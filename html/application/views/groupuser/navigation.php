<header class="main-header">
            <!-- Logo -->
            <a href="dashboard.html" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">KS<span class="text-one">M</span></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">Kurrent Stream <span class="text-one">Manager</span> <span class="text-two">v1.0</span></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>

                <div class="navbar-custom-menu topbarRight">
                    <ul class="nav navbar-nav">
                    	<li>
                            <a id="lockscreen" href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                            </a>
                        </li>
                        <!-- Notifications -->
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
                                <span class="">Group User </span><i class="fa fa-caret-down" aria-hidden="true"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                	<?php
                                	$userdata = $this->session->userdata('user_data');
                                		if($userdata['userImage'] == "")
                                		{
											?>
											<img src="<?php echo site_url();?>assets/site/main/images/avatar2.png" class="img-circle" alt="User Image">  
											<?php		
										}
										else
										{
											?>
											<img src="<?php echo site_url();?>assets/site/main/group_pics/<?php echo $userdata['userImage'];?>" class="img-circle" alt="User Image">  
											
											<?php		
										}
                                	?>
                                    <p>                                    
                                    <?php
                                    
                                    echo $userdata['fname'].' '.$userdata['lname'];
                                    ?>
				                     </br>
                                       
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo site_url();?>groupuser/profile" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo site_url();?>user/logout" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>