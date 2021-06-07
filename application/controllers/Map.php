<?php defined('BASEPATH') or exit('No direct script access allowed');
class Map extends CI_Controller
{
	public $tbl_loc = "tbl_loc";
	public $tbl_prototypeform = 'prototypeform';
	function __construct()
	{
		parent::__construct();
		header('Access-Control-Allow-Origin: *');
		if ($this->session->userdata('login') != true) {

			redirect('user/login', 'refresh');
		}
		//header('Content-type: application/json');

		$this->load->library('pagination');

		error_reporting(1);

		$this->load->model('Cruds');
	}

	public function reject_user_type($user_id, $previous_utype, $want_utype)
	{
		$update = $this->db->where(array('id' => $user_id))->update('users', array('user_type' => $previous_utype));


		if ($update) {
			$result = $this->db->get_where('users', array('id' => $user_id))->result_array()[0];
			$to = $result['email'];
			$headers = "From:" . APP_EMAIL;
			$subject = "FLB";
			$message = lang('rejected_request');
			mail($to, $subject, $message, $headers);
			$location = base_url() . 'dashboard';
			header("location:$location");
			// $this->load->view('dashboard');
		}
	}



	public function set_lang()
	{
		// $this->session->set_userdata('lang', $_POST['lang']);
		$_SESSION['lang'] = $_POST['lang'];
		// pre($_SESSION);
		// echo $_SESSION['lang'];
		// pre($_SESSION);
		// echo $this->session->userdata('lang');
		echo $_SESSION['lang'];
	}


	public function reference()
	{

		$this->load->view("reference");
	}

	public function setlatlon()

	{

		$ip = $this->getVisIpAddr(); // the IP address to query

		$query = @unserialize(file_get_contents('http://ip-api.com/php/' . $ip));

		if ($query && $query['status'] == 'success') {

			$this->session->set_userdata('latitude', $query['lat']);

			$this->session->set_userdata('longitude', $query['lon']);
		} else {

			//47.6376934

			$this->session->set_userdata('latitude', '47.6376934');

			$this->session->set_userdata('longitude', '-3.4629995');
		}
	}







	public function index()

	{


		$table = 'tbl_loc';

		$aData = array();



		// incase user not share his location get nearist location from ip

		if (!isset($_GET['latitude']) and $_GET['latitude'] == '' and !isset($_GET['longitude']) and $_GET['longitude'] == '') {

			$this->load->view('no_location');


			/*
			$this->setlatlon();



			$latitude = get_session('latitude');

			$longitude = get_session('longitude');
			*/
		} else {




			$latitude = $_SESSION['latitude'] = $_GET['latitude'];

			$longitude = $_SESSION['longitude'] = $_GET['longitude'];
		}

		if ($latitude != '' and $longitude != '') {




			$sql = "SELECT *,(SELECT GROUP_CONCAT(tbl_map_images.file,'|',tbl_map_images.type) FROM tbl_map_images WHERE tbl_loc.id= tbl_map_images.map_id ) AS files,

			 tbl_loc.lat as latitude,tbl_loc.lon as longitude,( 6371 * 

			acos( 

			cos( radians( " . $latitude . " ) ) * 

			cos( radians( lat ) ) * 

			cos( radians( lon ) - 

			radians( " . $longitude . " ) ) + 

				sin( radians( " . $latitude . " ) ) * 

				sin( radians( lat ) ) ) ) 

				AS `radius` FROM tbl_loc  

				HAVING radius <= 100 ORDER BY radius ASC ";





			$aData['latitude'] = $latitude;

			$aData['longitude'] = $longitude;

			$aData['address'] = $this->getAddressFromGoogle($latitude, $longitude);
			$object  = $this->db->query($sql);


			$aData['result'] = $object;

			$aData['latitude'] = $latitude;

			$aData['longitude'] = $longitude;

			$aData['page_title'] = "Map page";
			$aData['usersDatalist'] = $this->db->select('id,name')->where('user_type!=', 1)->get('users');

			$this->load->view('map', $aData);
		}
	}


	public function check_nest()
	{
		extract($_POST);


		$table = 'tbl_loc';

		$aData = array();


		$sql = "SELECT *,(SELECT GROUP_CONCAT(tbl_map_images.file,'|',tbl_map_images.type) FROM tbl_map_images WHERE tbl_loc.id= tbl_map_images.map_id ) AS files,

			 tbl_loc.lat as latitude,tbl_loc.lon as longitude,( 6371 * 

    acos( 

    cos( radians( " . $lat . " ) ) * 

      cos( radians( lat ) ) * 

      cos( radians( lon ) - 

      radians( " . $long . " ) ) + 

        sin( radians( " . $lat . " ) ) * 

          sin( radians( lat ) ) ) ) 

           AS `radius` FROM tbl_loc  

					 HAVING radius <= " . $radius . " ORDER BY radius ASC ";







		$aData['address'] = $this->getAddressFromGoogle($lat, $long);


		$object  = $this->db->query($sql);


		$aData['result'] = $object;

		$aData['latitude'] = $lat;

		$aData['longitude'] = $long;

		$aData['page_title'] = "Map page";
		$aData['usersDatalist'] = $this->db->select('id,name')->where('user_type!=', 1)->get('users');

		if ($object->num_rows() > 0) {
			echo json_encode(array('status' => 200));
		} else {
			echo json_encode(array('status' => 100));
		}
		// $this->load->view('map', $aData);
	}



	public function contactpro()
	{


		$radius = 20;
		$aData['page_title'] = "Contact with pro users";

		$aData = array();

		$latitude = $_GET['latitude'];

		$longitude = $_GET['longitude'];
		if (isset($_GET['radius']) and $_GET['radius'] != '') {

			$radius = $_GET['radius'];
		}

		if ($latitude != '' and $longitude != '') {



			$sql = "SELECT * , 6371 * 

    acos( 

    cos( radians( " . $latitude . " ) ) * 

      cos( radians( latitude ) ) * 

      cos( radians( longitude ) - 

      radians( " . $longitude . " ) ) + 

        sin( radians( " . $latitude . " ) ) * 

          sin( radians( latitude ) ) ) 

           AS `radius` FROM users  where user_type=3

					  HAVING radius <= " . $radius . " ORDER BY radius ASC ";

			$aData['latitude'] = $latitude;

			$aData['longitude'] = $longitude;
		}

		//	echo $sql;
		/**
		Référent = 3
		Particulier =4
		Institution =5
		 */

		$object  = $this->db->query($sql);

		$aData['data'] = $object;

		$this->load->view('contactpro', $aData);
	}

	public function delImage()

	{

		extract($_POST);

		$result = $this->crud->delete($id, 'tbl_map_images');

		switch ($result) {

			case 1:

				$arr = array('status' => 1, 'message' => lang('succeess'));

				echo json_encode($arr);

				break;

			case 0:

				$arr = array('status' => 0, 'message' => "Not Deleted!");

				echo json_encode($arr);

				break;

			default:

				$arr = array('status' => 0, 'message' => "Not Deleted!");

				echo json_encode($arr);

				break;
		}
	}

	public function deleteItem()

	{

		extract($_POST);

		$result = $this->crud->delete($id, $this->tbl_loc);

		switch ($result) {

			case 1:

				$arr = array('status' => 1, 'message' => "Deleted Succefully !");

				echo json_encode($arr);

				break;

			case 0:

				$arr = array('status' => 0, 'message' => "Not Deleted!");

				echo json_encode($arr);

				break;

			default:

				$arr = array('status' => 0, 'message' => "Not Deleted!");

				echo json_encode($arr);

				break;
		}
	}
	public function deleteFollow()

	{

		extract($_POST);

		$result = $this->crud->delete($id, 'tbl_follow');

		switch ($result) {

			case 1:

				$arr = array('status' => 1, 'message' => "Deleted Succefully !");

				echo json_encode($arr);

				break;

			case 0:

				$arr = array('status' => 0, 'message' => "Not Deleted!");

				echo json_encode($arr);

				break;

			default:

				$arr = array('status' => 0, 'message' => "Not Deleted!");

				echo json_encode($arr);

				break;
		}
	}



	public function delPrototype()

