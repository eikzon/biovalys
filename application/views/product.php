<?PHP
// Gen Template
echo $temp['head'].$temp['nav_bar'].$temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- Profile Image -->
                        <?PHP 
                        if(isset($list) && !empty($list))
                        {
                            foreach($list as $item)
                            {
                        ?>
                        <div class="box box-primary">
                            <div class="box-body box-profile">
                                <?PHP 
                                    $arr = array('file'=>$item['product_picture'],'path'=>'assets/img/product');
                                    $img = $this->model_utility->show_images($arr);
                                ?>
                                <img class="product-img img-responsive img-thumbnail" src="<?PHP echo $img; ?>">
                                <h3><?PHP echo $item['product_name']; ?></h3>
                                <p class="text-muted"><?PHP echo $item['product_detail']; ?></p>
                                <!--<hr>
                                <label>Instock</label>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-green " role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                        <span>50% </span>
                                    </div>
                                </div>-->
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <?PHP
                            }
                        }
                        ?>
                        <a class="btn btn-primary btn-outline btn-lg" role="button" href="<?PHP echo base_url(); ?>" ><i class="fa fa-reply"></i> Back</a>
                        <!-- /.box -->
                        <!-- About Me Box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
<?PHP
// Gen Template
echo $temp['footer'];
?>