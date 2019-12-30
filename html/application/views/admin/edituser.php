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
          <a href="<?php echo site_url();?>">Home</a>
        </li>
        <li class="breadcrumb-item active"><a href="<?php echo site_url();?>clients">Clients</a></li>
        <li class="breadcrumb-item active"><?php echo isset($groupuser[0]['fname'])?$groupuser[0]['fname']:"";?> <?php echo isset($groupuser[0]['lname'])?$groupuser[0]['lname']:"";?></li>
      </ol>
      <div class="container-fluid">
      	<div class="animated fadeIn">
           <div class="card">
             <form id="wowza-form" class="form-only form-one" method="post" action="<?php echo site_url();?>admin/updateUserdetails" enctype="multipart/form-data">
             <div class="card-header">Edit User</div>
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
				<div class="row">
							<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
							<div class="col-lg-12 conf">
								<div class="row">
									<div class="col-lg-4">
									<div class="form-group">
										<label>First Name  <span class="mndtry">*</span></label>
										<input type="text" pattern="[a-zA-Z ]+" title="[a-zA-Z ]+"  class="form-control" placeholder="First Name" name="fname" id="fname" value="<?php echo isset($groupuser[0]['fname'])?$groupuser[0]['fname']:"";?>" required="true"/>
										<input type = "hidden" value = "<?php echo isset($groupuser[0]['id'])?$groupuser[0]['id']:"";?>" name = "id"/>

									</div>
									<div class="form-group">
										<label>Last Name  <span class="mndtry">*</span></label>
										<input type="text" pattern="[a-zA-Z ]+" title="[a-zA-Z ]+"  class="form-control" placeholder="Last Name" name="lname" id="lname" value="<?php echo isset($groupuser[0]['lname'])?$groupuser[0]['lname']:"";?>" required="true"/>
									</div>
									<div class="form-group">
										<label>Email  <span class="mndtry">*</span></label>
										<input  pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" title="example@domain.com" type="email" class="form-control" placeholder="email@example.com" name="email_id" id="email_id" value="<?php echo isset($groupuser[0]['email_id'])?$groupuser[0]['email_id']:"";?>" required="true"/>
									</div>
								</div>
								<div class="col-lg-4">
									<div class="form-group">
										<label>Phone <span class="mndtry">*</span></label>
										<input type="text" class="form-control" placeholder="Phone" name="phone" id="phone" value="<?php echo isset($groupuser[0]['phone'])?$groupuser[0]['phone']:"";?>" required="true"/>
									</div>
									<?php

										if($groupuser[0]['group_id'] !=NULL){
											?>
										<div class="form-group">
										<label>Group</label>
										<select class="form-control selectpicker" name="group_id" id="group_id">
											<option value="0">Select Group</option>
											<?php

													if(sizeof($groups)>0)
												   {
													$counter =1;
													foreach($groups as $group)
													{

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

											<?php
											}

										?>
									<div class="form-group">
										<label>Role <span class="mndtry">*</span></label>
										<select class="form-control selectpicker" name="role_id" id="role_id" required="true">
											<option value="0">-- Select --</option>
											<?php

											if(sizeof($roles)>0)
											{
												foreach($roles as $rid=>$rname)
												{
													if($rid == $groupuser[0]['role_id'])
													{
														?>
													<option selected="selected" value="<?php echo $rid;?>"><?php echo $rname;?></option>
													<?php
													}
													else
													{
													?>
													<option value="<?php echo $rid;?>"><?php echo $rname;?></option>
													<?php
													}

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
											<br/>
											<div class="switch-box">Receive Group Notifications
                                    <span class="switch-btn">
                                   <?php
												if(!empty($groupuser)){
														if($groupuser[0]['group_notification'] == 1)
													{

														echo '<input type="checkbox" name="group_notification" id="group_notification" checked/>';

													}
													elseif($groupuser[0]['group_notification'] == 0)
													{
														echo '<input type="checkbox" name="group_notification" id="group_notification">';
													}
													}


												?><label for="group_notification">Toggle</label></span>
                                </div>
                                <div class="switch-box">Use Light Theme
                                    <span class="switch-btn"><?php
													if(!empty($groupuser)){
														if($groupuser[0]['theme'] == 1)
														{

															echo '<input type="checkbox" name="group_theme" id="group_theme" checked/>';

														}
														elseif($groupuser[0]['theme'] == 0)
														{
															echo '<input type="checkbox" name="group_theme" id="group_theme">';
														}
													}

												?><label for="group_theme">Toggle</label></span>
                                </div>


										</div>
										<div class="col-lg-4">
											<?php $img = $this->common_model->getUsersImage($groupuser[0]['id']);


												if(sizeof($img)<=0)
												{
												?>
												<img class="groupimg img-circle" id="imgdiv" src="<?php echo site_url();?>public/site/main/images/user.png">
												<?php
												}
												else
												{
												?>
												<img  id="imgdiv" src="<?php echo site_url();?>public/site/main/group_pics/<?php if(!empty($img[0])){echo $img[0]['name'];}?>" class="groupimg img-circle">
												<?php
												}
											?>


											<input style="width:0px;height:0px;" type="file" name="groupfile" id="groupfile" class="groupfile"/>
											<a href="javascript:void(0);" id="uploadprofilepic">Upload Image</a>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label>Time Zone <span class="mndtry">*</span></label>
												<select id="timezone" name="timezone" class="form-control selectpicker"  required="true">
													<option value="0">Time Zone</option>
													<?php
														$timezone = $this->common_model->getAllTimezone();
														if(!empty($timezone)){
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
										 <?php
										 if($groupuser[0]['timeformat'] != "")
										 {
										 	if($groupuser[0]['timeformat'] == 12)
										 	{
												?>
											 	<option selected="selected" value="12">12 hours</option>
											   <option value="24">24 hours</option>
										 	<?php
											}
											elseif($groupuser[0]['timeformat'] == 24)
										 	{
												?>
											 	<option value="12">12 hours</option>
											   <option selected="selected" value="24">24 hours</option>
										 	<?php
											}
										 }
										 else
										 {
										 	?>
										 	<option value="12">12 hours</option>
										   <option value="24">24 hours</option>
										 	<?php
										 }
										 ?>

									</select>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label>Password</label>
												<input type="password" class="form-control" name="password" id="password" />
											</div>
										</div>
										<div class="col-lg-6">
											<div class="form-group">
												<label>Confirm Password</label>
												<input type="password" class="form-control" name="passwordagain" id="passwordagain"/>
											</div>
										</div>
									</div>
								</div>
								</div>

							</div>
					</div>
				</div>
        <div class="card-footer">
					<button class="btn btn-sm btn-primary" type="submit">Update</button>
						<button class="btn btn-sm btn-danger" type="reset">Reset</button>
						</div>
            </form>
			</div>
		</div>
	</div>
</main>
