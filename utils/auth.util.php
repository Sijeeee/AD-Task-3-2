<?php

require_once UTILS_PATH . '/envSetter.util.php';

class Auth
{
    private static function connect()
    {
        try {
            $dsn = "pgsql:host=" . $_ENV['PG_HOST'] . ";port=" . $_ENV['PG_PORT'] . ";dbname=" . $_ENV['PG_DB'];
            return new PDO($dsn, $_ENV['PG_USER'], $_ENV['PG_PASS'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ]);
        } catch (PDOException $e) {
            return null;
        }
    }

    public static function init()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function login(string $username, string $password)
    {
        self::init();
        $pdo = self::connect();

        if (!$pdo) return ['status' => false, 'message' => 'Database connection failed'];

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return ['status' => false, 'message' => 'User not found'];
        }

        if (!password_verify($password, $user['password'])) {
            return ['status' => false, 'message' => 'Invalid password'];
        }

        $_SESSION['user'] = [
            'id' => $user['id'],
            'username' => $user['username'],
            'role' => $user['role'],
        ];

        return ['status' => true, 'message' => 'Login successful'];
    }

    public static function user()
    {
        self::init();
        return $_SESSION['user'] ?? null;
    }

    public static function check()
    {
        self::init();
        return isset($_SESSION['user']);
    }

public static function logout()
    {
        self::init();

        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
    }
}
