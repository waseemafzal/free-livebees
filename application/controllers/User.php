<?php

defined('BASEPATH') or exit('No direct script access allowed');



class User extends CI_Controller
{

	public $tbl_user = "users";







	function __construct()

	{


		parent::__construct();

		//	header('Access-Control-Allow-Origin: *');

		// header('Content-type: application/json');

		define('IMG', base_url() . 'uploads/');
	}



	public function index()
	{



		$aData['page_title'] = "Freelivebess Home";

		$this->load->view('home', $aData);
	}

	public function login()
	{

		if ($this->session->userdata('userlogin') == true) {
			redirect('map', 'refresh');
		}

		$aData['page_title'] = "Freelivebess login";

		$this->load->view('login', $aData);
	}



	public function signup()
	{



		$aData['page_title'] = "Freelivebess signup";

		$this->load->view('signup', $aData);
	}

	public function profile()
	{



		$aData['page_title'] = "Profil";

		$data = $this->db->select('*')->from('users')->where('id', get_session('user_id'))->get();

		$aData['user'] = $data->row();

		$this->load->view('profile', $aData);
	}

	public function notifications()
	{



		$aData['page_title'] = "Freelivebess notifications";

		$aData['notifidata'] = $this->db->where(array('receiver_id' => get_session('user_id')))->get('notifications');

		$this->load->view('notifications_list', $aData);
	}





	public function contactWithPro()
	{



		$response = array();

		$response['status'] = 204;

		$response['message'] = 'Notification non envoyée!';



		$pro_id = base64_decode($_POST['pro_id']);

		$data = $this->db->select('id,name,email')->from('users')->where('id', $pro_id)->get();

		$nest = $this->db->select('*')->from('tbl_loc')->where('id', get_session('last_nest_id'))->get()->row();

		if ($data->num_rows() > 0) {

			$userid = $data->row()->id;

			// send email 

			$to = $data->row()->email;

			$from = 'noreply@freelivebees.org';

			$from_heading = 'Freelivebees';

			$subject = 'Un nouveau nid vous est signalé';

			$fromName = $this->session->userdata('name');

			$htmlContent .= '<div ><div ><b>Voici le message de ' . ucfirst($fromName) . ' ,</b><br>';

			// $htmlContent .= '<p>Contacter moi merci.</p>';



			$htmlContent .= '<p>' . $_POST['message'] . '</p><br>';



			$htmlContent .= '<a id="btnLik" class="myButton"   href="' . base_url() . 'map/followHistory/' . get_session('last_nest_id') . '">' . lang('email_btn') . '</a>';



			$htmlContent .= '<br>';

			$htmlContent .= '<h5>FreeLiveBees</h5></div></div>';

			// $to='waseemafzal31@gmail.com';

			$this->crud->send_smtp_email($to, $from, $from_heading, $subject, $htmlContent);

			// save notification into database

			$notification = array(

				'body' => $nest->name . ' reported a nest',

				'created_date' => NOW,

				'resource_type' => 'nest',

				'resource_id' => get_session('last_nest_id'),

				'sender_id' => get_session('user_id'),

				'receiver_id' => $pro_id

			);

			if ($this->db->insert('notifications', $notification)) {

				$response['status'] = 200;

				$response['message'] = 'Notification envoyée avec succès!';
			}
		}



		echo json_encode($response);
	}

	function 	saveUser()
	{



		extract($_POST);

		$data = $this->db->select('*')->from('users')->where('email', $email)->get();

		$_POST['user_type'] = 4;

		if ($pro == 0) {

			$_POST['user_type'] = 3;
		}

		$_POST['about'] = $description;

		unset($_POST['pro']);

		unset($_POST['description']);

		unset($_POST['userId']);

		if ($data->num_rows() > 0) {

			$userid = $data->row()->id;

			if ($this->db->where('email', $userid)->update('users', $_POST)) {

				echo json_encode(array('message' => 'Mis à jour avec succés ', 'data' => $_POST));
			}
		} else {

			$this->db->insert('users', $_POST);
		}



		echo json_encode($_POST);
	}
}
