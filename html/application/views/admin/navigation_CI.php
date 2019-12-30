<style type="text/css">
.clock .jcgmt-digital
{
	color: white;font-size: 15px;font-weight: 400;
}
</style>
<header class="main-header">
            <!-- Logo -->
            <a href="<?php echo site_url();?>" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <!--<span class="logo-mini">S<span class="text-one">M</span></span>-->
         <!--       <object class="logo-mini" type="image/svg+xml" data="<?php echo site_url();?>assets/site/main/img/iohub_logo.png">
  Your browser does not support SVG
</object>-->
<img class="logo-mini" src="<?php echo site_url();?>assets/site/main/img/iohub-logo.png"/>
                <!-- logo for regular state and mobile devices -->
                <!--<span class="logo-lg">Stream <span class="text-one">Manager</span> <span class="text-two">v1.0</span></span>-->
            <!--   <object style="width:50px;" type="image/svg+xml" data="<?php echo site_url();?>assets/site/main/img/iohub_logo.png">
  Your browser does not support SVG
</object>-->
<img class="logo-lg" src="<?php echo site_url();?>assets/site/main/img/sygnet.png"/>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <?php echo $this->breadcrumbs->show();?>
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>



                <div class="navbar-custom-menu topbarRight">
                <div id="dtz">

                      	<?php
                      	$userdata = $this->session->userdata('user_data');
                      	//print_r($userdata);
                      	$time = $this->common_model->getTimezoneById($userdata['timezone']);
                    $d = date('Y-m-d');
					$t = date('h:i:s');
					$startTime  = $d."T".$t.".00Z";
					$d = date_format(date_create(date('Y-m-d H:i:s',strtotime("+2 min")))->setTimezone(new DateTimeZone('CET')), 'c');

                      	?>

                          <span style="color:white;float:right;"><?php echo $time[0]['gmtAdjustment'];?></span><span style="color:gray;float:right;"> | </span>
                           <div id="current_timer" style="float:right;color:white;" title="<?php echo $time[0]['time_value'];?>" class="clock"></div>
                      </div>
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
                               <!-- <span class="label label-danger">3</span>-->
                            </a>
                            <ul class="dropdown-menu" style="display:none;">
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
                                <!--<span class="label label-danger">4</span>-->
                            </a>
                            <ul class="dropdown-menu" style="display:none;">
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

                                <span class="" style="top:16px;color:#fff;position: relative;font-size: 12px;"><?php
                                $userdata = $this->session->userdata('user_data');
                                 echo $userdata['fname'];?> </span>

                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                	<?php


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
				                     <br/>

                                    </p>
                                </li>
                                <!-- Menu Footer-->
                            </ul>
                        </li>
                        <li>

                        <?php
                        if($userdata['user_type'] == 1)
                        {
                        	?>
                        	<a href="<?php echo site_url();?>configuration"><i class="fa fa-gear" aria-hidden="true"></i></a>
                        	<?php
						}
						elseif($userdata['user_type'] == 2 || $userdata['user_type'] == 3)
                        {
                        	?>
                        	<a href="<?php echo site_url();?>updateuser/<?php echo $userdata['userid'];?>"><i class="fa fa-gear" aria-hidden="true"></i></a>
                        	<?php
						}
                        ?>

                          </li>
                          <li>
                            <a href="<?php echo site_url();?>user/logout"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
                          </li>
                    </ul>
                </div>
            </nav>
        </header>
