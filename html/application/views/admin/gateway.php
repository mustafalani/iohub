<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<style type="text/css">
	.modal-content {
		background:#303030;
	}
	.iconn
	{
		font-size:36px;
	}
	.bankpopup{
		cursor: pointer;
	}
	.events-attachment-button {
    padding: 1px 10px !important;
}
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
#removedropGateway {
    float: left;
		margin-top: 20px !important;
}
#localsources {
    margin-top: 20px !important;
    float: right;
}

.btn-primary {
    color: #fff !important;
		cursor: pointer;
}

.external-event {

    padding: 5px 10px;
    font-weight: bold;
    margin-bottom: 4px;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    text-shadow: 0 1px 1px rgba(0,0,0,0.1);
    border-radius: 3px;
    cursor: move;

}
.form-control {
    height: 30px;
    border-radius: 2px;
    font-size: 12px;
    border: 1px solid #191919;
    background-color: #191919;
    color: #ccc;
}
.content-box {
    width: 100%;
    margin: auto;
        margin-bottom: auto;
    padding: 20px;
    min-height: 100px;
    background-color: rgba(255, 255, 255, .1);
    display: flex;
    color: #fff !important;
    border: 1px solid;
    border-radius: 10px;
}
hr{
	border: 1px solid;
	width: 100%;
}
</style>
<script type="text/javascript">
var banks = [];
var channelss = [];
</script>
<?php
$bankdata = array();
$channelData = array();
if(sizeof($banks)>0)            	{
	foreach($banks as $bank)
	{
		//$bankdata[$bank['id']] = $bank['bank_name'];
		$bankdata[$bank['id']] = array('name'=>$bank['bank_name'],'isLocked'=>$bank['isLocked']);
		$channels = $this->common_model->getAllGatewayChannels(0,0,$bank['id']);
	    if(sizeof($channels)>0)
	    {
			foreach($channels as $channel)
		 	{
		 		if(!array_key_exists($channel['id'],$channelData))
		 		{
					$channelData[$channel['id']] = array();
				}
				if($bank['isLocked'] == 1)
				{
					$channelData[$channel['id']]['isLocked'] = TRUE;
				}
				else
				{
					$channelData[$channel['id']]['isLocked'] = FALSE;
				}
		 		$channelData[$channel['id']]['channel_name'] = $channel['channel_name'];
		 		$channelData[$channel['id']]['channel_type'] = $channel['channel_type'];
		 		switch($channel['channel_type'])
		 		{
					case "NDI":
					$channelData[$channel['id']]['bank_id'] = $channel['bank_id'];
					$channelData[$channel['id']]['channel_ndi_source'] = $channel['channel_ndi_source'];
					$channelData[$channel['id']]['ndi_destination'] = $channel['ndi_destination'];
					break;
					case "RTMP":
					$channelData[$channel['id']]['bank_id'] = $channel['bank_id'];
					$channelData[$channel['id']]['channel_ndi_source'] = $channel['channel_ndi_source'];
					$channelData[$channel['id']]['channel_apps'] = $channel['channel_apps'];
					$channelData[$channel['id']]['output_rtmp_url'] = $channel['output_rtmp_url'];
					$channelData[$channel['id']]['output_rtmp_key'] = $channel['output_rtmp_key'];
					$channelData[$channel['id']]['auth_uname'] = $channel['auth_uname'];
					$channelData[$channel['id']]['auth_pass'] = $channel['auth_pass'];
					$channelData[$channel['id']]['encoding_profile'] = $channel['encoding_profile'];
					break;
					case "SRT":
					$channelData[$channel['id']]['bank_id'] = $channel['bank_id'];
					$channelData[$channel['id']]['channel_ndi_source'] = $channel['channel_ndi_source'];
					$channelData[$channel['id']]['srt_ip'] = $channel['srt_ip'];
					$channelData[$channel['id']]['srt_port'] = $channel['srt_port'];
					$channelData[$channel['id']]['srt_mode'] = $channel['srt_mode'];
					$channelData[$channel['id']]['encoding_profile'] = $channel['encoding_profile'];
					break;
					case "SDI":
					$channelData[$channel['id']]['bank_id'] = $channel['bank_id'];
					$channelData[$channel['id']]['channel_ndi_source'] = $channel['channel_ndi_source'];
					$channelData[$channel['id']]['sdi_output'] = $channel['channelOutpue'];
					$channelData[$channel['id']]['audio_channel'] = $channel['audio_channel'];
					break;
				}
		 	}
		}
	}
}
$bankJson = json_encode($bankdata);
$channelJson = json_encode($channelData);
echo '<script type="text/javascript">banks='.$bankJson.'</script>';
echo '<script type="text/javascript">channelss='.$channelJson.'</script>';
?>
<main class="main">
	   <!-- Breadcrumb-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Home</a>
          </li>
          <li class="breadcrumb-item active">NDI Gateway</li>
        </ol>
        <div class="container-fluid">
	        <div class="animated fadeIn">
	        	<div class="card">
	        		<div class="card-body">
	        		<div class="row">

                            	<div class="col-md-5">

            <div class="box-header with-border" style="padding:10px !important;border:1px solid #23282c;">
              <h4 class="box-title" style="color:#fff;line-height: 2">Sources</h4>
               <a class="btn refreshSource btn-primary float-right"><span><i class="fa fa-refresh"></i> Refresh</span></a>
            </div>
            <div class="box-body" style="padding:10px 0 0 0;">
              <!-- the events Mustafa Dont Remove "removedropGateway" class -->
              <div id="external-events">
                <div id="removedropGateway" class="checkbox check-input">
                	<div class="boxes">
                      <input id="removeafterdrop" name="removeafterdrop" type="checkbox">
						<label for="removeafterdrop" style="padding-left:25px;">Remove After Drop</label>
					</div>

                </div>
                <div id="localsources" class="checkbox check-input">

                  <div class="boxes">
                      <input id="localsourcescheck" name="localsourcescheck" type="checkbox">
						<label for="localsourcescheck" style="padding-left:25px;">Show Local Sources</label>
					</div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->

          <!-- /. box -->
        </div>
        						<div class="col-md-7"><!-- KAMAL PLEASE NOTE THAT I WILL CHANGE THIS DIV LATER/-->
                          <div  class="">
                            <div class="box-header with-border" style="padding:10px !important;border:1px solid #23282c;">
                              <h4 class="box-title" style="color:#fff;line-height: 2">Destinations Banks</h4>
                              <a class="add-btn btn btn-primary float-right addBank"><span><i class="fa fa-plus"></i> Bank</span></a>
                            </div>
                            <div class="box-body" style="padding:10px 0 0 0;">
                              <!-- THE BANKS -->
                              <div class="fc fc-unthemed fc-ltr">
                              	<div id="banks-events">
                                	<?php
                                	if(sizeof($banks)>0)
                                	{
										foreach($banks as $bank)
										{

											?>
											<div id="<?php echo $bank['id'];?>" class="banks external-event" style="position: relative;border: 1px solid #23282c;">
												   <div class="banks-action">
												      <li class="fa fa-info-circle" data-toggle="tooltip" data-placement="left" title="Destination Bank" style="color: #fff;"></li>
												      <?php
												      if($bank['isLocked'] == 1)
												      {
													  	?>
													  	<li class="fa fa-lock bankLock" style="color:#fff;"></li>
													  	<?php
													  }
													  else
													  {
													  ?>
													  <li class="fa fa-unlock bankLock" style="color:#fff;"></li>
													  <?php
													  }
												      ?>

												      <li class="fa fa-times delBank" style="color:#fff;"></li>
												   </div>
												   <a style="text-align:center;margin:0 0 10px;display:block;" class="bankpopup"><i class="fa fa-link" style="color:#fff;"></i> <span><?php echo $bank['bank_name'];?></span></a>
												   <div class="box-events-buttons">
												      <ul class="events-attachments clearfix">

												         <?php
												         $channels = $this->common_model->getAllGatewayChannels(0,0,$bank['id']);
												         if(sizeof($channels)>0)
												         {
														 	foreach($channels as $channel)
														 	{
																if($channel['status'] == 1)
																{
																	?>
																<!--	<li id="<?php echo $channel['id'];?>" class="label label-live channelStartStopGateway"><a class='settings' id="<?php echo $channel['channel_type'];?>_<?php echo $bank['id'];?>" href='javascript:void(0);'><i class="fa fa-gear" style="color: #3737376b;position:  absolute;left: 0;padding: 2px;top:  0;font-size:  16px;"></i></a><a id="stop_<?php echo $bank['id'];?>" class='stopgatewaych' href='javascript:void(0);'><i class="fa fa-times" style="color: #3737376b;position:  absolute;right:  0;padding: 2px;top:  0;font-size:  16px;"></i></a><span class="events-attachment-button"><?php echo $channel['channel_type'];?></span>
                                <p class="counter" style="color: #f2f906;font-size: 13px;font-family: monospace;text-align:  center;" title="Fri Aug 31 23:45:00 2018"></p>
                                <img src="<?php echo site_url();?>assets/site/main/img/channel-loading.gif" class="ajxload"/>
                                </li>-->
                                <li id="<?php echo $channel['id'];?>" class="label label-gray channelStartStopGateway"><a class='settings' id="<?php echo $channel['channel_type'];?>_<?php echo $bank['id'];?>" href='javascript:void(0);'><i class="fa fa-gear" style="color: #3737376b;position:  absolute;left: 0;padding: 2px;top:  0;font-size:  16px;"></i></a><a id="stop_<?php echo $bank['id'];?>" class='stopgatewaych' href='javascript:void(0);'><i class="fa fa-times" style="color: #3737376b;position:  absolute;right:  0;padding: 2px;top:  0;font-size:  16px;"></i></a><span class="events-attachment-button inactive"><?php echo $channel['channel_type'];?></span>


                                <p class="counter inactive counter" style="color: #f2f906;font-size: 13px;font-family: monospace;text-align:  center;" title="">00:00:00:00</p>
                                <img src="<?php echo site_url();?>assets/site/main/img/channel-loading.gif" class="ajxload"/></li>
																	<?php
																}
																elseif($channel['status'] == 0)
																{
																	?>
																	<li id="<?php echo $channel['id'];?>" class="label label-gray channelStartStopGateway"><a class='settings' id="<?php echo $channel['channel_type'];?>_<?php echo $bank['id'];?>" href='javascript:void(0);'><i class="fa fa-gear" style="color: #3737376b;position:  absolute;left: 0;padding: 2px;top:  0;font-size:  16px;"></i></a><a id="stop_<?php echo $bank['id'];?>" class='stopgatewaych' href='javascript:void(0);'><i class="fa fa-times" style="color: #3737376b;position:  absolute;right:  0;padding: 2px;top:  0;font-size:  16px;"></i></a><span class="events-attachment-button inactive"><?php echo $channel['channel_type'];?></span>


                                <p class="counter inactive counter" style="color: #f2f906;font-size: 13px;font-family: monospace;text-align:  center;" title="">00:00:00:00</p>
                                <img src="<?php echo site_url();?>assets/site/main/img/channel-loading.gif" class="ajxload"/></li>
																	<?php
																}
															}
														 }
												         ?>

												         <li class="label label-add" style="border: 1px dashed #73787e;text-align:  center;font-size: 33px;">
												         <a href='javascript:void(0);' class='addnewchannel' id="bank_<?php echo $bank['id'];?>"><i class="fa fa-plus" style="color: #464748;"></i></a>
												         </li>
												      </ul>
												   </div>
												</div>


											<?php
										}
									}
									else
									{
										echo "Banks Not Created Yet!";
									}
                                	?>
                              	</div>
                              </div>
                            </div>
                            <!-- /.box-body -->
                          </div>
                          <!-- /. box -->
                        </div>

                    </div>
	        		</div>
	        	</div>
	        </div>
	      </div>
	</main>



