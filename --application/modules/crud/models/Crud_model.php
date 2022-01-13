<?php

class Crud_Model extends CI_model
{

	function __construct()

	{



		parent::__construct();
	}



	public function orderStatusTitle($id)
	{



		if ($id == RQ_PENDING) {

			$status = 'PENDING';
		} elseif ($id == RQ_ACCEPTED) {

			$status = 'ACCEPTED';
		} elseif ($id == RQ_CANCELLED_BY_DRIVER) {

			$status = 'CANCELLED BY DRIVER';
		} elseif ($id == RQ_CANCELLED_BY_CUSTOMER) {

			$status = 'CANCELLED BY CUSTOMER';
		} elseif ($id == RQ_COMPLETED) {

			$status = 'COMPLETED';
		} else {

			$status = 'PENDING';
		}

		return $status;
	}

	public function getPems($userType)
	{

		$row = $this->db->select('*')->from('app_setting')->get()->row();

		$response = array();



		if ($userType == CUSTOMER) {

			if ($row->production_customer == 1) {

				// return production or live pems file

				$response['certificate'] = 'pem/' . $row->customer_pems_file;

				$response['notificationUrl'] = 'ssl://gateway.push.apple.com:2195';
			}

			if ($row->production_customer == 0) {

				$response['certificate'] = 'pem/' . $row->customer_pems_file_dev;

				$response['notificationUrl'] = 'ssl://gateway.sandbox.push.apple.com:2195';
			}
		}

		if ($userType == DRIVER) {

			if ($row->production_driver == 1) {

				// return production or live pems file

				$response['certificate'] = 'pem/' . $row->driver_pems_file;

				$response['notificationUrl'] = 'ssl://gateway.push.apple.com:2195';
			}

			if ($row->production_driver == 0) {

				$response['certificate'] = 'pem/' . $row->driver_pems_file_dev;

				$response['notificationUrl'] = 'ssl://gateway.sandbox.push.apple.com:2195';
			}
		}



		return $response;
	}

	/******************** ios noitifcation start****************************/

	function send_ios_notification($deviceToken, $message, $userType)
	{

		$response = array();

		$passphrase = '1234';

		$res = $this->getPems($userType);

		//pre($res);

		$ctx = stream_context_create();

		$notificationUrl = $res['notificationUrl'];

		$certificate = $res['certificate'];

		stream_context_set_option($ctx, 'ssl', 'local_cert', $certificate);

		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);





		//$notificationUrl = 'ssl://gateway.push.apple.com:2195';

		// Open a connection to the APNS server

		$fp = stream_socket_client(

			$notificationUrl,
			$err,

			$errstr,
			60,
			STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT,
			$ctx
		);



		if (!$fp)

			exit("Failed to connect: $err $errstr" . PHP_EOL);



		$response['connection'] = 'Connected to APNS' . PHP_EOL;



		// Create the payload body

		$body['aps'] = array(

			'alert' => $message,

			'sound' => 'default'

		);



		// Encode the payload as JSON

		$payload = json_encode($body);



		// Build the binary notification

		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;



		// Send it to the server

		$result = fwrite($fp, $msg, strlen($msg));





		if (!$result) {

			//   $response['notification']='Message not delivered' . PHP_EOL;

			// return 0;exit;

		} else {

			// $response['notification'] ='Message successfully delivered' . PHP_EOL;



			// return 1;exit;

		}

		// Close the connection to the server

		fclose($fp);

