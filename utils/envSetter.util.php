<?php
require_once BASE_PATH . '/bootstrap.php';
require_once BASE_PATH . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(BASE_PATH);
$dotenv->load();


// Manually override PG_HOST for local execution
if (php_sapi_name() === 'cli') {
    $_ENV['PG_HOST'] = 'localhost';
}


global $typeConfig;
$typeConfig = [
    'env'       => $_ENV['ENV_NAME'] ?? 'unknown',
    'pg_host'   => $_ENV['PG_HOST'] ?? 'missing',
    'pg_port'   => $_ENV['PG_PORT'] ?? '5112',
    'pg_db'     => $_ENV['PG_DB'] ?? 'missing',
    'pg_user'   => $_ENV['PG_USER'] ?? 'missing',
    'pg_pass'   => $_ENV['PG_PASS'] ?? 'missing',
    'mongo_uri' => $_ENV['MONGO_URI'] ?? 'missing',
    'mongo_db'  => $_ENV['MONGO_DB'] ?? 'missing',
];

$pgConfig = [
     'host' => $_ENV['PG_HOST'],
     'port' => $_ENV['PG_PORT'],
     'user' => $_ENV['PG_USER'],
     'pass' => $_ENV['PG_PASS'],
     'dbname' => $_ENV['PG_DB']
 ];

?>