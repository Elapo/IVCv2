<?php
/**
 * Created by PhpStorm.
 * User: FVHBB94
 * Date: 22/12/2016
 * Time: 14:12
 */
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/src/domain"), $isDevMode);

// database configuration parameters
$conn = array(
    'driver'   => 'pdo_mysql',
    'user'     => 'root',
    'password' => '',
    'dbname'   => 'IVC-v2',
);

// obtaining the entity manager
$entityManager = EntityManager::create($conn, $config);