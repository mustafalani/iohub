<?php
include_once('includes/config.php');
session_start();

$stream_id = $_POST['stream_id'];
$st_target = $_POST['st_target'];
$str_src_name = $_POST['st_src_name'];


$query = "UPDATE stream SET st_target='".$st_target."' , str_src_name='".$str_src_name."' WHERE id='".$stream_id."'";
$update = mysql_query($query);

if ($update) {
	header("location: view_stream.php"); 
} else {
	echo "failed";exit;
}
mysql_close($connection);


?>