<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Appcolors extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('login')==true){
			redirect('auth/login', 'refresh');
		}
	}
	public $view = "save";
	public $tbl = 'app_template';
	
	public function index(){  

		$aData['row'] =$this->db->select('*')->from($this->tbl)->where('school_id',get_session('user_id'))->order_by("id","desc")->get()->row();
		$this->load->view($this->view,$aData);
	}
	public function users_rights(){  

		$aData['data'] =$this->db->select('*')->from('users_rights')->get();
		$this->load->view('users_rights',$aData);
	}
	
	
	public function add(){  
		$this->load->view('save');
	}
	public function edit(){
		$query =$this->crud->edit(1,$this->tbl);
		$aData['row']=$query;
		$this->load->view('save',$aData);
	}
	
	public function delete(){ 
		extract($_POST);
		$result =$this->crud->delete($id,$this->tbl);
		switch($result){
			case 1:
			$catt_id=$id;
			// get product ids
			$this->db->select('id as product_id');
		$this->db->from('product');
		$this->db->where('cat_id', $catt_id);
		$data = $this->db->get();
		if ($data->num_rows()>0){
			foreach($data->result() as $pro){
				// delete from contest
				$this->db->where('product_id', $pro->product_id)->delete('contest');
			
			}
		}
			//delete from products
			$this->db->where('cat_id', $id)->delete('product');
			$arr = array('status' => 1,'message' => "Deleted Succefully !");
			echo json_encode($arr);
			break;
			case 0:
			$arr = array('status' => 0,'message' => "Not Deleted!");
			echo json_encode($arr);
			break;
			default:
			$arr = array('status' => 0,'message' => "Not Deleted!");
			echo json_encode($arr);
			break;	
		}
	}
	
	function updateUserRight(){
		$count = count($_POST['id']);
		for($i=0;$i<=$count;$i++){
			$data=array(
			'add_users'=>$_POST['add_users'][$i],
			'edit_users'=>$_POST['edit_users'][$i],
			'delete_users'=>$_POST['delete_users'][$i],
			'add_property'=>$_POST['add_property'][$i],
			'edit_property'=>$_POST['edit_property'][$i],
			'delete_property'=>$_POST['delete_property'][$i]
			);
			$this->db->where('id',$_POST['id'][$i])->update('users_rights',$data);
			
			}
			
			$arr = array('status' => 2,'message' => "Updated Succefully !");
			echo json_encode($arr);
		
		}
	function save(){ 
		extract($_POST);
		$PrimaryID = $_POST['id'];
		unset($_POST['action'],$_POST['id']);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('text_color', 'text_color', 'trim|required');
		$this->form_validation->set_rules('bg_color', 'bg_color', 'trim|required');
		if ($this->form_validation->run()==false){
			$arr = array("status"=>"validation_error" ,"message"=> validation_errors());
			echo json_encode($arr);
		}else{
			/*--------------------------------------------------
			|Image uploading add/update
			---------------------------------------------------*/
			if (isset($_FILES['logo']['name'])) {
                $info = pathinfo($_FILES['logo']['name']);
                $ext = $info['extension']; // get the extension of the file
                $newname = rand(5, 3456) * date(time()) . "." . $ext;
                $target = 'uploads/' . $newname;
                if (move_uploaded_file($_FILES['logo']['tmp_name'], $target)) {
                  $_POST['logo']=$newname;
                }
            } else {
               unset($_POST['logo']);
            }
			
			/*===============================================*/
			if (isset($_FILES['bg_image']['name'])) {
                $info = pathinfo($_FILES['bg_image']['name']);
                $ext = $info['extension']; // get the extension of the file
                $newname = rand(5, 3456) * date(time()) . "." . $ext;
                $target = 'uploads/' . $newname;
                if (move_uploaded_file($_FILES['bg_image']['tmp_name'], $target)) {
                    $_POST['bg_image']=$newname;
                }
            } else {
               unset($_POST['bg_image']);
            }
		
		
			$result = $this->crud->saveRecord(1,$_POST,$this->tbl);
			
		switch($result){
			case 1:
			$arr = array('status' => 1,'message' => "Inserted Succefully !");
			echo json_encode($arr);
			break;
			case 2:
			$arr = array('status' => 2,'message' => "Updated Succefully !");
			echo json_encode($arr);
			break;
			case 0:
			$arr = array('status' => 0,'message' => "Not Saved!");
			echo json_encode($arr);
			break;
			default:
			$arr = array('status' => 0,'message' => "Not Saved!");
			echo json_encode($arr);
			break;	
		}
	}	

	}
	



				public function update_image(){ 
	
		extract($_POST);
		$data = array();
		if (!empty($_FILES)){ 
		/*--------------------------------------------------
		|File uploading either single or multiple
		---------------------------------------------------*/
		
		$image = $this->crud->upload_files($_FILES);
		$data['image'] =$image;
		}
		else{
			$data['image'] =$edit_image_hidden;
			$image =$edit_image_hidden;
			}	
		
		//	pre($data);	
		$result =$this->crud->update_where($edit_img_id,'post_images',$data);
		/*===============================================*/
		
		switch($result){
		case 1:
			$arr = array('status' => 1,'image' => $image,'id' => $edit_img_id,'message' => "Updated Succefully !");
			echo json_encode($arr);
			break;
		case 0:
			$arr = array('status' => 0,'message' => "Not Updated!");
			echo json_encode($arr);
			break;
		default:
			$arr = array('status' => 0,'message' => "Not Updated!");
			echo json_encode($arr);
			break;	
		}
	}


	
	
}
