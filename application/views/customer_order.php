<?PHP
// Gen Template
echo $temp['head'].$temp['nav_bar'].$temp['menu'];
?>
       <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
              <h1>
                  Sales Order <small>(<?PHP echo $customer['customer_name']; ?>)</small>
              </h1>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">

                        <!-- Profile Image -->
                        <div class="box box-primary">
                            <?PHP echo form_open('order/insert'); ?>
                            <div class="box-body box-profile">
                                <ul class="list-group list-group-unbordered">
                                    <?PHP
                                    if(isset($prod) && !empty($prod))
                                    {
                                        foreach($prod as $rs)
                                        {
                                    ?>
                                    <li class="list-group-item">
                                           <div class="col-xs-6">
                                                <label class="checkbox" for="checkbox<?PHP echo $rs['product_id'] ?>">
                                                    <input type="checkbox" value="<?PHP echo $rs['product_id'] ?>" id="checkbox<?PHP echo $rs['product_id'] ?>" data-toggle="checkbox" name="FK_product_id[<?PHP echo $rs['product_id'] ?>]"> <?PHP echo $rs['product_name'] ?>
                                                </label>
                                            </div>
                                            <div class="col-xs-6 text-right">
                                                <div class="col-xs-12">
                                               <label class="pull-left text-right"><small>QTY</small></label>
                                            <input class="form-control" placeholder="Qty" name="item_qty[<?PHP echo $rs['product_id'] ?>]">
                                        </div>
                                        <div class="col-xs-12">
                                            <label class="pull-left text-right"><small>Price</small></label>
                                            <input class="form-control" placeholder="Price" name="item_price[<?PHP echo $rs['product_id'] ?>]">
                                        </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="clearfix"></div>
                                    </li>
                                    <?PHP
                                        }
                                    }
                                    ?>
                                    <li class="list-group-item">
                                           <div class="col-xs-6">
                                                <label class="checkbox" for="checkbox0">
                                                    <input type="checkbox" value="0" id="checkbox0" data-toggle="checkbox" name="FK_product_id[0]">
                                                    <input type="text" class="form-control" name="item_name[0]" >
                                                </label>
                                            </div>
                                            <div class="col-xs-6 text-right">
                                                <div class="col-xs-12">
                                               <label class="pull-left text-right"><small>QTY</small></label>
                                            <input class="form-control" placeholder="Qty" name="item_qty[0]">
                                        </div>
                                        <div class="col-xs-12 text-right">
                                            <label class="pull-left"><small>Price</small></label>
                                            <input class="form-control" placeholder="Price" name="item_price[0]">
                                        </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="clearfix"></div>
                                    </li>
                                </ul>
                                <div class="col-xs-12">
                                    <label class="checkbox">Discount</label>
                                    <div class="input-group">
                                      <input type="text" class="form-control" placeholder="Discount" aria-describedby="percent" name="order_discount_percent" maxlength="2" id="order_discount_percent" >
                                      <span class="input-group-addon" id="percent">%</span>
                                    </div>
<!--
                                    <select name="order_discount_type" class="form-control">
                                        <option value="0">Not Discount</option>
                                        <option value="1">Discount</option>
                                    </select>
-->
                                </div>
                                <div class="col-xs-12">
                                    <label class="checkbox">Order Note</label>
                                    <textarea rows="4" name="order_discount_note" class="form-control" placeholder="Discount Note"></textarea>
                                </div>
<!--
                                <div class="col-xs-12">
                                    <label class="checkbox">Remark</label>
                                    <textarea rows="4" name="order_remark" class="form-control" placeholder="Remark"></textarea>
                                </div>
-->
                            </div>
                            <input type="hidden" name="FK_customer_id" value="<?PHP echo $customer['customer_id']; ?>">
                            <button type="submit" class="btn btn-outline btn-lg btn-block">Order</button>
                            <?PHP echo form_close(); ?>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                        <!-- About Me Box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
<?PHP
// Gen Template
echo $temp['footer'];
?>