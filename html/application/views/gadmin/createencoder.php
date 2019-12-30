<?php $this->load->view('gadmin/navigation.php');?>
<?php $this->load->view('gadmin/leftsidebar.php');?>
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
						<form id="wowza-form" class="action-table" method="post" action="<?php echo site_url();?>groupadmin/saveEncoder" enctype="multipart/form-data">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">	
				
					<div class="col-lg-12">
						<div class="row">
							     <button type="submit" class="btn-def save">
									<span>Save</span>
								</button>
						</div>
					</div>
					<div class="col-lg-12"><div class="row"><hr></div></div>
					<div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                            <label>ENCODER NAME <span class="mndtry">*</span></label>
                                                            <input type="text" name="encoder_name" id="encoder_name" class="form-control">
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label>IP Address <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="127.0.0.1" id="encoder_ip" name="encoder_ip">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>SSH Port <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="22" id="encoder_port" name="encoder_port">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">                                                                
                                                                <div class="col-md-6">
                                                                    <label>User Name <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="groupadmin"  id="encoder_uname" name="encoder_uname">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Password</label>
                                                                    <input type="password" class="form-control" placeholder="**********" id="encoder_pass" name="encoder_pass">
                                                                </div>                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                            <label>Hardware</label>
                                                            <select class="form-control selectpicker" name="encoder_hardware" id="encoder_hardware">
                                                                <option value="0">Select</option>
                                                               <?php
                                                                $hardware = $this->common_model->getAllHardware();
                                                                if(sizeof($hardware)>0)
                                                                {
																	foreach($hardware as $hard)
																	{
																		echo '<option value="'.$hard['id'].'">'.$hard['item'].'</option>';
																	}
																}
                                                                ?>
                                                            </select>
                                                        </div>                                                        
                                                        <div class="form-group">
                                                            <label>Model</label>
                                                            <select class="form-control selectpicker" name="encoder_model" id="encoder_model">
                                                                <option value="0">Select</option>
                                                               <?php
                                                                $model = $this->common_model->getAllModels();
                                                                if(sizeof($model)>0)
                                                                {
																	foreach($model as $modl)
																	{
																		if($modl['status'] == 1)
																		{
																			echo '<option value="'.$modl['id'].'">'.$modl['item'].'</option>';	
																		}
																		else if($modl['status'] == 0)
																		{
																			echo '<option disabled="disabled" value="'.$modl['id'].'">'.$modl['item'].'</option>';
																		}
																		
																	}
																}
                                                                ?>
                                                            </select>                                                            
                                                        </div>
                                                         <div class="col-lg-6 col-md-12 pdleft">
                                                            <label>Input</label>
                                                            <select class="form-control " name="encoder_inputs[]" id="encoder_inputs" multiple="multiple">
                                                                <?php
                                                                $inputs = $this->common_model->getEncoderInputs();
                                                                if(sizeof($inputs) > 0)
                                                                {
																	foreach($inputs as $input)
																	{
																		?>
																		<option value="<?php echo $input['id'];?>"><?php echo $input['item'];?></option>
																		<?php
																	}
																}
                                                                ?> 
                                                            </select>                                                            
                                                        </div>
                                                         <div class=" col-lg-6 col-md-12 pdright">
                                                            <label>Output</label>
                                                            <select class="form-control " name="encoder_output[]" id="encoder_output" multiple="multiple">
                                                               <?php
                                                                $outputs = $this->common_model->getEncoderOutput();
                                                                if(sizeof($outputs) > 0)
                                                                {
																	foreach($outputs as $output)
																	{
																		?>
																		<option value="<?php echo $output['id'];?>"><?php echo $output['item'];?></option>
																		<?php
																	}
																}
                                                                ?>
                                                            </select>                                                            
                                                        </div>
                                                    </div>
												<div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="form-group">
                                                                    <div class="row">
                                                                        <div class="col-md-8">
                                                                            <label>Assigned to</label>
                                                                            <select class="form-control selectpicker" name="encoder_group" id="encoder_group">
                                                                                <option>Group Name</option>
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
		</section>