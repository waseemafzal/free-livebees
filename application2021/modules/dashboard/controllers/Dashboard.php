<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Dashboard extends MX_Controller
{



	public function __construct()
	{

		parent::__construct();

		if (!$this->session->userdata('login') == true) {

			redirect('auth/login', 'refresh');
		}
		if ($this->session->userdata('user_type') != 1) {

			redirect('auth/login', 'refresh');
		}

		$this->load->library("pagination");
	}



	public $tbl = 'activity_feed';

	public $tbl_invites = 'invites';



	public function index()

	{

		/*$whereArr=array('school_id'=>get_session('user_id'));

	$config = array();

        $config["base_url"] = base_url() . "feed/index";

        $config["total_rows"] = getcount($this->tbl);

        $config["per_page"] = 20;

        $config["uri_segment"] = 3;

		$this->pagination->initialize($config);



        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		$data = $this->fetch_feed($config["per_page"], $page,$whereArr);

        $aData['links'] = $this->pagination->create_links();

		*/

		// $aData['data'] =$data;

		//$this->load->view('index',$aData);

		$this->load->view('index');
	}



	public function fetch_feed($limit, $start, $whereArray)
	{

		$this->db->limit($limit, $start);

		if (isset($_GET['activity_type']) and !empty($_GET['activity_type'])) {

			$whereArray['activity_type_id'] = $_GET['activity_type'];
		}



		$this->db->select("f.id as feed_id,f.title,f.posted_date,f.post_type,type.title as activity_type,i.file,u.name as teacher_name,u.image as teacher_image")

			->join('activity_types as type', 'type.id=f.activity_type_id')

			->join('activity_feed_images as i', 'i.feed_id=f.id')

			->join('users as u', 'u.id=f.user_id')

			/*->where($whereArray)*/

			->order_by('f.id', 'DESC');

		if (isset($_GET['posted_date']) and !empty($_GET['posted_date'])) {

			$this->db->like('posted_date', $_GET['posted_date']);
		}





		$query = $this->db->get($this->tbl . ' as f');



		//lq();

		if ($query->num_rows() > 0) {



			return $query;
		}

		return false;
	}
}
