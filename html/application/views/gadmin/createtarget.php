<?php $this->load->view('gadmin/navigation.php');?>
<?php $this->load->view('gadmin/leftsidebar.php');?>
<script>
  var fbid = "201130880631964";
  // Facebook SDK
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '201130880631964',
      xfbml      : true,
      version    : 'v2.8'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));

   function auth(){
      FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
          //console.log('Logged in.');
          $('.fbbutton > span').text("You are Logged In");
          FB.api('/me/live_videos', function(response) {
		     // console.log(response.data.length);	     
		    //  console.log(response.data[0].stream_url);	     
		 
		    });
		    FB.api(
    "/2116653851904017/live_videos",
    function (response) {
    	  console.log(response);
      if (response && !response.error) {
        /* handle the result */
      }
    }
);
        //  rtmp();
        }
        else {
          FB.login(function(response) {
            if (response.authResponse) {
            rtmp();
          }
          else {
            $('#alert-cancelled').show();
          }
          $('.fbbutton > span').text("You are not Logged In");
        }, {scope: 'public_profile'});
      }
    });
  }
	function isLoggedIn(){
      FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {          
          $('.fbbutton > span').text("You are Logged In");          
        }
        else {
         $('.fbbutton > span').text("You are not Logged In");
      }
    });
  }
  function rtmp(){
    FB.ui({
      display: 'popup',
      method: 'live_broadcast',
      phase: 'create',
    },
    function(response) {
      if (!response.id) {
        return;
        $('#alert-cancelled').show();
      }
      console.log(response);
      //document.getElementById('fbrtmp').value = response.secure_stream_url;
    // alert(FB.getAuthResponse()['accessToken']);
    
      document.getElementById('fbrtmp').value = response.stream_url;
      FB.ui({
        display: 'popup',
        method: 'live_broadcast',
        phase: 'publish',
        broadcast_data: response,
      },
      function(response) {
      });
    });
  }
  $(document).ready(function(){
  	//isLoggedIn();
  });
   function checkLoginState() {
    FB.getLoginStatus(function(response) {
      statusChangeCallback(response);
    });
  }
  function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
      // Logged into your app and Facebook.
      testAPI();
    } else {
      // The person is not logged into your app or we are unable to tell.
      document.getElementById('status').innerHTML = 'Please log ' +
        'into this app.';
    }
  }
  function testAPI() {   
    FB.api('/me/', function(response) {
      //console.log('Successful login for: ' + response.name);
      console.log(response);
      $('#status').text('Thanks for logging in, ' + response.name + '!');
    
      var tok = FB.getAuthResponse()["accessToken"];
          
    });
    FB.api('/me/accounts', function(response) {     
      console.log(response);      
    });
  }
  function enableEdit()
  {
  	$('#streamurl').removeAttr("readonly").css("color","#fff");
  }
  function showPages(valueofTimeline)
  {
  	if(valueofTimeline == "page")
  	{
		$('.pageslist').show();
	}
	else
	{
		$('.pageslist').hide();
	}
  }
 
