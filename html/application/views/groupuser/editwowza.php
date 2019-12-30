<?php $this->load->view('groupuser/navigation.php');?>
<?php $this->load->view('groupuser/leftsidebar.php');?>

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
								
								
								<form id="wowza-form" class="form-only form-one" method="post" action="<?php echo site_url();?>groupuser/updateConfiguration" enctype="multipart/form-data">
									<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
											<div class="wowza-form col-lg-12 conf shadow" id="wowza_form ">		
									<div class="sav-btn-dv wowza-save">
										
										<?php 
											$userdata =$this->session->userdata('user_data');
											//echo "<pre>";
											//print_r($userdata);die;
											$checkstatus = $this->common_model->checkWowzaStatus($userdata['userid']);
											//echo "<pre>";
											//print_r($checkstatus->create_wowza);die;
											if($checkstatus->edit_wowza == 0){
											?>
											<div class = "tool-tip-hover tool-tip-hover1">
											<button type="submit" class="btn-def save not-active">
												<span>Update</span>
												<span class="tool-msg">Sorry permission not allowed!</span>
											</button>
											</div>
											<?php
												}else{
											?>
											
											<button type="submit" class="btn-def save">
												<span><i class="fa fa-save"></i> Update</span>
											</button>
											<?php
											}
										?>
										
									</div>
								</div>
									<input type = "hidden" name = "appid" value = "<?php echo $wovzData[0]['id'];?>"
									<div class="row">
									
									<div class="col-lg-4 col-md-12">
										<div class="form-group">
											<label>WSE Instance Name <span class="mndtry">*</span></label>
											<input type="text" class="form-control" placeholder="Wowza Streaming Engine" name="wse_instance_name" value = "<?php echo $wovzData[0]['wse_instance_name'];?>"id="wse_instance_name">
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-md-4 xxl-only xtramargin">
													<label>IP Address <span class="mndtry">*</span></label>
													<input type="text" class="form-control" placeholder="127.0.0.1" name="ip_address" value="<?php echo $wovzData[0]['ip_address'];?>" id="ip_address">
												</div>
												<div class="col-md-4 xxl-only xtramargin">
													<label>Stream Name <span class="mndtry">*</span></label>
													<input type="text" class="form-control" value="<?php echo $wovzData[0]['stream_name'];?>" placeholder="myStream" name="stream_name" id="stream_name" required="true">
												</div>
												<div class="col-md-4 xxl-only">
													<label>RTMP Port <span class="mndtry">*</span></label>
													<input type="text" class="form-control" placeholder="1935" value="<?php echo $wovzData[0]['rtmp_port'];?>" name="rtmp_port" id="	rtmp_port" required="true">
												</div>
											</div>
										</div>
										<div class="form-group">
											<label>License Keys <span class="mndtry">*</span></label>
											<input type="text" class="form-control" value="<?php echo $wovzData[0]['licence_key'];?>" placeholder="XXXXX-XXXXX-XXXXX-XXXXX-XXXXX-XXXXX" name="licence_key" id="licence_key">
										</div>
									</div>
									<div class="col-lg-4 col-md-12">
										<div class="form-group">
											<label>Installation Directory <span class="mndtry">*</span></label>
											<input type="text" class="form-control" value="<?php echo $wovzData[0]['installation_directory'];?> " placeholder="/usr/local/WowzaStreamingEngine" name="installation_directory" id="installation_directory"/>
										</div>
										<div class="form-group">
											<label>VOD Directory <span class="mndtry">*</span></label>
											<input type="text" class="form-control" value="<?php echo $wovzData[0]['vod_directory'];?>" placeholder="/home/wse_ondemand" name="vod_directory" id="vod_directory">
										</div>
										<div class="form-group">
											<label>Connection Limit (0 for unlimited) <span class="mndtry">*</span></label>
											<input type="text" class="form-control" value="<?php echo $wovzData[0]['connection_limit'];?>" placeholder="0" name="connection_limit" id="connection_limit">
										</div>
									</div>
									<div class="col-lg-4 col-md-12">
										<div class="form-group">
											<label>WSE Administrator User Name <span class="mndtry">*</span></label>
											<input type="text" class="form-control"value="<?php echo $wovzData[0]['rtmp_port'];?>" placeholder="Admin"  name="wse_administrator_username" id="wse_administrator_username" required="true">
										</div>
										
										<div class="form-group">
											<label>WSE Administrator Password</label>
											<input type="password" class="form-control" placeholder="**********" name="wse_administrator_pssword" value="<?php echo $wovzData[0]['rtmp_port'];?>" id="wse_administrator_pssword" required="true">
										</div>
										<div class="form-group">
											<div class="row">
												<div class="col-md-4 xxl-only xtramargin">
													<label>WSE CP Port <span class="mndtry">*</span></label>
													<input type="text" value="<?php echo $wovzData[0]['wse_cp_port'];?>" class="form-control" placeholder="8088" name="wse_cp_port" id="wse_cp_port">
												</div>
												<div class="col-md-4 xxl-only xtramargin">
													<label>Java API Port <span class="mndtry">*</span></label>
													<input type="text" value="<?php echo $wovzData[0]['java_api_port'];?>" class="form-control" placeholder="8089" name="java_api_port" id="java_api_port" required="true">
												</div>
												<div class="col-md-4 xxl-only">
													<label>REST API Port <span class="mndtry">*</span></label>
													<input type="text" class="form-control" placeholder="8089" name="rest_api_port" id="rest_api_port" required="true" value="<?php echo $wovzData[0]['rest_api_port'];?>">
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
																	if($wovzData[0]['group_id'] == $group['id'])
																	{
																		echo '<option selected="selected" value="'.$group['id'].'">'.$group['group_name'].'</option>';
																	}
																	else
																	{
																		echo '<option value="'.$group['id'].'">'.$group['group_name'].'</option>';
																	}
																}
															}
														?>
													</select>
												</div>
												<div class="col-lg-4" style="text-align: center;">
													<?php
														if($wovzData[0]['wowza_image'] != "")
														{ 
														?>
														<img width="49px" height="49px" id="imgdiv" src="<?php echo site_url();?>assets/site/main/wowza_logo/<?php echo $wovzData[0]['wowza_image'];?>">
														<?php	
														}
														else
														{
														?>
														<img id="imgdiv" src="<?php echo site_url();?>assets/site/main/images/logo1.png">
														<?php	
														}
													?>
													
													<input style="width:0px;height:0px;" type="file" name="groupfile" id="groupfile" class="groupfile" required="true">
													<a href="javascript:void(0);" id="uploadprofilepic">Upload New Icon</a>
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
	</div>
</div>

</section>

<style>
	.tool-msg{display:none;} 
	.tool-tip-hover{display:inline-block;position:relative;}
	.tool-tip-hover:hover .tool-msg{display:block;position:absolute;top: 8px;
    left: 105%;
    color: #fff;
    background: #000;
    padding: 10px 20px;
    font-size: 11px;}
.tool-tip-hover1:hover .tool-msg{display: inline-block;
    position: absolute;
    top: 83%!important;
    color: #fff;
    background: #000;
    padding: 10px 20px;
    font-size: 11px;
    left: -40px;
    z-index: 1;}	
	.not-active {
	pointer-events: none;
	cursor: default;
	text-decoration:none;
	color:black;
	}
	
	.tool-tip-hover.tool-tip-hover1{
	float:right;
	}
	.tool-tip-hover.tool-tip-hover1 button[type="submit"]{
	color:#ffffff;
	}
	
	</style>