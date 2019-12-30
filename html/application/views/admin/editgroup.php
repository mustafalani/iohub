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
        <li class="breadcrumb-item active"><?php echo $groupdata[0]['group_name'];?></li>
      </ol>
      <div class="container-fluid">
      	<div class="animated fadeIn">
           <div class="card">
						 <form id="wowza-form"  class="action-table"  method="post" action="<?php echo site_url();?>admin/updateGroupDetails/<?php echo $this->uri->segment(2);?>" enctype="multipart/form-data">
						 <div class="card-header">Edit Group</div>
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
					<div class="content-box config-contentonly">

      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
					<div class="row">
						<div class="col-lg-4">
						<div class="form-group">
							<label>Group Name <span class="mndtry">*</span></label>
							<input type="text" class="form-control" placeholder="Group Name" name="group_name" value="<?php echo $groupdata[0]['group_name'];?>" required="true"/>

						</div>
						<div class="form-group">
							<label>Website <span class="mndtry">*</span></label>
							<input type="text" class="form-control" placeholder="www.example.com" name="group_website" id="group_website" value="<?php echo $groupdata[0]['group_website'];?>" required="true"/>
						</div>
						<div class="form-group">
							<label>Email <span class="mndtry">*</span></label>
							<input type="email" class="form-control" placeholder="email@example.com" name="group_email" id="group_email"  value="<?php echo $groupdata[0]['group_email'];?>" required="true"/>
						</div>
						<div class="form-group">
							<label>Phone <span class="mndtry">*</span></label>
							<input type="text" class="form-control" placeholder="111-222-333" name="group_phone" id="group_phone" value="<?php echo $groupdata[0]['group_phone'];?>" required="true"/>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label>Address <span class="mndtry">*</span></label>
							<input type="text" class="form-control" placeholder="Address" name="group_address" id="group_address" value="<?php echo $groupdata[0]['group_address'];?>" required="true"/>
						</div>
						<div class="form-group">
							<label>Zip / Postal Code <span class="mndtry">*</span></label>
							<input type="text" class="form-control" placeholder="Zip or Postal Code" name="group_postal_code" id="group_postal_code" value="<?php echo $groupdata[0]['group_postal_code'];?>"  required="true"/>
						</div>
						<div class="form-group">
							<label>City <span class="mndtry">*</span></label>
							<input type="text" class="form-control" placeholder="City" name="group_city" id="group_city" value="<?php echo $groupdata[0]['group_city'];?>" required="true"/>
						</div>
						<div class="form-group">
							<label>Country <span class="mndtry">*</span></label>
							<select class="form-control selectpicker" name="group_country" id="group_country" required="true">
								<option value="">-- Select --</option>
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


							<label class="prefer-text">Prefrences</label>
								 <div class="switch-box">Receive Global Newsletter
                                    <span class="switch-btn">
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
                                    <label for="group_notification">Toggle</label>
                                    </span></div>


								<div class="row">
									<div class="col-lg-7 cat">
										<label>Admins</label><br>
										<a href="javascript:void(0);">0 Show Admins</a><br>
										<a href="<?php echo site_url();?>createuser/2/<?php echo $this->uri->segment(2);?>"><i class="fa fa-plus"></i> Add New Admin</a>
										<br>
										<label>Assigned Resources</label><br>
										<a href="<?php echo site_url();?>configuration">

										<?php
											echo sizeof($this->common_model->getGroupWowaas($groupdata[0]['id']));
										?>
										Wowza
										</a><br/>
										<a href="<?php echo site_url();?>configuration">

										<?php
											echo sizeof($this->common_model->getGroupEncoders($groupdata[0]['id']));
										?>
										Encoders
										</a> <br>
									</div>
									<div class="col-lg-5 cat">
										<label>Users</label><br>
										<a href="javascript:void(0);">0 Show Users</a><br>
										<a href="<?php echo site_url();?>createuser/3/<?php echo $this->uri->segment(2);?>"><i class="fa fa-plus"></i> Add New User</a>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
							<?php $img = $this->common_model->getGgoupImage($groupdata[0]['id']);

												if(sizeof($img) <= 0)
												{
												?>
												<img class="groupimg img-circle" id="imgdiv" src="<?php echo site_url();?>public/site/main/images/dummy3.png">
												<?php
												}
												else
												{
												?>
												<img class="groupimg img-circle"  id="imgdiv" src="<?php echo site_url();?>public/site/main/group_pics/<?php echo $img[0]['name'];?>">
												<?php
												}
											?>


								<input style="width:0px;height:0px;" type="file" name="groupfile" id="groupfile" class="groupfile"  />


								<a href="javascript:void(0);" id="uploadprofilepic">Upload Image</a>

							</div>
							<div class="col-lg-12">
								<div class="form-group m-t-5">
									<label>License</label>
									<input type="text" class="form-control" placeholder="License" name="group_licence" id="group_licence"  value="<?php echo $groupdata[0]['group_licence'];?>" />
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
					<button class="btn btn-sm btn-primary" type="submit">Update</button>
						<button class="btn btn-sm btn-danger" type="reset">Reset</button>
						</div>
						</form>
			</div>
		</div>
	</div>
</main>
