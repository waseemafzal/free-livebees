<?php include_once "header.php"; ?>
<style>
.item{
    border-radius: 5px;
    box-shadow: 1px 1px 6px 1px #9b9aef59;
    background: #fff;	}
	.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
    padding: 0 0 0 5px;
	}
</style>
<section id="sub-header" >

    <div id="tintBG">

        <div class="container">

            <div class="row">

                <div class="col-md-10 col-md-offset-1 text-center">

                    <h1 id="title">Portfolio</h1>





                </div>

            </div><!-- End row -->

        </div><!-- End container -->

    </div>

</section>
<?php
if (count($data->result()) > 0) {
	



  $acontent = array();
  foreach ($data->result() as $row) {
    $nest_id[]                    = $row->id;



    $acontentHTML[]               = html_cut($row->address,30);



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
     $next_observation_date[]               = $row->next_observation_date;
    
    

  }

};
?>

<div class="login-area page-padding">
      <?php
      $totalWindow = 0;
      if (count($acontentHTML) > 0) {



        $totalWindow = count($acontentHTML);

$counterItem=0;

        for ($index = 0;$index < count($acontentHTML);$index++) {
$counterItem++;
          $btnEdit      = '';
          $btnPrototype = '';
          $btnDel       = '';
          $btnFollow    = '';
          $geonestUser  = false;
          $ci = &get_instance();
          $user_data =  $ci->db->query("select * from users where id=$auserIds[$index]")->result_array();
		$user_data =  $user_data[0];
          if ($this->session->userdata('userlogin') == true) {
            $geonest   = 'geonest';
            $userEmail = $this->session->userdata('email');

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
$aColonie_hauteur[] = $row->colonie_hauteur;
$aColonie_dimension[]= $row->colonie_dimension;
$aOrientation[]= $row->orientation;
$aShape[]= $row->shape;
$aArea[]= $row->area;
$aEntries_exits[]  = $row->entries_exits;
$aSite_tree[]= $row->site_tree;
$aTree_alive[] = $row->tree_alive;
$aActivity[] = $row->activity;
$aPollen_form_date[]     = $row->pollen;
$aTemperature[]          = $row->temperature;
$aWeather_situation[]= $row->weather_situation;
$aDetailed_information[] = $row->detailed_information;
$nesting_type[]          = $row->nesting_type;
$CI = &get_instance();
$show_val = '';
$data     = $CI->db->get_where('tbl_follow', array('nest_id' => $nestIds[$index]))->result_array();

if (!empty($data)) {
$data = $data[count($data) - 1];
$aPollen_form_date[$index] = $data['pollen'];
if ($data['pollen'] != 'Oui') {
 $aPollen_flights[$index]  = $data['flights'];
$aPollen_fight_with_workers[$index] = $data['fight_with_workers'];
$aPollen_waste_wax[$index]= $data['waste_wax'];
$aPollen_entries_exits[$index]      = $data['entries_exits'];
}
$aActivity[$index]= $data['activity'];
$aTemperature[$index]= $data['temperature'];
$aWeather_situation[$index]    = $data['weather_situation'];
$aDetailed_information[$index] = $data['a_information'];
                      $disappeared = $data['disappeared'];
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
<a  data-toggle="collapse" href="#collapse'.$index.'" class="text-left pinbuttons" >' . lang('observation_nest_modal') . '</a>
</h4>
</div>
<div id="collapse'.$index.'" class="panel-collapse collapse">
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

?>

<?php


echo '<div class="col-md-4 ">';
?>

                       
<?php 
echo '<div class="item">
<table class="table" 
><tr><td>' . lang('site_code_modal') . ' </td><td> ' . $aUniqid[$index] . '</td></tr>
<tr><td> ' . lang('date_nest_modal') . ' </th><td>' . $adedDate[$index];

echo '</td></tr>
<tr><td>' . lang('name_nest_modal') . '</td><td> ' . $aname[$index];
echo '</td></tr>
<tr><td>' . lang('address_nest_modal') . '</td><td>' . $acontentHTML[$index];
 echo '</td></tr>
 <tr>
 <tr><td>' . lang('law_nest_modal') . ' </td><td>' . lang1($aPlace[$index]);
 echo '</td></tr>
<tr><td>' . lang('site_nest_modal') . ' </td><td>' . $aNesting_type[$index];
echo '</td></tr>
<tr><td>' . lang('height_reporting') . ' </td><td>' . $aColonie_hauteur[$index];
 echo '</td></tr><td colspan="2"><div class="panel-group">
<div class="panel panel-default"><div><h4 class="panel-title">
<a  data-toggle="collapse" href="#collapse'.$index.'" class="pinbuttons">' . lang('complement_nest_modal') . '</a></h4></div>
<div id="collapse'.$index.'" class="panel-collapse collapse">
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
echo '</td> </tr><td>' . lang('temperature_nest_modal') . ' : &nbsp;&nbsp;</td><td>' . $aTemperature[$index];

  echo '</td></tr><td>' . lang('weather_forcast_nest_modal') . '  &nbsp;&nbsp; </td><td> ' . lang2($aWeather_situation[$index]) . '</td></tr> <tr><td> ' . lang('details_nest_modal') . '  : &nbsp;&nbsp;</td><td>' . $aDetailed_information[$index];

 echo '</td><tr><td>' . lang('update_nest_modal') . '</td><td> ' . date('d-m-Y H:i:s', strtotime(getLatestmodifydate($nestIds[$index])));
 echo '</td></tr></table></div></div>';
 if($counterItem%3==0 ){
	 echo '<div class="clearfix">&nbsp;</div>';
	 }
 // item closed
}
} 
?>



    
</div>

<!-- all js here -->

<!-- Start Footer Area -->

<?php include_once "footer.php"; ?>


