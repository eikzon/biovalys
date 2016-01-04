<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="col-xs-8">
            <h1><i class="fa fa-file-text-o fa-lg"></i> FOC</h1>
            <ol class="breadcrumb">
                <li><a href="<?PHP echo base_url('sitecontrol/home'); ?>"> Home</a></li>
                <li><a href="<?PHP echo base_url('sitecontrol/report'); ?>"> Report</a></li>
                <li class="active">FOC</li>
            </ol>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="box">
            <h4 class="box-title">FOC</h4>
            <button class="btn btn-table-tool btn-default" onclick="window.location='<?php echo base_url('sitecontrol/report');?>'"><i class="fa fa-arrow-left"></i> Back</button>
            <hr/>
            <div class="col-xs-12 filter-form">
                <?PHP echo form_open('sitecontrol/report/report_foc'); ?>
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
                        <select name="province" class="form-control selectpicker" data-live-search="true">
                            <option value="">-- Select Province --</option>
                            <?php
                                if(!empty($province_list)){
                                    foreach($province_list as $rs_prov){
                                        $sel_province = ($search['province'] == $rs_prov['province_id'])?'selected':'';
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
                            <button type="button" class="btn btn-default btn-search" onclick="window.location = '<?PHP echo base_url("sitecontrol/report/report_foc") ?>/refresh'"><i class="fa fa-refresh"></i> Show All</button>
                        <?PHP } ?>
                    </div>
                </div>
                <?PHP echo form_close(); ?>
            </div>
            <div class="table-scroll">
                <table class="table table-hover table-striped" style="table-layout: fixed;">
                    <thead>
                        <tr>
                            <th class="text-center" width="100px">F.O.C. No.</th>
                            <th class="text-center" width="100px">F.O.C.<br/>Issued Date</th>
                            <th class="text-center" width="100px">Invoice No.</th>
                            <th class="text-center" width="100px">IV<br/>Issued Date</th>
                            <th class="text-center" width="50px">W</th>
                            <th class="text-center" width="50px">M</th>
                            <th class="text-center" width="50px">Y</th>
                            <th class="text-center" width="60px">Rep.ID</th>
                            <th class="text-center" width="100px">Customer ID<br/>(A/C)</th>
                            <th class="text-center" width="200px">Customer Type</th>
                            <th class="text-center" width="200px">Customer Name</th>
                            <th class="text-center" width="150px">Province</th>
                            <?php
                                if(count($product_list) > 0){
                                    foreach($product_list as $thead_prod){
                                        echo '<th class="text-center" width="150px">'.$thead_prod['product_name'].'<br/>Placed Sample<br/>Amount (box)</th>';
                                    }
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?PHP
                        if (count(@$report_foc_index) > 0) {
                            $i = 1;
                            foreach ($report_foc_index as $rfi) {
                                $foc_detail = $admin_report->foc_detail($rfi['foc_id']);
                                ?>
                                <tr>
                                    <td class="text-center"><?PHP echo @$rfi['order_foc_code']; ?></td>
                                    <td class="text-center"><?PHP echo date('d M y', strtotime(@$rfi['foc_date'])); ?></td>
                                    <td class="text-center"><?PHP // echo substr(@$rfi['order_foc_code'],0, 2).substr(@$rfi['order_foc_code'], 3); ?></td>
                                    <td class="text-center"><?PHP echo date('d M y', strtotime(@$rfi['foc_date'])); ?></td>
                                    <td class="text-center"><?PHP echo date('W', strtotime(@$rfi['foc_date'])); ?></td>
                                    <td class="text-center"><?PHP echo date('m', strtotime(@$rfi['foc_date'])); ?></td>
                                    <td class="text-center"><?PHP echo date('Y', strtotime(@$rfi['foc_date'])); ?></td>
                                    <td class="text-center"><?PHP echo @$rfi['zone_code']; ?></td>
                                    <td class="text-center"><?PHP echo @$rfi['credit_number']; ?></td>
                                    <td class="text-center"><?PHP echo @$rfi['cus_type_name']; ?></td>
                                    <td class="text-center"><?PHP echo @$rfi['customer_name']; ?></td>
                                    <td class="text-center"><?PHP echo @$rfi['province_name']; ?></td>
                                    <?php
                                        if(count($product_list) > 0){
                                            foreach($product_list as $tbody_prod){
                                                $val_foc = (!empty($foc_detail[$tbody_prod['product_id']]))?$foc_detail[$tbody_prod['product_id']]:0;
                                                echo '<th class="text-center" width="150px">'.$val_foc.'</th>';
                                            }
                                        }
                                    ?>
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