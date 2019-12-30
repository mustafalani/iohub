<?php
	class Superadmin extends Admin {
		
		public function __construct(){
		}
		
		
		//Delete all Admin Encoding Templates
		public function encoderActions()
		{
			$sts = FALSE;
			$response = array('status'=>FALSE,'response'=>'');
			$cleanData = $this->security->xss_clean($this->input->post(NULL, TRUE));
			$wowId = $cleanData['id'];
			//echo '<pre>';print_r($wowId);die;
			$action = $cleanData['action'];
			switch($action){
				case "Refresh":
				$sts = TRUE;
				break;				
				case "Reboot":
				$sts = TRUE;
				break;
				case "Delete":
				if(sizeof($wowId)>0)
				{
					foreach($wowId as $wid)
					{
						$sts = $this->common_model->deleteEncoders($wid);		
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
				$response['response'] = "Error occure while ".$action." encoding templates!";
			}
			echo json_encode($response);			
		}
		
		
	}