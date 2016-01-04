<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Customer Detail 
        </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <!-- Profile Image -->
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="col-xs-12">
                            <label class="col-xs-4">Name</label>
                            <span class="col-xs-8">: <?php echo (!empty($customer['customer_name']))?$customer['customer_name']:'-'; ?></span>
                        </div>
                        <div class="col-xs-12">
                            <label class="col-xs-4">Common</label>
                            <span class="col-xs-8">: <?php echo (!empty($customer['customer_common']))?$customer['customer_common']:'-'; ?></span>
                        </div>
                        <div class="col-xs-12">
                            <label class="col-xs-4">CA</label>
                            <span class="col-xs-8">: <?php echo (!empty($customer['customer_credit_number']))?$customer['customer_credit_number']:'-'; ?></span>
                        </div>
                        <div class="col-xs-12">
                            <label class="col-xs-4">Type</label>
                            <span class="col-xs-8">: <?php echo (!empty($customer['cus_type_name']))?$customer['cus_type_name']:'-'; ?></span>
                        </div>
                        <div class="col-xs-12">
                            <label class="col-xs-4">Tax ID</label>
                            <span class="col-xs-8">: <?php echo (!empty($customer['customer_taxid']))?$customer['customer_taxid']:'-'; ?></span>
                        </div>
                        <div class="col-xs-12">
                            <label class="col-xs-4">Area</label>
                            <span class="col-xs-8">: <?php echo (!empty($customer['zone_code']))?$customer['zone_code']:'-'; ?></span>
                        </div>
                        <div class="col-xs-12">
                            <label class="col-xs-4">Address</label>
                            <span class="col-xs-8">: 
                                <?php echo (!empty($customer['customer_address']))?$customer['customer_address']:'-'; ?>
                                <?php echo (!empty($customer['province_name']))?$customer['province_name']:''; ?>
                                <?php echo (!empty($customer['customer_postcode']))?$customer['customer_postcode']:''; ?>
                            </span>
                        </div>
                        <div class="col-xs-12">
                            <label class="col-xs-4">Telephone</label>
                            <span class="col-xs-8">: <?php echo (!empty($customer['customer_telephone']))?$customer['customer_telephone']:'-'; ?></span>
                        </div>
                        <div class="col-xs-12">
                            <label class="col-xs-4">Military</label>
                            <span class="col-xs-8">: <?php echo (@$customer['customer_military'] > 0)?'Yes':'No'; ?></span>
                        </div>
                        <div class="col-xs-12">
                            <label class="col-xs-4">Provincial</label>
                            <span class="col-xs-8">: <?php echo (@$customer['customer_provincial'] > 0)?'Yes':'No'; ?></span>
                        </div>
                        <div class="col-xs-12">
                            <label class="col-xs-4">Delivery</label>
                            <span class="col-xs-8">: <?php echo (!empty($customer['customer_delivery']))?$customer['customer_delivery']:'-'; ?></span>
                        </div>
                        <div class="col-xs-12">
                            <label class="col-xs-4">Credit (Baht)</label>
                            <span class="col-xs-8">: <?php echo number_format($customer['customer_credit_price'],2); ?></span>
                        </div>
                        <div class="col-xs-12">
                            <label class="col-xs-4">Credit (Day)</label>
                            <span class="col-xs-8">: <?php echo number_format($customer['customer_payment_term']); ?></span>
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