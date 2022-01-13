<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 class Api_model extends CI_Model {

        public function __construct() {
            parent::__construct();
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
        
        public function insert($table,$data_array){
		$dbExi=$this->db->insert($table, $data_array); 
                    if($dbExi){
                        return  $this->db->insert_id();
                    }  else {
			    return  0;
    		}
    	}
        
        public function checkLogin($email, $password) {
            // fetching user by email
            $user = $this -> db
                -> select('id')
                -> where('email', $email)
                -> where('password', $password)
                -> limit(1)
                -> get('users')
                -> result_array();
            
            if(count($user)>0){
                return $user[0]['id'];
            }else{
                return false;
            }
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
        public function updateDevice($user_id,$device_type,$device_id,$language="en") {
            $data=array(
                'id'=>$user_id,
                'devicetype'=>$device_type,
                'device_id'=>$device_id,
                'language'=>$language
            );
            $this->db->where('id', $user_id); 
            $dbExi = $this->db->update('users', $data); 
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
        function getSingleRecordWhere($tbl,$condition = NULL, $fields = '*') {
            $result = array();
            $this->db->select($fields);
            $this->db->from($tbl);
            if(!empty($condition)) {
                $this->db->where($condition);
            }
            $result  = $this->db->get();
            return $result->row();
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
            if($this->db->affected_rows() == 1 || $this->db->affected_rows() == "1null")
                return true;
            else
                return false;
        }

        function selectJoinTablesMultipleRecord($tbl, $jtbls = array(), $condition = NULL, $fields='*', $orderfield='', $ordertype='') {
            $result = array();
            $this->db->select($fields);
            $this->db->from($tbl);
            if(!empty($condition)) {
                $this->db->where($condition);
            }

            // check if jtables supplied
            if(count($jtbls) > 0) {
                foreach ($jtbls as $tb) {
                    $this->db->join($tb['tbl'], $tb['cond'], $tb['type']);
                }
            }

            if(!empty($orderfield) && !empty($ordertype)) {
                $this->db->order_by($orderfield, $ordertype);
            }

            $result  = $this->db->get();
            return $result->result();
        }

        function sendEmail($to,$subject,$message){
            $headers = 'From: H2O Realstate <noreply@cyphersol.com>' . "\r\n" .
            'Reply-To: noreply@cyphersol.com' . "\r\n" .
            'MIME-Version: 1.0' . "\r\n".
            'Content-Type: text/html; charset=UTF-8' . "\r\n".
            'X-Mailer: PHP/' . phpversion();

            if(mail($to, $subject, $message, $headers)){
                return true;
            }else{
                return false;
            }
        }
        function getTranslation($title_key,$user_id=NULL){
            //default language column
            $column = "en";
            if($user_id != NULL){
                $user = $this -> db
                    -> select('*')
                    -> where('id', $user_id)
                    -> limit(1)
                    -> get('users')
                    -> result_array();
                if(count($user)>0){
                    $column = $user[0]['language'];
                }
            }
            $tranlation = $this -> db
                    -> select('*')
                    -> where('title_key', $title_key)
                    -> limit(1)
                    -> get('translation')
                    -> result_array();
                if(count($tranlation)>0){
                    return $tranlation[0][$column];
                    exit;
                }
            return $title_key;

        }
    }