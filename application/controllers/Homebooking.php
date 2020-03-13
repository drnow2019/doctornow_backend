<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/////====	START LEAD CONTROLLERS CLASS   =======///////
class Homebooking extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
	    $this->load->model('my_model');
	    $this->load->model('user_model');

		$this->load->model('com_model');
	   	$this->perPage = 10;
	   	 // if($this->session->userdata('user_logged_in')==FALSE):
      //    redirect('logout');
      //  endif;
		
	} 
	   

public function index()
	{ 
    $this->load->library('Ajax_pagination');
		$tables = BOOKING;
		$data = array();
		$cond = "id > 0 ";
		$keywords   = $this->input->get('keywords');
        $sortBy 	 = $this->input->get('sortBy');
        $perPage 	 = $this->input->get('perpage');
        $activePage  = $this->input->get('activePage');
        
         if(!empty($keywords))
             $conditions['search']['keywords'] = $keywords;

   
       
      $page = $this->input->get('page');
        if(!$page)
            $offset = 0;
        else
            $offset = $page; 

        if($perPage)
			$this->perPage = $perPage;

	
	
		$fields = "*";
        $totalRec = count($this->com_model->homeBooking($conditions));
        $config['target']      = '#postList';
        $config['base_url']    = base_url('homebooking/ajaxPaginationData');
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
		$config['colspan']     = 9;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;

        $this->ajax_pagination->initialize($config);

	   	$conditions['start'] = $offset;
	   	$conditions['limit'] = $this->perPage;  
		$data['booking'] = $this->com_model->homeBooking($conditions);
//	echo"<pre>";print_r($data['booking']);die;
	//	echo $this->db->last_query();die;
	   $data['title']  = COMPANYNAME.' | Home Booking';	
	   $this->load->view('common/header',$data);
	   $this->load->view('common/left-sidebar');
	   $this->load->view('booking/booking_view');
	    $this->load->view('common/footer');
	}

	function ajaxPaginationData()
	{
		$this->load->library('Ajax_pagination');
	   		
        $conditions = array();
        $tables = BOOKING;
        //calc offset number
        $page = $this->input->get('page');
        if(!$page)
            $offset = 0;
        else
            $offset = $page;
        
	    $keywords   = $this->input->get('keywords');
        $perPage 	= $this->input->get('perpage');
        $activePage = $this->input->get('activePage');
        //$cond       = " id > 0";
        
         if(!empty($keywords))
            $conditions['search']['keywords'] = $keywords;
        
		 
		$fields = "*";
		$totalRec = count($this->com_model->homeBooking($conditions));
		$config['target']      = '#postList';
        $config['base_url']    = base_url().'homebooking/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $perPage;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;
		$config['colspan']     = 9;
        $this->ajax_pagination->initialize($config);
        
        $conditions['start'] = $offset;
        $conditions['limit'] = $perPage;
        
        $data['booking'] = $this->com_model->homeBooking($conditions);
        //echo $this->db->last_query();die;
        $this->load->view('booking/booking_in', $data, false);
    }

  public function details($id="")
  {
        // echo $id;die;
         $data['title']  = COMPANYNAME.' | View Booking';	
         
         $data['booking']  = $this->com_model->bookingDetail(array('b.id'=>$id));
        // echo "<pre>";print_r($data['booking']);die;
	     $this->load->view('common/header',$data);
	     $this->load->view('common/left-sidebar');
	     $this->load->view('booking/booking_detail_view');
	     $this->load->view('common/footer');

  }	
  
  public function acceptBooking()
  {
             $booking_id = $this->input->post('id');
             if($booking_id){
              $update = $this->my_model->update_data(BOOKING,array('id'=>$booking_id),array('booking_status'=>'1'));     
             // $data['status']=$this->user_model->fetchvalue(BOOKING,'booking_status',array('id'=>$booking_id));
             }
           //  if($update)
           //  {
      	     $this->load->view('booking/accept_booking',$data);
      	    // echo 1;
            // }

  }


public function rejectBooking()
{ 
    
    $data['booking_id'] = $this->input->post('id');
    $this->load->view('booking/reject_booking_view',$data);
}

public function updateRejectStatus()
{
  // echo  $data['user_id'] = $this->uri->segment(3);die;
  $reason = $this->input->post('reject_reason');
  $booking_id = $this->input->post('booking_id');
  $data = array('booking_status'=>'2','reject_reason'=>$reason);
  $update = $this->my_model->update_data(BOOKING,array('id'=>$booking_id),$data); 
  	if($update)
		{
          echo 1;
        }   
      	 
	} 
	
	
