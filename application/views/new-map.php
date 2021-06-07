<?php

$user_agent = getenv("HTTP_USER_AGENT");
$os='';
$styleMac='style="margin:0"';
if(strpos($user_agent, "Win") !== FALSE){
$os = "Windows";
}
elseif(strpos($user_agent, "Mac") !== FALSE){
$os = "Mac";
$styleMac='style="padding:0"';
}

	$WHERE = '';
	$statefilter ='';
	$wherelike = '';
	$user_ip='';
  $radisfilter='';
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) { 
        $user_ip= $_SERVER['HTTP_CLIENT_IP']; 
    } 
    else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) { 
        $user_ip= $_SERVER['HTTP_X_FORWARDED_FOR']; 
    } 
    else { 
        $user_ip= $_SERVER['REMOTE_ADDR']; 
    } 
   
	if(isset($_GET['sbmitbtn']))
	{
	   
		
		
				if(isset($_GET['status-filter']) and count($_GET['status-filter']) > 0 )
				{
				// status
					$statusfilterstr = implode(',',$_GET['status-filter']);
					$statusfilter =' AND status  IN   ('.$statusfilterstr.')';
					$WHERE .= $statusfilter;   
				}
				
				if(isset($_GET['type-filter']) and count($_GET['type-filter']) > 0 )
				{
					 // type
					$typefilterstr = implode(',',$_GET['type-filter']);
					$typefilter =' AND nest_type  IN   ('.$typefilterstr.')';
					$WHERE .= $typefilter;   
				}
				if(isset($_GET['mynest']) and count($_GET['mynest']) > 0 )
				{
				    $mynest="AND userId='".$_GET['userId']."' ";
				$WHERE .= $mynest; 
				}
				
			  
				$dateClause ='';
				if(isset($_GET['date_from']) and !empty($_GET['date_from']) and  isset($_GET['date_to']) and !empty($_GET['date_to']))
				{
					//echo $_GET['date_from'];exit;
				
					$date_from = date('Y-m-d',strtotime($_GET['date_from'] ) );
					
				   $date_to = date('Y-m-d', strtotime($_GET['date_to']));
					$dateClause =  ' AND (added_date BETWEEN "'.$date_from.'" AND  "'.$date_to.'")';
					//echo $dateClause;exit;
				}
				
				
				$dateWhere = ' '.$AND.' '.$dateClause.'';
				$stateresgionfilter ='';
				if(isset($_GET['stateregsion-filter']) and !empty($_GET['stateregsion-filter']))
				{
					$stateresgionfilter =' AND  state_region='.'"'.$_GET['stateregsion-filter'].'"';
					$WHERE .= $stateresgionfilter;
				}
				
				if(isset($_GET['filtertext']) and (!empty($_GET['filtertext'])))
				{	
					$alocation = $this->crud->extract_coordinates($_GET['filtertext']); 
					$latitude =  $alocation['lat'];
					$longitude =  $alocation['lng'];
				}
				if(!empty($latitude) and !empty($longitude))
				{
				    $lat =$latitude;	
				    $lon=$longitude;
				}
				else
				{
				   $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$user_ip));	
				   $lat=$query['lat'];
				   $lon= $query['lon'];
				}
				
				$radiusHaving  = 'HAVING radius <= 150 ORDER BY radius ASC';
				if(isset($_GET['radisfilter']) and !empty($_GET['radisfilter']))
				{
				    $radisfilter=$_GET['radisfilter'];
				  $radiusHaving  = ' HAVING radius <= '.$_GET['radisfilter'].' ORDER BY radius ASC';
				  	
				}
				
			$radiusFiltr	=',(SELECT GROUP_CONCAT(tbl_map_images.file,"|",tbl_map_images.type) FROM tbl_map_images WHERE tbl_loc.id= tbl_map_images.map_id ) AS files,lat as latitude,lon as longitude,3959 * ACOS(SIN(RADIANS( '.$lat.' )) * SIN(RADIANS(`lat`)) +
					COS(RADIANS( '.$lat.' )) * COS(RADIANS(`lat`)) * COS(RADIANS(`lon`) -
					RADIANS( '.$lon.' ))) AS `radius` FROM tbl_loc   ';
				
				
				
				$sql = "SELECT *  ".$radiusFiltr."  WHERE 1=1 ".$WHERE ."    ".$dateWhere."  ".$radiusHaving." "; 
					$result = $this->db->query($sql);
					//lq();
				   
	   }
		
		
		$astateregions = $this->db->query("SELECT DISTINCT state_region FROM ".$this->tbl_loc." ");
		
		
