<?php $this->load->view('gadmin/navigation.php');?>
<?php $this->load->view('gadmin/leftsidebar.php');?>




<section class="content-wrapper">
   <!-- ========= Main Content Start ========= -->
   <div class="content">
   <div class="content-container">
      <div class="row">
         <!-- ========= Section One Start ========= -->
         <div class="col-lg-12 col-12-12">
            <div class="content-box config-contentonly">
               <div class="config-container">
               	 <form id="wowza-form" class="action-table" method="post" action="<?php echo site_url();?>groupadmin/saveEncoderTemplate" enctype="multipart/form-data">
               	 <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">	
                  <!-- === Nav tabs === -->
                  <div class="tab-btn-container">
                     <input type="submit" class="btn-def save" value="Save"/>
                  </div>
                  <!-- === Tab panes === -->
                  <div class="tab-content">
                     <div role="tabpanel" class="tab-pane active" id="groups">
                        <div class="action-table">
                           <div class="enc-template-form" id="enc_template_form">                           
                              <div class="row">
                                    <div class="col-lg-4 col-md-12">
                                       <div class="form-group">
                                          <label>TEMPLATE NAME <span class="mndtry">*</span></label>
                                          <input type="text" class="form-control" id="template_name" name="template_name">
                                       </div>
                                       <div class="form-group">
                                          <div class="check-input">
                                             <div class="boxes">
                                                <input type="checkbox" id="enableVideo" name="enableVideo">
                                                <label for="enableVideo" style="padding-left:25px;">VIDEO</label>
                                             </div>
                                          </div>
                                          <div class="row">
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Codec</span>
                                                <select class="form-control selectpicker" name="video_codec" id="video_codec">
                                               	   <option value="">-- Select --</option>
                                                   <option value="H.264">H.264</option>
                                                   <option value="HEVC">HEVC</option>
                                                </select>
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Resolution</span>
                                                <select class="form-control selectpicker" name="video_resolution" id="video_resolution">
                                                   <option value="">-- Select --</option>	
                                                   <option value="qvga">320x240</option>
                                                   <option value="vga">640x480</option>
                                                   <option value="ntsc">NTSC (720x480)</option>
                                                   <option value="pal">PAL (720x576)</option>
                                                   <option value="hd480">480P (852x480)</option>
                                                   <option value="hd720">720P (1280x720)</option>
                                                   <option value="hd1080">1080P (1920x1080)</option>
                                                   <option value="2k">2K (2048x1080)</option>
                                                   <option value="4k">4K (4096x2160)</option>
                                                </select>
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Bitrate (kbps)</span>
                                                <input type="number" class="form-control" id="video_bitrate" name="video_bitrate" value="1000">
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Framerate (fps)</span>
                                                <input type="number" class="form-control" value="30" id="video_framerate" name="video_framerate">
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Min. Bitrate (kbps)</span>
                                                <input type="number" class="form-control" id="video_min_bitrate" name="video_min_bitrate">
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Max. Bitrate (kbps)</span>
                                                <input type="number" class="form-control" id="video_max_bitrate" name="video_max_bitrate">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <div class="check-input advance_vid_setting">
                                             <div class="boxes">
                                                <input type="checkbox" id="advance_video_setting" name="advance_video_setting">
                                                <label for="advance_video_setting" style="padding-left:25px;">ADVANCED VIDEO ENCODING</label>
                                             </div>
                                          </div>
                                          <div class="row">
                                             <div class="col-md-6 ht">                                          
                                                <span class="text-blue">Preset</span>
                                                <select class="form-control selectpicker" name="adv_video_min_bitrate" id="adv_video_min_bitrate">
                                                    <option value="ultrafast">Ultrafast</option>
                                                    <option value="superfast">Superfast</option>
                                                    <option value="veryfast">Veryfast</option>
                                                    <option value="faster">Faster</option>
                                                    <option value="fast">Fast</option>
                                                    <option value="medium">Medium</option>
                                                    <option value="slow">Slow</option>
                                                    <option value="slower">Slower</option>
                                                    <option value="veryslow">Veryslow</option>
                                                    <option value="placebo">Placebo</option>
                                                </select> 
                                             </div>
                                             <div class="col-md-6 ht">                                          
                                                <span class="text-blue">Profile</span>
                                                <select class="form-control selectpicker" name="adv_video_max_bitrate" id="adv_video_max_bitrate">
                                                    <option value="baseline">Baseline</option>
                                                    <option value="main">Main</option>
                                                    <option value="high">High</option>
                                                    <option value="high10">High10</option>
                                                    <option value="High422">High422</option>
                                                    <option value="High444">High444</option>
                                                </select>
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Buffer Size (kbps)</span>
                                                <input type="number" class="form-control" id="adv_video_buffer_size" name="adv_video_buffer_size">
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">GOP</span>
                                                <input type="number" class="form-control" id="adv_video_gop" name="adv_video_gop">
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Keyframe Interval</span>
                                                <input type="number" class="form-control" id="adv_video_keyframe_intrval" name="adv_video_keyframe_intrval">
                                             </div>
                                          </div>
                                       </div>
                                       <div class="check-input">
                                          <div class="boxes">
                                             <input type="checkbox" id="enabledeinterlance" name="enabledeinterlance">
                                             <label for="enabledeinterlance" style="padding-left:25px;">Enable Deinterlace</label>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-lg-4 col-md-12">
                                       <div class="form-group">
                                          <div class="check-input">
                                             <div class="boxes">
                                                <input type="checkbox" id="audio_check" name="audio_check">
                                                <label for="audio_check" style="padding-left:25px;">AUDIO</label>
                                             </div>
                                          </div>
                                          <div class="row">
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Codec</span>
                                                <select class="form-control selectpicker" name="audio_codec" id="audio_codec">
                                                	<option value="">--Select--</option>
                                                   <option value="AAC">AAC</option>
                                                </select>
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Channels</span>
                                                <select class="form-control selectpicker" name="audio_channel" id="audio_channel">
                                                   <option value="">--Select--</option>
                                                   <option value="1">Mono</option>
                                                   <option value="2">Stereo</option>
                                                </select>
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Bitrate (kbps)</span>
                                                <select class="form-control selectpicker" name="audio_bitrate" id="audio_bitrate">
                                                   <option value="">--Select--</option>
                                                   <option value="64">64</option>
                                                   <option value="96">96</option>
                                                   <option value="120">128</option>
                                                   <option value="144">144</option>
                                                   <option value="160">160</option>
                                                   <option value="192">192</option>
                                                   <option value="256">256</option>
                                                </select>
                                             </div>
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Sample Rate</span>
                                                <select class="form-control selectpicker" name="audio_sample_rate" id="audio_sample_rate">
                                                	<option value="">--Select--</option>
                                                   <option value="44100">44.1 khz</option>
                                                   <option value="48000">48 khz</option>
                                                   <option value="88200">88.2 khz</option>
                                                   <option value="96000">96 khz</option>
                                                   <option value="192000">192 khz</option>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <div class="check-input enableAdvanceAudio">
                                             <div class="boxes">
                                                <input type="checkbox" id="enableAdvanceAudio" name="enableAdvanceAudio">
                                                <label for="enableAdvanceAudio" style="padding-left:25px;">ADVANCED AUDIO ENCODING</label>
                                             </div>
                                          </div>
                                          <div class="row adv_audio">
                                             <div class="col-md-6 ht">
                                                <span class="text-blue">Audio Gain</span>
                                                <input type="range" list="tickmarks">
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
                                             <span class="text-blue">Delay (ms)</span>
                                             <input type="number" id="delay" name="delay" class="form-control">
                                             </div>                                                                    
                                          </div>
                                       </div>
                                    </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     </div>
					</form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- ========= Main Content End ========= -->
</section>


