<?php
$data = $val1;

$result = $data[0]->result()[0];

?>



<form id="update_form" enctype="multipart/form-data" class="col s12 py-4 nest_form">

  <!-- //lat long inputs -->



  <!-- radio button -->

  <div class="row">

    <div class="input-field col s12">

      <div class="adjouter">

        <div class="file-field input-field">

          <div class="btn">

            <span>

              <?= lang('photos'); ?>

            </span>

            <input id="choose_file" name="images[]" type="file" accept=".jpg,.jpeg,.png,.mp4" multiple>

          </div>

          <div class="file-path-wrapper">

            <input class="file-path      " type="text" placeholder=" télécharger une ou plusieurs images / vidéos">

          </div>

        </div>

        <p>

          <?= lang('photos_sub_title'); ?>

        </p>

      </div>

      <div class="imgGallery">

        <?php

        foreach ($data[1]->result() as $im) {

          $chk = explode(".", $im->file);

          echo "<div style='display:inline;'>";

          if ($chk[1] == "jpeg" || $chk[1] == "JPEG" || $chk[1] == "png" || $chk[1] == "PNG" || $chk[1] == "JPG" || $chk[1] == "jpg") {

            echo '<img id="image" src="' . base_url() . 'uploads/images/' . $im->file . '" /><label id="del_icon" data-id="' . $im->id . '" >X</label>';
          } elseif ($chk[1] == "mp4") {

            echo '<video id="image" width="300" controls><source src="' . base_url() . 'uploads/images/' . $im->file . '" /></video><label id="del_icon" data-id="' . $im->id . '" >X</label>';
          }

          echo "</div>";
        }

        ?>

      </div>

    </div>

  </div>
  <br>


  <div class="row">



    <div class="input-field col-md-6 col-sm-12">

      <p>



        <label>



          <input name="hide_location" <?php echo checked($result->hide_location, 'on') ?> id="hide_location" type="checkbox" class="filled-in">



          <span style="font-size:17px;">



            <?php echo lang('hide_location'); ?>



          </span>



        </label>



      </p>
      <p class="under_title">
        <?php echo lang('hide_location_label'); ?>
      </p>



    </div>



  </div>

  <!-- Adresse -->

  <div class="row">

    <div class="input-field col-md-6">

      <h5 style="margin-left:6px;" class="title">

        <?= lang('address') ?>*

      </h5>

      <input id="address" onkeypress="searchAutocomplete()" style='margin-left:8px;' type="text" name="address" value="<?php echo $result->address; ?>" />
      <input value="<?php echo $result->address; ?>" id="dumy_address" type="hidden" />



      <span id="lat_val"><?php echo $result->lat; ?></span>
      <span id="lon_val"><?php echo $result->lon; ?></span>


      <span class="hidden" id="lat_dummy"><?php echo $result->lat; ?></span>
      <span class="hidden" id="lon_dummy"><?php echo $result->lon; ?></span>
      <div id="address_error"></div>

    </div>

  </div>

  <div class="row">
    <div class="input-field col-md-6 col-sm-12">
      <h5 class="title">
        Latitude
      </h5>
      <input type="number" value="<?php echo $result->lat; ?>" name="lat" id="lat" />
    </div>
  </div>
  <div class="row">
    <div class="input-field col-md-6 col-sm-12">
      <h5 class="title">
        Longitude
      </h5>
      <input type="number" value="<?php echo $result->lon; ?>" name="lon" id="lon" />
    </div>
  </div>




  <!-- date time picker start -->

  <div class="row">

    <div class="date_picker col s12 m6">

      <p class='title'>

        <?= lang('date'); ?>*

      </p>

      <p class-'under_title'>

        <?= lang('date_sub_title'); ?>

      </p>

      <input name="date" value="<?php echo $result->date; ?>" type="date">

    </div>

  </div>

  <div class="row">

    <div class="input-field col s12 ">

      <p class="title">

        <?= lang('colonie_title'); ?>*

      </p>

      <p class="radio_content under_title">

        <?= lang('colonie_sub_title'); ?>

      </p>

      <p>

        <label>

          <input name="place" type="radio" value="Cavité naturelle" <?php echo site_tree_fun($result->place, "Cavité naturelle"); ?> />

          <span class='f_extended'>

            <?= lang('colonie1'); ?>

          </span>

        </label>

      </p>

      <p>

        <label>

          <input name="place" value="Cavité artificielle" type="radio" <?php echo site_tree_fun($result->place, "Cavité artificielle"); ?> />

          <span class='f_extended'>

            <?= lang('colonie2'); ?>

          </span>

        </label>

      </p>

      <p>

        <label>

          <input name="place" class="with-gap" value="A l'air libre" type="radio" <?php echo site_tree_fun($result->place, "A l'air libre"); ?> />

          <span class='f_extended'>

            <?= lang('colonie3'); ?>

          </span>

        </label>

      </p>
      <div id="placeError"></div>

    </div>

  </div>

  <div class="row">

    <div class="input-field col-md-6">

      <p class='title'>

        <?= lang('height_reporting'); ?> *

      </p>

      <input type="number" name="colonie_hauteur" value="<?php echo $result->colonie_hauteur  ?>" />

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

      <h3>

        <?= lang('nidification'); ?>*

      </h3>

      <select name="nesting_type" id="browser">

        <option value="" disabled>

          <?= lang('choose'); ?>

        </option>

        <option value="Arbre" <?php echo get_nest_entrance($result->nesting_type, "Arbre");  ?>>

          <?= lang('nidification1'); ?>

        </option>

        <option value="Chemineé" <?php echo get_nest_entrance($result->nesting_type, "Chemineé");  ?>>

          <?= lang('nidification2'); ?>

        </option>

        <option value="Falaise" <?php echo get_nest_entrance($result->nesting_type, "Falaise");  ?>>

          <?= lang('nidification3'); ?>

        </option>

        <option value="Toiture" <?php echo get_nest_entrance($result->nesting_type, "Toiture");  ?>>

          <?= lang('nidification4'); ?>

        </option>

        <option value="Autre" <?php echo get_nest_entrance($result->nesting_type, "Autre");  ?>>

          <?= lang('nidification5'); ?>

        </option>

      </select>
      <p>



        <?= lang('nidification_sub_title'); ?>



      </p>
      <div id="type_de_support_error"></div>
    </div>

  </div>

  <?php

  $display = 'display:none';

  if ($result->nesting_type == 'Autre') {

    $display = 'display:block';
  }

  ?>

  <div class="row" id="extra_info" style="<?php echo $display; ?>">

    <div class="input-field col s12">

      <p class="title">

        <?php echo lang("specify_nidification") ?>

      </p>

      <input id="extra_info_val" name="e_nesting_type_info" value="<?php echo $result->e_nesting_type_info; ?>" />

    </div>

  </div>

  <!-- if arbre then showing accordion section but not is hiding -->

  <?php //if ($result->nesting_type == 'Arbre') {

  ?>

  <!-- 

