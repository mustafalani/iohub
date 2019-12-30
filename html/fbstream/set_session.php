<?php
include_once('includes/config.php');
session_start(); // Starting Session

$_SESSION['stream_target'] = $_POST['stream_target'];
$_SESSION['stream_source'] = $_POST['stream_source'];
$_SESSION['stream_title'] = $_POST['stream_title'];
$_SESSION['stream_description'] = $_POST['stream_description'];

echo "success";
?>