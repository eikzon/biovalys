<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class customer extends CI_Controller {

    var $status = array('0' => 'Wait', '1' => 'Approved', '2' => 'Reject');

    public function __construct() {
        parent::__construct();
        $this->load->model('model_admin_customer');
    }

    public function index() {
        $this->load->library('pagination');
        $data['total'] = count($this->model_admin_customer->customer_list());
        $config["base_url"] = base_url('sitecontrol/customer/page');
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

        $data['cus_type'] = $this->model_admin_customer->type_list();
        $data['search'] = $this->session->userdata('search_customer');
        $data['customer_list'] = $this->model_admin_customer->customer_list($arr);
        $data['zone_list'] = $this->model_admin_customer->zone_data();
        $data['temp'] = $this->model_admin_template->gen();
        $data['status'] = $this->status;
        $this->load->view('sitecontrol/customer', $data);
    }

    public function page() {
        $this->index();
    }

    public function search() {
        $zone = base64_decode(base64_decode(base64_decode(base64_decode($this->uri->segment(4)))));
        $data = $this->input->post();
        if (isset($data) && !empty($data)) {
            $arr['search_customer'] = $data;
            $this->session->set_userdata($arr);
        } else if (isset($zone) && !empty($zone)) {
            $search = array('sid' => '',
                'sname' => '',
                'scus_type' => '',
                'szone_id' => $zone,
                'sstatus' => '');
            $arr['search_customer'] = $search;
            $this->session->set_userdata($arr);
        }
        $this->index();
    }

    public function refresh() {

        $data = array('sid' => '',
            'sname' => '',
            'scus_type' => '',
            'szone_id' => '',
            'sstatus' => '');
        $arr['search_customer'] = $data;
        $this->session->set_userdata($arr);
        $this->index();
    }

    public function add() {
        $data['temp'] = $this->model_admin_template->gen();
        $data['type_list'] = $this->model_admin_customer->type_list();
        $data['province_list'] = $this->model_admin_customer->province_list();
        $data['zone_list'] = $this->model_admin_customer->zone_data();
        $data['product_list'] = $this->model_admin_customer->product_list();
        $this->load->view('sitecontrol/customer_add', $data);
    }

    public function insert() {
        $data = $this->input->post();
        echo $this->model_admin_customer->customer_insert($data);
        //$this->index();
        $arr = array('title' => '<i class="fa fa-exclamation-circle"></i>
 Add Customer ', 'detail' => 'Add successfully', 'url' => base_url('sitecontrol/customer'));
        echo $this->model_utility->alert($arr);
    }

    public function edit() {
        $data['temp'] = $this->model_admin_template->gen();

        $id = $this->uri->segment(4);
        $data['type_list'] = $this->model_admin_customer->type_list();
        $data['customer'] = $this->model_admin_customer->customer_edit($id);
        $data['province_list'] = $this->model_admin_customer->province_list();
        $data['zone_list'] = $this->model_admin_customer->zone_data();
        $data['product_list'] = $this->model_admin_customer->product_list();
        $data['rate_price'] = $this->model_admin_customer->rate_price($id);
        $this->load->view('sitecontrol/customer_edit', $data);
    }

    public function member_name() {
        $id = $this->uri->segment(4);
        echo $this->model_admin_customer->member_name($id);
    }

    public function update() {
        $data = $this->input->post();
        $id = $this->uri->segment(4);
        $this->model_admin_customer->customer_update($data, $id);
        $arr = array('title' => '<i class="fa fa-exclamation-circle"></i>
 Edit Customer ', 'detail' => 'Edit successfully', 'url' => base_url('sitecontrol/customer/edit/' . $id));
        echo $this->model_utility->alert($arr);
    }

    public function delete() {
        $data['temp'] = $this->model_admin_template->gen();

        $id = $this->uri->segment(4);
        $this->model_admin_customer->customer_delete($id);
        $arr = array('title' => '<i class="fa fa-exclamation-circle"></i>
 Delete Customer ', 'detail' => 'Delete successfully', 'url' => base_url('sitecontrol/customer'));
        echo $this->model_utility->alert($arr);
    }

    public function export_csv() {

        //ดาว์นโหลดไฟล์
        $this->load->helper('download');
        //ดึงข้อมูลที่จะทำไฟล์ excel
        $data = $this->model_admin_customer->export_csv();
        $export_data = "Customer Date " . date("d-m-Y H:i") . " \n";
        $export_data .= "No, Customer ID, Customer Name, Representative Name, Customer Type, Credit \n";
        for ($i = 0; $i < count($data); $i++) {
            $export_data .= $data[$i];
        }
        $name = "export_master_" . date("d-m-Y") . ".csv"; //ชื่อไฟล์
        force_download($name, $export_data); //ดาว์นโหลดไฟล์
    }
    
    public function print_ca() {
        $id = $this->uri->segment(4);
        $data['customer'] = $this->model_admin_customer->customer_detail($id);
        $this->load->view('sitecontrol/print_ca', $data);
    }
    
//    public function import() {
//        $i = 1;
//        $inputcsv_product = fopen(@$_FILES["import"]["tmp_name"], "r");
//        while ((@$objArr_product = fgetcsv(@$inputcsv_product, 2000, ",")) !== FALSE) {
//            if($i > 1){
//                $date = explode("/", $objArr_product[2]);
//                $format_date = @$date[2] . "-" . @$date[1] . "-" . @$date[0];
//                $member = $this->db->where('FK_zone_id', @$objArr_product[3])->get('bio_member')->first_row('array');
//                $data = array(
//                    "customer_credit_number"=> @$objArr_product[1],
//                    "customer_date_credit" => $format_date,
//                    "customer_date_register" => date('Y-m-d H:i:s'),
//                    "FK_member_id" => $member['member_id'],
//                    "FK_zone_id" => @$objArr_product[3],
//                    "customer_number" => @$objArr_product[4],
//                    "FK_type_id" => @$objArr_product[5],
//                    "customer_military" => @$objArr_product[6],
//                    "customer_provincial" => @$objArr_product[7],
//                    "customer_name" => @$objArr_product[8],
//                    "customer_common" => @$objArr_product[9],
//                    "customer_province" => @$objArr_product[10],
//                    "customer_rebate_normal" => @$objArr_product[11],
//                    "customer_rebate_extra_s" => @$objArr_product[12],
//                    "customer_rebate_extra_td" => @$objArr_product[13],
//                    "customer_payment_term" => @$objArr_product[14],
//                    "customer_credit_price" => @$objArr_product[15],
//                    "customer_taxid" => @$objArr_product[16],
//                    "customer_remark" => @$objArr_product[17],
//                    "customer_approve" => 1,
//                    "customer_status" => 1,
//                );
//                $this->db->insert('bio_customer', $data);
//            }
//            $i++;
//        }
//        fclose($inputcsv_product);
//        $arr = array('title' => '<i class="fa fa-exclamation-circle"></i>
// Import Customer ', 'detail' => 'Import successfully', 'url' => base_url('sitecontrol/customer'));
//        echo $this->model_utility->alert($arr);
//    }

}
