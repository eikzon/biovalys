<?PHP
// Gen Template
echo $temp['head'] . $temp['nav_bar'] . $temp['menu'];
?>  
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <h1><i class="fa fa-hospital-o fa-lg"></i> CA</h1>
        <ol class="breadcrumb">
            <li><a href="<?PHP echo base_url('sitecontrol') ?>"> Home</a>
            </li>
            <li>
                <a href="<?PHP echo base_url('sitecontrol/zone') ?>">Area</a>
            </li>
            <li class="active">Area Add</li>
        </ol>
    </div>
    <div class="col-xs-12">
        <div class="box">
            <h4 class="box-title">Area Add</h4>

            <hr>
            <div class="col-xs-12">
                <?PHP echo form_open_multipart('sitecontrol/zone/insert', 'onsubmit="return form_zone()"'); ?>
                <div class="row">
                    <div class="form-group col-sm-4">
                        <?php
                            echo form_label('Area <span style="color:red;">*</span>');
                            $area_data = array('' => 'Nothing selected');
                            if(count($area_list) > 0){
                                foreach($area_list as $rs_area){
                                    $area_data[$rs_area['area_id']] = $rs_area['area_name'];
                                }
                            }
                            echo form_dropdown('zone_area_id',$area_data,'', 'class="selectpicker" data-width="100%" style="position:absolute; top:55px; width:1px; height:1px; display:inline-block !important; opacity:0;" required');
                        ?>
                    </div>
                    <div class="form-group col-sm-4">
                        <label>Area Code <span style="color:red;">*</span></label>
                        <input type="text" name="zone_code" class="form-control" placeholder="Area Code " pattern=".{3,}" required title="3 characters minimum" maxlength="3"/>
                    </div>
<!--                    <div class="form-group col-sm-4">
                        <label>Area Name <span style="color:red;">*</span></label>
                        <input type="text" name="zone_name" class="form-control" placeholder="Area Name " required/>
                    </div>-->
                    <div class="clearfix"></div>
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
<?PHP
// Gen Template
echo $temp['footer'];
?>