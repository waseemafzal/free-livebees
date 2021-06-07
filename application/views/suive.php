<!DOCTYPE html>

<html lang="en">



<head>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" />

  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

  <!-- Compiled and minified JavaScript -->

  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAaqEI1hEro18UDNXVHKnQ5dc6A_vF-crY&libraries=places&callback=initAutocomplete" async defer></script>



  <!--  -->

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



              reader.onload = function(event) {

                $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(imgPreviewPlaceholder);

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



  <!--  -->



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

  <!--script for update image  -->

  <script>
    $(document).ready(function() {

      $('label#del_icon').click(function() {

        var id = $(this).data('id');

        var element = this;

        if (confirm("Are You Sure to Delete this picture???")) {



          $.ajax({

            url: "<?php echo  base_url() . 'map/del_image'; ?>",

            type: "POST",

            data: {

              image_id: id

            },

            success: function(data) {

              if (data == 1) {



                alert('your images is deleted');

                $(element).closest("div").fadeOut();

              } else {

                alert('image is not deleted..check ur query');

              }





            }

          });

        }

      });



    });
  </script>





  <!--  -->





  <!-- ////////////////////// -->

  <!-- Compiled and minified CSS -->

  <!-- /////////// -->

  <style>
    label#del_icon {

      position: relative;

      top: -140px;

      left: -15px;

      color: red;

      font-size: 30px;

      cursor: pointer;

    }



    label#del_icon:hover {

      font-size: 35px;

    }



    a.btn_behave {

      background-color: #c2ae13;

    }







    /* main container */

    div.form_container {

      width: 100%;

    }



    div.form_container>div.main_form {

      width: 70%;

      margin: 0 auto;

      padding: 2% 0 0 0;

    }



    div.texte>* {

      color: #c2ae13;

      font-size: 20px;

    }



    .imgGallery img {

      height: 25vh;

      padding: 8px;

      width: 25%;

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

      color: #c2ae13;

    }



    div.form_content>p {

      text-align: justify;

    }



    div.input-field>p.radio_content {

      font-size: 18px;

    }



    div.input-field>label.notification {

      font-size: 15px;

    }



    select {

      display: block;

    }
  </style>



  <meta charset="UTF-8" />

  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <title>Document</title>

</head>



