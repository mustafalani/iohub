

<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<main class="main">
	   <!-- Breadcrumb-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="/applications">Apps</a>
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
                      <a class="nav-link active show" id="target" data-toggle="tab" href="#apps_tar">Targets</a>
                    </li>
                 </ul>
              </div>
                     <div class="tab-content">

                        <div id="apps_tar" class="tab-pane active">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-12" style="padding: 0;">
                                    <div class="box-header">
                                       <div class="btn-group">
												<select class="form-control actionsel" id="actiontargetval1">
													<option value ="">Action</option>
													<option value ="Start">Start</option>
													<option value ="Stop">Stop</option>
													<option value ="Delete">Delete</option>
												</select>
                                       </div>
                                       <button type="button" class="btn btn-primary submit" onclick="submitAllTargets('admin/targetActions');">Submit</button>
                                       <a href="<?php echo site_url();?>admin/createtarget" class="add-btn btn btn-primary float-right">
                                       <span><i class="fa fa-plus"></i>

                                        Target</span>
                                       </a>
                                    </div>
                                    <br>
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
                                                <tr>
                                                   <td><div class="boxes">
				                                        <input type="checkbox" class="targetactions" id="target_<?php echo $target['id']?>">

				                                        <label for="target_<?php echo $target['id']?>"></label>
				                                    </div>
												</td>
                                                   <td><?php echo $counter1;?></td>
                                                   <td><a href="<?php echo site_url();?>editTarget/<?php echo $target['id']?>"><?php echo $target['target_name'];?></a></td>
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
                                                   <td><?php echo $app[0]['application_name'];?></td>
                                                   <td class="status"><span id="status" class="label label-danger">Disabled</span></td>
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
</main>
