<?php

namespace Context\E2E;

use Behat\Behat\Context\Context;
use Doctrine\Common\Annotations\AnnotationRegistry;
use PDO;

/**
 * @author    Jarosław Stańczyk <jaroslaw@stanczyk.co.uk>
 * @copyright 2017 Jarosław Stańczyk. All rights reserved.
 */
class FeatureContext implements Context
{
    /**
     * @var \PDO
     */
    private static $databaseConnection;

    /**
     * @param \PDO $databaseConnection
     */
    public function __construct(PDO $databaseConnection)
    {
        static::$databaseConnection = $databaseConnection;

        /** @var \Composer\Autoload\ClassLoader $loader */
        $loader = require 'vendor/autoload.php';

        AnnotationRegistry::registerLoader([$loader, 'loadClass']);
    }

    /**
     * @BeforeScenario
     */
    public static function setup()
    {
        self::setupDatabase();
    }

    private static function setupDatabase()
    {
        $schema = file_get_contents('features/bootstrap/Context/E2E/schema/database.sql');

        static::$databaseConnection->exec($schema);
    }
}
