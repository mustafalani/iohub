<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<main class="main">
	   <!-- Breadcrumb-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Home</a>
          </li>
          <li class="breadcrumb-item active">Apps</li>
        </ol>
        <div class="container-fluid">
	        <div class="animated fadeIn">
	        	<div class="card">
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
					
<style type="text/css">
	.tab-content {
    margin-top: -1px;
    background: #3a4149;
    border:none;
    border-top: 1px solid #23282c;
    border-radius: 0 0 0.25rem 0.25rem;
}
.form-control {
    height: 30px;
    border-radius: 2px;
    font-size: 12px;
    border: 1px solid #191919;
    background-color: #191919;
    color: #ccc;
}
.content-box1 {
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
	.btedit
	{
		position: absolute;
right: 7px;
top: 8px;
background: none;
color: #3C8DBC;
font-size: 18px;
padding: 0;
	}
	.clr{
		color:#747474;
	}
	.btn-def{
		float: right !important;
	}
	.input_box
	{
		min-width: 50px !important;
		border: 1px solid #1C6B98;
		color: #FFF;
		background: #1C6B98;
		text-align: center;
		max-width: 67px;
		border-radius: 4px;
		float: left;
		margin-right: 10px;
	}
	.output_box
	{
		min-width: 50px !important;
		border: 1px solid #cecece;
		color: #1C6B98;
		background: #cecece;
		text-align: center;
		max-width: 67px;
		border-radius: 4px;
		float: left;
		margin-right: 10px;
		font-weight: bold;
	}
	.bank_box{
		min-width: 80px !important;
		border: 1px solid #cecece;
		color: #1C6B98;
		background: #cecece;
		text-align: center;
		max-width: 97px;
		border-radius: 4px;
		float: left;
		margin-right: 10px;
		font-weight: bold;
	}
	.cls_txt{
		color: #EEE;
		font-size: 11px;
		margin-top: 0;
		display: block;
		font-weight: bold;
		margin-left: 15px;
		bottom: 10px;
		position: absolute;
	}
	.icn
	{
		background: #fff;
		margin-right: 2px;
		font-size: 14px;
		color: #1C6B98;
		border-radius: 18px;
		border: 1px solid #1C6B98;
	}
	.config-container .tab-content {
   	 padding: 6px 0 0 0;
	}
	
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
</style>
<script type="text/javascript">
	var allEncoders = [];
</script>
<script type="text/javascript">
		window.history.pushState({}, "IOHUB - Workflow",  baseURL + 'workflows/' + '<?php echo $workflowID; ?>');
	</script>
<?php
	$counterInputs=1;
	if(sizeof($encoders)>0)
	{
		$encoder_count=1;
		foreach($encoders as $encode)
		{
			echo "<script type='text/javascript'>allEncoders.push('".json_encode($encode)."');</script>";
		}
	}
?>
<div class="row">
                        <!-- ========= Section One Start ========= -->
                        <div class="col-lg-12 col-12-12">
                            <div class="content-box config-contentonly">
                                <div class="config-container">
                                    <!-- === Nav tabs === -->
                                    <div class="row">
                                    	<div class="col-lg-12 col-md-12">
												<div class="form-group col-md-6 pdleft float-left" >
													<input type="text" class="form-control" placeholder="Name" name="workflow_name" id="workflow_name" />		
												</div>
												<div class="col-md-1 sav-btn-dv pull-right" style="padding-left:0;">
										             <button type="button" class="btn-primary save saveWorkflow float-right">
														 <span>Apply</span>
													</button>
												</div>

										</div>

                                    </div>
                                    <br/>
                                    <div class="tab-btn-container">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="nav-item">
                                            <a class="nav-link active" href="#inputs" aria-controls="channels" role="tab" data-toggle="tab">Inputs</a></li>
                                            <li class="nav-item" role="presentation" >
                                            <a class="nav-link" href="#outputs" aria-controls="channels" role="tab" data-toggle="tab">Outputs</a></li>
                                              <li class="nav-item" role="presentation" >
                                              <a class="nav-link" href="#routing" aria-controls="channels" role="tab" data-toggle="tab">Routing</a></li>
                                            <li class="nav-item" role="presentation" >
                                            <a class="nav-link" href="#targets" aria-controls="channels" role="tab" data-toggle="tab">Targets</a></li>
                                        </ul>

                                    </div>

                                    <!-- === Tab panes === -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="inputs">
										    <div class="action-table">
										        <div class="row">
										            <div class="col-xs-12">
										              <div id="sdi" class="input_box">SDI</div>
										              <div id="ndi" class="input_box">NDI</div>
										              <div id="rtmp" class="input_box">RTMP</div>
										              <div id="rtp" class="input_box">RTP</div>
										              <div id="udp" class="input_box">UDP</div>
										              <div id="srt" class="input_box">SRT</div>
										            </div>
										        </div>
										    </div>
										</div>
										 <div role="tabpanel" class="tab-pane " id="outputs">
										    <div class="action-table">
										        <div class="row">
										            <div class="col-xs-12">
										              <div id="sdi" class="output_box">SDI</div>
										              <div id="ndi" class="output_box">NDI</div>
										              <div id="rtmp" class="output_box">RTMP</div>
										              <div id="rtp" class="output_box">RTP</div>
										              <div id="udp" class="output_box">UDP</div>
										              <div id="srt" class="output_box">SRT</div>

										            </div>
										        </div>
										    </div>
										</div>
										 <div role="tabpanel" class="tab-pane" id="routing">
										    <div class="action-table">
										        <div class="row">
										            <div class="col-xs-12">
										              <div id="gateway_inout" class="gateway_box">Gateway</div>
										               <div id="publisher_inout" class="publisher_box">Publisher</div>
										            </div>
										        </div>
										    </div>
										</div>
										 <div role="tabpanel" class="tab-pane " id="targets">
										    <div class="action-table">
										        <div class="row">
										            <div class="col-xs-12">
										              <div id="facebook_box" class="btn btn-facebook btn-sm facebook_box"><span><i class="fa fa-facebook"></i> Facebook Live</span></div>
										              <div id="youtube_box" class="btn btn-google btn-sm youtube_box"><span><i class="fa fa-youtube"></i> Youtube Live</span></div>
										              <div id="twitch_box" class="btn btn-twitch btn-sm twitch_box"><span><i class="fa fa-twitch"></i> Twitch</span></div>
										              <div  id="twitter_box" class="btn btn-twitter btn-sm twitter_box"><span><i class="fa fa-twitter"></i> Twitter</span></div>
										              <div id="wowzacdn_box" class="btn btn-soundcloud btn-sm wowzacdn_box"><span><i class="fa fa-cloud"></i> Wowza CDN</span></div>
										              <div id="TRG_RTMP_box" class="btn btn-github btn-sm TRG_RTMP_box"><span><i class="fa fa-gear"></i> RTMP</span></div>
										              <div id="TRG_MPEG_TS_box" class="btn btn-github btn-sm TRG_MPEG_TS_box"><span><i class="fa fa-gear"></i> MPEG-TS</span></div>
										              <div id="TRG_RTP_box" class="btn btn-github btn-sm TRG_RTP_box"><span><i class="fa fa-gear"></i> RTP</span></div>
										              <div id="TRG_SRT_box" class="btn btn-github btn-sm TRG_SRT_box"><span><i class="fa fa-gear"></i> SRT</span></div>



										            </div>
										        </div>
										    </div>
										</div>

                                    </div>
									<div class="workflow-drag-area">
										<span class="cls_txt"><i class="fa fa-info-circle icn"></i> You have to click the APPLY button to apply all changes.</span>
										<div class="summary_flow">
											<div class="sum_head">Summary</div>
											<div class="sum_data"></div>
										</div>
									</div>
									<div class="table_div">
										<table class="table table_priority">
											<thead>
												<th>#</th>
												<th>Input / number</th>
												<th>Output / source number / out number</th>
												<th>Channel Type</th>
												<th>Priority</th>
											</thead>
											<tbody>
												
											</tbody>
										</table>
									</div>
                                </div>

                            </div>
                        </div>
                        <!-- ========= Section One End ========= -->


                    </div>
              </div>
            </div>
         </div>
      </div>
  </main>                  
            
<!-- Popups Inputs start -->
<!-- SDI Channel Popup -->
<div class="modal fade" id="workflow_sdiChannelPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                <div class="card-body">
                    <div class="tab-btn-container">
                    	<a href="#"><i class="fa fa-gear iconn"></i></a>
                        <input type="button" class="btn-def save save_wf_SDI" value="Save"/>
                    </div>

                    <div class="col-lg-12 ">
                    <div class="row"><hr></div></div>
                    <div class="form-group">                                
                        <label>Encoders <span class="mndtry">*</span></label>
                      	 <select class="form-control selectpicker" name="channel_input_Encoders" id="channel_input_Encoders" required="true">
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
                     <div class="form-group">
                                    <label> Channel Input <span class="mndtry">*</span></label>                                    
                                    <select class="form-control selectpicker" name="channelInput" id="channelInput" required="true">
                                        <option value="">- Select Input -</option>                                       
                                    </select>
                                </div>
                     <div class="form-group audioch">
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
                  </div>
               </div>
        </div>
    </div>
</div>
<!-- SDI Channel Popup end -->
<!-- NDI Channel Popup-->
<div class="modal fade" id="workflow_ndiChannelPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                <div class="card-body">
                    <div class="tab-btn-container">
                    	<a href="#"><i class="fa fa-gear iconn"></i></a>
                        <input type="button" class="btn-def save save_WF_NDI" value="Save"/>
                    </div>
                    <div class="col-lg-12"><div class="row"><hr></div></div>
                    <div class="row">
                    	<div class="col-lg-12 p-t-15">
                    		<div class="form-group">
                                
                                    <label>Encoders <span class="mndtry">*</span></label>
                                   <select class="form-control selectpicker" name="channel_input_ndi_Encoders" id="channel_input_ndi_Encoders" required="true">
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
                        	<div class="check-input ipss">
                                	<br/>
                                	<div class="boxes">
                                        <input type="checkbox" id="wf_isIPAddress" name="wf_isIPAddress">
                                        <label for="wf_isIPAddress"></label>
                                    </div>
                                    <label style="margin-left:22px;"> Remote IP Addresses (comma seprated)</label>
                                    <input type="text" class="form-control" placeholder="" name="ip_addresses_comma" id="ip_addresses_comma" disabled="disabled"/>
                                </div>
                                <div class="form-group">
                                <br/>
                                    <label> NDI Source <a id="find_NDISources" style="margin-left: 5px !important;" href="javascript:void(0);"><i class="fa fa-refresh"></i></a></label>
                                    <select class="form-control selectpicker" id="channel_ndi_source" name="channel_ndi_source">
                                    	<optin value="0">-- No NDI Sources Found --</optin>

                                    </select>
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
<div class="modal fade" id="workflow_rtmpChannelPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                <div class="card-body">
                    <div class="tab-btn-container">
                    	<a href="#"><i class="fa fa-gear iconn"></i></a>
                        <input type="button" class="btn-def save save_wf_RTMP" value="Save"/>
                    </div>
                    <div class="col-lg-12"><div class="row"><hr></div></div>
                    <div class="row">
                        <div class="col-lg-12 p-t-15">
                        	  <div class="form-group">                                
		                        <label>Encoders <span class="mndtry">*</span></label>
		                      	 <select class="form-control selectpicker" name="channel_input_rtmp_Encoders" id="channel_input_rtmp_Encoders" required="true">
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
                        	<div class="form-group">
                            <br/>
                                <label> RTMP URL</label>
                                <input type="text" class="form-control" placeholder="rtmp://[username[:password]@]ip[:port]/<appName>/<stream_name>" name="input_rtmp_url" id="input_rtmp_url"/>
                            </div>
                        </div>
                    </div>
                  </div>
               </div>
        </div>
    </div>
</div>
<!-- RTMP Channel Popup End -->
<!-- MPEGST - RTP -->
<div class="modal fade" id="workflow_rtpChannelPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                <div class="card-body">
                    <div class="tab-btn-container">
                    	<a href="#"><i class="fa fa-gear iconn"></i></a>
                        <input type="button" class="btn-def save save_wf_RTP" value="Save"/>
                    </div>
                    <div class="col-lg-12"><div class="row"><hr></div></div>
                    <div class="row">
                        <div class="col-lg-12 p-t-15">
                        	 <div class="form-group">                                
		                        <label>Encoders <span class="mndtry">*</span></label>
		                      	 <select class="form-control selectpicker" name="channel_input_rtp_Encoders" id="channel_input_rtp_Encoders" required="true">
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
                        	<div class="form-group">
                            <br/>
                                 <label>MPEG TS - RTP</label>
                                    <input type="text" class="form-control" placeholder="rtmp://[username[:password]@]ip[:port]/<appName>/<stream_name>" name="input_mpeg_rtp" id="input_mpeg_rtp"/>
                            </div>
                        </div>
                    </div>
                  </div>
               </div>
        </div>
    </div>
</div>
<!-- MPEGST - RTP  End -->
<!-- MPEGST - UDP -->
<div class="modal fade" id="workflow_udpChannelPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                <div class="card-body">
                    <div class="tab-btn-container">
                    	<a href="#"><i class="fa fa-gear iconn"></i></a>
                        <input type="button" class="btn-def save save_wf_UDP" value="Save"/>
                    </div>
                    <div class="col-lg-12"><div class="row"><hr></div></div>
                    <div class="row">
                        <div class="col-lg-12 p-t-15">
                        	<div class="form-group">                                
		                        <label>Encoders <span class="mndtry">*</span></label>
		                      	 <select class="form-control selectpicker" name="channel_input_udp_Encoders" id="channel_input_udp_Encoders" required="true">
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
                        	<div class="form-group">
                            <br/>
                                 <label>MPEG TS - UDP</label>
                                    <input type="text" class="form-control" placeholder="rtmp://[username[:password]@]ip[:port]/<appName>/<stream_name>" name="input_mpeg_udp" id="input_mpeg_udp"/>
                            </div>
                        </div>
                    </div>
                  </div>
               </div>
        </div>
    </div>
</div>
<!-- MPEGST - UDP  End -->
<!-- MPEGST - SRT -->
<div class="modal fade" id="workflow_srtChannelPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                <div class="card-body">
                    <div class="tab-btn-container">
                    	<a href="#"><i class="fa fa-gear iconn"></i></a>
                        <input type="button" class="btn-def save save_wf_SRT" value="Save"/>
                    </div>
                    <div class="col-lg-12"><div class="row"><hr></div></div>
                    <div class="row">
                        <div class="col-lg-12 p-t-15">
                        	<div class="form-group">                                
		                        <label>Encoders <span class="mndtry">*</span></label>
		                      	 <select class="form-control selectpicker" name="channel_input_srt_Encoders" id="channel_input_srt_Encoders" required="true">
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
                        	<div class="form-group">
                            <br/>
                                 <label>MPEG TS - SRT</label>
                                    <input type="text" class="form-control" placeholder="rtmp://[username[:password]@]ip[:port]/<appName>/<stream_name>" name="input_mpeg_srt" id="input_mpeg_srt"/>
                            </div>
                        </div>
                    </div>
                  </div>
               </div>
        </div>
    </div>
</div>
<!-- MPEGST - SRT  End -->
<!-- Popups Inputs end -->
<!-- Popups Outputs Start -->
<!-- SDI Channel Popup -->
<div class="modal fade" id="workflow_out_sdiChannelPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                <div class="card-body">
                    <div class="tab-btn-container">
                    	<a href="#"><i class="fa fa-gear iconn"></i></a>
                        <input type="button" class="btn-def save save_wf_out_SDI" value="Save"/>
                    </div>

                    <div class="col-lg-12 apndendoers">
                    <div class="row"><hr></div></div>
                    	
                     <div class="form-group">
                                   <label>Channel Output <span class="mndtry">*</span></label>
                                     <select class="form-control selectpicker" name="channelOutpue" id="channelOutpue" required="true">
                                        <option value="">- Select Output -</option>
                                       
                                    </select>
                                </div>

                  </div>
               </div>
        </div>
    </div>
</div>
<!-- SDI Channel Popup end -->
<!-- NDI Channel Popup -->
<div class="modal fade" id="workflow_out_ndiChannelPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                <div class="card-body">
                    <div class="tab-btn-container">
                    	<a href="#"><i class="fa fa-gear iconn"></i></a>
                        <input type="button" class="btn-def save save_wf_out_NDI" value="Save"/>
                    </div>
                    <div class="col-lg-12 apndendoers">
                    <div class="row"><hr></div></div>                    
                      <div class="form-group">
                        <br/>
                            <label>NDI Name</label>
                            <input type="text" class="form-control" name="ndi_name" id="ndi_name">
                        </div>
                  </div>
               </div>
        </div>
    </div>
</div>
<!-- NDI Channel Popup end -->
<!-- RTMP Channel Popup -->
<div class="modal fade" id="workflow_out_rtmpChannelPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                <div class="card-body">
                    <div class="tab-btn-container">
                    	<a href="#"><i class="fa fa-gear iconn"></i></a>
                        <input type="button" class="btn-def save save_wf_out_RTMP" value="Save"/>
                    </div>
                    <div class="col-lg-12 apndendoers">
                    <div class="row"><hr></div></div>
                  
                      <div class="form-group ">
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

                    <div class="form-group out-rtmp-url">
                    <br>
                    	<label>RTMP Stream URL</label>
                    	<input type="text" class="form-control" name="output_rtmp_url" id="output_rtmp_url"/>
                    </div>
                    <div class="form-group out-rtmp-key">
                    <br/>
                    	<label>RTMP Stream Key</label>
                    	<input type="text" class="form-control" name="output_rtmp_key" id="output_rtmp_key"/>
                    </div>
                     <div class="boxes form-group">
                    <br/>
                        <input type="checkbox" id="channel-auth" name="channel-auth">
                        <span for="box-2">Use Authentication</span>
                    </div>
                    <div class="form-group ch-uname">
                    <br>
                    	<label>Username</label>
                    	<input type="text" class="form-control" name="auth_uname" id="auth_uname"/>
                    </div>

                    <div class="form-group ch-pass">
                    <br/>
                    	<label>Password</label>
                    	<input type="text" class="form-control" name="auth_pass" id="auth_pass"/>
                    </div>
                     <div class="form-group">
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
        </div>
    </div>
</div>
<!-- RTMP Channel Popup end -->
<!-- MPEGST - RTP -->
<div class="modal fade" id="workflow_out_rtpChannelPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                <div class="card-body">
                    <div class="tab-btn-container">
                    	<a href="#"><i class="fa fa-gear iconn"></i></a>
                        <input type="button" class="btn-def save save_wf_out_RTP" value="Save"/>
                    </div>
                    <div class="col-lg-12 apndendoers"><div class="row"><hr></div></div>
                   		<div class="form-group">
                            <br/>
                                 <label>MPEG TS - RTP</label>
                                    <input type="text" class="form-control" placeholder="rtmp://[username[:password]@]ip[:port]/<appName>/<stream_name>" name="output_mpeg_rtp" id="output_mpeg_rtp"/>
                            </div>
                        <div class="form-group">
                        <label> Encoding Presets</label>
                        <select class="form-control selectpicker" name="encoding_profile_rtp" id="encoding_profile_rtp">
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
<!-- MPEGST - RTP  End -->
<!-- MPEGST - UDP -->
<div class="modal fade" id="workflow_out_udpChannelPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                <div class="card-body">
                    <div class="tab-btn-container">
                    	<a href="#"><i class="fa fa-gear iconn"></i></a>
                        <input type="button" class="btn-def save save_wf_out_UDP" value="Save"/>
                    </div>
                    <div class="col-lg-12 apndendoers"><div class="row"><hr></div></div>
                    	<div class="form-group">
                            <br/>
                                 <label>MPEG TS - UDP</label>
                                    <input type="text" class="form-control" placeholder="rtmp://[username[:password]@]ip[:port]/<appName>/<stream_name>" name="output_mpeg_udp" id="output_mpeg_udp"/>
                            </div>
                        <div class="form-group">
                        <label> Encoding Presets</label>
                        <select class="form-control selectpicker" name="encoding_profile_udp" id="encoding_profile_udp">
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
<!-- MPEGST - UDP  End -->
<!-- MPEGST - SRT -->
<div class="modal fade" id="workflow_out_srtChannelPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                <div class="card-body">
                    <div class="tab-btn-container">
                    	<a href="#"><i class="fa fa-gear iconn"></i></a>
                        <input type="button" class="btn-def save save_wf_out_SRT" value="Save"/>
                    </div>
                    <div class="col-lg-12 apndendoers"><div class="row"><hr></div></div>                    
                        <div class="form-group">
                            <br/>
                                 <label>MPEG TS - SRT</label>
                                    <input type="text" class="form-control" placeholder="rtmp://[username[:password]@]ip[:port]/<appName>/<stream_name>" name="output_mpeg_srt" id="output_mpeg_srt"/>
                            </div>
                        <div class="form-group">
                        <label> Encoding Presets</label>
                        <select class="form-control selectpicker" name="encoding_profile_srt" id="encoding_profile_srt">
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
<!-- MPEGST - SRT  End -->
<!-- Popups Outputs End -->
<!-- Gateway Popup Start -->
<div class="modal fade" id="workflow_gateway_Popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                <div class="card-body">
                    <div class="tab-btn-container">
                    	<a href="#"><i class="fa fa-gear iconn"></i></a>
                        <input type="button" class="btn-def save save_wf_gateway" value="Save"/>
                    </div>
                    <div class="col-lg-12 apndendoers"><div class="row"><hr></div></div>  
                        <div class="form-group">
                            <br/>
                                 <label>Destination</label>
                                    <input type="text" class="form-control" placeholder="Destination" name="gateway_destination" id="gateway_destination"/>
                        </div>                        
                  </div>
               </div>
        </div>
    </div>
</div>
<!-- Gateway Popup end -->
<!-- Publisher Popup Start -->
<div class="modal fade" id="workflow_publisher_Popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                <div class="card-body">
                    <div class="tab-btn-container">
                    	<a href="#"><i class="fa fa-gear iconn"></i></a>
                        <input type="button" class="btn-def save save_wf_publisher" value="Save"/>
                    </div>
                    <div class="col-lg-12">
                    <div class="row"><hr></div></div>
                   <div class="form-group">
                                 <br/>
                    <label>Publisher</label>
                    <select class="form-control selectpicker" id="channel_publisher" name="channel_publisher">
                        <option value="">- Select Publisher -</option>
                        <?php

							if(sizeof($publishers)>0)
							{
								foreach($publishers as $pub)
								{
									echo '<option value="'.$pub['id'].'">'.$pub['wse_instance_name'].'</option>';
								}								
							}
						?>
                    </select>
                   </div>
                      <div class="form-group">
                                 <br/>
                    <label>Application</label>
                    <select class="form-control selectpicker" id="channel_pub_apps" name="channel_pub_apps">
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

                    <div class="form-group out-rtmp-url">
                    <br>
                    	<label>RTMP Stream URL</label>
                    	<input type="text" class="form-control" name="output_pub_rtmp_url" id="output_pub_rtmp_url"/>
                    </div>
                    <div class="form-group out-rtmp-key">
                    <br/>
                    	<label>RTMP Stream Key</label>
                    	<input type="text" class="form-control" name="output_pub_rtmp_key" id="output_pub_rtmp_key"/>
                    </div>
                     <div class="boxes form-group">
                    <br/>
                        <input type="checkbox" id="channel-auth-pub" name="channel-auth-pub">
                        <span for="box-2">Use Authentication</span>
                    </div>
                    <div class="form-group ch-uname">
                    <br>
                    	<label>Username</label>
                    	<input type="text" class="form-control" name="pub_auth_uname" id="pub_auth_uname"/>
                    </div>

                    <div class="form-group ch-pass">
                    <br/>
                    	<label>Password</label>
                    	<input type="text" class="form-control" name="pub_auth_pass" id="pub_auth_pass"/>
                    </div>
                     <div class="form-group">
                        <label> Encoding Presets</label>
                        <select class="form-control selectpicker" name="pub_encoding_profile" id="pub_encoding_profile">
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
<!-- Publisher Popup end -->

<!-- Facebook Popup Start -->
<div class="modal fade" id="workflow_facebook_targetPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                <div class="card-body">
                    <div class="tab-btn-container">
                    	<a href="#"><i class="fa fa-gear iconn"></i></a>
                        <input type="button" class="btn-def save save_wf_fb" value="Save"/>
                    </div>
                    <div class="col-lg-12 apndendoers"><div class="row"><hr></div></div>                    
                        <div class="form-group col-lg-12">
								<div class="row">
									<label>Target Name</label>
									<input type="text" class="form-control" placeholder="" name="target_name" id="target_name" required="true">
								</div>
							</div>
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Select Application</label>
									<select class="form-control selectpicker" name="wowzaengin" id="wowzaengin" onchange="showApplicationURL(this.value);" required="true">
										<option value="0">-- Select --</option>
										 <?php																				$selected = $this->uri->segment(3);
										 	
									
											if(sizeof($apps)>0)
											{
												foreach($apps as $app)
												{
													if($selected != "" && $selected > 0 && $selected == $app['id'])
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
									<?php
									if($selected != "" && $selected > 0)
									{
										$apps = $this->common_model->getApplicationStreams($selected);
										$wid = $apps[0]['live_source'];
										$wowza = $this->common_model->getWovzData($wid);
										$path = explode("/",$apps[0]['wowza_path']);
										$SURL="";
										if(sizeof($wowza)>0)
										{
											$SURL = 'rtmp://'.$wowza[0]['ip_address'].':'.$wowza[0]['rtmp_port'].'/'.$apps[0]['application_name'].'/'.$path[sizeof($path)-1];
										}
										?>
										<input type="text" class="form-control" placeholder="" name="streamurl" id="streamurl" readonly="true" value="<?php echo $SURL; ?>" required="true">
										<i type="button" class="fa fa-edit btn btedit" onclick="enableEdit();"></i>
										<?php
									}
									else
									{
										?>
										<input type="text" class="form-control" placeholder="" name="streamurl" id="streamurl" readonly="true">
										<i type="button" class="fa fa-edit btn btedit" onclick="enableEdit();"></i>
										<?php
									}
									?>
									
								</div>
							</div>
                        
                  </div>
               </div>
        </div>
    </div>
</div>
<!-- Facebook Popup End -->
<!-- Youtube Popup Start -->
<div class="modal fade" id="workflow_youtube_targetPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                <div class="card-body">
                    <div class="tab-btn-container">
                    	<a href="#"><i class="fa fa-gear iconn"></i></a>
                        <input type="button" class="btn-def save save_wf_fb" value="Save"/>
                    </div>
                    <div class="col-lg-12 apndendoers"><div class="row"><hr></div></div>                    
                        <div class="form-group col-lg-12">
								<div class="row">
									<label>Target Name</label>
									<input type="text" class="form-control" placeholder="" name="target_name" id="target_name" required="true">
								</div>
							</div>
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Select Application</label>
									<select class="form-control selectpicker" name="wowzaengin" id="wowzaengin" onchange="showApplicationURL(this.value);" required="true">
										<option value="0">-- Select --</option>
										 <?php																				$selected = $this->uri->segment(3);
										 	
									
											if(sizeof($apps)>0)
											{
												foreach($apps as $app)
												{
													if($selected != "" && $selected > 0 && $selected == $app['id'])
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
									<?php
									if($selected != "" && $selected > 0)
									{
										$apps = $this->common_model->getApplicationStreams($selected);
										$wid = $apps[0]['live_source'];
										$wowza = $this->common_model->getWovzData($wid);
										$path = explode("/",$apps[0]['wowza_path']);
										$SURL="";
										if(sizeof($wowza)>0)
										{
											$SURL = 'rtmp://'.$wowza[0]['ip_address'].':'.$wowza[0]['rtmp_port'].'/'.$apps[0]['application_name'].'/'.$path[sizeof($path)-1];
										}
										?>
										<input type="text" class="form-control" placeholder="" name="streamurl" id="streamurl" readonly="true" value="<?php echo $SURL; ?>" required="true">
										<i type="button" class="fa fa-edit btn btedit" onclick="enableEdit();"></i>
										<?php
									}
									else
									{
										?>
										<input type="text" class="form-control" placeholder="" name="streamurl" id="streamurl" readonly="true">
										<i type="button" class="fa fa-edit btn btedit" onclick="enableEdit();"></i>
										<?php
									}
									?>
									
								</div>
							</div>
                        
                  </div>
               </div>
        </div>
    </div>
</div>
<!-- Youtube Popup End -->
<!-- Twitch Popup Start -->
<div class="modal fade" id="workflow_twitch_targetPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                <div class="card-body">
                    <div class="tab-btn-container">
                    	<a href="#"><i class="fa fa-gear iconn"></i></a>
                        <input type="button" class="btn-def save save_wf_fb" value="Save"/>
                    </div>
                    <div class="col-lg-12 apndendoers"><div class="row"><hr></div></div>                    
                        <div class="form-group col-lg-12">
								<div class="row">
									<label>Target Name</label>
									<input type="text" class="form-control" placeholder="" name="target_name" id="target_name" required="true">
								</div>
							</div>
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Select Application</label>
									<select class="form-control selectpicker" name="wowzaengin" id="wowzaengin" onchange="showApplicationURL(this.value);" required="true">
										<option value="0">-- Select --</option>
										 <?php																				$selected = $this->uri->segment(3);
										 	
									
											if(sizeof($apps)>0)
											{
												foreach($apps as $app)
												{
													if($selected != "" && $selected > 0 && $selected == $app['id'])
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
									<?php
									if($selected != "" && $selected > 0)
									{
										$apps = $this->common_model->getApplicationStreams($selected);
										$wid = $apps[0]['live_source'];
										$wowza = $this->common_model->getWovzData($wid);
										$path = explode("/",$apps[0]['wowza_path']);
										$SURL="";
										if(sizeof($wowza)>0)
										{
											$SURL = 'rtmp://'.$wowza[0]['ip_address'].':'.$wowza[0]['rtmp_port'].'/'.$apps[0]['application_name'].'/'.$path[sizeof($path)-1];
										}
										?>
										<input type="text" class="form-control" placeholder="" name="streamurl" id="streamurl" readonly="true" value="<?php echo $SURL; ?>" required="true">
										<i type="button" class="fa fa-edit btn btedit" onclick="enableEdit();"></i>
										<?php
									}
									else
									{
										?>
										<input type="text" class="form-control" placeholder="" name="streamurl" id="streamurl" readonly="true">
										<i type="button" class="fa fa-edit btn btedit" onclick="enableEdit();"></i>
										<?php
									}
									?>
									
								</div>
							</div>
                        
                  </div>
               </div>
        </div>
    </div>
</div>
<!-- Twitch Popup End -->
<!-- Twitter Popup Start -->
<div class="modal fade" id="workflow_twitter_targetPopup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
       		<div class="content-box config-contentonly">
                <div class="card-body">
                    <div class="tab-btn-container">
                    	<a href="#"><i class="fa fa-gear iconn"></i></a>
                        <input type="button" class="btn-def save save_wf_fb" value="Save"/>
                    </div>
                    <div class="col-lg-12 apndendoers"><div class="row"><hr></div></div>                    
                        <div class="form-group col-lg-12">
								<div class="row">
									<label>Target Name</label>
									<input type="text" class="form-control" placeholder="" name="target_name" id="target_name" required="true">
								</div>
							</div>
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Select Application</label>
									<select class="form-control selectpicker" name="wowzaengin" id="wowzaengin" onchange="showApplicationURL(this.value);" required="true">
										<option value="0">-- Select --</option>
										 <?php																				$selected = $this->uri->segment(3);
										 	
									
											if(sizeof($apps)>0)
											{
												foreach($apps as $app)
												{
													if($selected != "" && $selected > 0 && $selected == $app['id'])
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
									<?php
									if($selected != "" && $selected > 0)
									{
										$apps = $this->common_model->getApplicationStreams($selected);
										$wid = $apps[0]['live_source'];
										$wowza = $this->common_model->getWovzData($wid);
										$path = explode("/",$apps[0]['wowza_path']);
										$SURL="";
										if(sizeof($wowza)>0)
										{
											$SURL = 'rtmp://'.$wowza[0]['ip_address'].':'.$wowza[0]['rtmp_port'].'/'.$apps[0]['application_name'].'/'.$path[sizeof($path)-1];
										}
										?>
										<input type="text" class="form-control" placeholder="" name="streamurl" id="streamurl" readonly="true" value="<?php echo $SURL; ?>" required="true">
										<i type="button" class="fa fa-edit btn btedit" onclick="enableEdit();"></i>
										<?php
									}
									else
									{
										?>
										<input type="text" class="form-control" placeholder="" name="streamurl" id="streamurl" readonly="true">
										<i type="button" class="fa fa-edit btn btedit" onclick="enableEdit();"></i>
										<?php
									}
									?>
									
								</div>
							</div>
                        
                  </div>
               </div>
        </div>
    </div>
</div>
<!-- Twitter Popup End -->
