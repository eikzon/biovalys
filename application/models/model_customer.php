<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class model_customer extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function list_customer($arr = '') {
        $user = $this->session->userdata('member_data');
        $where = array('customer_status' => 1);
        if ($user['member_id'] > 1) {
            $where = array_merge($where, array('FK_zone_id' => $user['FK_zone_id']));
        }
        $search = $this->session->userdata('customer');
        if (isset($arr) && !empty($arr)) {
//            $this->db->limit($arr['limit'],$arr['start']);
        }
//        if (isset($search) && !empty($search)) {
        if (!empty($search['name'])) {
            $where_or = "(
                    customer_name LIKE '%" . $search["name"] . "%' OR
                    customer_credit_number LIKE '%" . $search["name"] . "%'
                )";
            $this->db->where($where_or, NULL, FALSE);
        }
//        }
        $data = $this->db->select('*')
                        ->from('bio_customer')
                        ->where($where)->order_by('customer_id', 'desc')
                        ->get()->result_array();
        return $data;
    }

    public function data_customer($arr) {
        $data = $this->db->select('*')->from('bio_customer')->where($arr)->order_by('customer_id', 'desc')->get()->result_array();
        return $data;
    }

    public function save_customer($arr) {
        $mem = $this->session->userdata('member_data');

        $data = array(
            'customer_date_credit' => date('Y-m-d H:i:s'),
            'customer_date_register' => date('Y-m-d H:i:s'),
            'customer_approve' => 0,
            'FK_member_id' => $mem['member_id'],
            'customer_common' => $arr['customer_name'],
            'FK_zone_id' => $mem['FK_zone_id'],
            'customer_credit_number' => $this->model_utility->gen_code_ca()
        );
        $data = array_merge($arr, $data);
        $rs = $this->db->insert('bio_customer', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function type_customer() {
        $where = array('cus_type_status' => 1);
        $data = $this->db->select('*')->from('bio_customer_type')->where($where)->get()->result_array();
        return $data;
    }

    public function province_customer() {
        return $this->db->select('*')->from('bio_province')->get()->result_array();
    }

    public function customer_auto() {
        $user = $this->session->userdata('member_data');
        $where = array('customer_status' => 1, 'FK_zone_id' => $user['FK_zone_id']);
        return $this->db->select('customer_id,customer_name')->from('bio_customer')->where($where)->order_by('customer_id', 'desc')->get()->result_array();
    }

    public function customer_detail() {
        $id = $this->uri->segment(3);
        $where = array(
            'customer_status' => 1,
//            'customer_approve' => 1,
            'zone_status' => 1,
            'cus_type_status' => 1,
            'customer_id' => $id,
        );
        return $this->db->join('bio_customer_type as t', 'c.FK_type_id = t.cus_type_id', 'INNER')
                        ->join('bio_zone as z', 'c.FK_zone_id = z.zone_id', 'INNER')
                        ->join('bio_province as p', 'c.customer_province = p.province_id', 'LEFT')
                        ->where($where)
                        ->get('bio_customer as c')
                        ->first_row('array');
    }

    public function count_product($cus) {
        $data = 0;
        if ($this->cart->contents()) {
            foreach ($this->cart->contents() as $prod) {
                if ($prod['customer'] == $cus) {
                    $data += 1;
                }
            }
        }
        return $data;
    }

}
