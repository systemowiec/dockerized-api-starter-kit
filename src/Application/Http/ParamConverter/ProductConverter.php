<?php

namespace Application\Http\ParamConverter;

use Application\Http\Exception\MissingArgument;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Starter\Product\Product;
use Starter\Product\ProductFactory;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author    Jarosław Stańczyk <jaroslaw@stanczyk.co.uk>
 * @copyright 2017 Jarosław Stańczyk. All rights reserved.
 */
class ProductConverter implements ParamConverterInterface
{
    /**
     * @var ProductFactory
     */
    private $productFactory;

    /**
     * @param ProductFactory $productFactory
     */
    public function __construct(ProductFactory $productFactory)
    {
        $this->productFactory = $productFactory;
    }

    /**
     * Stores the object in the request.
     *
     * @param Request        $request       The request
     * @param ParamConverter $configuration Contains the name, class and options of the object
     *
     * @return bool True if the object has been successfully set, else false
     * @throws MissingArgument
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        $content = json_decode($request->getContent());

        $product = $this->productFactory->make(
            $content->uuid,
            $content->name,
            $content->price,
            $content->currency,
            $content->weight,
            $content->quantity
        );

        $request->attributes->set($configuration->getName(), $product);
    }

    /**
     * Checks if the object is supported.
     *
     * @param ParamConverter $configuration Should be an instance of ParamConverter
     *
     * @return bool True if the object is supported, else false
     */
    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() === Product::class && $configuration->getName() === 'product';
    }
}
