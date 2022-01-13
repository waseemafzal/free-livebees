<?php

include_once 'header.php';

$user_agent = getenv("HTTP_USER_AGENT");

$os         = '';

$styleMac   = 'style="margin:0"';

if (strpos($user_agent, "Win") !== false) {

  $os = "Windows";
} elseif (strpos($user_agent, "Mac") !== false) {

  $os       = "Mac";

  $styleMac = 'style="padding:0"';
}

$WHERE       = '';

$statefilter = '';

$wherelike   = '';

$user_ip     = '';
$radisfilter = 100;
if (isset($_GET['radisfilter'])) {
  $radisfilter = $_GET['radisfilter'];
}


$searchname  = '';

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {

  $user_ip = $_SERVER['HTTP_CLIENT_IP'];
} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

  $user_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {

  $user_ip = $_SERVER['REMOTE_ADDR'];
}

if (isset($_GET['sbmitbtn'])) {

  $lon = '';

  $lat = '';

  if (isset($_GET['nesting_type']) && count($_GET['nesting_type']) > 0) {

    $nesting_type1 = ' AND (1=0 ';

    foreach ($_GET['nesting_type'] as $n_type) {

      $nesting_type1 .= ' OR nesting_type=' . "'" . $n_type . "'";
    }

    $nesting_type1 .= ')';

    $WHERE .= $nesting_type1;
  }

  if (isset($_GET['etat_de_la_colonie']) && count($_GET['etat_de_la_colonie']) > 0) {

    $etat_colonie = ' AND (1=0 ';

    foreach ($_GET['etat_de_la_colonie'] as $etat) {

      $etat_colonie .= ' OR etat_de_la_colonie=' . "'" . $etat . "'";
    }

    $etat_colonie .= ')';

    $WHERE .= $etat_colonie;
  }

  if (isset($_GET['status-filter']) and count($_GET['status-filter']) > 0) {

    $statusfilterstr = implode(',', $_GET['status-filter']);

    $statusfilter    = ' AND status  IN   (' . $statusfilterstr . ')';

    $WHERE .= $statusfilter;
  }

  if (isset($_GET['user_id']) and !empty($_GET['user_id'])) {

    $WHERE .= 'AND tbl_loc.user_id=' . $_GET['user_id'];
  }

  if (isset($_GET['code_du_site']) and !empty($_GET['code_du_site'])) {

    $WHERE .= ' AND uniqid=' . '"' . $_GET['code_du_site'] . '"';
  }

  if (isset($_GET['findPro']) and !empty($_GET['findPro'])) {

    $WHERE .= ' AND findPro=' . '"' . $_GET['findPro'] . '"';
  }

  if (isset($_GET['type-filter']) and count($_GET['type-filter']) > 0) {

    $typefilterstr = implode(',', $_GET['type-filter']);

    $typefilter    = ' AND nest_type  IN   (' . $typefilterstr . ')';

    $WHERE .= $typefilter;
  }



  if (isset($_GET['searchname']) and $_GET['searchname'] != '') {

    $mynest     = "AND name='" . $_GET['searchname'] . "' ";

    $searchname = $_GET['searchname'];

    $WHERE .= $mynest;
  }

  $dateClause = '';

  if (isset($_GET['start_date']) and !empty($_GET['start_date']) and isset($_GET['end_date']) and !empty($_GET['end_date'])) {

    $date_from  = date('Y-m-d', strtotime($_GET['start_date']));

    $date_to    = date('Y-m-d', strtotime($_GET['end_date']));

    $dateClause = ' AND (date BETWEEN "' . $date_from . '" AND  "' . $date_to . '")';
  }

  $dateWhere          = ' ' . $AND . ' ' . $dateClause . '';

  $stateresgionfilter = '';

  if (isset($_GET['stateregsion-filter']) and !empty($_GET['stateregsion-filter'])) {

    $stateresgionfilter = ' AND  state_region=' . '"' . $_GET['stateregsion-filter'] . '"';

    $WHERE .= $stateresgionfilter;
  }

  if (isset($_GET['address']) and (!empty($_GET['address']))) {

    $alocation = $this->crud->extract_coordinates($_GET['address']);

    $latitude  = $alocation['lat'];

    $longitude = $alocation['lng'];
  }

  if (!empty($latitude) and !empty($longitude)) {

    $lat = $latitude;

    $lon = $longitude;
  } else {

    $query = @unserialize(file_get_contents('http://ip-api.com/php/' . $user_ip));

    $lat   = $query['lat'];

    $lon   = $query['lon'];
  }

  if (isset($_GET['latitude']) and $_GET['latitude'] != '' and isset($_GET['longitude']) and $_GET['longitude'] != '') {

    $lon = $_GET['longitude'];

    $lat = $_GET['latitude'];
  }

  if ($lon == '' and $lat == '') {

    $alocation = $this->crud->extract_coordinates($_GET['filtertext']);

    $lat       = $alocation['lat'];

    $lon       = $alocation['lng'];
  } elseif (isset($_GET['filtertext']) and isset($_GET['radisfilter'])) {

    $alocation = $this->crud->extract_coordinates($_GET['filtertext']);

    $lat       = $alocation['lat'];

    $lon       = $alocation['lng'];
  }

  $radiusHaving = 'HAVING radius <= 100 ORDER BY radius ASC';

  if (isset($_GET['radisfilter']) and !empty($_GET['radisfilter'])) {

    $radisfilter  = $_GET['radisfilter'];

    $radiusHaving = ' HAVING radius <= ' . $_GET['radisfilter'] . ' ORDER BY radius ASC';
  }

  $radiusFiltr = ',(SELECT GROUP_CONCAT(tbl_map_images.file,"|",tbl_map_images.type) FROM tbl_map_images WHERE tbl_loc.id= tbl_map_images.map_id ) AS files,lat as latitude,lon as longitude,( 6371 * 

acos(cos( radians( "' . $latitude . '" ) ) * cos( radians( lat ) ) * 

cos( radians( lon ) - radians(' . $longitude . ' ) ) + 

sin( radians(' . $latitude . ' ) ) * 

sin( radians( lat ) ) ) ) 

AS `radius` FROM tbl_loc  

