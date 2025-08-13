<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['form', 'url']);
        $this->load->library(['session', 'form_validation']);
        $this->load->model('Login_Model');
        $this->load->model('Admin_Model');
        $this->load->model('Product_model');

         $this->load->model('DryCleaning_model');

        $this->load->model('DryCleaning_model');
    }

    public function index()
    {
        $this->load->view('index');
    }

    public function Sidebar()
    {
        $this->load->view('include/Sidebar');
    }

    public function Navbar()
    {
        $this->load->view('include/Navbar');
    }

    public function AddStock()
    {
        $this->load->view("Admin/AddStock");
    }

    public function AdminLogin()
    {
        $this->load->view("Admin/Login");
    }

    public function CommonLinks()
    {
        $this->load->view("CommonLinks");
    }

    

 

public function DryCleaning_Forward()
{
    $this->load->model('OrdersModel');
    $data['products'] = $this->OrdersModel->get_all_products_for_drycleaning();
    $this->load->view('Admin/DryCleaning_Forward', $data);
}

// Save forward form to DB
public function save_drycleaning_forward()
{
    $this->load->model('DryCleaning_model');

    $data = [
        'vendor_name'     => $this->input->post('vendor_name'),
        'vendor_mobile'   => $this->input->post('vendor_mobile'),
        'product_name'    => $this->input->post('product_name'),
        'product_status'  => $this->input->post('product_status'),
        'forward_date'    => $this->input->post('forward_date'),
        'return_date'     => $this->input->post('return_date') ?: null,
        'status'          => 'In Cleaning', // default
        'expected_return' => $this->input->post('expected_return'),
        'cleaning_notes'  => $this->input->post('cleaning_notes'),
        'created_at'      => date('Y-m-d H:i:s'),
        'updated_at'      => date('Y-m-d H:i:s')
    ];

    if ($this->DryCleaning_model->insert($data)) {
        $this->session->set_flashdata('success', 'Dry cleaning forwarded successfully.');
    } else {
        $this->session->set_flashdata('error', 'Failed to forward dry cleaning.');
    }

    redirect('AdminController/DryCleaning_Forward');
}