?> 
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>Geonet</title>
  
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<link rel="stylesheet" href="https://geonest.org/fancybox/source/jquery.fancybox.css">
 <script src="https://geonest.org/fancybox/source/jquery.fancybox.js"></script>

<script src="<?php echo base_url();?>assets/GBJSTK.js"></script>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
 <style type="text/css">
 .gm-style img {
    max-width: none;
    width: 100%;
}
.w3-content {
    width: 100%;
}
.w3-black {
    top:50% !important;background:yellow;
}
  .searcform{ display:none;background: #fff;
border: 1px solid #ddd;
padding: 10px;
position: absolute;
z-index: 10000;
left: 5%;
top: 10%;}

.pac-container{
z-index: 10000;
}
.sbitbtn{ 
position: absolute;
z-index: 10000;
left: 10%;
top: 5%;}
.btnNexpre{
        background-color: #ddd;
    border: none !important;
    margin: 1px 7px 5px 7px !important;
}
  #nested_total {     background: yellow;
    cursor: pointer;
    position: absolute;
    z-index: 10000;
    width: 70px;
    text-align: center;
    right: 10%;
    top: 18%;
      padding: 12px 12px;
    border-radius: 50px;

}
.lastNext{
        background: yellow !important;
}.lastPrev{
      background: yellow !important;
}
  .jquery-datepicker{position: relative;margin: 0px 5px 0px 0px;

width: 43%;
float: left;}
.jquery-datepicker__panel{z-index: 100000 !important;}
.jquery-datepicker__table{z-index: 10000 !important;}
.jquery-datepicker__panel.-position--below{
        margin-top: -294px !important;;
}

.mrfn{ margin:0px !important; }  
.jquery-datepicker__panel{
    
}
.searchBtn{
    position:absolute;
   left: 3%;
    top: 22%;
    background-color: yellow;
    color: #000;
    border-color:#000;
    border: none;
    
}

.searcform{
    overflow-y: scroll;
    max-height: 500px;}
    .btnClose{
         position: absolute;
    right: 3%;
    color: #58516d;
    font-size: 17px;
    border: 2px solid;
    border-radius: 50px;
    padding: 4px 7px 0px 6px;
    }
	.gm-style-iw { width: 300px;} 
	
	.info_content a {
      margin: 0 4px 0 0px;
    border-radius: 15px;
    box-shadow: 1px 2px 4px 0px #656565;
    
    border: 1px solid;
}
	.info_content a img{
	    
	}
	#localAddress{
	    text-align: center;
    background: #F9E003;
    padding: 5px 0px;
	}
		#localAddress span{
	        padding: 0 20px;
	}
	#googlemap .gm-style-iw-a{
	    z-index: 999999;
	}
	
	label {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 5px;
    font-weight: bold;
    font-size: 10px;
}
.info_content>b{
    width: 84px;
    display: inline-block;
}
 input[type="number"]{
    padding: 0;
}

.delImage{
    
    position: absolute;
    right: 8px;
    top: -10px;
    font-size: 20px;
    border: 1px solid #000;
    padding: 2px 10px;
    background-color: yellow;
    color: red;
    border-radius: 20px;
    text-align: center;

}

	@media only screen and (max-width: 768px) {
h3 {
    font-size: 16px;
}
.gm-style-iw {
  width: 100%; 
  
}
	.gmnoprint{display: none;}
	.searchBtn,#nested_total {
    top: 10%;
	}
	
	label {
     font-weight: normal;
    font-size: 10px;
}
.mySlides .w3-black {
        top: 50% !important;
    background-color: yellow !important;
    padding: 6px 7px;
    color: #000 !important;
}

.mySlides .w3-button:hover {
    color: #000!important;
    background-color:yellow!important;
}
}
.gm-ui-hover-effect {
    opacity: 1;
    border: 1px solid #fc0 !important;
    margin: 5px 4px 0 0 !important;
    border-radius: 18px;
    background-color: #fc0 !important;
}
.mySlides .w3-black {
    padding: 2px 4px!important;
    
}
.modal{
        z-index: 99999;
}
.table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
    padding: 2px 4px;
}.w3-black, .w3-hover-black:hover {
    color: #000!important;
    background-color: yellow!important;
     padding: 8px 12px!important;
}
 </style>
 
<style>
.mySlides {display:none;}
.skiptranslate{}


