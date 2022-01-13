<?php

defined('BASEPATH') or exit('No direct script access allowed');



class Chat extends CI_Controller

{

    function __construct()

    {

        parent::__construct();

        /*if(!$this->session->userdata('login')==true){

			redirect('user/login', 'refresh');

		}*/



        define('USER_ID', get_session('user_id'));
    }

    public $tbl_user = 'users';

    /*messages

| -------------------------------------------------------------------

| CHAT APIS START HERE

| getConversations | to get all conversations

| chat             | to send message

| messages         | to get messages between two users 

| -------------------------------------------------------------------

*/

    /*** Send message to user ***/

    public function chat()

    {



        extract($_POST);

        $this->AM->verifyRequiredParams(array("message", "receiverId"));

        $response = array();

        $response['status'] = 200;



        if (!isset($receiverId) or empty($receiverId)) {



            $errors[] = 'receiverId is not set or empty !';
        }

        if (defined('USER_ID')) {

            $user_id = USER_ID;
        } else {

            $this->error('Access denied');
        }













        // reading post params



        $reciever_id = $message_receiver = $receiverId;



        $response = array();



        $conversation_id = 0;



        if (!$this->isConversationExist($user_id, $reciever_id)) {



            echo   $conversation_id = $this->createConversation($user_id, $reciever_id, $date);
        } else {



            $conversation_id = $this->getConversation($user_id, $reciever_id);
        }











        if ($conversation_id <= 0 || empty($conversation_id)) {



            $response['error'] = false;



            $response['message'] = "Conversation could not be found due to invalid parameters";
        }



        if (empty($date)) {



            $date = date('Y-m-d H:i:s');
        }



        $message_id = $this->sendMessage($conversation_id, $user_id, $message, $date, $type = 'text');



        if ($message_id > 0) {



            $response['error'] = false;



            $response['message'] = "Message sent successfully";



            // update convesation time 



            $this->db->where('conversation_id', $conversation_id)->update('conversations', array('modified' => $date));







            ///Send Notification to friend



            $messageText = $this->getNotificationType("message");



            if (!empty($messageText)) {



                $user = $this->getUserByUserId($user_id);



                $userName = $user['name'];



                $image = $user['image'];



                $trimedMessage = substr($message, 0, 30);



                if (strlen($message) > 30) {



                    $trimedMessage .= "...";
                }



                $composedMessage = sprintf($messageText, $userName);



                $devices = $this->getDeviceId($message_receiver);



                $unreadMessageCount = (int)$this->getAllUnreadCount($reciever_id, $conversation_id);



                if (!empty($devices)) {

                    $payloadData = array(

                        "senderName" => $user['name'],

                        "senderImage" => $image,

                        "sender_id" => $user_id,

                        "user_id" => $user_id,

                        "time" => date('H:i a')



                    );







                    /*********************/

                    $notification = array('title' => $composedMessage, 'body' => $message, 'sound' => 'default', 'badge' => '1');

                    $arrayToSend = array('to' => $devices, 'data' => $payloadData, 'notification' => $notification, 'priority' => 'high');

                    $notiresponse = $this->sendnoti($arrayToSend);

                    $response['notification_object'] = $arrayToSend;

                    /**********************************/





                    //$response['notiData']=     $this->send_android_notification($devices,$data,'text','');

                    /*  $this->db->insert('notifications',array('body'=>$composedMessage,'resource_type'=>$resource_type,'resource_id'=>$message_id,'user_id'=>$receiverId));*/
                }
            }







            // $app->expires(time() - 86400);







            echo json_encode($response);
        } else {



            $response['error'] = false;



            $response['message'] = "Message could not be sent";







            echo json_encode($response);
        }
    }



    /*** get all conversations of the user***/

    public function getConversations()

    {

        //extract($_POST);



        $response = $this->get_all_conversations();



        $this->load->view('chat/conversations', $response);



        // echo json_encode($conversations);

    }



    private function get_all_conversations()

