<style>
	
	.not-active {
	pointer-events: none;
	cursor: default;
	text-decoration:none;
	color:black;
	}
	
	
</style>
<?php //echo "<pre>";
	
	//print_r($targets);die;
	
?>
<?php $this->load->view('groupuser/navigation.php');?>
<?php $this->load->view('groupuser/leftsidebar.php');?>



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
													<div class="btn-group">
														<!----<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Action <i class="fa fa-angle-down" aria-hidden="true"></i>                                                                
															</button>
															<ul class="dropdown-menu">
															<li><a href="#">Refresh</a></li>
															<li><a href="#">Reboot</a></li>
															<li><a href="#">Take Offline</a></li>
															<li role="separator" class="divider"></li>
															<li><a href="#">Delete</a></li>
														</ul>------>
														<select class="selectpicker" id="grp_user_mutiple_app_id">
															
															<option value ="" hidden>Action</option>
															<option value ="Refresh">Refresh</option>
															<option value ="Reboot">Reboot</option>
															<option value ="Take Offline">Take Offline</option>
															<option value ="applicationdelete1">Delete</option>
														</select>
													</div>
													<button type="button" class="btn btn-default submit" onclick="actionPerform('<?php echo _GROUPUSER_;?>','<?php echo _GRP_USER_APPLICATION_TAB;?>','grp_user_mutiple_app_id');">Submit</button>
													
													<?php 
														$userdata =$this->session->userdata('user_data');
														//echo "<pre>";
														//print_r($userdata);die;
														$checkstatus = $this->common_model->checkWowzaStatus($userdata['userid']);
														//echo "<pre>";
														//print_r($checkstatus->create_user);die;
														if($checkstatus->create_application == 0){
														?>
														
														<a href="<?php echo site_url();?>groupuser/createapplication" class="add-btn not-active">
															<span> <i class="fa fa-plus"></i>
																
															Live </span>
														</a>
														<?php
														}
														else
														{
														?>
														<a href="<?php echo site_url();?>groupuser/createapplication" class="add-btn">
															<span> <i class="fa fa-plus"></i>
																
															Live </span>
														</a>
														<?php
															
														}
													?>
													<a href="<?php echo site_url();?>groupuser/createvod" class="add-btn">
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
																		if($checkstatus->delete_application == 0)
																		{
																		?>
																		<th><div class="boxes"><input type="checkbox" class="checkAll" value="grp_user_app_chk_class" disabled></div>
																		</th>
																		
																		<?php
																		}
																		else
																		{
																		?>
																		
																		<th><div class="boxes"><input type="checkbox" class="checkAll" value="grp_user_app_chk_class"></div>
																		</th>
																		
																		<?php
																			
																		}
																	?>
																	
																	<!-----<th>ID</th>-->
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
																			
																			$wowza = $this->common_model->getWowzabyID($application['live_source']);
																		?>
																		<tr>
																			<?php $userdata =$this->session->userdata('user_data');
																				
																				$checkstatus = $this->common_model->checkWowzaStatus($userdata['userid']);
																				//echo "<pre>";
																				//print_r($checkstatus->create_user);die;
																				if($checkstatus->delete_application == 0)
																				{
																				?>
																				
																				<td><input type="checkbox"  name="appids[]" class="grp_user_app_chk_class" value ="<?php echo $application['id']?>" disabled></td>
																				
																				<?php
																				}
																				else
																				{
																				?>
																				<td><input type="checkbox"  name="appids[]" class="grp_user_app_chk_class" value ="<?php echo $application['id']?>"></td>
																				
																				<?php
																				}
																				
																			?>
																			
																			
																			
																			<td><a href="<?php echo site_url();?>groupuser/updateapp/<?php echo $application['id'];?>"><?php echo $application['application_name'];?></a></td>
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
																				<a class="applicationdelete1" id="del_<?php echo $application['id']?>/uid_<?php echo $application['uid'];?>" href="javascript:void(0);"><i class="fa fa-trash"></i></a>
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
													<div class="btn-group">
														<!----<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Action <i class="fa fa-angle-down" aria-hidden="true"></i>                                                                
															</button>
															<ul class="dropdown-menu">
															<li><a href="#">Refresh</a></li>
															<li><a href="#">Reboot</a></li>
															<li><a href="#">Take Offline</a></li>
															<li role="separator" class="divider"></li>
															<li><a href="#">Delete</a></li>
														</ul>--->
														<select class="selectpicker" id="grp_user_mutiple_target_id">
															<option value="" hidden>Action</option>
															<option value="Refresh">Refresh</option>
															<option value="Reboot">Reboot</option>
															<option value="Take Offline">Take Offline</option>
															<option value="targetdelete1">Delete</option>
														</select>
													</div>
													<button type="button" class="btn btn-default submit" onclick="actionPerform('<?php echo _GROUPUSER_;?>','<?php echo _GRP_USER_TARGET_TAB;?>','grp_user_mutiple_target_id');">Submit</button>
													<a href="<?php echo site_url();?>groupuser/createtarget" class="add-btn">
														<span><i class="fa fa-plus"></i>
															<i class="fa fa-crosshairs"></i>
														Add Target</span>
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
																		if($checkstatus->delete_target == 0)
																		{
																		?>
																		
																		<th><div class="boxes"><input type="checkbox" class="checkAll" value="grp_user_target_chk_class" disabled></div>
																		</th>
																		
																		<?php
																		}
																		else
																		{
																		?>
																		
																		<th><div class="boxes"><input type="checkbox" class="checkAll" value="grp_user_target_chk_class"></div>
																		</th>
																		<?php 
																			
																		}
																	?>
																	
																	
																	<th>Target Name</th>
																	<th>Application Name</th>
																	<th>Status</th>   
																	<th>Stream URL</th>
																	<th>Video Streams</th>
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
																			
																			<?php $userdata =$this->session->userdata('user_data');
																				
																				$checkstatus = $this->common_model->checkWowzaStatus($userdata['userid']);
																				//echo "<pre>";
																				//print_r($checkstatus->create_user);die;
																				if($checkstatus->delete_target == 0)
																				{
																				?>
																				<td><input type="checkbox" name="appids[]" class="grp_user_target_chk_class" value ="<?php echo $target['id']?>" disabled></td>
																				
																				<?php
																					
																				}
																				else
																				{
																				?>
																				
																				<td><input type="checkbox" name="appids[]" class="grp_user_target_chk_class" value ="<?php echo $target['id']?>"></td>	
																				<?php		
																				}
																			?>
																			
																			
																			<td><?php echo $target['target_name'];?></td>
																			<td><?php echo $app[0]['application_name'];?></td>
																			<td><button class="btn btn-green btn-xs">Online</button></td>
																			<td><?php echo $target['streamurl'];?></td>
																			<td><video width="100%" height="100" controls style="border:1px solid;" src="<?php echo $target['streamurl'];?>"></video></td>
																			<td>
																			<a class="targetfresh" id="tarfresh_<?php echo $target['id']?>" href="javascript:void(0);"><i class="fa fa-refresh"></i></a>
																			</td>
																			<td>
																			<a class="targcopy" id="targcopy_<?php echo $target['id']?>" href="javascript:void(0);"><i class="fa fa-copy"></i></a>
																			</td>
																			
																			<td><a class="targenbdib" id="targenbdib_<?php echo $target['id']?>" href="javascript:void(0);"><i class="fa fa-play"></i></a>
																			</td>
																			<td>
																			<a class="targetdeluser" id="targdel_<?php echo $target['id']?>" href="javascript:void(0);"><i class="fa fa-trash"></i></a>
																			</td>
																			
																			</tr>
																			<?php	
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
																			
																																				