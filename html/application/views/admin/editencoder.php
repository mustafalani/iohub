<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<script type="text/javascript">
   var EncInputs = "";
   var EncOutputs = "";
   var encoderModelOutFormat ="";
   var encoderModelsCount = "";
   var encoderharwareCount = 0;
   var encoderModelFirstSelection = 0;
   var encoderModelSecondSelection = 0;
   var encoderModelThirdSelection = 0;
   var encoderModelInputs = [];
   var encoderModelOutputs = [];
</script>
<?php
   $modelsArray = array();
   $outputFormatArray = array();
   $models = $this->common_model->getAllModels();
   $outputFormat = $this->common_model->getOutputFormats();
   if(sizeof($outputFormat) > 0)
   {
   	foreach($outputFormat as $outformt)
   	{
   		array_push($outputFormatArray,array('id'=>$outformt['item'],'value'=>$outformt['value']));
   	}
   }
   if(sizeof($models) > 0)
   {
   	foreach($models as $md)
   	{
   		$modelsArray[$md['id']] = 0;
   	}
   }
    $inputs = $this->common_model->getEncoderInputs();
    $outputs = $this->common_model->getEncoderOutput();
    $inputEnc = array();
    $outputEnc = array();
   if(sizeof($inputs) > 0)
   {
   	foreach($inputs as $input)
   	{
   		$inputEnc[$input['type']][] = array('id'=>$input['id'],'value'=>$input['item']);
   	}
   }

   if(sizeof($outputs) > 0)
   {
   	foreach($outputs as $output)
   	{
   		if($output['id'] != 5)
   		{
   			$outputEnc[$output['type']][] = array('id'=>$output['id'],"value"=>$output['item']);
   		}
   	}
   }
   ?>
<?php
   echo '<script type="text/Javascript">EncInputs ='.json_encode($inputEnc).';</script>';
   echo '<script type="text/Javascript">EncOutputs ='.json_encode($outputEnc).';</script>';
   echo '<script type="text/Javascript">encoderModelsCount='.json_encode($modelsArray).';</script>';
   echo '<script type="text/Javascript">encoderModelOutFormat='.json_encode($outputFormatArray).';</script>';


   	$hardselected = $this->common_model->getHardwareByEncdrId($encoder[0]['id']);
   $modelsararyyy = array();
   if(sizeof($hardselected)>0)
   {
   	foreach($hardselected as $inphard)
   	{
   		if(!array_key_exists($inphard['model'],$modelsararyyy))
   		{
   			$modelsararyyy[$inphard['model']]= 0;
   		}
   		$modelsararyyy[$inphard['model']] = $modelsararyyy[$inphard['model']] + 1;
   	}
   }

   if(sizeof($modelsararyyy)>0)
   {
   	foreach($modelsararyyy as $key=>$modelsel)
   	{
   		if($key != '10')
   		{
   			$count = $modelsel;
   			switch($key)
   			{
   				case "1":
   				$len = 0;
   				$len = (4) * ($count);
   				for($i=1; $i<=$len; $i++)
   				{
   				  echo '<script type="text/javascript">encoderModelInputs.push("DeckLink Duo ('.$i.')");</script>';
   				  echo '<script type="text/javascript">encoderModelOutputs.push("DeckLink Duo ('.$i.')");</script>';
   				}
   				break;
   				case "6":
   				$len = 0;
   				$len = 4 * $count;
   				for($j=1; $j<=$len; $j++)
   				{
   					echo '<script type="text/javascript">encoderModelInputs.push("DeckLink SDI ('.$j.')");</script>';
   																																	echo '<script type="text/javascript">encoderModelOutputs.push("DeckLink SDI ('.$j.')");</script>';

   				}
   				break;
   				case "8":
   				$len = 0;
   				$len = 1 * $count;
   				for($k=1; $k<=$len; $k++)
   				{
   					if($k>1)
   					{
   						echo '<script type="text/javascript">encoderModelInputs.push("DeckLink SDI Micro ('.$k.')");</script>';
   																																	echo '<script type="text/javascript">encoderModelOutputs.push("DeckLink SDI Micro ('.$k.')");</script>';

   					}
   					else
   					{
   						echo '<script type="text/javascript">encoderModelInputs.push("DeckLink SDI Micro");</script>';
   																																	echo '<script type="text/javascript">encoderModelOutputs.push("DeckLink SDI Micro");</script>';

   					}

   				}
   				break;
   				case "9":
   				$len = 0;
   				$len = 1 * $count;
   				for($i=1; $i<=$len; $i++)
   				{
   					if($i>1)
   					{
   						echo '<script type="text/javascript">encoderModelInputs.push("DeckLink Mini Recorder 4K ('.$i.')");</script>';
   					echo '<script type="text/javascript">encoderModelInputs.push("DeckLink Mini Recorder 4K - HDMI ('.$i.')");</script>';

   					}
   					else
   					{
   						echo '<script type="text/javascript">encoderModelInputs.push("DeckLink Mini Recorder 4K");</script>';
   					echo '<script type="text/javascript">encoderModelInputs.push("DeckLink Mini Recorder 4K - HDMI");</script>';

   					}

   				}
   				break;
   				case "10":
   				$len = 0;
   				$len = 1 * $count;
   				for($i=1; $i<=$len; $i++)
   				{
   					if($i>1)
   					{																												echo '<script type="text/javascript">encoderModelOutputs.push("DeckLink Mini Monitor 4K ('.$i.')")");</script>';

   					}
   					else
   					{																												echo '<script type="text/javascript">encoderModelOutputs.push("DeckLink Mini Monitor 4K");</script>';
   					}

   				}
   				break;
   			}
   		}
   	}
   }
   ?>
<style type="text/css">
   .pd-13
   {
   padding-top: 13px;
   }
   .minlink
   {
   padding-left: 5px;
   padding-right: 5px;
   }
   .hdAdd
   {
   border: 1px dotted #515151;
   padding: 12px;
   border-radius: 5px;
   color: #515151;
   margin-top: 20px;
   display: block;
   width: 50px;
   height: 50px;
   float: left;
   text-align: center;
   font-size: 19px;
   }
   .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
   background-color: #191919 !important;
   opacity: 1;
   }
   .yellow
   {
   color:#f2f906;
   border: 1px solid #4998C2;
   }
   .gr
   {
   border: 1px solid green;
   color: #fff;
   background: #00A65A;
   font-weight: bold;
   border-radius: 6px;
   }
   .rd
   {
   border:1px solid #D73925;
   color: #fff;
   background:#D73925;
   font-weight: bold;
   border-radius: 6px;
   }
   .action-table table.table {
   min-width: auto !important;
   }
   .irs-slider {
   width: 6px !important;
   height: 27px !important;
   border: 1px solid #AAA !important;
   background: #3AA6D9 !important;
   border-radius: 0px !important;
   }
   .irs-grid span.small
   {
   display: none !important;
   }
   .ht span.irs-with-grid {
   height: 49px !important;
   }
   .irs-line {
   top: 9px !important;
   }
   .irs-bar{
   top: 9px !important;
   display: none !important;
   }
   .irs-bar-edge{
   top: 9px !important;
   display: none !important;
   }
   .irs-slider {
   top:0px !important;
   }
   .irs-min, .irs-max {
   display: none !important;
   }
   .irs-from, .irs-to, .irs-single {
   display: none !important;
   }
   .ht > span.text-blue {
   display: block;
   height: 25px;
   color: #1C6B98 !important;
   }
   .outpt
   {
   position: absolute;
   color: white;
   border: none;
   min-width: 47px;
   left: -13px;
   top: 18px;
   background: #3C8DBC;
   padding-left: 5px;
   padding-right: 5px;
   border-radius: 3px;
   }