<script>

$(document).ready(function() {

$("#collapse2").slideDown();

});

</script> -->

  <?php

  //  }

  ?>

  <!-- collapse_start -->

  <div style="border:1px solid #ddd" class="panel ">

    <div style="background-color: #F5F5F5;border:1px solid #ddd;" class="panel-heading">

      <h4 class="panel-title">

        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" style='text-decoration:none;'>

          <span style='font-size:20px;'>+

          </span>

          </span>&nbsp&nbsp COMPLEMENT ETUDE

        </a>

      </h4>

    </div>

    <div id="collapse2" class="panel-collapse collapse">

      <div class="panel-body">

        <!--************* waseem code start*************-->

        <!--************* waseem code end*************-->

        <div class=''>

          <div class="row">

            <?php

            $display_accordion_section = "hidden";

            if ($result->nesting_type == 'Arbre') {

              $display_accordion_section = '';
            }

            ?>

            <div id="accord" class="<?php echo $display_accordion_section; ?> accordion_section">

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

                  <!-- 9april -->

                  <h3>

                    <?= lang("height_reporting") ?>

                  </h3>

                  <input name="height" value="<?php echo $result->height; ?>" id="nodification" type="number" />

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

                  <h3>

                    <?= lang("tree_genes"); ?>

                  </h3>

                  <input name="tree_genes" value="<?php echo $result->tree_genes; ?>" id="notification" type="number" />

                  <h6>

                    <?= lang('tree_genes_sub_title'); ?>

                  </h6>

                </div>

              </div>

              <!-- p4 -->

              <div class="row">

                <div class="input-field col m6 s12">

                  <h3>

                    <?= lang('tree_alive') ?>

                  </h3>

                  <h5>

                    <p>

                      <?= lang('tree_alive_sub_title'); ?>

                    </p>

                  </h5>

                  <p>

                    <label>

                      <input name="tree_alive" value="Oui" type="radio" <?php echo site_tree_fun($result->tree_alive, "Oui"); ?> />

                      <span class='f_extended'>

                        <?= lang('yes') ?>

                      </span>

                    </label>

                  </p>

                  <p>

                    <label>

                      <input class="with-gap" name="tree_alive" value="Non" type="radio" <?php echo site_tree_fun($result->tree_alive, "Non"); ?> />

                      <span class='f_extended'>

                        <?= lang('no'); ?>

                      </span>

                    </label>

                  </p>

                  <p>

                    <label>

                      <input name="tree_alive" type="radio" value="ne sais pas" <?php echo site_tree_fun($result->tree_alive, "ne sais pas"); ?> />

                      <span class='f_extended'>

                        <?= lang('dont_know'); ?>

                      </span>

                    </label>

                  </p>

                </div>

              </div>

            </div>

            <!--xyz-->

            <div class="row">

              <div class="input-field col-md-6">

                <p class="title">

                  <?= lang('dimension'); ?>

                </p>

                <input name="colonie_dimension" type="number" value="<?php echo $result->colonie_dimension; ?>" />

                <p>

                  <?= lang('dimension_sub_title'); ?>

                </p>

              </div>

            </div>

            <div class="row">

              <div class="input-field col s6 m6">

                <p class='title'>

                  <?= lang('orientation'); ?>

                </p>

                <p>

                  <?= lang('orientatio_sub_title'); ?>

                </p>

                <select id="orientation_select" name="orientation">

                  <option disabled value="">

                    <?= lang('choose') ?>

                  </option>

                  <?php

                  $or = array(

                    "Nord", "Nord Est", "Est", "Sud Est", "Sud", "Sud Ouest", "Ouest", "Nord Ouest"

                  );

                  foreach ($or as $key => $orientVal) {

                  ?>

                    <option <?php echo get_nest_entrance($result->orientation, $orientVal); ?> value="

                <?= $orientVal ?>">

                      <?= lang($orientVal) ?>

                    </option>

                  <?php } ?>

                </select>

              </div>

            </div>

            <div class="row">

              <div class="input-field col-md-6">

                <p class='title'>

                  <?= lang('form'); ?>

                </p>

                <input name="shape" value="<?php echo $result->shape; ?>" />

                <p>

                  <?= lang('form_sub_title'); ?>

                </p>

              </div>

            </div>

            <div class="row">

              <div class="input-field col-md-6">

                <p class='title'>

                  <?= lang('entrance'); ?>

                </p>

                <input name="area" value="<?php echo $result->area; ?>" type="number" />

                <p>

                  <?= lang('entrance_sub_title'); ?>

                </p>

                <p>

                  <?= lang('complement'); ?>

                </p>

              </div>

            </div>

            <!---->

          </div>

        </div>

      </div>

    </div>

  </div>

  <?php

  $pollen_display = 'display:none';

  if ($result->pollen != 'Oui') {

    $pollen_display = 'display:block';
  }

  ?>

  <div class="row">

    <div class="input-field col s12 m6">

      <p class='title'>

        <?= lang('Pollen'); ?>*

      </p>

      <p class='under_title'>

        <?= lang('pollen_sub_title') ?>

      </p>

      <select name="pollen" onChange="checkPollen(this.value)">

        <option <?php echo  get_nest_entrance($result->pollen, "Oui"); ?> value="Oui">

          <?= lang('yes') ?>

        </option>

        <option <?php echo get_nest_entrance($result->pollen, "Non"); ?> value="Non">

          <?= lang('no') ?>

        </option>

        <option <?php echo get_nest_entrance($result->pollen, "Ne sais pas"); ?> value="Ne sais pas">

          <?= lang('dont_know'); ?>

        </option>

      </select>
      <div id="pollen_error"></div>

    </div>

  </div>

  <!-- pollen qustins start-->

  <section id="notPollen" style="<?php echo $pollen_display; ?>">

    <div class="input-field col m12 s12">

      <h3>

        <p>

          <?= lang('flights'); ?>

        </p>

      </h3>

      <p>

        <label>

          <input class="first_check" name="flights" value="Oui" type="radio" <?php echo site_tree_fun($result->flights, "Oui"); ?> />

          <span class='f_extended'>

            <?= lang('yes'); ?>

          </span>

        </label>

      </p>

      <p>

        <label>

          <input name="flights" value="Non" type="radio" <?php echo site_tree_fun($result->flights, "Non"); ?> />

          <span class='f_extended'>

            <?= lang('no'); ?>

          </span>

        </label>

      </p>

      <!-- dont_know -->

      <p>

        <label>

          <input name="flights" value="Ne sais pas" type="radio" <?php echo site_tree_fun($result->flights, "Ne sais pas"); ?> />

          <span class='f_extended'>

            <?= lang('dont_know'); ?>

          </span>

        </label>

      </p>

    </div>

    <div class="input-field col m12 s12">

      <h3>

        <p>

          <?= lang('fight'); ?>

        </p>

      </h3>

      <p>

        <label>

          <input class="first_check" name="fight_with_workers" value="Oui" type="radio" <?php echo site_tree_fun($result->fight_with_workers, "Oui"); ?> />

          <span class='f_extended'>

            <?= lang('yes'); ?>

          </span>

        </label>

      </p>

      <p>

        <label>

          <input name="fight_with_workers" value="Non" type="radio" <?php echo site_tree_fun($result->fight_with_workers, "Non"); ?> />

          <span class='f_extended'>

            <?= lang('no'); ?>

          </span>

        </label>

      </p>

      <!-- dont_know -->

      <p>

        <label>

          <input name="fight_with_workers" value="Ne sais pas" type="radio" <?php echo site_tree_fun($result->fight_with_workers, "Ne sais pas"); ?> />

          <span class='f_extended'>

            <?= lang('dont_know'); ?>

          </span>

        </label>

      </p>

    </div>

    <div class="input-field col m12 s12">

      <h3>

        <p>

          <?= lang('waste_wax'); ?>

        </p>

      </h3>

      <p>

        <label>

          <input class="first_check" name="waste_wax" value="Oui" type="radio" <?php echo site_tree_fun($result->waste_wax, "Oui"); ?> />

          <span class='f_extended'>

            <?= lang('yes'); ?>

          </span>

        </label>

      </p>

      <p>

        <label>

          <input name="waste_wax" value="Non" type="radio" <?php echo site_tree_fun($result->waste_wax, "Non"); ?> />

          <span class='f_extended'>

            <?= lang('no'); ?>

          </span>

        </label>

      </p>

      <!-- dont_know -->

      <p>

        <label>

          <input name="waste_wax" value="Ne sais pas" type="radio" <?php echo site_tree_fun($result->waste_wax, "Ne sais pas"); ?> />

          <span class='f_extended'>

            <?= lang('dont_know'); ?>

          </span>

        </label>

      </p>

    </div>

    <div class="input-field col m12 s12">

      <h3>

        <p>

          <?php echo lang('entries_exist'); ?>

        </p>

      </h3>

      <p>

        <label>

          <input class="first_check" name="entries_exits" value="Oui" type="radio" <?php echo site_tree_fun($result->entries_exits, "Oui"); ?> />

          <span class='f_extended'>Oui

          </span>

        </label>

      </p>

      <p>

        <label>

          <input name="entries_exits" value="Non" type="radio" <?php echo site_tree_fun($result->entries_exits, "Non"); ?> />

          <span class='f_extended'>Non

          </span>

        </label>

      </p>

      <!-- dont_know -->

      <p>

        <label>

          <input name="entries_exits" value="Ne sais pas" type="radio" <?php echo site_tree_fun($result->entries_exits, "Ne sais pas"); ?> />

          <span class='f_extended'>

            <?= lang('dont_know'); ?>

          </span>

        </label>

      </p>

    </div>

  </section>

  <div class="row">

    <div class="input-field col s12 m6">

      <!-- <p>Indiquer la surface approximative de l'entrée du site de nidification.

