<?php $this->load->view('group/navigation.php');?>
<?php $this->load->view('group/leftsidebar.php');?>
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
			<div class="col-xs-12">
               <div class="box-header">
                 <div class="wowza-form" id="wowza_form">
			
			
			<form id="wowza-form" class="form-only form-one" method="post" action="<?php echo site_url();?>groupadmin/saveConfiguration" enctype="multipart/form-data">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
      <div class="row">
                                                    <div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                            <label>WSE Instance Name <span class="mndtry">*</span></label>
                                                            <input type="text" class="form-control" placeholder="Wowza Streaming Engine" name="wse_instance_name" id="wse_instance_name">
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-12 xxl-only xtramargin">
                                                                    <label>IP Address <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="127.0.0.1" name="ip_address" id="ip_address">
                                                                </div>
                                                                <div class="col-md-12 xxl-only xtramargin">
                                                                    <label>Stream Name <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="myStream" name="stream_name" id="stream_name" required="true">
                                                                </div>
                                                                <div class="col-md-12 xxl-only">
                                                                    <label>RTMP Port <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="1935" name="rtmp_port" id="	rtmp_port" required="true">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>License Keys </label>
                                                            <input type="text" class="form-control" placeholder="XXXXX-XXXXX-XXXXX-XXXXX-XXXXX-XXXXX" name="licence_key" id="licence_key">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                            <label>Installation Directory </label>
                                                            <input type="text" class="form-control" placeholder="/usr/local/WowzaStreamingEngine" name="installation_directory" id="installation_directory"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>VOD Directory </label>
                                                            <input type="text" class="form-control" placeholder="/home/wse_ondemand" name="vod_directory" id="vod_directory">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Connection Limit (0 for unlimited) </label>
                                                            <input type="text" class="form-control" placeholder="0" name="connection_limit" id="connection_limit">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                            <label>WSE Administrator User Name <span class="mndtry">*</span></label>
                                                            <input type="text" class="form-control" placeholder="Admin"  name="wse_administrator_username" id="wse_administrator_username" required="true">
                                                        </div>

                                                        <div class="form-group">
                                                            <label>WSE Administrator Password</label>
                                                            <input type="password" class="form-control" placeholder="**********" name="wse_administrator_pssword" id="wse_administrator_pssword" required="true">
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-12 col-lg-6 xxl-only2 sml-marg">
                                                                    <label>WSE CP Port <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="8088" name="wse_cp_port" id="wse_cp_port">
                                                                </div>
                                                               
                                                                 <div class="col-md-12 col-lg-4 xxl-only2 sml-marg">
                                                                    <label>Java API Port <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="8089" name="java_api_port" id="java_api_port" required="true">
                                                                </div>
                                                                <div class="col-md-12 col-lg-4 xxl-only2 sml-marg">
                                                                    <label>REST API Port <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="8089" name="rest_api_port" id="rest_api_port" required="true">
                                                                </div>  
                                                            </div>
                                                        </div>
														 <div class="form-group">
                                                                    <div class="row">
                                                                            <div class="col-md-8">
                                                                            <label>Assigned to</label>
                                                                            <select class="form-control select" name="group_id" id="group_id">
                                                                                <option>None</option>
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
                                                                    <div class="col-lg-4" style="text-align: center;">
                                                                        <img id="imgdiv" src="<?php echo site_url();?>assets/site/main/images/logo1.png">
                                                                        <input style="width:0px;height:0px;" type="file" name="groupfile" id="groupfile" class="groupfile" required="true">
                                                                        <a href="javascript:void(0);" id="uploadprofilepic">Upload New Icon</a>
                                                                    </div>
                                                                    </div>
                                                                </div>
                                                    </div>
                                                </div>
			<div class="wowza-form col-lg-12 conf shadow" id="wowza_form ">
			
								
								<div class="col-lg-12 sav-btn-dv">
									             <button type="submit" class="btn-def save">
									<span><i class="fa fa-save"></i> Save</span>
								</button>
								</div>
							</div>
						</form>
						</div>
						</div>
						</div>
			</div>
			</div>
			</div>
			</div>
			
		</section>