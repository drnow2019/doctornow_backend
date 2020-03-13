<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/////====	START LEAD CONTROLLERS CLASS   =======///////
class Notification extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
	    $this->load->model('my_model');
		$this->load->model('com_model');
		 $this->load->model('user_model');
	   	$this->perPage = 10;
	   // if($this->session->userdata('user_logged_in')==FALSE):
    //      redirect('logout');
    //    endif;
		
	} 
	   

public function index()
	{ 
    $this->load->library('Ajax_pagination');
	
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
        $totalRec = count($this->com_model->notification($conditions));
        $config['target']      = '#postList';
        $config['base_url']    = base_url('notification/ajaxPaginationData');
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
		$config['colspan']     = 9;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;

        $this->ajax_pagination->initialize($config);

	   	$conditions['start'] = $offset;
	   	$conditions['limit'] = $this->perPage;  
		$data['notification'] = $this->com_model->notification($conditions);
//	echo"<pre>";print_r($data['specificpromocode']);die;
		//echo $this->db->last_query();die;
	   $data['title']  = COMPANYNAME.' | Specific Promo Code';	
	   $this->load->view('common/header',$data);
	   $this->load->view('common/left-sidebar');
	   $this->load->view('notification/notification_view');
	    $this->load->view('common/footer');
	}

	function ajaxPaginationData()
	{
		$this->load->library('Ajax_pagination');
	   		
        $conditions = array();
        $tables = 'doctor_specificpromo';
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
		$totalRec = count($this->com_model->notification($conditions));
		$config['target']      = '#postList';
        $config['base_url']    = base_url().'notification/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $perPage;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;
		$config['colspan']     = 9;
        $this->ajax_pagination->initialize($config);
        
        $conditions['start'] = $offset;
        $conditions['limit'] = $perPage;
        
        $data['notification'] = $this->com_model->notification($conditions);
        //echo $this->db->last_query();die;
        $this->load->view('notification/notification_in', $data, false);
    }
    
    function importnotification()
    {
       $data['result'] = $this->my_model->fieldResult('bulk_notification','title,message,id,created_date',array('status'=>''));    
       $data['title']  = COMPANYNAME.' | Import Notification';	
	   $this->load->view('common/header',$data);
	   $this->load->view('common/left-sidebar');
	   $this->load->view('notification/import_notification');
	   $this->load->view('common/footer');
    }
    
   public function upload(){
        // print_r($_FILES);die;
		$this->load->helper('upload_helper');
		
		if($_FILES)
		{
			if (!empty($_FILES['upload']['name']))
		  	{

				$file      = upload_img('assets/csv','upload');
			//	print_r($file);die;
			 	$csv_files = $file['upload_data']['file_name'];
		 	}

		 	  $csv_files='assets/csv/'.$csv_files;
		
			if (($getfile = fopen($csv_files, "r")) !== FALSE)
		 	{
				$total=0;
			 
					
		    	while (($data = fgetcsv($getfile, 1000, ",")) !==  FALSE)
			 	{
			 		$total++;
		     		$num    = count($data);
		    		$result = $data;
		    	//	print_r($result);die;
					if($total <2) 
					{
						for($i=0;$i<=$num;$i++)
						{
							
					

					if(strtolower($result[$i]) =='title' ||strtolower($result[$i]) =='title') $title=$i;		//print_r($expertise_id);
                     if(strtolower($result[$i]) =='message' ||strtolower($result[$i]) =='message') $message=$i;
					
					

					
                  
                 					
						}
					}
					else
					{
						$sno = 0;
						
						$str   = implode(",", $result);
		  				$slice = explode(",", $str);

		  				
						$sno ++;
                        $title1 	    = $slice[$title];
						$message1    = $slice[$message];
						
						
						
                      $expData = array(
											'title'       => $title1,
											'message'   => $message1,
											'status'    => '1',
											'created_date'=> date('Y-m-d H:i:s'),
											
											
											);	
						$insert = $this->my_model->insert_data('bulk_notification',$expData);
					   //echo $this->db->last_query();die;
					}
					$sno = $total-1; 
				}
				if($insert){
					
					$msg  = "Uploaded sucessfully " ."<br />";
					$msg  .= "Total row are inserted into  ".$sno;
					$this->msgsuccess($msg);
					redirect("notification/importnotification");
				}
			}
		}
	}
	
	function edit()
	{    $id =   $this->input->post('id');
	     $data['result'] = $this->my_model->getfields('bulk_notification','message,title,id',array('id'=>$id));
	    $this->load->view('notification/edit_bulknotification',$data);
	}
	
	function update()
	{  
	    $id = $this->input->post('id');
	    $data = array(
	                   'title'  => $this->input->post('title'),
	                   'message'=> $this->input->post('message'),
	                );
	  $update= $this->my_model->update_data('bulk_notification',array('id'=> $id),$data); 
	  //echo $this->db->last_query();die;
	  if($update)
	  {
	    	$this->msgsuccess('Notification updated successfully');
			redirect("notification/importnotification");  
	  }
	}
	
	//send notification to all user
	
	function sendUser($id="")
	{
	 $notification = $this->my_model->getfields('bulk_notification','title,message,status',array('id'=>$id));
	 $title = $notification[0]->title;
	 $message = $notification[0]->message;
	 $type = 'bulk';
	 $users = $this->my_model->getfields(USER,'id,name,device_type,device_token',array('status'=>'1'));   
	 if(!empty($users))
	 {
	    foreach($users as $user)
	    {
	       $device_token = $user->device_token;
	       $device_type   = $user->device_type;
	       $userId        = $user->id;
	       
	            $notificationData = array(
                                  'user_id'=> $userId,
                               //   'doctor_id'=> $id,
                                 // 'booking_id'=> $booking_id,
                                  'title'=> $title,
                                  'message'=> $message,
                                  'type'   => $type,
                                  'status'=>'0',
                                  'send_to'=>'user',
                                  'created_date'=> date('Y-m-d H:i:s'),
                                 );
     $notificationID=   $this->user_model->insert_data('notification',$notificationData);
     if($device_type=='android')
	       {
      $this->user_model->android_pushh($device_token,$message,$title,$type,$notificationID);
	       }
	       else if($device_type=='Iphone')
	       {
	   $this->user_model->iphone($device_token,$message,$title,$type,$notificationID); 
	       }
	    }
	 }
	$this->msgsuccess('Notification send  successfully');
	redirect("notification/importnotification");   
	}
	
	//send notification to all doctor
	function sendDoctor($id="")
	{
	 $notification = $this->my_model->getfields('bulk_notification','title,message,status',array('id'=>$id));
	 $title = $notification[0]->title;
	 $message = $notification[0]->message;
	 $type = 'bulk';
	 $doctors = $this->my_model->getfields(DOCTOR,'id,name,device_type,device_token',array('status'=>'1'));   
	 if(!empty($doctors))
	 {
	    foreach($doctors as $doctor)
	    {
	       $device_token = $doctor->device_token;
	       $device_type   = $doctor->device_type;
	       $doctorId        = $doctor->id;
	      
	            $notificationData = array(
                                //  'user_id'=> $userId,
                                  'doctor_id'=> $doctorId,
                                 // 'booking_id'=> $booking_id,
                                  'title'=> $title,
                                  'message'=> $message,
                                  'type'   => $type,
                                  'status'=>'0',
                                  'send_to'=>'doctor',
                                  'created_date'=> date('Y-m-d H:i:s'),
                                 );
     $notificationID=   $this->user_model->insert_data('notification',$notificationData);
      if($device_type=='android')
	       {
      $this->user_model->android_pushh1($device_token,$message,$title,$type,$notificationID);
	       }
	       else if($device_type=='Iphone')
	       {
	       $this->user_model->iphone1($device_token,$message,$title,$type,$notificationID); 
	       }
	    }
	 }
	$this->msgsuccess('Notification send  successfully');
	redirect("notification/importnotification");   
	}
    
  


}
?>