	{

		extract($_POST);

		$data = $this->db->select('*')->from($this->tbl_prototypeform)->where('id', $id)->get();

		if ($data->num_rows() > 0) {

			$result = $this->crud->delete($id, $this->tbl_prototypeform);
		} else {

			$arr = array('status' => 0, 'message' => "This form was empty and not saved at once. You have to save it otherwise no need to delete.");

			echo json_encode($arr);

			exit;
		}

		switch ($result) {

			case 1:

				$arr = array('status' => 1, 'message' => "Deleted Succefully id was " . $id);

				echo json_encode($arr);

				break;

			case 0:

				$arr = array('status' => 0, 'message' => "Not Deleted!");

				echo json_encode($arr);

				break;

			default:

				$arr = array('status' => 0, 'message' => "Not Deleted!");

				echo json_encode($arr);

				break;
		}
	}



	// 



	// ***********haris select edit_complete_form

	public function edit_complete_form($id)

	{

		//      pending1

		$response = array();



		$response['data'] = $this->Cruds->edit_c_form($id);





		$u_type = $response['data'][0]->result()[0]->report_type;

		if ($u_type == 0) {

			$this->load->view('complete_edit', $response);
		} else {

			$this->load->view('simple_edit', $response);
		}
	}

	public function follow_controller($nest_id)
	{

		$nest_array = array('nest_id' => $nest_id);
		$this->load->view('follow', $nest_array);
	}



	public function follow_form_insert()
	{

		extract($_POST);
		$_POST['user_id'] = get_session('user_id');
		$_POST['weather_situation'] = implode(',', $_POST['weather_situation']);
		if (isset($_POST['follow_id']) and $_POST['follow_id'] > 0) {
			$id = $_POST['follow_id'];
			unset($_POST['follow_id'], $_POST['nest_id']);
			$response = $this->Cruds->update_follow_data($id, $_POST);
		} else {
			$response = $this->Cruds->insert_follow_data("tbl_follow", $_POST);
			if ($response) {

				if (!empty($_FILES)) {
					$follow_id = $this->db->insert_id();
					$nameArray = $this->crud->upload_files($_FILES);
					$nameData = explode(',', $nameArray);
					foreach ($nameData as $file) {
						$file_data = array(
							'file' => $file,
							'follow_id' => $follow_id
						);
						$this->db->insert('tbl_follow_images', $file_data);
					}
				}
			}
		}

		echo $response;
	}



	public function editFollow($id)
	{

		$query = $this->crud->edit($id, 'tbl_follow');

		$aData['row'] = $query;
		$aData['follow_id'] = $id;
		$aData['nest_id'] = $query->nest_id;

		$this->load->view('follow', $aData);
	}



	public function editnest()

	{









		$query = $this->crud->edit($id, $this->tbl_loc);



		$html = $this->setEdithtm($query);

		$arr = array('status' => 1, 'html' => $html);

		echo json_encode($arr);
	}



	public function prototypeupdate()

	{

		extract($_POST);

		$primaryId = $_POST['id'];



		$linkedFormData = array(

			'nest_id' => $nest_id,

			'prototypeType' => $prototypeType,

			'perforated' => $perforated,

			'heatingTime' => $heatingTime,

			'conditions' => implode(',', $condition),

			'schedule' => $schedule,

			'exitInsect' => $exitInsect,

			'ifAttacked' => $ifAttacked,

			'choicesOnGround' => implode(',', $choicesOnGround),

			'whenActive' => implode(',', $whenActive),

			'remarks' => $remarks

		);

		$result =	   $this->crud->saveRecord($primaryId, $linkedFormData, $this->tbl_prototypeform);



		switch ($result) {

			case 1:

				$arr = array('status' => 1, 'message' => lang('success'));

				echo json_encode($arr);

				break;

			case 2:

				$arr = array('status' => 1, 'message' => lang('success'));

				echo json_encode($arr);

				break;

			case 0:

				$arr = array('status' => 0, 'message' => "Not Deleted!");

				echo json_encode($arr);

				break;

			default:

				$arr = array('status' => 0, 'message' => "Not Deleted!");

				echo json_encode($arr);

				break;
		}
	}



	public function viewProtoItem()

