<?php 
session_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usercontroller  extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
	    $this->load->model('my_model');
		$this->load->model('user_model');
		date_default_timezone_set('Asia/Calcutta'); 
	   	

	} 
//User Login

  function login()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
     $randomToken = $this->user_model->getToken();
     $email     = $this->input->post('email');
     $mobile    = $this->input->post('mobile');
     $password  = $this->input->post('password');

     if (empty($email)) {
            $response['status']     = "FAILURE";
            $response['message']    = 'Email/Phone is empty';
            $response['requestKey'] = "login";

            echo json_encode($response);
        }
        if (empty($password)) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Password is empty';
            $response['requestKey'] = "login";
            echo json_encode($response);die;
        }

        $cond = "(email = '".$email."' OR mobile = '".$email."') AND password = '".md5($password)."'";

        $result = $this->user_model->getCondResultArray(USER,'id,name,email,mobile,dob,gender,address,image,address_detail',$cond);
        $user_id = $result[0]['id'];
        //user already login or not 
      $checkLogin =  $this->user_model->getCondResultArray(USER,'id',array('id'=>$user_id,'login_status'=>'0'));  // zeero means not login
      $checBlock =  $this->user_model->getCondResultArray(USER,'id',array('id'=>$user_id,'status'=>'1')); //check block unblock
       //echo $this->db->last_query();die;
        if(!empty($result))
        {

         if($checkLogin){
      
         if($checBlock){
        	//update token

        	    $updateToken = array(

                'token'        => $randomToken,
                'device_type'  => $this->input->post('device_type'),
                'device_token' => $this->input->post('device_token'),
                'login_status' => '0',
            );
        	 $this->user_model->update_data(USER,$updateToken,array('id'=>$result[0]['id']));
        	

           

            $response['status']                      = "SUCCESS";
            $response['message']                     = 'User Login Successfully';
            $response['requestKey']                  = "login";
             $response["login"]['id']                = $result[0]['id'];
            $response["login"]['name']               = $result[0]['name'];
            $response["login"]['email']              = $email;
            $response["login"]['mobile']             = $result[0]['mobile'];
            $response["login"]['dob']                = $result[0]['dob'];
             $response["login"]['image']             = $result[0]['image'];
            $response["login"]['gender']             = $result[0]['gender'];
            $response["login"]['address']            = $result[0]['address'];
            $response["login"]['address_detail']     = $result[0]['address_detail'];
            $response["login"]['token']              =  $updateToken['token'];


          echo json_encode($response);die; 

      }else
      {
          echo json_encode(array('status' => "FAILURE", "message" => "User Blocked.Please contact to admin."));
      }
        
   
}else{
         echo json_encode(array('status' => "FAILURE", "message" => "User Already Login."));
}
}
        else
        {
          echo json_encode(array('status' => "FAILURE", "message" => "Invalid Email Id or Password!"));
        }

       }else
        {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
       }
  }


   function adduser()
   {
      // echo "hello";die;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
     $randomToken = $this->user_model->getToken();
     $name     = $this->input->post('name');
     $email    = $this->input->post('email');
     $pass     = $this->input->post('password');
     $conf_pass     = $this->input->post('confirm_password');
     $mobile   = $this->input->post('mobile');
     $dob      =  $this->input->post('dob');
     $gen      = $this->input->post('gender');
     $address  = $this->input->post('address');
     $address1  = $this->input->post('address_detail');

    $signup_type =  $this->input->post('signup_type');

       if (empty($signup_type)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Signup type is empty';
            $response['requestKey'] = "adduser";
            echo json_encode($response);die;
        }


    if($signup_type=='normal')
    {

     $userData = array(
                        'name'         => $this->input->post('name'),
                        'email'        => $this->input->post('email'),
                        'password'     => md5($pass),
                        'mobile'       => $this->input->post('mobile'),
                        'dob'          => date('Y-m-d',strtotime($this->input->post('dob'))),
                        'gender'       => $this->input->post('gender'),
                        'address'      => $this->input->post('address'),
                        'address_detail' =>  $this->input->post('address_detail'),
                        'token'        => $randomToken,
                        'device_type'  => $this->input->post('device_type'),
                        'device_token' => $this->input->post('device_token'),
                        'status'       => '1',
                        'created_date' => date('Y-m-d h:i:s'),
                        'updated_date' => date('Y-m-d h:i:s'),
                       );


  

     if (empty($userData['name'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Name is empty';
            $response['requestKey'] = "adduser";
            echo json_encode($response);die;
        }

        if (empty($userData['email'])) {
            $response['status']     = "FAILURE";
            $response['message']    = 'Email is empty';
            $response['requestKey'] = "adduser";
            echo json_encode($response);die;
        }

         if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            $response['status']     = "FAILURE";
            $response['message']    = 'Invalid email format';
            $response['requestKey'] = "adduser";
            echo json_encode($response);die;
        }


        if (!is_numeric($userData['mobile'])) {
            $response['status']     = "FAILURE";
            $response['message']    = 'Phone no is not valid';
            $response['requestKey'] = "adduser";
            echo json_encode($response);die;
        }

        if (empty($userData['mobile'])) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Phone is empty';
            $response['requestKey'] = "adduser";
            echo json_encode($response);die;
        }


 if (empty($pass)) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Password is empty';
            $response['requestKey'] = "adduser";
            echo json_encode($response);die;
        }

        if ($pass!=$conf_pass) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Password must be equal to Confim  Password.';
            $response['requestKey'] = "adduser";
            echo json_encode($response);die;
        }

         if (empty($userData['dob'])) {

            $response['status']     = "FAILURE";
            $response['message']    = 'DOB is empty';
            $response['requestKey'] = "adduser";
            echo json_encode($response);die;
        }


         if (empty($userData['address'])) {

            $response['status']     = "FAILURE";
            $response['message']    = 'address is empty';
            $response['requestKey'] = "adduser";
            echo json_encode($response);die;

        }


      

        

     $insert = $this->my_model->insert_data(USER,$userData);
       //add member strt
            $memberData = array(
                        'user_id'         => $insert,
                        'name'             => $this->input->post('member_name'),
                        'dob'              => date('Y-m-d',strtotime($this->input->post('member_dob'))),
                        'gender'           => $this->input->post('member_gender'),
                        'relationship'     => $this->input->post('member_relationship'),
                        'status'           => '1',
                        'created_date'     => date('Y-m-d h:i:s'),
                       );

         
         if (!empty($this->input->post('member_name'))) {  
          $this->my_model->insert_data('user_member',$memberData);  
         } 
        //end add member
     $result = $this->user_model->getCondResultArray(USER,'id,name,email,mobile,dob,gender,address,address_detail,token',array('id'=>$insert));
     if($insert)
     {
        $response['status']                   = "SUCCESS";
        $response['message']                  = 'User added Successfully';
        $response['requestKey']               = "adduser";
        $response["adduser"]['user_id']      = $insert;
        $response["adduser"]['name']         = $result[0]['name'];
        $response["adduser"]['email']        = $result[0]['email'];
        $response["adduser"]['mobile']       = $result[0]['mobile'];
        $response["adduser"]['dob']          = date('d-m-Y',strtotime($result[0]['dob']));
        $response["adduser"]['image']       = $result[0]['image'];
        $response["adduser"]['gender']       = $result[0]['gender'];
        $response["adduser"]['address']      = $result[0]['address'];
        $response["adduser"]['address_detail']      = $result[0]['address_detail'];
        $response["adduser"]['token']        =  $result[0]['token'];
         echo json_encode($response);die;
       
     }
   }
    elseif ($signup_type=='facebook') //facebook signup
    {
    //	echo "string";die;
    $cond = array('email'=> $this->input->post('email'),'type' =>$signup_type);
    $fb_signup =  $this->user_model->getCondResultArray(USER,'id',$cond);
    if(!$fb_signup)
    {
       // echo "token".$fb_signup[0];die;
         $fbData = [
                    'name' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'type' => $signup_type,
                    'token' => $token,
                    'social_token' => $this->input->post('socialToken'),
                    'image' => $this->input->post('profilePic'),
                    'status' => 1,
                    'device_type'  => $this->input->post('device_type'),
                    'device_token' => $this->input->post('device_token'),
                ];
             $insertid =   $this->my_model->insert_data(USER,$fbData);
             $getData =   $this->user_model->fieldCondRow(USER,'id,name,email,type,token,mobile,image',array('id'=>$insertid));
             $response = ['fb_signup' => $getData,'message'=>'user detail seen successfully.', 'status' => "SUCCESS"];
             echo json_encode($response);die;
    }
    else
    {
      $getData =   $this->user_model->fieldCondRow(USER,'id,name,email,type,token,mobile,image',array('id'=>$fb_signup[0]['id']));
      $response = ['fb_signup' => $getData,'message'=>'user detail seen successfully', 'status' => "SUCCESS"];
      echo json_encode($response);die;
    }
    }

   elseif ($signup_type=='google') //google plus signup
    {
       $cond = array('email'=> $this->input->post('email'),'type' =>$signup_type);
       $google_signup =  $this->user_model->getCondResultArray(USER,'id',$cond);

       if(!$google_signup)
    {
       // echo "token".$fb_signup[0];die;
         $token = $this->user_model->getToken();   
         $googleData = [
                    'name' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'type' => $signup_type,
                    'token' => $token,
                    'social_token' => $this->input->post('socialToken'),
                    'image' => $this->input->post('profilePic'),
                    'status' => 1,
                    'device_type'  => $this->input->post('device_type'),
                    'device_token' => $this->input->post('device_token'),
                ];
             $insertid =   $this->my_model->insert_data(USER,$googleData);
             $getData =   $this->user_model->fieldCondRow(USER,'id,name,email,type,token,mobile,image',array('id'=>$insertid));
             $response = ['google_signup' => $getData,'message'=>'user detail seen successfully.', 'status' => "SUCCESS"];
             echo json_encode($response);die;
    }
      {
      $getData =   $this->user_model->fieldCondRow(USER,'id,name,email,type,token,mobile,image',array('id'=>$google_signup[0]['id']));
      $response = ['google_signup' => $getData,'message'=>'user detail seen successfully.', 'status' => "SUCCESS"];
      echo json_encode($response);die;
    }
    }
   
       } else
        {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
       }
     

   }


   //check email or mobile no exists or not

   function checkEmail()
   {
      $email  = $this->input->post('email');
      $mobile = $this->input->post('mobile');
      $checkEmail  =    $this->user_model->getCondResult(USER,'id',array('email'=>$email,'type'=>'normal'));
      $checkMobile  =    $this->user_model->getCondResult(USER,'id',array('mobile'=>$mobile,'type'=>'normal'));

    

     
      if($checkEmail)
      {

      	 $response['status']  = "FAILURE";
         $response['message'] = 'Email Id already exists.';
         $response['requestKey'] = "checkEmail";
         echo json_encode($response);
      }else
      {
      	 
      if($checkMobile)
      {
      	 $response['status']  = "FAILURE";
         $response['message'] = 'Mobile Number already exists.';
         $response['requestKey'] = "checkMobile";
         echo json_encode($response);
      }
      else
      {
      	 $response['status']  = "SUCCESS";
         $response['message'] = 'Does not exists.';
         //$response['requestKey'] = "checkMobile";
         echo json_encode($response);
      }
      }
}
  
 //Check Social Token
  function checkSocialToken()
   {
      $token  = $this->input->post('socialToken');
     
      
      $checkSocialToken  =  $this->user_model->getCondResult(USER,'id',array('social_token'=>$token));

    

     
      if($checkSocialToken)
      {

      	 $response['status']  = "FAILURE";
         $response['message'] = 'Social Token already exists.';
         $response['requestKey'] = "checkEmail";
         echo json_encode($response);
      }
      else
      {
      	 $response['status']  = "SUCCESS";
         $response['message'] = 'Does not exists.';
         //$response['requestKey'] = "checkMobile";
         echo json_encode($response);
      }
      

      
   }
