<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>



<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css" integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lato-font/3.0.0/css/lato-font.min.css" integrity="sha512-rSWTr6dChYCbhpHaT1hg2tf4re2jUxBWTuZbujxKg96+T87KQJriMzBzW5aqcb8jmzBhhNSx4XYGA6/Y+ok1vQ==" crossorigin="anonymous" />







<style>
  .carousel-inner>.item>a>img,
  .carousel-inner>.item>img,
  .img-responsive,
  .thumbnail a>img,
  .thumbnail>img {



    width: 100%;

  }



  a.btn_behave {











    background-color: #C2AE13;







  }







  /* main container */



  div.form_container {



    width: 100%;



  }







  div.form_container>div.main_form {



    width: 60%;



    margin: 0 auto;



    padding: 2% 0 0 0;



  }







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



  @media (max-width: 768px) {



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



  .del {

    overflow: hidden;

    position: relative;

    padding: 1px 6px;

    border-radius: 40px;

    position: absolute;

    top: -10px;

    right: 0;

    color: #fff;

    background-color: #d9534f;

    border-color: #d43f3a;

  }
</style>



<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" />





<?php



include_once 'header.php';



?>









<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>







<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

















<script>
  function checkPollen(nest) {



    if (nest != "Oui") {



      // show all questions



      $("#notPollen").show();







    } else {
      // loosing data if pollen is not oui
      $("input[name='flights']").each(function() {



        $(this).prop('checked', false);



      });



      $("input[name='fight_with_workers']").each(function() {



        $(this).prop('checked', false);



      });



      $("input[name='waste_wax']").each(function() {



        $(this).prop('checked', false);



      });



      $("input[name='entries_exits']").each(function() {



        $(this).prop('checked', false);



      });




      $("#notPollen").hide();











    }



  }
</script>











<!--  -->



<div class="form_container">







  <div class="main_form">



    <div class="texte col s12 m6 texte">





      <h1 class="h1" style="font-size:44px;font-weight:bold; color:black;"><?= lang('suivi'); ?> </h1> <br>







      <p><?= lang('suivi_title'); ?> </p>























    </div>



    <div class="row" style="margin-top:50px;">



      <form method="POST" enctype="multipart/form-data" class="col s12 " style="margin-left:10px;" id="follow_form">



        <!-- pending -->



        <!---->



        <div class="row">



          <div class="input-field col s12 m6">







            <p class="title"><?= lang('activity'); ?></p>



            <p class="under_title"><?= lang('suivi_sub_title'); ?></p>



            <?php

            $activity = '';

            $pollen = '';

            $temperature = '';

            $weather_situation = '';

            $a_information = '';

            $display = 'display:none';

            if (isset($row)) {

              // pre($row);

              $activity = $row->activity;

              $pollen = $row->pollen;

              $temperature = $row->temperature;

              $a_information = $row->a_information;

              $weather_situation = $row->weather_situation;

              $etat_de_la_colonie = $row->etat_de_la_colonie;

              $date = $row->date;
            }

            ?>






            <select required name="activity">

              <option value="" selected disabled><?php echo lang('choose'); ?></option>

              <option <?= checkSelct($activity, 'Forte, plus de 25 abeilles') ?> value="Forte, plus de 25 abeilles">

                <?= lang('activity1') ?>

              </option>



              <option <?= checkSelct($activity, 'Modérée, 10 à 25 abeilles') ?> value="Modérée, 10 à 25 abeilles"><?= lang('activity2'); ?></option>



              <option <?= checkSelct($activity, 'Faible, 1 à 9 abeilles') ?> value="Faible, 1 à 9 abeilles"><?= lang('activity3'); ?></option>



              <option <?= checkSelct($activity, 'Nulle, 0 abeilles') ?> value="Nulle, 0 abeilles"><?= lang('activity5'); ?></option>



              <option <?= checkSelct($activity, 'Ne sais pas') ?> value="Ne sais pas"><?= lang('activity4'); ?></option>



            </select>



          </div>



        </div>

        <!--etat de la colonie-->

        <div class="row">



          <div class="input-field col s12 m6">



            <p class="title"><?= lang('colonie_search'); ?></p>







            <select name="etat_de_la_colonie" class="">

              <option <?php echo get_nest_entrance($etat_de_la_colonie, "Indéterminée"); ?> value="Indéterminée"><?= lang('colonie_search3') ?></option>

              <option <?php echo get_nest_entrance($etat_de_la_colonie, "Fondatrice"); ?> value="Fondatrice"><?= lang('colonie_search1'); ?></option>



              <option <?php echo get_nest_entrance($etat_de_la_colonie, "Etablie"); ?> value="Etablie"><?= lang('colonie_search2'); ?></option>







              <!--<option class="" value="Tout état">Tout état</option>-->



            </select>



          </div>



        </div>

        <!---->



        <div class="row">



          <div class="input-field col s12 m6">



            <p class="title"><?= lang('pollen'); ?></p>



            <p class="under_title"><?= lang('pollen_sub_title'); ?></p>







            <select onChange="checkPollen(this.value)" required name="pollen">

              <option value="" disabled selected> <?= lang("choose"); ?> </option>

              <option <?= checkSelct($pollen, 'Oui') ?> value="Oui">



                <?= lang('pollen1'); ?>



              </option>



              <option <?= checkSelct($pollen, 'Non') ?> value="Non">

                <?= lang('pollen2'); ?>

              </option>







              <option <?= checkSelct($pollen, 'Ne sais pas') ?> value="Ne sais pas"><?= lang('dont_know'); ?></option>



            </select>



          </div>



        </div>



        <?php if ($row->pollen != 'Oui' && !empty($row->pollen)) {



          $display = 'display:block';
        }

        ?>

        <section id="notPollen" style="<?php echo $display; ?>">



          <div class="input-field col m12 s12">



            <h3>

              <p><?= lang('flights'); ?> </p>

            </h3>



            <p>



              <label>



                <input name="flights" <?php echo checked($row->flights, 'Oui'); ?> value="Oui" type="radio" />



                <span class="f_extended"><?= lang('flights1'); ?></span>



              </label>



            </p>



            <p>



              <label>



                <input name="flights" <?php echo checked($row->flights, 'Non'); ?> value="Non" type="radio" />



                <span class="f_extended"><?= lang('no'); ?></span>



              </label>



            </p>
            <!-- dont_know -->
            <p>



              <label>



                <input name="flights" <?php echo checked($row->flights, 'Ne sais pas'); ?> value="Ne sais pas" type="radio" />



                <span class="f_extended"><?= lang('dont_know'); ?></span>



              </label>



            </p>




          </div>



          <div class="input-field col m12 s12">



            <h3>

              <p> <?= lang('fight'); ?> </p>

            </h3>



            <p>



              <label>



                <input name="fight_with_workers" <?php echo checked($row->fight_with_workers, 'Oui'); ?> value="Oui" type="radio" />



                <span class="f_extended"><?= lang('yes'); ?></span>



              </label>



            </p>



            <p>



              <label>



                <input name="fight_with_workers" value="Non" <?php echo checked($row->fight_with_workers, 'Non'); ?> type="radio" />



                <span class="f_extended"><?= lang('no'); ?></span>



              </label>



            </p>
            <!-- dont_know -->
            <p>



              <label>



                <input name="fight_with_workers" value="Ne sais pas" <?php echo checked($row->fight_with_workers, 'Ne sais pas'); ?> type="radio" />



                <span class="f_extended"><?= lang('dont_know'); ?></span>



              </label>



            </p>



          </div>







          <div class="input-field col m12 s12">



            <h3>

              <p> <?= lang('wax_nest_modal')  ?> * </p>

            </h3>



            <p>



              <label>



                <input name="waste_wax" <?php echo checked($row->waste_wax, 'Oui'); ?> value="Oui" type="radio" />



                <span class="f_extended"><?= lang('yes')  ?></span>



              </label>



            </p>



            <p>



              <label>



                <input name="waste_wax" <?php echo checked($row->waste_wax, 'Non'); ?> value="Non" type="radio" />



                <span class="f_extended"><?= lang('no')  ?></span>



              </label>



            </p>
            <!-- dont_know -->
            <p>



              <label>



                <input name="waste_wax" <?php echo checked($row->waste_wax, 'Ne sais pas'); ?> value="Ne sais pas" type="radio" />



                <span class="f_extended"><?= lang('dont_know')  ?></span>



              </label>



            </p>



          </div>



          <div class="input-field col m12 s12">



            <h3>

              <p> <?= lang('entries_nest_modal'); ?> * </p>

            </h3>



            <p>



              <label>



                <input name="entries_exits" <?php echo checked($row->waste_wax, 'Oui'); ?> value="Oui" type="radio" />



                <span class="f_extended"><?= lang('yes'); ?></span>



              </label>



            </p>



            <p>



              <label>



                <input name="entries_exits" <?php echo checked($row->waste_wax, 'Non'); ?> value="Non" type="radio" />



                <span class="f_extended"><?= lang('no'); ?></span>



              </label>



            </p>
            <!-- dont_know -->
            <p>



              <label>



                <input name="entries_exits" <?php echo checked($row->waste_wax, 'Ne sais pas'); ?> value="Ne sais pas" type="radio" />



                <span class="f_extended"><?= lang('dont_know'); ?></span>



              </label>



            </p>



          </div>



        </section>















        <div class="row">



          <div class="input-field col s12 m6">



            <p class="title"><?= lang('temperature'); ?></p>







            <input required name="temperature" value="<?= $temperature ?>" type="number" class="validate" />



            <p><?= lang('temperature_sub_title'); ?></p>



          </div>



        </div>



        <!-- check box -->











        <div class="row">



          <div class="input-field col m6 s12">



            <p class="title"><?= lang('conditions'); ?></p>



            <p class="under_title"><?= lang('conditions_sub_title'); ?></p>











            <p>



              <label>



                <input name="weather_situation[]" <?= checkedWeather($weather_situation, 'Soleil') ?> value="Soleil" type="checkbox" class="filled-in " />



                <span class="f_extended"><?= lang('conditions1'); ?></span>



              </label>



            </p>



            <p>



              <label>



                <input name="weather_situation[]" <?= checkedWeather($weather_situation, 'Eclaircies') ?> value="Eclaircies" type="checkbox" class="filled-in" />



                <span class="f_extended"><?= lang('conditions2'); ?></span>



              </label>



            </p>



            <p>



              <label>



                <input name="weather_situation[]" <?= checkedWeather($weather_situation, 'Nuages') ?> value="Nuages" type="checkbox" class="filled-in" />



                <span class="f_extended"><?= lang('conditions3'); ?></span>



              </label>



            </p>



            <p>



              <label>



                <input name="weather_situation[]" <?= checkedWeather($weather_situation, 'Vent') ?> value="Vent" type="checkbox" class="filled-in" />



                <span class="f_extended"><?= lang('conditions5'); ?></span>



              </label>



            </p>



            <p>



              <label>



                <input name="weather_situation[]" <?= checkedWeather($weather_situation, 'Pluie') ?> value="Pluie" type="checkbox" class="filled-in" />



                <span class="f_extended"><?= lang('conditions4'); ?></span>



              </label>



            </p>







          </div>



        </div>















        <!---->











        <input type="hidden" name="nest_id" value="<?php echo $nest_id; ?>" />









































        <div class="row">



          <div class=" col s6">



            <p class="title"><?= lang('swarm_disappear'); ?></p>



            <select name="disappeared" id="disappeared" onChange="checkme(this.value)">





              <option value="" disabled selected><?= lang('choose'); ?></option>

              <option <?php echo selected($row->disappeared, 'Non') ?> value="Non"><?= lang('no'); ?></option>



              <option <?php echo selected($row->disappeared, 'Oui') ?> value="Oui"><?= lang('yes'); ?></option>



            </select>



          </div>



        </div>

        <?php if ($row->disappeared == 'Oui') {

          $display = 'display:block';
        } ?>





        <div class="row" id="pickedup_div" style="<?php echo $display ?>">



          <div class=" col s6">



            <p class="title"><?= lang('bee_keeper') ?></p>



            <select name="pickedup" id="pickedup">







              <option value="Non" <?php echo selected($row->pickedup, 'Non') ?>><?= lang('no') ?></option>



              <option value="Oui" <?php echo selected($row->pickedup, 'Oui') ?>><?= lang('yes') ?></option>



              <option value="Ne sais pas" <?php echo selected($row->pickedup, 'Ne sais pas') ?>><?= lang('dont_know'); ?></option>



            </select>



          </div>



        </div>



        <div class="row">



          <div class=" col s6">



            <p class="title"><?= lang('cavity_suive'); ?></p>



            <select required name="cavity_occupied" id="cavity_occupied" onChange="checkAlso(this.value)">

              <option value="" disabled selected><?= lang('choose'); ?></option>

              <option value="Oui" <?php echo selected($row->cavity_occupied, 'Oui') ?>><?= lang('yes'); ?></option>



              <option value="Non" <?php echo selected($row->cavity_occupied, 'Non') ?>><?= lang('no'); ?></option>







              <option value="Ne sais pas" <?php echo selected($row->cavity_occupied, 'Ne sais pas') ?>><?= lang('dont_know'); ?></option>



            </select>



          </div>



        </div>



        <?php

        if ($row->cavity_occupied == 'Oui') {

          $display = 'display:block';
        }

        ?>







        <div class="row" id="cavity_occupied_div" style="<?php echo $display; ?>">



          <div class=" col s6">



            <p class="title"><?= lang('specify_suive'); ?></p>



            <input type="text" value="<?php echo $row->pouvezvous; ?>" class="form-control" name="pouvezvous">



          </div>



        </div>























        <div class="row">



          <div class=" col s12">



            <p class="title"><?= lang('info_suive'); ?></p>







            <textarea name="a_information" style="height:70px" rows="5"><?= $a_information ?></textarea>



            <p> <?= lang('addtional_info'); ?> </p>







          </div>



        </div>



        <div class="row">



          <div class="date_picker col s6 m6">



            <h5 class="title"> <?= lang('next_date'); ?> </h5>



            <p class="under_title"> <?= lang('next_observation'); ?></p>

            <?php

            if (!isset($date)) {

              $date = date("Y-m-d");
            }

            ?>

            <input name="date" type="date" value="<?php echo $date;  ?>" id="">



            <br><br>



          </div>



        </div>







        <div class="">







          <div class="adjouter">



            <div class="file-field input-field">



              <div class="btn">



                <span><?= lang('photos'); ?></span>



                <input id="file" name="file[]" type="file" accept=".jpg,.jpeg,.png,.mp4" multiple>



              </div>



              <div class="file-path-wrapper">



                <input class="file-path validate" type="text" placeholder="<?= lang('photos_sub_title_suivi'); ?>">



              </div>



            </div>



            <p><?= lang('swarm_photos'); ?></p>

            <?php

            if (isset($row)) {

              $post_id = $row->id;

              $where = array('follow_id' => $post_id);

              $ImgData = get_by_where_array($where, 'tbl_follow_images');



              foreach ($ImgData->result() as $Imgrow) {

                $src = base_url() . 'uploads/' . $Imgrow->file; { ?>

                  <div class="col-xs-4 col-md-2  box-primary  img_wrap_<?php echo $Imgrow->id ?>" style="padding-left:0">

                    <img id="img_<?php echo $Imgrow->id ?>" src="<?php echo $src ?>" class="img-responsive"><br>

                    <center>



                      <a class="del" onclick="deleteImage('<?php echo $Imgrow->id ?>','tbl_follow_images')" href="javascript:void(0)" data-toggle="tooltip" data-original-title="Delete"><i class="fa fa-times"></i>

                      </a>

                    </center>



                  </div>

            <?php }
              }
            }

            ?>

          </div>



        </div>



        <div class="row">



          <div class="input-field col s12">











            <input type="submit" class="pinbuttons1" value="<?= lang('submit_search'); ?>" />





            <?php

            if (isset($follow_id)) {

            ?>

              <input type="hidden" value="<?= $follow_id ?>" name="follow_id" />



            <?php } ?>





          </div>















        </div>



    </div>



  </div>



























  </form>















</div>







</div>







</div>







<script>
  $("#follow_form").on('submit', function(e) {

    //alert('going to submit');

    e.preventDefault();

    var formData = new FormData();



    // make sure there is file(s) to upload

    var inputFile = $('input#file');



    var filesToUpload = inputFile[0].files;



    if (filesToUpload.length > 0) {

      // provide the form data

      // that would be sent to sever through ajax

      for (var i = 0; i < filesToUpload.length; i++) {

        var file = filesToUpload[i];

        formData.append("file[]", file, file.name);

      }

    }





    /**********************/

    var other_data = $('#follow_form').serializeArray();

    $.each(other_data, function(key, input) {

      formData.append(input.name, input.value);

    });





    $.ajax({



      url: "<?php echo base_url() . 'map/follow_form_insert' ?>",



      data: formData,

      cache: false,

      contentType: false,

      processData: false,

      dataType: 'JSON',



      method: "POST",

      beforeSend: function() {

        $('#loader').removeClass('hidden');

        //	$('#form_add_update .btn_au').addClass('hidden');

      },

      success: function(data) {

        $('#loader').addClass('hidden');





        if (data == true) {







          $("#follow_form").trigger("reset");



          window.scrollTo(0, 0);

          $(".alert").show();



          $(".alert").addClass(" alert-success");

          $(".alert").html('<?php echo lang('success'); ?>');



          setTimeout(function() {

            $(".alert").hide("slow");

            window.location = "<?php echo base_url() . 'map/followHistory/' . $nest_id ?>";



          }, 3000);







        } else {

          $(".alert").show();

          $(".alert").addClass("alert-danger");


          $(".alert").html('<?php echo lang('success'); ?>');
          // $(".alert").html("données non insérées avec succès");



          setTimeout(function() {

            $(".alert").hide("slow")

          }, 3000);



        }







      }



    });



  });
</script>



<script type="text/javascript">
  function deleteImage(id, table) {



    if (!confirm("Confirmer la suppression ?")) {



      //User Pressed okay. Delete



      return false;



    }



    $.ajax({

      url: "<?php echo base_url() . 'crud/deleteImage'; ?>",

      type: 'POST',

      data: {

        id: id,

        table: table

      },

      dataType: "json",

      success: function(response) {

        if (response.status == 1) {

          $(".img_wrap_" + id).hide('slow');

        } else if (response.status == 0) {

          alert('Error :You could not delete');

        } else {

          alert(response);

        }

      }

    });





  }



  function checkme(v) {
    $('#pickedup option:selected').removeAttr('selected');
    $('#pickedup').prop('selectedIndex', 0);



    if (v == "Oui") {



      $("#pickedup_div").show();



    } else {



      $("#pickedup_div").hide();



    }



  }



  function checkAlso(v) {
    $("input[name='pouvezvous']").val('');


    if (v == "Oui") {



      $("#cavity_occupied_div").show();



    } else {



      $("#cavity_occupied_div").hide();



    }



  }
</script>



</body>



</html>