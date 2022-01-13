<!-- geonest -->

<!DOCTYPE html>







<html lang="en">



<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">







  <title>



    <?php


    if (isset($page_title)) {







      echo $page_title;

    } else {

      echo 'Free live bees';

    }



    ?>



  </title>







  <base href="<?php echo base_url() ?>">

  <!-- ***********************    08/06/2021       ******************************* -->

  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" /> -->



  <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lato-font/3.0.0/css/lato-font.min.css" integrity="sha512-rSWTr6dChYCbhpHaT1hg2tf4re2jUxBWTuZbujxKg96+T87KQJriMzBzW5aqcb8jmzBhhNSx4XYGA6/Y+ok1vQ==" crossorigin="anonymous" /> -->





  <!-- ******************************************************************** -->





  <meta name="viewport" content="width=device-width, initial-scale=1">







  <link rel="manifest" href="<?php echo base_url() ?>manifest.json">















  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">



  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">







  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>







  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>







  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



  <!---newly add -->



  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">













  <link rel="stylesheet" href="fancybox/source/jquery.fancybox.css">







  <script src="fancybox/source/jquery.fancybox.js"></script>







  <link rel="stylesheet" href="assets/custom.css">







  <style>

    i.my_icon {

      height: 30px;

    }



    #togglePassword {



      right: 18px;



      top: 9px;



      position: absolute;



    }



    .togglePasswordLogin {



      top: 35px !important;



    }



    .signup-area,

    .login-area {}



    .login-form {



      padding: 5px 20px;



      border-radius: 5px;



      background: #fff;



      box-shadow: 2px 2px 11px 2px rgb(148 147 133);



      margin: 10px 0 0 0;



    }



    .padleft0 {

      padding-left: 0;

    }







    .navbar-fixed-bottom {

      display: none;

    }







    #form_id_div {

      padding-top: 4%;

    }







    @media (min-width: 979px) {}







    @media (min-width: 320px) and (max-width: 768px) {



      .badge-notify,

      .linotify {

        display: none !important;

      }



      .login-page {







        padding: 0 0;







      }















      .navbar-fixed-bottom {

        display: block;















      }







      body {







        padding-bottom: 150px;







      }







      #searchBtn {







        background-color: rgb(252, 227, 3);







        top: 21%;







      }







      #nested_total {







        background: rgb(252, 227, 3);















        top: 21%;







      }















      .xs-hidden {

        display: none !important;

      }







    }























    #btnFilladdress:hover {

      color: red;

    }







    #formatted_address {

      background: rgb(245, 221, 4);

      text-align: center

    }







    #btnFilladdress {







      cursor: pointer;







    }















    .alert {

      /* z-index: 3;







    position: absolute;







    right: 0;







    width: 50%;*/







      z-index: 9999;







      position: fixed;







      width: 100%;







      text-align: center;







      top: 0;







      padding: 27px 0;

    }







    #userAvatar {

      width: 38px;



      border-radius: 1px;



      display: inline-block;







      margin: 0 3px 0 0;

    }







    .badge-notify {







      background: red;



      top: 10px;



      right: 8px;



      width: auto;



      padding: 2px 5px 2px 4px;



      position: absolute;







    }







    .hidden {

      display: none;

    }







    .logo {

      margin: -7px 0 0 0;

      height: 38px;

    }







    #moileUl li {

      display: inline-block;

      width: 23%;

    }







    #moileUl {

      margin: 0;

    }























    #moileUl li a {

      padding: 5px 5px 0 5px;







      text-align: center;

    }







    #moileUl li a i {

      display: block;

      font-size: 25px;

    }















    /*.navbar-right li a .glyphicon {*/

    /*  display: block;*/

    /*  font-size: 25px;*/

    /*}*/

