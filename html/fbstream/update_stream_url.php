<?php
// echo "here";exit;
include_once('includes/config.php');
session_start(); // Starting Session

$new_stream_url = $_POST['new_stream_url'];
$id = $_SESSION['stream_id'];
$query = "UPDATE stream SET new_stream_url='".$new_stream_url."' WHERE id='".$id."'";
$update = mysql_query($query);

if ($update) {
	echo "success";exit;
} else {
	echo "failed";exit;
}
mysql_close($connection);


?>