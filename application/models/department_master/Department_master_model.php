<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Department_master_model extends CI_Model {

	var $table = 'hms_department_master';
	var $column = array('hms_department_master.department_id','hms_department_master.department_name','hms_department_master.department_status','hms_department_master.created_date'); 
	var $order = array('department_id' => 'desc'); 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	


     
}
?>