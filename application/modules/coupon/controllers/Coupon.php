<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('login')==true){
			redirect('auth/login', 'refresh');
		}
	}
	public $view = "view";
	public $tbl = 'coupon';
	
	public function index(){  

		$aData['data'] =$this->db->select('*')->from($this->tbl)->order_by("id","desc")->get();
		$this->load->view($this->view,$aData);
	}
	public function check(){  
	//pre();
	//$this->cart->update('cart_total',100);
//echo 'Total '.$this->cart->total();exit;
$_POST['status']=1;
		$data =$this->db->select('*')->from($this->tbl)->where($_POST)->get();
		if($data->num_rows()>0){
			$row=$data->row();
			$percentage=$row->amount;
			$discount = $this->cart->total()/100 * $percentage;
			
			$payable=$this->cart->total()-$discount;
			$setSession=array('discount'=>true,"discounted_price"=>$payable);
			$_SESSION['cart_contents']['cart_total']=$payable;
			$this->session->set_userdata($setSession);
			$arr = array('status' => 1,'message' => "You got discount of $".$discount." and you have to pay $".$payable);
			echo json_encode($arr);exit;
			}else{
				$arr = array('status' => 0,'message' => "Invalid coupon !");
			echo json_encode($arr);
				}
	}
	
	
	public function add(){  
		$this->load->view('save');
	}
	public function edit($id){
		$query =$this->crud->edit($id,$this->tbl);
		$aData['row']=$query;
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
		unset($_POST['action'],$_POST['id']);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('code', 'Code', 'trim|required');
		$this->form_validation->set_rules('amount', 'Percentage', 'trim|numeric|required');
		if ($this->form_validation->run()==false){
			$arr = array("status"=>"validation_error" ,"message"=> validation_errors());
			echo json_encode($arr);
		}else{
		
			$result = $this->crud->saveRecord($PrimaryID,$_POST,$this->tbl);
			
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
