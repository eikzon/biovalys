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
        <div class="table-responsive">
            <img src="<?PHP echo base_url('assets_sitecontrol/img/logo.jpg'); ?>" class="print-logo">
            <i class=""></i>
            <table class="table print-border" data-width="100%">
                <thead>
                    <tr>
                        <th class="print-header print-title-data print-border-left" colspan="9">CREDIT APPLICATION FORM</th>
                    </tr>
                </thead>
                <thead class="print-title">
                    <tr>
                        <td class="print-title-data-none print-border-left" colspan="3">Credit Application No.</td>
                        <td class="print-title-data" colspan="2">: <?php echo @$customer['customer_credit_number'] ?></td>
                        <td class="print-title-data-none">Date</td>
                        <td class="print-title-data" colspan="2">: <?PHP echo date('d M Y', strtotime(@$customer['customer_date_credit'])); ?></td>
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
                        <td class="print-title-data" colspan="5">: <?PHP echo @$customer['customer_number']; ?></td>
                        <td class="print-title-data-none print-border-right"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-left" colspan="3">Customer Name</td>
                        <td class="print-title-data" colspan="5">: <?PHP echo @$customer['customer_name']; ?></td>
                        <td class="print-title-data-none print-border-right"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-left" colspan="2">Address</td>
                        <td class="print-title-data" colspan="6">: <?PHP echo @$customer['customer_address']; ?></td>
                        <td class="print-title-data-none print-border-right"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-left" colspan="2">Province</td>
                        <td class="print-title-data" colspan="3">: <?PHP echo @$customer['province_name']; ?></td>
                        <td class="print-title-data-none">Zip code</td>
                        <td class="print-title-data" colspan="2">: <?PHP echo @$customer['customer_postcode']; ?></td>
                        <td class="print-title-data-none print-border-right"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-left" colspan="2">Remark</td>
                        <td class="print-title-data" colspan="6">: <?PHP echo @$customer['customer_remark']; ?></td>
                        <td class="print-title-data-none print-border-right"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-left" colspan="2"></td>
                        <td class="print-title-data" colspan="6">&nbsp; เลขที่ภาษี <?PHP echo (!empty($customer['customer_taxid']))?$customer['customer_taxid']:'-'; ?></td>
                        <td class="print-title-data-none print-border-right"></td>
                    </tr>
                    <tr>
                        <th class="print-title-data" width="2%">&nbsp;</th>
                        <th class="print-title-data" width="10%"></th>
                        <th class="print-title-data" width="18%"></th>
                        <th class="print-title-data" width="12%"></th>
                        <th class="print-title-data" width="18%"></th>
                        <th class="print-title-data" width="14%"></th>
                        <th class="print-title-data" width="12%"></th>
                        <th class="print-title-data" width="10%"></th>
                        <th class="print-title-data" width="2%"></th>
                    </tr>
                    <tr>
                        <td class="print-border print-title-data-none" colspan="9">Customer Type</td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-left" style="padding: 0px!important;"></td>
                        <td class="print-title-data-none" colspan="3" style="vertical-align: bottom;padding: 0px!important;">01 <input type="checkbox"/> Public Hospital</td>
                        <td class="print-title-data-none" colspan="2" style="vertical-align: bottom;padding: 0px!important;">Credit rating recommended</td>
                        <td class="print-title-data text-center" style="vertical-align: bottom;padding: 0px!important;"> <?PHP echo number_format(@$customer['customer_credit_price'],2); ?></td>
                        <td class="print-title-data-none" style="vertical-align: bottom;padding: 0px!important;">Baht</td>
                        <td class="print-title-data-none print-border-right" style="padding: 0px!important;"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-left" style="padding: 0px!important;"></td>
                        <td class="print-title-data-none" colspan="8" style="padding: 0px!important;">02 <input type="checkbox"/> Private Hospital</td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-left" style="padding: 0px!important;"></td>
                        <td class="print-title-data-none" colspan="3" style="vertical-align: bottom;padding: 0px!important;">03 <input type="checkbox"/> Private Doctors/Clinics</td>
                        <td class="print-title-data-none" colspan="2" style="vertical-align: bottom;padding: 0px!important;">Payment term</td>
                        <td class="print-title-data text-center" style="vertical-align: bottom;padding: 0px!important;"> <?PHP echo @$customer['customer_payment_term']; ?></td>
                        <td class="print-title-data-none" style="vertical-align: bottom;padding: 0px!important;">Day</td>
                        <td class="print-title-data-none print-border-right" style="padding: 0px!important;"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-left" style="padding: 0px!important;"></td>
                        <td class="print-title-data-none" colspan="8" style="padding: 0px!important;">04 <input type="checkbox"/> Drugstores</td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-left" style="padding: 0px!important;"></td>
                        <td class="print-title-data-none" colspan="3" style="vertical-align: bottom;padding: 0px!important;">05 <input type="checkbox"/> National Thai institutions</td>
                        <td class="print-title-data-none" colspan="2" style="vertical-align: bottom;padding: 0px!important;">Payment channel</td>
                        <td class="print-title-data" colspan="2" style="vertical-align: bottom;padding: 0px!important;"> <?PHP echo @$customer['customer_payment_channel']; ?></td>
                        <td class="print-title-data-none print-border-right" style="padding: 0px!important;"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-left" style="padding: 0px!important;"></td>
                        <td class="print-title-data-none" colspan="5" style="vertical-align: bottom;padding: 0px!important;">06 <input type="checkbox"/> Exports</td>
                        <td class="print-title-data" colspan="2" style="vertical-align: bottom;padding: 0px!important;"></td>
                        <td class="print-title-data-none print-border-right" style="padding: 0px!important;"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-left" style="padding: 0px!important;"></td>
                        <td class="print-title-data-none" colspan="5" style="padding: 0px!important;">07 <input type="checkbox"/> International Organizations</td>
                        <td class="print-title-data" colspan="2" style="vertical-align: bottom;padding: 0px!important;"></td>
                        <td class="print-title-data-none print-border-right" style="padding: 0px!important;"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-left" style="padding: 0px!important;"></td>
                        <td class="print-title-data-none" colspan="5" style="padding: 0px!important;">08 <input type="checkbox"/> Others</td>
                        <td class="print-title-data" colspan="2" style="vertical-align: bottom;padding: 0px!important;"></td>
                        <td class="print-title-data-none print-border-right" style="padding: 0px!important;"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-left" style="padding: 0px!important;"></td>
                        <td class="print-title-data-none" colspan="5" style="padding: 0px!important;">09 <input type="checkbox"/> Company Limited</td>
                        <td class="print-title-data" colspan="2" style="vertical-align: bottom;padding: 0px!important;"></td>
                        <td class="print-title-data-none print-border-right" style="padding: 0px!important;"></td>
                    </tr>
                    <tr>
                        <td class="print-title-data-none print-border-left" style="padding: 0px!important;"></td>
                        <td class="print-title-data-none" colspan="5" style="padding: 0px!important;">10 <input type="checkbox"/> Limited</td>
                        <td class="print-title-data" colspan="2" style="vertical-align: bottom;padding: 0px!important;"></td>
                        <td class="print-title-data-none print-border-right" style="padding: 0px!important;"></td>
                    </tr>
                    
                    <tr>
                        <td colspan="3" class="print-title-data print-border-left"></td>
                        <td colspan="2" class="print-title-data"></td>
                        <td colspan="4" class="print-title-data print-border-right"></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="print-title-data-none print-border-left text-center">Recommended by</td>
                        <td colspan="2" class="print-title-data-none print-border-left text-center">Concurred by</td>
                        <td colspan="4" class="print-title-data-none print-border-left print-border-right text-center">Approved by</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="print-title-data-none print-signature5 print-border-left" style="padding: 5px;">&nbsp;</td>;
                        <td colspan="2" class="print-title-data-none print-signature5 print-border-left print-border-right"></td>
                        <td colspan="4" class="print-title-data-none print-signature5 print-border-right"></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="print-title-data-none print-border-left text-center">__________________</td>
                        <td colspan="2" class="print-title-data-none print-border-left text-center">__________________</td>
                        <td colspan="4" class="print-title-data-none print-border-left print-border-right text-center">__________________</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="print-title-data print-border-left text-center">( Medical Sales Representative )</td>
                        <td colspan="2" class="print-title-data print-border-left text-center">( Senior Consultant )</td>
                        <td colspan="4" class="print-title-data print-border-left print-border-right text-center">( Area Manager/Sales Manager )</td>
                    </tr>
                </thead>
            </table>
        </div>
    </body>
</html>
<script>
        window.print();
</script>
