<?php 
error_reporting(E_ALL);
ini_set('display_errors',1);
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	require_once 'application/third_party/phpseclib/Net/SSH2.php';
class Gateway extends CI_Controller {

	
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
		$this->load->model('user_model');
		$this->load->model('common_model');
		$this->load->model('Groupadmin_model');
		$this->load->model('LogsModel');
		$this->load->model('GatewayModel');
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
	public function index()
	{
		$permissions = $this->session->userdata('user_permissions');
		if($permissions['view_gateway'] <= 0)
		{
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', "You are not authorized to perform this action.");
			redirect('configuration');
		}
		else
		{
			$this->breadcrumbs->push('Gateway', '/gateway');
			$userdata = $this->session->userdata('user_data');
			if($userdata['user_type'] == 1)
			{
				$data['banks'] = $this->common_model->getAllBanks(0,0);
				$data['apps'] = $this->common_model->getAllApplications(0);
				$data['encoders'] = $this->common_model->getAllEncoders(0,0);
				$data['profiles'] = $this->common_model->getEncoderProfiles();
				$data['audiochannels'] = $this->common_model->getAudioChannels();
			}
			elseif($userdata['user_type'] == 2 || $userdata['user_type'] == 3)
			{
				$data['banks'] = $this->common_model->getAllBanks(0,$userdata['userid']);
				$wowzids = array();$apids = array();
				$wowzaids = $this->Groupadmin_model->getConfigurationsDetails($userdata['userid'],$userdata['group_id']);
				if(sizeof($wowzaids)>0)
				{
					foreach($wowzaids as $wow)
					{
						array_push($wowzids,$wow['id']);
					}
				}
				$data['encoders'] = $this->Groupadmin_model->getAllEncodersbyUserIdAndGroupId($userdata['userid'],$userdata['group_id']);
				$data['apps'] = $this->Groupadmin_model->getAllApplicationsByWowzaIdAndUserId($wowzids,$userdata['userid']);
				$data['profiles'] = $this->Groupadmin_model->getEncoderProfilesByUseridAndGroupId($userdata['userid'],$userdata['group_id']);
				$data['audiochannels'] = $this->common_model->getAudioChannels();
			}
			$this->load->view('admin/header');
			$this->load->view('admin/gateway',$data);
			$this->load->view('admin/footer');
		}
	}
	public function getGatewayNDISource()
	{
		$response = array('status'=>FALSE,'response'=>array());
		$userdata = $this->session->userdata('user_data');
		if($userdata['user_type'] == 1)
		{
			$encoders = $this->common_model->getAllGateways(0,0);
		}
		elseif($userdata['user_type'] == 2 || $userdata['user_type'] == 3)
		{
			$encoders = $this->Groupadmin_model->getAllGatewaysbyUserIdAndGroupId($userdata['userid'],$userdata['group_id']);
		}
		if(sizeof($encoders)>0)
		{

			$ndiFullArray = array();
			foreach($encoders as $encoder)
			{
				$ip = $encoder['encoder_ip'];
				$username = $encoder['encoder_uname'];
				$password = $encoder['encoder_pass'];
				$port = $encoder['encoder_port'];
				$ssh = new Net_SSH2($ip);

				if ($ssh->login($username, $password,$port)) {

					$resp = $ssh->exec("ffmpeg -f libndi_newtek -find_sources 1 -i dummy");
					$array = explode('NDI sources:',$resp);
					$array1 = explode("\n",$array[1]);
					if(sizeof($array1)>0)
					{
						if(!array_key_exists($encoder['encoder_name'],$ndiFullArray))
						{
							$ndiFullArray[$encoder['encoder_name']] = array();
						}
						$ndiArray = array();
						foreach($array1 as $ele)
						{
							if($ele != "" && strpos($ele, 'Immediate') == false)
							{
								$node = explode("'",$ele);
								$ipport = explode(":",$node[3]);

								$random = $this->random_string(10);
								$name = str_replace(" ","_",$node[1]);
								$name = str_replace("(","_",$name);
								$name = str_replace(")","_",$name);
								$name = $random."__".$name."_".date('Y_m_d_h_i_s');
								
								if($ipport[0] == $ip)
								{									
									$ndiArray[] = array('isLocal'=>TRUE,'encoderId'=>$encoder['id'],'encname'=>$encoder['encoder_name'],'ndiname'=>$node[1],'euname'=>$username,'epass'=>$password,'port'=>$port,'sourceIP'=>$node[3],"fname"=>$name.".png","nn"=>$name);

								}
								else
								{									
									$ndiArray[] = array('isLocal'=>FALSE,'encoderId'=>$encoder['id'],'encname'=>$encoder['encoder_name'],'ndiname'=>$node[1],'euname'=>$username,'epass'=>$password,'port'=>$port,'sourceIP'=>$node[3],"fname"=>$name.".png","nn"=>$name);

								}
							}
						}
						$ndiFullArray[$encoder['encoder_name']] = $ndiArray;
					}
					$response['status']= TRUE;
					$response['response']= $ndiFullArray;
				}
			}
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
