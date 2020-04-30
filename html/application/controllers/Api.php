<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ini_set('max_execution_time', 600);
set_time_limit(0);
 error_reporting(E_ALL);
 ini_set('display_errors',1);
 require_once APPPATH.'third_party/phpseclib/Net/SSH2.php';
require APPPATH . 'libraries/REST_Controller.php';
class Api extends REST_Controller {

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
		$this->load->model("Common_model");
		$this->load->model("User_model");
    }
    public function getChartData_get()
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
    public function getCharts_get()
	{

		$URLlink = $_GET['URL'];
		//echo $URLlink;
		$URL = "http://152.115.45.135:19999".$URLlink;

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
    public function getIncomingStreamsInstances_post()
    {
    	$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$appLiveSourceID = $cleanData['id'];
		$appids = explode('_',$appLiveSourceID);
		$application = $this->Common_model->getAppbyId($appids[0]);
		$wowza = $this->Common_model->getWovzData($application[0]['live_source']);

		$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.$application[0]['application_name'].'/instances/_definst_/incomingstreams/'.$appids[1].'/monitoring/current';

		$xmlData = file_get_contents($url);
		$data['xml'] = $xmlData;
		$xml = simplexml_load_string($xmlData);
		$stats = json_encode($xml);
		$statArray = json_decode($stats,TRUE);
		echo json_encode($statArray);
	}
    public function showdevicelist_post()
    {
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$cid = $cleanData['id'];
		$id = explode("_",$cid);
		$encoder = $this->Common_model->getAllEncoders($id[1],0);
		if(sizeof($encoder)>0)
		{
			$ip = $encoder[0]['encoder_ip'];
			$port = $encoder[0]['encoder_port'];
			$username = $encoder[0]['encoder_uname'];
			$password = $encoder[0]['encoder_pass'];
			$ssh = new Net_SSH2($ip);
			if ($ssh->login($username, $password,$port)) {
				//$output = $ssh->exec("./iohub/bm_sdk/Linux/Samples/DeviceList/DeviceList");
				$output = $ssh->exec("./iohub/config/decklink/DeviceConfigure/DeviceConfigure");

		        echo json_encode(array('data'=>$output,'status'=>TRUE));
			}
			else
			{
				echo json_encode(array('data'=>'Not Connected!','status'=>FALSE));
			}
		}
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
    public function removeJob($job = '') {
        if ($this->doesJobExist($job)) {
            $jobs = $this->getJobs();
            unset($jobs[array_search($job, $jobs)]);

            return $this->saveJobs($jobs);
        } else {
            return false;
        }
    }
    private function stringToArray($jobs = '') {
	    $array = explode("\n", trim($jobs)); // trim() gets rid of the last \r\n
	    foreach ($array as $key => $item) {
	        if ($item == '') {
	            unset($array[$key]);
	        }
    	}
    	return $array;
    }
    function arrayToString($jobs = array()) {
        $string = implode("\n", $jobs);
        return $string;
    }
    public function scheduleLockUnlock_post()
    {
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
			$sts = $this->Common_model->updateSchedules($data,$idarray[1]);
			if($sts >=0)
			{
				$response['status'] = TRUE;
				$response['response'] = $action." Successfully!";
			}
			else
			{
				$response['status'] = TRUE;
				$response['response'] = "Error occured while ".$action."ing schedule!";
			}
		}
		echo json_encode($response);
	}
    public function scheduleActions_post()
	{
		$sts = FALSE;
		$response = array('status'=>FALSE,'response'=>array());
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$schId = $cleanData['id'];
		$action = $cleanData['action'];
		switch($action){
			case "Lock":
			if(sizeof($schId)>0)
			{
				foreach($schId as $sid)
				{
					$data = array(
						'isLocked'=>1
					);
					$bankID = $this->Common_model->updateSchedules($data,$sid);
					if($bankID >= 0)
					{
						$response['response'][$sid]['status'] = TRUE;
						$response['response'][$sid]['change'] = "Lock";
					}
					else
					{
						$response['response'][$sid]['status'] = FALSE;
						$response['response'][$sid]['change'] = "UnLock";
					}
				}
			}
			break;
			case "UnLock":
			if(sizeof($schId)>0)
			{
				foreach($schId as $sid)
				{
					$data = array(
						'isLocked'=>0
					);
					$bankID = $this->Common_model->updateSchedules($data,$sid);
					if($bankID >= 0)
					{
						$response['response'][$sid]['status'] = TRUE;
						$response['response'][$sid]['change'] = "UnLock";
					}
					else
					{
						$response['response'][$sid]['status'] = false;
						$response['response'][$sid]['change'] = "Lock";
					}
				}
			}
			break;
			case "Refresh":
			if(sizeof($schId)>0)
			{
					foreach($schId as $sid)
					{

					}
				}
			break;
			case "Delete":
			if(sizeof($schId)>0)
			{

					foreach($schId as $sid)
					{
						$jobs = $this->getJobs();
						$schdeule = $this->Common_model->getAllSchedules($sid);
						$jobStart = $schdeule[0]['start_job'];
						$jobStop = $schdeule[0]['stop_job'];
						$this->removeJob($jobStart);
						$this->removeJob($jobStop);

						if($schdeule[0]['schedule_type'] == "channel")
						{
							$update = array(
								'is_scheduled'=>0,
								'startdate'=>NULL,
								'enddate'=>NULL
							);
							$s = $this->Common_model->updateChannels($update,$schdeule[0]['sid']);
						}
						elseif($schdeule[0]['schedule_type'] == "target")
						{
							$update = array(
								'enableTargetSchedule'=>0,
								'start_date'=>NULL,
								'end_date'=>NULL
							);
							$s = $this->Common_model->updateTarget($schdeule[0]['sid'],$update);
						}
						$sts = $this->Common_model->deleteSchedules($sid);
						if($sts > 0)
						{
							$this->delete_file_by_FTP("/home/ksm/scheduler/".$schdeule[0]['start_filename']);
							$this->delete_file_by_FTP("/home/ksm/scheduler/".$schdeule[0]['stop_filename']);
							//unlink("/home/ksm/scheduler/".$schdeule[0]['start_filename']);
							//unlink("/home/ksm/scheduler/".$schdeule[0]['stop_filename']);
							$response['response'][$sid]['status'] = TRUE;
							$response['response'][$sid]['response'] = $action." Successfully!";
						}
						else
						{
							$response['response'][$sid]['status'] = FALSE;
							$response['response'][$sid]['response'] = "Error occure while ".$action." wowza!";
						}
					}
				}
			break;
		}
		echo json_encode($response);
	}
    public function scheduledelete_post()
    {
		$response = array('status'=>FALSE,'response'=>array(),'message'=>"");
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$id = $cleanData['schId'];
		$idArray = explode('_',$id);

		$jobs = $this->getJobs();


		$schdeule = $this->Common_model->getAllSchedules($idArray[1]);
		$jobStart = $schdeule[0]['start_job'];
		$jobStop = $schdeule[0]['stop_job'];
		$this->removeJob($jobStart);
		$this->removeJob($jobStop);

		if($schdeule[0]['schedule_type'] == "channel")
		{
			$update = array(
				'is_scheduled'=>0,
				'startdate'=>NULL,
				'enddate'=>NULL
			);
			$s = $this->Common_model->updateChannels($update,$schdeule[0]['sid']);
		}
		elseif($schdeule[0]['schedule_type'] == "target")
		{
			$update = array(
				'enableTargetSchedule'=>0,
				'start_date'=>NULL,
				'end_date'=>NULL
			);
			$s = $this->Common_model->updateTarget($schdeule[0]['sid'],$update);
		}

		$sts = $this->Common_model->deleteSchedules($idArray[1]);

		if($sts >=0)
		{
			//unlink("/home/ksm/scheduler/".$schdeule[0]['start_filename']);
			//unlink("/home/ksm/scheduler/".$schdeule[0]['stop_filename']);
			$this->delete_file_by_FTP("/home/ksm/scheduler/".$schdeule[0]['start_filename']);
			$this->delete_file_by_FTP("/home/ksm/scheduler/".$schdeule[0]['stop_filename']);

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
	public function updateScheduleTarget_post()
	{
		$response = array('status'=>FALSE,'response'=>array(),'message'=>"");
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$id = $cleanData['id'];
		$target = $this->Common_model->getTargetbyId($id);
		if(sizeof($target)>0)
		{
			$sid = $cleanData['sid'];
			$jobs = $this->getJobs();
			$schdeule = $this->Common_model->getAllSchedules($sid);
			$jobStart = $schdeule[0]['start_job'];
			$jobStop = $schdeule[0]['stop_job'];
			$this->removeJob($jobStart);
			$this->removeJob($jobStop);

			//unlink("/home/ksm/scheduler/".$schdeule[0]['start_filename']);
			//unlink("/home/ksm/scheduler/".$schdeule[0]['stop_filename']);
			$this->delete_file_by_FTP("/home/ksm/scheduler/".$schdeule[0]['start_filename']);
			$this->delete_file_by_FTP("/home/ksm/scheduler/".$schdeule[0]['stop_filename']);

			$processname = $id.'_'.$this->random_string(10);;
			$startname = "Target_Start_".$processname.".sh";
			$stopname = "Target_Stop_".$processname.".sh";
			$starttime = $this->getDateTime($cleanData['stime']);
			$stoptime = $this->getDateTime($cleanData['etime']);
			$startfile =  $starttime["m"].' '.$starttime["h"].' '.$starttime["day"].' '.$starttime["month"].' * /home/ksm/scheduler/'.$startname;
			$stopfile = $stoptime["m"].' '.$stoptime["h"].' '.$stoptime["day"].' '.$stoptime["month"].' * /home/ksm/scheduler/'.$stopname;

			$dataS = array(

				'start_datetime'=>$cleanData['stime'],
				'end_datetime'=>$cleanData['etime'],
				'created'=>time(),
				'start_job'=>$startfile,
				'stop_job'=>$stopfile,
				'start_filename'=>$startname,
				'stop_filename'=>$stopname
			);
			$sts = $this->Common_model->updateSchedule($dataS,$sid);
			if($sts)
			{
				$dataC = array(
					'enableTargetSchedule'=>1,
					'start_date'=>$cleanData['stime'],
					'end_date'=>$cleanData['etime'],
				);
				$this->Common_model->updateTarget($id,$dataC);

				$ip = $this->config->item('ServerIP');
				$username = $this->config->item('ServerUser');
				$password = $this->config->item('ServerPassword');
				$port = '22';
				$ssh = new Net_SSH2($ip);
				if ($ssh->login($username, $password,$port)) {


					$ssh->exec("touch /home/ksm/scheduler/".$startname);
					$ssh->exec("chmod +x /home/ksm/scheduler/".$startname);

					$ssh->exec('echo "curl -H  \'Content-Type: application/json\'  --data \'{\"process\":\"'.$processname.'\"}\'  https://iohub.tv/api/startTarget >> /home/ksm/scheduler/"'.$processname.'".log" >>  /home/ksm/scheduler/'.$startname);
					$ssh->exec('echo "echo \"----------------------------------------------\" >> /home/ksm/scheduler/"'.$processname.'".log" >>  /home/ksm/scheduler/'.$startname);

					$ssh->exec("touch /home/ksm/scheduler/".$stopname);
					$ssh->exec("chmod +x /home/ksm/scheduler/".$stopname);
					$ssh->exec('echo "curl -H  \'Content-Type: application/json\'  --data \'{\"process\":\"'.$processname.'\"}\'  https://iohub.tv/api/StopTarget >> /home/ksm/scheduler/"'.$processname.'".log" >>  /home/ksm/scheduler/'.$stopname);
					$ssh->exec('echo "echo \"----------------------------------------------\" >> /home/ksm/scheduler/"'.$processname.'".log" >>  /home/ksm/scheduler/'.$stopname);

					$ssh->exec('(crontab -l; echo "'.$starttime["m"].' '.$starttime["h"].' '.$starttime["day"].' '.$starttime["month"].' * /home/ksm/scheduler/'.$startname.'") | crontab -');
					$ssh->exec('(crontab -l; echo "'.$stoptime["m"].' '.$stoptime["h"].' '.$stoptime["day"].' '.$stoptime["month"].' * /home/ksm/scheduler/'.$stopname.'") | crontab -');
				}
				$dataS['title'] = $target[0]['target_name'];
				$dataS['id'] = $sid;
				$response['status'] = TRUE;
				$response['message'] = "Scheduled Update Successfully!";
				$response['response'] = $dataS;
			}

		}
		echo json_encode($response);
	}
    public function saveTargetSchedule_post()
    {
    	$userdata = $this->session->userdata('user_data');
		$response = array('status'=>FALSE,'response'=>array(),'message'=>"");
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$id = $cleanData['id'];
		$target = $this->Common_model->getTargetbyId($id);
		if(sizeof($target)>0)
		{
			$processname = $id.'_'.$this->random_string(10);;
			$startname = "Target_Start_".$processname.".sh";
			$stopname = "Target_Stop_".$processname.".sh";
			$starttime = $this->getDateTime($cleanData['stime']);
			$stoptime = $this->getDateTime($cleanData['etime']);
			$startfile =  $starttime["m"].' '.$starttime["h"].' '.$starttime["day"].' '.$starttime["month"].' * /home/ksm/scheduler/'.$startname;
			$stopfile = $stoptime["m"].' '.$stoptime["h"].' '.$stoptime["day"].' '.$stoptime["month"].' * /home/ksm/scheduler/'.$stopname;

			$dataS = array(
				'schedule_type'=>'target',
				'type'=>$target[0]['target'],
				'sid'=>$cleanData['id'],
				'start_datetime'=>$cleanData['stime'],
				'end_datetime'=>$cleanData['etime'],
				'status'=>1,
				'created'=>time(),
				'start_job'=>$startfile,
				'stop_job'=>$stopfile,
				'start_filename'=>$startname,
				'stop_filename'=>$stopname,
				'uid'=>$userdata['userid']
			);
			$sts = $this->Common_model->insertSchedule($dataS);
			if($sts)
			{
				$dataC = array(
					'enableTargetSchedule'=>1,
					'start_date'=>$cleanData['stime'],
					'end_date'=>$cleanData['etime'],
				);
				$this->Common_model->updateTarget($id,$dataC);

				$ip = $this->config->item('ServerIP');
				$username = $this->config->item('ServerUser');
				$password = $this->config->item('ServerPassword');
				$port = '22';
				$ssh = new Net_SSH2($ip);
				if ($ssh->login($username, $password,$port)) {


					$ssh->exec("touch /home/ksm/scheduler/".$startname);
					$ssh->exec("chmod +x /home/ksm/scheduler/".$startname);

					$ssh->exec('echo "curl -H  \'Content-Type: application/json\'  --data \'{\"process\":\"'.$processname.'\"}\'  https://iohub.tv/api/startTarget >> /home/ksm/scheduler/"'.$processname.'".log" >>  /home/ksm/scheduler/'.$startname);
					$ssh->exec('echo "echo \"----------------------------------------------\" >> /home/ksm/scheduler/"'.$processname.'".log" >>  /home/ksm/scheduler/'.$startname);

					$ssh->exec("touch /home/ksm/scheduler/".$stopname);
					$ssh->exec("chmod +x /home/ksm/scheduler/".$stopname);
					$ssh->exec('echo "curl -H  \'Content-Type: application/json\'  --data \'{\"process\":\"'.$processname.'\"}\'  https://iohub.tv/api/StopTarget >> /home/ksm/scheduler/"'.$processname.'".log" >>  /home/ksm/scheduler/'.$stopname);
					$ssh->exec('echo "echo \"----------------------------------------------\" >> /home/ksm/scheduler/"'.$processname.'".log" >>  /home/ksm/scheduler/'.$stopname);

					 $ssh->exec('(crontab -l; echo "'.$starttime["m"].' '.$starttime["h"].' '.$starttime["day"].' '.$starttime["month"].' * /home/ksm/scheduler/'.$startname.'") | crontab -');
					 $ssh->exec('(crontab -l; echo "'.$stoptime["m"].' '.$stoptime["h"].' '.$stoptime["day"].' '.$stoptime["month"].' * /home/ksm/scheduler/'.$stopname.'") | crontab -');

				}
				$dataS['title'] = $target[0]['target_name'];
				$dataS['id'] = $sts;
				$response['status'] = TRUE;
				$response['message'] = "Target Scheduled Successfully!";
				$response['response'] = $dataS;
			}

		}
		echo json_encode($response);
	}
	public function updateScheduleChannel_post()
    {
		$response = array('status'=>FALSE,'response'=>array(),'message'=>"");
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$id = $cleanData['id'];
		$channel = $this->Common_model->getChannelbyId($id);

		if(sizeof($channel)>0)
		{
			$sid = $cleanData['sid'];
			$jobs = $this->getJobs();
			$schdeule = $this->Common_model->getAllSchedules($sid);
			$jobStart = $schdeule[0]['start_job'];
			$jobStop = $schdeule[0]['stop_job'];
			$this->removeJob($jobStart);
			$this->removeJob($jobStop);

			//unlink("/home/ksm/scheduler/".$schdeule[0]['start_filename']);
			//unlink("/home/ksm/scheduler/".$schdeule[0]['stop_filename']);
			$this->delete_file_by_FTP("/home/ksm/scheduler/".$schdeule[0]['start_filename']);
			$this->delete_file_by_FTP("/home/ksm/scheduler/".$schdeule[0]['stop_filename']);

			$processname = $channel[0]['process_name'];
			$startname = "Channel_Start_".$processname.".sh";
			$stopname = "Channel_Stop_".$processname.".sh";
			$starttime = $this->getDateTime($cleanData['stime']);
			$stoptime = $this->getDateTime($cleanData['etime']);
			$startfile =  $starttime["m"].' '.$starttime["h"].' '.$starttime["day"].' '.$starttime["month"].' * /home/ksm/scheduler/'.$startname;
			$stopfile = $stoptime["m"].' '.$stoptime["h"].' '.$stoptime["day"].' '.$stoptime["month"].' * /home/ksm/scheduler/'.$stopname;

			$dataS = array(
				'start_datetime'=>$cleanData['stime'],
				'end_datetime'=>$cleanData['etime'],
				'created'=>time(),
				'start_job'=>$startfile,
				'stop_job'=>$stopfile,
				'start_filename'=>$startname,
				'stop_filename'=>$stopname
			);
			$sts = $this->Common_model->updateSchedule($dataS,$sid);
			if($sts)
			{
				$dataC = array(
					'is_scheduled'=>1,
					'startdate'=>$cleanData['stime'],
					'enddate'=>$cleanData['etime'],
				);
				$this->Common_model->updateChannels($dataC,$id);

				$ip = $this->config->item('ServerIP');
				$username = $this->config->item('ServerUser');
				$password = $this->config->item('ServerPassword');
				$port = '22';
				$ssh = new Net_SSH2($ip);
				if ($ssh->login($username, $password,$port)) {

					$ssh->exec("touch /home/ksm/scheduler/".$startname);
					$ssh->exec("chmod +x /home/ksm/scheduler/".$startname);

					$ssh->exec('echo "curl -H  \'Content-Type: application/json\'  --data \'{\"process\":\"'.$processname.'\"}\'  https://iohub.tv/api/startchannels >> /home/ksm/scheduler/"'.$processname.'".log" >>  /home/ksm/scheduler/'.$startname);
					$ssh->exec('echo "echo \"----------------------------------------------\" >> /home/ksm/scheduler/"'.$processname.'".log" >>  /home/ksm/scheduler/'.$startname);

					$ssh->exec("touch /home/ksm/scheduler/".$stopname);
					$ssh->exec("chmod +x /home/ksm/scheduler/".$stopname);
					$ssh->exec('echo "curl -H  \'Content-Type: application/json\'  --data \'{\"process\":\"'.$processname.'\"}\'  https://iohub.tv/api/stopchannels >> /home/ksm/scheduler/"'.$processname.'".log" >>  /home/ksm/scheduler/'.$stopname);
					$ssh->exec('echo "echo \"----------------------------------------------\" >> /home/ksm/scheduler/"'.$processname.'".log" >>  /home/ksm/scheduler/'.$stopname);

					$ssh->exec('(crontab -l; echo "'.$starttime["m"].' '.$starttime["h"].' '.$starttime["day"].' '.$starttime["month"].' * /home/ksm/scheduler/'.$startname.'") | crontab -');
					$ssh->exec('(crontab -l; echo "'.$stoptime["m"].' '.$stoptime["h"].' '.$stoptime["day"].' '.$stoptime["month"].' * /home/ksm/scheduler/'.$stopname.'") | crontab -');
				}
				$dataS['title'] = $channel[0]['channel_name'];
				$dataS['id'] = $sid;
				$response['status'] = TRUE;
				$response['message'] = "Scheduled Updated Successfully!";
				$response['response'] = $dataS;
			}

		}
		echo json_encode($response);
	}
    public function saveChannelSchedule_post()
    {
    	$userdata = $this->session->userdata('user_data');
		$response = array('status'=>FALSE,'response'=>array(),'message'=>"");
		$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
		$id = $cleanData['id'];
		$channel = $this->Common_model->getChannelbyId($id);
		if(sizeof($channel)>0)
		{
			$type = "";
			$inpids = explode("_",$channel[0]['channelInput']);
			$outids = explode("_",$channel[0]['channelOutpue']);
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
          case "9":
          $type = $type."FILE";
          break;
				}
			}

			$processname = $channel[0]['process_name'];
			$startname = "Channel_Start_".$processname.".sh";
			$stopname = "Channel_Stop_".$processname.".sh";
			$starttime = $this->getDateTime($cleanData['stime']);
			$stoptime = $this->getDateTime($cleanData['etime']);
			$startfile =  $starttime["m"].' '.$starttime["h"].' '.$starttime["day"].' '.$starttime["month"].' * /home/ksm/scheduler/'.$startname;
			$stopfile = $stoptime["m"].' '.$stoptime["h"].' '.$stoptime["day"].' '.$stoptime["month"].' * /home/ksm/scheduler/'.$stopname;
			$dataS = array(
				'schedule_type'=>'channel',
				'type'=>$type,
				'sid'=>$cleanData['id'],
				'start_datetime'=>$cleanData['stime'],
				'end_datetime'=>$cleanData['etime'],
				'status'=>1,
				'created'=>time(),
				'start_job'=>$startfile,
				'stop_job'=>$stopfile,
				'start_filename'=>$startname,
				'stop_filename'=>$stopname,
				'uid'=>$userdata['userid']
			);
			$sts = $this->Common_model->insertSchedule($dataS);
			if($sts)
			{
				$dataC = array(
					'is_scheduled'=>1,
					'startdate'=>$cleanData['stime'],
					'enddate'=>$cleanData['etime'],
				);
				$this->Common_model->updateChannels($dataC,$id);

				$ip = $this->config->item('ServerIP');
				$username = $this->config->item('ServerUser');
				$password = $this->config->item('ServerPassword');
				$port = '22';
				$ssh = new Net_SSH2($ip);
				if ($ssh->login($username, $password,$port)) {

					$ssh->exec("touch /home/ksm/scheduler/".$startname);
					$ssh->exec("chmod +x /home/ksm/scheduler/".$startname);

					$ssh->exec('echo "curl -H  \'Content-Type: application/json\'  --data \'{\"process\":\"'.$processname.'\"}\'  https://iohub.tv/api/startchannels >> /home/ksm/scheduler/"'.$processname.'".log" >>  /home/ksm/scheduler/'.$startname);
					$ssh->exec('echo "echo \"----------------------------------------------\" >> /home/ksm/scheduler/"'.$processname.'".log" >>  /home/ksm/scheduler/'.$startname);

					$ssh->exec("touch /home/ksm/scheduler/".$stopname);
					$ssh->exec("chmod +x /home/ksm/scheduler/".$stopname);
					$ssh->exec('echo "curl -H  \'Content-Type: application/json\'  --data \'{\"process\":\"'.$processname.'\"}\'  https://iohub.tv/api/stopchannels >> /home/ksm/scheduler/"'.$processname.'".log" >>  /home/ksm/scheduler/'.$stopname);
					$ssh->exec('echo "echo \"----------------------------------------------\" >> /home/ksm/scheduler/"'.$processname.'".log" >>  /home/ksm/scheduler/'.$stopname);



					$ssh->exec('(crontab -l; echo "'.$starttime["m"].' '.$starttime["h"].' '.$starttime["day"].' '.$starttime["month"].' * /home/ksm/scheduler/'.$startname.'") | crontab -');
					$ssh->exec('(crontab -l; echo "'.$stoptime["m"].' '.$stoptime["h"].' '.$stoptime["day"].' '.$stoptime["month"].' * /home/ksm/scheduler/'.$stopname.'") | crontab -');
				}
				$dataS['title'] = $channel[0]['channel_name'];
				$dataS['id'] = $sts;
				$response['status'] = TRUE;
				$response['message'] = "Channel Scheduled Successfully!";
				$response['response'] = $dataS;
			}

		}
		echo json_encode($response);
	}
	function getDateTime_pre($date)
	{
		$dateTimeArray = explode(" ",$date);
		$dateArray = explode("/",$dateTimeArray[0]);
		$timeArray = explode(":",$dateTimeArray[1]);
		return array("day"=>$dateArray[0],"month"=>$dateArray[1],"year"=>$dateArray[2],"h"=>$timeArray[0],"m"=>$timeArray[1],"s"=>$timeArray[2]);
	}

	function getDateTime($date)
	{
		$dateTimeArray = explode(" ",$date);
		$dateArray = explode("/",$dateTimeArray[0]);
		$timeArray = explode(":",$dateTimeArray[1]);
		return array("day"=>$dateArray[0],"month"=>$dateArray[1],"year"=>$dateArray[2],"h"=>$timeArray[0],"m"=>$timeArray[1],"s"=>$timeArray[2]);
	}
    public function startChannel_post()
	{
		try
		{
			$action = "Start";
			$errorCode = 0;
		 	$body = file_get_contents('php://input');
	        $responsArray = array('response'=>array());
	        if(!isset($body)|| $body==NULL) {
	               $errorCode = -1;
	        }
	    	$channelArray = json_decode($body,TRUE);
	    	/**
			* start
			*/

			$channel = $this->Common_model->getChannelbyProcessName($channelArray['process']);
			$encoderId= $channel[0]['encoder_id'];
			$encoder = $this->Common_model->getAllEncoders($encoderId,0);
			$ip =  $encoder[0]["encoder_ip"];
			$username = $encoder[0]["encoder_uname"];
			$password = $encoder[0]["encoder_pass"];
			$port = "22";
			$ssh = new Net_SSH2($ip);
			if (!$ssh->login($username, $password,$port)) {
				$responsArray['status']= FALSE;
				$responsArray['response']= "Encoder Not Connected!";
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
					$inputName = $this->Common_model->getEncoderInputbyId($inputTypeArray[1]);
					$input_name = $inputName[0]['item'];

				}
				elseif($inputTypeArray[0] == VIRTUAL_INPUT)
				{
					switch($inputTypeArray[1])
					{
						case NDI:
						$input_type = "libndi_newtek";
						$input_name = $channel[0]['channel_ndi_source'];
						break;
						case RTMP:
						$input_type = "flv";
						$input_name = $channel[0]['input_rtmp_url'];
						$options ='-vf "tinterlace=2,format=pix_fmts=uyvy422,fps=50" -ar 48000';
						break;
						case MPEG_TS_SRT:
						$input_type = "mpegts";
						$input_name = $channel[0]['input_mpeg_srt'];
						$options ='-vf "tinterlace=2,format=pix_fmts=uyvy422,fps=50" -ar 48000';
						break;
						case HTTP_LIVE_STREAMING:
						$input_type = "";
						$input_name = $channel[0]['input_hls_url'];
						$options ='-vf "tinterlace=5,format=pix_fmts=uyvy422,fps=50" -ar 48000';
						break;
					}
				}
				if($outputTypeArray[0] == PHYSICAL_OUTPUT)
				{
					if($outputTypeArray[1] == HDMI_OUT)
					{
						$output_type = "alsa default ";
							$output_name = "-f alsa plughw:0,7 -pix_fmt bgra -f fbdev /dev/fb0";
					}
					else
					{
						$output_type = "decklink";
						$ou = $this->Common_model->getOutputName($outputTypeArray[1]);
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
            case FILE:
						$output_type = "";
						//$options = '-vf "scale=interl=1,fps=50,format=pix_fmts=uyvy422"';
						#$options = '-vf "tinterlace=2,format=pix_fmts=uyvy422,fps=50"'; commentd By Mustafa 16Aug
						$output_name = "";
						break;
						case RTMP:
						$application = $this->Common_model->getAppbyId($channel[0]['channel_apps']);
						$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
						$eprofile = "";
						$output_type = "flv";
						$gop ="";$deinterlace ="";
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
							$options =  '-c:v '.$encodingProfile[0]['video_codec'].' -s '.$encodingProfile[0]['video_resolution'].' -b:v '.$encodingProfile[0]['video_bitrate'].'k '.$minBitRate.' '.$maxBitRate.' '.$bufSize.' '.$adv_video_keyframe_intrval.' '.$gop.' '.$adv_video_profile.' -pix_fmt yuv420p -preset '.$encodingProfile[0]['adv_video_preset'].' '.$deinterlace.' '.$enablezerolatency.' '.$video_framerate.' -c:a '.$encodingProfile[0]['audio_codec'].' -b:a '.$encodingProfile[0]['audio_bitrate'].'k -ar '.$encodingProfile[0]['audio_sample_rate'].' -ac '.$encodingProfile[0]['audio_channel'];

						}
						else
						{
							$options =  "";
						}

						break;
						case MPEG_TS_SRT:
						$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
						$eprofile = "";
						$output_type = "mpegts";
						$gop ="";$deinterlace ="";$enablezerolatency="";
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
						$output_name = $channel[0]["output_mpeg_srt"]."?mode=listener";

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
				$command = "";
				if($inputTypeArray[0] == PHYSICAL_INPUT || $inputTypeArray[0] == VIRTUAL_INPUT)
				{
					$d ="";
					if($output_name != "")
					{
						$pid = $ssh->exec("pidof ".$channel[0]['process_name']);
						if($pid == "")
						{
							if($inputTypeArray[0] == VIRTUAL_INPUT && $inputTypeArray[1] == NDI)
							{
								if($outputTypeArray[1] == MPEG_TS_SRT)
								{
								   $command = 'bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -i \"'.$input_name.'\" '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"';							;
								   $ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -i \"'.$input_name.'\" '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"');
								}
								else if($outputTypeArray[0] == PHYSICAL_OUTPUT && $outputTypeArray[1] == HDMI_OUT)
								{
									$command = 'bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -re -i \''.$input_name.'\' '.$options.' -f alsa default -f alsa plughw:0,7 -pix_fmt bgra -f fbdev /dev/fb0 -threads 16"';
									$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -re -i \''.$input_name.'\' '.$options.' -f alsa default -f alsa plughw:0,7 -pix_fmt bgra -f fbdev /dev/fb0 -threads 16"');
								}
								else if($outputTypeArray[0] == PHYSICAL_OUTPUT && $outputTypeArray[1] != HDMI_OUT)
								{
									$command = 'bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -r 25 -itsoffset -1 -i \"'.$input_name.'\" '.$options.' -f '.$output_type.' -top 1 \''.$output_name.'\' -threads 16"';
									$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -r 25 -itsoffset -1 -i \"'.$input_name.'\" '.$options.' -f '.$output_type.' -top 1 \''.$output_name.'\' -threads 16"');
								}
								else
								{
									$command = 'bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -re -i \"'.$input_name.'\" '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"';
									$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -re -i \"'.$input_name.'\" '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"');
								}

							}
							elseif($inputTypeArray[0] == VIRTUAL_INPUT && $inputTypeArray[1] == MPEG_TS_SRT)
							{
								if($outputTypeArray[0] == PHYSICAL_OUTPUT && $outputTypeArray[1] == HDMI_OUT)
								{
									$command = 'bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -re -i \''.$input_name.'\' -f alsa default -f alsa plughw:0,7 -pix_fmt bgra -f fbdev /dev/fb0 -threads 16"';
									$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -re -i \''.$input_name.'\' -f alsa default -f alsa plughw:0,7 -pix_fmt bgra -f fbdev /dev/fb0 -threads 16"');
								}
								else
								{
									$command = 'bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.'  -i \''.$input_name.'\' -f '.$output_type.' '.$output_name.' -threads 16"';
									$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.'  -i \''.$input_name.'\' -f '.$output_type.' '.$output_name.' -threads 16"');
								}

							}
							elseif($inputTypeArray[0] == VIRTUAL_INPUT && $inputTypeArray[1] == HTTP_LIVE_STREAMING)
							{
								$command = 'bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg '.$input_type.' -re -i \''.$input_name.'\' '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"';
								$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg '.$input_type.' -re -i \''.$input_name.'\' '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"');

							}
							elseif($inputTypeArray[0] == PHYSICAL_INPUT && $outputTypeArray[1] == NDI)
							{
								$audioInput = "";
								if($channel[0]['audio_channel'] != "" && $channel[0]['audio_channel'] > 0)
								{
									$audioInput = "-ac ".$channel[0]['audio_channel'];
								}
								$command = 'bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -ac 8 -i \''.$input_name.'\' '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"';
								$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -ac 8 -i \''.$input_name.'\' '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"');
							}
							elseif($inputTypeArray[0] == VIRTUAL_INPUT && $inputTypeArray[1] == RTMP)
							{
								if($outputTypeArray[0] == PHYSICAL_OUTPUT && $outputTypeArray[1] != HDMI_OUT)
								{
									$command = 'bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -re -i \''.$input_name.'\'  -f '.$output_type.' '.$output_opt.' \''.$output_name.'\' -threads 16"';
									$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -re -i \''.$input_name.'\'  -f '.$output_type.' '.$output_opt.' \''.$output_name.'\' -threads 16"');
								}
								else
								{
									$command = 'bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -re -i \''.$input_name.'\' '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"';
									$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -re -i \''.$input_name.'\' '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"');
								}
							}
							else
							{
								if($outputTypeArray[0] == PHYSICAL_OUTPUT && $outputTypeArray[1] == HDMI_OUT)
								{
									$command = 'bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -re -i \''.$input_name.'\' '.$options.' -f alsa default -f alsa plughw:0,7 -pix_fmt bgra -f fbdev /dev/fb0 -threads 16"';
									$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -re -i \''.$input_name.'\' '.$options.' -f alsa default -f alsa plughw:0,7 -pix_fmt bgra -f fbdev /dev/fb0 -threads 16"');
								}

								else
								{
									$command = 'bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -re -i \''.$input_name.'\' '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"';
									$ssh->exec('bash -c "exec -a '.$channel[0]['process_name'].' ffmpeg -f '.$input_type.' -re -i \''.$input_name.'\' '.$options.' -f '.$output_type.' \''.$output_name.'\' -threads 16"');
								}

							}

							$pid1 = $ssh->exec("pidof ".$channel[0]['process_name']);
							if($pid1 == "")
							{
								echo json_encode(array("response"=>"Status : FALSE | Error occur while starting stream for channel ".$channel[0]['process_name']));

							}
							elseif($pid1 > 0)
							{
								$p = $pid1;
								$cmd = 'ps -p '.trim($p).' -o lstart=';
								$time1 = $ssh->exec($cmd);
								$status = "Success";
								echo json_encode(array("response"=>"Status : TRUE | Channel Start Successfully ".$channel[0]['process_name']));


							}
						}
						else
						{
								$p = $pid;
								$cmd = 'ps -p '.trim($p).' -o lstart=';
								$time1 = $ssh->exec($cmd);
								$command = $channel_name.'=>'.$action.'=> Already Running!';
								$status = "Success";
								echo json_encode(array("response"=>"Status : TRUE | Channel Already Running ".$channel[0]['process_name']));

						}

					}
					else
					{
						echo json_encode(array("response"=>"Status : FALSE | This is not an encoder channel ".$channel[0]['process_name']));

					}
				}
			}
	    	/**
			* end
			*/
		}
		catch(Exception $e)
		{
			$responsArray['response'][] = array('Error'=>$e->getMessage());

		}
		echo json_encode($responsArray);
	}
	public function StopChannel_post()
	{
		try
		{
			$action = "Stop";
			$errorCode = 0;
		 	$body = file_get_contents('php://input');
	        $responsArray = array('response'=>array());
	        if(!isset($body)|| $body==NULL) {
	               $errorCode = -1;
	        }
	    	$channelArray = json_decode($body,TRUE);
	    	/**
			* start
			*/
			$channel = $this->Common_model->getChannelbyProcessName($channelArray['process']);
			$encoderId= $channel[0]['encoder_id'];
			$encoder = $this->Common_model->getAllEncoders($encoderId,0);
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
				if($inputTypeArray[0] == PHYSICAL_INPUT)
				{
					$input_type = "decklink";
					$inputName = $this->Common_model->getEncoderInputbyId($inputTypeArray[1]);
					$input_name = $inputName[0]['item'];

				}
				elseif($inputTypeArray[0] == VIRTUAL_INPUT)
				{
					switch($inputTypeArray[1])
					{
						case NDI:
						$input_type = "libndi_newtek";
						$input_name = $channel[0]['channel_ndi_source'];
						#$options = '-vf "tinterlace=2,format=pix_fmts=uyvy422,fps=50"';commentd By Mustafa 16Aug

						//tinterlace=2,format=pix_fmts=uyvy422,fps=50
						break;
						case RTMP:
						$input_type = "flv";
						$input_name = $channel[0]['input_rtmp_url'];
						//$options = '-vf scale=1920:1080 -pix_fmt uyvy422';
						$options ='-vf "tinterlace=2,format=pix_fmts=uyvy422,fps=50" -ar 48000';
						break;
						case MPEG_TS_SRT:
						$input_type = "mpegts";
						$input_name = $channel[0]['input_mpeg_srt'];
						//$options = '-vf scale=1920:1080 -pix_fmt uyvy422';
						$options ='-vf "tinterlace=2,format=pix_fmts=uyvy422,fps=50" -ar 48000';
						break;
						case HTTP_LIVE_STREAMING:
						$input_type = "";
						$input_name = $channel[0]['input_hls_url'];
						//$options = '-vf scale=1920:1080 -pix_fmt uyvy422';
						$options ='-vf "tinterlace=5,format=pix_fmts=uyvy422,fps=50" -ar 48000';
						break;
					}
				}
				if($outputTypeArray[0] == PHYSICAL_OUTPUT)
				{
					if($outputTypeArray[1] == HDMI_OUT)
					{
						$output_type = "alsa default ";
							$output_name = "-f alsa plughw:0,7 -pix_fmt bgra -f fbdev /dev/fb0";
					}
					else
					{
						$output_type = "decklink";
						$ou = $this->Common_model->getOutputName($outputTypeArray[1]);
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
						$application = $this->Common_model->getAppbyId($channel[0]['channel_apps']);
						$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
						$eprofile = "";
						$output_type = "flv";
						$gop ="";$deinterlace ="";
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
							$options =  '-c:v '.$encodingProfile[0]['video_codec'].' -s '.$encodingProfile[0]['video_resolution'].' -b:v '.$encodingProfile[0]['video_bitrate'].'k '.$minBitRate.' '.$maxBitRate.' '.$bufSize.' '.$adv_video_keyframe_intrval.' '.$gop.' '.$adv_video_profile.' -pix_fmt yuv420p -preset '.$encodingProfile[0]['adv_video_preset'].' '.$deinterlace.' '.$enablezerolatency.' '.$video_framerate.' -c:a '.$encodingProfile[0]['audio_codec'].' -b:a '.$encodingProfile[0]['audio_bitrate'].'k -ar '.$encodingProfile[0]['audio_sample_rate'].' -ac '.$encodingProfile[0]['audio_channel'];

						}
						else
						{
							$options =  "";
						}

						break;
						case MPEG_TS_SRT:
						$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
						$eprofile = "";
						$output_type = "mpegts";
						$gop ="";$deinterlace ="";$enablezerolatency="";
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
						$output_name = $channel[0]["output_mpeg_srt"]."?mode=listener";

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
						$ssh->exec('pkill -f '.$channel[0]['process_name']);
						echo "\n ======================================================================================== \n Status : TRUE \n Channel ".$channel[0]['process_name']." Stopped Successfully. \n ======================================================================================== \n";
						//echo json_encode(array('status'=>TRUE, "message"=> 'Channel ('.$channel[0]['process_name'].') Stopped Successfully!','change'=>'stop'));
					}
					else
					{
						echo "\n ======================================================================================== \n Status : False \n Channel ".$channel[0]['process_name']." This is not an encoder channel!. \n ======================================================================================== \n";

					}
				}
			}
	    	/**
			* end
			*/
		}
		catch(Exception $e)
		{
			$responsArray['response'][] = array('Error'=>$e->getMessage());
			echo json_encode($responsArray);
		}
	}
	public function startTarget_post()
	{
		try
		{
			$errorCode = 0;
		 	$body = file_get_contents('php://input');
	        $responsArray = array('response'=>array());
	        if(!isset($body)|| $body==NULL) {
	               $errorCode = -1;
	        }
	    	$targetprocess = json_decode($body,TRUE);
	    	$targetid = explode("_",$targetprocess['process']);
	    	$appid = $targetid[0];
			$target = $this->Common_model->getTargetbyId($appid);
			$streamULR = $target[0]['streamurl'];
			$streamURL = explode('/',$streamULR);
			$application = $this->Common_model->getAppbyId($target[0]['wowzaengin']);
			$wowza = $this->Common_model->getWovzData($application[0]['live_source']);
			$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.str_replace(" ","+",$application[0]['application_name']).'/pushpublish/mapentries/'.str_replace(" ","+",$target[0]['target_name']).'/actions/enable';



			$fields = array(
				'app_name' =>$application[0]['application_name'],
				'target_name'=>array($target[0]['target_name'])
			);


			$resultt=shell_exec("curl -X put ".$url);
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
						$status = $value[$target[0]['target_name']];


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
			echo "\n ======================================================================================== \n Target Status:  ".json_encode($response)."  \n ======================================================================================== \n";

		}
		catch(Exception $e)
		{
			$responsArray['response'][] = array('Error'=>$e->getMessage());
		}
		echo "\n ======================================================================================== \n Target Status:  ".json_encode($responsArray)."  \n ======================================================================================== \n";

	}
	public function StopTarget_post()
	{
		try
		{
			$errorCode = 0;
		 	$body = file_get_contents('php://input');
	        $responsArray = array('response'=>array());
	        if(!isset($body)|| $body==NULL) {
	               $errorCode = -1;
	        }
	    	$targetprocess = json_decode($body,TRUE);
	    	$targetid = explode("_",$targetprocess['process']);
	    	$appid = $targetid[0];
	    	$target = $this->Common_model->getTargetbyId($appid);
			$streamULR = $target[0]['streamurl'];
			$streamURL = explode('/',$streamULR);
			$application = $this->Common_model->getAppbyId($target[0]['wowzaengin']);
			$wowza = $this->Common_model->getWovzData($application[0]['live_source']);


			$url = 'http://'.$wowza[0]['ip_address'].':'.$wowza[0]['rest_api_port'].'/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/'.str_replace(" ","+",$application[0]['application_name']).'/pushpublish/mapentries/'.str_replace(" ","+",$target[0]['target_name']).'/actions/disable';


			$fields = array(
				'app_name' =>$application[0]['application_name'],
				'target_name'=>array($target[0]['target_name'])
			);

			$resultt=shell_exec("curl -X put ".$url);

			if($target[0]['target'] == "twitter")
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
			echo "\n ======================================================================================== \n Target Status:  ".json_encode($response)."  \n ======================================================================================== \n";
		}
		catch(Exception $e)
		{
			$responsArray['response'][] = array('Error'=>$e->getMessage());
		}
		echo "\n ======================================================================================== \n Target Status:  ".json_encode($responsArray)."  \n ======================================================================================== \n";

	}
	function delete_file_by_FTP($filePath)
	{
		$file = $filePath;
		$ip = $this->config->item('ServerIP');
		$username = $this->config->item('ServerUser');
		$password = $this->config->item('ServerPassword');
		$port = '22';
		// set up basic connection
		$conn_id = ftp_connect($ip);
		// login with username and password
		$login_result = ftp_login($conn_id, $username, $password);
		// try to delete $file
		if (ftp_delete($conn_id, $file)) {
			return TRUE;
		} else {
			return FALSE;
		}
		// close the connection
		ftp_close($conn_id);
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
	public function startchannels_post()
    {
		$userdata = $this->session->userdata('user_data');
		$response = array('status'=>FALSE,'response'=>'');

		/* All Parametes From Request */
    $body = file_get_contents('php://input');
	        $responsArray = array('response'=>array());
	        if(!isset($body)|| $body==NULL) {
	               $errorCode = -1;
	        }
	    	$channelArray = json_decode($body,TRUE);
	    	/**
			* start
			*/

			$channel = $this->Common_model->getChannelbyProcessName($channelArray['process']);
		//$idArray = explode('_',$channelId);

		/* Fetch Channel Info from Database */

		/* Fetch Encoder Info from Database */

		if($channel[0]['encoder_id'] == "" || $channel[0]['encoder_id'] <=0)
		{
			$encoderId= $channel[0]['encoderid'];
		}
		else{
			$encoderId= $channel[0]['encoder_id'];
		}
		$encoder = $this->Common_model->getAllEncoders($encoderId,0);
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
					$audioSource = $this->Common_model->getInpOutByEncIdAndName($encoder[0]['id'],$inputName);
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
					$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
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
					$audioSource = $this->Common_model->getInpOutByEncIdAndName($encoder[0]['id'],$inputName);
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
					$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
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
					$audioSource = $this->Common_model->getInpOutByEncIdAndName($encoder[0]['id'],$inputName);
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
					$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
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
					$audioSource = $this->Common_model->getInpOutByEncIdAndName($encoder[0]['id'],$inputName);
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
					$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
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
					$audioSource = $this->Common_model->getInpOutByEncIdAndName($encoder[0]['id'],$inputName);
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
					$outputfull = $this->Common_model->getOutByEncIdAndName($encoder[0]['id'],$output[1]);

					if(sizeof($outputfull)>0)
					{
						$outformat = $this->Common_model->getOutputFormatsValueByItem($outputfull[0]['out_format']);
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
					$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
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
					$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
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
					$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
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
					$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
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
					$outputfull = $this->Common_model->getOutByEncIdAndName($encoder[0]['id'],$output[1]);
					if(sizeof($outputfull)>0)
					{
						$outformat = $this->Common_model->getOutputFormatsValueByItem($outputfull[0]['out_format']);
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
					$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_rtmp_url'];
					$inputOptions = "";
					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_rtmp_url"]."/".$channel[0]["output_rtmp_key"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "RTMPTOMPEGRTP":
					$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_rtmp_url'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_rtp"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "RTMPTOMPEGUDP":
					$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_rtmp_url'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_udp"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "RTMPTOMPEGSRT":
					$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_rtmp_url'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_srt"]."?mode=listener";
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "MPEGRTPTOSDI":
					$output = explode('_',$channel[0]['channelOutpue']);
					$outputfull = $this->Common_model->getOutByEncIdAndName($encoder[0]['id'],$output[1]);
					if(sizeof($outputfull)>0)
					{
						$outformat = $this->Common_model->getOutputFormatsValueByItem($outputfull[0]['out_format']);
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
					$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_rtp'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_rtmp_url"]."/".$channel[0]["output_rtmp_key"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "MPEGRTPTOMPEGRTP":
					$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_rtp'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_rtp"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "MPEGUDPTOSDI":
					$output = explode('_',$channel[0]['channelOutpue']);
					$outputfull = $this->Common_model->getOutByEncIdAndName($encoder[0]['id'],$output[1]);
					if(sizeof($outputfull)>0)
					{
						$outformat = $this->Common_model->getOutputFormatsValueByItem($outputfull[0]['out_format']);
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
					$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_udp'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_rtmp_url"]."/".$channel[0]["output_rtmp_key"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "MPEGUDPTOMPEGUDP":
					$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_udp'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_rtp"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "MPEGSRTTOSDI":
					$output = explode('_',$channel[0]['channelOutpue']);
					$outputfull = $this->Common_model->getOutByEncIdAndName($encoder[0]['id'],$output[1]);
					if(sizeof($outputfull)>0)
					{
						$outformat = $this->Common_model->getOutputFormatsValueByItem($outputfull[0]['out_format']);
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
					$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_srt'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_rtmp_url"]."/".$channel[0]["output_rtmp_key"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "MPEGSRTTOMPEGSRT":
					$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_mpeg_srt'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_srt"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "HTTPLIVETOSDI":
					$output = explode('_',$channel[0]['channelOutpue']);
					$outputfull = $this->Common_model->getOutByEncIdAndName($encoder[0]['id'],$output[1]);
					if(sizeof($outputfull)>0)
					{
						$outformat = $this->Common_model->getOutputFormatsValueByItem($outputfull[0]['out_format']);
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
					$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_hls_url'];
					$inputOptions = "";
					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_rtmp_url"]."/".$channel[0]["output_rtmp_key"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "HTTPLIVETOMPEGRTP":
					$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_hls_url'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_rtp"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "HTTPLIVETOMPEGUDP":
					$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
					$inputType = $_config['input_type'];
					$inputName = $channel[0]['input_hls_url'];
					$inputOptions = "";

					$outputType = $_config['output_type'];
					$outputName = $channel[0]["output_mpeg_udp"];
					$outputOptions = $this->encodingProfile($encodingProfile);
				break;
				case "HTTPLIVETOMPEGSRT":
					$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
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
							$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
							$outputOptions_recording = $this->encodingProfile($encodingProfile);
						}
						elseif($channel[0]['recording_presets'] == -2)
						{
							$encID = $channel[0]['encoderid'];
							$encoderprofile = $this->Common_model->getAllEncoders($encID,0);

							$outputOptions_recording = $this->encodingProfile($encoderprofile);
						}
						elseif($channel[0]['recording_presets'] > 0)
						{
							$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['recording_presets']);
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
							$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['encoding_profile']);
							$outputOptions_recording = $this->encodingProfile($encodingProfile);
						}
						elseif($channel[0]['recording_presets'] == -2)
						{
							$encID = $channel[0]['encoderid'];
							$encoderprofile = $this->Common_model->getAllEncoders($encID,0);

							$outputOptions_recording = $this->encodingProfile($encoderprofile);
						}
						elseif($channel[0]['recording_presets'] > 0)
						{
							$encodingProfile = $this->Common_model->getEncodingTemplateById($channel[0]['recording_presets']);
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
				$this->Common_model->insertLogs($channel_name,'channels',$LogCommand,$userdata['userid'],$status);
				echo json_encode(array('status'=>FALSE, "message"=> 'Error occur while starting stream!' ,'change'=>'stop','error'=>$resp));
			}
			elseif(!empty($loopId) && preg_match('~[0-9]+~', $loopId))
			{
				$LOOPIDINRESPONSE = (int) filter_var($loopId, FILTER_SANITIZE_NUMBER_INT);

				$cmd = 'ps -p '.trim($LOOPIDINRESPONSE).' -o lstart=';
				$time1 = $ssh->exec($cmd);
				$status = "Success";
				$this->Common_model->insertLogs($channel_name,'channels',$LogCommand,$userdata['userid'],$status);
				$data = array(
					'channel_status'=>1,
					'uptime'=>$time1
				);
				$this->Common_model->updateChannelByChannelId($data,$channelID);

				echo json_encode(array('status'=>TRUE, "message"=> 'Channel Start Successfully.','change'=>'start','time'=>$time1));
			}
		}
	}
	public function stopchannels_post()
	{
		$userdata = $this->session->userdata('user_data');
		$response = array('status'=>FALSE,'response'=>'');

		/* All Parametes From Request */
    $body = file_get_contents('php://input');
          $responsArray = array('response'=>array());
          if(!isset($body)|| $body==NULL) {
                 $errorCode = -1;
          }
        $channelArray = json_decode($body,TRUE);
        /**
      * start
      */

    $channel = $this->Common_model->getChannelbyProcessName($channelArray['process']);
		//$idArray = explode('_',$channelId);

		/* Fetch Channel Info from Database */
		if($channel[0]['encoder_id'] == "")
		{
			$encoderId = $channel[0]['encoderid'];
		}
		else
		{
			$encoderId = $channel[0]['encoder_id'];
		}

		$encoder = $this->Common_model->getAllEncoders($encoderId,0);
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
				$this->Common_model->updateChannelByChannelId($data,$channel[0]['process_name']);
				$this->Common_model->insertLogs($channel_name,'channels',$command,$userdata['userid'],$status);
				echo json_encode(array('status'=>TRUE, "message"=> 'Channel Stopped Successfully!','change'=>'stop'));
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
class MCrypt
{
    private $iv = 'thisisencryption'; #Initialization vector Same as in JAVA
    private $key = 'decryptionisthis'; #Secret key Same as in JAVA
    function __construct()
    {
    }
    function decrypt($code) {
      //$key = $this->hex2bin($key);
      $code = $this->hex2bin($code);
      $iv = $this->iv;
      $td = mcrypt_module_open('rijndael-128', '', 'cbc', $iv);
      mcrypt_generic_init($td, $this->key, $iv);
      $decrypted = mdecrypt_generic($td, $code);
      mcrypt_generic_deinit($td);
      mcrypt_module_close($td);
      return utf8_encode(trim($decrypted));
    }
    protected function hex2bin($hexdata) {
      $bindata = '';
      for ($i = 0; $i < strlen($hexdata); $i += 2) {
        $bindata .= chr(hexdec(substr($hexdata, $i, 2)));
      }
      return $bindata;
    }
}
