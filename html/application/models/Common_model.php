<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model {
    public $status; 
    public $roles;    
    function __construct(){
        // Call the Model constructor
        parent::__construct();   
        $this->load->database();     
        $this->status = $this->config->item('status');
        $this->roles = $this->config->item('roles');
    }
    function getWrokflowbyId($wid)
    {
	   $this->db->select('ks_workflow.*');
       $this->db->from('ks_workflow');  
       $this->db->where('workflow_id',$wid);  
       $code = $this->db->error(); 
       if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getOutputFormats()
    {
	   $this->db->select('ks_output_format.*');
       $this->db->from('ks_output_format');    
       $code = $this->db->error(); 
       if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getOutputFormatsValueByItem($id)
    {
	   $this->db->select('ks_output_format.*');
       $this->db->from('ks_output_format');  
       $this->db->where('item',$id);  
       $code = $this->db->error(); 
       if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getEncoderAudioInputs()
    {	
	   $this->db->select('ks_encoder_audio_inputs.*');
       $this->db->from('ks_encoder_audio_inputs');    
       $code = $this->db->error(); 
       if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getEncoderOutbyEncid($encid)
    {
		$this->db->select('ks_encoder_destinations.*');
       $this->db->from('ks_encoder_destinations');    
       $this->db->where('encid',$encid);  
       $code = $this->db->error(); 
       if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getEncoderInpOutbyEncid($encid)
    {
		$this->db->select('ks_encoder_sources.*');
       $this->db->from('ks_encoder_sources');    
       $this->db->where('encid',$encid);  
       $code = $this->db->error(); 
       if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getHardwareModelByEncId($encid,$harwareId)
    {
		$this->db->select('ks_encoder_hardware.*');
       $this->db->from('ks_encoder_hardware');    
       $this->db->where('encid',$encid);  
       $this->db->where('model_id',$harwareId);       
       $code = $this->db->error(); 
       if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getHardwareByEncId($encid,$harwareId)
    {
		$this->db->select('ks_encoder_hardware.*');
       $this->db->from('ks_encoder_hardware');    
       $this->db->where('encid',$encid);  
       $this->db->where('hardware_id',$harwareId);       
       $code = $this->db->error(); 
       if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getHardwareByEncdrId($encid)
    {
		$this->db->select('ks_encoder_hardware.*');
       $this->db->from('ks_encoder_hardware');    
       $this->db->where('encid',$encid);  
       $code = $this->db->error(); 
       if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getInpOutByEncId($encid)
    {
		$this->db->select('ks_encoder_sources.*');
       $this->db->from('ks_encoder_sources');    
       $this->db->where('encid',$encid);       
       $code = $this->db->error(); 
       if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getInpOutByEncIdAndName($encid,$name)
    {
		$this->db->select('ks_encoder_sources.*');
       $this->db->from('ks_encoder_sources');    
       $this->db->where('inp_source',$name);    
       $this->db->where('encid',$encid);       
       $code = $this->db->error(); 
       if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getOutByEncIdAndName($encid,$name)
    {
		$this->db->select('ks_encoder_destinations.*');
       $this->db->from('ks_encoder_destinations');    
       $this->db->where('out_destination',$name);    
       $this->db->where('encid',$encid);       
       $code = $this->db->error(); 
       if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    public function updateGatewayChannel($data,$id)
    {
		$this->db->where('id', $id);
        $this->db->update('ks_gateway_channels', $data); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $this->db->affected_rows(); 
	}
    public function updateBank($data,$id)
    {
		$this->db->where('id', $id);
        $this->db->update('ks_banks', $data); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $this->db->affected_rows(); 
	}
    function deleteLogs($id)
	{	          
       $this->db->where('id', $id);	
       $this->db->delete('ks_logs');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->affected_rows();
	}
	function deletGatewayChannel($id)
	{
		$this->db->where('id', $id);	
       $this->db->delete('ks_gateway_channels');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->affected_rows();
	}
	function deletBank($id)
	{
		$this->db->where('id', $id);	
       $this->db->delete('ks_banks');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->affected_rows();
	}
    function getPermissionNames()
    {
		return $this->db->list_fields('ks_permissions');
	}
	function getGatewayChannelsType()
	{		
	   $this->db->select('ks_gateway_channels_type.name');
       $this->db->from('ks_gateway_channels_type');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getLanguages($gid)
    {
		$this->db->select('ks_languages.*');
       $this->db->from('ks_languages');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getAudioChannels()
    {
		$this->db->select('ks_audio_channels.*');
       $this->db->from('ks_audio_channels');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getGroupWowaas($gid)
    {
		$this->db->select('ks_wowza.*');
       $this->db->from('ks_wowza');    
       $this->db->where('group_id',$gid);       
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getGroupEncoders($gid)
    {
		$this->db->select('ks_encoder.*');
       $this->db->from('ks_encoder');    
       $this->db->where('encoder_group',$gid);       
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getVideoCodec()
	{		
		$this->db->select('ks_video_codec.*');
       $this->db->from('ks_video_codec');         
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getAudioSampleRate()
    {
		$this->db->select('ks_audio_sample_rate.*');
       $this->db->from('ks_audio_sample_rate');         
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getAudioBitrate()
    {
		$this->db->select('ks_audio_bitrate.*');
       $this->db->from('ks_audio_bitrate');         
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getVideoProfile()
    {
		$this->db->select('ks_video_profile.*');
       $this->db->from('ks_video_profile');         
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getVideoPreset()
    {
		$this->db->select('ks_video_preset.*');
       $this->db->from('ks_video_preset');         
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getResolution()
    {
		$this->db->select('ks_video_resolution.*');
       $this->db->from('ks_video_resolution');         
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getIoTStreambyId($Id)
    {
		$this->db->select('ks_iotstreams.*');
		$this->db->from('ks_iotstreams');
       $this->db->where('id',$Id);  
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getChannelbyId($Id)
	{
		$this->db->select('ks_channels.*');
		$this->db->from('ks_channels');
		$this->db->where('id',$Id);
		$code = $this->db->error();
		if ($code['code'] > 0) {
			show_error('Message');
		}
		return $this->db->get()->result_array();
	}
	function getChannelbyProcessName($processname)
    {
		$this->db->select('ks_channels.*');
       $this->db->from('ks_channels');
       $this->db->where('process_name',$processname);  
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getAllChannelsByUserids($id)
    {
	   $this->db->select('ks_channels.*');
       $this->db->from('ks_channels');
       $this->db->where('status',1); 
       if($id > 0)
       {
	   		$this->db->where_in('uid',$id);  	
	   }
       $this->db->order_by('id','desc');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getAllArchiveChannelsByUserids($id,$vars)
    {    	
	   $this->db->select('*');
       $this->db->from('ks_channels');
       $this->db->where('status',0);      
       if(sizeof($id) > 0)
       {
	   		$this->db->where_in('uid',$id);  	
	   }
       $this->db->order_by('id','desc');
       $this->db->limit($vars['length'],$vars['start']);
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getAllTotalArchiveChannelsByUserids($id)
    {
	   $this->db->select('count(id)as total');
       $this->db->from('ks_channels');
       $this->db->where('status',0);      
       if(sizeof($id) > 0)
       {
	   		$this->db->where_in('uid',$id);  	
	   }
       $this->db->order_by('id','desc');
      
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	
	function getArchiveChannels($id)
	{
	   $this->db->select('ks_channels.*');
       $this->db->from('ks_channels');
       $this->db->where('status',0); 
       if($id > 0)
       {
	   		$this->db->where('uid',$id);  	
	   }
       $this->db->order_by('id','desc');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getAllArchiveChannels($id,$vars)
	{
	   $this->db->select('*');
       $this->db->from('ks_channels');
       $this->db->where('status',0); 
       if($id > 0)
       {
	   		$this->db->where('uid',$id);  	
	   }
       $this->db->order_by('id','desc');  
       $this->db->limit($vars['length'],$vars['start']);
	   $code = $this->db->error(); 
	   if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getAllTotalArchiveChannels($id)
	{
	   $this->db->select('count(id) as total');
       $this->db->from('ks_channels');
       $this->db->where('status',0); 
       if($id > 0)
       {
	   		$this->db->where('uid',$id);  	
	   }
       $this->db->order_by('id','desc');  
	   $code = $this->db->error(); 
	   if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getAllChannels($id)
    {
	   $this->db->select('ks_channels.*');
       $this->db->from('ks_channels');
       $this->db->where('status',1); 
       if($id > 0)
       {
	   		$this->db->where('uid',$id);  	
	   }
       $this->db->order_by('id','desc');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getAllIoTStreams($id)
	{
		$this->db->select('ks_iotstreams.*');
		$this->db->from('ks_iotstreams');
		$this->db->where('status',1);
		if ($id > 0) {
			$this->db->where('id',$id);
		}
		$this->db->order_by('id','desc');
		$code = $this->db->error();
		if ($code['code'] > 0) {
			show_error('Message');
		}
		return $this->db->get()->result_array();
	}
    function getInputName($id)
    {
	   $this->db->select('ks_encoder_input.*');
       $this->db->from('ks_encoder_input');
       $this->db->where('id',$id);  
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getOutputName($id)
    {
	   $this->db->select('ks_encoder_output.*');
       $this->db->from('ks_encoder_output');
       $this->db->where('id',$id);  
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getEncodingTemplateById($id)
	{
	   $this->db->select('ks_encoding_template.*');
       $this->db->from('ks_encoding_template');
       $this->db->where('id',$id);  
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getNebula($gid=0)
    {
		$this->db->select('ks_nebula.*');
       $this->db->from('ks_nebula');
       if($gid > 0)
       {
		   $this->db->where_in('encoder_group',$gid);  	
	   }
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
	   $this->db->order_by('id','DESC');
       return $this->db->get()->result_array();
	}
	function getNebulabyId($id=0)
    {
		$this->db->select('ks_nebula.*');
       $this->db->from('ks_nebula');
       if($id > 0)
       {
	   	$this->db->where('id',$id);  	
	   }
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
	   $this->db->order_by('id','DESC');
       return $this->db->get()->result_array();
	}
    function getEncoderTemplate($uid=0)
    {
		$this->db->select('ks_encoding_template.*');
       $this->db->from('ks_encoding_template');
       if($uid > 0)
       {
	   	$this->db->where('uid',$uid);  	
	   }
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
	   $this->db->order_by('id','DESC');
       return $this->db->get()->result_array();
	}
	function getEncoderInputbyId($id)
	{
		$this->db->select('ks_encoder_input.*');
       $this->db->from('ks_encoder_input');
       $this->db->where('id',$id); 
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getEncoderInputs()
    {
		$this->db->select('ks_encoder_input.*');
       $this->db->from('ks_encoder_input');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getEncoderInputsBYtYPE($type)
    {
		$this->db->select('ks_encoder_input.*');
       $this->db->from('ks_encoder_input');
       $this->db->where('type',$type);
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getEncoderOutput()
    {
		$this->db->select('ks_encoder_output.*');
       $this->db->from('ks_encoder_output');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getEncoderOutputbyType($type)
    {
		$this->db->select('ks_encoder_output.*');
       $this->db->from('ks_encoder_output');
       $this->db->where('type',$type);
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getEncoderProfiles()
    {
		$this->db->select('ks_encoding_template.*');
       $this->db->from('ks_encoding_template');
       $this->db->where('status',1);
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getChannelInputs()
    {
		$this->db->select('ks_channel_input.*');
       $this->db->from('ks_channel_input');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getChannelOutput()
    {
		$this->db->select('ks_channel_output.*');
       $this->db->from('ks_channel_output');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getAllModels()
    {
		$this->db->select('ks_model_master.*');
       $this->db->from('ks_model_master');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getAllModelsbyID($Id)
    {
		$this->db->select('ks_model_master.*');
		$this->db->where('id',$Id); 
       $this->db->from('ks_model_master');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}   
    function getAllHardware($id=0)
    {
		$this->db->select('ks_hardware_master.*');
       $this->db->from('ks_hardware_master');
       if($id>0)
       {
	   	 $this->db->where('id',$id);   
	   }
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}	
    function getWowzaApps($id)
    {
	   $this->db->select('ks_application.*');
       $this->db->from('ks_application');
       $this->db->where('live_source',$id); 
       $this->db->where('status',1);   
        	
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $result = $this->db->get()->result_array();
	}
	function getTargetbyAppID($appid)
	{
		$this->db->select('ks_target.*');
       $this->db->from('ks_target');
       $this->db->where('wowzaengin',$appid);   
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getTargetbyId($appid)
    {
	   $this->db->select('ks_target.*');
       $this->db->from('ks_target');
       $this->db->where('id',$appid);   
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	
	function deleteTemplate($id)
	{
		$this->db->where('id', $id);	
       $this->db->delete('ks_encoding_template');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->affected_rows();
	}
	function deleteTargetsbyAppId($id)
	{
		$this->db->where('wowzaengin', $id);	
       $this->db->delete('ks_target');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->affected_rows();
	}
	public function updateChannels($data,$id)
    {
		$this->db->where('id', $id);
        $this->db->update('ks_channels', $data); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $this->db->affected_rows(); 
	}
	public function updateIoTStreamByStreamId($data, $id)
	{
		$this->db->where('process_name', $id);
		$this->db->update('ks_iotstreams', $data);
		$code = $this->db->error();
		if ($code['code'] > 0) {
			show_error('Message');
		}
		return $this->db->affected_rows();
	}
	public function updateChannelByChannelId($data,$id)
    {
		$this->db->where('process_name', $id);
        $this->db->update('ks_channels', $data); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $this->db->affected_rows(); 
	}
	function updateTemplate($data,$id)
	{
		$this->db->where('id', $id);	
       $this->db->update('ks_encoding_template',$data);
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->affected_rows();
	}
	function deleteUsers($id)
	{
		$this->db->where('id', $id);	
        $this->db->delete('ks_users');
        $code = $this->db->error(); if($code['code'] > 0)
	    {	      	
		  show_error('Message');
	    }
        return $this->db->affected_rows();		
	}
	function deleteTarget($id)
	{
		$this->db->where('id', $id);	
       $this->db->delete('ks_target');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->affected_rows();
	}
	
	
    function getAppbyId($appid)
    {
	   $this->db->select('ks_application.*');
       $this->db->from('ks_application');
       $this->db->where('id',$appid);   
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $result = $this->db->get()->result_array();
	}
    function getAdminGroupInfo()
    {
	   $this->db->select('ks_groups.*');
       $this->db->from('ks_groups');
       $this->db->where('group_type','Admin');   
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $result = $this->db->get()->result_array();
	}
	function getGroupImage($id)
	{
	   $this->db->select('ks_group_pics.*');
       $this->db->from('ks_group_pics');
       $this->db->where('gid',$id);
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $result = $this->db->get()->result_array();
	}
	function getGroupInfobyId($id)
    {
	   $this->db->select('ks_groups.*');
       $this->db->from('ks_groups');
       $this->db->where('id',$id);   
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $result = $this->db->get()->result_array();
	}
    function getUserPermission($uid)
    {
	   $this->db->select('ks_permissions.*');
       $this->db->from('ks_permissions');
       $this->db->where('rid',$uid);   
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $result = $this->db->get()->result_array();
	}
    function getGroups($id=0)
    {
	   $this->db->select('ks_groups.*');
       $this->db->from('ks_groups');
       $this->db->where('group_type IS NULL');  
       if($id > 0)
       {
	   		$this->db->where('uid',$id);	
	   }
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $result = $this->db->get()->result_array();
	}
	
	function getUserbyId($id)
	{
		$this->db->select('u.*,g.group_name');
       $this->db->from('ks_users u');
	   $this->db->join('ks_groups g', 'g.id=u.group_id');
       $this->db->where('u.id',$id);
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $result = $this->db->get()->result_array();
	}
		function getAdminDataUserbyId($id)
	{
		$this->db->select('*');
       $this->db->from('ks_users');
       $this->db->where('id',$id);
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $result = $this->db->get()->result_array();
	}
	
	function getUsers()
    {
	   $this->db->select('ks_users.*');
       $this->db->from('ks_users');
       $this->db->where_in('role_id',array('2','3'));      
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $result = $this->db->get()->result_array();
	}
	function getUsersByGroupIds($group_ids)
    {	
	   $this->db->select('ks_users.*');
       $this->db->from('ks_users');
       $this->db->where_in('role_id',array(2,3));
	   $this->db->where_in('group_id',$group_ids);     
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $result = $this->db->get()->result_array();
	}
	//get user for logged group admin belong to that group
	function getUsersByGroupId($group_id=0)
    {	
	   $this->db->select('ks_users.*');
       $this->db->from('ks_users');
       $this->db->where_in('role_id',array('3'));
	   $this->db->where_in('group_id',$group_id);     
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $result = $this->db->get()->result_array();
	}

	
	function getallGroups()
    {
	   $this->db->select('ks_groups.*');
       $this->db->from('ks_groups');
       $this->db->where('group_type IS NULL');   
	   $this->db->where('status',1); 
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $result = $this->db->get()->result_array();
	}
	function getallUsers()
    {
	   $this->db->select('ks_users.*');
       $this->db->from('ks_users');
       $this->db->where_in('role_id',array('2','3'));     
	   $this->db->where('status',1);  
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $result = $this->db->get()->result_array();
	}
	
	function getallUsersForGroupAdmin($getGroupId)
    {
		//vikas
	   $this->db->select('ks_users.*');
       $this->db->from('ks_users');
	   $this->db->where('group_id',$getGroupId); 	   
	   $this->db->where('status',1);  
       $this->db->where_in('role_id',array('3')); 
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $result = $this->db->get()->result_array();
	}
	function insertLogs($name,$log_type,$message,$uid,$status)
	{
		$logs = array(
			'name'=>$name,
			'log_type'=>$log_type,
			'message'=>$message,
			'created'=>time(),
			'uid'=>$uid,
			'status'=>$status
		);
		$q = $this->db->insert_string('ks_logs',$logs);             
        $this->db->query($q);
        return $this->db->insert_id();
	}
	function insertEncoderHardware($hardwareData)
	{
		$q = $this->db->insert_string('ks_encoder_hardware',$hardwareData);             
        $this->db->query($q);
        return $this->db->insert_id();
	}
	function insertEncoderHardwareInpOut($InpOut)
	{
		$q = $this->db->insert_string('ks_encoder_sources',$InpOut);             
        $this->db->query($q);
        return $this->db->insert_id();
	}
	function insertEncoderHardwareOut($InpOut)
	{
		$q = $this->db->insert_string('ks_encoder_destinations',$InpOut);             
        $this->db->query($q);
        return $this->db->insert_id();
	}
	function insertBank($bankData)
	{
		$q = $this->db->insert_string('ks_banks',$bankData);             
        $this->db->query($q);
        return $this->db->insert_id();
	}
	function insertGatewayChannel($channel)
	{
		$q = $this->db->insert_string('ks_gateway_channels',$channel);             
        $this->db->query($q);
        return $this->db->insert_id();
	}
	function insertUserPermissions($permisison)
	{
		$q = $this->db->insert_string('ks_permissions',$permisison);             
        $this->db->query($q);
        return $this->db->insert_id();
	}
	public function getProfileData($id)
    {
		$new_array = array();
		$this->db->select('*');
		$this->db->from('ks_users');
		$this->db->where(array('ks_users.id'=>$id));
		$getProfileData = $this->db->get()->result_array();
		//echo '<pre>';print_r($getProfileData);die;
		if(isset($getProfileData[0]) && !empty($getProfileData[0])){
			$new_array[0] = $getProfileData[0];
			$user_id = isset($getProfileData[0]['id'])?$getProfileData[0]['id']:0;
			
			if($user_id>0){
				$getUsersImage = $this->getUsersImage($user_id);
				$new_array[0]['user_profile'] =isset($getUsersImage[0]['name'])?$getUsersImage[0]['name']:"";
			}
		}
		return $new_array;
	}
    function insertComplaint($data)
	{
		$q = $this->db->insert_string('iccr_complaints',$data);             
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error(); if($code['code'] > 0)
	    {	      	
		  show_error('Message');
		}
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function getAllGatewayChannels($id,$uid,$bankid)
	{
		$this->db->select("*");
		$this->db->from("ks_gateway_channels");
		if($id>0)
		{
			$this->db->where('id',$id);	
		}
		if($uid > 0)
		{
			$this->db->where('uid',$uid);	
		}
		if($bankid > 0)
		{
			$this->db->where('bank_id',$bankid);	
		}
		return $this->db->get()->result_array();
	}
	function getAllBanks($id=0,$uid=0)
    {
		$this->db->select("*");
		$this->db->from("ks_banks");
		if($id>0)
		{
			$this->db->where('id',$id);	
		}
		if($uid > 0)
		{
			$this->db->where('uid',$uid);	
		}
		$this->db->order_by('id','ASC');
		return $this->db->get()->result_array();
	}
	function updateTarget($id,$data)
	{
		$this->db->where('id', $id);		
		$this->db->update('ks_target', $data); 
        return $this->db->affected_rows(); 
	}
	function updateTargetbyAppID($id,$data)
	{
		$this->db->where('wowzaengin', $id);		
		$this->db->update('ks_target', $data); 
        return $this->db->affected_rows(); 
	}
	function updateApplication($id,$data)
	{
		$this->db->where('id', $id);		
		$this->db->update('ks_application', $data); 
        return $this->db->affected_rows(); 
	}
	function updatePermissions($uid,$permisisons)
	{
		$this->db->where('rid', $uid);		
		$this->db->update('ks_permissions', $permisisons); 
        return $this->db->affected_rows(); 
	}
    function updateProfilePassword($data)
	{
		$this->db->where('id', $data['id']);		
		$this->db->update('iccr_users', $data); 
        $success = $this->db->affected_rows(); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($success >= 0)
        	return TRUE;
        else
         	return FALSE;
	}
    function oldPasswordMatched($id,$pass)
    {
	   $this->db->select('ks_users.fname,ks_users.email_id');
       $this->db->from('ks_users');
       $this->db->where(array('password'=>$pass,'id'=>$id)); 
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
		  }
       return $this->db->get()->result_array();
	}
    function getHeadquarterInfo($uid)
    {
		$this->db->select('iccr_users.username,iccr_users.email_id,iccr_headquarters.*');
       $this->db->from('iccr_users');
       $this->db->join('iccr_headquarters', 'iccr_headquarters.uid = iccr_users.id');   
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }    
       return $this->db->get()->result_array();
	}
	function updateProfileHeadquarterName($data)
	{
		$this->db->where('id', $data['id']);		
		$this->db->update('iccr_users', $data); 
        $success = $this->db->affected_rows(); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($success >= 0)
        	return TRUE;
        else
         	return FALSE;
	}
    function updateProfileHeadquarter($data)
    {
		$this->db->where('uid', $data['uid']);		
		$this->db->update('iccr_headquarters', $data); 
        $success = $this->db->affected_rows(); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($success >= 0)
        	return TRUE;
        else
         	return FALSE;
	}
    function updateProfileRegion($data)
    {
		$this->db->where('id', $data['id']);		
		$this->db->update('iccr_regions', $data); 
        $success = $this->db->affected_rows(); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($success >= 0)
        	return TRUE;
        else
         	return FALSE;
	}
    function updateProfileMission($data)	
	{
		$this->db->where('id', $data['id']);		
		$this->db->update('iccr_missions', $data); 
        $success = $this->db->affected_rows(); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($success >= 0)
        	return TRUE;
        else
         	return FALSE;
	}
    function getAllCourseType()
    {
		$this->db->select('*');
       $this->db->from('iccr_course_type');  
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    /* Expenditure Report Start	*/
    function getStudentDayExpenditure($fy,$schem,$region,$quarter,$month)
    {
		$this->db->select('fy,scheme,regionId,sd_amount as amount');  
	   $this->db->from('iccr_exp_student_day');    
	   if($fy != "")
	   {
	   	  $this->db->where('iccr_exp_student_day.fy',$fy);
	   }
	   if($schem != "" && $schem != "all" && $schem > 0)
	   {
	   	  $this->db->where('iccr_exp_student_day.scheme',$schem);
	   }
	   if($region != "" && $region != "all" && $region > 0)
	   {
	   	  $this->db->where('iccr_exp_student_day.regionId',$region);
	   }
	   if($quarter != "" && $quarter != "all" && $quarter > 0)
	   {
	   	  if($quarter == 1)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('4','5','6'));
		  }
		  if($quarter == 2)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('7','8','9'));
		  }
		  if($quarter == 3)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('10','11','12'));
		  }
		  if($quarter == 4)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('1','2','3'));
		  }	   	 
	   }
	   if($month != "" && $month != "all" && $month > 0)
	   {
	   	 $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=',$month);
	   }
       	$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getEmergencyFundExpenditure($fy,$schem,$region,$quarter,$month)
    {
		$this->db->select('fy,scheme,regionId,ef_amount as amount');  
	   $this->db->from('iccr_exp_emergency_fund');    
	   if($fy != "")
	   {
	   	  $this->db->where('iccr_exp_emergency_fund.fy',$fy);
	   }
	   if($schem != "" && $schem != "all" && $schem > 0)
	   {
	   	  $this->db->where('iccr_exp_emergency_fund.scheme',$schem);
	   }
	   if($region != "" && $region != "all" && $region > 0)
	   {
	   	  $this->db->where('iccr_exp_emergency_fund.regionId',$region);
	   }
	   if($quarter != "" && $quarter != "all" && $quarter > 0)
	   {
	   	  if($quarter == 1)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('4','5','6'));
		  }
		  if($quarter == 2)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('7','8','9'));
		  }
		  if($quarter == 3)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('10','11','12'));
		  }
		  if($quarter == 4)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('1','2','3'));
		  }	   	 
	   }
	   if($month != "" && $month != "all" && $month > 0)
	   {
	   	 $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=',$month);
	   }
       	$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getSumptuaryExpenditure($fy,$schem,$region,$quarter,$month)
    {
		$this->db->select('fy,scheme,regionId,sump_amount as amount');  
	   $this->db->from('iccr_exp_sumptuary');    
	   if($fy != "")
	   {
	   	  $this->db->where('iccr_exp_sumptuary.fy',$fy);
	   }
	   if($schem != "" && $schem != "all" && $schem > 0)
	   {
	   	  $this->db->where('iccr_exp_sumptuary.scheme',$schem);
	   }
	   if($region != "" && $region != "all" && $region > 0)
	   {
	   	  $this->db->where('iccr_exp_sumptuary.regionId',$region);
	   }
	   if($quarter != "" && $quarter != "all" && $quarter > 0)
	   {
	   	  if($quarter == 1)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('4','5','6'));
		  }
		  if($quarter == 2)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('7','8','9'));
		  }
		  if($quarter == 3)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('10','11','12'));
		  }
		  if($quarter == 4)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('1','2','3'));
		  }	   	 
	   }
	   if($month != "" && $month != "all" && $month > 0)
	   {
	   	 $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=',$month);
	   }
       	$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getISAExpenditure($fy,$schem,$region,$quarter,$month)
    {
		$this->db->select('fy,scheme,regionId,isa_amount as amount');  
	   $this->db->from('iccr_exp_isa_meeting');    
	   if($fy != "")
	   {
	   	  $this->db->where('iccr_exp_isa_meeting.fy',$fy);
	   }
	   if($schem != "" && $schem != "all" && $schem > 0)
	   {
	   	  $this->db->where('iccr_exp_isa_meeting.scheme',$schem);
	   }
	   if($region != "" && $region != "all" && $region > 0)
	   {
	   	  $this->db->where('iccr_exp_isa_meeting.regionId',$region);
	   }
	   if($quarter != "" && $quarter != "all" && $quarter > 0)
	   {
	   	  if($quarter == 1)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('4','5','6'));
		  }
		  if($quarter == 2)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('7','8','9'));
		  }
		  if($quarter == 3)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('10','11','12'));
		  }
		  if($quarter == 4)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('1','2','3'));
		  }	   	 
	   }
	   if($month != "" && $month != "all" && $month > 0)
	   {
	   	 $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=',$month);
	   }
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }	
       return $this->db->get()->result_array();
	}
    function getCampsExpenditure($fy,$schem,$region,$quarter,$month)
    {
		$this->db->select('fy,scheme,regionId,camps_amount as amount');  
	   $this->db->from('iccr_exp_camps');    
	   if($fy != "")
	   {
	   	  $this->db->where('iccr_exp_camps.fy',$fy);
	   }
	   if($schem != "" && $schem != "all" && $schem > 0)
	   {
	   	  $this->db->where('iccr_exp_camps.scheme',$schem);
	   }
	   if($region != "" && $region != "all" && $region > 0)
	   {
	   	  $this->db->where('iccr_exp_camps.regionId',$region);
	   }
	   if($quarter != "" && $quarter != "all" && $quarter > 0)
	   {
	   	  if($quarter == 1)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('4','5','6'));
		  }
		  if($quarter == 2)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('7','8','9'));
		  }
		  if($quarter == 3)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('10','11','12'));
		  }
		  if($quarter == 4)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('1','2','3'));
		  }	   	 
	   }
	   if($month != "" && $month != "all" && $month > 0)
	   {
	   	 $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=',$month);
	   }
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }	
       return $this->db->get()->result_array();
	}
    function getOrientChargesExpenditure($fy,$schem,$region,$quarter,$month)
    {
		$this->db->select('fy,scheme,regionId,op_amount as amount');  
	   $this->db->from('iccr_exp_orientation_programme');    
	   if($fy != "")
	   {
	   	  $this->db->where('iccr_exp_orientation_programme.fy',$fy);
	   }
	   if($schem != "" && $schem != "all" && $schem > 0)
	   {
	   	  $this->db->where('iccr_exp_orientation_programme.scheme',$schem);
	   }
	   if($region != "" && $region != "all" && $region > 0)
	   {
	   	  $this->db->where('iccr_exp_orientation_programme.regionId',$region);
	   }
	   if($quarter != "" && $quarter != "all" && $quarter > 0)
	   {
	   	  if($quarter == 1)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('4','5','6'));
		  }
		  if($quarter == 2)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('7','8','9'));
		  }
		  if($quarter == 3)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('10','11','12'));
		  }
		  if($quarter == 4)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('1','2','3'));
		  }	   	 
	   }
	   if($month != "" && $month != "all" && $month > 0)
	   {
	   	 $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=',$month);
	   }
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }	
       return $this->db->get()->result_array();
	}
    function getHostelChargesExpenditure($fy,$schem,$region,$quarter,$month)
    {
		$this->db->select('fy,scheme,regionId,hos_amount as amount');  
	   $this->db->from('iccr_exp_hostel');    
	   if($fy != "")
	   {
	   	  $this->db->where('iccr_exp_hostel.fy',$fy);
	   }
	   if($schem != "" && $schem != "all" && $schem > 0)
	   {
	   	  $this->db->where('iccr_exp_hostel.scheme',$schem);
	   }
	   if($region != "" && $region != "all" && $region > 0)
	   {
	   	  $this->db->where('iccr_exp_hostel.regionId',$region);
	   }
	   if($quarter != "" && $quarter != "all" && $quarter > 0)
	   {
	   	  if($quarter == 1)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('4','5','6'));
		  }
		  if($quarter == 2)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('7','8','9'));
		  }
		  if($quarter == 3)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('10','11','12'));
		  }
		  if($quarter == 4)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('1','2','3'));
		  }	   	 
	   }
	   if($month != "" && $month != "all" && $month > 0)
	   {
	   	 $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=',$month);
	   }
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }	
       return $this->db->get()->result_array();
	}
    function getEnglishBridgeExpenditure($fy,$schem,$region,$quarter,$month)
    {
		$this->db->select('fy,scheme,regionId,ebc_amount as amount');  
	   $this->db->from('iccr_exp_english_bridge_course');    
	   if($fy != "")
	   {
	   	  $this->db->where('iccr_exp_english_bridge_course.fy',$fy);
	   }
	   if($schem != "" && $schem != "all" && $schem > 0)
	   {
	   	  $this->db->where('iccr_exp_english_bridge_course.scheme',$schem);
	   }
	   if($region != "" && $region != "all" && $region > 0)
	   {
	   	  $this->db->where('iccr_exp_english_bridge_course.regionId',$region);
	   }
	   if($quarter != "" && $quarter != "all" && $quarter > 0)
	   {
	   	  if($quarter == 1)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('4','5','6'));
		  }
		  if($quarter == 2)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('7','8','9'));
		  }
		  if($quarter == 3)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('10','11','12'));
		  }
		  if($quarter == 4)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('1','2','3'));
		  }	   	 
	   }
	   if($month != "" && $month != "all" && $month > 0)
	   {
	   	 $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=',$month);
	   }
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }	
       return $this->db->get()->result_array();
	}
    function getTFExpenditure($fy,$schem,$region,$quarter,$month)
    {
		$this->db->select('fy,scheme,regionId,tf_amount as amount');  
	   $this->db->from('iccr_exp_tution_fee');    
	   if($fy != "")
	   {
	   	  $this->db->where('iccr_exp_tution_fee.fy',$fy);
	   }
	   if($schem != "" && $schem != "all" && $schem > 0)
	   {
	   	  $this->db->where('iccr_exp_tution_fee.scheme',$schem);
	   }
	   if($region != "" && $region != "all" && $region > 0)
	   {
	   	  $this->db->where('iccr_exp_tution_fee.regionId',$region);
	   }
	   if($quarter != "" && $quarter != "all" && $quarter > 0)
	   {
	   	  if($quarter == 1)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('4','5','6'));
		  }
		  if($quarter == 2)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('7','8','9'));
		  }
		  if($quarter == 3)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('10','11','12'));
		  }
		  if($quarter == 4)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('1','2','3'));
		  }	   	 
	   }
	   if($month != "" && $month != "all" && $month > 0)
	   {
	   	 $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=',$month);
	   }
       	$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getTravelDetailsExpenditure($fy,$schem,$region,$quarter,$month)
    {
		$this->db->select('fy,scheme,regionId,travel_amount as amount');  
	   $this->db->from('iccr_exp_travel');    
	   if($fy != "")
	   {
	   	  $this->db->where('iccr_exp_travel.fy',$fy);
	   }
	   if($schem != "" && $schem != "all" && $schem > 0)
	   {
	   	  $this->db->where('iccr_exp_travel.scheme',$schem);
	   }
	   if($region != "" && $region != "all" && $region > 0)
	   {
	   	  $this->db->where('iccr_exp_travel.regionId',$region);
	   }
	   if($quarter != "" && $quarter != "all" && $quarter > 0)
	   {
	   	  if($quarter == 1)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('4','5','6'));
		  }
		  if($quarter == 2)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('7','8','9'));
		  }
		  if($quarter == 3)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('10','11','12'));
		  }
		  if($quarter == 4)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('1','2','3'));
		  }	   	 
	   }
	   if($month != "" && $month != "all" && $month > 0)
	   {
	   	 $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=',$month);
	   }
       	$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getThesisExpenditure($fy,$schem,$region,$quarter,$month)
    {
		$this->db->select('fy,scheme,regionId,tc_amount as amount');  
	   $this->db->from('iccr_exp_thesis_charges');    
	   if($fy != "")
	   {
	   	  $this->db->where('iccr_exp_thesis_charges.fy',$fy);
	   }
	   if($schem != "" && $schem != "all" && $schem > 0)
	   {
	   	  $this->db->where('iccr_exp_thesis_charges.scheme',$schem);
	   }
	   if($region != "" && $region != "all" && $region > 0)
	   {
	   	  $this->db->where('iccr_exp_thesis_charges.regionId',$region);
	   }
	   if($quarter != "" && $quarter != "all" && $quarter > 0)
	   {
	   	  if($quarter == 1)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('4','5','6'));
		  }
		  if($quarter == 2)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('7','8','9'));
		  }
		  if($quarter == 3)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('10','11','12'));
		  }
		  if($quarter == 4)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('1','2','3'));
		  }	   	 
	   }
	   if($month != "" && $month != "all" && $month > 0)
	   {
	   	 $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=',$month);
	   }
       	$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    function getMedicalReimbrusmentExpenditure($fy,$schem,$region,$quarter,$month)
    {
		$this->db->select('fy,scheme,regionId,mr_amount as amount');  
	   $this->db->from('iccr_exp_medical_reimbursment');    
	   if($fy != "")
	   {
	   	  $this->db->where('iccr_exp_medical_reimbursment.fy',$fy);
	   }
	   if($schem != "" && $schem != "all" && $schem > 0)
	   {
	   	  $this->db->where('iccr_exp_medical_reimbursment.scheme',$schem);
	   }
	   if($region != "" && $region != "all" && $region > 0)
	   {
	   	  $this->db->where('iccr_exp_medical_reimbursment.regionId',$region);
	   }
	   if($quarter != "" && $quarter != "all" && $quarter > 0)
	   {
	   	  if($quarter == 1)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('4','5','6'));
		  }
		  if($quarter == 2)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('7','8','9'));
		  }
		  if($quarter == 3)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('10','11','12'));
		  }
		  if($quarter == 4)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('1','2','3'));
		  }	   	 
	   }
	   if($month != "" && $month != "all" && $month > 0)
	   {
	   	 $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=',$month);
	   }
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }	
       return $this->db->get()->result_array();
	}
    function getStudyTourExpenditure($fy,$schem,$region,$quarter,$month)
    {
		$this->db->select('fy,scheme,regionId,st_amount as amount');  
	   $this->db->from('iccr_exp_study_tour');    
	   if($fy != "")
	   {
	   	  $this->db->where('iccr_exp_study_tour.fy',$fy);
	   }
	   if($schem != "" && $schem != "all" && $schem > 0)
	   {
	   	  $this->db->where('iccr_exp_study_tour.scheme',$schem);
	   }
	   if($region != "" && $region != "all" && $region > 0)
	   {
	   	  $this->db->where('iccr_exp_study_tour.regionId',$region);
	   }
	   if($quarter != "" && $quarter != "all" && $quarter > 0)
	   {
	   	  if($quarter == 1)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('4','5','6'));
		  }
		  if($quarter == 2)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('7','8','9'));
		  }
		  if($quarter == 3)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('10','11','12'));
		  }
		  if($quarter == 4)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('1','2','3'));
		  }	   	 
	   }
	   if($month != "" && $month != "all" && $month > 0)
	   {
	   	 $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=',$month);
	   }
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }	
       return $this->db->get()->result_array();
	}
    function gethraExpenditure($fy,$schem,$region,$quarter,$month)
    {
		$this->db->select('fy,scheme,regionId,hra_amount as amount');  
	   $this->db->from('iccr_exp_hra');    
	   if($fy != "")
	   {
	   	  $this->db->where('iccr_exp_hra.fy',$fy);
	   }
	   if($schem != "" && $schem != "all" && $schem > 0)
	   {
	   	  $this->db->where('iccr_exp_hra.scheme',$schem);
	   }
	   if($region != "" && $region != "all" && $region > 0)
	   {
	   	  $this->db->where('iccr_exp_hra.regionId',$region);
	   }
	   if($quarter != "" && $quarter != "all" && $quarter > 0)
	   {
	   	  if($quarter == 1)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('4','5','6'));
		  }
		  if($quarter == 2)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('7','8','9'));
		  }
		  if($quarter == 3)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('10','11','12'));
		  }
		  if($quarter == 4)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('1','2','3'));
		  }	   	 
	   }
	   if($month != "" && $month != "all" && $month > 0)
	   {
	   	 $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=',$month);
	   }
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }	
       return $this->db->get()->result_array();
	}
    function getStipendExpenditure($fy,$schem,$region,$quarter,$month)
    {
		$this->db->select('fy,scheme,regionId,amount');  
	   $this->db->from('iccr_exp_stipend');    
	   if($fy != "")
	   {
	   	  $this->db->where('iccr_exp_stipend.fy',$fy);
	   }
	   if($schem != "" && $schem != "all" && $schem > 0)
	   {
	   	  $this->db->where('iccr_exp_stipend.scheme',$schem);
	   }
	   if($region != "" && $region != "all" && $region > 0)
	   {
	   	  $this->db->where('iccr_exp_stipend.regionId',$region);
	   }
	   if($quarter != "" && $quarter != "all" && $quarter > 0)
	   {
	   	  if($quarter == 1)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('4','5','6'));
		  }
		  if($quarter == 2)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('7','8','9'));
		  }
		  if($quarter == 3)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('10','11','12'));
		  }
		  if($quarter == 4)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('1','2','3'));
		  }	   	 
	   }
	   if($month != "" && $month != "all" && $month > 0)
	   {
	   	 $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=',$month);
	   }
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }	
       return $this->db->get()->result_array();
	}
    function getAdvStipendExpenditure($fy,$schem,$region,$quarter,$month)
    {
		$this->db->select('fy,scheme,regionId,adv_stipend_amount as amount');  
	   $this->db->from('iccr_exp_advance_stipend');    
	   if($fy != "")
	   {
	   	  $this->db->where('iccr_exp_advance_stipend.fy',$fy);
	   }
	   if($schem != "" && $schem != "all" && $schem > 0)
	   {
	   	  $this->db->where('iccr_exp_advance_stipend.scheme',$schem);
	   }
	   if($region != "" && $region != "all" && $region > 0)
	   {
	   	  $this->db->where('iccr_exp_advance_stipend.regionId',$region);
	   }
	   if($quarter != "" && $quarter != "all" && $quarter > 0)
	   {
	   	  if($quarter == 1)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('4','5','6'));
		  }
		  if($quarter == 2)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('7','8','9'));
		  }
		  if($quarter == 3)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('10','11','12'));
		  }
		  if($quarter == 4)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('1','2','3'));
		  }	   	 
	   }
	   if($month != "" && $month != "all" && $month > 0)
	   {
	   	 $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=',$month);
	   }
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }	
       return $this->db->get()->result_array();
	}
    function getACAExpenditure($fy,$schem,$region,$quarter,$month)
	{
	   $this->db->select('fy,scheme,regionId,aca_amount as amount');  
	   $this->db->from('iccr_exp_aca');    
	   if($fy != "")
	   {
	   	  $this->db->where('iccr_exp_aca.fy',$fy);
	   }
	   if($schem != "" && $schem != "all" && $schem > 0)
	   {
	   	  $this->db->where('iccr_exp_aca.scheme',$schem);
	   }
	   if($region != "" && $region != "all" && $region > 0)
	   {
	   	  $this->db->where('iccr_exp_aca.regionId',$region);
	   }
	   if($quarter != "" && $quarter != "all" && $quarter > 0)
	   {
	   	  if($quarter == 1)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('4','5','6'));
		  }
		  if($quarter == 2)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('7','8','9'));
		  }
		  if($quarter == 3)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('10','11','12'));
		  }
		  if($quarter == 4)
	   	  {	   	  	 
		  	 $this->db->where_in('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))',array('1','2','3'));
		  }	   	 
	   }
	   if($month != "" && $month != "all" && $month > 0)
	   {
	   	 $this->db->where('MONTH(STR_TO_DATE(DATE_FORMAT(FROM_UNIXTIME(created), "%Y-%m-%d"), "%Y-%m-%d"))=',$month);
	   }
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }	
       return $this->db->get()->result_array();
	}
    /* Expenditure Report End	*/
    
    function getConfirmationofFourthOptionByHqrs($missionId)
    {
		$this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_student_application_details.course,iccr_student_application_details.programme,iccr_status_mapping.university_is_accept,iccr_status_mapping.regional_university,iccr_status_mapping.scholarship_id,iccr_university_response_by_hqrs.regional_university');	  
      $this->db->from('iccr_status_mapping');
      
      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no'); 
      $this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no');      
      $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');      
       $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
      $this->db->where(array('iccr_status_mapping.status'=>10));
      
      $this->db->where_in('iccr_student_other_details.application_through',$missionId); 
      $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
      return $this->db->get()->result_array();
	}
	function getAllExpenditureAppId()
	{
		
	}
	function getDivisionById($id)
	{		
	   $this->db->select('iccr_divisions.name,iccr_divisions.scheme_ids');  
	   $this->db->from('iccr_divisions');    
       $this->db->where(array('iccr_divisions.id'=>$id));	
       $code = $this->db->error();
       if($code['code'] > 0)
	   {	      	
		  show_error('Message',500);
	   }      
       return $this->db->get()->result_array();
       
	}
    function getCourseDurationFromAcademicDetails($appid)
    {
	   $this->db->select('iccr_academic_details.*');  
	   $this->db->from('iccr_academic_details');    
       $this->db->where(array('iccr_academic_details.application_id'=>$appid));	
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    /* Reports Section */
    private function _get_datatables_query($schemeids)
    {
     
		 $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.gender,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_student_application_details.course,iccr_status_mapping.regional_university,iccr_status_mapping.scholarship_id');	  
	       $this->db->from('iccr_status_mapping');
	      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
	      $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
	      $this->db->where(array('iccr_status_mapping.status >='=>1)); 
	     $this->db->where_in('iccr_status_mapping.scholarship_id',$schemeids); 
        //add custom filter here
       
        if($this->input->post('Country'))
        {        	
            $this->db->where('iccr_student_application_details.country', $this->input->post('Country'));
        }
        if($this->input->post('ApplicantName'))
        {
            $this->db->like('iccr_student_application_details.fullname', $this->input->post('ApplicantName'));
        } 
        if($this->input->post('Gender'))
        {
            $this->db->like('iccr_student_application_details.gender', $this->input->post('Gender'));
        }
        if($this->input->post('Mail'))
        {
            $this->db->like('iccr_student_application_details.email', $this->input->post('Mail'));
        }        
        if($this->input->post('Programme'))
        {
            $this->db->where('iccr_student_application_details.programme', $this->input->post('Programme'));
        }
        if($this->input->post('Counrse'))
        {
            $this->db->where('iccr_student_application_details.course', $this->input->post('Counrse'));
        }
        if($this->input->post('Scheme'))
        {
            $this->db->where('iccr_status_mapping.scholarship_id', $this->input->post('Scheme'));
        }
        if($this->input->post('Region'))
        {
			$this->db->where(' (iccr_student_application_details.university_choice_one_state='.$this->input->post('Region').' or iccr_student_application_details.university_choice_two_state='.$this->input->post('Region').' or iccr_student_application_details.university_choice_three_state='.$this->input->post('Region').')');
		}
         if($this->input->post('Universtiy'))
        {
			$this->db->where(' (iccr_student_application_details.universty_choice='.$this->input->post('Universtiy').' or iccr_student_application_details.universty_choice_two='.$this->input->post('Universtiy').' or iccr_student_application_details.universty_choice_three='.$this->input->post('Universtiy').')');
		}
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
    }
 
    public function get_datatables($schemss)
    {
        $this->_get_datatables_query($schemss);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $query->result();
    }
 
    public function count_filtered($schemss)
    {
        $this->_get_datatables_query($schemss);
        $query = $this->db->get();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $query->num_rows();
    }
 
    public function count_all()
    {
        $this->db->from("iccr_status_mapping");
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $this->db->count_all_results();
    }
 
    public function get_list_countries()
    {
        $this->db->select('*');
        $this->db->from("iccr_countries");
        $this->db->order_by('name','asc');
        $query = $this->db->get();
        $result = $query->result();
 
        $countries = array();
        foreach ($result as $row) 
        {
            $countries[] = $row->name;
        }
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $countries;
    }
    /* Report Section */
    function isStatusExists($data,$type,$status)
    {
       $this->db->select('status,scholarship_status,attendance_percentage,promoted_percentage,detained_reason,backlog_no');  
	   $this->db->from('iccr_academic_staus');    
       $this->db->where(array('aca_year'=>$data['aca_year'],'is_sem'=>$data['is_sem']));
       if($data['is_sem'] == 1)
       {
	   	 $this->db->where(array('sem_no'=>$data['sem_no']));
	   }
	   elseif($data['is_sem'] == 2)
       {
	   	 $this->db->where(array('annual_no'=>$data['annual_no']));
	   }
	   switch($type)
	   {
	   	 case "1":
	   	 $this->db->where(array('status'=>$data['status']));
	   	 	switch($status)
	   	 	{
				case "1":
				$this->db->where(array('promoted_percentage !='=>""));
				break;
				case "2":
				$this->db->where(array('detained_reason !='=>-1));
				break;
				case "3":
				$this->db->where(array('backlog_no !='=>-1));
				break;
				case "4":
				$this->db->where(array('finally_passed_percent !='=>""));
				break;
			}
	   	 break;
	   	 case "2":
	   	 $this->db->where(array('attendance_percentage !='=>-1));
	   	 break;
	   	 case "3":
	   	 $this->db->where(array('scholarship_status !='=>-1));
	   	 break;
	   }
	   $this->db->where(array('application_id'=>$data['application_id']));
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();		
	}
	function isRecordExists($data,$type,$status)
	{
	   $this->db->select('status,scholarship_status,attendance_percentage,promoted_percentage,detained_reason,backlog_no');  
	   $this->db->from('iccr_academic_staus');    
       $this->db->where(array('aca_year'=>$data['aca_year'],'is_sem'=>$data['is_sem']));
       if($data['is_sem'] == 1)
       {
	   	 $this->db->where(array('sem_no'=>$data['sem_no']));
	   }
	   elseif($data['is_sem'] == 2)
       {
	   	 $this->db->where(array('annual_no'=>$data['annual_no']));
	   }	  
	   $this->db->where(array('application_id'=>$data['application_id']));
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();	
	}
	
    /* Expenditure Selection Tables Start */
    function isAlreadyUpdatedbalance($fy,$regionId)
    {
		$this->db->select('iccr_opening_balance.*');  
	   $this->db->from('iccr_opening_balance');    
       $this->db->where(array('iccr_opening_balance.regional_office'=>$regionId,'iccr_opening_balance.financial_year'=>$fy));	
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();	
	}
    function getOpeningBalance($regionId)
    {
		$this->db->select('iccr_opening_balance.*');  
	   $this->db->from('iccr_opening_balance');    
       $this->db->where(array('iccr_opening_balance.regional_office'=>$regionId));
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();		
	}
	function getRegionalComplaints($rid)
	{
	   $this->db->select('iccr_complaints.*');
       $this->db->from('iccr_complaints');
       $this->db->where_in('rid',$rid); 
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $result = $this->db->get()->result_array();
	}
    function getBankingDetails($appno,$type)
    {
	   $this->db->select('iccr_exp_bank_details.*');  
	   $this->db->from('iccr_exp_bank_details');    
       $this->db->where(array('iccr_exp_bank_details.application_id'=>$appno));	
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	
	function getPermitDetails($appno,$type)
    {
	   $this->db->select('iccr_exp_residential_permit.*');
       $this->db->from('iccr_exp_residential_permit');       
       $this->db->where('iccr_exp_residential_permit.application_id', $appno);	 
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }      
       return $this->db->get()->result_array();
	}
	function getExpenditureDetails($appno)
	{
	   $this->db->select('*');
       $this->db->from('iccr_student_expenditure');      
       $this->db->where('iccr_student_expenditure.application_id', $appno);	
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getStipendDetails($appno,$type)
    {
	   $this->db->select('iccr_exp_stipend.*');
       $this->db->from('iccr_exp_stipend');
       $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_stipend.application_id');
       $this->db->where('iccr_exp_stipend.application_id', $appno);	
       if($type == "old")
       {
	   	  $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
	   }
	   elseif($type == "New")
       {
	   	 $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
	   }
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getAdvanceStipendDetails($appno,$type)
	{
	   $this->db->select('iccr_exp_advance_stipend.*');
       $this->db->from('iccr_exp_advance_stipend');
       $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_advance_stipend.application_id');
       $this->db->where('iccr_exp_advance_stipend.application_id', $appno);	
       if($type == "old")
       {
	   	  $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
	   }
	   elseif($type == "New")
       {
	   	 $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
	   }
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}	
	function getHRADetails($appno,$type)
    {
	   $this->db->select('iccr_exp_hra.*');
       $this->db->from('iccr_exp_hra');
       $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_hra.application_id');
       $this->db->where('iccr_exp_hra.application_id', $appno);	
       if($type == "old")
       {
	   	  $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
	   }
	   elseif($type == "New")
       {
	   	 $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
	   }
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getACADetails($appno,$type)
    {
	   $this->db->select('iccr_exp_aca.*');
       $this->db->from('iccr_exp_aca');
       $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_aca.application_id');
       $this->db->where('iccr_exp_aca.application_id', $appno);	
       if($type == "old")
       {
	   	  $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
	   }
	   elseif($type == "New")
       {
	   	 $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
	   }
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getStudyTourDetails($appno,$type)
    {
	   $this->db->select('iccr_exp_study_tour.*');
       $this->db->from('iccr_exp_study_tour');
       $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_study_tour.application_id');
       $this->db->where('iccr_exp_study_tour.application_id', $appno);	
       if($type == "old")
       {
	   	  $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
	   }
	   elseif($type == "New")
       {
	   	 $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
	   }
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getMedicalReimbursDetails($appno,$type)
    {
	   $this->db->select('iccr_exp_medical_reimbursment.*');
       $this->db->from('iccr_exp_medical_reimbursment');
       $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_medical_reimbursment.application_id');
       $this->db->where('iccr_exp_medical_reimbursment.application_id', $appno);	
       if($type == "old")
       {
	   	  $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
	   }
	   elseif($type == "New")
       {
	   	 $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
	   }
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getThesisChargesDetails($appno,$type)
    {
	   $this->db->select('iccr_exp_thesis_charges.*');
       $this->db->from('iccr_exp_thesis_charges');
       $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_thesis_charges.application_id');
       $this->db->where('iccr_exp_thesis_charges.application_id', $appno);	
       if($type == "old")
       {
	   	  $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
	   }
	   elseif($type == "New")
       {
	   	 $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
	   }
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getMiscDetails($appno,$type)
    {
	   $this->db->select('iccr_exp_miscellaneous.*');
       $this->db->from('iccr_exp_miscellaneous');
       $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_miscellaneous.application_id');
       $this->db->where('iccr_exp_miscellaneous.application_id', $appno);	
       if($type == "old")
       {
	   	  $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
	   }
	   elseif($type == "New")
       {
	   	 $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
	   }
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}	
	function getHostelDetails($appno,$type)
    {
	   $this->db->select('iccr_exp_hostel.*');
       $this->db->from('iccr_exp_hostel');
       $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_hostel.application_id');
       $this->db->where('iccr_exp_hostel.application_id', $appno);	
       if($type == "old")
       {
	   	  $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
	   }
	   elseif($type == "New")
       {
	   	 $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
	   }
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getTutionFeeDetails($appno,$type)
    {
	   $this->db->select('iccr_exp_tution_fee.*');
       $this->db->from('iccr_exp_tution_fee');
       $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_tution_fee.application_id');
       $this->db->where('iccr_exp_tution_fee.application_id', $appno);	
       if($type == "old")
       {
	   	  $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
	   }
	   elseif($type == "New")
       {
	   	 $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
	   }
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}	
	function getOCFDetails($appno,$type)
    {
	   $this->db->select('iccr_exp_other_fee.*');
       $this->db->from('iccr_exp_other_fee');
       $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_other_fee.application_id');
       $this->db->where('iccr_exp_other_fee.application_id', $appno);	
       if($type == "old")
       {
	   	  $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
	   }
	   elseif($type == "New")
       {
	   	 $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
	   }
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	
	
	function getMiscellaneousUniversityDetails($appno,$type)
    {
	   $this->db->select('iccr_exp_miscellaneous_university.*');
       $this->db->from('iccr_exp_miscellaneous_university');
       $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_miscellaneous_university.application_id');
       $this->db->where('iccr_exp_miscellaneous_university.application_id', $appno);	
       if($type == "old")
       {
	   	  $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
	   }
	   elseif($type == "New")
       {
	   	 $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
	   }
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getTravalDetails($appno,$type)
	{
	   $this->db->select('iccr_exp_travel.*');
       $this->db->from('iccr_exp_travel');
       $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_travel.application_id');
       $this->db->where('iccr_exp_travel.application_id', $appno);	
       if($type == "old")
       {
	   	  $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
	   }
	   elseif($type == "New")
       {
	   	 $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
	   }
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getOrientationDetails($appno,$type)
	{
	   $this->db->select('iccr_exp_orientation_programme.*');
       $this->db->from('iccr_exp_orientation_programme');
       $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_orientation_programme.application_id');
       $this->db->where('iccr_exp_orientation_programme.application_id', $appno);	
       if($type == "old")
       {
	   	  $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
	   }
	   elseif($type == "New")
       {
	   	 $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
	   }
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getCampsDetails($appno,$type)
	{
		$this->db->select('iccr_exp_camps.*');
       $this->db->from('iccr_exp_camps');
       $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_camps.application_id');
       $this->db->where('iccr_exp_camps.application_id', $appno);	
       if($type == "old")
       {
	   	  $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
	   }
	   elseif($type == "New")
       {
	   	 $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
	   }
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getISADetails($appno,$type)
	{
		$this->db->select('iccr_exp_isa_meeting.*');
       $this->db->from('iccr_exp_isa_meeting');
       $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_isa_meeting.application_id');
       $this->db->where('iccr_exp_isa_meeting.application_id', $appno);	
       if($type == "old")
       {
	   	  $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
	   }
	   elseif($type == "New")
       {
	   	 $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
	   }
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getSumptuaryDetails($appno,$type)
	{
		$this->db->select('iccr_exp_sumptuary.*');
       $this->db->from('iccr_exp_sumptuary');
       $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_sumptuary.application_id');
       $this->db->where('iccr_exp_sumptuary.application_id', $appno);	
       if($type == "old")
       {
	   	  $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
	   }
	   elseif($type == "New")
       {
	   	 $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
	   }
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getEmergencyFundDetails($appno,$type)
	{
		$this->db->select('iccr_exp_emergency_fund.*');
       $this->db->from('iccr_exp_emergency_fund');
       $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_emergency_fund.application_id');
       $this->db->where('iccr_exp_emergency_fund.application_id', $appno);	
       if($type == "old")
       {
	   	  $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
	   }
	   elseif($type == "New")
       {
	   	 $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
	   }
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getStudentDayDetails($appno,$type)
	{
		$this->db->select('iccr_exp_student_day.*');
       $this->db->from('iccr_exp_student_day');
       $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_student_day.application_id');
       $this->db->where('iccr_exp_student_day.application_id', $appno);	
       if($type == "old")
       {
	   	  $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
	   }
	   elseif($type == "New")
       {
	   	 $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
	   }
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getNationalDayDetails($appno,$type)
	{
	   $this->db->select('iccr_exp_national_day.*');
       $this->db->from('iccr_exp_national_day');
       $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_national_day.application_id');
       $this->db->where('iccr_exp_national_day.application_id', $appno);	
       if($type == "old")
       {
	   	  $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
	   }
	   elseif($type == "New")
       {
	   	 $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
	   }
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getEnglishBridgeCourseDetails($appno,$type)
	{
		$this->db->select('iccr_exp_english_bridge_course.*');
       $this->db->from('iccr_exp_english_bridge_course');
       $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_english_bridge_course.application_id');
       $this->db->where('iccr_exp_english_bridge_course.application_id', $appno);	
       if($type == "old")
       {
	   	  $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
	   }
	   elseif($type == "New")
       {
	   	 $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
	   }
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getDeductionDetails($appno,$type)
	{
	   $this->db->select('iccr_exp_deductions.*');
       $this->db->from('iccr_exp_deductions');
       $this->db->join('iccr_student_expenditure', 'iccr_student_expenditure.application_id = iccr_exp_deductions.application_id');
       $this->db->where('iccr_exp_deductions.application_id', $appno);	
       if($type == "old")
       {
	   	  $this->db->where('iccr_student_expenditure.exp_student_type', "OLD");
	   }
	   elseif($type == "New")
       {
	   	 $this->db->where('iccr_student_expenditure.exp_student_type', "NEW");
	   }
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	
	
    /* Expenditure Selection Tables  End */
    function getRegionById($regionid)
    {
		 $this->db->select('iccr_regions.*');
       $this->db->from('iccr_regions');
       
       
       $this->db->where('id', $regionid);	
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function deleteApplication($id)
	{
		$this->db->where('id', $id);	
       $this->db->delete('ks_application');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->affected_rows();
	}
	function deleteTarget12($id)
	{
		$this->db->where('id', $id);	
       $this->db->delete('ks_target');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->affected_rows();
	}
	function deleteAdminTarget($id)
	{
		$this->db->where('id', $id);	
       $this->db->delete('ks_target');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->affected_rows();
	}
	function deleteChannel($id)
	{	          
       $this->db->where('id', $id);	
       $this->db->delete('ks_channels');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->affected_rows();
	}
	function deleteWowza($id)
	{	          
       $this->db->where('id', $id);	
       $this->db->delete('ks_wowza');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->affected_rows();
	}
	
	//Delete Admin Encoders 
	function deleteEncoders($id)
	{	          
       $this->db->where('id', $id);	
       $this->db->delete('ks_encoder');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->affected_rows();
	}
	function deleteGateways($id)
	{	          
       $this->db->where('id', $id);	
       $this->db->delete('ks_gateways');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->affected_rows();
	}
	function updateSchedules($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('ks_schedules', $data);
		$success = $this->db->affected_rows(); 
		if($success){
			
			return true;
		}else{
			
			return false;
		}
    }
	function deleteSchedules($id)
	{	          
       $this->db->where('id', $id);	
       $this->db->delete('ks_schedules');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->affected_rows();
	}
	
	function updateUser($id)   
	{	
		$data = array
		(
		'status'=>1
		);
       $this->db->where('id', $id);	
       $this->db->update('ks_users',$data);
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->affected_rows();
	}
	
	function deleteScheme($id)
	{	          
       $this->db->where('id', $id);	
       $this->db->delete('iccr_scheme');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->affected_rows();
	}
	
     function deleteRgion($id)
     {
	 	$this->db->Where('id',$id);
       $this->db->delete('iccr_regions');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
         return $this->db->affected_rows();
	 }
	function getStateById($regionid)
    {
		 $this->db->select('iccr_states.name');
       $this->db->from('iccr_states');
       $this->db->where('id', $regionid);	
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function insertOpeningBalance($data)
	{
		$q = $this->db->insert_string('iccr_opening_balance',$data);             
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertAlumniData($data)
	{
		$q = $this->db->insert_string('iccr_alumni_data',$data);             
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertAdvanceStipend($data)
	{
		$q = $this->db->insert_string('iccr_exp_advance_stipend',$data);             
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertStipend($data)
	{
		$q = $this->db->insert_string('iccr_exp_stipend',$data);             
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertHRA($data)
	{
		$q = $this->db->insert_string('iccr_exp_hra',$data);             
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertACA($data)
	{
		$q = $this->db->insert_string('iccr_exp_aca',$data);             
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertStudyTour($data)
	{
		$q = $this->db->insert_string('iccr_exp_study_tour',$data);             
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertMedicalReimbursment($data)
	{
		$q = $this->db->insert_string('iccr_exp_medical_reimbursment',$data);             
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertThesisCharges($data)
	{
		$q = $this->db->insert_string('iccr_exp_thesis_charges',$data);             
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertMiscellaneous($data)
	{
		$q = $this->db->insert_string('iccr_exp_miscellaneous',$data);             
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertHostelCharges($data)
	{
		$q = $this->db->insert_string('iccr_exp_hostel',$data);             
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertSumptuary($data)
	{
		$q = $this->db->insert_string('iccr_exp_sumptuary',$data);             
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertStudentDay($data)
	{
		$q = $this->db->insert_string('iccr_exp_student_day',$data);             
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertNationalDay($data)
	{
		$q = $this->db->insert_string('iccr_exp_national_day',$data);             
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertEmergancyFund($data)
	{		
		$q = $this->db->insert_string('iccr_exp_emergency_fund',$data);             
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertISAMeeting($data)
	{
		$q = $this->db->insert_string('iccr_exp_isa_meeting',$data);             
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertCamps($data)
	{
		$q = $this->db->insert_string('iccr_exp_camps',$data);             
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertOrientationProgramme($data)
	{
		$q = $this->db->insert_string('iccr_exp_orientation_programme',$data);             
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertEnglishBridgeCourse($data)
	{
		$q = $this->db->insert_string('iccr_exp_english_bridge_course',$data);             
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertTutionFee($data)
	{
		$q = $this->db->insert_string('iccr_exp_tution_fee',$data);             
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertOCFee($data)
	{
		$q = $this->db->insert_string('iccr_exp_other_fee',$data);             
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertUniversityMiscellaneous($data)
	{
		$q = $this->db->insert_string('iccr_exp_miscellaneous_university',$data);             
        $this->db->query($q);
        $id = $this->db->insert_id();
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function isNotAcceptedByAllUniversities($appid)
	{
		$sql ="select Count(CASE WHEN  university_is_accept=2 or university_is_accept=1 THEN university_is_accept END) as count,
sum(CASE WHEN  university_is_accept=2 or university_is_accept=1 THEN university_is_accept END) as total from iccr_university_response  where application_id='".$appid."'";
		$code = $this->db->error(); 
		if($code['code'] > 0)
	    {	      	
		  show_error('Message');
	    }
		return $this->db->query($sql)->result_array();
	}
	function getTotalFundtoAllRegion()
	{
		$sql ="Select financial_year as FY, regional_office as RO,
SUM(CASE WHEN quarter=1 THEN amount_released END) First_Quarter,
SUM(CASE WHEN quarter=2 THEN amount_released END) Second_Quareter,
SUM(CASE WHEN quarter=3 THEN amount_released END) Third_Quareter,
SUM(CASE WHEN quarter=4 THEN amount_released END) Fourth_Quareter 
FROM iccr_hqrs_fund_monitoring Group BY regional_office,financial_year order by financial_year asc";
		$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		 return $this->db->query($sql)->result_array();
	}
	function getTotalFundtoRegionbyFY($regionId,$Fy)
	{
		
		$sql ="Select financial_year as FY, regional_office as RO,SUM(CASE WHEN quarter=1 THEN amount_released ELSE 0 END) First_Quarter,SUM(CASE WHEN quarter=2 THEN amount_released ELSE 0 END) Second_Quareter,SUM(CASE WHEN quarter=3 THEN amount_released ELSE 0 END) Third_Quareter,SUM(CASE WHEN quarter=4 THEN amount_released ELSE 0 END) Fourth_Quareter FROM iccr_hqrs_fund_monitoring where regional_office=".$regionId." and financial_year='".$Fy."' Group BY regional_office";
		$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		 return $this->db->query($sql)->result_array();
	}
	function getCurrentQuarterFundDetails($regionId,$fy,$quarter)
	{
		$sql ="Select amount_released FROM iccr_hqrs_fund_monitoring where regional_office=".$regionId." and quarter=".$quarter." and financial_year='".$fy."'";
		$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		 return $this->db->query($sql)->result_array();
	}
	function getTotalFundtoRegion($regionId)
	{
		$sql ="Select created,financial_year as FY, regional_office as RO,SUM(CASE WHEN quarter=1 THEN amount_released END) First_Quarter,SUM(CASE WHEN quarter=2 THEN amount_released END) Second_Quareter,SUM(CASE WHEN quarter=3 THEN amount_released END) Third_Quareter,SUM(CASE WHEN quarter=4 THEN amount_released END) Fourth_Quareter FROM iccr_hqrs_fund_monitoring where regional_office=".$regionId." group by financial_year";
		$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		 return $this->db->query($sql)->result_array();
	}
	function getAdvStipendByFY($fromyear,$toyear,$regionId)
	{
		$sql = "Select doc, 'Stipend' as Category,
SUM(CASE WHEN MONTH(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y'))=".$fromyear." THEN adv_stipend_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y'))=".$fromyear." THEN adv_stipend_amount END) Second_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y'))=".$fromyear." THEN adv_stipend_amount END) Third_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y'))=".$toyear." THEN adv_stipend_amount END) Fourth_Quarter FROM iccr_exp_advance_stipend where regionId=".$regionId;
$code = $this->db->error(); 
		if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getAdvStipendByFYofAppid($fromyear,$toyear,$appid)
	{
		$sql = "Select doc, 'Stipend' as Category,
SUM(CASE WHEN MONTH(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y'))=".$fromyear." THEN adv_stipend_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y'))=".$fromyear." THEN adv_stipend_amount END) Second_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y'))=".$fromyear." THEN adv_stipend_amount END) Third_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(adv_stipend_from, '%d/%m/%Y'))=".$toyear." THEN adv_stipend_amount END) Fourth_Quarter  FROM iccr_exp_advance_stipend where application_id='".$appid."'";
		$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getStipendByFY($fromyear,$toyear,$regionId)
	{
		$sql = "Select 'Stipend' as Category,
SUM(CASE WHEN MONTH(STR_TO_DATE(stipend_from, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(stipend_from, '%d/%m/%Y'))=".$fromyear." THEN amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(stipend_from, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(stipend_from, '%d/%m/%Y'))=".$fromyear." THEN amount END) Second_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(stipend_from, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(stipend_from, '%d/%m/%Y'))=".$fromyear." THEN amount END) Third_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(stipend_from, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(stipend_from, '%d/%m/%Y'))=".$toyear." THEN amount END) Fourth_Quarter FROM iccr_exp_stipend where regionId=".$regionId;
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getStipendByFYByAppno($fromyear,$toyear,$appid)
	{
		$sql = "Select doc, 'Stipend' as Category,
SUM(CASE WHEN MONTH(STR_TO_DATE(stipend_from, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(stipend_from, '%d/%m/%Y'))=".$fromyear." THEN amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(stipend_from, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(stipend_from, '%d/%m/%Y'))=".$fromyear." THEN amount END) Second_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(stipend_from, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(stipend_from, '%d/%m/%Y'))=".$fromyear." THEN amount END) Third_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(stipend_from, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(stipend_from, '%d/%m/%Y'))=".$toyear." THEN amount END) Fourth_Quarter FROM iccr_exp_stipend where application_id='".$appid."'";
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getMedicalReimbrusmentbyFY($fromyear,$toyear,$regionId)
	{
		$sql = "Select 'Medical Reimbursment' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(mr_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(mr_release_date, '%d/%m/%Y'))=".$fromyear." THEN mr_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(mr_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(mr_release_date, '%d/%m/%Y'))=".$fromyear." THEN mr_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(mr_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(mr_release_date, '%d/%m/%Y'))=".$fromyear." THEN mr_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(mr_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(mr_release_date, '%d/%m/%Y'))=".$toyear." THEN mr_amount END) Fourth_Quarter FROM iccr_exp_medical_reimbursment where regionId=".$regionId;
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getMedicalReimbrusmentbyFYByAppId($fromyear,$toyear,$appid)
	{
		$sql = "Select 'Medical Reimbursment' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(mr_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(mr_release_date, '%d/%m/%Y'))=".$fromyear." THEN mr_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(mr_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(mr_release_date, '%d/%m/%Y'))=".$fromyear." THEN mr_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(mr_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(mr_release_date, '%d/%m/%Y'))=".$fromyear." THEN mr_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(mr_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(mr_release_date, '%d/%m/%Y'))=".$toyear." THEN mr_amount END) Fourth_Quarter FROM iccr_exp_medical_reimbursment where application_id='".$appid."'";
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getThesisbyFY($fromyear,$toyear,$regionId)
	{
		$sql = "Select 'Thesis Charges' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tc_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(tc_release_date, '%d/%m/%Y'))=".$fromyear." THEN tc_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(tc_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(tc_release_date, '%d/%m/%Y'))=".$fromyear." THEN tc_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tc_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(tc_release_date, '%d/%m/%Y'))=".$fromyear." THEN tc_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tc_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(tc_release_date, '%d/%m/%Y'))=".$toyear." THEN tc_amount END) Fourth_Quarter FROM iccr_exp_thesis_charges where regionId=".$regionId;
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getThesisbyFYByAppId($fromyear,$toyear,$appid)
	{
		$sql = "Select 'Thesis Charges' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tc_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(tc_release_date, '%d/%m/%Y'))=".$fromyear." THEN tc_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(tc_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(tc_release_date, '%d/%m/%Y'))=".$fromyear." THEN tc_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tc_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(tc_release_date, '%d/%m/%Y'))=".$fromyear." THEN tc_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tc_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(tc_release_date, '%d/%m/%Y'))=".$toyear." THEN tc_amount END) Fourth_Quarter FROM iccr_exp_thesis_charges where application_id='".$appid."'";
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getMiscbyFY($fromyear,$toyear,$regionId)
	{
		$sql = "Select 'Misc Charges' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(msc_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(msc_release_date, '%d/%m/%Y'))=".$fromyear." THEN msc_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(msc_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(msc_release_date, '%d/%m/%Y'))=".$fromyear." THEN msc_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(msc_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(msc_release_date, '%d/%m/%Y'))=".$fromyear." THEN msc_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(msc_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(msc_release_date, '%d/%m/%Y'))=".$toyear." THEN msc_amount END) Fourth_Quarter FROM iccr_exp_miscellaneous where regionId=".$regionId;
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function gethraByFY($fromyear,$toyear,$regionId)
	{
		$sql = "Select 'HRA' as Category,
SUM(CASE WHEN MONTH(STR_TO_DATE(hra_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(hra_from_date, '%d/%m/%Y'))=".$fromyear." THEN hra_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(hra_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(hra_from_date, '%d/%m/%Y'))=".$fromyear." THEN hra_amount END) Second_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(hra_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(hra_from_date, '%d/%m/%Y'))=".$fromyear." THEN hra_amount END) Third_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(hra_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(hra_from_date, '%d/%m/%Y'))=".$toyear." THEN hra_amount END) Fourth_Quarter FROM iccr_exp_hra where regionId=".$regionId;
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function gethraByFYByAppno($fromyear,$toyear,$appid)
	{
		$sql = "Select doc, 'HRA' as Category,
SUM(CASE WHEN MONTH(STR_TO_DATE(hra_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(hra_from_date, '%d/%m/%Y'))=".$fromyear." THEN hra_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(hra_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(hra_from_date, '%d/%m/%Y'))=".$fromyear." THEN hra_amount END) Second_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(hra_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(hra_from_date, '%d/%m/%Y'))=".$fromyear." THEN hra_amount END) Third_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(hra_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(hra_from_date, '%d/%m/%Y'))=".$toyear." THEN hra_amount END) Fourth_Quarter FROM iccr_exp_hra where application_id='".$appid."'";
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getStudyTourbyFY($fromyear,$toyear,$regionId)
	{
		$sql = "Select 'Study Tour' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(st_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(st_from_date, '%d/%m/%Y'))=".$fromyear." THEN st_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(st_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(st_from_date, '%d/%m/%Y'))=".$fromyear." THEN st_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(st_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(st_from_date, '%d/%m/%Y'))=".$fromyear." THEN st_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(st_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(st_from_date, '%d/%m/%Y'))=".$toyear." THEN st_amount END) Fourth_Quarter FROM iccr_exp_study_tour where regionId=".$regionId;
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getStudyTourbyFYByAppId($fromyear,$toyear,$appid)
	{
		$sql = "Select 'Study Tour' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(st_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(st_from_date, '%d/%m/%Y'))=".$fromyear." THEN st_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(st_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(st_from_date, '%d/%m/%Y'))=".$fromyear." THEN st_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(st_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(st_from_date, '%d/%m/%Y'))=".$fromyear." THEN st_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(st_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(st_from_date, '%d/%m/%Y'))=".$toyear." THEN st_amount END) Fourth_Quarter 
FROM iccr_exp_study_tour where application_id='".$appid."'";
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getTravelDetailsbyFY($fromyear,$toyear,$regionId)
	{
		$sql = "Select 'Trvel' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(travel_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(travel_release_date, '%d/%m/%Y'))=".$fromyear." THEN travel_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(travel_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(travel_release_date, '%d/%m/%Y'))=".$fromyear." THEN travel_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(travel_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(travel_release_date, '%d/%m/%Y'))=".$fromyear." THEN travel_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(travel_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(travel_release_date, '%d/%m/%Y'))=".$toyear." THEN travel_amount END) Fourth_Quarter FROM iccr_exp_travel where regionId=".$regionId;
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getTravelDetailsbyFYByAppId($fromyear,$toyear,$appid)
	{
		$sql = "Select 'Trvel' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(travel_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(travel_release_date, '%d/%m/%Y'))=".$fromyear." THEN travel_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(travel_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(travel_release_date, '%d/%m/%Y'))=".$fromyear." THEN travel_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(travel_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(travel_release_date, '%d/%m/%Y'))=".$fromyear." THEN travel_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(travel_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(travel_release_date, '%d/%m/%Y'))=".$toyear." THEN travel_amount END) Fourth_Quarter FROM iccr_exp_travel where application_id='".$appid."'";
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getHostelChargesByAppid($fromyear,$toyear,$appid)
	{
		$sql = "Select 'Hostel' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(hos_from, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(hos_from, '%d/%m/%Y'))=".$fromyear." THEN hos_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(hos_from, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(hos_from, '%d/%m/%Y'))=".$fromyear." THEN hos_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(hos_from, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(hos_from, '%d/%m/%Y'))=".$fromyear." THEN hos_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(hos_from, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(hos_from, '%d/%m/%Y'))=".$toyear." THEN hos_amount END) Fourth_Quarter FROM iccr_exp_hostel where application_id='".$appid."'";
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getHostelChargesByFY($fromyear,$toyear,$regionId)
	{
		$sql = "Select 'Hostel' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(hos_from, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(hos_from, '%d/%m/%Y'))=".$fromyear." THEN hos_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(hos_from, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(hos_from, '%d/%m/%Y'))=".$fromyear." THEN hos_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(hos_from, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(hos_from, '%d/%m/%Y'))=".$fromyear." THEN hos_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(hos_from, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(hos_from, '%d/%m/%Y'))=".$toyear." THEN hos_amount END) Fourth_Quarter FROM iccr_exp_hostel where regionId=".$regionId;
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getACAbyFY($fromyear,$toyear,$regionId)
	{
		$sql = "Select 'ACA' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(aca_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(aca_release_date, '%d/%m/%Y'))=".$fromyear." THEN aca_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(aca_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(aca_release_date, '%d/%m/%Y'))=".$fromyear." THEN aca_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(aca_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(aca_release_date, '%d/%m/%Y'))=".$fromyear." THEN aca_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(aca_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(aca_release_date, '%d/%m/%Y'))=".$toyear." THEN aca_amount END) Fourth_Quarter FROM iccr_exp_aca where regionId=".$regionId;
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getACAbyFYByAppid($fromyear,$toyear,$appid)
	{
		$sql = "Select doc, 'ACA' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(aca_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(aca_release_date, '%d/%m/%Y'))=".$fromyear." THEN aca_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(aca_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(aca_release_date, '%d/%m/%Y'))=".$fromyear." THEN aca_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(aca_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(aca_release_date, '%d/%m/%Y'))=".$fromyear." THEN aca_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(aca_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(aca_release_date, '%d/%m/%Y'))=".$toyear." THEN aca_amount END) Fourth_Quarter FROM iccr_exp_aca where application_id='".$appid."'";
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getOCFByAppid($fromyear,$toyear,$appid)
	{
		$sql = "Select 'OCF' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ocf_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(ocf_release_date, '%d/%m/%Y'))=".$fromyear." THEN ocf_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(ocf_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(ocf_release_date, '%d/%m/%Y'))=".$fromyear." THEN ocf_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ocf_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(ocf_release_date, '%d/%m/%Y'))=".$fromyear." THEN ocf_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ocf_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(ocf_release_date, '%d/%m/%Y'))=".$toyear." THEN ocf_amount END) Fourth_Quarter FROM iccr_exp_other_fee where application_id='".$appid."'";
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getOCFByFY($fromyear,$toyear,$regionId)
	{
		$sql = "Select 'OCF' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ocf_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(ocf_release_date, '%d/%m/%Y'))=".$fromyear." THEN ocf_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(ocf_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(ocf_release_date, '%d/%m/%Y'))=".$fromyear." THEN ocf_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ocf_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(ocf_release_date, '%d/%m/%Y'))=".$fromyear." THEN ocf_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ocf_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(ocf_release_date, '%d/%m/%Y'))=".$toyear." THEN ocf_amount END) Fourth_Quarter FROM iccr_exp_other_fee where regionId=".$regionId;
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getTFByByAppid($fromyear,$toyear,$appid)
	{
		$sql = "Select doc, 'TF' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tf_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(tf_release_date, '%d/%m/%Y'))=".$fromyear." THEN tf_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(tf_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(tf_release_date, '%d/%m/%Y'))=".$fromyear." THEN tf_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tf_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(tf_release_date, '%d/%m/%Y'))=".$fromyear." THEN tf_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tf_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(tf_release_date, '%d/%m/%Y'))=".$toyear." THEN tf_amount END) Fourth_Quarter FROM iccr_exp_tution_fee  where application_id='".$appid."'";
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getTFByFY($fromyear,$toyear,$regionId)
	{
		$sql = "Select 'TF' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tf_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(tf_release_date, '%d/%m/%Y'))=".$fromyear." THEN tf_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(tf_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(tf_release_date, '%d/%m/%Y'))=".$fromyear." THEN tf_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tf_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(tf_release_date, '%d/%m/%Y'))=".$fromyear." THEN tf_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(tf_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(tf_release_date, '%d/%m/%Y'))=".$toyear." THEN tf_amount END) Fourth_Quarter FROM iccr_exp_tution_fee where regionId=".$regionId;
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getMiscUniByFY($fromyear,$toyear,$regionId)
	{
		$sql = "Select 'Misc' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(uni_msc_release_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(uni_msc_release_date, '%d/%m/%Y'))=".$fromyear." THEN uni_msc_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(uni_msc_release_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(uni_msc_release_date, '%d/%m/%Y'))=".$fromyear." THEN uni_msc_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(uni_msc_release_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(uni_msc_release_date, '%d/%m/%Y'))=".$fromyear." THEN uni_msc_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(uni_msc_release_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(uni_msc_release_date, '%d/%m/%Y'))=".$toyear." THEN uni_msc_amount END) Fourth_Quarter FROM iccr_exp_miscellaneous_university where regionId=".$regionId;
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getEnglishBridgeByappid($fromyear,$toyear,$appid)
	{
		$sql = "Select 'EBC' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ebc_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(ebc_from_date, '%d/%m/%Y'))=".$fromyear." THEN ebc_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(ebc_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(ebc_from_date, '%d/%m/%Y'))=".$fromyear." THEN ebc_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ebc_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(ebc_from_date, '%d/%m/%Y'))=".$fromyear." THEN ebc_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ebc_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(ebc_from_date, '%d/%m/%Y'))=".$toyear." THEN ebc_amount END) Fourth_Quarter FROM iccr_exp_english_bridge_course where application_id='".$appid."'";
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getEnglishBridgeByFY($fromyear,$toyear,$regionId)
	{
		$sql = "Select 'EBC' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ebc_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(ebc_from_date, '%d/%m/%Y'))=".$fromyear." THEN ebc_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(ebc_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(ebc_from_date, '%d/%m/%Y'))=".$fromyear." THEN ebc_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ebc_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(ebc_from_date, '%d/%m/%Y'))=".$fromyear." THEN ebc_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ebc_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(ebc_from_date, '%d/%m/%Y'))=".$toyear." THEN ebc_amount END) Fourth_Quarter FROM iccr_exp_english_bridge_course where regionId=".$regionId;
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getOrientChargesByFY($fromyear,$toyear,$regionId)
	{
		$sql = "Select 'OP' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(op_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(op_from_date, '%d/%m/%Y'))=".$fromyear." THEN op_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(op_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(op_from_date, '%d/%m/%Y'))=".$fromyear." THEN op_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(op_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(op_from_date, '%d/%m/%Y'))=".$fromyear." THEN op_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(op_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(op_from_date, '%d/%m/%Y'))=".$toyear." THEN op_amount END) Fourth_Quarter FROM iccr_exp_orientation_programme where regionId=".$regionId;
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getOrientChargesByAppid($fromyear,$toyear,$appid)
	{
		$sql = "Select 'OP' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(op_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(op_from_date, '%d/%m/%Y'))=".$fromyear." THEN op_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(op_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(op_from_date, '%d/%m/%Y'))=".$fromyear." THEN op_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(op_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(op_from_date, '%d/%m/%Y'))=".$fromyear." THEN op_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(op_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(op_from_date, '%d/%m/%Y'))=".$toyear." THEN op_amount END) Fourth_Quarter FROM iccr_exp_orientation_programme where application_id='".$appid."'";
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getCampsByAppid($fromyear,$toyear,$appid)
	{
		$sql = "Select 'Camps' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(camps_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(camps_from_date, '%d/%m/%Y'))=".$fromyear." THEN camps_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(camps_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(camps_from_date, '%d/%m/%Y'))=".$fromyear." THEN camps_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(camps_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(camps_from_date, '%d/%m/%Y'))=".$fromyear." THEN camps_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(camps_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(camps_from_date, '%d/%m/%Y'))=".$toyear." THEN camps_amount END) Fourth_Quarter FROM iccr_exp_camps where application_id='".$appid."'";
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getCampsByFY($fromyear,$toyear,$regionId)
	{
		$sql = "Select 'Camps' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(camps_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(camps_from_date, '%d/%m/%Y'))=".$fromyear." THEN camps_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(camps_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(camps_from_date, '%d/%m/%Y'))=".$fromyear." THEN camps_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(camps_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(camps_from_date, '%d/%m/%Y'))=".$fromyear." THEN camps_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(camps_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(camps_from_date, '%d/%m/%Y'))=".$toyear." THEN camps_amount END) Fourth_Quarter FROM iccr_exp_camps where regionId=".$regionId;
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getISAByAppid($fromyear,$toyear,$appid)
	{
		$sql = "Select 'ISA' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(isa_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(isa_from_date, '%d/%m/%Y'))=".$fromyear." THEN isa_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(isa_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(isa_from_date, '%d/%m/%Y'))=".$fromyear." THEN isa_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(isa_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(isa_from_date, '%d/%m/%Y'))=".$fromyear." THEN isa_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(isa_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(isa_from_date, '%d/%m/%Y'))=".$toyear." THEN isa_amount END) Fourth_Quarter FROM iccr_exp_isa_meeting where application_id='".$appid."'";
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getISAByFY($fromyear,$toyear,$regionId)
	{
		$sql = "Select 'ISA' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(isa_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(isa_from_date, '%d/%m/%Y'))=".$fromyear." THEN isa_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(isa_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(isa_from_date, '%d/%m/%Y'))=".$fromyear." THEN isa_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(isa_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(isa_from_date, '%d/%m/%Y'))=".$fromyear." THEN isa_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(isa_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(isa_from_date, '%d/%m/%Y'))=".$toyear." THEN isa_amount END) Fourth_Quarter FROM iccr_exp_isa_meeting where regionId=".$regionId;
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getSumptuaryByAppid($fromyear,$toyear,$appid)
	{
		$sql = "Select 'sump' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sump_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(sump_from_date, '%d/%m/%Y'))=".$fromyear." THEN sump_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(sump_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(sump_from_date, '%d/%m/%Y'))=".$fromyear." THEN sump_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sump_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(sump_from_date, '%d/%m/%Y'))=".$fromyear." THEN sump_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sump_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(sump_from_date, '%d/%m/%Y'))=".$toyear." THEN sump_amount END) Fourth_Quarter FROM iccr_exp_sumptuary where application_id='".$appid."'";
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getSumptuaryByFY($fromyear,$toyear,$regionId)
	{
		$sql = "Select 'sump' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sump_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(sump_from_date, '%d/%m/%Y'))=".$fromyear." THEN sump_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(sump_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(sump_from_date, '%d/%m/%Y'))=".$fromyear." THEN sump_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sump_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(sump_from_date, '%d/%m/%Y'))=".$fromyear." THEN sump_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sump_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(sump_from_date, '%d/%m/%Y'))=".$toyear." THEN sump_amount END) Fourth_Quarter FROM iccr_exp_sumptuary where regionId=".$regionId;
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getEmergencyFundByAppid($fromyear,$toyear,$appid)
	{
		$sql = "Select 'ISA' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ef_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(ef_from_date, '%d/%m/%Y'))=".$fromyear." THEN ef_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(ef_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(ef_from_date, '%d/%m/%Y'))=".$fromyear." THEN ef_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ef_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(ef_from_date, '%d/%m/%Y'))=".$fromyear." THEN ef_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ef_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(ef_from_date, '%d/%m/%Y'))=".$toyear." THEN ef_amount END) Fourth_Quarter FROM iccr_exp_emergency_fund where application_id='".$appid."'";
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getEmergencyFundByFY($fromyear,$toyear,$regionId)
	{
		$sql = "Select 'ISA' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ef_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(ef_from_date, '%d/%m/%Y'))=".$fromyear." THEN ef_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(ef_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(ef_from_date, '%d/%m/%Y'))=".$fromyear." THEN ef_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ef_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(ef_from_date, '%d/%m/%Y'))=".$fromyear." THEN ef_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(ef_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(ef_from_date, '%d/%m/%Y'))=".$toyear." THEN ef_amount END) Fourth_Quarter FROM iccr_exp_emergency_fund where regionid=".$regionId;
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getStudentDayByAppid($fromyear,$toyear,$appid)
	{
		$sql = "Select 'ISA' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sd_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(sd_from_date, '%d/%m/%Y'))=".$fromyear." THEN sd_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(sd_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(sd_from_date, '%d/%m/%Y'))=".$fromyear." THEN sd_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sd_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(sd_from_date, '%d/%m/%Y'))=".$fromyear." THEN sd_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sd_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(sd_from_date, '%d/%m/%Y'))=".$toyear." THEN sd_amount END) Fourth_Quarter FROM iccr_exp_student_day where application_id='".$appid."'";
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getStudentDayByFY($fromyear,$toyear,$regionId)
	{
		$sql = "Select 'ISA' as Category, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sd_from_date, '%d/%m/%Y')) IN(4,5,6) AND YEAR(STR_TO_DATE(sd_from_date, '%d/%m/%Y'))=".$fromyear." THEN sd_amount END) First_Quarter,
SUM(CASE WHEN MONTH(STR_TO_DATE(sd_from_date, '%d/%m/%Y')) IN(7,8,9) AND YEAR(STR_TO_DATE(sd_from_date, '%d/%m/%Y'))=".$fromyear." THEN sd_amount END) Second_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sd_from_date, '%d/%m/%Y')) IN(10,11,12) AND YEAR(STR_TO_DATE(sd_from_date, '%d/%m/%Y'))=".$fromyear." THEN sd_amount END) Third_Quarter, 
SUM(CASE WHEN MONTH(STR_TO_DATE(sd_from_date, '%d/%m/%Y')) IN(1,2,3) AND YEAR(STR_TO_DATE(sd_from_date, '%d/%m/%Y'))=".$toyear." THEN sd_amount END) Fourth_Quarter FROM iccr_exp_student_day where regionId=".$regionId;
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getDemands($regionid)
	{
	   $this->db->select('iccr_rodemands.*');  
	   $this->db->from('iccr_rodemands');    
       $this->db->where(array('regional_office'=>$regionid,'status'=>-1));
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getconfirmationDataforHqrs($appno)
	{
		$this->db->select('iccr_university_response.*');  
	   $this->db->from('iccr_university_response');    
       $this->db->where(array('application_id'=>$appno));
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getconfirmationDataforfourthoptionHqrs($appno)
	{
		$this->db->select('iccr_university_response_by_hqrs .*');  
	   $this->db->from('iccr_university_response_by_hqrs');    
       $this->db->where(array('application_id'=>$appno));
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getconfirmationData($appno)
	{
		$this->db->select('iccr_university_response.*');  
	   $this->db->from('iccr_university_response');    
       $this->db->where(array('university_is_accept'=>1,'application_id'=>$appno));
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function isExistsFund($fy,$ro,$quarter)
	{
	   $this->db->select('iccr_hqrs_fund_monitoring.*');  
	   $this->db->from('iccr_hqrs_fund_monitoring');    
       $this->db->where(array('financial_year'=>$fy,'regional_office'=>$ro,'quarter'=>$quarter));
       return $this->db->get()->result_array();
	}
	function isAnyUniversityResponseConfirm($appno,$regionId)
	{
	   $this->db->select('iccr_university_response.*');  
	   $this->db->from('iccr_university_response');    
       $this->db->where(array('region_one_status'=>$regionId,'application_id'=>$appno));
       $code = $this->db->error(); 
       if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function isAnyUniversityResponseConfirmToHqrs($appno)
	{
		$this->db->select('iccr_university_response.*');  
	   $this->db->from('iccr_university_response');    
       $this->db->where(array('application_id'=>$appno,'university_is_accept'=>1));
       $code = $this->db->error(); 
       if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getAllDemands()
	{
	   $this->db->select('iccr_rodemands.*');  
	   $this->db->from('iccr_rodemands');    
       $this->db->where(array('status'=>-1));
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getAllProcessedDemands()
	{
		$this->db->select('iccr_rodemands.*');  
	   $this->db->from('iccr_rodemands');    
       $this->db->where(array('status >'=>0));
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getProcessedDemands($regionid)
	{
		$this->db->select('iccr_rodemands.*');  
	   $this->db->from('iccr_rodemands');    
       $this->db->where(array('regional_office'=>$regionid,'status >'=>0));
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getTotalFundtoRegionDetails($regionId)
	{
		$sql ="Select financial_year as FY, regional_office as RO,SUM(CASE WHEN quarter=1 THEN amount_released END) First_Quarter,SUM(CASE WHEN quarter=2 THEN amount_released END) Second_Quareter,SUM(CASE WHEN quarter=3 THEN amount_released END) Third_Quareter,SUM(CASE WHEN quarter=4 THEN amount_released END) Fourth_Quareter FROM iccr_hqrs_fund_monitoring where regional_office=".$regionId." Group BY regional_office";
		$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		 return $this->db->query($sql)->result_array();
	}
	function updateDemand($data)
	{
		$this->db->where('demand_id', $data['demand_id']);		
		$this->db->update('iccr_rodemands', $data); 
        $success = $this->db->affected_rows(); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        if($success >= 0)
        	return TRUE;
        else
         	return FALSE;
	}
	function saveDemand($data)
	{
		$q = $this->db->insert_string('iccr_rodemands',$data);             
        $this->db->query($q);
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $id = $this->db->insert_id();
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertFund($data)
	{
		$q = $this->db->insert_string('iccr_hqrs_fund_monitoring',$data);             
        $this->db->query($q);
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $id = $this->db->insert_id();
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertTravelCharges($data)
	{
		$q = $this->db->insert_string('iccr_exp_travel',$data);             
        $this->db->query($q);
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $id = $this->db->insert_id();
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertDeductions($data)
	{
		$q = $this->db->insert_string('iccr_exp_deductions',$data);             
        $this->db->query($q);
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $id = $this->db->insert_id();
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertBankDetails($data)
	{
		$q = $this->db->insert_string('iccr_exp_bank_details',$data);             
        $this->db->query($q);
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $id = $this->db->insert_id();
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertPermitDetails($data)
	{
		$q = $this->db->insert_string('iccr_exp_residential_permit',$data);             
        $this->db->query($q);
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $id = $this->db->insert_id();
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
    function insertUniversity($data)
    {
		$q = $this->db->insert_string('iccr_univercities',$data);             
        $this->db->query($q);
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $id = $this->db->insert_id();
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertunivercitiesListMapping($data)
	{
		$q = $this->db->insert_string('iccr_university_mapping',$data);             
        $this->db->query($q);
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $id = $this->db->insert_id();
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertunivercitiesList($data)
    {
		$q = $this->db->insert_string('iccr_univercitiesList',$data);             
        $this->db->query($q);
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $id = $this->db->insert_id();
        if($id > 0)
        	return $id;
        else
        	return 0;
	}
    function insertRegion($data)
    {
		$q = $this->db->insert_string('iccr_regions',$data);             
        $this->db->query($q);
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $id = $this->db->insert_id();
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;	
	}
	function insertregionalExpenditure($data)
	{
		$q = $this->db->insert_string('iccr_regional_expenditure',$data);             
        $this->db->query($q);
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $id = $this->db->insert_id();
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function getAllSemesters()
	{
	   $this->db->select('iccr_academic_semesters.*');
       $this->db->from('iccr_academic_semesters');	
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getOldAcademicApplicant($regionid)
	{
	   $this->db->select('iccr_academic_details.*');
       $this->db->from('iccr_academic_details');
       $this->db->join('iccr_univercities', 'iccr_univercities.id = iccr_academic_details.university'); 
       $this->db->where('iccr_academic_details.academic_type', "OLD");	
       $this->db->where('iccr_univercities.state', $regionid);	
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getAcademicDetailsDataforReport($appno)
	{
		$this->db->select('iccr_academic_details.*');
        $this->db->from('iccr_academic_details');
        $this->db->where('iccr_academic_details.application_id', $appno);	
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }        
        return $this->db->get()->result_array();
	}
	function getAcademicStatusDataforReport($appno)
	{
		$this->db->select('iccr_academic_staus.*');
		$this->db->join('iccr_academic_details', 'iccr_academic_details.application_id = iccr_academic_staus.application_id');
        $this->db->from('iccr_academic_staus');
        $this->db->where('iccr_academic_staus.application_id', $appno);	
        $this->db->order_by('iccr_academic_staus.aca_year');	
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $this->db->get()->result_array();
	}
	function getScholarshipStatusDataforReport($appno)
	{
		$this->db->select('iccr_scholarship_staus.*');
       $this->db->from('iccr_scholarship_staus');
       $this->db->where('iccr_scholarship_staus.application_id', $appno);	
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getAcademicDataforReport($appno)
	{
		$this->db->select('iccr_academic_details.*');
       $this->db->from('iccr_academic_details');
       $this->db->where('iccr_academic_details.application_id', $appno);	
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getAcademicData($appno)
	{
		$this->db->select('iccr_academic_details.*');
       $this->db->from('iccr_academic_details');
       $this->db->where('application_id', $appno);	
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function insertAcademicDetails($data)
	{
		$q = $this->db->insert_string('iccr_academic_details',$data);             
        $this->db->query($q);
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $id = $this->db->insert_id();
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function updateAcademic($data)
	{
		$update_data = array();
		$this->db->where(array('application_id'=>$data['application_id'],'is_sem'=>$data['is_sem'],'aca_year'=>$data['aca_year']));
		if($data['is_sem'] == 1)
		{
			$this->db->where('sem_no',$data['sem_no']);
		}
		elseif($data['is_sem'] == 2)
		{
			$this->db->where('annual_no',$data['annual_no']);
		}	
		$update_data = $data;
		unset($update_data['date_from']);
		unset($update_data['date_to']);
		if($data['is_sem'] == "1")
	  	{						  	  	 
			unset($update_data['sem_no']);								 							
		}
		elseif($data['is_sem'] == "2")
	  	{
			unset($update_data['annual_no']);
		}		
		unset($update_data['is_sem']);				
		$this->db->update('iccr_academic_staus', $update_data); 
		$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $success = $this->db->affected_rows(); 
        if($success >= 0)
        	return TRUE;
        else
         	return FALSE;
	}
	function insertAcademic($data)
	{
		$q = $this->db->insert_string('iccr_academic_staus',$data);             
        $this->db->query($q);
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $id = $this->db->insert_id();
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	
	function insertAttendanceData($data)
	{
		$q = $this->db->insert_string('iccr_attendance_staus',$data);             
        $this->db->query($q);
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $id = $this->db->insert_id();
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertScholarshipStatus($data)
	{
		$q = $this->db->insert_string('iccr_scholarship_staus',$data);             
        $this->db->query($q);
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $id = $this->db->insert_id();
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function getScholarshipStatusofApplicant($appno)
	{
		
	   $this->db->select('iccr_academic_staus.*');
       $this->db->from('iccr_academic_staus');
       $this->db->where(array('application_id'=>$appno));	
       $this->db->order_by('aca_year','DESC');	
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function insertSchemeSlot($data)
	{
		$q = $this->db->insert_string('iccr_scheme_slots',$data);             
        $this->db->query($q);
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $id = $this->db->insert_id();
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;
	}
	function insertMission($data)
    {
		$q = $this->db->insert_string('iccr_missions',$data);             
        $this->db->query($q);
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $id = $this->db->insert_id();
        if($id > 0)
        	return TRUE;
        else
        	return FALSE;	
	}
	function getAttendenceStatus($acayear,$frommonth,$frmyear,$tomonth,$toyear,$appid)
	{
		$this->db->select('iccr_attendance_staus.*');
       $this->db->from('iccr_attendance_staus');
       $this->db->where(array('aca_year'=>$acayear,'sem_from_month'=>$frommonth,'sem_from_year'=>$frmyear,'sem_to_month'=>$tomonth,'sem_to_year'=>$toyear,'application_id'=>$appid));	
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getScholarshipStatus($acayear,$frommonth,$frmyear,$tomonth,$toyear,$appid)
	{
		$this->db->select('iccr_scholarship_staus.*');
       $this->db->from('iccr_scholarship_staus');
       $this->db->where(array('aca_year'=>$acayear,'sem_from_month'=>$frommonth,'sem_from_year'=>$frmyear,'sem_to_month'=>$tomonth,'sem_to_year'=>$toyear,'application_id'=>$appid));	
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getChecklistItemById($id)
	{
	   $this->db->select('iccr_mission_checklist.item');
       $this->db->from('iccr_mission_checklist');
       $this->db->where('id', $id);	
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getPendingCheckList($appid)
	{
	   $this->db->select('iccr_status_mapping.checklist_ids');	  
       $this->db->from('iccr_status_mapping');
       $this->db->where(array('iccr_status_mapping.application_no'=>$appid)); 
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   } 
      return $this->db->get()->result_array();
	}
	function pending_applications($missionId)
	{
		$this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_other_details.application_through,iccr_student_other_details.mission_made_through,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_status_mapping.scholarship_id,iccr_student_application_details.programme,iccr_student_application_details.course_subject');	  
      $this->db->from('iccr_status_mapping');
      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
      $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
      $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
      $this->db->where(array('iccr_status_mapping.status'=>2)); 
      $this->db->where_in('iccr_student_other_details.application_through',$missionId); 
      $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
      return $this->db->get()->result_array();
	}
	function resubmitapplication($missionId)
	{
		$this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.programme,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.course_subject');	  
      $this->db->from('iccr_status_mapping');
      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
      $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
      $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
      $this->db->where(array('iccr_status_mapping.status'=>6)); 
      $this->db->where_in('iccr_student_other_details.application_through',$missionId); 
      $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
      return $this->db->get()->result_array();
	}
	function hold_applications($missionId)
	{
	  $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.programme,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.course_subject');	  
      $this->db->from('iccr_status_mapping');
      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
      $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
      $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
      $this->db->where(array('iccr_status_mapping.status'=>3));
      $this->db->where_in('iccr_student_other_details.application_through',$missionId);  
      $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
      return $this->db->get()->result_array();
	}
	function getMissionChecklist()
	{
	   $this->db->select('iccr_mission_checklist.*');
       $this->db->from('iccr_mission_checklist');  
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }     	
       return $this->db->get()->result_array();
	}
	function getMissionsByCountry($cid)
	{
	   $this->db->select('iccr_missions.*');
       $this->db->from('iccr_missions');
       $this->db->where('country', $cid);	
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getAllMissions()
	{
	   $this->db->select('iccr_missions.*,iccr_countries.country_name');
       $this->db->from('iccr_missions');  
	   $this->db->join('iccr_countries', 'iccr_missions.country = iccr_countries.id');
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
	    $sort_col = array();
	    foreach ($arr as $key=> $row) {
	        $sort_col[$key] = $row[$col];
	    }

	    array_multisort($sort_col, $dir, $arr);
	}
	function getAllRegions()
	{
	   $this->db->select('iccr_regions.*');
       $this->db->from('iccr_regions');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getAllStudents()
	{
	   $this->db->select('iccr_users.email_id,iccr_student_details.*,iccr_countries.country_name');
       $this->db->from('iccr_users');  
       $this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_users.id');
       $this->db->join('iccr_countries', 'iccr_countries.id = iccr_student_details.country_of_domicile');	   
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function isExpenditureReady($appid)
	{
		$this->db->select('iccr_student_expenditure.id');
       $this->db->from('iccr_student_expenditure');  
       $this->db->where(array('application_id'=>$appid));  
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   } 
       return $this->db->get()->result_array();
	}
	function getAllStudentsApplications($schemeids)
	{
	   $this->db->select('iccr_student_application_details.*,iccr_users.email_id,iccr_student_details.*,iccr_countries.country_name,iccr_missions.mission_name,iccr_status_mapping.status,iccr_status_mapping.scholarship_id');
       $this->db->from('iccr_student_application_details');  
       $this->db->join('iccr_student_other_details', 'iccr_student_other_details.uid = iccr_student_application_details.uid');
       $this->db->join('iccr_users', 'iccr_student_application_details.uid = iccr_users.id');
       $this->db->join('iccr_student_details', 'iccr_student_details.uid = iccr_users.id');
       $this->db->join('iccr_missions', 'iccr_missions.id = iccr_student_other_details.mission_made_through');	
       $this->db->join('iccr_countries', 'iccr_countries.id = iccr_missions.country');	
       $this->db->join('iccr_status_mapping', 'iccr_status_mapping.application_no = iccr_student_application_details.application_no');	
       
        $this->db->where_in('iccr_status_mapping.scholarship_id',$schemeids); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       //$this->db->where(array('iccr_student_other_details.mission_made_through'=>$missionid));   
       return $this->db->get()->result_array();
	}
	function getAllUniversities()
	{
	   $this->db->select('iccr_univercities.*,iccr_regions.name as statename,iccr_states.name as stname');
       $this->db->from('iccr_univercities');  
	   $this->db->join('iccr_regions', 'iccr_univercities.state = iccr_regions.id');
	   $this->db->join('iccr_states', 'iccr_univercities.state_id = iccr_states.id','left');
	   $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getApplicationUnderStatus($id)
	{
	   $this->db->select('iccr_status_master.status');
       $this->db->from('iccr_status_master'); 
       $this->db->where(array('iccr_status_master.value'=>$id)); 
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getAllOLDSchemes()
	{
		$this->db->select('id,scheme_name,code');
      $this->db->from('iccr_schemes');	  
      $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
      return $this->db->get()->result_array();
	}
	function getAllFaqs()
	{
		$this->db->select('id,item,desc');
      $this->db->from('iccr_faqs');	  
      $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
      return $this->db->get()->result_array();
	}
    function getAllSchemes()
    {
	  $this->db->select('id,scheme_name,code,desc');
      $this->db->from('iccr_scheme');	 
      $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   } 
      return $this->db->get()->result_array();
	}
	function getLeftSlots($missionid,$schemeid)
	{
		$this->db->select('iccr_status_mapping.status');	  
       $this->db->from('iccr_status_mapping'); 
       $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
       $this->db->join('iccr_countries', 'iccr_countries.id = iccr_student_other_details.mission_made_through'); 
      $this->db->where(array('iccr_student_other_details.mission_made_through'=>$missionid,'iccr_status_mapping.scholarship_id >'=>$schemeid)); 
      $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
      return $this->db->get()->result_array();
	}
	function getSlotsbySchemes($schemeid,$countryid)
	{
	   $this->db->select('iccr_scheme_slots.slots');
       $this->db->from('iccr_scheme_slots');
       $this->db->where(array('iccr_scheme_slots.country_id'=>$countryid,'iccr_scheme_slots.scheme_id'=>$schemeid));
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
      return $this->db->get()->result_array();
	}
	function getAllSchemesOfMission($missionId)
    {
	   $this->db->select('iccr_scheme.id,iccr_scheme.scheme_name,iccr_scheme.scheme_type');
       $this->db->from('iccr_scheme_slots');	  
       $this->db->join('iccr_scheme', 'iccr_scheme.id = iccr_scheme_slots.scheme_id');
       $this->db->join('iccr_countries', 'iccr_countries.id = iccr_scheme_slots.country_id');
       $this->db->join('iccr_missions', 'iccr_missions.country = iccr_scheme_slots.country_id');       
       $this->db->where('iccr_scheme_slots.slots=-3 or iccr_scheme_slots.country_id='.$missionId);
       $this->db->group_by('iccr_scheme.id');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
      return $this->db->get()->result_array();
	}
	function getAllSchemesSlotsOfMission($missionId)
    {
	   $this->db->select('iccr_scheme_slots.scheme_id,iccr_scheme_slots.id,iccr_scheme_slots.slots,iccr_scheme_slots.country_id,iccr_scheme.scheme_name,iccr_scheme.scheme_type');
       $this->db->from('iccr_scheme_slots'); 
       $this->db->join('iccr_scheme', 'iccr_scheme.id = iccr_scheme_slots.scheme_id');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
      return $this->db->get()->result_array();
	}
	function getAllNIFT()
	{
		$this->db->select('iccr_univercities.id,iccr_univercities.name as uni,link');
      	$this->db->from('iccr_univercities');      	  
      	$this->db->where(array('university_type'=>9));
      	$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
      	return $this->db->get()->result_array();
	}
	function getNITUniversitiesofRO($regionId)
	{
		$this->db->select('iccr_univercities.id,iccr_univercities.name as uni,link');
      	$this->db->from('iccr_univercities');
        $this->db->where('iccr_univercities.state',$regionId);  
      	$this->db->where(array('university_type'=>3));
      	$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
      	return $this->db->get()->result_array();
	}
	function getNITUniversities()
	{
		$this->db->select('iccr_univercities.id,iccr_univercities.name as uni,link');
      	$this->db->from('iccr_univercities');
      //	$this->db->join('iccr_states', 'iccr_univercities.state_id = iccr_states.id');	  
      	$this->db->where(array('university_type'=>3));
      	$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
      	return $this->db->get()->result_array();
	}
	function getYogaGurus()
	{
		$this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_univercities.subject,link');
      	$this->db->from('iccr_univercities'); 
      	$this->db->where(array('university_type'=>4));
      	$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
      	return $this->db->get()->result_array();
	}
	function getCentralUniversitiesofRO($regionId)
	{
		$this->db->select('iccr_univercities.id,iccr_univercities.name as uni');
      	$this->db->from('iccr_univercities');
      	$this->db->where('iccr_univercities.state',$regionId);  
      	$this->db->where(array('university_type'=>1));
      	$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
      	return $this->db->get()->result_array();
	}
	function getCentralUniversities()
	{
		$this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_univercities.link');
      	$this->db->from('iccr_univercities');
      //	$this->db->join('iccr_states', 'iccr_univercities.state_id = iccr_states.id');	  
      	$this->db->where(array('university_type'=>1));
      	$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
      	return $this->db->get()->result_array();
	}
	function getICARUniversity()
	{
		$this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_univercities.link');
      	$this->db->from('iccr_univercities');        
      	$this->db->where(array('university_type'=>5));
      	$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
      	return $this->db->get()->result_array();
	}
	function getAYUSHUniversity()
	{
		$this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_univercities.link');
      	$this->db->from('iccr_univercities');        
      	$this->db->where(array('university_type'=>7));
      	$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
      	return $this->db->get()->result_array();
	}
	
	function getAgriculturalUniversity()
	{
		$this->db->select('iccr_univercities.id,iccr_univercities.name as uni,iccr_univercities.link');
      	$this->db->from('iccr_univercities');        
      	$this->db->where(array('university_type'=>6));
      	$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
      	return $this->db->get()->result_array();
	}

	function ForwardToHqrsFourthOption($data,$appno)
	{
		$q = $this->db->insert_string('iccr_university_response_by_hqrs',$data);             
        $this->db->query($q);
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $this->db->insert_id();
	}
	function ForwardToHqrs($data,$appno)
	{
		$q = $this->db->insert_string('iccr_university_response',$data);             
        $this->db->query($q);
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $this->db->insert_id();
	}
	function insertTravelPlan($data)
	{
		$q = $this->db->insert_string('iccr_travelplan',$data);             
        $this->db->query($q);
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $this->db->insert_id();
	}
	function ForwardtoUniversity($appno,$data)
	{
		$this->db->where('application_no', $appno);		
		$this->db->update('iccr_status_mapping', $data); 
		$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $success = $this->db->affected_rows(); 
        if($success >= 0)
        	return TRUE;
        else
         	return FALSE;
	}
	function confirmregionforTravel($data,$appno)
	{
		$this->db->where('application_no', $appno);		
		$this->db->update('iccr_status_mapping', $data); 
		$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $success = $this->db->affected_rows(); 
        if($success >= 0)
        	return TRUE;
        else
         	return FALSE;
	}
	function insertRegionalVisaInfo($data)
	{
		$q = $this->db->insert_string('iccr_regional_VISAInfo',$data);             
        $this->db->query($q);
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $this->db->insert_id();
	}
	function updateVisaInfo($data,$appno)
	{
		$this->db->where('application_no', $appno);		
		$this->db->update('iccr_status_mapping', $data); 
		$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $success = $this->db->affected_rows(); 
        if($success >= 0)
        	return TRUE;
        else
         	return FALSE;
	}
	function updateMissionPass($data,$id)
	{
		$this->db->where('id', $id);		
		$this->db->update('iccr_missions', $data); 
		$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $success = $this->db->affected_rows(); 
        if($success >= 0)
        	return TRUE;
        else
         	return FALSE;
	}
	function getUniversityById($universityId)
	{
		$this->db->select('iccr_univercities.id,iccr_univercities.name,iccr_univercities.state');	  
      $this->db->from('iccr_univercities');      
      $this->db->where(array('iccr_univercities.id'=>$universityId)); 
      $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getUniversityStateById($universityId)
	{
		
       $this->db->select('iccr_univercities.state');	  
      $this->db->from('iccr_univercities');      
      $this->db->where(array('iccr_univercities.id'=>$universityId)); 
      $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getEnglishProficiencyTestResults($missionId)
	{
	  $this->db->select('iccr_status_mapping.english_proficiency_test_marks,iccr_status_mapping.ref_no,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email');	  
      $this->db->from('iccr_status_mapping');
      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');    
      $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');      
      $this->db->where(array('iccr_status_mapping.english_proficiency_test_marks !='=>'')); 
      $this->db->where_in('iccr_student_other_details.application_through',$missionId);
      $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getConfirmationofHqrs($missionId)
	{
		// Used in Mission Controller
	  $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_student_application_details.programme,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_status_mapping.university_is_accept,iccr_status_mapping.regional_university,iccr_status_mapping.scholarship_id,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three');	  
      $this->db->from('iccr_status_mapping');
      $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');      
      $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');      
      $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
      $this->db->where(array('iccr_status_mapping.status'=>10));
      $this->db->where(array('iccr_university_response.university_is_accept'=>1));
      $this->db->where_in('iccr_student_other_details.application_through',$missionId); 
      
      $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
      return $this->db->get()->result_array();
	}
	function applicantAcceptance($schemeids)
	{
		$this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_status_mapping.scholar_acceptance');	  
      $this->db->from('iccr_status_mapping');      
      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');      
      $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');      
      $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');      
      $this->db->where(array('iccr_status_mapping.status >='=>11,'iccr_status_mapping.status >='=>12));  
      $this->db->where_in('iccr_status_mapping.scholarship_id',$schemeids);    
      $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }  
      return $this->db->get()->result_array();
	}
	function getAcceptedCandidates($missionId)
	{		
	  $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.programme,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_status_mapping.undertaking_doc');	  
      $this->db->from('iccr_status_mapping');      
      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');      
      $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');      
      $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
      $this->db->where_in('iccr_student_other_details.application_through',$missionId); 
      $this->db->where_in('iccr_status_mapping.status',array(11,13)); 
      $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }      
      return $this->db->get()->result_array();
	}
	function getVisaConveyedApplicatgion($missionId)
	{
		$this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.programme,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university');	  
      $this->db->from('iccr_status_mapping');      
      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');      
      $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');      
      $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
      $this->db->where_in('iccr_student_other_details.application_through',$missionId);
      $this->db->where_in('iccr_status_mapping.status',array(13,-14));   
      $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }    
      return $this->db->get()->result_array();
	}
	function getConfirmationofCandidatesByAppno($missionId,$appno)
	{
	  $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university');	  
      $this->db->from('iccr_status_mapping');      
      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');      
      $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');      
      $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
      $this->db->where('iccr_status_mapping.application_no',$appno);
      $this->db->where_in('iccr_student_other_details.application_through',$missionId);
      $this->db->where_in('iccr_status_mapping.status',array(11,12));  
      $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }     
      return $this->db->get()->result_array();
	}
	function getConfirmationofCandidates($missionId)
	{
	  $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_status_mapping.scholar_acceptance');	  
      $this->db->from('iccr_status_mapping');      
      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');      
      $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');      
      $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
      $this->db->where_in('iccr_student_other_details.application_through',$missionId);
      $this->db->where(array('iccr_status_mapping.status >='=>11));      
      $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   } 
      return $this->db->get()->result_array();
	}
	function scholarconfirmation($data,$appno)
	{
		$this->db->where('application_no', $appno);
		$this->db->update('iccr_status_mapping', $data); 
		$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $success = $this->db->affected_rows(); 
        if($success >= 0)
        	return TRUE;
        else
         	return FALSE;
	}
	function scholarArrived($appno,$data)
	{
		$this->db->where('application_no', $appno);
		$this->db->update('iccr_status_mapping', $data); 
		$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $success = $this->db->affected_rows(); 
        if($success >= 0)
        	return TRUE;
        else
         	return FALSE;
	}
	function confirmtomissionofuseracceptance($appno,$data)
	{
		$this->db->where('application_no', $appno);
		$this->db->update('iccr_status_mapping', $data); 
		$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $success = $this->db->affected_rows(); 
        if($success >= 0)
        	return TRUE;
        else
         	return FALSE;
	}
	function updateMissionStatus($data,$userid,$appno)
	{		
		$this->db->where('application_no', $appno);
		$this->db->update('iccr_status_mapping', $data); 
		$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $success = $this->db->affected_rows(); 
        if($success >= 0)
        	return TRUE;
        else
         	return FALSE;
	}
	function getMissionsRejectedApplications($missionid)
	{
		 $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_status_mapping.mission_status');	  
	      $this->db->from('iccr_status_mapping');
	      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
	      $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
	      $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
	      $this->db->where(array('iccr_status_mapping.mission_status'=>2,'iccr_status_mapping.status'=>1));  
	      $this->db->where_in('iccr_student_other_details.application_through',$missionid);
	      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
	      return $this->db->get()->result_array();
	}
	function getRoApplication()
	{
		 $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no');	  
	      $this->db->from('iccr_status_mapping');
	      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
	      $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
	      $this->db->where(array('iccr_status_mapping.mission_status'=>2,'iccr_status_mapping.status'=>2));  
	      $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
	      return $this->db->get()->result_array();
	}
	function getMissionsProcessedApplications($missionid)
	{
		  $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_status_mapping.mission_status,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_three,iccr_student_application_details.course_option_name_two,iccr_student_application_details.programme,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.course_subject');	  
	      $this->db->from('iccr_status_mapping');
	      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
	      $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
	      $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');	      
	      $this->db->where_in('iccr_student_other_details.application_through',$missionid);  
	      $this->db->where_in('iccr_status_mapping.status',array(4,5));
	      $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
	      return $this->db->get()->result_array();
	}
	function getMissionsApprovedApplications($missionid)
	{
		  $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_status_mapping.mission_status');	  
	      $this->db->from('iccr_status_mapping');
	      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
	      $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
	      $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
	      $this->db->where(array('iccr_status_mapping.status > '=>0,'iccr_status_mapping.mission_status'=>1,'iccr_student_other_details.application_through'=>$missionid));  
	      $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
	      return $this->db->get()->result_array();
	}
	function getUniversityResponses($appno)
	{
		$sql ="SELECT application_id, GROUP_CONCAT(region_one_status SEPARATOR ',') as regional_office,GROUP_CONCAT(regional_university SEPARATOR ',') as University,GROUP_CONCAT(university_is_accept SEPARATOR ',') as response, GROUP_CONCAT(region_one_doc SEPARATOR ',') as docs
FROM iccr_university_response where application_id ='".$appno."' GROUP BY application_id";
$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
		return $this->db->query($sql)->result_array();
	}
	function getRegionalApplicationsConfirmationtoHqrs($schemeids)
	{
		$this->db->distinct();
		$this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.region_one_doc,iccr_status_mapping.university_is_accept,iccr_student_application_details.course,iccr_status_mapping.scholarship_id');	  
	      $this->db->from('iccr_status_mapping');
	      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
	      $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
	      $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
	      $this->db->where(array('iccr_status_mapping.status'=>4));
	      $this->db->where_in('iccr_status_mapping.scholarship_id',$schemeids); 
	    $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
	      return $this->db->get()->result_array();
	}
	function getconfirmationForwardtoMissionbyHqrs()
	{
		$this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status');	  
	      $this->db->from('iccr_status_mapping');
	      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
	      $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
	      $this->db->where(array('iccr_status_mapping.mission_status'=>1,'iccr_status_mapping.status'=>5,'iccr_status_mapping.region_one_status>'=>0,'iccr_status_mapping.iccr_status >'=>0));
	    	    $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }  
	      return $this->db->get()->result_array();
	}
	  
	function ExpenditureExists($appid)
	{
		$this->db->select('iccr_student_expenditure.*');	  
	    $this->db->from('iccr_student_expenditure');	     
	    $this->db->where('iccr_student_expenditure.application_id',$appid); 
	     $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }	  
	    return $this->db->get()->result_array();
	}
	function oldExpenditureExists($appid)
	{
		$this->db->select('iccr_old_student_expenditure.*');	  
	    $this->db->from('iccr_old_student_expenditure');	     
	    $this->db->where('iccr_old_student_expenditure.application_no',$appid); 	
	     $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }  
	    return $this->db->get()->result_array();
	}
	function getOldRegionalReceivedApplication($regionid)
	{
		$this->db->select('iccr_student_expenditure.*');	  
	    $this->db->from('iccr_student_expenditure');	
	    $this->db->join('iccr_univercities', 'iccr_univercities.id = iccr_student_expenditure.universty_choice');     
	    $this->db->where('iccr_student_expenditure.exp_student_type',"OLD"); 	
	    $this->db->where('iccr_univercities.state', $regionid);	  
	     $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
	    return $this->db->get()->result_array();
	}
	function getOldReceivedApplication($schemeids)
	{
		$this->db->select('iccr_student_expenditure.*');	  
	    $this->db->from('iccr_student_expenditure');	
	    $this->db->join('iccr_univercities', 'iccr_univercities.id = iccr_student_expenditure.universty_choice');     
	    $this->db->where('iccr_student_expenditure.exp_student_type',"OLD"); 	
	    $this->db->where_in('iccr_student_expenditure.scheme',$schemeids); 
	     $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
	    return $this->db->get()->result_array();
	}
	function getAcademicDetailsForhqrs($schemeids)
	{
	   $this->db->select('iccr_academic_details.*');
       $this->db->from('iccr_academic_details');
       $this->db->where_in('iccr_academic_details.scheme',$schemeids); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getRegionalReceivedApplication($regionId)
	{
		$this->db->distinct();
		$this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_student_application_details.course,iccr_student_application_details.programme,iccr_status_mapping.bonafide_doc,iccr_status_mapping.joining_doc,iccr_status_mapping.police_doc');	  
	      $this->db->from('iccr_status_mapping');
	      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
	      $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
	      $this->db->join('iccr_travelplan', 'iccr_travelplan.application_id = iccr_status_mapping.application_no');
	      $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no','left');
	      $this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no','left');
	      
	      $this->db->where('(iccr_university_response.region_one_status='.$regionId.' and iccr_university_response.university_is_accept=1) or (iccr_university_response_by_hqrs.region_one_status='.$regionId.' and iccr_university_response_by_hqrs.university_is_accept=1)'); 
	      $this->db->where(array('iccr_status_mapping.status'=>14,'iccr_travelplan.status'=>14)); 	  
	     // $this->db->where(' (iccr_student_application_details.university_choice_one_state='.$regionId.' or iccr_student_application_details.university_choice_two_state='.$regionId.' or iccr_student_application_details.university_choice_three_state='.$regionId.')'); 	
	      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }  
	      return $this->db->get()->result_array();
	}
	function getRegionalTravelApplication($regionId)
	{	
		$this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_status_mapping.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_status_mapping.travel_plan_doc,iccr_status_mapping.scholarship_id,iccr_status_mapping.regional_university,iccr_student_application_details.programme,iccr_student_application_details.course');	  
	      $this->db->from('iccr_status_mapping');
	      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
	      $this->db->join('iccr_countries', 'iccr_student_application_details.country = iccr_countries.id');
	      $this->db->join('iccr_travelplan', 'iccr_travelplan.application_id = iccr_status_mapping.application_no and iccr_travelplan.status = iccr_status_mapping.status');
	      
	     // $applicalitonIds = $this->getApplicationIdsofTravel($regionId);
	      if(sizeof($applicalitonIds)>0)
	      {
		  	// $this->db->join('iccr_university_response', 'iccr_university_response.application_id = iccr_status_mapping.application_no');
	        // $this->db->join('iccr_university_response_by_hqrs', 'iccr_university_response_by_hqrs.application_id = iccr_status_mapping.application_no');	
		  }	  
	      
	      $this->db->where_in('iccr_status_mapping.status',array(13,14,-14));
	     
	      if(sizeof($applicalitonIds)>0)
	      {
	      	//print_r($applicalitonIds);
		  	//$this->db->where_in('iccr_status_mapping.application_no',$applicalitonIds);
		  }
	     
	    //  $this->db->where('(iccr_university_response.region_one_status='.$regionId.' && iccr_university_response_by_hqrs.region_one_status='.$regionId.')'); 
	    //  $this->db->where('(iccr_university_response.university_is_accept!=2 or iccr_university_response_by_hqrs.university_is_accept!=2)'); 
	    //  $this->db->where('(iccr_university_response.university_is_accept=1 or iccr_university_response_by_hqrs.university_is_accept=1)'); 
	     
	      //$this->db->where(' (iccr_student_application_details.university_choice_one_state='.$regionId.' or iccr_student_application_details.university_choice_two_state='.$regionId.' or iccr_student_application_details.university_choice_three_state='.$regionId.')'); 	   
	      //  echo $this->db->_compile_select();
	      //  die;  
	       $code = $this->db->error(); 
	       if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
	      return $this->db->get()->result_array();
	}
	function getConfirmationofApplicationIds($appid)
	{
		$sql ="Select tt.* from ((SELECT t1.* FROM iccr_university_response as t1 WHERE t1.application_id='".$appid."') UNION ALL (SELECT t2.*  FROM iccr_university_response_by_hqrs as t2 WHERE  t2.application_id='".$appid."')) as tt where tt.university_is_accept=1";
		$q = $this->db->query($sql);
		return $q->result();
	}
	function getApplicationIdsofTravel($regionId)
	{
		//echo $regionId;
		$sql ="Select iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,
		iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,tt.region_one_status, tt.application_id,tt.region_one_status_date,tt.region_one_doc,tt.regional_university,tt.university_is_accept,tt.course,iccr_status_mapping.status,iccr_status_mapping.arrival_date,iccr_status_mapping.visa_from_date,iccr_status_mapping.visa_to_date,iccr_travelplan.travel_arrival_date,iccr_status_mapping.travel_informed_to_region,iccr_travelplan.travel_plan_doc,iccr_status_mapping.scholarship_id from ((SELECT t1.* FROM iccr_university_response as t1) UNION ALL (SELECT t2.*  FROM iccr_university_response_by_hqrs as t2)) as tt 
join iccr_status_mapping on iccr_status_mapping.application_no = tt.application_id 
join iccr_student_application_details on iccr_student_application_details.application_no = iccr_status_mapping.application_no 
join iccr_countries on iccr_student_application_details.country = iccr_countries.id 
join iccr_travelplan on iccr_travelplan.application_id = iccr_status_mapping.application_no and iccr_travelplan.status = iccr_status_mapping.status 
where iccr_status_mapping.status IN(13,14,-14) and tt.university_is_accept=1 and tt.region_one_status=".$regionId;

		return $this->db->query($sql)->result_array();
		
	}
	function getRegionalApplicationsForwardtoHqrs($regionId)
	{
		$this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status');	  
	      $this->db->from('iccr_status_mapping');
	      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
	      $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
	      $this->db->where(array('iccr_status_mapping.mission_status'=>1,'iccr_status_mapping.status'=>4,'iccr_status_mapping.region_one_status>'=>0,'iccr_status_mapping.iccr_status'=>-1)); 
	        $this->db->where(' (iccr_student_application_details.university_choice_one_state='.$regionId.' or iccr_student_application_details.university_choice_two_state='.$regionId.' or iccr_student_application_details.university_choice_three_state='.$regionId.')'); 	
	       $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }     
	      return $this->db->get()->result_array();
	}
	function getRegionalPendingUniversityApplications($regionId)
	{
		 $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_student_application_details.programme,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_status_mapping.university_status_1,iccr_status_mapping.university_status_2,iccr_status_mapping.university_status_3,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_status_mapping.scholarship_id,iccr_student_application_details.course_subject');	  
	      $this->db->from('iccr_status_mapping');
	      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
	      $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
	      $this->db->where_in('iccr_status_mapping.status',array(4)); 
	     // $this->db->where('iccr_status_mapping.region_one_status <',1);
	        $this->db->where(' (iccr_student_application_details.university_choice_one_state='.$regionId.' or iccr_student_application_details.university_choice_two_state='.$regionId.' or iccr_student_application_details.university_choice_three_state='.$regionId.') '); 
	    $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
	      return $this->db->get()->result_array();
	}
	function getRegionalApplications($regionId)
	{
		 $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.programme,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.email,iccr_status_mapping.university_status_1,iccr_status_mapping.university_status_2,iccr_status_mapping.university_status_3,iccr_status_mapping.uni_forwarded_letter,iccr_status_mapping.uni_forwarded_letter_two,iccr_status_mapping.uni_forwarded_letter_three,iccr_status_mapping.scholarship_id,iccr_student_application_details.course_subject');	  
	      $this->db->from('iccr_status_mapping');
	      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
	      $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
	      $this->db->where_in('iccr_status_mapping.status',array(4)); 
	        $this->db->where(' (iccr_student_application_details.university_choice_one_state='.$regionId.' or iccr_student_application_details.university_choice_two_state='.$regionId.' or iccr_student_application_details.university_choice_three_state='.$regionId.')'); 
	    $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
	      return $this->db->get()->result_array();
	}
	function getPendingUnderRegionalApplications($schemeids)
	{
		$this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_status_mapping.ref_no,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.university_choice_one_state,iccr_student_application_details.university_choice_two_state,iccr_student_application_details.university_choice_three_state,iccr_status_mapping.region_one_status,iccr_status_mapping.university_status,iccr_student_application_details.course');	  
	      $this->db->from('iccr_status_mapping');
	      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
	      $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
	      $this->db->where(array('iccr_status_mapping.status >='=>1)); 
	      $this->db->where_in('iccr_status_mapping.scholarship_id',$schemeids); 
	      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
	      return $this->db->get()->result_array();
	}
	function getHQRSAYUSHProcessedApplication($schemeids)
	{
		$this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_student_application_details.programme,iccr_student_application_details.course_two,iccr_student_application_details.course_three');	  
      $this->db->from('iccr_status_mapping');
      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
      $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
      $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
      $this->db->where(array('iccr_status_mapping.status'=>10));
      $this->db->where(array('iccr_student_application_details.course_type'=>1));     
      $this->db->where(array('iccr_student_application_details.university_choice_one_state'=>0,'iccr_student_application_details.university_choice_two_state'=>0,'iccr_student_application_details.university_choice_three_state'=>0));  
      $this->db->where_in('iccr_status_mapping.scholarship_id',$schemeids); 
      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
      return $this->db->get()->result_array();
	}
	function getHQRSAYUSHApplication($schemeids)
	{
		$this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_student_application_details.programme,iccr_student_application_details.course_two,iccr_student_application_details.course_three');	  
      $this->db->from('iccr_status_mapping');
      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
      $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
      $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
      $this->db->where(array('iccr_status_mapping.status'=>4));
      $this->db->where(array('iccr_student_application_details.course_type'=>1));
      $this->db->where(array('iccr_student_application_details.university_choice_one_state'=>0,'iccr_student_application_details.university_choice_two_state'=>0,'iccr_student_application_details.university_choice_three_state'=>0));  
      $this->db->where_in('iccr_status_mapping.scholarship_id',$schemeids); 
      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
      return $this->db->get()->result_array();
	}
	function getHqrsICARProcessedApplication($schemeids)
	{
	   $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_student_application_details.programme,iccr_student_application_details.course_two,iccr_student_application_details.course_three');	  
      $this->db->from('iccr_status_mapping');
      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
      $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
      $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
      $this->db->where(array('iccr_status_mapping.status'=>10)); 
      $this->db->where(array('iccr_student_application_details.course_type'=>2));        
      $this->db->where_in('iccr_status_mapping.scholarship_id',$schemeids); 
      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
      return $this->db->get()->result_array();
	}
	function getHqrsICARApplication($schemeids)
	{
	   $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_student_application_details.programme,iccr_student_application_details.course_two,iccr_student_application_details.course_three');	  
      $this->db->from('iccr_status_mapping');
      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
      $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
      $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
      $this->db->where(array('iccr_status_mapping.status'=>4));      
      $this->db->where(array('iccr_student_application_details.course_type'=>2));
      $this->db->where(array('iccr_student_application_details.university_choice_one_state'=>0,'iccr_student_application_details.university_choice_two_state'=>0,'iccr_student_application_details.university_choice_three_state'=>0));  
      $this->db->where_in('iccr_status_mapping.scholarship_id',$schemeids); 
      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
      return $this->db->get()->result_array();
	}
	function getHqrsAllNewApplication()
	{
		  $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_status_mapping.scholarship_id,iccr_student_application_details.programme,iccr_student_application_details.course_two,iccr_student_application_details.course_three');	  
      $this->db->from('iccr_status_mapping');
      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
      $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
      $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
      $this->db->where(array('iccr_status_mapping.status'=>1)); 
      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
      return $this->db->get()->result_array();
	}
	function getHqrsNewApplication($schemeids)
	{
		
		$this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_status_mapping.scholarship_id');	  
      $this->db->from('iccr_status_mapping');
      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
      $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
      $this->db->join('iccr_countries', 'iccr_student_application_details.nationality = iccr_countries.id');
      $this->db->where(array('iccr_status_mapping.status'=>4));  
      $this->db->where_in('iccr_status_mapping.scholarship_id',$schemeids); 
      $code = $this->db->error(); if($code['code'] > 0)
      {	      	
	  	show_error('Message');
	  }
      return $this->db->get()->result_array();
	}
	function getLastReference()
	{	
		 $sql = $this->db->query("select  SUBSTRING_INDEX(ref_no,'-',-1) as appid  from iccr_status_mapping where ref_no IS NOT NULL order by id DESC limit 0,1");
	  $code = $this->db->error(); if($code['code'] > 0)
      {	      	
	  	show_error('Message');
	  }
    	return $sql->result();		
	}
	function getApplicationData($appno,$userid)
	{
		$this->db->select('*');
      $this->db->from('iccr_student_application_details');
      $this->db->where(array('application_no'=>$appno));  
      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
      return $this->db->get()->result_array();
	}
	function getCountriesofMissions($emailid)
	{
	  $this->db->select('id');	  
       $this->db->from('iccr_missions');
       $this->db->where(array('iccr_missions.mission_email'=>$emailid));
       $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
        return $this->db->get()->result_array();
	}
    function getMissionApplications($missionId)
    {
      	
	  $this->db->select('iccr_status_mapping.status,iccr_student_application_details.application_no,iccr_student_application_details.fullname,iccr_student_application_details.email,iccr_countries.country_name,iccr_student_application_details.course,iccr_student_application_details.course_two,iccr_student_application_details.course_three,iccr_student_application_details.programme,iccr_student_application_details.course_option_name,iccr_student_application_details.course_option_name_two,iccr_student_application_details.course_option_name_three,iccr_student_application_details.universty_choice,iccr_student_application_details.universty_choice_two,iccr_student_application_details.universty_choice_three,iccr_student_application_details.course_subject');	  
      $this->db->from('iccr_status_mapping');
      $this->db->join('iccr_student_application_details', 'iccr_student_application_details.application_no = iccr_status_mapping.application_no');
      $this->db->join('iccr_student_other_details', 'iccr_student_other_details.application_no = iccr_status_mapping.application_no');
      $this->db->join('iccr_countries', 'iccr_student_other_details.mission_made_through = iccr_countries.id');
      
      $this->db->where(array('iccr_status_mapping.status'=>1,"iccr_status_mapping.mission_status"=>-1,'iccr_status_mapping.iccr_status'=>-1,'iccr_status_mapping.region_one_status'=>-1,'iccr_status_mapping.region_two_status'=>-1,'iccr_status_mapping.region_three_status'=>-1));  
      $this->db->where_in('iccr_student_other_details.application_through',$missionId);
      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
      return $this->db->get()->result_array();
	}
    function getNationality()
    {
	  $this->db->select('id,title');
      $this->db->from('iccr_nationality');
      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }  
      return $this->db->get()->result_array();
	}
	function getCountries()
    {
	  $this->db->select('id,country_name');
      $this->db->from('ks_countries');	
      $this->db->order_by('country_name','ASC');
      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }	  
      return $this->db->get()->result_array();
	}
	function getCountryById($id)
    {
	  $this->db->select('country_name');
      $this->db->from('iccr_countries');	  
      $this->db->where('id',$id);
      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
      return $this->db->get()->result_array();
	}
	function getNationalityById($id)
	{
		$this->db->select('title');
      $this->db->from('iccr_nationality');	  
      $this->db->where('id',$id);
      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
      return $this->db->get()->result_array();		
	}
	
	function getApplicationStatus($userid)
	{
	  $this->db->select('iccr_status_mapping.application_no,iccr_status_mapping.status,iccr_student_application_details.fullname,iccr_student_application_details.phone,iccr_student_application_details.email,iccr_student_application_details.nationality,iccr_student_other_details.signature_doc');	  
      $this->db->from('iccr_status_mapping');
      $this->db->join('iccr_student_details','iccr_student_details.uid=iccr_status_mapping.uid');
      $this->db->join('iccr_student_application_details','iccr_student_application_details.uid=iccr_status_mapping.uid');
      $this->db->join('iccr_student_other_details','iccr_student_other_details.application_no=iccr_status_mapping.application_no');
      $this->db->where('iccr_status_mapping.uid',$userid);  
      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
      return $this->db->get()->result_array();
	}
	function getApplicationStepOneByAppno($appno)
	{
	  $this->db->select('*');
      $this->db->from('iccr_student_application_details');
      $this->db->where('application_no',$appno);  
      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
      return $this->db->get()->result_array();
	}
	
	function getAcademicDetailsofApplicant($appno)
	{
	  $this->db->select('iccr_academic_staus.scholarship_status');
      $this->db->from('iccr_academic_details');
      $this->db->join('iccr_academic_staus','iccr_academic_staus.application_id=iccr_academic_details.application_id');
      $this->db->where(array('iccr_academic_details.application_id'=>$appno));  
       $this->db->order_by('iccr_academic_details.id','DESC');
      $this->db->limit(1);	
      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
      return $this->db->get()->result_array();
	}
	function getApplicationStepOne($userid)
	{
	  $this->db->select('*');
      $this->db->from('iccr_student_application_details');
      $this->db->where('uid',$userid);  
      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
      return $this->db->get()->result_array();
	}
	function getApplicationStepTwo($userid)
	{
	  $this->db->select('*');
      $this->db->from('iccr_student_education_details');
      $this->db->where('uid',$userid);  
      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
      return $this->db->get()->result_array();
	}
	function getApplicationStepTwoByAppno($appno)
	{
	  $this->db->select('*');
      $this->db->from('iccr_student_education_details');
      $this->db->where('application_no',$appno);  
      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
      return $this->db->get()->result_array();
	}
	function getApplicationStepThreebyAppNo($appno)
	{
	  $this->db->select('*');
      $this->db->from('iccr_student_other_details');
      $this->db->where('application_no',$appno);  
      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
      return $this->db->get()->result_array();
	}
	function getApplicationStepThree($userid)
	{
	  $this->db->select('*');
      $this->db->from('iccr_student_other_details');
      $this->db->where('uid',$userid);  
      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
      return $this->db->get()->result_array();
	}
	
	function getUserImage($userid)
	{
	  $this->db->select('*');
      $this->db->from('ks_profile_image');
      $this->db->where('uid',$userid);  
      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
      return $this->db->get()->result_array();
	}
	function imageExists($userid)
	{
	  $this->db->select('*');
      $this->db->from('ks_group_pics');
      $this->db->where('gid',$userid);  
      $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
      return $this->db->get()->result_array();
	}	
	function getGgoupImage($id)
	{
	  $this->db->select('*');
      $this->db->from('ks_group_pics');
      $this->db->where('gid',$id);  
      return $this->db->get()->result_array();
	}
	
	
	function getUsersImage($id)
	{
	
	  $this->db->select('*');
      $this->db->from('ks_profile_image');
      $this->db->where('uid',$id);  
      return $this->db->get()->result_array();
	}
	function insertGroupImage($data)
	{
		$q = $this->db->insert_string('ks_group_pics',$data);             
        $this->db->query($q);
        $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
        return $this->db->insert_id();	
	}
	function insertUserImage($image,$userid)
	{
		$data = array(
			'name'=>$image,
			'created'=>date('y-m-d h:i:s a'),
			'status'=>1,
			'uid'=>$userid
        );
        $q = $this->db->insert_string('ks_profile_image',$data);             
        $this->db->query($q);
        $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
        return $this->db->insert_id();
	}
	function uploadUserProfilePic($name,$userid)
	{
		$data = array(
			'name'=>$name,
			'created'=>date('y-m-d h:i:s a'),
			'status'=>1
        );

		//check image exits or not
		$checkimage = $this->getUserImage($userid);
		
		if(count($checkimage)>0){
			
			$this->db->where('uid', $userid);
			$this->db->update('ks_profile_image', $data); 
			$code = $this->db->error(); if($code['code'] > 0)
			   {	      	
				  show_error('Message');
			   }
			$success = $this->db->affected_rows();

			if(!$success){
				return false;
			}

		}else{
			$this->insertUserImage($name,$userid);
		}
 
        return TRUE;
	}
	function uploadProfilePic($name,$userid)
	{
		$data = array(
			'name'=>$name,
			'created'=>date('y-m-d h:i:s a'),
			'status'=>1
        );
        $this->db->where('gid', $userid);
        $this->db->update('ks_group_pics', $data); 
        $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            return false;
        }
        return TRUE;
	}
    function updateProfile($post)
    {
		$data = array(
			'first_name'=>$post['fullname'],
			'phone'=>$post['mobile_number'],
			'email'=>$post['useremail']
        );
        $this->db->where('id', $post['userid']);
        $this->db->update('users', $data); 
        $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            return false;
        }
        return TRUE;
	}
	function updateProfileAgent($post)
	{
		$data = array(
			'first_name'=>$post['fullname'],
			'phone'=>$post['mobile_number'],
			'company'=>$post['company'],
			'ceano'=>$post['cea_number']
        );
        $this->db->where('id', $post['userid']);
        $this->db->update('users', $data); 
        $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            return false;
        }
        return TRUE;
	}
    function insertFbUser($post)
    {
		try
		{
			$string = array(
            	'username'=>$post['email'],
                'first_name'=>$post['name'],
                'email'=>$post['email'],
			    'phone'=>$post['mobile'],
                'role'=>$this->roles[0], 
				'password'=>"", 
				'user_type'=>$post['user_type'],
                'status'=>$this->status[1],
                'facebookid'=>$post['fbid']
            );
            $q = $this->db->insert_string('users',$string);             
            $this->db->query($q);
            $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
            return $this->db->insert_id();
		}
		catch(Exception $e)
		{
			return 0;
		}
	}	
	
	function updateUserImage($post)
	{
		$data = array(
               'image'=>$post['image']
        );
        $this->db->where('userid', $post['userid']);
        $this->db->update('user_profile_image', $data); 
        $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            return false;
        }
        return TRUE; 
	}
	
    public function insertUserFromMobile($d)
    {  
            $string = array(
            	'username'=>$d['username'],
                'first_name'=>$d['firstname'],
                'email'=>$d['email'],
			    'phone'=>$d['phone'],
                'role'=>$this->roles[0], 
				'password'=>md5($d['password']), 
				'user_type'=>$d['user_type'],
                'status'=>$this->status[1]
            );
            $q = $this->db->insert_string('users',$string);      
            $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }       
            $this->db->query($q);
            return $this->db->insert_id();
    }
    function insertStudentDetails($d)
    {
		 $string = array(
            	'country_of_domicile'=>$d['country'],
                'gender'=>$d['gender'],	
				'date_of_birth'=>$d['dob'],
				'mobile_number'=>$d['mobile_no'],
                'currently_in_india'=>$d['isindian'],
                'created'=>date('Y-m-d h:i:s'),
                'uid' => $d['uid']
            );
            $q = $this->db->insert_string('iccr_student_details',$string);     
            $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }        
            $this->db->query($q);
            return $this->db->insert_id();
	}
	public function insertRegion_User($string)
    {  
		try{
            $q = $this->db->insert_string('iccr_users',$string);             
            $this->db->query($q);
            $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
            return $this->db->insert_id();
		}
		catch(Exception $e)
		{
		return false;
		}
    }
    public function getAllWorkflowchannels($id)
    {
		$this->db->select('ks_workflow.*');
       $this->db->from('ks_workflow');
       $this->db->where('channel_status',1); 
       if($id > 0)
       {
	   		$this->db->where('uid',$id);  	
	   }
       $this->db->order_by('id','desc');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
    public function insertWorkflowChannels($channel)
    {  
		try
		{
           $q = $this->db->insert_string('ks_workflow',$channel);             
           $this->db->query($q);
           $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
           return $this->db->insert_id();
		}
		catch(Exception $e)
		{
			return false;
		}
    }
	public function insertIoTStreams($streams){
		try {
			$q = $this->db->insert_string('ks_iotstreams',$streams);
			$this->db->query($q);
			$code = $this->db->error();
			if ($code['code'] > 0) {
				show_error('Message');
			}
			return $this->db->insert_id();
		} catch (Exception $e) {
			return false;
		}
	}
    public function insertChannels($channel)
    {  
		try
		{
           $q = $this->db->insert_string('ks_channels',$channel);             
           $this->db->query($q);
           $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
           return $this->db->insert_id();
		}
		catch(Exception $e)
		{
			return false;
		}
    }
    public function insertSchedule($schedule)
    {  
		try
		{
           $q = $this->db->insert_string('ks_schedules',$schedule);             
           $this->db->query($q);
           $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
           return $this->db->insert_id();
		}
		catch(Exception $e)
		{
			return false;
		}
    }
    public function updateSchedule($data,$id)
    {
		$this->db->where('id', $id);
        $this->db->update('ks_schedules', $data); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $this->db->affected_rows(); 
	}
    public function insertEncodeingTemplate($encoder)
    {  
		try
		{
           $q = $this->db->insert_string('ks_encoding_template',$encoder);             
           $this->db->query($q);
           $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
           return $this->db->insert_id();
		}
		catch(Exception $e)
		{
			return false;
		}
    }
    public function insertEncoder($encoder)
    {  
		try
		{
           $q = $this->db->insert_string('ks_encoder',$encoder);             
           $this->db->query($q);
           $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
           return $this->db->insert_id();
		}
		catch(Exception $e)
		{
			return false;
		}
    }
    public function insertNebula($encoder)
    {  
		try
		{
           $q = $this->db->insert_string('ks_nebula',$encoder);             
           $this->db->query($q);
           $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
           return $this->db->insert_id();
		}
		catch(Exception $e)
		{
			return false;
		}
    }
    public function insertGateway($encoder)
    {  
		try
		{
           $q = $this->db->insert_string('ks_gateways',$encoder);             
           $this->db->query($q);
           $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
           return $this->db->insert_id();
		}
		catch(Exception $e)
		{
			return false;
		}
    }
    public function insertGroup($group)
    {  
		try
		{
           $q = $this->db->insert_string('ks_groups',$group);             
           $this->db->query($q);
           $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
           return $this->db->insert_id();
		}
		catch(Exception $e)
		{
			return false;
		}
    } 
	 public function insertConfiguration($group)
    {  
		try
		{
           $q = $this->db->insert_string('ks_wowza',$group);             
           $this->db->query($q);
           $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
           return $this->db->insert_id();
		}
		catch(Exception $e)
		{
			return false;
		}
    } 
    public function insertTarget($data)
    {  
		try
		{
           $q = $this->db->insert_string('ks_target',$data);             
           $this->db->query($q);
           $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
           return $this->db->insert_id();
		}
		catch(Exception $e)
		{
			return false;
		}
    }
	 public function insertCreateVod($group)
    {  
		try
		{
           $q = $this->db->insert_string('ks_application',$group);             
           $this->db->query($q);
           $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
           return $this->db->insert_id();
		}
		catch(Exception $e)
		{
			return false;
		}
    } 
	public function insertUser($d)
    {  
		try{
			//echo "<pre>";print_r($d);die;
            $string = array(
            	'username'=>$d['username'],
                'email_id'=>$d['emailId'],	
				'password'=>md5($d['password']),
				'user_type'=>1,
                'status'=>0,
                'created'=>date('Y-m-d h:i:s'),
                'state'=>0
            );
			
            $q = $this->db->insert_string('iccr_users',$string);             
            $this->db->query($q);
            $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
            return $this->db->insert_id();
		}
		catch(Exception $e)
		{
		return false;
		}
    }    
    public function isDuplicate($email)
    {     
        $this->db->get_where('iccr_users', array('email_id' => $email), 1);
        $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;         
    }
    public function isDuplicateFb($fbid)
    {     
        $this->db->get_where('users', array('facebookid' => $fbid), 1);
        $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
        return $this->db->affected_rows() > 0 ? TRUE : FALSE;         
    }
    public function insertToken($user_id)
    {   
        $token = substr(sha1(rand()), 0, 30); 
        $date = date('Y-m-d');        
        $string = array(
                'token'=> $token,
                'user_id'=>$user_id,
                'created'=>$date
            );
        $query = $this->db->insert_string('iccr_tokens',$string);
        
        $this->db->query($query);
        $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
        return $token . $user_id;
        
    }
	public function isTokenValid($token)
    {
       $tkn = substr($token,0,30);
       $uid = substr($token,30);      
       
        $q = $this->db->get_where('iccr_tokens', array(
            'iccr_tokens.token' => $tkn, 
            'iccr_tokens.user_id' => $uid), 1);      
        $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
        if($this->db->affected_rows() > 0){
            $row = $q->row();             
            
            $created = $row->created;
            $createdTS = strtotime($created);
            $today = date('Y-m-d'); 
            $todayTS = strtotime($today);
            
            if($createdTS != $todayTS){
                return false;
            }
            
            $user_info = $this->getUserInfo($row->user_id);
            return $user_info;
            
        }else{
            return false;
        }
        
    }   
    public function updateEncodingTemplate($data,$id)
    {
		$this->db->where('id', $id);
        $this->db->update('ks_encoding_template', $data); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $this->db->affected_rows(); 
	}
    public function updateEncoder($data,$id)
    {
		$this->db->where('id', $id);
        $this->db->update('ks_encoder', $data); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $this->db->affected_rows(); 
	}
	public function updateEncoderByItsEncoderId($data,$id)
    {
		$this->db->where('encoder_id', $id);
        $this->db->update('ks_encoder', $data); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $this->db->affected_rows(); 
	}
	public function updateEncoderHardware($data,$id)
    {
		$this->db->where(array('encid'=>$id,'hardware_id'=>$data['hardware_id']));
        $this->db->update('ks_encoder_hardware', $data); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $this->db->affected_rows(); 
	}
	public function updateEncoderInp($data,$id)
    {
		$this->db->where(array('encid'=>$id,'inp_name'=>$data['inp_name']));
        $this->db->update('ks_encoder_sources', $data); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $this->db->affected_rows(); 
	}	
	public function updateEncoderOut($data,$id)
    {
		$this->db->where(array('encid'=>$id,'out_name'=>$data['out_name']));
        $this->db->update('ks_encoder_destinations', $data); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $this->db->affected_rows(); 
	}
	 public function updateNebula($data,$id)
    {
		$this->db->where('id', $id);
        $this->db->update('ks_nebula', $data); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $this->db->affected_rows(); 
	}
	 public function updateGateway($data,$id)
    {
		$this->db->where('id', $id);
        $this->db->update('ks_gateways', $data); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $this->db->affected_rows(); 
	}
    public function updateGroupInfo($data,$id)
    {
		
		$this->db->where('id', $id);
        $this->db->update('ks_groups', $data); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $this->db->affected_rows(); 
        
	}
	public function updateUsersInfo($data,$id)
    {
		$this->db->where('id', $id);
        $this->db->update('ks_users', $data); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $this->db->affected_rows(); 
        
	}
	public function updateGroupInfo1($data,$id)
    {
		
		 $this->db->where('id', $id);
        $this->db->update('ks_users', $data); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $this->db->affected_rows(); 
        
	}
	public function updatePassword($post)
	{
		$data = array(
               'password' => $post['password']
        );
        $this->db->where('id', $post['user_id']);
        $this->db->update('users', $data); 
        $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
        $success = $this->db->affected_rows(); 
        
        if(!$success){
            error_log('Unable to updateUserInfo('.$post['user_id'].')');
            return false;
        }
        
        $user_info = $this->getUserInfo($post['user_id']); 
        return $user_info; 
	}
	public function holdApplication($appid)
	{
		$data = array(
               'status'=>3
        );
        $this->db->where('application_no', $appid);
        $this->db->update('iccr_status_mapping', $data); 
        $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
        $success = $this->db->affected_rows(); 
        if(!$success){
            return false;
        }
        return TRUE; 
	}
    function updateUserProfile($post){
		try
		{
			$string = array(
                'first_name'=>$post['name'],
                'email'=>$post['email'],
			    'phone'=>$post['mobile'],
			    'user_profile_image'=>$post['user_image']
            );
            $this->db->where('id', $post['user_id']); 
            $q = $this->db->update('users',$string); 
            $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
            $success = $this->db->affected_rows($q);
                        
	        if(!$success){
	            //error_log('Unable to update User Profile');
	            return FALSE;
	        }
	        return TRUE;
		}
		catch(Exception $e)
		{
			return FALSE;
		}
	}
	function updateUserRegistration($post)
	{
		try
		{
			$string = array(
            	'username'=>$post['phone'],
                'first_name'=>$post['firstname'],
                'email'=>$post['email'],
			    'phone'=>$post['phone'],
                'role'=>$this->roles[0], 
				'password'=>"", 
				'user_type'=>$post['user_type'],
                'status'=>$this->status[1]
            );
            $q = $this->db->insert_string('users',$string);             
            $this->db->query($q);
            $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
            $id = $this->db->insert_id();            
	        if($id <= 0){
	            error_log('Unable to updateUserRegistration()');
	            return FALSE;
	        }
	        return TRUE;
		}
		catch(Exception $e)
		{
			return FALSE;
		}
	}
	function checkFbLogin($post)
	{
		$fbid =$post['fbid'];		        	
    	$condition = array("facebookid"=>$fbid,"status"=>"1");
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where($condition);
		$rs=$this->db->get();
		$code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
		if($rs->num_rows()>0) 
		{
		   $row = $rs->row();
		   $datas = array(
			 'userid'=> $row->id,
			 'fname'=> $row->first_name,
			 'email'=> $row->email,
			 'user_type'=> $row->user_type,
			 'user_image'=> $row->user_profile_image,	
			 'phone'=> $row->phone,
			 'facebookid'=>$row->facebookid								
			);
		   $this->session->set_userdata('user_data',$datas);
		   return true;
		 }
		 else
		 {
			$this->session->set_flashdata('loginerror', '<div class="error" style="color:red;">Please enter valid login/password</div>');
			return false;
		 }
	}
    public function checkLoginmobile($data)
    {    	
    	$phone = $data['mobile'];		
    	$condition = array("username"=>$phone);
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where($condition);
		$rs=$this->db->get();
		$code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
		if($rs->num_rows()>0)
		{ 		 
		   $row = $rs->row();
		   $datas = array(
			 'userid'=> $row->id,
			 'fname'=> $row->first_name,
			 'email'=> $row->email,
			 'user_type'=> $row->user_type																		
			);
		  $this->session->set_userdata('user_data',$datas);
			return TRUE;
		}else{
			/*$string = array(
            	'username'=>$phone,
                'first_name'=>"",
                'email'=>"",
			    'phone'=>$phone,
                'role'=>$this->roles[0], 
				'password'=>"", 
                'status'=>$this->status[0]
            );
            $q = $this->db->insert_string('users',$string); 
                        
            $this->db->query($q);
            $this->db->insert_id();*/
			return FALSE;
		}
    }
    public function updateLoginTime($id)
    {
        $this->db->where('id', $id);
        $this->db->update('users', array('last_login' => date('Y-m-d h:i:s A')));
        $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
        return;
    }
	
	
	public function getUserInfoByEmail($email)
    {
        $q = $this->db->get_where('users', array('email' => $email), 1);  
        $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   }
        if($this->db->affected_rows() > 0){
            $row = $q->row();
            return $row;
        }else{
            error_log('no user found getUserInfo('.$email.')');
            return false;
        }
    }
	function getUserInfoByFbId($id)
    {
        $q = $this->db->get_where('users', array('facebookid' => $id), 1); 
        $code = $this->db->error(); if($code['code'] > 0)
		   {	      	
			  show_error('Message');
		   } 
        if($this->db->affected_rows() > 0){
            $row = $q->row();
            return $row;
        }else{
            error_log('no user found getUserInfo('.$id.')');
            return false;
        }
    }
	public function update_user($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('ks_users', $data);
		$success = $this->db->affected_rows(); 
		if($success){
			
			return true;
		}else{
			
			return false;
		}
    }
    function getAllSchedules($id=0,$uid=0)
    {
		$this->db->select("*");
		$this->db->from("ks_schedules");
		if($id>0)
		{
			$this->db->where('id',$id);	
		}
		if($uid > 0)
		{
			$this->db->where('uid',$uid);	
		}
		$this->db->order_by('id','DESC');
		return $this->db->get()->result_array();
	}
    function getAllEncoders($id=0,$uid=0)
    {
		$this->db->select("*");
		$this->db->from("ks_encoder");
		if($id>0)
		{
			$this->db->where('id',$id);	
		}
		if($uid > 0)
		{
			$this->db->where('uid',$uid);	
		}
		//$this->db->where('status',1);
		$this->db->order_by('id','DESC');
		return $this->db->get()->result_array();
	}
	function getAllRundownClips($rundownid)
    {
		$this->db->select("*");
		$this->db->from("ks_rundown_clips");
		if($rundownid>0)
		{
			$this->db->where('rundown_id',$rundownid);	
		}		
		return $this->db->get()->result_array();
	}
	function getAllEncodersbyStatusAndEnc($id=0,$uid=0,$encid)
    {
		$this->db->select("*");
		$this->db->from("ks_encoder");
		if($id>0)
		{
			$this->db->where('id',$id);	
		}
		if($uid > 0)
		{
			$this->db->where('uid',$uid);	
		}
		$this->db->where('status',1);
		if($encid > 0)
		{
			$this->db->or_where('id',$encid);	
		}
		
		$this->db->order_by('id','DESC');
		return $this->db->get()->result_array();
	}
	function getAllEncodersbyStatus($id=0,$uid=0)
    {
		$this->db->select("*");
		$this->db->from("ks_encoder");
		if($id>0)
		{
			$this->db->where('id',$id);	
		}
		if($uid > 0)
		{
			$this->db->where('uid',$uid);	
		}
		$this->db->where('status',1);
		$this->db->order_by('id','DESC');
		return $this->db->get()->result_array();
	}
	function getEncoderByEncoderID($id=0)
    {
		$this->db->select("*");
		$this->db->from("ks_encoder");
		if($id !="")
		{
			$this->db->where('encoder_id',$id);	
		}		
		return $this->db->get()->result_array();
	}
	function getGatewayEncoderByEncoderID($id)
    {
		$this->db->select("*");
		$this->db->from("ks_gateways");
		if($id !="")
		{
			$this->db->where('encoder_id',$id);	
		}		
		return $this->db->get()->result_array();
	}
	function getAllNebula($id=0,$uid=0)
    {
		$this->db->select("*");
		$this->db->from("ks_nebula");
		if($id>0)
		{
			$this->db->where('id',$id);	
		}
		if($uid > 0)
		{
			$this->db->where('uid',$uid);	
		}
		$this->db->order_by('id','DESC');
		return $this->db->get()->result_array();
	}
	function getAllGateways($id=0,$uid=0)
    {
		$this->db->select("*");
		$this->db->from("ks_gateways");
		if($id>0)
		{
			$this->db->where('id',$id);	
		}
		if($uid > 0)
		{
			$this->db->where('uid',$uid);	
		}
		$this->db->order_by('id','DESC');
		return $this->db->get()->result_array();
	}
	
	
    public function getGroupByType($type)
    {
		$this->db->select("*");
		$this->db->from("ks_groups");
		$this->db->where('group_type',$type);
		$this->db->order_by('id','DESC');
		return $this->db->get()->result_array();
	}
    public function getConfigurationsDetails($userid=0,$groupid=0)
	{	
		$this->db->select("*");
		$this->db->from("ks_wowza");
		if($userid>0){
			$this->db->where(array('uid'=>$userid));
		}
		if($groupid>0){
			$this->db->where(array('group_id'=>$groupid));
		}

		$this->db->order_by('id','DESC');
		return $this->db->get()->result_array();
	}
	
	public function getAllApplications($user_id=0)
	{		
		$this->db->select("*");	
		$this->db->from("ks_application");
		$this->db->where('status',1);   
		$this->db->order_by('id','DESC');
		if($user_id>0){
			$this->db->where('uid',$user_id);
		}
		return $this->db->get()->result_array();
	}
	public function getAllArchiveApplications($user_id=0,$vars)
	{		
		$this->db->select("*");	
		$this->db->from("ks_application");
		$this->db->where('status',0);   
		if($user_id>0){
			$this->db->where('uid',$user_id);
		}
		$this->db->limit($vars['length'],$vars['start']);
		return $this->db->get()->result_array();
	}
	public function getAllTotalArchiveApplications($user_id=0)
	{		
		$this->db->select("count(id) as total");	
		$this->db->from("ks_application");
		$this->db->where('status',0);   
		if($user_id>0){
			$this->db->where('uid',$user_id);
		}
		return $this->db->get()->result_array();
	}
	public function getAllApplicationsbyUserID($user_id=0)
	{		
		$this->db->select("*");	
		$this->db->from("ks_application");		  
		if($user_id>0){
			$this->db->where('uid',$user_id);
		}
		return $this->db->get()->result_array();
	}
	
	public function getGroupApplicationsByUserid($id)
	{		
		$this->db->select("*");	
		$this->db->from("ks_application");
		$this->db->where('uid',$id);
		return $this->db->get()->result_array();
	}
	
	public function getApplicationbyId($id)
	{
		$condition = array('id'=>$id);
		$this->db->select("*");
		$this->db->where($condition);	
		$this->db->from("ks_application");
		return $this->db->get()->result_array();
	}
	public function getAllTargets($user_id=0)
	{
		$this->db->select("*");	
		$this->db->from("ks_target");
		$this->db->where('status',1);   
		if($user_id>0){
			$this->db->where('uid',$user_id);
		}
		$this->db->where('status',1);   
		$this->db->order_by('id','DESC');
		return $this->db->get()->result_array();
	}
	public function getAllArchiveTargets($user_id=0,$vars)
	{
		$this->db->select("*");	
		$this->db->from("ks_target");		  
		if($user_id>0){
			$this->db->where('uid',$user_id);
		}
		$this->db->where('status',0); 
		$this->db->limit($vars['length'],$vars['start']);  
		$this->db->order_by('id','DESC');
		return $this->db->get()->result_array();
	}
	public function getAllTotalArchiveTargets($user_id=0)
	{
		$this->db->select("count(id) as total");	
		$this->db->from("ks_target");
		$this->db->where('status',0);   
		if($user_id>0){
			$this->db->where('uid',$user_id);
		}
		  
		$this->db->order_by('id','DESC');
		return $this->db->get()->result_array();
	}
	public function getTargetsByUserid($id)
	{		
		$this->db->select("*");	
		$this->db->from("ks_target");
		$this->db->where('uid',$id);
		return $this->db->get()->result_array();
	}
	public function getAllWowza()
	{		
		$this->db->select("*");	
		$this->db->from("ks_wowza");
		return $this->db->get()->result_array();
	}
	public function getAllTimezone()
	{		
		$this->db->select("*");	
		$this->db->from("ks_time_zones");
		return $this->db->get()->result_array();
	}
	public function getTimezoneById($id)
	{		
		$condition = array('timeZoneId'=>$id);
		$this->db->select("*");	
		$this->db->where($condition);
		$this->db->from("ks_time_zones");
		return $this->db->get()->result_array();
	}
	public function getWowzabyID($id)
	{
		$condition = array('id'=>$id);
		$this->db->select("*");
		$this->db->where($condition);
		$this->db->from("ks_wowza");
		return $this->db->get()->result_array();
	}
	public function getBlockByDistricts($ip_id)
	{
		$condition = array('id'=>$ip_id);
		$this->db->select("*");
		$this->db->where($condition);
		$this->db->from("ks_wowza");
		return $this->db->get()->result_array();
	}
	public function getApplicationStreams($id)
	{
		$condition = array('id'=>$id);
		$this->db->select("*");
		$this->db->where($condition);
		$this->db->from("ks_application");
		return $this->db->get()->result_array();
	}
	public function getdetail($id)
	{
	   $condition = array('ks_profile_image.id'=>$id);
	   $this->db->select('ks_profile_image.*');
       $this->db->from('ks_users');
       $this->db->join('ks_profile_image', 'ks_profile_image.uid = ks_users.id');
       $this->db->where($condition);
	   return $this->db->get()->result_array();
	}
	public function getgroupImageess($id)
	{
	   $condition = array('ks_group_pics.id'=>$id);
	   $this->db->select('ks_group_pics.*');
       $this->db->from('ks_groups');
       $this->db->join('ks_group_pics', 'ks_group_pics.uid = ks_groups.id');
       $this->db->where($condition);
	   return $this->db->get()->result_array();
	}
	public function getWovzData($id)
	{
		$condition = array('id'=>$id);
		$this->db->select("*");
		$this->db->where($condition);
		$this->db->from("ks_wowza");
		return $this->db->get()->result_array();
	}
	function updateConfiguration($appid,$data)
	{		
		$this->db->where('id', $appid);
		$this->db->update('ks_wowza', $data); 
		$code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        $success = $this->db->affected_rows(); 
        if($success >= 0)
        	return TRUE;
        else
         	return FALSE;
	}
	
		public function checkPass($username)
	    {
			$this->db->select('*');
			$this->db->from('ks_users');
			$this->db->where('email_id',$username); 
			$rs=$this->db->get();
			if($rs->num_rows()>0) 
			{
			   $row = $rs->row();
			   return $row;
			 }
			 else
			 {			
				return false;
			 }
	    }
	
		public function checkWowzaStatus($uid)
	    {
			$this->db->select('*');
			$this->db->from('ks_permissions');
			//$this->db->where('email_id',$username); 
			$this->db->where('rid',$uid); 
			$rs=$this->db->get();
			if($rs->num_rows()>0) 
			{
			   $row = $rs->row();
			   return $row;
			 }
			 else
			 {			
				return false;
			 }
	    }
		public function checkUserStatus($email,$pass)
    {
		$this->db->select('*');
		$this->db->from('ks_users');
		$this->db->where('password',$pass); 
		$this->db->where('email_id',$email); 
		$rs=$this->db->get();
		
		if($rs->num_rows()>0) 
		{
		   return true;
		 }
		 else
		 {			
			return false;
		 }
    }
	
	public function updatePassowrd($username,$data)
	{
		try
		{
            $this->db->where('email_id',$username); 
            $q = $this->db->update('ks_users',$data);           
            $success = $this->db->affected_rows($q);           
	        if(!$success){
	            return FALSE;
	        }
	        return TRUE;
		}
		catch(Exception $e)
		{
			return FALSE;
		}
	}
	
	
	
	//vipin
	
	
	
	   function getGroupuserbyId($id)
    {
	   $this->db->select('*');
       $this->db->from('ks_users');
       $this->db->where('group_id',$id);   
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $result = $this->db->get()->result_array();
	}
	
	
	function getUserDetails($uid)
    {
	   $this->db->select('*');
       $this->db->from('ks_users');
       $this->db->where('id',$uid);   
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $result = $this->db->get()->result_array();
	}
	function deleteEncoderSources($id)
	{		
		$this->db->where('encid', $id);	
       $this->db->delete('ks_encoder_sources');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->affected_rows();
	}
	function deleteEncoderDestinations($id)
	{		
		$this->db->where('encid', $id);	
       $this->db->delete('ks_encoder_destinations');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->affected_rows();
	}
	function deleteGroups($id)
	{		
		$this->db->where('id', $id);	
       $this->db->delete('ks_groups');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->affected_rows();
	}
	
	function channelInput($cid)
	{
	   $this->db->select('*');
       $this->db->from('ks_channel_input');
       $this->db->where('id',$cid);
       return $result = $this->db->get()->result_array();
	}
	
		function channelOutput($cid)
	{
	   $this->db->select('*');
       $this->db->from('ks_channel_output');
       $this->db->where('id',$cid);
       return $result = $this->db->get()->result_array();
	}
	function insertRundown($rundown)
	{
		$q = $this->db->insert_string('ks_rundowns',$rundown);             
        $this->db->query($q);
        return $this->db->insert_id();
	}
	function insertRundownClips($clip)
	{
		$q = $this->db->insert_string('ks_rundown_clips',$clip);             
        $this->db->query($q);
        return $this->db->insert_id();
	}
	
	function getAllRundowns($id)
	{
	   $this->db->select('*');
       $this->db->from('ks_rundowns');   
       $this->db->order_by('id','desc');  
	   $code = $this->db->error(); 
	   if($id>0)
		{
			$this->db->where('id',$id);	
		}
	   if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->get()->result_array();
	}
	function getAllRundownsByIds($ids)
	{
		$this->db->select('*');
		$this->db->from('ks_rundowns');
		$this->db->order_by('id','desc');
		$code = $this->db->error();
		if ($id>0) {
			$this->db->where_in('engine_id',$ids);
		}
		if ($code['code'] > 0) {
			show_error('Message');
		}
		return $this->db->get()->result_array();
	}
	function deleteRundown($rundownid)
	{	          
       $this->db->where('id', $rundownid);	
       $this->db->delete('ks_rundowns');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->affected_rows();
	}
	public function updateRundown($data,$id)
    {
		$this->db->where('id', $id);
        $this->db->update('ks_rundowns', $data); 
        $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
        return $this->db->affected_rows(); 
	}
	function deleteRundownClips($rundownid)
	{	          
       $this->db->where('rundown_id', $rundownid);	
       $this->db->delete('ks_rundown_clips');
       $code = $this->db->error(); if($code['code'] > 0)
	   {	      	
		  show_error('Message');
	   }
       return $this->db->affected_rows();
	}
} 
?>