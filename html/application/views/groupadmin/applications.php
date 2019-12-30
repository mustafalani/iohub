<?php $this->load->view('groupadmin/navigation.php');?>
<?php $this->load->view('groupadmin/leftsidebar.php');?>
<style>
	
	.not-active {
	pointer-events: none;
	cursor: default;
	text-decoration:none;
	color:black;
	}
	
	
</style>
<section class="content-wrapper">
	<!-- ========= Main Content Start ========= -->
	<div class="content">
		<div class="content-container">
			<div class="row">
				<div class="col-lg-12 col-12-12">
					<div class="content-box config-contentonly">
						<div class="config-container">
							<div class="tab-btn-container">
								<ul class="nav nav-tabs" role="tablist">
									<li class="active"><a data-toggle="tab" href="#apps">Applications</a></li>
									<li><a data-toggle="tab" href="#apps_tar">Targets</a></li>
								</ul>
							</div>
							<div class="tab-content">
								<div id="apps" class="tab-pane fade in active">
									<div class="action-table">
										<div class="row">
											<div class="col-xs-12">
												<div class="box-header">
													<!-------<div class="btn-group">
														<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Action <i class="fa fa-angle-down" aria-hidden="true"></i>                                                                
														</button>
														<ul class="dropdown-menu">
														<li><a href="#">Refresh</a></li>
														<li><a href="#">Reboot</a></li>
														<li><a href="#">Take Offline</a></li>
														<li role="separator" class="divider"></li>
														<li><a href="#">Delete</a></li>
														</ul>
													</div>--->
													<select class="selectpicker" id="grp_admin_select_id">
														<option value="" hidden>Action</option>
														<option value ="Refresh">Refresh</option>
														<option value ="Reboot">Reboot</option>
														<option value ="Take Offline">Take Offline</option>
														<option value ="applicationdelete1">Delete</option>
													</select>
													
													
													
													<button type="button" class="btn btn-default submit" onclick="actionPerform('<?php echo _GROUPADMIN_;?>','<?php echo _GRP_ADMIN_APPLICATION_TAB;?>','grp_admin_select_id');">Submit</button>
													
													<a href="<?php echo site_url();?>groupadmin/createapplication" class="add-btn">
														<span> <i class="fa fa-plus"></i>
															
														Live </span>
													</a>
													<a href="<?php echo site_url();?>groupadmin/createvod" class="add-btn">
														<span> <i class="fa fa-plus"></i>
															
														VOD </span>
													</a>
												</div>
												<div class="box">
													<div class="box-body table-responsive no-padding">
														<table class="table table-hover check-input">
															<tbody>
																<tr>
																	<?php $userdata =$this->session->userdata('user_data');
																		
																		$checkstatus = $this->common_model->checkWowzaStatus($userdata['userid']);
																		//echo "<pre>";
																		//print_r($checkstatus->create_user);die;
																		if($checkstatus->delete_application == 0){
																		?>
																		
																		<th><div class="boxes"><input type="checkbox" id="checkAll" disabled value="grp_admin_chk_class" ></div></th>
																		<?php
																		}
																		else
																		{
																		?>
																		
																		<th><div class="boxes"><input type="checkbox" id="checkAll" value="grp_admin_chk_class" ></div></th>
																		<?php 
																		}
																	?>
																	
																	<!----<th>ID</th>--->
																	<th>Application Name</th>
																	<th>Live Source</th>
																	<th>Stream Target</th>
																	<th>Status</th>
																	
																	<th>Stream URL</th>
																	
																	<th></th>
																	<th></th>
																	<th></th>
																	<th></th>
																</tr>
																<?php
																	if(sizeof($applications)>0)
																	{
																		$counter =1;
																		foreach($applications as $application)
																		{
																			//echo "<pre>";
																			//print_r($application);
																			$wowza = $this->common_model->getWowzabyID($application['live_source']);
																		?>
																		<tr>
																			
																			<td>	
																				<?php $userdata =$this->session->userdata('user_data');
																					
																					$checkstatus = $this->common_model->checkWowzaStatus($userdata['userid']);
																					//echo "<pre>";
																					//print_r($checkstatus->create_user);die;
																					if($checkstatus->delete_application == 0){
																					?>
																					<div class = "tool-tip-hover tool-tip-hover1 " style="float:right;">
																						<input type="checkbox"  name="appids[]" disabled class="grp_admin_chk_class" value ="<?php echo $application['id']?>">
																					</div>
																					<?php
																					}
																					else{
																					?>
																					<input type="checkbox"  name="appids[]" class="grp_admin_chk_class" value ="<?php echo $application['id']?>">
																					<?php
																						
																					}
																				?> 
																				
																			</td>		
																			
																			
																			<!----<td><?php echo $counter;?></td>--->
																			
																			<td><a href="<?php echo site_url();?>groupadmin/updateapp/<?php echo $application['id'];?>"><?php echo $application['application_name'];?></a></td>
																			<td><?php echo $wowza[0]['wse_instance_name'];?></td>
																			<td><strong>2</strong> See Targets<br><i class="fa fa-plus"></i> Add Target</td>
																			<td><button class="btn btn-green btn-xs">Online</button></td>
																			
																			<td><?php echo $application['wowza_path'];?></td>
																			
																			<td>
																				<a class="appsfresh" id="ref_<?php echo $application['id']?>" href="javascript:void(0);"><i class="fa fa-refresh"></i></a>
																			</td>
																			<td>
																				<a class="appscopy" id="copy_<?php echo $application['id']?>" href="javascript:void(0);"><i class="fa fa-copy"></i></a>
																			</td>
																			
																			<td><a href="javascript:void(0);"><i class="fa fa-unlock"></i></a></td>
																			<td>
																				<a class="applicationdelete2" id="del_<?php echo $application['id']?>/uid_<?php echo $application['uid'];?>" href="javascript:void(0);"><i class="fa fa-trash"></i></a>
																			</td>
																		</tr>
																		<?php
																		}
																	}
																	else
																	{
																	?>
																	<tr>
																		<td colspan="7">No Application Created Yet!</td>
																	</tr>
																	<?php	
																	}
																?>
															</tbody>
														</table>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div id="apps_tar" class="tab-pane fade">
									<div class="action-table">
										<div class="row">
											<div class="col-xs-12">
												<div class="box-header">
													<!----<div class="btn-group">
														<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
														Action <i class="fa fa-angle-down" aria-hidden="true"></i>                                                                
														</button>
														<ul class="dropdown-menu">
														<li><a href="#">Refresh</a></li>
														<li><a href="#">Reboot</a></li>
														<li><a href="#">Take Offline</a></li>
														<li role="separator" class="divider"></li>
														<li><a href="#">Delete</a></li>
														</ul>
													</div>----->
													<select class="selectpicker" id = "grp_admin_select_target_id">
														<option value ="" hidden >Action</option>
														<option value ="Refresh">Refresh</option>
														<option value ="Reboot">Reboot</option>
														<option value ="Take Offline">Take Offline</option>
														<option value ="groupadmintargetdelete">Delete</option>
													</select>
													
													
													<?php $userdata =$this->session->userdata('user_data');
														
														$checkstatus = $this->common_model->checkWowzaStatus($userdata['userid']);
														
														if($checkstatus->create_target == 0)
														{
														?>
														
														<button type="button" class="btn btn-default submit" onclick="actionPerform('<?php echo _GROUPADMIN_;?>','<?php echo _GRP_ADMIN_TARGET_TAB;?>','grp_admin_select_target_id');" >Submit</button>
														<a href="<?php echo site_url();?>groupadmin/createtarget" class="add-btn">
															<span><i class="fa fa-plus"></i>
																<i class="fa fa-crosshairs"></i>
															Add Target</span>
															<?php 	
															}
															
															else
															{
															?>
															<button type="button" class="btn btn-default submit" onclick="actionPerform('<?php echo _GROUPADMIN_;?>','<?php echo _GRP_ADMIN_TARGET_TAB;?>','grp_admin_select_target_id');">Submit</button>
															<a href="<?php echo site_url();?>groupadmin/createtarget" class="add-btn">
																<span><i class="fa fa-plus"></i>
																	<i class="fa fa-crosshairs"></i>
																Add Target</span>
																<?php
																}
															?>
															
															
															
														</a>                                     
													</div>
													<div class="box">
														<div class="box-body table-responsive no-padding">
															<table class="table table-hover">
																<tbody>
																	<tr>
																		<th><div>
																			
																			
																			<?php $userdata =$this->session->userdata('user_data');
																				
																				$checkstatus = $this->common_model->checkWowzaStatus($userdata['userid']);
																				//echo "<pre>";
																				//print_r($checkstatus->create_user);die;
																				if($checkstatus->delete_target == 0){
																				?>
																				<input type="checkbox" id ="checkAlltar" value="grp_admin_chk_class" disabled>
																				<label></label>
																				
																				<?php
																				}
																				else
																				{
																				?>
																				
																				<input type="checkbox" id ="checkAlltar" value="grp_admin_chk_class">
																				<label></label>
																				
																				<?php
																				}
																			?>
																			
																			
																		</div></th>
																		<!-----<th>ID</th>--->
																		<th>Target Name</th>
																		<th>Application Name</th>
																		<th>Status</th>   
																		<th>Stream URL</th>  
																		<th></th>
																		<th></th>
																		<th></th>
																		<th></th>
																	</tr>
																	<?php
																		if(sizeof($targets)>0)
																		{
																			$counter1 =1;
																			foreach($targets as $target)
																			{
																				
																				$app = $this->common_model->getApplicationbyId($target['wowzaengin']);
																			?>
																			<tr>
																				<td><div class="boxes">
																					
																					<?php $userdata =$this->session->userdata('user_data');
																						
																						$checkstatus = $this->common_model->checkWowzaStatus($userdata['userid']);
																						//echo "<pre>";
																						//print_r($checkstatus->create_user);die;
																						if($checkstatus->delete_target == 0)
																						{
																						?>
																						<input type="checkbox" name="appids[]" class="grp_admin_chk_class" value ="<?php echo $target['id']?>" disabled>
																						<label ></label>
																						<?php
																						}
																						else
																						{
																						?>
																						<input type="checkbox" name="appids[]" class="grp_admin_chk_class" value ="<?php echo $target['id']?>">
																						<label ></label>
																						
																						<?php
																						}
																					?>
																					
																					
																				</div></td>
																				<!-----<td><?php echo $counter1;?></td>----->
																				<td><?php echo $target['target_name'];?></td>
																				<td><?php echo $app[0]['application_name'];?></td>
																				<td><button class="btn btn-green btn-xs">Online</button></td>
																				<td><?php echo $target['streamurl'];?></td>
																				
																				<td>
																					<a class="targetfresh" id="tarfresh_<?php echo $target['id']?>" href="javascript:void(0);"><i class="fa fa-refresh"></i></a>
																				</td>
																				<td>
																					<a class="targcopy" id="targcopy_<?php echo $target['id']?>" href="javascript:void(0);"><i class="fa fa-copy"></i></a>
																				</td>
																				
																				<td><a class="targenbdib" id="targenbdib_<?php echo $target['id']?>" href="javascript:void(0);"><i class="fa fa-play"></i></a>
																				</td>
																				<td>
																					<a class="groupadmintargdel" id="targdel_<?php echo $target['id']?>/uid_<?php echo $target['uid'] ?>" href="javascript:void(0);"><i class="fa fa-trash"></i></a>
																				</td>
																				
																			</tr>
																			<?php	
																				$counter1++;
																			}
																		}
																		else
																		{
																		?>
																		<tr>
																			<td colspan="10">No Target Created Yet!</td>
																		</tr>
																		<?php	
																		}
																	?>
																</tbody>
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
	</section>
	<style>
		.check-input input[type="checkbox"] {
		display: block;
		
	</style>
