<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	require_once 'application/libraries/Facebook/autoload.php';
	require_once 'application/third_party/google/vendor/autoload.php';
	require_once 'application/third_party/phpseclib/Net/SSH2.php';
	class Groupadmin extends CI_Controller {
		
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
			$this->load->helper('url');
			$this->load->helper('form');
			$this->load->helper('security');
			$this->load->library('form_validation');
			$this->load->library('session');	
			$this->load->library('encrypt');
			$this->load->helper('date');   
			$this->load->model('user_model'); 
			$this->load->model('common_model');  
			$userdata = $this->session->userdata('user_data');		
			if(!empty($userdata))
			{
				$roles = $this->config->item('roles_id');
				$role = $roles[$userdata['user_type']];			
				switch($role)
				{
					case "Admin":
					redirect(site_url() . 'admin/dashboard');
					break;	
					case "User":
					redirect(site_url() . 'user/dashboard');
					break;	
					case "Groupadmin":
					redirect(site_url() . 'groupadmin/dashboard');
					break;				
				} 
			}
			else
			{
				redirect(site_url() . 'home');
			}			
		}
		/* Wowza Actions Dropdowns */
		public function wowzaActions()
		{
			$sts = FALSE;
			$response = array('status'=>FALSE,'response'=>array());
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
			//http://$wowzaip:$rest_api_port/v2/servers/_defaultServer_/actions/restart
			$URL = "http://";
			$URL = $URL.$wowzaEngine[0]['ip_address'].":".$wowzaEngine[0]['rest_api_port']."/v2/servers/_defaultServer_/actions/restart";
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
	    	//print_r($result);
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
			$user_data = $this->session->userdata('user_data');
			$data['groups'] = $this->common_model->getGroups($user_data['userid']);
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/createwowza',$data);
			$this->load->view('gadmin/footer');
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
					$imgname ="";

					if($files["name"] != "")
					{
						$name = str_replace(" ","_",$files['name']);
						$imgname = time().'_'.$name;

						$target_file = 'assets/site/main/wowza_logo/'.$imgname;
						if (move_uploaded_file($_FILES["groupfile"]["tmp_name"], $target_file))
						{

						}
					}
					$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
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
                	'group_id'=>$cleanData['group_id'],
                	'wowza_image'=>$imgname,
                	'created'=>time(),
                	'status'=>1,
                	'uid'=>$userdata['userid']
					);

					$id = $this->common_model->insertConfiguration($userData);
					if($id > 0)
					{
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Wowza Engine Added Sucessfully!');
						$this->session->set_flashdata('tab', 'User');
						redirect('groupadmin/configuration');

					}
					else
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error occur while saving Wowza Engine!');
						redirect('groupadmin/configuration');
					}
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while saving Wowza Engine!');
				redirect('groupadmin/configuration');
			}
		}
		/* Wowza Edit Form */
		public function updatewowzaengin()
		{
			$userdata = $this->session->userdata('user_data');
			$segment = $this->uri->segment(3);
			$data['wovzData'] = $this->common_model->getWovzData($segment);
			$data['groups'] = $this->common_model->getGroups($userdata['userid']);
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/editwowza',$data);
			$this->load->view('gadmin/footer');
		}
		/* Wowza Update Existing */
		public function updateConfiguration()
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
				$this->form_validation->set_rules('java_api_port', 'API Port', 'required');
				$this->form_validation->set_rules('rest_api_port', 'API Port', 'required');
				$this->form_validation->set_rules('group_id', 'Group Selection', 'required');
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
					$files = $_FILES['groupfile'];
					$userId = $id;
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
					$imgname ="";

					if($files["name"] != "")
					{
						$name = str_replace(" ","_",$files['name']);
						$imgname = time().'_'.$name;

						$target_file = 'assets/site/main/wowza_logo/'.$imgname;
						if (move_uploaded_file($_FILES["groupfile"]["tmp_name"], $target_file))
						{

						}
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
                	'group_id'=>$cleanData['group_id'],
                	'created'=>time(),
                	'status'=>1,
                	'uid'=>$userdata['userid']
					);
					if($imgname != "")
					{
						$userData1['wowza_image'] = $imgname;
					}
					$id = $this->common_model->updateConfiguration($cleanData['appid'],$userData1);
					if($id > 0)
					{
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'wavaz updated Sucessfully!');
						redirect('groupadmin/configuration');
					}
					else
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error occur while updloading group image!');
						redirect('groupadmin/configuration');
					}
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while updloading group image!');
				redirect('groupadmin/configuration');
			}
		}
		/* Encoder Uptime */
		public function encoderUptime()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$encid = $cleanData['id'];

			$encoder = $this->common_model->getAllEncoders($encid,0);
			$ip = $encoder[0]["encoder_ip"];
			$username = $encoder[0]["encoder_uname"];
			$password = $encoder[0]["encoder_pass"];
			$port = "22";
			$ssh = new Net_SSH2($ip);
			if (!$ssh->login($username, $password,$port)) {
				$response['response'][$encid] = array('status'=>TRUE,'response'=>$ssh->getLog());
			}
			else
			{
				$resp = $ssh->exec("uptime -p");
				$response['response'][$encid] = array('status'=>TRUE,'response'=>$resp);
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
			$userdata = $this->session->userdata('user_data');
			$data['groups'] = $this->common_model->getGroups($userdata['userid']);
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/createencoder',$data);
			$this->load->view('gadmin/footer');
		}
		/* Encoder Edit Form */
		public function editEncoder()
		{
			$id = $this->uri->segment(3);
			$userdata =$this->session->userdata('user_data');
			$data['groups'] = $this->common_model->getGroups($userdata['userid']);
			$data['encoder'] = $this->common_model->getAllEncoders($id);
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/editencoder',$data);
			$this->load->view('gadmin/footer');
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
				$this->form_validation->set_rules('encoder_hardware', 'Encoder Hardware', 'required');
				$this->form_validation->set_rules('encoder_model', 'Encoder Model', 'required');
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
					$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
					$userdata = $this->session->userdata('user_data');
					$encoderData = array(
						'uid'=>$userdata['userid'],
	                	'encoder_name'=>$cleanData['encoder_name'],
	                	'encoder_ip'=>$cleanData['encoder_ip'],
	                	'encoder_port'=>$cleanData['encoder_port'],
	                	'encoder_uname'=>$cleanData['encoder_uname'],
	                	'encoder_pass'=>$cleanData['encoder_pass'],
	                	'encoder_hardware'=>$cleanData['encoder_hardware'],
	                	'encoder_model'=>$cleanData['encoder_model'],
	                	'encoder_group'=>$cleanData['encoder_group'],
	                	'encoder_inputs'=>implode(',',$cleanData['encoder_inputs']),
	                	'encoder_output'=>implode(',',$cleanData['encoder_output']),
	                	'created'=>time()
					);
					$id = $this->common_model->insertEncoder($encoderData);
					if($id > 0)
					{
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Encoder is sucessfully cretaed!');
						redirect('groupadmin/addEncoderes');
					}
					else
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error occur while creating encoder!');
						redirect('groupadmin/addEncoderes');
					}
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while creating encoder!');
				redirect('groupadmin/addEncoderes');
			}
		}
		/* Encoder Update Existing */
		public function updateEncoder()
		{
			try{
				$this->form_validation->set_rules('encoder_name', 'Encoder Name', 'required');
				$this->form_validation->set_rules('encoder_ip', 'Encoder IP Address', 'required');
				$this->form_validation->set_rules('encoder_port', 'Encoder Port', 'required');
				$this->form_validation->set_rules('encoder_uname', 'Encoder Username', 'required');
				$this->form_validation->set_rules('encoder_pass', 'Encoder Password', 'required');
				$this->form_validation->set_rules('encoder_hardware', 'Encoder Hardware', 'required');
				$this->form_validation->set_rules('encoder_model', 'Encoder Model', 'required');
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
					$encoderData = array(
						'uid'=>$userdata['userid'],
	                	'encoder_name'=>$cleanData['encoder_name'],
	                	'encoder_ip'=>$cleanData['encoder_ip'],
	                	'encoder_port'=>$cleanData['encoder_port'],
	                	'encoder_uname'=>$cleanData['encoder_uname'],
	                	'encoder_pass'=>$cleanData['encoder_pass'],
	                	'encoder_hardware'=>$cleanData['encoder_hardware'],
	                	'encoder_model'=>$cleanData['encoder_model'],
	                	'encoder_group'=>$cleanData['encoder_group'],
	                	'encoder_inputs'=>implode(',',$cleanData['encoder_inputs']),
	                	'encoder_output'=>implode(',',$cleanData['encoder_output']),
					);
					$id = $this->common_model->updateEncoder($encoderData,$cleanData['encoderId']);
					if($id >= 0)
					{
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Encoder is sucessfully updated!');
						redirect('groupadmin/addEncoderes');
					}
					else
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error occur while updating encoder!');
						redirect('groupadmin/addEncoderes');
					}
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while updating encoder!');
				redirect('groupadmin/addEncoderes');
			}
		}
		/* Encoder Reboot */
		public function encoderReboot()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$wid = explode("_",$cleanData['wowzaId']);
			$encoder = $this->common_model->getAllEncoders($wid[1],0);
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
			echo json_encode($response);
		}
		/* Encoder Refresh */
		public function encoderRefresh()
		{
			$response = array('status'=>TRUE,'response'=>'Refresh Successfully!');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$wid = explode("_",$cleanData['wowzaId']);
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
			echo json_encode($response);
		}
		/* Encoding Template */
		public function updateencodingtemplate()
		{
			$id = $this->uri->segment(3);
			$data['template'] = $this->common_model->getEncodingTemplateById($id);
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/updateencodingtemplate',$data);
			$this->load->view('gadmin/footer');
		}
		/* Channel Listing */
		public function channels()
		{
			$userdata =$this->session->userdata('user_data');
			$data['channels'] = $this->common_model->getAllChannels($userdata['userid']);
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/channels',$data);
			$this->load->view('gadmin/footer');
		}
		/* Channel Create New Form */
		public function createchannel()
		{
			$userdata =$this->session->userdata('user_data');
			$data['encoders'] = $this->common_model->getAllEncoders(0,$userdata['userid']);
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/createchannels',$data);
			$this->load->view('gadmin/footer');
		}
		/* Channels Update Form */
		public function updatechannel()
		{
			$id = $this->uri->segment(3);
			$userdata =$this->session->userdata('user_data');
			$data['encoders'] = $this->common_model->getAllEncoders(0,$userdata['userid']);
			$data['channels'] = $this->common_model->getChannelbyId($id);
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/updatechannel',$data);
			$this->load->view('gadmin/footer');
		}
		/* Channels Save */
		public function saveChannel()
		{
			try{
				$post     = $this->input->post();
				$actual_link =  $_SERVER['HTTP_REFERER'];
				$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
				$userdata = $this->session->userdata('user_data');
				$apps =0;$encid =0;
				//print_r($cleanData);die;
				if($cleanData['channel_apps'] != "")
				{
					$apps = $cleanData['channel_apps'];
				}
				$eids = explode("_",$cleanData['channelInput']);
				$ids = explode("_",$cleanData['channelOutpue']);
				if($eids[0]== "phyinput")
				{
					$encid = $eids[2];
				}
				elseif($ids[0] == "phyoutput")
				{
					$encid = $ids[2];
				}
				else
				{
					$encid = 0;
				}
				if($cleanData['encoding_profile'] == "")
				{
					$encodingProfile = 0;
				}
				$chennelData = array(
					'uid'=>$userdata['userid'],
                	'channel_name'=>$cleanData['channel_name'],
                	'encoder_id'=>$encid,
                	'channelInput'=>$cleanData['channelInput'],
                	'channel_ndi_source'=>$cleanData['channel_ndi_source'],
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
                	'process_name'=>'CH'.$this->random_string(10)
				);

				$id = $this->common_model->insertChannels($chennelData);
				if($id > 0)
				{
					$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'Channel is sucessfully saved!');
					redirect('groupadmin/channels');
				}
				else
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error occur while creating channel!');
					redirect('groupadmin/channels');
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while creating channel!');
				redirect('groupadmin/channels');
			}
		}
		/* Channels Update Existing  */
		public function updateExistingChannel()
		{
			try{
				$cid = $this->uri->segment(3);
				$post     = $this->input->post();
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
				if($eids[0]== "phyinput")
				{
					$encid = $eids[2];
				}
				elseif($ids[0] == "phyoutput")
				{
					$encid = $ids[2];
				}
				else
				{
					$encid = 0;
				}
				
				$chennelData = array(
                	'channel_name'=>$cleanData['channel_name'],
                	'encoder_id'=>$encid,
                	'channelInput'=>$cleanData['channelInput'],
                	'channel_ndi_source'=>$cleanData['channel_ndi_source'],
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
                	'encoding_profile'=>$cleanData['encoding_profile']
				);

				$id = $this->common_model->updateChannels($chennelData,$cid);
				if($id > 0)
				{
					$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'Channel is sucessfully saved!');
					redirect('groupadmin/channels');
				}
				else
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error occur while creating channel!');
					redirect('groupadmin/channels');
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while creating channel!');
				redirect('groupadmin/channels');
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
							$response['response'][$cid]['response'] = "Error occure while ".$action." wowza!";
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
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/appTargets',$data);
			$this->load->view('gadmin/footer');
		}
		/* Wowza Refresh Action */
		public function applicaitonRestart()
		{
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$wids = $cleanData['wowzaId'];
			$wid = explode('_',$wids);
			$wowzaEngine = $this->common_model->get($wid[1]);
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
			$ip = "152.115.45.153";
			$username = "ls";
			$password ="EnXs247";
			$port = "22";
			$ssh = new Net_SSH2($ip);
			if (!$ssh->login($username, $password,$port)) {
				$response['status']= FALSE;
				$response['response']= $ssh->getLog();
			}
			else
			{
				$ndiArray = array();
				$resp = $ssh->exec("ffmpeg -f libndi_newtek -find_sources 1 -i dummy");
				$array = explode('NDI sources:',$resp);
				$array1 = explode("\n",$array[1]);
				if(sizeof($array1)>0)
				{
					foreach($array1 as $ele)
					{
						if($ele != "" && strpos($ele, 'Immediate') == false)
						{
							$node = explode("'",$ele);
							$ndiArray[] = $node[1];
						}
					}
				}
				$response['status']= TRUE;
				$response['response']= $ndiArray;
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
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/createencodingtemplate');
			$this->load->view('gadmin/footer');
		}


		public function editTarget()
		{
			$id = $this->uri->segment(3);
			$data['target'] = $this->common_model->getTargetbyId($id);
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/edittarget',$data);
			$this->load->view('gadmin/footer');
		}
		public function cancelProvider()
		{
			$this->session->unset_userdata('fb_token');
			$this->session->unset_userdata('rtmpData');
			$this->session->unset_userdata('fbUser');
			$this->session->unset_userdata('socialLogin');
			$this->session->unset_userdata('state');
			$this->session->unset_userdata('youtubeData');
			redirect(site_url() . 'admin/createtarget');
		}
		public function channelStartStop()
		{
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
				if($inputTypeArray[0] == "phyinput")
				{
					$input_type = "decklink";
					$inputName = $this->common_model->getEncoderInputbyId($inputTypeArray[1]);
					$input_name = $inputName[0]['item'];

				}
				elseif($inputTypeArray[0] == "virinput")
				{
					switch($inputTypeArray[1])
					{
						case "3":
						$input_type = "libndi_newtek";
						$input_name = $channel[0]['channel_ndi_source'];
						$options = '-vf "scale=interl=1,fps=50,format=pix_fmts=uyvy422"';
						break;
						case "4":
						$input_type = "flv";
						break;
					}
				}
				if($outputTypeArray[0] == "phyoutput")
				{
					$output_type = "decklink";										
					$ou = $this->common_model->getOutputName($outputTypeArray[1]);
					$output_name = $ou[0]['item'];
				}
				elseif($outputTypeArray[0] == "viroutput")
				{

					switch($outputTypeArray[1])
					{
						case 3:
						$output_type = "libndi_newtek";
						$options = '-vf "scale=interl=1,fps=50,format=pix_fmts=uyvy422"';
						$output_name = $channel[0]["ndi_name"];
						break;
						case 4:
						$application = $this->common_model->getAppbyId($channel[0]['channel_apps']);
						$encodingProfile = $this->common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
						$output_type = "flv";
						$gop ="";$deinterlace ="";
						if($encodingProfile[0]['adv_video_gop'] != "")
						{
							$gop = '-g '.$encodingProfile[0]["adv_video_gop"];
						}
						if($encodingProfile[0]['adv_video_gop'] == 1)
						{
							$deinterlace = '-deinterlace';
						}
						$output_name = $channel[0]["output_rtmp_url"]."/".$channel[0]["output_rtmp_key"];

						$options =  '-c:v '.$encodingProfile[0]['video_codec'].' -s '.$encodingProfile[0]['video_resolution'].' -b:v '.$encodingProfile[0]['video_bitrate'].'k -minrate '.$encodingProfile[0]['video_min_bitrate'].'k -maxrate '.$encodingProfile[0]['video_max_bitrate'].'k -bufsize '.$encodingProfile[0]['adv_video_buffer_size'].'k -force_key_frames '.$encodingProfile[0]['adv_video_keyframe_intrval'].' '.$gop.' -profile:v '.$encodingProfile[0]['adv_video_profile'].' -pix_fmt yuv420p -preset '.$encodingProfile[0]['adv_video_preset'].' '.$deinterlace.' -vf fps='.$encodingProfile[0]['video_framerate'].' -c:a '.$encodingProfile[0]['audio_codec'].' -b:a '.$encodingProfile[0]['audio_bitrate'].'k -ar '.$encodingProfile[0]['audio_sample_rate'].' -ac '.$encodingProfile[0]['audio_channel'];
						break;
					}
				}

				if($inputTypeArray[0] == "phyinput" || $inputTypeArray[0] == "virinput")
				{
					if($output_name != "")
					{
						$pid = $ssh->exec("pidof ".$channel[0]['process_name']);
						if($action == "Start")
						{							
							if($pid == "")
							{		
								if($inputTypeArray[0] == "virinput" && $inputTypeArray[1] == 3)		
								{
									//echo 'bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -re -i \"'.$input_name.'\" '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"';
									$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -re -i \"'.$input_name.'\" '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"');
								}
								else
								{
									$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -re -i \''.$input_name.'\' '.$options.' -f '.$output_type.' '.$output_name.' -threads 16"');
								}						
								
								$pid1 = $ssh->exec("pidof ".$channel[0]['process_name']);
								if($pid1 == "")
								{
									echo json_encode(array('status'=>FALSE, "message"=> 'Error occur while starting stream!','change'=>'stop'));
								}
								elseif($pid1 > 0)
								{
									$p = $pid1;
									$cmd = 'ps -p '.trim($p).' -o lstart=';								
									$time1 = $ssh->exec($cmd);									
									echo json_encode(array('status'=>TRUE, "message"=> 'Stream Starting..','change'=>'start','time'=>$time1));
								}
							}
							else
							{
								$p = $pid1;
									$cmd = 'ps -p '.trim($p).' -o lstart=';								
									$time1 = $ssh->exec($cmd);	
								echo json_encode(array('status'=>TRUE, "message"=> 'Already Running','change'=>'start','time'=>$time1));
							}
						}
						elseif($action == "Stop")
						{
							
							$ssh->exec('pkill -f '.$channel[0]['process_name']);
							echo json_encode(array('status'=>TRUE, "message"=> 'Stopped Successfully!','change'=>'stop'));
						}
						elseif($action == "checkstatus")
						{
							$pid = $ssh->exec("pidof ".$channel[0]['process_name']);
							if($pid == "")
							{
								echo json_encode(array('status'=>TRUE, "message"=> 'Stopped','change'=>'stop'));

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

			/*$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch, CURLOPT_TIMEOUT_MS, 300); //timeout in seconds
			//curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));

			$result = curl_exec($ch);
			*/

			$resultt=shell_exec("curl -X put ".$url);


			//$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			//curl_close($ch);


			/*  Check Status */
			$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['java_api_port'].'/api/v1/getStreamTargetStatus/'.$application[0]['application_name'];

			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_FAILONERROR, true);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_HEADER, FALSE);   // we want headers
			    // we don't need body
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($curl, CURLOPT_TIMEOUT_MS, 300); //timeout in seconds
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($curl);
			$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	    	$data = json_decode($result,TRUE);

	    	if(sizeof($data['status'])>0)
	    	{
				foreach($data['status'] as $key=>$value)
				{
					if(array_key_exists($target[0]['target_name'],$value))
					{
						$response['status'] = TRUE;
						$response['response'] = $value[$target[0]['target_name']];
					}
				}
			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = array();
			}
			if(curl_error($curl))
			{
				$response['status'] = FALSE;
				$response['response'] = $result;
			}
			/* Check Status */

			if($httpcode != "")
			{
				$response['status'] = TRUE;
				$response['code'] = $httpcode;
			}
			else
			{
				$response['status'] = FALSE;
				$response['code'] = $httpcode;
			}
			echo json_encode($response);
		}
		public function googleaccount()
		{
			$this->session->set_userdata('socialLogin', "google");
			$OAUTH2_CLIENT_ID = '96664961069-u28cbpg3rn590g43l9jbl8fu3ma1uk41.apps.googleusercontent.com';
			
			$OAUTH2_CLIENT_SECRET = 'sjjaq7BxcjKLrQ1Pv4ISpPuj';
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

			  $client->authenticate($_GET['code']);
			  $this->session->set_userdata($tokenSessionKey, $client->getAccessToken());
			}
			$googleTokenSessionKey = $this->session->userdata($tokenSessionKey);

			if ($googleTokenSessionKey != "") {

			  $client->setAccessToken($googleTokenSessionKey);
			}
			if ($client->getAccessToken()) {
			  try {

			    $streamSnippet = new Google_Service_YouTube_LiveStreamSnippet();
			    $streamSnippet->setTitle('New Stream');
			    $cdn = new Google_Service_YouTube_CdnSettings();
			    $cdn->setFormat("1080p");
			    $cdn->setIngestionType('rtmp');

			    // Create the API request that inserts the liveStream resource.
			    $streamInsert = new Google_Service_YouTube_LiveStream();
			    $streamInsert->setSnippet($streamSnippet);
			    $streamInsert->setCdn($cdn);
			    $streamInsert->setKind('youtube#liveStream');

			    $streamsResponse = $youtube->liveStreams->insert('snippet,cdn',$streamInsert, array());


				$this->session->set_userdata("youtubeData", $streamsResponse);

			  } catch (Google_Service_Exception $e) {
			  		$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'A service error occurred '.htmlspecialchars($e->getMessage()));
					$state = mt_rand();
			  $client->setState($state);
			  $this->session->set_userdata("state", $state);
			  $authUrl = $client->createAuthUrl();
			redirect($authUrl);
					redirect(site_url() . 'admin/createtarget');
			  } catch (Google_Exception $e) {
			    	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'A service error occurred '.htmlspecialchars($e->getMessage()));
					$state = mt_rand();
			  $client->setState($state);
			  $this->session->set_userdata("state", $state);
			  $authUrl = $client->createAuthUrl();
			  redirect($authUrl);
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
		}
		public function twitter()
		{
			$this->session->set_userdata('socialLogin', "twitter");
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
			header('Location: '.$url);
		}
		public function fb()
		{
			define('APP_URL', 'https://iohub.tv/admin/fb');
			$facebookArray = array('app_id' => '201130880631964', 'app_secret' => '49e984459f5d67695b85b443dc879d82',  'default_graph_version' => 'v2.6');


			$fb = new Facebook\Facebook($facebookArray);
		//	$FacebooOBJ = $fb;
			$helper = $fb->getRedirectLoginHelper();
			$permissions = ['publish_actions','manage_pages','pages_show_list'];
			$fbToken = $this->session->userdata('fb_token');
			$scope = "email, user_about_me, user_birthday, user_hometown, user_location, user_website, publish_actions, manage_pages,publish_pages,pages_show_list,user_managed_groups,user_events,user_posts";
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
			 	redirect('groupadmin/createtarget');
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
			 	$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Facebook SDK returned an error: ' . $e->getMessage());
			 	redirect('groupadmin/createtarget');
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
					session_destroy();
			 		//redirect('groupadmin/createtarget');
				}
				catch(Facebook\Exceptions\FacebookSDKException $e)
				{
					// When validation fails or other local issues
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Facebook SDK returned an error: ' . $e->getMessage());
			 		//redirect('groupadmin/createtarget');
				}


				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'Logged in facebook Successfully');
				$createLiveVideo['logoutULR'] = $helper->getLogoutUrl(APP_URL, $permissions);
				//$this->session->set_userdata('rtmpData', $createLiveVideo);
				$this->session->set_userdata('fbUser', $user);



			 	redirect('groupadmin/createtarget');

			    //$data = [
			      //'title' => 'My Foo Video',
			      //'description' => 'This video is full of foo and bar action.',
			    //];

			    //try {
			      //$response = $fb->uploadVideo('1451106665118438', 'xyz.mp4', $data, $_SESSION['fb_token']);
			    //} catch(Facebook\Exceptions\FacebookResponseException $e) {
			      // When Graph returns an error
			      //echo 'Graph returned an error: ' . $e->getMessage();
			      //exit;
			    //} catch(Facebook\Exceptions\FacebookSDKException $e) {
			      // When validation fails or other local issues
			      //echo 'Facebook SDK returned an error: ' . $e->getMessage();
			      //exit;
			    //}

			   // echo 'Video ID: ' . $response['video_id'];

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
	print_r($data);
		}
		public function dashboard()
		{
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/dashboard');
			$this->load->view('gadmin/footer');
		}
		public function wowzaapps()
		{
			$id = $this->uri->segment(3);
			$data['applications'] = $this->common_model->getWowzaApps($id);
			$data['targets'] = $this->common_model->getAllTargets();
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/wowzaapplications',$data);
			$this->load->view('gadmin/footer');
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
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/dashboard');
			$this->load->view('gadmin/footer');
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
			$sts = $this->common_model->updateTarget($appData);
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
        	'uid'=>$userdata->userid
			);
			$sts = $this->common_model->insertCreateVod($appData);
			if($sts)
			{
				$response['status'] = TRUE;
				$response['response'] = "Copied Successfully!";
			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = "Error occure while Copying Application!";
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
			  curl_setopt($ch, CURLOPT_RETURNTRANSFER, FALSE);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
			$result = curl_exec($ch);
			$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			curl_close($ch);
			$sts = $this->common_model->deleteApplication($idArray[1]);
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
			//http://IP:Port/api/v1/getStreamTargetStatus/{appName}
			$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['java_api_port'].'/api/v1/getStreamTargetStatus/'.$application[0]['application_name'];

			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_FAILONERROR, true);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_HEADER, FALSE);   // we want headers
			    // we don't need body
			curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($curl, CURLOPT_TIMEOUT_MS, 300); //timeout in seconds
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$result = curl_exec($curl);
			$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
	    	$data = json_decode($result,TRUE);
	    	if(sizeof($data['status'])>0)
	    	{
				foreach($data['status'] as $key=>$value)
				{
					if(array_key_exists($target[0]['target_name'],$value))
					{
						$response['status'] = TRUE;
						$response['response'] = $value[$target[0]['target_name']];
					}
				}
			}
			else
			{
				$response['status'] = FALSE;
				$response['response'] = array();
			}
			if(curl_error($curl))
			{
				$response['status'] = FALSE;
				$response['response'] = $result;
			}
			echo json_encode($response);
			curl_close($curl);
		}

		public function configuration()
		{
			$userdata = $this->session->userdata('user_data');
			$data['configdetails'] = $this->common_model->getConfigurationsDetails($userdata['userid']);
			$data['encoders'] = $this->common_model->getAllEncoders(0,$userdata['userid']);
			$data['userDetails'] = $this->common_model->getUserDetails($userdata['userid']);
			$data['encoderTemplates'] = $this->common_model->getEncoderTemplate($userdata['userid']);
			$data['groupinfo'] = $this->common_model->getGroupByType("Admin");
			$data['sessiondata']= $userdata;
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/configuration',$data);
			$this->load->view('gadmin/footer');
		}
		public function clients()
		{
			$user_data = $this->session->userdata('user_data');
			$data['groups'] = $this->common_model->getGroups($user_data['userid']);
			$data['users'] = $this->common_model->getUsers();
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/clients',$data);
			$this->load->view('gadmin/footer');
		}
		public function profile()
		{
			try
			{
				$user_data = $this->session->userdata('user_data');
				$data['userProfileData'] = $this->common_model->getProfileData($user_data['userid']);
				$this->load->view('gadmin/header');
				$this->load->view('gadmin/profile',$data);
				$this->load->view('gadmin/footer');
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
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/createwowza');
			$this->load->view('gadmin/footer');
		}
		public function creategroup()
		{
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/creategroup');
			$this->load->view('gadmin/footer');
		}

		public function createuser()
		{
			$data['groups'] = $this->common_model->getGroups();

			$this->load->view('gadmin/header');
			$this->load->view('gadmin/createuser',$data);
			$this->load->view('gadmin/footer');
		}
		public function applications()
		{
			$segment = $this->uri->segment(3);
			if($segment != "" && $segment > 0)
			{
				$data['applications'] = $this->common_model->getWowzaApps($segment);
			}
			else
			{
				$data['applications'] = $this->common_model->getAllApplications();
			}

			$data['targets'] = $this->common_model->getAllTargets();
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/applications',$data);
			$this->load->view('gadmin/footer');
		}
		public function createapplication()
		{
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/createvod');
			$this->load->view('gadmin/footer');
		}
		public function updateapp()
		{
			$appid = $this->uri->segment(3);
			$data['application'] = $this->common_model->getAppbyId($appid);
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/updateapp',$data);
			$this->load->view('gadmin/footer');
		}
		public function createtarget()
		{
		//	$this->session->unset_userdata('fb_token');
		//	$this->session->unset_userdata('rtmpData');
		//	$this->session->unset_userdata('fbUser');
		//	$this->session->unset_userdata('socialLogin');

			$this->load->view('gadmin/header');
			$this->load->view('gadmin/createtarget');
			$this->load->view('gadmin/footer');
		}
		public function playlists()
		{
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/playlists');
			$this->load->view('gadmin/footer');
		}
		public function createplaylist()
		{
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/createplaylist');
			$this->load->view('gadmin/footer');
		}
		public function permissions()
		{
			$data['users'] = $this->common_model->getUsers();
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/permissions',$data);
			$this->load->view('gadmin/footer');
		}
		public function savePermissions()
		{
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			print_r($cleanData);

			if(sizeof($cleanData['rid'])>0)
			{
				$permissionData = array();
				foreach($cleanData['rid'] as $userId)
				{
					if(array_key_exists('create_user',$cleanData))
					{
						if(array_key_exists($userId,$cleanData['create_user']))
						{
							$permissionData['create_user'] = 1;
						}
						else
						{
							$permissionData['create_user'] = 0;
						}
					}
					else
					{
						$permissionData['create_user'] = 0;
					}
					if(array_key_exists('edit_user',$cleanData))
					{
						if(array_key_exists($userId,$cleanData['edit_user']))
						{
							$permissionData['edit_user'] = 1;
						}
						else
						{
							$permissionData['edit_user'] = 0;
						}
					}
					else
					{
						$permissionData['edit_user'] = 0;
					}
					if(array_key_exists('delete_user',$cleanData))
					{
						if(array_key_exists($userId,$cleanData['delete_user']))
						{
							$permissionData['delete_user'] = 1;
						}
						else
						{
							$permissionData['delete_user'] = 0;
						}
					}
					else
					{
						$permissionData['delete_user'] = 0;
					}
					if(array_key_exists('createapp',$cleanData))
					{
						if(array_key_exists($userId,$cleanData['createapp']))
						{
							$permissionData['create_application'] = 1;
						}
						else
						{
							$permissionData['create_application'] = 0;
						}
					}
					else
					{
						$permissionData['create_application'] = 0;
					}
					if(array_key_exists('editapp',$cleanData))
					{
						if(array_key_exists($userId,$cleanData['editapp']))
						{
							$permissionData['edit_application'] = 1;
						}
						else
						{
							$permissionData['edit_application'] = 0;
						}
					}
					else
					{
						$permissionData['edit_application'] = 0;
					}
					if(array_key_exists('deleteapp',$cleanData))
					{
						if(array_key_exists($userId,$cleanData['deleteapp']))
						{
							$permissionData['delete_application'] = 1;
						}
						else
						{
							$permissionData['delete_application'] = 0;
						}
					}
					else
					{
						$permissionData['delete_application'] = 0;
					}
					if(array_key_exists('createtarget',$cleanData))
					{
						if(array_key_exists($userId,$cleanData['createtarget']))
						{
							$permissionData['create_target'] = 1;
						}
						else
						{
							$permissionData['create_target'] = 0;
						}
					}
					else
					{
						$permissionData['create_target'] = 0;
					}
					if(array_key_exists('edittarget',$cleanData))
					{
						if(array_key_exists($userId,$cleanData['edittarget']))
						{
							$permissionData['edit_target'] = 1;
						}
						else
						{
							$permissionData['edit_target'] = 0;
						}
					}
					else
					{
						$permissionData['edit_target'] = 0;
					}
					if(array_key_exists('deletetarget',$cleanData))
					{
						if(array_key_exists($userId,$cleanData['deletetarget']))
						{
							$permissionData['delete_target'] = 1;
						}
						else
						{
							$permissionData['delete_target'] = 0;
						}
					}
					else
					{
						$permissionData['delete_target'] = 0;
					}
					if(array_key_exists('createwowza',$cleanData))
					{
						if(array_key_exists($userId,$cleanData['createwowza']))
						{
							$permissionData['create_wowza'] = 1;
						}
						else
						{
							$permissionData['create_wowza'] = 0;
						}
					}
					else
					{
						$permissionData['create_wowza'] = 0;
					}
					if(array_key_exists('editwowza',$cleanData))
					{
						if(array_key_exists($userId,$cleanData['editwowza']))
						{
							$permissionData['edit_wowza'] = 1;
						}
						else
						{
							$permissionData['edit_wowza'] = 0;
						}
					}
					else
					{
						$permissionData['edit_wowza'] = 0;
					}
					if(array_key_exists('deletewowza',$cleanData))
					{
						if(array_key_exists($userId,$cleanData['deletewowza']))
						{
							$permissionData['delete_wowza'] = 1;
						}
						else
						{
							$permissionData['delete_wowza'] = 0;
						}
					}
					else
					{
						$permissionData['delete_wowza'] = 0;
					}

					$permissionData['created']= time();
					$roles = $this->config->item('rol');
					$userId = $roles[$userId];
					$permissionData['rid']= $userId;
					$permission = $this->common_model->getUserPermission($userId);
					if(sizeof($permission)>0)
					{
						$id = $this->common_model->updatePermissions($userId,$permissionData);
					}
					else
					{
						$id = $this->common_model->insertUserPermissions($permissionData);
					}
				}
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'Permissions updated successfully!');
				redirect('groupadmin/permissions');
			}
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
						$message .= '<strong>Your Password has been updated Sucessfully.</strong><br><br>';
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
		            	if(array_key_exists('group_notification',$cleanData['group_notification']) && $cleanData['group_notification'] == "on")
		            	{
							$notify=1;
						}
						if(array_key_exists('group_theme',$cleanData['group_theme']) && $cleanData['group_theme'] == "on")
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
							$userId = $id;
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

								$target_file = 'assets/site/main/group_pics/'.$imgname;
								if (move_uploaded_file($_FILES["groupfile"]["tmp_name"], $target_file)) {
									if($this->common_model->insertUserImage($imgname,$userId))
									{
										$this->session->set_flashdata('message_type', 'success');
										$this->session->set_flashdata('success', 'User is sucessfully created!');
										$this->session->set_flashdata('tab', 'User');
										redirect('groupadmin/clients');
									}
								}
							}
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'Error occur while updloading User image!');

							redirect('groupadmin/clients');
						}
					}

				}
			}
			catch(Exception $e)
			{
		 		$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occured While Creating User!');
				redirect('groupadmin/createuser');
			}
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
				if($id > 0)
				{
					$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'Encoding Template is sucessfully updated!');
					redirect('groupadmin/configuration');
				}
				else
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error occur while creating encoding template!');
					redirect('groupadmin/configuration');
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while creating encoding template!');
				redirect('groupadmin/configuration');
			}
		}
		public function saveEncoderTemplate()
		{
			try{


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
                	'delay'=>$cleanData['delay'],
                	'status'=>1,
                	'created'=>time()
				);
				$id = $this->common_model->insertEncodeingTemplate($encoderData);
				if($id > 0)
				{
					$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'Encoding Template is sucessfully saved!');
					redirect('groupadmin/createtemplate');
				}
				else
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Error occur while creating encoding template!');
					redirect('groupadmin/createtemplate');
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while creating encoding template!');
				redirect('groupadmin/configuration');
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

							$target_file = 'assets/site/main/group_pics/'.$imgname;
							if (move_uploaded_file($_FILES["groupfile"]["tmp_name"], $target_file)) {
								$data = array(
								'name'=>$imgname,
								'created'=>time(),
								'status'=>1,
								'gid'=>$userId
								);

								if($this->common_model->insertGroupImage($data))
								{
									$this->session->set_flashdata('message_type', 'success');
									$this->session->set_flashdata('success', 'Group is sucessfully cretaed!');
									$this->session->set_flashdata('tab', 'Group');
									redirect('groupadmin/clients');
								}
							}
						}
						else
						{
							$this->session->set_flashdata('message_type', 'success');
							$this->session->set_flashdata('success', 'Group is sucessfully cretaed!');
							$this->session->set_flashdata('tab', 'Group');
							redirect('groupadmin/clients');
						}
					}
					else
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error occur while updloading group image!');
						redirect('groupadmin/clients');
					}
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while updloading group image!');
				redirect('groupadmin/creategroup');
			}
		}
		public function updategroupanduserinfo()
		{
			$userdata = $this->session->userdata('user_data');
			$this->form_validation->set_rules('group_name', 'Group Name', 'required');
			$this->form_validation->set_rules('group_email', 'Group Email', 'required');
			$this->form_validation->set_rules('group_licence', 'Licence', 'required');
			$this->form_validation->set_rules('group_favicon',' Shortcut Icon', 'required');
			$this->form_validation->set_rules('group_theme', 'Use Light Theme', 'required');
			$this->form_validation->set_rules('group_menu_hide', 'Menu Auto Hide', 'required');
			$this->form_validation->set_rules('group_logo', 'Use Default Logo', 'required');
			$this->form_validation->set_rules('group_sitename', 'Hide Sitename', 'required');
			$this->form_validation->set_rules('group_notification', 'Hide Notification', 'required');
			$this->form_validation->set_rules('timezone', 'Timezone', 'required');
			$this->form_validation->set_rules('timeformat', 'Timeformat', 'required');
			$this->form_validation->set_rules('language', 'Language', 'required');


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
				redirect('groupadmin/configuration');
			}
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('success', 'Configuration Updated Successfully!');
			redirect('groupadmin/configuration');
		}

		public function saveTarget()
		{
			try
			{


				$userdata = $this->session->userdata('user_data');
				$this->form_validation->set_rules('target_name', 'Target Name', 'required');
				$this->form_validation->set_rules('wowzaengin', 'Live Source', 'required');
				$this->form_validation->set_rules('streamurl', 'Stream URL', 'required');
				//$this->form_validation->set_rules('target', 'Target', 'required');
				$this->form_validation->set_rules('title', 'Title', 'required');
				$this->form_validation->set_rules('description', 'Description', 'required');

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
                	'title'=>$cleanData['title'],
                	'description'=>$cleanData['description'],
                	'continuelive'=>$cont,
                	'status'=>1,
                	'created'=>time(),
                	'uid'=>$userdata['userid']
					);
					//
					$apps = $this->common_model->getAppbyId($cleanData['wowzaengin']);
					$wid = $apps[0]['live_source'];
					$wowza = $this->common_model->getWovzData($wid);


                    if(sizeof($socialLogin)>0)
                    {
                    	switch($socialLogin){
							case "facebook":
							$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['java_api_port'].'/api/v1/addFBStream';
							$createLiveVideo = array();
							define('APP_URL', 'http://streamer.kurrent.tv/admin/fb');
							$fbToken = $this->session->userdata('fb_token');
							$fbcode = $this->session->userdata('fb_code');
							$facebookArray = array('app_id' => '201130880631964', 'app_secret' => '49e984459f5d67695b85b443dc879d82',  'default_graph_version' => 'v2.6');
							$u = $this->session->userdata('fbUser');
							$fbobj = new Facebook\Facebook($facebookArray);
							$pageidAndToken = explode('_',$cleanData['pagelist']);

		 /*

		 */
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

							if($cleanData['timelines'] == "timeline")
							{
								$createLiveVideo = $fbobj->post('/me/live_videos', ["name"=>$cleanData['title'], "description"=>$cleanData['description'],'privacy'=>array('value'=>$cleanData['privacy'])],$fbToken);
							}
							elseif($cleanData['timelines'] == "page")
							{
								$createLiveVideo = $fbobj->post('/'.$pageidAndToken[0].'/live_videos',["name"=>$cleanData['title'], "description"=>$cleanData['description']],$tokenArray['access_token']);
							}
							$graphNode = $createLiveVideo->getGraphNode()->asArray();

							$fields = array(
								'source_name'=>$wowza[0]['stream_name'],
								'target_name'=>$cleanData['target_name'],
								'app_name'=>$apps[0]['application_name'],
								'rtmp_url'=>$graphNode['stream_url'],
								'enabled'=>'false'
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
						$this->session->unset_userdata('fb_token');
						$this->session->unset_userdata('rtmpData');
						$this->session->unset_userdata('fbUser');
						$this->session->unset_userdata('socialLogin');
						$this->session->unset_userdata('youtubeData');
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Target Created Sucessfully!');
						$this->session->set_flashdata('tab', 'Target');
						redirect('groupadmin/applications/target');

					}
					else
					{
						$this->session->unset_userdata('fb_token');
						$this->session->unset_userdata('rtmpData');
						$this->session->unset_userdata('fbUser');
						$this->session->unset_userdata('socialLogin');$this->session->unset_userdata('youtubeData');
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error occur while Creating Target!');

						//redirect('groupadmin/applications/target');
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
				$this->session->set_flashdata('error', 'Error occur while Creating Target!');
				print_r($e->getMessage());
				//redirect('groupadmin/applications/target');
			}
		}
		public function updateApplication()
		{
			try
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
					if($id > 0)
					{
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Group Created Sucessfully!');
						redirect('groupadmin/applications');
					}
					else
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error occur while updloading group image!');
						redirect('groupadmin/applications');
					}
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while Updating applicaiton!');
				redirect('groupadmin/applications');
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
					$userData = array(
                	'application_name'=>$cleanData['application_name'],
                	'live_source'=>$cleanData['live_source'],
                	'wowza_path'=>$cleanData['wowza_path'],
                	'created'=>time(),
                	'status'=>1,
                	'uid'=>$userdata['userid']
					);
					$wowza = $this->common_model->getWovzData($cleanData['live_source']);
					$id = $this->common_model->insertCreateVod($userData);
					$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['java_api_port'].'/api/v1/createLiveApplication';
					$fields = array(
					'app_name' =>$cleanData['application_name']
					);
					$ch = curl_init();
					curl_setopt($ch,CURLOPT_URL, $url);
					curl_setopt($ch,CURLOPT_POST, count($fields));
					curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));
					curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
					$result = curl_exec($ch);
					$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
					curl_close($ch);
					if($id > 0)
					{
						$this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Application Created Sucessfully!'.$httpcode.$result);
						$this->session->set_flashdata('tab', 'Application');
						redirect('groupadmin/applications');

					}
					else
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error occur while updloading group image!');
						redirect('groupadmin/applications');
					}
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error occur while updloading group image!');
				redirect('groupadmin/applications');
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
				$response['status'] = TRUE;
				$response['data'] = 'rtmp://'.$wowza[0]['ip_address'].':'.$wowza[0]['rtmp_port'].'/'.$apps[0]['application_name'].'/'.$wowza[0]['stream_name'];
			}
			echo json_encode($response);
		}

		public function updategroup()
		{
			$segment = $this->uri->segment(3);
			$data['groupdata'] = $this->common_model->getGroupInfobyId($segment);
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/editgroup',$data);
			$this->load->view('gadmin/footer');
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

					if($_FILES['groupfile']['name'] != "")
					{
					 	$files = $_FILES['groupfile'];
						$userId = $id;
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

							$target_file = 'assets/site/main/group_pics/'.$imgname;
							if (move_uploaded_file($_FILES["groupfile"]["tmp_name"], $target_file)) {
								if($this->common_model->uploadUserProfilePic($imgname,$userId))
								{
									$this->session->set_flashdata('message_type', 'success');
									$this->session->set_flashdata('success', 'User Updated Sucessfully!');
									redirect('groupadmin/allgroupuser/'.$clean['group_id']);
								}
							}
						}
					}
					else
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error occur while updloading User image!');
						redirect('groupadmin/allgroupuser');
					}

				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occured While Creating User!');
				redirect('groupadmin/createuser');
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

							$target_file = 'assets/site/main/group_pics/'.$imgname;
							if (move_uploaded_file($_FILES["groupfile"]["tmp_name"], $target_file)) {
								if($this->common_model->uploadUserProfilePic($imgname,$id))
								{
									$this->session->set_flashdata('message_type', 'success');
									$this->session->set_flashdata('success', 'User Updated Sucessfully!');
									redirect('groupadmin/profile/'.$clean['group_id']);
								}
							}
						}
					}
					else
					{
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Error occur while updloading User image!');
						redirect('groupadmin/profile');
					}
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Error Occured While Creating User!');
				redirect('groupadmin/createuser');
			}
		}
		public function updateuser()
		{
			$segment = $this->uri->segment(3);
			$data['groupuser'] = $this->common_model->getAdminDataUserbyId($segment);
			$data['groups'] = $this->common_model->getGroups();
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/edituser',$data);
			$this->load->view('gadmin/footer');
		}
		public function updateusers()
		{
			$segment = $this->uri->segment(3);
			$data['groupuser'] = $this->common_model->getAdminDataUserbyId($segment);
			$data['groups'] = $this->common_model->getGroups();
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/editusers',$data);
			$this->load->view('gadmin/footer');
		}

		public function updateGroupDetails()
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
			$this->form_validation->set_rules('group_notification', 'Notification', 'required');
			$this->form_validation->set_rules('group_licence', 'Licence', 'required');

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

				$target_file = 'assets/site/main/group_pics/'.$imgname;
				if (move_uploaded_file($_FILES["groupfile"]["tmp_name"], $target_file))
				{
					$this->common_model->uploadProfilePic($imgname,$group_id);
					$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'Group Image Created Sucessfully!');
					redirect('groupadmin/clients');

				}
			}
			if($status>=0)
			{
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'Group Image Created Sucessfully!');
				redirect('groupadmin/clients');
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

				$target_file = 'assets/site/main/group_pics/'.$imgname;
				if (move_uploaded_file($_FILES["groupfile"]["tmp_name"], $target_file))
				{
					$this->common_model->uploadProfilePic($imgname,$group_id);
					$this->session->set_flashdata('message_type', 'success');
					$this->session->set_flashdata('success', 'User Image Created Sucessfully!');
					redirect('groupadmin/clients');

				}
			}
			if($status>=0)
			{
				$this->session->set_flashdata('message_type', 'success');
				$this->session->set_flashdata('success', 'Group Image Created Sucessfully!');
				redirect('groupadmin/clients');
			}
		}
		public function allgroupuser()
		{
			$group_id = $this->uri->segment(3);
			$data['groups'] = $this->common_model->getGroups();
			$data['groupsUsers'] = $this->common_model->getGroupuserbyId($group_id);
			$this->load->view('gadmin/header');
			$this->load->view('gadmin/groupusers',$data);
			$this->load->view('gadmin/footer');
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
			switch($action)
			{
				case "Block":
				break;
				case "UnBlock":				
				break;			
				case "Delete":
				if(!empty($ids)){
					foreach($ids as $id ){
						$sts = $this->common_model->deleteUsers($id);
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
							$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['java_api_port'].'/api/v1/activateStreamTarget';
							$fields = array(
								'app_name' =>$application[0]['application_name'],
								'target_name'=>array($target[0]['target_name'])
							);
							$ch = curl_init();
							curl_setopt($ch,CURLOPT_URL, $url);
							curl_setopt($ch, CURLOPT_HEADER, false);   // we don't need body
							curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
							curl_setopt($ch, CURLOPT_TIMEOUT_MS, 300); //timeout in seconds
							curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
							curl_setopt($ch,CURLOPT_POST, count($fields));
							curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));
							curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
							$result = curl_exec($ch);
							$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
							curl_close($ch);
							if($httpcode != "")
							{
								$response['status'] = TRUE;
								$response['response'] = $httpcode;
							}
							else
							{
								$response['status'] = FALSE;
								$response['response'] = $httpcode;
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
							$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['java_api_port'].'/api/v1/deactivateStreamTarget';
							$fields = array(
								'app_name' =>$application[0]['application_name'],
								'target_name'=>array($target[0]['target_name'])
							);

							$ch = curl_init();
							curl_setopt($ch,CURLOPT_URL, $url);
							curl_setopt($ch, CURLOPT_HEADER, false);   // we don't need body
							curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
							curl_setopt($ch, CURLOPT_TIMEOUT_MS, 300); //timeout in seconds
							curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
							curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
							curl_setopt($ch,CURLOPT_POST, count($fields));
							curl_setopt($ch,CURLOPT_POSTFIELDS, json_encode($fields));
							curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
							$result = curl_exec($ch);
							$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
							curl_close($ch);
							if($httpcode != "")
							{
								$response['status'] = TRUE;
								$response['response'] = $httpcode;
							}
							else
							{
								$response['status'] = FALSE;
								$response['response'] = $httpcode;
							}
						}
					}
				break;
				case "Delete":
					if(sizeof($targetIDs)>0)
					{
						foreach($targetIDs as $ID)
						{
							$sts = $this->common_model->deleteAdminTarget($ID);
							if($sts >=0)
							{
								$response['status'] = TRUE;
								$response['response'] = $action." Successfully!";
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
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, FALSE);
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
						redirect('groupadmin/profile');
					}
					else
					{
						$password = $this->input->post('newpassword');
						$old_passowrd = sha1($this->input->post('oldpassword'));
						$userPass= $this->common_model->checkPass($user_data['email']);
						if($userPass->password !=$old_passowrd){
							$this->session->set_flashdata('error', 'Sorry Password Not Match!');
							redirect('groupadmin/profile');
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
							redirect('groupadmin/profile');
						}
					}
				}else{
					redirect('home');
				}
			}
			catch(Exception $e)
			{
				$this->session->set_flashdata('warning', 'Internal Server Error. Please Try After Some Time.');
				redirect('groupadmin/profile');
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
