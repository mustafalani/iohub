<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<style type="text/css">
	.netdata-chart span{
		color: #FFFFFF !important;
	}
	.wowzaTable tr td a.wowzadisable:hover .box-body
	{
		display:block !important;
	}

</style>
<main class="main">
        <!-- Breadcrumb-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Home</a>
          </li>
          <li class="breadcrumb-item active">Settings</li>
        </ol>
        <div class="container-fluid">
        <div class="animated fadeIn">
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
			<div class="card">
				<div class="card-body">
					<div class="row">
				<div class="col-md-12 mb-4">
                <ul class="nav nav-tabs" role="tablist">
                	<?php
            		$user_permissions = $this->session->userdata('user_permissions');
		              $userdata = $userdata = $this->session->userdata('user_data');
		              if($userdata['user_type'] == 1)
		              {
		              	?>
		              	<li class="nav-item" role="presentation">

		              	<a class="nav-link active" id="system" href="#systems" aria-controls="systems" role="tab" data-toggle="tab">System</a></li>
		              	<?php
					  }
					?>
					<li class="nav-item"  role="presentation">
					<a class="nav-link" id="wowza" href="#wowzaengine" aria-controls="wowza" role="tab" data-toggle="tab">Publishers</a></li>
					<li class="nav-item" role="presentation">
					<a class="nav-link" id="encoders" href="#Encoders" aria-controls="ffmpeg" role="tab" data-toggle="tab">Encoders</a></li>
					<li class="nav-item" role="presentation">
					<a class="nav-link" id="gateway" href="#gateways" aria-controls="ffmpeg" role="tab" data-toggle="tab">NDI Gateways</a></li>
					<li class="nav-item" role="presentation">
					<a class="nav-link" id="encodingtemplate" href="#Encoding-Templates" aria-controls="Encoding Templates" role="tab" data-toggle="tab">Encoding Presets</a></li>
					<li class="nav-item" role="presentation">
					<a class="nav-link"  href="#nebula" aria-controls="Nebula" role="tab" data-toggle="tab">Nebula</a></li>

                </ul>
                <div class="tab-content">
                   <?php

              if($userdata['user_type'] == 1)
              {
              	?>
              		<div role="tabpanel" class="tab-pane active" id="systems">
									<form  class="form-only form-one" method="post" action="<?php echo site_url();?>admin/updategroupanduserinfo" enctype="multipart/form-data">
									<div class="col-lg-12 sav-btn-dv">
						             <button type="submit" class="btn save btn-primary float-right">
										<span>Save</span>
									</button>
								</div>
										<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
										 <!-- <div class="wowza-form col-lg-12 conf shadow" id="wowza_form ">											</div>-->
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


														<select id="timezone" name="timezone" class="form-control selectpicker"  required="true">
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
											<div class="col-lg-4 col-md-12" style="display:none;">
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
              	<?php
			  }


			  if($userdata['user_type'] == 1)
              {
              	?>
              	<div role="tabpanel" class="tab-pane " id="wowzaengine">
              	<?php
			  }
			  else
			  {
			  	?>
			  				<div role="tabpanel" class="tab-pane active" id="wowzaengine">
			  	<?php
			  }
			  ?>					<div class="card-body">
                                        <div class="row">
                                            <div class="col-12" style="padding: 0;">
                                                <div class="box-header">
                                                    <!-- Single button -->
                                                    <div class="btn-group">
														<select class="form-control actionsel" id="actionval">
															<option value="">Action</option>
															<option value="Refresh">Refresh</option>
															<option value="TakeOffline">Take Offline</option>
															<option value="BringOnline">Bring Online</option>
															<option value="Reboot">Reboot</option>
												            <option value="Delete">Delete</option>


														</select>
													</div>
                                                    <!-- Standard button -->
                                                    <button type="button" class="btn btn-primary submit" onclick="wowzaactions();">Submit</button>
                                                    <a class="add-btn btn btn-primary float-right" id="add_wowza" href="<?php echo site_url();?>createwowza">
                                                        <span><i class="fa fa-plus"></i> Publisher</span>
													</a>
												</div>
												<br />
                                                    <div class="table-responsive no-padding">
                                                        <table id="wowzaengins" class="cstmtable table table-hover check-input wowzaTable">
                                                        <tr>
                                                                <th>
                                                                    <div class="boxes">
																		<input type="checkbox"  class="checkbox" id="selecctalladminuser"/>
                                                                        <label for="selecctalladminuser"></label>
																	</div>
																</th>
																<th>ID</th>
                                                                <th>Name</th>
                                                                <th>Group Name</th>
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
																	<tr class="wowza_row" id="row_<?php echo $configdetail['id'];?>">
																		<td>
																			<div class="boxes">
																				<input type="checkbox" name="appids[]" class="groupdel2" id = "del_<?php echo $configdetail['id']?>" value = "<?php echo $configdetail['id']?>">
																				<label for="del_<?php echo $configdetail['id']?>"></label>
																			</div>
																		</td>																											<td><?php echo $counter;?></td>
																		<td><a class="wowid" id="<?php echo $configdetail['id']?>" href="<?php echo site_url();?>updatewowzaengin/<?php echo $configdetail['id']?>">


																		<?php echo $configdetail['wse_instance_name'];?></a></td>
																		<td>
																			<?php
																			if($configdetail['group_id'] > 0)
																			{
																				$groupName = $this->common_model->getGroupInfobyId($configdetail['group_id']);
																				echo $groupName[0]['group_name'];
																			}
																			else
																			{
																				echo "NA";
																			}

																			?>
																		</td>
																		<td>
																		<?php
																		$woaddress = "http://".$configdetail['ip_address'].":".$configdetail['wse_cp_port'];
																		 ?>
																		<a target="_blank" href="<?php echo $woaddress;?>"><?php echo $configdetail['ip_address'];?></a></td>


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
																		<td style="position:relative;"><a  class="wowzadisable" href="javascript:void(0);"><i class="fa fa-heartbeat" aria-hidden="true"></i></a>
																		<?php
																		if($configdetail['status'] == 1)
																		{
																			$host = "http://".$configdetail['ip_address'].":19999";
										$url = $host."/api/v1/charts";
										$ch = curl_init();
									    $headers = array(
									    'Content-Type: application/json'
									    );
									    curl_setopt($ch, CURLOPT_URL, $url);
									    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
									    curl_setopt($ch, CURLOPT_HEADER, 0);
									    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
									    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
									    curl_setopt($ch, CURLOPT_TIMEOUT, 2);
									    $result = curl_exec($ch);
									    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);


										if($httpcode == 200)
										{

									?>

	                     <div class="box-body" style="display:none;position: absolute;top: -117px;min-width: 500px;/*! left: 0; */border: 1px solid;background: #3C8DBC;padding: 0;min-height: 131px;right: -274%;">
	                        <div style="width: 100%; max-height: calc(100% - 15px); text-align: center; display: inline-block;">
						            <div style="width: 100%; height:100%; align: center; display: inline-block;">
	              					  <br/>
						                <div class="netdata-container-gauge" style="margin-right: 10px; width: 32%; will-change: transform;" data-netdata="system.cpu"  data-host="<?php echo $host;?>" data-chart-library="gauge" data-title="CPU" data-units="%" data-gauge-max-value="100" data-width="32%" data-after="-420" data-points="420" data-colors="#22AA99" role="application"></div>
						                <div class="netdata-container-easypiechart" style="margin-right: 10px; width: 17%; will-change: transform;" data-netdata="system.net" data-host="<?php echo $host;?>" data-dimensions="received" data-chart-library="easypiechart" data-title="Net Inbound" data-width="17%" data-before="0" data-after="-420" data-points="420" data-common-units="system.net.mainhead" role="application"></div>
						                <div class="netdata-container-easypiechart" style="margin-right: 10px; width: 15%; will-change: transform;" data-netdata="system.net" data-host="<?php echo $host;?>" data-dimensions="sent" data-chart-library="easypiechart" data-title="Net Outbound" data-width="15%" data-before="0" data-after="-420" data-points="420" data-common-units="system.net.mainhead" role="application"></div>
						                <div class="netdata-container-easypiechart" style="margin-right: 10px; width: 12%; will-change: transform;" data-netdata="system.ram" data-host="<?php echo $host;?>" data-dimensions="used|buffers|active|wired" data-append-options="percentage" data-chart-library="easypiechart" data-title="Used RAM" data-units="%" data-easypiechart-max-value="100" data-width="12%" data-after="-420" data-points="420" data-colors="#EE9911" role="application">

						                </div>
	           						 </div>
						          </div>
	                    		 </div>
									<?php
										}
										else
										{
											?>

					                     <div class="box-body" style="display:none;position: absolute; top:-34px; min-width: 211px; border: 1px solid; background: rgb(60, 141, 188) none repeat scroll 0% 0%; padding: 0px; min-height: 50px; right: -169%;">
					                        <div class="row">
					                           <div class="col-xs-6 col-md-12 text-center">
					                              <h1 style="margin:0;font-size:25px;margin-top:10px;">No Data Found</h1>
					                           </div>
					                        </div>
					                     </div>
										<?php
										}
																		}
																		else
																		{
																			?>

					                     <div class="box-body" style="display:none;position: absolute; top:-34px; min-width: 211px; border: 1px solid; background: rgb(60, 141, 188) none repeat scroll 0% 0%; padding: 0px; min-height: 50px; right: -169%;">
					                        <div class="row">
					                           <div class="col-xs-6 col-md-12 text-center">
					                              <h1 style="margin:0;font-size:25px;margin-top:10px;">No Data Found</h1>
					                           </div>
					                        </div>
					                     </div>
										<?php
																		}
																		?>
																		</td>

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
																	<td colspan="11">No Publishers Added Yet!</td>
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
							<div role="tabpanel" class="tab-pane" id="Encoders">
									<div class="card-body">
						    			<div class="row">
        									<div class="col-12" style="padding: 0;">
									            <div class="box-header">
									                 <!-- Single button -->
									                <div class="btn-group">
														<select class="form-control actionsel" id="actionEncoders">
															<option value="">Action</option>
															<option value="Refresh">Refresh</option>
															<option value="TakeOffline">Take Offline</option>
															<option value="BringOnline">Bring Online</option>
															<option value="Reboot">Reboot</option>
															<option value="Delete">Delete</option>
														</select>
													</div>
									                <!-- Standard button -->
									                <button type="button" class="btn btn-primary submit" onclick="submitAllencoders()">Submit</button>

									                <a href="<?php echo site_url();?>addEncoderes" class="btn btn-primary add-btn float-right">
									                    <span><i class="fa fa-plus"></i> Encoder</span>
									                </a>
									            </div>
            <br/>
                <div class="table-responsive no-padding" >
                    <table class="table table-hover check-input cstmtable encoderTable">
                        <tr>
                            <th>
                                <div class="boxes">
                                    <input type="checkbox" id="selectallencoders">
                                    <label for="selectallencoders"></label>
                                </div>
                            </th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Group Name</th>
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
									<tr id="row_<?php echo $encode['id'];?>">
										<td>
			                                <div class="boxes">
			                                    <input type="checkbox" name="appids[]" class="endcoderGrp" id="del_<?php echo $encode['id'];?>" value="<?php echo $encode['id'];?>">
			                                    <label for="del_<?php echo $encode['id'];?>"></label>
			                                </div>
			                            </td>
			                            <td><?php echo $encoder_count;?></td>
			                            <td><a id="<?php echo $encode['id'];?>" class="enciid" href="<?php echo site_url();?>editEncoder/<?php echo $encode['id'];?>"><?php echo $encode['encoder_name'];?></a> </td>
			                            <td>
											<?php
											if($encode['encoder_group'] > 0)
											{
												$groupName = $this->common_model->getGroupInfobyId($encode['encoder_group']);
												echo $groupName[0]['group_name'];
											}
											else
											{
												echo "NA";
											}
											?>
										</td>
			                            <td><?php echo $encode['encoder_ip'];?></td>
			                            <td>
			                            <?php

			                            //$hardware = $this->common_model->getAllHardware($encode['encoder_hardware']);
										$hardware = $this->common_model->getHardwareByEncdrId($encode['id']);
										if(sizeof($hardware)>0)
										{
											foreach($hardware as $hdr)
											{
												$model = $this->common_model->getAllModelsbyID($hdr['model']);
												if(sizeof($model)>0)
												{
													echo '<span class="text-blue">'.$model[0]['item'].'</span><br/>';
												}
											}
										}
										else
										{
											echo 'NA';
										}
										?></td>
			                            <td class="uptime">
			                            <?php
			                            if($encode['status'] == 1)
										{
											if($encode['uptime'] != "")
											{
													echo $encode['uptime'];
											}
											else
											{
													echo "NA";
											}


										}
										elseif($encode['status'] == 2)
										{
											echo 'NA';
										}
										?>
										</td>
			                            <td>
			                            <?php
			                            if($encode['status'] == 1)
										{
											echo("<span id='status' class='label label-success'>Online</span>");
										}
										else
										{
											echo("<span id='status' class='label label-danger'>Offline</span>");
										}
										?>

											</td>
											 <td style="position:relative;"><a class="encoder_heart" id="encheart_<?php echo $encode['id'];?>" data-html="true" href="#"><i class="fa fa-heartbeat" aria-hidden="true"></i></a>
			                            	<?php
																		if($encode['status'] == 1)
																		{
																			$host = "http://".$encode['encoder_ip'].":19999";
										$url = $host."/api/v1/charts";
										$ch = curl_init();
									    $headers = array(
									    'Content-Type: application/json'
									    );
									    curl_setopt($ch, CURLOPT_URL, $url);
									    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
									    curl_setopt($ch, CURLOPT_HEADER, 0);
									    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
									    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
									    curl_setopt($ch, CURLOPT_TIMEOUT, 2);
									    $result = curl_exec($ch);
									    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);


										if($httpcode == 200)
										{

									?>

	                     <div class="box-body" style="display:none;position: absolute;top: -117px;min-width: 500px;/*! left: 0; */border: 1px solid;background: #3C8DBC;padding: 0;min-height: 131px;right: -274%;">
	                        <div style="width: 100%; max-height: calc(100% - 15px); text-align: center; display: inline-block;">
						            <div style="width: 100%; height:100%; align: center; display: inline-block;">
	              					  <br/>
						                <div class="netdata-container-gauge" style="margin-right: 10px; width: 32%; will-change: transform;" data-netdata="system.cpu"  data-host="<?php echo $host;?>" data-chart-library="gauge" data-title="CPU" data-units="%" data-gauge-max-value="100" data-width="32%" data-after="-420" data-points="420" data-colors="#22AA99" role="application"></div>
						                <div class="netdata-container-easypiechart" style="margin-right: 10px; width: 17%; will-change: transform;" data-netdata="system.net" data-host="<?php echo $host;?>" data-dimensions="received" data-chart-library="easypiechart" data-title="Net Inbound" data-width="17%" data-before="0" data-after="-420" data-points="420" data-common-units="system.net.mainhead" role="application"></div>
						                <div class="netdata-container-easypiechart" style="margin-right: 10px; width: 15%; will-change: transform;" data-netdata="system.net" data-host="<?php echo $host;?>" data-dimensions="sent" data-chart-library="easypiechart" data-title="Net Outbound" data-width="15%" data-before="0" data-after="-420" data-points="420" data-common-units="system.net.mainhead" role="application"></div>
						                <div class="netdata-container-easypiechart" style="margin-right: 10px; width: 12%; will-change: transform;" data-netdata="system.ram" data-host="<?php echo $host;?>" data-dimensions="used|buffers|active|wired" data-append-options="percentage" data-chart-library="easypiechart" data-title="Used RAM" data-units="%" data-easypiechart-max-value="100" data-width="12%" data-after="-420" data-points="420" data-colors="#EE9911" role="application">

						                </div>
	           						 </div>
						          </div>
	                    		 </div>
									<?php
										}
										else
										{
											?>

					                     <div class="box-body" style="display:none;position: absolute; top:-34px; min-width: 211px; border: 1px solid; background: rgb(60, 141, 188) none repeat scroll 0% 0%; padding: 0px; min-height: 50px; right: -169%;">
					                        <div class="row">
					                           <div class="col-xs-6 col-md-12 text-center">
					                              <h1 style="margin:0;font-size:25px;margin-top:10px;">No Data Found</h1>
					                           </div>
					                        </div>
					                     </div>
										<?php
										}
																		}
																		else
																		{
																			?>

					                     <div class="box-body" style="display:none;position: absolute; top:-34px; min-width: 211px; border: 1px solid; background: rgb(60, 141, 188) none repeat scroll 0% 0%; padding: 0px; min-height: 50px; right: -169%;">
					                        <div class="row">
					                           <div class="col-xs-6 col-md-12 text-center">
					                              <h1 style="margin:0;font-size:25px;margin-top:10px;">No Data Found</h1>
					                           </div>
					                        </div>
					                     </div>
										<?php
																		}
																		?>

			                            </td>
			                            <td><a href="#" class="encoder_refresh" id="encref_<?php echo $encode['id'];?>" data-toggle="tooltip" title="Refresh" data-placement="bottom"><i class="fa fa-refresh" aria-hidden="true"></i></a></td>
			                            <td><a href="#" class="encoder_reboot" id="encreboot_<?php echo $encode['id'];?>" data-toggle="tooltip" title="Reboot" data-placement="bottom"><i class="fa fa-repeat" aria-hidden="true"></i></a></td>

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
								<td colspan="10">No Encoders Added Yet!</td>
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
							<div role="tabpanel" class="tab-pane" id="gateways">
								<div class="card-body">
					    			<div class="row">
        								<div class="col-12" style="padding: 0;">
            								<div class="box-header">
                 <!-- Single button -->
                <div class="btn-group">

					<select class="form-control actionsel " id="actionGateways">
						<option value="">Action</option>
						<option value="Refresh">Refresh</option>
						<option value="TakeOffline">Take Offline</option>
						<option value="BringOnline">Bring Online</option>
						<option value="Reboot">Reboot</option>
						<option value="Delete">Delete</option>
					</select>


				</div>
                <!-- Standard button -->
                <button type="button" class="btn btn-primary submit" onclick="submitAllgateways()";>Submit</button>

                <a  href="<?php echo site_url();?>addgateways" class="btn btn-primary add-btn float-right">
                    <span><i class="fa fa-plus"></i> NDI Gateway</span>
                </a>
            </div>
            <br/>
                <div class="table-responsive no-padding" >
                    <table class="table table-hover check-input cstmtable gatewayTable">
                        <tr>
                            <th>
                                <div class="boxes">
                                    <input type="checkbox" id="selectallgateways">
                                    <label for="selectallgateways"></label>
                                </div>
                            </th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Group Name</th>
                            <th>IP Address</th>

                            <th>Uptime</th>
                            <th>Status</th>
                            <th> &nbsp; </th>
                            <th> &nbsp; </th>
                            <th> &nbsp; </th>
                            <th> &nbsp; </th>
                        </tr>

                        	<?php
                        	if(sizeof($gateways)>0)
                        	{
                        		$gateway_count=1;
								foreach($gateways as $gateway)
								{
									?>
									<tr id="row_<?php echo $gateway['id'];?>">
										<td>
			                                <div class="boxes">
			                                    <input type="checkbox" name="appids[]" class="gatewaysGrp" id="del_<?php echo $gateway['id'];?>" value="<?php echo $gateway['id'];?>">
			                                    <label for="del_<?php echo $gateway['id'];?>"></label>
			                                </div>
			                            </td>
			                            <td><?php echo $gateway_count;?></td>
			                            <td><a id="<?php echo $gateway['id'];?>" class="enciid" href="<?php echo site_url();?>editGateway/<?php echo $gateway['id'];?>"><?php echo $gateway['encoder_name'];?></a> </td>
			                            <td>
											<?php
											if($gateway['encoder_group'] > 0)
											{
												$groupName = $this->common_model->getGroupInfobyId($gateway['encoder_group']);
												echo $groupName[0]['group_name'];
											}
											else
											{
												echo "NA";
											}
											?>
										</td>
			                            <td><?php echo $gateway['encoder_ip'];?></td>

			                            <td class="uptime">
			                            <?php
			                            	if($gateway['status'] == 1)
											{
												if($gateway['uptime'] != "")
												{
													echo $gateway['uptime'];
												}
												else
												{
													echo 'NA';
												}
											}
											else
											{
												echo 'NA';
											}
										 ?></td>
			                            <td>
			                            <?php
			                            	if($gateway['status'] == 1)
											{
												$ip= $gateway['encoder_ip'];
												//if (!$socket = @fsockopen("$ip", 22, $errno, $errstr, 2))
												//{
												//  echo ("<span id='status' class='label label-danger'>Dead</span>");
												//}
											//	else
												//{
												  echo("<span id='status' class='label label-success'>Online</span>");
												//  fclose($socket);
												//}
											}
											else
											{
												echo ("<span id='status' class='label label-danger'>Offline</span>");
											}

											?>

											</td>
											 <td style="position:relative;"><a class="gateway_heart" id="encheart_<?php echo $gateway['id'];?>" href="javascript:void(0);"><i class="fa fa-heartbeat" aria-hidden="true"></i></a>
			                            <?php
																		if($gateway['status'] == 1)
																		{
																			$host = "http://".$gateway['encoder_ip'].":19999";
										$url = $host."/api/v1/charts";
										$ch = curl_init();
									    $headers = array(
									    'Content-Type: application/json'
									    );
									    curl_setopt($ch, CURLOPT_URL, $url);
									    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
									    curl_setopt($ch, CURLOPT_HEADER, 0);
									    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
									    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
									    curl_setopt($ch, CURLOPT_TIMEOUT, 2);
									    $result = curl_exec($ch);
									    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);


										if($httpcode == 200)
										{

									?>

	                     <div class="box-body" style="display:none;position: absolute;top: -117px;min-width: 500px;/*! left: 0; */border: 1px solid;background: #3C8DBC;padding: 0;min-height: 131px;right: -274%;">
	                        <div style="width: 100%; max-height: calc(100% - 15px); text-align: center; display: inline-block;">
						            <div style="width: 100%; height:100%; align: center; display: inline-block;">
	              					  <br/>
						                <div class="netdata-container-gauge" style="margin-right: 10px; width: 32%; will-change: transform;" data-netdata="system.cpu"  data-host="<?php echo $host;?>" data-chart-library="gauge" data-title="CPU" data-units="%" data-gauge-max-value="100" data-width="32%" data-after="-420" data-points="420" data-colors="#22AA99" role="application"></div>
						                <div class="netdata-container-easypiechart" style="margin-right: 10px; width: 17%; will-change: transform;" data-netdata="system.net" data-host="<?php echo $host;?>" data-dimensions="received" data-chart-library="easypiechart" data-title="Net Inbound" data-width="17%" data-before="0" data-after="-420" data-points="420" data-common-units="system.net.mainhead" role="application"></div>
						                <div class="netdata-container-easypiechart" style="margin-right: 10px; width: 15%; will-change: transform;" data-netdata="system.net" data-host="<?php echo $host;?>" data-dimensions="sent" data-chart-library="easypiechart" data-title="Net Outbound" data-width="15%" data-before="0" data-after="-420" data-points="420" data-common-units="system.net.mainhead" role="application"></div>
						                <div class="netdata-container-easypiechart" style="margin-right: 10px; width: 12%; will-change: transform;" data-netdata="system.ram" data-host="<?php echo $host;?>" data-dimensions="used|buffers|active|wired" data-append-options="percentage" data-chart-library="easypiechart" data-title="Used RAM" data-units="%" data-easypiechart-max-value="100" data-width="12%" data-after="-420" data-points="420" data-colors="#EE9911" role="application">

						                </div>
	           						 </div>
						          </div>
	                    		 </div>
									<?php
										}
										else
										{
											?>

					                     <div class="box-body" style="display:none;position: absolute; top:-34px; min-width: 211px; border: 1px solid; background: rgb(60, 141, 188) none repeat scroll 0% 0%; padding: 0px; min-height: 50px; right: -169%;">
					                        <div class="row">
					                           <div class="col-xs-6 col-md-12 text-center">
					                              <h1 style="margin:0;font-size:25px;margin-top:10px;">No Data Found</h1>
					                           </div>
					                        </div>
					                     </div>
										<?php
										}
																		}
																		else
																		{
																			?>

					                     <div class="box-body" style="display:none;position: absolute; top:-34px; min-width: 211px; border: 1px solid; background: rgb(60, 141, 188) none repeat scroll 0% 0%; padding: 0px; min-height: 50px; right: -169%;">
					                        <div class="row">
					                           <div class="col-xs-6 col-md-12 text-center">
					                              <h1 style="margin:0;font-size:25px;margin-top:10px;">No Data Found</h1>
					                           </div>
					                        </div>
					                     </div>
										<?php
																		}
																		?>


			                            </td>
			                            <td><a href="#" class="gateway_refresh" id="encref_<?php echo $gateway['id'];?>" data-toggle="tooltip" title="Refresh" data-placement="bottom"><i class="fa fa-refresh" aria-hidden="true"></i></a></td>
			                            <td><a href="#" class="gateway_reboot" id="encreboot_<?php echo $gateway['id'];?>" data-toggle="tooltip" title="Reboot" data-placement="bottom"><i class="fa fa-repeat" aria-hidden="true"></i></a></td>

										<td><a data-toggle="tooltip" title="Delete" class="gatewayssdelete" id="del_<?php echo $gateway['id']?>" href="javascript:void(0);"><i class="fa fa-trash" aria-hidden="true"></i></a></td>

			                        </tr>
									<?php
									$gateway_count++;
								}
							}
							else
							{
							?>
							<tr>
								<td colspan="10">No Gateways Added Yet!</td>
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
							<div role="tabpanel" class="tab-pane" id="Encoding-Templates">
							 	<div class="card-body">
                                    <div class="row">
                                        <div class="col-12" style="padding: 0;">
                                       	    <div class="box-header">
                                                <!-- Single button -->
                                                <div class="btn-group">
													<select class="form-control actionsel" id="enctempactionval">
														<option value="">Action</option>
														<option value="Enable">Enable</option>
														<option value="Disable">Disable</option>
														<option value="Delete">Delete</option>
													</select>
                                                </div>

                                                <!-- Standard button -->
                                                 <button type="button" class="btn btn-default submit btn btn-primary" onclick="submitAllencodingTemplate('admin/encoderTemplateActions')";>Submit</button>
                                                <a style="float:right;" href="<?php echo site_url();?>createtemplate" class="add-btn btn btn-primary float-right">
                                                    <span><i class="fa fa-plus"></i> Preset</span>
                                                </a>

                                            </div>
                                            <br/>
											<div class="table-responsive">
                                                    <table class="table table-hover check-input encodingTable cstmtable">
                                                        <tr>
                                                            <th>
                                                            <div class="boxes">
                                                                <input type="checkbox" id="eTemplateall">
                                                                <label for="eTemplateall"></label>
                                                            </div>
                                                            </th>
                                                            <th>ID</th>
                                                            <th>Name</th>
                                                             <th>Group Name</th>
                                                            <th>Video Encoding</th>
                                                            <th>Audio Encoding</th>
                                                            <th>Status</th>
                                                            <th> &nbsp; </th>
                                                            <th> &nbsp; </th>
                                                        </tr>
                                                        <?php
                                                        $templateCounter =1;
                                                        if(sizeof($encoderTemplates)>0)
                                                        {
															foreach($encoderTemplates as $template)
															{
																?>
															<tr id="row_<?php echo $template['id'];?>">
                                                            <td>
                                                                <div class="boxes">
                                                                    <input class="encodingTemplates" type="checkbox" id="templateAction_<?php echo $template['id'];?>">
                                                                    <label for="templateAction_<?php echo $template['id'];?>"></label>
                                                                </div>
                                                            </td>
                                                            <td><?php echo $templateCounter;?></td>
                                                            <td><a href="<?php echo site_url();?>updateencodingtemplate/<?php echo $template['id'];?>"><?php echo $template['template_name'];?></a></td>
                                                             <td>
															<?php
															if($template['group_id'] > 0)
															{
																$groupName = $this->common_model->getGroupInfobyId($template['group_id']);
																echo $groupName[0]['group_name'];
															}
															else
															{
																echo "NA";
															}
															?>
														</td>
                                                            <td>
                                                                <table style="border: solid transparent;">
                                                                    <tr>
                                                                        <td style="padding: 0 6px;text-align: center;">
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
                                                                            <span class="text-blue">Bitrate
                                                                            </span>
                                                                            <p><?php echo $template['video_bitrate'];?> kbps</p>
                                                                        </td>
                                                                        <td style="padding: 0 6px;text-align: center;">
                                                                            <span class="text-blue">FPS
                                                                            </span>
                                                                            <p><?php echo $template['video_framerate'];?></p>
                                                                        </td>
                                                                        <td style="padding: 0 6px;text-align: center;">
                                                                            <span class="text-blue">Preset
                                                                            </span>
                                                                            <p><?php echo $template['adv_video_preset'];?></p>
                                                                        </td>
                                                                        <td style="padding: 0 6px;text-align: center;">
                                                                            <span class="text-blue">Profile
                                                                            </span>
                                                                            <p><?php echo $template['adv_video_profile'];?></p>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td>
                                                                <table style="border: solid transparent;">
                                                                    <tr>
                                                                        <td style="padding: 0 6px;text-align: center;">
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
                                                                            <span class="text-blue">Bitrate
                                                                            </span>
                                                                            <p><?php echo $template['audio_bitrate'];?> kbps</p>
                                                                        </td>
                                                                        <td style="padding: 0 6px;text-align: center;">
                                                                            <span class="text-blue">S.R.
                                                                            </span>
                                                                            <p><?php echo $template['audio_sample_rate'];?> Hz</p>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td>
                                                            <?php
                                                            if( $template['status'] == 0)
                                                            {
																?>
																<span id="status" class="label label-danger">Disabled</span>
																<?php
															}
															elseif( $template['status'] == 1)
                                                            {
																?>
																<span id="status" class="label label-success">Enabled</span>
																<?php
															}
                                                            ?>
                                                            </td>
                                                            <td><a id="<?php echo $template['id'];?>" href="javascript:void(0);" data-toggle="tooltip" title="Enable/Disable" data-placement="bottom" class="enbdisb">
                                                             <?php
                                                            if( $template['status'] == 0)
                                                            {
																?>
																<i class="fa fa-ban" aria-hidden="true"></i>
																<?php
															}
															elseif( $template['status'] == 1)
                                                            {
																?>
																<i class="fa fa-check-circle" aria-hidden="true"></i>
																<?php
															}
                                                            ?>
                                                            </a></td>
                                                            <td><a data-toggle="tooltip" title="Remove" data-placement="bottom" href="javascript:void(0);" class="deleteEncodingTempate" id="<?php echo $template['id'];?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
                                                        </tr>
																<?php
																$templateCounter++;
															}
														}
														else
														{
															?>
																<tr>
																	<td colspan="9">No Encoding Presets Added Yet!</td>
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
							<div role="tabpanel" class="tab-pane" id="nebula">

								<div class="card-body">
								    <div class="row">
								        <div class="col-12" style="padding: 0;">
								            <div class="box-header">
								 <!-- Single button -->
								<div class="btn-group">

								<select class="form-control actionsel " id="actionNebula">
								<option value="">Action</option>
								<option value="Refresh">Refresh</option>
								<option value="TakeOffline">Take Offline</option>
								<option value="BringOnline">Bring Online</option>
								<option value="Reboot">Reboot</option>
								<option value="Delete">Delete</option>
								</select>


								</div>
								<!-- Standard button -->
								<button type="button" class="btn btn-primary submit" onclick="submitAllnebula()";>Submit</button>

								<a  href="<?php echo site_url();?>createnebula" class="btn btn-primary add-btn float-right">
								    <span><i class="fa fa-plus"></i> Nebula</span>
								</a>
								</div>
								<br/>
								<div class="table-responsive no-padding" >
								    <table class="table table-hover check-input cstmtable nebulaTable">
								        <tr>
								            <th>
								                <div class="boxes">
								                    <input type="checkbox" id="selectallnebula">
								                    <label for="selectallnebula"></label>
								                </div>
								            </th>
								            <th>ID</th>
								            <th>Name</th>
								            <th>Group Name</th>
								            <th>IP Address</th>

								            <th>Uptime</th>
								            <th>Status</th>
								            <th> &nbsp; </th>
								            <th> &nbsp; </th>
								            <th> &nbsp; </th>
								            <th> &nbsp; </th>
								        </tr>

								          <?php
								          if(sizeof($nebula)>0)
								          {
								            $nebula_count=1;
								foreach($nebula as $nebula)
								{
								  ?>
								  <tr id="row_<?php echo $nebula['id'];?>">
								    <td>
								                      <div class="boxes">
								                          <input type="checkbox" name="appids[]" class="nebulaGrp" id="del_<?php echo $nebula['id'];?>" value="<?php echo $nebula['id'];?>">
								                          <label for="del_<?php echo $nebula['id'];?>"></label>
								                      </div>
								                  </td>
								                  <td><?php echo $nebula_count;?></td>
								                  <td><a id="<?php echo $nebula['id'];?>" class="enciid" href="<?php echo site_url();?>editnebula/<?php echo $nebula['id'];?>"><?php echo $nebula['encoder_name'];?></a> </td>
								                  <td>
								      <?php
								      if($nebula['encoder_group'] > 0)
								      {
								        $groupName = $this->common_model->getGroupInfobyId($nebula['encoder_group']);
								        echo $groupName[0]['group_name'];
								      }
								      else
								      {
								        echo "NA";
								      }
								      ?>
								    </td>
								                  <td><?php echo $nebula['encoder_ip'];?></td>

								                  <td class="uptime">
								                  <?php
								                    if($nebula['status'] == 1)
								      {
								        if($nebula['uptime'] != "")
								        {
								          echo $nebula['uptime'];
								        }
								        else
								        {
								          echo 'NA';
								        }
								      }
								      else
								      {
								        echo 'NA';
								      }
								     ?></td>
								                  <td>
								                  <?php
								                    if($nebula['status'] == 1)
								      {
								        $ip= $nebula['encoder_ip'];
								        //if (!$socket = @fsockopen("$ip", 22, $errno, $errstr, 2))
								        //{
								        //  echo ("<span id='status' class='label label-danger'>Dead</span>");
								        //}
								      //	else
								        //{
								          echo("<span id='status' class='label label-success'>Online</span>");
								        //  fclose($socket);
								        //}
								      }
								      else
								      {
								        echo ("<span id='status' class='label label-danger'>Offline</span>");
								      }

								      ?>

								      </td>
								       <td style="position:relative;"><a class="nebula_heart" id="encheart_<?php echo $nebula['id'];?>" href="javascript:void(0);"><i class="fa fa-heartbeat" aria-hidden="true"></i></a>
								                  <?php
								                    if($nebula['status'] == 1)
								                    {
								                      $host = "http://".$nebula['encoder_ip'].":19999";
								    $url = $host."/api/v1/charts";
								    $ch = curl_init();
								      $headers = array(
								      'Content-Type: application/json'
								      );
								      curl_setopt($ch, CURLOPT_URL, $url);
								      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
								      curl_setopt($ch, CURLOPT_HEADER, 0);
								      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
								      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
								      curl_setopt($ch, CURLOPT_TIMEOUT, 2);
								      $result = curl_exec($ch);
								      $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);


								    if($httpcode == 200)
								    {

								  ?>

								       <div class="box-body" style="display:none;position: absolute;top: -117px;min-width: 500px;/*! left: 0; */border: 1px solid;background: #3C8DBC;padding: 0;min-height: 131px;right: -274%;">
								          <div style="width: 100%; max-height: calc(100% - 15px); text-align: center; display: inline-block;">
								        <div style="width: 100%; height:100%; align: center; display: inline-block;">
								            <br/>
								            <div class="netdata-container-gauge" style="margin-right: 10px; width: 32%; will-change: transform;" data-netdata="system.cpu"  data-host="<?php echo $host;?>" data-chart-library="gauge" data-title="CPU" data-units="%" data-gauge-max-value="100" data-width="32%" data-after="-420" data-points="420" data-colors="#22AA99" role="application"></div>
								            <div class="netdata-container-easypiechart" style="margin-right: 10px; width: 17%; will-change: transform;" data-netdata="system.net" data-host="<?php echo $host;?>" data-dimensions="received" data-chart-library="easypiechart" data-title="Net Inbound" data-width="17%" data-before="0" data-after="-420" data-points="420" data-common-units="system.net.mainhead" role="application"></div>
								            <div class="netdata-container-easypiechart" style="margin-right: 10px; width: 15%; will-change: transform;" data-netdata="system.net" data-host="<?php echo $host;?>" data-dimensions="sent" data-chart-library="easypiechart" data-title="Net Outbound" data-width="15%" data-before="0" data-after="-420" data-points="420" data-common-units="system.net.mainhead" role="application"></div>
								            <div class="netdata-container-easypiechart" style="margin-right: 10px; width: 12%; will-change: transform;" data-netdata="system.ram" data-host="<?php echo $host;?>" data-dimensions="used|buffers|active|wired" data-append-options="percentage" data-chart-library="easypiechart" data-title="Used RAM" data-units="%" data-easypiechart-max-value="100" data-width="12%" data-after="-420" data-points="420" data-colors="#EE9911" role="application">

								            </div>
								         </div>
								      </div>
								           </div>
								  <?php
								    }
								    else
								    {
								      ?>

								               <div class="box-body" style="display:none;position: absolute; top:-34px; min-width: 211px; border: 1px solid; background: rgb(60, 141, 188) none repeat scroll 0% 0%; padding: 0px; min-height: 50px; right: -169%;">
								                  <div class="row">
								                     <div class="col-xs-6 col-md-12 text-center">
								                        <h1 style="margin:0;font-size:25px;margin-top:10px;">No Data Found</h1>
								                     </div>
								                  </div>
								               </div>
								    <?php
								    }
								                    }
								                    else
								                    {
								                      ?>

								               <div class="box-body" style="display:none;position: absolute; top:-34px; min-width: 211px; border: 1px solid; background: rgb(60, 141, 188) none repeat scroll 0% 0%; padding: 0px; min-height: 50px; right: -169%;">
								                  <div class="row">
								                     <div class="col-xs-6 col-md-12 text-center">
								                        <h1 style="margin:0;font-size:25px;margin-top:10px;">No Data Found</h1>
								                     </div>
								                  </div>
								               </div>
								    <?php
								                    }
								                    ?>


								                  </td>
								                  <td><a href="#" class="nebula_refresh" id="encref_<?php echo $nebula['id'];?>" data-toggle="tooltip" title="Refresh" data-placement="bottom"><i class="fa fa-refresh" aria-hidden="true"></i></a></td>
								                  <td><a href="#" class="nebula_reboot" id="encreboot_<?php echo $nebula['id'];?>" data-toggle="tooltip" title="Reboot" data-placement="bottom"><i class="fa fa-repeat" aria-hidden="true"></i></a></td>

								    <td><a data-toggle="tooltip" title="Delete" class="nebuladelete" id="del_<?php echo $nebula['id']?>" href="javascript:void(0);"><i class="fa fa-trash" aria-hidden="true"></i></a></td>

								              </tr>
								  <?php
								  $nebula_count++;
								}
								}
								else
								{
								?>
								<tr>
								<td colspan="10">No Nebula Added Yet!</td>
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
			</div>

        </div>
        </div>
</main>
