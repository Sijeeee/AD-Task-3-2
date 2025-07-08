<?php
require_once "bootstrap.php";
require_once UTILS_PATH . "/auth.util.php";
if (!Auth::check()) {
    header("Location: /pages/login/index.php");
    exit;
}
?>
<html>
<body>

</body>
</html>
