<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class Home extends CI_Controller {
		
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
			$this->load->helper('captcha');
		} 
		public function not_found()
		{
			$this->load->view('site/header');
			$this->load->view('errors/html/error_500');
			$this->load->view('site/footer');
		}
		public function createasset()
		{
			$URL = "https://kurrenttv.nbla.cloud/login";			
			$ch1 = curl_init();	
			curl_setopt($ch1,CURLOPT_URL, $URL);	
			curl_setopt($ch1, CURLOPT_POST, 1);	
			curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);	
			curl_setopt($ch1,CURLOPT_POSTFIELDS, "login=demo&password=demo&api=1");
			curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type'=>'application/json'));			
			
			$result = curl_exec($ch1);				
			$jsonData = rtrim($result, "\0");		
			$resultarray = json_decode($jsonData,TRUE);				
			curl_close($ch1);
		
			$curl = curl_init();
			$fields = json_encode(array("object_type" =>'asset','objects'=>array(0),'data'=>array('title'=>'test','subtitle'=>'testing','description'=>'testing desc','id_folder'=>1),'session_id'=>$resultarray['session_id']));
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://kurrenttv.nbla.cloud/api/set",
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
			echo $response;
			print_r($response);
			curl_close($curl);
			
			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
			  echo $response;
			}
		}
		public function testcurl()
		{
			$URL = "https://kurrenttv.nbla.cloud/login";			
			$ch1 = curl_init();	
			curl_setopt($ch1,CURLOPT_URL, $URL);	
			curl_setopt($ch1, CURLOPT_POST, 1);	
			curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);	
			curl_setopt($ch1,CURLOPT_POSTFIELDS, "login=demo&password=demo&api=1");
			curl_setopt($ch1, CURLOPT_HTTPHEADER, array('Content-Type'=>'application/json'));			
			
			$result = curl_exec($ch1);				
			$jsonData = rtrim($result, "\0");		
			$resultarray = json_decode($jsonData,TRUE);				
			curl_close($ch1);
		
			$curl = curl_init();
			$fields = json_encode(array("object_type" =>'asset','id_view'=>1,'session_id'=>$resultarray['session_id']));
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://kurrenttv.nbla.cloud/api/get",
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
			
			if ($err) {
			  echo "cURL Error #:" . $err;
			} else {
			  echo $response;
			}
		}
		public function index()
		{
			$userdata = $this->session->userdata('user_data');
			if(!empty($userdata))
			{
			    $roles = $this->config->item('roles_id');
				$role = $roles[$userdata['user_type']];
				redirect(site_url() . 'dashboard');
			}
			$this->load->view('site/header');
			$this->load->view('site/login');
			$this->load->view('site/footer');
			
		}
		public function test($body)
		{
			$data = $_POST;
			
			print_r($body);
			
		}
		public function privacy()
		{
			$this->load->view('site/header');
			$this->load->view('site/privacy');
			$this->load->view('site/footer');
		}
		public function terms()
		{
			$this->load->view('site/header');
			$this->load->view('site/termsandconditions');
			$this->load->view('site/footer');
		}
		public function random_string()
		{
			$character_set_array = array();
			$character_set_array[] = array('count' => 4, 'characters' => 'abcdefghijklmnopqrstuvwxyz');
			$character_set_array[] = array('count' => 4, 'characters' => '0123456789');
			$temp_array = array();
			foreach ($character_set_array as $character_set) {
				for ($i = 0; $i < $character_set['count']; $i++) {
					$temp_array[] = $character_set['characters'][rand(0, strlen($character_set['characters']) - 1)];
				}
			}
			shuffle($temp_array);
			return implode('', $temp_array);
		}
		 public function refresh(){
		 	$actual_link =  $_SERVER['HTTP_REFERER'];	
	        $config = array(
	            'img_path'      => FCPATH.'public/site/main/captcha/',
	            'img_url'       => base_url().'public/site/main/captcha/',
	            'font_path'     => 'system/fonts/texb.ttf',
	            'img_width'     => '160',
	            'img_height'    => 50,
	            'word_length'   => 10,
	            'font_size'     => 20
	        );
	        $captcha = create_captcha($config);
	        $this->session->unset_userdata('captchaCode');
	        $this->session->set_userdata('captchaCode',$captcha['word']);
	         echo $captcha['image'];
	    }
		public function forgotPassword()
		{			
			$config = array(
			    'img_path'      => FCPATH.'public/site/main/captcha/',
			    'img_url'       => base_url().'public/site/main/captcha/',
			    'font_path'     => FCPATH.'public/site/main/fonts/captcha_fonts/times_new_yorker.ttf',
			    'img_width'     => '150',
			    'img_height'    => 50,
			    'word_length'   => 8,
			    'font_size'     => 16,
			    'colors' => array(
				    'background' => array(255, 255, 255),
				    'border' => array(0, 0, 0),
				    'text' => array(0, 0, 0),
				    'grid' => array(255, 40, 40)
				  )
				);
			$captcha = create_captcha($config);
			 $this->session->unset_userdata('captchaCode');
	        $this->session->set_userdata('captchaCode', $captcha['word']);	        
	        $data['captchaImg'] = $captcha['image'];
			$this->load->view('site/header');
			$this->load->view('site/forgotpassword',$data);
			$this->load->view('site/footer');
		}
		public function forgot_password() 
		{
			
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|min_length[5]|max_length[125]');
			if ($this->form_validation->run() == FALSE) 
			{
				$this->session->set_flashdata('message_type', 'error');
				$this->session->set_flashdata('error', 'Wrong Email Id');	
			} 
			else 
			{	
				$post = $this->input->post(NULL, TRUE);
				$cleanPost = $this->security->xss_clean($post);
				
					$email = $this->input->post('email');
					$this->db->where('email_id', $email);
					$this->db->from('iccr_users');
					$num_res = $this->db->count_all_results();
					
					
					if ($num_res == 1) 
					{
						// Make a small string (code) to assign to the user // to indicate they've requested a change of // password
						$code = mt_rand('5000', '200000');
						$code = md5($code);
						$data = array(
						'token' => $code,
						'pass_updated_count'=>0
						);
						
						$this->db->where('email_id', $email);
						if ($this->db->update('iccr_users', $data)) 
						{
							
							
							// Update okay, send email
							$url     = site_url() . 'home/completePassword/' .$code;
							
							$link    = '<a href="' . $url . '">Please click the link to reset the password! »</a>';
							$message = '';                
							$message .= 'Please click the link below to reset your password. <br>';
							
							$message .= $link;
							$data = array(
							'content' => $message					   
							);
							$config = Array(
							 'mailtype' => 'html'				        
							);
							$content = $this->load->view('change_password',$data, true); 
							//$from_email = "diritc.iccr@gov.in"; 
							$from_email = "yashpal.sharma@velocis.co.in"; 
							$to_email = $email; 			   
							/* Load email library */
							$this->load->library('email',$config);			   
							$this->email->from($from_email, 'Indian Council for Cultural Relations (ICCR)'); 
							$this->email->to($to_email);
							$this->email->subject('Indian Council for Cultural Relations (ICCR)'); 
							$this->email->message($content);			   
							if($this->email->send()) 
							{
								$this->session->set_flashdata('message_type', 'success');
								$this->session->set_flashdata('success', 'Kindly Check Your Email to Reset Password!');
								redirect(site_url().'home/forgotPassword');
								
							}
							else 
							{
								
								$this->session->set_flashdata('message_type', 'error');
								$this->session->set_flashdata('error', 'Email Not Send');
								redirect(site_url().'home/forgotPassword');
							}
							
							
							
						} 
						else 
						{ 
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'Wrong Email Id');
							redirect(site_url().'home/forgotPassword');
						}
					} 
					else
					{ 
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Wrong Email Id');
						redirect(site_url().'home/forgotPassword');
					}
				
				
			}
		}
		public function completePassword() 
		{
		
			$data['salt'] = uniqid(rand(59999, 199999));
			$this->load->library('form_validation');
			$this->form_validation->set_rules('code', 'Code', 'required|min_length[4]|max_length[50]');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|min_length[5]|max_length[125]');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]|max_length[125]');
			$this->form_validation->set_rules('password2', 'Confirmation Password', 'required|min_length[8]|max_length[45]|matches[password]');
			
			// Get Code from URL or POST and clean up
			 $var = $this->uri->segment(3);
			if(!empty($var))
			{
				$passUpdatedCount = $this->common_model->checkPasswordUpdatedCount($var);	
			//echo "<pre>";print_r($passUpdatedCount);die;
				if($passUpdatedCount[0]['pass_updated_count'] == 1)
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Your token has been expire.Please Try Again.');
					redirect(site_url().'home');
					return false;
				}
			}
			
			if($this->input->post()) 
			{
				$data['code'] = xss_clean($this->input->post('code'));
			} 
			else 
			{
				$data['code'] = xss_clean($this->uri->segment(3));
			}
			
			if($this->form_validation->run() == FALSE) 
			{
		
				$data['captcha'] = $this->getCaptchaForPassword();
				$this->load->view('site/header');
				$this->load->view('site/new_password',$data);
				$this->load->view('site/footer');
			} 
			else 
			{
				// Does code from input match the code against the // email
				// $this->load->model('Signin_model');
				$post = $this->input->post(NULL, TRUE);
				$cleanPost = $this->security->xss_clean($post);				
				if($this->isValidCaptch($cleanPost['userCaptcha']))
				{
					$email = xss_clean($this->input->post('email'));
					if (!$this->common_model->does_code_match($data['code'], $email)) 
					{
						// Code doesn't match
						$this->session->set_flashdata('message_type', 'error');
						$this->session->set_flashdata('error', 'Your Email is not Valid Please Try Again.');
						redirect(site_url().'home/completePassword');
					} 
					else 
					{
						$password = $this->input->post('password');
						$hash = $password;
						//echo $hash; die;
						$data = array(
						'password' => $hash,
						'pass_updated_count'=>1
						);
						
						if ($this->common_model->update_user($data, $email)) 
						{
							$this->session->set_flashdata('message_type', 'success');
							$this->session->set_flashdata('success', 'Password Update Successfully!');
							redirect(site_url().'home');
						}
						else
						{
							$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'Password is not Update Successfully');
							redirect(site_url().'home');							 
						}
					}
				}
				else
				{
					$this->session->set_flashdata('message_type', 'error');
					$this->session->set_flashdata('error', 'Wrong Text Entered');
					redirect(site_url().'home/completePassword');
				}
			}
		}
		public function getCaptchaForPassword()
		{
			$data['captcha'] = $this->createCaptcha( array(
			'min_length' => 5,
			'max_length' => 5,
			'backgrounds' => array(FCPATH.'public/site/main/images/captcha_bg/white-carbon.png'),
			'fonts' => array(FCPATH.'public/site/main/fonts/captcha_fonts/times_new_yorker.ttf'),
			'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789',
			'min_font_size' => 28,
			'max_font_size' => 28,
			'color' => '#666',
			'angle_min' => 0,
			'angle_max' => 10,
			'shadow' => true,
			'shadow_color' => '#fff',
			'shadow_offset_x' => -1,
			'shadow_offset_y' => 1
			));	
			$this->session->set_userdata('captcha_code',$data['captcha']);
			
			return $data; 
		}
		function isValidCaptch($captchText)
		{
			$sessionData = $this->session->userdata('captcha_code');
			$sessionText = $sessionData['code'];
			
			return ($captchText == $sessionText) ? TRUE : FALSE;
		}
	
		public function register()
		{	
			$this->load->view('site/header');
			$this->load->view('site/register');
			$this->load->view('site/footer');
		}	
		public function createGroup()
		{
			try{
				$this->form_validation->set_rules('username', 'Group Name', 'required');
		        $this->form_validation->set_rules('phone', 'Phone Number', 'required');
		        $this->form_validation->set_rules('email_id', 'Email Id', 'required|valid_email');
		        $this->form_validation->set_rules('fname', 'First Name', 'required');
		        $this->form_validation->set_rules('lname', 'Last Name', 'required');
		        $this->form_validation->set_rules('timezone', 'Time Zone', 'required');
		        $this->form_validation->set_rules('timeformat', 'Time Format', 'required');
		        $this->form_validation->set_rules('password', 'Password', 'required');	       
		        $this->form_validation->set_rules('passwordagain', 'Confirm Password', 'required');
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
		                $userData = array(
		                	'username'=>$cleanData['username'],
		                	'fname'=>$cleanData['fname'],
		                	'lname'=>$cleanData['lname'],
		                	'email_id'=>$cleanData['email_id'],
		                	'timezone'=>$cleanData['timezone'],
		                	'timeformat'=>$cleanData['timeformat'],
		                	'phone'=>$cleanData['phone'],
		                	'password'=>sha1($cleanData['password']),
		                	'role_id'=>2,
		                	'created'=>time()
		                );
		                $id      = $this->user_model->insertUser($userData);	
		                $token   = $this->user_model->insertToken($id);
		                $qstring = $this->base64url_encode($token);
		                $url     = site_url() . 'home/complete/token/'.$qstring;
		                $link    = '<a href="' . $url . '">Confirm my email and create my account! »</a>';
		                $message = '';                
		                $message .= '<strong>Please confirm your email address.</strong><br><br>';
		                $message .= 'You are almost there! Please click the link below to create your KSM account. <br>';
		                                
		                $message .= $link;
	                	$data = array(
						    'content' => $message					   
						);
	                	$config = Array(
					        'mailtype' => 'html'				        
					     );
					     $content = $this->load->view('mail_signup',$data, true); 
					     $from_email = "accounts@ksm.com"; 
						 $to_email = $this->input->post('email_id'); 			   
						 /* Load email library */
						 $this->load->library('email',$config);			   
						 $this->email->from($from_email, 'Kurrent Stream Manager'); 
						 $this->email->to($to_email);
						 $this->email->subject('Kurrent Stream Manager Account Activation'); 
						 $this->email->message($content); 			   
						 if($this->email->send()) 
						 {						 	
						 	$this->session->set_flashdata('message_type', 'success');
							$this->session->set_flashdata('success', 'Registration Sucessfully! Please check your email inbox/spam to activate the account!');
							redirect($actual_link);	 
						 }					
						 else 
						 {
						 	$this->session->set_flashdata('message_type', 'error');
							$this->session->set_flashdata('error', 'Registration Sucessfully! But due to technical problem mail not sent!');
							redirect($actual_link);	
						 }		
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
		public function complete()
		{
			try{
				$token      = base64_decode($this->uri->segment(4));
				$cleanToken = $this->security->xss_clean($token);
				$user_info  = $this->user_model->isTokenValid($cleanToken);
				if (!is_object($user_info)) {
					echo '<script>window.location.href="'.site_url().'home?text=Token is invalid or expired!.&type=Error Message&at=danger&redirect='.site_url().'home";</script>';
					return;  
				}
				$data = array(
	            'firstName' => $user_info->username,
	            'email' => $user_info->email_id,
	            'user_id' => $user_info->id,
	            'token' => $this->base64url_encode($token)
				);
				$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
				$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]');
				if ($this->form_validation->run() == FALSE) {
					$this->load->view('site/header');
					$this->load->view('site/complete', $data);
					$this->load->view('site/footer');
					} else {
					$post                  = $this->input->post(NULL, TRUE);
					$cleanPost             = $this->security->xss_clean($post);
					$hashed                = md5($cleanPost['password']);
					$cleanPost['password'] = $hashed;
					$cleanPost['user_id'] =  $user_info->id;
					unset($cleanPost['passconf']);
					$userInfo = $this->user_model->updateUserInfo($cleanPost);
					if(is_object($userInfo) && property_exists($userInfo,"username"))
					{
						unset($userInfo->password);
						$datas = array(
						'userid'=> $userInfo->id,
						'fname'=> $userInfo->username,
						'email'=> $userInfo->email_id,
						'user_type'=> $userInfo->user_type								
						);
						$this->session->set_userdata('user_data',$datas);   
						echo '<script>window.location.href="'.site_url().'home?text=Login Successfully!.&type=Thank You!&at=success&redirect='.site_url().'Applicant/dashboard";</script>';       
						
					}
					else
					{
						if (!$userInfo) {            	
							$this->session->set_flashdata('flash_message', 'There was a problem updating your record');
							echo '<script>window.location.href="'.site_url().'home?text=There was a problem updating your record!.&type=Error Message!&at=danger&redirect='.site_url().'home";</script>';  
						}
					}
				}
			}
			catch(Exception $e)
			{
				echo '<script>window.location.href="'.site_url().'home?text=Internal Server Error. Try After Some Time!&type=Error Message!&at=danger&redirect='.site_url().'home";</script>';			
			}
		} 
			
		public function createCaptcha($config = array())
		{
			if( !function_exists('gd_info') ) {
				throw new Exception('Required GD library is missing');
			}
			
			$bg_path = dirname(__FILE__) . 'public/site/main/images/captcha_bg/backgrounds/';
			$font_path = dirname(__FILE__) . 'public/site/main/fonts/captcha_fonts/';
			
			// Default values
			$captcha_config = array(
	        'code' => '',
	        'min_length' => 5,
	        'max_length' => 5,
	        'backgrounds' => array(
			$bg_path . '45-degree-fabric.png',
			$bg_path . 'cloth-alike.png',
			$bg_path . 'grey-sandbag.png',
			$bg_path . 'kinda-jean.png',
			$bg_path . 'polyester-lite.png',
			$bg_path . 'stitched-wool.png',
			$bg_path . 'white-carbon.png',
			$bg_path . 'white-wave.png'
	        ),
	        'fonts' => array(
			$font_path . 'opensans-semibold-webfont.ttf'
	        ),
	        'characters' => 'ABCDEFGHJKLMNPRSTUVWXYZabcdefghjkmnprstuvwxyz23456789',
	        'min_font_size' => 20,
	        'max_font_size' => 28,
	        'color' => '#666',
	        'angle_min' => 0,
	        'angle_max' => 10,
	        'shadow' => true,
	        'shadow_color' => '#fff',
	        'shadow_offset_x' => -1,
	        'shadow_offset_y' => 1
			);
			
			// Overwrite defaults with custom config values
			if( is_array($config) ) {
				foreach( $config as $key => $value ) $captcha_config[$key] = $value;
			}
			
			// Restrict certain values
			if( $captcha_config['min_length'] < 1 ) $captcha_config['min_length'] = 1;
			if( $captcha_config['angle_min'] < 0 ) $captcha_config['angle_min'] = 0;
			if( $captcha_config['angle_max'] > 10 ) $captcha_config['angle_max'] = 10;
			if( $captcha_config['angle_max'] < $captcha_config['angle_min'] ) $captcha_config['angle_max'] = $captcha_config['angle_min'];
			if( $captcha_config['min_font_size'] < 10 ) $captcha_config['min_font_size'] = 10;
			if( $captcha_config['max_font_size'] < $captcha_config['min_font_size'] ) $captcha_config['max_font_size'] = $captcha_config['min_font_size'];
			
			// Generate CAPTCHA code if not set by user
			if( empty($captcha_config['code']) ) {
				$captcha_config['code'] = '';
				$length = mt_rand($captcha_config['min_length'], $captcha_config['max_length']);
				while( strlen($captcha_config['code']) < $length ) {
					$captcha_config['code'] .= substr($captcha_config['characters'], mt_rand() % (strlen($captcha_config['characters'])), 1);
				}
			}
			$image_src = site_url().'home/getCaptcha?_CAPTCHA&amp;t=' . urlencode(microtime());
			
			$cnfg = array('config'=>serialize($captcha_config));
			$this->session->set_userdata('captcha',$cnfg);	
			return array(
	        'code' => $captcha_config['code'],
	        'image_src' => $image_src
			);
		}
		public function getCaptcha()
		{	
			
			$captcha_cnf = array();		
			$cnf = $this->session->userdata('captcha');			
			$captcha_config = unserialize($cnf['config']);			
			
			if( !$captcha_config ) exit();
			
			//$this->session->unset_userdata('captcha');	    
			
			// Pick random background, get info, and start captcha
			$background = $captcha_config['backgrounds'][mt_rand(0, count($captcha_config['backgrounds']) -1)];
			list($bg_width, $bg_height, $bg_type, $bg_attr) = getimagesize($background);
			
			$captcha = imagecreatefrompng($background);
			
			$color = $this->hex2rgb($captcha_config['color']);
			$color = imagecolorallocate($captcha, $color['r'], $color['g'], $color['b']);
			
			// Determine text angle
			$angle = mt_rand( $captcha_config['angle_min'], $captcha_config['angle_max'] ) * (mt_rand(0, 1) == 1 ? -1 : 1);
			
			// Select font randomly
			$font = $captcha_config['fonts'][mt_rand(0, count($captcha_config['fonts']) - 1)];
			
			// Verify font file exists
			if( !file_exists($font) ) throw new Exception('Font file not found: ' . $font);
			
			//Set the font size.
			$font_size = mt_rand($captcha_config['min_font_size'], $captcha_config['max_font_size']);
			$text_box_size = imagettfbbox($font_size, $angle, $font, $captcha_config['code']);
			
			// Determine text position
			$box_width = abs($text_box_size[6] - $text_box_size[2]);
			$box_height = abs($text_box_size[5] - $text_box_size[1]);
			$text_pos_x_min = 0;
			$text_pos_x_max = ($bg_width) - ($box_width);
			$text_pos_x = mt_rand($text_pos_x_min, $text_pos_x_max);
			$text_pos_y_min = $box_height;
			$text_pos_y_max = ($bg_height) - ($box_height / 2);
			if ($text_pos_y_min > $text_pos_y_max) {
				$temp_text_pos_y = $text_pos_y_min;
				$text_pos_y_min = $text_pos_y_max;
				$text_pos_y_max = $temp_text_pos_y;
			}
			$text_pos_y = mt_rand($text_pos_y_min, $text_pos_y_max);
			
			// Draw shadow
			if( $captcha_config['shadow'] ){
				$shadow_color = $this->hex2rgb($captcha_config['shadow_color']);
				$shadow_color = imagecolorallocate($captcha, $shadow_color['r'], $shadow_color['g'], $shadow_color['b']);
				imagettftext($captcha, $font_size, $angle, $text_pos_x + $captcha_config['shadow_offset_x'], $text_pos_y + $captcha_config['shadow_offset_y'], $shadow_color, $font, $captcha_config['code']);
			}
			
			// Draw text
			imagettftext($captcha, $font_size, $angle, $text_pos_x, $text_pos_y, $color, $font, $captcha_config['code']);
			
			// Output image
			header("Content-type: image/png");
			imagepng($captcha);
		}
		function hex2rgb($hex_str, $return_string = false, $separator = ',') {
			$hex_str = preg_replace("/[^0-9A-Fa-f]/", '', $hex_str); // Gets a proper hex string
			$rgb_array = array();
			if( strlen($hex_str) == 6 ) {
				$color_val = hexdec($hex_str);
				$rgb_array['r'] = 0xFF & ($color_val >> 0x10);
				$rgb_array['g'] = 0xFF & ($color_val >> 0x8);
				$rgb_array['b'] = 0xFF & $color_val;
				} elseif( strlen($hex_str) == 3 ) {
				$rgb_array['r'] = hexdec(str_repeat(substr($hex_str, 0, 1), 2));
				$rgb_array['g'] = hexdec(str_repeat(substr($hex_str, 1, 1), 2));
				$rgb_array['b'] = hexdec(str_repeat(substr($hex_str, 2, 1), 2));
				} else {
				return false;
			}
			return $return_string ? implode($separator, $rgb_array) : $rgb_array;
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
