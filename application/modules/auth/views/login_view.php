<!DOCTYPE html>

<html>

<head>

  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>ADMIN | Log in</title>

  <base href="<?php echo base_url(); ?>">

  <!-- Tell the browser to be responsive to screen width -->

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Bootstrap 3.3.7 -->

  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">

  <!-- Font Awesome -->

  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">

  <!-- Ionicons -->

  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">

  <!-- Theme style -->

  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">

  <!-- iCheck -->

  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">



  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

  <!--[if lt IE 9]>

  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>

  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

  <![endif]-->



  <!-- Google Font -->

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <style>
    .login-page,
    .register-page {

      background: url(assets/background-login.jpg);

      background-repeat: no-repeat;

      background-size: 100%;

    }

    .login-logo a,
    .register-logo a {

      color: #fff;

    }

    .login-box-body,
    .register-box-body {

      background: #aa9bff;

      padding: 20px;

      border-top: 0;

      color: #fff;

      border-radius: 5px;

      box-shadow: 2px 4px 10px 1px #010206;

    }



    .btn-primary {

      background-color: #6a50ff;

      box-shadow: 1px 0px 2px 1px !important;

      border: none;

      border-radius: 10px !important;

    }

    body.hold-transition {
      background: radial-gradient(circle, rgba(63, 94, 251, 1) 0%, rgba(252, 70, 251, 0.6166841736694677) 100%);
    }
  </style>

</head>

<body class="hold-transition login-page">

  <div class="login-box">

    <div class="login-logo">

      <a href=""><?= APP_NAME ?></a>

    </div>

    <!-- /.login-logo -->

    <div class="login-box-body">

      <p class="login-box-msg">Sign in to start your session</p>



      <form method="post" action="<?php echo base_url(); ?>auth/login">

        <?php

        if (isset($message)) {



          echo  '<div class="alert alert-danger">' . $message . '</div>';
        }

        ?>

        <div class="form-group has-feedback">

          <input type="email" class="form-control" value="" name="identity" placeholder="Email">

          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

        </div>

        <div class="form-group has-feedback">

          <input type="password" class="form-control" value="" name="password" placeholder="Password">

          <span class="glyphicon glyphicon-lock form-control-feedback"></span>

        </div>

        <div class="row">

          <div class="col-xs-8 hidden">

            <div class="checkbox icheck">

              <label>

                <input type="checkbox" name="remember"> Remember Me

              </label>

            </div>

          </div>

          <!-- /.col -->

          <div class="col-xs-4">

            <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>

          </div>

          <!-- /.col -->

        </div>

      </form>







      <a href="#" class="col-xs-8 hidden">I forgot my password</a><br>



    </div>

    <!-- /.login-box-body -->

  </div>

  <!-- /.login-box -->



  <!-- jQuery 3 -->

  <script src="bower_components/jquery/dist/jquery.min.js"></script>

  <!-- Bootstrap 3.3.7 -->

  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- iCheck -->

  <script src="plugins/iCheck/icheck.min.js"></script>

  <script>
    $(function() {

      $('input').iCheck({

        checkboxClass: 'icheckbox_square-blue',

        radioClass: 'iradio_square-blue',

        increaseArea: '20%' // optional

      });

    });
  </script>

</body>

</html>