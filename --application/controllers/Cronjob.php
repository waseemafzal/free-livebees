<?php defined('BASEPATH') or exit('No direct script access allowed');
class Cronjob extends CI_Controller
{
       
        function __construct()
        {
                parent::__construct();
        }
		
	public $tbl_nest='tbl_loc';	
	public function	sendnotification_observationdate(){
			/*
			Le site doit être suivi /This site has to be followed (with the link to the Nest infos)
			*/
			$i=0;
			$res=0;
			$data=$this->db->select('tbl_loc.*,users.name,users.email')
			->where('tbl_loc.notification_date',date('Y-m-d'))
			->join('users', 'users.id = tbl_loc.user_id')
			->get($this->tbl_nest)->result_array();
			if(count($data)>0){
				foreach($data as $key=>$nest){
			$to = $nest['email'];
            $from = 'noreply@freelivebees.org';
            $from_heading = 'Freelivebees';
            $subject = 'Visit the site';
            $htmlContent = '<div ><div ><b>Hello ' . ucfirst($nest['name']) . ' ,</b><br>
            The next observation date is :'.$nest['next_observation_date'].'<br> 
            Notification was set for :'.$nest['notification_date'].'<br> 
            ';
            $link = '<a id="btnLik" class="myButton"   href="' . base_url() . 'map/viewHistory/'.$nest['id']. '">Le site doit être suivi</a>';
            $htmlContent .= $link.'<br>';
            $htmlContent .= '<h5>FreeLiveBees</h5></div></div>';
	// send mail to owner		
  if($this->send_smtp_email($to, $from, $from_heading, $subject, $htmlContent)){
	  $i++;
	  // send notification to all 	
	  $res=  $this->senNotificationToPro($nest['lat'],$nest['lon'],$nest);

	  }
	
					}
				}
				
				echo 'The notification has been sent to '.$i.' owners and '.$res.' Pro users';
			}

		function senNotificationToPro($latitude,$longitude,$nest){
		    //pre($nest);
			$j=0;
	$PRO_USER=3;
	$sql = "SELECT u.name,u.email , 6371 *acos(cos( radians( " . $latitude . " ) ) *cos( radians( latitude ) ) *cos( radians( longitude)- radians(".$longitude.")) + sin( radians(".$latitude." ))*sin( radians( latitude ) ) ) AS `radius` FROM users  as u where u.user_type='".$PRO_USER."'
	 HAVING  radius <=20";
$usersData=$this->db->query($sql)->result_array();

		if(count($usersData)>0){
		foreach($usersData as $key=>$user){
		$to = $user['email'];
		$from = 'noreply@freelivebees.org';
		$from_heading = 'Freelivebees';
		$subject = 'Visit the site of user';
		$htmlContent = '<div ><div ><b>Dear  ' . ucfirst($user['name']) . ' ,</b><br>
		You have to visit the site and its a reminder to you.
		The next observation date is :'.$nest['next_observation_date'].'<br> 
            Notification was set for :'.$nest['notification_date'].'<br> 
		';
		$link = '<a id="btnLik" class="myButton"   href="' . base_url() . 'map/viewHistory/'.$nest['id']. '">Le site doit être suivi</a>';
		$htmlContent .= $link.'<br>';
		$htmlContent .= '<h5>FreeLiveBees</h5></div></div>';
		
		if($this->send_smtp_email($to, $from, $from_heading, $subject, $htmlContent)){
		$j++;
		}
		
		}
		}
		
		return $j;
	
	}

			public function send_smtp_email($to, $from, $from_heading, $subject, $htmlContent){
		//Load email library
		$this->load->library('email');
		//SMTP & mail configuration {O~8idwV(a^L
		$config = array(
			'protocol'  => 'smtp',
			'smtp_host' => 'ssl://mail.free-livebees.org',
			'smtp_port' => 465,
			'smtp_user' => 'webmaster@free-livebees.org',
			'smtp_pass' => 'P@ssword123',
			'mailtype'  => 'html',
			'charset'   => 'utf-8'
		);
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");
		//Email content
		$this->email->to($to);
		$this->email->from('webmaster@free-livebees.org', 'FreeLiveBees');
		$this->email->subject($subject);
		$this->email->message($htmlContent);
		//Send email
		if ($this->email->send()) {
			return 1;
		} else {
			echo $this->email->print_debugger();
			exit;
			//return 0;
		}
	}

		
	
}
