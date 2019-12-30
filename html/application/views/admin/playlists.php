<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12 conf shadow min-h-64">
					<div class="col-lg-12">
						<div class="row">
							<select class="btn btn-sm select">
								<option>Actions</option>
							</select>
							<button class="btn btn-sm select">Submit</button>
							<a href="<?php echo site_url();?>admin/createplaylist" class="btn btn-green-drk btn-sm pull-right">
								<span>
									<i class="fa fa-plus"></i>
									<i class="fa fa-hdd-o"></i>
									VOD
								</span>
							</a>
							<a class="btn btn-green-drk btn-sm pull-right">
								<span>
									<i class="fa fa-plus"></i>
									<i class="fa fa-video-camera"></i>
									Live
								</span>
							</a>
						</div>
					</div>
					<div class="col-lg-12 tabl">
						<div class="row">
							<div class="table-responsive">
								<table class="table table-striped">
									<thead>
										<tr>
											<th><input type="checkbox" name=""></th>
											<th>ID</th>
											<th>Playlist Name</th>
											<th>Channel</th>
											<th>Length</th>
											<th>Live Preview</th>
											<th>Status</th>
											<th>Actions</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><input type="checkbox" name=""></td>
											<td>1</td>
											<td>My Playlist</td>
											<td>Wowza Stream Engine 1</td>
											<td><strong>21</strong> Videos<br>
												00:37:09 Total
											</td>
											<td>rtmp://192.168.1.11:1953/PL-FB-LIVE/myStream</td>
											<td><button class="btn btn-green btn-xs">RUNNING</button></td>
											<td>
												<a href="javascript:void(0);"><i class="fa fa-refresh"></i></a>
												<a href="javascript:void(0);"><i class="fa fa-copy"></i></a>
												<a href="play-video.html"><i class="fa fa-play"></i></a>
												<a href="javascript:void(0);"><i class="fa fa-trash"></i></a>
											</td>
										</tr>
										<tr>
											<td><input type="checkbox" name=""></td>
											<td>1</td>
											<td>My Playlist2</td>
											<td>TV3 Sport WSE</td>
											<td><strong>1</strong> Videos<br>
												00:07:09 Total
											</td>
											<td>rtmp://192.168.1.11:1953/PL-FB-LIVE/myStream</td>
											<td><button class="btn btn-red btn-xs">STOPPED</button></td>
											<td>
												<a href="javascript:void(0);"><i class="fa fa-refresh"></i></a>
												<a href="javascript:void(0);"><i class="fa fa-copy"></i></a>
												<a href="play-video.html"><i class="fa fa-play"></i></a>
												<a href="javascript:void(0);"><i class="fa fa-trash"></i></a>
											</td>
										</tr>
										<tr>
											<td><input type="checkbox" name=""></td>
											<td>1</td>
											<td>My Playlist3</td>
											<td>TV2-WSE-01</td>
											<td>This playlist is empty<br>
											</i> 00:07:09 Total
										</td>
										<td>rtmp://192.168.1.11:1953/PL-FB-LIVE/myStream</td>
										<td><button class="btn btn-yellow btn-xs">SCHEDULED</button></td>
										<td>
											<a href="javascript:void(0);"><i class="fa fa-refresh"></i></a>
											<a href="javascript:void(0);"><i class="fa fa-copy"></i></a>
											<a href="play-video.html"><i class="fa fa-play"></i></a>
											<a href="javascript:void(0);"><i class="fa fa-trash"></i></a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- </div> -->
			</div>
		</div>
		<div class="row">
			<div class="footer">
				<span>Kurrent Stream Manager - Copyright Kurrent Ltd. All rights reserved v1.0</span>
				<span class="pull-right">Technical Support</span>
			</div>
		</div>
	</div>
