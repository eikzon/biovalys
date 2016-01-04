<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

@header("Content-type: text/html; charset=utf-8"); //set utf-8
@date_default_timezone_set("Asia/Bangkok");

class model_admin_customer extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function type_list() {
        $query = $this->db->select("*")->from("bio_customer_type")->where("cus_type_status", 1)->order_by("cus_type_id", "asc")->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $type) {
                $type_list[] = array(
                    'type_id' => $type['cus_type_id'],
                    'type_name' => $type['cus_type_name']);
            }
        } else {
            $type_list[] = array();
        }
        return $type_list;
    }

    public function province_list() {
        $query = $this->db->select("*")->from("bio_province")->order_by("province_name_eng", "asc")->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $prov) {
                $prov_list[] = array(
                    'prov_id' => $prov['province_id'],
                    'prov_name' => $prov['province_name']);
            }
        } else {
            $prov_list[] = array();
        }
        return $prov_list;
    }

    public function customer_list($arr = '') {
        if (isset($arr) && !empty($arr)) {
            $this->db->limit($arr['limit'], $arr['start']);
        }
        $search = $this->session->userdata('search_customer');
        if (isset($search) && !empty($search) && $this->uri->segment(2)) {
            if (@$search['sid'] != '') {
                $this->db->where('customer_number', $search['sid']);
            }

            if (@$search['sname'] != '') {
                $this->db->like('customer_name', $search['sname']);
            }

//            if($search['srep_name'] != ''){
//                $this->db->like('customer_represent_name',$search['srep_name']);
//            }

            if (@$search['scus_type'] != '') {
                $this->db->where('FK_type_id', @$search['scus_type']);
            }

            if (@$search['szone_id'] != '') {
                $this->db->where('c.FK_zone_id', $search['szone_id']);
            }

            if (@$search['sstatus'] != '') {
                $this->db->where('customer_approve', $search['sstatus']);
            }
        }
        $case = "CASE WHEN customer_approve = 1 THEN '<span class=\'success\'><i class=\"fa fa-check-square fa-lg\"></i>&nbsp;&nbsp;Approve</span>' WHEN customer_approve = 2 THEN '<span class=\'reject\'><i class=\"fa fa-times fa-lg\"></i>&nbsp;&nbsp;Reject</span>' ELSE '<span class=\'warning\'><i class=\"fa fa-exclamation-triangle fa-lg\"></i>&nbsp;&nbsp;Waiting</span>' END approve";
        $query = $this->db->select("*, " . $case, false)
                ->from("bio_customer as c")
                ->join('bio_customer_type', 'FK_type_id = cus_type_id', 'INNER')
                ->join('bio_zone as z', 'c.FK_zone_id = zone_id', 'INNER')
                ->join('bio_member as m', 'm.FK_zone_id = z.zone_id', 'INNER')
                ->where("customer_status !=", 2)
                ->order_by("customer_id", "desc")->get()->result_array();
        return $query;
    }

    public function customer_data($arr) {
        $data = $this->db->select("*")->from("bio_customer")->where($arr)->get()->result_array();
        return $data;
    }

    public function customer_credit($row) {
        $order = $this->db->select("sum(item_qty*item_price) as sum_item")->from("bio_order")->join("bio_order_list", "order_id = FK_order_id")->where("FK_customer_id", $row['customer_id'])->get();
        //return $this->db->last_query();

        if ($order->num_rows() > 0) {
            foreach ($order->result_array() as $sum)
                ;
            if ($row['customer_credit_price'] > 0 || $sum['sum_item'] > 0) {
                $per = (($row['customer_credit_price'] - $sum['sum_item'] ) / $row['customer_credit_price']) * 100;
                $per_credit = (@$per < 0) ? 0 : @$per;
            } else {
                $per_credit = 0;
            }
        } else {
            $per_credit = 100;
        }

        if ($per_credit < 71) {
            $credit_color = 'progress-bar-green';
        } else if ($per_credit < 81) {
            $credit_color = 'progress-bar-yellow';
        } else {
            $credit_color = 'progress-bar-red';
        }
        $data = array('color' => $credit_color, 'per' => $per_credit);
        return $data;
    }

    public function customer_insert($data) {
        $user = ($this->session->userdata('id') != '') ? $this->session->userdata('id') : 0;
        $date = explode("/", $data['credit_date']);
        $format_date = $date[2] . "-" . $date[1] . "-" . $date[0];
        $mem_zone = explode('##', @$data['zone_id']);
        
        $customer = array(
            'FK_type_id' => $data['cus_type'],
            'FK_member_id' => @$mem_zone[1],
            'FK_zone_id' => @$mem_zone[0],
            'customer_credit_number' => $this->model_utility->gen_code_ca(),
            'customer_number' => $data['cus_number'],
            'customer_date_credit' => $format_date,
            'customer_taxid' => @$data['customer_taxid'],
            'customer_name' => $data['cus_name'],
            'customer_common' => $data['com_name'],
            'customer_address' => $data['cus_address'],
            'customer_province' => $data['cus_province'],
            'customer_postcode' => $data['cus_zone'],
            'customer_telephone' => $data['cus_tel'],
            'customer_lat' => '',
            'customer_lon' => '',
            'customer_pharmacist' => $data['customer_pharmacist'],
            'customer_remark' => $data['cus_remark'],
            'customer_credit_price' => $data['credit_price'],
            'customer_payment_term' => $data['pay_term'],
            'customer_payment_channel' => $data['pay_channel'],
            'customer_rebate_normal' => $data['rebate_normal'],
            'customer_rebate_extra_s' => $data['rebate_extra_s'],
            'customer_rebate_extra_td' => $data['rebate_extra_td'],
            'customer_date_register' => date("Y-m-d H:i:s"),
            'customer_military' => $data['customer_military'],
            'customer_provincial' => $data['customer_provincial'],
            'customer_approve' => 1,
            'customer_invoice_status' => $data['inv_print'],
            'customer_status' => 1
        );
        $this->db->insert('bio_customer', $customer);
        $cid = $this->db->insert_id();
        $rate_array = array();
        foreach($data['product_id'] as $p => $pid){
            $rate_array = array(
                'rate_product_id' => $pid,
                'rate_customer_id' => $cid,
                'rate_price' => @$data['product'][$p]
            );
            $this->db->insert('bio_product_rateprice', $rate_array);
        }
    }

    public function customer_edit($id) {
        return $this->db->join('bio_zone as z', 'z.zone_id = c.FK_zone_id', 'INNER')
                ->join('bio_member as m', 'm.FK_zone_id = z.zone_id', 'INNER')
                ->where("customer_id", $id)
                ->get('bio_customer as c')->first_row('array');
    }
    
    public function customer_detail($id) {
        return $this->db->join('bio_zone as z', 'z.zone_id = c.FK_zone_id', 'INNER')
                ->join('bio_member as m', 'm.FK_zone_id = z.zone_id', 'INNER')
                ->where("customer_id", $id)
                ->get('bio_customer as c')->first_row('array');
    }

    public function customer_update($data, $id) {
        $user = ($this->session->userdata('id') != '') ? $this->session->userdata('id') : 0;
        $where = array('customer_id' => $id);
        $date = explode("/", $data['credit_date']);
        $format_date = $date[2] . "-" . $date[1] . "-" . $date[0];
        $mem_zone = explode('##', @$data['zone_id']);
        
        $customer = array(
            'FK_type_id' => $data['cus_type'],
            'FK_member_id' => @$mem_zone[1],
            'FK_zone_id' => @$mem_zone[0],
            'customer_date_credit' => $format_date,
            'customer_number' => $data['cus_number'],
            'customer_taxid' => @$data['customer_taxid'],
            'customer_name' => $data['cus_name'],
            'customer_common' => $data['com_name'],
            'customer_address' => $data['cus_address'],
            'customer_province' => $data['cus_province'],
            'customer_postcode' => $data['cus_zone'],
            'customer_telephone' => $data['cus_tel'],
            'customer_remark' => $data['cus_remark'],
            'customer_pharmacist' => $data['customer_pharmacist'],
            'customer_credit_price' => $data['credit_price'],
            'customer_payment_term' => $data['pay_term'],
            'customer_payment_channel' => $data['pay_channel'],
            'customer_rebate_normal' => $data['rebate_normal'],
            'customer_rebate_extra_s' => $data['rebate_extra_s'],
            'customer_rebate_extra_td' => $data['rebate_extra_td'],
            'customer_military' => $data['customer_military'],
            'customer_provincial' => $data['customer_provincial'],
            'customer_approve' => $data['customer_approve'],
        );
        $this->db->update('bio_customer', $customer, $where);
        $rate_array = array();
        foreach($data['product_id'] as $p => $pid){
            $where_check = array(
                'rate_product_id' => $pid,
                'rate_customer_id' => $id,
            );
            $data_check = array('rate_price' => @$data['product'][$p]);
            $check = $this->db->select('rate_id')->where($where_check)->get('bio_product_rateprice')->num_rows();
            if($check > 0){
                $this->db->update('bio_product_rateprice', $data_check, $where_check);
            }else{
                $rate_array = array_merge($where_check, $data_check);
                $this->db->insert('bio_product_rateprice', $rate_array);
            }
        }
    }

    public function customer_delete($id) {
        $data = array('customer_status' => '2');
        $where = array("customer_id" => $id);
        $this->db->update("bio_customer", $data, $where);
        return $this->db->last_query();
    }

    //ไฟล์ excel สกุล csv
    function export_csv() {
        $k = 1;
        $query = $this->db->select("*")
                ->from("bio_customer as c")
                ->join("bio_customer_type", "FK_type_id = cus_type_id")
                ->join("bio_member", "member_id = c.FK_member_id", "INNER")
                ->where("customer_status != ", "2")
                ->get();
        foreach ($query->result_array() as $row) {
            $data[] = $k . "," . $row['customer_number'] . "," . iconv('UTF-8', 'TIS-620', $row['customer_name']) . "," . iconv('UTF-8', 'TIS-620', $row['member_name']) . "," . iconv('UTF-8', 'TIS-620', $row['cus_type_name']) . "," . $row['customer_credit_price'] . ".-" . "\n";
            $k++;
        }

        return $data;
    }

    public function zone_data() {
        $data = $this->db->select("*")->join('bio_member as m', 'm.FK_zone_id = z.zone_id', 'INNER')->where(array("zone_status" => 1, 'FK_level_id' => 3))->get('bio_zone as z')->result_array();
        return $data;
    }

    public function member_name($id) {
        $data = $this->db->select("*")->from("bio_member")->where(array("FK_zone_id" => $id))->get();
        if ($data->num_rows() > 0) {
            foreach ($data->result_array() as $dw)
                ;
            return $dw['member_name'];
        } else {
            return "";
        }
    }

    public function product_list() {
        return $this->db->select('*')->where('product_status', 1)->get('bio_product')->result_array();
    }
    
    public function rate_price($cid){
        $query = $this->db->select('*')->where('rate_customer_id', $cid)->get('bio_product_rateprice')->result_array();
        $data = array();
        if(count($query) > 0){
            foreach($query as $rs){
                $data[$rs['rate_product_id']] = $rs['rate_price'];
            }
        }
        return $data;
    }

}