';

  if (isset($_GET['etat_de_la_colonie']) && count($_GET['etat_de_la_colonie']) > 0) {

    $sql = "SELECT tbl_loc.*,f.`a_information`, f.`nest_id`, f.`date`, f.`time`, f.`occupied_species`, f.`recovery_bee_keeper`, f.`disappeared`, f.`pickedup`, f.`cavity_occupied`, f.`which_one`, f.`weather_situation`, f.`temperature`, f.`pollen`, f.`activity`, f.`user_id`, f.`etat_de_la_colonie`,f.`pouvezvous`, f.`flights`, f.`entries_exits`, f.`waste_wax`, f.`fight_with_workers`  " . $radiusFiltr . " INNER JOIN  tbl_follow as f ON

tbl_loc.id=f.nest_id" . "  WHERE 1=1 " . $WHERE . " 

" . $dateWhere . "  

" . $radiusHaving . " ";
  } else {


    $sql = "SELECT *  " . $radiusFiltr . "  WHERE 1=1 " . $WHERE . " 

" . $dateWhere . "  

" . $radiusHaving . " ";
  }

  $result = $this->db->query($sql);
}

$astateregions = $this->db->query("SELECT DISTINCT state_region FROM " . $this->tbl_loc . " ");

?>

<style>
  .list-group-item {

    padding: 3px 3px;

    background-color: #e9e9e921
  }

  .info_content tr td {

    padding: 0 !important
  }

  .btnCustom {

    border: 1px solid !important;

    padding: 8px 21px 8px 20px;

    color: #000;

    width: 25%;

    border-radius: 7px !important
  }

  .btnCustom>i {

    color: #000
  }

  #formsbmittt .form-group {

    margin-bottom: 8px
  }

  .btnFollow:hover {

    color: #000 !important;

    background-color: rgba(252, 227, 3, .56)
  }

  .btnFollow {

    display: block;

    text-align: center;

    text-decoration: none;

    width: 100%;

    border: 1px solid;

    color: #000
  }

  .panel-heading,
  .panel-title {

    font-size: 12px;

    text-transform: uppercase;

    text-align: center
  }

  div.bg {

    background-color: red
  }
</style>

<div id="formatted_address">

</div>

<div id="nested_total">

  <?php

  foreach ($result->result() as $ids) {

    $idsArr[] = $ids->id;
  }

  $str = implode(',', $idsArr);

  ?>

  <span class="pull-left">

    <?php

    echo count($result->result());

    ?>

    <?= lang('nest') ?>

  </span>

  <form id="csvForm" action="<?= base_url() ?>map/exportCsv" method="post">

    <input type="hidden" value="<?= $str ?>" name='ids'>

  </form>

  <i class="glyphicon glyphicon-download">

  </i>

</div>

<script type="text/javascript">
  $("#nested_total").click(function() {

      $("#csvForm").submit();

    }

  );

  function triggerClick(i) {

    google.maps.event.trigger(markers[i], 'click');

    //map.getBounds();	

  }
</script>

<button id="searchBtn" type="button" class="btn btn-default sbitbtn btn-info">

  <i class="glyphicon glyphicon-search">

  </i>

  <?= lang('nest_btn'); ?>

</button>

<div class="col-md-4 col-xs-11" id="searcform">

  <a id="btnClose" href="javascript:void(0)">

    <i class="glyphicon glyphicon-remove">

    </i>

  </a>

  <div class="col-xs-12">

    <h3>

      <?= lang('search_criteria'); ?>

    </h3>

  </div>

  <form id="formsbmittt" action="map/index" method="GET">

    <span id='proceeee'>

    </span>

    <!-- adresse -->

    <div class="col-xs-12  col-md-12">

      <input type="hidden" name="latitude" id="mylatitude" placeholder="Latitude" value="<?php

                                                                                          echo $latitude;

                                                                                          ?>">

      <input type="hidden" name="longitude" id="mylongitude" placeholder="Longitude" value="<?php

                                                                                            echo $longitude;

                                                                                            ?>">

      <label for="email">

        <?= lang('address_search') ?>

      </label>

      <?php

      $localAddress = '';

      if (isset($address) and $address != '') {

        $localAddress = $address;
      }

      if (isset($_GET['filtertext'])) {

        $localAddress = $_GET['filtertext'];
      }

      ?>

      <input type="text" onkeypress="searchAutocomplete()" class="form-control" name="address" id="filtertext" value="<?= $localAddress; ?>" placeholder="Enter address to search" />

      <span class="glyphicon glyphicon-map-marker" style="

                                                          position: relative;

                                                          float: right;

                                                          margin: -32px 3px 0 0;

                                                          line-height: 25px;

                                                          font-size: 20px;

                                                          background-color: #fff;

                                                          display:none

                                                          ">

      </span>

    </div>

    <div class="col-xs-12 col-md-12">

      <label>

        <?= lang('within_radius'); ?>

      </label>

      <input name="radisfilter" class="form-control" value="100" type="number" />

    </div>

    <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6">

      <label>

        <?= lang('site_code'); ?>

      </label>

      <?php

      $codedusiste = '';

      if (isset($_GET['code_du_site'])) {

        $codedusiste = $_GET['code_du_site'];
      }
      // haris changing 16/04 remove this from below line  $codedusiste 

      ?>

      <input list="browsers12" name="code_du_site" class="form-control jquery-datepicker__input filter-date-class " value="" placeholder=" " id="ville" />

      <datalist id="browsers12">

        <?php

        $dl_items   = $this->db->select("uniqid")->get("tbl_loc")->result_array();

        $last_names = array_column($dl_items, 'uniqid');

        foreach ($last_names as $val) {

          echo "<option value='$val'>";
        }

        ?>

        <!--<input name="code_du_site"  class="form-control jquery-datepicker__input filter-date-class " value="" placeholder=" " id="ville" /> &nbsp;-->

    </div>

    <!-- Site suivi par -->

    <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6">

      <label>

        <?= lang('site_followed'); ?>

      </label>

      <input list="userlist" name="user_id" class="form-control" value="" placeholder=" " id="user_id" />

      <datalist id="userlist">

        <?php

        foreach ($usersDatalist->result() as $users) {

        ?>

          <option data-id="<?= $users->id ?>" value="<?= $users->name ?>">

          <?php

        }

          ?>

      </datalist>

    </div>

    <!-- type de site -->

    <div class="form-group col-xs-6 col-md-6">

      <label>

        <?= lang('site_type'); ?>

      </label>

      <div style="overflow-y: scroll;height:80px;" class="form-control">

        <input type="checkbox" name="nesting_type[]" value="Arbre" id="Arbre">

        <label for="Arbre">

          <?= lang('nidification1'); ?>

        </label>

        <br>

        <input type="checkbox" name="nesting_type[]" value="Chemineé" id="cavite">

        <label for="cavite">

          <?= lang('nidification2'); ?>

        </label>

        <br>

        <input type="checkbox" name="nesting_type[]" value="Falaise" id="falaise">

        <label for="falaise">

          <?= lang('nidification3'); ?>

        </label>

        <br>

        <input type="checkbox" name="nesting_type[]" value="Toiture" id="tout">

        <label for="tout">

          <?= lang('nidification4'); ?>

        </label>

        <br>

        <input type="checkbox" name="nesting_type[]" value="Autre" id="Autre">

        <label for="Autre">

          <?= lang('nidification5'); ?>

        </label>

        <br>

      </div>

    </div>

    <!-- <div class="form-group col-xs-6 col-md-6">

