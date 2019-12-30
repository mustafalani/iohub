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
                <h4>Kurrent Stream <span class="text-one">Manager</span></h4>
                <h5>User Login</h5>
              
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
                        <input id="unlockpass" name="unlockpass" class="form-control" type="password" required="true" placeholder="password"/>
                    </div>
                </div>
                <div class="form-group">
                    <button id="btnunlock" type="button" class="btn btn-signin">Un-Lock</button>
                </div>
            </form>
        </div>
   