<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Changepassword extends MY_Controller {
   	public function __construct()
   	{
	  	parent::__construct();
		
        $this->load->model('My_model');
       $this->load->model('user_model');
       //  if($this->session->userdata('user_logged_in')==FALSE):
       //   redirect('logout');
       // endif;
   	}
   	
   	public function index()
   	{  		
		$data['title'] 	= COMPANYNAME.' | Change Password';
		$this->load->view('common/header',$data);
    $this->load->view('common/left-sidebar');
    $this->load->view('login/admin_change_password');
    $this->load->view('common/footer');
	}

  public function updatepassword()
  {
    $userid       = $this->session->userdata('userid');
    $newPass      =md5($this->input->post('new_pass')); 
    $oldPass      =md5($this->input->post('old_pass'));   
    $confPass     =md5($this->input->post('con_pass')); 

    $condition_array = array(
                'id'        => '1',
                'password'  =>  $oldPass,
               ); 
            //   print_r($condition_array);die;
     
   if($this->input->post('new_pass')!=$this->input->post('old_pass'))
    {
   $result = $this->user_model->getCondResult('doctor_admin','id',$condition_array);
  // echo $this->db->last_query();die;
   if(!empty($result))
   { 
     //echo "fdfg";die;
    $data_array=array("password" =>$newPass);
     if($newPass==$confPass)
     {
     $update =$this->My_model->update_data('doctor_admin',$condition_array,$data_array);
      
     $this->msgsuccess("Password update successfully.");
     redirect('dashboard');
    }
    else
    {   $this->msgerror('New password must be equal to Confirm password.');
      redirect('Changepassword');  
    }
   }
    else
   {
     $this->msgerror('Old Password Worng'); 
       redirect('Changepassword'); 
    }
  
  
  
}
else

{
  $this->msgerror('New Password must be diffrent to Old Password'); 
    redirect('Changepassword');  
}
  }


}