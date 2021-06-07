<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Allnests extends MX_Controller {

	public function __construct(){
		parent::__construct();
		if(!$this->session->userdata('login')==true){
			redirect('auth/login', 'refresh');
		}
		$this->load->library("pagination");
	}
	
	public $tbl = 'tbl_loc';
	public $tbl_invites = 'invites';
	
	public function index()
	{  
	
	$config = array();
        $config["base_url"] = base_url() . "allnests/index";
        $config["total_rows"] = getcount($this->tbl);
        $config["per_page"] = 20;
        $config["uri_segment"] = 3;
		$this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$data = $this->fetch_feed($config["per_page"], $page);
        $aData['links'] = $this->pagination->create_links();
		 $aData['data'] =$data;
		$this->load->view('index',$aData);
		//$this->load->view('index');
	}
	
	function importcsv(){
		
		if (isset($_FILES['file']['name']) and !empty($_FILES['file']['name'])) { 
				$imgcheck = true;
				$info = pathinfo($_FILES['file']['name']);
				$ext = $info['extension']; // get the extension of the file
				$newname = rand(5, 3456) * date(time()) . "." . $ext;
				$target = 'uploads/' . $newname;
					if (move_uploaded_file($_FILES['file']['tmp_name'], $target)) {
					$file =base_url().'uploads/'. $newname;
					}
				
			}
			
			$string = file_get_contents('uploads/'.$newname);
			
$json_a=json_decode($string,true);
$data=$json_a['nest'];
//echo count($data);exit;
$counter=0;


foreach ($data as $key => $value){
	$counter++;
 // print_r($value);
  $insert_csv=$value;
  
  /*
  [actif] => 1
    [adresse] => 28 Passage des Panoramas, 75002 Paris, France
    [createdDate] => vendredi 10 mai 2019
    [hauteur] => 4
    [id] => -LeX1c55ISIARU6QicrZ
    [imageUrl] => https://firebasestorage.googleapis.com/v0/b/nidinfo-10ee7.appspot.com/o/images%2F1557496752966?alt=media&token=9005d076-870b-4ba7-b4a8-a10d9657cdfa
    [informations] => 
    [latitude] => 48.8703961
    [longitude] => 2.3415857
    [ownerId] => pVIbAhiaaDOZQagdeZNbFbg2OEf1
    [professionel] => 0
    [size] => 25
    [support] => toit
    [type] => Frelon asiatique
    [username] => Benedicte Reitzel
  */
 
//$arr[]=$date;

	if($insert_csv['type']=='Frelon asiatique')
							{
							 $nesttype = 1;	
							}
							else
							if($insert_csv['type']=='Frelon européen')
							{
								$nesttype = 2;
													}
							else
							if($insert_csv['type']=='WASP')
							{
								$nesttype = 3;
							}else{
							    $nesttype = '4';
							}
							

  $dataArray = array(
                'status' => $insert_csv['actif'],
               'added_date' => $insert_csv['createdDate'],
                'hight_in_meters' => $insert_csv['hauteur'],
                'description' => $insert_csv['informations'],
                'lat' => $insert_csv['latitude'],
                'lon' => $insert_csv['longitude'],
                'diameter' => $insert_csv['size'],
                'support' => $insert_csv['support'],
                'nest_type' => $nesttype,
                'name' => $insert_csv['username']
				);
				if(isset($insert_csv['adresse'])){
				  $dataArray['address']	=$insert_csv['adresse'];
					
					}
				//pre($data);
           $this->db->insert('tbl_loc', $dataArray);
		   $this->db->insert('tbl_map_images', array('map_id'=>$this->db->insert_id(),'file'=>$insert_csv['imageUrl'],'type'=>'image'));
}

        $response['status']=1;
        $response['message']=$counter .' record imported';
       echo json_encode($response);
		}
	function _importcsv(){
		
		$count=0;
        $fp = fopen($_FILES['file']['tmp_name'],'r') or die("can't open file");
        while($csv_line = fgetcsv($fp,1024))
        {
            $count++;
            if($count == 1)
            {
                continue;
            }//keep this if condition if you want to remove the first row
            for($i = 0, $j = count($csv_line); $i < $j; $i++)
            {
                $insert_csv = array();
                $insert_csv['status'] = $csv_line[0];
                $insert_csv['address'] = $csv_line[1];
                $insert_csv['added_date'] = date('Y-m-d',strtotime($csv_line[2]));
                $insert_csv['hight_in_meters'] = $csv_line[3];
                 $insert_csv['description'] = $csv_line[6];
                $insert_csv['lat'] = $csv_line[7];
                $insert_csv['lon'] = $csv_line[8];
                $insert_csv['diameter'] = $csv_line[10];
                $insert_csv['support'] = $csv_line[11];
                $insert_csv['nest_type'] = $csv_line[12];
                $insert_csv['name'] = $csv_line[13];

            }
            $i++;
            $data = array(
                'status' => $insert_csv['status'],
                'address' => $insert_csv['address'],
                'added_date' => $insert_csv['added_date'],
                'hight_in_meters' => $insert_csv['hight_in_meters'],
                'description' => $insert_csv['description'],
                'lat' => $insert_csv['lat'],
                'lon' => $insert_csv['lon'],
                'diameter' => $insert_csv['diameter'],
                'support' => $insert_csv['support'],
                'nest_type' => $insert_csv['nest_type'],
                'name' => $insert_csv['name']
				);
           $this->db->insert('tbl_loc', $data);
		   $this->db->insert('tbl_map_images', array('map_id'=>$this->db->insert_id(),'file'=>$csv_line[5],'type'=>'image'));
        }
        fclose($fp) or die("can't close file");
        $data['success']=1;
        $data['message']='imported';
       echo json_encode($data);
		}
	
	public function fetch_feed($limit, $start) {
        $this->db->limit($limit, $start);
		/*if(isset($_GET['activity_type']) and !empty($_GET['activity_type'])){
			$whereArray['activity_type_id']= $_GET['activity_type'];
			}
		*/
         $this->db->select("f.*")
		/*->join('activity_types as type','type.id=f.activity_type_id')
		->join('activity_feed_images as i','i.feed_id=f.id')
		->join('users as u','u.id=f.user_id')
		*//*->where($whereArray)*/
		->order_by('f.id','DESC');
		/*if(isset($_GET['posted_date']) and !empty($_GET['posted_date'])){
			$this->db->like('posted_date', $_GET['posted_date']);
			}*/
		
		
	$query =$this->db->get($this->tbl.' as f');
	
//lq();
        if ($query->num_rows() > 0) {
            
            return $query;
        }
        return false;
   }
   
   
   function convert_date_fr($date, $format_in = 'j F Y', $format_out = 'Y-m-d') {
    // French to english month names
    $months = array(
        'janvier' => 'january',
        'février' => 'february',
        'mars' => 'march',
        'avril' => 'april',
        'mai' => 'may',
        'juin' => 'june',
        'juillet' => 'july',
        'août' => 'august',
        'septembre' => 'september',
        'octobre' => 'october',
        'novembre' => 'november',
        'décembre' => 'december',
    );
    
    // List of available formats for date
    $formats_list = array('d','D','j','l','N','S','w','z','S','W','M','F','m','M','n','t','A','L','o','Y','y','H','a','A','B','g','G','h','H','i','s','u','v','F','e','I','O','P','T','Z','D','c','r','U');
    
    // We get separators between elements in $date, based on $format_in
    $split = str_split($format_in);
    $separators = array();
    $_continue = false;
    foreach($split as $k => $s) {
        if($_continue) {
            $_continue = false;
            continue;
        }
        // For escaped chars (like "\h")
        if($s == '\\' && isset($split[$k+1])) {
            $separators[] = '\\' . $split[$k+1];
            $_continue = true;
            continue;
        }
        if(!in_array($s, $formats_list)) {
            $separators[] = $s;
        }
    }
    
    // Translate month name
    $tmp = preg_split('/('.implode('|', array_map(function($v) {
        if($v == '/') {
            return '\/';
        }
        return str_replace('\\', '\\\\', $v);
    }, $separators)).')/', $date);
    
    foreach($tmp as $k => $v) {
        $v = mb_strtolower($v, 'UTF-8');
        if(isset($months[$v])) {
            $tmp[$k] = $months[$v];
        }
    }
    
    // Re-construct the date
    $imploded = '';
    foreach($tmp as $k => $v) {
        $imploded .= $v . (isset($separators[$k]) ? str_replace('\\', '', $separators[$k]) : '');
    }
    
    return DateTime::createFromFormat($format_in, $imploded)->format($format_out);
}
   

}
