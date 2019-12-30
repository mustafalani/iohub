<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common_model extends CI_Model
{
	function insert_data($table, $data){
		$this->db->insert($table, $data);
		return $this->db->insert_id();
	}
	function batch_insert_data($table, $data){
		$this->db->insert_batch($table, $data);
		return true;
	}
	function update_data($table, $data, $where){
		$this->db->where($where);
		$this->db->update($table, $data); 
		return true;
	}
	function delete_data($table, $where){
		$this->db->where($where);
		$this->db->delete($table);
		return true;
	}
	function batch_delete_data($table, $where){
		$this->db->where_in($where);
		$this->db->delete($table);
		return $this->db->last_sql();
	}
	function get_all_data($table, $where='', $select=' * ', $join=array()){
		$this->db->select($select);
		if(!empty($where)){
			$this->db->where($where);
		}
		if( is_array($join) && count($join)){
			$this->db->join($join[0], $join[1], $join[2]);
		}
		$query = $this->db->get($table);
		return $query->result();
	}
	
	function get_data($table, $where='', $select=' * ', $join=array()){
		$this->db->select($select);
		
		if(!empty($where)){
			$this->db->where($where);
		}
		if( is_array($join) && count($join)){
			$this->db->join($join[0], $join[1], $join[2]);
		}
		$query = $this->db->get($table);
		return $query->row();
	}
	
	function get_all_distinct_data($table, $select='id', $where=''){
		$this->db->distinct();
		$this->db->select($select);
		
		if(!empty($where)){
			$this->db->where($where);
		}
		
		$query = $this->db->get($table);
		
		return $query->result();
	}
	
	function get_distinct_data($table, $select='id', $where=''){
		$this->db->distinct();
		$this->db->select($select);
		if(!empty($where)){
		$this->db->where($where);
		}
		$query = $this->db->get($table);
		return $query->row();
	}
	
	function get_total_count($table, $where='', $select=' * ', $or_where){
		$this->db->select($select);
		
		if(!empty($where)){
			$this->db->where($where);
		}
		if(!empty($or_where)){
			$this->db->or_where($or_where);
		}
		
		$query = $this->db->get($table);
		return $query->row();
	}
	
	function get_all_where_in($table, $where){
		$this->db->where_in('id', $where);
		$query = $this->db->get($table);
		
		return $query->result();
	}
	
	function get_all_data_limit($table, $where, $limit, $offset, $select=' * ', $join = array(), $distinct = false, $group_by = '', $order_by, $or_where='' ){
		if($distinct)
			$this->db->distinct();
		$this->db->select($select);
		if( is_array($join) && count($join)){
			$this->db->join($join[0], $join[1], $join[2]);
		}
		if(!empty($where)){
			$this->db->where($where);
		}
		if(!empty($or_where)){
			$this->db->or_where($or_where);
		}
		if(!empty($group_by)){
			$this->db->group_by($group_by);
		}
		if(!empty($order_by)) {
			$this->db->order_by($order_by);
		}
		if($limit)
			$this->db->limit($limit, $offset);
		$query = $this->db->get($table);
		return $query->result();
		}
	 
	function get_all_data_limitn($table, $where='', $limit, $offset, $select=' * ', $join = array(), $distinct = false, $group_by = '', $order_by, $or_where='' ){
		if($distinct)
			$this->db->distinct();
		
		$this->db->select($select);
		
		if( is_array($join) && count($join)){
			$this->db->join($join[0], $join[1], $join[2]);
		}
		if(!empty($where)){
			$this->db->where($where);
		}
		if(!empty($or_where)){
			$this->db->or_where($or_where);
		}
		if(!empty($group_by)){
			$this->db->group_by($group_by);
		}
		if(!empty($order_by)) {
			$this->db->order_by($order_by);
		}

		//$this->db->limit($limit, $offset);
		$query = $this->db->get($table);
		$query->result();
		return $query->result();
		//echo  $this->db->last_query();
	} 
	
	function get_all_products($table, $where='', $limit, $offset, $select=' * ', $join = array(), $distinct = false ){
	if($distinct)
		$this->db->distinct();
	
	$this->db->select($select);
	
	if( is_array($join) && count($join)){
		$this->db->join($join[0], $join[1], $join[2]);
	}
	if(!empty($where)){
		$this->db->where($where);
	}
	$this->db->limit($limit, $offset);
	$query = $this->db->get($table);
	return $query->result();
	}
	
	public function getRecords($dataset,$table){
	$this->db->where($dataset);
	$query = $this->db->get($table);
	return $query->result();
	}
	public function getData($table){
	$query = $this->db->get($table);
	return $query->result();
	}
	public function insert_entry($table, $data) {
	$data = $this->security->xss_clean($data);
	$query = $this->db->insert($table, $data);
	$this->db->last_query();
	$lid = $this->db->insert_id();
	if($query)
	return $lid;	
	else return 0;
	}
	public function getmaxId($table){
	$maxid = $this->db->query('SELECT MAX(id) AS `maxid` FROM '.$table)->row()->maxid;	
		return $maxid;
		
	}
	public function getnumRows($table){
	$this->db->select('count(*) as total');
	$this->db->from($table);
	$query = $this->db->get();
	$total = $query->row()->total;
	return $total;	
	}
	public function getnumRow($table,$where){
	$this->db->where($where);			
	$this->db->select('count(*) as total');
	$this->db->from($table);
	$query = $this->db->get();
	$total = $query->row()->total;
	return $total;	
	}
	public function getDataRows($table,$limit,$offset,$order_by=''){
    $this->db->from($table);
	$this->db->limit($limit,$offset);
	if($order_by) $this->db->order_by($order_by);
	$query = $this->db->get()->result();
	$this->db->last_query();
	return $query;
	}
	public function getActiveRows($table,$dataset,$limit,$offset,$order_by=''){
	$this->db->where($dataset);	
    $this->db->from($table);
	$this->db->limit($limit,$offset);
	if($order_by) $this->db->order_by($order_by);
	$query = $this->db->get()->result();
	$this->db->last_query();
	return $query;
	}
	private function xml_attribute($object, $attribute)
	{
	if(isset($object[$attribute]))
	return (string) $object[$attribute];
	}
	private function objectsIntoArray($arrObjData, $arrSkipIndices = array())
	{
	$arrData = array();
	
	// if input is object, convert into array
	if (is_object($arrObjData)) {
	$arrObjData = get_object_vars($arrObjData);
	}
	
	if (is_array($arrObjData)) {
	foreach ($arrObjData as $index => $value) {
	if (is_object($value) || is_array($value)) {
	$value = $this->objectsIntoArray($value, $arrSkipIndices); // recursive call
	}
	if (in_array($index, $arrSkipIndices)) {
	continue;
	}
	$arrData[$index] = $value;
	}
	}
	return $arrData;
	}
	public function insert_dealsapi($table, $data) {
	$data = $this->security->xss_clean($data);
	$dealdate = date("Y/m/d", strtotime($data['created']));
	$data['created'] = $data['created']." ".date("h:i:s");
	$url='http://api.popshops.com/v3/deals.xml?catalog=7l7yu9zpmx05gytj3tgjyutux&account=3vxtxn7bgi7g5csyfi5xhvab9&start_on='.$dealdate;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, FAlSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$curl_results = curl_exec($ch);
	$xml 		= simplexml_load_string($curl_results);
	$xmlObj  	= $xml->results;
	$arrXml 	= $this->objectsIntoArray($xmlObj);
	$arrData  	= $arrXml['deals']['deal'];
	$i=1;
	$data['total_count'] = $arrXml['deals']['@attributes']['count'];
	$per_page = 100;
	$total_results = $arrXml['deals']['@attributes']['count'];
	$total_pages = ceil($total_results / $per_page);
	for($i=0;$i<=$total_pages;$i++){
	
	$urlrec='http://api.popshops.com/v3/deals.xml?catalog=7l7yu9zpmx05gytj3tgjyutux&account=3vxtxn7bgi7g5csyfi5xhvab9&results_per_page='.$per_page.'&page='.$i.'&start_on='.$dealdate;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $urlrec);
	curl_setopt($ch, CURLOPT_POST, FAlSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$curl_results 	= curl_exec($ch);
	$xmlrec 		= simplexml_load_string($curl_results);
	$xmlObjrec  	= $xmlrec->results;
	$arrXmlrec 		= $this->objectsIntoArray($xmlObjrec);
	$arrDatarec  	= $arrXmlrec['deals']['deal'];
			
	foreach($arrDatarec as $val){
			
	$data['deals_name'] 	= $val['@attributes']['name'];
	$data['coupon_id'] 	 	= $val['@attributes']['id'];
	$data['merchant_id'] 	= $val['@attributes']['merchant'];
	$data['coupon_code'] 	= $val['@attributes']['code'];
	$data['deal_type'] 		= $val['@attributes']['deal_type'];
	$startdate 				= $val['@attributes']['start_on'];
	$enddate 				= $val['@attributes']['end_on'];
	$data['start_date'] 	= date("Y-m-d", strtotime($startdate));
	$data['end_date'] 		= date("Y-m-d", strtotime($enddate));
	$data['site_wide'] 		= $val['@attributes']['site_wide'];
	$data['coupon_url'] 	= $val['@attributes']['url'];
	$r = $this->getnumRow('frm_dealcoupon',array('coupon_id'=>$data['coupon_id']));
	if($r > 0){}else{
	$query = $this->db->insert($table, $data);
	}
	}
	}
	return true;
	}
	
	public function insert_productapi($table, $datas) {
	$data = $this->security->xss_clean($data);
	$url='http://api.popshops.com/v3/products.xml?catalog=7l7yu9zpmx05gytj3tgjyutux&account=3vxtxn7bgi7g5csyfi5xhvab9';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, FAlSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$curl_results = curl_exec($ch);
	$xml 		= simplexml_load_string($curl_results);
	$xmlObj  	= $xml->messagebody;
	$arrXml 	= $this->objectsIntoArray($xmlObj);
	$arrData  	= $arrXml['response']['results']['products']['product'];
	echo '<pre>';
	
	
	$per_page = 20;
	$total_results = $arrXml['response']['results']['products']['@attributes']['count'];
	$total_pages = ceil($total_results / $per_page);
	for($i=1;$i<=4;$i++){
	$urlrec='http://api.popshops.com/v3/products.xml?catalog=7l7yu9zpmx05gytj3tgjyutux&account=3vxtxn7bgi7g5csyfi5xhvab9&results_per_page='.$per_page.'&page='.$i;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $urlrec);
	curl_setopt($ch, CURLOPT_POST, FAlSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$curl_results 	= curl_exec($ch);
	$xmlrec 		= simplexml_load_string($curl_results);
	$xmlObjrec  	= $xml->messagebody;
	$arrXmlrec 		= $this->objectsIntoArray($xmlObjrec);
	$arrDatarec  	= $arrXml['response']['results']['products']['product'];
	foreach($arrDatarec as $val){
	$data['product_id'] 		= $val['@attributes']['id'];
	$data['brand'] 	 			= $val['@attributes']['brand'];
	$data['category'] 			= $val['@attributes']['category'];
	$data['image_url_large'] 	= $val['@attributes']['image_url_large'];
	$data['image_url_small']	= $offarr['@attributes']['image_url_small'];
	$data['image_url_medium']	= $offarr['@attributes']['image_url_medium'];
	$data['name'] 				= $val['@attributes']['name'];
	$data['price'] 				= $val['@attributes']['price_max'];
	$data['special_price'] 		= $val['@attributes']['price_min'];
	$data['store_description'] 	= $val['@attributes']['description'];
	$offers = $val['offers'];
	$offarr = $offers['offer'];
	$query = $this->db->insert($table, $data);
	$lid = $this->db->insert_id();
	$offerdata['product_id'] = $lid;
	$offercount = $offers['@attributes']['count'];
	for($j=0;$j<$offercount;$j++){
	$offerdata['offer_description']	= $offarr['@attributes']['description'];
	$offerdata['offer_id']			= $offarr['@attributes']['id'];
	$offerdata['image_url_large']	= $offarr['@attributes']['image_url_large'];
	$offerdata['merchant']			= $offarr['@attributes']['merchant'];
	$offerdata['name']				= $offarr['@attributes']['name'];
	$offerdata['price_merchant']	= $offarr['@attributes']['price_merchant'];
	$offerdata['url']				= $offarr['@attributes']['url'];
	$offerdata['currency_iso']		= $offarr['@attributes']['currency_iso'];
	if($offarr['@attributes']['price_retail']):
	$offerdata['price_retail']		= $offarr['@attributes']['price_retail'];
	endif;
	if($offarr['@attributes']['percent_off']):
	$offerdata['percent_off']		= $offarr['@attributes']['percent_off'];
	endif;
	$que = $this->db->insert('frm_product_offer', $offerdata);	
	}
	}
	}
	return true;
	}
	public function insert_storeapi($table, $datas){
	$url='http://api.popshops.com/v3/merchants.xml?catalog=7l7yu9zpmx05gytj3tgjyutux&account=3vxtxn7bgi7g5csyfi5xhvab9';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, FAlSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$curl_results = curl_exec($ch);
	$xml 		= simplexml_load_string($curl_results);
	$xmlObj  	= $xml->results;
	$arrXml 	= $this->objectsIntoArray($xmlObj);
	$arrData  	= $arrXml['merchants']['merchant'];
	$per_page = 100;
	$total_results = $arrXml['merchants']['@attributes']['count'];
	$total_pages = ceil($total_results / $per_page);
	for($i=1;$i<=$total_results;$i++){
	$urlrec='http://api.popshops.com/v3/merchants.xml?catalog=7l7yu9zpmx05gytj3tgjyutux&account=3vxtxn7bgi7g5csyfi5xhvab9&results_per_page='.$per_page.'&page='.$i;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $urlrec);
	curl_setopt($ch, CURLOPT_POST, FAlSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$curl_results 	= curl_exec($ch);
	$xmlrec 		= simplexml_load_string($curl_results);
	$xmlObjrec  	= $xmlrec->results;
	$arrXmlrec 		= $this->objectsIntoArray($xmlObjrec);
	$arrDatarec  	= $arrXmlrec['merchants']['merchant'];
			
	foreach($arrDatarec as $val){
	$data['store_id'] 		= $val['@attributes']['id'];
	$data['category'] 	 	= $val['@attributes']['category'];
	$data['deal_count'] 	= $val['@attributes']['deal_count'];
	$data['logo_url'] 		= $val['@attributes']['logo_url'];
	$data['merchant_type'] 	= $val['@attributes']['merchant_type'];
	$data['storename']		= $val['@attributes']['name'];
	$data['network'] 		= $val['@attributes']['network'];
	if($val['@attributes']['network_merchant_id']):
	$data['network_merchant_id'] 	= $val['@attributes']['network_merchant_id'];
	endif;
	$data['product_count'] 	= $val['@attributes']['product_count'];
	$data['site_url'] 		= $val['@attributes']['site_url'];
	$data['url'] 			= $val['@attributes']['url'];
	$data['country'] 		= $val['@attributes']['country'];
	$r = $this->getnumRow('frm_stores',array('store_id'=>$data['store_id']));
	if($r > 0){}else{
	$query = $this->db->insert($table, $data);
	}
	}
	}
	return true;
	}
	
	public function insert_dealtypeapi($table, $datas){
	$url='http://api.popshops.com/v3/deal_types.xml?catalog=7l7yu9zpmx05gytj3tgjyutux&account=3vxtxn7bgi7g5csyfi5xhvab9';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, FAlSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$curl_results = curl_exec($ch);
	$xml 		= simplexml_load_string($curl_results);
	$xmlObj  	= $xml->results;
	$arrXml 	= $this->objectsIntoArray($xmlObj);
	$arrData  	= $arrXml['deal_types']['deal_type'];
	$per_page = 100;
	$total_results = $arrXml['deal_types']['@attributes']['count'];
	$total_pages = ceil($total_results / $per_page);	
	foreach($arrData as $val):
	$data['deal_type_id']		=	$val['@attributes']['id'];
	$data['dealtype']			=	$val['@attributes']['name'];
	$data['deal_count']			=	$val['@attributes']['deal_count'];
	$r = $this->getnumRow('frm_dealtype',array('deal_type_id'=>$data['deal_type_id']));
	if($r > 0){}else{
	$query = $this->db->insert($table, $data);
	}
	endforeach;
	return true;
	}
	
	public function apimerchanttype($table, $datas){
	$url='http://api.popshops.com/v3/merchant_types.xml?catalog=7l7yu9zpmx05gytj3tgjyutux&account=3vxtxn7bgi7g5csyfi5xhvab9';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, FAlSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$curl_results = curl_exec($ch);
	$xml 		= simplexml_load_string($curl_results);
	$xmlObj  	= $xml->results;
	$arrXml 	= $this->objectsIntoArray($xmlObj);
	$arrData  	= $arrXml['merchant_types']['merchant_type'];
	$per_page = 100;
	
	$total_results = $arrXml['merchant_types']['@attributes']['count'];
	$total_pages = ceil($total_results / $per_page);
	foreach($arrData as $val):
	$data['type_id']				=	$val['@attributes']['id'];
	$data['merchant_type']			=	$val['@attributes']['name'];
	$data['merchant_count']			=	$val['@attributes']['merchant_count'];
	$r = $this->getnumRow('frm_merchanttype',array('type_id'=>$data['type_id']));
	if($r > 0){}else{
	$query = $this->db->insert($table, $data);
	}
	endforeach;
	return true;
	}
	public function cdel($id,$column,$table){
	$this->db->where($column, $id);
	$res = $this->db->delete($table);
	if($res)
	return true; 	
	}
	public function cupdate($data,$id,$column,$table){
	$data = $this->security->xss_clean($data);	
	$this->db->where($column, $id);
	$res = $this->db->update($table, $data);
	 $this->db->last_query();
	if($res)
	return true;	
	}
	public function getRecord($dataset,$table){
	$this->db->where($dataset);
	$query = $this->db->get($table);
	$query->row();
	$this->db->last_query();
	
	return $query->row();
}
	public function getColumns($dataset,$table,$selectCol){
	$this->db->select($selectCol, false);
	$this->db->where($dataset);
	$query = $this->db->get($table);
	$this->db->last_query();
	return $query->result();
	}
	public function getForum(){
	$selectCol="n.nodeid, n.title as title,n.description as des,nd.title as ctitle";	
	$this->db->select($selectCol, false);
	$this->db->from('frm_node as nd');
	$this->db->join('frm_node as n', 'nd.nodeid = n.parentid AND nd.parentid=2');
	$this->db->order_by("n.nodeid","desc");
	$query = $this->db->get()->result();
	$this->db->last_query();
	return $query;		
	}
	public function getRoles(){
		$this->load->library('session');
		$where = "ur.userid = ".$this->session->userdata('userid')." ORDER BY ur.id ASC";
		$join = array('frm_userrole ur', 'r.id=ur.roleid', 'LEFT');
		$rolesObj = $this->get_all_data('frm_role r', $where, ' name ', $join );
		foreach($rolesObj as $role)
			$roles[] = $role->name;
		return $roles;
	}
    public function getFromRaw($sql){
        $query = $this->db->query($sql);
        return $query->result();
    }
	public function countViews($dataset){
		$selectCol = 'view';
		$this->db->select($selectCol, false);
		$this->db->from('frm_products');
		$this->db->where($dataset);
		$query = $this->db->get()->row();
		$this->db->last_query();
		return $query;
	}
	
	function getpropertybytype($type){ 
		$this->db->select('*');
		$this->db->from('property');
		$this->db->where(array('prop_for'=>$type,'prop_status'=>1));
		$rs=$this->db->get();
		return $rs->result();
	}
	function getuserdetail($dealer_id){ 
		$this->db->select('*');
		$this->db->from('users');
		$this->db->where('id',$dealer_id);
		$rs=$this->db->get();
		return $rs->result();
	}
	function getproimage($pro_id){ 
		$this->db->select('*');
		$array = array('pro_id' => $pro_id, 'baseimage' => 1, 'img_status' => 1);

		$this->db->from('propertyimg');
		$this->db->where($array);
		$rs=$this->db->get();
		return $rs->result();
	}
	function user_search($data)	
	{
		$name=$data['keyword'];
		$condition= '';
		if(!empty($name))
		{
			$condition= " and (first_name like '%$name%')";
		}
		$sql = "select *  from `users` WHERE 1=1 $condition";
		$query = $this->db->query($sql);
		print_r($this->db->last_query());
		return $query->result();
	}

}


?>