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
                    <?PHP
                        $img = $this->model_utility->show_images(array('file'=>$user['member_picture'],'path'=>'assets/img/user'));
                    ?>
                  <!--<img class="profile-user-img img-responsive img-circle" src="<?PHP echo $img; ?>" alt="User profile picture">
                  <h3 class="profile-username text-center"><?PHP echo $user['member_name']; ?></h3>
                  <p class="text-muted text-center"><?PHP echo $user['member_number']; ?></p>-->

                  <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                      <a href="<?PHP echo base_url('order') ?>"><i></i><b class="text-yellow"><i class="fa fa-star"></i> Sale Order</b> <a class="pull-right text-yellow" ><?PHP echo $sum['total'] ?></a></a>
                    </li>
                    <li class="list-group-item">
                      <a href="<?PHP echo base_url('order/success') ?>"><b class="text-green"> <i class="fa fa-check"></i> Success Order</b> <a class="pull-right text-green" ><?PHP echo $sum['approve'] ?></a></a>
                    </li>
                    <li class="list-group-item">
                      <a href="<?PHP echo base_url('order/reject') ?>"><b class="text-red"><i class="fa fa-times"></i> Reject Order</b> <a class="pull-right text-red"  ><?PHP echo $sum['reject'] ?></a></a>
                    </li>
                  </ul>
<!--                  <a href="#" class="btn btn-outline btn-block "><b>Send Message</b></a>-->
                </div><!-- /.box-body -->
              </div><!-- /.box -->
              <!-- About Me Box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
<?PHP
// Gen Template
echo $temp['footer'];
?>