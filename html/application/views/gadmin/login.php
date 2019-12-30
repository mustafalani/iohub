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
               <img class="login-logo" src="<?php echo site_url();?>assets/site/main/img/iohub_logo.png"/>
                <h5>User Login</h5>
              
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
                        <input type="password"  id="unlockpass" name="unlockpass" class="form-control" placeholder="password"/>
                    </div>
                </div>
                <div class="form-group">
                    <button id="btnunlock" type="button" class="btn btn-signin">Un-Lock</button>
                </div>            
        </div>
   