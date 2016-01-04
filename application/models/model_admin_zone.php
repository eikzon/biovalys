<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

@header("Content-type: text/html; charset=utf-8"); //set utf-8
@date_default_timezone_set("Asia/Bangkok");

class model_admin_zone extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function zone_list($arr = '') {
        if (isset($arr) && !empty($arr)) {
            $this->db->limit($arr['limit'], $arr['start']);
        }

        $query = $this->db->select("*")->from("bio_zone as z")->join('bio_area as a', 'z.zone_area_id = a.area_id', 'INNER')->where("zone_status !=", 2)->order_by("zone_id", "desc")->get()->result_array();
        if (!empty($query)) {
            foreach ($query as $row) {
                $total = $this->total_customer($row['zone_id']);
                $zone_list[] = array(
                    'id' => $row['zone_id'],
                    'code' => $row['zone_code'],
                    'name' => $row['zone_name'],
                    'area' => $row['area_name'],
                    'total' => $total,
                    'status' => $row['zone_status']);
            }
        } else {
            $zone_list[] = array();
        }
        return $zone_list;
    }

    public function total_customer($id) {
        $query = $this->db->select("*")->from("bio_customer")->where(array("FK_zone_id" => $id, "customer_status !=" => 2))->get();
        return $query->num_rows();
    }

    public function zone_insert($data) {
        $user = ($this->session->userdata('id') != '') ? $this->session->userdata('id') : 0;

        $zone = array(
            'zone_code' => $data['zone_code'],
//            'zone_name' => $data['zone_name'],
            'zone_area_id' => $data['zone_area_id']
        );
        $this->db->insert('bio_zone', $zone);
    }

    public function zone_edit($id) {
        $query = $this->db->select("*")->from("bio_zone")->where("zone_id", $id)->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {

                $zone_list[] = array('id' => $row['zone_id'],
                    'code' => $row['zone_code'],
                    'name' => $row['zone_name'],
                    'area_id' => $row['zone_area_id']
                );
            }
        } else {
            $zone_list[] = array();
        }
        return $zone_list;
    }

    public function zone_update($data, $id) {
        $user = ($this->session->userdata('id') != '') ? $this->session->userdata('id') : 0;
        $where = array('zone_id' => $id);

        $zone = array(
            'zone_code' => $data['zone_code'],
//            'zone_name' => $data['zone_name'],
            'zone_area_id' => $data['zone_area_id']
        );
        $this->db->update('bio_zone', $zone, $where);
    }

    public function zone_delete($id) {
        $data = array('zone_status' => '2');
        $where = array("zone_id" => $id);
        $this->db->update("bio_zone", $data, $where);
        return $this->db->last_query();
    }

    public function change_status($arr) {
        $where = array('zone_id' => $arr['id']);
        $data = array('zone_status' => $arr['stat']);
        $this->db->update('bio_zone', $data, $where);
        return $this->db->last_query();
    }
    
    public function area_list() {
        return $this->db->select('*')->where('area_stat', 1)->get('bio_area')->result_array();
    }

}
