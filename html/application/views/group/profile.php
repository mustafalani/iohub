<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
  <!-- ========= Content Wrapper Start ========= -->
        <section class="content-wrapper db-page">
            <!-- ========= Main Content Start ========= -->
            <div class="content">

                <!-- ========= Section One Start ========= -->
                <div class="content-container">
                    <div class="row">
	
	

	
	  <div id="home" class="tab-pane fade in active">	
	  
	      <div class="col-lg-12 col-sm-12" style="padding:0;">
  
    <div class="btn-pref btn-group btn-group-justified btn-group-lg" role="group" aria-label="...">
        <div class="btn-group" role="group">
            <button type="button" id="stars" class="btn bg-green" href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                <div class="hidden-xs">Personal Information</div>
            </button>
        </div>
        <div class="btn-group" role="group">
            <button type="button" id="favorites" class="btn btn-default" href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span>
                <div class="hidden-xs">Contact Details</div>
            </button>
        </div>
		 
		 
		  <div class="btn-group" role="group">
            <button type="button" id="favorites" class="btn btn-default" href="#tab3" data-toggle="tab"><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span>
                <div class="hidden-xs">Change Password</div>
            </button>
        </div>
		
		
    
    </div>

        <div class="well">
      <div class="tab-content">
        <div class="tab-pane fade in active" id="tab1" style="overflow:hidden;"> 

 <div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">
 <div>
 
        
					<label>Name: </label>
						<?php if(!empty($userProfileData)) echo $userProfileData[0]['fname'];?>
				         </br>
							
					<label>Last Name: </label>
						<?php if(!empty($userProfileData)) echo $userProfileData[0]['lname'];?>
      
					</div>	
					</div>	
					
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">	
					
						
				
					</div>
						<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">
					
					</div>
					<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">	
									</div>
        </div>
        <div class="tab-pane fade in" id="tab2" style="overflow:hidden;">
          <div class="col-xs-12 col-sm-7 col-md-12 contact-detail">
			<label>Mobile Number:</label>
			
			 <?php if(!empty($userProfileData)) echo $userProfileData[0]['phone'];?>
				
		  </div>
		  <div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdright">
			<label>Email Id: </label>	
			 <?php if(!empty($userProfileData)) echo $userProfileData[0]['email_id'];?>
			</div>
        </div>
        <div class="tab-pane fade in" id="tab3" style="overflow:hidden;">
          <form id="wowza-form" class="form-only form-one" method="post" action="<?php echo site_url();?>admin/saveConfiguration" enctype="multipart/form-data">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
      <div class="row">
					<div class="form-group col-xs-9">
					
					    <label for="inputEmail3" class="col-sm-2">Old Password.</label>
					    <div class="col-sm-8">
					     
						  <input type="password" class="form-control" name="oldpassword" id="oldpassword" placeholder="Old Password" required="true">
					    </div>
					</div>
					
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">New Password.</label>
					    <div class="col-sm-8">
					     
						  <input type="password" class="form-control" name="oldpassword" id="oldpassword" placeholder="New Password" required="true">
					    </div>
					</div>
					<div class="form-group col-xs-9">
					    <label for="inputEmail3" class="col-sm-2">Confirm Password.</label>
					    <div class="col-sm-8">
					     
						  <input type="password" class="form-control" name="oldpassword" id="oldpassword" placeholder="Confirm Password" required="true">
					    </div>
					</div>
					<div class="form-group col-xs-6">
					
					      <input type="submit" class="form-control sbmt" value="Submit"/>
					    </div>	
				</div>
        </div>
      </div>
    </div>
    
    </div>
	  
	  
	  
	  
	  
                
              
              
          
              
              
              
              
              
                   
	  </div>	   
	
	</div>
	</div>
	</div>
</section>



            
    	