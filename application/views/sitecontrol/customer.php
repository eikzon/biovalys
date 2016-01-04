<?PHP
// Gen Template
echo $temp['head'].$temp['nav_bar'].$temp['menu'];
?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="col-xs-8">
                    <h1><i class="fa fa-hospital-o fa-lg"></i> CA</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?PHP echo base_url('sitecontrol/home'); ?>"> Home</a>
                        </li>
                        <li class="active">CA</li>
                    </ol>
                </div>
                <div class="col-xs-4 text-right"><h1>All List : <?PHP echo number_format($total); ?> CA</h1></div>
            </div>
            <div class="col-xs-12">
                <div class="box">
                    <h4 class="box-title">CA</h4>
                    <?php // echo form_open_multipart(base_url('sitecontrol/customer/import'));?>
<!--                        <input type="file" name="import"/>
                        <input type="submit"/>
                    </form>-->
                    <button class="btn btn-table-tool btn-default" data-toggle="tooltip" data-placement="top" title="Export"onclick="export_csv('<?PHP echo base_url("sitecontrol/customer/export_csv"); ?>')"> <i class="fa fa-share-square-o"> </i> Export Data
                    </button>
                    <!--<button class="btn btn-table-tool btn-warning" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="fa fa-pencil-square-o"> </i> Edit Data
                    </button>-->
                    <a class="btn btn-table-tool btn-info" data-toggle="tooltip" data-placement="top" title="Add" href="<?PHP echo base_url('sitecontrol/customer/add'); ?>"> <i class="fa fa-plus"> </i> Add New Data
                    </a>
                    <hr>
                    <div class="col-xs-12 filter-form">
                        <?PHP echo form_open('sitecontrol/customer/search'); ?>
                            <div class="row">
                                <div class="form-group col-sm-3">
                                    <label>CA ID</label>
                                    <input type="text" name="sid" class="form-control" placeholder="CA ID" value="<?PHP echo @$search['sid']; ?>">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label>CA List</label>
                                    <input type="text" name="sname" class="form-control" placeholder="CA List" value="<?PHP echo @$search['sname']; ?>">
                                </div>
                                <!--<div class="form-group col-sm-3">
                                    <label>Representative Name</label>
                                    <input type="text" name="srep_name" class="form-control" placeholder="Representative Name" value="<?PHP echo @$search['srep_name']; ?>">
                                </div>-->
                                <div class="form-group col-sm-3">
                                    <label>CA Type</label>
                                    <select name="scus_type" class="form-control selectpicker">
                                        <option value="">-- Select CA Type --</option>
                                        <?PHP if(isset($cus_type)){ foreach($cus_type as $type){ ?>
                                        <option <?PHP echo (@$search['scus_type'] == $type['type_id'])?'selected':''; ?> value="<?PHP echo $type['type_id']; ?>"><?PHP echo $type['type_name']?></option>
                                        <?PHP }} ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label>Area</label>
                                    <select name="szone_id" class="form-control selectpicker">
                                        <option value="">-- Select Area --</option>
                                        <?PHP if(isset($zone_list)){ foreach($zone_list as $zone){ ?>
                                        <option <?PHP echo (@$search['szone_id'] == $zone['zone_id'])?'selected':''; ?> value="<?PHP echo $zone['zone_id']; ?>"><?PHP echo $zone['zone_code']?></option>
                                        <?PHP }} ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-3">
                                    <label>Status</label>
                                     <select class="selectpicker" data-width="100%" name="sstatus">
                                        <option value="">-- Select Status --</option>
                                        <?PHP
                                        if(isset($status) && !empty($status))
                                        {
                                            $op = "";
                                            foreach($status as $dv=>$dk)
                                            {
                                                $select = ($dv == $search['sstatus'] && $search['sstatus'] <> '')?'selected':'';
                                                $op .='<option value="'.$dv.'" '.$select.' >'.$dk.'</option>';
                                            }
                                            echo $op;
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-3">
                                    <button type="submit" class="btn btn-default btn-search"><i class="fa fa-search"></i> Search</button>
                                    <?PHP if(@$search['sid'] || @$search['sname'] || @$search['scus_type'] || @$search['szone_id'] || @$search['sstatus'] != ""){ ?>
                                    &nbsp;&nbsp;
                                    <button type="button" class="btn btn-default btn-search" onclick="window.location = '<?PHP echo base_url("sitecontrol/customer")?>/refresh'"><i class="fa fa-refresh"></i> Show All</button>
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
                                <th class="text-center" width="10%">CA ID</th>
                                <th width="15%">CA List</th>
                                <!--<th width="20%">Representative name</th>-->
                                <th width="12%">CA Type</th>
                                <th class="text-center" width="15%">CA Status</th>
                                <th width="12%">Zone</th>
                                <th>Sale Name</th>
                                <!--<th width="10%">Credit</th>-->
                                <th class="text-center" width="12%">Tools</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?PHP if((!empty($customer_list[0])) && isset($customer_list[0])){ $i=1; foreach($customer_list as $dw){ ?>
                            <tr id='row_<?PHP echo $dw['customer_id']; ?>'>
                                <td class="text-center"><?PHP echo $i; ?></td>
                                <td class="text-center"><?PHP echo $dw['customer_credit_number']; ?></td>
                                <td><a href="<?PHP echo base_url('sitecontrol/customer/edit/'.$dw['customer_id']); ?>" data-toggle="tooltip" data-placement="top" title="Edit"><?PHP echo $dw['customer_name']; ?></a></td>
                                <!--<td><?//PHP echo $dw['contact_name']; ?></td>-->
                                <td><?PHP echo $dw['cus_type_name']; ?></td>
                                <td class="text-center"><?PHP echo $dw['approve']; ?></td>
                                <td><?PHP echo $dw['zone_code']; ?></td>
                                <td><?PHP echo $dw['member_name']; ?></td>
                                <!--<td>
                                    <div class="progress">
                                        <div class="progress-bar <?//PHP echo $dw['credit_color']; ?>" role="progressbar" aria-valuenow="<?//PHP echo $dw['credit_per']; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?//PHP echo $dw['credit_per']?>%">
                                            <span><?//PHP echo $dw['credit_per']; ?>%</span>
                                        </div>
                                    </div>
                                </td>-->
                                <td class="text-right">
                                    <?php if($dw['customer_approve']){?>
                                    <a href="<?PHP echo base_url('sitecontrol/customer/print_ca/'.$dw['customer_id']); ?>" target="_blank" data-toggle="tooltip" data-placement="top" title="Print"><i class="fa fa-print fa-lg"></i></a>
                                    <?php }?>
                                    <a href="<?PHP echo base_url('sitecontrol/order/customer/'.$dw['customer_name']); ?>"  data-toggle="tooltip" data-placement="top" title="Sale Order"><i class="fa fa-list-alt fa-lg"></i></a>
                                    <a href="<?PHP echo base_url('sitecontrol/customer/edit/'.$dw['customer_id']); ?>" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square fa-lg"></i></a>
                                    <a href="#" onclick="del('<?PHP echo $dw['customer_id']; ?>','<?PHP echo $dw['customer_name']; ?>','<?PHP echo base_url('sitecontrol/customer/delete/'.$dw['customer_id']); ?>')"><i class="fa fa-trash-o fa-lg" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                                </td>
                            </tr>
                            <?PHP $i++; }}else{ ?>
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