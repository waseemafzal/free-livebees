<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SendNotification extends MX_Controller {
	
	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('login')==true){
			redirect('auth/login', 'refresh');
		}
		define('API_ACCESS_KEY_PARENT','AAAAWefZ6cU:APA91bHLCLACUTvucjQw9hKSgH_9DTYqjqKzLcM3HYv0r-JTjOCh5is4Eg9EPOF-Kho0KAEinhX3YYudZV2l18vtHLFOdjKJ930h65saw5Ua8PrcioKtKpHfoonTLOXntVpuky4PkebK');
		define('API_ACCESS_KEY_TEACHER','AAAAItZmnB0:APA91bGBYuhjI1zFeh6NAPScedW222hjrAsDJozWAcovNPILXNPcpCUqAafOHdY3VC7jE-NTSiGQGoNY1EpuLYhCnkdCWzqfuJfdhFmK1xWRpt2SHdpFvZ9PyuOY42MX5Fv9P4MyGX2W');
	 
	}
	public $view = "view";
	public $tbl = 'notifications';
	
	public function index(){  
//pre($this->session);
		$aData['data'] =$this->db->select('*')->from('studentparent')->where(array('school_id'=>get_session('user_id')))->get();
		$this->load->view($this->view,$aData);
	}
	function send(){ 
		extract($_POST);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('description', 'description', 'trim|required');
		if ($this->form_validation->run()==false){
			$arr = array("status"=>"validation_error" ,"message"=> validation_errors());
			echo json_encode($arr);
		}else{
			
			$result=1;
		//	pre($_POST);
			$devices=implode(',',$_POST['device_ids']);
			$message=$description;
		$notiResponse = $this->send_android_parent_notification($_POST['device_ids'], $message,'normal');
			
			
		switch($result){
			case 1:
			$arr = array('status' => 1,'notiResponse' => $notiResponse,'message' => "Sent Succefully !".$notiResponse);
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
	

public function  testNotification(){
extract($_POST);
    
	// My message
$title='Monterssori International';

$deviceToken[] = 'eOPH0mpxy7w:APA91bG5Oc3Qai343ziTqCCQsxW22uaEfB7LIguIDZpGYNtbp1Rcd5TrGFrcb9gsqChzpJVGSc5HKGeqGrFiu504RfbV0jXe8L3bCuG4MNoVYyCHMMs3gKBnP4ByD5YBritIrA3OcC_N';


//$notification = array('title' =>$title , 'text' => $message);;
$message='Test Notification  By waseem';
$response=$this->send_teacher_notification($deviceToken,$message,'normal');
echo json_encode($response);
}	




/************send  push notificattion**********************/
function send_teacher_notification($push_id,$message,$type='text'){
if($type=='message'){
    $type='text';
}
if(!is_array($push_id)){
$registrationIds = array($push_id);
}else{
    $registrationIds = $push_id;
}
$data='';
// prep the bundle 
if(is_array($message)){
   $data =  $message;
}else{
    $data = array
(	'title'		=> 'Monterssori International',
	'message'	=> $message,
	'type'	=> $type,
	'vibrate'	=> 1
	
); 
}



$fields = array
(
	'registration_ids' 	=> $registrationIds,
	'data'			=> $data
);
 //pre($fields);
$headers = array
(
	'Authorization:key='.API_ACCESS_KEY_TEACHER,
	'Content-Type:application/json'
);
 
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );
return $result;
	}




/************send  push notificattion**********************/
function send_android_parent_notification($push_id,$message,$type='normal'){
if($type=='message'){
    $type='text';
}
if(!is_array($push_id)){
$registrationIds = array($push_id);
}else{
    $registrationIds = $push_id;
}
$data='';
// prep the bundle 
if(is_array($message)){
   $data =  $message;
}else{
    $data = array
(	'title'		=> 'Monterssori International',
	'message'	=> $message,
	'type'	=> $type,
	'vibrate'	=> 1
	
); 
}



$fields = array
(
	'registration_ids' 	=> $registrationIds,
	'data'			=> $data
);
 //pre($fields);
$headers = array
(
	'Authorization:key='.API_ACCESS_KEY_PARENT,
	'Content-Type:application/json'
);
 
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );
return $result;
	}

/******************************************************************/





	function sendNotification($include_player_ids,$title='Childcare App',$data){
    $content = array(
        "en" => $title
        );
if(!is_array($include_player_ids)){
	$include_player_ids =array($include_player_ids);
}
//'included_segments' => array('All'),
    $fields = array(
        'app_id' => "030094ec-b793-4874-9f03-8337245b5109",
		 'include_player_ids' => $include_player_ids,
		 'data' => $data,
        'large_icon' =>"ic_launcher_round.png",
        'contents' => $content
    );
//pre($fields);
    $fields = json_encode($fields);


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                               'Authorization: Basic ODZiM2VhYjQtY2FjMi00NzE1LThkNGQtM2Y2Yjc5OGZiMTJi'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

    $response = curl_exec($ch);
    curl_close($ch);

    return $response;
}

/***************************************/
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
	

	
	
}
