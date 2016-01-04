<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class model_borrow extends CI_Model {

    function __construct()
    {
        parent::__construct();
    }
    
    public function list_customer($arr='')
    {
        if(isset($arr) && !empty($arr))
        {
            $this->db->where($arr);
        }
        $user = $this->session->userdata('member_data'); 
        $where = array('customer_status'=>1,'FK_zone_id'=>$user['FK_zone_id']);
        $data = $this->db->select('*')->from('bio_customer')->where($where)->order_by('customer_id','desc')->get()->result_array();
        return $data;
    }
    
    public function save_borrow($arr)
    {
        $this->load->model('model_order');
        $od_data = array('FK_member_id'=>$this->model_utility->member_id(),
                         'FK_customer_id'=>$arr['FK_customer_id'],
                         'order_number'=>$this->model_order->order_number(),
                         'order_approve'=>0,
                         'order_create_date'=>date('Y-m-d H:i:s'),
                         'order_status_borrow'=>1,
                         'order_status'=>1
                        );
        $this->db->insert('bio_order',$od_data);
        $order_id = $this->db->insert_id();
        $arr = array_merge($arr,array('ob_order_id'=>$order_id));
        $ob = $this->insert_order_borrow($arr);
        $arr = array_merge($arr,array('obd_ob_id'=>$ob['id'],'lbd_lb_id'=>$ob['code']));
        $this->insert_detail_borrow($arr);
        return $ob['id'];
        
    }
    
    private function insert_order_borrow($arr)
    {
        $borrow_code = $this->code_order_borrow();
        $ob_qty_borrow = 0;
        if(!empty($arr['borrow']) && isset($arr['borrow']))
        {
            foreach($arr['borrow'] as $key=>$val)
            {
                $ob_qty_borrow += $val; 
            }
        }
        $data = array('ob_order_id'=>$arr['ob_order_id'],'ob_date'=>date('Y-m-d H:i:s'),'ob_qty_borrow'=>$ob_qty_borrow,'ob_qty_amount'=>$ob_qty_borrow,'ob_status'=>1,'ob_code'=>$borrow_code);
        $this->db->insert('bio_order_borrow',$data);
        
        $ob_id = $this->db->insert_id();
        $log = array('lb_borrow_id'=>$ob_id,'lb_order_id'=>$arr['ob_order_id'],'lb_qty_total'=>$ob_qty_borrow);
        $this->insert_log_borrow($log);
        return array('id'=>$ob_id,'code'=>$borrow_code);
    }
    
    private function insert_detail_borrow($arr)
    {
        if(!empty($arr['borrow']) && isset($arr['borrow']))
        {
            foreach($arr['borrow'] as $key=>$val)
            {
                if($val <> '')
                {
                    $data = array('obd_ob_id'=>$arr['obd_ob_id'],'obd_product_id'=>$key,'obd_qty_borrow'=>$val,'obd_qty_amount'=>$val,'obd_status'=>1);
                    $this->db->insert('bio_order_borrow_detail',$data);
                    $log = array('lbd_lb_id'=>$arr['lbd_lb_id'],'lbd_product_id'=>$key,'lbd_qty'=>$val,'lbd_status'=>1);
                    $this->db->insert('bio_log_borrow_detail',$log);
                }
            }
        }
    }
    
    public function code_order_borrow()
    {
        $year = date('y');
        $where = array('ob_date >='=>date('Y').'-01-01');
        $data = $this->db->select('ob_code')->from('bio_order_borrow')->where($where)->order_by('ob_id','desc')->limit(1,0)->get()->result_array();
        if(isset($data) && !empty($data))
        {
            if($data[0]['ob_code']<>'')
            {
                $data = explode('LO'.$year,$data[0]['ob_code']);
                $data = $data[1];
                
            }
            else
            {
                $data = 0;
            }
        }
        else
        {
            $data = 0;
        }
        
        $data = 'LO'.$year.str_pad($data+1,5,"0",STR_PAD_LEFT);
        return $data;
    }
    
    public function check_product($arr)
    {
        $data = 0;
        foreach($arr['borrow'] as $key=>$val)
        {
            if($val <> '')
            {
                $data = 1;
            }
        }
        if($data == 0)
        {
            $arr = array('title'=>'
 Please Choose Product','detail'=>'Please Choose Product For Borrow','url'=>base_url('borrow'));
            echo $this->model_utility->alert($arr);
            die();
        }
    }
    
    private function insert_log_borrow($arr)
    {
        $data = array_merge($arr,array('lb_date'=>date('Y-m-d H:i:s'),'lb_type'=>1,'lb_status'=>1));
        $this->db->insert('bio_log_borrow',$data);
    }

}