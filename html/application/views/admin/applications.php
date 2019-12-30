<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<script type="text/javascript">
	var applicationLocks = [];
	var appTargets = [];
</script>
<?php
if(sizeof($applock)>0)
{
	foreach($applock as $key=>$ap)
	{
		if($ap == NULL || $ap == "")
		{
			echo '<script type="text/javascript">applicationLocks['.$key.']=0;</script>';
		}
		else
		{
			echo '<script type="text/javascript">applicationLocks['.$key.']='.$ap.';</script>';
		}
	}
}
if(sizeof($targets)>0)
{
	$counter1 =1;
	foreach($targets as $target)
	{
		echo '<script type="text/javascript">appTargets['.$target["id"].']="'.$target["target"].'";</script>';
	}
}
?>
<main class="main">
	   <!-- Breadcrumb-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Home</a>
          </li>
          <li class="breadcrumb-item active">Apps</li>
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
				                <div class="tab-btn-container">
				                        <ul class="nav nav-tabs" role="tablist" id="appstarger">
				                        	<li class="nav-item">
				                        		<a class="nav-link active" id="application" data-toggle="tab" href="#apps">Applications</a>
				                        	</li>
				                           	<li class="nav-item">
				                           		<a class="nav-link" id="target" data-toggle="tab" href="#apps_tar">Targets</a>
				                           	</li>
				                        </ul>
				                     </div>
				                <div class="tab-content">
				                     <div id="apps" class="tab-pane active">
				                           <div class="card-body">
				                              <div class="row">
				                                 <div class="col-12" style="padding: 0;">
				                                    <div class="box-header">
				                                       <div class="btn-group">
															<select class="form-control actionsel" id = "actionappval1">
																<option value ="">Action</option>
																<option value ="Lock">Lock</option>
																<option value ="Un-Lock">Un-Lock</option>
																<option value ="Reboot">Reboot</option>
																<option value ="Archive">Archive</option>
																<option value ="Delete">Delete</option>
															</select>


				                                       </div>
				                                       <button type="button" class="btn btn-primary submit" onclick="submitAllApps('admin/appActions');">Submit</button>
													   <!--  <a href="<?php echo site_url();?>createvod" class="add-btn">
				                                       <span> <i class="fa fa-plus"></i>

				                                       VOD </span>
				                                       </a>-->
				                                       <a href="<?php echo site_url();?>createapplication" class="btn btn-primary add-btn float-right">
				                                       <span> <i class="fa fa-plus"></i>

				                                       Live </span>
				                                       </a>

				                                    </div>
				                                    <br/>
				                                       <div class="table-responsive no-padding">
				                                          <table class="table table-hover check-input cstmtable appsTable">
				                                             <tbody>
				                                                <tr>
				                                                   <th><div class="boxes">
								                                        <input type="checkbox" id="selectallApps" class="selectallApps">
								                                        <label for="selectallApps"></label>
								                                    </div>
								                                   </th>
				                                                   <th>ID</th>
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
				                                                <tr id="row_<?php echo $application['id'];?>">
				                                                   <td><div class="boxes">
								                                        <input type="checkbox" class="appActions" id="appapps_<?php echo $application['id'];?>">
								                                        <label for="appapps_<?php echo $application['id'];?>"></label>
								                                    </div></td>
				                                             	<td><?php echo $counter;?></td>
				                                                   <td class="appname"><a href="<?php echo site_url();?>updateapp/<?php echo $application['id'];?>"><?php echo $application['application_name'];?></a></td>

				                                                   <td>

																	   <?php
																	   if(!empty($wowza)){
																		     echo $wowza[0]['wse_instance_name'];
																		   ?>
																		<?php

																		   }
																		?>

																	   </td>
				                                                   <td><strong>
				                                                   <?php
				                                                   $targetCount = $this->common_model->getTargetbyAppID($application['id']);
				                                                   echo sizeof($targetCount);
				                                                   ?>

				                                                   </strong>
				                                                   <?php
				                                                   if(sizeof($targetCount)>0)
				                                                   {
																   	?>
																   	<a href="<?php echo site_url();?>admin/apptargets/<?php echo $application['id'];?>">See Targets</a>
																   	<?php
																   }
																   else
																   {
																   	echo 'See Targets';
																   }
				                                                   ?>
				                                                   <br><a href="<?php echo site_url();?>admin/createtarget/<?php echo $application['id'];?>"><i class="fa fa-plus"></i> Add Target</a></td>
				                                                   <td><span id="status" class="label label-success"></span></td>

				                                                   <td><?php echo $application['wowza_path'];?></td>

				                                                    <td>
				                                                      <a data-toggle="tooltip" title="Reboot" class="appsfresh" id="ref_<?php echo $application['id']?>" href="javascript:void(0);"><i class="fa fa-refresh"></i></a>
				                                                      </td>
				                                                      <td>
				                                                      <a data-toggle="tooltip" title="Copy" class="appscopy" id="copy_<?php echo $application['id']?>" href="javascript:void(0);"><i class="fa fa-copy"></i></a>
				                                                      </td>

				                                                      <td>
				                                                      <?php
				                                                      if($application['isLocked'] == 0)
				                                                      {
																	  ?>
																	  <a data-toggle="tooltip" title="Lock/Un-Lock" id="lock_<?php echo $application['id']?>" class="appsLock" href="javascript:void(0);"><i class="fa fa-unlock"></i></a>
																	  <?php
																	  }
																	  else if($application['isLocked'] == 1)
				                                                      {
																	  	?>
																	  	<a data-toggle="tooltip" title="Lock/Un-Lock" id="lock_<?php echo $application['id']?>" class="appsLock" href="javascript:void(0);"><i class="fa fa-lock"></i></a>
																	  	<?php
																	  }
				                                                      ?>

				                                                      </td>
				                                                      <td>
				                                                      <a data-toggle="tooltip" title="Delete" class="appsdel" id="del_<?php echo $application['id']?>" href="javascript:void(0);"><i class="fa fa-trash"></i></a>
				                                                   </td>
				                                                </tr>
				                                                <?php
				                                                $counter++;
				                                                   }
				                                                   }
																	else
																	{
																	?>
																	<tr>
																	<td colspan="11">No Applications Created Yet!</td>
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
				                        <div id="apps_tar" class="tab-pane">
				                           <div class="card-body">
				                              <div class="row">
				                                 <div class="col-12" style="padding: 0;">
				                                    <div class="box-header">
				                                       <div class="btn-group">
																<select class="form-control actionsel" id="actiontargetval1">
																	<option value ="">Action</option>
																	<option value ="Start">Start</option>
																	<option value ="Stop">Stop</option>
																	<option value ="Archive">Archive</option>
																	<option value ="Delete">Delete</option>
																</select>

				                                       </div>
				                                       <button type="button" class="btn btn-primary submit" onclick="submitAllTargets('admin/targetActions');">Submit</button>
				                                       <a href="<?php echo site_url();?>createtarget" class="add-btn btn btn-primary float-right">
				                                       <span><i class="fa fa-plus"></i>

				                                        Target</span>
				                                       </a>
				                                    </div>
				                                    <br/>

				                                       <div class="table-responsive no-padding">
				                                          <table class="cstmtable table table-hover check-input targetTable">
				                                             <tbody>
				                                                <tr>
				                                                   <th><div class="boxes">
								                                        <input type="checkbox" id="selectalltargets">
								                                        <label for="selectalltargets"></label>
								                                    </div></th>
				                                                  <th>ID</th>
				                                                   <th>Target Name</th>
				                                                   <th>Provider</th>
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
				                                                <tr id="row_<?php echo $target['id']?>">
				                                                   <td><div class="boxes">
								                                        <input type="checkbox" class="targetactions" id="target_<?php echo $target['id']?>">

								                                        <label for="target_<?php echo $target['id']?>"></label>
								                                    </div>
																</td>
				                                                   <td><?php echo $counter1;?></td>
				                                                   <td ><a href="<?php echo site_url();?>editTarget/<?php echo $target['id']?>"><?php echo $target['target_name'];?></a></td>
				                                                   <td><?php $tar = $target['target'];
				                                                   if($tar != "")
				                                                   {
																   	switch($tar){
																	   	case "facebook":
																	   	?>
																	   	 <div class="btn btn-facebook btn-sm">
									                                        <span>
									                                            <i class="fa fa-facebook"></i>
									                                            Facebook Live
									                                        </span>
									                                    </div>
																		<?php
																	   		break;
																	   	case "google":
																	   	?>
																	   <div class="btn btn-google btn-sm ">
									                                        <i class="fa fa-youtube"></i>
									                                            Youtube Live
									                                    </div>
																		<?php
																	   		break;
																	   			case "twitch":
																	   	?>
																	    <div class="btn btn-twitch btn-sm">
									                                        <i class="fa fa-twitch"></i>
									                                            Twitch
									                                    </div>
																		<?php
																	   		break;
																	   		case "twitter":
																	   	?>
																			 <div class="btn btn-twitter btn-sm">
										                                        <i class="fa fa-twitter"></i>
										                                            Twitter Periscope
										                                    </div>
																		<?php
																	   		break;
																	   		case "rtmp":
																	   	?>
																	   	<div class="btn btn-github btn-sm btndis">
								                                            <i class="fa fa-gear"></i>
								                                                RTMP
								                                        </div>

																		<?php
																	   		break;
																	   }
																   }
				                                                   ?></td>
				                                                   <td class="targetappname"><?php echo $app[0]['application_name'];?></td>
				                                                   <td class="status"><span id="status" class="label label-gray">Disabled</span></td>
				                                                   <td><?php echo $target['streamurl'];?></td>

				                                                  <td>
				                                                      <a class="targetfresh" id="tarfresh_<?php echo $target['id']?>" href="javascript:void(0);"><i class="fa fa-refresh"></i></a>
				                                                      </td>
				                                                      <td>
				                                                      <a class="targcopy" id="targcopy_<?php echo $target['id']?>" href="javascript:void(0);"><i class="fa fa-copy"></i></a>
				                                                      </td>

				                                                      <td><a class="targenbdib" id="targenbdib_<?php echo $target['id']?>" href="javascript:void(0);"><i class="fa fa-play"></i></a>
				                                                      </td>
				                                                     <!-- <td><a class="trans" id="targenbdib_<?php echo $target['id']?>" href="<?php echo site_url();?>admin/googleaccount/starttransition/<?php echo $target['id']?>"> <i class="fa fa-gear faa-spin animated"></i>Start Transition</a>
				                                                      </td>-->
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
																	<td colspan="11">No Targets Created Yet!</td>
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
</main>
