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
					<form id="wowza-form" class="form-only form-one" method="post" action="<?php echo site_url();?>groupadmin/saveUser" enctype="multipart/form-data">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
				<div class="col-lg-12 conf shadow">
					<div class="col-lg-12">
						<div class="row">
							 <button type="submit" class="btn-def save">
									<span><i class="fa fa-save"></i> Save</span>
								</button>
						</div>
					</div>
					<div class="col-lg-12"><div class="row"><hr></div></div>
					<div class="col-lg-4">
						<div class="form-group">
							<label>First Name</label>
							<input type="text" class="form-control" placeholder="First Name" name="fname" id="fname"/>
						</div>
						<div class="form-group">
							<label>Last Name</label>
							<input type="text" class="form-control" placeholder="Last Name" name="lname" id="lname"/>
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control" placeholder="info@urrent.tv" name="email_id" id="email_id"/>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label>Phone</label>
							<input type="text" class="form-control" placeholder="Phone" name="phone" id="phone"/>
						</div>
						<div class="form-group">
							<label>Group</label>
							<select class="form-control selectpicker" name="group_id" id="group_id">
								<option>Select Group</option>
								
                               <?php
							   if(sizeof($groups)>0)
							   {
									foreach($groups as $group)
									{
										echo '<option value="'.$group['id'].'">'.$group['group_name'].'</option>';
									}
							   }
							   ?>								
							</select>
						</div>
						<div class="form-group">
							<label>Role</label>
							<select class="form-control selectpicker" name="role_id" id="role_id">
								<option value="0">Select Role</option>
								<option value="1">groupadmin</option>
								<option value="2">Group groupadmin</option>
								<option value="3">Group User</option>
							</select>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="row">
							<div class="col-lg-8 pref">
								<label>Prefrences</label>
								<br/>
								<div class="switch-box">Receive Group Notifications
                                    <span class="switch-btn">
                                    <input type="checkbox" id="group_notification" name="group_notification"/><label for="switch">Toggle</label></span>
                                </div>
								<div class="switch-box">Use Dark Theme
                                    <span class="switch-btn"><input type="checkbox" id="group_theme" name="group_theme"/><label for="switch">Toggle</label></span>
                                </div>
								
								
								
							</div>
							<div class="col-lg-4">
								<img id="imgdiv" src="<?php echo site_url();?>assets/site/main/images/user.png">
								<input style="width:0px;height:0px;" type="file" name="groupfile" id="groupfile" class="groupfile"/>
								<a href="javascript:void(0);" id="uploadprofilepic">Upload Image</a>
							</div>
							
							<div class="col-lg-12 margintop3"> &nbsp;</div>
								
							<div class="col-lg-6">
								<div class="form-group">
									<label>Time Zone</label>
									<select id="timezone" name="timezone" class="form-control selectpicker"  required="true">           
																 <option value="0">Time Zone</option>          
																	 <?php 
																		$timezone = $this->common_model->getAllTimezone();                  			
																		if(sizeof($timezone)>0)
																		{
																			foreach($timezone as $timezones)
																			{
																				
																				echo '<option value="'.$timezones['timeZoneId'].'">'.$timezones['time_zone_name'].'</option>';		
																				
																			}
																		}
																		?> 
															</select>  
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Time Format</label>									
									<select id="timeformat" name="timeformat" class="form-control selectpicker"  required="true">           
										 <option value="0">Time Format</option>          
										 <option value="12">12 hours</option>   
										  <option value="24">24 hours</option>   	 
									</select>  
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Password</label>
									<input type="password" class="form-control" placeholder="********" name="password" id="password"/>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Confirm Password</label>
									<input type="password" class="form-control" placeholder="Confirm Password" name="passwordagain" id="passwordagain"/>
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
			</div>
		</section>