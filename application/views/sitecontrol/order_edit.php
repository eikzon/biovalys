<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <h1><i class="fa fa-list-alt fa-lg"></i> Sales Order</h1>
        <ol class="breadcrumb">
            <li><a href="#"> Home</a></li>
            <li><a href="<?PHP echo base_url('sitecontrol/order'); ?>">Sales Order</a></li>
            <li class="active">Sales Order Edit</li>
        </ol>
    </div>
    <div class="col-xs-12">
        <div class="box">
            <h4 class="box-title col-xs-6">Sales Order Edit (<?PHP echo $customer['c_code']; ?>)</h4>
            <div class="col-xs-6 text-right">
                <?php
                if ($customer['c_approve'] == 1) {
                    if ($this->uri->segment(4) == 'foc') {
                        echo form_button(array(
                            'type' => 'button',
                            'class' => 'btn btn-info',
                            'content' => '<i class="fa fa-print"></i> FOC</button>',
                            'onclick' => 'window.open(\'' . base_url('sitecontrol/order/print_foc/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '') . '\')'
                        ));
                    }
                    if ($this->uri->segment(4) == 'so') {
                        echo form_button(array(
                            'type' => 'button',
                            'class' => 'btn btn-success',
                            'content' => '<i class="fa fa-print"></i> ORDER</button>',
                            'onclick' => 'window.open(\'' . base_url('sitecontrol/order/print_so/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '') . '\')'
                        ));
                    }
                    if ($this->uri->segment(4) == 'lo') {
                        echo form_button(array(
                            'type' => 'button',
                            'class' => 'btn btn-warning',
                            'content' => '<i class="fa fa-print"></i> BORROW</button>',
                            'onclick' => 'window.open(\'' . base_url('sitecontrol/order/print_lo/' . $this->uri->segment(4) . '/' . $this->uri->segment(5) . '') . '\')'
                        ));
                    }
                } else
                if ($customer['c_approve'] == 0) {
                    echo '<h4 class="text-danger"><b>Not Approve</b></h4>';
                }
                ?>
            </div>
            <div class="clearfix"></div>
            <hr>
            <div class="col-xs-12">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>CA List :</label>
                        <input type="text" value="<?PHP echo $customer['customer_name']; ?>" class="form-control" disabled>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Represent Name :</label>
                        <input type="text" class="form-control" value="<?PHP echo $customer['member_name']; ?>" disabled>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Create Date :</label>
                        <input type="text" class="form-control" value="<?PHP echo date('d/m/Y H:s', strtotime($customer['order_date_create'])); ?>" disabled>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Tax ID :</label>
                        <input type="text" class="form-control" value="<?PHP echo $customer['customer_taxid']; ?>" disabled>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Delivery Date :</label>
                        <input type="text" class="form-control" value="<?PHP echo date('d/m/Y ', strtotime(@$customer['order_date_delivery'])); ?>" disabled>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Time of receipt :</label>
                        <input type="text" class="form-control" value="<?PHP echo $customer['order_contact_date']; ?>" disabled>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Contact Name :</label>
                        <input type="text" class="form-control" value="<?PHP echo $customer['order_contact_name']; ?>" disabled>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Contact Department :</label>
                        <input type="text" class="form-control" value="<?PHP echo $customer['order_contact_dep']; ?>" disabled>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Contact Phone :</label>
                        <input type="text" class="form-control" value="<?PHP echo $customer['order_contact_tel']; ?>" disabled>
                    </div>
                    <div class="form-group col-sm-6">
                        <label>Card Tear :</label>
                        <input type="text" class="form-control" value="<?PHP echo $customer['order_card_tear']; ?>" disabled>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <table class="table table-bordered order-item">
                        <thead>
                            <tr>
                                <th class="text-center" width="10%">Code</th>
                                <th class="text-center" width="35%">Product</th>
                                <th class="text-center" width="10%">Quantity</th>
                                <th class="text-center" width="15%">Price/Unit<br>(Baht)</th>
                                <th class="text-center" width="15%">Free</th>
                                <th class="text-center" width="15%">Total<br>(Baht)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?PHP
                            $total = $extra_s = $extra_td = 0;
                            $level = $this->session->userdata('level');
                            if (isset($detail) && !empty($detail)) {
                                $table = '';
                                $total = $default = 0;
                                foreach ($detail as $rs) {
                                    if ($rs['product_type_rebate'] == 1 && $rs['order_rebate_extra_s'] > 0) {
                                        $extra_s += (($rs['d_subtotal'] * $rs['order_rebate_extra_s']) / 100);
                                    }
                                    if ($rs['product_type_rebate'] == 2 && $rs['order_rebate_extra_td'] > 0) {
                                        $extra_td += (($rs['d_subtotal'] * $rs['order_rebate_extra_td']) / 100);
                                    }
                                    $prod = ($rs['product_id'] <> 0) ? $rs['product_name'] : $rs['item_name'];
//                                    $price = ($this->uri->segment(4) == "so")?number_format($rs['d_price'], 2):(($this->uri->segment(4) == "foc")?'F.O.C':'-');
//                                    $ptotal = ($this->uri->segment(4) == "so")?number_format($rs['d_subtotal'], 2):(($this->uri->segment(4) == "foc")?'F.O.C':'-');
                                    $table .= '
                                        <tr>
                                            <td class="text-center">' . $rs['product_code'] . '</td>
                                            <td class="text-center">' . $prod . '</td>
                                            <td class="text-center">' . number_format($rs['d_qty']) . '</td>
                                            <td class="text-center">' . $rs['d_price'] . '</td>
                                            <td class="text-center">' . (($rs['d_free'] > 0) ? $rs['d_free'] : '-') . '</td>
                                            <td class="text-center">' . @$rs['d_subtotal'] . '</td>
                                        </tr>
                                        ';
                                    $total += ($rs['d_subtotal']);
                                    $default += $rs['d_qty'] * $rs['d_price'];
                                }
                                echo $table;
                            }
                            $disable = ($customer['c_approve'] == 1 && $level <> 1) ? 'disabled' : '';
                            ?>
                        </tbody>
                    </table>
                    <?PHP echo form_open('sitecontrol/order/update'); ?>
                    <?php if ($this->uri->segment(4) != 'foc') { ?>
                        <div class="form-group col-sm-6"></div>
                        <div class="form-group col-sm-5 col-sm-offset-1">
                            <?PHP
                            $befor = (($total * 100) / 107);
                            $vat = $total - $befor;
                            ?>
                            <label class="col-xs-6 input-inline"><?php echo ($customer['order_discount'] > 0) ? '( ' . $customer['order_discount'] . '% )' : ''; ?> Discount :</label>
                            <P class="col-xs-6 price-text text-price"><?PHP echo ($customer['order_discount'] > 0) ? number_format(($default - $total), 2) : '0.00'; ?> Baht</P>
                            <label class="col-xs-6 input-inline">Sub Total :</label>
                            <P class="col-xs-6 price-text text-price"><?PHP echo number_format($befor, 2); ?> Baht</P>
                            <label class="col-xs-6 input-inline">Vat (7%) :</label>
                            <P class="col-xs-6 price-text text-vat"><?PHP echo number_format($vat, 2) ?> Baht</P>
                            <label class="col-xs-6 input-inline">Total Price:</label>
                            <P class="col-xs-6 price-text text-price"><?PHP echo number_format($total, 2); ?> Baht</P>
                            <?php // if($customer['order_rebate_normal'] > 0){?>
                            <label class="col-xs-6 input-inline">Rebate Normal (-) :</label>
                            <P class="col-xs-6 price-text"><?PHP echo number_format((($total * $customer['order_rebate_normal']) / 100), 2); ?> Baht</P>
                            <?php // }?>
                            <?php // if($extra_s > 0){?>
                            <label class="col-xs-6 input-inline">Rebate Extra(S) (-) :</label>
                            <P class="col-xs-6 price-text"><?PHP echo number_format($extra_s, 2); ?> Baht</P>
                            <?php // }?>
                            <?php // if($extra_td > 0){?>
                            <label class="col-xs-6 input-inline">Rebate Extra(TD) (-) :</label>
                            <P class="col-xs-6 price-text"><?PHP echo number_format($extra_td, 2); ?> Baht</P>
                            <?php // }?>
                            <label class="col-xs-6 input-inline">Grand Price :</label>
                            <P class="col-xs-6 price-text-total text-total"><?PHP echo number_format(($total - (($total * $customer['order_rebate_normal']) / 100) - $extra_s - $extra_td), 2); ?> Baht</P>
                        </div>
                    <?php } ?>
                    <?PHP
                    if (isset($level) && !empty($level) && $level == 1) {
                        ?>
                        <div class="form-group col-sm-12">
                            <label>Comment</label>
                            <textarea class="form-control" rows="4" name="order_remark"><?PHP echo $customer['c_remark'] ?></textarea>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Status: </label>
                            <select name="order_approve" class="form-control selectpicker" <?PHP echo ($customer['customer_approve'] == 1) ? '' : 'disabled'; ?>>
                                <?PHP
                                print_r($customer['order_id']);
                                if (isset($status) && !empty($status)) {
                                    $stat = '';
                                    foreach ($status as $k => $v) {
                                        $select = ($k == $customer['c_approve'] && $customer['c_approve'] <> '') ? 'selected' : '';
                                        $stat .='<option value="' . $k . '" ' . $select . '>' . $v . '</option>';
                                    }
                                    echo $stat;
                                }
                                ?>
                            </select>
                            <?php if ($customer['customer_approve'] != 1) { ?>
                                <p><span style="color: red;">*** Customer not approve, <a href="<?php echo base_url('sitecontrol/customer'); ?>" onclick="return confirm('You want go to approve customer?');">Go to approve customer click</a></span></p>
                            <?php } ?>
                        </div>
                        <div class="form-group col-sm-6">
                            <?php
                            if ($customer['c_approve'] == 1 && $this->uri->segment(4) == 'so') {
                                echo '<label class="col-xs-12"> &nbsp; </label>';
                                echo form_button(array(
                                    'type' => 'button',
                                    'class' => 'btn btn-danger',
                                    'content' => ' CN',
                                    'onclick' => ''
                                ));
                            }
                            ?>
                        </div>
                        <?PHP
                    }
                    ?>
                    <div class="clearfix"></div>
                    <hr>
                    <div class="form-group col-sm-12">
                        <input type="hidden" name="order_id" value="<?PHP echo $customer['order_id']; ?>" >
                        <input type="hidden" name="type" value="<?PHP echo $this->uri->segment(4); ?>" >
                        <button class="btn btn-info" type="submit"><i class="fa fa-check"></i> Save</button>
                        <button class="btn btn-default" type="reset"><i class="fa fa-times"></i> Cancel</button>
                    </div>
                    <?PHP echo form_close() ?>
                </div>
            </div>
            <div class="clearfix"></div>
            <input type="hidden" id="control_page" value="<?PHP echo base_url(); ?>" >
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<!-- /.content-wrapper -->
<?PHP
// Gen Template
echo $temp['footer'];
?>