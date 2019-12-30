     	 <?php
     	 $uri = $_SERVER['REQUEST_URI'];
		$segment = $this->uri->segment(1);
		 ?>
<div class="sidebar">
        <nav class="sidebar-nav">
          <ul class="nav">
            <?php
                	$permissions = $this->session->userdata('user_permissions');
                	$userdata = $this->session->userdata('user_data');
                	//print_r($userdata);
					if($permissions['view_dashboard'] > 0)
					{
					?>
					 <li class="nav-item <?php if(!empty($segment) && ($segment == 'dashboard')){echo "active";}else{echo "";} ?>"><a class="nav-link" href="<?php echo site_url();?>dashboard"><i class="nav-icon icon-speedometer" aria-hidden="true"></i> <span class="mtext">Dashboard</span></a></li>
					<?php
					}
					if($permissions['create_wowza'] > 0 || $permissions['edit_wowza'] > 0 || $permissions['delete_wowza'] > 0 || $permissions['create_encoder'] > 0 || $permissions['edit_encoder'] > 0 || $permissions['delete_encoder'] > 0 || $permissions['create_template'] > 0 || $permissions['edit_template'] > 0 || $permissions['delete_template'] > 0)
					{
					?>
					 <li class = "nav-item <?php if(!empty($segment) && ($segment == 'configuration' || $segment == "createwowza" || $segment == "addEncoderes" ||  $segment == "createtemplate")){echo "active";}else{echo "";} ?>"><a id = "tab2" class="nav-link" href="<?php echo site_url();?>configuration"><i class="nav-icon icon-settings" aria-hidden="true"></i> <span class="mtext">Settings</span>
                        </a>
                    </li>
					<?php
					}
					if($permissions['create_group'] > 0 || $permissions['edit_group'] > 0 || $permissions['delete_group'] > 0 || $permissions['create_user'] > 0 || $permissions['edit_user'] > 0 || $permissions['delete_user'] > 0)
					{
					?>
					  <li class = "nav-item <?php if(!empty($segment) && ($segment == 'clients' || $segment == "creategroup" || $segment == "createuser")){echo "active";}else{echo "";} ?>"><a class="nav-link" href="<?php echo site_url();?>clients"><i class="nav-icon icon-people" aria-hidden="true" alt="Clients"></i> <span class="mtext">Clients</span>
                    	</a>
                    </li>
					<?php
					}
					if($permissions['create_application'] > 0 || $permissions['edit_application'] > 0 || $permissions['delete_application'] > 0 || $permissions['create_target'] > 0 || $permissions['edit_target'] > 0 || $permissions['delete_target'] > 0)
					{
					?>
					  <li class = "nav-item <?php if(!empty($segment) && ($segment == 'applications' ||  $segment == "createapplication" || $segment == "createtarget")){echo "active";}else{echo "";} ?>"> <a class="nav-link" href="<?php echo site_url();?>applications"><i class="nav-icon fa fa-bolt" aria-hidden="true"></i> <span class="mtext">Apps</span>
                        </a>
                    </li>
					<?php
					}

					if($permissions['create_channel'] > 0 || $permissions['edit_channel'] > 0 || $permissions['delete_channel'] > 0)
					{
					?>
					  <li class = "nav-item <?php if(!empty($segment) && ($segment == 'channels') || ($segment == 'createchannel') ){echo "active";}else{echo "";} ?>"><a class="nav-link" href="<?php echo site_url();?>channels"><i class="nav-icon icon-shuffle" aria-hidden="true"></i> <span class="mtext">Channels</span>
                        </a>
                    </li>

          <?php
          }

          if($permissions['create_channel'] > 0 || $permissions['edit_channel'] > 0 || $permissions['delete_channel'] > 0)
          {
          ?>
            <li class = "nav-item <?php if(!empty($segment) && ($segment == 'channels') || ($segment == 'createchannel') ){echo "active";}else{echo "";} ?>"><a class="nav-link" href="<?php echo site_url();?>workflowlist"><i class="nav-icon fa fa-sitemap" aria-hidden="true"></i> <span class="mtext">Workflows</span>
                        </a>
                  </li>
        <?php
        if($permissions['view_schedule'] > 0)
        {
        ?>
         <li class="nav-item"><a class="nav-link" href="<?php echo site_url();?>schedule"><i class="nav-icon icon-calendar" aria-hidden="true" style="background-position:14px 14px;"></i> <span class="mtext">Scheduler</span>
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
					  <li class="nav-item"><a class="nav-link" href="<?php echo site_url();?>gateway"><i class="nav-icon icon-size-fullscreen" aria-hidden="true"></i> <span class="mtext">NDI Gateway</span>
                        </a>
                    </li>
					<?php
					}
                	?>

                     <?php
                    if($permissions['view_playlist'] > 0)
					{
					?>
					  <li class="nav-item"><a class="nav-link" href="<?php echo site_url();?>"><i class="nav-icon icon-list" aria-hidden="true"></i> <span class="mtext">Playlist</span>
                        </a>
                    </li>
					<?php
					}
                    ?>

          <?php
                    if($permissions['view_media'] > 0)
					{
					?>
					  <li class="nav-item"><a class="nav-link" href="media-library.html"><i class="nav-icon fa fa-film" aria-hidden="true"></i> <span class="mtext">Media Library</span></a></li>
					<?php
					}
                    ?>
 					 <li class="nav-item nav-dropdown"><a class="nav-link nav-dropdown-toggle" href="#">
 					 <i class="nav-icon fa fa-database" aria-hidden="true"></i> <span class="mtext">Assets</span>
                        </a>
                        <ul class="nav-dropdown-items">
                        	<?php
                        	if($userdata['user_type'] == 1){
								$nebulas = $this->common_model->getNebula(0);
								if(sizeof($nebulas)>0)
								{
									foreach($nebulas as $nebul){
										?>
										<li class="nav-item">
										<a class="nav-link" href="<?php echo site_url();?>assets/<?php echo $nebul['id']; ?>"><i class="nav-icon fa fa-film" aria-hidden="true"></i> <span class="mtext"><?php echo $nebul['encoder_name']; ?></span></a></li>
										<?php
									}
								}
							}else if($userdata['user_type'] > 1){
								$nebulas = $this->common_model->getNebula($userdata['group_id']);
								if(sizeof($nebulas)>0)
								{
									foreach($nebulas as $nebul){
										?>
										<li class="nav-item">
										<a class="nav-link" href="<?php echo site_url();?>assets/<?php echo $nebul['id']; ?>"><i class="nav-icon fa fa-film" aria-hidden="true"></i> <span class="mtext"><?php echo $nebul['encoder_name']; ?></span></a></li>
										<?php
									}
								}
							}
                        	?>
                        </ul>
                    </li>
                     <li class="nav-item"><a class="nav-link" href="<?php echo site_url();?>rundowns"><i class="nav-icon icon-list" aria-hidden="true"></i> <span class="mtext">Rundowns</span>
                        </a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo site_url();?>jobs"><i class="nav-icon fa fa-tasks" aria-hidden="true"></i> <span class="mtext">Jobs</span>
                        </a>
                    </li>
                      <?php
                    if($permissions['view_archive'] > 0)
					{
					?>
					 <li class="nav-item"><a class="nav-link" href="<?php echo site_url();?>archive"><i class="nav-icon fa fa-archive" aria-hidden="true"></i> <span class="mtext">Archive</span></a></li>
					<?php
					}

					if($permissions['view_cg'] > 0)
					{
					?>
					  <li class="nav-item"><a class="nav-link" href="<?php echo site_url();?>"><i class="nav-icon fa fa-font" aria-hidden="true"></i> <span class="mtext">CG</span></a></li>
					<?php
					}

                    ?>


                    <li class="devider-only"><a  href="#"> &nbsp; </a></li>
                    <?php
                    if($permissions['view_statistics'] > 0)
					{
					?>
					  <li class="nav-item"><a class="nav-link" href="<?php echo site_url();?>"><i class="nav-icon fa fa-area-chart" aria-hidden="true"></i> <span class="mtext">Statistics</span></a></li>
					<?php
					}
					if($permissions['view_info'] > 0)
					{
					?>
					  <li class="nav-item"><a class="nav-link" href="<?php echo site_url();?>"><i class="nav-icon fa fa-info-circle" aria-hidden="true"></i> <span class="mtext">Info</span></a></li>
					<?php
					}?>



                    <?php
                    if($permissions['view_logs'] > 0)
					{
					?>
					<li class = "nav-item <?php if(!empty($segment) && ($segment == 'logs')){echo "active";}else{echo "";} ?>"><a class="nav-link" href="<?php echo site_url();?>logs"><i class="nav-icon fa fa-history" aria-hidden="true"></i> <span class="mtext">Logs</span>
                        </a>
                    </li>
					<?php
					}
                    ?>
 					<?php
                    if($permissions['view_help'] > 0)
					{
					?>
					<li class="nav-item"><a class="nav-link" href="<?php echo site_url();?>help"><i class="nav-icon cui-lightbulb" aria-hidden="true"></i> <span class="mtext">Help</span>
                        </a>
                    </li>
					<?php
					}
                    ?>

                       <?php
                    if($permissions['view_extra'] > 0)
					{
					?>
					 <li class="nav-item"><a class="nav-link" href="<?php echo site_url();?>extra"><i class="nav-icon icon-present" aria-hidden="true"></i> <span class="mtext">Extra</span>
                        </a>
                    </li>
					<?php
					}
                    ?>


          </ul>
        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
      </div>
