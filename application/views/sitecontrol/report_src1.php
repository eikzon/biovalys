<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="col-xs-8">
            <h1><i class="fa fa-file-text-o fa-lg"></i> SRC1</h1>
            <ol class="breadcrumb">
                <li><a href="<?PHP echo base_url('sitecontrol/home'); ?>"> Home</a></li>
                <li><a href="<?PHP echo base_url('sitecontrol/report'); ?>"> Report</a></li>
                <li class="active">SRC1</li>
            </ol>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="box">
            <h4 class="box-title">SRC1</h4>
            <button class="btn btn-table-tool btn-default" onclick="window.location='<?php echo base_url('sitecontrol/report');?>'"><i class="fa fa-arrow-left"></i> Back</button>
            <hr/>
            <div class="col-xs-12 filter-form">
                <?PHP echo form_open('sitecontrol/report/report_src1'); ?>
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label>Sale of year</label>
                        <select name="year" class="form-control selectpicker" data-live-search="true">
                            <option value="">-- Select Sale of year --</option>
                            <?php
//                                if(!empty($custotmer_list)){
//                                    foreach($custotmer_list as $rs_cus){
//                                        $sel_name = ($search['year'] == $rs_cus['customer_id'])?'selected':'';
//                                        echo '<option value="'.$rs_cus['customer_id'].'" '.$sel_name.'>'.sprintf('%05d', $rs_cus['customer_id']).' - '.$rs_cus['customer_name'].'</option>';
//                                    }
//                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Order as of</label>
                        <select name="name" class="form-control selectpicker" data-live-search="true">
                            <option value="">-- Select Order as of --</option>
                            <?php
//                                if(!empty($custotmer_list)){
//                                    foreach($custotmer_list as $rs_cus){
//                                        $sel_name = ($search['name'] == $rs_cus['customer_id'])?'selected':'';
//                                        echo '<option value="'.$rs_cus['customer_id'].'" '.$sel_name.'>'.sprintf('%05d', $rs_cus['customer_id']).' - '.$rs_cus['customer_name'].'</option>';
//                                    }
//                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Product</label>
                        <select name="product" class="form-control selectpicker" data-live-search="true">
                            <option value="">-- Select Product --</option>
                            <?php
                                if(count($product_list) > 0){
                                    foreach($product_list as $rs_prod){
                                        $sel_product= ($search['product'] == $rs_prod['product_name'])?'selected':'';
                                        echo '<option value="'.$rs_prod['product_id'].'" '.$sel_product.'>'.$rs_prod['product_name'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Rep.ID</label>
                        <select name="rep_id" class="form-control selectpicker" data-live-search="true">
                            <option value="">-- Select Rep.ID --</option>
                            <?php
//                                if(!empty($custotmer_list)){
//                                    foreach($custotmer_list as $rs_cus){
//                                        $sel_name = ($search['rep_id'] == $rs_cus['customer_id'])?'selected':'';
//                                        echo '<option value="'.$rs_cus['customer_id'].'" '.$sel_name.'>'.sprintf('%05d', $rs_cus['customer_id']).' - '.$rs_cus['customer_name'].'</option>';
//                                    }
//                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Customer Type</label>
                        <select name="cus_type" class="form-control selectpicker" data-live-search="true">
                            <option value="">-- Select Customer Type --</option>
                            <?php
//                                if(!empty($custotmer_list)){
//                                    foreach($custotmer_list as $rs_cus){
//                                        $sel_name = ($search['cus_type'] == $rs_cus['customer_id'])?'selected':'';
//                                        echo '<option value="'.$rs_cus['customer_id'].'" '.$sel_name.'>'.sprintf('%05d', $rs_cus['customer_id']).' - '.$rs_cus['customer_name'].'</option>';
//                                    }
//                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Province</label>
                        <select name="province" class="form-control selectpicker" data-live-search="true">
                            <option value="">-- Select Province --</option>
                            <?php
                                if(!empty($province_list)){
                                    foreach($province_list as $rs_prov){
                                        $sel_province = ($search['province'] == $rs_prov['province_name'])?'selected':'';
                                        echo '<option value="'.$rs_prov['province_id'].'" '.$sel_province.'>'.$rs_prov['province_name_eng'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <button type="submit" class="btn btn-default btn-search"><i class="fa fa-search"></i> Search</button>
                        <?PHP if (!empty($search['name']) || !empty($search['province'])) { ?>
                            &nbsp;&nbsp;
                            <button type="button" class="btn btn-default btn-search" onclick="window.location = '<?PHP echo base_url("sitecontrol/report/report_ca") ?>/refresh'"><i class="fa fa-refresh"></i> Show All</button>
                        <?PHP } ?>
                    </div>
                </div>
                <?PHP echo form_close(); ?>
            </div>
            <div class="table-scroll">
                <table class="table table-hover table-striped" style="table-layout: fixed;">
                    <thead>
                        <tr>
                            <th width="50px" class="text-center">Rep.ID</th>
                            <th width="80px" class="text-center">IV Date</th>
                            <th width="100px" class="text-center">Invoice No.</th>
                            <th width="200px" class="text-center">Customer Name</th>
                            <th width="150px" class="text-center">Province</th>
                            <th width="150px" class="text-center">Quantity (dose)</th>
                            <th width="150px" class="text-center">Quantity +FOC (dose)</th>
                            <th width="150px" class="text-center">Total (Baht)</th>
                            <th width="150px" class="text-center">Discount (Baht)</th>
                            <th width="150px" class="text-center">Net Total -VAT (Baht)</th>
                            <th width="150px" class="text-center">ASP (Baht/dose)</th>
                            <th width="150px" class="text-center">Rebate (Baht)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?PHP
                        if (count(@$report_foc_index) > 0) {
                            $i = 1;
                            foreach ($report_foc_index as $rfi) {
                                ?>
                                <tr>
                                    <td class="text-center"><?PHP echo @$rfi['order_number']; ?></td>
                                    <td class="text-center"><?PHP echo @$rfi['order_number']; ?></td>
                                    <td class="text-center"><?PHP echo @$rfi['order_number']; ?></td>
                                    <td class="text-center"><?PHP echo @$rfi['order_number']; ?></td>
                                    <td class="text-center"><?PHP echo @$rfi['order_number']; ?></td>
                                    <td class="text-center"><?PHP echo @$rfi['order_number']; ?></td>
                                    <td class="text-center"><?PHP echo @$rfi['order_number']; ?></td>
                                    <td class="text-center"><?PHP echo @$rfi['order_number']; ?></td>
                                    <td class="text-center"><?PHP echo @$rfi['order_number']; ?></td>
                                    <td class="text-center"><?PHP echo @$rfi['order_number']; ?></td>
                                    <td class="text-center"><?PHP echo @$rfi['order_number']; ?></td>
                                    <td class="text-center"><?PHP echo @$rfi['order_number']; ?></td>
                                </tr>
                                <?PHP
                                $i++;
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="12" align="center">No Data</td>
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