		// return $response;

	}



	/************send android push notificattion**********************/



	function send_android_notification($push_id, $message)
	{



		$registrationIds = array($push_id);



		// prep the bundle 

		$msg = array(
			'title'		=> 'VAAVROOM',

			'message'	=> $message,

			'vibrate'	=> 1,

			'sound'		=> 1

		);

		$fields = array(

			'registration_ids' 	=> $registrationIds,

			'data'			=> $msg

		);



		$headers = array(

			'Authorization: key=' . API_ACCESS_KEY,

			'Content-Type: application/json'

		);



		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');

		curl_setopt($ch, CURLOPT_POST, true);

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

		$result = curl_exec($ch);

		curl_close($ch);





		return $result;
	}





	/******************************************************************/









	public function send_smtp_email($to, $from, $from_heading, $subject, $htmlContent)
	{

		//Load email library

		$this->load->library('email');

		//SMTP & mail configuration {O~8idwV(a^L

		$config = array(

			'protocol'  => 'smtp',

			'smtp_host' => 'ssl://mail.free-livebees.org',

			'smtp_port' => 465,

			'smtp_user' => 'noreply@free-livebees.org',

			'smtp_pass' => 'blI[mpB@t4&M',

			'mailtype'  => 'html',

			'charset'   => 'utf-8'

		);
$config['charset'] = 'utf-8';
$config['wordwrap'] = TRUE;
$config['mailtype'] = 'html';
		$this->email->initialize($config);

		$this->email->set_newline("\r\n");
		//Email content

		$this->email->to($to);

		$this->email->from('noreply@free-livebees.org', $from_heading);

		$this->email->subject($subject);

		$this->email->message($htmlContent);

		//Send email

		if ($this->email->send()) {

			return 1;
		} else {
			echo $this->email->print_debugger();
			exit;
			//return 0;
		}
	}



	function send_mail($to, $from, $from_heading, $subject, $htmlContent)
	{

		// $arr['to'] = $to;
		// $arr['from'] = $from;
		// $arr['headng'] = $from_heading;
		// $arr['subject'] = $subject;
		// $arr['htmlContent'] = $htmlContent;
		// pre($arr);


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

			//return 0;
			echo $this->email->print_debugger();
			exit;
		}
	}



	public function saveRecord($id, $data_array, $table, $extra_data = '')
	{


		if (!empty($id)) {

			$ql = $this->db->select('id')->from($table)->where('id', $id)->get();



			if ($ql->num_rows() > 0) {

				// if id exist then update

				$this->db->where('id', $id);

				$result = $this->db->update($table, $data_array);
				if (!empty($extra_data)) {

					// haris
					// $to = $data_array['email'];
					// $from = APP_EMAIL;
					// $from_heading = FROM_HEADING;
					// $subject = "User Type Request";
					// $htmlContent = "Votre demande de changement de type d'utilisateur a été envoyée à l'administrateur.";
					// $this->send_smtp_email($to, $from, $from_heading, $subject, $htmlContent);
					// $to = $data_array['email'];
					// $subject = "User Type Change Message";
					// $message = "Your request for change the user type has been sent to Admin";
					// $headers = "From:" . APP_EMAIL;

					// mail($to, $subject, $message, $headers);

					$to = 'support@free-livebees.org';
					$subject = lang('subject_msg');
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

					$headers .= "From:" . APP_EMAIL;
					$p_user = '';
					$w_user = '';
					if ($extra_data['previous_usertype'] == 3) {
						$p_user = lang('referent');
					} elseif ($extra_data['previous_usertype'] == 4) {
						$p_user = lang('particular');
					} else {
						$p_user = lang('Institution');
					}

					if ($extra_data['want_usertype'] == 3) {
						$w_user = lang('referent');
					} elseif ($extra_data['want_usertype'] == 4) {
						$w_user = lang('particular');
					} else {
						$w_user = lang('Institution');
					}


					$message = $data_array['fname'] . $data_array['lname'] . " " . lang('msg_mail') . " " . $p_user . " to " . $w_user . ' . ';
					$message .= lang('block_mail_msg') . " " . "<div><a style='text-decoration:none;color:black;' href=" . base_url() . 'map/reject_user_type/' . $id . '/' . $extra_data['previous_usertype'] . '/' . $extra_data['want_usertype'] . "><button style='cursor:pointer;background-color:yellow; color:black;padding:5px 15px;'>" . lang('block_label_msg') . "</button></a>";




					mail($to, $subject, $message, $headers);


					//$this->db->insert('tbl_usertype', $extra_data);
				}

				if (get_session('user_type') != 1) {
					$this->session->set_userdata('user_type', $data_array['user_type']);
				}

				//echo $this->db->last_query(); die;

				if ($result) {

					return 2;
				}
			}
		} else {



			// add new record

			//	echo $table;pre($data_array);

			$dbExi = $this->db->insert($table, $data_array);

			//	echo $this->db->_error_message();die();

			$result = 0;

			if ($dbExi) {

				$result = 1;
			}
		}

		return  $result;
	}

	public function save($data_array, $table, $uniqueField, $uniqueVal)

	{

		$query = $this->db->select('*')->from($table)->where($uniqueField, $uniqueVal)->get();





		if ($query->num_rows() > 0) {

			$result = 2;
		} else {



			$dbExi = $this->db->insert($table, $data_array);

			$result = 0;

			if ($dbExi) {

				$result = 1;
			}
		}

		return  $result;
	}



	public 	function get($table)

	{

		$this->db->select('*');

		$this->db->from($table);

		$data = $this->db->get();

		if ($data->num_rows() > 0) {

			return $data;
		} else {

			return 0;
		}
	}

	function getData($fileds, $where, $table)
	{

		$response = array();

		$response['status'] = 1;

		$response['object'] = array();

		if ($fileds == '') {

			$fileds = '*';
		}

		if (is_array($where) and !empty($where)) {

			$data = $this->db->select($fileds)->where($where)->get($table);
		} else {

			$data = $this->db->select($fileds)->get($table);
		}



		if ($data->num_rows() > 0) {

			$response['message'] = 'Record founds';

			$response['total_record'] = $data->num_rows();

			foreach ($data->result() as $row) {

				if (isset($row->image)) {

					$row->image = base_url() . 'uploads/' . $row->image;
				}

				$response['object'][] = $row;
			}
		} else {

			$response['status'] = 0;

			$response['message'] = 'no record found';

			$response['object'] = array();
		}

		return $response;
	}



	public 	function get_by_user($table)
	{

		$this->db->select('*');

		$this->db->from($table);

		$this->db->where('user_id', $this->session->userdata('user_id'));

		$data = $this->db->get();

		if ($data->num_rows() > 0) {

			return $data;
		} else {

			return 0;
		}
	}









	public  function deleteTargetByCol($id, $table, $col)

	{

		//echo $id. ' ' .$table;die('L');

		$this->db->where($col, $id);

		$result = $this->db->delete($table);



		if ($result) {

			return 1;
		} else {

			return 0;
		}
	}





	public  function delete($id, $table)

	{

		//echo $id. ' ' .$table;die('L');

		$this->db->where('id', $id);

		$result = $this->db->delete($table);

		//	$this->pq();

		if ($result) {

			return 1;
		} else {

			return 0;
		}
	}



	public function edit($id, $table)
	{

		$this->db->select('*');

		$this->db->from($table);

		$this->db->where("id", $id);

		$data = $this->db->get();



		if ($data->num_rows() > 0) {

			return $data->row();
		} else {

			return 0;
		}
	}





	public function checkdupliction($table, $column, $value, $acase = false)
	{



		if (is_array($value) and count($value) > 0) {

			foreach ($value as $key => $value) {

				$arr[] = "'" . $value . "'";
			}

			$stringtosearch =  implode(',', $arr);
		} else {



			$stringtosearch =  "'" . $value . "'";
		}



		$AND = '';

		if (is_array($acase)) {

			$AND = 'AND  id !=' . $acase['id'];;
		}



		$sql = "SELECT id FROM " . $table . " WHERE " . $column . " IN (" . $stringtosearch . ") " . $AND;

		// die();

		$data = $this->db->query($sql);

		if ($data->num_rows() > 0) {

			return count($data->row());
		} else {

			return 0;
		}
	}



	public function get_user_info($id)
	{

		$this->db->select('id,name,username,email,image,user_type,active');

		$this->db->from(TBL_USER);

		$this->db->where("id", $id);

		$data = $this->db->get();



		if ($data->num_rows() > 0) {

			return $data->row();
		} else {

			return 0;
		}
	}



	public function changeStatus($id, $tblName, $status)
	{



		$data = array('status' => $status);

		$this->db->where("id", $id);

		$result = $this->db->update($tblName, $data);

		if ($result) {

			return 1;
		} else {

			return 0;
		}
	}

	public function changeFieldStatus($id, $tblName, $status)
	{



		$data = array('validated' => $status);

		$this->db->where("id", $id);

		$result = $this->db->update($tblName, $data);

		if ($result) {

			return 1;
		} else {

			return 0;
		}
	}





	public function changeUserStatus($id, $tblName, $status)
	{

		if ($status == 0) {

			$status = 1;
		} else if ($status == 1) {

			$status = 0;
		} else {

			$status = 0;
		}

		$data = array('active' => $status);

		$this->db->where('id', $id);

		$result = $this->db->update($tblName, $data);

		if ($result) {

			return 1;
		} else {

			return 0;
		}
	}



	public  function update($id, $data_array, $table, $uniqueField, $uniqueVal)

	{



		$sql = "SELECT * FROM " . $table . " WHERE " . $uniqueField . "='" . $uniqueVal . "' ";

		$data = $this->db->query($sql);

		if ($data->num_rows() > 0) {



			if ($data->row()->id != $id) {

				$result = 2;
			} else {

				$this->db->where('id', $id);

				$result = $this->db->update($table, $data_array);
			}
		} else {

			$this->db->where('id', $id);

			$result = $this->db->update($table, $data_array);

			if ($result) {

				$result = 1;
			} else {

				$result = 0;
			}
		}



		return $result;
	}



	public function insert($table, $data_array)
	{

		$dbExi = $this->db->insert($table, $data_array);

		if ($dbExi) {

			return  TRUE;
		} else {

			return  FALSE;
		}
	}



	public function insert_get_insert_id($table, $data_array)
	{

		$dbExi = $this->db->insert($table, $data_array);

		if ($dbExi) {

			return   $this->db->insert_id();
		} else {

			return  FALSE;
		}
	}





	public  function update_where($id, $table, $data_array)
	{

		//echo '$id '. $id .'$table '. $table . '$data_array ' ; pre($data_array);

		$this->db->where('id', $id);

		$result = $this->db->update($table, $data_array);

		//echo $this->db->last_query(); die('?');

		if ($result)

			return  1;

		else

			return  0;
	}

	public  function update_where_specific_field($field, $field_value, $table, $data_array)
	{



		//echo '$id '. $id .'$table '. $table . '$data_array ' ; pre($data_array);

		$this->db->where($field, $field_value);

		$result = $this->db->update($table, $data_array);

		if ($result)

			return  1;

		else

			return  0;
	}

	public function get_user_location($id)
	{

		$sql = "SELECT * FROM " . TBL_USERS_LOCATION . "  WHERE user_id='" . $id . "'";

		$data = $this->db->query($sql);

		if ($data->num_rows() > 0) {

			return $data->row();
		} else {

			return 0;
		}
	}

	public function set_language($code)
	{

		$title = "title_" . $code . " as title";

		$sql = "SELECT id, " . $title . ", constant as cons FROM " . TBL_COUNTRIES_LANGUAGES . " ";



		$data = $this->db->query($sql);

		if ($data->num_rows() > 0) {

			$this->session->set_userdata('lang_code', $code);



			foreach ($data->result() as $row) {

				$this->session->set_userdata($row->cons, $row->title);
			} // loop end



			return TRUE;
		} else {

			return FALSE;
		}
	}





	public function get_last_record($table)
	{

		$query = $this->db->query("SELECT * FROM " . $table . " ORDER BY id DESC LIMIT 1");

		$result = $query->result_array();

		return $result;
	}



	public  function delAll($idArray, $table)

	{

		//pre($idArray);

		$idArray = explode(',', $idArray);

		for ($i = 0; $i < count($idArray); $i++) {

			$this->db->where_in('id', $idArray[$i]);

			$result = $this->db->delete($table);
		}



		if ($result) {

			return 1;
		} else {

			return 0;
		}
	}

	public function set_permission($id)
	{

		//$data = get_where($id,TBL_USERS_LEVELS); // this function available in helpers/admin_main_helper.php

		//$data =$this->db->select('*')->from(TBL_USERS_LEVELS)->where('id',$id);

		$row = $this->db->select('*')->from(TBL_USERS_LEVELS)->where("id", $id)->get()->result_array();

		if ($this->session->set_userdata('permission', $row[0])) {

			return TRUE;
		} else {

			return FALSE;
		}
	}



	public function getSchoolName($id)
	{



		return 	$this->db->select('name as school_name')->where('id', $id)->get(TBL_USER)->row()->school_name;
	}

	public	function get_data($thisfields, $table, $field, $val)

	{

		$select =  $thisfields;

		if (empty($select)) {

			$select = '*';
		} else {

			$select =  $thisfields;
		}

		if (isset($field) and !empty($field) and isset($val) and !empty($val)) {

			$this->db->select($select)->from($table)->where($field, $val);
		} else {

			$this->db->select($select)->from($table);
		}

		$data = $this->db->get();

		if ($data->num_rows() > 0) {

			return $data->result();
		} else {

			return 0;
		}
	}



	function DuplicateMySQLRecord($table, $primary_key_field, $primary_key_val)

	{

		/* generate the select query */

		$this->db->where($primary_key_field, $primary_key_val);

		$query = $this->db->get($table);



		foreach ($query->result() as $row) {

			foreach ($row as $key => $val) {

				if ($key == 'unique_id_number') {

					//  echo $key .' ' .$val ;

					$val = preg_replace('/\d/', '', $val);



					$uniqueID = get_unused_id($table, 'unique_id_number');

					$val = $val . $uniqueID;
				}

				if ($key != $primary_key_field) {

					/* $this->db->set can be used instead of passing a data array directly to the insert or update functions */

					$this->db->set($key, $val);
				} //endif              

			} //endforeach

		} //endforeach



		/* insert the new record into table*/

		return $this->db->insert($table);
	}







	/**************************************************************************************************************/

	public function upload_files($FILES)
	{



		$config['upload_path'] = './uploads';

		$config['allowed_types'] = ALLOWED_TYPES;

		$config['encrypt_name'] = TRUE;

		$this->load->library('upload');



		$files           = $FILES;

		$number_of_files = count($_FILES['file']['name']);

		$errors = 0;



		// codeigniter upload just support one file

		// to upload. so we need a litte trick

		for ($i = 0; $i < $number_of_files; $i++) {

			$_FILES['file']['name'] = $files['file']['name'][$i];

			$_FILES['file']['type'] = $files['file']['type'][$i];

			$_FILES['file']['tmp_name'] = $files['file']['tmp_name'][$i];

			$_FILES['file']['error'] = $files['file']['error'][$i];

			$_FILES['file']['size'] = $files['file']['size'][$i];



			// we have to initialize before upload

			$this->upload->initialize($config);



			if (!$this->upload->do_upload("file")) {

				$errors++;
			}

			$upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.

			$fileName = $upload_data['file_name'];

			// create thumbnail 

			$this->_createThumbnail($fileName);

			// $this->addWatermark($fileName);

			$images[] = $fileName;
		}



		if ($errors > 0) {

			return array('upload_status' => 0, 'upload_message' => "File not uploaded" . $this->upload->display_errors());
		} else {

			$fileName = implode(',', $images);

			return $fileName;
		}

		//pre($this->upload->data());





	}



	function addWatermark($file_name)
	{

		$config = array();

		$config['image_library'] = 'GD2';

		$config['source_image']  = './uploads/' . $file_name;

		$config['wm_type']       = 'overlay';

		$config['wm_opacity'] = '80';

		$config['wm_vrt_alignment'] = 'bottom';

		$config['wm_hor_alignment'] = 'right';

		$config['wm_overlay_path'] = './assets/logo.png';

		$this->load->library('image_lib', $config);

		$this->image_lib->initialize($config);

		$this->image_lib->watermark();
	}



	public function upload_files2($FILES)
	{



		$config['upload_path'] = './uploads';

		$config['allowed_types'] = ALLOWED_TYPES;

		$config['encrypt_name'] = TRUE;

		$this->load->library('upload');



		$files           = $FILES;

		$number_of_files = count($_FILES['image']['name']);

		$errors = 0;



		// codeigniter upload just support one file

		// to upload. so we need a litte trick

		for ($i = 0; $i < $number_of_files; $i++) {

			$_FILES['image']['name'] = $files['image']['name'][$i];

			$_FILES['image']['type'] = $files['image']['type'][$i];

			$_FILES['image']['tmp_name'] = $files['image']['tmp_name'][$i];

			$_FILES['image']['error'] = $files['image']['error'][$i];

			$_FILES['image']['size'] = $files['image']['size'][$i];



			// we have to initialize before upload

			$this->upload->initialize($config);



			if (!$this->upload->do_upload("image")) {

				$errors++;
			}

			$upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.

			$fileName = $upload_data['file_name'];

			// create thumbnail 

			$this->_createThumbnail($fileName);

			$images[] = $fileName;
		}

		$fileName = implode(',', $images);

		if ($errors > 0) {

			echo $errors . "File(s) cannot be uploaded";
		}

		//pre($this->upload->data());

		return $fileName;
	}

	public function upload_pdf_files($FILES)
	{



		$config['upload_path'] = './uploads';

		$config['allowed_types'] = 'pdf';

		$config['encrypt_name'] = TRUE;

		$this->load->library('upload');



		$files           = $FILES;

		$number_of_files = count($_FILES['image']['name']);

		$errors = 0;



		// codeigniter upload just support one file

		// to upload. so we need a litte trick

		for ($i = 0; $i < $number_of_files; $i++) {

			$_FILES['file']['name'] = $files['image']['name'][$i];

			$_FILES['file']['type'] = $files['image']['type'][$i];

			$_FILES['file']['tmp_name'] = $files['image']['tmp_name'][$i];

			$_FILES['file']['error'] = $files['image']['error'][$i];

			$_FILES['file']['size'] = $files['image']['size'][$i];



			// we have to initialize before upload

			$this->upload->initialize($config);



			if (!$this->upload->do_upload("image")) {

				$errors++;
			}

			$upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.

			$fileName = $upload_data['file_name'];

			// create thumbnail 

			//	 $this->_createThumbnail($fileName);

			$images[] = $fileName;
		}

		$fileName = implode(',', $images);

		if ($errors > 0) {

			echo $errors . "File(s) cannot be uploaded" . $this->upload->data();
		}

		//	pre($this->upload->data());

		return $fileName;
	}



	/******************************************************************************************************************************/

	//Create Thumbnail function

	function _createThumbnail($filename)

	{

		$this->load->library('image_lib');

		// Set your config up

		$config['image_library']    = "gd2";

		$config['allowed_types'] = ALLOWED_TYPES;

		$config['source_image']     = "uploads/" . $filename;

		$config['create_thumb']     = TRUE;

		$config['maintain_ratio']   = FALSE;

		$config['width'] = "100";

		$config['height'] = "100";



		$this->image_lib->initialize($config);

		// Do your manipulation



		if (!$this->image_lib->resize()) {

			echo $this->image_lib->display_errors();
		}

		$this->image_lib->clear();
	}



	function createThumbnailByLength($filename, $length = 100)

	{

		$this->load->library('image_lib');

		// Set your config up

		$config['image_library']    = "gd2";

		$config['allowed_types'] = ALLOWED_TYPES;

		$config['source_image']     = "uploads/" . $filename;

		$config['create_thumb']     = TRUE;

		$config['maintain_ratio']   = FALSE;

		$config['width'] = $length;

		$config['height'] = $length;



		$this->image_lib->initialize($config);

		// Do your manipulation



		if (!$this->image_lib->resize()) {

			echo $this->image_lib->display_errors();
		}

		$this->image_lib->clear();
	}





	function extract_coordinates($address)
	{

		$result = array();

		if ($address != '') {

			$api_key = 'AIzaSyCzfWLHgFNaUiwqWhPQsoVB97kgQjPx1XM';

			$address = urlencode($address);

			$get_file_data =  file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=" . $address . "&key=" . $api_key);

			$decoded_get_file_data = json_decode($get_file_data);

			if ($decoded_get_file_data->status == 'OK') {

				if (isset($decoded_get_file_data->results[0]->geometry->location)) {

					$lat = $decoded_get_file_data->results[0]->geometry->location->lat;

					$lng = $decoded_get_file_data->results[0]->geometry->location->lng;

					$result = array('lat' => $lat, 'lng' => $lng);
				}
			}
		}



		return $result;
	}













	/*******************************************************************************************************/









	function pq()
	{

		echo $this->db->last_query();

		die(' <=====Last query exe======> ');
	}

	/*******end of crud_model.php Location application\modules\crud\controllers*******/
}
