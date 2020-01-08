<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('max_execution_time', 600);
 ini_set('display_errors',1);
 require_once APPPATH.'third_party/phpseclib/Net/SSH2.php';
require APPPATH . 'libraries/REST_Controller.php';
class Extras extends CI_Controller {

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
    public function iotstream(){		
		$data['streams'] = $this->common_model->getAllIoTStreams(0);
		$this->load->view('admin/header');
		$this->load->view('admin/iotstream',$data);
		$this->load->view('admin/footer');
    }
	public function createIoTStream(){
		$data['audiochannels'] = $this->common_model->getAudioChannels();
		$data['encoders'] = $this->common_model->getAllEncodersbyStatus(0,0);
		$this->load->view('admin/header');
		$this->load->view('admin/createIoTStream',$data);
		$this->load->view('admin/footer');
	}
	public function saveIoTStream(){
		try 
		{
			$post     = $this->input->post();
			$actual_link =  $_SERVER['HTTP_REFERER'];
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));

			$userdata = $this->session->userdata('user_data');
			$encid =0;			
			$is_scheduled = 0;
			$processname = 'CH'.$this->random_string(10);
			$eids = explode("_",$cleanData['channelInput']);			
			$ndisoucewe ="";
			$isRemote = 0;
			if ($eids[0]== "phyinput") {
				$encid = $eids[2];
			}
			elseif($eids[0] == "virinput")
			{
				$src = explode('#',$cleanData['channel_ndi_source']);
				$encid = $src[0];
				$ndisoucewe = $src[1];
				if ($src[2] == "Remote") {
					$isRemote = 1;
				}
			} else {
				$encid = 0;
			}
			
			$is_IPAddress = 0;
			if (array_key_exists('isIPAddress',$cleanData)) {
				$is_IPAddress = 1;
			}
			$ip_addresses_comma = "";
			if (array_key_exists('ip_addresses_comma',$cleanData)) {
				$ip_addresses_comma = $cleanData['ip_addresses_comma'];
			}
			$record_channel = 0;
			if (array_key_exists('record_channel',$cleanData)) {
				$record_channel = 1;
			}
			$type = "";
			$cinputs = explode('_',$cleanData['channelInput']);				
			$encoder = $this->common_model->getAllEncoders($encid,0);
			if (sizeof($encoder)>0) {
				$processname = $processname.'_'.$encoder[0]['encoder_id'];
			}
			$EncrID = 0;
			if ($cleanData['channelEncoders'] != "") {
				$EncrIDs = explode('_',$cleanData['channelEncoders']);
				$EncrID = $EncrIDs[1];
			}
			$chennelData = array(
				'uid'=>$userdata['userid'],				
				'channel_name'=>$cleanData['stream_name'],
				'encoder_id'=>$encid,
				'channelInput'=>$cleanData['channelInput'],
				'audio_channel'=>$cleanData['sdi_audio_channel'],
				'channel_ndi_source'=>$ndisoucewe,
				'input_rtmp_url'=>$cleanData['input_rtmp_url'],
				'input_mpeg_rtp'=>$cleanData['input_mpeg_rtp'],
				'input_mpeg_udp'=>$cleanData['input_mpeg_udp'],
				'input_mpeg_srt'=>$cleanData['input_mpeg_srt'],			
				'status'=>1,
				'created'=>time(),
				'process_name'=>$processname,
				'input_hls_url'=>$cleanData['input_hls_url'],			
				'isIPAddresses'=>$is_IPAddress,
				'ipAddress'=>$ip_addresses_comma,
				'isRemote'=>$isRemote						
			);

			$id = $this->common_model->insertIoTStreams($chennelData);
			if ($id > 0) {			
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'Stream is sucessfully saved!');
				redirect('iotstream');
			} else {
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while creating Channel!');
				redirect('iotstream');
			}
		}
		catch (Exception $e) {
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Error occur while creating Channel!');
			redirect('iotstream');
		}
	}
	public function startiotstream(){
		$userdata = $this->session->userdata('user_data');
		$response = array('status'=>FALSE,'response'=>'');

		/* All Parametes From Request */
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$iotStreamId = $cleanData['iotstreamid'];
		$idArray = explode('_',$iotStreamId);

		/* Fetch Stream Info from Database */
		$iotStream = $this->common_model->getIoTStreambyId($idArray[1]);

		/* Fetch Encoder Info from Database */
		$encoderId = 0;
		if ($iotStream[0]['encoder_id'] == "" || $iotStream[0]['encoder_id'] <=0) {
			$encoderId= $iotStream[0]['encoder_id'];
		}
		$encoder = $this->common_model->getAllEncoders($encoderId,0);
		$ip =  $encoder[0]["encoder_ip"];
		$username = $encoder[0]["encoder_uname"];
		$password = $encoder[0]["encoder_pass"];
		$port = "22";
		/* Checking Connection of Encoder */
		$ssh = new Net_SSH2($ip);
		if (!$ssh->login($username, $password,$port)) {
			$response['status']= FALSE;
			$response['response']= $ssh->getLog();
			echo json_encode($response);
		} else {	
			$inputType = "";$inputName = "";
			$streamlID = $iotStream[0]['process_name'];
			$stream_name = $iotStream[0]['channel_name'];
			$Inputs = explode('_',$iotStream[0]['channelInput']);		
			switch ($Inputs[0]) {
				case "phyinput":					
				break;
				case "virinput":
				switch ($Inputs[1]) {
					case 3:
					$inputName = $iotStream[0]['channel_ndi_source'];
					break;
					case 4:
					$inputName = $iotStream[0]['input_rtmp_url'];
					break;
					case 5:
					$inputName = $iotStream[0]['input_mpeg_rtp'];
					break;
					case 6:
					$inputName = $iotStream[0]['input_mpeg_udp'];
					break;
					case 7:
					$inputName = $iotStream[0]['input_mpeg_srt'];
					break;
					case 8:
					$inputName = $iotStream[0]['input_hls_url'];
					break;	
				}					
				break;
			}
			$response = $ssh->exec('while sleep 2; do omxplayer --adev hdmi '.$inputName.' -threads 16  >>iohub/logs/'.$streamlID.' 2>&1; done');	
			$loopId = $ssh->exec('$(ps -ef | grep "'.$streamlID.'" | grep -v "grep" | grep "ffmpeg" | awk \'{print $2}\');');
			if (empty($loopId)) {
				$status = "Error";				
				echo json_encode(array('status'=>FALSE, "message"=> 'Error occur while starting stream!' ,'change'=>'stop','error'=>$response));
			}
			elseif(!empty($loopId) && preg_match('~[0-9]+~', $loopId))
			{
				$LOOPIDINRESPONSE = (int) filter_var($loopId, FILTER_SANITIZE_NUMBER_INT);

				$cmd = 'ps -p '.trim($LOOPIDINRESPONSE).' -o lstart=';
				$time1 = $ssh->exec($cmd);
				$status = "Success";
				$data = array(
				'channel_status'=>1,
				'uptime'=>$time1
				);
				$this->common_model->updateIoTStreamByStreamId($data,$streamlID);
				echo json_encode(array('status'=>TRUE,"response"=>$response, "message"=> 'Stream Start Successfully.','change'=>'start','time'=>$time1));	
			}
		}
	}
	public function stopiotstream(){
		
	}
	function random_string($length)
	{
		$key = '';
		$keys = array_merge(range(0, 9), range('A', 'Z'));

		for ($i = 0; $i < $length; $i++) {
			$key .= $keys[array_rand($keys)];
		}

		return $key;
	}
}
?>
