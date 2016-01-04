<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class product extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_admin_product');
    }

    public function index() {
        $this->load->library('pagination');
        $data['total'] = count($this->model_admin_product->product_list());
        $config["base_url"] = base_url('sitecontrol/product/page');
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

        $data['search'] = $this->session->userdata('product');
        $data['product_list'] = $this->model_admin_product->product_list($arr);
        $data['temp'] = $this->model_admin_template->gen();
        $this->load->view('sitecontrol/product', $data);
    }

    public function page() {
        $this->index();
    }

    public function search() {
        $data = $this->input->post();
        if (isset($data) && !empty($data)) {
            $arr['product'] = $data;
            $this->session->set_userdata($arr);
        }
        $this->index();
    }

    public function refresh() {
        $data = array('sid' => '',
            'sname' => '');
        $arr['product'] = $data;
        $this->session->set_userdata($arr);
        $this->index();
    }

    public function add() {
        $data['temp'] = $this->model_admin_template->gen();
        $this->load->view('sitecontrol/product_add', $data);
    }

    public function insert() {
        $data = $this->input->post();
        $last_id = $this->model_admin_product->product_insert($data);

        $config['upload_path'] = 'assets/img/product/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '100';
        $config['max_width'] = '200';
        $config['max_height'] = '148';

        $file = $this->model_utility->do_upload('picture', $config);
        $file = (isset($file['upload_data']['file_name']) && !empty($file['upload_data']['file_name'])) ? $file['upload_data']['file_name'] : '';
        $this->model_admin_product->product_image($file, $last_id);
        echo "<script>window.location='" . base_url('sitecontrol/product') . "'</script>";
        exit;
    }

    public function edit() {
        $data['temp'] = $this->model_admin_template->gen();

        $id = $this->uri->segment(4);
        $data['product'] = $this->model_admin_product->product_edit($id);
        $this->load->view('sitecontrol/product_edit', $data);
    }

    public function update() {
        $data = $this->input->post();
        $id = $this->uri->segment(4);
        $this->model_admin_product->product_update($data, $id);
        if(!empty($_FILES['picture']['tmp_name'])){
            $config['upload_path'] = 'assets/img/product/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size'] = '100';
            $config['max_width'] = '200';
            $config['max_height'] = '148';

            $file = $this->model_utility->do_upload('picture', $config);
            $file = (isset($file['upload_data']['file_name']) && !empty($file['upload_data']['file_name'])) ? $file['upload_data']['file_name'] : '';
            $this->model_admin_product->product_image($file, $id);
        }
        echo "<script>window.location.href='" . base_url('sitecontrol/product') . "'</script>";
        exit;
    }

    public function delete() {
        $data['temp'] = $this->model_admin_template->gen();

        $id = $this->uri->segment(4);
        $this->model_admin_product->product_delete($id);
        $this->index();
    }

    public function detail() {
        $data['temp'] = $this->model_admin_template->gen();

        $id = $this->uri->segment(4);
        $data['product'] = $this->model_admin_product->product_edit($id);
        $this->load->view('sitecontrol/product_detail', $data);
    }

    public function export_csv() {
        $this->model_admin_product->export_csv();
        exit();
    }

}
