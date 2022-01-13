<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Home extends CI_Controller

{

	public $tbl_user = "users";







	function __construct()

	{

		parent::__construct();

		define('IMG', base_url() . 'uploads/');

		//$this->load->model('crud_model','cr');

	}

	public $tbl = 'tbl_loc';

	public function index()

	{

		$aData = array();

		//$uri = $this->uri->segment_array();

		//print_r($uri);exit;

		$aData['page_title'] = "Geonest Home";

		//$this->cr->edit($id); 



		$aData['mydata'] = $this->db->where(array('status' => 0, 'nest_type' => 0))->get($this->tbl);



		$this->load->view('home', $aData);
	}


	function forgotpassemail()
	{

		extract($_POST);
		$arr = array();
		$ckdata = $this->db->where('email', $email)->get('users')->result();
	//	lq();
		if (!empty($ckdata)) {
		    //	lq();
			$code = time();
			$data = array(
				'email' => $email,
				'code' => $code,
			);
			if ($this->db->insert('forgot_session', $data)) {


				$url = base_url() . "home/recoverpassword/" . $code;
				$subject = lang('forgot_recover_pwd');

				$message = '<h3>' . lang('click_link_recover_pwd') . '</h3>
						' . $url . '
						';

				if ($this->crud->send_smtp_email($email, FROM, FROM_HEADING, $subject, $message) == 1) {
					$arr['message'] = lang('forgot_pwd_link_send');
					$arr['status'] = 200;
				} else {

					$arr['message'] = lang('problem_sending_mail');
					$arr['status'] = 100;
				}

			
			}
		} else {

			$arr['message'] = lang('go_to_registration');
			$arr['status'] = 100;

			$arr['message'] = lang('error');;
			$arr['status'] = 100;
		}

		echo json_encode($arr);
	}
	function recoverpassword()
	{
		$forgot_id = $this->uri->segment(3);
		$arr = array();
		// activation is using to check whether he is entering this value first time or not if he enter  correct this value  it will become 1 and on first time it will 0 by default
		$cdata = $this->db->where(array('code' => $forgot_id, 'activtion' => 0))->get('forgot_session')->result();
		if (!empty($cdata)) {
			$arr['userrecord'] = $cdata;
			$this->load->view('forgot', $arr);
		} else {
			$this->load->view('login');
		}
	}

	/*
	function forgotpassemail()
	{
		extract($_POST);
		$arr = array();
		$ckdata = $this->db->where('email', $email)->get('users')->result();
		if (!empty($ckdata)) {
			$code = time();
			$data = array(
				'email' => $email,
				'code' => $code,
			);
			if ($this->db->insert('forgot_session', $data)) {
				$url = base_url() . "home/recoverpassword/" . $code;
				$subject = "Forogot Password";

				$message = '<h3>Cliquez sur le lien ci-dessous pour récupérer un mot de passe </h3>
						' . $url . '
						';

				if ($this->crud->send_mail($email, FROM, FROM_HEADING, $subject, $message) == 1) {
					$arr['message'] = "Mot de passe oublié Lien envoyer votre email";
					$arr['status'] = 200;
				} else {
					$arr['message'] = "problème d'envoi de courrier";
					$arr['status'] = 100;
				}
			}
		} else {
			$arr['message'] = "Accédez à l'inscription impossible de trouver votre compte";
			$arr['status'] = 100;
		}

		echo json_encode($arr);
	}
	function recoverpassword()
	{
		$forgot_id = $this->uri->segment(3);
		$arr = array();
		$cdata = $this->db->where(array('code' => $forgot_id, 'activtion' => 0))->get('forgot_session')->result();
		if (!empty($cdata)) {
			$arr['userrecord'] = $cdata;
			$this->load->view('forgot', $arr);
		} else {
			$this->load->view('login');
		}
	}
	*/



	public function reportnest()

	{



		$aData['page_title'] = "Report a nest";

		$this->load->view('reportnest', $aData);
	}



	function save()

	{

		//printer($_POST);

		//inser

		$response['status'] = 200;

		$response['mymessage'] = lang('success');

		echo json_encode($response);

		exit;
	}
}
