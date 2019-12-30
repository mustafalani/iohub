<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Groupadmin_model extends CI_Model {   
    function __construct(){
        parent::__construct();   
        $this->load->database();   
    }
    function getConfigurationsDetails($userid=0,$groupid=0)
	{	
		$this->db->select("*");
		$this->db->from("ks_wowza");
		if($userid>0){
			$this->db->where(array('uid'=>$userid));
		}
		if($groupid>0){
			$this->db->or_where(array('group_id'=>$groupid));
		}

		$this->db->order_by('id','DESC');
		return $this->db->get()->result_array();
	}
	function getAllEncodersbyUserIdAndGroupId($uid=0,$gid=0)
    {
		$this->db->select("*");
		$this->db->from("ks_encoder");
		if($uid > 0)
		{
			$this->db->where('uid',$uid);	
		}
		if($gid>0)
		{
			$this->db->or_where('encoder_group',$gid);	
		}
		
		$this->db->order_by('id','DESC');
		return $this->db->get()->result_array();
	}
	function getAllOnlineEncodersbyUserIdAndGroupIdAndEncdi($userid=0,$gid=0,$encid=0)
    {    	
    	if(sizeof($gid)>0)
		{
			if($encid > 0)
			{
				$sql ="Select * from (SELECT * FROM ks_encoder WHERE  uid =".$userid." or encoder_group=".$gid.") as t1 where status=1 or id=".$encid." ORDER BY t1.id DESC";
			}
			else
			{
				$sql ="Select * from (SELECT * FROM ks_encoder WHERE  uid =".$userid." or encoder_group=".$gid.") as t1 where status=1 ORDER BY t1.id DESC";
			}
		}
		else
		{
			if($encid > 0)
			{
				$sql ="Select * from (SELECT * FROM ks_encoder WHERE  uid =".$userid.") as t1 where status=1 or id=".$encid." ORDER BY t1.id DESC";
			}
			else
			{
				$sql ="Select * from (SELECT * FROM ks_encoder WHERE  uid =".$userid.") as t1 where status=1 ORDER BY t1.id DESC";
			}
		}		
		$code = $this->db->error(); 
		if($code['code'] > 0)
	    {	      	
		  show_error('Message');
	    }
		return $this->db->query($sql)->result_array();
	}
	function getAllOnlineEncodersbyUserIdAndGroupId($userid=0,$gid=0)
    {
		if(sizeof($gid)>0)
		{
			$sql ="Select * from (SELECT * FROM ks_encoder WHERE  uid =".$userid." or encoder_group=".$gid.") as t1 where status=1 ORDER BY t1.id DESC";	
		}
		else
		{
			$sql ="Select * from (SELECT * FROM ks_encoder WHERE  uid =".$userid.") as t1 where status=1 ORDER BY t1.id DESC";
		}		
		$code = $this->db->error(); 
		if($code['code'] > 0)
	    {	      	
		  show_error('Message');
	    }
		return $this->db->query($sql)->result_array();
	}
	function getAllGatewaysbyUserIdAndGroupId($uid=0,$gid=0)
    {
		$this->db->select("*");
		$this->db->from("ks_gateways");
		if($gid>0)
		{
			$this->db->or_where('encoder_group',$gid);	
		}
		if($uid > 0)
		{
			$this->db->or_where('uid',$uid);	
		}
		$this->db->order_by('id','DESC');
		return $this->db->get()->result_array();
	}
	function getEncoderTemplatebyUserId($uid=0)
    {
		$this->db->select('ks_encoding_template.*');
       $this->db->from('ks_encoding_template');
       if($uid > 0)
       {
	   	$this->db->or_where('uid',$uid);  	
	   }	   
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getAllApplicationsByWowzaIdAndUserId($wowzid=array(),$userid)
	{
		if(sizeof($wowzid)>0)
		{
			$sql ="Select * from (SELECT * FROM ks_application WHERE  uid =".$userid." or live_source IN(".implode(",",$wowzid).")) as t1 where status=1 ORDER BY t1.id DESC";	
		}
		else
		{
			$sql ="Select * from (SELECT * FROM ks_application WHERE  uid =".$userid.") as t1 where status=1 ORDER BY t1.id DESC";
		}
		
		$code = $this->db->error(); 
		if($code['code'] > 0)
	    {	      	
		  show_error('Message');
	    }
		return $this->db->query($sql)->result_array();
	}
	function getAllArchiveApplicationsByWowzaIdAndUserId($wowzid=array(),$userid,$vars)
	{		
		if(sizeof($wowzid)>0)
		{
			$sql ="Select * from (SELECT * FROM ks_application WHERE  uid =".$userid." or live_source IN(".implode(",",$wowzid).")) as t1 where status=0 ORDER BY t1.id DESC LIMIT ".$vars['start'].",".$vars['length'];
		}
		else
		{
			$sql ="Select * from (SELECT * FROM ks_application WHERE  uid =".$userid.") as t1 where status=0 ORDER BY t1.id DESC LIMIT ".$vars['start'].",".$vars['length'];
		}
		
		$code = $this->db->error(); 
		if($code['code'] > 0)
	    {	      	
		  show_error('Message');
	    }
		return $this->db->query($sql)->result_array();
	}
	function getAllTotalArchiveApplicationsByWowzaIdAndUserId($wowzid=array(),$userid)
	{		
		if(sizeof($wowzid)>0)
		{
			$sql ="Select count(*) as total from (SELECT * FROM ks_application WHERE  uid =".$userid." or live_source IN(".implode(",",$wowzid).")) as t1 where status=0 ORDER BY t1.id DESC";
		}
		else
		{
			$sql ="Select count(*) as total from (SELECT * FROM ks_application WHERE  uid =".$userid.") as t1 where status=0 ORDER BY t1.id DESC";
		}
		
		$code = $this->db->error(); 
		if($code['code'] > 0)
	    {	      	
		  show_error('Message');
	    }
		return $this->db->query($sql)->result_array();		
	}
	function getAllTargetsbyWowzaAndAppid($appids = array(),$user_id=0)
	{
		if(sizeof($appids)>0)
		{
			$sql ="Select * from (SELECT * FROM ks_target WHERE  uid =".$user_id." or wowzaengin IN(".implode(",",$appids).")) as t1 where status=1 ORDER BY t1.id DESC";
		}
		else
		{
			$sql ="Select * from (SELECT * FROM ks_target WHERE  uid =".$user_id.") as t1 where status=1 ORDER BY t1.id DESC";
		}
		
		$code = $this->db->error(); 
		if($code['code'] > 0)
	    {	      	
		  show_error('Message');
	    }
		return $this->db->query($sql)->result_array();
	}
	function getAllArchiveTargetsbyWowzaAndAppid($appids = array(),$user_id=0,$vars)
	{
		if(sizeof($appids)>0)
		{
			$sql ="Select * from (SELECT * FROM ks_target WHERE  uid =".$user_id." or wowzaengin IN(".implode(",",$appids).")) as t1 where status=0 ORDER BY t1.id DESC LIMIT ".$vars['start'].",".$vars['length'];
		}
		else
		{
			$sql ="Select * from (SELECT * FROM ks_target WHERE  uid =".$user_id.") as t1 where status=0 ORDER BY t1.id DESC LIMIT ".$vars['start'].",".$vars['length'];
		}
		
		$code = $this->db->error(); 
		if($code['code'] > 0)
	    {	      	
		  show_error('Message');
	    }
		return $this->db->query($sql)->result_array();		
	}
	function getAllTotalArchiveTargetsbyWowzaAndAppid($appids = array(),$user_id=0)
	{
		if(sizeof($appids)>0)
		{
			$sql ="Select count(*) as total from (SELECT * FROM ks_target WHERE  uid =".$user_id." or wowzaengin IN(".implode(",",$appids).")) as t1 where status=0 ORDER BY t1.id DESC";
		}
		else
		{
			$sql ="Select count(*) as total from (SELECT * FROM ks_target WHERE  uid =".$user_id.") as t1 where status=0 ORDER BY t1.id DESC";
		}
		$code = $this->db->error(); 
		if($code['code'] > 0)
	    {	      	
		  show_error('Message');
	    }
		return $this->db->query($sql)->result_array();		
	}
	 function getEncoderProfilesByUseridAndGroupId($uid,$gid)
    {
		$this->db->select('ks_encoding_template.*');
       $this->db->from('ks_encoding_template');
       $this->db->where('status',1);
       if($uid >0)
       {
	   		$this->db->where('uid',$uid);
	   }
	   if($gid >0)
       {
	   	$this->db->or_where('group_id',$gid);
	   }
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
} 


?>