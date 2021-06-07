<?php

class Cruds extends CI_Model

{

        public function __construct()

        {

                parent::__construct();

                $this->load->database();

        }

        public function insert_data($tbl, $form_array, $string)

        {

            

            

            

            



            $code=$this-> getZipcodeW($form_array['address']);

           if(empty($code)){

               $code=time();

           }

          

                

                if ($this->db->insert($tbl, $form_array)) {

                    $last_id =  $this->db->insert_id();

                    $this->session->set_userdata('last_nest_id',$last_id);

                    

                    

                    $this->db->where('id', $last_id)->update($tbl, array("postal_code"=>$code,"uniqid"=>$code."_".$last_id));









                        $map_id = $this->db->select_max('id')

                                ->get('tbl_loc')

                                ->row()->id;

                        $images_Data = explode(",", $string);

                        foreach ($images_Data as $image) {

                                $post = array('file' => $image, 'map_id' => $map_id);

                                $this->db->insert('tbl_map_images', $post);

                        }

                        return 1;

                }

        }

        

        

        

        // 

             

          function getZipcodeW($address){

         if(!empty($address)){

        //Formatted address

        $formattedAddr = str_replace(' ','+',$address);

        //Send request and receive json data by address

        $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=true_or_false&key=AIzaSyAaqEI1hEro18UDNXVHKnQ5dc6A_vF-crY');

       

        $output1 = json_decode($geocodeFromAddr);

        //Get latitude and longitute from json data

        $latitude  = $output1->results[0]->geometry->location->lat; 

        $longitude = $output1->results[0]->geometry->location->lng;

        //Send request and receive json data by latitude longitute

        $geocodeFromLatlon = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?latlng='.$latitude.','.$longitude.'&sensor=true_or_false&key=AIzaSyAaqEI1hEro18UDNXVHKnQ5dc6A_vF-crY');

        //  pre( $geocodeFromLatlon);

        $output2 = json_decode($geocodeFromLatlon);

        if(!empty($output2)){

            $addressComponents = $output2->results[0]->address_components;

           

            foreach($addressComponents as $addrComp){

                if($addrComp->types[0] == 'postal_code'){

                    //Return the zipcode

                    return $addrComp->long_name;

                }

            }

            return false;

        }else{

            return false;

        }

    }else{

        return false;   

    }

}      

                

        public function edit_c_form($id)

        {

                

                $result = $this->db->get_where('tbl_loc', array('id' => $id));



                $r = $this->db->get_where('tbl_map_images', array('map_id' => $id));

                $result = array($result, $r);





                return $result;

        }

        public function edit_complete_form_data($tbl)

        {

                $id = $_POST['pro_user'];

                unset($_POST['pro_user']);

                $_POST["updated_at"] = date("Y-m-d h:i:s");

                return $this->db->where('id', $id)->update($tbl, $_POST);

        }

        public function updated_images($tbl_loc_id, $string)

        {



                $images_Data = explode(",", $string);

                foreach ($images_Data as $image) {

                        $post = array('file' => $image, 'map_id' => $tbl_loc_id);

                        $this->db->insert('tbl_map_images', $post);

                }

        }

        public function check_suivi_user($id)

        {



                $query = $this->db->get_where('prototypeform', array('nest_id' => $id));

               



                if ($query->num_rows() == 0) {

                        // update 

                        return false;

                } else {



                        $images_id = $query->result()[0]->id;



                        $r = $this->db->get_where('tbl_map_images', array('map_id' => $images_id));



                        $result = array($query, $r);



                        return $result;

                }

        }

        public function insert_suive_data($tbl, $string)

        {

                if ($this->db->insert($tbl, $_POST)) {









                        $map_id = $this->db->select_max('id')

                                ->get('prototypeform')

                                ->row()->id;

                        $images_Data = explode(",", $string);



                        foreach ($images_Data as $image) {

                                $post = array('file' => $image, 'map_id' => $map_id);

                                $this->db->insert('tbl_map_images', $post);

                        }

                        return 1;

                }

               



                // $this->db->insert($tbl, $_POST);

                // $map_id = $this->db->select_max('id')

                //         ->get($tbl)

                //         ->row()->id;





                // $post = array('file' => $string, 'map_id' => $map_id);

                // return $this->db->insert('tbl_map_images', $post);

        }

        public function update_suivi_form($tbl, $string)

        {

                $nestid = $_POST['nest_id'];

                $id = $_POST['id'];

                unset($_POST['id']);

                return $this->db->where('nest_id', $nestid)->update($tbl, $_POST);

        }

        public function delete_image($image_id)

        {

                return $this->db->delete('tbl_map_images', array('id' => $image_id));

        }

        public function insert_follow_data($tbl,$frm_data){

            if( $this->db->insert($tbl,$frm_data)){
				
		
                          return true;

                      }

                      else{

                          return false;

                      }

        }
        public function update_follow_data($id,$frm_data){

            if( $this->db->where('id',$id)->update('tbl_follow',$frm_data)){
				$follow_id=$id;
				if (!empty($_FILES)){ 
			$nameArray = $this->crud->upload_files($_FILES);
			$nameData = explode(',',$nameArray);
			foreach($nameData as $file){
				$file_data = array(
				'file' => $file,
				'follow_id' =>$follow_id
				);
				$this->db->insert('tbl_follow_images', $file_data);
				}
			  }
                          return true;

                      }

                      else{

                          return false;

                      }

        }

        public function insert_clone_data(){

             $query = $this->db->get_where("tbl_loc", array('id' => $_POST['id']));

            

              if ($query->result_id->num_rows > 0) {





                       $duplicate_data=$query->result_array()[0];

                     

                      unset($duplicate_data['id']);

                    

                      if( $this->db->insert("tbl_loc",$duplicate_data)){

                          return true;

                          

                      }

                      else{

                          return false;

                          

                      }

                       

                       

                } else {

                        return false;

                }

            

            

        }

            

        

}

