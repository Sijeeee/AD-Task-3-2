<?php
session_start();
require_once BASE_PATH . "/bootstrap.php";
require_once UTILS_PATH . "/auth.util.php";

Auth::init();
$user = Auth::user();

if (!$user) {
    header("Location: /pages/login/index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eef2f3;
            padding: 40px;
        }
        .dashboard {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: auto;
        }
        .dashboard h1 {
            margin-bottom: 10px;
        }
        .dashboard p {
            font-size: 18px;
        }
        .logout {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background: crimson;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout:hover {
            background: darkred;
        }
    </style>
</head>
<body>
<div class="dashboard">
    <h1>Welcome, <?= htmlspecialchars($user['username']) ?>!</h1>
    <p>Your role is: <strong><?= htmlspecialchars($user['role']) ?></strong></p>

    <a href="/handlers/auth.handler.php?action=logout" class="logout">Logout</a>
</div>
</body>
</html>
