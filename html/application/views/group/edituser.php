<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
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
			<div class="content-box config-contentonly">
			<div class="row">
			
				<form id="wowza-form" class="form-only form-one" method="post" action="<?php echo site_url();?>admin/updateUserdetails" enctype="multipart/form-data">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
				<div class="col-lg-12 conf shadow">
					<div class="col-lg-12">
						<div class="row">
							 <button type="submit" class="btn-def save">
									<span><i class="fa fa-save"></i> Update</span>
								</button>
						</div>
					</div>
					<div class="col-lg-12"><div class="row"><hr></div></div>
					<div class="col-lg-4">
						<div class="form-group">
							<label>First Name</label>
							<input type="text" class="form-control" placeholder="First Name" name="fname" id="fname" value="<?php echo $groupuser[0]['fname']?>"/>
						</div>
						<div class="form-group">
							<label>Last Name</label>
							<input type="text" class="form-control" placeholder="Last Name" name="lname" id="lname" value="<?php echo $groupuser[0]['lname']?>"/>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control" placeholder="info@urrent.tv" name="email_id" id="email_id" value="<?php echo $groupuser[0]['email_id']?>"/>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label>Phone</label>
							<input type="text" class="form-control" placeholder="Phone" name="phone" id="phone" value="<?php echo $groupuser[0]['phone']?>"/>
						</div>
						<div class="form-group">
							<label>Group</label>
							<select class="form-control select" name="group_id" id="group_id">
								<option>Select Group</option>
								<?php
									if(sizeof($groups)>0)
									{
										$counter =1;
										foreach($groups as $group)
										{
										print_r($group);	
										if($groupuser[0]['group_id'] == $group['id'])
											{
												echo '<option selected="selected" value="'.$group['id'].'">'.$group['group_name'].'</option>';	
											}
											else
											{
												echo '<option value="'.$group['id'].'">'.$group['group_name'].'</option>';	
											}
											?>
											
											<?php
										}
									}
								?>			
							</select>
						</div>
						<div class="form-group">
							<label>Role</label>
							<select class="form-control select" name="role_id" id="role_id">
								<option value="0">Select Role</option>
								<option value="2">Group Admin</option>
								<option value="3">Group User</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="row">
							<div class="col-lg-8 pref">
								<label>Prefrences</label>
								<br/>
								<span class="pull-left">Receive Notification</span>
								<label class="switch pull-right">
									
									<?php 
											if($groupuser[0]['group_notification'] == 1)
											{
												
												echo '<input type="checkbox" name="group_notification" id="group_notification" checked/>';
											
											}
											elseif($groupuser[0]['group_notification'] == 0)
											{
												echo '<input type="checkbox" name="group_notification" id="group_notification">';
											}	
											
											?>
									<span class="slider round"></span>
								</label>
								<span class="pull-left">Use Light Theme</span>
								<label class="switch pull-right l-30">
								<?php 
											if($groupuser[0]['theme'] == 1)
											{
												
												echo '<input type="checkbox" name="theme" id="theme" checked/>';
											
											}
											elseif($groupuser[0]['theme'] == 0)
											{
												echo '<input type="checkbox" name="theme" id="theme">';
											}	
											
											?>
									
									<span class="slider round"></span>
								</label>
							</div>
							<div class="col-lg-4">
							<?php $img = $this->common_model->getUsersImage($groupuser[0]['id']);
							
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
								
								
								<input style="width:0px;height:0px;" type="file" name="groupfile" id="groupfile" class="groupfile"/>
								<a href="javascript:void(0);" id="uploadprofilepic">Upload Image</a>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Time Zone</label>
									<select id="timezone" name="timezone" class="form-control"  required="true">           
																 <option value="0">Time Zone</option>          
																	 <?php 
																		$timezone = $this->common_model->getAllTimezone();                  			
																		if(sizeof($timezone)>0)
																		{
																			foreach($timezone as $timezones)
																			
																			{
																				if($groupuser[0]['timezone'] == $timezones['timeZoneId'])
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
							<div class="col-lg-6">
								<div class="form-group">
									<label>Time Format</label>
									<input type="text" class="form-control" placeholder="Time Format" name="timeformat" id="timeformat"value="<?php echo $groupuser[0]['timeformat']?>"/>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Password</label>
									<input type="text" class="form-control" placeholder="********" name="password" id="password" value="<?php echo $groupuser[0]['password']?>"/>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Confirm Password</label>
									<input type="text" class="form-control" placeholder="Time Zone" name="passwordagain" id="passwordagain" value="<?php echo $groupuser[0]['password']?>"/>
								</div>
							</div>
						</div>
					</div>
				</div>
				</form>
			</div>
			</div>
			</div>
			</div>
		</section>