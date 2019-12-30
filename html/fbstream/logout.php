<?php
session_start();
// unset($_SESSION['is_login']);
session_destroy();
header("Location: login.php");
?>