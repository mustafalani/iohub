<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include_once('../fbstream/includes/config.php');
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
if (empty($_POST['email']) || empty($_POST['password'])) {
$error = "email or Password is invalid";
}
else
{
$email=$_POST['email'];
$password=$_POST['password'];

$email = stripslashes($email);
$password = stripslashes($password);

//$email = mysql_real_escape_string($email);
//$password = mysql_real_escape_string($password);

// Selecting User
$chSQL = "SELECT * FROM `users` WHERE `email`='".$email."' AND `password`='".$password."'";
$chResult = mysqli_query($mysqlhandle,$chSQL);
$rows = mysqli_num_rows($chResult);
if ($rows == 1) {
$_SESSION['login_user_email'] = $email; // Initializing Session

$get_user_detail = "SELECT * FROM `users` WHERE `email`='".$email."' AND `password`='".$password."'";
$user_result = mysqli_query($mysqlhandle,$get_user_detail);
$user = mysqli_fetch_array($user_result);
$_SESSION['login_user_id'] = $user['id'];
$_SESSION['user_role'] = $user['user_role'];
$_SESSION['user_name'] = $user['user_name'];
$_SESSION['title'] = $user['title'];
$_SESSION['description'] = $user['description'];
$_SESSION['app_name'] = $user['app_name'];

if($user['user_role'] == 'admin'){
	header("location: admin.php"); // Redirecting To Other Page
} else {
	header("location: view_stream.php"); // Redirecting To Other Page
}

} else {
header("location: login_error.php");
}
mysql_close($connection); // Closing Connection
}
}
?>