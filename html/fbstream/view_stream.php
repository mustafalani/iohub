<?php 

include_once('../fbstream/includes/config.php');
session_start();
// echo $_SESSION['login_user_id'];
// exit;

/* Get All Streams */
$query = "SELECT * FROM stream WHERE user_id = ".$_SESSION['login_user_id']." ORDER BY id ASC ";
$result = mysqli_query($query);
$count = mysqli_num_rows($result);

// exit;
/* ****************** */


// Starting Session
if (!isset($_SESSION['login_user_id']) || ($_SESSION['login_user_id'] == '')) {
    header("location: login.php");
}
?>
<!DOCTYPE html>
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
		
		<div class="form-bootsa" style="width:100%;">
			<div class="logo">
				<img src="images/logo.png" >
			</div>
			<br>
			<?php 
			if($_GET['status'] == 'success'){
				echo "<p style='color:green'>Your app has been created successfully! </p>";
			}
			?>
			<form class="form-inline">
				<div class="end-btns2">
				
				  	<ul>
				  	 	<li>
				  	 		<a href="#">
				  	 		    <a href="add_stream.php" type="button" class="fa fa-plus btn btn-primary add-stream all-btn">Add Stream Target</a>
				  	 		</a>
				  	 	</li>
						<li>
				  	 		<a href="logout.php">
				  	 		    <button type="button" class="btn btn-danger enable-stream pull-right logout">Logout</button>
				  	 		</a>
				  	 	</li>
						
				 	</ul>
				</div>
				<?php if($count > 0){ ?>
			   <table class="table table-bordered" style="margin-top:20px;">
			   <thead>
			      <tr>
			        <th>Stream Target</th>
			        <th>RMTP URL</th>
			        <th>Status</th>
			        <th>Actions</th>
			      </tr>
			   </thead>
			   <tbody>
				
				
					<?php while ($row = mysql_fetch_assoc($result)) { 
					
						$rmtp = explode('/rtmp/',$row['new_stream_url']); ?>
						
			      <tr>
					
			        <td style="width:27%;">
			        	<i class="fa fa-facebook-official fb-icon" aria-hidden="true"></i>
			        	<a target="_blank" href="<?php echo $row['rtmp_url']; ?>"><?php echo $row['st_target']; ?> (RTMP)</a>
			        </td>
					<td>
			        	<?php echo $row['new_stream_url']; ?>
					</td>
					
			        <td>Wating</td>
			        <td style="width:26%;">
			        	<ul class="action-li">
			      			<li><a href="edit_stream.php?id=<?php echo $row['id']; ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></li>
			        		<li><a href="remove_stream.php?id=<?php echo $row['id']; ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a></li>
			        	</ul>
			        </td>
					
			      </tr>
				  <?php } ?>
					
			    </tbody>
			  </table>
			  <?php } else { echo "No Results Found!"; }  ?>
			</form>
		</div>
	</div>
</div>

</body>


<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">

</html>