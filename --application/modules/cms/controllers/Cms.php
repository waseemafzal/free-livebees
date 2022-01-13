<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cms extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('login')==true){
			redirect('auth/login', 'refresh');
		}
	}
	public $view = "view";
	public $tbl = 'cms';
	
	public function index(){  

		$aData['data'] =$this->db->query("SELECT p.* FROM cms as p");
		$this->load->view($this->view,$aData);
	}
	public function add(){  
		$this->load->view('save');
	}
	public function edit($id){
		$query =$this->crud->edit($id,$this->tbl);
		$aData['slug']=$this->db->query("SELECT slug FROM app_routes where resource_id='".$id."'")->row()->slug;
		$aData['row']=$query;
		//pre($aData);
		$this->load->view('save',$aData);
	}
	public function delete(){ 
		extract($_POST);
		$result =$this->crud->delete($id,$this->tbl);
		switch($result){
			case 1:
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
	function save(){ 
		extract($_POST);
		$PrimaryID = $_POST['id'];
		$slugs = $_POST['slug'];
		unset($_POST['action'],$_POST['id'],$_POST['slug']);
		//$_POST['user_id'] =get_session('user_id');
		//`post_title`, `post_date`, `post_type`, `video_url`, `posted_by`
		$this->load->library('form_validation');
		$this->form_validation->set_rules('post_title', 'page content', 'trim|required');
		if ($this->form_validation->run()==false){
			$arr = array("status"=>"validation_error" ,"message"=> validation_errors());
			echo json_encode($arr);
		}else{
			
			/*echo "<pre>";
			 print_r($_FILES);
			echo "</pre>";
			die();*/
			//pre($_POST);
			/********************upload image start***********************/
		$imageName='';
		$error='';
		if(isset($_FILES['image']['name']))
		{                
			$info = pathinfo($_FILES['image']['name']);
			$ext = $info['extension']; // get the extension of the file
			$newname = rand(5,3456)*date(time()).".".$ext; 
			$target = 'uploads/'.$newname;
			if(move_uploaded_file( $_FILES['image']['tmp_name'], $target))
			{
				$_POST['post_banner'] =$newname ;
			}
		}
		//firstimage secondimage
		/*$imageName='';
		$error='';
		if(isset($_FILES['firstimage']['name']) &&  !empty($_FILES['firstimage']['name']))
		{                
			$info = pathinfo($_FILES['firstimage']['name']);
			$ext = $info['extension']; // get the extension of the file
			$newname = rand(5,3456)*date(time()).".".$ext; 
			$target = 'uploads/'.$newname;
			if(move_uploaded_file( $_FILES['firstimage']['tmp_name'], $target))
			{
				$_POST['firstimage'] =$newname ;
			}
		}
		
		
		//$imageName='';
		//$error='';
		if(isset($_FILES['secondimage']['name']) && !empty($_FILES['secondimage']['name']))
		{                
			$info = pathinfo($_FILES['secondimage']['name']);
			$ext = $info['extension']; // get the extension of the file
			$newname = rand(5,3456)*date(time()).".".$ext; 
			$target = 'uploads/'.$newname;
			if(move_uploaded_file( $_FILES['secondimage']['tmp_name'], $target))
			{
				$_POST['secondimage'] =$newname ;
			}
		}*/
		
		
		/********************upload image end***********************/
	    $result = $this->crud->saveRecord($PrimaryID,$_POST,$this->tbl);
		//	lq();
			
		switch($result){
			case 1:
			$pageID=$this->db->insert_id();
			$this->db->insert('app_routes',array('resource_id'=>$pageID,'slug'=>$slugs,'controller'=>'page/cms/'.$pageID,'type'=>'cms'));
			$arr = array('status' => 1,'message' => "Inserted Succefully !");
			echo json_encode($arr);
			break;
			case 2:
			$this->db->where(array('resource_id'=>$PrimaryID))->update('app_routes',array('slug'=>$slugs));
			
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
		$data['file'] =$image;
		}
		else{
			$data['file'] =$edit_image_hidden;
			$image =$edit_image_hidden;
			}	
		
		//	pre($data);	
		$result =$this->crud->update_where($edit_img_id,'blogpost_images',$data);
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
