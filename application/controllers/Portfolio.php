<?php defined('BASEPATH') or exit('No direct script access allowed');

class Portfolio extends CI_Controller

{

	public $tbl_loc = "tbl_loc";

	public $tbl_prototypeform = 'prototypeform';

	function __construct(){
		parent::__construct();
		header('Access-Control-Allow-Origin: *');
		/*if ($this->session->userdata('login') != true) {
			redirect('user/login', 'refresh');
		}*/
		$this->load->library('pagination');
		error_reporting(1);
		$this->load->model('Cruds');
	}

	public function index(){
$table = 'tbl_loc';
		$aData = array();
		// incase user not share his location get nearist location from ip
		if (!isset($_GET['latitude']) and $_GET['latitude'] == '' and !isset($_GET['longitude']) and $_GET['longitude'] == '') {
			if(isset($_SESSION['latitude']) and isset($_SESSION['longitude'])){
			$latitude=	$_SESSION['latitude'];
						$longitude=	$_SESSION['longitude'];

				}else{
					$this->load->view('no_location');

					}
			
		} 
		if ($latitude != '' and $longitude != '') {
$sql = "SELECT *,(SELECT GROUP_CONCAT(tbl_map_images.file,'|',tbl_map_images.type) FROM tbl_map_images WHERE tbl_loc.id= tbl_map_images.map_id ) AS files,
tbl_loc.lat as latitude,tbl_loc.lon as longitude,( 6371 * 
acos( cos( radians( " . $latitude . " ) ) * 
cos( radians( lat ) ) * 
cos( radians( lon ) - 
radians( " . $longitude . " ) ) + 
sin( radians( " . $latitude . " ) ) * 
sin( radians( lat ) ) ) ) 
AS `radius` FROM tbl_loc  
HAVING radius <= 100  ORDER BY radius ASC  ";

			$aData['latitude'] = $latitude;
			$aData['longitude'] = $longitude;
			$aData['address'] = $this->getAddressFromGoogle($latitude, $longitude);
			$object  = $this->db->query($sql);
			//lq();
			$aData['data'] = $object;
			$aData['latitude'] = $latitude;
			$aData['longitude'] = $longitude;
			$aData['page_title'] = "Portfolio page";
			$aData['usersDatalist'] = $this->db->select('id,name')->where('user_type!=', 1)->get('users');
			
			$this->load->view('portfolio', $aData);

		}

	}

	function getAddressFromGoogle($latitude, $longitude)



	{







		$geolocation = $latitude . ',' . $longitude;
		$request = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $geolocation . '&sensor=false&key=AIzaSyC7VQ8dJPR9dSkcPWYBctj2fbI3flLl5TU';
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


}

