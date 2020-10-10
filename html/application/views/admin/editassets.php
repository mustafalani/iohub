<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<style type="text/css">
	.netdata-chart span{
		color: #FFFFFF !important;
	}
	.wowzaTable tr td a.wowzadisable:hover .box-body
	{
		display:block !important;
	}
.dropzone {
    background: #343B41;
}
.icnasset i{
	cursor: pointer;
}
pre {
    overflow-x: hidden;
    }
</style>
<?php

function convertToDHMS($seconds){
	$string = "";

	$days = intval(intval($seconds) / (3600*24));
	$hours = (intval($seconds) / 3600) % 24;
	$minutes = (intval($seconds) / 60) % 60;
	$seconds = (intval($seconds)) % 60;

	if($days> 0){
	    $string .= "$days:";
	}
	else
	{
		   $string .= "00:";
	}
	if($hours > 0){
	    $string .= "$hours:";
	}
	else
	{
		   $string .= "00:";
	}
	if($minutes > 0){
	    $string .= "$minutes:";
	}
	else
	{
		   $string .= "00:";
	}
	if ($seconds > 0){
	    $string .= "$seconds";
	}
	else
	{
		   $string .= "00";
	}

	return $string;
}
function convertoTimeFormat($time){

	$t = (int)($time)*(1000);

	return date('Y-m-d H:i:s',$t);
}



