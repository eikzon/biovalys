<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>  
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <h1><i class="fa fa-hospital-o fa-lg"></i> CA</h1>
        <ol class="breadcrumb">
            <li><a href="<?PHP echo base_url('sitecontrol') ?>"> Home</a>
            </li>
            <li>
                <a href="<?PHP echo base_url('sitecontrol/customer') ?>">CA</a>
            </li>
            <li class="active">CA Edit</li>
        </ol>
    </div>
    <div class="col-xs-12">
        <div class="box">
            <h4 class="box-title">CA Edit</h4>
            <ul class="list-unstyled list-data" style="width:50%; float:right">
                <li>
                    <p class="top-sale"> <a href="<?PHP echo base_url('sitecontrol/order/search/customer/' . $customer['customer_id'] . '/' . $customer['customer_name']); ?>">Credit</a> </p>
                    <a href="<?PHP echo base_url('sitecontrol/order/search/customer/' . $customer['customer_id'] . '/' . $customer['customer_name']); ?>">
                        <div class="progress">
                            <div class="progress-bar progress-bar-green" role="progressbar" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100" style="width: 88%">
                                <span>88%</span>
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
            <hr>
            <div class="col-xs-12">
                <?PHP echo form_open_multipart('sitecontrol/customer/update/' . @$customer['customer_id'], 'onsubmit="return form_customer()"'); ?>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <?php
                        echo form_label('CA List <span style="color:red">*</span>');
                        echo form_input(array(
                            'name' => 'cus_name',
                            'class' => 'form-control cus_name',
                            'placeholder' => 'CA List',
                            'required' => 'true'
                        ), set_value('', @$customer['customer_name']));
                        ?>
                    </div>
                    <div class="form-group col-sm-12">
                        <?php
                        echo form_label('CA Common');
                        echo form_input(array(
                            'name' => 'com_name',
                            'class' => 'form-control com_name',
                            'placeholder' => 'CA Common'
                        ), set_value('', @$customer['customer_common']));
                        ?>
                    </div>
                    <div class="form-group col-sm-6">
                        <?php
                        echo form_label('Military Hospital');
                        $military = array(
                            ' "disabled="disabled' => 'Select Military Hospital',
                            0 => 'No',
                            1 => 'Yes'
                        );
                        echo form_dropdown('customer_military', $military, @$customer['customer_military'], 'class="selectpicker" data-width="100%"');
                        ?>
                    </div>
                    <div class="form-group col-sm-6">
                        <?php
                        echo form_label('Provincial Hospital');
                        $provincial = array(
                            ' "disabled="disabled' => 'Select Provincial Hospital',
                            0 => 'No',
                            1 => 'Yes'
                        );
                        echo form_dropdown('customer_provincial', $provincial, @$customer['customer_provincial'], 'class="selectpicker" data-width="100%"');
                        ?>
                    </div>
                    <div class="form-group col-sm-2">
                        <?php
                        echo form_label('Date');
                        echo form_input(array(
                            'name' => 'credit_date',
                            'class' => 'form-control datepicker',
                            'placeholder' => 'Date',
                            'value' => date('d/m/Y')
                        ), set_value('', date('d/m/Y', strtotime(@$customer['customer_date_credit']))));
                        ?>
                    </div>
