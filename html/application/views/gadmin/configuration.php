
<?php $this->load->view('gadmin/navigation.php');?>
<?php $this->load->view('gadmin/leftsidebar.php');?>


<!-- ========= Content Wrapper Start ========= -->
<section class="content-wrapper">
	<!-- ========= Main Content Start ========= -->
	<div class="content">
		
		<div class="content-container">
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
				<!-- ========= Section One Start ========= -->
				<div class="col-lg-12 col-12-12">
					<div class="content-box config-contentonly">
						<div class="config-container">
							<!-- === Nav tabs === -->
							<div class="tab-btn-container">
								<ul class="nav nav-tabs" role="tablist" id="configuration">									
									<li  role="presentation"><a id="wowza" href="#wowzaengine" aria-controls="wowza" role="tab" data-toggle="tab">Wowza</a></li>
									<li role="presentation"><a id="encoders" href="#Encoders" aria-controls="ffmpeg" role="tab" data-toggle="tab">Encoders</a></li>
										<li role="presentation"><a id="encodingtemplate" href="#Encoding-Templates" aria-controls="Encoding Templates" role="tab" data-toggle="tab">Encoding Templates</a></li>	
								</ul>
								
							</div>
							
							<!-- === Tab panes === -->
							<div class="tab-content">								
								<div role="tabpanel" class="tab-pane active" id="wowzaengine">
									<div class="action-table">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="box-header">
                                                   
                                                    <a class="add-btn" id="add_wowza" href="<?php echo site_url();?>groupadmin/createwowza">
                                                        <span><i class="fa fa-plus"></i> Wowza Engine</span>
													</a>
												</div>
                                                
                                                <div class="box">
                                                    <div class="box-body table-responsive no-padding">
                                                        <table id="wowzaengins" class="table table-hover check-input wowzaTable">
                                                            <tr>
                                                                
																<th>ID</th>                                                              
                                                                <th>Name</th>
                                                                <th>IP Address</th>
                                                                <th>Uptime</th>
                                                                <th >Applications Running</th>
                                                                <th>Status</th>
                                                                <th> &nbsp; </th>
                                                                <th> &nbsp; </th>
                                                                <th> &nbsp; </th>
                                                                <th> &nbsp; </th>
															</tr>
                                                            <?php
																if(sizeof($configdetails)>0)
																{
																	$counter =1;
																	foreach($configdetails as $configdetail)
																	{
																		$Id = $configdetail['id'];
																		$applicationsCount = $this->common_model->getWowzaApps($Id);
																	?>
																	<tr class="wowza_row">																																																		<td><?php echo $counter;?></td>
																		<td><a class="wowid" id="<?php echo $configdetail['id']?>" href="<?php echo site_url();?>/groupadmin/updatewowzaengin/<?php echo $configdetail['id']?>">
																			<?php
																				if($configdetail['wowza_image'] == "")
																				{
																				?>
																				<img src="<?php echo site_url();?>assets/site/main/images/logo1.png" class="">
																				<?php	
																				}
																				else
																				{
																				?>
																				<img src="<?php echo site_url();?>assets/site/main/wowza_logo/<?php echo $configdetail['wowza_image'];?>" class="">
																				<?php	
																				}
																			?>
																			
																		<?php echo $configdetail['wse_instance_name'];?></a></td>
																		<td><?php echo $configdetail['ip_address'];?></td>
																		
																		
																		<td><span class="uptime"></span></td>
																		<td>
																			<?php
																				
																			?>
																		<strong>
																		<?php 
																		if(sizeof($applicationsCount)>0)
																		{
																			echo sizeof($applicationsCount);
																		}
																		else
																		{
																			echo "0";
																		}
																		?></strong> <a href="<?php echo site_url();?>groupadmin/applications/<?php echo $Id;?>"> See Application</a></td>
																		<td><?php 
																			if($configdetail['status'] == 1)
																			{
																				echo '<span id="status" class="label label-success">online</span>';
																			}
																			elseif($configdetail['status'] == 2)
																			{
																				echo '<span id="status" class="label label-danger">offline</span>';
																			}
																			else
																			{
																				echo '<span id="status" class="label label-danger">offline</span>';
																			}
																		?></td>
																		<td><a data-container="body" data-toggle="tooltip" title="CPU: XX Heap: XX Memory: XX Disk: XX" data-placement="bottom" data-html="true" class="wowzadisable" href="javascript:void(0);"><i class="fa fa-heartbeat" aria-hidden="true"></i></a></td>
																		
																		<td><a data-toggle="tooltip" title="Refresh" class="wowzarefresh" id="ref_<?php echo $configdetail['id']?>" href="javascript:void(0);"><i class="fa fa-refresh" aria-hidden="true"></i></a></td>
																		
																		<td><a data-toggle="tooltip" title="Reboot" class="wowzareboot" id="reb_<?php echo $configdetail['id']?>" href="javascript:void(0);"><i class="fa fa-repeat" aria-hidden="true"></i></a></td>
						
																		<td><a data-toggle="tooltip" title="Delete" class="wowzadelete" id="del_<?php echo $configdetail['id']?>" href="javascript:void(0);"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
																	</tr>
																	<?php	
																		$counter++;
																	}
																}
																else
																{
																?>
																<tr>
																	<td colspan="11">Wowza Engine Not Added Yet!</td>
																</tr>
																<?php
																}
															?>
                                                            
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div role="tabpanel" class="tab-pane" id="Encoders">
									<div class="action-table">
						    			<div class="row">
        <div class="col-xs-12">
            <div class="box-header">
         
               
                <a href="<?php echo site_url();?>groupadmin/addEncoderes" class="add-btn">
                    <span><i class="fa fa-plus"></i> Encoder</span>
                </a>				
            </div>
            <div class="box">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover check-input">
                        <tr>
                            
                            <th>ID</th>
                            <th>Name</th>
                            <th>IP Address</th>
                            <th>Hardware</th>
                            <th>Uptime</th>
                            <th>Status</th>
                            <th> &nbsp; </th>
                            <th> &nbsp; </th>
                            <th> &nbsp; </th>
                            <th> &nbsp; </th>
                        </tr>
                       
                        	<?php
                        	if(sizeof($encoders)>0)
                        	{
                        		$encoder_count=1;
								foreach($encoders as $encode)
								{
									?>
									<tr>										
			                            <td><?php echo $encoder_count;?></td>
			                            <td><a href="<?php echo site_url();?>groupadmin/editEncoder/<?php echo $encode['id'];?>"><?php echo $encode['encoder_name'];?></a> </td>
			                            <td><?php echo $encode['encoder_ip'];?></td>
			                            <td><span class="text-blue">
			                            <?php 
			                            $hardware = $this->common_model->getAllHardware($encode['encoder_hardware']);
			                            
			                            echo $hardware[0]['item'];?></span></td>
			                            <td>  <?php
$start = time();
											$srvip= $encode['encoder_ip'];
											$srvapiport= $encode['encoder_port'];
											$url = "http://$srvip:$srvapiport/v2/machine/monitoring/current";
											$ch = curl_init($url);
											curl_setopt($ch, CURLOPT_NOBODY, true);
											curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
											curl_setopt($ch, CURLOPT_HTTPGET, true);
											    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
											    curl_setopt($ch,CURLOPT_TIMEOUT,10);
											    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);

											    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
											    'Content-Type: application/json',
											    'Accept: application/json'
											));
											$result = curl_exec($ch);
											$end = time() - $start;

											$retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
											curl_close($ch);
											if (200==$retcode) {
											   
											    $json = json_decode($result, true);
											    $tseconds = $json['serverUptime'];
											    if(!function_exists('secondsToWords')){
													function secondsToWords($seconds){
												    $ret = "";
												    /*** get the days ***/
												    $days = intval(intval($seconds) / (3600*24));
												    if($days> 0)
												    {
												        $ret .= "$days days ";
												    }
												    /*** get the hours ***/
												    $hours = (intval($seconds) / 3600) % 24;
												    if($hours > 0)
												    {
												        $ret .= "$hours hours ";
												    }
												    /*** get the minutes ***/
												    $minutes = (intval($seconds) / 60) % 60;
												    if($minutes > 0)
												    {
												        $ret .= "$minutes minutes ";
												    }
												    /*** get the seconds ***/
												    $seconds = intval($seconds) % 60;
												    if ($seconds > 0) {
												        $ret .= "$seconds seconds";
												    }
												    return $ret;
												}
																						}
													print secondsToWords($tseconds);
												}
											    else {
											    echo('NA');
											}
											?></td>
			                            <td>
			                            <?php
			                              $ip= $encode['encoder_ip'];
											if (!$socket = @fsockopen("$ip", 22, $errno, $errstr, 2))
											{
											  echo ("<span id='status' class='label label-danger'>Dead</span>");
											}
											else 
											{
											  echo("<span id='status' class='label label-success'>Alive</span>");
											  fclose($socket);
											}
											?>
			                           
											</td>
			                            <td><a href="#" data-toggle="tooltip" title="Refresh" data-placement="bottom"><i class="fa fa-refresh" aria-hidden="true"></i></a></td>
			                            <td><a href="#" data-toggle="tooltip" title="Reboot" data-placement="bottom"><i class="fa fa-repeat" aria-hidden="true"></i></a></td>
			                            <td><a data-container="body" data-toggle="tooltip" title="CPU: XX Heap: XX Memory: XX Disk: XX" data-placement="bottom" data-html="true" href="#"><i class="fa fa-heartbeat" aria-hidden="true"></i></a></td>
			                            <!--<td><a data-toggle="tooltip" title="Remove" data-placement="bottom"><i class="fa fa-trash" aria-hidden="true"></i></a></td>-->
										
										<td><a data-toggle="tooltip" title="Delete" class="encodersdelete" id="del_<?php echo $encode['id']?>" href="javascript:void(0);"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
										
			                        </tr>
									<?php
									$encoder_count++;
								}
							}
							else
							{
								?>
								<tr>
									<td colspan="10">Encoders Not Added Yet!</td>
								</tr>
								<?php
							}
                        	?>
                    </table>
                </div>
            </div>
        </div>
    </div>
									</div>
								</div>
								 <div role="tabpanel" class="tab-pane" id="Encoding-Templates"><div class="action-table">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="box-header">                                               
                                                <a href="<?php echo site_url();?>groupadmin/createtemplate" class="add-btn">
                                                    <span><i class="fa fa-plus"></i> Template</span>
                                                </a>
                                            </div>
                                            <div class="box">
                                                <div class="box-body table-responsive no-padding">
                                                    <table class="table table-hover check-input">
                                                        <tr>                                                           
                                                            <th>ID</th>
                                                            <th>Name</th>
                                                            <th>Video Encoding</th>
                                                            <th>Audio Encoding</th>
                                                            <th>Status</th>
                                                            <th> &nbsp; </th>
                                                            <th> &nbsp; </th>                                                            
                                                        </tr>
                                                        <?php
                                                        $user_data = $this->session->userdata('user_data');	
                                                        $encoderTemplates = $this->common_model->getEncoderTemplate($user_data['userid']);
                                                        $templateCounter =1;
                                                        if(sizeof($encoderTemplates)>0)
                                                        {
															foreach($encoderTemplates as $template)
															{
																?>
															<tr>                                                           
                                                            <td><?php echo $templateCounter;?></td>
                                                            <td><?php echo $template['template_name'];?></td>
                                                            <td>
                                                                <table>
                                                                    <tr>
                                                                        <td style="padding-right:6px;text-align: center;">
                                                                            <span class="text-blue">Codec
                                                                            </span>
                                                                            <p><?php echo $template['video_codec'];?></p>
                                                                        </td>
                                                                        <td style="padding: 0 6px;text-align: center;">
                                                                            <span class="text-blue">Resolution
                                                                            </span>
                                                                            <p><?php echo $template['video_resolution'];?></p>                                                                            
                                                                        </td>
                                                                        <td style="padding: 0 6px;text-align: center;">
                                                                            <span class="text-blue">Bitrate (kbps)
                                                                            </span>
                                                                            <p><?php echo $template['video_bitrate'];?></p>
                                                                        </td>
                                                                        <td style="padding: 0 6px;text-align: center;">
                                                                            <span class="text-blue">FPS
                                                                            </span>
                                                                            <p><?php echo $template['video_framerate'];?></p>
                                                                        </td>           
                                                                        <td style="padding: 0 6px;text-align: center;">
                                                                            <span class="text-blue">Preset
                                                                            </span>
                                                                            <p><?php echo $template['adv_video_min_bitrate'];?></p>
                                                                        </td>
                                                                        <td style="padding: 0 6px;text-align: center;">
                                                                            <span class="text-blue">Profile
                                                                            </span>
                                                                            <p><?php echo $template['adv_video_max_bitrate'];?></p>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td>
                                                                <table>
                                                                    <tr>
                                                                        <td style="padding-right:6px;text-align: center;">
                                                                            <span class="text-blue">Codec
                                                                            </span>
                                                                            <p><?php echo $template['audio_codec'];?></p>
                                                                        </td>
                                                                        <td style="padding: 0 6px;text-align: center;">
                                                                            <span class="text-blue">Channels
                                                                            </span>
                                                                            <p><?php echo $template['audio_channel'];?></p>                                                                            
                                                                        </td>
                                                                        <td style="padding: 0 6px;text-align: center;">
                                                                            <span class="text-blue">Bitrate (kbps)
                                                                            </span>
                                                                            <p><?php echo $template['audio_bitrate'];?></p>
                                                                        </td>
                                                                        <td style="padding: 0 6px;text-align: center;">
                                                                            <span class="text-blue">Sampel Rate
                                                                            </span>
                                                                            <p><?php echo $template['audio_sample_rate'];?></p>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td><span class="label label-success">Enabled</span></td>
                                                            <td><a href="#"><i class="fa fa-check-circle" aria-hidden="true"></i></a></td>
                                                            <td><a href="#"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                                        </tr>
																<?php
																$templateCounter++;
															}
														}
														else
														{
															?>
																<tr>
																	<td colspan="8">Encoder Template Not Created Yet!</td>
																</tr>
															<?php
														}
                                                        ?>
                                                       
                                                    </table>
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
				<!-- ========= Section One End ========= -->
				
				
			</div>
		</div>
	</div>
	<!-- ========= Main Content End ========= -->
</section>
<!-- ========= Content Wrapper End ========= -->