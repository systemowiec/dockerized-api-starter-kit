<?php

namespace Starter\Product;

use Money\Money;
use Ramsey\Uuid\UuidInterface;

/**
 * @author    Jarosław Stańczyk <jaroslaw@stanczyk.co.uk>
 * @copyright 2017 Jarosław Stańczyk. All rights reserved.
 */
interface Product
{
    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return Money
     */
    public function getPrice(): Money;

    /**
     * @return int
     */
    public function getQuantity(): int;
}
