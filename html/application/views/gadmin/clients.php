

<?php $this->load->view('gadmin/navigation.php');?>
<?php $this->load->view('gadmin/leftsidebar.php');?>

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
								<ul class="nav nav-tabs" role="tablist" id="clients">
									<li class="active"><a id="groups" data-toggle="tab" href="#system">Groups</a></li>
									<li><a id="users" data-toggle="tab" href="#ftp2">Users</a></li>
									<li><a id="permissions" data-toggle="tab" href="#ftp3">Permissions</a></li>
								</ul>
							</div>
							<div class="tab-content">
								<div id="system" class="tab-pane fade in system2 active">
									<div class="action-table">
										<div class="row">
											<div class="col-xs-12">
												
												<div class="box-header">
													<div class="btn-group">														
														<div class="custom-select">
														<select class="form-control actionsel" id="actionval">
															<option value ="" hidden>Action</option>
															<option value ="Block">Block</option>
															<option value ="Un-Block">Un-Block</option>
															<option value ="Delete">Delete</option>
														</select>
														</div>
													</div>
													<button type="button" class="btn btn-default submit" onclick="submitAllGroups('groupadmin/groupActions');">Submit</button>
													<a href="<?php echo site_url();?>groupadmin/creategroup" class="add-btn">
														<span><i class="fa fa-plus"></i> New Group</span>
													</a>
												</div>
												
												<div class="box">
													<div class="box-body table-responsive no-padding">
														
															<table class="table table-hover check-input groupTable">
																
																	<tr>
																		<th>
																		<input type="checkbox" class="checkbox" id="selecctallgroups">
																			<label for="selecctallgroups"></label>
																		</th>
																		<th>ID</th>
																		<th>Group Name</th>
																		<th>Address</th>
																		<th>E-mail Address</th>
																		<th>Status</th>
																	<th></th>
																	<th>Users</th>																	
																	<th>Login</th>
																	</tr>
																	<?php
																	
																		if(sizeof($groups)>0)
																		{
																			$counter =1;
																			foreach($groups as $group)
																			{
																				$Id = $group['id'];
																				$img = $this->common_model->getGgoupImage($Id);
																			?>
																			<tr>
																				
																				<td>
																				<input type="checkbox" name="appids[]" class="groupaction" id = "del_<?php echo $group['id']?>" value="<?php echo $group['id']?>"/>
																					<label for="del_<?php echo $group['id']?>"></label>
																				</td>
																				<td><?php echo $counter;?></td>
																				<td>
																				<?php
																				if(sizeof($img)>0)
																				{
																				?>
																				<img class="img-circle" src="<?php echo site_url();?>assets/site/main/group_pics/<?php echo $img[0]['name'];?>"/>
																				<?php	
																				}
																				else
																				{
																					?>
																				<img class="img-circle" src="<?php echo site_url();?>assets/site/main/images/dummy3.png"/>
																				<?php	
																				}
																				?>
																				<a id="<?php echo $group['group_name']?>" href="<?php echo site_url();?>/groupadmin/updategroup/<?php echo $group['id']?>"><?php echo $group['group_name']?></a></td>
																				
																				<td><?php echo $group['group_address'];?></td>
																				<td><?php echo $group['group_email'];?></td>
																				<td>
																					<span class="label label-success">Active</span>
																				</td>
																				<td>999 Days Remaining</td>
																				<!----<td><a href="javascript:void(0);">12 <br> Show all users</a></td>---->
																				<td><a href="<?php echo site_url();?>groupadmin/allgroupuser/<?php echo $group['id'];?>"><br> Show all users</a></td>																				
																				<td>
																					<button class="btn btn-purple btn-xs">
																						<i class="fa fa-sign-in"></i> groupadmin Login
																					</button>
																				</td>
																			</tr>
																			<?php	
																				$counter++;
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
								<div id="ftp2" class="tab-pane system2">
										<div class="action-table">
											<div class="row">
												<div class="col-xs-12">
													
													<div class="box-header">
														<div class="btn-group">
															
															<div class="custom-select">
														<select class="form-control actionsel" id = "actionval1">
															<option value ="">Action</option>
															<option value ="Block">Block</option>
															<option value ="Un-Block">Un-Block</option>
															<option value ="Delete">Delete</option>
														</select>
														</div>
														</div>
														<button type="button" class="btn btn-default submit" onclick="submitAllUser('groupadmin/userActions');">Submit</button>
														<a href="<?php echo site_url();?>groupadmin/createuser" class="add-btn">
															<span><i class="fa fa-plus"></i> New User</span>
														</a>
													</div>
													
													
													<div class="box">
														<div class="box-body table-responsive no-padding">
															<table class="table table-hover check-input userTable">
																<tbody>
																	<tr>
																		<th>
																			<input type="checkbox" class="checkbox" id="selecctalluser" >
																			<label for="selecctalluser"></label>
																		</th>																																<th>ID</th>
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
																				<td>
																				<input type="checkbox" name="appidss[]" class="useraction" id = "deluser_<?php echo $usr['id']?>" value ="<?php echo $usr['id']?>"/>
																				<label for="deluser_<?php echo $usr['id']?>"></label>
																					
																				</td>
																				<td><?php echo $counterU;?></td>
																				<td><img class="img-circle" src="<?php echo site_url();?>assets/site/main/group_pics/<?php echo $img1[0]['name'];?>"/><a id="<?php echo $usr['fname'].' '.$usr['lname'];?>" href="<?php echo site_url();?>/groupadmin/updateuser/<?php echo $usr['id']?>"> <?php echo $usr['fname'].' '.$usr['lname'];?></td>
																					<td>
																					
																						<?php
																							if(!empty($groupname)){
																							
		
																								echo $groupname[0]['group_name'];
																								}
																							
																							
																							?>
																						
																						
																				   </td>
																					
																					<td>
																						<?php $roles = $this->config->item('roles_id');
																							echo $roles[$usr['role_id']];
																						?>	
																					</td>
																					<td><?php echo $usr['email_id'];?></td>
																					<?php if($usr['status'] == 1){
																					?>
																					<td>
																						<span class="label label-success">Active</span>
																					</td>
																					<?php
																					}
																					else
																					{
																						?>
																					<td>
																						<span class="label label-danger">Blocked</span>
																					</td>
																						<?php 
																						} ?>
																					
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
								<div id="ftp3" class="tab-pane system2">
							<div class="action-table">
                        		<div class="row">
                        			<div class="col-xs-12">
						
						<form class="login-form" method="post" action="<?php echo site_url();?>groupadmin/savePermissions" enctype="multipart/form-data">
						  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<div class="box-header">
                            
							<button type="submit" class="add-btn">Save Permissions</button>	
							</div>
							
							  <div class="box">
                              <div class="box-body table-responsive no-padding">   
								  <table class="table table-hover check-input">
										
											
										
										<tbody>
										<tr>												
												<th>ID</th>												
												<th>Role</th>
												<th>Users<br/>
												Create/Edit/Delete</th>
												<th>Application
												<br/>
												Create/Edit/Delete</th>
												<th>Target<br/>
												Create/Edit/Delete</th>
												<th>Wowza<br/>
												Create/Edit/Delete</th>
												
											</tr>
											<?php
											$conter=1;
											$roles = $this->config->item('roles_id');
											foreach($roles as $role)
											{
												?>
												<input type="hidden" id="rid" name="rid[]" value="<?php echo $role;?>"/>
												<tr>
													<td><?php echo $conter;?></td>
												<td><?php echo $role;?></td>
													<td>
														<label class="switch">
															<input type="checkbox" id="create_user" name="create_user[<?php echo $role;?>][]" />
															<span class="slider round"></span>
														</label>
															<label class="switch">
															<input type="checkbox" id="edit_user" name="edit_user[<?php echo $role;?>][]" />
															<span class="slider round"></span>
														</label>
															<label class="switch">
															<input type="checkbox" id="delete_user" name="delete_user[<?php echo $role;?>][]" />
															<span class="slider round"></span>
														</label>
															
																													
														</td>
														<td>
															<label class="switch">
															<input type="checkbox" id="createapp" name="createapp[<?php echo $role;?>][]" />
															<span class="slider round"></span>
														</label>
														<label class="switch">
															<input type="checkbox" id="editapp" name="editapp[<?php echo $role;?>][]" />
															<span class="slider round"></span>
														</label>
														<label class="switch">
															<input type="checkbox" id="deleteapp" name="deleteapp[<?php echo $role;?>][]" />
															<span class="slider round"></span>
														</label>
														</td>
														<td>
														
															
															<label class="switch">
															<input type="checkbox" id="createtarget" name="createtarget[<?php echo $role;?>][]" />
															<span class="slider round"></span>
														</label>
														<label class="switch">
															<input type="checkbox" id="edittarget" name="edittarget[<?php echo $role;?>][]" />
															<span class="slider round"></span>
														</label>
														<label class="switch">
															<input type="checkbox" id="deletetarget" name="deletetarget[<?php echo $role;?>][]" />
															<span class="slider round"></span>
														</label>
															
														</td>
														<td>
														
															
																<label class="switch">
															<input type="checkbox" id="createwowza" name="createwowza[<?php echo $role;?>][]" />
															<span class="slider round"></span>
														</label>
														<label class="switch">
															<input type="checkbox" id="editwowza" name="editwowza[<?php echo $role;?>][]" />
															<span class="slider round"></span>
														</label>
														<label class="switch">
															<input type="checkbox" id="deletewowza" name="deletewowza[<?php echo $role;?>][]" />
															<span class="slider round"></span>
														</label>
																
														</td>
														</tr>
												<?php
												$conter++;
											}
											
											?>
											
										</tbody>
									</table>
									
								</div>
							</div>
							</form>
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
	
