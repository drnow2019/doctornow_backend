<?php 
session_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cronjobapi  extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('my_model');
        $this->load->model('user_model');
        date_default_timezone_set('Asia/Calcutta'); 
    } 


   // this function is used to cancelled booking automatic
 function cancelBooking()
 {
    //echo date('H:i');die;
   $booking =   $this->user_model->getCondResultArray(BOOKING,'id,created_date,user_id,doctor_id',array('booking_status'=>'0'));
   //echo $this->db->last_query();die;
   if(!empty($booking))
   {
    //echo "hello";
    foreach($booking as $values)
    {
     $booking_time = date('H:i',strtotime($values['created_date']));
     $currentTime = date('H:i');
     $booking_id = $values['id'];
     $userId = $values['user_id'];
     $doctorId = $values['doctor_id'];
     //$after30minTime = date("H:i", strtotime('+29 minutes', strtotime($booking_time)));
             $datetime1 = strtotime($booking_time);
             $datetime2 = strtotime($currentTime);
             $interval  = abs($datetime2 - $datetime1);
             $minutes   = round($interval / 60);
             if($minutes==25) //this notification send to doctr for alert(doctor app) 25
             {
              $doctorDetail = $this->user_model->fieldCondRow(DOCTOR,'device_token,device_type,notification_status,language_type',array('id'=>$doctorId));
              $doctor_notification_status = $doctorDetail->notification_status;
              $doctor_language_type1      = $doctorDetail->language_type;
              $doctor_device_token        = $doctorDetail->device_token;
              $doctor_device_type         = $doctorDetail->device_type;
                
        if($doctor_language_type1=='en'){
        $doctor_message = "Please confirm the pending booking before it get's cancelled";
        $doctor_title = "Please confirm the pending booking before it get's cancelled";
         }else if($doctor_language_type1=='hi'){
          $doctor_message = "कृपया रद्द होने से पहले लंबित बुकिंग की पुष्टि करें";
          $doctor_title = "कृपया रद्द होने से पहले लंबित बुकिंग की पुष्टि करें"; 
         }
         $type = "cancelled";

       $notificationData = array(
                                  'user_id'=> $userId,
                                  'doctor_id'=> $doctorId,
                                  'booking_id'=> $values['id'],
                                  'title'=> $doctor_title,
                                  'message'=> $doctor_message,
                                  'type'   => $type,
                                  'status' => '0',
                                   'badge_count'=>'1',
                                  'send_to'=>'doctor',
                                  'created_date'=> date('Y-m-d H:i:s'),
                                 );
       $notificationId=$this->user_model->insert_data('notification',$notificationData);
        $notificationCount = count($this->user_model->getCondResult('notification','id',array('doctor_id'=>$doctorId,'status'=>'0','badge_count'=>'1','send_to'=>'doctor','type!='=>'adminChatDoctor'))); 
     if($doctor_notification_status=="on"){   
      if($doctor_device_type=="android"){
       
       $this->user_model->android_pushh1($doctor_device_token,$message,$title,$type,$notificationId,$notificationCount);
      }

      else if($doctor_device_type=="Iphone"){
       
        $this->user_model->iphone1($doctor_device_token,$message,$title,$type,$notificationId,$notificationCount);
      }
    }

   // }

        }
      if($minutes>=30)  //this msg send to user for cancilation 30 min
        {
                //update here
          $updateStatus = array('booking_status'=>'5');     
          $update =   $this->user_model->update_data(BOOKING,$updateStatus,array('id'=>$booking_id));
     if($update)
      {
 //send notification start
  $userdetial = $this->user_model->fieldCondRow(USER,'device_token,device_type,notification_status,language_type',array('id'=>$userId)); //notification send when status is on
  $notification_status = $userdetial->notification_status;
  $language_type1      = $userdetial->language_type;
  $device_token        = $userdetial->device_token;
  $device_type        = $userdetial->device_type;
  $type                = "cancelled";
      
        if($language_type1=='en'){
        $message = "Unfortunately, Dr will not be able to attain. Please contact Admin ";
        $title = "Unfortunately, Dr will not be able to attain. Please contact Admin";
         }else if($language_type1=='hi'){
          $message = "दुर्भाग्य से, डॉ। प्राप्त करने में सक्षम नहीं होंगे। कृपया व्यवस्थापक से संपर्क करें";
          $title = "दुर्भाग्य से, डॉ। प्राप्त करने में सक्षम नहीं होंगे। कृपया व्यवस्थापक से संपर्क करें"; 
         }

       $notificationData = array(
                                  'user_id'=> $userId,
                                  'doctor_id'=> $id,
                                  'booking_id'=> $values['id'],
                                  'title'=> $title,
                                  'message'=> $message,
                                  'type'   => $type,
                                  'status' => '0',
                                   'badge_count'=>'1',
                                  'send_to'=>'user',
                                  'created_date'=> date('Y-m-d H:i:s'),
                                 );
       $notificationId=$this->user_model->insert_data('notification',$notificationData);
        $notificationCount = count($this->user_model->getCondResult('notification','id',array('user_id'=>$userId,'status'=>'0','badge_count'=>'1','send_to'=>'user','type!='=>'adminChatUser')));  
     if($notification_status=="on"){   
      if($device_type=="android"){
       
       $this->user_model->android_pushh($device_token,$message,$title,$type,$notificationId,$notificationCount);
      }

       if($device_type=="Iphone"){
       
        $this->user_model->iphone($device_token,$message,$title,$type,$notificationId,$notificationCount);
      }
}
  //  } //end check notification
      //send notification end
          }

           // echo $this->db->last_query();
             
            }
    }
   }
  
 }


 function paymentBooking()
 {
   // $this->user_model->android_pushh("cWLFip0hlkI:APA91bHkNwkRXP41ssWjHEgEjEfdDFzJtjHNrKPDPsNzTzh6I4epGVlSnimp5Cgl4iPMwTFaffd71uFydMMbIVOPS27kL_cKa1J75doMKRQ-9hxd7XvD3rxUdWNiGqZMu2FlPSI6NjxA","msg","title","ty",7,3);die;
 	 $booking =   $this->user_model->getCondResultArray(BOOKING,'id,updated_date,user_id,doctor_id',array('booking_status'=>'1'));
   //echo $this->db->last_query();die;
   if(!empty($booking))
   {
    //echo "hello";
    foreach($booking as $values)
    {
     $booking_time = date('H:i',strtotime($values['updated_date']));
     $currentTime = date('H:i');
     $booking_id = $values['id'];
     $userId = $values['user_id'];
     $doctorId = $values['doctor_id'];
     //$after30minTime = date("H:i", strtotime('+29 minutes', strtotime($booking_time)));
             $datetime1 = strtotime($booking_time);
             $datetime2 = strtotime($currentTime);
             $interval  = abs($datetime2 - $datetime1);
             $minutes   = round($interval / 60);
             if($minutes>30) //booking cancelled here and send notification to user app
             {
             $updateStatus = array('booking_status'=>'5');     //5 for cancel
             $update =   $this->user_model->update_data(BOOKING,$updateStatus,array('id'=>$booking_id));
              $doctorDetail = $this->user_model->fieldCondRow(DOCTOR,'device_token,device_type,notification_status,language_type',array('id'=>$doctorId));
              $doctor_notification_status = $doctorDetail->notification_status;
              $doctor_language_type1      = $doctorDetail->language_type;
              $doctor_device_token        = $doctorDetail->device_token;
              $doctor_device_type         = $doctorDetail->device_type;
              if($doctor_notification_status=="on"){    
        if($doctor_language_type1=='en'){
        $doctor_message = "Please confirm the pending booking before it get's cancelled";
        $doctor_title = "Please confirm the pending booking before it get's cancelled";
         }else if($doctor_language_type1=='hi'){
          $doctor_message = "कृपया रद्द होने से पहले लंबित बुकिंग की पुष्टि करें";
          $doctor_title = "कृपया रद्द होने से पहले लंबित बुकिंग की पुष्टि करें"; 
         }
         $type = "cancelled";

       $notificationData = array(
                                  'user_id'=> $userId,
                                  'doctor_id'=> $doctorId,
                                  'booking_id'=> $values['id'],
                                  'title'=> $doctor_title,
                                  'message'=> $doctor_message,
                                  'type'   => $type,
                                  'status' => '0',
                                   'badge_count'=>'1',
                                  'send_to'=>'doctor',
                                  'created_date'=> date('Y-m-d H:i:s'),
                                 );
       $notificationId=$this->user_model->insert_data('notification',$notificationData);
        $notificationCount = count($this->user_model->getCondResult('notification','id',array('doctor_id'=>$doctorId,'status'=>'0','badge_count'=>'1','send_to'=>'doctor','type!='=>'adminChatDoctor')));   
      if($doctor_device_type=="android"){
       
       $this->user_model->android_pushh1($doctor_device_token,$message,$title,$type,$notificationId,$notificationCount);
      }

       if($doctor_device_type=="Iphone"){
       
        $this->user_model->iphone1($doctor_device_token,$message,$title,$type,$notificationId,$notificationCount);
      }

    }

        }
        if($minutes==25)  //user reminder notification message
        {
                
 //send notification start
  $userdetial = $this->user_model->fieldCondRow(USER,'name,device_token,device_type,notification_status,language_type',array('id'=>$userId)); //notification send when status is on
  $notification_status = $userdetial->notification_status;
  $language_type1      = $userdetial->language_type;
  $device_token        = $userdetial->device_token;
  $device_type        = $userdetial->device_type;
  $username        = $userdetial->name;
  $type                = "cancelled";
       
        if($language_type1=='en'){
        $message = "Dear ".ucwords($username).", Your booking is going to cancel,please make a paymnet within 5 minutes";
        $title = "Dear ".ucwords($username)." Your booking is going to cancel,please make a paymnet within 5 minutes";
         }else if($language_type1=='hi'){
          $message = "प्रिय ".ucwords($username)." आपकी बुकिंग रद्द होने जा रही है, कृपया 5 मिनट के भीतर एक भुगतान करें";
          $title = "प्रिय ".ucwords($username)." आपकी बुकिंग रद्द होने जा रही है, कृपया 5 मिनट के भीतर एक भुगतान करें"; 
         }

       $notificationData = array(
                                  'user_id'=> $userId,
                                  'doctor_id'=> $id,
                                  'booking_id'=> $values['id'],
                                  'title'=> $title,
                                  'message'=> $message,
                                  'type'   => $type,
                                  'status' => '0',
                                   'badge_count'=>'1',
                                  'send_to'=>'user',
                                  'created_date'=> date('Y-m-d H:i:s'),
                                 );
       $notificationId=$this->user_model->insert_data('notification',$notificationData);
        $notificationCount = count($this->user_model->getCondResult('notification','id',array('user_id'=>$userId,'status'=>'0','badge_count'=>'1','send_to'=>'user','type!='=>'adminChatUser')));  
   if($notification_status=="on"){    
      if($device_type=="android"){
       
       $this->user_model->android_pushh($device_token,$message,$title,$type,$notificationId,$notificationCount);
      }

       if($device_type=="Iphone"){
       
        $this->user_model->iphone($device_token,$message,$title,$type,$notificationId,$notificationCount);
      }
    }

   // } //end check notification
      //send notification end
         // }

           // echo $this->db->last_query();
             
            }
    }
   }
 }

}