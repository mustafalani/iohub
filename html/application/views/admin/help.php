<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>

<!-- ========= Content Wrapper Start ========= -->
<main class="main">
        <!-- Breadcrumb-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Home</a>
          </li>
          <li class="breadcrumb-item active">Help</li>
        </ol>
        <div class="container-fluid">
        <div class="animated fadeIn">
        					<div class="card">
				<div class="card-body">
															<div class="row">
																	<div class="col-lg-8">
																			<h1 class="content-max-width">iohub Help</h1>
																	</div>
															</div>
													</header>
													<!-- Main content -->
													<div class="content container-fluid" style="padding-top: 0px;">
															<div class="row">
																	<div class="col-lg-8">
																			<section class="content-max-width">
																			<h2 class="page-header first"><a href="#getting-started">GETTING STARTED</a></h2>
																			<ul class="bring-up">
																					<li><a href="#dashboard">What Is The Dashboard Page? And How Can I Use It?</a></li>
																			</ul>
																			<h2 class="page-header first"><a href="#configurations">CONFIGURATIONS</a></h2>
																			<ul class="bring-up">
																					<li><a href="#encoders">How Can I Add And Configure a New Encoder?</a></li>
																					<li><a href="#publishers">How Can I Add and Configure a New Publisher?</a></li>
																					<li><a href="#gateway">How Can I Add and Configure a New NDI Gateway?</a></li>
																					<li><a href="#presets">How Can I Add a New Encoding Preset?</a></li>
																			</ul>
																			<h2 class="page-header first"><a href="#channels">CHANNELS</a></h2>
																			<ul class="bring-up">
																					<li><a href="#channels">What Is a Channel And How Can I Start a New Channel?</a></li>
																			</ul>
																			<h2 id="getting-started">GETTING STARTED</h2>
																			<section id="dashboard">
																				<h4>What Is The Dashboard Page? And How Can I Use It?</h4>
																			<p>The Dashboard page contains information to help you configure your iohub setup and to provide a quick overview of the system status. The Dashboard also provides
																				summary information about your live assets i.e. Channels, Applications and Targets.<p>
																					<div class="box box-solid">
																						<div class="box-header with-border" style="color: #6a6c6f;">
																							<h3 class="box-title">Production</h3>
																							<div class="box-tools pull-right">
																								<button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
																								</button>
																								<button type="button" id="production" class="btn btn-default btn-sm wowzashowhide"><i class="fa fa-times"></i>
																								</button>
																							</div>
																						</div>
																						<!-- /.box-header -->
																						<div class="box-body" style="background-color: rgb(232, 245, 249); color: rgb(29, 157, 224);">
																							<p>The Production section provides information about the capacity and an overview on your Channels <i class="fa fa-random" aria-hidden="true"></i> , Applications & Targets <i class="fa fa-bolt" aria-hidden="true"></i> , Playlists <i class="fa fa-list" aria-hidden="true"></i> and Schedules <i class="fa fa-clock-o" aria-hidden="true"></i><p>
																						</div>
																					</div>
																					<div class="box box-solid">
																						<div class="box-header with-border" style="color: #6a6c6f;">
																							<h3 class="box-title">Hosting</h3>
																							<div class="box-tools pull-right">
																								<button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
																								</button>
																								<button type="button" id="production" class="btn btn-default btn-sm wowzashowhide"><i class="fa fa-times"></i>
																								</button>
																							</div>
																						</div>
																						<!-- /.box-header -->
																						<div class="box-body" style="background-color: rgb(232, 245, 249); color: rgb(29, 157, 224);">
																							<p>The Hosting section provides an overview on your iohub hosting server.<p>
																						</div>
																					</div>
																					<div class="box box-solid">
																						<div class="box-header with-border" style="color: #6a6c6f;">
																							<h3 class="box-title">Network</h3>
																							<div class="box-tools pull-right">
																								<button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
																								</button>
																								<button type="button" id="production" class="btn btn-default btn-sm wowzashowhide"><i class="fa fa-times"></i>
																								</button>
																							</div>
																						</div>
																						<!-- /.box-header -->
																						<div class="box-body" style="background-color: rgb(232, 245, 249); color: rgb(29, 157, 224);">
																							<p>The Neywrok section provides information about the overall network traffics the Inbound <i class="fa fa-arrow-circle-down"></i> and the Outbound <i class="fa fa-arrow-circle-up"></i><p>
																						</div>
																					</div>
																			</section>
																			<h2 id="configurations">CONFIGURATIONS</h2>
																			<div class="callout callout-danger" style="background: #fff!important;color: #373737!important;">
																				<h4 style="color: #c23321;">Note!</h4>
																				<p>Adding, Removing and Modifying System Resources Require Administrative Privileges.</p>
																				<p>Only Encoding Presets Can Be Added and Modified By Operators.</p>
																			</div>
																			<section id="encoders">
																				<h4>How Can I Add And Configure a New Encoder?</h4>
																				<p>Navigate to the <a href="/configuration">Configuration</a> page then Click on the Encoders tab.</p>
																				<img class="img-responsive pad" src="../assets/site/main/images/tutorial/ss/screenshot-encoders-1.png" alt="Photo" style="border: solid 1px #4597c4;">
																				<br>
																				<p>To add a New Encoder, click on <a href="/addEncoderes" style="float:unset!important;margin-left:0;"class="add-btn"><span><i class="fa fa-plus"></i> Encoder</span></a></p>
																				<p>A window requesting basic information for the new encoder (Name, IP Address, SSH Port, Encoder User Name and Password ) will pop up.</p>
																				<div class="callout callout-info" style="background: #fff!important;color: #373737!important;">
																					<h4 style="color: #0097bc;">Tip!</h4>
																					<p>All of this information can be edited later. Once it is filled in, click Save.</p>
																				</div>
																				<img class="img-responsive pad" src="../assets/site/main/images/tutorial/ss/screenshot-encoders-3.png" alt="Photo" style="border: solid 1px #4597c4;">
																				<br>
																				<div class="callout callout-info" style="background: #fff!important;color: #373737!important;">
																					<h4 style="color: #0097bc;">Tip!</h4>
																					<p>Enabling the Netdata Monitoring Tool Will Add The Encoder To The Dashboard Page.</p>
																					<p>Enabling The PC Output Will Add An HDMI Output To The Encoder's Outputs List When Creating Channels.</p>
																				</div>
																				<p>In the Hardware tab you can add upto three Decklink I/O cards. To add a new I/O card, select Blackmagic Design from the Hardware list
																						then select the installed Model from the Model list</p>
																				<img class="img-responsive pad" src="../assets/site/main/images/tutorial/ss/screenshot-encoders-4.png" alt="Photo" style="border: solid 1px #4597c4;">
																				<br>
																				<p>Click on the Inputs tab, then click <a style="float:unset!important;margin-left:0;"class="add-btn"><span><i class="fa fa-plus"></i> Input</span></a> to add an input from the previusly added Decklink I/O cards with whichever connection type you are using.</p>
																				<div class="callout callout-danger" style="background: #fff!important;color: #373737!important;">
																					<h4 style="color: #c23321;">Note!</h4>
																					<p>Inputs Will Only Appear In The Inputs List If The Selected I/O Cards Support That.</p>
																					<p>Refere To <a href="#supported-io-devices" style="color: #3c8dbc!important;">The List Of Supported</a> I/O Devices To See If Your Device is Supported.</p>
																				</div>
																				<p>Select the video and audio sources of the new added input.</p>
																				<img class="img-responsive pad" src="../assets/site/main/images/tutorial/ss/screenshot-encoders-5.png" alt="Photo" style="border: solid 1px #4597c4;">
																				<br>
																				<p>Click on the Outputs tab, then click <a style="float:unset!important;margin-left:0;"class="add-btn"><span><i class="fa fa-plus"></i> Output</span></a> to add an output from the previusly added Decklink I/O cards.</p>
																				<div class="callout callout-danger" style="background: #fff!important;color: #373737!important;">
																					<h4 style="color: #c23321;">Note!</h4>
																					<p>Outputs Will Only Appear In The Outputs List If The Selected I/O Cards Support That.</p>
																					<p>Refere To <a href="#supported-io-devices" style="color: #3c8dbc!important;">The List Of Supported</a> I/O Devices To See If Your Device is Supported.</p>
																				</div>
																				<p>Select the video destination of the new added output and the desired output format.</p>
																				<img class="img-responsive pad" src="../assets/site/main/images/tutorial/ss/screenshot-encoders-6.png" alt="Photo" style="border: solid 1px #4597c4;">
																				<br>
																				<div class="callout callout-danger" style="background: #fff!important;color: #373737!important;">
																					<h4 style="color: #c23321;">Note!</h4>
																					<p>After Adding A New Encoder, It Will Be Lsited In The Encoders List. Each New Encoder Must Be Paired With iohub Automation Controller Before It Can Be Used.</p>
																				</div>
																				<p>To pair an encoder, click on the encoder name, this will open the encoder editing page.</p>
																				<img class="img-responsive pad" src="../assets/site/main/images/tutorial/ss/screenshot-encoders-7.png" alt="Photo" style="border: solid 1px #4597c4;">
																				<br>
																				<p>Make sure that the encoder is running, then click on the <a style="color: #3c8dbc!important;">Pair </a>button.</p>
																				<img class="img-responsive pad" src="../assets/site/main/images/tutorial/ss/screenshot-encoders-8.png" alt="Photo" style="border: solid 1px #4597c4;">
																				<br>
																				<p>If pairing the encoder is successful it will return a Pair Token.</p>
																				<img class="img-responsive pad" src="../assets/site/main/images/tutorial/ss/screenshot-encoders-9.png" alt="Photo" style="border: solid 1px #4597c4;">
																				<br>
																				<p>The encoder is now ready to use.</p>
																				<img class="img-responsive pad" src="../assets/site/main/images/tutorial/ss/screenshot-encoders-10.png" alt="Photo" style="border: solid 1px #4597c4;">
																				<br>
																			</section>
																			<section id="publishers">
																			  <h4>How Can I Add and Configure a New Publisher?</h4>
																			  <p>Navigate to the <a href="/configuration">Configuration</a> page then Click on the Publishers tab.</p>
																			  <img class="img-responsive pad" src="../assets/site/main/images/tutorial/ss/screenshot-publisher-1.png" alt="Photo" style="border: solid 1px #4597c4;">
																			  <br>
																			  <p>To add a New Publisher, click on <a href="/createwowza" style="float:unset!important;margin-left:0;"class="add-btn"><span><i class="fa fa-plus"></i> Publisher</span></a></p>
																			  <p>A window requesting information for the new publisher (Name, IP Address, Default Stream Name, RTMP Port, License, ..etc) will pop up.</p>
																				<div class="callout callout-info" style="background: #fff!important;color: #373737!important;">
																					<h4 style="color: #0097bc;">Tip!</h4>
																					<p>All of this information can be edited later. Once it is filled in, click Save.</p>
																				</div>
																			  <img class="img-responsive pad" src="../assets/site/main/images/tutorial/ss/screenshot-publisher-3.png" alt="Photo" style="border: solid 1px #4597c4;">
																			  <br>
																			  <div class="callout callout-info" style="background: #fff!important;color: #373737!important;">
																			    <h4 style="color: #0097bc;">Tip!</h4>
																			    <p>Enabling the Netdata Monitoring Tool Will Add The Publisher To The Dashboard Page.</p>
																			  </div>
																			  <div class="callout callout-danger" style="background: #fff!important;color: #373737!important;">
																			    <h4 style="color: #c23321;">Note!</h4>
																			    <p>After Adding A New Publisher, It Will Be Lsited In The Publishers List.</p>
																			  </div>
																			  <p>The publisher is now ready to use.</p>
																			  <img class="img-responsive pad" src="../assets/site/main/images/tutorial/ss/screenshot-publisher-4.png" alt="Photo" style="border: solid 1px #4597c4;">
																			  <br>
																			</section>
																			<section id="gateway">
																			  <h4>How Can I Add and Configure a NDI Gateway?</h4>
																			  <p>Navigate to the <a href="/configuration">Configuration</a> page then Click on the NDI Gateway tab.</p>
																			  <img class="img-responsive pad" src="../assets/site/main/images/tutorial/ss/screenshot-ndi-gw-1.png" alt="Photo" style="border: solid 1px #4597c4;">
																			  <br>
																			  <p>To add a New Gateway, click on <a href="/addgateways" style="float:unset!important;margin-left:0;"class="add-btn"><span><i class="fa fa-plus"></i> Gateway</span></a></p>
																			  <p>A window requesting information for the new publisher (Name, IP Address, SSH Port, User Name & Password) will pop up.</p>
																				<div class="callout callout-info" style="background: #fff!important;color: #373737!important;">
																					<h4 style="color: #0097bc;">Tip!</h4>
																					<p>All of this information can be edited later. Once it is filled in, click Save.</p>
																				</div>
																			  <img class="img-responsive pad" src="../assets/site/main/images/tutorial/ss/screenshot-ndi-gw-3.png" alt="Photo" style="border: solid 1px #4597c4;">
																			  <br>
																			  <div class="callout callout-info" style="background: #fff!important;color: #373737!important;">
																			    <h4 style="color: #0097bc;">Tip!</h4>
																			    <p>Enabling the Netdata Monitoring Tool Will Add The Gateway To The Dashboard Page.</p>
																			  </div>
																			  <div class="callout callout-danger" style="background: #fff!important;color: #373737!important;">
																			    <h4 style="color: #c23321;">Note!</h4>
																			    <p>After Adding A New NDI Gateway, It Will Be Lsited In The NDI Gateways List. Each New Gateway Must Be Paired With iohub Automation Controller Before It Can Be Used.</p>
																			  </div>
																			  <p>To pair an NDI Gateway, click on it's name in the list, this will open the NDI Gateway editing page.</p>
																			  <img class="img-responsive pad" src="../assets/site/main/images/tutorial/ss/screenshot-ndi-gw-5.png" alt="Photo" style="border: solid 1px #4597c4;">
																			  <br>
																			  <p>Make sure that the NDI Gateway is running, then click on the <a style="color: #3c8dbc!important;">Pair </a>button.</p>
																			  <img class="img-responsive pad" src="../assets/site/main/images/tutorial/ss/screenshot-encoders-8.png" alt="Photo" style="border: solid 1px #4597c4;">
																			  <br>
																			  <p>If pairing the NDI Gateway is successful it will return a Pair Token.</p>
																			  <img class="img-responsive pad" src="../assets/site/main/images/tutorial/ss/screenshot-encoders-9.png" alt="Photo" style="border: solid 1px #4597c4;">
																			  <br>
																			  <p>The Gateway is now ready to use.</p>
																			  <img class="img-responsive pad" src="../assets/site/main/images/tutorial/ss/screenshot-ndi-gw-4.png" alt="Photo" style="border: solid 1px #4597c4;">
																			  <br>
																			</section>
																			<section id="presets">
																			  <h4>How Can I Add a New Encoding Preset?</h4>
																			  <p>Navigate to the <a href="/configuration">Configuration</a> page then Click on the Encoding Presets tab.</p>
																			  <img class="img-responsive pad" src="../assets/site/main/images/tutorial/ss/screenshot-preset-1.png" alt="Photo" style="border: solid 1px #4597c4;">
																			  <br>
																			  <p>To add a New Preset, click on <a href="/createtemplate" style="float:unset!important;margin-left:0;"class="add-btn"><span><i class="fa fa-plus"></i> Preset</span></a></p>
																			  <p>A window requesting information for the new preset (Name, Video, Audio ..etc) will pop up.</p>
																				<div class="callout callout-info" style="background: #fff!important;color: #373737!important;">
																					<h4 style="color: #0097bc;">Tip!</h4>
																					<p>All of this information can be edited later. Once it is filled in, click Save.</p>
																				</div>
																			  <img class="img-responsive pad" src="../assets/site/main/images/tutorial/ss/screenshot-preset-3.png" alt="Photo" style="border: solid 1px #4597c4;">
																			  <br>
																			  <div class="callout callout-info" style="background: #fff!important;color: #373737!important;">
																			    <h4 style="color: #0097bc;">Tip!</h4>
																			    <p>You Can Create Different Presets For Different Streams. A Preset Can Be For Video Encoding Only, Or For Audio Encoding Only, Or For Both.</p>
																			  </div>
																			  <p>To enable video encoding, check the <a style="color: #3c8dbc!important;">Video </a>box.</p>
																			  <p>Select the desired video codec from the <a style="color: #3c8dbc!important;">Codec </a>drop down list</p>
																			  <p>Select the resolution from the <a style="color: #3c8dbc!important;">Resolution </a>drop down list</p>
																			  <p>Specify the video bitrate in <a style="color: #3c8dbc!important;">kbps </a>in the <a style="color: #3c8dbc!important;">Bitrate </a>field</p>
																			  <p>Specify the framerate in <a style="color: #3c8dbc!important;">FPS </a>in the <a style="color: #3c8dbc!important;">Framerate </a>field</p>
																			  <p>Specify the minimum bitrate in <a style="color: #3c8dbc!important;">kbps </a>in the <a style="color: #3c8dbc!important;">Min. Bitrate </a>field</p>
																			  <p>Specify the maximum bitrate in <a style="color: #3c8dbc!important;">kbps </a>in the <a style="color: #3c8dbc!important;">Max. Bitrate </a>field</p>
																			  <div class="callout callout-info" style="background: #fff!important;color: #373737!important;">
																			    <h4 style="color: #0097bc;">Tip!</h4>
																			    <p>Min. & Max. Bitrate are optional, they can be used to keep the stream's bitrate within certain bounds.</p>
																			  </div>
																			  <div class="callout callout-info" style="background: #fff!important;color: #373737!important;">
																			    <h4 style="color: #0097bc;">Tip!</h4>
																			    <p>Advanced Video Encoding contains more settings for the encoding preset, you can enable the Advanced Video Encoding and specify one or more of the desired settings, if you don't specify one of these settings it will not be considered or it will use its default value</p>
																			  </div>
																			  <p>Select the preset from the <a style="color: #3c8dbc!important;">Preset </a>drop down list, default is <a style="color: #3c8dbc!important;">"medium"</a>.</p>
																			  <p>Select the profile from the <a style="color: #3c8dbc!important;">Profile </a>drop down list.</p>
																			  <p>Specify the buffer size in <a style="color: #3c8dbc!important;">kbps </a>in the <a style="color: #3c8dbc!important;">Buffer Size  </a>field.</p>
																			  <p>Specify the Group Of Picture size in <a style="color: #3c8dbc!important;">Frames </a>in the <a style="color: #3c8dbc!important;">GOP </a>field.</p>
																			  <p>Specify the keyframe interval size in <a style="color: #3c8dbc!important;">Seconds </a>in the <a style="color: #3c8dbc!important;">Keyframe Interval </a>field.</p>
																			  <p>To enable audio encoding, check the <a style="color: #3c8dbc!important;">Audio </a>box.</p>
																			  <p>Select the desired audio codec from the <a style="color: #3c8dbc!important;">Codec </a>drop down list</p>
																			  <p>Select the number of audio channels from the <a style="color: #3c8dbc!important;">Channels </a>drop down list</p>
																			  <p>Select the audio bitrate from the <a style="color: #3c8dbc!important;">Bitrate </a>drop down list</p>
																			  <p>Select the sample rate from the <a style="color: #3c8dbc!important;">Sample Rate </a>drop down list</p>
																			  <div class="callout callout-info" style="background: #fff!important;color: #373737!important;">
																			    <h4 style="color: #0097bc;">Tip!</h4>
																			    <p>Advanced Audio Encoding contains more settings for the encoding preset, you can enable the Advanced Audio Encoding and specify one or more of the desired settings, if you don't specify one of these settings it will not be considered or it will use its default value</p>
																			  </div>
																			  <p>Adjust the audio gain in <a style="color: #3c8dbc!important;">dB </a> from the <a style="color: #3c8dbc!important;">Audio Gain </a> slider, default is <a style="color: #3c8dbc!important;">"0dB"</a>.</p>
																			  <p>Adjust the audio delay in <a style="color: #3c8dbc!important;">Milliseconds </a> from the <a style="color: #3c8dbc!important;">Delay </a> filed, default is <a style="color: #3c8dbc!important;">"0"</a>.</p>
																			  <div class="callout callout-danger" style="background: #fff!important;color: #373737!important;">
																			    <h4 style="color: #c23321;">Note!</h4>
																			    <p>After Adding A New Preset, It Will Be Listed In The Presets List.</p>
																			  </div>
																			  <p>The Preset is now ready to use.</p>
																			  <img class="img-responsive pad" src="../assets/site/main/images/tutorial/ss/screenshot-preset-4.png" alt="Photo" style="border: solid 1px #4597c4;">
																			  <br>
																			</section>
																			<section id="channels">
																				<h2 id="channels">CHANNELS</h2>
																			  <h4>What Is A Channel And How Can I Start A New Channel?</h4>
																			  <p>A channel is a process that takes an input stream to create an output stream. Channel's input and output can be physical signal like SDI and HDMI, or live stream like RTMP, MPEG-TS and SRT. For more information about inputs/outputs Please refer to the Channels Input->Output combinations.</p>
																			  <p>To add a new channel, navigate to the <a href="/channels">Channels</a> page then Click on <a href="/createchannel" style="float:unset!important;margin-left:0;"class="add-btn"><span><i class="fa fa-plus"></i> Channel</span></a></p>
																				<p>A window requesting information for the new channel (Name, Input and Output) will pop up.</p>
																				<p>Select an input from the <a style="color: #3c8dbc!important;">Channel Input </a>list and an output from the <a style="color: #3c8dbc!important;">Channel Output </a>list.</p>
																				<div class="callout callout-info" style="background: #fff!important;color: #373737!important;">
																			    <h4 style="color: #0097bc;">Tip!</h4>
																			    <p>SDI and HDMI Inputs will appear in the <span style="color: #3c8dbc!important;">Channel Input </span>list starting with the encoder name followed by the input label that is preconfigured in the encoder configuration. For example if the encoder name is <span style="color: #3c8dbc!important;">XX</span> and the input label is <span style="color: #3c8dbc!important;">YY</span> the input will be listed as <span style="color: #3c8dbc!important;">XX->YY</span>.</p>
																					<p>SDI and HDMI Outputs will appear in the <span style="color: #3c8dbc!important;">Channel Output </span>list starting with the encoder name followed by the output label that is preconfigured in the encoder configuration. For example if the encoder name is <span style="color: #3c8dbc!important;">XX</span> and the output label is <span style="color: #3c8dbc!important;">ZZ</span> the output will be listed as <span style="color: #3c8dbc!important;">XX->ZZ</span>.</p>
																			  </div>
																				<div class="callout callout-info" style="background: #fff!important;color: #373737!important;">
																			    <h4 style="color: #0097bc;">Tip!</h4>
																					<p>Enabling the Schedule will add the channel to the <a href="/schedule" style="color: #3c8dbc!important;">Schedule</a> list.</p>
																			  </div>
																			</section>
																			</section>
																	</div>

															</div>
													</div>
													<!-- /.content -->
											</article>
					<!-- ========= article ends here ========= -->
					</div>
				</div>
				<!-- ========= Section One End ========= -->
			</div>
		</div>
	</div>
</div>
	<!-- ========= Main Content End ========= -->
</main>
<!-- ========= Content Wrapper End ========= -->