	{

		extract($_POST);

		$html = '<h2>No Data Found!</h2>';

		$nest_id = $id;

		$query = $this->db->where('nest_id', $id)->get($this->tbl_prototypeform);

		$Moinsde20cmChecked = '';

		$Entre20et30cmChecked = '';

		$Entre30et50cmChecked = '';

		$Entre30et50cmChecked = '';

		$Entre30et50cmChecked = '';

		$heatingTime10 = '';

		$heatingTime30 = '';

		$conditions = '';

		$Pluie = '';

		$Vent = '';

		$Soleil = '';

		$Larves = '';

		$Frelonsadultes = '';

		$Rien = '';

		$whenActiveLarves = '';

		$whenActiveLarvesApres = '';

		$whenActiveToujours = '';

		$exitInsectNon = '';

		$exitInsectPeu = '';

		$exitInsectBeaucoup = '';

		$ifAttackedNon = '';

		$ifAttackedOui = '';

		$vapeurChecked = '';

		$airChecked = '';

		$remarks = '';

		$schedule = '';



		if ($query->num_rows() > 0) {

			$row = $query->row();



			$schedule = $row->schedule;

			$remarks = $row->remarks;

			if ($row->prototypeType == 'vapeur') {

				$vapeurChecked = 'checked';
			}

			if ($row->prototypeType == 'air') {

				$airChecked = 'checked';
			}

			/**********************/



			if ($row->perforated == 'Moins de 20 cm') {

				$Moinsde20cmChecked = 'checked';

				//Moins de 20 cm

			}



			if ($row->perforated == 'Entre 20 et 30 cm') {

				$Entre20et30cmChecked = 'checked';

				//Entre 20 et 30 cm

			}



			if ($row->perforated == 'Entre 30 et 50 cm') {

				$Entre30et50cmChecked = 'checked';
			}

			/***********************/







			if ($row->heatingTime == '10 min env') {

				$heatingTime10 = 'checked';
			}

			$heatingTime20 = '';

			if ($row->heatingTime == '20 min env') {

				$heatingTime20 = 'checked';
			}



			if ($row->heatingTime == '30 min ou plus') {

				$heatingTime30 = 'checked';
			}

			/***********************/



			if ($row->conditions != '') {

				$condition = explode(',', $row->conditions);



				if (in_array("Pluie", $condition)) {

					$Pluie = 'checked';
				}

				if (in_array("Vent", $condition)) {

					$Vent = 'checked';
				}

				if (in_array("Soleil", $condition)) {

					$Soleil = 'checked';
				}
			}

			/***********************/





			if ($row->choicesOnGround != '') {

				$choicesOnGround = explode(',', $row->choicesOnGround);

				//	pre($choicesOnGround);

				$Larves = '';

				$Frelonsadultes = '';

				$Rien = '';

				if (in_array("Larves", $choicesOnGround)) {

					$Larves = 'checked="checked"';
				}

				if (in_array("Frelons adultes", $choicesOnGround)) {

					$Frelonsadultes = 'checked="checked';
				}

				if (in_array("Rien", $choicesOnGround)) {

					$Rien = 'checked="checked';
				}
			}

			/***********************/





			if ($row->whenActive != '') {

				$whenActive = explode(',', $row->whenActive);



				if (in_array("Larves", $whenActive)) {

					$whenActiveLarves = 'checked';
				}

				if (in_array("Après 10 jours", $whenActive)) {

					$whenActiveLarvesApres = 'checked';
				}

				if (in_array("Toujours actif après 15 jours", $whenActive)) {

					$whenActiveToujours = 'checked';
				}
			}



			/**********************/



			if ($row->exitInsect == 'Non') {

				$Moinsde20cmChecked = 'checked';
			}

			if ($row->exitInsect == 'Peu') {

				$exitInsectPeu = 'checked';
			}

			if ($row->exitInsect == 'Beaucoup') {

				$exitInsectBeaucoup = 'checked';
			}

			/************************************/





			if ($row->ifAttacked == 'Non') {

				$ifAttackedNon = 'checked';
			}

			if ($row->ifAttacked == 'Oui') {

				$ifAttackedOui = 'checked';
			}



			/************************************/
		}

		$html = '<div id="protoTypeForm" >

		<form  class="target" id="protoTypeFormpost" name="protoTypeForm" role="form">

              <div class="col-md-6 col-xs-12">

              <p><b> Type de prototype * </b></p>

              <p> Indiquer quel type de prototype vous avez utilisé</p>

              <div class="col-md-6 col-xs-12"><p>

			  <input type="hidden" name="id" value="' . $row->id . '">

              <input type="hidden" name="nest_id" value="' . $nest_id . '">

                <label><input type="radio" name="prototypeType" ' . $vapeurChecked . ' value="vapeur"><span> vapeur </span></label></p>

                </div>

               <div class="col-md-6 col-xs-12"><p>

                <label><input type="radio" name="prototypeType" ' . $airChecked . ' value="air"><span> Air </span></label></p>

                </div>

				</div>

            <!---------------------------->

                <div class="col-md-6 col-xs-12">

             <p>  Longueur canne perforée (en cm) * </p>

             <label><input type="radio"  name="perforated" ' . $Moinsde20cmChecked . ' value="Moins de 20 cm"><span> Moins de 20 cm </span></label>

             <label><input type="radio" name="perforated" ' . $Entre20et30cmChecked . ' value="Entre 20 et 30 cm"><span> Entre 20 et 30 cm </span></label>

            <label>

                  	  <input type="radio" name="perforated" ' . $Entre30et50cmChecked . ' value="Entre 30 et 50 cm"><span>Entre 30 et 50 cm</span>

                    </label>

           	</div>

            <!---------------------------->

			<div class="clearfix">&nbsp;</div>

                <div class="col-md-6 col-xs-12">

             <p>  <b> Temps de chauffe de nid  * </b></p>

             <p>   Indiquer combien de temps cela vous a pris pour chauffer le nid </p>

             <label><input type="radio" name="heatingTime" ' . $heatingTime10 . ' value="10 min env"><span> 10 min env </span></label>

                <label><input type="radio" name="heatingTime" ' . $heatingTime20 . ' value="20 min env"><span> 20 min env </span></label>

                    <label>

                  	  <input type="radio" name="heatingTime" ' . $heatingTime30 . ' value="30 min ou plus"><span>30 min ou plus</span>

                    </label>

                    

           	</div>

			

            <!---------------------------->

                <div class="col-md-6 col-xs-12">

             <p>  <b> Conditions  * </b></p>

             <p>   Indiquer si une ou plusieurs de ces conditions météorologiques étaient réunies lors de l\'intervention </p>

              <label><input type="checkbox" name="condition[]" ' . $Pluie . ' value="Pluie"><span> Pluie </span></label>

              <label><input type="checkbox" name="condition[]" ' . $Vent . '  value="Vent"><span> Vent </span></label>=

               <label><input type="checkbox" name="condition[]" ' . $Soleil . '  value="Soleil"><span> Soleil </span></label> 

              

              

           	</div>

            <!---------------------------->

			<div class="clearfix">&nbsp;</div>

            

                <div class="col-md-12 col-xs-12">

             <p>  <b> Horaire *  </b></p>

             <p>    Indiquer l\'horaire auquel vous avez effectué l\'intervention</p>

             <label><input type="time" name="schedule" value="' . $schedule . '" ></label></p>

               </div>

                 <div class="col-md-12 col-xs-12">

           <label style="color: rgb(50, 48, 84); font-family: Lato; font-weight: normal; font-style: normal; font-variant: normal; font-size: 22px; margin-bottom:10x">OBSERVATIONS APRÈS APPLICATION</label>

           </div>

            <!---------------------------->

            <div class="col-md-12 col-xs-12">

             <p><b>   Sortie des insectes * </b> </p>

             <p>   Indiquer dans quelle proportion les insectes sont sortis de leur nid  </p>

              

                <label><input type="radio" name="exitInsect" ' . $exitInsectNon . '  value="Non"><span>Non </span></label>

          

                <label><input type="radio" name="exitInsect" ' . $exitInsectPeu . '  value="Peu"><span>Peu</span></label>

               <label><input type="radio" name="exitInsect" ' . $exitInsectBeaucoup . ' value="Beaucoup"><span>Beaucoup</span></label>

             

              

           	</div>

            <!---------------------------->

            <div class="col-md-6 col-xs-12">

             <p><b>   Attaques *  </b> </p>

             <p>    Indiquer si les frelons asiatiques vous ont attaqué</p>

                <label><input type="radio" name="ifAttacked" ' . $ifAttackedNon . ' value="Non"><span>Non </span></label>

                <label><input type="radio" name="ifAttacked" ' . $ifAttackedOui . ' value="Oui"><span>Oui</span></label>

           	</div>

                        <!---------------------------->

                <div class="col-md-6 col-xs-12">

             <p>  <b>  Observations au sol  *  </b></p>

             <p>    Indiquer si vous trouvez ces choix au sol </p>

                <label><input type="checkbox" name="choicesOnGround[]" ' . $Larves . ' value="Larves"><span> Larves  </span></label>     <label><input type="checkbox" name="choicesOnGround[]" ' . $Frelonsadultes . ' value="Frelons adultes"><span> Frelons adultes </span></label><label><input type="checkbox" name="choicesOnGround[]" ' . $Rien . ' value="Rien"><span> Rien </span></label></p>

                

              

           	</div>

                        <!---------------------------->

						<div class="clearfix">&nbsp;</div>

            

                <div class="col-md-12 col-xs-12">

             <p>  <b>   Activité du nid  *   </b></p>

             <p>     Indiquer après combien de jours le nid est devenu inactif</span>

              <label><input type="checkbox" name="whenActive[]" ' . $whenActiveLarves . ' value="Larves"><span> Après 5 jours  </span></label>

            <label><input type="checkbox" name="whenActive[]" ' . $whenActiveLarvesApres . ' value="Après 10 jours"><span> Après 10 jours</span></label>

                <label><input type="checkbox" name="whenActive[]" ' . $whenActiveToujours . ' value="Toujours actif après 15 jours"><span> Toujours actif après 15 jours </span></label>

              

           	</div>



     <div class="col-md-12 col-xs-12">

      <p>  <b>   Remarques  *  </b></p>

            <div class="control">



        <div class="col-md-6 col-xs-12">

		<span class="lbl"> Indiquer des remarques supplémentaires relatives à l\'utilisation du prototype <sup> * </sup></span>

        



          <input id="remarks" value="' . $remarks . '" name="remarks" >

          

        </div>

      </div>

        </div>

		</form>

		<div class="clearfix">&nbsp;</div>

		<div class="clearfix">&nbsp;</div>

		

            </div>';



		$arr = array('status' => 1, 'html' => $html);

		echo json_encode($arr);
	}

	function setEdithtm($row)

