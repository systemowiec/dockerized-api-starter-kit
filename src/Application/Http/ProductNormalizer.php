<?php

namespace Application\Http;

use Starter\Product\Product;
use Starter\Product\VirtualProduct;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ProductNormalizer implements NormalizerInterface
{
    /**
     * {@inheritdoc}
     */
    public function normalize($product, $format = null, array $context = [])
    {
        if (is_array($product)) {
            return $this->normalizeMultiple($product);
        }

        return $this->normalizeSingle($product);
    }

    /**
     * @param Product[] $products
     *
     * @return array
     */
    private function normalizeMultiple(array $products): array
    {
        $normalizedProducts = [];

        foreach ($products as $product) {
            $weight = ($product instanceof VirtualProduct)
                ? null
                : $product->getWeight();

            $normalizedProducts[] = [
                'uuid' => $product->getUuid(),
                'name' => $product->getName(),
                'price' => $product->getPrice()->getAmount(),
                'currency' => $product->getPrice()->getCurrency(),
                'quantity' => $product->getQuantity(),
                'weight' => $weight,
            ];
        }

        return $normalizedProducts;
    }

    /**
     * @param Product $product
     *
     * @return array
     */
    private function normalizeSingle(Product $product): array
    {
        $weight = $product instanceof VirtualProduct
            ? null
            : $product->getWeight();

        return [
            'uuid' => $product->getUuid(),
            'name' => $product->getName(),
            'price' => $product->getPrice()->getAmount(),
            'currency' => $product->getPrice()->getCurrency(),
            'quantity' => $product->getQuantity(),
            'weight' => $weight,
        ];
    }

    /**
     * Checks whether the given class is supported for normalization by this normalizer.
     *
     * @param mixed  $data   Data to normalize
     * @param string $format The format being (de-)serialized from or into
     *
     * @return bool
     */
    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Product;
    }
}
