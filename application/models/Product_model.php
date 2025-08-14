<?php
class Product_model extends CI_Model
{
    
    public function get_all_products()
    {
        return $this->db->get('products')->result_array();
    }

    // Fetch all products with their category name, price, and stock
    public function get_products_with_category()
    {
        return $this->db
            ->select('products.id, products.name, products.category_id, products.price, products.stock, products.status, categories.name as category_name')
            ->from('products')
            ->join('categories', 'products.category_id = categories.id', 'left')
            ->order_by('products.name', 'ASC')
            ->get()->result_array();
    }

    // Fetch all categories
    public function get_all_categories()
    {
        return $this->db->order_by('name', 'ASC')->get('categories')->result_array();
    }

    // Fetch a single product by ID with category name
    public function get_product_by_id($id)
    {
        $this->db->select('products.id, products.name, products.category_id, products.price, products.status, categories.name as category_name');
        $this->db->from('products');
        $this->db->join('categories', 'products.category_id = categories.id', 'left');
        $this->db->where('products.id', $id);
        return $this->db->get()->row_array();
    }

    // Fetch products by category for AJAX
    public function get_products_by_category($category_id)
    {
        return $this->db->select('id, name, price, stock, status')
            ->from('products')
            ->where('category_id', $category_id)
            ->order_by('name', 'ASC')
            ->get()->result_array();
    }
   

}
