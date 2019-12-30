<?php $this->load->view('guser/navigation.php');?>
<?php $this->load->view('guser/leftsidebar.php');?>
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
						<form id="wowza-form" class="action-table" method="post" action="<?php echo site_url();?>admin/saveGroup" enctype="multipart/form-data">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">	
				
					<div class="col-lg-12">
						<div class="row">
							     <button type="submit" class="btn-def save">
									<span>Save</span>
								</button>
						</div>
					</div>
					<div class="col-lg-12"><div class="row"><hr></div></div>
					<div class="col-lg-4">
						<div class="form-group">
							<label>Group Name <span class="mndtry">*</span></label>
							<input type="text" class="form-control" placeholder="Group Name" name="group_name" id="group_name" required="true"/>
						</div>
						<div class="form-group">
							<label>Website <span class="mndtry">*</span></label>
							<input type="text" class="form-control" placeholder="kurrent.tv" name="group_website" id="group_website" required="true"/>
						</div>
						<div class="form-group">
							<label>Email<span class="mndtry">*</span></label>
							<input type="email" class="form-control" placeholder="info@urrent.tv" name="group_email" id="group_email" required="true"/>
						</div>
						<div class="form-group">
							<label>Phone<span class="mndtry">*</span></label>
							<input type="text" class="form-control" placeholder="111-222-333" name="group_phone" id="group_phone" required="true"/>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="form-group">
							<label>Address<span class="mndtry">*</span></label>
							<input type="text" class="form-control" placeholder="Address" name="group_address" id="group_address" required="true"/>
						</div>
						<div class="form-group">
							<label>Zip / Postal Code<span class="mndtry">*</span></label>
							<input type="text" class="form-control" placeholder="Zip or Postal Code" name="group_postal_code" id="group_postal_code" required="true"/>
						</div>
						<div class="form-group">
							<label>City<span class="mndtry">*</span></label>
							<input type="text" class="form-control" placeholder="City" name="group_city" id="group_city" required="true"/>
						</div>
						<div class="form-group">
							<label>Country<span class="mndtry">*</span></label>
							<select class="form-control selectpicker" name="group_country" id="group_country" required="true">
								<option value="0">Country</option>
								<?php 
								$countries = $this->common_model->getCountries();
								if(sizeof($countries)>0)
								{
									foreach($countries as $country)
									{
										?>
										<option value="<?php echo $country['id'];?>"><?php echo $country['country_name'];?></option>
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
                                   <input type="checkbox" id="group_notification" name="group_notification" />
                                    <label for="switch">Toggle</label></span></div>								
								<div class="row">
									<div class="col-lg-7 cat margintop">
										<label>Admins</label><br>
										<a href="javascript:void(0);">2 Show Admins</a><br>
										<a href="javascript:void(0);"><i class="fa fa-plus"></i> Add New Admin</a>
										<br>
										<label>Assigned Resources</label><br>
										<a href="javascript:void(0);">2 Wowza 1 FTP</a><br>
										<a href="javascript:void(0);"><i class="fa fa-plus"></i> Manage Resources</a>
									</div>
									<div class="col-lg-5 cat margintop">
										<label>Users</label><br>
										<a href="javascript:void(0);">2 Show Users</a><br>
										<a href="javascript:void(0);"><i class="fa fa-plus"></i> Add New User</a>
									</div>
								</div>
							</div>
							<div class="col-lg-4">
								<img id="imgdiv" src="<?php echo site_url();?>assets/site/main/images/dummy3.png">
								<input style="width:0px;height:0px;" type="file" name="groupfile" id="groupfile" class="groupfile" />
								<a href="javascript:void(0);" id="uploadprofilepic">Upload Image</a>
								
							</div>
							
							<div class="col-lg-12">
							<br/><br/>
								<div class="form-group m-t-5">
									<label>License</label>
									<input type="text" class="form-control" placeholder="License" name="group_licence" id="group_licence" />
									<a style="color:#ffc704;float: right;">{Live Stream},{VOD},{Playlist}</a>
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