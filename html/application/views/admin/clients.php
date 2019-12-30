<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<style type="text/css">
	table tr td.tdimg{
		text-align: left;
	}
	table tr td.tdimg a{
		padding-left: 10px;
		width: 100%;
	}
	table tr td.tdimg img{
		width: 30px;
	}
</style>
<main class="main">
	   <!-- Breadcrumb-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Home</a>
          </li>
          <li class="breadcrumb-item active">Clients</li>
        </ol>
        <div class="container-fluid">
        <div class="animated fadeIn">
        	<div class="card">
        		<div class="card-body">
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
				<div class="row">
					<div class="col-lg-12 col-12-12">
							<ul class="nav nav-tabs" role="tablist" id="clients">
									<li class="nav-item">
										<a class="nav-link active" id="groups" data-toggle="tab" href="#system">Groups</a></li>
									<li class="nav-item">
										<a class="nav-link" id="users" data-toggle="tab" href="#ftp2">Users</a></li>
									<?php
						            $userdata = $userdata = $this->session->userdata('user_data');
						            if($userdata['user_type'] == 1)
						            {
						            ?>
						            <li class="nav-item">
						            	<a class="nav-link" id="permissions" data-toggle="tab" href="#ftp3">Permissions</a>
						            </li>
						            <?php
						            }
              						?>
								</ul>
								<div class="tab-content">
									<div id="system" class="tab-pane system2 active">
										<div class="card-body">
											<div class="row">
											<div class="col-12" style="padding: 0;">
												<?php
									            $userdata = $userdata = $this->session->userdata('user_data');
									            if($userdata['user_type'] == 1)
									            {
									            ?>
									            <div class="box-header">
													<div class="btn-group">
														<select class="form-control actionsel" id="actionval">
															<option value ="" hidden>Action</option>
															<option value ="Block">Block</option>
															<option value ="UnBlock">Un-Block</option>
															<option value ="Delete">Delete</option>
														</select>

													</div>
													<button type="button" class="btn btn-primary submit" onclick="submitAllGroups('admin/groupActions');">Submit</button>
													<a href="<?php echo site_url();?>creategroup" class="btn btn-primary add-btn float-right">
														<span><i class="fa fa-plus"></i> New Group</span>
													</a>
												</div>
									            <?php
									            }
			              						?>
												<br/>
												<div class="table-responsive no-padding">

															<table class="table table-hover check-input cstmtable groupTable">

																	<tr>

																		<?php
															            $userdata = $userdata = $this->session->userdata('user_data');
															            if($userdata['user_type'] == 1)
															            {
															            	?>
															            	<th>
															            	<input type="checkbox" class="checkbox" id="selecctallgroups">
																			<label for="selecctallgroups"></label>
																			</th>
															            	<?php
															            }
															            ?>

																		<th>ID</th>
																		<th>Group Name</th>
																		<th>E-mail Address</th>
																		<th>Status</th>
																	<th>Users</th>
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
																			<tr id="row_<?php echo $group['id'];?>">
																				<?php
															            $userdata = $userdata = $this->session->userdata('user_data');
															            if($userdata['user_type'] == 1)
															            {
															            	?>
															            	<td>
																				<input type="checkbox" name="appids[]" class="groupaction" id = "del_<?php echo $group['id']?>" value="<?php echo $group['id']?>"/>
																					<label for="del_<?php echo $group['id']?>"></label>
																				</td>
															            	<?php
															            }
															            ?>


																				<td><?php echo $counter;?></td>
																				<td class="tdimg">
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
																				<a id="<?php echo $group['group_name']?>" href="<?php echo site_url();?>updategroup/<?php echo $group['id']?>"><?php echo $group['group_name']?></a></td>
																				<td><?php echo $group['group_email'];?></td>
																				<td>
																					<?php
																					if($group['status'] == 0)
																					{
																						?>
																					<span id="status" class="label label-danger">Block</span>
																					<?php
																					}
																					elseif($group['status'] == 1)
																					{
																					?>
																					<span id="status" class="label label-success">Active</span>
																					<?php
																					}
																					?>

																				</td>
																				<!----<td><a href="javascript:void(0);">12 <br> Show all users</a></td>---->
																				<td><a href="<?php echo site_url();?>allgroupuser/<?php echo $group['id'];?>">Show all users</a></td>
																			</tr>
																			<?php
																				$counter++;
																			}
																		}
																		else
																		{
																			?>
																			<tr>
																			<td colspan="9">No Record Found!</td>
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
								<div id="ftp2" class="tab-pane system2">
										<div class="card-body">
											<div class="row">
												<div class="col-12" style="padding: 0;">
													<div class="box-header">
														<div class="btn-group">

														<select class="form-control actionsel" id = "actionval1">
															<option value ="0">Action</option>
															<option value ="Block">Block</option>
															<option value ="UnBlock">Un-Block</option>
															<option value ="Delete">Delete</option>
														</select>

														</div>
														<button type="button" class="btn btn-primary submit" onclick="submitAllUser('admin/userActions');">Submit</button>
														<a href="<?php echo site_url();?>createuser" class="btn btn-primary add-btn float-right">
															<span><i class="fa fa-plus"></i> New User</span>
														</a>
													</div>
													<br/>
														<div class="table-responsive no-padding">
															<table class="table table-hover check-input userTable cstmtable">
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
																		<th>Last Login</th>
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
																			<tr id="row_<?php echo $usr['id'];?>">
																				<td>
																				<input type="checkbox" name="appidss[]" class="useraction" id = "deluser_<?php echo $usr['id']?>" value ="<?php echo $usr['id']?>"/>
																				<label for="deluser_<?php echo $usr['id']?>"></label>

																				</td>
																				<td><?php echo $counterU;?></td>
																				<td class="tdimg">
																				<?php
																				if(sizeof($img1)>0)
																				{
																				?>
																				<img class="img-circle" src="<?php echo site_url();?>assets/site/main/group_pics/<?php echo $img1[0]['name'];?>"/>
																				<?php
																				}
																				else
																				{
																					?>
																					<img class="img-circle" src="<?php echo site_url();?>assets/site/main/group_pics/1522075611_user.png" style="background:#ffff;"/>
																					<?php
																				}
																				?>

																				<a id="<?php echo $usr['fname'].' '.$usr['lname'];?>" href="<?php echo site_url();?>updateuser/<?php echo $usr['id']?>"> <?php echo $usr['fname'].' '.$usr['lname'];?></a></td>
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
																						<span id="status" class="label label-danger">Blocked</span>
																					</td>
																						<?php
																						} ?>

																					<td><?php
																					if($usr['last_login'] != "")
																					{
																						 echo $usr['last_login'];
																					}
																					else
																					{
																						 echo "NA";
																					}
																					 ?></td>
																				</tr>
																				<?php
																					$counterU++;
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
																	</tbody>
																</table>
															</div>
													</div>
												</div>
											</div>


										</div>
								<?php
						            $userdata = $userdata = $this->session->userdata('user_data');
						            if($userdata['user_type'] == 1)
						            {
						            ?>
						           <div id="ftp3" class="tab-pane system2">
							<div class="card-body">
                        		<div class="row">


						<form class="login-form" method="post" action="<?php echo site_url();?>admin/savePermissions" enctype="multipart/form-data">
						  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<div class="box-header">

							<button type="submit" class="btn btn-primary add-btn ">Save Permissions</button>
							</div>
							  <br/>
                              <div class="table-responsive no-padding">
                              		<table class="table table-hover check-input cstmtable">
                              			<tr>
                              			<th class="permishd">Permissions</th>
                              			<th class="permishd">Admin</th>
                              			<th class="permishd">Group Admin</th>
                              			<th class="permishd">User</th>
                              			</tr>
                              			<?php
                              			$category = $this->common_model->getPermissionNames();
                              			$apermission = $this->common_model->getUserPermission(1);
                              			$gpermission = $this->common_model->getUserPermission(2);
                              			$upermission = $this->common_model->getUserPermission(3);
                              			if(sizeof($category)>0)
                              			{
											foreach($category as $cat)
											{
												if($cat != "id" && $cat != "rid" && $cat != "created")
												{
													?>
													<tr>

														<td class="permish">
														<?php
															$cataction = explode("_",$cat);
															switch($cataction[0])
															{
																case "create":
																?>
																<i class="fa fa-plus"></i>
																<?php
																break;
																case "edit":
																?>
																<i class="fa fa-pencil"></i>
																<?php
																break;
																case "delete":
																?>
																<i class="fa fa-trash"></i>
																<?php
																break;
																case "lock":
																?>
																<i class="fa fa-lock"></i>
																<?php
																break;
																case "unlock":
																?>
																<i class="fa fa-unlock"></i>
																<?php
																break;
																case "copy":
																?>
																<i class="fa fa-copy"></i>
																<?php
																break;
																case "reboot":
																?>
																<i class="fa fa-refresh"></i>
																<?php
																break;
																case "start":
																?>
																<i class="fa fa-pause"></i>
																<?php
																break;
																case "stop":
																?>
																<i class="fa fa-play"></i>
																<?php
																break;
																case "enable":
																?>
																<i class="fa fa-check"></i>
																<?php
																break;
																case "disable":
																?>
																<i class="fa fa-ban"></i>
																<?php
																break;
																case "block":
																?>
																<i class="fa fa-check"></i>
																<?php
																break;
																case "unblock":
																?>
																<i class="fa fa-ban"></i>
																<?php
																break;
																case "view":
																?>
																<i class="fa fa-eye"></i>
																<?php
																break;

															}
														  echo ucwords(str_replace('_',' ',$cataction[1]));?></td>
														<td class="permis">
														<div class="permission_box">

															<?php
															if(sizeof($apermission) && $apermission[0][$cat] == 1)
															{
																?>
																<input checked="true" type="checkbox" id="<?php echo $cat;?>_1" name="<?php echo $cat;?>[1][]" />
																<?php
															}
															else
															{
																?>
																<input type="checkbox" id="<?php echo $cat;?>_1" name="<?php echo $cat;?>[1][]" />
																<?php
															}
															?>
															<label for="<?php echo $cat;?>_1"></label>
														</div>
														</td>
														<td class="permis">
														<div class="permission_box">
															<?php
															if(sizeof($gpermission) && $gpermission[0][$cat] == 1)
															{
																?>
																<input checked="true" type="checkbox" id="<?php echo $cat;?>_2" name="<?php echo $cat;?>[2][]" />
																<?php
															}
															else
															{
																?>
																<input type="checkbox" id="<?php echo $cat;?>_2" name="<?php echo $cat;?>[2][]" />
																<?php
															}
															?>

															<label for="<?php echo $cat;?>_2"></label>
														</div>
														</td>
														<td class="permis">
														<div class="permission_box">
														<?php
															if(sizeof($upermission) && $upermission[0][$cat] == 1)
															{
																?>
																<input checked="true" type="checkbox" id="<?php echo $cat;?>_3" name="<?php echo $cat;?>[3][]" />
																<?php
															}
															else
															{
																?>
																<input type="checkbox" id="<?php echo $cat;?>_3" name="<?php echo $cat;?>[3][]" />
																<?php
															}
															?>

															<label for="<?php echo $cat;?>_3"></label>
														</div>
														</td>
													</tr>
													<?php
												}
											}
										}
                              			?>
                              		</table>


								</div>

							</form>

							</div>
							</div>
						</div>
						            <?php
						            }
              						?>


									</div>
						</div>
					</div>
        		</div>
        	</div>
        </div>
    </div>
</main>