</style>
<link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/ion.rangeSlider.css"/>
<link rel="stylesheet" href="<?php echo site_url();?>public/site/main/css/ion.rangeSlider.skinHTML5.css"/>
<main class="main">
   <!-- Breadcrumb-->
   <ol class="breadcrumb">
      <li class="breadcrumb-item">
         <a href="<?php echo site_url();?>">Home</a>
      </li>
      <li class="breadcrumb-item active"><a href="<?php echo site_url();?>configuration">Settings</a></li>
      <li class="breadcrumb-item active"><?php echo $encoder[0]['encoder_name'];?></li>
   </ol>
   <div class="container-fluid">
   <div class="animated fadeIn">
   <div class="card">
    <form id="wowza-form" class="action-table" method="post" action="<?php echo site_url();?>admin/updateEncoder/<?php echo $encoder[0]['id'];?>" enctype="multipart/form-data">
     <div class="card-header">Edit Encoder</div>
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
         <?php }?>
         <div class="row">
            <div class="col-lg-12 col-12-12">
               <div class="content-box config-contentonly">

                     <!--<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>"/>-->
                     <input type="hidden" id="encoderId" name="encoderId" value="<?php echo $encoder[0]['id'];?>"/>

                        <ul class="nav nav-tabs" role="tablist" id="configuration">
                           <li class="nav-item " role="presentation">
                           		<a class="nav-link active" id="generaltab" href="#general" aria-controls="systems" role="tab" data-toggle="tab">General</a></li>
                           <li class="nav-item" role="presentation">
                           		<a class="nav-link" id="hardwaretabs" href="#hardware" aria-controls="wowza" role="tab" data-toggle="tab">Hardware</a></li>
                           <li class="nav-item" role="presentation">
                           		<a class="nav-link" id="inputsTab" href="#inputs" aria-controls="ffmpeg" role="tab" data-toggle="tab">Inputs</a></li>
                           <li class="nav-item" role="presentation">
                           		<a class="nav-link" id="ouptputsTab" href="#outputs" aria-controls="ffmpeg" role="tab" data-toggle="tab">Outputs</a></li>
                           <li class="nav-item" role="presentation">
                           		<a class="nav-link" id="recordingsTab" href="#recordings" aria-controls="Encoding Templates" role="tab" data-toggle="tab">Recordings</a></li>
                        </ul>
                      <!--  <button type="submit" class="btn-def save btn btn-primary float-right" style="position: absolute;right: 18px;top: -9px;">
                        <span>Update</span>
                        </button>-->

                     <div class="tab-content">
                        <div role="tabpanel" class="tab-pane pd-13 active" id="general">
                        	<div class="row">
                        		 <div class="col-lg-4 col-md-12">
                              <div class="form-group">
                                 <label>Encoder Name <span class="mndtry">*</span></label>
                                 <input type="text" name="encoder_name" id="encoder_name" class="form-control" required="true" value="<?php echo $encoder[0]['encoder_name'];?>"/>
                              </div>
                              <div class="form-group">
                                 <div class="row">
                                    <div class="col-md-6">
                                       <label>IP Address <span class="mndtry">*</span></label>
                                       <input type="text" class="form-control"  id="encoder_ip" name="encoder_ip" required="true" value="<?php echo $encoder[0]['encoder_ip'];?>"/>
                                    </div>
                                    <div class="col-md-6">
                                       <label>SSH Port <span class="mndtry">*</span></label>
                                       <input type="text" class="form-control"  id="encoder_port" name="encoder_port" required="true" value="<?php echo $encoder[0]['encoder_port'];?>"/>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <div class="row">
                                    <div class="col-md-6">
                                       <label>User Name <span class="mndtry">*</span></label>
                                       <input type="text" class="form-control" placeholder="Admin"  id="encoder_uname" name="encoder_uname" required="true" value="<?php echo $encoder[0]['encoder_uname'];?>">
                                    </div>
                                    <div class="col-md-6">
                                       <label>Password <span class="mndtry">*</span></label>
                                       <input type="password" class="form-control" id="encoder_pass" name="encoder_pass" required="true" value="<?php echo $encoder[0]['encoder_pass'];?>"/>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-4 col-md-12">
                              <div class="form-group">
                                 <div class="row">
                                    <div class="form-group">
                                       <div class="row">
                                          <?php
                                             if($userdata['user_type']==1)
                                             {
                                             ?>
                                          <div class="col-md-12">
                                             <label>Assigned to</label>
                                             <select class="form-control selectpicker" name="encoder_group" id="encoder_group">
                                                <option value="0">-- Select --</option>
                                                <?php
                                                   if(sizeof($groups)>0)
                                                   {
                                                   	$counter =1;
                                                   	foreach($groups as $group)
                                                   	{
                                                   		if($encoder[0]['encoder_group'] == $group['id'])
                                                   		{
                                                   		?>
                                                <option selected="selected" value="<?php echo $group['id'];?>"><?php echo $group['group_name'];?></option>
                                                <?php
                                                   }
                                                   else
                                                   {
                                                   	?>
                                                <option value="<?php echo $group['id'];?>"><?php echo $group['group_name'];?></option>
                                                <?php
                                                   }
                                                   }
                                                   }
                                                   ?>
                                             </select>
                                          </div>
                                          <?php
                                             }
                                             else
                                             {
                                             ?>
                                          <div class="col-md-12 dnone">
                                             <label>Assigned to</label>
                                             <select class="form-control selectpicker" name="encoder_group" id="encoder_group">
                                                <option value="0">-- Select --</option>
                                                <?php
                                                   if(sizeof($groups)>0)
                                                   {
                                                   	$counter =1;
                                                   	foreach($groups as $group)
                                                   	{
                                                   		if($encoder[0]['encoder_group'] == $group['id'])
                                                   		{
                                                   		?>
                                                <option selected="selected" value="<?php echo $group['id'];?>"><?php echo $group['group_name'];?></option>
                                                <?php
                                                   }
                                                   else
                                                   {
                                                   	?>
                                                <option value="<?php echo $group['id'];?>"><?php echo $group['group_name'];?></option>
                                                <?php
                                                   }
                                                   }
                                                   }
                                                   ?>
                                             </select>
                                          </div>
                                          <?php
                                             }
                                                                                               	?>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <div class="row">
                                    <div class="col-md-8">
                                       <div class="check-input">
                                          <div class="boxes">
                                             <?php
                                                if($encoder[0]['encoder_enable_netdata'] == 1)
                                                {
                                                ?>
                                             <input id="encoder_enable_netdata" checked="true" name="encoder_enable_netdata" type="checkbox">
                                             <?php
                                                }
                                                else
                                                {
                                                ?>
                                             <input id="encoder_enable_netdata" name="encoder_enable_netdata" type="checkbox">
                                             <?php
                                                }
                                                                                                     	?>
                                             <label for="encoder_enable_netdata" style="padding-left:25px;">Enable Netdata Monitoring</label>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-group">
                                 <div class="row">
                                    <div class="col-md-8">
                                       <div class="check-input">
                                          <div class="boxes">
                                             <?php
                                                if($encoder[0]['encoder_enable_hdmi_out'] == 1)
                                                {
                                                ?>
                                             <input checked="true" id="encoder_enable_hdmi_out" name="encoder_enable_hdmi_out" type="checkbox">
                                             <?php
                                                }
                                                else
                                                {
                                                ?>
                                             <input id="encoder_enable_hdmi_out" name="encoder_enable_hdmi_out" type="checkbox">
                                             <?php
                                                }
                                                                                                     	?>
                                             <label for="encoder_enable_hdmi_out" style="padding-left:25px;">Enable PC Output</label>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="col-lg-4 col-md-12">
                              <div class="form-group">
                                 <label>Encoder ID</label>
                                 <input type="text" readonly="true" class="form-control yellow"  value="<?php echo $encoder[0]['encoder_id'];?>"/>
                              </div>
                              <div class="form-group">
                                 <label>Pair Token</label>
                                 <?php
                                    if($encoder[0]['paired'] == 1)
                                    {
                                    	?>
                                 <input type="text" readonly="true" class="form-control yellow pairingtext"  placeholder="Not-Paired" value="<?php echo $encoder[0]['pairID'];?>"/>
                                 <?php
                                    }
                                    else
                                    {
                                    	?>
                                 <input type="text" readonly="true" class="form-control yellow pairingtext"  placeholder="Not-Paired"/>
                                 <?php
                                    }
                                                                           ?>
                              </div>
                              <?php
                                 if($encoder[0]['paired'] == 1)
                                 {
                                 	?>
                              <a href="javascript:void(0);"  id="<?php echo $encoder[0]['encoder_id'];?>_unpair" class="btn gr pairing_encoder">Unpair <span></span></a>
                              <?php
                                 }
                                 else
                                 {
                                 	?>
                              <a  href="javascript:void(0);" id="<?php echo $encoder[0]['encoder_id'];?>_pair" class="btn rd pairing_encoder">Pair<span></span></a>
                              <?php
                                 }
                                                                        ?>
                           </div>
                        	</div>

                           <div class="col-xs-6 col-md-12 text-center">
                              <div style="width: 100%; max-height: calc(100% - 15px); text-align: center; display: inline-block;">
                                 <div style="width: 100%; height:100%; align: center; display: inline-block;">
                                    <br/>
                                    <?php $host = "http://".$encoder[0]['encoder_ip'].":19999";
                                       $url = $host."/api/v1/charts";
                                       $ch = curl_init();
                                       $headers = array(
                                       'Content-Type: application/json'
                                       );
                                       curl_setopt($ch, CURLOPT_URL, $url);
                                       curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                                       curl_setopt($ch, CURLOPT_HEADER, 0);
                                       curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                                       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                       curl_setopt($ch, CURLOPT_TIMEOUT, 3);
                                       $result = curl_exec($ch);
                                       $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                                       if($httpcode == 200)
                                       {
                                       ?>
                                    <div class="netdata-container-easypiechart"style="margin-right: 10px; width: 11%; will-change: transform;" data-netdata="system.io" data-host="<?php echo $host;?>"
                                       data-dimensions="in"
                                       data-chart-library="easypiechart"
                                       data-title="Disk Read"
                                       data-width="10%"
                                       data-before="0"
                                       data-after="-420"
                                       data-points="420"
                                       data-common-units="system.io.mainhead"
                                       role="application">
                                    </div>
                                    <div class="netdata-container-easypiechart" style="margin-right: 10px; width: 11%; will-change: transform;" data-netdata="system.io" data-host="<?php echo $host;?>"
                                       data-dimensions="out"
                                       data-chart-library="easypiechart"
                                       data-title="Disk Write"
                                       data-width="10%"
                                       data-before="0"
                                       data-after="-420"
                                       data-points="420"
                                       data-common-units="system.io.mainhead"
                                       role="application">
                                    </div>
                                    <div data-netdata="disk_space._"
                                       data-host="<?php echo $host;?>"
                                       data-decimal-digits="0"
                                       data-title="Available Disk"
                                       data-dimensions="avail"
                                       data-chart-library="easypiechart"
                                       data-easypiechart-max-value="100"
                                       data-width="11%"
                                       data-height="100%"
                                       data-after="-420"
                                       data-points="420"
                                       role="application">
                                    </div>
                                    <div class="netdata-container-gauge" style="margin-right: 10px; width: 20%; will-change: transform;" data-netdata="system.cpu"  data-host="<?php echo $host;?>"
                                       data-chart-library="gauge"
                                       data-title="CPU"
                                       data-units="%"
                                       data-gauge-max-value="100"
                                       data-width="20%"
                                       data-after="-420"
                                       data-points="420"
                                       data-colors="#22AA99"
                                       role="application">
                                    </div>
                                    <div class="netdata-container-easypiechart" style="margin-right: 10px; width: 9%; will-change: transform;" data-netdata="system.ram" data-host="<?php echo $host;?>"
                                       data-dimensions="used|buffers|active|wired"
                                       data-append-options="percentage"
                                       data-chart-library="easypiechart"
                                       data-title="Used RAM"
                                       data-units="%"
                                       data-easypiechart-max-value="100"
                                       data-width="11%"
                                       data-after="-420"
                                       data-points="420"
                                       data-colors="#EE9911"
                                       role="application">
                                    </div>
                                    <div class="netdata-container-easypiechart" style="margin-right: 10px; width: 11%; will-change: transform;" data-netdata="system.net" data-host="<?php echo $host;?>"
                                       data-dimensions="received"
                                       data-chart-library="easypiechart"
                                       data-title="Net Inbound"
                                       data-width="10%"
                                       data-before="0"
                                       data-after="-420"
                                       data-points="420"
                                       data-common-units="system.net.mainhead"
                                       role="application">
                                    </div>
                                    <div class="netdata-container-easypiechart" style="margin-right: 10px; width: 11%; will-change: transform;" data-netdata="system.net" data-host="<?php echo $host;?>"
                                       data-dimensions="sent"
                                       data-chart-library="easypiechart"
                                       data-title="Net
                                       Outbound" data-width="10%"
                                       data-before="0"
                                       data-after="-420"
                                       data-points="420"
                                       data-common-units="system.net.mainhead"
                                       role="application">
                                    </div>
                                    <?php
                                       }
                                              else
                                              {
                                       ?>
                                    <div class="row">
                                       <div class="col-xs-6 col-md-12 text-center">
                                          <h1>No Data Found</h1>
                                       </div>
                                    </div>
                                    <?php
                                       }

                                                   ?>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div role="tabpanel" class="tab-pane pd-13 fade" id="hardware">
                           <div class="row">
                           	 <div class="col-lg-3 col-md-12 hardware-box">
                              <div class="form-group">
                                 <label>Hardware <span class="mndtry">*</span></label>
                                 <select class="form-control selectpicker" name="encoder_hardware" id="encoder_hardware" required="true">
                                    <option value="0">-- none --</option>
                                    <?php
                                       $hardware = $this->common_model->getAllHardware();
                                       if(sizeof($hardware)>0)
                                       {
                                       	$hards = $this->common_model->getHardwareByEncId($encoder[0]['id'],"encoder_hardware");

                                       foreach($hardware as $hard)
                                       {
                                       if(sizeof($hards)>0)
                                       {
                                       if($hards[0]['hardware'] == $hard['id'])
                                       {
                                       echo '<option selected="selected" value="'.$hard['id'].'">'.$hard['item'].'</option>';
                                       }
                                       else
                                       {
                                       echo '<option value="'.$hard['id'].'">'.$hard['item'].'</option>';
                                       }

                                       }
                                       else
                                       {
                                       echo '<option value="'.$hard['id'].'">'.$hard['item'].'</option>';
                                       }
                                       }
                                       }
                                       ?>
                                 </select>
                              </div>
                              <div class="form-group">
                                 <?php
                                    $modelss = $this->common_model->getHardwareModelByEncId($encoder[0]['id'],"encoder_model");
                                    ?>
                                 <script type="text/javascript">encoderModelFirstSelection = '<?php echo $modelss[0]["model"];?>';</script>
                                 <label>Model <span class="mndtry">*</span></label>
                                 <select class="form-control selectpicker" name="encoder_model" id="encoder_model" required="true">
                                    <option value="0">-- none --</option>
                                    <?php
                                       $model = $this->common_model->getAllModels();
                                       if(sizeof($model)>0)
                                       {

                                       foreach($model as $modl)
                                       {
                                       if($modl['status'] == 1)
                                       {
                                       if($modelss[0]["model"] == $modl['id'])
                                       {
                                       echo '<option selected="selected" value="'.$modl['id'].'">'.$modl['item'].'</option>';
                                       }
                                       else
                                       {
                                       echo '<option value="'.$modl['id'].'">'.$modl['item'].'</option>';
                                       }

                                       }
                                       else if($modl['status'] == 0)
                                       {
                                       echo '<option disabled="disabled" value="'.$modl['id'].'">'.$modl['item'].'</option>';
                                       }

                                       }
                                       }
                                       ?>
                                 </select>
                              </div>
                           </div>
                           <?php
                              $hards1 = $this->common_model->getHardwareByEncId($encoder[0]['id'],"encoder_hardware1");
                              $hards2 = $this->common_model->getHardwareByEncId($encoder[0]['id'],"encoder_hardware2");
                              if(sizeof($hards1)>0)
                              {

                              ?>
                           <script type="text/javascript">encoderharwareCount = encoderharwareCount+1;</script>
                           <div class='col-lg-3 col-md-12 hardware-box'>
                              <div class='form-group'>
                                 <label style='width:100%;'>Hardware <span class='mndtry'>*</span> <a href='javascript:void(0);' class='pull-right minlink'><i class='fa fa-times-circle'></i></a></label>
                                 <select class='form-control selectpicker' id="encoder_hardware1" name='encoder_hardware1'  required='true'>
                                    <option value="0">-- none --</option>
                                    <?php
                                       if(sizeof($hardware)>0)
                                                                             {
                                       foreach($hardware as $hard)
                                       {
                                       if(sizeof($hards1)>0)
                                       {
                                       if($hards1[0]['hardware'] == $hard['id'])
                                       {
                                       echo '<option selected="selected" value="'.$hard['id'].'">'.$hard['item'].'</option>';
                                       }
                                       else
                                       {
                                       echo '<option value="'.$hard['id'].'">'.$hard['item'].'</option>';
                                       }

                                       }
                                       else
                                       {
                                       echo '<option value="'.$hard['id'].'">'.$hard['item'].'</option>';
                                       }
                                       }
                                       }
                                       ?>
                                 </select>
                              </div>
                              <div class='form-group'>
                                 <?php
                                    $modelss = $this->common_model->getHardwareModelByEncId($encoder[0]['id'],"encoder_model1");
                                    ?>
                                 <script type="text/javascript">encoderModelSecondSelection = '<?php echo $modelss[0]["model"];?>';</script>
                                 <label>Model <span class='mndtry'>*</span></label>
                                 <select class='form-control selectpicker' id="encoder_model1" name='encoder_model1' >
                                    <option value="0">-- none --</option>
                                    <?php
                                       if(sizeof($model)>0)
                                                                              {

                                       foreach($model as $modl)
                                       {
                                       if($modl['status'] == 1)
                                       {
                                       if($modelss[0]["model"] == $modl['id'])
                                       {
                                       	echo '<option selected="selected" value="'.$modl['id'].'">'.$modl['item'].'</option>';
                                       }
                                       else
                                       {
                                       	echo '<option value="'.$modl['id'].'">'.$modl['item'].'</option>';
                                       }

                                       }
                                       else if($modl['status'] == 0)
                                       {
                                       echo '<option disabled="disabled" value="'.$modl['id'].'">'.$modl['item'].'</option>';
                                       }

                                       }
                                       }
                                       ?>
                                 </select>
                              </div>
                           </div>
                           <?php
                              }
                              if(sizeof($hards2)>0)
                                                               {
                              	?>
                           <script type="text/javascript">encoderharwareCount = encoderharwareCount+1;</script>
                           <div class='col-lg-3 col-md-12 hardware-box'>
                              <div class='form-group'>
                                 <label style='width:100%;'>Hardware <span class='mndtry'>*</span> <a href='javascript:void(0);' class='pull-right minlink'><i class='fa fa-times-circle'></i></a></label>
                                 <select class='form-control selectpicker' id="encoder_hardware2" name='encoder_hardware2' required='true'>
                                    <option value="0">-- none --</option>
                                    <?php
                                       if(sizeof($hardware)>0)
                                                                             {
                                       foreach($hardware as $hard)
                                       {
                                       if(sizeof($hards2)>0)
                                       {
                                       if($hards2[0]['hardware'] == $hard['id'])
                                       {
                                       echo '<option selected="selected" value="'.$hard['id'].'">'.$hard['item'].'</option>';
                                       }
                                       else
                                       {
                                       echo '<option value="'.$hard['id'].'">'.$hard['item'].'</option>';
                                       }

                                       }
                                       else
                                       {
                                       echo '<option value="'.$hard['id'].'">'.$hard['item'].'</option>';
                                       }
                                       }
                                       }
                                       ?>
                                 </select>
                              </div>
                              <div class='form-group'>
                                 <?php
                                    $modelss = $this->common_model->getHardwareModelByEncId($encoder[0]['id'],"encoder_model2");
                                    ?>
                                 <script type="text/javascript">encoderModelThirdSelection = '<?php echo $modelss[0]["model"];?>';</script>
                                 <label>Model <span class='mndtry'>*</span></label>
                                 <select class='form-control selectpicker' id="encoder_model2" name='encoder_model2'>
                                    <option value="0">-- none --</option>
                                    <?php
                                       if(sizeof($model)>0)
                                                                              {
                                       foreach($model as $modl)
                                       {
                                       if($modl['status'] == 1)
                                       {
                                       if($modelss[0]["model"] == $modl['id'])
                                       {
                                       	echo '<option selected="selected" value="'.$modl['id'].'">'.$modl['item'].'</option>';
                                       }
                                       else
                                       {
                                       	echo '<option value="'.$modl['id'].'">'.$modl['item'].'</option>';
                                       }

                                       }
                                       else if($modl['status'] == 0)
                                       {
                                       echo '<option disabled="disabled" value="'.$modl['id'].'">'.$modl['item'].'</option>';
                                       }

                                       }
                                       }
                                       ?>
                                 </select>
                              </div>
                           </div>
                           <?php
                              }?>
                              <a href="javascript:void(0);" class="hdAdd"><i class="fa fa-plus"></i></a>
                           </div>


                        </div>
                        <div role="tabpanel" class="tab-pane pd-13 fade" id="inputs">
                           <div class="col-lg-12 col-md-12">
                              <div class="box-header">
                                 <a class="add-btn btn btn-primary" id="add_encoder_inputs" href="javascript:void(0);">
                                 <span><i class="fa fa-plus"></i> Input</span>
                                 </a>
                              </div>
                              <br/>
                              <div class="table-responsive no-padding">
                              <table class="cstmtable table table-hover check-input hardware_input_table">
                                 <thead>
                                    <th>Label</th>
                                    <th>Video Source</th>
                                    <th>Audio Source</th>
                                    <th>Status</th>
                                    <th>Delete</th>
                                 </thead>
                                 <tbody>
                                    <?php
                                       $inputsOutputs = $this->common_model->getEncoderInpOutbyEncid($encoder[0]['id']);

                                       $selectedArray = array();
                                       if(sizeof($inputsOutputs)>0)
                                       {
                                       	foreach($inputsOutputs as $inps)
                                       	{
                                       ?>
                                    <tr>
                                       <td><input type='text' class='form-control' name='inputs[]' value='<?php echo $inps['inp_name'];?>'/></td>
                                       <td class='sourcestd'>
                                          <select name='videoinputsources[]' class='form-control videosources'>
                                             <option value=''>-- none --</option>
                                             <?php
                                                $hardselected = $this->common_model->getHardwareByEncdrId($encoder[0]['id']);
                                                $modelsararyyy = array();
                                                if(sizeof($hardselected)>0)
                                                {
                                                	foreach($hardselected as $inphard)
                                                	{
                                                		if(!array_key_exists($inphard['model'],$modelsararyyy))
                                                		{
                                                			$modelsararyyy[$inphard['model']]= 0;
                                                		}
                                                		$modelsararyyy[$inphard['model']] = $modelsararyyy[$inphard['model']] + 1;
                                                	}
                                                }

                                                if(sizeof($modelsararyyy)>0)
                                                {
                                                	foreach($modelsararyyy as $key=>$modelsel)
                                                	{
                                                		if($key != '10')
                                                		{
                                                			$count = $modelsel;
                                                			switch($key)
                                                			{
                                                				case "1":
                                                				$len = 0;
                                                				$len = (4) * ($count);
                                                				for($i=1; $i<=$len; $i++)
                                                				{
                                                					if($inps['inp_source'] == "DeckLink Duo (".$i.")")
                                                					{
                                                						echo "<option selected='selected' value='DeckLink Duo (".$i.")'>DeckLink Duo (".$i.")</option>";
                                                						array_push($selectedArray,"DeckLink Duo (".$i.")");
                                                					}
                                                					else
                                                					{
                                                						if(sizeof($selectedArray)>0)
                                                						{
                                                							if(in_array("DeckLink Duo (".$i.")",$selectedArray))
                                                							{
                                                								echo "<option disabled='disabled' value='DeckLink Duo (".$i.")'>DeckLink Duo (".$i.")</option>";
                                                							}
                                                							else
                                                							{
                                                								echo "<option value='DeckLink Duo (".$i.")'>DeckLink Duo (".$i.")</option>";
                                                							}
                                                						}
                                                						else
                                                						{
                                                							echo "<option value='DeckLink Duo (".$i.")'>DeckLink Duo (".$i.")</option>";
                                                						}
                                                					}
                                                				}
                                                				break;
                                                				case "6":
                                                				$len = 0;
                                                				$len = 4 * $count;
                                                				for($j=1; $j<=$len; $j++)
                                                				{
                                                					if($inps['inp_source'] == "DeckLink SDI (".$j.")")
                                                					{
                                                						echo "<option selected='selected' value='DeckLink SDI (".$j.")'>DeckLink SDI (".$j.")</option>";
                                                						array_push($selectedArray,"DeckLink SDI (".$j.")");
                                                					}
                                                					else
                                                					{
                                                						if(sizeof($selectedArray)>0)
                                                						{
                                                							if(in_array("DeckLink SDI (".$j.")",$selectedArray))
                                                							{
                                                								echo "<option disabled='disabled' value='DeckLink SDI (".$j.")'>DeckLink SDI (".$j.")</option>";
                                                							}
                                                							else
                                                							{
                                                							echo "<option value='DeckLink SDI (".$j.")'>DeckLink SDI (".$j.")</option>";
                                                							}
                                                						}
                                                						else
                                                						{
                                                							echo "<option value='DeckLink SDI (".$j.")'>DeckLink SDI (".$j.")</option>";
                                                						}
                                                					}
                                                				}
                                                				break;
                                                				case "8":
                                                				$len = 0;
                                                				$len = 1 * $count;
                                                				for($k=1; $k<=$len; $k++)
                                                				{
                                                					if($k>1)
                                                					{
                                                						if($inps['inp_source'] == "DeckLink SDI Micro (".$k.")")
                                                						{

                                                							echo "<option selected='selected' value='DeckLink SDI (".$k.")'>DeckLink SDI Micro (".$k.")</option>";
                                                							array_push($selectedArray,"DeckLink SDI Micro (".$k.")");

                                                						}
                                                						else
                                                						{
                                                							if(sizeof($selectedArray)>0)
                                                							{
                                                								if(in_array("DeckLink SDI Micro (".$k.")",$selectedArray))
                                                								{
                                                									echo "<option value='DeckLink SDI (".$k.")'>DeckLink SDI Micro (".$k.")</option>";
                                                								}
                                                							}
                                                							else
                                                							{
                                                								echo "<option value='DeckLink SDI (".$k.")'>DeckLink SDI Micro (".$k.")</option>";
                                                							}
                                                						}
                                                					}
                                                					else
                                                					{
                                                						if($inps['inp_source'] == "DeckLink SDI Micro")
                                                						{
                                                							echo "<option selected='selected' value='DeckLink SDI Micro'>DeckLink SDI Micro</option>";
                                                							array_push($selectedArray,"DeckLink SDI Micro");
                                                						}
                                                						else
                                                						{
                                                							if(sizeof($selectedArray)>0)
                                                							{
                                                								if(in_array("DeckLink SDI Micro",$selectedArray))
                                                								{
                                                									echo "<option disabled='disabled' value='DeckLink SDI Micro'>DeckLink SDI Micro</option>";
                                                								}
                                                							}
                                                							else
                                                							{
                                                								echo "<option value='DeckLink SDI Micro'>DeckLink SDI Micro</option>";
                                                							}
                                                						}
                                                					}
                                                				}
                                                				break;
                                                				case "9":
                                                				$len = 0;
                                                				$len = 1 * $count;
                                                				for($i=1; $i<=$len; $i++)
                                                				{
                                                					if($i>1)
                                                					{
                                                						if($inps['inp_source'] == "DeckLink Mini Recorder 4K (".$i.")")
                                                						{
                                                							echo "<option selected='selected' value='DeckLink Mini Recorder 4K (".$i.")'>DeckLink Mini Recorder 4K (".$i.")</option>";
                                                							array_push($selectedArray,"DeckLink Mini Recorder 4K (".$i.")");
                                                						}
                                                						else
                                                						{
                                                							if(sizeof($selectedArray)>0)
                                                							{
                                                								if(in_array("DeckLink Mini Recorder 4K (".$i.")",$selectedArray))
                                                								{
                                                									echo "<option disabled='disabled' value='DeckLink Mini Recorder 4K (".$i.")'>DeckLink Mini Recorder 4K (".$i.")</option>";
                                                								}
                                                							}
                                                							else
                                                							{
                                                								echo "<option value='DeckLink Mini Recorder 4K (".$i.")'>DeckLink Mini Recorder 4K (".$i.")</option>";
                                                							}

                                                						}
                                                						if($inps['inp_source'] == "DeckLink Mini Recorder 4K - HDMI (".$i.")")
                                                						{
                                                							echo "<option selected='selected' value='DeckLink Recorder 4K - HDMI (".$i.")'>DeckLink Mini Recorder 4K - HDMI (".$i.")</option>";
                                                							array_push($selectedArray,"DeckLink Mini Recorder 4K - HDMI (".$i.")");
                                                						}
                                                						else
                                                						{
                                                							if(sizeof($selectedArray)>0)
                                                							{
                                                								if(in_array("DeckLink Mini Recorder 4K - HDMI (".$i.")",$selectedArray))
                                                								{
                                                									echo "<option disabled='disabled' value='DeckLink Recorder 4K - HDMI (".$i.")'>DeckLink Mini Recorder 4K - HDMI (".$i.")</option>";
                                                								}
                                                							}
                                                							else
                                                							{
                                                								echo "<option value='DeckLink Recorder 4K - HDMI (".$i.")'>DeckLink Mini Recorder 4K - HDMI (".$i.")</option>";
                                                							}

                                                						}

                                                					}
                                                					else
                                                					{
                                                						if($inps['inp_source'] == "DeckLink Mini Recorder 4K")
                                                						{
                                                							echo "<option selected='selected' value='DeckLink Mini Recorder 4K'>DeckLink Mini Recorder 4K</option>";
                                                							array_push($selectedArray,"DeckLink Mini Recorder 4K");
                                                						}
                                                						else
                                                						{
                                                							if(sizeof($selectedArray)>0)
                                                							{
                                                								if(in_array("DeckLink Mini Recorder 4K",$selectedArray))
                                                								{
                                                									echo "<option disabled='disabled' value='DeckLink Mini Recorder 4K'>DeckLink Mini Recorder 4K</option>";
                                                								}
                                                							}
                                                							else
                                                							{
                                                								echo "<option value='DeckLink Mini Recorder 4K'>DeckLink Mini Recorder 4K</option>";
                                                							}

                                                						}
                                                						if($inps['inp_source'] == "DeckLink Mini Recorder 4K - HDMI")
                                                						{
                                                							echo "<option selected='selected' value='DeckLink Mini Recorder 4K - HDMI'>DeckLink Mini Recorder 4K - HDMI</option>";
                                                							array_push($selectedArray,"DeckLink Mini Recorder 4K - HDMI");
                                                						}
                                                						else
                                                						{
                                                							if(sizeof($selectedArray)>0)
                                                							{
                                                								if(in_array("DeckLink Mini Recorder 4K - HDMI",$selectedArray))
                                                								{
                                                									echo "<option disabled='disabled' value='DeckLink Mini Recorder 4K - HDMI'>DeckLink Mini Recorder 4K - HDMI</option>";
                                                								}
                                                							}
                                                							else
                                                							{
                                                								echo "<option value='DeckLink Mini Recorder 4K - HDMI'>DeckLink Mini Recorder 4K - HDMI</option>";
                                                							}

                                                						}

                                                					}

                                                				}
                                                				break;
                                                			}
                                                		}
                                                	}
                                                }

                                                ?>
                                          </select>
                                       </td>
                                       <td>
                                          <select name='audiosources[]' class='form-control'>
                                             <option value=''>-- none --</option>
                                             <?php
                                                $incAudio = $this->common_model->getEncoderAudioInputs();

                                                if(sizeof($incAudio)>0)
                                                {
                                                	foreach($incAudio as $aud)
                                                	{
                                                		if($aud['value'] == $inps['inp_aud_source'])
                                                		{
                                                			?>
                                             <option selected='selected' value='<?php echo $aud['value'];?>'><?php echo $aud['item'];?></option>
                                             <?php
                                                }
                                                else
                                                {
                                                	?>
                                             <option value='<?php echo $aud['value'];?>'><?php echo $aud['item'];?></option>
                                             <?php
                                                }
                                                }
                                                }
                                                ?>
                                          </select>
                                       </td>
                                       <td>-</td>
                                       <td><a href='javascript:void(0);' class='deleteEncInputs'><i class='fa fa-trash'></i></a></td>
                                    </tr>
                                    <?php
                                       }
                                       }
                                       else
                                       {
                                       ?>
                                    <tr class="emptyrow">
                                       <td colspan="5">No Inputs Created Yet!</td>
                                    </tr>
                                    <?php
                                       }
                                                               				?>
                                 </tbody>
                              </table>
                              </div>
                           </div>
                        </div>
                        <div role="tabpanel" class="tab-pane pd-13 fade" id="outputs">
                           <div class="col-lg-12 col-md-12">
                              <div class="box-header">
                                 <a class="add-btn btn btn-primary" id="add_encoder_outputs" href="javascript:void(0);">
                                 <span><i class="fa fa-plus"></i> Output</span>
                                 </a>
                              </div>
                              <br/>
                              <div class="table-responsive no-padding">
                              <table class="cstmtable table table-hover check-input hardware_output_table">
                                 <thead>
                                    <th>Label</th>
                                    <th>Video Destination</th>
                                    <th>Output Format</th>
                                    <th>Status</th>
                                    <th>Delete</th>
                                 </thead>
                                 <tbody>
                                    <?php
                                       $Outputs = $this->common_model->getEncoderOutbyEncid($encoder[0]['id']);
                                       $selectedoutputArray = array();
                                       if(sizeof($Outputs)>0)
                                       {
                                       	foreach($Outputs as $out)
                                       	{
                                       ?>
                                    <tr>
                                       <td><input type='text' class='form-control'  name='outputs[]' value='<?php echo $out['out_name'];?>'/></td>
                                       <td class='sourcestd'>
                                          <select name='videooutputsources[]' class='form-control  videosources'>
                                             <option value=''>-- none --</option>
                                             <?php
                                                if(sizeof($modelsararyyy)>0)
                                                																	{
                                                																		foreach($modelsararyyy as $key=>$modelsel)
                                                																		{
                                                																			if($key != '9')
                                                																			{
                                                																				$count = $modelsel;
                                                																				switch($key)
                                                																				{
                                                																					case "1":
                                                																					$len = 0;
                                                																					$len = (4) * ($count);
                                                																					for($i=1; $i<=$len; $i++)
                                                																					{
                                                																						if($out['out_destination'] == "DeckLink Duo (".$i.")")
                                                																						{
                                                																							echo "<option selected='selected' value='DeckLink Duo (".$i.")'>DeckLink Duo (".$i.")</option>";
                                                																							array_push($selectedoutputArray,"DeckLink Duo (".$i.")");
                                                																						}
                                                																						else
                                                																						{
                                                																							if(sizeof($selectedoutputArray)>0)
                                                																							{
                                                																								if(in_array("DeckLink Duo (".$i.")",$selectedoutputArray))
                                                																								{
                                                																									echo "<option disabled='disabled' value='DeckLink Duo (".$i.")'>DeckLink Duo (".$i.")</option>";
                                                																								}
                                                																								else
                                                																								{
                                                																									echo "<option value='DeckLink Duo (".$i.")'>DeckLink Duo (".$i.")</option>";
                                                																								}
                                                																							}
                                                																							else
                                                																							{
                                                																								echo "<option value='DeckLink Duo (".$i.")'>DeckLink Duo (".$i.")</option>";
                                                																							}
                                                																						}
                                                																					}
                                                																					break;
                                                																					case "6":
                                                																					$len = 0;
                                                																					$len = 4 * $count;
                                                																					for($j=1; $j<=$len; $j++)
                                                																					{
                                                																						if($out['out_destination'] == "DeckLink SDI (".$j.")")
                                                																						{
                                                																							echo "<option selected='selected' value='DeckLink SDI (".$j.")'>DeckLink SDI (".$j.")</option>";
                                                																							array_push($selectedoutputArray,"DeckLink SDI (".$j.")");
                                                																						}
                                                																						else
                                                																						{
                                                																							if(sizeof($selectedoutputArray)>0)
                                                																							{
                                                																								if(in_array("DeckLink SDI (".$j.")",$selectedoutputArray))
                                                																								{
                                                																									echo "<option disabled='disabled' value='DeckLink SDI (".$j.")'>DeckLink SDI (".$j.")</option>";
                                                																								}
                                                																								else
                                                																								{
                                                																								echo "<option value='DeckLink SDI (".$j.")'>DeckLink SDI (".$j.")</option>";
                                                																								}
                                                																							}
                                                																							else
                                                																							{
                                                																								echo "<option value='DeckLink SDI (".$j.")'>DeckLink SDI (".$j.")</option>";
                                                																							}
                                                																						}
                                                																					}
                                                																					break;
                                                																					case "8":
                                                																					$len = 0;
                                                																					$len = 1 * $count;
                                                																					for($k=1; $k<=$len; $k++)
                                                																					{
                                                																						if($k>1)
                                                																						{
                                                																							if($out['out_destination'] == "DeckLink SDI Micro (".$k.")")
                                                																							{

                                                																								echo "<option selected='selected' value='DeckLink SDI (".$k.")'>DeckLink SDI Micro (".$k.")</option>";
                                                																								array_push($selectedoutputArray,"DeckLink SDI Micro (".$k.")");

                                                																							}
                                                																							else
                                                																							{
                                                																								if(sizeof($selectedoutputArray)>0)
                                                																								{
                                                																									if(in_array("DeckLink SDI Micro (".$k.")",$selectedoutputArray))
                                                																									{
                                                																										echo "<option value='DeckLink SDI (".$k.")'>DeckLink SDI Micro (".$k.")</option>";
                                                																									}
                                                																								}
                                                																								else
                                                																								{
                                                																									echo "<option value='DeckLink SDI (".$k.")'>DeckLink SDI Micro (".$k.")</option>";
                                                																								}
                                                																							}
                                                																						}
                                                																						else
                                                																						{
                                                																							if($out['out_destination'] == "DeckLink SDI Micro")
                                                																							{
                                                																								echo "<option selected='selected' value='DeckLink SDI Micro'>DeckLink SDI Micro</option>";
                                                																								array_push($selectedoutputArray,"DeckLink SDI Micro");
                                                																							}
                                                																							else
                                                																							{
                                                																								if(sizeof($selectedoutputArray)>0)
                                                																								{
                                                																									if(in_array("DeckLink SDI Micro",$selectedoutputArray))
                                                																									{
                                                																										echo "<option disabled='disabled' value='DeckLink SDI Micro'>DeckLink SDI Micro</option>";
                                                																									}
                                                																								}
                                                																								else
                                                																								{
                                                																									echo "<option value='DeckLink SDI Micro'>DeckLink SDI Micro</option>";
                                                																								}
                                                																							}
                                                																						}
                                                																					}
                                                																					break;
                                                																					case "10":
                                                																					$len = 0;
                                                																					$len = 1 * $count;
                                                																					for($i=1; $i<=$len; $i++)
                                                																					{
                                                																						if($i>1)
                                                																						{
                                                																							if($out['out_destination'] == "DeckLink Mini Monitor 4K (".$i.")")
                                                																							{
                                                																								echo "<option selected='selected' value='DeckLink Mini Monitor 4K (".$i.")'>DeckLink Mini Monitor 4K (".$i.")</option>";
                                                																								array_push($selectedoutputArray,"DeckLink Mini Monitor 4K (".$i.")");
                                                																							}
                                                																							else
                                                																							{
                                                																								if(sizeof($selectedoutputArray)>0)
                                                																								{
                                                																									if(in_array("DeckLink Mini Monitor 4K (".$i.")",$selectedoutputArray))
                                                																									{
                                                																										echo "<option disabled='disabled' value='DeckLink Mini Monitor 4K (".$i.")'>DeckLink Mini Monitor 4K (".$i.")</option>";
                                                																									}
                                                																									else
                                                																									{
                                                																										echo "<option value='DeckLink Mini Monitor 4K (".$i.")'>DeckLink Mini Monitor 4K (".$i.")</option>";
                                                																									}
                                                																								}
                                                																								else
                                                																								{
                                                																									echo "<option value='DeckLink Mini Monitor 4K (".$i.")'>DeckLink Mini Monitor 4K (".$i.")</option>";
                                                																								}

                                                																							}

                                                																						}
                                                																						else
                                                																						{
                                                																							echo '<script type="text/javascript">encoderModelInputs.push("DeckLink Mini Monitor 4K");</script>';
                                                																							if($out['out_destination'] == "DeckLink Mini Monitor 4K")
                                                																							{
                                                																								echo "<option selected='selected' value='DeckLink Mini Monitor 4K'>DeckLink Mini Monitor 4K</option>";
                                                																								array_push($selectedoutputArray,"DeckLink Mini Monitor 4K");
                                                																							}
                                                																							else
                                                																							{
                                                																								if(sizeof($selectedoutputArray)>0)
                                                																								{
                                                																									if(in_array("DeckLink Mini Monitor 4K",$selectedoutputArray))
                                                																									{
                                                																										echo "<option disabled='disabled' value='DeckLink Mini Monitor 4K'>DeckLink Mini Monitor 4K</option>";
                                                																									}
                                                																									else
                                                																									{
                                                																										echo "<option value='DeckLink Mini Monitor 4K'>DeckLink Mini Monitor 4K</option>";
                                                																									}
                                                																								}
                                                																								else
                                                																								{
                                                																									echo "<option value='DeckLink Mini Monitor 4K'>DeckLink Mini Monitor 4K</option>";
                                                																																																				}

                                                																							}
                                                																						}

                                                																					}
                                                																					break;
                                                																				}
                                                																			}
                                                																		}
                                                																	}
                                                ?>
                                          </select>
                                       </td>
                                       <td>
                                          <select name='encoderOutputFormat[]' class='form-control '>
                                             <option value=''>-- none --</option>
                                             <?php
                                                if(sizeof($outputFormatArray)>0)
                                                {
                                                	foreach($outputFormatArray as $ouformat)
                                                	{
                                                		if($ouformat['id'] == $out['out_format'])
                                                		{
                                                			?>
                                             <option selected='selected' value='<?php echo $ouformat['id'];?>'><?php echo $ouformat['id'];?></option>
                                             <?php
                                                }
                                                else
                                                {
                                                	?>
                                             <option value='<?php echo $ouformat['id'];?>'><?php echo $ouformat['id'];?></option>
                                             <?php
                                                }
                                                }
                                                }
                                                ?>
                                          </select>
                                       </td>
                                       <td>-</td>
                                       <td><a href='javascript:void(0);' class='deleteEncOuptputs'><i class='fa fa-trash'></i></a></td>
                                    </tr>
                                    <?php
                                       }
                                       }
                                       else
                                       {
                                       ?>
                                    <tr class="emptyrow">
                                       <td colspan="5">No Outputs Created Yet!</td>
                                    </tr>
                                    <?php
                                       }
                                                               				?>
                                 </tbody>
                              </table>
								</div>
                           </div>
                        </div>
                        <div role="tabpanel" class="tab-pane pd-13 fade" id="recordings">
                           <div class="action-table">
                              <div class="enc-template-form" id="enc_template_form">
                                 <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                       <div class="form-group">
                                          <div class="check-input">
                                             <div class="boxes">
                                                <?php
                                                   if($encoder[0]['enable_recording_on_local_disk'] == 1)
                                                   {
                                                   ?>
                                                <input type="checkbox" id="enable_recording_on_local_disk" name="enable_recording_on_local_disk" checked="checked"/>
                                                <?php
                                                   }
                                                   else if($encoder[0]['enable_recording_on_local_disk'] == 0)
                                                                                    	{
                                                   	?>
                                                <input type="checkbox" id="enable_recording_on_local_disk" name="enable_recording_on_local_disk"/>
                                                <?php
                                                   }
                                                                                    	?>
                                                <label for="enable_recording_on_local_disk" style="padding-left:25px;">Enable Recording On The Local Disk</label>
                                             </div>
                                          </div>
                                          <br/>
                                          <?php
                                             if($encoder[0]['enable_recording_on_local_disk'] == 1)
                                             {
                                             	?>
                                          <div class="check-input ">
                                             <div class="boxes">
                                                <?php
                                                   if($encoder[0]['is_default_recording_preset'] == 1)
                                                   {
                                                   ?>
                                                <input type="checkbox" id="is_default_recording_preset" name="is_default_recording_preset" checked="checked"/>
                                                <?php
                                                   }
                                                   else if($encoder[0]['is_default_recording_preset'] == 0)
                                                                                    	{
                                                   	?>
                                                <input type="checkbox" id="is_default_recording_preset" name="is_default_recording_preset"/>
                                                <?php
                                                   }
                                                                                    	?>
                                                <label for="is_default_recording_preset" style="padding-left:25px;">Enable Default Recording Preset</label>
                                             </div>
                                          </div>
                                          <?php
                                             }
                                             else
                                             {

                                             ?>
                                          <div class="check-input isdefaultrecording_preset">
                                             <div class="boxes">
                                                <input type="checkbox" id="is_default_recording_preset" name="is_default_recording_preset"/>
                                                <label for="is_default_recording_preset" style="padding-left:25px;">Enable Default Recording Preset</label>
                                             </div>
                                          </div>
                                          <?php
                                             }

                                                                              	?>
                                          <br/>
                                          <?php
                                             if($encoder[0]['is_default_recording_preset'] == 1)
                                             {
                                             	?>
                                          <div class="check-input">
                                             <div class="boxes">
                                                <?php
                                                   if($encoder[0]['enableVideo'] == 1)
                                                   {
                                                   ?>
                                                <input type="checkbox" id="enableVideo" name="enableVideo" checked="checked"/>
                                                <?php
                                                   }
                                                   else if($encoder[0]['enableVideo'] == 0)
                                                                                    	{
                                                   	?>
                                                <input type="checkbox" id="enableVideo" name="enableVideo"/>
                                                <?php
                                                   }
                                                                                    	?>
                                                <label for="enableVideo" style="padding-left:25px;">VIDEO</label>
                                             </div>
                                          </div>
                                          <?php
                                             }
                                             else
                                             {
                                             ?>
                                          <div class="col-lg-4 col-md-12">
                                             <div class="form-group enbleVidDefault" style="display:none;">
                                                <div class="check-input enbleVid">
                                                   <div class="boxes">
                                                      <?php
                                                         if($encoder[0]['enableVideo'] == 1)
                                                         {
                                                         ?>
                                                      <input type="checkbox" id="enableVideo" name="enableVideo" checked="checked"/>
                                                      <?php
                                                         }
                                                         else if($encoder[0]['enableVideo'] == 0)
                                                                                          	{
                                                         	?>
                                                      <input type="checkbox" id="enableVideo" name="enableVideo"/>
                                                      <?php
                                                         }
                                                                                          	?>
                                                      <label for="enableVideo" style="padding-left:25px;">VIDEO</label>
                                                   </div>
                                                </div>
                                                <?php
                                                   }

                                                   ?>
                                                <div class="row">
                                                   <?php
                                                      if($encoder[0]['enableVideo'] == "1")
                                                       	{

                                                       	?>
                                                   <div class="col-md-6"  style="display:block;">
                                                      <span class="text-blue">Codec</span>
                                                      <select class="form-control selectpicker" name="video_codec" id="video_codec">
                                                         <option value="">-- Select --</option>
                                                         <?php
                                                            $codec = $this->common_model->getVideoCodec();
                                                            if(sizeof($codec)>0)
                                                            {
                                                            foreach($codec as $codac)
                                                            {
                                                            if($codac['value'] == $encoder[0]['video_codec'])
                                                            {
                                                            ?>
                                                         <option selected="selected" value="<?php echo $codac['value'];?>"><?php echo $codac['item'];?></option>
                                                         <?php
                                                            }
                                                            else
                                                            {
                                                            ?>
                                                         <option value="<?php echo $codac['value'];?>"><?php echo $codac['item'];?></option>
                                                         <?php
                                                            }
                                                            }
                                                            }
                                                                                            	   ?>
                                                      </select>
                                                   </div>
                                                   <div class="col-md-6"  style="display:block;">
                                                      <span class="text-blue">Resolution</span>
                                                      <select class="form-control selectpicker" name="video_resolution" id="video_resolution">
                                                         <option value="">-- Select --</option>
                                                         <?php
                                                            $resolution = $this->common_model->getResolution();
                                                            if(sizeof($resolution)>0)
                                                            {
                                                            foreach($resolution as $reso)
                                                            {
                                                            if($encoder[0]['video_resolution'] == $reso['value'])
                                                            {
                                                            echo '<option selected="selected" value="'.$reso['value'].'">'.$reso['name'].'</option>';
                                                            }
                                                            else
                                                            {
                                                            echo '<option value="'.$reso['value'].'">'.$reso['name'].'</option>';
                                                            }
                                                            }
                                                            }
                                                            ?>
                                                      </select>
                                                   </div>
                                                   <div class="col-md-6"  style="display:block;">
                                                      <br/>
                                                      <span class="text-blue">Bitrate (kbps)</span>
                                                      <input type="number" class="form-control" id="video_bitrate" name="video_bitrate" value="<?php echo $encoder[0]['video_bitrate'];?>">
                                                   </div>
                                                   <div class="col-md-6"  style="display:block;">
                                                      <br/>
                                                      <span class="text-blue">Framerate (fps)</span>
                                                      <input type="number" class="form-control" id="video_framerate" name="video_framerate" value="<?php echo $encoder[0]['video_framerate'];?>"/>
                                                   </div>
                                                   <div class="col-md-6"  style="display:block;">
                                                      <br/>
                                                      <span class="text-blue">Min. Bitrate (kbps)</span>
                                                      <input type="number" class="form-control" id="video_min_bitrate" name="video_min_bitrate" value="<?php echo $encoder[0]['video_min_bitrate'];?>">
                                                   </div>
                                                   <div class="col-md-6"  style="display:block;">
                                                      <br/>
                                                      <span class="text-blue">Max. Bitrate (kbps)</span>
                                                      <input type="number" class="form-control" id="video_max_bitrate" name="video_max_bitrate" value="<?php echo $encoder[0]['video_max_bitrate'];?>">
                                                   </div>
                                                   <?php
                                                      }
                                                      else
                                                      {
                                                      	?>
                                                   <div class="col-md-6 ht">
                                                      <span class="text-blue">Codec</span>
                                                      <select class="form-control selectpicker" name="video_codec" id="video_codec">
                                                         <option value="">-- Select --</option>
                                                         <?php
                                                            $codec = $this->common_model->getVideoCodec();
                                                            if(sizeof($codec)>0)
                                                            {
                                                            foreach($codec as $codac)
                                                            {
                                                            if($codac['value'] == $encoder[0]['video_codec'])
                                                            {
                                                            ?>
                                                         <option selected="selected" value="<?php echo $codac['value'];?>"><?php echo $codac['item'];?></option>
                                                         <?php
                                                            }
                                                            else
                                                            {
                                                            ?>
                                                         <option value="<?php echo $codac['value'];?>"><?php echo $codac['item'];?></option>
                                                         <?php
                                                            }
                                                            }
                                                            }
                                                                                            	   ?>
                                                      </select>
                                                   </div>
                                                   <div class="col-md-6 ht">
                                                      <span class="text-blue">Resolution</span>
                                                      <select class="form-control selectpicker" name="video_resolution" id="video_resolution">
                                                         <option value="">-- Select --</option>
                                                         <?php
                                                            $resolution = $this->common_model->getResolution();
                                                            if(sizeof($resolution)>0)
                                                            {
                                                            foreach($resolution as $reso)
                                                            {
                                                            echo '<option value="'.$reso['value'].'">'.$reso['name'].'</option>';
                                                            }
                                                            }
                                                            ?>
                                                      </select>
                                                   </div>
                                                   <div class="col-md-6 ht">
                                                      <span class="text-blue">Bitrate (kbps)</span>
                                                      <input type="number" class="form-control" id="video_bitrate" name="video_bitrate" value="1000ggg">
                                                   </div>
                                                   <div class="col-md-6 ht">
                                                      <span class="text-blue">Framerate (fps)</span>
                                                      <input type="number" class="form-control" id="video_framerate" name="video_framerate">
                                                   </div>
                                                   <div class="col-md-6 ht">
                                                      <span class="text-blue">Min. Bitrate (kbps)</span>
                                                      <input type="number" class="form-control" id="video_min_bitrate" name="video_min_bitrate">
                                                   </div>
                                                   <div class="col-md-6 ht">
                                                      <span class="text-blue">Max. Bitrate (kbps)</span>
                                                      <input type="number" class="form-control" id="video_max_bitrate" name="video_max_bitrate">
                                                   </div>
                                                   <?php
                                                      }
                                                                                    	?>
                                                </div>
                                             </div>
                                             <div class="form-group">
                                                <div class="check-input advance_vid_setting" style="display:none !important;">
                                                   <div class="boxes">
                                                      <?php
                                                         if($encoder[0]['advance_video_setting'] == 0)
                                                         {
                                                         ?>
                                                      <input type="checkbox" id="advance_video_setting" name="advance_video_setting"/>
                                                      <?php
                                                         }
                                                         elseif($encoder[0]['advance_video_setting'] == 1)
                                                                                          {
                                                         ?>
                                                      <input checked="true" type="checkbox" id="advance_video_setting" name="advance_video_setting"/>
                                                      <?php
                                                         }
                                                                                          ?>
                                                      <label for="advance_video_setting" style="padding-left:25px;">ADVANCED VIDEO ENCODING</label>
                                                   </div>
                                                </div>
                                                <?php
                                                   if($encoder[0]['advance_video_setting'] == 1)
                                                   {
                                                   	?>
                                                <div class="row" id="advance_video_ch">
                                                   <div class="col-md-6 ht">
                                                      <span class="text-blue">Preset</span>
                                                      <select class="form-control selectpicker" name="adv_video_min_bitrate" id="adv_video_min_bitrate">
                                                         <option value="">-- Select --</option>
                                                         <?php
                                                            $videoPreset = $this->common_model->getVideoPreset();
                                                            if(sizeof($videoPreset)>0)
                                                            {
                                                            foreach($videoPreset as $vp)
                                                            {
                                                            if($encoder[0]['adv_video_preset'] == $vp['value'])
                                                            {
                                                            echo '<option selected="selected" value="'.$vp['value'].'">'.$vp['name'].'</option>';
                                                            }
                                                            else
                                                            {
                                                            echo '<option value="'.$vp['value'].'">'.$vp['name'].'</option>';
                                                            }
                                                            }
                                                            }
                                                            ?>
                                                      </select>
                                                   </div>
                                                   <div class="col-md-6 ht">
                                                      <span class="text-blue">Profile</span>
                                                      <select class="form-control selectpicker" name="adv_video_max_bitrate" id="adv_video_max_bitrate">
                                                         <option value="">-- Select --</option>
                                                         <?php
                                                            $videoProfile = $this->common_model->getVideoProfile();
                                                            if(sizeof($videoProfile)>0)
                                                            {
                                                            foreach($videoProfile as $vpef)
                                                            {
                                                            if($encoder[0]['adv_video_profile'] == $vpef['value'])
                                                            {
                                                            echo '<option selected="selected" value="'.$vpef['value'].'">'.$vpef['name'].'</option>';
                                                            }
                                                            else
                                                            {
                                                            echo '<option value="'.$vpef['value'].'">'.$vpef['name'].'</option>';
                                                            }
                                                            }
                                                            }
                                                            ?>
                                                      </select>
                                                   </div>
                                                   <div class="col-md-6 ht">
                                                      <span class="text-blue">Buffer Size (kbps)</span>
                                                      <input type="number" class="form-control" id="adv_video_buffer_size" name="adv_video_buffer_size" value="<?php echo $encoder[0]['adv_video_buffer_size'];?>">
                                                   </div>
                                                   <div class="col-md-6 ht">
                                                      <span class="text-blue">GOP</span>
                                                      <input type="number" class="form-control" id="adv_video_gop" name="adv_video_gop" value="<?php echo $encoder[0]['adv_video_gop'];?>">
                                                   </div>
                                                   <div class="col-md-6 ht">
                                                      <span class="text-blue">Keyframe Interval</span>
                                                      <input type="number" class="form-control" id="adv_video_keyframe_intrval" name="adv_video_keyframe_intrval" value="<?php echo $encoder[0]['adv_video_keyframe_intrval'];?>">
                                                   </div>
                                                </div>
                                                <?php
                                                   }
                                                   else
                                                   {
                                                   ?>
                                                <div class="row dnone" id="advance_video_ch">
                                                   <div class="col-md-6 ht">
                                                      <span class="text-blue">Preset</span>
                                                      <select class="form-control selectpicker" name="adv_video_min_bitrate" id="adv_video_min_bitrate">
                                                         <option value="">-- Select --</option>
                                                         <?php
                                                            $videoPreset = $this->common_model->getVideoPreset();
                                                            if(sizeof($videoPreset)>0)
                                                            {
                                                            foreach($videoPreset as $vp)
                                                            {
                                                            if($encoder[0]['adv_video_preset'] == $vp['value'])
                                                            {
                                                            echo '<option selected="selected" value="'.$vp['value'].'">'.$vp['name'].'</option>';
                                                            }
                                                            else
                                                            {
                                                            echo '<option value="'.$vp['value'].'">'.$vp['name'].'</option>';
                                                            }
                                                            }
                                                            }
                                                            ?>
                                                      </select>
                                                   </div>
                                                   <div class="col-md-6 ht">
                                                      <span class="text-blue">Profile</span>
                                                      <select class="form-control selectpicker" name="adv_video_max_bitrate" id="adv_video_max_bitrate">
                                                         <option value="">-- Select --</option>
                                                         <?php
                                                            $videoProfile = $this->common_model->getVideoProfile();
                                                            if(sizeof($videoProfile)>0)
                                                            {
                                                            foreach($videoProfile as $vpef)
                                                            {
                                                            if($encoder[0]['adv_video_profile'] == $vpef['value'])
                                                            {
                                                            echo '<option selected="selected" value="'.$vpef['value'].'">'.$vpef['name'].'</option>';
                                                            }
                                                            else
                                                            {
                                                            echo '<option value="'.$vpef['value'].'">'.$vpef['name'].'</option>';
                                                            }
                                                            }
                                                            }
                                                            ?>
                                                      </select>
                                                   </div>
                                                   <div class="col-md-6 ht">
                                                      <span class="text-blue">Buffer Size (kbps)</span>
                                                      <input type="number" class="form-control" id="adv_video_buffer_size" name="adv_video_buffer_size" value="<?php echo $encoder[0]['adv_video_buffer_size'];?>">
                                                   </div>
                                                   <div class="col-md-6 ht">
                                                      <span class="text-blue">GOP</span>
                                                      <input type="number" class="form-control" id="adv_video_gop" name="adv_video_gop" value="<?php echo $encoder[0]['adv_video_gop'];?>">
                                                   </div>
                                                   <div class="col-md-6 ht">
                                                      <span class="text-blue">Keyframe Interval</span>
                                                      <input type="number" class="form-control" id="adv_video_keyframe_intrval" name="adv_video_keyframe_intrval" value="<?php echo $encoder[0]['adv_video_keyframe_intrval'];?>">
                                                   </div>
                                                </div>
                                                <?php
                                                   }
                                                                                 ?>
                                             </div>
                                             <div class="check-input deinterlanc" style="display: none;">
                                                <div class="boxes">
                                                   <?php
                                                      if($encoder[0]['enabledeinterlance'] == 0)
                                                      {
                                                      ?>
                                                   <input  type="checkbox" id="enabledeinterlance" name="enabledeinterlance">
                                                   <?php
                                                      }
                                                      elseif($encoder[0]['enabledeinterlance'] == 1)
                                                                                       {
                                                      ?>
                                                   <input checked="true" type="checkbox" id="enabledeinterlance" name="enabledeinterlance">
                                                   <?php
                                                      }
                                                                                       ?>
                                                   <label for="enabledeinterlance" style="padding-left:25px;">Enable Deinterlace</label>
                                                </div>
                                             </div>
                                             <br/>
                                             <div class="check-input latency" style="display: none;">
                                                <div class="boxes">
                                                   <?php
                                                      if($encoder[0]['enablezerolatency'] == 0)
                                                      {
                                                      ?>
                                                   <input  type="checkbox" id="enablezerolatency" name="enablezerolatency">
                                                   <?php
                                                      }
                                                      elseif($encoder[0]['enablezerolatency'] == 1)
                                                                                       {
                                                      ?>
                                                   <input checked="true" type="checkbox" id="enablezerolatency" name="enablezerolatency">
                                                   <?php
                                                      }
                                                                                       ?>
                                                   <label for="enablezerolatency" style="padding-left:25px;">Enable Zero Latency</label>
                                                </div>
                                             </div>
                                          </div>
                                          <?php
                                             if($encoder[0]['enable_recording_on_local_disk'] == 1)
                                             {
                                             	?>
                                          <div class="col-lg-4 col-md-12 enableAudioEnc" style="display:none;">
                                             <div class="form-group">
                                                <div class="check-input">
                                                   <div class="boxes">
                                                      <?php
                                                         if($encoder[0]['audio_check'] == 0)
                                                         {
                                                         ?>
                                                      <input type="checkbox" id="audio_check" name="audio_check">
                                                      <?php
                                                         }
                                                         elseif($encoder[0]['audio_check'] == 1)
                                                                                          {
                                                         ?>
                                                      <input checked="true" type="checkbox" id="audio_check" name="audio_check">
                                                      <?php
                                                         }
                                                                                          ?>
                                                      <label for="audio_check" style="padding-left:25px;">AUDIO</label>
                                                   </div>
                                                </div>
                                                <div class="row">
                                                   <div class="col-md-6 ht">
                                                      <span class="text-blue">Codec</span>
                                                      <select class="form-control selectpicker" name="audio_codec" id="audio_codec">
                                                         <option value="0">-- Select --</option>
                                                         <?php
                                                            if($encoder[0]['audio_codec'] != "" && $encoder[0]['audio_codec'] == "aac")
                                                            {
                                                            ?>
                                                         <option selected="selected" value="aac">AAC</option>
                                                         <option value="libopus">Libopus</option>
                                                         <?php
                                                            }
                                                            elseif($encoder[0]['audio_codec'] != "" && $encoder[0]['audio_codec'] == "libopus")
                                                                                                {
                                                            	?>
                                                         <option  value="aac">AAC</option>
                                                         <option selected="selected" value="libopus">Libopus</option>
                                                         <?php
                                                            }
                                                            else
                                                            {
                                                            	?>
                                                         <option value="aac">AAC</option>
                                                         <option value="libopus">Libopus</option>
                                                         <?php
                                                            }
                                                                                                ?>
                                                      </select>
                                                   </div>
                                                   <div class="col-md-6 ht">
                                                      <span class="text-blue">Channels</span>
                                                      <select class="form-control selectpicker" name="audio_channel" id="audio_channel">
                                                         <option value="">--Select--</option>
                                                         <?php
                                                            if($encoder[0]['audio_channel'] ==1)
                                                            {
                                                            ?>
                                                         <option selected="selected" value="1">Mono</option>
                                                         <option value="2">Stereo</option>
                                                         <?php
                                                            }
                                                            elseif($encoder[0]['audio_channel'] == 2)
                                                                                             {
                                                            ?>
                                                         <option value="1">Mono</option>
                                                         <option selected="selected" value="2">Stereo</option>
                                                         <?php
                                                            }
                                                            else
                                                            {
                                                            	?>
                                                         <option value="1">Mono</option>
                                                         <option value="2">Stereo</option>
                                                         <?php
                                                            }
                                                                                             ?>
                                                      </select>
                                                   </div>
                                                   <div class="col-md-6 ht">
                                                      <span class="text-blue">Bitrate (kbps)</span>
                                                      <select class="form-control selectpicker" name="audio_bitrate" id="audio_bitrate">
                                                         <option value="">--Select--</option>
                                                         <?php
                                                            $AudioBitrate = $this->common_model->getAudioBitrate();
                                                            if(sizeof($AudioBitrate)>0)
                                                            {
                                                            foreach($AudioBitrate as $abr)
                                                            {
                                                            if($encoder[0]['audio_bitrate'] == $abr['value'])
                                                            {
                                                            echo '<option selected="selected" value="'.$abr['value'].'">'.$abr['name'].'</option>';
                                                            }
                                                            else
                                                            {
                                                            echo '<option value="'.$abr['value'].'">'.$abr['name'].'</option>';
                                                            }
                                                            }
                                                            }
                                                            ?>
                                                      </select>
                                                   </div>
                                                   <div class="col-md-6 ht">
                                                      <span class="text-blue">Sample Rate</span>
                                                      <select class="form-control selectpicker" name="audio_sample_rate" id="audio_sample_rate">
                                                         <option value="">--Select--</option>
                                                         <?php
                                                            $AudioSamplerate = $this->common_model->getAudioSampleRate();
                                                            if(sizeof($AudioSamplerate)>0)
                                                            {
                                                            foreach($AudioSamplerate as $asr)
                                                            {
                                                            if($encoder[0]['audio_sample_rate'] == $asr['value'])
                                                            {
                                                            echo '<option selected="selected" value="'.$asr['value'].'">'.$asr['name'].'</option>';
                                                            }
                                                            else
                                                            {
                                                            echo '<option value="'.$asr['value'].'">'.$asr['name'].'</option>';
                                                            }
                                                            }
                                                            }
                                                            ?>
                                                      </select>
                                                   </div>
                                                </div>
                                             </div>
                                             <div class="form-group">
                                                <div class="check-input enableAdvanceAudio">
                                                   <div class="boxes">
                                                      <?php
                                                         if($encoder[0]['enableAdvanceAudio'] ==0)
                                                         {
                                                         ?>
                                                      <input type="checkbox" id="enableAdvanceAudio" name="enableAdvanceAudio">
                                                      <?php
                                                         }
                                                         elseif($encoder[0]['enableAdvanceAudio'] == 1)
                                                                                          {
                                                         ?>
                                                      <input checked="true" type="checkbox" id="enableAdvanceAudio" name="enableAdvanceAudio">
                                                      <?php
                                                         }
                                                                                          ?>
                                                      <label for="enableAdvanceAudio" style="padding-left:25px;">ADVANCED AUDIO ENCODING</label>
                                                   </div>
                                                </div>
                                                <?php
                                                   if($encoder[0]['enableAdvanceAudio'] ==0)
                                                   {
                                                   ?>
                                                <div class="row adv_audio dnone" >
                                                   <div class="col-md-9 ht">
                                                      <span class="text-blue">Audio Gain</span>
                                                      <input type="text" id="rangeslider" name="rangeslider" value="<?php echo $encoder[0]['audio_gain'];?>"/>
                                                      <datalist id="audio_gain" name="audio_gain">
                                                         <option value="-20db" label="-20db">
                                                         <option value="-15db">
                                                         <option value="-10db">
                                                         <option value="-5db">
                                                         <option value="0db" label="0">
                                                         <option value="5db">
                                                         <option value="10db">
                                                         <option value="15db">
                                                         <option value="20db" label="+20db">
                                                      </datalist>
                                                   </div>
                                                   <div class="col-md-6 ht">
                                                   <br/>
                                                   <span class="text-blue">Delay (ms)</span>
                                                   <input type="number" id="delay" name="delay" class="form-control" value="<?php echo $encoder[0]['delay'];?>">
                                                   </div>
                                                </div>
                                                <?php
                                                   }
                                                   elseif($encoder[0]['enableAdvanceAudio'] == 1)
                                                                                    {
                                                   ?>
                                                <div class="row adv_audio">
                                                <div class="col-md-9 ht">
                                                <span class="text-blue">Audio Gain</span>
                                                <input type="text" id="rangeslider" name="rangeslider" value="<?php echo $encoder[0]['audio_gain'];?>"/>
                                                <datalist id="audio_gain" name="audio_gain">
                                                <option value="-20db" label="-20db">
                                                <option value="-15db">
                                                <option value="-10db">
                                                <option value="-5db">
                                                <option value="0db" label="0">
                                                <option value="5db">
                                                <option value="10db">
                                                <option value="15db">
                                                <option value="20db" label="+20db">
                                                </datalist>
                                                </div>
                                                <div class="col-md-6 ht">
                                                <br/>
                                                <span class="text-blue">Delay (ms)</span>
                                                <input type="number" id="delay" name="delay" class="form-control" value="<?php echo $encoder[0]['delay'];?>">
                                                </div>
                                                </div>
                                                <?php
                                                   }
                                                                                    ?>
                                             </div>
                                          </div>
                                          <?php
                                             }
                                             else
                                             {
                                             ?>
                                          <div class="col-lg-4 col-md-12 enableAudioEnc">
                                          <div class="form-group">
                                          <div class="check-input">
                                          <div class="boxes">
                                          <?php
                                             if($encoder[0]['audio_check'] == 0)
                                             {
                                             ?>
                                          <input type="checkbox" id="audio_check" name="audio_check">
                                          <?php
                                             }
                                             elseif($encoder[0]['audio_check'] == 1)
                                                                              {
                                             ?>
                                          <input checked="true" type="checkbox" id="audio_check" name="audio_check">
                                          <?php
                                             }
                                                                              ?>
                                          <label for="audio_check" style="padding-left:25px;">AUDIO</label>
                                          </div>
                                          </div>
                                          <div class="row">
                                          <div class="col-md-6 ht">
                                          <span class="text-blue">Codec</span>
                                          <select class="form-control selectpicker" name="audio_codec" id="audio_codec">
                                          <option value="0">-- Select --</option>
                                          <?php
                                             if($encoder[0]['audio_codec'] != "" && $encoder[0]['audio_codec'] == "aac")
                                             {
                                             ?>
                                          <option selected="selected" value="aac">AAC</option>
                                          <option value="libopus">Libopus</option>
                                          <?php
                                             }
                                             elseif($encoder[0]['audio_codec'] != "" && $encoder[0]['audio_codec'] == "libopus")
                                                                                 {
                                             	?>
                                          <option  value="aac">AAC</option>
                                          <option selected="selected" value="libopus">Libopus</option>
                                          <?php
                                             }
                                             else
                                             {
                                             	?>
                                          <option value="aac">AAC</option>
                                          <option value="libopus">Libopus</option>
                                          <?php
                                             }
                                                                                 ?>
                                          </select>
                                          </div>
                                          <div class="col-md-6 ht">
                                          <span class="text-blue">Channels</span>
                                          <select class="form-control selectpicker" name="audio_channel" id="audio_channel">
                                          <option value="">--Select--</option>
                                          <?php
                                             if($encoder[0]['audio_channel'] ==1)
                                             {
                                             ?>
                                          <option selected="selected" value="1">Mono</option>
                                          <option value="2">Stereo</option>
                                          <?php
                                             }
                                             elseif($encoder[0]['audio_channel'] == 2)
                                                                              {
                                             ?>
                                          <option value="1">Mono</option>
                                          <option selected="selected" value="2">Stereo</option>
                                          <?php
                                             }
                                             else
                                             {
                                             	?>
                                          <option value="1">Mono</option>
                                          <option value="2">Stereo</option>
                                          <?php
                                             }
                                                                              ?>
                                          </select>
                                          </div>
                                          <div class="col-md-6 ht">
                                          <span class="text-blue">Bitrate (kbps)</span>
                                          <select class="form-control selectpicker" name="audio_bitrate" id="audio_bitrate">
                                          <option value="">--Select--</option>
                                          <?php
                                             $AudioBitrate = $this->common_model->getAudioBitrate();
                                             if(sizeof($AudioBitrate)>0)
                                             {
                                             foreach($AudioBitrate as $abr)
                                             {
                                             if($encoder[0]['audio_bitrate'] == $abr['value'])
                                             {
                                             echo '<option selected="selected" value="'.$abr['value'].'">'.$abr['name'].'</option>';
                                             }
                                             else
                                             {
                                             echo '<option value="'.$abr['value'].'">'.$abr['name'].'</option>';
                                             }
                                             }
                                             }
                                             ?>
                                          </select>
                                          </div>
                                          <div class="col-md-6 ht">
                                          <span class="text-blue">Sample Rate</span>
                                          <select class="form-control selectpicker" name="audio_sample_rate" id="audio_sample_rate">
                                          <option value="">--Select--</option>
                                          <?php
                                             $AudioSamplerate = $this->common_model->getAudioSampleRate();
                                             if(sizeof($AudioSamplerate)>0)
                                             {
                                             foreach($AudioSamplerate as $asr)
                                             {
                                             if($encoder[0]['audio_sample_rate'] == $asr['value'])
                                             {
                                             echo '<option selected="selected" value="'.$asr['value'].'">'.$asr['name'].'</option>';
                                             }
                                             else
                                             {
                                             echo '<option value="'.$asr['value'].'">'.$asr['name'].'</option>';
                                             }
                                             }
                                             }
                                             ?>
                                          </select>
                                          </div>
                                          </div>
                                          </div>
                                          <div class="form-group">
                                          <div class="check-input enableAdvanceAudio">
                                          <div class="boxes">
                                          <?php
                                             if($encoder[0]['enableAdvanceAudio'] ==0)
                                             {
                                             ?>
                                          <input type="checkbox" id="enableAdvanceAudio" name="enableAdvanceAudio">
                                          <?php
                                             }
                                             elseif($encoder[0]['enableAdvanceAudio'] == 1)
                                                                              {
                                             ?>
                                          <input checked="true" type="checkbox" id="enableAdvanceAudio" name="enableAdvanceAudio">
                                          <?php
                                             }
                                                                              ?>
                                          <label for="enableAdvanceAudio" style="padding-left:25px;">ADVANCED AUDIO ENCODING</label>
                                          </div>
                                          </div>
                                          <?php
                                             if($encoder[0]['enableAdvanceAudio'] ==0)
                                             {
                                             ?>
                                          <div class="row adv_audio dnone" >
                                          <div class="col-md-9 ht">
                                          <span class="text-blue">Audio Gain</span>
                                          <input type="text" id="rangeslider" name="rangeslider" value="<?php echo $encoder[0]['audio_gain'];?>"/>
                                          <datalist id="audio_gain" name="audio_gain">
                                          <option value="-20db" label="-20db">
                                          <option value="-15db">
                                          <option value="-10db">
                                          <option value="-5db">
                                          <option value="0db" label="0">
                                          <option value="5db">
                                          <option value="10db">
                                          <option value="15db">
                                          <option value="20db" label="+20db">
                                          </datalist>
                                          </div>
                                          <div class="col-md-6 ht">
                                          <br/>
                                          <span class="text-blue">Delay (ms)</span>
                                          <input type="number" id="delay" name="delay" class="form-control" value="<?php echo $encoder[0]['delay'];?>">
                                          </div>
                                          </div>
                                          <?php
                                             }
                                             elseif($encoder[0]['enableAdvanceAudio'] == 1)
                                                                              {
                                             ?>
                                          <div class="row adv_audio">
                                          <div class="col-md-9 ht">
                                          <span class="text-blue">Audio Gain</span>
                                          <input type="text" id="rangeslider" name="rangeslider" value="<?php echo $encoder[0]['audio_gain'];?>"/>
                                          <datalist id="audio_gain" name="audio_gain">
                                          <option value="-20db" label="-20db">
                                          <option value="-15db">
                                          <option value="-10db">
                                          <option value="-5db">
                                          <option value="0db" label="0">
                                          <option value="5db">
                                          <option value="10db">
                                          <option value="15db">
                                          <option value="20db" label="+20db">
                                          </datalist>
                                          </div>
                                          <div class="col-md-6 ht">
                                          <br/>
                                          <span class="text-blue">Delay (ms)</span>
                                          <input type="number" id="delay" name="delay" class="form-control" value="<?php echo $encoder[0]['delay'];?>">
                                          </div>
                                          </div>
                                          <?php
                                             }
                                                                              ?>
                                          </div>
                                          </div>
                                          <?php
                                             }
                                                                        ?>
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
                  <div class="card-footer">
          	        <button class="btn btn-sm btn-primary" type="submit">Update</button>
          	          <button class="btn btn-sm btn-danger" type="reset">Reset</button>
          	          </div>
             </form>
         </div>
      </div>
   </div>
</main>
