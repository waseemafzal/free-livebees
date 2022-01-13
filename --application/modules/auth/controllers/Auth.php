<?php defined('BASEPATH') or exit('No direct script access allowed');





class Auth extends MX_Controller
{

	function __construct()

	{

		parent::__construct();



		$this->load->database();

		$this->load->model('crud/crud_model');

		$this->load->library(array('auth/ion_auth', 'form_validation'));

		$this->load->helper(array('url', 'language'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

		//$this->lang->load('auth');
		$this->lang->load('auth', get_session('lang'));
	}

	// redirect if needed, otherwise display the user list

	public function index()

	{



		if (!$this->ion_auth->logged_in()) {

			// redirect them to the login page

			redirect('auth/login', 'refresh');
		} elseif ($this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins

		{

			// redirect them to the home page because they must be an administrator to view this

			//return show_error('You must be an administrator to view this page.');

			$this->session->set_flashdata('message', $this->ion_auth->messages());

			redirect('dashboard', 'refresh');
		} else {

			// set the flash data error message if there is one

			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');



			//list the users

			$this->data['users'] = $this->ion_auth->users()->result();

			foreach ($this->data['users'] as $k => $user) {

				$this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
			}



			$this->_render_page('auth/index', $this->data);
		}
	}
	////update password
	function updatepassword()
	{

		extract($_POST);
		//// print_r($_POST);
		$pass = $this->ion_auth->getForgot($_POST['password']);
		if ($this->db->where('email', $email)->update('users', array('password' => $pass))) {
			if ($this->db->where('email', $email)->update('forgot_session', array('activtion' => 1))) {
				$arr['status'] = 200;


				// $arr['message'] = $this->success;
				$arr['message'] = lang('success');
			} else {
				$arr['status'] = 100;
				$arr['message'] = "erreur dans l'état d'activation";
			}
		} else {
			$arr['status'] = 200;
			$arr['message'] = 'impossible de changer le mot de passe';
		}

		echo json_encode($arr);
	}


	//end of update password


	public function view_users($type = 4)
	{

		if (!$this->ion_auth->logged_in()) {

			redirect('auth/login', 'refresh'); // redirect them to the login page

		} else {

			// set the flash data error message if there is one

			$Adata['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$title = 'App Users';



			if ($type == SUPER_ADMIN) {

				$title = 'Super Admins';
			} elseif ($type == ADMIN) {

				$title = 'ADMIN';
			}



			//list the users

			$data =  $this->db->select('*')->from(TBL_USER)->where('user_type', $type)->get();



			$Adata['users'] = $data->result();

			$Adata['title'] = $title;





			$this->_render_page('view', $Adata);
		}
	}







	/**************************************************************************************************************/



	public function get_by_userType()
	{

		if (!$this->ion_auth->logged_in()) {

			redirect('auth/login', 'refresh'); // redirect them to the login page

		} else {

			// set the flash data error message if there is one

			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');



			//list the users

			extract($_POST);

			$where = array('user_type' => $id);

			$res =  get_by_where_array($where, TBL_USER);

			$this->data['users'] = $res->result();



			foreach ($this->data['users'] as $k => $user) {

				$this->data['users'][$k]->groups =

					$this->ion_auth->get_users_groups($user->id)->result();
			}

			$this->data['user_type'] = $id;

			$this->_render_page('user_list_by_userType', $this->data);
		}
	}

	/****************************************************************************************************************/

	public function view_user_added_by()
	{

		if (!$this->ion_auth->logged_in()) {



			redirect('auth/login', 'refresh'); // redirect them to the login page

		} else {



			// set the flash data error message if there is one

			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');			//list the users

			//$data['data'] = $this->ion_auth->users_by_current_user();

			$this->data['users'] = $this->ion_auth->users_by_current_user();

			$this->load->view('user_list_view', $this->data);
		}
	}







	public function  changeUserStatus()

	{

		extract($_POST);

		if ($status == 1) {

			$chageTo = 'Inactive';
		} else {

			$chageTo = 'active';
		}





		$result = $this->crud_model->changeUserStatus($id, $tblName, $status);

		if ($result == 1) {

			$arr = array('chaged' => $result, 'status' => $chageTo);

			echo json_encode($arr);
		}
	}









	// log the user in

	// log the user in

	public function login()

	{

		// check if user already logedin then redirect to dashboard

		if ($this->session->userdata('login') == 1 && $this->session->userdata('user_type') == 1)

			redirect('dashboard', 'refresh');

		else

			//validate form input

			$this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');

		$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');



		if ($this->form_validation->run() == true) {

			// check to see if the user is logging in

			// check for "remember me"

			$remember = (bool) $this->input->post('remember');



			if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {

				//if the login is successful

				$this->session->set_userdata('login', true);





				$this->session->set_flashdata('message', $this->ion_auth->messages());



				if ($this->ion_auth->is_admin()) {

					// redirect them to the admin dashboard page because they must be an administrator to view this

					$this->session->set_flashdata('message', $this->ion_auth->messages());

					redirect('dashboard', 'refresh');
				} elseif (!$this->ion_auth->is_admin()) {

					// redirect them to the useer dashboard page because they must be an administrator to view this



					redirect('dashboard', 'refresh');

					//die('You must be admin to continue');

					//redirect('dashboard', 'refresh');

				}
			} else {

				// if the login was un-successful

				// redirect them back to the login page

				$this->session->set_flashdata('message', $this->ion_auth->errors());

				redirect('auth/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries

			}
		} else {

			// the user is not logging in so display the login page

			// set the flash data error message if there is one

			$aData['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$aData['identity'] = array(
				'name' => 'identity',

				'id'    => 'identity',

				'type'  => 'text',

				'value' => $this->form_validation->set_value('identity'),

			);

			$aData['password'] = array(
				'name' => 'password',

				'id'   => 'password',

				'type' => 'password',

			);



			$this->_render_page('auth/login_view', $aData);
		}
	}

	// log the user out

	public function logout()

	{

		$this->data['title'] = "Logout";



		// log the user out

		$logout = $this->ion_auth->logout();



		// redirect them to the login page

		$this->session->set_flashdata('message', $this->ion_auth->messages());

		redirect('auth/login', 'refresh');
	}



	// change password

	public function change_password()

	{

		$this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');

		$this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');

		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');



		if (!$this->ion_auth->logged_in()) {

			redirect('auth/login', 'refresh');
		}



		$user = $this->ion_auth->user()->row();



		if ($this->form_validation->run() == false) {

			// display the form

			// set the flash data error message if there is one

			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');



			$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');

			$this->data['old_password'] = array(

				'name' => 'old',

				'id'   => 'old',

				'type' => 'password',

			);

			$this->data['new_password'] = array(

				'name'    => 'new',

				'id'      => 'new',

				'type'    => 'password',

				'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',

			);

			$this->data['new_password_confirm'] = array(

				'name'    => 'new_confirm',

				'id'      => 'new_confirm',

				'type'    => 'password',

				'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',

			);

			$this->data['user_id'] = array(

				'name'  => 'user_id',

				'id'    => 'user_id',

				'type'  => 'hidden',

				'value' => $user->id,

			);



			// render

			$this->_render_page('auth/change_password', $this->data);
		} else {

			$identity = $this->session->userdata('identity');



			$change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));



			if ($change) {

				//if the password was successfully changed

				$this->session->set_flashdata('message', $this->ion_auth->messages());

				$this->logout();
			} else {

				$this->session->set_flashdata('message', $this->ion_auth->errors());

				redirect('auth/change_password', 'refresh');
			}
		}
	}



	// forgot password

	public function forgot_password()

	{

		// setting validation rules by checking whether identity is username or email

		if ($this->config->item('identity', 'ion_auth') != 'email') {

			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
		} else {

			$this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
		}





		if ($this->form_validation->run() == false) {

			$this->data['type'] = $this->config->item('identity', 'ion_auth');

			// setup the input

			$this->data['identity'] = array(
				'name' => 'identity',

				'id' => 'identity',

			);



			if ($this->config->item('identity', 'ion_auth') != 'email') {

				$this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
			} else {

				$this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
			}



			// set any errors and display the form

			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->_render_page('auth/forgot_password', $this->data);
		} else {

			$identity_column = $this->config->item('identity', 'ion_auth');

			$identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();



			if (empty($identity)) {



				if ($this->config->item('identity', 'ion_auth') != 'email') {

					$this->ion_auth->set_error('forgot_password_identity_not_found');
				} else {

					$this->ion_auth->set_error('forgot_password_email_not_found');
				}



				$this->session->set_flashdata('message', $this->ion_auth->errors());

				redirect("auth/forgot_password", 'refresh');
			}



			// run the forgotten password method to email an activation code to the user

			$forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});



			if ($forgotten) {

				// if there were no errors

				$this->session->set_flashdata('message', $this->ion_auth->messages());

				redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page

			} else {

				$this->session->set_flashdata('message', $this->ion_auth->errors());

				redirect("auth/forgot_password", 'refresh');
			}
		}
	}



	// reset password - final step for forgotten password

	public function reset_password($code = NULL)

	{

		if (!$code) {

			show_404();
		}



		$user = $this->ion_auth->forgotten_password_check($code);



		if ($user) {

			// if the code is valid then display the password reset form



			$this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');

			$this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');



			if ($this->form_validation->run() == false) {

				// display the form



				// set the flash data error message if there is one

				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');



				$this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');

				$this->data['new_password'] = array(

					'name' => 'new',

					'id'   => 'new',

					'type' => 'password',

					'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',

				);

				$this->data['new_password_confirm'] = array(

					'name'    => 'new_confirm',

					'id'      => 'new_confirm',

					'type'    => 'password',

					'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',

				);

				$this->data['user_id'] = array(

					'name'  => 'user_id',

					'id'    => 'user_id',

					'type'  => 'hidden',

					'value' => $user->id,

				);

				$this->data['csrf'] = $this->_get_csrf_nonce();

				$this->data['code'] = $code;



				// render

				$this->_render_page('auth/reset_password', $this->data);
			} else {

				// do we have a valid request?

				if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {



					// something fishy might be up

					$this->ion_auth->clear_forgotten_password_code($code);



					show_error($this->lang->line('error_csrf'));
				} else {

					// finally change the password

					$identity = $user->{$this->config->item('identity', 'ion_auth')};



					$change = $this->ion_auth->reset_password($identity, $this->input->post('new'));



					if ($change) {

						// if the password was successfully changed

						$this->session->set_flashdata('message', $this->ion_auth->messages());

						redirect("auth/login", 'refresh');
					} else {

						$this->session->set_flashdata('message', $this->ion_auth->errors());

						redirect('auth/reset_password/' . $code, 'refresh');
					}
				}
			}
		} else {

			// if the code is invalid then send them back to the forgot password page

			$this->session->set_flashdata('message', $this->ion_auth->errors());

			redirect("auth/forgot_password", 'refresh');
		}
	}





	// activate the user

	public function activate($id, $code = false)

	{

		if ($code !== false) {

			$activation = $this->ion_auth->activate($id, $code);
		} else if ($this->ion_auth->is_admin()) {

			$activation = $this->ion_auth->activate($id);
		}



		if ($activation) {

			// redirect them to the auth page

			$this->session->set_flashdata('message', $this->ion_auth->messages());

			redirect("auth", 'refresh');
		} else {

			// redirect them to the forgot password page

			$this->session->set_flashdata('message', $this->ion_auth->errors());

			redirect("auth/forgot_password", 'refresh');
		}
	}



	// deactivate the user

	public function deactivate($id = NULL)

	{

		if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {

			// redirect them to the home page because they must be an administrator to view this

			return show_error('You must be an administrator to view this page.');
		}



		$id = (int) $id;



		$this->load->library('form_validation');

		$this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');

		$this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');



		if ($this->form_validation->run() == FALSE) {

			// insert csrf check

			$this->data['csrf'] = $this->_get_csrf_nonce();

			$this->data['user'] = $this->ion_auth->user($id)->row();



			$this->_render_page('auth/deactivate_user', $this->data);
		} else {

			// do we really want to deactivate?

			if ($this->input->post('confirm') == 'yes') {

				// do we have a valid request?

				if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {

					show_error($this->lang->line('error_csrf'));
				}



				// do we have the right userlevel?

				if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin()) {

					$this->ion_auth->deactivate($id);
				}
			}



			// redirect them back to the auth page

			redirect('auth', 'refresh');
		}
	}