// update profile
   function updateProfile()
   {
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
     $name     = $this->input->post('name');
     $email    = $this->input->post('email');
    // $pass     = $this->input->post('password');
     $mobile   = $this->input->post('mobile');
     $dob      =  $this->input->post('dob');
     $gen      = $this->input->post('gender');
     $address  = $this->input->post('address');
     $address1  = $this->input->post('address_detail');
     $token    = $this->input->post('token');

    $checkToken = $this->user_model->getCondResultArray(USER,'id,name,email,mobile,dob,gender,address',array('token'=>$token));
    if($checkToken)
    {

     // $profile_image = '';
     // $profile = $this->input->post('profile');
     // if($profile)
     // {
     //  $profile_image =   $this->user_model->image_upload($profile,'user_profile'); //die;//base64 decode image
     // }

    //start upload iamge
    	$imgArr =array();
      if (!empty($_FILES['image']['name'])) {

            $type     = explode('.', $_FILES["image"]["name"]);
            $type     = strtolower($type[count($type) - 1]);
            $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "user_profile/" . $filename;

            move_uploaded_file($_FILES["image"]["tmp_name"], $url);
            $data['image'] = $filename;
            $image = base_url('user_profile/').$filename;
            $imgArr = array('image'=>$image);
        }
    //end upload image	


     $userData = array(
                        'name'         => $this->input->post('name'),
                        'email'        => $this->input->post('email'),
                       // 'password'     => $pass,
                        'mobile'       => $this->input->post('mobile'),
                        'dob'          => date('Y-m-d',strtotime($this->input->post('dob'))),
                        'gender'       => $this->input->post('gender'),
                        'address'      => $this->input->post('address'),
                        'address_detail' =>  $this->input->post('address_detail'),
                      //  'image'         => $image ,
                       // 'status'       => '1',
                        'updated_date' => date('Y-m-d h:i:s'),
                       );
     $finalArr = array_merge($imgArr,$userData);
    // echo "<pre>";
    // print_r($finalArr);die;

     if (empty($userData['name'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Name is empty';
            $response['requestKey'] = "updateProfile";
            echo json_encode($response);die;
        }

        if (empty($userData['email'])) {
            $response['status']     = "FAILURE";
            $response['message']    = 'Email is empty';
            $response['requestKey'] = "updateProfile";
            echo json_encode($response);die;
        }

         if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            $response['status']     = "FAILURE";
            $response['message']    = 'Invalid email format';
            $response['requestKey'] = "updateProfile";
            echo json_encode($response);die;
        }


        if (!is_numeric($userData['mobile'])) {
            $response['status']     = "FAILURE";
            $response['message']    = 'Phone no is not valid';
            $response['requestKey'] = "updateProfile";
            echo json_encode($response);die;
        }

        if (empty($userData['mobile'])) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Phone is empty';
            $response['requestKey'] = "updateProfile";
            echo json_encode($response);die;
        }

         if (empty($userData['dob'])) {

            $response['status']     = "FAILURE";
            $response['message']    = 'DOB is empty';
            $response['requestKey'] = "updateProfile";
            echo json_encode($response);die;
        }


         if (empty($userData['address'])) {

            $response['status']     = "FAILURE";
            $response['message']    = 'address is empty';
            $response['requestKey'] = "updateProfile";
            echo json_encode($response);die;
        }


   

     $update =  $this->user_model->update_data(USER,$finalArr,array('id'=>$checkToken[0]['id']));
    $userDetail =  $this->user_model->getCondResultArray(USER,'id,name,image',array('id'=>$checkToken[0]['id']));
     if($update)
     {
        $response['status']              = "SUCCESS";
        $response['message']             = 'User edit Successfully';
        $response['requestKey']          = "updateProfile";
        $response["updateProfile"]['id'] = $userDetail[0]['id'];
        $response["updateProfile"]['name'] = $userDetail[0]['name'];
        $response["updateProfile"]['image'] = $userDetail[0]['image'];
       
     }
      echo json_encode($response);die;
  }
  else
  {
            $errors = "token mismatch ...Please logOut.";
            $response = ['message' => $errors, 'status' => "FAILURE"];
             echo json_encode($response);die;
  }
   }else
        {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
       }

   }

  //show profile detail
   function userProfile()
   {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
        $token     = $this->input->post('token');
        $result = $this->user_model->getCondResultArray(USER,'id,name,email,mobile,dob,gender,address,address_detail,image',array('token'=>$token));
        if($result)
        {

        	$response['status']                   = "SUCCESS";
            $response['message']                  = 'Users Data seen successfully';
            $response['requestKey']               = "userProfile";
            $response["userProfile"]['name']         = $result[0]['name'];
            $response["userProfile"]['email']        = $result[0]['email'];
            $response["userProfile"]['mobile']       = $result[0]['mobile'];
            $response["userProfile"]['dob']          =date('d-m-Y',strtotime($result[0]['dob']));
            $response["userProfile"]['gender']       = $result[0]['gender'];
            $response["userProfile"]['address']      = $result[0]['address'];
            $response["userProfile"]['address_detail']  = $result[0]['address_detail'];
           // $response["response"]['image']        =  base_url('user_profile/'.$result[0]['image']);
            $response["userProfile"]['image']        = $result[0]['image'];
            echo json_encode($response);die;

        }
        else
        {
        	$response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            $response['requestKey'] = "userProfile";
            echo json_encode($response);
            die;
        }

      }else
        {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
       }

   }

  


