     <!-- ========= Left Sidebar Start ========= -->
	 <?php $uri = $_SERVER['REQUEST_URI']; 
		 
		$segment = $this->uri->segment(2);
		//echo $segment;
		
		 ?>
        <aside class="main-sidebar leftPanel">
            <section class="sidebar">
                <ul class="sidebar-menu" data-widget="tree">
				
				
				
                    <li class="<?php if(!empty($segment) && ($segment == 'dashboard')){echo "active";}else{echo "";} ?>"><a href="<?php echo site_url();?>groupuser/dashboard"><i class="fa fa-home" aria-hidden="true"></i> <span style="display:none;">Dashboard</span></a></li>
					
					
					
                   <li class="<?php if(!empty($segment) && ($segment == 'configuration')){echo "active";}else{echo "";} ?>"><a href="<?php echo site_url();?>groupuser/configuration"><i class="fa fa-cogs" aria-hidden="true"></i> <span style="display:none;">Configuration</span>
                        </a>
                    </li>
                   <!-- <li class="<?php if(!empty($segment) && ($segment == 'clients')){echo "active";}else{echo "";} ?>"><a href="<?php echo site_url();?>groupuser/clients"><i class="fa fa-users" aria-hidden="true" alt="Clients"></i> <span style="display:none;">Users</span>
                    	</a>
                    </li>-->
                   
                    <li class="<?php if(!empty($segment) && ($segment == 'applications')){echo "active";}else{echo "";} ?>"><a href="<?php echo site_url();?>groupuser/applications"><i class="fa fa-bolt" aria-hidden="true"></i> <span style="display:none;">Apps</span>  
                        </a>
                    </li>
                   
                    <li><a href="media-library.html"><i class="fa fa-film" aria-hidden="true"></i> <span style="display:none;">Media Library</span></a></li>
                    <li><a href="cg.html"><i class="fa fa-font" aria-hidden="true"></i> <span style="display:none;">CG</span></a></li>
                    <li class="devider-only"><a href="#"> &nbsp; </a></li>
                    <li><a href="statistics.html"><i class="fa fa-area-chart" aria-hidden="true"></i> <span style="display:none;">Statistics</span></a></li>
                    <li><a href="info.html"><i class="fa fa-info-circle" aria-hidden="true"></i> <span style="display:none;">Info</span>
                    <li><a href="help.html"><i class="fa fa-question-circle" aria-hidden="true"></i> <span style="display:none;">Help</span>
                        </a>
                    </li>
                </ul>
            </section>
        </aside>
        <!-- ========= Left Sidebar End ========= -->
