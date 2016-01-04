<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class login extends CI_Controller {

    public function __construct()
    {
       parent::__construct();
    }
    
	public function index()
	{
        $this->session->sess_destroy();
        $data['temp'] = $this->model_template->gen();
		$this->load->view('login',$data);
	}
}

