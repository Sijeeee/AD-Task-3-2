<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();

// Manually override PG_HOST for local execution
if (php_sapi_name() === 'cli') {
    $_ENV['PG_HOST'] = 'localhost';
}

$pgConfig = [
    'host' => $_ENV['PG_HOST'],
    'port' => $_ENV['PG_PORT'],
    'user' => $_ENV['PG_USER'],
    'pass' => $_ENV['PG_PASS'],
    'dbname' => $_ENV['PG_DB']
];

?>