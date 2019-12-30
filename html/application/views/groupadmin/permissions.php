<?php $this->load->view('groupadmin/navigation.php');?>
<?php $this->load->view('groupadmin/leftsidebar.php');?>
<section class="content-wrapper">
   <!-- ========= Main Content Start ========= -->
   <div class="content">
      <div class="content-container">
		  		 <?php
	if($this->session->flashdata('message_type') == "success")
	{
		?>			
		<div id="card-alert" class="card green lighten-5">
	      <div class="card-content green-text">
	        <p>SUCCESS : <?php echo $this->session->flashdata('success');?></p>
	      </div>
	      <button type="button" class="close green-text" data-dismiss="alert" aria-label="Close">
	        <span aria-hidden="true">×</span>
	      </button>
	    </div>
		<?php	
		}
		if($this->session->flashdata('message_type') == "error")
	{
		?>
		<div id="card-alert" class="card red lighten-5">
	      <div class="card-content red-text">
	        <p>DANGER : <?php echo $this->session->flashdata('error');?></p>
	      </div>
	      <button type="button" class="close red-text" data-dismiss="alert" aria-label="Close">
	        <span aria-hidden="true">×</span>
	      </button>
	    </div>			
		<?php	
		}

	?>
	<div class="row">	
				  <div class="col-lg-12 col-12-12">
               <div class="content-box config-contentonly">		
				<div class="col-lg-12 conf shadow min-h-64">
					<div class="tab-btn-container">
                        <ul class="nav nav-tabs" role="tablist">
                          <li class="active"><a data-toggle="tab" href="#ftp2">User Permissions</a></li>
                        </ul>
                     </div>					

					<div class="tab-content">						
						<div id="ftp2" class="tab-pane fade in active system2">
							<div class="action-table">
                        		<div class="row">
                        			<div class="col-xs-12">
						
						<form class="login-form" method="post" action="<?php echo site_url();?>groupadmin/savePermissions" enctype="multipart/form-data">
						  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<div class="box-header">
                                 <div class="btn-group">							
								<button type="submit" class="add-btn">Save Permissions</button>
								<a href="<?php echo site_url();?>groupadmin/createuser" class="add-btn">
									<span><i class="fa fa-plus"></i> New User</span>
								</a>
							</div>
							</div>
							
							  <div class="box">
                              <div class="box-body table-responsive no-padding">   
								  <table class="table table-hover check-input">
										
											
										
										<tbody>
										<tr>												
												<th>ID</th>
												<th>Name</th>
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
												if(sizeof($users)>0)
												{
													$counterU =1;
													foreach($users as $usr)
													{
														$Id = $usr['id'];
														$img1 = $this->common_model->getUserImage($Id);
														
														$groupname = $this->common_model->getGroupInfobyId($usr['group_id']);
														$permission = $this->common_model->getUserPermission($Id);
													?>
													<tr>	
														<td><?php echo $counterU;?></td>
														<td><img width="20px" height="20px" src="<?php echo site_url();?>assets/site/main/group_pics/<?php echo $img1[0]['name'];?>"/> <?php echo $usr['fname'].' '.$usr['lname'];?>
															<input type="hidden" id="userids" name="userids[]" value="<?php echo $usr['id'];?>"/>
														</td>
														<td><?php $roles = $this->config->item('roles_id');
														echo $roles[$usr['role_id']];
														?></td>
														<td>
															<?php															
															if(sizeof($permission)>0)
															{
																if($permission[0]['create_user'] == 0 || $permission[0]['create_user'] == NULL || $permission[0]['create_user'] == -1)
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="create_user" name="create_user[<?php echo $usr['id'];?>][]" />
															<span class="slider round"></span>
														</label>
																	<?php
																}
																elseif($permission[0]['create_user'] == 1)	
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="create_user" name="create_user[<?php echo $usr['id'];?>][]" checked="true" />
															<span class="slider round"></span>
														</label>
																	<?php
																}																
																if($permission[0]['edit_user'] == 0 || $permission[0]['create_user'] == NULL || $permission[0]['create_user'] == -1)
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="edit_user" name="edit_user[<?php echo $usr['id'];?>][]" />
															<span class="slider round"></span>
														</label>
																	<?php
																}
																elseif($permission[0]['edit_user'] == 1)	
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="edit_user" name="edit_user[<?php echo $usr['id'];?>][]" checked="true" />
															<span class="slider round"></span>
														</label>
																	<?php
																}
																if($permission[0]['delete_user'] == 0 || $permission[0]['create_user'] == NULL || $permission[0]['create_user'] == -1)
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="delete_user" name="delete_user[<?php echo $usr['id'];?>][]" />
															<span class="slider round"></span>
														</label>
																	<?php
																}
																elseif($permission[0]['delete_user'] == 1)	
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="delete_user" name="delete_user[<?php echo $usr['id'];?>][]" checked="true" />
															<span class="slider round"></span>
														</label>
																	<?php
																}
															}
															else
															{
																?>
																<label class="switch">
															<input type="checkbox" id="create_user" name="create_user[<?php echo $usr['id'];?>][]" />
															<span class="slider round"></span>
														</label>
														<label class="switch">
															<input type="checkbox" id="edit_user" name="edit_user[<?php echo $usr['id'];?>][]" />
															<span class="slider round"></span>
														</label>
														<label class="switch">
															<input type="checkbox" id="delete_user" name="delete_user[<?php echo $usr['id'];?>][]" />
															<span class="slider round"></span>
														</label>
																<?php
															}
															?>
																													
														</td>
														<td>
															<?php
															if(sizeof($permission)>0)
															{
																if($permission[0]['create_application'] == 0)
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="createapp" name="createapp[<?php echo $usr['id'];?>][]" />
															<span class="slider round"></span>
														</label>
																	<?php
																}
																elseif($permission[0]['create_application'] == 1)	
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="createapp" name="createapp[<?php echo $usr['id'];?>][]" checked="true" />
															<span class="slider round"></span>
														</label>
																	<?php
																}
																if($permission[0]['edit_application'] == 0)
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="editapp" name="editapp[<?php echo $usr['id'];?>][]" />
															<span class="slider round"></span>
														</label>
																	<?php
																}
																elseif($permission[0]['edit_application'] == 1)	
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="editapp" name="editapp[<?php echo $usr['id'];?>][]" checked="true" />
															<span class="slider round"></span>
														</label>
																	<?php
																}
																if($permission[0]['delete_application'] == 0)
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="deleteapp" name="deleteapp[<?php echo $usr['id'];?>][]" />
															<span class="slider round"></span>
														</label>
																	<?php
																}
																elseif($permission[0]['delete_application'] == 1)	
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="deleteapp" name="deleteapp[<?php echo $usr['id'];?>][]" checked="true" />
															<span class="slider round"></span>
														</label>
																	<?php
																}
															}
															else
															{
																?>
																<label class="switch">
															<input type="checkbox" id="createapp" name="createapp[<?php echo $usr['id'];?>][]" />
															<span class="slider round"></span>
														</label>
														<label class="switch">
															<input type="checkbox" id="editapp" name="editapp[<?php echo $usr['id'];?>][]" />
															<span class="slider round"></span>
														</label>
														<label class="switch">
															<input type="checkbox" id="deleteapp" name="deleteapp[<?php echo $usr['id'];?>][]" />
															<span class="slider round"></span>
														</label>
																<?php
															}
															?>
																													
														</td>
														<td>
														<?php
															if(sizeof($permission)>0)
															{
																if($permission[0]['create_target'] == 0)
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="createtarget" name="createtarget[<?php echo $usr['id'];?>][]"  />
															<span class="slider round"></span>
														</label>
																	<?php
																}
																elseif($permission[0]['create_target'] == 1)
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="createtarget" name="createtarget[<?php echo $usr['id'];?>][]" checked="true" />
															<span class="slider round"></span>
														</label>
																	<?php
																}
																if($permission[0]['edit_target'] == 0)
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="edittarget" name="edittarget[<?php echo $usr['id'];?>][]"  />
															<span class="slider round"></span>
														</label>
																	<?php
																}
																elseif($permission[0]['edit_target'] == 1)
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="edittarget" name="edittarget[<?php echo $usr['id'];?>][]" checked="true" />
															<span class="slider round"></span>
														</label>
																	<?php
																}
																if($permission[0]['delete_target'] == 0)
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="deletetarget" name="deletetarget[<?php echo $usr['id'];?>][]"  />
															<span class="slider round"></span>
														</label>
																	<?php
																}
																elseif($permission[0]['delete_target'] == 1)
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="deletetarget" name="deletetarget[<?php echo $usr['id'];?>][]" checked="true" />
															<span class="slider round"></span>
														</label>
																	<?php
																}
																
															}
															else
															{
															?>
															<label class="switch">
															<input type="checkbox" id="createtarget" name="createtarget[<?php echo $usr['id'];?>][]" />
															<span class="slider round"></span>
														</label>
														<label class="switch">
															<input type="checkbox" id="edittarget" name="edittarget[<?php echo $usr['id'];?>][]" />
															<span class="slider round"></span>
														</label>
														<label class="switch">
															<input type="checkbox" id="deletetarget" name="deletetarget[<?php echo $usr['id'];?>][]" />
															<span class="slider round"></span>
														</label>
															<?php	
															}
														?>	
														</td>
														<td>
														<?php
															if(sizeof($permission)>0)
															{
																if($permission[0]['create_wowza'] == 0)
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="createwowza" name="createwowza[<?php echo $usr['id'];?>][]" />
															<span class="slider round"></span>
														</label>
																	<?php
																}
																elseif($permission[0]['create_wowza'] == 1)
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="createwowza" name="createwowza[<?php echo $usr['id'];?>][]" checked="true" />
															<span class="slider round"></span>
														</label>
																	<?php
																}
																if($permission[0]['edit_wowza'] == 0)
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="editwowza" name="editwowza[<?php echo $usr['id'];?>][]" />
															<span class="slider round"></span>
														</label>
																	<?php
																}
																elseif($permission[0]['edit_wowza'] == 1)
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="editwowza" name="editwowza[<?php echo $usr['id'];?>][]" checked="true" />
															<span class="slider round"></span>
														</label>
																	<?php
																}
																if($permission[0]['delete_wowza'] == 0)
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="deletewowza" name="deletewowza[<?php echo $usr['id'];?>][]" />
															<span class="slider round"></span>
														</label>
																	<?php
																}
																elseif($permission[0]['delete_wowza'] == 1)
																{
																	?>
																	<label class="switch">
															<input type="checkbox" id="deletewowza" name="deletewowza[<?php echo $usr['id'];?>][]" checked="true" />
															<span class="slider round"></span>
														</label>
																	<?php
																}
															}
															else
															{
																?>
																<label class="switch">
															<input type="checkbox" id="createwowza" name="createwowza[<?php echo $usr['id'];?>][]" />
															<span class="slider round"></span>
														</label>
														<label class="switch">
															<input type="checkbox" id="editwowza" name="editwowza[<?php echo $usr['id'];?>][]" />
															<span class="slider round"></span>
														</label>
														<label class="switch">
															<input type="checkbox" id="deletewowza" name="deletewowza[<?php echo $usr['id'];?>][]" />
															<span class="slider round"></span>
														</label>
																<?php
															}	
															?>
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