public function paymentStatus()
{
    
$booking_id = $this->input->post('id');
  $data = array('booking_status'=>'3');
  $update = $this->my_model->update_data(BOOKING,array('id'=>$booking_id),$data); 
 // echo $this->db->last_query();
  	if($update)
		{
          echo 1;
        } 
        
}
        
    function bookingStatus()
    {
     $booking_id = $this->input->get('id');  
     $status = $this->input->get('status');
       //send notification start
        $bookingDetails = $this->user_model->fieldCondRow(BOOKING,'user_id,doctor_id',array('id'=>$booking_id));
         $userId = $bookingDetails->user_id;
        $doctorId = $bookingDetails->doctor_id;   
        $userDetails = $this->user_model->getCondResultArray(USER,'id,device_type,device_token,notification_status',array('id'=>$userId)); 
        $device_token =  $userDetails[0]['device_token'];
        $device_type =  $userDetails[0]['device_type'];
       
       
      if($status=='0')
     {
         $msg="Booking Pending successfully";
     }
     if($status=='1')
     {
         $msg="Booking Accepted successfully";
         //start notification
        $message = "Your Booking Request has been confirmed, Please proceed with the Payment";
        $title = "Your Booking Request has been confirmed, Please proceed with the Payment";
       $type = 'accepted';
     if($userDetails[0]['notification_status']=="on"){
        $notificationData = array(
                                  'user_id'=> $userId,
                                  'doctor_id'=> $doctorId,
                                  'booking_id'=> $booking_id,
                                  'title'=> $title,
                                  'message'=> $message,
                                  'type'   => $type,
                                  'status'=>'0',
                                  'badge_count'=>'1',
                                  'send_to'=>'user',
                                  'created_date'=> date('Y-m-d H:i:s'),
                                 );
      if($device_type=="android")
      {
     
       $notificationID=   $this->user_model->insert_data('notification',$notificationData);
    $notificationCount = count($this->user_model->getCondResult('notification','id',array('user_id'=>$userId,'status'=>'0','badge_count'=>'1','send_to'=>'user','type!='=>'adminChatUser'))); 

    //  echo $this->db->last_query();die;
      $this->user_model->android_pushh($device_token,$message,$title,$type,$notificationID,$notificationCount);
      }
      //ios
    if($device_type=="Iphone")
    {
     
         $notificationID= $this->user_model->insert_data('notification',$notificationData);
        $notificationCount = count($this->user_model->getCondResult('notification','id',array('user_id'=>$userId,'status'=>'0','badge_count'=>'1','send_to'=>'user','type!='=>'adminChatUser'))); 

        // echo $this->db->last_query();die;
        $this->user_model->iphone($device_token,$message,$title,$type,$notificationID,$notificationCount);
    }
  }
      //send notification end
     }
     
      if($status=='2')
     {
         $msg="Booking Rejected successfully";
           //start notification
        $message = "Unfortunately, Dr will not be able to attain. Please contact Admin";
        $title = "Unfortunately, Dr will not be able to attain. Please contact Admin";
        $type = 'rejected';
       if($userDetails[0]['notification_status']=="on"){
        $notificationData = array(
                                  'user_id'=> $userId,
                                  'doctor_id'=> $doctorId,
                                  'booking_id'=> $booking_id,
                                  'title'=> $title,
                                  'message'=> $message,
                                  'type'   => $type,
                                  'status'=>'0',
                                  'badge_count'=>'1',
                                  'send_to'=>'user',
                                  'created_date'=> date('Y-m-d H:i:s'),
                                 );
      if($device_type=="android")
      {
     
       $notificationID=   $this->user_model->insert_data('notification',$notificationData);
    $notificationCount = count($this->user_model->getCondResult('notification','id',array('user_id'=>$userId,'status'=>'0','badge_count'=>'1','send_to'=>'user','type!='=>'adminChatUser'))); 

      // echo $this->db->last_query();die;
      $this->user_model->android_pushh($device_token,$message,$title,$type,$notificationID,$notificationCount);
      }
      //ios
    if($device_type=="Iphone")
    {
     
         $notificationID= $this->user_model->insert_data('notification',$notificationData);
        // echo $this->db->last_query();die;
        $notificationCount = count($this->user_model->getCondResult('notification','id',array('user_id'=>$userId,'status'=>'0','badge_count'=>'1','send_to'=>'user','type!='=>'adminChatUser'))); 
        $this->user_model->iphone($device_token,$message,$title,$type,$notificationID,$notificationCount);
    }
  }
      //send notification end
     }
     if($status=='3')
     {
         $msg="Booking Payment Accepted successfully";
     }
     if($status=='5')
     {
      $msg= "Booking cancelled successfully";    
        //start notification
        $message = "Unfortunately, Dr will not be able to attain. Please contact Admin";
        $title = "Unfortunately, Dr will not be able to attain. Please contact Admin";
        $type = 'cancelled';
        if($userDetails[0]['notification_status']=="on"){
        $notificationData = array(
                                  'user_id'=> $userId,
                                  'doctor_id'=> $doctorId,
                                  'booking_id'=> $booking_id,
                                  'title'=> $title,
                                  'message'=> $message,
                                  'type'   => $type,
                                  'status'=>'0',
                                  'badge_count'=>'1',
                                  'send_to'=>'user',
                                  'created_date'=> date('Y-m-d H:i:s'),
                                 );
      if($device_type=="android")
      {
     
       $notificationID=   $this->user_model->insert_data('notification',$notificationData);
         $notificationCount = count($this->user_model->getCondResult('notification','id',array('user_id'=>$userId,'status'=>'0','badge_count'=>'1','send_to'=>'user','type!='=>'adminChatUser'))); 
      // echo $this->db->last_query();die;
      
      $this->user_model->android_pushh($device_token,$message,$title,$type,$notificationID,$notificationCount);
      }
      //ios
    if($device_type=="Iphone")
    {
     
         $notificationID= $this->user_model->insert_data('notification',$notificationData);
        $notificationCount = count($this->user_model->getCondResult('notification','id',array('user_id'=>$userId,'status'=>'0','badge_count'=>'1','send_to'=>'user','type!='=>'adminChatUser'))); 

        // echo $this->db->last_query();die;
        $this->user_model->iphone($device_token,$message,$title,$type,$notificationID,$notificationCount);
    }
  }
      //send notification end 
     }
   //  echo $this->db->last_query();
       $update = $this->my_model->update_data(BOOKING,array('id'=>$booking_id),array("booking_status"=>$status)); 
       //echo $this->db->last_query();
       	if($update){ 
				echo "ok";
				$this->msgsuccess($msg);
				
				}
			else { echo "fail";
				$this->msgwarning("Operation Failed ");
				}

     
    }






  


}
?>
