<?php



// if (isset($_POST['pro_user'])) {



//   print_r($_POST);



//   die('working');



// }



// print_r($data);



// die('working');

?>



<!DOCTYPE html>



<html lang="en">







<head>



  <!-- Compiled and minified JavaScript -->



  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js">



  </script>



  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">



  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lato-font/3.0.0/css/lato-font.min.css" integrity="sha512-rSWTr6dChYCbhpHaT1hg2tf4re2jUxBWTuZbujxKg96+T87KQJriMzBzW5aqcb8jmzBhhNSx4XYGA6/Y+ok1vQ==" crossorigin="anonymous" />



  <!-- Compiled and minified CSS -->



  <!-- /////////// -->



  <style>
    .input-field .error {

      color: red !important;

      padding-left: 18px;

    }



    a.btn_behave {



      background-color: #C2AE13;



    }







    /* main container */



    div.form_container {



      width: 100%;



    }







    div.form_container>div.main_form {}







    div.texte>* {



      color: #c2ae13;



      font-size: 20px;



    }







    /* input::placeholder {



      color: green;



      } */



    /* form content */



    div.form_content {



      text-align: center;



      width: 100%;



      margin: 0 auto;



    }







    div.form_content>h1,



    div.form_content>p {



      color: #C2AE13;



    }







    div.form_content>p {



      text-align: justify;



    }







    div.input-field>p.radio_content {



      font-size: 15px;



    }







    div.input-field>label.notification {



      font-size: 15px;



    }







    select {



      display: block !important;



    }







    .imgGallery img {



      height: 35vh;



      padding: 8px;



      width: 25%;



    }







    label#del_icon {



      position: relative;



      top: -95px;



      left: -20px;



      color: red;



      font-size: 30px;



      cursor: pointer;



    }







    label#del_icon:hover {



      font-size: 35px;



    }







    form * {



      font-size: 15px;



    }







    label {



      font-size: 15px !important;



      color: rgb(50, 48, 84) !important;



      font-family: 'Lato';



    }







    .f_extended {



      font-size: 12px !important;



      color: #333;



    }




#navbar ul li a i {
    height: 25px;
}

#mainheading{color: #000; font-family: Lato; font-weight: normal; font-style: normal; font-variant: normal; font-size: 35px;}
.texte p {
    text-align: justify;
}
    @media (max-width: 768px) {
		.file-field span {
    cursor: pointer;
    font-size: smaller;
}
.container{
    width: auto!important;
}
		#mainheading{ font-size: 22px;}

#navbar ul li {
    width: 100%;
}
#language2 {
   
    margin: 8px 45% !important;
}

      div.form_container>div.main_form {



        width: 80%;



      }



    }







    .title {



      font-size: 20px;



      font-weight: bold;



    }







    .under_title {



      font-size: 15px;



    }







    label#del_icon {



      position: relative;



      top: -95px;



      left: -20px;



      cursor: pointer;



      background-color: #e9d6d6;



      padding: 0.5%;



      border-radius: 50%;



    }







    label#del_icon:hover {



      padding: 1%;



      background-color: red;



    }
  </style>



  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaqEI1hEro18UDNXVHKnQ5dc6A_vF-crY&libraries=places&callback=initAutocomplete" async defer>



  </script>



  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">



  </script>



  <script type="text/javascript">
    function initAutocomplete() {



      var fillInAddress;



      // Create the autocomplete object, restricting the search to geographical



      // location types.



      autocomplete = new google.maps.places.Autocomplete(



        /** @type {!HTMLInputElement} */



        (document.getElementById('address')), {







          types: ['geocode']







        }



      );











      autocomplete.addListener('place_changed', fillInAddress);



    }
  </script>







  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">



  </script>



  <script>
    $(document).ready(function() {



      $(function() {



        // Multiple images preview with JavaScript



        var multiImgPreview = function(input, imgPreviewPlaceholder) {



          $('.imgGallery').empty();



          if (input.files) {



            var filesAmount = input.files.length;



            for (i = 0; i < filesAmount; i++) {



              var reader = new FileReader();



              //  file



              reader.onload = function(event) {



                var str = event.target.result;



                var chk = str.substring(5, 10);



                if (chk == "image") {



                  $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);



                } else if (chk == "video") {



                  $($.parseHTML('<video controls width="300"><source src="' + event.target.result + '"></video>')).appendTo(imgPreviewPlaceholder);



                }



              }



              reader.readAsDataURL(input.files[i]);



            }



          }



        };



        $('#choose_file').on('change', function() {



          multiImgPreview(this, 'div.imgGallery');



        });



      });



    });
  </script>



  <!--script for update image  -->



  <script>
    $(document).ready(function() {



      $('label#del_icon').click(function() {



        var id = $(this).data('id');



        var element = this;



        if (confirm("Confirmer la suppression ?")) {



          $.ajax({



            url: "<?php echo  base_url() . 'map/del_image'; ?>",



            type: "POST",



            data: {



              image_id: id



            },



            success: function(data) {



              if (data == 1) {



                alert('Supprimé avec succès');



                $(element).closest("div").fadeOut();



              } else {



                alert('impossible de supprimer');



              }



            }



          });



        }



      });



    });
  </script>



  <!--  -->



  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" />



  <!-- ////////////////////// -->



  <meta charset="UTF-8" />



  <meta name="viewport" content="width=device-width, initial-scale=1.0" />



  <title>Document



  </title>



