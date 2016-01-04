<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <h1><i class="fa fa-users fa-lg"></i> Sale Member</h1>
        <ol class="breadcrumb">
            <li><a href="<?PHP echo base_url('sitecontrol') ?>"> Home</a>
            </li>
            <li>
                <a href="<?PHP echo base_url('sitecontrol/member') ?>">Sale Member</a>
            </li>
            <li class="active">Sale Member Add</li>
        </ol>
    </div>
    <div class="col-xs-12">
        <div class="box">
            <h4 class="box-title">Sale Member Add</h4>

            <hr>
            <?PHP
            if (isset($member)) {
                foreach ($member as $mem)
                    ;
            }
            ?>
            <div class="col-xs-12">
                <?PHP echo form_open_multipart('sitecontrol/member/update/' . $mem['id'], 'onsubmit="return form_member()"'); ?>
                <div class="row">
                    <?PHP // $pic = (is_file("assets/img/user/" . $mem['picture'])) ? base_url() . "assets/img/user/" . $mem['picture'] : base_url() . "assets_sitecontrol/img/default.jpg"; ?>
<!--                    <div class="form-group col-sm-6">
                        <img src="<?PHP echo $pic; ?>" class="avatar" id="pics" alt="avatar" width="200" height="200">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Picture</label>
                        <input type="file" name="picture" id="file_image" class="form-control" placeholder="">
                    </div>-->
                    <div class="form-group col-sm-6">
                        <label>Level <span style="color: red;">*</span></label>
                        <select name="level" id="level" class="selectpicker" data-width="100%" required data-live-search="true" required style="position:absolute; top:55px; width:1px; height:1px; display:inline-block !important; opacity:0; ">
                            <option value="">-- Please select level --</option>
                            <?PHP
                            if (isset($level)) {
                                foreach ($level as $lv) {
                                    ?>
                                    <option <?PHP echo ($mem['level'] == $lv['level_id']) ? 'selected' : ''; ?> value="<?PHP echo $lv['level_id']; ?>"><?PHP echo $lv['level_name']; ?></option>
                                    <?PHP
                                }
                            }
                            ?>
                        </select>
                        <span id="text_level" style="color:red"><br>กรุณาเลือกระดับสมาชิก</span>
                    </div>
<!--                    <div class="form-group col-sm-6">
                        <label>ID <span style="color:red">*</span></label>
                        <input type="text" name="mem_id" id="mem_id" class="form-control" placeholder="ID" value="<?PHP echo $mem['number'] ?>" required>
                        <span id="text_mem_id" style="color:red"><br>กรุณาระบุรหัสสมาชิก</span>
                    </div>-->
                    <div class="form-group col-sm-6">
                        <label>Name <span style="color:red">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="<?PHP echo $mem['name'] ?>" required>
                        <span id="text_name" style="color:red"><br>กรุณาระบุชื่อ-นามสกุล</span>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>E-mail <span style="color:red">*</span></label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" value="<?PHP echo $mem['email'] ?>" required>
                        <span id="text_email" style="color:red"><br>กรุณาระบุอีเมล์</span>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Address</label>
                        <input type="text" name="address" class="form-control" placeholder="Address" value="<?PHP echo $mem['address'] ?>" >
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Telephone <span style="color:red">*</span></label>
                        <input type="text" name="mobile" id="mobile" class="form-control" maxlength="10" placeholder="Mobile" value="<?PHP echo $mem['mobile'] ?>" required>
                        <span id="text_mobile" style="color:red"><br>กรุณาระบุเบอร์โทรศัพท์</span>
                        <span id="text_mobile_length" style="color:red"><br>คุณระบุเบอร์โทรศัพท์ไม่ครบ</span>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Username <span style="color:red">*</span></label>
                        <input type="text" name="username" class="form-control" placeholder="Username" readonly value="<?PHP echo $mem['username'] ?>" required>
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Password</label>
                        <input type="text" name="password" id="password" class="form-control" placeholder="Password">
                        <!--<span id="text_not_match" style="color:red"><br>รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน</span>-->
                    </div>
                    <div class="form-group col-sm-2">
                        <label>&nbsp;</label>
                        <button class="btn btn-default form-control" type="button" onclick="random_pass()"><i class="fa fa-repeat"></i> Random Password</button>
                    </div>
                    <!--<div class="form-group col-sm-6">
                        <label>Confirm password</label>
                        <input type="text" name="confirm_password" id="confirm_password" class="form-control" placeholder="Confirm Password">
                    </div>-->
                    <!-- ยังไม่ได้สร้าง DB รองรับ -->
                    <!--<div class="form-group col-sm-6">
                        <label>Select Zone</label>
                        <select multiple="multiple" id="my-select" name="my-select[]">
                    <?PHP
                    if (isset($zone_list)) {
                        foreach ($zone_list as $zone) {
                            $relate_zone = explode(",", $zone['FK_zone_id']);
                            ?>
                                                                                    <option value='<?PHP echo $zone['zone_id'] ?>' <?PHP
                            for ($i = 0; $i < count($relate_zone); $i++) {
                                if ($relate_zone[$i] == $zone['zone_id']) {
                                    echo "selected";
                                } else {
                                    echo "";
                                }
                            }
                            ?>><?PHP echo $zone['zone_name'] ?></option>
                            <?PHP
                        }
                    }
                    ?>
                        </select>
                    </div>-->
                    <div class="form-group col-sm-6">
                        <label>Zone</label>
                        <select name="zone_id" class="selectpicker" data-width="100%">
                            <option value="0">-- Select Zone --</option>
                            <?PHP
                            if (isset($zone_list)) {
                                foreach ($zone_list as $zone) {
                                    ?>
                                    <option <?PHP
                                    if ($mem['FK_zone_id'] == $zone['zone_id']) {
                                        echo "selected";
                                    } else {
                                        echo "";
                                    }
                                    ?> value="<?PHP echo $zone['zone_id']; ?>"><?PHP echo $zone['zone_code'] ?></option>
                                        <?PHP
                                    }
                                }
                                ?>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <div class="form-group col-sm-12">
                        <button class="btn btn-info" type="submit"><i class="fa fa-check"></i> Save</button>
                        <button class="btn btn-default" type="reset"><i class="fa fa-times"></i> Cancel</button>
                    </div>

                </div>
                <input type="hidden" name="action" id="action" value="edit">
                <?PHP echo form_close(); ?>
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