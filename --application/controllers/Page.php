<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {
public $tbl_user ="users";



    function __construct()
	{
		parent::__construct();
		define('IMG',base_url().'uploads/');
	}
    public function set_lang()
	{
		// $this->session->set_userdata('lang', $_POST['lang']);
		$_SESSION['lang'] = $_POST['lang'];
		// pre($_SESSION);
		// echo $_SESSION['lang'];
		// pre($_SESSION);
		// echo $this->session->userdata('lang');
		echo $_SESSION['lang'];
	}
    
    public function privacy(){
	
		$aData['data']= $this->db->select('post_description')->where('id',2)->get('cms')->row()->post_description;
	
	   $this->load->view('cms',$aData);

	}
	public function aboutus(){
	
		$aData['data']= $this->db->select('post_description')->where('id',4)->get('cms')->row()->post_description;
	
	   $this->load->view('cms',$aData);

	}
	public function terms(){
	
		$aData['data']= $this->db->select('post_description')->where('id',3)->get('cms')->row()->post_description;
	
	   $this->load->view('cms',$aData);

	}
   
   	public function cms($id){ 
		$query =$this->crud->edit($id,'cms');
		$aData['imgdata'] =get_by_where_array(array('cms_id'=>$id),'tbl_sidebarcontent');
		$aData['row']=$query;
		$aData['meta_title']=$query->meta_title;
		$aData['meta_description']=$query->meta_description;
		$aData['meta_keyword']=$query->meta_keyword;
		$this->load->view('cms',$aData);
	}
}
