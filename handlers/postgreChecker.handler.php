<?php
require_once UTILS_PATH . '/envSetter.util.php';

$host = $typeConfig['pg_host'];
$port = $typeConfig['pg_port'];
$username = $typeConfig['pg_user'];
$password = $typeConfig['pg_pass'];
$dbname = $typeConfig['pg_db'];

$conn_string = "host={$typeConfig['pg_host']} port={$typeConfig['pg_port']} dbname={$typeConfig['pg_db']} user={$typeConfig['pg_user']} password={$typeConfig['pg_pass']}";

$dbconn = pg_connect($conn_string);

if (!$dbconn) {
    echo "❌ Connection Failed: ", pg_last_error() . "  <br>";
    exit();
} else {
    echo "✔️ PostgreSQL Connection  <br>";
    pg_close($dbconn);
}