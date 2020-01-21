<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	require_once 'application/third_party/phpseclib/Net/SSH2.php';
	require_once("application/third_party/ssp.class.php");
	class Diverse extends CI_Controller {

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
