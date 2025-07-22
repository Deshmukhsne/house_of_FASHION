<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Model extends CI_Model {

      public function insert_staff($data)
    {
        return $this->db->insert('users', $data);
    }

    public function get_all_staffs($search = null, $role = null)
    {
        if ($search) {
            $this->db->like('name', $search);
        }
        if ($role) {
            $this->db->where('role', $role);
        }
        return $this->db->get('users')->result();
    }

    public function get_staff_by_id($id)
    {
        return $this->db->get_where('users', ['id' => $id])->row();
    }

    public function update_staff($id, $data)
    {
        return $this->db->where('id', $id)->update('users', $data);
    }

    public function delete_staff($id)
    {
        return $this->db->delete('users', ['id' => $id]);
    }

    public function get_by_username($username)
    {
        return $this->db->get_where('users', ['username' => $username])->row();
    }
}
