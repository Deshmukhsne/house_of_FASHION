<?php
class Product_model extends CI_Model {

    public function get_all_products() {
        return $this->db->get('products')->result();
    }

    public function insert_product($data) {
        return $this->db->insert('products', $data);
    }

    public function get_product_by_id($id) {
        return $this->db->get_where('products', ['id' => $id])->row();
    }

    public function update_product($id, $data) {
        return $this->db->where('id', $id)->update('products', $data);
    }

    public function delete_product($id) {
        return $this->db->where('id', $id)->delete('products');
    }
}
