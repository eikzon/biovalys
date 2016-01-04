<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_admin_template extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('model_admin_order');
        $this->load->model('model_admin_report');
    }

    public function gen($val = '') {
        if(empty($val)){
            $session = $this->session->userdata('username');
            if (empty($session) || $session < 0) {
                $cookie = $this->get_cookie_bio();
                if (isset($cookie) && !empty($cookie)) {
                    $this->load->model('model_admin_member');
                    $data = $this->model_admin_member->member_data(array('member_id' => $cookie));
                    if (isset($data) && !empty($data)) {
                        $this->model_admin_member->gen_session($data);
                    } else {
                        $arr = array('title' => 'Please Login', 'detail' => 'can\'t Access Please Login  ', 'url' => base_url('sitecontrol/login'));
                        echo $this->model_utility->alert($arr);
                        exit;
                    }
                } else {
                    $arr = array('title' => 'Please Login', 'detail' => 'can\'t Access Please Login  ', 'url' => base_url('sitecontrol/login'));
                    echo $this->model_utility->alert($arr);
                    exit;
                }
            }
        }
        $temp = array('head' => $this->head(),
            'nav_bar' => $this->nav_bar(),
            'menu' => $this->menu(),
            'footer' => $this->footer());
        return $temp;
    }

    public function head() {
        $data = '<!DOCTYPE html>
                    <html>
                    <head>
                        <meta charset="utf-8">
                        <meta http-equiv="X-UA-Compatible" content="IE=edge">
                        <title>Biovalys Admin</title>
                        <!-- boostrap css -->
                        <link href="' . base_url() . 'assets_sitecontrol/css/vendors/bootstrap.css" rel="stylesheet" type="text/css">
                        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
                        <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css">

                        <!-- style css -->
                        <link href="' . base_url() . 'assets_sitecontrol/css/AdminLTE.css" rel="stylesheet" type="text/css">
                        <link href="' . base_url() . 'assets_sitecontrol/css/style.css" rel="stylesheet" type="text/css">
                        <link href="' . base_url() . 'assets_sitecontrol/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
                        <link href="' . base_url() . 'assets_sitecontrol/css/datepicker.css" rel="stylesheet" type="text/css">
                        <link href="' . base_url() . 'assets_sitecontrol/css/multi-select.css" rel="stylesheet">

                        <!-- Just for debugging purposes. Don\'t actually copy these 2 lines! -->
                        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
                        <script src="' . base_url() . 'assets_sitecontrol/js/ie-emulation-modes-warning.js"></script>

                        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
                        <!--[if lt IE 9]>
                          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
                        <![endif]-->

                    </head>
                    <!-- ADD THE CLASS sidedar-collapse TO HIDE THE SIDEBAR PRIOR TO LOADING THE SITE -->';
        return $data;
    }

    public function nav_bar() {
        $noti_order = $this->model_admin_order->order_noti();
//        print_r($noti_order);
        $data = '<body class="hold-transition skin-blue sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="' . base_url('sitecontrol') . '" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->

                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Biovalys</b></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        <!-- <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope-o"></i>
                                <span class="label label-success">4</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 4 messages</li>
                                <li> -->
                                    <!-- inner menu: contains the messages -->
                                    <!-- <ul class="menu">
                                        <li>
                                            <!-- start message -->
                                            <!-- <a href="#">
                                                <div class="pull-left">
                                                    <!-- User Image -->
                                                    <!-- <img src="' . base_url() . 'assets_sitecontrol/img/user/user2-160x160.jpg" class="img-circle" alt="User Image">
                                                </div>
                                                <!-- Message title and timestamp -->
                                                <!-- <h4>
                                                    Support Team
                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                </h4>
                                                <!-- The message -->
                                                <!-- <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <!-- end message -->
                                        <!-- <li>
                                            <!-- start message -->
                                            <!-- <a href="#">
                                                <div class="pull-left">
                                                    <!-- User Image -->
                                                    <!-- <img src="' . base_url() . 'assets_sitecontrol/img/user/user2-160x160.jpg" class="img-circle" alt="User Image">
                                                </div>
                                                <!-- Message title and timestamp -->
                                                <!-- <h4>
                                                    Support Team
                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                </h4>
                                                <!-- The message -->
                                                <!-- <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <!-- end message -->
                                        <!-- <li>
                                            <!-- start message -->
                                            <!-- <a href="#">
                                                <div class="pull-left">
                                                    <!-- User Image -->
                                                    <!-- <img src="' . base_url() . 'assets_sitecontrol/img/user/user2-160x160.jpg" class="img-circle" alt="User Image">
                                                </div>
                                                <!-- Message title and timestamp -->
                                                <!-- <h4>
                                                    Support Team
                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                </h4>
                                                <!-- The message -->
                                                <!-- <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <!-- end message -->
                                        <!-- <li>
                                            <!-- start message -->
                                            <!-- <a href="#">
                                                <!-- <div class="pull-left">
                                                    <!-- User Image -->
                                                    <!-- <img src="' . base_url() . 'assets_sitecontrol/img/user/user2-160x160.jpg" class="img-circle" alt="User Image">
                                                </div>
                                                <!-- Message title and timestamp -->
                                                <!-- <h4>
                                                    Support Team
                                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                                </h4>
                                                <!-- The message -->
                                                <!-- <p>Why not buy a new awesome theme?</p>
                                            </a>
                                        </li>
                                        <!-- end message -->
                                    <!-- </ul> -->
                                    <!-- /.menu -->
                                <!-- </li>
                                <li class="footer"><a href="#">See All Messages</a>
                                </li>
                            </ul>
                        </li> -->
                        
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bell-o"></i>';
        if (count(@$noti_order) > 0) {
            $data .= '<span class="label label-warning">' . count($noti_order) . '</span>';
        }
        $data .= '</a>';
        if (count(@$noti_order) > 0) {
            $data .= '<ul class="dropdown-menu">
                                        <li class="header">You have ' . count($noti_order) . ' notifications</li>
                                        <li>
                                            <ul class="menu">';
            foreach ($noti_order as $mes) {
                $data .= '<li>
                                                    <a href="' . base_url("/sitecontrol/order/edit/" . $mes['d_type'] . "/" . $mes['d_id'] . "") . '">
                                                        <!--<i class="fa fa-users text-aqua"></i>--> Order ID : ' . $mes['d_code'] . '
                                                            <p><span style="float: right;">Date : ' . $mes['d_date'] . '</span></p>
                                                    </a>
                                                </li>';
            }
            $data .= '
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">View all</a>
                                </li>
                            </ul>';
        }

        $data .= '</li>
                        <li class="dropdown user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="' . base_url() . $this->session->userdata('picture') . '" class="user-image" alt="User Image">
                                <span class="hidden-xs">' . $this->session->userdata('username') . '  <b class="caret"></b></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="' . base_url("sitecontrol/member/edit") . "/" . $this->session->userdata('id') . '"><i class="fa fa-user"></i> User Profile</a>
                                </li>
                                <!-- <li><a href="#"><i class="fa fa-inbox"></i> Inbox</a>
                                </li> -->
                                <li><a href="#" data-toggle="modal" data-target="#change_pass"><i class="fa fa-lock"></i> Change Password</a>
                                </li>
                                <li><a href="#" data-toggle="modal" data-target="#Logout"><i class="fa fa-power-off"></i> Log out</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- =============================================== -->
';
        return $data;
    }

    public function menu() {
        $uri2 = $this->uri->segment(2);
        $dashboard = (empty($uri2)) ? 'active' : '';
        $member = (@$uri2 == 'member') ? 'active' : '';
        $customer = (@$uri2 == 'customer') ? 'active' : '';
        $zone = (@$uri2 == 'zone') ? 'active' : '';
        $order = (@$uri2 == 'order') ? 'active' : '';
        $product = (@$uri2 == 'product') ? 'active' : '';
        $report = (@$uri2 == 'report') ? 'active' : '';
        $data = ' <!-- Left side column. contains the sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <ul class="sidebar-menu">
                    <li class="' . $dashboard . '">
                        <a href="' . base_url('sitecontrol') . '">
                            <i class="fa fa-bar-chart"></i> <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="' . $member . '">
                        <a href="' . base_url('sitecontrol/member') . '"> <i class="fa fa-users"></i> <span> Sales Member</span>
                        </a>
                    </li>
                    <li class="' . $customer . $zone . '">
                        <a href="' . base_url('sitecontrol/customer') . '"><i class="fa fa-hospital-o"></i> <span> CA Customer</span> <i class="fa fa-angle-left pull-right"></i></a>
                        <ul class="treeview-menu">
                            <li class="' . $zone . '"><a href="' . base_url('sitecontrol/zone') . '"><i class="fa fa-hospital-o"></i> <span> Area</span></a></li>
                            <li class="' . $customer . '"><a href="' . base_url('sitecontrol/customer') . '"><i class="fa fa-hospital-o"></i> <span> CA List</span></a></li>
                        </ul>
                    </li>
                    <li class="' . $order . '">
                        <a href="' . base_url('sitecontrol/order') . '"> <i class="fa fa-list-alt"></i> <span>Sale Order</span>
                        </a>
                    </li>
                    <li class="' . $product . '">
                        <a href="' . base_url('sitecontrol/product') . '"><i class="fa fa-cubes"></i> <span> Product</span></a>
                    </li>
                    <li class="' . $report . '">
                        <a href="' . base_url('sitecontrol/report') . '"><i class="fa fa-file-text-o"></i> <span>Report</span></a>
                    </li>
                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>
        <!-- =============================================== -->
';
        return $data;
    }

    public function footer() {
        //DONUT CHART
        $array_donut = $this->model_admin_report->donut_chart();
        $data_donut = explode("##", $array_donut);
        $total_approve = $data_donut[0];
        $total_reject = $data_donut[1];
        $total_waiting = $data_donut[2];
        //BAR CHART
        $total_bar = $this->model_admin_report->bar_chart();

        $data = '
        <footer class="main-footer text-center">

            <strong>Copyright &copy; 2015 Biovalys Admin V 1.0</strong>
        </footer>
        
        <!-- Modal -->
        <div class="modal fade" id="change_pass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <form name="form" method="post" action="' . base_url('sitecontrol/member/changepass') . '" onsubmit="return form_changepass()">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel">Change password</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label>Old Password :</label>
                                    <input type="password" name="old_pass" id="old_pass" class="form-control" placeholder="Old password">
                                    <span id="text_old_pass" style="color:red"><br>กรุณาระบุรหัสผ่านเดิม</span>
                                    <span id="text_old_pass_false" style="color:red"><br>รหัสผ่านเดิมผิด</span>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label>New Password</label>
                                    <input type="password" name="new_pass" id="new_pass" class="form-control" placeholder="New password">
                                    <span id="text_new_pass" style="color:red"><br>กรุณาระบุรหัสผ่านใหม่</span>
                                    <span id="text_new_no_match" style="color:red"><br>รหัสผ่านใหม่และยินยันรหัสผ่านใหม่ไม่เหมือนกัน</span>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label>Confirm New Password</label>
                                    <input type="password" name="confirm_pass" id="con_new_pass" class="form-control" placeholder="Confirm new password">
                                    <span id="text_con_new_pass" style="color:red"><br>กรุณาระบุยืนยันรหัสผ่านใหม่</span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="submit_changepass" class="btn btn-primary">Save changes</button>
                        </div>
                        <input type="hidden" name="link_page" value="http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '">
                        <input type="hidden" name="link_url" id="link_url" value="' . base_url('sitecontrol/member/checkpass') . '">
                    </div>
                </form>
            </div>
        </div>
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
                <a type="button" href="' . base_url('sitecontrol/login/logout') . '" class="btn btn-primary">Sign Out</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        <div id="func_alert" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title alert-title">Function Alert</h4>
                    </div>
                    <div class="modal-body alert-body">
                        <p>Body Data</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-del">OK</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <a data-toggle="modal" data-target="#func_alert" id="func_alert_click"></a>
        <div id="func_notificate" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title notificate-title">Function Alert</h4>
                    </div>
                    <div class="modal-body notificate-body">
                        <p>Body Data</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">OK</button>
                        <!--<button type="button" class="btn btn-default" >Close</button>-->
                    </div>
                </div>
            </div>
        </div>
        <a data-toggle="modal" data-target="#func_notificate" id="func_notificate_click"></a>
        <!-- End Modal -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="' . base_url() . 'assets_sitecontrol/js/jquery.min.js"></script>

    <!-- Bootstrap 3.3.5 -->
    <script src="' . base_url() . 'assets_sitecontrol/js/bootstrap.min.js"></script>
    <!-- plug in js -->
    <script src="' . base_url() . 'assets_sitecontrol/js/jquery.slimscroll.min.js"></script>
    <script src="' . base_url() . 'assets_sitecontrol/js/bootstrap-select.min.js"></script>
    <script src="' . base_url() . 'assets_sitecontrol/js/bootstrap-datepicker.js"></script>
    <!-- AdminLTE App -->
    <script src="' . base_url() . 'assets_sitecontrol/js/app.js"></script>
    <!-- Flot Graph js -->
    <script src="' . base_url() . 'assets_sitecontrol/js/flot/jquery.flot.js"></script>
    <script src="' . base_url() . 'assets_sitecontrol/js/flot/jquery.flot.pie.js"></script>
    <script src="' . base_url() . 'assets_sitecontrol/js/flot/jquery.flot.categories.min.js"></script>
    <script src="' . base_url() . 'assets_sitecontrol/js/script.js"></script>
    <!-- menu open when hover -->
    <script src="' . base_url() . 'assets_sitecontrol/js/jquery.multi-select.js"></script>
    <script type="text/javascript">
        $("#my-select").multiSelect();
        member_name($("#zone_id").val());
    </script>
    <script>
        $(function () {
            $(".dropdown").hover(
                function () {
                    $(\'.dropdown-menu\', this).stop(true, true).fadeIn("fast");
                    $(this).toggleClass(\'open\');

                },
                function () {
                    $(\'.dropdown-menu\', this).stop(true, true).fadeOut("fast");
                    $(this).toggleClass(\'open\');

                });
                
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
    <script>
        $(function () {
            /*
             * DONUT CHART
             * -----------
             */

            var donutData = [
                {
                    label: "Approve",
                    data: ' . $total_approve . ',
                    color: "#27ae60"
                },
                {
                    label: "Reject",
                    data: ' . $total_reject . ',
                    color: "#dd4b39"
                },
                {
                    label: "Waiting",
                    data: ' . $total_waiting . ',
                    color: "#F4B350"
                },
        ];
            $.plot("#donut-chart", donutData, {
                series: {
                    pie: {
                        show: true,
                        radius: 1,
                        label: {
                            show: true,
                            radius: 2 / 3,
                            formatter: labelFormatter,
                            threshold: 0.1
                        }

                    }
                },
                legend: {
                    show: false
                }
            });
            /*
             * END DONUT CHART
             */
             
            /*
             * BAR CHART
             * ---------
             */

            var bar_data = {
                data: [' . $total_bar . '],
                color: "#3c8dbc",
            };
            $.plot("#bar-chart", [bar_data], {
                grid: {
                    borderWidth: 1,
                    borderColor: "#f3f3f3",
                    tickColor: "#f3f3f3"
                },
                series: {
                    bars: {
                        show: true,
                        barWidth: 0.5,
                        align: "center"
                    }
                },
                xaxis: {
                    mode: "categories",
                    tickLength: 0
                }
            });
            /* END BAR CHART */

            /*
             * LINE CHART
             * ----------
             */
            //LINE randomly generated data

            var sin = [],
                cos = [];
            for (var i = 0; i < 14; i += 0.5) {
                sin.push([i, Math.sin(i)]);
                cos.push([i, Math.cos(i)]);
            }
            var line_data1 = {
                data: sin,
                color: "#3c8dbc"
            };
            var line_data2 = {
                data: cos,
                color: "#00c0ef"
            };
            $.plot("#line-chart", [line_data1, line_data2], {
                grid: {
                    hoverable: true,
                    borderColor: "#f3f3f3",
                    borderWidth: 1,
                    tickColor: "#f3f3f3"
                },
                series: {
                    shadowSize: 0,
                    lines: {
                        show: true
                    },
                    points: {
                        show: true
                    }
                },
                lines: {
                    fill: false,
                    color: ["#3c8dbc", "#f56954"]
                },
                yaxis: {
                    show: true,
                },
                xaxis: {
                    show: true
                }
            });
            //Initialize tooltip on hover
            $(\'<div class="tooltip-inner" id="line-chart-tooltip"></div>\').css({
                position: "absolute",
                display: "none",
                opacity: 0.8
            }).appendTo("body");
            $("#line-chart").bind("plothover", function (event, pos, item) {

                if (item) {
                    var x = item.datapoint[0].toFixed(2),
                        y = item.datapoint[1].toFixed(2);

                    $("#line-chart-tooltip").html(item.series.label + " of " + x + " = " + y)
                        .css({
                            top: item.pageY + 5,
                            left: item.pageX + 5
                        })
                        .fadeIn(200);
                } else {
                    $("#line-chart-tooltip").hide();
                }

            });
            /* END LINE CHART */

        });

        /*
         * Custom Label formatter
         * ----------------------
         */
        function labelFormatter(label, series) {
            return \'<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">\' + label + "<br>" + Math.round(series.percent) + "%</div>";
        }
    </script>
    



</body>

</html>';
        return $data;
    }

    public function get_cookie_bio() {
        $data = $this->input->cookie('biovalys', TRUE);
        if ($data <> '' && isset($data)) {
            $data = $this->model_utility->encrypt_decode($data);
        } else {
            $data = '';
        }
        return $data;
    }

}
