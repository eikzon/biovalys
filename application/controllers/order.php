<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class order extends CI_Controller {

    var $status = array('0' => 'Wait', '1' => 'Approved', '2' => 'Reject');
    var $order_type = array('1' => '<span class="label label-success">Order</span>', '2' => '<span class="label label-info">F.O.C</span>', '3' => '<span class="label label-warning">Borrow</span>');

    public function __construct() {
        parent::__construct();
        $this->model_utility->check_login();
        $this->load->model('model_order');
    }

    public function index() {
        $data['temp'] = $this->model_template->gen();
        $this->load->library("pagination");
        $data['total'] = count($this->model_order->list_order());
        $config["base_url"] = base_url('order/page');
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
        $data['list'] = $this->model_order->list_order($arr);
        $data['status'] = $this->status;
        $data['search'] = $this->session->userdata('order');
        $data['obj'] = $this->model_order;
        $this->load->view('order', $data);
    }

    public function page() {
        $this->index();
    }

    public function search() {
        $data = $this->input->post();
        if (isset($data) && !empty($data)) {
            $arr['order'] = $data;
            $this->session->set_userdata($arr);
        }
        $this->index();
    }

    public function success() {
        $arr['order'] = array('stat' => 1, 'name' => '');
        $this->session->set_userdata($arr);
        $this->index();
    }

    public function reject() {
        $arr['order'] = array('stat' => 2, 'name' => '');
        $this->session->set_userdata($arr);
        $this->index();
    }

    public function choose_product() {
        $this->load->model('model_product');
        $this->load->model('model_customer');
//        $data['customer'] = $this->model_customer->customer_detail();
        $data['temp'] = $this->model_template->gen();
        $data['list'] = $this->model_product->list_product();
        $this->load->view('set_product', $data);
    }

    public function new_summary() { // tatal cart order for submit new order
        $this->load->model('model_customer');
        $this->load->model('model_product');
        $id = $this->uri->segment(3);
        $where = array('customer_id' => $id);
        $cus = $this->model_customer->data_customer($where);
        $data['name'] = $cus[0]['customer_name'];
        if ($data['name'] == '') {
            $arr = array('title' => '<i class="fa fa-file-text-o"></i> Please Choose Customer', 'detail' => ' Please Choose Customer For Order', 'url' => base_url('order/new_order'));
            echo $this->model_utility->alert($arr);
        }
        $data['temp'] = $this->model_template->gen();
        $data['cart'] = $this->cart->contents();
        if (empty($data['cart'])) {
            $arr = array('title' => '<i class="fa fa-file-text-o"></i> Please Order Product', 'detail' => 'Please Choose Product For Order', 'url' => base_url('customer/order/' . $id));
            echo $this->model_utility->alert($arr);
        }
        $data['type'] = $this->order_type;
        $this->load->view('summary_new', $data);
    }

    public function summary() { // total cart order for submit order
        $this->load->model('model_customer');
        $this->load->model('model_product');
        $id = $this->uri->segment(3);
        $where = array('customer_id' => $id);
        $data['last'] = $this->model_order->last_order($id);
        $data['cus'] = $this->model_customer->data_customer($where);
        $data['name'] = $data['cus'][0]['customer_name'];
        if ($data['name'] == '') {
            $arr = array('title' => '<i class="fa fa-file-text-o"></i> Please Choose Customer', 'detail' => ' Please Choose Customer For Order', 'url' => base_url('order/new_order'));
            echo $this->model_utility->alert($arr);
        }
        $data['temp'] = $this->model_template->gen();
        $data['cart'] = $this->cart->contents();
        if (empty($data['cart'])) {
            $arr = array('title' => '<i class="fa fa-file-text-o"></i> Please Order Product', 'detail' => 'Please Choose Product For Order', 'url' => base_url('customer/order/' . $id));
            echo $this->model_utility->alert($arr);
        }
        $data['type'] = $this->order_type;
        $this->load->view('summary', $data);
    }

    public function save_order() { // add to cart
        $data = $this->input->post();
        echo $rs = $this->model_order->add_cart($data);
    }

    public function delete_order() { // delete cart
        $data = $this->input->post();
        if (isset($data) && !empty($data)) {
            $this->cart->update($data);
        }
    }

    public function save() { // function insert all order by create new CA
        $data = $this->input->post();
        if (isset($data) && !empty($data)) {
            $res = $this->model_order->save_order($data);
            $this->cart->destroy();
            if ($res == true) {
                $arr = array('title' => '<i class="fa fa-file-text-o"></i> Save Order', 'detail' => 'Please wait Manager Approve Order', 'url' => base_url('customer'));
                echo $this->model_utility->alert($arr);
            } else {
                $arr = array('title' => '<i class="fa fa-file-text-o"></i> Save Error', 'detail' => 'Please Contact to Admin', 'url' => base_url('customer'));
                echo $this->model_utility->alert($arr);
            }
        } else {
            $arr = array('title' => '<i class="fa fa-file-text-o"></i> Save Error', 'detail' => 'Please Contact to Admin', 'url' => base_url('customer'));
            echo $this->model_utility->alert($arr);
        }
    }

    public function so() { //view data order SO
        $id = $this->uri->segment(3);
        if ($id > 0) {
            $data['temp'] = $this->model_template->gen();
            $where = array('ldetail_order_list_id' => $id, 'ldetail_status' => 1);
            $arr = $this->model_order->so_data_detail($where);
            if (empty($arr)) {
                $arr = array('title' => '<i class="fa fa-warning"></i> No data', 'detail' => 'Please Contact to Admin', 'url' => base_url('order'));
                echo $this->model_utility->alert($arr);
                exit();
            }
            $data['list'] = $arr;
            $data['so'] = $arr[0];
            $data['stat'] = $this->status;
            $this->load->view('so_view', $data);
        } else {
            $arr = array('title' => '<i class="fa fa-warning"></i> No data', 'detail' => 'Please Contact to Admin', 'url' => base_url('order'));
            echo $this->model_utility->alert($arr);
            exit();
        }
    }

    public function foc() { //view data order FOC
        $id = $this->uri->segment(3);
        if ($id > 0) {
            $data['temp'] = $this->model_template->gen();
            $where = array('fdetail_foc_id' => $id, 'fdetail_status' => 1);
            $arr = $this->model_order->foc_data_detail($where);
            if (empty($arr)) {
                $arr = array('title' => '<i class="fa fa-warning"></i> No data', 'detail' => 'Please Contact to Admin', 'url' => base_url('order'));
                echo $this->model_utility->alert($arr);
                exit();
            }
            $data['list'] = $arr;
            $data['foc'] = $arr[0];
            $data['stat'] = $this->status;
            $this->load->view('foc_view', $data);
        } else {
            $arr = array('title' => '<i class="fa fa-warning"></i> No data', 'detail' => 'Please Contact to Admin', 'url' => base_url('order'));
            echo $this->model_utility->alert($arr);
            exit();
        }
    }

    public function lo() { //view data order LO
        $id = $this->uri->segment(3);
        if ($id > 0) {
            $data['temp'] = $this->model_template->gen();
            $where = array('obd_ob_id' => $id, 'obd_status' => 1);
            $arr = $this->model_order->lo_data_detail($where);
            if (empty($arr)) {
                $arr = array('title' => '<i class="fa fa-warning"></i> No data', 'detail' => 'Please Contact to Admin', 'url' => base_url('order'));
                echo $this->model_utility->alert($arr);
                exit();
            }
            $data['list'] = $arr;
            $data['lo'] = $arr[0];
            $data['stat'] = $this->status;
            $this->load->view('lo_view', $data);
        } else {
            $arr = array('title' => '<i class="fa fa-warning"></i> No data', 'detail' => 'Please Contact to Admin', 'url' => base_url('order'));
            echo $this->model_utility->alert($arr);
            exit();
        }
    }
    
    public function set_price() {
        $data = $this->input->post();
        $session_price = $this->session->userdata('price_customer');
        echo $session_price[$data['cus']][$data['id']]['price'];
    }

}
