<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['login_user_id']) || ($_SESSION['login_user_id'] == '') || ($_SESSION['user_role'] != 'admin')) {
    header("location: login.php");
}
include_once('includes/config.php');
session_start();

$query = "SELECT * FROM users WHERE user_role != 'admin'";
$result = mysql_query($query);
?>
<html>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<head>
<title>Form</title>

<link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css">

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

.end-btns2 {
    padding: 0 0 5% 0;
}

.end-btns2 ul {
    padding: 0;
    margin: 0;
}

.end-btns2 ul li {
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
    /* margin-top: 50px; */
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

.action-li{
	padding: 0;
	margin: 0;
}

.action-li li{
	display: inline-block;
	list-style: none;
}

.action-li li i {
	font-size: 20px;
    padding: 0 10px;
}

.add-stream{
	float: left;
	margin: 0 10px 0 0;
}

.enable-stream{

}

.fb-icon {
	font-size: 60px;
	color: #3176b2;
	vertical-align: middle;
    margin-right: 10px;
}

th {
    background: #f4f4f4;
}

.admin-btns {
	margin: 0 0 20px;
}

.del-check{
	float: right;
	display: none;
}

.admin-btns a {
    color: #fff;
}

.admin-btns a:hover {
    color: #fff;
    text-decoration: none;
}


.checkbox-custom {
  opacity: 0;
  position: absolute;
}

.checkbox-custom,
.checkbox-custom-label {
  display: inline-block;
  vertical-align: middle;
  margin: 5px;
  cursor: pointer;
}

.checkbox-custom-label {
  position: relative;
}

.checkbox-custom + .checkbox-custom-label:before {
  content: '';
  background: #fff;
  border: 2px solid #ddd;
  display: inline-block;
  vertical-align: middle;
  width: 20px;
  height: 20px;
  margin-right: 10px;
  text-align: center;
  line-height: 1;
}

/*Simply Change the content to any font awesome unicode here to add your own check icon*/
.checkbox-custom:checked + .checkbox-custom-label:before {
  content: "\f00c";
  font-family: 'FontAwesome';
  background: #fe4365;
  color: #fff;
  text-align: center;
  vertical-align: middle;
}

.checkbox-custom:focus + .checkbox-custom-label {
  outline: 1px solid #ddd;
  /* focus style */
}

</style>

<script>
$(document).ready(function(){
    $(".delet-user").click(function(){
        $(".del-check").toggle();
    });
});
</script>

</head>
<body>

<div class="container">
	<div class="row">
		<div class="form-bootsa">
			<div class="logo">
				<img src="images/logo.png" >
			</div>
			<div class="btn-group admin-btns" role="group" aria-label="...">
				<button type="button" data-toggle="modal" data-target="#add_user" class="btn btn-primary fa fa-plus ad-user">Add User</button>
				
			</div>
			<a type="button" style="" href="logout.php" class="btn btn-danger pull-right">Logout</a>
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Email</th>
						<th>User name</th>
						<th>Title</th>
						<th>Description</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php if($result){ 
						while ($row = mysql_fetch_assoc($result)) { ?>
							<tr>
								<td>
									<i class="fa fa-facebook-official fb-icon" aria-hidden="true"></i>
										<a href=""><?php echo $row['email']; ?></a>
								</td>
								<td><?php echo ucwords($row['user_name']); ?></td>
								<td><?php echo ucwords($row['title']); ?></td>
								<td><?php echo ucwords($row['description']); ?></td>
								<td>
									<ul class="action-li">
										<li><a href="javascript:;" data-toggle="modal" data-target="#update_user_<?php echo $row['id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></li>
										<li><a href="remove_user.php?id=<?php echo $row['id']; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a></li>
									</ul>
								</td>
							</tr>
							<!-- Update User Model -->
							<div id="update_user_<?php echo $row['id']; ?>" class="modal fade" role="dialog">
								<div class="modal-dialog">
									<div class="modal-content">
									
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Update User</h4>
										</div>
										<form class="" method="POST" action="update_user.php">
											<div class="modal-body">
												<div class="form-group">
													
													<input type="hidden" value="<?php echo $row['id']; ?>" name="user_id">
												
													<label for="exampleInputAmount">Email</label>
													<br>
													<div class="input-group">
														<div class="input-group-addon">I</div>
														<input required type="email" name="email" class="form-control" id="exampleInputAmount" value="<?php echo $row['email']; ?>" placeholder="Enter Email">
													</div>
												</div>
												<div class="form-group">
													<label for="exampleInputAmount">Username</label>
													<br>
													<div class="input-group">
														<div class="input-group-addon">I</div>
														<input required value="<?php echo $row['user_name']; ?>" type="text" name="user_name" class="form-control" id="exampleInputAmount" placeholder="Enter username">
													</div>
												</div>
												<div class="form-group">
													<label for="exampleInputAmount">Password</label>
													<br>
													<div class="input-group">
														<div class="input-group-addon">I</div>
														<input required value="<?php echo $row['password']; ?>" type="text" name="password" class="form-control" id="exampleInputAmount" placeholder="Input">
													</div>
												</div>
												<div class="form-group">
												<label for="exampleInputAmount">Title</label>
												<br>
												<div class="input-group">
													<div class="input-group-addon">I</div>
													<input required value="<?php echo $row['title']; ?>" type="text" name="title" class="form-control" id="exampleInputAmount" placeholder="Enter Title">
												</div>
											</div>
											<div class="form-group">
												<label for="exampleInputAmount">Description</label>
												<br>
												<div class="input-group">
													<div class="input-group-addon">I</div>
													<input required value="<?php echo $row['description']; ?>" type="text" name="description" class="form-control" id="exampleInputAmount" placeholder="Enter Description">
												</div>
											</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												<input type="submit" name="submit" value="Update User" class="btn btn-success">
											</div>
										</form>
									</div>
								</div>
							</div>
							<!-- **** -->
				<?php	} 
					} else { echo "No Results Found!"; }  ?>
			    </tbody>
			</table>
		</div>
	</div>
</div>
<!-- Add New User Modal -->
<div id="add_user" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Add New User</h4>
			</div>
			<form class="form-inline" method="POST" action="add_new_user.php">
				<div class="modal-body">
					<div class="form-group">
						<label for="exampleInputAmount">Email</label>
						<br>
						<div class="input-group">
							<div class="input-group-addon">I</div>
							<input required type="email" name="email" class="form-control" id="exampleInputAmount" placeholder="Enter Email">
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputAmount">Username</label>
						<br>
						<div class="input-group">
							<div class="input-group-addon">I</div>
							<input required type="text" name="user_name" class="form-control" id="exampleInputAmount" placeholder="Enter username">
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputAmount">Password</label>
						<br>
						<div class="input-group">
							<div class="input-group-addon">I</div>
							<input required type="password" name="password" class="form-control" id="exampleInputAmount" placeholder="Input">
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputAmount">Title</label>
						<br>
						<div class="input-group">
							<div class="input-group-addon">I</div>
							<input required type="text" name="title" class="form-control" id="exampleInputAmount" placeholder="Enter Title">
						</div>
					</div>
					<div class="form-group">
						<label for="exampleInputAmount">Description</label>
						<br>
						<div class="input-group">
							<div class="input-group-addon">I</div>
							<input required type="text" name="description" class="form-control" id="exampleInputAmount" placeholder="Enter Description">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<input type="submit" name="submit" value="Add User" class="btn btn-success">
				</div>
			</form>
		</div>
	</div>
</div>


<!-- ************* -->

</body>

<link rel="stylesheet" type="text/css" href="css/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">

</html>