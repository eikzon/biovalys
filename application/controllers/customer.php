<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class customer extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->model_utility->check_login();
        $this->load->model('model_customer');
    }

    public function index() {
        $data['temp'] = $this->model_template->gen();
        $this->load->library("pagination");
        $data['total'] = count($this->model_customer->list_customer());
        $config["base_url"] = base_url('customer/page');
        $config["total_rows"] = $data['total'];
        $config["per_page"] = 5;
        $config["uri_segment"] = 3;
        $config['num_links'] = 1;

        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = 'Frist';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data["links"] = $this->pagination->create_links();
        $arr = array('start' => $page, 'limit' => $config["per_page"]);
        $data['list'] = $this->model_customer->list_customer($arr);
        $data['search'] = $this->session->userdata('customer');
        $this->load->view('customer', $data);
    }

    public function page() {
        $this->index();
    }

    public function add() {
        $data['type'] = $this->model_customer->type_customer();
        $data['temp'] = $this->model_template->gen();
        $data['prov'] = $this->model_customer->province_customer();
        $this->load->view('new_customer', $data);
    }

    public function search() {
        $data = $this->input->post();
        if (isset($data) && !empty($data)) {
            $arr['customer'] = $data;
            $this->session->set_userdata($arr);
        }
        $this->index();
    }

    public function insert() {
        $data = $this->input->post();
        if (isset($data) && !empty($data)) {
            $rs = $this->model_customer->save_customer($data);
            $arr = array('title' => '<i class="fa fa-floppy-o"></i>
 Save Customer', 'detail' => 'Wait Manager Approve Customer Please send New order', 'url' => base_url('customer/order/' . $rs));
            echo $this->model_utility->alert($arr);
        } else {
            $arr = array('title' => '<i class="fa fa-floppy-o"></i>
 Save Error', 'detail' => 'Please Contact Administrator', 'url' => base_url('customer'));
            echo $this->model_utility->alert($arr);
        }
    }

    public function neworder() {
        $id = $this->uri->segment(3);
        $where = array('customer_id' => $id);
        $data['cus'] = $this->model_customer->customer_detail();
        $this->load->model('model_product');
        $data['list'] = $this->model_product->list_product($this->uri->segment(3));
        $data['temp'] = $this->model_template->gen();
        $this->load->view('set_newproduct', $data);
    }

    public function order() {
        $id = $this->uri->segment(3);
        $this->load->model('model_product');
        $data['cus'] = $this->model_customer->customer_detail();
        $data['list'] = $this->model_product->list_product($id);
        $data['temp'] = $this->model_template->gen();
        $data['count'] = $this->model_customer->count_product($id);
        $this->load->view('set_product', $data);
    }

    public function auto_customer() {
        $data = $this->model_customer->customer_auto();
        if (isset($data) && !empty($data)) {
            foreach ($data as $item) {
                $rs[] = array('id' => $item['customer_name'], 'name' => $item['customer_name'] . ' (มีอยู่แล้วในระบบ)');
            }
            echo json_encode($rs);
        }
    }
    
    public function detail() {
        $data['temp'] = $this->model_template->gen();
        $data['customer'] = $this->model_customer->customer_detail();
        $this->load->view('customer_detail', $data);
    }

}
