<?php
class Category_model extends CI_Model {

    public function get_all() {
        return $this->db->get('categories')->result();
    }

    public function insert_category($data) {
        return $this->db->insert('categories', $data);
    }
}
