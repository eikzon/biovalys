<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="col-xs-8">
            <h1><i class="fa fa-file-text-o fa-lg"></i> CN-LO</h1>
            <ol class="breadcrumb">
                <li><a href="<?PHP echo base_url('sitecontrol/home'); ?>"> Home</a></li>
                <li><a href="<?PHP echo base_url('sitecontrol/report'); ?>"> Report</a></li>
                <li class="active">CN-LO</li>
            </ol>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="box">
            <h4 class="box-title">CN-LO</h4>
            <button class="btn btn-table-tool btn-default" onclick="window.location='<?php echo base_url('sitecontrol/report');?>'"><i class="fa fa-arrow-left"></i> Back</button>
            <hr/>
            <div class="col-xs-12 filter-form">
                <?PHP echo form_open('sitecontrol/report/report_cn_lo'); ?>
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label>CA Name</label>
                        <select name="name" class="form-control selectpicker" data-live-search="true">
                            <option value="">-- Select CA Name --</option>
                            <?php
                                if(!empty($custotmer_list)){
                                    foreach($custotmer_list as $rs_cus){
                                        $sel_name = ($search['name'] == $rs_cus['customer_id'])?'selected':'';
                                        echo '<option value="'.$rs_cus['customer_id'].'" '.$sel_name.'>'.sprintf('%05d', $rs_cus['customer_id']).' - '.$rs_cus['customer_name'].'</option>';
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
                                        echo '<option value="'.$rs_prov['province_id'].'" '.$sel_province.'>'.$rs_prov['province_name_eng'].'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
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
                            <th width="60px" class="text-center">Index</th>
                            <th width="100px" class="text-center">SO No.</th>
                            <th width="110px">SO issued Date</th>
                            <th width="100px">Invoice No.</th>
                            <th width="110px">IV issued Date</th>
                            <th width="100px">Order as of</th>
                            <th width="150px">Product</th>
                            <th width="60px">Rep.ID</th>
                            <th width="60px">Area</th>
                            <th width="60px">Rep.ID<br/>by C&I</th>
                            <th width="60px">Cust.ID</th>
                            <th width="200px">Customer Type</th>
                            <th width="200px">Customer Name</th>
                            <th width="150px">Province</th>
                            <th width="100px">BOP Check<br/>Vol(-FOC)</th>
                            <th width="100px">BOP Check<br/>F.O.C.Vol</th>
                            <th width="100px">BOP Check<br/>Value(net)</th>
                            <th width="100px">Status</th>
                            <th width="300px">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?PHP
                        if (count(@$report_foc_index) > 0) {
                            $i = 1;
                            foreach ($report_foc_index as $rfi) {
                                ?>
                                <tr>
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
                                <td colspan="19" align="center">No Data</td>
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