<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="col-xs-8">
            <h1><i class="fa fa-users fa-lg"></i> Sale Member</h1>
            <ol class="breadcrumb">
                <li><a href="<?PHP echo base_url('sitecontrol'); ?>"> Home</a>
                </li>
                <li class="active">Sale Member</li>
            </ol>
        </div>
        <div class="col-xs-4 text-right"><h1>All List : <?PHP echo number_format($total); ?> Member</h1></div>
    </div>
    <div class="col-xs-12">
        <div class="box">
            <h4 class="box-title">Sale Member Table</h4>
            <button class="btn btn-table-tool btn-default" data-toggle="tooltip" data-placement="top" title="Export" onclick="export_csv('<?PHP echo base_url("sitecontrol/member/export_csv"); ?>')"> <i class="fa fa-share-square-o"> </i> Export Data
            </button>
            <!--<button class="btn btn-table-tool btn-warning" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="fa fa-pencil-square-o"> </i> Edit Data
            </button>-->
            <a class="btn btn-table-tool btn-info" data-toggle="tooltip" data-placement="top" title="Add" href="<?PHP echo base_url('sitecontrol/member/add'); ?>"> <i class="fa fa-plus"> </i> Add New Data
            </a>
            <hr>
            <div class="col-xs-12 filter-form">
                <?PHP echo form_open('sitecontrol/member/search'); ?>
                <div class="row">
<!--                    <div class="form-group col-sm-2">
                        <label>Area Code</label>
                        <input type="text" name="sid" class="form-control" placeholder="Search Code" value="<?PHP echo $search['sid']; ?>">
                    </div>-->
                    <div class="form-group col-sm-3">
                        <label>Name</label>
                        <input type="text" name="sname" class="form-control" placeholder="Search Name" value="<?PHP echo $search['sname']; ?>">
                    </div>
                    <div class="form-group col-sm-3">
                        <label>E-mail</label>
                        <input type="text" name="semail" class="form-control" placeholder="Search E-mail" value="<?PHP echo $search['semail']; ?>">
                    </div>
                    <div class="form-group col-sm-2">
                        <label>Level</label>
                        <select name="slevel" class="form-control selectpicker">
                            <option value="">-- Select Level --</option>
                            <?PHP
                            if (isset($level)) {
                                foreach ($level as $lv) {
                                    ?>
                                    <option <?PHP echo ($search['slevel'] == $lv['level_id']) ? 'selected' : ''; ?> value="<?PHP echo $lv['level_id']; ?>"><?PHP echo $lv['level_name']; ?></option>
                                    <?PHP
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-2">
                        <button type="submit" class="btn btn-default btn-search"><i class="fa fa-search"></i> Search</button>
                        <?PHP if ($search['sid'] || $search['sname'] || $search['semail'] || $search['slevel']) { ?>
                            &nbsp;&nbsp;
                            <button type="button" class="btn btn-default btn-search" onclick="window.location = '<?PHP echo base_url("sitecontrol/member") ?>/refresh'"><i class="fa fa-refresh"></i> Show All</button>
                        <?PHP } ?>
                    </div>
                </div>
                <?PHP echo form_close(); ?>
            </div>
            <div class="text-right col-xs-12"><?PHP echo $links; ?></div>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No.</th>
                        <th class="text-center" width="10%">Level</th>
                        <th class="text-center" width="10%">Area</th>
                        <th width="10%">Name</th>
                        <th width="20%">Email</th>
                        <th class="text-center" width="10%">Status</th>
                        <th class="text-center" width="8%">Order</th>
                        <th class="text-center" width="8%">Approve</th>
                        <th class="text-center" width="8%">Reject</th>
                        <th width="8%">Tools</th>
                    </tr>
                </thead>
                <tbody>
                    <?PHP
                    if (!empty($member_list[0]) && isset($member_list[0])) {
                        $i = 1;
                        foreach ($member_list as $dw) {
                            $arr = array('FK_member_id' => $dw['id']);
                            $ordernum = $func->member_order($arr);
                            ?>
                            <tr id='row_<?PHP echo $dw['id']; ?>'>
                                <td class="text-center"><?PHP echo $i; ?></td>
                                <td class="text-center"><?PHP echo $dw['level']; ?></td>
                                <td class="text-center"><?PHP echo $dw['code']; ?></td>
                                <td><a href="<?PHP echo base_url('sitecontrol/order/sales/' . $dw['name']); ?>"><?PHP echo $dw['name']; ?></a></td>
                                <td><?PHP echo $dw['email']; ?></td>
                                <td>
                                    <select class="form-control selectpicker" name="status_member" data-id="<?PHP echo $dw['id']; ?>" onchange="status('<?PHP echo $dw['id'] ?>', this.value, '<?PHP echo base_url('sitecontrol/member/status'); ?>')">
                                        <option value="1" <?PHP
                                        if ($dw['status'] == 1) {
                                            echo 'selected';
                                        }
                                        ?>>ใช้งานปกติ</option>
                                        <option value="0" <?PHP
                                        if ($dw['status'] == 0) {
                                            echo 'selected';
                                        }
                                        ?>>ระงับการใช้งาน</option>
                                    </select>
                                </td>
                                <td class="text-center"><?PHP echo ($ordernum['total'] > 0) ? "<a href='" . base_url('sitecontrol/order/search/member/' . $dw['name'] . '/' . base64_encode(base64_encode(base64_encode(base64_encode('0'))))) . "'>" . $ordernum['total'] . "</a>" : $ordernum['total']; ?></td>
                                <td class="text-center"><?PHP echo ($ordernum['approve'] > 0) ? "<a href='" . base_url('sitecontrol/order/search/member/' . $dw['name'] . '/' . base64_encode(base64_encode(base64_encode(base64_encode('1'))))) . "'>" . $ordernum['approve'] . "</a>" : $ordernum['approve']; ?></td>
                                <td class="text-center"><?PHP echo ($ordernum['reject'] > 0) ? "<a href='" . base_url('sitecontrol/order/search/member/' . $dw['name'] . '/' . base64_encode(base64_encode(base64_encode(base64_encode('2'))))) . "'>" . $ordernum['reject'] . "</a>" : $ordernum['reject']; ?></td>
                                <td>
                                    <?PHP
//                                        $stat = array('stat'=>$dw['status'],'id'=>$dw['id'],'url'=>base_url('sitecontrol/member/status'));
//                                        $stat = $this->model_utility->status_control($stat);
//                                        echo $stat;
                                    ?>
                                    <a href="<?PHP echo base_url('sitecontrol/member/edit/' . $dw['id']); ?>" data-toggle="tooltip" data-placement="top" title="Edit" ><i class="fa fa-pencil-square fa-lg"></i></a>
                                    <a href="#" onclick="del('<?PHP echo $dw['id']; ?>', '<?PHP echo $dw['name']; ?>', '<?PHP echo base_url('sitecontrol/member/delete/' . $dw['id']); ?>')"><i class="fa fa-trash-o fa-lg" data-toggle="tooltip" data-placement="top" title="Delete"></i></a> 
                                </td>
                            </tr>
                            <?PHP
                            $i++;
                        }
                    } else {
                        ?>
                        <tr>
                            <td align="center" colspan="9">No Data</td>
                        </tr>
                    <?PHP } ?>
                </tbody>
            </table>
            <div class="text-right col-xs-12"><?PHP echo $links; ?></div>
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