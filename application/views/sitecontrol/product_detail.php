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
                <div class="row">
                    <div class="form-group col-sm-6 text-center">
                        <img src="<?PHP echo $pro['pro_picture']; ?>" class="avatar" id="pics" alt="avatar" width="200">
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Code</label> : <?PHP echo $pro['pro_code']; ?>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Name</label> : <?PHP echo $pro['pro_name']; ?>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Rebate</label> : <?PHP echo ($pro['product_type_rebate'] > 0)?(($pro['product_type_rebate'] == 1)?'Extra (S)':'Extra (TD)'):'-'; ?>
                    </div>
                    <div class="form-group col-sm-12">
                        <label>Detail</label>
                        <br>
                        <?PHP echo $pro['pro_detail']; ?>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <div class="form-group col-sm-12">
                        <button class="btn btn-default" type="button" onclick="javascript:window.location.href = '<?PHP echo base_url("sitecontrol/product"); ?>'"><i class="fa fa-arrow-left"></i> กลับ</button>
                    </div>

                </div>
                <input type="hidden" name="action" id="action" value="add">
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