<!-- Bank Popup-->
<div class="modal fade" id="bankPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                                <div class="card-body">

                                    <div class="tab-btn-container">
                                    	<a href="#"><i class="fa fa-gear iconn"></i></a>
                                        <input type="button" class="btn btn-primary save float-right saveBankDetails" value="Save"/>
                                    </div>

                                    <div class="col-12"><div class="row"><hr></div></div>
                                    <div class="row">
                        <div class="col-lg-12 p-t-15">
                            <div class="form-group col-lg-12">
                                <div class="row">
                                    <label>Bank Name <span class="mndtry">*</span></label>
                                    <input type="text" class="form-control" name="bank_popup_name" id="bank_popup_name" required="true"/>
                                    <input type="hidden" class="form-control" name="bank_popup_id" id="bank_popup_id" required="true"/>
                                </div>
                            </div>
                        </div>
                    </div>
                                </div>
                            </div>
        </div>
    </div>
</div>
<!-- Bank Popup end -->


<!-- Create New Channel Popup -->
<div  class="modal fade" id="modelCreateGatewayChannels" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                                <div class="card-body">
                                    <div class="tab-btn-container">
                                        <input type="submit" class="btn btn-primary save float-right savegatewaychannel" value="Save"/>
                                    </div>
                                    <h2>New Gateway Channel</h2>
                                    <div class="col-lg-12"><div class="row"><hr></div></div>
                                    <div class="row">
                        <div class="col-lg-12 p-t-15">
                            <div class="form-group col-lg-12">
                                <div class="row">
                                    <label>Channel Name <span class="mndtry">*</span></label>
                                    <input type="text" class="form-control" name="channel_name" id="channel_name" required="true"/>
                                </div>
                            </div>

                            <div class="form-group col-lg-12">
                                <div class="row">
                                <br/>
                                    <label> NDI Source</label>
                                   <input readonly="true" type="text" class="form-control" placeholder="" name="channel_ndi_source" id="channel_ndi_source"/>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <div class="row">
                                    <label>Channel Output <span class="mndtry">*</span></label>
                                    <select class="form-control selectpicker" name="newchannelOutpue" id="newchannelOutpue" required="true">
                                        <option value="">- Select Output -</option>

                                        <?php
                                        $counterOutput=1;
                                         if(sizeof($encoders)>0)
			                        	{
			                        		$encoder_count=1;
											foreach($encoders as $encode)
											{
												$outputs = $encode['encoder_output'];
												if($outputs != "")
												{
													$outputArray = explode(',',$outputs);
													foreach($outputArray as $out)
													{
														$outputname = $this->common_model->getOutputName($out);
														?>
														<option id="enc_<?php echo $encode['id'];?>" tabindex="<?php echo $counterOutput;?>" label="phyoutput" value="phyoutput_<?php echo $out;?>_<?php echo $encode['id'];?>"><?php echo $encode['encoder_name']."->". $outputname[0]['item'];?></option>
														<?php
														$counterOutput++;
													}
												}
											}
										}
                                        $channelOutput = $this->common_model->getChannelOutput();
                                        if(sizeof($channelOutput)>0)
                                        {
											foreach($channelOutput as $output)
											{
												if($output['id'] != 5 && $output['id'] != 6)
												{
													?>
												<option tabindex="<?php echo $counterOutput;?>" label="viroutput" value="viroutput_<?php echo $output['id'];?>"><?php echo $output['item'];?></option>
												<?php
												$counterOutput++;
												}

											}
										}
                                        ?>
                                    </select>
                                </div>

                                <div class="row ndi-name">
                                <br/>
                                    <label>NDI Destination</label>
                                    <input type="text" class="form-control" name="ndi_destination" id="ndi_destination">
                                </div>

                                <div class="row ch-applications">
                                 <br/>
                                    <label>Application</label>
                                    <select class="form-control selectpicker" id="channel_apps" name="channel_apps">
                                        <option value="">- Select Application -</option>
                                        <?php

											if(sizeof($apps)>0)
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

                                    <div class="row out-rtmp-url">
                                    <br>
                                    	<label>RTMP Stream URL</label>
                                    	<input type="text" class="form-control" name="output_rtmp_url" id="output_rtmp_url"/>
                                    </div>
                                    <div class="row out-rtmp-key">
                                    <br/>
                                    	<label>RTMP Stream Key</label>
                                    	<input type="text" class="form-control" name="output_rtmp_key" id="output_rtmp_key"/>
                                    </div>



                                 <div class="row pdleft new-srt">
                                 <div class="col-lg-4 pdleft">

                                	<br/>
                                    <label>IP Address</label>
                                    <input type="text" class="form-control" placeholder="IP Address" name="new_srt_ip" id="new_srt_ip"/>


                                </div>
                                 <div class="col-lg-4">
                                <br/>
                                    <label>Port</label>
                                    <input type="text" class="form-control" placeholder="Port" name="new_srt_port" id="new_srt_port"/>
                                </div>
                                 <div class="col-lg-4 pdright">
                                <br/>
                                    <label>Mode</label>
                                    <select class="form-control selectpicker" name="new_srt_mode" id="new_srt_mode">
                                        <option value="listener">Listener</option>
                                        <option value="caller">Caller</option>
                                    </select>
                                </div>
                            </div>
                                 <div class="boxes row ch-authentication">
                                    <br/>
                                        <input type="checkbox" id="channel-auth" name="channel-auth">
                                        <span for="box-2">Use Authentication</span>
                                    </div>

                                    <div class="row ch-uname">
                                    <br>
                                    	<label>Username</label>
                                    	<input type="text" class="form-control" name="auth_uname" id="auth_uname"/>
                                    </div>

                                    <div class="row ch-pass">
                                    <br/>
                                    	<label>Password</label>
                                    	<input type="text" class="form-control" name="auth_pass" id="auth_pass"/>
                                    </div>
                            </div>
                            <div class="form-group col-lg-12 ch-profile">
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
                            <div class="form-group col-lg-12 ch-audio-channels">
                                <div class="row">
                                    <label> Audio Channels</label>
                                    <select class="form-control selectpicker" name="audio_channel" id="audio_channel">
                                        <option value="0">- Select Channel -</option>
                                        <?php
											if(sizeof($audiochannels)>0)
											{
												foreach($audiochannels as $audio)
												{
													echo '<option value="'.$audio['value'].'">'.$audio['name'].'</option>';
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
<!-- Create New Channel Popup End-->
<!-- NDI Channel Popup-->
<div class="modal fade" id="ndiChannelPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                                <div class="card-body">

                                    <div class="tab-btn-container">
                                    	<a href="#"><i class="fa fa-gear iconn"></i></a>
                                        <input type="button" class="btn btn-primary save float-right saveNDI" value="Save"/>
                                    </div>

                                    <div class="col-lg-12"><div class="row"><hr></div></div>
                                    <div class="row">
                        <div class="col-lg-12 p-t-15">
                            <div class="form-group col-lg-12">
                                <div class="row">
                                    <label>Name <span class="mndtry">*</span></label>
                                    <input type="text" class="form-control" name="ndi_channel_name" id="ndi_channel_name" required="true"/>
                                </div>
                            </div>

                            <div class="form-group col-lg-12">
                                <div class="row">
                                    <label> Source </label>
                                    <input type="text" class="form-control" name="source" id="source" required="true" readonly="true"/>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <div class="row">
                                    <label>Destination </label>
                                     <input type="text" class="form-control" name="destination" id="destination" required="true" readonly="true"/>
                                </div>
                            </div>
                        </div>
                    </div>
                                </div>
                            </div>
        </div>
    </div>
</div>
<!-- NDI Channel Popup end -->
<!-- RTMP Channel Popup -->
<div class="modal fade" id="rtmpChannelPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                                <div class="card-body">

                                    <div class="tab-btn-container">
                                    	<a href="#"><i class="fa fa-gear iconn"></i></a>
                                        <input type="button" class="btn btn-primary save float-right saveRTMP" value="Save"/>
                                    </div>

                                    <div class="col-lg-12"><div class="row"><hr></div></div>
                                    <div class="row">
                        <div class="col-lg-12 p-t-15">
                            <div class="form-group col-lg-12">
                                <div class="row">
                                    <label>Name <span class="mndtry">*</span></label>
                                    <input type="text" class="form-control" name="rtmp_channel_name" id="rtmp_channel_name" required="true"/>
                                </div>
                            </div>

                            <div class="form-group col-lg-12">
                                <div class="row">
                                    <label> Source </label>
                                    <input type="text" class="form-control" name="rtmp_ndi_source" id="rtmp_ndi_source" required="true" readonly="true"/>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                              <div class="row">
                                 <br/>
                                    <label>Application</label>
                                    <select class="form-control selectpicker" id="rtmp_apps" name="rtmp_apps">
                                        <option value="">- Select Application -</option>
                                        <?php
											if(sizeof($apps)>0)
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
							</div>
							<div class="form-group col-lg-12 gateway-rtmp-url">
                                <div class="row">
                                <br>
                                	<label>RTMP Stream URL</label>
                                	<input type="text" class="form-control" name="rtmp_url" id="rtmp_url"/>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 gateway-rtmp-key">
                                <div class="row">
                                <br/>
                                	<label>RTMP Stream Key</label>
                                	<input type="text" class="form-control" name="rtmp_key" id="rtmp_key"/>
                       			</div>
                            </div>
                            <div class="form-group col-lg-12">
                            <div class="boxes row">
                            <br/>
                                <input type="checkbox" id="gateway-auth" name="gateway-auth">
                                <span for="box-2">Use Authentication</span>
                            </div>

                            <div class="row gateway-uname">
                            <br>
                            	<label>Username</label>
                            	<input type="text" class="form-control" name="gateway_auth_uname" id="gateway_auth_uname"/>
                            </div>

                            <div class="row gateway-pass">
                            <br/>
                            	<label>Password</label>
                            	<input type="text" class="form-control" name="gateway_auth_pass" id="gateway_auth_pass"/>
                            </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <div class="row">
                                    <label> Encoding Presets</label>
                                    <select class="form-control selectpicker" name="rtmp_encoding_profile" id="rtmp_encoding_profile">
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
                    </div>
                  </div>
               </div>
        </div>
    </div>
</div>
<!-- RTMP Channel Popup End -->
<!-- SRT Channel Popup start-->
<div class="modal fade" id="srtChannelPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                                <div class="card-body">

                                    <div class="tab-btn-container">
                                    	<a href="#"><i class="fa fa-gear iconn"></i></a>
                                        <input type="button" class="btn btn-primary save float-right saveSRT" value="Save"/>
                                    </div>

                                    <div class="col-lg-12"><div class="row"><hr></div></div>
                                    <div class="row">
                        <div class="col-lg-12 p-t-15">
                            <div class="form-group col-lg-12">
                                <div class="row">
                                    <label>Name <span class="mndtry">*</span></label>
                                    <input type="text" class="form-control" name="srt_channel_name" id="srt_channel_name" required="true"/>
                                </div>
                            </div>

                            <div class="form-group col-lg-12">
                                <div class="row">
                                    <label> Source </label>
                                    <input type="text" class="form-control" name="srt_source" id="srt_source" required="true" readonly="true"/>
                                </div>
                            </div>
                            <div class="form-group col-lg-12 pdleft">
                                 <div class="col-lg-4 pdleft">

                                	<br/>
                                    <label>IP Address</label>
                                    <input type="text" class="form-control" placeholder="IP Address" name="srt_ip" id="srt_ip"/>


                                </div>
                                 <div class="col-lg-4">
                                <br/>
                                    <label>Port</label>
                                    <input type="text" class="form-control" placeholder="Port" name="srt_port" id="srt_port"/>
                                </div>
                                 <div class="col-lg-4 pdright">
                                <br/>
                                    <label>Mode</label>
                                    <select class="form-control selectpicker" name="srt_mode" id="srt_mode">
                                        <option value="listener">Listener</option>
                                        <option value="caller">Caller</option>
                                    </select>
                                </div>
                            </div>
                             <div class="form-group col-lg-12">
                                <div class="row">
                                    <label> Encoding Presets</label>
                                    <select class="form-control selectpicker" name="srt_encoding_profile" id="srt_encoding_profile">
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
                    </div>
                 </div>
             </div>
        </div>
    </div>
</div>
<!-- SRT Channel Popup End -->
<!-- SDI Channel Popup start-->
<div class="modal fade" id="sdiChannelPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                                <div class="card-body">

                                    <div class="tab-btn-container">
                                    	<a href="#"><i class="fa fa-gear iconn"></i></a>
                                        <input type="button" class="btn btn-primary save float-right saveSDI" value="Save"/>
                                    </div>

                                    <div class="col-lg-12"><div class="row"><hr></div></div>
                                    <div class="row">
                       		 <div class="col-lg-12 p-t-15">
                            <div class="form-group col-lg-12">
                                <div class="row">
                                    <label>Name <span class="mndtry">*</span></label>
                                    <input type="text" class="form-control" name="sdi_channel_name" id="sdi_channel_name" required="true"/>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <div class="row">
                                    <label> Source </label>
                                    <input type="text" class="form-control" name="sdi_source" id="sdi_source" required="true" readonly="true"/>
                                </div>
                            </div>
                             <div class="form-group col-lg-12">
                                <div class="row">
                                    <label> SDI Output </label>
                                    <select class="form-control selectpicker" name="sdi_output" id="sdi_output" required="true">
                                        <option value="">- Select Output -</option>
                                    <?php
                                    $counterOutput=1;
                                        if(sizeof($encoders)>0)
			                        	{
			                        		$encoder_count=1;
											foreach($encoders as $encode)
											{
												$outputs = $encode['encoder_output'];
												if($outputs != "")
												{
													$outputArray = explode(',',$outputs);
													foreach($outputArray as $out)
													{
														$outputname = $this->common_model->getOutputName($out);
														?>
														<option id="enc_<?php echo $encode['id'];?>" tabindex="<?php echo $counterOutput;?>" label="phyoutput" value="phyoutput_<?php echo $out;?>_<?php echo $encode['id'];?>"><?php echo $encode['encoder_name']."->". $outputname[0]['item'];?></option>
														<?php
														$counterOutput++;
													}
												}
											}
										}
										?>
										</select>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <div class="row">
                                    <label> Audio Channels</label>
                                    <select class="form-control selectpicker" name="sdi_audio_channel" id="sdi_audio_channel">
                                        <option value="0">- Select Channel -</option>
                                        <?php
											if(sizeof($audiochannels)>0)
											{
												foreach($audiochannels as $audio)
												{
													echo '<option value="'.$audio['value'].'">'.$audio['name'].'</option>';
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
<!-- SDI Channel Popup End -->
