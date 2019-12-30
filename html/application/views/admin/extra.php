<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<style type="text/css">
.extr:hover i{
	color: #38A1D3;
}
</style>
<!-- ========= Content Wrapper Start ========= -->
<main class="main">
				<!-- Breadcrumb-->
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a href="#">Home</a>
					</li>
					<li class="breadcrumb-item active">Extra</li>
				</ol>
				<div class="container-fluid">
				<div class="animated fadeIn">
									<div class="card">
				<div class="card-body">
                    <div class="row">
                    		<div class="col-lg-12 col-12-12">
								<div class="content-box config-contentonly">
									<div class="config-container">
										<div class="row">
										<div class="col-1">
											<a class="extr" href="<?php echo site_url(); ?>streamviewer" style="width: 100px;font-size:105px;color:#fff;height:123px;display:block;">
												<i class="fa fa-th-large"></i></a>
											<a href="<?php echo site_url(); ?>streamviewer">
												<span>Stream Viewer</span></a>
										</div>
										<div style="text-align:center;width:103px !important;">
											<a class="extr" href="<?php echo site_url(); ?>iotstream" style="width: 101px;font-size:105px;color:#fff;height:138px;display:block;">
												<i class="icon-screen-tablet"></i></a>
											<a href="<?php echo site_url(); ?>iotstream" style="text-align:center;">
												<span>IoT Stream</span></a></div>
										</div>							
                             		</div>
                           		</div>
                         </div>
                    </div>
                </div>
            </div>
					</div>
				</div>
            <!-- ========= Main Content End ========= -->
			</main>
        <!-- ========= Content Wrapper End ========= -->
