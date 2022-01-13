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
