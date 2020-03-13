<?php
class User_model extends CI_Model
{




	public function getCount($table,$field,$cond)
	{
		$this->db->select($field);
		$this->db->from($table);
		$this->db->where($cond);		
        return $this->db->count_all_results();
 
	}

	public function getSum($table,$feilds,$cond)
    {
        $this->db->select_sum($feilds);
        $this->db->from();
        $this->db->where($cond);
        $data = $this->db->get($table);

        return ($data->num_rows() > 0)?$data->row():0;
    } 

	

	
    public function checkUserEmail($email)
	{
		$this->db->select("id");
		$this->db->where("email",$email);
        $client = $this->db->get(CLIENT);

      	return ($client->num_rows() >0)?TRUE:FALSE;
    }
    
	public function fetchCondRow($table,$con)
    {
       $data = $this->db
	                ->select('*')
					->from($table)
					->where($con)
					->get();
					
	   	return ($data->num_rows() > 0)?$data->row():FALSE;
	}

	public function fieldCondRow($table,$filed,$con)
    {
       $data = $this->db
	                ->select($filed)
					->from($table)
					->where($con)
					->get();
		//echo 	$data->num_rows();
	  //return ($data->num_rows() > 0)?$data->row():FALSE; 
	  return $data->row();
	}

    public function fieldCondRow1($table,$filed,$con)
    {
       $data = $this->db
                  ->select($filed)
          ->from($table)
          ->where($con)
          ->order_by('id','DESC')
          ->get();
    //echo  $data->num_rows();
    //return ($data->num_rows() > 0)?$data->row():FALSE; 
    return $data->row();
  }

	public function resultArrayNull($table,$filed,$con)
    {
       $data = $this->db
	                ->select($filed)
					->from($table)
					->where($con)
					->get();
	  return ($data->num_rows() > 0)?$data->result_array():NULL; 
	}

	public function fieldCRow($table,$filed,$con)
    {
       $data = $this->db
	                ->select($filed)
					->from($table)
					->where($con)
					->get();
	  return ($data->num_rows() > 0)?$data->row():FALSE; 
	}

	public function getCondResult($table,$filed,$con)
    {
       $data = $this->db
	                ->select($filed)
					->from($table)
					->where($con)
					->get();
				
	   	return ($data->num_rows() > 0)?$data->result():FALSE;	
	}

  public function getCondResult1($table,$filed,$con)
    {
       $data = $this->db
                  ->select($filed)
          ->from($table)
          ->where($con)
          ->order_by('id','DESC')
          ->get();
        
      return ($data->num_rows() > 0)?$data->result():FALSE; 
  }

	public function getCondResultArray($table,$filed,$con)
    {
       $data = $this->db
	                ->select($filed)
					->from($table)
					->where($con)
					->order_by('id','DESC')
					->get();
					
	   	return ($data->num_rows() > 0)?$data->result_array():FALSE;
	}

	

   

	public function fetchValue($table,$field,$con)
    {
       $data = $this->db
	                ->select($field)
					->from($table)
					->where($con)
					->get();
		$result = $data->row();
	   	return ($data->num_rows() >0)?$result->$field:FALSE;
	}

	public function mysqlResult($table,$field,$condition,$orderby,$order)
	{
		$this->db->select($field);
		if($condition)
		   $this->db->where($condition);
		if(!empty($orderby) && !empty($order))
			$this->db->order_by($orderby,$order);
		$query = $this->db->get($table);

		return ($query->num_rows() > 0)?$query->result():FALSE;
	}

	public function mysqlResultLimit($table,$field,$condition,$orderby,$order,$limit,$limitS)
	{
		$this->db->select($field);
		if($condition)
		   $this->db->where($condition);
		if(!empty($orderby) && !empty($order))
			$this->db->order_by($orderby,$order);
		if(!empty($limitS) && !empty($limit))
			$this->db->limit($limit, $limitS);
		else if(empty($limitS) && !empty($limit))
			$this->db->limit($limit);
		$query = $this->db->get($table);

		return ($query->num_rows() > 0)?$query->result():FALSE;
	}

	public function maxIdVal($table,$field)
    {
        $this->db->select($field);
        $data = $this->db->get($table);
        return ($data->num_rows() >0)?$data->row():FALSE;
    }

    public function selectMax($table,$field)
    {
    	$this->db->select_max($field);
    	$data = $this->db->get($table);
    	$dataVal = $data->row();
    	return $dataVal->$field;
    }

