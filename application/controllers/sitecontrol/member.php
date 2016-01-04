<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class member extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_admin_member');
    }

    public function index() {
        $this->load->library('pagination');
        $data['total'] = count($this->model_admin_member->member_list());
        $config["base_url"] = base_url('sitecontrol/member/page');
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

        $data['level'] = $this->model_admin_member->level_list();
        $data['search'] = $this->session->userdata('member');
        $data['member_list'] = $this->model_admin_member->member_list($arr);
        $data['temp'] = $this->model_admin_template->gen();
        $data['func'] = $this->model_admin_member;
        $this->load->view('sitecontrol/member', $data);
    }

    public function page() {
        $this->index();
    }

    public function search() {
        $data = $this->input->post();
        if (isset($data) && !empty($data)) {
            $arr['member'] = $data;
            $this->session->set_userdata($arr);
        }
        $this->index();
    }

    public function refresh() {
        $data = array('sid' => '',
            'sname' => '',
            'semail' => '',
            'slevel' => '');
        $arr['member'] = $data;
        $this->session->set_userdata($arr);
        $this->index();
    }

    public function add() {
        $data['temp'] = $this->model_admin_template->gen();
        $data['level'] = $this->model_admin_member->level_list();
        $data['zone_list'] = $this->model_admin_member->zone_data();
        $this->load->view('sitecontrol/member_add', $data);
    }

    public function insert() {
        $data = $this->input->post();
        $last_id = $this->model_admin_member->member_insert($data);

        $config['upload_path'] = 'assets/img/user/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '100';
        $config['max_width'] = '128';
        $config['max_height'] = '128';

        $file = $this->model_utility->do_upload('picture', $config);
        $file = (isset($file['upload_data']['file_name']) && !empty($file['upload_data']['file_name'])) ? $file['upload_data']['file_name'] : '';
        $this->model_admin_member->member_image($file, $last_id);
        $arr = array('title' => '<i class="fa fa-exclamation-circle"></i>
 Add Member ', 'detail' => 'Add successfully', 'url' => base_url('sitecontrol/member'));
        echo $this->model_utility->alert($arr);
        //$this->index();
    }

    public function edit() {
        $data['temp'] = $this->model_admin_template->gen();
        $id = $this->uri->segment(4);
        $data['level'] = $this->model_admin_member->level_list();
        $data['member'] = $this->model_admin_member->member_edit($id);
        $data['zone_list'] = $this->model_admin_member->zone_data();
        $this->load->view('sitecontrol/member_edit', $data);
    }

    public function update() {
        $data = $this->input->post();
        $id = $this->uri->segment(4);
        $this->model_admin_member->member_update($data, $id);

        $config['upload_path'] = 'assets/img/user/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size'] = '100';
        $config['max_width'] = '128';
        $config['max_height'] = '128';

        $file = $this->model_utility->do_upload('picture', $config);
        $file = (isset($file['upload_data']['file_name']) && !empty($file['upload_data']['file_name'])) ? $file['upload_data']['file_name'] : '';
        $this->model_admin_member->member_image($file, $id);
        $arr = array('title' => '<i class="fa fa-exclamation-circle"></i>
 Edit Member ', 'detail' => 'Edit successfully', 'url' => base_url('sitecontrol/member/edit/' . $id));
        echo $this->model_utility->alert($arr);
//        echo "<script>window.location.href='".base_url('sitecontrol/member')."'</script>";
//        exit;
    }

    public function delete() {
        $data['temp'] = $this->model_admin_template->gen();
        $id = $this->uri->segment(4);
        $this->model_admin_member->member_delete($id);
        $arr = array('title' => '<i class="fa fa-exclamation-circle"></i>
 Delete Member ', 'detail' => 'Delete successfully', 'url' => base_url('sitecontrol/member'));
        echo $this->model_utility->alert($arr);
    }

    public function checkpass() {
        $old = $this->uri->uri_to_assoc(2);
        $arr = array("system_username" => $this->session->userdata('username'), "system_password" => $old['old']);
        echo $this->model_admin_member->member_login($arr);
        exit;
    }

    public function changepass() {
        $data = $this->input->post('new_pass');
        $this->model_admin_member->member_login($data, $this->session->userdata('id'));
        $arr = array('title' => '<i class="fa fa-exclamation-circle"></i>
 Change Password ', 'detail' => 'Change password successfully', 'url' => $this->input->post('link_page'));
        echo $this->model_utility->alert($arr);
//        echo "<script>window.location.href='".$this->input->post('link_page')."'</script>";
//        exit;
    }

    public function export_csv() {
        //ดาว์นโหลดไฟล์
        $this->load->helper('download');
        //ดึงข้อมูลที่จะทำไฟล์ excel
        $data = $this->model_admin_member->export_csv();
        $export_data = "Member Date " . date("d-m-Y H:i") . " \n";
        $export_data .= "No, User Name, Name, Email, Level User, Mobile \n";
        for ($i = 0; $i < count($data); $i++) {
            $export_data .= $data[$i];
        }
        $name = "export_member_" . date("d-m-Y") . ".csv"; //ชื่อไฟล์
        force_download($name, $export_data); //ดาว์นโหลดไฟล์
    }

    public function status() {
        $data = array("id" => $this->uri->segment(4),
            "stat" => $this->uri->segment(5));
        $this->model_admin_member->change_status($data);
    }

}
