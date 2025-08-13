<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrdersController extends CI_Controller {
    // Get category name by ID (for JS autofill)
    public function get_category_name() {
        $category_id = $this->input->get('category_id');
        $category = $this->OrdersModel->get_category_by_id($category_id);
        echo json_encode($category ?: []);
    }

    public function __construct() {
        parent::__construct();
        $this->load->model('OrdersModel');
        $this->load->helper(array('form', 'url'));
    }

    // View Orders Page
    public function view_orders() {
        $data['orders'] = $this->OrdersModel->get_all_orders_with_details(); // use detailed join version
        $this->load->view('Admin/Orders', $data);
    }

    // Create a new rental order
    public function create_order() {
        $post = $this->input->post();
        print_r($post); // Debugging line, remove in production

        $orderData = [
            'customerId'    => $post['customerId'],
            'customerName'  => $post['customerName'],
            'productImage'  => $post['productImage'], // base64 or raw image (depends)
            'productId'     => $post['productId'],
            'productName'   => $post['productName'],
            'productPrice'  => $post['productPrice'],
            'totalDays'     => $post['totalDays'],
            'category'    => $post['categoryName'],
            'issueDate'     => $post['issueDate'],
            'returnDate'    => $post['returnDate'],
            'totalPrice'    => $post['totalPrice'],
            'status'        => $post['status']
        ];

        $result = $this->OrdersModel->insert_order($orderData);

        if ($result) {
            redirect('OrdersController/view_orders');
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to insert order']);
        }
    }

    // Get customer by name (autocomplete)
    public function get_customers() {
        $term = $this->input->get('term');
        $customers = $this->OrdersModel->get_customers_by_name($term);
        echo json_encode($customers);
    }

    // Get single customer by ID
    public function get_customer_by_id() {
        $id = $this->input->get('id');
        $customer = $this->OrdersModel->get_customer_by_id($id);
        echo json_encode($customer ?: null);
    }

    // Get product details by ID
    public function get_product_details() {
        $product_id = $this->input->get('product_id');
        $product = $this->OrdersModel->get_product_by_id($product_id);
        if (!$product) {
            echo json_encode(['error' => 'Product not found']);
            return;
        }
        echo json_encode($product);
    }

    // View product image
    public function get_product_image($product_id) {
        $product = $this->OrdersModel->get_product_by_id($product_id);
        if ($product && !empty($product['image'])) {
            header("Content-Type: image/jpeg");
            echo $product['image'];
        } else {
            readfile(FCPATH . 'assets/images/no-image.png');
        }
    }

    // Show edit order form
public function edit_order($id) {
    $data['order'] = $this->OrdersModel->get_order_by_id($id);

    if (!$data['order']) {
        show_404(); // Order not found
    }

    $this->load->view('Admin/Orders', $data); 
}

// Update order from form
public function update_order() {
    $post = $this->input->post();

    $id = $post['order_id']; // Hidden input from the form

    $updatedData = [
        'customerName'  => $post['customerName'],
        'productName'   => $post['productName'],
        'productPrice'  => $post['productPrice'],
        'productImage'  => $post['productImage'], // base64 or raw image (depends)
        'category'    => $post['categoryName'],
        'totalDays'     => $post['totalDays'],
        'issueDate'     => $post['issueDate'],
        'returnDate'    => $post['returnDate'],
        'totalPrice'    => $post['totalPrice'],
        'status'        => $post['status']
    ];

    $this->OrdersModel->update_order($id, $updatedData);
    redirect('OrdersController/view_orders');
}

// Delete order
public function delete_order($id) {
    $this->OrdersModel->delete_order($id);
    redirect('OrdersController/view_orders');
}




}