    public function selectMaxCond($table,$field,$cond)
    {
    	$this->db->select_max($field);
    	$this->db->where($cond);
    	$data = $this->db->get($table);
    	$dataVal = $data->row();
    	return $dataVal->$field;
    }

    public function maxConVal($table,$field,$cond)
    {
        $this->db->select($field);
        $this->db->where($cond);
        $data = $this->db->get($table);
        return ($data->num_rows() >0)?$data->row():FALSE;
    }

    public function mysqlNumRows($table,$field,$cond)
    {
        $this->db->select($field);
        $this->db->where($cond);
        $data = $this->db->get($table);
        return ($data->num_rows() >0)?$data->num_rows():0;
    }

	

	public function checkExist($table,$field,$con)
    {
       $data = $this->db
	                ->select($field)
					->from($table)
					->where($con)
					->get();
					
	   	return ($data->num_rows() > 0)?TRUE:FALSE;
	}

	
	public function whereIn($tbl,$field,$con)
    {
	    $data = $this->db
	               ->select($field)
				   ->from($tbl)
				   ->where_in($con)
				   ->get();
		return $data->result();
		//return $this->db->last_query();
    }

   

	

	
   public function insert_data($tbl,$data)
   {
        $this->db->insert($tbl,$data);
		$insert_id = $this->db->insert_id();
		$this->db->cache_delete_all();
		return $insert_id;
   }

   
	

    public function update_data($tbl,$data,$condition)
    {
   		$this->db->trans_start();
   		$this->db->where($condition);
        $this->db->update($tbl,$data);
        $this->db->trans_complete();
        $this->db->cache_delete_all();

		if ($this->db->affected_rows() == '1') 
		    return TRUE;
		else {
		    if ($this->db->trans_status() === FALSE)
		        return FALSE;
		    return TRUE;
		}
    }

	public function update_data_cache($tbl,$data,$condition)
    {
   		$this->db->trans_start();
   		$this->db->where($condition);
        $this->db->update($tbl,$data);
        $this->db->trans_complete();
        $this->db->cache_delete_all();
		if ($this->db->affected_rows() == '1') 
		    return TRUE;
		else {
		    if ($this->db->trans_status() === FALSE)
		        return FALSE;
		    return TRUE;
		}
    }
   
    public function deleteRow($table,$cond)
    {
  		$this->db->where($cond);
  		$this->db->delete($table);
  		$this->db->cache_delete_all();
  		return TRUE;
    }

    public function fetchAllRecords($school)
    {
       $data = $this->db
	                ->select('*')
					->from($school)
					->get();
					//return $data->result();
	   return ($data->num_rows() > 0)?$data->result():FALSE;					
    }
   
  

  
   
 public  function getToken()
 {
   	 $length = 20;
     $token = "";
     $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
     $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
     $codeAlphabet.= "0123456789";
     $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[rand(0, $max-1)];
    }

    return $token;
}


