<!DOCTYPE html>
<html>
<head>
	<title>Stream Manager | Login</title>

	<link rel="shortcut icon" href="<?php echo site_url();?>assets/site/main/images/favicon.png" type="image/png" />
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">	
	<?php echo '<script type="text/javascript">var baseURL = "'.base_url().'";</script>'; ?>
<?php echo '<script type="text/javascript">var csrf_test_name = "'.$this->security->get_csrf_hash().'";</script>'; ?>
	<style type="text/css">
	.login-full{
		background-image: url('<?php echo site_url();?>assets/site/main/images/bg.jpg');
	}

	.login-dv{
		background-image: url('<?php echo site_url();?>assets/site/main/images/login-bg.png');
	}
</style>
 <!-- ========= CSS Included ========= -->
    <!-- === Bootstrap 3.3.7 === -->
    <link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/css/bootstrap.min.css">
    <!-- === Font Awesome === -->
    <link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/css/font-awesome.min.css">
    <!-- === Core Style === -->
    <link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/css/admin.min.css">
    <link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/css/all-skins.min.css">
    <!-- === Date Picker === -->
    <link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/css/sweetalert.css">
    <!-- === Custom Css === -->
    <link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/css/custom.css">
    <link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/css/beyond_design.css">

    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
    <!-- ========= Google Font ========= -->
    <!--<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900|Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <!-- ============================== Viewport Container Start ============================== -->
    <div class="wrapper">