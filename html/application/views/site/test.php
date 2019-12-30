<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Admin | Dashboard</title>
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
      <!-- ========= CSS Included ========= -->
      <!-- === Bootstrap 3.3.7 === -->
      <link rel="stylesheet" href="assets/css/bootstrap.min.css">
      <!-- === Font Awesome === -->
      <link rel="stylesheet" href="assets/css/font-awesome.min.css">
      <!-- === Core Style === -->
      <link rel="stylesheet" href="assets/css/admin.min.css">
      <link rel="stylesheet" href="assets/css/all-skins.min.css">
      <!-- === Date Picker === -->
      <link rel="stylesheet" href="assets/css/bootstrap-datepicker.min.css">
      <!-- === Custom Css === -->
      <link rel="stylesheet" href="assets/css/custom.css">
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
      <header class="main-header">
         <!-- Logo -->
         <a href="dashboard.html" class="logo">
         <span class="logo-lg"><img src="assets/images/iohub_logo.svg" alt="underground-sign"/></img></span>
         </a>
         <!-- Header Navbar: style can be found in header.less -->
         <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            </a>
            <div class="navbar-custom-menu topbarRight">
               <ul class="nav navbar-nav">
                  <!-- Notifications -->
                  <li>
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                     <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                     </a>
                  </li>
                  <li class="dropdown notifications-menu">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                     <i class="fa fa-bell" aria-hidden="true"></i>
                     <span class="label label-danger">3</span>
                     </a>
                     <ul class="dropdown-menu">
                        <li class="header">You have 3 notifications</li>
                        <li>
                           <!-- inner menu -->
                           <ul class="menu">
                              <li><a href="#"><i class="fa fa-users text-aqua"></i> 5 new members joined today</a></li>
                              <li><a href="#"><i class="fa fa-warning text-yellow"></i> Very long description may cause design problems</a></li>
                              <li><a href="#"><i class="fa fa-users text-red"></i> 5 new members joined</a></li>
                              <li><a href="#"><i class="fa fa-shopping-cart text-green"></i> 25 sales made</a></li>
                              <li><a href="#"><i class="fa fa-user text-red"></i> You changed your username</a></li>
                           </ul>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                     </ul>
                  </li>
                  <!-- Messages -->
                  <li class="dropdown messages-menu">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                     <i class="fa fa-envelope" aria-hidden="true"></i>
                     <span class="label label-danger">4</span>
                     </a>
                     <ul class="dropdown-menu">
                        <li class="header">You have 4 messages</li>
                        <li>
                           <!-- inner menu: contains the actual data -->
                           <ul class="menu">
                              <li>
                                 <a href="#">
                                    <div class="pull-left"><img src="assets/images/avatar2.png" class="img-circle" alt="User Image"></div>
                                    <h4>Support Team <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                    </h4>
                                    <p>Why not buy a new awesome theme?</p>
                                 </a>
                              </li>
                              <li>
                                 <a href="#">
                                    <div class="pull-left">
                                       <img src="assets/images/avatar2.png" class="img-circle" alt="User Image">
                                    </div>
                                    <h4>Admin Design Team
                                       <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                    </h4>
                                    <p>Why not buy a new awesome theme?</p>
                                 </a>
                              </li>
                              <li>
                                 <a href="#">
                                    <div class="pull-left">
                                       <img src="assets/images/avatar2.png" class="img-circle" alt="User Image">
                                    </div>
                                    <h4>Developers
                                       <small><i class="fa fa-clock-o"></i> Today</small>
                                    </h4>
                                    <p>Why not buy a new awesome theme?</p>
                                 </a>
                              </li>
                              <li>
                                 <a href="#">
                                    <div class="pull-left">
                                       <img src="assets/images/avatar2.png" class="img-circle" alt="User Image">
                                    </div>
                                    <h4>Sales Department
                                       <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                    </h4>
                                    <p>Why not buy a new awesome theme?</p>
                                 </a>
                              </li>
                              <li>
                                 <a href="#">
                                    <div class="pull-left">
                                       <img src="assets/images/avatar2.png" class="img-circle" alt="User Image">
                                    </div>
                                    <h4>Reviewers
                                       <small><i class="fa fa-clock-o"></i> 2 days</small>
                                    </h4>
                                    <p>Why not buy a new awesome theme?</p>
                                 </a>
                              </li>
                           </ul>
                        </li>
                        <li class="footer"><a href="#">See All Messages</a></li>
                     </ul>
                  </li>
                  <li class="dropdown user user-menu">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                     <span class="">Admin </span><i class="fa fa-caret-down" aria-hidden="true"></i>
                     </a>
                     <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                           <img src="assets/images/avatar2.png" class="img-circle" alt="User Image">
                           <p>
                              Admin - The Super Power
                              <small>Member since Nov. 2017</small>
                           </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                           <div class="pull-left">
                              <a href="#" class="btn btn-default btn-flat">Profile</a>
                           </div>
                           <div class="pull-right">
                              <a href="#" class="btn btn-default btn-flat">Sign out</a>
                           </div>
                        </li>
                     </ul>
                  </li>
               </ul>
            </div>
         </nav>
      </header>
      <!-- ========= Left Sidebar Start ========= -->
      <aside class="main-sidebar leftPanel">
         <section class="sidebar">
            <ul class="sidebar-menu" data-widget="tree">
               <li class="active"><a href="dashboard.html"><i class="fa fa-home" aria-hidden="true"></i> <span style="display:none;">Dashboard</span></a></li>
               <li><a href="Configuration.html"><i class="fa fa-cogs" aria-hidden="true"></i> <span style="display:none;">Configuration</span>
                  </a>
               </li>
               <li><a href="clients.html"><i class="fa fa-users" aria-hidden="true" alt="Clients"></i> <span style="display:none;">Users</span>
                  </a>
               </li>
               <li><a href="apps.html"><i class="fa fa-bolt" aria-hidden="true"></i> <span style="display:none;">Apps</span>  
                  </a>
               </li>
               <li><a href="playlist.html"><i class="fa fa-list" aria-hidden="true"></i> <span style="display:none;">Playlist</span>
                  </a>
               </li>
               <li><a href="schedule.html"><i class="fa fa-clock-o" aria-hidden="true"></i> <span style="display:none;">Schedule</span>
                  </a>
               </li>
               <li><a href="media-library.html"><i class="fa fa-film" aria-hidden="true"></i> <span style="display:none;">Media Library</span></a></li>
               <li><a href="cg.html"><i class="fa fa-font" aria-hidden="true"></i> <span style="display:none;">CG</span></a></li>
               <li class="devider-only"><a href="#"> &nbsp; </a></li>
               <li><a href="statistics.html"><i class="fa fa-area-chart" aria-hidden="true"></i> <span style="display:none;">Statistics</span></a></li>
               <li>
                  <a href="info.html">
                     <i class="fa fa-info-circle" aria-hidden="true"></i> <span style="display:none;">Info</span>
               <li><a href="help.html"><i class="fa fa-question-circle" aria-hidden="true"></i> <span style="display:none;">Help</span>
               </a>
               </li>
            </ul>
         </section>
      </aside>
      <!-- ========= Left Sidebar End ========= -->
      <!-- ========= Content Wrapper Start ========= -->
      <section class="content-wrapper db-page">
         <!-- ========= Main Content Start ========= -->
         <div class="content">
         <!-- ========= Section One Start ========= -->
         <div class="content-container" style="margin-top: -30px;">
            <div class="col-xs-12" style="padding-bottom: 15px;">
                <div class="row">
                    <h1> Main Dashboard </h1>
                    Overview of Production Server
                </div>
            </div>
        </div>
        <br>
         <div class="content-container">
            <div class="row">
               <div class="col-xs-12">
                  <!-- Production Information -->
                  <div class="box box-solid">
                     <div class="box-header with-border">
                        <h3 class="box-title">Production</h3>
                        <div class="box-tools pull-right">
                           <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                           </button>
                           <button type="button" class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                           </button>
                        </div>
                     </div>
                     <!-- /.box-header -->
                     <div class="box-body">
                        <div class="row">
                           <div class="col-xs-6 col-md-12 text-center">
                              <img src="<?php echo site_url();?>public/site/main/img/Screenshot at May 16 00-33-20.png">
                           </div>
                     </div>
                  </div>
               </div>
            </div>
            </div>
         <!-- ========= Section One End ========= -->
         <!-- ========= Section Two Start ========= -->
            <div class="row">
               <div class="col-xs-12">
                  <!-- Host Information -->
                  <div class="box box-solid">
                     <div class="box-header with-border">
                        <h3 class="box-title">Hosting</h3>
                        <div class="box-tools pull-right">
                           <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                           </button>
                           <button type="button" class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                           </button>
                        </div>
                     </div>
                     <!-- /.box-header -->
                     <div class="box-body">
                        <div class="row">
                           <div class="col-xs-6 col-md-12 text-center">
                              <img src="<?php echo site_url();?>public/site/main/img/Screenshot at May 15 16-53-30.png">
                           </div>
                        </div>
                     </div>
                  </div>
               <!-- ========= Section Two End ========= -->
               <!-- ========= Section Three Start ========= -->
            <div class="row">
               <div class="col-xs-12">
                  <!-- Host Information -->
                  <div class="box box-solid">
                     <div class="box-header with-border">
                        <h3 class="box-title">Network</h3>
                        <div class="box-tools pull-right">
                           <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                           </button>
                           <button type="button" class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                           </button>
                        </div>
                     </div>
                     <!-- /.box-header -->
                     <div class="box-body">
                        <div class="row">
                           <div class="col-xs-6 col-md-12 text-center">
                              <img src="<?php echo site_url();?>public/site/main/img/Screenshot at May 15 16-53-30.png">
                           </div>
                        </div>
                     </div>
                  </div>     
               <!-- ========= Section Three End ========= -->
               <!-- ========= Section Four Start ========= -->
               <h1> System Resources </h1>
               <pstyle="padding-bottom: 15px;">Overview of the system resources e.g encoders & publisher.</p>
                <div class="row">
               <div class="col-xs-12">
                  <!-- Host Information -->
                  <div class="box box-solid">
                     <div class="box-header with-border">
                        <h3 class="box-title">wowza1</h3>
                        <div class="box-tools pull-right">
                           <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                           </button>
                           <button type="button" class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                           </button>
                        </div>
                     </div>
                     <!-- /.box-header -->
                     <div class="box-body">
                        <div class="row">
                           <div class="col-xs-6 col-md-12 text-center">
                              <img src="<?php echo site_url();?>public/site/main/img/Screenshot at May 15 16-53-30.png">
                           </div>
                        </div>
                     </div>
                  </div>
                   <div class="row">
               <div class="col-xs-12">
                  <!-- Host Information -->
                  <div class="box box-solid">
                     <div class="box-header with-border">
                        <h3 class="box-title">wowza2</h3>
                        <div class="box-tools pull-right">
                           <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                           </button>
                           <button type="button" class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                           </button>
                        </div>
                     </div>
                     <!-- /.box-header -->
                     <div class="box-body">
                        <div class="row">
                           <div class="col-xs-6 col-md-12 text-center">
                              <img src="<?php echo site_url();?>public/site/main/img/Screenshot at May 15 16-53-30.png">
                           </div>
                        </div>
                     </div>
                  </div>
                   <div class="row">
               <div class="col-xs-12">
                  <!-- Host Information -->
                  <div class="box box-solid">
                     <div class="box-header with-border">
                        <h3 class="box-title">ott-enc-01</h3>
                        <div class="box-tools pull-right">
                           <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                           </button>
                           <button type="button" class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                           </button>
                        </div>
                     </div>
                     <!-- /.box-header -->
                     <div class="box-body">
                        <div class="row">
                           <div class="col-xs-6 col-md-12 text-center">
                              <img src="<?php echo site_url();?>public/site/main/img/Screenshot at May 15 16-53-30.png">
                           </div>
                        </div>
                     </div>
                  </div>
                   <div class="row">
               <div class="col-xs-12">
                  <!-- Host Information -->
                  <div class="box box-solid">
                     <div class="box-header with-border">
                        <h3 class="box-title">ott-enc-02</h3>
                        <div class="box-tools pull-right">
                           <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                           </button>
                           <button type="button" class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                           </button>
                        </div>
                     </div>
                     <!-- /.box-header -->
                     <div class="box-body">
                        <div class="row">
                           <div class="col-xs-6 col-md-12 text-center">
                              <img src="<?php echo site_url();?>public/site/main/img/Screenshot at May 15 16-53-30.png">
                           </div>
                        </div>
                     </div>
                  </div>
              </div>

               <!-- ========= Section Four End ========= -->
            </div>
            <!-- ========= Main Content End ========= -->
      </section>
      <!-- ========= Content Wrapper End ========= -->
      <footer class="main-footer">
      <div class="footer-container">
      <div class="row">
      <div class="col-md-8 footer-text">Kurrent Stream Manager - Copyright Kurrent Ltd. All rights reserved<br> v1.0</div>
      <div class="col-md-4 footer-text2"><a href="#">Technical Support <i class="fa fa-angle-up"></i></a></div>
      </div>
      </div>
      </footer>
      </div>
      <!-- ============================== Viewport Container End ============================== -->
      <!-- ========= jQuery Included ========= -->
      <script src="assets/js/jquery.min.js"></script>
      <!-- === Bootstrap 3.3.7 === -->
      <script src="assets/js/bootstrap.min.js"></script>
      <!-- === Date Picker === -->
      <script src="assets/js/bootstrap-datepicker.min.js"></script>
      <!-- === Admin Min JS === -->
      <script src="assets/js/admin.min.js"></script>
      <!-- === Custom JS === -->
      <script src="assets/js/custom.js"></script>
   </body>
</html>