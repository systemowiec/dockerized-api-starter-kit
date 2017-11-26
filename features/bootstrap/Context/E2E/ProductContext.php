<?php

namespace Context\E2E;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use PDO;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Kernel;

/**
 * @author    Jarosław Stańczyk <jaroslaw@stanczyk.co.uk>
 * @copyright 2017 Jarosław Stańczyk. All rights reserved.
 */
class ProductContext implements Context
{
    /**
     * @var \PDO
     */
    private $databaseConnection;

    /**
     * @var Kernel
     */
    private $kernel;

    /**
     * @var int Response code returned by last app request
     */
    private $responseCode;

    /**
     * @var string Response body returned by last app request
     */
    private $response;

    /**
     * @var string Unique Identifier
     */
    private $uuid;

    /**
     * @param \PDO   $databaseConnection
     * @param Kernel $kernel
     */
    public function __construct(PDO $databaseConnection, Kernel $kernel)
    {
        $this->databaseConnection = $databaseConnection;
        $this->kernel = $kernel;
    }

    /**
     * @Given the unique identifier is :uuid
     *
     * @param $uuid
     */
    public function theUniqueIdentifierIs($uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @When I request a Product details
     */
    public function iRequestAProductDetails()
    {
        $request = Request::create("/product/{$this->uuid}", Request::METHOD_GET);

        $this->makeRequest($request);
    }

    /**
     * @Then the Product should contain the following data:
     *
     * @param TableNode $product
     */
    public function theProductShouldContainTheFollowingData(TableNode $product)
    {
        $expectedProduct = $product->getColumnsHash()[0];

        Assert::assertEquals(
            $this->uuid,
            $this->response->uuid,
            'uuid not match'
        );

        $this->assertProductBasis($expectedProduct, $this->response);
    }

    /**
     * @When I request for a new Product creation based on the following details
     *
     * @param TableNode $productRequest
     */
    public function iRequestForANewProductCreationBasedOnTheFollowingDetails(TableNode $productRequest)
    {
        $product = $productRequest->getColumnsHash()[0];

        $request = [
            'name' => $product['name'],
            'price' => $product['price'],
            'currency' => $product['currency'],
            'weight' => $product['weight'],
            'quantity' => $product['quantity'],
        ];

        $request = Request::create('/product/create', Request::METHOD_POST, [], [], [], [], json_encode($request));

        $this->makeRequest($request);
    }

    /**
     * @Then the Product should be created with a new unique identifier
     */
    public function theProductShouldBeCreatedWithANewUniqueIdentifier()
    {
        Assert::assertTrue(
            !empty($this->response->uuid),
            "uuid is empty"
        );
    }

    /**
     * @When I request a Product list
     */
    public function iRequestAProductList()
    {
        $request = Request::create("/products/", Request::METHOD_GET);

        $this->makeRequest($request);
    }

    /**
     * @Then the the list of products should contain the following data:
     *
     * @param TableNode $products
     */
    public function theTheListOfProductsShouldContainTheFollowingData(TableNode $products)
    {
        $expectedProducts = $products->getColumnsHash();

        foreach ($expectedProducts as $index => $product) {
            Assert::assertEquals(
                $product['uuid'],
                $this->response[$index]->uuid,
                "uuid not match"
            );

            $this->assertProductBasis($product, $this->response[$index]);
        }
    }

    /**
     * @Then I should be told that the product not found
     */
    public function iShouldBeToldThatTheProductNotFound()
    {
        Assert::assertEquals(
            "Product {$this->uuid} not found",
            $this->response->message,
            "exception message not match"
        );
    }

    /**
     * @param Request $request
     */
    private function makeRequest(Request $request)
    {
        $response = $this->kernel->handle($request);

        $this->responseCode = $response->getStatusCode();
        $this->response = json_decode($response->getContent());

        if (json_last_error()) {
            throw new \RuntimeException("Could not decode JSON response - " . json_last_error());
        }
    }

    /**
     * @param $expectedProduct
     * @param $response
     */
    private function assertProductBasis($expectedProduct, $response)
    {
        Assert::assertEquals(
            $expectedProduct['name'],
            $response->name,
            "name not match"
        );

        Assert::assertEquals(
            $expectedProduct['price'],
            $response->price,
            "price not match"
        );

        Assert::assertEquals(
            $expectedProduct['currency'],
            $response->currency,
            "currency not match"
        );

        Assert::assertEquals(
            $expectedProduct['weight'],
            $response->weight,
            "weight not match"
        );

        Assert::assertEquals(
            $expectedProduct['quantity'],
            $response->quantity,
            "quantity not match"
        );
    }
}
