     	 <?php 
     	 $uri = $_SERVER['REQUEST_URI']; 			 
		$segment = $this->uri->segment(1);
		 ?>
	 <!-- ========= Left Sidebar Start ========= -->
        <aside class="main-sidebar leftPanel">
        
        
        
        
            <section class="sidebar" id="menu">
                <ul class="sidebar-menu" data-widget="tree">
                
                	
                	<?php
                	$permissions = $this->session->userdata('user_permissions');			
					if($permissions['view_dashboard'] > 0)
					{				
					?>
					 <li class="<?php if(!empty($segment) && ($segment == 'dashboard')){echo "active";}else{echo "";} ?>"><a class="" href="<?php echo site_url();?>dashboard"><i class="fa fa-home" aria-hidden="true"></i> <span class="mtext">Dashboard</span></a></li>
					<?php
					}
					if($permissions['create_wowza'] > 0 || $permissions['edit_wowza'] > 0 || $permissions['delete_wowza'] > 0 || $permissions['create_encoder'] > 0 || $permissions['edit_encoder'] > 0 || $permissions['delete_encoder'] > 0 || $permissions['create_template'] > 0 || $permissions['edit_template'] > 0 || $permissions['delete_template'] > 0)
					{				
					?>
					 <li class = "<?php if(!empty($segment) && ($segment == 'configuration' || $segment == "createwowza" || $segment == "addEncoderes" ||  $segment == "createtemplate")){echo "active";}else{echo "";} ?>"><a id = "tab2" href="<?php echo site_url();?>configuration"><i class="fa fa-cogs" aria-hidden="true"></i> <span class="mtext">Configuration</span>
                        </a>
                    </li>
					<?php
					}
					if($permissions['create_group'] > 0 || $permissions['edit_group'] > 0 || $permissions['delete_group'] > 0 || $permissions['create_user'] > 0 || $permissions['edit_user'] > 0 || $permissions['delete_user'] > 0)
					{				
					?>
					  <li class = "<?php if(!empty($segment) && ($segment == 'clients' || $segment == "creategroup" || $segment == "createuser")){echo "active";}else{echo "";} ?>"><a href="<?php echo site_url();?>clients"><i class="fa  fa-user-secret" aria-hidden="true" alt="Clients"></i> <span class="mtext">Clients</span>
                    	</a>
                    </li> 
					<?php
					}
					if($permissions['create_application'] > 0 || $permissions['edit_application'] > 0 || $permissions['delete_application'] > 0 || $permissions['create_target'] > 0 || $permissions['edit_target'] > 0 || $permissions['delete_target'] > 0)
					{				
					?>
					  <li class = "<?php if(!empty($segment) && ($segment == 'applications' ||  $segment == "createapplication" || $segment == "createtarget")){echo "active";}else{echo "";} ?>"> <a href="<?php echo site_url();?>applications"><i class="fa fa-bolt" aria-hidden="true"></i> <span class="mtext">Apps</span>  
                        </a>
                    </li>
					<?php
					}
					
					if($permissions['create_channel'] > 0 || $permissions['edit_channel'] > 0 || $permissions['delete_channel'] > 0)
					{				
					?>
					  <li class = "<?php if(!empty($segment) && ($segment == 'channels') || ($segment == 'createchannel') ){echo "active";}else{echo "";} ?>"><a href="<?php echo site_url();?>channels"><i class="fa fa-random" aria-hidden="true"></i> <span class="mtext">Channels</span>  
                        </a>
                    </li>
					<?php
					}
					if($permissions['view_gateway'] > 0)
					{				
					?>
					  <li><a href="<?php echo site_url();?>gateway"><i class="fa fa-anchor" aria-hidden="true"></i> <span class="mtext">Gateway</span>
                        </a>
                    </li>
					<?php
					}
                	?>
                   
                     <?php
                    if($permissions['view_playlist'] > 0)
					{				
					?>
					  <li><a href="<?php echo site_url();?>"><i class="fa fa-list" aria-hidden="true"></i> <span class="mtext">Playlist</span>
                        </a>
                    </li>
					<?php
					}                    
                    ?>
                                    
                   
                   
                    
                   
                    <?php
                    if($permissions['view_schedule'] > 0)
					{				
					?>
					 <li><a href="<?php echo site_url();?>schedule"><i class="fa fa-clock-o" aria-hidden="true"></i> <span class="mtext">Schedule</span>
                        </a>
                    </li>
					<?php
					}                    
                    ?>
                     <?php
                    if($permissions['view_media'] > 0)
					{				
					?>
					  <li><a href="media-library.html"><i class="fa fa-film" aria-hidden="true"></i> <span class="mtext">Media Library</span></a></li>
					<?php
					}                    
                    ?>
                   
                      <?php
                    if($permissions['view_archive'] > 0)
					{				
					?>
					 <li><a href="<?php echo site_url();?>archive"><i class="fa fa-archive" aria-hidden="true"></i> <span class="mtext">Archive</span></a></li>
					<?php
					} 
					
					if($permissions['view_cg'] > 0)
					{				
					?>
					  <li><a href="<?php echo site_url();?>"><i class="fa fa-font" aria-hidden="true"></i> <span class="mtext">CG</span></a></li>
					<?php
					} 
					                    
                    ?>
                   
                   
                    <li class="devider-only"><a href="#"> &nbsp; </a></li>
                    <?php
                    if($permissions['view_statistics'] > 0)
					{				
					?>
					  <li><a href="<?php echo site_url();?>"><i class="fa fa-area-chart" aria-hidden="true"></i> <span class="mtext">Statistics</span></a></li>
					<?php
					}
					if($permissions['view_info'] > 0)
					{				
					?>
					  <li><a href="<?php echo site_url();?>"><i class="fa fa-info-circle" aria-hidden="true"></i> <span class="mtext">Info</span></a></li>
					<?php
					}?>
                    
                    
                    
                    <?php
                    if($permissions['view_logs'] > 0)
					{				
					?>
					<li class = "<?php if(!empty($segment) && ($segment == 'logs')){echo "active";}else{echo "";} ?>"><a href="<?php echo site_url();?>logs"><i class="fa fa-history" aria-hidden="true"></i> <span class="mtext">Logs</span>  
                        </a>
                    </li>
					<?php
					}                    
                    ?>
 					<?php
                    if($permissions['view_help'] > 0)
					{				
					?>
					<li><a href="<?php echo site_url();?>help"><i class="fa fa-question-circle" aria-hidden="true"></i> <span class="mtext">Help</span>
                        </a>
                    </li>
					<?php
					}                    
                    ?>
                    
                       <?php
                    if($permissions['view_extra'] > 0)
					{				
					?>
					 <li><a href="<?php echo site_url();?>extra"><i class="fa fa-gift" aria-hidden="true"></i> <span class="mtext">Extra</span>
                        </a>
                    </li>
					<?php
					}                    
                    ?>
                   
                </ul>
            </section>
           
          
            
        </aside>
        <!-- ========= Left Sidebar End ========= -->
