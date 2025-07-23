<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InvoiceModel extends CI_Model {

    public function insertInvoice($data) {
        $this->db->insert('invoices', $data);
        return $this->db->insert_id(); // returns the invoice ID
    }

    public function insertInvoiceItem($item) {
        $this->db->insert('invoice_items', $item);
    }
    public function get_all_invoices() {
    return $this->db->get('invoices')->result();  // should return array of objects
}

}
