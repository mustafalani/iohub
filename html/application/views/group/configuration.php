

<?php $this->load->view('group/navigation.php');?>
<?php $this->load->view('group/leftsidebar.php');?>

																				
  <!-- ========= Content Wrapper Start ========= -->
        <section class="content-wrapper">
            <!-- ========= Main Content Start ========= -->
            <div class="content">

                <div class="content-container">
                			  		 <?php
	if($this->session->flashdata('message_type') == "success")
	{
		?>			
		<div id="card-alert" class="card green lighten-5">
	      <div class="card-content green-text">
	        <p>SUCCESS : <?php echo $this->session->flashdata('success');?></p>
	      </div>
	      <button type="button" class="close green-text" data-dismiss="alert" aria-label="Close">
	        <span aria-hidden="true">×</span>
	      </button>
	    </div>
		<?php	
		}
		if($this->session->flashdata('message_type') == "error")
	{
		?>
		<div id="card-alert" class="card red lighten-5">
	      <div class="card-content red-text">
	        <p>DANGER : <?php echo $this->session->flashdata('error');?></p>
	      </div>
	      <button type="button" class="close red-text" data-dismiss="alert" aria-label="Close">
	        <span aria-hidden="true">×</span>
	      </button>
	    </div>			
		<?php	
		}

	?>
                    <div class="row">
                        <!-- ========= Section One Start ========= -->
                        <div class="col-lg-12 col-12-12">
                            <div class="content-box config-contentonly">
                                <div class="config-container">
                                    <!-- === Nav tabs === -->
                                    <div class="tab-btn-container">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#systems" aria-controls="systems" role="tab" data-toggle="tab">Systems</a></li>
                                            <li role="presentation"><a href="#wowza" aria-controls="wowza" role="tab" data-toggle="tab">Wowza</a></li>
                                            <li role="presentation"><a href="#ffmpeg" aria-controls="ffmpeg" role="tab" data-toggle="tab">FFMPEG</a></li>
                                        </ul>
                                        
                                    </div>

                                    <!-- === Tab panes === -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="systems">
                                            <form  class="form-only form-one" method="post" action="<?php echo site_url();?>groupadmin/updategroupanduserinfo" enctype="multipart/form-data">
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                                <div class="row">
                                                    <div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                            <label>Company Name <span class="mndtry">*</span></label>
                                                            <input type="text" class="form-control" placeholder="Kurrent" name="group_name" value="<?php echo $groupinfo[0]['group_name'];?>"> 
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Email <span class="mndtry">*</span></label>
                                                            <input type="text" class="form-control" placeholder="info@kurrent.tv" name="group_email" value="<?php echo $groupinfo[0]['group_email'];?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>License <span class="mndtry">*</span></label>
                                                            <input type="text" class="form-control" placeholder="Demo" name="group_licence" value="<?php echo $groupinfo[0]['group_licence'];?>">
                                                            <span class="text-five">9999 days remaining</span>
                                                        </div>
                                                        <button type="submit" class="btn-def save">
									<span><i class="fa fa-save"></i> Save</span>
								    </button>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                           <label>Time Zone <span class="mndtry">*</span></label>
                                                            <div class="custom-select">
                                                               
																<select id="timezone" name="timezone" class="form-control"  required="true">           
																 <option value="0">Time Zone</option>          
																	 <?php 
																	 $timezoness = $this->common_model->getAllTimezone();                  			
																		if(sizeof($timezoness)>0)
																		{
																			foreach($timezoness as $timezones)
																			{
																				if($timezones['id'] == $timezone)
																				{
																					echo '<option selected="selected" value="'.$timezones['id'].'">'.$timezones['time_zone_name'].'</option>';	
																				}
																				else
																				{
																					echo '<option value="'.$timezones['id'].'">'.$timezones['time_zone_name'].'</option>';	
																				}
																			}
																		}
																		
																		?> 
																		
																</select>  
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Date Format <span class="mndtry">*</span></label>
                                                            <div class="input-group date" data-provide="datepicker2">
                                                                <input type="text" class="form-control datepicker2" data-date-format="dd/mm/yyyy" placeholder=" dd/mm/yyyy" name="timeformat" id="timeformat" value="<?php echo $sessiondata['timeformat'];?>">
                                                                <div class="input-group-addon calc-addon">
                                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                                </div>
                                                            </div>
                                                       </div>
                                                        <div class="form-group">
                                                            <label>Language <span class="mndtry">*</span></label>
                                                            <input type="text" class="form-control" placeholder="English" name="language" id="language" value="<?php echo $sessiondata['language'];?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                            <label>Appearance</label>
                                                            <div class="appearance-box">
                                                                <div class="row rows row-one ">
                                                                    <div class="col-lg-6 col-md-6 xm-only">
                                                                        <div class="switch-box" >Use Light Theme <span class="switch-btn">
																		
																		<?php 
																		if($groupinfo[0]['group_theme'] == 1)
																		{
																			
																			echo '<input type="checkbox" name="group_theme" id="group_theme" checked/>';
																		
																		}
																	    elseif($groupinfo[0]['group_theme'] == 0)
																		{
																			echo '<input type="checkbox" name="group_theme" id="group_theme">';
																		}	
																		
																		?>
																		<label for="group_theme">Toggle</label>
																	</span></div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 xm-only">
                                                                        <div class="switch-box">Menu Auto Hide <span class="switch-btn">
																		<?php 
																		if($groupinfo[0]['group_menu_hide'] == 1)
																		{
																			
																			echo '<input type="checkbox" name="group_menu_hide" id="group_menu_hide" checked/>';
																		
																		}
																	    elseif($groupinfo[0]['group_menu_hide'] == 0)
																		{
																			echo '<input type="checkbox" name="group_menu_hide" id="group_menu_hide">';
																		}	
																		
																		?>
																		
																		
																		<label for="group_menu_hide">Toggle</label></span></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row rows row-two">
                                                                    <div class="col-lg-6 col-md-6 xm-only">
                                                                        <div class="switch-box">Use Default Logo <span class="switch-btn">
																		<?php 
																		if($groupinfo[0]['group_logo'] == 1)
																		{
																			
																			echo '<input type="checkbox" name="group_logo" id="group_logo" checked/>';
																		
																		}
																	    elseif($groupinfo[0]['group_logo'] == 0)
																		{
																			echo '<input type="checkbox" name="group_logo" id="group_logo">';
																		}	
																		
																		?>
																		
																		<label for="group_logo">Toggle</label></span></div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 xm-only">
                                                                        <div class="switch-box">Shortcut Icon <span class="switch-btn">
																		<?php 
																		if($groupinfo[0]['group_favicon'] == 1)
																		{
																			
																			echo '<input type="checkbox" name="group_favicon" id="group_favicon" checked/>';
																		
																		}
																	    elseif($groupinfo[0]['group_favicon'] == 0)
																		{
																			echo '<input type="checkbox" name="group_favicon" id="group_favicon">';
																		}	
																		
																		?>
																		<label for="group_favicon">Toggle</label></span></div>
                                                                    </div>
                                                                </div>
                                                                <div class="row rows row-three">
                                                                    <div class="col-lg-6 col-md-6 xm-only">
                                                                        <div class="switch-box">Hide Notifications <span class="switch-btn"><input type="checkbox" id="switch4" />
																		<?php 
																		if($groupinfo[0]['group_notification'] == 1)
																		{
																			
																			echo '<input type="checkbox" name="group_notification" id="group_notification" checked/>';
																		
																		}
																	    elseif($groupinfo[0]['group_notification'] == 0)
																		{
																			echo '<input type="checkbox" name="group_notification" id="group_notification">';
																		}	
																		
																		?>
																		
																		
																		<label for="group_notification">Toggle</label></span></div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 xm-only none"> &nbsp; </div>
                                                                </div>
                                                                <div class="row rows row-four">
                                                                    <div class="col-lg-6 col-md-6 xm-only">
                                                                        <div class="switch-box">Hide Site Name <span class="switch-btn">
																		<?php 
																		if($groupinfo[0]['group_sitename'] == 1)
																		{
																			
																			echo '<input type="checkbox" name="group_sitename" id="group_sitename" checked/>';
																		
																		}
																	    elseif($groupinfo[0]['group_sitename'] == 0)
																		{
																			echo '<input type="checkbox" name="group_sitename" id="group_sitename">';
																		}	
																		
																		?>
																		
																		
																		
																		
																		<label for="group_sitename">Toggle</label></span></div>
                                                                    </div>
                                                                    <div class="col-lg-6 col-md-6 xm-only none"> &nbsp; </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </form>
                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="wowza">
                                            <div class="action-table">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="box-header">
                                                    
                                                    <!-- Single button -->
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Action <i class="fa fa-angle-down" aria-hidden="true"></i>                                                                
                                                                  </button>
                                                        <ul class="dropdown-menu">
                                                            <li><a href="#">Refresh</a></li>
                                                            <li><a href="#">Reboot</a></li>
                                                            <li><a href="#">Take Offline</a></li>
                                                            <li role="separator" class="divider"></li>
                                                            <li><a href="#">Delete</a></li>
                                                        </ul>
                                                    </div>
                                                    <!-- Standard button -->
                                                    <button type="button" class="btn btn-default submit">Submit</button>
                                                    <a class="add-btn" id="add_wowza" href="<?php echo site_url();?>groupadmin/createwowza">
                                                        <span><i class="fa fa-plus"></i> Wowza Engine</span>
                                                    </a>
                                                </div>
                                                
                                                <div class="box">
                                                    <div class="box-body table-responsive no-padding">
                                                        <table id="wowzaengins" class="table table-hover check-input">
                                                            <tr>
                                                                <th>
                                                                    <div class="boxes">
                                                                        <input type="checkbox" id="box-1">
                                                                        <label for="box-1"></label>
                                                                    </div>
                                                                </th>
                                                                <th>ID</th>
                                                                <th>Name</th>
                                                                <th>IP Address</th>
                                                                <th>Uptime</th>
                                                                <th >Applications Running</th>
                                                                <th>Status</th>
                                                                <th> &nbsp; </th>
                                                                <th> &nbsp; </th>
                                                                <th> &nbsp; </th>
                                                                <th> &nbsp; </th>
                                                            </tr>
                                                            <?php
												if(sizeof($configdetails)>0)
												{
													$counter =1;
													foreach($configdetails as $configdetail)
													{
														$Id = $configdetail['id'];
													?>
											<tr class="wowza_row">
												<td> 
													<div class="boxes">
	                                                <input type="checkbox" id="box-2" checked>
	                                                <label for="box-2"></label>
	                                           		</div>
	                                            </td>
												<td><?php echo $counter;?></td>
											<td><a class="wowid" id="<?php echo $configdetail['id']?>" href="<?php echo site_url();?>/groupadmin/updatewowzaengin/<?php echo $configdetail['id']?>">
											<?php
												if($configdetail['wowza_image'] == "")
												{
												?>
												<img src="<?php echo site_url();?>assets/site/main/images/logo1.png" class="">
												<?php	
												}
												else
												{
												?>
												<img src="<?php echo site_url();?>assets/site/main/wowza_logo/<?php echo $configdetail['wowza_image'];?>" class="">
												<?php	
												}
											?>
											
											<?php echo $configdetail['wse_instance_name'];?></a></td>
												<td><?php echo $configdetail['ip_address'];?></td>
												
												
												<td><span class="uptime"></span></td>
												<td>
												<?php
													
												?>
												<strong>2</strong> See application</td>
												<td><?php 
												if($configdetail['status'] == 1)
												{
													echo '<span id="status" class="label label-success">online</span>';
												}
												elseif($configdetail['status'] == 2)
												{
													echo '<span id="status" class="label label-danger">offline</span>';
												}
												else
												{
													echo '<span id="status" class="label label-danger">offline</span>';
												}
												?></td>
												<td><a class="wowzarefresh" id="ref_<?php echo $configdetail['id']?>" href="javascript:void(0);"><i class="fa fa-refresh" aria-hidden="true"></i></a></td>
                                                <td><a class="wowzareboot" id="reb_<?php echo $configdetail['id']?>" href="javascript:void(0);"><i class="fa fa-repeat" aria-hidden="true"></i></a></td>
                                                <td><a class="wowzadisable" href="javascript:void(0);"><i class="fa fa-heartbeat" aria-hidden="true"></i></a></td>
                                                <td><a class="wowzadelete" id="del_<?php echo $configdetail['id']?>" href="javascript:void(0);"><i class="fa fa-trash" aria-hidden="true"></i></a></td>
											</tr>
											<?php	
											$counter++;
													}
												}
												else
												{
													?>
													<tr>
														<td colspan="11">Wowza Engine Not Added Yet!</td>
													</tr>
													<?php
												}
											?>
                                                            
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                        <div role="tabpanel" class="tab-pane" id="ffmpeg">FFMPEG goes here</div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- ========= Section One End ========= -->

                        
                    </div>
                </div>
            </div>
            <!-- ========= Main Content End ========= -->
        </section>
        <!-- ========= Content Wrapper End ========= -->

		