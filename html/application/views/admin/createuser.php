<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<style type="text/css">
	.groupfile {
	    display: none !important;
	}
</style>
<main class="main">
  	   <!-- Breadcrumb-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Home</a>
        </li>
        <li class="breadcrumb-item active"><a href="<?php echo site_url();?>clients">Clients</a></li>
        <li class="breadcrumb-item active">Create User</li>
      </ol>
      <div class="container-fluid">
      	<div class="animated fadeIn">
           <div class="card">
						 <form id="wowza-form" class="form-only form-one" method="post" action="<?php echo site_url();?>admin/saveUser" enctype="multipart/form-data">
						 <div class="card-header">Add New User</div>
				<div class="card-body">
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
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					<div class="row">
						<div class="col-lg-4">
						<div class="form-group">
							<label>First Name <span class="mndtry">*</span></label>
							<input type="text" pattern="[a-zA-Z ]+" title="[a-zA-Z ]+"  class="form-control" placeholder="First Name" name="fname" id="fname" required="true"/>
						</div>
						<div class="form-group">
							<label>Last Name <span class="mndtry">*</span></label>
							<input type="text" pattern="[a-zA-Z ]+" title="[a-zA-Z ]+"  class="form-control" placeholder="Last Name" name="lname" id="lname" required="true"/>
						</div>
						<div class="form-group">
							<label>Email <span class="mndtry">*</span></label>
							<input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="example@domain.com" class="form-control" placeholder="email@example.com" name="email_id" id="email_id" required="true"/>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label>Phone <span class="mndtry">*</span></label>
							<input type="text" class="form-control" placeholder="Phone" name="phone" id="phone" required="true"/>
						</div>
						<div class="form-group">
							<label>Group</label>
							<select class="form-control selectpicker" name="group_id" id="group_id">
								<option>-- Select --</option>
								<?php
									if(sizeof($groups)>0)
									{
										$counter =1;
										foreach($groups as $group)
										{
											if($this->uri->segment(3) != "" && $this->uri->segment(3) == $group['id'])
											{
												?>
											<option selected="selected" value="<?php echo $group['id'];?>"><?php echo $group['group_name'];?></option>
											<?php
											}
											else
											{
											?>
											<option value="<?php echo $group['id'];?>"><?php echo $group['group_name'];?></option>
											<?php
											}
										}
									}
								?>
							</select>
						</div>
						<div class="form-group">
							<label>Role <span class="mndtry">*</span></label>
							<select class="form-control selectpicker" name="role_id" id="role_id" required="true">
								<option value="0">-- Select --</option>

								<?php
								$userdata = $this->session->userdata('user_data');
								if($this->uri->segment(2) != "" && $this->uri->segment(2) == 2)
								{
									if($userdata['user_type'] == 1)
									{
										?>
										<option value="1">Admin</option>
									<option selected="selected" value="2">Group Admin</option>
									<option value="3">Group User</option>
									<?php
									}
									else
									{
										?>
									<option selected="selected" value="2">Group Admin</option>
									<option value="3">Group User</option>
									<?php
									}

								}
								elseif($this->uri->segment(2) != "" && $this->uri->segment(2) == 3)
								{
									if($userdata['user_type'] == 1)
									{
										?>
										<option value="1">Admin</option>
									<option  value="2">Group Admin</option>
									<option selected="selected" value="3">Group User</option>
									<?php
									}
									else
									{
										?>
								<option  value="2">Group Admin</option>
									<option selected="selected" value="3">Group User</option>
									<?php
									}
								}
								else
								{
									?>

									<option  value="2">Group Admin</option>
									<option  value="3">Group User</option>
									<?php
								}
								?>

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
                                    <input type="checkbox" id="group_notification" name="group_notification"/><label for="group_notification">Toggle</label></span>
                                </div>
								<div class="switch-box">Use Light Theme
                                    <span class="switch-btn"><input type="checkbox" id="group_theme" name="group_theme"/><label for="group_theme">Toggle</label></span>
                                </div>



							</div>
							<div class="col-lg-4">
								<img id="imgdiv" class="groupimg" src="<?php echo site_url();?>assets/site/main/images/user.png">
								<input style="width:0px;height:0px;" type="file" name="groupfile" id="groupfile" class="groupfile"/>
								<a href="javascript:void(0);" id="uploadprofilepic">Upload Image</a>
							</div>

							<div class="col-lg-12 margintop3"> &nbsp;</div>

							<div class="col-lg-6">
								<div class="form-group">
									<label>Time Zone <span class="mndtry">*</span></label>
									<select id="timezone" name="timezone" class="form-control selectpicker"  required="true">
																 <option value="0">-- Select --</option>
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
									<label>Time Format <span class="mndtry">*</span></label>
									<select id="timeformat" name="timeformat" class="form-control selectpicker"  required="true">
										 <option value="0">-- Select --</option>
										 <option value="12">12 hours</option>
										  <option value="24">24 hours</option>
									</select>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Password <span class="mndtry">*</span></label>
									<input type="password" class="form-control" name="password" id="password" required="true"/>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="form-group">
									<label>Confirm Password <span class="mndtry">*</span></label>
									<input type="password" class="form-control" name="passwordagain" id="passwordagain" required="true"/>
								</div>
							</div>
						</div>
					</div>

					</div>
					</div>
				</div>
			</div>
				</div>
				<div class="card-footer">
					<button class="btn btn-sm btn-primary" type="submit">Save</button>
						<button class="btn btn-sm btn-danger" type="reset">Reset</button>
						</div>
						</form>
			</div>
		</div>
	</div>
</main>
