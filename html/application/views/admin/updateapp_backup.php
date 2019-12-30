<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>


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
         <div class="content-box config-contentonly">

               <div class="col-xs-12">

                <div class="row">
                     <div class="wowza-form" id="wowza_form">
                        <form class="form-only form-one" method="post" action="<?php echo site_url();?>admin/updateApplication/<?php echo $this->uri->segment(2);?>" enctype="multipart/form-data">
                           <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                      <div class="wowza-form col-lg-12 conf shadow" id="wowza_form ">


								<div class=" sav-btn-dv wowza-save">
									            <button type="submit" class="btn-def save pull-right">
                                <span>

                                Update
                                </span>
                                </button>
                <h2><?php echo $application[0]['application_name'];?></h2>
								</div>
			</div>
			 <div class="col-lg-12">
                               	<div class="row">
                               	<hr>
                               	</div>
                               </div>
                             <div class="col-lg-6 col-md-12">
                                    <div class="form-group col-lg-9">
                                       <div class="row">
                                          <label>Application Name <span class="mndtry">*</span></label>
                                          <input type="text" class="form-control" placeholder="" name="application_name" id="application_name" required="true" value="<?php echo $application[0]['application_name'];?>">
                                       </div>
                                    </div>
                                    <div class="form-group col-lg-9">
                                       <div class="row">
                                          <label>Live Source <span class="mndtry">*</span></label>
                                          <select id="live_source" name="live_source" class="form-control selectpicker" onchange="showAddress(this.value);" required="true">
                                             <option value="0">-- Select --</option>
                                             <?php

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
                                       <?php
                                       $path = $application[0]['wowza_path'];
                                       $path = str_replace("http","rtmp",$path);
                                       ?>
                                          <input type="text" readonly="true" class="form-control" name="wowza_path" id="block" value="<?php echo $path;?>"/>
                                       </div>
                                    </div>
                                    <div class="col-lg-3">
                                       <button type="button" class="btn  btn-edit btn-sm" onclick="enableAppEdit();">Edit</button>
                                    </div>


                                 </div>
                             <div class="col-lg-6 pdright">

                                 <div id="player-container" style="border:1px solid #fff;height:270px;width:480px;" class="pull-right">
										<div  style="width:480px;height:270px;" id="player_apps" title="<?php echo $application[0]['wowza_path'];?>"></div>
										<div id="player-tip"></div>
									</div>


                             </div>
                             <br/>  <br/>
                             <div class="col-lg-6 text-center pull-right" style="margin-top:20px;">
										<button type="button" id="playappp" class="btn" style="color:#747474;"><i class="fa fa-play"></i> Play</button>
							</div>



                        </form>
                     </div>
                  </div>
               </div>

         </div>
      </div>
   </div>
</section>
