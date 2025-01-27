<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ipd_particular_summary_report_model extends CI_Model {

    var $table = 'hms_ipd_patient_to_charge';
    var $column = array('hms_ipd_booking.ipd_no','hms_ipd_booking.booking_date', 'hms_patient.patient_name','hms_ipd_patient_to_charge.particulars','hms_doctors.doctor_name','hms_ipd_booking.total_amount','hms_ipd_booking.discount','hms_ipd_booking.net_amount','hms_ipd_booking.paid_amount','hms_ipd_booking.balance','hms_ipd_booking.booking_status','hms_ipd_booking.modified_date');  
    var $order = array('hms_ipd_patient_to_charge.ipd_id' => 'desc');
    //,'hms_department.department'
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); 
    }

    private function _get_datatables_query()
    {
        
        $users_data = $this->session->userdata('auth_users');
        $billing_collection_search_data = $this->session->userdata('ipd_particular_summary_search_data');
        $this->db->select("hms_patient.patient_name,hms_patient.patient_code,hms_ipd_booking.admission_date as booking_date,hms_ipd_booking.ipd_no as booking_code,hms_ipd_patient_to_charge.net_price as net_amount,hms_ipd_patient_to_charge.net_price as total_amount, hms_ipd_patient_to_charge.net_price as debit,hms_ipd_patient_to_charge.created_date,hms_ipd_patient_to_charge.particular as particular_name,hms_ipd_patient_to_charge.start_date,hms_ipd_patient_to_charge.quantity");
        
        /*(select GROUP_CONCAT(hms_ipd_patient_to_charge.particular) FROM hms_ipd_patient_to_charge where hms_ipd_patient_to_charge.ipd_id = hms_ipd_booking.id AND (hms_ipd_patient_to_charge.type=3 OR hms_ipd_patient_to_charge.type=5) AND hms_ipd_patient_to_charge.branch_id=".$users_data['parent_id'].") as particular_name*/
        
        
            $this->db->join('hms_ipd_booking','hms_ipd_booking.id=hms_ipd_patient_to_charge.ipd_id','left');
            $this->db->join('hms_patient','hms_patient.id=hms_ipd_booking.patient_id','left'); 
           $this->db->where('hms_ipd_booking.branch_id',$users_data['parent_id']);   
            if(!empty($billing_collection_search_data['start_date']))
            {
               $start_date=date('Y-m-d',strtotime($billing_collection_search_data['start_date']))." 00:00:00";

               $this->db->where('hms_ipd_booking.admission_date >= "'.$start_date.'"');
            }

            if(!empty($billing_collection_search_data['end_date']))
            {
                $end_date=date('Y-m-d',strtotime($billing_collection_search_data['end_date']))." 23:59:59";
                $this->db->where('hms_ipd_booking.admission_date <= "'.$end_date.'"');
            }
            
            if(isset($billing_collection_search_data['particulars']) && !empty($billing_collection_search_data['particulars'])
                )
            {
               $this->db->where('hms_ipd_patient_to_charge.particular_id',$billing_collection_search_data["particulars"]);
            }
            
            if(isset($billing_collection_search_data['particulars_name']) && !empty($billing_collection_search_data['particulars_name'])
                )
            {
               $this->db->where('hms_ipd_patient_to_charge.particulars LIKE "'.$billing_collection_search_data["particulars_name"].'%"');
            }
            
            if(isset($billing_collection_search_data['charge_type']) && !empty($billing_collection_search_data['charge_type'])
                )
            {
               $this->db->where('hms_ipd_patient_to_charge.particular LIKE "'.$billing_collection_search_data["charge_type"].'%"');
            }
            
            
            
            
         
            
            $this->db->where('hms_ipd_booking.is_deleted','0');
            $this->db->where('hms_ipd_booking.branch_id',$users_data['parent_id']);
            $this->db->where('(hms_ipd_patient_to_charge.type=3 OR hms_ipd_patient_to_charge.type=5)'); 
            if(!empty($get["order_by"]) && $get['order_by']=='ASC')
            {
                $this->db->order_by('hms_ipd_patient_to_charge.ipd_id','ASC');
            }
            else
            {
                $this->db->order_by('hms_ipd_patient_to_charge.ipd_id','DESC');
            }
            $this->db->group_by('hms_ipd_patient_to_charge.ipd_id');
            $this->db->from('hms_ipd_patient_to_charge');
            

        $i = 0;
       //$this->db->group_by('hms_ipd_booking.id');
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

    function get_datatables($branch_id='')
    {
        $this->_get_datatables_query($branch_id);
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get(); 
        //echo $this->db->last_query();die;
        return $query->result();
    }

    function search_report_data()
    {
        $users_data = $this->session->userdata('auth_users');
        $billing_collection_search_data = $this->session->userdata('ipd_particular_summary_search_data'); 
        
        $this->db->select("hms_patient.patient_name,hms_patient.patient_code,hms_ipd_booking.admission_date as booking_date,hms_ipd_booking.ipd_no as booking_code,hms_ipd_patient_to_charge.net_price as net_amount,hms_ipd_patient_to_charge.net_price as total_amount, hms_ipd_patient_to_charge.net_price as debit,hms_ipd_patient_to_charge.created_date,hms_ipd_patient_to_charge.particular as particular_name,hms_ipd_patient_to_charge.start_date,hms_ipd_patient_to_charge.quantity");
        
        /*(select GROUP_CONCAT(hms_ipd_patient_to_charge.particular) FROM hms_ipd_patient_to_charge where hms_ipd_patient_to_charge.ipd_id = hms_ipd_booking.id AND (hms_ipd_patient_to_charge.type=3 OR hms_ipd_patient_to_charge.type=5) AND hms_ipd_patient_to_charge.branch_id=".$users_data['parent_id'].") as particular_name*/
        
        
            $this->db->join('hms_ipd_booking','hms_ipd_booking.id=hms_ipd_patient_to_charge.ipd_id','left');
            $this->db->join('hms_patient','hms_patient.id=hms_ipd_booking.patient_id','left'); 
           $this->db->where('hms_ipd_booking.branch_id',$users_data['parent_id']);   
            if(!empty($billing_collection_search_data['start_date']))
            {
               $start_date=date('Y-m-d',strtotime($billing_collection_search_data['start_date']))." 00:00:00";

               $this->db->where('hms_ipd_booking.admission_date >= "'.$start_date.'"');
            }

            if(!empty($billing_collection_search_data['end_date']))
            {
                $end_date=date('Y-m-d',strtotime($billing_collection_search_data['end_date']))." 23:59:59";
                $this->db->where('hms_ipd_booking.admission_date <= "'.$end_date.'"');
            }
            
            if(isset($billing_collection_search_data['particulars']) && !empty($billing_collection_search_data['particulars'])
                )
            {
               $this->db->where('hms_ipd_patient_to_charge.particular_id',$billing_collection_search_data["particulars"]);
            }
            
            if(isset($billing_collection_search_data['particulars_name']) && !empty($billing_collection_search_data['particulars_name'])
                )
            {
               $this->db->where('hms_ipd_patient_to_charge.particulars LIKE "'.$billing_collection_search_data["particulars_name"].'%"');
            }
            
            if(isset($billing_collection_search_data['charge_type']) && !empty($billing_collection_search_data['charge_type'])
                )
            {
               $this->db->where('hms_ipd_patient_to_charge.particular LIKE "'.$billing_collection_search_data["charge_type"].'%"');
            }
         
            
            $this->db->where('hms_ipd_booking.is_deleted','0');
            $this->db->where('hms_ipd_booking.branch_id',$users_data['parent_id']);
            $this->db->where('(hms_ipd_patient_to_charge.type=3 OR hms_ipd_patient_to_charge.type=5)'); 
            if(!empty($get["order_by"]) && $get['order_by']=='ASC')
            {
                $this->db->order_by('hms_ipd_patient_to_charge.ipd_id','ASC');
            }
            else
            {
                $this->db->order_by('hms_ipd_patient_to_charge.ipd_id','DESC');
            }
            $this->db->group_by('hms_ipd_patient_to_charge.ipd_id');
            $this->db->from('hms_ipd_patient_to_charge');
            $new_self_billing['self_bill_coll'] = $this->db->get()->result();  
            //echo $this->db->last_query();die;

            return $new_self_billing;
        //echo $this->db->last_query();die;
        //return $result;
        
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
    
    public function religion_list()
    {
        $user_data = $this->session->userdata('auth_users');
        $this->db->select('*');
        $this->db->where('branch_id',$user_data['parent_id']);
        $this->db->where('status',1); 
        $this->db->where('is_deleted',0); 
        $this->db->order_by('religion','ASC'); 
        $query = $this->db->get('path_religion');
        return $query->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('path_religion.*');
        $this->db->from('path_religion'); 
        $this->db->where('path_religion.id',$id);
        $this->db->where('path_religion.is_deleted','0');
        $query = $this->db->get(); 
        return $query->row_array();
    }
    
    public function save()
    {
        $user_data = $this->session->userdata('auth_users');
        $post = $this->input->post();  
        $data = array( 
                    'branch_id'=>$user_data['parent_id'],
                    'religion'=>$post['religion'],
                    'status'=>$post['status'],
                    'ip_address'=>$_SERVER['REMOTE_ADDR']
                 );
        if(!empty($post['data_id']) && $post['data_id']>0)
        {    
            $this->db->set('modified_by',$user_data['id']);
            $this->db->set('modified_date',date('Y-m-d H:i:s'));
            $this->db->where('id',$post['data_id']);
            $this->db->update('path_religion',$data);  
        }
        else{    
            $this->db->set('created_by',$user_data['id']);
            $this->db->set('created_date',date('Y-m-d H:i:s'));
            $this->db->insert('path_religion',$data);               
        }   
    }

    public function delete($id="")
    {
        if(!empty($id) && $id>0)
        {

            $user_data = $this->session->userdata('auth_users');
            $this->db->set('is_deleted',1);
            $this->db->set('deleted_by',$user_data['id']);
            $this->db->set('deleted_date',date('Y-m-d H:i:s'));
            $this->db->where('id',$id);
            $this->db->update('path_religion');
            //echo $this->db->last_query();die;
        } 
    }

    public function deleteall($ids=array())
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
            $branch_ids = implode(',', $id_list);
            $user_data = $this->session->userdata('auth_users');
            $this->db->set('is_deleted',1);
            $this->db->set('deleted_by',$user_data['id']);
            $this->db->set('deleted_date',date('Y-m-d H:i:s'));
            $this->db->where('id IN ('.$branch_ids.')');
            $this->db->update('path_religion');
            //echo $this->db->last_query();die;
        } 
    }
    public function get_billing_collection_report_details($get=array())
    {
        

        if(!empty($get))
        {
            $users_data = $this->session->userdata('auth_users'); 
            $sub_branch_details = $this->session->userdata('sub_branches_data');
            if(!empty($sub_branch_details))
            {
                $child_ids_arr = array_column($sub_branch_details,'id');
                $child_ids = implode(',',$child_ids_arr);
            } 
            $this->db->select("path_expenses.*,path_expenses_category.exp_category"); 
            $this->db->from('path_expenses'); 
            $this->db->join("path_expenses_category","path_expenses.paid_to_id=path_expenses_category.id",'left');
            if(!empty($get['start_date']))
            {
              $this->db->where('path_expenses.expenses_date >= "'.$get['start_date'].'"');
            }

            if(!empty($get['end_date']))
            {
              $this->db->where('path_expenses.expenses_date<= "'.$get['end_date'].'"');   
            }

            if(!empty($get['branch_id']))
            {
              if(is_numeric($get['branch_id']) && $get['branch_id']>0)
              {
                 $this->db->where('path_expenses.branch_id',$get['branch_id']);  
              } 
              else if($get['branch_id']=='all') 
              {
                 $this->db->where('path_expenses.branch_id IN ('.$child_ids.')');  
              }  
            } 
            $query = $this->db->get();
            $result = $query->result();  
            return $result;
        } 
    }

}
?>