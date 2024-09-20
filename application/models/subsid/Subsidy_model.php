<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subsidy_model extends CI_Model {

	var $table = 'hms_subsidy';
	var $column = array('hms_subsidy.subsidy_id','hms_subsidy.subsidy_name','hms_subsidy.subsidy_status','hms_subsidy.created_date'); 
	var $order = array('subsidy_id' => 'desc'); 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
     
}
?>