<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
  <!-- ========= Main Content Start ========= -->
  <main class="main">
  	   <!-- Breadcrumb-->
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="#">Home</a>
            </li>
            <li class="breadcrumb-item active"><a href="configuration">Settings</a></li>
            <li class="breadcrumb-item active">New Publisher</li>
          </ol>
          <div class="container-fluid">
  	        <div class="animated fadeIn">
            <div class="card">
            
            	<form id="wowza-form" class="form-only form-one" method="post" action="<?php echo site_url();?>admin/saveConfiguration" enctype="multipart/form-data">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
              <div class="card-header">Add New Publisher</div>
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
                 <div class="config-container" id="wowza_form">


		
	  		<div class="wowza-form col-lg-12 conf pl-0" id="wowza_form ">


								<!--<div class=" sav-btn-dv wowza-save">
									             <button type="submit" class="btn btn-primary add-btn float-right">
									<span>Save</span>
								</button>
								</div>-->
			</div>
      <div class="col-lg-12"><div class="row"><hr></div></div>
      <div class="row action-table">
                                                    <div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                            <label>Publisher Name <span class="mndtry">*</span></label>
                                                            <input type="text" class="form-control" name="wse_instance_name" id="wse_instance_name" required="true"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-4 xxl-only xtramargin">
                                                                    <label>IP Address <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control"  placeholder="127.0.0.1" name="ip_address" id="ip_address" required="true"/>
                                                                </div>
                                                                <div class="col-md-4 xxl-only xtramargin p-0">
                                                                    <label>Stream Name <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="myStream" name="stream_name" id="stream_name" required="true">
                                                                </div>
                                                                <div class="col-md-4 xxl-only">
                                                                    <label>RTMP Port <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="1935" name="rtmp_port" id="rtmp_port" required="true">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>License Keys (Leave Blank for Unmanaged)</label>
                                                            <input type="text" class="form-control" name="licence_key" id="licence_key">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                            <label>Installation Directory (Blank for Default)<span class="mndtry"></span></label>
                                                            <input type="text" class="form-control" name="installation_directory" id="installation_directory"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>VOD Directory (Blank for Default) <span class="mndtry"></span></label>
                                                            <input type="text" class="form-control" name="vod_directory" id="vod_directory">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Connection Limit (Zero for Unlimited)</label>
                                                            <input type="text" class="form-control" value="0" name="connection_limit" id="connection_limit">
                                                        </div>

                                                    </div>
                                                    <div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                            <label>WSE Administrator User Name <span class="mndtry">*</span></label>
                                                            <input type="text" class="form-control" placeholder="Admin"  name="wse_administrator_username" id="wse_administrator_username">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>WSE Administrator Password <span class="mndtry">*</span></label>
                                                            <input type="password" class="form-control" name="wse_administrator_pssword" id="wse_administrator_pssword" required="true">
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                               <div class="col-md-4 xxl-only xtramargin">
                                                                    <label>WSE CP Port <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="8088" name="wse_cp_port" id="wse_cp_port" required="true"/>
                                                                </div>

                                                                <div class="col-md-4 xxl-only xtramargin pl-0">
                                                                    <label>Java API Port <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="8182" name="java_api_port" id="java_api_port" required="true"/>
                                                                </div>
                                                                <div class="col-md-4 xxl-only pl-0">
                                                                    <label>REST API Port <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="8087" name="rest_api_port" id="rest_api_port" required="true">
                                                                </div>
                                                            </div>
                                                        </div>
														 <div class="form-group">
                                                                    <div class="row">
                                                                    	<?php

                                                                    	if($userdata['user_type'] == 1)
                                                                    	{
																			?>
																			 <div class="col-md-8">
                                                                            <label>Assigned to</label>
                                                                            <select class="form-control selectpicker" name="group_id" id="group_id">
                                                                                <option value="0">-- Select --</option>
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
																			<?php
																		}
																		else
																		{
																			?>
																			 <div class="col-md-8 " style="display: none;">
                                                                            <label>Assigned to</label>
                                                                            <select class="form-control selectpicker" name="group_id" id="group_id">
                                                                                <option value="0">-- Select --</option>
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
																			<?php
																		}
                                                                    	?>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                  <div class="row">
                                                                    <div class="col-md-8">
                                                                      <div class="check-input">
                                                                        <div class="boxes">
                                                                          <input type="checkbox" id="enablenetdata" name="netdata" id="netdata">
                                                                          <label for="enablenetdata" style="padding-left:25px;">Enable Netdata Monitoring</label>
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
      <div class="card-footer">
        <button class="btn btn-sm btn-primary" type="submit">Save</button>
          <button class="btn btn-sm btn-danger" type="reset">Reset</button>
          </div>
          
          	</form>
          
			</div>
    </div>
    </div>
</main>
