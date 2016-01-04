<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class model_utility extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('encrypt');
    }

    public function passwd($arr) {
        if (isset($arr) && !empty($arr)) {
            $rs = '';
            foreach ($arr as $k) {
                $rs .= md5($k);
            }
            return md5($rs);
        }
    }

    public function encrypt_encode($val) {
        return str_replace(array('+', '/', '='), array('-', '_', '~'), $this->encrypt->encode($val));
    }

    public function encrypt_decode($val) {
        return $this->encrypt->decode(str_replace(array('-', '_', '~'), array('+', '/', '='), $val));
    }

    public function check_login() {
        $data = $this->session->userdata('member_data');
        if ($data['member_id'] == '' || !isset($data) || empty($data)) {
            echo '<script>window.location="' . base_url('login') . '";</script>';
            exit();
        }
    }

    public function member_id()// get member_id data from session 
    { 
        $data = $this->session->userdata('member_data');
        return $data['member_id'];
    }
    
    

    public function show_images($arr = '') {
        if ($arr['file'] <> '' && $arr['path'] <> '') {
            $file = $arr['path'] . '/' . $arr['file'];
            if (file_exists($file) == TRUE) {
                return base_url($file);
            } else {
                return base_url('assets/img/NoImage.gif');
            }
        } else {
            return base_url('assets/img/NoImage.gif');
        }
    }

    public function show_file($arr = '') {
        if ($arr['file'] <> '' && $arr['path'] <> '') {
            $file = $arr['path'] . '/' . $arr['file'];
            if (file_exists($file) == TRUE) {
                return base_url($file);
            } else {
                return base_url('assets/img/template/nofile.png');
            }
        } else {
            return base_url('assets/img/template/nofile.png');
        }
    }

    public function do_upload($file, $config) {
        $this->load->library('upload');
        $this->upload->initialize($config);
        if (!$this->upload->do_upload($file)) {
            $data = array('error' => $this->upload->display_errors());
        } else {
            $data = array('upload_data' => $this->upload->data());
        }
        return $data;
    }

    public function send_mail($arr) {
        $from = 'emailtest@genetic-plus.org';
        $fromname = $arr['from'];
        $to = $arr['to'];
        $cc = $arr['cc'];
        $subject = $arr['subject'];
        $message = $arr['message'];
        $this->load->library('email');
        $this->email->initialize(array(
            'charset' => 'utf-8',
            'mailtype' => 'html',
            'protocol' => 'smtp',
            'smtp_host' => 'mail.genetic-plus.org',
            'smtp_user' => 'emailtest@genetic-plus.org',
            'smtp_pass' => 'y3GMjaNiOu',
            'smtp_port' => 25,
            'crlf' => "\n",
            'newline' => "\r\n"
        ));
        $this->email->from($from, $fromname);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->message($message);
        $this->email->send();
    }

    public function alert($arr) {
        $data = '
        <!DOCTYPE html>
                    <html>
                      <head>
                        <meta charset="UTF-8">
                        <title>Biovalys</title>
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

                        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
                        <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
                        <!--[if lt IE 9]>
                            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
                            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
                        <![endif]-->
                      </head>
                      <body>
                      <!-- Modal -->
      
                  <div id="alert" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <!--<button type="button" class="close" data-dismiss="modal">&times;</button>-->
                            <h4 class="modal-title">' . $arr['title'] . '</h4>
                          </div>
                          <div class="modal-body">
                            <p>' . $arr['detail'] . '</p>
                          </div>
                          <div class="modal-footer">
                            <!--<a href="' . $arr['url'] . '" id="submite" class="btn btn-primary" >OK</a>-->
                            <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                          </div>
                        </div>
                      </div>
                    </div>
                  <a href="' . $arr['url'] . '" id="go" ></a>
                  <a data-toggle="modal" data-target="#alert" id="alert_click"></a>
                  <!-- End Modal -->
                  <!-- Control Sidebar -->
                </div><!-- ./wrapper -->
                <!-- jQuery 2.1.4 -->
                <script src="' . base_url() . 'assets/js/jquery.js"></script>
                <!-- Bootstrap 3.3.5 -->
                <script src="' . base_url() . 'assets/js/bootstrap.min.js"></script>
                <!-- FastClick -->
                <!-- AdminLTE App -->
                <script src="' . base_url() . 'assets/js/app.js"></script>
                <!-- AdminLTE for demo purposes -->
                <script>
                $(function () {
                    $("#alert_click").click();
                    setInterval(function(){ 
                        window.location="' . $arr['url'] . '";
                    }, 3000);
                });
                function go()
                {
                    $("#go").click();
                }
                </script>
              </body>
            </html>
        ';
        return $data;
    }

    public function status_control($arr) {
        if ($arr['stat'] == 1) {
            $stat = '<div class="stat' . $arr['id'] . '" style="float:left;"><a href="#" data-toggle="tooltip" data-placement="top" title="Disable" onclick="status(\'' . $arr['id'] . '\',\'' . $arr['stat'] . '\',\'' . $arr['url'] . '\');"><i class="fa fa-times-circle-o fa-lg"></i></i></a></div>';
        } elseif ($arr['stat'] == 2) {
            $stat = '<div class="stat' . $arr['id'] . '" style="float:left;"><a href="#" data-toggle="tooltip" data-placement="top" title="Enable" onclick="status(\'' . $arr['id'] . '\',\'' . $arr['stat'] . '\',\'' . $arr['url'] . '\');"><i class="fa fa-check-square fa-lg"></i></i></a></div>';
        } else {
            $stat = '';
        }
        return $stat;
    }
    
    public function gen_code_ca() {
        $query = $this->db->like('customer_credit_number', 'CA'.date('y'))->count_all_results('bio_customer');
        return 'CA'.date('y').sprintf('%05d', $query+1);
    }
    public function gen_code_so() {
        $query = $this->db->like('order_list_code', 'SO'.date('y'))->count_all_results('bio_order_list');
        return 'SO'.date('y').sprintf('%05d', $query+1);
    }
    public function gen_code_foc() {
        $query = $this->db->like('foc_code', 'FOC'.date('y'))->count_all_results('bio_order_foc');
        return 'FOC'.date('y').sprintf('%05d', $query+1);
    }
    public function gen_code_lo() {
        $query = $this->db->like('ob_code', 'LO'.date('y'))->count_all_results('bio_order_borrow');
        return 'LO'.date('y').sprintf('%05d', $query+1);
    }
    
    public function short_date($date) //convert short date
    {
        $time = strtotime($date);
        return date('d M Y',$time);
    }

}

/* BackEnd Codeigniter V. 2.2.4 stable by Piya by Piya start 25/08/2015 */
/* End of file model_utility.php */
/* Location: ./application/model/model_utility.php */