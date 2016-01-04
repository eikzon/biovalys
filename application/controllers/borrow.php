<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class borrow extends CI_Controller {
    
    
    public function __construct()
    {
       parent::__construct();
       $this->model_utility->check_login();
       $this->load->model('model_borrow');
    }

	public function index()
	{
        $this->load->model('model_product');
        $data['customer'] = $this->model_borrow->list_customer();
        $prod = array('product_status'=>1);
        $data['list'] = $this->model_product->product_data($prod);
        $data['temp'] = $this->model_template->gen();
        $this->load->view('borrow',$data);
	}
    
    public function angular()
    {
        $angurla = '
<!DOCTYPE html>
<html lang="en-US">
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
<body ng-app="myApp">
 <div  ng-controller="customersCtrl">
<table>
  <tr ng-repeat="x in names">
    <td>{{ x.customer_name }}</td>
    <td>{{ x.customer_address }}</td>
  </tr>
</table>

</div>
<br>
 <div ng-controller="productCtrl">
<table>
  <tr ng-repeat="x in names">
    <td>{{ x.product_name }}</td>
    <td><img src="'.base_url('assets/img/product').'/{{ x.product_picture }}"></td>
  </tr>
</table>

</div>
<script>
var app = angular.module(\'myApp\', []);
app.controller(\'customersCtrl\', function($scope, $http) {
    $http.get("'.base_url('borrow/json').'")
    .success(function (response) {$scope.names = response.records;});
});
app.controller(\'productCtrl\', function($scope, $http) {
    $http.get("'.base_url('borrow/json').'")
    .success(function (response) {$scope.names = response.prod;});
});
</script>
</body>
</html> 
        ';
        echo $angurla;
    }
    
    public function json()
    {
        $data['records'] = $this->model_borrow->list_customer();
        $this->load->model('model_product');
        $prod = array('product_status'=>1);
        $data['prod'] = $this->model_product->product_data($prod);
        echo json_encode($data);
    }
    
    public function save()
    {
        $arr = $this->input->post();
        if($arr['FK_customer_id']=='')
        {
            $arr = array('title'=>'
 Please Choose Customer','detail'=>'Please Choose Customer For Borrow Product','url'=>base_url('borrow'));
            echo $this->model_utility->alert($arr);
            die();
        }
        $this->model_borrow->check_product($arr);
        $rs = $this->model_borrow->save_borrow($arr);
        if($rs > 0)
        {
            $arr = array('title'=>'
 Borrow Sucsess!!','detail'=>'Please wait for approve','url'=>base_url('borrow'));
            echo $this->model_utility->alert($arr);
            die();
        }
        else
        {
            $arr = array('title'=>'
 Borrow False!!','detail'=>'Please contact manager or Administrator','url'=>base_url('borrow'));
            echo $this->model_utility->alert($arr);
            die();
        }
        
    }
    
}

/* End of file borrow.php */
/* Location: ./application/controllers/borrow.php */