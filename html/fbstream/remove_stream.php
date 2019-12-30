<?php
include_once('includes/config.php');
session_start(); // Starting Session
$error=''; // Variable To Store Error Message


$id=$_GET['id'];
	
$delete_query = "DELETE FROM stream WHERE `id`='".$id."'";

$result = mysql_query($delete_query);

if ($result) {
	header("Location: view_stream.php");
} else {
	echo "failed";exit;
}


mysql_close($connection); // Closing Connection


?>