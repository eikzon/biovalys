<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <h1><i class="fa fa-list-alt fa-lg"></i> Sales Order</h1>
        <ol class="breadcrumb">
            <li><a href="#"> Home</a>
            </li>
            <li>
                <a href="#">Sales Order</a>
            </li>
            <li class="active">Sales Order Add For CN</li>
        </ol>
    </div>
    <div class="col-xs-12">
        <div class="box">
            <h4 class="box-title">Sales Order Add For CN</h4>

            <hr>
            <div class="col-xs-12">
                <?php echo form_open(base_url('sitecontrol/order/insert_for_cn')); ?>
                <div class="row">
                    <div class="form-group col-sm-6">
                        <?php
                        echo form_label('CA List <span style="color: red;">*</span>');
                        $customer_data = array('' => 'Select CA');
                        if (count(@$customer) > 0) {
                            foreach ($customer as $rs_cus) {
                                $customer_data[$rs_cus['customer_id']] = $rs_cus['customer_name'];
                            }
                        }
                        echo form_dropdown('FK_customer_id', $customer_data, '', 'class="selectpicker FK_customer_id" data-width="100%" data-live-search="true" required  style="position:absolute; top:55px; width:1px; height:1px; display:inline-block !important; opacity:0; "');
                        echo form_input(array(
                            'type' => 'hidden',
                            'name' => 'FK_zone_id',
                            'class' => 'FK_zone_id'
                        ));
                        ?>
                    </div>
                    <div class="form-group col-sm-6">
                        <?php
                        echo form_label('SO for CN <span style="color: red;">*</span>');
                        $customer_data = array('' => 'Select SO for CN');
                        echo form_dropdown('so_for_cn[]', $customer_data, '0', 'id="so_for_cn" class="so_for_cn selectpicker" multiple data-actions-box="true" data-width="100%" data-live-search="true" required  style="position:absolute; top:55px; width:1px; height:1px; display:inline-block !important; opacity:0; "');
                        ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-6">
                        <?php
                        echo form_label('Date <span style="color: red;">*</span>');
                        echo form_input(array(
                            'name' => 'order_date',
                            'class' => 'form-control datepicker',
                            'required' => 'required',
                        ));
                        ?>
                    </div>
                    <div class="form-group col-sm-6">
                        <?php
                        echo form_label('Sales Name <span style="color: red;">*</span>');
                        $member_data = array('' => 'Select Sales');
                        if (count(@$member) > 0) {
                            foreach ($member as $rs_mem) {
                                $member_data[$rs_mem['member_id']] = $rs_mem['member_name'];
                            }
                        }

                        echo form_dropdown('FK_member_id', $member_data, '', 'class="selectpicker" data-width="100%" data-live-search="true" required  style="position:absolute; top:55px; width:1px; height:1px; display:inline-block !important; opacity:0; "');
                        ?>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-6">
                        <?php
                        echo form_label('เลขที่ใบกำกับภาษี <span style="color: red;">*</span>');
                        echo form_input(array(
                            'class' => 'form-control customer_taxid onlyint',
                            'name' => 'customer_taxid',
                            'required' => 'required',
                            'maxlength' => '13'
                        ));
                        ?>
                    </div>
                    <div class="form-group col-sm-6">
                        <?php
                        echo form_label('ส่วนสินค้าวันที่ <span style="color: red;">*</span>');
                        echo form_input(array(
                            'class' => 'form-control datepicker',
                            'name' => 'date_delivery',
                            'required' => 'required',
                        ));
                        ?>
                    </div>
                    <div class="form-group col-sm-6">
                        <?php
                        echo form_label('เวลารับสินค้าที่เหมาะสม <span style="color: red;">*</span>');
                        echo '<div class="input-group col-sm-12 ">';
                            echo form_input(array(
                                'class' => 'form-control',
                                'name' => 'date_receipt',
                                'required' => 'required',
                            ));
                        ?>
                            <div class="input-group-addon">น.</div>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <?php
                        echo form_label('สถานที่รับสินค้า <span style="color: red;">*</span>');
                        echo form_input(array(
                            'class' => 'form-control customer_delivery',
                            'name' => 'customer_delivery',
                            'required' => 'required',
                        ));
                        ?>
                    </div>
                    <div class="form-group col-sm-12">
                        <?php
                        echo form_label('Remark');
                        echo form_textarea(array(
                            'class' => 'form-control',
                            'name' => 'order_remark',
                            'rows' => '4',
                        ));
                        ?>
                    </div>
                    <div class="clearfix"></div>
                    <hr/>
                    <div class="form-group col-sm-12"><h4>Product List <span style="color: red;">*</span></h4></div>
                    <div class="form-group col-sm-12 product-form hide">
                        <div class="form-group col-sm-3">
                            <?php
                            echo form_label('Type Order');
                            $type_data = array(
                                'so' => 'Sale Order',
//                                'foc' => 'F.O.C',
//                                'lo' => 'Borrow - Returns',
                            );
                            echo form_dropdown('', $type_data, '', 'class="selectpicker product_type" data-width="100%"');
                            ?>
                        </div>
                        <div class="form-group col-sm-3">
                            <?php
                            echo form_label('Product');
                            $product_data = array('' => 'Select Product');
                            if (count(@$product) > 0) {
                                foreach ($product as $rs_prod) {
                                    $product_data[$rs_prod['id']] = $rs_prod['name'];
                                }
                            }
                            echo form_dropdown('', $product_data, '', 'class="selectpicker product_id" data-width="100%" data-live-search="true"');
                            ?>
                        </div>
                        <div class="form-group col-sm-2">
                            <?php
                            echo form_label('Quatity');
                            echo form_input(array(
                                'class' => 'form-control product_qty ',
                                'placeholder' => 'Quatity',
                            ));
                            ?>
                        </div>
                        <div class="form-group col-sm-2">
                            <?php
                            echo form_label('Price/Unit');
                            echo '<div class="input-group col-sm-12 ">';
                                echo form_input(array(
                                    'class' => 'form-control product_price onlynumber',
                                    'placeholder' => 'Price/Unit(Baht)',
                                ));
                            ?>
                                <div class="input-group-addon">Baht</div>
                            </div>
                        </div>
                        <div class="form-group col-sm-2">
                            <?php
                            echo form_button(array(
                                'type' => 'button',
                                'class' => 'btn btn-success product-add',
                                'content' => '<i class="fa fa-plus-circle"></i> Add Product',
                                'disabled' => 'disabled',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <table class="table table-bordered order-item">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%"></th>
                                <th class="text-center" width="10%">Code</th>
                                <th class="text-center" width="30%">Product</th>
                                <th class="text-center" width="10%">Quantity</th>
                                <th class="text-center" width="10%">Price/Unit<br>(Baht)</th>
                                <th class="text-center" width="10%">Free</th>
                                <th class="text-center" width="20%">Total<br>(Baht)</th>
                            </tr>
                        </thead>
                        <tbody class="order-product-list">
                            <?php
                            $alltotal = 0;
                            if ($this->session->userdata('order_add_admin')) {
                                foreach ($this->session->userdata('order_add_admin') as $key_detail => $rs_detail) {
                                    $detail_product = $order->data_product($rs_detail['pid']);
                                    if ($rs_detail['type'] == 'so') {
                                        $free = (!empty($detail_product['free_id'])) ? floor($rs_detail['qty'] / $detail_product['qty_free']) * $detail_product['free'] : 0;
                                        $total = ($rs_detail['qty'] * $rs_detail['price']);
                                        $subtotal = $total;
                                        $alltotal += $subtotal;
                                    } else if ($rs_detail['type'] == 'lo') {
                                        $free = (!empty($detail_product['free_id'])) ? floor($rs_detail['qty'] / $detail_product['qty_free']) * $detail_product['free'] : 0;
                                        $total = ($rs_detail['qty'] * $rs_detail['price']);
                                        $free = 'Borrow';
                                        $subtotal = $total;
                                        $alltotal += $subtotal;
                                    } else {
                                        $free = $total = $free = $subtotal = 'F.O.C';
                                    }
                                    echo '
                                            <tr>
                                                <td class="text-center"><a style="cursor: pointer;"><i class="fa fa-trash-o fa-lg text-danger" data-content="type=' . $rs_detail['type'] . '&pid=' . $detail_product['product_id'] . '" data-url="' . base_url('sitecontrol/order/del_product') . '"> </i></a></td>
                                                <td class="text-center">' . @$detail_product['product_code'] . '</td>
                                                <td class="text-center">' . @$detail_product['product_name'] . '</td>
                                                <td class="text-center">' . number_format($rs_detail['qty']) . '</td>
                                                <td class="text-center">' . number_format($rs_detail['price'], 2) . '</td>
                                                <td class="text-center">' . $free . '</td>
                                                <td class="text-center">' . (($rs_detail['type'] == 'foc') ? $subtotal : number_format($subtotal, 2)) . '</td>
                                            </tr>
                                        ';
                                }
                            } else {
                                echo '<tr><td colspan="8" class="text-center">No data</td></tr>';
                            }
                            ?>

                        </tbody>
                    </table>
                    <div class="form-group col-sm-6"></div>
                    <div class="form-group col-sm-5 col-sm-offset-1">
                        <?php
                        $befortotal = ($alltotal * 100) / 107;
                        $vat = $alltotal - $befortotal;
                        ?>
                        <label class="col-xs-4 input-inline">Discount :</label>
                        <div class="input-group col-sm-8 ">
                            <input class="form-control onlyint discount" name="discount"/>
                            <div class="input-group-addon">%</div>
                        </div>
                        
                        <label class="col-xs-4 input-inline">Total Price :</label>
                        <p class="col-xs-8 price-text"><span class="total_price"><?php echo number_format($befortotal, 2); ?></span> Baht</p>
                        
                        <label class="col-xs-4 input-inline">Vat (7%) :</label>
                        <p class="col-xs-8 price-text"><span class="vat"><?php echo number_format($vat, 2); ?></span> Baht</p>
                        
                        <label class="col-xs-6 input-inline">Rebate Normal (-) :</label>
                        <P class="col-xs-6 price-text"><span class="normal">0.00</span> Baht</P>
                        
                        <label class="col-xs-6 input-inline">Rebate Extra(S) (-) :</label>
                        <P class="col-xs-6 price-text"><span class="extra_s">0.00</span> Baht</P>
                        
                        <label class="col-xs-6 input-inline">Rebate Extra(TD) (-) :</label>
                        <P class="col-xs-6 price-text"><span class="extra_td">0.00</span> Baht</P>    
                        
                        <label class="col-xs-4 input-inline">Grand Total :</label>
                        <p class="col-xs-8 price-text-total"><span class="grand_price"><?php echo number_format($alltotal, 2); ?></span> Baht</p>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <div class="form-group col-sm-12">
                        <input type="hidden" name="re_normal" class="re_normal"/>
                        <input type="hidden" name="re_ext_s" class="re_ext_s"/>
                        <input type="hidden" name="re_ext_td" class="re_ext_td"/>
                        <button class="btn btn-info save_order" type="submit" <?php echo ($this->session->userdata('order_add_admin')) ? '' : 'disabled'; ?>><i class="fa fa-check"></i> Save</button>
                        <button class="btn btn-default" type="reset"><i class="fa fa-times"></i> Cancel</button>
                    </div>

                </div>
                <?php echo form_close(); ?>
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
<script>
    if ($('.FK_customer_id').val() != '') {
        $('.product-form').addClass('show').removeClass('hide');
    }
    $('.product_id, .product_qty, .product_price').bind('change keyup', function () {
        if ($('.product_id').val() && $('.product_qty').val() && /[0-9]/.test($('.product_qty').val()) && $('.product_price').val()) {
            $('.product-add').prop('disabled', '');
        } else {
            $('.product-add').prop('disabled', 'disabled');
        }
    });
    $('.product_id, .FK_customer_id').change(function () {
        var cus = 0;
        if(this.name == 'FK_customer_id'){
            cus = 1;
        }
        $.ajax({
            url: '<?php echo base_url('sitecontrol/order/price_product'); ?>',
            global: false,
            type: "POST",
            data: "pid=" + $('.product_id').val() + "&cid=" + $('.FK_customer_id').val()+"&cus="+cus,
            dataType: "html",
            async: false,
            success: function (data) {
                var data = data.split('##');
                $('.product_price').val(data[0]);
                if(data[1] == 1){
                    $('.product_price').prop('disabled', true);
                }else{
                    $('.product_price').prop('disabled', false);
                }
                $('.order-product-list').html(data[2]);
                $('.total_price').html(data[3]);
                $('.vat').html(data[4]);
                $('.grand_price').html(data[5]);
            }
        });
    });

    $('.FK_customer_id').change(function () {
        if (this.value == "") {
            $('.product-form').addClass('hide').removeClass('show');
        } else {
            $('.product-form').addClass('show').removeClass('hide');
            $.ajax({
                url: '<?php echo base_url('sitecontrol/order/detail_customer'); ?>',
                global: false,
                type: "POST",
                data: "pid=" + $('.product_id').val() + "&cid=" + $('.FK_customer_id').val(),
                dataType: "html",
                async: false,
                success: function (data) {
                    var data = data.split('##');
                    $('.customer_taxid').val(data[0]);
                    $('.FK_zone_id').val(data[1]);
                    $('.re_normal').val(data[2]);
                    $('.re_ext_s').val(data[3]);
                    $('.re_ext_td').val(data[4]);
                }
            });
        }
    });
    $('.FK_customer_id').change(function () {
        if (this.value == "") {
            $('.product-form').addClass('hide').removeClass('show');
        } else {
            $('.product-form').addClass('show').removeClass('hide');
            $.ajax({
                url: '<?php echo base_url('sitecontrol/order/detail_customer'); ?>',
                global: false,
                type: "POST",
                data: "pid=" + $('.product_id').val() + "&cid=" + $('.FK_customer_id').val(),
                dataType: "html",
                async: false,
                success: function (data) {
                    var data = data.split('##');
                    $('.customer_taxid').val(data[0]);
                    $('.FK_zone_id').val(data[1]);
                    $('.re_normal').val(data[2]);
                    $('.re_ext_s').val(data[3]);
                    $('.re_ext_td').val(data[4]);
                }
            });
        }
    });
    
    $('.FK_customer_id').change(function () {
        if (this.value != "") {
            $.ajax({
                url: '<?php echo base_url('sitecontrol/order/cn_list'); ?>',
                global: false,
                type: "POST",
                data: "cid=" + $('.FK_customer_id').val(),
                dataType: "html",
                async: false,
                success: function (data) {
                    $('#so_for_cn').html(data).selectpicker('refresh');
                }
            });
        }
    });

    $('.product-add').click(function () {
        if (confirm('You want add product?')) {
            var type = $('.product_type').val();
            var pid = $('.product_id').val();
            var qty = $('.product_qty').val();
            var price = $('.product_price').val();
            var discount = $('.discount').val();
            var cus = $('.FK_customer_id').val();
            var content = 'pid=' + pid + '&qty=' + qty + '&price=' + price + '&discount=' + discount + '&type=' + type+'&cus='+cus;
            $.ajax({
                url: '<?php echo base_url('sitecontrol/order/add_product'); ?>',
                global: false,
                type: "POST",
                data: content,
                dataType: "html",
                async: false,
                success: function (data) {
                    $('.product_price').prop('disabled', 'disabled');
                    var data = data.split('##');
                    $('.order-product-list').html(data[0]);
                    $('.total_price').html(data[1]);
                    $('.vat').html(data[2]);
                    $('.grand_price').html(data[3]);
                    if (data[4] == 1) {
                        $('.save_order').prop('disabled', 'disabled');
                    } else {
                        $('.save_order').prop('disabled', '');
                    }
                    $('.normal').html(data[5]);
                    $('.extra_s').html(data[6]);
                    $('.extra_td').html(data[7]);
                }
            });
        }
    });

    $('body').delegate(".fa-trash-o","click",function () {
        if (confirm('You want delete product?')) {
            $.ajax({
                url: $(this).data('url'),
                global: false,
                type: "POST",
                data: $(this).data('content')+'&cus='+$('.FK_customer_id').val(),
                dataType: "html",
                async: false,
                success: function (data) {
                    var data = data.split('##');
                    $('.order-product-list').html(data[0]);
                    $('.total_price').html(data[1]);
                    $('.vat').html(data[2]);
                    $('.grand_price').html(data[3]);
                    if (data[4] == 1) {
                        $('.save_order').prop('disabled', 'disabled')
                    } else {
                        $('.save_order').prop('disabled', '')
                    }
                }
            });
        }
    });
    
    $('.discount').keyup(function(){
        $.ajax({
            url: '<?php echo base_url('sitecontrol/order/change_discount'); ?>',
            global: false,
            type: "POST",
            data: "discount="+this.value+"&cus="+$('.FK_customer_id').val(),
            dataType: "html",
            async: false,
            success: function (data) {
                var data = data.split('##');
                $('.order-product-list').html(data[0]);
                $('.total_price').html(data[1]);
                $('.vat').html(data[2]);
                $('.grand_price').html(data[3]);
                if (data[4] == 1) {
                    $('.save_order').prop('disabled', 'disabled')
                } else {
                    $('.save_order').prop('disabled', '')
                }
            }
        });
    });
</script>