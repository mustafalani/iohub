<?php $this->load->view('guser/navigation.php');?>
<?php $this->load->view('guser/leftsidebar.php');?>


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
									<li class= "active" role="presentation"><a id="system" href="#systems" aria-controls="systems" role="tab" data-toggle="tab">Systems</a></li>
									<li  role="presentation"><a id="wowza" href="#wowzaengine" aria-controls="wowza" role="tab" data-toggle="tab">Wowza</a></li>
									<li role="presentation"><a id="encoders" href="#Encoders" aria-controls="ffmpeg" role="tab" data-toggle="tab">Encoders</a></li>
										<li role="presentation"><a id="encodingtemplate" href="#Encoding-Templates" aria-controls="Encoding Templates" role="tab" data-toggle="tab">Encoding Templates</a></li>	
								</ul>
								
							</div>
							
							<!-- === Tab panes === -->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane fade in active" id="systems">
									<form  class="form-only form-one" method="post" action="<?php echo site_url();?>admin/updategroupanduserinfo" enctype="multipart/form-data">
									<div class="col-lg-12 sav-btn-dv">
						             <button type="submit" class="btn-def save">
										<span>Save</span>
									</button>
								</div>
										<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
										  <div class="wowza-form col-lg-12 conf shadow" id="wowza_form ">		
								
							</div>
										<div class="row">
											<div class="col-lg-4 col-md-12">
												<div class="form-group">
													<label>Company Name <span class="mndtry">*</span></label>
													<input type="text" class="form-control" placeholder="Kurrent" name="group_name" value="<?php echo $groupinfo[0]['group_name'];?>"> 
												</div>
												<div class="form-group">
													<label>Email <span class="mndtry">*</span></label>
													<input type="text" class="form-control" placeholder="info@kurrent.tv" name="group_email" value="<?php echo $groupinfo[0]['group_email'];?>">
												</div>
												<div class="form-group">
													<label>License <span class="mndtry">*</span></label>
													<input type="text" class="form-control" placeholder="Demo" name="group_licence" value="<?php echo $groupinfo[0]['group_licence'];?>">
													<span class="text-five">9999 days remaining</span>
												</div>
												<!----<button type="submit" class="btn-def save">
													<span><i class="fa fa-save"></i> Save</span>
												</button>--->
											</div>
											<div class="col-lg-4 col-md-12">
												<div class="form-group">
													<label>Time Zone <span class="mndtry">*</span></label>
													<div class="custom-select">
														
														<select id="timezone" name="timezone" class="form-control"  required="true">           
															<option value="0">Time Zone</option>          
															<?php 
																$timezoness = $this->common_model->getAllTimezone();                  			
																if(sizeof($timezoness)>0)
																{
																	foreach($timezoness as $timezones)
																	{
																		if($timezones['timeZoneId'] == $userDetails[0]['timezone'])
																		{
																			echo '<option selected="selected" value="'.$timezones['timeZoneId'].'">'.$timezones['time_zone_name'].'</option>';	
																		}
																		else
																		{
																			echo '<option value="'.$timezones['timeZoneId'].'">'.$timezones['time_zone_name'].'</option>';	
																		}
																	}
																}
																
															?> 
															
														</select>  
													</div>
												</div>
												<div class="form-group">
													<label>Date Format <span class="mndtry">*</span></label>
													<div class="input-group date" data-provide="datepicker2">
														<input type="text" class="form-control datepicker2" data-date-format="dd/mm/yyyy" placeholder=" dd/mm/yyyy" name="timeformat" id="timeformat" value="<?php echo $userDetails[0]['timeformat'];?>">
														<div class="input-group-addon calc-addon">
															<span class="glyphicon glyphicon-calendar"></span>
														</div>
													</div>
												</div>
												<div class="form-group">
													<label>Language <span class="mndtry">*</span></label>
													<input type="text" class="form-control" placeholder="English" name="language" id="language" value="<?php echo $userDetails[0]['language'];?>">
												</div>
											</div>
											<div class="col-lg-4 col-md-12">
												<div class="form-group">
													<label>Appearance</label>
													<div class="appearance-box">
														<div class="row rows row-one ">
															<div class="col-lg-6 col-md-6 xm-only">
																<div class="switch-box" >Use Light Theme <span class="switch-btn">
																	
																	<?php 
																		if($groupinfo[0]['group_theme'] == 1)
																		{
																			
																			echo '<input type="checkbox" name="group_theme" id="group_theme" checked/>';
																			
																		}
																	    elseif($groupinfo[0]['group_theme'] == 0)
																		{
																			echo '<input type="checkbox" name="group_theme" id="group_theme">';
																		}	
																		
																	?>
																	<label for="group_theme">Toggle</label>
																</span></div>
															</div>
															<div class="col-lg-6 col-md-6 xm-only">
																<div class="switch-box">Menu Auto Hide <span class="switch-btn">
																	<?php 
																		if($groupinfo[0]['group_menu_hide'] == 1)
																		{
																			
																			echo '<input type="checkbox" name="group_menu_hide" id="group_menu_hide" checked/>';
																			
																		}
																	    elseif($groupinfo[0]['group_menu_hide'] == 0)
																		{
																			echo '<input type="checkbox" name="group_menu_hide" id="group_menu_hide">';
																		}	
																		
																	?>
																	
																	
																<label for="group_menu_hide">Toggle</label></span></div>
															</div>
														</div>
														<div class="row rows row-two">
															<div class="col-lg-6 col-md-6 xm-only">
																<div class="switch-box">Use Default Logo <span class="switch-btn">
																	<?php 
																		if($groupinfo[0]['group_logo'] == 1)
																		{
																			
																			echo '<input type="checkbox" name="group_logo" id="group_logo" checked/>';
																			
																		}
																	    elseif($groupinfo[0]['group_logo'] == 0)
																		{
																			echo '<input type="checkbox" name="group_logo" id="group_logo">';
																		}	
																		
																	?>
																	
																<label for="group_logo">Toggle</label></span></div>
															</div>
															<div class="col-lg-6 col-md-6 xm-only">
																<div class="switch-box">Shortcut Icon <span class="switch-btn">
																	<?php 
																		if($groupinfo[0]['group_favicon'] == 1)
																		{
																			
																			echo '<input type="checkbox" name="group_favicon" id="group_favicon" checked/>';
																			
																		}
																	    elseif($groupinfo[0]['group_favicon'] == 0)
																		{
																			echo '<input type="checkbox" name="group_favicon" id="group_favicon">';
																		}	
																		
																	?>
																<label for="group_favicon">Toggle</label></span></div>
															</div>
														</div>
														<div class="row rows row-three">
															<div class="col-lg-6 col-md-6 xm-only">
																<div class="switch-box">Hide Notifications <span class="switch-btn"><input type="checkbox" id="switch4" />
																	<?php 
																		if($groupinfo[0]['group_notification'] == 1)
																		{
																			
																			echo '<input type="checkbox" name="group_notification" id="group_notification" checked/>';
																			
																		}
																	    elseif($groupinfo[0]['group_notification'] == 0)
																		{
																			echo '<input type="checkbox" name="group_notification" id="group_notification">';
																		}	
																		
																	?>
																	
																	
																<label for="group_notification">Toggle</label></span></div>
															</div>
															<div class="col-lg-6 col-md-6 xm-only none"> &nbsp; </div>
														</div>
														<div class="row rows row-four">
															<div class="col-lg-6 col-md-6 xm-only">
																<div class="switch-box">Hide Site Name <span class="switch-btn">
																	<?php 
																		if($groupinfo[0]['group_sitename'] == 1)
																		{
																			
																			echo '<input type="checkbox" name="group_sitename" id="group_sitename" checked/>';
																			
																		}
																	    elseif($groupinfo[0]['group_sitename'] == 0)
																		{
																			echo '<input type="checkbox" name="group_sitename" id="group_sitename">';
																		}	
																		
																	?>
																	
																	
																	
																	
																<label for="group_sitename">Toggle</label></span></div>
															</div>
															<div class="col-lg-6 col-md-6 xm-only none"> &nbsp; </div>
														</div>
													</div>
												</div>
											</div>
											
										</div>
									</form>
								</div>
								<div role="tabpanel" class="tab-pane" id="wowzaengine">
									<div class="action-table">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="box-header">
                                                    
                                                    <!-- Single button -->
                                                    <div class="btn-group">                                                       
														<div class="custom-select">
														<select class="form-control actionsel" id="actionval">
															<option value="">Action</option>
															<option value="Refresh">Refresh</option>
															<option value="Reboot">Reboot</option>	
															<option value="Delete">Delete</option>
														</select>
														</div>
														
													</div>
                                                    <!-- Standard button -->
                                                    <button type="button" class="btn btn-default submit" onclick="submitAllwavoz('admin/wowzaActions')";>Submit</button>
                                                    <a class="add-btn" id="add_wowza" href="<?php echo site_url();?>admin/createwowza">
                                                        <span><i class="fa fa-plus"></i> Wowza Engine</span>
													</a>
												</div>
                                                
                                                <div class="box">
                                                    <div class="box-body table-responsive no-padding">
                                                        <table id="wowzaengins" class="table table-hover check-input wowzaTable">
                                                            <tr>
                                                                <th>
                                                                    <div class="boxes">                                                                       
																		<input type="checkbox"  class="checkbox" id="selecctalladminuser"/>
                                                                        <label for="selecctalladminuser"></label>
																	</div>
																</th>
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
																	<tr class="wowza_row">
																		<td> 
																			<div class="boxes">	
																				<input type="checkbox" name="appids[]" class="groupdel2" id = "del_<?php echo $configdetail['id']?>" value = "<?php echo $configdetail['id']?>">
																				<label for="del_<?php echo $configdetail['id']?>"></label>
																			</div>
																		</td>																																<td><?php echo $counter;?></td>
																		<td><a class="wowid" id="<?php echo $configdetail['id']?>" href="<?php echo site_url();?>/admin/updatewowzaengin/<?php echo $configdetail['id']?>">
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
																		?></strong> <a href="<?php echo site_url();?>admin/applications/<?php echo $Id;?>"> See Application</a></td>
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
                 <!-- Single button -->
                <div class="btn-group">                                                       
					<div class="custom-select">
					<select class="form-control actionsel" id="actionEncoders">
						<option value="">Action</option>
						<option value="Refresh">Refresh</option>
						<option value="Reboot">Reboot</option>	
						<option value="Delete">Delete</option>
					</select>
					</div>
					
				</div>
                <!-- Standard button -->
                <button type="button" class="btn btn-default submit" onclick="submitAllencoders('admin/encoderActions')";>Submit</button>
               
                <a href="<?php echo site_url();?>admin/addEncoderes" class="add-btn">
                    <span><i class="fa fa-plus"></i> Encoder</span>
                </a>				
            </div>
            <div class="box">
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover check-input">
                        <tr>
                            <th>
                                <div class="boxes">
                                    <input type="checkbox" id="selectallencoders">
                                    <label for="selectallencoders"></label>
                                </div>
                            </th>
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
										<td>
			                                <div class="boxes">
			                                    <input type="checkbox" name="appids[]" class="endcoderGrp" id="del_<?php echo $encode['id'];?>" value="<?php echo $encode['id'];?>">
			                                    <label for="del_<?php echo $encode['id'];?>"></label>
			                                </div>
			                            </td>
			                            <td><?php echo $encoder_count;?></td>
			                            <td><a href="<?php echo site_url();?>admin/editEncoder/<?php echo $encode['id'];?>"><?php echo $encode['encoder_name'];?></a> </td>
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
                                                <!-- Single button -->
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <i class="fa fa-angle-down" aria-hidden="true"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="#">Disable</a></li>
                                                        <li><a href="#">Enable</a></li>
                                                        <li role="separator" class="divider"></li>
                                                        <li><a href="#">Delete</a></li>
                                                    </ul>
                                                </div>
                                                <!-- Standard button -->
                                                <button type="button" class="btn btn-default submit">Submit</button>
                                                <a href="<?php echo site_url();?>admin/createtemplate" class="add-btn">
                                                    <span><i class="fa fa-plus"></i> Template</span>
                                                </a>
                                            </div>
                                            <div class="box">
                                                <div class="box-body table-responsive no-padding">
                                                    <table class="table table-hover check-input">
                                                        <tr>
                                                            <th>
                                                                <div class="boxes">
                                                                    <input type="checkbox" id="box-1">
                                                                    <label for="box-1"></label>
                                                                </div>
                                                            </th>
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
                                                            <td>
                                                                <div class="boxes">
                                                                    <input type="checkbox" id="templateAction_<?php echo $template['id'];?>">
                                                                    <label for="templateAction_<?php echo $template['id'];?>"></label>
                                                                </div>
                                                            </td>
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
																	<td colspan="8">No Record Found!</td>
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