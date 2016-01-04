<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class model_admin_order extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function list_order($arr = '') {
        $where = array('order_status' => 1);
        $search = $this->session->userdata('search_order');
        if (isset($arr) && !empty($arr)) {
            $this->db->limit($arr['limit'], $arr['start']);
        }
        if (isset($search) && !empty($search) && $this->uri->segment(2)) {
            if (!empty($search['customer'])) {
                $this->db->like('customer_name', $search['customer']);
            }
            if (!empty($search['representative'])) {
                $this->db->like('customer_represent_name', $search['representative']);
            }
            if (!empty($search['sale'])) {
                $this->db->like('member_name', $search['sale']);
            }
        }
        $data = array();
        $query = $this->db->select('*')
                ->from('bio_order o')
                ->join('bio_member m', 'o.FK_member_id = m.member_id', 'INNER')
                ->join('bio_customer c', 'c.customer_id = o.FK_customer_id', 'INNER')
                ->where($where)
                ->order_by('order_id', 'desc')
                ->get()
                ->result_array();
        if (count($query)) {
            foreach ($query as $rs) {
                
                $where_so = array('order_list_order_id' => $rs['order_id'], 'order_list_status' => 1);
                $where_foc = array('foc_order_id' => $rs['order_id'], 'foc_status' => 1);
                $where_lo = array('ob_order_id' => $rs['order_id'], 'ob_status' => 1);
                if (!empty($search['date'])) {
                    $where_so = array_merge($where_so, array('DATE_FORMAT(order_list_date, \'%d/%m/%Y\') =' => $search['date']));
                    $where_foc = array_merge($where_foc, array('DATE_FORMAT(foc_date, \'%d/%m/%Y\') =' => $search['date']));
                    $where_lo = array_merge($where_lo, array('DATE_FORMAT(ob_date, \'%d/%m/%Y\') =' => $search['date']));
                }
                if(!empty($search['stat'])){
                    $where_so = array_merge($where_so, array('order_list_approve' => $search['stat']));
                    $where_foc = array_merge($where_foc, array('foc_approve' => $search['stat']));
                    $where_lo = array_merge($where_lo, array('ob_approve' => $search['stat']));
                }
                if(empty($search['stype']) || $search['stype'] == 1){
                    @$data = array_merge($data, $this->db->select('
                        order_list_code as d_code,order_list_id as d_id, order_list_order_id as d_oid,
                        order_list_date as d_date,order_list_discount as d_discount,order_list_free as d_free,
                        order_list_approve as d_approve,order_list_status as d_status, CONCAT(\'so\')as d_type,
                        CONCAT(\''.$rs['customer_name'].'\') as d_cusname,
                        CONCAT(\''.$rs['member_name'].'\') as d_memname,
                        CONCAT(\''.$rs['customer_represent_name'].'\') as d_repname

                        ')
                                    ->where($where_so)
                                    ->get('bio_order_list')
                                    ->result_array());
                }
                if(empty($search['stype']) || $search['stype'] == 2){
                    @$data = array_merge($data, $this->db->select('
                        foc_code as d_code,foc_id as d_id, foc_order_id as d_oid,
                        foc_date as d_date,CONCAT(\'0\') as d_discount,CONCAT(\'0\') as d_free,
                        foc_approve as d_approve,foc_status as d_status, CONCAT(\'foc\')as d_type,
                        CONCAT(\''.$rs['customer_name'].'\') as d_cusname,
                        CONCAT(\''.$rs['member_name'].'\') as d_memname,
                        CONCAT(\''.$rs['customer_represent_name'].'\') as d_repname
                        ')
                                    ->where($where_foc)
                                    ->get('bio_order_foc')
                                    ->result_array());
                }
                if(empty($search['stype']) || $search['stype'] == 3){
                    @$data = array_merge($data, $this->db->select('
                        ob_code as d_code,ob_id as d_id, ob_order_id as d_oid,
                        ob_date as d_date,CONCAT(\'0\') as d_discount,ob_qty_borrow as d_free,
                        ob_approve as d_approve,ob_status as d_status, CONCAT(\'lo\')as d_type,
                        CONCAT(\''.$rs['customer_name'].'\') as d_cusname,
                        CONCAT(\''.$rs['member_name'].'\') as d_memname,
                        CONCAT(\''.$rs['customer_represent_name'].'\') as d_repname
                        ')
                                    ->where($where_lo)
                                    ->get('bio_order_borrow')
                                    ->result_array());
                }
            }
        }
        return @$data;
    }

    public function order_total_price_so($id) {
        $subtotal = $total = $normal = $extra_s = $extra_td = 0;
        $where = array('order_list_order_id' => $id, 'order_list_status' => 1);
//        $data = $this->db->select_sum('ldetail_subtotal')
//                ->join('bio_order_list as l', 'l.order_list_id = d.ldetail_order_list_id', 'INNER')
//                ->where($where)
//                ->get('bio_order_list_detail as d')
//                ->first_row('array');
        $data = $this->db->join('bio_order_list as l', 'l.order_list_id = d.ldetail_order_list_id', 'INNER')
                ->join('bio_order as o', 'o.order_id = l.order_list_order_id', 'INNER')
                ->join('bio_product as p', 'p.product_id = d.ldetail_product_id', 'INNER')
                ->where($where)
                ->get('bio_order_list_detail as d')
                ->result_array();
        foreach($data as $rs){
            $subtotal += $rs['ldetail_subtotal'];
            if($rs['order_rebate_normal'] > 0){
                $normal += (($rs['ldetail_subtotal']*$rs['order_rebate_normal'])/100);
            }
            if($rs['product_type_rebate'] == 1 && $rs['order_rebate_extra_s'] > 0){
                $extra_s += (($rs['ldetail_subtotal']*$rs['order_rebate_extra_s'])/100);
            }
            if($rs['product_type_rebate'] == 2 && $rs['order_rebate_extra_td'] > 0){
                $extra_td += (($rs['ldetail_subtotal']*$rs['order_rebate_extra_td'])/100);
            }
        }
        return ($subtotal-$normal-$extra_s-$extra_td);
    }
    
    public function order_total_price_lo($id) {
        $where = array('ob_order_id' => $id, 'ob_status' => 1);
        $value = 0;
        $total = 0;
        $data = $this->db->select_sum('obd_total')
                ->join('bio_order_borrow as b', 'b.ob_id = d.obd_ob_id', 'INNER')
                ->where($where)
                ->get('bio_order_borrow_detail as d')
                ->first_row('array');
        return $data['obd_total'];
    }

    public function order_noti() {
        $data = array();
        $order = $this->db->where('order_status', 1)->order_by("order_id", "desc")->get('bio_order')->result_array();
        if (count($order) > 0) {
            foreach ($order as $rs) {
                $where_so = array(
                    'order_list_order_id' => $rs['order_id'],
                    'order_list_approve' => 0,
                    'order_list_status' => 1
                );
                $so = $this->db->where($where_so)->get('bio_order_list')->first_row('array');
                if(!empty($so['order_list_code'])){
                    $data[] = array(
                        'd_id' => $rs['order_id'],
                        'd_code' => $so['order_list_code'],
                        'd_date' => $so['order_list_date'],
                        'd_type' => 'so',
                    );
                }
                $where_foc = array(
                    'foc_order_id' => $rs['order_id'],
                    'foc_approve' => 0,
                    'foc_status' => 1
                );
                $foc = $this->db->where($where_foc)->get('bio_order_foc')->first_row('array');
                if(!empty($foc['foc_code'])){
                    $data[] = array(
                        'd_id' => $rs['order_id'],
                        'd_code' => $foc['foc_code'],
                        'd_date' => $foc['foc_date'],
                        'd_type' => 'foc',
                    );
                }
                $where_lo = array(
                    'ob_order_id' => $rs['order_id'],
                    'ob_approve' => 0,
                    'ob_status' => 1
                );
                $lo = $this->db->where($where_lo)->get('bio_order_borrow')->first_row('array');
                if(!empty($so['ob_code'])){
                    $data[] = array(
                        'd_id' => $rs['order_id'],
                        'd_code' => $lo['ob_code'],
                        'd_date' => $lo['ob_date'],
                        'd_type' => 'lo',
                    );
                }
            }
        }
        return $data;
    }

    public function read_message($id) {
        $where = array('FK_order_id' => $id, 'FK_member_id' => $this->session->userdata('id'));
        $data = array('message_status' => 1);
        return $this->db->update('bio_order_message', $data, $where);
    }

    public function order_data() {
        $id = $this->uri->segment(5);
        $type = $this->uri->segment(4);
        if($type == "so"){
            $data = $this->db->select('
                        *, l.order_list_code as c_code, order_list_approve as c_approve,
                        order_list_remark as c_remark, order_list_note as c_note
                    ')
                    ->from('bio_order o')
                    ->join('bio_member m', 'o.FK_member_id = m.member_id', 'INNER')
                    ->join('bio_customer c', 'c.customer_id = o.FK_customer_id', 'INNER')
                    ->join('bio_province p', 'p.province_id = c.customer_province', 'INNER')
                    ->join('bio_order_list as l', 'l.order_list_order_id = o.order_id', 'INNER')
                    ->join('bio_zone as z', 'z.zone_id = o.FK_zone_id', 'INNER')
                    ->order_by('order_id', 'desc')
                    ->where(array('order_list_order_id' => $id, 'order_list_status' => 1))
                    ->get()
                    ->first_row('array');
        }else if($type == "foc"){
            $data = $this->db->select('
                        *, f.foc_code as c_code, foc_approve as c_approve,
                        foc_remark as c_remark, foc_note as c_note
                    ')
                    ->from('bio_order o')
                    ->join('bio_member m', 'o.FK_member_id = m.member_id', 'INNER')
                    ->join('bio_customer c', 'c.customer_id = o.FK_customer_id', 'INNER')
                    ->join('bio_order_foc as f', 'f.foc_order_id = o.order_id', 'INNER')
                    ->order_by('order_id', 'desc')
                    ->where(array('foc_order_id' => $id, 'foc_status' => 1))
                    ->get()
                    ->first_row('array');
        }else if($type == "lo"){
            $data = $this->db->select('
                        *, ob_code as c_code, ob_approve as c_approve,
                        ob_remark as c_remark, ob_note as c_note
                    ')
                    ->from('bio_order o')
                    ->join('bio_member m', 'o.FK_member_id = m.member_id', 'INNER')
                    ->join('bio_customer c', 'c.customer_id = o.FK_customer_id', 'INNER')
                    ->join('bio_order_borrow as b', 'b.ob_order_id = o.order_id', 'INNER')
                    ->order_by('order_id', 'desc')
                    ->where(array('ob_order_id' => $id, 'ob_status' => 1))
                    ->get()
                    ->first_row('array');
        }
        
        return @$data;
    }

    public function order_detail() {
        $id = $this->uri->segment(5);
        $type = $this->uri->segment(4);
        if($type == "so"){
            $data = $this->db->select('
                    *, ldetail_qty as d_qty, ldetail_price as d_price, ldetail_discount as d_discount, 
                    ldetail_free as d_free, ldetail_subtotal as d_subtotal, 
                    ')
                    ->join('bio_order_list_detail d', 'o.order_list_id = d.ldetail_order_list_id', 'INNER')
                    ->join('bio_product p', 'p.product_id = d.ldetail_product_id', 'INNER')
                    ->join('bio_order ord', 'ord.order_id = o.order_list_order_id', 'INNER')
                    ->where(array('order_list_status' => 1, 'order_list_order_id' => $id))
                    ->order_by('order_list_id', 'desc')
                    ->get('bio_order_list o')
                    ->result_array();
        }else if($type == "foc"){
            $data = $this->db->select('
                    *, fdetail_qty as d_qty, CONCAT(\'F.O.C\') as d_price, CONCAT(\'F.O.C\') as d_discount, 
                    CONCAT(\'F.O.C\') as d_free, CONCAT(\'F.O.C\') as d_subtotal, 
                    ')
                    ->join('bio_order_foc_detail d', 'f.foc_id = d.fdetail_foc_id', 'INNER')
                    ->join('bio_product p', 'p.product_id = d.fdetail_product_id', 'INNER')
                    ->join('bio_order o', 'o.order_id = f.foc_order_id', 'INNER')
                    ->where(array('foc_status' => 1, 'foc_order_id' => $id))
                    ->order_by('foc_id', 'desc')
                    ->get('bio_order_foc as f')
                    ->result_array();
        }else if($type == "lo"){
            $data = $this->db->select('
                    *, obd_qty_borrow as d_qty, obd_price as d_price, CONCAT(\'0\') as d_discount, 
                    CONCAT(\'-\') as d_free, obd_total as d_subtotal, 
                    ')
                    ->join('bio_order_borrow_detail d', 'b.ob_id = d.obd_ob_id', 'INNER')
                    ->join('bio_product p', 'p.product_id = d.obd_product_id', 'INNER')
                    ->join('bio_order o', 'o.order_id = b.ob_order_id', 'INNER')
                    ->where(array('ob_status' => 1, 'ob_order_id' => $id))
                    ->order_by('ob_id', 'desc')
                    ->get('bio_order_borrow as b')
                    ->result_array();
        }
        return @$data;
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
        if($arr['type'] == "so"){
            $where = array('order_list_order_id' => $arr['order_id']);
            $data = array(
                'order_list_approve' => $arr['order_approve'],
                'order_list_approve_date' => date('Y-m-d H:i:s'),
                'order_list_remark' => $arr['order_remark']
            );
            return $this->db->update('bio_order_list', $data, $where);
        }else if($arr['type'] == "foc"){
            $where = array('foc_order_id' => $arr['order_id']);
            $data = array(
                'foc_approve' => $arr['order_approve'],
                'foc_approve_date' => date('Y-m-d H:i:s'),
                'foc_remark' => $arr['order_remark']
            );
            return $this->db->update('bio_order_foc', $data, $where);
        }else if($arr['type'] == "lo"){
            $where = array('ob_order_id' => $arr['order_id']);
            $data = array(
                'ob_approve' => $arr['order_approve'],
                'ob_approve_date' => date('Y-m-d H:i:s'),
                'ob_remark' => $arr['order_remark']
            );
            return $this->db->update('bio_order_borrow', $data, $where);
        }
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
                if($item['d_type'] == 'so'){
                    $approve += ($item['d_approve'] == 1) ? $this->order_total_price_so($item['d_oid']) : 0;
                    $total += $this->order_total_price_so($item['d_oid']);
                }else if($item['d_type'] == 'lo'){
                    $approve += ($item['d_approve'] == 1) ? $this->order_total_price_lo($item['d_oid']) : 0;
                    $total += $this->order_total_price_lo($item['d_oid']);
                }
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
    
    public function customer_list($id = '') {
        if(!empty($id)){
            $this->db->where('customer_id', $id);
        }
        return $this->db->where(array('customer_status' => 1, 'customer_approve' => 1))
                        ->get('bio_customer')
                        ->result_array();
    }
    
    public function member_sale_list() {
        return $this->db->select('*')
                        ->join('bio_zone as z', 'z.zone_id = m.FK_zone_id', 'INNER')
                        ->where(array('member_status' => 1, 'FK_level_id' => 3, 'zone_status' => 1))
                        ->get('bio_member as m')
                        ->result_array();
    }
    
    public function price_product($val) {
        if($val['cus'] == 1){
            $this->session->unset_userdata('order_add_admin');
        }
        $query = $this->db->where(array('rate_product_id' => $val['pid'], 'rate_customer_id' => $val['cid']))->get('bio_product_rateprice as r')->first_row('array');
        $price_unit = @$query['rate_price'];
        $check_unit = 0;
        if($this->session->userdata('order_add_admin')){
            $array['order_add_admin'] = $this->session->userdata('order_add_admin');
            foreach($array['order_add_admin'] as $key_plus => $rs_plus){
                $price_cus = $this->db->where(array('rate_product_id' => $rs_plus['pid'], 'rate_customer_id' => $val['cid']))->get('bio_product_rateprice as r')->first_row('array');
                if($rs_plus['pid'] == $val['pid']){
                    $price_unit = @$rs_plus['price'];
                    $check_unit = 1;
                }
            }
            $this->session->set_userdata($array);
        }
        
//        return @$query['rate_price'].'##'.$this->show_order_dummy();
        return @$price_unit.'##'.$check_unit.'##'.$this->show_order_dummy();
    }
    
    public function add_product($val) {
        $check = 0;
        $array['order_add_admin'] = $this->session->userdata('order_add_admin');
        if(!empty($array['order_add_admin'])){
            foreach($array['order_add_admin'] as $key_plus => $rs_plus){
                if($rs_plus['pid'] == $val['pid'] && $rs_plus['type'] == $val['type']){
                    $array['order_add_admin'][$key_plus]['qty'] += $val['qty'];
                    if($array['order_add_admin'][$key_plus]['qty'] <= 0){
                        unset($array['order_add_admin'][$key_plus]);
                    }
                    $check = 1;
                }
            }
        }
        if($check == 0 && $val['qty'] > 0){
            $array['order_add_admin'][] = $val;
        }
        $this->session->set_userdata($array);
        return $this->show_order_dummy($val);
    }
    
    public function change_discount($val) {
        $array['order_add_admin'] = $this->session->userdata('order_add_admin');
        if($this->session->userdata('order_add_admin')){
            foreach($array['order_add_admin'] as $key_plus => $rs_plus){
                $array['order_add_admin'][$key_plus]['discount'] = $val['discount'];
            }
        }
        $this->session->set_userdata($array);
        return $this->show_order_dummy($val);
    }
    
    public function show_order_dummy($val = '') {
        $alltotal = $noitem = $alldiscount = $normal = $extra_s = $extra_td = 0;
        $customer = $this->customer_list(@$val['cus']);
        if($this->session->userdata('order_add_admin')){
            $session['order_add_admin'] = $this->session->userdata('order_add_admin');
            foreach($session['order_add_admin'] as $key_data => $rs_data){
                $product = $this->data_product($rs_data['pid']);
                if($rs_data['type'] == 'so'){
                    $free = (!empty($product['free_id']))?floor($rs_data['qty']/$product['qty_free'])*$product['free']:0;
                    $total = ($rs_data['qty']*$rs_data['price']);
                    $discount = 0;
                    if(!empty($rs_data['discount']) && $rs_data['discount'] > 0){
                        $discount = ($total*$rs_data['discount'])/100;
//                        $alldiscount += ($total*$rs_data['discount'])/100;
                    }
                    $subtotal = $total-$discount;
                    $alltotal += $subtotal;
                    $session['order_add_admin'][$key_data] = array_merge($session['order_add_admin'][$key_data], array('free' => $free));
                    if(@$customer[0]['customer_rebate_extra_s'] > 0 && $product['product_type_rebate'] == 1){
                        $extra_s += ($subtotal*$customer[0]['customer_rebate_extra_s'])/100;
                    }
                    if(@$customer[0]['customer_rebate_extra_td'] > 0 && $product['product_type_rebate'] == 2){
                        $extra_td += ($subtotal*$customer[0]['customer_rebate_extra_td'])/100;
                    }
                }else if($rs_data['type'] == 'lo'){
                    $free = (!empty($product['free_id']))?floor($rs_data['qty']/$product['qty_free'])*$product['free']:0;
                    $total = ($rs_data['qty']*$rs_data['price']);
                    $subtotal = $total;
                    $alltotal += $subtotal;
                    $session['order_add_admin'][$key_data] = array_merge($session['order_add_admin'][$key_data], array('free' => 0));
                }else{
                    $free = $total = $free = $subtotal = 'F.O.C';
                    $session['order_add_admin'][$key_data] = array_merge($session['order_add_admin'][$key_data], array('free' => 0));
                }
                @$data .= '
                    <tr>
                        <td class="text-center"><a style="cursor: pointer;"><i class="fa fa-trash-o fa-lg text-danger" data-content="type='.$rs_data['type'].'&pid='.$rs_data['pid'].'" data-url="'.base_url('sitecontrol/order/del_product').'"> </i></a></td>
                        <td class="text-center">'.$product['product_code'].'</td>
                        <td class="text-center">'.$product['product_name'].'</td>
                        <td class="text-center">'.number_format($rs_data['qty']).'</td>
                        <td class="text-center">'.number_format($rs_data['price'],2).'</td>
                        <td class="text-center">'.$free.'</td>
                        <td class="text-center">'.(($rs_data['type'] == 'foc')?$subtotal:number_format($subtotal,2)).'</td>
                    </tr>
                ';
            }
        $alltotal = $alltotal-$alldiscount;
        $beforetotal = ($alltotal*100)/107;
        $vat = $alltotal-$beforetotal;
        $this->session->set_userdata($session);
        if($customer[0]['customer_rebate_normal'] > 0){
            $normal = ($alltotal*$customer[0]['customer_rebate_normal'])/100;
        }
        $grand_total = ($alltotal-$normal-$extra_s-$extra_td);
//        $this->session->unset_userdata('order_add_admin');
        }else{
            $noitem = 1;
            $data = '<tr><td colspan="8" class="text-center">No data</td></tr>';
        }
        
        return @$data.'##'.number_format(@$beforetotal,2).'##'.number_format(@$vat,2).'##'.number_format(@$grand_total,2).'##'.$noitem.'##'.number_format($normal,2).'##'.number_format($extra_s,2).'##'.number_format($extra_td,2);
    }
    
    public function data_product($id) {
        return $this->db->join('bio_free as f', 'f.FK_product_id = p.product_id', 'LEFT')->where('product_id', $id)->get('bio_product as p')->first_row('array');
    }
    
    public function del_product($val) {
        $check = '';
        $array['order_add_admin'] = $this->session->userdata('order_add_admin');
        foreach(@$this->session->userdata('order_add_admin') as $key_plus => $rs_plus){
            if($rs_plus['pid'] == $val['pid'] && $rs_plus['type'] == $val['type']){
                unset($array['order_add_admin'][$key_plus]);
            }
        }
        $this->session->set_userdata($array);
        return $this->show_order_dummy($val);
    }

    
    public function insert($val) {
        $this->db->trans_begin();
        $date = explode('/', $val['order_date']);
        $delivery = explode('/', $val['date_delivery']);
        $date_order_add = $date[2].'-'.$date[1].'-'.$date[0].date(' H:i:s');
        $date_delivery= $delivery[2].'-'.$delivery[1].'-'.$delivery[0];
        $data_update = array('order_status' => 1);
        $data_order = array(
            'FK_member_id' => $val['FK_member_id'],
            'FK_customer_id' => $val['FK_customer_id'],
            'FK_zone_id' => $val['FK_zone_id'],
            'order_date_create' => $date_order_add,
            'order_status' => 1,
            'order_discount' => $val['discount'],
            'order_rebate_normal' => $val['re_normal'],
            'order_rebate_extra_s' => $val['re_ext_s'],
            'order_rebate_extra_td' => $val['re_ext_td'],
        );
        $this->db->insert('bio_order', $data_order);
        $oid = $this->db->insert_id();
        $sale_detail = $this->member_detail($val['FK_member_id']);
        $customer = $this->customer_list($val['FK_member_id']);
        $body_mail  = ' ถึงผู้ดูแลระบบ <br/>';
        $body_mail .= ' ผู้ดำเนินการ '.$sale_detail['member_name'].'<br/>';
        $body_mail .= $customer[0]['customer_name'].' ได้ทำการสั่งซื้อสินค้า  <br/>';
        
        $data_customer = array(
            'customer_taxid' => $val['customer_taxid'],
            'customer_delivery' => $val['customer_delivery'],
        );
        $this->db->update('bio_customer', $data_customer, array('customer_id' => $val['FK_customer_id']));
        if($this->session->userdata('order_add_admin')){
            foreach($this->session->userdata('order_add_admin') as $rs_product){
                if($rs_product['type'] == 'so'){
                    $product_so[] = $rs_product;

                }else if($rs_product['type'] == 'foc'){
                    $product_foc[] = $rs_product;

                }else if($rs_product['type'] == 'lo'){
                    $product_lo[] = $rs_product;

                }
            }
        }
        $total = $before_total = $normal = $extra_s = $extra_td = 0;
        if(!empty($product_so)){
            $so_code = $this->model_utility->gen_code_so();
            $data_order_list = array(
                'order_list_order_id' => $oid,
                'order_list_code' => $so_code,
                'order_list_date' => $date_order_add,
                'order_list_remark' => $val['order_remark'],
                'order_list_free' => 0,
                'order_list_receipt_date' => $val['date_receipt'],
                'order_list_date_delivery' => '$date_delivery',
                'order_list_status' => 1,
            );
            $this->db->insert('bio_order_list', $data_order_list);
            $so_id = $this->db->insert_id();
            
            $body_mail .= 'หมายเลขการสั่งซื้อ '.$so_code.'<br/>';
            $body_mail .= 'วันที่สั่งซื้อ '.$date_order_add.'<br/>';
            $body_mail .= '
                <table>
                    <tr>
                        <td>Code</td>
                        <td>Product</td>
                        <td>Quantity</td>
                        <td>Price/Unit(Baht)</td>
                        <td>Free</td>
                        <td>Total(Baht)</td>
                    </tr>
            ';
            
            $data_update = array_merge($data_update, array('order_list_code' => $so_code));
            foreach($product_so as $rs_so){
                $subtotal = ($rs_so['price']*$rs_so['qty'])-((($rs_so['price']*$rs_so['qty'])*$rs_so['discount'])/100);
                $data_order_list_detail = array(
                    'ldetail_order_list_id' => $so_id,
                    'ldetail_product_id' => $rs_so['pid'],
                    'ldetail_type' => '',
                    'ldetail_qty' => $rs_so['qty'],
                    'ldetail_price' => $rs_so['price'],
                    'ldetail_discount' => $rs_so['discount'],
                    'ldetail_subtotal' => $subtotal,
                    'ldetail_free' => $rs_so['free'],
                    'ldetail_status' => 1,
                );
                $this->db->insert('bio_order_list_detail', $data_order_list_detail);
                
                $total += $subtotal;
                $product = @$this->data_product(@$rs_so['pid']);
                $body_mail .= '
                    <tr>
                        <td>'.@$product['product_code'].'</td>
                        <td>'.@$product['product_name'].'</td>
                        <td>'.@$rs_so['qty'].'</td>
                        <td>'.@$rs_so['price'].'</td>
                        <td>'.@$rs_so['free'].'</td>
                        <td>'.@$subtotal.'</td>
                    </tr>
                ';
                if($product['product_type_rebate'] == 1 && $val['re_ext_s'] > 0){
                    $extra_s += ((@$subtotal*$val['re_ext_s'])/100);
                }
                if($product['product_type_rebate'] == 2 && $val['re_ext_td'] > 0){
                    $extra_td += ((@$subtotal*$val['re_ext_td'])/100);
                }
            }
        }
        if(!empty($product_foc)){
            $foc_code = $this->model_utility->gen_code_foc();
            $data_order_foc = array(
                'foc_order_id' => $oid,
                'foc_code' => $foc_code,
                'foc_date' => $date_order_add,
                'foc_remark' => $val['order_remark'],
                'foc_receipt_date' => $val['date_receipt'],
                'foc_date_delivery' => '$date_delivery',
                'foc_status' => 1,
            );
            $this->db->insert('bio_order_foc', $data_order_foc);
            $foc_id = $this->db->insert_id();
            
            $body_mail .= 'หมายเลขการสั่งซื้อ '.$foc_code.'<br/>';
            $body_mail .= 'วันที่สั่งซื้อ '.$date_order_add.'<br/>';
            $body_mail .= '
                <table>
                    <tr>
                        <td>Code</td>
                        <td>Product</td>
                        <td>Quantity</td>
                        <td>Price/Unit(Baht)</td>
                        <td>Free</td>
                        <td>Total(Baht)</td>
                    </tr>
            ';
            
            $data_update = array_merge($data_update, array('order_foc_code' => $foc_code));
            foreach($product_foc as $rs_foc){
                $subtotal = ($rs_foc['price']*$rs_foc['qty'])-((($rs_foc['price']*$rs_foc['qty'])*$rs_foc['discount'])/100);
                $data_order_foc_detail = array(
                    'fdetail_foc_id' => $foc_id,
                    'fdetail_product_id' => $rs_foc['pid'],
                    'fdetail_qty' => $rs_foc['qty'],
                    'fdetail_status' => 1,
                );
                $this->db->insert('bio_order_foc_detail', $data_order_foc_detail);
                
                $product = @$this->data_product(@$rs_foc['pid']);
                $body_mail .= '
                    <tr>
                        <td>'.@$product['product_code'].'</td>
                        <td>'.@$product['product_name'].'</td>
                        <td>'.@$rs_foc['qty'].'</td>
                        <td>F.O.C</td>
                        <td>F.O.C</td>
                        <td>F.O.C</td>
                    </tr>
                ';
            }
        }
        if(!empty($product_lo)){
            $lo_code = $this->model_utility->gen_code_lo();
            $data_order_borrow = array(
                'ob_order_id' => $oid,
                'ob_code' => $lo_code,
                'ob_date' => $date_order_add,
                'ob_remark' => $val['order_remark'],
                'ob_receipt_date' => $val['date_receipt'],
                'ob_date_delivery' => '$date_delivery',
                'ob_status' => 1,
            );
            $this->db->insert('bio_order_borrow', $data_order_borrow);
            $lo_id = $this->db->insert_id();
            
            $body_mail .= 'หมายเลขการสั่งซื้อ '.$lo_code.'<br/>';
            $body_mail .= 'วันที่สั่งซื้อ '.$date_order_add.'<br/>';
            $body_mail .= '
                <table>
                    <tr>
                        <td>Code</td>
                        <td>Product</td>
                        <td>Quantity</td>
                        <td>Price/Unit(Baht)</td>
                        <td>Free</td>
                        <td>Total(Baht)</td>
                    </tr>
            ';
            
            
            $data_update = array_merge($data_update, array('order_borrow_code' => $lo_code));
            foreach($product_lo as $rs_lo){
                $subtotal = ($rs_lo['price']*$rs_lo['qty'])-((($rs_lo['price']*$rs_lo['qty'])*$rs_lo['discount'])/100);
                $data_order_borrow_detail = array(
                    'obd_ob_id' => $lo_id,
                    'obd_product_id' => $rs_lo['pid'],
                    'obd_qty_borrow' => $rs_lo['qty'],
                    'obd_price' => $rs_lo['price'],
                    'obd_total' => $subtotal,
                    'obd_status' => 1,
                );
                $this->db->insert('bio_order_borrow_detail', $data_order_borrow_detail);
                
                $total += $subtotal;
                $product = @$this->data_product(@$rs_lo['pid']);
                $body_mail .= '
                    <tr>
                        <td>'.@$product['product_code'].'</td>
                        <td>'.@$product['product_name'].'</td>
                        <td>'.@$rs_lo['qty'].'</td>
                        <td>'.@$rs_lo['price'].'</td>
                        <td>'.@$rs_lo['free'].'</td>
                        <td>'.@$subtotal.'</td>
                    </tr>
                ';
            }
        }
        $this->db->update('bio_order', $data_update, array('order_id' => $oid));
        
        $before_total += (($total*100)/107);
        $normal += (($total*$val['re_normal'])/100);
        $body_mail .= '
            <tr>
                <td colspan="5" align="right">'.((@$val['discount'])?'( '.@$val['discount'].'% )':'').' Discount :</td>
                <td>'.number_format((($total*@$val['discount'])/100),2).' Baht</td>
            </tr>
            <tr>
                <td colspan="5" align="right"> Sub Total :</td>
                <td>'.number_format($before_total,2).' Baht</td>
            </tr>
            <tr>
                <td colspan="5" align="right"> Vat(7%) :</td>
                <td>'.number_format(($total-$before_total),2).' Baht</td>
            </tr>
            <tr>
                <td colspan="5" align="right"> Total Price :</td>
                <td>'.number_format($total,2).' Baht</td>
            </tr>
            <tr>
                <td colspan="5" align="right"> Rebate Normal (-) :</td>
                <td>'.number_format($normal,2).' Baht</td>
            </tr>
            <tr>
                <td colspan="5" align="right"> Rebate Extra(S) (-) :</td>
                <td>'.number_format($extra_s,2).' Baht</td>
            </tr>
            <tr>
                <td colspan="5" align="right"> Rebate Extra(TD) (-) :</td>
                <td>'.number_format($extra_td,2).' Baht</td>
            </tr>
            <tr>
                <td colspan="5" align="right"> Grand Price :</td>
                <td>'.number_format(($total-$normal-$extra_s-$extra_td),2).' Baht</td>
            </tr>
            </table>
            ท่านสามารถทำการ Approve ได้โดยการ <a href="'.base_url('sitecontrol/order/approve/'.$oid.'').'">คลิกที่นี่</a> 
            หรือ ท่านสามารถทำการ Reject ได้โดยการ <a href="'.base_url('sitecontrol/order/reject/'.$oid.'').'">คลิกที่นี่</a> <br/>
        ';
        $this->send_mail_submit_order($body_mail);
        
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
            $this->session->unset_userdata('order_add_admin');
            return 1;
        }
    }
    
    public function detail_customer($val){
        $query = $this->db->where('customer_id', $val['cid'])->get('bio_customer')->row();
        return $query->customer_taxid.'##'.$query->FK_zone_id.'##'.$query->customer_rebate_normal.'##'.$query->customer_rebate_extra_s.'##'.$query->customer_rebate_extra_td;
    }
    
    public function approve_for_mail(){
        $id = $this->uri->segment(4);
        $check_so_dup = $this->db->where(array('order_list_order_id' => $id, 'order_list_approve' => 0))->get('bio_order_list')->num_rows();   
        $check_foc_dup = $this->db->where(array('foc_order_id' => $id, 'foc_approve' => 0))->get('bio_order_foc')->num_rows();   
        $check_lo_dup = $this->db->where(array('ob_order_id' => $id, 'ob_approve' => 0))->get('bio_order_borrow')->num_rows();   
        if($check_so_dup > 0){
            $this->db->update('bio_order_list', array('order_list_approve' => 1, 'order_list_approve_date' => date('Y-m-d H:i:s')), array('order_list_order_id' => $id));
        }
        if($check_foc_dup > 0){
            $this->db->update('bio_order_foc', array('foc_approve' => 1, 'foc_approve_date' => date('Y-m-d H:i:s')), array('foc_order_id' => $id));
        }
        if($check_lo_dup){
            $this->db->update('bio_order_borrow', array('ob_approve' => 1, 'ob_approve_date' => date('Y-m-d H:i:s')), array('ob_order_id' => $id));
        }
        $check_so = $this->db->where('order_list_order_id', $id)->get('bio_order_list')->num_rows();    
        $check_foc = $this->db->where('foc_order_id', $id)->get('bio_order_foc')->num_rows();    
        $check_lo = $this->db->where('ob_order_id', $id)->get('bio_order_borrow')->num_rows();    
        if($check_so > 0){
            echo "<script>alert('Approve Success !');window.location='".base_url('sitecontrol/order/edit/so/'.$id.'/mail')."'</script>";
            exit();
        }else if($check_foc > 0){
            echo "<script>alert('Approve Success !');window.location='".base_url('sitecontrol/order/edit/foc/'.$id.'/mail')."'</script>";
            exit();
        }else if($check_lo > 0){
            echo "<script>alert('Approve Success !');window.location='".base_url('sitecontrol/order/edit/lo/'.$id.'/mail')."'</script>";
            exit();
        }
    }
    
    public function reject_for_mail(){
        $id = $this->uri->segment(4);
        $check_so_dup = $this->db->where(array('order_list_order_id' => $id, 'order_list_approve' => 0))->get('bio_order_list')->num_rows();   
        $check_foc_dup = $this->db->where(array('foc_order_id' => $id, 'foc_approve' => 0))->get('bio_order_foc')->num_rows();   
        $check_lo_dup = $this->db->where(array('ob_order_id' => $id, 'ob_approve' => 0))->get('bio_order_borrow')->num_rows();
        if($check_so_dup > 0){
            $this->db->update('bio_order_list', array('order_list_approve' => 2, 'order_list_approve_date' => date('Y-m-d H:i:s')), array('order_list_order_id' => $id));
        }
        if($check_foc_dup > 0){
            $this->db->update('bio_order_foc', array('foc_approve' => 2, 'foc_approve_date' => date('Y-m-d H:i:s')), array('foc_order_id' => $id));
        }
        if($check_lo_dup){
            $this->db->update('bio_order_borrow', array('ob_approve' => 2, 'ob_approve_date' => date('Y-m-d H:i:s')), array('ob_order_id' => $id));
        }
        $check_so = $this->db->where('order_list_order_id', $id)->get('bio_order_list')->num_rows();    
        $check_foc = $this->db->where('foc_order_id', $id)->get('bio_order_foc')->num_rows();    
        $check_lo = $this->db->where('ob_order_id', $id)->get('bio_order_borrow')->num_rows();    
        if($check_so > 0){
            echo "<script>alert('Reject Success !');window.location='".base_url('sitecontrol/order/edit/so/'.$id.'/mail')."'</script>";
            exit();
        }else if($check_foc > 0){
            echo "<script>alert('Reject Success !');window.location='".base_url('sitecontrol/order/edit/foc/'.$id.'/mail')."'</script>";
            exit();
        }else if($check_lo > 0){
            echo "<script>alert('Reject Success !');window.location='".base_url('sitecontrol/order/edit/lo/'.$id.'/mail')."'</script>";
            exit();
        }
    }

    private function send_mail_submit_order($val) {
        
        $mail = array(
            'from' => 'Biovalys System ',
            'to' => 'supachai@genetic-plus.com',
            'cc' => 'kittithouch@genetic-plus.com',
            'subject' => 'Submit Order for Sales',
            'message' => $val
        );
        $this->model_utility->send_mail($mail);
    }
    
    private function member_detail($id){
        return $this->db->where('member_id', $id)->get('bio_member')->first_row('array');
    }
}
