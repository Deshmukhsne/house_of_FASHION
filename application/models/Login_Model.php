<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Check login credentials
    public function check_login($username, $password, $role) {
        $this->db->where('username', $username);
        $this->db->where('password', $password); // Note: hash it later!
        $query = $this->db->get('admin'); // your table name

        return $query->row(); // returns single user row or null
    }
}
