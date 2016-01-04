<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_home');
    }

    public function index() {
        $mem = $this->session->userdata('member_data');
        if ($mem['member_id'] == '' || !isset($mem) || empty($mem)) {
            echo '<script>window.location="' . base_url('login') . '";</script>';
        } else {
//            $data['sum'] = $this->model_home->summary_order();
            $data['temp'] = $this->model_template->gen();
//            $data['user'] = $this->session->userdata('member_data');
            $this->load->view('main', $data);
        }
    }

    public function profile() {
        $mem = $this->session->userdata('member_data');
        if ($mem['member_id'] == '' || !isset($mem) || empty($mem)) {
            echo '<script>window.location="' . base_url('login') . '";</script>';
        } else {
            $data['sum'] = $this->model_home->summary_order();
            $data['temp'] = $this->model_template->gen();
            $data['user'] = $this->session->userdata('member_data');
            $data['chart'] = $this->model_home->product_chart($data['user']['member_id']);
            $data['color'] = $this->model_home->color_list();
            $this->load->view('home', $data);
        }
    }

}
