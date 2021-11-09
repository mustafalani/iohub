<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('max_execution_time', 600);
set_time_limit(0);
 error_reporting(E_ALL);
 ini_set('display_errors',1);
 require_once APPPATH.'third_party/phpseclib/Net/SSH2.php';
require APPPATH . 'libraries/REST_Controller.php';
class Channels extends REST_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
    {
        parent::__construct();
		$this->load->model("common_model");
		$this->load->model("User_model");
    }
    public function update_uptime_post()
    {
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		if(!empty($cleanData['channelId']))
		{
			$data = array(
				'uptime'=>$cleanData['uptime']
			);
			$channel = $this->common_model->getChannelbyProcessName($cleanData['channelId']);
			if(sizeof($channel)>0)
			{
				$isUpdated = $this->common_model->updateChannelByChannelId($data,$cleanData['channelId']);
				if($isUpdated > 0){
					echo "Channel Time Updated Successfully!";
				}else{
					echo "Channel Time Not Updated!";
				}
			}
			else
			{
				echo "wrong channel ID-".$cleanData['channelId'];
			}

		}else{
			echo "Channel Id Null";
		}
	}
    public function update_post()
    {
		$cleanData = json_decode(file_get_contents('php://input'),TRUE);
		if(!empty($cleanData['channelId']))
		{
			$data = array(
				'channel_status'=>$cleanData['status']
			);
			$channel = $this->common_model->getChannelbyProcessName($cleanData['channelId']);
			if(sizeof($channel)>0)
			{
				$isUpdated = $this->common_model->updateChannelByChannelId($data,$cleanData['channelId']);
				if($isUpdated > 0){
					echo "Status Updated Successfully for ".$cleanData['channelId'];
				}else{
					echo "Status has already been updated for ".$cleanData['channelId'];
				}
			}
			else
			{
				echo "wrong channel ID-".$cleanData['channelId'];
			}

		}else{
			echo "Channel Id Null";
		}
	}
    public function start_post()
    {
		$userdata = $this->session->userdata('user_data');
		$response = array('status'=>FALSE,'response'=>'');

		/* All Parametes From Request */
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$channelId = $cleanData['channelId'];
		$idArray = explode('_',$channelId);

		/* Fetch Channel Info from Database */
		$channel = $this->common_model->getChannelbyId($idArray[1]);

		/* Fetch Encoder Info from Database */
		$encoderId= $channel[0]['encoder_id'];
		$encoder = $this->common_model->getAllEncoders($encoderId,0);
		$ip =  $encoder[0]["encoder_ip"];
		$username = $encoder[0]["encoder_uname"];
		$password = $encoder[0]["encoder_pass"];
		$port = "22";

		/* Checking Connection of Encoder */
		$ssh = new Net_SSH2($ip);
		if (!$ssh->login($username, $password,$port))
		{
			$response['status']= FALSE;
			$response['response']= $ssh->getLog();
			echo json_encode($response);
		}
		else
		{
			/* Variables Define */
			$inputType = "";$inputName = "";$inputOptions = "";$outputType ="";$outputName="";$outputOptions="";
			$channelID = $channel[0]['process_name'];
			$channel_name = $channel[0]['channel_name'];

			$logPath = ' >>iohub/logs/'.$channelID.' 2>&1';

			$channelType = $channel[0]['channel_type'];
			$_config = $this->config->item($channelType);
			switch($channelType)
			{
				case "SDITONDI":
					$Inputs = explode('_',$channel[0]['channelInput']);
					$inputType = $_config['input_type'];
					$inputName = $Inputs[1];
					$audioSource = $this->common_model->getInpOutByEncIdAndName($encoder[0]['id'],$inputName);
					$inputOptions = $_config['format_code'];
					$inputOptions .= ($encoder[0]['encoder_enable_hdmi_out'] == 1) ? " -video_input hdmi":" -video_input sdi";
					$inputOptions .= ($audioSource[0]['inp_aud_source'] != "") ? " -audio_input ".$audioSource[0]['inp_aud_source']:"";

					if($channel[0]['audio_channel'] != "" && $channel[0]['audio_channel'] > 0)
					{
						$inputOptions .= " -channels '".$channel[0]['audio_channel']."'";
					}
					$outputType = $_config['output_type'];
					$outputName = $channel[0]["ndi_name"];
					$outputOptions = "";
				break;
				case "SDITORTMP":
					$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$Inputs = explode('_',$channel[0]['channelInput']);
					$inputType = $_config['input_type'];
					$inputName = $Inputs[1];
					$audioSource = $this->common_model->getInpOutByEncIdAndName($encoder[0]['id'],$inputName);
					$inputOptions = $_config['format_code'];
					$inputOptions .= ($encoder[0]['encoder_enable_hdmi_out'] == 1) ? " -video_input hdmi":" -video_input sdi";
					$inputOptions .= ($audioSource[0]['inp_aud_source'] != "") ? " -audio_input ".$audioSource[0]['inp_aud_source']:"";
					if($channel[0]['audio_channel'] != "" && $channel[0]['audio_channel'] > 0)
					{
						$inputOptions .= " -channels '".$channel[0]['audio_channel']."'";
					}
					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_rtmp_url"]."/".$channel[0]["output_rtmp_key"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "SDITOMPEGRTP":
					$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$Inputs = explode('_',$channel[0]['channelInput']);
					$inputType = $_config['input_type'];
					$inputName = $Inputs[1];
					$audioSource = $this->common_model->getInpOutByEncIdAndName($encoder[0]['id'],$inputName);
					$inputOptions = $_config['format_code'];
					$inputOptions .= ($encoder[0]['encoder_enable_hdmi_out'] == 1) ? " -video_input hdmi":" -video_input sdi";
					$inputOptions .= ($audioSource[0]['inp_aud_source'] != "") ? " -audio_input ".$audioSource[0]['inp_aud_source']:"";
					if($channel[0]['audio_channel'] != "" && $channel[0]['audio_channel'] > 0)
					{
						$inputOptions .= " -channels '".$channel[0]['audio_channel']."'";
					}
					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_rtp"];
					$outputOptions = $this->encodingProfile($encodingProfile);

				break;
				case "SDITOMPEGUDP":
					$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$Inputs = explode('_',$channel[0]['channelInput']);
					$inputType = $_config['input_type'];
					$inputName = $Inputs[1];
					$audioSource = $this->common_model->getInpOutByEncIdAndName($encoder[0]['id'],$inputName);
					$inputOptions = $_config['format_code'];
					$inputOptions .= ($encoder[0]['encoder_enable_hdmi_out'] == 1) ? " -video_input hdmi":" -video_input sdi";
					$inputOptions .= ($audioSource[0]['inp_aud_source'] != "") ? " -audio_input '".$audioSource[0]['inp_aud_source']."'":"";
					if($channel[0]['audio_channel'] != "" && $channel[0]['audio_channel'] > 0)
					{
						$inputOptions .= " -channels '".$channel[0]['audio_channel']."'";
					}
					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_udp"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "SDITOMPEGSRT":
					$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$Inputs = explode('_',$channel[0]['channelInput']);
					$inputType = $_config['input_type'];
					$inputName = $Inputs[1];
					$audioSource = $this->common_model->getInpOutByEncIdAndName($encoder[0]['id'],$inputName);
					$inputOptions = $_config['format_code'];
					$inputOptions .= ($encoder[0]['encoder_enable_hdmi_out'] == 1) ? " -video_input hdmi":" -video_input sdi";
					$inputOptions .= ($audioSource[0]['inp_aud_source'] != "") ? " -audio_input '".$audioSource[0]['inp_aud_source']."'":"";
					if($channel[0]['audio_channel'] != "" && $channel[0]['audio_channel'] > 0)
					{
						$inputOptions .= " -channels '".$channel[0]['audio_channel']."'";
					}
					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_srt"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "NDITOSDI":
					$output = explode('_',$channel[0]['channelOutpue']);
					$outputfull = $this->common_model->getOutByEncIdAndName($encoder[0]['id'],$output[1]);
					$outformat = $this->common_model->getOutputFormatsValueByItem($outputfull[0]['out_format']);
					$inputType = $_config['input_type'];
					if($channel[0]['isRemote'] == 1 && $channel[0]['isIPAddresses'] == 1)
					{
						$inputType = $inputType." -extra_ips ".$channel[0]['ipAddress'];
					}
					$inputType .= " -r 25 -itsoffset -1";
					$inputName = $channel[0]['channel_ndi_source'];

					$outputOptions = "";

					if(strpos($output[1], 'HDMI') !== false)
					{
						$outputType = "alsa default ";
						$outputName = "-pix_fmt bgra -f fbdev /dev/fb0";
					}
					else
					{
						$outputType = $_config['output_type'].' -top 1';
						$outputName = $output[1];
						$outputOptions = $outformat[0]['value'];
					}
				break;
				case "NDITONDI":
					$inputType = $_config['input_type'];
					if($channel[0]['isRemote'] == 1 && $channel[0]['isIPAddresses'] == 1)
					{
						$inputType = $inputType." -extra_ips ".$channel[0]['ipAddress'];
					}
					$inputName = $channel[0]['channel_ndi_source'];
					$inputOptions = "";
					$outputType = $_config['output_type'];
					$outputName = $channel[0]["ndi_name"];
					$outputOptions = "";
				break;
				case "NDITORTMP":
					$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					if($channel[0]['isRemote'] == 1 && $channel[0]['isIPAddresses'] == 1)
					{
						$inputType = $inputType." -extra_ips ".$channel[0]['ipAddress'];
					}
					$inputName = $channel[0]['channel_ndi_source'];
					$inputOptions = "";
					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_rtmp_url"]."/".$channel[0]["output_rtmp_key"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "NDITOMPEGRTP":
					$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					if($channel[0]['isRemote'] == 1 && $channel[0]['isIPAddresses'] == 1)
					{
						$inputType = $inputType." -extra_ips ".$channel[0]['ipAddress'];
					}
					$inputName = $channel[0]['channel_ndi_source'];
					$inputOptions = "";
					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_rtp"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "NDITOMPEGUDP":
					$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					if($channel[0]['isRemote'] == 1 && $channel[0]['isIPAddresses'] == 1)
					{
						$inputType = $inputType." -extra_ips ".$channel[0]['ipAddress'];
					}
					$inputName = $channel[0]['channel_ndi_source'];
					$inputOptions = "";
					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_udp"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "NDITOMPEGSRT":
					$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					if($channel[0]['isRemote'] == 1 && $channel[0]['isIPAddresses'] == 1)
					{
						$inputType = $inputType." -extra_ips ".$channel[0]['ipAddress'];
					}
					$inputName = $channel[0]['channel_ndi_source'];
					$inputOptions = "";
					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_srt"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "RTMPTOSDI":
					$output = explode('_',$channel[0]['channelOutpue']);
					$outputfull = $this->common_model->getOutByEncIdAndName($encoder[0]['id'],$output[1]);
					$outformat = $this->common_model->getOutputFormatsValueByItem($outputfull[0]['out_format']);

					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_rtmp_url'];
					$inputOptions = "";
					$outputType = $_config['output_type'];
					$outputName = $output[1];
					$outputOptions = $outformat[0]['value'];
				break;
				case "RTMPTONDI":
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_rtmp_url'];
					$inputOptions = "";
					$outputType = $_config['output_type'];
					$outputName = $channel[0]["ndi_name"];
					$outputOptions = "";
				break;
				case "RTMPTORTMP":
					$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_rtmp_url'];
					$inputOptions = "";
					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_rtmp_url"]."/".$channel[0]["output_rtmp_key"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "RTMPTOMPEGRTP":
					$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_rtmp_url'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_rtp"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "RTMPTOMPEGUDP":
					$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_rtmp_url'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_udp"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "RTMPTOMPEGSRT":
					$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_rtmp_url'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_srt"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "MPEGRTPTOSDI":
					$output = explode('_',$channel[0]['channelOutpue']);
					$outputfull = $this->common_model->getOutByEncIdAndName($encoder[0]['id'],$output[1]);
					$outformat = $this->common_model->getOutputFormatsValueByItem($outputfull[0]['out_format']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_rtp'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $output[1];
					$outputOptions = $outformat[0]['value'];
				break;
				case "MPEGRTPTONDI":
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_rtp'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["ndi_name"];
					$outputOptions = "";
				break;
				case "MPEGRTPTORTMP":
					$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_rtp'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_rtmp_url"]."/".$channel[0]["output_rtmp_key"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "MPEGRTPTOMPEGRTP":
					$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_rtp'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_rtp"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "MPEGUDPTOSDI":
					$output = explode('_',$channel[0]['channelOutpue']);
					$outputfull = $this->common_model->getOutByEncIdAndName($encoder[0]['id'],$output[1]);
					$outformat = $this->common_model->getOutputFormatsValueByItem($outputfull[0]['out_format']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_udp'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $output[1];
					$outputOptions = $outformat[0]['value'];
				break;
				case "MPEGUDPTONDI":
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_udp'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["ndi_name"];
					$outputOptions = "";
				break;
				case "MPEGUDPTORTMP":
					$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_udp'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_rtmp_url"]."/".$channel[0]["output_rtmp_key"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "MPEGUDPTOMPEGUDP":
					$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_udp'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_rtp"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "MPEGSRTTOSDI":
					$output = explode('_',$channel[0]['channelOutpue']);
					$outputfull = $this->common_model->getOutByEncIdAndName($encoder[0]['id'],$output[1]);
					$outformat = $this->common_model->getOutputFormatsValueByItem($outputfull[0]['out_format']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_srt'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $output[1];
					$outputOptions = $outformat[0]['value'];
				break;
				case "MPEGSRTTONDI":
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_srt'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["ndi_name"];
					$outputOptions = "";
				break;
				case "MPEGSRTTORTMP":
					$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_srt'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_rtmp_url"]."/".$channel[0]["output_rtmp_key"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "MPEGSRTTOMPEGSRT":
					$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_srt'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_srt"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "HTTPLIVETOSDI":
					$output = explode('_',$channel[0]['channelOutpue']);
					$outputfull = $this->common_model->getOutByEncIdAndName($encoder[0]['id'],$output[1]);
					$outformat = $this->common_model->getOutputFormatsValueByItem($outputfull[0]['out_format']);

					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_hls_url'];
					$inputOptions = "";
					$outputType = $_config['output_type'];
					$outputName = $output[1];
					$outputOptions = $outformat[0]['value'];
				break;
				case "HTTPLIVETONDI":
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_hls_url'];
					$inputOptions = "";
					$outputType = $_config['output_type'];
					$outputName = $channel[0]["ndi_name"];
					$outputOptions = "";
				break;
				case "HTTPLIVETORTMP":
					$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_hls_url'];
					$inputOptions = "";
					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_rtmp_url"]."/".$channel[0]["output_rtmp_key"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "HTTPLIVETOMPEGRTP":
					$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_hls_url'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_rtp"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "HTTPLIVETOMPEGUDP":
					$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_hls_url'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_udp"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "HTTPLIVETOMPEGSRT":
					$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_hls_url'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_srt"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
			}

			$PID = $ssh->exec("pidof ".$channelID);
			$resp ="";
			if(empty($PID))
			{
				$LogCommand = $channel_name.'=> Start => "until ffmpeg '.$inputOptions.' -f '.$inputType.' -i \''.$inputName.'\' '.$outputOptions.' -f '.$outputType.' \''.$outputName.'\' -threads 16"'.$logPath.'; do echo \'restarting channel loop...\'; done';

				$resp = $ssh->exec('until ffmpeg '.$inputOptions.' -f '.$inputType.' -i \''.$inputName.'\' '.$outputOptions.' -f '.$outputType.' \''.$outputName.'\' -threads 16 '.$logPath.'; do echo \'restarting channel loop...\'; done');
			}

			$isPIDCreated = $ssh->exec("pidof ".$channelID);
			if(empty($isPIDCreated))
			{
				$status = "Error";
				$this->common_model->insertLogs($channel_name,'channels',$LogCommand,$userdata['userid'],$status);
				echo json_encode(array('status'=>FALSE, "message"=> 'Error occur while starting stream!' ,'change'=>'stop','error'=>$resp));
			}
			elseif(!empty($isPIDCreated) && $isPIDCreated > 0)
			{
				$cmd = 'ps -p '.trim($isPIDCreated).' -o lstart=';
				$time1 = $ssh->exec($cmd);
				$status = "Success";
				$this->common_model->insertLogs($channel_name,'channels',$LogCommand,$userdata['userid'],$status);
				$data = array(
					'channel_status'=>1,
					'uptime'=>$time1
				);
				$this->common_model->updateChannelByChannelId($data,$channelID);

				echo json_encode(array('status'=>TRUE, "message"=> 'Channel Start Successfully.','change'=>'start','time'=>$time1));
			}
		}
	}
	public function stop_post()
	{
		$userdata = $this->session->userdata('user_data');
		$response = array('status'=>FALSE,'response'=>'');

		/* All Parametes From Request */
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$channelId = $cleanData['channelId'];

		$idArray = explode('_',$channelId);
		$channel = $this->common_model->getChannelbyId($idArray[1]);
		$encoderId= $channel[0]['encoder_id'];
		$encoder = $this->common_model->getAllEncoders($encoderId,0);
		$ip =  $encoder[0]["encoder_ip"];
		$username = $encoder[0]["encoder_uname"];
		$password = $encoder[0]["encoder_pass"];
		$port = "22";
		$ssh = new Net_SSH2($ip);
		if (!$ssh->login($username, $password,$port)) {

			$response['status']= FALSE;
			$response['response']= $ssh->getLog();
			echo json_encode($response);
		}
		else
		{
			$channel_name ="";$status = "";
			$channel_name = $channel[0]['channel_name'];
			$ssh->exec('pkill -f '.$channel[0]['process_name']);
			$status = "Success";
			$command = $channel_name.'=> Stop => Channel Stopped Successfully!';
			$data = array(
					'channel_status'=>0,
					'uptime'=>''
				);
			$this->common_model->updateChannelByChannelId($data,$channel[0]['process_name']);
			$this->common_model->insertLogs($channel_name,'channels',$command,$userdata['userid'],$status);
			echo json_encode(array('status'=>TRUE, "message"=> 'Channel Stopped Successfully!','change'=>'stop'));
		}
	}
	/* Fetch Output Options from Encoding Profile */
	public function encodingProfile($encodingProfile)
	{
		$eprofile = "";
		$outputOptions ="";
		$gop ="";$deinterlace ="";

		if(sizeof($encodingProfile)>0)
		{
			if($encodingProfile[0]['adv_video_gop'] != "" && $encodingProfile[0]['adv_video_gop'] != NULL)
			{
				$gop = '-g '.$encodingProfile[0]["adv_video_gop"];
			}
			if($encodingProfile[0]['enabledeinterlance'] == 1)
			{
				$deinterlace = '-deinterlace';
			}
			if($encodingProfile[0]['enablezerolatency'] == 1)
			{
				$enablezerolatency = '-tune zerolatency';
			}
			$enablezerolatency="";
			$minBitRate = "";$maxBitRate ="";$bufSize="";$adv_video_keyframe_intrval="";$adv_video_profile="";$video_framerate ="";
			if($encodingProfile[0]['video_min_bitrate'] != "")
			{
				$minBitRate = '-minrate '.$encodingProfile[0]['video_min_bitrate'].'k';
			}
			if($encodingProfile[0]['video_max_bitrate'] != "")
			{
				$maxBitRate = '-maxrate '.$encodingProfile[0]['video_max_bitrate'].'k';
			}
			if($encodingProfile[0]['adv_video_buffer_size'] != "")
			{
				$bufSize = '-bufsize '.$encodingProfile[0]['adv_video_buffer_size'].'k';
			}
			if($encodingProfile[0]['adv_video_keyframe_intrval'] != "")
			{
				$adv_video_keyframe_intrval = '-force_key_frames '.$encodingProfile[0]['adv_video_keyframe_intrval'];
			}
			if($encodingProfile[0]['adv_video_profile'] != "" && $encodingProfile[0]['adv_video_profile'] != 0)
			{
				$adv_video_profile = '-profile:v '.$encodingProfile[0]['adv_video_profile'];
			}
			if($encodingProfile[0]['video_framerate'] != "" && $encodingProfile[0]['video_framerate'] > 0)
			{
				$video_framerate = '-vf fps='.$encodingProfile[0]['video_framerate'];
			}
			$outputOptions =  '-c:v '.$encodingProfile[0]['video_codec'].' -s '.$encodingProfile[0]['video_resolution'].' -b:v '.$encodingProfile[0]['video_bitrate'].'k '.$minBitRate.' '.$maxBitRate.' '.$bufSize.' '.$adv_video_keyframe_intrval.' '.$gop.' '.$adv_video_profile.' -pix_fmt yuv420p -preset '.$encodingProfile[0]['adv_video_preset'].' '.$deinterlace.' '.$enablezerolatency.' '.$video_framerate.' -c:a '.$encodingProfile[0]['audio_codec'].' -b:a '.$encodingProfile[0]['audio_bitrate'].'k -ar '.$encodingProfile[0]['audio_sample_rate'].' -ac '.$encodingProfile[0]['audio_channel'];
		}
		return $outputOptions;
	}
}
?>