.goog-te-banner-frame.skiptranslate {
    display: none !important;
    } 
   .goog-te-gadget img {
    vertical-align: middle;
    border: none;
    display: none;
}
.fukcr{top: 0 !important;}
#lol{top: 0 !important;}

    #google_translate_element{position: absolute;}
</style>
 <script>
     $(window).on('load',function(){
   // PAGE IS FULLY LOADED  
   // FADE OUT YOUR OVERLAYING DIV
   $('#overlay').fadeOut();
});
 </script>
</head>
<body id="lol" style="position: relative;
    min-height: 100%;
    top: 0;">
    
<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'fr',
includedLanguages: 'fr,en,es', 
            autoDisplay: false,
 layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
$(document).ready(function(){
   setTimeout(function(){
            $("body").css("top", 0);
     $("body").addClass("fukcr");
     $(".goog-te-gadget img").addClass("hidden");
  
                    },2000);
   
  
});
</script>

        <style>
       .error{ color:red
	   }
	   .has-error input{ border:1px solid red}
.centered {
  position: fixed;
  top: 50%;
  left: 50%; z-index: 9999;
  /* bring your own prefixes */
  transform: translate(-50%, -50%);
}
h3 {
    font-size: 22px;
}
#SELECT{width:100px;display: inline-block;padding: 0;margin: 4px 6px 0 4px;height: auto;}
       </style> 
        <div id="loader" class="hidden">
    <div id="loading-img" class="centered"> 
    
    <img src="https://geonest.org/assets/loader.gif">
    </div>
	
    </div>
    <div id="overlay">
     Loading...
</div>

<div id="localAddress"><span>
    
 <?php echo $address; ?>
    
</span>
<div style="text-align:center;width:100%">
<select id="SELECT" onChange="changeForm(this.value)">
<option value="French">French</option>
<option value="English">English</option>
</select>
</div>
</div>
<div id="nested_total">
    <?php
    foreach($result->result() as $ids){
        $idsArr[]=$ids->id;
    }
   $str= implode(',',$idsArr);
    ?>
    <?php echo  count($result->result());?> Nests 
    <form id="csvForm" action="https://geonest.org/map/exportCsv" method="post">
    <input type="hidden" value="<?=$str?>" name='ids'>
    </form>
    </div>

<script type="text/javascript">
    
$("#nested_total").click(function(){
$("#csvForm").submit();
});
function changeForm(v){
	if(v=='French'){
	$('.French').show();
	$('.English').hide();
	}else{
		//engAddress
		//
		$('.English').show();
	$('#.French').hide();
	
		}
	}
