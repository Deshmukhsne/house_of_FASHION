<?php
class Product_model extends CI_Model {

     public function get_all_with_category() {
        $this->db->select('products.*, categories.name as category_name');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id = products.category_id');
        return $this->db->get()->result();
    }

    public function insert_product($data) {
    return $this->db->insert('products', $data);
    }
    

    public function delete_product($id) {
        return $this->db->where('id', $id)->delete('products');
    }
     public function get_all_products() {
    $this->db->select('products.*, categories.name as category_name');
    $this->db->from('products');
    $this->db->join('categories', 'products.category_id = categories.id');
    $query = $this->db->get();
    return $query->result();
}

}
