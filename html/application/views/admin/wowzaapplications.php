<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<?php
	$class1 ='';
	$class2 ='';
	$class3 ='active';
	$tabstatus = $this->session->flashdata('tab');
	  if($tabstatus=='Target'){
			$class3 ='';
			$class2 ='';
			$class1= 'active';

		  }
	 elseif($tabstatus=='Application'){
			$class1 ='';
			$class3 ='';
			$class2 ='active';

	}else
	{
		$class1 ='';
		$class2 ='';
		$class3 ='active';


	}

	?>
<main class="main">
  	   <!-- Breadcrumb-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Home</a>
        </li>
        <li class="breadcrumb-item active"><a href="configuration">Settings</a></li>
        <li class="breadcrumb-item active">Edit Publisher</li>
      </ol>
      <div class="container-fluid">
      	<div class="animated fadeIn">
           <div class="card">
				<div class="card-body">
					 <?php if($this->session->flashdata('success')){ ?>
						<div class="alert alert-success">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<strong>Success!</strong> <?php echo $this->session->flashdata('success'); ?>
						</div>
						<?php }else if($this->session->flashdata('error')){  ?>
						<div class="alert alert-danger">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<strong>Error!</strong> <?php echo $this->session->flashdata('error'); ?>
						</div>
						<?php }else if($this->session->flashdata('warning')){  ?>
						<div class="alert alert-warning">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<strong>Warning!</strong> <?php echo $this->session->flashdata('warning'); ?>
						</div>
						<?php }else if($this->session->flashdata('info')){  ?>
						<div class="alert alert-info">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<strong>Info!</strong> <?php echo $this->session->flashdata('info'); ?>
						</div>
					<?php } ?>
					<div class="row">
            <div class="col-lg-12 col-12-12">
               <div class="content-box config-contentonly">
                  <div class="config-container">
                     <div class="tab-btn-container">
                        <ul class="nav nav-tabs" role="tablist">
                           <li class="<?php echo $class3.' '.$class2;?>"><a data-toggle="tab" href="#apps">Applications</a></li>
                           <li class= "<?php echo $class1;?>"><a data-toggle="tab" href="#apps_tar">Targets</a></li>
                        </ul>
                     </div>
                     <div class="tab-content">
                        <div id="apps" class="tab-pane fade in <?php echo $class3.' '.$class2;?>">
                           <div class="action-table">
                              <div class="row">
                                 <div class="col-xs-12">
                                    <div class="box-header">
                                       <div class="btn-group">
                                          <div class="custom-select">
												<select class="form-control actionsel" id = "actionappval1">
													<option value ="">Action</option>
													<option value ="Lock">Lock</option>
													<option value ="Un-Lock">Un-Lock</option>
													<option value ="Refresh">Refresh</option>
													<option value ="Delete">Delete</option>
												</select>
												</div>
                                       </div>
                                       <button type="button" class="btn btn-default submit" onclick="submitAllApps('admin/appActions');">Submit</button>
									     <a href="<?php echo site_url();?>admin/createvod" class="add-btn">
                                       <span> <i class="fa fa-plus"></i>

                                       VOD </span>
                                       </a>
                                       <a href="<?php echo site_url();?>admin/createapplication" class="add-btn">
                                       <span> <i class="fa fa-plus"></i>

                                       Live </span>
                                       </a>

                                    </div>
                                    <div class="box">
                                       <div class="box-body table-responsive no-padding">
                                          <table class="table table-hover check-input">
                                             <tbody>
                                                <tr>
                                                   <th><div class="boxes">
				                                        <input type="checkbox" id="allapps">
				                                        <label for="allapps"></label>
				                                    </div>
				                                   </th>
                                                   <!----<th>ID</th>--->
                                                   <th>Application Name</th>
                                                   <th>Live Source</th>
                                                   <th>Stream Target</th>
                                                   <th>Status</th>
                                                   <th>Stream URL</th>
                                                   <th></th>
                                                   <th></th>
                                                   <th></th>
                                                   <th></th>
                                                </tr>
                                                <?php
                                                   if(sizeof($applications)>0)
                                                   {
                                                   	$counter =1;
                                                   	foreach($applications as $application)
                                                   	{
                                                   		$wowza = $this->common_model->getWowzabyID($application['live_source']);
                                                   		?>
                                                <tr>
                                                   <td><div class="boxes">
				                                        <input type="checkbox" id="appapps_<?php echo $application['id'];?>">
				                                        <label for="appapps_<?php echo $application['id'];?>"></label>
				                                    </div></td>

                                                   <td><a href="<?php echo site_url();?>admin/updateapp/<?php echo $application['id'];?>"><?php echo $application['application_name'];?></a></td>
                                                   <td>

													   <?php
													   if(!empty($wowza)){
														     echo $wowza[0]['wse_instance_name'];
														   ?>
														<?php

														   }
														?>

													   </td>
                                                   <td><strong>2</strong> See Targets<br><i class="fa fa-plus"></i> Add Target</td>
                                                   <td><span class="label label-success">Un-Locked</span></td>

                                                   <td><?php echo $application['wowza_path'];?></td>

                                                    <td>
                                                      <a class="appsfresh" id="ref_<?php echo $application['id']?>" href="javascript:void(0);"><i class="fa fa-refresh"></i></a>
                                                      </td>
                                                      <td>
                                                      <a class="appscopy" id="copy_<?php echo $application['id']?>" href="javascript:void(0);"><i class="fa fa-copy"></i></a>
                                                      </td>

                                                      <td><a href="javascript:void(0);"><i class="fa fa-unlock"></i></a></td>
                                                      <td>
                                                      <a class="appsdel" id="del_<?php echo $application['id']?>" href="javascript:void(0);"><i class="fa fa-trash"></i></a>
                                                   </td>
                                                </tr>
                                                <?php
                                                   }
                                                   }
													else
													{
													?>
													<tr>
													<td colspan="7">No Application Created Yet!</td>
													</tr>
													<?php
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
                        <div id="apps_tar" class="tab-pane <?php echo $class1;?>">
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
                                       <a href="<?php echo site_url();?>admin/createtarget" class="add-btn">
                                       <span><i class="fa fa-plus"></i>
                                       <i class="fa fa-crosshairs"></i>
                                       Add Target</span>
                                       </a>
                                    </div>
                                    <div class="box">
                                       <div class="box-body table-responsive no-padding">
                                          <table class="table table-hover check-input">
                                             <tbody>
                                                <tr>
                                                   <th><div class="boxes">
				                                        <input type="checkbox" id="box-2">
				                                        <label for="box-2"></label>
				                                    </div></th>
                                                   <!----<th>ID</th>--->
                                                   <th>Target Name</th>
                                                   <th>Application Name</th>
                                                   <th>Status</th>
                                                   <th>Stream URL</th>
                                                   <th></th>
                                                   <th></th>
                                                   <th></th>
                                                   <th></th>
                                                </tr>
                                                <?php
                                                   if(sizeof($targets)>0)
                                                   {
                                                   	$counter1 =1;
                                                   	foreach($targets as $target)
                                                   	{
                                                   	  $app = $this->common_model->getApplicationbyId($target['wowzaengin']);
                                                   	?>
                                                <tr>
                                                   <td><div class="boxes">
				                                        <input type="checkbox" id="target_<?php echo $counter1;?>">
				                                        <label for="target_<?php echo $counter1;?>"></label>
				                                    </div>
												</td>

                                                   <td><?php echo $target['target_name'];?></td>
                                                   <td><?php echo $app[0]['application_name'];?></td>
                                                   <td><span class="label label-success">Online</span></td>
                                                   <td><?php echo $target['streamurl'];?></td>

                                                  <td>
                                                      <a class="targetfresh" id="tarfresh_<?php echo $target['id']?>" href="javascript:void(0);"><i class="fa fa-refresh"></i></a>
                                                      </td>
                                                      <td>
                                                      <a class="targcopy" id="targcopy_<?php echo $target['id']?>" href="javascript:void(0);"><i class="fa fa-copy"></i></a>
                                                      </td>

                                                      <td><a class="targenbdib" id="targenbdib_<?php echo $target['id']?>" href="javascript:void(0);"><i class="fa fa-play"></i></a>
                                                      </td>
                                                      <td>
                                                      <a class="targdel" id="targdel_<?php echo $target['id']?>" href="javascript:void(0);"><i class="fa fa-trash"></i></a>
                                                   </td>

                                                </tr>
                                                <?php
                                                $counter1++;
                                                   }
                                                   }
                                                   else
													{
													?>
													<tr>
													<td colspan="10">No Target Created Yet!</td>
													</tr>
													<?php
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
		</div>
	</div>
</main>					
	
	