//Drycleaning 
// Show status page


    // Save new record
    public function save_drycleaning()
    {
        $this->load->model('DryCleaning_model');

        $data = [
            'vendor_name'     => $this->input->post('vendor_name'),
            'vendor_mobile'   => $this->input->post('vendor_mobile'),
            'product_name'    => $this->input->post('product_name'),
            'product_status'  => $this->input->post('product_status'),
            'forward_date'    => $this->input->post('forward_date'),
            'return_date'     => $this->input->post('return_date') ?: null,
            'status'          => 'Forwarded', // default
            'expected_return' => $this->input->post('expected_return') ?: null,
            'cleaning_notes'  => $this->input->post('cleaning_notes'),
            'created_at'      => date('Y-m-d H:i:s'),
            'updated_at'      => date('Y-m-d H:i:s')
        ];

        if ($this->DryCleaning_model->insert($data)) {
            $this->session->set_flashdata('success', 'Record added successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to add record.');
        }

        redirect('AdminController/DryCleaning_Status');
    }

    // Status page
    public function DryCleaning_Status()
    {
        $this->load->model('DryCleaning_model');
        $data['drycleaning_data'] = $this->DryCleaning_model->get_all();
        $this->load->view('Admin/DryCleaning_Status', $data);
    }

    // AJAX update status
    public function update_status()
    {
        $id = $this->input->post('id');
        $status = $this->input->post('status');

        $this->load->model('DryCleaning_model');
        $updated = $this->DryCleaning_model->update_status($id, $status);

        echo json_encode(['success' => $updated]);
    }



    // AJAX delete
    public function delete_drycleaning()
    {
        $id = $this->input->post('id');

        $this->load->model('DryCleaning_model');
        $deleted = $this->DryCleaning_model->delete($id);

        echo json_encode(['success' => $deleted]);
    }

    // Add to stock (only if Returned)
    public function add_to_stock()
    {
        $status = $this->input->post('status');

        if ($status !== 'Returned') {
            echo json_encode(['success' => false, 'message' => 'Status must be Returned']);
            return;
        }

        // Stock saving logic here...
        echo json_encode(['success' => true]);
    }




    public function Orders()
    {
        $this->load->view('Admin/Orders');
    }

    public function Dashboard()
    {
        if (!$this->session->userdata('username')) {
            redirect('AdminController/Login');
        }
        $this->load->view('Admin/AdminDashboard');
    }

    public function Login()
    {
        $data['message'] = $this->session->userdata('username') ? 'Login successful!' : null;
        $this->load->view('Admin/Login', $data);
    }

    public function AfterLogin()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('AdminController/Login');
        } else {
            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);

            $user = $this->Login_Model->check_login($username, $password);

            if ($user) {
                $this->session->set_userdata([
                    'username' => $user->username,
                    'role'     => $user->role // Still store role from database if needed
                ]);

                $this->session->set_flashdata('success', 'Login successful!');
                redirect('AdminController/dashboard');
            } else {
                $this->session->set_flashdata('error', 'Invalid username or password.');
                redirect('AdminController/Login');
            }
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'You have successfully logged out.');
        redirect('AdminController/Login');
    }

    public function AddStaff()
    {
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
    public function Billing()
    {
        $this->load->view('Admin/BillSection');
    }

    public function ProductInventory()
    {
        $this->load->model('Product_model');

        $data['products'] = $this->Product_model->get_all_products();
        $this->load->view('Admin/product_inventory', $data);
    }

    public function AddCategory()
    {
        $this->load->view('Admin/add_category');
    }

    public function BillHistory()
    {
        $this->load->view('Admin/BillHistory');
    }
    public function ConsentForm()
    {
        $this->load->view('Admin/consent');
    }
    public function MonthlyReport()
    {
        $this->load->view('Admin/monthlyreport');
    }
    public function Report()
    {
        $this->load->view('Admin/Report');
    }

    public function Profile()
    {
        $this->load->view('Admin/Admin_Profile');
    }

    // Export to Excel without using library
    public function export_excel()
    {
        $customers = $this->CustomerModel->get_all_customers();

        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=customers_" . date('Ymd_His') . ".xls");

        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Name</th><th>Contact</th></tr>";
        foreach ($customers as $cust) {
            echo "<tr>";
            echo "<td>{$cust->id}</td>";
            echo "<td>{$cust->name}</td>";
            echo "<td>{$cust->contact}</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    // Export to PDF without library (just outputs HTML with PDF headers)
    public function export_pdf()
    {
        $customers = $this->CustomerModel->get_all_customers();

        $html = '<h2 style="text-align:center;">Customer List</h2>';
        $html .= '<table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse;">';
        $html .= '<tr style="background-color:#f2f2f2;">
                    <th>ID</th>
                    <th>Name</th>
                    <th>Contact</th>
                  </tr>';

        foreach ($customers as $cust) {
            $html .= '<tr>
                        <td>' . $cust->id . '</td>
                        <td>' . htmlspecialchars($cust->name) . '</td>
                        <td>' . htmlspecialchars($cust->contact) . '</td>
                      </tr>';
        }

        $html .= '</table>';

        $filename = "customers_" . date('Ymd_His') . ".pdf";
        header("Content-Type: application/pdf");
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header("Cache-Control: max-age=0");

        echo $html;
        exit;
    }

    // View-only PDF version (optional)
    public function export_pdf_view()
    {
        $data['customers'] = $this->CustomerModel->get_all_customers();
        $this->load->view('admin/export_pdf', $data);
    }
    public function change_password_handler()
    {
        if (!$this->session->userdata('username')) {
            $this->session->set_flashdata('error', 'Please log in first.');
            redirect('AdminController/Login');
        }

        $currentPassword = $this->input->post('currentPassword', TRUE);
        $newPassword     = $this->input->post('newPassword', TRUE);
        $confirmPassword = $this->input->post('confirmPassword', TRUE);

        $username = $this->session->userdata('username');

        $admin = $this->db->get_where('admin', ['username' => $username])->row();

        if (!$admin) {
            $this->session->set_flashdata('error', 'User not found.');
            redirect('AdminController/Profile');
        }

        if (!password_verify($currentPassword, $admin->password)) {
            $this->session->set_flashdata('error', 'Current password is incorrect.');
            redirect('AdminController/Profile');
        }

        if ($newPassword !== $confirmPassword) {
            $this->session->set_flashdata('error', 'New passwords do not match.');
            redirect('AdminController/Profile');
        }

        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $this->db->where('username', $username);
        $this->db->update('admin', ['password' => $hashedPassword]);

        $this->session->set_flashdata('success', 'Password updated successfully.');
        redirect('AdminController/Profile');
    }

    public function hash_existing_passwords()
    {
        $this->load->database();

        $admins = $this->db->get('admin')->result();

        foreach ($admins as $admin) {
            // Skip if already hashed (optional check, for example length > 60 chars)
            if (strlen($admin->password) < 60) {
                $hashed = password_hash($admin->password, PASSWORD_DEFAULT);
                $this->db->where('id', $admin->id)->update('admin', ['password' => $hashed]);
            }
        }

        echo "Password hashing completed for existing admin users.";
    }
    public  function printInvoice()
    {
        $this->load->view('admin/print_invoice');
    }
}
