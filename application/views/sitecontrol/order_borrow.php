<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <h1><i class="fa fa-list-alt fa-lg"></i> Sales Order</h1>
        <ol class="breadcrumb">
            <li><a href="#"> Home</a>
            </li>
            <li>
                <a href="#">Sales Order</a>
            </li>
            <li class="active">Sales Order Add</li>
        </ol>
    </div>
    <div class="col-xs-12">
        <div class="box">
            <h4 class="box-title">Sales Order Add</h4>

            <hr>
            <div class="col-xs-12">
                <form>
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label>CA List :</label>
                            <select name="FK_customer_id" class=" form-control selectpicker" required>
                                <option>Select CA</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Date</label>
                            <input type="text" class="form-control datepicker" id="datepicker" value="">
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Sales Name :</label>
                            <select name="FK_member_id" class=" form-control selectpicker" required>
                                <option>Select Sales</option>
                            </select>
                        </div>
                        <div class="clearfix"></div>
                        <hr>
                        <div class="form-group col-sm-1">
                            <label>Code :</label>
                            <input type="text" class="form-control" placeholder="Code ">
                        </div>
                        <div class="form-group col-sm-3">
                            <label>product :</label>
                            <input type="text" class="form-control" placeholder="Code ">
                        </div>
                        <div class="form-group col-sm-2">
                            <label>packing :</label>
                            <input type="text" class="form-control" placeholder="Code ">
                        </div>
                        <div class="form-group col-sm-2">
                            <label>Quatity :</label>
                            <input type="text" class="form-control" placeholder="Code ">
                        </div>
                        <div class="form-group col-sm-2">
                            <label>Price/Unit(Baht) :</label>
                            <input type="text" class="form-control" placeholder="Code ">
                        </div>
                        <div class="form-group col-sm-2">

                            <button class="btn btn-success product-add" type="button"><i class="fa fa-plus-circle"></i> Add Product</button>
                        </div>

                        <div class="clearfix"></div>
                        <hr>
                        <table class="table table-bordered order-item">
                            <thead>
                                <tr>
                                    <th class="text-center" width="10%">Code</th>
                                    <th class="text-center" width="35%">Product</th>
                                    <th class="text-center" width="15%">Packing</th>
                                    <th class="text-center" width="10%">Quantity</th>
                                    <th class="text-center" width="15%">Price/Unit
                                        <br>(ฺBaht)</th>
                                    <th class="text-center" width="15%">Total
                                        <br>(Baht)</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">#0001</td>
                                    <td class="text-center">Speeda</td>
                                    <td class="text-center">100 Dose</td>
                                    <td class="text-center">5</td>
                                    <td class="text-center">5,000</td>
                                    <td class="text-center">
                                        250,000
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group col-sm-6">
                            <label>Remark</label>
                            <textarea class="form-control" rows="4"></textarea>
                        </div>
                        <div class="form-group col-sm-4 col-sm-offset-2">
                            <label class="col-xs-6 input-inline">Discount:</label>
                            <div class="input-group col-xs-6">
                                <input type="text" class="form-control" id="" placeholder="">
                                <div class="input-group-addon">%</div>
                            </div>
                            <label class="col-xs-6 input-inline">Discount Price :</label>
                            <P class="col-xs-6 price-text text-danger">0.00 Baht</P>
                            <label class="col-xs-6 input-inline">Total Price :</label>
                            <P class="col-xs-6 price-text">250,000 Baht</P>
                            <label class="col-xs-6 input-inline">Vat (7%) :</label>
                            <P class="col-xs-6 price-text">0.00 Baht</P>
                            <label class="col-xs-6 input-inline">Grand Total :</label>
                            <P class="col-xs-6 price-text-total">250,000 Baht</P>
                        </div>


                        <div class="clearfix"></div>
                        <hr>
                        <div class="form-group col-sm-12">
                            <button class="btn btn-info" type="submit"><i class="fa fa-check"></i> Save</button>
                            <button class="btn btn-default" type="reset"><i class="fa fa-times"></i> Cancel</button>
                        </div>

                    </div>
                </form>
            </div>

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