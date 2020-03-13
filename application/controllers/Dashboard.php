<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/////====	START LEAD CONTROLLERS CLASS   =======///////
class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
	    $this->load->model('my_model');
		$this->load->model('com_model');
	   	$this->perPage = 10;
	   	 // if($this->session->userdata('user_logged_in')==FALSE):
      //    redirect('logout');
      //  endif;
		
	} 
	   
	public function index()
	{ 
		// echo CI_VERSION;die; 
	//	echo phpinfo();die;
	   $data['user']  = $this->my_model->coutrows(USER,'id');  
	   $data['doctor']  = $this->my_model->coutrows(DOCTOR,'id');
	   $cond = "booking_type='home' OR booking_type='scheduling'";
	   $data['homeBooking']  = $this->my_model->coutrow('doctor_booking','id',$cond);  
	   $data['callBooking']  = $this->my_model->coutrow('doctor_booking','id',array('booking_type'=>'call'));  
	   //Calculate total doctor earning according to month
	   $year = date('Y');
	   $earning = $this->db->query("select sum(amount) as amt,MONTH(created_date) as month from doctor_payment where DATE_FORMAT(created_date,'%Y') = '".$year."' GROUP BY DATE_FORMAT(created_date, '%m')")->result();
	   
	 // echo $amt;die;
	  
	  
   
	 
	  

	 // echo $this->db->last_query();die;
	   $data['title']  = COMPANYNAME.' | Dashboard';	
	   $this->load->view('common/header',$data);
	   $this->load->view('common/left-sidebar');
	   $this->load->view('dashboard/dashboard');
	   $this->load->view('common/footer');
}	
}
?>
