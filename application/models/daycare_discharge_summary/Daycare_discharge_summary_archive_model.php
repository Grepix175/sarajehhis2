<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daycare_discharge_summary_archive_model extends CI_Model {

    var $table = 'hms_daycare_discharge_summery';
    var $column = array('hms_daycare_discharge_summery.id','hms_daycare_discharge_summery.patient_id', 'hms_daycare_discharge_summery.status','hms_daycare_discharge_summery.created_date');   
    var $order = array('id' => 'desc');

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $users_data = $this->session->userdata("auth_users");
        $this->db->select("hms_daycare_discharge_summery.*,hms_day_care_booking.booking_code,hms_patient.patient_name,hms_patient.age_m,hms_patient.age_y,hms_patient.age_d,hms_patient.patient_code, hms_patient.age_y,hms_patient.gender,hms_patient.mobile_no,hms_patient.address");

        $this->db->join('hms_day_care_booking','hms_day_care_booking.id=hms_daycare_discharge_summery.daycare_id','left');
        $this->db->join('hms_patient','hms_patient.id=hms_day_care_booking.patient_id','left');
        $this->db->from($this->table); 
        $this->db->where('hms_daycare_discharge_summery.is_deleted','1');
        $this->db->where('hms_daycare_discharge_summery.branch_id',$users_data['parent_id']);
        
        $i = 0;
    
        foreach ($this->column as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND. 
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column) - 1 == $i) //last loop+
                    $this->db->group_end(); //close bracket
            }
            $column[$i] = $item; // set column array variable to order processing
            $i++;
        }
        
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get(); 
        //echo $this->db->last_query();die;
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    public function restore($id="")
    {
        if(!empty($id) && $id>0)
        {
            $user_data = $this->session->userdata('auth_users');
            $this->db->set('is_deleted',0);
            $this->db->set('deleted_by',$user_data['id']);
            $this->db->set('deleted_date',date('Y-m-d H:i:s'));
            $this->db->where('id',$id);
            $this->db->update('hms_daycare_discharge_summery');
        } 
    }

    public function restoreall($ids=array())
    {
        if(!empty($ids))
        {
            $id_list = [];
            foreach($ids as $id)
            {
                if(!empty($id) && $id>0)
                {
                  $id_list[]  = $id;
                } 
            }
            $emp_ids = implode(',', $id_list);
            $user_data = $this->session->userdata('auth_users');
            $this->db->set('is_deleted',0);
            $this->db->set('deleted_by',$user_data['id']);
            $this->db->set('deleted_date',date('Y-m-d H:i:s'));
            $this->db->where('id IN ('.$emp_ids.')');
            $this->db->update('hms_daycare_discharge_summery');
        } 
    }

    public function trash($id="")
    {
   //   if(!empty($id) && $id>0)
   //   {  
            // $this->db->where('id',$id);
            // $this->db->delete('hms_discharge_summery');
   //   } 
        if(!empty($id) && $id>0)
        {

            $user_data = $this->session->userdata('auth_users');
            $this->db->set('is_deleted',2);
            $this->db->set('deleted_by',$user_data['id']);
            $this->db->set('deleted_date',date('Y-m-d H:i:s'));
            $this->db->where('id',$id);
            $this->db->update('hms_daycare_discharge_summery');
            //echo $this->db->last_query();die;
        } 
    }

    public function trashall($ids=array())
    {
   //   if(!empty($ids))
   //   {
   //       $id_list = [];
   //       foreach($ids as $id)
   //       {
   //           if(!empty($id) && $id>0)
   //           {
   //                $id_list[]  = $id;
   //           } 
   //       }
   //       $branch_ids = implode(',', $id_list); 
            // $this->db->where('id IN ('.$branch_ids.')');
            // $this->db->delete('hms_discharge_summery');
   //   } 
        if(!empty($ids))
        {
            $id_list = [];
            foreach($ids as $id)
            {
                if(!empty($id) && $id>0)
                {
                  $id_list[]  = $id;
                } 
            }
            $branch_ids = implode(',', $id_list); 
            $user_data = $this->session->userdata('auth_users');
            $this->db->set('is_deleted',2);
            $this->db->set('deleted_by',$user_data['id']);
            $this->db->set('deleted_date',date('Y-m-d H:i:s'));
            $this->db->where('id IN ('.$branch_ids.')');
            $this->db->update('hms_daycare_discharge_summery');
        } 
    }
 

}
?>