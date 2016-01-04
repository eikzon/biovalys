<html>
    <head>
        <meta charset="UTF-8">
        <script src="<?php echo base_url('assets_sitecontrol/js/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets_sitecontrol/js/bootstrap.min.js'); ?>"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets_sitecontrol/css/vendors/bootstrap.css'); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets_sitecontrol/css/print.css'); ?>">
        <title></title>
    </head>
    <body>
        <?php for($a = 1;$a < 3;$a++){?>
        <div class="table-responsive">
            <img src="<?PHP echo base_url('assets_sitecontrol/img/logo.jpg'); ?>" class="print-logo">
            <i class=""></i>
            <table class="table print-border" data-width="100%">
                <thead>
                    <tr>
                        <th class="print-header print-title-data print-border-left" colspan="5">SALES ORDER</th>
                        <th class="print-header print-title-data print-border-right text-right" colspan="4">ยืมสินค้า</th>
                    </tr>
                </thead>
                <thead class="print-title">
                    <tr>
                        <td class="print-title-data-none print-border-left" colspan="3">Sales Order No.</td>
                        <td class="print-title-data">: <?php echo @$customer['c_code'] ?></td>
                        <td class="print-title-data-none">Date</td>
                        <td class="print-title-data" colspan="2">: <?PHP echo date('d F Y', strtotime($customer['order_date_create'])); ?></td>
                        <td class="print-title-data-none text-right"><?php echo ($a == 1)?'SS':'EDP'?></td>
                        <td class="print-title-data-none print-border-right"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-left" colspan="3">Representative Name</td>
                        <td class="print-title-data" colspan="3">: <?PHP echo $customer['member_name']; ?></td>
                        <td class="print-title-data-none">Rep.ID</td>
                        <td class="print-title-data">: <?PHP echo @$customer['zone_code']; ?></td>
                        <td class="print-title-data-none print-border-right"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-left" colspan="3">Customer ID (A/C)</td>
                        <td class="print-title-data" colspan="5">: <?PHP echo @$customer['customer_number']; ?></td>
                        <td class="print-title-data-none print-border-right"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-left" colspan="3">Customer Name</td>
                        <td class="print-title-data" colspan="5">: <?PHP echo @$customer['customer_name']; ?></td>
                        <td class="print-title-data-none print-border-right"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-left" colspan="3">Province</td>
                        <td class="print-title-data" colspan="5">: <?PHP echo @$customer['province_name']; ?></td>
                        <td class="print-title-data-none print-border-right"></td>
                    </tr>
                </thead>
                <tbody class=" print-title">
                    <tr>
                        <th width="2%"></th>
                        <th width="10%"></th>
                        <th width="20%"></th>
                        <th width="20%"></th>
                        <th width="10%"></th>
                        <th width="12%"></th>
                        <th width="12%"></th>
                        <th width="12%"></th>
                        <th width="2%"></th>
                    </tr>
                    <tr>
                        <td class="print-border text-center" colspan="2">Code</td>
                        <td class="print-border text-center" colspan="3">Product</td>
                        <td class="print-border text-center">Quantity</td>
                        <td class="print-border text-center">Price/unit<br/>(Bath)</td>
                        <td class="print-border text-center" colspan="2">Total<br/>(Bath)</td>
                    </tr>
                    <?php
                    $i = 1;
                    $total = 0;
                    if (!empty($detail)) {
                        foreach ($detail as $rs) {
                            $prod = ($rs['product_id'] <> 0) ? $rs['product_name'] : $rs['item_name'];
                            ?>
                            <tr>
                                <td class="print-border text-center" colspan="2"><?php echo $rs['product_code']; ?></td>
                                <td class="print-border" colspan="3"><?php echo $prod; ?></td>
                                <td class="print-border text-center"><?php echo number_format($rs['d_qty']); ?></td>
                                <td class="print-border text-center"><?php echo $rs['d_price']; ?></td>
                                <td class="print-border text-center" colspan="2"><?php echo number_format($rs['d_subtotal'], 2); ?></td>
                            </tr>
                            <?php
                            $i++;
                            $total += $rs['d_subtotal'];
                        }
                    }
                    $total_before = ($total*100)/107;
                    $total_vat = $total-$total_before;
                    for ($j = $i; $j < 11; $j++) {
                        ?>
                        <tr>
                            <td class="print-border" colspan="2">&nbsp;</td>
                            <td class="print-border" colspan="3"></td>
                            <td class="print-border"></td>
                            <td class="print-border"></td>
                            <td class="print-border" colspan="2"></td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr>
                        <td class="print-title-data-none print-border-left" colspan="2" rowspan="5">Remark</td>
                        <td colspan="3" rowspan="5" class="print-title-data-none">
                            <div class="print-title-data" style="white-space: nowrap">&nbsp;</div>
                            <br/>
                            <div class="print-title-data">&nbsp;</div>
                            <br/>
                            <div class="print-title-data">&nbsp;</div>
                            <br/>
                            <div class="print-title-data">&nbsp;</div>
                            <br/>
                            <div class="print-title-data">&nbsp;</div>
                        </td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none text-right" colspan="2">Total Price</td>
                        <td class="print-border text-right" colspan="2"><?php echo number_format($total_before, 2);?></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none text-right" colspan="2">VAT (7%)</td>
                        <td class="print-border text-right" colspan="2"><?php echo number_format($total_vat, 2);?></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none text-right" colspan="2">Grand Total</td>
                        <td class="print-border text-right" colspan="2"><?php echo number_format($total, 2);?></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-right" colspan="4"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-left"></td>
                        <td class="print-signature print-title-data" colspan="3">&nbsp;</td>
                        <td class="print-title-data-none" colspan="2"></td>
                        <td class="print-signature print-title-data" colspan="2">&nbsp;</td>
                        <td class="print-title-data-none print-border-right"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-left"></td>
                        <td class="print-title-data-none text-center" colspan="3">Medical Sales Representative</td>
                        <td class="print-title-data-none" colspan="2"></td>
                        <td class="print-title-data-none text-center" colspan="2">Approve by</td>
                        <td class="print-title-data-none print-border-right"></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td class="print-title-data" colspan="9"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php }?>
    </body>
</html>
<script>
        window.print();
</script>
