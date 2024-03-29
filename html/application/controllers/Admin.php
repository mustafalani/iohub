<?php
error_reporting(E_ALL);

	defined('BASEPATH') OR exit('No direct script access allowed');
	require_once 'application/libraries/Facebook/autoload.php';
	require_once 'application/third_party/google/vendor/autoload.php';
	require_once 'application/third_party/phpseclib/Net/SSH2.php';
	require_once("application/third_party/twitterAPI/TwitterAPIExchange.php");
	require_once("application/third_party/ssp.class.php");
	class Admin extends CI_Controller {

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
		public $userId = 0;
		public $FacebooOBJ = NULL;

		public function __construct()
		{
			parent::__construct();
			$this->load->helper('url');
			$this->load->helper('form');
			$this->load->helper('security');
			$this->load->library('form_validation');
			$this->load->library('session');
			$this->load->library('breadcrumbs');
			//$this->load->library('Facebook\Facebook');
			//$this->load->library('Facebook\Exceptions\FacebookSDKException');
			$this->load->library('encrypt');
			$this->load->helper('date');
			$this->load->model('user_model');
			$this->load->model('common_model');
			$this->load->model('Groupadmin_model');

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
		public function upload_asset_files(){

			$returnarray = array('status'=>FALSE,'data'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$nebulaId = $this->uri->segment(3);
			$nebula = $this->common_model->getNebulabyId($nebulaId);
			$URL_SERVER = "https://".$nebula[0]['encoder_ip'];
			$URL = $URL_SERVER."/login";
			$ch1 = curl_init();
			curl_setopt($ch1,CURLOPT_URL, $URL);
			curl_setopt($ch1, CURLOPT_POST, 1);
			curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch1,CURLOPT_POSTFIELDS,"login=".$nebula[0]['encoder_uname']."&password=".$nebula[0]['encoder_pass']."&api=1");
			curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type'=>'application/json'));

			$result = curl_exec($ch1);
			$jsonData = rtrim($result, "\0");
			$resultarray = json_decode($jsonData,TRUE);
			curl_close($ch1);

			$curl = curl_init();
			$fields = array("id_asset" =>43,'session_id'=>$resultarray['session_id'],'file'=>'@'.$_FILES['file']['tmp_name']);

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $URL_SERVER."/upload",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS =>$fields,
			  CURLOPT_HTTPHEADER => array(
			    'Content-Type: multipart/form-data',
			    'Content-Length:'. strlen($fields),
			    'Authorization: Bearer '.base64_encode($resultarray['data']['login'].':demo'),
			    'Cookie: '.$_SERVER['HTTP_COOKIE']
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if($err){
			  echo json_encode($returnarray);
			}
			else{
				$returnarray['status'] = TRUE;
				$returnarray['data'] = $response;
			    echo json_encode($returnarray);
			}
		}

		public function saveAssets(){

			$returnarray = array('status'=>FALSE,'data'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$nebulaId = $cleanData['accesskey'];
			$nebula = $this->common_model->getNebulabyId($nebulaId);
			$URL_SERVER = "https://".$nebula[0]['encoder_ip'];
			$URL = $URL_SERVER."/login";
			$ch1 = curl_init();
			curl_setopt($ch1,CURLOPT_URL, $URL);
			curl_setopt($ch1, CURLOPT_POST, 1);
			curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch1,CURLOPT_POSTFIELDS, "login=".$nebula[0]['encoder_uname']."&password=".$nebula[0]['encoder_pass']."&api=1");
			curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type'=>'application/json'));

			$result = curl_exec($ch1);
			$jsonData = rtrim($result, "\0");
			$resultarray = json_decode($jsonData,TRUE);
			curl_close($ch1);

			$curl = curl_init();
			$flds = array();
			foreach($cleanData as $key=>$d)
			{
				if($key != "accesskey"){
					$flds[$key] = $d;
				}
			}
			$fields = json_encode(array("object_type" =>'asset','objects'=>array(0),'data'=>$flds,'session_id'=>$resultarray['session_id']));

			curl_setopt_array($curl, array(
			  CURLOPT_URL => $URL_SERVER."/api/set",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS =>$fields,
			  CURLOPT_HTTPHEADER => array(
			  	'Accept: application/json',
			    'Content-Type: application/json',
			    'Content-Length:'. strlen($fields),
			    'Authorization: Bearer '.base64_encode($resultarray['data']['login'].':demo'),
			    'Cookie: '.$_SERVER['HTTP_COOKIE']
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);
			curl_close($curl);
			if($err){
			  echo json_encode($returnarray);
			}
			else{
				$returnarray['status'] = TRUE;
				$returnarray['session_id'] = $resultarray['session_id'];
				$returnarray['data'] = $response;
			    echo json_encode($returnarray);
			}
		}
		public function createassets(){

			$data = array();
			$nebulaId = $this->uri->segment(3);
			$nebula = $this->common_model->getNebulabyId($nebulaId);

			$userdata = $this->session->userdata('user_data');
			$data['userdata'] = $this->session->userdata('user_data');
			$URL_SERVER = "https://".$nebula[0]['encoder_ip'];
			$data = array();
			$URL = $URL_SERVER."/login";
			$ch1 = curl_init();
			curl_setopt($ch1,CURLOPT_URL, $URL);
			curl_setopt($ch1, CURLOPT_POST, 1);
			curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch1,CURLOPT_POSTFIELDS, "login=".$nebula[0]['encoder_uname']."&password=".$nebula[0]['encoder_pass']."&api=1");
			curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type'=>'application/json'));
			$result = curl_exec($ch1);
			$jsonData = rtrim($result, "\0");
			$resultarray = json_decode($jsonData,TRUE);
			curl_close($ch1);

			$settins = curl_init();
			$fields = json_encode(array('session_id'=>$resultarray['session_id']));
			curl_setopt_array($settins, array(
			  CURLOPT_URL => $URL_SERVER."/api/settings",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS =>$fields,
			  CURLOPT_HTTPHEADER => array(
			  	'Accept: application/json',
			    'Content-Type: application/json',
			    'Content-Length:'. strlen($fields),
			    'Authorization: Bearer '.base64_encode($resultarray['data']['login'].':demo'),
			    'Cookie: '.$_SERVER['HTTP_COOKIE']
			  ),
			));
			$sesponse = curl_exec($settins);
			$set = json_decode($sesponse,TRUE);
			$data['settings'] = $set;
			$err = curl_error($settins);
			curl_close($settins);
			$this->load->view('admin/header');
			$this->load->view('admin/createassets',$data);
			$this->load->view('admin/footer');
		}
		public function updateNebula()
		{
			try{

				$this->form_validation->set_rules('encoder_name', 'Encoder Name', 'required');
				$this->form_validation->set_rules('encoder_ip', 'Encoder IP Address', 'required');
				$this->form_validation->set_rules('encoder_port', 'Encoder Port', 'required');
				$this->form_validation->set_rules('encoder_uname', 'Encoder Username', 'required');
				$this->form_validation->set_rules('encoder_pass', 'Encoder Password', 'required');
				$this->form_validation->set_rules('encoder_group', 'Encoder Group', 'required');
				$post     = $this->input->post();
				$actual_link =  $_SERVER['HTTP_REFERER'];
				if ($this->form_validation->run() == FALSE) {
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', validation_errors());
					redirect($actual_link);
				}
				else
				{
					$userdata = $this->session->userdata('user_data');
					$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
					$groupid =0;
					if($userdata['user_type'] == 1)
					{
						$groupid = $cleanData['encoder_group'];
					}
					else
					{
							$groupid = $userdata['group_id'];
					}
					$encoderData = array(
						'uid'=>$userdata['userid'],
	                	'encoder_name'=>$cleanData['encoder_name'],
	                	'encoder_ip'=>$cleanData['encoder_ip'],
	                	'encoder_port'=>$cleanData['encoder_port'],
	                	'encoder_uname'=>$cleanData['encoder_uname'],
	                	'encoder_pass'=>$cleanData['encoder_pass'],
						'parh_setting'=>$cleanData['parh_setting'],
	                	'encoder_group'=>$groupid
					);
					$id = $this->common_model->updateNebula($encoderData,$cleanData['encoderId']);
					if($id >= 0)
					{
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Nebula is sucessfully updated!');
						redirect('configuration');
					}
					else
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error occur while updating Nebula!');
						redirect('configuration');
					}
				}

			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while updating gateway!');
				redirect('configuration');
			}
		}
		public function saveNebula()
		{
			try{
				$this->form_validation->set_rules('encoder_name', 'Encoder Name', 'required');
				$this->form_validation->set_rules('encoder_ip', 'Encoder IP Address', 'required');
				$this->form_validation->set_rules('encoder_port', 'Encoder Port', 'required');
				$this->form_validation->set_rules('encoder_uname', 'Encoder Username', 'required');
				$this->form_validation->set_rules('encoder_pass', 'Encoder Password', 'required');
				$post     = $this->input->post();
				$actual_link =  $_SERVER['HTTP_REFERER'];
				if ($this->form_validation->run() == FALSE) {
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', validation_errors());
					redirect($actual_link);
				}
				else
				{
					$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
					$userdata = $this->session->userdata('user_data');
					$groupid = 0;
					if($userdata['user_type'] == 1)
					{
						$groupid = $cleanData['encoder_group'];
					}
					else
					{
						$groupid = $userdata['group_id'];
					}
					$encoderData = array(
						'uid'=>$userdata['userid'],
						'encoder_id'=>'NEBULA-ENC-'.$this->random_stringid(12),
	                	'encoder_name'=>$cleanData['encoder_name'],
	                	'encoder_ip'=>$cleanData['encoder_ip'],
	                	'encoder_port'=>$cleanData['encoder_port'],
	                	'encoder_uname'=>$cleanData['encoder_uname'],
	                	'encoder_pass'=>$cleanData['encoder_pass'],
						'parh_setting'=>$cleanData['parh_setting'],
	                	'encoder_group'=>$groupid,

	                	'created'=>time()
					);
					$id = $this->common_model->insertNebula($encoderData);
					if($id > 0)
					{
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Nebula is sucessfully cretaed!');
						redirect('admin/createnebula');
					}
					else
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error occur while creating Nebula!');
						redirect('admin/createnebula');
					}
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while adding Nebula!');
				redirect('admin/createnebula');
			}
		}
		public function editnebula()
		{
			$this->breadcrumbs->push('Configuration/Edit Nebula', '/configuration');
			$id = $this->uri->segment(2);
			$userdata =$this->session->userdata('user_data');
			$userdata = $this->session->userdata('user_data');
			$data['userdata'] = $this->session->userdata('user_data');
			if($userdata['user_type'] == 1)
			{
				$data['groups'] = $this->common_model->getGroups(0);
			}
			else
			{
				$data['groups'] = $this->common_model->getGroups($userdata['userid']);
			}

			$data['nebula'] = $this->common_model->getAllNebula($id);
			$this->load->view('admin/header');
			$this->load->view('admin/editnebula',$data);
			$this->load->view('admin/footer');
		}
		public function createnebula(){

			$userdata = $this->session->userdata('user_data');
			$data['userdata'] = $this->session->userdata('user_data');
			if($userdata['user_type'] == 1)
			{
				$data['groups'] = $this->common_model->getGroups(0);
			}
			else
			{
				$data['groups'] = $this->common_model->getGroups($userdata['userid']);
			}
			$this->load->view('admin/header');
			$this->load->view('admin/createnebula',$data);
			$this->load->view('admin/footer');
		}

		public function asset(){

			$nebulaId = $this->uri->segment(2);
			$nebula = $this->common_model->getNebulabyId($nebulaId);
			$URL_SERVER = 	"https://".$nebula[0]['encoder_ip'];

			$data = array();
			$URL = $URL_SERVER."/login";
			$ch1 = curl_init();
			curl_setopt($ch1,CURLOPT_URL, $URL);
			curl_setopt($ch1, CURLOPT_POST, 1);
			curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch1,CURLOPT_POSTFIELDS, "login=".$nebula[0]['encoder_uname']."&password=".$nebula[0]['encoder_pass']."&api=1");
			curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type'=>'application/json'));

			$result = curl_exec($ch1);
			$jsonData = rtrim($result, "\0");
			$resultarray = json_decode($jsonData,TRUE);
			curl_close($ch1);

			$settins = curl_init();
			$fields = json_encode(array('session_id'=>$resultarray['session_id']));
			curl_setopt_array($settins, array(
			  CURLOPT_URL => $URL_SERVER."/api/settings",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS =>$fields,
			  CURLOPT_HTTPHEADER => array(
			  	'Accept: application/json',
			    'Content-Type: application/json',
			    'Content-Length:'. strlen($fields),
			    'Authorization: Bearer '.base64_encode($resultarray['data']['login'].':demo'),
			    'Cookie: '.$_SERVER['HTTP_COOKIE']
			  ),
			));
			$sesponse = curl_exec($settins);
			$set = json_decode($sesponse,TRUE);
			$data['settings'] = $set;
			$err = curl_error($settins);
			curl_close($settins);

			$main = curl_init();
			$fields = json_encode(array("object_type" =>'asset','id_view'=>1,'session_id'=>$resultarray['session_id']));
			curl_setopt_array($main, array(
			  CURLOPT_URL => $URL_SERVER."/api/get",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS =>$fields,
			  CURLOPT_HTTPHEADER => array(
			  	'Accept: application/json',
			    'Content-Type: application/json',
			    'Content-Length:'. strlen($fields),
			    'Authorization: Bearer '.base64_encode($resultarray['data']['login'].':demo'),
			    'Cookie: '.$_SERVER['HTTP_COOKIE']
			  ),
			));
			$mainresponse = curl_exec($main);
			$mainAssets = json_decode($mainresponse,TRUE);
			$data['main'] = $mainAssets;
			$err = curl_error($main);
			curl_close($main);


			$fill = curl_init();
			$fields = json_encode(array("object_type" =>'asset','id_view'=>2,'session_id'=>$resultarray['session_id']));
			curl_setopt_array($fill, array(
			  CURLOPT_URL => $URL_SERVER."/api/get",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS =>$fields,
			  CURLOPT_HTTPHEADER => array(
			  	'Accept: application/json',
			    'Content-Type: application/json',
			    'Content-Length:'. strlen($fields),
			    'Authorization: Bearer '.base64_encode($resultarray['data']['login'].':demo'),
			    'Cookie: '.$_SERVER['HTTP_COOKIE']
			  ),
			));
			$fillresponse = curl_exec($fill);
			$fillAssets = json_decode($fillresponse,TRUE);
			$data['fill'] = $fillAssets;
			$err = curl_error($fill);
			curl_close($fill);

			$music = curl_init();
			$fields = json_encode(array("object_type" =>'asset','id_view'=>3,'session_id'=>$resultarray['session_id']));
			curl_setopt_array($music, array(
			  CURLOPT_URL => $URL_SERVER."/api/get",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS =>$fields,
			  CURLOPT_HTTPHEADER => array(
			  	'Accept: application/json',
			    'Content-Type: application/json',
			    'Content-Length:'. strlen($fields),
			    'Authorization: Bearer '.base64_encode($resultarray['data']['login'].':demo'),
			    'Cookie: '.$_SERVER['HTTP_COOKIE']
			  ),
			));
			$musicresponse = curl_exec($music);
			$musicAssets = json_decode($musicresponse,TRUE);
			$data['music'] = $musicAssets;
			$err = curl_error($music);
			curl_close($music);

			$stories = curl_init();
			$fields = json_encode(array("object_type" =>'asset','id_view'=>4,'session_id'=>$resultarray['session_id']));
			curl_setopt_array($stories, array(
			  CURLOPT_URL => $URL_SERVER."/api/get",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS =>$fields,
			  CURLOPT_HTTPHEADER => array(
			  	'Accept: application/json',
			    'Content-Type: application/json',
			    'Content-Length:'. strlen($fields),
			    'Authorization: Bearer '.base64_encode($resultarray['data']['login'].':demo'),
			    'Cookie: '.$_SERVER['HTTP_COOKIE']
			  ),
			));
			$storiesresponse = curl_exec($stories);
			$storyAssets = json_decode($storiesresponse,TRUE);
			$data['story'] = $storyAssets;
			$err = curl_error($stories);
			curl_close($stories);

			$commercial = curl_init();
			$fields = json_encode(array("object_type" =>'asset','id_view'=>5,'session_id'=>$resultarray['session_id']));
			curl_setopt_array($commercial, array(
			  CURLOPT_URL => $URL_SERVER."/api/get",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS =>$fields,
			  CURLOPT_HTTPHEADER => array(
			  	'Accept: application/json',
			    'Content-Type: application/json',
			    'Content-Length:'. strlen($fields),
			    'Authorization: Bearer '.base64_encode($resultarray['data']['login'].':demo'),
			    'Cookie: '.$_SERVER['HTTP_COOKIE']
			  ),
			));
			$commercialresponse = curl_exec($commercial);
			$commercialAssets = json_decode($commercialresponse,TRUE);
			$data['commercial'] = $commercialAssets;
			$err = curl_error($commercial);
			curl_close($commercial);


			$incoming = curl_init();
			$fields = json_encode(array("object_type" =>'asset','id_view'=>52,'session_id'=>$resultarray['session_id']));
			curl_setopt_array($incoming, array(
			  CURLOPT_URL => $URL_SERVER."/api/get",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS =>$fields,
			  CURLOPT_HTTPHEADER => array(
			  	'Accept: application/json',
			    'Content-Type: application/json',
			    'Content-Length:'. strlen($fields),
			    'Authorization: Bearer '.base64_encode($resultarray['data']['login'].':demo'),
			    'Cookie: '.$_SERVER['HTTP_COOKIE']
			  ),
			));
			$incomingresponse = curl_exec($incoming);
			$incomingAssets = json_decode($incomingresponse,TRUE);
			$data['incoming'] = $incomingAssets;
			$err = curl_error($incoming);
			curl_close($incoming);

			$archive = curl_init();
			$fields = json_encode(array("object_type" =>'asset','id_view'=>51,'session_id'=>$resultarray['session_id']));
			curl_setopt_array($archive, array(
			  CURLOPT_URL => $URL_SERVER."/api/get",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS =>$fields,
			  CURLOPT_HTTPHEADER => array(
			  	'Accept: application/json',
			    'Content-Type: application/json',
			    'Content-Length:'. strlen($fields),
			    'Authorization: Bearer '.base64_encode($resultarray['data']['login'].':demo'),
			    'Cookie: '.$_SERVER['HTTP_COOKIE']
			  ),
			));
			$archiveresponse = curl_exec($archive);
			$archiveAssets = json_decode($archiveresponse,TRUE);
			$data['archive'] = $archiveAssets;
			$err = curl_error($archive);
			curl_close($archive);

			$trash = curl_init();
			$fields = json_encode(array("object_type" =>'asset','id_view'=>50,'session_id'=>$resultarray['session_id']));
			curl_setopt_array($trash, array(
			  CURLOPT_URL => $URL_SERVER."/api/get",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS =>$fields,
			  CURLOPT_HTTPHEADER => array(
			  	'Accept: application/json',
			    'Content-Type: application/json',
			    'Content-Length:'. strlen($fields),
			    'Authorization: Bearer '.base64_encode($resultarray['data']['login'].':demo'),
			    'Cookie: '.$_SERVER['HTTP_COOKIE']
			  ),
			));
			$trashresponse = curl_exec($trash);
			$trashAssets = json_decode($trashresponse,TRUE);
			$data['trash'] = $trashAssets;
			$err = curl_error($trash);
			curl_close($trash);

			$this->load->view('admin/header');
			$this->load->view('admin/assets',$data);
			$this->load->view('admin/footer');
		}
		public function rundowns(){

			$userdata = $this->session->userdata('user_data');
			if ($userdata['user_type'] == 1) {
				$data['rundowns'] = $this->common_model->getAllRundowns(0);
			}
			elseif($userdata['user_type'] == 2 || $userdata['user_type'] == 3){
				$group_id = $userdata['group_id'];
				if($group_id != NULL && $group_id >0)
				{
					$nebulas = $this->common_model->getNebula($group_id);
					$nebulaids = array();
					if (sizeof($nebulas)>0) {
						foreach ($nebulas as $nebula) {
							array_push($nebulaids,$nebula['id']);
						}
					}

					if (sizeof($nebulaids)>0) {
						$data['rundowns'] = $this->common_model->getAllRundownsByIds($nebulaids);
					}
 					else {
						$data['rundowns'] = array();
					}
				}
 				else {
	 				$data['rundowns'] = array();
				}
			}
			$this->load->view('admin/header');
			$this->load->view('admin/rundown',$data);
			$this->load->view('admin/footer');
		}
		public function help()
		{
			$this->breadcrumbs->push('Help', '/help');
			$this->load->view('admin/header');
			$this->load->view('admin/help');
			$this->load->view('admin/footer');
		}
		public function privacy()
		{
			$this->breadcrumbs->push('Privacy', '/privacy');
			$this->load->view('admin/header');
			$this->load->view('admin/privacy');
			$this->load->view('admin/footer');
		}
		public function terms()
		{
			$this->breadcrumbs->push('Terms', '/terms');
			$this->load->view('admin/header');
			$this->load->view('admin/terms');
			$this->load->view('admin/footer');
		}
		public function streamviewer()
		{
			$this->breadcrumbs->push('Stream Viewer', '/streamviewer');
			$this->load->view('admin/header');
			$this->load->view('admin/streamviewer');
			$this->load->view('admin/footer');
		}
		public function extra()
		{
			$this->breadcrumbs->push('Extra', '/extra');
			$this->load->view('admin/header');
			$this->load->view('admin/extra');
			$this->load->view('admin/footer');
		}
		function getarchiveChannels()
	    {
			$vars = $this->input->post(NULL,TRUE);
			$userdata = $this->session->userdata('user_data');
			if($userdata['user_type'] == 1)
			{
				$result = $this->common_model->getAllArchiveChannels(0,$vars);
				$totalResult = $this->common_model->getAllTotalArchiveChannels(0,$vars);
			}
			elseif($userdata['user_type'] == 2 || $userdata['user_type'] == 3)
			{
				$idsss = array($userdata['group_id']);
				$useids = $this->common_model->getUsersByGroupIds($idsss);
				$USERidS = array();
				if(sizeof($useids)>0)
				{
					foreach($useids as $u)
					{
						array_push($USERidS,$u['id']);
					}
				}

				$result = $this->common_model->getAllArchiveChannelsByUserids($USERidS,$vars);
				$totalResult = $this->common_model->getAllTotalArchiveChannelsByUserids($USERidS);
			}

			$response = array();
			if(!empty($result))
			{
				$counter = 1;
				foreach($result as $r)
				{
					$output= array();
					$output[] = "<div class='boxes'><input type='checkbox' id='log_".$r['id']."' class='selectarchive'/><label for='log_".$r['id']."'></label></div>";
					$output[] = $counter;
					$output[] = $r['channel_name'];
					$output[] = $r['process_name'];
					$u = $this->common_model->getUserDetails($r['uid']);
			       	$output[] = $u[0]['fname'];

					$output[] = '<a data-toggle="tooltip" title="Restore" id="ch_'.$r['id'].'" class="archChannelRestore" href="Javascript:void(0);"><i class="fa fa-undo"></i></a>';
					$output[] = '<a class="channelArchiveDel" data-toggle="tooltip" title="Delete" id="ch_'.$r['id'].'" href="javascript:void(0);"><i class="fa fa-trash"></i></a>';
					$response[] = $output;
					$counter++;
				}
			}
			$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
			$returnJson['recordsTotal'] = $totalResult[0]['total'];
			$returnJson['recordsFiltered'] = $totalResult[0]['total'];
			$returnJson['data'] = $response;
			echo json_encode($returnJson);
		}
		public function workflowlist(){
			$data = array();
			$userdata = $this->session->userdata('user_data');

			$this->load->view('admin/header');
			$this->load->view('admin/workflowlist',$data);
			$this->load->view('admin/footer');
		}
		public function workflows_old()
		{
			$data = array();
			$userdata = $this->session->userdata('user_data');
			if($userdata['user_type'] == 1)
			{
				$data['apps'] = $this->common_model->getAllApplications(0);
				$data['encoders'] = $this->common_model->getAllEncoders(0,0);
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
				$data['encoders'] = $this->Groupadmin_model->getAllEncodersbyUserIdAndGroupId($userdata['userid'],$userdata['group_id']);
				$data['apps'] = $this->Groupadmin_model->getAllApplicationsByWowzaIdAndUserId($wowzids,$userdata['userid']);
				$data['profiles'] = $this->Groupadmin_model->getEncoderProfilesByUseridAndGroupId($userdata['userid'],$userdata['group_id']);
				$data['audiochannels'] = $this->common_model->getAudioChannels();
			}
			$this->load->view('admin/header');
			$this->load->view('admin/workflows',$data);
			$this->load->view('admin/footer');
		}
		public function workflows()
		{
			$data = array();
			$data['workflowID'] = 'WF'.$this->random_string(10);
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
			$this->load->view('admin/workflows',$data);
			$this->load->view('admin/footer');
		}
		public function flowchart()
		{
			$this->load->view('admin/header');
			$this->load->view('admin/flowchart');
			$this->load->view('admin/footer');
		}
		/* Cront Jobs */
		private function stringToArray($jobs = '') {
        $array = explode("\n", trim($jobs)); // trim() gets rid of the last \r\n
        foreach ($array as $key => $item) {
            if ($item == '') {
                unset($array[$key]);
            }
        }
        return $array;
	    }

	     private function arrayToString($jobs = array()) {
	        $string = implode("\n", $jobs);
	        return $string;
	    }
	    public function getJobs() {

	    	$ip = $this->config->item('ServerIP');
			$username = $this->config->item('ServerUser');
			$password = $this->config->item('ServerPassword');
			$port = '22';
			$ssh = new Net_SSH2($ip);
			if ($ssh->login($username, $password,$port)) {
				$output = $ssh->exec("crontab -l");
		        $s = $this->stringToArray($output);
		       return $s;
			}
	    }
	    public function saveJobs($jobs = array()) {
	        //$output = shell_exec('echo "'.$this->arrayToString($jobs).'" | crontab -');
	        $output = "";
	        $ip = $this->config->item('ServerIP');
			$username = $this->config->item('ServerUser');
			$password = $this->config->item('ServerPassword');
			$port = '22';
			$ssh = new Net_SSH2($ip);
			if ($ssh->login($username, $password,$port)) {
				$s = $this->arrayToString($jobs);
				$output = $ssh->exec('echo "'.$s.'" | crontab -');
			}
	        echo $output;
	    }
	    public function doesJobExist($job = '') {
	        $jobs = $this->getJobs();
	        if (in_array($job, $jobs)) {
	            return TRUE;
	        } else {
	            return FALSE;
	        }
	    }
	    public function addJob($job = '') {
	        if ($this->doesJobExist($job)) {
	            return false;
	        } else {
	            $jobs = $this->getJobs();
	            $jobs[] = $job;
	            return $this->saveJobs($jobs);
	        }
	    }
	    public function removeJob($job = '') {
	        if ($this->doesJobExist($job)) {
	            $jobs = $this->getJobs();
	            unset($jobs[array_search($job, $jobs)]);

	            return $this->saveJobs($jobs);
	        } else {
	            return false;
	        }
	    }
		/* Cront End */
		public function schedule()
		{


			$userdata =$this->session->userdata('user_data');
			$channelsLocks = array();
			if($userdata['user_type'] == 1)
			{
				$data['channels'] = $this->common_model->getAllChannels(0);
				$data['targets'] = $this->common_model->getAllTargets();
				$data['schedule'] = $this->common_model->getAllSchedules(0,0);
			}
			elseif($userdata['user_type'] == 2 || $userdata['user_type'] == 3)
			{
				$idsss = array($userdata['group_id']);
				$useids = $this->common_model->getUsersByGroupIds($idsss);
				$USERidS = array();
				if(sizeof($useids)>0)
				{
					foreach($useids as $u)
					{
						array_push($USERidS,$u['id']);
					}
				}
				$data['channels'] = $this->common_model->getAllChannelsByUserids($USERidS);
				$data['schedule'] = $this->common_model->getAllSchedules(0,$USERidS);
				$wowzids = array();$apids = array();

				$wowzaids = $this->Groupadmin_model->getConfigurationsDetails($userdata['userid'],$userdata['group_id']);
				if(sizeof($wowzaids)>0)
				{
					foreach($wowzaids as $wow)
					{
						array_push($wowzids,$wow['id']);
					}
				}
				$appids = $this->Groupadmin_model->getAllApplicationsByWowzaIdAndUserId($wowzids,$userdata['userid']);
				if(sizeof($appids)>0)
				{
					foreach($appids as $appidddd)
					{
						array_push($apids,$appidddd['id']);
						$locksArray[$appidddd['id']] = $appidddd['isLocked'];
					}
				}
				$data['targets'] = $this->Groupadmin_model->getAllTargetsbyWowzaAndAppid($apids,$userdata['userid']);
			}
			$this->load->view('admin/header');
			$this->load->view('admin/schedule',$data);
			$this->load->view('admin/footer');
		}
		/* Bank Lock */
		public function lockUnlockBank()
		{
			$response = array('status'=>FALSE,'response'=>array(),'message'=>"");
			$userdata = $this->session->userdata('user_data');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$action = $cleanData['action'];
			$Id = $cleanData['id'];
			if($action != "")
			{
				switch($action)
				{
					case "Lock":
					$data = array(
						'isLocked'=>1
					);
					$bankID = $this->common_model->updateBank($data,$Id);
					if($bankID >= 0)
					{
						$response['status'] = TRUE;
						$response['change'] = "Lock";
					}
					else
					{
						$response['status'] = false;
						$response['change'] = "UnLock";
					}
					break;
					case "UnLock":
					$data = array(
						'isLocked'=>0
					);
					$bankID = $this->common_model->updateBank($data,$Id);
					if($bankID >= 0)
					{
						$response['status'] = TRUE;
						$response['change'] = "UnLock";
					}
					else
					{
						$response['status'] = false;
						$response['change'] = "Lock";
					}
					break;
				}
			}
			else
			{
				$response['status'] = FALSE;
				$response['change'] = "Select At least on action";
			}
			$gatewayData = $this->getUpdatedGatewayArray();
			$bankJson = json_encode($gatewayData['bankdata']);
			$channelJson = json_encode($gatewayData['channelData']);
			$response['banks'] = $bankJson;
			$response['channelss'] = $channelJson;
			echo json_encode($response);
		}
		/* Start Stop Gateway Channels */
		public function gatewayStartStop()
		{
			$response = array('status'=>FALSE,'response'=>array(),'message'=>"");
			$userdata = $this->session->userdata('user_data');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$Id = $cleanData['id'];
			$action = $cleanData['action'];
			$channel = $this->common_model->getAllGatewayChannels($Id,0,0);
			if(sizeof($channel)>0)
			{
				$bank = $this->common_model->getAllBanks($channel[0]['bank_id'],0);
				if($channel[0]['channel_type'] == "SDI" && $channel[0]['channelOutpue'] != "")
				{
					$outputTypeArray = explode("_",$channel[0]['channelOutpue']);
					$encoder = $this->common_model->getAllEncoders($outputTypeArray[2],0);
				}
				else
				{
					$encoder = $this->common_model->getAllGateways($bank[0]['encoder_id']);
				}

				$ip =  $encoder[0]["encoder_ip"];
				$username = $encoder[0]["encoder_uname"];
				$password = $encoder[0]["encoder_pass"];
				$port = "22";
				$options = "";
				$command ="";
				if($action == "Start")
				{
					$extra = '>>iohub/logs/'.$channel[0]['process_name'].'.log 2>&1';
					switch($channel[0]["channel_type"])
					{
						case "NDI":
						$ssh = new Net_SSH2($ip);
						if (!$ssh->login($username, $password,$port)) {
							$response['status']= FALSE;
							$response['response']= $ssh->getLog();
						}
						else{
							$command = $channel[0]['channel_name'].'=>'.$action.'=>bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f libndi_newtek -i \''.$channel[0]['channel_ndi_source'].'\' -f libndi_newtek \''.$channel[0]['ndi_destination'].'\'"'.$extra;
							$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f libndi_newtek -i \''.$channel[0]['channel_ndi_source'].'\' -f libndi_newtek \''.$channel[0]['ndi_destination'].'\'"'.$extra);
						}
						$pid1 = $ssh->exec("pidof ".$channel[0]['process_name']);
						if($pid1 == "")
						{
							$this->common_model->insertLogs($channel[0]['channel_name'],'Gateway Channel',$command,$userdata['userid'],"Error");
							echo json_encode(array('status'=>FALSE, "message"=> 'Error occur while starting stream!','change'=>'stop'));
						}
						elseif($pid1 > 0)
						{
							$p = $pid1;
							$cmd = 'ps -p '.trim($p).' -o lstart=';
							$time1 = $ssh->exec($cmd);
							$this->common_model->insertLogs($channel[0]['channel_name'],'Gateway Channel',$command,$userdata['userid'],"Success");
							echo json_encode(array('status'=>TRUE, "message"=> 'Channel Start Successfully.','change'=>'start','time'=>$time1));
						}
						break;
						case "RTMP":
						$input_type = "libndi_newtek";
						$input_name = $channel[0]['channel_ndi_source'];
						$application = $this->common_model->getAppbyId($channel[0]['channel_apps']);
						$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
						$eprofile = "";
						$output_type = "flv";
						$gop ="";
						$deinterlace ="";
						$x264params="";
						$x264opts="";
						if(sizeof($encodingProfile) > 0 && $encodingProfile[0]['adv_video_gop'] != "" && $encodingProfile[0]['adv_video_gop'] != NULL)
						{
							$gop = '-g '.$encodingProfile[0]["adv_video_gop"];
						}
						if(sizeof($encodingProfile) > 0 && $encodingProfile[0]['adv_video_gop'] == 1)
						{
							$deinterlace = '-deinterlace';
						}
						if(sizeof($encodingProfile) > 0 && $encodingProfile[0]['enablezerolatency'] == 1)
						{
							$enablezerolatency = '-tune zerolatency';
						}
						//x264_params && x264opts
						if(sizeof($encodingProfile) > 0 && $encodingProfile[0]['x264_params'] != NULL)
						{
							$x264params = '-x264-params '.$encodingProfile[0]["x264_params"];
						}
						if(sizeof($encodingProfile) > 0 && $encodingProfile[0]['x264opts'] != NULL)
						{
							$x264opts = '-x264opts '.$encodingProfile[0]["x264opts"];
						}
						//eof x264_params && x264opts
						$output_name = $channel[0]["output_rtmp_url"]."/".$channel[0]["output_rtmp_key"];

						if(sizeof($encodingProfile)>0)
						{
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
								$adv_video_keyframe_intrval = '-force_key_frames \'expr:gte(t,n_forced*'.$encodingProfile[0]['adv_video_keyframe_intrval'].')\'';
							}
							if($encodingProfile[0]['adv_video_profile'] != "" && $encodingProfile[0]['adv_video_profile'] != 0)
							{
								$adv_video_profile = '-profile:v '.$encodingProfile[0]['adv_video_profile'];
							}
							if($encodingProfile[0]['video_framerate'] != "" && $encodingProfile[0]['video_framerate'] > 0)
							{
								$video_framerate = '-vf fps='.$encodingProfile[0]['video_framerate'];
							}
							$options =  '-c:v '.$encodingProfile[0]['video_codec'].' -s '.$encodingProfile[0]['video_resolution'].' -b:v '.$encodingProfile[0]['video_bitrate'].'k '.$minBitRate.' '.$maxBitRate.' '.$bufSize.' '.$adv_video_keyframe_intrval.' '.$gop.' '.$adv_video_profile.' -pix_fmt yuv420p -preset '.$encodingProfile[0]['adv_video_preset'].' '.$deinterlace.' '.$enablezerolatency.' '.$video_framerate.' -c:a '.$encodingProfile[0]['audio_codec'].' -b:a '.$encodingProfile[0]['audio_bitrate'].'k -ar '.$encodingProfile[0]['audio_sample_rate'].' -ac '.$encodingProfile[0]['audio_channel'];
						}
						else
						{
							$options =  "";
						}
						$ssh = new Net_SSH2($ip);
						if (!$ssh->login($username, $password,$port)) {
							$response['status']= FALSE;
							$response['response']= $ssh->getLog();
						}
						else
						{
							$command = $channel[0]['channel_name'].'=>'.$action.' bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -i \"'.$input_name.'\" '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"'.$extra;
							$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.'  -i \"'.$input_name.'\" '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"'.$extra);
						}
						$pid1 = $ssh->exec("pidof ".$channel[0]['process_name']);
						if($pid1 == "")
						{
							$this->common_model->insertLogs($channel[0]['channel_name'],'Gateway Channel',$command,$userdata['userid'],"Error");
							echo json_encode(array('status'=>FALSE, "message"=> 'Error occur while starting stream!','change'=>'stop'));
						}
						elseif($pid1 > 0)
						{
							$p = $pid1;
							$cmd = 'ps -p '.trim($p).' -o lstart=';
							$time1 = $ssh->exec($cmd);
							echo json_encode(array('status'=>TRUE, "message"=> 'Channel Start Successfully.','change'=>'start','time'=>$time1));
							$this->common_model->insertLogs($channel[0]['channel_name'],'Gateway Channel',$command,$userdata['userid'],"Success");
						}
						break;
						case "SRT":

						$input_type = "libndi_newtek";
						$input_name = $channel[0]['channel_ndi_source'];
						$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
						$eprofile = "";
						$output_type = "mpegts";
						$gop ="";
						$deinterlace ="";
						$x264params="";
						$x264opts="";
						$enablezerolatency="";
						if(sizeof($encodingProfile) > 0 && $encodingProfile[0]['adv_video_gop'] != "" && $encodingProfile[0]['adv_video_gop'] != NULL)
						{
							$gop = '-g '.$encodingProfile[0]["adv_video_gop"];
						}
						if(sizeof($encodingProfile) > 0 && $encodingProfile[0]['adv_video_gop'] == 1)
						{
							$deinterlace = '-deinterlace';
						}
						if(sizeof($encodingProfile) > 0 && $encodingProfile[0]['enablezerolatency'] == 1)
						{
							$enablezerolatency = '-tune zerolatency';
						}

						//x264_params && x264opts
						if(sizeof($encodingProfile) > 0 && $encodingProfile[0]['x264_params'] != NULL)
						{
							$x264params = '-x264-params '.$encodingProfile[0]["x264_params"];
						}
						if(sizeof($encodingProfile) > 0 && $encodingProfile[0]['x264opts'] != NULL)
						{
							$x264opts = '-x264opts '.$encodingProfile[0]["x264opts"];
						}
						//eof x264_params && x264opts
            
						$output_name =  "srt://".$channel[0]["srt_ip"].':'.$channel[0]['srt_port'];


						if(sizeof($encodingProfile)>0)
						{

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
								$adv_video_keyframe_intrval = '-force_key_frames \'expr:gte(t,n_forced*'.$encodingProfile[0]['adv_video_keyframe_intrval'].')\'';
							}
							if($encodingProfile[0]['adv_video_profile'] != "" && $encodingProfile[0]['adv_video_profile'] != 0)
							{
								$adv_video_profile = '-profile:v '.$encodingProfile[0]['adv_video_profile'];
							}
							if($encodingProfile[0]['video_framerate'] != "" && $encodingProfile[0]['video_framerate'] > 0)
							{
								$video_framerate = '-vf fps='.$encodingProfile[0]['video_framerate'];
							}
							$options =  '-c:v '.$encodingProfile[0]['video_codec'].' -s '.$encodingProfile[0]['video_resolution'].' -b:v '.$encodingProfile[0]['video_bitrate'].'k '.$minBitRate.' '.$maxBitRate.' '.$bufSize.' '.$adv_video_keyframe_intrval.' '.$gop.' '.$adv_video_profile.' -pix_fmt yuv420p -preset '.$encodingProfile[0]['adv_video_preset'].' '.$deinterlace.' '.$enablezerolatency.' '.$video_framerate.' -c:a '.$encodingProfile[0]['audio_codec'].' -b:a '.$encodingProfile[0]['audio_bitrate'].'k -ar '.$encodingProfile[0]['audio_sample_rate'].' -ac '.$encodingProfile[0]['audio_channel'];
						}
						else
						{
							$options =  "";
						}

						$ssh = new Net_SSH2($ip);
						if (!$ssh->login($username, $password,$port)) {
							$response['status']= FALSE;
							$response['response']= $ssh->getLog();
						}
						else
						{
							$command =  $channel[0]['channel_name'].'=>'.$action.'=> bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -i \"'.$input_name.'\" '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"'.$extra;
									$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -i \"'.$input_name.'\" '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"'.$extra);
						}
						$pid1 = $ssh->exec("pidof ".$channel[0]['process_name']);
						if($pid1 == "")
						{
							$this->common_model->insertLogs($channel[0]['channel_name'],'Gateway Channel',$command,$userdata['userid'],"Error");
							echo json_encode(array('status'=>FALSE, "message"=> 'Error occur while starting stream!','change'=>'stop'));
						}
						elseif($pid1 > 0)
						{
							$p = $pid1;
							$cmd = 'ps -p '.trim($p).' -o lstart=';
							$time1 = $ssh->exec($cmd);
							echo json_encode(array('status'=>TRUE, "message"=> 'Channel Start Successfully.','change'=>'start','time'=>$time1));
							$this->common_model->insertLogs($channel[0]['channel_name'],'Gateway Channel',$command,$userdata['userid'],"Success");
						}

						break;
						case "SDI":
						$options ="";
						$input_type = "libndi_newtek";
						$input_name = $channel[0]['channel_ndi_source'];
						$audio_channel = $channel[0]['audio_channel'];
						$output_type = "decklink";
						$outputTypeArray = explode("_",$channel[0]['channelOutpue']);

						$encoder = $this->common_model->getAllEncoders($outputTypeArray[2],0);
						$ip =  $encoder[0]["encoder_ip"];
						$username = $encoder[0]["encoder_uname"];
						$password = $encoder[0]["encoder_pass"];
						$port = "22";

						$ou = $this->common_model->getOutputName($outputTypeArray[1]);
						$output_name = $ou[0]['item'];
						$ssh = new Net_SSH2($ip);
						if (!$ssh->login($username, $password,$port)) {
							$response['status']= FALSE;
							$response['response']= $ssh->getLog();
						}
						else
						{
							$command = $channel[0]['channel_name'].'=>'.$action.'=> bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -r 25 -itsoffset -1 -i \"'.$input_name.'\" '.$options.' -ac '.$audio_channel.' -f '.$output_type.' -top 1 \''.$output_name.'\' -threads 16"'.$extra;

							$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -r 25 -itsoffset -1 -i \"'.$input_name.'\" '.$options.' -ac '.$audio_channel.' -f '.$output_type.' -top 1 \''.$output_name.'\' -threads 16"'.$extra);
						}
						$pid1 = $ssh->exec("pidof ".$channel[0]['process_name']);
						if($pid1 == "")
						{
							$this->common_model->insertLogs($channel[0]['channel_name'],'Gateway Channel',$command,$userdata['userid'],"Error");
							echo json_encode(array('status'=>FALSE, "message"=> 'Error occur while starting stream!','change'=>'stop'));
						}
						elseif($pid1 > 0)
						{
							$p = $pid1;
							$cmd = 'ps -p '.trim($p).' -o lstart=';
							$time1 = $ssh->exec($cmd);
							echo json_encode(array('status'=>TRUE, "message"=> 'Channel Start Successfully.','change'=>'start','time'=>$time1));
							$this->common_model->insertLogs($channel[0]['channel_name'],'Gateway Channel',$command,$userdata['userid'],"Success");
						}
						break;
					}
				}
				else if($action == "Stop")
				{
					$ssh = new Net_SSH2($ip);
					if (!$ssh->login($username, $password,$port)) {
						$response['status']= FALSE;
						$response['response']= $ssh->getLog();
					}
					else
					{
						$ssh->exec('pkill -f '.$channel[0]['process_name']);
						echo json_encode(array('status'=>TRUE, "message"=> 'Channel Stopped Successfully!','change'=>'stop'));
					}
				}
				else if($action == "checkstatus")
				{
					$ssh = new Net_SSH2($ip);
					if (!$ssh->login($username, $password,$port)) {
						$response['status']= FALSE;
						$response['response']= $ssh->getLog();
					}
					else
					{
						$pid = $ssh->exec("pidof ".$channel[0]['process_name']);
						if($pid == "")
						{
							echo json_encode(array('status'=>TRUE, "message"=> 'Channel Stopped','change'=>'stop'));
						}
						else
						{
							$p = $pid;
							$cmd = 'ps -p '.trim($p).' -o lstart=';
							$time1 = $ssh->exec($cmd);
							$timestamp = strtotime($time1);
							echo json_encode(array('status'=>TRUE, "message"=> 'Already Running','change'=>'start','time'=>trim($time1)));
						}
					}

				}
			}



		}
		public function getUpdatedGatewayArray()
		{
			$bankdata = array();
			$channelData = array();
			$userdata = $this->session->userdata('user_data');
			if($userdata['user_type'] == 1)
			{
				$banks = $this->common_model->getAllBanks(0,0);
			}
			elseif($userdata['user_type'] == 2 || $userdata['user_type'] == 3)
			{
				$banks = $this->common_model->getAllBanks(0,$userdata['userid']);
			}
			if(sizeof($banks)>0)            	{
				foreach($banks as $bank)
				{
					$bankdata[$bank['id']] = array('name'=>$bank['bank_name'],'isLocked'=>$bank['isLocked']);

					$channels = $this->common_model->getAllGatewayChannels(0,0,$bank['id']);
				    if(sizeof($channels)>0)
				    {
						foreach($channels as $channel)
					 	{
					 		if(!array_key_exists($channel['id'],$channelData))
					 		{
								$channelData[$channel['id']] = array();
							}
							if($bank['isLocked'] == 1)
							{
								$channelData[$channel['id']]['isLocked'] = TRUE;
							}
							else
							{
								$channelData[$channel['id']]['isLocked'] = FALSE;
							}
					 		$channelData[$channel['id']]['channel_name'] = $channel['channel_name'];
					 		$channelData[$channel['id']]['channel_type'] = $channel['channel_type'];
					 		switch($channel['channel_type'])
					 		{
								case "NDI":
								$channelData[$channel['id']]['bank_id'] = $channel['bank_id'];
								$channelData[$channel['id']]['channel_ndi_source'] = $channel['channel_ndi_source'];
								$channelData[$channel['id']]['ndi_destination'] = $channel['ndi_destination'];
								break;
								case "RTMP":
								$channelData[$channel['id']]['bank_id'] = $channel['bank_id'];
								$channelData[$channel['id']]['channel_ndi_source'] = $channel['channel_ndi_source'];
								$channelData[$channel['id']]['channel_apps'] = $channel['channel_apps'];
								$channelData[$channel['id']]['output_rtmp_url'] = $channel['output_rtmp_url'];
								$channelData[$channel['id']]['output_rtmp_key'] = $channel['output_rtmp_key'];
								$channelData[$channel['id']]['auth_uname'] = $channel['auth_uname'];
								$channelData[$channel['id']]['auth_pass'] = $channel['auth_pass'];
								$channelData[$channel['id']]['encoding_profile'] = $channel['encoding_profile'];
								break;
								case "SRT":
								$channelData[$channel['id']]['bank_id'] = $channel['bank_id'];
								$channelData[$channel['id']]['channel_ndi_source'] = $channel['channel_ndi_source'];
								$channelData[$channel['id']]['srt_ip'] = $channel['srt_ip'];
								$channelData[$channel['id']]['srt_port'] = $channel['srt_port'];
								$channelData[$channel['id']]['srt_mode'] = $channel['srt_mode'];
								$channelData[$channel['id']]['encoding_profile'] = $channel['encoding_profile'];
								break;
								case "SDI":
								$channelData[$channel['id']]['bank_id'] = $channel['bank_id'];
								$channelData[$channel['id']]['channel_ndi_source'] = $channel['channel_ndi_source'];
								$channelData[$channel['id']]['sdi_output'] = $channel['channelOutpue'];
								$channelData[$channel['id']]['audio_channel'] = $channel['audio_channel'];
								break;
							}
					 	}
					}
				}
			}
			return array('bankdata'=>$bankdata,'channelData'=>$channelData);
		}
		/* Update SDI Channel */
		public function updateGatewaySDIChannel()
		{
			$response = array('status'=>FALSE,'response'=>array(),'message'=>"");
			$userdata = $this->session->userdata('user_data');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$Id = $cleanData['id'];
			$NDI = array(
				'channel_name'=>$cleanData['channelname'],
            	'channel_ndi_source'=>$cleanData['sdi_source'],
            	'channelOutpue'=>$cleanData['sdi_output'],
            	'audio_channel'=>$cleanData['sdi_audio_channel'],
			);
			$chId = $this->common_model->updateGatewayChannel($NDI,$Id);
			if($chId >=0)
			{
				$response['status'] = TRUE;
				$response['message'] = "Update Successfully";
			}
			$gatewayData = $this->getUpdatedGatewayArray();
			$bankJson = json_encode($gatewayData['bankdata']);
			$channelJson = json_encode($gatewayData['channelData']);
			$response['banks'] = $bankJson;
			$response['channelss'] = $channelJson;
			echo json_encode($response);
		}
		/* Update SRT Channel */
		public function updateGatewaySRTChannel()
		{
			$response = array('status'=>FALSE,'response'=>array(),'message'=>"");
			$userdata = $this->session->userdata('user_data');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$Id = $cleanData['id'];
			$NDI = array(
				'channel_name'=>$cleanData['channelname'],
            	'channel_ndi_source'=>$cleanData['srt_source'],
            	'srt_ip'=>$cleanData['srt_ip'],
            	'srt_port'=>$cleanData['srt_port'],
            	'srt_mode'=>$cleanData['srt_mode'],
            	'encoding_profile'=>$cleanData['srt_encoding_profile'],
			);
			$chId = $this->common_model->updateGatewayChannel($NDI,$Id);
			if($chId >=0)
			{
				$response['status'] = TRUE;
				$response['message'] = "Update Successfully";
			}
			$gatewayData = $this->getUpdatedGatewayArray();
			$bankJson = json_encode($gatewayData['bankdata']);
			$channelJson = json_encode($gatewayData['channelData']);
			$response['banks'] = $bankJson;
			$response['channelss'] = $channelJson;
			echo json_encode($response);
		}
		/* Update RTMP Channel */
		public function updateGatewayRTMPChannel()
		{
			$response = array('status'=>FALSE,'response'=>array(),'message'=>"");
			$userdata = $this->session->userdata('user_data');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$Id = $cleanData['id'];
			$NDI = array(
				'channel_name'=>$cleanData['channelname'],
            	'channel_ndi_source'=>$cleanData['rtmp_ndi_source'],
            	'channel_apps'=>$cleanData['rtmp_apps'],
            	'output_rtmp_url'=>$cleanData['rtmp_url'],
            	'output_rtmp_key'=>$cleanData['rtmp_key'],
            	'auth_uname'=>$cleanData['gateway_auth_uname'],
            	'auth_pass'=>$cleanData['gateway_auth_pass'],
            	'encoding_profile'=>$cleanData['rtmp_encoding_profile'],
			);
			$chId = $this->common_model->updateGatewayChannel($NDI,$Id);
			if($chId >=0)
			{
				$response['status'] = TRUE;
				$response['message'] = "Update Successfully";
			}
			$gatewayData = $this->getUpdatedGatewayArray();
			$bankJson = json_encode($gatewayData['bankdata']);
			$channelJson = json_encode($gatewayData['channelData']);
			$response['banks'] = $bankJson;
			$response['channelss'] = $channelJson;
			echo json_encode($response);
		}
		/* Update Gateway Channel*/
		public function updateGatewayChannel()
		{
			$response = array('status'=>FALSE,'response'=>array(),'message'=>"");
			$userdata = $this->session->userdata('user_data');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$Id = $cleanData['id'];
			$NDI = array(
            	'channel_ndi_source'=>$cleanData['sourcename'],
            	'ndi_destination'=>$cleanData['sourcename'].'_VR'
			);
			$chId = $this->common_model->updateGatewayChannel($NDI,$Id);
			if($chId >=0)
			{
				$response['status'] = TRUE;
				$response['message'] = "Update Successfully";
			}
			$gatewayData = $this->getUpdatedGatewayArray();
			$bankJson = json_encode($gatewayData['bankdata']);
			$channelJson = json_encode($gatewayData['channelData']);
			$response['banks'] = $bankJson;
			$response['channelss'] = $channelJson;
			echo json_encode($response);
		}
		public function updateBankNameOnly()
		{
			$response = array('status'=>FALSE,'response'=>array(),'message'=>"");
			$userdata = $this->session->userdata('user_data');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$Id = $cleanData['id'];
			$bankData = array(
				'bank_name'=>$cleanData['bankname']
			);
			$bankID = $this->common_model->updateBank($bankData,$Id);
			if($bankID >=0)
			{
				$response['status'] = TRUE;
				$response['message'] = "Update Successfully";
			}
			$gatewayData = $this->getUpdatedGatewayArray();
			$bankJson = json_encode($gatewayData['bankdata']);
			$channelJson = json_encode($gatewayData['channelData']);
			$response['banks'] = $bankJson;
			$response['channelss'] = $channelJson;

			echo json_encode($response);
		}
		/* Update Bank Name */
		public function updateBankName()
		{
			$response = array('status'=>FALSE,'response'=>array(),'message'=>"");
			$userdata = $this->session->userdata('user_data');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$Id = $cleanData['id'];
			$bankData = array(
				'bank_name'=>$cleanData['bankname'],
				'encoder_id'=>$cleanData['endoerId'],
				'banksource'=>$cleanData['name'],
			);
			$bankID = $this->common_model->updateBank($bankData,$Id);
			$channels = $this->common_model->getAllGatewayChannels(0,0,$Id);
			if(sizeof($channels)>0)
			{
				foreach($channels as $channel)
				{
					$encoder = $this->common_model->getAllGateways($cleanData['endoerId'],0);
					$NDI = array(
						'channel_name'=>$cleanData['bankname'].'_'.$channel['channel_type']
					);
					if($channel['channel_type'] == "NDI")
					{
						$NDI['channel_ndi_source'] = $cleanData['name'];
					}
					else
					{
						preg_match('#\((.*?)\)#', $cleanData['name'], $match);
						$NDI['channel_ndi_source'] = $encoder[0]['encoder_name'].' ('.$match[1].'_VR)';
					}
					if($channel['channel_type'] == "NDI")
					{
						preg_match('#\((.*?)\)#', $cleanData['name'], $match);
						$NDI['ndi_destination'] = $match[1].'_VR';
					}
					$chId = $this->common_model->updateGatewayChannel($NDI,$channel['id']);
				}
			}
			if($bankID >=0)
			{
				$response['status'] = TRUE;
				$response['message'] = "Update Successfully";
			}
			$gatewayData = $this->getUpdatedGatewayArray();
			$bankJson = json_encode($gatewayData['bankdata']);
			$channelJson = json_encode($gatewayData['channelData']);
			$response['banks'] = $bankJson;
			$response['channelss'] = $channelJson;

			echo json_encode($response);
		}
		public function createGatewayChannel()
		{
			$response = array('status'=>FALSE,'response'=>array(),'message'=>"");
			$userdata = $this->session->userdata('user_data');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$apps =0;$encid =0;
			if($cleanData['channel_apps'] != "")
			{
				$apps = $cleanData['channel_apps'];
			}

			if($cleanData['encoding_profile'] == "")
			{
				$encodingProfile = 0;
			}
			else
			{
				$encodingProfile = $cleanData['encoding_profile'];
			}
			$choup = $cleanData['channelOutpue'];
			$chnnT = explode("_",$choup);
			$type = "";
			if($chnnT[0] == "phyoutput")
			{
				$type = "SDI";
			}
			elseif($chnnT[0] == "viroutput")
			{
				switch($chnnT[1])
				{
					case "3":
					$type = "NDI";
					break;
					case "4":
					$type = "RTMP";
					break;
					case "7":
					$type = "SRT";
					break;
				}
			}


			$NDI = array(
				'uid'=>$userdata['userid'],
				'bank_id'=>$cleanData['bankId'],
            	'channel_name'=>$cleanData['channelName'],
            	'encoder_id'=>0,
            	'channel_type'=>$type,
            	'channel_ndi_source'=>$cleanData['channel_ndi_source'],
            	'channelOutpue'=>$cleanData['channelOutpue'],
            	'ndi_destination'=>$cleanData['ndi_destination'],
            	'channel_apps'=>$apps,
            	'output_rtmp_url'=>$cleanData['output_rtmp_url'],
            	'output_rtmp_key'=>$cleanData['output_rtmp_key'],
            	'auth_uname'=>$cleanData['auth_uname'],
            	'auth_pass'=>$cleanData['auth_pass'],
            	'srt_ip'=>$cleanData['srt_ip'],
            	'srt_port'=>$cleanData['srt_port'],
            	'srt_mode'=>$cleanData['srt_mode'],
            	'encoding_profile'=>$encodingProfile,
            	'audio_channel'=>$cleanData['audio_channel'],
            	'status'=>1,
            	'created'=>time(),
            	'process_name'=>'CH'.$this->random_string(10)
			);
			$banks = $this->common_model->getAllBanks($cleanData['bankId'],0);
			$encoder = $this->common_model->getAllGateways($banks[0]['encoder_id'],0);
			if($type == "NDI")
			{
				$NDI['channel_ndi_source'] = $banks[0]['banksource'];
			}
			else
			{
				preg_match('#\((.*?)\)#', $banks[0]['banksource'], $match);
				$NDI['channel_ndi_source'] = $encoder[0]['encoder_name'].' ('.$match[1].'_VR)';
			}
			if($type == "NDI")
			{
				preg_match('#\((.*?)\)#', $banks[0]['banksource'], $match);
				$NDI['ndi_destination'] = $match[1].'_VR';
			}
			$NDIId = $this->common_model->insertGatewayChannel($NDI);

			if($NDIId > 0)
			{
				$response['status'] = TRUE;
				$response['message'] = $NDIId;
				$gatewayData = $this->getUpdatedGatewayArray();
				$bankJson = json_encode($gatewayData['bankdata']);
				$channelJson = json_encode($gatewayData['channelData']);
				$response['banks'] = $bankJson;
				$response['channelss'] = $channelJson;
			}
			else
			{
				$response['message'] = "Error Occured while creating channel";
			}

			echo json_encode($response);
		}
		/* Delete Gateway Channel */
		public function deletGatewayChannel()
		{
			$response = array('status'=>FALSE,'response'=>array(),'message'=>"");
			$userdata = $this->session->userdata('user_data');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$NDIId = $this->common_model->deletGatewayChannel($cleanData['id']);
			if($NDIId > 0)
			{
				$response['status'] = TRUE;
				$response['message'] = "Deleted Successfully";
			}
			else
			{
				$response['message'] = "Error Occured while creating channel";
			}
			echo json_encode($response);
		}
		/* Delete bank */
		public function deletBank()
		{
			$response = array('status'=>FALSE,'response'=>array(),'message'=>"");
			$userdata = $this->session->userdata('user_data');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$channels = $this->common_model->getAllGatewayChannels(0,0,$cleanData['id']);
			if(sizeof($channels)>0)
			{
				foreach($channels as $channel)
				{
					$this->common_model->deletGatewayChannel($channel['id']);
				}
			}
			$NDIId = $this->common_model->deletBank($cleanData['id']);
			if($NDIId > 0)
			{
				$response['status'] = TRUE;
				$response['message'] = "Deleted Successfully";
			}
			else
			{
				$response['message'] = "Error Occured while creating channel";
			}
			echo json_encode($response);
		}
		/* Create bank */
		public function createBank()
		{
			$bankID =0;
			$response = array('status'=>FALSE,'response'=>array(),'message'=>"");
			$userdata = $this->session->userdata('user_data');
			$bankData = array(
				'bank_name'=>'EmptyBank',
				'uid'=>$userdata['userid'],
				'created'=>time(),
				'status'=>1
			);
			$bankID = $this->common_model->insertBank($bankData);
			if($bankID > 0)
			{
				$NDI = array(
					'uid'=>$userdata['userid'],
					'bank_id'=>$bankID,
                	'channel_name'=>"NDI",
                	'channel_type'=>'NDI',
                	'encoder_id'=>0,
                	'channelInput'=>"",
                	'channel_ndi_source'=>"",
                	'channelOutpue'=>"",
                	'channel_apps'=>0,
                	'encoding_profile'=>0,
                	'status'=>0,
                	'created'=>time(),
                	'process_name'=>'CH'.$this->random_string(10)
				);
				$NDIId = $this->common_model->insertGatewayChannel($NDI);
				$RTMP = array(
					'uid'=>$userdata['userid'],
					'bank_id'=>$bankID,
                	'channel_name'=>"RTMP",
                	'channel_type'=>'RTMP',
                	'encoder_id'=>0,
                	'channelInput'=>"",
                	'channel_ndi_source'=>"",
                	'channelOutpue'=>"",
                	'channel_apps'=>0,
                	'encoding_profile'=>0,
                	'status'=>0,
                	'created'=>time(),
                	'process_name'=>'CH'.$this->random_string(10)
				);
				$RtmpId = $this->common_model->insertGatewayChannel($RTMP);
				$SRT = array(
					'uid'=>$userdata['userid'],
					'bank_id'=>$bankID,
                	'channel_name'=>"SRT",
                	'channel_type'=>'SRT',
                	'encoder_id'=>0,
                	'channelInput'=>"",
                	'channel_ndi_source'=>"",
                	'channelOutpue'=>"",
                	'channel_apps'=>0,
                	'encoding_profile'=>0,
                	'status'=>0,
                	'created'=>time(),
                	'process_name'=>'CH'.$this->random_string(10)
				);
				$SRTId = $this->common_model->insertGatewayChannel($SRT);
				$REC = array(
					'uid'=>$userdata['userid'],
					'bank_id'=>$bankID,
                	'channel_name'=>"SDI",
                	'channel_type'=>'SDI',
                	'encoder_id'=>0,
                	'channelInput'=>"",
                	'channel_ndi_source'=>"",
                	'channelOutpue'=>"",

                	'channel_apps'=>0,
                	'encoding_profile'=>0,
                	'status'=>0,
                	'created'=>time(),
                	'process_name'=>'CH'.$this->random_string(10)
				);
				$RECId = $this->common_model->insertGatewayChannel($REC);
				$response['status'] = TRUE;
				$response['response']['bankId'] = $bankID;
				$response['response']['ndiId'] = $NDIId;
				$response['response']['rtmpId'] = $RtmpId;
				$response['response']['srtId'] = $SRTId;
				$response['response']['recId'] = $RECId;
				$response['message'] = "Bank Created Successfully!";
				$gatewayData = $this->getUpdatedGatewayArray();
				$bankJson = json_encode($gatewayData['bankdata']);
				$channelJson = json_encode($gatewayData['channelData']);
				$response['banks'] = $bankJson;
				$response['channelss'] = $channelJson;
			}
			else
			{
				$response['status'] = FALSE;
				$response['message'] = "Error occured while creating bank!";
			}
			echo json_encode($response);
		}
		function array_search_partial($arr, $keyword) {
		    foreach($arr as $index => $string) {
		        if (strpos($string, $keyword) !== FALSE)
		            return $index;
		    }
		}
		public function extractSources()
		{
			$response = array('status'=>FALSE,'response'=>array());
			$source = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$resp = array();
			$encoders = $this->common_model->getAllGateways($source['encid'],0);
			$ip = $encoders[0]['encoder_ip'];
			$username = $encoders[0]['encoder_uname'];
			$password = $encoders[0]['encoder_pass'];
			$port = $encoders[0]['encoder_port'];


			$random = $this->random_string(10);
			$name = str_replace(" ","_",$source['src']);
			$name = str_replace("(","_",$name);
			$name = str_replace(")","_",$name);
			$name = $random."__".$name."_".date('Y_m_d_h_i_s');
			$name = $name.'.png';
			$src = $source['src'];
			$ssh = new Net_SSH2($ip);
			if($ssh->login($username, $password,$port)) {

				$out = $ssh->exec('ffmpeg -f libndi_newtek -i "'.$src.'" -vf  "scale=85:45" -vframes 1 tmp/img/'.$name);
				$resp = explode("\n",$out);
				$response['data'] = array('src'=>$src,'name'=>$name,'out'=>$out);
			}
			$path = 'public/site/main/tmp/images/'.$response['data']['name'];
			if(file_exists($path))
			{
				$indexFirst = $this->array_search_partial($resp,"Audio: ");
				$response['data']['isExist'] = TRUE;

				$v = str_replace("Stream #0:","",$resp[$indexFirst+1]);
				$vid = explode(",",$v);

				$a = str_replace("Stream #0:","",$resp[$indexFirst]);
				$aud = explode("Audio:",$a);

				$response['data']['Audio'] = "Audio: " .$aud[1];
				$response['data']['Video'] = "Video: " .$vid[1] . ", " . $vid[2]. ", ". str_replace("tbr","FPS",$vid[4]);
			}
			else
			{
				$response['data']['isExist'] = FALSE;
				$response['data']['Audio'] = "Audio: N/A";
				$response['data']['Video'] = "Video: N/A";
			}


			echo json_encode($response);
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
									//$name = $name;
									//echo $ipport[0].'__';
									//echo $ip."\n";
									if($ipport[0] == $ip)
									{
										//$ssh->setTimeout(7);
									//	$out = $ssh->exec('ffmpeg -f libndi_newtek -i "'.$node[1].'" -vf  "thumbnail,scale=85:45" -vframes 1 tmp/img/'.$name);
										$ndiArray[] = array('isLocal'=>TRUE,'encoderId'=>$encoder['id'],'encname'=>$encoder['encoder_name'],'ndiname'=>$node[1],'euname'=>$username,'epass'=>$password,'port'=>$port,'sourceIP'=>$node[3],"fname"=>$name.".png","nn"=>$name);

									}
									else
									{
										//$ssh->setTimeout(7);
										//$out = $ssh->exec('ffmpeg -f libndi_newtek -i "'.$node[1].'" -vf  "thumbnail,scale=85:45" -vframes 1 tmp/img/'.$name);
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
		/* Gateways List page */
		public function gateway()
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
		/* Gateways List page */
		public function addgateways()
		{
			$this->breadcrumbs->push('Configuration/New Gateway', '/configuration');
			$permissions = $this->session->userdata('user_permissions');
			if($permissions['create_gateway'] <= 0)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', "You are not authorized to add Gateway.");
				redirect('configuration');
			}
			elseif($permissions['create_gateway'] == 1)
			{
				$userdata = $this->session->userdata('user_data');
				$data['userdata'] = $this->session->userdata('user_data');
				if($userdata['user_type'] == 1)
				{
					$data['groups'] = $this->common_model->getGroups(0);
				}
				else
				{
					$data['groups'] = $this->common_model->getGroups($userdata['userid']);
				}
				$this->load->view('admin/header');
				$this->load->view('admin/creategateway',$data);
				$this->load->view('admin/footer');
			}
		}
		/* Save Gateways */
		public function saveGateway()
		{
			try{
				$this->form_validation->set_rules('encoder_name', 'Encoder Name', 'required');
				$this->form_validation->set_rules('encoder_ip', 'Encoder IP Address', 'required');
				$this->form_validation->set_rules('encoder_port', 'Encoder Port', 'required');
				$this->form_validation->set_rules('encoder_uname', 'Encoder Username', 'required');
				$this->form_validation->set_rules('encoder_pass', 'Encoder Password', 'required');
				$post     = $this->input->post();
				$actual_link =  $_SERVER['HTTP_REFERER'];
				if ($this->form_validation->run() == FALSE) {
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', validation_errors());
					redirect($actual_link);
				}
				else
				{
					$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
					$userdata = $this->session->userdata('user_data');
					$groupid = 0;
					if($userdata['user_type'] == 1)
					{
						$groupid = $cleanData['encoder_group'];
					}
					else
					{
						$groupid = $userdata['group_id'];
					}
					$encoderData = array(
						'uid'=>$userdata['userid'],
						'encoder_id'=>'GATE-ENC-'.$this->random_stringid(12),
	                	'encoder_name'=>$cleanData['encoder_name'],
	                	'encoder_ip'=>$cleanData['encoder_ip'],
	                	'encoder_port'=>$cleanData['encoder_port'],
	                	'encoder_uname'=>$cleanData['encoder_uname'],
	                	'encoder_pass'=>$cleanData['encoder_pass'],
	                	'encoder_group'=>$groupid,
	                	'created'=>time()
					);
					$id = $this->common_model->insertGateway($encoderData);
					if($id > 0)
					{
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Gateway is sucessfully cretaed!');
						redirect('admin/addgateways');
					}
					else
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error occur while creating gateway!');
						redirect('admin/addgateways');
					}
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while adding gateway!');
				redirect('admin/addgateways');
			}
		}
		/* Edit Gateway */
		public function editGateway()
		{
			$this->breadcrumbs->push('Configuration/Edit Gateway', '/configuration');
			$id = $this->uri->segment(2);
			$userdata =$this->session->userdata('user_data');
			$userdata = $this->session->userdata('user_data');
			$data['userdata'] = $this->session->userdata('user_data');
			if($userdata['user_type'] == 1)
			{
				$data['groups'] = $this->common_model->getGroups(0);
			}
			else
			{
				$data['groups'] = $this->common_model->getGroups($userdata['userid']);
			}

			$data['gateway'] = $this->common_model->getAllGateways($id);
			$this->load->view('admin/header');
			$this->load->view('admin/editgateway',$data);
			$this->load->view('admin/footer');
		}
		/* Update Gateway */
		public function updateGateway()
		{
			try{
				$permissions = $this->session->userdata('user_permissions');
				if($permissions['edit_gateway'] <= 0)
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', "You are not authorized to edit Gateway.");
					redirect('configuration');
				}
				elseif($permissions['edit_gateway'] == 1)
				{
					$this->form_validation->set_rules('encoder_name', 'Encoder Name', 'required');
					$this->form_validation->set_rules('encoder_ip', 'Encoder IP Address', 'required');
					$this->form_validation->set_rules('encoder_port', 'Encoder Port', 'required');
					$this->form_validation->set_rules('encoder_uname', 'Encoder Username', 'required');
					$this->form_validation->set_rules('encoder_pass', 'Encoder Password', 'required');
					$this->form_validation->set_rules('encoder_group', 'Encoder Group', 'required');
					$post     = $this->input->post();
					$actual_link =  $_SERVER['HTTP_REFERER'];
					if ($this->form_validation->run() == FALSE) {
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', validation_errors());
						redirect($actual_link);
					}
					else
					{
						$userdata = $this->session->userdata('user_data');
						$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
						$groupid =0;
						if($userdata['user_type'] == 1)
						{
							$groupid = $cleanData['encoder_group'];
						}
						else
						{
								$groupid = $userdata['group_id'];
						}
						$encoderData = array(
							'uid'=>$userdata['userid'],
		                	'encoder_name'=>$cleanData['encoder_name'],
		                	'encoder_ip'=>$cleanData['encoder_ip'],
		                	'encoder_port'=>$cleanData['encoder_port'],
		                	'encoder_uname'=>$cleanData['encoder_uname'],
		                	'encoder_pass'=>$cleanData['encoder_pass'],
		                	'encoder_group'=>$groupid
						);
						$id = $this->common_model->updateGateway($encoderData,$cleanData['encoderId']);
						if($id >= 0)
						{
							$this->session->set_flashdata('message_type', 'success');
							$this->session->set_flashdata('success', 'Gateway is sucessfully updated!');
							redirect('configuration');
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'Error occur while updating gateway!');
							redirect('configuration');
						}
					}
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while updating gateway!');
				redirect('configuration');
			}
		}
		/* Delete Gateway */
		public function gatewayssdelete()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$encoderId = $cleanData['encodersId'];
			$idArray = explode('_',$encoderId);

			$sts = $this->common_model->deleteGateways($idArray[1]);
			if($sts)
			{
				$response['status'] = TRUE;
				$response['response'] = "Deleted Successfully!";
			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = "Error occure while deleting gateway!";
			}
			echo json_encode($response);

		}
		/* Reboot Gateway */
		public function gatewayReboot()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$wid = explode("_",$cleanData['wowzaId']);
			$encoder = $this->common_model->getAllGateways($wid[1],0);
			$ip = $encoder[0]["encoder_ip"];
			$username = $encoder[0]["encoder_uname"];
			$password = $encoder[0]["encoder_pass"];
			$port = "22";
			$ssh = new Net_SSH2($ip);
			if (!$ssh->login($username, $password,$port)) {
				$response['response'][$wid[1]] = array('status'=>TRUE,'response'=>$ssh->getLog());
			}
			else
			{
				$ssh->exec("echo ".$password." | sudo -S reboot");
				$response['response'][$wid[1]] = array('status'=>TRUE,'response'=>"Reboot Successfully!");
			}
			echo json_encode($response);
		}
		public function gatewayRefresh()
		{
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$wid = explode("_",$cleanData['wowzaId']);
			$encoder = $this->common_model->getAllGateways($wid[1],0);
			$ip = $encoder[0]["encoder_ip"];
			$username = $encoder[0]["encoder_uname"];
			$password = $encoder[0]["encoder_pass"];
			$port = "22";
			if (!$socket = @fsockopen("$ip", 22, $errno, $errstr, 2))
			{
				$response['response'][$wid[1]] = array('status'=>FALSE,'response'=>"fail");
			}
			else
			{
				$response['response'][$wid[1]] =  array('status'=>TRUE,'response'=>"success");
			 	fclose($socket);
			}
			echo json_encode($response);
		}
		/* gateway Actions */
		public function gatewayActions()
		{
			$sts = FALSE;
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$encid = $cleanData['id'];
			$action = $cleanData['action'];

			switch($action){
				case "Refresh":
				if(sizeof($encid)>0)
				{
					$response['response']= array();
					foreach($encid as $wid)
					{
						$encoder = $this->common_model->getAllGateways($wid,0);
						$ip = $encoder[0]["encoder_ip"];
						$username = $encoder[0]["encoder_uname"];
						$password = $encoder[0]["encoder_pass"];
						$port = "22";
						if (!$socket = @fsockopen("$ip", 22, $errno, $errstr, 2))
						{
							$response['response'][$wid] = array('status'=>FALSE,'response'=>"fail");
						}
						else
						{
							$response['response'][$wid] =  array('status'=>TRUE,'response'=>"success");
						 	fclose($socket);
						}
					}
				}
				break;
				case "Reboot":
				if(sizeof($encid)>0)
				{
					foreach($encid as $wid)
					{
						$encoder = $this->common_model->getAllGateways($wid,0);
						$ip = $encoder[0]["encoder_ip"];
						$username = $encoder[0]["encoder_uname"];
						$password = $encoder[0]["encoder_pass"];
						$port = "22";
						$ssh = new Net_SSH2($ip);
						if (!$ssh->login($username, $password,$port)) {
							$response['response'][$wid] = array('status'=>TRUE,'response'=>$ssh->getLog());
						}
						else
						{
							$resp = $ssh->exec("sudo reboot");
							$response['response'][$wid] = array('status'=>TRUE,'response'=>"Reboot Successfully!");
						}
					}
				}
				break;
				case "Delete":
				if(sizeof($encid)>0)
				{
					foreach($encid as $wid)
					{
						$sts = $this->common_model->deleteGateways($wid);
						if($sts >0)
						{
							$response['response'][$wid] = array('status'=>TRUE,'response'=>"Delete Successfully!");
						}
						else
						{
							$response['response'][$wid] = array('status'=>FALSE,'response'=>"Error Occured While Deleting!");
						}
					}
				}
				break;
				case "TakeOffline":
				if(sizeof($encid)>0)
				{
					foreach($encid as $wid)
					{
						$dat = array(
							'status'=>2
						);
						$sts = $this->common_model->updateGateway($dat,$wid);
						if($sts >0)
						{
							$response['response'][$wid] = array('status'=>TRUE,'response'=>"Update Successfully!");
						}
						else
						{
							$response['response'][$wid] = array('status'=>FALSE,'response'=>"Error Occured While Updating!");
						}
					}
				}
				break;
				case "BringOnline":
				if(sizeof($encid)>0)
				{
					foreach($encid as $wid)
					{
						$dat = array(
							'status'=>1
						);
						$sts = $this->common_model->updateGateway($dat,$wid);
						if($sts >0)
						{
							$response['response'][$wid] = array('status'=>TRUE,'response'=>"Update Successfully!");
						}
						else
						{
							$response['response'][$wid] = array('status'=>FALSE,'response'=>"Error Occured While Updating!");
						}
					}
				}
				break;
			}

			echo json_encode($response);
		}
		public function getarchiveTargets()
		{
			$vars = $this->input->post(NULL,TRUE);
			$userdata = $this->session->userdata('user_data');
			if($userdata['user_type'] == 1)
			{
				$result = $this->common_model->getAllArchiveTargets(0,$vars);
				$totalResult = $this->common_model->getAllTotalArchiveTargets(0,$vars);
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
				$appids = $this->Groupadmin_model->getAllApplicationsByWowzaIdAndUserId($wowzids,$userdata['userid']);
				if(sizeof($appids)>0)
				{
					foreach($appids as $appidddd)
					{
						array_push($apids,$appidddd['id']);
					}
				}
				$result = $this->Groupadmin_model->getAllArchiveTargetsbyWowzaAndAppid($apids,$userdata['userid'],$vars);
				$totalResult = $this->Groupadmin_model->getAllTotalArchiveTargetsbyWowzaAndAppid($apids,$userdata['userid']);
			}

			$response = array();
			if(!empty($result))
			{
				$counter = 1;
				foreach($result as $r)
				{
				//print_r($r);
					$output= array();
					$output[] = "<div class='boxes'><input type='checkbox' id='archiveTar_".$r['id']."' class='selectArchTar'/><label for='archiveTar_".$r['id']."'></label></div>";;
					$output[] = $counter;
					$output[] = $r['target_name'];
					$output[] = $r['streamurl'];
					$output[] = $r['target'];
					$u = $this->common_model->getUserDetails($r['uid']);
			       	$output[] = $u[0]['fname'];
			       	$apid = $r['wowzaengin'];
					$appstatus = $this->common_model->getAppbyId($apid);
					if(sizeof($appstatus) > 0)
					{
						if($appstatus[0]['status'] == 0)
						{
							$output[] = '<a class="archTargetRestore" href="Javascript:void(0);"><i class="fa fa-undo"><i class="fa fa-ban" id="nested"></i></i></a>';
						}
						elseif($appstatus[0]['status'] == 1)
						{
							$output[] = '<a class="archTargetRestore" data-toggle="tooltip" title="Restore" id="id_'.$r['id'].'" href="Javascript:void(0);"><i class="fa fa-undo"></i></a>';
						}
					}
					else
					{
						$output[] = '<a class="archTargetRestore" href="Javascript:void(0);"><i class="fa fa-undo"><i class="fa fa-ban" id="nested"></i></i></a>';
					}
					$output[] = '<a class="targetArchiveDel" data-toggle="tooltip" title="Delete" id="id_'.$r['id'].'" href="javascript:void(0);"><i class="fa fa-trash"></i></a>';
					$response[] = $output;
					$counter++;
				}
			}
			$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
			$returnJson['recordsTotal'] = $totalResult[0]['total'];
			$returnJson['recordsFiltered'] = $totalResult[0]['total'];
			$returnJson['data'] = $response;
			echo json_encode($returnJson,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
		}
		public function getarchiveApps()
		{
			$vars = $this->input->post(NULL,TRUE);
			$userdata = $this->session->userdata('user_data');
			if($userdata['user_type'] == 1)
			{
				$result = $this->common_model->getAllArchiveApplications(0,$vars);
				$totalResult = $this->common_model->getAllTotalArchiveApplications(0);
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
				$result = $this->Groupadmin_model->getAllArchiveApplicationsByWowzaIdAndUserId($wowzids,$userdata['userid'],$vars);
				$totalResult = $this->Groupadmin_model->getAllTotalArchiveApplicationsByWowzaIdAndUserId($wowzids,$userdata['userid']);
			}

			$response = array();
			if(!empty($result))
			{
				$counter = 1;
				foreach($result as $r)
				{
					$output= array();
					$output[] = "<div class='boxes'><input type='checkbox' id='arvhiveApps_".$r['id']."' class='selectarchApps'/><label for='arvhiveApps_".$r['id']."'></label></div>";
					$output[] = $counter;
					$output[] = $r['application_name'];
					$output[] = $r['wowza_path'];
					$u = $this->common_model->getUserDetails($r['uid']);
			       	$output[] = $u[0]['fname'];
			       	$output[] = '<a data-toggle="tooltip" title="Restore" id="id_'.$r['id'].'" class="archAppRestore" href="Javascript:void(0);"><i class="fa fa-undo"></i></a>';
					$output[] = '<a class="appArchiveDel" data-toggle="tooltip" title="Delete" id="id_'.$r['id'].'" href="javascript:void(0);"><i class="fa fa-trash"></i></a>';

					$response[] = $output;
					$counter++;
				}
			}
			$returnJson['draw'] = isset($vars['draw']) ? $vars['draw'] : 0;
			$returnJson['recordsTotal'] = $totalResult[0]['total'];
			$returnJson['recordsFiltered'] = $totalResult[0]['total'];
			$returnJson['data'] = $response;
			echo json_encode($returnJson);
		}
		public function getarchiveChannels111()
		{
			$userdata = $this->session->userdata('user_data');
			if($userdata['user_type'] == 1)
			{
				$channels = $this->common_model->getArchiveChannels(0);

			}
			elseif($userdata['user_type'] == 2 || $userdata['user_type'] == 3)
			{
				$idsss = array($userdata['group_id']);
				$useids = $this->common_model->getUsersByGroupIds($idsss);
				$USERidS = array();
				if(sizeof($useids)>0)
				{
					foreach($useids as $u)
					{
						array_push($USERidS,$u['id']);
					}
				}
				$channels = $this->common_model->getAllArchiveChannelsByUserids($USERidS);
			}
			$vars = $this->input->get();

			$table = 'ks_channels';
			$primaryKey = 'id';
			$columns = array(
				array(
			        'db' => 'id',
			        'dt' => 'DT_RowId',
			        'formatter' => function( $d, $row ) {
			            // Technically a DOM id cannot start with an integer, so we prefix
			            // a string. This can also be useful if you have multiple tables
			            // to ensure that the id is unique with a different prefix
			            return 'row_'.$d;
			        }
			    ),
			    array( 'db' => 'channel_name', 'dt' => 'channel_name' ),
			    array( 'db' => 'process_name', 'dt' => 'process_name' ),
				array(
			        'db'        => 'uid',
			        'dt'        => 'uid',
			        'formatter' => function( $d, $row ) {
			        	$u = $this->common_model->getUserDetails($d);
			            return $u[0]['fname'];
			        }
			    ),


			);
			// SQL server connection information
			$sql_details = array(
			    'user' => $this->db->username,
			    'pass' => $this->db->password,
			    'db'   => $this->db->database,
			    'host' => $this->db->hostname
			);

			$returnJson = SSP::archive( $_GET, $sql_details, $table, $primaryKey, $columns );


			if(sizeof($returnJson['data'])>0)
			{
				$counter = $vars['start'] + 1;
				foreach($returnJson['data'] as $key=>$data)
				{
					$returnJson['data'][$key]['channel_name'] = utf8_encode($returnJson['data'][$key]['channel_name']);
					$returnJson['data'][$key]['checkbox'] = "<div class='boxes'><input type='checkbox' id='log_".$returnJson['data'][$key]['DT_RowId']."' class='selectarchive'/><label for='log_".$returnJson['data'][$key]['DT_RowId']."'></label></div>";
					$returnJson['data'][$key]['counter'] = $counter;
					$returnJson['data'][$key]['delete'] = '<a class="channelArchiveDel" data-toggle="tooltip" title="Delete" id="'.$returnJson['data'][$key]['DT_RowId'].'" href="javascript:void(0);"><i class="fa fa-trash"></i></a>';
					$returnJson['data'][$key]['restore'] = '<a data-toggle="tooltip" title="Restore" id="'.$returnJson['data'][$key]['DT_RowId'].'" class="archChannelRestore" href="Javascript:void(0);"><i class="fa fa-undo"></i></a>';
					$counter++;
				}
			}
			echo json_encode($returnJson,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);

		}
		public function archive()
		{
			$this->breadcrumbs->push('Archive', '/archive');
			$this->load->view('admin/header');
			$this->load->view('admin/archive');

			$this->load->view('admin/footer');
		}
		public function logs()
		{
			$this->breadcrumbs->push('Logs', '/logs');
			$segment = $this->uri->segment(3);
			$this->load->view('admin/header');
			$this->load->view('admin/logs');
			$this->load->view('admin/footer');
		}
		public function clearlogs()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$logids = $cleanData['id'];
			if(sizeof($logids)>0)
			{
				foreach($logids as $lid)
				{
					$sts = $this->common_model->deleteLogs($lid);
					if($sts > 0)
					{
						$response['status'] = TRUE;
						$response['response'][$lid]['status'] = TRUE;
						$response['response'][$lid]['response'] = "Deleted Successfully!";
					}
					else
					{
						$response['response'][$lid]['status'] = FALSE;
						$response['response'][$lid]['response'] = "Error occure while deleting logs!";
					}
				}
			}
			echo json_encode($response);
		}
		public function getlogs()
		{
			$vars = $this->input->get();

			$table = 'ks_logs';
			$primaryKey = 'id';
			$columns = array(
				array(
			        'db' => 'id',
			        'dt' => 'DT_RowId',
			        'formatter' => function( $d, $row ) {
			            // Technically a DOM id cannot start with an integer, so we prefix
			            // a string. This can also be useful if you have multiple tables
			            // to ensure that the id is unique with a different prefix
			            return 'row_'.$d;
			        }
			    ),
			    array( 'db' => 'log_type', 'dt' => 'log_type' ),


			    array(
			        'db'        => 'created',
			        'dt'        => 'created',
			        'formatter' => function( $d, $row ) {
			            return date( 'd-m-y H:i:s', $d);
			        }
			    ),
			      array( 'db' => 'message',  'dt' => 'message',
			    'formatter' => function( $d, $row ) {
			            return '<span class="code">'.utf8_encode($d).'</span>';
			        }
			        ),
			     array(
			        'db'        => 'uid',
			        'dt'        => 'uid',
			        'formatter' => function( $d, $row ) {
			        	if($d == 0)
			        	{
			            	return "NA";
						}
						elseif($d>0)
						{
							$u = $this->common_model->getUserDetails($d);
			            	return $u[0]['fname'];
						}

			        }
			    ),
			    array(
			        'db'        => 'status',
			        'dt'        => 'status',
			        'formatter' => function( $d, $row ) {
			        	if($d == NULL || $d == "")
			        	{
							return "<span class='label label-danger'>NA</span>";
						}
						else
						{
							if($d == "Success")
							{
								return "<span class='label label-success'>Success</span>";
							}
							elseif($d == "Error")
							{
								return "<span class='label label-danger'>Error</span>";
							}
							elseif($d == "Waiting...")
							{
								return "<span class='label label-auth'>Waiting</span>";
							}
							elseif($d == "Disabled")
							{
								return "<span class='label label-gray'>Disabled</span>";
							}

						}
			        }
			    )

			);

			// SQL server connection information
			$sql_details = array(
			    'user' => 'root',
			    'pass' => 'pedestrianism98marguerites',
			    'db'   => 'kurrent_streams',
			    'host' => 'localhost'
			);

			$returnJson = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
			if(sizeof($returnJson['data'])>0)
			{
				$counter = $vars['start'] + 1;
				foreach($returnJson['data'] as $key=>$data)
				{
					$returnJson['data'][$key]['checkbox'] = "<div class='boxes'><input type='checkbox' id='log_".$counter."' class='selectlogs'/><label for='log_".$counter."'></label></div>";
					$returnJson['data'][$key]['counter'] = $counter;
					$counter++;
				}
			}
			//$returnJson = array_map('utf8_encode', $returnJson);
			echo json_encode($returnJson,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
		}
		public function twittertest()
		{
			$str ="\u003Cblockquote class=\"twitter-tweet\"\u003E\u003Cp lang=\"en\" dir=\"ltr\"\u003Etest \u003Ca href=\"https:\/\/t.co\/fZviaIkiuJ\"\u003Ehttps:\/\/t.co\/fZviaIkiuJ\u003C\/a\u003E\u003C\/p\u003E&mdash; kamal (@KamalObroi) \u003Ca href=\"https:\/\/twitter.com\/KamalObroi\/status\/1022081137701789696?ref_src=twsrc%5Etfw\"\u003EJuly 25, 2018\u003C\/a\u003E\u003C\/blockquote\u003E\n\u003Cscript async src=\"https:\/\/platform.twitter.com\/widgets.js\" charset=\"utf-8\"\u003E\u003C\/script\u003E\n";

			$str = preg_replace("/\\\\u([0-9a-f]{3,4})/i", "&#x\\1;", $str);
			$str = html_entity_decode($str, null, 'UTF-8');

			$appid = $this->uri->segment(3);
			$target = $this->common_model->getTargetbyId($appid);
			$settings = array(
		        'oauth_access_token' => "3307449300-QCsWeN3Iy8cVQ8pOlrW9ug9ZA5TTJZsXZdi2X7L",
		        'oauth_access_token_secret' => "prN3ksFzd79EpXcS1chxerYVfsQc4btf4gnu8SriCA5Fu",
		        'consumer_key' => "RXXsXk44Hv8HsPILWIfQ1mnUk",
		        'consumer_secret' => "xgRmRMTIjzVQ2CporNCBVKaQLofLbpUKguFGp8KkdINBwMVVR7"
		    );
			$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
		    $getfield = '?screen_name=KamalObroi';
		    $requestMethod = 'GET';

		    $twitter = new TwitterAPIExchange($settings);
		    $response = $twitter->setGetfield($getfield)
		        ->buildOauth($url, $requestMethod)
		        ->performRequest();

		    $result=json_decode($response);
			print_r($result);
		}
		public function getTwitchGames()
		{
			$queryParam = $this->input->post(NULL,TRUE);
			$URL = "https://api.twitch.tv/kraken/search/games?query=".$queryParam['term'];
			//echo $URL;
			$curl = curl_init($URL);
			curl_setopt($curl, CURLOPT_FAILONERROR, true);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_HEADER, false);    // we want headers
			//curl_setopt($curl, CURLOPT_NOBODY, true);    // we don't need body
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
			//curl_setopt($curl, CURLOPT_TIMEOUT_MS, 300); //timeout in seconds
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_HTTPHEADER,array('Accept: application/vnd.twitchtv.v5+json','Client-ID: kz30uug3w8b73asx3qe2q1yt98al5r'));
			$result = curl_exec($curl);
			$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			$games = json_decode($result,TRUE);
			$response = array();
			if(sizeof($games)>0)
			{
				//print_r($games);
				foreach($games['games'] as $game)
				{
					$ar = array('name'=>$game['name'],'id'=>$game['_id'],'icon'=>$game['logo']['small']);
					$response[] = $ar;
				}

			}
			echo json_encode($response);
		}

		public function periscope()
		{
			if(isset($_GET['code']))
			{
				$URL = "https://api.pscp.tv/v1/oauth/token";
				$fields = array(
					"grant_type"=>"authorization_code",
					"code"=>$_GET['code'],
					"redirect_uri"=>"https://iohub.tv/periscope",
					"client_id"=>"Tr5fxCa7x62pZrhe50b3Oy_iGoSrn02KcclRRH20rHteUdD8L2",
					"client_secret"=>"8PyUSMT1LuliGFBVAUZFZaUXO5Mzw8-mZGxslimam6M1V2u187"
				);
				$ch = curl_init();
				curl_setopt($ch,CURLOPT_URL, $URL);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch,CURLOPT_POST, count($fields));
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
				curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));
				$result = curl_exec($ch);
				$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				$array = json_decode($result,TRUE);

				$this->session->set_userdata('twitter_data',$array['user']);
				$this->session->set_userdata('twitter_access',$array['access_token']);
				$this->session->set_userdata('twitter_refresh',$array['refresh_token']);
				$sotp = $this->session->userdata('soptTwitter');
				redirect(site_url() . 'createtarget');
			}
			else
			{
				echo "invalid request";
				die;
			}
		}
		public function revokeFB()
		{

			try {
			$fbToken = $this->session->userdata('fb_token');
			$fbdd = $this->session->userdata('fbUser');
			define('APP_URL', 'https://iohub.tv/admin/fb');
			$facebookArray = array('app_id' => '201130880631964', 'app_secret' => '49e984459f5d67695b85b443dc879d82',  'default_graph_version' => 'v2.6');

			$fb = new Facebook\Facebook($facebookArray);
			$response = $fb->delete(
			   '/'. $fbdd['id'].'/permissions',
			    array (),
			    $fbToken
			  );
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
			  echo 'Graph returned an error: ' . $e->getMessage();
			  exit;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
			  echo 'Facebook SDK returned an error: ' . $e->getMessage();
			  exit;
			}
			$graphNode = $response->getGraphNode()->asArray();
			if($graphNode['success'] == 1)
			{
				$dataa = array(
					'revoke'=>1
				);
				$this->session->set_userdata('revoke',TRUE);
				$redir = $this->session->userdata('act');
				$redi = explode('_',$redir);
				$this->common_model->updateTarget($redi[1],$dataa);
				if($redi[0] != "")
				{
					redirect('editTarget/'.$redi[1]);
				}
			}
		}
		public function tst()
		{
			$this->load->view('admin/header');
			$this->load->view('admin/tst');
			$this->load->view('admin/footer');
		}
		public function notFound()
		{
			$this->load->view('admin/header');
			$this->load->view('admin/navigation');
			$this->load->view('admin/leftsidebar');
			$this->load->view('errors/html/error_404');
			$this->load->view('admin/footer');
		}
		public function getChartData()
		{
			$URLlink = $_GET['DURL'];
			//echo $URLlink;
			$URL = $URLlink;

			//echo $URL;
			$curl = curl_init($URL);
			curl_setopt($curl, CURLOPT_FAILONERROR, true);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_HEADER, false);    // we want headers
			//curl_setopt($curl, CURLOPT_NOBODY, true);    // we don't need body
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
			//curl_setopt($curl, CURLOPT_TIMEOUT_MS, 300); //timeout in seconds
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
			$result = curl_exec($curl);
			$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			echo json_encode($result);
		}
		public function getCharts()
		{

			$URLlink = $_GET['URL'];
			//echo $URLlink;
			$URL = "http://iohub.tv:19999".$URLlink;

			//echo $URL;
			$curl = curl_init($URL);
			curl_setopt($curl, CURLOPT_FAILONERROR, true);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_HEADER, false);    // we want headers
			//curl_setopt($curl, CURLOPT_NOBODY, true);    // we don't need body
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
			//curl_setopt($curl, CURLOPT_TIMEOUT_MS, 300); //timeout in seconds
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($curl, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
			$result = curl_exec($curl);
			$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			echo json_encode($result);

		}
		/* Wowza Actions Dropdowns */
		public function wowzaActions()
		{
			$sts = FALSE;
			$response = array('status'=>FALSE,'response'=>array());
			$user_data = $this->session->userdata('user_data');
			$permissions = $this->session->userdata('user_permissions');


			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$wowId = $cleanData['id'];
			$action = $cleanData['action'];
			switch($action){
				case "Refresh":
				if(sizeof($wowId)>0)
				{
					foreach($wowId as $wid)
					{
						$wowzaEngine = $this->common_model->getWovzData($wid);
						$URL = "http://";
						$URL = $URL.$wowzaEngine[0]['ip_address'].":".$wowzaEngine[0]['rest_api_port']."/v2/servers/_defaultServer_/status";

						$curl = curl_init($URL);
						curl_setopt($curl, CURLOPT_FAILONERROR, true);
						curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
						curl_setopt($curl, CURLOPT_HEADER, true);    // we want headers
						curl_setopt($curl, CURLOPT_NOBODY, true);    // we don't need body
						curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
						curl_setopt($curl, CURLOPT_TIMEOUT_MS, 300); //timeout in seconds
						curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
						curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
						$result = curl_exec($curl);
						$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
						if($httpcode == 200)
						{
							$response['response'][$wid]['status'] = TRUE;
							$response['response'][$wid]['response'] = $httpcode;
						}
						else
						{
							$response['response'][$wid]['status'] = FALSE;
							$response['response'][$wid]['response'] = $httpcode;
						}
					}
				}
				break;
				case "TakeOffline":
					if(sizeof($wowId)>0)
					{
						foreach($wowId as $wid)
						{
							$dat = array(
								'status'=>2
							);
							$sts = $this->common_model->updateConfiguration($wid,$dat);
							if($sts > 0)
							{
								$response['response'][$wid]['status'] = TRUE;
								$response['response'][$wid]['response'] = $action." Successfully!";
							}
							else
							{
								$response['response'][$wid]['status'] = FALSE;
								$response['response'][$wid]['response'] = "Error occure while ".$action." wowza!";
							}
						}
					}
				break;
				case "BringOnline":
				if(sizeof($wowId)>0)
					{
						foreach($wowId as $wid)
						{
							$dat = array(
								'status'=>1
							);
							$sts = $this->common_model->updateConfiguration($wid,$dat);
							if($sts > 0)
							{
								$response['response'][$wid]['status'] = TRUE;
								$response['response'][$wid]['response'] = $action." Successfully!";
							}
							else
							{
								$response['response'][$wid]['status'] = FALSE;
								$response['response'][$wid]['response'] = "Error occure while ".$action." wowza!";
							}
						}
					}
				break;
				case "Reboot":
				if(sizeof($wowId)>0)
				{
						foreach($wowId as $wid)
						{
							$wowzaEngine = $this->common_model->getWovzData($wid);
							$URL = "http://";
							$URL = $URL.$wowzaEngine[0]['ip_address'].":".$wowzaEngine[0]['java_api_port']."/api/v1/restartServer";
							$curl = curl_init($URL);
							curl_setopt($curl, CURLOPT_FAILONERROR, true);
							curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
							curl_setopt($curl, CURLOPT_HEADER, true);    // we want headers
							curl_setopt($curl, CURLOPT_NOBODY, true);    // we don't need body
							curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
							curl_setopt($curl, CURLOPT_TIMEOUT_MS, 300); //timeout in seconds
							curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
							curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
							$result = curl_exec($curl);
							$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
							if($httpcode == 200)
							{
								$response['response'][$wid]['status'] = TRUE;
								$response['response'][$wid]['response'] = $httpcode;
							}
							else
							{
								$response['response'][$wid]['status'] = FALSE;
								$response['response'][$wid]['response'] = $httpcode;
							}
						}
					}
				break;
				case "Delete":
				if(sizeof($wowId)>0)
				{
						foreach($wowId as $wid)
						{
							$sts = $this->common_model->deleteWowza($wid);
							if($sts > 0)
							{
								$response['response'][$wid]['status'] = TRUE;
								$response['response'][$wid]['response'] = $action." Successfully!";
							}
							else
							{
								$response['response'][$wid]['status'] = FALSE;
								$response['response'][$wid]['response'] = "Error occure while ".$action." wowza!";
							}
						}
					}
				break;
			}
			echo json_encode($response);
		}
		/* Wowza Refresh Action */
		public function wowzarefresh()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$wids = $cleanData['wowzaId'];
			$wid = explode('_',$wids);
			$wowzaEngine = $this->common_model->getWovzData($wid[1]);
			$URL = "http://";
			$URL = $URL.$wowzaEngine[0]['ip_address'].":".$wowzaEngine[0]['rest_api_port']."/v2/servers/_defaultServer_/status";

			$curl = curl_init($URL);
			curl_setopt($curl, CURLOPT_FAILONERROR, true);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_HEADER, true);    // we want headers
			curl_setopt($curl, CURLOPT_NOBODY, true);    // we don't need body
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($curl, CURLOPT_TIMEOUT_MS, 300); //timeout in seconds
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($curl);
			$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			$sts = $httpcode;
			if($httpcode == 200)
			{
				$response['status'] = TRUE;
				$response['response'] = $httpcode;
			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = $httpcode;
			}
			echo json_encode($response);
		}
		/* Wowza Reboot Action */
		public function wowzareboot()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$wowIdArray = explode("_",$cleanData['wowzaId']);
			$wowzaEngine = $this->common_model->getWovzData($wowIdArray[1]);
			$URL = "http://";
			$URL = $URL.$wowzaEngine[0]['ip_address'].":".$wowzaEngine[0]['rest_api_port']."/v2/servers/_defaultServer_/actions/restart";
			$curl = curl_init($URL);
			curl_setopt($curl, CURLOPT_FAILONERROR, true);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_HEADER, true);    // we want headers
			curl_setopt($curl, CURLOPT_NOBODY, true);    // we don't need body
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($curl, CURLOPT_TIMEOUT_MS, 300); //timeout in seconds
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($curl);
			$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			if(curl_error($curl))
			{
				$response['status'] = FALSE;
				$response['response'] = curl_error($curl);
			}
			else
			{
				$response['status'] = TRUE;
				$response['response'] = $httpcode;
			}

			echo json_encode($response);
			curl_close($curl);
		}
		/* Wowza Delete Action */
		public function wowzadelete()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$wowId = $cleanData['wowzaId'];
			$idArray = explode('_',$wowId);

			$sts = $this->common_model->deleteWowza($idArray[1]);
			if($sts)
			{
				$response['status'] = TRUE;
				$response['response'] = "Deleted Successfully!";
			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = "Error occure while deleting wowza!";
			}
			echo json_encode($response);
		}
		/* Wowza Uptime on Load */
		public function wowzauptime()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$wowId = $cleanData['wowzaId'];
			$wowzaEngine = $this->common_model->getWovzData($wowId);
			if($wowzaEngine[0]['status'] == 1)
			{
				$URL = "http://";
				$URL = $URL.$wowzaEngine[0]['ip_address'].":".$wowzaEngine[0]['rest_api_port']."/v2/machine/monitoring/current";
				$curl = curl_init($URL);
				curl_setopt($curl, CURLOPT_FAILONERROR, true);
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
				curl_setopt($curl, CURLOPT_TIMEOUT_MS, 300); //timeout in seconds
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl, CURLOPT_HTTPHEADER,array('Content-Type: application/json','Accept: application/json'));
				$result = curl_exec($curl);
				if(curl_error($curl))
				{
					$response['status'] = FALSE;
					$response['response'] = curl_error($curl);
				}
				else
				{
					$res = json_decode($result,TRUE);
					$time =  $res['serverUptime'];
					$timee = $this->secondsToWords($time);
					$response['status'] = TRUE;
					$response['response'] = array('ServerUptime'=>$timee,'CurrentHeapSize'=>$this->format_size($res['heapUsed']),'MemoryUsed'=>$this->format_size($res['memoryUsed']),'DiskUsed'=>$this->format_size($res['diskUsed']),'CPU'=>$res['cpuUser']);
				}
				echo json_encode($response);
				curl_close($curl);
			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = "400";
			}
		}
		/* Wowza Status on Load */
		public function wowzastatus()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$wowId = $cleanData['wowzaId'];
			$wowzaEngine = $this->common_model->getWovzData($wowId);

			$URL = "http://";
			$URL = $URL.$wowzaEngine[0]['ip_address'].":".$wowzaEngine[0]['rest_api_port']."/v2/servers/_defaultServer_/status";

			$curl = curl_init($URL);
			curl_setopt($curl, CURLOPT_FAILONERROR, true);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_HEADER, true);    // we want headers
			curl_setopt($curl, CURLOPT_NOBODY, true);    // we don't need body
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($curl, CURLOPT_TIMEOUT_MS, 300); //timeout in seconds
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($curl);
			$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

			if(curl_error($curl))
			{
				$response['status'] = FALSE;
				$response['response'] = $httpcode;
			}
			else
			{
				$response['status'] = TRUE;
				$response['response'] = $httpcode;
			}
			echo json_encode($response);
			curl_close($curl);
		}
		/* Wowza Create New */
		public function createwowza()
		{
			$this->breadcrumbs->push('Configuration/New Publisher', '/configuration');
			$user_data = $this->session->userdata('user_data');
			$permissions = $this->session->userdata('user_permissions');
			$data['userdata'] = $user_data;
			if($permissions['create_wowza'] <= 0)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', "You are not authorized to add Publishers.");
				redirect('configuration');
			}
			elseif($permissions['create_wowza'] == "1")
			{
				if($user_data['user_type'] == 1)
				{
					$data['groups'] = $this->common_model->getGroups(0);
				}
				else
				{
					$data['groups'] = $this->common_model->getGroups($user_data['userid']);
				}

				$this->load->view('admin/header');
				$this->load->view('admin/createwowza',$data);
				$this->load->view('admin/footer');
			}

		}
		/* Wowza Save New */
		public function saveConfiguration()
		{
			try
			{
				$userdata = $this->session->userdata('user_data');
				$this->form_validation->set_rules('wse_instance_name', 'WSE Instance Name', 'required');
				$this->form_validation->set_rules('ip_address', 'IP Address', 'required');
				$this->form_validation->set_rules('stream_name', 'Stream Name', 'required');
				$this->form_validation->set_rules('rtmp_port', 'RTMP Port', 'required');
				$this->form_validation->set_rules('wse_administrator_username', 'WSE Administrator User Name', 'required');
				$this->form_validation->set_rules('wse_administrator_pssword', 'WSE Administrator Password', 'required');
				$this->form_validation->set_rules('wse_cp_port', 'WSE CP Port', 'required');
				$this->form_validation->set_rules('java_api_port', 'JAVA API Port', 'required');
				$this->form_validation->set_rules('rest_api_port', 'REST API Port', 'required');


				$post     = $this->input->post();
				$actual_link =  $_SERVER['HTTP_REFERER'];
				$clean   = $this->security->xss_clean($this->input->post(NULL, TRUE));
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', validation_errors());
					redirect($actual_link);
				}
				else
				{
					$imgname ="";
					$files = $_FILES['groupfile'];
					if($files["name"] != "")
					{
						$fnmae = $_FILES['groupfile']['name'];
						$typpe = $_FILES['groupfile']['type'];
						$tempfile = $_FILES['groupfile']['tmp_name'];

						$name = str_replace(" ","_",$files['name']);
						$imgname = time().'_'.$name;

						$target_file = 'public/site/main/wowza_logo/'.$imgname;
						if (move_uploaded_file($_FILES["groupfile"]["tmp_name"], $target_file))
						{

						}
					}
					$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
					$netdata = 0;$groupId = 0;
					if(array_key_exists("enablenetdata",$cleanData))
					{
						$netdata = 1;
					}
					if($userdata['user_type'] == 1)
					{
						$groupId = $cleanData['group_id'];
					}
					else
					{
						$groupId = $userdata['group_id'];
					}

					$userData = array(
                	'wse_instance_name'=>$cleanData['wse_instance_name'],
                	'ip_address'=>$cleanData['ip_address'],
                	'stream_name'=>$cleanData['stream_name'],
                	'rtmp_port'=>$cleanData['rtmp_port'],
                	'licence_key'=>$cleanData['licence_key'],
                	'installation_directory'=>$cleanData['installation_directory'],
                	'vod_directory'=>$cleanData['vod_directory'],
                	'wse_administrator_username'=>$cleanData['wse_administrator_username'],
                	'connection_limit'=>$cleanData['connection_limit'],
                	'wse_administrator_pssword'=>$cleanData['wse_administrator_pssword'],
					'wse_cp_port'=>$cleanData['wse_cp_port'],
                	'java_api_port'=>$cleanData['java_api_port'],
                	'rest_api_port'=>$cleanData['rest_api_port'],
                	'group_id'=>$groupId,
                	'wowza_image'=>$imgname,
                	'enablenetdata'=>$netdata,
                	'created'=>time(),
                	'status'=>1,
                	'uid'=>$userdata['userid']
					);

					$id = $this->common_model->insertConfiguration($userData);
					if($id > 0)
					{
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Wowza Engine Added Successfully!');
						$this->session->set_flashdata('tab', 'User');
						redirect('admin/configuration');

					}
					else
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error occur while saving Wowza Engine!');
						redirect('admin/configuration');
					}
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while saving Wowza Engine!');
				redirect('admin/configuration');
			}
		}
		/* Wowza Edit Form */
		public function updatewowzaengin()
		{
			$this->breadcrumbs->push('Configuration/Edit Publisher', '/configuration');
			$userdata = $this->session->userdata('user_data');
			$data['userdata'] = $userdata;
			$segment = $this->uri->segment(2);
			$data['wovzData'] = $this->common_model->getWovzData($segment);
			$data['groups'] = $this->common_model->getGroups($userdata['userid']);
			$this->load->view('admin/header');
			$this->load->view('admin/editwowza',$data);
			$this->load->view('admin/footer');

		}
		/* Wowza Update Existing */
		public function updateConfiguration()
		{
			try
			{
				$permissions = $this->session->userdata('user_permissions');
				if($permissions['edit_wowza'] <= 0)
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'You are not authorized to edit Publishers.');
					redirect('configuration');
				}
				elseif($permissions['delete_wowza'] == "1")
				{
					$userdata = $this->session->userdata('user_data');
					$this->form_validation->set_rules('wse_instance_name', 'WSE Instance Name', 'required');
					$this->form_validation->set_rules('ip_address', 'IP Address', 'required');
					$this->form_validation->set_rules('stream_name', 'Stream Name', 'required');
					$this->form_validation->set_rules('rtmp_port', 'RTMP Port', 'required');
					$this->form_validation->set_rules('wse_administrator_username', 'WSE Administrator User Name', 'required');
					$this->form_validation->set_rules('wse_administrator_pssword', 'WSE Administrator Password', 'required');
					$this->form_validation->set_rules('wse_cp_port', 'WSE CP Port', 'required');
					$this->form_validation->set_rules('java_api_port', 'API Port', 'required');
					$this->form_validation->set_rules('rest_api_port', 'API Port', 'required');

					$post     = $this->input->post();
					$actual_link =  $_SERVER['HTTP_REFERER'];
					$clean   = $this->security->xss_clean($this->input->post(NULL, TRUE));

					if ($this->form_validation->run() == FALSE)
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', validation_errors());
						redirect($actual_link);
					}
					else
					{
						$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));

						$netdata = 0;
						if(array_key_exists("enablenetdata",$cleanData))
						{
							$netdata = 1;
						}
						$group_id =0;
						if($userdata['user_type'] == 1)
						{
							$group_id = $cleanData['group_id'];
						}
						else
						{
							$group_id = $userdata['group_id'];
						}
						$userData1 = array(
	                	'wse_instance_name'=>$cleanData['wse_instance_name'],
	                	'ip_address'=>$cleanData['ip_address'],
	                	'stream_name'=>$cleanData['stream_name'],
	                	'rtmp_port'=>$cleanData['rtmp_port'],
	                	'licence_key'=>$cleanData['licence_key'],
	                	'installation_directory'=>$cleanData['installation_directory'],
	                	'vod_directory'=>$cleanData['vod_directory'],
	                	'wse_administrator_username'=>$cleanData['wse_administrator_username'],
	                	'connection_limit'=>$cleanData['connection_limit'],
	                	'wse_administrator_pssword'=>$cleanData['wse_administrator_pssword'],
						'wse_cp_port'=>$cleanData['wse_cp_port'],
	                	'java_api_port'=>$cleanData['java_api_port'],
	                	'rest_api_port'=>$cleanData['rest_api_port'],
	                	'group_id'=>$group_id,
	                	'enablenetdata'=>$netdata,
	                	'created'=>time(),
	                	'wowza_image'=>"",
	                	'status'=>1,
	                	'uid'=>$userdata['userid']
						);
						$id = $this->common_model->updateConfiguration($cleanData['appid'],$userData1);
						if($id > 0)
						{
							$this->session->set_flashdata('message_type', 'success');
							$this->session->set_flashdata('success', 'wavaz updated Successfully!');
							redirect('admin/configuration');
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'Error occur while updloading group image!');
							redirect('admin/configuration');
						}
					}
				}

			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while updloading group image!');
				redirect('admin/configuration');
			}
		}
		/* Encoder Uptime */
		public function encoderUptime()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$encid = $cleanData['id'];

			$encoder = $this->common_model->getAllEncoders($encid,0);
			if($encoder[0]['status'] == 1)
			{
				$ip = $encoder[0]["encoder_ip"];
				$username = $encoder[0]["encoder_uname"];
				$password = $encoder[0]["encoder_pass"];
				$port = "22";
				$ssh = new Net_SSH2($ip);
				if (!$ssh->login($username, $password,$port)) {
					$response['response'][$encid] = array('status'=>FALSE,'response'=>$ssh->getLog());
				}
				else
				{
					$resp = $ssh->exec("uptime -p");
					$response['response'][$encid] = array('status'=>TRUE,'response'=>$resp);
				}
			}
			else
			{
				$response['response'][$encid] = array('status'=>FALSE,'response'=>"");
			}

			echo json_encode($response);
		}
		/* Encoder Actions Dropdown	*/
		public function encoderActions()
		{
			$sts = FALSE;
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$encid = $cleanData['id'];
			$action = $cleanData['action'];

			switch($action){
				case "Refresh":
				if(sizeof($encid)>0)
				{
					$response['response']= array();
					foreach($encid as $wid)
					{
						$encoder = $this->common_model->getAllEncoders($wid,0);
						$ip = $encoder[0]["encoder_ip"];
						$username = $encoder[0]["encoder_uname"];
						$password = $encoder[0]["encoder_pass"];
						$port = "22";
						if (!$socket = @fsockopen("$ip", 22, $errno, $errstr, 2))
						{
							$response['response'][$wid] = array('status'=>FALSE,'response'=>"fail");
						}
						else
						{
							$response['response'][$wid] =  array('status'=>TRUE,'response'=>"success");
						 	fclose($socket);
						}
					}
				}
				break;
				case "Reboot":
				if(sizeof($encid)>0)
				{
					foreach($encid as $wid)
					{
						$encoder = $this->common_model->getAllEncoders($wid,0);
						$ip = $encoder[0]["encoder_ip"];
						$username = $encoder[0]["encoder_uname"];
						$password = $encoder[0]["encoder_pass"];
						$port = "22";
						$ssh = new Net_SSH2($ip);
						if (!$ssh->login($username, $password,$port)) {
							$response['response'][$wid] = array('status'=>TRUE,'response'=>$ssh->getLog());
						}
						else
						{
							$resp = $ssh->exec("sudo reboot");
							$response['response'][$wid] = array('status'=>TRUE,'response'=>"Reboot Successfully!");
						}
					}
				}
				break;
				case "TakeOffline":
				if(sizeof($encid)>0)
				{
					foreach($encid as $wid)
					{
						$dat = array(
							'status'=>2
						);
						$sts = $this->common_model->updateEncoder($dat,$wid);
						if($sts >0)
						{
							$response['response'][$wid] = array('status'=>TRUE,'response'=>"Delete Successfully!");
						}
						else
						{
							$response['response'][$wid] = array('status'=>FALSE,'response'=>"Error Occured While Deleting!");
						}
					}
				}
				break;
				case "BringOnline":
				if(sizeof($encid)>0)
				{
					foreach($encid as $wid)
					{
						$dat = array(
							'status'=>1
						);
						$sts = $this->common_model->updateEncoder($dat,$wid);
						if($sts >0)
						{
							$response['response'][$wid] = array('status'=>TRUE,'response'=>"Delete Successfully!");
						}
						else
						{
							$response['response'][$wid] = array('status'=>FALSE,'response'=>"Error Occured While Deleting!");
						}
					}
				}
				break;
				case "Delete":
				if(sizeof($encid)>0)
				{
					foreach($encid as $wid)
					{
						$sts = $this->common_model->deleteEncoders($wid);
						if($sts >0)
						{
							$response['response'][$wid] = array('status'=>TRUE,'response'=>"Delete Successfully!");
						}
						else
						{
							$response['response'][$wid] = array('status'=>FALSE,'response'=>"Error Occured While Deleting!");
						}
					}
				}
				break;
			}

			echo json_encode($response);
		}
		/* Encoders Create New */
		public function addEncoderes()
		{
			$this->breadcrumbs->push('Configuration/New Encoder', '/configuration');
			$permissions = $this->session->userdata('user_permissions');
			if($permissions['create_encoder'] <= 0)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', "You are not authorized to add Encoders.");
				redirect('configuration');
			}
			elseif($permissions['create_encoder'] == 1)
			{
				$userdata = $this->session->userdata('user_data');
				$data['userdata'] = $this->session->userdata('user_data');
				if($userdata['user_type'] == 1)
				{
					$data['groups'] = $this->common_model->getGroups(0);
				}
				else
				{
					$data['groups'] = $this->common_model->getGroups($userdata['userid']);
				}
				$this->load->view('admin/header');
				$this->load->view('admin/createencoder',$data);
				$this->load->view('admin/footer');
			}
		}
		/* Encoder Edit Form */
		public function editEncoder()
		{
			$this->breadcrumbs->push('Configuration/Edit Encoder', '/configuration');
			$id = $this->uri->segment(2);
			$userdata =$this->session->userdata('user_data');
			$userdata = $this->session->userdata('user_data');
			$data['userdata'] = $this->session->userdata('user_data');
			if($userdata['user_type'] == 1)
			{
				$data['groups'] = $this->common_model->getGroups(0);
			}
			else
			{
				$data['groups'] = $this->common_model->getGroups($userdata['userid']);
			}

			$data['encoder'] = $this->common_model->getAllEncoders($id);
			$this->load->view('admin/header');
			$this->load->view('admin/editencoder',$data);
			$this->load->view('admin/footer');
		}
		/* Encoder Save New */
		public function saveEncoder()
		{
			try{
				$this->form_validation->set_rules('encoder_name', 'Encoder Name', 'required');
				$this->form_validation->set_rules('encoder_ip', 'Encoder IP Address', 'required');
				$this->form_validation->set_rules('encoder_port', 'Encoder Port', 'required');
				$this->form_validation->set_rules('encoder_uname', 'Encoder Username', 'required');
				$this->form_validation->set_rules('encoder_pass', 'Encoder Password', 'required');

				$post = $this->input->post();
				$actual_link =  $_SERVER['HTTP_REFERER'];
				if ($this->form_validation->run() == FALSE) {
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', validation_errors());
					redirect($actual_link);
				}
				else
				{
					$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
					$userdata = $this->session->userdata('user_data');
					$groupid = 0;

					//====
					$enableVideo =0; $advance_video_setting=0;$enabledeinterlance=0;$audio_check=0;$enableAdvanceAudio=0;$enablezerolatency=0;$video_codec = "";$video_resolution ="";$video_bitrate="";$video_framerate="";
					if(array_key_exists('enableVideo',$cleanData) && $cleanData['enableVideo'] == "on")
					{
						$enableVideo = 1;
					}
					if(array_key_exists('advance_video_setting',$cleanData) && $cleanData['advance_video_setting'] == "on")
					{
						$advance_video_setting = 1;
					}
					if(array_key_exists('enabledeinterlance',$cleanData) && $cleanData['enabledeinterlance'] == "on")
					{
						$enabledeinterlance = 1;
					}
					if(array_key_exists('enablezerolatency',$cleanData) && $cleanData['enablezerolatency'] == "on")
					{
						$enablezerolatency = 1;
					}
					if(array_key_exists('audio_check',$cleanData) && $cleanData['audio_check'] == "on")
					{
						$audio_check = 1;
					}
					if(array_key_exists('enableAdvanceAudio',$cleanData) && $cleanData['enableAdvanceAudio'] == "on")
					{
						$enableAdvanceAudio = 1;
					}

					if(array_key_exists('video_codec',$cleanData))
					{
						$video_codec = $cleanData['video_codec'];
					}
					if(array_key_exists('video_resolution',$cleanData))
					{
						$video_resolution = $cleanData['video_resolution'];
					}
					if(array_key_exists('video_bitrate',$cleanData))
					{
						$video_bitrate = $cleanData['video_bitrate'];
					}
					if(array_key_exists('video_framerate',$cleanData))
					{
						$video_framerate = $cleanData['video_framerate'];
					}
					//====

					if($userdata['user_type'] == 1)
					{
						$groupid = $cleanData['encoder_group'];
					}
					else
					{
						$groupid = $userdata['group_id'];
					}
					$enableNetData = 0;$encoder_enable_hdmi_out = 0;
					if(array_key_exists('encoder_enable_netdata',$cleanData))
					{
						$enableNetData = 1;
					}
					if(array_key_exists('encoder_enable_hdmi_out',$cleanData))
					{
						$encoder_enable_hdmi_out = 1;
					}
					if(array_key_exists('enable_recording_on_local_disk',$cleanData))
					{
						$enable_recording_on_local_disk = 1;
					}
					if(array_key_exists('is_default_recording_preset',$cleanData))
					{
						$is_default_recording_preset = 1;
					}
					if(!array_key_exists('video_min_bitrate',$cleanData))
					{
						$cleanData['video_min_bitrate']="";
					}
					if(!array_key_exists('video_max_bitrate',$cleanData))
					{
						$cleanData['video_max_bitrate']="";
					}
					if(!array_key_exists('adv_video_min_bitrate',$cleanData))
					{
						$cleanData['adv_video_min_bitrate']="";
					}
					if(!array_key_exists('adv_video_max_bitrate',$cleanData))
					{
						$cleanData['adv_video_max_bitrate']="";
					}
					if(!array_key_exists('adv_video_buffer_size',$cleanData))
					{
						$cleanData['adv_video_buffer_size']="";
					}
					if(!array_key_exists('adv_video_gop',$cleanData))
					{
						$cleanData['adv_video_gop']="";
					}
					if(!array_key_exists('adv_video_keyframe_intrval',$cleanData))
					{
						$cleanData['adv_video_keyframe_intrval']="";
					}
					if(!array_key_exists('audio_codec',$cleanData))
					{
						$cleanData['audio_codec']="";
					}
					if(!array_key_exists('audio_channel',$cleanData))
					{
						$cleanData['audio_channel']="";
					}
					if(!array_key_exists('audio_bitrate',$cleanData))
					{
						$cleanData['audio_bitrate']="";
					}
					if(!array_key_exists('audio_sample_rate',$cleanData))
					{
						$cleanData['audio_sample_rate']="";
					}
					if(!array_key_exists('rangeslider',$cleanData))
					{
						$cleanData['rangeslider']="";
					}
					if(!array_key_exists('delay',$cleanData))
					{
						$cleanData['delay']="";
					}
					$encoderData = array(
						'uid'=>$userdata['userid'],
						'encoder_id'=>'ENC'.$this->random_stringid(12),
	                	'encoder_name'=>$cleanData['encoder_name'],
	                	'encoder_ip'=>$cleanData['encoder_ip'],
	                	'encoder_port'=>$cleanData['encoder_port'],
	                	'encoder_uname'=>$cleanData['encoder_uname'],
	                	'encoder_pass'=>$cleanData['encoder_pass'],
	                	'encoder_group'=>$groupid,
	                	'encoder_enable_netdata'=>$enableNetData,
	                	'encoder_enable_hdmi_out'=>$encoder_enable_hdmi_out,
	                	'created'=>time(),
	                	'enableVideo'=>$enableVideo,
	                	'video_codec'=>$video_codec,
	                	'video_resolution'=>$video_resolution,
	                	'video_bitrate'=>$video_bitrate,
	                	'video_framerate'=>$video_framerate,
	                	'video_min_bitrate'=>$cleanData['video_min_bitrate'],
	                	'video_max_bitrate'=>$cleanData['video_max_bitrate'],
	                	'advance_video_setting'=>$advance_video_setting,
	                	'adv_video_preset'=>$cleanData['adv_video_min_bitrate'],
	                	'adv_video_profile'=>$cleanData['adv_video_max_bitrate'],
	                	'adv_video_buffer_size'=>$cleanData['adv_video_buffer_size'],
	                	'adv_video_gop'=>$cleanData['adv_video_gop'],
	                	'adv_video_keyframe_intrval'=>$cleanData['adv_video_keyframe_intrval'],
	                	'enabledeinterlance'=>$enabledeinterlance,
	                	'enablezerolatency'=>$enablezerolatency,
	                	'audio_check'=>$audio_check,
	                	'audio_codec'=>$cleanData['audio_codec'],
	                	'audio_channel'=>$cleanData['audio_channel'],
	                	'audio_bitrate'=>$cleanData['audio_bitrate'],
	                	'audio_sample_rate'=>$cleanData['audio_sample_rate'],
	                	'enableAdvanceAudio'=>$enableAdvanceAudio,
	                	'audio_gain'=>$cleanData['rangeslider'],
	                	'delay'=>$cleanData['delay'],
	                	'enable_recording_on_local_disk'=>$enable_recording_on_local_disk,
	                	'is_default_recording_preset'=>$is_default_recording_preset
					);
					$encoderHarwares = array();
					$id = $this->common_model->insertEncoder($encoderData);
					//$id = 0;
					$hardwaredata = array(); $inputoutputdata = array();
					if(array_key_exists('encoder_hardware',$cleanData))
					{
						$hardwaredata[0]['hardware_id'] = 'encoder_hardware';
						$hardwaredata[0]['hardware'] = $cleanData['encoder_hardware'];
						$hardwaredata[0]['encid'] = $id;
						$hardwaredata[0]['status'] = 1;
						$hardwaredata[0]['created'] = time();
					}
					if(array_key_exists('encoder_hardware1',$cleanData))
					{
						$hardwaredata[1]['hardware_id'] = 'encoder_hardware1';
						$hardwaredata[1]['hardware'] = $cleanData['encoder_hardware1'];
						$hardwaredata[1]['encid'] = $id;
						$hardwaredata[1]['status'] = 1;
						$hardwaredata[1]['created'] = time();
					}
					if(array_key_exists('encoder_hardware2',$cleanData))
					{
						$hardwaredata[2]['hardware_id'] = 'encoder_hardware2';
						$hardwaredata[2]['hardware'] = $cleanData['encoder_hardware2'];
						$hardwaredata[2]['encid'] = $id;
						$hardwaredata[2]['status'] = 1;
						$hardwaredata[2]['created'] = time();
					}
					if(array_key_exists('encoder_model',$cleanData))
					{
						$hardwaredata[0]['model_id'] = 'encoder_model';
						$hardwaredata[0]['model'] = $cleanData['encoder_model'];
					}
					if(array_key_exists('encoder_model1',$cleanData))
					{
						$hardwaredata[1]['model_id'] = 'encoder_model1';
						$hardwaredata[1]['model'] = $cleanData['encoder_model1'];
					}
					if(array_key_exists('encoder_model2',$cleanData))
					{
						$hardwaredata[2]['model_id'] = 'encoder_model2';
						$hardwaredata[2]['model'] = $cleanData['encoder_model2'];
					}
					if(array_key_exists('inputs',$cleanData))
					{
						if(sizeof($cleanData['inputs'])>0)
						{
							$i = 0;
							foreach($cleanData['inputs'] as $inp)
							{
								$inputoutputdata[$i]['inp_name'] = $inp;
								$inputoutputdata[$i]['inp_status'] = 1;
								$inputoutputdata[$i]['encid'] = $id;
								$i++;
							}
							$i = 0;
							foreach($cleanData['videoinputsources'] as $vide)
							{
								$inputoutputdata[$i]['inp_source'] = $vide;
								$i++;
							}
							$i = 0;
							foreach($cleanData['audiosources'] as $aud)
							{
								$inputoutputdata[$i]['inp_aud_source'] = $aud;
								$i++;
							}
							$i = 0;
							foreach($cleanData['outputs'] as $out)
							{
								$outputdata[$i]['out_name'] = $out;
								$outputdata[$i]['out_status'] = 1;
								$outputdata[$i]['encid'] = $id;
								$outputdata[$i]['created'] = time();

								$i++;
							}
							$i = 0;
							foreach($cleanData['videooutputsources'] as $out)
							{
								$outputdata[$i]['out_destination'] = $out;
								$i++;
							}
							$i = 0;
							foreach($cleanData['encoderOutputFormat'] as $format)
							{
								$outputdata[$i]['out_format'] = $format;
								$i++;
							}
						}
					}

					if($id > 0)
					{
						if(sizeof($hardwaredata)>0)
						{
							foreach($hardwaredata as $hard)
							{
								$Hid = $this->common_model->insertEncoderHardware($hard);
							}
						}
						if(sizeof($inputoutputdata)>0)
						{
							foreach($inputoutputdata as $inpoup)
							{
								$Hid = $this->common_model->insertEncoderHardwareInpOut($inpoup);
							}

						}
						if(sizeof($outputdata)>0)
						{
							foreach($outputdata as $Outt)
							{
								$Oid = $this->common_model->insertEncoderHardwareOut($Outt);
							}

						}
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Encoder is sucessfully cretaed!');
						redirect('admin/addEncoderes');
					}
					else
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error occur while creating encoder!');
						redirect('admin/addEncoderes');
					}
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while adding Encoder!');
				redirect('admin/addEncoderes');
			}
		}
		/* Encoder Update Existing */
		public function updateEncoder()
		{
			try{
				$permissions = $this->session->userdata('user_permissions');
				if($permissions['edit_encoder'] <= 0)
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', "You are not authorized to edit Encoders.");
					redirect('configuration');
				}
				elseif($permissions['edit_encoder'] == 1)
				{
					$this->form_validation->set_rules('encoder_name', 'Encoder Name', 'required');
					$this->form_validation->set_rules('encoder_ip', 'Encoder IP Address', 'required');
					$this->form_validation->set_rules('encoder_port', 'Encoder Port', 'required');
					$this->form_validation->set_rules('encoder_uname', 'Encoder Username', 'required');
					$this->form_validation->set_rules('encoder_pass', 'Encoder Password', 'required');
					$post     = $this->input->post();
					$actual_link =  $_SERVER['HTTP_REFERER'];
					if ($this->form_validation->run() == FALSE) {
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', validation_errors());
						redirect($actual_link);
					}
					else
					{

						$userdata = $this->session->userdata('user_data');
						$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
						$groupid =0;
						$enableVideo =0; $advance_video_setting=0;$enabledeinterlance=0;$audio_check=0;$enableAdvanceAudio=0;
						if(array_key_exists('enableVideo',$cleanData) && $cleanData['enableVideo'] == "on")
						{
							$enableVideo = 1;
						}
						if(array_key_exists('advance_video_setting',$cleanData) && $cleanData['advance_video_setting'] == "on")
						{
							$advance_video_setting = 1;
						}
						if(array_key_exists('enabledeinterlance',$cleanData) && $cleanData['enabledeinterlance'] == "on")
						{
							$enabledeinterlance = 1;
						}
						if(array_key_exists('audio_check',$cleanData) && $cleanData['audio_check'] == "on")
						{
							$audio_check = 1;
						}
						if(array_key_exists('enableAdvanceAudio',$cleanData) && $cleanData['enableAdvanceAudio'] == "on")
						{
							$enableAdvanceAudio = 1;
						}


						if($userdata['user_type'] == 1)
						{
							$groupid = $cleanData['encoder_group'];
						}
						else
						{
							$groupid = $userdata['group_id'];
						}
						$enableNetData = 0;$encoder_enable_hdmi_out = 0;
						if(array_key_exists('encoder_enable_netdata',$cleanData))
						{
							$enableNetData = 1;
						}
						if(array_key_exists('encoder_enable_hdmi_out',$cleanData))
						{
							$encoder_enable_hdmi_out = 1;
						}
						if(array_key_exists('enable_recording_on_local_disk',$cleanData))
						{
							$enable_recording_on_local_disk = 1;
						}
						if(array_key_exists('is_default_recording_preset',$cleanData))
						{
							$is_default_recording_preset = 1;
						}
						$encoderData = array(
							'uid'=>$userdata['userid'],
		                	'encoder_name'=>$cleanData['encoder_name'],
		                	'encoder_ip'=>$cleanData['encoder_ip'],
		                	'encoder_port'=>$cleanData['encoder_port'],
		                	'encoder_uname'=>$cleanData['encoder_uname'],
		                	'encoder_pass'=>$cleanData['encoder_pass'],
		                	'encoder_group'=>$groupid,
		                	'encoder_enable_netdata'=>$enableNetData,
		                	'encoder_enable_hdmi_out'=>$encoder_enable_hdmi_out,
		                	'created'=>time(),
		                	'enableVideo'=>$enableVideo,
		                	'video_codec'=>$cleanData['video_codec'],
		                	'video_resolution'=>$cleanData['video_resolution'],
		                	'video_bitrate'=>$cleanData['video_bitrate'],
		                	'video_framerate'=>$cleanData['video_framerate'],
		                	'video_min_bitrate'=>$cleanData['video_min_bitrate'],
		                	'video_max_bitrate'=>$cleanData['video_max_bitrate'],
		                	'advance_video_setting'=>$advance_video_setting,
		                	'adv_video_preset'=>$cleanData['adv_video_min_bitrate'],
		                	'adv_video_profile'=>$cleanData['adv_video_max_bitrate'],
		                	'adv_video_buffer_size'=>$cleanData['adv_video_buffer_size'],
		                	'adv_video_gop'=>$cleanData['adv_video_gop'],
		                	'adv_video_keyframe_intrval'=>$cleanData['adv_video_keyframe_intrval'],
		                	'enabledeinterlance'=>$enabledeinterlance,
		                	'audio_check'=>$audio_check,
		                	'audio_codec'=>$cleanData['audio_codec'],
		                	'audio_channel'=>$cleanData['audio_channel'],
		                	'audio_bitrate'=>$cleanData['audio_bitrate'],
		                	'audio_sample_rate'=>$cleanData['audio_sample_rate'],
		                	'enableAdvanceAudio'=>$enableAdvanceAudio,
		                	'audio_gain'=>$cleanData['rangeslider'],
		                	'delay'=>$cleanData['delay'],
		                	'enable_recording_on_local_disk'=>$enable_recording_on_local_disk,
		                	'is_default_recording_preset'=>$is_default_recording_preset
						);
						$encoderHarwares = array();
						$id = $this->common_model->updateEncoder($encoderData,$cleanData['encoderId']);
						if(array_key_exists('encoder_hardware',$cleanData))
						{
							$hardwaredata[0]['hardware_id'] = 'encoder_hardware';
							$hardwaredata[0]['hardware'] = $cleanData['encoder_hardware'];
							$hardwaredata[0]['encid'] = $cleanData['encoderId'];
							$hardwaredata[0]['status'] = 1;
							$hardwaredata[0]['created'] = time();
						}
						if(array_key_exists('encoder_hardware1',$cleanData))
						{
							$hardwaredata[1]['hardware_id'] = 'encoder_hardware1';
							$hardwaredata[1]['hardware'] = $cleanData['encoder_hardware1'];
							$hardwaredata[1]['encid'] = $cleanData['encoderId'];
							$hardwaredata[1]['status'] = 1;
							$hardwaredata[1]['created'] = time();
						}
						if(array_key_exists('encoder_hardware2',$cleanData))
						{
							$hardwaredata[2]['hardware_id'] = 'encoder_hardware2';
							$hardwaredata[2]['hardware'] = $cleanData['encoder_hardware2'];
							$hardwaredata[2]['encid'] = $cleanData['encoderId'];
							$hardwaredata[2]['status'] = 1;
							$hardwaredata[2]['created'] = time();
						}
						if(array_key_exists('encoder_model',$cleanData))
						{
							$hardwaredata[0]['model_id'] = 'encoder_model';
							$hardwaredata[0]['model'] = $cleanData['encoder_model'];
						}
						if(array_key_exists('encoder_model1',$cleanData))
						{
							$hardwaredata[1]['model_id'] = 'encoder_model1';
							$hardwaredata[1]['model'] = $cleanData['encoder_model1'];
						}
						if(array_key_exists('encoder_model2',$cleanData))
						{
							$hardwaredata[2]['model_id'] = 'encoder_model2';
							$hardwaredata[2]['model'] = $cleanData['encoder_model2'];
						}
					if(array_key_exists('inputs',$cleanData))
					{
						if(sizeof($cleanData['inputs'])>0)
						{
							$i = 0;
							foreach($cleanData['inputs'] as $inp)
							{
								$inputoutputdata[$i]['inp_name'] = $inp;
								$inputoutputdata[$i]['inp_status'] = 1;
								$inputoutputdata[$i]['encid'] = $cleanData['encoderId'];
								$i++;
							}
							$i = 0;
							foreach($cleanData['videoinputsources'] as $vide)
							{
								$inputoutputdata[$i]['inp_source'] = $vide;
								$i++;
							}
							$i = 0;
							foreach($cleanData['audiosources'] as $aud)
							{
								$inputoutputdata[$i]['inp_aud_source'] = $aud;
								$i++;
							}
							$i = 0;
							foreach($cleanData['outputs'] as $out)
							{
								$outputdata[$i]['out_name'] = $out;
								$outputdata[$i]['out_status'] = 1;
								$outputdata[$i]['encid'] = $cleanData['encoderId'];
								$outputdata[$i]['created'] = time();

								$i++;
							}
							$i = 0;
							foreach($cleanData['videooutputsources'] as $out)
							{
								$outputdata[$i]['out_destination'] = $out;
								$i++;
							}
							$i = 0;
							foreach($cleanData['encoderOutputFormat'] as $form)
							{
								$outputdata[$i]['out_format'] = $form;
								$i++;
							}
						}
					}
						if($id >= 0)
						{
							$this->common_model->deleteEncoderSources($cleanData['encoderId']);
							$this->common_model->deleteEncoderDestinations($cleanData['encoderId']);
							if(sizeof($hardwaredata)>0)
							{
								foreach($hardwaredata as $hard)
								{
									$Hid = $this->common_model->updateEncoderHardware($hard,$cleanData['encoderId']);

								}
							}
							if(sizeof($inputoutputdata)>0)
							{
								foreach($inputoutputdata as $inpoup)
								{
									//$Hid = $this->common_model->updateEncoderInp($inpoup,$id);
									$Hid = $this->common_model->insertEncoderHardwareInpOut($inpoup);
								}

							}
							if(sizeof($outputdata)>0)
							{
								foreach($outputdata as $Outt)
								{
									//$Oid = $this->common_model->updateEncoderOut($Outt,$id);
									$Oid = $this->common_model->insertEncoderHardwareOut($Outt);
								}

							}
							$this->session->set_flashdata('message_type', 'success');
							$this->session->set_flashdata('success', 'Encoder is sucessfully updated!');
							redirect('configuration');
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'Error occur while updating encoder!');
							redirect('configuration');
						}
					}
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while updating encoder!');
				redirect('configuration');
			}
		}
		/* Encoder Reboot */
		public function encoderReboot()
		{
			$response = array('status'=>FALSE,'response'=>array());
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$wid = explode("_",$cleanData['wowzaId']);
			$encoder = $this->common_model->getAllEncoders($wid[1],0);
			$ip = $encoder[0]["encoder_ip"];
			$username = $encoder[0]["encoder_uname"];
			$password = $encoder[0]["encoder_pass"];
			$port = "22";
			$ssh = new Net_SSH2($ip);
			if (!$ssh->login($username, $password,$port)) {
				$response['status'] = FALSE;
				$response['response'][$wid[1]] = array('status'=>FALSE,'response'=>"NOT Connecting");
			}
			else
			{
				$resp = $ssh->exec("echo ".$password." | sudo -S reboot");
				$response['status'] = TRUE;
				$response['response'][$wid[1]] = array('status'=>TRUE,'response'=>"Reboot Successfully!");
			}
			echo json_encode($response);
		}
		/* Encoder Refresh */
		public function encoderRefresh()
		{
			$response = array('status'=>TRUE,'response'=>array());
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$wid = explode("_",$cleanData['wowzaId']);
			$encoder = $this->common_model->getAllEncoders($wid[1],0);
			$ip = $encoder[0]["encoder_ip"];
			$username = $encoder[0]["encoder_uname"];
			$password = $encoder[0]["encoder_pass"];
			$port = "22";
			if (!$socket = @fsockopen("$ip", 22, $errno, $errstr, 2))
			{
				$response['response'][$wid[1]] = array('status'=>FALSE,'response'=>"fail");
			}
			else
			{
				$resp = $ssh->exec("uptime -p");
				$response['response'][$wid[1]] =  array('status'=>TRUE,'response'=>$resp);
			 	fclose($socket);
			}
			echo json_encode($response);
		}
		/* Encoding Template */
		public function updateencodingtemplate()
		{
			$this->breadcrumbs->push('Configuration/Edit Encoding Presets', '/configuration');
			$id = $this->uri->segment(2);
			$data['template'] = $this->common_model->getEncodingTemplateById($id);
			$this->load->view('admin/header');
			$this->load->view('admin/updateencodingtemplate',$data);
			$this->load->view('admin/footer');
		}
		public function appsLockUnlock()
		{
			$response = array('status'=>FALSE,'response'=>"");
			$userdata = $this->session->userdata('user_data');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$cid = $cleanData['id'];
			$idarray = explode('_',$cid);
			$action = $cleanData['action'];
			if($action != "")
			{
				switch($action)
				{
					case "Lock":
						$data = array(
							'isLocked'=>1
						);
					break;
					case "UnLock":
						$data = array(
							'isLocked'=>0
						);
					break;
				}
				$sts = $this->common_model->updateApplication($idarray[1],$data);
				if($sts >=0)
				{
					$response['status'] = TRUE;
					$response['response'] = $action." Successfully!";
				}
				else
				{
					$response['status'] = TRUE;
					$response['response'] = "Error occured while ".$action."ing application!";
				}
			}
			echo json_encode($response);
		}
		public function channelsLockUnlock()
		{
			$response = array('status'=>FALSE,'response'=>"");
			$userdata = $this->session->userdata('user_data');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$cid = $cleanData['id'];
			$idarray = explode('_',$cid);
			$action = $cleanData['action'];
			if($action != "")
			{
				switch($action)
				{
					case "Lock":
						$data = array(
							'isLocked'=>1
						);
					break;
					case "UnLock":
						$data = array(
							'isLocked'=>0
						);
					break;
				}
				$sts = $this->common_model->updateChannels($data,$idarray[1]);
				if($sts >=0)
				{
					$response['status'] = TRUE;
					$response['response'] = $action." Successfully!";
				}
				else
				{
					$response['status'] = TRUE;
					$response['response'] = "Error occured while ".$action."ing channel!";
				}
			}
			echo json_encode($response);
		}
		public function allchannels()
		{
			$this->breadcrumbs->push('Channels', '/channels');
			$userdata =$this->session->userdata('user_data');
			$channelsLocks = array();
			if($userdata['user_type'] == 1)
			{
				$data['channels'] = $this->common_model->getAllChannels(0);
				$channelAdmin = $this->common_model->getAllChannels(0);
				if(sizeof($channelAdmin)>0)
				{
					foreach($channelAdmin as $ch)
					{
						$channelsLocks[$ch['id']] = $ch['isLocked'];
					}
				}
			}
			elseif($userdata['user_type'] == 2 || $userdata['user_type'] == 3)
			{
				$idsss = array($userdata['group_id']);
				$useids = $this->common_model->getUsersByGroupIds($idsss);
				$USERidS = array();
				if(sizeof($useids)>0)
				{
					foreach($useids as $u)
					{
						array_push($USERidS,$u['id']);
					}
				}
				$data['channels'] = $this->common_model->getAllChannelsByUserids($USERidS);
				$channelUser = $this->common_model->getAllChannelsByUserids($userdata['userid']);
				if(sizeof($channelUser)>0)
				{
					foreach($channelUser as $chu)
					{
						$channelsLocks[$chu['id']] = $chu['isLocked'];
					}
				}

			}
			$data['channelsLock'] = $channelsLocks;

			$this->load->view('admin/header');
			$this->load->view('admin/ALLchannels',$data);
			$this->load->view('admin/footer');
		}
		/* Channel Listing */
		public function channels()
		{
			$this->breadcrumbs->push('Channels', '/channels');
			$userdata =$this->session->userdata('user_data');
			$channelsLocks = array();
			if($userdata['user_type'] == 1)
			{
				$data['channels'] = $this->common_model->getAllChannels(0);
				$channelAdmin = $this->common_model->getAllChannels(0);
				$data['channelTabs'] = $this->common_model->getAllChannelGroups(0);
				$data['channelGroupMapping'] = $this->common_model->getChannelGroupMapping($userdata['userid']);
				if(sizeof($channelAdmin)>0)
				{
					foreach($channelAdmin as $ch)
					{
						$channelsLocks[$ch['id']] = $ch['isLocked'];
					}
				}
			}
			elseif($userdata['user_type'] == 2 || $userdata['user_type'] == 3)
			{
				$idsss = array($userdata['group_id']);
				$useids = $this->common_model->getUsersByGroupIds($idsss);
				$USERidS = array();
				if(sizeof($useids)>0)
				{
					foreach($useids as $u)
					{
						array_push($USERidS,$u['id']);
					}
				}
				$data['channels'] = $this->common_model->getAllChannelsByUserids($USERidS);
				$channelUser = $this->common_model->getAllChannelsByUserids($userdata['userid']);
				$data['channelTabs'] = $this->common_model->getChannelGroups($USERidS);
				$data['channelGroupMapping'] = $this->common_model->getChannelGroupMapping($userdata['userid']);
				if(sizeof($channelUser)>0)
				{
					foreach($channelUser as $chu)
					{
						$channelsLocks[$chu['id']] = $chu['isLocked'];
					}
				}

			}
			$data['channelsLock'] = $channelsLocks;
			$this->load->view('admin/header');
			$this->load->view('admin/channels',$data);
			$this->load->view('admin/footer');
		}
		/* Channel Create New Form */
		public function createchannel()
		{
			$this->breadcrumbs->push('Channels/New Channel', '/createchannel');
			$permissions = $this->session->userdata('user_permissions');
			if($permissions['create_channel'] <= 0)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', "You are not authorized to Add Channels");
				redirect('channels');
			}
			elseif($permissions['create_channel'] == 1)
			{
				$userdata =$this->session->userdata('user_data');
				$data['audiochannels'] = $this->common_model->getAudioChannels();
				if($userdata['user_type'] == 1)
				{
					$data['apps'] = $this->common_model->getAllApplications(0);
					$data['encoders'] = $this->common_model->getAllEncodersbyStatus(0,0);
					$data['profiles'] = $this->common_model->getEncoderProfiles();

				}
				else
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
					$data['apps'] = $this->Groupadmin_model->getAllApplicationsByWowzaIdAndUserId($wowzids,$userdata['userid']);
					$data['encoders'] = $this->Groupadmin_model->getAllOnlineEncodersbyUserIdAndGroupId($userdata['userid'],$userdata['group_id']);
					$data['profiles'] = $this->Groupadmin_model->getEncoderProfilesByUseridAndGroupId($userdata['userid'],$userdata['group_id']);
				}

				if($userdata['user_type'] == 1)
				{
				  $data['channelgroups'] = $this->common_model->getAllChannelGroups(0);
				}
				elseif($userdata['user_type'] == 2 || $userdata['user_type'] == 3)
				{
				  $idsss = array($userdata['group_id']);
				  $useids = $this->common_model->getUsersByGroupIds($idsss);
				  $USERidS = array();
				  if(sizeof($useids)>0)
				  {
				    foreach($useids as $u)
				    {
				      array_push($USERidS,$u['id']);
				    }
				  }
				$data['channelgroups'] = $this->common_model->getChannelGroups($USERidS);}
				$this->load->view('admin/header');
				$this->load->view('admin/createchannels',$data);
				$this->load->view('admin/footer');
			}
		}
		/* Channels Update Form */
		public function updatechannel()
		{
			$this->breadcrumbs->push('Channels/Edit Channel', '/channels');
			$id = $this->uri->segment(2);
			$userdata =$this->session->userdata('user_data');
			$data['audiochannels'] = $this->common_model->getAudioChannels();
			$ch = $this->common_model->getChannelbyId($id);
			$encid = 0;
			$encid = $ch[0]['encoderid'];
			if($userdata['user_type'] == 1)
			{

				$data['apps'] = $this->common_model->getAllApplications(0);
				$data['encoders'] = $this->common_model->getAllEncodersbyStatusAndEnc(0,0,$encid);
				$data['profiles'] = $this->common_model->getEncoderProfiles();
				$data['channels'] = $this->common_model->getChannelbyId($id);
			}
			else
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
					$data['apps'] = $this->Groupadmin_model->getAllApplicationsByWowzaIdAndUserId($wowzids,$userdata['userid']);

					$data['encoders'] = $this->Groupadmin_model->getAllOnlineEncodersbyUserIdAndGroupIdAndEncdi($userdata['userid'],$userdata['group_id'],$encid);
					//$data['encoders'] = $this->Groupadmin_model->getAllOnlineEncodersbyUserIdAndGroupId($userdata['userid'],$userdata['group_id']);
					$data['profiles'] = $this->Groupadmin_model->getEncoderProfilesByUseridAndGroupId($userdata['userid'],$userdata['group_id']);
					$data['channels'] = $this->common_model->getChannelbyId($id);
			}

			if($userdata['user_type'] == 1)
			{
				$data['channelgroups'] = $this->common_model->getAllChannelGroups(0);
			}
			elseif($userdata['user_type'] == 2 || $userdata['user_type'] == 3)
			{
				$idsss = array($userdata['group_id']);
				$useids = $this->common_model->getUsersByGroupIds($idsss);
				$USERidS = array();
				if(sizeof($useids)>0)
				{
					foreach($useids as $u)
					{
						array_push($USERidS,$u['id']);
					}
				}
			$data['channelgroups'] = $this->common_model->getChannelGroups($USERidS);}
			$data['ugroup'] = $userdata['group_id'];
			//echo $userdata['group_id'].'__'.$userdata['userid'];
			$GChannelId = $this->uri->segment(2);
			$data['channelMapping'] = $this->common_model->getChannelGroupMappingByChannelId($GChannelId);

			$this->load->view('admin/header');
			$this->load->view('admin/updatechannel',$data);
			$this->load->view('admin/footer');
		}
		/* Channels Save */
		public function saveChannel()
		{
			try{
				$post     = $this->input->post();
				$actual_link =  $_SERVER['HTTP_REFERER'];
				$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));

				//die;
				$userdata = $this->session->userdata('user_data');
				$apps =0;$encid =0;
				if($cleanData['channel_apps'] != "")
				{
					$apps = $cleanData['channel_apps'];
				}
				$is_scheduled = 0;
				$processname = 'CH'.$this->random_string(10);

				$eids = explode("_",$cleanData['channelInput']);
				$ids = explode("_",$cleanData['channelOutpue']);
				$ndisoucewe ="";
				$isRemote = 0;
				if($eids[0]== "phyinput")
				{
					$encid = $eids[2];
				}
				elseif($eids[0] == "virinput")
				{
					$src = explode('#',$cleanData['channel_ndi_source']);
					$encid = $src[0];
					$ndisoucewe = $src[1];
					if($src[2] == "Remote")
					{
						$isRemote = 1;
					}
				}
				else
				{
					$encid = 0;
				}
				if($ids[0] == "phyoutput")
				{
					$encid = $ids[2];
				}

				if($cleanData['encoding_profile'] == "")
				{
					$encodingProfile = 0;
				}
				else
				{
					$encodingProfile = $cleanData['encoding_profile'];
				}

				if(array_key_exists('enablechannelSchedule',$cleanData))
				{
					$is_scheduled = 1;
				}
				$is_IPAddress = 0;
				if(array_key_exists('isIPAddress',$cleanData))
				{
					$is_IPAddress = 1;
				}
				$ip_addresses_comma = "";
				if(array_key_exists('ip_addresses_comma',$cleanData))
				{
					$ip_addresses_comma = $cleanData['ip_addresses_comma'];
				}
				$record_channel = 0;
				if(array_key_exists('record_channel',$cleanData))
				{
					$record_channel = 1;
				}
				$type = "";
				$cinputs = explode('_',$cleanData['channelInput']);
				$coutputs = explode('_',$cleanData['channelOutpue']);
				switch($cinputs[0])
				{
					case "phyinput":
					$type = "SDITO";
					break;
					case "virinput":
						switch($cinputs[1])
						{
							case 3:
							$type = "NDITO";
							break;
							case 4:
							$type = "RTMPTO";
							break;
							case 5:
							$type = "MPEGRTPTO";
							break;
							case 6:
							$type = "MPEGUDPTO";
							break;
							case 7:
							$type = "MPEGSRTTO";
							break;
							case 8:
							$type = "HTTPLIVETO";
							break;
						}
					break;
				}
				switch($coutputs[0])
				{
					case "phyoutput":
					$type .= "SDI";
					break;
					case "viroutput":
						switch($coutputs[1])
						{
							case 3:
							$type .= "NDI";
							break;
							case 4:
							$type .= "RTMP";
							break;
							case 5:
							$type .= "MPEGRTP";
							break;
							case 6:
							$type .= "MPEGUDP";
							break;
							case 7:
							$type .= "MPEGSRT";
							break;
							case 8:
							$type .= "HTTPLIVE";
							break;
							case 9:
							$type .= "FILE";
							break;
						}
					break;
				}
				$encoder = $this->common_model->getAllEncoders($encid,0);
				if(sizeof($encoder)>0)
				{
					$processname = $processname.'_'.$encoder[0]['encoder_id'];
				}
				$EncrID = 0;
				if($cleanData['channelEncoders'] != "")
				{
					$EncrIDs = explode('_',$cleanData['channelEncoders']);
					$EncrID = $EncrIDs[1];
				}
				$chennelData = array(
					'uid'=>$userdata['userid'],
					'channel_type'=>$type,
                	'channel_name'=>$cleanData['channel_name'],
                	'encoder_id'=>$encid,
                	'channelInput'=>$cleanData['channelInput'],
                	'audio_channel'=>$cleanData['sdi_audio_channel'],
                	'channel_ndi_source'=>$ndisoucewe,
                	'input_rtmp_url'=>$cleanData['input_rtmp_url'],
                	'input_mpeg_rtp'=>$cleanData['input_mpeg_rtp'],
                	'input_mpeg_udp'=>$cleanData['input_mpeg_udp'],
                	'input_mpeg_srt'=>$cleanData['input_mpeg_srt'],
                	'channelOutpue'=>$cleanData['channelOutpue'],
                	'ndi_name'=>$cleanData['ndi_name'],
                	'channel_apps'=>$apps,
                	'output_rtmp_url'=>$cleanData['output_rtmp_url'],
                	'output_rtmp_key'=>$cleanData['output_rtmp_key'],
                	'output_mpeg_rtp'=>$cleanData['output_mpeg_rtp'],
                	'output_mpeg_udp'=>$cleanData['output_mpeg_udp'],
                	'output_mpeg_srt'=>$cleanData['output_mpeg_srt'],
                	'auth_uname'=>$cleanData['auth_uname'],
                	'auth_pass'=>$cleanData['auth_pass'],
                	'encoding_profile'=>$encodingProfile,
                	'status'=>1,
                	'created'=>time(),
                	'process_name'=>$processname,
                	'input_hls_url'=>$cleanData['input_hls_url'],
                	'is_scheduled'=>$is_scheduled,
                	'startdate'=>$cleanData['channel_starttime'],
                	'enddate'=>$cleanData['channel_endtime'],
                	'isIPAddresses'=>$is_IPAddress,
                	'ipAddress'=>$ip_addresses_comma,
                	'isRemote'=>$isRemote,
                	'encoderid'=>$EncrID,
                	'record_file'=>$cleanData['record_file'],
                	'recording_presets'=>$cleanData['recording_encoding_profile'],
									'recording_preset_script'=>$cleanData['recording_preset_script'],
                	'is_record_channel'=>$record_channel
				);

				$id = $this->common_model->insertChannels($chennelData);
				if($id > 0)
				{
						if ($cleanData['channelGroup'] > 0) {
							$grpupData = array(
								'channelId'=>$id,
								'groupid'=>$cleanData['channelGroup'],
								'uid'=>$userdata['userid']
							);
							$this->common_model->insertChannelGroupMapping($grpupData);
						}
						if($cleanData['enablechannelSchedule'] != "")
						{

							$type = "";
							$inpids = explode("_",$cleanData['channelInput']);
							$outids = explode("_",$cleanData['channelOutpue']);
							if($inpids[0] == "phyinput")
							{
								$type = "SDI";
							}
							if($inpids[0] == "virinput")
							{
								switch($inpids[1])
								{
									case "3":
									$type = "NDI";
									break;
									case "4":
									$type = "RTMP";
									break;
									case "5":
									$type = "MPEG-RTP";
									break;
									case "6":
									$type = "MPEG-UDP";
									break;
									case "7":
									$type = "MPEG-SRT";
									break;
								}
							}
							$type = $type ." to ";
							if($outids[0] == "phyoutput")
							{
								$type = $type ."SDI";
							}
							if($outids[0] == "viroutput")
							{
								switch($outids[1])
								{
									case "3":
									$type = $type."NDI";
									break;
									case "4":
									$type = $type."RTMP";
									break;
									case "5":
									$type = $type."MPEG-RTP";
									break;
									case "6":
									$type = $type."MPEG-UDP";
									break;
									case "7":
									$type = $type."MPEG-SRT";
									break;
									case "8":
									$type = $type."HTTP-LIVE";
									break;
									case "9":
									$type = $type."FILE";
									break;
								}
							}
							$startname = "Channel_Start_".$processname.".sh";
							$stopname = "Channel_Stop_".$processname.".sh";
							$starttime = $this->getDateTime($cleanData['channel_starttime']);
							$stoptime = $this->getDateTime($cleanData['channel_endtime']);
							$startfile =  $starttime["m"].' '.$starttime["h"].' '.$starttime["day"].' '.$starttime["month"].' * /home/ksm/scheduler/'.$startname;
							$stopfile = $stoptime["m"].' '.$stoptime["h"].' '.$stoptime["day"].' '.$stoptime["month"].' * /home/ksm/scheduler/'.$stopname;
							$dataS = array(
								'schedule_type'=>'channel',
								'type'=>$type,
								'sid'=>$id,
								'start_datetime'=>$cleanData['channel_starttime'],
								'end_datetime'=>$cleanData['channel_endtime'],
								'status'=>1,
								'created'=>time(),
								'start_job'=>$startfile,
								'stop_job'=>$stopfile,
								'start_filename'=>$startname,
								'stop_filename'=>$stopname,
								'uid'=>$userdata['userid']
							);
							$this->common_model->insertSchedule($dataS);

							$is_scheduled = 1;
							$ip = $this->config->item('ServerIP');
							$username = $this->config->item('ServerUser');
							$password = $this->config->item('ServerPassword');
							$port = '22';
							$ssh = new Net_SSH2($ip);
							if ($ssh->login($username, $password,$port)) {

								$ssh->exec("touch /home/ksm/scheduler/".$startname);
								$ssh->exec("chmod +x /home/ksm/scheduler/".$startname);

								$ssh->exec('echo "curl -k -H  \'Content-Type: application/json\'  --data \'{\"process\":\"'.$processname.'\"}\'  '.$this->config->item('startChannelPath').' >> /home/ksm/scheduler/scheduler.log" >>  /home/ksm/scheduler/'.$startname);
								$ssh->exec('echo "echo \"\n----------------------------------------------\n\" >> /home/ksm/scheduler/scheduler.log" >>  /home/ksm/scheduler/'.$startname);

								$ssh->exec("touch /home/ksm/scheduler/".$stopname);
								$ssh->exec("chmod +x /home/ksm/scheduler/".$stopname);
								$ssh->exec('echo "curl -k -H  \'Content-Type: application/json\'  --data \'{\"process\":\"'.$processname.'\"}\'  '.$this->config->item('stopChannelPath').' >> /home/ksm/scheduler/scheduler.log" >>  /home/ksm/scheduler/'.$stopname);
								$ssh->exec('echo "echo \"\n----------------------------------------------\n\" >> /home/ksm/scheduler/scheduler.log" >>  /home/ksm/scheduler/'.$stopname);
								$starttime = $this->getDateTime($cleanData['channel_starttime']);
								$stoptime = $this->getDateTime($cleanData['channel_endtime']);

								$ssh->exec('(crontab -l; echo "'.$starttime["m"].' '.$starttime["h"].' '.$starttime["day"].' '.$starttime["month"].' * /home/ksm/scheduler/'.$startname.'") | crontab -');
								$ssh->exec('(crontab -l; echo "'.$stoptime["m"].' '.$stoptime["h"].' '.$stoptime["day"].' '.$stoptime["month"].' * /home/ksm/scheduler/'.$stopname.'") | crontab -');
							}
						}
					$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'Channel is sucessfully saved!');
					redirect('admin/channels');
				}
				else
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error occur while creating Channel!');
					redirect('admin/channels');
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while creating Channel!');
				redirect('admin/channels');
			}
		}
		function getDateTime($date)
		{
			$dateTimeArray = explode(" ",$date);
			$dateArray = explode("/",$dateTimeArray[0]);
			$timeArray = explode(":",$dateTimeArray[1]);
			return array("day"=>$dateArray[0],"month"=>$dateArray[1],"year"=>$dateArray[2],"h"=>$timeArray[0],"m"=>$timeArray[1],"s"=>$timeArray[2]);
		}
		/* Channels Update Existing  */
		public function updateExistingChannel()
		{
			try{
				$permissions = $this->session->userdata('user_permissions');
				if($permissions['edit_channel'] <= 0)
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', "You are not authorized to update Channels.");
					redirect('channels');
				}
				elseif($permissions['edit_channel'] == 1)
				{
					$cid = $this->uri->segment(3);
					$post = $this->input->post();
					$actual_link =  $_SERVER['HTTP_REFERER'];
					$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
					$userdata = $this->session->userdata('user_data');
					$apps =0;$encid =0;
					if($cleanData['channel_apps'] != "")
					{
						$apps = $cleanData['channel_apps'];
					}


					$eids = explode("_",$cleanData['channelInput']);
					$ids = explode("_",$cleanData['channelOutpue']);
					$ndisoucewe ="";$isRemote=0;
					if($eids[0]== "phyinput")
					{
						$encid = $eids[2];
					}
					elseif($eids[0] == "virinput")
					{
						$src = explode('#',$cleanData['channel_ndi_source']);
						$encid = $src[0];
						$ndisoucewe = $src[1];
						if($src[2] == "Remote")
						{
							$isRemote = 1;
						}
					}
					else
					{
						$encid = 0;
					}
					if($ids[0] == "phyoutput")
					{
						$encid = $ids[2];
					}

					$is_IPAddress = 0;
					if(array_key_exists('isIPAddress',$cleanData))
					{
						$is_IPAddress = 1;
					}

					$type = "";
					$cinputs = explode('_',$cleanData['channelInput']);
					$coutputs = explode('_',$cleanData['channelOutpue']);
					switch($cinputs[0])
					{
						case "phyinput":
						$type = "SDITO";
						break;
						case "virinput":
							switch($cinputs[1])
							{
								case 3:
								$type = "NDITO";
								break;
								case 4:
								$type = "RTMPTO";
								break;
								case 5:
								$type = "MPEGRTPTO";
								break;
								case 6:
								$type = "MPEGUDPTO";
								break;
								case 7:
								$type = "MPEGSRTTO";
								break;
								case 8:
								$type = "HTTPLIVETO";
								break;
							}
						break;
					}
					switch($coutputs[0])
					{
						case "phyoutput":
						$type .= "SDI";
						break;
						case "viroutput":
							switch($coutputs[1])
							{
								case 3:
								$type .= "NDI";
								break;
								case 4:
								$type .= "RTMP";
								break;
								case 5:
								$type .= "MPEGRTP";
								break;
								case 6:
								$type .= "MPEGUDP";
								break;
								case 7:
								$type .= "MPEGSRT";
								break;
								case 8:
								$type .= "HTTPLIVE";
								break;
								case 9:
								$type .= "FILE";
								break;
							}
						break;
					}
					$processname ="";
					$encoder = $this->common_model->getAllEncoders($encid,0);
					if(sizeof($encoder)>0)
					{
						$enciddd = explode('_',$cleanData['processname']);

						$processname = $enciddd[0].'_'.$encoder[0]['encoder_id'];
					}
					else
					{
						$processname = $cleanData['processname'];
					}
					$record_channel =0;
					if(array_key_exists('record_channel',$cleanData))
					{
						$record_channel = 1;
					}
					$is_IPAddress = 0;
					if(array_key_exists('isIPAddress',$cleanData))
					{
						$is_IPAddress = 1;
					}
					$ip_addresses_comma = "";
					if(array_key_exists('ip_addresses_comma',$cleanData))
					{
						$ip_addresses_comma = $cleanData['ip_addresses_comma'];
					}
					$EncrID = 0;
					if($cleanData['channelEncoders'] != "")
					{
						$EncrIDs = explode('_',$cleanData['channelEncoders']);
						$EncrID = $EncrIDs[1];
					}
					$chennelData = array(
	                	'channel_name'=>$cleanData['channel_name'],
	                	'encoder_id'=>$encid,
	                	'channel_type'=>$type,
	                	'audio_channel'=>$cleanData['sdi_audio_channel'],
										'sdi_out_audio_channels'=>$cleanData['sdi_out_audio_channels'],
	                	'channelInput'=>$cleanData['channelInput'],
	                	'channel_ndi_source'=>$ndisoucewe,
	                	'input_rtmp_url'=>$cleanData['input_rtmp_url'],
	                	'input_mpeg_rtp'=>$cleanData['input_mpeg_rtp'],
	                	'input_mpeg_udp'=>$cleanData['input_mpeg_udp'],
	                	'input_mpeg_srt'=>$cleanData['input_mpeg_srt'],
	                	'channelOutpue'=>$cleanData['channelOutpue'],
	                	'ndi_name'=>$cleanData['ndi_name'],
	                	'channel_apps'=>$apps,
	                	'output_rtmp_url'=>$cleanData['output_rtmp_url'],
	                	'output_rtmp_key'=>$cleanData['output_rtmp_key'],
	                	'output_mpeg_rtp'=>$cleanData['output_mpeg_rtp'],
	                	'output_mpeg_udp'=>$cleanData['output_mpeg_udp'],
	                	'output_mpeg_srt'=>$cleanData['output_mpeg_srt'],
	                	'auth_uname'=>$cleanData['auth_uname'],
	                	'auth_pass'=>$cleanData['auth_pass'],
	                	'encoding_profile'=>$cleanData['encoding_profile'],
	                	'input_hls_url'=>$cleanData['input_hls_url'],
	                	'isIPAddresses'=>$is_IPAddress,
                		'ipAddress'=>$ip_addresses_comma,
                		'isRemote'=>$isRemote,
                		'process_name'=>$processname,
                		'encoderid'=>$EncrID,
	                	'record_file'=>$cleanData['record_file'],
	                	'recording_presets'=>$cleanData['recording_encoding_profile'],
										'recording_preset_script'=>$cleanData['recording_preset_script'],
	                	'is_record_channel'=>$record_channel
					);

					$id = $this->common_model->updateChannels($chennelData,$cid);
					if ($cleanData['channelGroup'] > 0) {
						$grpupData = array(
						'channelId'=>$cid,
						'groupid'=>$cleanData['channelGroup'],
						'uid'=>$userdata['userid']
						);
						$isExistingTab = $this->common_model->getChannelIdsbyMappingChannelId($userdata['userid'],$cid);
						if (sizeof($isExistingTab)>0) {
							$this->common_model->updateChannelGroupMapping($grpupData,$isExistingTab[0]['id']);
						}
						else {
							$this->common_model->insertChannelGroupMapping($grpupData);
						}

					}
					if($id >= 0)
					{

						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Channel is sucessfully updated!');
						redirect('admin/channels');
					}
					else
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error occur while updating channel!');
						redirect('admin/channels');
					}
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while updating channel!');
				redirect('admin/channels');
			}
		}
		/* Channel Actions */
		public function channelActions()
		{
			$sts = FALSE;
			$response = array('status'=>FALSE,'response'=>array());
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$chid = $cleanData['id'];
			$action = $cleanData['action'];
			switch($action){
				case "Refresh":
				if(sizeof($chid)>0)
				{
					foreach($chid as $cid)
					{
						$wowzaEngine = $this->common_model->getChannelbyId($cid);
					}
				}
				break;
				case "Reboot":
				if(sizeof($chid)>0)
				{
					foreach($chid as $cid)
					{
						$wowzaEngine = $this->common_model->getChannelbyId($cid);

					}
				}
				break;
				case "Archive":
				if(sizeof($chid)>0)
				{
					foreach($chid as $cid)
					{
						$data = array(
							'status'=>0
						);
						$sts = $this->common_model->updateChannels($data,$cid);
						if($sts > 0)
						{
							$response['response'][$cid]['status'] = TRUE;
							$response['response'][$cid]['response'] = $action." Successfully!";
						}
						else
						{
							$response['response'][$cid]['status'] = FALSE;
							$response['response'][$cid]['response'] = "Error occure while ".$action." Publisher!";
						}
					}
				}
				break;
				case "Restore":
				if(sizeof($chid)>0)
				{
					foreach($chid as $cid)
					{
						$data = array(
							'status'=>1
						);
						$sts = $this->common_model->updateChannels($data,$cid);
						if($sts > 0)
						{
							$response['response'][$cid]['status'] = TRUE;
							$response['response'][$cid]['response'] = $action." Successfully!";
						}
						else
						{
							$response['response'][$cid]['status'] = FALSE;
							$response['response'][$cid]['response'] = "Error occure while ".$action." Publisher!";
						}
					}
				}
				break;
				case "Delete":
				if(sizeof($chid)>0)
				{
					foreach($chid as $cid)
					{
						$sts = $this->common_model->deleteChannel($cid);
						if($sts > 0)
						{
							$response['response'][$cid]['status'] = TRUE;
							$response['response'][$cid]['response'] = $action." Successfully!";
						}
						else
						{
							$response['response'][$cid]['status'] = FALSE;
							$response['response'][$cid]['response'] = "Error occure while ".$action." Publisher!";
						}
					}
				}
				break;
			}
			echo json_encode($response);
		}
		/* Applications Refresh */
		function apptargets()
		{
			$appid = $this->uri->segment(3);
			$data['targets'] = $this->common_model->getTargetbyAppID($appid);
			$this->load->view('admin/header');
			$this->load->view('admin/appTargets',$data);
			$this->load->view('admin/footer');
		}
		/* Wowza Refresh Action */
		public function applicaitonRestart()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$wids = $cleanData['wowzaId'];
			$wid = explode('_',$wids);
			$app = $this->common_model->getAppbyId($wid[1]);
			$woId = $app[0]['live_source'];
			$wowzaEngine = $this->common_model->getWowzabyID($woId);
			$URL = "http://";
			$URL = $URL.$wowzaEngine[0]['ip_address'].":".$wowzaEngine[0]['rest_api_port']."/v2/servers/_defaultServer_/status";

			$curl = curl_init($URL);
			curl_setopt($curl, CURLOPT_FAILONERROR, true);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_HEADER, true);    // we want headers
			curl_setopt($curl, CURLOPT_NOBODY, true);    // we don't need body
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($curl, CURLOPT_TIMEOUT_MS, 300); //timeout in seconds
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($curl);
			$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
			$sts = $httpcode;
			if($httpcode == 200)
			{
				$response['status'] = TRUE;
				$response['response'] = $httpcode;
			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = $httpcode;
			}
			echo json_encode($response);
		}
		public function getNDISource()
		{
			$response = array('status'=>FALSE,'response'=>array());
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$userdata = $this->session->userdata('user_data');
			if($userdata['user_type'] == 1)
			{
				$encoders = $this->common_model->getAllEncodersbyStatus(0,0);
			}
			elseif($userdata['user_type'] == 2 || $userdata['user_type'] == 3)
			{
				$encoders = $this->Groupadmin_model->getAllOnlineEncodersbyUserIdAndGroupId($userdata['userid'],$userdata['group_id']);
			}
			$IDS = explode('_',$cleanData['id']);
			$encoders = $this->common_model->getAllEncodersbyStatus($IDS[1],0);
			//print_r($encoders);
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

						$ips = $cleanData['txt'];
						$ipArray = array();
						if($ips != "NULL" && $ips != "")
						{
							$ipArray = explode(',',$ips);
							$resp = $ssh->exec("ffmpeg -f libndi_newtek -extra_ips ".$ips." -find_sources 1 -i dummy");
						}
						else
						{
							$resp = $ssh->exec("ffmpeg -f libndi_newtek -find_sources 1 -i dummy");
						}

						if (strpos($resp, 'NDI sources:') !== false) {
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
									if($ele != "" && strpos($ele, 'Immediate') == false && strpos($ele, 'Last message repeated 1 times') == false)
									{
										$node = explode("'",$ele);
										$RemoteIP = explode(':',$node[3]);
										$remote = FALSE;
										if(in_array($RemoteIP[0],$ipArray))
										{
											$remote = TRUE;
										}
										$ndiArray[] = array('encid'=>$encoder['id'],'encname'=>$encoder['encoder_name'],'ndiname'=>$node[1],'isRemote'=>$remote);
									}
								}
								$ndiFullArray[$encoder['encoder_name']] = $ndiArray;
							}
							$response['status']= TRUE;
							$response['response']= $ndiFullArray;
						}
					}
					else
					{
						$response['status']= FALSE;
						$response['response']= "Not Able to Login to this Encoder!";
					}
				}
			}
			echo json_encode($response);
		}
		public function templateEnableDisable()
		{
			$response = array('status'=>FALSE,'response'=>'');$sts=0;
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$templateId = $cleanData['templateId'];
			$action = $cleanData['action'];
			switch($action)
			{
				case "Enable":
				$data = array('status'=>1);
				$sts = $this->common_model->updateTemplate($data,$templateId);
				break;
				case "Disable":
				$data = array('status'=>0);
				$sts = $this->common_model->updateTemplate($data,$templateId);
				break;
			}

			if($sts > 0)
			{
				$response['status'] = TRUE;
				$response['response'] = $action." Successfully";
			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = "Error Occurred While ".$action." template";
			}
			echo json_encode($response);
		}
		public function templateDelete()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$templateId = $cleanData['templateId'];
			$sts = $this->common_model->deleteTemplate($templateId);
			if($sts > 0)
			{
				$response['status'] = TRUE;
				$response['response'] = "Deleted Successfully";
			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = "Error Occurred While deleting template";
			}
			echo json_encode($response);
		}
		public function createtemplate()
		{
			$this->breadcrumbs->push('Configuration/New Encoding Preset', '/configuration');
			$permissions = $this->session->userdata('user_permissions');
			if($permissions['create_template'] <= 0)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', "You are not authorized to add Encoding Preset.");
				redirect('configuration');
			}
			elseif($permissions['create_template'] == 1)
			{
				$this->load->view('admin/header');
				$this->load->view('admin/createencodingtemplate');
				$this->load->view('admin/footer');
			}
		}
		public function editTarget()
		{
			$this->breadcrumbs->push('Apps/Edit Target', '/applications');
			$id = $this->uri->segment(2);
			$data['target'] = $this->common_model->getTargetbyId($id);
			$userdata = $this->session->userdata('user_data');
			$wowzids = array();$apids = array();
			if($userdata['user_type'] == 1)
			{
				$data['apps'] = $this->common_model->getAllApplications(0);
			}
			else
			{
				$wowzaids = $this->Groupadmin_model->getConfigurationsDetails($userdata['userid'],$userdata['group_id']);
				if(sizeof($wowzaids)>0)
				{
					foreach($wowzaids as $wow)
					{
						array_push($wowzids,$wow['id']);
					}
				}
				$data['apps'] = $this->Groupadmin_model->getAllApplicationsByWowzaIdAndUserId($wowzids,$userdata['userid']);
			}

			$this->load->view('admin/header');
			$this->load->view('admin/edittarget',$data);
			$this->load->view('admin/footer');
		}
		public function cancelProvider()
		{
			$this->session->unset_userdata('fb_token');
			$this->session->unset_userdata('rtmpData');
			$this->session->unset_userdata('fbUser');
			$this->session->unset_userdata('socialLogin');
			$this->session->unset_userdata('state');
			$this->session->unset_userdata('youtubeData');
			$key = $this->session->userdata('gkey');
			$this->session->unset_userdata($key);
			$this->session->unset_userdata('gkey');
			redirect(site_url() . 'admin/createtarget');
		}
		public function editcancelProvider()
		{
			$id = $this->uri->segment(3);
			$this->session->unset_userdata('fb_token');
			$this->session->unset_userdata('rtmpData');
			$this->session->unset_userdata('fbUser');
			$this->session->unset_userdata('socialLogin');
			$this->session->unset_userdata('state');
			$this->session->unset_userdata('youtubeData');
			redirect(site_url() . 'editTarget/'.$id);
		}
		public function channelDelete()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$channelid = $cleanData['channelId'];
			$idArray = explode('_',$channelid);

			$sts = $this->common_model->deleteChannel($idArray[1]);
			if($sts)
			{
				$response['status'] = TRUE;
				$response['response'] = "Deleted Successfully!";
			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = "Error occure while deleting Publisher!";
			}
			echo json_encode($response);
		}
		public function channelStartStop()
		{
			$userdata = $this->session->userdata('user_data');
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$channelId = $cleanData['channelId'];
			$action = $cleanData["action"];
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


				$input_type = "";
				$input_name = "";
				$options = "";
				$output_type = "";
				$output_name ="";
				$inputTypeArray = explode("_",$channel[0]['channelInput']);
				$outputTypeArray = explode("_",$channel[0]['channelOutpue']);
				if($inputTypeArray[0] == PHYSICAL_INPUT)
				{
					$input_type = "decklink";
					$inputName = $this->common_model->getEncoderInputbyId($inputTypeArray[1]);
					$input_name = $inputName[0]['item'];

				}
				elseif($inputTypeArray[0] == VIRTUAL_INPUT)
				{
					switch($inputTypeArray[1])
					{
						case NDI:
						if($channel[0]['isRemote'] == 1 && $channel[0]['isIPAddresses'] == 1)
						{
							$input_type = "libndi_newtek -extra_ips ".$channel[0]['ipAddress'];
						}
						else
						{
							$input_type = "libndi_newtek";
						}
						$input_name = $channel[0]['channel_ndi_source'];
						#$options = '-vf "tinterlace=2,format=pix_fmts=uyvy422,fps=50"';commentd By Mustafa 16Aug

						//tinterlace=2,format=pix_fmts=uyvy422,fps=50
						break;
						case RTMP:
						$input_type = "flv";
						$input_name = $channel[0]['input_rtmp_url'];
						//$options = '-vf scale=1920:1080 -pix_fmt uyvy422';
						//$options ='-vf "tinterlace=2,format=pix_fmts=uyvy422,fps=50" -ar 48000';
						break;
						case MPEG_TS_SRT:
						$input_type = "mpegts";
						$input_name = $channel[0]['input_mpeg_srt'];
						//$options = '-vf scale=1920:1080 -pix_fmt uyvy422';
						//$options ='-vf "tinterlace=2,format=pix_fmts=uyvy422,fps=50" -ar 48000';
						break;
						case HTTP_LIVE_STREAMING:
						$input_type = "";
						$input_name = $channel[0]['input_hls_url'];
						//$options = '-vf scale=1920:1080 -pix_fmt uyvy422';
						//$options ='-vf "tinterlace=5,format=pix_fmts=uyvy422,fps=50" -ar 48000';
						break;
					}
				}
				if($outputTypeArray[0] == PHYSICAL_OUTPUT)
				{
					if($outputTypeArray[1] == HDMI_OUT)
					{
						$output_type = "alsa default ";
							$output_name = "-pix_fmt bgra -f fbdev /dev/fb0";
					}
					else
					{
						$output_type = "decklink";
						$ou = $this->common_model->getOutputName($outputTypeArray[1]);
						$output_name = $ou[0]['item'];
						$output_opt = "-pix_fmt uyvy422 -s 1920x1080 -r 25000/1000 -ac 2 -ar 48000 -top 1";

					}

				}
				elseif($outputTypeArray[0] == VIRTUAL_OUTPUT)
				{

					switch($outputTypeArray[1])
					{
						case NDI:
						$output_type = "libndi_newtek";
						//$options = '-vf "scale=interl=1,fps=50,format=pix_fmts=uyvy422"';
						#$options = '-vf "tinterlace=2,format=pix_fmts=uyvy422,fps=50"'; commentd By Mustafa 16Aug
						$output_name = $channel[0]["ndi_name"];
						break;
						case RTMP:
						$application = $this->common_model->getAppbyId($channel[0]['channel_apps']);
						$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
						$eprofile = "";
						$output_type = "flv";
						$gop ="";
						$deinterlace ="";
						$x264params="";
						$x264opts="";
						if(sizeof($encodingProfile) > 0 && $encodingProfile[0]['adv_video_gop'] != "" && $encodingProfile[0]['adv_video_gop'] != NULL)
						{
							$gop = '-g '.$encodingProfile[0]["adv_video_gop"];
						}
						if(sizeof($encodingProfile) > 0 && $encodingProfile[0]['enabledeinterlance'] == 1)
						{
							$deinterlace = '-deinterlace';
						}
						if(sizeof($encodingProfile) > 0 && $encodingProfile[0]['enablezerolatency'] == 1)
						{
							$enablezerolatency = '-tune zerolatency';
						}
						//x264_params && x264opts
						if(sizeof($encodingProfile) > 0 && $encodingProfile[0]['x264_params'] != NULL)
						{
							$x264params = '-x264-params '.$encodingProfile[0]["x264_params"];
						}
						if(sizeof($encodingProfile) > 0 && $encodingProfile[0]['x264opts'] != NULL)
						{
							$x264opts = '-x264opts '.$encodingProfile[0]["x264opts"];
						}
						//eof x264_params && x264opts
						$output_name = $channel[0]["output_rtmp_url"]."/".$channel[0]["output_rtmp_key"];

						if(sizeof($encodingProfile)>0)
						{
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
								$adv_video_keyframe_intrval = '-force_key_frames \'expr:gte(t,n_forced*'.$encodingProfile[0]['adv_video_keyframe_intrval'].')\'';
							}
							if($encodingProfile[0]['adv_video_profile'] != "" && $encodingProfile[0]['adv_video_profile'] != 0)
							{
								$adv_video_profile = '-profile:v '.$encodingProfile[0]['adv_video_profile'];
							}
							if($encodingProfile[0]['video_framerate'] != "" && $encodingProfile[0]['video_framerate'] > 0)
							{
								$video_framerate = '-vf fps='.$encodingProfile[0]['video_framerate'];
							}
							$options =  '-c:v '.$encodingProfile[0]['video_codec'].' -s '.$encodingProfile[0]['video_resolution'].' -b:v '.$encodingProfile[0]['video_bitrate'].'k '.$minBitRate.' '.$maxBitRate.' '.$bufSize.' '.$adv_video_keyframe_intrval.' '.$gop.' '.$adv_video_profile.' -pix_fmt yuv420p -preset '.$encodingProfile[0]['adv_video_preset'].' '.$deinterlace.' '.$enablezerolatency.' '.$video_framerate.' -c:a '.$encodingProfile[0]['audio_codec'].' -b:a '.$encodingProfile[0]['audio_bitrate'].'k -ar '.$encodingProfile[0]['audio_sample_rate'].' -ac '.$encodingProfile[0]['audio_channel'];

						}
						else
						{
							$options =  "";
						}

						break;
						case MPEG_TS_SRT:
						$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
						$eprofile = "";
						$output_type = "mpegts";
						$gop ="";
						$deinterlace ="";
						$enablezerolatency="";
						$x264params="";
						$x264opts="";
						if(sizeof($encodingProfile) > 0 && $encodingProfile[0]['adv_video_gop'] != "" && $encodingProfile[0]['adv_video_gop'] != NULL)
						{
							$gop = '-g '.$encodingProfile[0]["adv_video_gop"];
						}
						if(sizeof($encodingProfile) > 0 && $encodingProfile[0]['enabledeinterlance'] == 1)
						{
							$deinterlace = '-deinterlace';
						}
						if(sizeof($encodingProfile) > 0 && $encodingProfile[0]['enablezerolatency'] == 1)
						{
							$enablezerolatency = '-tune zerolatency';
						}

						//x264_params && x264opts
						if(sizeof($encodingProfile) > 0 && $encodingProfile[0]['x264_params'] != NULL)
						{
							$x264params = '-x264-params '.$encodingProfile[0]["x264_params"];
						}
						if(sizeof($encodingProfile) > 0 && $encodingProfile[0]['x264opts'] != NULL)
						{
							$x264opts = '-x264opts '.$encodingProfile[0]["x264opts"];
						}
						//eof x264_params && x264opts

						$output_name = $channel[0]["output_mpeg_srt"];

						if(sizeof($encodingProfile)>0)
						{

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
								$adv_video_keyframe_intrval = '-force_key_frames \'expr:gte(t,n_forced*'.$encodingProfile[0]['adv_video_keyframe_intrval'].')\'';
							}
							if($encodingProfile[0]['adv_video_profile'] != "" && $encodingProfile[0]['adv_video_profile'] != 0)
							{
								$adv_video_profile = '-profile:v '.$encodingProfile[0]['adv_video_profile'];
							}
							if($encodingProfile[0]['video_framerate'] != "" && $encodingProfile[0]['video_framerate'] > 0)
							{
								$video_framerate = '-vf fps='.$encodingProfile[0]['video_framerate'];
							}
							$options =  '-c:v '.$encodingProfile[0]['video_codec'].' -s '.$encodingProfile[0]['video_resolution'].' -b:v '.$encodingProfile[0]['video_bitrate'].'k '.$minBitRate.' '.$maxBitRate.' '.$bufSize.' '.$adv_video_keyframe_intrval.' '.$gop.' '.$adv_video_profile.' -pix_fmt yuv420p -preset '.$encodingProfile[0]['adv_video_preset'].' '.$deinterlace.' '.$enablezerolatency.' '.$video_framerate.' -c:a '.$encodingProfile[0]['audio_codec'].' -b:a '.$encodingProfile[0]['audio_bitrate'].'k -ar '.$encodingProfile[0]['audio_sample_rate'].' -ac '.$encodingProfile[0]['audio_channel'];
						}
						else
						{
							$options =  "";
						}

						break;
					}
				}
				$channel_name ="";$status = "";
				$channel_name = $channel[0]['channel_name'];

				if($inputTypeArray[0] == PHYSICAL_INPUT || $inputTypeArray[0] == VIRTUAL_INPUT)
				{
					$d ="";
					if($output_name != "")
					{
						$pid = $ssh->exec("pidof ".$channel[0]['process_name']);
						if($action == "Start")
						{
							$extra = ' >>iohub/logs/'.$channel[0]['process_name'].'.log 2>&1';
							if($pid == "")
							{

								if($inputTypeArray[0] == VIRTUAL_INPUT && $inputTypeArray[1] == NDI)
								{
									if($outputTypeArray[1] == MPEG_TS_SRT)
									{
										$command =  $channel_name.'=>'.$action.'=> bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -i \"'.$input_name.'\" '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"'.$extra;
									   $d = $ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -i \"'.$input_name.'\" '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"'.$extra);
									}
									else if($outputTypeArray[0] == PHYSICAL_OUTPUT && $outputTypeArray[1] == HDMI_OUT)
									{
										$command = $channel_name.'=>'.$action.'=> bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -i \''.$input_name.'\' '.$options.' -f alsa default -pix_fmt bgra -f fbdev /dev/fb0 -threads 16"'.$extra;

									$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -i \''.$input_name.'\' '.$options.' -f alsa default -pix_fmt bgra -f fbdev /dev/fb0 -threads 16"'.$extra);
									}
									else if($outputTypeArray[0] == PHYSICAL_OUTPUT && $outputTypeArray[1] != HDMI_OUT)
									{
										$command = $channel_name.'=>'.$action.'=> bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -r 25 -itsoffset -1 -i \"'.$input_name.'\" '.$options.' -f '.$output_type.' -top 1 \''.$output_name.'\' -threads 16"'.$extra;

									$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -r 25 -itsoffset -1 -i \"'.$input_name.'\" '.$options.' -f '.$output_type.' -top 1 \''.$output_name.'\' -threads 16"'.$extra);
									}
									else
									{
										$command = $channel_name.'=>'.$action.'=> bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -re -i \"'.$input_name.'\" '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"'.$extra;

									$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -re -i \"'.$input_name.'\" '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"'.$extra);
									}

								}
								elseif($inputTypeArray[0] == VIRTUAL_INPUT && $inputTypeArray[1] == MPEG_TS_SRT)
								{
									if($outputTypeArray[0] == PHYSICAL_OUTPUT && $outputTypeArray[1] == HDMI_OUT)
									{
										$command = $channel_name.'=>'.$action.'=> bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -fflags nobuffer -f '.$input_type.' -i \''.$input_name.'\' -f alsa default -pix_fmt bgra -f fbdev /dev/fb0 -threads 16"'.$extra;

									$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -i \''.$input_name.'\' -f alsa default -pix_fmt bgra -f fbdev /dev/fb0 -threads 16"'.$extra);
									}
									else
									{
										$command = $channel_name.'=>'.$action.'=> bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -fflags nobuffer -f '.$input_type.'  -i \''.$input_name.'\' -f '.$output_type.' '.$output_name.' -threads 16"'.$extra;

									// Previous $ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -re -i \''.$input_name.'\' '.$options.' -f '.$output_type.' '.$output_name.' -threads 16"');
									$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.'  -i \''.$input_name.'\' -f '.$output_type.' '.$output_name.' -threads 16"'.$extra);
									}

								}
								elseif($inputTypeArray[0] == VIRTUAL_INPUT && $inputTypeArray[1] == HTTP_LIVE_STREAMING)
								{
									$command = $channel_name.'=>'.$action.'=> bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg '.$input_type.' -re -i \''.$input_name.'\' '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"'.$extra;

									$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg '.$input_type.' -re -i \''.$input_name.'\' '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"'.$extra);

								}
								elseif($inputTypeArray[0] == PHYSICAL_INPUT && $outputTypeArray[1] == NDI)
								{
									$audioInput = "";
									if($channel[0]['audio_channel'] != "" && $channel[0]['audio_channel'] > 0)
									{
										$audioInput = "-ac ".$channel[0]['audio_channel'];
									}
									$command = $channel_name.'=>'.$action.'=> bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' '.$audioInput.' -i \''.$input_name.'\' '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"'.$extra;

									$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -ac 8 -i \''.$input_name.'\' '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"'.$extra);
								}
								elseif($inputTypeArray[0] == VIRTUAL_INPUT && $inputTypeArray[1] == RTMP)
								{
									if($outputTypeArray[0] == PHYSICAL_OUTPUT && $outputTypeArray[1] != HDMI_OUT)
									{
										$command = $channel_name.'=>'.$action.'=> bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -i \''.$input_name.'\' -f '.$output_type.' '.$output_opt.' \''.$output_name.'\' -threads 16"'.$extra;


										$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -i \''.$input_name.'\'  -f '.$output_type.' '.$output_opt.' \''.$output_name.'\' -threads 16"'.$extra);
									}
									else
									{
										$command = $channel_name.'=>'.$action.'=> bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -i \''.$input_name.'\' '.$options.' -f '.$output_type.' '.$output_name.' -threads 16"'.$extra;

//echo $command;
									$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -i \''.$input_name.'\' '.$options.' -f '.$output_type.' '.$output_name.' -threads 16"'.$extra);
									}
								}
								else
								{
									if($outputTypeArray[0] == PHYSICAL_OUTPUT && $outputTypeArray[1] == HDMI_OUT)
									{
										$command = $channel_name.'=>'.$action.'=> bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -i \''.$input_name.'\' '.$options.' -f alsa default -pix_fmt bgra -f fbdev /dev/fb0 -threads 16"'.$extra;

									$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -i \''.$input_name.'\' '.$options.' -f alsa default -pix_fmt bgra -f fbdev /dev/fb0 -threads 16"'.$extra);
									}

									else
									{
										$command = $channel_name.'=>'.$action.'=> bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -re -i \''.$input_name.'\' '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"'.$extra;

//echo $command;
									$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -re -i \''.$input_name.'\' '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"'.$extra);
									}

								}

								$pid1 = $ssh->exec("pidof ".$channel[0]['process_name']);
								if($pid1 == "")
								{
									$status = "Error";

									$this->common_model->insertLogs($channel_name,'channels',$command,$userdata['userid'],$status);
									echo json_encode(array('status'=>FALSE, "message"=> 'Error occur while starting stream!' .$d,'change'=>'stop'));
								}
								elseif($pid1 > 0)
								{
									$p = $pid1;
									$cmd = 'ps -p '.trim($p).' -o lstart=';
									$time1 = $ssh->exec($cmd);
									$status = "Success";

									$this->common_model->insertLogs($channel_name,'channels',$command,$userdata['userid'],$status);
									echo json_encode(array('status'=>TRUE, "message"=> 'Channel Start Successfully.','change'=>'start','time'=>$time1));
								}
							}
							else
							{
								$p = $pid;
									$cmd = 'ps -p '.trim($p).' -o lstart=';
									$time1 = $ssh->exec($cmd);
									$command = $channel_name.'=>'.$action.'=> Already Running!';
									$status = "Success";
									$this->common_model->insertLogs($channel_name,'channels',$command,$userdata['userid'],$status);
								echo json_encode(array('status'=>TRUE, "message"=> 'Already Running','change'=>'start','time'=>$time1));
							}
						}
						elseif($action == "Stop")
						{

							$ssh->exec('pkill -f '.$channel[0]['process_name']);
							$status = "Success";
							$command = $channel_name.'=>'.$action.'=> Channel Stopped Successfully!';
							$this->common_model->insertLogs($channel_name,'channels',$command,$userdata['userid'],$status);
							echo json_encode(array('status'=>TRUE, "message"=> 'Channel Stopped Successfully!','change'=>'stop'));
						}
						elseif($action == "checkstatus")
						{
							$pid = $ssh->exec("pidof ".$channel[0]['process_name']);
							if($pid == "")
							{

								echo json_encode(array('status'=>TRUE, "message"=> 'Channel Stopped','change'=>'stop'));

							}
							else
							{
								$p = $pid;
								$cmd = 'ps -p '.trim($p).' -o lstart=';
								$time1 = $ssh->exec($cmd);
								$timestamp = strtotime($time1);
								echo json_encode(array('status'=>TRUE, "message"=> 'Already Running','change'=>'start','time'=>trim($time1)));
							}

						}
					}
					else
					{
						echo json_encode(array('status'=>FALSE, "message"=> 'This is not an encoder channel!','change'=>'stop'));
					}
				}
			}
		}
		public function targetStartStop()
		{
			$userdata = $this->session->userdata('user_data');
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$appid = $cleanData['targetId'];
			$action = $cleanData["action"];
			$idArray = explode('_',$appid);
			$target = $this->common_model->getTargetbyId($idArray[1]);
			$streamULR = $target[0]['streamurl'];
			$streamURL = explode('/',$streamULR);
			$application = $this->common_model->getAppbyId($target[0]['wowzaengin']);
			$wowza = $this->common_model->getWovzData($application[0]['live_source']);
			if($action == "Start")
			{
				$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.str_replace(" ","+",$application[0]['application_name']).'/pushpublish/mapentries/'.str_replace(" ","+",$target[0]['target_name']).'/actions/enable';
			}
			elseif($action == "Stop")
			{
				$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.str_replace(" ","+",$application[0]['application_name']).'/pushpublish/mapentries/'.str_replace(" ","+",$target[0]['target_name']).'/actions/disable';
			}

			$fields = array(
				'app_name' =>$application[0]['application_name'],
				'target_name'=>array($target[0]['target_name'])
			);

			$resultt=shell_exec("curl -X put ".$url);
			if($target[0]['target'] == "twitter" && $action == "Stop")
			{
				// Refresh Token Call
				$URL = "https://api.pscp.tv/v1/oauth/token";
				$fields = array(
					"grant_type"=>"refresh_token",
					"refresh_token"=>$target[0]["token"],
					"client_id"=>"Tr5fxCa7x62pZrhe50b3Oy_iGoSrn02KcclRRH20rHteUdD8L2",
					"client_secret"=>"8PyUSMT1LuliGFBVAUZFZaUXO5Mzw8-mZGxslimam6M1V2u187"
				);
				$ch = curl_init();
				curl_setopt($ch,CURLOPT_URL, $URL);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch,CURLOPT_POST, count($fields));
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
				curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));
				$result = curl_exec($ch);
				$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				$array = json_decode($result,TRUE);
				$this->session->set_userdata('twitter_access',$array['access_token']);

				/* Stop Broadcast */
				$broadcastId = $target[0]["broadcast_id"];
				$URL_broadCast = "https://api.pscp.tv/v1/broadcast/stop";
				$fields_broadcast = array(
					"broadcast_id"=>$broadcastId
				);
				$ch_broadcast = curl_init();
				curl_setopt($ch_broadcast,CURLOPT_URL, $URL_broadCast);
				curl_setopt($ch_broadcast, CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch_broadcast,CURLOPT_POST, count($fields_broadcast));
				curl_setopt($ch_broadcast, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$array['access_token'],'Content-Type: application/json'));
				curl_setopt($ch_broadcast,CURLOPT_POSTFIELDS, json_encode($fields_broadcast));
				$result_broadcast = curl_exec($ch_broadcast);
				$httpcode_broadcast = curl_getinfo($ch_broadcast, CURLINFO_HTTP_CODE);
				curl_close($ch_broadcast);

			}

			$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.$application[0]['application_name'].'/pushpublish/mapentries';

			$xmlData = file_get_contents($url);
			$xml = simplexml_load_string($xmlData);

			$elem = new SimpleXMLElement($xmlData);
			$mapEntiresCount = $elem->MapEntries->count();

			$MapEntries = json_encode($xml);
			$mapEntriesArray = json_decode($MapEntries,TRUE);
			$status="";
			if(array_key_exists('MapEntries',$mapEntriesArray))
			{
				if($mapEntiresCount > 1)
				{
					foreach($mapEntriesArray['MapEntries'] as $key=>$targetData)
					{
						if($targetData['EntryName'] == $target[0]['target_name'])
						{
							$response['status'] = TRUE;
							$response['code'] = "200";
							if($targetData['Enabled'] == 'false' && $targetData['SessionStatus'] == "NotFound")
							{
								$response['response'] = "Disabled";
								$status = "Disabled";
							}
							elseif($targetData['Enabled'] == 'true' && $targetData['SessionStatus'] == "NotFound")
							{
								$response['response'] = "Waiting...";
								$status = "Waiting...";
							}
							elseif($targetData['Enabled'] == 'true' && $targetData['SessionStatus'] == "Active")
							{
								$response['response'] = "Active";
								$status = "Active";
							}
							elseif($targetData['Enabled'] == 'true' && $targetData['SessionStatus'] == "Starting")
							{
								$response['response'] = "Starting";
								$status = "Starting";
							}
							elseif($targetData['Enabled'] == 'false' && $targetData['SessionStatus'] == "Error")
							{
								$response['response'] = "Disabled";
								$status = "Disabled";
							}
							elseif($targetData['Enabled'] == 'true' && $targetData['SessionStatus'] == "Error")
							{
								$response['response'] = "Error";
								$status = "Error";
							}
							$command = $target[0]['target_name']."=>".$action;
							$this->common_model->insertLogs($target[0]['target_name'],'targets',$command,$userdata['userid'],$status);
						}
					}
				}
				else
				{
						$targetData = $mapEntriesArray['MapEntries'];
						if($targetData['EntryName'] == $target[0]['target_name'])
						{
							$response['status'] = TRUE;
							$response['code'] = "200";
							if($targetData['Enabled'] == 'false' && $targetData['SessionStatus'] == "NotFound")
							{
								$response['response'] = "Disabled";
								$status = "Disabled";
							}
							elseif($targetData['Enabled'] == 'true' && $targetData['SessionStatus'] == "NotFound")
							{
								$response['response'] = "Waiting...";
								$status = "Waiting...";
							}
							elseif($targetData['Enabled'] == 'true' && $targetData['SessionStatus'] == "Active")
							{
								$response['response'] = "Active";
								$status = "Active";
							}
							elseif($targetData['Enabled'] == 'true' && $targetData['SessionStatus'] == "Starting")
							{
								$response['response'] = "Starting";
								$status = "Starting";
							}
							elseif($targetData['Enabled'] == 'false' && $targetData['SessionStatus'] == "Error")
							{
								$response['response'] = "Disabled";
								$status = "Disabled";
							}
							elseif($targetData['Enabled'] == 'true' && $targetData['SessionStatus'] == "Error")
							{
								$response['response'] = "Error";
								$status = "Error";
							}
							$command = $target[0]['target_name']."=>".$action;
							$this->common_model->insertLogs($target[0]['target_name'],'targets',$command,$userdata['userid'],$status);
						}

				}

			}
			else
			{
				$response['code'] = "404";
				$response['status'] = FALSE;
				$response['response'] = array();
				$status = "NA";
				$command = $target[0]['target_name']."=>".$action." =>".$result;
				$this->common_model->insertLogs($target[0]['target_name'],'targets',$command,$userdata['userid'],$status);
			}
			echo json_encode($response);
		}

		public function googlelogin()
		{
			$this->session->set_userdata('socialLogin', "google");
			redirect('createtarget');
		}
		public function googleaccount()
		{
			$act = $this->uri->segment(3);
			$id = $this->uri->segment(4);
			if($act != "" && $act == "transiton")
			{
				$this->session->set_userdata('transiton',$id);
			}
			elseif($act != "" && $act == "savetarget")
			{
				$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
				$this->session->set_userdata('savetarget',$cleanData);
			}
			//$OAUTH2_CLIENT_ID = '96664961069-u28cbpg3rn590g43l9jbl8fu3ma1uk41.apps.googleusercontent.com';

			//$OAUTH2_CLIENT_SECRET = 'sjjaq7BxcjKLrQ1Pv4ISpPuj';

			$OAUTH2_CLIENT_ID = '699642164037-j0fjeccfase1pdlsu3adhbnkmurr9emi.apps.googleusercontent.com';

			$OAUTH2_CLIENT_SECRET = 'rhkLiIco6_2F_7jSDvIXLB-P';

			$client = new Google_Client();
			$client->setClientId($OAUTH2_CLIENT_ID);
			$client->setClientSecret($OAUTH2_CLIENT_SECRET);
			$client->setScopes('https://www.googleapis.com/auth/youtube');
			$redirect = filter_var('https://' . $_SERVER['HTTP_HOST'] . '/admin/googleaccount',FILTER_SANITIZE_URL);

			$client->setRedirectUri($redirect);
			$youtube = new Google_Service_YouTube($client);
			$tokenSessionKey = 'token-' . $client->prepareScopes();

			$googleState = $this->session->userdata('state');
			if (isset($_GET['code'])) {
			  if (!empty($googleState) && strval($googleState) !== strval($_GET['state'])) {
			   	$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'The Google Account session state did not match.');
				redirect(site_url() . 'admin/createtarget');
			  }
 				$this->session->set_userdata('ycode', $_GET['code']);
			  $client->authenticate($_GET['code']);
			  $this->session->set_userdata($tokenSessionKey, $client->getAccessToken());
			  $this->session->set_userdata('gkey', $tokenSessionKey);

			}
			$googleTokenSessionKey = $this->session->userdata($tokenSessionKey);

			if ($googleTokenSessionKey != "") {

			  $client->setAccessToken($googleTokenSessionKey);
			}
			if ($client->getAccessToken()) {
			  try {
			  	$transition = $this->session->userdata('transiton');
			  	$cleanData = $this->session->userdata('savetarget');
			  	if(!empty($transition) && $transition >0)
			  	{
			  		try
			  		{
			  			$target = $this->common_model->getTargetbyId($transition);
			  			$streamULR = $target[0]['streamurl'];
						$streamURL = explode('/',$streamULR);
						$application = $this->common_model->getAppbyId($target[0]['wowzaengin']);
						$wowza = $this->common_model->getWovzData($application[0]['live_source']);

						$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.str_replace(" ","+",$application[0]['application_name']).'/pushpublish/mapentries/'.str_replace(" ","+",$target[0]['target_name']).'/actions/disable';

						$resultt = shell_exec("curl -X put ".$url);
						$token = $client->getAccessToken();

				  		$transitionBroadcastResponse = $youtube->liveBroadcasts->transition('complete', $target[0]['broadcast_id'], 'id,status,contentDetails');
						redirect(site_url() . 'applications');
					}
					catch (Google_Service_Exception $e) {
			  			$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'A service error occurred '.$e->getMessage());
						redirect(site_url() . 'applications');
					}
					catch (Google_Exception $e) {
					    $this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'A service error occurred 1 '.htmlspecialchars($e->getMessage()));
						redirect(site_url() . 'applications');
					}
				}
				elseif(!empty($cleanData) && sizeof($cleanData) > 0)
				{
					$broadcastSnippet = new Google_Service_YouTube_LiveBroadcastSnippet();
					$broadcastSnippet->setTitle($cleanData['title']);
					$broadcastSnippet-> setDescription($cleanData['description']);
					$d = date('Y-m-d');
					$t = date('h:i:s');
					$startTime  = $d."T".$t.".00Z";
					$d = date_format(date_create(date('Y-m-d H:i:s',strtotime("+5 min")))->setTimezone(new DateTimeZone('Asia/Kolkata')), 'c');
					$broadcastSnippet->setScheduledStartTime($d);
					$status = new Google_Service_YouTube_LiveBroadcastStatus();
					$stsssssss = $cleanData['privacystatus'];
					$status->setPrivacyStatus($stsssssss);
					$status->setLifeCycleStatus('live');

					$info = new Google_Service_YouTube_MonitorStreamInfo();
					$info->setEnableMonitorStream(FALSE);

					$cntdetail = new Google_Service_YouTube_LiveBroadcastContentDetails();
					$cntdetail->setEnableAutoStart(TRUE);
					$cntdetail->setMonitorStream($info);
					// Create the API request that inserts the liveBroadcast resource.
					$broadcastInsert = new Google_Service_YouTube_LiveBroadcast();
					$broadcastInsert->setSnippet($broadcastSnippet);
					$broadcastInsert->setStatus($status);
					$broadcastInsert->setKind('youtube#liveBroadcast');
					$broadcastInsert->setContentDetails($cntdetail);

					$broadcastsResponse = $youtube->liveBroadcasts->insert('snippet,status,contentDetails',
					$broadcastInsert, array());

					$streamSnippet = new Google_Service_YouTube_LiveStreamSnippet();
					$streamSnippet->setTitle('New YT Stream');

					$cdn = new Google_Service_YouTube_CdnSettings();
					$cdn->setFormat("1080p");
					$cdn->setframeRate("30fps");
					$cdn->setresolution("1080p");

					$cdn->setIngestionType('rtmp');
					$statsss = new Google_Service_YouTube_LiveStreamStatus();
					$statsss->setStreamStatus("active");
					// Create the API request that inserts the liveStream resource.
					$streamInsert = new Google_Service_YouTube_LiveStream();
					$streamInsert->setSnippet($streamSnippet);
					$streamInsert->setCdn($cdn);
					$streamInsert->setKind('youtube#liveStream');
					$streamsResponse = $youtube->liveStreams->insert('snippet,cdn,status',
					$streamInsert, array());
					$bindBroadcastResponse = $youtube->liveBroadcasts->bind(
					$broadcastsResponse['id'],'id,contentDetails',
					array(
					'streamId'=>$streamsResponse['id'],
					));
					//$this->session->set_userdata("youtubeData_broadid", $broadcastsResponse['id']);
					//$this->session->set_userdata("youtubeData", $streamsResponse);
					//$this->session->set_userdata("livstreamid",$streamsResponse['id']);
					//$this->session->set_userdata($broadcastsResponse['id'],$client->getAccessToken());
					$cont =0;
					if(array_key_exists('continuelive',$cleanData))
					{
						$cont = 1;
					}
					else
					{
						$cont = 0;
					}
					$userdata = $this->session->userdata('user_data');
					$socialLogin = $this->session->userdata('socialLogin');
					$userData = array(
	                	'target_name'=>$cleanData['target_name'],
	                	'wowzaengin'=>$cleanData['wowzaengin'],
	                	'streamurl'=>$cleanData['streamurl'],
	                	'target'=>$socialLogin,
	                	'title'=>$cleanData['title'],
	                	'description'=>$cleanData['description'],
	                	'continuelive'=>$cont,
	                	'status'=>1,
	                	'created'=>time(),
	                	'uid'=>$userdata['userid']
					);
					if($cleanData['enableTargetSchedule'] != "")
					{

						$userData['enableTargetSchedule'] = 1;
						$userData['start_date'] = $cleanData['start_date'];
						$userData['end_date'] = $cleanData['end_date'];
					}
					$userData['broadcast_id'] = $broadcastsResponse['id'];
					$userData['livstreamid'] = $streamsResponse['id'];

					$apps = $this->common_model->getAppbyId($cleanData['wowzaengin']);
					$wid = $apps[0]['live_source'];
					$wowza = $this->common_model->getWovzData($wid);

					$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.$apps[0]['application_name'].'/pushpublish/mapentries/'.$cleanData['target_name'];
					$stremURL = explode('/',$cleanData['streamurl']);

					$fields = array(
				        "sourceStreamName"=>$stremURL[4],
				        "profile"=>"rtmp",
				        "application"=>"live2",
				        "host"=>"a.rtmp.youtube.com",
				        "streamName"=>$streamsResponse['cdn']->ingestionInfo['streamName'],
				        "port"=>"1935",
				        "enabled"=>"false",
				        "extraOptions"=>array("destinationName"=>"rtmp")
					);
					$ch = curl_init();
					curl_setopt($ch,CURLOPT_URL, $url);
					curl_setopt($ch,CURLOPT_POST, count($fields));
					curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
					$result = curl_exec($ch);
					$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					curl_close($ch);
					$id = $this->common_model->insertTarget($userData);
					if($id > 0)
					{
						if($cleanData['enableTargetSchedule'] != "")
						{
							$processname = $id.'_'.$this->random_string(10);
							$startname = "Target_Start_".$processname.".sh";
							$stopname = "Target_Stop_".$processname.".sh";
							$starttime = $this->getDateTime($cleanData['start_date']);
							$stoptime = $this->getDateTime($cleanData['end_date']);
							$startfile =  $starttime["m"].' '.$starttime["h"].' '.$starttime["day"].' '.$starttime["month"].' * /home/ksm/scheduler/'.$startname;
							$stopfile = $stoptime["m"].' '.$stoptime["h"].' '.$stoptime["day"].' '.$stoptime["month"].' * /home/ksm/scheduler/'.$stopname;
							$type = "google";
							$dataS = array(
								'schedule_type'=>'target',
								'type'=>$type,
								'sid'=>$id,
								'start_datetime'=>$cleanData['start_date'],
								'end_datetime'=>$cleanData['end_date'],
								'status'=>1,
								'created'=>time(),
								'start_job'=>$startfile,
								'stop_job'=>$stopfile,
								'start_filename'=>$startname,
								'stop_filename'=>$stopname
							);
							$this->common_model->insertSchedule($dataS);
							$is_scheduled = $cleanData['enableTargetSchedule'];
							$ip = $this->config->item('ServerIP');
							$username = $this->config->item('ServerUser');
							$password = $this->config->item('ServerPassword');
							$port = '22';
							$ssh = new Net_SSH2($ip);
							if ($ssh->login($username, $password,$port)) {

								$startname = "Target_Start_".$processname.".sh";
								$stopname = "Target_Stop_".$processname.".sh";
								$ssh->exec("touch /home/ksm/scheduler/".$startname);
								$ssh->exec("chmod +x /home/ksm/scheduler/".$startname);
								$ssh->exec('echo "curl -k -H  \'Content-Type: application/json\'  --data \'{\"process\":\"'.$processname.'\"}\'  https://iohub.tv/api/startTarget >> /home/ksm/scheduler/scheduler.log" >>  /home/ksm/scheduler/'.$startname);
								$ssh->exec('echo "echo \"\n----------------------------------------------\n\" >> /home/ksm/scheduler/scheduler.log" >>  /home/ksm/scheduler/'.$startname);

								$ssh->exec("touch /home/ksm/scheduler/".$stopname);
								$ssh->exec("chmod +x /home/ksm/scheduler/".$stopname);
								$ssh->exec('echo "curl -k -H  \'Content-Type: application/json\'  --data \'{\"process\":\"'.$processname.'\"}\'  https://iohub.tv/api/StopTarget >> /home/ksm/scheduler/scheduler.log" >>  /home/ksm/scheduler/'.$stopname);
								$ssh->exec('echo "echo \"\n----------------------------------------------\n\" >> /home/ksm/scheduler/scheduler.log" >>  /home/ksm/scheduler/'.$stopname);
								$ssh->exec('(crontab -l; echo "'.$starttime["m"].' '.$starttime["h"].' '.$starttime["day"].' '.$starttime["month"].' * /home/ksm/scheduler/'.$startname.'") | crontab -');
								$ssh->exec('(crontab -l; echo "'.$stoptime["m"].' '.$stoptime["h"].' '.$stoptime["day"].' '.$stoptime["month"].' * /home/ksm/scheduler/'.$stopname.'") | crontab -');
							}
						}
						$this->session->unset_userdata('fb_token');
						$this->session->unset_userdata('rtmpData');
						$this->session->unset_userdata('fbUser');
						$this->session->unset_userdata('socialLogin');
						$this->session->unset_userdata('youtubeData');
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', "Target Created Successfully");
						$this->session->set_flashdata('tab', 'Target');
						redirect('admin/applications');

					}
					else
					{
						$this->session->unset_userdata('fb_token');
						$this->session->unset_userdata('rtmpData');
						$this->session->unset_userdata('fbUser');
						$this->session->unset_userdata('socialLogin');$this->session->unset_userdata('youtubeData');
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error occur while creating Target!');

						redirect('admin/createtarget');
					}



				}
			  } catch (Google_Service_Exception $e) {
			  		$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'A service error occurred '.$e->getMessage());

					redirect(site_url() . 'admin/createtarget');
			  } catch (Google_Exception $e) {
			    	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'A service error occurred 1 '.htmlspecialchars($e->getMessage()));

					redirect(site_url() . 'admin/createtarget');
			  }
			  $this->session->set_userdata($tokenSessionKey, $client->getAccessToken());
			  redirect(site_url() . 'admin/createtarget');
			}
			elseif ($OAUTH2_CLIENT_ID == 'REPLACE_ME') {
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Client Credentials Required You need to set <code>\$OAUTH2_CLIENT_ID</code> and <code>\$OAUTH2_CLIENT_ID</code> before proceeding');
				redirect(site_url() . 'admin/createtarget');
			}
			else
			{
			  $state = mt_rand();
			  $client->setState($state);
			  $this->session->set_userdata("state", $state);
			  $authUrl = $client->createAuthUrl();
			  redirect($authUrl);
			}
		}
		public function twitch()
		{
			$this->session->set_userdata('socialLogin', "twitch");

			header("Location: https://api.twitch.tv/kraken/oauth2/authorize?client_id=kz30uug3w8b73asx3qe2q1yt98al5r&redirect_uri=https://iohub.tv/twitchcasting&response_type=code&scope=channel_read+channel_editor");


		}
		public function twitchcasting()
		{
			if(isset($_GET['code']))
			{
				$URL = "https://api.twitch.tv/kraken/oauth2/token";
				$fields = array(
					"client_id"=>"kz30uug3w8b73asx3qe2q1yt98al5r",
					"client_secret"=>"fpsw6urwwko7lkrwtdu5jyulm0zrpi",
					"code"=>$_GET['code'],
					"grant_type"=>"authorization_code",
					"redirect_uri"=>"https://iohub.tv/twitchcasting",
					"scope"=>"channel_editor"
				);
				$ch = curl_init();
				curl_setopt($ch,CURLOPT_URL, $URL);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch,CURLOPT_POST, count($fields));
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
				curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));
				$result = curl_exec($ch);
				$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
				curl_close($ch);
				$array = json_decode($result,TRUE);
				$this->session->set_userdata('twitch_access',$array['access_token']);

				$URL1 = "https://api.twitch.tv/kraken/channel";
				$curl = curl_init($URL1);
				curl_setopt($curl, CURLOPT_FAILONERROR, true);
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($curl, CURLOPT_HEADER, false);    // we want headers
				curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($curl, CURLOPT_HTTPHEADER,array('Accept: application/vnd.twitchtv.v5+json','Client-ID: kz30uug3w8b73asx3qe2q1yt98al5r','Authorization: OAuth '.$array['access_token']));
				$result1 = curl_exec($curl);
				//echo $result1;
				$tdata = json_decode($result1,TRUE);
				$this->session->set_userdata('twitch_data',$tdata);
				curl_close($curl);
			print_r($array);
				print_r($tdata);

				redirect(site_url() . 'createtarget');
			}
			else
			{
				echo "invalid request";
				die;
			}
		}
		public function twitter()
		{
			$this->session->set_userdata('socialLogin', "twitter");
			header("Location: https://www.pscp.tv/oauth?client_id=Tr5fxCa7x62pZrhe50b3Oy_iGoSrn02KcclRRH20rHteUdD8L2&redirect_uri=https://iohub.tv/periscope");
		}
		public function wowzacdn()
		{
			$this->session->set_userdata('socialLogin', "wowzacdn");
		}
		public function akamai()
		{
			$this->session->set_userdata('socialLogin', "akamai");
		}
		public function cloudfront()
		{
			$this->session->set_userdata('socialLogin', "cloudfront");
		}
		public function wowzaengine()
		{
			$this->session->set_userdata('socialLogin', "wowzaengine");
		}
		public function limelight()
		{
			$this->session->set_userdata('socialLogin', "limelight");
		}
		public function rtmp()
		{
			$this->session->set_userdata('socialLogin', "rtmp");
			redirect("createtarget");
		}
		public function mpeg()
		{
			$this->session->set_userdata('socialLogin', "mpeg");
		}
		public function rtp()
		{
			$this->session->set_userdata('socialLogin', "rtp");
		}
		public function srt()
		{
			$this->session->set_userdata('socialLogin', "srt");
		}
		public function facebookLogout()
		{
			$fbToken = $this->session->userdata('fb_token');
			$url = 'https://www.facebook.com/logout.php?next=https://iohub.tv/admin/createtarget&access_token='.$fbToken;
			$this->session->unset_userdata('fb_token');
			$this->session->unset_userdata('rtmpData');
			$this->session->unset_userdata('fbUser');
			$this->session->unset_userdata('socialLogin');
			$this->session->unset_userdata('act');
			header('Location: '.$url);
		}
		public function fb()
		{
			$act = $this->uri->segment(3);
			$id = $this->uri->segment(4);
			if($act != "")
			{
				$this->session->set_userdata('act',$act.'_'.$id);
			}

			define('APP_URL', 'https://iohub.tv/admin/fb');
			$facebookArray = array('app_id' => '201130880631964', 'app_secret' => '49e984459f5d67695b85b443dc879d82',  'default_graph_version' => 'v2.6');


			$fb = new Facebook\Facebook($facebookArray);
		//	$FacebooOBJ = $fb;
			$helper = $fb->getRedirectLoginHelper();
			$permissions = ['manage_pages','pages_show_list','publish_pages','publish_video'];
			$fbToken = $this->session->userdata('fb_token');
			$scope = "email, user_about_me, user_birthday, user_hometown, user_location, user_website,  manage_pages,publish_pages,pages_show_list,user_managed_groups,user_events,user_posts,publish_video";
			try {

				if (!empty($fbToken)) {
					$accessToken = $fbToken;
				} else {
			  		//$accessToken = $helper->getAccessToken();
			  		$accessToken = $helper->getAccessToken('https://iohub.tv/admin/fb');
				}
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
			 	$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Graph returned an error: ' . $e->getMessage());
			 	redirect('admin/createtarget');
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
			 	$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Facebook SDK returned an error: ' . $e->getMessage());
			 	redirect('admin/createtarget');
			 }
			if(isset($accessToken)) {
			if(!empty($fbToken)) {
					$fb->setDefaultAccessToken($fbToken);
				} else {
					$this->session->set_userdata('fb_token', (string) $accessToken);
				  	// OAuth 2.0 client handler
				  	$fbTokenNew = $this->session->userdata('fb_token');
					$oAuth2Client = $fb->getOAuth2Client();
					// Exchanges a short-lived access token for a long-lived one
					$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($fbTokenNew);
					$this->session->set_userdata('fb_token', (string) $longLivedAccessToken);
					$this->session->set_userdata('socialLogin', "facebook");
					// setting default access token to be used in script
					$fbTokenNewAgain = $this->session->userdata('fb_token');
					$fb->setDefaultAccessToken($fbTokenNewAgain);
				}
				// redirect the user back to the same page if it has "code" GET variable
				if (isset($_GET['code'])) {
					//header('Location: ./');
						$this->session->set_userdata('fb_code',$_GET['code']);
				}
				// validating user access token
				$user;
				try
				{
					$user = $fb->get('/me',$accessToken);
					$user = $user->getGraphNode()->asArray();

					$user1 = $fb->get('/'.$user['id'].'/accounts',$accessToken);
					$b = $user1->getDecodedBody($user1);
					$this->session->set_userdata('dfff', $b);
				}
				catch(Facebook\Exceptions\FacebookResponseException $e)
				{
					// When Graph returns an error
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Graph returned an error: ' . $e->getMessage());
			 		//redirect('admin/createtarget');
				}
				catch(Facebook\Exceptions\FacebookSDKException $e)
				{
					// When validation fails or other local issues
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Facebook SDK returned an error: ' . $e->getMessage());
			 		//redirect('admin/createtarget');
				}


				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'Logged in facebook Successfully');
				$createLiveVideo['logoutULR'] = $helper->getLogoutUrl(APP_URL, $permissions);
				//$this->session->set_userdata('rtmpData', $createLiveVideo);

				$this->session->set_userdata('fbUser', $user);

				$linkss = $this->session->userdata('act');
				if($linkss != "")
				{
					$redirc = explode('_',$linkss);
					if($redirc[0] != "" && $redirc[0] == "edittarget")
					{
						$datafff = array(
							'revoke'=>0
						);
						$this->common_model->updateTarget($redirc[1],$datafff);
						redirect('editTarget/'.$redirc[1]);
					}
					if($redirc[0] != "" && $redirc[0] == "revokeFB")
					{
						$datafff = array(
							'revoke'=>1
						);
						$this->common_model->updateTarget($redirc[1],$datafff);
						redirect('admin/revokeFB/'.$redirc[1]);
					}
					if($redirc[0] != "" && $redirc[0] == "player")
					{
						redirect('editTarget/'.$redirc[1]);
					}

				}
				else
				{
					redirect('admin/createtarget');
				}
			} else {
				// replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
				$loginUrl = $helper->getLoginUrl(APP_URL, $permissions);
			//	echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
				echo "<script>window.top.location.href='".$loginUrl."'</script>";
			}
		}
		public function getStreamURL()
		{
			$cleanDAta = $this->input->post(NULL,TRUE);
			$identifier = $this->input->post("id");
			$access_token = $this->input->post("token");
			$option = "SELF";
			$result = shell_exec("curl 'https://graph.facebook.com/v2.6/'".$identifier."'/live_videos?access_token=".$access_token."' -H 'Host: graph.facebook.com' -H 'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64; rv:47.0) Gecko/20100101 Firefox/47.0' -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' -H 'Accept-Language: en-US,en;q=0.5'  -H 'Content-Type: application/x-www-form-urlencoded' -H 'Referer: https://developers.facebook.com' -H 'origin: https://developers.facebook.com' --data 'debug=all&format=json&method=post&pretty=0&title=usama&privacy=%7B%22value%22%3A%22".$option."%22%7D&suppress_http_code=1'");

	$data = json_decode($result,true);

		}
		public function dashboard()
		{
			$this->breadcrumbs->push('Dashboard', '/');
			$this->load->view('admin/header');
			$this->load->view('admin/dashboard');
			$this->load->view('admin/footer');
		}
		public function wowzaapps()
		{
			$id = $this->uri->segment(3);
			$data['applications'] = $this->common_model->getWowzaApps($id);
			$data['targets'] = $this->common_model->getAllTargets();
			$this->load->view('admin/header');
			$this->load->view('admin/wowzaapplications',$data);
			$this->load->view('admin/footer');
		}
		public function lockscreen()
		{
			$lockData = array('isLock'=>TRUE);
			$this->session->set_userdata('lock_data',$lockData);
			echo json_encode(array('status'=>TRUE));
		}
		public function unlock1()
		{
			$userdata =$this->session->userdata('user_data');
			$lockData = array('isLock'=>TRUE);
			$this->session->set_userdata('lock_data',array());
			echo json_encode(array('status'=>TRUE));
		}
		public function unlock()
		{

			$userdata =$this->session->userdata('user_data');
			$response = array('status'=>FALSE,'response'=>'');
			$lockData = array('isLock'=>TRUE);
			$this->session->set_userdata('lock_data',array());
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$pass = sha1($cleanData['password']);
			$checkstatus = $this->common_model->checkUserStatus($userdata['email'],$pass);
			if(!$checkstatus){

				$response['status'] = FALSE;
				$response['response'] = "Wrong! Password";
			}
			else
			{
				$response['status'] = TRUE;

			}
			echo json_encode($response);
		}
		public function index()
		{
			$this->breadcrumbs->push('Dashboard', '/');
			$this->load->view('admin/header');
			$this->load->view('admin/dashboard');
			$this->load->view('admin/footer');
		}
		public function copyTarget()
		{
			$userdata =$this->session->userdata('user_data');
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$appid = $cleanData['appid'];
			$idArray = explode('_',$appid);
			$target = $this->common_model->getTargetbyId($idArray[1]);
			$userData = array(
        	'target_name'=>'Clone of '.$target[0]['target_name'],
        	'wowzaengin'=>$target[0]['wowzaengin'],
        	'streamurl'=>$target[0]['streamurl'],
        	'target'=>$target[0]['target'],
        	'title'=>$target[0]['title'],
        	'description'=>$target[0]['description'],
        	'continuelive'=>$target[0]['continuelive'],
        	'status'=>1,
        	'created'=>time(),
        	'uid'=>$userdata['userid']
			);
			$sts = $this->common_model->insertTarget($appData);
			if($sts)
			{
				$response['status'] = TRUE;
				$response['response'] = "Copied Successfully!";
			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = "Error occure while Copying Target!";
			}
			echo json_encode($response);
		}
		public function copyChannel()
		{
			$userdata =$this->session->userdata('user_data');
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$appid = $cleanData['appid'];
			$idArray = explode('_',$appid);
			$channel = $this->common_model->getChannelbyId($idArray[1]);

			$chennelData = array(
				'channel_name'=>'Clone of '.$channel[0]['channel_name'],
	        	'encoder_id'=>$channel[0]['encoder_id'],
	        	'channelInput'=>$channel[0]['channelInput'],
	        	'channel_ndi_source'=>$channel[0]['channel_ndi_source'],
	        	'input_rtmp_url'=>$channel[0]['input_rtmp_url'],
	        	'input_mpeg_rtp'=>$channel[0]['input_mpeg_rtp'],
	        	'input_mpeg_udp'=>$channel[0]['input_mpeg_udp'],
	        	'input_mpeg_srt'=>$channel[0]['input_mpeg_srt'],
	        	'channelOutpue'=>$channel[0]['channelOutpue'],
	        	'ndi_name'=>$channel[0]['ndi_name'],
	        	'channel_apps'=>$channel[0]['channel_apps'],
	        	'output_rtmp_url'=>$channel[0]['output_rtmp_url'],
	        	'output_rtmp_key'=>$channel[0]['output_rtmp_key'],
	        	'output_mpeg_rtp'=>$channel[0]['output_mpeg_rtp'],
	        	'output_mpeg_udp'=>$channel[0]['output_mpeg_udp'],
	        	'output_mpeg_srt'=>$channel[0]['output_mpeg_srt'],
	        	'auth_uname'=>$channel[0]['auth_uname'],
	        	'auth_pass'=>$channel[0]['auth_pass'],
	        	'encoding_profile'=>$channel[0]['encoding_profile'],
	        	'created'=>time(),
	        	'status'=>1,
	        	'uid'=>$userdata['userid'],
	        	'process_name'=>'CH'.$this->random_string(10)
			);
			$id = $this->common_model->insertChannels($chennelData);
			if($id > 0)
			{
				$response['status'] = TRUE;
				$response['response'] = "Channel Copied Successfully!";
			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = "Error occure while Copying Application!";
			}
			echo json_encode($response);
		}
		public function copyApplication()
		{
			$userdata =$this->session->userdata('user_data');
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$appid = $cleanData['appid'];
			$idArray = explode('_',$appid);
			$application = $this->common_model->getAppbyId($idArray[1]);
			$appData = array(
				'application_name'=>'Clone of '.$application[0]['application_name'],
	        	'live_source'=>$application[0]['live_source'],
	        	'wowza_path'=>$application[0]['wowza_path'],
	        	'created'=>time(),
	        	'status'=>1,
	        	'group_id'=>$application[0]['group_id'],
	        	'uid'=>$userdata['userid']
			);
			$sts = $this->common_model->insertCreateVod($appData);
			$wowza = $this->common_model->getWovzData($application[0]['live_source']);


			$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.$application[0]['application_name'];

	 		$headers = array("Content-type: application/json");
			$fields = array(
			'restURI'=>'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.$application[0]['application_name'],
			'name'=>$application[0]['application_name'],
			"appType"=>"Live",
			"clientStreamReadAccess"=>"*",
			"clientStreamWriteAccess"=>"*",
			"description"=>"Live Streaming application created by iohub Live",
			"streamConfig"=>array(
					"restURI"=>'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/$app_name/streamconfiguration',
					"streamType"=>"live"
				)
			);
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch,CURLOPT_POST, 1);
			curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			$result = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if($httpcode == 200 || $httpcode == 201)
			{
				$url_second = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.$application[0]['application_name'].'/adv';
		 		$headers = array("Content-type: application/json");
				$fields_second = array(
				   "restURI"=>'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.$application[0]['application_name'].'/adv',
				   "modules"=>array(array(
				       "order"=>0,
				       "name"=>"base",
				       "description"=>"Base",
				       "class"=>"com.wowza.wms.module.ModuleCore"
				   ), array(
				       "order"=>0,
				       "name"=>"logging",
				       "description"=>"Client Logging",
				       "class"=>"com.wowza.wms.module.ModuleClientLogging"
				   ), array(
				       "order"=>0,
				       "name"=>"flvplayback",
				       "description"=>"FLVPlayback",
				       "class"=>"com.wowza.wms.module.ModuleFLVPlayback"
				   ), array(
				       "order"=>0,
				       "name"=>"ModulePushPublish",
				       "description"=>"Module Push Publish",
				       "class"=>"com.wowza.wms.pushpublish.module.ModulePushPublish"
				   )),
				   "advancedSettings"=>array(array(
				       "enabled"=>true,
				       "canRemove"=>false,
				       "name"=>"pushPublishMapPath",
				       "value"=>'${com.wowza.wms.context.VHostConfigHome}/conf/${com.wowza.wms.context.Application}/PushPublishMap.txt',
				       "defaultValue"=>null,
				       "type"=>"String",
				       "sectionName"=>"Application",
				       "section"=>"/Root/Application",
				       "documented"=>false
				   ))
				);
				$ch_sec = curl_init();
				curl_setopt($ch_sec,CURLOPT_URL, $url_second);
				curl_setopt($ch_sec,CURLOPT_POST, 1);
				curl_setopt($ch_sec,CURLOPT_POSTFIELDS, json_encode($fields_second));
				curl_setopt($ch_sec, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch_sec, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
				$result_second = curl_exec($ch_sec);
				$httpcode1 = curl_getinfo($ch_sec, CURLINFO_HTTP_CODE);
				curl_close($ch_sec);
				if($httpcode1 == 200 || $httpcode1 == 201)
				{
					$id = $this->common_model->insertCreateVod($userData);
					if($id > 0)
					{
						$response['status'] = TRUE;
						$response['response'] = "Copied Successfully!";
					}
					else
					{
						$response['status'] = FALSE;
						$response['response'] = "Error occure while Copying Application!";
					}
				}
				else
				{
					$response['status'] = FALSE;
					$response['response'] = "Error occure while Copying Application!";
				}
			}
			echo json_encode($response);
		}

		public function wowzadisable()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$response['status'] = FALSE;
			$response['response'] = "Error occure while disabling!";
			echo json_encode($response);
		}
		public function deleteTarget()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$appid = $cleanData['appid'];
			$idArray = explode('_',$appid);

			$target = $this->common_model->getTargetbyId($idArray[1]);
			$application = $this->common_model->getAppbyId($target[0]['wowzaengin']);
			$wowza = $this->common_model->getWovzData($application[0]['live_source']);
			$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.str_replace(" ","+",$application[0]['application_name']).'/pushpublish/mapentries/'.str_replace(" ","+",$target[0]['target_name']);

			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
			$result = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			$sts = $this->common_model->deleteTarget($idArray[1]);
			if($sts)
			{
				$response['status'] = TRUE;
				$response['response'] = "Deleted Successfully!";
			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = "Error occure while deleting wowza!";
			}


			echo json_encode($response);
		}
		public function restoreArchiveChannel()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$appid = $cleanData['appid'];
			$idArray = explode('_',$appid);
			$data = array('status'=>1);
			$sts = $this->common_model->updateChannels($data,$idArray[1]);
			if($sts)
			{
				$response['status'] = TRUE;
				$response['response'] = "Restore Successfully!";
			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = "Error occure while Restore channel!";
			}


			echo json_encode($response);
		}
		public function restoreArchiveApp()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$appid = $cleanData['appid'];
			$idArray = explode('_',$appid);
			$data = array('status'=>1);
			$sts = $this->common_model->updateApplication($idArray[1],$data);
			if($sts)
			{
				$response['status'] = TRUE;
				$response['response'] = "Restore Successfully!";
			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = "Error occure while restore Apps!";
			}


			echo json_encode($response);
		}
		public function restoreArchiveTarget()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$appid = $cleanData['appid'];
			$idArray = explode('_',$appid);
			$data = array('status'=>1);
			$sts = $this->common_model->updateTarget($idArray[1],$data);
			if($sts)
			{
				$response['status'] = TRUE;
				$response['response'] = "Restore Successfully!";
			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = "Error occure while Restore target!";
			}


			echo json_encode($response);
		}
		public function startRecording()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$url = $cleanData['url'];
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$result = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($httpcode = '200') {
				$response['status'] = TRUE;
				$response['response'] = "Recoding Started Successfully!";
			}
			else {
				$response['status'] = FALSE;
				$response['response'] = "Error occured while Starting Recording!";
			}
			curl_close($ch);
			echo json_encode($response);
		}
		public function stopRecording()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$url = $cleanData['url'];
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$result = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			if ($httpcode = '200') {
				$response['status'] = TRUE;
				$response['response'] = "Recoding Stoped Successfully!";
			}
			else {
				$response['status'] = FALSE;
				$response['response'] = "Error occured while Stopping Recording!";
			}
			curl_close($ch);
			echo json_encode($response);
		}
		public function deleteApplication()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$appid = $cleanData['appid'];
			$idArray = explode('_',$appid);
			$application = $this->common_model->getAppbyId($idArray[1]);
			$this->common_model->deleteTargetsbyAppId($idArray[1]);
			$wowza = $this->common_model->getWovzData($application[0]['live_source']);
			$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.$application[0]['application_name'];

			$fields = array(
			'app_name' =>$application[0]['application_name']
			);
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
			curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));
			  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
			$result = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			$sts = $this->common_model->deleteApplication($idArray[1]);

			if($sts)
			{
				$response['status'] = TRUE;
				if(curl_error($ch))
				{
				    $response['status'] = FALSE;
				}
				$response['response'] = "Deleted Successfully!";
			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = "Error occure while deleting wowza!";
			}
			curl_close($ch);
			echo json_encode($response);
		}


		//Admin Encoders single row delete
		public function encodersdelete()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$encoderId = $cleanData['encodersId'];
			$idArray = explode('_',$encoderId);

			$sts = $this->common_model->deleteEncoders($idArray[1]);
			if($sts)
			{
				$response['status'] = TRUE;
				$response['response'] = "Deleted Successfully!";
			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = "Error occure while deleting wowza!";
			}
			echo json_encode($response);

		}





		function format_size($size) {
		   $units = explode(' ', 'B KB MB GB TB PB');
		    $mod = 1024;

		    for ($i = 0; $size > $mod; $i++) {
		        $size /= $mod;
		    }

		    $endIndex = strpos($size, ".")+3;

		    return substr( $size, 0, $endIndex).' '.$units[$i];
		}


		public function targetStatus()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$appid = $cleanData['targetId'];
			$idArray = explode('_',$appid);
			$target = $this->common_model->getTargetbyId($idArray[1]);
			$application = $this->common_model->getAppbyId($target[0]['wowzaengin']);
			$wowza = $this->common_model->getWovzData($application[0]['live_source']);

			$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.$application[0]['application_name'].'/pushpublish/mapentries';

			//echo $url;
			$xmlData = file_get_contents($url);

			$xml = simplexml_load_string($xmlData);
			//echo $xml;
			$MapEntries = json_encode($xml);
			$mapEntriesArray = json_decode($MapEntries,TRUE);

			$elem = new SimpleXMLElement($xmlData);
			$mapEntiresCount = $elem->MapEntries->count();

			if(array_key_exists('MapEntries',$mapEntriesArray))
			{
				if($mapEntiresCount > 1)
				{
					foreach($mapEntriesArray['MapEntries'] as $key=>$targetData)
					{
						if($targetData['EntryName'] == $target[0]['target_name'])
						{

							if($targetData['Enabled'] == 'false' && $targetData['SessionStatus'] == "NotFound")
							{
								$response['status'] = TRUE;
								$response['response'] = "Disabled";
							}
							elseif($targetData['Enabled'] == 'true' && $targetData['SessionStatus'] == "NotFound")
							{
								$response['status'] = TRUE;
								$response['response'] = "Waiting...";
							}
							elseif($targetData['Enabled'] == 'true' && $targetData['SessionStatus'] == "Active")
							{
								$response['status'] = TRUE;
								$response['response'] = "Active";
							}
							elseif($targetData['Enabled'] == 'true' && $targetData['SessionStatus'] == "Starting")
							{
								$response['status'] = TRUE;
								$response['response'] = "Starting";
								$status = "Starting";
							}
							elseif($targetData['Enabled'] == 'false' && $targetData['SessionStatus'] == "Error")
							{
								$response['status'] = false;
								$response['response'] = "Disabled";
								$status = "Disabled";
							}
							elseif($targetData['Enabled'] == 'true' && $targetData['SessionStatus'] == "Error")
							{
								$response['status'] = true;
								$response['response'] = "Error";
								$status = "Error";
							}
						}
					}
				}
				else
				{
					$targetData = $mapEntriesArray['MapEntries'];
					if($targetData['EntryName'] == $target[0]['target_name'])
					{

							if($targetData['Enabled'] == 'false' && $targetData['SessionStatus'] == "NotFound")
							{
								$response['status'] = TRUE;
								$response['response'] = "Disabled";
							}
							elseif($targetData['Enabled'] == 'true' && $targetData['SessionStatus'] == "NotFound")
							{
								$response['status'] = TRUE;
								$response['response'] = "Waiting...";
							}
							elseif($targetData['Enabled'] == 'true' && $targetData['SessionStatus'] == "Active")
							{
								$response['status'] = TRUE;
								$response['response'] = "Active";
							}
							elseif($targetData['Enabled'] == 'true' && $targetData['SessionStatus'] == "Starting")
							{
								$response['status'] = TRUE;
								$response['response'] = "Starting";
								$status = "Starting";
							}
							elseif($targetData['Enabled'] == 'false' && $targetData['SessionStatus'] == "Error")
							{
								$response['status'] = false;
								$response['response'] = "Disabled";
								$status = "Disabled";
							}
							elseif($targetData['Enabled'] == 'true' && $targetData['SessionStatus'] == "Error")
							{
								$response['status'] = true;
								$response['response'] = "Error";
								$status = "Error";
							}
						}

				}

			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = array();
			}
			echo json_encode($response);

		}

		public function configuration()
		{
			$this->breadcrumbs->push('Configuration', '/configuration');
			$userdata = $this->session->userdata('user_data');
			if($userdata['user_type'] == 1)
			{
				$data['configdetails'] = $this->common_model->getConfigurationsDetails(0,0);
				$data['encoders'] = $this->common_model->getAllEncoders(0,0);
				$data['gateways'] = $this->common_model->getAllGateways(0,0);
				$data['encoderTemplates'] = $this->common_model->getEncoderTemplate(0);
				$data['groupinfo'] = $this->common_model->getGroupByType("Admin");
				$data['nebula'] = $this->common_model->getNebula(0);
			}
			elseif($userdata['user_type'] == 2 || $userdata['user_type'] == 3)
			{
				$data['configdetails'] = $this->Groupadmin_model->getConfigurationsDetails($userdata['userid'],$userdata['group_id']);
				$data['encoders'] = $this->Groupadmin_model->getAllEncodersbyUserIdAndGroupId($userdata['userid'],$userdata['group_id']);
				$data['gateways'] = $this->Groupadmin_model->getAllGatewaysbyUserIdAndGroupId($userdata['userid'],$userdata['group_id']);
				$data['encoderTemplates'] = $this->Groupadmin_model->getEncoderProfilesByUseridAndGroupId($userdata['userid'],$userdata['group_id']);
				$data['groupinfo'] = $this->common_model->getGroupInfobyId($userdata['group_id']);
				$data['nebula'] = $this->common_model->getNebula($userdata['group_id']);
			}
			$data['userDetails'] = $this->common_model->getUserDetails($userdata['userid']);

			$data['sessiondata']= $userdata;
			$this->load->view('admin/header');
			$this->load->view('admin/configuration',$data);
			$this->load->view('admin/footer');
		}
		public function clients()
		{
			$this->breadcrumbs->push('Clients', '/clients');
			$user_data = $this->session->userdata('user_data');
			$gids = array();
			if($user_data['user_type'] == 1)
			{
				$groups = $this->common_model->getGroups(0);
				$data['groups'] = $this->common_model->getGroups(0);
				$data['users'] = $this->common_model->getUsers($gids);
			}
			else
			{
				$groups = $this->common_model->getGroupInfobyId($user_data['group_id']);
				$data['groups'] = $this->common_model->getGroupInfobyId($user_data['group_id']);

				if(sizeof($groups)>0)
				{
					foreach($groups as $group)
					{
						array_push($gids,$group['id']);
					}
					$data['users'] = $this->common_model->getUsersByGroupIds($gids);
				}
				else
				{
					$data['users'] = array();
				}
			}


			$this->load->view('admin/header');
			$this->load->view('admin/clients',$data);
			$this->load->view('admin/footer');
		}
		public function profile()
		{
			try
			{
				$user_data = $this->session->userdata('user_data');
				$data['userProfileData'] = $this->common_model->getProfileData($user_data['userid']);
				$this->load->view('admin/header');
				$this->load->view('admin/profile',$data);
				$this->load->view('admin/footer');
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
				redirect(site_url().'headquarter/dashboard');
			}
		}
		public function updatewowza()
		{
			$this->load->view('admin/header');
			$this->load->view('admin/createwowza');
			$this->load->view('admin/footer');
		}
		public function creategroup()
		{
			$this->breadcrumbs->push('Clients/New Group', '/creategroup');
			$permissions = $this->session->userdata('user_permissions');
			if($permissions['create_group'] <= 0)
			{
				$this->session->set_flashdata('message_type', 'warning');
				$this->session->set_flashdata('warning', 'You are not authorized to add Groups.');
				redirect('clients');
			}
			elseif($permissions['create_group'] == "1")
			{
				$this->load->view('admin/header');
				$this->load->view('admin/creategroup');
				$this->load->view('admin/footer');
			}
		}
		public function createuser()
		{
			$this->breadcrumbs->push('Clients/New User', '/createuser');
			$permissions = $this->session->userdata('user_permissions');
			if($permissions['create_user'] <= 0)
			{
				$this->session->set_flashdata('message_type', 'warning');
				$this->session->set_flashdata('warning', 'You are not authorized to add Users.');
				redirect('clients');
			}
			elseif($permissions['create_user'] == "1")
			{
				$user_data = $this->session->userdata('user_data');
				if($user_data['user_type'] == 1)
				{
					$data['groups'] = $this->common_model->getGroups(0);
				}
				else
				{
					$data['groups'] = $this->common_model->getGroupInfobyId($user_data['group_id']);
				}
				$this->load->view('admin/header');
				$this->load->view('admin/createuser',$data);
				$this->load->view('admin/footer');
			}
		}
		public function applicationStatus()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$appid = $cleanData['appId'];
			$application = $this->common_model->getAppbyId($appid);
			$wowza = $this->common_model->getWovzData($application[0]['live_source']);
			$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.$application[0]['application_name'];
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_FAILONERROR, true);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_HEADER, FALSE);   // we want headers

			curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($curl, CURLOPT_TIMEOUT_MS, 300); //timeout in seconds
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($curl);
			$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	    	if($httpcode == 200)
	    	{
				$response['status'] = TRUE;
				$response['response'] = $httpcode;
			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = $httpcode;
			}
			if(curl_error($curl))
			{
				$response['status'] = FALSE;
				$response['response'] = $httpcode;
			}
			echo json_encode($response);
			curl_close($curl);
		}
		public function applications()
		{
			$this->breadcrumbs->push('Applications', '/applications');
			$this->session->unset_userdata('fb_token');
			$this->session->unset_userdata('rtmpData');
			$this->session->unset_userdata('fbUser');
			$this->session->unset_userdata('socialLogin');
			$segment = $this->uri->segment(3);
			$locksArray = array();
			$userdata = $this->session->userdata('user_data');
			if($segment != "" && $segment > 0)
			{
				$data['applications'] = $this->common_model->getWowzaApps($segment);
				$data['targets'] = $this->common_model->getAllTargets();
			}
			else
			{
				if($userdata['user_type'] == 1)
				{
					$data['applications'] = $this->common_model->getAllApplications(0);
					$apps = $this->common_model->getAllApplications(0);
					if(sizeof($apps)>0)
					{
						foreach($apps as $ap)
						{
							$locksArray[$ap['id']] = $ap['isLocked'];
						}
					}
					$data['targets'] = $this->common_model->getAllTargets(0);
				}
				else
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
					$appids = $this->Groupadmin_model->getAllApplicationsByWowzaIdAndUserId($wowzids,$userdata['userid']);
					if(sizeof($appids)>0)
					{
						foreach($appids as $appidddd)
						{
							array_push($apids,$appidddd['id']);
							$locksArray[$appidddd['id']] = $appidddd['isLocked'];
						}
					}
					$data['applications'] = $this->Groupadmin_model->getAllApplicationsByWowzaIdAndUserId($wowzids,$userdata['userid']);
					$data['targets'] = $this->Groupadmin_model->getAllTargetsbyWowzaAndAppid($apids,$userdata['userid']);
				}
			}
			$data['applock'] = $locksArray;
			$this->load->view('admin/header');
			$this->load->view('admin/applications',$data);
			$this->load->view('admin/footer');
		}
		public function createapplication()
		{
			$this->breadcrumbs->push('Applications/New Application', '/createapplication');
			$permissions = $this->session->userdata('user_permissions');
			if($permissions['create_application'] <= 0)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', "You are not authorized to create Applications.");
				redirect('applications');
			}
			elseif($permissions['create_application'] == 1)
			{
				$userdata = $this->session->userdata('user_data');
				if($userdata['user_type'] == 1)
				{
					$data['wowzaz'] = $this->common_model->getAllWowza();
				}
				else
				{
					$data['wowzaz'] = $this->Groupadmin_model->getConfigurationsDetails($userdata['userid'],$userdata['group_id']);
				}

				$this->load->view('admin/header');
				$this->load->view('admin/createvod',$data);
				$this->load->view('admin/footer');
			}
		}
		public function updateapp()
		{
			$this->breadcrumbs->push('Apps/Edit Application', '/applications');
			$appid = $this->uri->segment(2);
			$data['application'] = $this->common_model->getAppbyId($appid);
			$userdata = $this->session->userdata('user_data');
			if($userdata['user_type'] == 1)
			{
				$data['wowzaz'] = $this->common_model->getAllWowza();
			}
			else
			{
				$data['wowzaz'] = $this->Groupadmin_model->getConfigurationsDetails($userdata['userid'],$userdata['group_id']);
			}
			$application = $this->common_model->getAppbyId($appid);
			$wowza = $this->common_model->getWovzData($application[0]['live_source']);
			//check if publisher is up
			$appwowzastatusresponse = array('status'=>FALSE,'response'=>'');
			$appwowzastatusurl = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/status';
			$curlappengine = curl_init($appwowzastatusurl);
		  curl_setopt($curlappengine, CURLOPT_FAILONERROR, true);
		  curl_setopt($curlappengine, CURLOPT_FOLLOWLOCATION, true);
		  curl_setopt($curlappengine, CURLOPT_HEADER, true);    // we want headers
		  curl_setopt($curlappengine, CURLOPT_NOBODY, true);    // we don't need body
		  curl_setopt($curlappengine, CURLOPT_RETURNTRANSFER,1);
		  curl_setopt($curlappengine, CURLOPT_TIMEOUT_MS, 300); //timeout in seconds
		  curl_setopt($curlappengine, CURLOPT_SSL_VERIFYHOST, false);
		  curl_setopt($curlappengine, CURLOPT_SSL_VERIFYPEER, false);
		  $appwowzastatusresult = curl_exec($curlappengine);
		  $appwowzastatushttpcode = curl_getinfo($curlappengine, CURLINFO_HTTP_CODE);
			if(curl_error($curlappengine))
		  {
		    $appwowzastatusresponse['status'] = FALSE;
		    $appwowzastatusresponse['response'] = $appwowzastatushttpcode;
				$data['incomingStreams'] = array();
				$data['incomingStreamsCount'] = 0;
		  }
			else
		  {
		    $appwowzastatusresponse['status'] = TRUE;
		    $appwowzastatusresponse['response'] = $appwowzastatushttpcode;
				$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.$application[0]['application_name'].'/instances';
				$xmlData = file_get_contents($url);
				$data['xml'] = $xmlData;
				$xml = simplexml_load_string($xmlData);

				$elem = new SimpleXMLElement($xmlData);

				$isExists = isset($elem->InstanceList) ? TRUE : FALSE;
				if($isExists)
				{
					$mapEntiresCount = $elem->InstanceList->IncomingStreams->IncomingStream->count();
					$incomingStreams = json_encode($xml);
					$incomingStreamsArray = json_decode($incomingStreams,TRUE);
					$data['incomingStreams'] = $incomingStreamsArray;
					$data['incomingStreamsCount'] = $mapEntiresCount;
					$isRecorders = isset($elem->InstanceList->Recorders->StreamRecorder) ? TRUE : FALSE;
					if($isRecorders)
					{
						$data['recordersCount'] = $mapEntiresCount = $elem->InstanceList->Recorders->StreamRecorder->count();
					}
					else
					{
						$data['recordersCount'] = 0;
					}
				}
				else
				{
					$data['incomingStreams'] = array();
					$data['incomingStreamsCount'] = 0;
				}
				curl_close($curlappengine);
		  }
			$this->load->view('admin/header');
			$this->load->view('admin/updateapp',$data);
			$this->load->view('admin/footer');
		}
		public function createtarget()
		{
			$this->breadcrumbs->push('Applications/New Target', '/createtarget');
			$this->session->unset_userdata('act');
			$permissions = $this->session->userdata('user_permissions');
			$userdata = $this->session->userdata('user_data');
			$data = array();
			if($permissions['create_target'] <= 0)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', "You are not authorized to create Targets.");
				redirect('applications');
			}
			elseif($permissions['create_target'] == 1)
			{
				$wowzids = array();$apids = array();
				if($userdata['user_type'] == 1)
				{
					$data['apps'] = $this->common_model->getAllApplications(0);
				}
				else
				{
					$wowzaids = $this->Groupadmin_model->getConfigurationsDetails($userdata['userid'],$userdata['group_id']);
					if(sizeof($wowzaids)>0)
					{
						foreach($wowzaids as $wow)
						{
							array_push($wowzids,$wow['id']);
						}
					}
					$data['apps'] = $this->Groupadmin_model->getAllApplicationsByWowzaIdAndUserId($wowzids,$userdata['userid']);
				}
				 $this->session->unset_userdata('savetarget');
				 $this->session->unset_userdata('transiton');
				$this->load->view('admin/header');
				$this->load->view('admin/createtarget',$data);
				$this->load->view('admin/footer');
			}
		}
		public function text()
		{
			$this->load->view('admin/header');
			$this->load->view('site/test');
			$this->load->view('admin/footer');
		}
		public function playlists()
		{
			$this->load->view('admin/header');
			$this->load->view('admin/playlists');
			$this->load->view('admin/footer');
		}
		public function createplaylist()
		{
			$this->load->view('admin/header');
			$this->load->view('admin/createplaylist');
			$this->load->view('admin/footer');
		}
		public function permissions()
		{
			$data['users'] = $this->common_model->getUsers();
			$this->load->view('admin/header');
			$this->load->view('admin/permissions',$data);
			$this->load->view('admin/footer');
		}
		public function savePermissions()
		{
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$category = $this->common_model->getPermissionNames();
			$adminPermission = array();
			$groupPermission = array();$userPermission = array();
  			if(sizeof($category)>0)
  			{
				foreach($category as $cat)
				{
					if($cat != "id" && $cat != "rid" && $cat != "created")
					{
						if(array_key_exists($cat,$cleanData))
						{
							$values =$cleanData[$cat];
							$ids = array(1,2,3);

							foreach($ids as $key)
							{
								if(array_key_exists($key,$values))
								{
									if($key == "1")
									{
										$adminPermission[$cat] = 1;
									}
									if($key === 2)
									{
										$groupPermission[$cat] = 1;
									}

									if($key === 3)
									{
										$userPermission[$cat] = 1;
									}
								}
								else
								{
									if($key == "1")
									{
										$adminPermission[$cat] = 0;
									}
									if($key === 2)
									{
										$groupPermission[$cat] = 0;
									}

									if($key === 3)
									{
										$userPermission[$cat] = 0;
									}
								}
							}
						}
						else
						{
							$adminPermission[$cat] = 0;
							$groupPermission[$cat] = 0;
							$userPermission[$cat] = 0;
						}
					}
				}
				$adminPermission['created'] = time();$adminPermission['rid'] = 1;
				$groupPermission['created'] = time();$groupPermission['rid'] = 2;
				$userPermission['created'] = time();$userPermission['rid'] = 3;
			}
			$rids = array(1,2,3);
			foreach($rids as $rid)
			{
				$permission = $this->common_model->getUserPermission($rid);
				if(sizeof($permission)>0)
				{
					switch($rid)
					{
						case "1":
						$id = $this->common_model->updatePermissions($rid,$adminPermission);
						break;
						case "2":
						$id = $this->common_model->updatePermissions($rid,$groupPermission);
						break;
						case "3":
						$id = $this->common_model->updatePermissions($rid,$userPermission);
						break;
					}

				}
				else
				{
					switch($rid)
					{
						case "1":
						$id = $this->common_model->insertUserPermissions($adminPermission);
						break;
						case "2":
						$id = $this->common_model->insertUserPermissions($groupPermission);
						break;
						case "3":
						$id = $this->common_model->insertUserPermissions($userPermission);
						break;
					}
				}
			}
			$user_data = $this->session->userdata('user_data');
			$permission = $this->common_model->getUserPermission($user_data['user_type']);
			$this->session->set_userdata('user_permissions',$permission[0]);
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('success', 'Permissions updated successfully!');
			redirect('clients');
		}
		public function changepassword()
		{
			try
			{
				$user_data = $this->session->userdata('user_data');
				$postData = $this->input->post(NULL,TRUE);
				if(sizeof($postData)>0)
				{
					$cleanData = $this->security->xss_clean($postData);
					if(sizeof($this->common_model->oldPasswordMatched($cleanData['id'],$cleanData['oldpassword'])))
					{
						$profileData = array(
						'id'=>$cleanData['id'],
						'password'=>$cleanData['newpassword']
						);
						$message = '';
						$message .= '<strong>Your Password has been updated Successfully.</strong><br><br>';
						$data = array(
						'content' => $message
						);
						$config = Array(
						'mailtype' => 'html'
						);
						$content = $this->load->view('change_password',$data, true);
						$from_email = "kamal.oberoi@velocis.co.in";
						$to_email = $user_data['email'];
						/* Load email library */
						$this->load->library('email',$config);
						$this->email->from($from_email, 'Stream Manager Password Reset');
						$this->email->to($to_email);
						$this->email->subject('Stream Manager Password Reset');
						$this->email->message($content);
						if($this->email->send())
						{
							$status = $this->common_model->updateProfilePassword($profileData);
							if($status)
							{
								$this->session->set_flashdata('message_type', 'success');
								$this->session->set_flashdata('success', 'Password Successfully Updated!');
							}
							else
							{
								$this->session->set_flashdata('message_type', 'error');
								$this->session->set_flashdata('error', 'Error Occur While Updating Password! Try Again Later.');
							}
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'Error Occur While Email not send! Try Again Later.');
						}
					}
					else
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Old Password Not Matched.');
					}
				}
				$data['head'] = $this->session->userdata('user_data');
				$this->load->view('site/header');
				$this->load->view('site/changepassword',$data);
				$this->load->view('site/footer');
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time!');
				redirect(site_url().'headquarter/dashboard');
			}
		}
		public function saveUser()
		{
			try{

		        $this->form_validation->set_rules('phone', 'Phone Number', 'required');
		        $this->form_validation->set_rules('email_id', 'Email Id', 'required|valid_email');
		        $this->form_validation->set_rules('fname', 'First Name', 'required');
		        $this->form_validation->set_rules('lname', 'Last Name', 'required');
		        $this->form_validation->set_rules('timezone', 'Time Zone', 'required');
		        $this->form_validation->set_rules('timeformat', 'Time Format', 'required');
		        $this->form_validation->set_rules('password', 'Password', 'required');

				$this->form_validation->set_rules('passwordagain', 'Confirm Password', 'required|trim|xss_clean|matches[password]|strip_tags');
		        $post     = $this->input->post();
		        $actual_link =  $_SERVER['HTTP_REFERER'];
		        $clean   = $this->security->xss_clean($this->input->post(NULL, TRUE));
		        if ($this->form_validation->run() == FALSE) {
	        	    $this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', validation_errors());
					redirect($actual_link);
				}
		        else
		        {
	    		    if($this->user_model->isDuplicate($this->input->post('email_id')))
	    		    {
	    		     	$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Email Id Already Exist!');
						redirect($actual_link);
					}
		            else
		            {
		            	$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		            	$notify =0 ;$theme=0;
		            	if(array_key_exists('group_notification',$cleanData) && $cleanData['group_notification'] == "on")
		            	{
							$notify=1;
						}
						if(array_key_exists('group_theme',$cleanData) && $cleanData['group_theme'] == "on")
		            	{
							$theme=1;
						}
						$user_data = $this->session->userdata('user_data');
		                $userData = array(
							'fname'=>$cleanData['fname'],
							'lname'=>$cleanData['lname'],
							'email_id'=>$cleanData['email_id'],
							'timezone'=>$cleanData['timezone'],
							'timeformat'=>$cleanData['timeformat'],
							'phone'=>$cleanData['phone'],
							'group_notification'=>$notify,
							'theme'=>$theme,
							'group_id'=>$cleanData['group_id'],
							'password'=>sha1($cleanData['password']),
							'role_id'=>$cleanData['role_id'],
							'created'=>time(),
							'status'=>1,
							'createdby'=>$user_data['userid']
		                );
						$id = $this->user_model->insertUser($userData);
						if($id > 0)
						{
						 	$files = $_FILES['groupfile'];
						 	if($files["name"] != "")
							{
								$userId = $id;
								/*******File Content Check**********/
								$fnmae = $_FILES['groupfile']['name'];
								$typpe = $_FILES['groupfile']['type'];
								$tempfile = $_FILES['groupfile']['tmp_name'];
								if($files["name"] != "")
								{
									$name = str_replace(" ","_",$files['name']);
									$imgname = time().'_'.$name;

									$target_file = 'public/site/main/group_pics/'.$imgname;
									if (move_uploaded_file($_FILES["groupfile"]["tmp_name"], $target_file)) {
										if($this->common_model->insertUserImage($imgname,$userId))
										{
											$this->session->set_flashdata('message_type', 'success');
											$this->session->set_flashdata('success', 'User is sucessfully created!');
											redirect('clients');
										}
									}
								}
							}
							else
							{
								$this->session->set_flashdata('message_type', 'success');
								$this->session->set_flashdata('success', 'User is sucessfully created!');
								redirect('clients');
							}
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'Error occur while updloading User image!');

							redirect('admin/clients');
						}
					}
				}
			}
			catch(Exception $e)
			{
		 		$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occured While Creating User!');
				redirect('admin/createuser');
			}
		}
		function random_stringid($length)
		{
			 $key = '';
		    $keys = array_merge( range('A', 'Z'),range(0, 9),range('a', 'z'));

		    for ($i = 0; $i < $length; $i++) {
		        $key .= $keys[array_rand($keys)];
		    }

		    return $key;
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
		public function updateEncoderTemplate()
		{
			try{
				$permissions = $this->session->userdata('user_permissions');
				if($permissions['edit_template'] <= 0)
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'You are not authorized to edit Publishers.');
					redirect('configuration');
				}
				elseif($permissions['edit_template'] == "1")
				{
					$tempId = $this->uri->segment(3);
					$post     = $this->input->post();
					$actual_link =  $_SERVER['HTTP_REFERER'];
					$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
					$userdata = $this->session->userdata('user_data');
					$enableVideo =0; $advance_video_setting=0;$enabledeinterlance=0;$audio_check=0;$enableAdvanceAudio=0;
					if(array_key_exists('enableVideo',$cleanData) && $cleanData['enableVideo'] == "on")
					{
						$enableVideo = 1;
					}
					if(array_key_exists('advance_video_setting',$cleanData) && $cleanData['advance_video_setting'] == "on")
					{
						$advance_video_setting = 1;
					}
					if(array_key_exists('enabledeinterlance',$cleanData) && $cleanData['enabledeinterlance'] == "on")
					{
						$enabledeinterlance = 1;
					}
					if(array_key_exists('audio_check',$cleanData) && $cleanData['audio_check'] == "on")
					{
						$audio_check = 1;
					}
					if(array_key_exists('enableAdvanceAudio',$cleanData) && $cleanData['enableAdvanceAudio'] == "on")
					{
						$enableAdvanceAudio = 1;
					}
					$encoderData = array(
						'uid'=>$userdata['userid'],
	                	'template_name'=>$cleanData['template_name'],
	                	'enableVideo'=>$enableVideo,
	                	'video_codec'=>$cleanData['video_codec'],
	                	'video_resolution'=>$cleanData['video_resolution'],
	                	'video_bitrate'=>$cleanData['video_bitrate'],
	                	'video_framerate'=>$cleanData['video_framerate'],
	                	'video_min_bitrate'=>$cleanData['video_min_bitrate'],
	                	'video_max_bitrate'=>$cleanData['video_max_bitrate'],
	                	'advance_video_setting'=>$advance_video_setting,
	                	'adv_video_preset'=>$cleanData['adv_video_min_bitrate'],
	                	'adv_video_profile'=>$cleanData['adv_video_max_bitrate'],
	                	'adv_video_buffer_size'=>$cleanData['adv_video_buffer_size'],
	                	'adv_video_gop'=>$cleanData['adv_video_gop'],
	                	'adv_video_keyframe_intrval'=>$cleanData['adv_video_keyframe_intrval'],
	                	'enabledeinterlance'=>$enabledeinterlance,
	                	'audio_check'=>$audio_check,
	                	'audio_codec'=>$cleanData['audio_codec'],
	                	'audio_channel'=>$cleanData['audio_channel'],
	                	'audio_bitrate'=>$cleanData['audio_bitrate'],
	                	'audio_sample_rate'=>$cleanData['audio_sample_rate'],
	                	'enableAdvanceAudio'=>$enableAdvanceAudio,
	                	'audio_gain'=>$cleanData['rangeslider'],
	                	'delay'=>$cleanData['delay']

					);
					$id = $this->common_model->updateEncodingTemplate($encoderData,$tempId);
					if($id >= 0)
					{
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Encoding Template is sucessfully updated!');
						redirect('admin/configuration');
					}
					else
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error occur while updating Encoding Preset!');
						redirect('admin/configuration');
					}
				}

			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while updating Encoding Preset!');
				redirect('admin/configuration');
			}
		}
		public function saveEncoderTemplate()
		{
			try{


				$post     = $this->input->post();
				$actual_link =  $_SERVER['HTTP_REFERER'];
				$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));

				$userdata = $this->session->userdata('user_data');
				$enableVideo =0; $advance_video_setting=0;$enabledeinterlance=0;$audio_check=0;$enableAdvanceAudio=0;$enablezerolatency=0;
				if(array_key_exists('enableVideo',$cleanData) && $cleanData['enableVideo'] == "on")
				{
					$enableVideo = 1;
				}
				if(array_key_exists('advance_video_setting',$cleanData) && $cleanData['advance_video_setting'] == "on")
				{
					$advance_video_setting = 1;
				}
				if(array_key_exists('enabledeinterlance',$cleanData) && $cleanData['enabledeinterlance'] == "on")
				{
					$enabledeinterlance = 1;
				}
				if(array_key_exists('enablezerolatency',$cleanData) && $cleanData['enablezerolatency'] == "on")
				{
					$enablezerolatency = 1;
				}
				if(array_key_exists('audio_check',$cleanData) && $cleanData['audio_check'] == "on")
				{
					$audio_check = 1;
				}
				if(array_key_exists('enableAdvanceAudio',$cleanData) && $cleanData['enableAdvanceAudio'] == "on")
				{
					$enableAdvanceAudio = 1;
				}
				$groupId=0;
				if($userdata['user_type'] == 1)
				{
					$groupId = 0;
				}
				else
				{
					$groupId = $userdata['group_id'];
				}
				$video_codec = "";$video_resolution ="";$video_bitrate="";$video_framerate="";
				if(array_key_exists('video_codec',$cleanData))
				{
					$video_codec = $cleanData['video_codec'];
				}
				if(array_key_exists('video_resolution',$cleanData))
				{
					$video_resolution = $cleanData['video_resolution'];
				}
				if(array_key_exists('video_bitrate',$cleanData))
				{
					$video_bitrate = $cleanData['video_bitrate'];
				}
				if(array_key_exists('video_framerate',$cleanData))
				{
					$video_framerate = $cleanData['video_framerate'];
				}

				$encoderData = array(
					'uid'=>$userdata['userid'],
                	'template_name'=>$cleanData['template_name'],
                	'enableVideo'=>$enableVideo,
                	'video_codec'=>$video_codec,
                	'video_resolution'=>$video_resolution,
                	'video_bitrate'=>$video_bitrate,
                	'video_framerate'=>$video_framerate,
                	'video_min_bitrate'=>$cleanData['video_min_bitrate'],
                	'video_max_bitrate'=>$cleanData['video_max_bitrate'],
                	'advance_video_setting'=>$advance_video_setting,
                	'adv_video_preset'=>$cleanData['adv_video_min_bitrate'],
                	'adv_video_profile'=>$cleanData['adv_video_max_bitrate'],
                	'adv_video_buffer_size'=>$cleanData['adv_video_buffer_size'],
                	'adv_video_gop'=>$cleanData['adv_video_gop'],
                	'adv_video_keyframe_intrval'=>$cleanData['adv_video_keyframe_intrval'],
                	'enabledeinterlance'=>$enabledeinterlance,
                	'enablezerolatency'=>$enablezerolatency,
                	'audio_check'=>$audio_check,
                	'audio_codec'=>$cleanData['audio_codec'],
                	'audio_channel'=>$cleanData['audio_channel'],
                	'audio_bitrate'=>$cleanData['audio_bitrate'],
                	'audio_sample_rate'=>$cleanData['audio_sample_rate'],
                	'enableAdvanceAudio'=>$enableAdvanceAudio,
                	'audio_gain'=>$cleanData['rangeslider'],
                	'delay'=>$cleanData['delay'],
                	'group_id'=>$groupId,
                	'status'=>1,
                	'created'=>time()
				);
				$id = $this->common_model->insertEncodeingTemplate($encoderData);
				if($id > 0)
				{
					$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'Encoding Template is sucessfully saved!');
					redirect('createtemplate');
				}
				else
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error occur while adding Encoding Preset!');
					redirect('createtemplate');
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while adding Encoding Preset!');
				redirect('configuration');
			}
		}
		public function saveGroup()
		{
			try{
				$this->form_validation->set_rules('group_name', 'Group Name', 'required');
				$this->form_validation->set_rules('group_website', 'Group Website', 'required');
				$this->form_validation->set_rules('group_email', 'Email Id', 'required|valid_email');
				$this->form_validation->set_rules('group_phone', 'Phone Number', 'required');
				$this->form_validation->set_rules('group_address', 'Address', 'required');
				$this->form_validation->set_rules('group_postal_code', 'Postal Code', 'required');
				$this->form_validation->set_rules('group_city', 'City', 'required');
				$this->form_validation->set_rules('group_country', 'Country', 'required');
				$post     = $this->input->post();
				$actual_link =  $_SERVER['HTTP_REFERER'];
				$clean   = $this->security->xss_clean($this->input->post(NULL, TRUE));
				if ($this->form_validation->run() == FALSE) {
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', validation_errors());
					redirect($actual_link);
				}
				else
				{
					$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
					if(array_key_exists('group_notification',$cleanData) && $cleanData['group_notification'] == "on")
					{
						$groupnotification = 1;
					}
					else
					{
						$groupnotification = 0;
					}
					$udata = $this->session->userdata('user_data');
					$userData = array(
						'uid'=>$udata['userid'],
	                	'group_name'=>$cleanData['group_name'],
	                	'group_website'=>$cleanData['group_website'],
	                	'group_email'=>$cleanData['group_email'],
	                	'group_phone'=>$cleanData['group_phone'],
	                	'group_address'=>$cleanData['group_address'],
	                	'group_postal_code'=>$cleanData['group_postal_code'],
	                	'group_city'=>$cleanData['group_city'],
	                	'group_country'=>$cleanData['group_country'],
	                	'group_notification'=>$groupnotification,
	                	'group_licence'=>$cleanData['group_licence'],
	                	'created'=>time()
					);
					$id = $this->common_model->insertGroup($userData);
					if($id > 0)
					{
						$files = $_FILES['groupfile'];
						$userId = $id;
						if($files["name"] != "")
						{
							$name = str_replace(" ","_",$files['name']);
							$imgname = time().'_'.$name;

							$target_file = 'public/site/main/group_pics/'.$imgname;
							if (move_uploaded_file($_FILES["groupfile"]["tmp_name"], $target_file)) {
								$data = array(
								'name'=>$imgname,
								'created'=>time(),
								'status'=>1,
								'gid'=>$id
								);

								if($this->common_model->insertGroupImage($data))
								{
									$this->session->set_flashdata('message_type', 'success');
									$this->session->set_flashdata('success', 'Group is sucessfully cretaed!');
									$this->session->set_flashdata('tab', 'Group');
									redirect('admin/clients');
								}
							}
						}
						else
						{
							$this->session->set_flashdata('message_type', 'success');
							$this->session->set_flashdata('success', 'Group is sucessfully cretaed!');
							$this->session->set_flashdata('tab', 'Group');
							redirect('admin/clients');
						}
					}
					else
					{
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Group is sucessfully cretaed!');
						redirect('admin/clients');
					}
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while updloading group image!');
				redirect('admin/creategroup');
			}
		}
		public function updategroupanduserinfo()
		{
			$permissions = $this->session->userdata('user_permissions');
			if($permissions['create_encoder'] <= 0)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', "You are not authorized to add Encoders.");
				redirect('configuration');
			}
			elseif($permissions['create_encoder'] == 1)
			{
				$userdata = $this->session->userdata('user_data');
				$this->form_validation->set_rules('group_name', 'Group Name', 'required');
				$this->form_validation->set_rules('group_email', 'Group Email', 'required');
				$this->form_validation->set_rules('group_sitename', 'Hide Sitename', 'required');
				$this->form_validation->set_rules('timezone', 'Timezone', 'required');
				$clean   = $this->security->xss_clean($this->input->post(NULL, TRUE));
				if(array_key_exists('group_favicon',$clean) && $clean['group_favicon'] == "on")
				{
					$groupfavicon = 1;
				}
				else
				{
					$groupfavicon = 0;
				}
				if(array_key_exists('group_theme',$clean) && $clean['group_theme'] == "on")
				{
					$grouptheme = 1;
				}
				else
				{
					$grouptheme = 0;
				}
				if(array_key_exists('group_menu_hide',$clean) && $clean['group_menu_hide'] == "on")
				{
					$groupmenuhide = 1;
				}
				else
				{
					$groupmenuhide = 0;
				}
				if(array_key_exists('group_logo',$clean) && $clean['group_logo'] == "on")
				{
					$grouplogo = 1;
				}
				else
				{
					$grouplogo = 0;
				}
				if(array_key_exists('group_sitename',$clean) && $clean['group_sitename'] == "on")
				{
					$groupsitename = 1;
				}
				else
				{
					$groupsitename = 0;
				}
				if(array_key_exists('group_notification',$clean) && $clean['group_notification'] == "on")
				{
					$groupnotification = 1;
				}
				else
				{
					$groupnotification = 0;
				}
				$updateGroup = array(
	        	'group_name'=>$clean['group_name'],
	        	'group_email'=>$clean['group_email'],
	        	'group_licence'=>$clean['group_licence'],
				'group_favicon'=>$groupfavicon,
				'group_theme'=>$grouptheme,
				'group_menu_hide'=>$groupmenuhide,
				'group_logo'=>$grouplogo,
				'group_sitename'=>$groupsitename,
				'group_notification'=>$groupnotification,

				);
				$updateGroup1 = array(
				'timezone'=>$clean['timezone'],
				'timeformat'=>$clean['timeformat'],
				'language'=>$clean['language']
				);

				$status = $this->common_model->updateGroupInfo($updateGroup,$userdata['group_id']);
				$this->common_model->updateGroupInfo1($updateGroup1,$userdata['userid']);
				if($status > 0)
				{
					$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'Configuration Updated Successfully!');
					redirect('admin/configuration');
				}
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'Configuration Updated Successfully!');
				redirect('admin/configuration');
			}
		}
		public function saveeditTarget()
		{
			$permissions = $this->session->userdata('user_permissions');
			if($permissions['edit_target'] <= 0)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'You are not authorized to update Targets.');
				redirect('applications');
			}
			elseif($permissions['edit_target'] == "1")
			{
				$userdata = $this->session->userdata('user_data');
				$id = $this->uri->segment(3);
				$this->form_validation->set_rules('target_name', 'Target Name', 'required');
				$this->form_validation->set_rules('wowzaengin', 'Live Source', 'required');
				$this->form_validation->set_rules('streamurl', 'Stream URL', 'required');


				$post     = $this->input->post();
				$actual_link =  $_SERVER['HTTP_REFERER'];
				$cleanData   = $this->security->xss_clean($this->input->post(NULL, TRUE));
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', validation_errors());
					redirect($actual_link);
				}
				else
				{
					try
					{

						$cont =0;
						if(array_key_exists('continuelive',$cleanData))
						{
							$cont = 1;
						}
						else
						{
							$cont = 0;
						}



						$userData = array(
	                	'target_name'=>$cleanData['target_name'],
	                	'wowzaengin'=>$cleanData['wowzaengin'],
	                	'streamurl'=>$cleanData['streamurl'],
	                	'title'=>$cleanData['title'],
	                	'description'=>$cleanData['description'],
	                	'continuelive'=>$cont
						);
						if(array_key_exists('timelines',$cleanData) && $cleanData['timelines'] != "" && $cleanData['timelines'] == "page")
						{
							$PAndToken = explode('_',$cleanData['pagelist']);
							$userData['pagename'] = $PAndToken[2];
						}
						switch($cleanData['target']){
							case "facebook":
							if(array_key_exists('fbuserid',$cleanData) && array_key_exists('fbusername',$cleanData) && array_key_exists('timelines',$cleanData))
							{
								$userData['fbuserid'] = $cleanData['fbuserid'];
								$userData['fbusername'] = $cleanData['fbusername'];
								$userData['shareon'] = $cleanData['timelines'];
							}
							break;
						}
						$apps = $this->common_model->getAppbyId($cleanData['wowzaengin']);
						$wid = $apps[0]['live_source'];
						$wowza = $this->common_model->getWovzData($wid);

						switch($cleanData['target']){
							case "rtmp":
							if(array_key_exists('rtmp_stream_url',$cleanData))
							{
								$streamURL = $cleanData['rtmp_stream_url'];
							}
							else
							{
								$streamURL = "";
							}
							if(array_key_exists('rtmp_stream_key',$cleanData))
							{
								$streamKey = $cleanData['rtmp_stream_key'];
							}
							else
							{
								$streamKey = "";
							}
							$isAuth = 0;$uname = "";$pass="";
							if(array_key_exists('target_auth',$cleanData))
							{
								$isAuth = 1;

							}
							if(array_key_exists('target_auth_uname',$cleanData))
							{
								$uname = $cleanData["target_auth_uname"];

							}
							if(array_key_exists('target_auth_pass',$cleanData))
							{
								$pass = $cleanData["target_auth_pass"];

							}
							$userData['rtmp_stream_url'] = $streamURL;
							$userData['rtmp_stream_key'] = $streamKey;
							$userData['target_auth'] = $isAuth;
							$userData['target_auth_uname'] = $uname;
							$userData['target_auth_pass'] = $pass;
							break;
							case "facebook":
							$n = str_replace(' ','%20',$cleanData['target_name']);
							$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.$apps[0]['application_name'].'/pushpublish/mapentries/'.$n;

							if(array_key_exists('fbuserid',$cleanData) && array_key_exists('fbusername',$cleanData) && array_key_exists('timelines',$cleanData))
							{
								$createLiveVideo = array();
								define('APP_URL', 'https://iohub.tv/admin/fb');
								$fbToken = $this->session->userdata('fb_token');
								$fbcode = $this->session->userdata('fb_code');
								if($cleanData['timelines'] == "page")
								{
									$facebookArray = array('app_id' => '201130880631964', 'app_secret' => '49e984459f5d67695b85b443dc879d82',  'default_graph_version' => 'v2.6');
								$u = $this->session->userdata('fbUser');
								$fbobj = new Facebook\Facebook($facebookArray);
								$pageidAndToken = explode('_',$cleanData['pagelist']);

			 					$urlll = "https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id=201130880631964&client_secret=49e984459f5d67695b85b443dc879d82&fb_exchange_token=".$pageidAndToken[1]."&scope=publish_pages,manage_pages";
			 					$fch = curl_init();
								curl_setopt($fch,CURLOPT_URL, $urlll);
								curl_setopt($fch, CURLOPT_FAILONERROR, true);
								curl_setopt($fch, CURLOPT_FOLLOWLOCATION, true);
								curl_setopt($fch, CURLOPT_HEADER, FALSE);   // we want headers
								    // we don't need body
								curl_setopt($fch, CURLOPT_RETURNTRANSFER,1);
								//curl_setopt($fch, CURLOPT_TIMEOUT_MS, 300); //timeout in seconds
								curl_setopt($fch, CURLOPT_SSL_VERIFYHOST, false);
								curl_setopt($fch, CURLOPT_SSL_VERIFYPEER, false);
								curl_setopt($fch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
								$result = curl_exec($fch);
								$httpcode = curl_getinfo($fch, CURLINFO_HTTP_CODE);
								curl_close($fch);

			 					$tokenArray = json_decode($result,TRUE);
								}


							}



							if($cleanData['timelines'] == "timeline")
							{
								if($cont == 1)
								{
									$createLiveVideo = $fbobj->post('/me/live_videos', ["title"=>$cleanData['title'],'stream_type'=>"AMBIENT", "description"=>$cleanData['description'],'privacy'=>array('value'=>$cleanData['privacy'])],$fbToken);
								}
								else
								{
									$createLiveVideo = $fbobj->post('/me/live_videos', ["title"=>$cleanData['title'], "description"=>$cleanData['description'],'privacy'=>array('value'=>$cleanData['privacy'])],$fbToken);
								}

								$graphNode = $createLiveVideo->getGraphNode()->asArray();
							}
							elseif($cleanData['timelines'] == "page")
							{
								if($cont == 1)
								{
									$createLiveVideo = $fbobj->post('/'.$pageidAndToken[0].'/live_videos',["title"=>$cleanData['title'],'stream_type'=>"AMBIENT", "description"=>$cleanData['description']],$tokenArray['access_token']);
								}
								else
								{
									$createLiveVideo = $fbobj->post('/'.$pageidAndToken[0].'/live_videos',["title"=>$cleanData['title'], "description"=>$cleanData['description']],$tokenArray['access_token']);
								}


								$graphNode = $createLiveVideo->getGraphNode()->asArray();
							}


							$stremURL = explode('/',$cleanData['streamurl']);
							$fields = array(
								'source_name'=>$stremURL[4],
								'target_name'=>$cleanData['target_name'],
								'app_name'=>$apps[0]['application_name'],
								'rtmp_url'=>$graphNode['stream_url'],
								'enabled'=>'false'
							);
							break;
						}
						$stramArray = explode('/',$graphNode['stream_url']);
        				$URLStream = $stramArray[sizeof($stramArray)-1];

						$xmlData = '<PushPublishStream serverName="_defaultServer_">
    <Enabled>false</Enabled>
    <AutoStartTranscoder>false</AutoStartTranscoder>
    <SourceStreamName>'.$stremURL[4].'</SourceStreamName>
    <Profile>rtmp</Profile>
    <StreamName>'.str_replace('&','&amp;',$URLStream).'</StreamName>
    <Application>rtmp</Application>
    <Host>rtmp-api.facebook.com</Host>
    <Port>443</Port>
    <AdaptiveStreaming>false</AdaptiveStreaming>
    <SendFCPublish>true</SendFCPublish>
    <SendReleaseStream>true</SendReleaseStream>
    <SendStreamCloseCommands>true</SendStreamCloseCommands>
    <RemoveDefaultAppInstance>true</RemoveDefaultAppInstance>
    <SendOriginalTimecodes>true</SendOriginalTimecodes>
    <OriginalTimecodeThreshold>0x100000</OriginalTimecodeThreshold>
    <Akamai.HdNetwork>true</Akamai.HdNetwork>
    <Akamai.SendToBackupServer>false</Akamai.SendToBackupServer>
    <Akamai.DestinationServer>primary</Akamai.DestinationServer>
    <DestinationServer>primary</DestinationServer>
    <Cupertino.Renditions>audiovideo</Cupertino.Renditions>
    <Http.playlistCount>0</Http.playlistCount>
    <Http.playlistAcrossSessions>false</Http.playlistAcrossSessions>
    <Http.playlistTimeout>120000</Http.playlistTimeout>
    <Http.fakePosts>false</Http.fakePosts>
    <Http.writerDebug>false</Http.writerDebug>
    <StreamWaitTimeout>5000</StreamWaitTimeout>
    <TimeToLive>63</TimeToLive>
    <RTPWrap>false</RTPWrap>
    <Shoutcast.Public>false</Shoutcast.Public>
    <Icecast2.Public>false</Icecast2.Public>
    <srtKeyLength>0</srtKeyLength>
    <srtRecoveryBuffer>400</srtRecoveryBuffer>
    <DebugLogChildren>false</DebugLogChildren>
    <DebugLog>false</DebugLog>
    <DebugPackets>false</DebugPackets>
    <SendSSL>true</SendSSL>
    <Facebook.continuousLive>false</Facebook.continuousLive>
    <Facebook.360Projection>none</Facebook.360Projection>
    <WowzaCloud.adaptiveStreaming>true</WowzaCloud.adaptiveStreaming>
</PushPublishStream>';
$xmlll ='<PushPublishStream serverName="_defaultServer_">
    <Enabled>false</Enabled>
    <AutoStartTranscoder>false</AutoStartTranscoder>
    <SourceStreamName>'.$stremURL[4].'</SourceStreamName>
    <Profile>rtmp</Profile>
    <StreamName>'.str_replace('&','&amp;',$URLStream).'</StreamName>
    <Application>rtmp</Application>
    <Host>rtmp-api.facebook.com</Host>
    <Port>443</Port>
    <AdaptiveStreaming>false</AdaptiveStreaming>
    <SendFCPublish>true</SendFCPublish>
    <SendReleaseStream>true</SendReleaseStream>
    <SendStreamCloseCommands>true</SendStreamCloseCommands>
    <RemoveDefaultAppInstance>true</RemoveDefaultAppInstance>
    <SendOriginalTimecodes>true</SendOriginalTimecodes>
    <OriginalTimecodeThreshold>0x100000</OriginalTimecodeThreshold>
    <Akamai.HdNetwork>true</Akamai.HdNetwork>
    <Akamai.SendToBackupServer>false</Akamai.SendToBackupServer>
    <Akamai.DestinationServer>primary</Akamai.DestinationServer>
    <DestinationServer>primary</DestinationServer>
    <Cupertino.Renditions>audiovideo</Cupertino.Renditions>
    <Http.playlistCount>0</Http.playlistCount>
    <Http.playlistAcrossSessions>false</Http.playlistAcrossSessions>
    <Http.playlistTimeout>120000</Http.playlistTimeout>
    <Http.fakePosts>false</Http.fakePosts>
    <Http.writerDebug>false</Http.writerDebug>
    <StreamWaitTimeout>5000</StreamWaitTimeout>
    <TimeToLive>63</TimeToLive>
    <RTPWrap>false</RTPWrap>
    <Shoutcast.Public>false</Shoutcast.Public>
    <Icecast2.Public>false</Icecast2.Public>
    <srtKeyLength>0</srtKeyLength>
    <srtRecoveryBuffer>400</srtRecoveryBuffer>
    <DebugLogChildren>false</DebugLogChildren>
    <DebugLog>false</DebugLog>
    <DebugPackets>false</DebugPackets>
    <SendSSL>true</SendSSL>
    <Facebook.continuousLive>false</Facebook.continuousLive>
    <Facebook.360Projection>none</Facebook.360Projection>
    <WowzaCloud.adaptiveStreaming>true</WowzaCloud.adaptiveStreaming>
</PushPublishStream>';

						$ch = curl_init();
						curl_setopt($ch,CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
					    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
					    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
					    curl_setopt($ch, CURLOPT_POSTFIELDS,$xmlll);
						$result = curl_exec($ch);
						$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
							$err = curl_error($ch);
						curl_close($ch);





						if ($err) {
						  echo "cURL Error #:" . $err;
						} else {
						  echo $result;
						}

						$sts = $this->common_model->updateTarget($id,$userData);

						if($sts >= 0)
						{
							$this->session->set_flashdata('message_type', 'success');
							$this->session->set_flashdata('success', 'Target Updated Successfully!');
							redirect('applications');
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'Error occured while updating target!');
							redirect('applications');
						}
					}
					catch(Exception $e)
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', $e->getMessage());
						redirect($actual_link);
					}
				}
			}
		}
		public function XML2Array($parent)
		{
		    $array = array();

		    foreach ($parent as $name => $element) {
		        ($node = & $array[$name])
		            && (1 === count($node) ? $node = array($node) : 1)
		            && $node = & $node[];

		        $node = $element->count() ? $this->XML2Array($element) : trim($element);
		    }

		    return $array;
		}
		public function saveTarget()
		{
			try
			{
				$userdata = $this->session->userdata('user_data');
				$this->form_validation->set_rules('target_name', 'Target Name', 'required');
				$this->form_validation->set_rules('wowzaengin', 'Live Source', 'required');
				$this->form_validation->set_rules('streamurl', 'Stream URL', 'required');
				$post     = $this->input->post();
				$actual_link =  $_SERVER['HTTP_REFERER'];
				$cleanData   = $this->security->xss_clean($this->input->post(NULL, TRUE));
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', validation_errors());
					redirect($actual_link);
				}
				else
				{
					$is_scheduled = 0;

					$cont =0;
					if(array_key_exists('continuelive',$cleanData))
					{
						$cont = 1;
					}
					else
					{
						$cont = 0;
					}
					$socialLogin = $this->session->userdata('socialLogin');

					$userData = array(
	                	'target_name'=>$cleanData['target_name'],
	                	'wowzaengin'=>$cleanData['wowzaengin'],
	                	'streamurl'=>$cleanData['streamurl'],
	                	'target'=>$socialLogin,
	                	'continuelive'=>$cont,
	                	'status'=>1,
	                	'created'=>time(),
	                	'uid'=>$userdata['userid']
					);
					if(array_key_exists('enableTargetSchedule',$cleanData))
					{
						$userData['enableTargetSchedule'] = 1;
						$userData['start_date'] = $cleanData['start_date'];
						$userData['end_date'] = $cleanData['end_date'];
					}
					if(sizeof($socialLogin)>0)
                    {
                    	switch($socialLogin){
                    		case "facebook": case "google": case "twitter": case "twitch":
                    		$userData['title'] = $cleanData['title'];
							$userData['description'] = $cleanData['description'];
                    		break;
                    	}
                    }
					if(sizeof($socialLogin)>0)
                    {
                    	switch($socialLogin){
							case "facebook":
							$userData['fbuserid'] = $cleanData['fbuserid'];
							$userData['fbusername'] = $cleanData['fbusername'];
							$userData['shareon'] = $cleanData['timelines'];
							if($cleanData['timelines'] != "" && $cleanData['timelines'] == "page")
							{
								$PAndToken = explode('_',$cleanData['pagelist']);
								$userData['pagename'] = $PAndToken[2];
							}
							break;
							case "google":
							$userData['broadcast_id'] = $cleanData['broadcast_id'];
							$userData['livstreamid'] = $cleanData['livstreamid'];
							break;
						}
					}

					$apps = $this->common_model->getAppbyId($cleanData['wowzaengin']);
					$wid = $apps[0]['live_source'];
					$wowza = $this->common_model->getWovzData($wid);

					$message = "";
                    if(sizeof($socialLogin)>0)
                    {
                    	switch($socialLogin){
							case "facebook":
							$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.$apps[0]['application_name'].'/pushpublish/mapentries/'.$cleanData['target_name'];
							$createLiveVideo = array();

							$fbToken = $this->session->userdata('fb_token');

							$fbcode = $this->session->userdata('fb_code');
							$facebookArray = array('app_id' => '201130880631964', 'app_secret' => '49e984459f5d67695b85b443dc879d82',  'default_graph_version' => 'v2.6');
							$u = $this->session->userdata('fbUser');
							$fbobj = new Facebook\Facebook($facebookArray);
							$pageidAndToken = explode('_',$cleanData['pagelist']);


		 					$urlll = "https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id=201130880631964&client_secret=49e984459f5d67695b85b443dc879d82&fb_exchange_token=".$pageidAndToken[1]."&scope=publish_pages,manage_pages,publish_video";
		 					$fch = curl_init();
							curl_setopt($fch,CURLOPT_URL, $urlll);
							curl_setopt($fch, CURLOPT_FAILONERROR, true);
							curl_setopt($fch, CURLOPT_FOLLOWLOCATION, true);
							curl_setopt($fch, CURLOPT_HEADER, FALSE);   // we want headers
							    // we don't need body
							curl_setopt($fch, CURLOPT_RETURNTRANSFER,1);
							//curl_setopt($fch, CURLOPT_TIMEOUT_MS, 300); //timeout in seconds
							curl_setopt($fch, CURLOPT_SSL_VERIFYHOST, false);
							curl_setopt($fch, CURLOPT_SSL_VERIFYPEER, false);
							curl_setopt($fch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
							$result = curl_exec($fch);
							$httpcode = curl_getinfo($fch, CURLINFO_HTTP_CODE);
							curl_close($fch);

		 					$tokenArray = json_decode($result,TRUE);

							if($cleanData['timelines'] == "timeline")
							{
								if($cont == 1)
								{
									$createLiveVideo = $fbobj->post('/me/live_videos', ["title"=>$cleanData['title'],'stream_type'=>"AMBIENT", "description"=>$cleanData['description'],'privacy'=>array('value'=>$cleanData['privacy'])],$fbToken);
								}
								else
								{
									$createLiveVideo = $fbobj->post('/me/live_videos', ["title"=>$cleanData['title'], "description"=>$cleanData['description'],'privacy'=>array('value'=>$cleanData['privacy'])],$fbToken);
								}
								$userData['page_id'] = "me";
							}
							elseif($cleanData['timelines'] == "page")
							{
								if($cont == 1)
								{
									$createLiveVideo = $fbobj->post('/'.$pageidAndToken[0].'/live_videos',["title"=>$cleanData['title'],'stream_type'=>"AMBIENT", "description"=>$cleanData['description']],$tokenArray['access_token']);
								}
								else
								{
									$createLiveVideo = $fbobj->post('/'.$pageidAndToken[0].'/live_videos',["title"=>$cleanData['title'],"description"=>$cleanData['description']],$tokenArray['access_token']);
								}
								$userData['page_id'] = $pageidAndToken[0];
							}
							$graphNode = $createLiveVideo->getGraphNode()->asArray();
							$userData['broadcast_id'] = $graphNode['id'];
							$userData['livstreamid'] = $graphNode['stream_url'];
							$stremURL = explode('/',$cleanData['streamurl']);
							$stremURLFB = explode('/',$graphNode['stream_url']);
							$fields = array(
								"sourceStreamName"=>$stremURL[4],
								"profile"=>"rtmp",
								"application"=>"rtmp",
       							"host"=>"live-api-s.facebook.com",
       							"streamName"=>$stremURLFB[4],
						        "port"=>"443",
										"sendSSL"=>"true",
						        "enabled"=>"false",
						        "extraOptions"=>array("destinationName"=>"rtmp")
							);

							break;
							case "google":
							$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['java_api_port'].'/api/v1/addYTStream';
							$stremURL = explode('/',$cleanData['streamurl']);

							$fields = array(
								'source_name'=>$stremURL[4],
								'target_name'=>$cleanData['target_name'],
								'app_name'=>$apps[0]['application_name'],
								'stream_key'=>$cleanData['googlestream'],
								'enabled'=>'false'
							);
							break;
							case "twitter":
							$stremURL = explode('/',$cleanData['streamurl']);
							$refreshToken =  $this->session->userdata('twitter_refresh');
							$twitterData =  $this->session->userdata('twitter_data');
							$twitterAccesstoken = $this->session->userdata('twitter_access');
							$URL_broadCast = "https://api.pscp.tv/v1/broadcast/create";
							$fields_broadcast = array(
								"region"=>"ap-southeast-1","is_360"=>false,"is_low_latency"=>false
							);
							$ch_broadcast = curl_init();
							curl_setopt($ch_broadcast,CURLOPT_URL, $URL_broadCast);
							curl_setopt($ch_broadcast, CURLOPT_RETURNTRANSFER,1);
							curl_setopt($ch_broadcast,CURLOPT_POST, count($fields_broadcast));
							curl_setopt($ch_broadcast, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$twitterAccesstoken,'Content-Type: application/json'));
							curl_setopt($ch_broadcast,CURLOPT_POSTFIELDS, json_encode($fields_broadcast));
							$result_broadcast = curl_exec($ch_broadcast);
							$httpcode_broadcast = curl_getinfo($ch_broadcast, CURLINFO_HTTP_CODE);
							curl_close($ch_broadcast);

							$broadcastArray = json_decode($result_broadcast,TRUE);


							if($httpcode_broadcast == 200 && sizeof($broadcastArray) > 0 && array_key_exists("broadcast",$broadcastArray) == TRUE)
							{
								$userData['broadcast_id'] = $broadcastArray["broadcast"]["id"];
								$userData['livstreamid'] = $broadcastArray['encoder']['stream_key'];
								$userData['fbuserid'] = $twitterData['twitter_id'];
								$userData['fbusername'] = $twitterData['username'];
								$userData['page_id'] = $twitterData['id'];
								$userData['pagename'] = $twitterData['display_name'];
								$userData['token'] = $refreshToken;

								$URL_broadCast_publish = "https://api.pscp.tv/v1/broadcast/publish";
								$fields_broadcast_publish = array(
									"broadcast_id"=>$broadcastArray["broadcast"]["id"],"title"=>$cleanData["title"],"should_not_tweet"=>FALSE,"enable_super_hearts"=>TRUE
								);
								$ch_broadcast_publish = curl_init();
								curl_setopt($ch_broadcast_publish,CURLOPT_URL, $URL_broadCast_publish);
								curl_setopt($ch_broadcast_publish, CURLOPT_RETURNTRANSFER,1);
								curl_setopt($ch_broadcast_publish,CURLOPT_POST, count($fields_broadcast_publish));
								curl_setopt($ch_broadcast_publish, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$twitterAccesstoken,'Content-Type: application/json'));
								curl_setopt($ch_broadcast_publish, CURLOPT_HEADER, true);
								curl_setopt($ch_broadcast_publish,CURLOPT_POSTFIELDS, json_encode($fields_broadcast_publish));
								$result_broadcast_publish = curl_exec($ch_broadcast_publish);
								$httpcode_broadcast_publish = curl_getinfo($ch_broadcast_publish, CURLINFO_HTTP_CODE);
								curl_close($ch_broadcast_publish);
								$settings = array(
							        'oauth_access_token' => "3307449300-QCsWeN3Iy8cVQ8pOlrW9ug9ZA5TTJZsXZdi2X7L",
							        'oauth_access_token_secret' => "prN3ksFzd79EpXcS1chxerYVfsQc4btf4gnu8SriCA5Fu",
							        'consumer_key' => "RXXsXk44Hv8HsPILWIfQ1mnUk",
							        'consumer_secret' => "xgRmRMTIjzVQ2CporNCBVKaQLofLbpUKguFGp8KkdINBwMVVR7"
							    );
								$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
							    $getfield = '?screen_name='.$twitterData['username'];
							    $requestMethod = 'GET';

							    $twitter = new TwitterAPIExchange($settings);
							    $response = $twitter->setGetfield($getfield)
							        ->buildOauth($url, $requestMethod)
							        ->performRequest();

							    $result_twittes=json_decode($response);
							    if(sizeof($result_twittes)>0)
							    {
									$userData['broadcast_id'] = $result_twittes[0]->id;
								}
							}


							$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.str_replace(" ","+",$apps[0]['application_name']).'/pushpublish/mapentries/'.str_replace(" ","+",$cleanData['target_name']);

							$fields = array(
								'sourceStreamName'=>$stremURL[4],
								'profile'=>"rtmp",
								'host'=>"sg.pscp.tv",
								'streamName'=>$broadcastArray['encoder']['stream_key'],
								"port"=>80,
								"application"=>"x",
								"enabled"=>"false",
								'extraOptions'=>array("destinationName"=>"rtmp")
							);
							break;
							case "twitch":
							if(array_key_exists('twitterCat',$cleanData))
							{
								$gameName = $cleanData['twitterCat'];
							}
							else
							{
								$gameName = "";
							}
							if(array_key_exists('twitterLang',$cleanData))
							{
								$lang = $cleanData['twitterLang'];
							}
							else
							{
								$lang = "en";
							}
							if(array_key_exists('ingestserver',$cleanData))
							{
								$inseg = $cleanData['ingestserver'];
							}
							else
							{
								$inseg = "";
							}
							$stremURL = explode('/',$cleanData['streamurl']);
							$refreshToken =  $this->session->userdata('twitch_access');
							$twitchData =  $this->session->userdata('twitch_data');
							$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.str_replace(" ","+",$apps[0]['application_name']).'/pushpublish/mapentries/'.str_replace(" ","+",$cleanData['target_name']);

							$ur = str_replace("rtmp://","",$inseg);
							$ur = str_replace("/app/{stream_key}","",$ur);
							$userData['fbusername'] = $twitchData['name'];
							$fields = array(
								"sourceStreamName"=>$stremURL[4],
								"profile"=>"rtmp",
								"host"=>$ur,
								"streamName"=>$twitchData["stream_key"],
								"port"=>1935,
								"application"=>"app",
								"enabled"=>"false",
								"extraOptions"=>array("destinationName"=>"rtmp")
							);
							$twitchParams = array(
								'channel'=>array(
									'status'=>$cleanData["title"],
									'game'=>$gameName,
									'channel_feed_enabled'=>TRUE
								)
							);
				            $ch = curl_init();
				            curl_setopt($ch, CURLOPT_URL, "https://api.twitch.tv/kraken/channels/".$twitchData["_id"]);
				            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
				            curl_setopt($ch, CURLOPT_POST, 1);
				            $fieldsParam = array('channel[status]' =>trim($cleanData["title"]), 'channel[game]' =>trim($gameName),'channel_feed_enabled=true'=>TRUE,'description'=>trim($cleanData["description"]));
				            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fieldsParam));
				            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Client-ID: kz30uug3w8b73asx3qe2q1yt98al5r','Accept: application/vnd.twitchtv.v5+json','Authorization: OAuth '.$refreshToken));
				            $output = curl_exec($ch);
				            $response = json_decode($output, true);
				            curl_close($ch);
							break;
							case "rtmp":
							if(array_key_exists('rtmp_stream_url',$cleanData))
							{
								$streamURL = $cleanData['rtmp_stream_url'];
							}
							else
							{
								$streamURL = "";
							}
							if(array_key_exists('rtmp_stream_key',$cleanData))
							{
								$streamKey = $cleanData['rtmp_stream_key'];
							}
							else
							{
								$streamKey = "";
							}
							$isAuth = 0;$uname = "";$pass="";
							if(array_key_exists('target_auth',$cleanData))
							{
								$isAuth = 1;

							}
							if(array_key_exists('target_auth_uname',$cleanData))
							{
								$uname = $cleanData["target_auth_uname"];

							}
							if(array_key_exists('target_auth_pass',$cleanData))
							{
								$pass = $cleanData["target_auth_pass"];

							}
							$userData['rtmp_stream_url'] = $streamURL;
							$userData['rtmp_stream_key'] = $streamKey;
							$userData['target_auth'] = $isAuth;
							$userData['target_auth_uname'] = $uname;
							$userData['target_auth_pass'] = $pass;
							$stremURL = explode('/',$cleanData['streamurl']);
							$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.str_replace(" ","+",$apps[0]['application_name']).'/pushpublish/mapentries/'.str_replace(" ","+",$cleanData['target_name']);
							$RTMPURL = explode('/',$cleanData['rtmp_stream_url']);
							$RtmpAr = explode(':',$RTMPURL[2]);

							$fields = array(
								"sourceStreamName"=>$stremURL[4],
								"profile"=>"rtmp",
								"host"=>$RtmpAr[0],
								"streamName"=>$cleanData['rtmp_stream_key'],
								"port"=>$RtmpAr[1],
								"sendSSL"=>"true",
								"userName"=>$uname,
								"password"=>$pass,
								"application"=>$RTMPURL[3],
								"enabled"=>"false",
								"extraOptions"=>array("destinationName"=>"rtmp")
							);
							break;
						}
					}

					$ch = curl_init();
					curl_setopt($ch,CURLOPT_URL, $url);
					curl_setopt($ch,CURLOPT_POST, count($fields));
					curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
					$result = curl_exec($ch);
					$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					curl_close($ch);



					$id = $this->common_model->insertTarget($userData);

					if($id > 0)
					{
						if($cleanData['enableTargetSchedule'] != "")
						{
							$processname = $id.'_'.$this->random_string(10);
							$startname = "Target_Start_".$processname.".sh";
							$stopname = "Target_Stop_".$processname.".sh";
							$starttime = $this->getDateTime($cleanData['start_date']);
							$stoptime = $this->getDateTime($cleanData['end_date']);
							$startfile =  $starttime["m"].' '.$starttime["h"].' '.$starttime["day"].' '.$starttime["month"].' * /home/ksm/scheduler/'.$startname;
							$stopfile = $stoptime["m"].' '.$stoptime["h"].' '.$stoptime["day"].' '.$stoptime["month"].' * /home/ksm/scheduler/'.$stopname;
							$type = $socialLogin;
							$dataS = array(
								'schedule_type'=>'target',
								'type'=>$type,
								'sid'=>$id,
								'start_datetime'=>$cleanData['start_date'],
								'end_datetime'=>$cleanData['end_date'],
								'status'=>1,
								'created'=>time(),
								'start_job'=>$startfile,
								'stop_job'=>$stopfile,
								'start_filename'=>$startname,
								'stop_filename'=>$stopname,
								'uid'=>$userdata['userid']
							);
							$this->common_model->insertSchedule($dataS);

							$is_scheduled = $cleanData['enableTargetSchedule'];
							$ip = $this->config->item('ServerIP');
							$username = $this->config->item('ServerUser');
							$password = $this->config->item('ServerPassword');
							$port = '22';
							$ssh = new Net_SSH2($ip);
							if ($ssh->login($username, $password,$port)) {


								$ssh->exec("touch /home/ksm/scheduler/".$startname);
								$ssh->exec("chmod +x /home/ksm/scheduler/".$startname);
								$ssh->exec('echo "curl -k -H  \'Content-Type: application/json\'  --data \'{\"process\":\"'.$processname.'\"}\'  https://iohub.tv/api/startTarget >> /home/ksm/scheduler/scheduler.log" >>  /home/ksm/scheduler/'.$startname);
								$ssh->exec('echo "echo \"\n----------------------------------------------\n\" >> /home/ksm/scheduler/scheduler.log" >>  /home/ksm/scheduler/'.$startname);

								$ssh->exec("touch /home/ksm/scheduler/".$stopname);
								$ssh->exec("chmod +x /home/ksm/scheduler/".$stopname);
								$ssh->exec('echo "curl -k -H  \'Content-Type: application/json\'  --data \'{\"process\":\"'.$processname.'\"}\'  https://iohub.tv/api/StopTarget >> /home/ksm/scheduler/scheduler.log" >>  /home/ksm/scheduler/'.$stopname);
								$ssh->exec('echo "echo \"\n----------------------------------------------\n\" >> /home/ksm/scheduler/scheduler.log" >>  /home/ksm/scheduler/'.$stopname);

								$ssh->exec('(crontab -l; echo "'.$starttime["m"].' '.$starttime["h"].' '.$starttime["day"].' '.$starttime["month"].' * /home/ksm/scheduler/'.$startname.'") | crontab -');
								$ssh->exec('(crontab -l; echo "'.$stoptime["m"].' '.$stoptime["h"].' '.$stoptime["day"].' '.$stoptime["month"].' * /home/ksm/scheduler/'.$stopname.'") | crontab -');

							}
						}

						$this->session->unset_userdata('fb_token');
						$this->session->unset_userdata('rtmpData');
						$this->session->unset_userdata('fbUser');
						$this->session->unset_userdata('twitter_access');
						$this->session->unset_userdata('socialLogin');
						$this->session->unset_userdata('youtubeData');
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', "Target Created Successfully");
						$this->session->set_flashdata('tab', 'Target');
						redirect('admin/applications');

					}
					else
					{
						$this->session->unset_userdata('fb_token');
						$this->session->unset_userdata('rtmpData');
						$this->session->unset_userdata('fbUser');
						$this->session->unset_userdata('twitter_access');
						$this->session->unset_userdata('socialLogin');$this->session->unset_userdata('youtubeData');
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error occur while creating Target!');

						redirect('admin/createtarget');
					}
				}
			}
			catch(Exception $e)
			{
				$this->session->unset_userdata('fb_token');
				$this->session->unset_userdata('rtmpData');
				$this->session->unset_userdata('fbUser');
				$this->session->unset_userdata('socialLogin');
				$this->session->unset_userdata('youtubeData');
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', $e->getMessage());
				redirect('applications');
			}
		}
		public function updateApplication()
		{
			try
			{
				$permissions = $this->session->userdata('user_permissions');
				if($permissions['edit_application'] <= 0)
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'You are not authorized to update Applications.');
					redirect('clients');
				}
				elseif($permissions['edit_application'] == "1")
				{
					$userdata = $this->session->userdata('user_data');
					$this->form_validation->set_rules('application_name', 'Application Name', 'required');
					$this->form_validation->set_rules('live_source', 'Live Source', 'required');
					$post     = $this->input->post();
					$id = $this->uri->segment(3);
					$actual_link =  $_SERVER['HTTP_REFERER'];
					$clean   = $this->security->xss_clean($this->input->post(NULL, TRUE));
					if ($this->form_validation->run() == FALSE)
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', validation_errors());
						redirect($actual_link);
					}
					else
					{
						$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
						$userData = array(
	                	'application_name'=>$cleanData['application_name'],
	                	'live_source'=>$cleanData['live_source'],
	                	'wowza_path'=>$cleanData['wowza_path'],
	                	'created'=>time(),
	                	'status'=>1,
	                	'uid'=>$userdata['userid']
						);

						$id = $this->common_model->updateApplication($id,$userData);
						if($id >= 0)
						{
							$this->session->set_flashdata('message_type', 'success');
							$this->session->set_flashdata('success', 'App Updated Successfully!');
							redirect('admin/applications');
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'Error occur while updating Application!');
							redirect('admin/applications');
						}
					}
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while updating Applicaiton!');
				redirect('admin/applications');
			}
		}
		public function saveCreateVod()
		{
			try
			{
				$userdata = $this->session->userdata('user_data');
				$this->form_validation->set_rules('application_name', 'Application Name', 'required');
				$this->form_validation->set_rules('live_source', 'Live Source', 'required');
				$post     = $this->input->post();
				$actual_link =  $_SERVER['HTTP_REFERER'];
				$clean   = $this->security->xss_clean($this->input->post(NULL, TRUE));
				if ($this->form_validation->run() == FALSE)
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', validation_errors());
					redirect($actual_link);
				}
				else
				{
					$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
					$groupid = 0;
					if($userdata['user_type'] == 1)
					{
						$groupid = 0;
					}
					else
					{
						$groupid = $userdata['group_id'];
					}

					$userData = array(
                	'application_name'=>$cleanData['application_name'],
                	'live_source'=>$cleanData['live_source'],
                	'wowza_path'=>$cleanData['wowza_path'],
                	'created'=>time(),
                	'group_id'=>$groupid,
                	'status'=>1,
                	'uid'=>$userdata['userid']
					);
					$wowza = $this->common_model->getWovzData($cleanData['live_source']);


					$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.$cleanData['application_name'];

			 		$headers = array("Content-type: application/json");
					$fields = array(
					'restURI'=>'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.$cleanData['application_name'],
					'name'=>$cleanData['application_name'],
					"appType"=>"Live",
					"clientStreamReadAccess"=>"*",
   					"clientStreamWriteAccess"=>"*",
   					"description"=>"Live Streaming application created by iohub Live",
   					"streamConfig"=>array(
   							"restURI"=>'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/$app_name/streamconfiguration',
   							"streamType"=>"live"
   						)
					);
					$ch = curl_init();
					curl_setopt($ch,CURLOPT_URL, $url);
					curl_setopt($ch,CURLOPT_POST, 1);
					curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
					$result = curl_exec($ch);
					$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					if($httpcode == 200 || $httpcode == 201)
					{
						$url_second = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.$cleanData['application_name'].'/adv';
				 		$headers = array("Content-type: application/json");
						$fields_second = array(
						   "restURI"=>'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.$cleanData['application_name'].'/adv',
						   "modules"=>array(array(
						       "order"=>0,
						       "name"=>"base",
						       "description"=>"Base",
						       "class"=>"com.wowza.wms.module.ModuleCore"
						   ), array(
						       "order"=>0,
						       "name"=>"logging",
						       "description"=>"Client Logging",
						       "class"=>"com.wowza.wms.module.ModuleClientLogging"
						   ), array(
						       "order"=>0,
						       "name"=>"flvplayback",
						       "description"=>"FLVPlayback",
						       "class"=>"com.wowza.wms.module.ModuleFLVPlayback"
						   ), array(
						       "order"=>0,
						       "name"=>"ModulePushPublish",
						       "description"=>"Module Push Publish",
						       "class"=>"com.wowza.wms.pushpublish.module.ModulePushPublish"
						   )),
						   "advancedSettings"=>array(array(
						       "enabled"=>true,
						       "canRemove"=>false,
						       "name"=>"pushPublishMapPath",
						       "value"=>'${com.wowza.wms.context.VHostConfigHome}/conf/${com.wowza.wms.context.Application}/PushPublishMap.txt',
						       "defaultValue"=>null,
						       "type"=>"String",
						       "sectionName"=>"Application",
						       "section"=>"/Root/Application",
						       "documented"=>false
						   ))
						);
						$ch_sec = curl_init();
						curl_setopt($ch_sec,CURLOPT_URL, $url_second);
						curl_setopt($ch_sec,CURLOPT_POST, 1);
						curl_setopt($ch_sec,CURLOPT_POSTFIELDS, json_encode($fields_second));
						curl_setopt($ch_sec, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch_sec, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
						$result_second = curl_exec($ch_sec);
						$httpcode1 = curl_getinfo($ch_sec, CURLINFO_HTTP_CODE);
						curl_close($ch_sec);
						if($httpcode1 == 200 || $httpcode1 == 201)
						{
							$id = $this->common_model->insertCreateVod($userData);
							if($id > 0)
							{
								$this->session->set_flashdata('message_type', 'success');
								$this->session->set_flashdata('success', 'Application Created Successfully!');
								$this->session->set_flashdata('tab', 'Application');
								redirect('applications');

							}
							else
							{
								$this->session->set_flashdata('message_type', 'error');
								$this->session->set_flashdata('error', 'Error occur while creating Application!');
								redirect('applications');
							}
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'Error occur while creating Application!');
							redirect('applications');
						}
					}
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while creating Application!');
				redirect('applications');
			}
		}

		public function getIPAdressByWowaz()
		{
			$response = array('status'=> FALSE,'data'=>array());
			$ip_id = $this->input->post('id');
			$districts = $this->common_model->getBlockByDistricts($ip_id);
			if(sizeof($districts)>0)
			{
				$response['status'] = TRUE;
				$response['data'] = $districts;
			}
			echo json_encode($response);
		}
		public function getApplicationStreams()
		{
			$response = array('status'=> FALSE,'data'=>array());
			$ip_id = $this->input->post('id');
			$apps = $this->common_model->getApplicationStreams($ip_id);
			$wid = $apps[0]['live_source'];
			$wowza = $this->common_model->getWovzData($wid);
			if(sizeof($wowza)>0)
			{

				$path = explode("/",$apps[0]['wowza_path']);
				$response['status'] = TRUE;
				$response['data'] = 'rtmp://'.$wowza[0]['ip_address'].':'.$wowza[0]['rtmp_port'].'/'.$apps[0]['application_name'].'/'.$path[sizeof($path)-1];
			}
			echo json_encode($response);
		}
		public function updategroup()
		{
			$this->breadcrumbs->push('Clients/Edit Group', '/clients');
			$segment = $this->uri->segment(2);
			$data['groupdata'] = $this->common_model->getGroupInfobyId($segment);
			$this->load->view('admin/header');
			$this->load->view('admin/editgroup',$data);
			$this->load->view('admin/footer');
		}
		public function updateUserdetails()
		{
			try
			{
				$this->form_validation->set_rules('phone', 'Phone Number', 'required');
				$this->form_validation->set_rules('email_id', 'Email Id', 'required|valid_email');
				$this->form_validation->set_rules('fname', 'First Name', 'required');
				$this->form_validation->set_rules('lname', 'Last Name', 'required');
				$this->form_validation->set_rules('timezone', 'Time Zone', 'required');
				$this->form_validation->set_rules('timeformat', 'Time Format', 'required');
				$post     = $this->input->post();
				$actual_link =  $_SERVER['HTTP_REFERER'];
				$clean   = $this->security->xss_clean($this->input->post(NULL, TRUE));
				if ($this->form_validation->run() == FALSE) {
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', validation_errors());
					redirect($actual_link);
				}
				else
				{
					$id = $clean['id'];
					$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
	            	$notify =0 ;$theme=0;
	            	if(array_key_exists('group_notification',$cleanData) && $cleanData['group_notification'] == "on")
	            	{
						$notify=1;
					}
					if(array_key_exists('group_theme',$cleanData) && $cleanData['group_theme'] == "on")
	            	{
						$theme=1;
					}
	                $userData = array(
						'fname'=>$cleanData['fname'],
						'lname'=>$cleanData['lname'],
						'email_id'=>$cleanData['email_id'],
						'timezone'=>$cleanData['timezone'],
						'timeformat'=>$cleanData['timeformat'],
						'phone'=>$cleanData['phone'],
						'group_notification'=>$notify,
						'theme'=>$theme,
						'group_id'=>$cleanData['group_id'],
						'password'=>sha1($cleanData['password']),
						'role_id'=>$cleanData['role_id'],
						'created'=>time()
	                );
					$this->common_model->updateUsersInfo($userData,$id);
					$files = $_FILES['groupfile'];
					if(isset($files['name']) && $files['name'] != "")
					{
					 	$files = $_FILES['groupfile'];
						$userId = $id;
						/*******File Content Check**********/
						$fnmae = $_FILES['groupfile']['name'];
						$typpe = $_FILES['groupfile']['type'];
						if($files["name"] != "")
						{
							$name = str_replace(" ","_",$files['name']);
							$imgname = time().'_'.$name;

							$target_file = 'public/site/main/group_pics/'.$imgname;
							if (move_uploaded_file($_FILES["groupfile"]["tmp_name"], $target_file)) {
								if($this->common_model->uploadUserProfilePic($imgname,$userId))
								{
									$this->session->set_flashdata('message_type', 'success');
									$this->session->set_flashdata('success', 'User Updated Successfully!');
									redirect('clients');
								}
							}
						}
					}
					else
					{
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'User update successfully');
						redirect('clients');
					}

				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occured While Creating User!');
				redirect('admin/createuser');
			}
		}
		public function updatesUsersdetails()
		{
			try
			{
				$this->form_validation->set_rules('phone', 'Phone Number', 'required');
				$this->form_validation->set_rules('email_id', 'Email Id', 'required|valid_email');
				$this->form_validation->set_rules('fname', 'First Name', 'required');
				$this->form_validation->set_rules('lname', 'Last Name', 'required');
				$this->form_validation->set_rules('timezone', 'Time Zone', 'required');
				$this->form_validation->set_rules('timeformat', 'Time Format', 'required');
				$post     = $this->input->post();
				$actual_link =  $_SERVER['HTTP_REFERER'];
				$clean   = $this->security->xss_clean($this->input->post(NULL, TRUE));
				if ($this->form_validation->run() == FALSE) {
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', validation_errors());
					redirect($actual_link);
				}
				else
				{
					$id = $clean['id'];
					$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
	            	$notify =0 ;$theme=0;
	            	if(array_key_exists('group_notification',$cleanData) && $cleanData['group_notification'] == "on")
	            	{
						$notify=1;
					}
					if(array_key_exists('group_theme',$cleanData) && $cleanData['group_theme'] == "on")
	            	{
						$theme=1;
					}
	                $userData = array(
						'fname'=>$cleanData['fname'],
						'lname'=>$cleanData['lname'],
						'email_id'=>$cleanData['email_id'],
						'timezone'=>$cleanData['timezone'],
						'timeformat'=>$cleanData['timeformat'],
						'phone'=>$cleanData['phone'],
						'group_notification'=>$notify,
						'theme'=>$theme,
						'password'=>sha1($cleanData['password']),
						//'role_id'=>$cleanData['role_id'],
						'created'=>time()
	                );

					$this->common_model->updateUsersInfo($userData,$id);
					if($_FILES['groupfile']['name'] != "")
					{
					 	$files = $_FILES['groupfile'];
						/*******File Content Check**********/
						$fnmae = $_FILES['groupfile']['name'];
						$typpe = $_FILES['groupfile']['type'];
						$tempfile = $_FILES['groupfile']['tmp_name'];
						$sizekbb = filesize($tempfile); //10485760= 10mb
						$head = fgets(fopen($tempfile, "r"), 5);
						$section = strtoupper(base64_encode(file_get_contents($tempfile)));
						$nsection = substr($section, 0, 8);

						$frst = strpos($fnmae, ".");
						$sec = strrpos($fnmae, ".");
						$handle = fopen($tempfile, "rb");
						$fsize = filesize($tempfile);
						$contents = fread($handle, $fsize);


						if($files["name"] != "")
						{
							$name = str_replace(" ","_",$files['name']);
							$imgname = time().'_'.$name;

							$target_file = 'public/site/main/group_pics/'.$imgname;
							if (move_uploaded_file($_FILES["groupfile"]["tmp_name"], $target_file)) {
								if($this->common_model->uploadUserProfilePic($imgname,$id))
								{
									$this->session->set_flashdata('message_type', 'success');
									$this->session->set_flashdata('success', 'User Updated Successfully!');
									redirect('admin/profile/'.$clean['group_id']);
								}
							}
						}
					}
					else
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error occur while updloading User image!');
						redirect('admin/profile');
					}
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occured While Creating User!');
				redirect('admin/createuser');
			}
		}
		public function updateuser()
		{
			$this->breadcrumbs->push('Clients/Edit User', '/clients');
			$segment = $this->uri->segment(2);
			$data['groupuser'] = $this->common_model->getAdminDataUserbyId($segment);
			$user_data = $this->session->userdata('user_data');
			if($user_data['user_type'] == 1)
			{
				$data['roles'] = array('1'=>'Admin','2'=>'Group Admin','3'=>'User');
				$data['groups'] = $this->common_model->getGroups(0);
			}
			else
			{
				if($user_data['user_type'] == 2)
				{
					$data['roles'] = array('2'=>'Group Admin','3'=>'User');
				}
				elseif($user_data['user_type'] == 3)
				{
					$data['roles'] = array('3'=>'User');
				}
				$data['groups'] = $this->common_model->getGroupInfobyId($user_data['group_id']);
			}

			$this->load->view('admin/header');
			$this->load->view('admin/edituser',$data);
			$this->load->view('admin/footer');
		}
		public function updateusers()
		{
			$segment = $this->uri->segment(3);
			$data['groupuser'] = $this->common_model->getAdminDataUserbyId($segment);
			$data['groups'] = $this->common_model->getGroups();
			$this->load->view('admin/header');
			$this->load->view('admin/editusers',$data);
			$this->load->view('admin/footer');
		}

		public function updateGroupDetails()
		{
			$permissions = $this->session->userdata('user_permissions');
			if($permissions['edit_group'] <= 0)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'You are not authorized to update Groups.');
				redirect('clients');
			}
			elseif($permissions['edit_group'] == "1")
			{
				$group_id = $this->uri->segment(3);
				$this->form_validation->set_rules('group_name', 'Group Name', 'required');
				$this->form_validation->set_rules('group_email', 'Group Email', 'required');
				$this->form_validation->set_rules('group_website', 'Group Website', 'required');
				$this->form_validation->set_rules('group_phone', 'Phone Number', 'required');
				$this->form_validation->set_rules('group_address', 'Address', 'required');
				$this->form_validation->set_rules('group_postal_code', 'Postal Code', 'required');
				$this->form_validation->set_rules('group_city', 'City', 'required');
				$this->form_validation->set_rules('group_country', 'Country', 'required');



				$clean   = $this->security->xss_clean($this->input->post(NULL, TRUE));
				if(array_key_exists('group_notification',$clean) && $clean['group_notification'] == "on")
				{
					$groupnotification = 1;
				}
				else
				{
					$groupnotification = 0;
				}
				$updateGroup = array(
				'group_name'=>$clean['group_name'],
				'group_website'=>$clean['group_website'],
				'group_email'=>$clean['group_email'],
				'group_phone'=>$clean['group_phone'],
				'group_address'=>$clean['group_address'],
				'group_postal_code'=>$clean['group_postal_code'],
				'group_city'=>$clean['group_city'],
				'group_country'=>$clean['group_country'],
				'group_licence'=>$clean['group_licence'],
				'group_notification'=>$groupnotification
				);

				$status = $this->common_model->updateGroupInfo($updateGroup,$group_id);
				$files = $_FILES['groupfile'];
				$userId = $id;
				if($files["name"] != "")
				{
					$name = str_replace(" ","_",$files['name']);
					$imgname = time().'_'.$name;

					$target_file = 'public/site/main/group_pics/'.$imgname;
					if (move_uploaded_file($_FILES["groupfile"]["tmp_name"], $target_file))
					{
						$img = $this->common_model->getGgoupImage($group_id);
						if(sizeof($img)>0)
						{
							$this->common_model->uploadProfilePic($imgname,$group_id);
						}
						else
						{
							$data = array(
								'name'=>$imgname,
								'created'=>date('y-m-d h:i:s a'),
								'status'=>1,
								'gid'=>$group_id
					        );
							$this->common_model->insertGroupImage($data);
						}

						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Group updated Successfully!');
						redirect('admin/clients');

					}
				}
				if($status>=0)
				{
					$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'Group Updated Successfully!');
					redirect('admin/clients');
				}
			}

		}
		public function updateUsersDetails()
		{
			$user_id = $this->uri->segment(3);
			$this->form_validation->set_rules('phone', 'Phone Number', 'required');
			$this->form_validation->set_rules('email_id', 'Email Id', 'required|valid_email');
			$this->form_validation->set_rules('fname', 'First Name', 'required');
			$this->form_validation->set_rules('lname', 'Last Name', 'required');
			$this->form_validation->set_rules('timezone', 'Time Zone', 'required');
			$this->form_validation->set_rules('timeformat', 'Time Format', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('passwordagain', 'Confirm Password', 'required');
			$this->form_validation->set_rules('group_notification', 'Notification', 'required');
			$this->form_validation->set_rules('theme', 'Group Theme', 'required');

			$clean   = $this->security->xss_clean($this->input->post(NULL, TRUE));
			if(array_key_exists('group_notification',$clean) && $clean['group_notification'] == "on")
			{
				$groupnotification = 1;
			}
			else
			{
				$groupnotification = 0;
			}
			if(array_key_exists('theme',$clean) && $clean['theme'] == "on")
			{
				$grouptheme = 1;
			}
			else
			{
				$grouptheme = 0;
			}
			$updateGroup = array(
				'fname'=>$clean['fname'],
				'lname'=>$clean['lname'],
				'email_id'=>$clean['email_id'],
				'timezone'=>$clean['timezone'],
				'timeformat'=>$clean['timeformat'],
				'phone'=>$clean['phone'],
				'group_notification'=>$groupnotification,
				'theme'=>$grouptheme,
				'group_id'=>$clean['group_id'],
				'password'=>sha1($clean['password']),
				'role_id'=>$clean['role_id'],
				'created'=>time()
			);

			$status = $this->common_model->updateUsersInfo($updateGroup,$user_id);
			$files = $_FILES['groupfile'];
			$userId = $id;
			/*******File Content Check**********/
			$fnmae = $_FILES['groupfile']['name'];
			$typpe = $_FILES['groupfile']['type'];
			$tempfile = $_FILES['groupfile']['tmp_name'];
			$sizekbb = filesize($tempfile); //10485760= 10mb
			$contents = fread($handle, $fsize);


			if($files["name"] != "")
			{
				$name = str_replace(" ","_",$files['name']);
				$imgname = time().'_'.$name;

				$target_file = 'public/site/main/group_pics/'.$imgname;
				if (move_uploaded_file($_FILES["groupfile"]["tmp_name"], $target_file))
				{
					$this->common_model->uploadProfilePic($imgname,$group_id);
					$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'User Image Created Successfully!');
					redirect('admin/clients');

				}
			}
			if($status>=0)
			{
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'Group Image Created Successfully!');
				redirect('admin/clients');
			}
		}
		public function allgroupuser()
		{
			$group_id = $this->uri->segment(2);
			$data['groups'] = $this->common_model->getGroups();
			$gids = array();
			$groups = $this->common_model->getGroupInfobyId($group_id);
			if(sizeof($groups)>0)
			{
				foreach($groups as $group)
				{
					array_push($gids,$group['id']);
				}
				$data['groupsUsers'] = $this->common_model->getUsersByGroupIds($gids);
			}
			else
			{
				$data['groupsUsers'] = array();
			}
			$this->load->view('admin/header');
			$this->load->view('admin/groupusers',$data);
			$this->load->view('admin/footer');
		}
		public function groupActions()
		{
			$sts = FALSE;
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$ids = $cleanData['id'];
			$action = $cleanData['action'];
			switch($action)
			{
				case "Block":
				if(!empty($ids)){
					foreach($ids as $id){
						$data = array(
							'status'=>0
						);
						$sts = $this->common_model->updateGroupInfo($data,$id);
						if($sts>0)
						{
							$response[$id] = array('status'=>TRUE,'response' =>'Blocked Successfully');
						}
						else
						{
							$response[$id] = array('status'=>FALSE,'response' =>'Error Cccured While updating group.');
						}
					}
				}
				break;
				case "UnBlock":
				if(!empty($ids)){
					foreach($ids as $id){
						$data = array(
							'status'=>1
						);
						$sts = $this->common_model->updateGroupInfo($data,$id);
						if($sts>0)
						{
							$response[$id] = array('status'=>TRUE,'response' =>'Un-Blocked Successfully');
						}
						else
						{
							$response[$id] = array('status'=>FALSE,'response' =>'Error Cccured While updating group.');
						}
					}
				}
				break;
				case "Delete":
				if(!empty($ids)){
				foreach($ids as $id){
						$sts = $this->common_model->deleteGroups($id);
						if($sts>0)
						{
							$response[$id] = array('status'=>TRUE,'response' =>'Deleted Successfully');
						}
						else
						{
							$response[$id] = array('status'=>FALSE,'response' =>'Error Cccured While updating group.');
						}
					}
				}
				break;
			}
			echo json_encode($response);
		}
		public function userActions()
		{
			$sts = FALSE;
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$ids = $cleanData['id'];
			$action = $cleanData['action'];
			switch($action)
			{
				case "Block":
				if(!empty($ids)){
					foreach($ids as $id){
						$data = array(
							'status'=>0
						);
						$sts = $this->common_model->update_user($data,$id);
						if($sts)
						{
							$response[$id] = array('status'=>TRUE,'response' =>'Blocked Successfully');
						}
						else
						{
							$response[$id] = array('status'=>FALSE,'response' =>'Error Occured While updating group.');
						}
					}
				}
				break;
				case "UnBlock":
				if(!empty($ids)){
					foreach($ids as $id){
						$data = array(
							'status'=>1
						);
						$sts = $this->common_model->update_user($data,$id);
						if($sts)
						{
							$response[$id] = array('status'=>TRUE,'response' =>'Un-Blocked Successfully');
						}
						else
						{
							$response[$id] = array('status'=>FALSE,'response' =>'Error Cccured While updating group.');
						}
					}
				}
				break;
				case "Delete":
				if(!empty($ids)){
					foreach($ids as $id){
						$sts = $this->common_model->deleteUsers($id);
						if($sts>0)
						{
							$response[$id] = array('status'=>TRUE,'response' =>'Deleted Successfully');
						}
						else
						{
							$response[$id] = array('status'=>FALSE,'response' =>'Error Cccured While updating group.');
						}
					}
				}
				break;
			}
			echo json_encode($response);
		}
		public function targetActions()
		{
			$sts = FALSE;
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$targetIDs = $cleanData['id'];
			$action = $cleanData['action'];
			switch($action){
				case "Start":
					if(sizeof($targetIDs)>0)
					{
						foreach($targetIDs as $ID)
						{
							$target = $this->common_model->getTargetbyId($ID);
							$streamULR = $target[0]['streamurl'];
							$streamURL = explode('/',$streamULR);
							$application = $this->common_model->getAppbyId($target[0]['wowzaengin']);
							$wowza = $this->common_model->getWovzData($application[0]['live_source']);

							$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.str_replace(" ","+",$application[0]['application_name']).'/pushpublish/mapentries/'.str_replace(" ","+",$target[0]['target_name']).'/actions/enable';

							$fields = array(
								'app_name' =>$application[0]['application_name'],
								'target_name'=>array($target[0]['target_name'])
							);

							$result=shell_exec("curl -X put ".$url);


							$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.$application[0]['application_name'].'/pushpublish/mapentries';

							$xmlData = file_get_contents($url);
							$xml = simplexml_load_string($xmlData);
							$MapEntries = json_encode($xml);
							$mapEntriesArray = json_decode($MapEntries,TRUE);
							$status="";
							$elem = new SimpleXMLElement($xmlData);
							$mapEntiresCount = $elem->MapEntries->count();

							if(array_key_exists('MapEntries',$mapEntriesArray))
							{
								if($mapEntiresCount > 1)
								{
									foreach($mapEntriesArray['MapEntries'] as $key=>$targetData)
									{
										if($targetData['EntryName'] == $target[0]['target_name'])
										{
											$response['status'] = TRUE;
											$response['code'] = "200";
										}
									}
								}
								else
								{
									$targetData = $mapEntriesArray['MapEntries'];
									if($targetData['EntryName'] == $target[0]['target_name'])
									{
										$response['status'] = TRUE;
										$response['code'] = "200";
									}
								}
							}
							else
							{
								$response['status'] = FALSE;
								$response['response'] = '404';
							}
						}
					}
				break;
				case "Stop":
					if(sizeof($targetIDs)>0)
					{
						foreach($targetIDs as $ID)
						{
							$target = $this->common_model->getTargetbyId($ID);
							$streamULR = $target[0]['streamurl'];
							$streamURL = explode('/',$streamULR);
							$application = $this->common_model->getAppbyId($target[0]['wowzaengin']);
							$wowza = $this->common_model->getWovzData($application[0]['live_source']);
							$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.str_replace(" ","+",$application[0]['application_name']).'/pushpublish/mapentries/'.str_replace(" ","+",$target[0]['target_name']).'/actions/disable';

							$fields = array(
								'app_name' =>$application[0]['application_name'],
								'target_name'=>array($target[0]['target_name'])
							);

							$result=shell_exec("curl -X put ".$url);


							$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.$application[0]['application_name'].'/pushpublish/mapentries';

							$xmlData = file_get_contents($url);
							$xml = simplexml_load_string($xmlData);
							$MapEntries = json_encode($xml);
							$mapEntriesArray = json_decode($MapEntries,TRUE);
							$status="";
							$elem = new SimpleXMLElement($xmlData);
							$mapEntiresCount = $elem->MapEntries->count();
							if(array_key_exists('MapEntries',$mapEntriesArray))
							{
								if($mapEntiresCount > 1)
								{
									foreach($mapEntriesArray['MapEntries'] as $key=>$targetData)
									{
										if($targetData['EntryName'] == $target[0]['target_name'])
										{
											$response['status'] = TRUE;
											$response['code'] = "200";
										}
									}
								}
								else
								{
									$targetData = $mapEntriesArray['MapEntries'];
									if($targetData['EntryName'] == $target[0]['target_name'])
									{
										$response['status'] = TRUE;
										$response['code'] = "200";
									}
								}
							}
							else
							{
								$response['status'] = FALSE;
								$response['response'] = '404';
							}
						}
					}
				break;
				case "Delete":
					if(sizeof($targetIDs)>0)
					{
						foreach($targetIDs as $ID)
						{

							$target = $this->common_model->getTargetbyId($ID);
							$application = $this->common_model->getAppbyId($target[0]['wowzaengin']);
							$wowza = $this->common_model->getWovzData($application[0]['live_source']);
							$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.str_replace(" ","+",$application[0]['application_name']).'/pushpublish/mapentries/'.str_replace(" ","+",$target[0]['target_name']);


							$ch = curl_init();
							curl_setopt($ch,CURLOPT_URL, $url);
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
							curl_setopt($ch, CURLOPT_HEADER, false);
							curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
							$result = curl_exec($ch);
							$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
							curl_close($ch);
							$sts = $this->common_model->deleteAdminTarget($ID);
							if($httpcode == 200)
							{
								$response['status'] = TRUE;
								$response['response'] = $action." Successfully!";
								$response['httpcode'] = $httpcode;
							}
							else
							{
								$response['status'] = FALSE;
								$response['response'] = "Error occure while ".$action." targets!";
							}
						}
					}
				break;
				case "Archive":
					if(sizeof($targetIDs)>0)
					{
						foreach($targetIDs as $ID)
						{
							$data = array('status'=>0);
							$sts = $this->common_model->updateTarget($ID,$data);
							if($sts >0 )
							{
								$response['status'] = TRUE;
								$response['response'] = $action." Successfully!";
								$response['httpcode'] = 200;
							}
							else
							{
								$response['status'] = FALSE;
								$response['response'] = "Error occure while ".$action." targets!";
							}
						}
					}
				break;
				case "Restore":
					if(sizeof($targetIDs)>0)
					{
						foreach($targetIDs as $ID)
						{
							$data = array('status'=>1);
							$sts = $this->common_model->updateTarget($ID,$data);
							if($sts >0 )
							{
								$response['status'] = TRUE;
								$response['response'] = $action." Successfully!";
								$response['httpcode'] = 200;
							}
							else
							{
								$response['status'] = FALSE;
								$response['response'] = "Error occure while ".$action." targets!";
							}
						}
					}
				break;
			}
			echo json_encode($response);
		}
		public function appActions()
		{
			$sts = FALSE;
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$appid = $cleanData['id'];
			$action = $cleanData['action'];
			switch($action){
				case "Reboot":
				break;
				case "Reboot":
					if(sizeof($appid)>0)
					{
						foreach($appid as $aid)
						{
							$application = $this->common_model->getAppbyId($aid);
							$wowza = $this->common_model->getWovzData($application[0]['live_source']);
							$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['java_api_port'].'/v1/restartApp/'.$application[0]['application_name'];
							$ch = curl_init();
							curl_setopt($ch,CURLOPT_URL, $url);
							$result = curl_exec($ch);
							$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
							curl_close($ch);
							if($sts)
							{
								$response['response'][$aid] = array('status'=>TRUE,'response'=>"Reboot Successfully!");
							}
							else
							{
								$response['response'][$aid] = array('status'=>FALSE,'response'=>"Error occure while rebooting wowza!");
							}
						}
					}
				break;
				case "Delete":
					if(sizeof($appid)>0)
					{
						foreach($appid as $aid)
						{
							$application = $this->common_model->getAppbyId($aid);
							$this->common_model->deleteTargetsbyAppId($aid);
							$wowza = $this->common_model->getWovzData($application[0]['live_source']);
							$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.$application[0]['application_name'];
							$fields = array(
								'app_name' =>$application[0]['application_name']
							);
							$ch = curl_init();
							curl_setopt($ch,CURLOPT_URL, $url);
							curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
							curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
							curl_setopt($ch, CURLOPT_HEADER, false);
							curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
							$result = curl_exec($ch);
							$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
							curl_close($ch);
							$sts = $this->common_model->deleteApplication($aid);
							if($sts)
							{
								$response['response'][$aid] = array('status'=>TRUE,'response'=>"Deleted Successfully!");
							}
							else
							{
								$response['response'][$aid] = array('status'=>FALSE,'response'=>"Error occure while deleting wowza!");
							}
						}
					}
				break;
				case "Restore":
					if(sizeof($appid)>0)
					{
						foreach($appid as $aid)
						{
							$data = array('status'=>1);
							$sts = $this->common_model->updateApplication($aid,$data);
							if($sts)
							{
								$response['response'][$aid] = array('status'=>TRUE,'response'=>"Restore Successfully!");
							}
							else
							{
								$response['response'][$aid] = array('status'=>FALSE,'response'=>"Error occure while deleting wowza!");
							}
						}
					}
				break;
				case "Archive":
					if(sizeof($appid)>0)
					{
						foreach($appid as $aid)
						{
							$application = $this->common_model->getAppbyId($aid);
							$data = array('status'=>0);
							$this->common_model->updateTargetbyAppID($aid,$data);
							$sts = $this->common_model->updateApplication($aid,$data);
							if($sts)
							{
								$response['response'][$aid] = array('status'=>TRUE,'response'=>"Archive Successfully!");
							}
							else
							{
								$response['response'][$aid] = array('status'=>FALSE,'response'=>"Error occure while deleting wowza!");
							}
						}
					}
				break;
			}
			if($sts)
			{
				$response['status'] = TRUE;
				$response['response'] = $action." Successfully!";
			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = "Error occure while ".$action." apps!";
			}
			echo json_encode($response);
		}

		public function encoderTemplateActions()
		{
			$sts = FALSE;
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$encid = $cleanData['id'];
			$action = $cleanData['action'];

			switch($action){
				case "Enable":
				if(sizeof($encid)>0)
				{
					$response['response']= array();
					foreach($encid as $wid)
					{
						$data = array('status'=>1);
						$sts = $this->common_model->updateTemplate($data,$wid);
					}
				}
				break;
				case "Disable":
				if(sizeof($encid)>0)
				{
					foreach($encid as $wid)
					{
						$data = array('status'=>0);
						$sts = $this->common_model->updateTemplate($data,$wid);
					}
				}
				break;
				case "Delete":
				if(sizeof($encid)>0)
				{
					foreach($encid as $wid)
					{
						$sts = $this->common_model->deleteTemplate($wid);
					}
				}
				break;
			}
			if($sts >0)
			{
				$response['status'] = TRUE;
				$response['response'] = $action." Successfully!";
			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = "Error occure while ".$action." encoding template!";
			}
			echo json_encode($response);
		}
		//Delete Admin Encoders


		public function activateUser()
		{
			$sts = FALSE;
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$wowId = $cleanData['id'];
			$sts = $this->common_model->updateUser($wowId[0]);
			if($sts)
			{
				$response['status'] = TRUE;
				$response['response'] = "Deleted Successfully!";
			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = "Error occure while deleting wowza!";
			}
			echo json_encode($response);
		}
		public function changePasswordSubmit()
		{
			$post= $this->input->post();
			try
			{
				$user_data = $this->session->userdata('user_data');
				if(!empty($user_data)){

					$old_password = $this->input->post('oldpassword');
					$new_passowrd = $this->input->post('newpassword');
					$confirm_password = $this->input->post('confirmpassword');
					$this->form_validation->set_rules('oldpassword', 'Old Password', 'required|trim|xss_clean|strip_tags');
					$this->form_validation->set_rules('newpassword', 'Password', 'required|trim|xss_clean|matches[confirmpassword]|strip_tags');
					$this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|trim|xss_clean|strip_tags');

					if ($this->form_validation->run() == FALSE) {

						$this->session->set_flashdata('error',validation_errors());
						redirect('admin/profile');
					}
					else
					{
						$password = $this->input->post('newpassword');
						$old_passowrd = sha1($this->input->post('oldpassword'));
						$userPass= $this->common_model->checkPass($user_data['email']);
						if($userPass->password !=$old_passowrd){
							$this->session->set_flashdata('error', 'Sorry Password Not Match!');
							redirect('admin/profile');
						}
						else
						{
							$password = $this->input->post('newpassword');
							$newpass = sha1($password);
							$data = array(
								'password'=>$newpass
							);
							$this->common_model->updatePassowrd($user_data['email'],$data);
							$this->session->set_flashdata('success', 'Your Password has been Changed successfully');
							redirect('admin/profile');
						}
					}
				}else{
					redirect('home');
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('warning', 'Internal Server Error. Please Try After Some Time.');
				redirect('admin/profile');
			}
	   }

	   function secondsToWords($seconds)
		{
		    $ret = "";
		    /** get the days **/
		    $days = intval(intval($seconds) / (3600*24));
		    if($days> 0)
		    {
		        $ret .= "$days days ";
		    }
		    /** get the hours **/
		    $hours = (intval($seconds) / 3600) % 24;
		    if($hours > 0)
		    {
		        $ret .= "$hours hours ";
		    }
		    /** get the minutes **/
		    $minutes = (intval($seconds) / 60) % 60;
		    if($minutes > 0)
		    {
		        $ret .= "$minutes minutes ";
		    }
		    /** get the seconds **/
		    $seconds = intval($seconds) % 60;
		    if ($seconds > 0) {
		        $ret .= "$seconds seconds";
		    }
		    return $ret;
		}
}
