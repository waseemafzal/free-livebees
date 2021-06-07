<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 class Api_model extends CI_Model {

        public function __construct() {
            parent::__construct();
            $this -> load -> library('session');
        }

        /**
         * All Api functions
         */ 
        
        function mail_exists($key)
        {
            $this->db->where('email',$key);
            $query = $this->db->get('users');
            if ($query->num_rows() > 0){
                return true;
            }
            else{
                return false;
            }
        }
        function isSubscribe($user_id)
        {
            $result = array();

            $this->db->select('*');
            $this->db->from('subscription');            
            $this->db->where('user_id',$user_id);
            $this->db->where('compare_date >',strtotime(date('d-m-Y')));
             $this->db->join('packages','packages.id = package_id');            
            $result = $this->db->get();
            if ($result->num_rows() > 0){
            return $result->row();
            }
            else{
                return false;
            }
        }
         function isSubscribedAlready($user_id)
        {
            $result = array();

            $this->db->select('*');
            $this->db->from('subscription');            
            $this->db->where('user_id',$user_id);
            $result = $this->db->get();
            if ($result->num_rows() > 0){
            return $result->row();
            }
            else{
                return false;
            }
        }
         function getPackageById($user_id)
        {
            $result = array();

            $this->db->select('*');
            $this->db->from('packages');            
            $this->db->where('id',$user_id);
            $result = $this->db->get();
            if ($result->num_rows() > 0){
            return $result->row();
            }
            else{
                return false;
            }
        }
        
        public function insert($table,$data_array){
		$dbExi=$this->db->insert($table, $data_array); 
                    if($dbExi){
                        return  $this->db->insert_id();
                    }  else {
			    return  0;
    		}
    	}
    	//getData
    	public function getData($table){
            return $this -> db
                -> select('*')  
                -> get($table)
                -> result_array();
        }
    	//getData
    	public function getCountryData($table){
            return $this -> db
                -> select('*')  
                -> order_by('country')    
                -> get($table)
                -> result_array();
        }
        //getData
    	public function getCategoriesData($table){
            return $this -> db
                -> select('*')  
                -> order_by('cat_name')  
                -> where('parent_id',0)    
                -> get($table)
                -> result_array();
        }
        //getData
    	public function getPackagesData($table){
            return $this -> db
                -> select('*')  
                -> order_by('type')
                -> order_by('value')
                -> where("price !=","0")
                -> get($table)
                -> result_array();
        }
        
        public function checkLogin($email, $password) {
            // fetching user by email
            $user = $this -> db
                -> select('id')
                -> where('email', $email)
                -> where('password', md5($password))
                -> limit(1)
                -> get('users')
                -> result_array();
            
            if(count($user)>0){
                return $user[0]['id'];
            }else{
                return false;
            }
        }
        public function getFeedById($table,$id){
            $user = $this -> db
                -> select('*')
                -> where('id', $id)
                -> limit(1)
                -> get($table)
                -> result_array();
            if(count($user)>0){
                return $user[0];
            }else{
                return null;
            }
        }
        
        public function getFeedByUserId($table,$user_id){
            $url = base_url("uploads/");
            $fields = "*,CONCAT(('$url'),(''),(image)) as image,categories.cat_name";
            return $this -> db
                -> select($fields)  
                -> where('user_id',$user_id)   
                    
                -> get($table)
                -> result_array();
        }
        public function getImagesOtherUserProfile($user_id){
            $url = base_url("uploads/");
            $fields = "CONCAT(('$url'),(''),(image)) as image";
            return $this -> db
                -> select($fields)  
                -> where('user_id',$user_id)   
                -> get("feed")
                -> result_array();
        }

        public function getUserById($id){
            $user = $this -> db
                -> select('*')
                -> where('id', $id)
                -> limit(1)
                -> get('users')
                -> result_array();
            if(count($user)>0){
                return $user[0];
            }else{
                return null;
            }
        }
        public function updateDevice($user_id,$device_type,$device_id){
                $data=array(
		 'id'=>$user_id,
		 'device_type'=>$device_type,
		 'device_id'=>$device_id);
                $this->db->where('id', $user_id); 
		$dbExi=$this->db->update('users', $data); 
        }
        
        
        
        //predefined sentences
        public function getPredefined(){
            return $this -> db
                -> select('*')  
                -> get('predifned_answers')
                -> result_array();
        }
        
        //All Topics
         public function getTopics($key,$value,$user_id,$course_id){
             if($value == 0){
            $topics = $this -> db
                -> select('*')
                ->where($key,$value)
                ->where("course_id",$course_id)
                -> get('topics')
                -> result_array();
             } else {
            $topics = $this -> db
                -> select('*')
                ->where($key,$value)     
                -> get('topics')
                -> result_array();
             }
            $count = 0;
            foreach ($topics as $topic){
                $topics[$count]['rating'] = $this->calculateTopicRating($topic['id']);
                $topics[$count]['subtopics'] = $this->doesHaveSubTopics($topic['title']);
                $topics[$count]['isAnswered'] = $this->isAnswered($topic['id'],$user_id);
                $count = $count+1;
            }
            return $topics;
        }
        function isAnswered($topic_id,$user_id){
           
            
            $result = $this -> db
                -> select('*')
                -> where('user_id', $user_id)
                -> where('topic_id',$topic_id)
                -> limit(1)
                -> get('answers')
                -> result_array();
       
            if(count($result)>0){
                return TRUE; 
            }else{
                return FALSE;
            }
        
        }
        
        function doesHaveSubTopics($title){
            if(count($this -> db
                -> select('*')
                ->where('hyperonym',$title)     
                -> get('topics')
                -> result_array())>0){
                    return true;
                }
            return false;
        }

        function calculateTopicRating($topic_id){
            $ratings = array(
                    5 => $this->ratingCount($topic_id,5),
                    4 => $this->ratingCount($topic_id,4),
                    3 => $this->ratingCount($topic_id,3),
                    2 => $this->ratingCount($topic_id,2),
                    1 => $this->ratingCount($topic_id,1)
                    );
                    
             return $this->calcAverageRating($ratings);
        }
        function ratingCount($topic_id,$rating){
            return count($this -> db
                -> select('*')  
                ->where('topic_id',$topic_id) 
                ->where('rating',$rating)    
                -> get('rating')
                -> result_array());
        }
        function calcAverageRating($ratings) {

            $totalWeight = 0;
            $totalReviews = 0;

            foreach ($ratings as $weight => $numberofReviews) {
                
                $WeightMultipliedByNumber = $weight * $numberofReviews;
                $totalWeight += $WeightMultipliedByNumber;
                $totalReviews += $numberofReviews;
            }

            //divide the total weight by total number of reviews
            if($totalReviews==0){
                return 0;
            }
            $averageRating = $totalWeight / $totalReviews;

            return number_format((float)$averageRating, 2, '.', '');
        }


        //Get Rating if already saved
        public function ratingStatus($data){
             // fetching user by email
            $result = $this -> db
                -> select('id')
                -> where('user_id', $data["user_id"])
                -> where('topic_id',$data["topic_id"])
                -> limit(1)
                -> get('rating')
                -> result_array();
        
            if(count($result)>0){
                $data["id"] = $result[0]["id"];
                return $this->db->update('rating', $data); 
            }else{
                return $this->insert("rating", $data); 
            }
        }
        
        
        
        //Get Anser if already saved
        //Get Anser if already saved
        public function answerStatus($data){
            
            $result = $this -> db
                -> select('*')
                -> where('user_id', $data["user_id"])
                -> where('topic_id',$data["topic_id"])
                -> limit(1)
                -> get('answers')
                -> result_array();
        
            if(count($result)>0){
                return $result; 
            }else{
                return array(); 
            }
        }

        
        public function addAnswer($data){
            
            $result = $this -> db
                -> select('id')
                -> where('user_id', $data["user_id"])
                -> where('topic_id',$data["topic_id"])
                -> limit(1)
                -> get('answers')
                -> result_array();
        
            if(count($result)>0){
                $this->db->where("id",$result[0]["id"]);
                return $this->db->update('answers', $data); 
            }else{
                return $this->insert("answers", $data); 
            }
        }
        
        //Get Rating if already saved
        public function likesdislikesStatus($data){
             // fetching user by email
            $result = $this -> db
                -> select('id')
                -> where('user_id', $data["user_id"])
                -> where('answer_id',$data["answer_id"])
                -> limit(1)
                -> get('likesdislikes')
                -> result_array();
            if(count($result)>0){
                $this->db->where("id",$result[0]["id"]);
                return $this->db->update('likesdislikes', $data); 
            }else{
                return $this->insert("likesdislikes", $data); 
            }
        }
        
         public function topicAnswersOrUserAnswers($data){
             if(isset($data["user_id"])){
                 return $this -> db
                -> select('answers.*,topics.title as topic,topics.image')
                ->from('answers')
                ->join('topics', 'topics.id = answers.topic_id')         
                ->where('answers.user_id',$data["user_id"])-> get()
                -> result_array();
             }else{
                return $this -> db
                -> select('answers.*,users.name,users.image')
                ->from('answers')
                ->join('users', 'users.id = answers.user_id')          
                ->where('answers.topic_id',$data["topic_id"])    
                -> get()
                -> result_array();
             }
        }
        
        public function getUsersStatsByUserId($user_id){
            $data = array();
            $data["total_answers"] = $this->totalUserAnswers($user_id);
            $data["total_like"] = $this->totalUserAnswersLikes($user_id);
            $data["total_unlikes"] = $this->totalUserAnswersUnLikes($user_id);
            $data["total_topics"] = $this->totalTopics($user_id);
            $data["progress"] = $this->userAnswersProgress($user_id);
            $data["progress_info"] = "Progress is calculated on the basis of like/unlikes by users on your answers";
            return $data;
        }
        function totalUserAnswers($user_id){
            return count($this -> db
                -> select('*')
                ->from('answers')
                ->where('user_id',$user_id)    
                -> get()
                -> result_array());
        }
        function totalUserAnswersLikes($user_id){
            
            return count($this -> db
                -> select('*')
                ->from('answers')    
                ->join('likesdislikes',"likesdislikes.answer_id=answers.id")    
                ->where('likesdislikes.user_id !=',$user_id)    
                ->where('answers.user_id',$user_id)        
                ->where('likesdislikes.islike',1)    
                -> get()
                -> result_array());
        }
        function totalUserAnswersUnLikes($user_id){
            return count($this -> db
                -> select('*')
                ->from('answers')    
                ->join('likesdislikes',"likesdislikes.answer_id=answers.id")    
                ->where('likesdislikes.user_id !=',$user_id)    
                ->where('answers.user_id',$user_id)        
                ->where('likesdislikes.islike',0)    
                -> get()
                -> result_array());
        }
        function getCourses(){
            return $this -> db
                -> select('*')  
                -> get('courses')
                -> result_array();
        }
        function totalTopics($user_id){
            return count($this -> db
                -> select('*')
                ->from('topics')
                -> get()
                -> result_array());
        }
        
        
        function userAnswersProgress($user_id){
            $totalLikes = $this->totalUserAnswersLikes($user_id);
            $totalUnLikes = $this->totalUserAnswersUnLikes($user_id);
            $totalLikesUnlikes = $totalLikes+$totalUnLikes;
            if ($totalLikesUnlikes==0){
                return 0;
            }
            return number_format((float)(($totalLikes/$totalLikesUnlikes)*100), 2, '.', '');
        }
        
        
        
        public function totalLikesOrUnlikes($answer_id,$islike){
            return count($this -> db
                -> select('*')  
                ->where('answer_id',$answer_id) 
                ->where('islike',$islike)    
                -> get('likesdislikes')
                -> result_array());
        }

        /*
        |----------------------------------------------------------------------
        | ADDED BY @NOOR MUHAMMAD
        |----------------------------------------------------------------------
        */

        /*
        |----------------------------------------------------------------------
        | FUNCTION TO GET SINGLE RECORD
        |----------------------------------------------------------------------
        */
        function getSingleRecordWhere($tbl,$condition) {
            $result = array();
            $this->db->select('*');
            $this->db->from($tbl);
            $this->db->where($condition);
            $result  = $this->db->get();
            
            return $result->row();
        }
        function joinRecord($contests,$user_id){
            $i = 0;
                foreach ($contests as $data) {
                $result = array();
            $this->db->select('*');
            $this->db->from('connects');
            $this->db->where('user_id',$user_id);
            $result  = $this->db->get();
                if (!empty($result->row())) {

                $contests[$i]['isConnect'] = TRUE;

                }else{

                $contests[$i]['isConnect'] = FALSE;

                }
                $i = $i + 1;

                }
                return $contests;
        }

        /*
        |----------------------------------------------------------------------
        | FUNCTION TO GET MULTIPE RECORDS
        |----------------------------------------------------------------------
        */
        function getMultipleRecordWhere($tbl, $condition =  NULL, $fields='*') {
            $result = array();
            $this->db->select($fields);
            $this->db->from($tbl);
            if(!empty($condition)) {
                $this->db->where($condition);
            }
            $result  = $this->db->get();
            return $result->result();
        }

        /*
        |----------------------------------------------------------------------
        | FUNCTION TO INSERT RECORD
        |----------------------------------------------------------------------
        */
        function insertData($tbl,$fields) {
            $result = array();
            $query = $this->db->insert($tbl,$fields);
            if($this->db->affected_rows() == 1)
                return true;
            else
                return false;
        }

        /*
        |----------------------------------------------------------------------
        | FUNCTION TO UPDATE RECORD
        |----------------------------------------------------------------------
        */
        function updateData($tbl,$fields,$condition) {
            $result = array();
            $this->db->where($condition);
            $query = $this->db->update($tbl,$fields);
            if($this->db->affected_rows() == 1)
                return true;
            else
                return false;
        }

        /*
        |----------------------------------------------------------------------
        | FUNCTION TO DELETE RECORD
        |----------------------------------------------------------------------
        */
        
        
        function deleteRecord($tbl,$condition) {
            $result = array();
            $this->db->where($condition);
            $this->db->delete($tbl);
            if($this->db->affected_rows() == 1 || $this->db->affected_rows() != "null")
                return true;
            else
                return false;
        }
		
	
        
        function selectJoinTablesMultipleRecord($tbl, $jtbls = array(), $condition = NULL, $fields='*',$order = NULL,$page=NULL) {
            $result = array();
            $this->db->select($fields);
            $this->db->from($tbl);
            if(!empty($order)){
                $this->db->order_by($order);
            }
            if(!empty($condition)) {
                $this->db->where($condition);
            }

            // check if jtables supplied
            if(count($jtbls) > 0) {
                foreach ($jtbls as $tb) {
                    $this->db->join($tb['tbl'], $tb['cond'], $tb['type']);
                }
            }
           
            if(isset($page)&& ($page != 0)) {
                $start = ($page-1)*10;
                $this->db->limit(10,$start);
            }
            
            $result  = $this->db->get();
//            echo $this->db->last_query();
//            exit;
            return $result->result();
        }
    }