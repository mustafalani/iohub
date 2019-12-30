<?php $this->load->view('gadmin/navigation.php');?>
<?php $this->load->view('gadmin/leftsidebar.php');


?>
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
				<form id="wowza-form" class="form-only form-one" method="post" action="<?php echo site_url();?>admin/updateGroupDetails/<?php echo $this->uri->segment(3);?>" enctype="multipart/form-data">
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
			</div>
			</div>
		</section>