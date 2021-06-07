<!DOCTYPE html>

<html lang="en">



<head>

  <link rel="manifest" href="<?php echo base_url() ?>manifest.json">



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





  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <script>
    function InvalidMsg(textbox) {
      if (textbox.value == '') {
        textbox.setCustomValidity('<?= lang('required_message') ?>');
      } else {
        textbox.setCustomValidity('');
      }
      return true;
    }
  </script>
  <link rel="stylesheet" href="fancybox/source/jquery.fancybox.css">

  <script src="fancybox/source/jquery.fancybox.js"></script>

  <link rel="stylesheet" href="assets/custom.css">

  <style>
    .navbar-fixed-bottom {
      display: none;
    }





    @media (min-width: 320px) and (max-width: 768px) {
      .profile_li ul {}

      .profile_li ul li {
        background-color: #ddd;
      }

      .profile_li ul li a {}


      .navbar-fixed-bottom {
        display: block;



      }


      body {

        padding-top: 52px;

      }



      .xs-hidden {
        display: none !important;
      }

    }

    .hidden,
    .navbar-toggle {
      display: none;
    }



    #moileUl li {
      width: auto;

      margin: 0;

      float: left;

      padding: 0;
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



    .navbar-right li a .glyphicon {
      display: block;
      font-size: 25px;
    }

    #navbar ul li a i {
      display: block;
      font-size: 25px;
      height: auto;
    }

    #navbar ul li {
      text-align: center;
      line-height: 0;
    }
  </style>

  <script type="text/javascript">
    if ('serviceWorker' in navigator)

    {

      //alert('work');

      navigator.serviceWorker.register("<?php echo base_url() ?>sw.js").then(registration => {

        console.log('SW register');

        console.log(registration);



      }).catch(error => {

        console.log('registration Failed');

        console.log(error);



      });

    } else

    {

      // alert('not work')

      console.log('browser not support');

    }
  </script>



  <script type="text/javascript">
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register("<?php echo base_url() ?>sw.js").then(registration => {

        console.log('SW register');

        console.log(registration);



      }).catch(error => {

        console.log('registration Failed');

        console.log(error);



      });

    } else

    {

      // alert('not work')

      console.log('browser not support');

    }
  </script>



</head>



<?php

// 		$homeActive='';

// 		$arr=$this->uri->rsegment_array();

// 		if($arr[1]=='map' and $arr[2]=='index'){

// 			$homeActive='active';

// 			}

?>

<meta name="viewport" content="width=device-width, initial-scale=1">

