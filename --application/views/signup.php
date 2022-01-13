<?php include_once "header.php"; ?>

<style>
    form>div {
        margin-bottom: 10px;
    }

    .redborder {
        border-color: red !important;
    }

    .pinbuttons_signup {

        font-size: 12px;

        border: 1px solid;

        color: black;

        font-weight: 500;

        text-decoration: none;

        background: rgb(252, 227, 3);



        text-align: center;

        border-radius: 2px;

        padding: 8px 22px;

        margin: 5px 0 0 0;

    }
</style>

<div class="signup-area page-padding">

    <div class="container">

        <div class="row">

            <div class=" col-md-12 col-sm-12 col-xs-12">

                <div class="login-page signup-page">

                    <div class="login-form signup-form">

                        <h4 class="login-title "><?= lang("register_now"); ?></h4>

                        <div class="row">

                            <form id="form_user" name="form_user" method="POST" class="log-form">

                                <div class="col-md-6 col-sm-12 col-xs-12">

                                    <input type="text" id="fname" name="fname" class="form-control" placeholder="<?= lang('fname'); ?>" required data-error="Please enter your name">

                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12">

                                    <input type="text" id="lname" name="lname" class="form-control" placeholder="<?= lang('lname'); ?>" required data-error="Please enter your last name">

                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12">

                                    <input type="email" id="email" name="email" class="form-control" placeholder="<?= lang('your_email'); ?>" required data-error="Please enter your name">

                                </div>

                                <div style="display:flex;align-items:center;" class="col-md-6 col-sm-12 col-xs-12">

                                    <input type="password" name="password" id="password" class="form-control" placeholder="<?= lang('password'); ?>" required data-error="Please enter your password">
                                    <span id="eye_open" style="cursor:pointer;padding: 0px 2px;margin-left: -20px;" class="hidden glyphicon glyphicon-eye-open"></span>
                                    <span id="eye_close" style="cursor:pointer;padding: 0px 2px;margin-left: -20px;" class=" glyphicon glyphicon-eye-close"></span>
                                </div>

                                <div class="col-md-6 col-sm-12 col-xs-12">

                                    <select class="form-control" name="user_type">

                                        <option disabled selected><?= lang("you_are"); ?></option>

                                        <option value="3"><?= lang("referent"); ?> </option>

                                        <option value="4"><?= lang("particular"); ?> </option>
                                        <option value="5"><?= lang("Institution"); ?> </option>

                                    </select>

                                </div>



                                <div class="col-md-6 col-sm-12 col-xs-12 prowrap">

                                    <input type="text" id="phone" name="phone" class="form-control" placeholder="<?= lang('mobile'); ?>" required data-error="Please enter your phone/mobile">

                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    <input type="text" id="about" name="about" class="form-control" placeholder="<?= lang('bio'); ?>" required>

                                </div>
                                <div class="prowrap">

                                    <div class="col-md-12 col-sm-12 col-xs-12">



                                        <input type="text" onChange="check()" id="address" name="address" class="form-control" placeholder="<?= lang('address'); ?>" required data-error="Please enter your address">

                                    </div>

                                    <div class="clearfix">&nbsp;</div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">

                                        <input type="hidden" id="cityLon" name="longitude" class="form-control" placeholder="Veuillez entrer votre longitude">

                                    </div>

                                    <div class="col-md-6 col-sm-12 col-xs-12">

                                        <input type="hidden" id="cityLat" name="latitude" class="form-control" placeholder="Veuillez entrer votre latitude">

                                    </div>

                                </div>





                                <div class="col-md-12 col-sm-12 col-xs-12 ">

                                    <div class="check-group flexbox">

                                        <label class="check-box">

                                            <input type="checkbox" class="check-box-input" checked>

                                            <a href="terms-and-conditions" target="_blank"> <span class="remember-text"><?= lang("terms_conditions") ?></span></a>

                                        </label>

                                    </div>

                                </div>



                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    <label><?= lang("profile_pic"); ?></label><br>

                                    <label for="file" class="pinbuttons_signup" style="cursor:pointer;padding:8px 17px !important"><?= lang('choose_profile'); ?></label><br> <input style="display:none" id="file" type="file" name="myPhoto" onchange="PreviewImage();" />

                                    <br>

                                    <img src="assets/noimg.jpg" id="uploadPreview" style="width: 100px; height: 100px;" />



                                    <script type="text/javascript">
                                        function PreviewImage() {

                                            var oFReader = new FileReader();

                                            oFReader.readAsDataURL(document.getElementById("file").files[0]);



                                            oFReader.onload = function(oFREvent) {

                                                document.getElementById("uploadPreview").src = oFREvent.target.result;

                                            };

                                        };
                                    </script>
                                </div>

                                <div class="clearfix">&nbsp;</div>



                                <div class="col-md-12 col-sm-12 col-xs-12">

                                    <button type="button" onClick="create_user()" id="submit" class="pinbuttons_signup"><?= lang("submit"); ?></button>

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

                                        <div class="acc-not"><?= lang('have_an_account'); ?> <a href="page/login"><?= lang('log_in'); ?></a></div>

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

<?php //include_once"footer.php"; 
?>

<?php include_once "includes/js/user.php"; ?>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaqEI1hEro18UDNXVHKnQ5dc6A_vF-crY&libraries=places&callback=initAutocomplete" async defer></script>
<script>
    $("#eye_open").click(function() {

        $("#password").attr("type", "password");
        $(this).addClass("hidden");
        $("#eye_close").removeClass("hidden");
    });
    $("#eye_close").click(function() {

        $("#password").attr("type", "text");
        $(this).addClass("hidden");
        $("#eye_open").removeClass("hidden");
    });
</script>
<script type="text/javascript">
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

        //alert(errorMessage);

    };



    var options = {

        enableHighAccuracy: true,

        timeout: 1000,

        maximumAge: 0

    };



    navigator.geolocation.getCurrentPosition(successCallback, errorCallback, options);





    function check() {

        console.log("check");

        try {

            var place = autocomplete.getPlace();

            console.log(place);

            if (!place.geometry) {
                //$('#address').removeClass('redborder');
                // User entered the name of a Place that was not suggested and

                // pressed the Enter key, or the Place Details request failed.

                /* window.alert("Please enter address suggested by google !");

					$('#address').val('');

                    return false;*/

            }

        } catch (err) {

            //  window.alert("Please enter address suggested by google");
            //$('#address').addClass('redborder');
            // $('#address').val('');

            return false;

        }



    }
</script>