
<style>
	
	.not-active {
	pointer-events: none;
	cursor: default;
	text-decoration:none;
	color:black;
	}
	
	
</style>

<?php $this->load->view('groupadmin/navigation.php');?>
<?php $this->load->view('groupadmin/leftsidebar.php');?>
<section class="content-wrapper">
   <!-- ========= Main Content Start ========= -->
   <div class="content">
      <div class="content-container">
         <div class="row">
            <div class="col-lg-12 col-12-12">
			
			
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
			
			
               <div class="content-box config-contentonly">
				   <div class="config-container">
                     <div class="tab-btn-container">
                        <ul class="nav nav-tabs" role="tablist">
                           <li class="active"><a data-toggle="tab" href="#system">Group Info</a></li>
                           <li><a data-toggle="tab" href="#ftp2">Users</a></li>
                        </ul>
                     </div>
                     <div class="tab-content">
                        <div id="system" class="tab-pane fade in active system2">
                        	<div class="row">
				<form id="wowza-form" class="form-only form-one" method="post" action="<?php echo site_url();?>groupadmin/updateGroupDetails/<?php echo isset($group_id)?$group_id:"";?>" enctype="multipart/form-data">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">	
				<div class="col-lg-12 conf shadow">
					<div class="col-lg-12">
						<div class="row">
							     <button type="submit" class="btn-def save btntop3">
									<span><i class="fa fa-save"></i> Update</span>
								</button>
						</div>
					</div>
					
					<div class="col-lg-4">
						<div class="form-group">
							<label>Group Name</label>
							<input type="text" class="form-control" placeholder="Group Name" name="group_name" value="<?php echo $groupdata[0]['group_name'];?>" required="true"/> 
							
						</div>
						<div class="form-group">
							<label>Website</label>
							<input type="text" class="form-control" placeholder="kurrent.tv" name="group_website" id="group_website" value="<?php echo $groupdata[0]['group_website'];?>" required="true"/>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control" placeholder="info@urrent.tv" name="group_email" id="group_email"  value="<?php echo $groupdata[0]['group_email'];?>" required="true"/>
						</div>
						<div class="form-group">
							<label>Phone</label>
							<input type="text" class="form-control" placeholder="111-222-333" name="group_phone" id="group_phone" value="<?php echo $groupdata[0]['group_phone'];?>" required="true"/>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label>Address</label>
							<input type="text" class="form-control" placeholder="Address" name="group_address" id="group_address" value="<?php echo $groupdata[0]['group_address'];?>" required="true"/>
						</div>
						<div class="form-group">
							<label>Zip / Postal Code</label>
							<input type="text" class="form-control" placeholder="Zip or Postal Code" name="group_postal_code" id="group_postal_code" value="<?php echo $groupdata[0]['group_postal_code'];?>"  required="true"/>
						</div>
						<div class="form-group">
							<label>City</label>
							<input type="text" class="form-control" placeholder="City" name="group_city" id="group_city" value="<?php echo $groupdata[0]['group_city'];?>" required="true"/>
						</div>
						<div class="form-group">
							<label>Country</label>
							<select class="form-control" name="group_country" id="group_country" required="true">
								<option value="0">Country</option>
								<?php 
								$countries = $this->common_model->getCountries();
								if(sizeof($countries)>0)
								{
									foreach($countries as $country)
									{
									
										if($groupdata[0]['group_country'] == $country['id'])
											{
												echo '<option selected="selected" value="'.$country['id'].'">'.$country['country_name'].'</option>';	
											}
											else
											{
												echo '<option value="'.$country['id'].'">'.$country['country_name'].'</option>';	
											}
										
										?>
										 	
										<?php
									}
								}
								?>
							</select>						
						</div>
					</div>
					<div class="col-lg-4">
						<div class="row">
							<div class="col-lg-8 pref">
								<label>Prefrences</label>
								<p class="groupuser-p">
								<span class="pull-left">Receive Global Newsletter</span>
								<label class="switch pull-right">
									
									<?php 
											if($groupdata[0]['group_notification'] == 1)
											{
												
												echo '<input type="checkbox" name="group_notification" id="group_notification" checked/>';
											
											}
											elseif($groupdata[0]['group_notification'] == 0)
											{
												echo '<input type="checkbox" name="group_notification" id="group_notification">';
											}	
											
											?>
									<span class="slider round"></span>
								</label>
								</p>
								<div class="row">
									<div class="col-lg-7 cat">
										<label>Admins</label><br>
										<a href="javascript:void(0);">2 Show Admins</a><br>
										<a href="javascript:void(0);"><i class="fa fa-plus"></i> Add New Admin</a>
										<br>
										<label>Assigned Resources</label><br>
										<a href="javascript:void(0);">2 Wowza 1 FTP</a><br>
										<a href="javascript:void(0);"><i class="fa fa-plus"></i> Manage Resources</a>
									</div>
									<div class="col-lg-5 cat">
										<label>Users</label><br>
										<a href="javascript:void(0);">2 Show Users</a><br>
										<a href="javascript:void(0);"><i class="fa fa-plus"></i> Add New User</a>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
							<?php $img = $this->common_model->getGgoupImage($groupdata[0]['id']);
							
												if($img[0]['name'] == "")
												{
												?>
												<img id="imgdiv" src="<?php echo site_url();?>assets/site/main/images/dummy3.png">
												<?php	
												}
												else
												{
												?>
												<img width="78" height="69" id="imgdiv" src="<?php echo site_url();?>assets/site/main/group_pics/<?php echo $img[0]['name'];?>" class="">
												<?php	
												}
											?>
								
								
								<input style="width:0px;height:0px;" type="file" name="groupfile" id="groupfile" class="groupfile"  />
								
								
								<a href="javascript:void(0);" id="uploadprofilepic">Upload Image</a>
								
							</div>
							<div class="col-lg-12">
								<div class="form-group m-t-5">
									<label>License</label>
									<input type="text" class="form-control" placeholder="License" name="group_licence" id="group_licence"  value="<?php echo $groupdata[0]['group_licence'];?>" required="true"/>
								</div>
							</div>
						</div>
					</div>
				</div>
				</form>
			</div>
			</div>
						
                        <div id="ftp2" class="tab-pane fade system2">
                           <div class="action-table">
                           		<div class="row">
                        			<div class="col-xs-12">
                           		
                              <div class="box-header">
                                 <!----<div class="btn-group">
                                    <!-----<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action <i class="fa fa-angle-down" aria-hidden="true"></i>                                                                
                                    </button>
                                    <ul class="dropdown-menu">
                                       <li><a href="#">Refresh</a></li>
                                       <li><a href="#">Reboot</a></li>
                                       <li><a href="#">Take Offline</a></li>
                                       <li role="separator" class="divider"></li>
                                       <li><a href="#">Delete</a></li>
                                    </ul>
									
                                 </div>---->
                                 <!----<button type="button" class="btn btn-default submit">Submit</button>--->
								 <select class="selectpicker" id = "actionval1">
															<option value ="Action" hidden>Action</option>
															<option value ="Refresh">Refresh</option>
															<option value ="Reboot">Reboot</option>
															<option value ="Take Offline">Take Offline</option>
															<option value ="Delete">Delete</option>
														</select>
								 <?php $userdata =$this->session->userdata('user_data'); 
									 $checkstatus = $this->common_model->checkWowzaStatus($userdata['userid']);
									//echo "<pre>";
									//print_r($checkstatus->create_user);die;
									if($checkstatus->delete_user == 0)
									{
								?>
								 <div class = "tool-tip-hover tool-tip-hover1">
								 <button type="button" class="btn btn-default submit" onclick="submitAllUser('groupadmin/deleteUser');">Submit</button>
								 <span class="tool-msg">Sorry! permission not allowed!</span>
								 </div>
								<?php
								   }
								else
									{
										?>
										
										 <button type="button" class="btn btn-default submit" onclick="submitAllUser('groupadmin/deleteUser');">Submit</button>
										
										<?php
										
										}
									
									 ?>
									 
									
									
								
								 
								  <?php 
									 
									 $userdata =$this->session->userdata('user_data');
									//echo "<pre>";
									//print_r($userdata);die;
									$checkstatus = $this->common_model->checkWowzaStatus($userdata['userid']);
									//echo "<pre>";
									//print_r($checkstatus->create_user);die;
									if($checkstatus->create_user == 0){
									 ?>
									 <div class = "tool-tip-hover tool-tip-hover1 " style="float:right;">
									  <a href="<?php echo site_url();?>groupadmin/createuser" class="add-btn not-active">
                                 <span><i class="fa fa-plus"></i> New User</span>
								 <span class="tool-msg">Sorry! permission not allowed!</span>
								 
                                 </a>
								 </div>
									 <?php
									}else{
									?>
									<a href="<?php echo site_url();?>groupadmin/createuser" class="add-btn">
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
                                          <!----<th><input type="checkbox" name=""></th>--->
										  <th><input type="checkbox"  class="checkbox" id="selecctalluser" ></th>
                                          <!-----<th>ID</th>---->
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
                                             <!-----<td><input type="checkbox" name="actions"></td>--->
											 <td><input type="checkbox" name="appidss[]" class="groupdel1" id = "deluser_<?php echo $usr['id']?>" value ="<?php echo $usr['id']?>"></td>
                                          <!------<td><?php echo $counterU;?></td>---->
                                          <td><img width="20px" height="20px" src="<?php echo site_url();?>assets/site/main/group_pics/<?php echo $img1[0]['name'];?>"/><a id="<?php echo $usr['fname'].' '.$usr['lname'];?>" href="<?php echo site_url();?>/groupadmin/updateuser/<?php echo $usr['id']?>"> <?php echo $usr['fname'].' '.$usr['lname'];?></td>
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

<style>
	.tool-msg{display:none;} 
	.tool-tip-hover{display:inline-block;position:relative;}
	.tool-tip-hover:hover .tool-msg{display:block;position:absolute;top: 8px;
    left: 105%;
    color: #fff;
    background: #000;
    padding: 10px 20px;
    font-size: 11px;}
.tool-tip-hover1:hover .tool-msg{display: inline-block;
    position: absolute;
    top: 83%!important;
    color: #fff;
    background: #000;
    padding: 10px 20px;
    font-size: 11px;
    left: -40px;
    z-index: 1;}	
	.check-input input[type="checkbox"] {
    display: block;
}
	</style>