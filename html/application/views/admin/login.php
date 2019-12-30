<link href="<?php echo site_url();?>node_modules/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
<style type="text/css">
body {
    margin: 0;
    font-family: -apple-system,BlinkMacSystemFont,segoe ui,Roboto,helvetica neue,Arial,sans-serif,apple color emoji,segoe ui emoji,segoe ui symbol,noto color emoji;
    font-size: .875rem;
    font-weight: 400;
    line-height: 1.5;
    color: #e4e7ea;
    text-align: left;
    background-color: #2f353a;
  }
.app, app-dashboard, app-root {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-height: 100vh;
}

.align-items-center {
    -ms-flex-align: center!important;
    align-items: center!important;
}
.flex-row {
    -ms-flex-direction: row!important;
    flex-direction: row!important;
}
.justify-content-center {
    -ms-flex-pack: center!important;
    justify-content: center!important;
}

.row {
    display: -ms-flexbox;
    display: flex;
    -ms-flex-wrap: wrap;
    flex-wrap: wrap;
    margin-right: -15px;
    margin-left: -15px;
}
.card {
    position: relative;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color: #3a4149;
    background-clip: border-box;
    border: 1px solid #23282c;
    border-radius: .25rem;
}
.card-body {
    -ms-flex: 1 1 auto;
    flex: 1 1 auto;
    padding: 1.25rem;
  }

  .form-control {
      display: block;
      width: 100%;
      height: calc(2.0625rem + 2px);
      padding: .375rem .75rem;
      line-height: 1.5;
      color: #e4e7ea;
      background-color: #515b65;
      background-clip: padding-box;
      border: 1px solid #23282c;
      border-radius: .25rem;
      transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
  }

  .input-group-text {
      display: -ms-flexbox;
      display: flex;
      -ms-flex-align: center;
      align-items: center;
      padding: .375rem .75rem;
      margin-bottom: 0;
      font-size: .875rem;
      font-weight: 400;
      line-height: 1.5;
      color: #e4e7ea;
      text-align: center;
      white-space: nowrap;
      background-color: #343b41;
      border: 1px solid #23282c;
      border-radius: .25rem;
  }

.icon-user {
font-family: simple-line-icons;
speak: none;
font-style: normal;
font-weight: 400;
font-variant: normal;
text-transform: none;
line-height: 1;
-webkit-font-smoothing: antialiased;
-moz-osx-font-smoothing: grayscale;
}

</style>
      <div class="container" style="padding-top:20vh;">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card-group">
              <div class="card p-4">
                <div class="card-body">

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
        <div class="login-form">
					<span class="input-group-addon" style="
    width: 100%;
    margin: auto;
    display: block;
		padding: 10px;
"><i class="icon-lock" aria-hidden="true" style="
    font-size: 100px;
    text-align: center;
    margin: auto;
    display: block;
    width: 100%;
"></i></span>
					<div class="form-group">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-key"></i></span>
									<input type="password"  id="unlockpass" name="unlockpass" class="form-control" placeholder="password"/>
							</div>
					</div>
					<div class="form-group">
						<button id="btnunlock" type="button" class="btn btn-signin">Unlock!</button>
					</div>
        </div>
			</div>
	    </div>
		</div>
			<div style="padding-left:5px;">
				<a href="http://iohub.live">iohub v2.0</span></a>
				<span>&copy; - Copyright <a href="https://kurrent.tv">Kurrent TV </a>All rights reserved.</span>
			</div>

	    </div>
	    </div>
