<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrdersModel extends CI_Model {
    // Get category by ID
    public function get_category_by_id($category_id) {
        return $this->db->get_where('categories', ['id' => $category_id])->row_array();
    }

    // Get product by ID with category name
    public function get_product_with_category($product_id) {
        $this->db->select('products.*, categories.name as category_name');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id = products.category_id', 'left');
        // $this->db->join('orders', 'orders.productId = products.id', 'left');
        $this->db->where('products.id', $product_id);

        return $this->db->get()->row_array();
    }

    // Get all rental orders with joined customer & product details
    public function get_all_orders_with_details() {
        $this->db->select('orders.*, customers.name AS customerName, products.name AS productName, products.price AS productPrice, products.category_id, products.image');
        $this->db->from('orders');
        $this->db->join('customers', 'customers.id = orders.customerId', 'left');
        $this->db->join('products', 'products.id = orders.productId', 'left');
        $query = $this->db->get();
        return $query->result(); // returns array of objects
    }


    // Insert a new order
    public function insert_order($data) {
        return $this->db->insert('orders', $data);
    }

    // Get customer by ID
    public function get_customer_by_id($id) {
        return $this->db->get_where('customers', ['id' => $id])->row_array();
    }

    // Get customers by name (autocomplete)
    public function get_customers_by_name($term) {
        $this->db->like('name', $term);
        $query = $this->db->get('customers');
        return $query->result_array();
    }

    // Get product by ID
    public function get_product_by_id($product_id) {
    $this->db->select('products.*, categories.name as category_name');
        $this->db->from('products');
        $this->db->join('categories', 'categories.id = products.category_id', 'left');
        // $this->db->join('orders', 'orders.productId = products.id', 'left');
        $this->db->where('products.id', $product_id);

        return $this->db->get()->row_array();    }

    // Get order by ID
    public function get_order_by_id($id) {
        return $this->db->get_where('orders', ['order_id' => $id])->row_array();
    }

// Update order
public function update_order($id, $data) {
    $this->db->where('order_id', $id);
    return $this->db->update('orders', $data);
}

// Delete order
public function delete_order($id) {
    $this->db->where('order_id', $id);
    return $this->db->delete('orders');
}

}
