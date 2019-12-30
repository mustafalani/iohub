

<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<script src="https://cdn.jsdelivr.net/npm/vue@2.5.17/dist/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

  <!-- ========= Content Wrapper Start ========= -->
        <section class="content-wrapper">
            <!-- ========= Main Content Start ========= -->
            <div class="content">
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
                        <div class="custom-select">
							<select class="form-control actionsel" id="actionChannels">
								<option value="0">Action</option>
								<option value="Lock">Lock</option>
								<option value="UnLock">Un-Lock</option>	
								<option value="Restart">Restart</option>
								<option value ="Archive">Archive</option>
								<option value="Delete">Delete</option>
							</select>
							</div>
                    </div>
                    <!-- Standard button -->
                    <button type="button" class="btn btn-default submit" onclick="submitChannels();">Submit</button>
                    <a href="<?php echo site_url();?>createchannel" class="add-btn">
                        <span><i class="fa fa-plus"></i> Channel</span>
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
                                <th  width="200px">Input</th>
                                <th>Output</th>
                                <th>Status</th>
                                <th> &nbsp; </th>
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
								<tr id="row_<?php echo $channel['id'];?>">
                                <td>
                                    <div class="boxes">
                                        <input type="checkbox" id="channel_<?php echo $channel['id'];?>" class="channelActions">
                                        <label for="channel_<?php echo $channel['id'];?>"></label>
                                    </div>
                                </td>
                            	<td><?php echo $counter;?></td>
                                <td><a class="channels_status" onclick="openEditPage('<?php echo site_url();?>updatechannel/<?php echo $channel['id'];?>',this);" href="javascript:void(0);"><?php echo $channel['channel_name'];?></a></td>
                                <td>
                                	
                                
                                <?php 
                                
                                $channelInput = $channel['channelInput'];
                                 $channelInputid=explode("_",$channelInput);
                                 switch($channelInputid[0])
                                 {
								 	case "phyinput":
								 		$id = $channel['encoder_id'];
								 		$encoder = $this->common_model->getAllEncoders($id,0);								 		
								 		$encoderInput = $this->common_model->getEncoderInputbyId($channelInputid[1]);
								 		if(sizeof($encoder) > 0)
								 		{
											echo $encoder[0]['encoder_name'].'->'. $encoderInput[0]['item'];	
										}
										else
										{
											echo "NA";
										}
								 		
								 	break;
								 	case "virinput":
								 		$virInput = $this->common_model->channelInput($channelInputid[1]);
								 		switch($channelInputid[1])
								 		{
											case 3:
												echo $virInput[0]['item'] .' ('.$channel['channel_ndi_source'].')';
											break;
											case 4:
											echo $virInput[0]['item'] .' ('.$channel['input_rtmp_url'].')';
											break;
											case 5:
											echo $virInput[0]['item'] .' ('.$channel['input_mpeg_rtp'].')';
											break;
											case 6:
											echo $virInput[0]['item'] .' ('.$channel['input_mpeg_udp'].')';
											break;
											case 7:
											echo $virInput[0]['item'] .' ('.$channel['input_mpeg_srt'].')';
											break;
											case 8:
											
											echo $virInput[0]['item'] .' ('.substr($channel['input_hls_url'],0,50).'...)';
											break;
										}
								 		
								 	break;
								 }
                                  ?></td>
                                <td><?php $channelOutpue= $channel['channelOutpue'];
                                $channelOutpueid=explode("_",$channelOutpue);
                                
                                 switch($channelOutpueid[0])
                                 {
								 	case "phyoutput":
								 		$id = $channel['encoder_id'];
								 		$encoder = $this->common_model->getAllEncoders($id,0);								 		
								 		$encoderOutput = $this->common_model->getOutputName($channelOutpueid[1]);
								 		if(sizeof($encoder)>0)
								 		{
											echo $encoder[0]['encoder_name'].'->'. $encoderOutput[0]['item'];	
										}
										else{
											echo "NA";
										}
								 		
								 		?>
								 	
								 		<?php
								 	break;
								 	case "viroutput":
								 		$virOutput = $this->common_model->channelOutput($channelOutpueid[1]);
								 		switch($channelOutpueid[1])
								 		{
											case 3:
												echo $virOutput[0]['item'] .' ('.$channel['ndi_name'].')';
											break;
											case 4:
											echo $virOutput[0]['item'] .' ('.$channel['output_rtmp_url'].'/'.$channel['output_rtmp_key'].')';
											break;
											case 5:
											echo $virOutput[0]['item'] .' ('.$channel['output_mpeg_rtp'].')';
											break;
											case 6:
											echo $virOutput[0]['item'] .' ('.$channel['output_mpeg_udp'].')';
											break;
											case 7:
											echo $virOutput[0]['item'] .' ('.$channel['output_mpeg_srt'].')';
											break;
										}
								 		
								 	break;} ?></td>
								 	
                                <td><span id="status" class="label label-gray">Offline</span></td>
                                <td><p class="counter" title=""></p></td>
                                <td><a data-container="body" data-toggle="tooltip" title="Refresh" data-placement="bottom" data-html="true" class="wowzadisable" href="javascript:void(0);"><i class="fa fa-refresh"></i></a></td>
                                <td><a data-container="body" data-toggle="tooltip" title="Copy" data-placement="bottom" data-html="true" id="ss_<?php echo $channel['id'];?>" class="channelscopy" href="javascript:void(0);"><i class="fa fa-copy"></i></a></td>
                                <td><a data-container="body" data-toggle="tooltip" title="Start/Stop" data-placement="bottom" data-html="true" id="ss_<?php echo $channel['id'];?>" class="channelsstartstop" href="javascript:void(0);"><i class="fa fa-play"></i></a></td>
                                <td>
                                	<?php 
                                	if($channel['isLocked'] == 0)
                                	{
								?>
								<a data-container="body" data-toggle="tooltip" title="Lock/Un-Lock" data-placement="bottom" id="ss_<?php echo $channel['id'];?>" data-html="true" class="channellocs" href="javascript:void(0);"><i class="fa fa-unlock"></i></a>
								<?php		
									}
									elseif($channel['isLocked'] == 1)
                                	{
								?>
								<a data-container="body" data-toggle="tooltip" title="Lock/Un-Lock" data-placement="bottom" id="ss_<?php echo $channel['id'];?>" data-html="true" class="channellocs" href="javascript:void(0);"><i class="fa fa-lock"></i></a>
								<?php		
									}
                                	?>
                                </td>
                                <td><a data-container="body" data-toggle="tooltip" title="Delete" data-placement="bottom" data-html="true" id="ss_<?php echo $channel['id'];?>"  class="channelsDelete" href="javascript:void(0);"><i class="fa fa-trash"></i></a></td>
                            </tr>
								<?php
								$counter++;
							}
						   }
						   else
						   {
						   	?>
						   	 <tr>
                            	<td colspan="12">No Channels Found!</td>
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
	
