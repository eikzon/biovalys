<?PHP
// Gen Template
echo $temp['head'].$temp['nav_bar'].$temp['menu'];
?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
              <h1>
               Sales Order
              </h1>
                <form role="form" action="<?PHP echo base_url('order/search'); ?>" method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1"></label>
                        <input type="text" class="form-control" id="" placeholder="Search Order" name="name" value="<?PHP echo $search['name']; ?>">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-outline btn-lg btn-block btn-submit">Search</button>
                    </div>
                    <div class="form-group">
                        <select class="form-control selectpicker order_status" name="stat">
                            <option value="">Select Status All</option>
                            <?PHP
                            if(isset($status) && !empty($status))
                            {
                                $ops = '';
                                foreach($status as $k => $v)
                                {
                                    $select = ($k==$search['stat'] && $search['stat'] <> '')?'selected':'';
                                    $ops .='<option value="'.$k.'" '.$select.' >'.$v.'</option>';
                                }
                                echo $ops;
                            }
                            ?>
                        </select>
                    </div>
                </form>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- Profile Image -->
                        <div class="box box-primary">
                            <div class="box-body box-profile">
                                <ul class="list-group list-group-unbordered">
                                    <?PHP 
                                        if(isset($list) && !empty($list))
                                        { 
                                            foreach($list as $rs)
                                            {
                                                
                                                $time = strtotime($rs['order_date_create']);
                                        ?>
                                       <li class="list-group-item">
                                        <div class="col-xs-12">
                                            <b class="col-xs-11">
                                                <small><?PHP echo $rs['customer_name'];  ?></small>
                                                <br>
                                                <small> <i class="fa fa-calendar"></i><?PHP echo date('d/m/Y',$time); ?></small>
                                            </b>
                                            <div class="col-xs-1">
                                                <button type="button" class="btn btn-info btn-xs" onclick="show_detail_order('showorder<?PHP echo $rs['order_id'] ?>');" >
                                                    Show Order <i class="fa fa-angle-down"></i>
                                                </button>
                                            </div>
                                            <div class="clearfix"></div>
                                            <br>
                                            
                                            <div class="showorder<?PHP echo $rs['order_id'] ?>" style="display:none;">
                                            <?PHP 
                                            $order = $obj->list_data_order($rs['order_id']); 
                                            if(!empty($search['name'])){
                                                echo ($order['so']<>'')?$order['so']:'';
                                            }else{
                                                echo ($order['so']<>'')?$order['so']:'';
                                                echo ($order['foc']<>'')?$order['foc']:'';
                                                echo ($order['lo']<>'')?$order['lo']:'';
                                            }
                                            ?>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </li>
                                        <?PHP
                                            }
                                        }
                                        else
                                        {
                                            echo '<li class="list-group-item">
                                                    <div class="col-xs-12 text-center">
                                                        <b>NO DATA</b>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </li>';
                                        }
                                        ?>
                                </ul>
                                <div class="col-xs-12 text-center">
                                    <nav>
                                        <?PHP echo $links; ?>
                                    </nav>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                        <!-- About Me Box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
<?PHP
// Gen Template
echo $temp['footer'];
?>