	public function userlogout()



	{

		$this->db->where('id', $this->session->userdata('user_id'));

		$this->db->update('users', array('online' => 0));

		$this->data['title'] = "Logout";

		// log the user out

		$logout = $this->ion_auth->logout();

		// redirect them to the login page

		$this->session->set_flashdata('message', $this->ion_auth->messages());

		redirect('/', 'refresh');
	}

	/**====================User login end========================**/



	public function admins($user_type = 1)

	{





		if (!$this->ion_auth->logged_in()) {



			redirect('auth/login', 'refresh'); // redirect them to the login page



		} else {



			// set the flash data error message if there is one





			//list the users

			$where  = array('user_type' => $user_type);

			$lmea =  $this->db->select('*')->from(TBL_USER)->where($where)->get();



			$aData['users'] = $lmea->result();











			$this->_render_page('admin_view', $aData);
		}
	}



	public function prousers()

	{





		if (!$this->ion_auth->logged_in()) {



			redirect('auth/login', 'refresh'); // redirect them to the login page



		} else {



			// set the flash data error message if there is one



			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');







			//list the users

			$where  = array('user_type' => PRO_USER);

			$data =  $this->db->select('*')->from(TBL_USER)->where($where)->get();



			$lunmera['users'] = $data->result();











			$this->_render_page('prouser_view', $lunmera);
		}
	}



