<?PHP
// Gen Template
echo $temp['head'].$temp['nav_bar'].$temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <form action="<?PHP echo base_url('order/new_summary');?>" method="post">
                    <div class="col-xs-12">
                        <h3>Customer : <?PHP echo $name; ?></h3>
                        <!-- Profile Image -->
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
                                          <div class="col-xs-3"><img src="'.$img.'" class="img-thumbnail img-responsive"></div>
                                          <div class="col-xs-6">'.$item['product_name'].'</div>
                                          <div class="col-xs-3"><a href="#" data-toggle="modal" data-target="#modalcart" data-id="'.$item['product_id'].'" data-price="0" data-name="'.$item['product_name'].'" class="btn-prod" ><i class="fa fa-shopping-cart fa-lg" data-toggle="tooltip" data-placement="top" title="Add to Cart"></i></a></div>
                                          <div class="clearfix"></div>
                                          </div>
                                          '; 
                            }
                        }
                        $html .= '</div>
                                </div>';
                        echo $html;
                        ?>
                        <a class="btn btn-primary btn-outline btn-lg" role="button" href="<?PHP echo base_url('order'); ?>" ><i class="fa fa-reply"></i> Back</a>
                        <a class="btn btn-primary btn-outline btn-lg pull-right" role="button" href="<?PHP echo base_url('order/new_summary/'.$this->uri->segment(3)); ?>" ><i class="fa fa-cart-plus"></i> Order</a>
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
        <!-- modal add to cart -->
<div class="modal fade" id="modalcart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="product_name">Add Order</h4>
      </div>
      <div class="modal-body">
          <label class="checkbox"><small>Type</small></label>
            <div>
              <select class="form-control selectpicker" name="type" id="type" data-width="100%">
                  <option value="1">Order</option>
                  <option value="2">F.O.C</option>
                  <option value="3">Borrow</option>
              </select>
            </div>
          <label class="pull-left text-right"><small>QTY</small></label>
            <input class="form-control numberonly item_qty_new" placeholder="Qty" name="item_qty" id="item_qty" value="1" onchange="calulate_price('item_qty','price','item_discount')" required>
          <label class="pull-left text-right"><small>Package</small></label>
            <select name="package" id="package" class="form-control selectpicker">
                <?PHP echo $pack; ?>
            </select>
          <div class="cart_type">
          <label class="pull-left text-right"><small>Item Price</small></label>
            <input class="form-control numberonly" placeholder="Item Price" name="price" id="price" value="0" onchange="calulate_price('item_qty','price','item_discount')">
            <label class="checkbox"><small>Discount</small></label>
            <div class="input-group">
              <input type="text" class="form-control numberonly" placeholder="Discount" aria-describedby="percent" name="item_discount" maxlength="2" id="item_discount" onchange="calulate_price('item_qty','price','item_discount')" ><span class="input-group-addon" id="percent">%</span>
            </div>
            <label class="pull-left text-right"><small>Price</small></label>
            <input class="form-control" placeholder="Price" id="item_price" class="item_price" name="item_price[]" value="" readonly >
            <input type="hidden" id="price" value="">
            <label class="checkbox"><small>Free</small></label>
            <div class="input-group">
              <input type="text" class="form-control numberonly" placeholder="Free" aria-describedby="giveaway" name="giveaway[]" maxlength="2" id="giveaway" value=""  >
              <span class="input-group-addon" id="giveaway"><i class="fa fa-gift"></i>
</span>
              <input type="hidden" id="customer_id" value="<?PHP echo $this->uri->segment(3); ?>" >
            </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-order" data-toggle="modal" data-target="#order" data-dismiss="modal" >Order</button>
      </div>
    </div>
  </div>
</div>
<?PHP
// Gen Template
echo $temp['footer'];
?>