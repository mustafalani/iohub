<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
session_start();

if(!$_SESSION['login_user_id']){
	
header('location:login.php');
		}
?>

<!DOCTYPE html>

<html>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<head>
<title>Form</title>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

<style type="text/css">

.form-bootsa {
    width: 760px;
    margin: 5% auto;
    border: 1px solid #ccc;
    padding: 20px;
    border-radius: 10px;
}

.form-bootsa h1 {
    margin: 0;
}

.form-group {
    display: block!important;
    margin: 5% 0;
}

.input-group {
    width: 100%;
}

.input-group input{
    width: 100%;
}

.end-btns {
    padding: 5% 0;
}

.end-btns ul {
    padding: 0;
    margin: 0;
}

.end-btns ul li {
    list-style: none;
    display: block;
}

.back{
	float: left;
}

.finish{
	float: right;
}

.logo {
    text-align: center;
    margin-top: 50px;
}
.logo img {
    width: 180px;
    text-align: center;
}

.fb-login {
    margin: 10px 0;
}

.fb-login b {
    padding-bottom: 10px;
    display: block;
}

</style>
</head>
<body>

<div class="container">
	<div class="row">
		<div class="logo">
			<img src="images/logo.png" >
		</div>
		<div class="form-bootsa">
			<h1>Heading</h1>
			<form class="form-inline">
			  <div class="form-group">
			    <label for="exampleInputAmount">Stream Target Name</label>
			    <br>
			    <div class="input-group">
			      <div class="input-group-addon">I</div>
			      <input type="text" class="form-control" id="exampleInputAmount" placeholder="Input">
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="exampleInputAmount">Source Stream Name</label>
			    <br>
			    <div class="input-group">
			      <div class="input-group-addon">I</div>
			      <input type="text" class="form-control" id="exampleInputAmount" placeholder="Input">
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="exampleInputAmount">Title</label>
			    <br>
			    <div class="input-group">
			      <div class="input-group-addon">I</div>
			      <input type="text" class="form-control" id="exampleInputAmount" placeholder="Input">
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="exampleInputAmount">Description</label>
			    <br>
			    <div class="input-group">
			      <div class="input-group-addon">I</div>
			      <input type="text" class="form-control" id="exampleInputAmount" placeholder="Input">
			    </div>
			  </div>

			  <div class="fb-login">
			  	<b>Log in to Facebook to authorize as a Facebook Live Stream target.</b>
			  	<button class="btn btn-primary sfb-btn">
			  		<i class="fa fa-facebook-official" aria-hidden="true"></i>Facebook
			  	</button>
			  </div>

			  <div class="end-btns">
			  	 <ul>
			  	 	<li><a href="#"><button type="button" class="btn btn-default back">Back</button></a></li>
			  	 	<li><a href="#"><button type="button" class="btn btn-success finish">Finish</button></a></li>
			  	 </ul>
			  </div>

			</form>
		</div>
	</div>
</div>

</body>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">

</html>