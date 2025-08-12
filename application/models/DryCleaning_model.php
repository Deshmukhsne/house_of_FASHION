<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DryCleaning_model extends CI_Model {

    public function insertDryCleaning($data) {
        return $this->db->insert('drycleaning_status', $data);
    }

    public function getProducts() {
        return $this->db->get('products')->result(); // Assuming 'products' table exists
    }
}
