<?php

include_once "header.php";



?>

<style>
  #alertLocation,
  #loading {

    padding: 2%;

    border-radius: 5px;

    text-align: center;

  }
</style>



<section class="vc_rows wpb_rows vc_rows-fluid vc_custom_1488790902404 " id="main-features" style="padding-top:20px !important">

  <div class="container">

    <div id="alertLocation" class="" style="display:none"></div>

    <div id="loading" class="alert-success">Chargement en cours...</div>





  </div>

</section>





<?php

include_once "footer.php";

?>

<script>
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

        console.log(data.results);

        //   document.write(address.formatted_address);

        $("#filtertext").val(address.formatted_address);

        $("#formatted_address").html(address.formatted_address);



        <?php

        if (!isset($_GET['latitude']) and $_GET['latitude'] == '' and !isset($_GET['longitude']) and $_GET['longitude'] == '') {

        ?>

          window.location = '<?php echo base_url() . 'map/index?latitude=' ?>' + latitude + '<?php echo "&longitude=" ?>' + longitude;
        <?php } ?>





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

        errorMessage = 'Unable to get location';

        break;

    }
    // let show_message = "<?php //echo lang('refresh_page'); 
                            ?>";
    // alert(show_message);
    // var button = "<b> <?php //lang('refresh_page');  
                          ?> </b>"
    // alert(button);
    // alert(errorMessage);
    // alert("<?php //echo lang('refresh_page'); 
              ?>")
    <?php
    if ($_SESSION['lang'] == 'english') {
    ?>
      var button = "Please refresh your browser in order to continue and allow your location.";
    <?php
    } else {
    ?>
      var button = "Veuillez actualiser votre navigateur pour continuer et autoriser votre position.";
    <?php
    }
    ?>

    $('#alertLocation').html(errorMessage + " " + button);

    $('#alertLocation').show();

    $('#alertLocation').addClass('alert-danger');

    $('#loading').hide();



  };



  var options = {

    enableHighAccuracy: true,

    timeout: 5000,

    maximumAge: 0

  };



  navigator.geolocation.getCurrentPosition(successCallback, errorCallback, options);



  function onclickgetlocation() {

    window.location.reload(true);

    //	 window.location.href="map/refreshLocation" 

  }
</script>