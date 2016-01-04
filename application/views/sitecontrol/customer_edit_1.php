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
            <li class="active">CA Information</li>
        </ol>
    </div>
    <div class="col-xs-12">
        <div class="box">
            <?PHP
            if (isset($customer)) {
                foreach ($customer as $cus)
                    ;
            }
            ?>
            <h4 class="box-title">CA Information</h4>
            <ul class="list-unstyled list-data" style="width:50%; float:right">
                <li>
                    <p class="top-sale"> <a href="<?PHP echo base_url('sitecontrol/order/search/customer/' . $cus['id'] . '/' . $cus['cus_name']); ?>">Credit</a> </p>
                    <a href="<?PHP echo base_url('sitecontrol/order/search/customer/' . $cus['id'] . '/' . $cus['cus_name']); ?>">
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
                <?PHP echo form_open_multipart('sitecontrol/customer/update/' . $cus['id'], 'onsubmit="return form_customer()"'); ?>
                <div class="row">
                    <div class="form-group col-sm-8">
                        <label>Credit Application No :</label>
                        <input type="text" name="credit_number" class="form-control" placeholder="Credit Application No" value="<?PHP echo $cus['credit_number']; ?>">
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Date</label>
                        <input type="text" name="credit_date" class="form-control datepicker" placeholder="Date" value="<?PHP echo $cus['credit_date']; ?>">
                    </div>
                    <div class="form-group col-sm-8">
                        <label>Representative Name :</label>
                        <input type="text" name="rep_name" class="form-control" placeholder="Representative Name" value="<?PHP echo $cus['rep_name']; ?>">
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Rep .ID :</label>
                        <input type="text" name="rep_id" class="form-control" placeholder="Rep .ID" value="<?PHP echo $cus['rep_id']; ?>">
                    </div>
                    <!--                                <div class="form-group col-sm-12">
                                                        <label>CA ID (A/C) :</label>
                                                        <input type="text" name="cus_id" class="form-control" placeholder="CA ID" value="<?PHP echo $cus['cus_id']; ?>">
                                                    </div>-->
                    <div class="form-group col-sm-12">
                        <label>CA List :</label>
                        <input type="text" name="cus_name" class="form-control" placeholder="CA List" value="<?PHP echo $cus['cus_name']; ?>">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Zone</label>
                        <select name="zone_id" class="selectpicker" data-width="100%" onchange="member_name(this.value)">
                            <option value="0">-- Select Zone --</option>
                            <?PHP
                            if (isset($zone_list)) {
                                foreach ($zone_list as $zone) {
                                    ?>
                                    <option value="<?PHP echo $zone['zone_id']; ?>" <?PHP echo ($zone['zone_id'] == $cus['zone_id']) ? "selected" : ""; ?>><?PHP echo $zone['zone_name'] ?></option>
                                    <?PHP
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Sale Name :</label>
                        <sapn class="form-control" id="member_name"><?PHP echo $cus['sale_name']; ?></sapn>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Address :</label>
                        <textarea class="form-control" rows="3" name="cus_address"><?PHP echo $cus['cus_address']; ?></textarea>
                    </div>
                    <div class="form-group col-sm-8">
                        <label>Provice</label>
                        <select name="cus_province" class="selectpicker" data-width="100%">
                            <option value="0">-- Select Province --</option>
                            <?PHP
                            if (isset($province_list)) {
                                foreach ($province_list as $prov) {
                                    ?>
                                    <option <?PHP echo ($cus['cus_province'] == $prov['prov_id']) ? 'selected' : ''; ?> value="<?PHP echo $prov['prov_id']; ?>"><?PHP echo $prov['prov_name'] ?></option>
                                    <?PHP
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Zip code:</label>
                        <input type="text" name="cus_zone" class="form-control" placeholder="Zip Code" value="<?PHP echo $cus['cus_zone']; ?>">
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Telphone No. :</label>
                        <input type="text" name="cus_tel" class="form-control" placeholder="Tel No." value="<?PHP echo $cus['cus_tel']; ?>">
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Remark :</label>
                        <textarea class="form-control" rows="3" name="cus_remark"><?PHP echo $cus['cus_remark']; ?></textarea>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <div class="form-group col-sm-6">
                        <label class="label-inline">Requires Quotation?</label>
                        <label class="radio radio-inline">
                            <input type="radio" name="requ_quota" data-toggle="radio" id="optionsRadios1" value="0" <?PHP echo ($cus['requ_quota'] == 0) ? 'checked' : ''; ?>>
                            <i></i>Yes
                        </label>
                        <label class="radio radio-inline" for="checkbox2">
                            <input type="radio" name="requ_quota" data-toggle="radio" id="optionsRadios1" value="1" <?PHP echo ($cus['requ_quota'] == 1) ? 'checked' : ''; ?>> No
                        </label>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="label-inline">Invoice Printing Date?</label>
                        <label class="radio radio-inline">
                            <input type="radio" name="inv_print" data-toggle="radio" id="optionsRadios1" value="0" <?PHP echo ($cus['inv_print'] == 0) ? 'checked' : ''; ?>>
                            <i></i>Yes
                        </label>
                        <label class="radio radio-inline" for="checkbox2">
                            <input type="radio" name="inv_print" data-toggle="radio" id="optionsRadios1" value="1" <?PHP echo ($cus['inv_print'] == 1) ? 'checked' : ''; ?>> No
                        </label>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <label class="col-sm-12">CA Type</label>
                    <div class="form-group col-sm-6">
                        <?PHP
                        if (isset($type_list)) {
                            $k = 1;
                            foreach ($type_list as $type) {
                                ?>
                                <label class="checkbox" for="checkbox<?PHP echo $k; ?>">
                                    <input type="radio" name="cus_type" id="checkbox<?PHP echo $k; ?>" data-toggle="checkbox" value="<?PHP echo $type['type_id']; ?>" <?PHP echo ($cus['type_id'] == $type['type_id']) ? 'checked' : ''; ?>> <?PHP echo $type['type_name']; ?>
                                </label>
                                <?PHP
                                $k++;
                            }
                        }
                        ?>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="col-sm-6 input-inline ">Credit Rating Recommended :</label>
                        <div class="input-group col-sm-6 ">
                            <input type="text" name="credit_price" class="form-control" id="credit_price" placeholder="Credit" value="<?PHP echo $cus['credit_price']; ?>">
                            <div class="input-group-addon">Baht</div>
                        </div>
                        <label class="col-sm-6 input-inline ">Payment Term :</label>
                        <div class="input-group col-sm-6 ">
                            <input type="text" name="pay_term" class="form-control" id="" placeholder="Tearm" value="<?PHP echo $cus['pay_term']; ?>">
                            <div class="input-group-addon">Day</div>
                        </div>
                        <label class="col-sm-6 input-inline ">Payment channel :</label>
                        <div class="input-group col-sm-6 ">
                            <input type="text" name="pay_channel" class="form-control" id="" placeholder="" value="<?PHP echo $cus['pay_channel']; ?>">
                        </div>
                        <label class="col-sm-6 input-inline text-danger">Status :</label>
                        <div class="input-group col-sm-6 ">
                            <select name="status" class="form-control">
                                <?PHP if ($cus['status'] == 0) { ?><option value="0">:: Change Status ::</option><?PHP } ?>
                                <option value="1" <?PHP
                                if ($cus['status'] == 1) {
                                    echo 'selected';
                                }
                                ?>>Approve</option>
                                <option value="2" <?PHP
                                if ($cus['status'] == 2) {
                                    echo 'selected';
                                }
                                ?>>Reject</option>
                            </select>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-12">
                        <button class="btn btn-info" type="submit"><i class="fa fa-check"></i> Save</button>
                        <button class="btn btn-default" type="reset"><i class="fa fa-times"></i> Cancel</button>
                    </div>
                </div>
                <input type="hidden" id="zone_id" value="<?PHP echo $cus['zone_id']; ?>">
                <input type="hidden" name="link_url" id="link_url" value="<?PHP echo base_url('sitecontrol/customer/member_name'); ?>">
                </form>
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