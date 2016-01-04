<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class model_home extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function summary_order() {
        $data = array('total' => $this->total(), 'approve' => $this->approve(), 'reject' => $this->reject());
        return $data;
    }

    public function total() {
        return $this->so_number() + $this->foc_number() + $this->lo_number();
    }

    public function approve() {
        return $this->so_number(1) + $this->foc_number(1) + $this->lo_number(1);
    }

    public function reject() {
        return $this->so_number(2) + $this->foc_number(2) + $this->lo_number(2);
    }

    public function so_number($num = "") {
        if ($num <> '') {
            $this->db->where(array('so.order_list_approve' => $num));
        }
        $id = $this->model_utility->member_id();
        $this->db->where(array('o.FK_member_id' => $id, 'so.order_list_status' => 1));
        $this->db->join('bio_order_list so', 'o.order_id = so.order_list_order_id', 'left');
        return $this->db->select('*')->from('bio_order o')->get()->num_rows();
    }

    public function foc_number($num = "") {
        if ($num <> '') {
            $this->db->where(array('fo.foc_approve' => $num));
        }
        $id = $this->model_utility->member_id();
        $this->db->where(array('o.FK_member_id' => $id, 'fo.foc_status' => 1));
        $this->db->join('bio_order_foc fo', 'o.order_id = fo.foc_order_id', 'left');
        return $this->db->select('*')->from('bio_order o')->get()->num_rows();
    }

    public function lo_number($num = "") {
        if ($num <> '') {
            $this->db->where(array('lo.ob_approve' => $num));
        }
        $id = $this->model_utility->member_id();
        $this->db->where(array('o.FK_member_id' => $id, 'lo.ob_status' => 1));
        $this->db->join('bio_order_borrow lo', 'o.order_id = lo.ob_order_id', 'left');
        return $this->db->select('*')->from('bio_order o')->get()->num_rows();
    }

    public function product_chart($val) {
        $session['total'] = 0;
        $product_list = $this->db->where('product_status', 1)->order_by('product_id', 'ASC')->get('bio_product')->result_array();
        foreach ($product_list as $rs_prod) {
            $where_count_list = array(
                'order_list_status' => 1,
                'order_list_approve' => 1,
                'ldetail_status' => 1,
                'ldetail_product_id' => $rs_prod['product_id'],
                'FK_member_id' => $val,
                'order_status' => 1,
                'DATE_FORMAT(order_list_date,(\'%m%Y\'))' => date('mY')
            );
            $where_count_foc = array(
                'foc_status' => 1,
                'foc_approve' => 1,
                'fdetail_status' => 1,
                'fdetail_product_id' => $rs_prod['product_id'],
                'FK_member_id' => $val,
                'order_status' => 1,
                'DATE_FORMAT(foc_date,(\'%m%Y\'))' => date('mY')
            );
            $where_count_borrow = array(
                'ob_status' => 1,
                'ob_approve' => 1,
                'obd_status' => 1,
                'obd_product_id' => $rs_prod['product_id'],
                'FK_member_id' => $val,
                'order_status' => 1,
                'DATE_FORMAT(ob_date,(\'%m%Y\'))' => date('mY')
            );

            $count_list = $this->db->select_sum('ldetail_qty', 'qty')
                            ->join('bio_order_list_detail as ld', 'ld.ldetail_order_list_id = l.order_list_id', 'INNER')
                            ->join('bio_order as o', 'o.order_id = l.order_list_order_id', 'INNER')
                            ->where($where_count_list)->group_by('ldetail_product_id')->get('bio_order_list as l')->row('qty');
            
            $count_foc = $this->db->select_sum('fdetail_qty', 'qty')
                            ->join('bio_order_foc_detail as fd', 'fd.fdetail_foc_id = f.foc_id', 'INNER')
                            ->join('bio_order as o', 'o.order_id = f.foc_order_id', 'INNER')
                            ->where($where_count_foc)->group_by('fdetail_product_id')->get('bio_order_foc as f')->row('qty');
            
            $count_borrow = $this->db->select_sum('obd_qty_borrow', 'qty')
                            ->join('bio_order_borrow_detail as bd', 'bd.obd_ob_id = b.ob_id', 'INNER')
                            ->join('bio_order as o', 'o.order_id = b.ob_order_id', 'INNER')
                            ->where($where_count_borrow)->group_by('obd_product_id')->get('bio_order_borrow as b')->row('qty');
            $session['qty'][] = array(
                'id' => $rs_prod['product_id'],
                'name' => $rs_prod['product_name'],
                'qty' => ((!empty($count_list))?$count_list:0)+((!empty($count_foc))?$count_foc:0)+((!empty($count_borrow))?$count_borrow:0),
            );
            $session['total'] += ((!empty($count_list))?$count_list:0)+((!empty($count_foc))?$count_foc:0)+((!empty($count_borrow))?$count_borrow:0);
        }
        return ($session);
    }
    
    public function color_list(){
        return array(
            '#666666', '#990000', '#007700', '#FF6600', '#FF6666', '#9933CC', '#009ACD', '#00CDCD', '#C0FF3E', '#DAA520'
        );
    }

}
