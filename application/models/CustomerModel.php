<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerModel extends CI_Model {

    public function insert_customer($data) {
        return $this->db->insert('customers', $data);
    }


    public function update_customer($id, $data) {
        return $this->db->where('id', (int)$id)->update('customers', $data);
    }

    public function delete_customer($id) {
        return $this->db->where('id', (int)$id)->delete('customers');
    }

    public function get_customers($limit = null, $start = null, $search = null, $filter = null, $forExport = false) {
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('contact', $search);
            $this->db->group_end();
        }

       

        $this->db->order_by('id', 'DESC');
        return $this->db->get('customers')->result();
    }

    public function count_customers($search = null, $filter = null) {
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('name', $search);
            $this->db->or_like('contact', $search);
            $this->db->group_end();
        }

        if (!empty($filter)) {
            $this->db->where('id_proof_type', $filter);
        }

        return $this->db->count_all_results('customers');
    }
}