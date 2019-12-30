<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<?php
include_once('includes/config.php');
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) {
if (empty($_POST['email']) || empty($_POST['password'])) {
$error = "email or Password is invalid";
}
else
{
$user_id=$_POST['user_id'];
$email=$_POST['email'];
$password=$_POST['password'];
$user_name = $_POST['user_name'];
$title = $_POST['title'];
$description = $_POST['description'];

$email = stripslashes($email);
$password = stripslashes($password);

$email = mysql_real_escape_string($email);
$password = mysql_real_escape_string($password);

// Selecting User
$query = "UPDATE users SET email='$email', user_name='$user_name', password='$password' , title='$title', description='$description' WHERE id='".$user_id."'";
$update = mysql_query($query);

if ($update) {
	header("Location: admin.php");
} else {
	echo "failed";exit;
}
mysql_close($connection); // Closing Connection
}
}
?>