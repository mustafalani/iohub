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
	.form-control {
		height: calc(1.5em + 0.75rem + 2px);
		font-size: 0.875rem;
	}
</style>
<main class="main">
	   <!-- Breadcrumb-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Home</a>
          </li>
          <li class="breadcrumb-item active">Assets</li>
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
					<div class="mb-4 col-12">
    <ul class="nav nav-tabs">
        <li class="nav-item"><a class="nav-link active" id="main" href="#main" role="tab" data-toggle="tab">Main</a></li>
        <li class="nav-item"><a class="nav-link" id="fill" href="#fill" role="tab" data-toggle="tab">Fill</a></li>
        <li class="nav-item"><a class="nav-link" id="music" href="#music" role="tab" data-toggle="tab">Music</a></li>
        <li class="nav-item"><a class="nav-link" id="stories" href="#stories" role="tab" data-toggle="tab">Stories</a></li>
        <li class="nav-item"><a class="nav-link" id="commercial" href="#commercial" role="tab" data-toggle="tab">Commercial</a></li>
				<li class="nav-item"><a class="nav-link" id="incoming" href="#incoming" role="tab" data-toggle="tab">Incoming</a></li>
				<li class="nav-item"><a class="nav-link" id="archive" href="#archive" role="tab" data-toggle="tab">Archive</a></li>
        <li class="nav-item"><a class="nav-link" id="trash" href="#trash" role="tab" data-toggle="tab">Trash</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" role="tabpanel" id="main">
            <div class="row">
                <div class="d-none d-sm-inline-block col-sm-4">
                    <div aria-label="Toolbar with button groups" role="toolbar" class="float-left btn-toolbar">
                        <div aria-label="First group" role="group" class="mr-3 btn-group">
                            <button type="button" class="btn btn-outline-secondary">
                                <i class="fa fa-th-list"></i></button>
                            <button type="button" class="btn btn-outline-secondary active">

                                <i class="fa fa-th-large"></i></button>
                            <button type="button" class="btn btn-outline-secondary">

                                <i class="fa fa-cog"></i></button>
                        </div>
                    </div>
                </div>
                <div class="d-none d-sm-inline-block col-sm-4">
                    <a href="#/asset/add">
                        <button class="float-left btn btn-primary">

                            <i class="fa fa-plus"></i> Add New Asset</button>
                    </a>
                </div>
                <div class="col-md-4">
                    <div class="float-right position-relative form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-btn btn-outline-dark btn-block">

                                    <i class="fa fa-search"></i></button>
                            </div>
                            <input id="input3-group2" name="input3-group2" placeholder="Search" type="text" class="form-control" value="">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-btn btn-outline-dark btn-block">

                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
						<div class="card">
						    <div class="card-body">
						        <div class="row">
						            <div class="mb-4 col-12 col-sm-6 col-md-4 col-xl-2">
						                <table class="w-100" style="table-layout: fixed;">
						                    <tbody>
						                        <tr>
						                            <td>
						                                <div style="position: relative;">
						                                    <div>
						                                        <div class="rh5v-DefaultPlayer_component ">
						                                            <video class="rh5v-DefaultPlayer_video" poster="https://kurrenttv.nbla.cloud/thumb/0000/42/orig.jpg">
						                                                <source src="https://kurrenttv.nbla.cloud/proxy/0000/42.mp4" type="video/webm">
						                                            </video>
						                                            
						                                            
						                                        </div>
						                                    </div>
						                                </div><a href="#/asset/42"><h5>trip_to_the_moon</h5></a>

						                                <i class="fa fa-circle text-success"></i><span>  </span>

						                                <i class="fa fa-flag text-danger"></i><span>  </span><span>  </span>
						                                <button class="badge badge-block btn-outline-secondary" disabled="">00:12:52:00</button><span>  </span>
						                                <button class="badge badge-block btn-outline-secondary" disabled="">4 GB</button><span>  </span>
						                                <button class="badge badge-block btn-outline-secondary" disabled="">25FPS</button><span>  </span>
						                                <button class="badge badge-block btn-outline-secondary" disabled="">DNXHD</button><span>  </span>
						                                <button class="badge badge-block btn-outline-secondary" disabled="">1920x1080</button>
						                            </td>
						                        </tr>
						                    </tbody>
						                </table>
						            </div>
						           
						        </div>
						    </div>
						</div>
        </div>
        <div class="tab-pane" role="tabpanel" id="fill">
            <div class="row">
                <div class="d-none d-sm-inline-block col-sm-4">
                    <div aria-label="Toolbar with button groups" role="toolbar" class="float-left btn-toolbar">
                        <div aria-label="First group" role="group" class="mr-3 btn-group">
                            <button type="button" class="btn btn-outline-secondary">

                                <i class="fa fa-th-list"></i></button>
                            <button type="button" class="btn btn-outline-secondary active">

                                <i class="fa fa-th-large"></i></button>
                            <button type="button" class="btn btn-outline-secondary">

                                <i class="fa fa-cog"></i></button>
                        </div>
                    </div>
                </div>
                <div class="d-none d-sm-inline-block col-sm-4">
                    <a href="#/asset/add">
                        <button class="float-left btn btn-primary">

                            <i class="fa fa-plus"></i>Add New Asset</button>
                    </a>
                </div>
                <div class="col-md-4">
                    <div class="float-right position-relative form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-btn btn-outline-dark btn-block">

                                    <i class="fa fa-search"></i></button>
                            </div>
                            <input id="input3-group2" name="input3-group2" placeholder="Search" type="text" class="form-control" value="">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-btn btn-outline-dark btn-block">

                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
        <div class="tab-pane">
            <div class="row">
                <div class="d-none d-sm-inline-block col-sm-4">
                    <div aria-label="Toolbar with button groups" role="toolbar" class="float-left btn-toolbar">
                        <div aria-label="First group" role="group" class="mr-3 btn-group">
                            <button type="button" class="btn btn-outline-secondary">

                                <i class="fa fa-th-list"></i></button>
                            <button type="button" class="btn btn-outline-secondary active">

                                <i class="fa fa-th-large"></i></button>
                            <button type="button" class="btn btn-outline-secondary">

                                <i class="fa fa-cog"></i></button>
                        </div>
                    </div>
                </div>
                <div class="d-none d-sm-inline-block col-sm-4">
                    <a href="#/asset/add">
                        <button class="float-left btn btn-primary">

                            <i class="fa fa-plus"></i>Add New Asset</button>
                    </a>
                </div>
                <div class="col-md-4">
                    <div class="float-right position-relative form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-btn btn-outline-dark btn-block">

                                    <i class="fa fa-search"></i></button>
                            </div>
                            <input id="input3-group2" name="input3-group2" placeholder="Search" type="text" class="form-control" value="">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-btn btn-outline-dark btn-block">

                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
        <div class="tab-pane">
            <div class="row">
                <div class="d-none d-sm-inline-block col-sm-4">
                    <div aria-label="Toolbar with button groups" role="toolbar" class="float-left btn-toolbar">
                        <div aria-label="First group" role="group" class="mr-3 btn-group">
                            <button type="button" class="btn btn-outline-secondary">

                                <i class="fa fa-th-list"></i></button>
                            <button type="button" class="btn btn-outline-secondary active">

                                <i class="fa fa-th-large"></i></button>
                            <button type="button" class="btn btn-outline-secondary">

                                <i class="fa fa-cog"></i></button>
                        </div>
                    </div>
                </div>
                <div class="d-none d-sm-inline-block col-sm-4">
                    <a href="#/asset/add">
                        <button class="float-left btn btn-primary">

                            <i class="fa fa-plus"></i>Add New Asset</button>
                    </a>
                </div>
                <div class="col-md-4">
                    <div class="float-right position-relative form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-btn btn-outline-dark btn-block">

                                    <i class="fa fa-search"></i></button>
                            </div>
                            <input id="input3-group2" name="input3-group2" placeholder="Search" type="text" class="form-control" value="">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-btn btn-outline-dark btn-block">

                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
        <div class="tab-pane">
            <div class="row">
                <div class="d-none d-sm-inline-block col-sm-4">
                    <div aria-label="Toolbar with button groups" role="toolbar" class="float-left btn-toolbar">
                        <div aria-label="First group" role="group" class="mr-3 btn-group">
                            <button type="button" class="btn btn-outline-secondary">

                                <i class="fa fa-th-list"></i></button>
                            <button type="button" class="btn btn-outline-secondary active">

                                <i class="fa fa-th-large"></i></button>
                            <button type="button" class="btn btn-outline-secondary">

                                <i class="fa fa-cog"></i></button>
                        </div>
                    </div>
                </div>
                <div class="d-none d-sm-inline-block col-sm-4">
                    <a href="#/asset/add">
                        <button class="float-left btn btn-primary">

                            <i class="fa fa-plus"></i>Add New Asset</button>
                    </a>
                </div>
                <div class="col-md-4">
                    <div class="float-right position-relative form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-btn btn-outline-dark btn-block">

                                    <i class="fa fa-search"></i></button>
                            </div>
                            <input id="input3-group2" name="input3-group2" placeholder="Search" type="text" class="form-control" value="">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-btn btn-outline-dark btn-block">

                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
        <div class="tab-pane">
            <div class="row">
                <div class="d-none d-sm-inline-block col-sm-4">
                    <div aria-label="Toolbar with button groups" role="toolbar" class="float-left btn-toolbar">
                        <div aria-label="First group" role="group" class="mr-3 btn-group">
                            <button type="button" class="btn btn-outline-secondary">

                                <i class="fa fa-th-list"></i></button>
                            <button type="button" class="btn btn-outline-secondary active">

                                <i class="fa fa-th-large"></i></button>
                            <button type="button" class="btn btn-outline-secondary">

                                <i class="fa fa-cog"></i></button>
                        </div>
                    </div>
                </div>
                <div class="d-none d-sm-inline-block col-sm-4">
                    <a href="#/asset/add">
                        <button class="float-left btn btn-primary">

                            <i class="fa fa-plus"></i>Add New Asset</button>
                    </a>
                </div>
                <div class="col-md-4">
                    <div class="float-right position-relative form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-btn btn-outline-dark btn-block">

                                    <i class="fa fa-search"></i></button>
                            </div>
                            <input id="input3-group2" name="input3-group2" placeholder="Search" type="text" class="form-control" value="">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-btn btn-outline-dark btn-block">

                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
        <div class="tab-pane">
            <div class="row">
                <div class="d-none d-sm-inline-block col-sm-4">
                    <div aria-label="Toolbar with button groups" role="toolbar" class="float-left btn-toolbar">
                        <div aria-label="First group" role="group" class="mr-3 btn-group">
                            <button type="button" class="btn btn-outline-secondary">

                                <i class="fa fa-th-list"></i></button>
                            <button type="button" class="btn btn-outline-secondary active">

                                <i class="fa fa-th-large"></i></button>
                            <button type="button" class="btn btn-outline-secondary">

                                <i class="fa fa-cog"></i></button>
                        </div>
                    </div>
                </div>
                <div class="d-none d-sm-inline-block col-sm-4">
                    <a href="#/asset/add">
                        <button class="float-left btn btn-primary">

                            <i class="fa fa-plus"></i>Add New Asset</button>
                    </a>
                </div>
                <div class="col-md-4">
                    <div class="float-right position-relative form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-btn btn-outline-dark btn-block">

                                    <i class="fa fa-search"></i></button>
                            </div>
                            <input id="input3-group2" name="input3-group2" placeholder="Search" type="text" class="form-control" value="">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-btn btn-outline-dark btn-block">

                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
            </div>
        </div>
        <div class="tab-pane">
            <div class="row">
                <div class="d-none d-sm-inline-block col-sm-4">
                    <div aria-label="Toolbar with button groups" role="toolbar" class="float-left btn-toolbar">
                        <div aria-label="First group" role="group" class="mr-3 btn-group">
                            <button type="button" class="btn btn-outline-secondary">

                                <i class="fa fa-th-list"></i></button>
                            <button type="button" class="btn btn-outline-secondary active">

                                <i class="fa fa-th-large"></i></button>
                            <button type="button" class="btn btn-outline-secondary">

                                <i class="fa fa-cog"></i></button>
                        </div>
                    </div>
                </div>
                <div class="d-none d-sm-inline-block col-sm-4">
                    <a href="#/asset/add">
                        <button class="float-left btn btn-primary">

                            <i class="fa fa-plus"></i>Add New Asset</button>
                    </a>
                </div>
                <div class="col-md-4">
                    <div class="float-right position-relative form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <button type="button" class="btn btn-btn btn-outline-dark btn-block">

                                    <i class="fa fa-search"></i></button>
                            </div>
                            <input id="input3-group2" name="input3-group2" placeholder="Search" type="text" class="form-control" value="">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-btn btn-outline-dark btn-block">

                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4"></div>
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
