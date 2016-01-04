<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Customer
        </h1>
        <form role="form" action="<?PHP echo base_url('customer/search'); ?>" method="post">
            <div class="form-group">
                <label for="exampleInputEmail1"></label>
                <input type="text" class="form-control  input-lg" id="" placeholder="Search Customer" name="name" value="<?PHP echo $search['name']; ?>">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-outline btn-md btn-block">Search</button>
            </div>
            <div class="form-group">
                <a href="<?PHP echo base_url('customer/add'); ?>" class="btn btn-outline btn-md btn-block">New Customer</a>
            </div>
        </form>
    </section>
    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-xs-12">      
                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <h3 class="box-title">List Customer <small><span class="badge"><?PHP echo $total; ?></span> </small></h3>
                        <style>
                            .fix-hight {  
                                height: 300px !important;
                                overflow: scroll;
                            }
                        </style>
                        <div class="box-body">
                            <div class="list-custom">
                                <ul class="list-group list-group-unbordered">
                                    <?PHP
                                    if (isset($list) && !empty($list)) {
                                        foreach ($list as $rs) {
                                            ?>
                                            <li class="list-group-item">
                                                <div class="col-xs-9">
                                                    <a href="<?PHP echo base_url('customer/detail/' . $rs['customer_id']); ?>">
                                                        <b><?PHP echo $rs['customer_name']; ?></b>
                                                        <div class="text-success"><strong>Code <?PHP echo $rs['customer_credit_number']; ?></strong></div>
                                                    </a>
                                                </div>
                                                <a href="<?PHP echo base_url('customer/order/' . $rs['customer_id']); ?>">
                                                    <button class="btn btn-outline btn-md">
                                                        <span>Order</span>
                                                    </button>
                                                </a>
                                                <div class="clearfix"></div>
                                            </li>
                                            <?PHP
                                        }
                                    } else {
                                        echo '<li class="list-group-item">
                                        <div class="col-xs-12 text-center">
                                            <b>NO DATA</b>
                                        </div>
                                        <div class="clearfix"></div>
                                    </li>';
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="clearfix"></div>
                        <div class="clearfix"></div>
                    </div>
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