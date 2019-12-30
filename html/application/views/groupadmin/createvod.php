<?php $this->load->view('groupadmin/navigation.php');?>
<?php $this->load->view('groupadmin/leftsidebar.php');?>


<section class="content-wrapper">
   <!-- ========= Main Content Start ========= -->
   <div class="content">
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
	                    <li role="presentation" class="active"><a href="#systems" aria-controls="systems" role="tab" data-toggle="tab">Create Application</a></li>	                  
	                </ul>	                
	            </div>
                <div class="box-header">
                     <div class="wowza-form" id="wowza_form">
                        <form class="form-only form-one" method="post" action="<?php echo site_url();?>groupadmin/saveCreateVod" enctype="multipart/form-data">
						  <button type="submit" class="btn-def save btntop2">
                                <span>
                                <i class="fa fa-save"></i>
                                Save
                                </span>
                                </button>
                           <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                           
                             <div class="col-lg-8 col-md-12">
                                    <div class="form-group col-lg-9">
                                       <div class="row">
                                          <label>Application Name</label>
                                          <input type="text" class="form-control" placeholder="PL-FB-LIVE" name="application_name" id="application_name" required="true">
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
                                                		
                                                		echo '<option value="'.$wowza['id'].'">'.$wowza['wse_instance_name'].'</option>';		
                                                		
                                                	}
                                                }
                                                ?> 
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group col-lg-9">
                                       <div class="row">
                                          <!---<input type="text" class="form-control" placeholder="rtmp://192.168.1.11:1935/PL-FB-LIVE/myStream" name="wowza_path" id="block">--->
                                          <input type="text" class="form-control" name="wowza_path" id="block">
                                       </div>
                                    </div>
                                    <div class="col-lg-3">
                                       <button class="btn  btn-edit btn-sm">Edit</button>
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