	public function userlogin() // arslan



	{





		if ($this->session->userdata('userlogin') == 1) {



			echo json_encode(array('status' => 1, 'message' => lang('success')));
		} else {





			$this->form_validation->set_rules('identity', 'User Email', 'trim|required'); // emial validation



			//$this->form_validation->set_message('required', 'Pease enter your Phone No .'); 



			/*$this->form_validation->set_rules('identity', str_replace(':', '', 'Email'), 'trim|required|valid_email'); // emial validation

		

		$this->form_validation->set_message('valid_email', 'Pease enter a valid email Address .'); */

			$this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

			if ($this->form_validation->run() == true) {





				$remember = (bool) $this->input->post('remember');

				if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {







					$this->session->set_userdata('login', true);

					$this->session->set_userdata('userlogin', true);

					$this->session->set_flashdata('message', $this->ion_auth->messages());







					if (!$this->ion_auth->is_admin()) {







						$this->db->where('id', $this->session->userdata('user_id'));

						$this->db->update('users', array('online' => 1));

						echo json_encode(array('status' => 1, 'message' => lang('success')));
						exit;
					}
				} else {

					// die('herer in else');

					//$this->session->set_flashdata('message', $this->ion_auth->errors());

					$check = '';

					if ($this->ion_auth->errors() == '<p>Account is inactive</p>') {

						$check = '.<p> Check your inbox to activate it.</p>';
					}

					//echo $this->ion_auth->errors();exit;

					echo json_encode(array('status' => 0, 'message' => $this->ion_auth->errors() . $check));
					exit;
				}
			} else {



				$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

				$this->data['identity'] = array(
					'name' => 'identity',

					'id'    => 'identity',

					'type'  => 'text',

					'value' => $this->form_validation->set_value('identity'),

				);

				$this->data['password'] = array(
					'name' => 'password',

					'id'   => 'password',

					'type' => 'password',

				);

				//$this->_render_page('login', $this->data);

				echo json_encode(array('status' => 0, 'message' => validation_errors()));
				exit;
			}
		}
	}
	/**====================User login end========================**/





