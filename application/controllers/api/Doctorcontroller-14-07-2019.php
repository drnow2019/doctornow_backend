<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/////====	START LEAD CONTROLLERS CLASS   =======///////
class Doctorcontroller  extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
	    $this->load->model('my_model');
		$this->load->model('user_model');
	   	

	} 
//User Login



  function login()
  {
    $token = $this->user_model->getToken();

   if ($_SERVER['REQUEST_METHOD'] === 'POST') {

     $email     = $this->input->post('email');
     //$mobile    = $this->input->post('mobile');
     $password  = $this->input->post('password');

     if (empty($email)) {
            $response['status']     = "FAILURE";
            $response['message']    = 'Email/Phone is empty';
            $response['requestKey'] = "login";

            echo json_encode($response);die;
        }
        if (empty($password)) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Password is empty';
            $response['requestKey'] = "login";
            echo json_encode($response);die;
        }

        $cond = "(email = '".$email."' OR mobile = '".$email."') AND password = '".md5($password)."'";
        $result = $this->user_model->getCondResultArray(DOCTOR,'id,name,email,mobile,dob,gender,address,image,profile_status',$cond);
        $doctor_id = $result[0]['id'];
        $checkBlock =  $this->user_model->getCondResultArray(DOCTOR,'id',array('id'=>$doctor_id,'status'=>'1')); //check block unblock
        $checkVerifystatus =  $this->user_model->getCondResultArray(DOCTOR,'id',array('id'=>$doctor_id,'verify_status'=>'1'));  // zeero means not login
         $doctorRating =  $this->user_model->AvgRating('doctor_rating',array('doctor_id'=>$doctor_id));
         $doctorRate =  $doctorRating->rate;
        // print_r($doctorRating);die;
      //  echo $this->db->last_query();die;
        if(!empty($result))
        {

            // if($checkLogin)
            // {
        if($checkBlock){

            if($checkVerifystatus){
        	//update token

        	    $updateToken = array(
                
                'token'        => $token,
                'device_type'  => $this->input->post('device_type'),
                'device_token' => $this->input->post('device_token'),
                'login_status' => '1',
            );
        	 $this->user_model->update_data(DOCTOR,$updateToken,array('id'=>$result[0]['id']));
        	

           

            $response['status']                  = "SUCCESS";
            $response['message']                 = 'Doctor Login Successfully';
            $response['requestKey']              = "login";
            $response["login"]['id']             = $result[0]['id'];
            $response["login"]['name']           = $result[0]['name'];
            $response["login"]['email']          = $result[0]['email'];
            $response["login"]['mobile']         = $result[0]['mobile'];
            $response["login"]['dob']            = $result[0]['dob'];
            $response["login"]['gender']         = $result[0]['gender'];
            $response["login"]['address']        = $result[0]['address'];
            $response["login"]['image']          = $result[0]['image'];
            $response["login"]['token']          =  $updateToken['token'];
            $response["login"]['profile_status'] =  $result[0]['profile_status'];
            $response["login"]['rating']         =  $doctorRate;


          echo json_encode($response);die; 
     }else{
         echo json_encode(array('status' => "FAILURE", "message" => "Doctor are not verified.Please contact to admin."));
     }
}
     else
      {
          echo json_encode(array('status' => "FAILURE", "message" => "Doctor Blocked.Please contact to admin."));
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


   function addDoctor()
   {

     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $token = $this->user_model->getToken();   

    $signup_type =  $this->input->post('signup_type');
    $confirm_pass = $this->input->post('confirm_password');
    $pass =  $this->input->post('password');
    if($signup_type=='normal'){
     $doctorData = array(
                        'name'         => $this->input->post('name'),
                        'email'        => $this->input->post('email'),
                        'password'     => md5($this->input->post('password')),
                        'mobile'       => $this->input->post('mobile'),
                        'dob'          => date('Y-m-d',strtotime($this->input->post('dob'))),
                        'gender'       => $this->input->post('gender'),
                        'address'      => $this->input->post('address'),
                        'token'        => $token,
                        'device_type'  => $this->input->post('device_type'),
                        'device_token' => $this->input->post('device_token'),
                        'type'         => 'normal',
                        'status'       => '1',
                        'verify_status' => '0',    // 0 means not verified 
                        'created_date' => date('Y-m-d h:i:s'),
                        'updated_date' => date('Y-m-d h:i:s'),
                       );

     if (empty($doctorData['name'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Name is empty';
            $response['requestKey'] = "adddoctor";
            echo json_encode($response);die;
        }

        if (empty($doctorData['email'])) {
            $response['status']     = "FAILURE";
            $response['message']    = 'Email is empty';
            $response['requestKey'] = "adddoctor";
            echo json_encode($response);die;
        }

         if (!filter_var($doctorData['email'], FILTER_VALIDATE_EMAIL)) {
            $response['status']     = "FAILURE";
            $response['message']    = 'Invalid email format';
            $response['requestKey'] = "adddoctor";
            echo json_encode($response);die;
        }


        if (!is_numeric($doctorData['mobile'])) {
            $response['status']     = "FAILURE";
            $response['message']    = 'Phone no is not valid';
            $response['requestKey'] = "adddoctor";
            echo json_encode($response);die;
        }

        if (empty($doctorData['mobile'])) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Phone is empty';
            $response['requestKey'] = "adddoctor";
            echo json_encode($response);die;
        }

         if (empty($doctorData['password'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Password is empty';
            $response['requestKey'] = "adddoctor";
            echo json_encode($response);die;
        }

         if (empty($confirm_pass)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Confirm Password is empty';
            $response['requestKey'] = "adddoctor";
            echo json_encode($response);die;
        }

         if ($confirm_pass!=$pass) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Password must be equal to Confirm Password';
            $response['requestKey'] = "adddoctor";
            echo json_encode($response);die;
        }

         if (empty($doctorData['dob'])) {

            $response['status']     = "FAILURE";
            $response['message']    = 'DOB is empty';
            $response['requestKey'] = "adddoctor";
            echo json_encode($response);die;
        }


         if (empty($doctorData['address'])) {

            $response['status']     = "FAILURE";
            $response['message']    = 'address is empty';
            $response['requestKey'] = "adddoctor";
            echo json_encode($response);die;
        }



        //check email id  or mobile 
       $cond = $cond = "email = '".$doctorData['email']."' OR mobile = '".$doctorData['mobile']."'"; 
     // $checkEmail  =    $this->user_model->getCondResult(DOCTOR,'id',$cond);
      // if($checkEmail)
      // {
      //    $response['status']  = "FAILURE";
      //   $response['message'] = 'Email / Phone already exists.';
      //   $response['requestKey'] = "adddoctor";
      //   echo json_encode($response);die;
      // }

     $insert = $this->my_model->insert_data(DOCTOR,$doctorData);
     $result = $this->user_model->getCondResultArray(DOCTOR,'id,name,email,mobile,dob,gender,address',array('id'=>$insert));
     if($insert)
     {
        $response['status']                   = "SUCCESS";
        $response['message']                  = 'doctor added Successfully';
        $response['requestKey']               = "adddoctor";
        $response["adddoctor"]['doctor_id']    = $insert;
        $response["adddoctor"]['name']         = $result[0]['name'];
        $response["adddoctor"]['email']        = $result[0]['email'];
        $response["adddoctor"]['mobile']       = $result[0]['mobile'];
        $response["adddoctor"]['dob']          = $result[0]['dob'];
        $response["adddoctor"]['gender']       = $result[0]['gender'];
        $response["adddoctor"]['address']      = $result[0]['address'];
        $response["adddoctor"]['token']        =  $token;
         echo json_encode($response);die;
       
     }
 }
 elseif ($signup_type=='facebook') //facebook signup
 {
  
    $cond = array('email'=> $this->input->post('email'),'type' =>$signup_type);
    $fb_signup =  $this->user_model->getCondResultArray(DOCTOR,'id',$cond);
    if(!$fb_signup)
    {
       // echo "token".$fb_signup[0];die;
         $token = $this->user_model->getToken();   
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
             $insertid =   $this->my_model->insert_data(DOCTOR,$fbData);
             $getData =   $this->user_model->fieldCondRow(DOCTOR,'id,name,email,type,token,mobile,image',array('id'=>$insertid));
             $response = ['fb_signup' => $getData, 'message'=>'doctor detail seen successfully.','status' => "SUCCESS"];
             echo json_encode($response);die;
    }
    else
    {
      $getData =   $this->user_model->fieldCondRow(DOCTOR,'id,name,email,type,token,mobile,image',array('id'=>$fb_signup[0]['id']));
      $response = ['fb_signup' => $getData,'message'=>'doctor detail seen successfully.', 'status' => "SUCCESS"];
      echo json_encode($response);die;
    }
 }
 //google plus login or signup
 elseif ($signup_type=='google')
 {
     $cond = array('email'=> $this->input->post('email'),'type' =>$signup_type);
     $google_signup =  $this->user_model->getCondResultArray(DOCTOR,'id',$cond);

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
             $insertid =   $this->my_model->insert_data(DOCTOR,$googleData);
             //echo $this->db->last_query();die;
             $getData =   $this->user_model->fieldCondRow(DOCTOR,'id,name,email,type,token,mobile,image',array('id'=>$insertid));

             $response = ['google_signup' => $getData,'message'=>'doctor detail seen successfully.', 'status' => "SUCCESS"];
             echo json_encode($response);die;
    }
      {
     
      //update remaining data start arr
    $googleData1 =   array(
                    
                            'mobile'       => $this->input->post('mobile'),
                            'dob'          => date('Y-m-d',strtotime($this->input->post('dob'))),
                            'gender'       => $this->input->post('gender'),
                            'address'      => $this->input->post('address'),
                        
                            'status'       => '1',
                            'verify_status' => '0',    // 0 means not verified 
                            'created_date' => date('Y-m-d h:i:s'),
                      
                       );
     $this->user_model->update_data(DOCTOR,$googleData1,array('id'=>$google_signup[0]['id']));
     $getData =   $this->user_model->fieldCondRow(DOCTOR,'id,name,email,type,token,mobile,image,dob,gender,address',array('id'=>$google_signup[0]['id']));
      //end updating remaing data
      $response = ['google_signup' => $getData,'message'=>'doctor detail seen successfully.', 'status' => "SUCCESS"];
      echo json_encode($response);die;
    }
 }

}else
{
     $response['status']     = "FAILURE";
     $response['message']    = 'This method is not allowed.';
      echo json_encode($response);die;
}
     

   }


   function checkEmail()
   {
      $email  = $this->input->post('email');
      $mobile = $this->input->post('mobile');
      $checkEmail  =    $this->user_model->getCondResult(DOCTOR,'id',array('email'=>$email,'type'=>'normal'));
      $checkMobile  =    $this->user_model->getCondResult(DOCTOR,'id',array('mobile'=>$mobile));

    

     
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



   function addProfessionalDetail()
   {
       
       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //$token     = $this->input->post('token');
        $id     = $this->input->post('id');
        $result = $this->user_model->getCondResultArray(DOCTOR,'id',array('id'=>$id));
        if($result)
        {

        $imgArr = array();   
      if (!empty($_FILES['profile']['name'])) {

            $type     = explode('.', $_FILES["profile"]["name"]);
            $type     = strtolower($type[count($type) - 1]);
            $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "doctor_profile/" . $filename;

            move_uploaded_file($_FILES["profile"]["tmp_name"], $url);
            $data['image'] = $filename;
            $image = base_url('doctor_profile/').$filename;
            $imgArr = array('image'=>$image);
        }

         flush(); 
        $imgArr1 = array();   
      if (!empty($_FILES['document_image']['name'])) {

            $type     = explode('.', $_FILES["document_image"]["name"]);
            $type     = strtolower($type[count($type) - 1]);
            $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "doctor_profile/" . $filename;

            move_uploaded_file($_FILES["document_image"]["tmp_name"], $url);
            $data['image'] = $filename;
            $image = base_url('doctor_profile/').$filename;
            $imgArr1 = array('document'=>$image);

        }
      flush();
     

      $imgArr2 = array();   
      if (!empty($_FILES['signature_image']['name'])) {

            $type     = explode('.', $_FILES["signature_image"]["name"]);
            $type     = strtolower($type[count($type) - 1]);
            $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "doctor_profile/" . $filename;

            move_uploaded_file($_FILES["signature_image"]["tmp_name"], $url);
            $data['image'] = $filename;
            $image2 = base_url('doctor_profile/').$filename;
            $imgArr2 = array('digital_sign'=>$image2);
            
        }

   
    // ob_flush();
     

         $frees = $this->user_model->fetchValue('doctor_fees','frees',array('status'=>'1'));
        if($this->input->post('home_visit_type')=='1')    // 1 for yes  
        {
            $homestatus = "yes";
        }else
        {
            $homestatus = "no";
        }

         if($this->input->post('call_visit_type')=='1')  // 1 for no
        {
            $callStatus = "yes";
        }else
        {
            $callStatus = "no";
        }
           $createProfile = array(

                             'specialty'        => $this->input->post('specialty'),
                             'license_no'       => $this->input->post('license_no'),
                           //  'document'         => $document,
                             'experience'       => $this->input->post('exp'),
                            'qualification'     => $this->input->post('qualification'),
                             'frees'            => $frees,
                             'clinic_name'      => $this->input->post('clinic_name'),
                             'home_visit_type'  => $homestatus,
                             'home_visit_days'  => $this->input->post('home_visit_days'),
                             'call_visit_type'  => $callStatus,
                             'call_visit_days'  => $this->input->post('call_visit_days'),
                             'city_operation'   => $this->input->post('city_operation'),
                             'distance'         => $this->input->post('distance'),
                             'profile_status'   => '1' , // means profile is not created .
                            // 'eta_time'         => '25-35'
                           // 'digital_sign'     => $signature_file,
                            
                        );
           $finalArr = array_merge($createProfile,$imgArr1,$imgArr2,$imgArr);
         // echo "<pre>";
          // print_r($createProfile);die;
           $this->user_model->update_data(DOCTOR,$finalArr,array('id'=>$result[0]['id']));
        $profileDetail = $this->user_model->getCondResultArray(DOCTOR,'id,specialty,license_no,experience,qualification,frees,clinic_name,home_visit_type,home_visit_days,call_visit_type,call_visit_days,city_operation,distance',array('id'=>$id));
           $response['status']              = "SUCCESS";
           $response['profileDetail']       = $profileDetail;
           $response['message']             = 'doctor profile created Successfully';
           $response['requestKey']          = "addProfessionalDetail";
          
         echo json_encode($response);die;

        }
        else
        {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            $response['requestKey'] = "addProfessionalDetail";
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


   function addBank()
   {
     if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $id     = $this->input->post('id');
         if (empty($id)) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Id is empty';
            $response['requestKey'] = "addBank";
            echo json_encode($response);die;
        }
        $result = $this->user_model->getCondResultArray(DOCTOR,'id',array('id'=>$id));
        $doctor_id = $result[0]['id'];
        if($result)
        {
          $bankData = array(
                             'doctor_id'       => $doctor_id,
                             'bank_name'        => $this->input->post('bank_name'),
                             'ac_holder'       => $this->input->post('ac_holder_name'),
                             'account_no'         => $this->input->post('account_no'),
                             'ifsc_code'      => $this->input->post('ifsc_code'),
                             'status'       => '1',
                             'created_date' =>date('Y-m-d h:i:s'),

                        );
                        
         if (empty($bankData['bank_name'])) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Bank Name is empty';
            $response['requestKey'] = "addBank";
            echo json_encode($response);die;
        }     
        
          if (empty($bankData['account_no'])) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Account Holder Name is empty';
            $response['requestKey'] = "addBank";
            echo json_encode($response);die;
        }    
        
         if (empty($bankData['account_no'])) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Account No is empty';
           $response['requestKey'] = "addBank";
            echo json_encode($response);die;
        }    


           $insertBank =$this->my_model->insert_data(BANK,$bankData);
           $response['status']              = "SUCCESS";
           $response['message']             = 'Bank added Successfully';
           $response['requestKey']          = "addbank";
          
         echo json_encode($response);die;
   }else
    {
        $response['status']     = "FAILURE";
        $response['message']    = 'token mismatch ...Please logOut.';
        $response['requestKey'] = "addbank";
        echo json_encode($response);
        die;
   }
    }
    else
    {
     $response['status']     = "FAILURE";
     $response['message']    = 'This method is not allowed.';
      echo json_encode($response);die;
    }
}
 //show perosnal details
 function personalDetail()
 {
     if ($_SERVER['REQUEST_METHOD'] === 'POST') {

     $token = $this->input->post('token');
     // $token     = $this->input->post('token');
         if (empty($token)) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Token is empty';
            $response['requestKey'] = "personalDetail";
            echo json_encode($response);die;
        }
     $checkToken = $this->user_model->getCondResultArray(DOCTOR,'id,name,email,mobile,dob,gender,address,image',array('token'=>$token));
     $doctor_id = $checkToken[0]['id'];
     if($checkToken)
     {
            $response['status']                   = "SUCCESS";
            $response['message']                  = 'Doctor personal detail seen successfully. ';
            $response['requestKey']               = "personalDetail ";
            $response["personalDetail"]['id']           = $checkToken[0]['id'];
            $response["personalDetail"]['name']         = $checkToken[0]['name'];
            $response["personalDetail"]['email']        = $checkToken[0]['email'];
            $response["personalDetail"]['mobile']       = $checkToken[0]['mobile'];
            $response["personalDetail"]['dob']          = $checkToken[0]['dob'];
            $response["personalDetail"]['gender']       = $checkToken[0]['gender'];
            $response["personalDetail"]['address']      = $checkToken[0]['address'];
            $response["personalDetail"]['image']        = $checkToken[0]['image'];

          echo json_encode($response);die; 
     }
     else
     {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            $response['requestKey'] = "personalDetail";
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

//update personal detail

function updatePersonalDetail()
{
   if ($_SERVER['REQUEST_METHOD'] === 'POST') 
   { 
     $token = $this->input->post('token');
      if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'token is empty';
            echo json_encode($response);die;
        }
     $checkToken = $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));
     if($checkToken){
     $doctor_id = $checkToken[0]['id'];

     // $profile_image = '';
     // $profile = $this->input->post('profile');
     // if($profile)
     // {
     //    $profile_image =   $this->user_model->image_upload($profile,'doctor_profile');
     // }

     //upload image

       $imgArr = array();   
      if (!empty($_FILES['profile']['name'])) {

            $type     = explode('.', $_FILES["profile"]["name"]);
            $type     = strtolower($type[count($type) - 1]);
            $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "doctor_profile/" . $filename;

            move_uploaded_file($_FILES["profile"]["tmp_name"], $url);
            $data['image'] = $filename;
            $image = base_url('doctor_profile/').$filename;
            $imgArr = array('image'=>$image);
        }
     $personalData = array(
                             'name'         => $this->input->post('name'),
                             'email'        => $this->input->post('email'),
                             'mobile'       => $this->input->post('mobile'),
                             'dob'          => date('Y-m-d',strtotime($this->input->post('dob'))),
                             'gender'       => $this->input->post('gender'),
                             'address'       => $this->input->post('address'),
                             //'image'        => $profile_image,
                             'updated_date'  => date('Y-m-d h:i:s'),
                      
                         );
     $finalArr = array_merge($personalData,$imgArr);

      if (empty($personalData['name'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Name is empty';
            echo json_encode($response);die;
        }

        if (empty($personalData['email'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Email is empty';
            echo json_encode($response);die;
        }

         if (empty($personalData['mobile'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Mobile is empty';
            echo json_encode($response);die;
        }

         if (empty($personalData['gender'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Gender is empty';
            echo json_encode($response);die;
        }

        if (empty($personalData['dob'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Dob is empty';
            echo json_encode($response);die;
        }
    $update =  $this->user_model->update_data(DOCTOR,$finalArr,array('id'=>$doctor_id));
    $doctorData = $this->user_model->getCondResultArray(DOCTOR,'id,name,email,mobile,dob,gender,address,image',array('id'=>$doctor_id));
    if($update)
    {
            $response['status']                         = "SUCCESS";
            $response['message']                        = 'personal detail updated successfully.';
            $response['requestKey']                     = "updatePersonalDetail";
            $response["personalDetail"]['id']           = $doctorData[0]['id'];
            $response["personalDetail"]['name']         = $doctorData[0]['name'];
            $response["personalDetail"]['email']        = $personalData['email'];
            $response["personalDetail"]['mobile']       = $doctorData[0]['mobile'];
            $response["personalDetail"]['dob']          = $doctorData[0]['dob'];
            $response["personalDetail"]['gender']       = $doctorData[0]['gender'];
            $response["personalDetail"]['address']      = $doctorData[0]['address'];
            $response["personalDetail"]['image']        = $doctorData[0]['image'];
      echo json_encode($response);die;
    }
   }

     else
     {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            $response['requestKey'] = "updatePersonalDetail";
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

//show professional detail
function professionalDetail()
{
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {

     $token = $this->input->post('token');
     $checkToken = $this->user_model->getCondResultArray(DOCTOR,'id,specialty,license_no,document,experience,clinic_name,home_visit_type,home_visit_days,call_visit_type,call_visit_days,city_operation,distance,digital_sign,qualification,frees,image',array('token'=>$token));
     $doctor_id = $checkToken[0]['id'];
     if($checkToken)
     {
            $response['status']                                  = "SUCCESS";
            $response['message']                                 = 'Doctor perofessional detail seen successfully. ';
            $response['requestKey']                              = "professionalDetail ";
            $response["professionalDetail"]['id']                = $checkToken[0]['id'];
            $response["professionalDetail"]['specialty']         = $checkToken[0]['specialty'];
            $response["professionalDetail"]['license_no']        = $checkToken[0]['license_no'];
            $response["professionalDetail"]['document']          = $checkToken[0]['document'];
            $response["professionalDetail"]['experience']        = $checkToken[0]['experience'];
            $response["professionalDetail"]['qualification']     = $checkToken[0]['qualification'];
            $response["professionalDetail"]['frees']             = $checkToken[0]['frees'];
            $response["professionalDetail"]['clinic_name']       = $checkToken[0]['clinic_name'];
            $response["professionalDetail"]['home_visit_type']   = $checkToken[0]['home_visit_type'];
            $response["professionalDetail"]['home_visit_days']   = $checkToken[0]['home_visit_days'];
            $response["professionalDetail"]['call_visit_type']   = $checkToken[0]['call_visit_type'];
            $response["professionalDetail"]['call_visit_days']   = $checkToken[0]['call_visit_days'];
            $response["professionalDetail"]['city_operation']    = $checkToken[0]['city_operation'];
            $response["professionalDetail"]['distance']          = $checkToken[0]['distance'];
            $response["professionalDetail"]['digital_sign']      = $checkToken[0]['digital_sign'];
            $response["professionalDetail"]['image']             = $checkToken[0]['image'];

          //   $response["professionalDetail"]['digital_sign']      = $checkToken[0]['digital_sign'];
            

          echo json_encode($response);die; 
     }
     else
     {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            $response['requestKey'] = "professionalDetail";
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

//update doctor professional details


function updateProfessionalDetail()
   {
       
       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token     = $this->input->post('token');
        $result = $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));
        if($result)
        {
         

      //upload document image  
      $imgArr1 = array();   
      if (!empty($_FILES['document']['name'])) {

            $type     = explode('.', $_FILES["document"]["name"]);
            $type     = strtolower($type[count($type) - 1]);
            $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "doctor_profile/" . $filename;

            move_uploaded_file($_FILES["document"]["tmp_name"], $url);
            $data['image'] = $filename;
            $image = base_url('doctor_profile/').$filename;
            $imgArr1 = array('document'=>$image);

        }
      flush();
    
  //upload signature image
      $imgArr2 = array();   
      if (!empty($_FILES['signature']['name'])) {

            $type     = explode('.', $_FILES["signature"]["name"]);
            $type     = strtolower($type[count($type) - 1]);
            $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "doctor_profile/" . $filename;

            move_uploaded_file($_FILES["signature"]["tmp_name"], $url);
            $data['image'] = $filename;
            $image2 = base_url('doctor_profile/').$filename;
            $imgArr2 = array('digital_sign'=>$image2);
            
        }

   
    // ob_flush();
     

     

           $createProfile = array(

                             'specialty'        => $this->input->post('specialty'),
                             'license_no'       => $this->input->post('license'),
                           //  'document'         => $document,
                             'experience'       => $this->input->post('exp'),
                             'qualification'     => $this->input->post('qualification'),
                             'clinic_name'      => $this->input->post('clinic_name'),
                             'home_visit_type'  => $this->input->post('home_visit_type'),
                             'home_visit_days'  => implode(',',$this->input->post('home_visit_days')),
                             'call_visit_type'  => $this->input->post('call_visit_type'),
                             'call_visit_days'  => implode(',',$this->input->post('call_visit_days')),
                             'city_operation'   => $this->input->post('city_operation'),
                             'distance'         => $this->input->post('distance'),
                            // 'digital_sign'     => $signature_file,
                            
                        );
         $finalArr = array_merge($createProfile,$imgArr1,$imgArr2) ; 
         // echo "<pre>";
          // print_r($createProfile);die;
           $this->user_model->update_data(DOCTOR,$finalArr,array('id'=>$result[0]['id']));
           $response['status']              = "SUCCESS";
           $response['message']             = 'perofessional detail updated successfully.';
           $response['requestKey']          = "updateProfessionalDetail";
          
         echo json_encode($response);die;

        }
        else
        {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            $response['requestKey'] = "updateProfessionalDetail";
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

// show doctor bank details
function bankDetail()
{
     if ($_SERVER['REQUEST_METHOD'] === 'POST') {

     $token = $this->input->post('token');
     $checkToken = $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));
     $doctor_id = $checkToken[0]['id'];
     $bankDetail = $this->user_model->getCondResultArray(BANK,'bank_name,account_no,ac_holder,ifsc_code',array('doctor_id'=>$doctor_id));
     if($checkToken)
     {
            $response['status']                      = "SUCCESS";
            $response['message']                     = 'Doctor Bank detail seen successfully. ';
            $response['requestKey']                  = "bankDetail ";
            $response["bankDetail"]['bank_name']       = $bankDetail[0]['bank_name'];
            $response["bankDetail"]['ac_holder_name']  = $bankDetail[0]['ac_holder'];
            $response["bankDetail"]['account_no']      = $bankDetail[0]['account_no'];
            $response["bankDetail"]['ifsc_code']       = $bankDetail[0]['ifsc_code'];
            
            

          echo json_encode($response);die; 
     }
     else
     {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            $response['requestKey'] = "bankDetail";
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


//update doctor bank detail

 function updateBankDetail()
   {
     if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $token     = $this->input->post('token');
        $result = $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));
        $doctor_id = $result[0]['id'];
        if($result)
        {
          $bankData = array(
                            
                             'bank_name'        => $this->input->post('bank_name'),
                             'ac_holder'        => $this->input->post('ac_holder_name'),
                             'account_no'       => $this->input->post('account_no'),
                             'ifsc_code'        => $this->input->post('ifsc_code'),
                             'updated_date'     => date('Y-m-d h:i:s'),

                        );
    $update  = $this->user_model->update_data(BANK,$bankData,array('doctor_id'=>$doctor_id));
     if($update)
     {
          
           $response['status']              = "SUCCESS";
           $response['message']             = 'Bank detail updated Successfully';
            $response['requestKey'] = "updateBankDetail";
            echo json_encode($response);die;
          
      }    
        
   }else
    {
        $response['status']     = "FAILURE";
        $response['message']    = 'token mismatch ...Please logOut.';
        $response['requestKey'] = "updateBankDetail";
        echo json_encode($response);
        die;
   }
    }
    else
    {
     $response['status']     = "FAILURE";
     $response['message']    = 'This method is not allowed.';
      echo json_encode($response);die;
    }
}








   function changePassword()
   {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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

  $checkToken = $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));
  $doctor_id = $checkToken[0]['id'];
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
   $passwordFound = $this->user_model->getCondResultArray(DOCTOR,'password',array('id'=>$doctor_id,'password'=>md5($oldpass)));
    if($passwordFound)
    {

    
    $new_pass=md5($newpass);
   

    
      
      $updatedata=array("password"=>$new_pass);
     
      $update=$this->my_model->update_data(DOCTOR,array('id'=>$doctor_id),$updatedata);
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
   }
    else
    {
     $response['status']     = "FAILURE";
     $response['message']    = 'This method is not allowed.';
      echo json_encode($response);die;
    }

}


   function forgotPassword()
   {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mobile = $this->input->post('mobile');
    $con =array('mobile'=>$mobile );
    $fields = "id,name,email";
    $user=$this->my_model->getfields(DOCTOR,$fields,$con);
 
  
  if(!empty($user)){
   $name         = ucfirst($user[0]->name);
   $email        = $user[0]->email;
  
   $otp = rand(1000, 9999);
 
   $this->my_model->update_data(DOCTOR,array('mobile' =>$mobile),array('confirm_code'=>$otp));
   
  
    
      $getResponse = file_get_contents("https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=K0IbqH3mHE2PAyuTBlUipA&senderid=EDUIAP&channel=2&DCS=0&flashsms=0&number=" . $mobile . "&text=Your%20verification%20code%20is%20" . $otp . ".&route=13");
    
          $success  = "otp send successfully";
          $response = ['message' => $success, 'status' => "SUCCESS",'otp'=>$otp]; 
    
    }
    else{
            $errors = "Mobile no is not registered.";
            $response = ['message' => $errors, 'status' => "FAILURE"];
      }
  
   echo json_encode($response);
   }
    else
    {
     $response['status']     = "FAILURE";
     $response['message']    = 'This method is not allowed.';
      echo json_encode($response);die;
    } 
    
 
}

function updatepassword()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $newpass = $this->input->post('new_pass');
  $conpass = $this->input->post('confirm_pass');
  $otp = $this->input->post('otp');
   if (empty($otp)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'OTP is empty';
            $response['requestKey'] = "updatepassword";
            echo json_encode($response);die;
        }

  $checkOtpToken = $this->user_model->getCondResultArray(DOCTOR,'id',array('confirm_code'=>$otp));
  if($checkOtpToken){

 
   if (empty($newpass)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'New Password is empty';
            $response['requestKey'] = "updatepassword";
            echo json_encode($response);die;
        }

        if (empty($conpass)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Confirm Password is empty';
            $response['requestKey'] = "updatepassword";
            echo json_encode($response);die;
        }

   
    if($newpass != $conpass)    
    { 
            $response['status']  = "FAILURE";
            $response['message'] = 'New password must be equal to confirm password';
            $response['requestKey'] = "updatepassword";
            echo json_encode($response);die;
          
    }

    
    $new_pass=md5($newpass);
    $con_pass=md5($conpass);

    
      $con=array("confirm_code"=>$otp);
      $updatedata=array("password"=>$new_pass);
     
      $update=$this->my_model->update_data(DOCTOR,$con,$updatedata);
      if($update) {
     
          $success = "Password Updated successfully";
          $response = ['message' => $success, 'status' => "SUCCESS"];
           echo json_encode($response);die;
   }

 }
 else
 {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            $response['requestKey'] = "updatepassword";

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

   
   


  
	   
    //notification on or off
    function notification()
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
     

      $checkToken =   $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));
      if($checkToken)
      {
      $update =  $this->user_model->update_data(DOCTOR,array('notification_status'=>$status),array('id'=>$checkToken[0]['id']));
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

  }
 //docotr past booking list 

  function pastBookingList()  //for past booking
  {

     $token = $this->input->post('token');
      

     if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

     $checkToken =   $this->user_model->getCondResultArray(DOCTOR,'id,verify_status',array('token'=>$token));
     $id = $checkToken[0]['id'];

    if($checkToken)
    {
      
     // if($checkToken[0]['verify_status']==1)
    
     $booking_status=4;     
    $query = "SELECT u.name,u.email,u.mobile,b.id,b.created_date,b.address,b.address_type,b.booking_type,b.schedule_time,b.schedule_date,b.session_status FROM `doctor_booking` as b INNER JOIN doctor_user as u on b.user_id=u.id  WHERE doctor_id = '".$id."' and booking_status = '".$booking_status."'"   ;
    $result = $this->db->query($query)->result_array(); 
    //echo $this->db->last_query();die;
    if($result){
    $response = ['status' => "SUCCESS",'pastbooking' => $result];
    echo json_encode($response);die;
 }
 else{
       $response['status']     = "SUCCESS";
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


 function upcomingBookinList()  //for past booking
  {

     $token = $this->input->post('token');
      

     if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

     $checkToken =   $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));
     $id = $checkToken[0]['id'];

    if($checkToken)
    {
         $dateto = date('Y-m-d');
    
    // $cond = "doctor_id = '".$id."' and str_to_date(b.created_date,'%Y-%m-%d') < '".$dateto."'";
    $booking_status=3;     
    $query = "SELECT u.name,u.email,u.mobile,b.id,b.created_date,b.address,b.address_type,b.booking_type,b.schedule_time,b.schedule_date,b.session_status FROM `doctor_booking` as b INNER JOIN doctor_user as u on b.user_id=u.id  WHERE doctor_id = '".$id."' and booking_status = '".$booking_status."'"   ;
    $result = $this->db->query($query)->result_array(); 


    if($result){
    $response = ['status' => "SUCCESS",'pastbooking' => $result];
    echo json_encode($response);die;
 }
 else{
       $response['status']     = "SUCCESS";
       $response['message']    = 'No upcoming booking record found.';
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




//add start session detail

 function logout()
   {
    //echo "hi";die;
       $token = $this->input->post('token');
       
       $userTokenCheck =   $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));
       // if($result)
        if($userTokenCheck) {
        $userLogout = $this->user_model->update_data(DOCTOR,array('token'=>'','login_status'=>'0'),array('id'=>$userTokenCheck[0]['id']));
    
            if($userLogout) {
                $response = ['message' => "Logout successfully", 'status' => "SUCCESS"];
     
          }
        } else{
            $errors = "Bad Request";
            $response = ['message' => $errors, 'status' => "FAILURE"];
         
        }

         echo json_encode($response);
   }

 //accept user booking
   function acceptBooking()
   {
     $token = $this->input->post('token');
     $status = $this->input->post('status');
     $booking_id  = $this->input->post('booking_id');
     $reason = $this->input->post('reason');

     if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

     $checkToken =   $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));
     $id = $checkToken[0]['id'];

    if($checkToken)
    {
         
     if($status=='1')
     {
        $msg = "Booking Accpted successfully.";
         $data = array('booking_status'=>$status);

     }  else if($status=='2')  //reject
     {
        $data = array('booking_status'=>$status,'reject_reason'=>$reason );
        $msg = "Booking Rejected successfully";
     }
     $update =   $this->user_model->update_data('doctor_booking',$data,array('id'=>$booking_id));
         
       $response['status']     = "SUCCESS";
       $response['message']    = $msg;
       echo json_encode($response);
      
}
else
{
    $response['status']     = "FAILURE";
    $response['message']    = 'token mismatch ...Please logOut.';
    echo json_encode($response);
}
   }

   function qualification()
   {
   // echo "hi";
    $qualification = $this->user_model->getCondResultArray('doctor_qualification','id,name',array('status'=>'1'));
    if(!empty($qualification))
    {
        $response = [ 'status' => "SUCCESS",'message'=>'qualification List seen successfully.','qualification'=>$qualification];
      echo json_encode($response);die;
    }
   }

    function city()
   {
   // echo "hi";
    $city = $this->user_model->getCondResultArray('doctor_city','id,name',array('status'=>'1'));
    if(!empty($city))
    {
        $response = [ 'status' => "SUCCESS",'message'=>'city List seen successfully.','city'=>$city];
      echo json_encode($response);die;
    }
   }


    function specialtyList()
   {
   // echo "hi";
    $specialtyList = $this->user_model->getCondResultArray('specility','id,name',array('status'=>'1'));
    if(!empty($specialtyList))
    {
        $response = [ 'status' => "SUCCESS",'message'=>'specility List seen successfully.','specialtyList'=>$specialtyList];
      echo json_encode($response);die;
    }
   }


   function experienceList()
   {
   // echo "hi";
    $experienceList = $this->user_model->getCondResultArray('doctor_exp','id,exp',array('status'=>'1'));
    if(!empty($experienceList))
    {
        $response = [ 'status' => "SUCCESS",'message'=>'experience List seen successfully.','experienceList'=>$experienceList];
      echo json_encode($response);die;
    }
   }


     function bankList()
   {
   // echo "hi";
    $bankList = $this->user_model->getCondResultArray('bank_listing','id,name',array('status'=>'1'));
    if(!empty($bankList))
    {
        $response = [ 'status' => "SUCCESS",'message'=>'Bank List seen successfully.','bankList'=>$bankList];
      echo json_encode($response);die;
    }
   }


   //doctor session start apis

   function homeSessionStart()
   {
     if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $token     = $this->input->post('token');
        $booking_id = $this->input->post('booking_id');
         if (empty($token)) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Token is empty';
            $response['requestKey'] = "homeSessionStart";
            echo json_encode($response);die;
        }

         $image='';    
       if (!empty($_FILES['image']['name'])) {

            $type     = explode('.', $_FILES["image"]["name"]);
            $type     = strtolower($type[count($type) - 1]);
            $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "session_image/" . $filename;

            move_uploaded_file($_FILES["image"]["tmp_name"], $url);
            $data['image'] = $filename;
            $image = base_url('session_image/').$filename;
           
        }

        //upload digital signature 
           $signature='';    
       if (!empty($_FILES['signature']['name'])) {

            $type     = explode('.', $_FILES["signature"]["name"]);
            $type     = strtolower($type[count($type) - 1]);
            $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "session_image/" . $filename;

            move_uploaded_file($_FILES["signature"]["tmp_name"], $url);
            $data['signature'] = $filename;
            $signature = base_url('session_image/').$filename;
           
        }
        //end upload digital singnature 
        $result = $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));
        $doctor_id = $result[0]['id'];
        if($result)
        {
          $sessionData = array(
                             'doctor_id'          => $doctor_id,
                             'booking_id'         => $booking_id,
                             'subjective'         => $this->input->post('subjective'),
                             'objective'          => $this->input->post('objective'),
                             'assessment'         => $this->input->post('assessment'),
                              'planning'          => $this->input->post('planning'),
                              'session_type  '    => 'home',
                              'image'             => $image,
                              'signature'         => $signature,
                             'status'             => '1',
                             'created_date'       =>date('Y-m-d h:i:s'),

                        );
                        
         if (empty($booking_id)) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Booking Id is empty';
            $response['requestKey'] = "homeSessionStart";
            echo json_encode($response);die;
        }     
        
         if (empty($sessionData['subjective'])) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Subjective is empty';
            $response['requestKey'] = "homeSessionStart";
            echo json_encode($response);die;
        }    
        
        if (empty($sessionData['objective'])) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Objective is empty';
            $response['requestKey'] = "homeSessionStart";
            echo json_encode($response);die;
        }   

         if (empty($sessionData['assessment'])) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Assessment is empty';
            $response['requestKey'] = "homeSessionStart";
            echo json_encode($response);die;
        }  

         if (empty($sessionData['planning'])) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Planning is empty';
            $response['requestKey'] = "homeSessionStart";
            echo json_encode($response);die;
        }    


           $insertid =$this->my_model->insert_data('doctor_session',$sessionData);
           $update =$this->my_model->update_data('doctor_booking',array('id'=>$booking_id),array('booking_status'=>'4','session_status'=>'0')); //update booking status 4 
           //session status 0 means session end
           //echo $this->db->last_query();die;
           $response['status']              = "SUCCESS";
           $response['message']             = 'Session added Successfully';
           $response['requestKey']          = "homeSessionStart";
          
         echo json_encode($response);die;
   }else
    {
        $response['status']     = "FAILURE";
        $response['message']    = 'token mismatch ...Please logOut.';
        $response['requestKey'] = "homeSessionStart";
        echo json_encode($response);
        die;
   }
    }
    else
    {
     $response['status']     = "FAILURE";
     $response['message']    = 'This method is not allowed.';
      echo json_encode($response);die;
    }
}


function callSessionStart()
   {
     if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $token     = $this->input->post('token');
        $booking_id = $this->input->post('booking_id');
         if (empty($token)) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Token is empty';
            $response['requestKey'] = "callSessionStart";
            echo json_encode($response);die;
        }

          $image='';    
       if (!empty($_FILES['image']['name'])) {

            $type     = explode('.', $_FILES["image"]["name"]);
            $type     = strtolower($type[count($type) - 1]);
            $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "session_image/" . $filename;

            move_uploaded_file($_FILES["image"]["tmp_name"], $url);
            $data['image'] = $filename;
            $image = base_url('session_image/').$filename;
           
        }

          //upload digital signature 
           $signature='';    
       if (!empty($_FILES['signature']['name'])) {

            $type     = explode('.', $_FILES["signature"]["name"]);
            $type     = strtolower($type[count($type) - 1]);
            $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "session_image/" . $filename;

            move_uploaded_file($_FILES["signature"]["tmp_name"], $url);
            $data['signature'] = $filename;
            $signature = base_url('session_image/').$filename;
           
        }
        //end upload digital singnature 

        $result = $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));
        $doctor_id = $result[0]['id'];
        if($result)
        {
          $sessionData = array(
                             'doctor_id'          => $doctor_id,
                             'booking_id'         => $booking_id,
                             'subjective'         => $this->input->post('subjective'),
                             'objective'          => $this->input->post('objective'),
                             'assessment'         => $this->input->post('assessment'),
                              'planning'          => $this->input->post('planning'),
                              'session_type  '    => 'call',
                              'image'             => $image,
                              'signature'         => $signature,
                             'status'             => '1',
                             'created_date'       =>date('Y-m-d h:i:s'),

                        );
                        
         if (empty($booking_id)) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Booking Id is empty';
            $response['requestKey'] = "callSessionStart";
            echo json_encode($response);die;
        }     
        
         if (empty($sessionData['subjective'])) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Subjective is empty';
            $response['requestKey'] = "callSessionStart";
            echo json_encode($response);die;
        }    
        
        if (empty($sessionData['objective'])) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Objective is empty';
            $response['requestKey'] = "callSessionStart";
            echo json_encode($response);die;
        }   

         if (empty($sessionData['assessment'])) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Assessment is empty';
            $response['requestKey'] = "callSessionStart";
            echo json_encode($response);die;
        }  

         if (empty($sessionData['planning'])) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Planning is empty';
            $response['requestKey'] = "callSessionStart";
            echo json_encode($response);die;
        }    


           $insertid =$this->my_model->insert_data('doctor_session',$sessionData);
           if($insertid){
             $update =$this->my_model->update_data('doctor_booking',array('id'=>$booking_id),array('booking_status'=>'4','session_status'=>'0')); //update booking status 4 
             //session status 0 means session end
           //echo $this->db->last_query();die;
           $response['status']              = "SUCCESS";
           $response['message']             = 'Session added Successfully';
           $response['requestKey']          = "callSessionStart";
       }
          
         echo json_encode($response);die;
   }else
    {
        $response['status']     = "FAILURE";
        $response['message']    = 'token mismatch ...Please logOut.';
        $response['requestKey'] = "callSessionStart";
        echo json_encode($response);
        die;
   }
    }
    else
    {
     $response['status']     = "FAILURE";
     $response['message']    = 'This method is not allowed.';
      echo json_encode($response);die;
    }
}