Cf. Fiche explicative de méthode de mesure de la surface de l'entrée</p> -->

      <p class='title'>

        <?= lang('activity'); ?>

      </p>

      <p class='under_title'>

        <?= lang('activity_sub_title'); ?>

      </p>

      <select name="activity">

        <option selected value="" disabled>

          <?= lang('choose'); ?>

        </option>

        <option value="Forte, plus de 25 abeilles" <?php echo selected($result->activity, 'Forte, plus de 25 abeilles'); ?>>

          <?= lang('activity1'); ?>

        </option>

        <option value="Modérée, 10 à 25 abeilles" <?php echo selected($result->activity, 'Modérée, 10 à 25 abeilles'); ?>>

          <?= lang('activity2'); ?>

        </option>

        <option value="Faible, 1 à 9 abeilles" <?php echo selected($result->activity, 'Faible, 1 à 9 abeilles'); ?>>

          <?= lang('activity3') ?>

        </option>

        <option value="Nulle, 0 abeilles" <?php echo selected($result->activity, 'Nulle, 0 abeilles'); ?>>

          <?= lang('activity5') ?>

        </option>

        <option value="ne sais pas" <?php echo selected($result->activity, 'ne sais pas'); ?>>

          <?= lang('activity4') ?>

        </option>

      </select>
      <div id="activity_error"></div>

    </div>

  </div>

  <div class="row">

    <div class="input-field col s12 m6">

      <p class='title'>

        <?= lang('temperature'); ?>*

      </p>

      <input name="temperature" value="<?php echo $result->temperature; ?>" placeholder="" id="" type="number" />

      <p>

        <?= lang('temperature_sub_title'); ?>

      </p>
      <div id="temperature_error"></div>

    </div>

  </div>

  <?php

  $weather_situation_array = explode(",", $result->weather_situation);

  function weather_situation($static_val, $weather_situation_array)

  {

    if (in_array($static_val, $weather_situation_array)) {

      return 'checked="checked"';
    }
  }

  ?>

  <!-- check box -->

  <div class="row">

    <div class="input-field col m6 s12 mycheckbox">

      <p class='title'>

        <?= lang('conditions'); ?>*

      </p>

      <p class='under_title'>

        <?= lang('conditions_sub_title'); ?>

      </p>

      <p>

        <label>

          <input name="weather_situation[]" value="Soleil" type="checkbox" class="filled-in" <?php echo weather_situation("Soleil", $weather_situation_array); ?> />

          <span>

            <?= lang('conditions1'); ?>

          </span>

        </label>

      </p>

      <p>

        <label>

          <input name="weather_situation[]" value="Eclaircies" type="checkbox" class="filled-in" <?php echo weather_situation("Eclaircies", $weather_situation_array); ?> />

          <span>

            <?= lang('conditions2'); ?>

          </span>

        </label>

      </p>

      <p>

        <label>

          <input name="weather_situation[]" value="Nuages" type="checkbox" class="filled-in" <?php echo weather_situation("Nuages", $weather_situation_array); ?> />

          <span>

            <?= lang('conditions3'); ?>

          </span>

        </label>

      </p>

      <p>

        <label>

          <input name="weather_situation[]" value="Vent" type="checkbox" class="filled-in" <?php echo weather_situation("Vent", $weather_situation_array); ?> />

          <span>

            <?= lang('conditions5'); ?>

          </span>

        </label>

      </p>

      <p>

        <label>

          <input name="weather_situation[]" value="Pluie" type="checkbox" class="filled-in" <?php echo weather_situation("Filled in", $weather_situation_array); ?> />

          <span>

            <?= lang('conditions4'); ?>

          </span>

        </label>

      </p>
      <div id="errrorWeather"></div>

    </div>

  </div>

  <!-- ////// -->

  <!-- information details -->

  <!-- information details end -->

  <div class="row">

    <div class="col-md-6">

      <p class='title'>

        <?= lang('information'); ?>*

      </p>
      <textarea class="form-control" name="detailed_information" rows="5" id="comment">
      <?php echo $result->detailed_information; ?>
      </textarea>



      </textarea>
      <div id="detailed_information_error"></div>

    </div>

  </div>

  <!-- extra content1 -->

  <!-- date picker end -->

  <!--pending-->

  <div style="padding: 0 0 20px 0;" class="row">

    <div class="input-field col s12">

      <input type="hidden" value="<?php echo $result->id; ?>" name=" pro_user" />

      <input type="submit" name="pro_user" class="pinbuttons1" value="<?php echo lang('submit_reporting'); ?>" />

    </div>

  </div>

</form>

</div>

</script>

<script>
  $(document).ready(function() {

    $(".accordion_section").slideDown();

    $(".site_is_tree").click(function() {

      $(".accordion_section").show();

    });

    $(".site_is_not_tree").click(function() {

      $(".accordion_section").hide();

    });

    //$(".f_extended").css("font-size","15px");

  });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>

<script>
  $(document).ready(function() {

    //waseemafzal





    $("#update_form").validate({



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

        }







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



















      },







      errorElement: 'span'



    })











  });
</script>


<script>
  $("#update_form").on("submit", function(e) {



    e.preventDefault();



    if (!$("#update_form").valid()) {

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

      var other_data = $('#update_form').serializeArray();

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

        url: "<?php echo  base_url() . 'map/complete_edit_form'; ?>",

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
</script>

<?php
