<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<main class="main">
  	   <!-- Breadcrumb-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Home</a>
        </li>
        <li class="breadcrumb-item active"><a href="configuration">Settings</a></li>
        <li class="breadcrumb-item active">New Nebula</li>
      </ol>
      <div class="container-fluid">
      	<div class="animated fadeIn">
           <div class="card">
           	<form id="wowza-form" class="action-table" method="post" action="<?php echo site_url();?>admin/saveNebula" enctype="multipart/form-data">

             <div class="card-header">Add New Nebula</div>
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


							    <!-- <button type="submit" class="btn-def save btn btn-primary float-right">
									<span>Save</span>
								</button>-->


					<div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                            <label>Nebula Engine Name <span class="mndtry">*</span></label>
                                                            <input type="text" name="encoder_name" id="encoder_name" class="form-control" required="true"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label>IP Address <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control" value="127.0.0.1" id="encoder_ip" name="encoder_ip" required="true"/>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Port <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control" value="22" id="encoder_port" name="encoder_port" required="true"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label>Administrator User Name <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Admin"  id="encoder_uname" name="encoder_uname" required="true">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Administrator Password <span class="mndtry">*</span></label>
                                                                    <input type="password" class="form-control" id="encoder_pass" name="encoder_pass" required="true">
                                                                </div>
                                                            </div>
                                                        </div>
														<div class="form-group">
											<label>Media Directory
																<span class="mndtry">*</span></label>
											<input type="text" name="parh_setting" id="parh_setting" class="form-control" required="true"/>
														</div>
                                                    </div>

												<div class="col-lg-4 col-md-12">
                                                    <div class="form-group">
                                                    	<?php                                                    
                                                    	if($userdata['user_type']==1)
                                                    	{
															?>
															 <div class="col-md-8 pl-0">
                                                                            <label>Assigned to</label>
                                                                            <select class="form-control selectpicker" name="encoder_group" id="encoder_group">
                                                                                <option value="0">-- Select --</option>
                                                                                <?php
																					if(sizeof($groups)>0)
																					{
																						$counter =1;
																						foreach($groups as $group)
																						{
																							?>
																							<option value="<?php echo $group['id'];?>"><?php echo $group['group_name'];?></option>
																							<?php
																						}
																					}
																				?>
                                                                            </select>
                                                                        </div>
															<?php
														}
														else
														{
														?>
														 <div class="col-md-8 dnone  pl-0">
                                                                            <label>Assigned to</label>
                                                                            <select class="form-control selectpicker" name="encoder_group" id="encoder_group">
                                                                                <option value="0">-- Select --</option>
                                                                                <?php
																					if(sizeof($groups)>0)
																					{
																						$counter =1;
																						foreach($groups as $group)
																						{
																							?>
																							<option value="<?php echo $group['id'];?>"><?php echo $group['group_name'];?></option>
																							<?php
																						}
																					}
																				?>
                                                                            </select>
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
        <div class="card-footer">
	        <button class="btn btn-sm btn-primary" type="submit">Save</button>
	          <button class="btn btn-sm btn-danger" type="reset">Reset</button>
	          </div>


	          </form>
			</div>
		</div>
	</div>
</main>
