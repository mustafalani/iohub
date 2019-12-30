

<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<style type="text/css">
	table.dataTable tbody tr {
    background:none !important;
}
.table > thead > tr > th {
    vertical-align: middle !important;

}
.action-table table.table {

    background:none !important;
    border: 1px solid #cecece;
    margin: 0;
    min-width: 100% !important;
	width: 100% !important;

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
	background:#747474;
	border:none;
}
.dataTables_filter label
{
	color:#fff;
}
.dataTables_filter input
{
	background:#747474;
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
}
.dataTables_info
{
	color: beige !important;
	margin-bottom: 11px;
}
.dataTables_paginate {
   background: #fff;
width: 100%;
padding: 13px !important;
border-radius: 0px 0px 8px 8px;
}
</style>
<main class="main">
	   <!-- Breadcrumb-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Home</a>
          </li>
          <li class="breadcrumb-item active">Logs</li>
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
                     <div class="tab-content">
                     		<div id="apps" class="tab-pane active">
                           <div class="action-table">
                              <div class="row">
                                 <div class="col-12">
                                  <div class="box-header">
                                       <div class="btn-group">
											<select class="form-control actionsel" id = "actionLogs">
												<option value ="">Action</option>
												<option value ="Clear">Clear</option>
											</select>

                                       </div>
                                       <button type="button" class="btn btn-primary submit" onclick="submitAllLogs();">Submit</button>
                                    </div>
										<br/>
                                          <table class="table dataTable no-footer logTables check-input" style="width:100%;">
                                             <thead>
                                             	   <th><div class='boxes'><input type='checkbox' id='log_all' class='selectalllogs'><label for='log_all'></label></div></th>
                                             	   <th>ID</th>
                                             	   <th>Section</th>
                                             	   <th>Date</th>
                                                   <th>Operation</th>
                                                   <th>User</th>
                                                   <th>Status</th>
                                             </thead>
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
