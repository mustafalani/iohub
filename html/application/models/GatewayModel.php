<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GatewayModel extends yidas\Model {
    
    function __construct(){
        // Call the Model constructor
        parent::__construct();   
       $this->table = 'ks_gateway_channels';       
       
    }
       
} 
?>