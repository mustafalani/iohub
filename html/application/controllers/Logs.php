<?php 
error_reporting(E_ALL);
ini_set('display_errors',1);
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once("application/third_party/ssp.class.php");
class Logs extends CI_Controller {
	
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
		$this->load->model('common_model');  
		$this->load->model('LogsModel');
	}
	public function index()
	{
		$this->breadcrumbs->push('Logs', '/logs');
		$segment = $this->uri->segment(3);
		$this->load->view('admin/header');
		$this->load->view('admin/logs');
		$this->load->view('admin/footer');
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
		    'pass' => 'iihdudrekuvoweehyffyxrirtaorhlo',
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
		echo json_encode($returnJson,JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE);
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
}
