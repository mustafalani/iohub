<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<main class="main">
   <!-- Breadcrumb-->
   <ol class="breadcrumb">
      <li class="breadcrumb-item">
         <a href="<?php echo site_url();?>">Home</a>
      </li>
      <li class="breadcrumb-item active"><a href="<?php echo site_url();?>configuration">Settings</a></li>
      <li class="breadcrumb-item active"><?php echo $wovzData[0]['wse_instance_name'];?></li>
   </ol>
   <div class="container-fluid">
      <div class="animated fadeIn">
         <div class="card">
           <form id="wowza-form" class="form-only form-one" method="post" action="<?php echo site_url();?>admin/updateConfiguration" enctype="multipart/form-data">
           <div class="card-header">Edit Publisher</div>
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
                  <div class="col-lg-12 col-12-12">
                     <div class="content-box config-contentonly" style="margin-bottom:0;">
                        <div class="wowza-form" id="wowza_form">
                         
                              <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                              <div class="wowza-form col-lg-12 conf" id="wowza_form " style="height: 50px;">
                                 <div class="sav-btn-dv wowza-save">
                                   <!-- <button type="submit" class="btn btn-primary save float-right">
                                    <span>Update</span>
                                    </button>
                                    <br>-->
                                 </div>
                              </div>
                              <input type="hidden" name = "appid" value = "<?php echo $wovzData[0]['id'];?>"/>
                              <div class="row action-table">
                                 <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                       <label>Publisher Name <span class="mndtry">*</span></label>
                                       <input type="text" class="form-control" name="wse_instance_name" value = "<?php echo $wovzData[0]['wse_instance_name'];?>"id="wse_instance_name" required="true"/>
                                    </div>
                                    <div class="form-group">
                                       <div class="row">
                                          <div class="col-md-4 xxl-only xtramargin margin-bot">
                                             <label>IP Address <span class="mndtry">*</span></label>
                                             <input type="text" class="form-control" name="ip_address" value="<?php echo $wovzData[0]['ip_address'];?>" id="ip_address"  required="true">
                                          </div>
                                          <div class="col-md-4 xxl-only xtramargin margin-bot pl-0">
                                             <label>Stream Name <span class="mndtry">*</span></label>
                                             <input type="text" class="form-control" value="<?php echo $wovzData[0]['stream_name'];?>" name="stream_name" id="stream_name" required="true">
                                          </div>
                                          <div class="col-md-4 xxl-only margin-bot">
                                             <label>RTMP Port <span class="mndtry">*</span></label>
                                             <input type="text" class="form-control" value="<?php echo $wovzData[0]['rtmp_port'];?>" name="rtmp_port" id="	rtmp_port" required="true">
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label>License Keys (Leave Blank for Unmanaged)</label>
                                       <input type="text" class="form-control" value="<?php echo $wovzData[0]['licence_key'];?>" name="licence_key" id="licence_key">
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                       <label>Installation Directory (Blank for Default)<span class="mndtry"></span></label>
                                       <input type="text" class="form-control" value="<?php echo $wovzData[0]['installation_directory'];?> " name="installation_directory" id="installation_directory"/>
                                    </div>
                                    <div class="form-group">
                                       <label>VOD Directory (Blank for Default) <span class="mndtry"></span></label>
                                       <input type="text" class="form-control" value="<?php echo $wovzData[0]['vod_directory'];?>" name="vod_directory" id="vod_directory">
                                    </div>
                                    <div class="form-group">
                                       <label>Connection Limit (Zero for Unlimited)</label>
                                       <input type="text" class="form-control" value="<?php echo $wovzData[0]['connection_limit'];?>" name="connection_limit" id="connection_limit">
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-12">
                                    <div class="form-group">
                                       <label>WSE Administrator User Name <span class="mndtry">*</span></label>
                                       <input type="text" class="form-control" value="<?php echo $wovzData[0]['rtmp_port'];?>" placeholder="Admin"  name="wse_administrator_username" id="wse_administrator_username" required="true">
                                    </div>
                                    <div class="form-group">
                                       <label>WSE Administrator Password</label>
                                       <input type="password" class="form-control" name="wse_administrator_pssword" value="<?php echo $wovzData[0]['rtmp_port'];?>" id="wse_administrator_pssword" required="true"/>
                                    </div>
                                    <div class="form-group">
                                       <div class="row">
                                          <div class="col-md-4 xxl-only xtramargin">
                                             <label>WSE CP Port <span class="mndtry">*</span></label>
                                             <input type="text" placeholder="8088" value="<?php echo $wovzData[0]['wse_cp_port'];?>" class="form-control" name="wse_cp_port" id="wse_cp_port"  required="true"/>
                                          </div>
                                          <div class="col-md-4 xxl-only xtramargin  pl-0">
                                             <label>Java API Port <span class="mndtry">*</span></label>
                                             <input type="text" placeholder="8182" value="<?php echo $wovzData[0]['java_api_port'];?>" class="form-control" name="java_api_port" id="java_api_port" required="true"/>
                                          </div>
                                          <div class="col-md-4 xxl-only  pl-0">
                                             <label>REST API Port <span class="mndtry">*</span></label>
                                             <input type="text" class="form-control" placeholder="8087" name="rest_api_port" id="rest_api_port" required="true" value="<?php echo $wovzData[0]['rest_api_port'];?>"/>
                                          </div>
                                       </div>
                                    </div>
                                    <?php
                                       if($userdata['user_type'] == 1)
                                       {
                                       	?>
                                    <div class="form-group">
                                       <div class="row">
                                          <div class="col-md-8">
                                             <label>Assigned to</label>
                                             <select class="form-control selectpicker" name="group_id" id="group_id">
                                                <option value="0">-- Select --</option>
                                                <?php
                                                   if(sizeof($groups)>0)
                                                   {
                                                   foreach($groups as $group)
                                                   {
                                                   if($wovzData[0]['group_id'] == $group['id'])
                                                   {
                                                   echo '<option selected="selected" value="'.$group['id'].'">'.$group['group_name'].'</option>';
                                                   }
                                                   else
                                                   {
                                                   echo '<option value="'.$group['id'].'">'.$group['group_name'].'</option>';
                                                   }
                                                   }
                                                   }
                                                   ?>
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                    <?php
                                       }
                                       else
                                       {
                                       ?>
                                    <div class="form-group dnone">
                                       <div class="row">
                                          <div class="col-md-8">
                                             <label>Assigned to</label>
                                             <select class="form-control selectpicker" name="group_id" id="group_id">
                                                <option value="0">-- Select --</option>
                                                <?php
                                                   if(sizeof($groups)>0)
                                                   {
                                                   foreach($groups as $group)
                                                   {
                                                   if($wovzData[0]['group_id'] == $group['id'])
                                                   {
                                                   echo '<option selected="selected" value="'.$group['id'].'">'.$group['group_name'].'</option>';
                                                   }
                                                   else
                                                   {
                                                   echo '<option value="'.$group['id'].'">'.$group['group_name'].'</option>';
                                                   }
                                                   }
                                                   }
                                                   ?>
                                             </select>
                                          </div>
                                       </div>
                                    </div>
                                    <?php
                                       }
                                                                                 ?>
                                    <div class="form-group">
                                       <div class="row">
                                          <div class="col-md-8">
                                             <div class="check-input">
                                                <div class="boxes">
                                                   <?php
                                                      if($wovzData[0]['enablenetdata'] == 1)
                                                      {
                                                      ?>
                                                   <input checked="true" type="checkbox" id="enablenetdata" name="enablenetdata">
                                                   <?php
                                                      }
                                                      else
                                                      {
                                                        ?>
                                                   <input type="checkbox" id="enablenetdata" name="enablenetdata">
                                                   <?php
                                                      }
                                                                                          ?>
                                                   <label for="enablenetdata" style="padding-left:25px;">Enable Netdata Monitoring</label>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>

                              </div>
                              <div class="col-lg-12 col-md-12 text-center" style="color:#303030;">
                                    <br/>
                                    <div style="width: 100%; max-height: calc(100% - 15px); text-align: center; display: inline-block;">
                                       <div style="width: 100%; height:100%; align: center; display: inline-block;">
                                          <?php $host = "http://".$wovzData[0]['ip_address'].":19999";
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
                                             data-common-max"avail"
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
                        <!-- wowza edit -->
                        <!-- wowza edit end -->
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
