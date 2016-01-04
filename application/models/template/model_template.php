<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_template extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function gen() {
        $data = array('head' => $this->head(),
            'nav_bar' => $this->nav_bar(),
            'menu' => $this->menu(),
            'footer' => $this->footer()
        );
        return $data;
    }

    public function head() {
        $data = '<!DOCTYPE html>
                    <html>
                      <head>
                        <meta charset="UTF-8">
                        <title>Biovalys</title>
                        <meta http-equiv="X-UA-Compatible" content="IE=edge">
                        <!-- Tell the browser to be responsive to screen width -->
                        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
                        <!-- Bootstrap 3.3.5 -->
                        <link rel="stylesheet" href="' . base_url() . 'assets/css/bootstrap.min.css">
                        <!-- Font Awesome -->
                        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

                        <!-- Theme style -->
                        <link rel="stylesheet" href="' . base_url() . 'assets/css/AdminLTE.min.css">
                        <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
                        <link rel="stylesheet" href="' . base_url() . 'assets/css/skin-blue-light.min.css">
                        <link rel="stylesheet" href="' . base_url() . 'assets/css/style.css">
                        <link href="' . base_url() . 'assets_sitecontrol/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
                        <link href="' . base_url() . 'assets_sitecontrol/css/datepicker.css" rel="stylesheet" type="text/css">
                        <!-- Add Other Style -->                        
                        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
                        <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
                        <!--[if lt IE 9]>
                            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
                            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
                        <![endif]-->
                        <!-- jQuery 2.1.4 -->
                        <script src="' . base_url() . 'assets/js/jquery.js"></script>
                        <!-- Bootstrap 3.3.5 -->
                        <script src="' . base_url() . 'assets/js/bootstrap.min.js"></script>
                      </head>
                      <body class="hold-transition skin-blue-light layout-top-nav">
                        <div class="wrapper">
                    ';
        return $data;
    }

    public function nav_bar() {
        $user = $this->session->userdata('member_data');
        $img = $this->model_utility->show_images(array('file' => $user['member_picture'], 'path' => 'assets/img/user'));
        $data = '<header class="main-header">
        <!-- Logo -->
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-fixed-top" role="navigation">
         <div class="contianer-fluid">
          <!-- Sidebar toggle button-->
          <div class="col-xs-3">
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          </a>
          </div>
          <div class="col-xs-6">
            <a href="' . base_url('home') . '" style="font-color:#FFF !important;" ><h3 class="text-center mainlogo">Biovalys</h3></a>
          </div>
          <div class="col-xs-3">
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                 <span class="fa-stack fa-lg">
                      <i class="fa fa-circle-thin fa-stack-2x"></i>
                      <i class="fa fa fa-user fa-stack-1x"></i>
                    </span>
                  <span class="hidden-xs">' . $user['member_name'] . '</span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <!--<li class="user-header">
                    <img class="profile-user-img img-responsive img-circle" src="' . $img . '" alt="User profile picture">
                    <p>
                      ' . $user['member_name'] . '
                      <small>Member since ' . $this->convert_mount($user['member_register']) . '</small>
                    </p>
                  </li>-->
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <!--<div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>-->
                    <div>
                      <a data-toggle="modal" data-target=".change-password" class="btn btn-default btn-flat col-xs-12"><i class="fa fa-cog"></i> Change Password</a>
                      <a href="#" data-toggle="modal" data-target="#Logout" class="btn btn-default btn-flat col-xs-12"><i class="fa fa-power-off"></i>
 Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
              <!-- Control Sidebar Toggle Button -->
            </ul>
          </div>
          </div>
          </div>
        </nav>
      </header>';
        return $data;
    }

    public function menu() {
        $sale_order = ($this->uri->segment(1) == 'home' && $this->uri->segment(2) == 'profile')?'active':'';
        $customer = ($this->uri->segment(1) == 'customer')?'active':'';
        $order = ($this->uri->segment(1) == 'order')?'active':'';
        $product = ($this->uri->segment(1) == 'product')?'active':'';
        $data = '<!-- Left side column. contains the logo and sidebar -->
                      <aside class="main-sidebar">
                        <!-- sidebar: style can be found in sidebar.less -->
                        <section class="sidebar">
                         <div class="row list-menu">
                                <a href="' . base_url('home/profile') . '" class="'.$sale_order.'">
                                    <div class="col-xs-2"><i class="fa fa-users fa-lg"></i>
                                    </div>
                                    <div class="col-xs-8 "> Sales Member</div>
                                    <div class="col-xs-2 text-right"><i class="fa fa-chevron-right"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="row list-menu">
                                <a href="' . base_url('customer') . '" class="'.$customer.'">
                                    <div class="col-xs-2"><i class="fa fa-hospital-o fa-lg"></i>
                                    </div>
                                    <div class="col-xs-8 "> Customer (CA)</div>
                                    <div class="col-xs-2 text-right"><i class="fa fa-chevron-right"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="row list-menu">
                                <a href="' . base_url('order') . '" class="'.$order.'">
                                    <div class="col-xs-2"><i class="fa fa-list-alt fa-lg"></i>
                                    </div>
                                    <div class="col-xs-8 text-"> Sales Order (SO)</div>
                                    <div class="col-xs-2 text-right"><i class="fa fa-chevron-right"></i>
                                    </div>
                                </a>
                            </div>
                            <!--<div class="row list-menu">
                                <a href="' . base_url('order/new_order') . '">
                                    <div class="col-xs-2"><i class="fa fa-file-text-o fa-lg"></i>
                                    </div>
                                    <div class="col-xs-8 text-"> New Order (NO)</div>
                                    <div class="col-xs-2 text-right"><i class="fa fa-chevron-right"></i>
                                    </div>
                                </a>
                            </div>-->
                           <div class="row list-menu">
                                <a href="' . base_url('product') . '" class="'.$product.'">
                                    <div class="col-xs-2"><i class="fa fa-cubes fa-lg"></i>
                                    </div>
                                    <div class="col-xs-8 "> Product</div>
                                    <div class="col-xs-2 text-right"><i class="fa fa-chevron-right"></i>
                                    </div>
                                </a>
                            </div>
                            <div class="row" style="padding-left:5px;margin-top:30px;">
                            <div class="col-xs-12"><b>Address : </b></div>
                                    <div class="col-xs-12">21 Udomsuk 37, Sukhumvit 103 Rd.,Bangjak ,
Prakanong,Bangkok 10260, Thailand </div>
                            <div class="clearfix"></div>
                            <div class="col-xs-12"><b>Phone :</b></div>
                            <div class="col-xs-12"> +662-361-8116</div>
                            <div class="clearfix"></div>
                            <div class="col-xs-12"><b>Fax :</b></div>
                            <div class="col-xs-12">+662-361-8106</div>
                            <div class="clearfix"></div>
                            </div>
                            <!--<div class="row list-menu">
                                <a href="#">
                                    <div class="col-xs-2"><i class="fa fa-envelope fa-lg"></i>
                                    </div>
                                    <div class="col-xs-8 "> Message</div>
                                    <div class="col-xs-2 text-right"><i class="fa fa-chevron-right"></i>
                                    </div>
                                </a>
                            </div>-->
                        </section>
                        <!-- /.sidebar -->
                      </aside>';
        return $data;
    }

    public function footer() {
        $data = '<footer class="main-footer">
                    <div class="pull-right hidden-xs">
                    </div>
                      <strong>Copyright &copy; 2014-2015  All rights reserved.</strong>
                  </footer>
                  <!-- Modal -->
                  <div id="Logout" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Sign Out</h4>
                          </div>
                          <div class="modal-body">
                            <p>Are you Sign Out Biovalys System ?</p>
                          </div>
                          <div class="modal-footer">
                            <a type="button" href="' . base_url('member/logout') . '" class="btn btn-primary">Sign Out</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- End Modal -->
                  
                  <!-- Modal order -->
                  <div id="order" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"><i class="fa fa-cart-plus"></i>
 Order Product</h4>
                          </div>
                          <div class="modal-body">
                            <p>Are You Order Product ?</p>
                          </div>
                          <div class="modal-footer">
                            <a type="button" href="#" class="btn btn-primary order-now">Order</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- End Modal -->
                  
                  <!-- Modal order -->
                  <div id="delorder" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Delete Order This Product</h4>
                          </div>
                          <div class="modal-body">
                            <p>Are You Delete Order Product ?</p>
                          </div>
                          <div class="modal-footer">
                            <a type="button" href="#" class="btn btn-danger del-order">Delete</a>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- End Modal -->
                  
                  <!-- Modal Change Password -->
                  <div class="modal fade change-password" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Change Password</h4>
                          </div>
                          <div class="modal-body">
                            '.form_open(base_url('member/change_password'),'class="change-password-form"').'
                                <div class="form-group">
                                    '.form_label('Old password <span style="color: red;">*</span>').'
                                    '.form_password(array(
                                        'class' => 'form-control password_old',
                                        'name' => 'password_old',
                                    )).'
                                    <p class="alert_password_old" style="color: red;font-size:12px; display: none;">* Enter Keyword Old password</p>
                                </div>
                                <div class="form-group">
                                    '.form_label('New password <span style="color: red;">*</span>').'
                                    '.form_password(array(
                                        'class' => 'form-control password_new',
                                        'name' => 'password_new',
                                    )).'
                                    <p class="alert_password_new" style="color: red;font-size:12px; display: none;">* Enter Keyword New password</p>
                                </div>
                                <div class="form-group">
                                    '.form_label('Renew password <span style="color: red;">*</span>').'
                                    '.form_password(array(
                                        'class' => 'form-control password_renew',
                                        'name' => 'password_renew',
                                    )).'
                                    <p class="alert_password_renew1" style="color: red;font-size:12px; display: none;">* Enter Keyword Renew password</p>
                                    <p class="alert_password_renew2" style="color: red;font-size:12px; display: none;">* Renew password not math</p>
                                </div>
                            '.form_close().'
                          </div>
                          <div class="modal-footer">
                                '.form_button(array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-primary change_password',
                                    'content' => 'Change',
                                )).'
                                    
                                '.form_button(array(
                                    'type' => 'button',
                                    'class' => 'btn btn-default',
                                    'content' => 'Close',
                                    'data-dismiss' => 'modal'
                                )).'
                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- End Modal -->
                  
                  <!-- Control Sidebar -->
                </div><!-- ./wrapper -->
                <!-- FastClick -->
                <script src="../../plugins/fastclick/fastclick.min.js"></script>
                <!-- AdminLTE for demo purposes -->
                <script src="../../dist/js/demo.js"></script>
                <script src="' . base_url() . 'assets/js/map.js"></script>
                <script src="' . base_url() . 'assets_sitecontrol/js/bootstrap-select.min.js"></script>
                <script src="' . base_url() . 'assets/js/jquery.slimscroll.min.js"></script>
                <script src="' . base_url() . 'assets/js/scroll.js"></script>
                <script src="' . base_url() . 'assets_sitecontrol/js/bootstrap-datepicker.js"></script>
                <!-- AdminLTE App -->
               
                <script src="' . base_url() . 'assets/js/app.js"></script>
                
                <script>
                $(function () {
                    $("<script/>", {
                        "type": "text/javascript",
                        src: "https://maps.googleapis.com/maps/api/js?key=AIzaSyA813uDIQsMGU8WchkqB4EhZoeoaOnFMRk&sensor=false&language=th&callback=initialize&libraries=places"
                    }).appendTo("body");
                    
                    $(\' .datepicker \').datepicker({
                    format: "dd/mm/yyyy",
                   
                }).on(\'changeDate\', function (ev) {
                    $(this).datepicker(\'hide\');
                });
                $(\' .datepicker_month \').datepicker({
                    viewMode: "months",
                    format: "mm/yyyy",
                   
                }).on(\'changeDate\', function (ev) {
                    $(this).datepicker(\'hide\');
                });
                    
                });
                </script>
                 
                <div id="base_url" style="display:none;">' . base_url() . '</div>
               
              </body>
            </html>';
        return $data;
    }

    private function convert_mount($date) {
        $date = strtotime($date);
        return date('M. Y', $date);
    }

}
