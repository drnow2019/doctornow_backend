<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends MY_Controller {
   	
   	public function __construct()
   	{
	  	parent::__construct();
        $this->load->model('My_model');
       $this->load->model('login_model');
       /// $this->load->model('user_model');
   	}
   	
   	public function index()
   	{  		
		$data['title'] 	= COMPANYNAME.' | Login page';
		$this->load->view("admin/login/login_view",$data);
	}

	public function adminlogin()
	{
		$redirecturl = "admin";
		$username	= $this->input->post('username');
		$pass 		= $this->input->post('password');
		if($username == "") { $this->msgerror('Username is empty'); }
		else if($pass == "") { $this->msgerror('Password is empty'); }
		else {
			$result1=$this->My_model->getfields(ADMIN,"username",array('username'=>$username),"");

		if(!empty($result1)){
				$cond = array ('username' =>$username,'password'=>md5($pass),'status'=>'1');
				$fields = "id,name,username,email";
				$result=$this->My_model->getfields(ADMIN,$fields,$cond,"");
			//	echo $this->db->last_query();die;
				//echo "<pre>";
				if(!empty($result)){
					
					
					$userdata = array(
						   'username'  	=> $result[0]->username,
						   'useremail'  => $result[0]->email,
						   'userid'     => $result[0]->id,
						   'permission' => $result[0]->id,
						   //'role'       =>$rolepermison,
						   'user_type'  =>$result[0]->user_type,
						   'user_logged_in' => TRUE
					   );
					
					$this->session->set_userdata($userdata);
					//echo"<pre>";
					//print_r($this->session->userdata);die;
					$redirecturl = "admin/dashboard";
				}
				else { $this->msgerror('Password is incorrect'); }
			}
			else { $this->msgerror('This Username is not registered'); }
		}
		///echo $redirecturl;
		redirect($redirecturl);
	} ////--- END LOGIN FUNCTION 
	
/////=====	START LOGOUT ======////
	public function logout()
	{
		$this->session->sess_destroy();  
		redirect('admin/admin');
	}
	
	public function changepassword()
   	{

   		//$id= $this->session->userdata('userid');die;
	   // $this->session->set_userdata(array('menu'=>'password'));
        $data['title'] = COMPANYNAME.' | Change Password';
        $this->load->view('admin/common/header',$data); 
 		$this->load->view('admin/common/left-sidebar');
		$this->load->view('admin/password/changepass_view');
		$this->load->view('admin/common/footer');	

   	} 

   	public function changepass()
   	{
    $userid        = $this->session->userdata('userid');
   	$newPass      =md5($this->input->post('newpwd')); 
   	$oldPass      =md5($this->input->post('oldpwd')); 	
   	$confPass     =md5($this->input->post('conpwd')); 

   	$condition_array = array(
							  'id'        =>  $userid,
							  'password'  =>  $oldPass,
							 );	
     

   $result = $this->login_model->authenticate(ADMIN,$condition_array);
  if(count($result)==1)
   { 
   	 
   	$data_array=array("password" =>$newPass);
     if($newPass==$confPass)
   	 {
   	 $update =$this->My_model->update_data(ADMIN,$condition_array,$data_array);

					$logdata =array(
					  	              'user_id'      =>$userid,
					  	              'activity'     =>'CHANGE_PASSWORD',
					  	              'created_date' =>date('Y-m-d h:i:s'),
                                      'description'  =>"password changed successfully",

					                   );
					 $this->my_model->logactivity($logdata);
     $this->msgsuccess("Password update successfully");
     redirect('admin/changepassword');
   	}
   	else
   	{   $this->msgerror('Password Mismatch');
   		
		redirect('admin/changepassword');	
   	}
   }
    else
   {

    		 
    		$this->msgerror('Old Password Worng '); 
		   redirect('admin/changepassword');	
    }
	
	
	
}
}



