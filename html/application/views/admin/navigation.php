<style type="text/css">
.clock .jcgmt-digital
{
	color: white;font-size: 15px;font-weight: 400;
}
</style>
     	 <?php
     	 $uri = $_SERVER['REQUEST_URI'];
		$segment = $this->uri->segment(1);
		 ?>
<header class="app-header navbar">
      <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="#">
        <img class="navbar-brand-full" src="<?php echo site_url();?>public/site/main/img/logo.png" width="auto" height="40" alt="iohub Logo">
        <img class="navbar-brand-minimized" src="<?php echo site_url();?>public/site/main/img/sygnet.png" width="auto" height="40" alt="iohub Logo">
      </a>
      <button class="navbar-toggler sidebar-toggler d-md-down-none opentopmenu" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
      </button>
      <ul class="nav navbar-nav d-md-down-none upparmenu dnone">
      	<?php
                	$permissions = $this->session->userdata('user_permissions');
					if($permissions['view_dashboard'] > 0)
					{
					?>
					 <li class="nav-item px-3 <?php if(!empty($segment) && ($segment == 'dashboard')){echo "active";}else{echo "";} ?>"><a class="nav-link" href="<?php echo site_url();?>dashboard">Dashboard</a></li>
					<?php
					}
					if($permissions['create_wowza'] > 0 || $permissions['edit_wowza'] > 0 || $permissions['delete_wowza'] > 0 || $permissions['create_encoder'] > 0 || $permissions['edit_encoder'] > 0 || $permissions['delete_encoder'] > 0 || $permissions['create_template'] > 0 || $permissions['edit_template'] > 0 || $permissions['delete_template'] > 0)
					{
					?>
					 <li class = "nav-item px-3 <?php if(!empty($segment) && ($segment == 'configuration' || $segment == "createwowza" || $segment == "addEncoderes" ||  $segment == "createtemplate")){echo "active";}else{echo "";} ?>"><a id = "tab2" class="nav-link" href="<?php echo site_url();?>configuration">Settings
                        </a>
                    </li>
					<?php
					}
					if($permissions['create_group'] > 0 || $permissions['edit_group'] > 0 || $permissions['delete_group'] > 0 || $permissions['create_user'] > 0 || $permissions['edit_user'] > 0 || $permissions['delete_user'] > 0)
					{
					?>
					  <li class = "nav-item px-3 <?php if(!empty($segment) && ($segment == 'clients' || $segment == "creategroup" || $segment == "createuser")){echo "active";}else{echo "";} ?>"><a class="nav-link" href="<?php echo site_url();?>clients">Clients
                    	</a>
                    </li>
					<?php
					}
					if($permissions['create_application'] > 0 || $permissions['edit_application'] > 0 || $permissions['delete_application'] > 0 || $permissions['create_target'] > 0 || $permissions['edit_target'] > 0 || $permissions['delete_target'] > 0)
					{
					?>
					  <li class = "nav-item px-3 <?php if(!empty($segment) && ($segment == 'applications' ||  $segment == "createapplication" || $segment == "createtarget")){echo "active";}else{echo "";} ?>"> <a class="nav-link" href="<?php echo site_url();?>applications">Apps
                        </a>
                    </li>
					<?php
					}

					if($permissions['create_channel'] > 0 || $permissions['edit_channel'] > 0 || $permissions['delete_channel'] > 0)
					{
					?>
					  <li class = "nav-item px-3 <?php if(!empty($segment) && ($segment == 'channels') || ($segment == 'createchannel') ){echo "active";}else{echo "";} ?>"><a class="nav-link" href="<?php echo site_url();?>channels">Channels
                        </a>
                    </li>
										<?php
										}

										if($permissions['create_channel'] > 0 || $permissions['edit_channel'] > 0 || $permissions['delete_channel'] > 0)
										{
										?>
											<li class = "nav-item px-3 <?php if(!empty($segment) && ($segment == 'channels') || ($segment == 'createchannel') ){echo "active";}else{echo "";} ?>"><a class="nav-link" href="<?php echo site_url();?>channels">Workflows
																	</a>
															</li>
															<?php
															if($permissions['view_schedule'] > 0)
															{
															?>
															<li class="nav-item px-3"><a class="nav-link" href="<?php echo site_url();?>schedule">Scheduler
																	</a>
															</li>
															<?php
															}
															?>
					<?php
					}
					if($permissions['view_gateway'] > 0)
					{
					?>
					  <li class="nav-item px-3"><a class="nav-link" href="<?php echo site_url();?>gateway">NDI Gateway                        </a>
                    </li>
					<?php
					}
                	?>

                     <?php
                    if($permissions['view_playlist'] > 0)
					{
					?>
					  <li class="nav-item px-3"><a class="nav-link" href="<?php echo site_url();?>">Playlist
                        </a>
                    </li>
					<?php
					}
                    ?>
        	<?php
                    if($permissions['view_media'] > 0)
					{
					?>
					  <li class="nav-item px-3"><a class="nav-link" href="media-library.html">Media Library</li>
					<?php
					}
                    ?>
 				<li class="nav-item px-3"><a class="nav-link" href="<?php echo site_url();?>asset">Assets</a></li>
  				<li class="nav-item px-3"><a class="nav-link" href="<?php echo site_url();?>rundowns">Rundowns</a></li>
  				<li class="nav-item px-3"><a class="nav-link" href="<?php echo site_url();?>jobs">Jobs</a></li>
                      <?php
                    if($permissions['view_archive'] > 0)
					{
					?>
					 <li class="nav-item px-3"><a class="nav-link" href="<?php echo site_url();?>archive">Archive</a></li>
					<?php
					}

					if($permissions['view_cg'] > 0)
					{
					?>
					  <li class="nav-item px-3"><a class="nav-link" href="<?php echo site_url();?>">CG</a></li>
					<?php
					}

                    ?>

                    <?php
                    if($permissions['view_statistics'] > 0)
					{
					?>
					  <li class="nav-item px-3"><a class="nav-link" href="<?php echo site_url();?>">Statistics</a></li>
					<?php
					}
					if($permissions['view_info'] > 0)
					{
					?>
					  <li class="nav-item px-3"><a class="nav-link" href="<?php echo site_url();?>">Info</a></li>
					<?php
					}?>



                    <?php
                    if($permissions['view_logs'] > 0)
					{
					?>
					<li class = "nav-item px-3 <?php if(!empty($segment) && ($segment == 'logs')){echo "active";}else{echo "";} ?>"><a class="nav-link" href="<?php echo site_url();?>logs">Logs
                        </a>
                    </li>
					<?php
					}
                    ?>
 					<?php
                    if($permissions['view_help'] > 0)
					{
					?>
					<li class="nav-item px-3"><a class="nav-link" href="<?php echo site_url();?>help">Help
                        </a>
                    </li>
					<?php
					}
                    ?>

                       <?php
                    if($permissions['view_extra'] > 0)
					{
					?>
					 <li class="nav-item px-3"><a class="nav-link" href="<?php echo site_url();?>extra">Extra
                        </a>
                    </li>
					<?php
					}
                    ?>

      </ul>
      <ul class="nav navbar-nav ml-auto">
				<li class="nav-item dropdown">
				<div id="dtz">
					<?php $userdata = $this->session->userdata('user_data');
								//print_r($userdata);
								$time = $this->common_model->getTimezoneById($userdata['timezone']);
								$d = date('Y-m-d');
								$t = date('h:i:s');
								$startTime  = $d."T".$t.".00Z";
								$d = date_format(date_create(date('Y-m-d H:i:s',strtotime("+2 min")))->setTimezone(new DateTimeZone('CET')), 'c');?>
								<div id="current_timer" style="float: right;font-size: 20px;font-weight:200;width: 100%;margin-bottom: -10px;color:white;" title="<?php echo $time[0]['time_value'];?>" ></div><br>
								<span style="font-size: 10px;width: 100%;text-align: center;float:right;"><?php echo $time[0]['gmtAdjustment'];?></span>

				</div>
				</li>
				<li class="nav-item dropdown">
          <a class="nav-link nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
             <?php
             $userdata = $this->session->userdata('user_data');           
             $gid = $userdata['group_id'];
              $img = $this->common_model->getGgoupImage($gid);

						          if(sizeof($img) <= 0)
						          {
						          ?>
						          <img class="img-avatar" id="imgdiv" src="<?php echo site_url();?>public/site/main/images/admin-dummy.png"/>
						          <?php
						          }
						          else
						          {
						          ?>
						          <img class="img-avatar" id="imgdiv" src="<?php echo site_url();?>public/site/main/group_pics/<?php echo $img[0]['name'];?>"/>
						          <?php
						          }
						        ?>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-header text-center">
              <strong><?php $userdata = $this->session->userdata('user_data'); echo $userdata['fname'].' '.$userdata['lname'];?></strong>
            </div>

            <a class="dropdown-item" href="<?php echo site_url();?>updateuser/<?php echo $userdata['userid'];?>">
              <i class="fa fa-user"></i> Profile</a>
            <a class="dropdown-item" id="lockscreen" href="javascript:void(0);">
              <i class="fa fa-shield"></i> Lock Screen</a>
            <a class="dropdown-item" href="<?php echo site_url();?>user/logout">
              <i class="fa fa-lock"></i> Logout</a>
          </div>
        </li>

      </ul>

      <button class="navbar-toggler aside-menu-toggler d-md-down-none" type="button" data-toggle="aside-menu-lg-show">
        <span class="navbar-toggler-icon"></span>
      </button>
      <button class="navbar-toggler aside-menu-toggler d-lg-none" type="button" data-toggle="aside-menu-show">
        <span class="navbar-toggler-icon"></span>
      </button>
    </header>
        <div class="app-body">
