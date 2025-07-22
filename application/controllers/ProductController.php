<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
    }

    public function index() {
        $data['products'] = $this->Product_model->get_all_products();
        $this->load->view('product_inventory', $data);
    }

    public function add_product() {
        $data = [
            'name' => $this->input->post('name'),
            'category' => $this->input->post('category'),
            'stock' => $this->input->post('stock'),
            'status' => $this->input->post('status')
        ];
        $this->Product_model->insert_product($data);
        redirect('ProductController');
    }

    public function delete_product($id) {
        $this->Product_model->delete_product($id);
        redirect('ProductController');
    }

    public function edit_product($id) {
        $product = $this->Product_model->get_product_by_id($id);
        echo json_encode($product); // For AJAX
    }

    public function update_product() {
        $id = $this->input->post('id');
        $data = [
            'name' => $this->input->post('name'),
            'category' => $this->input->post('category'),
            'stock' => $this->input->post('stock'),
            'status' => $this->input->post('status')
        ];
        $this->Product_model->update_product($id, $data);
        redirect('ProductController');
    }
}