	// create a new user

	public function create_user()

	{

		$this->load->view('create_user_view');
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
	public function createaccount()

	{


		extract($_POST);

		//	pre($_FILES);



		$nameArray = '';

		$error = '';

		$tables = $this->config->item('tables', 'ion_auth');

		$identity_column = $this->config->item('identity', 'ion_auth');

		$this->data['identity_column'] = $identity_column;

		$this->load->library('form_validation');

		$this->form_validation->set_rules('fname', 'First Name', 'required|max_length[50]');

		$this->form_validation->set_rules('lname', 'Last Name', 'required|max_length[50]');

		$this->form_validation->set_rules('email', 'email', 'trim|required|valid_email');

		$this->form_validation->set_message('valid_email', 'Pease enter a valid email Address');  // ch


		// if ($user_type == PRO_USER) {

		// 	$this->form_validation->set_rules('phone', 'Phone', 'required|max_length[12]');

		// 	$this->form_validation->set_rules('address', 'address', 'required');
		// }
		// haris changing 16/04

		if (!isset($id) && $user_type == PRO_USER) {

			$this->form_validation->set_rules('phone', 'Phone', 'required|max_length[12]');

			$this->form_validation->set_rules('address', 'address', 'required');
		}

		if (isset($id) && !empty($id)) {



			//die('herrr in if');

			$original_value = $this->db->query("SELECT email FROM users WHERE id = " . $id)->row()->email;

			if ($this->input->post('email') != $original_value) {

				$is_unique =  '|is_unique[users.email]';
			} else {

				$is_unique =  '';
			}

			$this->form_validation->set_rules('email', 'email', 'required|valid_email' . $is_unique);
		} else {

			// just  confgiure it

			$this->form_validation->set_rules('email', 'email', 'valid_email|is_unique[' . $tables['users'] . '.email]|required');

			$this->form_validation->set_message('is_unique', 'This email address is associated with an existing account');



			$this->form_validation->set_rules('password', 'password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');
		}



		if ($user_type == '') {

			$this->form_validation->set_rules('user_type', 'user type', 'trim|required');  // ch

			$this->form_validation->set_message('user_type', 'user type missing');  // ch

		}



		if ($this->form_validation->run() == false) {

			$arr = array("status" => "validation_error", "message" => validation_errors());

			echo json_encode($arr);
		} else {

			extract($_POST);



			if ($this->form_validation->run() == true) {

				$email    = strtolower($this->input->post('email'));

				$identity = ($identity_column === 'email') ? $email : $this->input->post('identity');

				$password = $this->input->post('password');

				$activation_code = uniqid();

				$additional_data = array(

					'email' => $this->input->post('email'),
					'user_type' => $user_type,
					'name' => $fname . ' ' . $lname,
					'fname' =>  $fname,
					'lname' =>  $lname,

					'phone' => $phone, // arslan

					'activation_code' => $activation_code,

					'active' => 1,

					'referal_code' => uniqid()



				);
				$extra_data = array();
				// $change_user_msg = '';
				if (isset($id) && !empty($id) && $user_type != $check_user_type) {
					$extra_data['previous_usertype'] = $check_user_type;
					$extra_data['want_usertype'] = $user_type;
					$extra_data['userid'] = $_SESSION['user_id'];
				}

				if (isset($_POST['address'])) {

					$additional_data['address'] = $address;
				}

				if (isset($_POST['about'])) {

					$additional_data['about'] = $about;
				}

				/*--------------------------------------------------

			|Image uploading add/update

			---------------------------------------------------*/

				if (!empty($_FILES['image']['name'])) {

					$config['upload_path']          = './uploads/';

					$config['allowed_types']        = ALLOWED_TYPES;

					$config['encrypt_name'] = TRUE;

					$this->load->library('upload');

					$this->upload->initialize($config);

					if (!$this->upload->do_upload('image')) {

						$arr = array('status' => 0, 'message' => "Error " . $this->upload->display_errors());

						echo json_encode($arr);
						exit;
					} else {

						$upload_data = $this->upload->data();



						$additional_data['image'] = $upload_data['file_name'];
					}
				}

				/*===============================================*/

				if ($latitude != '' and $longitude != '') {

					$additional_data['user_type'] = $user_type;

					$additional_data['latitude'] = $latitude;

					$additional_data['longitude'] = $longitude;
				} else {

					// $this->setlatlon();
					$additional_data['user_type'] = $user_type;

					$additional_data['latitude'] = get_session('latitude');

					$additional_data['longitude'] = get_session('longitude');
				}


				//setlatlon()
				/*	if ($user_type == USER) {

					$additional_data['user_type'] = $user_type;
				}*/





				if ($error == '') {

					if (isset($id) && !empty($id)) {


						$result = $this->crud->saveRecord($id, $additional_data, TBL_USER, $extra_data);
					} else {


						$result =  $this->ion_auth->register($identity, $password, $email, $additional_data);
					}



					switch ($result) {



						case 1:



							//$arr = array('status' => 1,'message' => "Registered Successfully, check you email account for confirmation.!".$error);

							$arr = array('status' => 1, 'message' => lang('success'));

							/*	* send confirmation email **/

							$href = base_url() . 'verify/email/' . $activation_code;

							// "background:#254c33ad !important; padding:5px;

							$htmlContent = $this->setEmailTemplate($name, $href);

							$to = $email;

							$from = 'noreply@free-livebees.org';

							$from_heading = 'FLB';

							$subject = 'EMAIL VERIFICATION';

							if ($this->input->ip_address() != '127.0.0.1') {

								//$this->crud->send_smtp_email($to,$from,$from_heading,$subject,$htmlContent);

								// $this->sendemailphpmailf($to,$subject, $htmlContent ,$from );



							}

							echo json_encode($arr);



							break;



						case 2:



							$arr = array('status' => 2, 'message' => lang('success'));



							echo json_encode($arr);



							break;



						case 0:



							$arr = array('status' => 0, 'message' => lang('error'));



							echo json_encode($arr);



							break;



						default:



							$arr = array('status' => 0, 'message' => lang('error'));



							echo json_encode($arr);



							break;
					}
				} else {



					$arr = array('status' => 0, 'message' => ' ' . $error);



					echo json_encode($arr);
				}
			}
		}
	}





	public function setEmailTemplate($userName, $activationLink)
	{

		$template = '<table bgcolor="#f2f2f2" border="0" cellpadding="0" cellspacing="0" width="100%">

   <tbody>

      <tr>

         <td>

            <div style="max-width:600px;margin:0 auto;font-size:16px;line-height:24px">

               <table border="0" cellpadding="0" cellspacing="0" width="100%">

                  <tbody>

                     <tr>

                        <td>

                           <table border="0" cellpadding="0" cellspacing="0"  width="100%">

                              <tbody>

                                 <tr>

                                    <td>

                                       <table border="0" cellpadding="0" cellspacing="0" width="100%">

                                          <tbody>

                                             <tr>

                                                <td style="background-color:white;padding-top:30px;padding-bottom:30px">

                                                   <table border="0" cellpadding="0" cellspacing="0" width="100%">

                                                      <tbody>

                                                         <tr>

                                                            <td align="center" style="padding-top:0;padding-bottom:20px"> <a >

															 <img src="' . base_url() . 'assets/logo.png" alt="" width="104" height="30" style="vertical-align:middle; background:#254c33ad !important; padding:5px;" class="CToWUd"> </a> </td>

                                                         </tr>

                                                         <tr>

                                                            <td  style="font-family:Helvetica,Arial,sans-serif!important;font-size:16px;line-height:24px;word-break:break-word;padding-left:20px;padding-right:20px;padding-top:20px;padding-bottom:20px">

                                                               <h3 style="margin-top:0;margin-bottom:0;font-family:"Montserrat",Helvetica,Arial,sans-serif!important;font-weight:700;font-size:20px;line-height:30px;color:#222">Verify your email address to complete your registration</h3>

                                                            </td>

                                                         </tr>

                                                         <tr>

                                                            <td   style="font-family:Helvetica,Arial,sans-serif!important;font-size:16px;line-height:24px;word-break:break-word;padding-left:20px;padding-right:20px;padding-top:20px"> Hi ' . $userName . ', </td>

                                                         </tr>

                                                         <tr>

                                                            <td   style="font-family:Helvetica,Arial,sans-serif!important;font-size:16px;line-height:24px;word-break:break-word;padding-left:20px;padding-right:20px;padding-top:20px"> Welcome to geonest! </td>

                                                         </tr>

                                                         <tr>

                                                            <td   style="font-family:Helvetica,Arial,sans-serif!important;font-size:16px;line-height:24px;word-break:break-word;padding-left:20px;padding-right:20px;padding-top:20px"> Please verify your email address so you can get full access to qualified freelancers eager to tackle your project. </td>

                                                         </tr>

                                                         <tr>

                                                            <td   style="font-family:Helvetica,Arial,sans-serif!important;font-size:16px;line-height:24px;word-break:break-word;padding-left:20px;padding-right:20px;padding-top:20px"> We\'re thrilled to have you on board! </td>

                                                         </tr>

                                                         <tr>

                                                            <td   style="font-family:Helvetica,Arial,sans-serif!important;font-size:16px;line-height:24px;word-break:break-word;padding-left:20px;padding-right:20px;padding-top:10px">

                                                               <table border="0" cellpadding="0" cellspacing="0" width="100%">

                                                                  <tbody>

                                                                     <tr>

                                                                        <td style="font-size:0;line-height:0">&nbsp;</td>

                                                                     </tr>

                                                                  </tbody>

                                                               </table>

                                                            </td>

                                                         </tr>

                                                         <tr>

                                                            <td   style="font-family:Helvetica,Arial,sans-serif!important;font-size:16px;line-height:24px;word-break:break-word;padding-left:20px;padding-right:20px;padding-top:30px">

                                                               <table style="text-align:center" width="100%" border="0" cellspacing="0" cellpadding="0">

                                                                  <tbody>

                                                                     <tr>

                                                                        <td>

                                                                           <div style="text-align:center;margin:0 auto">  <a style="background-color:#37a000;border:2px solid #37a000;border-radius:2px;color:#ffffff;white-space:nowrap;font-weight:bold;display:block;font-family:Helvetica,Arial,sans-serif;font-size:16px;line-height:36px;text-align:center;text-decoration:none" href="' . $activationLink . '" target="_blank" >Verify Email</a> </div>

                                                                        </td>

                                                                     </tr>

                                                                  </tbody>

                                                               </table>

                                                            </td>

                                                         </tr>

                                                         <tr>

                                                            <td   style="font-family:Helvetica,Arial,sans-serif!important;font-size:16px;line-height:24px;word-break:break-word;padding-left:20px;padding-right:20px;padding-top:30px">

                                                               <div style="padding-top:10px">Thanks for your time,<br>The geonest Team</div>

                                                            </td>

                                                         </tr>

                                                      </tbody>

                                                   </table>

                                                </td>

                                             </tr>

                                          </tbody>

                                       </table>

                                    </td>

                                 </tr>

                              </tbody>

                           </table>

                        </td>

                     </tr>

                  </tbody>

               </table>

               <table border="0" cellpadding="0" cellspacing="0" width="100%">

                  <tbody>

                    <tr>

                        <td align="center" width="100%" style="color:#656565;font-size:12px;line-height:24px;padding-bottom:30px;padding-top:30px"><a href="' . base_url() . 'terms' . '" style="color:#656565;text-decoration:underline" target="_blank" >Privacy Policy</a> &nbsp; | &nbsp; <a href="' . base_url() . 'contact' . '" style="color:#656565;text-decoration:underline" target="_blank" >Contact Support</a> 

                           <div style="font-family:Helvetica,Arial,sans-serif!important;word-break:break-all" >

                              New York, Canal Road Thokar, USA

                           </div>

                           <div style="font-family:Helvetica,Arial,sans-serif!important;word-break:break-all">

                              &copy; 2019 geonest Inc.

                           </div>

                        </td>

                     </tr>

                  </tbody>

               </table>

            </div>

         </td>

      </tr>

   </tbody>

</table>';

		return $template;
	}







	/********************************************************************************************************************/

	public function save_user()

	{





		extract($_POST);

		$nameArray = '';

		$error = '';

		$tables = $this->config->item('tables', 'ion_auth');

		$identity_column = $this->config->item('identity', 'ion_auth');

		$this->data['identity_column'] = $identity_column;



		$this->load->library('form_validation');

		$this->form_validation->set_rules('name', ' name', 'trim|required');

		//$this->form_validation->set_rules('last_name', 'last name', 'trim|required');

		$this->form_validation->set_rules('email', 'email', 'trim|required');

		if (isset($user_type) and $user_type == 0) {

			$_POST['user_type'] = '';

			$this->form_validation->set_rules('user_type', 'User Type', 'required');
		}

		if (isset($id) && !empty($id)) {

			$original_value = $this->db->query("SELECT email FROM users WHERE id = " . $id)->row()->email;

			if ($this->input->post('email') != $original_value) {

				$is_unique =  '|is_unique[users.email]';
			} else {

				$is_unique =  '';
			}

			$this->form_validation->set_rules('email', 'email', 'required|valid_email' . $is_unique);
		} else {

			$this->form_validation->set_rules('email', 'email', 'valid_email|is_unique[' . $tables['users'] . '.email]|required');
		}

		if (isset($password) && !empty($password)) {

			$this->form_validation->set_rules('password', 'password', 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');

			$this->form_validation->set_rules('password_confirm', 'password_confirm', 'required');
		}

		if ($this->form_validation->run() == false) {



			$arr = array("status" => "validation_error", "message" => validation_errors());

			echo json_encode($arr);
		} else {



			extract($_POST);

			if ($this->form_validation->run() == true) {


				$email    = strtolower($this->input->post('email'));

				$identity = ($identity_column === 'email') ? $email : $this->input->post('identity');

				$password = $this->ion_auth->getForgot($this->input->post('password'));

				$additional_data = array(



					'name' => $this->input->post('name'),

					'email' => $this->input->post('email'),

					'phone' => $this->input->post('phone'),

					'mobile' => $this->input->post('mobile'),

					'added_by' => $this->session->userdata('user_id'),

					'user_type' => $this->input->post('user_type'),
					'password'=>$password
					

				);

				if (get_session('user_type') == AGENT) {

					$additional_data['user_type'] = AGENT;
				}



				if (!empty($_FILES)) {

					/*--------------------------------------------------

			|File uploading either single or multiple

			---------------------------------------------------*/

					$nameArray = $this->crud->upload_files($_FILES);

					if (strpos($nameArray, '.jpg') != false or strpos($nameArray, '.png') != false) {

						$additional_data['image'] = $nameArray;
					} else {

						$error = 'Profile pic not uploaded ' . $nameArray['upload_message'];
					}
				}

				if ($user_type == SCHOOL) {

					$redirect = base_url() . 'schools';
				} elseif ($user_type == ADMIN) {

					$redirect = base_url() . 'admins';
				} else {

					$redirect = base_url() . 'super-admins';
				}

				if (get_session('user_type') == AGENT) {

					$redirect = base_url() . 'auth/profile';
				}





				if (prelasturi() == 'profile') {

					$redirect = base_url() . 'auth/profile';
				}

				if ($error == '') {

					if (isset($id) && !empty($id)) {

                       
						$result = $this->crud->saveRecord($id, $additional_data, TBL_USER);
					} else {

						$additional_data['uniq_id'] = uniqid();

						$result =  $this->ion_auth->register($identity, $password, $email, $additional_data);
					}

					switch ($result) {

						case 1:



							$arr = array('status' => 1, 'redirect' => $redirect, 'message' => "Saved Succefully !" . $error);

							echo json_encode($arr);

							break;

						case 2:

							$arr = array('status' => 2, 'redirect' => $redirect, 'message' => "Updated successfully !" . $error);

							echo json_encode($arr);

							break;

						case 0:

							$arr = array('status' => 0, 'redirect' => $redirect, 'message' => "Not Saved!");

							echo json_encode($arr);

							break;

						default:

							$arr = array('status' => 0, 'redirect' => $redirect, 'message' => "Not Saved!");

							echo json_encode($arr);

							break;
					}
				} else {

					$arr = array('status' => 0, 'redirect' => $redirect, 'message' => ' ' . $error);

					echo json_encode($arr);
				}
			}
		}
	}



	public function profile()
	{

		$id = get_session('user_id');

		$query = $this->crud->edit($id, TBL_USER);

		$aData['row'] = $query;

		$this->load->view('create_user_view', $aData);
	}



	/*******************************/

	public function edit($id)
	{

		$query = $this->crud->edit($id, TBL_USER);

		$aData['row'] = $query;

		$this->load->view('create_user_view', $aData);
	}

	function updateProfile()
	{

		extract($_POST);



		$this->load->library('form_validation');



		$this->form_validation->set_rules('side_profile_email', 'Email', 'valid_email');

		$this->form_validation->set_rules('side_profile_name', $this->lang->line('side-profile-name'), 'required');

		$this->form_validation->set_rules('side_profile_mobile', $this->lang->line('mobile'), 'required');

		// update the password if it was posted

		if ($password != '' and $password == $password_confirm) {

			$this->form_validation->set_rules('side_profile_password', $this->lang->line('password'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');

			$this->form_validation->set_rules('side_profile_password_confirm', $this->lang->line('password confirm'), 'required');
		}



		if ($this->form_validation->run() == false) {



			$arr = array('status' => 0, 'message' => validation_errors());

			echo json_encode($arr);
		} else {



			//pre($_POST);

			$nameArr = explode(" ", $_POST['side_profile_name']);

			$first_name = $nameArr[0];

			$last_name = $nameArr[1];



			$data = array(

				'first_name' => $first_name,

				'last_name' => $last_name,

				'email' => $side_profile_email,

				'mobile' => $side_profile_mobile

			);









			// update the password if it was posted

			if ($this->input->post('side_profile_password')) {

				$data['password'] = $this->input->post('side_profile_password');
			}



			$result = $this->ion_auth->update($this->session->userdata('user_id'), $data);



			switch ($result) {

				case 1:

					$arr = array('status' => 0, 'message' => " Updated Successfully!");

					echo json_encode($arr);



					break;

				case 2:

					$arr = array('status' => 2, 'message' => "Already Exist !");

					echo json_encode($arr);

					break;

				case 0:

					$arr = array('status' => 0, 'message' => "Not Updated!");

					echo json_encode($arr);

					break;

				default:

					$arr = array('status' => 0, 'message' => "Not Updated Some thing went wrong!");

					echo json_encode($arr);

					break;
			}
		}
	}











	public function _get_csrf_nonce()

	{

		$this->load->helper('string');

		$key   = random_string('alnum', 8);

		$value = random_string('alnum', 20);

		$this->session->set_flashdata('csrfkey', $key);

		$this->session->set_flashdata('csrfvalue', $value);



		return array($key => $value);
	}



	public function _valid_csrf_nonce()

	{

		if (
			$this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&

			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')
		) {

			return TRUE;
		} else {

			return FALSE;
		}
	}



	public function _render_page($view, $data = null, $returnhtml = false) //I think this makes more sense

	{



		$this->viewdata = (empty($data)) ? $this->data : $data;



		$view_html = $this->load->view($view, $this->viewdata, $returnhtml);



		if ($returnhtml) return $view_html; //This will return html on 3rd argument being true

	}















	public function delete()
	{

		extract($_POST);





		$result = $this->ion_auth->delete_user($id);

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



	public function user_acc_setting()
	{

		//$aData['user_location'] = $this->crud_model->get_user_location($this->session->userdata('user_id'));

		$this->load->view('user_acc_setting');
	}





	function pre($data)
	{

		echo "<pre>";

		print_r($data);

		echo "</pre>";

		die('<===========>');
	}
}
