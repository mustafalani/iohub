<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<script type="text/javascript">
	var EncInputs = "";
	var EncOutputs = "";
	var encoderModelOutFormat ="";
	var encoderModelsCount = "";
	var encoderharwareCount = 0;
	var encoderModelFirstSelection = 0;
	var encoderModelSecondSelection = 0;
	var encoderModelThirdSelection = 0;
	var encoderModelInputs = [];
	var encoderModelOutputs = [];
</script>
<?php
$modelsArray = array();
$outputFormatArray = array();
$models = $this->common_model->getAllModels();
$outputFormat = $this->common_model->getOutputFormats();
if(sizeof($outputFormat) > 0)
{
	foreach($outputFormat as $outformt)
	{
		array_push($outputFormatArray,array('id'=>$outformt['item'],'value'=>$outformt['value']));
	}
}
if(sizeof($models) > 0)
{
	foreach($models as $md)
	{
		$modelsArray[$md['id']] = 0;
	}
}
 $inputs = $this->common_model->getEncoderInputs();
 $outputs = $this->common_model->getEncoderOutput();
 $inputEnc = array();
 $outputEnc = array();
if(sizeof($inputs) > 0)
{
	foreach($inputs as $input)
	{
		$inputEnc[$input['type']][] = array('id'=>$input['id'],'value'=>$input['item']);
	}
}

if(sizeof($outputs) > 0)
{
	foreach($outputs as $output)
	{
		if($output['id'] != 5)
		{
			$outputEnc[$output['type']][] = array('id'=>$output['id'],"value"=>$output['item']);
		}
	}
}
?>
<?php
echo '<script type="text/Javascript">EncInputs ='.json_encode($inputEnc).';</script>';
echo '<script type="text/Javascript">EncOutputs ='.json_encode($outputEnc).';</script>';
echo '<script type="text/Javascript">encoderModelsCount='.json_encode($modelsArray).';</script>';
echo '<script type="text/Javascript">encoderModelOutFormat='.json_encode($outputFormatArray).';</script>';
?>
<style type="text/css">
	.pd-13
	{
		padding-top: 13px;
	}
	.minlink
	{
		padding-left: 5px;
		padding-right: 5px;

	}
	.hdAdd
	{
		border: 1px dotted #515151;
		padding: 12px;
		border-radius: 5px;
		color: #515151;
		margin-top: 20px;
		display: block;
		width: 50px;
		height: 50px;
		float: left;
		text-align: center;
		font-size: 19px;
	}
	.action-table table.table {
    min-width: auto !important;
}
</style>
<style type="text/css">
.irs-slider {

    width: 6px !important;
    height: 27px !important;
    border: 1px solid #AAA !important;
    background: #3AA6D9 !important;
    border-radius: 0px !important;
}
.irs-grid span.small
{
	display: none !important;
}
.ht span.irs-with-grid {

    height: 49px !important;
}
.irs-line {
    top: 9px !important;
}
.irs-bar{
    top: 9px !important;
    display: none !important;
}
.irs-bar-edge{
    top: 9px !important;
    display: none !important;
}
.irs-slider {
	top:0px !important;
}
.irs-min, .irs-max {
    display: none !important;
}
.irs-from, .irs-to, .irs-single {
	display: none !important;
}
	.ht > span.text-blue {

    display: block;
    height: 25px;
    color: #1C6B98 !important;

}

	.outpt
	{
		position: absolute;
		color: white;
		border: none;
		min-width: 47px;
		left: -13px;
		top: 18px;
		background: #3C8DBC;
		padding-left: 5px;
		padding-right: 5px;
		border-radius: 3px;
	}
