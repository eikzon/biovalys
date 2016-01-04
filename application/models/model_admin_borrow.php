<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class model_admin_borrow extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function order_message() {
        $sqlmessage = $this->db->select("*")->from("bio_order_message")->join("bio_order as `ord`", "order_id = FK_order_id")->where(array("bio_order_message.FK_member_id" => $this->session->userdata('id'), "message_status" => 0))->order_by("message_id", "desc")->get();
        $count = $sqlmessage->num_rows();
        if ($count > 0) {
            foreach ($sqlmessage->result_array() as $row) {
                $data[] = array('order_id' => $row['order_id'],
                    'order_number' => $row['order_number'],
                    'order_datae' => $row['order_create_date']);
            }
        } else {
            $data[] = array();
        }
        return $data;
    }

    public function read_message($id) {
        $where = array('FK_order_id' => $id, 'FK_member_id' => $this->session->userdata('id'));
        $data = array('message_status' => 1);
        return $this->db->update('bio_order_message', $data, $where);
    }

    public function borrow_list($arr = '') {
        $where = array('order_status !=' => 2);
        $search = $this->session->userdata('search_order');
        if (isset($arr) && !empty($arr)) {
            $this->db->limit($arr['limit'], $arr['start']);
        }
        if (isset($search) && !empty($search) && $this->uri->segment(2)) {
            if (isset($search['customer']) && $search['customer'] <> '') {
                $this->db->like('customer_name', $search['customer']);
            }
            if (isset($search['representative']) && $search['representative'] <> '') {
                $this->db->like('customer_represent_name', $search['representative']);
            }
            if (isset($search['date']) && $search['date'] <> '') {
                $date = explode('/', $search['date']);
                $this->db->like('order_create_date', $date[2] . '-' . $date[1] . '-' . $date[0]);
            }
            if (isset($search['stat']) && $search['stat'] <> '') {
                $this->db->where('order_approve', $search['stat']);
            }
            if (isset($search['sale']) && $search['sale'] <> '') {
                $this->db->like('member_name', $search['sale']);
            }
        }
        $this->db->join('bio_member m', 'o.FK_member_id=m.member_id', 'LEFT');
        $this->db->join('bio_customer c', 'c.customer_id=o.FK_customer_id', 'LEFT');
        $data = $this->db->select('*')->from('bio_order o')->where($where)->order_by('order_id', 'desc')->get()->result_array();
        return $data;
    }

    public function order_data($arr) {
        $this->db->join('bio_member m', 'o.FK_member_id=m.member_id', 'LEFT');
        $this->db->join('bio_customer c', 'c.customer_id=o.FK_customer_id', 'LEFT');
        $data = $this->db->select('*')->from('bio_order o')->where($arr)->order_by('order_id', 'desc')->get()->result_array();
        return $data;
    }

    public function order_detail($arr) {
        $this->db->join('bio_product p', 'p.product_id=o.FK_product_id', 'LEFT');
        $data = $this->db->select('*')->from('bio_order_list o')->where($arr)->order_by('order_list_id', 'desc')->get()->result_array();
        return $data;
    }

    public function save_order($arr) {
        $od_data = array('FK_member_id' => $this->model_utility->member_id(),
            'order_number' => $this->order_number(),
            'order_approve' => 0);
        $key = array('FK_product_id' => '', 'item_qty' => '', 'item_price' => '');
        $order = array_diff_key($arr, $key);
        $detail = array_intersect_key($arr, $key);

        $insert_data = array_merge($order, $od_data);
        $rs = $this->db->insert('bio_order', $insert_data);
        $id = $this->db->insert_id();
        $id = array('FK_order_id' => $id);
        $detail = array_merge($detail, $id);
        $this->order_detail_save($detail);
        return $rs;
    }

    public function order_update($arr) {
        $where = array_intersect_key($arr, array('order_id' => ''));
        $arr = array_diff_key($arr, $where);
        return $this->db->update('bio_order', $arr, $where);
    }

    public function order_number() {
        $where = array('order_id >=' => 1);
        $data = $this->order_data($where);
        $data = str_pad(count($data) + 1, 6, "0", STR_PAD_LEFT);
        return $data;
    }

    public function order_detail_save($arr) {
        foreach ($arr['FK_product_id'] as $k) {
            $data = array('FK_product_id' => $k,
                'item_qty' => $arr['item_qty'][$k],
                'item_price' => $arr['item_price'][$k],
                'FK_order_id' => $arr['FK_order_id']
            );
            $this->db->insert('bio_order_list', $data);
        }
    }

    public function order_total_price($id) {
        $where = array('FK_order_id' => $id);
        $value = 0;
        $total = 0;

//        $order = $this->order_data(array('order_id'=>$id));
//        $discount = $order['0']['order_discount_percent'];

        $data = $this->db->select_sum('item_subtotal')->from('bio_order_list')->where($where)->get()->result_array();
//        if(isset($data) && !empty($data))
//        {
//            foreach($data as $sum)
//            {
//                $value += $sum['item_price']*$sum['item_qty'];
//            }
//        }
//        $discount = ($discount > 0)?$value*($discount/100):0;
//        $total = $value-$discount;
        return $data[0]['item_subtotal'];
    }

    public function order_show_status($id) {
        if ($id == 1) {
            $data = '<span class="list-stat success"><i class="fa fa-check-square fa-lg"></i>  Approved</span>';
        } elseif ($id == 2) {
            $data = '<span class="list-stat reject"><i class="fa fa-times fa-lg"></i>Reject</span>';
        } else {
            $data = '<span class="list-stat warning"><i class="fa fa-exclamation-triangle fa-lg"></i> Waiting</span>';
        }
        return $data;
    }

    public function order_delete($arr) {
        $data = array('order_status' => 2);
        $rs = $this->db->update('bio_order', $data, $arr);
        return $rs;
    }

    public function total_price_order() {
        $data = $this->list_order();
        $total = 0;
        $approve = 0;
        if (isset($data) && !empty($data)) {
            foreach ($data as $item) {

                $approve += ($item['order_approve'] == 1) ? $this->order_total_price($item['order_id']) : 0;
                $total += $this->order_total_price($item['order_id']);
            }
        }
        $rs = array('total' => $total, 'approve' => $approve);
        return $rs;
    }

    public function change_status($arr) {
        $where = array('order_id' => $arr['id']);
        $data = array('order_approve' => $arr['stat']);
        $rs = $this->db->update('bio_order', $data, $where);
        echo $this->db->last_query();
    }

}