	{

		$Asian = '';

		$European = '';

		$Wasp = '';

		$Other = '';

		if ($row->nest_type == 1) {

			$Asian = 'checked';
		} elseif ($row->nest_type == 2) {

			$European = 'checked';
		} elseif ($row->nest_type == 3) {

			$Wasp = 'checked';
		} elseif ($row->nest_type == 4) {

			$Other = 'checked';
		} else {

			// nothing

		}

		$Active = '';

		$InActive = '';

		$Handel = '';

		$Treated = '';

		if ($row->status == 1) {

			$Active = 'checked';
		} elseif ($row->status == 2) {

			$InActive = 'checked';
		} elseif ($row->status == 3) {

			$Handel = 'checked';
		} elseif ($row->status == 4) {

			$Treated = 'checked';
		} else {

			// nothing

		}







		$htmlEdit = '<div id="form_id_div" class="container">

<form   id="formEit" name="formEit" role="form">

 <div class="row">

 

        <div class="input-field col-md-12 col-xs-12">

        <span class="lbl">Entrer adresse</span>

          <input id="address" name="address" type="text" value="' . $row->address . '" class="form-control">

        </div>

     <input id="userFuckerName" name="name" value="' . $row->name . '" type="hidden">

      

      <div class="clearfix">&nbsp;</div>

       <div >

<div class=" col-md-12"><b>Types de nid</b></div>

        <div class="col-md-3 col-xs-6">

                <label>Asian Hornet</label>

                <input name="nest_type" type="radio" ' . $Asian . '   value="1" />

        </div>

         <div class="col-md-3 col-xs-6" style="padding: 0;">

         <label>Européenne Hornet</label>

                <input name="nest_type" type="radio" ' . $European . '   value="2" />

        </div>

         <div class="col-md-3 col-xs-6">

          <label>Guêpe</label>

                <input name="nest_type" type="radio" ' . $Wasp . '  value="3" />

                </div>

         <div class="col-md-3 col-xs-6">

         <label>Autre

                </label>

				<input name="nest_type" type="radio" ' . $Other . '  value="4" />

            

        </div>

       </div>

      

<div class="clearfix">&nbsp;</div>

     

     <div class="form-group">

    <div class="col-md-12"><b>State of the nest</b></div>

        <div class="col-md-3 col-xs-6">

                <label>

                Actif

                </label><input name="status" type="radio" ' . $Active . '  value="1" />

        </div>

          <div class="col-md-3 col-xs-6">

                <label>

             Inactif

                </label>

             <input name="status" type="radio" ' . $InActive . '  value="2" />

			 </div>

         <div class="col-md-3 col-xs-6">

          

                <label>

               Pris en Charge

                </label>

            <input name="status" type="radio" ' . $Handel . '   value="3" />

        </div>

         <div class="col-md-3 col-xs-6">

         

                <label>

                Traité

                </label>

            <input name="status" type="radio" ' . $Treated . '   value="4" />

                

        </div>

       </div>

       

       <div class="clearfix">&nbsp;</div>

      

      <div class="form-group">

	  <div class="col-md-4 col-xs-6 ">

		<span class="lbl">Support  <sup>*</sup></span>

          <input id="support" name="support" type="text" value="' . $row->support . '" required placeholder="Ex:tree/beam/etc" class="form-control">

          

        </div>

        <div class="col-md-4 col-xs-6">

		<span class="lbl">Diamètre  (cm)<sup>*</sup></span>

        

          <input id="diameter" name="diameter" value="' . $row->diameter . '" type="text" placeholder="Ex:30" required class="form-control">

          

        </div>

		<div class="col-md-4 col-xs-6">

		<span class="lbl">Hauteur  (m) <sup>*</sup></span>

          <input id="hight_in_meters" name="hight_in_meters" value="' . $row->hight_in_meters . '" placeholder="Ex: 10 " required type="text" class="form-control">

          

        </div>

      </div>

      <div class="clearfix">&nbsp;</div>

      

<div class="form-group">



        <div class="col-md-12 col-xs-12">

		<span class="lbl">Informations détaillées <sup>*</sup></span>

        

          <textarea id="description" name="description" required  class="form-control">' . $row->description . '</textarea>

          

        </div>

      </div>

<div class="clearfix">&nbsp;</div>

      

       <div class="col-md-12" style="width:100%; display:block">

        <div class="input-field">



         <input type="file" name="file[]" title=" " class="custom-file-input file"  id="file" accept=".png,.PNG,.JPG,.jpg,.jpeg,.JPEG,.gif,.mp4" multiple >

                     

        </div>

      </div><div class="clearfix">&nbsp;</div>



	  <div class="col-md-12">

	  ' . $this->getImagesWithHtml($row->id) . '

	  </div>

	  <div class="clearfix">&nbsp;</div>

         <div class="col-xs-12 col-md-3">

        <div class="input-field col s12">

        

          <input id="location_file" name="location_file" style="background-color: #FCE303;

    color: #000;

    width: 100%;"  type="button" onclick="editFormSave()" class="btn" value="Submit">

    <input type="hidden" name="primaryId" value="' . $row->id . '">

          <label for="location_file"></label> 

        </div>

      </div>

        

        

        

   

  </div>

   </form>      

</div>';

		return $htmlEdit;
	}















	function geolocation()

	{

		if (!empty($_POST['latitude']) && !empty($_POST['longitude'])) {

			//send request and receive json data by latitude and longitude

			$url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng=' . trim($_POST['latitude']) . ',' . trim($_POST['longitude']) . '&sensor=false';

			$json = @file_get_contents($url);

			$data = json_decode($json);

			$status = $data->status;



			//if request status is successful

			if ($status == "OK") {

				//get address from json data

				$location = $data->results[0]->formatted_address;
			} else {

				$location =  '';
			}



			//return address to ajax 

			echo $location;
		}
	}

	function exportCsv()

	{



		extract($_POST);



		//    pre($this->session);

		$arrIds = explode(',', $ids);

		$email = get_session('email');


		/*
		if (strpos($email, 'geonest.org') !== false) {

			$this->exportCsvFull($arrIds);

			exit;
		}
		

		if (get_session('proiam') == 1) {



			$this->exportCsvPro($arrIds);

			exit;
		}
*/




		$data = $this->db->where_in('id', $arrIds)->get('tbl_loc')->result_array();



		// 
		// lq();







		//pre($res);

		//echo 'L';exit;

		$fileName = count($arrIds) . 'nest-csv' . date('y-m-d H:i:s');

		header('Content-Type: application/csv; charset=UTF-8');



		header("Content-Disposition: attachment; filename=\"'" . $fileName . "'" . ".csv\"");



		$handle = fopen('php://output', 'w');



		fputcsv($handle, array("UniqueID", "Date", "Name", "Updated_at", "Next Obs.",  "X", "Y", "Address", "City", "Postal_code", "Country", "Site", "Support", "Heigh of Colony", "Colony Sate", "Activity", "Pollen", "Disapperead", "Occupied", "Detailed_information", "Link Pictures", "Height Tree", "Tree_alive", "Trunk_circumference", "Entrance_dimension", "Nest_entrance orientation",   "Entry_form", "Entrance_area", "Temperature", "Weather_situation", "Entre en Contact", "Regulars Flights ", "fight_with_workers",  "waste_wax"));
		fputcsv($handle, array("Identifiant unique", "Date",  "Nom", "Mise à jour", "Prochaine Obs.", "X", "Y", "Adresse", "Ville", "Code postal", "Pays", "Site", "Support", "Hauteur Colonie", "Etat de la Colonie", "Activité", "Pollen", "Disparu", "Occupé",  "Informations détaillées",  "Lien images", "Hauteur arbre", "Arbre vivant", "Circonférencedu tronc", "Dimension d'entrée", "Orientation entrée du nid", "Forme entrée", "Surface entrée", "Température", "Météo", "Mise en contact", "Vols réguliers", "Combat entre ouvrières",  "Déchets de cire"));

		$i = 0;

		foreach ($data as $key) {

			if ($key['findPro'] == 'on' and get_session('lang') == 'english') {
				$key['findPro'] = 'Yes';
			}
			if ($key['findPro'] == 'on' and get_session('lang') == 'french') {
				$key['findPro'] = 'Oui';
			}


			/*
			$etat_colonie = '';
			$disappeared = '';
			$occupied    =  '';
			$next_oservation_data = '';

			$follow_data = $this->db->get_where('tbl_follow', array('nest_id' => $key["id"]))->result_array();
			if (!empty($follow_data)) {
				$my_data = $follow_data[count($follow_data) - 1];
				$etat_colonie = $my_data['etat_de_la_colonie'];
				$disappeared = $my_data['disappeared'];
				$occupied    = $my_data['cavity_occupied'];
				$next_oservation_data = $my_data['date'];
			}
			*/
			$i++;








			if ($key["status"] == 1) {

				$key["status"] = 'Actif';
			} else if ($key["status"] == 2) {

				$key["status"] = 'Inactif';
			} else if ($key["status"] == 3) {

				$key["status"] = 'manipulé';
			} else if ($key["status"] == 4) {

				$key["status"] = 'traité';
			}
			if ($key['hide_location'] == "on") {

				if ($_SESSION['user_type'] == 3 || $_SESSION['user_type'] == 5 || $_SESSION['user_id'] == $key['user_id']) {

					$key['address'] = $key["address"];
				} else {
					$key['address'] = "*********";
				}
			}



			//

			$narray = array(

				/*

				old_code

				$key["uniqid"],

				$key["lat"],

				$key["lon"],

				date('d-m-Y', strtotime($key["added_date"])),

				$key["precision_pt"],

				$key["name"],

				$key["description"],



				$key["nest_type"],

				$key["modificationDate"],

				$key["proName"],

				$key["diameter"],

				$key["hight_in_meters"],

				$key["support"],

				$key["status"],

				*/

				// updated_code

				$key["uniqid"],
				$key["date"],
				$key["name"],
				// updated at
				$key["updated_at"],
				// $next_oservation_data,
				'',

				$key["lat"],

				$key["lon"],



				$key["address"],



				$key["city"],
				// pending

				$key["postal_code"],

				$key["country"],



				lang1($key["place"]),

				lang1($key["nesting_type"]),

				$key['colonie_hauteur'],


				// $etat_colonie,
				'undetermined',

				lang1($key["activity"]),

				lang1($key["pollen"]),

				// $disappeared,
				'',

				// $occupied,
				'',



				$key['detailed_information'],



				$this->setcsvLink($key["id"]),
				$key["height"],
				lang1($key["tree_alive"]),
				// $key["trunk_circumference"],
				$key['tree_genes'],
				// $key["entrance_dimension"],
				$key['colonie_dimension'],

				// $key["nest_entrance"],
				lang1($key['orientation']),
				// $key["entry_form"],
				$key['shape'],
				// $key["entrance_area"],
				$key['area'],
				$key["temperature"],
				lang2($key["weather_situation"]),
				// Enter in contact
				$key['findPro'],
				lang1($key["flights"]),

				lang1($key["fight_with_workers"]),

				lang1($key["waste_wax"]),
				// done_here







				// $key["entrance_height"],

















				// $key["detailed_information"],

				// $key["video"],

				// $key["report_type"],

				// $key["time"],

				// $key["bees_in_pollen"],

				// $key["babysitters"],



				// $key["timestamp"],



				// $key["state_region"],

				// $key["end_section"],













			);

			fputcsv($handle, $narray);
			$follow_data = $this->db->get_where('tbl_follow', array('nest_id' => $key["id"]))->result_array();
			if (!empty($follow_data)) {
				foreach ($follow_data as $row) {
					if ($row['cavity_occupied'] == "Oui") {
						$row['cavity_occupied'] = $row['pouvezvous'];
					} else {
						$row['cavity_occupied'] = lang1($row['cavity_occupied']);
					}
					$narray = array(
						$key["uniqid"],
						'',
						// name
						'',
						// updated at
						'',
						// next observation date
						$row['date'],
						// lat
						'',
						// long
						'',
						// addresss
						'',
						// city
						'',
						// postal code
						'',
						// country
						'',
						// place
						'',
						// nesting type
						'',
						// colonie hauter
						'',
						// etat de la colonie
						lang1($row['etat_de_la_colonie']),

						lang1($row['activity']),
						lang1($row['pollen']),
						lang1($row['disappeared']),
						$row['cavity_occupied'],

						// detailed nformation
						'',


						$this->setcsvLink($row["id"]),
						// height
						'',
						// tree alive
						'',
						// trunk circumference
						'',
						// entrance dimension
						'',
						// nest entrance
						'',
						// entry form
						'',
						// entrance area
						'',
						$row['temperature'],
						lang2($row["weather_situation"]),
						// enter in contact pending
						'',
						lang1($row["flights"]),
						lang1($row["fight_with_workers"]),
						lang1($row["waste_wax"]),








					);
					fputcsv($handle, $narray);
				}
			}
		}

		$htmlContent = '<p>Normal csv</p>';

		$htmlContent .= '<p>Loop . ' . $i . '</p>';

		$htmlContent .= '<p> ids' . implode(',', $arrIds) . '</p>';

		// $this->crud->send_mail('waseemafzal31@gmail.com','app@geonest.org','geonest csv','export csv',$htmlContent);



		fclose($handle);
	}

