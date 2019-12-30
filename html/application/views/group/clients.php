

<?php $this->load->view('group/navigation.php');?>
<?php $this->load->view('group/leftsidebar.php');?>
<section class="content-wrapper">
   <!-- ========= Main Content Start ========= -->
   <div class="content">
      <div class="content-container">
         <div class="row">
            <div class="col-lg-12 col-12-12">
               <div class="content-box config-contentonly">
                  <div class="config-container">
                     <div class="tab-btn-container">
                        <ul class="nav nav-tabs" role="tablist">
                           <li class="active"><a data-toggle="tab" href="#system">Groups</a></li>
                           <li><a data-toggle="tab" href="#ftp2">Users</a></li>
                        </ul>
                     </div>
                     <div class="tab-content">
                        <div id="system" class="tab-pane fade in active system2">
                        	<div class="action-table">
                        		<div class="row">
                        			<div class="col-xs-12">
                        				 
                              <div class="box-header">
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
                                 <button type="button" class="btn btn-default submit">Submit</button>
                                 <a href="<?php echo site_url();?>groupadmin/creategroup" class="add-btn">
                                 <span><i class="fa fa-plus"></i> New Group</span>
                                 </a>
                              </div>
                        
                           <div class="box">
                              <div class="box-body table-responsive no-padding">
                                 <table class="table table-hover check-input">
                                 	<tbody>
                                    <tr>
                                       <th><input type="checkbox" name=""></th>
                                       <th>ID</th>
                                       <th>Group Name</th>
                                       <th>Address</th>
                                       <th>E-mail Address</th>
                                       <th>Status</th>
                                       <th></th>
                                       <th>Users</th>
                                       <th>Edit</th>
                                       <th>Login</th>
                                    </tr>
                                    <?php
                                       if(sizeof($groups)>0)
                                       {
                                       	$counter =1;
                                       	foreach($groups as $group)
                                       	{
                                       		$Id = $group['id'];
                                       		$img = $this->common_model->getGgoupImage($Id);
                                       	?>
                                    <tr>
                                       <td><input type="checkbox" name="actions"></td>
                                       <td><?php echo $counter;?></td>
                                       <td><img width="20px" height="20px" src="<?php echo site_url();?>assets/site/main/group_pics/<?php echo $img[0]['name'];?>"/><a id="<?php echo $group['group_name']?>" href="<?php echo site_url();?>/groupadmin/updategroup/<?php echo $group['id']?>"><?php echo $group['group_name']?></a></td>

                                       <td><?php echo $group['group_address'];?></td>
                                       <td><?php echo $group['group_email'];?></td>
                                       <td>
                                          <button class="btn btn-green btn-xs">Active</button>
                                       </td>
                                       <td>999 Days Remaining</td>
                                       <td><a href="javascript:void(0);">12 <br> Show all users</a></td>
                                       <td><a href="javascript:void(0);">Edit Resources</a></td>
                                       <td>
                                          <button class="btn btn-purple btn-xs">
                                          <i class="fa fa-sign-in"></i> Admin Login
                                          </button>
                                       </td>
                                    </tr>
                                    <?php	
                                    $counter++;
                                       }
                                       }
                                       ?>
                                    </tbody>
                                 </table>
                              </div>
                           </div>
                        			</div>
                        		</div>
                        	</div>	
                        </div>
                        <div id="ftp2" class="tab-pane fade system2">
                           <div class="action-table">
                           		<div class="row">
                        			<div class="col-xs-12">
                           		
                              <div class="box-header">
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
                                 <button type="button" class="btn btn-default submit">Submit</button>
                                 <a href="<?php echo site_url();?>groupadmin/createuser" class="add-btn">
                                 <span><i class="fa fa-plus"></i> New User</span>
                                 </a>
                              </div>
                          
                           
                          <div class="box">
                              <div class="box-body table-responsive no-padding">
                                 <table class="table table-hover check-input">
                                    <tbody>
                                    	 <tr>
                                          <th><input type="checkbox" name=""></th>
                                          <th>ID</th>
                                          <th>Name</th>
                                          <th>Group</th>
                                          <th>Role</th>
                                          <th>E-mail Address</th>
                                          <th>Status</th>
                                       </tr>
                                       <?php
                                          if(sizeof($users)>0)
                                          {
                                          	$counterU =1;
                                          	foreach($users as $usr)
                                          	{
                                          		$Id = $usr['id'];
                                          		$img1 = $this->common_model->getUserImage($Id);
                                          		
                                          		$groupname = $this->common_model->getGroupInfobyId($usr['group_id']);
                                          	?>
                                       <tr>
                                          <td><input type="checkbox" name=""></td>
                                          <td><?php echo $counterU;?></td>
                                          <td><img width="20px" height="20px" src="<?php echo site_url();?>assets/site/main/group_pics/<?php echo $img1[0]['name'];?>"/><a id="<?php echo $usr['fname'].' '.$usr['lname'];?>" href="<?php echo site_url();?>/groupadmin/updateuser/<?php echo $usr['id']?>"> <?php echo $usr['fname'].' '.$usr['lname'];?></td>
                                          <td><?php echo $groupname[0]['group_name'];?></td>

                                          <td>
                                             <?php $roles = $this->config->item('roles_id');
                                                echo $roles[$usr['role_id']];
                                                ?>	
                                          </td>
                                          <td><?php echo $usr['email_id'];?></td>
                                          <td>
                                             <button class="btn btn-green btn-xs">Active</button>
                                          </td>
                                       </tr>
                                       <?php	
                                          $counterU++;
                                          }
                                          }
                                          ?>	
                                    </tbody>
                                 </table>
                              </div>
                           </div>
								</div>
								</div>
                           </div>
                           
                           
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>

