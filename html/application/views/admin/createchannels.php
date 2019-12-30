<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<style type="text/css">
.input-append .add-on:last-child, .input-append .btn:last-child, .input-append .btn-group:last-child > .dropdown-toggle {

    -webkit-border-radius: 0 4px 4px 0;
    -moz-border-radius: 0 4px 4px 0;
    border-radius: 0 4px 4px 0;

}
.input-append .add-on, .input-prepend .add-on {

    display: inline-block;
    width: auto;
    height: 27px;
    min-width: 16px;
    padding: 4px 5px;
    font-size: 14px;
    font-weight: normal;
    line-height: 20px;
    text-align: center;
    text-shadow: 0 1px 0 #ffffff;
    background-color: #eeeeee;
    border: 1px solid #ccc;
    position: absolute;
top: 27px;
z-index: 9999;

}
.input-append input, .input-prepend input, .input-append select, .input-prepend select, .input-append .uneditable-input, .input-prepend .uneditable-input {

    position: relative;
    margin-bottom: 0;
    *margin-left: 0;
    vertical-align: top;
    -webkit-border-radius: 0 4px 4px 0;
    -moz-border-radius: 0 4px 4px 0;
    border-radius: 0 4px 4px 0;

}
.input-append.date .add-on i, .input-prepend.date .add-on i {

    display: block;
    cursor: pointer;
    width: 16px;
    height: 16px;

}
	div.dropdown-menu li > a {

    display: block;
    padding: 3px 20px;
    clear: both;
    font-weight: normal;
    line-height: 20px;
    color: #333333;
    white-space: nowrap;

}
.bootstrap-datetimepicker-widget > ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
}
[class^="icon-"], [class*=" icon-"] {

    display: inline-block;
    width: 14px;
    height: 14px;
    margin-top: 1px;
    *margin-right: .3em;
    line-height: 14px;
    vertical-align: text-top;
    background-image: url("assets/site/main/img/glyphicons-halflings.png");
    background-position: 14px 14px;
    background-repeat: no-repeat;

}
.bootstrap-select .dropdown-menu > li > a {
    color: #777 !important;
}
.bootstrap-select .dropdown-menu > li:hover > a {
    color: #FFF !important;
}
.bootstrap-select .dropdown-menu > li.selected > a {
    color: #FFF !important;
}

