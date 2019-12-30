<?php
session_start();
unset($_SESSION['is_login']);
$requiredSessionVar = array('user_role','login_user_id','login_user_email','title','description','app_name','user_name');
foreach($_SESSION as $key => $value) {
    if(!in_array($key, $requiredSessionVar)) {
        unset($_SESSION[$key]);
    }
}
header("Location: ../add_stream.php");
?>