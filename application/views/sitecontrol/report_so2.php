<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="col-xs-8">
            <h1><i class="fa fa-file-text-o fa-lg"></i> SO2</h1>
            <ol class="breadcrumb">
                <li><a href="<?PHP echo base_url('sitecontrol/home'); ?>"> Home</a></li>
                <li><a href="<?PHP echo base_url('sitecontrol/report'); ?>"> Report</a></li>
                <li class="active">SO2</li>
            </ol>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="box">
            <h4 class="box-title">SO2</h4>
            <button class="btn btn-table-tool btn-default" onclick="window.location='<?php echo base_url('sitecontrol/report');?>'"><i class="fa fa-arrow-left"></i> Back</button>
            <hr/>
            <div class="col-xs-12 filter-form">
                <?PHP echo form_open('sitecontrol/report/report_so2'); ?>
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label>CA Name</label>
                        <select name="name" class="form-control selectpicker" data-live-search="true">
                            <option value="">-- Select CA Name --</option>
                            <?php
                                if(!empty($customer_list)){
                                    foreach($customer_list as $rs_cus){
                                        $sel_name = ($search['name'] == $rs_cus['customer_id'])?'selected':'';
                                        echo '<option value="'.$rs_cus['customer_id'].'" '.$sel_name.'>'.sprintf('%05d', $rs_cus['customer_id']).' - '.$rs_cus['customer_name'].'</option>';
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
                            <button type="button" class="btn btn-default btn-search" onclick="window.location = '<?PHP echo base_url("sitecontrol/report/report_so2") ?>/refresh'"><i class="fa fa-refresh"></i> Show All</button>
                        <?PHP } ?>
                    </div>
                </div>
                <?PHP echo form_close(); ?>
            </div>
            <div class="table-scroll">
                <table class="table table-hover table-striped" style="table-layout: fixed;">
                    <thead>
                        <tr>
                            <th width="50px" class="text-center">Index</th>
                            <th width="100px" class="text-center">External<br/>Invoice No.</th>
                            <th width="100px">Ext IV<br/>issued Date</th>
                            <th width="100px">Internal<br/>Invoice No.</th>
                            <th width="100px">Int IV<br/>issued Date</th>
                            <th width="100px">Order as of</th>
                            <th width="100px">Product</th>
                            <th width="50px">Rep.ID</th>
                            <th width="60px">Cust.ID</th>
                            <th width="200px">Customer Type</th>
                            <th width="200px">Customer Name</th>
                            <th width="200px">Place of Delivery</th>
                            <?php
                                if(count($product_list) > 0){
                                    foreach($product_list as $th => $thead_prod){
                                        if($th == 0){
                                            $bg_color = '#4bacc6';
                                            $font_color = '#ffffff';
                                        }else if($th == 1){
                                            $bg_color = '#c0504d';
                                            $font_color = '#ffffff';
                                        }else if($th == 2){
                                            $bg_color = '#f79646';
                                            $font_color = '#ffffff';
                                        }else if($th == 3){
                                            $bg_color = '#8064a2';
                                            $font_color = '#ffffff';
                                        }else if($th == 4){
                                            $bg_color = '#1f497d';
                                            $font_color = '#ffffff';
                                        }else if($th == 5){
                                            $bg_color = '#9bbb59';
                                            $font_color = '#ffffff';
                                        }else if($th == 6){
                                            $bg_color = '#948a54';
                                            $font_color = '#ffffff';
                                        }else{
                                            $bg_color = '#ffffff';
                                            $font_color = '#000000';
                                        }
                                        echo '<th width="100px" style="background-color: '.$bg_color.';color: '.$font_color.'">'.$thead_prod['product_name'].'<br/>Quantity<br/>(Box)</th>';
                                        echo '<th width="100px" style="background-color: '.$bg_color.';color: '.$font_color.'">'.$thead_prod['product_name'].'<br/>Quantity<br/>(dose)</th>';
                                        echo '<th width="100px" style="background-color: '.$bg_color.';color: '.$font_color.'">'.$thead_prod['product_name'].'<br/>Quantity +FOC<br/>(dose)</th>';
                                        echo '<th width="100px" style="background-color: '.$bg_color.';color: '.$font_color.'">'.$thead_prod['product_name'].'<br/>Price/unit<br/>(Baht)</th>';
                                        echo '<th width="100px" style="background-color: '.$bg_color.';color: '.$font_color.'">'.$thead_prod['product_name'].'<br/>Price/dose +VAT<br/>(Baht)</th>';
                                        echo '<th width="100px" style="background-color: '.$bg_color.';color: '.$font_color.'">'.$thead_prod['product_name'].'<br/>Total<br/>(Baht)</th>';
                                        echo '<th width="100px" style="background-color: '.$bg_color.';color: '.$font_color.'">'.$thead_prod['product_name'].'<br/>Discount<br/>(Baht)</th>';
                                        echo '<th width="100px" style="background-color: '.$bg_color.';color: '.$font_color.'">'.$thead_prod['product_name'].'<br/>Total-VAT -Disc<br/>(Baht)</th>';
                                        echo '<th width="100px" style="background-color: '.$bg_color.';color: '.$font_color.'">'.$thead_prod['product_name'].'<br/>ASP<br/>(Baht/dose)</th>';
                                        echo '<th width="100px" style="background-color: '.$bg_color.';color: '.$font_color.'">'.$thead_prod['product_name'].'<br/>Rebate<br/>(Baht)</th>';
                                        echo '<th width="100px" style="background-color: '.$bg_color.';color: '.$font_color.'">'.$thead_prod['product_name'].'<br/>F.O.C.<br/>(Box)</th>';
                                        echo '<th width="100px" style="background-color: '.$bg_color.';color: '.$font_color.'">'.$thead_prod['product_name'].'<br/>F.O.C.<br/>(dose)</th>';
                                    }
                                }
                            ?>
                            <th width="100px">Remaining<br/>Credit (day)</th>
                            <th width="100px">Self-collecting<br/>(1/0)</th>
                            <th width="100px">Completed<br/>Collecting<br/>(1/0)</th>
                            <th width="100px">BOP Check<br/>Vol(-FOC)</th>
                            <th width="100px">BOP Check<br/>Vol(+FOC)</th>
                            <th width="100px">BOP Check<br/>Value(net)</th>
                            <th width="100px">AR submit<br/>Date</th>
                            <th width="50px">M</th>
                            <th width="50px">Y</th>
                            <th width="100px">Rebate Paid<br/>(1/0)</th>
                            <th width="100px">RSR issued<br/>Date</th>
                            <th width="50px">M</th>
                            <th width="50px">Y</th>
                            <th width="100px">Placing Bill<br/>(1/0)</th>
                            <th width="100px">Bill Placing<br/>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?PHP
                        if (count(@$report_so2_index) > 0) {
                            $i = 1;
                            foreach ($report_so2_index as $rso2i) {
                                ?>
                                <tr>
                                    <td class="text-center"><?PHP echo $i; ?></td>
                                    <td class="text-center"><?PHP echo @$rso2i['order_number']; ?></td>
                                    <td class="text-center"><?PHP echo date('d M y', strtotime(@$rso2i['order_create_date'])); ?></td>
                                    <td class="text-center"><?PHP echo @$rso2i['order_number']; ?></td>
                                    <td class="text-center"><?PHP echo date('d M y', strtotime(@$rso2i['order_create_date'])); ?></td>
                                    <td class="text-center"><?PHP echo date('Ym', strtotime(@$rso2i['order_create_date'])); ?></td>
                                    <td class="text-center"><?PHP echo @$rso2i['product_name']; ?></td>
                                    <td class="text-center"><?PHP echo @$rso2i['zone_code']; ?></td>
                                    <td class="text-center"><?PHP echo sprintf('%05d', @$rso2i['customer_id']); ?></td>
                                    <td class="text-center"><?PHP echo @$rso2i['cus_type_name']; ?></td>
                                    <td class="text-center"><?PHP echo @$rso2i['customer_name']; ?></td>
                                    <td class="text-center"></td>
                                    <?php
                                        if(count($product_list) > 0){
                                            foreach($product_list as $th => $thead_prod){
                                                if($th == 0){
                                                    $bg_color = '#4bacc6';
                                                    $font_color = '#ffffff';
                                                }else if($th == 1){
                                                    $bg_color = '#c0504d';
                                                    $font_color = '#ffffff';
                                                }else if($th == 2){
                                                    $bg_color = '#f79646';
                                                    $font_color = '#ffffff';
                                                }else if($th == 3){
                                                    $bg_color = '#8064a2';
                                                    $font_color = '#ffffff';
                                                }else if($th == 4){
                                                    $bg_color = '#1f497d';
                                                    $font_color = '#ffffff';
                                                }else if($th == 5){
                                                    $bg_color = '#9bbb59';
                                                    $font_color = '#ffffff';
                                                }else if($th == 6){
                                                    $bg_color = '#948a54';
                                                    $font_color = '#ffffff';
                                                }else{
                                                    $bg_color = '#ffffff';
                                                    $font_color = '#000000';
                                                }
                                                echo '<td class="text-center" style="background-color: '.$bg_color.';color: '.$font_color.'"></td>';
                                                echo '<td class="text-center" style="background-color: '.$bg_color.';color: '.$font_color.'"></td>';
                                                echo '<td class="text-center" style="background-color: '.$bg_color.';color: '.$font_color.'"></td>';
                                                echo '<td class="text-center" style="background-color: '.$bg_color.';color: '.$font_color.'"></td>';
                                                echo '<td class="text-center" style="background-color: '.$bg_color.';color: '.$font_color.'"></td>';
                                                echo '<td class="text-center" style="background-color: '.$bg_color.';color: '.$font_color.'"></td>';
                                                echo '<td class="text-center" style="background-color: '.$bg_color.';color: '.$font_color.'"></td>';
                                                echo '<td class="text-center" style="background-color: '.$bg_color.';color: '.$font_color.'"></td>';
                                                echo '<td class="text-center" style="background-color: '.$bg_color.';color: '.$font_color.'"></td>';
                                                echo '<td class="text-center" style="background-color: '.$bg_color.';color: '.$font_color.'"></td>';
                                                echo '<td class="text-center" style="background-color: '.$bg_color.';color: '.$font_color.'"></td>';
                                                echo '<td class="text-center" style="background-color: '.$bg_color.';color: '.$font_color.'"></td>';
                                            }
                                        }
                                    ?>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
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