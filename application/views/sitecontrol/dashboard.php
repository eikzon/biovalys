<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <h1><i class="fa fa-bar-chart fa-lg"></i> Dashboard</h1>
        <ol class="breadcrumb">
            <li><a href="#"> Home</a>
            </li>
            <li class="active">Dashboard</li>
        </ol>
    </div>

    <div class="col-sm-6">
        <div class="box">
            <h4 class="box-title">New Order</h4>
            <?PHP if (isset($order_list) && !empty($order_list)) { ?>
                <ul class="list-unstyled list-data">
                    <?PHP
                    foreach ($order_list as $key_ord => $ord) {
                        if ($key_ord < 6) {
                            ?>
                    <a href="<?PHP echo base_url('sitecontrol/order/edit/' . $ord['d_type'] . '/' . $ord['d_oid']); ?>" title="<?php echo $ord['d_code'];?>">
                                <li>
                                    <span class="order-num"> Order no <?PHP echo $ord['d_code']; ?></span>
                                    <?PHP
                                    if ($ord['d_type'] == "foc") {
                                        echo " F.O.C ";
                                    } else if ($ord['d_type'] == "lo") {
                                        echo number_format($model->order_total_price_lo($ord['d_oid']), 2) . " Baht ";
                                    } else {
                                        echo number_format($model->order_total_price_so($ord['d_oid']), 2) . " Baht ";
                                    }
                                    echo $model->order_show_status($ord['d_approve']);
                                    ?>
                                </li>
                            </a>
                            <?PHP
                        } else {
                            echo '<li class="text-right"><a href="' . base_url('sitecontrol/order') . '">Read all >></a></li>';
                            break;
                        }
                    }
                    ?>

                </ul>
            <?PHP } ?>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="box col-xs-12">
            <h4 class="box-title">New CA</h4>
            <button class="btn btn-box-tool" onclick="javascript:window.location.href = '<?PHP echo base_url("sitecontrol/customer/add"); ?>'"><i class="fa fa-plus"></i>
            </button>
            <?PHP if (!empty($customer_list[0]) && isset($customer_list[0])) { ?>
                <ul class="list-unstyled list-data">
                    <?PHP
                    foreach ($customer_list as $key_cus => $cus) {
                        if ($key_cus < 6) {
                            ?>
                            <!--<li class="col-xs-12">-->
                            <a href="<?PHP echo base_url("sitecontrol/customer/edit/" . $cus['customer_id']) ?>" title="<?PHP echo $cus['customer_name']; ?>">
                                <li>

                                    <div class="col-xs-2">
                                        <?PHP echo date("d/m/Y", strtotime($cus['customer_date_credit'])); ?>
                                    </div>

                                    <div class="col-xs-4 dashboard-text-overflow">
                                        <?PHP echo $cus['customer_name']; ?>
                                    </div>

                                    <div class="col-xs-3">
                                        <?PHP echo $cus['customer_approve']; ?>
                                    </div>

                                    <div class="col-xs-3 dashboard-text-overflow">
                                        <span title="<?PHP echo $cus['member_name']; ?>"><?PHP echo $cus['member_name']; ?></span>
                                    </div>
                                    <!--<div class="col-xs-3">
                                         <?//PHP echo ($cus['credit_price'] != '')?'<span class="label label-success pull-right" style="margin:11px 0 0 0;">Credit : '.number_format($cus['credit_price']).'</span>':''; ?>
                                    </div>-->

                                    <div class="clearfix"></div>
                                </li>
                            </a>
                            <?PHP
                        } else {
                            echo '<li class="text-right"><a href="' . base_url('sitecontrol/customer') . '">Read all >></a></li>';
                            break;
                        }
                    }
                    ?>
                </ul>
            <?PHP } ?>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="col-sm-12">
        <div class="box inline-box">
            <div class="col-sm-4 col-sm-offset-4">
                <?PHP echo form_open('sitecontrol/home/graph'); ?>
                <div class="input-group">
                    <input type="text" name="sdate" class="form-control datepicker_month" value="<?php echo (!empty($search['sdate'])) ? $search['sdate'] : date('m/Y'); ?>"> 
                    <span class="input-group-btn">                       
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button> 
                    </span>
                </div>
                <?PHP echo form_close(); ?>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="col-sm-4">           
                <h4 class="box-title">Monthly Order</h4>

                <?PHP if ($total_approve > 0 || $total_reject > 0 || $total_waiting > 0) { ?>
                    <div id="donut-chart" style="height: 265px;"></div>
                    <a href="#">
                        <p class="text-right viewmore">
                            View More <i class="fa fa-angle-double-right"></i>
                        </p>
                    </a>
                    <?PHP
                } else {
                    echo "<p>No data</p>";
                }
                ?>
            </div>
            <div class="col-sm-4">               
                <h4 class="box-title">Ranking</h4>
                <div id="bar-chart" style="height: 265px;"></div>
                <?PHP if (count($total_bar) > 0) { ?>
                    <a href="#">
                        <p class="text-right viewmore">
                            View More <i class="fa fa-angle-double-right"></i>
                        </p>
                    </a>
                <?PHP } ?>
            </div>
            <div class="col-sm-4">
                <h4 class="box-title">Top Sale</h4>
                <?PHP if (isset($top_sale) && !empty($top_sale)) { ?>
                    <ul class="list-unstyled list-data">
                        <?PHP
                        foreach ($top_sale as $data) {
                            $per_width = ($data['total_price'] / $max_price) * 100;
                            ?>
                            <li>
                                <a href="#">
                                    <p class="top-sale"> <?PHP echo @$data['member_name']; ?> </p>
                                    <div class="progress lg">
                                        <!-- Change the css width attribute to simulate progress -->
                                        <div class="progress-bar progress-bar-aqua" style="width: <?PHP echo $per_width; ?>%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                            <span><?PHP echo number_format($data['total_price'], 2); ?> Baht</span>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        <?PHP } ?>
                    </ul>
                    <a href="#">
                        <p class="text-right viewmore">
                            View More <i class="fa fa-angle-double-right"></i>
                        </p>
                    </a>
                    <?PHP
                } else {
                    echo "<p>No data</p>";
                }
                ?>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<!-- /.content-wrapper -->
<?PHP
// Gen Template
echo $temp['footer'];
?>