.icon-chevron-up {

    background-position: -288px -120px;

}
.icon-chevron-down {

    background-position: -313px -119px;

}
.icon-calendar {
    background-position: -192px -120px;
}
.icon-time {
    background-position: -48px -24px;
}
div.dropdown-menu li.picker-switch > a:hover, .dropdown-menu li.picker-switch > a:focus, .dropdown-submenu:hover > a {

    color: #ffffff;
    text-decoration: none;
    background-color: #0081c2;
    background-image: -moz-linear-gradient(top, #0088cc, #0077b3);
    background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#0088cc), to(#0077b3));
    background-image: -webkit-linear-gradient(top, #0088cc, #0077b3);
    background-image: -o-linear-gradient(top, #0088cc, #0077b3);
    background-image: linear-gradient(to bottom, #0088cc, #0077b3);
    background-repeat: repeat-x;
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff0088cc', endColorstr='#ff0077b3', GradientType=0);

}
</style>
<main class="main">
  	   <!-- Breadcrumb-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo site_url();?>">Home</a>
        </li>
        <li class="breadcrumb-item active"><a href="<?php echo site_url();?>channels">Channels</a></li>
        <li class="breadcrumb-item active">New Channel</li>
      </ol>
      <div class="container-fluid">
      	<div class="animated fadeIn">
           <div class="card">
             <form id="wowza-form" class="action-table" method="post" action="<?php echo site_url();?>admin/saveChannel" enctype="multipart/form-data">
             <div class="card-header">Add New Channel</div>
				<div class="card-body">
				<div class="row">
                        <!-- ========= Section One Start ========= -->
                        <div class="col-lg-12 col-12-12">

      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <div class="content-box config-contentonly">
                                <div class="config-container">
                                    <div class="row">
                        <div class="col-lg-6 p-t-15">
                            <div class="form-group col-lg-11">
                                <div class="row">
                                    <label>Channel Name <span class="mndtry">*</span></label>
                                    <input type="text" class="form-control" name="channel_name" id="channel_name" required="true"/>
                                </div>
                            </div>
                            <div class="form-group col-lg-11">
                                <div class="row">
                                    <label>Encoders <span class="mndtry">*</span></label>

                                   <select class="form-control selectpicker" name="channelEncoders" id="channelEncoders" required="true">
                                        <option value="">- Select Encoder -</option>
                                        <?php
                                        $counterInputs=1;
                                        if(sizeof($encoders)>0)
			                        	{
			                        		$encoder_count=1;
											foreach($encoders as $encode)
											{
											?>
												<option id="enc_<?php echo $encode['id'];?>" tabindex="<?php echo $counterInputs;?>" label="phyinput" value="phyinput_<?php echo $encode['id'];?>"><?php echo $encode['encoder_name'];?></option>
											<?php
											$counterInputs++;
											}
										}
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-11">
                                <div class="row form-group ">
                                    <label> Channel Input <span class="mndtry">*</span></label>
                                    <input type="hidden" id="encid" name="encid" value="0"/>
                                    <select class="form-control selectpicker" name="channelInput" id="channelInput" required="true">
                                        <option value="">- Select Input -</option>
                                        <?php
                                        $channelInputs = $this->common_model->getChannelInputs();
                                        if(sizeof($channelInputs)>0)
                                        {
                                        	$counterInputs1=1;
											foreach($channelInputs as $input)
											{
												?>
												<option tabindex="<?php echo $counterInputs1;?>" label="virinput" value="virinput_<?php echo $input['id'];?>"><?php echo $input['item'];?></option>
												<?php
												$counterInputs1++;
											}
										}
                                        ?>
                                    </select>
                                </div>
                                <div class="row form-group audioch">
                                	<br/>
                                	<label>Audio Channel</label>
                                	 <select class="form-control selectpicker" name="sdi_audio_channel" id="sdi_audio_channel">
                                        <option value="0">- Select Channel -</option>
                                        <?php
											if(sizeof($audiochannels)>0)
											{
												foreach($audiochannels as $audio)
												{
													if($audio['value'] != 6)
													{
														echo '<option value="'.$audio['value'].'">'.$audio['name'].'</option>';
													}
												}
											}
										?>
                                    </select>
                                </div>
                                <div class="row form-group check-input ips" style="padding: 20px;">
                                	<br/>
                                	<div class="boxes">
                                        <input type="checkbox" id="isIPAddress" name="isIPAddress">
                                        <label for="isIPAddress"></label>
                                    </div>
                                    <label style="padding-left: 20px;line-height:15px;"> Remote IP Addresses (comma seprated)</label>
                                    <input type="text" class="form-control" placeholder="" name="ip_addresses_comma" id="ip_addresses_comma" disabled="disabled"/>
                                </div>
                                <div class="row form-group ndi">
                                <br/>
                                    <label> NDI Source <a id="find_NDISources" style="margin-left: 5px !important;" href="javascript:void(0);"><i class="fa fa-refresh"></i></a></label>
                                    <select class="form-control selectpicker" id="channel_ndi_source" name="channel_ndi_source">
                                    	<optin value="0">-- No NDI Sources Found --</optin>

                                    </select>

                                </div>
								 <div class="row form-group hls">
                                <br/>
                                    <label> M3U8 URL</label>
                                    <input type="text" class="form-control" placeholder="" name="input_hls_url" id="input_hls_url"/>
                                </div>
                                <div class="row form-group rtmp">
                                <br/>
                                    <label> RTMP URL</label>
                                    <input type="text" class="form-control" placeholder="rtmp://[username[:password]@]ip[:port]/<appName>/<stream_name>" name="input_rtmp_url" id="input_rtmp_url"/>
                                </div>

                                <div class="row form-group mpeg-rtp">
                                <br/>
                                    <label>MPEG TS - RTP</label>
                                    <input type="text" class="form-control" placeholder="rtp://@<StreamIP>:<Port>/?serviceId=<ProgramPid>&videoPid=<VideoStreamPid>&audioPids=<AudioStreamsPids>" name="input_mpeg_rtp" id="input_mpeg_rtp"/>
                                </div>

                                <div class="row form-group mpeg-udp">
                                 <br/>
                                    <label>MPEG TS - UDP</label>
                                    <input type="text" class="form-control" placeholder="udp://@<StreamIP>:<Port>/?serviceId=<ProgramPid>&videoPid=<VideoStreamPid>&audioPids=<AudioStreamsPids>" name="input_mpeg_udp" id="input_mpeg_udp"/>
                                </div>

                                <div class="row form-group mpeg-srt">
                                <br/>
                                    <label>MPEG TS - SRT</label>
                                    <input type="text" class="form-control" placeholder="srt://<ip>:<port>" name="input_mpeg_srt" id="input_mpeg_srt"/>
                                </div>
                            </div>
                            <div class="form-group col-lg-11">
                                <div class="row form-group ">
                                    <label>Channel Output <span class="mndtry">*</span></label>
                                    <select class="form-control selectpicker" name="channelOutpue" id="channelOutpue" required="true">
                                        <option value="">- Select Output -</option>
										<?php
										 $channelOutput = $this->common_model->getChannelOutput();
                                        if(sizeof($channelOutput)>0)
                                        {
                                        	$counterOutput=1;
											foreach($channelOutput as $output)
											{
												?>
												<option tabindex="<?php echo $counterOutput;?>" label="viroutput" value="viroutput_<?php echo $output['id'];?>"><?php echo $output['item'];?></option>
												<?php
												$counterOutput++;
											}
										}
										?>

                                    </select>
                                </div>

                                <div class="row form-group ndi-name">
                                <br/>
                                    <label>NDI Name</label>
                                    <input type="text" class="form-control" name="ndi_name" id="ndi_name">
                                </div>

                                <div class="row form-group ch-applications">
                                 <br/>
                                    <label>Application</label>
                                    <select class="form-control selectpicker" id="channel_apps" name="channel_apps">
                                        <option value="">- Select Application -</option>
                                        <?php


											{
												foreach($apps as $app)
												{
													echo '<option id="'.$app['wowza_path'].'" value="'.$app['id'].'">'.$app['application_name'].'</option>';
												}
												echo '<option id="-2" value="-2">Custom</option>';
											}
										?>
                                    </select>
                                   </div>

                                    <div class="row form-group out-rtmp-url">
                                    <br>
                                    	<label>RTMP Stream URL</label>
                                    	<input type="text" class="form-control" name="output_rtmp_url" id="output_rtmp_url"/>
                                    </div>
                                    <div class="row form-group out-rtmp-key">
                                    <br/>
                                    	<label>RTMP Stream Key</label>
                                    	<input type="text" class="form-control" name="output_rtmp_key" id="output_rtmp_key"/>
                                    </div>


                                <div class="row form-group out-mpeg-rpt">
                                <br/>
                                    <label>MPEG TS - RTP</label>
                                    <input type="text" class="form-control" placeholder="rtp://@<StreamIP>:<Port>/?serviceId=<ProgramPid>&videoPid=<VideoStreamPid>&audioPids=<AudioStreamsPids>" name="output_mpeg_rtp" id="output_mpeg_rtp"/>
                                </div>
                                <div class="row form-group out-mpeg-udp">
                                <br/>
                                    <label>MPEG TS - UDP</label>
                                    <input type="text" class="form-control" placeholder="udp://@<StreamIP>:<Port>/?serviceId=<ProgramPid>&videoPid=<VideoStreamPid>&audioPids=<AudioStreamsPids>" name="output_mpeg_udp" id="output_mpeg_udp"/>
                                </div>
                                <div class="row form-group out-mpeg-srt">
                                <br/>
                                    <label>MPEG TS - SRT</label>
                                    <input type="text" class="form-control" placeholder="srt://<ip>:<port>" name="output_mpeg_srt" id="output_mpeg_srt"/>
                                </div>
                                 <div class="boxes row form-group ch-authentication">
                                    <br/>
                                        <input type="checkbox" id="channel-auth" name="channel-auth">
                                        <span for="box-2">Use Authentication</span>
                                    </div>

                                    <div class="row form-group ch-uname">
                                    <br>
                                    	<label>Username</label>
                                    	<input type="text" class="form-control" name="auth_uname" id="auth_uname"/>
                                    </div>

                                    <div class="row form-group ch-pass">
                                    <br/>
                                    	<label>Password</label>
                                    	<input type="text" class="form-control" name="auth_pass" id="auth_pass"/>
                                    </div>
                            </div>
                            <div class="form-group col-lg-11 ch-profile">
                                <div class="row">
                                    <label> Encoding Presets</label>
                                    <select class="form-control selectpicker" name="encoding_profile" id="encoding_profile">
                                        <option value="0">- Select Preset -</option>
                                        <?php
											if(sizeof($profiles)>0)
											{
												foreach($profiles as $profile)
												{
													echo '<option value="'.$profile['id'].'">'.$profile['template_name'].'</option>';
												}
											}
										?>
                                    </select>
                                </div>
                            </div>
                        </div>

							<div class="col-lg-6 p-t-15">
                <div class="form-group col-lg-11" style="margin-bottom: 10px;">
                                <div class="row form-group check-input">
                                <div class="boxes">
										<input class="checkbox" id="enablechannelSchedule" name="enablechannelSchedule" type="checkbox">
                                        <label for="enablechannelSchedule"></label>
									</div>
                                    <label style="padding-left: 20px;line-height:15px;">Enable Schedule</label>

                                </div>
                            </div>
                            <div class="form-group col-lg-11 pdleft" style="margin-bottom: 40px;">
                                <div class="col-md-12 pdleft">
                            		 <label>Start Time</label>
                                 <div class="col-md-12" style="padding:0;margin-bottom:1rem;">
                                   <div id="datetimepicker_schedule_start_time" class="input-append date">
                                     <div class="input-group">
                                       <div class="input-group-prepend">
                                         <span class="input-group-text">
                                           <i class="icon-calendar"></i>
                                         </span>
                                       </div>
                                       <input id="channel_starttime" name="channel_starttime" data-format="dd/MM/yyyy hh:mm:ss" class="form-control" type="text" style="padding-left:32px;"></input>
                                     </div>
                                   </div>
                                 </div>

								  <!-- <span class="add-on">
								      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
								      </i>
								    </span>-->


								  </div>

                            	<div class="col-md-12 pdleft">
                            		 <label>End Time</label>
                                 <div class="col-md-12" style="padding:0;margin-bottom:1rem;">
                                   <div id="datetimepicker_schedule_start_time" class="input-append date">
                                     <div class="input-group">
                                       <div class="input-group-prepend">
                                         <span class="input-group-text">
                                           <i class="icon-calendar"></i>
                                         </span>
                                       </div>
                                       <input id="channel_endtime" name="channel_endtime" data-format="dd/MM/yyyy hh:mm:ss" class="form-control" type="text" style="padding-left:32px;"></input>
                                     </div>
                                   </div>
                                 </div>

								<!--   <span class="add-on">
								      <i data-time-icon="icon-time" data-date-icon="icon-calendar">
								      </i>
								    </span>-->



								  </div>


                            </div>
                            <div class="form-group col-lg-11" style="margin-bottom:10px;padding-left:0;">
	                            <div class="check-input">
	                              <div class="boxes">
	                                 <input type="checkbox" id="record_channel" name="record_channel">
	                                 <label for="record_channel" style="padding-left: 20px;line-height:15px;">Record Channel</label>
	                              </div>
	                           </div>
                            </div>
                            <div class="form-group col-lg-11">
	                             <div class="row">
                                    	<label>File Name</label>
                                    	<input type="text" class="form-control" name="record_file" id="record_file"/>
                                    </div>
                            </div>
                           	<div class="form-group col-lg-11">
                                <div class="row">
                                    <label> Recording Presets</label>
                                    <select class="form-control selectpicker" name="recording_encoding_profile" id="recording_encoding_profile">
                                        <option value="0">- Select Preset -</option>
                                        <option value="-1">Use The Channel Encoding Preset</option>
                                        <option value="-2">Use The Default Encoder Recording Preset</option>
                                        <?php
											if(sizeof($profiles)>0)
											{
												foreach($profiles as $profile)
												{
													echo '<option value="'.$profile['id'].'">'.$profile['template_name'].'</option>';
												}
											}
										?>
                                    </select>
                                </div>
                            </div>
						 </div>
                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
				</div>
        <div class="card-footer">
          <button class="btn btn-sm btn-primary" type="submit">Save</button>
            <button class="btn btn-sm btn-danger" type="reset">Reset</button>
            </div>
            </form>
			</div>
		</div>
	</div>
</main>