function image_upload($image,$folder) {
      $UPLOAD_DIR = $folder."/";
       $image_parts = explode(";base64,", $image);
       $image_type_aux = explode("image/", $image_parts[0]);
       $image_type = $image_type_aux[1];
      // $image_type = $type;;
       $image_base64 = base64_decode($image_parts[1]);
       $image_base64 = base64_decode($image);
       $file = $UPLOAD_DIR.uniqid() . '.'.$image_type;
       file_put_contents($file, $image_base64);
       $file = base_url().$file;
       return $file;
   }

   function mybooking($condition)
   {
   	 $this->db->select('d.name,d.specialty,b.created_date,b.address,b.address_type,b.booking_type');
     $this->db->from('doctor_booking as b');
     $this->db->join('doctor_doctor as d', 'b.doctor_id = d.id'); 
     $this->db->where($condition);
     $query = $this->db->get();
     return $query->result();
   }

    function doctorBooking($condition)
   {
   	 $this->db->select('b.id,u.name,u.email,u.mobile,b.created_date,b.address,b.address_type,b.booking_type');
     $this->db->from('doctor_booking as b');
     $this->db->join('doctor_user as u', 'b.user_id = u.id'); 
     $this->db->where($condition);
      $this->db->order_by("b.id", "DESC");
     $query = $this->db->get();
     return $query->result();
   }

   function getHospital($condition)
   {
    $this->db->select('H.id,hospital_name,provider_name,provider_specility,service_date,I.image');
    $this->db->from('user_hospital_records as H');
    $this->db->join('medical_record_image as I', 'H.id = I.record_id');
    $this->db->where($condition);
     $this->db->order_by("H.id", "DESC");
     $query = $this->db->get();
     return $query->result();
   }

   //for docotr api
   function getHomeUserList($condition)
   {
    $this->db->select('U.name as username,U.id,B.address,B.booking_type,B.member_name,B.reason_visit,B.created_date,B.schedule_time,B.schedule_date,B.doctor_id,B.id as booking_id,B.booking_latitude,B.booking_longitude');
    $this->db->from('doctor_booking  as B');
    $this->db->join('doctor_user as U', 'U.id = B.user_id');
  //  $this->db->join('doctor_doctor as D', 'D.id = B.user_id');
    $this->db->where($condition);
    $this->db->order_by("booking_id", "DESC");
     $query = $this->db->get();
     return $query->result();
   }


   public function AvgRating($table,$cond)
    {
        $this->db->select('AVG(rating) as rate');
        $this->db->from($table);
        $this->db->where($cond);
        $data = $this->db->get();

        return ($data->num_rows() > 0)?$data->row():0;
    }


    //my  notification list for user 
   //  function notification($condition)
   // {
   //  $this->db->select('n.id,n.title,n.message,n.type,n.booking_id,d.id as doctor_id,d.mobile,d.name as doctor_name,u.name as user_name,n.created_date,d.specialty,d.image,d.clinic_name,d.home_visit_type,d.call_visit_type,b.reason_visit,b.member_name,b.frees,b.booking_type,n.status');
   //  $this->db->from('notification  as n');
   //  $this->db->join('doctor_user as u', 'u.id = n.user_id');
   //  $this->db->join('doctor_doctor as d', 'd.id = n.doctor_id','left');
   //   $this->db->join('doctor_booking as b', 'b.id = n.booking_id');
   //  $this->db->where($condition);
   //  $this->db->order_by("n.id", "DESC");
   //   $query = $this->db->get();
   //   return $query->result();
   // }

   //my notification list for doctor
   //  function doctorNotification($condition)
   // {
   //  $this->db->select('n.id,n.title,n.message,n.type,n.booking_id,n.created_date');
   //  $this->db->from('notification  as n');
   //  $this->db->join('doctor_user as u', 'u.id = n.user_id');
   //  $this->db->join('doctor_doctor as d', 'd.id = n.doctor_id');
   //  // $this->db->join('doctor_booking as b', 'b.id = n.booking_id');
   //  $this->db->where($condition);
   //  $this->db->order_by("n.id", "DESC");
   //   $query = $this->db->get();
   //   return $query->result();
   // }

   function notificationDetails($condition)
   {
     $this->db->select('n.id,n.title,n.message,n.type,d.name as doctor_name,u.name as user_name,n.created_date,d.specialty,d.image,d.clinic_name,d.home_visit_type,d.call_visit_type,b.reason_visit,b.member_name,b.frees,b.booking_type,n.doctor_id,n.booking_id');
    $this->db->from('notification  as n');
    $this->db->join('doctor_user as u', 'u.id = n.user_id');
    $this->db->join('doctor_doctor as d', 'd.id = n.doctor_id');
     $this->db->join('doctor_booking as b', 'b.id = n.booking_id');
    $this->db->where($condition);
   // $this->db->order_by("n.id", "DESC");
     $query = $this->db->get();
     return $query->result();
   }

  
    
    
     public function getLatLong($address){
        if(!empty($address)){
            //Formatted address
            $formattedAddr = str_replace(' ','+',$address);
            //Send request and receive json data by address
            $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$formattedAddr.'&sensor=false&key=AIzaSyCHu8t8gkBK-yT0hkzrp5P5Fa51kFNUjUk'); 
            $output = json_decode($geocodeFromAddr);
            //Get latitude and longitute from json data
            $data['latitude']  = $output->results[0]->geometry->location->lat; 
            $data['longitude'] = $output->results[0]->geometry->location->lng;
            //var_dump($output->results[0]->address_components[0]->types);die;
            for($j=0;$j<count($output->results[0]->address_components);$j++){
                $city = $output->results[0]->address_components[$j]->types;
                if($city[0]=="locality"){
                     $data['city'] = $output->results[0]->address_components[$j]->long_name;    
                }
            }
            //Return latitude and longitude of the given address
            if(!empty($data)) {
                return $data;
            }else{
                return false;
            }
        }else{
            return false;   
        }
    }


 //push notification for android 
  //this is used to send doctor to user  
 public function android_pushh($deviceToken = null, $message = null,$title=null,$type = null,$notification_id=null,$badge = null)
    {
        $this->autoRender = false;
        $this->layout     = false;
       // $type="";
        $url              = 'https://fcm.googleapis.com/fcm/send';
        $message          = array("message" => $badge['sender_name'].$message,'title'=>$title,'notification_id'=>$notification_id,'type'=>$type,'time'=> date('H:i:s'), "type" => $type, "batch" => $batch,'badge'=>$badge,'sound' => 'default');
        $registatoin_ids  = array($deviceToken); 
        $fields           = array('registration_ids' => $registatoin_ids, 'data' => $message);
          //$GOOGLE_API_KEY   = "AIzaSyCT1hAiELV9ogaDsrPfyTlBJ9ocI5jRqE0";
        $GOOGLE_API_KEY   = "AIzaSyAnssTv8JOVx6YjgKRLN9nUIT-u_-z3sY4";
        $headers          = array(
            'Authorization: key=' . $GOOGLE_API_KEY,
            'Content-Type: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === false) {
            die('Curl failed: ' . curl_error($ch));
        } else {
           //print_r("success");die;
        }
        curl_close($ch);
    }   
    //this function is used to send user to doctor
     public function android_pushh1($deviceToken = null, $message = null,$title=null,$type = null,$notification_id=null,$badge = null)
    {
        $this->autoRender = false;
        $this->layout     = false;
      //  $type="";
        $url              = 'https://fcm.googleapis.com/fcm/send';
        $message          = array("message" => $badge['sender_name'].$message,'title'=>$title,'notification_id'=>$notification_id,'type'=>$type,'time'=> date('H:i:s'), "type" => $type, "batch" => $batch,'badge'=>$badge,'sound' => 'default');
        $registatoin_ids  = array($deviceToken); 
        $fields           = array('registration_ids' => $registatoin_ids, 'data' => $message);
          //$GOOGLE_API_KEY   = "AIzaSyCT1hAiELV9ogaDsrPfyTlBJ9ocI5jRqE0";
        $GOOGLE_API_KEY   = "AIzaSyB6VCNDG6L-GS2q4znlw4eX-mj5PDal5mc";
        $headers          = array(
            'Authorization: key=' . $GOOGLE_API_KEY,
            'Content-Type: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === false) {
            die('Curl failed: ' . curl_error($ch));
        } else {
        // print_r("success");die;
        }
        curl_close($ch);
    }   

    //pushnotification for iphone
    //this is used to send doctor to user  
   public function iphone($device_token="",$message="",$title="",$type="",$notification_id="",$badge)
    {
       // $device_token = "F1CBB2829CB905EAF01F847A0F3DA0D98080FCDCC6A1E677E6E4A7E595D58961";
        $passphrase       = '123456';
        $title = $message;
        $Text    = $message;
       // $type= "hjhg";
        $header = " ghhg";
        //$badge = "2";
       // $this->autoRender = false;
        //$this->layout     = false;
        $basePath         = 'DrNow_User_new.pem';
        
       // if(fopen($basePath,'r'))   {
         // echo "hi";die;
            $ctx = stream_context_create();
            stream_context_set_option($ctx, 'ssl', 'local_cert', $basePath);
            stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
            $fp = stream_socket_client(
                'ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx
            );
            if (!$fp) {
                exit("Failed to connect: $err $errstr" . PHP_EOL);
            }
            $body['aps'] = array('alert' => array("body" => $Text,'type'=> $type,'title'=>$title,'notification_id'=>$notification_id,'header'=>$header),'badge'=>$badge,'sound' => 'default');
            // print_r($body);die;
            $payload     = json_encode($body);
         
            $msg         = chr(0) . pack('n', 32) . pack("H*",$device_token) . pack('n', strlen($payload)) . $payload;
            $result      = fwrite($fp, $msg, strlen($msg));
            

             if ($result === false) {

               
        //  print_r("hi");die;
             } else {

            // echo print_r("success");die;
      
              }
            
            fclose($fp);
     //   }

   }

    public function iphone1($device_token="",$message="",$title="",$type="",$notification_id="",$badge="")
    {
       // $device_token = "F1CBB2829CB905EAF01F847A0F3DA0D98080FCDCC6A1E677E6E4A7E595D58961";
        $passphrase       = '123456';
        $title = $message;
        $Text    = $message;
       // $type= "hjhg";
        $header = " ghhg";
       
       // $this->autoRender = false;
        //$this->layout     = false;
        $basePath         = 'CertificatesDrNow.pem';
        
       // if(fopen($basePath,'r'))   {
         // echo "hi";die;
            $ctx = stream_context_create();
            stream_context_set_option($ctx, 'ssl', 'local_cert', $basePath);
            stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
            $fp = stream_socket_client(
                'ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx
            );
            if (!$fp) {
                exit("Failed to connect: $err $errstr" . PHP_EOL);
            }
            $body['aps'] = array('alert' => array("body" => $Text,'type'=> $type,'title'=>$title,'notification_id'=>$notification_id,'header'=>$header),'badge'=>$badge,'sound' => 'default');

          // $body['aps'] = array('alert' => array('title' => $title,"body"=>$Text),'sound' =>'default','badge'=>$badge);
          // $body['body'] = $Text;
          // $body['type'] = $type;
          // $body['notification_id'] = $notification_id;
         
            $payload     = json_encode($body);
           //  print_r($body);die;
         
            $msg         = chr(0) . pack('n', 32) . pack("H*",$device_token) . pack('n', strlen($payload)) . $payload;
            $result      = fwrite($fp, $msg, strlen($msg));
            

             if ($result === false) {

               
        //  print_r("hi");die;
             } else {

           //   echo print_r("success");die;
      
              }
            
            fclose($fp);
     //   }

   }


  
    public function distance($lat1, $lon1, $lat2, $lon2, $unit) 
    {

            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) *sin(deg2rad($lat2)) + cos(deg2rad($lat1))* cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist* 60 *1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
            return ($miles * 1.609344);
            } else if ($unit == "N") {
            return ($miles * 0.8684);
            } else {
            return $miles;
            }

   }

   //for user chat
