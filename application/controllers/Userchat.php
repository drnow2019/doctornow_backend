<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/////====	START LEAD CONTROLLERS CLASS   =======///////
class Userchat extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
	    $this->load->model('my_model');
		  $this->load->model('com_model');
		  $this->load->model('user_model');
	   	$this->perPage = 10;

       // if($this->session->userdata('user_logged_in')==FALSE):
       //   redirect('logout');
       // endif;
		
	} 
	   

public function index()
{ 

      // $data['user']= $this->user_model->userChatIist(array('u.status'=>'1','user_type'=>'user'));
        $data['user']= $this->db->query("SELECT max(c.id) as chatid,`u`.`id`, `c`.`message`, `c`.`created_date`, `u`.`name`, `u`.`image`, `c`.`id` as `chat_id` FROM `doctor_chat` as `c` INNER JOIN `doctor_user` as `u` ON `u`.`id`=`c`.`user_id` WHERE `u`.`status` = '1' AND `user_type` = 'user' GROUP BY `user_id` ORDER BY chatid DESC")->result();
     //  echo"<pre>"; print_r($data['user']);die;
      // echo $this->db->last_query();die;
	   $data['title']  = COMPANYNAME.' | Frees';	
	   $this->load->view('common/header',$data);
	   $this->load->view('common/left-sidebar');
	   $this->load->view('chat/user_chat_view');
	   $this->load->view('common/footer');
	  // die;
	}


function getuser()
{
	// $data['user']= $this->user_model->userChatIist(array('u.status'=>'1','user_type'=>'user'));
	  $data['user']= $this->db->query("SELECT max(c.id) as chatid,`u`.`id`, `c`.`message`, `c`.`created_date`, `u`.`name`, `u`.`image`, `c`.`id` as `chat_id` FROM `doctor_chat` as `c` INNER JOIN `doctor_user` as `u` ON `u`.`id`=`c`.`user_id` WHERE `u`.`status` = '1' AND `user_type` = 'user' GROUP BY `user_id` ORDER BY chatid DESC")->result();
	// echo $this->db->last_query();die;
	 $this->load->view('chat/user_search',$data);
}	
	
	function fetchuser()
	{
	   $keywords = $this->input->post('keywords');
	    	$cond = "u.status= '1' and user_type='user'";
	    if($keywords)
	    {
	     $cond .= " AND name LIKE '%".$keywords."%'";     
	    }

	     $data['user']= $this->user_model->userChatIist($cond);
	     //echo $this->db->last_query();die;
	     //  $data['user']  = $this->my_model->getfields('doctor_user','name,image',$cond);
	    // echo $this->db->last_query();die;
	  	   $this->load->view('chat/user_search',$data);


	  
	}
	
	function userDetails()
	{
	   // echo "hi";die;
	      $user_id = $this->input->post('user_id');
	     $data['user_id'] = $user_id; 
	     $data['chat']  = $this->com_model->userChat(array('user_id'=>$user_id,'user_type'=>'user'));
	     $this->user_model->update_data('doctor_chat',array('status'=>'0','badge_count'=>'0'),array('user_id'=>$user_id,'user_type'=>'user'));
	     $this->load->view('chat/user_detail_view',$data);
	}

	function userDetails1()
	{
	   // echo "hi";die;
	      $user_id = $this->input->post('user_id');
	     $data['user_id'] = $user_id; 
	     $this->user_model->update_data('doctor_chat',array('status'=>'0','badge_count'=>'0'),array('user_id'=>$user_id,'user_type'=>'user'));
	     $data['chat']  = $this->com_model->userChat(array('user_id'=>$user_id,'user_type'=>'user'));
	   // echo  json_encode($data);
	     $this->load->view('chat/user_detail_view1',$data);
	}
	
	
	function saveData()
	{
	  $query = $this->input->post('text');  
	  $user_id = $this->input->post('user_id'); 
	 
   

	  $insertData = array(
	      
	                      'user_id'=>$user_id,
	                      'message'=>$query,
	                      'sender_type'=>'reciver',
	                      'user_type'=>'user',
	                      'status'=>'1',
	                      'created_date'=> date('Y-m-d H:i:s'),
	                     );

	// echo "<pre>";
	// print_r($insertData);die;
    $insert= $this->my_model->insert_data('doctor_chat',$insertData) ;

	     
	      
	             

	      if($insert)
	      {
	      	 //send notification start
     $userDetail = $this->user_model->fieldCRow(USER,'notification_status,device_token,device_type',array('id'=>$user_id)); 
     $checkNotificationStatus = $userDetail->notification_status;
     $device_token = $userDetail->device_token;
     $device_type = $userDetail->device_type;
      
      if($checkNotificationStatus=="on"){ 
        
        $message = $query;
        $title = 'New message!';
         $type = 'adminChatUser';
        $notificationData = array(
                                  'user_id'=> $user_id,
                                  'doctor_id'=> '',
                                  'booking_id'=> '',
                                  'title'=> $title,
                                  'message'=> $message,
                                  'type'   => $type,
                                  'status'=>'0',
                                  'badge_count'=>'1',
                                  'send_to'=>'user',
                                  'created_date'=> date('Y-m-d H:i:s'),
                                 );
         $notificationID=   $this->user_model->insert_data('notification',$notificationData);
         //echo 
         $notificationCount = count($this->user_model->getCondResult('notification','id',array('user_id'=>$user_id,'status'=>'0','badge_count'=>'1','send_to'=>'user','type'=>'adminChatUser'))); 
      if($device_type=="android")
      {
         $this->user_model->android_pushh($device_token,$message,$title,$type,$notificationID,$notificationCount);
      }
       //ios
       if($device_type=="Iphone")
       {
      
         $this->user_model->iphone($device_token,$message,$title,$type,$notificationID,$notificationCount);
       }

    }  
      //send notification end

	          echo 1;
	      }else
	      {
	          echo 0;
	      }
	     //$this->load->view('chat/user_detail_view',$data); 
	                     
	}
	    
	

	


   


   

  
  


}
?>
