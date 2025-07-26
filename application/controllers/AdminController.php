<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminController extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['form', 'url']);
        $this->load->library(['session', 'form_validation']);
        $this->load->model('Login_Model'); 
        $this->load->model('Admin_Model'); 
        $this->load->model('Product_model');
        $this->load->model('CustomerModel');
        $this->load->library('pagination');
        $this->load->library('user_agent'); // For referrer detection


    }

    public function index() {
        $this->load->view('index');
    }

    public function Sidebar() {
        $this->load->view('include/Sidebar');
    }

    public function Navbar() {
        $this->load->view('include/Navbar');
    }

    public function AddStock() {
        $this->load->view("Admin/AddStock");
    }

    public function AdminLogin() {
        $this->load->view("Admin/Login");
    }

    public function CommonLinks() {
        $this->load->view("CommonLinks");
    }
    
       //Dry cleaning 
     public function DryCleaning_Forward(){
         $this->load->view('Admin/DryCleaning_Forward');
 
    }
    public function DryCleaning_Status(){
         $this->load->view('Admin/DryCleaning_Status');

    if ($this->input->method() === 'post') {
        $data = [
            'product_id'       => $this->input->post('forward_dress_id'),
            'forward_date'     => $this->input->post('forward_date'),
            'status'           => $this->input->post('status'),
            'expected_return'  => $this->input->post('expected_return'),
            'cleaning_notes'   => $this->input->post('cleaning_notes')
        ];

        $this->load->database();
        $this->db->insert('drycleaning_status', $data);

        redirect('AdminController/DryCleaning_Status'); 
    }
    }
    
    public function Orders() {
        $this->load->view('Admin/Orders');
    }

    public function Dashboard() {
        if (!$this->session->userdata('username')) {
            redirect('AdminController/Login');
        }
        $this->load->view('Admin/AdminDashboard');
    }

    public function Login() {
        $data['message'] = $this->session->userdata('username') ? 'Login successful!' : null;
        $this->load->view('Admin/Login', $data);
    }

    public function AfterLogin() {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[Admin,Accountant,Staff]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('AdminController/Login');
        } else {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);
            $role     = $this->input->post('role', TRUE);

            $user = $this->Login_Model->check_login($username, $password, $role);

            if ($user) {
                $this->session->set_userdata([
                    'username' => $user->username,
                    'role'     => $user->role
                ]);

                $this->session->set_flashdata('success', 'Login successful!');
                redirect('AdminController/dashboard');
            } else {
                $this->session->set_flashdata('error', 'Invalid username, password, or role.');
                redirect('AdminController/Login');
            }
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'You have successfully logged out.');
        redirect('AdminController/Login');
    }

    public function AddStaff() {
        $this->load->view('Admin/StaffManagement');
    }

    public function StaffManagement()
    {
        $search = $this->input->get('search');
        $role   = $this->input->get('role');
        $data['staffs'] = $this->Admin_Model->get_all_staffs($search, $role);
        $this->load->view('Admin/StaffManagement', $data);
    }

    public function saveStaff()
    {
        $data = [
            'name'         => $this->input->post('name'),
            'email'        => $this->input->post('email'),
            'phone'        => $this->input->post('phone'),
            'address'      => $this->input->post('address'),
            'joining_date' => $this->input->post('joining_date'),
            'role'         => $this->input->post('role'),
            'username'     => $this->input->post('username'),
            'password'     => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
        ];
        $this->Admin_Model->insert_staff($data);
        redirect('AdminController/StaffManagement');
    }

    public function editStaff($id)
    {
        $staff = $this->Admin_Model->get_staff_by_id($id);
        if (!$staff) show_404();

        if ($_POST) {
            $username = $this->input->post('username');

            // Check for duplicate usernames
            $existing = $this->Admin_Model->get_by_username($username);
            if ($existing && $existing->id != $id) {
                $this->session->set_flashdata('error', 'Username already taken.');
                redirect('AdminController/editStaff/' . $id);
            }

            $data = [
                'name'         => $this->input->post('name'),
                'email'        => $this->input->post('email'),
                'phone'        => $this->input->post('phone'),
                'address'      => $this->input->post('address'),
                'joining_date' => $this->input->post('joining_date'),
                'role'         => $this->input->post('role'),
                'username'     => $username,
            ];

            if (!empty($this->input->post('password'))) {
                $data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            }

            $this->Admin_Model->update_staff($id, $data);
            $this->session->set_flashdata('success', 'Staff updated successfully!');
        }
        redirect('AdminController/StaffManagement');
    }

    public function deleteStaff($id)
    {
        $this->Admin_Model->delete_staff($id);
        $this->session->set_flashdata('success', 'Staff deleted successfully!');
        redirect('AdminController/StaffManagement');
    }

    //billing 
    public function Billing() {
        $this->load->view('Admin/BillSection');
    }

    public function ProductInventory() {
         $this->load->model('Product_model');

    $data['products'] = $this->Product_model->get_all_products();
        $this->load->view('Admin/product_inventory', $data);
    }
 
    public function AddCategory() {
        $this->load->view('Admin/add_category');
    }
    
      public function BillHistory() {
        $this->load->view('Admin/BillHistory');
    }
       public function DailyReport() {
        $this->load->view('Admin/DailyReport');  // Capital D

    }
    public function MonthlyReport() {
        $this->load->view('Admin/monthlyreport');
    }
  public function Profile()
  {
    $this->load->view('Admin/Admin_Profile');
  }
  
  public function customers() {
    $search = $this->input->get('search');
    $filter = $this->input->get('filter');

    $config['base_url'] = base_url('AdminController/customers');
    $config['per_page'] = 10;
    $config['uri_segment'] = 3;

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

    $page = ($this->uri->segment(3)) ? (int)$this->uri->segment(3) : 0;

    $data['customers'] = $this->CustomerModel->get_customers($config['per_page'], $page, $search, $filter);
    $data['pagination'] = $this->pagination->create_links();
    $data['search'] = $search;
    $data['filter'] = $filter;

    $this->load->view('Admin/Customers', $data);
}

// Add Customer
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
                redirect(base_url('AdminController/customers'));
                return;
            }
        }

        $this->CustomerModel->insert_customer($data);
        $this->session->set_flashdata('success', 'Customer added successfully.');
    } else {
        $this->session->set_flashdata('error', validation_errors());
    }

    redirect(base_url('AdminController/customers'));
}

// Edit Customer
public function editCustomer($id) {
    $referrer = $this->agent->referrer();  // needs user_agent lib loaded

    $this->form_validation->set_rules('name', 'Name', 'required');
    $this->form_validation->set_rules('contact', 'Contact', 'required');

    if ($this->form_validation->run()) {
        $data = [
            'name' => $this->input->post('name'),
            'contact' => $this->input->post('contact'),
            'id_proof_type' => $this->input->post('id_proof_type'),
        ];

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
                redirect($referrer);
                return;
            }
        }

        $this->CustomerModel->update_customer($id, $data);
        $this->session->set_flashdata('success', 'Customer updated successfully.');
    } else {
        $this->session->set_flashdata('error', validation_errors());
    }

    redirect($referrer);
}

// Delete Customer
public function deleteCustomer($id) {
    $this->CustomerModel->delete_customer($id);
    $this->session->set_flashdata('success', 'Customer deleted successfully.');
    redirect(base_url('AdminController/customers'));
}

}