//session status
 function sessionStatus()
 {
  $booking_id = $this->input->post('booking_id');
  if (empty($booking_id)) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Booking id  is empty';
          //  $response['requestKey'] = "callSessionStart";
            echo json_encode($response);die;
        } 

  $update  = $this->my_model->update_data('doctor_booking',array('id'=>$booking_id),array('session_status'=>'1')); //update session status 1 means session start      
  //echo $this->db->last_query(); 
  if($update)
  {
         $response['status']              = "SUCCESS";
         $response['message']             = 'Session start Successfully';
         echo json_encode($response);die;
        // $response['requestKey']          = "callSessionStart";
  }

  //$status     = $this->input->post('session_status');




 }

//end session status


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

         
     

      $checkToken =   $this->user_model->getCondResultArray(DOCTOR,'id,notification_status  ',array('token'=>$token));
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
  
  function homeUSerBookingListing()
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

         
     

      $checkToken =   $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));
      if($checkToken)
      {
      $result =  $this->user_model->getHomeUserList(array('B.doctor_id'=>$checkToken[0]['id'],'B.booking_status'=>'0'));

      if(!empty($result))
      {
        foreach($result as $values)
        {
//echo $values->doctor_id;
         $distance =   $this->user_model->fetchValue(DOCTOR,'distance',array('id'=>$values->doctor_id)); 
        $homeBookingList[] = array(
                                     'booking_id'               => $values->booking_id, 
                                     'user_name'                => $values->username,
                                     'address'                  => $values->address,
                                     'booking_type'             => $values->booking_type,
                                     'reason_visit'             => $values->reason_visit,
                                     'date'                     => date('d-m-Y',strtotime($values->created_date)),
                                     'time'                     => date('h:i:s',strtotime($values->created_date)),
                                     'scheduling_date'          => date('d-m-Y',strtotime($values->schedule_date)),
                                     'schedule_time'            => date('h:i:s',strtotime($values->schedule_time)),
                                     'distance'                 => $distance,
                                   );

    }
      }
    
       
            $response['status']               = "SUCCESS";
            $response['homeBookingList']      = $homeBookingList;
            $response['message']              = 'Home booking list  seen successfully.';
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


  // get user medical detail 

  function getReportDetail()
  {
     if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token       = $this->input->post('token');
      $booking_id  = $this->input->post('booking_id');

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

         
     

      $checkToken =   $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));


      if($checkToken)
      {
        $userId =   $this->user_model->fetchValue('doctor_booking','user_id',array('id'=>$booking_id));
    
        //get hospital 
         $hostpital =   $this->user_model->getCondResultArray('user_hospital_records','id,hospital_name,provider_name,provider_specility,service_date,type,created_date',array('user_id'=>$userId));
       if(!empty($hostpital)){

         foreach($hostpital as $hos){
         $hos_img =   $this->user_model->getCondResult('medical_record_image','image',array('record_id'=>$hos['id'],'type'=>'hospital'));

         if(empty($hos_img))
              $hos_img = array();

                 $HospitalArr[] = array(
                                   'id'                  => $hos['id'],
                                   'hospital_name'       => $hos['hospital_name'],
                                   'provider_name'       => $hos['provider_name'],
                                   'provider_specility'  => $hos['provider_specility'],
                                   'service_date'        => $hos['service_date'],
                                   'date'                => date('d-m-Y',strtotime($hos['created_date'])),
                                    'type'               => $hos['type'],
                                   'images'              => $hos_img,

                                 );
             }
         }else
         {
            $HospitalArr = array();
         }
        
        //end hospital

         //get speciality
          $specialty =   $this->user_model->getCondResultArray('user_specialty_records','id,specialty,specialty_type,service_date,type,created_date',array('user_id'=>$userId));
            if(!empty($specialty)){

            foreach($specialty as $spe){
                  $spe_img =   $this->user_model->getCondResult('medical_record_image','image',array('record_id'=>$spe['id'],'type'=>'specialty'));
            if(empty($spe_img))
                 $spe_img = array();
                 $SpecialtyArr[] = array(
                                      'id'              => $spe['id'],
                                      'specialty'       => $spe['specialty'],
                                      'specialty_type'  => $spe['specialty_type'],
                                      'service_date'    => $spe['service_date'],
                                       'date'           => date('d-m-Y',strtotime($hos['created_date'])),
                                      'type'            => $spe['type'],
                                      'images'          => $spe_img,
                                   );
             }

         }else
         {
            $SpecialtyArr = array();
         }
         //end speciality

       //get lab 
          $lab =   $this->user_model->getCondResultArray('user_lab_records','id,lab_name,prescription_name,lab_date,type,created_date',array('user_id'=>$userId));
         if(!empty($lab)){
                
         foreach($lab as $lb)
             {
                $lab_img =   $this->user_model->getCondResultArray('medical_record_image','image',array('record_id'=>$lb['id'],'type'=>'lab'));

                if(empty($lab_img))
                    $lab_img = array();

                 $LabArr[] = array(
                                      'id'                  => $lb['id'],
                                      'lab_name'            => $lb['lab_name'],
                                      'prescription_name'   => $lb['prescription_name'],
                                      'lab_date'            => $lb['lab_date'],
                                       'date'               => date('d-m-Y',strtotime($hos['created_date'])),
                                      'type'                => $lb['type'],
                                      'images'              => $lab_img,
                                   );
             }
         }else
         {
             $LabArr =array();
         }
       //end lab 

       //get physical
          $physical =   $this->user_model->getCondResultArray('user_physical_therapist_records','id,therapy_name,therapy_date,type,created_date',array('user_id'=>$userId));
        if(!empty($physical)){
                
       foreach($physical as $py)
             {
                 $phy_img =   $this->user_model->getCondResultArray('medical_record_image','image',array('record_id'=>$py['id'],'type'=>'physical'));

                 if(empty($phy_img))
                     $phy_img = array();

                   $PhyArr[] = array(
                                      'id'              => $py['id'],
                                      'therapy_name'    => $py['therapy_name'],
                                      'therapy_date'    => $py['therapy_date'],
                                       'date'           => date('d-m-Y',strtotime($hos['created_date'])),
                                      'type'            => $py['type'],
                                      'images'          => $phy_img,
                                   );
             }
         }else
         {
            $PhyArr = array();
         }
       //end physical 

         //get other

        $other =   $this->user_model->getCondResultArray('user_other_records','id,description,date,type,created_date',array('user_id'=>$userId));
            
             if(!empty($other))
             {

            
            foreach($other as $othr)
             {

                 $other_img =   $this->user_model->getCondResultArray('medical_record_image','image',array('record_id'=>$othr['id'],'type'=>'other'));
                  if(empty($other_img))
                      $other_img = array();
                 $OtherArr[] = array(
                                      'id'                  => $othr['id'],
                                      'description'         => $othr['description'],
                                      'date'                => $othr['date'],
                                       'date'               => date('d-m-Y',strtotime($hos['created_date'])),
                                      'type'                => $othr['type'],
                                      'images'              => $other_img,
                                   );
             }
         }
         else
         {
            $OtherArr =array();
         }
         //end other


         //get pharmacy 
           $pharmacy =   $this->user_model->getCondResultArray('user_pharmacy_script','id,pharmacy_name,pharmacy_provider_name,service_date,type,created_date',array('user_id'=>$userId));
            

              if(!empty($pharmacy))
              {
                

                foreach($pharmacy as $ph)
                {
                     $ph_img =   $this->user_model->getCondResultArray('medical_record_image','image',array('record_id'=>$ph['id'],'type'=>'pharmacy'));

                      if(empty($ph_img))
                           $ph_img = array();

                         $PharmacyArr[] = array(
                                              'id'                     => $ph['id'],
                                              'pharmacy_name'          => $ph['pharmacy_name'],
                                              'pharmacy_provider_name' => $ph['pharmacy_provider_name'],
                                               'service_date'          => $ph['service_date'],
                                               'date'                 => date('d-m-Y',strtotime($hos['created_date'])),
                                              'type'                   => $ph['type'],
                                              'images'                 => $ph_img,
                                           );
             }

                }

            else
            {
                $PharmacyArr =array();
            }
         //end pharmacy

         //get session 
           //get pharmacy 
        $getSeeion =   $this->user_model->getCondResultArray('doctor_session','id,subjective,objective,assessment,planning,image',array('booking_id'=>$booking_id));
            

              if(!empty($getSeeion))
              {
                

                foreach($getSeeion as $sess)
                {
                     

                      

                         $sessArr[] = array(
                                              'id'                   => $sess['id'],
                                              'subjective'           => $sess['subjective'],
                                              'objective'            => $sess['objective'],
                                               'assessment'          => $sess['assessment'],
                                               'planning'            => $sess['planning'],
                                               'images'               => $sess['image'],
                                           );
             }

                }

            else
            {
                $sessArr =array();
            }
         //end session    
     
           $response = [ 'status' => "SUCCESS",'message'=>'user medical detail seen successfully.','hospitalDetail' => $HospitalArr,'specialtyDetail'=>$SpecialtyArr,'labDetail'=>$LabArr,'physicalDetails'=>$PhyArr,'otherDetail'=>$OtherArr,'pharmacyDetail'=>$PharmacyArr,'sessionDetail'=>$sessArr];
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
  //past booking detail

  function pastBookingDetails() //when click on past booking show this detail
  {

     if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token       = $this->input->post('token');
      $booking_id  = $this->input->post('booking_id');
      $user_id    = $this->input->post('user_id');

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

         
     

      $checkToken =   $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));
      $doctor_id = $checkToken[0]['id'];

      if($checkToken)
      {
    
    
    $getSeeion =   $this->user_model->getCondResultArray('doctor_session','id,subjective,objective,assessment,planning,image',array('booking_id'=>$booking_id));
     $rating = $this->user_model->fetchValue('doctor_rating','rating',array('doctor_id'=> $doctor_id,'user_id'=>$user_id)); 
     if(!empty($getSeeion)){
    foreach($getSeeion as $values)
    {
      
  $pastBookingDetails[] = array(
                      'subjective'    => $values['subjective'],
                      'objective'     => $values['objective'],
                      'assessment'    => $values['assessment'],
                      'planning'      => $values['planning'],
                      'image'         => $values['image'],
                      'rating'        => $rating,
                     );
    }
      $response = [ 'status' => "SUCCESS",'message'=>'pastBookingDetails detail seen successfully.','pastBookingDetails' => $pastBookingDetails];
            echo json_encode($response);die;
          }else 
          {
             $response['status']     = "SUCCESS";
             $response['message']    = 'No Record found';
             echo json_encode($response);
          }  
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

function rejectReason()
{
   $rejectReason =  $this->user_model->getCondResultArray(REASON,'id,name',array('status'=>'1'));
   if(!empty($rejectReason))
   {
   $response = [ 'status' => "SUCCESS",'message'=>'Reject Reason List seen successfully.','rejectReason' => $rejectReason];
            echo json_encode($response);die;
   }else
   {
       $response['status']     = "SUCCESS";
       $response['message']    = 'No Record found';
       echo json_encode($response);
   }
}


}
?>
