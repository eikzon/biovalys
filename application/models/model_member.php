<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class model_member extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function do_login($arr) {
        $pass = array($arr['member_username'], $arr['member_password']);
        $pass = $this->model_utility->passwd($pass);
        $where = array_merge($arr, array('member_password' => $pass, 'member_status' => 1));
        $rs = $this->member_data($where);
        $data = '';
        if (isset($rs) && !empty($rs)) {
            $rs = $rs[0];
            $rs = array_diff_key($rs, array('member_password' => '', 'member_status' => '', 'FK_level_id' => ''));
            $data = $this->set_session_member($rs);
        }
        return $data;
    }

    public function member_data($arr) {
        $rs = $this->db->select('*')->from('bio_member')->where($arr)->get()->result_array();
        return $rs;
    }

    public function set_session_member($arr) {
        $data['member_data'] = $arr;
        $this->session->set_userdata($data);
        return $arr;
    }
    
    public function save_change_password($val){
        $data_member = $this->session->userdata('member_data');
        $pass = array($data_member['member_username'], @$val['password_old']);
        $pass = $this->model_utility->passwd($pass);
        $where = array(
            'member_id' => $data_member['member_id'],
            'member_password' => $pass
        );
        $check = $this->db->where($where)->get('bio_member')->num_rows();
        if($check > 0){
            $pass_new = array($data_member['member_username'], @$val['password_new']);
            $pass_new = $this->model_utility->passwd($pass_new);
            $this->db->update('bio_member', array('member_password' => $pass_new), array('member_id' => $data_member['member_id']));
            $arr = array('title' => '<i class="fa fa-exclamation-circle"></i>
 Change Password Success!!!', 'detail' => 'Change Password Successful.', 'url' => base_url('home'));
            echo $this->model_utility->alert($arr);
            exit();
        }else{
            $arr = array('title' => '<i class="fa fa-exclamation-circle"></i>
 Change Password False!!!', 'detail' => 'Please try again.', 'url' => base_url('home'));
            echo $this->model_utility->alert($arr);
            exit();
        }
    }

}