</script>
 
 <button  type="button" class=" searchBtn btn btn-default French sbitbtn sbitbtnFr btn-info"><i class="glyphicon glyphicon-search"></i> Rechercher Un  Nid</button>
  <button  type="button" style="display:none" class=" searchBtn btn btn-default English sbitbtn sbitbtnEng btn-info"><i class="glyphicon glyphicon-search"></i> &nbsp;Search a Nest &nbsp;&nbsp;&nbsp;</button>
 <div class="col-md-4 col-xs-11 French searcform searcformFr">
      <a class="btnClose"  href="javascript:void(0)"><i class="glyphicon glyphicon-remove"></i></a>
    <div class="col-xs-7">
      <h3>Où est le Nest?</h3>
      </div>
        <form id="formsbmittt"  action="" method="GET">
        <span id='proceeee'></span>
         
    <div class="col-xs-8 col-sm-8 col-lg-8  col-md-8">
      <label for="email">Adresse :</label> 
     <?php 	 $localAddress='';	 if(isset($address) and $address!=''){		 $localAddress=$address;	 }	 if(isset( $_GET['filtertext'])) {	$localAddress=	 $_GET['filtertext'];	 }	 		 ?>
       <input type="text" class="form-control" name="filtertext" id="filtertext" value="<?=$localAddress;?>"  placeholder="Enter address to search"/>
    </div>
   
    <div class="col-xs-4 col-sm-4 col-lg-4  col-md-4">
     
      <label>Rayon en KM:</label>
        <input name="radisfilter" class="form-control" value="100" type="number"/> 
   
	</div>
	  <input name="userId" type="hidden" value="<?=$userId?>" /> 
   
    <div class="clearfix">&nbsp;</div>
    <div class="col-xs-12" > <label for="sel1">Types de nids:</label></div>
    <div class="checkbox mrfn">
    
           <div class="col-xs-6 col-md-6" > <label class="checkbox-inline">
            <input type="checkbox" class="typeAll" name="type-filter[]" value="1">Frelon asiatique
            </label></div>
         <div class="col-xs-6 col-md-6" >   <label class="checkbox-inline">
            <input type="checkbox" class="typeAll" name="type-filter[]" value="2">Frelon européen
            </label></div>
        <div class="col-xs-6 col-md-6" >    <label class="checkbox-inline">
            <input type="checkbox" class="typeAll" name="type-filter[]" value="3">Guêpe
            </label></div>
        <div class="col-xs-6 col-md-6" >    <label class="checkbox-inline">
            <input type="checkbox" id="typeAll"  >
            </label></div>
        </div>
    <div class="clearfix">&nbsp;</div>
       <div class="col-xs-12" >  <label for="sel1">State:</label></div>
         <div class="checkbox mrfn">
           
       <div class="col-xs-6 col-md-4" >   <label class="checkbox-inline">
            <input type="checkbox" name="status-filter[]" value="1">Actif
            </label></div>
       <div class="col-xs-6 col-md-4" >     <label class="checkbox-inline">
            <input type="checkbox" name="status-filter[]" value="2">Inactif
            </label></div>
       <div class="col-xs-6 col-md-4" >     <label class="checkbox-inline">
            <input type="checkbox" name="status-filter[]" value="3">Traité
            </label></div>
         <div class="col-xs-6 col-md-4" >   <label class="checkbox-inline">
            <input type="checkbox" name="status-filter[]" value="4">Manipulé
            </label></div>
        </div>
        
    <?php
      
      if(isset($userId) and $userId!=''){?>
      <div class="col-xs-12 col-md-12 col-sm-6 col-lg-12">
      <label id="lblMy" >Afficher mon nid:</label>
     
       <input type="checkbox"name="mynest"  id="mynest" />
       
      </div> 
      
      <?php } ?>
    <div class="clearfix">&nbsp;</div>
    
    <div class="form-group">
      
      
       <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6" >
          <label >Dater de:</label>
         
           <input type="date" class="form-control jquery-datepicker__input filter-date-class " value="" <?=$styleMac?>  placeholder=" " name="date_from" id="date_from"/>  &nbsp;
       
        </div>
      
         <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6">
      <label >Date à:</label>
     
       <input type="date" value=""  <?=$styleMac?> placeholder=" " class="form-control jquery-datepicker__input filter-date-class "  name="date_to"  id="date_to" />
       
      </div> 
      
    </div>
    <div class="clearfix">&nbsp;</div>
  
