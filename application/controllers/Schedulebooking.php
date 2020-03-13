<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/////====	START LEAD CONTROLLERS CLASS   =======///////
class Schedulebooking extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
	    $this->load->model('my_model');
	    $this->load->model('user_model');

		$this->load->model('com_model');
	   	$this->perPage = 10;
		
	} 
	   

public function index()
	{ 
    $this->load->library('Ajax_pagination');
		$tables = BOOKING;
		$data = array();
		$conditions = array();
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
        $totalRec = count($this->com_model->scheduleBooking($conditions));
        $config['target']      = '#postList';
        $config['base_url']    = base_url('schedulebooking/ajaxPaginationData');
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
		$config['colspan']     = 9;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;

        $this->ajax_pagination->initialize($config);

	   	$conditions['start'] = $offset;
	   	$conditions['limit'] = $this->perPage;  
		$data['scheduling'] = $this->com_model->scheduleBooking($conditions);
       //print_r($data['schedule']);die;
		//echo $this->db->last_query();die;
	   $data['title']  = COMPANYNAME.' | Schedule Booking';	
	   $this->load->view('common/header',$data);
	   $this->load->view('common/left-sidebar');
	   $this->load->view('schedulebooking/booking_view');
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
		$totalRec = count($this->com_model->scheduleBooking($conditions));
		$config['target']      = '#postList';
        $config['base_url']    = base_url().'schedulebooking/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $perPage;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;
		$config['colspan']     = 9;
        $this->ajax_pagination->initialize($config);
        
        $conditions['start'] = $offset;
        $conditions['limit'] = $perPage;
        
        $data['scheduling'] = $this->com_model->scheduleBooking($conditions);
        //echo $this->db->last_query();die;
        $this->load->view('schedulebooking/booking_in', $data, false);
    }

  public function details($id="")
  {
        // echo $id;die;
         $data['title']  = COMPANYNAME.' | View Booking';	
         $data['booking']  = $this->com_model->sceduleDetail(array('user_id'=>$id,'booking_type'=>'scheduling'));
      //   echo "<pre>";print_r($data['booking']);die;
	     $this->load->view('common/header',$data);
	     $this->load->view('common/left-sidebar');
	     $this->load->view('schedulebooking/booking_detail_view');
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
      	     $this->load->view('schedulebooking/accept_booking',$data);
      	    // echo 1;
            // }

  }


public function rejectBooking()
{ 
    
    $data['booking_id'] = $this->input->post('id');
    $this->load->view('schedulebooking/reject_booking_view',$data);
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





  


}
?>
