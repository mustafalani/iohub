<?php 
error_reporting(E_ALL);
ini_set('display_errors',1);
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once("application/third_party/ssp.class.php");
class Workflow extends CI_Controller {
	
	protected $response = array();
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->helper('security');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('breadcrumbs');
		$this->load->library('encrypt');
		$this->load->helper('date');
		$this->load->model('common_model');  
		$this->load->model('WorkflowModel');
		$userdata = $this->session->userdata('user_data');
		if(!empty($userdata))
		{
			$roles = $this->config->item('roles_id');
			$permissions = $this->common_model->getUserPermission($userdata['user_type']);
			$this->session->set_userdata('user_permissions',$permissions[0]);
			$role = $roles[$userdata['user_type']];
		}
		else
		{
			redirect(site_url() . 'home');
		}
	}
	public function edit()
	{
		$workflowid = $this->uri->segment(3);
		$data['workflow'] = $this->common_model->getWrokflowbyId($workflowid);
		$userdata = $this->session->userdata('user_data');
			if($userdata['user_type'] == 1)
			{
				$data['apps'] = $this->common_model->getAllApplications(0);
				$data['encoders'] = $this->common_model->getAllEncoders(0,0);
				$data['publishers'] = $this->common_model->getAllWowza();
				$data['profiles'] = $this->common_model->getEncoderProfiles();
				$data['audiochannels'] = $this->common_model->getAudioChannels();
			}
			elseif($userdata['user_type'] == 2 || $userdata['user_type'] == 3)
			{
				$wowzids = array();$apids = array();
				$wowzaids = $this->Groupadmin_model->getConfigurationsDetails($userdata['userid'],$userdata['group_id']);
				if(sizeof($wowzaids)>0)
				{
					foreach($wowzaids as $wow)
					{
						array_push($wowzids,$wow['id']);
					}
				}
				$data['publishers'] = $this->Groupadmin_model->getConfigurationsDetails($userdata['userid'],$userdata['group_id']);
				$data['encoders'] = $this->Groupadmin_model->getAllEncodersbyUserIdAndGroupId($userdata['userid'],$userdata['group_id']);
				$data['apps'] = $this->Groupadmin_model->getAllApplicationsByWowzaIdAndUserId($wowzids,$userdata['userid']);
				$data['profiles'] = $this->Groupadmin_model->getEncoderProfilesByUseridAndGroupId($userdata['userid'],$userdata['group_id']);
				$data['audiochannels'] = $this->common_model->getAudioChannels();
			}
		$this->load->view('admin/header');
		$this->load->view('admin/editworkflows',$data);
		$this->load->view('admin/footer');
	}
	public function create()
	{
		$response = array('status'=>FALSE,'response'=>array(),'message'=>"");
		$userdata = $this->session->userdata('user_data');
		
		$cleanData = $this->input->post();	
		$workFlowID = $cleanData['_settings']['wfid'];
		if(array_key_exists('_settings',$cleanData))
		{
			$counter =1;
			foreach($cleanData['_settings']['links'] as $index=>$values)
			{
				$fields = array();
				$type = "";
				$cinputs = explode('_',$values['from']);
				$coutputs = explode('_',$values['to']);
				$type = strtoupper($cinputs[2]).'TO'.strtoupper($coutputs[2]);
				$fields['channel_type'] = $type;
				$fields['channelID'] = 'WF_CH'.$this->random_string(8);
				$fields['uid'] = $userdata['userid'];
				$fields['channel_status'] = 1;
				$fields['status'] = 0;
				$fields['workflow_id'] = $cleanData['_settings']['wfid'];
				$fields['workflow_name'] = $cleanData['_settings']['wfname'];
				
				$fields['priority'] = $counter;
				$fields['channel_from'] = $values['from'];
				$fields['channel_to'] = $values['to'];
				
				if($cinputs[1] == "Input")
				{
					
					$fromData = $cleanData['_settings'][$values['from']];
					$enids = explode("_",$fromData['channel_encoder']);
					$fields['encoder_id'] = $enids[1];
					switch($cinputs[2])
					{
						case "sdi":
						$fields['channelInput'] = $fromData['channel_input'];
						$fields['audio_channel'] = $fromData['channel_audioChannel'];						
						break;
						case "ndi":
						$fields['channelInput'] = "virinput_3";
						$fields['isIPAddresses'] = $fromData['channel_isIPAddress'];
						$fields['ipAddress'] = $fromData['channel_ipAddress'];
						$fields['channel_ndi_source'] = $fromData['channel_ndiSource'];						
						break;
						case "rtmp":
						$fields['channelInput'] = "virinput_4";
						$fields['input_rtmp_url'] = $fromData['channel_rtmpURL'];
						break;
						case "rtp":
						$fields['channelInput'] = "virinput_5";
						$fields['input_mpeg_rtp'] = $fromData['channel_rtpURL'];
						break;
						case "udp":
						$fields['channelInput'] = "virinput_6";
						$fields['input_mpeg_udp'] = $fromData['channel_udpURL'];
						break;
						case "srt":
						$fields['channelInput'] = "virinput_7";
						$fields['input_mpeg_srt'] = $fromData['channel_srtURL'];
						break;
					}
				}
				if($cinputs[1] == "Output")
				{
					$fromData = $cleanData['_settings'][$values['from']];
					$toData = $cleanData['_settings'][$values['to']];
					 $encoder = array();					
					if($toData['channel_out_encoder'] != "" && $toData['channel_out_encoder'] != 0)
					{						
						$encidss = explode('_',$toData['channel_out_encoder']);
						$fields['encoder_id'] = $encidss[1];						
						$encoder = $this->common_model->getAllEncoders($fields['encoder_id'],0);	
					}	
					switch($cinputs[2])
					{						
						case "ndi":
						$fields['channelInput'] = "virinput_3";
						$fields['isIPAddresses'] = 0;
						$fields['ipAddress'] = "";
						$fields['channel_ndi_source'] = $encoder[0]['encoder_name'].' ('.$fromData['channel_ndiname'].')';						
						break;
						case "rtmp":
						$fields['channelInput'] = "virinput_4";
						$fields['input_rtmp_url'] = $fromData['channel_rtmp_stream_url'].'/'.$fromData['channel_rtmp_stream_kay'];
						break;
						case "rtp":
						$fields['channelInput'] = "virinput_5";
						$fields['input_mpeg_rtp'] = $fromData['channel_out_rtp_url'];
						break;
						case "udp":
						$fields['channelInput'] = "virinput_6";
						$fields['input_mpeg_udp'] = $fromData['channel_out_udp_url'];
						break;
						case "srt":
						$fields['channelInput'] = "virinput_7";
						$fields['input_mpeg_srt'] = $fromData['channel_out_srt_url'];
						break;
					}
				}
				if($coutputs[1] == "Output")
				{
					$fromData = $cleanData['_settings'][$values['from']];
					$toData = $cleanData['_settings'][$values['to']];
					if($toData['channel_out_encoder'] > 0)
					{
						$fields['encoder_id'] = $toData['channel_out_encoder'];
					}					
					switch($coutputs[2])
					{
						case "sdi":
						$fields['channelOutpue'] = $toData['channel_output'];
						break;
						case "ndi":
						$fields['channelOutpue'] = "viroutput_3";
						$fields['ndi_name'] = $toData['channel_ndiname'];
						break;
						case "rtmp":	
						$fields['channelOutpue'] = "viroutput_4";					
						$fields['channel_apps'] = $toData['channel_apps'];
						$fields['output_rtmp_url'] = $toData['channel_rtmp_stream_url'];
						$fields['output_rtmp_key'] = $toData['channel_rtmp_stream_kay'];
						$fields['auth_uname'] = $toData['channel_authUsername'];
						$fields['auth_pass'] = $toData['channel_authpassword'];
						$fields['encoding_profile'] = $toData['channel_encodingpreset'];
						break;
						case "rtp":
						$fields['channelOutpue'] = "viroutput_5";
						$fields['output_mpeg_rtp'] = $toData['channel_out_rtp_url'];
						$fields['encoding_profile'] = $toData['channel_encodingpreset'];
						break;
						case "udp":
						$fields['channelOutpue'] = "viroutput_6";
						$fields['output_mpeg_udp'] = $toData['channel_out_udp_url'];
						$fields['encoding_profile'] = $toData['channel_encodingpreset'];
						break;
						case "srt":
						$fields['channelOutpue'] = "viroutput_7";
						$fields['output_mpeg_srt'] = $toData['channel_out_srt_url'];
						$fields['encoding_profile'] = $toData['channel_encodingpreset'];
						break;
					}
				}
				if($coutputs[1] == "Gateway")
				{					
					$toData = $cleanData['_settings'][$values['to']];
					$fields['channelInput'] = "virinput_3";
					$fields['ndi_name'] = $toData['gateway_destination'];					
				}
				if($coutputs[1] == "Publisher")
				{			
					$fields['channelInput'] = "virinput_4";
					$toData = $cleanData['_settings'][$values['to']];	
					$fields['publisher'] = $toData['publisher'];				
					$fields['channel_apps'] = $toData['channel_pub_apps'];
					$fields['output_rtmp_url'] = $toData['output_pub_rtmp_url'];
					$fields['output_rtmp_key'] = $toData['output_pub_rtmp_key'];
					$fields['auth_uname'] = $toData['pub_auth_uname'];
					$fields['auth_pass'] = $toData['pub_auth_pass'];
					$fields['encoding_profile'] = $toData['pub_encoding_profile'];					
				}
				$id = $this->common_model->insertWorkflowChannels($fields);				
				$counter++;
			}
		}
		$response['status'] = TRUE;
		echo json_encode($response);
	}
	public function getApplicationsbyPublisher()
	{
		$response = array('status'=>FALSE,'response'=>array(),'message'=>"");
		$userdata = $this->session->userdata('user_data');		
		$clean = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$apps = $this->common_model->getWowzaApps($clean['id']);
		if(sizeof($apps)>0)
		{
			$response['status'] = TRUE;
			$response['data'] = $apps;
		}		
		echo json_encode($response);
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
