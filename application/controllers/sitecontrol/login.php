<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_admin_member');
    }

    public function index() {
//        $data['temp'] = $this->model_template->gen();
        $this->load->view('sitecontrol/login');
    }

    public function do_login() {
        $data = $this->input->post();
//        print_r($data);
//        $data = array_diff_key($data,array('remember'=>''));
//        exit();
        $count = $this->model_admin_member->member_login($data);

        if ($count == 0) {
            $arr = array('title' => '<i class="fa fa-exclamation-circle"></i>
 Login False!!!', 'detail' => 'Please login again.', 'url' => base_url('sitecontrol/login'));
            echo $this->model_utility->alert($arr);
        } else {
            echo '<script>window.location="' . base_url("sitecontrol/home") . '"</script>';
            exit;
        }
    }

    public function logout() {
        delete_cookie('biovalys');
        $this->session->sess_destroy();
        $arr = array('title' => '<i class="fa fa-exclamation-circle"></i>
 SignOut!!!', 'detail' => 'Thank for use System', 'url' => base_url('sitecontrol/login'));
        echo $this->model_utility->alert($arr);
    }

}