<label> Type de site </label>

<select name="nesting_type" class="form-control" multiple>

<option value="Arbre">Arbre</option>

<option value="Cavité rocheuse">Cavité rocheuse</option>

<option value="Autre">Autre</option>

<option value="Tout type">Tout type</option>

</select>

</div> -->

    <!-- etat de la colonie -->

    <div class="form-group col-xs-6 col-md-6">

      <label>

        <?= lang('colonie_search'); ?>

      </label>

      <div style="overflow-y: scroll;height:80px;" class="form-control">

        <input type="checkbox" name="etat_de_la_colonie[]" value="Fondatrice" id="Fondatrice">

        <label for="Fondatrice">

          <?= lang('colonie_search1'); ?>

        </label>

        <br>

        <input type="checkbox" name="etat_de_la_colonie[]" value="Etablie" id="Etablie">

        <label for="Etablie">

          <?= lang('colonie_search2'); ?>

        </label>

        <br>

        <input type="checkbox" name="etat_de_la_colonie[]" value="Indéterminée" id="Indéterminée">

        <label for="Indéterminée">

          <?= lang('colonie_search3'); ?>

        </label>

        <br>

      </div>

    </div>

    <!-- <div class="form-group col-xs-6 col-md-6">

<label> Etat de la colonie </label>

<select name="etat_de_la_colonie" class="form-control" multiple>

<option value="Fondatrice">Fondatrice</option>

<option value="Etablie">Etablie</option>

<option value="Indéterminée">Indéterminée</option>

</select>

</div> -->

    <!-- d'essaim -->

    <div class="form-group form-group col-xs-12 col-md-12">

      <!-- code du site -->

      <label>

        <input name="findPro" id="findPro" type="checkbox" class="filled-in">

        <span style="font-size:14px;">

          <?= lang('removal_reqiest'); ?>

        </span>

      </label>

    </div>

    <!-- start observation date -->

    <div class="form-group col-xs-12 col-md-6">

      <label for="">

        <?= lang('between'); ?>

      </label>

      <input type="date" class="form-control jquery-datepicker__input filter-date-class " value="" placeholder=" " name="start_date" id="date_from" /> &nbsp;

    </div>

    <!-- end date observation -->

    <div class="form-group col-xs-12 col-md-6">

      <label for="">

        <?= lang('and_the'); ?>

      </label>

      <input type="date" class="form-control jquery-datepicker__input filter-date-class " value="" placeholder=" " name="end_date" id="date_from" /> &nbsp;

    </div>

    <div class="col-xs-12">

      <input type="hidden" id="hidden_user_id" name="user_id">

      <input type="submit" onclick="return validateSearch()" name="sbmitbtn" id="sbmitbtnid" value="<?= lang('submit_search'); ?>" class="btn btn-default btn-info">

    </div>

    <script type='text/javascript' src='https://maps.googleapis.com/maps/api/js?key=AIzaSyAaqEI1hEro18UDNXVHKnQ5dc6A_vF-crY'>

    </script>

    <script type="text/javascript">
      $('#date_from').val("");

      $('#date_to').val("");
    </script>

  </form>

</div>

<?php

if (count($result->result()) > 0) {

  $acontent = array();

  foreach ($result->result() as $row) {


    $nest_id[]                    = $row->id;

    $acontentHTML[]               = $row->address;

    $auserIds[]                   = $row->user_id;

    $nestIds[]                    = $row->id;

    $alat[]                       = $row->latitude;

    $aimage[]                     = $row->image;

    $alon[]                       = $row->longitude;

    $astatus[]                    = $row->status;

    $adiameter[]                  = $row->diameter;

    $aHeight[]                    = $row->height;

    $subspecie[]                  = $row->subspecie;

    $aname[]                      = $row->name;

    $adedDate[]                   = date('d-m-Y', strtotime($row->date));

    $aStrfiles[]                  = $row->files;

    $aPlace[]                     = $row->place;

    $aNesting_type[]              = $row->nesting_type;

    $nest_extra_info[]            = $row->e_nesting_type_info;

    $aTree_genes[]                = $row->tree_genes;

    $aColonie_hauteur[]           = $row->colonie_hauteur;

    $aColonie_dimension[]         = $row->colonie_dimension;

    $aOrientation[]               = $row->orientation;

    $aShape[]                     = $row->shape;

    $aArea[]                      = $row->area;

    $aEntries_exits[]             = $row->entries_exits;

    $aSite_tree[]                 = $row->site_tree;

    $aTree_alive[]                = $row->tree_alive;

    $aActivity[]                  = $row->activity;

    $aPollen_form_date[]          = $row->pollen;

    $aPollen[]                    = get_etat_de_la_colonie($row->id);

    $aPollen_flights[]            = $row->flights;

    $aPollen_fight_with_workers[] = $row->fight_with_workers;

    $aPollen_waste_wax[]          = $row->waste_wax;

    $aPollen_entries_exits[]      = $row->entries_exits;

    $aTemperature[]               = $row->temperature;

    $aWeather_situation[]         = $row->weather_situation;

    $aDetailed_information[]      = $row->detailed_information;

    $aTimestamp[]                 = $row->timestamp;

    $aUpdated_at[]                = get_tbl_follow_data($row->id);

    $aUniqid[]                    = $row->uniqid;

    $aRadius[]                    = $row->radius;
    $ahide_location[]                    = $row->hide_location;
    $auserid_data[]               = $row->user_id;
  }
};

