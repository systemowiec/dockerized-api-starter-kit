<?php

namespace Starter\Product;

use Money\Currency;
use Money\Money;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @author    Jarosław Stańczyk <jaroslaw@stanczyk.co.uk>
 * @copyright 2017 Jarosław Stańczyk. All rights reserved.
 */
class ProductFactory
{
    /**
     * @param UuidInterface|string $uuid
     * @param string               $name
     * @param float|Money          $price
     * @param string               $currency
     * @param float|null           $weight
     * @param int                  $quantity
     *
     * @return Product
     */
    public function make(
        $uuid,
        string $name,
        float $price,
        string $currency,
        float $weight = null,
        int $quantity
    ): Product {

        $uuid = (empty($uuid))
            ? Uuid::uuid4()
            : $uuid;

        if (is_null($weight)) {
            return new VirtualProduct(
                Uuid::fromString($uuid),
                $name,
                new Money(
                    $price,
                    new Currency($currency)
                ),
                $quantity
            );
        }

        return new PhysicalProduct(
            Uuid::fromString($uuid),
            $name,
            new Money(
                $price,
                new Currency($currency)
            ),
            $weight,
            $quantity
        );
    }
}
