<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class borrow extends CI_Controller {

    var $status = array('0' => 'Wait', '1' => 'Approved', '2' => 'Reject');

    public function __construct() {
        parent::__construct();
        $this->load->model('model_admin_borrow');
    }

    public function index() {
        $data['model'] = $this->model_admin_borrow;
        $this->load->library("pagination");
        $data['total'] = count($this->model_admin_borrow->borrow_list());
        $config["base_url"] = base_url('sitecontrol/borrow/page');
        $config["total_rows"] = $data['total'];
        $config["per_page"] = 20;
        $config["uri_segment"] = 4;
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
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data["links"] = $this->pagination->create_links();
        $arr = array('start' => $page, 'limit' => $config["per_page"]);
        $data['borrow_list'] = $this->model_admin_borrow->borrow_list($arr);
        $data['status'] = $this->status;
        $data['search'] = $this->session->userdata('search_order');
        $data['temp'] = $this->model_admin_template->gen();
        $this->load->view('sitecontrol/borrow', $data);
    }

    public function page() {
        $this->index();
    }

    public function search() {
        //กด link จากหน้า member
        if ($this->uri->segment(4) == 'member') {
            $sale = $this->uri->segment(5);
            $status = base64_decode(base64_decode(base64_decode(base64_decode($this->uri->segment(6)))));
            $search = array('customer' => '',
                'representative' => '',
                'stat' => ($status > 0) ? $status : '',
                'date' => '',
                'sale' => $sale);
        } else if ($this->uri->segment(4) == 'customer') {
            $cus_id = $this->uri->segment(5);
            $data = $this->model_admin_customer->customer_data(array('customer_id' => $cus_id));
            $search = array('customer' => $data[0]['customer_name'],
                'representative' => '',
                'stat' => '',
                'date' => '',
                'sale' => '');
        }

        $data = $this->input->post();
        if (isset($data) && !empty($data)) {
            $arr['search_order'] = $data;
            $this->session->set_userdata($arr);
        } else if (isset($search) && !empty($search)) {
            $arr['search_order'] = $search;
            $this->session->set_userdata($arr);
        }
        $this->index();
    }

    public function reset_search() {
        $this->session->unset_userdata('search_order');
        $this->index();
    }

    public function edit() {
        $id = $this->uri->segment(4);
        $data['temp'] = $this->model_admin_template->gen();
        $where = array('order_id' => $id);
        $cus = $this->model_admin_order->order_data($where);
        $data['customer'] = $cus[0];
        $where = array('FK_order_id' => $id);
        $data['status'] = $this->status;
        $data['detail'] = $this->model_admin_order->order_detail($where);
        if ($this->uri->segment(5) == 'message') {
            $this->model_admin_order->read_message($id);
        }
        $this->load->view('sitecontrol/order_edit', $data);
    }

    public function update() {
        $data = $this->input->post();
        $arr = array('title' => 'Error', 'detail' => 'Update data Error!!', 'url' => base_url('sitecontrol/order'));
        if (isset($data) && !empty($data)) {
            $rs = $this->model_admin_order->order_update($data);
            if ($rs) {
                $arr = array('title' => 'Update', 'detail' => 'Update data Order Success!!', 'url' => base_url('sitecontrol/order'));
                echo $this->model_utility->alert($arr);
            } else {
                echo $this->model_utility->alert($arr);
            }
        } else {
            echo $this->model_utility->alert($arr);
        }
    }

    public function delete() {
        $id = $this->input->post('id');
        $arr = array('order_id' => $id);
        $rs = $this->model_admin_order->order_delete($arr);
        if ($rs) {
            echo $id;
        }
    }

    public function customer() {
        $data = $this->uri->segment(4);
        $data = array('customer' => urldecode($data), 'representative' => '', 'stat' => '', 'date' => '', 'sale' => '');
        if (isset($data) && !empty($data)) {
            $arr['search_order'] = $data;
            $this->session->set_userdata($arr);
        }
        $this->index();
    }

    public function sales() {
        $data = $this->uri->segment(4);
        $data = array('customer' => '', 'representative' => '', 'stat' => '', 'date' => '', 'sale' => urldecode($data));
        if (isset($data) && !empty($data)) {
            $arr['search_order'] = $data;
            $this->session->set_userdata($arr);
        }
        $this->index();
    }

    public function status() {
        $data = $this->input->post();
        $this->model_admin_order->change_status($data);
    }

}