<!--                    <div class="form-group col-sm-9">
                        <?php
                        echo form_label('Representative Name <span style="color:red">*</span>');
                        echo form_input(array(
                            'name' => 'rep_name',
                            'class' => 'form-control',
                            'placeholder' => 'Representative Name',
                            'required' => 'true'
                        ), set_value('', @$customer['customer_represent_name']));
                        ?>
                    </div>-->
                    <div class="form-group col-sm-5">
                        <?php
                        echo form_label('Area <span style="color:red;">*</span>');
                        $zone_data = array('' => '-- Select Area --');
                        if (isset($zone_list)) {
                            foreach ($zone_list as $zone) {
                                $zone_data[$zone['zone_id'].'##'.$zone['member_id']] = $zone['zone_code'] . ' - ' . $zone['member_name'];
                            }
                        }
                        echo form_dropdown('zone_id', $zone_data, @$customer['FK_zone_id'].'##'.@$customer['member_id'], 'class="selectpicker" data-width="100%" data-live-search="true" required style="position:absolute; top:55px; width:1px; height:1px; display:inline-block !important; opacity:0; "');
                        ?>
                    </div>
                    <div class="form-group col-sm-5">
                        <?php
                        echo form_label('Tax Invoice <span style="color: red;">*</span>');
                        echo form_input(array(
                            'name' => 'customer_taxid',
                            'class' => 'form-control onlyint',
                            'placeholder' => 'Tax Invoice',
                            'maxlength' => 13,
                            'required' => 'true'
                            
                        ), set_value('', @$customer['customer_taxid']));
                        ?>
                    </div>
                    <div class="form-group col-sm-12">
                        <?php
                        echo form_label('Address');
                        echo form_textarea(array(
                            'class' => 'form-control',
                            'name' => 'cus_address',
                            'rows' => 3,
                        ), set_value('', @$customer['customer_address']));
                        ?>
                    </div>
                    <div class="form-group col-sm-8">
                        <?php
                        echo form_label('Province <span style="color:red;">*</span>');
                        $province_data = array('' => '-- Select Province --');
                        if (isset($province_list)) {
                            foreach ($province_list as $prov) {
                                if(@$customer['customer_province'] == $prov['prov_id']){
                                    $cus_name = $prov['prov_name'];
                                }
                                $province_data[$prov['prov_id']] = $prov['prov_name'];
                            }
                        }
                        echo form_dropdown('cus_province', $province_data, @$customer['customer_province'], 'class="selectpicker cus_province" data-width="100%" data-live-search="true" required  style="position:absolute; top:55px; width:1px; height:1px; display:inline-block !important; opacity:0; "');
                        ?>
                    </div>
                    <div class="form-group col-sm-4">
                        <?php
                        echo form_label('Zip code');
                        echo form_input(array(
                            'name' => 'cus_zone',
                            'class' => 'form-control onlyint',
                            'placeholder' => 'Zip Code',
                        ), set_value('', @$customer['customer_postcode']));
                        ?>
                    </div>
                    <div class="form-group col-sm-4">
                        <?php
                        echo form_label('Pharmacist Name <span style="color: red;">*</span>');
                        echo form_input(array(
                            'name' => 'customer_pharmacist',
                            'class' => 'form-control onlyint',
                            'placeholder' => 'Pharmacist Name',
                            'required' => 'true'
                        ), set_value('', @$customer['customer_pharmacist']));
                        ?>
                    </div>
                    <div class="form-group col-sm-4">
                        <?php
                        echo form_label('Telphone No.');
                        echo form_input(array(
                            'name' => 'cus_tel',
                            'class' => 'form-control onlyint',
                            'placeholder' => 'Tel No.',
                        ), set_value('', @$customer['customer_telephone']));
                        ?>
                    </div>
                    <div class="form-group col-sm-4">
                        <?php
                        echo form_label('Customer number <span style="color: red;">* เลขที่ได้จาก biopex</span>');
                        echo form_input(array(
                            'name' => 'cus_number',
                            'class' => 'form-control onlyint',
                            'placeholder' => 'Customer number',
                        ), set_value('', @$customer['customer_number']));
                        ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-12">
                        <?php
                        echo form_label('Remark');
                        echo form_textarea(array(
                            'class' => 'form-control',
                            'name' => 'cus_remark',
                            'rows' => 3,
                            
                        ), set_value('', @$customer['customer_remark']));
                        ?>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
<!--                    <div class="form-group col-sm-6">
                        <label class="label-inline">Requires Quotation?</label>
                        <label class="radio radio-inline">
                            <input type="radio" name="requ_quota" data-toggle="radio" id="requ_quota1" value="1" <?php echo (@$customer['customer_quotation_status'] == 1)?'checked':'';?> />
                            Yes
                        </label>
                        <label class="radio radio-inline">
                            <input type="radio" name="requ_quota" data-toggle="radio" id="requ_quota0" value="0" <?php echo (@$customer['customer_quotation_status'] == 0)?'checked':'';?>/> No
                        </label>
                    </div>-->
