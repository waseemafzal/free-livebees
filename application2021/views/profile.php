<?php include_once "header.php"; ?>

<style>
  form>div {
    margin-bottom: 10px;
  }
</style>

<div class="signup-area page-padding">

  <div class="container">

    <div class="row">

      <div class=" col-md-12 col-sm-12 col-xs-12">

        <div class="login-page signup-page">

          <div class="login-form signup-form">

            <h4 class="login-title "><?= lang("profile"); ?></h4>

            <div class="row">

              <?php

              $fname = '';

              $lname = '';

              if (isset($user)) {

                $nameArr = explode(' ', $user->name);

                $fname = $nameArr[0];

                $lname = $nameArr[1];
              }

              ?>

              <form id="form_user" name="form_user" method="POST" class="log-form">

                <div class="col-md-6 col-sm-12 col-xs-12">

                  <input type="text" id="fname" name="fname" class="form-control" placeholder="<?= lang('fname'); ?>" value="<?= $fname ?>" required>

                </div>

                <div class="col-md-6 col-sm-12 col-xs-12">

                  <input type="text" id="lname" name="lname" class="form-control" placeholder="<?= lang('lname'); ?>" value="<?= $lname ?>" required data-error="Please enter your last name">

                </div>

                <div class="col-md-6 col-sm-12 col-xs-12">

                  <input type="email" id="email" name="email" class="form-control" placeholder="<?= lang('your_email'); ?>" value="<?= $user->email ?>" required data-error="Please enter your name">

                </div>

                <div class="col-md-6 col-sm-12 col-xs-12">

                  <div style="display:flex;align-items:center;">

                    <input type="password" name="password" id="password" class="form-control" required>

                    <span id="eye_open" style="cursor:pointer;padding: 0px 2px;margin-left: -20px;" class="glyphicon glyphicon-eye-open"></span>

                    <span id="eye_close" style="cursor:pointer;padding: 0px 2px;margin-left: -20px;" class="hidden glyphicon glyphicon-eye-close"></span>

                  </div>



                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">

                  <?php

                  $ref = '';

                  $par = '';

                  if ($user->user_type == 3) {

                    $ref = 'selected="selected"';
                  } elseif ($user->user_type == 4) {

                    $par = 'selected="selected"';
                  } elseif ($user->user_type == 5) {

                    $inst = 'selected="selected"';
                  }




                  ?>

                  <select class="form-control" onChange="checkPro(this.value)" name="user_type">

                    <option disabled selected value=""> <?= lang('you_are');  ?> </option>

                    <option <?= $ref ?> value="3"><?= lang('referent'); ?> </option>

                    <option <?= $par ?> value="4"><?= lang('particular'); ?> </option>
                    <option <?= $inst ?> value="5"><?= lang('Institution'); ?> </option>

                  </select>

                </div>

                <?php

                if ($user->user_type == PRO_USER) {

                ?>



                  <div class="col-md-12 col-sm-12 col-xs-12 prowrap">

                    <input type="text" value="<?= $user->phone ?>" id="phone" name="phone" class="form-control" placeholder="Téléphone" required data-error="Please enter your phone/mobile">

                  </div>

                  <div class="col-md-12 col-sm-12 col-xs-12 prowrap">

                    <input type="text" value="<?= $user->address ?>" id="address" name="address" class="form-control" placeholder="Adresse" autocomplete="off" required data-error="Please enter your address">

                    <input type="hidden" id="cityLon" name="longitude" value="<?php echo $user->longitude; ?>" class="form-control" placeholder="Please enter your longitude">

                    <input type="hidden" id="cityLat" name="latitude" value="<?php echo $user->latitude; ?>" class="form-control" placeholder="Please enter your latitude">

                  </div>

                  <div class="col-md-12 col-sm-12 col-xs-12 prowrap">

                    <input type="text" value="<?= $user->about ?>" id="about" name="about" class="form-control" placeholder="<?= lang('bio'); ?>">

                  </div>



                <?php } ?>



                <div class="col-xs-12 col-md-6">

                  <label><?= lang('profile_pic'); ?></label><br>

                  <label for="file" class="pinbuttons1"><?= lang('choose_profile');  ?></label>

                  <input style="display:none" type="file" name="file" class="file" id="file" accept=".png,.PNG,.JPG,.jpg,.jpeg,.JPEG,.gif">

                </div>





                <div class="col-xs-12">

                  <span style="margin:0 !important; display:inline-block">

                    <?php

                    if (isset($user->image)) {

                      $image =  $user->image;

                      $src  = base_url() . 'uploads/' . $user->image;

                      echo '<img width="200"  src="' . $src . '" alt="img">';
                    }



                    ?>

                  </span>

                </div>



                <div class=" col-sm-12 col-xs-12">
                  <input type="hidden" name="check_user_type" value="<?php echo $user->user_type ?>">



                  <button type="button" onClick="create_user()" id="submit" class="pinbuttons1"><?= lang('submit'); ?></button><input type="hidden" name="id" value="<?= $user->id ?>">


                  <div id="msgSubmit" class="h3 hidden"></div>

                  <div class="clearfix"></div>

                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">

                  <div class="clear"></div>

                  <!--                                            <div class="separetor"><span>Or with signup</span></div>