</style>
<link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/css/ion.rangeSlider.css"/>
<link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/css/ion.rangeSlider.skinHTML5.css"/>
  <main class="main">
  	   <!-- Breadcrumb-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Home</a>
        </li>
        <li class="breadcrumb-item active"><a href="configuration">Settings</a></li>
        <li class="breadcrumb-item active">New Encoder</li>
      </ol>
      <div class="container-fluid">
      	<div class="animated fadeIn">
           <div class="card">
           <form id="wowza-form" class="action-table" method="post" action="<?php echo site_url();?>admin/saveEncoder" enctype="multipart/form-data">
						 <div class="card-header">Add New Encoder</div>
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
						<div class="col-md-12 mb-4">
							
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								<ul class="nav nav-tabs" role="tablist" id="configuration">
              						<li class="nav-item" role="presentation">
              							<a class="nav-link active" id="generaltab" href="#general" aria-controls="systems" role="tab" data-toggle="tab">General</a></li>
             						<li class="nav-item"  role="presentation">
             							<a class="nav-link" id="hardwaretabs" href="#hardware" aria-controls="wowza" role="tab" data-toggle="tab">Hardware</a></li>
									<li class="nav-item" role="presentation">
										<a class="nav-link" id="inputsTab" href="#inputs" aria-controls="ffmpeg" role="tab" data-toggle="tab">Inputs</a></li>
									<li class="nav-item" role="presentation">
										<a class="nav-link" id="ouptputsTab" href="#outputs" aria-controls="ffmpeg" role="tab" data-toggle="tab">Outputs</a></li>
									<li class="nav-item" role="presentation">
										<a class="nav-link" id="recordingsTab" href="#recordings" aria-controls="Encoding Templates" role="tab" data-toggle="tab">Recordings</a></li>
								</ul>
								<!--<button type="submit" class="btn btn-primary add-btn float-right" style="position: absolute;right: 18px;top: -9px;">
									<span>Save</span>
								</button>-->
								<div class="tab-content">
								<div role="tabpanel" class="tab-pane pd-13 active" id="general">
									<div class="row">
										<div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                            <label>Encoder Name <span class="mndtry">*</span></label>
                                                            <input type="text" name="encoder_name" id="encoder_name" class="form-control" required="true"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label>IP Address <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control" id="encoder_ip" name="encoder_ip" required="true"/>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>SSH Port <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control" id="encoder_port" name="encoder_port" required="true"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label>User Name <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control" id="encoder_uname" name="encoder_uname" required="true">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Password <span class="mndtry">*</span></label>
                                                                    <input type="password" class="form-control" id="encoder_pass" name="encoder_pass" required="true">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                    	<?php
                                                                    	if($userdata['user_type']==1)
                                                                    	{
																			?>
																			 <div class="col-md-8">
                                                                            <label>Assigned to</label>
                                                                            <select class="form-control selectpicker" name="encoder_group" id="encoder_group">
                                                                                <option value="0">-- Select --</option>
                                                                                <?php
																					if(sizeof($groups)>0)
																					{
																						$counter =1;
																						foreach($groups as $group)
																						{
																							?>
																							<option value="<?php echo $group['id'];?>"><?php echo $group['group_name'];?></option>
																							<?php
																						}
																					}
																				?>
                                                                            </select>
                                                                        </div>
																			<?php
																		}
																		else
																		{
																		?>
																		 <div class="col-md-8 dnone">
                                                                            <label>Assigned to</label>
                                                                            <select class="form-control selectpicker" name="encoder_group" id="encoder_group">
                                                                                <option value="0">-- Select --</option>
                                                                                <?php
																					if(sizeof($groups)>0)
																					{
																						$counter =1;
																						foreach($groups as $group)
																						{
																							?>
																							<option value="<?php echo $group['id'];?>"><?php echo $group['group_name'];?></option>
																							<?php
																						}
																					}
																				?>
                                                                            </select>
                                                                        </div>
																		<?php
																		}
                                                                    	?>
                                                                    </div>
                                                        </div>
                                                        <div class="form-group">


                                                                      <div class="check-input">
                                                                        <div class="boxes">
                                                                          <input id="encoder_enable_netdata" name="encoder_enable_netdata" type="checkbox">
                                                                          <label for="encoder_enable_netdata" style="padding-left:25px;">Enable Netdata Monitoring</label>
                                                                        </div>
                                                                      </div>


                                                                    </div>
                                                                    <div class="form-group">


                                                                      <div class="check-input">
                                                                        <div class="boxes">
                                                                          <input id="encoder_enable_hdmi_out" name="encoder_enable_hdmi_out" type="checkbox">
                                                                          <label for="encoder_enable_hdmi_out" style="padding-left:25px;">Enable PC Output</label>
                                                                        </div>

                                                                    </div>
                                                                    </div>
                                                        </div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane pd-13 fade" id="hardware">
									<div class="row">
										<div class="col-lg-3 col-md-12 hardware-box">
                                        <div class="form-group">
                                                            <label>Hardware <span class="mndtry">*</span></label>
                                                            <select class="form-control selectpicker" name="encoder_hardware" id="encoder_hardware" required="true">
                                                                <option value="0">-- none --</option>
                                                               <?php
                                                                $hardware = $this->common_model->getAllHardware();
                                                                if(sizeof($hardware)>0)
                                                                {
																	foreach($hardware as $hard)
																	{
																		echo '<option value="'.$hard['id'].'">'.$hard['item'].'</option>';
																	}
																}
                                                                ?>
                                                            </select>
                                                        </div>
                                        <div class="form-group">
                                                            <label>Model <span class="mndtry">*</span></label>
                                                            <select class="form-control selectpicker" name="encoder_model" id="encoder_model" required="true">
                                                                <option value="0">-- none --</option>
                                                               <?php
                                                                $model = $this->common_model->getAllModels();
                                                                if(sizeof($model)>0)
                                                                {
																	foreach($model as $modl)
																	{
																		if($modl['status'] == 1)
																		{
																			echo '<option value="'.$modl['id'].'">'.$modl['item'].'</option>';
																		}
																		else if($modl['status'] == 0)
																		{
																			echo '<option disabled="disabled" value="'.$modl['id'].'">'.$modl['item'].'</option>';
																		}

																	}
																}
                                                                ?>
                                                            </select>
                                                        </div>
                                     </div>
                                     <a href="javascript:void(0);" class="hdAdd"><i class="fa fa-plus"></i></a>
									</div>


								</div>
								<div role="tabpanel" class="tab-pane pd-13 fade" id="inputs">
									<div class="col-lg-12 col-md-12">

											<div class="box-header">
                                                    <a class="btn btn-primary add-btn" id="add_encoder_inputs" href="javascript:void(0);">
                                                        <span><i class="fa fa-plus"></i> Input</span>
													</a>
												</div>
										<br/>
										<div class="table-responsive no-padding">
											<table class="cstmtable table table-hover check-input hardware_input_table">
	                                     		<thead>
	                                     			<th>Label</th>
	                                     			<th>Video Source</th>
	                                                <th>Audio Source</th>
	                                                <th>Status</th>
	                                                <th>Delete</th>
	                                     		</thead>
	                                     		<tbody>
	                                     			<tr class="emptyrow">
	                                     				<td colspan="5">No Inputs Created Yet!</td>
	                                     			</tr>
	                                     		</tbody>
										 </table>
										</div>
                                      </div>
								</div>
								<div role="tabpanel" class="tab-pane pd-13 fade" id="outputs">
									<div class="col-lg-12 col-md-12">
										<div class="box-header">
                                                    <a class="btn btn-primary add-btn" id="add_encoder_outputs" href="javascript:void(0);">
                                                        <span><i class="fa fa-plus"></i> Output</span>
													</a>
												</div>
												<br/>
												<div class="table-responsive no-padding">
													 <table class="cstmtable table table-hover check-input hardware_output_table">
	                                     		<thead>
	                                     			<th>Label</th>
	                                     			<th>Video Destination</th>
	                                     			<th>Output Format</th>
	                                                <th>Status</th>
	                                                <th>Delete</th>

	                                     		</thead>
	                                     		<tbody>
	                                     			<tr class="emptyrow">
	                                     				<td colspan="5">No Outputs Created Yet!</td>
	                                     			</tr>
	                                     		</tbody>
										 </table>
												</div>


                                     </div>
								</div>
								<div role="tabpanel" class="tab-pane pd-13 fade" id="recordings">
									 <div class="action-table">
			                           <div class="enc-template-form" id="enc_template_form">
			                              <div class="row">
			                                    <div class="col-lg-12 col-md-12">

			                                       <div class="check-input">
			                                          <div class="boxes">
			                                             <input type="checkbox" id="enable_recording_on_local_disk" name="enable_recording_on_local_disk">
			                                             <label for="enable_recording_on_local_disk" style="padding-left:25px;">Enable Recording On The Local Disk</label>
			                                          </div>
			                                       </div>
			                                        <br/>
			                                       <div class="check-input isdefaultrecording_preset">
			                                          <div class="boxes">
			                                             <input type="checkbox" id="is_default_recording_preset" name="is_default_recording_preset">
			                                             <label for="is_default_recording_preset" style="padding-left:25px;">Enable Default Recording Preset</label>
			                                          </div>
			                                       </div>
			                                       <br/>
			                                       <div class="row">
			                                       	   <div class="col-lg-4 col-md-12">
			                                       <div class="form-group enbleVidDefault">
			                                          <div class="check-input enbleVid">
			                                             <div class="boxes">
			                                                <input type="checkbox" id="enableVideo" name="enableVideo">
			                                                <label for="enableVideo" style="padding-left:25px;">VIDEO</label>
			                                             </div>
			                                          </div>
			                                          <div class="row">
			                                             <div class="col-md-6 ht">
			                                                <span class="text-blue">Codec</span>
			                                                <select class="form-control selectpicker" name="video_codec" id="video_codec">
			                                               	   <option value="0">-- Select --</option>
			                                                   <option value="libx264">H.264</option>
			                                                   <option value="libx265">HEVC</option>
			                                                </select>
			                                             </div>
			                                             <div class="col-md-6 ht">
			                                                <span class="text-blue">Resolution</span>
			                                                <select class="form-control selectpicker" name="video_resolution" id="video_resolution">
			                                                   <option value="0">-- Select --</option>
			                                                   <option value="qvga">320x240</option>
			                                                   <option value="vga">640x480</option>
			                                                   <option value="ntsc">NTSC (720x480)</option>
			                                                   <option value="pal">PAL (720x576)</option>
			                                                   <option value="hd480">480P (852x480)</option>
			                                                   <option value="hd720">720P (1280x720)</option>
			                                                   <option value="hd1080">1080P (1920x1080)</option>
			                                                   <option value="2k">2K (2048x1080)</option>
			                                                   <option value="4k">4K (4096x2160)</option>
			                                                </select>
			                                             </div>
			                                             <div class="col-md-6 ht">
			                                                <span class="text-blue">Bitrate (kbps)</span>
			                                                <input type="number" class="form-control" id="video_bitrate" name="video_bitrate">
			                                             </div>
			                                             <div class="col-md-6 ht">
			                                                <span class="text-blue">Framerate (fps)</span>
			                                                <input type="number" class="form-control" id="video_framerate" name="video_framerate" step="any">
			                                             </div>
			                                             <div class="col-md-6 ht">
			                                                <span class="text-blue">Min. Bitrate (kbps)</span>
			                                                <input type="number" class="form-control" id="video_min_bitrate" name="video_min_bitrate" step="any">
			                                             </div>
			                                             <div class="col-md-6 ht">
			                                                <span class="text-blue">Max. Bitrate (kbps)</span>
			                                                <input type="number" class="form-control" id="video_max_bitrate" name="video_max_bitrate" step="any">
			                                             </div>
			                                          </div>
			                                       </div>
			                                       <div class="form-group">
			                                          <div class="check-input advance_vid_setting">
			                                             <div class="boxes">
			                                                <input type="checkbox" id="advance_video_setting" name="advance_video_setting">
			                                                <label for="advance_video_setting" style="padding-left:25px;">ADVANCED VIDEO ENCODING</label>
			                                             </div>
			                                          </div>
			                                          <div class="row" id="advance_video_ch">
			                                             <div class="col-md-6 ht">
			                                                <span class="text-blue">Preset</span>
			                                                <select class="form-control selectpicker" name="adv_video_min_bitrate" id="adv_video_min_bitrate">
			                                                	<option value="0">-- Select --</option>
			                                                    <option value="ultrafast">Ultrafast</option>
			                                                    <option value="superfast">Superfast</option>
			                                                    <option value="veryfast">Veryfast</option>
			                                                    <option value="faster">Faster</option>
			                                                    <option value="fast">Fast</option>
			                                                    <option value="medium">Medium</option>
			                                                    <option value="slow">Slow</option>
			                                                    <option value="slower">Slower</option>
			                                                    <option value="veryslow">Veryslow</option>
			                                                    <option value="placebo">Placebo</option>
			                                                </select>
			                                             </div>
			                                             <div class="col-md-6 ht">
			                                                <span class="text-blue">Profile</span>
			                                                <select class="form-control selectpicker" name="adv_video_max_bitrate" id="adv_video_max_bitrate">
			                                                	<option value="0">-- Select --</option>
			                                                    <option value="baseline">Baseline</option>
			                                                    <option value="main">Main</option>
			                                                    <option value="high">High</option>
			                                                    <option value="high10">High10</option>
			                                                    <option value="High422">High422</option>
			                                                    <option value="High444">High444</option>
			                                                </select>
			                                             </div>
			                                             <div class="col-md-6 ht">
			                                                <span class="text-blue">Buffer Size (kbps)</span>
			                                                <input type="number" class="form-control" id="adv_video_buffer_size" name="adv_video_buffer_size">
			                                             </div>
			                                             <div class="col-md-6 ht">
			                                                <span class="text-blue">GOP</span>
			                                                <input type="number" class="form-control" id="adv_video_gop" name="adv_video_gop">
			                                             </div>
			                                             <div class="col-md-6 ht">
			                                                <span class="text-blue">Keyframe Interval</span>
			                                                <input type="number" class="form-control" id="adv_video_keyframe_intrval" name="adv_video_keyframe_intrval">
			                                             </div>
			                                          </div>
			                                       </div>
			                                       <div class="check-input deinterlanc">
			                                          <div class="boxes">
			                                             <input type="checkbox" id="enabledeinterlance" name="enabledeinterlance">
			                                             <label for="enabledeinterlance" style="padding-left:25px;">Enable Deinterlace</label>
			                                          </div>
			                                       </div>
			                                       <br/>
			                                       <div class="check-input latency">
			                                          <div class="boxes">
			                                             <input type="checkbox" id="enablezerolatency" name="enablezerolatency">
			                                             <label for="enablezerolatency" style="padding-left:25px;">Enable Zero Latency</label>
			                                          </div>
			                                       </div>
			                                    </div>
			                                    <div class="col-lg-4 col-md-12 enableAudioEnc">
			                                       <div class="form-group">
			                                          <div class="check-input">
			                                             <div class="boxes">
			                                                <input type="checkbox" id="audio_check" name="audio_check">
			                                                <label for="audio_check" style="padding-left:25px;">AUDIO</label>
			                                             </div>
			                                          </div>
			                                          <div class="row">
			                                             <div class="col-md-6 ht">
			                                                <span class="text-blue">Codec</span>
			                                                <select class="form-control selectpicker" name="audio_codec" id="audio_codec">
			                                                	<option value="">--Select--</option>
			                                                   <option value="aac">AAC</option>
			                                                   <option value="libopus">Libopus</option>

			                                                </select>
			                                             </div>
			                                             <div class="col-md-6 ht">
			                                                <span class="text-blue">Channels</span>
			                                                <select class="form-control selectpicker" name="audio_channel" id="audio_channel">
			                                                   <option value="">--Select--</option>
			                                                   <option value="1">Mono</option>
			                                                   <option value="2">Stereo</option>
			                                                </select>
			                                             </div>
			                                             <div class="col-md-6 ht">
			                                                <span class="text-blue">Bitrate (kbps)</span>
			                                                <select class="form-control selectpicker" name="audio_bitrate" id="audio_bitrate">
			                                                   <option value="">--Select--</option>
			                                                   <option value="64">64</option>
			                                                   <option value="96">96</option>
			                                                   <option value="128">128</option>
			                                                   <option value="144">144</option>
			                                                   <option value="160">160</option>
			                                                   <option value="192">192</option>
			                                                   <option value="256">256</option>
			                                                </select>
			                                             </div>
			                                             <div class="col-md-6 ht">
			                                                <span class="text-blue">Sample Rate</span>
			                                                <select class="form-control selectpicker" name="audio_sample_rate" id="audio_sample_rate">
			                                                	<option value="">--Select--</option>
			                                                   <option value="44100">44.1 khz</option>
			                                                   <option value="48000">48 khz</option>
			                                                   <option value="88200">88.2 khz</option>
			                                                   <option value="96000">96 khz</option>
			                                                   <option value="192000">192 khz</option>
			                                                </select>
			                                             </div>
			                                          </div>
			                                       </div>
			                                       <div class="form-group">
			                                          <div class="check-input enableAdvanceAudio">
			                                             <div class="boxes">
			                                                <input type="checkbox" id="enableAdvanceAudio" name="enableAdvanceAudio">
			                                                <label for="enableAdvanceAudio" style="padding-left:25px;">ADVANCED AUDIO ENCODING</label>
			                                             </div>
			                                          </div>
			                                          <div class="row adv_audio">
			                                             <div class="col-md-9 ht">
			                                                <span class="text-blue">Audio Gain </span>

			                                                <input type="text" id="rangeslider" name="rangeslider" value="0"/>




			                                                <datalist id="audio_gain" name="audio_gain">
			                                                   <option value="-20dB" label="-20dB">
			                                                   <option value="-15dB">
			                                                   <option value="-10dB">
			                                                   <option value="-5dB">
			                                                   <option value="0dB" label="0">
			                                                   <option value="5dB">
			                                                   <option value="10dB">
			                                                   <option value="15dB">
			                                                   <option value="20dB" label="+20dB">
			                                                </datalist>

			                                             </div>
			                                             <div class="col-md-6 ht">
			                                             <br/>
			                                             <span class="text-blue">Delay (ms)</span>
			                                             <input type="number" id="delay" name="delay" class="form-control">
			                                             </div>
			                                          </div>
			                                       </div>
			                                    </div>
			                                       </div>

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
