<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

@header("Content-type: text/html; charset=utf-8"); //set utf-8
@date_default_timezone_set("Asia/Bangkok");

class model_admin_product extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function product_list($arr = '') {
        if (isset($arr) && !empty($arr)) {
            $this->db->limit($arr['limit'], $arr['start']);
        }

        $search = $this->session->userdata('product');
        if (isset($search) && !empty($search)) {
            if ($search['sid'] != '') {
                $this->db->where('product_code', $search['sid']);
            }

            if ($search['sname'] != '') {
                $this->db->like('product_name', $search['sname']);
            }
        }

        $query = $this->db->select("*")->from("bio_product")->where("product_status !=", 2)->order_by("product_id", "desc")->get();
        //return $this->db->last_query();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $pro_pic = (is_file("assets/img/product/" . $row['product_picture'])) ? base_url() . "assets/img/product/" . $row['product_picture'] : '//placehold.it/200x143?text=No+Image';
                $product_list[] = array(
                    'id' => $row['product_id'],
                    'code' => $row['product_code'],
                    'name' => $row['product_name'],
                    'detail' => $row['product_detail'],
                    'rebate' => $row['product_type_rebate'],
                    'picture' => $pro_pic);
            }
        } else {
            $product_list[] = array();
        }
        return $product_list;
    }

    public function product_insert($data) {
        $product = array('product_code' => $data['pro_code'],
            'product_name' => $data['pro_name'],
            'product_update_price' => date('Y-m-d H:i:s'),
            'product_detail' => $data['pro_detail'],
            'product_type_rebate' => $data['rebate'],
        );
        $this->db->insert('bio_product', $product);
        return $this->db->insert_id();
    }

    public function product_edit($id) {
        $query = $this->db->select("*")->from("bio_product")->where("product_id", $id)->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $pro_pic = (is_file("assets/img/product/" . $row['product_picture'])) ? base_url() . "assets/img/product/" . $row['product_picture'] : '//placehold.it/200x143?text=No+Image';
                $product_list[] = array('pro_code' => $row['product_code'],
                    'pro_name' => $row['product_name'],
                    'pro_picture' => $pro_pic,
                    'pro_detail' => $row['product_detail'],
                    'product_type_rebate' => $row['product_type_rebate']
                );
            }
        } else {
            $product_list[] = array();
        }
        return $product_list;
    }

    public function product_update($data, $id) {
        $where = array('product_id' => $id);
        $product = array('product_code' => $data['pro_code'],
            'product_name' => $data['pro_name'],
            'product_type_rebate' => $data['rebate'],
            'product_detail' => $data['pro_detail']);
        $this->db->update('bio_product', $product, $where);
    }

    public function product_delete($id) {
        $data = array('product_status' => '2');
        $where = array("product_id" => $id);
        $this->db->update("bio_product", $data, $where);
        return $this->db->last_query();
    }

    public function product_image($field, $id) {
        $data = array('product_picture' => $field);
        $where = array("product_id" => $id);
        return $this->db->update("bio_product", $data, $where);
    }

    //ไฟล์ excel สกุล csv
    function export_csv() {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline = "\r\n";
        $filename = "export_product_" . date("d-m-Y") . ".csv"; //ชื่อไฟล์

        $this->db->query('SET @rank=0;');
        $result = $this->db->select("
            (@rank:=@rank+1) as No,
           product_code as 'Product Code',
           product_name as 'Product Name'
        ")->from("bio_product")->where("product_status != ", "2")->get();
        $data = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
    }

}
