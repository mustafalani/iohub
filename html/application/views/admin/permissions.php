<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
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

						<form class="login-form" method="post" action="<?php echo site_url();?>admin/savePermissions" enctype="multipart/form-data">
						  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<div class="box-header">
                                 <div class="btn-group">
								<button type="submit" class="add-btn">Save Permissions</button>
								<a href="<?php echo site_url();?>admin/createuser" class="add-btn">
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
														<div class="boxes">
															<input type="checkbox" id="create_user" name="create_user[<?php echo $role;?>][]" />
	                                                        <label for="create_user"></label>
														</div>
														<div class="boxes">
															<input type="checkbox" id="edit_user" name="edit_user[<?php echo $role;?>][]" />
	                                                        <label for="edit_user"></label>
														</div>
														<div class="boxes">
															<input type="checkbox" id="delete_user" name="delete_user[<?php echo $role;?>][]" />
	                                                        <label for="delete_user"></label>
														</div>
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
