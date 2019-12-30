<?php
error_reporting(E_ALL);
ini_set('display_errors',1);
include_once('../fbstream/includes/config.php');

	session_start();
	/* UnSet Session */
	unset($_SESSION['stream_target']);
	unset($_SESSION['stream_source']);
	unset($_SESSION['stream_title']);
	unset($_SESSION['stream_description']);
	/* ************ */
	
	$st_target = $_POST['st_target'];
	$st_src_name = $_POST['st_src_name'];
	$st_title = $_SESSION['title'];
	$st_description = $_SESSION['description'];

	$flag = $_POST['flag'];
	if($flag == 'timeline') 
	{
		$option = $_POST['share'];
		$identifier =  str_replace('?fields=cover','',$_SESSION["identifier"]);
		$accesstoken2 = $_SESSION["accesstoken"];
		$new_token = substr($accesstoken2, strpos($accesstoken2, "access_token="));
		$access_token = str_replace("access_token=","",$new_token);
		echo $identifier.' '.$access_token;exit;
		$result = shell_exec("curl 'https://graph.facebook.com/v2.7/'".$identifier."'/live_videos?access_token=".$access_token."' -H 'Host: graph.facebook.com' -H 'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' -H 'Accept-Language: en-US,en;q=0.5'  -H 'Content-Type: application/x-www-form-urlencoded' -H 'Referer: https://developers.facebook.com' -H 'origin: https://developers.facebook.com' --data 'debug=all&format=json&method=post&pretty=0&title=usama&privacy=%7B%22value%22%3A%22".$option."%22%7D&suppress_http_code=1'");
			
			
			
		$data = json_decode($result,true);
		if($data['stream_url'] == '' || $data['message']){
			echo "No rtmp found <a href='add_stream.php'>Go back</a>";exit;
		}
		
		
		$new_stream_url = $data['stream_url'];
		/* Get Stream Key */
		$explode_stream = explode('/rtmp/',$new_stream_url);
		$stream_key = $explode_stream[1];
		/* ************ */
		$new_stream_url_secure = $data['secure_stream_url'];
		$rmtp_stream_id = $data['id'];		
		
	}
	else if($flag == 'page')
	{
		$option = $_POST['pages'];
		$all_pages = $_SESSION["accounts"];
		foreach($all_pages['data'] as $pages){
			if($pages['id'] == $option){
				$identifier = $pages['id'];
				$access_token = $pages['access_token'];
				$page_name = $pages['name'];
			}
		}
		
		$result = shell_exec('curl -k -X POST https://graph.facebook.com/'.$identifier.'/live_videos \
		-F "access_token='.$access_token.'" \
		-F "published=true"');
		
		$data = json_decode($result,true);
		$new_stream_url = $data['stream_url'];
		/* Get Stream Key */
		$explode_stream = explode('/rtmp/',$new_stream_url);
		$stream_key = $explode_stream[1];
		/* ************ */
		$new_stream_url_secure = $data['secure_stream_url'];
		$rmtp_stream_id = $data['id'];
		
	} 
	else
	{
		$identifier =  str_replace('?fields=cover','',$_SESSION["identifier"]);
		$accesstoken2 = $_SESSION["accesstoken"];
		$new_token = substr($accesstoken2, strpos($accesstoken2, "access_token="));
		$access_token = str_replace("access_token=","",$new_token);
		
		$result = shell_exec('curl -k -X POST https://graph.facebook.com/'.$identifier.'/live_videos \
		-F "access_token='.$access_token.'" \
		-F "published=true"');
		$data = json_decode($result,true);
		$new_stream_url = $data['stream_url'];
		/* Get Stream Key */
		$explode_stream = explode('/rtmp/',$new_stream_url);
		$stream_key = $explode_stream[1];
		/* ************ */
		$new_stream_url_secure = $data['secure_stream_url'];
		$rmtp_stream_id = $data['id'];
	}
	
$createSQL = "INSERT INTO `stream` (`user_id`, `st_target`, `str_src_name`, `st_title`, `st_description`, `flag`, `flag_option`, `access_token`, `user_identifier_id`,`new_stream_url`, `new_stream_url_secure`, `rmtp_stream_id`, `rtmp_url`, `stream_key`) VALUES ('".$_SESSION['login_user_id']."','".$st_target."','".$st_src_name."','".$st_title."','".$st_description."','".$flag."','".$option."','".$access_token."','".$identifier."','".$new_stream_url."','".$new_stream_url_secure."','".$rmtp_stream_id."','".$new_stream_url."','".$stream_key."')";



$createSuccess = mysql_query($createSQL);

if ($createSuccess) {
	$_SESSION['stream_id'] = mysql_insert_id();
	$_SESSION['new_stream_url'] = $new_stream_url;
	$_SESSION['source_name'] = $st_src_name;
	header("Location: get_response.php");
} else {
	echo "failed";exit;
}
 ?>