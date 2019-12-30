<?php $this->load->view('guser/navigation.php');?>
<?php $this->load->view('guser/leftsidebar.php');?>
<!-- ========= Content Wrapper Start ========= -->
        <section class="content-wrapper">
            <!-- ========= Main Content Start ========= -->
            <div class="content">
                <div class="content-container">
                    <div class="row">
                        <!-- ========= Section One Start ========= -->
                        <div class="col-lg-12 col-12-12">
                        	<form id="wowza-form" class="action-table" method="post" action="<?php echo site_url();?>admin/saveChannel" enctype="multipart/form-data">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">	
                            <div class="content-box config-contentonly">
                                <div class="config-container">
                                    <div class="tab-btn-container">
                                        <input type="submit" class="btn-def save" value="Save"/>
                                    </div>
                                    <br>
                                    <div class="row">
                        <div class="col-lg-6 p-t-15">
                            <div class="form-group col-lg-9">
                                <div class="row">
                                    <label>Channel Name</label>
                                    <input type="text" class="form-control" name="channel_name" id="channel_name"/>
                                </div>
                            </div>
                            <div class="form-group col-lg-9">
                                <div class="row">
                                    <label> Channel Input</label>
                                    <select class="form-control selectpicker" name="channelInput" id="channelInput">
                                        <option>- Seletc Input -</option>
                                        <?php 
                                        $counterInputs=1;
                                        if(sizeof($encoders)>0)
			                        	{
			                        		$encoder_count=1;
											foreach($encoders as $encode)
											{
												$input = $encode['encoder_inputs'];
												if($input != "")
												{
													$inputArray = explode(',',$input);
													foreach($inputArray as $inp)
													{
														$inputname = $this->common_model->getInputName($inp);
														?>
														<option tabindex="<?php echo $counterInputs;?>" label="phyinput" value="phyinput_<?php echo $inp;?>"><?php echo $encode['encoder_name']."->". $inputname[0]['item'];?></option>
														<?php	
														$counterInputs++;
													}
												}
												
											}
										}		
                                        $channelInputs = $this->common_model->getChannelInputs();
                                        if(sizeof($channelInputs)>0)
                                        {
											foreach($channelInputs as $input)
											{
												?>
												<option tabindex="<?php echo $counterInputs;?>" label="virinput" value="virinput_<?php echo $input['id'];?>"><?php echo $input['item'];?></option>
												<?php
												$counterInputs++;
											}
										}
                                        ?>
                                    </select>
                                </div>
                                <div class="row ndi">
                                <br/>
                                    <label><i class="fa fa-refresh"></i> NDI Source</label>
                                    <select class="form-control selectpicker" id="channel_ndi_source" name="channel_ndi_source">
                                    	<optin value="">-- Select --</optin>
                                        <option>OTT-ENC-03 (NDI_2)</option>
                                        <option>OTT-ENC-02 (NDI_1)</option>
                                    </select>
                                </div>
                                
                                <div class="row rtmp">
                                <br/>
                                    <label> RTMP URL</label>
                                    <input type="text" class="form-control" placeholder="rtmp://[username[:password]@]ip[:port]/<appName>/<stream_name>" name="input_rtmp_url" id="input_rtmp_url"/>
                                </div>
                                
                                <div class="row mpeg-rtp">
                                <br/>
                                    <label>MPEG TS - RTP</label>
                                    <input type="text" class="form-control" placeholder="rtmp://[username[:password]@]ip[:port]/<appName>/<stream_name>" name="input_mpeg_rtp" id="input_mpeg_rtp"/>
                                </div>
                               
                                <div class="row mpeg-udp">
                                 <br/>
                                    <label>MPEG TS - UDP</label>
                                    <input type="text" class="form-control" placeholder="rtmp://[username[:password]@]ip[:port]/<appName>/<stream_name>" name="input_mpeg_udp" id="input_mpeg_udp"/>
                                </div>
                                
                                <div class="row mpeg-srt">
                                <br/>
                                    <label>MPEG TS - SRT</label>
                                    <input type="text" class="form-control" placeholder="rtmp://[username[:password]@]ip[:port]/<appName>/<stream_name>" name="input_mpeg_srt" id="input_mpeg_srt"/>
                                </div>                                                                                                                                
                            </div>
                            <div class="form-group col-lg-9">
                                <div class="row">
                                    <label>Channel Output</label>
                                    <select class="form-control selectpicker" name="channelOutpue" id="channelOutpue">
                                        <option value="">- Seletc Output -</option>
                                        
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
														<option tabindex="<?php echo $counterOutput;?>" label="phyoutput" value="phyoutput_<?php echo $out;?>"><?php echo $encode['encoder_name']."->". $outputname[0]['item'];?></option>
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
												?>
												<option tabindex="<?php echo $counterOutput;?>" label="viroutput" value="viroutput_<?php echo $output['id'];?>"><?php echo $output['item'];?></option>
												<?php
												$counterOutput++;	
											}
										}
                                        ?>
                                    </select>
                                </div>
                                
                                <div class="row ndi-name">
                                <br/>
                                    <label>NDI Name</label>
                                    <input type="text" class="form-control" name="ndi_name" id="ndi_name">
                                </div>
                               
                                <div class="row ch-applications">
                                 <br/>
                                    <label>Application</label>
                                    <select class="form-control selectpicker" id="channel_apps" name="channel_apps">
                                        <option value="">- Select Application -</option>
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
                                   
                                   
                                <div class="row out-mpeg-rpt">
                                <br/>
                                    <label>MPEG TS - RTP</label>
                                    <input type="text" class="form-control" placeholder="rtmp://[username[:password]@]ip[:port]/<appName>/<stream_name>" name="output_mpeg_rtp" id="output_mpeg_rtp"/>
                                </div>
                                <div class="row out-mpeg-udp">
                                <br/>
                                    <label>MPEG TS - UDP</label>
                                    <input type="text" class="form-control" placeholder="rtmp://[username[:password]@]ip[:port]/<appName>/<stream_name>" name="output_mpeg_udp" id="output_mpeg_udp"/>
                                </div>
                                <div class="row out-mpeg-srt">
                                <br/>
                                    <label>MPEG TS - SRT</label>
                                    <input type="text" class="form-control" placeholder="rtmp://[username[:password]@]ip[:port]/<appName>/<stream_name>" name="output_mpeg_srt" id="output_mpeg_srt"/>
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
                            <div class="form-group col-lg-9 ch-profile">
                                <div class="row">
                                    <label> Encoding Profile</label>
                                    <select class="form-control selectpicker" name="encoding_profile" id="encoding_profile">
                                        <option>- Seletc Profile -</option>
                                        <?php 
											$profiles = $this->common_model->getEncoderProfiles();    
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
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ========= Main Content End ========= -->
        </section>
        <!-- ========= Content Wrapper End ========= -->