	function exportCsvFull($arrIds)

	{



		extract($_POST);

		//  pre($this->session);



		$data = $this->db->select('r.*')->where_in('r.id', $arrIdss)->get('tbl_loc as r')->result_array();

		// lq();

		//pre($res);

		//echo 'L';exit;



		$fileName = 'Fullcsv-' . date('y-m-d H:i:s');

		header('Content-Type: application/csv; charset=UTF-8');

		header("Content-Disposition: attachment; filename=\"'" . $fileName . "'" . ".csv\"");



		$handle = fopen('php://output', 'w');

		fputcsv($handle, array(

			"UniqueID", "X", "Y", "date declaration", "precision_pt", "User name", "description", "Nest", "Date modification", "Name Pro", "Diametre", "Hauteur", "support", "Etat du Nid", "Link Pictures", "Type de prototype", "Longueur canne perforée (en cm)", "Temps de chauffe de nid", "Conditions", "Horaire", "Sortie des insectes", "Attaques", "Observations au sol", "Activité du nid", "Remarques "

		));





		foreach ($data as $key) {



			if ($key["status"] == 1) {

				$key["status"] = 'Actif';
			} else if ($key["status"] == 2) {

				$key["status"] = 'Inactif';
			} else if ($key["status"] == 3) {

				$key["status"] = 'manipulé';
			} else {

				$key["status"] = 'traité';
			}



			//

			$narray = array(

				$key["uniqid"],

				$key["lat"],

				$key["lon"],

				$key["added_date"], $key["precision_pt"],

				$key["name"],

				$key["description"],

				$key["nest_type"],

				$key["modificationDate"],

				$key["proName"],

				$key["diameter"],

				$key["hight_in_meters"],

				$key["support"],

				$key["status"],

				$this->setcsvLink($key["id"]),

				$key["prototypeType"],

				$key["perforated"],

				$key["heatingTime"],

				$key["conditions"],

				$key["schedule"],

				$key["exitInsect"],

				$key["ifAttacked"],

				$key["choicesOnGround"],

				$key["whenActive"],

				$key["remarks"]

			);

			fputcsv($handle, $narray);
		}

		fclose($handle);

		$htmlContent = '<p>Full csv</p>';

		$htmlContent .= '<p>Loop . ' . $i . '</p>';

		$htmlContent .= '<p> ids' . implode(',', $arrIds) . '</p>';

		// $this->crud->send_mail('waseemafzal31@gmail.com','app@geonest.org','geonest csv','export csv',$htmlContent);

	}

	function exportCsvPro($arrIdss)

	{

		//    extract($_POST);

		//  pre($this->session);





		$data = $this->db->select('r.*')->where_in('r.id', $arrIdss)->get('tbl_loc as r')->result_array();

		// lq();

		//pre($res);

		//echo 'L';exit;



		$fileName = 'Fullcsv';

		header('Content-Type: application/csv; charset=UTF-8');

		header("Content-Disposition: attachment; filename=\"'" . $fileName . "'" . ".csv\"");



		$handle = fopen('php://output', 'w');

		fputcsv($handle, array(

			"UniqueID", "X", "Y", "date declaration", "precision_pt", "User name", "Contact", "description", "Nest", "Date modification", "Name Pro", "Diametre", "Hauteur", "support", "Etat du Nid", "Link Pictures", "Type de prototype", "Longueur canne perforée (en cm)", "Temps de chauffe de nid", "Conditions", "Horaire", "Sortie des insectes", "Attaques", "Observations au sol", "Activité du nid", "Remarques "

		));



		/*  if($key["findpro"]!='on'){

				  continue;

				  }*/



		foreach ($data as $key) {

			if ($key["status"] == 1) {

				$key["status"] = 'Actif';
			} else if ($key["status"] == 2) {

				$key["status"] = 'Inactif';
			} else if ($key["status"] == 3) {

				$key["status"] = 'manipulé';
			} else {

				$key["status"] = 'traité';
			}



			//

			$narray = array(

				$key["uniqid"],

				$key["lat"],

				$key["lon"],

				$key["added_date"], $key["precision_pt"],

				$key["name"],

				$key["phone"],

				$key["description"],

				$key["nest_type"],

				$key["modificationDate"],

				$key["proName"],

				$key["diameter"],

				$key["hight_in_meters"],

				$key["support"],

				$key["status"],

				$this->setcsvLink($key["id"]),



				$key["prototypeType"],

				$key["perforated"],

				$key["heatingTime"],

				$key["conditions"],

				$key["schedule"],

				$key["exitInsect"],

				$key["ifAttacked"],

				$key["choicesOnGround"],

				$key["whenActive"],

				$key["remarks"]

			);

			fputcsv($handle, $narray);
		}

		fclose($handle);

		$htmlContent = '<p>Full csv</p>';

		$htmlContent .= '<p>Loop . ' . $i . '</p>';

		$htmlContent .= '<p> ids' . implode(',', $arrIds) . '</p>';

		// $this->crud->send_mail('waseemafzal31@gmail.com','app@geonest.org','geonest csv','export csv',$htmlContent);

	}



	function getImagesLinks($id)

	{

		$data = $this->db->select("CONCAT('" . base_url() . "uploads/',file) as file")->where('map_id', $id)->get('tbl_map_images')->limit(1);

		if ($data->num_rows() > 0) {

			$i = 1;

			foreach ($data->result() as $row) {

				//$html.='<a href="'.$row->file.'">Link'.$i.'</a>';

				$html .= '=HYPERLINK("' . $row->file . '","Show Image")';



				$i++;
			}

			return $html;
		}
	}

