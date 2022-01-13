<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Eblogs extends CI_Controller {


	  
	  function __construct()
	{
		parent::__construct();
		$this->load->library("pagination");
	}
	public $tbl='blogpost';
	public function index(){
		$config = array();
	$config["per_page"] = 3;
        $config["uri_segment"] = 3;
	$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		
		$aData['page_title'] ='blogs';
		$aData['data'] =$this->db->query("select b.*,f.file as image from ".$this->tbl."  as b left join post_images as f on f.post_id=b.id limit  ".$page." ,".$config["per_page"]."  ");
		$cat ='';
		if(isset($_GET['query'])){
			$cat = $_GET['query'];
			$aData['data'] =$this->db->query("select b.*,f.file as image from ".$this->tbl."  as b left join post_images as f on f.post_id=b.id
			where b.category='".$cat."'
			 limit  ".$page." ,".$config["per_page"]."  ");
		
			}
		
		$aData['recentPost'] =$this->db->query("select b.post_title,b.created_on,b.id from ".$this->tbl."  as b order by id desc");
		
					
        $config["base_url"] = base_url() . "eblogs/index";
       
        
		$config['full_tag_open'] = "<ul class='pagination'>";
$config['full_tag_close'] ="</ul>";
$config['num_tag_open'] = '<li>';
$config['num_tag_close'] = '</li>';
$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
$config['next_tag_open'] = "<li>";
$config['next_tagl_close'] = "</li>";
$config['prev_tag_open'] = "<li>";
$config['prev_tagl_close'] = "</li>";
$config['first_tag_open'] = "<li>";
$config['first_tagl_close'] = "</li>";
$config['last_tag_open'] = "<li>";
$config['last_tagl_close'] = "</li>";
 $config["total_rows"] = getcount('blogpost');
		$this->pagination->initialize($config);
		 $aData['links'] = $this->pagination->create_links();
		$this->load->view('blogs',$aData);
	}
	
	public function detail($id){
		$aData['page_title'] ='blog detail';
	$q =$this->db->query("select b.*,f.file as image from ".$this->tbl."  as b left join post_images as f on f.post_id=b.id  where b.id='".$id."'");
		$aData['row'] =$q->row();
		$aData['comments'] =$this->db->query("SELECT p.* FROM blogpost_comments p where p.blog_id='".$id."' and status=1");
		
		$aData['recentPost'] =$this->db->query("select b.post_title,b.created_on,b.id from ".$this->tbl."  as b order by id desc ");
		$this->load->view('blogs-detail',$aData);
	}
	
	
	
		function saveComment(){ 
		extract($_POST);
		
		
		if($saved==true){
setcookie("cppexuser", $name, time() + (86400 * 90), "/");
setcookie("cppexemail", $email, time() + (86400 * 90), "/");
			}
			unset($_POST['submit'],$_POST['saved'],$_POST['id']);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'name', 'trim|required');
		$this->form_validation->set_rules('email', 'email', 'trim|required');
		$this->form_validation->set_rules('body', 'comment', 'trim|required');
		if ($this->form_validation->run()==false){
			$arr = array("status"=>"validation_error" ,"message"=> validation_errors());
			echo json_encode($arr);
		}else{
				
			$result = $this->crud->saveRecord('',$_POST,'blogpost_comments');
			
			
		switch($result){
			case 1:
			$arr = array('status' => 1,'message' => "Thanks for your comment, it will publish after approval !");
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

	
	
}
