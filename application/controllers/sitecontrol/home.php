<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class home extends CI_Controller {

    var $status = array('0' => 'Wait', '1' => 'Approved', '2' => 'Reject');

    public function __construct() {
        parent::__construct();
        $this->load->model('model_admin_customer');
        $this->load->model('model_admin_order');
        $this->load->model('model_admin_report');
    }

    public function index() {
        $data['temp'] = $this->model_admin_template->gen();
        $arr = array('start' => 0, 'limit' => 6);
        $data['model'] = $this->model_admin_order;
        $data['status'] = $this->status;
        $data['order_list'] = $this->model_admin_order->list_order($arr);
        $data['customer_list'] = $this->model_admin_customer->customer_list($arr);
        $data['top_sale'] = $this->model_admin_report->top_sale("home");
        $max_price = 0;

        foreach ($data['top_sale'] as $price) {
            $max_price = ($price['total_price'] > $max_price) ? $price['total_price'] : $max_price;
        }

        $data['max_price'] = $max_price;
        //DONUT CHART
        $array_donut = $this->model_admin_report->donut_chart();
        $data_donut = explode("##", $array_donut);
        $data['total_approve'] = $data_donut[0];
        $data['total_reject'] = $data_donut[1];
        $data['total_waiting'] = $data_donut[2];

        //BAR CHART
        $data['total_bar'] = $this->model_admin_report->bar_chart();
        $data['search'] = $this->session->userdata('search_date');

        $this->load->view('sitecontrol/dashboard', $data);
    }

    public function test() {
        $this->session->sess_destroy();
        $this->load->view('sitecontrol/login');
    }

    public function graph() {
        $data = $this->input->post();
        if (isset($data) && !empty($data)) {
            $arr['search_date'] = $data;
            $this->session->set_userdata($arr);
        }
        $this->index();
    }

}
