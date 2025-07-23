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
    
         public function DryCleaning(){
         $this->load->view('Admin/DryCleaning');
 
    }
     public function DryCleaning_Forward(){
         $this->load->view('Admin/DryCleaning_Forward');
 
    }
    public function DryCleaning_Status(){
         $this->load->view('Admin/DryCleaning_Status');
 
    }


    // ✅ Only one dashboard() method
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
    public function DailyReport() {
        $this->load->view('Admin/dailyreport');
    }
    public function MonthlyReport() {
        $this->load->view('Admin/monthlyreport');
    }
}

