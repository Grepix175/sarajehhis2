<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Corporate_model extends CI_Model {

	var $table = 'hms_corporate';
	var $column = array('hms_corporate.corporate_id','hms_corporate.corporate_name','hms_corporate.corporate_status','hms_corporate.created_date'); 
	var $order = array('corporate_id' => 'desc'); 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
     
}
?>