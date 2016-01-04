<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>
<script src="<?php echo base_url('assets/js/jquery.chart.js'); ?>"></script>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Welcome To Biovalys
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body box-profile">
                        <?PHP
                        $img = $this->model_utility->show_images(array('file' => $user['member_picture'], 'path' => 'assets/img/user'));
                        ?>
                        <!--<img class="profile-user-img img-responsive img-circle" src="<?PHP echo $img; ?>" alt="User profile picture">-->
                        <div align="center">
                            <table class="pie_chart_show">
                                <tr><th>sortOrder</th><th>value</th><th>color</th><th>description</th></tr>
                                <?php 
                                    foreach($chart['qty'] as $key_cha => $rs_cha){
                                        echo '<tr><td>'.(@$key_cha+1).'</td><td>'.((@$rs_cha['qty'] > 0)?((@$rs_cha['qty']*100)/@$chart['total']):0).'</td><td>'.@$color[@$key_cha].'</td><td>'.str_replace(array('<sup>', '</sup>'), ' ',$rs_cha['name']).' ('.@$rs_cha['qty'].')</td></tr>';
                                    }
                                ?>
                            </table>
                        </div>
                        <h3 class="profile-username text-center"><?PHP echo $user['member_name']; ?></h3>
                        <p class="text-muted text-center"><?PHP echo $user['member_number']; ?></p>

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
                        <a href="<?PHP echo base_url('customer'); ?>" class="btn btn-outline btn-block "><b>New Order</b></a>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <!-- About Me Box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?PHP
// Gen Template
echo $temp['footer'];
?>
<script>
    $(".pie_chart_show").donutChart({
        width: 350,
        height: 200,
        legendSizePadding: 0.05,
//        hasBorder: true
    });
</script>