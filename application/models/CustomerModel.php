<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CustomerModel extends CI_Model
{

    // Insert new customer
    public function insert_customer($data)
    {
        return $this->db->insert('customers', $data);
    }

    // Update existing customer
    public function update_customer($id, $data)
    {
        return $this->db->where('id', $id)->update('customers', $data);
    }

    // Delete customer by ID
    public function delete_customer($id)
    {
        return $this->db->delete('customers', ['id' => $id]);
    }

    // Get single customer by ID
    public function get_customer_by_id($id)
    {
        return $this->db->get_where('customers', ['id' => $id])->row();
    }

    // Get paginated and filtered customers
    public function get_customers($limit, $offset, $search = '')
    {
        if (!empty($search)) {
            $this->db->like('name', $search);
            $this->db->or_like('contact', $search);
        }
        $this->db->order_by('id', 'DESC');
        return $this->db->get('customers', $limit, $offset)->result();
    }

    // Count filtered customers for pagination
    public function count_customers($search = '')
    {
        if (!empty($search)) {
            $this->db->like('name', $search);
            $this->db->or_like('contact', $search);
        }
        return $this->db->count_all_results('customers');
    }

    // Get all customers (for export)
    public function get_all_customers()
    {
        return $this->db->order_by('id', 'DESC')->get('customers')->result();
    }
}
