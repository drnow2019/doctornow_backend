<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Adminlogin extends MY_Controller {
   	public function __construct()
   	{
	  	parent::__construct();
		
        $this->load->model('My_model');
       
   	}
   	
   	public function index()
   	{  		
		$data['title'] 	= COMPANYNAME.' | Login';
		$this->load->view("login/login_view",$data);
		//echo "sdffsd";;die;
	}

	public function login(){

		//print_r($_POST);die;
		$redirecturl = base_url("admin"); //exit;
		$username	= $this->input->post('email');
		$pass 		= $this->input->post('password');
		if($username == "") { $this->msgerror('Username is empty'); }
		else if($pass == "") { $this->msgerror('Password is empty'); }
		else {
			$result1=$this->My_model->getfields(ADMIN,"username",array('username'=>$username),"");
//echo $this->db->last_query();die;
		if(!empty($result1)){
				$cond = array ('username' =>$username,'password'=>md5($pass),'status'=>'1');
				$fields = "id,name,username,email";
				$result=$this->My_model->getfields(ADMIN,$fields,$cond,"");
			//	echo $this->db->last_query();die;
				//echo "<pre>";
				if(!empty($result)){
					
				
					$userdata = array(
						   'username'  	=> $result[0]->username,
						   'email'  => $result[0]->email,
						   'userid'     => $result[0]->id,
						   'logintype'  => "admin",
						  // 'user_type'  =>$result[0]->user_type,
						   'user_logged_in' => TRUE
					   );
                      if($this->input->post('remember')=='1'){

                    setcookie("username", $username, time()+3600*24*30, '/');
                    setcookie("password", $pass, time()+3600*24*30, '/');


                  }

					
					$this->session->set_userdata($userdata);
					//print_r($this->session->userdata());die;
					if($this->session->userdata('user_logged_in')==TRUE):
						redirect(base_url('dashboard'));
					
					endif;
				}
				else { $this->msgerror('Password is incorrect'); }
			}
			else { $this->msgerror('This Username is not registered'); }
		}
		redirect(base_url('admin'));
	} ////--- END LOGIN FUNCTION 

   


	
/////=====	START LOGOUT ======////
	public function logout(){
		$this->session->sess_destroy();  
		redirect('admin');
	}
	
	public function changepassword(){

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

 //forgot password

 function forgotpass()
 {  
 	 $data['title'] 	= COMPANYNAME.' | Forget Password';
	 $this->load->view("login/forget_pass_view",$data);
 }

 function forgotpassword(){
{     
	
	 $msg="";	
 // $email ="mohd.anas@mobulous.com";
  $email = $this->input->post('email');
// alert($email);
  $con =array('email'=>$email );
  $fields = "id,username,email";
  $user=$this->My_model->getfields(ADMIN,$fields,$con);
 
  
  if(!empty($user)){
   $name         = ucfirst($user[0]->username);
   $email        = $user[0]->email;
   $data['name'] = ucfirst($user[0]->username);
   $sendcode     = md5($user[0]->username).date("dmYhis");
   $linkurl      = $data['linkurl']=base_url('change-password/'.$sendcode);
 
   $this->My_model->update_data(ADMIN,array('email' =>$email),array('confirm_code'=>$sendcode));
 // echo $this->db->last_query();die;
   $this->load->model('Sendmail');
   $mailmsg='Dear '.$name.'<br><p style ="color:#000;text-align:left;font-family:Arial; line-height:1.6;">We have received a password reset request, please click on below link to reset your password:</p><br>
      <table> 
      <a href="'.$linkurl.'"><strong>CLICK HERE</strong></a><br/>
      </table><br>
      <p style ="color:#000;text-align:left;font-family:Arial; line-height:1.6;">Thanks for DOCTOR NOW!</p><br>
      <p style ="color:#000;text-align:left;font-family:Arial; line-height:1.6;">Sincerely<br/> DOCTOR NOW Team</p>';
  
  $this->Sendmail->sendmail($email,"DOCTOR NOW Password Reset Request",$mailmsg);
  $msg = " <strong>Success ! </strong> Please check your email. Password reset instructions sent to the associated email address.";
    
    }
    else{ $msg = " <strong>Warning ! </strong> Email id doesn't exist, Please enter a valid Email id"; }
  

    
    
  echo '<div class="alert alert-success alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close">
        &times;</a>'.$msg.'</div>';	
}

}

//forgot change passwords

function forgot_change_view()
 {
 	$data['uri_data'] = $this->uri->segment(2);
 	 $data['title'] 	= COMPANYNAME.' | Forget Password';
	 $this->load->view("login/change_pass_view",$data);
 }

 function updatepassword()
 {
   $uri_data = $this->input->post("uri_data");
    $new_pass1=$this->input->post("new_pass");
    $con_pass1=$this->input->post("con_pass");
    
    if($new_pass1 != $con_pass1)    
    { 
      $this->msgwarning("New password must be equal to confirm password"); 
     redirect('adminlogin/forgot_change_view');       
    }

    
    $new_pass=md5($new_pass1);
    $con_pass=md5($con_pass1);

    
      $con=array("confirm_code"=>$uri_data);
      $updatedata=array("password"=>$new_pass);
     
      $update=$this->My_model->update_data('doctor_admin',$con,$updatedata);
      if($update) {
     
        $this->msgsuccess("Password has been successfully updated,Please Login here.");           
         redirect('adminlogin'); 
   }
 }

}

?>

