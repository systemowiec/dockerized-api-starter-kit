<?php

namespace Application\Persistence\Database;

use Application\Persistence\Exception\ProductNotFound;
use Starter\Product\Product;
use Starter\Product\ProductFactory;
use Starter\Product\ProductRepositoryInterface;

/**
 * @author    Jarosław Stańczyk <jaroslaw@stanczyk.co.uk>
 * @copyright 2017 Jarosław Stańczyk. All rights reserved.
 */
class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var ProductFactory
     */
    private $productFactory;

    /**
     * @param \PDO           $pdo
     * @param ProductFactory $productFactory
     */
    public function __construct(\PDO $pdo, ProductFactory $productFactory)
    {

        $this->pdo = $pdo;
        $this->productFactory = $productFactory;
    }

    /**
     * @return array
     */
    public function fetchAll(): array
    {
        $query = $this->pdo->prepare(
            '
            SELECT uuid, name, price, currency, quantity, weight
            FROM products
            '
        );

        $query->execute();
        $products = $query->fetchAll(\PDO::FETCH_ASSOC);

        $productCollection = [];
        foreach ($products as $product) {
            $productCollection[] = $this->productFactory->make(
                $product['uuid'],
                $product['name'],
                $product['price'],
                $product['currency'],
                $product['weight'],
                $product['quantity']
            );
        }

        return $productCollection;
    }

    /**
     * @param string $uuid
     *
     * @return Product
     */
    public function fetchByUuid(string $uuid): Product
    {
        $query = $this->pdo->prepare(
            '
            SELECT uuid, name, price, currency, quantity, weight
            FROM products
            WHERE uuid = :uuid
            '
        );

        $query->bindValue(':uuid', $uuid);

        $query->execute();
        $product = $query->fetch(\PDO::FETCH_ASSOC);

        if (false === $product) {
            throw new ProductNotFound($uuid);
        }

        return $this->productFactory->make(
            $product['uuid'],
            $product['name'],
            $product['price'],
            $product['currency'],
            $product['weight'],
            $product['quantity']
        );
    }

    /**
     * @param Product $product
     *
     * @return Product
     */
    public function store(Product $product): Product
    {
        $query = $this->pdo->prepare(
            '
            INSERT INTO products SET
            uuid = :uuid, 
            name = :name, 
            price = :price,
            currency = :currency,
            quantity = :quantity, 
            weight = :weight
            '
        );

        $query->bindValue(':uuid', $product->getUuid()->toString());
        $query->bindValue(':name', $product->getName());
        $query->bindValue(':price', $product->getPrice()->getAmount());
        $query->bindValue(':currency', $product->getPrice()->getCurrency());
        $query->bindValue(':quantity', $product->getQuantity());

        $weight = ($product instanceof VirtualProduct)
            ? null
            : $product->getWeight;
        $query->bindValue(':weight', $weight);

        $query->execute(); // todo: catch pdo exception

        return $product;
    }
}