</head>







<body>



  <?php



  if (isset($data)) {



    $val1 = $data;
  }



  include_once 'header.php';



  if ($this->session->userdata('userlogin') == 1) {



  ?>









    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>



    <script>
      $(document).ready(function() {

        //waseemafzal





        $("#nest_insert_form").validate({



          rules: {



            address: "required",



            date: "required",



            place: "required",

            colonie_hauteur: "required",

            nesting_type: "required",

            pollen: "required",

            activity: "required",

            temperature: "required",

            detailed_information: "required",

            'weather_situation[]': "required",

            flights: {

              required: function() {

                return $("select[name='pollen']").val() == 'Non' || $("select[name='pollen']").val() == 'ne sais pas';

              }

            },

            fight_with_workers: {

              required: function() {

                return $("select[name='pollen']").val() == 'Non' || $("select[name='pollen']").val() == 'ne sais pas';

              }

            },

            waste_wax: {

              required: function() {

                return $("select[name='pollen']").val() == 'Non' || $("select[name='pollen']").val() == 'ne sais pas';

              }

            },



            entries_exits: {

              required: function() {

                return $("select[name='pollen']").val() == 'Non' || $("select[name='pollen']").val() == 'ne sais pas';

              }

            },

            'images[]': "required",





            // fight_with_workers: {

            //   required: $("select[name='pollen']").val() == 'Non' || $("select[name='pollen']").val() == 'ne sais pas'

            // },

            // waste_wax: {

            //   required: $("select[name='pollen']").val() == 'Non' || $("select[name='pollen']").val() == 'ne sais pas'

            // },

            // entries_exits: {

            //   required: $("select[name='pollen']").val() == 'Non' || $("select[name='pollen']").val() == 'ne sais pas'

            // }



          },



          messages: {

            'images[]': `<?php echo lang('image_field'); ?>`,

            address: `<?php echo lang('address_field'); ?>`,



            date: `<?php echo lang('date_field'); ?>`,

            // just put this and check phpstart  echo lang('address_field')   php close

            place: `<?php echo lang('colonie_field'); ?>`,

            colonie_hauteur: `<?php echo lang('colonie_hauter'); ?>`,

            nesting_type: `<?php echo lang('type_support_field'); ?>`,

            pollen: `<?php echo lang('pollen_field'); ?>`,

            activity: `<?php echo lang('activity_field'); ?>`,

            temperature: `<?php echo lang('temperature_field'); ?>`,

            detailed_information: `<?php echo lang('detailed_information_field'); ?>`,

            'weather_situation[]': `<?php echo lang('weather_situation_field'); ?>`,

            flights: `<?php echo lang('flight'); ?>`,

            fight_with_workers: `<?php echo lang('fight_with_workers'); ?>`,

            waste_wax: `<?php echo lang('waste_wax_field'); ?>`,

            entries_exits: `<?php echo lang('entries_exits_field'); ?>`,













          },



          errorPlacement: function(error, element) {



            if (element.attr("name") == "address") {



              error.insertAfter("#address_error");



            }



            if (element.attr("name") == "address") {



              error.insertAfter("#address_error");



            }



            if (element.attr("name") == "date") {



              error.insertAfter("#date_error");



            }



            // in case of radio button or checkboxes , put a div where you want to show the error



            if (element.attr("name") == "place") {



              error.insertAfter("#placeError");



            }



            if (element.attr("name") == "colonie_hauteur") {



              error.insertAfter("#colonie_hauter_error");



            }



            if (element.attr("name") == "nesting_type") {



              error.insertAfter("#type_de_support_error");



            }



            if (element.attr("name") == "pollen") {



              error.insertAfter("#pollen_error");



            }

            if (element.attr("name") == "activity") {



              error.insertAfter("#activity_error");



            }

            if (element.attr("name") == "temperature") {



              error.insertAfter("#temperature_error");



            }



            if (element.attr("name") == "weather_situation[]") {



              error.insertAfter("#errrorWeather");



            }

            if (element.attr("name") == "detailed_information") {



              error.insertAfter("#detailed_information_error");



            }





            if (element.attr("name") == "flights") {



              error.insertAfter("#flights_error");



            }





            if (element.attr("name") == "fight_with_workers") {



              error.insertAfter("#fight_with_workers_error");



            }



            if (element.attr("name") == "waste_wax") {



              error.insertAfter("#waste_wax_error");



            }



            if (element.attr("name") == "entries_exits") {



              error.insertAfter("#entries_exits_error");



            }



            if (element.attr("name") == "images[]") {



              error.insertAfter("#image_error");



            }















          },







          errorElement: 'span'



        })











      });
    </script>
































    <!--  -->



    <div class="container">



      <div class="main_form boxshadow">



        <div class="texte col s12 m6 texte">


          <h1 id="mainheading">



            <?= lang('reporting_title'); ?>



          </h1>



          <p>



            <?= lang('reporting_sub_title') ?>



          </p>



        </div>



        <div class="row">



          <?php



          if (isset($val1)) {



            include 'editnest.php';
          } else {



          ?>



            <form id="nest_insert_form" enctype="multipart/form-data" class="col s12 nest_form">



              <!-- address -->



              <!-- //lat long inputs -->







              <!-- images -->



              <div class="row">



                <div class="input-field col-sm-12">



                  <div class="adjouter">



                    <div class="file-field input-field">



                      <div class="btn">



                        <span>



                          <?= lang('photos'); ?>



                        </span>



                      </div>



                      <input id="choose_file" name="images[]" class="my_get_image_exif" type="file" accept="image/png, image/gif, image/jpeg,video/mp4" multiple>



                      <div class="file-path-wrapper">



                        <input class="file-path" type="text" placeholder="télécharger une ou plusieurs images / vidéos">

                      </div>



                    </div>



                    <p>



                      <?= lang('photos_sub_title'); ?>



                    </p>



                  </div>

                  <div id="image_error"></div>



                  <div class="imgGallery">



                  </div>



                </div>



              </div>
              <br>


              <div class="row">



                <div class="input-field col-md-6 col-sm-12">

                  <p>



                    <label>



                      <input name="hide_location" id="hide_location" type="checkbox" class="filled-in">



                      <span style="font-size:17px;">



                        <?php echo lang('hide_location');  ?>



                      </span>



                    </label>



                  </p>
                  <p class="under_title">
                    <?php echo lang('hide_location_label');  ?>
                  </p>



                </div>



              </div>



              <!-- address -->



              <div class="row">



                <div class="input-field col-md-6 col-sm-12">



                  <h5 class="title">



                    <?= lang('address') ?>*



                  </h5>



                  <input id="address" onkeypress="searchAutocomplete()" placeholder="Adresse" type="text" name="address" />

                  <div id="address_error"></div>

                  <input id="dumy_address" type="hidden" />
                  <span id="lat_val"></span>
                  <span id="lon_val"></span>


                  <span class="hidden" id="lat_dummy"></span>
                  <span class="hidden" id="lon_dummy"></span>



                </div>



              </div>
              <div class="row">
                <div class="input-field col-md-6 col-sm-12">
                  <h5 class="title">
                    Latitude
                  </h5>
                  <input type="number" name="lat" id="lat" />
                </div>
              </div>
              <div class="row">
                <div class="input-field col-md-6 col-sm-12">
                  <h5 class="title">
                    Longitude
                  </h5>
                  <input type="number" name="lon" id="lon" />
                </div>
              </div>









              <!-- date -->



              <div class="row">



                <div class="date_picker col-md-6 col-sm-12">



                  <h5 class="title">



                    <?= lang('date'); ?>*



                  </h5>



                  <p class="under_title">



                    <?= lang('date_title'); ?>



                  </p>



                  <input name="date" type="date" value="<?php echo date("Y-m-d");  ?>" id="my_date">

                  <div id="date_error"></div>

                  <br>



                  <br>



                </div>



              </div>



















              <!--  -->







              <!-- radius -->



              <div class="row">



                <div class="input-field col-md-12">



                  <div class="row">



                    <div class="col-md-6">







                      <div class="form-group">



                        <h5 class="title">



                          <!-- <label for="radius" class="title"> -->



                          <?php echo lang('ifreported'); ?>



                          <!-- </label> -->



                        </h5>



                        <!--<p class="under_title">-->



                        <?php // echo lang('helptextradius') 
                        ?>



                        <!--</p>-->







                        <input type="number" class="form-control" id="radius">



                      </div>



                      <div>



                        <input type="button" onclick="validateSearch()" name="sbmitbtn" id="sbmitbtnid" value="<?php echo lang('verify_radius'); ?>" class="btn btn-default btn-info">







                      </div>







                    </div>







                  </div>



                </div>



              </div>



              <div class="row">



                <div class="input-field col s12 ">



                  <p class="title">



                    <?= lang('colonie_title') ?>*



                  </p>



                  <p class="radio_content under_title">



                    <?= lang('colonie_sub_title') ?>



                  </p>



                  <p>



                    <label>



                      <input name="place" type="radio" value="Cavité naturelle" />



                      <span class="f_extended">



                        <?= lang('colonie1'); ?>



                      </span>



                    </label>



                  </p>



                  <p>



                    <label>



                      <input name="place" value="Cavité artificielle" type="radio" />



                      <span class="f_extended">



                        <?= lang('colonie2'); ?>



                      </span>



                    </label>



                  </p>



                  <p>



                    <label>



                      <input name="place" class="with-gap" value="A l'air libre" type="radio" />



                      <span class="f_extended">



                        <?= lang('colonie3'); ?>



                      </span>



                    </label>



                  </p>



                  <div id="placeError"></div>



                </div>



              </div>



              <!-- radio button end -->



              <!-- notification start -->



              <div class="row">



                <div class="input-field col-md-6">



                  <p class='title'>



                    <?= lang('height_reporting'); ?> *



                  </p>



                  <input name="colonie_hauteur" type="number" />



                  <p>



                    <?= lang('height_sub_title_reporting'); ?>



                    <a href="javascript:void(0)">



                      <?= lang('height_sub_title_reporting_anchor'); ?>



                    </a>



                  </p>

                  <div id="colonie_hauter_error"></div>



                </div>



              </div>



              <div class="row">



                <div class="input-field col-md-6">



                  <p class="title">



                    <?= lang('nidification'); ?> *



                  </p>



                  <select name="nesting_type" id="browser">



                    <option value="" disabled selected>



                      <?= lang('choose'); ?>



                    </option>



                    <option value="Arbre">



                      <?= lang('nidification1'); ?>



                    </option>



                    <option value="Chemineé">



                      <?= lang('nidification2'); ?>



                    </option>



                    <option value="Falaise">



                      <?= lang('nidification3'); ?>



                    </option>



                    <option value="Toiture">



                      <?= lang('nidification4'); ?>



                    </option>



                    <option value="Autre">



                      <?= lang('nidification5'); ?>



                    </option>



                  </select>



                  <p>



                    <?= lang('nidification_sub_title'); ?>



                  </p>

                  <div id="type_de_support_error"></div>



                </div>



              </div>



              <div class="row" id="extra_info" style="display: none;">



                <div class="input-field col s12">



                  <p class="title">



                    <?php echo lang("specify_nidification") ?>



                  </p>



                  <input id="extra_info_val" name="e_nesting_type_info" />



                </div>



              </div>



              <div class="panel panel-default">



                <div class="panel-heading">



                  <h4 class="panel-title">



                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" style="text-decoration:none;" id="collapse_a">



                      <span style="font-size:20px;">+



                      </span>



                      </span>&nbsp&nbsp COMPLEMENT



                    </a>



                  </h4>



                </div>



                <div id="collapse2" class="panel-collapse collapse ">



                  <div class="panel-body">



                    <div class="">



                      <!-- p2 -->



                      <!--  -->



                      <div class="accordion_section">



                        <div class="row">



                          <div class="input-field col s12 m6">



                            <h3>



                              <?= lang('height_reporting'); ?>



                            </h3>



                            <input name="height" placeholder="" id="nodification" type="number" />



                            <h6>



                              <?= lang('height_sub_title_reporting') ?>



                              <a href="<?php echo base_url() . 'map/reference'; ?>" target="_blank">



                                <?= lang('height_sub_title_anchor') ?>



                              </a>



                            </h6>



                          </div>



                        </div>



                        <!--  -->



                        <!-- p3 -->



                        <div class="row">



                          <div class="input-field col m6 s12">



                            <!-- 9april -->



                            <h3>



                              <?= lang("subspecie") ?>



                            </h3>



                            <input name="subspecie" value="<?php echo $result->subspecie; ?>" id="subspecie" type="text" />



                          </div>



                        </div>



                        <div class="row">



                          <div class="input-field col m6 s12">



                            <h3>



                              <?= lang('tree_genes'); ?>



                            </h3>



                            <input name="tree_genes" placeholder="" id="notification" type="number" />



                            <h6>



                              <?= lang('tree_genes_sub_title'); ?>



                            </h6>



                          </div>



                        </div>



                        <!-- p4 -->



                        <div class="row">



                          <div class="input-field col m6 s12">



                            <h3>



                              <?= lang('tree_alive'); ?>



                            </h3>



                            <h5>



                              <p>



                                <?= lang('tree_alive_sub_title'); ?>



                              </p>



                            </h5>



                            <p>



                              <label>



                                <input name="tree_alive" value="Oui" type="radio" />



                                <span class="f_extended">



                                  <?= lang('Oui'); ?>



                                </span>



                              </label>



                            </p>



                            <p>



                              <label>



                                <input class="with-gap" name="tree_alive" value="Non" type="radio" />



                                <span class="f_extended">



                                  <?= lang('no'); ?>



                                </span>



                              </label>



                            </p>



                            <p>



                              <label>



                                <input name="tree_alive" type="radio" value="ne sais pas" />



                                <span class="f_extended">



                                  <?= lang('dont_know'); ?>



                                </span>



                              </label>



                            </p>



                          </div>



                        </div>



                      </div>



                      <div class="row">



                        <!-- <div style="display:none;" class="input-field col s12 m12">



<p> ENTREE DU NID</p>



<div>



<p class="title"> Entrée de la colonie : Hauteur (m) * </p>



<h1>height2</h1>



<input name="colonie_hauteur" value="<? php // echo $result->colonie_hauteur; 
                                      ?>" />



<p> Indiquer la hauteur approximative à laquelle se trouve l entrée de la colonie </p>



</div>



</div> -->



                        <div class="input-field col-md-6">



                          <p class="title">



                            <?= lang('dimension'); ?>



                          </p>



                          <input name="colonie_dimension" type="number" />



                          <p>



                            <?= lang('dimension_sub_title'); ?>



                          </p>



                        </div>



                      </div>



                      <div class="row">



                        <div class="input-field col-md-6">



                          <p class="title">



                            <?= lang('orientation'); ?>



                          </p>



                          <p>



                            <?= lang('orientatio_sub_title');  ?>



                          </p>



                          <select id="orientation_select" name="orientation">



                            <option selected disabled value="">



                              <?= lang('choose') ?>



                            </option>



                            <?php



                            $or = array(



                              "Nord", "Nord Est", "Est", "Sud Est", "Sud", "Sud Ouest", "Ouest", "Nord Ouest"



                            );



                            foreach ($or as $key => $orientVal) {



                            ?>



                              <option value="<?= $orientVal ?>">



                                <?= lang($orientVal) ?>



                              </option>



                            <?php } ?>



                          </select>



                        </div>



                      </div>



                      <div class="row">



                        <div class="input-field col-md-6">



                          <p class="title">



                            <?= lang('form'); ?>



                          </p>



                          <input name="shape" />



                          <p>



                            <?= lang('form_sub_title'); ?>



                          </p>



                        </div>



                      </div>



                      <div class="row">



                        <div class="input-field col-md-6">



                          <p class="title">



                            <?= lang('entrance');  ?>



                          </p>



                          <input name="area" type="number" />



                          <p>



                          </p>



                          <p>



                            <?= lang('entrance_sub_title');  ?>



                          </p>



                          <p>



                            <?= lang('complement');  ?>



                          </p>



                        </div>



                      </div>



                    </div>



                  </div>



                </div>



              </div>



              <div class="row">



                <div class="input-field col s12 m6">



                  <p class="title">



                    <?= lang('pollen');  ?>*



                  </p>



                  <p class="under_title">



                    <?= lang('pollen_sub_title');  ?>



                  </p>



                  <select name="pollen" onChange="checkPollen(this.value)">



                    <option selected value="" disabled selected>



                      <?= lang('choose'); ?>



                    </option>



                    <option value="Oui">



                      <?= lang('pollen1'); ?>



                    </option>



                    <option value="Non">



                      <?= lang('pollen2'); ?>



                    </option>



                    <option value="ne sais pas">



                      <?= lang('dont_know'); ?>



                    </option>



                  </select>

                  <div id="pollen_error"></div>



                </div>



              </div>



              <section id="notPollen" style="display:none">



                <div class="input-field col m12 s12">



                  <h3>



                    <p>



                      <?= lang('flights'); ?>



                    </p>



                  </h3>



                  <p>



                    <label>



                      <input class="first_check" name="flights" value="Oui" type="radio" />



                      <span class="f_extended">



                        <?= lang('yes'); ?>



                      </span>



                    </label>



                  </p>



                  <p>



                    <label>



                      <input name="flights" value="Non" type="radio" />



                      <span class="f_extended">



                        <?= lang('no'); ?>



                      </span>



                    </label>



                  </p>



                  <p>



                    <label>



                      <input name="flights" value="Ne sais pas" type="radio" />



                      <span class="f_extended">



                        <?= lang('dont_know'); ?>



                      </span>



                    </label>



                  </p>

                  <div id="flights_error"></div>



                </div>



                <div class="input-field col m12 s12">



                  <h3>



                    <p>



                      <?= lang('fight'); ?>



                    </p>



                  </h3>



                  <p>



                    <label>



                      <input class="first_check" name="fight_with_workers" value="Oui" type="radio" />



                      <span class="f_extended">



                        <?= lang('yes'); ?>



                      </span>



                    </label>



                  </p>



                  <p>



                    <label>



                      <input name="fight_with_workers" value="Non" type="radio" />



                      <span class="f_extended">



                        <?= lang('no'); ?>



                      </span>



                    </label>



                  </p>



                  <p>



                    <label>



                      <input name="fight_with_workers" value="Ne sais pas" type="radio" />



                      <span class="f_extended">



                        <?= lang('dont_know'); ?>



                      </span>



                    </label>



                  </p>

                  <div id="fight_with_workers_error"></div>



                </div>



                <div class="input-field col m12 s12">



                  <h3>



                    <p>



                      <?= lang('waste_wax'); ?>



                    </p>



                  </h3>



                  <p>



                    <label>



                      <input class="first_check" name="waste_wax" value="Oui" type="radio" />



                      <span class="f_extended">



                        <?= lang('yes'); ?>



                      </span>



                    </label>



                  </p>



                  <p>



                    <label>



                      <input name="waste_wax" value="Non" type="radio" />



                      <span class="f_extended">



                        <?= lang('no'); ?>



                      </span>



                    </label>



                  </p>



                  <p>



                    <label>



                      <input name="waste_wax" value="Ne sais pas" type="radio" />



                      <span class="f_extended">



                        <?= lang('dont_know'); ?>



                      </span>



                    </label>



                  </p>

                  <div id="waste_wax_error"></div>



                </div>



                <div class="input-field col m12 s12">



                  <h3>



                    <p>



                      <?= lang('entries_exist'); ?>



                    </p>



                  </h3>



                  <p>



                    <label>



                      <input class="first_check" name="entries_exits" value="Oui" type="radio" />



                      <span class="f_extended">



                        <?= lang('yes'); ?>



                      </span>



                    </label>



                  </p>



                  <p>



                    <label>



                      <input name="entries_exits" value="Non" type="radio" />



                      <span class="f_extended">



                        <?= lang('no'); ?>



                      </span>



                    </label>



                  </p>



                  <p>



                    <label>



                      <input name="entries_exits" value="Ne sais pas" type="radio" />



                      <span class="f_extended">



                        <?= lang('dont_know'); ?>



                      </span>



                    </label>



                  </p>

                  <div id="entries_exits_error"></div>



                </div>



              </section>



              <div class="row">



                <div class="input-field col s12 m6">



                  <p class="title">



                    <?= lang('activity'); ?>



                  </p>



                  <p class="under_title">



                    <?= lang('activity_sub_title'); ?>



                  </p>



                  <select name="activity">



                    <option selected value="" disabled>



                      <?= lang('choose'); ?>



                    </option>



                    <option value="Forte, plus de 25 abeilles">



                      <?= lang('activity1'); ?>



                    </option>



                    <option value="Modérée, 10 à 25 abeilles">



                      <?= lang('activity2') ?>



                    </option>



                    <option value="Faible, 1 à 9 abeilles">



                      <?= lang('activity3') ?>



                    </option>



                    <option value="Nulle, 0 abeilles">



                      <?= lang('activity5') ?>



                    </option>



                    <option value="ne sais pas">



                      <?= lang('activity4') ?>



                    </option>



                  </select>

                  <div id="activity_error"></div>



                </div>



              </div>



              <div class="row">



                <div class="input-field col s12 m6">



                  <p class="title">



                    <?= lang('temperature'); ?>*



                  </p>



                  <input name="temperature" placeholder="" id="" type="number" />



                  <p>



                    <?= lang('temperature_sub_title');  ?>



                  </p>

                  <div id="temperature_error"></div>



                </div>



              </div>



              <!-- check box -->



              <div class="row">



                <div class="input-field col m6 s12 mycheckbox">



                  <p class="title">



                    <?= lang('conditions'); ?>*



                  </p>



                  <p class="under_title">



                    <?= lang('conditions_sub_title'); ?>



                  </p>



                  <p>



                    <label>



                      <input name="weather_situation[]" value="Soleil" type="checkbox" class="filled-in " />



                      <span class="f_extended">



                        <?= lang('conditions1') ?>



                      </span>



                    </label>



                  </p>



                  <p>



                    <label>



                      <input name="weather_situation[]" value="Eclaircies" type="checkbox" class="filled-in" />



                      <span class="f_extended">



                        <?= lang('conditions2') ?>



                      </span>



                    </label>



                  </p>



                  <p>



                    <label>



                      <input name="weather_situation[]" value="Nuages" type="checkbox" class="filled-in" />



                      <span class="f_extended">



                        <?= lang('conditions3') ?>



                      </span>



                    </label>



                  </p>



                  <p>



                    <label>



                      <input name="weather_situation[]" value="Vent" type="checkbox" class="filled-in" />



                      <span class="f_extended">



                        <?= lang('conditions4') ?>



                      </span>



                    </label>



                  </p>



                  <p>



                    <label>



                      <input name="weather_situation[]" value="Pluie" type="checkbox" class="filled-in" />



                      <span class="f_extended">



                        <?= lang('conditions5') ?>



                      </span>



                    </label>



                  </p>



                  <div id="errrorWeather"></div>



                </div>







              </div>



              <div class="row">



                <div class=" col-md-6">



                  <p class="title">



                    <?= lang('information'); ?>*



                  </p>

                  <textarea class="form-control" name="detailed_information" rows="5" id="comment"></textarea>





                  </textarea>

                  <div id="detailed_information_error"></div>



                </div>



              </div>



              <!-- extra content1 -->



              <div class="row">



                <div class="input-field col m12 s12">



                  <p class="title">



                    <?= lang('contact'); ?> *



                  </p>



                  <p class="under_title">



                    <?= lang('contact_sub_title'); ?>



                  </p>



                  <p>



                    <label>



                      <input name="findPro" id="findPro" type="checkbox" class="filled-in">



                      <span style="font-size:17px;">



                        <?= lang('entree'); ?>



                      </span>



                    </label>



                  </p>



                </div>



              </div>



              <div style="padding: 0 0 20px 0;" class="row">



                <div class="input-field col s12">



                  <input type="submit" class="pinbuttons1" id="btnSubmit" value="<?php echo lang('submit_reporting'); ?>" />



                </div>



              </div>



            </form>



            <!-- validate_problem -->







            <script>
              $(document).ready(function() {



                $("#collapse_a").click(function() {



                  // $("#collapse2").slideDown();



                });



              });
            </script>



            <script>
              $(document).ready(function() {



                $(".accordion_section").slideUp();



                $(".site_is_tree").click(function() {



                  $(".accordion_section").slideDown();



                });



                $(".site_is_not_tree").click(function() {



                  $(".accordion_section").slideUp();



                });



                //  $(".f_extended").css("font-size","15px");



              });
            </script>



            <?php



            include_once "location_js.php";



            ?>



          <?php



          }



          ?>



        </div>



      </div>



    </div>



  <?php } else { ?>



    <div class="container">



      <div class="jumbotron">



        <h1 class="h1">



          <?= lang('must_login'); ?>



          <br>



          <br>



          <center>



            <a class="pinbuttons1" href="user/login">



              <?= lang('login'); ?>



            </a>



          </center>



        </h1>



      </div>



    </div>



  <?php } ?>



  <!--  -->



