<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="col-xs-8">
            <h1><i class="fa fa-list-alt fa-lg"></i> Sales order</h1>
            <ol class="breadcrumb">
                <li><a href="#"> Home</a>
                </li>
                <li class="active">Sales-order</li>
            </ol>
        </div>
        <div class="col-xs-4 text-right"><h1>All List : <?PHP echo number_format($total); ?> Order</h1></div>
    </div>
    <div class="col-xs-12">
        <div class="box">
            <h4 class="box-title">Sales order </h4>
            <!--
            <button class="btn btn-table-tool btn-default" data-toggle="tooltip" data-placement="top" title="Export"> <i class="fa fa-share-square-o"> </i> Export Data</button>
            <button class="btn btn-table-tool btn-warning" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="fa fa-pencil-square-o"> </i> Edit Data
            </button>
            -->
            <!--                    <p class="btn-table-tool"><b>total :</b> <?PHP echo $total; ?> order</p>-->
            <a class="btn btn-table-tool btn-info" data-toggle="tooltip" data-placement="top" title="Borrow" href="<?PHP echo base_url('sitecontrol/order/add'); ?>"> <i class="fa fa-plus"> </i> Add Order</a>
            <br/>
            <p class="btn-table-tool"><b>total price :</b> <?PHP echo number_format($total_price['total'], 2); ?> ฿</p>
            <p class="btn-table-tool"><b>total price approve :</b> <?PHP echo number_format($total_price['approve'], 2); ?> ฿</p>
            <!--<br/>-->
            <hr/>
            <div class="col-xs-12 filter-form">
                <?PHP echo form_open('sitecontrol/order/search'); ?>
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label>CA List</label>
                        <input type="text" class="form-control" placeholder="CA List" name="customer" value="<?PHP echo $search['customer']; ?>">
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Representname</label>
                        <input type="text" class="form-control" placeholder="Representative name" name="representative" value="<?PHP echo $search['representative']; ?>">
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Create Date</label>
                        <input type="text" class="form-control datepicker" placeholder="Create Date" name="date" value="<?PHP echo $search['date']; ?>">
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Sales Name</label>
                        <input type="text" class="form-control" placeholder="Create Date" name="sale" value="<?PHP echo $search['sale']; ?>">
                    </div>
                    <div class="form-group col-sm-3">
                        <label>Status</label>
                        <select class="selectpicker" data-width="100%" name="stat">
                            <option value="">Select All</option>
                            <?PHP
                            if (isset($status) && !empty($status)) {
                                foreach ($status as $dv => $dk) {
                                    $select = ($dv == $search['stat'] && $search['stat'] <> '') ? 'selected' : '';
                                    $op .='<option value="' . $dv . '" ' . $select . ' >' . $dk . '</option>';
                                }
                                echo $op;
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <?php 
                        echo form_label('Type');
                        $type_array = array('' => 'Select All');
                        $type_array[1] = 'Sale Order';
                        $type_array[2] = 'F.O.C';
                        $type_array[3] = 'Borrow - Returns';
                        echo form_dropdown('stype',$type_array,@$search['stype'],'class="selectpicker" data-width="100%"');
                        ?>
                    </div>
                    <div class="form-group col-sm-3">
                        <button type="submit" class="btn btn-default btn-search pull-left" style="margin-right:10px;"><i class="fa fa-search"></i> Search</button>
                        <?PHP if ($search['customer'] || $search['representative'] || $search['stat'] || $search['sale'] || $search['date'] || $search['stype']) { ?>
                            <a href="<?PHP echo base_url('sitecontrol/order/reset_search'); ?>" class="btn btn-default btn-search pull-left"><i class="fa fa-refresh"></i> Reset&nbsp;&nbsp;&nbsp;</a>
                        <?PHP } ?>
                    </div>
                </div>
                <?PHP echo form_close(); ?>
            </div>
            <div class="text-right col-xs-12"><?PHP echo $links; ?></div>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th class="text-center">No.</th>
                        <th class="text-center">Order ID</th>
                        <th>CA List</th>
                        <th>Representative name</th>
                        <th>Sales Name</th>
                        <th>Date</th>
                        <th>Total Price</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Tools</th>
                    </tr>
                </thead>
                <tbody>
                    <?PHP
                    if (isset($list) && !empty($list)) {
                        $num = ($this->uri->segment(4) > 1) ? $this->uri->segment(4) + 1 : 1;
                        foreach ($list as $rs) {
                            $total_data = ($rs["d_type"] == "foc")?'F.O.C':
                                (($rs["d_type"] == "lo")?number_format($model->order_total_price_lo($rs['d_oid']), 2):
                                    number_format($model->order_total_price_so($rs['d_oid']), 2));
                            $status_data = $model->order_show_status($rs['d_approve']);
                            ?>
                            <tr id="row_<?PHP echo $rs['d_oid']; ?>">
                                <td class="text-center row-click" data-url="<?PHP echo base_url('sitecontrol/order/edit/'.$rs['d_type'].'/' . $rs['d_oid']); ?>"><?PHP echo $num++; ?></td>
                                <td class="text-center row-click" data-url="<?PHP echo base_url('sitecontrol/order/edit/'.$rs['d_type'].'/' . $rs['d_oid']); ?>"><?PHP echo $rs['d_code']; ?></td>
                                <td class="row-click" data-url="<?PHP echo base_url('sitecontrol/order/edit/'.$rs['d_type'].'/' . $rs['d_oid']); ?>"><?PHP echo $rs['d_cusname']; ?></td>
                                <td class="row-click" data-url="<?PHP echo base_url('sitecontrol/order/edit/'.$rs['d_type'].'/' . $rs['d_oid']); ?>"><?PHP echo $rs['d_repname']; ?></td>
                                <td class="row-click" data-url="<?PHP echo base_url('sitecontrol/order/edit/'.$rs['d_type'].'/' . $rs['d_oid']); ?>"><?PHP echo $rs['d_memname']; ?></td>
                                <td class="row-click" data-url="<?PHP echo base_url('sitecontrol/order/edit/'.$rs['d_type'].'/' . $rs['d_oid']); ?>"><?PHP echo date('d/m/Y', strtotime($rs['d_date'])); ?></td>
                                <td class="text-center row-click" data-url="<?PHP echo base_url('sitecontrol/order/edit/'.$rs['d_type'].'/' . $rs['d_oid']); ?>"><?PHP echo $total_data; ?></td>
                                <td class="row-click" data-url="<?PHP echo base_url('sitecontrol/order/edit/'.$rs['d_type'].'/' . $rs['d_oid']); ?>"><?PHP echo $status_data; ?></td>
                                <td class="text-center">
                                    <a href="<?PHP echo base_url('sitecontrol/order/edit/'.$rs['d_type'].'/' . $rs['d_oid']); ?>" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square fa-lg"></i></a>
                                    <a href="#" onclick="del_admin(<?PHP echo $rs['d_oid']; ?>, '<?PHP echo base_url('sitecontrol/order/delete/'); ?>', '<i class=\'fa fa-exclamation-triangle text-danger\'></i> Delete ', 'Are you Delete This Order ?')"><i class="fa fa-trash-o fa-lg" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                                </td>
                            </tr>
                            <?PHP
                        }
                    } else {
                        echo '<tr><td colspan="9" class="text-center">--No Data--</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
            <div class="text-right col-xs-12"><?PHP echo $links; ?></div>
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
    $('.row-click').click(function(){
        window.location=$(this).data('url');
//        alert($(this).data('url'));
    });
</script>