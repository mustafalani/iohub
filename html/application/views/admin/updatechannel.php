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
        <li class="breadcrumb-item active"><a href="<?php echo site_url();?>channels">Channels</a></li>
        <li class="breadcrumb-item active"><?php echo $channels[0]['channel_name'];?></li>
      </ol>
      <div class="container-fluid">
      	<div class="animated fadeIn">
           <div class="card">
						 <form id="wowza-form" class="action-table" method="post" action="<?php echo site_url();?>admin/updateExistingChannel/<?php echo $channels[0]['id'];?>" enctype="multipart/form-data">
						 <div class="card-header">Edit Channel</div>
				<div class="card-body">
					 <div class="row">
                        <!-- ========= Section One Start ========= -->
                        <div class="col-lg-12 col-12-12">

      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
      <input type="hidden" name="processname" id="processname" value="<?php echo $channels[0]['process_name'];?>"/>
                            <div class="content-box config-contentonly">
                                <div class="config-container">
                                    <div class="row">
                        <div class="col-lg-6 p-t-15">
                            <div class="form-group col-lg-11">
                                <div class="row">
                                    <label>Channel Name <span class="mndtry">*</span></label>
                                    <input type="text" class="form-control" name="channel_name" id="channel_name" value="<?php echo $channels[0]['channel_name'];?>" required="true"/>
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
												if($encode['id'] == $channels[0]["encoderid"])
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
                                        $cInput = explode("_",$channels[0]['channelInput']);
                                        $counterInputs=1;
                                        $encoder_count=1;
										if($channels[0]["encoderid"] > 0)
										{
											$input = $this->common_model->getEncoderInpOutbyEncid($channels[0]["encoderid"]);
											if(sizeof($input) > 0)
											{
												foreach($input as $inp)
												{
													//$inputname = $this->common_model->getInputName($inp);
													$inputname = $inp['inp_source'];
													$inpname =  $inp['inp_name'];
													if($cInput[0] == "phyinput")
													{
														if($cInput[1] == $inp['inp_source'] && $cInput[2] == $channels[0]["encoderid"])
														{
															?>
													<option selected="selected" id="enc_<?php echo $channels[0]["encoderid"];?>" tabindex="<?php echo $counterInputs;?>" label="phyinput" value="phyinput_<?php echo $inputname;?>_<?php echo $channels[0]["encoderid"];?>"><?php echo $inpname;?></option>
													<?php
														}
														else
														{
															?>
													<option id="enc_<?php echo $channels[0]["encoderid"];?>" tabindex="<?php echo $counterInputs;?>" label="phyinput" value="phyinput_<?php echo $inputname;?>_<?php echo $channels[0]["encoderid"];?>"><?php echo $inpname;?></option>
													<?php
														}
													}
													else
													{
														?>
													<option id="enc_<?php echo $channels[0]["encoderid"];?>" tabindex="<?php echo $counterInputs;?>" label="phyinput" value="phyinput_<?php echo $inputname;?>_<?php echo $channels[0]["encoderid"];?>"><?php echo $inpname;?></option>
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
													if($channels[0]['audio_channel'] == $audio['value'] )
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
	                                    if($channels[0]['isIPAddresses'] == 1)
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
	                                    if($channels[0]['isIPAddresses'] == 1)
	                                    {
										?>
										<input type="text" class="form-control" placeholder="" name="ip_addresses_comma" id="ip_addresses_comma" value="<?php echo $channels[0]['ipAddress'];?>"/>
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
	                                    if($channels[0]['isRemote'] == 1)
	                                    {
											?>
											<option selected="selected" value="<?php echo $channels[0]['encoder_id'].'#'.$channels[0]['channel_ndi_source']; ?>#Remote"><?php echo $channels[0]['channel_ndi_source']; ?></option>
											<?php
										}
										else
										{
											?>
											<option selected="selected" value="<?php echo $channels[0]['encoder_id'].'#'.$channels[0]['channel_ndi_source']; ?>#No"><?php echo $channels[0]['channel_ndi_source']; ?></option>
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
									if($cInput[0] == "virinput" && $cInput[1] == 4)
									{
										$outputURL = $channels[0]['input_rtmp_url'];
									?>
									 <div class="row rtmp" style="display:block;">
	                                	<br/>
	                                    <label> RTMP URL</label>
	                                    <input type="text" class="form-control" placeholder="" value="<?php echo $channels[0]['input_rtmp_url']; ?>" name="input_rtmp_url" id="input_rtmp_url"/>
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
									if($cInput[0] == "virinput" && $cInput[1] == 8)
									{
										$outputURL = $channels[0]['input_hls_url'];
									?>
									 <div class="row hls" style="display:block;">
	                                	<br/>
	                                    <label> M3U8 URL</label>
	                                    <input type="text" class="form-control" placeholder="" value="<?php echo $channels[0]['input_hls_url']; ?>" name="input_hls_url" id="input_hls_url"/>
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
		                                    <input type="text" class="form-control" value="<?php echo $channels[0]['input_mpeg_rtp']; ?>" placeholder="rtp://@<StreamIP>:<Port>/?serviceId=<ProgramPid>&videoPid=<VideoStreamPid>&audioPids=<AudioStreamsPids>" name="input_mpeg_rtp" id="input_mpeg_rtp"/>
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
		                                    <input type="text" class="form-control" value="<?php echo $channels[0]['input_mpeg_udp']; ?>"  placeholder="udp://@<StreamIP>:<Port>/?serviceId=<ProgramPid>&videoPid=<VideoStreamPid>&audioPids=<AudioStreamsPids>" name="input_mpeg_udp" id="input_mpeg_udp"/>
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
			                                    <input type="text" class="form-control" value="<?php echo $channels[0]['input_mpeg_srt']; ?>"  placeholder="rtmp://[username[:password]@]ip[:port]/<appName>/<stream_name>" name="input_mpeg_srt" id="input_mpeg_srt"/>
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
                            <div class="form-group col-lg-11">
                                <div class="row">
                                    <label>Channel Output <span class="mndtry">*</span></label>
                                    <select class="form-control selectpicker" name="channelOutpue" id="channelOutpue" required="true">
                                        <option value="0">- Seletc Output -</option>
                                        <?php
                                        $cOutput = explode("_",$channels[0]['channelOutpue']);
                                        $counterOutput=1;
                                        $encoder_count=1;
										if($channels[0]["encoderid"] >0)
										{
													$outputs = $this->common_model->getEncoderOutbyEncid($channels[0]["encoderid"]);
													if(sizeof($outputs)>0)
													{
														foreach($outputs as $out)
														{
															$outputname = $out['out_destination'];//$this->common_model->getOutputName($out);
															$outname = $out['out_name'];
															if($cOutput[0] == "phyoutput")
															{
																if($cOutput[1] == $outputname && $cOutput[2] == $channels[0]["encoderid"])
																{
																	?>
																	<option selected="selected" id="enc_<?php echo $channels[0]["encoderid"];?>" tabindex="<?php echo $counterOutput;?>" label="phyoutput" value="phyoutput_<?php echo $outputname;?>_<?php echo $channels[0]["encoderid"];?>"><?php echo $outname;?></option>
															<?php
																}
																else
																{
																	?>
																	<option id="enc_<?php echo $channels[0]["encoderid"];?>" tabindex="<?php echo $counterOutput;?>" label="phyoutput" value="phyoutput_<?php echo $outputname;?>_<?php echo $channels[0]["encoderid"];?>"><?php echo $encode['encoder_name']."->". $outname;?></option>
															<?php
																}
															}
															else
															{
																?>
															<option id="enc_<?php echo $channels[0]["encoderid"];?>" tabindex="<?php echo $counterOutput;?>" label="phyoutput" value="phyoutput_<?php echo $outputname;?>_<?php echo $channels[0]["encoderid"];?>"><?php echo $encode['encoder_name']."->". $outname;?></option>
															<?php
															}
														}
														$counterOutput++;
													}
													else
													{
														if($encode['encoder_enable_hdmi_out'] == 1)
														{

															if($cOutput[1] == 'PC Out' && $cOutput[2] == $channels[0]["encoderid"])
															{
																?>
																<option selected="selected" id="enc_<?php echo $channels[0]["encoderid"];?>" tabindex="<?php echo $counterOutput++;?>" label="phyoutput" value="phyoutput_PC Out_<?php echo $channels[0]["encoderid"];?>"><?php echo "PC Out";?></option>
																<?php
															}
															else
															{
																?>
																<option id="enc_<?php echo $channels[0]["encoderid"];?>" tabindex="<?php echo $counterOutput++;?>" label="phyoutput" value="phyoutput_PC Out_<?php echo $channels[0]["encoderid"];?>"><?php echo "PC Out";?></option>
																<?php
															}
														}
													}
												}
                                        $channelOutput = $this->common_model->getChannelOutput();
                                        if(sizeof($channelOutput)>0)
                                        {
											foreach($channelOutput as $output)
											{
												if($cOutput[0] == "viroutput")
												{
													if($cOutput[1] == $output['id'])
													{
														?>
												<option selected="selected" tabindex="<?php echo $counterOutput;?>" label="viroutput" value="viroutput_<?php echo $output['id'];?>"><?php echo $output['item'];?></option>
												<?php
													}
													else
													{
														?>
												<option tabindex="<?php echo $counterOutput;?>" label="viroutput" value="viroutput_<?php echo $output['id'];?>"><?php echo $output['item'];?></option>
												<?php
													}
												}
												else
												{
													?>
												<option tabindex="<?php echo $counterOutput;?>" label="viroutput" value="viroutput_<?php echo $output['id'];?>"><?php echo $output['item'];?></option>
												<?php
												}

												$counterOutput++;
											}
										}
                                        ?>
                                    </select>
                                </div>
		                       	<?php
		                       	if ($cOutput[0] == "phyoutput") {
		                       	?>
		                       	<div class="row sdioutaudioch" style="display:block;">
		                                	<br/>
		                                	<label>SDI Out Audio Channels</label>
		                                	 <select class="form-control selectpicker" name="sdi_out_audio_channels" id="sdi_out_audio_channels">
		                                        <option value="0">- Select Channel -</option>
		                        <?php
		                        if (sizeof($audiochannels) > 0) {
										foreach ($audiochannels as $audio) {
														if ($channels[0]['sdi_out_audio_channels'] == $audio['value']) {

																		echo '<option selected="selected" value="' . $audio['value'] . '">' . $audio['name'] . '</option>';
														}
														else {
																		echo '<option value="' . $audio['value'] . '">' . $audio['name'] . '</option>';
														}

										}
									}
								?>
								</select>
									</div>
									<?php
								}
								else {
									?>
									<div class="row sdioutaudioch" style="display:none;">
		                                	<br/>
		                                	<label>SDI Out Audio Channels</label>
		                                	 <select class="form-control selectpicker" name="sdi_out_audio_channels" id="sdi_out_audio_channels">
		                                        <option value="0">- Select Channel -</option>
		                                        <?php
		                                        if (sizeof($audiochannels) > 0) {
		                                        	foreach ($audiochannels as $audio) {
														echo '<option value="' . $audio['value'] . '">' . $audio['name'] . '</option>';
													}
												}
												?>
		                                    </select>
		                                </div>
										<?php
									}
									?>
                                <?php
                                if($cOutput[0] == "viroutput" && $cOutput[1] == 3)
                                {
									?>
									<div class="row ndi-name" style="display:block;">
	                                <br/>
	                                    <label>NDI Name</label>
	                                    <input type="text" class="form-control" name="ndi_name" id="ndi_name" value="<?php echo $channels[0]['ndi_name'];?>">
	                                </div>
									<?php
								}
								else
								{
									?>
									<div class="row ndi-name" style="display:none;">
	                                <br/>
	                                    <label>NDI Name</label>
	                                    <input type="text" class="form-control" name="ndi_name" id="ndi_name">
	                                </div>
									<?php
								}
								if($cOutput[0] == "viroutput" && $cOutput[1] == "4")
                                {

									?>
									 <div class="row ch-applications" style="display:block;">
                                 	<br/>
                                    <label>Application</label>
                                    <select class="form-control selectpicker" id="channel_apps" name="channel_apps">
                                        <option value="">- Select Application -</option>
                                        <?php

											if(sizeof($apps)>0)
											{
												foreach($apps as $app)
												{
													if($channels[0]['channel_apps'] == $app['id'])
													{
														echo '<option selected="selected" id="'.$app['wowza_path'].'" value="'.$app['id'].'">'.$app['application_name'].'</option>';
													}
													else
													{
														echo '<option id="'.$app['wowza_path'].'" value="'.$app['id'].'">'.$app['application_name'].'</option>';
													}

												}
												if($channels[0]['channel_apps'] == -2)
												{
													echo '<option selected="selected" id="-2" value="-2">Custom</option>';
												}
												else
												{
													echo '<option id="-2" value="-2">Custom</option>';
												}

											}
										?>
                                    </select>
                                   </div>
                                    <?php $outputURL = $channels[0]['output_rtmp_url']."/".$channels[0]['output_rtmp_key'];?>
                                    <div class="row out-rtmp-url" style="display:block;">
                                    <br>
                                    	<label>RTMP Stream URL</label>
                                    	<input type="text" class="form-control" name="output_rtmp_url" id="output_rtmp_url" value="<?php echo $channels[0]['output_rtmp_url'];?>"/>
                                    </div>
                                    <div class="row out-rtmp-key" style="display:block;">
                                    <br/>
                                    	<label>RTMP Stream Key</label>
                                    	<input type="text" class="form-control" name="output_rtmp_key" id="output_rtmp_key" value="<?php echo $channels[0]['output_rtmp_key'];?>"/>
                                    </div>
									<?php
								}
								else
								{
									?>
									 <div class="row ch-applications" style="display:none;">
                                 <br/>
                                    <label>Application</label>
                                    <select class="form-control selectpicker" id="channel_apps" name="channel_apps">
                                        <option value="0">- Select Application -</option>
                                        <?php
											$apps = $this->common_model->getAllApplications();
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

                                    <div class="row out-rtmp-url" style="display:none;">
                                    <br>
                                    	<label>RTMP Stream URL</label>
                                    	<input type="text" class="form-control" name="output_rtmp_url" id="output_rtmp_url"/>
                                    </div>
                                    <div class="row out-rtmp-key" style="display:none;">
                                    <br/>
                                    	<label>RTMP Stream Key</label>
                                    	<input type="text" class="form-control" name="output_rtmp_key" id="output_rtmp_key" />
                                    </div>
									<?php
								}

                                ?>
                                <?php
                                if($cOutput[0] == "viroutput" && $cOutput[1] == "5")
                                {
                                ?>
                                 <div class="row out-mpeg-rpt" style="display:block;">
                                <br/>
                                    <label>MPEG TS - RTP</label>
                                    <input type="text" class="form-control" placeholder="rtp://@<StreamIP>:<Port>/?serviceId=<ProgramPid>&videoPid=<VideoStreamPid>&audioPids=<AudioStreamsPids>" name="output_mpeg_rtp" id="output_mpeg_rtp"/>
                                </div>
                                <?php
                                }
                                else
                                {
									 ?>
                                 <div class="row out-mpeg-rpt" style="display:none;">
                                <br/>
                                    <label>MPEG TS - RTP</label>
                                    <input type="text" class="form-control" placeholder="rtp://@<StreamIP>:<Port>/?serviceId=<ProgramPid>&videoPid=<VideoStreamPid>&audioPids=<AudioStreamsPids>" name="output_mpeg_rtp" id="output_mpeg_rtp"/>
                                </div>
                                <?php
								}
								if($cOutput[0] == "viroutput" && $cOutput[1] == "6")
                                {
                                	?>
                                	<div class="row out-mpeg-udp" style="display:block;">
                                <br/>
                                    <label>MPEG TS - UDP</label>
                                    <input type="text" class="form-control" placeholder="udp://@<StreamIP>:<Port>/?serviceId=<ProgramPid>&videoPid=<VideoStreamPid>&audioPids=<AudioStreamsPids>" name="output_mpeg_udp" id="output_mpeg_udp"/>
                                </div>
                                	<?php
                                }
                                else
                                {
									?>
                                	<div class="row out-mpeg-udp" style="display:none;">
                                <br/>
                                    <label>MPEG TS - UDP</label>
                                    <input type="text" class="form-control" placeholder="udp://@<StreamIP>:<Port>/?serviceId=<ProgramPid>&videoPid=<VideoStreamPid>&audioPids=<AudioStreamsPids>" name="output_mpeg_udp" id="output_mpeg_udp"/>
                                </div>
                                	<?php
								}
								if($cOutput[0] == "viroutput" && $cOutput[1] == "7")
                                {
                                	?>
                                	 <div class="row out-mpeg-srt" style="display:block;">
                                <br/>
                                    <label>MPEG TS - SRT</label>
                                    <input type="text" class="form-control" placeholder="srt://<ip>:<port>" name="output_mpeg_srt" id="output_mpeg_srt" value="<?php echo $channels[0]['output_mpeg_srt'];?>"/>
                                </div>
                                	<?php
                                }
                                else
                                {
									?>
                                	 <div class="row out-mpeg-srt" style="display:none;">
                                <br/>
                                    <label>MPEG TS - SRT</label>
                                    <input type="text" class="form-control" placeholder="srt://<ip>:<port>" name="output_mpeg_srt" id="output_mpeg_srt"/>
                                </div>
                                	<?php
								}

                                ?>
                               <?php
                               if($cOutput[0] == "viroutput" && $cOutput[1] == "4")
                                {
                               ?>
                                 <div class="boxes row ch-authentication" style="display:block;">
                                    <br/>
                                    	<?php
                                    	if($channels[0]['auth_uname'] != "")
                                    	{
										?>
										<input type="checkbox" checked="true" id="channel-auth" name="channel-auth"/>
										<?php
										}
										else
										{
										?>
										<input type="checkbox" id="channel-auth" name="channel-auth"/>
										<?php
										}
                                    	?>

                                        <span for="box-2">Use Authentication</span>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    	if($channels[0]['auth_uname'] != "" && $channels[0]['auth_pass'] != "")
                                    	{
                                    	?>
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
                                    	<?php
                                    	}
                                    	else
                                    	{
												?>
                                    	<div class="row ch-uname" style="display:none;">
	                                    <br>
	                                    	<label>Username</label>
	                                    	<input type="text" class="form-control" name="auth_uname" id="auth_uname"/>
	                                    </div>
	                                    <div class="row ch-pass" style="display:none;">
                                    	<br/>
                                    	<label>Password</label>
                                    	<input type="text" class="form-control" name="auth_pass" id="auth_pass"/>
                                    </div>
                                    	<?php
										}
                                    ?>
                            </div>
                            <?php
                            if($cOutput[0] == "viroutput" && $cOutput[1] == "4" || $cOutput[1] == "7")
                            {
								?>
								 <div class="form-group col-lg-11 ch-profile" style="display:block;">
                                <div class="row">
                                    <label> Encoding Preset</label>
                                    <select class="form-control selectpicker" name="encoding_profile" id="encoding_profile">
                                        <option value="0">- Seletc Preset -</option>
                                        <?php

											if(sizeof($profiles)>0)
											{
												foreach($profiles as $profile)
												{

													if($channels[0]['encoding_profile'] == $profile['id'])
													{
														echo '<option selected="selected" value="'.$profile['id'].'">'.$profile['template_name'].'</option>';
													}
													else
													{
													echo '<option value="'.$profile['id'].'">'.$profile['template_name'].'</option>';
													}

												}
											}
										?>
                                    </select>
                                </div>
                            </div>
								<?php
							}
							else
							{
								?>
								 <div class="form-group col-lg-11 ch-profile" style="display:none;">
                                <div class="row">
                                    <label> Encoding Preset</label>
                                    <select class="form-control selectpicker" name="encoding_profile" id="encoding_profile">
                                        <option value="0">- Seletc Preset -</option>
                                        <?php
											$profiles = $this->common_model->getEncoderProfiles();
											if(sizeof($profiles)>0)
											{
												foreach($profiles as $profile)
												{
													if($channels[0]['encoding_profile'] == $profile['id'])
													{
														echo '<option selected="selected" value="'.$profile['id'].'">'.$profile['template_name'].'</option>';
													}
													else
													{
														echo '<option value="'.$profile['id'].'">'.$profile['template_name'].'</option>';
													}
												}
											}
										?>
                                    </select>
                                </div>
                            </div>
								<?php
							}
                            ?>
                            <div class="form-group col-lg-11" style="margin-bottom:0;padding-left:0;">
	                            <div class="check-input">
	                              <div class="boxes">
	                              	<?php
	                              	if($channels[0]['is_record_channel'] == 1)
	                              	{
										?>
										<input checked="true" type="checkbox" id="record_channel" name="record_channel">
										<?php
									}
									else
									{
										?>
										<input type="checkbox" id="record_channel" name="record_channel">
										<?php
									}
	                              	?>

	                                 <label for="record_channel" style="padding-left: 20px;line-height:15px;">Record Channel</label>
	                              </div>
	                           </div>
                            </div>
                            <div class="form-group col-lg-11">
	                             <div class="row">
                                    <br/>
                                    	<label>File Name</label>
                                    	<input type="text" class="form-control" name="record_file" id="record_file" value="<?php echo $channels[0]['record_file']; ?>"/>
                                    </div>
                            </div>
                           	<div class="form-group col-lg-11">
                                <div class="row">
                                    <label> Recording Presets</label>
                                    <select class="form-control selectpicker" name="recording_encoding_profile" id="recording_encoding_profile">
                                        <option value="0">- Select Preset -</option>
                                        <?php
                                        if($channels[0]['recording_presets'] == -1)
                                        {
											?>
											 <option selected="true" value="-1">Use The Channel Encoding Preset</option>
											<?php
										}
										else
										{
											?>
											 <option value="-1">Use The Channel Encoding Preset</option>
											<?php
										}
                                        ?>
                                        <?php
                                        if($channels[0]['recording_presets'] == -2)
                                        {
											?>
											 <option selected="true" value="-2">Use The Default Encoder Recording Preset</option>
											<?php
										}
										else
										{
											?>
											  <option value="-2">Use The Default Encoder Recording Preset</option>
											<?php
										}
                                        ?>
																				<?php
                                        if($channels[0]['recording_presets'] == -3)
                                        {
											?>
											 <option selected="true" value="-3">Use Script</option>
											<?php
										}
										else
										{
											?>
											  <option value="-3">Use Script</option>
											<?php
										}
                                        ?>
                                        <?php
											if(sizeof($profiles)>0)
											{
												foreach($profiles as $profile)
												{
													if($channels[0]['recording_presets'] == $profile['id'])
													{
														echo '<option selected="selected" value="'.$profile['id'].'">'.$profile['template_name'].'</option>';
													}
													else
													{
														echo '<option value="'.$profile['id'].'">'.$profile['template_name'].'</option>';
													}

												}
											}
										?>
                                    </select>
                                </div>
                            </div>
														<div class="form-group col-lg-11">
	                             <div class="row">
                                    	<input type="text" placeholder="Recording Script" class="form-control" name="recording_preset_script" id="recording_script" value="<?php echo $channels[0]['recording_preset_script']; ?>"/>
                                    </div>
                            </div>
							<div class="form-group col-lg-11">
								<div class="row">
									<label> Channel Groups</label>
									<?php
										$array = array();
										if (sizeof($channelMapping)>0) {
											foreach ($channelMapping as $map) {
												if (!array_key_exists($map['groupid'],$array)) {
													$array[$map['groupid']] = array();
												}
												array_push($array[$map['groupid']],$map['channelId']);
											}
										}

									?>
									<select class="form-control selectpicker" name="channelGroup" id="channelGroup">
										<option value="0">- Select Group -</option>
										<?php


							if (sizeof($channelgroups)>0) {
										foreach ($channelgroups as $grp) {
											if (in_array($channels[0]['id'],$array[$grp['id']])) {
												echo '<option selected="selected" value="'.$grp['id'].'">'.$grp['groupname'].'</option>';
											}
 											else {
												echo '<option value="'.$grp['id'].'">'.$grp['groupname'].'</option>';
											}


								}
							}
							?>
									</select>
								</div>
							</div>
                        </div>
						<div class="col-lg-6 p-t-15">
							<br/>
							<br/>
							   <div class="form-group col-lg-6" style="display:none;">
                                <div class="preview row" style="width:100%;">
                                    <div class="video-status" style="padding-bottom: 5px;">
                                    <span id="status" class="label label-gray" style="color:#fff !important;">Preview</span>
                                    <span id="status" class="text-one">---</span>
                                    <span id="status" class="text-one">---</span>
                                   <span id="status" class="text-one">---</span>
                                    <span id="status" class="text-one">---</span>
                                    </div>
                                    <div id="player-container">
										<div id="player_offline" title="<?php echo $outputURL;?>"></div>
										<div id="player-tip"></div>
									</div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <div class="live row" style="width:100%;">
                                    <div class="video-status" style="padding-bottom: 5px;">
                                    <?php
	                            	$segment = $this->uri->segment(3);
	                            	$id = $this->uri->segment(2);
	                            	if($segment == "offline")
	                            	{
	                            	?>
	                            	<span id="statusvideo" class="label label-gray">OFFLINE</span>
	                            	<?php
	                            	}
	                            	elseif($segment == "live")
	                            	{
	                            	?>
	                            	<span id="statusvideo" class="label label-live">ONLINE</span>
	                            	<?php
	                            	}
	                            		?>

                                    <span id="status" class="text-one">---</span>
                                    <span id="status" class="text-one">---</span>
                                    <span id="status" class="text-one">---</span>
                                    <span id="status" class="text-one">---</span>
                                    </div>
                                    <div id="player-container">
										<div id="player_live" title="<?php echo $outputURL;?>"></div>
										<div id="player-tip"></div>
									</div>
                                </div>
                            </div>
                            <div class="form-group col-lg-12">
                                <div class="row">
                                    <div class="video-buttons  col-md-12">
                                    <?php
	                            	$segment = $this->uri->segment(3);
	                            	$id = $this->uri->segment(2);
	                            	if($segment == "offline")
	                            	{
	                            		?>
	                            		<button id="btnn_<?php echo $id;?>" type="button"  class="btn btn-default splayer strt" style="width: 25%;margin-right: 10px;"><i class="fa fa-play"></i> START</button>
	                            		  <button id="btnn_<?php echo $id;?>" type="button" class="btn btn-default splayer stpt" style="width: 25%;margin-left: 10px;" disabled="disabled"><i class="fa fa-stop"></i> STOP</button>
	                            		<?php
	                            	}
	                            	elseif($segment == "live")
	                            	{
										?>
	                            		<button id="btnn_<?php echo $id;?>" type="button" onclick="startPlayer();" class="btn btn-default splayer strt" style="width: 25%;margin-right: 10px;" disabled="disabled"><i class="fa fa-play"></i> START</button>
	                            		  <button  id="btnn_<?php echo $id;?>" type="button" class="btn btn-default splayer stpt" style="width: 25%;margin-left: 10px;" ><i class="fa fa-stop"></i> STOP</button>
	                            		<?php
									}
	                            	?>


                                    <br>
                                    <p style="display:none;" class="text-yellow">Tip: Preview is not available if the channels is Live!</p>
                                </div>
                                    </div>
                            </div>
                            	<?php
                            	$segment = $this->uri->segment(3);
                            	if($segment == "offline")
                            	{
									?>
									<script type="text/javascript">
									sourceURL = '<?php echo $channels[0]["output_rtmp_url"];?>/<?php echo $channels[0]["output_rtmp_key"];?>';
									playerId = "offlineplayer";
								</script>
									<?php
								}
								if($segment == "live")
                            	{
									?>
									<script type="text/javascript">
									sourceURL = '<?php echo $channels[0]["output_rtmp_url"];?>/<?php echo $channels[0]["output_rtmp_key"];?>';
									playerId = "liveplayer";
								</script>
									<?php
								}
                            	?>
								<script type="text/javascript">

									sourceURL = '<?php echo $channels[0]["output_rtmp_url"];?>/<?php echo $channels[0]["output_rtmp_key"];?>';
								</script>

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