<body>

  <!--  -->

  <div class="form_container">

    <div class="main_form">

      <div class="texte col s12 m6">

        <div class="texte">

          <h2 _ngcontent-hqf-c567="" style="

                color: rgb(194, 174, 19);

                font-family: Lato;

                font-weight: normal;

                font-style: normal;

                font-variant: normal;

                font-size: 44px;

              ">

            SUIVI ( dans résultat Recherche)

          </h2>

          <p>

            Merci pour votre aide dans le suivi des sites de nidification

            d'essaims sauvages d'abeilles.

          </p>

          <p>

            Pour les renseignements obligatoires signalés par

            <strong>*</strong> dont vous ne connaissez pas la réponse,

            indiquez "Je ne sais pas".

          </p>

        </div>

        <br class="clear" />

      </div>

      <?php

      if (isset($update)) {

        //  pre($data);

        $result = $data->row();

      ?>



        <form class="col s12" method="POST" action="<?php echo base_url() . 'map/edit_suivi_form'; ?>" enctype="multipart/form-data" ">

       



          <!-- address -->

          <div class=" row">

          <h5>Adresse *</h5>

          <div class="input-field col s12">

            <input required id="address" value="<?php echo $result->address; ?>" type="text" name="address" class="validate" />

            <label for="address">Adresse</label>

          </div>



          <!--Adress End  -->

          <!--complemetn address -->

          <div class="row">

            <div class="input-field col s12">

              <input required name="additional_address" value="<?php echo $result->additional_address; ?>" id="address1" type="text" class="validate" />

              <label for="address1">Complément d’adresse</label>

            </div>

          </div>

          <!--complemetn address end-->

          <!-- ville / etat region -->

          <div class="row">

            <div class="input-field col m6 s12">

              <input required name="city" value="<?php echo $result->city; ?>" placeholder="ville" id="ville" type="text" class="validate" />

              <label for="ville">Ville</label>

            </div>

            <div class="input-field col m6 s12">

              <input required name="state_region" value="<?php echo $result->state_region; ?>" id="region" type="text" placeholder="Etat / Région" class="validate" />

              <label for="region">Etat / Région</label>

            </div>

          </div>



          <!-- ville / etat regon end -->

          <!-- postal code and pays -->

          <div class="row">

            <div class="input-field col s6">

              <input required name="postal_code" value="<?php echo $result->postal_code; ?>" placeholder="Postal Code" id="ville" type="number" class="validate" />

              <label for="ville">Code Postal</label>

            </div>





            <div class="input-field col s6">

              <select required name="country">

                <option selected value="<?php echo $result->country; ?>"><?php echo $result->country; ?></option>

                <?php if ($result->country != 'france') { ?>

                  <option value="france">France</option>

                <?php } ?>

                <?php if ($result->country != 'pakistan') { ?>

                  <option value="pakistan">Pakistan</option> <?php } ?>

                <?php if ($result->country != 'india') { ?>

                  <option value="india">India</option> <?php } ?>

              </select>

            </div>

            <!-- select box ending -->

          </div>





          <!-- date time picker start -->

          <div class="date_picker col s12 m6">

            <h5>Date *</h5>

            <p>Indiquer la date de l'observation</p>

            <input required type="date" value="<?php echo $result->date; ?>" name="date" id="" />

          </div>

          <!-- date picker end -->



          <div class="time_picker col s12 m6">

            <h5>Heure de début *</h5>

            <p>Indiquer l'heure du début de l'observation</p>

            <input required type="time" value="<?php echo $result->time; ?>" name="time" id="" />

          </div>

          <!-- radio button -->

          <div class="row">

            <div class="input-field col s12 m6">

              <p class="radio_content">

                Colonie en cavité naturelle, artificielle ou à l'air libre

              </p>

              <p class="radio_content">

                Indiquer si la colonie s'est installée dans une cavité

                naturelle, artificielle ou à l'air libre

              </p>

              <p>



                <label>

                  <input name="place" type="radio" value="<?php echo $result->place; ?>" checked />

                  <span><?php echo $result->place; ?></span>

                </label>





              </p>





              <!-- 1st -->

              <?php if ($result->place != 'Cavité naturelle') { ?>

                <p>



                  <label>

                    <input name="place" type="radio" value="Cavité naturelle" checked />

                    <span>Cavité naturelle</span>

                  </label>





                <?php

              }

                ?>

                <!-- second -->

                <?php if ($result->place != 'Cavité artificielle') { ?>

                <p>



                  <label>

                    <input name="place" type="radio" value="Cavité artificielle" checked />

                    <span>Cavité artificielle</span>

                  </label>





                <?php

                }

                ?>

                <!-- third -->

                <?php if ($result->place != "A l'air libre") { ?>

                <p>



                  <label>

                    <input name="place" type="radio" value="A l'air libre" />

                    <span>A l'air libre</span>

                  </label>





                <?php

                }

                ?>

            </div>

          </div>

          <!-- radio button end -->

          <!-- notification start -->

          <div class="row">

            <div class="input-field col s12">

              <label class="notification" for="notification">Type de site de nidification *</label>

              <input required name="nesting_type" value="<?php echo $result->nesting_type; ?>" placeholder="" id="notification" type="text" class="validate" />

              <p>

                Indiquer le type de support de la colonie, i.e. site de

                nidification. Ex: Arbre, cheminée, falaise, etc.

              </p>

            </div>

          </div>

          <!-- notification_end -->

          <!-- after notification -->

          <div class="row">

            <div class="input-field col s12 m6">

              <h4>Température (°C)</h4>



              <input required name="temperature" value="<?php echo $result->temperature; ?>" placeholder="" id="" type="number" class="validate" />

              <p>

                Idéalement, l'observation se fait à des températures

                supérieures à 16°C.

              </p>

            </div>

          </div>



          <div class="row">

            <div class="input-field col m6 s12">

              <h5>Conditions météorologiques *</h5>

              <p>

                Cochez toutes les conditions météorologiques réunies lors de

                l'observation. Idéalement, l'observation se fait sans vent ni

                pluie.

              </p>

              <?php

              $w_situation = explode(",", $result->weather_situation);



              foreach ($w_situation as $w_s) { ?>

                <p>

                  <label>

                    <input name="weather_situation[]" value="<?php echo $w_s; ?>" type="checkbox" class="filled-in" checked="checked" />

                    <span><?php echo $w_s; ?></span>

                  </label>

                </p>

              <?php

              }

              ?>

              <?php

              $arr = array('Soleil', 'Eclaircies', 'Nuages', 'Vent', 'Pluie');





              for ($i = 0; $i <= count($arr) - 1; $i++) {





                if (!in_array($arr[$i], $w_situation)) { ?>

                  <p>

                    <label>

                      <input name="weather_situation[]" value="<?php echo $arr[$i]; ?>" type="checkbox" class="filled-in" />

                      <span><?php echo $arr[$i]; ?></span>

                    </label>

                  </p>

              <?php



                }
              }

              ?>

            </div>

          </div>



          <div class="row">

            <div class="input-field col m6 s12">

              <p>ÉLEMENTS POUR ESTIMATION DE L'ACTIVITÉ DU NID</p>

              <p>Nombre d'abeilles entrant avec du pollen en 1 min</p>



              <input required name="bees_in_pollen" value="<?php echo $result->bees_in_pollen; ?>" placeholder="" id="notification" type="number" class="validate" />

              <p>

                En vous chronométrant, indiquez combien d'abeilles sortent du

                le site en 1 minute

              </p>

            </div>

          </div>



          <div class="row">

            <div class="input-field col s12 m6">

              <h6>

                S'il est impossible de compter le nombre d'abeilles entrant

                avec du pollen ou si vous n'en voyez pas, vérifiez les

                critères suivants :

              </h6>

              <h5>Activité (en nombre d'abeilles) *</h5>

              <p>Indiquer le niveau d'activité au trou d'envol</p>

              <select required name="activity">



                <option selected value="<?php echo $result->activity; ?>"> <?php echo $result->activity; ?></option>

                <?php if ($result->activity != 'Forte (+ de 25 abeilles)') { ?>

                  <option value=" Forte (+ de 25 abeilles)">

                    Forte (+ de 25 abeilles)

                  </option>

                <?php } ?>

                <?php if ($result->activity != 'Modérée (10 à 25 abeilles)') { ?>

                  <option value="Modérée (10 à 25 abeilles)">Modérée (10 à 25 abeilles)</option>

                <?php } ?>

                <?php if ($result->activity != 'Faible (1 à 9 abeilles)') { ?>

                  <option value="Faible (1 à 9 abeilles)">Faible (1 à 9 abeilles)</option>

                <?php } ?>

                <?php if ($result->activity != 'Nulle (0 abeilles)') { ?>

                  <option value="Nulle (0 abeilles)">Nulle (0 abeilles)</option>

                <?php } ?>

                <?php if ($result->activity != 'Je ne sais pas') { ?>

                  <option value="Je ne sais pas">Je ne sais pas</option>

                <?php } ?>

              </select>

            </div>

          </div>



          <div class="row">

            <div class="input-field col s12">

              <h5>Y a-t-il des gardiennes ? *</h5>

              <!--  -->

              <p>



                <label>

                  <input checked name="babysitters" type="radio" value="<?php echo $result->babysitters; ?>" checked />

                  <span><?php echo $result->babysitters; ?></span>

                </label>





              </p>

              <?php

              if ($result->babysitters != "Oui") { ?>

                <p>

                  <label>

                    <input name="babysitters" value="Oui" type="radio" />

                    <span>Oui</span>

                  </label>

                </p>



              <?php

              }

              ?>



              <?php

              if ($result->babysitters != "Non") { ?>

                <p>

                  <label>

                    <input name="babysitters" value="Non" type="radio" />

                    <span>Non</span>

                  </label>

                </p>



              <?php

              }

              ?>





              <!--  -->





            </div>

          </div>

          <!--  -->

          <div class="row">

            <div class="input-field col s12">

              <h5>Les vols se font-ils en lignes droites ? *</h5>



              <!-- start -->

              <p>



                <label>

                  <input checked name="flights" type="radio" value="<?php echo $result->flights; ?>" checked />

                  <span><?php echo $result->flights; ?></span>

                </label>





              </p>

              <?php

              if ($result->flights != "Oui") { ?>

                <p>

                  <label>

                    <input name="flights" value="Oui" type="radio" />

                    <span>Oui</span>

                  </label>

                </p>



              <?php

              }

              ?>



              <?php

              if ($result->flights != "Non") { ?>

                <p>

                  <label>

                    <input name="flights" value="Non" type="radio" />

                    <span>Non</span>

                  </label>

                </p>



              <?php

              }

              ?>

              <!-- end -->







            </div>

          </div>

          <div class="row">

            <div class="input-field col s12">

              <h5>Y a-t-il combat entre ouvrières ? *</h5>

              <!-- start -->

              <p>



                <label>

                  <input checked name="fight_with_workers" type="radio" value="<?php echo $result->fight_with_workers; ?>" checked />

                  <span><?php echo $result->fight_with_workers; ?></span>

                </label>





              </p>

              <?php

              if ($result->fight_with_workers != "Oui") { ?>

                <p>

                  <label>

                    <input name="fight_with_workers" value="Oui" type="radio" />

                    <span>Oui</span>

                  </label>

                </p>



              <?php

              }

              ?>



              <?php

              if ($result->fight_with_workers != "Non") { ?>

                <p>

                  <label>

                    <input name="fight_with_workers" value="Non" type="radio" />

                    <span>Non</span>

                  </label>

                </p>



              <?php

              }

              ?>

              <!-- end -->



            </div>

          </div>

          <div class="row">

            <div class="input-field col s12">

              <h5>

                Y a-t-il des déchets de cire devant l'entrée ou au sol? *

              </h5>

              <!-- start -->

              <p>



                <label>

                  <input checked name="waste_wax" type="radio" value="<?php echo $result->waste_wax; ?>" checked />

                  <span><?php echo $result->waste_wax; ?></span>

                </label>





              </p>

              <?php

              if ($result->waste_wax != "Oui") { ?>

                <p>

                  <label>

                    <input name="waste_wax" value="Oui" type="radio" />

                    <span>Oui</span>

                  </label>

                </p>



              <?php

              }

              ?>



              <?php

              if ($result->waste_wax != "Non") { ?>

                <p>

                  <label>

                    <input name="waste_wax" value="Non" type="radio" />

                    <span>Non</span>

                  </label>

                </p>



              <?php

              }

              ?>

              <!-- end -->



            </div>

          </div>

          <div class="row">

            <div class="input-field col s12">

              <h5>

                Y a-t-il des entrées/sorties de frelons ou de guêpes ? *

              </h5>

              <!-- start -->

              <p>



                <label>

                  <input checked name="hornets" type="radio" value="<?php echo $result->hornets; ?>" checked />

                  <span><?php echo $result->hornets; ?></span>

                </label>





              </p>

              <?php

              if ($result->hornets != "Oui") { ?>

                <p>

                  <label>

                    <input name="hornets" value="Oui" type="radio" />

                    <span>Oui</span>

                  </label>

                </p>



              <?php

              }

              ?>



              <?php

              if ($result->hornets != "Non") { ?>

                <p>

                  <label>

                    <input name="hornets" value="Non" type="radio" />

                    <span>Non</span>

                  </label>

                </p>



              <?php

              }

              ?>

              <!-- end -->



            </div>

          </div>



          <div class="row">

            <div class="input-field col s12">

              <p>Si l'essaim précédemment signalé a disparu :</p>

              <p>

                La cavité est-elle occupée par une autre espèce ? Si oui,

                laquelle ?

              </p>



              <input required placeholder="" name="cavity" value="<?php echo $result->cavity; ?>" id="notification" type="text" class="validate" />

              <p>

                Indiquer la ou les espèces (autre insecte que l'abeille,

                oiseau, mammifère…) qui occupent le site de nidification

                anciennement occupé par des abeilles mellifères

              </p>

            </div>

          </div>

          <!--  -->

          <div class="row">

            <div class="input-field col s12">

              <h5>Recupération par un apiculteur?</h5>

              <p>

                Si vous détenez l'information, indiquez si l'essaim

                anciennement occupant ce site de nidification a été récupéré

                par un apiculteur

              </p>



              <!-- start -->

              <p>



                <label>

                  <input checked name="beekeeper_r" type="radio" value="<?php echo $result->beekeeper_r; ?>" checked />

                  <span><?php echo $result->beekeeper_r; ?></span>

                </label>





              </p>

              <?php

              if ($result->beekeeper_r != "Oui") { ?>

                <p>

                  <label>

                    <input name="beekeeper_r" value="Oui" type="radio" />

                    <span>Oui</span>

                  </label>

                </p>



              <?php

              }

              ?>



              <?php

              if ($result->beekeeper_r != "Non") { ?>

                <p>

                  <label>

                    <input name="beekeeper_r" value="Non" type="radio" />

                    <span>Non</span>

                  </label>

                </p>



              <?php

              }

              ?>



              <?php

              if ($result->beekeeper_r != "na sais pas") { ?>

                <p>

                  <label>

                    <input name="beekeeper_r" value="na sais pas" type="radio" />

                    <span>Non</span>

                  </label>

                </p>



              <?php

              }

              ?>

              <!-- end -->

            </div>

          </div>







          <div class="row">

            <div class="input-field col s12">

              <textarea required name="additional_information" id="" cols="40" rows="1" style="padding: 12px 10px" placeholder="Autres Informations"><?php echo $result->additional_information; ?></textarea>

              <p>Merci d'indiquer ici toute information complémentaire</p>

            </div>

          </div>

          <div class="row">

            <div class="input-field col s12">

              <div class="adjouter">

                <div class="file-field input-field">

                  <div class="btn">

                    <span>AJOUTER DES PHOTOS</span>

                    <input required id="choose_file" type="file" name="images[]" accept="image/*" multiple />

                  </div>



                  <div class="file-path-wrapper">

                    <input class="file-path validate" type="text" placeholder="Upload one or more files" />

                  </div>

                </div>

                <p>

                  Ajouter des photos pour actualiser le suivi du site de

                  nidification

                </p>

              </div>

              <div class="imgGallery">

                <?php





                foreach ($imagesData->result() as $im) {



                  echo "<div style='display:inline;'>";

                  echo '<img id="image" src="' . base_url() . 'uploads/images/' . $im->file . '" /><label id="del_icon" data-id="' . $im->id . '" >X</label>';

                  echo "</div>";
                }



                ?>

              </div>



              <div class="adjouter">

                <div class="file-field input-field">

                  <div class="btn">

                    <span>AJOUTER UNE VIDÉO</span>

                    <input required type="file" name="video" />

                  </div>

                  <div class="file-path-wrapper">

                    <input class="file-path validate" type="text" placeholder="Upload one or more files" />

                  </div>

                </div>

                <p>

                  Ajouter une vidéo de l'entrée du site de nidification

                  pour faciliter l'analyse de suivi du site de

                  nidification

                </p>

              </div>

            </div>

          </div>

          <div class="date_picker col s12 m6">

            <h5>Date de la prochaine observation prévue</h5>

            <p>Indiquer la prochaine date d'observation souhaitée</p>

            <input required type="date" name="date_picker" value="<?php echo $result->date_picker; ?>" id="" />

          </div>

          <!-- date picker end -->

          <!-- pending -->

          <div class="time_picker col s12 m6">

            <h5>Heure de fin (Automatique) *</h5>

            <p>Indiquer l'heure de fin de l'observation</p>

            <br />

            <input required type="time" name="time_picker" value="<?php echo $result->time_picker; ?>" id="" />

          </div>

          <div class="row">

            <div class="input-field col s12">

              <input type="hidden" name="nest_id" value="<?php echo $result->nest_id; ?>">

              <input type="hidden" name="id" value="<?php echo $result->id; ?>">

              <input type="submit" name="submit" class="btn waves-effect waves-light" value="Envoyer" />

            </div>

          </div>



    </div>

    </form>

  <?php

      } else {



  ?>

    <form class="col s12" method="POST" action="<?php echo base_url() . 'map/insert_suivi_form'; ?>" enctype="multipart/form-data" ">

        <div class=" row">



      <!-- address -->

      <div class=" row">

        <h5>Adresse *</h5>

        <div class="input-field col s12">

          <input required id="address" type="text" name="address" class="validate" />

          <label for="address">Adresse</label>

        </div>

      </div>

      <!--Adress End  -->

      <!--complemetn address -->

      <div class="row">

        <div class="input-field col s12">

          <input required name="additional_address" id="address1" type="text" class="validate" />

          <label for="address1">Complément d’adresse</label>

        </div>

      </div>

      <!--complemetn address end-->

      <!-- ville / etat region -->

      <div class="row">

        <div class="input-field col m6 s12">

          <input required name="city" placeholder="ville" id="ville" type="text" class="validate" />

          <label for="ville">Ville</label>

        </div>

        <div class="input-field col m6 s12">

          <input required name="state_region" id="region" type="text" placeholder="Etat / Région" class="validate" />

          <label for="region">Etat / Région</label>

        </div>

      </div>



      <!-- ville / etat regon end -->

      <!-- postal code and pays -->

      <div class="row">

        <div class="input-field col s6">

          <input required name="postal_code" placeholder="Postal Code" id="ville" type="number" class="validate" />

          <label for="ville">Code Postal</label>

        </div>





        <div class="input-field col s6">

          <select required name="country">

            <option selected value="france">france</option>

            <option value="pakistan">pakistan</option>

            <option value="india">india</option>

          </select>

        </div>

        <!-- select box ending -->

      </div>





      <!-- date time picker start -->

      <div class="date_picker col s12 m6">

        <h5>Date *</h5>

        <p>Indiquer la date de l'observation</p>

        <input required type="date" name="date" id="" />

      </div>

      <!-- date picker end -->



      <div class="time_picker col s12 m6">

        <h5>Heure de début *</h5>

        <p>Indiquer l'heure du début de l'observation</p>

        <input required type="time" name="time" id="" />

      </div>

      <!-- radio button -->

      <div class="row">

        <div class="input-field col s12 m6">

          <p class="radio_content">

            Colonie en cavité naturelle, artificielle ou à l'air libre

          </p>

          <p class="radio_content">

            Indiquer si la colonie s'est installée dans une cavité

            naturelle, artificielle ou à l'air libre

          </p>

          <p>

            <label>

              <input name="place" value="Cavité naturelle" type="radio" checked />

              <span>Cavité naturelle</span>

            </label>

          </p>

          <p>

            <label>

              <input name="place" value="Cavité artificielle" type="radio" />

              <span>Cavité artificielle</span>

            </label>

          </p>

          <p>

            <label>

              <input class="with-gap" value="A l'air libre" name="place" type="radio" />

              <span>A l'air libre</span>

            </label>

          </p>

        </div>

      </div>

      <!-- radio button end -->

      <!-- notification start -->

      <div class="row">

        <div class="input-field col s12">

          <label class="notification" for="notification">Type de site de nidification *</label>

          <input required name="nesting_type" placeholder="" id="notification" type="text" class="validate" />

          <p>

            Indiquer le type de support de la colonie, i.e. site de

            nidification. Ex: Arbre, cheminée, falaise, etc.

          </p>

        </div>

      </div>

      <!-- notification_end -->

      <!-- after notification -->

      <div class="row">

        <div class="input-field col s12 m6">

          <h4>Température (°C)</h4>



          <input required name="temperature" placeholder="" id="" type="number" class="validate" />

          <p>

            Idéalement, l'observation se fait à des températures

            supérieures à 16°C.

          </p>

        </div>

      </div>



      <div class="row">

        <div class="input-field col m6 s12">

          <h5>Conditions météorologiques *</h5>

          <p>

            Cochez toutes les conditions météorologiques réunies lors de

            l'observation. Idéalement, l'observation se fait sans vent ni

            pluie.

          </p>



          <p>

            <label>

              <input name="weather_situation[]" value="Soleil" type="checkbox" class="filled-in" checked="checked" />

              <span>Soleil</span>

            </label>

          </p>

          <p>

            <label>

              <input name="weather_situation[]" value="Eclaircies" type="checkbox" class="filled-in" />

              <span>Eclaircies</span>

            </label>

          </p>

          <p>

            <label>

              <input name="weather_situation[]" value="Nuages" type="checkbox" class="filled-in" />

              <span>Nuages</span>

            </label>

          </p>

          <p>

            <label>

              <input name="weather_situation[]" value="Vent" type="checkbox" class="filled-in" />

              <span>Vent</span>

            </label>

          </p>

          <p>

            <label>

              <input name="weather_situation[]" value="Pluie" type="checkbox" class="filled-in" />

              <span>Pluie</span>

            </label>

          </p>

        </div>

      </div>



      <div class="row">

        <div class="input-field col m6 s12">

          <p>ÉLEMENTS POUR ESTIMATION DE L'ACTIVITÉ DU NID</p>

          <p>Nombre d'abeilles entrant avec du pollen en 1 min</p>



          <input name="bees_in_pollen" placeholder="" id="notification" type="number" class="validate" />

          <p>

            En vous chronométrant, indiquez combien d'abeilles sortent du

            le site en 1 minute

          </p>

        </div>

      </div>



      <div class="row">

        <div class="input-field col s12 m6">

          <h6>

            S'il est impossible de compter le nombre d'abeilles entrant

            avec du pollen ou si vous n'en voyez pas, vérifiez les

            critères suivants :

          </h6>

          <h5>Activité (en nombre d'abeilles) *</h5>

          <p>Indiquer le niveau d'activité au trou d'envol</p>

          <select required name="activity">

            <option selected value=" Forte (+ de 25 abeilles)">

              Forte (+ de 25 abeilles)

            </option>

            <option value="Modérée (10 à 25 abeilles)">Modérée (10 à 25 abeilles)</option>

            <option value="Faible (1 à 9 abeilles)">Faible (1 à 9 abeilles)</option>

            <option value="Nulle (0 abeilles)">Nulle (0 abeilles)</option>

            <option value="Je ne sais pas">Je ne sais pas</option>

          </select>

        </div>

      </div>



      <div class="row">

        <div class="input-field col s12">

          <h5>Y a-t-il des gardiennes ? *</h5>



          <p>

            <label>

              <input name="babysitters" value="Oui" type="radio" />

              <span>Oui</span>

            </label>

          </p>

          <p>

            <label>

              <input name="babysitters" value="Non" type="radio" />

              <span>Non</span>

            </label>

          </p>

        </div>

      </div>

      <!--  -->

      <div class="row">

        <div class="input-field col s12">

          <h5>Les vols se font-ils en lignes droites ? *</h5>

          <p>

            <label>

              <input name="flights" value="Oui" type="radio" />

              <span>Oui</span>

            </label>

          </p>

          <p>

            <label>

              <input name="flights" value="Non" type="radio" />

              <span>Non</span>

            </label>

          </p>

        </div>

      </div>

      <div class="row">

        <div class="input-field col s12">

          <h5>Y a-t-il combat entre ouvrières ? *</h5>

          <p>

            <label>

              <input name="fight_with_workers" value="Oui" type="radio" />

              <span>Oui</span>

            </label>

          </p>

          <p>

            <label>

              <input name="fight_with_workers" value="Non" type="radio" />

              <span>Non</span>

            </label>

          </p>

        </div>

      </div>

      <div class="row">

        <div class="input-field col s12">

          <h5>

            Y a-t-il des déchets de cire devant l'entrée ou au sol? *

          </h5>

          <p>

            <label>

              <input name="waste_wax" value="Oui" type="radio" />

              <span>Oui</span>

            </label>

          </p>

          <p>

            <label>

              <input name="waste_wax" value="Non" type="radio" />

              <span>Non</span>

            </label>

          </p>

        </div>

      </div>

      <div class="row">

        <div class="input-field col s12">

          <h5>

            Y a-t-il des entrées/sorties de frelons ou de guêpes ? *

          </h5>

          <p>

            <label>

              <input name="hornets" value="Oui" type="radio" />

              <span>Oui</span>

            </label>

          </p>

          <p>

            <label>

              <input name="hornets" value="Non" type="radio" />

              <span>Non</span>

            </label>

          </p>

        </div>

      </div>



      <div class="row">

        <div class="input-field col s12">

          <p>Si l'essaim précédemment signalé a disparu :</p>

          <p>

            La cavité est-elle occupée par une autre espèce ? Si oui,

            laquelle ?

          </p>



          <input required placeholder="" name="cavity" id="notification" type="text" class="validate" />

          <p>

            Indiquer la ou les espèces (autre insecte que l'abeille,

            oiseau, mammifère…) qui occupent le site de nidification

            anciennement occupé par des abeilles mellifères

          </p>

        </div>

      </div>

      <!--  -->

      <div class="row">

        <div class="input-field col s12">

          <h5>Recupération par un apiculteur?</h5>

          <p>

            Si vous détenez l'information, indiquez si l'essaim

            anciennement occupant ce site de nidification a été récupéré

            par un apiculteur

          </p>

          <!-- chk -->

          <p>

            <label>

              <input name="beekeeper_r" value="Oui" type="radio" />

              <span>Oui</span>

            </label>

          </p>

          <p>

            <label>

              <input name="beekeeper_r" value="Non" type="radio" />

              <span>Non</span>

            </label>

          </p>

          <p>

            <label>

              <input name="beekeeper_r" value="na sais pas" type="radio" />

              <span>na sais pas</span>

            </label>

          </p>

          <div class="row">

            <div class="input-field col s12">

              <textarea required name="additional_information" id="" cols="40" rows="1" style="padding: 12px 10px" placeholder="Autres Informations"></textarea>

              <p>Merci d'indiquer ici toute information complémentaire</p>

            </div>

          </div>

          <div class="row">

            <div class="input-field col s12">

              <div class="adjouter">

                <div class="file-field input-field">

                  <div class="btn">

                    <span>AJOUTER DES PHOTOS</span>

                    <input required id="choose_file" type="file" name="images[]" accept="image/*" multiple />

                  </div>



                  <div class="file-path-wrapper">

                    <input class="file-path validate" type="text" placeholder="Upload one or more files" />

                  </div>

                </div>

                <p>

                  Ajouter des photos pour actualiser le suivi du site de

                  nidification

                </p>

              </div>

            </div>

            <div class="imgGallery">

            </div>





            <div class="input-field col s12">

              <div class="adjouter">

                <div class="file-field input-field">

                  <div class="btn">

                    <span>AJOUTER UNE VIDÉO</span>

                    <input required type="file" name="video" type="file" />

                  </div>

                  <div class="file-path-wrapper">

                    <input class="file-path validate" type="text" placeholder="Upload one or more files" />

                  </div>

                </div>

                <p>

                  Ajouter une vidéo de l'entrée du site de nidification

                  pour faciliter l'analyse de suivi du site de

                  nidification

                </p>

              </div>



            </div>



            <div class="date_picker col s12 m6">

              <h5>Date de la prochaine observation prévue</h5>

              <p>Indiquer la prochaine date d'observation souhaitée</p>

              <input required type="date" name="date_picker" id="" />

            </div>

            <!-- date picker end -->

            <!-- pending -->

            <div class="time_picker col s12 m6">

              <h5>Heure de fin (Automatique) *</h5>

              <p>Indiquer l'heure de fin de l'observation</p>

              <br />

              <input required type="time" name="time_picker" id="" />

            </div>

            <div class="row">

              <div class="input-field col s12">

                <input type="submit" name="submit" class="btn waves-effect waves-light" value="Envoyer" />

              </div>

            </div>

          </div>

        </div>

    </form>



  <?php

      }

  ?>

  </div>

  </div>

  </div>



  <!--  -->

</body>



</html>