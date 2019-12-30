<!-- ============================== Viewport Container Start ============================== -->
    <div class="login-container">
    	<?php
	    	if($this->session->flashdata('message_type') == "success")
	    	{
			?>			
			<div id="card-alert" class="alert alert-success">
               <strong>Success!</strong> <?php echo $this->session->flashdata('success');?>
             
              <button type="button" class="close green-text" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>
			<?php	
			}
			if($this->session->flashdata('message_type') == "error")
	    	{
			?>
			<div id="card-alert" class="alert alert-danger">
             <strong>Danger!</strong> <?php echo $this->session->flashdata('error');?>               
              <button type="button" class="close red-text" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
            </div>			
			<?php	
			}
	    	
	    	?>
        <div class="login-box">
             <form class="login-form" method="post" action="<?php echo site_url();?>home/forgot_password" enctype="multipart/form-data">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>
                <!--<h4> Stream <span class="text-one">Manager</span></h4>-->
                <img class="login-logo" src="<?php echo site_url();?>public/site/main/img/iohub_logo.png"/>
                <h5>Forgot Password</h5>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                       	<input id="email" name="email" class="form-control" type="text" required="true" placeholder="username"/>
                    </div>
                </div>
                <p id="captImg"><?php echo $captchaImg; ?></p>
				<p>Can't read the image? click <a href="javascript:void(0);" class="refreshCaptcha">here</a> to refresh.</p>
               <br/><br/>
               
                <div class="form-group">
                    <button type="submit" class="btn btn-signin">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <!-- ============================== Viewport Container End ============================== -->
