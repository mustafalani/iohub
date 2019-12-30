<!DOCTYPE html>
<?php
session_start();
if (isset($_SESSION['login_user_id']) || ($_SESSION['login_user_id'] != '')) {
	if(($_SESSION['user_role'] == 'admin')){
		header("location: admin.php");
	} else {
		header("location: view_stream.php");
	}
    
} else { }
?>
<html>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<head>
<title>Form</title>

<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css">

<link rel="stylesheet" type="text/css" href="css/style.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

</head>
<body>

<div class="container">
	<div class="row">
		
		<div class="form-bootsa">
		<div class="logo">
			<img src="images/logo.png" >
		</div>
			<h1 style="text-align">Login Area</h1>
			<form class="form-inline" method="POST" action="login_process.php">
			  
			  <div class="end-btns">
			  	 <ul>
			  	 	<li><button type="button" data-toggle="modal" data-target="#login-user" class="btn btn-success pull-left all-btn"> Login</button></li>
			  	 	<li><button type="button" data-toggle="modal" data-target="#add_user" class="btn btn-primary fa fa-plus all-btn pull-right"> Register</button></li>
         					 
				 </ul><br><br>
				<a href="http://pacific1055.us.unmetered.com/vidavovivo/trems.php">Terms & Conditions</a>&nbsp;&nbsp;&nbsp;
				<a href="http://pacific1055.us.unmetered.com/vidavovivo/trems.php">Policy Privancy</a>
			  </div>
		

			</form>
	
		</div>
	</div>
</div>
<!-- Add New User Modal -->
<div id="add_user" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Register</h4>
			</div>
			<form class="form-inline" method="POST" id="signup_form">
				<div class="modal-body">
					<div class="form-group">
						<label for="exampleInputAmount">Email</label>
						<br>
						<div class="input-group">
							<i class="fa fa-envelope" aria-hidden="true"></i>
							<input required type="email" name="email" class="form-control" id="email" placeholder="Enter Email">
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputAmount">Username</label>
						<br>
						<div class="input-group">
							<i class="fa fa-user" aria-hidden="true"></i>
							<input required type="text" name="user_name" class="form-control" id="user_name" placeholder="Enter username">
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputAmount">Password</label>
						<br>
						<div class="input-group">
							<i class="fa fa-unlock-alt" aria-hidden="true"></i>
							<input required type="password" name="password" class="form-control" id="password" placeholder="Input">
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputAmount">Title</label>
						<br>
						<div class="input-group">
							<i class="fa fa-font-awesome" aria-hidden="true"></i>
							<input required type="text" name="title" class="form-control" id="title" placeholder="Enter Title">
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputAmount">Description</label>
						<br>
						<div class="input-group">
							<i class="fa fa-wpforms" aria-hidden="true"></i>
							<input required type="text" name="description" class="form-control" id="description" placeholder="Enter Description">
						</div>
					</div>
					<?php $current_date_time = date('Y-m-d H:i:s'); $converted_date = strtotime($current_date_time)*1000; ?>
					<input required type="hidden" name="date_time" class="form-control" id="date_time" value="<?php echo $converted_date ?>">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default all-btn" data-dismiss="modal">Close</button>
					<input type="submit" name="submit" value="Register" class="btn btn-success finish">
				</div>
			</form>
		</div>
	</div>
</div>

<!-- login User Modal -->
<div id="login-user" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Login</h4>
			</div>
			<form class="form-inline" method="POST" action="login_process.php">
			<div class="modal-body">
				<div class="form-group">
				    <label for="exampleInputAmount">Enter Email</label>
				    <br>
				    <div class="input-group">
				      	<i class="fa fa-user" aria-hidden="true"></i>
				      	<input type="email" name="email" class="form-control" id="exampleInputAmount" placeholder="Please Enter Your Email!">
				    </div>
				</div>
				<div class="form-group">
					   <label for="exampleInputAmount">Enter Password</label>
				    <br>
				    <div class="input-group">
				      	<i class="fa fa-key" aria-hidden="true"></i>
				      	<input type="password" class="form-control" id="exampleInputAmount" placeholder="Input" name="password">
				    </div>
				</div>
			</div>
				<div class="modal-footer">
					<input type="submit" data-toggle="modal" data-target="#login-user"  class="btn btn-success pull-left all-btn" value="Sign In" name="submit">
					<!--button type="button" class="btn btn-default all-btn" data-dismiss="modal">Close</button>
					<input type="submit" name="submit" value="Add User" class="btn btn-success finish"-->
				</div>
			</form>
		</div>
	</div>
</div>


<!-- ************* -->
</body>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
<script>
$( "#signup_form" ).submit(function( event ) {
	var email = $('#email').val();
	var user_name = $('#user_name').val();
	var password = $('#password').val();
	var title = $('#title').val();
	var description = $('#description').val();
	var date_time = $('#date_time').val();
	
	var app_name = user_name+date_time;
	
	var data = {"app_name":app_name};
	var data2 = {"email" : email, "user_name" : user_name, "password" : password, "title" : title, "description" : description, "app_name":app_name};
	$.ajax({
		type: "POST",
        data :JSON.stringify(data),
        url: "http://199.189.86.19:8182/api/v1/createApp",
        contentType: "application/json",
		success : function(data){
			if(data.status == 'success'){
				
				$.ajax({
					url: "add_new_user.php",
					type : 'POST',
					data : data2,
					success : function(response){
						if(response == 'success'){
							window.location.href = 'view_stream.php?status=success';
						} else {
							alert('Something went wrong! Please Try Again');
						}
						
						
					}
				});
			} else {
				alert('App couldnot Be Created!');
			}
		}
		
	});
	
	
  event.preventDefault();
});
</script>
</html>