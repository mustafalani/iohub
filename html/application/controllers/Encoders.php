<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('max_execution_time', 600);
set_time_limit(0);
 error_reporting(E_ALL);
 ini_set('display_errors',1);
 require_once APPPATH.'third_party/phpseclib/Net/SSH2.php';
require APPPATH . 'libraries/REST_Controller.php';
class Encoders extends REST_Controller {

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
		$cleanData = json_decode(file_get_contents('php://input'),TRUE);
		if(!empty($cleanData['encoderId']))
		{
			$data = array(
				'uptime'=>$cleanData['uptime']
			);
			$isUpdated = $this->common_model->updateEncoderByItsEncoderId($data,$cleanData['encoderId']);
			if($isUpdated){
				echo "Encoder Time Updated Successfully!";
			}else{
				echo "Encoder Time Not Updated!";
			}
		}else{
			echo "Encoder Id is Null";
		}
	}
    public function update_post()
    {
		$cleanData = json_decode(file_get_contents('php://input'),TRUE);
		if(!empty($cleanData['encoderId']))
		{
			$data = array(
				'status'=>$cleanData['status']
			);
			$isUpdated = $this->common_model->updateEncoderByItsEncoderId($data,$cleanData['encoderId']);
			if($isUpdated){
				echo "Encoder Status Updated Successfully!";
			}else{
				echo "Encoder Status Not Updated!";
			}
		}else{
			echo "Encoder Id is Null";
		}
	}
	public function pairing_post()
	{
		$response = array('status'=>FALSE,'response'=>'');
		/* All Parametes From Request */
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$channelId = $cleanData['id'];
		$idArray = explode('_',$channelId);
		$encoder = $this->common_model->getAllEncoders($idArray[0],0);
		$ip =  $encoder[0]["encoder_ip"];
		$username = $encoder[0]["encoder_uname"];
		$password = $encoder[0]["encoder_pass"];
		$port = $encoder[0]["encoder_port"];;
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
			$res = $ssh->exec('$HOME/iohub/scripts/encoder-pair.sh '.site_url().' '.$encoder[0]["encoder_name"].' '.$encoder[0]["encoder_id"]);
			$response['status']= TRUE;
			$response['response']= $idArray[1];
			$response['responseserver']= $res;
			echo json_encode($response);
		}
	}
}
