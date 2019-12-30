<style>	
	.not-active {
	pointer-events: none;
	cursor: default;
	text-decoration:none;
	color:black;
	}
</style>
<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<section class="content-wrapper">
	<!-- ========= Main Content Start ========= -->
	<div class="content">
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
		<div class="content-container">
			<div class="row">
				<div class="col-lg-12 col-12-12">
					<div class="content-box config-contentonly">
						<div class="config-container">							
							<div class="tab-content">
								<div id="system" class="tab-pane fade in active system2">
									<div class="action-table">
										<div class="row">
											<div class="col-xs-12">
												
												<div class="box-header">
													<div class="btn-group">														
														<ul class="dropdown-menu">
															<li><a href="#">Refresh</a></li>
															<li><a href="#">Reboot</a></li>
															<li><a href="#">Take Offline</a></li>
															<li role="separator" class="divider"></li>
															<li><a href="#">Delete</a></li>
														</ul>
													</div>													
												</div>												
												<div class="box">
													<div class="box-body table-responsive no-padding">
														<table class="table table-hover check-input">
															<tbody>
																<tr>
																	<th><input type="checkbox" name=""></th>
															
																	<th>Name</th>
																	<th>E-mail Address</th>
																	<th>Role</th>
																	<th>Status</th>	
																</tr>
																<?php
																	if(sizeof($groupsUsers)>0)
																	{
																		$counter =1;
																		foreach($groupsUsers as $group)
																		{
																			$Id = $group['id'];	
																			$img = $this->common_model->getUsersImage($Id);		
																		?>
																		<tr>
																			<td><input type="checkbox" name="actions"></td>
																			
																			<td><img width="20px" height="20px" src="<?php echo site_url();?>public/site/main/group_pics/<?php echo isset($img[0]['name'])?$img[0]['name']:"";?>"/><a id="<?php echo $group['id']?>" href="<?php echo site_url();?>updateuser/<?php echo $group['id']?>"><?php echo $group['fname'].' '.$group['lname']?></a></td>
																			
																			<td><?php echo isset($group['email_id'])?$group['email_id']:"";?></td>
																			<td><?php if(!empty($group['role_id'])){
																				if($group['role_id'] == 1){
																				
																					echo "Admin";
																				}
																				elseif($group['role_id'] == 2){
																				
																					echo "GroupAdmin";
																				}
																				elseif($group['role_id'] == 3){
																				
																					echo "User";
																				}
																			}
																			?>
																			</td>
																			<td>
																				<span class="label label-success">Active</span>
																			</td>
																		</tr>
																		<?php	
																			$counter++;
																		}
																	}
																	else
																	{
																		?>
																		<tr>
																			<td colspan="5">No Users Found</td>
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
								<div id="ftp2" class="tab-pane fade system2">
									<div class="action-table">
										<div class="row">
											<div class="col-xs-12">
												
												<div class="box-header">
													<div class="btn-group">
														<!----<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
															Action <i class="fa fa-angle-down" aria-hidden="true"></i>                                                                
														</button>---->
														<ul class="dropdown-menu">
															<li><a href="#">Refresh</a></li>
															<li><a href="#">Reboot</a></li>
															<li><a href="#">Take Offline</a></li>
															<li role="separator" class="divider"></li>
															<li><a href="#">Delete</a></li>
														</ul>
													</div>
													<!-----<button type="button" class="btn btn-default submit">Submit</button>----->
													
													<?php 
														
														$userdata =$this->session->userdata('user_data');
														//echo "<pre>";
														//print_r($userdata);die;
														$checkstatus = $this->common_model->checkWowzaStatus($userdata['userid']);
														//echo "<pre>";
														//print_r($checkstatus->create_user);die;
														if($checkstatus->create_user == 0){
														?>
														<a href="<?php echo site_url();?>admin/createuser" class="add-btn not-active">
															<span><i class="fa fa-plus"></i> New User</span>
														</a>
														<?php
															}else{
														?>
														<a href="<?php echo site_url();?>admin/createuser" class="add-btn">
															<span><i class="fa fa-plus"></i> New User</span>
														</a>
														<?php
														}
													?>
													
													
													
												</div>
												
												
												<div class="box">
													<div class="box-body table-responsive no-padding">
														<table class="table table-hover check-input">
															<tbody>
																<tr>
																	<th><input type="checkbox" name=""></th>
																	<th>ID</th>
																	<th>Name</th>
																	<th>Group</th>
																	<th>Role</th>
																	<th>E-mail Address</th>
																	<th>Status</th>
																</tr>
																<?php
																	if(sizeof($users)>0)
																	{
																		$counterU =1;
																		foreach($users as $usr)
																		{
																			$Id = $usr['id'];
																			$img1 = $this->common_model->getUserImage($Id);
																			
																			$groupname = $this->common_model->getGroupInfobyId($usr['group_id']);
																		?>
																		<tr>
																			<td><input type="checkbox" name=""></td>
																			<td><?php echo $counterU;?></td>
																			<td><img width="20px" height="20px" src="<?php echo site_url();?>public/site/main/group_pics/<?php echo $img1[0]['name'];?>"/><a id="<?php echo $usr['fname'].' '.$usr['lname'];?>" href="<?php echo site_url();?>/admin/updateuser/<?php echo $usr['id']?>"> <?php echo $usr['fname'].' '.$usr['lname'];?></td>
																				<td><?php echo $groupname[0]['group_name'];?></td>
																				
																				<td>
																					<?php $roles = $this->config->item('roles_id');
																						echo $roles[$usr['role_id']];
																					?>	
																				</td>
																				<td><?php echo $usr['email_id'];?></td>
																				<td>
																					<button class="btn btn-green btn-xs">Active</button>
																				</td>
																			</tr>
																			<?php	
																				$counterU++;
																			}
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
	
