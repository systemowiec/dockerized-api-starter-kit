<?php

namespace Application\Persistence\Exception;

/**
 * @author    Jarosław Stańczyk <jaroslaw@stanczyk.co.uk>
 * @copyright 2017 Jarosław Stańczyk. All rights reserved.
 */
class ProductNotFound extends \InvalidArgumentException
{
    const CODE = 404;
    const MESSAGE = "Product %s not found";

    /**
     * @param string $uuid
     */
    public function __construct($uuid)
    {
        $message = sprintf(static::MESSAGE, $uuid);
        parent::__construct($message, static::CODE);
    }
}
