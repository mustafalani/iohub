<?php
$current_date_time = date('Y-m-d H:i:s').' ';
$converted_date = strtotime($current_date_time)*1000;

include_once('includes/config.php');
session_start(); 
$email=$_POST['email'];
$password=$_POST['password'];
$user_name = $_POST['user_name'];
$title = $_POST['title'];
$description = $_POST['description'];
$app_name = $_POST['app_name'];

$email = stripslashes($email);
$password = stripslashes($password);

$email = mysql_real_escape_string($email);
$password = mysql_real_escape_string($password);

// Selecting User
$chSQL = "SELECT * FROM `users` WHERE `email`='".$email."'";
$chResult = mysql_query($chSQL);
$rows = mysql_num_rows($chResult);
if ($rows == 1) {
echo "Email Already Exists!";exit;
} else {
	
$createSQL = "INSERT INTO `users` (`user_name`, `email`, `password`,`title`, `description`, `app_name`) VALUES ('".$user_name."','".$email."','".$password."','".$title."','".$description."','".$app_name."')";
$createSuccess = mysql_query($createSQL);

if ($createSuccess) {
	$get_user_detail = "SELECT * FROM `users` WHERE `email`='".$email."' AND `password`='".$password."'";
	$user_result = mysql_query($get_user_detail);
	$user = mysql_fetch_array($user_result);
	$_SESSION['login_user_id'] = $user['id'];
	$_SESSION['user_role'] = $user['user_role'];
	$_SESSION['login_user_email'] = $email;
	$_SESSION['title'] = $user['title'];
	$_SESSION['description'] = $user['description'];
	$_SESSION['app_name'] = $user['app_name'];
	$_SESSION['user_name'] = $user['user_name'];

	echo "success";exit;
} else {
	echo "failed";exit;
	// header("Location: login.php");
	
}

}
mysql_close($connection); // Closing Connection
?>