?>

<script type="text/javascript">
  function formsbmit(id) {

    document.getElementById(id).submit();

  }

  var markers = [];

  function loadMap() {

    var infoWindowContent = [

      <?php

      $totalWindow = 0;

      if (count($acontentHTML) > 0) {

        $totalWindow = count($acontentHTML);

        for (
          $index = 0;

          $index < count($acontentHTML);

          $index++
        ) {

          $btnEdit      = '';

          $btnPrototype = '';

          $btnDel       = '';

          $btnFollow    = '';

          $geonestUser  = false;
          // haris code start here
          $ci = &get_instance();
          $user_data =  $ci->db->query("select * from users where id=$auserIds[$index]")->result_array()[0];


          // haris code end here




          if ($this->session->userdata('userlogin') == true) {

            $geonest   = 'geonest';

            $userEmail = $this->session->userdata('email');
            /*

            if (strpos($userEmail, $geonest) !== false) {

              $geonestUser = true;

              $btnEdit     = '<a  onClick="editItem(\'' . $nestIds[$index] . '\')"  class="btnhalf"  hr"><i class="glyphicon glyphicon-pencil"></i>';

              $btnDel      = '<a onClick="deleteItem(\'' . $nestIds[$index] . '\')" class="btnhalf" href="javascript:void(0)"><i class="glyphicon glyphicon-trash"></i></a>';
            } else if ($auserIds[$index] == $this->session->userdata('user_id')) {
              //      $_SESSION['user_type']
              // if ($user_data['user_type'] == 5 || $user_data['user_type'] == 4) {
              // }

              $btnEdit   = '<a  href="' . base_url() . 'map/edit_complete_form/' . $nestIds[$index] . '" class="btnhalf" ><i class="glyphicon glyphicon-pencil"></i></a>';

              $btnDel    = '<a onClick="deleteItem(\'' . $nestIds[$index] . '\')" class="btnhalf" href="javascript:void(0)"><i class="glyphicon glyphicon-trash"></i></a>';

              $btnFollow = '<a href="' . base_url() . 'map/followHistory/' . $nestIds[$index] . '" class="btnFollow pinbuttons border-0">' . lang('suivi_monitor_btn') . '</a>';
            }
            */
            if ($auserIds[$index] == $this->session->userdata('user_id')) {
              $btnEdit   = '<a  href="' . base_url() . 'map/edit_complete_form/' . $nestIds[$index] . '" class="btnhalf" ><i class="glyphicon glyphicon-pencil"></i></a>';

              $btnDel    = '<a onClick="deleteItem(\'' . $nestIds[$index] . '\')" class="btnhalf" href="javascript:void(0)"><i class="glyphicon glyphicon-trash"></i></a>';

              $btnFollow = '<a href="' . base_url() . 'map/followHistory/' . $nestIds[$index] . '" class="btnFollow pinbuttons border-0">' . lang('suivi_monitor_btn') . '</a>';
            }

            /*
            // haris comment this
            //  elseif ($this->session->userdata('user_type') == PRO_USER) {

            //   $btnEdit   = '<a href="' . base_url() . 'map/edit_complete_form/' . $nestIds[$index] . '" class="btnhalf" href="javascript:void(0)"><i class="glyphicon glyphicon-pencil"></i></a>';

            //   $btnDel    = '<a onClick="deleteItem(\'' . $nestIds[$index] . '\')" class="btnhalf" href="javascript:void(0)"><i class="glyphicon glyphicon-trash"></i></a>';

            //   $btnFollow = '<a  href="' . base_url() . 'map/followHistory/' . $nestIds[$index] . '" class="pinbuttons border-0">' . lang('site_monitor') . '</a>';
            // }
            // end here
            //haris code  Institution (5) have rights to delete/modify/monitor any  referent nests (3)
           */

            if ($_SESSION['user_type'] == 3 && $user_data['user_type'] == 4) {

              $btnEdit   = '<a  href="' . base_url() . 'map/edit_complete_form/' . $nestIds[$index] . '" class="btnhalf" ><i class="glyphicon glyphicon-pencil"></i></a>';

              $btnDel    = '<a onClick="deleteItem(\'' . $nestIds[$index] . '\')" class="btnhalf" href="javascript:void(0)"><i class="glyphicon glyphicon-trash"></i></a>';

              $btnFollow = '<a href="' . base_url() . 'map/followHistory/' . $nestIds[$index] . '" class="btnFollow pinbuttons border-0">' . lang('suivi_monitor_btn') . '</a>';
            } elseif ($_SESSION['user_type'] == 5) {

              $btnEdit   = '<a  href="' . base_url() . 'map/edit_complete_form/' . $nestIds[$index] . '" class="btnhalf" ><i class="glyphicon glyphicon-pencil"></i></a>';

              $btnDel    = '<a onClick="deleteItem(\'' . $nestIds[$index] . '\')" class="btnhalf" href="javascript:void(0)"><i class="glyphicon glyphicon-trash"></i></a>';

              $btnFollow = '<a href="' . base_url() . 'map/followHistory/' . $nestIds[$index] . '" class="btnFollow pinbuttons border-0">' . lang('suivi_monitor_btn') . '</a>';
            }

            // haris code end here
          }
          if ($ahide_location[$index] == "on") {





            if ($_SESSION['user_type'] == 3 || $_SESSION['user_type'] == 5 || $_SESSION['user_id'] == $auserid_data[$index]) {

              $acontentHTML[$index] = $acontentHTML[$index];
            } else {
              $acontentHTML[$index] = "**************";
            }
          } else {

            $acontentHTML[$index] = $acontentHTML[$index];
          }

          $mapIcon = 'https://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi2.png';

          $mapIcon = 'assets/white.png';

          if (!empty($aStrfiles)) {

            $imagestr  = '';

            $videosstr = '';

            if (strpos($aStrfiles[$index], 'https') !== false) {

              $astrfileskk = explode('|', $aStrfiles[$index]);

              $imagestr .= '<img  style="display:block" class="firebase" src="' . $astrfileskk[0] . '"  onclick="myModal(\'' . $astrfileskk[0] . '\')" class="mySlides" >';
            } else {

              $astrfiles = explode(',', $aStrfiles[$index]);

              for ($k = 0; $k < count($astrfiles); $k++) {

                $displatImg = '';

                if ($k == 0) {

                  $displatImg = 'style="display:block"';
                }

                $astrfileskk = explode('|', $astrfiles[$k]);

                if ($astrfileskk[1] == 0) {

                  $file = base_url() . 'uploads/images/' . $astrfileskk[0];

                  if (file_exists(FCPATH . 'uploads/images/' . $astrfileskk[0])) {

                    $imagestr .= '<img   ' . $displatImg . ' src="' . $file . '"  onclick="myModal(\'' . $file . '\')" class="mySlides" >';
                  }
                } else if ($astrfileskk[1] == 1) {

                  $videosstr .= '<video id="my-video" controls preload="auto"   height="150px" style="width:100%;margin: 20px 0px 0px 0px;"   data-setup="{}"> <source src="' . base_url() . 'uploads/images/' . $astrfileskk[0] . '" type="video/mp4"></video>';
                }
              }
            }
          }


      ?>[`'<div class="info_content"><div class="w3-content w3-display-container"><?php


                                                                                  echo $imagestr;

                                                                                  $aColonie_hauteur[]      = $row->colonie_hauteur;

                                                                                  $aColonie_dimension[]    = $row->colonie_dimension;

                                                                                  $aOrientation[]          = $row->orientation;

                                                                                  $aShape[]                = $row->shape;

                                                                                  $aArea[]                 = $row->area;

                                                                                  $aEntries_exits[]        = $row->entries_exits;

                                                                                  $aSite_tree[]            = $row->site_tree;

                                                                                  $aTree_alive[]           = $row->tree_alive;

                                                                                  $aActivity[]             = $row->activity;

                                                                                  $aPollen_form_date[]     = $row->pollen;

                                                                                  $aTemperature[]          = $row->temperature;

                                                                                  $aWeather_situation[]    = $row->weather_situation;

                                                                                  $aDetailed_information[] = $row->detailed_information;

                                                                                  $nesting_type[]          = $row->nesting_type;

                                                                                  ?>

         <button class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094;</button><button class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">&#10095;</button></div></br><?php



                                                                                                                                                                                                          $CI = &get_instance();

                                                                                                                                                                                                          $show_val = '';

                                                                                                                                                                                                          $data     = $CI->db->get_where('tbl_follow', array(

                                                                                                                                                                                                            'nest_id' => $nestIds[$index]

                                                                                                                                                                                                          ))->result_array();

                                                                                                                                                                                                          if (!empty($data)) {

                                                                                                                                                                                                            $data                        = $data[count($data) - 1];

                                                                                                                                                                                                            $aPollen_form_date[$index] = $data['pollen'];

                                                                                                                                                                                                            if ($data['pollen'] != 'Oui') {

                                                                                                                                                                                                              $aPollen_flights[$index]            = $data['flights'];

                                                                                                                                                                                                              $aPollen_fight_with_workers[$index] = $data['fight_with_workers'];

                                                                                                                                                                                                              $aPollen_waste_wax[$index]          = $data['waste_wax'];

                                                                                                                                                                                                              $aPollen_entries_exits[$index]      = $data['entries_exits'];
                                                                                                                                                                                                            }
                                                                                                                                                                                                            // poka




                                                                                                                                                                                                            $aActivity[$index]             = $data['activity'];

                                                                                                                                                                                                            $aTemperature[$index]          = $data['temperature'];

                                                                                                                                                                                                            $aWeather_situation[$index]    = $data['weather_situation'];

                                                                                                                                                                                                            $aDetailed_information[$index] = $data['a_information'];

                                                                                                                                                                                                            $disappeared                     = $data['disappeared'];

                                                                                                                                                                                                            if ($disappeared == 'Oui') {

                                                                                                                                                                                                              $show_val = '<tr><td>' . lang('picked_up_beekeeper') . '</td><td>' . lang1($data['pickedup']) . '</td></tr>';
                                                                                                                                                                                                              $occupied_val = lang1($data['cavity_occupied']);
                                                                                                                                                                                                              if ($data['cavity_occupied'] == 'Oui') {
                                                                                                                                                                                                                $occupied_val = $data['pouvezvous'];
                                                                                                                                                                                                              }
                                                                                                                                                                                                              $show_val .= '<tr><td>' . lang('cavity_suive_modal') . '</td><td>' . $occupied_val . '</td></tr>';
                                                                                                                                                                                                            }
                                                                                                                                                                                                          }

                                                                                                                                                                                                          if ($aPollen_form_date[$index] != 'Oui') {

                                                                                                                                                                                                            $pollen_data = ' <tr><td colspan="2"><div class="panel-group">

<div class="panel panel-default">

<div   class="">

<h4 class="panel-title">

<a  data-toggle="collapse" href="#collapse2" class="text-left pinbuttons" >' . lang('observation_nest_modal') . '</a>

    </h4>

    </div>

<div id="collapse2" class="panel-collapse collapse">

<ul class="list-group">

<li class="list-group-item"> ' . lang('flights_nest_modal') . '  ' . lang1($aPollen_flights[$index]) . ' </li>

<li class="list-group-item">  ' . lang('fights_nest_modal') . ' ' . lang1($aPollen_fight_with_workers[$index]) . ' </li>

<li class="list-group-item">' . lang('wax_nest_modal') . '    ' . lang1($aPollen_waste_wax[$index]) . ' </li>

<li class="list-group-item">' . lang('entries_nest_modal') . '  ' . lang1($aPollen_entries_exits[$index]) . ' </li>

    </ul>

    </div>

    </div>

    </div></td></tr>';
                                                                                                                                                                                                          } else {

                                                                                                                                                                                                            $pollen_data = '';
                                                                                                                                                                                                          }

                                                                                                                                                                                                          if (empty($btnFollow)) {

                                                                                                                                                                                                            $style1 = "display:none";
                                                                                                                                                                                                          } else {

                                                                                                                                                                                                            $style1 = "";
                                                                                                                                                                                                          }

                                                                                                                                                                                                          $display = 'display:block';

                                                                                                                                                                                                          if ($aNesting_type[$index] != 'Arbre') {

                                                                                                                                                                                                            $display = 'display:none';
                                                                                                                                                                                                          }

                                                                                                                                                                                                          if ($aNesting_type[$index] == 'Autre') {

                                                                                                                                                                                                            $aNesting_type[$index] = $nest_extra_info[$index];
                                                                                                                                                                                                          } else {

                                                                                                                                                                                                            $aNesting_type[$index] = lang1($aNesting_type[$index]);
                                                                                                                                                                                                          }

                                                                                                                                                                                                          echo $videosstr;


                                                                                                                                                                                                          ?><?php

                                                                                                                                                                                                            echo '<table class="table" ><tr><td>' . lang('site_code_modal') . ' </td><td> ' . $aUniqid[$index] . '</td></tr><tr><td> ' . lang('date_nest_modal') . ' </th><td>' . $adedDate[$index];

                                                                                                                                                                                                            ?><?php

                                                                                                                                                                                                              echo '</td></tr><tr><td>' . lang('name_nest_modal') . '</td><td> ' . $aname[$index];

                                                                                                                                                                                                              ?><?php



                                                                                                                                                                                                                echo '</td></tr><tr><td>' . lang('address_nest_modal') . '</td><td>' . $acontentHTML[$index];




                                                                                                                                                                                                                ?><?php

                                                                                                                                                                                                                  echo '</td></tr><tr>

                                                                                                                                                                                                            <tr><td>' . lang('law_nest_modal') . ' </td><td>' . lang1($aPlace[$index]);

                                                                                                                                                                                                                  ?><?php

                                                                                                                                                                                                                    echo '</td></tr>

<tr><td>' . lang('site_nest_modal') . ' </td><td>' . $aNesting_type[$index];

                                                                                                                                                                                                                    ?><?php

                                                                                                                                                                                                                      echo '</td></tr>

<tr><td>' . lang('height_reporting') . ' </td><td>' . $aColonie_hauteur[$index];

                                                                                                                                                                                                                      ?><?php

                                                                                                                                                                                                                        echo '</td></tr>

<td colspan="2"><div class="panel-group">

<div class="panel panel-default">

<div  >

<h4 class="panel-title">

<a  data-toggle="collapse" href="#collapse1" class="pinbuttons">' . lang('complement_nest_modal') . '</a>

    </h4>

    </div>

<div id="collapse1" class="panel-collapse collapse">

<ul class="list-group">

<li style="' . $display . '" ><b>' . lang('tree_info_nest_modal') . '</b></li>

<li style="' . $display . '" class="list-group-item">' . lang('subspecie') . ': &nbsp;&nbsp ' . $subspecie[$index] . ' </li>

<li style="' . $display . '" class="list-group-item">' . lang('height_nest_modal') . ' &nbsp;&nbsp;' . $aHeight[$index] . ' </li>

<li style="' . $display . '" class="list-group-item">' . lang('circumference_nest_modal') . ' &nbsp;&nbsp;' . $aTree_genes[$index] . ' </li>

<li style="' . $display . '"  class="list-group-item">' . lang('living_tree_nest_modal') . '  &nbsp;&nbsp;' . lang1($aTree_alive[$index]) . ' </li>

<li><b>' . lang('entry_nest_modal') . '</b></li>        

<li class="list-group-item">' . lang('dimension_nest_modal') . ' &nbsp;&nbsp;' . $aColonie_dimension[$index] . ' </li>

<li class="list-group-item">' . lang('Orientation') . ' &nbsp;&nbsp;' . lang1($aOrientation[$index]) . ' </li>

<li class="list-group-item">' . lang('form_nest_modal') . '   &nbsp;&nbsp;' . $aShape[$index] . ' </li>

<li class="list-group-item">' . lang('entrance_nest_modal') . '    &nbsp;&nbsp;' . $aArea[$index] . ' </li>

    </ul>

<div class="panel-footer">' . lang('complement_section_nest_modal') . '</div>

    </div>

    </div>

    </div></td></tr>  <tr><td>

' . lang('colony_nest_modal') . ' &nbsp;&nbsp; </td><td>' . lang1(getetatdelacolonyStatus($nestIds[$index])) . '</td></tr>

<tr><td>

' . lang('pollen') . ' &nbsp;&nbsp; </td><td>' . lang1($aPollen_form_date[$index]) . '</td></tr>

' . $pollen_data . '

<tr><td>' . lang('activity_nest_modal') . ' &nbsp;&nbsp;</td><td>' . lang1($aActivity[$index]);

                                                                                                                                                                                                                        ?><?php

                                                                                                                                                                                                                          echo '</td> </tr><td>' . lang('temperature_nest_modal') . ' : &nbsp;&nbsp;</td><td>' . $aTemperature[$index];

                                                                                                                                                                                                                          ?><?php

                                                                                                                                                                                                                            echo '</td></tr> <td>

' . lang('weather_forcast_nest_modal') . '  &nbsp;&nbsp; </td><td> ' . lang2($aWeather_situation[$index]) . '</td></tr> <tr><td> ' . lang('details_nest_modal') . '  : &nbsp;&nbsp;</td><td>' . $aDetailed_information[$index];

                                                                                                                                                                                                                            ?><?php

                                                                                                                                                                                                                              echo '</td><tr><td>' . lang('update_nest_modal') . '</td><td> ' . date('d-m-Y H:i:s', strtotime(getLatestmodifydate($nestIds[$index])));

                                                                                                                                                                                                                              ?><?php

                                                                                                                                                                                                                                echo '</td></tr>

' . $show_val . last_observation_date($nestIds[$index]) . '

<tr style="' . $style1 . '">

<td colspan="2"  class="border-0" style="padding: 3px!important;">' . $btnFollow . '</td>

    </tr>

<tr><td colspan="2" class="text-center" style="border:none">

' . $btnEdit . '  ' . $btnDel . ' 

    </td></tr>

<table class="map_table">';

                                                                                                                                                                                                                                ?>

<?php

          $next            = $index + 1;

          $prev            = $index - 1;

          $changeClassNext = '';

          if ($totalWindow == $next) {

            $changeClassNext = 'lastNext';
          }

          $changeClassPrev = '';

          if ($prev == -1) {

            $changeClassPrev = 'lastPrev';
          }

          echo '<a href="javascript:void(0)" style="position: absolute;left:10px;bottom:5px" onClick="triggerClick(' . $prev . ')" class="  btnNexpre pull-left  btn btn-xs ' . $changeClassPrev . '"><i class="glyphicon glyphicon-triangle-left"></i> ' . lang('previous') . ' </a>';

          echo '<a href="javascript:void(0)" style="position: absolute;right:10px;bottom:5px" onClick="triggerClick(' . $next . ')" class="  btnNexpre pull-right btn btn-xs ' . $changeClassNext . '">' . lang('next') . ' <i class="glyphicon glyphicon-triangle-right"></i></a>';

?>

`],

        <?php

        }
      } else {

        ?>

      <?php

      }

      ?>

    ];

    var customzoom = 3;

    var radiusStroke = '<?= $radisfilter ?>';

    if (radiusStroke == '') {

      radiusStroke = 150;

    }

    if (radiusStroke > 4000) {

      customzoom = 2;

    }

    var mapOptions = {

      gestureHandling: "greedy",

      mapTypeControl: false,

      zoom: customzoom,

      center: new google.maps.LatLng(<?= $latitude ?>, <?= $longitude ?>),

      mapTypeId: 'roadmap'

    }

    var map = new google.maps.Map(document.getElementById("googlemap"), mapOptions);

    if (radiusStroke < 4000) {

      var antennasCircle = new google.maps.Circle({

          strokeColor: "#8080803b",

          strokeOpacity: 0.8,

          strokeWeight: 2,

          fillColor: "#000",

          fillOpacity: 0.35,

          map: map,

          center: {

            lat: <?= $latitude ?>,

            lng: <?= $longitude ?>

          }

          ,

          radius: 1000 * radiusStroke

        }

      );

      map.fitBounds(antennasCircle.getBounds());

    }

    var locations = [

      <?php

      if (count($alat) > 0) {

        for (
          $key = 0;

          $key < count($alat);

          $key++
        ) {

      ?>

          [infoWindowContent[<?php

                              echo $key;

                              ?>][0], <?php

                                      echo $alat[$key];

                                      ?>, <?php

                                          echo $alon[$key];

                                          ?>],

        <?php

        }
      } else {

        ?>

      <?php

      }

      ?>

    ];

    var marker, i;

    var infowindow = new google.maps.InfoWindow({

        maxWidth: 2880,

      }

    );

    infowindow.setZIndex(1111111111);

    google.maps.event.addListener(map, 'click', function() {

        infowindow.close();

      }

    );

    // create markers

    for (i = 0; i < locations.length; i++) {

      marker = new google.maps.Marker({

          position: new google.maps.LatLng(locations[i][1], locations[i][2]),

          map: map,

          icon: locations[i][3],

          icon: {

            url: "<?php

                  echo $mapIcon;

                  ?>"

          }

        }

      );

      google.maps.event.addListener(marker, 'click', (function(marker, i) {

          return function() {

            infowindow.setContent(locations[i][0]);

            infowindow.setZIndex(1111111111);

            infowindow.open(map, marker);

          }

        }

      )(marker, i));

      markers.push(marker);

    }

  }

  google.maps.event.addDomListener(window, 'load', loadMap);

  function NextPrev(id) {

  }

  function get(id) {

    google.maps.event.trigger(markers[id], 'click');

    //$(".fancybox").fancybox();

    var slideIndex = 1;

    showDivs(slideIndex);

  }

  function clonerow(id) {

    if (!confirm("êtes-vous sûr de copier les données?")) {

      //User Pressed okay. will make clone

      return false;

    }

    $.ajax({

        url: "<?= base_url() ?>map/clonerow",

        type: 'POST',

        data: {

          id: id

        }

        ,

        dataType: "json",

        success: function(data) {

          if (data.result == true) {

            alert("clonage des données réussi!");

            location.reload();

          } else {

            alert("échec du clonage des données");

          }

        }

      }

    );

  }

  function searchAutocomplete() {

    var fillInAddress;

    // Create the autocomplete object, restricting the search to geographical

    // location types.

    autocomplete = new google.maps.places.Autocomplete((

        document.getElementById('filtertext')), {

        types: ['geocode']

      }

    );

    autocomplete.addListener('place_changed', fillInAddressMY);

  }

  $("#resetbtnid").click(function() {

      $("option:selected").prop("selected", false);

      $('input[type="checkbox"]').prop('checked', false);

      $('input[type="radio"]').prop('checked', false);

      $('input[type="text"]').val('');

    }

  )
