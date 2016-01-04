<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <form action="<?PHP echo base_url('order/summary'); ?>" method="post">
                <div class="col-xs-12">
                    <h3>Customer : <?PHP echo @$cus['customer_name']; ?></h3>
                    <!-- Profile Image -->
                    <?PHP
                    echo '<div class="box box-primary">
                                 <div class="box-body box-profile">';
                    if (!empty($list)) {
                        $sess_pri = $this->session->userdata('price_customer');
                        foreach ($list as $item) {
                            if($item['rate_price'] > 0){
                                $set['price_customer'][@$cus['customer_id']][@$item['product_id']] = array(
                                    'price' => @$item['rate_price'],
                                    'id' => @$item['product_id'],
                                );
                            }else{
                                $set['price_customer'][@$cus['customer_id']][@$item['product_id']] = array(
                                    'price' => @$sess_pri[@$cus['customer_id']][@$item['product_id']]['price'],
                                    'id' => @$item['product_id'],
                                );
                            }
                            $arr = array('file' => $item['product_picture'], 'path' => 'assets/img/product');
                            $img = $this->model_utility->show_images($arr);
                            echo '<div class="row" style="margin:5px;">
                                          <div class="col-xs-3"><img src="' . $img . '" class="img-thumbnail img-responsive"></div>
                                          <div class="col-xs-6">' . $item['product_name'] . '</div>
                                          <div class="col-xs-3"><a href="#" data-toggle="modal" data-target="#modalcart" data-id="' . $item['product_id'] . '" data-price="0" data-name="' . $item['product_name'] . '" class="btn-prod" ><i class="fa fa-shopping-cart fa-3x " title="Add to Cart"></i></a></div>
                                          <div class="clearfix"></div>
                                          </div>
                                          ';
                        }
                    }
                    
                            $this->session->set_userdata($set);
//                    print_r($set);
                    echo '</div>
                                </div>';
                    ?>
                    <a class="btn btn-primary btn-outline btn-lg" role="button" href="<?PHP echo base_url('order'); ?>" ><i class="fa fa-reply"></i> Back</a>
                    <a class="btn btn-primary btn-outline btn-lg pull-right" role="button" href="<?PHP echo base_url('order/summary/' . $this->uri->segment(3)); ?>" ><i class="fa fa-cart-plus"></i> Order (<span class="order-count"><?php echo $count;?></span>)</a>
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
            <div class="modal-header" style="padding: 10px;">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="product_name">Add Order</h4>
            </div>
            <div class="modal-body" style="padding: 10px;" style="overflow-y: scroll;">
                <label class="checkbox"><small>Type</small></label>
                <div>
                    <select class="form-control selectpicker" name="type" id="type" data-width="100%">
                        <option value="1">Order</option>
                        <option value="2">F.O.C</option>
                        <option value="3">Borrow</option>
                    </select>
                </div>
                <label class="checkbox"><small>QTY</small></label>
                <input class="form-control numberonly item_qty" placeholder="Qty" name="item_qty" id="item_qty" value="1" onkeyup="calulate_price('item_qty', 'price', 'item_discount')" required>
                <div class="cart_type">
                    <label class="checkbox"><small>Item Price</small></label>
                    <div class="input-group">
                        <input class="form-control numberonly" placeholder="Item Price" name="price" id="price" value="0" onkeyup="calulate_price('item_qty', 'price', 'item_discount')"><span class="input-group-addon">B</span>
                    </div>
<!--                    <label class="checkbox hide"><small>Discount</small></label>
                    <div class="input-group hide">
                        <?php // print_r($cus);?>
                        <input type="text" class="form-control numberonly" placeholder="Discount" value="<?php echo $cus['customer_rebate_normal'];?>" aria-describedby="percent" name="item_discount" maxlength="2" id="item_discount" onkeyup="calulate_price('item_qty', 'price', 'item_discount')" ><span class="input-group-addon" id="percent">%</span>
                    </div>-->
                    <label class="checkbox"><small>Total Price</small></label>
                    <input class="form-control" placeholder="Price" id="item_price" class="item_price" name="item_price" value="" readonly="">
                    <label class="checkbox"><small>Free</small></label>
                    <div class="input-group">
                        <input type="text" class="form-control numberonly" placeholder="Free" aria-describedby="giveaway" name="giveaway" maxlength="2" id="giveaway" value=""  >
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