<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

@header("Content-type: text/html; charset=utf-8"); //set utf-8
@date_default_timezone_set("Asia/Bangkok");

class model_admin_member extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function member_login($arr) {
        $user = array($arr['system_username'], $arr['system_password']);
        $this->db->select("*")->from("bio_member")->where(array("member_username" => $user[0], "member_password" => $this->model_utility->passwd($user), "member_status !=" => "2"));
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $mem_pic = (is_file('assets/img/user/' . $row['member_picture'])) ? 'assets/img/user/' . $row['member_picture'] : 'assets/img/NoImage.gif';
                $data = array(
                    'id' => $row['member_id'],
                    'username' => $row['member_username'],
                    'level' => $row['FK_level_id'],
                    'picture' => $mem_pic);
                if (isset($arr['remember']) && !empty($arr['remember'])) {
                    $this->set_cookie($row);
                }
            }
            $member = $this->session->set_userdata($data);
            return 1;
        } else {
            return 0;
        }
    }

    public function member_data($arr) {
        if (isset($arr) && !empty($arr)) {
            $where = array_merge($arr, array('member_status !=' => '2'));
            $data = $this->db->select('*')->from('bio_member')->where($where)->get()->result_array();
            return $data[0];
        }
    }

    public function gen_session($row) {
        $mem_pic = (is_file('assets/img/user/' . $row['member_picture'])) ? 'assets/img/user/' . $row['member_picture'] : 'assets/img/NoImage.gif';
        $data = array(
            'id' => $row['member_id'],
            'username' => $row['member_username'],
            'level' => $row['FK_level_id'],
            'picture' => $mem_pic);
        $this->session->set_userdata($data);
    }

    public function level_list() {
        $query = $this->db->select("*")->from("bio_member_level")->where("level_status", 1)->order_by("level_id", "asc")->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $lv) {
                $lv_list[] = array(
                    'level_id' => $lv['level_id'],
                    'level_name' => $lv['level_name']);
            }
        } else {
            $lv_list[] = array();
        }
        return $lv_list;
    }

    public function member_list($arr = '') {
        if (isset($arr) && !empty($arr)) {
            $this->db->limit($arr['limit'], $arr['start']);
        }

        $search = $this->session->userdata('member');
        if (isset($search) && !empty($search)) {
//            if ($search['sid'] != '') {
//                $this->db->where('member_number', $search['sid']);
//            }

            if ($search['sname'] != '') {
                $this->db->like('member_name', $search['sname']);
            }

            if ($search['semail'] != '') {
                $this->db->like('member_email', $search['semail']);
            }

            if ($search['slevel'] != '') {
                $this->db->where('FK_level_id', $search['slevel']);
            }
        }

        $query = $this->db->select("*")->from("bio_member")->join('bio_member_level', 'FK_level_id = level_id')->join('bio_zone', 'FK_zone_id = zone_id', 'left')->where("member_status !=", 2)->order_by("member_id", "desc")->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $member_list[] = array(
                    'id' => $row['member_id'],
                    'code' => $row['zone_code'],
                    'name' => $row['member_name'],
                    'email' => $row['member_email'],
                    'level' => $row['level_name'],
                    'status' => $row['member_status'],
                );
            }
        } else {
            $member_list[] = array();
        }
        return $member_list;
    }

    public function member_insert($data) {
        $user = ($this->session->userdata('id') != '') ? $this->session->userdata('id') : 0;
        $member = array(
            'FK_level_id' => $data['level'],
//            'member_number' => $data['mem_id'],
            'member_name' => $data['name'],
            'member_email' => $data['email'],
            'member_address' => $data['address'],
            'member_mobile' => $data['mobile'],
            'member_username' => $data['username'],
            'member_password' => $this->model_utility->passwd(array($data['username'], $data['password'])),
            'member_register' => date("Y-m-d H:i:s"),
            'FK_zone_id' => $data['zone_id'],
            'FK_member_id' => $user);

        $this->db->insert('bio_member', $member);
        return $this->db->insert_id();
    }

    public function member_edit($id) {
        $query = $this->db->select("*")->from("bio_member")->where("member_id", $id)->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $member_list[] = array(
                    'id' => $row['member_id'],
                    'number' => $row['member_number'],
                    'picture' => $row['member_picture'],
                    'name' => $row['member_name'],
                    'email' => $row['member_email'],
                    'address' => $row['member_address'],
                    'mobile' => $row['member_mobile'],
                    'username' => $row['member_username'],
                    'level' => $row['FK_level_id'],
                    'FK_zone_id' => $row['FK_zone_id']);
            }
        } else {
            $member_list[] = array();
        }
        return $member_list;
    }

    public function member_update($data, $id) {
        $user = ($this->session->userdata('id') != '') ? $this->session->userdata('id') : 0;
        $where = array('member_id' => $id);
        $member = array('FK_level_id' => $data['level'],
//            'member_number' => $data['mem_id'],
            'member_name' => $data['name'],
            'member_email' => $data['email'],
            'member_address' => $data['address'],
            'member_mobile' => $data['mobile'],
            'FK_zone_id' => $data['zone_id'],
            'FK_member_id' => $user);

        $this->db->update('bio_member', $member, $where);

        if ($data['password'] != '') {
            $update_pass = array('member_password' => $this->model_utility->passwd(array($data['username'], $data['password'])));
            $this->db->update('bio_member', $update_pass, $where);
        }
    }

    public function member_image($field, $id) {
        if (!empty($field)) {
            $data = array('member_picture' => $field);
            $where = array("member_id" => $id);
            $this->db->update("bio_member", $data, $where);
        }
    }

    public function member_delete($id) {
        $data = array('member_status' => '2');
        $where = array("member_id" => $id);
        $this->db->update("bio_member", $data, $where);
        return $this->db->last_query();
    }

    public function changepass($new, $id) {
        $data = array('member_password' => $new);
        $where = array("member_id" => $id);
        $this->db->update("bio_member", $data, $where);
    }

    //ไฟล์ excel สกุล csv
    function export_csv() {
        $k = 1;
        $query = $this->db->select("*")->from("bio_member")->join("bio_member_level", "FK_level_id = level_id")->where("member_status != ", "2")->get();
        foreach ($query->result_array() as $row) {
            $data[] = $k . "," . $row['member_number'] . "," . iconv('UTF-8', 'TIS-620', $row['member_name']) . "," . $row['member_email'] . "," . iconv('UTF-8', 'TIS-620', $row['level_name']) . "," . $row['member_mobile'] . "\n";
            $k++;
        }
        return $data;
    }

    public function set_cookie($arr) {
        if (isset($arr) && !empty($arr)) {
            $cookie = $this->model_utility->encrypt_encode($arr['member_id']);
            $data = array('name' => 'biovalys', 'value' => $cookie, 'expire' => 86500);
            $this->input->set_cookie($data);
        }
    }

    public function member_order($arr) {
        $approve = array_merge($arr, array('order_approve' => 1));
        $reject = array_merge($arr, array('order_approve' => 2));
        return array('total' => $this->number_order($arr), 'approve' => $this->number_order($approve), 'reject' => $this->number_order($reject));
    }

    public function number_order($val) {
        $where_so = array('FK_member_id' => $val['FK_member_id'], 'order_list_status' => 1);
        $where_foc = array('FK_member_id' => $val['FK_member_id'], 'foc_status' => 1);
        $where_lo = array('FK_member_id' => $val['FK_member_id'], 'ob_status' => 1);
        if(!empty($val['order_approve'])){
            $where_so = array_merge($where_so, array('order_list_approve' => $val['order_approve']));
            $where_foc = array_merge($where_foc, array('foc_approve' => $val['order_approve']));
            $where_lo = array_merge($where_lo, array('ob_approve' => $val['order_approve']));
        }
        $so = $this->db->join('bio_order_list as l', 'l.order_list_order_id = o.order_id', 'INNER')->where($where_so)->get('bio_order as o')->num_rows();
        $foc = $this->db->join('bio_order_foc as f', 'f.foc_order_id = o.order_id', 'INNER')->where($where_foc)->get('bio_order as o')->num_rows();
        $lo = $this->db->join('bio_order_borrow as b', 'b.ob_order_id = o.order_id', 'INNER')->where($where_lo)->get('bio_order as o')->num_rows();
        return $so+$foc+$lo;
    }

    public function change_status($arr) {
        $where = array('member_id' => $arr['id']);
        $data = array('member_status' => $arr['stat']);
        $rs = $this->db->update('bio_member', $data, $where);
        if ($rs) {
            $gen = array('id' => $arr['id'], 'stat' => $arr['stat'], 'url' => base_url('sitecontrol/member/status'));
            echo $this->model_utility->status_control($gen);
        }
    }

    public function zone_data() {
        $data = $this->db->select("*")->from("bio_zone")->where(array("zone_status" => 1))->get()->result_array();
        return $data;
    }

}
