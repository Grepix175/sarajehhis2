<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Side_effect_model extends CI_Model
{

    var $table = 'hms_side_effect';
    var $column = array('hms_side_effect.id', 'hms_side_effect.side_effect_name', 'hms_side_effect.created_date');
    var $order = array('id' => 'desc');

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $this->db->select("hms_side_effect.*");
        $this->db->from($this->table);
        $this->db->where('hms_side_effect.is_deleted', '0');

        $i = 0;
        foreach ($this->column as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $column[$i] = $item;
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
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

    public function get_by_id($id)
    {
        $this->db->select('hms_side_effect.*');
        $this->db->from($this->table);
        $this->db->where('hms_side_effect.id', $id);
        $this->db->where('hms_side_effect.is_deleted', '0');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function save()
    {
        $post = $this->input->post();
        $data = array(
            'side_effect_name' => $post['side_effect_name'],
        );

        if (!empty($post['data_id']) && $post['data_id'] > 0) {
            $this->db->set('modified_date', date('Y-m-d H:i:s'));
            $this->db->where('id', $post['data_id']);
            $this->db->update('hms_side_effect', $data);
        } else {
            $this->db->set('created_date', date('Y-m-d H:i:s'));
            $this->db->insert('hms_side_effect', $data);
        }
    }

    public function delete($id = "")
    {
        if (!empty($id) && $id > 0) {
            $this->db->set('is_deleted', 1);
            $this->db->where('id', $id);
            $this->db->update('hms_side_effect');
        }
    }

    public function deleteall($ids = array())
    {
        if (!empty($ids)) {
            $id_list = [];
            foreach ($ids as $id) {
                if (!empty($id) && $id > 0) {
                    $id_list[] = $id;
                }
            }
            $side_effect_ids = implode(',', $id_list);
            $this->db->set('is_deleted', 1);
            $this->db->where('id IN (' . $side_effect_ids . ')');
            $this->db->update('hms_side_effect');
        }
    }
}
