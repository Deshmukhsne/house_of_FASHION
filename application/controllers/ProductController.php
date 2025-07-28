<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ProductController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Category_model');
    }

    public function index()
    {
        $this->load->model('Category_model');
        $this->load->model('Product_model');

        $data['categories'] = $this->Category_model->get_all_categories(); // ✅ Fetch categories
        $data['products'] = $this->Product_model->get_all_products(); // Optional

        $this->load->view('Admin/product_inventory', $data);
        // ✅ Make sure view file exists
    }

    public function add_product()
    {
        // Upload
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
            'price' => $this->input->post('price'),
            'category_id' => $this->input->post('category_id'),
            'stock' => $this->input->post('stock'),
            'status' => $this->input->post('status'),
            'image' => $imagePath
        ];

        $this->Product_model->insert_product($data);

        $this->session->set_flashdata('success', 'Product added successfully!');
        redirect('ProductController');
    }
    public function delete_product($id)
    {
        $this->Product_model->delete_product($id);
        redirect('ProductController');
    }

    public function add_category()
    {
        $name = $this->input->post('name');
        $this->Category_model->insert_category(['name' => $name]);

        $this->session->set_flashdata('success', 'Category added successfully!');
        redirect('ProductController');
    }
    public function edit_product($id)
    {
        $this->load->model('Category_model');
        $data['categories'] = $this->Category_model->get_all_categories();
        $data['product'] = $this->Product_model->get_product_by_id($id);

        if (empty($data['product'])) {
            show_404();
        }

        $this->load->view('Admin/edit_product', $data);
    }

    public function update_product()
    {
        $id = $this->input->post('product_id');
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['encrypt_name'] = TRUE;

        $this->load->library('upload', $config);

        $imagePath = $this->input->post('existing_image'); // fallback to existing image

        if (!empty($_FILES['image']['name']) && $this->upload->do_upload('image')) {
            $data = $this->upload->data();
            $imagePath = 'uploads/' . $data['file_name'];
        }

        $data = [
            'name' => $this->input->post('name'),
            'price' => $this->input->post('price'),
            'category_id' => $this->input->post('category_id'),
            'stock' => $this->input->post('stock'),
            'status' => $this->input->post('status'),
            'image' => $imagePath

        ];

        $this->Product_model->update_product($id, $data);
        $this->session->set_flashdata('success', 'Product updated successfully!');
        redirect('ProductController');
    }
}
