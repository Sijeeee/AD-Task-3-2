<?php

require_once UTILS_PATH . '/auth.util.php';

Auth::init();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $result = Auth::login($username, $password);

    if ($result['status']) {
        header('Location: /pages/dashboard/index.php'); // Adjust the path as needed
        exit;
    } else {
        $_SESSION['error'] = $result['message'];
        header('Location: /login.php');
        exit;
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    Auth::logout();
    header('Location: /login.php');
    exit;
}
