<!DOCTYPE html>
<html>
<?php
include_once('includes/config.php');
/* Fetch Data Yo Update */
$stream_id = $_REQUEST['id'];
$chSQL = "SELECT * FROM `stream` WHERE `id`='".$stream_id."'";
$chResult = mysql_query($chSQL);
$rows = mysql_fetch_assoc($chResult);
/* ************** */


session_start(); 
if (($_SESSION['is_login'] == '') || (!isset($_SESSION['is_login']))) {
} else if($_SESSION['is_login'] == 'facebook'){
} else {
	
}
?>
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
		<div class="form-bootsa">
			<div class="logo">
				<img src="images/logo.png" >
			</div>
			<h1>Update Stream</h1>
			<form class="form-inline" method="POST" action="update_stream_process.php">
				<div class="form-group">
					<label for="exampleInputAmount">Stream Target Name</label>
					<br>
					<input type="hidden" value="<?php echo $stream_id; ?>" name="stream_id">
					<div class="input-group">
						<div class="input-group-addon">I</div>
						<input type="text" value="<?php if($rows['st_target']){ echo $rows['st_target']; } ?>" name="st_target" id="st_target_name" class="form-control" id="exampleInputAmount" placeholder="Input">
					</div>
				</div>
				<div class="form-group">
					<label for="exampleInputAmount">Source Stream Name</label>
					<br>
					<div class="input-group">
						<div class="input-group-addon">I</div>
						<input type="text" value="<?php if($rows['str_src_name']){ echo $rows['str_src_name']; } ?>" class="form-control" id="st_src" name="st_src_name" id="exampleInputAmount" placeholder="Input">
					</div>
				</div>
				
				<div class="end-btns">
					<ul>
						<li><a href="view_stream.php"><button type="button" class="btn btn-default back">Back</button></a></li>
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
// $('#flag').change(function(){
	// var flag = $('#flag').val();
	// if(flag == 'timeline'){
		// $('#show_timeline').show();
		// $('.show_timeline_label').show();
		// $('.show_pages_label').hide();
		// $('#show_pages').hide();
	// } else if(flag == 'page') {
		// $('#show_pages').show();
		// $('.show_pages_label').show();
		// $('.show_timeline_label').hide();
		// $('#show_timeline').hide();
	// } else {
		// $('#show_pages').hide();
		// $('.show_pages_label').hide();
		// $('.show_timeline_label').hide();
		// $('#show_timeline').hide();
		// return false;
	// }
// });

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
        url: "http://10.90.1.22:8182/api/v1/addStream",
        contentType: "application/json",
		success : function(data){
			console.log(data);
		}
    });
});


</script>
</html>