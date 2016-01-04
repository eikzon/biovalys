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
                    <form action="<?PHP echo base_url('order/save');?>" method="post">
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
                                                <th class="text-center">Package</th>
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
                                    if($item['customer'] == $this->uri->segment(3) && !empty($item['customer']) && isset($item['customer']))
                                    {
                            ?>
                                        <tr class="row-order<?PHP echo $item['id'] ?>">
                                            <td class="text-center"><?PHP echo $num++; ?></td>
                                            <td class="text-center"><?PHP echo $type[$item['type']]; ?></td>
                                            <td><?PHP echo $item['name'] ?></td>
                                            <td><?PHP echo $pack[$item['package']] ?></td>
                                            <td class="text-center"><?PHP echo $item['qty'] ?>
                                            </td>
                                            <td class="text-center"><?PHP echo ($item['type']<>2)?number_format($item['subtotal'],2):'-'; ?>
                                            </td>
                                            <td class="text-center"><?PHP echo ($item['type']==1)?($item['discount']=='')?'0%':$item['discount'].'%':'-'; ?></td>
                                            <td class="text-center"><?PHP echo ($item['type']==1)?($item['free']=='')?0:$item['free']:'-'; ?></td>
                                            <td class="text-center"><a href="#" class="btn-delorder" data-toggle="modal" data-target="#delorder" data-rowid="<?PHP echo $item['rowid'] ?>" data-id="<?PHP echo $item['id'] ?>" data-url="<?PHP echo base_url('order/delete_order'); ?>" ><i class="fa fa-times"></i></a></td>
                                       </tr>
                            <?PHP
                                    }
                                }
                            }
                            ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="box-body box-profile" >
                                <div class="form-group">
                                    <label class="checkbox">Order Delivery</label>
                                    <input class="form-control datepicker" name="delivery">
                                </div>
                                <div class="form-group">
                                    <label class="checkbox">Order Note</label>
                                    <textarea rows="4" name="note" class="form-control" placeholder="Order Note"></textarea>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <input type="hidden" name="customer_id" value="<?PHP echo $this->uri->segment(3); ?>">
                        <input type="hidden" name="new" value="1">
                        <a class="btn btn-primary btn-outline btn-lg" role="button" href="<?PHP echo base_url('customer/neworder/'.$this->uri->segment(3)); ?>" ><i class="fa fa-reply"></i>ฺBack</a>
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