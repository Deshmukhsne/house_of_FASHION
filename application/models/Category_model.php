<?php
class Category_model extends CI_Model {

    public function get_all() {
        return $this->db->get('categories')->result();
    }

    public function insert_category($data) {
        return $this->db->insert('categories', $data);
    }
    public function get_all_categories() {
    $query = $this->db->get('categories'); // use your table name
    return $query->result();
}

}
