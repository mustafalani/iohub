<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<style type="text/css">
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
</style>
<main class="main">
  	   <!-- Breadcrumb-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php echo site_url();?>">Home</a>
        </li>
        <li class="breadcrumb-item active"><a href="<?php echo site_url();?>configuration">Settings</a></li>
        <li class="breadcrumb-item active"><?php echo $gateway[0]['encoder_name'];?></li>
      </ol>
      <div class="container-fluid">
      	<div class="animated fadeIn">
           <div class="card">
           
           	<form id="wowza-form" class="action-table" method="post" action="<?php echo site_url();?>admin/updateGateway/<?php echo $gateway[0]['id'];?>" enctype="multipart/form-data">
           
						 <div class="card-header">Edit NDI Gateway</div>
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
					<div class="content-box config-contentonly">
					
      <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
      <input type="hidden" name="encoderId" id="encoderId" value="<?php echo $gateway[0]['id'];?>">


							   <!--  <button type="submit" class="btn-def save btn btn-primary float-right">
									<span>Update</span>
								</button>-->
                <br>
                	<div class="row">
                					<div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                            <label>Encoder Name <span class="mndtry">*</span></label>
                                                            <input type="text" name="encoder_name" id="encoder_name" class="form-control" value="<?php echo $gateway[0]['encoder_name'];?>" required="true">
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label>IP Address <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control" id="encoder_ip" name="encoder_ip" value="<?php echo $gateway[0]['encoder_ip'];?>"  required="true">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>SSH Port <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control" id="encoder_port" name="encoder_port" value="<?php echo $gateway[0]['encoder_port'];?>"  required="true">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <label>User Name <span class="mndtry">*</span></label>
                                                                    <input type="text" class="form-control" placeholder="Admin"  id="encoder_uname" name="encoder_uname" value="<?php echo $gateway[0]['encoder_uname'];?>"  required="true">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label>Password <span class="mndtry">*</span></label>
                                                                    <input type="password" class="form-control" id="encoder_pass" name="encoder_pass" value="<?php echo $gateway[0]['encoder_pass'];?>"  required="true">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

												<div class="col-lg-4 col-md-12">
                                                        <div class="form-group">
                                                            <div class="row">
                                                            	<?php
                                                                    	if($userdata['user_type']==1)
                                                                    	{
																			?>

                                                                            <label>Assigned to <span class="mndtry"></span></label>
                                                                            <select class="form-control selectpicker" name="encoder_group" id="encoder_group">
                                                                                <option value="0">-- Select --</option>
                                                                                <?php
																					if(sizeof($groups)>0)
																					{
																						$counter =1;
																						foreach($groups as $group)
																						{
																							if($gateway[0]['encoder_group'] == $group['id'])
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

																			<?php
																		}
																		else
																		{
																			?>
																			 <div class="dnone">

                                                                            <label>Assigned to <span class="mndtry"></span></label>
                                                                            <select class="form-control selectpicker" name="encoder_group" id="encoder_group">
                                                                                <option value="0">-- Select --</option>
                                                                                <?php
																					if(sizeof($groups)>0)
																					{
																						$counter =1;
																						foreach($groups as $group)
																						{
																							if($gateway[0]['encoder_group'] == $group['id'])
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
  <div class="col-lg-4 col-md-12">
											        <div class="form-group">
                                                        <label>Gateway Encoder ID <span class="mndtry"></span></label>
                                                        	                                                            							<input type="text" readonly="true" class="form-control yellow"  value="<?php echo $gateway[0]['encoder_id'];?>"/>
                                                    </div>
                                                     <div class="form-group">
                                                        <label>Pair Token</label>
                                                         <?php
                                                    if($gateway[0]['paired'] == 1)
                                                    {
                                                    	?>
                                                    	<input type="text" readonly="true" class="form-control yellow pairingtext"  placeholder="Not-Paired" value="<?php echo $gateway[0]['pairID'];?>"/>
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
                                                    if($gateway[0]['paired'] == 1)
                                                    {
                                                    	?>
                                                    	<a href="javascript:void(0);"  id="<?php echo $gateway[0]['encoder_id'];?>_unpair" class="btn gr pairing_gateway_encoder">Unpair <span></span></a>
                                                    	<?php
													}
													else
													{
														?>
                                                    	<a  href="javascript:void(0);" id="<?php echo $gateway[0]['encoder_id'];?>_pair" class="btn rd pairing_gateway_encoder">Pair<span></span></a>
                                                    	<?php
													}
                                                    ?>

										          </div>
                	</div>

<div class="col-xs-6 col-md-12 text-center">
					        <div style="width: 100%; max-height: calc(100% - 15px); text-align: center; display: inline-block;">
					            <div style="width: 100%; height:100%; align: center; display: inline-block;">
                <br/>
                <?php $host = "http://".$gateway[0]['encoder_ip'].":19999";
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
										<div class="netdata-container-easypiechart" style="margin-right: 10px; width: 9%; will-change: transform;" data-netdata="system.swap" data-host="<?php echo $host;?>" data-dimensions="used" data-append-options="percentage" data-chart-library="easypiechart" data-title="Used Swap" data-units="%" data-easypiechart-max-value="100" data-width="9%" data-before="0" data-after="-420" data-points="420" data-colors="#DD4400" role="application"></div>
                <div class="netdata-container-easypiechart" style="margin-right: 10px; width: 11%; will-change: transform;" data-netdata="system.io" data-host="<?php echo $host;?>" data-dimensions="in" data-chart-library="easypiechart" data-title="Disk Read" data-width="11%" data-before="0" data-after="-420" data-points="420" data-common-units="system.io.mainhead" role="application"></div>

                <div class="netdata-container-easypiechart" style="margin-right: 10px; width: 11%; will-change: transform;" data-netdata="system.io" data-host="<?php echo $host;?>" data-dimensions="out" data-chart-library="easypiechart" data-title="Disk Write" data-width="11%" data-before="0" data-after="-420" data-points="420" data-common-units="system.io.mainhead" role="application"></div>

                <div class="netdata-container-gauge" style="margin-right: 10px; width: 20%; will-change: transform;" data-netdata="system.cpu"  data-host="<?php echo $host;?>" data-chart-library="gauge" data-title="CPU" data-units="%" data-gauge-max-value="100" data-width="20%" data-after="-420" data-points="420" data-colors="#22AA99" role="application"></div>

                <div class="netdata-container-easypiechart" style="margin-right: 10px; width: 11%; will-change: transform;" data-netdata="system.net" data-host="<?php echo $host;?>" data-dimensions="received" data-chart-library="easypiechart" data-title="Net Inbound" data-width="11%" data-before="0" data-after="-420" data-points="420" data-common-units="system.net.mainhead" role="application"></div>

                <div class="netdata-container-easypiechart" style="margin-right: 10px; width: 11%; will-change: transform;" data-netdata="system.net" data-host="<?php echo $host;?>" data-dimensions="sent" data-chart-library="easypiechart" data-title="Net Outbound" data-width="11%" data-before="0" data-after="-420" data-points="420" data-common-units="system.net.mainhead" role="application"></div>

                <div class="netdata-container-easypiechart" style="margin-right: 10px; width: 9%; will-change: transform;" data-netdata="system.ram" data-host="<?php echo $host;?>" data-dimensions="used|buffers|active|wired" data-append-options="percentage" data-chart-library="easypiechart" data-title="Used RAM" data-units="%" data-easypiechart-max-value="100" data-width="9%" data-after="-420" data-points="420" data-colors="#EE9911" role="application">

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
