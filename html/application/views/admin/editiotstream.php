<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<style>
	canvas {
  border-top: 1px solid black;
  border-bottom: 1px solid black;
  margin-bottom: -3px;
  box-shadow: 0 -2px 4px rgba(0,0,0,0.7),
              0 3px 4px rgba(0,0,0,0.7);
}
.label-gray
{
	color:#FFFFFF !important;
}
</style>
<?php $outputURL ="";?>
<main class="main">
  	   <!-- Breadcrumb-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo site_url();?>">Home</a>
        </li>
        <li class="breadcrumb-item active"><a href="<?php echo site_url();?>iotstream">Streams</a></li>
        <li class="breadcrumb-item active"><?php echo $streams[0]['channel_name'];?></li>
      </ol>
      <div class="container-fluid">
      	<div class="animated fadeIn">
           <div class="card">
						 <form id="wowza-form" class="action-table" method="post" action="<?php echo site_url();?>extras/updateIOTStream/<?php echo $this->uri->segment(2);?>" enctype="multipart/form-data">
						 <div class="card-header">Edit IoTStream</div>
				<div class="card-body">
					 <div class="row">
                        <!-- ========= Section One Start ========= -->
                        <div class="col-lg-12 col-12-12">

      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
      <input type="hidden" name="processname" id="processname" value="<?php echo $streams[0]['process_name'];?>"/>
                            <div class="content-box config-contentonly">
                                <div class="config-container">
                                    <div class="row">
                        <div class="col-lg-6 p-t-15">
                            <div class="form-group col-lg-11">
                                <div class="row">
                                    <label>Name <span class="mndtry">*</span></label>
                                    <input type="text" class="form-control" name="stream_name" id="stream_name" value="<?php echo $streams[0]['channel_name'];?>" required="true"/>
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
												if($encode['id'] == $streams[0]["encoder_id"])
												{
													?>
												<option selected="selected" id="enc_<?php echo $encode['id'];?>" tabindex="<?php echo $counterInputs;?>"  label="phyinput" value="phyinput_<?php echo $encode['id'];?>"><?php echo $encode['encoder_name'];?></option>
											<?php
												}
												else
												{
													?>
												<option id="enc_<?php echo $encode['id'];?>" tabindex="<?php echo $counterInputs;?>" label="phyinput"  value="phyinput_<?php echo $encode['id'];?>"><?php echo $encode['encoder_name'];?></option>
											<?php
												}

											$counterInputs++;
											}
										}
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-lg-11">
                                <div class="row">
                                    <label> Channel Input <span class="mndtry">*</span></label>
                                    <input type="hidden" id="encid" name="encid" value="0"/>
                                    <select class="form-control selectpicker" name="channelInput" id="channelInput" required="true">
                                        <option value="">- Seletc Input -</option>
                                        <?php
                                        $cInput = explode("_",$streams[0]['channelInput']);
                                        print_r($cInput);
                                        $counterInputs=1;
                                        $encoder_count=1;
										if($streams[0]["encoder_id"] > 0)
										{
											$input = $this->common_model->getEncoderInpOutbyEncid($streams[0]["encoder_id"]);
											if(sizeof($input) > 0)
											{
												foreach($input as $inp)
												{
													//$inputname = $this->common_model->getInputName($inp);
													$inputname = $inp['inp_source'];
													$inpname =  $inp['inp_name'];
													if($cInput[0] == "phyinput")
													{
														if($cInput[1] == $inp['inp_source'] && $cInput[2] == $streams[0]["encoderid"])
														{
															?>
													<option selected="selected" id="enc_<?php echo $streams[0]["encoderid"];?>" tabindex="<?php echo $counterInputs;?>" label="phyinput" value="phyinput_<?php echo $inputname;?>_<?php echo $streams[0]["encoderid"];?>"><?php echo $inpname;?></option>
													<?php
														}
														else
														{
															?>
													<option id="enc_<?php echo $streams[0]["encoderid"];?>" tabindex="<?php echo $counterInputs;?>" label="phyinput" value="phyinput_<?php echo $inputname;?>_<?php echo $streams[0]["encoderid"];?>"><?php echo $inpname;?></option>
													<?php
														}
													}
													else
													{
														?>
													<option id="enc_<?php echo $streams[0]["encoder_id"];?>" tabindex="<?php echo $counterInputs;?>" label="phyinput" value="phyinput_<?php echo $inputname;?>_<?php echo $streams[0]["encoder_id"];?>"><?php echo $inpname;?></option>
													<?php
													}
													$counterInputs++;
												}
											}
										}

                                        $channelInputs = $this->common_model->getChannelInputs();
                                        if(sizeof($channelInputs)>0)
                                        {
											foreach($channelInputs as $input)
											{
												if($cInput[0] == "virinput")
												{
													if($input['id'] == $cInput[1])
													{
														?>
												<option selected="selected" tabindex="<?php echo $counterInputs;?>" label="virinput" value="virinput_<?php echo $input['id'];?>"><?php echo $input['item'];?></option>
												<?php
													}
													else
													{
														?>
												<option tabindex="<?php echo $counterInputs;?>" label="virinput" value="virinput_<?php echo $input['id'];?>"><?php echo $input['item'];?></option>
												<?php
													}
												}
												else
												{
													?>
												<option tabindex="<?php echo $counterInputs;?>" label="virinput" value="virinput_<?php echo $input['id'];?>"><?php echo $input['item'];?></option>
												<?php

												}

												$counterInputs++;
											}
										}
                                        ?>
                                    </select>
                                </div>
                                <?php
                                if($cInput[0] == "phyinput")
                                {
								?>
								<div class="row audioch" style="display:block;">
                                	<br/>
                                	<label>Audio Channel</label>
                                	 <select class="form-control selectpicker" name="sdi_audio_channel" id="sdi_audio_channel">
                                        <option value="0">- Select Channel -</option>
                                        <?php
											if(sizeof($audiochannels)>0)
											{
												foreach($audiochannels as $audio)
												{
													if($streams[0]['audio_channel'] == $audio['value'] )
													{

														echo '<option selected="selected" value="'.$audio['value'].'">'.$audio['name'].'</option>';
													}
													else
													{
														echo '<option value="'.$audio['value'].'">'.$audio['name'].'</option>';
													}

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
								<div class="row audioch" style="display:none;">
                                	<br/>
                                	<label>Audio Channel</label>
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
								<?php
								}
                                ?>
                                <?php
									if($cInput[0] == "virinput" && $cInput[1] == 3)
									{
									?>
									 <div class="row check-input ips" style="display:block;padding: 20px;">
	                                	<br/>
	                                	<div class="boxes">
	                                        	<?php
	                                    if($streams[0]['isIPAddresses'] == 1)
	                                    {
	                                    	?>
	                                    	    <input checked="true" type="checkbox" id="isIPAddress" name="isIPAddress" >
	                                    	<?php
	                                    }
	                                    else
	                                    {
											?>
											    <input type="checkbox" id="isIPAddress" name="isIPAddress">
											<?php
										}
										?>
	                                        <label for="isIPAddress"></label>
	                                    </div>
	                                    <label style="padding-left: 20px;line-height:15px;"> Remote IP Addresses (comma seprated)</label>
	                                     <?php
	                                    if($streams[0]['isIPAddresses'] == 1)
	                                    {
										?>
										<input type="text" class="form-control" placeholder="" name="ip_addresses_comma" id="ip_addresses_comma" value="<?php echo $streams[0]['ipAddress'];?>"/>
										<?php
										}
										else
										{
										?>
										<input type="text" class="form-control" placeholder="" name="ip_addresses_comma" id="ip_addresses_comma" disabled="disabled"/>
										<?php
										}
	                                    ?>
	                                </div>
									<div class="row ndi" style="display:block;">
	                                	<br/>
	                                    <label> NDI Source <a id="find_NDISources" style="margin-left: 5px !important;" href="javascript:void(0);"><i class="fa fa-refresh"></i></a></label>
	                                    <select class="form-control selectpicker" id="channel_ndi_source" name="channel_ndi_source">
	                                    <?php
	                                    if($streams[0]['isRemote'] == 1)
	                                    {
											?>
											<option selected="selected" value="<?php echo $streams[0]['encoder_id'].'#'.$streams[0]['channel_ndi_source']; ?>#Remote"><?php echo $streams[0]['channel_ndi_source']; ?></option>
											<?php
										}
										else
										{
											?>
											<option selected="selected" value="<?php echo $streams[0]['encoder_id'].'#'.$streams[0]['channel_ndi_source']; ?>#No"><?php echo $streams[0]['channel_ndi_source']; ?></option>
											<?php
										}
	                                    ?>
	                                    	                                   									</select>
                               		</div>
									<?php
									}
									else
									{
									?>
									 <div class="row check-input ips" style="display:none;padding: 20px;">
	                                	<br/>
	                                	<div class="boxes">
	                                	 <input type="checkbox" id="isIPAddress" >
	                                        <label for="isIPAddress"></label>
	                                    </div>
	                                    <label style="padding-left: 20px;line-height:15px;"> Remote IP Addresses (comma seprated)</label>

										<input type="text" class="form-control" placeholder="" name="ip_addresses_comma" id="ip_addresses_comma" disabled="disabled"/>


	                                </div>
									<div class="row ndi" style="display:none;">
	                                	<br/>
	                                    <label> NDI Source <a id="find_NDISources" style="margin-left: 5px !important;" href="javascript:void(0);"><i class="fa fa-refresh"></i></a></label>
	                                    <select class="form-control selectpicker" id="channel_ndi_source" name="channel_ndi_source">
	                                    	<option value="0">-- Select --</option>

	                                    </select>
                               		</div>

									<?php
									}
									if($cInput[0] == "virinput" && $cInput[1] ==4)
									{
										$outputURL = $streams[0]['input_rtmp_url'];
									?>
									 <div class="row rtmp" style="display:block;">
	                                	<br/>
	                                    <label> RTMP URL</label>
	                                    <input type="text" class="form-control" placeholder="" value="<?php echo $streams[0]['input_rtmp_url']; ?>" name="input_rtmp_url" id="input_rtmp_url"/>
	                                </div>
									<?php
									}
									else
									{
									?>
									 <div class="row rtmp" style="display:none;">
	                                	<br/>
	                                    <label> RTMP URL</label>
	                                    <input type="text" class="form-control" placeholder="rtmp://[username[:password]@]ip[:port]/<appName>/<stream_name>" name="input_rtmp_url" id="input_rtmp_url"/>
	                                </div>
									<?php
									}
									if($cInput[0] == "virinput" && $cInput[1] ==8)
									{
										$outputURL = $streams[0]['input_hls_url'];
									?>
									 <div class="row hls" style="display:block;">
	                                	<br/>
	                                    <label> M3U8 URL</label>
	                                    <input type="text" class="form-control" placeholder="" value="<?php echo $streams[0]['input_hls_url']; ?>" name="input_hls_url" id="input_hls_url"/>
	                                </div>
									<?php
									}
									else
									{
									?>
									 <div class="row hls" style="display:none;">
	                                	<br/>
	                                    <label> M3U8 URL</label>
	                                    <input type="text" class="form-control" placeholder="" name="input_hls_url" id="input_hls_url"/>
	                                </div>
									<?php
									}
									if($cInput[0] == "virinput" && $cInput[1] == 5)
									{
									?>
									 <div class="row mpeg-rtp" style="display:block;">
		                                <br/>
		                                    <label>MPEG TS - RTP</label>
		                                    <input type="text" class="form-control" value="<?php echo $streams[0]['input_mpeg_rtp']; ?>" placeholder="rtp://@<StreamIP>:<Port>/?serviceId=<ProgramPid>&videoPid=<VideoStreamPid>&audioPids=<AudioStreamsPids>" name="input_mpeg_rtp" id="input_mpeg_rtp"/>
		                                </div>
									<?php
									}
									else
									{
									?>
									 <div class="row mpeg-rtp" style="display:none;">
		                                <br/>
		                                    <label>MPEG TS - RTP</label>
		                                    <input type="text" class="form-control" placeholder="rtp://@<StreamIP>:<Port>/?serviceId=<ProgramPid>&videoPid=<VideoStreamPid>&audioPids=<AudioStreamsPids>" name="input_mpeg_rtp" id="input_mpeg_rtp"/>
		                                </div>
									<?php
									}
									if($cInput[0] == "virinput" && $cInput[1] == 6)
									{
									?>
									  <div class="row mpeg-udp" style="display:block;">
		                                 <br/>
		                                    <label>MPEG TS - UDP</label>
		                                    <input type="text" class="form-control" value="<?php echo $streams[0]['input_mpeg_udp']; ?>"  placeholder="udp://@<StreamIP>:<Port>/?serviceId=<ProgramPid>&videoPid=<VideoStreamPid>&audioPids=<AudioStreamsPids>" name="input_mpeg_udp" id="input_mpeg_udp"/>
		                                </div>
									<?php
									}
									else
									{
									?>
									  <div class="row mpeg-udp" style="display:none;">
		                                 <br/>
		                                    <label>MPEG TS - UDP</label>
		                                    <input type="text" class="form-control" placeholder="udp://@<StreamIP>:<Port>/?serviceId=<ProgramPid>&videoPid=<VideoStreamPid>&audioPids=<AudioStreamsPids>" name="input_mpeg_udp" id="input_mpeg_udp"/>
		                                </div>
									<?php
									}
									if($cInput[0] == "virinput" && $cInput[1] == 7)
									{
									?>
									    <div class="row mpeg-srt" style="display:block;">
			                                <br/>
			                                    <label>MPEG TS - SRT</label>
			                                    <input type="text" class="form-control" value="<?php echo $streams[0]['input_mpeg_srt']; ?>"  placeholder="rtmp://[username[:password]@]ip[:port]/<appName>/<stream_name>" name="input_mpeg_srt" id="input_mpeg_srt"/>
			                                </div>
									<?php
									}
									else
									{
										?>
									    <div class="row mpeg-srt" style="display:none;">
			                                <br/>
			                                    <label>MPEG TS - SRT</label>
			                                    <input type="text" class="form-control" placeholder="srt://<ip>:<port>" name="input_mpeg_srt" id="input_mpeg_srt"/>
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
				<div class="card-footer">
					<button class="btn btn-sm btn-primary" type="submit">Update</button>
						<button class="btn btn-sm btn-danger" type="reset">Reset</button>
						</div>
						</form>
			</div>
		</div>
	</div>
</main>
