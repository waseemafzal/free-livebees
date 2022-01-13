<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo APP_NAME;?> </title>
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
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="bower_components/jquery-confirm/confirm.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- DateTime picker -->
<link type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" /> 

  <!-- DataTables -->
  <link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
  <link rel="stylesheet" href="fancybox/source/jquery.fancybox.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
<!--  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
-->  <style>
  
.pad0{
	padding:0;
	}
	.user-menu:hover .dropdown-menu{
		display:block !important;
		}
		.textRole{
			    color: #fff;
    margin-top: 14px;
    display: inline-block;
	}
  </style>
  <?php
//  pre($this->session);

  ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">

<?php /*?><script type="text/javascript">
window.onload="googleTranslateElementInit('ar')";


function googleTranslateElementInit(lang) {
	if(lang==''){
		lang='en';
	}
  new google.translate.TranslateElement({pageLanguage: lang, layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<div class="wrapper">
<?php */?>
  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"> RE</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><?php echo APP_NAME;?></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
       <span class="hidden-xs"> <a href="auth/profile" class="textRole"> Hey <?=adminName()?>! You are Logedin as <?=role()?></span></a>
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!--<img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
            
             <i class="fa fa-user"></i><?=adminName()?>
              
              </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
              <?php
			  
			  ?>
                <img src="<?=adminAvatar()?>" class="img-circle" alt="User Image">

                <p>
                 <?php echo '<i class="fa fa-envelop-open"></i>'. $this->session->userdata('email') ?>
                  <!--<small>Member since Nov. 2012</small>-->
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row hidden">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="auth/profile" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="auth/logout" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <!--<li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>-->
        </ul>
      </div>
    </nav>
  </header>
    <style>
       .error{ color:red
	   }
	   .has-error input{ border:1px solid red}
.centered {
  position: fixed;
  top: 50%;
  left: 50%; z-index: 9999;
  /* bring your own prefixes */
  transform: translate(-50%, -50%);
}
#google_translate_element{
    position: absolute;
    right: 6%;
    z-index: 9999;
    top: 12px;
}.goog-te-banner-frame.skiptranslate {
    display: none !important;
    } 
body {
    top: 0px !important; 
    }.goog-te-gadget img {
    vertical-align: middle;
    border: none;
    display: none;
}.goog-te-menu-value {
    text-decoration: none;
    color: #0000cc;
    white-space: nowrap;
    margin-left: 4px;
    margin-right: 2px;
}
       </style> 
        <div id="loader" class="hidden">
    <div id="loading-img" class="centered"> 
    
    <img src="<?php echo base_url(); ?>assets/loader.gif">
    </div>
	
    </div>
  <!-- Left side column. contains the logo and sidebar -->
  
 <?php
 
$this->crud->set_permission($this->session->userdata('user_type'));
 $permission = $this->session->userdata('permission');
//pre($this->session);
 if($this->session->userdata('user_type')==SCHOOL){
	 include"school_aside.php";
	 }
	  if($this->session->userdata('user_type')==ADMIN){
	 include"admin_aside.php";
	 }
	  if($this->session->userdata('user_type')==SUPER_ADMIN){
	 include"aside.php";
	 }
	 
   ?>
<!--   <div id="google_translate_element"></div>-->