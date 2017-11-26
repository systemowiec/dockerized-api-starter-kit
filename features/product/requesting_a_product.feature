Feature: Requesting a Product

  @e2e
  Scenario: Successfully getting a product
    Given the unique identifier is "b3f5fdc3-3883-4068-a42c-467324361785"
    When I request a Product details
    Then the Product should contain the following data:
      | uuid                                 | name     | price  | currency | quantity |
      | b3f5fdc3-3883-4068-a42c-467324361785 | Ethereum | 700.00 | USD      | 100      |

  @e2e
  Scenario: Successfully creating a product
    When I request for a new Product creation based on the following details
      | name                              | price  | currency | weight | quantity |
      | BitCoin Gold Plated Physical Coin | 100.00 | PLN      | 0.1    | 10       |
    Then the Product should be created with a new unique identifier

  @e2e
  Scenario: Successfully getting a list of products
    When I request a Product list
    Then the the list of products should contain the following data:
      | uuid                                 | name                     | price   | currency | weight | quantity |
      | b3f5fdc3-3883-4068-a42c-467324361785 | Ethereum                 | 700.00  | USD      |        | 100      |
      | 1944db82-33d1-4855-90a3-618b31eb2715 | Monero                   | 200.00  | USD      |        | 1000     |
      | 7deceb16-a057-497e-acd4-c60937bb7771 | Bitcoin                  | 5000.00 | USD      |        | 7        |
      | 0d01b196-813d-43f1-8d52-7e9dde154fa6 | Lisk                     | 30.00   | USD      |        | 10000    |
      | 060ac223-ab7d-4ac9-a07f-5df1e3feb1a2 | Ripple                   | 2.00    | USD      |        | 500000   |
      | cb0f2751-4a69-476a-bdc8-38d7ada375d0 | Ethereum Developer Bible | 75.00   | PLN      | 0.50   | 5        |

  @e2e
  Scenario: Failing to getting a product details when requesting unrecognised Uuid
    Given the unique identifier is "q1w2e3r4-a1s2d3f4-z1x2c3v4"
    When I request a Product details
    Then I should be told that the product not found