<script type='text/javascript' src='https://maps.googleapis.com/maps/api/js?key=AIzaSyAaqEI1hEro18UDNXVHKnQ5dc6A_vF-crY'></script>

  
  <script type="text/javascript">
 	 $('#date_from').val("");
	 $('#date_to').val("");
  </script>
    
    <div class="clearfix">&nbsp;</div>
     <div class="col-xs-12">   <input type="submit" name="sbmitbtn" id="sbmitbtnid" style="background-color: rgb(252, 227, 3);border: none;color:#000" value="Search" class="btn btn-default btn-info"></div>&nbsp;  </form>     </div>
    <div style="display:none" class="col-md-4 col-xs-11 English searcform searcformEng" >
      <a class="btnClose"  href="javascript:void(0)"><i class="glyphicon glyphicon-remove"></i></a>
    <div class="col-xs-7">
      <h3>Where is the Nest ?</h3>
      </div>
        <form id="formsbmittt"  action="" method="GET">
        <span id='proceeee'></span>
         
    <div class="col-xs-8 col-sm-8 col-lg-8  col-md-8">
      <label for="email">Address :</label> 
     <?php 	 $localAddress='';	 if(isset($address) and $address!=''){		 $localAddress=$address;	 }	 if(isset( $_GET['filtertext'])) {	$localAddress=	 $_GET['filtertext'];	 }	 		 ?>
       <input type="text" class="form-control" name="filtertext" id="filtertext" value="<?=$localAddress;?>"  placeholder="Enter address to search"/>
    </div>
   
    <div class="col-xs-4 col-sm-4 col-lg-4  col-md-4">
     
      <label>Radius in KM:</label>
        <input name="radisfilter" class="form-control" value="100" type="number"/> 
   
	</div>
	  <input name="userId" type="hidden" value="<?=$userId?>" /> 
   
    <div class="clearfix">&nbsp;</div>
    <div class="col-xs-12" > <label for="sel1">Nest Types:</label></div>
    <div class="checkbox mrfn">
    
           <div class="col-xs-6 col-md-6" > <label class="checkbox-inline">
            <input type="checkbox" class="typeAll" name="type-filter[]" value="1">Asian Hornet
            </label></div>
         <div class="col-xs-6 col-md-6" >   <label class="checkbox-inline">
            <input type="checkbox" class="typeAll" name="type-filter[]" value="2">European Hornet
            </label></div>
        <div class="col-xs-6 col-md-6" >    <label class="checkbox-inline">
            <input type="checkbox" class="typeAll" name="type-filter[]" value="3">Wasp
            </label></div>
        <div class="col-xs-6 col-md-6" >    <label class="checkbox-inline">
            <input type="checkbox" id="typeAll"  >All
            </label></div>
        </div>
    <div class="clearfix">&nbsp;</div>
       <div class="col-xs-12" >  <label for="sel1">State:</label></div>
         <div class="checkbox mrfn">
           
       <div class="col-xs-6 col-md-4" >   <label class="checkbox-inline">
            <input type="checkbox" name="status-filter[]" value="1">Active
            </label></div>
       <div class="col-xs-6 col-md-4" >     <label class="checkbox-inline">
            <input type="checkbox" name="status-filter[]" value="2">In active
            </label></div>
       <div class="col-xs-6 col-md-4" >     <label class="checkbox-inline">
            <input type="checkbox" name="status-filter[]" value="3">Treated
            </label></div>
         <div class="col-xs-6 col-md-4" >   <label class="checkbox-inline">
            <input type="checkbox" name="status-filter[]" value="4">Handled
            </label></div>
        </div>
        
    <?php
      
      if(isset($userId) and $userId!=''){?>
      <div class="col-xs-12 col-md-12 col-sm-6 col-lg-12">
      <label id="lblMy" >Show My Nest:</label>
     
       <input type="checkbox"name="mynest"  id="mynest" />
       
      </div> 
      
      <?php } ?>
    <div class="clearfix">&nbsp;</div>
    
    <div class="form-group">
      
      
       <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6" >
          <label >Date From:</label>
         
           <input type="date" class="form-control jquery-datepicker__input filter-date-class " value="" <?=$styleMac?>  placeholder=" " name="date_from" id="date_from"/>  &nbsp;
       
        </div>
      
         <div class="col-xs-6 col-md-6 col-sm-6 col-lg-6">
      <label >Date To:</label>
     
       <input type="date" value=""  <?=$styleMac?> placeholder=" " class="form-control jquery-datepicker__input filter-date-class "  name="date_to"  id="date_to" />
       
      </div> 
      
    </div>
    <div class="clearfix">&nbsp;</div>
  
<script type='text/javascript' src='https://maps.googleapis.com/maps/api/js?key=AIzaSyAaqEI1hEro18UDNXVHKnQ5dc6A_vF-crY'></script>

  
  <script type="text/javascript">
 	 $('#date_from').val("");
	 $('#date_to').val("");
  </script>
    
    <div class="clearfix">&nbsp;</div>
     <div class="col-xs-12">   <input type="submit" name="sbmitbtn" id="sbmitbtnid" style="background-color: rgb(252, 227, 3);border: none;color:#000" value="Search" class="btn btn-default btn-info"></div>&nbsp;  </form>     </div>
	 
	 <?php	 if(count($result->result()) > 0 )	 {
		$acontent = array (); 
		foreach ($result->result() as $row) 
		 {
		    $acontentHTML[] = 	$row->address;
			 $auserIds[] = 	$row->userId;
			 $nestIds[] = 	$row->id;
			$alat[] = 	$row->latitude;
			$aimage[] = 	$row->image;
			$alon[] = 	$row->longitude;
			$anest_type[] = 	$row->nest_type;
			$astatus[] = 	$row->status;
			$adiameter[] = 	$row->diameter;
			$aHeight[] = 	$row->hight_in_meters;
			$aname[] = 	$row->name;
			$adescription[] = 	$row->description;
			$adedDate[] = 	$row->added_date;
			$aStrfiles[] = 	$row->files;
			
			
		 }   
	 };
	 
	
	
	?>
     

