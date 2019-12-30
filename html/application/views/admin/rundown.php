<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<style type="text/css">
	table tr td.tdimg{
		text-align: left;
	}
	table tr td.tdimg a{
		padding-left: 10px;
		width: 100%;
	}
	table tr td.tdimg img{
		width: 30px;
	}
</style>
<?php

function timeToMilliseconds($time){
    $time_start = substr($time, -11, -3);
    $time_end = substr($time, -3);

    $time_arr = explode(':', $time_start);
    $seconds = 0;
    foreach($time_arr as $key => $val){
        if($key == 0){
            $seconds += $val * 60 * 60;
        }elseif($key == 1){
            $seconds += $val * 60;
        }elseif($key == 2){
            $seconds += $val;
        }
    }

    $seconds = $seconds.$time_end;
    $milliseconds = $seconds * 1000;

    return $milliseconds;
}

function formatMilliseconds($milliseconds) {
    $seconds = floor($milliseconds / 1000);
    $minutes = floor($seconds / 60);
    $hours = floor($minutes / 60);
    $milliseconds = $milliseconds % 1000;
    $seconds = $seconds % 60;
    $minutes = $minutes % 60;

    $format = '%u:%02u:%02u.%03u';
   
    if($milliseconds == "" || $milliseconds == 0){
		$milliseconds = "00";
	}
	if($seconds == "" || $seconds == 0){
		$seconds = "00";
	}
	if($minutes == "" || $minutes == 0){
		$minutes = "00";
	}
	if($hours == "" || $hours == 0){
		$hours = "00";
	}
    $time = $hours.":".$minutes.":".$seconds.":".$milliseconds;
    return $time;
}
?>
<main class="main">
	   <!-- Breadcrumb-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Home</a>
          </li>
          <li class="breadcrumb-item active">Rundowns</li>
        </ol>
        <div class="container-fluid">
        <div class="animated fadeIn">
        	<div class="card">
        		<div class="card-body">
        			<?php if($this->session->flashdata('success')){ ?>
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					 <?php echo $this->session->flashdata('success'); ?>
				</div>
				<?php }else if($this->session->flashdata('error')){  ?>
				<div class="alert alert-danger">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					 <?php echo $this->session->flashdata('error'); ?>
				</div>
				<?php }else if($this->session->flashdata('warning')){  ?>
				<div class="alert alert-warning">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<?php echo $this->session->flashdata('warning'); ?>
				</div>
				<?php }else if($this->session->flashdata('info')){  ?>
				<div class="alert alert-info">
					<a href="#" class="close" data-dismiss="alert">&times;</a>
					<?php echo $this->session->flashdata('info'); ?>
				</div>
			<?php } ?>
				<div class="row">
					<!-- ========= Section One Start ========= -->
					<div class="col-lg-12 col-12-12">
							<div class="content-box config-contentonly">
									<div class="config-container">
											<!-- === Nav tabs === -->
													<ul class="nav nav-tabs" role="tablist">
														<li class="nav-item" role="presentation" class="active">
															<a class="nav-link active" href="#Rundowns" aria-controls="rundowns" role="tab" data-toggle="tab">Rundowns</a></li>
													</ul>


											<!-- === Tab panes === -->
											<div class="tab-content">
													<div role="tabpanel" class="tab-pane active" id="Rundowns">
														<div class="card-body">
															<div class="row">
									<div class="col-12" style="padding: 0;">
										<div class="box-header">
												<!-- Single button -->
												<div class="btn-group">

									<select class="form-control actionsel" id="actionRundowns">
										<option value="">Action</option>
										<option value="Lock">Lock</option>
										<option value="UnLock">Un-Lock</option>										
										<option value ="Archive">Archive</option>
										<option value="Delete">Delete</option>
									</select>

												</div>
												<!-- Standard button -->
												<button type="button" class="btn btn-primary submit" onclick="submitRundowns();">Submit</button>
												<a href="<?php echo site_url();?>createrundown" class="add-btn btn btn-primary float-right">
														<span><i class="fa fa-plus"></i> Rundown</span>
												</a>
										</div>
	<br/>
			<div class="table-responsive no-padding">
					<table  class="table table-hover check-input cstmtable rundowntable rundownTable">
							<tr>
									<th width="60px">
											<div class="boxes">
													<input type="checkbox" id="allRundowns" >
													<label for="allRundowns"></label>
											</div>
									</th>
									<th width="40px">ID</th>
									<th>Title</th>
									<th>Duration</th>
									<th>Live Preview</th>
									<th>Status</th>
									
									<th> &nbsp; </th>
									
									<th> &nbsp; </th>
									<th> &nbsp; </th>

							</tr>
							<?php
							if(sizeof($rundowns)>0)
							{
								$counter =1;
								foreach($rundowns as $rundown)
								{
									$clips = $this->common_model->getAllRundownClips($rundown['id']);	
									$time = "0";
									if(sizeof($clips)>0)
									{
										foreach($clips as $clp){																					
											//$time = $time + timeToMilliseconds($clp['clip_duration']);	
											$time = $time + $clp['clip_duration'];	
										}
									}
									?>
									<tr class="rundownTR">
									  <td>
									    <div class="boxes">
									      <input type="checkbox" id="RUN_<?php echo $rundown['id'];?>" class="rundownActions">
												<label for="RUN_<?php echo $rundown['id'];?>"></label>
									    </div>
									  </td>
									  <td><?php echo $counter;?></td>
									  <td><a href="<?php echo site_url();?>editrundown/<?php echo $rundown['id'];?>"><?php echo $rundown['title'];?></a></td>
										<td>
											<?php echo sizeof($clips);?> Clips
									  <p class="clr" title=""><?php echo gmdate("H:i:s", $time);?></p>
									  </td>
										<td>
											<span>
											<?php
											$URL = "rtmp://";
											$encoder = $this->common_model->getAllEncoders($rundown['engine_id'],0);
											$nebula = $this->common_model->getNebulabyId($rundown['engine_id'],0);
											if($rundown['engine_type'] == 'encoder')
											{
												$URL = $URL.$encoder[0]['encoder_ip'];
											}
											else if($rundown['engine_type'] == 'nebula')
											{
												$URL = $URL.$nebula[0]['encoder_ip'];
											}
											$URL = $URL.':1935/rundowns/'.$rundown['rundown_id'].'-preview';
											echo $URL;
											?>
											</span>
										</td>
										<td>
										<?php
									    	if($rundown['status']==0)
									    	{
												?>
												<span id="status" class="label label-gray">Disabled </span>
												<?php
											}
											else if($rundown['status'] == 1){
												?>
												<span id="status" class="label label-success">Running </span>
												<?php
											}
									     ?>
									    
									  </td>
										<td>
									  </td>										
										
										<td class="lck"><a accesskey="<?php echo $rundown['id'];?>" class="loclRundown" href="javascript:void(0);"><i class="fa fa-unlock"></i></a></td>
										<td class="del"><a accesskey="<?php echo $rundown['id'];?>" class="deleteRundown" href="javascript:void(0);"><i class="fa fa-trash"></i></a></td>

									</tr>
									<?php
									$counter++;
								}
							}
							else{
								?>
								<tr>
								<td colspan="11">No Rundowns Added Yet!</td>
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
									</div>

							</div>
					</div>
					<!-- ========= Section One End ========= -->

					</div>
        		</div>
        	</div>
        </div>
    </div>
</main>
