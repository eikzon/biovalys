<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class product extends CI_Controller {

    public function __construct()
    {
       parent::__construct();
       $this->model_utility->check_login();
       $this->load->model('model_product');
    }
    
	public function index()
	{
        $data['temp'] = $this->model_template->gen();
        $data['list'] = $this->model_product->list_product();
		$this->load->view('product',$data);
	}
    
    public function get_price()
    {
        $data = $this->input->post();
        if(isset($data) && !empty($data))
        {
            $pwhere = array('rate_product_id'=>$data['product_id'],'rate_customer_id'=>$data['customer'],'rate_package_id'=>$data['package']);
            $prod = $this->model_product->get_price($pwhere);
            
            $free = $this->model_product->product_free($data);
            $arr = array('product_price'=>(!empty($prod) && $prod[0]['product_price'] <> '')?$prod[0]['product_price']:'');
            $arr = array_merge($arr,array('free'=>"$free"));
            echo (isset($arr) && !empty($arr))?json_encode($arr):'';
        }
    }
    
}