function changePassword()
   {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
      $oldpass = $this->input->post('old_pass');  
      $newpass = $this->input->post('new_pass');
      $conpass = $this->input->post('confirm_pass');
      $token = $this->input->post('token');

   if (empty($token)) {
            $response['status']     = "FAILURE";
            $response['message']    = 'Token is empty';
            $response['requestKey'] = "changePassword";

            echo json_encode($response);
            die;
        }

  $checkToken = $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
  $user_id = $checkToken[0]['id'];
  if($checkToken){

  if (empty($oldpass)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Old Password is empty';
            $response['requestKey'] = "changePassword";
            echo json_encode($response);die;
        }

   if (empty($newpass)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'New Password is empty';
            $response['requestKey'] = "changePassword";
            echo json_encode($response);die;
        }

        if (empty($conpass)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Confirm Password is empty';
            $response['requestKey'] = "changePassword";
            echo json_encode($response);die;
        }

   
    if($newpass != $conpass)    
    { 
               $response['status']     = "FAILURE";
                $response['message']    = 'confirm password does not match to newpassword';
                $response['requestKey'] = "changePassword";
                echo json_encode($response);die;
          
    }
   $passwordFound = $this->user_model->getCondResultArray(USER,'password',array('id'=>$user_id,'password'=>md5($oldpass)));
    if($passwordFound)
    {

    
    $new_pass=md5($newpass);
   

    
      
      $updatedata=array("password"=>$new_pass);
     
      $update=$this->my_model->update_data(USER,array('id'=>$user_id),$updatedata);
     // echo $this->db->last_query();die;
      if($update) {
     
                    $response['status']     = "SUCCESS";
                    $response['message']    = 'Password changed successfully';
                    $response['requestKey'] = "changePassword";

                    echo json_encode($response);
                    die;
   }

 }
 else
 {
            $response['status']     = "FAILURE";
            $response['message']    = 'Old Password worng.';
            $response['requestKey'] = "changePassword";

            echo json_encode($response);
   }

 }else
 {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            $response['requestKey'] = "changePassword";

            echo json_encode($response);
 }

      }else
        {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          $response['requestKey'] = "changePassword";
          echo json_encode($response);die; 
       }

}


   function forgotPassword()
   {
     if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
    $mobile = $this->input->post('mobile');
    $con =array('mobile'=>$mobile );
    $fields = "id,name,email";
    $user=$this->my_model->getfields(USER,$fields,$con);
 
  
  if(!empty($user)){
   $name         = ucfirst($user[0]->name);
   $email        = $user[0]->email;
  
   $otp = rand(1000, 9999);
 
   $this->my_model->update_data(USER,array('mobile' =>$mobile),array('confirm_code'=>$otp));
   
  
    
      $getResponse = file_get_contents("https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=K0IbqH3mHE2PAyuTBlUipA&senderid=EDUIAP&channel=2&DCS=0&flashsms=0&number=" . $mobile . "&text=Your%20verification%20code%20is%20" . $otp . ".&route=13");
    
          $success  = "otp send successfully";
          $response = ['message' => $success, 'status' => "SUCCESS",'otp'=>"$otp"]; 
    
    }
    else{
            $errors = "Mobile number is not registered.";
            $response = ['message' => $errors, 'status' => "FAILURE"];
      }
  
   echo json_encode($response);
    
    }else
        {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
       }
 
}
//reset forgot pass
function updatepassword()
{

  if ($_SERVER['REQUEST_METHOD'] === 'POST') 
   {
  $newpass = $this->input->post('new_pass');
  $conpass = $this->input->post('confirm_pass');
  $otp = $this->input->post('otp');
   if (empty($otp)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'OTP is empty';
           // $response['requestKey'] = "updatepassword";
            echo json_encode($response);die;
        }

  $checkOtpToken = $this->user_model->getCondResultArray(USER,'id',array('confirm_code'=>$otp));
  if($checkOtpToken){

 
   if (empty($newpass)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'New Password is empty';
          //  $response['requestKey'] = "updatepassword";
            echo json_encode($response);die;
        }

        if (empty($conpass)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Confirm Password is empty';
           // $response['requestKey'] = "updatepassword";
            echo json_encode($response);die;
        }

   
    if($newpass != $conpass)    
    { 
         $response['status']  = "FAILURE";
            $response['message'] = 'New password must be equal to confirm password';
          //  $response['requestKey'] = "updatepassword";
            echo json_encode($response);die;
          
    }

    
    $new_pass=md5($newpass);
    $con_pass=md5($conpass);

    
      $con=array("confirm_code"=>$otp);
      $updatedata=array("password"=>$new_pass);
     
      $update=$this->my_model->update_data(USER,$con,$updatedata);
      if($update) {
     
          $success = "Password Updated successfully";
          $response = ['message' => $success, 'status' => "SUCCESS"];
           echo json_encode($response);die;
   }

 }
 else
 {
            $response['status']     = "FAILURE";
            $response['message']    = 'Invalid token ,please check.';
           // $response['requestKey'] = "updatepassword";

            echo json_encode($response);
 }
  }else
        {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
       }

    }

    //add user family member

    function addMember()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
       {
        $token     = $this->input->post('token');
         if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
          $response['requestKey'] = "addMember";
            echo json_encode($response);die;
        }
        $result = $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
        $user_id  = $result[0]['id'];
        if($result)
        { 
        $memberData = array(
                        'user_id'         => $user_id,
                        'name'             => $this->input->post('name'),
                        'dob'              => date('Y-m-d',strtotime($this->input->post('dob'))),
                        'gender'           => $this->input->post('gender'),
                        'relationship'     => $this->input->post('relationship'),
                        'status'           => '1',
                        'created_date'     => date('Y-m-d h:i:s'),
                       );
                       
         if (empty($memberData['name'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Name is empty';
            $response['requestKey'] = "addMember";
            echo json_encode($response);die;
        }  
        
          if (empty($memberData['dob'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'DOB is empty';
            $response['requestKey'] = "addMember";
            echo json_encode($response);die;
        }  
        
         if (empty($memberData['gender'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Gender is empty';
            $response['requestKey'] = "addMember";
            echo json_encode($response);die;
        }  
   
     if (empty($memberData['relationship'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Relationship is empty';
            $response['requestKey'] = "addMember";
            echo json_encode($response);die;
        }  
        
         $insert = $this->my_model->insert_data('user_member',$memberData);

          $response['status']              = "SUCCESS";
          $response['message']             = 'User member added Successfully';
          $response['requestKey']          = "addMember";
          $response["addMember"]['user_id'] = $insert;
          echo json_encode($response);die;

    }else
    {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
           $response['requestKey'] = "addMember";

            echo json_encode($response);
    }

    }else
        {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
       }

}

//show user member list

function memberList()
{
   if ($_SERVER['REQUEST_METHOD'] === 'POST') 
   {
        $token     = $this->input->post('token');
        $checkToken = $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
          if($checkToken)
        {
        $member = $this->user_model->getCondResultArray('user_member','id,name,dob,gender,relationship,image',array('user_id'=>$checkToken[0]['id']));
      

            // $response['status']                   = "SUCCESS";
            // $response['message']                  = 'Users Member seen successfully';
            // $response['requestKey']               = "memberList";
            // $response["memberList"]['name']         = $member[0]['name'];
            // $response["memberList"]['dob']          = $member[0]['dob'];
            // $response["memberList"]['gender']       = $member[0]['gender'];
            // $response["memberList"]['relationship'] = $member[0]['relationship'];

            $response = [ 'status' => "SUCCESS",'message'=>'Users Member seen successfully','memberList' => $member];
            echo json_encode($response);die;

        }
        else
        {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            $response['requestKey'] = "memberList";
            echo json_encode($response);
            die;
        }
         }else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }
}

 //edit user member


function memberProfile()
   {
      if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
        $token     = $this->input->post('token');
        $member_id = $this->input->post('member_id');
        $result = $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
        if($result)
        {
         $member = $this->user_model->getCondResultArray('user_member','id,name,dob,gender,relationship,image',array('id'=>$member_id,'user_id'=>$result[0]['id']));
         //echo $this->db->last_query();die;
        	$response['status']                      = "SUCCESS";
            $response['message']                     = 'Member Data seen successfully';
            $response['requestKey']                  = "memberProfile";
            $response["memberProfile"]['name']         = $member[0]['name'];
            $response["memberProfile"]['dob']          =date('d-m-Y',strtotime($member[0]['dob']));
            $response["memberProfile"]['gender']       = $member[0]['gender'];
            $response["memberProfile"]['relationship']      = $member[0]['relationship'];
            $response["memberProfile"]['image']        = $member[0]['image'];
            echo json_encode($response);die;

        }
        else
        {
        	$response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            $response['requestKey'] = "memberProfile";
            echo json_encode($response);
            die;
        }

      }else
        {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
       }

   }

function editMember()
{
      if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
        $token     = $this->input->post('token');
        $member_id = $this->input->post('member_id');

         if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            $response['requestKey'] = "editProfile";
            echo json_encode($response);die;
        }  

        if (empty($member_id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Member id  is empty';
            $response['requestKey'] = "editProfile";
            echo json_encode($response);die;
        }  
        
        $result = $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
        if($result)
        { 

        //start upload iamge
       $imgArr = array(); 	
      if (!empty($_FILES['image']['name'])) {

            $type     = explode('.', $_FILES["image"]["name"]);
            $type     = strtolower($type[count($type) - 1]);
            $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "user_profile/" . $filename;

            move_uploaded_file($_FILES["image"]["tmp_name"], $url);
            $data['image'] = $filename;
            $image = base_url('user_profile/').$filename;
            $imgArr = array('image'=>$image);
        }
    //end upload image		
        $memberData = array(
                        //'user_id'         => $this->input->post('user_id'),
                        'name'             => $this->input->post('name'),
                        'dob'              => date('Y-m-d',strtotime($this->input->post('dob'))),
                        'gender'           => $this->input->post('gender'),
                        'relationship'     => $this->input->post('relationship'),
                        //'image'            => $image,
                        'status'           => '1',
                       // 'updated_date'     => date('Y-m-d h:i:s'),
                       );
        $finalArr = array_merge($memberData,$imgArr);

        
         $insert = $this->my_model->update_data('user_member',array('user_id'=>$result[0]['id'],'id'=>$member_id),$finalArr);
        // echo $this->db->last_query();die;

          $response['status']              = "SUCCESS";
          $response['message']             = 'User member edit Successfully';
          $response['requestKey']          = "editProfile";

         $member = $this->user_model->getCondResultArray('user_member','id,name,dob,gender,relationship,image',array('id'=>$member_id,'user_id'=>$result[0]['id']));
        // echo $this->db->last_query();die;
        	$response['status']                      = "SUCCESS";
            $response['message']                     = 'Member Data edit successfully';
            $response['requestKey']                  = "editProfile";
            $response["editProfile"]['name']       = $member[0]['name'];
            $response["editProfile"]['dob']        =date('d-m-Y',strtotime($member[0]['dob']));
            $response["editProfile"]['gender']     = $member[0]['gender'];
            $response["editProfile"]['relationship'] = $member[0]['relationship'];
            $response["editProfile"]['image']       = $member[0]['image'];
          //$response["response"]['user_id'] = $insert;
          echo json_encode($response);die;

    }else
    {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            $response['requestKey'] = "editProfile";
            echo json_encode($response);
    }

     }else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }
}

//delete member
function deleteMember()
{
       if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
        $token     = $this->input->post('token');
        $result = $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
        if($result)
        { 
          $delete =   $this->user_model->deleteRow('user_member',array('user_id'=>$result[0][id]));
          $response['status']              = "SUCCESS";
          $response['message']             = 'User member delete Successfully';
          $response['requestKey']          = "deleteMember";
        
          echo json_encode($response);die;

        }else
        {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            $response['requestKey'] = "deleteMember";
            echo json_encode($response);
        }
         }else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }
}



   


   function logout()
   {
   	   $token = $this->input->post('token');
       
       $userTokenCheck =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
       // if($result)
        if($userTokenCheck) {
        $userLogout = $this->user_model->update_data(USER,array('token'=>'','login_status'=>'0'),array('id'=>$userTokenCheck[0]['id']));
    
            if($userLogout) {
                $response = ['message' => "Logout successfully", 'status' => "SUCCESS"];
     
          }
        } else{
            $errors = "token mismatch ...Please logOut.";
            $response = ['message' => $errors, 'status' => "FAILURE"];
         
        }

         echo json_encode($response);
   }

  //show doctor listing
   function doctorListing()
   {
      $doctor = $this->user_model->getCondResultArray(DOCTOR,'id,name,mobile,email,specialty,license_no,experience,clinic_name,distance,image',array('status'=>'1'));

      $response = [ 'status' => "SUCCESS",'doctorListing' => $doctor];
      echo json_encode($response);die;


   }

   function searchDoctor()
   {
    $doctor_type = trim($this->input->post('doctor_type'));

    if (empty($doctor_type)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Doctor Type is empty';
           // $response['requestKey'] = "updatepassword";
            echo json_encode($response);die;
        } 

   $result =   $this->user_model->getCondResultArray(DOCTOR,'id,name,mobile,email,specialty,license_no,experience,clinic_name,distance,image,qualification,frees',array('status'=>'1','specialty'=>$doctor_type));
    if($result){
     $response = [ 'status' => "SUCCESS",'message'=>'search record show successfully.','doctorListing' => $result];
    }else
    {
       $errors = "No record found.";
       $response = ['message' => $errors, 'status' => "SUCCESS"];
    }
    echo json_encode($response);die;
   }

  // add home visit booking
   function addBooking()
   {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
        $token     = $this->input->post('token');

         if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        } 
        $result = $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
        $user_id = $result[0]['id'];
        if($result)
        { 
            $bookingData = array(

                                   'doctor_id'      => $this->input->post('doctor_id'),
                                   'user_id'        => $user_id,
                                   'address_type'   => $this->input->post('address_type'),
                                   'address'        => $this->input->post('address'),
                                   'promocode'      => $this->input->post('promocode'),
                                   'frees'          => $this->input->post('frees'),
                                   'member_name'    => $this->input->post('member_name'),
                                   'reason_visit'   => $this->input->post('reason_visit'),
                                   'status'         => '1',
                                   'booking_status' =>'0',
                                   'booking_type'   => 'home',
                                   'created_date'  => date('Y-m-d h:i:s')
                                 );

    if (empty($bookingData['address_type'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Address Type is empty';
            echo json_encode($response);die;
        } 

        if (empty($bookingData['address'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Address  is empty';
            echo json_encode($response);die;
        }  

         if (empty($bookingData['doctor_id'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Doctor id  is empty';
            echo json_encode($response);die;
        }  


         if (empty($bookingData['member_name'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Member Name  is empty';
            echo json_encode($response);die;
        }  

         if (empty($bookingData['reason_visit'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Visit Reason  is empty';
            echo json_encode($response);die;
        }  

     $insert =  $this->my_model->insert_data('doctor_booking',$bookingData);
   //  echo $this->db->last_query();die;
     if($insert)
     {
          $response['status']              = "SUCCESS";
          $response['message']             = 'Booking added Successfully';
          echo json_encode($response);die;

     }
   }
   else{
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            
            echo json_encode($response);

      }

    }
     else
     {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
     }

}

//add call booking

function addCallBooking()
{
  if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
        $token     = $this->input->post('token');

         if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        } 
        $result = $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
        $user_id = $result[0]['id'];
        if($result)
        { 
            $bookingData = array(

                                   'doctor_id'      => $this->input->post('doctor_id'),
                                   'user_id'        => $user_id,
                                   'booking_type'   => 'call',
                                  // 'address_type'   => $this->input->post('address_type'),
                                   //'address'        => $this->input->post('address'),
                                   'promocode'      => $this->input->post('promocode'),   //optional
                                   'frees'          => $this->input->post('frees'),
                                   'member_name'    => $this->input->post('member_name'),
                                   'reason_visit'   => $this->input->post('reason_visit'),
                                   'status'         => '1',
                                   'booking_status'  =>'0',
                                   'created_date'   => date('Y-m-d h:i:s')
                                 );

             if (empty($bookingData['doctor_id'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Doctor id  is empty';
            echo json_encode($response);die;
        }  


         if (empty($bookingData['member_name'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Member Name  is empty';
            echo json_encode($response);die;
        }  

         if (empty($bookingData['reason_visit'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Visit Reason  is empty';
            echo json_encode($response);die;
        }  

     $insert =  $this->my_model->insert_data('doctor_booking',$bookingData);
   //  echo $this->db->last_query();die;
     if($insert)
     {
          $response['status']              = "SUCCESS";
          $response['message']             = 'Call Booking added Successfully';
          echo json_encode($response);die;

     }
   }
   else{
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            
            echo json_encode($response);

      }

    }
     else
     {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
     }
}



    //my booking (this booking show left side section)
    function myBooking()
    {
       $token = $this->input->post('token');

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));

      if($checkToken)
      {   
        $result = $this->user_model->mybooking(array('user_id'=>$checkToken[0]['id']));
        if($result):
        foreach($result as $values):
        $arr[] = array(
                      'doctor_name' => $values->name,
                      'specialty'   => $values->specialty,
                      'booking_type' => $values->booking_type,
                      'booking_date' => date('Y-m-d',strtotime($values->created_date)),
                      'booking_time'  => date('h:i A',strtotime($values->created_date)),
                   );
      endforeach;
      endif;

         $response = ['status' => "SUCCESS",'bookingList' => $arr];
         echo json_encode($response);die;
       // echo $this->db->last_query();die;
       // echo "<pre>";
       // print_r($result);die;
      }
      else
      {
        $response['status']     = "FAILURE";
        $response['message']    = 'token mismatch ...Please logOut.';
        echo json_encode($response);
      }

 }

 

 //add scheduling 
 function addScheduling()
 {
 	 if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
        $token     = $this->input->post('token');

         if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        } 
        $result = $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
        $user_id = $result[0]['id'];
        if($result)
        { 
            $scheduleData = array(

                                   'doctor_id'      => $this->input->post('doctor_id'),
                                   'user_id'        => $user_id,
                                  // 'booking_type'   => 'call',
                                   'address_type'   => $this->input->post('address_type'),
                                   'address'        => $this->input->post('address'),
                                   'schedule_time'  => $this->input->post('schedule_time'),
                                   'schedule_date'  => date('Y-m-d',strtotime($this->input->post('schedule_date'))),
                                   'promocode'      => $this->input->post('promocode'),   //optional
                                   'member_name'    => $this->input->post('member_name'),
                                   'reason_visit'   => $this->input->post('reason_visit'),
                                   'booking_type'   => 'scheduling',
                                   'booking_status' => '0', 
                                   'frees'          => $this->input->post('frees'),
                                   'status'         => '1',
                                   'created_date'   => date('Y-m-d h:i:s')
                                 );

            if (empty($scheduleData['doctor_id'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Doctor id  is empty';
            echo json_encode($response);die;
        } 


             if (empty($scheduleData['address_type'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Address Type  is empty';
            echo json_encode($response);die;
        } 

         if (empty($scheduleData['address'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Address is empty';
            echo json_encode($response);die;
        } 

        if (empty($scheduleData['schedule_time'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Schedule Time is empty';
            echo json_encode($response);die;
        } 

         if (empty($scheduleData['member_name'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Member Name  is empty';
            echo json_encode($response);die;
        }  

         if (empty($scheduleData['reason_visit'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Visit Reason  is empty';
            echo json_encode($response);die;
        }  



     $insert =  $this->my_model->insert_data('doctor_booking',$scheduleData);
   //  echo $this->db->last_query();die;
     if($insert)
     {
          $response['status']              = "SUCCESS";
          $response['message']             = 'Schedule added Successfully';
          echo json_encode($response);die;

     }
   }
   else{
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            
            echo json_encode($response);

      }

 }

}
   //notification on or off
    function notification()
    {
       if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $status = $this->input->post('status');

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

         if (empty($status)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'status is empty';
            echo json_encode($response);die;
        }
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {
      $update =  $this->user_model->update_data(USER,array('notification_status'=>$status),array('id'=>$checkToken[0]['id']));
      if($update){
       
            $response['status']     = "SUCCESS";
            $response['message']    = 'status change successfully.';
            echo json_encode($response);die;
      }
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
           

            echo json_encode($response);
      }
    } 
     }else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }  

  }
  //get notification status 
	   
  function getNotificationStatus()
    {
       if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
     // $status = $this->input->post('status');

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

         
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id,notification_status	',array('token'=>$token));
      if($checkToken)
      {
      //$getStatus =  $this->user_model->fetchValue(USER,'notification',array('token'=>$token));
    
       
            $response['status']     = "SUCCESS";
             $response['getNotificationStatus']     = $checkToken[0]['notification_status'];
            $response['message']    = 'status seen successfully.';
            echo json_encode($response);die;
      }
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
           

            echo json_encode($response);
      }
     
     }else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }  

  }
// USER MEDICAL HISTORY CODE HERE


  //add hospital records

  function addHospitalRecords()
  {
  	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
   //   $status = $this->input->post('status');

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

        
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {

      	

        
        $insertData = array(

                              'user_id'  => $checkToken[0]['id'],
                              'hospital_name' => $this->input->post('hospital_name'),
                              'provider_name' => $this->input->post('provider_name'),
                              'provider_specility' => $this->input->post('provider_specility'),
                              'service_date	'    => date('Y-m-d',strtotime($this->input->post('service_date'))),
                             // 'image'           => $image,
                              'type'            => 'hospital',
                              'status'     => '1',
                              'created_date'    => date('Y-m-d h:i:s')
                             );

       

         if (empty($insertData['hospital_name'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Hospital Name is empty';
            echo json_encode($response);die;
        }

         if (empty($insertData['provider_name'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Provider Name is empty';
            echo json_encode($response);die;
        }


         if (empty($insertData['provider_specility'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'provider Specility is empty';
            echo json_encode($response);die;
        }

       


       $insertid =  $this->user_model->insert_data('user_hospital_records',$insertData);

         //start multiple upload image

      if (!empty($_FILES['image']['name'])) {

      	$filesCount = count($_FILES['image']['name']);
          for($i = 0; $i < $filesCount; $i++){

            $type     = explode('.', $_FILES["image"]["name"][$i]);
            $type     = strtolower($type[count($type) -1]);
             $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "images/" . $filename;

            move_uploaded_file($_FILES["image"]["tmp_name"][$i], $url);
            $data['image'] = $filename;
            $image = base_url('images/').$filename;
            $imageData = array(
                               'image' => $image,
                               'type'  => 'hospital',
                               'record_id' => $insertid,
                               'status' =>'1',
                               'created_date'=>date('Y-m-d h:i:s'),
                              );
           $this->user_model->insert_data('medical_record_image',$imageData);
        }

        }
    //end upload image	
     //  echo $this->db->last_query();die;

      if($insertid){
       
            $response['status']     = "SUCCESS";
            $response['message']    = 'User hospital record added successfully.';
            echo json_encode($response);die;
      }
  }
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
           

            echo json_encode($response);
      }
     
     }
     else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }  
  }
 

 //edit hospital records 

  function editHospitalRecords()
  {
  	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $id = $this->input->post('id');

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

        
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {

       
        $insertData = array(

                              'user_id'  => $checkToken[0]['id'],
                              'hospital_name' => $this->input->post('hospital_name'),
                              'provider_name' => $this->input->post('provider_name'),
                              'provider_specility' => $this->input->post('provider_specility'),
                              'service_date	'    => date('Y-m-d',strtotime($this->input->post('service_date'))),
                             // 'image'           => $image,
                              'status'     => '1',
                              'created_date'    => date('Y-m-d h:i:s')
                             );

          if (empty($id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'id is empty';
            echo json_encode($response);die;
        }


         if (empty($insertData['hospital_name'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Hospital Name is empty';
            echo json_encode($response);die;
        }

         if (empty($insertData['provider_name'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Provider Name is empty';
            echo json_encode($response);die;
        }


         if (empty($insertData['provider_specility'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'provider Specility is empty';
            echo json_encode($response);die;
        }

       


       $update =  $this->user_model->update_data('user_hospital_records',$insertData,array('id'=>$id));
       $delete = $this->user_model->deleteRow('medical_record_image',array('record_id'=>$id,'type'=>'hospital'));
//echo $this->db->last_query();die;
   if($delete){
       //upload multiple images
       if (!empty($_FILES['image']['name'])) {

      	$filesCount = count($_FILES['image']['name']);
          for($i = 0; $i < $filesCount; $i++){

            $type     = explode('.', $_FILES["image"]["name"][$i]);
            $type     = strtolower($type[count($type) -1]);
             $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "images/" . $filename;

            move_uploaded_file($_FILES["image"]["tmp_name"][$i], $url);
            $data['image'] = $filename;
            $image = base_url('images/').$filename;
            $imageData = array(
                               'image' => $image,
                               'type'  => 'hospital',
                               'record_id' => $id,
                               'status' =>'1',
                               'created_date'=>date('Y-m-d h:i:s'),
                              );
           $this->user_model->insert_data('medical_record_image',$imageData);
        }

        }
    }
       //end upload ultiple images

      if($update){
       
            $response['status']     = "SUCCESS";
            $response['message']    = 'User hospital record edit successfully.';
            echo json_encode($response);die;
      }
  }
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
           

            echo json_encode($response);
      }
     
     }
     else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }  
  }

//show all medical detail related to user



  //show user hostpital detail

//this function is used to get all user medical records with multiple images
function medicalHistory()
{
	 $token = $this->input->post('token');
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }
      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {
      	    //hospital
		    $hostpital =   $this->user_model->getCondResultArray('user_hospital_records','id,hospital_name,provider_name,provider_specility,service_date,type',array('user_id'=>$checkToken[0]['id']));

		    
		      
 //print_r($hos_img);die;
		   
          if(!empty($hostpital))
          {


		      

		   
             foreach($hostpital as $hos)
             {
             	
               $hos_img =   $this->user_model->getCondResult('medical_record_image','image',array('record_id'=>$hos['id'],'type'=>'hospital'));

               if(empty($hos_img))
		     	   $hos_img = array();

             	 $HospitalArr[] = array(
		    	                   'id' => $hos['id'],
		    	                   'hospital_name' => $hos['hospital_name'],
		    	                   'provider_name' => $hos['provider_name'],
		    	                   'provider_specility' => $hos['provider_specility'],
		    	                   'service_date' => $hos['service_date'],
		    	                    'type' => $hos['type'],
		    	                   'images'        => $hos_img,

		                         );
             }
         }else
         {
         	$HospitalArr = array();
         }
		       
		     
		    // $HospitalArr = array_merge($hostpital,$img);

		     //end hospital
            //specialty
		     $specialty =   $this->user_model->getCondResultArray('user_specialty_records','id,specialty,specialty_type,service_date,type',array('user_id'=>$checkToken[0]['id']));
		    
		      if(!empty($specialty))
		     	{

		     
		     foreach($specialty as $spe)
		     {
		     	  $spe_img =   $this->user_model->getCondResult('medical_record_image','image',array('record_id'=>$spe['id'],'type'=>'specialty'));
		     	   if(empty($spe_img))
		           	$spe_img = array();
		     	 $SpecialtyArr[] = array(
                                      'id' => $spe['id'],
                                      'specialty' => $spe['specialty'],
                                      'specialty_type' => $spe['specialty_type'],
                                      'service_date' => $spe['service_date'],
                                      'type' => $spe['type'],
                                      'images' => $spe_img,
		                           );
		     }

		 }else
		 {
		 	$SpecialtyArr = array();
		 }
		    
		     //end specialty

		     //lab 
		      $lab =   $this->user_model->getCondResultArray('user_lab_records','id,lab_name,prescription_name,lab_date,type',array('user_id'=>$checkToken[0]['id']));
		      if(!empty($lab))
		      {
		      	
		     
		     
		    
		     
             foreach($lab as $lb)
		     {
		     	$lab_img =   $this->user_model->getCondResultArray('medical_record_image','image',array('record_id'=>$lb['id'],'type'=>'lab'));

		     	if(empty($lab_img))
		     	   $lab_img = array();

		     	 $LabArr[] = array(
                                      'id' => $lb['id'],
                                      'lab_name' => $lb['lab_name'],
                                      'prescription_name' => $lb['prescription_name'],
                                      'lab_date' => $lb['lab_date'],
                                      'type' => $lb['type'],
                                      'images' => $lab_img,
		                           );
		     }
		 }else
		 {
             $LabArr =array();
		 }
		     //end lab

		     //physical

		      $physical =   $this->user_model->getCondResultArray('user_physical_therapist_records','id,therapy_name,therapy_date,type',array('user_id'=>$checkToken[0]['id']));
		    
		     if(!empty($physical))
		     {
		     	

		      
		   foreach($physical as $py)
		     {
		     	 $phy_img =   $this->user_model->getCondResultArray('medical_record_image','image',array('record_id'=>$py['id'],'type'=>'physical'));

		     	 if(empty($phy_img))
		     	     $phy_img = array();


		     	 $PhyArr[] = array(
                                      'id' => $py['id'],
                                      'therapy_name' => $py['therapy_name'],
                                      'therapy_date' => $py['therapy_date'],
                                      'type' => $py['type'],
                                      'images' => $phy_img,
		                           );
		     }
		 }else
		 {
		 	$PhyArr = array();
		 }

		     //end physical
              //other
		      $other =   $this->user_model->getCondResultArray('user_other_records','id,description,date,type',array('user_id'=>$checkToken[0]['id']));
		    
		     if(!empty($other))
		     {

            
		    foreach($other as $othr)
		     {

		     	 $other_img =   $this->user_model->getCondResultArray('medical_record_image','image',array('record_id'=>$othr['id'],'type'=>'other'));
		     	  if(empty($other_img))
		     	      $other_img = array();
		     	 $OtherArr[] = array(
                                      'id' => $othr['id'],
                                      'description' => $othr['description'],
                                      'date' => $othr['date'],
                                      'type' => $othr['type'],
                                      'images' => $other_img,
		                           );
		     }
		 }
		 else
		 {
		 	$OtherArr =array();
		 }

		     //end other

		        $pharmacy =   $this->user_model->getCondResultArray('user_pharmacy_script','id,pharmacy_name,pharmacy_provider_name,service_date,type',array('user_id'=>$checkToken[0]['id']));
		    

		      if(!empty($pharmacy))
		      {
		      	

		      	foreach($pharmacy as $ph)
		        {
		        	 $ph_img =   $this->user_model->getCondResultArray('medical_record_image','image',array('record_id'=>$ph['id'],'type'=>'pharmacy'));

		        	  if(empty($ph_img))
		     	           $ph_img = array();

		                 $PharmacyArr[] = array(
		                                      'id' => $ph['id'],
		                                      'pharmacy_name' => $ph['pharmacy_name'],
		                                      'pharmacy_provider_name' => $ph['pharmacy_provider_name'],
		                                       'service_date' => $ph['service_date'],
		                                      'type' => $ph['type'],
		                                      'images' => $ph_img,
				                           );
			 }

		     	}

		    else
		    {
		    	$PharmacyArr =array();
		    }
  
      		$response = [ 'status' => "SUCCESS",'message'=>'medical detail seen successfully.','hospitalDetail' => $HospitalArr,'specialtyDetail'=>$SpecialtyArr,'labDetail'=>$LabArr,'physicalDetails'=>$PhyArr,'otherDetail'=>$OtherArr,'pharmacyDetail'=>$PharmacyArr];
 			echo json_encode($response);die;
//
}else
{
	 	    $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            echo json_encode($response);
}

}


 //edit medical history using types
  function showMedicalHistory()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $id    = $this->input->post('id');
      $type    = $this->input->post('type');
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

         if (empty($id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Id is empty';
            echo json_encode($response);die;
        }

         if (empty($type)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Type is empty';
            echo json_encode($response);die;
        }

        
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {
         if($type=='hospital')
         {
         	//echo "gg";die;

         	 $hostpital =   $this->user_model->getCondResultArray('user_hospital_records','id,hospital_name,provider_name,provider_specility,service_date,type',array('id'=>$id));

		     $hos_img =   $this->user_model->getCondResultArray('medical_record_image','image',array('record_id'=>$hostpital[0]['id'],'type'=>'hospital'));
		      
 // print_r($img);die;
		   
          if(!empty($hostpital))
          {


		      if(empty($hos_img))
		     	$hos_img = array();

		   
             foreach($hostpital as $hos)
             {
             	
               
             	 $HospitalArr = array(
		    	                   'id' => $hos['id'],
		    	                   'hospital_name' => $hos['hospital_name'],
		    	                   'provider_name' => $hos['provider_name'],
		    	                   'provider_specility' => $hos['provider_specility'],
		    	                   'service_date' => $hos['service_date'],
		    	                    'type' => $hos['type'],
		    	                   'images'        => $hos_img,

		                         );
             }
         }else
         {
         	$HospitalArr = array();
         }
              
		      $response = [ 'status' => "SUCCESS",'message'=>'medical detail seen successfully.','editdetail' => $HospitalArr];
		             echo json_encode($response);die;
         }
         if($type=='specialty')
         {
         	 $specialty =   $this->user_model->getCondResultArray('user_specialty_records','id,specialty,specialty_type,service_date,type',array('id'=>$id));
         	 $spe_img =   $this->user_model->getCondResultArray('medical_record_image','image',array('record_id'=>$id,'type'=>'specialty'));

		     	 if(empty($spe_img))
		     	   $spe_img = array();
		    
		      if(!empty($specialty))
		     	{

		     foreach($specialty as $spe)
		     {
             
		     

		     	

		     	 $SpecialtyArr = array(
                                      'id' => $spe['id'],
                                      'specialty' => $spe['specialty'],
                                      'specialty_type' => $spe['specialty_type'],
                                      'service_date' => $spe['service_date'],
                                      'type' => $spe['type'],
                                      'images' => $spe_img,
		                           );
		     }

		 }else
		 {
		 	$SpecialtyArr = array();
		 }

		 $response = [ 'status' => "SUCCESS",'message'=>'specialty detail seen successfully.','editdetail' => $SpecialtyArr];
		             echo json_encode($response);die;

         }
         if($type=='lab')
         {
            $lab =   $this->user_model->getCondResultArray('user_lab_records','id,lab_name,prescription_name,lab_date,type',array('id'=>$id));
		      if(!empty($lab))
		      {
		      	
		     
		     $lab_img =   $this->user_model->getCondResultArray('medical_record_image','image',array('record_id'=>$lab[0]['id'],'type'=>'lab'));
		    
		     if(empty($lab_img))
		     	$lab_img = array();
             foreach($lab as $lb)
		     {
		     	 $LabArr = array(
                                      'id' => $lb['id'],
                                      'lab_name' => $lb['lab_name'],
                                      'prescription_name' => $lb['prescription_name'],
                                      'lab_date' => $lb['lab_date'],
                                      'type' => $lb['type'],
                                      'images' => $lab_img,
		                           );
		     }
		 }else
		 {
             $LabArr =array();
		 }

		  $response = [ 'status' => "SUCCESS",'message'=>'Lab detail seen successfully.','editdetail' => $LabArr];
		             echo json_encode($response);die;
         }
         if($type=='other')
         {

            $other =   $this->user_model->getCondResultArray('user_other_records','id,description,date,type',array('id'=>$id));
		     $other_img =   $this->user_model->getCondResultArray('medical_record_image','image',array('record_id'=>$other[0]['id'],'type'=>'other'));
		     if(!empty($other))
		     {

             if(empty($other_img))
		     	$other_img = array();
		    foreach($other as $othr)
		     {
		     	 $OtherArr = array(
                                      'id' => $othr['id'],
                                      'description' => $othr['description'],
                                      'date' => $othr['date'],
                                      'type' => $othr['type'],
                                      'images' => $other_img,
		                           );
		     }
		 }
		 else
		 {
		 	$OtherArr =array();
		 }
		  $response = [ 'status' => "SUCCESS",'message'=>'other detail seen successfully.','editdetail' => $OtherArr];
		             echo json_encode($response);die;
         }

         if($type=='pharmacy')
         {
            $pharmacy =   $this->user_model->getCondResultArray('user_pharmacy_script','id,pharmacy_name,pharmacy_provider_name,service_date,type',array('id'=>$id));
		     $ph_img =   $this->user_model->getCondResultArray('medical_record_image','image',array('record_id'=>$pharmacy[0]['id'],'type'=>'pharmacy'));

		      if(!empty($pharmacy))
		      {
		      	 if(empty($ph_img))
		     	    $ph_img = array();

		      	foreach($pharmacy as $ph)
		        {
		                 $PharmacyArr = array(
		                                      'id' => $ph['id'],
		                                      'pharmacy_name' => $ph['pharmacy_name'],
		                                      'pharmacy_provider_name' => $ph['pharmacy_provider_name'],
		                                       'service_date' => $ph['service_date'],
		                                      'type' => $ph['type'],
		                                      'images' => $ph_img,
				                           );
			 }

		     	}

		    else
		    {
		    	$PharmacyArr =array();
		    }
		   $response = [ 'status' => "SUCCESS",'message'=>'pharmacy detail seen successfully.','editdetail' => $PharmacyArr];
		             echo json_encode($response);die; 
         }
         if($type=='physical')
         {
            $physical =   $this->user_model->getCondResultArray('user_physical_therapist_records','id,therapy_name,therapy_date,type',array('id'=>$id));
		     $phy_img =   $this->user_model->getCondResultArray('medical_record_image','image',array('record_id'=>$physical[0]['id'],'type'=>'physical'));
		     if(!empty($physical))
		     {
		     	

		      if(empty($phy_img))
		     	$phy_img = array();

		   foreach($physical as $py)
		     {
		     	 $PhyArr = array(
                                      'id' => $py['id'],
                                      'therapy_name' => $py['therapy_name'],
                                      'therapy_date' => $py['therapy_date'],
                                      'type' => $py['type'],
                                      'images' => $phy_img,
		                           );
		     }
		 }else
		 {
		 	$PhyArr = array();
		 }
		  $response = [ 'status' => "SUCCESS",'message'=>'physical detail seen successfully.','editdetail' => $PhyArr];
		             echo json_encode($response);die; 
         }
       }
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
           

            echo json_encode($response);
      }
     
     }
     else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }  

  }


  function showHospitalDetail()
  {
  	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $hospital_id = $this->input->post('id');
      //$status = $this->input->post('status');

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

         if (empty($hospital_id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Hospital id  is empty';
            echo json_encode($response);die;
        }

        
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {
        
     //  echo $this->db->last_query();die;

		     $showDetail  =  $this->user_model->getCondResultArray('user_hospital_records','id,hospital_name,provider_name,provider_specility,service_date,image',array('user_id'=>$checkToken[0]['id'],'id'=>$hospital_id));
		      $response = [ 'status' => "SUCCESS",'hospitalDetail' => $showDetail];
		             echo json_encode($response);die;
       
          
      }
  
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            echo json_encode($response);
      }
     
     }else
          {
	          $response['status']     = "FAILURE";
	          $response['message']    = 'This method is not allowed.';
	          echo json_encode($response);die; 
        }  
  }


  // add user  specialty

   function addSpecialty()
  {
  	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

        
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {

         

        $insertData = array(

                              'user_id'         => $checkToken[0]['id'],
                              'specialty'       => $this->input->post('specialty'),
                              'specialty_type'  => $this->input->post('specialty_type'),
                              'service_date	'   => date('Y-m-d',strtotime($this->input->post('service_date'))),
                            //  'image'           => $image,
                              'type'           =>'specialty',
                              'status'          => '1',
                              'created_date'    => date('Y-m-d h:i:s')
                             );

       

         if (empty($insertData['specialty'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Specialty Name is empty';
            echo json_encode($response);die;
        }

         if (empty($insertData['specialty_type'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Specialty Type  is empty';
            echo json_encode($response);die;
        }



       


       $insertid =  $this->user_model->insert_data('user_specialty_records',$insertData);
        //upload multiple images
        if (!empty($_FILES['image']['name'])) {

      	$filesCount = count($_FILES['image']['name']);
          for($i = 0; $i < $filesCount; $i++){

            $type     = explode('.', $_FILES["image"]["name"][$i]);
            $type     = strtolower($type[count($type) -1]);
             $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "images/" . $filename;

            move_uploaded_file($_FILES["image"]["tmp_name"][$i], $url);
            $data['image'] = $filename;
            $image = base_url('images/').$filename;
            $imageData = array(
                               'image' => $image,
                               'type'  => 'specialty',
                               'record_id' => $insertid,
                               'status' =>'1',
                               'created_date'=>date('Y-m-d h:i:s'),
                              );
           $this->user_model->insert_data('medical_record_image',$imageData);
        }

        }
        //end of uploaded multiple images
     //  echo $this->db->last_query();die;

      if($insertid){
       
            $response['status']     = "SUCCESS";
            $response['message']    = 'User Specialty record added successfully.';
            echo json_encode($response);die;
      }
  }
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
           

            echo json_encode($response);
      }
     
     }
     else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }  
  }

 
  //update specality

    function editSpecialty()
  {
  	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $id    = $this->input->post('id');
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

        
       if (empty($id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'id is empty';
            echo json_encode($response);die;
        }

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {

      	 

        $insertData = array(

                              'user_id'         => $checkToken[0]['id'],
                              'specialty'       => $this->input->post('specialty'),
                              'specialty_type'  => $this->input->post('specialty_type'),
                              'service_date	'   => date('Y-m-d',strtotime($this->input->post('service_date'))),
                              //'image'           => $image,
                              'status'          => '1',
                              'updated_date'    => date('Y-m-d h:i:s')
                             );

       

         if (empty($insertData['specialty'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Specialty Name is empty';
            echo json_encode($response);die;
        }

         if (empty($insertData['specialty_type'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Specialty Type  is empty';
            echo json_encode($response);die;
        }



       


       $insertid =  $this->user_model->update_data('user_specialty_records',$insertData,array('id'=>$id));
     //  echo $this->db->last_query();die;

//echo $this->db->last_query();die;
  // if($delete){
       //upload multiple images
       if (!empty($_FILES['image']['name'])) {
 $delete = $this->user_model->deleteRow('medical_record_image',array('record_id'=>$id,'type'=>'specialty'));
      	$filesCount = count($_FILES['image']['name']);
          for($i = 0; $i < $filesCount; $i++){

            $type     = explode('.', $_FILES["image"]["name"][$i]);
            $type     = strtolower($type[count($type) -1]);
             $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "images/" . $filename;

            move_uploaded_file($_FILES["image"]["tmp_name"][$i], $url);
            $data['image'] = $filename;
            $image = base_url('images/').$filename;
            $imageData = array(
                               'image' => $image,
                               'type'  => 'specialty',
                               'record_id' => $id,
                               'status' =>'1',
                               'created_date'=>date('Y-m-d h:i:s'),
                              );
           $this->user_model->insert_data('medical_record_image',$imageData);
        }

        }
  //  }
       //end upload ultiple images 

      if($insertid){
       
            $response['status']     = "SUCCESS";
            $response['message']    = 'User Specialty record edit successfully.';
            echo json_encode($response);die;
      }
  }
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
           

            echo json_encode($response);
      }
     
     }
     else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }  
  }



  //show user specialty

  function showSpecialtyDetail()
  {
  	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $id = $this->input->post('id');

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

         if (empty($id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Id is empty';
            echo json_encode($response);die;
        }

        
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {
        

     //  echo $this->db->last_query();die;

		     $showDetail  =  $this->user_model->getCondResultArray('user_specialty_records','id,specialty,specialty_type,service_date,image',array('user_id'=>$checkToken[0]['id'],'id'=>$id));

		      $response = [ 'status' => "SUCCESS",'specialtyDetail' => $showDetail];
		             echo json_encode($response);die;
       
          
      }
  
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            echo json_encode($response);
      }
     
     }else
          {
	          $response['status']     = "FAILURE";
	          $response['message']    = 'This method is not allowed.';
	          echo json_encode($response);die; 
        }  
  }


//user lab records 

    function addLab()
  {
  	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

        
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {

      
        $insertData = array(

                              'user_id'         => $checkToken[0]['id'],
                              'lab_name'       => $this->input->post('lab_name'),
                              'prescription_name'  => $this->input->post('prescription_name'),
                              'lab_date	'   => date('Y-m-d',strtotime($this->input->post('lab_date'))),
                             // 'image'        => $image,
                              'type'           =>'lab',
                              'status'          => '1',
                              'created_date'    => date('Y-m-d h:i:s')
                             );

       

         if (empty($insertData['lab_name'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Lab Name is empty';
            echo json_encode($response);die;
        }

         if (empty($insertData['prescription_name'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Prescription Name  is empty';
            echo json_encode($response);die;
        }



       


       $insertid =  $this->user_model->insert_data('user_lab_records',$insertData);

        //upload multiple images
        if (!empty($_FILES['image']['name'])) {

      	$filesCount = count($_FILES['image']['name']);
          for($i = 0; $i < $filesCount; $i++){

            $type     = explode('.', $_FILES["image"]["name"][$i]);
            $type     = strtolower($type[count($type) -1]);
             $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "images/" . $filename;

            move_uploaded_file($_FILES["image"]["tmp_name"][$i], $url);
            $data['image'] = $filename;
            $image = base_url('images/').$filename;
            $imageData = array(
                               'image' => $image,
                               'type'  => 'lab',
                               'record_id' => $insertid,
                               'status' =>'1',
                               'created_date'=>date('Y-m-d h:i:s'),
                              );
           $this->user_model->insert_data('medical_record_image',$imageData);
        }

        }
        //end of uploaded multiple images
      // echo $this->db->last_query();die;

      if($insertid){
       
            $response['status']     = "SUCCESS";
            $response['message']    = 'User Lab record added successfully.';
            echo json_encode($response);die;
      }
  }
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
           

            echo json_encode($response);
      }
     
     }
     else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }  
  }


  //edit lab detail 

   function editLab()
  {
  	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $id    = $this->input->post('id');
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

          if (empty($id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'id is empty';
            echo json_encode($response);die;
        }
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {
  if (!empty($_FILES['image']['name'])) {

            $type     = explode('.', $_FILES["image"]["name"]);
            $type     = strtolower($type[count($type) - 1]);
            $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "images/" . $filename;

            move_uploaded_file($_FILES["image"]["tmp_name"], $url);
            $data['image'] = $filename;
            $image = base_url('images/').$filename;
        }
        $insertData = array(

                              'user_id'         => $checkToken[0]['id'],
                              'lab_name'       => $this->input->post('lab_name'),
                              'prescription_name'  => $this->input->post('prescription_name'),
                              'lab_date	'   => date('Y-m-d',strtotime($this->input->post('lab_date'))),
                             // 'image'        => $image,
                              'status'          => '1',
                              'created_date'    => date('Y-m-d h:i:s')
                             );

       

         if (empty($insertData['lab_name'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Lab Name is empty';
            echo json_encode($response);die;
        }

         if (empty($insertData['prescription_name'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Prescription Name  is empty';
            echo json_encode($response);die;
        }



       


       $update =  $this->user_model->update_data('user_lab_records',$insertData,array('id'=>$id));
      // echo $this->db->last_query();die;

      if($update){
       
            $response['status']     = "SUCCESS";
            $response['message']    = 'User Lab record edit successfully.';
            echo json_encode($response);die;
      }
  }
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
           

            echo json_encode($response);
      }
     
     }
     else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }  
  }


//show lab records
 function showLabDetails()
  {
  	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $id = $this->input->post('id');

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

         if (empty($id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Id is empty';
            echo json_encode($response);die;
        }

        
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {
        
     //  echo $this->db->last_query();die;

		     $showDetail  =  $this->user_model->getCondResultArray('user_lab_records','id,lab_name,prescription_name,lab_date,image',array('user_id'=>$checkToken[0]['id'],'id'=>$id));

		      $response = [ 'status' => "SUCCESS",'labDetails' => $showDetail];
		             echo json_encode($response);die;
       
          
      }
  
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            echo json_encode($response);
      }
     
     }else
          {
	          $response['status']     = "FAILURE";
	          $response['message']    = 'This method is not allowed.';
	          echo json_encode($response);die; 
        }  
  }



// add user physical therapy records

  function addPhysicalTherapy()
  {
  	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

        
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {

      
        $insertData = array(

                              'user_id'         => $checkToken[0]['id'],
                              'therapy_name'    => $this->input->post('therapy_name'),
                              'therapy_date	'   => date('Y-m-d',strtotime($this->input->post('therapy_date'))),
                            //  'image'           => $image,
                              'type'            =>'physical',
                              'status'          => '1',
                              'created_date'    => date('Y-m-d h:i:s')
                             );

       

         if (empty($insertData['therapy_name'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Therapy Name is empty';
            echo json_encode($response);die;
        }




       


       $insertid =  $this->user_model->insert_data('user_physical_therapist_records',$insertData);

        //upload multiple images
        if (!empty($_FILES['image']['name'])) {

      	$filesCount = count($_FILES['image']['name']);
          for($i = 0; $i < $filesCount; $i++){

            $type     = explode('.', $_FILES["image"]["name"][$i]);
            $type     = strtolower($type[count($type) -1]);
             $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "images/" . $filename;

            move_uploaded_file($_FILES["image"]["tmp_name"][$i], $url);
            $data['image'] = $filename;
            $image = base_url('images/').$filename;
            $imageData = array(
                               'image' => $image,
                               'type'  => 'physical',
                               'record_id' => $insertid,
                               'status' =>'1',
                               'created_date'=>date('Y-m-d h:i:s'),
                              );
           $this->user_model->insert_data('medical_record_image',$imageData);
        }

        }
        //end of uploaded multiple images
      // echo $this->db->last_query();die;

      if($insertid){
       
            $response['status']     = "SUCCESS";
            $response['message']    = 'User Physical Therapy record added successfully.';
            echo json_encode($response);die;
      }
  }
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
           

            echo json_encode($response);
      }
     
     }
     else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }  
  }



  //update physical therapy

  function editPhysicalTherapy()
  {
  	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $id    = $this->input->post('id');
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

          if (empty($id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'id is empty';
            echo json_encode($response);die;
        }
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {

        if (!empty($_FILES['image']['name'])) {

            $type     = explode('.', $_FILES["image"]["name"]);
            $type     = strtolower($type[count($type) - 1]);
            $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "images/" . $filename;

            move_uploaded_file($_FILES["image"]["tmp_name"], $url);
            $data['image'] = $filename;
            $image = base_url('images/').$filename;
        }
        $insertData = array(

                              'user_id'         => $checkToken[0]['id'],
                              'therapy_name'    => $this->input->post('therapy_name'),
                              'therapy_date	'   => date('Y-m-d',strtotime($this->input->post('therapy_date'))),
                              //'image'           => $image,
                              'status'          => '1',
                              //'created_date'    => date('Y-m-d h:i:s')
                             );

       

         if (empty($insertData['therapy_name'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Therapy Name is empty';
            echo json_encode($response);die;
        }




       


       $update =  $this->user_model->update_data('user_physical_therapist_records',$insertData,array('id'=>$id));
      // echo $this->db->last_query();die;

      if($update){
       
            $response['status']     = "SUCCESS";
            $response['message']    = 'User Physical Therapy record edit successfully.';
            echo json_encode($response);die;
      }
  }
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
           

            echo json_encode($response);
      }
     
     }
     else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }  
  }


  function showPhysicalTherapy()
  {
  	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $id = $this->input->post('id');

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

          if (empty($id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Id is empty';
            echo json_encode($response);die;
        }

        
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {
        
     //  echo $this->db->last_query();die;

		     $showDetail  =  $this->user_model->getCondResultArray('user_physical_therapist_records','id,therapy_name,therapy_date,image',array('user_id'=>$checkToken[0]['id'],'id'=>$id));

		      $response = [ 'status' => "SUCCESS",'physicalTherapy' => $showDetail];
		             echo json_encode($response);die;
       
          
      }
  
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            echo json_encode($response);
      }
     
     }else
          {
	          $response['status']     = "FAILURE";
	          $response['message']    = 'This method is not allowed.';
	          echo json_encode($response);die; 
        }  
  }


 //add other records 
  
  function addOther()
  {
  	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

        
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {


      
        $insertData = array(

                              'user_id'         => $checkToken[0]['id'],
                              'description'     => $this->input->post('description'),
                              'date	'            => date('Y-m-d',strtotime($this->input->post('date'))),
                              'status'          => '1',
                             // 'image'           => $image,
                              'type'          =>'other',
                              'created_date'    => date('Y-m-d h:i:s')
                             );

        $insertid =  $this->user_model->insert_data('user_other_records',$insertData);

        //upload multiple images
        if (!empty($_FILES['image']['name'])) {

      	$filesCount = count($_FILES['image']['name']);
          for($i = 0; $i < $filesCount; $i++){

            $type     = explode('.', $_FILES["image"]["name"][$i]);
            $type     = strtolower($type[count($type) -1]);
             $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "images/" . $filename;

            move_uploaded_file($_FILES["image"]["tmp_name"][$i], $url);
            $data['image'] = $filename;
            $image = base_url('images/').$filename;
            $imageData = array(
                               'image' => $image,
                               'type'  => 'other',
                               'record_id' => $insertid,
                               'status' =>'1',
                               'created_date'=>date('Y-m-d h:i:s'),
                              );
           $this->user_model->insert_data('medical_record_image',$imageData);
        }

        }
        //end of uploaded multiple images

      // echo $this->db->last_query();die;

      if($insertid){
       
            $response['status']     = "SUCCESS";
            $response['message']    = 'User other  record added successfully.';
            echo json_encode($response);die;
      }
  }
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
           

            echo json_encode($response);
      }
     
     }
     else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }  
  }



//edit other detals

  function editOther()
  {
  	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $id = $this->input->post('id');
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

        
       if (empty($id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'id is empty';
            echo json_encode($response);die;
        }

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {


        if (!empty($_FILES['image']['name'])) {

            $type     = explode('.', $_FILES["image"]["name"]);
            $type     = strtolower($type[count($type) - 1]);
            $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "images/" . $filename;

            move_uploaded_file($_FILES["image"]["tmp_name"], $url);
            $data['image'] = $filename;
            $image = base_url('images/').$filename;
        }
        $insertData = array(

                              'user_id'         => $checkToken[0]['id'],
                              'description'     => $this->input->post('description'),
                              'date	'            => date('Y-m-d',strtotime($this->input->post('date'))),
                              'status'          => '1',
                             // 'image'           => $image,
                              'created_date'    => date('Y-m-d h:i:s')
                             );

        $insertid =  $this->user_model->update_data('user_other_records',$insertData,array('id'=>$id));
      // echo $this->db->last_query();die;

      if($insertid){
       
            $response['status']     = "SUCCESS";
            $response['message']    = 'User other  record edit successfully.';
            echo json_encode($response);die;
      }
  }
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
           

            echo json_encode($response);
      }
     
     }
     else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }  
  }

  //function show other details

  function showOtherDetail()
  {
  	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $id = $this->input->post('id');

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

         if (empty($id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Id is empty';
            echo json_encode($response);die;
        }

        
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {
        
     //  echo $this->db->last_query();die;

		     $showDetail  =  $this->user_model->getCondResultArray('user_other_records','id,description,date,image',array('user_id'=>$checkToken[0]['id'],'id'=>$id));

		      $response = [ 'status' => "SUCCESS",'otherDetail' => $showDetail];
		             echo json_encode($response);die;
       
          
      }
  
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            echo json_encode($response);
      }
     
     }else
          {
	          $response['status']     = "FAILURE";
	          $response['message']    = 'This method is not allowed.';
	          echo json_encode($response);die; 
        }  
  }


  function addPharmacy()
  {
  	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

        
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {


        
        $insertData = array(

                              'user_id'                    => $checkToken[0]['id'],
                              'pharmacy_name'              => $this->input->post('pharmacy_name'),
                              'pharmacy_provider_name	'  => $this->input->post('pharmacy_provider_name'),
                              'service_date			'      => date('Y-m-d',strtotime($this->input->post('service_date'))),
                              'status'                     => '1',
                              'type'                       => 'pharmacy',
                             // 'image'                     => $image,
                              'created_date'               => date('Y-m-d h:i:s')
                             );

        $insertid =  $this->user_model->insert_data('user_pharmacy_script',$insertData);

        //upload multiple images
        if (!empty($_FILES['image']['name'])) {

      	$filesCount = count($_FILES['image']['name']);
          for($i = 0; $i < $filesCount; $i++){

            $type     = explode('.', $_FILES["image"]["name"][$i]);
            $type     = strtolower($type[count($type) -1]);
             $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "images/" . $filename;

            move_uploaded_file($_FILES["image"]["tmp_name"][$i], $url);
            $data['image'] = $filename;
            $image = base_url('images/').$filename;
            $imageData = array(
                               'image' => $image,
                               'type'  => 'pharmacy',
                               'record_id' => $insertid,
                               'status' =>'1',
                               'created_date'=>date('Y-m-d h:i:s'),
                              );
           $this->user_model->insert_data('medical_record_image',$imageData);
        }

        }
        //end of uploaded multiple images
      // echo $this->db->last_query();die;

      if($insertid){
       
            $response['status']     = "SUCCESS";
            $response['message']    = 'User Pharmacy  record added successfully.';
            echo json_encode($response);die;
      }
  }
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
           

            echo json_encode($response);
      }
     
     }
     else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }  
  }

  //edit pharmacy details

  function editPharmacy()
  {
  	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $id    = $this->input->post('id');
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

          if (empty($id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'id is empty';
            echo json_encode($response);die;
        }
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {


          if (!empty($_FILES['image']['name'])) {

            $type     = explode('.', $_FILES["image"]["name"]);
            $type     = strtolower($type[count($type) - 1]);
            $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "images/" . $filename;

            move_uploaded_file($_FILES["image"]["tmp_name"], $url);
            $data['image'] = $filename;
            $image = base_url('images/').$filename;
        }
        $insertData = array(

                              'user_id'                    => $checkToken[0]['id'],
                              'pharmacy_name'              => $this->input->post('pharmacy_name'),
                              'pharmacy_provider_name	'  => $this->input->post('pharmacy_provider_name'),
                              'service_date			'      => date('Y-m-d',strtotime($this->input->post('service_date'))),
                              'status'                     => '1',
                              //'image'                     => $image,
                              'created_date'               => date('Y-m-d h:i:s')
                             );

        $insertid =  $this->user_model->update_data('user_pharmacy_script',$insertData,array('id'=>$id));
      // echo $this->db->last_query();die;

      if($insertid){
       
            $response['status']     = "SUCCESS";
            $response['message']    = 'User Pharmacy  record edit successfully.';
            echo json_encode($response);die;
      }
  }
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
           

            echo json_encode($response);
      }
     
     }
     else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }  
  }


  //show pharmacy detail 

  function showPharmacyDetail()
  {
  	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $id = $this->input->post('id');

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

         if (empty($id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Id is empty';
            echo json_encode($response);die;
        }

        
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {
        
     //  echo $this->db->last_query();die;

		     $showDetail  =  $this->user_model->getCondResultArray('user_pharmacy_script','id,pharmacy_name,pharmacy_provider_name,service_date,',array('user_id'=>$checkToken[0]['id'],'id'=>$id));

		      $response = [ 'status' => "SUCCESS",'pharmacyDetail' => $showDetail];
		             echo json_encode($response);die;
       
          
      }
  
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            echo json_encode($response);
      }
     
     }else
          {
	          $response['status']     = "FAILURE";
	          $response['message']    = 'This method is not allowed.';
	          echo json_encode($response);die; 
        }  
  }


  //delete medical records

  function deleteMedicalRecords()
  {
  	$type = $this->input->post('type');
  	$id   = $this->input->post('id');
  	$token = $this->input->post('token');

  	  if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

        
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {

      	 if (empty($type)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Type is empty';
            echo json_encode($response);die;
        }

       //delete hospital
        if($type=='hospital')
        {
        $delete = 	$this->user_model->deleteRow('user_hospital_records',array('id'=> $id));
        if($delete)
        {
        	  $response['status']     = "SUCCESS";
	          $response['message']    = 'User hospital record delete successfully.';
	          echo json_encode($response);die; 
        }
        }
    //delete speciality
        if($type=='specialty')
        {
        $delete = 	$this->user_model->deleteRow('user_specialty_records',array('id'=> $id));
        if($delete)
        {
        	  $response['status']     = "SUCCESS";
	          $response['message']    = 'User Specialty record delete successfully.';
	          echo json_encode($response);die; 
        }
        }
     //delete lab
        if($type=='lab')
        {
        $delete = 	$this->user_model->deleteRow('user_lab_records',array('id'=> $id));
        if($delete)
        {
        	  $response['status']     = "SUCCESS";
	          $response['message']    = 'User Lab record delete successfully.';
	          echo json_encode($response);die; 
        }
        }
    //delete therapy
       if($type=='physical')
        {
        $delete = 	$this->user_model->deleteRow('user_physical_therapist_records',array('id'=> $id));
        if($delete)
        {
        	  $response['status']     = "SUCCESS";
	          $response['message']    = 'User therapy record delete successfully.';
	          echo json_encode($response);die; 
        }
        }

    //delete other detail
       if($type=='other')
        {
        $delete = 	$this->user_model->deleteRow('user_other_records',array('id'=> $id));
        if($delete)
        {
        	  $response['status']     = "SUCCESS";
	          $response['message']    = 'User other record delete successfully.';
	          echo json_encode($response);die; 
        }
        }

        if($type=='pharmacy')
        {
        $delete = 	$this->user_model->deleteRow('user_pharmacy_script',array('id'=> $id));
        if($delete)
        {
        	  $response['status']     = "SUCCESS";
	          $response['message']    = 'User pharmacy record delete successfully.';
	          echo json_encode($response);die; 
        }
        }



         
     }
     else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            echo json_encode($response);
      }
}




//add rating
function addRating()
{
	if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

        
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {


        $ratingData = array(

                              'user_id'           => $checkToken[0]['id'],
                              'doctor_id'         => $this->input->post('doctor_id'),
                              'rating' 			  => $this->input->post('rating'),
                              'comment'  	      => $this->input->post('comment'),
                              'status'            => strtolower($this->input->post('status')),
                              'created_date'      => date('Y-m-d h:i:s')
                             );

        if (empty($this->input->post('doctor_id'))) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Doctor id  is empty';
            echo json_encode($response);die;
        }

          if (empty($this->input->post('rating'))) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Rating is empty';
            echo json_encode($response);die;
        }

          if (empty($this->input->post('status'))) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Status is empty';
            echo json_encode($response);die;
        }

        $insertid =  $this->user_model->insert_data('doctor_rating',$ratingData);
      // echo $this->db->last_query();die;

      if($insertid){
       
            $response['status']     = "SUCCESS";
            $response['message']    = 'rating  added successfully.';
            echo json_encode($response);die;
      }
  }
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
           

            echo json_encode($response);
      }
     
     }
     else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }  
}
 //show doctor home visit listing
 function homeVistiLIsting()
 {
      $homeVisit = $this->user_model->getCondResultArray(DOCTOR,'id,name,mobile,email,specialty,license_no,experience,clinic_name,distance,image,qualification,frees',array('status'=>'1','home_visit_type'=>'yes'));
      if(!empty($homeVisit))
      {
      $response = [ 'status' => "SUCCESS",'message'=>'home visit seen successfully.','homeVisit' => $homeVisit];
      echo json_encode($response);die;
  }else
  {
  	 $response = [ 'status' => "FAILURE",'message' => 'No record found!'];
      echo json_encode($response);die;
  }
 }

 //show call visit doctor listing
 function callVistListing()
 {
    $callVisit = $this->user_model->getCondResultArray(DOCTOR,'id,name,mobile,email,specialty,license_no,experience,clinic_name,distance,image,qualification,frees',array('status'=>'1','call_visit_type'=>'yes'));
      if(!empty($callVisit))
      {
      $response = [ 'status' => "SUCCESS",'message'=>'call visit seen successfully.','callVist' => $callVisit];
      echo json_encode($response);die;
  }else
  {
  	 $response = [ 'status' => "FAILURE",'message' => 'No record found!'];
      echo json_encode($response);die;
  }
 }
 
 //show user past booking list
  function pastBookingList()  // when confirm status 1
  {

     $token = $this->input->post('token');
      

     if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

     $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
     $id = $checkToken[0]['id'];

    if($checkToken)
    {
         $dateto = date('Y-m-d');
    
    
    // $query = "SELECT d.name,d.email,d.mobile,d.image,d.qualification,b.created_date,b.address,b.address_type,b.booking_type FROM `doctor_booking` as b INNER JOIN doctor_doctor as d on b.doctor_id=d.id  WHERE b.user_id = '".$id."' and str_to_date(b.created_date,'%Y-%m-%d') < '".$dateto."' ORDER BY b.id DESC ";
    $booking_status = 4 ;
    $query = "SELECT b.doctor_id,d.name,d.email,d.mobile,d.image,d.qualification,d.experience,d.clinic_name,d.specialty,d.frees,b.created_date,b.address,b.address_type,b.booking_type,b.reason_visit,b.member_name,b.user_id FROM `doctor_booking` as b INNER JOIN doctor_doctor as d on b.doctor_id=d.id  WHERE b.user_id = '".$id."' and booking_status = '".$booking_status."' ORDER BY b.id DESC ";     
    $result = $this->db->query($query)->result_array(); 
  if($result){
    foreach($result as $values)
    {
    $rating =   $this->user_model->fetchValue('doctor_rating','rating',array('doctor_id'=>$values['doctor_id'],'user_id'=>$id));
    if($rating)
    {
      $rate = $rating;
    }else{ $rate= '';}
   // echo $this->db->last_query();
 
      $Arr[]  = array(
                   
                    'doctor_id'      => $values['doctor_id'],
                    'name'           => $values['name'],
                    'email'          => $values['email'],
                    'mobile'         => $values['mobile'],
                    'image'          => $values['image'],
                    'qualification'  => $values['qualification'],
                    'experience'     => $values['experience'],
                    'clinic_name'    => $values['clinic_name'],
                    'specialty'      => $values['specialty'],
                    'frees'          => $values['frees'],
                    'created_date'   => $values['created_date'],
                    'address'        => $values['address'],
                    'address_type'   => $values['address_type'],
                    'booking_type'   => $values['booking_type'],
                    'reason_visit'   => $values['reason_visit'],
                    'member_name'    => $values['member_name'],
                    'rating'         =>$rate,



                   );
    }
   // print_r($Arr);die;
    //echo $this->db->last_query();die;
  
    $response = ['status' => "SUCCESS",'message'=>'Past Booking seen successfully','pastbooking' => $Arr];
    echo json_encode($response);die;
 }
 else{
       $response['status']     = "FAILURE";
       $response['message']    = 'No past booking record found.';
       echo json_encode($response);
   }    
}
else
{
    $response['status']     = "FAILURE";
    $response['message']    = 'token mismatch ...Please logOut.';
    echo json_encode($response);
}
}

