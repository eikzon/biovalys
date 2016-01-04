<?PHP
// Gen Template
echo $temp['head'].$temp['nav_bar'].$temp['menu'];
?>  <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="col-xs-8">
                    <h1><i class="fa fa-cubes fa-lg"></i> Product</h1>
                    <ol class="breadcrumb">
                        <li><a href="<?PHP echo base_url("sitecontrol")?>"> Home</a>
                        </li>
                        <li class="active">Product</li>
                    </ol>
                </div>
                <div class="col-xs-4 text-right"><h1>All List : <?PHP echo number_format($total); ?> Product</h1></div>
            </div>
            <div class="col-xs-12">
                <div class="box">
                    <h4 class="box-title">Product</h4>
                    <button class="btn btn-table-tool btn-default" data-toggle="tooltip" data-placement="top" title="Export" onclick="export_csv('<?PHP echo base_url("sitecontrol/product/export_csv"); ?>')"> <i class="fa fa-share-square-o"> </i> Export Data
                    </button>                    
                    <!--<button class="btn btn-table-tool btn-warning" data-toggle="tooltip" data-placement="top" title="Edit"> <i class="fa fa-pencil-square-o"> </i> Edit Data
                    </button>-->
                    <a class="btn btn-table-tool btn-info" data-toggle="tooltip" data-placement="top" title="Add" href="<?PHP echo base_url('sitecontrol/product/add'); ?>"> <i class="fa fa-plus"> </i> Add New Data
                    </a>
                    <hr>
                    <div class="col-xs-12 filter-form">
                        <?PHP echo form_open('sitecontrol/product/search'); ?>
                            <div class="row">
                                <div class="form-group col-sm-3">
                                    <label>ID</label>
                                    <input type="text" name="sid" class="form-control" value="<?PHP echo $search['sid']; ?>" placeholder="Search ID">
                                </div>
                                <div class="form-group col-sm-3">
                                    <label>Name</label>
                                    <input type="text" name="sname" class="form-control" value="<?PHP echo $search['sname']; ?>" placeholder="Search Name">
                                </div>
                                <div class="form-group col-sm-3">
                                    <button type="submit" class="btn btn-default btn-search"><i class="fa fa-search"></i> Search</button>
                                    <?PHP if($search['sid'] || $search['sname']){ ?>
                                    &nbsp;&nbsp;
                                    <button type="button" class="btn btn-default btn-search" onclick="window.location = '<?PHP echo base_url("sitecontrol/product")?>/refresh'"><i class="fa fa-refresh"></i> Show All</button>
                                    <?PHP } ?>
                                </div>
                            </div>
                        <?PHP echo form_close(); ?>
                    </div>
                    <div class="text-right col-xs-12"><?PHP echo $links; ?></div>
                    <table class="table table-hover table-striped product-table">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">No.</th>
                                <th class="text-center" width="10%">ID</th>
                                <th class="text-center" width="20%">Image</th>
                                <th> Name</th>
                                <th class="text-center" width="10%">Rebate</th>
                                <th class="text-center" width="20%">Detail</th>
                                <th class="text-center" width="15%">Tools</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?PHP if((!empty($product_list[0])) && isset($product_list[0])){ $i=1; foreach($product_list as $dw){ ?>
                            <tr id='row_<?PHP echo $dw['id']; ?>'>
                                <td class="text-center"><?PHP echo $i; ?></td>
                                <td class="text-center"><?PHP echo $dw['code']; ?></td>
                                <td class="text-center"><a href="#"> <img class="img-thumbnail img-reponsive" src="<?PHP echo $dw['picture']; ?>"></a></td>
                                <td><?PHP echo $dw['name']; ?></td>
                                <td class="text-center"><?PHP echo ($dw['rebate'] > 0)?(($dw['rebate'] == 1)?'Extra (S)':'Extra (TD)'):'-'; ?></td>
                                <td class="text-center"><?PHP echo $dw['detail']; ?></td>
                                <td class="text-center">
                                    <a href="<?PHP echo base_url('sitecontrol/product/detail/'.$dw['id']); ?>" data-toggle="tooltip" data-placement="top" title="Detail"><i class="fa fa-info-circle fa-lg"></i></a>
                                    <a href="<?PHP echo base_url('sitecontrol/product/edit/'.$dw['id']); ?>" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil-square fa-lg"></i></a>
                                    <a href="#" onclick="del('<?PHP echo $dw['id']; ?>','<?PHP echo $dw['name']; ?>','<?PHP echo base_url('sitecontrol/product/delete/'.$dw['id']); ?>')"><i class="fa fa-trash-o fa-lg" data-toggle="tooltip" data-placement="top" title="Delete"></i></a>
                                </td>
                            </tr>
                            <?PHP $i++;}}else{ ?>
                            <tr>
                                <td colspan="5" align="center">No Data</td>
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