    {

        $response = array();

        $errors = array();

        $response['status'] = 200;

        $user_id = USER_ID;


        $sql = "SELECT * FROM conversations as c WHERE c.owner_id = $user_id OR c.receiver_id = $user_id" .

            " GROUP BY c.conversation_id order by modified desc";



        if (!empty($conversation_id)) {

            $sql = "SELECT * FROM conversations as c WHERE c.conversation_id = $conversation_id AND (c.owner_id = $user_id OR c.receiver_id = $user_id)" .

                " GROUP BY c.conversation_id order by modified desc";
        }




        $data = $this->db->query($sql);

        $conversations = array();



        if ($data->num_rows() > 0) {





            foreach ($data->result() as $row) {

                $conversations[] = $row;
            }
        }



        foreach ($conversations as $key => $conversation) {

            $conversation_id = $conversation->conversation_id;

            $owner_id = $conversation->owner_id;

            $receiver_id = $conversation->receiver_id;

            if ($owner_id == $user_id) {



                $owner = $this->getUserById($owner_id);

                $receiver = $this->getUserById($receiver_id);





                $conversations[$key]->avatar_owner = base_url() . 'uploads/' . $owner->image;



                $conversations[$key]->name_owner = $owner->name;

                $conversations[$key]->avatar_receiver = base_url() . 'uploads/' . $receiver->image;

                $conversations[$key]->name_receiver = $receiver->name;

                $conversations[$key]->is_owner = true;

                $conversations[$key]->is_online = $this->isUserOnline($receiver_id);
            } else {

                $owner = $this->getUserById($receiver_id);

                $receiver = $this->getUserById($owner_id);

                $conversations[$key]->receiver_id = $owner_id;

                $conversations[$key]->owner_id = $receiver_id;

                $conversations[$key]->avatar_owner = base_url() . 'uploads/' . $owner->image;

                $conversations[$key]->name_owner = $owner->name;

                $conversations[$key]->avatar_receiver = base_url() . 'uploads/' . $receiver->image;

                $conversations[$key]->name_receiver = $receiver->name;

                $conversations[$key]->is_owner = false;

                $conversations[$key]->is_online = $this->isUserOnline($receiver_id);
            }

            $sql2 = "SELECT * FROM  messages WHERE conversation_id = $conversation_id and status=0 ORDER BY message_id DESC LIMIT 1";

            $stmt2 = $this->db->query($sql2);

            if ($stmt2->num_rows() > 0) {

                $message = $stmt2->row();



                $conversations[$key]->message = $message->body;

                $conversations[$key]->date = $message->date;

                $conversations[$key]->read = $message->read;

                $conversations[$key]->UnreadCount = (int)$this->getAllUnreadCount($user_id, $conversation_id);
            } else {

                $conversations[$key]->message = "";

                $conversations[$key]->date = "";
            }
        }



        $response['conversations'] = $conversations;



        return $response;
    }



    /*

| -------------------------------------------------------------------

| CHAT APIS START HERE

| -------------------------------------------------------------------

*/







    public function isConversationExist($owner_id, $reciever_id)

    {

        $sql = "SELECT conversation_id FROM conversations WHERE (owner_id = '" . $owner_id . "' || receiver_id = '" . $owner_id . "') AND (receiver_id = '" . $reciever_id . "' || owner_id = '" . $reciever_id . "')";

        $data = $this->db->query($sql);

        $exist = false;

        if ($data->num_rows() > 0) {

            $row = $data->row();

            $conversation_id = $row->conversation_id;

            if (!empty($conversation_id)) {

                $exist = true;
            }
        }

        return $exist;
    }

    public function createConversation($owner_id, $reciever_id, $date = "")

    {

        if (empty($date)) {

            $date = date('Y-m-d H:i:s');
        }

        $insert_id = 0;

        $result = false;

        $query = $this->db->query("INSERT INTO conversations (`owner_id`,`receiver_id`,`modified`) values('" . $owner_id . "','" . $reciever_id . "','" . $date . "')");

        if ($query) {

            $insert_id = $this->db->insert_id();
        }

        return $insert_id;
    }



    public function getConversation($owner_id, $reciever_id)

    {

        $sql = "SELECT conversation_id FROM conversations WHERE (owner_id = '" . $owner_id . "' || receiver_id = '" . $owner_id . "') AND (receiver_id = '" . $reciever_id . "' || owner_id = '" . $reciever_id . "')";

        //  echo   $sql;die('L');

        $data = $this->db->query($sql);



        $conversation_id = 0;

        if ($data->num_rows() > 0) {

            $row = $data->row();

            $conversation_id = $row->conversation_id;
        }

        return $conversation_id;
    }



    public function getConversationById($conversation_id)

    {

        $sql = "SELECT * FROM conversations  WHERE conversation_id = $conversation_id LIMIT 1";

        $data = $this->db->query($sql);

        $conversation = array();

        if ($data->num_rows() > 0) {

            $conversation = $data->row();
        }

        return $conversation;
    }

    public function getMessages($user_id = 0, $conversation_id, $timezone = "UTC")

    {

        $sql = "SELECT m.*,u.image,u.name,m.user_id, message_id,m.conversation_id,m.status,m.deleted_by FROM messages as m INNER JOIN " . $this->tbl_user . " as u ON u.id = m.user_id INNER JOIN conversations as c ON c.conversation_id = m.conversation_id  WHERE m.conversation_id = $conversation_id and m.status=0 ORDER BY m.date ";





        $data = $this->db->query($sql);

        $messages = array();

        if ($data->num_rows() > 0) {

            foreach ($data->result() as $row) {



                if ($user_id > 0 && $user_id == $row->user_id) {

                    $message['body'] = $row->body;

                    $message['conversation_id'] = $row->conversation_id;



                    $message['name'] = $row->name;

                    $message['message_id'] = $row->message_id;

                    $message['user_id'] = $row->user_id;

                    $message['image'] = base_url() . 'uploads/' . $row->image;

                    $message['date'] = date("g:i a", strtotime($row->date));;

                    $message['read'] = (int)$row->read;

                    $message['is_owner'] = true;

                    $message['status'] = (int)$row->status;

                    $message['deleted_by'] = (int) $row->deleted_by;
                } else {

                    $message['body'] = $row->body;

                    $message['conversation_id'] = $row->conversation_id;

                    $message['name'] = $row->name;

                    $message['message_id'] = $row->message_id;

                    $message['user_id'] = $row->user_id;

                    $message['image'] = base_url() . 'uploads/' . $row->image;

                    $message['date'] = date("g:i a", strtotime($row->date));

                    $message['read'] = (int)$row->read;

                    $message['is_owner'] = false;

                    $message['status'] = (int)$row->status;

                    $message['deleted_by'] = (int) $row->deleted_by;
                }

                // date_default_timezone_set($timezone);

                //$message['date'] = date("m-d-Y h:i A");

                $messages[] = $message;
            }
        }

        return $messages;
    }

