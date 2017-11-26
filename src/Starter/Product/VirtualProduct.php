<?php

namespace Starter\Product;

use Money\Money;
use Ramsey\Uuid\UuidInterface;

/**
 * @author    Jarosław Stańczyk <jaroslaw@stanczyk.co.uk>
 * @copyright 2017 Jarosław Stańczyk. All rights reserved.
 */
class VirtualProduct implements Product
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    /**
     * @var string
     */
    private $name;

    /**
     * @var Money
     */
    private $price;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @param UuidInterface $uuid
     * @param string        $name
     * @param Money         $price
     * @param int           $quantity
     */
    public function __construct(UuidInterface $uuid, string $name, Money $price, int $quantity)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    /**
     * @return UuidInterface
     */
    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Money
     */
    public function getPrice(): Money
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
