<!DOCTYPE html>
<html>
<head>	
 <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php
	$segment = $this->uri->segment(1);
	if(!empty($segment))
	{
		switch($segment)
		{
			case "dashboard":
				echo "iohub | Dashboard";
			break;
			case "configuration":
				echo "iohub | Configuration";
			break;
			case "clients":
				echo "iohub | Clients";
			break;
			case "creategroup":
				echo "iohub | Create Group";
				break;
			case "createuser":
				echo "iohub | Create User";
				break;
			break;
			case "permissions":
				echo "iohub | Permissions";
			break;
			case "applications":
				echo "iohub | Applications";
			break;
			case "createapplication":
			echo "iohub | Create Application";
			break;			
			case "createtarget":
			echo "iohub | Create Targets";
			break;
			case "logs":
			echo "iohub | Report | Logs";
			break;
			default:
				echo "iohub";
			break;		
		}
	}
	else
	{
		echo "iohub";
	}
    ?>
   </title>
   
   <?php
   if(!empty($segment))
	{
		switch($segment)
		{
			case "editTarget":
				?>
				<meta content='text/html; charset=UTF-8' http-equiv='Content-Type' />
				<meta name="twitter:card" content="player"> 
			
				<meta name="twitter:player:height" content="250"> 
				<meta name="twitter:player:width" content="700"> 
				<meta name="twitter:domain" content="iohub.tv"> 
				<?php
			break;
		}
	}	
   ?>
   <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta http-equiv="Cache-Control" content=" private, no-cache, no-store, must-revalidate, pre-check=0, post-check=0, max-age=0">
<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Expires" content="0" />
	<link rel="shortcut icon" href="<?php echo site_url();?>public/site/main/img/iohub_logo.png" type="image/png" />
	
	<?php echo '<script type="text/javascript">var baseURL = "'.base_url().'";</script>'; ?>
<?php echo '<script type="text/javascript">var csrf_test_name = "'.$this->security->get_csrf_hash().'";</script>'; ?>
<?php
echo '<script type="text/javascript">var Controller="'.$this->router->fetch_class().'";</script>';
echo '<script type="text/javascript">var Action="'.$this->router->fetch_method().'";</script>';
echo '<script type="text/javascript">var Segmnetthree="'.$this->uri->segment(3).'";</script>';
echo '<script type="text/javascript">var Segmnetfour="'.$this->uri->segment(4).'";</script>';
echo "\n";
$userdata = $this->session->userdata('user_data');
$permissions = $this->common_model->getUserPermission($userdata['user_type']);
echo '<script type="text/javascript">var userPermissions=\''.json_encode($permissions[0]).'\';</script>';
?>
	<style type="text/css">
	.login-full{
		background-image: url('<?php echo site_url();?>public/site/main/images/bg.jpg');
	}

	.login-dv{
		background-image: url('<?php echo site_url();?>public/site/main/images/login-bg.png');
	}
</style>
 <!-- ========= CSS Included ========= -->
    <!-- === Bootstrap 3.3.7 === -->
    <link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/bootstrap.min.css">
    <!-- === Font Awesome === -->
     <link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/jquery-ui.css"/>
    <link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/font-awesome.min.css"/>
    <!-- === Core Style === -->
    <link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/admin.min.css"/>
    <link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/all-skins.min.css"/>
    <!-- === Date Picker === -->
 
<link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/bst.css"/>
     <link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/bootstrap-datetimepicker.min.css"/>
<link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/bootstrap-datepicker.min.css"/>
    
     <!--<link rel="stylesheet" href="<?php echo site_url();?>public/site/main/js/plugins/bootstrap-daterangepicker/daterangepicker.css"/>-->
    <link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/bootstrap-select.min.css"/>
    <link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/bootstrap-multiselect.css"/>
    <link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/datatables.min.css"/>
    
    <link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/fullcalendar.min.css">
  <link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/fullcalendar.print.min.css" media="print">
  
    <link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/sweetalert.css">
   
    <link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/jquery.countdownTimer.css">
    <!-- === Custom Css === -->
    
    <link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/custom.css">
    <link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/beyond_design.css">
    <link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/dashboard.css">
     
	<link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/animate.css">
		<link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/toastr.min.css"/>
		<link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/jquery.flowchart.css"/>

	<!--<link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/style.css">-->


	<!-- Modernizr JS -->
	<!--<script src="<?php echo site_url();?>public/site/main/js/modernizr-2.6.2.min.js"></script>-->
  
	
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
    <!-- ========= Google Font ========= -->
    <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900|Raleway:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    

    
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <!-- ============================== Viewport Container Start ============================== -->
    <div class="wrapper">