    public function sendMessage($conversation_id, $user_id, $body, $date = "", $type)

    {



        $timezone = 'America/Toronto';

        $date2 = new DateTime($row->date, new DateTimeZone($timezone));

        $date = $date2->format('Y-m-d H:i:s');

        $insert_id = 0;

        $result = false;

        $data = array(

            'conversation_id' => $conversation_id,

            'user_id' => $user_id,

            'body' => $body,

            'type' => $type,

            'date' => $date

        );



        $query = $this->db->insert('messages', $data);

        if ($query) {

            $insert_id = $this->db->insert_id();
        }

        return $insert_id;
    }



    public function getNotificationType($type)

    {

        if (empty($type)) {

            return "";
        }

        $messageText = "";



        $sql = "SELECT * FROM notification_types WHERE `type` = '" . $type . "' LIMIT 1";

        $data = $this->db->query($sql);

        if ($data->num_rows() > 0) {

            $row = $data->row();

            $messageText = $row->message;
        }

        return $messageText;
    }

    public function getUserByUserId($user_id)

    {

        $sql = "SELECT * FROM " . $this->tbl_user . " WHERE id = $user_id LIMIT 1";

        $data = $this->db->query($sql);

        if ($data->num_rows() > 0) {

            $row = $data->row();

            $userDetails = array(

                'name' => $row->name,

                'image' => base_url() . 'uploads/' . $row->image

            );
        } else {

            $userDetails = array(

                'name' => "",

                'image' => ""

            );
        }

        return $userDetails;
    }





    public function getDeviceId($user_id)

    {

        $sql = "SELECT device_id FROM " . TBL_USER . "  where id =" . $user_id;

        $data = $this->db->query($sql);

        $device = 0;

        if ($data->num_rows() > 0) {

            $device = $data->row()->device_id;
        }

        return $device;
    }



    public function getUserDevices($user_id = 0)

    {

        $sql = "SELECT device_id as push_id FROM " . TBL_USER . " ";

        if (!empty($user_id)) {

            $sql .= " WHERE user_id = $user_id ";
        }

        $data = $this->db->query($sql);

        $devices = array();

        if ($data->num_rows() > 0) {

            foreach ($data->result() as $row) {

                $devices[] = $row->push_id;
            }
        }

        return $devices;
    }

    public function getAllUnreadCount($user_id, $conversation_id = 0)

    {
        $where = '';
        if ($conversation_id != 0) {
            $where = 'AND m.conversation_id =' . $conversation_id;
        }
        $sql = "SELECT COUNT(m.message_id) as message_count FROM messages as m INNER JOIN " . $this->tbl_user . " as u ON u.id = m.user_id INNER JOIN "

            . "conversations as c ON c.conversation_id = m.conversation_id WHERE (c.owner_id = $user_id OR c.receiver_id = $user_id) AND "

            . "m.user_id <> $user_id AND m.read = 0
            $where
            ORDER BY m.message_id ASC";

        $data = $this->db->query($sql);

        $message_count = 0;

        if ($data->num_rows() > 0) {

            $row = $data->row();

            $message_count = $row->message_count;
        }

        return $message_count;
    }



    public function getDeviceType($push_id)

    {

        $sql = "SELECT * FROM user_devices WHERE push_id = '" . $push_id . "'LIMIT 1";

        $data = $this->db->query($sql);

        $type = "android";

        if ($data->num_rows() > 0) {

            $row = $data->row();

            $type = $row->type;
        }

        return $type;
    }



    public function setMessagesAsRead($conversation_id, $user_id)

    {

        $sql = "UPDATE messages SET `read` = 1 WHERE conversation_id = '" . $conversation_id . "' AND user_id != '" . $user_id . "'";

        $this->db->query($sql);
    }



    /***********************************chat db function end ********************************************/











    function sendnoti($array)

    {

        $url = "https://fcm.googleapis.com/fcm/send";

        $serverKey = 'AAAAxvt5y-s:APA91bHgpPJ_E5nIvmO1WpmOO7qvz9YcCzIAaAJKqdjI-fZmYuc01FU0Ix6LNnHcK1SMtUyBqg4Q45fE2mv1pOFUkoAQo-yy6BYVJT-Bl6_zLpA8vsNDx3nFRcQOul82DT2SDxPOJAwO';

        $json = json_encode($array);

        $headers = array();

        $headers[] = 'Content-Type: application/json';

        $headers[] = 'Authorization: key=' . $serverKey;

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);



        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        //Send the request

        $res = curl_exec($ch);

