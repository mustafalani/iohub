<?php
include_once('includes/config.php');
session_start(); // Starting Session
$error=''; // Variable To Store Error Message


$stream_key= explode('/vidavovivo/delete_stream.php?id=',$_SERVER['REQUEST_URI']);
// echo $stream_key[1];exit;
	
$delete_query = "DELETE FROM stream WHERE `stream_key`='".$stream_key[1]."'";

$result = mysql_query($delete_query);

if ($result) {
	echo "success";exit;
} else {
	echo "failed";exit;
}


mysql_close($connection); // Closing Connection


?>