<script type="text/javascript">
function formsbmit(id)
{
 
document.getElementById(id).submit();
}
        var markers = [];

	    function loadMap() {
			
			 var infoWindowContent = [
							
						<?php
						$totalWindow=0;
						if(count($acontentHTML) > 0)
						{
						    $totalWindow=count($acontentHTML);
						for($index = 0 ; $index < count($acontentHTML) ; $index ++)
						{
							//$image =   base_url().'uploads/'.$aimage[$index];
							$btnEdit='';
							$btnDel='';
							if(isset($pro) and $pro==0 and $pro!=null){
								$btnEdit='<a onClick="editItem(\''.$nestIds[$index].'\')" class="pull-right btn btn-info btn-xs" href="javascript:void(0)"><i class="glyphicon glyphicon-pencil"></a>';
								$btnDel='<a onClick="deleteItem(\''.$nestIds[$index].'\')" class="pull-right btn btn-danger btn-xs" href="javascript:void(0)"><i class="glyphicon glyphicon-trash"></a>';
								}
								else if($auserIds[$index]==$userId){
								$btnEdit='<a onClick="editItem(\''.$nestIds[$index].'\')" class="pull-right btn btn-info btn-xs" href="javascript:void(0)"><i class="glyphicon glyphicon-pencil"></a>';
								$btnDel='<a onClick="deleteItem(\''.$nestIds[$index].'\')" class="pull-right btn btn-danger btn-xs" href="javascript:void(0)"><i class="glyphicon glyphicon-trash"></a>';
								}
							if($anest_type[$index]=='1')
							{
							 $nexttypename = 'Asian Hornet';	
							}
							else
							if($anest_type[$index]=='2')
							{
								$nexttypename = 'Eurpion Hornet';	  
							}
							else
							if($anest_type[$index]=='3')
							{
								$nexttypename = 'WASP';	  
							}
							else
							if($anest_type[$index]=='4')
							{
								$nexttypename = 'Other';	  
							}
							
							
							if($astatus[$index]=='1')
							{
							 $statusename = 'Active';	
							}
							else
							if($astatus[$index]=='2')
							{
								$statusename = 'In-Active';	
							}
							else
							if($astatus[$index]=='3')
							{
								$statusename = 'Handled';	
							}
							else
							if($astatus[$index]=='4')
							{
								$statusename = 'Treated';	
							}
							
							if(!empty($aStrfiles))
						    {
							   $imagestr='';
							   $videosstr='';
							   $astrfiles = explode(',',$aStrfiles[$index]);
							   for($k =0 ; $k < count($astrfiles);$k++)
							   {
							       $displatImg='';
							       if($k==0){
							           $displatImg='style="display:block"';
							       }
									$astrfileskk = explode('|',$astrfiles[$k]);
									if($astrfileskk[1]==0)
									{
										$file=base_url().'uploads/'.$astrfileskk[0];
										if(file_exists(FCPATH.'uploads/'.$astrfileskk[0])){
										$imagestr.='<img  '.$displatImg.' src="'.$file.'"  onclick="myModal(\''.$file.'\')" class="mySlides" >'; 
										}
										
									} 
									else
									if($astrfileskk[1]==1)
									{
									  $videosstr.='<video id="my-video" controls preload="auto"   height="150px" style="width:100%;margin: 20px 0px 0px 0px;"   data-setup="{}"> <source src="'.base_url().'uploads/'.$astrfileskk[0].'" type="video/mp4"></video>';
									}
								  
								}
							}
							?>  
							[`'<div class="info_content"><div class="w3-content w3-display-container"><?php 
							
							echo $imagestr;?>
<button class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094;</button><button class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">&#10095;</button></div></br><?php echo $videosstr;?><?php echo '<table class="table table-striped"><tr><th> Date:</th><td>'.$adedDate[$index];?><?php echo '</td></tr><tr><th>Name:</th><td> '.$aname[$index];?><?php echo '</td></tr><tr><th>Address: </th><td>'. $acontentHTML[$index];?><?php echo '</td></tr><tr><th>Nest Type: </th><td>'.$nexttypename;?><?php echo '</td></tr><tr><th>Status:</th><td>'.$statusename;?><?php echo $btnEdit.'</td></tr><tr><th>Diameter:</th><td>'.$adiameter[$index];?><?php echo  '</td></tr><tr><th>Height (m):</th><td>'.$aHeight[$index];?><?php echo $btnDel. '</td></tr><tr><th>Description:</th><td> '.$adescription[$index].'</td></tr><table>';?>
<?php
$next=$index+1;
$prev=$index-1;
 $changeClassNext='';
if($totalWindow==$next){
    $changeClassNext='lastNext';
}
$changeClassPrev='';
if($prev==-1){
    $changeClassPrev='lastPrev';
}
echo '<a href="javascript:void(0)" onClick="triggerClick('.$prev .')" class="btn btn-default btnNexpre pull-left  '.$changeClassPrev.'">Prev</a>';
echo '<a href="javascript:void(0)" onClick="triggerClick('.$next .')" class="btn btn-default btnNexpre pull-right '.$changeClassNext.'">Next</a>';?>
'`],
						<?php
						}
						}
						else
						{
						?>

					  <?php 
					  }
					  ?>		
                       ];
                       var customzoom=3;
			var radiusStroke='<?=$radisfilter?>';
            if(radiusStroke=='' ){
                radiusStroke=100;
            }
            if(radiusStroke>4000 ){
                customzoom=2;
               
            }
			var mapOptions = {
			    gestureHandling: "greedy",
			    mapTypeControl: false,
                zoom: customzoom,
                center: new google.maps.LatLng(<?=$latitude?>, <?=$longitude?>),
                   mapTypeId: 'roadmap'
            }
            var map = new google.maps.Map(document.getElementById("googlemap"), mapOptions);
            if(radiusStroke<4000 ){
            var antennasCircle = new google.maps.Circle({
      strokeColor: "#FF0000",
      strokeOpacity: 0.8,
      strokeWeight: 2,
      fillColor: "#FF0000",
      fillOpacity: 0.35,
     
      map: map,
      center: {
        lat: <?=$latitude?>,
        lng: <?=$longitude?>
      },
      radius: 1000 * radiusStroke
    });
    map.fitBounds(antennasCircle.getBounds());
    
            }
           var locations = [
						  <?php
						 
						if(count($alat) > 0)
						{ 
						   for($key = 0 ; $key < count($alat); $key ++)
						   {
						  ?>  
						
						   [infoWindowContent[<?php echo $key;?>][0], <?php echo $alat[$key];?>, <?php echo $alon[$key];?>],
						 <?php
						 }
						}else
						{
						 ?>
						<!-- [infoWindowContent[<?php //echo $key;?>][0], <?php //echo '48.856613';?>, <?php // '2.352222';?>],-->
						<?php 
						}
						?>
					];
                    
				
				
            var marker, i;
            var infowindow = new google.maps.InfoWindow();
    
    infowindow.setZIndex(1111111111);
                        
            google.maps.event.addListener(map, 'click', function() {
                infowindow.close();
            });
    
            // create markers
            for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map,
                    
                    icon: locations[i][3]
                });
    
                google.maps.event.addListener(marker, 'click', (function(marker, i) {  
                  
                    return function() {
                        infowindow.setContent(locations[i][0]);
                        infowindow.setZIndex(1111111111);
                        infowindow.open(map, marker);
                        
                    }
                    
                    
                })(marker, i));
        
                markers.push(marker);
                
                 
            }
            
		}
        google.maps.event.addDomListener(window, 'load', loadMap);
        function NextPrev(id){
            
        }
        
        function get(id){
            google.maps.event.trigger(markers[id], 'click');
			//$(".fancybox").fancybox();
			var slideIndex = 1;
showDivs(slideIndex);
					
        }
		
	 
		function initAutocomplete() {
			var fillInAddress;
        // Create the autocomplete object, restricting the search to geographical
        // location types.
         autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('filtertext')),
            {types: ['geocode']});
		  autocomplete.addListener('place_changed', fillInAddress);
      }
	  
	     
	  $("#resetbtnid").click(function (){
		
		$("option:selected").prop("selected", false);
		$('input[type="checkbox"]').prop('checked', false);
		$('input[type="radio"]').prop('checked', false);
		$('input[type="text"]').val('');
    })
	  