</body>







</html>





















<script src="https://unpkg.com/exif-js@2.2.1"></script>

<script>
  (function() {



    document.getElementById("choose_file").onchange = function(el) {



      // alert("haris");



      // readURL(this)



      EXIF.getData(el.target.files[0], function() {



        EXIF.getData(this, () => {



          if (Object.keys(this.exifdata).length > 0) {





            let my_date = this.exifdata.DateTime.split(" ");



            my_date = my_date[0].split(":");



            my_date = my_date[0] + '-' + my_date[1] + '-' + my_date[2];



            // $("input[name='date']").val(date[0]);



            $("#my_date").val(my_date);



            //display camera details    



            // camera_details(this.exifdata)



            //display image details



            generate_lat_lang(this)



            // poka



          } else {



            $("#address").val($("#dumy_address").val());

            $("#lat_val").html("Latitude " + $("#lat_dummy").html() + " | ");

            $("#lon_val").html("Longitude " + $("#lon_dummy").html());
            $("#lat").val($("#lat_dummy").html());
            $("#lon").val($("#lon_dummy").html());



            // var d = new Date();



            // var strDate = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate();



            // alert(strDate);



            // $("#my_date").val(strDate);



            let d = new Date().toISOString();



            // alert(d);



            d = d.split("-");







            let today = d[2].substr(0, 2);







            d = `${d[0]}-${d[1]}-${today}`;







            $("#my_date").val(d);



          }



        });



      });



    }



  })();







  function get_address(latitude, longitude) {



    var request = new XMLHttpRequest();



    var method = 'GET';



    var url = 'https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyCzfWLHgFNaUiwqWhPQsoVB97kgQjPx1XM&latlng=' + latitude + ',' + longitude + '&sensor=false';



    var async = true;



    request.open(method, url, async);



    request.onreadystatechange = function() {



      if (request.readyState == 4 && request.status == 200) {



        var data = JSON.parse(request.responseText);



        var address = data.results[1];



        console.log(data.results);;



        $("#address").val(address.formatted_address);



      }



    };



    request.send();



  }







  function generate_lat_lang(imageData = '') {



    //geting cordinates of latitude



    var latDegree = imageData.exifdata.GPSLatitude[0].numerator;





    var latMinute = imageData.exifdata.GPSLatitude[1].numerator;



    var latSecond = imageData.exifdata.GPSLatitude[2].numerator / imageData.exifdata.GPSLatitude[2].denominator;



    let lat_val = (latDegree + (latMinute / 60) + (latSecond / 3600));

    $("#lat_val").html("Latitude:" + lat_val + "  |  ");
    $("#lat").val(lat_val);


    // document.getElementById("Lati").innerText = (latDegree + (latMinute / 60) + (latSecond / 3600)).toFixed(8);;



    // //geting cordinates of longitude



    var lonDegree = imageData.exifdata.GPSLongitude[0].numerator;



    var lonMinute = imageData.exifdata.GPSLongitude[1].numerator;



    var lonSecond = imageData.exifdata.GPSLongitude[2].numerator / imageData.exifdata.GPSLongitude[2].denominator;



    let long_val = (lonDegree + (lonMinute / 60) + (lonSecond / 3600));

    $("#lon_val").html("Longitude:" + long_val);
    $("#lon").val(long_val);

    // alert("working");



    get_address(lat_val, long_val);



  }



  function checkPollen(nest) {



    if (nest != "Oui") {



      // show all questions







      $("#notPollen").show();







    } else {

      // loosing data if pollen is not oui

      $("#notPollen").hide();



    }



  }



  $("#browser").on("change", function() {



    var site_tree_val = $(this).val();



    if (site_tree_val == "Arbre") {



      //  $("#collapse2").slideDown();



      $(".site_tree").hide();



      $(".accordion_section").slideDown();



      $(".accordion_section").removeClass('hidden');



      $("#extra_info").hide();



      $("#extra_info_val").val('');



    } else if (site_tree_val == "Autre") {



      $("#extra_info").show();



      $(".site_tree").hide();



      $(".accordion_section").slideUp();



      // $("#collapse2").slideUp();



      // lossing data inside collapse 2



      $("input[name='height']").val('');



      $("input[name='tree_genes']").val('');



      $("input[name='tree_alive']").each(function() {



        $(this).prop('checked', false);



      });



      $('#orientation_select option:selected').removeAttr('selected');



      $('#orientation_select').prop('selectedIndex', 0);



      $("input[name='shape']").val('');



      $("input[name='area']").val('');



      $("input[name='colonie_dimension']").val('');



    } else {



      $(".accordion_section").slideUp();



      // $("#collapse2").slideUp();



      $(".site_tree").show();



      $("#extra_info").hide();



      $("#extra_info_val").val('');



      // lossing data inside collapse 2



      $("input[name='height']").val('');



      $("input[name='tree_genes']").val('');



      $("input[name='tree_alive']").each(function() {



        $(this).prop('checked', false);



      });



      $('#orientation_select option:selected').removeAttr('selected');



      $('#orientation_select').prop('selectedIndex', 0);



      $("input[name='shape']").val('');



      $("input[name='area']").val('');



      $("input[name='colonie_dimension']").val('');



    }



  });



  function validateSearch() {
    if ($("#radius").val() == "") {
      alert("<?php echo lang('please_add_radius') ?>");
      return false;
    }



    $('#loader').removeClass('hidden');



    var geocoder = new google.maps.Geocoder();



    var ad = document.getElementById("address").value;



    geocoder.geocode({



        address: ad,



      },



      function(results) {



        $("#lat").val(results[0].geometry.location.lat());



        $("#lon").val(results[0].geometry.location.lng());



      }



    );



    setTimeout(() => {



      let lat = $("#lat").val();



      let long = $("#lon").val();



      let radius = $("#radius").val();

      radius = radius / 1000;

      var formData = new FormData();



      formData.append('lat', lat);



      formData.append('long', long);



      formData.append('radius', radius);



      $.ajax({



        url: "<?php echo  base_url() . '/map/check_nest'; ?>",



        type: "post",



        data: formData,



        cache: false,



        contentType: false,



        processData: false,



        dataType: 'json',



        // beforeSend: function() {



        // },



        success: function(response) {



          $('#loader').addClass('hidden');



          if (response.status == 200) {



            let my_url = "latitude=" + lat + "&longitude=" + long + "&radisfilter=" + radius + "&sbmitbtn=Envoyer";



            window.location.href = "<?php echo base_url() . 'map/index?' ?>" + my_url;



          } else {


            alert("<?php echo lang('no_nest_found') ?>");




          }



        }



      });



    }, 2000);



  }











  function searchAutocomplete() {







    var fillInAddress;







    // Create the autocomplete object, restricting the search to geographical







    // location types.







    autocomplete = new google.maps.places.Autocomplete((







        document.getElementById('address')), {







        types: ['geocode']







      }








    );







    autocomplete.addListener('place_changed', fillInAddressMY);







  }
