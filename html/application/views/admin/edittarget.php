<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<script type="text/javascript">
	function showpagelist()
	{
		$('.fbinput').show();
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
  function enableEdit()
  {
  	$('#streamurl').removeAttr("readonly").css("color","#fff");
  }

</script>
<style type="text/css">
	#player-container {
    position: relative;
    width: 100%;
    max-width: 752px;
    height: 393px;
    background: url(../img/rukavat.jpg);
    background-size: 100%;
    background: black;
}
.btedit {

    position: absolute;
    right: 7px;
    top: 1px;
    background: none;
    color: #3C8DBC;
    font-size: 18px;
    padding: 0;
    -webkit-appearance:none;

}
	iframe.twitter-tweet {
  display: inline-block;
  font-family: "Helvetica Neue", Roboto, "Segoe UI", Calibri, sans-serif;
  font-size: 12px;
  font-weight: bold;
  line-height: 16px;
  border-color: #eee #ddd #bbb;
  border-radius: 5px;
  border-style: solid;
  border-width: 1px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.15);
  margin: 10px 5px;
  padding: 0 16px 16px 16px;
  width: 100% !important;
  max-width: 100% !important;
}

iframe.twitter-tweet p {
  font-size: 16px;
  font-weight: normal;
  line-height: 20px;
}
.EmbeddedTweet
{
	width:100% !important;
}
</style>
<main class="main">
  	   <!-- Breadcrumb-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo site_url();?>">Home</a>
        </li>
        <li class="breadcrumb-item active"><a href="<?php echo site_url();?>applications">Apps</a></li>
        <li class="breadcrumb-item active"><?php echo $target[0]["target_name"];?></li>
      </ol>
      <div class="container-fluid">
      	<div class="animated fadeIn">
           <div class="card">
						 <form class="form-only form-one" method="post" action="<?php echo site_url();?>admin/saveeditTarget/<?php echo $this->uri->segment(2);?>" enctype="multipart/form-data">
						 <div class="card-header">Edit Target</div>
				<div class="card-body">
				<?php if($this->session->flashdata('success')){ ?>
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<?php echo $this->session->flashdata('success'); ?>
				</div>
				<?php }else if($this->session->flashdata('error')){  ?>
				<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<?php echo $this->session->flashdata('error'); ?>
				</div>
				<?php }else if($this->session->flashdata('warning')){  ?>
				<div class="alert alert-warning">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<?php echo $this->session->flashdata('warning'); ?>
				</div>
				<?php }else if($this->session->flashdata('info')){  ?>
				<div class="alert alert-info">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<?php echo $this->session->flashdata('info'); ?>
				</div>
			<?php } ?>
			<div class="row">

			<div class="col-lg-12 col-12-12">
	            <div class="content-box config-contentonly">
	            <div class="config-container">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

	  <div class="sav-btn-dv wowza-save">
						<?php
						$socialLogin = $this->session->userdata('socialLogin');
						if(sizeof($socialLogin) > 0)
						{
						?>
						<a href="<?php echo site_url();?>admin/editcancelProvider/<?php echo $this->uri->segment(2);?>" class="btn btn-danger btntop2" style="float:right;margin-right:8px;height:39px;">
							<span><i class="fa fa-remove"></i> Cancel</span>
						</a>
						<?php
						}
						?>
					</div>
					<div class="row">
						<div class="col-lg-6 p-t-15">
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Target Name</label>
									<input type="text" class="form-control" placeholder="" name="target_name" id="target_name" value="<?php echo $target[0]["target_name"];?>"readonly="true">
								</div>
							</div>
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Select Application</label>
									<select class="form-control selectpicker" name="wowzaengin" id="wowzaengin" onchange="showApplicationURL(this.value);">
										<option value="0">-- Select --</option>
										 <?php

											if(sizeof($apps)>0)
											{
												foreach($apps as $app)
												{
													if($app['id'] == $target[0]{"wowzaengin"})
													{
														echo '<option selected="selected" value="'.$app['id'].'">'.$app['application_name'].'</option>';
													}
													else
													{
														echo '<option value="'.$app['id'].'">'.$app['application_name'].'</option>';
													}
												}
											}
											?>
									</select>
								</div>
							</div>
							<div class="form-group col-lg-12">
								<div class="row">
									<input type="text" class="form-control" placeholder="" name="streamurl" id="streamurl" readonly="true" value="<?php echo $target[0]["streamurl"];?>">
									<i type="button" class="fa fa-edit btn btedit" onclick="enableEdit();"></i>
								</div>
							</div>
							<!--<div class="col-lg-3">
								<button type="button" class="btn btn-edit" onclick="enableEdit();">Edit</button>
							</div>-->



						</div>

						<div class="col-lg-6 p-t-15" id="facebookTargetFields">
							<input type="hidden" value="<?php echo $target[0]['target'];?>" id="target" name="target"/>
							<?php
							$fbUser=$this->session->userdata('fbUser');
									$facebookData = $this->session->userdata('ddd');
                                if($target[0]['target'] == "facebook")
                                {
                                	?>
                                		<input type="hidden" value="<?php echo $fbUser['id'];?>" id="fbuserid" name="fbuserid"/>
							<input type="hidden" value="<?php echo $fbUser['name'];?>" id="fbusername" name="fbusername"/>
                                	<?php

									if(!empty($fbUser))
									{
										?>
										<div class="col-lg-12">
									 <div class="btns-dv">
                                    <div class="row">
                                    <a class="btn btn-facebook btn-sm fbbutton" href="#">
                                            <span id="status">
                                                Logged in as (<?php echo $fbUser['name'];?>)
                                                <img style="margin-left:7px;width:32px;" class="img-circle" src="//graph.facebook.com/<?php echo $fbUser['id'];?>/picture">
                                            </span>
                                        </a>

                                    </div>

                                </div>
								</div>
										<?php
									}
									else
									{
										?>
										<div class="col-lg-12">
										 <div class="btns-dv">
	                                    <div class="row">

                                         <a href="<?php echo site_url();?>admin/fb/player/<?php echo $target[0]['id'];?>" class="btn btn-facebook btn-sm">
                                            <span>
                                                <i class="fa fa-facebook"></i>
                                             Login to View Player
                                            </span>
                                        </a>

                                        </div>
                                        </div>
                                        </div>
										<?php
									}
									?>

								<br/><br/>
									<div class="col-lg-12">
									 <div class="btns-dv">
                                    <div class="fb-notification alert-success alert-dismissable fade in">
                                        <a href="#" class="close" data-dismiss="fb-notification" onclick="javascript:$(this).parent().parent().parent().fadeOut('slow');" aria-label="close">&times;</a>
                                        <?php
                                        	if($target[0]['shareon'] == "page")
                                        	{
												if(!empty($fbUser))
												{
													if($target[0]['revoke'] == 1)
													{
														 ?>
													 Your Live Video will be shared on <span style="color: #0000ff;"><?php echo $target[0]["pagename"];?></span>, You can <strong><a href="javascript:void(0);" onclick="showpagelist();">Chnage</a></strong> The Post Destination.
													 <?php
													}
													else
													{
														?>
													 Your Live Video will be shared on <span style="color: #0000ff;"><?php echo $target[0]["pagename"];?></span>, You can <strong><a href="javascript:void(0);" onclick="showpagelist();">Chnage</a></strong> The Post Destination or <strong><a style="color:red;" href="<?php echo site_url();?>admin/revokeFB/<?php echo $this->uri->segment(2);?>">Revoke</a> </strong>your Facebook Access.
													 <?php
													}
												}
												else
												{
													if($target[0]['revoke'] == 1)
													{
														 ?>
													 Your Live Video will be shared on <span style="color: #0000ff;"><?php echo $target[0]["pagename"];?></span>, You can <strong><a href="<?php echo site_url();?>admin/fb/edittarget/<?php echo $this->uri->segment(2);?>">Chnage</a></strong> The Post Destination.
													 <?php
													}
													else
													{
														?>
													 Your Live Video will be shared on <span style="color: #0000ff;"><?php echo $target[0]["pagename"];?></span>, You can <strong><a href="<?php echo site_url();?>admin/fb/edittarget/<?php echo $this->uri->segment(2);?>">Chnage</a></strong> The Post Destination or <strong><a href="<?php echo site_url();?>admin/fb/revokeFB/<?php echo $this->uri->segment(2);?>" style="color:red;">Revoke</a> </strong>your Facebook Access.


													 <?php
													}
												}
											}
											elseif($target[0]['shareon'] == "timeline")
                                        	{
                                        		if(!empty($fbUser))
												{
													if($target[0]['revoke'] == 1)
													{
														 ?>
													 Your Live Video will be shared on <span style="color: #0000ff;"><?php echo $target[0]["fbusername"];?>'s Timeline</span>, You can <strong><a href="javascript:void(0);" onclick="showpagelist();">Chnage</a></strong> The Post Destination.
													 <?php
													}
													else
													{
														?>
													 Your Live Video will be shared on <span style="color: #0000ff;"><?php echo $target[0]["fbusername"];?>'s Timeline</span>, You can <strong><a href="javascript:void(0);" onclick="showpagelist();">Chnage</a></strong> The Post Destination or <strong><a href="<?php echo site_url();?>admin/revokeFB/<?php echo $this->uri->segment(2);?>" style="color:red;">Revoke</a> </strong>your Facebook Access.
													 <?php
													}
												}
												else
												{
													if($target[0]['revoke'] == 1)
													{
														 ?>
													 Your Live Video will be shared on <span style="color: #0000ff;"><?php echo $target[0]["fbusername"];?>'s Timeline</span>, You can <strong><a href="<?php echo site_url();?>admin/fb/edittarget/<?php echo $this->uri->segment(2);?>">Chnage</a></strong> The Post Destination.
													 <?php
													}
													else
													{
														?>
													  Live Video will be shared on <span style="color: #0000ff;"><?php echo $target[0]["fbusername"];?>'s Timeline</span>, You can <strong><a href="<?php echo site_url();?>admin/fb/edittarget/<?php echo $this->uri->segment(2);?>">Chnage</a></strong> The Post Destination or <strong><a href="<?php echo site_url();?>admin/fb/revokeFB/<?php echo $this->uri->segment(2);?>" style="color:red;">Revoke</a> </strong>your Facebook Access.
													 <?php
													}
												}
											}
                                        ?>


                                    </div>
                               </div>
                               </div>
									<?php
								}
                                ?>
                                <?php
                                if(!empty($fbUser))
								{
									?>
									<div class="form-group col-lg-12 fbinput">
								<div class="row">
									<label>Share On</label>
									<select class="form-control selectpicker" name="timelines" id="timelines" onchange="showPages(this.value);">
										<option value="">Select An Option</option>
										<option value="timeline" >Timeline</option>
										<option value="page">Page</option>
									</select>
								</div>
							</div>
							<div class="form-group col-lg-12 fbinput">
								<div class="row">
									<label>Privacy</label>
									<select class="form-control selectpicker" id="privacy" name="privacy">
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
									<select class="form-control selectpicker" id="pagelist" name="pagelist">
									<option value="">Select</option>
									<?php
										$pages = $this->session->userdata('dfff');
										if(sizeof($pages)>0)
										{
											foreach($pages['data'] as $key=>$body)
											{
												echo '<option value="'.$body['id'].'_'.$body['access_token'].'_'.$body['name'].'">'.$body['name'].'</option>';
											}
										}
									?>
									</select>
								</div>
							</div>
									<?php
								}
                                ?>
							<?php
							if($target[0]["target"] == "facebook" || $target[0]["target"] == "google" || $target[0]["target"] == "twitter" || $target[0]["target"] == "twitch")
							{
								?>
								<div class="form-group col-lg-12">
								<div class="row">
									<label>Title</label>
									<input type="text" class="form-control" placeholder="Title of the live video post" name="title" id="title" value="<?php echo $target[0]["title"];?>">
								</div>
							</div>
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Description</label>
									<textarea class="form-control" rows="4" id="description" name="description"><?php echo $target[0]["description"];?></textarea>
								</div>
							</div>
								<?php
							}
							?>
							<?php
							if($target[0]["target"] == "facebook")
							{
								?>
								<div class="form-group col-lg-12 check-input">
								<div class="row">
										<div class="boxes">
                                        <?php
									if($target[0]["continuelive"] == 0)
									{
									?>
										<input type="checkbox" id="continuelive" name="continuelive">
									<?php
									}
									elseif($target[0]["continuelive"] == 1)
									{
										?>
										<input type="checkbox" checked="true" id="continuelive" name="continuelive">
										<?php
									}
									?>
																				<label for="continuelive" style="padding-left: 20px;line-height:15px;">Send A Continuous Live Stream</label>
                                    </div>


								</div>
							</div>
								<?php
							}
							?>

							<?php
							if($target[0]["target"] == "rtmp")
							{
								?>
									<div class="form-group col-lg-12">
										<div class="row">
											<label>RTMP Stream URL</label>
											<input type="text" class="form-control" name="rtmp_stream_url" id="rtmp_stream_url" value="<?php echo $target[0]["rtmp_stream_url"];?>">

										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="row">
											<label>RTMP Stream Key</label>
											<input type="text" class="form-control" name="rtmp_stream_key" id="rtmp_stream_key" value="<?php echo $target[0]["rtmp_stream_key"];?>">

										</div>
									</div>
									<div class="form-group col-lg-12 check-input">
									<div class="row">

                                    <div class="boxes">
                                    	<?php
                                    	if($target[0]['target_auth'] == 0)
                                    	{
											?>
											<input type="checkbox" id="target_auth" name="target_auth">
											<?php
										}
										elseif($target[0]['target_auth'] == 1)
                                    	{
											?>
											<input checked="true" type="checkbox" id="target_auth" name="target_auth">
											<?php
										}
                                    	?>

                                        <label for="target_auth" style="padding-left: 20px;line-height:15px;">Use Authentication</label>
                                    </div>

                                    </div>
									</div>
									<div class="form-group col-lg-12">
                                    <div class="row tar-uname">

                                    	<label>Username</label>
                                    	<input type="text" class="form-control" name="target_auth_uname" id="target_auth_uname"/>
                                    </div>
									</div>
									<div class="form-group col-lg-12">
                                    <div class="row tar-pass">

                                    	<label>Password</label>
                                    	<input type="text" class="form-control" name="target_auth_pass" id="target_auth_pass"/>
                                    </div>
                                    </div>
								<?php
							}
							?>




						</div>
						<div class="divider col-lg-12"></div>

							<div class="col-lg-6 p-t-15">

								<div id="source-container">
									<div id="player_source" title="<?php echo $target[0]['streamurl'];?>"></div>
								</div>
							</div>
							<div class="col-lg-6 p-t-15">
									<?php
									//https://api.twitter.com/1.1/collections/list.json
									if($target[0]['target'] == "twitter")
									{

										$content = file_get_contents("https://publish.twitter.com/oembed?url=https%3A%2F%2Ftwitter.com%2FInterior%2Fstatus%2F".$target[0]["broadcast_id"]);
										$jsonarray = json_decode($content,TRUE);

										?>
										<div id="des-container">
										<?php
										echo $jsonarray['html'];
										?>
										</div>

										<?php
									}
									if($target[0]['target'] == "rtmp")
									{
										?>
										<div id="des-container">
											<div id="player_source_rtmp" title="<?php echo $target[0]['rtmp_stream_url'];?>/<?php echo $target[0]['rtmp_stream_key'];?>"></div>
										</div>
										<?php
									}
									if($target[0]['target'] == "twitch")
									{
										?>
										<div id="des-container">
										<iframe id="twitchPlayer"
										    src="//player.twitch.tv/?channel=<?php echo $target[0]['fbusername'];?>" style="width:100%;"

										    frameborder="0"
										    allowfullscreen="true">
										</iframe>
										</div>
										<?php
									}
							if($target[0]['target'] == "google")
							{
								?>
								<div id="des-container">
								<div id="YTplayer" title="<?php echo $target[0]["broadcast_id"];?>"></div>
								</div>
								<script>
							      // 2. This code loads the IFrame Player API code asynchronously.
							      var tag = document.createElement('script');

							      tag.src = "https://www.youtube.com/iframe_api";
							      var firstScriptTag = document.getElementsByTagName('script')[0];
							      firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

							      // 3. This function creates an <iframe> (and YouTube player)
							      //    after the API code downloads.
							      var player;
							      function onYouTubeIframeAPIReady() {
							        player = new YT.Player('YTplayer', {
							          height: '300',
							          width: '640',

							          videoId: '<?php echo $target[0]["broadcast_id"];?>',
							           playerVars: { 'autoplay': 0},
							          events: {
							           // 'onReady': onPlayerReady,
							            'onStateChange': onPlayerStateChange
							          }
							        });
							      }

							      // 4. The API will call this function when the video player is ready.
							      function onPlayerReady(event) {
							        event.target.playVideo();
							      }

							      // 5. The API calls this function when the player's state changes.
							      //    The function indicates that when playing a video (state=1),
							      //    the player should play for six seconds and then stop.
							      var done = false;
							      function onPlayerStateChange(event) {
							        if (event.data == YT.PlayerState.PLAYING && !done) {
							          setTimeout(stopVideo, 6000);
							          done = true;
							        }
							      }
							      function stopVideo() {
							        player.stopVideo();
							      }
							    </script>


								<?php
							}
							if($target[0]['target'] == "facebook")
							{
								$userdata = $this->session->userdata('fbUser');
								$fbTokenNew = $this->session->userdata('fb_token');
								if(!empty($userdata) && $target[0]["shareon"] == "timeline")
								{
									$facebookArray = array('app_id' => '201130880631964', 'app_secret' => '49e984459f5d67695b85b443dc879d82',  'default_graph_version' => 'v2.6');
									$fbobj = new Facebook\Facebook($facebookArray);
									$createLiveVideo = $fbobj->get('/me/live_videos',$fbTokenNew);
									$graphNode = $createLiveVideo->getGraphEdge()->asArray();
									foreach($graphNode as $b)
									{
										if($target[0]['broadcast_id'] == $b['id'])
										{
											echo '<div id="des-container">';
											preg_match('/src="([^"]+)"/', $b['embed_html'], $match);
											$url = $match[1];
											if($target[0]["shareon"] == "timeline")
											{
												$url = str_replace("&width=1280","",$url);
											}
											?>
											<iframe id="twitchPlayer"
											    src="<?php echo $url;?>"
											    frameborder="0"
											    allowfullscreen="true">
											</iframe>
											<?php
											echo '</div>';
										}
									}
								}
								elseif(!empty($userdata) && $target[0]["shareon"] == "page")
								{
									if(!empty($userdata))
									{
										$pages = $this->session->userdata('dfff');
										$token = "";
										$pageId = $target[0]['page_id'];
										if(sizeof($pages)>0)
										{
											foreach($pages['data'] as $key=>$body)
											{
												if($body['id'] == $pageId)
												{
													$token = $body['access_token'];
												}
											}
										}
										if($token != "")
										{
											$urlll = "https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id=201130880631964&client_secret=49e984459f5d67695b85b443dc879d82&fb_exchange_token=".$token."&scope=publish_pages,manage_pages";
						 					$fch = curl_init();
											curl_setopt($fch,CURLOPT_URL, $urlll);
											curl_setopt($fch, CURLOPT_FAILONERROR, true);
											curl_setopt($fch, CURLOPT_FOLLOWLOCATION, true);
											curl_setopt($fch, CURLOPT_HEADER, FALSE);   // we want headers
											    // we don't need body
											curl_setopt($fch, CURLOPT_RETURNTRANSFER,1);
											//curl_setopt($fch, CURLOPT_TIMEOUT_MS, 300); //timeout in seconds
											curl_setopt($fch, CURLOPT_SSL_VERIFYHOST, false);
											curl_setopt($fch, CURLOPT_SSL_VERIFYPEER, false);
											curl_setopt($fch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
											$result = curl_exec($fch);
											$httpcode = curl_getinfo($fch, CURLINFO_HTTP_CODE);
											curl_close($fch);

						 					$tokenArray = json_decode($result,TRUE);
											$facebookArray = array('app_id' => '201130880631964', 'app_secret' => '49e984459f5d67695b85b443dc879d82',  'default_graph_version' => 'v2.6');
											$fbobj = new Facebook\Facebook($facebookArray);
											if($target[0]["shareon"] == "page")
											{
												$createLiveVideo = $fbobj->get('/'.$pageId.'/live_videos',$tokenArray['access_token']);
											}

											$graphNode = $createLiveVideo->getGraphEdge()->asArray();
											foreach($graphNode as $b)
											{
												if($target[0]['broadcast_id'] == $b['id'])
												{
													echo '<div id="des-container">';
													preg_match('/src="([^"]+)"/', $b['embed_html'], $match);
													$url = $match[1];
													if($target[0]["shareon"] == "page")
													{
														$url = str_replace("&width=0","",$url);
													}
													?>
													<iframe id="twitchPlayer"
													    src="<?php echo $url;?>"
													    frameborder="0"
													    allowfullscreen="true">
													</iframe>
													<?php
													echo '</div>';
												}
											}
										}
									}
								}


								?>




								<?php
							}
							?>
							</div>


					</div>

					<!-- </div> -->
	            </div>

				</div>
			</div>
			</div>
				</div>
				<div class="card-footer">
					<button class="btn btn-sm btn-primary" type="submit">Update</button>
						<button class="btn btn-sm btn-danger" type="reset">Reset</button>
						</div>
						</form>
			</div>
		</div>
	</div>
</main>
