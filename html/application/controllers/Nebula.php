<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	require_once 'application/libraries/Facebook/autoload.php';
	require_once 'application/third_party/google/vendor/autoload.php';
	require_once 'application/third_party/phpseclib/Net/SSH2.php';
	require_once("application/third_party/twitterAPI/TwitterAPIExchange.php");
	require_once("application/third_party/ssp.class.php");
	class Nebula extends CI_Controller {

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
	public function deletechannelgroup(){
		$response = array('status'=>FALSE);
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$action = $cleanData['action'];
		$groupId = $cleanData['groupname'];		
		if($action == "deletegroupandchannel"){
			$channelGroups = $this->common_model->getChannelGroupMappingByGroupId($groupId);
			if(sizeof($channelGroups)>0){
				foreach($channelGroups as $chanelgroup){
					$channelId = $chanelgroup['channelId'];
					$this->common_model->deleteChannel($channelId);
				}
			}
		}
		$this->common_model->deleteChannelGroupMapping($groupId);
		$this->common_model->deleteChannelGroup($groupId);
		$response['status'] = TRUE;
		echo json_encode($response);
	}	
	public function savechannelgroup(){
		$nebulas = array();$response = array('status'=>FALSE);
		$userdata = $this->session->userdata('user_data');		
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$data = array(
			'groupname'=>$cleanData['groupname'],
			'uid'=>$userdata['userid'],
			'status'=>1,
			'created_at'=>time()	
		);
		$id = $this->common_model->insertChannelGroups($data);
		if ($id>0) {
			$response['status'] = TRUE;
			echo json_encode($response);
		}
	}
	public function jobs()
	{
		$nebulas = array();
		$userdata = $this->session->userdata('user_data');
		if ($userdata['user_type'] == 1) {
			$nebulas = $this->common_model->getNebula(0);			
		}
		elseif($userdata['user_type'] == 2 || $userdata['user_type'] == 3)
		{
			$idsss = array($userdata['group_id']);
			$nebulas = $this->common_model->getNebula($idsss);			
		}
		$returnResponse = array('active_jobs'=>array(),'finished_jobs'=>array(),'failed_jobs'=>array());
		$returnResponse['active_jobs']['data'] = array();
		$returnResponse['finished_jobs']['data'] = array();
		$returnResponse['failed_jobs']['data'] = array();
		if (sizeof($nebulas)>0) {			
			foreach ($nebulas as $nebula) {
				//echo base64_encode($nebula['encoder_uname'].':'.$nebula['encoder_pass']);
				//$returnResponse['active_jobs']['encoder_name'] = $nebula['encoder_name'];
				//$returnResponse['finished_jobs']['encoder_name'] = $nebula['encoder_name'];
				//$returnResponse['failed_jobs']['encoder_name'] = $nebula['encoder_name'];
				
				$WURL = "https://".$nebula['encoder_ip'];
				$URL = $WURL."/login";
				$ch1 = curl_init();
				curl_setopt($ch1,CURLOPT_URL, $URL);
				curl_setopt($ch1, CURLOPT_POST, 1);
				curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch1,CURLOPT_POSTFIELDS, "login=".$nebula['encoder_uname']."&password=".$nebula['encoder_pass']."&api=1");
				curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type'=>'application/json'));
				
				$result = curl_exec($ch1);
				$jsonData = rtrim($result, "\0");
				$resultarray = json_decode($jsonData,TRUE);				
				curl_close($ch1);		
						
				$activejobs = curl_init();
				$fields = json_encode(array("object_type" =>'jobs','view'=>'active','session_id'=>$resultarray['session_id']));
				curl_setopt_array($activejobs, array(
				CURLOPT_URL => $WURL."/api/jobs",
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
				'Authorization: Bearer '.base64_encode($nebula['encoder_uname'].':'.$nebula['encoder_pass']),
				'Cookie: '.$_SERVER['HTTP_COOKIE']
				),
				));
				$allactiveJobs = curl_exec($activejobs);			
				$activejobs_data = json_decode($allactiveJobs,TRUE);	
				$err = curl_error($activejobs);
				curl_close($activejobs);				
				$finishedjobs = curl_init();
				$fields = json_encode(array("object_type" =>'jobs','view'=>'finished','session_id'=>$resultarray['session_id']));
				curl_setopt_array($finishedjobs, array(
				CURLOPT_URL => $WURL."/api/jobs",
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
				'Authorization: Bearer '.base64_encode($nebula['encoder_uname'].':'.$nebula['encoder_pass']),
				'Cookie: '.$_SERVER['HTTP_COOKIE']
				),
				));
				$allFinishJobs = curl_exec($finishedjobs);
				$finishjobs_data = json_decode($allFinishJobs,TRUE);
				$err = curl_error($finishedjobs);
				curl_close($finishedjobs);				
				$failedjobs = curl_init();
				$fields = json_encode(array("object_type" =>'jobs','view'=>'failed','session_id'=>$resultarray['session_id']));
				curl_setopt_array($failedjobs, array(
				CURLOPT_URL => $WURL."/api/jobs",
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
				'Authorization: Bearer '.base64_encode($nebula['encoder_uname'].':'.$nebula['encoder_pass']),
				'Cookie: '.$_SERVER['HTTP_COOKIE']
				),
				));
				$allFailedJobs = curl_exec($failedjobs);
				$faildejobs_data = json_decode($allFailedJobs,TRUE);
				$err = curl_error($failedjobs);
				curl_close($failedjobs);
				
				if (sizeof($activejobs_data['data'])>0)
				{
					foreach ($activejobs_data['data'] as $asset) {
						$curl = curl_init();
						$fields = json_encode(array("object_type" =>'asset','id_asset'=>(int)$asset['id_asset'],'objects'=>array((int)$asset['id_asset']),'session_id'=>$resultarray['session_id']));
						curl_setopt_array($curl, array(
						CURLOPT_URL => $WURL."/api/get",
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
						'Authorization: Bearer '.base64_encode($nebula['encoder_uname'].':'.$nebula['encoder_pass']),
						'Cookie: '.$_SERVER['HTTP_COOKIE']
						),
						));
						$response = curl_exec($curl);
						$clip = json_decode($response,TRUE);
						$clip['message'] = $asset['message'];
						$clip['progress'] = $asset['progress'];
						$clip['ctime'] = $asset['ctime'];
						$clip['stime'] = $asset['stime'];
						$clip['etime'] = $asset['etime'];
						$clip['id_action'] = $asset['id_action'];
						$clip['encoder_name'] = $nebula['encoder_name'];
						$returnResponse['active_jobs']['data'][] = $clip;
						$err = curl_error($curl);
						curl_close($curl);
					}					
				}	
				if (sizeof($finishjobs_data['data'])>0) {
					foreach ($finishjobs_data['data'] as $asset) {
						$curl = curl_init();
						$fields = json_encode(array("object_type" =>'asset','id_asset'=>(int)$asset['id_asset'],'objects'=>array((int)$asset['id_asset']),'session_id'=>$resultarray['session_id']));
						curl_setopt_array($curl, array(
						CURLOPT_URL => $WURL."/api/get",
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
						'Authorization: Bearer '.base64_encode($nebula['encoder_uname'].':'.$nebula['encoder_pass']),
						'Cookie: '.$_SERVER['HTTP_COOKIE']
						),
						));
						$response = curl_exec($curl);
						$clip = json_decode($response,TRUE);
						$clip['encoder_name'] = $nebula['encoder_name'];
						$clip['message'] = $asset['message'];
						$clip['progress'] = $asset['progress'];
						$clip['ctime'] = $asset['ctime'];
						$clip['stime'] = $asset['stime'];
						$clip['etime'] = $asset['etime'];
						$clip['id_action'] = $asset['id_action'];
						$returnResponse['finished_jobs']['data'][] = $clip;
						$err = curl_error($curl);
						curl_close($curl);
					}
				}
				if (sizeof($faildejobs_data['data'])>0) {
					foreach ($faildejobs_data['data'] as $asset) {
						$curl = curl_init();
						$fields = json_encode(array("object_type" =>'asset','id_asset'=>(int)$asset['id_asset'],'objects'=>array((int)$asset['id_asset']),'session_id'=>$resultarray['session_id']));
						curl_setopt_array($curl, array(
						CURLOPT_URL => $WURL."/api/get",
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
						'Authorization: Bearer '.base64_encode($nebula['encoder_uname'].':'.$nebula['encoder_pass']),
						'Cookie: '.$_SERVER['HTTP_COOKIE']
						),
						));
						$response = curl_exec($curl);
						$clip = json_decode($response,TRUE);
						$clip['encoder_name'] = $nebula['encoder_name'];
						$clip['message'] = $asset['message'];
						$clip['progress'] = $asset['progress'];
						$clip['ctime'] = $asset['ctime'];
						$clip['stime'] = $asset['stime'];
						$clip['etime'] = $asset['etime'];
						$clip['id_action'] = $asset['id_action'];
						$returnResponse['failed_jobs']['data'][] = $clip;
						$err = curl_error($curl);
						curl_close($curl);
					}
				}							
			}			
		}
		//print_r($returnResponse);
		$data['resp'] = $returnResponse;
		$this->load->view('admin/header');
		$this->load->view('admin/jobs',$data);
		$this->load->view('admin/footer');
	}
	public function updateRundownTitle(){
		$response = array('status'=>FALSE);
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$title = $cleanData['title'];		
		$data['title'] = $title;		
		$runid = explode('_',$cleanData['id']);
		$engine_previous = $this->common_model->getAllRundowns($runid[1]);
		$data['rundown_id'] = str_replace(' ','_',$cleanData['title']).'_'.$this->random_string(4);
		$sts = $this->common_model->updateRundown($data,$runid[1]);
		if($sts >=0){
			$response['status'] = TRUE;
			$engine = $this->common_model->getAllRundowns($runid[1]);
			if($engine[0]['engine_type'] == "encoder"){
				$runEngine = $this->common_model->getAllEncoders($engine[0]['engine_id']);
			}
			else if($engine[0]['engine_type'] == "nebula"){
				$runEngine = $this->common_model->getAllNebula($engine[0]['engine_id']);
			}
			
			$settins = curl_init();	
			$fields = json_encode(array('playlistid'=>$engine_previous[0]['rundown_id'],'newplaylistid'=>$engine[0]['rundown_id']));
			curl_setopt_array($settins, array(
			CURLOPT_URL => "http://".$runEngine[0]['encoder_ip'].":".$runEngine[0]['encoder_port']."/api/v1/playlist/config?playlistid=".$engine[0]['rundown_id'],
			  CURLOPT_RETURNTRANSFER => true, 
			  CURLOPT_CUSTOMREQUEST => "PUT",
			  CURLOPT_POSTFIELDS =>$fields,
			  CURLOPT_HTTPHEADER => array(
			    'Content-Type: application/json',
			    'Content-Length:'. strlen($fields),		    
			  ),
			));
			$httpcode = curl_getinfo($settins, CURLINFO_HTTP_CODE);
			$sesponse = curl_exec($settins);
			$set = json_decode($sesponse,TRUE);			
			$err = curl_error($settins);
			curl_close($settins);
		}
		echo json_encode($response);
	}
	public function deleteRundown(){
		$response = array('status'=>FALSE);
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		
		$engine = $this->common_model->getAllRundowns($cleanData['rundownid']);
		if($engine[0]['engine_type'] == "encoder"){
			$runEngine = $this->common_model->getAllEncoders($engine[0]['engine_id']);
		}
		else if($engine[0]['engine_type'] == "nebula"){
			$runEngine = $this->common_model->getAllNebula($engine[0]['engine_id']);
		}
		$settins = curl_init();	
		$fields = json_encode(array('playlistid'=>$engine[0]['rundown_id']));
		curl_setopt_array($settins, array(
		CURLOPT_URL => "http://".$runEngine[0]['encoder_ip'].":".$runEngine[0]['encoder_port']."/api/v1/playlist/config?playlistid=".$engine[0]['rundown_id'],
		  CURLOPT_RETURNTRANSFER => true, 
		  CURLOPT_CUSTOMREQUEST => "DELETE",
		  CURLOPT_POSTFIELDS =>$fields,
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Content-Length:'. strlen($fields),		    
		  ),
		));
		$httpcode = curl_getinfo($settins, CURLINFO_HTTP_CODE);
		$sesponse = curl_exec($settins);
		$set = json_decode($sesponse,TRUE);			
		$err = curl_error($settins);
		curl_close($settins);
		
		$this->common_model->deleteRundownClips($cleanData['rundownid']);
		$sts = $this->common_model->deleteRundown($cleanData['rundownid']);		
		if($sts > 0){
			
			
			$response['status'] = TRUE;
			$response['status_api'] = $sesponse;
		}
		echo json_encode($response);
	}
	public function lockRundown(){
		$response = array('status'=>FALSE);
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$data['isLocked'] =1;
		$sts = $this->common_model->updateRundown($data,$cleanData['rundownid']);
		if($sts >=0){
			$response['status'] = TRUE;
		}
		echo json_encode($response);
	}
	public function unLockRundown(){
		$response = array('status'=>FALSE);
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$data['isLocked'] =0;
		$sts = $this->common_model->updateRundown($data,$cleanData['rundownid']);
		if($sts >=0){
			$response['status'] = TRUE;
		}
		echo json_encode($response);
	}
	public function stopPlaylist(){
		$response = array();
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$rundownid = explode('_',$cleanData['rundownid']);
		$engine = $this->common_model->getAllRundowns($rundownid[1]);
		if($engine[0]['engine_type'] == "encoder"){
			$runEngine = $this->common_model->getAllEncoders($engine[0]['engine_id']);
		}
		else if($engine[0]['engine_type'] == "nebula"){
			$runEngine = $this->common_model->getAllNebula($engine[0]['engine_id']);
		}
		$settins = curl_init();	
		$fields = json_encode(array('playlistid'=>$engine[0]['rundown_id']));	
					
		curl_setopt_array($settins, array(
		CURLOPT_URL => "http://".$runEngine[0]['encoder_ip'].":".$runEngine[0]['encoder_port']."/api/v1/playlist/actions/stop",
		  CURLOPT_RETURNTRANSFER => true, 
		  CURLOPT_CUSTOMREQUEST => "PUT",
		  CURLOPT_POSTFIELDS =>$fields,
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Content-Length:'. strlen($fields),		    
		  ),
		));
		$httpcode = curl_getinfo($settins, CURLINFO_HTTP_CODE);
		$sesponse = curl_exec($settins);
		$set = json_decode($sesponse,TRUE);			
		$err = curl_error($settins);		
		curl_close($settins);		
		if($set == "playlist stopeed"){
			echo json_encode(array('status'=>TRUE,'message'=>'Playlist Stoped'));	
		}else{
			echo json_encode(array('status'=>FALSE,'message'=>'Internal Server Error!'));
		}
		
	}
	public function startPlaylist(){
		$response = array();
		$isOnline = FALSE;
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$rundownid = explode('_',$cleanData['rundownid']);
		$engine = $this->common_model->getAllRundowns($rundownid[1]);
		if($engine[0]['engine_type'] == "encoder"){
			$runEngine = $this->common_model->getAllEncoders($engine[0]['engine_id']);
		}
		else if($engine[0]['engine_type'] == "nebula"){
			$runEngine = $this->common_model->getAllNebula($engine[0]['engine_id']);
		}
		$settins = curl_init();	
		$fields = json_encode(array('playlistid'=>$engine[0]['rundown_id']));
		curl_setopt_array($settins, array(
		CURLOPT_URL => "http://".$runEngine[0]['encoder_ip'].":".$runEngine[0]['encoder_port']."/api/v1/playlist/actions/start",
		  CURLOPT_RETURNTRANSFER => true, 
		  CURLOPT_CUSTOMREQUEST => "PUT",
		  CURLOPT_POSTFIELDS =>$fields,
		  CURLOPT_HTTPHEADER => array(
		    'Content-Type: application/json',
		    'Content-Length:'. strlen($fields),		    
		  ),
		));
		$httpcode = curl_getinfo($settins, CURLINFO_HTTP_CODE);
		$sesponse = curl_exec($settins);
		$set = json_decode($sesponse,TRUE);			
		$err = curl_error($settins);
		
		curl_close($settins);
		
		
		
		
		if($set == "playlist started"){
			
			$fields = json_encode(array('playlistid'=>$engine[0]['rundown_id']));	
			$playlist = curl_init();	
			curl_setopt_array($playlist, array(
			CURLOPT_URL => "http://".$runEngine[0]['encoder_ip'].":".$runEngine[0]['encoder_port']."/api/v1/playlist/status?playlistid=".$engine[0]['rundown_id'],
			  CURLOPT_RETURNTRANSFER => TRUE,
			  CURLOPT_SSL_VERIFYPEER=>FALSE,
			  CURLOPT_CUSTOMREQUEST=>'GET',
			  CURLOPT_HTTP_VERSION =>CURL_HTTP_VERSION_1_1,
			  CURLOPT_FOLLOWLOCATION=>TRUE,
			  CURLOPT_POSTFIELDS =>$fields,
			  CURLOPT_HTTPHEADER => array('Content-Type: application/json')
			));
			$httpcode = curl_getinfo($playlist, CURLINFO_HTTP_CODE);
			$sesponse = curl_exec($playlist);
				
			$set = json_decode($sesponse,TRUE);		
			curl_close($playlist);			
			$data['OnlineIndex'] = -5;
			if($sesponse != "" && strpos($sesponse, "Index") !== false){				
				$isOnline = true;
			}
			elseif($sesponse == "Offline"){
				$isOnline = FALSE;
			}
			
			echo json_encode(array('status'=>TRUE,'message'=>'Playlist Running','isOnline'=>$isOnline));	
		}else{
			echo json_encode(array('status'=>FALSE,'message'=>'Internal Server Error!'));
		}
		
	}
	public function downloadPlaylist(){		

		$rundown_id = $this->uri->segment(3);
		$engine = $this->common_model->getAllRundowns($rundown_id);
		$clips = $this->common_model->getAllRundownClips($rundown_id);	
		$cntr = 0;
		$items = array();
		foreach ($clips as $cid) {
			array_push($items,array('begin'=>"0:00:00.000","duration"=>$cid['clip_duration'],"in"=>0,"out"=>$cid['clip_duration'],"source"=>$engine[0]['parh_setting'] .$cid['path']));
			$cntr++;		
		}
		$json = json_encode(array(
				'channel'=>$engine[0]['rundown_id'],
				'date'=>date('Y-m-d'),
				'program'=>$items
			),JSON_NUMERIC_CHECK);
		header('Content-disposition: attachment; filename=playlist.json');
		header('Content-type: application/json');
		echo $json;
	}
	public function saveRundownList(){
		$response = array();
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$cids = explode("|",$cleanData['clipids']);
		$loops = explode("|",$cleanData['loops']);
		$paths = explode("|",$cleanData['paths']);
		$stime = explode("|",$cleanData['stime']);
		$items = array();
		if(sizeof($cids)>0)
		{
			$this->common_model->deleteRundownClips($cleanData['rundownid']);
			$cntr = 0;
			$engine = $this->common_model->getAllRundowns($cleanData['rundownid']);
			if ($engine[0]['engine_type'] == "encoder") {
				$runEngine = $this->common_model->getAllEncoders($engine[0]['engine_id']);
			} else if ($engine[0]['engine_type'] == "nebula") {
				$runEngine = $this->common_model->getAllNebula($engine[0]['engine_id']);
			}
			foreach($cids as $cid){
				$cid_duration = explode('-',$cid);
				$clip = array(
					'rundown_id'=>$cleanData['rundownid'],
					'clip_id'=>$cid_duration[0],
					'clip_duration'=>$cid_duration[1],
					'loop'=>($loops[$cntr] == "") ? "--" : $loops[$cntr],
					'path'=>$paths[$cntr],
					'start_time'=>$stime[$cntr],
					'created_at'=>time(),
					'updated_at'=>time()
				);
				$out = ((($loops[$cntr] == "") ? 0 : $loops[$cntr]) + 1) * $cid_duration[1];
				array_push($items,array('begin'=>"0:00:00.000","duration"=>$cid_duration[1],"in"=>$stime[$cntr],"out"=>$out,"source"=>$runEngine[0]['parh_setting'] .$paths[$cntr]));
				$cntr++;
				$this->common_model->insertRundownClips($clip);
			}
			
			$settins = curl_init();	
			$fields = json_encode(array(
				'playlistid'=>$engine[0]['rundown_id'],
				'items'=>array(
					'channel'=>$engine[0]['rundown_id'],
					'date'=>date('Y-m-d'),
					'program'=>$items
				)
			),JSON_NUMERIC_CHECK);
			
			curl_setopt_array($settins, array(
			CURLOPT_URL => "http://".$runEngine[0]['encoder_ip'].":".$runEngine[0]['encoder_port']."/api/v1/playlist/items",
			  CURLOPT_RETURNTRANSFER => true, 
			  CURLOPT_CUSTOMREQUEST => "PUT",
			  CURLOPT_POSTFIELDS =>$fields,
			  CURLOPT_HTTPHEADER => array(
			    'Content-Type: application/json',
			    'Content-Length:'. strlen($fields),		    
			  ),
			));
			$httpcode = curl_getinfo($settins, CURLINFO_HTTP_CODE);
			$sesponse = curl_exec($settins);
			$set = json_decode($sesponse,TRUE);			
			$err = curl_error($settins);
			curl_close($settins);
			
			echo json_encode(array('status'=>TRUE,'message'=>'Saved Successfully'));
		}
	}
	public function temp(){
		$this->load->view('admin/header');
		$this->load->view('admin/temp');
		$this->load->view('admin/footer');
	}
	public function editrundown(){
		$data = array();
		$rundownid = $this->uri->segment(2);
		$engine = $this->common_model->getAllRundowns($rundownid);
		if($engine[0]['engine_type'] == "encoder"){
			$runEngine = $this->common_model->getAllEncoders($engine[0]['engine_id']);
		}
		else if($engine[0]['engine_type'] == "nebula"){
			$runEngine = $this->common_model->getAllNebula($engine[0]['engine_id']);
		}
		$data['rundwon'] = $engine;
		$data['clips'] = $this->common_model->getAllRundownClips($rundownid);	
		
		// Check Playlist Status
		//echo "https://".$runEngine[0]['encoder_ip'].":".$runEngine[0]['encoder_port']."/api/v1/playlist/status?playlistid=".$engine[0]['rundown_id'];
		
		$fields = json_encode(array('playlistid'=>$engine[0]['rundown_id']));	
		$playlist = curl_init();	
		curl_setopt_array($playlist, array(
		CURLOPT_URL => "http://".$runEngine[0]['encoder_ip'].":".$runEngine[0]['encoder_port']."/api/v1/playlist/status?playlistid=".$engine[0]['rundown_id'],
		  CURLOPT_RETURNTRANSFER => TRUE,
		  CURLOPT_SSL_VERIFYPEER=>FALSE,
		  CURLOPT_CUSTOMREQUEST=>'GET',
		  CURLOPT_HTTP_VERSION =>CURL_HTTP_VERSION_1_1,
		  CURLOPT_FOLLOWLOCATION=>TRUE,
		  CURLOPT_POSTFIELDS =>$fields,
		  CURLOPT_HTTPHEADER => array('Content-Type: application/json')
		));
		$httpcode = curl_getinfo($playlist, CURLINFO_HTTP_CODE);
		$sesponse = curl_exec($playlist);
			//	echo $sesponse;
		$set = json_decode($sesponse,TRUE);		
		curl_close($playlist);
		$data['isOnline'] = FALSE;
		$data['OnlineIndex'] = -5;
		$data['currentIndestime'] = "";
		$data['currentIndesPos'] =0;
		if($sesponse != "" && strpos($sesponse, "Index") !== false){
			$settingArray = explode("Index",$sesponse);
			$currentTIME = str_replace('[INFO]',"",$settingArray[0]);
			$currentTIME = str_replace('["Online","[',"",$currentTIME);
			$currentTIME = str_replace(']',"",$currentTIME);
			
			$currentTIMEAR = explode(",",$currentTIME);;			
			
			$settingArray_one = explode("Node",$settingArray[1]);			
			$index = str_replace('\"',"",$settingArray_one[0]);
			$index = str_replace(":","",$index);
			$data['isOnline'] = true;
			$data['OnlineIndex'] = $index;
			$data['currentIndestime'] = trim($currentTIMEAR[0]);
			$data['currentIndesPos'] = trim($currentTIMEAR[1]);
		}
		elseif($sesponse == "Offline"){
			$data['isOnline'] = FALSE;
		}
			
		$WURL = "https://".$runEngine[0]['encoder_ip'];
		$data['wuname'] = $runEngine[0]['encoder_uname'];
		$data['wpass'] = $runEngine[0]['encoder_pass'];
			$URL = $WURL."/login";			
			$ch1 = curl_init();	
			curl_setopt($ch1,CURLOPT_URL, $URL);	
			curl_setopt($ch1, CURLOPT_POST, 1);	
			curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);	
			curl_setopt($ch1,CURLOPT_POSTFIELDS, "login=".$runEngine[0]['encoder_uname']."&password=".$runEngine[0]['encoder_pass']."&api=1");
			curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type'=>'application/json'));			
			
			$result = curl_exec($ch1);				
			$jsonData = rtrim($result, "\0");		
			$resultarray = json_decode($jsonData,TRUE);				
			curl_close($ch1);
		
			$settins = curl_init();
			$fields = json_encode(array('session_id'=>$resultarray['session_id']));
			curl_setopt_array($settins, array(
			  CURLOPT_URL => $WURL."/api/settings",
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
				'Authorization: Bearer '.base64_encode($runEngine[0]['encoder_uname'].':'.$runEngine[0]['encoder_pass']),
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
			  CURLOPT_URL => $WURL."/api/get",
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
				'Authorization: Bearer '.base64_encode($runEngine[0]['encoder_uname'].':'.$runEngine[0]['encoder_pass']),
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
			  CURLOPT_URL => $WURL."/api/get",
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
				'Authorization: Bearer '.base64_encode($runEngine[0]['encoder_uname'].':'.$runEngine[0]['encoder_pass']),
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
			  CURLOPT_URL => $WURL."/api/get",
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
				'Authorization: Bearer '.base64_encode($runEngine[0]['encoder_uname'].':'.$runEngine[0]['encoder_pass']),
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
			  CURLOPT_URL => $WURL."/api/get",
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
				'Authorization: Bearer '.base64_encode($runEngine[0]['encoder_uname'].':'.$runEngine[0]['encoder_pass']),
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
			  CURLOPT_URL => $WURL."/api/get",
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
				'Authorization: Bearer '.base64_encode($runEngine[0]['encoder_uname'].':'.$runEngine[0]['encoder_pass']),
			    'Cookie: '.$_SERVER['HTTP_COOKIE']
			  ),
			));
			$commercialresponse = curl_exec($commercial);
			$commercialAssets = json_decode($commercialresponse,TRUE);
			$data['commercial'] = $commercialAssets;
			$data['RUNDOWN_URL'] = $WURL;
			$err = curl_error($commercial);
			curl_close($commercial);	
			
		
			
		$this->load->view('admin/header');
		$this->load->view('admin/editrundown',$data);
		$this->load->view('admin/footer');
	}
	public function getAssets(){
		
		$response = array();
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$nebula = $this->common_model->getNebulabyId($cleanData['nid']);	
		$URL_SERVER = 	"https://".$nebula[0]['encoder_ip'];
		//echo $URL_SERVER;
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
		$id_view = 0;
		$assetType = $cleanData['assetType'];
		$assetType = str_replace("#","",$assetType);
		switch($assetType){			
			case "main":
			$id_view = 1;
			break;
			case "fill":
			$id_view = 2;
			break;
			case "music":
			$id_view = 3;
			break;
			case "stories":
			$id_view = 4;
			break;
			case "commercial":
			$id_view = 5;
			break;
			case "incoming":
			$id_view = 52;
			break;
			case "archive":
			$id_view = 51;
			break;
			case "trash":
			$id_view = 50;
			break;
		}
		$main = curl_init();
		$fields = json_encode(array("object_type" =>'asset','id_view'=>$id_view,'session_id'=>$resultarray['session_id']));
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
		$response['data'] = $mainresponse;
		$response['KURRENTTV_BASE_URL'] = $URL_SERVER;
		$err = curl_error($main);
		curl_close($main);
		echo json_encode($response);
	}
	public function createrundown(){
		
		$data = array();
		$userdata = $this->session->userdata('user_data');
		if($userdata['user_type'] == 1)
		{				
			$data['encoders'] = $this->common_model->getAllEncoders(0,0);	
			$data['nebula'] = $this->common_model->getNebula(0);			
		}
		elseif($userdata['user_type'] == 2 || $userdata['user_type'] == 3)
		{			
			$data['encoders'] = $this->Groupadmin_model->getAllEncodersbyUserIdAndGroupId($userdata['userid'],$userdata['group_id']);			$data['nebula'] = $this->common_model->getNebula($userdata['group_id']);	
		}
		$this->load->view('admin/header');
		$this->load->view('admin/createrundown',$data);
		$this->load->view('admin/footer');
	}
	public function saveRundown(){
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$rundown = array();
		$rundown['title'] = $cleanData['title'];
		$endingids = explode('_',$cleanData['engine_id']);
		$rundown['engine_id'] = $endingids[1];
		$rundown_id = "";
		
		$rundown_id = str_replace(' ','_',$cleanData['title']).'_'.$this->random_string(4);
		$encoder = $this->common_model->getAllEncoders($cleanData['engine_id'],0);
		if(sizeof($encoder)>0)
		{
			//$rundown_id = $rundown_id.'_'.$encoder[0]['encoder_id'];
		}
		$rundown['rundown_id'] = $rundown_id;		
		$rundown['is_scheduled'] = $cleanData['is_scheduled'];
		$rundown['start_time'] = $cleanData['rundown_starttime'];
		$rundown['end_time'] = $cleanData['rundown_endtime'];
		$rundown['duration'] = '00:00:00:00';
		$rundown['engine_type'] = $endingids[0];
		$rundown['status'] = 0;
		$rundown['created_at'] = time();
		$rundown['updated_at'] = time();
		$id = $this->common_model->insertRundown($rundown);
		if($id > 0)
		{
			if($endingids[0] == "encoder"){
				$runEngine = $this->common_model->getAllEncoders($endingids[1]);
			}
			else if($endingids[0] == "nebula"){
				$runEngine = $this->common_model->getAllNebula($endingids[1]);
			}
			$settins = curl_init();
			$fields = json_encode(array('playlistid'=>$rundown_id));
			echo "http://".$runEngine[0]['encoder_ip'].":".$runEngine[0]['encoder_port']."/api/v1/playlist/config";
			curl_setopt_array($settins, array(
			CURLOPT_URL => "http://".$runEngine[0]['encoder_ip'].":".$runEngine[0]['encoder_port']."/api/v1/playlist/config",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,			 
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS =>$fields,
			  CURLOPT_HTTPHEADER => array(
			    'Content-Type: application/json',
			    'Content-Length:'. strlen($fields)			    
			  ),
			));
			$sesponse = curl_exec($settins);
			//echo $sesponse;
			//die;
			$set = json_decode($sesponse,TRUE);			
			$err = curl_error($settins);
			curl_close($settins);	
			$this->session->set_flashdata('message_type', 'success');
			$this->session->set_flashdata('success', 'Rundown saved successfully!');
			redirect('editrundown/'.$id);
		}
	}
	public function editasset(){
		
		$data = array();
		$id = $this->uri->segment(2);
		$nebulaId = $this->uri->segment(3);		
		$userdata = $this->session->userdata('user_data');
		$data['userdata'] = $this->session->userdata('user_data');			
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
		
		$curl = curl_init();
		$fields = json_encode(array("object_type" =>'asset','id_asset'=>(int)$id,'objects'=>array((int)$id),'session_id'=>$resultarray['session_id']));		
		  curl_setopt_array($curl, array(
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

		$response = curl_exec($curl);
		$err = curl_error($curl);				
		curl_close($curl);
		$data['data'] = json_decode($response,TRUE);
		$data['URL'] = $URL_SERVER;
		$this->load->view('admin/header');
		$this->load->view('admin/editassets',$data);
		$this->load->view('admin/footer');
	}
	public function updateAssets(){
			
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
			if($key != "assetid" && $key != "accesskey")
			{
				$flds[$key] = $d;	
			}
			
		}
		$fields = json_encode(array("object_type" =>'asset','id_asset'=>(int)$cleanData['assetid'],'objects'=>array((int)$cleanData['assetid']),'data'=>$flds,'session_id'=>$resultarray['session_id']));		
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
	function random_string($length)
		{
		    $key = '';
		    $keys = array_merge(range(0, 9), range('a', 'z'));

		    for ($i = 0; $i < $length; $i++) {
		        $key .= $keys[array_rand($keys)];
		    }

		    return $key;
		}
}
