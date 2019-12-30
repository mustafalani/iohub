<?php $this->load->view('guser/navigation.php');?>
<?php $this->load->view('guser/leftsidebar.php');?>
<section class="content-wrapper">
  <!-- ========= Main Content Start ========= -->
  <div class="content">
    <div class="content-container">
			<div class="row">
			
			<div class="col-lg-12 col-12-12">			
	            <div class="content-box config-contentonly">
	            <div class="config-container">
	            	<form class="form-only form-one" method="post" action="<?php echo site_url();?>admin/saveeditTarget" enctype="multipart/form-data">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
	 
	  <div class="sav-btn-dv wowza-save">
						<button type="submit" class="btn-def save btntop2">
							<span><i class="fa fa-save"></i> Update</span>
						</button>
						<?php 
						$socialLogin = $this->session->userdata('socialLogin');	
						if(sizeof($socialLogin) > 0)
						{
						?>
						<a href="<?php echo site_url();?>admin/cancelProvider" class="btn btn-danger btntop2" style="float:right;margin-right:8px;height:39px;">
							<span><i class="fa fa-remove"></i> Cancel</span>
						</a>
						<?php	
						}
						?>
						
					</div>
				<div class="col-lg-12 conf min-h-64 shadow">
					<div class="row">
						<div class="col-lg-6 p-t-15">						
							<div class="form-group col-lg-9">
								<div class="row">
									<label>Target Name</label>
									<input type="text" class="form-control" placeholder="" name="target_name" id="target_name" value="<?php echo $target[0]["target_name"];?>">
								</div>
							</div>
							<div class="form-group col-lg-9">
								<div class="row">
									<label>Select Application</label>
									<select class="form-control select" name="wowzaengin" id="wowzaengin" onchange="showApplicationURL(this.value);"> 
										<option value="0">Select</option>          
										 <?php 
											$apps = $this->common_model->getAllApplications();    
											if(sizeof($apps)>0)
											{
												foreach($apps as $app)
												{				
													if($app['id'] == $target[0]{"wowzaengin"})	
													{
														echo '<option selected="selected" value="'.$app['id'].'">'.$app['application_name'].'</option>';											
													}	
													else
													{
														echo '<option value="'.$app['id'].'">'.$app['application_name'].'</option>';												
													}				
												}
											}
											?>	
									</select>
								</div>
							</div>
							<div class="form-group col-lg-9">
								<div class="row">
									<input type="text" class="form-control" placeholder="" name="streamurl" id="streamurl" readonly="true" value="<?php echo $target[0]["streamurl"];?>">
								</div>
							</div>
							<div class="col-lg-3">
								<button type="button" class="btn btn-edit" onclick="enableEdit();">Edit</button>
							</div>

							
						
						</div>
						<div class="col-lg-6 p-t-15" id="facebookTargetFields">
						
						<input type="hidden" value="<?php if(!empty($youtubeData)) echo $youtubeData['cdn']->ingestionInfo['streamName']; else echo "";?>" id="googlestream" name="googlestream"/>
								<?php if($this->session->flashdata('success')){ ?>
								<div class="alert alert-success" style="float:left;width: 100%;">
									<a href="#" class="close" data-dismiss="alert">&times;</a>
									<strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
								</div>
								<?php }else if($this->session->flashdata('error')){  ?>
								<div class="alert alert-danger" style="float: left;width: 100%;">
									<a href="#" class="close" data-dismiss="alert">&times;</a>
									<strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
								</div>
								<?php }else if($this->session->flashdata('warning')){  ?>
								<div class="alert alert-warning" style="float: left;width: 100%;">
									<a href="#" class="close" data-dismiss="alert">&times;</a>
									<strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
								</div>
								<?php }else if($this->session->flashdata('info')){  ?>
								<div class="alert alert-info" style="float: left;width: 100%;">
									<a href="#" class="close" data-dismiss="alert">&times;</a>
									<strong>Info!</strong> <?php echo $this->session->flashdata('info'); ?>
								</div>
							<?php } ?>
						
							
											
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Title</label>
									<input type="text" class="form-control" placeholder="Title of the live video post" name="title" id="title" value="<?php echo $target[0]["title"];?>">
								</div>
							</div>
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Description</label>
									<textarea class="form-control" rows="4" id="description" name="description"><?php echo $target[0]["description"];?></textarea>
								</div>
							</div>
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Continuous Live</label><br>
									<label class="checkbox-inline">
									<?php 
									if($target[0]["continuelive"] == 0)
									{
									?>
										<input type="checkbox" id="continuelive" name="continuelive">
									<?php	
									}
									elseif($target[0]["continuelive"] == 1)
									{
										?>
										<input type="checkbox" checked="true" id="continuelive" name="continuelive">
										<?php
									}
									?>
									
										Send a continuous live stream
									</label>
								</div>
							</div>
						</div>
						
						
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