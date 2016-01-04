<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="col-xs-8">
            <h1><i class="fa fa-file-text-o fa-lg"></i> Plot</h1>
            <ol class="breadcrumb">
                <li><a href="<?PHP echo base_url('sitecontrol/home'); ?>"> Home</a></li>
                <li><a href="<?PHP echo base_url('sitecontrol/report'); ?>"> Report</a></li>
                <li class="active">Plot</li>
            </ol>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="box">
            <h4 class="box-title">Plot</h4>
            <button class="btn btn-table-tool btn-default" onclick="window.location='<?php echo base_url('sitecontrol/report');?>'"><i class="fa fa-arrow-left"></i> Back</button>
            <hr/>
            <div class="col-xs-12 filter-form">
                <?PHP echo form_open('sitecontrol/report/report_plot'); ?>
                <div class="row">
<!--                    <div class="form-group col-sm-3">
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
                                        echo '<option value="'.$rs_prov['province_id'].'" '.$sel_province.'>'.$rs_prov['province_name_eng'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>-->
                    <div class="form-group col-sm-3">
                        <label>Product</label>
                        <select name="product" class="form-control selectpicker"  data-live-search="true">
                            <option value="">-- Select Product --</option>
                            <?php
                                if(!empty($product_list)){
                                    foreach($product_list as $rs_prod){
                                        $sel_product = ($search['product'] == $rs_prod['province_name'])?'selected':'';
                                        echo '<option value="'.$rs_prod['product_id'].'" '.$sel_product.'>'.$rs_prod['product_name'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <button type="submit" class="btn btn-default btn-search"><i class="fa fa-search"></i> Search</button>
                        <?PHP if (!empty($search['name']) || !empty($search['type']) || !empty($search['province']) || !empty($search['product'])) { ?>
                            &nbsp;&nbsp;
                            <button type="button" class="btn btn-default btn-search" onclick="window.location = '<?PHP echo base_url("sitecontrol/report/report_plot") ?>/refresh'"><i class="fa fa-refresh"></i> Show All</button>
                        <?PHP } ?>
                    </div>
                </div>
                <?PHP echo form_close(); ?>
            </div>
            <div class="table-scroll">
                <table class="table table-hover table-striped" style="table-layout: fixed;">
                    <thead>
                        <tr>
                            <th width="250px" class="text-center" rowspan="2">Representative</th>
                            <th width="100px" class="text-center"><?php echo 'Year'.(date('Y')-1);?></th>
                            <th width="1560px" class="text-center" colspan="13"><?php echo 'Year'.date('Y');?></th>
                        </tr>
                        <tr>
                            <th class="text-center">Total</th>
                            <th width="120px" class="text-center">JAN<br/>1 Jan - 26 Jan</th>
                            <th width="120px" class="text-center">FEB<br/>27 Jan - 24 Feb</th>
                            <th width="120px" class="text-center">MAR<br/>25 Feb - 26 Mar</th>
                            <th width="120px" class="text-center">APR<br/>27 Mar - 28 Apr</th>
                            <th width="120px" class="text-center">MAY<br/>29 Apr - 26 May</th>
                            <th width="120px" class="text-center">JUN<br/>27 May - 30 Jun</th>
                            <th width="120px" class="text-center">JUL<br/>1 Jul - 24 Jul</th>
                            <th width="120px" class="text-center">AUG<br/>25 Jul - 28 Aug</th>
                            <th width="120px" class="text-center">SEP<br/>29 Aug - 29 Sep</th>
                            <th width="120px" class="text-center">OCT<br/>30 Sep - 27 Oct</th>
                            <th width="120px" class="text-center">NOV<br/>28 Oct - 24 Nov</th>
                            <th width="120px" class="text-center">DEC<br/>25 Nov - 23 Dec</th>
                            <th width="120px" class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?PHP
                        if (count(@$report_plot_index['area']) > 0) {
                            foreach ($report_plot_index['area'] as $rpia) {
                                ?>
                                <tr>
                                    <td class="plot-list">Dose-sold of <?PHP echo @$rpia['area_name']; ?> Area (excluded FOC)</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                </tr>
                                <?php
                                    if (count(@$report_plot_index['zone'][$rpia['area_id']]) > 0) {
                                        foreach ($report_plot_index['zone'][$rpia['area_id']] as $rpiz) {
                                ?>
                                <tr>
                                    <td class="plot-list-indent"><?PHP echo @$rpiz['zone_code']; ?> (<?PHP echo @$rpiz['zone_name']; ?>; <?PHP echo @$rpiz['member_name']; ?>)</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                </tr>
                                <?php
                                        }
                                    }
                                ?>
                                <tr>
                                    <td class="plot-title"><?PHP echo @$rpia['area_name']; ?>Total (dose excluded FOC)</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                </tr>
                                <tr>
                                    <td class="plot-title"><?PHP echo @$rpia['area_name']; ?>Total (dose included FOC)</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                </tr>
                                <tr>
                                    <td class="plot-title"><?PHP echo @$rpia['area_name']; ?>Total (Baht excluded VAT)</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                </tr>
                                <tr>
                                    <td class="plot-title"><?PHP echo @$rpia['area_name']; ?>Total (Baht excluded VAT)</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                </tr>
                                <?PHP
                            }
                            ?>
                                <tr>
                                    <td class="plot-title">Grand Total (dose excluded FOC)</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                </tr>
                                <tr>
                                    <td class="plot-title">Grand Total (dose included FOC)</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                </tr>
                                <tr>
                                    <td class="plot-title">Grand Total (Baht excluded VAT)</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                </tr>
                                <tr>
                                    <td class="plot-list-indent">Company (direct); +FOC</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                </tr>
                                <tr>
                                    <td class="plot-list-indent">Bkk Drugstores; +FOC</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                </tr>
                                <tr>
                                    <td class="plot-list-indent">Exports; +FOC</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                </tr>
                                <tr>
                                    <td class="plot-list-indent">Thai Institute; +FOC</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                </tr>
                                <tr>
                                    <td class="plot-title">Total CPY,BDG,EXP,INS (THB;-VAT)</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                    <td class="text-center">-</td>
                                </tr>
                                <?php
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