</script>


 


   <div id="googlemap" style="width: 100%; height: 700px;"></div>
<script type="text/javascript">
 $(document).ready(function(e) {
     //////////////
     
     /////////////
   
	$(".sbitbtnEng").click(function(){
		
		$(".searcformEng").toggle();
	});
	$(".sbitbtnFr").click(function(){
		
		$(".searcformFr").toggle();
	});
	
		$(".btnClose").click(function(){
		
		$(".searcform").hide();
	});
	
});



</script>

</body>
</html>
    <script type="text/javascript"> 
	  $('#typeAll').click(function(event) {
			         if(this.checked) {
						         $('.typeAll').each(function() {
									             this.checked = true;
						});  
						}
						 else { 
						        $('.typeAll').each(function() {   
								         this.checked = false;   
						});
						    }});	 
							 	      


var options = {
  enableHighAccuracy: true,
  timeout: 15000,
  maximumAge: 0
};

$(document).ready(function(){
 
    if(navigator.geolocation){
		
        navigator.geolocation.getCurrentPosition(showLocation,error, options);
    }else{ 
        $('#location').html('Geolocation is not supported by this browser.');
    }
    
    setTimeout(function(){
                        $(".fancybox").fancybox();
                    },2000);
});



function showLocation(position){
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;
//	alert(latitude);

    $.ajax({
        type:'POST',
        url:'http://geonest.org/map/geolocation',
        data:'latitude='+latitude+'&longitude='+longitude,
        success:function(msg){
            if(msg){
               $("#location").html(msg);
            }else{
                $("#location").html('Not Available');
            }
        }
    });
}


