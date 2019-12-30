<!DOCTYPE html>
<!--
* CoreUI Pro - Bootstrap Admin Template
* @version v2.1.10
* @link https://coreui.io/pro/
* Copyright (c) 2018 creativeLabs Łukasz Holeczek
* License (https://coreui.io/pro/license)
-->

<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
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
				echo "iohub | Settings";
			break;
      case "createwowza":
				echo "iohub | New Publisher";
			break;
      case "updatewowzaengin":
				echo "iohub | Edit Publisher";
			break;
      case "addEncoderes":
				echo "iohub | New Encoder";
			break;
      case "editEncoder":
				echo "iohub | Edit Encoder";
			break;
      case "addgateways":
				echo "iohub | New NDI Gateway";
			break;
      case "editGateway":
				echo "iohub | Edit NDI Gateway";
			break;
      case "createtemplate":
				echo "iohub | New Preset";
			break;
      case "updateencodingtemplate":
				echo "iohub | Edit Preset";
			break;
      case "createnebula":
				echo "iohub | New Nebula";
			break;
      case "editnebula":
				echo "iohub | Edit Nebula";
			break;
			case "clients":
				echo "iohub | Clients";
			break;
			case "creategroup":
				echo "iohub | Create Group";
			break;
      case "updategroup":
  			echo "iohub | Edit Group";
  		break;
			case "createuser":
				echo "iohub | Create User";
			break;
      case "updateuser":
    		echo "iohub | Edit User";
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
			echo "iohub | Create Target";
			break;
      case "channels":
			echo "iohub | Channels";
			break;
      case "createchannel":
			echo "iohub | Create Channel";
			break;
      case "updatechannel":
			echo "iohub | Edit Channel";
			break;
      case "workflowlist":
			echo "iohub | Workflows";
			break;
      case "workflows":
			echo "iohub | New Workflow";
			break;
      case "schedule":
			echo "iohub | Scheduler";
			break;
      case "gateway":
			echo "iohub | NDI Gateway";
			break;
      case "assets":
			echo "iohub | Assets";
			break;
      case "editasset":
			echo "iohub | Edit Asset";
			break;
      case "rundowns":
			echo "iohub | Rundowns";
			break;
      case "createrundown":
			echo "iohub | Create Rundown";
			break;
      case "editrundown":
			echo "iohub | Edit Rundown";
			break;
      case "jobs":
			echo "iohub | Jobs";
			break;
      case "archive":
			echo "iohub | Archive";
			break;
      case "logs":
			echo "iohub | Report | Logs";
			break;
      case "helo":
			echo "iohub | Help";
			break;
      case "extra":
			echo "iohub | Extra";
			break;
      case "streamviewer":
			echo "iohub | Stream Viewer";
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
   <link rel="shortcut icon" href="<?php echo site_url();?>assets/site/main/img/iohub_logo.png" type="image/png" />
    <!-- Icons-->
    <link href="<?php echo site_url();?>node_modules/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
    <link href="<?php echo site_url();?>node_modules/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    <link href="<?php echo site_url();?>node_modules/font-awesome/css/font-awesome.min.css" rel="stylesheet">


    <link href="<?php echo site_url();?>node_modules/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
 <!--    <link rel="stylesheet" href="<?php echo site_url();?>node_modules/jquery-ui-dist/jquery-ui.min.css"/>
     <link rel="stylesheet" href="<?php echo site_url();?>node_modules/bootstrap/dist/css/bootstrap.min.css"/>


    <link href="<?php echo site_url();?>node_modules/bootstrap-datetime-picker/css/bootstrap-datetimepicker.min.css"/>-->

   <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.0.0/flatly/bootstrap.min.css">-->
    <!-- Main styles for this application-->
    <link href="<?php echo site_url();?>assets/site/main/css/style.css" rel="stylesheet">
    <link href="<?php echo site_url();?>vendors/pace-progress/css/pace.min.css" rel="stylesheet">
    <!-- Custom styles for this application-->
    <link href="<?php echo site_url();?>assets/site/main/css/custom.css" rel="stylesheet">
    <link href="<?php echo site_url();?>assets/site/main/css/beyond_design.css" rel="stylesheet">


<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.0.0/flatly/bootstrap.min.css">-->
<link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/Date-Time-Picker/build/css/bootstrap-datetimepicker.min.css">
   <link rel="stylesheet" href="<?php echo site_url();?>node_modules/bootstrap-select-v4/dist/css/bootstrap-select.min.css"/>
   <!-- <link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/css/bootstrap-multiselect.css"/>-->
   <!-- <link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/css/bootstrap-datetimepicker.min.css"/>-->
<!--	<link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/css/bootstrap-datepicker.min.css"/>-->

    <!-- sweetalert-->
    <link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/css/sweetalert.css">
    <link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/css/toastr.min.css"/>
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
	 <link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/css/fullcalendar.min.css">
  <link rel="stylesheet" href="<?php echo site_url();?>assets/site/main/css/fullcalendar.print.min.css" media="print">
  <link rel="stylesheet" href="https://iohub.tv/assets/site/main/css/jquery.flowchart.css"/>


	 <style type="text/css">
    	.login-logo
		{
			margin:0;
			width: 100%;
		  padding-bottom: 42px;
		}

		.loaddiv
		{
			display:none;
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: #000000;
			z-index: 22222222;
			opacity: 0.8;
			text-align: center;
			padding-top: 20%;
		}
		footer{
			height: 50px;
		}
		.cstmtable{
			border-collapse:collapse;border:1px solid #23282c;
		}

		/* ========= Custom Checkboxes Styles ========= */

		.check-input input[type="checkbox"] {
		    display: none;
		}

		.check-input input[type="checkbox"]+label {
		    display: block;
		    position: relative;
		    /*padding-left: 35px;*/
		    margin-bottom: 20px;
		    font: 14px/20px 'Open Sans', Arial, sans-serif;
		    color: #ddd;
		    cursor: pointer;
		    -webkit-user-select: none;
		    -moz-user-select: none;
		    -ms-user-select: none;
		}

		.check-input input[type="checkbox"]+label:last-child {
		    margin-bottom: 0;
		}

		.check-input input[type="checkbox"]+label:before {
		    content: '';
		    display: block;
		    width: 16px;
		    height: 16px;
		    border: 1px solid #ced0da;
		    border-radius: 3px;
		    position: absolute;
		    left: 0;
		    top: 0;
		    opacity: 1;
		    -webkit-transition: all .12s, border-color .08s;
		    transition: all .12s, border-color .08s;
		}

		.check-input input[type="checkbox"]:checked+label:before {
		    width: 16px;
		    height: 16px;
		    border: 1px solid #3c8dbc;
		    border-radius: 3px;
		    background-color: #3c8dbc;
		    opacity: 1;
		    content: "\f00c";
		    font-family: FontAwesome;
		    line-height: 15px;
		    color: #fff;
		    font-size: 10px;
		    text-align: center;
		}
	</style>

  </head>
  <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    <!-- ============================== Viewport Container Start ============================== -->
    <div class="app">
