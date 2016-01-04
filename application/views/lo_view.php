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
            <div class="col-xs-12">
                <!-- Profile Image -->
                <h3><?PHP echo $lo['ob_code']; ?><br> Status : <?PHP echo $stat[$lo['ob_approve']]; ?> </h3>
                <div class="box box-primary">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Product</th>
                                    <th class="text-center">QTY</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?PHP
                            if(!empty($list) && isset($list))
                            {
                                $num = 1;
                                $table = '';
                                foreach($list as $item)
                                {
                                    $table .= '<tr>
                                                    <td class="text-center">'.$num++.'</td>
                                                    <td>'.$item['product_name'].'</td>
                                                    <td class="text-center">'.$item['obd_qty_borrow'].'</td>
                                                    <td class="text-center">'.number_format($item['obd_price'],2).'</td>
                                                    <td class="text-center">'.number_format($item['obd_total'],2).'</td>
                                                </tr>';
                                }
                                echo $table;
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-body box-profile" >
                        <div class="form-group">
                            <label class="checkbox">So Note</label>
                            <textarea rows="4" name="note" class="form-control" placeholder="Order Note"><?PHP echo $lo['ob_note']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label class="checkbox">Manager Note</label>
                            <textarea rows="4" name="note" class="form-control" placeholder="Order Note" disabled><?PHP echo $lo['ob_remark']; ?></textarea>
                        </div>
                    </div>
                    <!-- /.box-body -->
                </div>
                <a class="btn btn-primary btn-outline btn-lg" role="button" href="<?PHP echo base_url('order'); ?>" ><i class="fa fa-reply"></i>Back</a>
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