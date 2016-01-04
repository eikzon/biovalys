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
                    <form action="<?PHP echo base_url('order/insert_data');?>" method="post">
                    <div class="col-xs-12">
                        <!-- Profile Image -->
                        <h3>Customer : <?PHP echo $name; ?></h3>
                        <div class="box box-primary">
                            <div class="table-responsive">
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">Product</th>
                                                <th class="text-center">QTY</th>
                                                <th class="text-center">Price</th>
                                                <th class="text-center">Discount</th>
                                                <th class="text-center">Free</th>
                                                <th class="text-center">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                            <?PHP 
                            if(isset($cart) && !empty($cart))
                            {
                                $num = 1; 
                                foreach($cart as $item)
                                {
                            ?>
                                        <tr class="row-order<?PHP echo $item['id'] ?>">
                                            <td class="text-center"><?PHP echo $num++; ?></td>
                                            <td><?PHP echo $item['name'] ?></td>
                                            <td class="text-center"><?PHP echo $item['qty'] ?><input type="hidden" class="form-control update-qty numberonly" placeholder="Qty" name="item_qty[<?PHP echo $item['id'] ?>]" id="item_qty<?PHP echo $item['id'] ?>" value="<?PHP echo $item['qty'] ?>"  onchange="get_price(this.value,<?PHP echo $item['id'] ?>,'<?PHP echo base_url('product/get_price'); ?>');" ></td>
                                            <td class="text-center"><?PHP echo number_format($item['subtotal'],2) ?><input type="hidden" class="form-control" placeholder="Price" id="item_price_<?PHP echo $item['id'] ?>" name="item_subtotal[<?PHP echo $item['id'] ?>]" value="<?PHP echo $item['subtotal'] ?>" readonly></td>
                                            <td class="text-center"><?PHP echo ($item['discount']=='')?0:$item['discount']; ?>%<input type="hidden" class="form-control numberonly update-discount" placeholder="Discount" aria-describedby="percent" name="item_discount[<?PHP echo $item['id'] ?>]" maxlength="2" id="item_discount<?PHP echo $item['id'] ?>" onchange="discount(<?PHP echo $item['id'] ?>,this.value)" value="<?PHP echo $item['discount'] ?>" ><input type="hidden" id="price_<?PHP echo $item['id'] ?>" name="item_price[<?PHP echo $item['id'] ?>]" value="<?PHP echo @$item['ori_price'] ?>"></td>
                                            <td class="text-center"><?PHP echo ($item['free']=='')?0:$item['free']; ?><input type="hidden" class="form-control numberonly" placeholder="Giveaway" aria-describedby="giveaway" name="item_free[<?PHP echo $item['id'] ?>]" maxlength="2" id="giveaway_<?PHP echo $item['id'] ?>" readonly value="<?PHP echo $item['free']; ?>" ><input type="hidden" name="FK_product_id[<?PHP echo $item['id'] ?>]" value="<?PHP echo $item['id'] ?>"></td>
                                            <td class="text-center"><a href="#" class="btn-delorder" data-toggle="modal" data-target="#delorder" data-rowid="<?PHP echo $item['rowid'] ?>" data-id="<?PHP echo $item['id'] ?>" data-url="<?PHP echo base_url('order/delete_order'); ?>" ><i class="fa fa-times"></i></a></td>
                                       </tr>
                            <?PHP
                                }
                            }
                            ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="box-body box-profile" >
                                <div class="form-group">
                                    <label class="checkbox">Order Note</label>
                                    <textarea rows="4" name="order_discount_note" class="form-control" placeholder="Discount Note"></textarea>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <input type="hidden" name="FK_customer_id" value="<?PHP echo $this->uri->segment(3); ?>">
                        <a class="btn btn-primary btn-outline btn-lg" role="button" href="<?PHP echo base_url('customer/order/'.$this->uri->segment(3)); ?>" ><i class="fa fa-reply"></i>ฺBack</a>
                        <button class="btn btn-primary btn-outline btn-lg pull-right" role="button" ><i class="fa fa-check-circle"></i>Order</button>
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