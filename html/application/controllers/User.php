<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

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
        $this->load->library('form_validation');
        $this->load->library('session');	
        $this->load->library('encrypt');
        $this->load->helper('date');      
        $this->load->model('user_model');
        $this->load->model('common_model');
    } 
	public function login()
	{
		try
		{
			$this->form_validation->set_rules('username', 'Email', 'required|valid_email');
	        $this->form_validation->set_rules('pass', 'Password', 'required');	       
	        $actual_link =  $_SERVER['HTTP_REFERER'];
	        if ($this->form_validation->run() == FALSE) { 	
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Wrong Username/Password!');
				redirect($actual_link);				            
	        } else {
	            $post     = $this->input->post();
	            $clean    = $this->security->xss_clean($post);	
				$userPass= $this->common_model->checkPass($clean['username']);				
				if(sha1($clean['pass']) !=$userPass->password){
						$this->session->set_flashdata('error', 'Wrong Username/Password!');
						redirect('user/login');
					}
					$userInfo = $this->user_model->checkLogin($clean);	 					
		            if (is_object($userInfo) && property_exists($userInfo,"password")) {	
		            	
		            	$password = $this->input->post('pass');
						session_regenerate_id();
						$this->user_model->updateLogin($userInfo->id);			   			
			   			$roles = $this->config->item('roles_id');
			   			$role = $roles[$userInfo->role_id];	
		            	switch($role)
		            	{
							case "Admin":
							$groupInfo = $this->common_model->getAdminGroupInfo();
							$groupImage = $this->common_model->getGroupImage($groupInfo[0]['id']);
							$userImage = $this->user_model->getUserImage($userInfo->id);
							
							$datas = array(
							 'userid'=> $userInfo->id,
							 'fname'=> $userInfo->fname,
							 'lname'=> $userInfo->lname,
							 'email'=> $userInfo->email_id,
							 'user_type'=>$userInfo->role_id,
							 'timezone'=>$userInfo->timezone,
							 'timeformat'=>$userInfo->timeformat,
							 'language'=>$userInfo->language,
							 'userImage'=>$userImage['image'],
							 'group_id'=>$groupInfo[0]['id'],
							 'group_name'=>$groupInfo[0]['group_name'],
							 'group_address'=>$groupInfo[0]['group_address'],
							 'group_website'=>$groupInfo[0]['group_website'],
							 'group_postal_code'=>$groupInfo[0]['group_postal_code'],
							 'group_email'=>$groupInfo[0]['group_email'],
							 'group_phone'=>$groupInfo[0]['group_phone'],
							 'group_licence'=>$groupInfo[0]['group_licence'],
							 'group_country'=>$groupInfo[0]['group_country'],
							 'group_image'=>$groupImage[0]['name'],
							 'group_theme'=>$groupInfo[0]['group_theme'],
							 'group_menu_hide'=>$groupInfo[0]['group_menu_hide'],
							 'group_logo'=>$groupInfo[0]['group_logo'],
							 'group_favicon'=>$groupInfo[0]['group_favicon'],
							 'group_notification'=>$groupInfo[0]['group_notification'],
							 'group_sitename'=>$groupInfo[0]['group_sitename']
							);
							$this->common_model->insertLogs($datas['fname'],'user',"User Logged In Successfully!",$datas['userid'],"Success");
							$this->session->set_userdata('user_data',$datas);   
							$this->session->set_userdata('lock_data',array());        
							redirect(site_url() . 'dashboard');
							break;
							
							case "GroupAdmin":
							$groupId = $userInfo->group_id;
							$groupInfo = $this->common_model->getGroupInfobyId($groupId);
							
							if(sizeof($groupInfo)>0)
							{
								$groupImage = $this->common_model->getGroupImage($groupInfo[0]['id']);	
							}
							else
							{
								$groupImage = "";
							}							
							$userImage = $this->user_model->getUserImage($userInfo->id);
							
							$datas = array(
							 'userid'=> $userInfo->id,
							 'fname'=> $userInfo->fname,
							 'lname'=> $userInfo->lname,
							 'email'=> $userInfo->email_id,
							 'user_type'=>$userInfo->role_id,
							 'timezone'=>$userInfo->timezone,
							 'timeformat'=>$userInfo->timeformat,
							 'language'=>$userInfo->language,
							 'userImage'=>$userImage['image']							 
							);
							if(sizeof($groupInfo) > 0){
								
								$datas['group_id'] = 	$groupInfo[0]['id'];
								$datas['group_name'] = 	$groupInfo[0]['group_name'];
								$datas['group_address'] = 	$groupInfo[0]['group_address'];
								$datas['group_website'] = 	$groupInfo[0]['group_website'];
								$datas['group_postal_code'] = 	$groupInfo[0]['group_postal_code'];
								$datas['group_email'] = 	$groupInfo[0]['group_email'];
								$datas['group_phone'] = 	$groupInfo[0]['group_phone'];
								$datas['group_licence'] = 	$groupInfo[0]['group_licence'];
								$datas['group_country'] = 	$groupInfo[0]['group_country'];
								$datas['group_image'] = 	$groupInfo[0]['group_name'];
								$datas['group_theme'] = 	$groupInfo[0]['group_theme'];
								$datas['group_menu_hide'] = 	$groupInfo[0]['group_menu_hide'];
								
								$datas['group_logo'] = 	$groupInfo[0]['group_logo'];
								$datas['group_favicon'] = 	$groupInfo[0]['group_favicon'];
								$datas['group_notification'] = 	$groupInfo[0]['group_notification'];
								$datas['group_sitename'] = 	$groupInfo[0]['group_sitename'];
							}else{
								$datas['group_id'] = 	0;
								$datas['group_name'] = 	"";
								$datas['group_address'] = "";
								$datas['group_website'] = "";
								$datas['group_postal_code'] = "";
								$datas['group_email'] = "";
								$datas['group_phone'] = "";
								$datas['group_licence'] = "";
								$datas['group_country'] = 0;
								$datas['group_image'] = "";
								$datas['group_theme'] =0;
								$datas['group_menu_hide'] = 0;
								
								$datas['group_logo'] = 0;
								$datas['group_favicon'] = 0;
								$datas['group_notification'] = 	0;
								$datas['group_sitename'] = 0;
							}
										 
							$this->session->set_userdata('user_data',$datas);
							redirect(site_url() . 'dashboard');
							break;
							case "User":
							$groupId = $userInfo->group_id;
							$groupInfo = $this->common_model->getGroupInfobyId($groupId);
							
							$group_image = '';
							if(isset($groupInfo[0]['id']) && !empty($groupInfo[0]['id'])){
								$groupImage = $this->common_model->getGroupImage($groupInfo[0]['id']);
								$group_image = isset($groupImage[0]['name'])?$groupImage[0]['name']:"";
							}
							$userImage = $this->user_model->getUserImage($userInfo->id);
							$datas = array(
							 'userid'=> $userInfo->id,
							 'fname'=> $userInfo->fname,
							 'lname'=> $userInfo->lname,
							 'email'=> $userInfo->email_id,
							 'user_type'=>$userInfo->role_id,
							 'timezone'=>$userInfo->timezone,
							 'timeformat'=>$userInfo->timeformat,
							 'language'=>$userInfo->language,
							 'userImage'=>$userImage['image']							 			 
							);
								if(sizeof($groupInfo) > 0){
								
								$datas['group_id'] = 	$groupInfo[0]['id'];
								$datas['group_name'] = 	$groupInfo[0]['group_name'];
								$datas['group_address'] = 	$groupInfo[0]['group_address'];
								$datas['group_website'] = 	$groupInfo[0]['group_website'];
								$datas['group_postal_code'] = 	$groupInfo[0]['group_postal_code'];
								$datas['group_email'] = 	$groupInfo[0]['group_email'];
								$datas['group_phone'] = 	$groupInfo[0]['group_phone'];
								$datas['group_licence'] = 	$groupInfo[0]['group_licence'];
								$datas['group_country'] = 	$groupInfo[0]['group_country'];
								$datas['group_image'] = 	$groupInfo[0]['group_name'];
								$datas['group_theme'] = 	$groupInfo[0]['group_theme'];
								$datas['group_menu_hide'] = 	$groupInfo[0]['group_menu_hide'];
								
								$datas['group_logo'] = 	$groupInfo[0]['group_logo'];
								$datas['group_favicon'] = 	$groupInfo[0]['group_favicon'];
								$datas['group_notification'] = 	$groupInfo[0]['group_notification'];
								$datas['group_sitename'] = 	$groupInfo[0]['group_sitename'];
							}else{
								$datas['group_id'] = 	0;
								$datas['group_name'] = 	"";
								$datas['group_address'] = "";
								$datas['group_website'] = "";
								$datas['group_postal_code'] = "";
								$datas['group_email'] = "";
								$datas['group_phone'] = "";
								$datas['group_licence'] = "";
								$datas['group_country'] = 0;
								$datas['group_image'] = "";
								$datas['group_theme'] =0;
								$datas['group_menu_hide'] = 0;
								
								$datas['group_logo'] = 0;
								$datas['group_favicon'] = 0;
								$datas['group_notification'] = 	0;
								$datas['group_sitename'] = 0;
							}
							$this->session->set_userdata('user_data',$datas);
							redirect(site_url() . 'dashboard');
							break;
						} 
						
		            }
		            else
		            {
		            	$this->common_model->insertLogs($clean['username'],'user',"Wrong Username/Password!",0,"Error");
		            	$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Wrong Username/Password!');
						redirect($actual_link);	
					}
	        }
		}
		catch(Exception $e)
		{
			$this->common_model->insertLogs($clean['username'],'user',"Wrong Username/Password!",0,"Error");
			$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Wrong Username/Password');
			redirect($actual_link);				
		}
	}	
	public function logout()
    {        
        $userInfo = $this->session->userdata('user_data');
        $this->common_model->insertLogs($userInfo['username'],'user',"User Logged Out Successfully!",$userInfo['userid'],"Success");
		$roles = $this->config->item('roles_id');
		$role = $roles[$userInfo['user_type']];
		$this->session->unset_userdata('user_data');
		$this->session->sess_destroy();
		redirect('home');    	       
    }
	function isValidCaptch($captchText)
	{
		$sessionData = $this->session->userdata('captcha_code');
		$sessionText = $sessionData['code'];
		return ($captchText == $sessionText) ? TRUE : FALSE;
	}
	public function register()
	{
		try{
			$this->form_validation->set_rules('country', 'Country', 'required');
	        $this->form_validation->set_rules('student_name', 'Name', 'required');
	        $this->form_validation->set_rules('gender', 'Gender', 'required');
	        $this->form_validation->set_rules('applicant_date', 'Date of Birth', 'required');
	        $this->form_validation->set_rules('applicant_month', 'Date of Birth', 'required');
	        $this->form_validation->set_rules('applicant_year', 'Date of Birth', 'required');
	        $this->form_validation->set_rules('mobile_no', 'Mobile Number', 'required');
	        $this->form_validation->set_rules('emailId', 'Email', 'required|valid_email');
	        $this->form_validation->set_rules('password', 'Password', 'required');	       
	        $this->form_validation->set_rules('isindian', 'Is Indian', 'required');
	        $post     = $this->input->post();
	        $actual_link =  $_SERVER['HTTP_REFERER'];
	        $clean    = $this->security->xss_clean($post);
	        if ($this->form_validation->run() == FALSE) {
        	    $this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Invalid Data!');
				redirect($actual_link);		           
	        } 
	        else 
	        {
	        	if($this->isValidCaptch($clean['userCaptcha']))
	            {
    		     if ($this->user_model->isDuplicate($this->input->post('emailId'))) {
    		     	$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Email Id Already Exist!');
					redirect($actual_link);	    	
	            } else {
		                $clean   = $this->security->xss_clean($this->input->post(NULL, TRUE));	               
		                $clean['username'] = $this->input->post('student_name');
		                $id      = $this->user_model->insertUser($clean);
		                $clean['uid'] = $id;
		                $id_detail = $this->user_model->insertStudentDetails($clean);
		                $token   = $this->user_model->insertToken($id);
		                $qstring = $this->base64url_encode($token);
		                $url     = site_url() . 'home/complete/token/' . $qstring;
		                $link    = '<a href="' . $url . '">Confirm my email and create my account! »</a>';
		                $message = '';                
		                $message .= '<strong>Please confirm your email address.</strong><br><br>';
		                $message .= 'You are almost there! Please click the link below to create your ICCR account. <br>';
		                                
		                $message .= $link;
	                	$data = array(
						    'content' => $message					   
						);
	                	$config = Array(
					        'mailtype' => 'html'				        
					     );
					     $content = $this->load->view('mail_signup',$data, true); 
					     $from_email = "diritc.iccr@gov.in"; 
						 $to_email = $this->input->post('emailId'); 			   
						 /* Load email library */
						 $this->load->library('email',$config);			   
						 $this->email->from($from_email, 'Indian Council for Cultural Relations (ICCR)'); 
						 $this->email->to($to_email);
						 $this->email->subject('Indian Council for Cultural Relations (ICCR)'); 
						 $this->email->message($content); 			   
						 // if($this->email->send()) 
						 // {
						 	// echo '<script>window.location.href="'.site_url().'home?text=Please check your email inbox/spam to activate the account.&type=Thank You!&at=success&redirect='.site_url().'home";</script>';
						 // }					
						 // else 
						 // echo '<script>window.location.href="'.site_url().'home?text=Email not sent.&type=Error Message&at=danger&redirect='.site_url().'home/register";</script>';
						 $this->session->set_flashdata('message_type', 'success');
						$this->session->set_flashdata('success', 'Registration Sucessfully!');
						redirect($actual_link);		
	            	}    	
	            }
	            else
	            {
	            	 $this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Wrong Text Enterd!');
					redirect($actual_link);	
					
				}
        	}
		}
		catch(Exception $e)
		{
	 		$this->session->set_flashdata('message_type', 'error');
			$this->session->set_flashdata('error', 'Internal Server Error. Please Try After Some Time');
			redirect($actual_link);				 
		}
	}
	public function base64url_encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    public function base64url_decode($data)
    {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }	
}
