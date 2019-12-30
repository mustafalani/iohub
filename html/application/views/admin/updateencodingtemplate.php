<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
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
          <a href="<?php echo site_url();?>">Home</a>
        </li>
        <li class="breadcrumb-item active"><a href="<?php echo site_url();?>configuration">Settings</a></li>
        <li class="breadcrumb-item active"><?php echo $template[0]['template_name'];?></li>
      </ol>
      <div class="container-fluid">
      	<div class="animated fadeIn">
           <div class="card">
           
            <form id="wowza-form" class="action-table" method="post" action="<?php echo site_url();?>admin/updateEncoderTemplate/<?php echo $template[0]['id'];?>" enctype="multipart/form-data">
           
             <div class="card-header">Edit Encoding Preset</div>
				<div class="card-body">
				<div class="row">
         <!-- ========= Section One Start ========= -->
         <div class="col-lg-12 col-12-12">
            <div class="content-box config-contentonly">
               <div class="config-container">
               	
               	 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                  <!-- === Nav tabs === -->
                  <div class="col-lg-12 conf" id="">
                  <div class=" sav-btn-dv">
                  		 <!-- <button type="submit" class="btn-def save btn btn-primary float-right">
								<span>Update</span>
							</button>-->
              
							</div>
                      </div>
                      <div class="row"><div class="col-lg-12">
                  <!-- === Tab panes === -->
                     <div role="tabpanel" class="tab-pane active" id="groups">
                        <div class="action-table">
                           <div class="enc-template-form" id="enc_template_form">
                              <div class="row">
                                    <div class="col-lg-4 col-md-12">
                                       <div class="form-group">
                                          <label>Preset Name <span class="mndtry">*</span></label>
                                          <input type="text" class="form-control" id="template_name" name="template_name" value="<?php echo $template[0]['template_name'];?>"/>
                                       </div>
                                       <div class="form-group">
                                          <div class="check-input">
                                             <div class="boxes">
                                             	<?php
                                             	if($template[0]['enableVideo'] == 1)
                                             	{
												?>
												 <input type="checkbox" id="enableVideo" name="enableVideo" checked="checked"/>
												<?php
												}
												else if($template[0]['enableVideo'] == 0)
                                             	{
													?>
													 <input type="checkbox" id="enableVideo" name="enableVideo"/>
													<?php
												}
                                             	?>

                                                <label for="enableVideo" style="padding-left:25px;">VIDEO</label>
                                             </div>
                                          </div>
                                          <div class="row">
                                          	<?php

                                          		if($template[0]['enableVideo'] == "1")
                                             	{

                                             	?>
                                             	<div class="col-md-6"  style="display:block;">
                                                <span class="text-blue">Codec</span>
                                                <select class="form-control selectpicker" name="video_codec" id="video_codec">
                                               	   <option value="">-- Select --</option>
                                               	   <?php
                                               	   $codec = $this->common_model->getVideoCodec();
                                               	   if(sizeof($codec)>0)
                                               	   {
													   	foreach($codec as $codac)
													   	{
													   		if($codac['value'] == $template[0]['video_codec'])
													   		{
															?>
															<option selected="selected" value="<?php echo $codac['value'];?>"><?php echo $codac['item'];?></option>
															<?php
															}
															else
															{
															?>
															<option value="<?php echo $codac['value'];?>"><?php echo $codac['item'];?></option>
															<?php
															}
														}
												   }
                                               	   ?>
                                                </select>
                                             </div>
                                             <div class="col-md-6"  style="display:block;">
                                                <span class="text-blue">Resolution</span>
                                                <select class="form-control selectpicker" name="video_resolution" id="video_resolution">
                                                   <option value="">-- Select --</option>
                                                    <?php
                                                   $resolution = $this->common_model->getResolution();
                                                   if(sizeof($resolution)>0)
                                                   {
												   	foreach($resolution as $reso)
												   	{
												   		if($template[0]['video_resolution'] == $reso['value'])
												   		{
														echo '<option selected="selected" value="'.$reso['value'].'">'.$reso['name'].'</option>';
														}
														else
														{
														echo '<option value="'.$reso['value'].'">'.$reso['name'].'</option>';
														}
													}
												   }
                                                   ?>
                                                </select>
                                             </div>
                                             <div class="col-md-6"  style="display:block;">
                                             	<br/>
                                                <span class="text-blue">Bitrate (kbps)</span>
                                                <input type="number" class="form-control" id="video_bitrate" name="video_bitrate" value="<?php echo $template[0]['video_bitrate'];?>">
                                             </div>
                                             <div class="col-md-6"  style="display:block;">
                                             <br/>
                                                <span class="text-blue">Framerate (fps)</span>
                                                <input type="number" class="form-control" id="video_framerate" name="video_framerate" value="<?php echo $template[0]['video_framerate'];?>"/>
                                             </div>
                                             <div class="col-md-6"  style="display:block;">
                                             <br/>
                                                <span class="text-blue">Min. Bitrate (kbps)</span>
                                                <input type="number" class="form-control" id="video_min_bitrate" name="video_min_bitrate" value="<?php echo $template[0]['video_min_bitrate'];?>">
                                             </div>
                                             <div class="col-md-6"  style="display:block;">
                                             <br/>
                                                <span class="text-blue">Max. Bitrate (kbps)</span>
                                                <input type="number" class="form-control" id="video_max_bitrate" name="video_max_bitrate" value="<?php echo $template[0]['video_max_bitrate'];?>">
                                             </div>
                                             	<?php
												}
												else
												{
													?>
													<div class="col-md-6 ht">
                                                <span class="text-blue">Codec</span>
                                                <select class="form-control selectpicker" name="video_codec" id="video_codec">
                                               	   <option value="">-- Select --</option>
                                                    <?php
                                               	   $codec = $this->common_model->getVideoCodec();
                                               	   if(sizeof($codec)>0)
                                               	   {
													   	foreach($codec as $codac)
													   	{
													   		if($codac['value'] == $template[0]['video_codec'])
													   		{
															?>
															<option selected="selected" value="<?php echo $codac['value'];?>"><?php echo $codac['item'];?></option>
															<?php
															}
															else
															{
															?>
															<option value="<?php echo $codac['value'];?>"><?php echo $codac['item'];?></option>
															<?php
															}
														}
												   }
                                               	   ?>
                                                </select>
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Resolution</span>
                                                <select class="form-control selectpicker" name="video_resolution" id="video_resolution">
                                                   <option value="">-- Select --</option>
                                                   <?php
                                                   $resolution = $this->common_model->getResolution();
                                                   if(sizeof($resolution)>0)
                                                   {
												   	foreach($resolution as $reso)
												   	{
														echo '<option value="'.$reso['value'].'">'.$reso['name'].'</option>';
													}
												   }
                                                   ?>
                                                </select>
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Bitrate (kbps)</span>
                                                <input type="number" class="form-control" id="video_bitrate" name="video_bitrate" value="1000ggg">
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Framerate (fps)</span>
                                                <input type="number" class="form-control" value="30" id="video_framerate" name="video_framerate">
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Min. Bitrate (kbps)</span>
                                                <input type="number" class="form-control" id="video_min_bitrate" name="video_min_bitrate">
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Max. Bitrate (kbps)</span>
                                                <input type="number" class="form-control" id="video_max_bitrate" name="video_max_bitrate">
                                             </div>
													<?php
												}
                                          	?>

                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <div class="check-input advance_vid_setting" style="display:block;">
                                             <div class="boxes">
                                             <?php
                                             if($template[0]['advance_video_setting'] == 0)
                                             {
											  ?>
											  <input type="checkbox" id="advance_video_setting" name="advance_video_setting"/>
											 <?php
											 }
											 elseif($template[0]['advance_video_setting'] == 1)
                                             {
											 ?>
											  <input checked="true" type="checkbox" id="advance_video_setting" name="advance_video_setting"/>
											 <?php
											 }
                                             ?>

                                                <label for="advance_video_setting" style="padding-left:25px;">ADVANCED VIDEO ENCODING</label>
                                             </div>
                                          </div>
                                          <?php
                                          if($template[0]['advance_video_setting'] == 1)
                                          {
                                          	?>
										  	<div class="row"  id="advance_video_ch">
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Preset</span>
                                                <select class="form-control selectpicker" name="adv_video_min_bitrate" id="adv_video_min_bitrate">
                                                <option value="">-- Select --</option>
                                                    <?php
                                                   $videoPreset = $this->common_model->getVideoPreset();
                                                   if(sizeof($videoPreset)>0)
                                                   {
												   	foreach($videoPreset as $vp)
												   	{
												   		if($template[0]['adv_video_preset'] == $vp['value'])
												   		{
														echo '<option selected="selected" value="'.$vp['value'].'">'.$vp['name'].'</option>';
														}
														else
														{
														echo '<option value="'.$vp['value'].'">'.$vp['name'].'</option>';
														}
													}
												   }
                                                   ?>
                                                </select>
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Profile</span>
                                                <select class="form-control selectpicker" name="adv_video_max_bitrate" id="adv_video_max_bitrate">
                                                <option value="">-- Select --</option>
                                                  <?php
                                                   $videoProfile = $this->common_model->getVideoProfile();
                                                   if(sizeof($videoProfile)>0)
                                                   {
												   	foreach($videoProfile as $vpef)
												   	{
												   		if($template[0]['adv_video_profile'] == $vpef['value'])
												   		{
														echo '<option selected="selected" value="'.$vpef['value'].'">'.$vpef['name'].'</option>';
														}
														else
														{
														echo '<option value="'.$vpef['value'].'">'.$vpef['name'].'</option>';
														}
													}
												   }
                                                   ?>
                                                </select>
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Buffer Size (kbps)</span>
                                                <input type="number" class="form-control" id="adv_video_buffer_size" name="adv_video_buffer_size" value="<?php echo $template[0]['adv_video_buffer_size'];?>">
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">GOP</span>
                                                <input type="number" class="form-control" id="adv_video_gop" name="adv_video_gop" value="<?php echo $template[0]['adv_video_gop'];?>">
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Keyframe Interval</span>
                                                <input type="number" class="form-control" id="adv_video_keyframe_intrval" name="adv_video_keyframe_intrval" value="<?php echo $template[0]['adv_video_keyframe_intrval'];?>">
                                             </div>
                                          </div>
										  	<?php
                                          }
                                          else
                                          {
										  	?>
										  	<div class="row dnone">
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Preset</span>
                                                <select class="form-control selectpicker" name="adv_video_min_bitrate" id="adv_video_min_bitrate">
                                                <option value="">-- Select --</option>
                                                    <?php
                                                   $videoPreset = $this->common_model->getVideoPreset();
                                                   if(sizeof($videoPreset)>0)
                                                   {
												   	foreach($videoPreset as $vp)
												   	{
												   		if($template[0]['adv_video_preset'] == $vp['value'])
												   		{
														echo '<option selected="selected" value="'.$vp['value'].'">'.$vp['name'].'</option>';
														}
														else
														{
														echo '<option value="'.$vp['value'].'">'.$vp['name'].'</option>';
														}
													}
												   }
                                                   ?>
                                                </select>
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Profile</span>
                                                <select class="form-control selectpicker" name="adv_video_max_bitrate" id="adv_video_max_bitrate">
                                                <option value="">-- Select --</option>
                                                  <?php
                                                   $videoProfile = $this->common_model->getVideoProfile();
                                                   if(sizeof($videoProfile)>0)
                                                   {
												   	foreach($videoProfile as $vpef)
												   	{
												   		if($template[0]['adv_video_profile'] == $vpef['value'])
												   		{
														echo '<option selected="selected" value="'.$vpef['value'].'">'.$vpef['name'].'</option>';
														}
														else
														{
														echo '<option value="'.$vpef['value'].'">'.$vpef['name'].'</option>';
														}
													}
												   }
                                                   ?>
                                                </select>
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Buffer Size (kbps)</span>
                                                <input type="number" class="form-control" id="adv_video_buffer_size" name="adv_video_buffer_size" value="<?php echo $template[0]['adv_video_buffer_size'];?>">
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">GOP</span>
                                                <input type="number" class="form-control" id="adv_video_gop" name="adv_video_gop" value="<?php echo $template[0]['adv_video_gop'];?>">
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Keyframe Interval</span>
                                                <input type="number" class="form-control" id="adv_video_keyframe_intrval" name="adv_video_keyframe_intrval" value="<?php echo $template[0]['adv_video_keyframe_intrval'];?>">
                                             </div>
                                          </div>
										  	<?php
										  }
                                          ?>

                                       </div>
                                       <div class="check-input">
                                          <div class="boxes">
                                          <?php
                                             if($template[0]['enabledeinterlance'] == 0)
                                             {
											  ?>
											  <input  type="checkbox" id="enabledeinterlance" name="enabledeinterlance">
											 <?php
											 }
											 elseif($template[0]['enabledeinterlance'] == 1)
                                             {
											 ?>
											  <input checked="true" type="checkbox" id="enabledeinterlance" name="enabledeinterlance">
											 <?php
											 }
                                             ?>

                                             <label for="enabledeinterlance" style="padding-left:25px;">Enable Deinterlace</label>
                                          </div>
                                       </div>
                                        <br/>
                                       <div class="check-input">
                                          <div class="boxes">
                                          <?php
                                             if($template[0]['enablezerolatency'] == 0)
                                             {
											  ?>
											  <input  type="checkbox" id="enablezerolatency" name="enablezerolatency">
											 <?php
											 }
											 elseif($template[0]['enablezerolatency'] == 1)
                                             {
											 ?>
											  <input checked="true" type="checkbox" id="enablezerolatency" name="enablezerolatency">
											 <?php
											 }
                                             ?>

                                             <label for="enablezerolatency" style="padding-left:25px;">Enable Zero Latency</label>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                       <div class="form-group">
                                          <div class="check-input">
                                             <div class="boxes">
                                             <?php
                                             if($template[0]['audio_check'] == 0)
                                             {
											  ?>
											    <input type="checkbox" id="audio_check" name="audio_check">
											 <?php
											 }
											 elseif($template[0]['audio_check'] == 1)
                                             {
											 ?>
											   <input checked="true" type="checkbox" id="audio_check" name="audio_check">
											 <?php
											 }
                                             ?>

                                                <label for="audio_check" style="padding-left:25px;">AUDIO</label>
                                             </div>
                                          </div>
                                          <div class="row">
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Codec</span>
                                                <select class="form-control selectpicker" name="audio_codec" id="audio_codec">
                                                   <option value="0">-- Select --</option>
                                                   <?php
                                                   if($template[0]['audio_codec'] != "" && $template[0]['audio_codec'] == "aac")
                                                   {
												   	?>
												   	 <option selected="selected" value="aac">AAC</option>
												   	  <option value="libopus">Libopus</option>
												   	<?php
												   }
												   elseif($template[0]['audio_codec'] != "" && $template[0]['audio_codec'] == "libopus")
                                                   {
												   	?>
												   	 <option  value="aac">AAC</option>
												   	  <option selected="selected" value="libopus">Libopus</option>
												   	<?php
												   }
												   else
												   {
												   	?>
												   	 <option value="aac">AAC</option>
												   	 <option value="libopus">Libopus</option>
												   	<?php
												   }
                                                   ?>

                                                </select>
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Channels</span>
                                                <select class="form-control selectpicker" name="audio_channel" id="audio_channel">

                                                   <option value="">--Select--</option>
                                                   <?php
                                             if($template[0]['audio_channel'] ==1)
                                             {
											  ?>
											  <option selected="selected" value="1">Mono</option>
                                                   <option value="2">Stereo</option>
											 <?php
											 }
											 elseif($template[0]['audio_channel'] == 2)
                                             {
											 ?>
											   <option value="1">Mono</option>
                                                   <option selected="selected" value="2">Stereo</option>
											 <?php
											 }
											 else
											 {
											 	?>
											   	   <option value="1">Mono</option>
                                                   <option value="2">Stereo</option>
											 <?php
											 }
                                             ?>

                                                </select>
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Bitrate (kbps)</span>
                                                <select class="form-control selectpicker" name="audio_bitrate" id="audio_bitrate">
                                                   <option value="">--Select--</option>
                                                   <?php
                                                   $AudioBitrate = $this->common_model->getAudioBitrate();
                                                   if(sizeof($AudioBitrate)>0)
                                                   {
												   	foreach($AudioBitrate as $abr)
												   	{
												   		if($template[0]['audio_bitrate'] == $abr['value'])
												   		{
														echo '<option selected="selected" value="'.$abr['value'].'">'.$abr['name'].'</option>';
														}
														else
														{
														echo '<option value="'.$abr['value'].'">'.$abr['name'].'</option>';
														}
													}
												   }
                                                   ?>
                                                </select>
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Sample Rate</span>
                                                <select class="form-control selectpicker" name="audio_sample_rate" id="audio_sample_rate">
                                                	<option value="">--Select--</option>
                                                   <?php
                                                   $AudioSamplerate = $this->common_model->getAudioSampleRate();
                                                   if(sizeof($AudioSamplerate)>0)
                                                   {
												   	foreach($AudioSamplerate as $asr)
												   	{
												   		if($template[0]['audio_sample_rate'] == $asr['value'])
												   		{
														echo '<option selected="selected" value="'.$asr['value'].'">'.$asr['name'].'</option>';
														}
														else
														{
														echo '<option value="'.$asr['value'].'">'.$asr['name'].'</option>';
														}
													}
												   }
                                                   ?>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <div class="check-input enableAdvanceAudio">
                                             <div class="boxes">
                                             <?php
                                             if($template[0]['enableAdvanceAudio'] ==0)
                                             {
											  ?>
											  <input type="checkbox" id="enableAdvanceAudio" name="enableAdvanceAudio">
											 <?php
											 }
											 elseif($template[0]['enableAdvanceAudio'] == 1)
                                             {
											 ?>
											     <input checked="true" type="checkbox" id="enableAdvanceAudio" name="enableAdvanceAudio">
											 <?php
											 }
                                             ?>

                                                <label for="enableAdvanceAudio" style="padding-left:25px;">ADVANCED AUDIO ENCODING</label>
                                             </div>
                                          </div>
                                            <?php
                                             if($template[0]['enableAdvanceAudio'] ==0)
                                             {
											  ?>
											  <div class="row adv_audio dnone" >
                                             <div class="col-md-9 ht">
                                                <span class="text-blue">Audio Gain</span>
                                               <input type="text" id="rangeslider" name="rangeslider" value="<?php echo $template[0]['audio_gain'];?>"/>
                                                <datalist id="audio_gain" name="audio_gain">
                                                   <option value="-20db" label="-20db">
                                                   <option value="-15db">
                                                   <option value="-10db">
                                                   <option value="-5db">
                                                   <option value="0db" label="0">
                                                   <option value="5db">
                                                   <option value="10db">
                                                   <option value="15db">
                                                   <option value="20db" label="+20db">
                                                </datalist>
                                             </div>
                                             <div class="col-md-6 ht">
                                             <br/>
                                             <span class="text-blue">Delay (ms)</span>
                                             <input type="number" id="delay" name="delay" class="form-control" value="<?php echo $template[0]['delay'];?>">
                                             </div>
                                          </div>
											 <?php
											 }
											 elseif($template[0]['enableAdvanceAudio'] == 1)
                                             {
											 ?>
											    <div class="row adv_audio">
                                             <div class="col-md-9 ht">
                                                <span class="text-blue">Audio Gain</span>
                                               <input type="text" id="rangeslider" name="rangeslider" value="<?php echo $template[0]['audio_gain'];?>"/>
                                                <datalist id="audio_gain" name="audio_gain">
                                                   <option value="-20db" label="-20db">
                                                   <option value="-15db">
                                                   <option value="-10db">
                                                   <option value="-5db">
                                                   <option value="0db" label="0">
                                                   <option value="5db">
                                                   <option value="10db">
                                                   <option value="15db">
                                                   <option value="20db" label="+20db">
                                                </datalist>
                                             </div>
                                             <div class="col-md-6 ht">
                                             <br/>
                                             <span class="text-blue">Delay (ms)</span>
                                             <input type="number" id="delay" name="delay" class="form-control" value="<?php echo $template[0]['delay'];?>">
                                             </div>
                                          </div>
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
                     </div>
					
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
