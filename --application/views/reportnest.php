<?php

include_once 'header.php';
if ($this->session->userdata('userlogin') == 1) {
?>

  <div id="modal1" class="modal">

    <div class="modal-content">

      <h4>Modal Header</h4>

      <p>A bunch of text</p>

    </div>

    <div class="modal-footer">

      <a href="#!" class="modal-close waves-effect waves-green btn-flat">Agree</a>

    </div>

  </div>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaqEI1hEro18UDNXVHKnQ5dc6A_vF-crY&libraries=places&callback=initAutocomplete" async defer></script>



  <script type="text/javascript">
    function initAutocomplete() {

      var fillInAddress;

      // Create the autocomplete object, restricting the search to geographical

      // location types.

      autocomplete = new google.maps.places.Autocomplete(

        /** @type {!HTMLInputElement} */

        (document.getElementById('address')), {

          types: ['geocode']

        });

      autocomplete.addListener('place_changed', fillInAddress);

    }
  </script>

  <form class=" target" id="formskillsubmitreply_678768_083__nonce_330987b" name="formskillsubmitreply_678768_083__nonce_330987b" role="form">



    <div id="form_id_div" class="container">

      <div class="col-md-12">

        <div class="col-md-6 padleft0">

          <label class="control-label">Entrez l'adresse</label>

          <div class="input-group">

            <input id="address" name="address" type="text" required class="form-control">

            <span class="input-group-addon" id="btnFilladdress" onClick="onclickgetlocation()"><i class="glyphicon glyphicon-map-marker form-control-feedback"></i></span>

          </div>





        </div>

      </div>

      <div class="clearfix">&nbsp;</div>





      <div class="col-md-12">

        <h3> État du nid </h3>

      </div>

      <div class="input-field col-md-2 col-xs-6">

        <label>

          <input name="status" type="radio" checked="" value="1">

          <span> Actif </span>

        </label>



      </div>

      <div class="input-field col-md-2 col-xs-6">

        <label>

          <input name="status" type="radio" value="2">

          <span> Inactif </span>

        </label>



      </div>

      <div class="input-field col-md-2 col-xs-6">



        <label>

          <input name="status" type="radio" value="3">

          <span> Pris en charge </span>

        </label>





      </div>

      <div class="input-field col-md-2 col-xs-6">





        <label>

          <input name="status" type="radio" value="4">

          <span> Traité </span>

        </label>



      </div>

      <div class="clearfix">&nbsp;</div>

      <div class="clearfix">&nbsp;</div>



      <div class="clearfix">&nbsp;</div>

      <div class="col-md-12 m12" style="width:100%; display:block">

        <div class="input-field">

          <label>Joindre une vidéo ou une image</label>

          <input type="file" name="file[]" onchange="GetFileSizeNameAndType()" class="custom-file-input customfileinputFrench file" id="file" accept=".png,.PNG,.JPG,.jpg,.jpeg,.JPEG,.gif,.mp4" multiple>



          <label for="file"></label>

        </div>

      </div>

      <div class="col-md-12 m12" style="width:100%; display:block">

        <div id="fp"></div>

        <p>

        <div id="divTotalSize"></div>

        </p>

      </div>

      <div class="input-field col-md-12 m12 l12">

        <span class="lbl"> Trouver un désinsectiseur </span>



        <input type="checkbox" id="findPro" name="findPro">

      </div>







      <div class="clearfix">&nbsp;</div>

      <div class="control">

        <div class="input-field col-md-12">



          <input id="location_file" name="location_file" style="background-color: #FCE303;

    color: #000;

    width: 100%;" type="submit" class="btn col-xs-12" value="Soumettre">





        </div>











      </div>





  </form>



  </div>

  <?php

  include_once "location_js.php";

  ?>

  <script type="text/javascript">
    $('#formskillsubmitreply_678768_083__nonce_330987b').on("submit", function(e) {

      e.preventDefault();

      if (!confirm("Confirmer le signalement du nid : ")) {

        return false;

      }



      var formData = new FormData();

      var other_data = $('#formskillsubmitreply_678768_083__nonce_330987b').serializeArray();

      $.each(other_data, function(key, input) {

        formData.append(input.name, input.value);

      });

      /**********multiple files**************/



      var inputFile = $('input#file');

      var filesToUpload = inputFile[0].files;

      if (filesToUpload.length > 0) {

        for (var i = 0; i < filesToUpload.length; i++) {

          var file = filesToUpload[i];

          formData.append("file[]", file, file.name);

        }

      }



      /**********multiple files**************/

      $.ajax({

        type: "POST",

        url: "map/maplocationsave",

        data: formData,

        cache: false,

        contentType: false,

        processData: false,



        beforeSend: function() {

          $('#loader').removeClass('hidden');

          //	$('#form_skill_squared_kjnsdjnhsdjs87sd8s7d8s7d .btn_au').addClass('hidden');

        },

        success: function(data) {



          $('#loader').addClass('hidden');

          if (data.status == 1) {

            $("#formskillsubmitreply_678768_083__nonce_330987b")[0].reset();

            $('.alert').show();

            $('.alert').addClass('alert-success');

            $('.alert').html(data.message);

            //alert(data.redirect);

            setTimeout(function() {

              window.location.href = data.redirect;

            }, 3000);

          }





        }

      });



      //ajax end    

    });







    function GetFileSizeNameAndType() {

      var fi = document.getElementById('file'); // GET THE FILE INPUT AS VARIABLE.



      var totalFileSize = 0;

      if (fi.files.length > 0) {

        for (var i = 0; i <= fi.files.length - 1; i++) {

          var fsize = fi.files.item(i).size;

          totalFileSize = totalFileSize + fsize;

          document.getElementById('fp').innerHTML =

            document.getElementById('fp').innerHTML +

            '<br /> ' + 'File Name is <b>' + fi.files.item(i).name +

            '</b> and Size is <b>' + Math.round((fsize / 1024))

            //DEFAULT SIZE IS IN BYTES SO WE DIVIDING BY 1024 TO CONVERT IT IN KB

            +

            '</b> KB and File Type is <b>' + fi.files.item(i).type + "</b>.";

        }

      }

      document.getElementById('divTotalSize').innerHTML = "Total File(s) Size is <b>" + Math.round(totalFileSize / 1024) + "</b> KB";

    }
  </script>

<?php } else { ?>

  <div class="container">

    <div class="jumbotron">

      <h1 class="h1">Vous devez d'abord vous connecter pour accéder à cette page! <br><br>

        <center><a class="btn btn-info" href="user/login">Login</a></center>

      </h1>



    </div>

  </div>



<?php } ?>