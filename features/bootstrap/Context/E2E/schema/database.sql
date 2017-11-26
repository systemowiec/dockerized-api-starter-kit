DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `uuid` varchar(50) NOT NULL DEFAULT '',
  `name` varchar(30) NOT NULL DEFAULT '',
  `price` decimal(6,2) DEFAULT NULL,
  `currency` char(3) DEFAULT NULL,
  `weight` decimal(6,2) DEFAULT NULL,
  `quantity` int(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `products` (`uuid`, `name`, `price`, `currency`, `weight`, `quantity`)
VALUES
  ("b3f5fdc3-3883-4068-a42c-467324361785", "Ethereum", "700.00", "USD", NULL, "100"),
  ("1944db82-33d1-4855-90a3-618b31eb2715", "Monero", "200.00", "USD", NULL, "1000"),
  ("7deceb16-a057-497e-acd4-c60937bb7771", "Bitcoin", "5000.00", "USD", NULL, "7"),
  ("0d01b196-813d-43f1-8d52-7e9dde154fa6", "Lisk", "30.00", "USD", NULL, "10000"),
  ("060ac223-ab7d-4ac9-a07f-5df1e3feb1a2", "Ripple", "2.00", "USD", NULL, "500000"),
  ("cb0f2751-4a69-476a-bdc8-38d7ada375d0", "Ethereum Developer Bible", "75.00", "PLN", "0.5", "5");