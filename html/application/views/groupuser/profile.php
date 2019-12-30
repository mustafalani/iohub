<?php //echo "<pre>";print_r($userProfileData);die;?>

<?php $this->load->view('groupuser/navigation.php');?>
<?php $this->load->view('groupuser/leftsidebar.php');?>
<!-- ========= Content Wrapper Start ========= -->
<section class="content-wrapper db-page">
<!-- ========= Main Content Start ========= -->
<div class="content">

<!-- ========= Section One Start ========= -->
<div class="content-container">
<div class="row">



	
<div id="home" class="tab-pane fade in active">	
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
	      <div class="col-lg-12 col-sm-12" style="padding:0;">
  
    <div class="btn-pref btn-group btn-group-justified btn-group-lg" role="group" aria-label="...">
        <div class="btn-group" role="group">
            <button type="button" id="stars" class="btn bg-green" href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                <div class="hidden-xs">Personal Information</div>
            </button>
        </div>
        
		<!--<div class="btn-group" role="group">
            <button type="button" id="favorites" class="btn btn-default" href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span>
                <div class="hidden-xs">Contact Details</div>
            </button>
        </div>-->
		 
		 
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
				<div class="col-xs-2 col-sm-2 col-md-2 pdleft pdright">	
					<?php if(isset($userProfileData[0]['user_profile']) && !empty($userProfileData[0]['user_profile'])){
						echo '<img width="150" height="170" id="imgdiv" src="'.site_url().'assets/site/main/group_pics/'.$userProfileData[0]['user_profile'].'">';
					}else{
						echo '<img width="150" height="170" id="imgdiv" src="'.site_url().'assets/site/main/images/'._DEFAULT_USER_IMAGE_.'">';
					}?>
				</div>
				
				<div class="col-xs-3 col-sm-3 col-md-3 pdleft pdright">
					<label>First Name: </label>
					<?php if(!empty($userProfileData)) echo $userProfileData[0]['fname'];?>
					</br>
							
					<label>Mobile Number:</label>
					<?php if(!empty($userProfileData)) echo $userProfileData[0]['phone'];?>
					</br>
					
					<label>Last Name: </label>
					<?php if(!empty($userProfileData)) echo $userProfileData[0]['lname'];?>
					</br>
					
					<label>User Email:</label>
					<?php if(!empty($userProfileData)) echo $userProfileData[0]['email_id'];?>
					</br></br>
					
					<a class="btn-def save" href="<?php echo site_url().'groupuser/updateuser/'.$userProfileData[0]['id'];?>" style="float:left;">Edit User</a>
					
				</div>	
			</div>	
			
			<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">	
			</div>
						
			<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">
			</div>
			
			<div class="dateof-birth col-xs-12 col-sm-12 col-md-12 pdleft pdright">	
		</div>
        </div>
		
        <!--<div class="tab-pane fade in" id="tab2" style="overflow:hidden;">
			<div class="col-xs-12 col-sm-7 col-md-12 contact-detail">
				<label>Mobile Number:</label>
				<?php if(!empty($userProfileData)) echo $userProfileData[0]['phone'];?>
			</div>
			<div class="addres-sec col-xs-9 col-sm-9 col-md-12 pdright">
				<label>Email Id: </label>	
				<?php if(!empty($userProfileData)) echo $userProfileData[0]['email_id'];?>
			</div>
        </div>-->
		
		
        <div class="tab-pane fade in" id="tab3" style="overflow:hidden;">
			<form id="wowza-form" class="form-only form-one profile-tab" method="post" action="<?php echo site_url();?>Groupuser/changePasswordSubmit" enctype="multipart/form-data">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			<div class="row">
				<div class="form-group col-xs-12">
					<label for="inputEmail3" class="col-sm-2 txt-label">Old Password.</label>
					<div class="col-sm-4">
					  <input type="password" class="form-control profiles-inputs" name="oldpassword" id="oldpassword" placeholder="Old Password" required="true">
					</div>
				</div>

				<div class="form-group col-xs-12">
					<label for="inputEmail3" class="col-sm-2 txt-label">New Password.</label>
					<div class="col-sm-4">
					  <input type="password" class="form-control profiles-inputs" name="newpassword" id="newpassword" placeholder="New Password" required="true">
					</div>
				</div>
				
				<div class="form-group col-xs-12">
					<label for="inputEmail3" class="col-sm-2 txt-label">Confirm Password.</label>
					<div class="col-sm-4">
					  <input type="password" class="form-control profiles-inputs" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password" required="true">
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