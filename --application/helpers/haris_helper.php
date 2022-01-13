<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


// function get_latest_data($id)
// {

// }



function last_observation_date($id)
{

	$CI = &get_instance();
	$tr = '';
	//	$date = $CI->db->query("select date from tbl_follow where nest_id=1 ORDER by id DESC LIMIT 1")->row()->date;
	$date = $CI->db->query("select date from tbl_follow where nest_id='" . $id . "' ORDER by id DESC LIMIT 1")->row()->date;
	$next_observation_date = $CI->db->query("select next_observation_date from tbl_loc where id='" . $id . "' ORDER by id DESC LIMIT 1")->row()->next_observation_date;
	//	echo $CI->db->last_query();
$date=	date('d-m-Y', strtotime($date));
$next_observation_date=	date('d-m-Y', strtotime($next_observation_date));

	if (!empty($date)) {
		$tr = '<tr><td>' . lang('observer_date') . ':</td><td>' . $date . '</td></tr>';
	}
	
	if ($next_observation_date>$date) {
		$tr = '<tr><td>' . lang('observer_date') . ':</td><td>' . $next_observation_date . '</td></tr>';
	}
	
	
	return $tr;

	// return $data;
}

function printer($arr)

{

	echo '<pre>';

	print_r($arr);

	die('<========printer called==========>');
}

// get 

function get_nest_entrance($db_val, $static_val)

{



	if ($db_val == $static_val) {



		return 'selected="selected"';
	}
}

function site_tree_fun($db_val, $static_val)

{


	if ($db_val == $static_val) {

		return 'checked="checked"';
	}
}

function get_etat_de_la_colonie($nest_id)
{



	$CI = &get_instance();

	$data = $CI->db->query("SELECT etat_de_la_colonie FROM `tbl_follow` WHERE nest_id=$nest_id ORDER BY `tbl_follow`.`id` DESC LIMIT 1")->row()->etat_de_la_colonie;

	return $data;
}

// 

function get_tbl_follow_data($nest_id)
{



	$CI = &get_instance();

	$data = $CI->db->query("SELECT date FROM `tbl_follow` WHERE nest_id=$nest_id ORDER BY `tbl_follow`.`id` DESC LIMIT 1")->row()->date;



	return $data;
}
