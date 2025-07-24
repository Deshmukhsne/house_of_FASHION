<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('CustomerModel');
        $this->load->library(['form_validation', 'pagination']);
        $this->load->helper(['url', 'form']);
        $this->load->library('user_agent');

    }

    public function index() {
        $search = $this->input->get('search');
        $filter = $this->input->get('filter');

        $config['base_url'] = base_url('customers');
        $config['per_page'] = 10;
        $config['uri_segment'] = 2;

        $query_array = [];
        if (!empty($search)) $query_array['search'] = $search;
        if (!empty($filter)) $query_array['filter'] = $filter;

        if (!empty($query_array)) {
            $suffix = '?' . http_build_query($query_array);
            $config['suffix'] = $suffix;
            $config['first_url'] = $config['base_url'] . $suffix;
        }

        $config['total_rows'] = $this->CustomerModel->count_customers($search, $filter);
        $this->pagination->initialize($config);

        $page = ($this->uri->segment(2)) ? (int)$this->uri->segment(2) : 0;

        $data['customers'] = $this->CustomerModel->get_customers($config['per_page'], $page, $search, $filter);
        $data['pagination'] = $this->pagination->create_links();
        $data['search'] = $search;
        $data['filter'] = $filter;

        $this->load->view('customers/main', $data);
    }

    public function addCustomer() {
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('contact', 'Contact', 'required');

        if ($this->form_validation->run()) {
            $data = [
                'name' => $this->input->post('name'),
                'contact' => $this->input->post('contact'),
                'id_proof_type' => $this->input->post('id_proof_type'),
            ];

            // File Upload
            if (!empty($_FILES['id_proof']['name'])) {
                $upload_path = FCPATH . 'uploads/id_proofs/';
                if (!is_dir($upload_path)) mkdir($upload_path, 0777, true);

                $config['upload_path'] = $upload_path;
                $config['allowed_types'] = 'jpg|jpeg|png|pdf';
                $config['max_size'] = 2048;

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('id_proof')) {
                    $data['id_proof_file'] = $this->upload->data('file_name');
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect(base_url('customers'));
                    return;
                }
            }

            $this->CustomerModel->insert_customer($data);
            $this->session->set_flashdata('success', 'Customer added successfully.');
        } else {
            $this->session->set_flashdata('error', validation_errors());
        }

        redirect(base_url('customers'));
    }

    public function editCustomer($id)
     {
    $referrer = $this->agent->referrer();  // Load user agent library in constructor

    $this->form_validation->set_rules('name', 'Name', 'required');
    $this->form_validation->set_rules('contact', 'Contact', 'required');

    if ($this->form_validation->run()) {
        $data = [
            'name' => $this->input->post('name'),
            'contact' => $this->input->post('contact'),
            'id_proof_type' => $this->input->post('id_proof_type'),
        ];

        // File Upload
        if (!empty($_FILES['id_proof']['name'])) {
            $upload_path = FCPATH . 'uploads/id_proofs/';
            if (!is_dir($upload_path)) mkdir($upload_path, 0777, true);

            $config['upload_path'] = $upload_path;
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size'] = 2048;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('id_proof')) {
                $data['id_proof_file'] = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                redirect($referrer);  // Redirect back
                return;
            }
        }

        $this->CustomerModel->update_customer($id, $data);
        $this->session->set_flashdata('success', 'Customer updated successfully.');
    } else {
        $this->session->set_flashdata('error', validation_errors());
    }

    redirect($referrer);  // Redirect back
}


    public function delete($id) {
        $this->CustomerModel->delete_customer($id);
        $this->session->set_flashdata('success', 'Customer deleted successfully.');
        redirect(base_url('customers'));
    }
}