        if ($res === FALSE) {

            return 'FCM Send Error: ' . curl_error($ch);
        } else {

            curl_close($ch);

            return $json;
        }
    }



    /*



* messagess 



*/
    public function updateUnread($con_id, $rec_id)
    {
        $this->db->where(array('conversation_id' => $con_id, 'user_id' => $rec_id))->update('messages', array('read' => 1));
    }

    // haris messages
    public function messages($owner, $reciever, $conversation_id)

    {
        $this->updateUnread($conversation_id, $reciever);
        // extract($_POST);

        $owner = USER_ID;

        // $conversation_id = $this->db->get_where('conversations', array('owner_id' => $owner, 'receiver_id' => $reciever))->row()->conversation_id;



        $aData['reciever'] = $reciever;

        $aData['owner'] = $owner;

        $aData['chat_between'] = $this->db->get_where('messages', array('conversation_id' => $conversation_id))->result_array();

        // haris champ

        $aData['conversations'] = $this->get_all_conversations();






        $this->load->view('chat/chat-1', $aData);











        /*

        // ******************************************************

        $response = array();

        $errors = array();

        $response['status'] = 200;

        $this->AM->verifyRequiredParams(array(

            "receiverId",

            "timezone"

        ));







        // chekc if conversation exist 





        $reciever_id = $_POST['receiverId'];



        $timezone = $_POST['timezone'];

        if (defined('USER_ID')) {

            $user_id = USER_ID;

        } else {

            $this->error('Access denied');

        }



        if (!$this->isConversationExist($user_id, $reciever_id)) {

            $conversation_id = $this->createConversation($user_id, $reciever_id);

        } else {

            $conversation_id = $this->getConversation($user_id, $reciever_id);

        }



        $response = array();

        if (empty($conversation_id)) {

            $response["error"] = false;

            $response["messages"] = 'Required field(s) conversationId is missing or empty';

            echo json_encode($response);

            exit;

        }





        // updating activity request

        $messages = $this->getMessages($user_id, $conversation_id, $timezone);

        $conversation = $this->getConversationById($conversation_id);

        $this->setMessagesAsRead($conversation_id, $user_id);

        if (!empty($conversation)) {

            $response["conversation_id"] = $conversation_id;

            if ($conversation->owner_id == $user_id) {

                $response["user_id"] = $conversation->receiver_id;

                $user = $this->getUserByUserId($conversation->receiver_id);



                $response["user_image"] = $user['image'];

                $response["user_name"] = $user['name'];

                $response["is_owner"] = true;

            } else {

                $response["user_id"] = $conversation->owner_id;

                $user = $this->getUserByUserId($conversation->owner_id);



                $response["user_image"] = $user['image'];

                $response["user_name"] = $user['name'];

                $response["is_owner"] = false;

            }

        }



        if (!empty($messages)) {

            $response["status"] = 200;

            $response["messages"] = $messages;

            echo json_encode($response);

        } else {





            $response["messages"] = array();

            echo json_encode($response);

        }

        // *****************************************************

        */
    }



    /***********************************************************************************/

    /***

     * Send online or offline status

     * method post

     * url /whipser

     * @param status (0 or 1)

     */

    public function whisper()

    {



        $status = $_POST['status'];

        $user_id = $_POST['user_id'];

        $response = array();

        if (empty($status)) {

            $status = 204;
        }

        $whisper = $this->whisper_update($user_id, $status);

        if ($whisper) {

            $response['error'] = false;

            $response['message'] = "Your status has been updated.";
        } else {

            $response['error'] = false;

            $response['message'] = "Unable save your status";
        }



        echo json_encode($response);
    }



    public function whisper_update($user_id, $status = 1)

    {

        $whisper = $this->getItemByType("whispers", "user_id", $user_id);

        $date = date("Y-m-d h:i:s");

        if (empty($whisper)) {

            $sql = "INSERT INTO whispers (user_id, date, status) VALUES ( '" . $user_id . "', '" . $date . "','" . $status . "')";

            $stmt = $this->db->query($sql);

            if ($stmt) {

                return true;
            }

            return false;
        }

        $sql = "UPDATE whispers SET status = $status, date = '$date' WHERE user_id = $user_id";

        $this->db->query($sql);

        return true;
    }



    public function getItemByType($table, $primary, $id)

    {

        $data = $this->db->query("SELECT * FROM $table WHERE $primary = $id");

        $item = array();

        if ($data->num_rows() > 0) {

            $item = $data->row();
        }

        return $item;
    }











    /*******get messages end **********************************/



    public function  onlineusers()

    {

        $response["status"] = 200;

        $response["users"] = array();



        if (defined('USER_ID')) {

            $user_id = USER_ID;
        } else {

            $this->error('Access denied');
        }

        $q = "SELECT u.id as user_id,c.modified, u.name,u.email as email,u.image,u.bio,u.online as active,

	u.device_id as push_id  FROM " . $this->tbl_user . " as u  

	 left outer join conversations as c on u.id=c.owner_id or u.id=c.receiver_id 

where u.id!='" . $user_id . "'   group by u.id order by c.modified asc ";

        $data = $this->db->query($q);



        if ($data->num_rows() > 0) {

            $response["status"] = 200;

            foreach ($data->result() as $row) {

                $response["users"][] = array(

                    'user_id' => $row->user_id,

                    'is_friend' => $this->is_friend($row->user_id),

                    'name' => $row->name,

                    'email' => $row->email,

                    'bio' => $row->bio,

                    'image' => base_url() . 'uploads/' . $row->image,

                    'active' => $row->active,

                    'push_id' => $row->push_id

                );
            }
        } else {

            $response["status"] = 204;
        }



        echo json_encode($response);
    }





    public function  searchUsers()

    {

        $response["status"] = 200;

        $response["users"] = array();



        if (defined('USER_ID')) {

            $user_id = USER_ID;
        } else {

            $this->error('Access denied');
        }





        $this->AM->verifyRequiredParams(array(

            "name"

        ));

        extract($_POST);



        $q = "SELECT u.id as user_id,c.modified, u.name,u.email as email,u.image,u.bio,u.online as active,

	u.device_id as push_id  FROM " . $this->tbl_user . " as u  

	 left outer join conversations as c on u.id=c.owner_id or u.id=c.receiver_id 

where u.id!='" . $user_id . "' and u.name like '%" . $name . "%'   group by u.id order by c.modified asc ";

        $data = $this->db->query($q);



        if ($data->num_rows() > 0) {

            $response["status"] = 200;

            foreach ($data->result() as $row) {

                $response["users"][] = array(

                    'user_id' => $row->user_id,

                    'is_friend' => $this->is_friend($row->user_id),

                    'name' => $row->name,

                    'email' => $row->email,

                    'bio' => $row->bio,

                    'image' => base_url() . 'uploads/' . $row->image,

                    'active' => $row->active,

                    'push_id' => $row->push_id

                );
            }
        } else {

            $response["status"] = 204;
        }



        echo json_encode($response);
    }





    public function  is_friend($fid)

    {

        if (checkExist('friends', array('friend_id' => $fid, 'user_id' => USER_ID))) {

            return true;
        } else {

            return false;
        }
    }

    public function  _getFriends()

    {

        $response["status"] = 200;

        $response["users"] = array();



        if (defined('USER_ID')) {

            $user_id = USER_ID;
        } else {

            $this->error('Access denied');
        }

        $q = "SELECT u.id as user_id,c.modified, u.name,u.email as email,u.image,u.bio,u.online as active,

	u.device_id as push_id  FROM " . $this->tbl_user . " as u  

	

	 left outer join conversations as c on u.id=c.owner_id or u.id=c.receiver_id 

	 join friends as f on f.friend_id=u.id

where u.id!='" . $user_id . "' and f.user_id ='" . USER_ID . "' group by u.id order by c.modified asc ";

        $data = $this->db->query($q);



        if ($data->num_rows() > 0) {

            $response["status"] = 200;

            foreach ($data->result() as $row) {

                $response["users"][] = array(

                    'user_id' => $row->user_id,

                    'name' => $row->name,

                    'email' => $row->email,

                    'bio' => $row->bio,

                    'image' => base_url() . 'uploads/' . $row->image,

                    'active' => $row->active,

                    'push_id' => $row->push_id

                );
            }
        } else {

            $response["status"] = 204;
        }



        echo json_encode($response);
    }







    public function getUserById($user_id)

    {

        $sql = "SELECT * FROM " . $this->tbl_user . " where id = '" . $user_id . "' LIMIT 1";

        $stmt = $this->db->query($sql);

        $userDetails = array(

            'name' => "",

            'avatar' => ""

        );

        if ($stmt) {

            $user = $stmt->row();

            if (!empty($user)) {

                $userDetails = $user;
            }
        }

        return $userDetails;
    }







    /****/



    public function timezones()

    {

        $response = array();

        $response["status"] = 200;

        $response["timezones"] = array(

            'US/Pacific' => '(UTC-8) Pacific Time (US & Canada)',

            'US/Mountain' => '(UTC-7) Mountain Time (US & Canada)',

            'US/Central' => '(UTC-6) Central Time (US & Canada)',

            'US/Eastern' => '(UTC-5) Eastern Time (US & Canada)',

            'America/Halifax' => '(UTC-4)  Atlantic Time (Canada)',

            'America/Anchorage' => '(UTC-9)  Alaska (US & Canada)',

            'Pacific/Honolulu' => '(UTC-10) Hawaii (US)',

            'Pacific/Samoa' => '(UTC-11) Midway Island, Samoa',



            'Etc/GMT-12' => '(UTC-12) Eniwetok, Kwajalein',

            'Canada/Newfoundland' => '(UTC-3:30) Canada/Newfoundland',

            'America/Buenos_Aires' => '(UTC-3) Brasilia, Buenos Aires, Georgetown',

            'Atlantic/South_Georgia' => '(UTC-2) Mid-Atlantic',

            'Atlantic/Azores' => '(UTC-1) Azores, Cape Verde Is.',

            'Europe/London' => 'Greenwich Mean Time (Lisbon, London)',

            'Europe/Berlin' => '(UTC+1) Amsterdam, Berlin, Paris, Rome, Madrid',

            'Europe/Athens' => '(UTC+2) Athens, Helsinki, Istanbul, Cairo, E. Europe',

            'Europe/Moscow' => '(UTC+3) Baghdad, Kuwait, Nairobi, Moscow',

            'Iran' => '(UTC+3:30) Tehran',

            'Asia/Dubai' => '(UTC+4) Abu Dhabi, Kazan, Muscat',

            'Asia/Kabul' => '(UTC+4:30) Kabul',

            'Asia/Yekaterinburg' => '(UTC+5) Islamabad, Karachi, Tashkent',

            'Asia/Calcutta' => '(UTC+5:30) Bombay, Calcutta, New Delhi',

            'Asia/Katmandu' => '(UTC+5:45) Nepal',

            'Asia/Omsk' => '(UTC+6) Almaty, Dhaka',

            'Indian/Cocos' => '(UTC+6:30) Cocos Islands, Yangon',

            'Asia/Krasnoyarsk' => '(UTC+7) Bangkok, Jakarta, Hanoi',

            'Asia/Hong_Kong' => '(UTC+8) Beijing, Hong Kong, Singapore, Taipei',

            'Asia/Tokyo' => '(UTC+9) Tokyo, Osaka, Sapporto, Seoul, Yakutsk',

            'Australia/Adelaide' => '(UTC+9:30) Adelaide, Darwin',

            'Australia/Sydney' => '(UTC+10) Brisbane, Melbourne, Sydney, Guam',

            'Asia/Magadan' => '(UTC+11) Magadan, Solomon Is., New Caledonia',

            'Pacific/Auckland' => '(UTC+12) Fiji, Kamchatka, Marshall Is., Wellington',

        );



        foreach ($response["timezones"] as $key => $value) {

            $response["android"][] = array(

                'key' => $key,

                'value' => $value

            );
        }

        echo json_encode($response);
    }



    /*******************devices**************/



    public function addDevice($user_id, $push_id, $push_type)

    {

        if (empty($user_id) || empty($push_id)) {

            return;
        }

        if (empty($push_type)) {

            $push_type = "android";
        }

        if ($this->deviceExist($user_id, $push_id)) {

            $this->updateDeviceStatus($user_id, $push_id, 1);

            return;
        }



        $result = $this->db->query("INSERT INTO user_devices(user_id, push_id, type) values('" . $user_id . "', '" . $push_id . "', '" . $push_type . "')");

        return $result;
    }



    public function deviceExist($user_id, $push_id)

    {

        $sql = "SELECT * FROM user_devices WHERE user_id = $user_id AND push_id = '" . $push_id . "'LIMIT 1";

        $query = $this->db->query($sql);

        $exists = false;

        if ($query->num_rows() > 0) {

            $exists = true;
        }

        return $exists;
    }

    public function updateDeviceStatus($user_id, $push_id, $deviceStatus)

    {

        $sql = "UPDATE user_devices SET `active` = $deviceStatus WHERE user_id = $user_id AND `push_id` = '$push_id'";

        $result = $this->db->query($sql);

        $status = false;

        if ($result) {

            $status = true;
        }

        return $status;
    }



    public function isUserOnline($user_id)

    {

        return   $this->db->select('online')->where('id', $user_id)->get('users')->row()->online;
    }

    /*-------------------- 

	|CHAT APIS END vavroom

	|---------------------

	*/


    public function contactWithUser()
    {

        $response = array();

        $response['status'] = 204;

        $response['message'] = 'Notification not sent!';



        $pro_id = base64_decode($_POST['pro_id']);

        $data = $this->db->select('id,name,email')->from('users')->where('id', $pro_id)->get();

        $reportedBy = $this->db->select('*')->from('users')->where('id', get_session('user_id'))->get()->row();

        $nest = $this->db->select('*')->from('tbl_loc')->where('id', get_session('last_nest_id'))->get()->row();

        if ($data->num_rows() > 0) {

            $userid = $data->row()->id;

            // send email 

            $to = $data->row()->email;

            $from = 'noreply@geonest.org';

            $from_heading = 'GEONEST';

            $subject = 'Un nouveau nid signalé';

            $htmlContent = '<div style="text-align:center"><div id="co" style="padding: 2%;border-radius:5px;width: 50%;background-color:#fffff2;box-shadow: 1px 3px 10px 3px #acc8f3;margin: 12px 0 0 0;" ><b>Bonjour ' . ucfirst($data->row()->name) . ' ,</b><br><br>';

            $htmlContent .= '<p>Un nouveau nid a été signalé, cliquez sur le lien ci-dessous pour voir les détails.</p>';

            $htmlContent .= '<style>#btnLik:active{color:red}#btnLik:hover{color:#d3e1ec}</style>';

            $htmlContent .= '<a id="btnLik" style="box-shadow:inset 0px 1px 0px 0px #cf866c;

                background-color: rgb(252, 227, 3);

                border-radius:3px;

                border:1px solid #942911;

                display:inline-block;

                cursor:pointer;

                color:black;

                font-family:Arial;

                font-size:13px;

                padding:6px 24px;

                text-decoration:none;

                text-shadow:0px 1px 0px #854629;" class="myButton" href="' . base_url() . 'map/nestdetail/' . get_session('last_nest_id') . '">voir le nid signalé</a>';





            $htmlContent .= '<br><br>';

            // attach info who report the nest

            //$reportedBy



            $htmlContent .= "<p><b>Vous trouverez ci-dessous le détail de l'utilisateur qui a signalé le nid</b></p>";

            $htmlContent .= '<p><b>Nom</b>: ' . $reportedBy->name . ' </p>';

            $htmlContent .= '<p><b>Email</b>:  ' . $reportedBy->email . '</p>';

            $htmlContent .= '<p><b>Téléphone</b>:  ' . $reportedBy->phone . '</p>';

            $htmlContent .= '<a style="box-shadow:inset 0px 1px 0px 0px #cf866c;

	background-color: rgb(252, 227, 3);

	border-radius:3px;

	border:1px solid #942911;

	display:inline-block;

	cursor:pointer;

	color:black;

	font-family:Arial;

	font-size:13px;

	padding:6px 24px;

	text-decoration:none;

	text-shadow:0px 1px 0px #854629;" id="btnLik" class="myButton" href="mailto:' . $reportedBy->email . '">Envoyer un e-mail</a><br><br>';



            $htmlContent .= '<a>Équipe de soutien</a> </div></div>';

            $this->crud->send_mail($to, $from, $from_heading, $subject, $htmlContent);

            // save notification into database

            $notification = array(

                'body' => $nest->name . ' signalé un nid',

                'created_date' => NOW,

                'resource_type' => 'nest',

                'resource_id' => get_session('last_nest_id'),

                'sender_id' => get_session('user_id'),

                'receiver_id' => $pro_id

            );

            if ($this->db->insert('notifications', $notification)) {

                $response['status'] = 200;

                $response['message'] = 'Opération effectuée avec succès';
            }
        }

        $response['pro_id'] = $pro_id;

        echo json_encode($response);
    }
    function createconnection($my_chat_arr, $response)

    {

        $arr = array();

        extract($my_chat_arr);
        if (empty($message)) {
            echo json_encode($response);
            exit;
        }
        $datac = array(



            'receiver_id' => $rec_id,

            'owner_id' => $sender_id,



        );
        $odata = $this->db->where('id', $sender_id)->get('users')->result();
        $data = $this->db->where('id', $rec_id)->get('users')->result();
        //pre($data);
        // if ($data[0]->online == 0) {

        //     $url   = base_url() . 'user/user_chat';
        //     $rec_name = $data[0]->name;
        //     $email = $data[0]->email;
        //     $subject = 'Message sur geonest';
        //     $mailmessage = '<p><b>' . ucfirst($rec_name) . '</b> vous envoyer un message </p><p>Message: ' . $message . '</p>';

        //     $result = $this->crud->send_mail($email, APP_EMAIL, FROM_HEADING, $subject, $mailmessage);

        //     if ($result == 1) {

        //         ///  $arr['status']=200;

        //         ///       $arr['message']='mail successfully send';  
        //     } else {

        //         $arr['status'] = 200;

        //         $arr['message'] = 'mail sending error';
        //         echo json_encode($arr);
        //         exit;
        //     }
        // }


        if (!$this->isConversationExist($rec_id, $sender_id)) {


            if ($this->db->insert('conversations', $datac)) {


                $cl = $this->db->query('SELECT conversation_id FROM conversations ORDER BY conversation_id DESC LIMIT 1')->result();





                $datacon = array(



                    'conversation_id' => $cl[0]->conversation_id,

                    'user_id' => $sender_id,

                    'body' => $message,

                );



                if ($this->db->insert('messages', $datacon)) {


                    $arr['status'] = 200;

                    $arr['message'] = 'Message Sent Succeesfully';
                } else {


                    $arr['status'] = 100;

                    $arr['message'] = "Error";
                }
            } else {

                $arr['status'] = 100;

                $arr['message'] = "Error";
            }
        }

        ///if conversoin alreday exist

        else {


            $cl = $this->getConversationExist($rec_id, $sender_id);





            $datacon = array(



                'conversation_id' => $cl,

                'user_id' => $rec_id,

                'body' => $message,

            );



            if ($this->db->insert('messages', $datacon)) {

                $arr['status'] = 200;

                $arr['message'] = 'Opération effectuée avec succès';
            } else {

                $arr['status'] = 100;

                $arr['message'] = "Erreur d'envoi";
            }
        }



        echo json_encode($arr);
    }
    public function contactWithPro()
    {



        $response = array();

        $response['status'] = 204;

        $response['message'] = 'Notification non envoyée!';



        $pro_id = base64_decode($_POST['pro_id']);

        $data = $this->db->select('id,name,email')->from('users')->where('id', $pro_id)->get();

        $nest = $this->db->select('*')->from('tbl_loc')->where('id', get_session('last_nest_id'))->get()->row();

        if ($data->num_rows() > 0) {

            $userid = $data->row()->id;

            // send email 

            $to = $data->row()->email;

            $from = 'noreply@freelivebees.org';

            $from_heading = 'Freelivebees';

            $subject = 'Un nouveau nid vous est signalé';

            $fromName = $this->session->userdata('name');

            $htmlContent = '<div ><div ><b>Voici le message de ' . ucfirst($fromName) . ' ,</b><br>';

            // $htmlContent .= '<p>Contacter moi merci.</p>';



            $htmlContent .= '<p>' . $_POST['message'] . '</p><br>';



            $htmlContent .= '<a id="btnLik" class="myButton"   href="' . base_url() . 'map/followHistory/' . get_session('last_nest_id') . '">' . lang('email_btn') . '</a>';



            $htmlContent .= '<br>';

            $htmlContent .= '<h5>FreeLiveBees</h5></div></div>';

            // $to='waseemafzal31@gmail.com';

            $this->crud->send_smtp_email($to, $from, $from_heading, $subject, $htmlContent);

            // save notification into database

            $notification = array(

                'body' => $nest->name . ' reported a nest',

                'created_date' => NOW,

                'resource_type' => 'nest',

                'resource_id' => get_session('last_nest_id'),

                'sender_id' => get_session('user_id'),

                'receiver_id' => $pro_id

            );

            if ($this->db->insert('notifications', $notification)) {

                $response['status'] = 200;

                $response['message'] = 'Notification envoyée avec succès!';
            }
        }



        $this->createconnection($_POST, $response);
        // echo json_encode($response);
    }
    function replaymessage()

    {


        extract($_POST);

        $cl = $this->getConversationExist($owner_id, $rec_id);

        $datacon = array(



            'conversation_id' => $cl,

            'user_id' => $owner_id,

            'body' => $msg,

        );



        if ($this->db->insert('messages', $datacon)) {
            $datacheck = $this->db->where('id', $rec_id)->get('users')->result();
            if ($datacheck[0]->online == 0) {
                $this->db->insert('notifications', array('body' => $msg, 'sender_id' => $owner_id, 'receiver_id' => $rec_id, 'resource_id' => 1, '	resource_type' => 'message', 'readed' => 0));
            }
            $arr['status'] = 200;

            $arr['record'] = $this->getmessagerecord($owner_id, $rec_id);
        } else {

            $arr['status'] = 100;

            $arr['record'] = 'Error in sending';
        }



        echo json_encode($arr);
    }
    public function getConversationExist($owner_id, $reciever_id)
    {

        $sql = "SELECT conversation_id FROM conversations WHERE (owner_id = '" . $owner_id . "' || receiver_id = '" . $owner_id . "') AND (receiver_id = '" . $reciever_id . "' || owner_id = '" . $reciever_id . "')";

        $data = $this->db->query($sql);

        $exist = false;

        if ($data->num_rows() > 0) {

            $row = $data->row();

            $conversation_id = $row->conversation_id;

            if (!empty($conversation_id)) {

                return $conversation_id;
            }
        }

        return $exist;
    }
    function get_all_messages()
    {
        extract($_POST);
        $arr['status'] = 200;

        $arr['record'] = $this->getmessagerecord($owner_id, $rec_id);

        echo json_encode($arr);
        exit;
    }
    function getmessagerecord($owner_id, $user_id)

    {

        $udata = $this->session->userdata('user_loginrecord');


        $r_image = $this->db->get_where('users', array('id' => $user_id))->row()->image;
        $o_image = $this->db->get_where('users', array('id' => $owner_id))->row()->image;




        $mid = $udata->id;

        $uname = $udata->name;

        if (empty($udata->image)) {

            $uurl = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS0rz7SHvHoyn3LwaQ6Zc8LkQEmi-ClP8mvZg&usqp=CAU';
        } else {

            $uurl = base_url() . "/uploads/" . $udata->image;
        }

        extract($_POST);

        $html = '';

        $cl = $this->getConversationExist($owner_id, $user_id);

        $data = $this->db->where('conversation_id', $cl)->get('messages')->result();



        $udata = $this->db->where('id', $user_id)->get('users')->result();

        if (empty($udata[0]->image)) {

            $url = 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS0rz7SHvHoyn3LwaQ6Zc8LkQEmi-ClP8mvZg&usqp=CAU';
        } else {

            $url = base_url() . "/uploads/" . $udata[0]->image;
        }





        $name = $udata[0]->name;

        $id = $udata[0]->id;

        $html .= '<input type="hidden" id="receiver_id" name="receiver_id" value="' . $id . '" />';

        if (!empty($data)) {



            foreach ($data as $d) {

                if ($d->user_id == $owner_id) {
                    $uurl = 'uploads/' . $o_image;
                } else {
                    $uurl = 'uploads/' . $r_image;
                }

                if ($d->user_id == $owner_id) {

                    $html .= '<div class="message-day">';
                    $html .= ' <div class="message self">';
                    $html .= '<div class="message-wrapper">';

                    $html .= '<div class="message-content">';
                    $html .= '<span>' . $d->body . '</span>';
                    $html .= '</div>';



                    $html .= '</div>';

                    $html .= '<div class="message-options">
                                                <div class="avatar avatar-sm"><img alt="" src="' . $uurl . '"></div>

                                                <small><span class="message-date">' . $d->date . '</span> </small>
                                                <small class="del_msg_icon">
                                                    <a class="text-danger" href="javascript:void(0)" onclick="delete_message(' . $d->message_id . ')" >
                                                        <svg class="hw-18 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        

                                                    
                                                    </a>
                                                </small>
                                                
                                            </div>';
                    $html .= '</div>';
                    $html .= '</div>';
                } else {
                    $html .= '<div class="message">
                                            <div class="message-wrapper">
                                                <div class="message-content">
                                                    <span>' . $d->body . '</span>
                                                </div>
                                            </div>
                                            <div class="message-options">

                                                <div class="avatar avatar-sm"><img alt="" src="' . $uurl . '"></div>
                                                <span class="message-date">' . $d->date . '</span>
                                              
                                            </div>
                                        </div>';
                }
                $html .= '</div></div>';
            }
        } else {

            $html .= '<div class="chat">Pas encore de conversation</div>';
        }

        return $html;
    }
    function delete_message()
    {
        extract($_POST);
        $arr['status'] = 200;
        $this->db->where('message_id', $messageid)->delete('messages');

        $arr['record'] = $this->getmessagerecord($owner_id, $rec_id);


        echo json_encode($arr);


        // $arr = array();

        // extract($_POST);
        // // print_r($_POST);
        // //exit;
        // ///check if owner
        // $del = $this->db->where('message_id', $messageid)->delete('messages');
        // if ($del) {

        //     $html = $this->getmessagerecord($owner_id, $user_id);

        //     $arr['status'] = 200;

        //     $arr['record'] = $html;

        //     echo json_encode($arr);
        // } else {
        //     $arr['status'] = 100;
        // }
    }
}
