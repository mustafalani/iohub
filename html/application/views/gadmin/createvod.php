<?php $this->load->view('gadmin/navigation.php');?>
<?php $this->load->view('gadmin/leftsidebar.php');?>


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
         <div class="row">            
               <div class="col-lg-12 col-12-12"> 
                <form class="form-only form-one" method="post" action="<?php echo site_url();?>groupadmin/saveCreateVod" enctype="multipart/form-data">              
                <div class="content-box config-contentonly">
                	 
                     <div class="config-container" id="wowza_form">
                      <div class="tab-btn-container">
                                       <button type="submit" class="btn-def save btntop2">
					                    <span>Save</span>
					   </div>
                           <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
						   <br/>
						    
                                                           
                             <div class="col-lg-6 p-t-15">
                                    <div class="form-group col-lg-9">
                                       <div class="row">
                                          <label>Application Name</label>
                                          <input type="text" class="form-control" placeholder="PL-FB-LIVE" name="application_name" id="application_name" required="true">
                                       </div>
                                    </div>
                                    <div class="form-group col-lg-9">
                                       <div class="row">
                                          <label>Live Source</label>
                                          <select id="live_source" name="live_source" class="form-control selectpicker" onchange="showAddress(this.value);" required="true">
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
                          
                     </div>
                  </div>
                  </form>
               </div>
           
         </div>
      </div>
   </div>
</section>

