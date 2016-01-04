<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class member extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_member');
    }

    public function index() {
//      $data['temp'] = $this->model_template->gen();
//		$this->load->view('home',$data);
    }

    public function login() {
        $data = $this->input->post();
        if (isset($data) && !empty($data)) {
            $rs = $this->model_member->do_login($data);
            if (isset($rs) && !empty($rs)) {
                $arr = array('title' => '<i class="fa fa-exclamation-circle"></i>
 Login Success!!!', 'detail' => 'Welcome To biovalys System', 'url' => base_url(''));
                echo $this->model_utility->alert($arr);
            } else {
                $arr = array('title' => '<i class="fa fa-exclamation-circle"></i>
 Login False!!!', 'detail' => 'Please Contact Administrator', 'url' => base_url('login'));
                echo $this->model_utility->alert($arr);
            }
        } else {
            echo '<script>window.location="' . base_url('login') . '";</script>';
        }
    }

    public function logout() {
        $this->session->sess_destroy();
//        echo '<script>window.location="'.base_url('login').'";</script>';
        $arr = array('title' => '<i class="fa fa-exclamation-circle"></i>
 SignOut!!!', 'detail' => 'Thank for use System', 'url' => base_url('login'));
        echo $this->model_utility->alert($arr);
    }
    
    public function change_password() {
        $data = $this->input->post();
        $this->model_member->save_change_password($data);
        exit();
    }

}