</script>



<script>
  $("#nest_insert_form").on("submit", function(e) {



    e.preventDefault();


    if (!$("#nest_insert_form").valid()) {

      return false;

    }


    let lat_coordinate = $("#lat").val();
    let lon_coordinate = $("#lon").val();

    // if (lat_coordinate == "" && lon_coordinate == "") {

    var geocoder = new google.maps.Geocoder();



    var ad = document.getElementById("address").value;



    geocoder.geocode({



        address: ad,



      },



      function(results) {



        $("#lat").val(results[0].geometry.location.lat());



        $("#lon").val(results[0].geometry.location.lng());



        // console.log(results[0].geometry.location.lat()); //LatLng



        // console.log(results[0].geometry.location.lng()); //LatLng



      }



    );
    // }

    setTimeout(() => {

      var formData = new FormData();

      var other_data = $('#nest_insert_form').serializeArray();

      $.each(other_data, function(key, input) {

        formData.append(input.name, input.value);

      });
      if ($("#hide_location").prop('checked') == true) {
        formData.append('hide_location', 'on');
      } else {
        formData.append('hide_location', 'off');
      }



      totalfiles = document.getElementById('choose_file').files.length;



      if (totalfiles > 0) {



        for (var index = 0; index < totalfiles; index++) {



          formData.append("images[]", document.getElementById('choose_file').files[index]);



        }
      }

      $('input[name="weather_situation"]:checked').each(function() {

        formData.append("weather_situation[]", $(this).val());

      });

      let val_attr;

      val_attr = $("select[name='nesting_type']").val();

      if (val_attr == null) {

        val_attr = "";

      }

      formData.append("nesting_type", val_attr);

      val_attr = $("select[name='pollen']").val();

      if (val_attr == null) {

        val_attr = "";

      }

      formData.append("pollen", val_attr);

      val_attr = $("select[name='activity']").val();

      if (val_attr == null) {

        val_attr = "";

      }

      formData.append("activity", val_attr);

      // complete_insert



      $.ajax({

        url: "<?php echo  base_url() . 'map/complete_insert'; ?>",

        type: "post",

        data: formData,

        cache: false,

        contentType: false,

        processData: false,

        dataType: 'json',

        beforeSend: function() {

          $('#loader').removeClass('hidden');

          // $('#btnsignup1').prop("disabled", true);

          // $('#btnsignup1').val('Creating...');

          // add spinner to button

        },

        success: function(response) {

          $('#loader').addClass('hidden');

          $("#msgs").removeClass("alert-danger alert-success");

          $("#msgs").html("");

          //console.log(response);

          if (response.status == 100) {

            $("#msgs").addClass("alert-danger");

            $("#msgs").html(response.message);

            $("#msgs").show('slow');

            setTimeout(() => {

              $("#msgs").hide("slow");

            }, 3000);

            // $('#btnsignup1').val('Create Account');

            // swal("Email Already Exist!", {

            //   icon: "error",

            // });

          }

          if (response.status == 200) {

            window.location.href = response.redirect;

          }





          if (response.status == 201) {

            window.location.href = response.redirect;

          }









        }

      });







    }, 1000);



  });



  function lat_lon(e, form = '') {



    e.preventDefault();







    $('#loader').removeClass('hidden');



    var geocoder = new google.maps.Geocoder();



    var ad = document.getElementById("address").value;



    geocoder.geocode({



        address: ad,



      },



      function(results) {



        $("#lat").val(results[0].geometry.location.lat());



        $("#lon").val(results[0].geometry.location.lng());



        // console.log(results[0].geometry.location.lat()); //LatLng



        // console.log(results[0].geometry.location.lng()); //LatLng



      }



    );



    setTimeout(() => {



      e.target.submit();



    }, 3000);



























  }
</script>