.navbar-right{
    display:flex;
    align-items: center;
}
@media screen and (max-width: 766px) {
  .navbar-right{
    flex-direction: column !important;
    
  }
}




    #navbar ul li a i {

      display: block;

      font-size: 25px;

    }







    #navbar ul li {

      text-align: center;

    }



    .verify_button {

      background-color: #FCE303;

      color: black;

      border: 1px solid black;

      padding: 5px 10px;

      outline: none;

    }



    span.my_badge {

      position: relative;

      right: 18px;

      bottom: 8px;

      background-color: red;



    }

  </style>















</head>































<body>







  



  







  



    













  



  



  <?php







  $homeActive = '';







  $arr = $this->uri->rsegment_array();







  if ($arr[1] == 'map' and $arr[2] == 'index') {







    $homeActive = 'active';

  }







  ?>







  <div class="alert" style="display:none"></div>
<div id="msgs" class="alert" style="display:none"></div>







  <div class="navbar navbar-default navbar-fixed-bottom">







    <div class="container">







      <ul class="nav navbar-nav " id="moileUl">







        <li class="<?= $homeActive ?>"><a href="<?php echo base_url() . 'map'; ?>"> <i class="glyphicon glyphicon-search"></i> Rechercher </a></li>

        <li class="<?= getActive('complete') ?>"><a href="<?php echo base_url() . 'complete' . $url ?>"><i class="my_icon glyphicon glyphicon-list-alt"></i><?= lang("reporting"); ?> </a></li>







        <?php

        $d = getnav();

        if (count($d) > 0) {



          foreach ($d as $val) {



            if (isset($_SESSION['lang']) && $_SESSION['lang'] == 'english') {

              $slug_title_val = $val['title_english'];

            } else {

              $slug_title_val = $val['title_french'];

            }



            echo '<li class="xs-hidden"><a href="' . $val['slug'] . '"><i class="' . $val['icon_class'] . '"></i>' .  $slug_title_val . '</a></li>';

          }

        }



        ?>















        <?php



        $d = getnav();



        if (count($d) > 0) {



          foreach ($d as $val) {



            echo '<li><a href="' . $val['slug'] . '"><i class="' . $val['icon'] . '"></i>' . $val['title'] . '</a></li>';

          }

        }







        ?>

        <li class="hidden <?= getActive('utilisation-et-contact') ?>"><a href="utilisation-et-contact"><i class="glyphicon glyphicon-envelope"></i>Contact</a></li>













      </ul>







    </div>







  </div>







  <nav class="navbar navbar-default navbar-fixed-top ">







    <div class="container">







      <div class="navbar-header">







        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">







          <span class="sr-only">Toggle navigation</span>







          <span class="icon-bar"></span>







          <span class="icon-bar"></span>







          <span class="icon-bar"></span>







        </button>



        <? //lang('btn_submit')

        ?>







        <a class="navbar-brand" href="<?php echo base_url() . 'map' ?>"><span id="api_brand"> Free Live Bees</span><span id="identify">Essaims libres</span></a>

























      </div>















      <div style="background-color: #FCE303;" id="navbar" class="navbar-collapse collapse">







        <ul class="nav navbar-nav ">







          <li class="<?= $homeActive ?> xs-hidden"><a href="<?php echo base_url() . 'map' ?>"> <i class="my_icon glyphicon glyphicon-search"></i><?= lang('search') ?> </a></li>



          <li class="<?= getActive('complete') ?> xs-hidden"><a href="<?php echo base_url() . 'complete' . $url ?>"><i class="my_icon glyphicon glyphicon-list-alt"></i><?= lang("reporting"); ?> </a></li>

 <li class="<?= getActive('leproject') ?> xs-hidden"><a href="<?php echo base_url() . 'leproject' . $url ?>"><i class="my_icon glyphicon glyphicon-list-alt"></i><?= lang("leproject"); ?> </a></li>



























        </ul>







        <ul class=" nav navbar-nav navbar-right">



          <?php



          $u =  $this->session->userdata();



          $avatar = base_url() . 'uploads/' . $u['image'];



          if ($u['image'] == 'noimg.png') {



            $avatar = base_url() . 'uploads/noimage.jpg';

          }







          if ($this->session->userdata('userlogin') == 1) {











          ?>





            <li class="dropdown hidden">



              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-comment"></span><span class="badge badge-notify"><?= getunreadCount(); ?></span></a>







              <ul class="dropdown-menu">



                <?php



                $notidata = getNotification();



                if ($notidata->num_rows() > 0) {



                  foreach ($notidata->result() as $noti) {



                    $url = 'javascript:void(0)';



                    if ($noti->resource_type == 'nest') {



                      $url = 'map/nestdetail/' . $noti->resource_id . '?notification=true';

                    }



                ?>



                    <li><a href="<?= $url ?>"><?= ucfirst($noti->body) ?></a></li>







                <?php }

                } ?>



                <li role="separator" class="divider"></li>



                <li><a href="notifications" data-toggle="tooltip" title="See All notifications">See All</a></li>



              </ul>



            </li>

            <?php

            $notifications = 0;

            if (isset($_SESSION['user_id'])) {

              $notifications = get_notifications();

            }

            if ($notifications != 0) {



            ?>







              <li class="">







                <a href="javascript:void(0)" onclick="get_conversations()" class=""><span class="glyphicon glyphicon-comment"></span>







                  <span class="badge badge-notify"><?= $notifications; ?></span>







                </a>

              </li>

            <?php } ?>





            <li class="dropdown">



              <a href="#" id="dropdownProfile_a" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img id="userAvatar" class="img-responsive" src="<?= $avatar ?>"><?= $this->session->userdata('name') ?> <span class="caret"></span></a>



              <ul class="dropdown-menu">



                <li><a href="user/profile"><?= lang("profile"); ?></a></li>



                <li><a href="<?php echo base_url() . "chat/getconversations"; ?>">Messages</a></li>





                <li><a href="auth/userlogout" data-toggle="tooltip" title="logout"><?= lang("signout"); ?></a></li>



              </ul>



            </li>

















          <?php } else { ?>





            <li class="<?= getActive('signup') ?>"><a data-toggle="tooltip" title="Registration" href="signup"><span class="glyphicon glyphicon-user"></span> <?= lang("register"); ?></a></li>



            <li class="<?= getActive('login') ?>"><a href="login"><span class="glyphicon glyphicon-log-in"></span> <?= lang("login"); ?> </a></li> <?php } ?>

          <li class="lang2">

           



            <select id="language2">



              <option class="lang" <?php echo selected($_SESSION['lang'], "french"); ?> value="french">Fr</option>

              <option class="lang" <?php echo selected($_SESSION['lang'], "english"); ?> value="english">Eng</option>

            </select>

          </li>



        </ul>















      </div>

      <!--/.nav-collapse -->







    </div>







  </nav>























  <div id="loader" class="hidden">







    <div id="loading-img" class="centered">















      <img src="assets/loader.gif">







    </div>















  </div>

  <!-- *****************08/06/2021***************** -->





  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js">

  </script> -->





  <!-- **************************************************-->











  <script>

    function get_conversations() {

      window.location.href = "<?php echo base_url() . 'chat/getconversations'; ?>";

    }



    function conversion(val)



    {



      var formData = new FormData();



      formData.append('lang', val);



      $.ajax({



        type: "POST",



        url: "<?php echo base_url() . 'Home/changelang'; ?>",



        data: formData,



        cache: false,



        contentType: false,



        processData: false,



        dataType: 'JSON',







        success: function(data) {



          if (data.status == 200)



          {



            location.reload();



          }



          if (data.status == 100)



          {



            alert('error');



          }







        }



      });



    }

    $("#language2").on("change", function() {



      let val = $(this).val();

      $.ajax({

        url: "<?php echo base_url() . 'page/set_lang' ?>",

        type: "POST",

        data: {

          lang: val

        },

        success: function(success) {

          // alert(success)

          location.reload();

        }





      })

    });

  </script>