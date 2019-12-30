     	 <?php $uri = $_SERVER['REQUEST_URI']; 
			 
		$segment = $this->uri->segment(2);
		//echo $segment;
		
		
		 ?>
	 <!-- ========= Left Sidebar Start ========= -->
        <aside class="main-sidebar leftPanel">
            <section class="sidebar" id="menu">
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="<?php if(!empty($segment) && ($segment == 'dashboard')){echo "active";}else{echo "";} ?>"><a class="" href="<?php echo site_url();?>groupadmin/dashboard"><i class="fa fa-home" aria-hidden="true"></i> <span class="mtext">Dashboard</span></a></li>
                    <li class = "<?php if(!empty($segment) && ($segment == 'configuration' || $segment == "createwowza")){echo "active";}else{echo "";} ?>"><a id = "tab2" href="<?php echo site_url();?>groupadmin/configuration"><i class="fa fa-cogs" aria-hidden="true"></i> <span class="mtext">Configuration</span>
                        </a>
                    </li>
                    <li class = "<?php if(!empty($segment) && ($segment == 'clients' || $segment == "creategroup" || $segment == "createuser")){echo "active";}else{echo "";} ?>"><a href="<?php echo site_url();?>groupadmin/clients"><i class="fa  fa-user-secret" aria-hidden="true" alt="Clients"></i> <span class="mtext">Users</span>
                    	</a>
                    </li>
                  <!--  <li class = "<?php if(!empty($segment) && ($segment == 'permissions')){echo "active";}else{echo "";} ?>"><a href="<?php echo site_url();?>groupadmin/permissions"><i class="fa fa-lock"></i><span class="mtext">Permissions</span></a>
						</li>-->
                    <li class = "<?php if(!empty($segment) && ($segment == 'applications' ||  $segment == "createapplication" || $segment == "createtarget")){echo "active";}else{echo "";} ?>"> <a href="<?php echo site_url();?>groupadmin/applications"><i class="fa fa-bolt" aria-hidden="true"></i> <span class="mtext">Apps</span>  
                        </a>
                    </li>
                    <li class = "<?php if(!empty($segment) && ($segment == 'channels')){echo "active";}else{echo "";} ?>"><a href="<?php echo site_url();?>groupadmin/channels"><i class="fa fa-random" aria-hidden="true"></i> <span class="mtext">Channels</span>  
                        </a>
                    </li>
                    <li><a href="playlist.html"><i class="fa fa-list" aria-hidden="true"></i> <span class="mtext">Playlist</span>
                        </a>
                    </li>
                    <li><a href="schedule.html"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="mtext">Schedule</span>
                        </a>
                    </li>
                    <li><a href="media-library.html"><i class="fa fa-film" aria-hidden="true"></i> <span class="mtext">Media Library</span></a></li>
                    <li><a href="cg.html"><i class="fa fa-font" aria-hidden="true"></i> <span class="mtext">CG</span></a></li>
                    <li class="devider-only"><a href="#"> &nbsp; </a></li>
                    <li><a href="statistics.html"><i class="fa fa-area-chart" aria-hidden="true"></i> <span class="mtext">Statistics</span></a></li>
                    <li><a href="info.html"><i class="fa fa-info-circle" aria-hidden="true"></i> <span class="mtext">Info</span>
                    <li><a href="help.html"><i class="fa fa-question-circle" aria-hidden="true"></i> <span class="mtext">Help</span>
                        </a>
                    </li>
                </ul>
            </section>
        </aside>
        <!-- ========= Left Sidebar End ========= -->
