<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<style type="text/css">
	.groupfile {
	    display: none !important;
	}
</style>
<main class="main">
  	   <!-- Breadcrumb-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Home</a>
        </li>
        <li class="breadcrumb-item active"><a href="<?php echo site_url();?>extra">Extras</a></li>
        <li class="breadcrumb-item active">Create IoT Stream</li>
      </ol>
      <div class="container-fluid">
      	<div class="animated fadeIn">
           <div class="card">
						 <form id="wowza-form" class="form-only form-one" method="post" action="<?php echo site_url();?>extras/saveIoTStream" enctype="multipart/form-data">
						 <div class="card-header">Add New Stream</div>
						<div class="card-body">
							<?php if($this->session->flashdata('success')){ ?>
								<div class="alert alert-success">
								<a href="#" class="close" data-dismiss="alert">&times;</a>
								<strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
								</div>
								<?php }else if($this->session->flashdata('error')){  ?>
								<div class="alert alert-danger">
								<a href="#" class="close" data-dismiss="alert">&times;</a>
								<strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
								</div>
								<?php }else if($this->session->flashdata('warning')){  ?>
								<div class="alert alert-warning">
								<a href="#" class="close" data-dismiss="alert">&times;</a>
								<strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
								</div>
								<?php }else if($this->session->flashdata('info')){  ?>
								<div class="alert alert-info">
								<a href="#" class="close" data-dismiss="alert">&times;</a>
								<strong>Info!</strong> <?php echo $this->session->flashdata('info'); ?>
								</div>
							<?php } ?>
						<div class="row">
							<div class="col-lg-12 col-12-12">
								<div class="content-box config-contentonly">
			      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								<div class="row">
									<div class="col-lg-4">
										<div class="form-group">
											<label>Name <span class="mndtry">*</span></label>
												<input type="text"  class="form-control" placeholder="First Name" name="stream_name" id="stream_name" required="true"/>
										</div>
										<div class="form-group">
											<label>Encoders <span class="mndtry">*</span></label>
												<select class="form-control selectpicker" name="channelEncoders" id="channelEncoders" required="true">
													<option value="">- Select Encoder -</option>
													<?php
												$counterInputs=1;
												if (sizeof($encoders)>0) {
													$encoder_count=1;
													foreach ($encoders as $encode) {
												?>
													<option id="enc_<?php echo $encode['id']; ?>" tabindex="<?php echo $counterInputs; ?>" label="phyinput" value="phyinput_<?php echo $encode['id']; ?>"><?php echo $encode['encoder_name']; ?></option>
													<?php
												$counterInputs++;
											}
										}
												?>
												</select>
										</div>
										<div class="form-group col-lg-12">
											<div class="row form-group">
													<label>Input
														<span class="mndtry">*</span></label>
													<input type="hidden" id="encid" name="encid" value="0"/>
													<select class="form-control selectpicker" name="channelInput" id="channelInput" required="true">
														<option value="">- Select Input -</option>
														<?php
													$channelInputs = $this->common_model->getChannelInputs();
													if (sizeof($channelInputs)>0) {
														$counterInputs1=1;
														foreach ($channelInputs as $input) {
													?>
														<option tabindex="<?php echo $counterInputs1; ?>" label="virinput" value="virinput_<?php echo $input['id']; ?>"><?php echo $input['item']; ?></option>
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
												if (sizeof($audiochannels)>0) {
													foreach ($audiochannels as $audio) {
														if ($audio['value'] != 6) {
															echo '<option value="'.$audio['value'].'">'.$audio['name'].'</option>';
														}
													}
												}
												?>
													</select>
												</div>
												<div class="row form-group check-input ips" >
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
													<label> NDI Source
														<a id="find_NDISources" style="margin-left: 5px !important;" href="javascript:void(0);">
															<i class="fa fa-refresh"></i></a></label>
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
