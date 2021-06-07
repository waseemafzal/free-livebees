<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Translation extends MX_Controller
{

	public function __construct()
	{
		parent::__construct();
		if (!$this->session->userdata('login') == true) {
			redirect('auth/login', 'refresh');
		}
		if ($this->session->userdata('user_type') == PRO_USER || $this->session->userdata('user_type') == USER) {
			redirect('auth/logout', 'refresh');
		}
	}
	public $view = "view";
	public $tbl = 'trans_language';

	public function index()
	{
		$aData['categories'] = $this->db->query("SELECT * FROM tabl_language_category ")->result_array();
		$aData['data'] = $this->db->query("SELECT p.* FROM " . $this->tbl . " p ");
		if (isset($_GET['cat_id'])) {
			$aData['data'] = $this->db->query("SELECT p.* FROM " . $this->tbl . " p where cat_id=" . $_GET['cat_id']);
		}
		$this->load->view($this->view, $aData);
	}
	public function add()
	{
		$aData['categories'] = $this->db->query("SELECT * FROM tabl_language_category ")->result_array();

		$this->load->view('save', $aData);
	}
	public function edit($id)
	{
		$aData['categories'] = $this->db->query("SELECT * FROM tabl_language_category ")->result_array();

		$query = $this->crud->edit($id, $this->tbl);
		$aData['row'] = $query;
		$this->load->view('save', $aData);
	}
	public function delete()
	{
		extract($_POST);
		$result = $this->crud->delete($id, $this->tbl);
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
	function save()
	{
		$arr = array();
		extract($_POST);

		$PrimaryID = $_POST['id'];
		if (empty($PrimaryID)) {
			$exist = $this->db->where('tkey', $tkey)->get($this->tbl)->result();
			if (count($exist) > 0) {
				$arr['status'] = 100;
				$arr['message'] = 'This Key Already Used should be used Unique';
				echo json_encode($arr);
				exit;
			}
			if ($this->db->insert($this->tbl, array('tkey' => $tkey, 'cat_id' => $cat_id, 'english' => $ens, 'french' => $frs))) {
				$arr['status'] = 200;
				$arr['message'] = 'successfully Add';
			} else {
				$arr['status'] = 200;
				$arr['message'] = 'unable to add';
			}
		}
		if (!empty($PrimaryID)) {
			if ($this->db->where('id', $PrimaryID)->update($this->tbl, array('tkey' => $tkey, 'cat_id' => $cat_id, 'english' => $ens, 'french' => $frs))) {
				$arr['status'] = 200;
				$arr['message'] = 'successfully update';
			} else {
				$arr['status'] = 200;
				$arr['message'] = 'unable to update';
			}
		}

		echo json_encode($arr);
	}






	public function update_image()
	{

		extract($_POST);
		$data = array();
		if (!empty($_FILES)) {
			/*--------------------------------------------------
		|File uploading either single or multiple
		---------------------------------------------------*/

			$image = $this->crud->upload_files($_FILES);
			$data['file'] = $image;
		} else {
			$data['file'] = $edit_image_hidden;
			$image = $edit_image_hidden;
		}

		//	pre($data);	
		$result = $this->crud->update_where($edit_img_id, 'post_images', $data);
		/*===============================================*/

		switch ($result) {
			case 1:
				$arr = array('status' => 1, 'image' => $image, 'id' => $edit_img_id, 'message' => "Updated Succefully !");
				echo json_encode($arr);
				break;
			case 0:
				$arr = array('status' => 0, 'message' => "Not Updated!");
				echo json_encode($arr);
				break;
			default:
				$arr = array('status' => 0, 'message' => "Not Updated!");
				echo json_encode($arr);
				break;
		}
	}
}
