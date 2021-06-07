<script>
  function displayLocation(latitude, longitude) {

    var request = new XMLHttpRequest();


    // alert(latitude);
    // alert(longitude);
    var method = 'GET';

    var url = 'https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyCzfWLHgFNaUiwqWhPQsoVB97kgQjPx1XM&latlng=' + latitude + ',' + longitude + '&sensor=false';

    var async = true;



    request.open(method, url, async);

    request.onreadystatechange = function() {

      if (request.readyState == 4 && request.status == 200) {

        var data = JSON.parse(request.responseText);

        var address = data.results[1];

        console.log(data.results);

        //   document.write(address.formatted_address);

        $("#address").val(address.formatted_address);
        $("#dumy_address").val(address.formatted_address);
        $("#lat_val").html("Latitude:" + latitude + "  |  ");
        $("#lon_val").html("Longitude:" + longitude);

        $("#lat_dummy").html(latitude);
        $("#lon_dummy").html(longitude);

        $("#lat").val(latitude);
        $("#lon").val(longitude);

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

    alert(errorMessage + " " + button);

  };



  var options = {

    enableHighAccuracy: true,

    timeout: 2000,

    maximumAge: 0

  };

  // setTimeout(() => {
  //   navigator.geolocation.getCurrentPosition(successCallback, errorCallback, options);
  //   alert("haris");
  // }, 1000);

  //navigator.geolocation.getCurrentPosition(successCallback, errorCallback, options);

  function onclickgetlocation() {

    navigator.geolocation.getCurrentPosition(successCallback, errorCallback, options);



  }

  <?php


  if (isset($_GET['latitude']) and isset($_GET['longitude'])) { ?>
    //  $url='?latitude='.$_GET['latitude'].'&longitude='.$_GET['longitude'];
    displayLocation(<?= $_GET['latitude'] ?>, <?= $_GET['longitude'] ?>);
  <?php } else { ?>
    displayLocation(<?= $_SESSION['latitude'] ?>, <?= $_SESSION['longitude'] ?>);
  <?php
  }
  ?>
</script>