function success(pos) {
  var crd = pos.coords;
//alert('success');
  console.log('Your current position is:');
  console.log(`Latitude : ${crd.latitude}`);
  console.log(`Longitude: ${crd.longitude}`);
  console.log(`More or less ${crd.accuracy} meters.`);
}

function error(err) {
	//alert('error in location');
  console.warn(`ERROR(${err.code}): ${err.message}`);
}

$(document).ready(function() {
//alert('location required');

gbGetLocation();

});

function getLocationOnClick(){
   
    gbGetLocation();
}

function gbDidSuccessGetLocation ( lat, lng){
//    alert('lat is '+lat);
 var latlng = new google.maps.LatLng(lat, lng);
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
				//	alert(status);
				//	alert("ok");
                    if (results[1]) {
                     //   alert("Location: " + results[1].formatted_address);
					 $("#address").val(results[1].formatted_address);
				//	 alert(results[1].formatted_address);
                    }
                }
            });


}
function gbDidFailGetLocation ( errorMessage ){
//alert(errorMessage);
}
      
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
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length} ;
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  x[slideIndex-1].style.display = "block";
  
}


function triggerClick(i) {
  google.maps.event.trigger(markers[i], 'click');
  //map.getBounds();	
}
	////////////////////////////////
function myModal(src){
    $("#myModal").modal('show');
    $("#currentImage").attr("src", src);
}	

function hideback(){
    $(".modal-backdrop").hide();
}function hidemodal(){
    $("#myModal").modal('hide');
     $(".modal-backdrop").hide();
}

function deleteItem(){
	
		$.ajax({
				url: "https://geonest.org/map/deleteItem",
				type: 'POST',
				data: {id:id},
				dataType: "json",
				success: function(response) {
					$("Deleted successfully!");
					}
				});
	}
	function delImage(id){
	//alert(id);
	if (confirm("Are you sure to delete!")) {
		$.ajax({
				url: "https://geonest.org/map/delImage",
				type: 'POST',
				data: {id:id},
				dataType: "json",
				success: function(response) {
				$("#imageDiv"+id).remove();
					}
				});
	}
	}
	
	function editItem(id){ 	// will get single entitty	and show its image in modal
		    $.ajax({
			url: "https://geonest.org/map/editnest",
			type: 'POST',
			data: {id:id},
			dataType: "json",
			beforeSend: function() {
				$('#loader').removeClass('hidden');
		   },
			success: function(response) {
			if (response.status == 1)
            {
				$("#editModal").modal("show");
				$("#editBody").html(response.html);
					
			}
			else  
			{   
			}
			}
		});
}




 /***********************/
	   function editFormSave()
	{   
	     $("#pro").show();
			//e.preventDefault();	
			var formData = new FormData();
			var other_data = $('#formEit').serializeArray();
				$.each(other_data,function(key,input)
				{
					formData.append(input.name,input.value);
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
			url: "https://geonest.org/map/maplocationsave",
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			dataType: 'JSON',
			beforeSend: function() {
			$('#loader').removeClass('hidden');
		  //	$('#form_skill_squared_kjnsdjnhsdjs87sd8s7d8s7d .btn_au').addClass('hidden');
			},
			success: function(data) {
			    //alert(data);
				if(data){
				    $('#loader').addClass('hidden');
				    $('#editModal').modal('hide');
				    location.reload();
				}
           }
	 });

	//ajax end    
    }
	  
/*******************/
</script>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:90%">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" onclick="hideback();" id="btnClosePopup" class="close" data-dismiss="modal">&times;</button>
        
      </div>
      <div class="modal-body">
        <img id="currentImage" onclick="hidemodal()" src="" style="width:100%" >
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="hideback();"  data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<div id="editModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:90%">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" onclick="hideback();" id="btnClosePopup" class="close" data-dismiss="modal">&times;</button>
        <div class="alert hidden"></div>
        
      </div>
      <div class="modal-body" id="editBody">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onclick="hideback();"  data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


