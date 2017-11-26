<?php

namespace Starter\Product;

use Money\Money;
use Ramsey\Uuid\UuidInterface;

/**
 * @author    Jarosław Stańczyk <jaroslaw@stanczyk.co.uk>
 * @copyright 2017 Jarosław Stańczyk. All rights reserved.
 */
class PhysicalProduct implements Product
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
     * @var
     */
    private $weight;

    /**
     * @var int
     */
    private $quantity;

    /**
     * @param UuidInterface $uuid
     * @param string        $name
     * @param Money         $price
     * @param float         $weight
     * @param int           $quantity
     */
    public function __construct(UuidInterface $uuid, string $name, Money $price, float $weight, int $quantity)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->weight = $weight;
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

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }
}