function upcomingBookingList()  //when payment success then show upcoming (status==3)
  {

     $token = $this->input->post('token');
      

     if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

     $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
     $id = $checkToken[0]['id'];

    if($checkToken)
    {
         $dateto = date('Y-m-d');
    
    
    // $query = "SELECT d.name,d.email,d.mobile,d.image,b.created_date,b.address,b.address_type,b.booking_type FROM `doctor_booking` as b INNER JOIN doctor_doctor as d on b.doctor_id=d.id  WHERE b.user_id = '".$id."' and str_to_date(b.created_date,'%Y-%m-%d') >='".$dateto."' ORDER BY b.id DESC ";
     $booking_status = 3; 
     $query = "SELECT b.doctor_id,d.name,d.email,d.mobile,d.image,d.qualification,d.experience,d.clinic_name,d.specialty,d.frees,b.created_date,b.address,b.address_type,b.booking_type,b.reason_visit,b.member_name FROM `doctor_booking` as b INNER JOIN doctor_doctor as d on b.doctor_id=d.id  WHERE b.user_id = '".$id."' and b.booking_status='".$booking_status."' ORDER BY b.id DESC ";     
    $result = $this->db->query($query)->result_array(); 
    //print_r($resul);die;
    //echo $this->db->last_query();die;
    if($result){

       foreach($result as $values)
    {
    $rating =   $this->user_model->fetchValue('doctor_rating','rating',array('doctor_id'=>$values['doctor_id'],'user_id'=>$id));
    if($rating)
    {
      $rate = $rating;
    }else{ $rate= '';}
   // echo $this->db->last_query();
 
      $Arr[]  = array(
                   
                    'doctor_id'      => $values['doctor_id'],
                    'name'           => $values['name'],
                    'email'          => $values['email'],
                    'mobile'         => $values['mobile'],
                    'image'          => $values['image'],
                    'qualification'  => $values['qualification'],
                    'experience'     => $values['experience'],
                    'clinic_name'    => $values['clinic_name'],
                    'specialty'      => $values['specialty'],
                    'frees'          => $values['frees'],
                    'created_date'   => $values['created_date'],
                    'address'        => $values['address'],
                    'address_type'   => $values['address_type'],
                    'booking_type'   => $values['booking_type'],
                    'reason_visit'   => $values['reason_visit'],
                    'member_name'    => $values['member_name'],
                    'rating'         =>$rate,



                   );
    }
    $response = ['status' => "SUCCESS",'message'=>'upcoming booking seen successfully','upcomingBooking' => $Arr];
    echo json_encode($response);die;
 }
 else{
       $response['status']     = "FAILURE";
       $response['message']    = 'No Upcoming booking record found.';
       echo json_encode($response);
   }    
}
else
{
    $response['status']     = "FAILURE";
    $response['message']    = 'token mismatch ...Please logOut.';
    echo json_encode($response);
}
}


 function memberListById()
   {
   
   	$user_id = $this->input->post('user_id');
    $memberList = $this->user_model->getCondResultArray('user_member','id,name',array('user_id'=>$user_id));
    if(!empty($memberList))
    {
        $response = [ 'status' => "SUCCESS",'message'=>'Member List seen successfully.','memberList'=>$memberList];
      echo json_encode($response);die;
    }else{
    	 $response['status']     = "FAILURE";
         $response['message']    = 'No member List found this user id.';
         echo json_encode($response);
    }
   }


     function doctorType()
   {
   // echo "hi";
    $doctorType = $this->user_model->getCondResultArray('specility','id,name',array('status'=>'1'));
    if(!empty($doctorType))
    {
        $response = [ 'status' => "SUCCESS",'message'=>'Doctor Type seen successfully.','doctorType'=>$doctorType];
      echo json_encode($response);die;
    }else{
    	$response['status']     = "FAILURE";
        $response['message']    = 'No record found.';
        echo json_encode($response);
    }
   }

   //start user faimly member medical records 

   //end user faimly member records 



}
?>
