<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . 'libraries/Model.php';

class LogsModel extends yidas\Model {

    function __construct(){
        // Call the Model constructor
        parent::__construct();
       $this->table = 'ks_logs';

    }

}
?>
