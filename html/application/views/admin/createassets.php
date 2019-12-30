<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<style type="text/css">
	.netdata-chart span{
		color: #FFFFFF !important;
	}
	.wowzaTable tr td a.wowzadisable:hover .box-body
	{
		display:block !important;
	}
.dropzone {
    background: #343B41; 
}
</style>
<script type="text/javascript">
	var _folderSettings = {};	
</script>
<?php 
$settingss = json_encode($settings);
echo '<script type="text/javascript">';
echo "_folderSettings=".$settingss;
echo '</script>';
?>

<main class="main">
        <!-- Breadcrumb-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Home</a>
          </li>
          <li class="breadcrumb-item active"><a href="assets">Assets</a></li>
					<li class="breadcrumb-item active">New Asset</li>
        </ol>
        <div class="container-fluid">
        <div class="animated fadeIn">
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
			<div class="card">
				<div class="card-header">Add New Asset</div>
				<div class="card-body">
					<div class="row">
				<div class="col-md-12 mb-4">
                <ul class="nav nav-tabs" role="tablist">
                	<?php
            		$user_permissions = $this->session->userdata('user_permissions');
		              $userdata = $userdata = $this->session->userdata('user_data');
		              if($userdata['user_type'] == 1)
		              {
		              	?>
		              	<li class="nav-item" role="presentation">

		              	<a class="nav-link active" id="system" href="#main" aria-controls="systems" role="tab" data-toggle="tab">Main</a></li>
		              	<?php
					  }
					?>
                </ul>
                <div class="tab-content">
                  			<div role="tabpanel" class="tab-pane active" id="main">
										<div class="row">
											<div class="col-lg-6 col-md-6">
												<div class='form-group col-lg-11 pl-0 folderSelection'>
													<label>Folder</label>
													<select id="id_folder" name="id_folder" class="form-control selectpicker">
													<option value="">Select</option>
													<?php
													
													if(sizeof($settings['data']['folders'])>0)
													{
														foreach($settings['data']['folders'] as $fid=>$folder)
														{
															?>
																<option style="color:#<?php echo base_convert($settings['data']['folders'][$fid]['color'], 10, 16);?>" value="<?php echo $fid;?>"><?php echo $folder['title']; ?></option>
															<?php
														}
													}
													?>
												</select>
												</div>
											</div>
										</div>
										<br/>
										<div class="row">
											<div class="col-lg-6 col-md-12 p-0 fields">
											</div>
											<div class="col-lg-6 col-md-12">
												<form id="frm_assetsmain" action="<?php echo site_url();?>admin/upload_asset_files/<?php echo $this->uri->segment(3);?>"  method="post" enctype="multipart/form-data">
												<input type="hidden" id="assetid" name="assetid"/>
												</form>		
											</div>
										</div>

								</div>							
						</div>
                	</div>
              </div>
		</div>
		<div class="card-footer">
				<button class="btn btn-sm btn-primary btnSaveAssets" accesskey="<?php echo $this->uri->segment(3);?>" type="button">Next</button>
				<button class="btn btn-sm btn-danger btnresetAssets" type="reset">Reset</button>
				</div>
				</div>
			</div>

        </div>
        </div>
</main>
