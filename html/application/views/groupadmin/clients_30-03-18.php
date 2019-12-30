
<style>
	
	.not-active {
	pointer-events: none;
	cursor: default;
	text-decoration:none;
	color:black;
	}
	
	
</style>

<?php $this->load->view('groupadmin/navigation.php');?>
<?php $this->load->view('groupadmin/leftsidebar.php');?>
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
                                    <!---<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action <i class="fa fa-angle-down" aria-hidden="true"></i>                                                                
                                    </button>
                                    <ul class="dropdown-menu">
                                       <li><a href="#">Refresh</a></li>
                                       <li><a href="#">Reboot</a></li>
                                       <li><a href="#">Take Offline</a></li>
                                       <li role="separator" class="divider"></li>
                                       <li><a href="#">Delete</a></li>
                                    </ul>----->
									<select class="selectpicker" id = "actionval">
															<option value ="Refresh">Action</option>
															<option value ="Refresh">Refresh</option>
															<option value ="Reboot">Reboot</option>
															<option value ="Take Offline">Take Offline</option>
															<option value ="Delete">Delete</option>
									</select>
                                 </div>
                                 <button type="button" class="btn btn-default submit" onclick="submitAll('groupadmin/deleteGroup');">Submit</button>
                                 <a href="<?php echo site_url();?>groupadmin/creategroup" class="add-btn">
                                 <span><i class="fa fa-plus"></i> New Group</span>
                                 </a>
                              </div>
                        
                           <div class="box">
                              <div class="box-body table-responsive no-padding">
                                 <table class="table table-hover check-input">
                                 	<tbody>
                                    <tr>
                                       	<th><input type="checkbox"  class="checkbox" id="selecctall" ></th>
                                       <!-----<th>ID</th>--->
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
										  <td><input type="checkbox" name="appids[]" class="groupdel" id = "del_<?php echo $group['id']?>" value = "<?php echo $group['id']?>"></td>
                                    
                                       <!-----<td><?php echo $counter;?></td>---->
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
                                          <i class="fa fa-sign-in"></i> groupadmin Login
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
                                 <!----<button type="button" class="btn btn-default submit">Submit</button>--->
								 
								 
								 <button type="button" class="btn btn-default submit" onclick="submitAllUser('groupadmin/deleteUser');">Submit</button>
								 
								  <?php 
									 
									 $userdata =$this->session->userdata('user_data');
									//echo "<pre>";
									//print_r($userdata);die;
									$checkstatus = $this->common_model->checkWowzaStatus($userdata['userid']);
									//echo "<pre>";
									//print_r($checkstatus->create_user);die;
									if($checkstatus->create_user == 0){
									 ?>
									 <div class = "tool-tip-hover tool-tip-hover1 " style="float:right;">
									  <a href="<?php echo site_url();?>groupadmin/createuser" class="add-btn not-active">
                                 <span><i class="fa fa-plus"></i> New User</span>
								 <span class="tool-msg">Sorry! permission not allowed!</span>
								 
                                 </a>
								 </div>
									 <?php
									}else{
									?>
									<a href="<?php echo site_url();?>groupadmin/createuser" class="add-btn">
                                 <span><i class="fa fa-plus"></i> New User</span>
                                 </a>
									<?php
									}
									 ?>
									

                                 
                              </div>
                          
                           
                          <div class="box">
                              <div class="box-body table-responsive no-padding">
                                 <table class="table table-hover check-input">
                                    <tbody>
                                    	 <tr>
                                          <!----<th><input type="checkbox" name=""></th>--->
										  <th><input type="checkbox"  class="checkbox" id="selecctalluser" ></th>
                                          <!-----<th>ID</th>---->
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
                                             <!-----<td><input type="checkbox" name="actions"></td>--->
											 <td><input type="checkbox" name="appidss[]" class="groupdel1" id = "deluser_<?php echo $usr['id']?>" value ="<?php echo $usr['id']?>"></td>
                                          <!------<td><?php echo $counterU;?></td>---->
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

<style>
	.tool-msg{display:none;} 
	.tool-tip-hover{display:inline-block;position:relative;}
	.tool-tip-hover:hover .tool-msg{display:block;position:absolute;top: 8px;
    left: 105%;
    color: #fff;
    background: #000;
    padding: 10px 20px;
    font-size: 11px;}
.tool-tip-hover1:hover .tool-msg{display: inline-block;
    position: absolute;
    top: 83%!important;
    color: #fff;
    background: #000;
    padding: 10px 20px;
    font-size: 11px;
    left: -40px;
    z-index: 1;}	
	.check-input input[type="checkbox"] {
    display: block;
}
	</style>