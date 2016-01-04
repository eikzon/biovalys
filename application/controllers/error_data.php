<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class error_data extends CI_Controller {

    public function __construct()
    {
       parent::__construct();
    }
    
	public function index()
	{
        $arr = array('title'=>'<i class="fa fa-exclamation-triangle"></i>
</i>Error page','detail'=>'Please Contact Administrator','url'=>base_url(''));
        echo $this->model_utility->alert($arr);
	}
}
