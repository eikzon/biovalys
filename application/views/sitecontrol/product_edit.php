<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <h1><i class="fa fa-cubes fa-lg"></i> Product</h1>
        <ol class="breadcrumb">
            <li><a href="<?PHP echo base_url('sitecontrol') ?>"> Home</a>
            </li>
            <li>
                <a href="<?PHP echo base_url('sitecontrol/product') ?>">Product</a>
            </li>
            <li class="active">Product Add</li>
        </ol>
    </div>
    <div class="col-xs-12">
        <div class="box">
            <h4 class="box-title">Product</h4>
            <hr>
            <?PHP
            if (isset($product)) {
                foreach ($product as $pro)
                    ;
            }
            ?>
            <div class="col-xs-12">
                <?PHP echo form_open_multipart('sitecontrol/product/update/' . $this->uri->segment(4), 'onsubmit="return form_product()"'); ?>
                <div class="row">
                    <div class="col-sm-6 text-center">
                        <img src="<?PHP echo $pro['pro_picture']; ?>" class="avatar" id="pics" alt="avatar" width="200" height="143">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Picture</label>
                        <input type="file" name="picture" id="file_image" class="form-control" placeholder="">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Rebate Type</label>
                        <select name="rebate" id="rebate" class="form-control selectpicker">
                            <option value="0" <?PHP echo ($pro['product_type_rebate'] == 0)?'selected':''; ?>>None</option>
                            <option value="1" <?PHP echo ($pro['product_type_rebate'] == 1)?'selected':''; ?>>Extra (S)</option>
                            <option value="2" <?PHP echo ($pro['product_type_rebate'] == 2)?'selected':''; ?>>Extra (TD)</option>
                        </select>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-6">
                        <label>Code <span style="color:red">*</span></label>
                        <input type="text" name="pro_code" id="pro_code" class="form-control" placeholder="Product Code" value="<?PHP echo $pro['pro_code']; ?>" required>
                        <span id="text_pro_code" style="color:red"><br>กรุณาระบุรหัสสินค้า</span>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Name <span style="color:red">* , ตัวอักษรยกให้ใช้ &lt;sup&gt;&lt;/sup&gt; เช่น &lt;sup&gt;TM&lt;/sup&gt;</span></label>
                        <input type="text" name="pro_name" id="pro_name" class="form-control" placeholder="Product Name" value="<?PHP echo $pro['pro_name']; ?>" required>
                        <span id="text_pro_name" style="color:red"><br>กรุณาระบุชื่อสินค้า</span>
                    </div>
                    <!--                    <div class="form-group col-sm-6">
                                            <label>Price <span style="color:red">*</span></label>
                                            <input type="text" name="pro_price" id="pro_price" class="form-control" placeholder="Product Price" value="<?PHP echo $pro['pro_price']; ?>" required>
                                            <input type="hidden" name="pro_oldprice" id="pro_oldprice" value="<?PHP echo $pro['pro_price']; ?>">
                                            <span id="text_pro_price" style="color:red"><br>กรุณาระบุราคากลาง</span>
                                        </div>-->
                    <div class="form-group col-sm-12">
                        <label>Detail</label>
                        <textarea name="pro_detail" id="pro_detail" class="form-control"><?PHP echo $pro['pro_detail']; ?></textarea>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <div class="form-group col-sm-12">
                        <button class="btn btn-info" type="submit"><i class="fa fa-check"></i> Save</button>
                        <button class="btn btn-default" type="reset"><i class="fa fa-times"></i> Cancel</button>
                    </div>

                </div>
                <input type="hidden" name="action" id="action" value="add">
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