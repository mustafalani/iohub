<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12 conf shadow min-h-64">
					<div class="row">
						<div class="col-lg-12 btns-dv2">
							<button class="btn btn-red-drk btn-sm pull-right">
								<span><i class="fa fa-save"></i> Save</span>
							</button>
						</div>
						<div class="col-lg-5 p-t-15">
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Playlist Name</label>
									<input type="text" class="form-control" placeholder="MyPlaylist" name="">
								</div>
							</div>
							<div class="form-group col-lg-12">
								<div class="row">
									<label>Select Channel</label>
									<select class="form-control select" name="">
										<option>Wowza Streem Engine 1</option>
										<option>Wowza Streem Engine 2</option>
										<option>Wowza Streem Engine 3</option>
									</select>
								</div>
							</div>
						</div>

						<div class="col-lg-2">
							<div class="form-group ply-chks">
								<label class="checkbox-inline">
									<input type="checkbox" value="">Start Manually
								</label><br>
								<label class="checkbox-inline">
									<input type="checkbox" value="">Add to Schedule
								</label>
							</div>
						</div>

						<div class="col-lg-4">
							<div class="drag-drop">
								<i class="fa fa-plus"></i>
								<p>Add Videos to Playlist</p>
							</div>
						</div>
					</div>
				</div>
				<!-- </div> -->
			</div>
		</div>