<body>
  <script>
    $(document).ready(function() {
      setTimeout(function() {
        $("#msgs").hide();
        $("#validation").addClass('hidden');

      }, 3000);


    });
  </script>
  <div id="msgs" class="alert" style="display:none; margin-top:20px;"></div>

  <?php

  if ($this->session->flashdata('status') == 204) {

    echo '<div id="validation" class="alert alert-danger" >' . $this->session->flashdata('message') . '</div>';
  } elseif ($this->session->flashdata('status') == 200) {

    echo '<div id="validation" class="alert alert-success" >' . $this->session->flashdata('message') . '</div>';
  ?>
    <script>
      $(document).readyy(function() {
        setTimeout(function() {
          window.location.href = "<?php echo base_url() . 'map/index' ?>";
        }, 2000);
      });
    </script>

  <?php

  }

  ?>



  <div class="navbar navbar-default navbar-fixed-bottom">

    <div class="">
      <?php
      $url = '';

      if (isset($_GET['latitude']) and isset($_GET['longitude'])) {
        $url = '?latitude=' . $_GET['latitude'] . '&longitude=' . $_GET['longitude'];
      }
      ?>
      <ul class="nav navbar-nav " id="moileUl">

        <li class="<?= $homeActive ?>"><a href="<?php echo base_url() . 'map' ?>"> <i class="glyphicon glyphicon-search"></i> <?= lang("search") ?> </a></li>

        <li class="<?= getActive('complete') ?>"><a href="<?php echo base_url() . 'complete' . $url ?>"><i class="glyphicon glyphicon-list-alt"></i><?= lang("reporting"); ?> </a></li>

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


        <li class="hidden <?= getActive('utilisation-et-contact') ?>"><a href="utilisation-et-contact"><i class="glyphicon glyphicon-envelope"></i>Contact</a></li>
        <li class="ml-2">
          <i class="langiconMobile fa fa-globe"></i>
          <select id="language1">
            <option class="lang" <?php echo selected($_SESSION['lang'], "french"); ?> value="french">Fr</option>
            <option class="lang" <?php echo selected($_SESSION['lang'], "english"); ?> value="english">Eng</option>
          </select>
        </li>


        <?php

        $u =  $this->session->userdata();

        $avatar = base_url() . 'uploads/' . $u['image'];

        if ($u['image'] == 'noimg.png') {

          $avatar = base_url() . 'uploads/noimage.jpg';
        }



        if ($this->session->userdata('userlogin') == 1) {





        ?>


          <li class="dropdown profile_li">

            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class=" fa fa-user"></i><?= $this->session->userdata('name') ?> <span class="caret"></span></a>

            <ul class="dropdown-menu" style="position: absolute;">

              <li><a href="user/profile"><?= lang("profile"); ?></a></li>

              <li role="separator" class="divider"></li>

              <li><a href="auth/userlogout" data-toggle="tooltip" title="logout"><?= lang("signout"); ?></a></li>

            </ul>

          </li>







        <?php } else { ?>

          <li class="<?= getActive('signup') ?>"><a data-toggle="tooltip" title="Registration" href="signup"><span class="glyphicon glyphicon-user"></span> <?= lang("register"); ?></a></li>

          <li class="<?= getActive('login') ?>"><a href="login"><span class="glyphicon glyphicon-log-in"></span> <?= lang("login"); ?> </a></li> <?php } ?>


      </ul>

    </div>

  </div>

  <nav class="navbar navbar-default navbar-fixed-top">

    <div class="container">

      <div class="navbar-header">

        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">

          <span class="sr-only">Toggle navigation</span>

          <span class="icon-bar"></span>

          <span class="icon-bar"></span>

          <span class="icon-bar"></span>

        </button>

        <a class="navbar-brand" href="<?php echo base_url() . 'map' ?>"><span id="api_brand"> Free Live Bees</span><span id="identify">Essaims libres</span></a>
      </div>

      <?php

      $homeActive = '';

      $arr = $this->uri->rsegment_array();

      if ($arr[1] == 'map' and $arr[2] == 'index') {

        $homeActive = 'active';
      }

      ?>

      <div id="navbar" class="navbar-collapse collapse">

        <ul class="nav navbar-nav">

          <li class="<?= $homeActive ?>"><a href="<?php echo base_url() . 'map' ?>"> <i class="glyphicon glyphicon-search"></i> <?= lang("search") ?> </a></li>

          <li class="<?= getActive('complete') ?>"><a href="<?php echo base_url() . 'complete' . $url ?>"><i class="glyphicon glyphicon-list-alt"></i><?= lang("reporting"); ?> </a></li>

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
          <li class="hidden <?= getActive('utilisation-et-contact') ?>"><a href="utilisation-et-contact"><i class="glyphicon glyphicon-envelope"></i>Contact</a></li>







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

            <li class="dropdown">

              <a href="#" id="dropdownProfile_a" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><img id="userAvatar" class="img-responsive" src="<?= $avatar ?>"><?= $this->session->userdata('name') ?> <span class="caret"></span></a>

              <ul class="dropdown-menu">

                <li><a href="user/profile"><?= lang("profile"); ?></a></li>

                <li role="separator" class="divider"></li>

                <li><a href="auth/userlogout" data-toggle="tooltip" title="logout"><?= lang("signout"); ?></a></li>

              </ul>

            </li>







          <?php } else { ?>

            <li class="<?= getActive('signup') ?>"><a data-toggle="tooltip" title="Registration" href="signup"><span class="glyphicon glyphicon-user"></span> <?= lang("register"); ?></a></li>

            <li class="<?= getActive('login') ?>"><a href="login"><span class="glyphicon glyphicon-log-in"></span> <?= lang("login"); ?> </a></li> <?php } ?>
          <li class="lang2">
            <i class="langiconDesktop fa fa-globe"></i>

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

  <script>
    $("#language1").on("change", function() {

      let val = $(this).val();
      $.ajax({
        url: "<?php echo base_url() . 'page/set_lang' ?>",
        type: "POST",
        data: {
          lang: val
        },
        success: function(success) {
          location.reload();
        }


      })
    });
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