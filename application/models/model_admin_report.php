<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class model_admin_report extends CI_Model {

    public function product_list() {
        return $this->db->select('*')->where('product_status', 1)->get('bio_product')->result_array();
    }

    public function mindate() {
        return $this->db->select('min(order_date_create) as date')->where(array('order_status' => 1))->get('bio_order')->result_array();
    }

    public function donut_chart() {
        $search = $this->session->userdata('search_date');

        //Donut Chart - Monthly Order
        $count_approve = 0;
        $count_reject = 0;
        $count_waiting = 0;
        
        $where_so = array("order_list_status" => 1);
        $where_foc = array("foc_status" => 1);
        $where_lo = array("ob_status" => 1);
        if(!empty($search['sdate'])){
            $where_so = array_merge($where_so,array('DATE_FORMAT(order_list_date,\'%m/%Y\') =' => $search['sdate']));
            $where_foc = array_merge($where_foc,array('DATE_FORMAT(foc_date,\'%m/%Y\') =' => $search['sdate']));
            $where_lo = array_merge($where_lo,array('DATE_FORMAT(ob_date,\'%m/%Y\') =' => $search['sdate']));
        }
        $donut_chart_so = $this->db->select("count(order_list_approve) as count_order, order_list_approve as approve")->where($where_so)->group_by("order_list_approve")->order_by("order_list_approve", "asc")->get('bio_order_list')->result_array();
        $donut_chart_foc = $this->db->select("count(foc_approve) as count_order, foc_approve as approve")->where($where_foc)->group_by("foc_approve")->order_by("foc_approve", "asc")->get('bio_order_foc')->result_array();
        $donut_chart_lo = $this->db->select("count(ob_approve) as count_order, ob_approve as approve")->where($where_lo)->group_by("ob_approve")->order_by("ob_approve", "asc")->get('bio_order_borrow')->result_array();
        
        foreach ($donut_chart_so as $dw) {
            if ($dw['approve'] == 1) { //จำนวน approve
                $count_approve += $dw['count_order'];
            } else if ($dw['approve'] == 2) { //จำนวน reject
                $count_reject += $dw['count_order'];
            } else if ($dw['approve'] == 0) { //จำนวน waiting
                $count_waiting += $dw['count_order'];
            }
        }
        foreach ($donut_chart_foc as $dw) {
            if ($dw['approve'] == 1) { //จำนวน approve
                $count_approve += $dw['count_order'];
            } else if ($dw['approve'] == 2) { //จำนวน reject
                $count_reject += $dw['count_order'];
            } else if ($dw['approve'] == 0) { //จำนวน waiting
                $count_waiting += $dw['count_order'];
            }
        }
        foreach ($donut_chart_lo as $dw) {
            if ($dw['approve'] == 1) { //จำนวน approve
                $count_approve += $dw['count_order'];
            } else if ($dw['approve'] == 2) { //จำนวน reject
                $count_reject += $dw['count_order'];
            } else if ($dw['approve'] == 0) { //จำนวน waiting
                $count_waiting += $dw['count_order'];
            }
        }
        $total = $count_approve + $count_reject + $count_waiting;
        if ($total > 0) {
            $total_approve = number_format(($count_approve / $total) * 100);
            $total_reject = number_format(($count_reject / $total) * 100);
            $total_waiting = number_format(($count_waiting / $total) * 100);
        } else {
            $total_approve = 0;
            $total_reject = 0;
            $total_waiting = 0;
        }
        return $total_approve . "##" . $total_reject . "##" . $total_waiting;
    }

    public function bar_chart() {
        $search = $this->session->userdata('search_date');
        //Bar Chart - Ranking
        $k = 1;
        $total_bar = "";
        if(!empty($search['sdate'])){
            $this->db->where('DATE_FORMAT(order_list_date, \'%m/%Y\') =',$search['sdate']);
        }
        $bar_chart = $this->db->select("sum(ldetail_qty) as sum_product, product_name, product_id")
                            ->from("bio_order_list_detail l")
                            ->join("bio_product p", "l.ldetail_product_id = p.product_id", "INNER")
                            ->join("bio_order_list o", "l.ldetail_order_list_id = o.order_list_id", "INNER")
                            ->where(array("product_status" => 1))
                            ->group_by("ldetail_product_id")
                            ->order_by("p.product_id", "asc")
                            ->get();
        $num_bar = $bar_chart->num_rows();
        if($num_bar > 0){
            foreach ($bar_chart->result_array() as $dw) {
                $sum = (!empty($dw['sum_product']))?$dw['sum_product']:0;
                @$array_data[$dw['product_name']] += @$sum;
                arsort($array_data);
            }
        }
        if(!empty($search['sdate'])){
            $this->db->where('DATE_FORMAT(foc_date, \'%m/%Y\') =',$search['sdate']);
        }
        $bar_chart = $this->db->select("sum(fdetail_qty) as sum_product, product_name, product_id")
                            ->from("bio_order_foc_detail as d")
                            ->join("bio_product as p", "d.fdetail_product_id = p.product_id", "INNER")
                            ->join("bio_order_foc as f", "d.fdetail_foc_id = f.foc_id", "INNER")
                            ->where(array("product_status" => 1))
                            ->group_by("fdetail_product_id")
                            ->order_by("p.product_id", "asc")
                            ->get();
        $num_bar = $bar_chart->num_rows();
        if($num_bar > 0){
            foreach ($bar_chart->result_array() as $dw) {
                $sum = (!empty($dw['sum_product']))?$dw['sum_product']:0;
                @$array_data[@$dw['product_name']] += @$sum;
                arsort($array_data);
            }
        }
        if(!empty($search['sdate'])){
            $this->db->where('DATE_FORMAT(ob_date, \'%m/%Y\') =',$search['sdate']);
        }
        $bar_chart = $this->db->select("sum(obd_qty_borrow) as sum_product, product_name, product_id")
                            ->from("bio_order_borrow_detail as d")
                            ->join("bio_product as p", "d.obd_product_id = p.product_id", "INNER")
                            ->join("bio_order_borrow as b", "d.obd_ob_id = b.ob_id", "INNER")
                            ->where(array("product_status" => 1))
                            ->group_by("obd_product_id")
                            ->order_by("p.product_id", "asc")
                            ->get();
        $num_bar = $bar_chart->num_rows();
        if($num_bar > 0){
            foreach ($bar_chart->result_array() as $dw) {
                $sum = (!empty($dw['sum_product']))?$dw['sum_product']:0;
                @$array_data[$dw['product_name']] += @$sum;
                arsort($array_data);
            }
        }
        if(count(@$array_data) > 0){
            $rs_i = 1;
            foreach($array_data as $key_data => $rs_data){
                if($rs_i <= 5){
                    $sign = ($rs_i < 5) ? ", " : "";
                    $total_bar .= '[' . '"' . $key_data . '"' . "," . $rs_data . ']' . $sign;
                }else{
                    break;
                }
                $rs_i++;
            }
        }
        return $total_bar;
    }

    public function top_sale($page) {
        $max_price = 0;
        $data = array();
        if ($page == "home") {
            $this->db->limit(4, 0);
        }
        $where = array("order_list_approve" => 1, "order_status" => 1);
        
        $sqlsale = $this->db->select("sum(ldetail_subtotal) as total_price, member_name")
                            ->from("bio_order_list l")
                            ->join("bio_order_list_detail", "order_list_id = ldetail_order_list_id", "INNER")
                            ->join("bio_order o", "order_id = order_list_id", "INNER")
                            ->join("bio_member", "o.FK_member_id = member_id", "INNER")
                            ->where($where)
                            ->group_by("o.FK_member_id")
                            ->get();
            foreach ($sqlsale->result_array() as $sale) {
                if ($sale['total_price'] > 0) {
                    $data[] = array("member_name" => $sale['member_name'],"total_price" => $sale['total_price']);
                }
            }
        return $data;
    }

    public function customer_list() {
        return $this->db->select('*')->where('customer_status', 1)->get('bio_customer')->result_array();
    }
    
    public function customer_type_list(){
        return $this->db->select('*')->where('cus_type_status', 1)->get('bio_customer_type')->result_array();
    }

    public function province_list() {
        return $this->db->select('*')->order_by('province_name', 'ASC')->get('bio_province')->result_array();
    }

    public function rate_price($cid) {
        $query = $this->db->select('*')->where('rate_customer_id', $cid)->get('bio_product_rateprice')->result_array();
        $data = array();
        if (count($query) > 0) {
            foreach ($query as $rs) {
                $data[$rs['rate_product_id']] = $rs['rate_price'];
            }
        }
        return $data;
    }

    public function report_ca_index($val = '', $arr = '') {
        if (isset($arr) && !empty($arr)) {
            $this->db->limit($arr['limit'], $arr['start']);
        }
        if (!empty($val['name'])) {
            $this->db->where('customer_id', $val['name']);
        }
        if (!empty($val['type'])) {
            $this->db->where('FK_type_id', $val['type']);
        }
        if (!empty($val['province'])) {
            $this->db->where('customer_province', $val['province']);
        }
        $query = $this->db->join('bio_customer_type as t', 'c.FK_type_id = t.cus_type_id', 'INNER')
                ->join('bio_zone as z', 'c.FK_zone_id = z.zone_id', 'LEFT')
                ->join('bio_province as prov', 'prov.province_id = c.customer_province', 'LEFT')
                ->join('bio_order as o', 'o.FK_customer_id = c.customer_id', 'LEFT')
                ->join('bio_order_list as l', 'l.order_list_order_id = o.order_id and order_list_approve = 1 and order_list_status = 1', 'LEFT')
                ->join('bio_order_list_detail as ld', 'l.order_list_id = ld.ldetail_order_list_id', 'LEFT')
                ->join('bio_product as p', 'ld.ldetail_product_id = p.product_id', 'LEFT')
                ->where('customer_status', 1)
                ->group_by('customer_id')
                ->get('bio_customer as c')
                ->result_array();
        return $query;
    }
    
    public function report_cr_index($search = '', $arr = '') {
        if (isset($arr) && !empty($arr)) {
            $this->db->limit($arr['limit'], $arr['start']);
        }
        
        if ($search['rep_id'] != '') {
            $this->db->where('zone_code', $search['rep_id']);
        }

        if ($search['sdate'] != '') {
            $array_date = explode("/", $search['sdate']);
            $startdate = date("Ym", strtotime("-12 month", strtotime($array_date[1] . "-" . $array_date[0] . "-1 00:00:00")));
            $day_month = date('t', strtotime($array_date[1] . "-" . $array_date[0] . "-01")); //ดึงวันที่สุดท้ายของเดือนที่ค้นหา
            $todate = date("Ym", strtotime(date($array_date[1] . "-" . $array_date[0] . "-" . $day_month . " 23:59:59")));
        } else {
            $startdate = date("Ym", strtotime("-12 month"));
            $todate = date("Ym");
        }
        $this->db->where('DATE_FORMAT(order_date_create,"%Y%m") >= ', $startdate);
        $this->db->where('DATE_FORMAT(order_date_create,"%Y%m") <= ', $todate);

        $where = array(
            'order_status' => 1,
        );

        $data = array();
        $query = $this->db->join("bio_customer as c", "o.FK_customer_id = c.customer_id", "INNER")
                ->join("bio_zone as z", "c.FK_zone_id = z.zone_id", "INNER")
                ->join("bio_member as m", "c.FK_member_id = m.member_id", "INNER")
                ->join("bio_province as p", "c.customer_province = p.province_id", "INNER")
                ->where($where)
                ->group_by("o.FK_customer_id")
                ->order_by("zone_code asc, order_date_create asc")
                ->get('bio_order as o');
        foreach ($query->result_array() as $cr) {
            //วันที่สั่งซื้อสินค้าครั้งแรกสุดและวันที่สั่งซื้อสินค้าครั้งล่าสุด
            $order = $this->db->select("max(order_date_create) as last_date, min(order_date_create) as first_date")->from("bio_order")->where(array("FK_customer_id" => $cr['FK_customer_id']))->get();
            foreach ($order->result_array() as $ord)
                ;

            $k = 0;
            $order_qty = "";
            $psearch = (!empty($search['pro_name']))?$search['pro_name']:1;
            foreach ($this->report_cr_date($search) as $date) {
                //ผลรวมของแต่ละเดือนกับปี
                $order_total = 0;
                $where_so = array(
                    "FK_customer_id" => $cr['FK_customer_id'],
                    "DATE_FORMAT(order_date_create,'%Y%m')" => $date,
                    'order_list_approve' => 1,
                    'order_list_status' => 1,
                    'ldetail_product_id' => $psearch,
                    'ldetail_status' => 1,
                );
                $where_foc = array(
                    "FK_customer_id" => $cr['FK_customer_id'],
                    "DATE_FORMAT(order_date_create,'%Y%m')" => $date,
                    'foc_approve' => 1,
                    'foc_status' => 1,
                    'fdetail_product_id' => $psearch,
                    'fdetail_status' => 1,
                );
                $where_lo = array(
                    "FK_customer_id" => $cr['FK_customer_id'],
                    "DATE_FORMAT(order_date_create,'%Y%m')" => $date,
                    'ob_approve' => 1,
                    'ob_status' => 1,
                    'obd_product_id' => $psearch,
                    'obd_status' => 1,
                );
                if(@$search['stype'] == 'so' || empty($search['stype'])){
                    $sum_so = $this->db->select("sum(ldetail_qty) as total, order_date_create")
                                    ->join("bio_order_list as l", "l.order_list_order_id = o.order_id", 'INNER')
                                    ->join("bio_order_list_detail as d ", "l.order_list_id = d.ldetail_order_list_id", 'INNER')
                                    ->where($where_so)
                                    ->group_by("ldetail_product_id")
                                    ->order_by("order_date_create")
                                    ->get('bio_order as o')
                                    ->first_row('array');
                    
                    $order_total += ((!empty($sum_so['total']))?$sum_so['total']:'0');
                }
                if(@$search['stype'] == 'foc' || empty($search['stype'])){
                    $sum_foc = $this->db->select("sum(fdetail_qty) as total, order_date_create")
                                    ->join("bio_order_foc as f", "f.foc_order_id = o.order_id", 'INNER')
                                    ->join("bio_order_foc_detail as d ", "f.foc_id = d.fdetail_foc_id", 'INNER')
                                    ->where($where_foc)
                                    ->group_by("fdetail_product_id")
                                    ->order_by("order_date_create")
                                    ->get('bio_order as o')
                                    ->first_row('array');
                    $order_total += ((!empty($sum_foc['total']))?$sum_foc['total']:'0');
                }
                if(@$search['stype'] == 'lo' || empty($search['stype'])){
                    $sum_lo = $this->db->select("sum(obd_qty_borrow) as total, order_date_create")
                                    ->join("bio_order_borrow as b", "b.ob_order_id = o.order_id", 'INNER')
                                    ->join("bio_order_borrow_detail as d ", "b.ob_id = d.obd_ob_id", 'INNER')
                                    ->where($where_lo)
                                    ->group_by("obd_product_id")
                                    ->order_by("order_date_create")
                                    ->get('bio_order as o')
                                    ->first_row('array');
                    $order_total += ((!empty($sum_lo['total']))?$sum_lo['total']:'0');
                }
                $order_qty .= $order_total."||";
            }
            $data[] = array("rep_id" => $cr['member_number'],
                "province" => $cr['province_name'],
                "zone" => $cr['zone_code'],
                "customer_name" => $cr['customer_name'],
                "order_first_date" => $ord['first_date'],
                "order_qty" => $order_qty,
                "order_last_date" => $ord['last_date']);
        }
        return $data;
    }

    public function report_cr_date($search = '') {
        if ($search['sdate'] != '') {
            $array_date = explode("/", $search['sdate']);
            $search_date = $array_date[1] . "-" . $array_date[0] . "-01";
        } else {
            $search_date = date("Y-m-d");
        }
        for ($i = 12; $i >= 0; $i--) {
            $date[] = date("Ym", strtotime("-" . $i . " month", strtotime($search_date)));
        }
        return $date;
    }

    public function report_foc_index($val = '') {
        if (!empty($val['name'])) {
            $this->db->where('customer_id', $val['name']);
        }
        if (!empty($val['type'])) {
            $this->db->where('FK_type_id', $val['type']);
        }
        if (!empty($val['province'])) {
            $this->db->where('customer_province', $val['province']);
        }
        $where = array(
            'customer_status' => 1,
            'zone_status' => 1,
            'order_status' => 1,
            'foc_status' => 1,
            'foc_approve' => 1,
        );
        $query = $this->db->select('*')
                ->join('bio_customer_type as t', 'c.FK_type_id = t.cus_type_id', 'INNER')
                ->join('bio_province as prov', 'prov.province_id = c.customer_province', 'LEFT')
                ->join('bio_order as o', 'o.FK_customer_id = c.customer_id', 'INNER')
                ->join('bio_zone as z', 'o.FK_zone_id = z.zone_id', 'INNER')
                ->join('bio_order_foc as f', 'f.foc_order_id = o.order_id', 'INNER')
                ->where($where)
                ->get('bio_customer as c')
                ->result_array();
        return $query;
    }

    public function foc_detail($oid) {
        $query = $this->db->select('*')->where(array('fdetail_foc_id' => $oid, 'fdetail_status' => 1))->get('bio_order_foc_detail')->result_array();
        $data = array();
        if (count($query) > 0) {
            foreach ($query as $rs) {
                @$data[$rs['fdetail_product_id']] += $rs['fdetail_qty'];
            }
        }
        return $data;
    }

    public function report_so2_index($val = '') {
        if(!empty($val['name'])){
            $this->db->where('customer_id', $val['name']);
        }
        if(!empty($val['type'])){
            $this->db->where('FK_type_id', $val['type']);
        }
        if(!empty($val['province'])){
            $this->db->where('customer_province', $val['province']);
        }
        $where = array(
            'customer_status' => 1,
            'order_status' => 1,
//            'order_approve' => 1,
            'RIGHT(zone_code,2) REGEXP' => '^[ABCabc]+$'
        );
        $query = $this->db->select('*')
                ->join('bio_order as o', 'o.FK_customer_id = c.customer_id', 'INNER')
//                ->join('bio_order_list as ol', 'ol.FK_order_id = o.order_id', 'LEFT')
//                ->join('bio_product as p', 'p.product_id = ol.FK_product_id', 'LEFT')
                ->join('bio_customer_type as t', 'c.FK_type_id = t.cus_type_id', 'INNER')
                ->join('bio_zone as z', 'o.FK_zone_id = z.zone_id', 'INNER')
                ->join('bio_province as prov', 'prov.province_id = c.customer_province', 'INNER')
                ->where($where)
                ->group_by('order_id')
                ->get('bio_customer as c')
                ->result_array();
        return $query;
    }
    
    public function report_so_index($val = '') {
        if(!empty($val['name'])){
            $this->db->where('customer_id', $val['name']);
        }
        if(!empty($val['type'])){
            $this->db->where('FK_type_id', $val['type']);
        }
        if(!empty($val['province'])){
            $this->db->where('customer_province', $val['province']);
        }
        $where = array(
            'customer_status' => 1,
            'order_status' => 1,
//            'order_approve' => 1,
            'RIGHT(zone_code,2) REGEXP' => '^[0-9]+$'
        );
        $query = $this->db->select('*')
                ->join('bio_order as o', 'o.FK_customer_id = c.customer_id', 'INNER')
//                ->join('bio_order_list as ol', 'ol.FK_order_id = o.order_id', 'LEFT')
//                ->join('bio_product as p', 'p.product_id = ol.FK_product_id', 'LEFT')
                ->join('bio_customer_type as t', 'c.FK_type_id = t.cus_type_id', 'INNER')
                ->join('bio_zone as z', 'c.FK_zone_id = z.zone_id', 'INNER')
                ->join('bio_area as a', 'a.area_id = z.zone_area_id', 'INNER')
                ->join('bio_province as prov', 'prov.province_id = c.customer_province', 'INNER')
                ->where($where)
                ->group_by('order_id')
                ->get('bio_customer as c')
                ->result_array();
        return $query;
    }

    public function report_src_index($search = '') {
        if ($search['pro_name'] != '') {
            $this->db->where('ol.FK_product_id', $search['pro_name']);
        }

        if ($search['rep_id'] != '') {
            $this->db->where('z.zone_id', $search['rep_id']);
        }

        if ($search['cus_type'] != '') {
            $this->db->where('c.FK_type_id', $search['cus_type']);
        }

        if ($search['province'] != '') {
            $this->db->where('customer_province', $search['province']);
        }

        if ($search['syear'] != '') {
            $this->db->where('DATE_FORMAT(order_date_create,"%Y")', $search['syear']);
        }

        if ($search['sdate'] != '') {
            $array_date = explode("/", $search['sdate']);
            $startdate = date("Ym", strtotime("-12 month", strtotime($array_date[1] . "-" . $array_date[0] . "-1 00:00:00")));
            $day_month = date('t', strtotime($array_date[1] . "-" . $array_date[0] . "-01")); //ดึงวันที่สุดท้ายของเดือนที่ค้นหา
            $todate = date("Ym", strtotime(date($array_date[1] . "-" . $array_date[0] . "-" . $day_month . " 23:59:59")));
            $this->db->where('DATE_FORMAT(order_create_date,"%Y%m") >= ', $startdate);
            $this->db->where('DATE_FORMAT(order_create_date,"%Y%m") <= ', $todate);
        }

        if ($search['syear'] == '' && $search['sdate'] == '') {
            $startdate = date("Ym", strtotime("-12 month"));
            $todate = date("Ym");
            $this->db->where('DATE_FORMAT(order_date_create,"%Y%m") >= ', $startdate);
            $this->db->where('DATE_FORMAT(order_date_create,"%Y%m") <= ', $todate);
        }

        $where = array(
            'order_status' => 1,
        );

        $data = array();
        $query = $this->db->select('*,SUM(ldetail_qty)as sum_so,SUM(fdetail_qty)as sum_foc')
                ->join("bio_order as o", "o.FK_zone_id = z.zone_id", "INNER")
                ->join("bio_customer as c", "o.FK_customer_id = c.customer_id", "INNER")
                ->join("bio_province as p", "c.customer_province = p.province_id", "INNER")
                ->join("bio_order_list as l", "order_list_order_id = order_id and order_list_approve = 1 and order_list_status = 1", "left")
                ->join("bio_order_list_detail as ld", "order_list_id = ldetail_order_list_id and ldetail_status = 1", "INNER")
                ->join("bio_order_foc as f", "foc_order_id = order_id and foc_approve = 1 and foc_status = 1", "left")
                ->join("bio_order_foc_detail as fd", "foc_id = fdetail_foc_id and fdetail_status = 1", "INNER")
                ->where($where)
                ->group_by('DATE_FORMAT(order_date_create,(\'%Y%m%d\'))')
                ->order_by("zone_code asc, customer_name asc")
                ->get('bio_zone as z')
                ->result_array();
        
        return $query;
    }
    
    public function report_plot_index($val = '') {
        if (!empty($val['product'])) {
//            $this->db->where('customer_id', $val['name']);
        }
        $return['area'] = $this->db->select('*')->where('area_stat', 1)->get('bio_area')->result_array();
        foreach($return['area'] as $area){
            $where_zone = array(
                'zone_status' => 1,
                'FK_level_id' => 3,
                'zone_area_id' => $area['area_id']
            );
            $return['zone'][$area['area_id']] = $this->db->select('*')
                                                        ->join('bio_member as m', 'm.FK_zone_id = z.zone_id', 'INNER')
                                                        ->where($where_zone)
                                                        ->get('bio_zone as z')
                                                        ->result_array();
        }
//        $return['']
//        $query = $this->db->select('*')
//                ->join('bio_customer_type as t', 'c.FK_type_id = t.cus_type_id', 'INNER')
//                ->join('bio_zone as z', 'c.FK_zone_id = z.zone_id', 'LEFT')
//                ->join('bio_province as prov', 'prov.province_id = c.customer_province', 'LEFT')
//                ->join('bio_order as o', 'o.FK_customer_id = c.customer_id', 'LEFT')
//                ->join('bio_order_list as l', 'l.FK_order_id = o.order_id', 'LEFT')
//                ->join('bio_product as p', 'l.FK_product_id = p.product_id', 'LEFT')
//                ->where('customer_status', 1)
//                ->group_by('customer_id')
//                ->get('bio_customer as c')
//                ->result_array();
        return $return;
    }

}

/* End of file model_admin_report.php */
/* Location ./application/models/model_admin_report.php */
