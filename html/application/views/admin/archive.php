<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<style type="text/css">
	table.dataTable tbody tr {
    background:none !important;
}

.action-table table.table {

    background:none !important;
    margin: 0;
    min-width: 100% !important;
	width: 100% !important;

}

.table thead th {
	vertical-align: top!important;
	border-bottom: none;
}
.action-table table.table tr td{
    color:#fff;
}
.dataTables_length
{
	float: right !important;
	margin-left: 15px;
}
.dataTables_length label
{
	color:#fff;
}
.dataTables_length select
{
	background: #515b64;
	    border: 1px solid #23282c;
	    color: white;
	    height: calc(1.648438rem + 2px);
	    padding-top: .375rem;
	    padding-bottom: .375rem;
	    font-size: 75%;
}
.dataTables_filter label
{
	color:#fff;
}
.dataTables_filter input
{
	background:#747474;
}

.dataTables_wrapper .dataTables_paginate {
    text-align: right;
}

.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0.5em 1em;
    text-decoration:none;
    cursor: pointer;
		color: #fff;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    color: #20a8d8;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.current, .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
	color: #20a8d8;
}
.dataTables_wrapper .dataTables_info {
    padding-top: 0.755em;
}

span.code
{
padding: 2px 4px;
font-size: 13px;
color: pink;
background: none;
border-radius: 4px;
min-height: 25px;
overflow: hidden;
display: block;
width: 585px;
text-align: left;
}
#loaderlogs
{
	background: none;
	display: none;
}
.dataTables_info
{
	color: beige !important;
	margin-bottom: 11px;
}
.dataTables_paginate {
background: #2f353a52;
width: 100%;
padding: 13px !important;
}

</style>
<main class="main">
   <!-- Breadcrumb-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="#">Home</a>
      </li>
      <li class="breadcrumb-item active">Archives</li>
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
                        <ul class="nav nav-tabs" role="tablist" id="appstarger">
                        	<li class="nav-item">
                        		<a class="nav-link active" id="target" data-toggle="tab" href="#channles">Channels</a></li>
                        	<li class="nav-item">
                        		<a class="nav-link" id="application" data-toggle="tab" href="#apps">Applications</a></li>
                            <li class="nav-item">
                            	<a class="nav-link" id="target" data-toggle="tab" href="#apps_tar">Targets</a></li>
                        </ul>
                     </div>
                     <div class="tab-content">
                     		<div id="channles" class="tab-pane active">
                           <div class="action-table">
                              <div class="row">
                                 <div class="col-md-12">
                                    <div class="box-header">
                                       <div class="btn-group">

											<select class="form-control actionsel" id = "actionArchiveChannel" name="actionArchiveChannel">
												<option value ="">Action</option>
												<option value ="Delete">Delete</option>
												<option value ="Restore">Restore</option>
											</select>

                                       </div>
                                       <button type="button" class="btn btn-primary submit" onclick="submitArchiveChannels();">Submit</button>
                                    </div>
                                    <table class="table cstmtable check-input archiveChannelsTable">
                                          	<thead>

                                                   <th><div class="boxes">
				                                        <input type="checkbox" id="selectallarchivechannels" class="selectallarchivechannels">
				                                        <label for="selectallarchivechannels"></label>
				                                    </div>
				                                   </th>
                                                   <th>ID</th>
                                                   <th>Channel Name</th>
                                                   <th>Process Name</th>
                                                   <th>User</th>
                                                   <th>Restore</th>
                                                   <th>Delete</th>
                                          	</thead>
                                             <tbody>


                                             </tbody>
                                          </table>
                                 </div>
                              </div>
                           </div>
                        </div>
							<div id="apps" class="tab-pane">
                           <div class="action-table">
                              <div class="row">
                                 <div class="col-md-12">
                                    <div class="box-header">
                                       <div class="btn-group">

											<select class="form-control actionsel" id = "actionArchiveApps" name="actionArchiveApps">
												<option value ="">Action</option>
												<option value ="Delete">Delete</option>
												<option value ="Restore">Restore</option>
											</select>

                                       </div>
                                       <button type="button" class="btn btn-primary submit" onclick="submitAllArchiveApps('admin/appActions');">Submit</button>
                                    </div>
                                    <table class="table cstmtable table-hover check-input archiveAppsTable">
                                          	<thead>

                                                   <th><div class="boxes">
				                                        <input type="checkbox" id="selectallarchiveApps" class="selectallarchiveApps">
				                                        <label for="selectallarchiveApps"></label>
				                                    </div>
				                                   </th>
                                                   <th>ID</th>
                                                   <th>Application Name</th>
                                                   <th>Stream URL</th>
                                                   <th>User</th>
                                                   <th>Restore</th>
                                                   <th>Delete</th>
                                          	</thead>
                                             <tbody>


                                             </tbody>
                                          </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div id="apps_tar" class="tab-pane">
                           <div class="action-table">
                              <div class="row">
                                 <div class="col-md-12">
                                    <div class="box-header">
                                       <div class="btn-group">

												<select class="form-control actionsel" id="actionArchTarget">
													<option value ="">Action</option>
													<option value ="Delete">Delete</option>
													<option value ="Restore">Restore</option>
												</select>

                                       </div>
                                       <button type="button" class="btn btn-primary submit" onclick="submitAllArchiveTargets('admin/targetActions');">Submit</button>

                                    </div>

                                          <table class="table cstmtable table-hover check-input archiveTargetTable">
                                          	<thead>
                                          		  <th><div class="boxes">
				                                        <input type="checkbox" id="selectallArchtargets">
				                                        <label for="selectallArchtargets"></label>
				                                    </div></th>
                                                  <th>ID</th>
                                                   <th>Target Name</th>
                                                   <th>Stream URL</th>
                                                   <th>Target Type</th>
                                                   <th>User</th>
                                                   <th>Restore</th>
                                                   <th>Delete</th>
                                          	</thead>
                                             <tbody>
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
</main>
<section class="content-wrapper">
   <!-- ========= Main Content Start ========= -->
   <div class="content">




      <div class="content-container">

      </div>
   </div>
</section>
