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
            <form action="<?PHP echo base_url('order/save'); ?>" method="post">
                <div class="col-xs-12">
                    <!-- Profile Image -->
                    <h3>Customer : <?PHP echo $name; ?></h3>
                    <div class="box box-primary">
                        <div class="table-responsive">
                            <table class="table table-condensed">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Type</th>
                                        <th class="text-center">Product</th>
                                        <th class="text-center">Price/Unit</th>
                                        <th class="text-center">QTY</th>
                                        <th class="text-center">Price</th>
                                        <th class="text-center">Free</th>
                                        <th class="text-center">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?PHP
                                    if (isset($cart) && !empty($cart)) {
                                        $num = 1;
                                        $total = 0;
                                        foreach ($cart as $item) {
                                            if ($item['customer'] == $this->uri->segment(3) && !empty($item['customer']) && isset($item['customer'])) {
                                                ?>
                                                <tr class="row-order<?PHP echo $item['id'] ?>">
                                                    <td class="text-center"><?PHP echo $num++; ?></td>
                                                    <td class="text-center"><?PHP echo $type[$item['type']]; ?></td>
                                                    <td><?PHP echo $item['name'] ?></td>
                                                    <td class="text-center"><?PHP echo $item['ori_price'] ?></td>
                                                    <td class="text-center"><?PHP echo $item['qty'] ?></td>
                                                    <td class="text-center"><?PHP echo ($item['type'] <> 2) ? number_format($item['subtotal'], 2) : '-'; ?></td>
                                                    <td class="text-center"><?PHP echo ($item['type'] == 1) ? ($item['free'] == '') ? 0 : $item['free'] : '-'; ?></td>
                                                    <td class="text-center"><a href="#" class="btn-delorder" data-toggle="modal" data-target="#delorder" data-rowid="<?PHP echo $item['rowid'] ?>" data-id="<?PHP echo $item['id'] ?>" data-url="<?PHP echo base_url('order/delete_order'); ?>" ><i class="fa fa-times"></i></a></td>
                                                </tr>
                                                <?PHP
//                                                if($item['type'] != 2){
//                                                    $total += $item['subtotal'];
//                                                }
                                            }
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="box-body box-profile" >
                            <div class="form-group">
                                <label class="checkbox">Order Discount</label>
                                <div class="input-group col-sm-12 ">
                                    <input type="text" class="form-control onlyint" name="discount" value="<?php echo @$cus[0]['customer_last_discount'];?>">
                                    <div class="input-group-addon">%</div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="checkbox">Order Delivery</label>
                                <input class="form-control datepicker" name="delivery" value="<?php echo (date('d/m/Y', strtotime(@$last['order_date_delivery'])) != '01/01/1970')?date('d/m/Y', strtotime($last['order_date_delivery'])):'';?>" required>
                            </div>
                            <div class="form-group">
                                <label class="checkbox">Time of receipt</label>
                                <input class="form-control" name="time_receipt" maxlength="50" value="<?php echo @$last['order_contact_date'];?>" required>
                            </div>
                            <div class="form-group">
                                <label class="checkbox">Order Contact Name</label>
                                <input class="form-control" name="contact_name" maxlength="150" value="<?php echo @$last['order_contact_name'];?>" required>
                            </div>
                            <div class="form-group">
                                <label class="checkbox">Order Contact Department</label>
                                <input class="form-control" name="contact_dep" maxlength="150" value="<?php echo @$last['order_contact_dep'];?>" required>
                            </div>
                            <div class="form-group">
                                <label class="checkbox">Order Contact Phone</label>
                                <input class="form-control" name="contact_tel" maxlength="50" value="<?php echo @$last['order_contact_tel'];?>" required>
                            </div>
                            <div class="form-group">
                                <label class="checkbox">Order Tax Id</label>
                                <input class="form-control onlyint" name="tax_id" value="<?php echo @$cus[0]['customer_taxid'];?>" maxlength="13" required>
                            </div>
                            <div class="form-group">
                                <label class="checkbox">Card tear.</label>
                                <input class="form-control onlyint" name="card_tear" value="<?php echo @$last['order_card_tear'];?>" required>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <input type="hidden" name="customer_id" value="<?PHP echo $this->uri->segment(3); ?>">
                    <a class="btn btn-primary btn-outline btn-lg" role="button" href="<?PHP echo base_url('customer/order/' . $this->uri->segment(3)); ?>" ><i class="fa fa-reply"></i>Back</a>
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