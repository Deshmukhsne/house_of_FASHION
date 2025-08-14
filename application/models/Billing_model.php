<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Billing_model extends CI_Model
{
    /* -------- INSERTS -------- */
    public function insert_invoice($data)
    {
        $this->db->insert('invoices', $data);
        return $this->db->insert_id();
    }

    public function insert_invoice_items($items)
    {
        return $this->db->insert_batch('invoice_items', $items);
    }

    /* -------- LOOKUPS for the form -------- */
    public function get_categories()
    {
        return $this->db->order_by('name', 'ASC')->get('categories')->result_array();
    }

    public function get_categories_map()
    {
        $rows = $this->get_categories();
        $map = [];
        foreach ($rows as $r) $map[$r['id']] = $r['name'];
        return $map;
    }

    public function get_products_with_cat()
    {
        // Join with categories to get category name as well
        return $this->db
            ->select('products.id, products.name, products.category_id, products.price, products.status, categories.name as category_name')
            ->from('products')
            ->join('categories', 'products.category_id = categories.id', 'left')
            ->order_by('products.name', 'ASC')
            ->get()->result_array();
    }

    public function get_products_map()
    {
        $rows = $this->get_products_with_cat();
        $map = [];
        foreach ($rows as $r) {
            $map[$r['id']] = [
                'name'        => $r['name'],
                'price'       => (float)$r['price'],
                'category_id' => (int)$r['category_id'],
                'status'      => $r['status']
            ];
        }
        return $map;
    }

    public function get_products_by_category($category_id)
    {
        return $this->db->select('id, name, price, stock, status')
                        ->from('products')
                        ->where('category_id', $category_id)
                        ->order_by('name','ASC')
                        ->get()->result_array();
    }

    /* -------- BILLING HISTORY / DETAILS -------- */
    public function get_invoices($from = null, $to = null)
    {
        if ($from) $this->db->where('invoice_date >=', $from);
        if ($to)   $this->db->where('invoice_date <=', $to);

        // Fetch all columns, including customer_mobile if present
        return $this->db->order_by('id','DESC')->get('invoices')->result_array();
    }

    public function get_invoice_by_id($id)
    {
        $inv = $this->db->where('id', $id)->get('invoices')->row_array();
        if ($inv) {
            // $inv will include customer_mobile if present in table
            $inv['items'] = $this->db->where('invoice_id', $id)->get('invoice_items')->result_array();
        }
        return $inv;
    }

    public function delete_invoice($id)
    {
        $this->db->where('id', $id)->delete('invoices'); // cascade removes items
        return $this->db->affected_rows();
    }

    public function update_invoice_number($invoice_id, $invoice_no) {
        $this->db->where('id', $invoice_id);
        $this->db->update('invoices', ['invoice_no' => $invoice_no]);
    }
}
