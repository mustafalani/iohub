<?php $this->load->view('groupadmin/navigation.php');?>
<?php $this->load->view('groupadmin/leftsidebar.php');?>
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
			<div class="tab-btn-container">
	                <ul class="nav nav-tabs" role="tablist">
	                    <li role="presentation" class="active"><a href="#systems" aria-controls="systems" role="tab" data-toggle="tab">Create Target</a></li>	                  
	                </ul>	                
	            </div>
	            <div class="box-header">
	            
			<form class="form-only form-one" method="post" action="<?php echo site_url();?>groupadmin/saveTarget" enctype="multipart/form-data">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
				<div class="col-lg-12 conf min-h-64 shadow">
					<div class="row">
						<div class="col-lg-6 p-t-15">
							<div class="form-group col-lg-9">
								<div class="row">
									<label>Target Name</label>
									<input type="text" class="form-control" placeholder="PL-FB-LIVE" name="target_name" id="target_name">
								</div>
							</div>
							<div class="form-group col-lg-9">
								<div class="row">
									<label>Select Application</label>
									<select class="form-control select" name="wowzaengin" id="wowzaengin" onchange="showApplicationURL(this.value);"> 
										<option value="0">Select</option>          
										 <?php $userdata = $this->session->userdata('user_data');
											$apps = $this->common_model->getAllApplications($userdata['userid']);    
											if(sizeof($apps)>0)
											{
												foreach($apps as $app)
												{													
													echo '<option value="'.$app['id'].'">'.$app['application_name'].'</option>';															
												}
											}
											?>	
									</select>
								</div>
							</div>
							<div class="form-group col-lg-9">
								<div class="row">
									<input type="text" class="form-control" placeholder="rtmp://192.168.1.11:1953/PL-FB-LIVE/myStream" name="streamurl" id="streamurl">
								</div>
							</div>
							<div class="col-lg-3">
								<button class="btn-def">Edit</button>
							</div>
							<div class="col-lg-12">
								<div class="btns-dv">
									<div class="row">		
										    <div class="cc-selector">
										        <input id="facebook" type="radio" name="target" value="facebook" />
										        <label class="drinkcard-cc visa" for="facebook"></label>
										        <input id="youtube" type="radio" name="target" value="youtube" />
										        <label class="drinkcard-cc mastercard"for="youtube"></label>
										    </div>										
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 p-t-15">
							<div class="form-group col-lg-12 pdright">
								<div class="btns-dv">
									<div class="row">
										<button class="btn btn-sky btn-sm">
											<span>
												<i class="fa fa-facebook"></i>
												Logged In
											</span>
										</button>
									</div>
								</div>
								<div class="row">
									
								</div>
							</div>
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Title</label>
									<input type="text" class="form-control" placeholder="Title of the live video post" name="title" id="title">
								</div>
							</div>
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Description</label>
									<textarea class="form-control" rows="4" id="description" name="description"></textarea>
								</div>
							</div>
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Continuous Live</label><br>
									<label class="checkbox-inline">
									<input type="checkbox" id="continuelive" name="continuelive">
										Send a continuous live stream
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12 sav-btn-dv">
						<button type="submit" class="btn-def save">
							<span><i class="fa fa-save"></i> Save</span>
						</button>
					</div>
					<!-- </div> -->
				</div>
</form>
				</div>
			</div>
			</div>
				</div>
			</div>
			</div>
		</section>