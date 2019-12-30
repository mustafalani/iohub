<!DOCTYPE html>
<html>
<?php 
session_start();


if(!$_SESSION['login_user_id']){
	
header('location:login.php');
		}
// session_unset(); 
// session_destroy(); 
if (($_SESSION['is_login'] == '') || (!isset($_SESSION['is_login']))) {
   // header("Location: login.php");
   // session_unset(); 
// session_destroy(); 
} else if($_SESSION['is_login'] == 'facebook'){
	// $name =  $_SESSION["name"];
	// $profile_url =  $_SESSION["profile_url"];
	// $image =  $_SESSION["image"];
	// $email = $_SESSION["email"];
	$accesstoken2 = $_SESSION["accesstoken"];
	$new_token = substr($accesstoken2, strpos($accesstoken2, "access_token="));
	$access_token = str_replace("access_token=","",$new_token);
	// echo "<b>Name</b> :".$name."<br>";
	// echo "<b>Profile URL</b> :".$profile_url."<br>";
	// echo "<b>Image</b> :".$image."<br> ";
	// echo "<img src='".$image."'/><br>";
	// echo "<b>Email</b> :".$email."<br>";
	// echo "<b>Access Token</b> ".$access_token."<br>";
} else {
	
}


?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<head>
<title>Stream Live </title>

<link rel="stylesheet" type="text/css" href="css/style.css">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

<script type="text/javascript">
	
$( ".input" ).focusin(function() {
  $( this ).find( "span" ).animate({"opacity":"0"}, 200);
});

$( ".input" ).focusout(function() {
  $( this ).find( "span" ).animate({"opacity":"1"}, 300);
});

