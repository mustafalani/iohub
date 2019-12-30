<?php
//--------------------CONFIGARATION FILE---------------------//
//---------------mysql configaration start-------------//
define("DBNAME","fbstream");
define("DBSERVER","localhost");
define("DBUSER","root");
define("DBPASS","dbedit");

$mysqlhandle=mysqli_connect(DBSERVER,DBUSER,DBPASS);
if(!$mysqlhandle){
	die(mysql_errno()." : ".mysql_error());
}
$dbhandle=mysqli_select_db($mysqlhandle,DBNAME);
if(!$dbhandle){
	die(mysql_errno()." : ".mysql_error());
}
?>
