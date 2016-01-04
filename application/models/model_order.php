<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class model_order extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function list_order($arr = '') {  // list order main
        $where = array('o.FK_member_id' => $this->model_utility->member_id(), 'order_status !=' => 2);
        $search = $this->session->userdata('order');
        if (isset($arr) && !empty($arr)) {
            $this->db->limit($arr['limit'], $arr['start']);
        }
        if (isset($search) && !empty($search)) {
            if (isset($search['name']) && $search['name'] <> '') {
                $where_or = "(
                    customer_name LIKE '%" . $search["name"] . "%' OR
                    order_foc_code LIKE '%" . $search["name"] . "%' OR
                    order_list_code LIKE '%" . $search["name"] . "%' OR
                    order_borrow_code LIKE '%" . $search["name"] . "%'
                )";
                $this->db->where($where_or, NULL, FALSE);
            }
        }
        $this->db->join('bio_customer c', 'c.customer_id=o.FK_customer_id', 'LEFT');
        $data = $this->db->select('*')->from('bio_order o')->where($where)->order_by('order_id', 'desc')->get()->result_array();
        return $data;
    }

    public function list_data_order($id) { // get sub order show SO , FOC , BORROW
        $type = array('0' => 'warning', '1' => 'success', '2' => 'danger');
        $text = array('0' => 'Warning', '1' => 'Approve', '2' => 'Reject');
        $icon = array('0' => '<i class="fa fa-star"></i>', '1' => '<i class="fa fa-check"></i>', '2' => '<i class="fa fa-times"></i>');

        $sow = array('order_list_order_id' => $id); // SO
        $SO = $this->bio_order_list_data($sow);
        $SO = (!empty($SO)) ? '<div class="row"><div class="col-xs-12"><a href="' . base_url('order/so/' . $SO[0]['order_list_id']) . '" class="btn col-xs-12 btn-' . $type[$SO[0]['order_list_approve']] . '" style="color:#FFF;">' . $icon[$SO[0]['order_list_approve']] . ' ' . $SO[0]['order_list_code'] . ' ' . $text[$SO[0]['order_list_approve']] . '</a></div></div><br>' : '';

        $focw = array('foc_order_id' => $id); // FOC
        $FOC = $this->bio_order_foc_data($focw);
        $FOC = (!empty($FOC)) ? '<div class="row"><div class="col-xs-12"><a href="' . base_url('order/foc/' . $FOC[0]['foc_id']) . '" class="btn col-xs-12 btn-' . $type[$FOC[0]['foc_approve']] . '" style="color:#FFF;">' . $icon[$FOC[0]['foc_approve']] . ' ' . $FOC[0]['foc_code'] . ' ' . $text[$FOC[0]['foc_approve']] . '</a></div></div><br>' : '';

        $low = array('ob_order_id' => $id); // BORROW
        $LO = $this->bio_order_borrow_data($low);
        $LO = (!empty($LO)) ? '<div class="row"><div class="col-xs-12"><a href="' . base_url('order/lo/' . $LO[0]['ob_id']) . '"class="btn col-xs-12 btn-' . $type[$LO[0]['ob_approve']] . '" style="color:#FFF;">' . $icon[$LO[0]['ob_approve']] . ' ' . $LO[0]['ob_code'] . ' ' . $text[$LO[0]['ob_approve']] . '</a></div></div><br>' : '';

        $arr = array('so' => $SO, 'foc' => $FOC, 'lo' => $LO);
        return $arr;
    }

    private function bio_order_list_data($arr) { // get data table bio_order_list
        return $this->db->select('*')->from('bio_order_list')->where($arr)->get()->result_array();
    }

    private function bio_order_foc_data($arr) { // get data table bio_order_foc
        return $this->db->select('*')->from('bio_order_foc')->where($arr)->get()->result_array();
    }

    private function bio_order_borrow_data($arr) { // get data table bio_order_borrow
        return $this->db->select('*')->from('bio_order_borrow')->where($arr)->get()->result_array();
    }

    public function order_data($arr) {
        $this->db->join('bio_customer c', 'c.customer_id=o.FK_customer_id', 'LEFT');
        $data = $this->db->select('*')->from('bio_order o')->where($arr)->order_by('order_id', 'desc')->get()->result_array();
        return $data;
    }

    public function order_detail($arr) {
        $this->db->join('bio_product p', 'p.product_id=o.FK_product_id', 'LEFT');
        $data = $this->db->select('*')->from('bio_order_list o')->where($arr)->order_by('order_list_id', 'desc')->get()->result_array();
        return $data;
    }

    public function order_foc($arr) { // get free product
        $this->db->join('bio_product p', 'p.product_id=o.foc_product_id', 'LEFT');
        $data = $this->db->select('*')->from('bio_free_of_charge o')->where($arr)->order_by('foc_id', 'desc')->get()->result_array();
        return $data;
    }

    public function customer_data($id) {
        return $this->db->where(array('customer_id' => $id))->get('bio_customer')->first_row('array');
    }

    public function save_order($arr) { // save order ALL CA
        $call = false;
        $this->db->trans_begin();
        if (isset($arr['new']) && !empty($arr['new']) && $arr['new'] == 1) { // new CA order set price product
            $this->load->model('model_product');
            $this->model_product->set_product_value($arr);
        }
        $member = $this->session->userdata('member_data');
        $customer = $this->customer_data($arr['customer_id']);
        $main = array(
            'FK_member_id' => $member['member_id'],
            'FK_zone_id' => $member['FK_zone_id'],
            'FK_customer_id' => $arr['customer_id'],
            'order_date_create' => date('Y-m-d H:i:s'),
            'order_discount' => $arr['discount'],
            'order_rebate_normal' => $customer['customer_rebate_normal'],
            'order_rebate_extra_s' => $customer['customer_rebate_extra_s'],
            'order_rebate_extra_td' => $customer['customer_rebate_extra_td'],
            'order_date_delivery' => $this->convert_date($arr['delivery']),
            'order_contact_date' => $arr['time_receipt'],
            'order_contact_name' => $arr['contact_name'],
            'order_contact_dep' => $arr['contact_dep'],
            'order_contact_tel' => $arr['contact_tel'],
            'order_card_tear' => $arr['card_tear'],
            'order_status' => 1
        );
        $this->db->insert('bio_order', $main);
        $id = $this->db->insert_id();
        // Body mail
        $arr = array_merge($arr, array(
            'order_rebate_normal' => $customer['customer_rebate_normal'],
            'order_rebate_extra_s' => $customer['customer_rebate_extra_s'],
            'order_rebate_extra_td' => $customer['customer_rebate_extra_td'],
        ));
        $body_mail  = ' ถึงผู้ดูแลระบบ <br/>';
        $body_mail .= ' ผู้ดำเนินการ '.$member['member_name'].'<br/>';
        $body_mail .= $customer['customer_name'].' ได้ทำการสั่งซื้อสินค้า  <br/>';
        
        // update last discount
        $this->db->update('bio_customer', array('customer_last_discount' => @$arr['discount'], 'customer_taxid' => @$arr['tax_id']), array('customer_id' => $arr['customer_id']));
        $arr = array_merge($arr,
            array('id' => $id)
        );
        $res = $this->order_detail_save($arr,$body_mail);
        if ($res['order_foc_code'] == '' && $res['order_list_code'] == '' && $res['order_borrow_code'] == '') {
            $this->db->trans_rollback();
        } else {
            $where = array('order_id' => $id);
            $this->db->update('bio_order', $res, $where);
            $this->db->trans_commit();
            $call = true;
        }
        return $call;
    }

    private function order_detail_save($arr, $body_mail) { // insert detail order SO LO Borrow
        $so_id = $foc_id = $lo_id = $FOCID = $SOID = $LOID = '';
        $cart = $this->cart->contents();
        $date = date('Y-m-d H:i:s');
        $delivery = $this->convert_date($arr['delivery']);
        $type_order = $this->check_type_order($cart, $arr['customer_id']);
        if (isset($type_order[1]) && !empty($type_order[1])) { // insert SO main
            $SOID = $this->order_number();
            $SO = array('order_list_order_id' => $arr['id'], 'order_list_code' => $SOID, 'order_list_date' => $date, 'order_list_status' => 1, 'order_list_free' => $type_order[1]['free'], 'order_list_date_delivery' => $delivery);
            $this->db->insert('bio_order_list', $SO);
            $so_id = $this->db->insert_id();
        }
        if (isset($type_order[2]) && !empty($type_order[2])) { // insert FOC main
            $FOCID = $this->gen_code_foc();
            $FOC = array('foc_order_id' => $arr['id'], 'foc_code' => $FOCID, 'foc_date' => $date, 'foc_status' => 1, 'foc_date_delivery' => $delivery);
            $this->db->insert('bio_order_foc', $FOC);
            $foc_id = $this->db->insert_id();
        }
        if (isset($type_order[3]) && !empty($type_order[3])) { // insert LO main
            $LOID = $this->gen_code_lo();
            $LO = array('ob_order_id' => $arr['id'], 'ob_code' => $LOID, 'ob_date' => $date, 'ob_status' => 1, 'ob_qty_borrow' => $type_order[3]['qty'], 'ob_date_delivery' => $delivery);
            $this->db->insert('bio_order_borrow', $LO);
            $lo_id = $this->db->insert_id();
        }
        $body_mail .= 'หมายเลขการสั่งซื้อ '.@$SOID.((!empty($SOID) && !empty($LOID))?',':'').@$LOID.(((!empty($SOID) && !empty($FOCID)) || ((!empty($LOID) && !empty($FOCID))))?',':'').@$FOCID.'<br/>';
        $body_mail .= 'วันที่สั่งซื้อ '.$date.'<br/>';
        
        $detail = array('so' => $so_id, 'foc' => $foc_id, 'lo' => $lo_id);
        $this->insert_detail_order($cart, $detail, $arr, @$arr['discount'], $body_mail); // insert detail all order
        $return = array('order_foc_code' => $FOCID, 'order_list_code' => $SOID, 'order_borrow_code' => $LOID); // return code for update main order
        
        return $return;
    }

    private function check_type_order($data, $customer) { // check type order 1=SO,2=FOC,3=LO
        $free1 = $qty1 = $qty2 = 0;
        if (isset($data) && !empty($data)) {
            foreach ($data as $row) {
                if ($row['customer'] == $customer) {
                    if ($row['type'] == 1) { // SO
                        $free1 += $row['free'];
                        $qty1 += $row['qty'];
                        $arr[1] = array('free' => $free1, 'qty' => $qty1);
                    }
                    if ($row['type'] == 2) { // FOC
                        $arr[2] = array('return' => true);
                    }
                    if ($row['type'] == 3) { // LO
                        $qty2 += $row['qty'];
                        $arr[3] = array('qty' => $qty2);
                    }
                }
            }
        }
        return $arr;
    }

    private function insert_detail_order($cart, $arr, $val, $disc, $body_mail) { // insert detail data ALL SO , FOC ,LO
        $total = $before_total = $defailt_total = $normal = $extra_s = $extra_td = 0;
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
        if (isset($cart) && !empty($cart)) {
            foreach ($cart as $item) {
                if ($item['customer'] == $val['customer_id']) {
                    $this->check_price_late($item['prod'], $item['customer'], $item['ori_price']);
                    if ($item['type'] == 1 && $arr['so'] <> '') { // insert SO detail
                        if (!empty($disc) && $disc > 0) {
                            $item['subtotal'] = ($item['subtotal'] - (($item['subtotal'] * $disc) / 100));
                        }
                        $so_detail = array('ldetail_order_list_id' => $arr['so'], 'ldetail_product_id' => $item['prod'], 'ldetail_type' => $item['type'], 'ldetail_qty' => $item['qty'], 'ldetail_price' => $item['ori_price'], 'ldetail_discount' => @$disc, 'ldetail_subtotal' => $item['subtotal'], 'ldetail_free' => $item['free'], 'ldetail_status' => 1);
                        $this->db->insert('bio_order_list_detail', $so_detail);
                    }
                    if ($item['type'] == 2 && $arr['foc'] <> '') { // insert FOC detail
                        $foc_detail = array('fdetail_foc_id' => $arr['foc'], 'fdetail_product_id' => $item['prod'], 'fdetail_qty' => $item['qty'], 'fdetail_status' => 1);
                        $this->db->insert('bio_order_foc_detail', $foc_detail);
                    }
                    if ($item['type'] == 3 && $arr['lo'] <> '') { // insert LO detail
                        $lo_detail = array('obd_ob_id' => $arr['lo'], 'obd_product_id' => $item['prod'], 'obd_qty_borrow' => $item['qty'], 'obd_price' => $item['ori_price'], 'obd_total' => $item['subtotal'], 'obd_status' => 1);
                        $this->db->insert('bio_order_borrow_detail', $lo_detail);
                    }
                    $product = @$this->product_detail(@$item['prod']);
                    if($product['product_type_rebate'] == 1 && $val['order_rebate_extra_s'] > 0){
                        $extra_s += (@$item['subtotal']*$val['order_rebate_extra_s'])/100;
                    }
                    if($product['product_type_rebate'] == 2 && $val['order_rebate_extra_td'] > 0){
                        $extra_td += (@$item['subtotal']*$val['order_rebate_extra_td'])/100;
                    }
                    $body_mail .= '
                        <tr>
                            <td>'.@$product['product_code'].'</td>
                            <td>'.@$product['product_name'].'</td>
                            <td>'.@$item['qty'].'</td>
                            <td>'.@$item['ori_price'].'</td>
                            <td>'.@$item['free'].'</td>
                            <td>'.@$item['subtotal'].'</td>
                        </tr>
                    ';
                    
                    $total += @$item['subtotal'];
                    $defailt_total += (@$item['qty']*@$item['ori_price']);
                }
            }
            $before_total = (($total*100)/107);
            $normal = (($total*@$val['order_rebate_normal'])/100);
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
                ท่านสามารถทำการ Approve ได้โดยการ <a href="'.base_url('sitecontrol/order/approve/'.$val['id'].'').'">คลิกที่นี่</a> 
                หรือ ท่านสามารถทำการ Reject ได้โดยการ <a href="'.base_url('sitecontrol/order/reject/'.$val['id'].'').'">คลิกที่นี่</a> <br/>
            ';
        
        }
        $this->send_mail_submit_order($body_mail);
    }
    
    public function product_detail($id) {
        return $this->db->where('product_id', $id)->get('bio_product')->first_row('array');
    }

    public function check_price_late($pid, $cid, $price) {
        $check = $this->db->where(array('rate_product_id' => $pid, 'rate_customer_id' => $cid))->get('bio_product_rateprice')->num_rows();
        if ($check > 0) {
            $this->db->update('bio_product_rateprice', array('rate_price' => $price), array('rate_product_id' => $pid, 'rate_customer_id' => $cid));
        } else {
            $this->db->insert('bio_product_rateprice', array('rate_product_id' => $pid, 'rate_customer_id' => $cid, 'rate_price' => $price));
        }
    }

    public function order_number() { // gen SO number
        $year = date('y');
        $where = array('order_list_date >=' => date('Y') . '-01-01');
        $data = $this->db->select('order_list_code')->from('bio_order_list')->where($where)->order_by('order_list_id', 'desc')->limit(1, 0)->get()->result_array();
        if (isset($data) && !empty($data)) {
            if ($data[0]['order_list_code'] <> '') {
                $data = explode('SO' . $year, $data[0]['order_list_code']);
                $data = @$data[1];
            } else {
                $data = 0;
            }
        } else {
            $data = 0;
        }
        $data = 'SO' . $year . str_pad($data + 1, 5, "0", STR_PAD_LEFT);
        return $data;
    }

    public function add_cart($arr) { // add cart to session cart codeignetor
        if ($this->session->userdata('price_customer')) {
            $sess_pri = $this->session->userdata('price_customer');
            foreach ($sess_pri[$arr['customer']] as $key => $rs_spri) {
                if ($key == $arr['id']) {
                    $data['price_customer'][$arr['customer']][$key] = array(
                        'price' => $arr['price'],
                        'id' => $arr['id']
                    );
                } else {
                    $data['price_customer'][$arr['customer']][$key] = array(
                        'price' => @$rs_spri['price'],
                        'id' => $key
                    );
                }
            }
//            print_r(@$data);
            $this->session->set_userdata($data);
        } else {
            $data['price_customer'][$arr['customer']][$arr['id']] = array(
                'price' => $arr['price'],
                'id' => $arr['id']
            );
            $this->session->set_userdata($data);
        }
//        print_r($arr);
        if ($arr['type'] == 1) { // SO
            $arr = array_merge($arr, array('id' => 'SO' . $arr['id'] . 'CA' . $arr['customer'], 'price' => $arr['price'], 'discount' => 0, 'ori_price' => $arr['price'], 'prod' => $arr['id']));
        } elseif ($arr['type'] == 2) { // FOC
            $arr = array_merge($arr, array('id' => 'FOC' . $arr['id'] . 'CA' . $arr['customer'], 'discount' => 0, 'ori_price' => $arr['price'], 'prod' => $arr['id']));
        } else { // 3 LO
            $arr = array_merge($arr, array('id' => 'LO' . $arr['id'] . 'CA' . $arr['customer'], 'discount' => 0, 'ori_price' => $arr['price'], 'prod' => $arr['id'], 'price' => $arr['price']));
        }
        $this->cart->insert($arr);
//        print_r($this->session->userdata('cart_contents'));
//        print_r($arr);
        $count = 0;
        if ($this->cart->contents()) {
            foreach ($this->cart->contents() as $prod) {
                if ($prod['customer'] == $arr['customer']) {
                    $count += 1;
                }
            }
        }
        echo $count;
    }

    private function discount_cart($arr) { // discount function befor insert cart
        if (isset($arr) && !empty($arr)) {
            $data = $arr['price'] - ($arr['price'] * ($arr['discount'] / 100));
            return $data;
        }
    }

    public function gen_code_foc() { // gen foc code
        $year = date('y');
        $where = array('foc_date >' => date('Y') . '-01-01 00:00:00', 'foc_code !=' => '');
        $code = 'FOC';
        $data = $this->db->select('*')->from('bio_order_foc')->where($where)->limit(1, 0)->order_by('foc_id', 'desc')->get()->result_array();
        if (isset($data) && !empty($data)) {
            if ($data[0]['foc_code'] <> '') {
                $data = explode('FOC' . $year, $data[0]['foc_code']);
                $data = $data[1];
            } else {
                $data = 0;
            }
        } else {
            $data = 0;
        }
        return $code . $year . str_pad($data + 1, 5, "0", STR_PAD_LEFT);
    }

    public function gen_code_lo() { // gen foc code
        $year = date('y');
        $where = array('ob_date >' => date('Y') . '-01-01 00:00:00', 'ob_code !=' => '');
        $code = 'LO';
        $data = $this->db->select('*')->from('bio_order_borrow')->where($where)->limit(1, 0)->order_by('ob_id', 'desc')->get()->result_array();
        if (isset($data) && !empty($data)) {
            if ($data[0]['ob_code'] <> '') {
                $data = explode($code . $year, $data[0]['ob_code']);
                $data = $data[1];
            } else {
                $data = 0;
            }
        } else {
            $data = 0;
        }
        return $code . $year . str_pad($data + 1, 5, "0", STR_PAD_LEFT);
    }

    public function so_data_detail($arr) { // get data detail SO 
        $this->db->join('bio_product p', 'p.product_id=sol.ldetail_product_id', 'inner');
        $this->db->join('bio_order_list so', 'so.order_list_id=sol.ldetail_order_list_id', 'inner');
        $this->db->join('bio_order o', 'so.order_list_order_id=o.order_id', 'inner');
        $data = $this->db->select('*')->from('bio_order_list_detail sol')->where($arr)->get()->result_array();
        return $data;
    }

    public function foc_data_detail($arr) { // get data detail FOC
        $this->db->join('bio_product p', 'p.product_id=focl.fdetail_product_id', 'inner');
        $this->db->join('bio_order_foc foc', 'foc.foc_id=focl.fdetail_foc_id', 'inner');
        $data = $this->db->select('*')->from('bio_order_foc_detail focl')->where($arr)->get()->result_array();
        return $data;
    }

    public function lo_data_detail($arr) { // get data detail Borrow
        $this->db->join('bio_product p', 'p.product_id=lol.obd_product_id', 'inner');
        $this->db->join('bio_order_borrow lo', 'lo.ob_id=lol.obd_ob_id', 'inner');
        $data = $this->db->select('*')->from('bio_order_borrow_detail lol')->where($arr)->get()->result_array();
        return $data;
    }

    private function convert_date($data) {
        if ($data <> '') {
            $day = explode('/', $data);
            return $day[2] . '-' . $day[1] . '-' . $day[0];
        } else {
            return '';
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
    
    public function last_order($id){
        return $this->db->where(array('order_status' => 1, 'FK_customer_id' => $id))->order_by('order_id', 'DESC')->get('bio_order')->first_row('array');
    }
}