$(".login").submit(function(){
  $(this).find(".submit i").removeAttr('class').addClass("fa fa-check").css({"color":"#fff"});
  $(".submit").css({"background":"#2ecc71", "border-color":"#2ecc71"});
  $(".feedback").show().animate({"opacity":"1", "bottom":"-80px"}, 400);
  $("input").css({"border-color":"#2ecc71"});
  $("select").css({"border-color":"#2ecc71"});
  return false;
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
			<h1>Add Stream</h1>
			<form class="form-inline" method="POST" action="stream_process.php">
				<div class="form-group">
					<label for="exampleInputAmount">Stream Target Name</label>
					<br>
					<div class="input-group input">
						<input type="text" value="<?php if($_SESSION['stream_target']){ echo $_SESSION['stream_target']; } ?>" name="st_target" id="st_target_name" class="form-control" id="exampleInputAmount" placeholder="Input">
					</div>
				</div>
				<div class="form-group">
					<label for="exampleInputAmount">Source Stream Name</label>
					<br>
					<div class="input-group input">
						<input type="text" value="<?php if($_SESSION['stream_source']){ echo $_SESSION['stream_source']; } ?>" class="form-control" id="st_src" name="st_src_name" id="exampleInputAmount" placeholder="Input">
					</div>
				</div>
				<?php if (($_SESSION['is_login'] == '') || (!isset($_SESSION['is_login']))) {
				   
				?>
				<div class="fb-login">
					<b>Log in to Facebook to authorize as a Facebook Live Stream target.</b>
					<a href="javascript:;" id="get_values" class="btn btn-primary sfb-btn facebook-btn">
			  		<i class="fa fa-facebook-official" aria-hidden="true"></i>Facebook
					</a>
				</div>
			  
				<?php } else { 
					$name =  $_SESSION["name"];
					$profile_url =  $_SESSION["profile_url"];
					$image =  $_SESSION["image"];
					$email = $_SESSION["email"];
					
					echo '<br><p style="color:black;font-size:large;">'.ucwords($name).' is currently logged in to Facebook.Click the button below if you want to log in as a differnt user!</p>';
				?><br>
				
				
				<input type="hidden" value="<?php echo $new_stream_url_secure; ?>" name="new_stream_url_secure">
				<input type="hidden" value="" name="json_data">
				
				<a class="btn btn-primary" id="change_user" href='https://www.facebook.com/logout.php?next=http://pacific1055.us.unmetered.com/vidavovivo/add_stream.php&access_token=<?php echo $access_token; ?>;'>Change User</a>
				
					<div class="form-group">
						<div class="input-group input">
							<select style="" class="form-control" name="flag" id="flag" placeholder="Input">
								<option readonly>Select An Option</option>
								<option value="timeline" >Timeline</option>
								<option value="page">Page</option>
							</select>
						</div>
					</div> 
					<?php 
					$posts = $_SESSION["posts"];
					$pages = $_SESSION["accounts"];
					?> 
					<div class="form-group">
						<div class="input-group input">
							<label class="show_timeline_label" style="display:none;">Share On*</label>
							<select class="form-control" style="display:none;" id="show_timeline" placeholder="Input" name="share">
								<option value="" readonly>Select</option>
								<option value="SELF">Only Me</option>
								<option value="ALL_FRIENDS">Friends</option>
								<option value="FRIENDS_OF_FRIENDS">Friends OF Friends</option>
								<option value="EVERYONE">Public</option>
							</select>
							<label class="show_pages_label" style="display:none;">My Pages*</label>
							<select class="form-control" name="pages" style="display:none;" id="show_pages" placeholder="Input">
							<option value="" readonly>Select Page</option>
							<?php foreach($pages['data'] as $p){ ?>
								<option value="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></option>
							<?php } ?>
							</select>
						</div>
					</div>
					
				<?php 
				} ?>
				<div class="end-btns">
					<ul>
						<li><a href="view_stream.php"><button type="button" class="btn btn-default back all-btn">Back</button></a></li>
						<li><input type="submit" id="submit" class="btn btn-success finish" value="Finish"> </li>
					</ul>
				</div>

			</form>
		</div>
	</div>
</div>

</body>

<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">
<script>
$('#change_user').click(function(){
	$.ajax({
		'url' : 'fb_login/logout.php',
		success: function(data){
		}
		
	});
	
});
$('#flag').change(function(){
	var flag = $('#flag').val();
	if(flag == 'timeline'){
		$('#show_timeline').show();
		$('.show_timeline_label').show();
		$('.show_pages_label').hide();
		$('#show_pages').hide();
	} else if(flag == 'page') {
		$('#show_pages').show();
		$('.show_pages_label').show();
		$('.show_timeline_label').hide();
		$('#show_timeline').hide();
	} else {
		$('#show_pages').hide();
		$('.show_pages_label').hide();
		$('.show_timeline_label').hide();
		$('#show_timeline').hide();
		return false;
	}
});

$('#get_values').click(function(){
	var stream_target = $('#st_target_name').val();
	var stream_source = $('#st_src').val();
	var stream_title = $('#st_title').val();
	var stream_description = $('#st_description').val();
	
	$.ajax({
		url : "set_session.php",
		type: "POST",
		data : {'stream_target' : stream_target,'stream_source' : stream_source,'stream_title' : stream_title,'stream_description' : stream_description },
		success : function(result) {
			if(result == 'success'){
				window.location.href = 'fb_login/login-with.php?provider=Facebook';
			} else {
				alert('Something Is Wrong');
			}
		},
	});

});


	$('#a').click(function(){
	// var format = {"app_name":"live","source_name":"Yousaf","rtmp_url":"rtmp:\/\/rtmp-api.facebook.com:80\/rtmp\/10154352878184004?ds=1&a=AabPAEMlyd70RlbA"};
	 var customer = {"app_name":"live","source_name":"Yousaf","rtmp_url":"rtmp:\/\/rtmp-api.facebook.com:80\/rtmp\/10154352878184004?ds=1&a=AabPAEMlyd70RlbA"};
    $.ajax({
        type: "POST",
        data :JSON.stringify(customer),
        url: "http://ngs8.net:8182/api/v1/addStream",
        contentType: "application/json",
		success : function(data){
			console.log(data);
		}
    });
});


</script>
</html>