	function setcsvLink($id)
	{

		$link = base_url() . 'map/showImages/' . $id . ' ';

		//return   '=HYPERLINK("'.$link.'","Show Images")';

		//return   '=HYPERLINK('.$link.',Show Images)';



		return  $link;
	}



	function followHistory($id)

	{
		$htmlDATA['nest_id'] = $id;
		$htmlDATA['nest'] = $this->db->select("*")->where('id', $id)->get('tbl_loc')->row();



		$htmlDATA['data'] = $this->db->select("f.*,u.name")->where('nest_id', $id)
			->join('users u', 'u.id=f.user_id')
			->order_by("id", "desc")
			->get('tbl_follow as f');
		// latest observer data
		$htmlDATA['latest_observer_data'] = $this->db->query("select date from tbl_follow where nest_id=$id order by id desc limit 1")->result_array()[0]['date'];




		// pre($htmlDATA);

		$this->load->view('followHistory', $htmlDATA);
	}



	function showImages($id)

	{

		$htmlDATA = array();

		$data = $this->db->select("CONCAT('" . base_url() . "uploads/images/',file) as file")->where('map_id', $id)->get('tbl_map_images');

		if ($data->num_rows() > 0) {

			$i = 1;

			foreach ($data->result() as $row) {

				$html .= '<div class="col-md-3 col-sm-6 col-xs-12"><div class="thumbnail"><a class="fancybox" rel="gallery" href="' . $row->file . '"><img src="' . $row->file . '" height="300" class="img-responsive"></a></div>

                <center><a download href="' . $row->file . '">Download</a></center>

                </div>';

				$active = '';

				if ($i == 1) {

					$active = 'active';
				}

				$slider .= '<div class="item ' . $active . '">

        <img src="' . $row->file . '" alt="image" style="width:100%;">

      </div>';



				$i++;
			}

			$htmlDATA['data'] = $html;

			$htmlDATA['slider'] = $slider;
		}

		$htmlDATA['nest'] = $this->db->select("*")->where('id', $id)->get('tbl_loc')->row();



		// pre($htmlDATA);

		$this->load->view('showImages', $htmlDATA);
	}

	function nestdetail($id)

	{



		if ($this->session->userdata('userlogin') == 1) {

			if (isset($_GET['notification']) and $_GET['notification'] == true) {



				$this->db->where(array('resource_id' => $id, 'receiver_id' => get_session('user_id')))->update('notifications', array('readed' => 1));
			}
		}


		$htmlDATA = array();

		$data = $this->db->select("CONCAT('" . base_url() . "uploads/',file) as file")->where('map_id', $id)->get('tbl_map_images');

		if ($data->num_rows() > 0) {

			$i = 1;

			foreach ($data->result() as $row) {

				$html = '<div class="col-md-3 col-sm-6 col-xs-12"><div class="thumbnail"><a class="fancybox" rel="gallery" href="' . $row->file . '"><img src="' . $row->file . '" height="300" class="img-responsive"></a></div>

                <center><a download href="' . $row->file . '">Download</a></center>

                </div>';

				$active = '';

				if ($i == 1) {

					$active = 'active';
				}

				$slider = '<div class="item ' . $active . '">

        <img src="' . $row->file . '" alt="image" style="width:100%;">

      </div>';



				$i++;
			}

			$htmlDATA['data'] = $html;

			$htmlDATA['slider'] = $slider;
		}

		$htmlDATA['nest'] = $this->db->select('*')->where('id', $id)->get('tbl_loc')->row();



		// pre($htmlDATA);

		$this->load->view('showImages', $htmlDATA);
	}

	function getImagesWithHtml($id)

	{

		$htmlDATA = array();

		$data = $this->db->select("id, file")->where('map_id', $id)->get('tbl_map_images');

		if ($data->num_rows() > 0) {

			$i = 1;

			foreach ($data->result() as $row) {

				$html  = '<div id="imageDiv' . $row->id . '" class="col-md-2 col-sm-3 col-xs-6"><div class="thumbnail"><a class="delImage" href="javascript:void(0)" onClick="delImage(\'' . $row->id . '\')">x</a><img src="' . $row->file . '" height="200" class="img-responsive"></div>

                </div>';



				$i++;
			}
		}

		return $html;
	}



	public function _index()

	{



		$JSONArr = file_get_contents('https://geoip-db.com/json/geoip.php');

		$location = json_decode($JSONArr);

		$latitude = $location->latitude;

		$longitude = $location->longitude;

		$aData = array();

		$sql = "SELECT *,3959 * ACOS(SIN(RADIANS( " . $latitude . " )) * SIN(RADIANS(`lat`)) +

                    COS(RADIANS( " . $latitude . " )) * COS(RADIANS(`lat`)) * COS(RADIANS(`lon`) -

                    RADIANS( " . $longitude . " ))) AS `radius` FROM " . $this->tbl_loc . "  

					 HAVING radius <= 500 ORDER BY radius ASC ";

		$aData['result']  = $this->db->query($sql);



		//	$aData['result']  = $this->db->select('*')->from($this->tbl_loc)->get();



