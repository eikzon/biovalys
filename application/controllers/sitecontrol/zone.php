<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class zone extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_admin_zone');
    }

    public function index() {
        $this->load->library('pagination');
        $data['total'] = count($this->model_admin_zone->zone_list());
        $config["base_url"] = base_url('sitecontrol/zone/page');
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

        $data['search'] = $this->session->userdata('search_zone');
        $data['zone_list'] = $this->model_admin_zone->zone_list($arr);
        $data['temp'] = $this->model_admin_template->gen();
        $this->load->view('sitecontrol/zone', $data);
    }

    public function page() {
        $this->index();
    }

    public function search() {
        $data = $this->input->post();
        if (isset($data) && !empty($data)) {
            $arr['search_zone'] = $data;
            $this->session->set_userdata($arr);
        }
        $this->index();
    }

    public function refresh() {
        $data = array('sid' => '',
            'sname' => '',
            'srep_name' => '',
            'scus_type' => '');
        $arr['search_zone'] = $data;
        $this->session->set_userdata($arr);
        $this->index();
    }

    public function add() {
        $data['temp'] = $this->model_admin_template->gen();
        $data['area_list'] = $this->model_admin_zone->area_list();
        $this->load->view('sitecontrol/zone_add', $data);
    }

    public function insert() {
        $data = $this->input->post();
        $this->model_admin_zone->zone_insert($data);
        //$this->index();
        $arr = array('title' => '<i class="fa fa-exclamation-circle"></i>
 Add Zone ', 'detail' => 'Add successfully', 'url' => base_url('sitecontrol/zone'));
        echo $this->model_utility->alert($arr);
    }

    public function edit() {
        $data['temp'] = $this->model_admin_template->gen();

        $id = $this->uri->segment(4);
        $data['zone'] = $this->model_admin_zone->zone_edit($id);
        $data['area_list'] = $this->model_admin_zone->area_list();
        $this->load->view('sitecontrol/zone_edit', $data);
    }

    public function update() {
        $data = $this->input->post();
        $id = $this->uri->segment(4);
        $this->model_admin_zone->zone_update($data, $id);
        $arr = array('title' => '<i class="fa fa-exclamation-circle"></i>
 Edit Zone ', 'detail' => 'Edit successfully', 'url' => base_url('sitecontrol/zone/edit/' . $id));
        echo $this->model_utility->alert($arr);
    }

    public function delete() {
        $data['temp'] = $this->model_admin_template->gen();

        $id = $this->uri->segment(4);
        $this->model_admin_zone->zone_delete($id);
        $arr = array('title' => '<i class="fa fa-exclamation-circle"></i>
 Delete Zone ', 'detail' => 'Delete successfully', 'url' => base_url('sitecontrol/zone'));
        echo $this->model_utility->alert($arr);
    }

    public function status() {
        $data = array("id" => $this->uri->segment(4),
            "stat" => $this->uri->segment(5));
        $this->model_admin_zone->change_status($data);
    }

}
