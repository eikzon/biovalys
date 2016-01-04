<?PHP
// Gen Template
echo $temp['head'].$temp['nav_bar'].$temp['menu'];
?>
<style type="text/css">
            /* css กำหนดความกว้าง ความสูงของแผนที่ */
            #map_canvas { 
                top:0px;
                width:100%;
                height:200px;
                margin:auto;
            }
            /*css กำหนดรูปแบบ ของ input สำหรับพิมพ์ค้นหา effect */
            .controls_tools {
                margin-top: 16px;
                border: 1px solid transparent;
                border-radius: 2px 0 0 2px;
                box-sizing: border-box;
                -moz-box-sizing: border-box;
                height: 32px;
                outline: none;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            }
            /*css กำหนดรูปแบบ ของ input สำหรับพิมพ์ค้นหา*/
            #news_location {
                background-color: #fff;
                padding: 0 11px 0 13px;
                width: 60%;
                font-family: Roboto;
                font-size: 15px;
                font-weight: 300;
                text-overflow: ellipsis;
            }
            /*css กำหนดรูปแบบ ของ input สำหรับพิมพ์ค้นหา ขณะ focus*/
            #news_location:focus {
                width: 60%;
                border-color: #4d90fe;
                margin-left: -1px;
                padding-left: 14px;  /* Regular padding-left + 1. */
            }

        </style>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Customer
                </h1>
            </section>
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <!-- Profile Image -->
                        <div class="box box-primary">
                            <div class="box-body box-profile">
                                <h3 class="box-title">Add News Customer</h3>
                                <form role="form" action="<?PHP echo base_url('customer/insert'); ?>" method="post">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Customer Name *</label>
                                            <input type="text" class="form-control typeahead" id="auto_customer" placeholder="Customer Name" name="customer_name" data-provide="typeahead" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Customer Address</label>
                                            <textarea class="form-control" rows="4" name="customer_address" placeholder="Address"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Customer Province</label>
<!--                                            <input type="text" class="form-control" id="" placeholder="Customer Province" name="customer_province">-->
                                            <select class="form-control selectpicker" name="customer_province" data-live-search="true" required>
                                            <option value="">Select Province</option>
                                            <?PHP
                                            if(isset($prov) && !empty($prov))
                                            {
                                                foreach($prov as $p)
                                                {
                                                    $op .='<option value="'.$p['province_id'].'">'.$p['province_name'].'</option>';
                                                }
                                                echo $op;
                                            }
                                            ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Customer Postcode</label>
                                            <input type="text" class="form-control" id="" placeholder="Customer Postcode" name="customer_postcode">
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Customer Telephone</label>
                                            <input type="text" class="form-control" id="" placeholder="Customer Telephone" name="customer_telephone">
                                        </div>
                                        <div class="form-group">
                                        <div class="col-sm-12">
                                            <div id="map_canvas">&nbsp;</div>
                                            <input id="news_location" class="form-control controls_tools" type="text" placeholder="Enter a location" >  
                                            <input id="customer_lat" name="customer_lat" type="hidden" value="13.74683"/><br/>
                                            <input id="customer_lon" name="customer_lon" type="hidden" value="100.53492800000004"/>
                                            <input id="news_late_default"  type="hidden" value=""/><br/>
                                            <input id="news_long_default"  type="hidden" value=""/>
                                            <input id="news_location_default" type="hidden" value=""/>
                                        </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Customer Type</label>
                                            <select class="form-control selectpicker" name="FK_type_id" required>
                                                <?PHP 
                                                if(isset($type) && !empty($type))
                                                {
                                                    foreach($type as $ty)
                                                    {
                                                        echo '<option value="'.$ty['cus_type_id'].'">'.$ty['cus_type_name'].'</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
<!--                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Representative Name</label>
                                            <input type="text" class="form-control" id="" placeholder="Customer Name" name="customer_represent_name">
                                        </div>-->
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Customer TaxID *</label>
                                            <div class="form-group has-feedback">
                                                <input type="text" class="form-control" placeholder="Customer TaxID" name="customer_taxid" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Pharmacist Name</label>
                                            <input type="text" class="form-control" id="" placeholder="Pharmacist Name" name="customer_pharmacist" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Remark</label>
                                            <div class="form-group has-feedback">
                                                <textarea  class="form-control" rows="4" name="customer_remark" placeholder="Customer Remark"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-outline btn-lg btn-block">Submit</button>
                                    </div>
                                </form>
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
<script src="<?PHP echo base_url() ?>assets/js/typeahead.bundle.js"></script>
<script>
    $(document).ready(function () {
        url = $('#base_url').html();
        $('.typeahead').typeahead({
            ajax: url+'customer/auto_customer'
        });
    });
                      
</script>
<?PHP
// Gen Template
echo $temp['footer'];
?>