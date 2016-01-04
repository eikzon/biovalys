<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="col-xs-8">
            <h1><i class="fa fa-file-text-o fa-lg"></i> CA</h1>
            <ol class="breadcrumb">
                <li><a href="<?PHP echo base_url('sitecontrol/home'); ?>"> Home</a></li>
                <li><a href="<?PHP echo base_url('sitecontrol/report'); ?>"> Report</a></li>
                <li class="active">CA</li>
            </ol>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="box">
            <h4 class="box-title">CA</h4>
            <button class="btn btn-table-tool btn-default" onclick="window.location='<?php echo base_url('sitecontrol/report');?>'"><i class="fa fa-arrow-left"></i> Back</button>
            <hr/>
            <div class="col-xs-12 filter-form">
                <?PHP echo form_open('sitecontrol/report/search_report_ca'); ?>
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label>CA Name</label>
                        <select name="name" class="form-control selectpicker" data-live-search="true">
                            <option value="">-- Select CA Name --</option>
                            <?php
                                if(!empty($customer_list)){
                                    foreach($customer_list as $rs_cus){
                                        $sel_name = ($search['name'] == $rs_cus['customer_id'])?'selected':'';
                                        echo '<option value="'.$rs_cus['customer_id'].'" '.$sel_name.'>'.$rs_cus['credit_number'].' - '.$rs_cus['customer_name'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label>CA Type</label>
                        <select name="type" class="form-control selectpicker" data-live-search="true">
                            <option value="">-- Select CA Type --</option>
                            <?php
                                if(!empty($customer_type_list)){
                                    foreach($customer_type_list as $rs_cus_type){
                                        $sel_type = ($search['type'] == $rs_cus_type['cus_type_id'])?'selected':'';
                                        echo '<option value="'.$rs_cus_type['cus_type_id'].'" '.$sel_type.'>'.$rs_cus_type['cus_type_name'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Province</label>
                        <select name="province" class="form-control selectpicker"  data-live-search="true">
                            <option value="">-- Select Province --</option>
                            <?php
                                if(!empty($province_list)){
                                    foreach($province_list as $rs_prov){
                                        $sel_province = ($search['province'] == $rs_prov['province_name'])?'selected':'';
                                        echo '<option value="'.$rs_prov['province_id'].'" '.$sel_province.'>'.$rs_prov['province_name'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <button type="submit" class="btn btn-default btn-search"><i class="fa fa-search"></i> Search</button>
                        <?PHP if (!empty($search['name']) || !empty($search['type']) || !empty($search['province'])) { ?>
                            &nbsp;&nbsp;
                            <button type="button" class="btn btn-default btn-search" onclick="window.location = '<?PHP echo base_url("sitecontrol/report/refresh_report_ca") ?>'"><i class="fa fa-refresh"></i> Show All</button>
                        <?PHP } ?>
                    </div>
                </div>
                <?PHP echo form_close(); ?>
            </div>
            <div class="text-right col-xs-12"><?PHP echo $links; ?></div>
            <div class="table-scroll">
                <table class="table table-hover table-striped" style="table-layout: fixed;">
                    <thead>
                        <tr>
                            <th width="200px" class="text-center">Credit Application <sup>No</sup></th>
                            <th width="100px" class="text-center">Issued Date</th>
                            <th width="80px" class="text-center">F.O.C.<br/>(Yes/No)</th>
                            <th width="100px" class="text-center"><sup>1st</sup> Order Date</th>
                            <th width="50px" class="text-center">M</th>
                            <th width="50px" class="text-center">Y</th>
                            <th width="50px" class="text-center">Order as of</th>
                            <th width="150px" class="text-center">Product</th>
                            <th width="50px" class="text-center">Hold</th>
                            <th width="50px" class="text-center">Rep.ID</th>
                            <th width="50px" class="text-center"><sup>1st</sup> Order Rep.ID</th>
                            <th width="100px" class="text-center">Customer ID<br/>(A/C)</th>
                            <th width="200px" class="text-center">Customer Type</th>
                            <th width="150px" class="text-center">Military Hospital<br/>(Yes/No)</th>
                            <th width="150px" class="text-center">Provincial Hospital<br/>(Yes/No)</th>
                            <th width="200px" class="text-center">Customer Name</th>
                            <th width="200px" class="text-center">Common Name</th>
                            <th width="150px" class="text-center">Province</th>
                            <?php
                                if(count($product_list) > 0){
                                    foreach($product_list as $thead_prod){
                                        echo '<th width="100px" class="text-center">'.@$thead_prod['product_name'].'<br/>Price/Box</th>';
                                    }
                                }
                            ?>
                            <th width="50px" class="text-center">Normal<br/>Rebate</th>
                            <th width="50px" class="text-center">Extra<br/>Rebate (S)</th>
                            <th width="50px" class="text-center">Extra<br/>Rebate (Td)</th>
                            <th width="50px" class="text-center">Credit<br/>(days)</th>
                            <th width="100px" class="text-center">Credit<br/>(Baht)</th>
                            <th width="200px" class="text-center">เลขประจำตัวผู้ภาษี 13 หลัก</th>
                            <th width="300px" class="text-center">Remark</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?PHP
                        if (count($report_ca_index) > 0) {
                            $i = 1;
                            foreach ($report_ca_index as $rci) {
                                $rate_price = $admin_report->rate_price($rci['customer_id']);
                                ?>
                                <tr>
                                    <td class="text-center"><?PHP echo @$rci['customer_credit_number']; ?></td>
                                    <td class="text-center"><?PHP echo date('d M y', strtotime(@$rci['customer_date_credit'])); ?></td>
                                    <td class="text-center"><?PHP echo (!empty($rci['order_foc_code']))?'Yes':'No'; ?></td>
                                    <td class="text-center"><?PHP echo (date('d M y', strtotime(@$rci['order_list_date'])) != '01 Jan 70')?date('d M y', strtotime(@$rci['order_list_date'])):''; ?></td>
                                    <td class="text-center"><?PHP echo (date('d M y', strtotime(@$rci['order_list_date'])) != '01 Jan 70')?date('m', strtotime(@$rci['order_list_date'])):'';?></td>
                                    <td class="text-center"><?PHP echo (date('d M y', strtotime(@$rci['order_list_date'])) != '01 Jan 70')?date('Y', strtotime(@$rci['order_list_date'])):'';?></td>
                                    <td class="text-center"><?PHP echo (date('d M y', strtotime(@$rci['order_list_date'])) != '01 Jan 70')?date('Ym', strtotime(@$rci['order_list_date'])):'';?></td>
                                    <td class="text-center"><?PHP echo @$rci['product_name']; ?></td>
                                    <td class="text-center"><?PHP echo 0; ?></td>
                                    <td class="text-center"><?PHP echo @$rci['zone_code']; ?></td>
                                    <td class="text-center"><?PHP echo @$rci['zone_code']; ?></td>
                                    <td class="text-center"><?PHP echo @$rci['customer_number']; ?></td>
                                    <td class="text-center"><?PHP echo @$rci['cus_type_name']; ?></td>
                                    <td class="text-center"><?PHP echo (@$rci['customer_military'] == 1)?'Yes':'No'; ?></td>
                                    <td class="text-center"><?PHP echo (@$rci['customer_provincial'] == 1)?'Yes':'No'; ?></td>
                                    <td class="text-center"><?PHP echo @$rci['customer_name']; ?></td>
                                    <td class="text-center"><?PHP echo @$rci['customer_common']; ?></td>
                                    <td class="text-center"><?PHP echo @$rci['province_name_eng']; ?></td>
                                    <?php
                                        if(count($product_list) > 0){
                                            foreach($product_list as $tbody_prod){
                                                $price = (@$rate_price[$tbody_prod['product_id']] != '0.00')?@$rate_price[$tbody_prod['product_id']]:'';
                                                echo '<td class="text-center">'.@$price.'</td>';
                                            }
                                        }
                                    ?>
                                    <td class="text-center"><?PHP echo (@$rci['customer_rebate_normal'] > 0)?@$rci['customer_rebate_normal'].'%':''; ?></td>
                                    <td class="text-center"><?PHP echo (@$rci['customer_rebate_extra_s'] > 0)?@$rci['customer_rebate_extra_s'].'%':''; ?></td>
                                    <td class="text-center"><?PHP echo (@$rci['customer_rebate_extra_td'] > 0)?@$rci['customer_rebate_extra_td'].'%':''; ?></td>
                                    <td class="text-center"><?PHP echo @$rci['customer_payment_term']; ?></td>
                                    <td class="text-center"><?PHP echo number_format(@$rci['customer_credit_price'],2); ?></td>
                                    <td class="text-center"><?PHP echo @$rci['customer_taxid']; ?></td>
                                    <td class="text-center"><?PHP echo @$rci['customer_remark']; ?></td>
                                </tr>
                                <?PHP
                                $i++;
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="16" align="center">No Data</td>
                            </tr>
                        <?PHP } ?>
                    </tbody>
                </table>
            </div>
            <div class="text-right col-xs-12"><?PHP echo $links; ?></div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<!-- /.content-wrapper -->
<?PHP
// Gen Template
echo $temp['footer'];
?>