<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Press_release extends CI_Controller {


	  
	  function __construct()
	{
		parent::__construct();
		$this->load->library("pagination");
	}
	public $tbl='news';
	public function index(){
		$config = array();
        $config["base_url"] = base_url() . "press_release/index";
        $config["total_rows"] = getcount($this->tbl);
        $config["per_page"] = 3;
        $config["uri_segment"] = 3;
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

		$this->pagination->initialize($config);
		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		 $aData['links'] = $this->pagination->create_links();
	
		$aData['page_title'] ='Press release';
		$aData['data'] =$this->db->query("select b.*,f.file as image from ".$this->tbl."  as b left join post_images as f on f.post_id=b.id limit  ".$page." ,".$config["per_page"]."  ");
		$aData['recentPost'] =$this->db->query("select b.post_title,b.created_on,b.id from ".$this->tbl."  as b order by id desc ");
		$this->load->view('press_release',$aData);
	}
	
	public function detail($id){
		$aData['page_title'] ='Press release';
		$q =$this->db->query("select b.*,f.file as image from ".$this->tbl."  as b left join post_images as f on f.post_id=b.id  where b.id='".$id."'");
		$aData['row'] =$q->row();
		$aData['recentPost'] =$this->db->query("select b.post_title,b.created_on,b.id from ".$this->tbl."  as b order by id desc ");
		$this->load->view('press_detail',$aData);
	}
	
}
