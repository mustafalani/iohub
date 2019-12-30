<?php
session_start();
require_once __DIR__ . '/src/Facebook/autoload.php'; // download official fb sdk for php @ https://github.com/facebook/php-graph-sdk
$fb = new Facebook\Facebook([
 'app_id' => '187399995210341',
  'app_secret' => '2c9a146d054d4f22fb8568ec443762c1',
  'default_graph_version' => 'v2.6'
  ]);
$helper = $fb->getRedirectLoginHelper();
// app directory could be anything but website URL must match the URL given in the developers.facebook.com/apps
define('APP_URL', 'http://streamer.kurrent.tv/facebook/');
$permissions = ['publish_actions','manage_pages','publish_pages','pages_show_list'];
try {
	if (isset($_SESSION['fb_token'])) {
		$accessToken = $_SESSION['fb_token'];
	} else {
  		//$accessToken = $helper->getAccessToken();
  		$accessToken = $helper->getAccessToken('http://streamer.kurrent.tv/facebook/');
	}
} catch(Facebook\Exceptions\FacebookResponseException $e) {
 	// When Graph returns an error
 	echo 'Graph returned an error: ' . $e->getMessage();
  	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
 	// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
  	exit;
 }
if (isset($accessToken)) {
   
if (isset($_SESSION['fb_token'])) {
		$fb->setDefaultAccessToken($_SESSION['fb_token']);
	} else {
		// getting short-lived access token
		$_SESSION['fb_token'] = (string) $accessToken;
	  	// OAuth 2.0 client handler
		$oAuth2Client = $fb->getOAuth2Client();
		// Exchanges a short-lived access token for a long-lived one
		$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['fb_token']);
		$_SESSION['fb_token'] = (string) $longLivedAccessToken;
		// setting default access token to be used in script
		$fb->setDefaultAccessToken($_SESSION['fb_token']);
	}
	// redirect the user back to the same page if it has "code" GET variable
	if (isset($_GET['code'])) {
		header('Location: ./');
	}
	// validating user access token
	try {
		$user = $fb->get('/me');
		$user = $user->getGraphNode()->asArray();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();
		session_destroy();
		// if access token is invalid or expired you can simply redirect to login page using header() function
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
	$response =  $fb->get('/me/accounts');
	$response = $response->getDecodedBody();
	
	$createLiveVideo = $fb->post('/me/live_videos', ["title" => "babbal", "description" => "babbal"]);
	 $createLiveVideo = $createLiveVideo->getGraphNode()->asArray();
	//$page = $fb->post('/2153366224689181/live_videos', ["title" => "babbal", "description" => "babbal"]);
	//$page = $fb->post('/2153366224689181/live_videos','');
	//$page = $page->getGraphNode()->asArray();
	
	$groups_request = $fb->get('/me/groups');
    $groups = $groups_request->getDecodedBody();
	echo"<pre>";
 print_r($response);	
	print_r($groups);
	 	 print_r($createLiveVideo);
	 exit; 
	// $createLiveVideo = $fb->post('/me/live_videos', ["title" => "babbal", "description" => "babbal"]);
	 // $createLiveVideo = $createLiveVideo->getGraphNode()->asArray();
	
    //$data = [
      //'title' => 'My Foo Video',
      //'description' => 'This video is full of foo and bar action.',
    //];
    
    //try {
      //$response = $fb->uploadVideo('1451106665118438', 'xyz.mp4', $data, $_SESSION['fb_token']);
    //} catch(Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      //echo 'Graph returned an error: ' . $e->getMessage();
      //exit;
    //} catch(Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      //echo 'Facebook SDK returned an error: ' . $e->getMessage();
      //exit;
    //}
    
   // echo 'Video ID: ' . $response['video_id'];

} else {
	// replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
	$loginUrl = $helper->getLoginUrl(APP_URL, $permissions);
//	echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
	echo "<script>window.top.location.href='".$loginUrl."'</script>";
}