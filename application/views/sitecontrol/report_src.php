<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="col-xs-8">
            <h1><i class="fa fa-file-text-o fa-lg"></i> SRC</h1>
            <ol class="breadcrumb">
                <li><a href="<?PHP echo base_url('sitecontrol/home'); ?>"> Home</a></li>
                <li><a href="<?PHP echo base_url('sitecontrol/report'); ?>"> Report</a></li>
                <li class="active">SRC</li>
            </ol>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="box">
            <h4 class="box-title">SRC</h4>
            <button class="btn btn-table-tool btn-default" onclick="window.location='<?php echo base_url('sitecontrol/report');?>'"><i class="fa fa-arrow-left"></i> Back</button>
            <hr/>
            <div class="col-xs-12 filter-form">
                <?PHP echo form_open('sitecontrol/report/report_src'); ?>
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label>Sale of year</label>
                        <select name="syear" class="form-control selectpicker">
                            <option value="">-- Select Sale of year --</option>
                            <?php
                                if(!empty($mindate)){
                                    foreach($mindate as $min);
                                    for($i=date("Y", strtotime($min['date'])); $i<=date("Y"); $i++){
                                        $sel_date = ($search['syear'] == $i)?'selected':'';
                                        echo '<option value="'.$i.'" '.$sel_date.'>'.$i.'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Order as of</label>
                        <input type="text" name="sdate" value="<?PHP echo $search['sdate']?>" class="form-control datepicker_month">   
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Product</label>
                        <select name="pro_name" class="form-control selectpicker">
                            <!--<option value="">-- Select Product --</option>-->
                            <?php
                                if(!empty($product_list)){
                                    $search['pro_name'] = (!empty($search['pro_name']))?$search['pro_name']:1;
                                    foreach($product_list as $rs_pro){
                                        $sel_pro = ($search['pro_name'] == $rs_pro['id'])?'selected':'';
                                        echo '<option value="'.$rs_pro['id'].'" '.$sel_pro.'>'.$rs_pro['name'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Representative ID</label>
                        <select name="rep_id" class="form-control selectpicker">
                            <option value="">-- Select Representative ID --</option>
                            <?php
                                if(!empty($zone_list)){
                                    foreach($zone_list as $rs_rep){
                                        $sel_rep = ($search['rep_id'] == $rs_rep['id'])?'selected':'';
                                        echo '<option value="'.$rs_rep['id'].'" '.$sel_rep.'>'.$rs_rep['code'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Customer Type</label>
                        <select name="cus_type" class="form-control selectpicker">
                            <option value="">-- Select Customer Type --</option>
                            <?php
                                if(!empty($customer_list)){
                                    foreach($customer_list as $rs_cus){
                                        $sel_name = ($search['cus_type'] == $rs_cus['type_id'])?'selected':'';
                                        echo '<option value="'.$rs_cus['type_id'].'" '.$sel_name.'>'.$rs_cus['type_name'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Province</label>
                        <select name="province" class="form-control selectpicker">
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
                    <div class="form-group col-sm-4">
                        <button type="submit" class="btn btn-default btn-search"><i class="fa fa-search"></i> Search</button>
                        <?PHP if (!empty($search['syear']) || !empty($search['sdate']) || $search['pro_name'] != 1 || !empty($search['rep_id']) || !empty($search['cus_type']) || !empty($search['province'])) { ?>
                            &nbsp;&nbsp;
                            <button type="button" class="btn btn-default btn-search" onclick="window.location = '<?PHP echo base_url("sitecontrol/report/report_src") ?>/refresh'"><i class="fa fa-refresh"></i> Show All</button>
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

                        if (count(@$report_src_list) > 0) {
                            $i = 1; $zone_code = "";
                            foreach ($report_src_list as $rsr) {
                                if($zone_code != $rsr['zone_code']){ 
                                    $rep_id = $rsr['zone_code'];
                                }else{
                                    $rep_id = "&nbsp";
                                }
                                $total_novat = ((@$rsr['item_subtotal']-@$rsr['item_discount'])*100)/107;
                                $total_asp = (@$rsr['item_free'] > 0)?$total_novat/@$rsr['item_free']:$total_novat;
                                $total_rebate = ($total_novat*$rsr['customer_rebate_normal'])/100;
                        ?>
                                <tr>
                                    <td class="text-center"><?PHP echo $rep_id; ?></td>
                                    <td class="text-center"><?PHP echo date("d M y", strtotime(@$rsr['order_create_date'])); ?></td>
                                    <td class="text-center"><?PHP echo @$rsr['order_number']; ?></td>
                                    <td class="text-center"><?PHP echo @$rsr['customer_name']; ?></td>
                                    <td class="text-center"><?PHP echo @$rsr['province_name']; ?></td>
                                    <td class="text-center"><?PHP echo number_format(@$rsr['sum_so']); ?></td>
                                    <td class="text-center"><?PHP echo number_format(@$rsr['sum_foc']); ?></td>
                                    <td class="text-center"><?PHP echo number_format(@$rsr['item_subtotal'],2); ?></td>
                                    <td class="text-center"><?PHP echo number_format(@$rsr['item_discount'],2); ?></td>
                                    <td class="text-center"><?PHP echo number_format($total_novat,2); ?></td>
                                    <td class="text-center"><?PHP echo number_format($total_asp,2); ?></td>
                                    <td class="text-center"><?PHP echo number_format($total_rebate,2); ?></td>
                                </tr>
                                <?PHP
                                    $zone_code = $rsr['zone_code'];
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