public function userChat($cond)
{
     $this->db->select('c.id,c.message,c.created_date,c.sender_type,c.user_type,u.name,u.image,u.id as userid');
          $this->db->from('doctor_chat as c');
           $this->db->join(USER.' as u', 'u.id=c.user_id','inner');
         // $this->db->join(DOCTOR.' as d', 'd.id=b.doctor_id','inner');
          $this->db->where($cond);
          $this->db->order_by('c.id','ASC');
          $data = $this->db->get();
       
        return ($data->num_rows() >0)?$data->result():NULL;
}

 //for doctor chat
public function doctorChat($cond)
{
     $this->db->select('c.id,c.message,c.created_date,c.sender_type,c.user_type,d.name,d.image,d.id as doctorid');
          $this->db->from('doctor_chat as c');
           $this->db->join(DOCTOR.' as d', 'd.id=c.user_id','inner');
         // $this->db->join(DOCTOR.' as d', 'd.id=b.doctor_id','inner');
          $this->db->where($cond);
          $this->db->order_by('c.id','ASC');
          $data = $this->db->get();
       
        return ($data->num_rows() >0)?$data->result():NULL;
}

public function userChatIist($cond)
{
     $this->db->select('u.id,c.message,c.created_date,u.name,u.image,c.id as chat_id');
          $this->db->from('doctor_chat as c');
           $this->db->join(USER.' as u', 'u.id=c.user_id','inner');
         // $this->db->join(DOCTOR.' as d', 'd.id=b.doctor_id','inner');
          $this->db->where($cond);
           $this->db->order_by('c.id','DESC');
          $this->db->group_by('user_id');
           
          $data = $this->db->get();
       
        return ($data->num_rows() >0)?$data->result():NULL;
}

public function doctorChatIist($cond)
{
     $this->db->select('d.id,c.message,c.created_date,d.name,d.image');
          $this->db->from('doctor_chat as c');
           $this->db->join(DOCTOR.' as d', 'd.id=c.user_id','inner');
         // $this->db->join(DOCTOR.' as d', 'd.id=b.doctor_id','inner');
          $this->db->where($cond);
         $this->db->order_by('c.id','DESC');
          $this->db->group_by('user_id');
          $data = $this->db->get();
       
        return ($data->num_rows() >0)?$data->result():NULL;
}

public function getTime($originsAddrs,$destinationAddrs)
{
 
  $geocodeFromAddr = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=imperial&origins='.urlencode($originsAddrs).'&destinations='.urlencode($destinationAddrs).'&key=AIzaSyD4DT_GCr9NRwa59751r3XgB6TDPiLxq5s'); 
           return $output = json_decode($geocodeFromAddr);
           // echo "<pre>";print_r($output);die;
}

   
}


