<?php

namespace Application\Http\Controller;

use Application\Persistence\Database\ProductRepository;
use Starter\Product\Product;

/**
 * @author    Jarosław Stańczyk <jaroslaw@stanczyk.co.uk>
 * @copyright 2017 Jarosław Stańczyk. All rights reserved.
 */
class ProductController
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @param ProductRepository $productRepository
     */
    function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @return Product[]
     */
    public function indexAction(): array
    {
        return $this->productRepository->fetchAll();
    }

    /**
     * @param string $uuid
     *
     * @return Product
     */
    public function getAction(string $uuid): Product
    {
        return $this->productRepository->fetchByUuid($uuid);
    }

    /**
     * @param Product $product
     *
     * @return Product
     */
    public function createAction(Product $product): Product
    {
        return $this->productRepository->store($product);
    }
}