</script>
<section class="content-wrapper">
  <!-- ========= Main Content Start ========= -->
  <div class="content">
    <div class="content-container">
			<div class="row">
			
			<div class="col-lg-12 col-12-12">			
	            <div class="content-box config-contentonly">
	            <div class="config-container">
	            	<form class="form-only form-one" method="post" action="<?php echo site_url();?>groupadmin/saveTarget" enctype="multipart/form-data">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	 
	  <div class="sav-btn-dv wowza-save">
						<button type="submit" class="btn-def save btntop2">
							<span><i class="fa fa-save"></i> Save</span>
						</button>
						<?php 
						$socialLogin = $this->session->userdata('socialLogin');	
						if(sizeof($socialLogin) > 0)
						{
						?>
						<a href="<?php echo site_url();?>groupadmin/cancelProvider" class="btn btn-danger btntop2" style="float:right;margin-right:8px;height:39px;">
							<span><i class="fa fa-remove"></i> Cancel</span>
						</a>
						<?php	
						}
						?>
						
					</div>
				<div class="col-lg-12 conf min-h-64 shadow">
					<div class="row">
						<div class="col-lg-6 p-t-15">
						
							<?php 
                                $socialLogin = $this->session->userdata('socialLogin');	
                                if(sizeof($socialLogin)>0)
                                {
									switch($socialLogin)
	                                {
										case "facebook":
										?>
										
							 <div class="form-group col-lg-10">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm" href="<?php echo site_url();?>groupadmin/fb">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm btndis">
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm btndis">
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>                                         
                                    <a class="btn btn-twitter btn-sm btndis">
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>                                                        
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-9">
                                <div class="row">
                                <span><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm btndis">
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>
                                        <a class="btn btn-microsoft btn-sm btndis">
                                            <i class="fa fa-cloud"></i>
                                                Akamai
                                        </a>
                                        <a class="btn btn-openid btn-sm btndis">
                                            <i class="fa fa-amazon"></i>
                                                CloudFront
                                        </a>                                                                                                                      
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">
                                        <a class="btn  btn-microsoft btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                Wowza Engine
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                Limelight
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>                                                                              
                                    </div>
                                </div>
                            </div> 
									<?php
										break;
										case "google":
										?>
										
							 <div class="form-group col-lg-10">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm btndis">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm " href="<?php echo site_url();?>groupadmin/googleaccount">
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm btndis">
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>                                         
                                    <a class="btn btn-twitter btn-sm btndis">
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>                                                        
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-9">
                                <div class="row">
                                <span><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm btndis">
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>
                                        <a class="btn btn-microsoft btn-sm btndis">
                                            <i class="fa fa-cloud"></i>
                                                Akamai
                                        </a>
                                        <a class="btn btn-openid btn-sm btndis">
                                            <i class="fa fa-amazon"></i>
                                                CloudFront
                                        </a>                                                                                                                      
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">
                                        <a class="btn  btn-microsoft btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                Wowza Engine
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                Limelight
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>                                                                              
                                    </div>
                                </div>
                            </div> 
									<?php
										break;
										case "twich":
										?>
										
							 <div class="form-group col-lg-10">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm btndis">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm btndis" >
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm " href="<?php echo site_url();?>groupadmin/twitch">
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>                                         
                                    <a class="btn btn-twitter btn-sm btndis">
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>                                                        
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-9">
                                <div class="row">
                                <span><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm btndis">
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>
                                        <a class="btn btn-microsoft btn-sm btndis">
                                            <i class="fa fa-cloud"></i>
                                                Akamai
                                        </a>
                                        <a class="btn btn-openid btn-sm btndis">
                                            <i class="fa fa-amazon"></i>
                                                CloudFront
                                        </a>                                                                                                                      
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">
                                        <a class="btn  btn-microsoft btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                Wowza Engine
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                Limelight
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>                                                                              
                                    </div>
                                </div>
                            </div> 
									<?php
										break;
										case "twitter":
										?>
										
							 <div class="form-group col-lg-10">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm btndis">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm btndis" >
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm btndis" >
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>                                         
                                    <a class="btn btn-twitter btn-sm " href="<?php echo site_url();?>groupadmin/twitter">
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>                                                        
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm btndis">
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>
                                        <a class="btn btn-microsoft btn-sm btndis">
                                            <i class="fa fa-cloud"></i>
                                                Akamai
                                        </a>
                                        <a class="btn btn-openid btn-sm btndis">
                                            <i class="fa fa-amazon"></i>
                                                CloudFront
                                        </a>                                                                                                                      
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">
                                        <a class="btn  btn-microsoft btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                Wowza Engine
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                Limelight
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>                                                                              
                                    </div>
                                </div>
                            </div> 
									<?php
										break;
										case "wowzacdn":
										?>
										
							 <div class="form-group col-lg-10">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm btndis">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm btndis" >
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm btndis" >
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>                                         
                                    <a class="btn btn-twitter btn-sm btndis" >
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>                                                        
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-9">
                                <div class="row">
                                <span><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm " href="<?php echo site_url();?>groupadmin/wowzacdn">
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>
                                        <a class="btn btn-microsoft btn-sm btndis">
                                            <i class="fa fa-cloud"></i>
                                                Akamai
                                        </a>
                                        <a class="btn btn-openid btn-sm btndis">
                                            <i class="fa fa-amazon"></i>
                                                CloudFront
                                        </a>                                                                                                                      
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">
                                        <a class="btn  btn-microsoft btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                Wowza Engine
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                Limelight
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>                                                                              
                                    </div>
                                </div>
                            </div> 
									<?php
										break;
										case "akamai":
										?>
										
							 <div class="form-group col-lg-9">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm btndis">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm btndis" >
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm btndis" >
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>                                         
                                    <a class="btn btn-twitter btn-sm btndis" >
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>                                                        
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-9">
                                <div class="row">
                                <span><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm btndis" >
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>
                                        <a class="btn btn-microsoft btn-sm " href="<?php echo site_url();?>groupadmin/akamai">
                                            <i class="fa fa-cloud"></i>
                                                Akamai
                                        </a>
                                        <a class="btn btn-openid btn-sm btndis">
                                            <i class="fa fa-amazon"></i>
                                                CloudFront
                                        </a>                                                                                                                      
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">
                                        <a class="btn  btn-microsoft btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                Wowza Engine
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                Limelight
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>                                                                              
                                    </div>
                                </div>
                            </div> 
									<?php
										break;
										case "cloudfront":
										?>
										
							 <div class="form-group col-lg-9">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm btndis">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm btndis" >
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm btndis" >
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>                                         
                                    <a class="btn btn-twitter btn-sm btndis" >
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>                                                        
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-9">
                                <div class="row">
                                <span><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm btndis" >
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>
                                        <a class="btn btn-microsoft btn-sm btndis" >
                                            <i class="fa fa-cloud"></i>
                                                Akamai
                                        </a>
                                        <a class="btn btn-openid btn-sm " href="<?php echo site_url();?>groupadmin/cloudfront">
                                            <i class="fa fa-amazon"></i>
                                                CloudFront
                                        </a>                                                                                                                      
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">
                                        <a class="btn  btn-microsoft btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                Wowza Engine
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                Limelight
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>                                                                              
                                    </div>
                                </div>
                            </div> 
									<?php
										break;
										case "wowzaengine":
										?>
										
							 <div class="form-group col-lg-9">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm btndis">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm btndis" >
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm btndis" >
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>                                         
                                    <a class="btn btn-twitter btn-sm btndis" >
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>                                                        
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-9">
                                <div class="row">
                                <span><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm btndis" >
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>
                                        <a class="btn btn-microsoft btn-sm btndis" >
                                            <i class="fa fa-cloud"></i>
                                                Akamai
                                        </a>
                                        <a class="btn btn-openid btn-sm btndis" >
                                            <i class="fa fa-amazon"></i>
                                                CloudFront
                                        </a>                                                                                                                      
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">
                                        <a class="btn  btn-microsoft btn-sm " href="<?php echo site_url();?>groupadmin/wowzaengine">
                                            <i class="fa fa-gear"></i>
                                                Wowza Engine
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                Limelight
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>                                                                              
                                    </div>
                                </div>
                            </div> 
									<?php
										break;
										case "limelight":
										?>
										
							 <div class="form-group col-lg-9">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm btndis">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm btndis" >
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm btndis" >
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>                                         
                                    <a class="btn btn-twitter btn-sm btndis" >
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>                                                        
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-9">
                                <div class="row">
                                <span><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm btndis" >
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>
                                        <a class="btn btn-microsoft btn-sm btndis" >
                                            <i class="fa fa-cloud"></i>
                                                Akamai
                                        </a>
                                        <a class="btn btn-openid btn-sm btndis" >
                                            <i class="fa fa-amazon"></i>
                                                CloudFront
                                        </a>                                                                                                                      
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">
                                        <a class="btn  btn-microsoft btn-sm btndis" >
                                            <i class="fa fa-gear"></i>
                                                Wowza Engine
                                        </a>
                                        <a class="btn btn-github btn-sm " href="<?php echo site_url();?>groupadmin/limelight">
                                            <i class="fa fa-gear"></i>
                                                Limelight
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>                                                                              
                                    </div>
                                </div>
                            </div> 
									<?php
										break;
										case "rtmp":
										?>
										
							 <div class="form-group col-lg-9">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm btndis">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm btndis" >
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm btndis" >
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>                                         
                                    <a class="btn btn-twitter btn-sm btndis" >
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>                                                        
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-9">
                                <div class="row">
                                <span><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm btndis" >
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>
                                        <a class="btn btn-microsoft btn-sm btndis" >
                                            <i class="fa fa-cloud"></i>
                                                Akamai
                                        </a>
                                        <a class="btn btn-openid btn-sm btndis" >
                                            <i class="fa fa-amazon"></i>
                                                CloudFront
                                        </a>                                                                                                                      
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">
                                        <a class="btn  btn-microsoft btn-sm btndis" >
                                            <i class="fa fa-gear"></i>
                                                Wowza Engine
                                        </a>
                                        <a class="btn btn-github btn-sm btndis" >
                                            <i class="fa fa-gear"></i>
                                                Limelight
                                        </a>
                                        <a class="btn btn-github btn-sm " href="<?php echo site_url();?>groupadmin/rtmp">
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>                                                                              
                                    </div>
                                </div>
                            </div> 
									<?php
										break;
										case "mpeg":
										?>
										
							 <div class="form-group col-lg-9">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm btndis">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm btndis" >
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm btndis" >
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>                                         
                                    <a class="btn btn-twitter btn-sm btndis" >
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>                                                        
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-9">
                                <div class="row">
                                <span><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm btndis" >
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>
                                        <a class="btn btn-microsoft btn-sm btndis" >
                                            <i class="fa fa-cloud"></i>
                                                Akamai
                                        </a>
                                        <a class="btn btn-openid btn-sm btndis" >
                                            <i class="fa fa-amazon"></i>
                                                CloudFront
                                        </a>                                                                                                                      
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">
                                        <a class="btn  btn-microsoft btn-sm btndis" >
                                            <i class="fa fa-gear"></i>
                                                Wowza Engine
                                        </a>
                                        <a class="btn btn-github btn-sm btndis" >
                                            <i class="fa fa-gear"></i>
                                                Limelight
                                        </a>
                                        <a class="btn btn-github btn-sm btndis" >
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm " href="<?php echo site_url();?>groupadmin/mpeg">
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>                                                                              
                                    </div>
                                </div>
                            </div> 
									<?php
										break;
										case "rtp":
										?>
										
							 <div class="form-group col-lg-9">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm btndis">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm btndis" >
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm btndis" >
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>                                         
                                    <a class="btn btn-twitter btn-sm btndis" >
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>                                                        
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-9">
                                <div class="row">
                                <span><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm btndis" >
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>
                                        <a class="btn btn-microsoft btn-sm btndis" >
                                            <i class="fa fa-cloud"></i>
                                                Akamai
                                        </a>
                                        <a class="btn btn-openid btn-sm btndis" >
                                            <i class="fa fa-amazon"></i>
                                                CloudFront
                                        </a>                                                                                                                      
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">
                                        <a class="btn  btn-microsoft btn-sm btndis" >
                                            <i class="fa fa-gear"></i>
                                                Wowza Engine
                                        </a>
                                        <a class="btn btn-github btn-sm btndis" >
                                            <i class="fa fa-gear"></i>
                                                Limelight
                                        </a>
                                        <a class="btn btn-github btn-sm btndis" >
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis" >
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm " href="<?php echo site_url();?>groupadmin/rtp">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>                                                                              
                                    </div>
                                </div>
                            </div> 
									<?php
										break;
										case "srt":
										?>
										
							 <div class="form-group col-lg-9">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm btndis">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm btndis" >
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm btndis" >
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>                                         
                                    <a class="btn btn-twitter btn-sm btndis" >
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>                                                        
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-9">
                                <div class="row">
                                <span><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm btndis" >
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>
                                        <a class="btn btn-microsoft btn-sm btndis" >
                                            <i class="fa fa-cloud"></i>
                                                Akamai
                                        </a>
                                        <a class="btn btn-openid btn-sm btndis" >
                                            <i class="fa fa-amazon"></i>
                                                CloudFront
                                        </a>                                                                                                                      
                                    </div>
                                </div>
                            </div>
		                     <div class="form-group col-lg-10">
                                <div class="row">
                                <span><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">
                                        <a class="btn  btn-microsoft btn-sm btndis" >
                                            <i class="fa fa-gear"></i>
                                                Wowza Engine
                                        </a>
                                        <a class="btn btn-github btn-sm btndis" >
                                            <i class="fa fa-gear"></i>
                                                Limelight
                                        </a>
                                        <a class="btn btn-github btn-sm btndis" >
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm btndis" >
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm btndis" >
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm " href="<?php echo site_url();?>groupadmin/srt">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>                                                                              
                                    </div>
                                </div>
                            </div> 
									<?php
										break;
									}
								}
								else
								{
									?>
							<div class="form-group col-lg-10">
                                <div class="row">
                                <label>Select Destination</label><br/>
                                <span><p class="fa fa-share-alt"></p> Social Platforms</span>
                                <div class="btns-dv">
                                 <a class="btn btn-facebook btn-sm" href="<?php echo site_url();?>groupadmin/fb">
                                        <span>
                                            <i class="fa fa-facebook"></i>
                                            Facebook Live
                                        </span>
                                    </a>
                                    <a class="btn btn-google btn-sm" href="<?php echo site_url();?>groupadmin/googleaccount">
                                        <i class="fa fa-youtube"></i>
                                            Youtube Live
                                    </a>
                                    <a class="btn btn-twitch btn-sm">
                                        <i class="fa fa-twitch"></i>
                                            Twitch
                                    </a>                                         
                                    <a class="btn btn-twitter btn-sm">
                                        <i class="fa fa-twitter"></i>
                                            Twitter Periscope
                                    </a>                                                        
                                    </div>
                                </div>
                            </div>
		                    <div class="form-group col-lg-9">
                                <div class="row">
                                <span><p class="fa fa-cloud"></p> CDN Services</span>
                                <div class="btns-dv">
                                        <a class="btn btn-soundcloud btn-sm">
                                            <i class="fa fa-cloud"></i>
                                                Wowza CDN
                                        </a>
                                        <a class="btn btn-microsoft btn-sm">
                                            <i class="fa fa-cloud"></i>
                                                Akamai
                                        </a>
                                        <a class="btn btn-openid btn-sm">
                                            <i class="fa fa-amazon"></i>
                                                CloudFront
                                        </a>                                                                                                                      
                                    </div>
                                </div>
                            </div>
		                    <div class="form-group col-lg-10">
                                <div class="row">
                                <span><p class="fa fa-gear"></p> Generic</span>
                                <div class="btns-dv">
                                        <a class="btn  btn-microsoft btn-sm">
                                            <i class="fa fa-gear"></i>
                                                Wowza Engine
                                        </a>
                                        <a class="btn btn-github btn-sm">
                                            <i class="fa fa-gear"></i>
                                                Limelight
                                        </a>
                                        <a class="btn btn-github btn-sm">
                                            <i class="fa fa-gear"></i>
                                                RTMP
                                        </a>
                                        <a class="btn btn-github btn-sm">
                                            <i class="fa fa-gear"></i>
                                                MPEG-TS
                                        </a>
                                        <a class="btn btn-github btn-sm">
                                            <i class="fa fa-gear"></i>
                                                RTP
                                        </a>
                                        <a class="btn btn-github btn-sm">
                                            <i class="fa fa-gear"></i>
                                                SRT
                                        </a>                                                                              
                                    </div>
                                </div>
                            </div> 
									<?php
								}
                            ?>
							
						
						
							<div class="form-group col-lg-9">
								<div class="row">
									<label>Target Name</label>
									<input type="text" class="form-control" placeholder="" name="target_name" id="target_name">
								</div>
							</div>
							<div class="form-group col-lg-9">
								<div class="row">
									<label>Select Application</label>
									<select class="form-control selectpicker" name="wowzaengin" id="wowzaengin" onchange="showApplicationURL(this.value);"> 
										<option value="0">Select</option>          
										 <?php 
											$apps = $this->common_model->getAllApplications();    
											if(sizeof($apps)>0)
											{
												foreach($apps as $app)
												{													
													echo '<option value="'.$app['id'].'">'.$app['application_name'].'</option>';															
												}
											}
											?>	
									</select>
								</div>
							</div>
							<div class="form-group col-lg-9">
								<div class="row">
									<input type="text" class="form-control" placeholder="" name="streamurl" id="streamurl" readonly="true">
								</div>
							</div>
							<div class="col-lg-3">
								<button type="button" class="btn btn-edit" onclick="enableEdit();">Edit</button>
							</div>

							
						
						</div>
						<div class="col-lg-6 p-t-15" id="facebookTargetFields">
						<?php 
						$fbUser=$this->session->userdata('fbUser');	
						$youtubeData=$this->session->userdata('youtubeData');	
						//print_r($youtubeData);					
						$facebookData = $this->session->userdata('ddd');	
						
						if(!empty($fbUser))
						{
							?>							
							
							<div class="form-group col-lg-12 pdright">
								<div class="btns-dv">
									<div class="row">
										<a class="btn btn-facebook btn-sm fbbutton" href="<?php echo site_url();?>groupadmin/facebookLogout">
                                            <span id="status">
                                                <i class="fa fa-facebook"></i>
                                                Revoke (<?php echo $fbUser['name'];?>)
                                                <img style="margin-left:7px;width:32px;" class="img-circle" src="//graph.facebook.com/<?php echo $fbUser['id'];?>/picture">
                                            </span>
                                        </a>
									</div>
								</div>								
							</div>		

							<?php
						}
						if(!empty($youtubeData))
						{
							?>							
							
							<div class="form-group col-lg-12 pdright">
								<div class="btns-dv">
									<div class="row">
										<a class="btn btn-google btn-sm fbbutton" href="<?php echo site_url();?>groupadmin/cancelProvider">
                                            <span id="status">
                                                <i class="fa fa-google"></i>
                                               	  Logout
                                            </span>
                                        </a>
									</div>
								</div>								
							</div>		

							<?php
						}
						?>
						<input type="hidden" value="<?php if(!empty($youtubeData)) echo $youtubeData['cdn']->ingestionInfo['streamName']; else echo "";?>" id="googlestream" name="googlestream"/>
								<?php if($this->session->flashdata('success')){ ?>
								<div class="alert alert-success" style="float:left;width: 100%;">
									<a href="#" class="close" data-dismiss="alert">&times;</a>
									<strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
								</div>
								<?php }else if($this->session->flashdata('error')){  ?>
								<div class="alert alert-danger" style="float: left;width: 100%;">
									<a href="#" class="close" data-dismiss="alert">&times;</a>
									<strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
								</div>
								<?php }else if($this->session->flashdata('warning')){  ?>
								<div class="alert alert-warning" style="float: left;width: 100%;">
									<a href="#" class="close" data-dismiss="alert">&times;</a>
									<strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
								</div>
								<?php }else if($this->session->flashdata('info')){  ?>
								<div class="alert alert-info" style="float: left;width: 100%;">
									<a href="#" class="close" data-dismiss="alert">&times;</a>
									<strong>Info!</strong> <?php echo $this->session->flashdata('info'); ?>
								</div>
							<?php } ?>
							<?php
							if(!empty($fbUser))
							{
							?>							
							
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Share On</label>
									<select class="form-control select" name="timelines" id="timelines" onchange="showPages(this.value);"> 
										<option value="">Select An Option</option>
										<option value="timeline" >Timeline</option>
										<option value="page">Page</option>
									</select>
								</div>
							</div>
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Privacy</label>
									<select class="form-control" id="privacy" name="privacy">
										<option value="">Select</option>
										<option value="SELF">Only Me</option>
										<option value="ALL_FRIENDS">Friends</option>
										<option value="FRIENDS_OF_FRIENDS">Friends OF Friends</option>
										<option value="EVERYONE">Public</option>
									</select>
								</div>
							</div>
							<div class="form-group col-lg-12 pageslist" style="display:none;">
								<div class="row">
									<label>Pages</label>
									<select class="form-control" id="pagelist" name="pagelist">
									<option value="">Select</option>
									<?php 
										$pages = $this->session->userdata('dfff');																	
										if(sizeof($pages)>0)
										{
											foreach($pages['data'] as $key=>$body)
											{												
												echo '<option value="'.$body['id'].'_'.$body['access_token'].'">'.$body['name'].'</option>';		
											}
										}
									?>	
									</select>
								</div>
							</div>		

							<?php
						}
						?>
							
											
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Title</label>
									<input type="text" class="form-control" placeholder="Title of the live video post" name="title" id="title">
								</div>
							</div>
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Description</label>
									<textarea class="form-control" rows="4" id="description" name="description"></textarea>
								</div>
							</div>
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Continuous Live</label><br>
									<label class="checkbox-inline">
									<input type="checkbox" id="continuelive" name="continuelive">
										Send a continuous live stream
									</label>
								</div>
							</div>
						</div>
						
						
					</div>
					
					<!-- </div> -->
				</div>
</form>
	            </div>
			
				</div>
			</div>
			</div>
				
			</div>
			</div>
		</section>