<?php

if (!defined('BASEPATH'))
    exit('No direct script allowed access');

class report extends CI_Controller {
    public function __construct() {
        parent:: __construct();
        $this->load->model('model_admin_report');
        $this->load->model('model_admin_product');
        $this->load->model('model_admin_zone');
        $this->load->model('model_admin_customer');
    }
    
    public function index() {
        $data['report'][] =  array('name' => 'CA', 'link' => 'report_ca');
//        $data['report'][] =  array('name' => 'CN-LO', 'link' => 'report_cn_lo');
        $data['report'][] =  array('name' => 'CR', 'link' => 'report_cr');
        $data['report'][] =  array('name' => 'FOC', 'link' => 'report_foc');
        $data['report'][] =  array('name' => 'SO2', 'link' => 'report_so2');
        $data['report'][] =  array('name' => 'SO', 'link' => 'report_so');
        $data['report'][] =  array('name' => 'SRC', 'link' => 'report_src');
        $data['report'][] =  array('name' => 'Plot', 'link' => 'report_plot');
//        $data['report'][] =  array('name' => 'WSP', 'link' => 'report_wsp');
//        $data['report'][] =  array('name' => 'MMM', 'link' => 'report_mmm');
                    
        $data['temp'] = $this->model_admin_template->gen();
        $this->load->view('sitecontrol/report', $data);
    }
    
    public function search_report_ca(){
        $data['search_report_ca'] = $this->input->post();
        $this->session->set_userdata($data);
        $this->report_ca();
    }
    
    public function search_report_cr(){
        $data['search_report_cr'] = $this->input->post();
        $this->session->set_userdata($data);
        $this->report_cr();
    }
    
    public function refresh_report_ca(){
        $this->session->unset_userdata('search_report_ca');
        $this->report_ca();
    }
    
    public function refresh_report_cr(){
        $this->session->unset_userdata('search_report_cr');
        $this->report_cr();
    }
    
    public function report_ca(){
        $data['search'] = $this->session->userdata('search_report_ca');
        
        $this->load->library('pagination');
        $data['total'] = count($this->model_admin_report->report_ca_index($data['search']));
        $config["base_url"] = base_url('sitecontrol/report/report_ca');
        $config["total_rows"] = $data['total'];
        $config["per_page"] = 20;
        $config["uri_segment"] = 4;
        $config['num_links'] = 5;
        
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
        
        $data['report_ca_index'] = $this->model_admin_report->report_ca_index($data['search'], $arr);
        $data['customer_list'] = $this->model_admin_report->customer_list();
        $data['customer_type_list'] = $this->model_admin_report->customer_type_list();
        $data['province_list'] = $this->model_admin_report->province_list();
        $data['admin_report'] = $this->model_admin_report;
        $data['temp'] = $this->model_admin_template->gen();
        $data['product_list'] = $this->model_admin_report->product_list();
        
        $this->load->view('sitecontrol/report_ca', $data);
    }
    
    public function report_cn_lo(){
        $data['search'] = $this->input->post();
        $data['customer_list'] = $this->model_admin_report->customer_list();
        $data['province_list'] = $this->model_admin_report->province_list();
        $data['admin_report'] = $this->model_admin_report;
        $data['temp'] = $this->model_admin_template->gen();
        $this->load->view('sitecontrol/report_cn_lo', $data);
    }
    
    public function report_cr(){
        
        $data['search'] = $this->session->userdata('search_report_cr');
        
        $this->load->library('pagination');
        $data['total'] = count($this->model_admin_report->report_cr_index($data['search']));
        $config["base_url"] = base_url('sitecontrol/report/report_cr');
        $config["total_rows"] = $data['total'];
        $config["per_page"] = 20;
        $config["uri_segment"] = 4;
        $config['num_links'] = 5;
        
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
        
        $this->load->model('model_admin_member');
        $set_data = array('sid' => '',
                      'sname' => '',
                      'semail' => '',
                      'slevel' => '3');
        $val['member'] = $set_data; 
        $this->session->set_userdata($val);
        
        $data['temp'] = $this->model_admin_template->gen();
        $data['product_list'] = $this->model_admin_product->product_list();
        $data['member_list'] = $this->model_admin_member->member_list();
        $data['date'] = $this->model_admin_report->report_cr_date(@$data['search']); /*ดึงปีเดือนมาแสดง*/
        $data['report_cr_list'] = $this->model_admin_report->report_cr_index(@$data['search'], $arr);
        $data['zone_list'] = $this->model_admin_zone->zone_list();
        $this->load->view('sitecontrol/report_cr', $data);
    }
    
    public function report_foc(){
        $data['search'] = $this->input->post();
        $data['report_foc_index'] = $this->model_admin_report->report_foc_index($data['search']);
        $data['customer_list'] = $this->model_admin_report->customer_list();
        $data['customer_type_list'] = $this->model_admin_report->customer_type_list();
        $data['province_list'] = $this->model_admin_report->province_list();
        $data['temp'] = $this->model_admin_template->gen();
        $data['product_list'] = $this->model_admin_report->product_list();
        $data['admin_report'] = $this->model_admin_report;
        $this->load->view('sitecontrol/report_foc', $data);
    }
    
    public function report_so2(){
        $data['search'] = $this->input->post();
        $data['report_so2_index'] = $this->model_admin_report->report_so2_index($data['search']);
        $data['customer_list'] = $this->model_admin_report->customer_list();
        $data['customer_type_list'] = $this->model_admin_report->customer_type_list();
        $data['province_list'] = $this->model_admin_report->province_list();
        $data['admin_report'] = $this->model_admin_report;
        $data['temp'] = $this->model_admin_template->gen();
        $data['product_list'] = $this->model_admin_report->product_list();
        $this->load->view('sitecontrol/report_so2', $data);
    }
    
    public function report_so(){
        $data['search'] = $this->input->post();
        $data['report_so_index'] = $this->model_admin_report->report_so_index($data['search']);
        $data['customer_list'] = $this->model_admin_report->customer_list();
        $data['customer_type_list'] = $this->model_admin_report->customer_type_list();
        $data['province_list'] = $this->model_admin_report->province_list();
        $data['admin_report'] = $this->model_admin_report;
        $data['temp'] = $this->model_admin_template->gen();
        $data['product_list'] = $this->model_admin_report->product_list();
        $this->load->view('sitecontrol/report_so', $data);
    }
    
    public function report_src(){
        $data['temp'] = $this->model_admin_template->gen();
        $data['search'] = $this->input->post();
        $data['product_list'] = $this->model_admin_product->product_list();
        $data['zone_list'] = $this->model_admin_zone->zone_list();
        $data['customer_list'] = $this->model_admin_customer->type_list();
        $data['province_list'] = $this->model_admin_report->province_list();
        $data['mindate'] = $this->model_admin_report->mindate();
        $data['report_src_list'] = $this->model_admin_report->report_src_index($data['search']);
        $this->load->view('sitecontrol/report_src', $data);
    }
    
    public function report_plot(){
        $data['search'] = $this->input->post();
        $data['report_plot_index'] = $this->model_admin_report->report_plot_index($data['search']);
        $data['customer_list'] = $this->model_admin_report->customer_list();
        $data['customer_type_list'] = $this->model_admin_report->customer_type_list();
        $data['province_list'] = $this->model_admin_report->province_list();
        $data['admin_report'] = $this->model_admin_report;
        $data['temp'] = $this->model_admin_template->gen();
        $data['product_list'] = $this->model_admin_report->product_list();
        $this->load->view('sitecontrol/report_plot', $data);
    }
    
}

/* End of file report.php */
/* Location ./application/controllers/report.php */