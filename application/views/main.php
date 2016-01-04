<?PHP
// Gen Template
echo $temp['head'].$temp['nav_bar'].$temp['menu'];
?>
<style>
    .app{
        font-size: 50px;
    }
    .top-app{
        margin-top: 20px;
    }
</style>
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
                    <div class="row top-app">
                        <div class="col-xs-6 text-center"><a href="<?PHP echo base_url('home/profile'); ?>"><i class="fa fa-users fa-5x "></i><br>Sale member</a></div>
                        <div class="col-xs-6 text-center"><a href="<?PHP echo base_url('customer'); ?>"><i class="fa fa-hospital-o fa-5x "></i><br>CA</a></div>
                    </div>
                    <div class="row top-app" >
                        <div class="col-xs-6 text-center"><a href="<?PHP echo base_url('order'); ?>"><i class="fa fa-list-alt fa-5x "></i><br>Order</a></div>
                        <div class="col-xs-6 text-center"><a href="<?PHP echo base_url('product'); ?>"><i class="fa fa-cubes fa-5x "></i><br>Product</a></div>
                    </div>
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