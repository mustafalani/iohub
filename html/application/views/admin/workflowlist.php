<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>

<script type="text/javascript">
	var channelLocks = [];
</script>
<?php
if(sizeof($channelsLock)>0)
{
	foreach($channelsLock as $key=>$chanl)
	{
		if($chanl == NULL)
		{
			echo '<script type="text/javascript">channelLocks['.$key.']=0;</script>';
		}
		else
		{
			echo '<script type="text/javascript">channelLocks['.$key.']='.$chanl.';</script>';
		}
	}
}
?>
<style type="text/css">
	.clr{
		color:#747474;
	}
</style>
<main class="main">
	   <!-- Breadcrumb-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Home</a>
          </li>
          <li class="breadcrumb-item active">Workflows</li>
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
                                            <li  class="nav-item" role="presentation" >
                                            	<a class="nav-link active" href="#workflows" aria-controls="channels" role="tab" data-toggle="tab">Workflow</a></li>
                                        </ul>


                                    <!-- === Tab panes === -->
                                    <div class="tab-content">
										<div role="tabpanel" class="tab-pane active" id="workflows">
											<div class="card-body">
												<div class="row">
            <div class="col-12" style="padding: 0;">
                <div class="box-header">
                    <!-- Single button -->
                    <div class="btn-group">

							<select class="form-control actionsel" id="actionChannels">
								<option value="0">Action</option>
								<option value="Lock">Lock</option>
								<option value="UnLock">Un-Lock</option>
								<option value="Restart">Restart</option>
								<option value ="Archive">Archive</option>
								<option value="Delete">Delete</option>
							</select>

                    </div>
                    <!-- Standard button -->
                    <button type="button" class="btn btn-primary submit" onclick="submitChannels();">Submit</button>
                    <a href="<?php echo site_url();?>workflows" class="add-btn btn btn-primary float-right">
                        <span><i class="fa fa-plus"></i> Workflow</span>
                    </a>
                </div>
                <br/>

                    <div class=" table-responsive no-padding">
                        <table  class="table table-hover check-input cstmtable channeltable cstmtable">
                            <tr>
                                <th width="60px">
                                    <div class="boxes">
                                        <input type="checkbox" id="allChannels" >
                                        <label for="allChannels"></label>
                                    </div>
                                </th>
                                <th width="40px">ID</th>
                                <th width="200px">Channel Name</th>
                                <th  width="300px">Input</th>
                                <th>Output</th>
                                <th>Status</th>
                                <th> &nbsp; </th>
                                <th> &nbsp; </th>
                                <th> &nbsp; </th>
                                <th> &nbsp; </th>
                                <th> &nbsp; </th>
                                <th> &nbsp; </th>

                            </tr>
                            <tr>
                            	<td colspan="12">No Workflows Created yet!</td>
                            </tr>
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
