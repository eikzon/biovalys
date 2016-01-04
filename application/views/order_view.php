<?PHP
// Gen Template
echo $temp['head'].$temp['nav_bar'].$temp['menu'];
$btn = '';
if($customer['order_approve']==1)
{
    $color = 'btn-success';
    $text = 'Approved';
}
elseif($customer['order_approve']==2)
{
    $color = 'btn-danger';
    $text = 'Reject';
    $btn = '<a href="'.base_url('order/reorder/'.$customer['order_id']).'" class="btn  btn-lg btn-block btn-warning" >Re-Order</a>';
}
else
{
    $color = 'btn-warning';
    $text = 'Wait';
}
$btn = ($btn<>'')?$btn:'<div class="btn btn-sm btn-block  '.$color.'">'.$text.'</div>';
?>
       <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
              <div class="col-md-10">
              <h1>Sales Order <small>(<?PHP echo $customer['customer_name']; ?>) Order : <?PHP echo $customer['order_number']; ?></small>
                  
              </h1>
                </div>
                <div class="col-md-2" style="">
                    <?PHP echo $btn ?>
                </div>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- Profile Image -->
                        <div class="box box-primary">
                            <div class="box-body box-profile">
                                    <div class="table-responsive">
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Product</th>
                                                <th class="text-center">QTY</th>
                                                <th class="text-center">Price</th>
                                                <th class="text-center">Discount</th>
                                                <th class="text-center">Free</th>
                                                <th class="text-center">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    <?PHP
                                    $num =1;
                                    if(isset($prod) && !empty($prod))
                                    {
                                        foreach($prod as $rs)
                                        {
                                            
                                    ?>
                                        <tr>
                                            <td class="text-center"><?PHP echo $num++; ?></td>
                                            <td><?PHP echo ($rs['FK_product_id']==0)?$rs['item_name'].' (Other)':$rs['product_name'] ?></td>
                                            <td class="text-center"><?PHP echo $rs['item_qty'] ?></td>
                                            <td class="text-center"><?PHP echo number_format($rs['item_price'],2) ?></td>
                                            <td class="text-center"><?PHP echo $rs['item_discount'] ?>%</td>
                                            <td class="text-center"><?PHP echo $rs['item_free'] ?></td>
                                            <td class="text-center"><?PHP echo number_format(($rs['item_subtotal']),2); ?></td>
                                        </tr>
                                    <?PHP
                                        }
                                    }
                                    if(isset($foc) && !empty($foc))
                                    {
                                        foreach($foc as $rs)
                                        {
                                    ?>
                                    <tr>
                                            <td class="text-center"><?PHP echo $num++; ?></td>
                                            <td><?PHP echo $rs['product_name']; ?> (F.O.C)</td>
                                            <td class="text-center"><?PHP echo $rs['foc_qty']; ?></td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        </tr>
                                    <?PHP
                                        }
                                    }
                                    ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-xs-12">
                                    <label class="checkbox">Discount Note</label>
                                    <textarea rows="4" name="order_discount_note" class="form-control" placeholder="Discount Detail" disabled><?PHP echo $customer['order_discount_note']; ?></textarea>
                                </div>
                                <div class="col-xs-12">
                                    <label class="checkbox">Comment From Manager</label>
                                    <textarea rows="4" name="order_remark" class="form-control" placeholder="Comment From Manager" disabled><?PHP echo $customer['order_remark']; ?></textarea>
                                </div>
                            </div>
                            <input type="hidden" name="FK_customer_id" value="<?PHP echo $customer['customer_id']; ?>">
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