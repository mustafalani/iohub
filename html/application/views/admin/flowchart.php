<?php $this->load->view('admin/navigation.php');?>
<?php $this->load->view('admin/leftsidebar.php');?>
<?php $this->load->view('admin/rightsidebar.php');?>
<style type="text/css">
	.modal-content {
		background:#303030;
	}
	.iconn
	{
		font-size:36px;
	}
	.bankpopup{
		cursor: pointer;
	}
	.events-attachment-button {
    padding: 1px 10px !important;
}
.encoderschannelsDrops
{
	width:100%;
	min-height: 300px;
}
</style>
<script type="text/javascript">
var banks = [];
var channelss = [];
</script>
<?php
$encoders = $this->common_model->getAllEncoders(0,0);
?>

<section class="content-wrapper">
            <!-- ========= Main Content Start ========= -->
            <div class="content">

                <div class="content-container">
                    <div class="row">
                        <!-- ========= Section One Start ========= -->
                        <div class="col-lg-12 col-12-12">
                            <div class="content-box config-contentonly" style="background-color: rgba(255, 255, 255, 0);">
                                <div class="col-md-5">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h4 class="box-title" style="color:#fff;line-height: 2">Encoders</h4>
            </div>
            <div class="box-body">
              <!-- the events Mustafa Dont Remove "removedropGateway" class -->
              <div id="external-events">
              	<?php
                		if(sizeof($encoders)>0)
                		{
							foreach($encoders as $encod)
							{
								?>
								<div role="false" name="<?php echo $encod['encoder_id'];?>" id="<?php echo $encod['encoder_id'];?>" class="external-event bg-aqua" style="position: relative;font-size: 13px;">
								<?php echo $encod['encoder_name'];?></div>
								<?php
							}
						}
                		?>
              </div>
            </div>
            <!-- /.box-body -->
          </div>

           <div class="box box-solid">
            <div class="box-header with-border">
              <h4 class="box-title" style="color:#fff;line-height: 2">Outputs</h4>
            </div>
            <div class="box-body">
              <!-- the events Mustafa Dont Remove "removedropGateway" class -->
              <div id="external-events">
              	<?php
                		if(sizeof($encoders)>0)
                		{
							foreach($encoders as $encod)
							{
								?>
								<div role="false" name="<?php echo $encod['encoder_id'];?>" id="<?php echo $encod['encoder_id'];?>" class="external-event bg-aqua" style="position: relative;font-size: 13px;">
								<?php echo $encod['encoder_name'];?></div>
								<?php
							}
						}
                		?>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
        <div class="col-md-9"><!-- KAMAL PLEASE NOTE THAT I WILL CHANGE THIS DIV LATER/-->
                          <div  class="box box-solid">
                            <div class="box-header with-border">
                              <h4 class="box-title" style="color:#fff;line-height: 2">Channels Area</h4>

                            </div>
                            <div class="box-body">
                              <!-- THE BANKS -->
                              <div class="fc fc-unthemed fc-ltr">
                              	<div id="banks-events">
                                	<div class="encoderschannelsDrops"></div>
                              	</div>
                              </div>
                            </div>
                            <!-- /.box-body -->
                          </div>
                          <!-- /. box -->
                        </div>

                            </div>
                        </div>
                        <!-- ========= Section One End ========= -->

                    </div>
                </div>
            </div>
            <!-- ========= Main Content End ========= -->
        </section>