function convertToReadableSize($size){

	if($size != "NAN" && $size != "")
	{
		$base = log($size) / log(1024);
	  $suffix = array("", "KB", "MB", "GB", "TB");
	  $f_base = floor($base);
	  return round(pow(1024, $base - floor($base)), 1).' ' . $suffix[$f_base];
	}
	else{
		return "0 KB";
	}
}
//print_r($data['data']);
//echo json_encode($data);
?>
<main class="main">
        <!-- Breadcrumb-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href=<?php echo site_url();?>>Home</a>
          </li>
          <li class="breadcrumb-item active"><a href="<?php echo site_url();?>assets/<?php echo $this->uri->segment(3); ?>"><?php $nebula_id = $this->uri->segment(3);?><?php $nebula = $this->common_model->getNebulabyId($nebula_id);?><?php echo $nebula[0]['encoder_name'];?></a></li>
					<li class="breadcrumb-item active">Edit Asset</li>
        </ol>
        <div class="container-fluid">
        <div class="animated fadeIn">
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
			<div class="card">
				<div class="card-header">Edit Asset</div>
				<div class="card-body">
					<div class="row">
				<div class="col-md-6 mb-4">
                <ul class="nav nav-tabs" role="tablist">
                	<?php
            		$user_permissions = $this->session->userdata('user_permissions');
		              $userdata = $userdata = $this->session->userdata('user_data');
		              if($userdata['user_type'] == 1)
		              {
		              	?>
		              	<li class="nav-item" role="presentation">

		              	<a class="nav-link active" id="system" href="#main" aria-controls="systems" role="tab" data-toggle="tab">Main</a></li>
		              	<li class="nav-item" role="presentation">
		              		<a class="nav-link" href="#extended" aria-controls="systems" role="tab" data-toggle="tab">Extended</a></li>
		              	<li class="nav-item" role="presentation">
		              		<a class="nav-link" href="#technical" aria-controls="systems" role="tab" data-toggle="tab">Technical</a></li>
		              	<?php
					  }
					?>
                </ul>
                <div class="tab-content">
                  			<div role="tabpanel" class="tab-pane active" id="main">
										<div class="row">
											<div class="col-lg-12 col-md-12 fields">
												<input type="hidden" name="assetid" id="assetid" value="<?php echo $data['data'][0]['id'];?>"/>
												<div class='form-group'>
													<label>Folder</label>
													<select id="id_folder" name="id_folder" class="form-control selectpicker">
													<option value="">Select</option>
													<?php

													if(sizeof($settings['data']['folders'])>0)
													{
														foreach($settings['data']['folders'] as $fid=>$folder)
														{
															if($data['data'][0]['id_folder'] == $fid)
															{
																?>
																<option selected="selected" style="color:#<?php echo base_convert($settings['data']['folders'][$fid]['color'], 10, 16);?>" value="<?php echo $fid;?>"><?php echo $folder['title']; ?></option>
															<?php
															}
															else{
															?>
																<option style="color:#<?php echo base_convert($settings['data']['folders'][$fid]['color'], 10, 16);?>" value="<?php echo $fid;?>"><?php echo $folder['title']; ?></option>
															<?php
															}

														}
													}
													?>
												</select>
												</div>
												<?php

												if(is_array($settings) && sizeof($settings)>0)
												{
													foreach($settings['data']['folders'][$data['data'][0]['id_folder']]['meta_set'] as $field)
													{
														$f = $settings['data']['meta_types'][$field[0]];
														if($f['fulltext'] == 0)
														{
															if(array_key_exists('cs',$f)){
																//print_r($data['data'][0][$field[0]]);
																?>
																<div class="form-group">
																	<label><?php echo $f['aliases']['en'][0];?> </label>
																	<select id="<?php echo $field[0]; ?>" name="<?php echo $field[0]; ?>" class="form-control selectpicker">
																		<option value="">Select</option>
																		<?php
																		foreach($settings['data']['cs'][$f['cs']] as $option)
																		{																																	if(is_array($data['data'][0][$field[0]]))
																			{
																				if($option[0] == $data['data'][0][$field[0]][0]){
																					?>
																					<option selected="selected" value="<?php echo $option[0];?>"><?php echo $option[1]['aliases']['en'];?></option>
																					<?php
																				}
																				else{
																					?>
																					<option value="<?php echo $option[0];?>"><?php echo $option[1]['aliases']['en'];?></option>
																					<?php
																				}
																			}
																			else{
																				if($option[0] == $data['data'][0][$field[0]]){
																					?>
																					<option selected="selected" value="<?php echo $option[0];?>"><?php echo $option[1]['aliases']['en'];?></option>
																					<?php
																				}
																				else{
																					?>
																					<option value="<?php echo $option[0];?>"><?php echo $option[1]['aliases']['en'];?></option>
																					<?php
																				}
																			}
																			?>

																			<?php
																		}
																		?>
																	</select>
																</div>
																<?php
															}
															else if(array_key_exists('mode',$f)){
																?>
															<div class="form-group">
																<label><?php echo $f['aliases']['en'][0];?> </label>
																<input type="text" class="form-control" name="<?php echo $field[0]; ?>" id="<?php echo $field[0]; ?>" value="<?php echo $data['data'][0][$field[0]];?>"/>
															</div>
															<?php
															}
															else{
																?>
																	<div class="form-group">
																		<label><?php echo $f['aliases']['en'][0];?> </label>
																		<input type="text" class="form-control" name="<?php echo $field[0]; ?>" id="<?php echo $field[0]; ?>" value="<?php echo $data['data'][0][$field[0]];?>"/>
																	</div>
															<?php
															}
														}
														else if($f['fulltext'] >= 1)
														{
															?>
															<div class="form-group">
																<label><?php echo $f['aliases']['en'][0];?> </label>
																<input type="text" class="form-control" name="<?php echo $field[0]; ?>" id="<?php echo $field[0]; ?>" value="<?php echo $data['data'][0][$field[0]];?>"/>
															</div>
															<?php
														}
													}
												}
												?>
											</div>

										</div>

								</div>
							<div role="tabpanel" class="tab-pane" id="extended">
								<div class="bg-secondary card">
								   <div class="card-body">
								      <pre><strong>Path : </strong><?php if(array_key_exists('path',$data['data'][0])){
								      		echo trim($data['data'][0]['path']);
								      		}
								      		else{
												echo "N/A";
											}
								      	?></pre>
								      <pre><strong>Status : </strong><?php
								       if(array_key_exists('status',$data['data'][0])){

								      		if($data['data'][0]['status'] == 1){
												?><i class="fa fa-circle text-success"></i> ONLINE <?php
											}else{?><i class="fa fa-circle text-secondary"></i> OFFLINE<?php
											}
								      	}
								      		else{
												echo "N/A";
											}
								      	?>
								      </pre>
								      <pre><strong>Folder : </strong><?php if(array_key_exists('id_folder',$data['data'][0])){
								      		echo $data['data'][0]['id_folder'];
								      		}
								      		else{
												echo "N/A";
											}
								      	?></pre>
								      <pre><strong>Storage ID : </strong><?php if(array_key_exists('id_storage',$data['data'][0])){echo trim($data['data'][0]['id_storage']).' (production)';}
								      		else{
												echo "N/A";
											}
								      	?> </pre>
								      <pre><strong>Media Type : </strong><?php if(array_key_exists('media_type',$data['data'][0])){echo trim($data['data'][0]['media_type']);}
								      		else{
												echo "N/A";
											}
								      	?>
								      </pre>
								      <pre><strong>Content Type : </strong><?php if(array_key_exists('content_type',$data['data'][0])){echo trim($data['data'][0]['content_type']);}
								      		else{
												echo "N/A";
											}
								      	?></pre>
								      <pre><strong>ID : </strong><?php if(array_key_exists('id',$data['data'][0])){echo trim($data['data'][0]['id']);
								      		}
								      		else{
												echo "N/A";
											}
								      	?>
								      </pre>
								      <pre><strong>Creation Time : </strong><?php if(array_key_exists('ctime',$data['data'][0])){echo trim(convertoTimeFormat($data['data'][0]['ctime']));
								      		}
								      		else{
												echo "N/A";
											}
								      	?>
								      </pre>
								      <pre><strong>Modify Time : </strong><?php if(array_key_exists('mtime',$data['data'][0])){
								      		echo convertoTimeFormat($data['data'][0]['mtime']);
								      		}
								      		else{
												echo "N/A";
											}
								      	?>
								      </pre>
								   </div>
								</div>
							</div>
							<div role="tabpanel" class="tab-pane" id="technical">
								<div class="bg-secondary card">
								   <div class="card-body">
								      <pre><strong>Duration : </strong><?php if(array_key_exists('duration',$data['data'][0])){
								      		echo convertToDHMS($data['data'][0]['duration']);
								      		}
								      		else{
												echo "N/A";
											}
								      	?></pre>
								      <pre><strong>File Modified : </strong>2014-12-03 14:38</pre>
								      <pre><strong>File Size : </strong><?php if(array_key_exists('file/size',$data['data'][0])){
								      		echo convertToReadableSize($data['data'][0]['file/size']);
								      		}
								      		else{
												echo "N/A";
											}
								      	?></pre>
								      <pre><strong>QC State : </strong><?php if(array_key_exists('qc/state',$data['data'][0])){
								      		echo convertToReadableSize($data['data'][0]['qc/state']);
								      		}
								      		else{
												echo "N/A";
											}
								      	?>
								      </pre>
								      <pre><strong>Aspect Ratio : </strong><?php if(array_key_exists('video/aspect_ratio',$data['data'][0])){
								      		echo $data['data'][0]['video/aspect_ratio'];
								      		}
								      		else{
												echo "N/A";
											}
								      	?></pre>
								      <pre><strong>Aspect Ratio : </strong><?php if(array_key_exists('video/aspect_ratio_f',$data['data'][0])){
								      		echo $data['data'][0]['video/aspect_ratio_f'];
								      		}
								      		else{
												echo "N/A";
											}
								      	?></pre>
								      <pre><strong>Video Codec : </strong><?php if(array_key_exists('video/codec',$data['data'][0])){
								      		echo $data['data'][0]['video/codec'];
								      		}
								      		else{
												echo "N/A";
											}
								      	?></pre>
								      <pre><strong>Color Range : </strong><?php if(array_key_exists('video/color_range',$data['data'][0])){
								      		echo $data['data'][0]['video/color_range'];
								      		}
								      		else{
												echo "N/A";
											}
								      	?></pre>
								      <pre><strong>Color Space : </strong><?php if(array_key_exists('video/color_space',$data['data'][0])){
								      		echo $data['data'][0]['video/color_space'];
								      		}
								      		else{
												echo "N/A";
											}
								      	?></pre>
								      <pre><strong>FPS : </strong><?php if(array_key_exists('video/fps',$data['data'][0])){
								      		echo $data['data'][0]['video/fps'];
								      		}
								      		else{
												echo "N/A";
											}
								      	?></pre>
								      <pre><strong>FPS : </strong><?php if(array_key_exists('video/fps_f',$data['data'][0])){
								      		echo $data['data'][0]['video/fps_f'];
								      		}
								      		else{
												echo "N/A";
											}
								      	?></pre>
								      <pre><strong>Height : </strong><?php if(array_key_exists('video/height',$data['data'][0])){
								      		echo $data['data'][0]['video/height'];
								      		}
								      		else{
												echo "N/A";
											}
								      	?></pre>
								      <pre><strong>Pixel Format : </strong><?php if(array_key_exists('video/pixel_format',$data['data'][0])){
								      		echo $data['data'][0]['video/pixel_format'];
								      		}
								      		else{
												echo "N/A";
											}
								      	?></pre>
								      <pre><strong>Width : </strong><?php if(array_key_exists('video/width',$data['data'][0])){
								      		echo $data['data'][0]['video/width'];
								      		}
								      		else{
												echo "N/A";
											}
								      	?></pre>
								   </div>
								</div>


							</div>
						</div>
                	</div>


                	<div class="col-md-6 mb-4">
                		<div class="col-lg-12 col-md-12" style="vertical-align: top !important;">
												 <video style="height: auto;" class="rh5v-DefaultPlayer_video" poster="<?php echo $URL; ?>/thumb/0000/<?php echo $data['data'][0]['id']; ?>/orig.jpg" controls="controls">
	                                                <source src="<?php echo $URL; ?>/proxy/0000/<?php echo $data['data'][0]['id']; ?>.mp4" type="video/webm">
	                                            </video>
	                                            <div style="text-align:left;font-size:20px;" class="icnasset">
	                                            	QC:
	                                              <?php
	                                              if(array_key_exists('qc/state',$data['data'][0]))
	                                              {
												  	switch($data['data'][0]['qc/state'])
												  	{
														case "3":
														?>
													   <i class="icon-check icons"></i>
							                          <span>  </span>
							                          <i class="icon-close icons text-danger"></i>
							                          <span>  </span>
							                          <i class="fa fa-circle-thin icons" style="font-size: 24px;"></i>
														<?php
														break;
														case "4":
														?>
													   <i class="icon-check icons text-success"></i>
							                          <span>  </span>
							                          <i class="icon-close icons"></i>
							                          <span>  </span>
							                          <i class="fa fa-circle-thin icons" style="font-size: 24px;"></i>
														<?php
														break;
														case "0":
														?>
													 <i class="icon-check icons"></i>
							                          <span>  </span>
							                          <i class="icon-close icons"></i>
							                          <span>  </span>
							                          <i class="fa fa-circle-thin icons text-secondary" style="font-size: 24px;"></i>

														<?php
														break;
													}
												  }
												  else{
												  	?>
													   <i class="icon-check icons"></i>
							                          <span>  </span>
							                          <i class="icon-close icons"></i>
							                          <span>  </span>
							                          <i class="fa fa-circle-thin icons" style="font-size: 24px;"></i>
														<?php
												  }
	                                              ?>

						                          <span>  </span>
						                         <!-- <button class="badge badge-block btn-outline-secondary" disabled>
						                          	<?php echo convertToDHMS($data['data'][0]['duration']); ?>
						                          </button>-->
												</div>
											</div>
                	</div>
              </div>
		</div>
		<div class="card-footer">
				<button class="btn btn-sm btn-primary btnEditAssets" accesskey="<?php echo $this->uri->segment(3);?>" type="button">Update</button>
				</div>
				</div>
			</div>

        </div>
        </div>
</main>
