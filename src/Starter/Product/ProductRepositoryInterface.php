<?php

namespace Starter\Product;

/**
 * @author    Jarosław Stańczyk <jaroslaw@stanczyk.co.uk>
 * @copyright 2017 Jarosław Stańczyk. All rights reserved.
 */
interface ProductRepositoryInterface
{
    /**
     * @return Product[]
     */
    public function fetchAll(): array;

    /**
     * @param string $uuid
     *
     * @return Product
     */
    public function fetchByUuid(string $uuid): Product;

    /**
     * @param Product $product
     *
     * @return Product
     */
    public function store(Product $product): Product;
}
