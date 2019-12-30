<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<center><img src="load.gif" height="" width=""></center>
<?php
include_once('includes/config.php');
session_start();
$app_name = $_SESSION['app_name'];
$new_stream_url = $_SESSION['new_stream_url'];
$source_name = $_SESSION['source_name'];
$arr = array('app_name' => $app_name, 'source_name' => $source_name, 'rtmp_url' => $new_stream_url);

$new_array =  json_encode($arr); 

?>

<input type="hidden" value="<?php echo $app_name; ?>" id="app_name">
<input type="hidden" value="<?php echo $source_name; ?>" id="source_name">
<input type="hidden" value="<?php echo $new_stream_url; ?>" id="rtmp_url">
<input type="hidden" value='<?php echo $new_array; ?>' id="json_data">

<script>
$( document ).ready(function() {
	// alert();
	var app_name = $('#app_name').val();
	var source_name = $('#source_name').val();
	var rtmp_url = $('#rtmp_url').val();
	var json_data = $('#json_data').val();
	var data = {"app_name":app_name,"source_name":source_name,"rtmp_url":rtmp_url};
    $.ajax({
        type: "POST",
        data :JSON.stringify(data),
        url: "http://199.189.86.19:8182/api/v1/addStream",
        Accept: 'application/json',
		contentType: 'application/json',
		success : function(data){			
			var new_stream_url = data.rtmp;
			$.ajax({
				url: "update_stream_url.php",
				type : 'POST',
				data : {'new_stream_url' : new_stream_url},
				success : function(response){
				window.location.href = 'view_stream.php';
					
				}
			});
		}
    });
});


</script>