		$this->load->view('main', $aData);
		//   pending

	}



	function getVisIpAddr()

	{



		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {

			return $_SERVER['HTTP_CLIENT_IP'];
		} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {

			return $_SERVER['REMOTE_ADDR'];
		}
	}

	// by waseem





	function getAddressFromGoogle($latitude, $longitude)

	{



		$geolocation = $latitude . ',' . $longitude;

		$request = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $geolocation . '&sensor=false&key=AIzaSyC7VQ8dJPR9dSkcPWYBctj2fbI3flLl5TU';

		//echo 'Status: '. $request;exit;

		$file_contents = file_get_contents($request);

		$json_decode = json_decode($file_contents);

		$status = $json_decode->status;

		if ($status == "OK") {

			return $json_decode->results[0]->formatted_address;

			exit;
		}



		if (isset($json_decode->results[0])) {

			$response = array();

			foreach ($json_decode->results[0]->address_components as $addressComponet) {

				if (in_array('political', $addressComponet->types)) {

					$response[] = $addressComponet->long_name;
				}
			}



			if (isset($response[0])) {

				$first  =  $response[0];
			} else {

				$first  = 'null';
			}

			if (isset($response[1])) {

				$second =  $response[1];
			} else {

				$second = 'null';
			}

			if (isset($response[2])) {

				$third  =  $response[2];
			} else {

				$third  = 'null';
			}

			if (isset($response[3])) {

				$fourth =  $response[3];
			} else {

				$fourth = 'null';
			}

			if (isset($response[4])) {

				$fifth  =  $response[4];
			} else {

				$fifth  = 'null';
			}

			$address = '';

			if ($first != 'null' && $second != 'null' && $third != 'null' && $fourth != 'null' && $fifth != 'null') {

				$address = $first . ',' . $second . ',' . $fourth . ' ' . $fifth;
			} else if ($first != 'null' && $second != 'null' && $third != 'null' && $fourth != 'null' && $fifth == 'null') {

				$address = $first . ',' . $second . ',' . $third . ' ' . $fourth;
			} else if ($first != 'null' && $second != 'null' && $third != 'null' && $fourth == 'null' && $fifth == 'null') {

				$address = $first . ',' . $second . ',' . $third;
			} else if ($first != 'null' && $second != 'null' && $third == 'null' && $fourth == 'null' && $fifth == 'null') {

				$address = $first . ',' . $second;
			} else if ($first != 'null' && $second == 'null' && $third == 'null' && $fourth == 'null' && $fifth == 'null') {

				$address = $first;
			}
		}



		return $address;
	}





	public function maplocationsave()

	{



		header('Access-Control-Allow-Origin: *');

		header('Content-type: application/json');

		$nestID = '';

		extract($_POST);

		$response = array();





		if (isset($primaryId) and $primaryId != '') {

			$nestID = $primaryId;

			unset($_POST['primaryId']);
		}



		$findProTru = 0;

		$response['redirect'] =  'reportnest';



		if (isset($findPro) and $findPro == 'on') {



			$findProTru =  $findPro;

			$response['redirect'] =  'contact-with-pro';
		}







		$name = get_session('name');



		$additional_data = array(

			'name' => $name,

			'user_id' => get_session('user_id'),

			'email' => $email,

			'findpro' => $findProTru,

			'city' => $city,

			'state_region' => $state_region,

			'postal_zip_code' => $postal_zip_code,

			'nest_type' => $nest_type,

			'status' => $status,

			'support' => $support,

			'diameter' => $diameter,

			'hight_in_meters' => $hight_in_meters,

			'pro' => 'Normal User',

			'added_date' => date('d-m-Y')

		);

		$alocation = $this->crud->extract_coordinates($address);



		if (count($alocation) > 0) {

			$additional_data['lat'] = $alocation['lat'];

			$additional_data['lon'] = $alocation['lng'];

			$response['redirect'] = $response['redirect'] . '?latitude=' . $alocation['lat'] . '&longitude=' . $alocation['lng'];
		}

		if (isset($userId) and $userId != '') {

			$additional_data['user_id'] = $userId;

			$additional_data['UniqueID'] = $userId . '_' . date('d-m-Y') . '_Geonest';
		}

		if (isset($name) and $name != '') {

			$additional_data['name'] = $name;

			$UniqueID = $name . '_' . date('d-m-Y') . '_FLB';

			$count = count_where('tbl_loc', array('added_date' => $UniqueID));

			$count = $count + 1;

			$additional_data['UniqueID'] = $UniqueID . '-' . $count;
		}



		if (isset($description) and $description != '') {

			$additional_data['description'] = $description;
		}

		if (isset($address) and $address != '') {

			$additional_data['address'] = $address;
		}

		if ($nestID != '') {

			$additional_data['modificationDate'] = date('d-m-Y');
		}

		//$aresultimg = $this->filuploadingfunction('imagefile','image','uploads/');

		//$additional_data =  array_merge($additional_data,$aresultimg);

		$result = $this->crud->saveRecord($primaryId, $additional_data, $this->tbl_loc);

		if ($result == 1) {

			$insrtID = $this->db->insert_id();

			$this->session->set_userdata('last_nest_id', $insrtID);
		} else {

			$insrtID =  $primaryId;
		}

		/*--------------------------------------------------

			|File uploading either single or multiple add/update

			---------------------------------------------------*/



		if (!empty($_FILES)) {

			$nameArray = $this->crud->upload_files($_FILES);

			$nameData = explode(',', $nameArray);

			$imagesHtml = '';

			foreach ($nameData as $file) {

				$arr = explode('.', $file);

				$type = 0;

				if ($arr[1] == 'mp4' or $arr == 'MP4') {

					$type = 1;
				}

				$file_data = array(

					'file' => $file,

					'type' => $type,

					'map_id' => $insrtID

				);

				$this->db->insert('tbl_map_images', $file_data);

				//lq();

				//	$src=base_url().'uploads/'.$file;

				//$imagesHtml.='<img src="'.$src.'">';

			}
		}

		/*--------------------------------------------------

			|SAAVING LINKED FORM OR PROTOTYPE INFO	

			---------------------------------------------------*/





		if ($checkboxPrototype == 'on') {

			$linkedFormData = array(

				'nest_id' => $insrtID,

				'prototypeType' => $prototypeType,

				'perforated' => $perforated,

				'heatingTime' => $heatingTime,

				'conditions' => implode(',', $condition),

				'schedule' => $schedule,

				'exitInsect' => $exitInsect,

				'ifAttacked' => $ifAttacked,

				'choicesOnGround' => implode(',', $choicesOnGround),

				'whenActive' => implode(',', $whenActive),

				'remarks' => $remarks

			);

			$this->crud->saveRecord($primaryId, $linkedFormData, $this->tbl_prototypeform);
		}



		/*

			  $htmlContent.='<b>Hi there</b><br><br>';

			  $htmlContent.='<p>A new nest has been reported and below is the detail.</p>';

			  foreach($additional_data as $key=>$val){

			      $dataVal= '<p><b>'.$key.': </b>'.$val.'</p>' ;

			  }

			   $htmlContent.=$dataVal;

			   $htmlContent.='<br><br>';

			   $htmlContent.=$imagesHtml;

			   

			  

			$this->send_mail($to, $from, $from_heading, $subject, $htmlContent);

			*/

		/*===============================================*/



		if ($result == 1) {

			$response['status'] = 1;

			$response['message'] = lang('success');
		} elseif ($result == 2) {

			$response['message'] = lang('success');
		}





		echo json_encode($response);

		exit;
	}





	public function filuploadingfunction($filelemName, $dbfieldcolname, $path)

	{



		$imgcheck = false;

		if (isset($_FILES[$filelemName]['name']) and !empty($_FILES[$filelemName]['name'])) {

			$imgcheck = true;

			$info = pathinfo($_FILES[$filelemName]['name']);

			$ext = $info['extension']; // get the extension of the file







			if (in_array($ext, array('jpg', 'png', 'JPEG', 'jpeg', 'PNG'))) {

				$newname = rand(5, 3456) * date(time()) . "." . $ext;

				$target = $path . $newname;

				if (move_uploaded_file($_FILES[$filelemName]['tmp_name'], $target)) {

					$image = $newname;
				}



				$additional_data = array($dbfieldcolname => $image);



				return $additional_data;
			} else {



				$arr = array("status" => "validation_error", "message" => 'You are trying to upload Invalid file type.');

				echo json_encode($arr);

				exit;
			}
		} else {

			return array();
		}
	}













	function send_mail($to, $from, $from_heading, $subject, $htmlContent)



	{



		$this->load->library('email');



		$config = array(



			'mailtype' => 'html',



			'charset' => 'iso-8859-1',



			'wordwrap' => TRUE



		);



		$this->email->initialize($config);



		$this->email->from($from, $from_heading);



		$this->email->to($to);



		$this->email->subject($subject);



		$this->email->message($htmlContent);



		if ($this->email->send()) {



			return 1;
		} else {



			return 0;
		}
	}

	// for video

	public function doupload()

	{



		$upload_path = "uploads/video";



		$config = array(

			'upload_path' =>

			$upload_path,

			'allowed_types' => "mp4",

			'overwrite' => TRUE,

			// 'encryption' => TRUE

			// 'max_size' => "2048000",

			// 'max_height' => "768",

			// 'max_width' => "1024"

		);

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('video')) {

			return $this->upload->display_errors();
		} else {

			$imageDetailArray = $this->upload->data();

			$image =  $imageDetailArray['file_name'];

			return $image;
		}
	}

	// complete

	public function complete()

	{

		$this->load->view('complete_edit');
	}

	// simple

	public function simple()

	{

		$this->load->view('simple_edit');
	}

	// suive

	// public function suive()

	// {

	// 	$this->load->view('suive');
	// }

	// 

	private function images_upload()

	{









		$files = $_FILES;



		$cpt = count($_FILES['images']['name']);

		for ($i = 0; $i < $cpt; $i++) {

			$f = explode(".", $files['images']['name'][$i]);

			$f[0] = md5(uniqid());

			$f = $f[0] . '.' . $f[1];



			$files['images']['name'][$i] = $f;

			$_FILES['images']['name'] = $f;





			$_FILES['images']['type'] = $files['images']['type'][$i];

			$_FILES['images']['tmp_name'] = $files['images']['tmp_name'][$i];

			$_FILES['images']['error'] = $files['images']['error'][$i];

			$_FILES['images']['size'] = $files['images']['size'][$i];

			// 

			// $config = array();
			$config['upload_path'] = 'uploads/images';

			$config['allowed_types'] = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG|mp4';
			// $config['encrypt_name'] = TRUE;
			$config['overwrite']     = FALSE;
			// $config['upload_path'] = 'uploads/images';

			// $config['allowed_types'] = 'gif|jpg|png|GIF|JPG|PNG|mp4';


			// $config['max_size']      = '0';

			// $config['overwrite']     = FALSE;
			$this->load->library('upload', $config);

			$this->upload->initialize($config);
			if ($this->upload->do_upload('images')) {
			} else {
				// pre($this->upload->display_errors());
				echo json_encode(array('status' => 100, 'message' => $this->upload->display_errors()));
				exit;
			}
			// if (!$this->upload->do_upload('images')) {
			// 	echo json_encode(array('status' => 100, 'message' => "invalid file"));
			// }
		}

		$_FILES = $files;
	}


	public function complete_insert()
	{



		$message = '';
		$this->load->library('form_validation');
		extract($_POST);
		if ($address == "") {
			$message .= lang('address_field') . '<br>';
		}
		if ($date == "") {
			$message .= lang('date_field') . '<br>';
		}
		if ($place == "") {
			$message .= lang('colonie_field') . '<br>';
		}
		if ($colonie_hauteur == "") {
			$message .= lang('colonie_hauter') . '<br>';
		}
		if ($nesting_type == "") {
			$message .= lang('type_support_field') . '<br>';
		}
		if ($pollen == "") {
			$message .= lang('pollen_field') . '<br>';
		}
		if ($activity == "") {
			$message .= lang('activity_field') . '<br>';
		}
		if ($temperature == "") {
			$message .= lang('temperature_field') . '<br>';
		}
		if ($detailed_information == "") {
			$message .= lang('detailed_information_field') . '<br>';
		}
		// $this->form_validation->set_rules('address', lang('address_field'), 'required');
		// $this->form_validation->set_rules('date', lang('date_field'), 'required');
		// $this->form_validation->set_rules('place', lang('colonie_field'), 'required');
		// $this->form_validation->set_rules('colonie_hauteur', lang('colonie_hauter'), 'required');
		// $this->form_validation->set_rules('nesting_type', lang('type_support_field'), 'required');
		// $this->form_validation->set_rules('pollen', lang('pollen_field'), 'required');
		// $this->form_validation->set_rules('activity', lang('activity_field'), 'required');
		// $this->form_validation->set_rules(
		// 	'temperature',
		// 	'Field Label',
		// 	'rule1|rule2|rule3',
		// 	array('rule2' => 'Error Message on rule2 for this field_name')
		// );
		// $this->form_validation->set_rules(
		// 	'temperature',
		// 	'temperature',
		// 	'rule1',
		// 	array('rule1' => 'temperature_haris firld required')
		// );
		// $this->form_validation->set_rules('temperature', lang('temperature_field'), 'required');
		// $this->form_validation->set_rules('detailed_information', lang('detailed_information_field'), 'required');
		if (empty($_FILES['images'])) {
			$message .= lang('image_field') . '<br>';
		}
		if (!isset($weather_situation) ||  empty($weather_situation)) {
			$message .= lang('weather_situation_field') . '<br>';
		}

		if ($message != '') {
			// $message .= validation_errors();
			echo json_encode(array('status' => 100, 'message' => $message));
		} else {




			if ($_POST['lat'] == '' and $_POST['lon'] == '') {



				$this->setlatlon();



				$_POST['lat'] = get_session('latitude');

				$_POST['lon'] = get_session('longitude');
			}

			$string = implode(',', $_POST['weather_situation']);

			$_POST['weather_situation'] = $string;

			if (isset($_POST['end_time_observation'])) {

				$_POST['report_type'] = 1;
			}

			if (isset($_FILES['images']['name']) || isset($_FILES['videos']['name'])) {

				$this->images_upload();
				// ***********************************


				// ***********************************

				$string = implode(',', $_FILES['images']['name']);
			}

			$_POST['name'] = get_session('name');

			$_POST['user_id'] = get_session('user_id');

			/*	$UniqueID =get_session('name').'_'.date('d-m-Y').'_FLB';

			$count = count_where('tbl_loc', array('date' => $UniqueID));

			$count = $count + 1;

			$_POST['uniqid'] = $UniqueID . '-' . $count;*/

			$success = $this->Cruds->insert_data("tbl_loc", $_POST, $string);

			if ($success) {

				$this->session->set_flashdata('message', lang('success'));

				$this->session->set_flashdata('status', 200);

				$redirect = 'contact-with-pro?latitude=' . $_POST['lat'] . '&longitude=' . $_POST['lon'];

				if (isset($_POST['findPro']) and $_POST['findPro'] == 'on') {

					//	redirect(base_url() . $redirect, 'refresh');
					echo json_encode(array('status' => 201, 'redirect' => base_url() . $redirect));
					exit;
				} else {
					//pending
					$redirect = 'map/index?latitude=' . $_POST['lat'] . '&longitude=' . $_POST['lon'];
					echo json_encode(array('status' => 200, 'redirect' => base_url() . $redirect));
					exit;
				}
			} else {
				echo json_encode(array('status' => 100, 'message' => $this->db->_error_message()));

				// $this->session->set_flashdata('message', $this->db->_error_message());

				// $this->session->set_flashdata('status', 204);

				// redirect(base_url() . 'complete', 'refresh');
			}
		}
	}

	public function complete_edit_form()

	{


		//saturday
		$message = '';
		$this->load->library('form_validation');
		extract($_POST);
		if ($address == "") {
			$message .= lang('address_field') . '<br>';
		}
		if ($date == "") {
			$message .= lang('date_field') . '<br>';
		}
		if ($place == "") {
			$message .= lang('colonie_field') . '<br>';
		}
		if ($colonie_hauteur == "") {
			$message .= lang('colonie_hauter') . '<br>';
		}
		if (
			$nesting_type == ""
		) {
			$message .= lang('type_support_field') . '<br>';
		}
		if (
			$pollen == ""
		) {
			$message .= lang('pollen_field') . '<br>';
		}
		if (
			$activity == ""
		) {
			$message .= lang('activity_field') . '<br>';
		}
		if (
			$temperature == ""
		) {
			$message .= lang('temperature_field') . '<br>';
		}
		if ($detailed_information == "") {
			$message .= lang('detailed_information_field') . '<br>';
		}
		//saturday

		if (!isset($weather_situation) ||  empty($weather_situation)) {
			$message .= lang('weather_situation_field') . '<br>';
		}

		if ($message != '') {
			// $message .= validation_errors();
			echo json_encode(array('status' => 100, 'message' => $message));
		} else {

			if (isset($_POST['pro_user'])) {

				$string = implode(',', $_POST['weather_situation']);

				$_POST['weather_situation'] = $string;

				if (isset($_POST['end_time_observation'])) {

					$_POST['report_type'] = 1;
				}



				if ($_FILES['video']['name'] != "") {

					$f1 = $_FILES['video']['name'];

					$f1 = explode(".", $f1);

					$f1[0] = uniqid();

					$f1 = $f1[0] . "." . $f1[1];

					$_FILES['video']['name'] = $f1;

					$this->doupload();

					$f = ['video' => $f1];

					$_POST = array_merge($_POST, $f);
				}



				if ($_FILES['images']['name'][0] != "") {



					$this->images_upload();





					$string = implode(',', $_FILES['images']['name']);





					$tbl_loc_id = $_POST['pro_user'];

					$this->Cruds->updated_images($tbl_loc_id, $string);
				}



				$success = $this->Cruds->edit_complete_form_data("tbl_loc");

				if ($success) {


					$this->session->set_flashdata('message', lang('success'));

					$this->session->set_flashdata('status', 200);

					$redirect = 'contact-with-pro?latitude=' . $_POST['lat'] . '&longitude=' . $_POST['lon'];

					if (isset($_POST['findPro']) and $_POST['findPro'] == 'on') {

						//	redirect(base_url() . $redirect, 'refresh');
						echo json_encode(array('status' => 201, 'redirect' => base_url() . $redirect));
						exit;
					} else {
						//pending
						$redirect = 'map/index?latitude=' . $_POST['lat'] . '&longitude=' . $_POST['lon'];
						echo json_encode(array('status' => 200, 'redirect' => base_url() . $redirect));
						exit;
					}





					// if (isset($_POST['end_time_observation'])) {



					// 	redirect(base_url() . 'simple', 'refresh');
					// } else {

					// 	// $this->session->set_flashdata('message', lang('success'));

					// 	// $this->session->set_flashdata('status', 200);

					// 	// redirect(base_url() . 'map/index', 'refresh');
					// 	echo json_encode(array('status' => 200));
					// }
				} else {

					die("query not working");
				}
			}
		}



		redirect(base_url() . 'complete', 'refresh');
	}



	public function del_image()

	{

		$image_id = $_POST['image_id'];

		$success = $this->Cruds->delete_image($image_id);

		if ($success) {

			echo 1;
		} else {

			echo 0;
		}
	}

	// 	pending

	public function clonerow()
	{



		$response = $this->Cruds->insert_clone_data();

		if ($response = true) {

			echo json_encode(array("result" => $response));
		} else {

			echo json_encode(array("result" => $response));
		}
	}
}