-->
                  <div class="sign-icon">

                    <!--<ul>

                                                    <li><a class="facebook" href="#">Facebook</a></li>

                                                    <li><a class="twitter" href="#">twitter</a></li>

                                                    <li><a class="google" href="#">google+</a></li>

                                                </ul>-->



                  </div>

                </div>

              </form>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>

<!-- Start Footer Area -->

<?php include_once "includes/js/user.php"; ?>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaqEI1hEro18UDNXVHKnQ5dc6A_vF-crY&libraries=places&callback=initAutocomplete" async defer></script>

<script type="text/javascript">
  $(document).ready(function() {

    setTimeout(function() {

      $('#password').val('');

    }, 2000);

  });



  function initAutocomplete() {

    var input = document.getElementById('address');

    var autocomplete = new google.maps.places.Autocomplete(input);

    google.maps.event.addListener(autocomplete, 'place_changed', function() {

      var place = autocomplete.getPlace();

      // document.getElementById('address').value = place.name;

      document.getElementById('cityLat').value = place.geometry.location.lat();

      document.getElementById('cityLon').value = place.geometry.location.lng();





      //alert("This function is working!");

      //alert(place.name);

      // alert(place.address_components[0].long_name);



    });

  }





  /****************************/



  function displayLocation(latitude, longitude) {

    var request = new XMLHttpRequest();



    var method = 'GET';

    var url = 'https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyCzfWLHgFNaUiwqWhPQsoVB97kgQjPx1XM&latlng=' + latitude + ',' + longitude + '&sensor=false';

    var async = true;



    request.open(method, url, async);

    request.onreadystatechange = function() {

      if (request.readyState == 4 && request.status == 200) {

        var data = JSON.parse(request.responseText);

        var address = data.results[2];



        //   document.write(address.formatted_address);

        $("#address").val(address.formatted_address);

        console.log(address.geometry.location);

        //alert(address.geometry.location.lat);

        document.getElementById('cityLat').value = address.geometry.location.lat;

        document.getElementById('cityLon').value = address.geometry.location.lng;



      }

    };

    request.send();

  };



  var successCallback = function(position) {

    var x = position.coords.latitude;

    var y = position.coords.longitude;

    displayLocation(x, y);

  };



  var errorCallback = function(error) {

    var errorMessage = 'Unknown error';

    switch (error.code) {

      case 1:

        errorMessage = 'Permission denied';

        break;

      case 2:

        errorMessage = 'Position unavailable';

        break;

      case 3:

        errorMessage = 'Timeout';

        break;

    }

    alert(errorMessage);

  };



  var options = {

    enableHighAccuracy: true,

    timeout: 1000,

    maximumAge: 0

  };



  //  navigator.geolocation.getCurrentPosition(successCallback,errorCallback,options);
</script>

<script>
  $("#eye_open").click(function() {

    $("#password").attr("type", "text");

    $(this).addClass("hidden");

    $("#eye_close").removeClass("hidden");

  });

  $("#eye_close").click(function() {

    $("#password").attr("type", "password");

    $(this).addClass("hidden");

    $("#eye_open").removeClass("hidden");

  });
</script>