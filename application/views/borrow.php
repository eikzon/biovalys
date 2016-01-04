<?PHP
// Gen Template
echo $temp['head'].$temp['nav_bar'].$temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            
            <!-- Main content -->
            <section class="content">
                <h3>Borrow product</h3>
                <div class="row">
                    <form action="<?PHP echo base_url('borrow/save');?>" method="post">
                    <div class="col-xs-12">
                        <div class="col-xs-12 input-group customer-select">
                            <label class="checkbox">Select Customer</label>
                            <select class="form-control selectpicker" name="FK_customer_id" >
                                <option value="">Select Customer</option>
                                <?PHP
                                if(isset($customer) && !empty($customer))
                                {
                                    $opcus = '';
                                    foreach($customer as $cus)
                                    {
                                        $opcus .= '<option value="'.$cus['customer_id'].'">'.$cus['customer_name'].'</option>'; 
                                    }
                                    echo $opcus;
                                }
                                ?>
                            </select>
                          </div>
                         <?PHP 
                        $html = '<div class="box box-primary">
                                 <div class="box-body box-profile">';
                        if(isset($list) && !empty($list))
                        {
                            
                            foreach($list as $item)
                            {
                                $arr = array('file'=>$item['product_picture'],'path'=>'assets/img/product');
                                $img = $this->model_utility->show_images($arr);
                                $html .= '<div class="row" style="margin:5px;">
                                          <div class="col-xs-12">'.$item['product_name'].'</div>
                                          <div class="col-xs-12"><div class="input-group">
  <input type="text" class="form-control" aria-label="QTY." name="borrow['.$item['product_id'].']">
  <span class="input-group-addon">QTY.</span>
</div></div>
                                          <div class="clearfix"></div>
                                          </div>
                                          '; 
                            }
                        }
                        $html .= '</div>
                                </div>';
                        echo $html;
                        ?>
                        <button class="btn btn-primary btn-outline btn-lg pull-right"><i class="fa fa-cart-plus"></i> Borrow</button>
                        <!-- /.box -->
                        <!-- About Me Box -->
                    </div>
                    <!-- /.col -->
                    </form>
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
<?PHP
// Gen Template
echo $temp['footer'];
?>