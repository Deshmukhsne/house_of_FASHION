<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProductController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Category_model');
    }

   public function index() {
    $this->load->model('Category_model');
    $this->load->model('Product_model');

    $data['categories'] = $this->Category_model->get_all_categories(); // ✅ Fetch categories
    $data['products'] = $this->Product_model->get_all_products(); // Optional

    $this->load->view('Admin/product_inventory', $data);
 // ✅ Make sure view file exists
}


public function add_product() {
    $config['upload_path'] = './uploads/';
    $config['allowed_types'] = 'jpg|jpeg|png|gif';
    $config['encrypt_name'] = TRUE;

    $this->load->library('upload', $config);
    $imagePath = null;

    if ($this->upload->do_upload('image')) {
        $data = $this->upload->data();
        $imagePath = 'uploads/' . $data['file_name'];
    }

    $data = [
        'name' => $this->input->post('name'),
        'category_id' => $this->input->post('category_id'),
        'stock' => $this->input->post('stock'),
        'status' => $this->input->post('status'),
        'image' => $imagePath
    ];

    $this->Product_model->insert_product($data);
    redirect('ProductController');
}


    public function delete_product($id) {
        $this->Product_model->delete_product($id);
        redirect('ProductController');
    }

    public function add_category() {
        $name = $this->input->post('name');
        $this->Category_model->insert_category(['name' => $name]);
        redirect('ProductController');
    }
}