<!--                    <div class="form-group col-sm-6">
                        <label class="label-inline">Invoice Printing Date?</label>
                        <label class="radio radio-inline">
                            <input type="radio" name="inv_print" data-toggle="radio" id="inv_print1" value="1" <?php echo (@$customer['customer_invoice_status'] == 1)?'checked':'';?> />
                            <i></i>Yes
                        </label>
                        <label class="radio radio-inline">
                            <input type="radio" name="inv_print" data-toggle="radio" id="inv_print0" value="0" <?php echo (@$customer['customer_invoice_status'] == 0)?'checked':'';?>/> No
                        </label>
                    </div>-->
                    <div class="clearfix"></div>
                    <hr/>
                    <label class="col-sm-12"><h4>CA Type <span style="color:red">*</span></h4></label>
                    <div class="form-group col-sm-6">
                        <?PHP
                        if (isset($type_list)) {
                            $k = 1;
                            foreach ($type_list as $type) {
                                ?>
                                <label class="checkbox" for="checkbox<?PHP echo $k; ?>">
                                    <input type="radio" name="cus_type" id="checkbox<?PHP echo $k; ?>" data-toggle="checkbox" required="" value="<?PHP echo $type['type_id']; ?>" <?php echo (@$customer['FK_type_id'] == $type['type_id'])?'checked':'';?>/> <?PHP echo $type['type_name']; ?>
                                </label>
                                <?PHP
                                $k++;
                            }
                        }
                        ?>
                        <input type="hidden" name="count_type" value="<?PHP echo count($type_list); ?>">
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="col-sm-6 input-inline ">Credit Rating Recommended :</label>
                        <div class="input-group col-sm-6 ">
                            <input type="text" name="credit_price" class="form-control onlynumber" id="credit_price" placeholder="Credit" value="<?php echo str_replace(',','',@$customer['customer_credit_price']);?>"/>
                            <div class="input-group-addon">Baht</div>
                        </div>
                        <label class="col-sm-6 input-inline ">Payment Term :</label>
                        <div class="input-group col-sm-6 ">
                            <input type="text" name="pay_term" class="form-control onlyint" placeholder="Tearm" value="<?php echo @$customer['customer_payment_term'];?>"/>
                            <div class="input-group-addon">Day</div>
                        </div>
                        <label class="col-sm-6 input-inline ">Payment channel :</label>
                        <div class="input-group col-sm-6 ">
                            <input type="text" name="pay_channel" class="form-control" id="" placeholder="" value="<?php echo @$customer['customer_payment_channel'];?>"/>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr/>
                    <label class="col-sm-12"><h4>Rebate</h4></label>
                    <div class="form-group col-sm-4">
                        <?php
                            echo form_label('Normal Rebate');
                            echo '<div class="input-group col-sm-12 ">';
                                echo form_input(array(
                                    'name' => 'rebate_normal',
                                    'class' => 'form-control onlyint',
                                    'maxlength' => 3 
                                ), set_value('', @$customer['customer_rebate_normal']));
                                echo '<div class="input-group-addon">%</div>';
                            echo '</div>';
                        ?>
                    </div>
                    <div class="form-group col-sm-4">
                        <?php
                            echo form_label('Extra Rebate(S)');
                            echo '<div class="input-group col-sm-12 ">';
                                echo form_input(array(
                                    'name' => 'rebate_extra_s',
                                    'class' => 'form-control onlyint',
                                    'maxlength' => 3
                                ), set_value('', @$customer['customer_rebate_extra_s']));
                                echo '<div class="input-group-addon">%</div>';
                            echo '</div>';
                        ?>
                    </div>
                    <div class="form-group col-sm-4">
                        <?php
                            echo form_label('Extra Rebate(Td)');
                            echo '<div class="input-group col-sm-12 ">';
                                echo form_input(array(
                                    'name' => 'rebate_extra_td',
                                    'class' => 'form-control onlyint',
                                    'maxlength' => 3
                                ), set_value('', @$customer['customer_rebate_extra_td']));
                                echo '<div class="input-group-addon">%</div>';
                            echo '</div>';
                        ?>
                    </div>
                    <div class="clearfix"></div>
                    <hr/>
                    <label class="col-sm-12"><h4>Price Rate</h4></label>
                    <?php
                        if(!empty($product_list)){
                            foreach($product_list as $prod){
                                echo '<div class="form-group col-sm-6">';
                                    echo form_label(@$prod['product_name'].' (Price/Box)');
                                    echo '<div class="input-group col-sm-6 ">';
                                        echo form_input(array(
                                            'name' => 'product[]',
                                            'class' => 'form-control onlynumber'
                                        ), set_value('', @$rate_price[$prod['product_id']]));
                                        echo form_hidden(array('product_id[]' => @$prod['product_id']));
                                        echo '<div class="input-group-addon">Baht</div>';
                                    echo '</div>';
                                echo '</div>';
                            }
                        }
                    ?>
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-6">
                        <?php
                            echo form_label('Status');
                            $status_data[0] = 'Wait';
                            $status_data[1] = 'Approve';
                            $status_data[2] = 'Reject';
                            echo form_dropdown('customer_approve', $status_data, @$customer['customer_approve'], 'class="selectpicker" data-width="100%"');
                        ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-12">
                        <button class="btn btn-info" type="submit"><i class="fa fa-check"></i> Save</button>
                        <button class="btn btn-default" type="reset"><i class="fa fa-times"></i> Cancel</button>
                    </div>
                </div>
                <?php echo form_close();?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<?PHP
// Gen Template
echo $temp['footer'];
?>
<script>
    $('.cus_name').keyup(function () {
        $('.com_name').val(this.value);
    });
</script>