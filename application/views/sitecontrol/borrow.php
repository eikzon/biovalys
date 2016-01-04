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
            <!--<a class="btn btn-table-tool btn-info" data-toggle="tooltip" data-placement="top" title="Borrow" href="<?PHP echo base_url('sitecontrol/order/borrow'); ?>"> <i class="fa fa-plus"> </i> Borrow</a>-->
            <!--<br/>-->
            <p class="btn-table-tool"><b>total price :</b> <?PHP echo number_format($total_price['total'], 2); ?> ฿</p>
            <p class="btn-table-tool"><b>total price approve :</b> <?PHP echo number_format($total_price['approve'], 2); ?> ฿</p>
            <br/>
            <hr/>
            <div class="col-xs-12 filter-form">
                <?PHP echo form_open('sitecontrol/order/search'); ?>
                <div class="row">
                    <div class="form-group col-sm-2">
                        <label>CA List</label>
                        <input type="text" class="form-control" placeholder="CA List" name="customer" value="<?PHP echo $search['customer']; ?>">
                    </div>
                    <div class="form-group col-sm-2">
                        <label>Representname</label>
                        <input type="text" class="form-control" placeholder="Representative name" name="representative" value="<?PHP echo $search['representative']; ?>">
                    </div>
                    <div class="form-group col-sm-2">
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
                    <div class="form-group col-sm-2">
                        <label>Create Date</label>
                        <input type="text" class="form-control datepicker" placeholder="Create Date" name="date" value="<?PHP echo $search['date']; ?>">
                    </div>
                    <div class="form-group col-sm-2">
                        <label>Sales Name</label>
                        <input type="text" class="form-control" placeholder="Create Date" name="sale" value="<?PHP echo $search['sale']; ?>">
                    </div>
                    <div class="form-group col-sm-2">
                        <button type="submit" class="btn btn-default btn-search pull-left" style="margin-right:10px;"><i class="fa fa-search"></i> Search</button>
                        <?PHP if ($search['customer'] || $search['representative'] || $search['stat'] || $search['sale'] || $search['date']) { ?>
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
                            $total_data = $model->order_total_price($rs['order_id']);
                            $status_data = $model->order_show_status($rs['order_approve']);
                            ?>
                            <tr id="row_<?PHP echo $rs['order_id']; ?>">
                                <td class="text-center"><?PHP echo $num++; ?></td>
                                <td class="text-center"><?PHP echo $rs['order_number']; ?></td>
                                <td><?PHP echo $rs['customer_name']; ?></td>
                                <td><?PHP echo $rs['customer_represent_name']; ?></td>
                                <td><?PHP echo $rs['member_name']; ?></td>
                                <td><?PHP echo date('d/m/Y', strtotime($rs['order_create_date'])); ?></td>
                                <td><?PHP echo number_format($total_data, 2); ?></td>
                                <td><?PHP echo $status_data; ?></td>
                                <td class="text-center">
                                    <a href="<?PHP echo base_url('sitecontrol/order/edit/' . $rs['order_id']); ?>" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square fa-lg"></i></a>
                                    <a href="#" onclick="del_admin(<?PHP echo $rs['order_id']; ?>, '<?PHP echo base_url('sitecontrol/order/delete/'); ?>', '<i class=\'fa fa-exclamation-triangle text-danger\'></i> Delete ', 'Are you Delete This Order ?')"><i class="fa fa-trash-o fa-lg" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
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