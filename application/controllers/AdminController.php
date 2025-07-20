<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AdminController extends CI_Controller
{
	public function index()
	{
		$this->load->view('index');
	}
    public function Sidebar(){
        $this->load->view('include/Sidebar');
    }
    public function Navbar(){
        $this->load->view('include/Navbar');
    }

    public function dashboard()
    {
        $this->load->view("Admin/AdminDashboard");  
    }
    public function AddStock()
    {
        $this->load->view("Admin/AddStock");
    }
    public function AdminLogin()
    {
        $this->load->view("Admin/Admin_Login");
    }
    
}
    