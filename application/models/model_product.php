<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class model_product extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function list_product($cus = '') {
        if(!empty($cus)){
            $this->db->join('bio_product_rateprice as r', 'p.product_id = r.rate_product_id and rate_customer_id = ' . $cus . '', 'LEFT');
        }
        $where = array('product_status' => 1);
        $data = $this->db->select('*')
                        ->from('bio_product as p')
                        ->where($where)
                        ->order_by('product_id', 'desc')->get()->result_array();
        return $data;
    }

    public function product_data($arr) {
        $where = array_merge(array('product_status' => 1), $arr);
        $data = $this->db->select('*')->from('bio_product')->where($where)->order_by('product_id', 'desc')->get()->result_array();
        return $data;
    }

    public function product_free($arr) {
        $data = $this->product_free_data($arr);
        $free = 0;
        if (isset($data) && !empty($data)) {
            $free = $data['0']['free'];
            $loop = $arr['qty'] / $data['0']['qty_free'];
            $loop = ($loop <= 1) ? 1 : floor($loop);
            $free = $free * $loop;
        }
        return $free;
    }

    private function product_free_data($arr) {
        $where = array('FK_product_id' => $arr['product_id'], 'free_stat' => 1, 'qty_free <=' => $arr['qty']);
        $data = $this->db->select('*')->from('bio_free')->where($where)->order_by('qty_free', 'desc')->get()->result_array();
        return $data;
    }

    public function set_product_value($arr) { // setting value product for add new CA
        $cart = $this->cart->contents();
        foreach ($cart as $item) {
            if ($item['type'] <> 2 && $item['customer'] == $arr['customer_id']) {
                $data = array('rate_product_id' => $item['prod'], 'rate_customer_id' => $item['customer'], 'rate_price' => $item['ori_price']);
                $this->db->insert('bio_product_rateprice', $data);
            }
        }
    }

    public function get_price($arr) {
        return $this->db->select('rate_price as product_price')->from('bio_product_rateprice')->where($arr)->order_by('rate_id', 'decs')->limit(1, 0)->get()->result_array();
    }

}
