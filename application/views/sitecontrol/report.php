<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="col-xs-8">
            <h1><i class="fa fa-file-text-o fa-lg"></i> Report</h1>
            <ol class="breadcrumb">
                <li><a href="<?PHP echo base_url('sitecontrol/home'); ?>"> Home</a>
                </li>
                <li class="active">Report</li>
            </ol>
        </div>
    </div>
    <div class="col-xs-12">
        <div class="box">
            <h4 class="box-title">Report</h4>
            <hr/>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No.</th>
                        <th>Report Name</th>
                        <th class="text-center" width="10%">Tools</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    foreach($report as $r => $rs){
                        $r++;
                ?>
                    <tr class="row_report" data-url="<?php echo base_url('sitecontrol/report/'.$rs['link'].'');?>" style="cursor: pointer;">
                        <td class="text-center"><?php echo $r;?></td>
                        <td><?php echo $rs['name'];?></td>
                        <td class="text-center"><i class="fa fa-info-circle fa-lg"></i></td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
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
    $('.row_report').click(function(){
        window.location=$(this).data('url');
    });
</script>