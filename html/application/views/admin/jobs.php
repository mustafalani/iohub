<?php $this->load->view('admin/navigation.php'); ?>
<?php $this->load->view('admin/leftsidebar.php'); ?>
<?php $this->load->view('admin/rightsidebar.php'); ?>
<?php 
function action_string($action){
	return 'Proxy';
}
?>
<main class="main">
	<!-- Breadcrumb-->
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="#">Home</a>
		</li>
		<li class="breadcrumb-item active">Jobs</li>
	</ol>
	<div class="container-fluid">
		<div class="animated fadeIn">
			<div class="card">
				<div class="card-body">
					<?php
					if ($this->session->flashdata('success')) {
					?>
					<div class="alert alert-success">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<?php echo $this->session->flashdata('success'); ?>
					</div>
					<?php } else if ($this->session->flashdata('error')) {
					?>
					<div class="alert alert-danger">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<?php echo $this->session->flashdata('error'); ?>
					</div>
					<?php } else if ($this->session->flashdata('warning')) {
					?>
					<div class="alert alert-warning">
						<a href="#" class="close" data-dismiss="alert">&times;</a>
						<?php echo $this->session->flashdata('warning'); ?>
					</div>
					<?php } else if ($this->session->flashdata('info')) {
					?>
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
											<a class="nav-link active" href="#jobs" aria-controls="jobs" role="tab" data-toggle="tab">Active Jobs</a></li>										
										<li class="nav-item" role="presentation" class="active">
											<a class="nav-link" href="#finishedjobs" aria-controls="jobs" role="tab" data-toggle="tab">Finished Jobs</a></li>
										<li class="nav-item" role="presentation" class="active">
											<a class="nav-link" href="#faildejobs" aria-controls="jobs" role="tab" data-toggle="tab">Failde Jobs</a></li>																				
									</ul>
									<!-- === Tab panes === -->
									<div class="tab-content">
										<div role="tabpanel" class="tab-pane active" id="jobs">
											<div class="card-body">
												<div class="row">
													<div class="col-12" style="padding: 0;">
														
														<div class="table-responsive no-padding">
															<table  class="table table-hover check-input cstmtable channeltable channelTable">
																<tr>
																	
																	<th width="40px">ID</th>
																	<th width="300px">Nebula Server</th>
																	<th width="260px">Asset Name</th>
																	<th width="260px">Action</th>
																	<th width="260px">Created</th>
																	<th width="260px">Started</th>
																	<th width="260px">Finished</th>
																	<th width="260px">Progress</th>
																	<th width="260px">Message</th>
																	
																</tr>
																<?php
															$counter=1;
																if (sizeof($resp['active_jobs']['data'])>0) {
																	foreach ($resp['active_jobs']['data'] as $asset) {
																		foreach($asset['data'] as $assets)
																		{
																			?>
																			<tr id="row_<?php echo $assets['id']; ?>">
																				<td><?php echo $counter; ?></td>
																	<td><?php echo $asset['encoder_name']; ?></td>
																	<td><?php echo $assets['title']; ?></td>
																	<td><?php echo action_string($asset['id_action']); ?></td>
 
																	<td><?php echo date('Y-m-d H:i:s',$asset['ctime']); ?></td>
																	<td><?php echo date('Y-m-d H:i:s',$asset['stime']); ?></td>
																	<td><?php echo date('Y-m-d H:i:s',$asset['etime']); ?></td>
																	<td><?php echo $asset['progress']; ?>%</td>
																	<td><?php echo $asset['message']; ?></td>
																			</tr>
																			<?php
																		}
																	$counter++;
																}
															} else {
																?>
																<tr>
																	<td colspan="12">No Active  Jobs Found!</td></tr>
																<?php
															}
															?>
															</table>
														</div>

													</div>
												</div>
											</div>

										</div>
										<div role="tabpanel" class="tab-pane" id="finishedjobs">
											<div class="card-body">
												<div class="row">
													<div class="col-12" style="padding: 0;">
														
														<div class="table-responsive no-padding">
															<table  class="table table-hover check-input cstmtable channeltable channelTable">
																<tr>																	
																	<th width="40px">ID</th>
																	<th width="300px">Nebula Server</th>
																	<th width="260px">Asset Name</th>
																	<th width="260px">Action</th>
																	<th width="260px">Created</th>
																	<th width="260px">Started</th>
																	<th width="260px">Finished</th>
																	<th width="260px">Progress</th>
																	<th width="260px">Message</th>
																	
																</tr>
																<?php
																$counter=1;
																if (sizeof($resp['finished_jobs']['data'])>0) {
																	foreach ($resp['finished_jobs']['data'] as $asset) {
																		foreach ($asset['data'] as $assets) {
																	?>
																	<tr id="row_<?php echo $assets['id']; ?>">
																	
																		<td><?php echo $counter; ?></td>
																	<td><?php echo $asset['encoder_name']; ?></td>
																		<td><?php echo $assets['title']; ?></td>
																	<td><?php echo action_string($asset['id_action']); ?></td>

																	<td><?php echo date('Y-m-d H:i:s',$asset['ctime']); ?></td>
																	<td><?php echo date('Y-m-d H:i:s',$asset['stime']); ?></td>
																	<td><?php echo date('Y-m-d H:i:s',$asset['etime']); ?></td>
																	<td><?php echo $asset['progress']; ?>%</td>
																	<td><?php echo $asset['message']; ?></td>
																	</tr>
																	<?php
																}
																$counter++;
															}
														} else {
																?>
																<tr>
																	<td colspan="12">No Finished Jobs Found!</td></tr>
																<?php
															}
																?>
															</table>
														</div>

													</div>
												</div>
											</div>

										</div>
										<div role="tabpanel" class="tab-pane" id="faildejobs">
											<div class="card-body">
												<div class="row">
													<div class="col-12" style="padding: 0;">
														
														<div class="table-responsive no-padding">
															<table  class="table table-hover check-input cstmtable channeltable channelTable">
																<tr>	
																	<th width="40px">ID</th>
																	<th width="300px">Nebula Server</th>
																	<th width="260px">Asset Name</th>
																	<th width="260px">Action</th>
																	<th width="260px">Created</th>
																	<th width="260px">Started</th>
																	<th width="260px">Finished</th>
																	<th width="260px">Progress</th>
																	<th width="260px">Message</th>
																	
																</tr>
																<?php
																$counter=1;
																if (sizeof($resp['failed_jobs']['data'])>0) {
																	foreach ($resp['failed_jobs']['data'] as $asset) {
																		foreach ($asset['data'] as $assets) {
																	?>
																	<tr id="row_<?php echo $assets['id']; ?>">
																		<td><?php echo $counter; ?></td>
																	<td><?php echo $asset['encoder_name']; ?></td>
																		<td><?php echo $assets['title']; ?></td>
																	<td><?php echo action_string($asset['id_action']); ?></td>

																	<td><?php echo date('Y-m-d H:i:s',$asset['ctime']); ?></td>
																	<td><?php echo date('Y-m-d H:i:s',$asset['stime']); ?></td>
																	<td><?php echo date('Y-m-d H:i:s',$asset['etime']); ?></td>
																	<td><?php echo $asset['progress']; ?>%</td>
																	<td><?php echo $asset['message']; ?></td>
																	</tr>
																	<?php
																}
																$counter++;
															}
														} else {
																?>
																<tr>
																	<td colspan="12">No Failde Jobs Found!</td></tr>
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
