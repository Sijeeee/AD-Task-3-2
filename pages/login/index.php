<?php
session_start();

require_once BASE_PATH . "/bootstrap.php";
require_once UTILS_PATH . "/auth.util.php";

if (Auth::check()) {
    header("Location: /dashboard.php");
    exit;
}

$error = $_SESSION['error'] ?? null;
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/pages/login/assets/css/login.css">
    <title>Login</title>
</head>
<body>
<div class="login-container">
    <h2>Welcome Back</h2>

    <form action="/handlers/auth.handler.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>

        <?php if ($error): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <button type="submit">Login</button>
    </form>
</div>
</body>
</html>
