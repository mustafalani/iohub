
<style>
	
	.not-active {
	pointer-events: none;
	cursor: default;
	text-decoration:none;
	color:black;
	}
	
	
</style>
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
				
				<div class="col-xs-12">
					<div class="tab-btn-container">
						<ul class="nav nav-tabs" role="tablist">
							<li role="presentation" class="active"><a href="#systems" aria-controls="systems" role="tab" data-toggle="tab">Update Application</a></li>	                  
						</ul>	                
					</div>
					<div class="box-header">
						<div class="wowza-form" id="wowza_form">
							<form class="form-only form-one" method="post" action="<?php echo site_url();?>groupuser/updateApplication/<?php echo $this->uri->segment(3);?>" enctype="multipart/form-data">
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
								
								<div class="col-lg-8 col-md-12">
                                    <div class="form-group col-lg-9">
										<div class="row">
											<label>Application Name</label>
											<input type="text" class="form-control" placeholder="PL-FB-LIVE" name="application_name" id="application_name" required="true" value="<?php echo $application[0]['application_name'];?>">
										</div>
									</div>
                                    <div class="form-group col-lg-9">
										<div class="row">
											<label>Live Source</label>
											<select id="live_source" name="live_source" class="form-control" onchange="showAddress(this.value);" required="true">
												<option value="0">Wowza Engine</option>
												<?php 
													$wowzaz = $this->common_model->getAllWowza();                  			
													if(sizeof($wowzaz)>0)
													{
														foreach($wowzaz as $wowza)
														{
															if($application[0]['live_source'] == $wowza['id'])
															{
																echo '<option selected="selected" value="'.$wowza['id'].'">'.$wowza['wse_instance_name'].'</option>';		
															}
															else
															{
																echo '<option value="'.$wowza['id'].'">'.$wowza['wse_instance_name'].'</option>';			
															}
														}
													}
												?> 
											</select>
										</div>
									</div>
                                    <div class="form-group col-lg-9">
										<div class="row">
											<input type="text" class="form-control" name="wowza_path" id="block" value="<?php echo $application[0]['wowza_path'];?>"/>
										</div>
									</div>
                                    <div class="col-lg-3">
										<button class="btn  btn-edit btn-sm">Edit</button>
									</div>
									<div class="form-group col-lg-9" style="padding-left:0;">
										<div class="tool-tip-hover">
										<?php 
											$userdata =$this->session->userdata('user_data');
											//echo "<pre>";
											//print_r($userdata);die;
											$checkstatus = $this->common_model->checkWowzaStatus($userdata['userid']);
											//echo "<pre>";
											//print_r($checkstatus->edit_application);die;
											if($checkstatus->edit_application == 0){
											?>
											
											<button type="submit" data-toggle="tooltip" title="Hooray!" class="btn-def save not-active" style="float:left;">
												<span>
													<i class="fa fa-save"></i>
													Update
												</span>
												<span class="tool-msg">Sorry permission not allowed!</span>
											</button>
											
											<?php 
												
												}else{
											?>
											
											<button type="submit" class="btn-def save" style="float:left;">
												<span>
													<i class="fa fa-save"></i>
													Update
												</span>
											</button>
											<?php
												
											}
										?>
										</div>
									</div>
                                    
								</div>
								<div class="col-lg-4 pdright">
									<video width="100%" height="280" controls style="border:1px solid;"></video>
								</div>
								
                                
								
							</form>
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
	
	
	.tool-tip-hover:hover .tool-msg{display:inline-block;position:absolute;top: 8px;
    left: 105%;
    color: #fff;
    background: #000;
    padding: 5px;
    font-size: 11px;width: 300px;}
	
	</style>
