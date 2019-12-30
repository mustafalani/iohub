<!-- ============================== Viewport Container Start ============================== -->
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
<body class="app flex-row align-items-center">
      <div class="container">
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
             <form class="login-form" method="post" action="<?php echo site_url();?>user/login" enctype="multipart/form-data">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>







                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icon-user"></i></span>
                       	<input id="username" name="username" class="form-control" type="text" required="true" placeholder="username"/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="icon-lock"></i></span>
                        <input id="pass" name="pass" class="form-control" type="password" required="true" placeholder="password"/>
                    </div>
                </div>
                <p><a href="<?php echo site_url();?>home/forgotpassword">forgot password?</a></p>
                <div class="form-group">
                    <button type="submit" class="btn btn-signin">Sign In</button>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </body>
    <footer class="app-footer" style="position:absolute;width:100%;padding:15px;bottom:0;font-size:12px;">
      <img class="loginlogo" style="width:10%;"src="<?php echo site_url();?>public/site/main/img/logo.png"/>
        <div style="padding-left:15px;">
          <a href="http://iohub.live">iohub v2.0</span></a>
          <span>&copy; - Copyright <a href="https://kurrent.tv">Kurrent TV </a>All rights reserved.</span>
        </div>
      </footer>
    <!-- ============================== Viewport Container End ============================== -->
