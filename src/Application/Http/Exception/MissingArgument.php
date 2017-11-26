<?php

namespace Application\Http\Exception;

/**
 * @author    Jarosław Stańczyk <jaroslaw@stanczyk.co.uk>
 * @copyright 2017 Jarosław Stańczyk. All rights reserved.
 */
class MissingArgument extends \InvalidArgumentException
{
    const CODE = 400;
    const MESSAGE = "Field %s is required";

    /**
     * @param string $field
     */
    public function __construct(string $field)
    {
        $message = sprintf(static::MESSAGE, $field);
        parent::__construct($message, static::CODE);
    }
}
