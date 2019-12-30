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
    public function getChannelInputsOutputs_post()
    {
		$response = array('status'=>FALSE,'response'=>'','hasInputs'=>FALSE,'inputs'=>array(),'hasOutputs'=>FALSE,'outputs'=>array(),'vchinputs'=>array(),'vchoutputs'=>array());
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$IDs = explode('_',$cleanData['id']);
		$input = $this->common_model->getEncoderInpOutbyEncid($IDs[1]);
		$outputs = $this->common_model->getEncoderOutbyEncid($IDs[1]);

		$channelInputs = $this->common_model->getChannelInputs();
        if(sizeof($channelInputs)>0)
        {
			foreach($channelInputs as $inpu)
			{
				array_push($response['vchinputs'],$inpu);
			}
		}
		 $channelOutput = $this->common_model->getChannelOutput();
        if(sizeof($channelOutput)>0)
        {
			foreach($channelOutput as $output)
			{
				array_push($response['vchoutputs'],$output);
			}
		}
		if(sizeof($input)>0)
		{
			$response['hasInputs'] = TRUE;
			foreach($input as $inp)
			{
				$encoder = $this->common_model->getAllEncoders($inp['encid'],0);
				$inp['ename'] = $encoder[0]['encoder_name'];
				array_push($response['inputs'],$inp);
			}
		}
		if(sizeof($outputs)>0)
		{
			$response['hasOutputs'] = TRUE;
			foreach($outputs as $out)
			{
				$encoder = $this->common_model->getAllEncoders($out['encid'],0);
				$out['ename'] = $encoder[0]['encoder_name'];
				array_push($response['outputs'],$out);
			}
		}
		else
		{

			$encode = $this->common_model->getAllEncoders($IDs[1],0);
			if($encode[0]['encoder_enable_hdmi_out'] == 1)
			{
				$response['hasOutputs'] = TRUE;
				$extOut = array('encid'=>$IDs[1],'out_destination'=>'PC Out','out_name'=>'PC Out','ename'=>$encode[0]['encoder_name']);
				array_push($response['outputs'],$extOut);
			}
		}
		echo json_encode($response);
	}
    public function update_uptime_post()
    {
		$cleanData = json_decode(file_get_contents('php://input'),TRUE);
		//echo($cleanData);
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

		if($channel[0]['encoder_id'] == "" || $channel[0]['encoder_id'] <=0)
		{
			$encoderId= $channel[0]['encoderid'];
		}
		else{
			$encoderId= $channel[0]['encoder_id'];
		}
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

			$logPath = ' >>iohub/logs/channels/'.$channelID.' 2>&1';

			$channelType = $channel[0]['channel_type'];
			$_config = $this->config->item($channelType);
			switch($channelType)
			{
				case "SDITONDI":
					$Inputs = explode('_',$channel[0]['channelInput']);
					$inputType = $_config['input_type'];

					if(strpos($Inputs[1],"HDMI") !== FALSE)
					{
						$inputName = "DeckLink Mini Recorder 4K";
					}
					else
					{
						$inputName = $Inputs[1];
					}
					$audioSource = $this->common_model->getInpOutByEncIdAndName($encoder[0]['id'],$inputName);
					$inputOptions = $_config['format_code'];

					if(strpos($Inputs[1],"HDMI") !== FALSE)
					{
						$inputOptions .= " -video_input hdmi";
					}
					else
					{
						$inputOptions .= " -video_input sdi";
					}

					$inputOptions .= ($audioSource[0]['inp_aud_source'] != "") ? " -audio_input ".$audioSource[0]['inp_aud_source']:"";

					if($channel[0]['audio_channel'] != "" && $channel[0]['audio_channel'] > 0)
					{
						$inputOptions .= " -channels '".$channel[0]['audio_channel']."'";
					}
					$outputType = $_config['output_type'];
					$outputName = $channel[0]["ndi_name"];
					$outputOptions = "-pix_fmt uyvy422";
				break;
				case "SDITORTMP":
					$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$Inputs = explode('_',$channel[0]['channelInput']);
					$inputType = $_config['input_type'];
					if(strpos($Inputs[1],"HDMI") !== FALSE)
					{
						$inputName = "DeckLink Mini Recorder 4K";
					}
					else
					{
						$inputName = $Inputs[1];
					}
					$audioSource = $this->common_model->getInpOutByEncIdAndName($encoder[0]['id'],$inputName);
					$inputOptions = $_config['format_code'];
					if(strpos($Inputs[1],"HDMI") !== FALSE)
					{
						$inputOptions .= " -video_input hdmi";
					}
					else
					{
						$inputOptions .= " -video_input sdi";
					}
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
					if(strpos($Inputs[1],"HDMI") !== FALSE)
					{
						$inputName = "DeckLink Mini Recorder 4K";
					}
					else
					{
						$inputName = $Inputs[1];
					}
					$audioSource = $this->common_model->getInpOutByEncIdAndName($encoder[0]['id'],$inputName);
					$inputOptions = $_config['format_code'];
					if(strpos($Inputs[1],"HDMI") !== FALSE)
					{
						$inputOptions .= " -video_input hdmi";
					}
					else
					{
						$inputOptions .= " -video_input sdi";
					}
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
					if(strpos($Inputs[1],"HDMI") !== FALSE)
					{
						$inputName = "DeckLink Mini Recorder 4K";
					}
					else
					{
						$inputName = $Inputs[1];
					}
					$audioSource = $this->common_model->getInpOutByEncIdAndName($encoder[0]['id'],$inputName);
					$inputOptions = $_config['format_code'];
					if(strpos($Inputs[1],"HDMI") !== FALSE)
					{
						$inputOptions .= " -video_input hdmi";
					}
					else
					{
						$inputOptions .= " -video_input sdi";
					}
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
					if(strpos($Inputs[1],"HDMI") !== FALSE)
					{
						$inputName = "DeckLink Mini Recorder 4K";
					}
					else
					{
						$inputName = $Inputs[1];
					}
					$audioSource = $this->common_model->getInpOutByEncIdAndName($encoder[0]['id'],$inputName);
					$inputOptions = $_config['format_code'];
					if(strpos($Inputs[1],"HDMI") !== FALSE)
					{
						$inputOptions .= " -video_input hdmi";
					}
					else
					{
						$inputOptions .= " -video_input sdi";
					}
					$inputOptions .= ($audioSource[0]['inp_aud_source'] != "") ? " -audio_input '".$audioSource[0]['inp_aud_source']."'":"";
					if($channel[0]['audio_channel'] != "" && $channel[0]['audio_channel'] > 0)
					{
						$inputOptions .= " -channels '".$channel[0]['audio_channel']."'";
					}
					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_srt"]."?mode=listener";
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "NDITOSDI":
					$outformat ="";
					$output = explode('_',$channel[0]['channelOutpue']);
					$outputfull = $this->common_model->getOutByEncIdAndName($encoder[0]['id'],$output[1]);

					if(sizeof($outputfull)>0)
					{
						$outformat = $this->common_model->getOutputFormatsValueByItem($outputfull[0]['out_format']);
					}

					$inputType = $_config['input_type'];
					if($channel[0]['isRemote'] == 1 && $channel[0]['isIPAddresses'] == 1)
					{
						$inputType = $inputType." -extra_ips ".$channel[0]['ipAddress'];
					}
					$inputName = $channel[0]['channel_ndi_source'];

					$outputOptions = "";


					if(strpos($output[1],'PC Out') !== false)
					{
						$outputType = "";
						$outputName = " alsa default -pix_fmt bgra -f fbdev /dev/fb0";
            $inputOptions = "-fflags nobuffer";
					}
					else
					{
						$outputType = $_config['output_type'];
						$outputName = $output[1];
					}

					if(!empty($outformat))
					{
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
					$outputOptions = "-pix_fmt uyvy422";
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
					$outputName = $channel[0]["output_mpeg_srt"]."?mode=listener";
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "RTMPTOSDI":
					$output = explode('_',$channel[0]['channelOutpue']);
					$outputfull = $this->common_model->getOutByEncIdAndName($encoder[0]['id'],$output[1]);
					if(sizeof($outputfull)>0)
					{
						$outformat = $this->common_model->getOutputFormatsValueByItem($outputfull[0]['out_format']);
					}
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_rtmp_url'];
					$inputOptions = "";

					if(strpos($output[1],'PC Out') !== false)
					{
						$outputType = "";
						$outputName = " alsa default -pix_fmt bgra -f fbdev /dev/fb0";
            $inputOptions = "-fflags nobuffer";
					}
					else
					{
						$outputType = $_config['output_type'];
						$outputName = $output[1];
					}
					if(!empty($outformat))
					{
						$outputOptions = $outformat[0]['value'];
					}
				break;
				case "RTMPTONDI":
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_rtmp_url'];
					$inputOptions = "";
					$outputType = $_config['output_type'];
					$outputName = $channel[0]["ndi_name"];
					$outputOptions = "-pix_fmt uyvy422";
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
					$outputName = $channel[0]["output_mpeg_srt"]."?mode=listener";
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "MPEGRTPTOSDI":
					$output = explode('_',$channel[0]['channelOutpue']);
					$outputfull = $this->common_model->getOutByEncIdAndName($encoder[0]['id'],$output[1]);
					if(sizeof($outputfull)>0)
					{
						$outformat = $this->common_model->getOutputFormatsValueByItem($outputfull[0]['out_format']);
					}
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_rtp'];
					$inputOptions = "";
					if(strpos($output[1],'PC Out') !== false)
					{
						$outputType = "";
						$outputName = " alsa default -pix_fmt bgra -f fbdev /dev/fb0";
            $inputOptions = "-fflags nobuffer";
					}
					else
					{
						$outputType = $_config['output_type'];
						$outputName = $output[1];
					}

					if(!empty($outformat))
					{
						$outputOptions = $outformat[0]['value'];
					}
				break;
				case "MPEGRTPTONDI":
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_rtp'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["ndi_name"];
					$outputOptions = "-pix_fmt uyvy422";
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
					if(sizeof($outputfull)>0)
					{
						$outformat = $this->common_model->getOutputFormatsValueByItem($outputfull[0]['out_format']);
					}
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_udp'];
					$inputOptions = "";

					if(strpos($output[1],'PC Out') !== false)
					{
						$outputType = "";
						$outputName = " alsa default -pix_fmt bgra -f fbdev /dev/fb0";
            $inputOptions = "-fflags nobuffer";
					}
					else
					{
						$outputType = $_config['output_type'];
						$outputName = $output[1];
					}

					if(!empty($outformat))
					{
						$outputOptions = $outformat[0]['value'];
					}
				break;
				case "MPEGUDPTONDI":
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_udp'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["ndi_name"];
					$outputOptions = "-pix_fmt uyvy422";
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
					if(sizeof($outputfull)>0)
					{
						$outformat = $this->common_model->getOutputFormatsValueByItem($outputfull[0]['out_format']);
					}
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_srt'];

					if(strpos($output[1],'PC Out') !== false)
					{
						$outputType = "";
						$outputName = " alsa default -pix_fmt bgra -s hd1080 -f fbdev /dev/fb0";
            $inputOptions = "-fflags nobuffer";
					}
					else
					{
						$outputType = $_config['output_type'];
						$outputName = $output[1];
					}

					if(!empty($outformat))
					{
						$outputOptions = $outformat[0]['value'];
					}
				break;
				case "MPEGSRTTONDI":
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_srt'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["ndi_name"];
					$outputOptions = "-pix_fmt uyvy422";
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
					if(sizeof($outputfull)>0)
					{
						$outformat = $this->common_model->getOutputFormatsValueByItem($outputfull[0]['out_format']);
					}

					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_hls_url'];
					$inputOptions = "";
					if(strpos($output[1],'PC Out') !== false)
					{
						$outputType = "";
						$outputName = " alsa default -pix_fmt bgra -f fbdev /dev/fb0";
            $inputOptions = "-fflags nobuffer";
					}
					else
					{
						$outputType = $_config['output_type'];
						$outputName = $output[1];
					}

					if(!empty($outformat))
					{
						$outputOptions = $outformat[0]['value'];
					}
				break;
				case "HTTPLIVETONDI":
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_hls_url'];
					$inputOptions = "";
					$outputType = $_config['output_type'];
					$outputName = $channel[0]["ndi_name"];
					$outputOptions = "-pix_fmt uyvy422";
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
					$outputName = $channel[0]["output_mpeg_srt"]."?mode=listener";
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
			}

			$lOO_PID = $ssh->exec('$(ps -ef | grep "'.$channelID.'" | grep -v "grep" | grep "ffmpeg" | awk \'{print $2}\');');
			$resp ="";$LogCommand="";
			if(empty($lOO_PID))
			{
				if(strpos($outputName,"alsa") != FALSE)
				{
					$outputOptions_recording = "";
					if($channel[0]['is_record_channel'] == 1)
					{
						if($channel[0]['recording_presets'] == -1)
						{
							$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
							$outputOptions_recording = $this->encodingProfile($encodingProfile);
						}
						elseif($channel[0]['recording_presets'] == -2)
						{
							$encID = $channel[0]['encoderid'];
							$encoderprofile = $this->common_model->getAllEncoders($encID,0);

							$outputOptions_recording = $this->encodingProfile($encoderprofile);
						}
						elseif($channel[0]['recording_presets'] > 0)
						{
							$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['recording_presets']);
							$outputOptions_recording = $this->encodingProfile($encodingProfile);
						}
						$dateTime = date('Y-m-d-h-i-s');

						$LogCommand = $channel_name.'=> Start => while sleep 2; do ffmpeg '.$inputOptions.' '.$inputType.' -i \''.$inputName.'\' '.$outputOptions.' '.$outputType.' '.$outputName.' -threads 16 '.$logPath.' -f mpegts '.$outputOptions_recording.' iohub/media/recordings/'.$channel[0]['record_file'].$channelID.'`date +%s`.ts >>iohub/logs/recordings/'.$channelID.' 2>&1; done';

					$resp = $ssh->exec('while sleep 2; do ffmpeg '.$inputOptions.' '.$inputType.' -i \''.$inputName.'\' '.$outputOptions.' '.$outputType.' '.$outputName.' -threads 16 '.$logPath.' -f mpegts  '.$outputOptions_recording.' iohub/media/recordings/'.$channel[0]['record_file'].$channelID.'`date +%s`.ts >>iohub/logs/recordings/'.$channelID.' 2>&1; done');
					}
					else
					{
						$LogCommand = $channel_name.'=> Start => while sleep 2; do ffmpeg '.$inputOptions.' '.$inputType.' -i \''.$inputName.'\' '.$outputOptions.' '.$outputType.' '.$outputName.' -threads 16 '.$logPath.'; done';
					$resp = $ssh->exec('while sleep 2; do ffmpeg '.$inputOptions.' '.$inputType.' -i \''.$inputName.'\' '.$outputOptions.' '.$outputType.' '.$outputName.' -threads 16 '.$logPath.'; done');
					}
				}
				else
				{
					if($channel[0]['is_record_channel'] == 1)
					{
						if($channel[0]['recording_presets'] == -1)
						{
							$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
							$outputOptions_recording = $this->encodingProfile($encodingProfile);
						}
						elseif($channel[0]['recording_presets'] == -2)
						{
							$encID = $channel[0]['encoderid'];
							$encoderprofile = $this->common_model->getAllEncoders($encID,0);

							$outputOptions_recording = $this->encodingProfile($encoderprofile);
						}
						elseif($channel[0]['recording_presets'] > 0)
						{
							$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['recording_presets']);
							$outputOptions_recording = $this->encodingProfile($encodingProfile);
						}
						$dateTime = date('Y-m-d-h-i-s');
						$LogCommand = $channel_name.'=> Start => while sleep 2; do ffmpeg '.$inputOptions.' '.$inputType.' -i \''.$inputName.'\' '.$outputOptions.' '.$outputType.' \''.$outputName.'\' -threads 16 '.$logPath.' -f mpegts  '.$outputOptions_recording.' iohub/media/recordings/'.$channel[0]['record_file'].$channelID.'`date +%s`.ts >>iohub/logs/recordings/'.$channelID.' 2>&1;  done';
					$resp = $ssh->exec('while sleep 2; do ffmpeg '.$inputOptions.' '.$inputType.' -i \''.$inputName.'\' '.$outputOptions.' '.$outputType.' \''.$outputName.'\' -threads 16 '.$logPath.' -f mpegts  '.$outputOptions_recording.' iohub/media/recordings/'.$channel[0]['record_file'].$channelID.'`date +%s`.ts >>iohub/logs/recordings/'.$channelID.' 2>&1; done');

					}
					else
					{
						$LogCommand = $channel_name.'=> Start => while sleep 2; do ffmpeg '.$inputOptions.' '.$inputType.' -i \''.$inputName.'\' '.$outputOptions.' '.$outputType.' \''.$outputName.'\' -threads 16 '.$logPath.'; done';
					$resp = $ssh->exec('while sleep 2; do ffmpeg '.$inputOptions.' '.$inputType.' -i \''.$inputName.'\' '.$outputOptions.' '.$outputType.' \''.$outputName.'\' -threads 16 '.$logPath.'; done');
					}

				}

			} /* this is the final command */

			$loopId = $ssh->exec('$(ps -ef | grep "'.$channelID.'" | grep -v "grep" | grep "ffmpeg" | awk \'{print $2}\');');
			if (empty($loopId)) {
				$status = "Error";
				$this->common_model->insertLogs($channel_name,'channels',$LogCommand,$userdata['userid'],$status);
				echo json_encode(array('status'=>FALSE, "message"=> 'Error occur while starting stream!' ,'change'=>'stop','error'=>$resp));
			}
			elseif(!empty($loopId) && preg_match('~[0-9]+~', $loopId))
			{
				$LOOPIDINRESPONSE = (int) filter_var($loopId, FILTER_SANITIZE_NUMBER_INT);

				$cmd = 'ps -p '.trim($LOOPIDINRESPONSE).' -o lstart=';
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
		if($channel[0]['encoder_id'] == "")
		{
			$encoderId = $channel[0]['encoderid'];
		}
		else
		{
			$encoderId = $channel[0]['encoder_id'];
		}

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
			$channelID = $channel[0]['process_name'];
			$loopid = $ssh->exec('$(ps -ef | grep "'.$channelID.'" | grep -v "grep" | grep "ffmpeg" | grep -h "while" | awk \'{print $2}\');');
			if(empty($loopid))
			{
				echo json_encode(array('status'=>TRUE, "message"=> 'Channel Id Not Exists!','change'=>'stop'));
			}
			else
			{

				$LOOPIDINRESPONSE = (int) filter_var($loopid, FILTER_SANITIZE_NUMBER_INT);
				//$CID = $ssh->exec('$(pgrep -P "'.$LOOPIDINRESPONSE.'");');
        $CID = "'.$LOOPIDINRESPONSE.'";
				$actualCID = (int) filter_var($CID, FILTER_SANITIZE_NUMBER_INT);
				//$ssh->exec('kill -9 '.trim($actualCID));
				//echo 'pkill -9 -P '.trim($actualCID).' && kill -9 '.trim($actualCID).' && dd if=/dev/zero of=/dev/fb0';
				$resp= $ssh->exec('pkill -9 -P '.trim($actualCID).' && kill -9 '.trim($actualCID).' && dd if=/dev/zero of=/dev/fb0');
				//echo $resp;
				$status = "Success";
				$command = $channel_name.'=> Stop => Channel Stopped Successfully!';
				$data = array(
						'channel_status'=>0,
						'uptime'=>'00:00:00'
					);
				$this->common_model->updateChannelByChannelId($data,$channel[0]['process_name']);
				$this->common_model->insertLogs($channel_name,'channels',$command,$userdata['userid'],$status);
				echo json_encode(array('status'=>TRUE, "message"=> 'Channel Stopped Successfully!','change'=>'stop'));
			}

		}
	}
	public function status_post()
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
			$channelID =$channel[0]['process_name'];
			$loopId = $ssh->exec('$(ps -ef | grep "'.$channelID.'" | grep -v "grep" | grep "ffmpeg" | awk \'{print $2}\');');

			if($loopId == "")
			{
				echo json_encode(array('status'=>TRUE, "message"=> 'Channel Stopped','change'=>'stop'));
			}
			else
			{
				$LOOPIDINRESPONSE = (int) filter_var($loopId, FILTER_SANITIZE_NUMBER_INT);
				$cmd = 'ps -p '.trim($LOOPIDINRESPONSE).' -o lstart=';
				$time1 = $ssh->exec($cmd);
				$timestamp = strtotime($time1);
				echo json_encode(array('status'=>TRUE, "message"=> 'Already Running','change'=>'start','time'=>trim($time1)));
			}
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
			$enableAdvanceAudio ="";$audio_gain ="";$delay =""; $enableAdvAudGainDealy = "";
			if($encodingProfile[0]['enableAdvanceAudio'] != "" && $encodingProfile[0]['enableAdvanceAudio'] > 0)
			{
				$enableAdvanceAudio  = ' -filter:a';
				if($encodingProfile[0]['delay'] != "")
				{
					if($encodingProfile[0]['audio_channel'] != "")
					{
						if($encodingProfile[0]['audio_channel'] == "1")
						{
							$delay  = 'adelay='.$encodingProfile[0]['delay'];
							if($encodingProfile[0]['audio_gain'] != "" && $encodingProfile[0]['audio_gain'] != "0")
							{
								$audio_gain  = ' "volume='.$encodingProfile[0]['audio_gain'].'dB, '.$delay.'"';
							}
							else
							{
								$audio_gain  = ' "'.$delay.'"';
							}
						}
						else if($encodingProfile[0]['audio_channel'] == "2")
						{
							$delay  = 'adelay='.$encodingProfile[0]['delay'].'|'.$encodingProfile[0]['delay'];
							if($encodingProfile[0]['audio_gain'] != "" && $encodingProfile[0]['audio_gain'] != "0")
							{
								$audio_gain  = ' "volume='.$encodingProfile[0]['audio_gain'].'dB, '.$delay.'"';
							}
							else
							{
								$audio_gain  = ' "'.$delay.'"';
							}
						}
					}
					else
					{
						if($encodingProfile[0]['audio_gain'] != "" && $encodingProfile[0]['audio_gain'] != "0")
						{
							$delay  = 'adelay='.$encodingProfile[0]['delay'];
							$audio_gain  = ' "volume='.$encodingProfile[0]['audio_gain'].'dB, '.$delay.'"';
						}
						else
						{
							$audio_gain  = ' "'.$delay.'"';
						}
					}
				}
				else
				{
					if($encodingProfile[0]['audio_gain'] != "" && $encodingProfile[0]['audio_gain'] != "0")
					{
						$audio_gain  = ' "volume='.$encodingProfile[0]['audio_gain'].'dB"';
					}
				}
				$enableAdvAudGainDealy = $enableAdvanceAudio.$audio_gain;
			}



			$outputOptions =  '-c:v '.$encodingProfile[0]['video_codec'].' -s '.$encodingProfile[0]['video_resolution'].' -b:v '.$encodingProfile[0]['video_bitrate'].'k '.$minBitRate.' '.$maxBitRate.' '.$bufSize.' '.$adv_video_keyframe_intrval.' '.$gop.' '.$adv_video_profile.' -pix_fmt yuv420p -preset '.$encodingProfile[0]['adv_video_preset'].' '.$deinterlace.' '.$enablezerolatency.' '.$video_framerate.' -c:a '.$encodingProfile[0]['audio_codec'].' -b:a '.$encodingProfile[0]['audio_bitrate'].'k -ar '.$encodingProfile[0]['audio_sample_rate'].' -ac '.$encodingProfile[0]['audio_channel'].$enableAdvAudGainDealy;
		}
		return $outputOptions;
	}
}
?>
