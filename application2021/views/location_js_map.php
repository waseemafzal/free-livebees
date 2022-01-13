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

  // navigator.geolocation.getCurrentPosition(successCallback, errorCallback, options);

  setTimeout(function() {
    navigator.geolocation.getCurrentPosition(successCallback, errorCallback, options);
  }, 100);




  function onclickgetlocation() {

    navigator.geolocation.getCurrentPosition(successCallback, errorCallback, options);



  }
</script>