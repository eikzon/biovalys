<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="col-xs-8">
            <h1><i class="fa fa-file-text-o fa-lg"></i> Report</h1>
            <ol class="breadcrumb">
                <li><a href="<?PHP echo base_url('sitecontrol/home'); ?>"> Home</a></li>
                <li><a href="<?PHP echo base_url('sitecontrol/report'); ?>"> Report</a></li>
                <li class="active">CR</li>
            </ol>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="box">
            <h4 class="box-title">CR</h4>
            <button class="btn btn-table-tool btn-default" onclick="window.location = '<?php echo base_url('sitecontrol/report'); ?>'"><i class="fa fa-arrow-left"></i> Back</button>
            <hr/>
            <div class="col-xs-12 filter-form">
                <?PHP echo form_open('sitecontrol/report/search_report_cr'); ?>
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label>Product</label>
                        <select name="pro_name" class="form-control selectpicker pro_name" data-live-search="true">
                            <!--<option value="">-- Select Product --</option>-->
                            <?php
                            if (!empty($product_list)) {
                                $search['pro_name'] = (!empty($search['pro_name'])) ? $search['pro_name'] : 1;
                                foreach ($product_list as $rs_pro) {
                                    $sel_pro = ($search['pro_name'] == $rs_pro['id']) ? 'selected' : '';
                                    echo '<option value="' . $rs_pro['id'] . '" ' . $sel_pro . '>' . $rs_pro['name'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <label>Representative ID</label>
                        <select name="rep_id" class="form-control selectpicker" data-live-search="true">
                            <option value="">-- Select Representative ID --</option>
                            <?php
                            if (!empty($zone_list)) {
                                foreach ($zone_list as $rs_rep) {
                                    $sel_rep = ($search['rep_id'] == $rs_rep['code']) ? 'selected' : '';
                                    echo '<option value="' . $rs_rep['code'] . '" ' . $sel_rep . '>' . $rs_rep['code'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <?php
                            $stype_array = array('' => 'Select All');
                            $stype_array['so'] = 'Sale Order';
                            $stype_array['foc'] = 'F.O.C';
                            $stype_array['lo'] = 'Borrow-Returns';
                            echo form_label('Type');
                            echo form_dropdown('stype', $stype_array, @$search['stype'], 'class="form-control selectpicker" data-live-search="true"');
                        ?>
                    </div>
                    <div class="form-group col-sm-2">
                        <label>Month</label>
                        <input type="text" name="sdate" value="<?PHP echo @$search['sdate'] ?>" class="form-control datepicker_month" readOnly>   
                    </div>
                    <div class="form-group col-sm-3">
                        <button type="submit" class="btn btn-default btn-search"><i class="fa fa-search"></i> Search</button>
                        <?PHP if ($search['pro_name'] != 1 || !empty($search['rep_id']) || !empty($search['sdate']) || !empty($search['stype'])) { ?>
                            &nbsp;&nbsp;
                            <button type="button" class="btn btn-default btn-search" onclick="window.location = '<?PHP echo base_url("sitecontrol/report/refresh_report_cr") ?>'"><i class="fa fa-refresh"></i> Show All</button>
                        <?PHP } ?>
                    </div>
                </div>
                <?PHP echo form_close(); ?>
            </div>
            <div class="text-right col-xs-12"><?PHP echo @$links; ?></div>
            <div class="table-scroll">
                <table class="table table-hover table-striped" style="table-layout: fixed;">
                    <thead>
                        <!--<tr>
                            <td colspan="23">
                                <div style="padding-bottom:15px; width:100%">
                                    <div style="float:left; vertical-align:top">
                                        <img src="<?//PHP echo base_url("assets_sitecontrol/img/logo.jpg"); ?>" width="300">
                                    </div>
                                    <div style="font-size:18px; font-weight:normal; float:left; padding-left:100px;">
                                        <b>TO:</b>MSR/AM/BSM/NSM/Senior consultant&nbsp;&nbsp;&nbsp;<b>FROM: </b>Administrative Officer<br>
                                        <b>DATE:</b> November 10, 2015<br>
                                        <b>SUBJECT:</b> 1<sup>st</sup>/Last Order details, Customer Retention measured by Repeating Order of SPEEDA<sup>TM</sup>
                                    </div>
                                </div>
                            </td>
                        </tr>-->
                        <tr>
                            <th width="550px" colspan="4">&nbsp;</th>
                            <th class="text-center" width="200px" colspan="2">DATE OF FIRST ORDER</th>
                            <th class="text-center" width="1120px" colspan="17">CUSTOMER RETENTION MEASURED BY REPEATING ORDER BY MONTH A &amp; PROBABILITY OF REORDERING FROM HISTORICAL TREND B</th>
                            <th class="text-center" width="200px" colspan="2">DATE OF LAST ORDER</th>
                        </tr>
                        <tr>
                            <th width="50px" class="text-center" rowspan="2" style="vertical-align:middle">No.</th>
                            <th width="50px" class="text-center" rowspan="2" style="vertical-align:middle">Rep.ID</th>
                            <th width="150px" class="text-center" rowspan="2" style="vertical-align:middle">Province</th>
                            <th width="300px" class="text-center" rowspan="2" style="vertical-align:middle">Customer Name</th>
                            <th width="100px" class="text-center" rowspan="2" style="vertical-align:middle">IV issued Date</th>
                            <th width="100px" class="text-center" rowspan="2" style="vertical-align:middle">Order as of</th>
                            <th width="1120px" class="text-center" colspan="14"><span class="show-product-name"></span> Quantity (dose)</th>
                            <th width="100px" class="text-center" colspan="3">Prob.(%)</th>
                            <th width="100px" class="text-center" rowspan="2" style="vertical-align:middle">IV issued Date</th>
                            <th width="100px" class="text-center" rowspan="2" style="vertical-align:middle">Order as of</th>
                        </tr>
                        <tr>
                            <?PHP foreach ($date as $dw) { ?>
                                <th width="80px" class="text-center"><?PHP echo $dw; ?></th>
                            <?PHP } ?>
                            <th width="50px" class="text-center" style="vertical-align:middle">Average</th>
                            <th width="50px" class="text-center">12M</th>
                            <th width="50px" class="text-center">6M</th>
                            <th width="50px" class="text-center">3M</th>                            
                        </tr>
                    </thead>
                    <tbody>
                        <?PHP
                        if (isset($report_cr_list) && !empty($report_cr_list)) {
                            if($this->uri->segment(4)){
                                $i = ($this->uri->segment(4)+1);
                            }else{
                                $i = 1;
                            }
                            foreach ($report_cr_list as $rcr) {
                                ?>
                                <tr>
                                    <td class="text-center"><?PHP echo $i; ?></td>
                                    <td class="text-center"><?PHP echo $rcr['zone']; ?></td>
                                    <td class="text-center"><?PHP echo $rcr['province']; ?></td>
                                    <td class="text-center tickLabel"><span data-toggle="tooltip" title="<?PHP echo $rcr['customer_name']; ?>"><?PHP echo $rcr['customer_name']; ?><span></td>
                                    <td class="text-center"><?PHP echo date("d M y", strtotime($rcr['order_first_date'])); ?></td>
                                    <td class="text-center"><?PHP echo date("Ym", strtotime($rcr['order_first_date'])); ?></td>
                                    <?PHP
                                    $count = 0;
                                    $total = 0;
                                    $month = 0;
                                    $arr = explode("||", $rcr['order_qty']);
                                    for ($k = 0; $k < count($arr) - 1; $k++) {
                                        if ($arr[$k] > 0) {
                                            $count++;
                                            $total = $total + $arr[$k];
                                            if($k > 0){
                                                $month++;
                                            }
                                        }
                                        echo '<td class="text-center">' . $arr[$k] . '</td>';
                                    }
                                    $average = (!empty($total) && !empty($count))?number_format($total / $count):0;
                                    ?>
                                    <td class="text-center"><?PHP echo $average; ?></td>
                                    <td class="text-center"><?php echo number_format($month/0.12);?></td>
                                    <td class="text-center"><?php echo number_format($month/0.06);?></td>
                                    <td class="text-center"><?php echo number_format($month/0.03);?></td>
                                    <td class="text-center"><?PHP echo date("d M y", strtotime($rcr['order_last_date'])); ?></td>
                                    <td class="text-center"><?PHP echo date("Ym", strtotime($rcr['order_last_date'])); ?></td>
                                </tr>
                                <?PHP
                                $i++;
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="25" align="center">No Data</td>
                            </tr>
                        <?PHP } ?>
                    </tbody>
                </table>
            </div>
            <div class="text-right col-xs-12"><?PHP echo @$links; ?></div>
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
<script>
    $('.show-product-name').html($( ".pro_name option:selected" ).text());
</script>