<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
<!--    <meta http-equiv="X-UA-Compatible" content="IE=edge">-->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Biovalys System</title>
    <!-- boostrap css -->
    <link href="<?PHP echo base_url();?>assets_sitecontrol/css/vendors/bootstrap.css" rel="stylesheet" type="text/css">


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css">

    <!-- style css -->
    <link href="<?PHP echo base_url();?>assets_sitecontrol/css/AdminLTE.css" rel="stylesheet" type="text/css">
    <link href="<?PHP echo base_url();?>assets_sitecontrol/css/bootstrap-select.min.css" rel="stylesheet" type="text/css">
    <link href="<?PHP echo base_url();?>assets_sitecontrol/css/checkbox-radio-switch.css" rel="stylesheet" type="text/css">
    <link href="<?PHP echo base_url();?>assets_sitecontrol/css/style.css" rel="stylesheet" type="text/css">
    <link href="<?PHP echo base_url();?>assets/css/log-in.css" rel="stylesheet" type="text/css">



    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="<?PHP echo base_url();?>assets_sitecontrol/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<!-- ADD THE CLASS sidedar-collapse TO HIDE THE SIDEBAR PRIOR TO LOADING THE SITE -->

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#" style="color:#fff"><b>Sales</b> System</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
           <p class="login-box-msg">Welcome To Biovalys Sales System</p>
            <form action="<?PHP echo base_url('member/login'); ?>" method="post">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Username" name="member_username" required>
                    <span class="fa fa-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" placeholder="Password" name="member_password" required>
                    <span class="fa fa-lock form-control-feedback"></span>
                </div>
                <div class="row">
<!--
                    <div class="col-xs-12">
                        <label class="checkbox" for="checkbox1">

                            <input type="checkbox" value="" id="checkbox1" data-toggle="checkbox"> Remember me

                        </label>
                    </div>
-->
                    <!-- /.col -->
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
<!--
            <br>
            <a href="#">I forgot my password</a>
            <br>
-->


        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <script src="<?PHP echo base_url();?>assets_sitecontrol/js/jquery.min.js"></script>

    <!-- Bootstrap 3.3.5 -->
    <script src="<?PHP echo base_url();?>assets_sitecontrol/js/bootstrap.min.js"></script>
    <!-- plug in js -->
    <script src="<?PHP echo base_url();?>assets_sitecontrol/js/jquery.slimscroll.min.js"></script>
    <script src="<?PHP echo base_url();?>assets_sitecontrol/js/gsdk-checkbox.js"></script>

</body>

</html>