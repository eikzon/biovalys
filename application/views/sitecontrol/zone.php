<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="col-xs-8">
            <h1><i class="fa fa-hospital-o fa-lg"></i> Area</h1>
            <ol class="breadcrumb">
                <li><a href="<?PHP echo base_url('sitecontrol/home'); ?>"> Home</a>
                </li>
                <li class="active">Area</li>
            </ol>
        </div>
        <div class="col-xs-4 text-right"><h1>All List : <?PHP echo number_format($total); ?> Area</h1></div>
    </div>
    <div class="col-xs-12">
        <div class="box">
            <h4 class="box-title">Area</h4>
            <!--<button class="btn btn-table-tool btn-default" data-toggle="tooltip" data-placement="top" title="Export"onclick="export_csv('<?//PHP echo base_url("sitecontrol/customer/export_csv"); ?>')"> <i class="fa fa-share-square-o"> </i> Export Data
            </button>-->
            <!--<button class="btn btn-table-tool btn-warning" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="fa fa-pencil-square-o"> </i> Edit Data
            </button>-->
            <a class="btn btn-table-tool btn-info" data-toggle="tooltip" data-placement="top" title="Add" href="<?PHP echo base_url('sitecontrol/zone/add'); ?>"> <i class="fa fa-plus"> </i> Add New Data
            </a>
            <hr>
            <div class="col-xs-12 filter-form">
                <?PHP echo form_open('sitecontrol/zone/search'); ?>
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label>Area Code</label>
                        <input type="text" name="scode" class="form-control" placeholder="Area Code" value="<?PHP echo $search['scode']; ?>">
                    </div>
<!--                    <div class="form-group col-sm-3">
                        <label>Zone Name</label>
                        <input type="text" name="sname" class="form-control" placeholder="Zone Name" value="<?PHP echo $search['sname']; ?>">
                    </div>-->
                    <div class="form-group col-sm-3">
                        <button type="submit" class="btn btn-default btn-search"><i class="fa fa-search"></i> Search</button>
                        <?PHP if ($search['scode'] || $search['sname']) { ?>
                            &nbsp;&nbsp;
                            <button type="button" class="btn btn-default btn-search" onclick="window.location = '<?PHP echo base_url("sitecontrol/zone") ?>/refresh'"><i class="fa fa-refresh"></i> Show All</button>
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
                        <th class="text-center" width="15%">Area</th>
                        <th class="text-center" width="15%">Area Code</th>
                        <!--<th>Zone Name</th>-->
                        <th class="text-center" width="15%">Area Status</th>
                        <th class="text-center" width="15%">CA</th>
                        <th class="text-center" width="10%">Tools</th>
                    </tr>
                </thead>
                <tbody>
                    <?PHP
                    if ((!empty($zone_list[0])) && isset($zone_list[0])) {
                        $i = 1;
                        foreach ($zone_list as $dw) {
                            ?>
                            <tr id='row_<?PHP echo $dw['id']; ?>'>
                                <td class="text-center"><?PHP echo $i; ?></td>
                                <td class="text-center"><?PHP echo $dw['area']; ?></td>
                                <td class="text-center"><?PHP echo $dw['code']; ?></td>
                                <!--<td><a href="<?PHP echo base_url('sitecontrol/zone/edit/' . $dw['id']); ?>" data-toggle="tooltip" data-placement="top" title="Edit"><?PHP echo $dw['name']; ?></a></td>-->
                                <td>
                                    <select class="form-control selectpicker" name="status_member" data-id="<?PHP echo $dw['id']; ?>" onchange="status('<?PHP echo $dw['id'] ?>', this.value, '<?PHP echo base_url('sitecontrol/zone/status'); ?>')">
                                        <option value="1" <?PHP
                                        if ($dw['status'] == 1) {
                                            echo 'selected';
                                        }
                                        ?>>แสดงปกติ</option>
                                        <option value="0" <?PHP
                                        if ($dw['status'] == 0) {
                                            echo 'selected';
                                        }
                                        ?>>ยกเลิกการแสดง</option>
                                    </select>
                                </td>
                                <td class="text-center"><?PHP echo ($dw['total'] > 0) ? "<a href=" . base_url('sitecontrol/customer/search/' . base64_encode(base64_encode(base64_encode(base64_encode($dw['id']))))) . ">" . $dw['total'] . "</a>" : $dw['total']; ?></td>
                                <td class="text-center">
                                    <a href="<?PHP echo base_url('sitecontrol/zone/edit/' . $dw['id']); ?>" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square fa-lg"></i></a>
                                    <a href="#" onclick="del('<?PHP echo $dw['id']; ?>', '<?PHP echo $dw['name']; ?>', '<?PHP echo base_url('sitecontrol/zone/delete/' . $dw['id']); ?>')"><i class="fa fa-trash-o fa-lg" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                                </td>
                            </tr>
                            <?PHP
                            $i++;
                        }
                    } else {
                        ?>
                        <tr>
                            <td colspan="7" align="center">No Data</td>
                        </tr>
                    <?PHP } ?>
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