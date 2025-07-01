<?php
declare(strict_types=1);

// 1) Composer autoload
require 'vendor/autoload.php';

// 2) Composer bootstrap
require 'bootstrap.php';

// 3) envSetter
require_once UTILS_PATH . '/envSetter.util.php';

$users = require_once DUMMIES_PATH . '/users.staticData.php';

// ——— Connect to PostgreSQL ———
$dsn = "pgsql:host={$pgConfig['host']};port={$pgConfig['port']};dbname={$pgConfig['dbname']}";
$pdo = new PDO($dsn, $pgConfig['user'], $pgConfig['pass'], [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
]);

// Just indicator it was working
echo "Applying schema from database/users.model.sql…\n";

$sql = file_get_contents('database/users.model.sql');

// Another indicator but for failed creation
if ($sql === false) {
  throw new RuntimeException("Could not read database/users.model.sql");
} else {
    echo "Creation Success from the database/users.model.sql";
}

// If your model.sql contains a working command it will be executed
$pdo->exec($sql);

echo "Truncating tables…\n";
foreach (['users'] as $table) {
  $pdo->exec("TRUNCATE TABLE {$table} RESTART IDENTITY CASCADE;");
}

echo "Seeding users…\n";

$stmt = $pdo->prepare("
    INSERT INTO users (username, role, first_name, last_name, password)
    VALUES (:username, :role, :fn, :ln, :pw)
");

foreach ($users as $u) {
  $stmt->execute([
    ':username' => $u['username'],
    ':role' => $u['role'],
    ':fn' => $u['first_name'],
    ':ln' => $u['last_name'],
    ':pw' => password_hash($u['password'], PASSWORD_DEFAULT),
  ]);
}

$stmt = $pdo->query("SELECT * FROM users");

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    echo "---------------------------\n";
    echo "User ID: " . $user['id'] . "\n";
    echo "Username: " . $user['username'] . "\n";
    echo "First Name: " . $user['first_name'] . "\n";
    echo "Last Name: " . $user['last_name'] . "\n";
    echo "Role: " . $user['role'] . "\n";
    echo "---------------------------\n";
}
?>