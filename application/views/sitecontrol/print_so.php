<html>
    <head>
        <meta charset="UTF-8">
        <script src="<?php echo base_url('assets_sitecontrol/js/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets_sitecontrol/js/bootstrap.min.js'); ?>"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets_sitecontrol/css/vendors/bootstrap.css'); ?>">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets_sitecontrol/css/print.css'); ?>">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <title></title>
    </head>
    <body>
        <div class="table-responsive">
        <?php for($a = 1;$a < 3;$a++){?>
            <img src="<?PHP echo base_url('assets_sitecontrol/img/logo.jpg'); ?>" class="print-logo">
            <table class="table print-border" data-width="100%">
                <thead class="print-header">
                    <tr>
                        <th class="print-border" colspan="9">SALES ORDER</th>
                    </tr>
                </thead>
                <thead class="print-title">
                    <tr>
                        <td class="print-title-data-none print-border-left" colspan="3">Sales Order No.</td>
                        <td class="print-title-data">: <?php echo @$customer['c_code'] ?></td>
                        <td class="print-title-data-none">Date</td>
                        <td class="print-title-data" colspan="2">: <?PHP echo date('d F Y', strtotime(@$customer['order_date_create'])); ?></td>
                        <td class="print-title-data-none text-right"><?php echo ($a == 1)?'SS':'EDP'?></td>
                        <td class="print-title-data-none print-border-right"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-left" colspan="3">Representative Name</td>
                        <td class="print-title-data" colspan="3">: <?PHP echo @$customer['member_name']; ?></td>
                        <td class="print-title-data-none">Rep.ID</td>
                        <td class="print-title-data">: <?PHP echo @$customer['zone_code']; ?></td>
                        <td class="print-title-data-none print-border-right"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-left" colspan="3">Customer ID (A/C)</td>
                        <td class="print-title-data" colspan="5">: <?PHP echo @$customer['customer_credit_number']; ?></td>
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
                <tbody class="print-title">
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
                    $total = $default_total = $extra_s = $extra_td = 0;
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
                            $default_total += $rs['d_qty']*$rs['d_price'];
                            $total += $rs['d_subtotal'];
                            if($rs['product_type_rebate'] == 1 && $customer['order_rebate_extra_s'] > 0){
                                $extra_s += ($rs['d_subtotal']*$customer['order_rebate_extra_s'])/100;
                            }
                            if($rs['product_type_rebate'] == 2 && $customer['order_rebate_extra_td'] > 0){
                                $extra_td += ($rs['d_subtotal']*$customer['order_rebate_extra_td'])/100;
                            }
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
                        <td class="print-title-data-none text-right" colspan="2"><?php echo (@$customer['order_discount'] > 0)?'( '.$customer['order_discount'].'% )':'';?> Discount</td>
                        <td class="print-border text-right" colspan="2"><?php echo (@$customer['order_discount'] > 0)?number_format($default_total-$total, 2):'';?></td>
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
                        <td class="print-title-data-none print-border-left"></td>
                        <td class="print-signature7 print-title-data" colspan="3">&nbsp;</td>
                        <td class="print-title-data-none" colspan="2"></td>
                        <td class="print-signature7 print-title-data" colspan="2">&nbsp;</td>
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
                <tfoot class=" print-title">
                    <tr>
                        <td class="print-title-data" colspan="9"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <?php }?>
        <?php for($a = 1;$a < 3;$a++){?>
        <?php if(@$customer['order_rebate_normal'] > 0){?>
        <div class="table-responsive">
            <table class="table" data-width="100%">
                <thead class="print-header">
                    <tr>
                        <th class="print-title-data-none" colspan="3" style="padding: 0px!important;"><img src="<?PHP echo base_url('assets_sitecontrol/img/logo.jpg'); ?>" class="print-logo" style="margin-bottom: 0px;"></th>
                        <th class="print-title-data-none text-center" colspan="3" style="vertical-align: middle;font-size: 12px;font-weight: normal;padding: 0px!important;">สวัสดิการโรงพยาบาล</th>
                        <th class="print-title-data-none text-right print-title" colspan="3" style="font-weight: normal;padding: 0px!important;"><?php echo ($a == 1)?'SS':'EDP'?></th>
                    </tr>
                </thead>
                <thead class="print-title">
                    <tr>
                        <td class="print-title-data-none" colspan="5">To : Accounting Dept./ Financial Dept.</td>
                        <td class="print-title-data-none">Date</td>
                        <td class="print-title-data" colspan="3"><?PHP echo date('d M Y', strtotime($customer['order_date_create'])); ?></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" colspan="3">Please arrange a hospital sales rebate <?PHP echo $customer['order_rebate_normal']; ?>% to</td>
                        <td class="print-title-data" colspan="3"> <?PHP echo $customer['customer_name']; ?></td>
                        <td class="print-title-data-none">Rep.ID</td>
                        <td class="print-title-data" colspan="2"><?PHP echo @$customer['zone_code']; ?></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" colspan="2">Customer Name</td>
                        <td class="print-title-data" colspan="3"><?PHP echo @$customer['customer_name']; ?></td>
                        <td class="print-title-data-none" colspan="2">Customer ID (A/C)</td>
                        <td class="print-title-data" colspan="2"><?PHP echo @$customer['customer_credit_number']; ?></td>
                    </tr>
                    <tr>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="2%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="10%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="20%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="20%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="10%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="12%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="12%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="12%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="2%"></th>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" style="padding: 0px!important;"></td>
                        <td class="print-title-data" colspan="7" style="padding: 0px!important;">As per details below :</td>
                        <td class="print-title-data-none" style="padding: 0px!important;"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none"></td>
                        <td class="print-border text-center" colspan="2">Date</td>
                        <td class="print-border text-center" colspan="1">Invoice No.</td>
                        <td class="print-border text-center" colspan="2">Total Value</td>
                        <td class="print-border text-center" colspan="2">Rebate</td>
                        <td class="print-title-data-none"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none"></td>
                        <td class="print-border text-center" colspan="2"><?PHP echo date('d/m/Y', strtotime($customer['order_date_create'])); ?></td>
                        <td class="print-border text-center" colspan="1"><?PHP echo $customer['customer_number']; ?></td>
                        <td class="print-border text-center" colspan="2"><?php echo number_format($total,2);?></td>
                        <td class="print-border text-center" colspan="2"><?PHP echo number_format((($total*$customer['order_rebate_normal'])/100),2); ?></td>
                        <td class="print-title-data-none"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none"></td>
                        <td class="print-title-data-none">Remark </td>
                        <td class="print-title-data" colspan="6"></td>
                        <td class="print-title-data-none"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" colspan="2"></td>
                        <td class="print-title-data" colspan="6">&nbsp;</td>
                        <td class="print-title-data-none"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" colspan="2"></td>
                        <td class="print-title-data-none" colspan="4">Followed by:</td>
                        <td class="print-title-data-none" colspan="2">Approved by:</td>
                        <td class="print-title-data-none"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none"></td>
                        <td class="print-title-data" colspan="2">&nbsp;</td>
                        <td class="print-title-data-none" colspan="2"></td>
                        <td class="print-title-data" colspan="3"></td>
                        <td class="print-title-data-none"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" colspan="5"></td>
                        <td class="print-title-data-none text-center" colspan="3">(Area Manager/Sales Manager)</td>
                        <td class="print-title-data-none"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" style="padding: 0px!important;" colspan="9"><input type="checkbox" /> เบิก ครั้งที่ 1 <span style="border-bottom: 1px solid #000!important;width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" style="padding: 0px!important;" colspan="9">
                            <input type="checkbox" /> เบิก ครั้งที่ 2 
                            <span style="border-bottom: 1px solid #000!important;width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <input type="checkbox" /> เคลียร์
                            <span style="border-bottom: 1px solid #000!important;width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <input type="checkbox" /> RE
                            <span style="border-bottom: 1px solid #000!important;width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none">&nbsp;</td>
                    </tr>
                </thead>
            </table>
        </div>
        <?php }?>
        <?php if($extra_s > 0){?>
        <div class="table-responsive">
            <table class="table" data-width="100%">
                <thead class="print-header">
                    <tr>
                        <th class="print-title-data-none" colspan="3" style="padding: 0px!important;"><img src="<?PHP echo base_url('assets_sitecontrol/img/logo.jpg'); ?>" class="print-logo" style="margin-bottom: 0px;"></th>
                        <th class="print-title-data-none text-center" colspan="3" style="vertical-align: middle;font-size: 12px;font-weight: normal;padding: 0px!important;">สวัสดิการโรงพยาบาล</th>
                        <th class="print-title-data-none text-right print-title" colspan="3" style="font-weight: normal;padding: 0px!important;"><?php echo ($a == 1)?'SS':'EDP'?></th>
                    </tr>
                </thead>
                <thead class="print-title">
                    <tr>
                        <td class="print-title-data-none" colspan="5">To : Accounting Dept./ Financial Dept.</td>
                        <td class="print-title-data-none">Date</td>
                        <td class="print-title-data" colspan="3"><?PHP echo date('d M Y', strtotime($customer['order_date_create'])); ?></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" colspan="3">Please arrange a hospital sales rebate <?PHP echo $customer['order_rebate_extra_s']; ?>% to</td>
                        <td class="print-title-data" colspan="3"> <?PHP echo $customer['customer_name']; ?></td>
                        <td class="print-title-data-none">Rep.ID</td>
                        <td class="print-title-data" colspan="2"><?PHP echo @$customer['zone_code']; ?></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" colspan="2">Customer Name</td>
                        <td class="print-title-data" colspan="3"><?PHP echo @$customer['customer_name']; ?></td>
                        <td class="print-title-data-none" colspan="2">Customer ID (A/C)</td>
                        <td class="print-title-data" colspan="2"><?PHP echo @$customer['customer_credit_number']; ?></td>
                    </tr>
                    <tr>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="2%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="10%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="20%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="20%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="10%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="12%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="12%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="12%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="2%"></th>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" style="padding: 0px!important;"></td>
                        <td class="print-title-data" colspan="7" style="padding: 0px!important;">As per details below :</td>
                        <td class="print-title-data-none" style="padding: 0px!important;"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none"></td>
                        <td class="print-border text-center" colspan="2">Date</td>
                        <td class="print-border text-center" colspan="1">Invoice No.</td>
                        <td class="print-border text-center" colspan="2">Total Value</td>
                        <td class="print-border text-center" colspan="2">Rebate</td>
                        <td class="print-title-data-none"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none"></td>
                        <td class="print-border text-center" colspan="2"><?PHP echo date('d/m/Y', strtotime($customer['order_date_create'])); ?></td>
                        <td class="print-border text-center" colspan="1"><?PHP echo $customer['customer_number']; ?></td>
                        <td class="print-border text-center" colspan="2"><?php echo number_format($total,2);?></td>
                        <td class="print-border text-center" colspan="2"><?PHP echo number_format($extra_s,2); ?></td>
                        <td class="print-title-data-none"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none"></td>
                        <td class="print-title-data-none">Remark </td>
                        <td class="print-title-data" colspan="6"></td>
                        <td class="print-title-data-none"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" colspan="2"></td>
                        <td class="print-title-data" colspan="6">&nbsp;</td>
                        <td class="print-title-data-none"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" colspan="2"></td>
                        <td class="print-title-data-none" colspan="4">Followed by:</td>
                        <td class="print-title-data-none" colspan="2">Approved by:</td>
                        <td class="print-title-data-none"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none"></td>
                        <td class="print-title-data" colspan="2">&nbsp;</td>
                        <td class="print-title-data-none" colspan="2"></td>
                        <td class="print-title-data" colspan="3"></td>
                        <td class="print-title-data-none"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" colspan="5"></td>
                        <td class="print-title-data-none text-center" colspan="3">(Area Manager/Sales Manager)</td>
                        <td class="print-title-data-none"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" style="padding: 0px!important;" colspan="9"><input type="checkbox" /> เบิก ครั้งที่ 1 <span style="border-bottom: 1px solid #000!important;width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" style="padding: 0px!important;" colspan="9">
                            <input type="checkbox" /> เบิก ครั้งที่ 2 
                            <span style="border-bottom: 1px solid #000!important;width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <input type="checkbox" /> เคลียร์
                            <span style="border-bottom: 1px solid #000!important;width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <input type="checkbox" /> RE
                            <span style="border-bottom: 1px solid #000!important;width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none">&nbsp;</td>
                    </tr>
                </thead>
            </table>
        </div>
        
        <?php }?>
        <?php if($extra_td > 0){?>
        <div class="table-responsive">
            <table class="table" data-width="100%">
                <thead class="print-header">
                    <tr>
                        <th class="print-title-data-none" colspan="3" style="padding: 0px!important;"><img src="<?PHP echo base_url('assets_sitecontrol/img/logo.jpg'); ?>" class="print-logo" style="margin-bottom: 0px;"></th>
                        <th class="print-title-data-none text-center" colspan="3" style="vertical-align: middle;font-size: 12px;font-weight: normal;padding: 0px!important;">สวัสดิการโรงพยาบาล</th>
                        <th class="print-title-data-none text-right print-title" colspan="3" style="font-weight: normal;padding: 0px!important;"><?php echo ($a == 1)?'SS':'EDP'?></th>
                    </tr>
                </thead>
                <thead class="print-title">
                    <tr>
                        <td class="print-title-data-none" colspan="5">To : Accounting Dept./ Financial Dept.</td>
                        <td class="print-title-data-none">Date</td>
                        <td class="print-title-data" colspan="3"><?PHP echo date('d M Y', strtotime($customer['order_date_create'])); ?></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" colspan="3">Please arrange a hospital sales rebate <?PHP echo $customer['order_rebate_extra_td']; ?>% to</td>
                        <td class="print-title-data" colspan="3"> <?PHP echo $customer['customer_name']; ?></td>
                        <td class="print-title-data-none">Rep.ID</td>
                        <td class="print-title-data" colspan="2"><?PHP echo @$customer['zone_code']; ?></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" colspan="2">Customer Name</td>
                        <td class="print-title-data" colspan="3"><?PHP echo @$customer['customer_name']; ?></td>
                        <td class="print-title-data-none" colspan="2">Customer ID (A/C)</td>
                        <td class="print-title-data" colspan="2"><?PHP echo @$customer['customer_credit_number']; ?></td>
                    </tr>
                    <tr>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="2%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="10%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="20%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="20%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="10%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="12%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="12%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="12%"></th>
                        <th class="print-title-data-none" style="padding: 0px!important;" width="2%"></th>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" style="padding: 0px!important;"></td>
                        <td class="print-title-data" colspan="7" style="padding: 0px!important;">As per details below :</td>
                        <td class="print-title-data-none" style="padding: 0px!important;"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none"></td>
                        <td class="print-border text-center" colspan="2">Date</td>
                        <td class="print-border text-center" colspan="1">Invoice No.</td>
                        <td class="print-border text-center" colspan="2">Total Value</td>
                        <td class="print-border text-center" colspan="2">Rebate</td>
                        <td class="print-title-data-none"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none"></td>
                        <td class="print-border text-center" colspan="2"><?PHP echo date('d/m/Y', strtotime($customer['order_date_create'])); ?></td>
                        <td class="print-border text-center" colspan="1"><?PHP echo $customer['customer_number']; ?></td>
                        <td class="print-border text-center" colspan="2"><?php echo number_format($total,2);?></td>
                        <td class="print-border text-center" colspan="2"><?PHP echo number_format($extra_td,2); ?></td>
                        <td class="print-title-data-none"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none"></td>
                        <td class="print-title-data-none">Remark </td>
                        <td class="print-title-data" colspan="6"></td>
                        <td class="print-title-data-none"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" colspan="2"></td>
                        <td class="print-title-data" colspan="6">&nbsp;</td>
                        <td class="print-title-data-none"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" colspan="2"></td>
                        <td class="print-title-data-none" colspan="4">Followed by:</td>
                        <td class="print-title-data-none" colspan="2">Approved by:</td>
                        <td class="print-title-data-none"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none"></td>
                        <td class="print-title-data" colspan="2">&nbsp;</td>
                        <td class="print-title-data-none" colspan="2"></td>
                        <td class="print-title-data" colspan="3"></td>
                        <td class="print-title-data-none"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" colspan="5"></td>
                        <td class="print-title-data-none text-center" colspan="3">(Area Manager/Sales Manager)</td>
                        <td class="print-title-data-none"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" style="padding: 0px!important;" colspan="9"><input type="checkbox" /> เบิก ครั้งที่ 1 <span style="border-bottom: 1px solid #000!important;width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none" style="padding: 0px!important;" colspan="9">
                            <input type="checkbox" /> เบิก ครั้งที่ 2 
                            <span style="border-bottom: 1px solid #000!important;width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <input type="checkbox" /> เคลียร์
                            <span style="border-bottom: 1px solid #000!important;width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                            <input type="checkbox" /> RE
                            <span style="border-bottom: 1px solid #000!important;width: 100%;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        </td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none">&nbsp;</td>
                    </tr>
                </thead>
            </table>
        </div>
        
        <?php }?>
        <?php }?>
    </body>
</html>
<script>
        window.print();
</script>
