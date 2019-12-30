<?php $this->load->view('guser/navigation.php');?>
<?php $this->load->view('guser/leftsidebar.php');?>

  <!-- ========= Content Wrapper Start ========= -->
        <section class="content-wrapper">
            <!-- ========= Main Content Start ========= -->
            <div class="content">
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
                <div class="content-container">
                    <div class="row">
                        <!-- ========= Section One Start ========= -->
                        <div class="col-lg-12 col-12-12">
                            <div class="content-box config-contentonly">
                                <div class="config-container">
                                    <!-- === Nav tabs === -->
                                    <div class="tab-btn-container">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#Channels" aria-controls="channels" role="tab" data-toggle="tab">Channels</a></li>
                                        </ul>
                                        <a href="#" class="btn-def save">Save</a>
                                    </div>

                                    <!-- === Tab panes === -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="channels">
    <div class="action-table">
        <div class="row">
            <div class="col-xs-12">
                <div class="box-header">
                    <!-- Single button -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a href="#">Lock</a></li>
                            <li><a href="#">Unlock</a></li>
                            <li><a href="#">Restart</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Delete</a></li>
                        </ul>
                    </div>
                    <!-- Standard button -->
                    <button type="button" class="btn btn-default submit">Submit</button>
                    <a href="<?php echo site_url();?>admin/createchannel" class="add-btn">
                        <span><i class="fa fa-plus"></i> Chennel</span>
                    </a>
                </div>
                <div class="box">
                    <div class="box-body table-responsive no-padding">
                        <table  class="table table-hover check-input channelTable">
                            <tr>
                                <th>
                                    <div class="boxes">
                                        <input type="checkbox" id="allChannels" >
                                        <label for="allChannels"></label>
                                    </div>
                                </th>
                                <th>ID</th>
                                <th>Channel Name</th>
                                <th>Input</th>
                                <th>Output</th>
                                <th>Status</th>
                                <th> &nbsp; </th>
                                <th> &nbsp; </th>
                                <th> &nbsp; </th>
                                <th> &nbsp; </th>
                                <th> &nbsp; </th>

                            </tr>
                            <?php
                            $counter=1;
                           if(sizeof($channels)>0)
                           {
						   	foreach($channels as $channel)
						   	{
								?>
								<tr>
                                <td>
                                    <div class="boxes">
                                        <input type="checkbox" id="channelActions">
                                        <label for="channelActions"></label>
                                    </div>
                                </td>
                            	<td><?php echo $counter;?></td>
                                <td><?php echo $channel['channel_name'];?></td>
                                <td>NDI<br>OTT-ENC-03 (NDI_2)</td>
                                <td>SDI<br>OTT-ENC-02 -> DeckLink SDI (3)</td>
                                <td><span class="label label-danger">OFFLINE</span></td>
                                <td><a data-container="body" data-toggle="tooltip" title="Refresh" data-placement="bottom" data-html="true" class="wowzadisable" href="javascript:void(0);"><i class="fa fa-refresh"></i></a></td>
                                <td><a data-container="body" data-toggle="tooltip" title="Copy" data-placement="bottom" data-html="true" class="wowzadisable" href="javascript:void(0);"><i class="fa fa-copy"></i></a></td>
                                <td><a data-container="body" data-toggle="tooltip" title="Start/Stop" data-placement="bottom" data-html="true" id="ss_<?php echo $channel['id'];?>" class="channelsstartstop" href="javascript:void(0);"><i class="fa fa-play"></i></a></td>
                                <td><a data-container="body" data-toggle="tooltip" title="Lock/Un-Lock" data-placement="bottom" data-html="true" class="wowzadisable" href="javascript:void(0);"><i class="fa fa-unlock"></i></a></td>
                                <td><a data-container="body" data-toggle="tooltip" title="Delete" data-placement="bottom" data-html="true" class="wowzadisable" href="javascript:void(0);"><i class="fa fa-trash"></i></a></td>
                            </tr>
								<?php
								$counter++;
							}
						   }
						   else
						   {
						   	?>
						   	 <tr>
                            	<td colspan="11">No Channels Found!</td>
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
                        </div>
                        <!-- ========= Section One End ========= -->

                        
                    </div>
                </div>
            </div>
            <!-- ========= Main Content End ========= -->
        </section>
        <!-- ========= Content Wrapper End ========= -->
	