</script>

<div id="googlemap" style="width: 100%; height: 700px;">

</div>

<script type="text/javascript">
  $(document).ready(function(e) {

      $(".sbitbtn").click(function() {

          $("#searcform").toggle();

        }

      );

      $("#btnClose").click(function() {

          $("#searcform").hide();

        }

      );

    }

  );
</script>

</body>

</html>

<?php

//include_once "location_js_map.php";

?>

<script type="text/javascript">
  $('#typeAll').click(function(event) {

      if (this.checked) {

        $('.typeAll').each(function() {

            this.checked = false;

          }

        );

      } else {

        $('.typeAll').each(function() {

            this.checked = false;

          }

        );

      }

    }

  );

  var options = {

    enableHighAccuracy: true,

    timeout: 15000,

    maximumAge: 0

  };

  $(document).ready(function() {

      if (navigator.geolocation) {

        navigator.geolocation.getCurrentPosition(showLocation, error, options);

      } else {

        $('#location').html('Geolocation is not supported by this browser.');

      }

      setTimeout(function() {

          $(".fancybox").fancybox();

        }

        , 2000);

    }

  );

  $(document).ready(function() {

      if ($(window).width() > 330) {

        $('.navbar').addClass('navbar-static-top');

      } else {

        $('.navbar').addClass('navbar-fixed-bottom');

      }

    }

  );

  /////////////////////////////////

  window.onload = function() {

    var slideIndex = 1;

    showDivs(slideIndex);

  }

  function plusDivs(n) {

    showDivs(slideIndex += n);

  }

  function showDivs(n) {

    var i;

    var x = document.getElementsByClassName("mySlides");

    if (n > x.length) {

      slideIndex = 1

    }

    if (n < 1) {

      slideIndex = x.length;

    };

    for (i = 0; i < x.length; i++) {

      x[i].style.display = "none";

    }

    x[slideIndex - 1].style.display = "block";

  }

  ////////////////////////////////

  function myModal(src) {

    $("#myModal").modal('show');

    $("#currentImage").attr("src", src);

  }

  function hideback() {

    $(".modal-backdrop").hide();

  }

  function hidemodal() {

    $("#myModal").modal('hide');

    $(".modal-backdrop").hide();

  }

  function deleteItem(id) {

    if (!confirm("<?php

                  echo lang('operation');

                  ?>")) {

      //User Pressed okay. Delete

      return false;

    }

    $.ajax({

        url: "<?= base_url() ?>map/deleteItem",

        type: 'POST',

        data: {

          id: id

        }

        ,

        dataType: "json",

        success: function(response) {

          alert("<?php

                  echo lang('success');

                  ?>");

          location.reload();

        }

      }

    );

  }

  function delImage(id) {

    //alert(id);

    if (confirm("<?php

                  echo lang('operation');

                  ?>")) {

      $.ajax({

          url: "<?= base_url() ?>map/delImage",

          type: 'POST',

          data: {

            id: id

          }

          ,

          dataType: "json",

          success: function(response) {

            $("#imageDiv" + id).remove();

          }

        }

      );

    }

  }

  /******************** haris_edit_form ********************** */

  function editItem(id) {

    $.ajax({

        url: "<?= base_url() ?>map/editnest",

        type: 'POST',

        data: {

          id: id

        }

        ,

        dataType: "json",

        beforeSend: function() {

            $('#loader').removeClass('hidden');

          }

          ,

        success: function(response) {

          $('#loader').addClass('hidden');

          if (response.status == 1) {

            $("#editModal").modal("show");

            $("#editBody").html(response.html);

          } else {

          }

        }

      }

    );

  }

  function viewProtoItem(id) {

    // will get single entitty	and show its image in modal

    $.ajax({

        url: "<?= base_url() ?>map/viewProtoItem",

        type: 'POST',

        data: {

          id: id

        }

        ,

        dataType: "json",

        beforeSend: function() {

            $('#loader').removeClass('hidden');

          }

          ,

        success: function(response) {

          $('#loader').addClass('hidden');

          if (response.status == 1) {

            $("#editModalPrototype").modal("show");

            $("#editBodyPrototype").html(response.html);

          } else {

          }

        }

      }

    );

  }

  /***********************/

  function editFormSave() {

    $("#pro").show();

    //e.preventDefault();	

    var formData = new FormData();

    var other_data = $('#formEit').serializeArray();

    $.each(other_data, function(key, input) {

        formData.append(input.name, input.value);

      }

    );

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

        url: "<?= base_url() ?>map/maplocationsave",

        data: formData,

        cache: false,

        contentType: false,

        processData: false,

        dataType: 'JSON',

        beforeSend: function() {

            $('#loader').removeClass('hidden');

            //	$('#form_skill_squared_kjnsdjnhsdjs87sd8s7d8s7d .btn_au').addClass('hidden');

          }

          ,

        success: function(data) {

          //alert(data);

          if (data) {

            $('#loader').addClass('hidden');

            $('#editModal').modal('hide');

            location.reload();

          }

        }

      }

    );

    //ajax end    

  }

  function prototypeFormSave() {

    var formData = new FormData();

    var other_data = $('#protoTypeFormpost').serializeArray();

    $.each(other_data, function(key, input) {

        formData.append(input.name, input.value);

      }

    );

    $.ajax({

        type: "POST",

        url: "<?= base_url() ?>map/prototypeupdate",

        data: formData,

        cache: false,

        contentType: false,

        processData: false,

        dataType: 'JSON',

        beforeSend: function() {

            $('#spinner').removeClass('hidden');

            //	$('#form_skill_squared_kjnsdjnhsdjs87sd8s7d8s7d .btn_au').addClass('hidden');

          }

          ,

        success: function(data) {

          $('#spinner').addClass('hidden');

          //alert(data);

          if (data) {

            $('#loader').addClass('hidden');

            $('#editModalPrototype').modal('hide');

            location.reload();

          }

        }

      }

    );

    //ajax end    

  }

  function validateSearch() {

    var user_id = $("#userlist option[value='" + $('#user_id').val() + "']").attr('data-id');

    $('#hidden_user_id').val(user_id);

    $("#formsbmittt").submit();

  }

  /*******************/
</script>

<!-- Modal -->

<div id="myModal" class="modal fade" role="dialog">

  <div class="modal-dialog" style="width:90%">

    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" onclick="hideback();" id="btnClosePopup" class="close" data-dismiss="modal">&times;

        </button>

      </div>

      <div class="modal-body">

        <img id="currentImage" onclick="hidemodal()" src="" style="width:100%">

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default" onclick="hideback();" data-dismiss="modal">Close

        </button>

      </div>

    </div>

  </div>

</div>

<div id="editModal" class="modal fade" role="dialog">

  <div class="modal-dialog" style="width:90%">

    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" onclick="hideback();" id="btnClosePopup" class="close" data-dismiss="modal">&times;

        </button>

        <div class="alert hidden">

        </div>

      </div>

      <div class="modal-body" id="editBody">

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default" onclick="hideback();" data-dismiss="modal">Close

        </button>

      </div>

    </div>

  </div>

</div>

<div id="editModalPrototype" class="modal fade" role="dialog">

  <div class="modal-dialog" style="width:90%">

    <!-- Modal content-->

    <div class="modal-content">

      <div class="modal-header">

        <button type="button" onclick="hideback();" id="btnClosePopup" class="close" data-dismiss="modal">&times;

        </button>

        <div class="alert hidden">

        </div>

      </div>

      <div class="modal-body" id="editBodyPrototype">

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-default" onclick="hideback();" data-dismiss="modal">Close

        </button>

        <button type="button" class="btn btn-info" onclick="prototypeFormSave();">

          <i id="spinner" class="  hidden glyphicon gly-spin glyphicon-cog" style="font-size:24px">

          </i>Save

        </button>

      </div>

    </div>

  </div>

</div>