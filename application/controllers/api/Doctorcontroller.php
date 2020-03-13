<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/////====   START LEAD CONTROLLERS CLASS   =======///////
//doctor now
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

     
     $language_type = $this->input->post('language_type'); 
     $email     = $this->input->post('email');
     //$mobile    = $this->input->post('mobile');
     $password  = $this->input->post('password');

     if (empty($email)) {
            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please enter Email/Phone';
             }else if($language_type=='hi'){
              $response['message']    = 'कृपया ईमेल / फोन नंबर दर्ज करें';  
             }
            $response['requestKey'] = "login";

            echo json_encode($response);die;
        }
        if (empty($password)) {

            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please enter Password';
             }else if($language_type=='hi'){
               $response['message']    = 'अपना पासवर्ड दर्ज करें';  
             }
            $response['requestKey'] = "login";
            echo json_encode($response);die;
        }

        $cond = "(email = '".$email."' OR mobile = '".$email."') AND password = '".md5($password)."'";
        $result = $this->user_model->getCondResultArray(DOCTOR,'id,name,email,mobile,country_code,dob,gender,address,image,profile_status,verify_status,digital_sign,available_status',$cond);
        $doctor_id = $result[0]['id'];
        $profileStatus  = $result[0]['profile_status'];
        if($profileStatus=='0') //means profile is not created 
        {
          $verifyStatus = '1';
        }else
        {
            $verifyStatus = '0';
        }
        $checkBlock =  $this->user_model->getCondResultArray(DOCTOR,'id',array('id'=>$doctor_id,'status'=>'1')); //check block unblock
        $checkVerifystatus =  $this->user_model->getCondResultArray(DOCTOR,'id',array('id'=>$doctor_id,'verify_status'=>$verifyStatus));  // zeero means not login
         $doctorRating =  $this->user_model->AvgRating('doctor_rating',array('doctor_id'=>$doctor_id));
         $doctorRate =  round($doctorRating->rate,1);
         if($doctorRate)
         {
          $rate = $doctorRate;
         }else
         {
          $rate=0;
         }
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
                 'language_type'=>$language_type,
            );
             $this->user_model->update_data(DOCTOR,$updateToken,array('id'=>$result[0]['id']));
            

           $notificationCount = count($this->user_model->resultArrayNull('notification','id',array('doctor_id'=>$doctor_id,'status'=>'0','badge_count'=>'1','send_to'=>'doctor','type !='=>'adminChatDoctor')));
           //echo $notificationCount;
         //echo $this->db->last_query();die;
            $response['status']                  = "SUCCESS";
            if($language_type=='en'){
            $response['message']                 = 'Doctor Login Successfully';
             }else if($language_type=='hi'){
              $response['message']                 = 'डॉक्टर ने  सफलतापूर्वक लॉग इन किया ';  
             }
            $response['requestKey']              = "login";
            $response["login"]['id']             = $result[0]['id'];
            $response["login"]['name']           = $result[0]['name'];
            $response["login"]['email']          = $result[0]['email'];
            $response["login"]['mobile']         = $result[0]['mobile'];
            $response["login"]['country_code']   = $result[0]['country_code'];
            $response["login"]['dob']            = $result[0]['dob'];
            $response["login"]['gender']         = $result[0]['gender'];
            $response["login"]['address']        = $result[0]['address'];
            $response["login"]['image']          = $result[0]['image'];
             $response["login"]['signature']     = $result[0]['digital_sign'];
            $response["login"]['token']          =  $updateToken['token'];
            $response["login"]['profile_status'] =  $result[0]['profile_status'];
            $response["login"]['verify_status']  =  $result[0]['verify_status'];
             $response["login"]['available_status']  =  $result[0]['available_status'];
            $response["login"]['rating']          =  "$rate";
            $response["login"]['badge_count']          =  $notificationCount;


          echo json_encode($response);die; 
     }else{
        if($language_type=='en'){
         echo json_encode(array('status' => "FAILURE", "message" => "Your profile is under verification process. Please wait for admin approval"));
        }else if($language_type=='hi'){
          echo json_encode(array('status' => "FAILURE", "message" => "आपकी प्रोफ़ाइल सत्यापन प्रक्रिया के अंतर्गत है। कृपया व्यवस्थापक अनुमोदन की प्रतीक्षा करें"));  
        }
     }
}
     else
      {
          if($language_type=='en'){
          echo json_encode(array('status' => "FAILURE", "message" => "Your account has been blocked due to some suspicious activity.Please contact admin."));
           }else if($language_type=='hi'){
         echo json_encode(array('status' => "FAILURE", "message" => "कुछ संदिग्ध गतिविधि के कारण आपका खाता ब्लॉक कर दिया गया है। कृपया संपर्क व्यवस्थापक से संपर्क करें।"));
           }
      }
}
        else
        {
           if($language_type=='en'){ 
          echo json_encode(array('status' => "FAILURE", "message" => "Invalid Email Id or Password!"));
           }else if($language_type=='hi'){
             echo json_encode(array('status' => "FAILURE", "message" => "ईमेल / फोन नंबर अमान्य है"));
           }
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
    $language_type = $this->input->post('language_type');
    if($signup_type=='normal'){
        
     $address = $this->input->post('address');
      if(!empty($address))
      {
      $res = $this->user_model->getLatLong($address);
      $latitude =  $res['latitude'];
      $longitude =  $res['longitude'];
      }    
     $doctorData = array(
                        'name'         => $this->input->post('name'),
                        'email'        => $this->input->post('email'),
                        'password'     => md5($this->input->post('password')),
                        'mobile'       => $this->input->post('mobile'),
                        'country_code' => $this->input->post('country_code'),
                        'dob'          => date('Y-m-d',strtotime($this->input->post('dob'))),
                        'gender'       => $this->input->post('gender'),
                        'address'      => $this->input->post('address'),
                        'latitude'     => $latitude,
                        'longitude'     => $longitude,
                        'token'        => $token,
                        'device_type'  => $this->input->post('device_type'),
                        'device_token' => $this->input->post('device_token'),
                        'type'         => 'normal',
                        'status'       => '1',
                        'available_status'=> 'on',
                        'verify_status' => '0',    // 0 means not verified 
                        'profile_status'   => '1' , // means profile is not created .
                        'notification_status' =>'on',
                        'language_type'=>$language_type,
                        'created_date' => date('Y-m-d h:i:s'),
                        'updated_date' => date('Y-m-d h:i:s'),
                       );

     if (empty($doctorData['name'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please enter name';
             }else if($language_type=='hi'){
               $response['message'] = 'कृपया नाम दर्ज करें';  
             }
            $response['requestKey'] = "adddoctor";
            echo json_encode($response);die;
        }

        if (empty($doctorData['email'])) {
            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please enter email';
             }else if($language_type=='hi'){
              $response['message']    = 'कृपया ईमेल दर्ज करें';  
             }
            $response['requestKey'] = "adddoctor";
            echo json_encode($response);die;
        }

         if (!filter_var($doctorData['email'], FILTER_VALIDATE_EMAIL)) {
            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Invalid email format';
             }else if($language_type=='hi'){
              $response['message']    = 'ईमेल प्रारूप अमान्य है';  
             }
            $response['requestKey'] = "adddoctor";
            echo json_encode($response);die;
        }


        if (!is_numeric($doctorData['mobile'])) {
            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Phone no is not valid';
             }else if($language_type=='hi'){
               $response['message']    = 'फ़ोन नंबर मान्य नहीं है';  
             }
            $response['requestKey'] = "adddoctor";
            echo json_encode($response);die;
        }

        if (empty($doctorData['mobile'])) {

            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please enter Phone'; 
           }else if($language_type=='hi'){
            $response['message']    = 'कृपया फ़ोन नंबर दर्ज करें'; 
           }
            $response['requestKey'] = "adddoctor";
            echo json_encode($response);die;
        }

         if (empty($doctorData['password'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please enter Password';
             }else if($language_type=='hi'){
               $response['message'] = 'कृप्या पास्वर्ड भरो';  
             }
            $response['requestKey'] = "adddoctor";
            echo json_encode($response);die;
        }

         if (empty($confirm_pass)) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please enter Confirm Password';
             }else if($language_type=='hi'){
               $response['message'] = 'कृपया पासवर्ड की पुष्टि करें';  
             }
            $response['requestKey'] = "adddoctor";
            echo json_encode($response);die;
        }

         if ($confirm_pass!=$pass) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Password must be equal to Confirm Password';
             }else if($language_type=='hi'){
              $response['message'] = 'पासवर्ड की पुष्टि पासवर्ड के बराबर होनी चाहिए';  
             }
            $response['requestKey'] = "adddoctor";
            echo json_encode($response);die;
        }

         if (empty($this->input->post('dob'))) {

            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please select DOB';
             }else if($language_type=='hi'){
              $response['message']    = 'कृपया जन्म तिथि का चयन करें';  
             }
            $response['requestKey'] = "adddoctor";
            echo json_encode($response);die;
        }

        if (empty($this->input->post('address'))) {

            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please select address';
             }else if($language_type=='hi'){
              $response['message']    = 'कृपया पता चुनें';  
             }
            $response['requestKey'] = "adddoctor";
            echo json_encode($response);die;
        }

        $dob = date('Y-m-d',strtotime($this->input->post('dob')));
        $from = new DateTime($dob);
        $to   = new DateTime('today');
         $dobYears =  $from->diff($to)->y;
        // if($dobYears<=18)
        // {
        //   $response['status']     = "FAILURE";
        //     if($language_type=='en'){
        //     $response['message']    = 'DOB should be greater than 18 years';
        //      }else if($language_type=='hi'){
        //      $response['message']    = 'DOB की आयु 18 वर्ष से अधिक होनी चाहिए'; 
        //      }
        //     $response['requestKey'] = "adduser";
        //     echo json_encode($response);die;  
        // }


         if (empty($doctorData['address'])) {

            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please enter address';
             }else if($language_type=='hi'){
               $response['message']    = 'कृपया पता दर्ज करें';  
             }
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
     $result = $this->user_model->getCondResultArray(DOCTOR,'id,name,email,mobile,country_code,dob,gender,address,type,verify_status',array('id'=>$insert));
       if($result[0]['dob']=='0000-00-00')
             {
              $dob = "";
             }else
             {
             
               $dob =date('y-m-d',strtotime($result[0]['dob']));
             }
     if($insert)
     {
        $response['status']                   = "SUCCESS";
        if($language_type=='en'){
        $response['message']                  = 'Thank you for the registeration. You can now proceed further.';
         }else if($language_type=='hi'){
           $response['message']                  = 'पंजीकरण के लिए धन्यवाद। अब आप आगे बढ़ सकते हैं';  
         }
        $response['requestKey']               = "adddoctor";
        $response["adddoctor"]['doctor_id']    = $insert;
        $response["adddoctor"]['name']         = $result[0]['name'];
        $response["adddoctor"]['email']        = $result[0]['email'];
        $response["adddoctor"]['mobile']       = $result[0]['mobile'];
        $response["adduser"]['country_code']   = $result[0]['country_code'];
        $response["adddoctor"]['dob']          = $dob;
        $response["adddoctor"]['gender']       = $result[0]['gender'];
        $response["adddoctor"]['address']      = $result[0]['address'];
        $response["adddoctor"]['token']        =  $token;
        $response["adddoctor"]['login_type'] =  $result[0]['type'];
        $response["adddoctor"]['verify_status'] =  $result[0]['verify_status'];

         echo json_encode($response);die;
       
     }
 }
 elseif ($signup_type=='facebook') //facebook signup
 {
  
    $cond = array('social_token'=> $this->input->post('socialToken'),'type' =>$signup_type);
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
                    'status' => '1',
                    'verify_status' =>'0',
                    'notification_status' =>'on',
                    'device_type'  => $this->input->post('device_type'),
                    'device_token' => $this->input->post('device_token'),
                    'profile_status'=> '1', // 1 means profile is not created
                ];
             $insertid =   $this->my_model->insert_data(DOCTOR,$fbData);
            //// echo $this->db->last_query();
            // echo $insertid;die;
        // $getData =   $this->user_model->fieldCondRow(DOCTOR,'id,name,email,mobile,dob,gender,address,image,profile_status,token',array('id'=>$insertid));
$result = $this->user_model->getCondResultArray(DOCTOR,'id,name,email,mobile,country_code,dob,gender,address,image,profile_status,token,type,verify_status,digital_sign',array('id'=>$insertid));

//echo $this->db->last_query();die;
     
            $doctorRating =  $this->user_model->AvgRating('doctor_rating',array('doctor_id'=>$result[0]['id']));
            $doctorRate =  round($doctorRating->rate,1);
            if($doctorRate)
            {
              $rate = $doctorRate;
            }else{
              $rate = 5;
            }
            $response['status']                      = "SUCCESS";
            if($language_type=='en'){
            $response['message']                     = 'Doctor detail seen Successfully';
        }else if($language_type=='hi'){
            $response['message']                     = 'डॉक्टर विस्तार से देखा गया';
        }
            $response['requestKey']                  = "login";
            $response["fb_signup"]['id']             = $result[0]['id'];
            $response["fb_signup"]['name']           = $result[0]['name'];
            $response["fb_signup"]['email']          = $result[0]['email'];
            $response["fb_signup"]['mobile']         = $result[0]['mobile'];
            $response["fb_signup"]['country_code']   = $result[0]['country_code'];
            $response["fb_signup"]['dob']            = $result[0]['dob'];
            $response["fb_signup"]['gender']         = $result[0]['gender'];
            $response["fb_signup"]['address']        = $result[0]['address'];
            $response["fb_signup"]['image']          = $result[0]['image'];
            $response["fb_signup"]['signature']      = $result[0]['digital_sign'];
            $response["fb_signup"]['token']           =  $result[0]['token'];
            $response["fb_signup"]['profile_status'] =  $result[0]['profile_status'];
            $response["fb_signup"]['login_type']     =  $result[0]['type'];
            $response["fb_signup"]['verify_status']  =  $result[0]['verify_status'];

            $response["fb_signup"]['rating']         =  $rate;
         
             echo json_encode($response);die;
             //echo json_encode($response);die;
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
                    'status' => '1',
                    'verify_status'=> '0',
                     'notification_status' =>'on',
                    'device_type'  => $this->input->post('device_type'),
                    'device_token' => $this->input->post('device_token'),
                    'profile_status'=>'1',  // 1 means profile is not created
                ];


             $insertid =   $this->my_model->insert_data(DOCTOR,$googleData);
             //echo $this->db->last_query();die;
             $getData =   $this->user_model->fieldCondRow(DOCTOR,'id,name,email,type,token,mobile,country_code,image,digital_sign,verify_status',array('id'=>$insertid));
             if($language_type=='en'){
                $msg = 'doctor detail seen successfully.';
             }else if($language_type=='hi')
             {
               $msg = 'डॉक्टर विस्तार से देखा गया'; 
             }

             $response = ['google_signup' => $getData,'message'=>$msg, 'status' => "SUCCESS"];
             echo json_encode($response);die;
    }
      {
     
      //update remaining data start arr
    // $googleData1 =   array(
                    
    //                         'mobile'       => $this->input->post('mobile'),
    //                         'dob'          => date('Y-m-d',strtotime($this->input->post('dob'))),
    //                         'gender'       => $this->input->post('gender'),
    //                         'address'      => $this->input->post('address'),
                        
    //                         'status'       => '1',
    //                         'verify_status' => '0',    // 0 means not verified 
    //                         'created_date' => date('Y-m-d h:i:s'),
                      
    //                    );
     //$this->user_model->update_data(DOCTOR,$googleData1,array('id'=>$google_signup[0]['id']));
   
     $result = $this->user_model->getCondResultArray(DOCTOR,'id,name,email,digital_sign,mobile,country_code,dob,gender,address,image,profile_status,token,type,verify_status',array('id'=>$google_signup[0]['id']));
     
            $doctorRating =  $this->user_model->AvgRating('doctor_rating',array('doctor_id'=>$result[0]['id']));
            $doctorRate =  round($doctorRating->rate,1);
            if($doctorRate)
            {
              $rate = $doctorRate;
            }else{
              $rate = 5;
            }

            if($language_type=='en'){
                $msg = 'doctor detail seen successfully.';
             }else if($language_type=='hi')
             {
               $msg = 'डॉक्टर विस्तार से देखा गया'; 
             }
            $response['status']                          = "SUCCESS";
            $response['message']                         = $msg;
            $response['requestKey']                      = "login";
            $response["google_signup"]['id']             = $result[0]['id'];
            $response["google_signup"]['name']           = $result[0]['name'];
            $response["google_signup"]['email']          = $result[0]['email'];
            $response["google_signup"]['mobile']         = $result[0]['mobile'];
            $response["google_signup"]['country_code']   = $result[0]['country_code'];
            $response["google_signup"]['dob']            = $result[0]['dob'];
            $response["google_signup"]['gender']         = $result[0]['gender'];
            $response["google_signup"]['address']        = $result[0]['address'];
            $response["google_signup"]['image']          = $result[0]['image'];
            $response["google_signup"]['signature']      = $result[0]['digital_sign'];
            $response["google_signup"]['token']          =  $result[0]['token'];
            $response["google_signup"]['profile_status'] =  $result[0]['profile_status'];
           $response["google_signup"]['verify_status']   =  $result[0]['verify_status'];

            $response["google_signup"]['login_type']     =  $result[0]['type'];
            $response["google_signup"]['rating']         =  $rate;
             echo json_encode($response);die;
    }
 }

}
else
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
      $language_type = $this->input->post('language_type');
      $checkEmail  =    $this->user_model->getCondResult(DOCTOR,'id',array('email'=>$email));
      $checkMobile  =    $this->user_model->getCondResult(DOCTOR,'id',array('mobile'=>$mobile));

     // $userEmail  =    $this->user_model->getCondResult(USER,'id',array('email'=>$email));
      //$userMobile  =    $this->user_model->getCondResult(USER,'id',array('mobile'=>$mobile));
    
     
     
      if($checkEmail)
      {
      
         $response['status']  = "FAILURE";
         if($language_type=='en'){
         $response['message'] = 'Email Id already exists.';
          }else if($language_type=='hi'){
           $response['message'] = 'ईमेल आईडी पहले से मौजूद है।'; 
          }
         $response['requestKey'] = "checkEmail";
         echo json_encode($response);die;
      }else
      {
         
      if($checkMobile)
      {
         $response['status']  = "FAILURE";
         if($language_type=='en'){
         $response['message'] = 'Mobile Number already exists.';
          }else if($language_type=='hi'){
            $response['message'] = 'मोबाइल नंबर पहले से मौजूद है'; 
          }
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
      $device_type =  $this->input->post('device_type');
      $device_token =  $this->input->post('device_token');
     
      
      $checkSocialToken  =  $this->user_model->getCondResult(DOCTOR,'id,name,email,type,token,mobile,country_code,image,dob,gender,digital_sign,address,profile_status,verify_status,available_status',array('social_token'=>$token));
     $doctorRating =  $this->user_model->AvgRating('doctor_rating',array('doctor_id'=>$checkSocialToken[0]->id));
     $doctorRate =  round($doctorRating->rate,1);
     if($doctorRate){
      $rate = $doctorRate;
     }else{
      $rate = 5;
     }
     $tkn = $this->user_model->getToken();  
     $this->user_model->update_data(DOCTOR,array('token'=>$tkn,'device_type'=>$device_type,'device_token'=>$device_token),array('id'=>$checkSocialToken[0]->id));
      $notificationCount = count($this->user_model->resultArrayNull('notification','id',array('doctor_id'=>$checkSocialToken[0]->id,'status'=>'0','badge_count'=>'1','send_to'=>'doctor','type !='=>'adminChatDoctor')));
     
      if($checkSocialToken)
      {

         $response['status']  = "FAILURE";
         $response['message'] = 'Social Token already exists.';
        // $response['requestKey'] = "checkEmail";

            $response["doctorDetail"]['id']                 = $checkSocialToken[0]->id;
            $response["doctorDetail"]['name']               = $checkSocialToken[0]->name;
            $response["doctorDetail"]['email']              = $checkSocialToken[0]->email;
            $response["doctorDetail"]['mobile']             = $checkSocialToken[0]->mobile;
             $response["doctorDetail"]['country_code']      = $checkSocialToken[0]->country_code;
            $response["doctorDetail"]['dob']                = $checkSocialToken[0]->dob;
            $response["doctorDetail"]['image']              = $checkSocialToken[0]->image;
            $response["doctorDetail"]['signature']          = $checkSocialToken[0]->digital_sign;
            
            $response["doctorDetail"]['gender']             = $checkSocialToken[0]->gender;
            $response["doctorDetail"]['address']            = $checkSocialToken[0]->address;
            $response["doctorDetail"]['token']              = $tkn;
            $response["doctorDetail"]['profile_status']     = $checkSocialToken[0]->profile_status;
            $response["doctorDetail"]['verify_status']      = $checkSocialToken[0]->verify_status;
            $response["doctorDetail"]['available_status']   = $checkSocialToken[0]->available_status;

            $response["doctorDetail"]['login_type']         = $checkSocialToken[0]->type;
            $response["doctorDetail"]['rating']             = $rate;
            $response["doctorDetail"]['badge_count']        = $notificationCount;

         echo json_encode($response);
      }
      else
      {
         $response['status']  = "SUCCESS";
         $response['message'] = 'Does not exists.';
         $response["doctorDetail"]['profile_status']     = '1';
         $response["doctorDetail"]['verify_status']      = '0';
         //$response['requestKey'] = "checkMobile";
         echo json_encode($response);
      }
      

      
   }



   function addProfessionalDetail()
   {
       
       if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        //$token     = $this->input->post('token');
        $id     = $this->input->post('id');
        $language_type = $this->input->post('language_type');
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

            $url = "images/" . $filename;

            move_uploaded_file($_FILES["document_image"]["tmp_name"], $url);
            $data['image'] = $filename;
            $image = base_url('images/').$filename;
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
     

         
        if($this->input->post('home_visit_type')=='1')    // 1 for yes  
        {
            $homestatus = "yes";
            $homeFrees = $this->user_model->fetchValue('doctor_fees','frees',array('status'=>'1'));
        }else
        {
            $homestatus = "no";
        }

         if($this->input->post('call_visit_type')=='1')  // 1 for no
        {
            $callStatus = "yes";
            $callFrees = $this->user_model->fetchValue('doctor_fees','call_fees',array('status'=>'1'));
        }else
        {
            $callStatus = "no";
        }
           $createProfile = array(

                             'specialty'        => $this->input->post('specialty'),
                             'license_no'       => $this->input->post('license_no'),
                           //  'document'         => $document,
                             'experience'       => $this->input->post('exp'),
                             'month'           => trim($this->input->post('month')),
                            'qualification'     => $this->input->post('qualification'),
                             'frees'            => $homeFrees, //home feess
                             'call_fees'        => $callFrees,  //call fees
                             'clinic_name'      => $this->input->post('clinic_name'),
                             'home_visit_type'  => $homestatus,
                             'home_visit_days'  => $this->input->post('home_visit_days'),
                             'call_visit_type'  => $callStatus,
                             'call_visit_days'  => $this->input->post('call_visit_days'),
                         //    'city_operation'   => $this->input->post('city_operation'),
                             'distance'         => $this->input->post('distance'),
                             'country_id'       => $this->input->post('country_id'),
                             'state_id'         =>  $this->input->post('state_id'),
                             'city_id'          =>  $this->input->post('city_id'),
                            // 'profile_status'   => '1' , // means profile is not created .
                            // 'eta_time'         => '25-35'
                           // 'digital_sign'     => $signature_file,
                            
                        );
                        
          if (empty($createProfile['specialty'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please select Speciality';
             }else if($language_type=='hi'){
               $response['message'] = 'कृपया स्पेशलिटी का चयन करें';  
             }
            echo json_encode($response);die;
        } 
        
         if (empty($createProfile['license_no'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please enter license ';
             }else if($language_type=='hi'){
               $response['message'] = 'कृपया लाइसेंस दर्ज करें ';  
             }
            echo json_encode($response);die;
        } 
        
         if (empty($createProfile['experience'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please select experience';
             }else if($language_type=='hi'){
               $response['message'] = 'कृपया अनुभव का चयन करें';  
             }
            echo json_encode($response);die;
        } 
        
         if (empty($createProfile['qualification'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please select qualification';
             }else if($language_type=='hi'){
               $response['message'] = 'कृपया योग्यता चुनें';   
             }
            echo json_encode($response);die;
        } 
        
        //  if (empty($createProfile['clinic_name'])) {
        //     $response['status']  = "FAILURE";
        //     $response['message'] = 'Please enter hospital/clinic name';
        //     echo json_encode($response);die;
        // } 
        
         if (empty($createProfile['home_visit_type'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please select home visit type';
             }else if($language_type=='hi'){
               $response['message'] = 'कृपया  होम विज़िट प्रकार चुनें';  
             }
            echo json_encode($response);die;
        } 
        
         if (empty($createProfile['call_visit_type'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please select home call type';
             }else if($language_type=='hi'){
                $response['message'] = 'कृपया  कॉल प्रकार चुनें'; 
             }
            echo json_encode($response);die;
        } 
        
         if (empty($createProfile['country_id'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please select country name';
             }else if($language_type=='hi'){
             $response['message'] = 'कृपया देश का नाम चुनें';   
             }
            echo json_encode($response);die;
        } 
        
         if (empty($createProfile['state_id'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please select state name';
             }else if($language_type=='hi'){
              $response['message'] = 'कृपया राज्य का नाम चुनें';  
             }
            echo json_encode($response);die;
        } 
        
         if (empty($createProfile['city_id'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please select city name';
             }else if($language_type=='hi'){
              $response['message'] = 'कृपया शहर का नाम चुनें';   
             }
            echo json_encode($response);die;
        } 
                
           $finalArr = array_merge($createProfile,$imgArr1,$imgArr2,$imgArr);
         // echo "<pre>";
          // print_r($createProfile);die;
           $this->user_model->update_data(DOCTOR,$finalArr,array('id'=>$result[0]['id']));
        $profileDetail = $this->user_model->getCondResultArray(DOCTOR,'id,specialty,license_no,document,experience,month,clinic_name,home_visit_type,home_visit_days,call_visit_type,call_visit_days,distance,digital_sign,qualification,frees,image,country_id,state_id,city_id',array('id'=>$id));
      $country_name =  $this->user_model->fieldCondRow('countries','name',array('id'=>$profileDetail[0]['country_id']));
      $state_name =  $this->user_model->fieldCondRow('states','name',array('id'=>$profileDetail[0]['state_id']));
      $city_name =  $this->user_model->fieldCondRow('cities','name',array('id'=>$profileDetail[0]['city_id']));
      $specialtyName =  $this->user_model->fieldCondRow('specility','name,hi_name',array('id'=>$profileDetail[0]['specialty']));
     if($language_type=='en'){
        $speName = $specialtyName->name;
     }else if($language_type=='hi'){
       $speName = $specialtyName->hi_name; 
     }
     $ProfileDetails = array(
                               'id'                 => $profileDetail[0]['id'],
                               'specialty'          => $speName,
                               'license_no'         => $profileDetail[0]['license_no'],
                                'document'          => $profileDetail[0]['document'],
                                'experience'        => $profileDetail[0]['experience'],
                                'month'             => trim($profileDetail[0]['month']),
                                'clinic_name'       => $profileDetail[0]['clinic_name'],
                                'home_visit_type'   => $profileDetail[0]['home_visit_type'],
                                'home_visit_days'   => $profileDetail[0]['home_visit_days'],
                                'call_visit_type'   => $profileDetail[0]['call_visit_type'],
                                'call_visit_days'   => $profileDetail[0]['call_visit_days'],
                                'distance'          => $profileDetail[0]['distance'],
                                'digital_sign'      => $profileDetail[0]['digital_sign'],
                                'qualification'     => $profileDetail[0]['qualification'],
                                'frees'             => $profileDetail[0]['frees'],
                                'image'             => $profileDetail[0]['image'],
                                'country_id'        => $profileDetail[0]['country_id'],
                                'state_id'          => $profileDetail[0]['state_id'],
                                'city_id'           => $profileDetail[0]['city_id'],
                                'country_name'      =>$country_name->name,
                                'state_name'        =>$state_name->name,
                                'city_name'         =>$city_name->name,



                            );
           $response['status']              = "SUCCESS";
           $response['profileDetail']       = $ProfileDetails;
           if($language_type=='en'){
           $response['message']             = 'doctor profile created Successfully';
            }else if($language_type=='hi'){
             $response['message']             = 'डॉक्टर प्रोफाइल सफलतापूर्वक बनाया गया';   
            }
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
        $language_type = $this->input->post('language_type');
         if (empty($id)) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Id is empty';
            $response['requestKey'] = "addBank";
            echo json_encode($response);die;
        }
        $result = $this->user_model->getCondResultArray(DOCTOR,'id',array('id'=>$id));
     //  echo $doctor_id = $result[0]['id'];die;
        if($result)
        {
          $bankData = array(
                             'doctor_id'       => $id,
                             'bank_name'        => $this->input->post('bank_name'),
                             'ac_holder'       => $this->input->post('ac_holder_name'),
                             'account_no'         => $this->input->post('account_no'),
                             'ifsc_code'      => $this->input->post('ifsc_code'),
                             'status'       => '1',
                             'created_date' =>date('Y-m-d h:i:s'),

                        );
                        
         if (empty($bankData['bank_name'])) {

            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please enter Bank Name';
             }else if($language_type=='hi'){
               $response['message']    = 'कृपया बैंक का नाम दर्ज करें';  
             }
            $response['requestKey'] = "addBank";
            echo json_encode($response);die;
        }     
        
          if (empty($bankData['account_no'])) {

            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please enter Account Holder Name';
             }else if($language_type=='hi'){
              $response['message']    = 'कृपया खाता धारक का नाम दर्ज करें';   
             }
            $response['requestKey'] = "addBank";
            echo json_encode($response);die;
        }    
        
         if (empty($bankData['account_no'])) {

            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please enter Account No';
             }else if($language_type=='hi'){
               $response['message']    = 'कृपया खाता संख्या दर्ज करें';  
             }
           $response['requestKey'] = "addBank";
            echo json_encode($response);die;
        }    


           $insertBank =$this->my_model->insert_data(BANK,$bankData);
           //echo $this->db->last_query();
           if($insertBank){
           $this->user_model->update_data(DOCTOR,array('profile_status'=>'0'),array('id'=>$result[0]['id']));  // 0 means pfile is created
           //echo $this->db->last_query();die;
           $response['status']              = "SUCCESS";
           if($language_type=='en'){
           $response['message']             = 'Bank added Successfully';
            }else if($language_type=='hi'){
              $response['message']             = 'बैंक ने सफलतापूर्वक जोड़ा ';   
            }
           $response['requestKey']          = "addbank";
          
         echo json_encode($response);die;}
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
     $language_type = $this->input->post('language_type');
     // $token     = $this->input->post('token');
         if (empty($token)) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Token is empty';
            $response['requestKey'] = "personalDetail";
            echo json_encode($response);die;
        }
     $checkToken = $this->user_model->getCondResultArray(DOCTOR,'id,name,email,mobile,country_code,dob,gender,address,image',array('token'=>$token));
     $doctor_id = $checkToken[0]['id'];
     if($checkToken)
     {
             if($checkToken[0]['dob']=='0000-00-00')
             {
              $dob = "";
             }else
             {
             
               $dob = date('d-m-Y',strtotime($checkToken[0]['dob']));
             }
            $response['status']                   = "SUCCESS";
            if($language_type=='en'){
            $response['message']                  = 'Doctor personal detail seen successfully. ';
             }else if($language_type=='hi'){
             $response['message']                  = 'डॉक्टर व्यक्तिगत विवरण सफलतापूर्वक देखा गया। ';   
             }
            $response['requestKey']               = "personalDetail ";
            $response["personalDetail"]['id']           = $checkToken[0]['id'];
            $response["personalDetail"]['name']         = $checkToken[0]['name'];
            $response["personalDetail"]['email']        = $checkToken[0]['email'];
            $response["personalDetail"]['mobile']       = $checkToken[0]['mobile'];
            $response["personalDetail"]['country_code'] = $checkToken[0]['country_code'];
            $response["personalDetail"]['dob']          = $dob;
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
     $language_type = $this->input->post('language_type');
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
        
     $address = $this->input->post('address');
      if(!empty($address))
      {
      $res = $this->user_model->getLatLong($address);
      $latitude =  $res['latitude'];
      $longitude =  $res['longitude'];
      }
     $personalData = array(
                             'name'         => $this->input->post('name'),
                             'email'        => $this->input->post('email'),
                             'mobile'       => $this->input->post('mobile'),
                             'country_code' =>  $this->input->post('country_code'),
                             'dob'          => date('Y-m-d',strtotime($this->input->post('dob'))),
                             'gender'       => $this->input->post('gender'),
                             'address'       => $this->input->post('address'),
                             'latitude'     => $latitude,
                             'longitude'     => $longitude,
                             //'image'        => $profile_image,
                             'updated_date'  => date('Y-m-d h:i:s'),
                      
                         );
     $finalArr = array_merge($personalData,$imgArr);

      if (empty($personalData['name'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please enter Name';
             }else if($language_type=='hi'){
               $response['message'] = 'कृपया नाम दर्ज करें';  
             }
            echo json_encode($response);die;
        }

        if (empty($personalData['email'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please enter Email';
             }else if($language_type=='hi'){
             $response['message'] = 'कृपया ईमेल दर्ज करें';   
             }
            echo json_encode($response);die;
        }

         if (empty($personalData['mobile'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please enter Mobile';
        }else if($language_type=='hi'){
          $response['message'] = 'कृपया मोबाइल दर्ज करें';  
        }
            echo json_encode($response);die;
        }

         if (empty($personalData['gender'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please select Gender';
        }else if($language_type=='hi'){
         $response['message'] = 'कृपया लिंग चुनें';   
        }
            echo json_encode($response);die;
        }

        if (empty($this->input->post('dob'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please select DOB';
             }else if($language_type=='hi'){
             $response['message'] = 'कृपया जन्म तिथि का चयन करें';   
             }
            echo json_encode($response);die;
        }
    $update =  $this->user_model->update_data(DOCTOR,$finalArr,array('id'=>$doctor_id));
    $doctorData = $this->user_model->getCondResultArray(DOCTOR,'id,name,email,mobile,country_code,dob,gender,address,image',array('id'=>$doctor_id));
    if($update)
    {
            $response['status']                         = "SUCCESS";
            if($language_type=='en'){
            $response['message']                        = 'personal detail updated successfully.';
             }else if($language_type=='hi'){
               $response['message']                        = 'डॉक्टर पेशेवर विवरण सफलतापूर्वक देखे गए हैं';  
             }
            $response['requestKey']                     = "updatePersonalDetail";
            $response["personalDetail"]['id']           = $doctorData[0]['id'];
            $response["personalDetail"]['name']         = $doctorData[0]['name'];
            $response["personalDetail"]['email']        = $personalData['email'];
            $response["personalDetail"]['mobile']       = $doctorData[0]['mobile'];
            $response["personalDetail"]['country_code'] = $doctorData[0]['country_code'];
            $response["personalDetail"]['dob']          = date('d-m-Y',strtotime($doctorData[0]['dob']));
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
     $language_type = $this->input->post('language_type');
     $checkToken = $this->user_model->getCondResultArray(DOCTOR,'id,specialty,license_no,document,experience,month,clinic_name,home_visit_type,home_visit_days,call_visit_type,call_visit_days,distance,digital_sign,qualification,frees,image,country_id,state_id,city_id',array('token'=>$token));
     $doctor_id = $checkToken[0]['id'];
     $country_name =  $this->user_model->getCondResult('countries','name',array('id'=>$checkToken[0]['country_id']));
     $state_name =  $this->user_model->getCondResult('states','name',array('id'=>$checkToken[0]['state_id']));
     $city_name =  $this->user_model->getCondResult('cities','name',array('id'=>$checkToken[0]['city_id']));
     $specialtyName =  $this->user_model->fieldCondRow('specility','name,hi_name',array('id'=>$checkToken[0]['specialty']));
     if($language_type=='en'){
        $speName = $specialtyName->name;
     }else if($language_type=='hi'){
       $speName = $specialtyName->hi_name; 
     }
     if($checkToken)
     {
            $response['status']                                  = "SUCCESS";
            if($language_type=='en'){
            $response['message']                                 = 'Doctor perofessional detail seen successfully. ';
             }else if($language_type=='hi'){
               $response['message']                                 = 'क्रमिक विस्तार से सफलतापूर्वक अपडेट किया गया। ';  
             }
            $response['requestKey']                              = "professionalDetail ";
            $response["professionalDetail"]['id']                = $checkToken[0]['id'];
            $response["professionalDetail"]['specialty']         = $speName;   //////////////
            $response["professionalDetail"]['license_no']        = $checkToken[0]['license_no'];
            $response["professionalDetail"]['document']          = $checkToken[0]['document'];
            $response["professionalDetail"]['experience']              = $checkToken[0]['experience'];
             $response["professionalDetail"]['month']            = trim($checkToken[0]['month']);
            $response["professionalDetail"]['qualification']     = $checkToken[0]['qualification'];
            $response["professionalDetail"]['frees']             = $checkToken[0]['frees'];
            $response["professionalDetail"]['clinic_name']       = $checkToken[0]['clinic_name'];
            $response["professionalDetail"]['home_visit_type']   = $checkToken[0]['home_visit_type'];
            $response["professionalDetail"]['home_visit_days']   = $checkToken[0]['home_visit_days'];
            $response["professionalDetail"]['call_visit_type']   = $checkToken[0]['call_visit_type'];
            $response["professionalDetail"]['call_visit_days']   = $checkToken[0]['call_visit_days'];
            //$response["professionalDetail"]['city_operation']    = $checkToken[0]['city_operation'];
            $response["professionalDetail"]['country_name']      = $country_name[0]->name;
            $response["professionalDetail"]['state_name']        = $state_name[0]->name;
            $response["professionalDetail"]['city_name']         = $city_name[0]->name;
            
             $response["professionalDetail"]['country_id']      = $checkToken[0]['country_id'];
            $response["professionalDetail"]['state_id']        = $checkToken[0]['state_id'];
            $response["professionalDetail"]['city_id']         = $checkToken[0]['city_id'];
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
        $language_type = $this->input->post('language_type');
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
           if($language_type=='en'){
           $response['message']             = 'perofessional detail updated successfully.';
            }else if($language_type=='hi'){
             $response['message']             = 'डॉक्टर बैंक विवरण सफलतापूर्वक देखा गया।';   
            }
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
     $language_type = $this->input->post('language_type');

      if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

     $checkToken = $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));
     $doctor_id = $checkToken[0]['id'];
     $bankDetail = $this->user_model->getCondResultArray(BANK,'bank_name,account_no,ac_holder,ifsc_code',array('doctor_id'=>$doctor_id));
     if($checkToken)
     {
            $response['status']                      = "SUCCESS";
            if($language_type=='en'){
            $response['message']                     = 'Doctor Bank detail seen successfully. ';
             }else if($language_type=='hi'){
              $response['message']                     = 'डॉक्टर बैंक विवरण सफलतापूर्वक देखा गया।';  
             }
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
        $language_type = $this->input->post('language_type');
        if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }
        $result = $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));
        $doctor_id = $result[0]['id'];
        if($result)
        {
          $bankData = array(
                             //'doctor_id'        => $doctor_id,
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
           if($language_type=='en'){
           $response['message']             = 'Bank detail updated Successfully';
            }else if($language_type=='hi'){
              $response['message']             = 'बैंक विवरण सफलतापूर्वक अपडेट किया गया';   
            }
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
      $language_type = $this->input->post('language_type');

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
            if($language_type=='en'){
            $response['message'] = 'Please enter current password';
             }else if($language_type=='hi'){
               $response['message'] = 'कृपया वर्तमान पासवर्ड दर्ज करें';  
             }
            $response['requestKey'] = "changePassword";
            echo json_encode($response);die;
        }

   if (empty($newpass)) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please enter new password';
             }else if($language_type=='hi'){
              $response['message'] = 'कृपया नया पासवर्ड दर्ज करें ';   
             }
            $response['requestKey'] = "changePassword";
            echo json_encode($response);die;
        }

        if (empty($conpass)) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please enter confirm password';
             }else if($language_type=='hi'){
               $response['message'] = 'कृपया पुष्टि पासवर्ड दर्ज करें';  
             }
            $response['requestKey'] = "changePassword";
            echo json_encode($response);die;
        }

   
    if($newpass != $conpass)    
    { 
               $response['status']     = "FAILURE";
               if($language_type=='en'){
                $response['message']    = 'New Password and Confirm Password does not match';
                 }else if($language_type=='hi'){
                 $response['message']    = 'नया पासवर्ड और कन्फर्म पासवर्ड मेल नहीं खाते हैं';   
                 }
                $response['requestKey'] = "changePassword";
                echo json_encode($response);die;
          
    }

      if($oldpass==$newpass)    
    { 
               $response['status']     = "FAILURE";
               if($language_type=='en'){
                $response['message']    = "New password should not be equal to current password";
                 }else if($language_type=='hi'){
                   $response['message']    = "नया पासवर्ड वर्तमान पासवर्ड के बराबर नहीं होना चाहिए"; 
                 }
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
                    if($language_type=='en'){
                    $response['message']    = 'Password changed successfully';
                     }else if($language_type=='hi'){
                      $response['message']    = 'पासवर्ड सफलतापूर्वक बदला गया';  
                     }
                    $response['requestKey'] = "changePassword";

                    echo json_encode($response);
                    die;
   }

 }
 else
 {
            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Current Password is incorrect';
             }else if($language_type=='hi'){
               $response['message']    = 'मौजूदा पासवर्ड गलत है';  
             }
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
    $language_type = $this->input->post('language_type');
    $con =array('mobile'=>$mobile );
    $fields = "id,name,email";
    $user=$this->my_model->getfields(DOCTOR,$fields,$con);
 
  
  if(!empty($user)){
   $name         = ucfirst($user[0]->name);
   $email        = $user[0]->email;
  
   $otp = rand(1000, 9999);
 
   $this->my_model->update_data(DOCTOR,array('mobile' =>$mobile),array('confirm_code'=>$otp));
   
  
    
      // $getResponse = file_get_contents("https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=K0IbqH3mHE2PAyuTBlUipA&senderid=EDUIAP&channel=2&DCS=0&flashsms=0&number=" . $mobile . "&text=Your%20verification%20code%20is%20" . $otp . ".&route=13");
    
          $success  = "Mobile no is  registered.";
          $response = ['message' => $success, 'status' => "SUCCESS"];
    
    }
    else{
            if($language_type=='en'){
            $errors = "Mobile no is not registered.";
             }else if($language_type=='hi'){
              $errors = "मोबाइल नंबर पंजीकृत नहीं है";  
             }
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
  $mobile = $this->input->post('mobile');
  $language_type = $this->input->post('language_type');
   if (empty($mobile)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Please enter mobile no';
            $response['requestKey'] = "updatepassword";
            echo json_encode($response);die;
        }

  // $checkOtpToken = $this->user_model->getCondResultArray(DOCTOR,'id',array('confirm_code'=>$otp));
  // if($checkOtpToken){

 
   if (empty($newpass)) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please enter New Password';
             }else if($language_type=='hi'){
              $response['message'] = 'कृपया नया पासवर्ड दर्ज करें';  
             }
            $response['requestKey'] = "updatepassword";
            echo json_encode($response);die;
        }

        if (empty($conpass)) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please enter Confirm Password';
             }else if($language_type=='hi'){
              $response['message'] = 'कृपया पासवर्ड की पुष्टि करें';   
             }
            $response['requestKey'] = "updatepassword";
            echo json_encode($response);die;
        }

   
    if($newpass != $conpass)    
    { 
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'New password must be equal to confirm password';
             }else if($language_type=='hi'){
             $response['message'] = 'नया पासवर्ड पासवर्ड की पुष्टि करने के लिए बराबर होना चाहिए';   
             }
            $response['requestKey'] = "updatepassword";
            echo json_encode($response);die;
          
    }

    
    $new_pass=md5($newpass);
    $con_pass=md5($conpass);

    
      $con=array("mobile"=>$mobile);
      $updatedata=array("password"=>$new_pass);
     
      $update=$this->my_model->update_data(DOCTOR,$con,$updatedata);
      if($update) {
          if($language_type=='en'){
          $success = "Password Updated successfully";
           }else if($language_type=='hi'){
            $success = "पासवर्ड सफलतापूर्वक अपडेट किया गया";
           }
          $response = ['message' => $success, 'status' => "SUCCESS"];
           echo json_encode($response);die;
   }

 // }
 // else
 // {
 //            $response['status']     = "FAILURE";
 //            $response['message']    = 'token mismatch ...Please logOut.';
 //            $response['requestKey'] = "updatepassword";

 //            echo json_encode($response);
 // }
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
       $language_type = $this->input->post('language_type');

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
            if($language_type=='en'){
            $response['message']    = 'status change successfully.';
             }else if($language_type=='hi'){
              $response['message']    = 'स्थिति सफलतापूर्वक बदल जाती है।';  
             }
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
      $language_type = $this->input->post('language_type'); 

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
    $query = "SELECT u.name,u.email,u.mobile,b.id,b.created_date,b.address,b.address_type,b.booking_type,b.schedule_time,b.schedule_date,b.session_status,b.user_id,b.reason_visit,b.member_name,b.member_id,b.end_session_date   FROM `doctor_booking` as b INNER JOIN doctor_user as u on b.user_id=u.id  WHERE doctor_id = '".$id."' and booking_status = '".$booking_status."' order by b.id DESC"   ;
    $result = $this->db->query($query)->result_array(); 
    //echo $this->db->last_query();die;
    if($result){
      foreach($result as $past)
      {

        $pastArr[] = array(
                          'name'             => $past['name'],
                          'email'            => $past['email'],
                          'mobile'           => $past['mobile'],
                          'id'               => $past['id'],
                          'created_date'    => date('d-m-Y h:i A',strtotime($past['created_date'])),
                          'address'         => $past['address'],
                          'address_type'    => $past['address_type'],
                          'booking_type'    => $past['booking_type'],
                          'schedule_time'   => date('h:i A',strtotime($past['end_session_date'])),
                          'schedule_date'   => date('d-m-Y',strtotime($past['end_session_date'])),
                          'session_status'  => $past['session_status'],
                          'user_id'         => $past['user_id'],
                          'reason_visit'    => $past['reason_visit'],
                          'member_name'     => $past['member_name'],
                          'member_id'       => $past['member_id'],
                         


                           );
      }
     // echo "<pre>";
      //print_r($pastArr);die;
      if($language_type=='en'){
        $msg = 'past Booking seen successfully.';
      }else if($language_type=='hi'){
        $msg= 'past Booking seen successfully.';
      }
    $response = ['status' => "SUCCESS",'message'=>$msg,'pastbooking' => $pastArr];
    echo json_encode($response);die;
 }
 else{
       $response['status']     = "SUCCESS";
       if($language_type=='en'){
       $response['message']    = 'No past booking record found.';
        }else if($language_type=='hi'){
           $response['message']    = 'कोई पिछला बुकिंग रिकॉर्ड नहीं मिला।';   
        }
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
     $language_type = $this->input->post('language_type'); 
      

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
$query = "SELECT u.id,u.name,u.email,u.mobile,b.id,b.created_date,b.address,b.address_type,b.booking_type,b.schedule_time,b.schedule_date,b.session_status,b.user_id,b.reason_visit,b.member_name,b.member_id,s.past_history,b.booking_latitude,b.booking_longitude FROM `doctor_booking` as b INNER JOIN doctor_user as u on b.user_id=u.id LEFT JOIN `doctor_session` as s on s.booking_id = b.id WHERE b.doctor_id = '".$id."' and booking_status = '".$booking_status."' order by b.id DESC"   ;
    $result = $this->db->query($query)->result_array(); 


    if($result){

       foreach($result as $past)
      {
         $userid       = $past['user_id'];
          $memberid    = $past['member_id'];
           $membername = $past['member_name'];
           if($membername=='')
           {
            $userid = $userid;
            $type = "user";
           }
           else {
            $userid = $memberid;
            $type = "member";
           }
       $pastHis= $this->db->query("select past_history from doctor_session where user_id =$userid and user_type = '".$type."' order by id DESC limit 1")->row();
      // echo $this->db->last_query();
      // print_r($pastHis);die;
       $pastHistory = $pastHis->past_history;
        $upcomingArr[] = array(
                         // 'userid'=> $past['id'],
                          'name'             => $past['name'],
                          'email'            => $past['email'],
                          'mobile'           => $past['mobile'],
                          'id'               => $past['id'],
                          'created_date'     => date('d-m-Y h:i A',strtotime($past['created_date'])),
                          'address'          => $past['address'],
                          'address_type'     => $past['address_type'],
                          'booking_type'     => $past['booking_type'],
                          'schedule_time'    => date('h:i A',strtotime($past['schedule_time'])),
                          'schedule_date'    => date('d-m-Y',strtotime($past['schedule_date'])),
                          'session_status'   => $past['session_status'],
                          'user_id'          => $past['user_id'],
                          'reason_visit'     => $past['reason_visit'],
                          'member_name'      => $past['member_name'],
                          'member_id'        => $past['member_id'],
                          'past_history'     => $pastHistory,
                          'latitude'         => $past['booking_latitude'],
                          'longitude'        => $past['booking_longitude'],
                         


                           );
      }
   if($language_type=='en'){
    $msg = 'Upcoming Booking successfully';
   }else if($language_type=='hi'){
    $msg = 'आगामी बुकिंग सफलतापूर्वक';
   }

    $response = ['status' => "SUCCESS",'message'=>$msg,'upcomingBookingList' => $upcomingArr];
    echo json_encode($response);die;
 }
 else{
       $response['status']     = "SUCCESS";
       if($language_type=='en'){
       $response['message']    = 'No upcoming booking record found.';
        }else if($language_type=='hi'){
         $response['message']    = 'कोई आगामी बुकिंग रिकॉर्ड नहीं मिला।';    
        }
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
       $language_type = $this->input->post('language_type'); 
       
       $userTokenCheck =   $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));
       // if($result)
        if($userTokenCheck) {
        $userLogout = $this->user_model->update_data(DOCTOR,array('token'=>'','login_status'=>'0','device_token'=>''),array('id'=>$userTokenCheck[0]['id']));
    
            if($userLogout) {
                if($language_type=='en'){
                $response = ['message' => "Logout successfully", 'status' => "SUCCESS"];
                 }else if($language_type=='hi'){
                   $response = ['message' => "सफलतापूर्वक लॉग आउट किया गया", 'status' => "SUCCESS"]; 
                 }
     
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
      $language_type = $this->input->post('language_type'); 
     

     if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

     $checkToken =   $this->user_model->getCondResultArray(DOCTOR,'id,name,latitude,longitude',array('token'=>$token));
     $id = $checkToken[0]['id'];
     $doctorName = $checkToken[0]['name'];
     $dotorLat   = $checkToken[0]['latitude'];
     $dotorLong  = $checkToken[0]['longitude'];

    if($checkToken)
    {

      $bookingDetails = $this->user_model->getCondResultArray(BOOKING,'user_id,booking_latitude,booking_longitude',array('id'=>$booking_id)); 
      $userId =  $bookingDetails[0]['user_id']; 
      $userLat = $bookingDetails[0]['booking_latitude']; 
      $userLong = $bookingDetails[0]['booking_longitude']; 
      $userDetails = $this->user_model->getCondResultArray(USER,'device_token,device_type,language_type',array('id'=>$userId));
      $device_type = $userDetails[0]['device_type'];
      $device_token = $userDetails[0]['device_token']; 
      $language_type1 = $userDetails[0]['language_type']; 
         
     if($status=='1')  //for accept
     {

       //tracking doctor start
      $checkTraking =  $this->user_model->getCondResultArray('doctor_tracking','id',array('booking_id'=>$booking_id)); 
      if(empty($checkTraking)){
         $trackingData = array(
                               'user_id'      => $userId,
                               'doctor_id'    => $id,
                               'booking_id'   => $booking_id,
                               'user_lat'     => $userLat,
                               'user_long'    => $userLong,
                               'doctor_lat'   => $dotorLat,
                               'doctor_long'  => $dotorLong,
                               'status'       => '0',
                               'created_date' => date('Y-m-d h:i:s'),
                              );
        $this->user_model->insert_data('doctor_tracking',$trackingData);
      }else
      {
       $this->user_model->update_data('doctor_tracking',$trackingData,array('id'=>$checkTraking[0]['id']));
      }
      //tracking doctor end
      if($language_type=='en'){
        $msg = "Booking Accepted successfully.";
         }else if($language_type=='hi'){
          $msg = "बुकिंग सफलतापूर्वक स्वीकार की गई।";  
         }
         $data = array('booking_status'=>$status,'updated_date'=>date('Y-m-d H:i:s'));

        //send notification start
     $checkNotificationStatus = $this->user_model->fetchValue(USER,'notification_status',array('id'=>$userId)); //notification send when status is on
      
      if($checkNotificationStatus=="on"){ 
        if($language_type1=='en'){
        $message = "Your Booking Request has been confirmed, Please proceed with the Payment";
        $title = "Your Booking Request has been confirmed, Please proceed with the Payment";
         }else if($language_type1=='hi'){
         $message = "आपके बुकिंग अनुरोध की पुष्टि हो गई है, कृपया भुगतान के साथ आगे बढ़ें";
        $title = "आपके बुकिंग अनुरोध की पुष्टि हो गई है, कृपया भुगतान के साथ आगे बढ़ें";   
         }
      if($device_type=="android"){
       $type = 'accepted';
   
       $notificationData = array(
                                  'user_id'=> $userId,
                                  'doctor_id'=> $id,
                                  'booking_id'=> $booking_id,
                                  'title'=> $title,
                                  'message'=> $message,
                                  'type'   => $type,
                                  'status'=>'0',
                                  'badge_count'=>'1',
                                  'send_to'=>'user',
                                  'created_date'=> date('Y-m-d H:i:s'),
                                 );
     $notificationID=   $this->user_model->insert_data('notification',$notificationData);
     $notificationCount = count($this->user_model->getCondResult('notification','id',array('user_id'=>$userId,'status'=>'0','badge_count'=>'1','send_to'=>'user','type!='=>'adminChatUser'))); 
      $x=$this->user_model->android_pushh($device_token,$message,$title,$type,$notificationID,$notificationCount);//print_r($x);die;
      }
      //ios
       if($device_type=="Iphone"){
        $type = 'accepted'; 
      // $this->user_model->iphone($device_token,$message,$title,$type,$notificationID);
       $notificationData = array(
                                  'user_id'=> $userId,
                                  'doctor_id'=> $id,
                                  'booking_id'=> $booking_id,
                                  'title'=> $title,
                                  'message'=> $message,
                                  'type'   => $type,
                                  'status'=>'0',
                                   'badge_count'=>'1',
                                  'send_to'=>'user',
                                  'created_date'=> date('Y-m-d H:i:s'),
                                 );
      $notificationID= $this->user_model->insert_data('notification',$notificationData);
       $notificationCount = count($this->user_model->getCondResult('notification','id',array('user_id'=>$userId,'status'=>'0','badge_count'=>'1','send_to'=>'user','type!='=>'adminChatUser'))); 
        $this->user_model->iphone($device_token,$message,$title,$type,$notificationID,$notificationCount);
   // print_r($x);die;
      }

    }  //check end notification status
      //send notification end

     }  else if($status=='2')  //reject
     {
        $data = array('booking_status'=>$status,'reject_reason'=>$reason );
        if($language_type=='en'){
        $msg = "Booking Rejected successfully";
         }else if($language_type=='hi'){
         $msg = "बुकिंग सफलतापूर्वक रद्द कर दी गई";   
         }

           //send notification start
         if($language_type1=='en'){

        $message = "Unfortunately, Dr will not be able to attain. Please contact Admin";
        $title = "Unfortunately, Dr will not be able to attain. Please contact Admin";
         }else if($language_type1=='hi'){
        $message = "दुर्भाग्य से, डॉ। प्राप्त करने में सक्षम नहीं होंगे। कृपया व्यवस्थापक से संपर्क करें";
        $title = "दुर्भाग्य से, डॉ। प्राप्त करने में सक्षम नहीं होंगे। कृपया व्यवस्थापक से संपर्क करें"; 
         }
       $checkNotificationStatus = $this->user_model->fetchValue(USER,'notification_status',array('id'=>$userId)); //notification send when status is on
     if($checkNotificationStatus=="on"){  
       //   $notificationCount = count($this->user_model->getCondResult('notification','id',array('user_id'=>$userId,'status'=>'1')));
      if($device_type=="android"){
       $type = "rejected"; 
      
       $notificationData = array(
                                  'user_id'=> $userId,
                                  'doctor_id'=> $id,
                                  'booking_id'=> $booking_id,
                                  'title'=> $title,
                                  'message'=> $message,
                                  'type'   => $type,
                                  'status'=>'0',
                                   'badge_count'=>'1',
                                 'send_to'=>'user',
                                  'created_date'=> date('Y-m-d H:i:s'),
                                 );
     $notificationId =   $this->user_model->insert_data('notification',$notificationData);
    $notificationCount = count($this->user_model->getCondResult('notification','id',array('user_id'=>$userId,'status'=>'0','badge_count'=>'1','send_to'=>'user','type!='=>'adminChatUser'))); 
        $this->user_model->android_pushh($device_token,$message,$title,$type,$notificationId,$notificationCount);
      }
      if($device_type=="Iphone")
      {
        $type = "rejected"; 
      
       $notificationData = array(
                                  'user_id'=> $userId,
                                  'doctor_id'=> $id,
                                  'booking_id'=> $booking_id,
                                  'title'=> $title,
                                  'message'=> $message,
                                  'type'   => $type,
                                  'status'=>'0',
                                  'badge_count'=>'1',
                                  'send_to'=>'user',
                                  'created_date'=> date('Y-m-d H:i:s'),
                                 );
       $notificationId=   $this->user_model->insert_data('notification',$notificationData);
       $notificationCount = count($this->user_model->getCondResult('notification','id',array('user_id'=>$userId,'status'=>'0','badge_count'=>'1','send_to'=>'user','type!='=>'adminChatUser'))); 
        $this->user_model->iphone($device_token,$message,$title,$type,$notificationId,$notificationCount);
      }

    } //end check notification
      //send notification end
     }
     else if($status=='5') //for cancel
     {
        $data = array('booking_status'=>$status,'cancel_reason'=>$reason );
        if($language_type=='en'){
        $msg = "Booking cancelled successfully"; 
         }else if($language_type=='hi'){
           $msg = "बुकिंग सफलतापूर्वक रद्द कर दी गई";   
         }

      //send notification start
  $checkNotificationStatus = $this->user_model->fetchValue(USER,'notification_status',array('id'=>$userId)); //notification send when status is on
     if($checkNotificationStatus=="on"){    
        if($language_type1=='en'){
        $message = "Unfortunately, Dr will not be able to attain. Please contact Admin";
        $title = "Unfortunately, Dr will not be able to attain. Please contact Admin";
         }else if($language_type1=='hi'){
          $message = "दुर्भाग्य से, डॉ। प्राप्त करने में सक्षम नहीं होंगे। कृपया व्यवस्थापक से संपर्क करें";
          $title = "दुर्भाग्य से, डॉ। प्राप्त करने में सक्षम नहीं होंगे। कृपया व्यवस्थापक से संपर्क करें"; 
         }
      if($device_type=="android"){
        $type= "cancelled";
     
       $notificationData = array(
                                  'user_id'=> $userId,
                                  'doctor_id'=> $id,
                                  'booking_id'=> $booking_id,
                                  'title'=> $title,
                                  'message'=> $message,
                                  'type'   => $type,
                                  'status' => '0',
                                   'badge_count'=>'1',
                                  'send_to'=>'user',
                                  'created_date'=> date('Y-m-d H:i:s'),
                                 );
       $notificationId=$this->user_model->insert_data('notification',$notificationData);
        $notificationCount = count($this->user_model->getCondResult('notification','id',array('user_id'=>$userId,'status'=>'0','badge_count'=>'1','send_to'=>'user','type!='=>'adminChatUser'))); 
         $this->user_model->android_pushh($device_token,$message,$title,$type,$notificationId,$notificationCount);
      }

       if($device_type=="Iphone"){
        $type= "cancelled";
     
       $notificationData = array(
                                  'user_id'=> $userId,
                                  'doctor_id'=> $id,
                                  'booking_id'=> $booking_id,
                                  'title'=> $title,
                                  'message'=> $message,
                                  'type'   => $type,
                                  'status'=>'0',
                                   'badge_count'=>'1',
                                   'send_to'=>'user',
                                  'created_date'=> date('Y-m-d H:i:s'),
                                 );
      $notificationId= $this->user_model->insert_data('notification',$notificationData);
       $notificationCount = count($this->user_model->getCondResult('notification','id',array('user_id'=>$userId,'status'=>'0','badge_count'=>'1','send_to'=>'user','type!='=>'adminChatUser'))); 
         $this->user_model->iphone($device_token,$message,$title,$type,$notificationId,$notificationCount);
      }

    } //end check notification
      //send notification end
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
    $language_type = $this->input->post('language_type'); 
    $qualification = $this->user_model->getCondResultArray('doctor_qualification','id,name',array('status'=>'1'));
    if(!empty($qualification))
    {
         if($language_type=='en'){
            $msg = 'qualification List seen successfully.';
         }else if($language_type=='hi'){
           $msg = 'योग्यता सूची सफलतापूर्वक देखी गई।'; 
         }
        $response = [ 'status' => "SUCCESS",'message'=>$msg,'qualification'=>$qualification];
      echo json_encode($response);die;
    }
   }

    function city()
   {
   // echo "hi";
    $language_type = $this->input->post('language_type'); 
    $city = $this->user_model->getCondResultArray('doctor_city','id,name',array('status'=>'1'));
    if(!empty($city))
    {
          if($language_type=='en'){
            $msg = 'city List seen successfully.';
         }else if($language_type=='hi'){
           $msg = 'सिटी लिस्ट सफलतापूर्वक देखी गई।'; 
         }
        $response = [ 'status' => "SUCCESS",'message'=>$msg,'city'=>$city];
      echo json_encode($response);die;
    }
   }


    function specialtyList()
   {
   // echo "hi";
     $language_type = $this->input->post('language_type'); 
    $specialtyList = $this->user_model->getCondResultArray('specility','id,name,hi_name',array('status'=>'1'));
    if(!empty($specialtyList))
    {

           if($language_type=='en'){
            $msg = 'specility List seen successfully.';
         }else if($language_type=='hi'){
           $msg = 'विशेष सूची सफलतापूर्वक देखी गई'; 
         }

         foreach($specialtyList as $values)
         {
            if($language_type=='en'){
                $name = $values['name'];
            }else if($language_type=='hi'){
                $name = $values['hi_name']; 
            }
           $specialtyListArr[]  = array(
                                      'id'=>$values['id'],
                                      'name'=> $name,
                                   );
         }
        $response = [ 'status' => "SUCCESS",'message'=>$msg,'specialtyList'=>$specialtyListArr];
      echo json_encode($response);die;
    }
   }


   function experienceList()
   {
   // echo "hi";
    $language_type = $this->input->post('language_type'); 
    $experienceList = $this->user_model->getCondResultArray('doctor_exp','id,exp',array('status'=>'1'));
    if(!empty($experienceList))
    {    
         if($language_type=='en'){
            $msg = 'experience List seen successfully.';
         }else if($language_type=='hi'){
           $msg = 'अनुभव सूची सफलतापूर्वक देखी गई।'; 
         }
        $response = [ 'status' => "SUCCESS",'message'=>$msg,'experienceList'=>$experienceList];
      echo json_encode($response);die;
    }
   }


     function bankList()
   {
   // echo "hi";
    $language_type = $this->input->post('language_type'); 
    $bankList = $this->user_model->getCondResultArray('bank_listing','id,name',array('status'=>'1'));
    if(!empty($bankList))
    {
         if($language_type=='en'){
            $msg = 'Bank List seen successfully.';
         }else if($language_type=='hi'){
           $msg = 'बैंक सूची सफलतापूर्वक देखी गई'; 
         }
        $response = [ 'status' => "SUCCESS",'message'=>$msg,'bankList'=>$bankList];
      echo json_encode($response);die;
    }
   }


   //doctor session start apis

   function homeSessionStart()
   {
     if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $token     = $this->input->post('token');
        $booking_id = $this->input->post('booking_id');
        $language_type = $this->input->post('language_type'); 
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
        $result = $this->user_model->getCondResultArray(DOCTOR,'id,name',array('token'=>$token));
        $doctor_id = $result[0]['id'];
        $doctor_name = $result[0]['name'];
        if($result)
        {
          $sessionData = array(
                             'doctor_id'          => $doctor_id,
                             'booking_id'         => $booking_id,
                             'user_id'           => $this->input->post('user_id'),
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

            $response['message']    = 'Please enter Subjective';
            $response['requestKey'] = "homeSessionStart";
            echo json_encode($response);die;
        }    
        
        if (empty($sessionData['objective'])) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Please enter Objective';
            $response['requestKey'] = "homeSessionStart";
            echo json_encode($response);die;
        }   

         if (empty($sessionData['assessment'])) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Please enter Assessment';
            $response['requestKey'] = "homeSessionStart";
            echo json_encode($response);die;
        }  

         if (empty($sessionData['planning'])) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Please enter Planning';
            $response['requestKey'] = "homeSessionStart";
            echo json_encode($response);die;
        }    


           $insertid =$this->my_model->insert_data('doctor_session',$sessionData);
           if($insertid){
              
        //send notification start
        $userId = $this->user_model->fetchValue(BOOKING,'user_id',array('id'=>$booking_id));  

        $userDetails = $this->user_model->getCondResultArray(USER,'id,device_type,device_token,notification_status',array('id'=>$userId)); 
        $device_token =  $userDetails[0]['device_token'];
        $device_type =  $userDetails[0]['device_type'];
        $message = "Your session has been completed, Please rate the Doctor";
        $title = "Your session has been completed, Please rate the Doctor";
        $type = 'Sessionend';
       if($userDetails[0]['notification_status']=='on')
       {
        $notificationData = array(
                                  'user_id'=> $userId,
                                  'doctor_id'=> $doctor_id,
                                  'booking_id'=> $booking_id,
                                  'title'=> $title,
                                  'message'=> $message,
                                  'type'   => $type,
                                  'status'=>'0',
                                   'badge_count'=>'1',
                                  'send_to'=>'user',
                                  'created_date'=> date('Y-m-d H:i:s'),
                                 );
       $notificationID=   $this->user_model->insert_data('notification',$notificationData);
       $notificationCount = count($this->user_model->getCondResult('notification','id',array('user_id'=>$userId,'status'=>'0','badge_count'=>'1','type!='=>'adminChatUser')));
      if($device_type=="android")
      {
     
     
      $this->user_model->android_pushh($device_token,$message,$title,$type,$notificationID,$notificationCount);
      }
      //ios
    if($device_type=="Iphone")
    {
     
         $notificationID= $this->user_model->insert_data('notification',$notificationData);
         $notificationCount = count($this->user_model->getCondResult('notification','id',array('user_id'=>$userId,'status'=>'1','send_to'=>'user','type!='=>'adminChatUser'))); 
        $this->user_model->iphone($device_token,$message,$title,$type,$notificationID,$notificationCount);
    }

     }
      //send notification end 
           $update =$this->my_model->update_data('doctor_booking',array('id'=>$booking_id),array('booking_status'=>'4','session_status'=>'0')); //update booking status 4 
           //session status 0 means session end
           //echo $this->db->last_query();die;
           $response['status']              = "SUCCESS";
           $response['message']             = 'Session added Successfully';
           $response['requestKey']          = "homeSessionStart";

          
         echo json_encode($response);die;
       }
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
        $user_type = $this->input->post('user_type');
         $language_type = $this->input->post('language_type'); 
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

        $result = $this->user_model->getCondResultArray(DOCTOR,'id,name',array('token'=>$token));
        $doctor_name = $result[0]['name'];
        $doctor_id = $result[0]['id'];
        if($result)
        {

           if($user_type=='member')
        {
          $user_id = $this->input->post('user_id');   // member id
        }
        if($user_type=='user')
        {
           $user_id = $this->input->post('user_id');
        }
          $sessionData = array(
                             'doctor_id'          => $doctor_id,
                             'booking_id'         => $booking_id,
                             'user_id'            => $user_id,
                             'subjective'         => $this->input->post('subjective'),
                             'objective'          => $this->input->post('objective'),
                             'assessment'         => $this->input->post('assessment'),
                              'planning'          => $this->input->post('planning'),
                              'session_type  '    => 'call',
                              'past_history  '    => $this->input->post('pass_history'),
                              'image'             => $image,
                              'user_type'         => $user_type,
                              'digital_signature'         => $signature,
                             'status'             => '1',
                             'created_date'       =>date('Y-m-d h:i:s'),

                        );
                        
         if (empty($booking_id)) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Booking Id is empty';
            $response['requestKey'] = "callSessionStart";
            echo json_encode($response);die;
        }   
        
                        
         if (empty($this->input->post('user_id'))) {

            $response['status']     = "FAILURE";
            $response['message']    = 'user Id is empty';
            $response['requestKey'] = "callSessionStart";
            echo json_encode($response);die;
        }   
        
         if (empty($sessionData['subjective'])) {

            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please enter subjective';
             }else if($language_type=='hi'){
             $response['message']    = 'कृपया सब्जेक्ट दर्ज करें';   
             }
            $response['requestKey'] = "callSessionStart";
            echo json_encode($response);die;
        }    
        
        if (empty($sessionData['objective'])) {

            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please enter objective';
             }else if($language_type=='hi'){
              $response['message']    = 'कृपया उद्देश्य दर्ज करें';  
             }
            $response['requestKey'] = "callSessionStart";
            echo json_encode($response);die;
        }   

         if (empty($sessionData['assessment'])) {

            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please enter assessment';
             }else if($language_type=='hi'){
                $response['message']    = 'कृपया आकलन दर्ज करें';  
             }
            $response['requestKey'] = "callSessionStart";
            echo json_encode($response);die;
        }  

         if (empty($sessionData['planning'])) {

            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please enter planningy';
             }else if($language_type=='hi'){
             $response['message']    = 'कृपया योजना दर्ज करें';   
             }
            $response['requestKey'] = "callSessionStart";
            echo json_encode($response);die;
        }    


           $insertid =$this->my_model->insert_data('doctor_session',$sessionData);
           //echo $this->db->last_query();die;
           if($insertid){
           $this->my_model->update_data(BOOKING,array('id'=>$booking_id),array('end_session_date'=>date('Y-m-d H:i:s')));
          // echo $this->db->last_query();die;
        //send notification start
        $userId = $this->user_model->fetchValue(BOOKING,'user_id',array('id'=>$booking_id));   
        $userDetails = $this->user_model->getCondResultArray(USER,'id,device_type,device_token,notification_status,language_type',array('id'=>$userId)); 
        $device_token =  $userDetails[0]['device_token'];
        $device_type =  $userDetails[0]['device_type'];
        $language_type1 =  $userDetails[0]['language_type'];
        if($language_type1){
        $message = "Your session has been completed, Please rate the Doctor";
        $title = "Your session has been completed, Please rate the Doctor";
         }else if($language_type1=='hi'){
          $message = "आपका सत्र पूरा हो गया है,कृपया डॉक्टर को रेट करें";
        $title = "आपका सत्र पूरा हो गया है,कृपया डॉक्टर को रेट करें";  
         }
        $type = 'Sessionend';
     if($userDetails[0]['notification_status']=="on"){
        $notificationData = array(
                                  'user_id'=> $userId,
                                  'doctor_id'=> $doctor_id,
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

            
             $update =$this->my_model->update_data('doctor_booking',array('id'=>$booking_id),array('booking_status'=>'4','session_status'=>'0')); //update booking status 4 
             //session status 0 means session end
           //echo $this->db->last_query();die;
           $response['status']              = "SUCCESS";
           if($language_type=='en'){
           $response['message']             = 'Session added Successfully';
            }else if($language_type=='hi'){
              $response['message']             = 'सत्र सफलतापूर्वक जोड़ा गया';   
            }
           $response['requestKey']          = "callSessionStart";
            echo json_encode($response);die;
       }
          
        
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
   $language_type = $this->input->post('language_type'); 
  if (empty($booking_id)) {

            $response['status']     = "FAILURE";
            $response['message']    = 'Booking id  is empty';
            echo json_encode($response);die;
         } 

      $doctorDetails = $this->user_model->fieldCondRow(BOOKING,'doctor_id',array('id'=>$booking_id));
      $doctor_id =  $doctorDetails->doctor_id;
       $checkSessionstatus = $this->user_model->getCondResult(BOOKING,'session_status',array('doctor_id'=>$doctor_id));
     
        // "<pre>";
    //   print_r($checkSessionstatus);die;
       $arr = array();
       foreach($checkSessionstatus as $status)
       {
        array_push($arr,$status->session_status);
     //   $sta = array($status->session_status);
       }
     
       if(in_array('1',$arr))
       {
       $response['status']              = "FAILURE";
       if($language_type=='en'){
       $response['message']             = 'Session Already started';
        }else if($language_type=='hi'){
          $response['message']             = 'सत्र पहले ही शुरू हो गया';   
        }
       echo json_encode($response);die;
      }
      // if($checkSessionstatus->session_status =='1')
      // {
      //        $response['status']     = "FAILURE";
      //       $response['message']    = 'Session Already started';
      //       echo json_encode($response);die;
      // } 

  
  $update  = $this->my_model->update_data('doctor_booking',array('id'=>$booking_id),array('session_status'=>'1')); //update session status 1 means session start      
 
  if($update)
  {

        $bookingDetails = $this->user_model->getCondResult(BOOKING,'booking_type,user_id,doctor_id,booking_latitude,booking_longitude',array('id'=>$booking_id));
         $userId = $bookingDetails[0]->user_id;
         $doctorId = $bookingDetails[0]->doctor_id;
         $userLat = $bookingDetails[0]->booking_latitude; 
         $userLong = $bookingDetails[0]->booking_longitude; 

        $doctorDetail = $this->user_model->getCondResult(DOCTOR,'name,latitude,longitude',array('id'=>$doctorId));  
        $doctor_name  = $doctorDetail[0]->name; 
        $dotorLat    = $doctorDetail[0]->latitude;
        $dotorLong   = $doctorDetail[0]->longitude;
        $userDetails = $this->user_model->getCondResultArray(USER,'id,device_type,device_token,notification_status,language_type',array('id'=>$userId)); 
        $device_token =  $userDetails[0]['device_token'];
        $device_type =  $userDetails[0]['device_type'];
        $language_type1 =  $userDetails[0]['language_type'];


      $userLat = $bookingDetails[0]->booking_latitude; 
      $userLong = $bookingDetails[0]->booking_longitude; 
    

       //tracking doctor start
      $checkTraking =  $this->user_model->getCondResultArray('doctor_tracking','id',array('booking_id'=>$booking_id)); 
      if(empty($checkTraking)){
         $trackingData = array(
                               'user_id'      => $userId,
                               'doctor_id'    => $doctorId,
                               'booking_id'   => $booking_id,
                               'user_lat'     => $userLat,
                               'user_long'    => $userLong,
                               'doctor_lat'   => $dotorLat,
                               'doctor_long'  => $dotorLong,
                               'status'       => '0',
                               'created_date' => date('Y-m-d h:i:s'),
                              );
        $this->user_model->insert_data('doctor_tracking',$trackingData);
        //echo $this->db->last_query();die;
      }else
      {
       $this->user_model->update_data('doctor_tracking',$trackingData,array('id'=>$checkTraking[0]['id']));
      }
      //tracking doctor end
     //end test   
    if($userDetails[0]['notification_status']=="on"){ 
     if($bookingDetails[0]->booking_type=='home')  //for home
      {

           //send notification start
        if($language_type1=='en'){
        $message = "Dr ".ucwords($doctor_name)." has started the session, You can track him now";
        $title = "Dr ".ucwords($doctor_name)." has started the session, You can track him now";
         }else if($language_type1=='hi'){
          $message = "डॉ। ".ucwords($doctor_name)." सत्र शुरू कर दिया है, आप उसे अब ट्रैक कर सकते हैं";
          $title = "डॉ। ".ucwords($doctor_name)." सत्र शुरू कर दिया है, आप उसे अब ट्रैक कर सकते हैं";   
         }
        $type = $bookingDetails[0]->booking_type.'StartSession';
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
       $notificationID=   $this->user_model->insert_data('notification',$notificationData); 
          $notificationCount = count($this->user_model->getCondResult('notification','id',array('user_id'=>$userId,'status'=>'0','badge_count'=>'1','type!='=>'adminChatUser'))); 
         
      if($device_type=="android")
      {

     
      
      $this->user_model->android_pushh($device_token,$message,$title,$type,$notificationID,$notificationCount);
      }
      //ios
    if($device_type=="Iphone")
    {
     
      
        $this->user_model->iphone($device_token,$message,$title,$type,$notificationID,$notificationCount);
    }
      //send notification end
   }else
   {
         if($language_type1=='en'){
        $message = "Dr ".ucwords($doctor_name)." has started the session, Please be available";
        $title = "Dr ".ucwords($doctor_name)." has started the session, Please be available";
         }else if($language_type1=='hi'){
           $message = "डॉ।  ".ucwords($doctor_name)." सत्र शुरू कर दिया है, कृपया उपलब्ध रहें";
        $title = "डॉ।  ".ucwords($doctor_name)." सत्र शुरू कर दिया है, कृपया उपलब्ध रहें";  
         }
        $type = $bookingDetails[0]->booking_type.'StartSession';
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
      $notificationID=   $this->user_model->insert_data('notification',$notificationData);
         $notificationCount = count($this->user_model->getCondResult('notification','id',array('user_id'=>$userId,'status'=>'0','badge_count'=>'1','send_to'=>'user','type!='=>'adminChatUser'))); 
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
  } //end check notification

         $response['status']              = "SUCCESS";
         if($language_type=='en'){
         $response['message']             = 'Session start Successfully';
          }else if($language_type=='hi'){
          $response['message']             = 'सत्र सफलतापूर्वक प्रारंभ होता है';  
          }
         echo json_encode($response);die;
       
  }

  




 }


//end session status


 function getNotificationStatus()
    {
       if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $language_type = $this->input->post('language_type'); 
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
             if($language_type=='en'){
            $response['message']    = 'status seen successfully.';
             }else if($language_type=='hi'){
             $response['message']    = 'स्थिति सफलतापूर्वक देखी गई।';   
             }
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
       $language_type = $this->input->post('language_type'); 
     // $status = $this->input->post('status');

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

         
      $checkToken =   $this->user_model->getCondResultArray(DOCTOR,'id,latitude,longitude',array('token'=>$token));
      if($checkToken)
      {
      $latitude =$checkToken[0]['latitude'];
      $longitude = $checkToken[0]['longitude'];
      $doctor_id =$checkToken[0]['id'];
      $result =  $this->user_model->getHomeUserList(array('B.doctor_id'=>$checkToken[0]['id'],'B.booking_status'=>'0'));
      $notificationCount = count($this->user_model->resultArrayNull('notification','id',array('doctor_id'=>$doctor_id,'status'=>'0','badge_count'=>'1','send_to'=>'doctor','type !='=>'adminChatDoctor')));
      if(!empty($result))
      {
       // echo "hi";die;
      foreach($result as $values)
      {
          //distance 
  //print_r($values);die;
     // $user  = $this->user_model->getCondResultArray(USER,'latitude,longitude',array('id'=>$values->id));   
     
       $latitudeFrom = $values->booking_latitude;
       $longitudeFrom = $values->booking_longitude;
       $theta = $longitudeFrom - $longitude;
      $dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitude)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitude)) * cos(deg2rad($theta));
     $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;

     $distance = ($miles * 1.609344).' km';
      // $distance =  $this->user_model->distance($latitudeTo,$longitudeTo,$latitudeFrom,$longitudeFrom,'K');  
       $distance = round($distance,1);  
          //end distance
//echo $values->doctor_id;

     
       
        $homeBookingList[] = array(
                                     'booking_id'               => $values->booking_id, 
                                     'user_name'                => $values->username,
                                     'member_name'              => $values->member_name, 
                                     'address'                  => $values->address,
                                     'booking_type'             => $values->booking_type,
                                     'reason_visit'             => $values->reason_visit,
                                     'latitude'                 => $values->booking_latitude,
                                     'longitude'                => $values->booking_longitude,
                                     'date'                     => date('d-m-Y',strtotime($values->created_date)),
                                     'time'                     => date('h:i A',strtotime($values->created_date)),
                                     'scheduling_date'          => date('d-m-Y',strtotime($values->schedule_date)),
                                     'schedule_time'            => date('h:i A',strtotime($values->schedule_time)),
                                     'distance'                 => $distance,
                                     'badge_count'              => $notificationCount,
                                   );

    }

           $response['status']               = "SUCCESS";
            $response['homeBookingList']      = $homeBookingList;
            if($language_type=='en'){
            $response['message']              = 'Home booking list  seen successfully.';
             }else if($language_type=='hi'){
               $response['message']              = 'घर की बुकिंग सूची सफलतापूर्वक देखी गई।';  
             }
            echo json_encode($response);die;


      }else{
    
       
            $response['status']               = "SUCCESS";
            $response['homeBookingList']      = $homeBookingList;
            if($language_type=='en'){
            $response['message']              = 'No Booking Found!';
             }else if($language_type=='hi'){
               $response['message']              = 'कोई बुकिंग नहीं मिली!';  
             }
            echo json_encode($response);die;
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


  // get user medical detail 

  function getReportDetail()
  {
     if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token       = $this->input->post('token');
      $booking_id  = $this->input->post('booking_id');
      $language_type = $this->input->post('language_type'); 

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

         
     

      $checkToken =   $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));


      if($checkToken)
      {
        //$userId =   $this->user_model->fetchValue('doctor_booking','user_id',array('id'=>$booking_id));
         $book =  $this->user_model->getCondResultArray('doctor_booking','user_id,member_id,member_name',array('id'=>$booking_id));
        // $userId = $book[0]['user_id'];
         $memberName = $book[0]['member_name']; 
         if($memberName)
         {
          $userId = $book[0]['member_id'];
          $type = 'member';
         }else
         {
          $userId = $book[0]['user_id'];
          $type = 'user';
         }
        //get hospital 
         $hostpital =   $this->user_model->getCondResultArray('user_hospital_records','id,hospital_name,provider_name,provider_specility,service_date,type,created_date',array('user_id'=>$userId,'user_type'=>$type));
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
                                   'service_date'        => date('d-m-Y',strtotime($hos['service_date'])),
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
          $specialty =   $this->user_model->getCondResultArray('user_specialty_records','id,specialty,specialty_type,service_date,type,created_date',array('user_id'=>$userId,'user_type'=>$type));
            if(!empty($specialty)){

            foreach($specialty as $spe){
                  $spe_img =   $this->user_model->getCondResult('medical_record_image','image',array('record_id'=>$spe['id'],'type'=>'specialty'));
            if(empty($spe_img))
                 $spe_img = array();
                 $SpecialtyArr[] = array(
                                      'id'              => $spe['id'],
                                      'specialty'       => $spe['specialty'],
                                      'specialty_type'  => $spe['specialty_type'],
                                      'service_date'    => date('d-m-Y',strtotime($spe['service_date'])),
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
          $lab =   $this->user_model->getCondResultArray('user_lab_records','id,lab_name,prescription_name,lab_date,type,created_date',array('user_id'=>$userId,'user_type'=>$type));
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
                                      'lab_date'            => date('d-m-Y',strtotime($lb['lab_date'])),
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
          $physical =   $this->user_model->getCondResultArray('user_physical_therapist_records','id,therapy_name,therapy_date,type,created_date',array('user_id'=>$userId,'user_type'=>$type));
        if(!empty($physical)){
                
       foreach($physical as $py)
             {
                 $phy_img =   $this->user_model->getCondResultArray('medical_record_image','image',array('record_id'=>$py['id'],'type'=>'physical'));

                 if(empty($phy_img))
                     $phy_img = array();

                   $PhyArr[] = array(
                                      'id'              => $py['id'],
                                      'therapy_name'    => $py['therapy_name'],
                                      'therapy_date'    => date('d-m-Y',strtotime($py['therapy_date'])),
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
                                      'other_date'           => date('d-m-Y',strtotime($othr['date'])),
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
           $pharmacy =   $this->user_model->getCondResultArray('user_pharmacy_script','id,pharmacy_name,pharmacy_provider_name,service_date,type,created_date',array('user_id'=>$userId,'user_type'=>$type));
            

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
                                               'service_date'          => date('d-m-Y',strtotime($ph['service_date'])),
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
        // $getSeeion =   $this->user_model->getCondResultArray('doctor_session','id,subjective,objective,assessment,planning,image',array('doctor_id'=>$booking_id));
            

        //       if(!empty($getSeeion))
        //       {
                

        //         foreach($getSeeion as $sess)
        //         {
                     

                      

        //                  $sessArr[] = array(
        //                                       'id'                   => $sess['id'],
        //                                       'subjective'           => $sess['subjective'],
        //                                       'objective'            => $sess['objective'],
        //                                        'assessment'          => $sess['assessment'],
        //                                        'planning'            => $sess['planning'],
        //                                        'images'               => $sess['image'],
        //                                    );
        //      }

        //         }

        //     else
        //     {
        //         $sessArr =array();
        //     }
         //end session    

         //get all records
            $getSessionData =   $this->user_model->getCondResultArray('doctor_session','doctor_id,subjective,objective,assessment,planning,digital_signature,image,created_date,id',array('user_id'=>$userId,'user_type'=>$type));
          //  echo $this->db->last_query();die;
     // $sessionObj=(object)$getSessionData[0];
      if(empty($getSessionData))
     {
      $SessArr = array();
     }
      foreach($getSessionData as $sess)
      {
        $doctorDetail =  $this->user_model->getCondResultArray(DOCTOR,'name,clinic_name',array('id'=>$sess['doctor_id']));
        $SessArr[] = array(
                           'id'          => $sess['id'],
                          'subjective'  => $sess['subjective'],
                          'objective'  => $sess['objective'],
                          'assessment'  => $sess['assessment'],
                          'planning'  => $sess['planning'],
                          'digital_signature'  => $sess['digital_signature'],
                          'doctor_name' => $doctorDetail[0]['name'],
                          'clinic_name'=> $doctorDetail[0]['clinic_name'],
                          'image'=> $sess['image'],
                          'date'=> date('d-m-Y',strtotime($sess['created_date'])),
                         );
      } 


    $pastHistory =  $this->user_model->fieldCondRow1('doctor_session','past_history,created_date,doctor_id',array('user_id'=>$userId,'user_type'=>$type));
    //  print_r($pastHistory);die;
     $doctor_name =  $this->user_model->fetchValue(DOCTOR,'name',array('id'=>$pastHistory->doctor_id));
      if($doctor_name)
      {
        $doctor_name = $doctor_name;
      } else
      {
        $doctor_name = "";
      }
      if($pastHistory->past_history)
      {
        $history = $pastHistory->past_history;
      }else
      {
        $history ="";
      }
      if($doctor_name!='' && $history!=''){
      $pastHis[] = array(
                       'past_history' => $history,
                       'date'      => date('d-m-Y',strtotime($pastHistory->created_date)),
                       'doctor_name' => $doctor_name,
                      );
    }else
    {
      $pastHis = array();
    }

       
         //end all records  
         if($language_type=='en'){
            $msg = 'user medical detail seen successfully.';
         } else if($language_type=='hi'){
            $msg = 'उपयोगकर्ता चिकित्सा विवरण सफलतापूर्वक देखा गया।';
         }
     
           $response = [ 'status' => "SUCCESS",'message'=>$msg,'hospitalDetail' => $HospitalArr,'specialtyDetail'=>$SpecialtyArr,'labDetail'=>$LabArr,'physicalDetails'=>$PhyArr,'otherDetail'=>$OtherArr,'pharmacyDetail'=>$PharmacyArr,'sessionDetail'=>$SessArr,'past_history'=>$pastHis];
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
      $language_type = $this->input->post('language_type'); 

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
     $rating = $this->user_model->getCondResultArray('doctor_rating','rating',array('doctor_id'=> $doctor_id,'user_id'=>$user_id)); 
     if(!empty($getSeeion)){
    foreach($getSeeion as $values)
    {
      
  $pastBookingDetails[] = array(
                      'subjective'    => $values['subjective'],
                      'objective'     => $values['objective'],
                      'assessment'    => $values['assessment'],
                      'planning'      => $values['planning'],
                      'image'         => $values['image'],
                      'rating'        => $rating[0]['rating'],
                     );
    }
      if($language_type=='en'){
        $msg = 'pastBookingDetails detail seen successfully.';
      }else if($language_type=='hi'){
       $msg = 'पिछले बुकिंग विवरण का विवरण सफलतापूर्वक देखा गया।'; 
      }
      $response = [ 'status' => "SUCCESS",'message'=>$msg,'pastBookingDetails' => $pastBookingDetails];
            echo json_encode($response);die;
          }else 
          {
             $response['status']     = "SUCCESS";
             if($language_type=='en'){
             $response['message']    = 'No Record found';
              }else if($language_type=='hi'){
                $response['message']    = 'कोई रिकॉर्ड नहीं मिला';
              }
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
    $language_type = $this->input->post('language_type'); 
   $rejectReason =  $this->user_model->getCondResultArray(REASON,'id,name,hi_name',array('status'=>'1'));

    

   if(!empty($rejectReason))
   {
    
   
    if($language_type=='en'){
        $msg = 'Reject Reason List seen successfully.';
    }else if($language_type=='hi'){
      $msg = 'अस्वीकार कारण सूची सफलतापूर्वक देखी गई।';   
    } 


   foreach($rejectReason as $values)
   {
     if($language_type=='en')
     {
        $name = $values['name'];
     }else if($language_type=='hi'){
        $name = $values['hi_name'];
     }
    $rejectReasonArr[] = array(
                             'id'=>$values['id'],
                             'name'=> $name,
                            );
   }
   $response = [ 'status' => "SUCCESS",'message'=>$msg,'rejectReason' => $rejectReasonArr];
            echo json_encode($response);die;
   }else
   {
       $response['status']     = "SUCCESS";
       if($language_type=='en'){
       $response['message']    = 'No Record found';
   }else if($language_type=='hi'){
    $response['message']    = 'कोई रिकॉर्ड नहीं मिला';
   }
       echo json_encode($response);
   }
}


//get country 

function countryList()
{
   $county =  $this->my_model->getfields2('countries','id,name');
     $language_type = $this->input->post('language_type'); 
   if(!empty($county))
   {
    if($language_type=='en'){
        $msg = 'Country List seen successfully.';
    }else if($language_type=='hi'){
      $msg = 'देश सूची सफलतापूर्वक देखी गई';   
    }
   $response = [ 'status' => "SUCCESS",'message'=>$msg,'county' => $county];
            echo json_encode($response);die;
   }else
   {
       $response['status']     = "SUCCESS";
       if($language_type=='en'){
       $response['message']    = 'No Record found';
   }else if($language_type=='hi'){
    $response['message']    = 'कोई रिकॉर्ड नहीं मिला';
   }
       echo json_encode($response);
   }
}


function stateList()
{
   $country_id = $this->input->post('country_id');
     $language_type = $this->input->post('language_type'); 

   if (empty($country_id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Country id  is empty';
            echo json_encode($response);die;
        }

   $state =  $this->my_model->getfields2('states','id,name',array('country_id'=>$country_id));
   if(!empty($state))
   {
    if($language_type=='en'){
        $msg = 'State List seen successfully.';
    }else if($language_type=='hi'){
      $msg = 'राज्य सूची सफलतापूर्वक देखी गई';   
    }
   $response = [ 'status' => "SUCCESS",'message'=>$msg,'state' => $state];
            echo json_encode($response);die;
   }else
   {
       $response['status']     = "SUCCESS";
       if($language_type=='en'){
       $response['message']    = 'No Record found';
   }else if($language_type=='hi'){
    $response['message']    = 'कोई रिकॉर्ड नहीं मिला';
   }
       echo json_encode($response);
   }
}



function cityList()
{
   $state_id = $this->input->post('state_id');
     $language_type = $this->input->post('language_type'); 

   if (empty($state_id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'State id  is empty';
            echo json_encode($response);die;
        }

   $city =  $this->my_model->getfields2('cities','id,name',array('state_id'=>$state_id));
   if(!empty($city))
   {
    if($language_type=='en'){
        $msg = 'City List seen successfully.';
    }else if($language_type=='hi'){
      $msg = 'सिटी लिस्ट सफलतापूर्वक देखी गई।';   
    }
   $response = [ 'status' => "SUCCESS",'message'=>$msg,'city' => $city];
            echo json_encode($response);die;
   }else
   {
       $response['status']     = "SUCCESS";
       if($language_type=='en'){
       $response['message']    = 'No Record found';
   }else if($language_type=='hi'){
    $response['message']    = 'कोई रिकॉर्ड नहीं मिला';
   }
       echo json_encode($response);
   }
}

function sessionDetail()
{
        $userId = $this->input->post('user_id');
        $booking_id = $this->input->post('booking_id');
        $user_type =  $this->input->post('user_type');
        $language_type = $this->input->post('language_type'); 
        $getSessionData =   $this->user_model->getCondResultArray('doctor_session','booking_id,id,doctor_id,subjective,objective,assessment,planning,digital_signature,image,created_date,past_history,user_type',array('user_id'=>$userId,'user_type'=>$user_type));
       /// $booking_id = $getSessionData[0]['booking_id'];
      //  $user_type = $getSessionData[0]['user_type'];
        if(!empty($getSessionData)){
         if($user_type=="user"){ 
        $userDetails = $this->user_model->getCondResultArray(USER,'name,address',array('id'=>$userId));
        $username = $userDetails[0]['name'];
         }else
         {
        $userDetails = $this->user_model->getCondResultArray('user_member','name',array('id'=>$userId));
        $username = $userDetails[0]['name'];
         }
      $avgRating =   $this->user_model->AvgRating('doctor_rating',array('doctor_id'=>$getSessionData[0]['doctor_id'],'booking_id'=>$booking_id));
      if($avgRating->rate)
      {
        $rate = round($avgRating->rate,1);
      }else
      {
        $rate = 0;
      }
        $sessionData = array(
                              'username'   => $username,
                              'address'    => $userDetails[0]['address'],
                              'subjective' => $getSessionData[0]['subjective'],
                              'objective' => $getSessionData[0]['objective'],
                              'assessment' => $getSessionData[0]['assessment'],
                              'planning' => $getSessionData[0]['planning'],
                              'prescription_image' => $getSessionData[0]['image'],
                              'pastHistory' => $getSessionData[0]['past_history'],
                              'subjective' => $getSessionData[0]['subjective'],
                              'date'      => date('d-m-Y h:i A',strtotime($getSessionData[0]['created_date'])),
                              'rating'    => "$rate",
                             );
         if($language_type=='en'){
            $msg = 'Session Detail seeen successfully.';
         }else if($language_type=='hi'){
           $msg= 'सत्र विवरण सफलतापूर्वक देखा गया'; 
         }
        $response = [ 'status' => "SUCCESS",'message'=>$msg,'pastSessionDetail' => $sessionData];
            echo json_encode($response);die;
            
          }else
          {
            $response['status']     = "SUCCESS";
           if($language_type=='en'){
           $response['message']    = 'No Record found';
          }else if($language_type=='hi'){
           $response['message']    = 'कोई रिकॉर्ड नहीं मिला';
           }
           echo json_encode($response);
          }

        }


    //change status doctor is avilable or not
     function changeDoctorStatus()
    {
      $token = $this->input->post('token');
      $status = $this->input->post('status');
     $language_type = $this->input->post('language_type'); 

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
      $update =  $this->user_model->update_data(DOCTOR,array('available_status'=>$status),array('id'=>$checkToken[0]['id']));
    //  echo $this->db->last_query();die;
      if($update){
       
            $response['status']     = "SUCCESS";
            if($language_type=='en'){
            $response['message']    = 'status change successfully.';
             }else if($language_type=='hi'){
               $response['message']    = 'स्थिति सफलतापूर्वक बदल जाती है।';  
             }
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


  function myNotification()
  {
     if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
       $language_type = $this->input->post('language_type'); 
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

   $checkToken =   $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));
   $doctorId = $checkToken[0]['id'];
      if($checkToken)
      {
        //$notification = $this->user_model->doctorNotification(array('n.doctor_id'=>$doctorId,'send_to'=>'doctor'));
       $cond ="doctor_id ='".$doctorId."' and send_to ='doctor' and type != 'adminChatDoctor'";
       // $update = $this->user_model->update_data('notification',array('status'=>'1','badge_count'=>'0'),$condition) ; 
       $notification = $this->user_model->getCondResult1('notification','id,doctor_id,booking_id,title,message,status,type,created_date',$cond);
       // echo $this->db->last_query();die;
        if(!empty($notification))
        {
         foreach($notification as $notify)
         {
          $arr[] = array(
                          'id'             => $notify->id,
                          'title'          => $notify->title,
                          'message'        => $notify->message,
                          'type'           => $notify->type,
                          'notification_status'=> $notify->status,
                          'date'           => date('d-m-Y',strtotime($notify->created_date)),
                          'time'           => date('h:i a',strtotime($notify->created_date)),
                          );
        }
           if($language_type=='en'){
            $msg = 'notification list seen successfully';
           }else if($language_type=='hi'){
            $msg= 'अधिसूचना सूची सफलतापूर्वक देखी गई';
           }
          $response = ['status'=>"SUCCESS",'message'=>$msg,'notificationList'=>$arr];
          echo json_encode($response);die;
         
        }else
        {
             $response['status']     = "FAILURE";
            if($language_type=='en'){
           $response['message']    = 'No Record found';
          }else if($language_type=='hi'){
           $response['message']    = 'कोई रिकॉर्ड नहीं मिला';
           }
            echo json_encode($response);die;
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

  //doctor tracking 
  function doctorTracking()
  {
     if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
     // $token = $this->input->post('token');
      $booking_id = $this->input->post('booking_id');
      $lat        = $this->input->post('latitude');
      $long       = $this->input->post('longitude'); 
      $language_type = $this->input->post('language_type'); 
      if(empty($booking_id)){
            $response['status']     = "FAILURE";
            $response['message']    = 'Booking id is empty';
            echo json_encode($response);die;
          }

     if(empty($lat)){
            $response['status']     = "FAILURE";
            $response['message']    = 'Latitude is empty';
            echo json_encode($response);die;
          }

    if(empty($long)){
            $response['status']     = "FAILURE";
            $response['message']    = 'Longitude is empty';
            echo json_encode($response);die;
          }
     
      $tracking =  $this->user_model->fieldCRow('doctor_tracking','user_lat,user_long,doctor_lat,doctor_long,status',array('booking_id'=>$booking_id)); 
      $userLat = $tracking->user_lat;
      $userLong = $tracking->user_long;
      if($lat==$userLat && $long==$userLong)
      {
        $status = '1';
      }else
      {
        $status = '0';
      }


        if (empty($booking_id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Booking id is empty';
            echo json_encode($response);die;
        }
        $data = array(
                       'doctor_lat'  => $lat,
                       'doctor_long' => $long,
                       'status'      => $status,
                     );

      $update = $this->user_model->update_data('doctor_tracking',$data,array('booking_id'=>$booking_id));
       if($update){
       $response['status']     = "SUCCESS";
       if($language_type=='en'){
       $response['message']    = 'Latlong updated successfully';
        }else if($language_type=='hi'){
          $response['message']    = 'लाटलोंग सफलतापूर्वक अपडेट किया गया';   
        }
       echo json_encode($response);die; 
      }
     
      }else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }  
  }


  //notification read or un read
   function notificationRead()
  {
     if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
    
      $status = $this->input->post('status');
      $notification_id = $this->input->post('notification_id');
      $language_type = $this->input->post('language_type'); 
     

      

  if (empty($notification_id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Notification id is empty';
            echo json_encode($response);die;
        }


    $update = $this->user_model->update_data('notification',array('status'=>'1','badge_count'=>'0'),array('id'=>$notification_id)) ;  
    
    if($update)
    {
          $response['status']     = "SUCCESS";
          if($language_type=='en'){
          $response['message']    = 'status updated successfully.';
           }else if($language_type=='hi'){
             $response['message']    = 'स्थिति सफलतापूर्वक अपडेट की गई।';
           }
          echo json_encode($response);die; 
    }

  
  
     
     }else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }  
  }


  function myEarning()
  {
     if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $month = $this->input->post('month');
      $language_type = $this->input->post('language_type'); 
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

   $checkToken =   $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));
   $doctorId = $checkToken[0]['id'];
      if($checkToken)
      {
        //$earning = $this->user_model->doctorEarning(array('n.doctor_id'=>$doctorId,'send_to'=>'doctor'));
       //$month = date('m'); 

       $cond = "doctor_id = $doctorId"; 
        if($month)
       {
        $cond .= " AND MONTH(created_date) = $month";
       }
       $monthlyEarning = $this->user_model->fieldCRow(PAYMENT,'id,SUM(amount) as amount',$cond);
      // echo $this->db->last_query();die;
       $totalHome = $this->user_model->fieldCRow(PAYMENT,'id,SUM(amount) as amount',array('doctor_id'=>$doctorId,'payment_type'=>'home'));
       $totalcall = $this->user_model->fieldCRow(PAYMENT,'id,SUM(amount) as amount',array('doctor_id'=>$doctorId,'payment_type'=>'call'));
       $totalcallVisit = $this->my_model->coutrow(PAYMENT,'id',array('doctor_id'=>$doctorId,'payment_type'=>'call'));
       $totalHomeVisit = $this->my_model->coutrow(PAYMENT,'id',array('doctor_id'=>$doctorId,'payment_type'=>'home'));
       //echo $this->db->last_query();die;
     // echo "<pre>";print_r($monthlyEarning);die;
       $monthEarning         = $monthlyEarning->amount;
       if($monthEarning)
       {
        $monthEarning1 = round($monthEarning);
       }else
       {
        $monthEarning1 = 0;
       }
       $totalHomeEarning     = $totalHome->amount;
       if($totalHomeEarning)
       {
        $totalHomeEarning1 = round($totalHomeEarning);
       }else
       {
        $totalHomeEarning1 = 0;
       }
       $totalcallEarning     = $totalcall->amount;
       if($totalcallEarning)
       {
        $totalcallEarning1= round($totalcallEarning);
       }else
       {
        $totalcallEarning1=0;
       }
       $totalHomevisitCount  = $totalHomeVisit;
       if($totalHomevisitCount)
       {
        $totalHomevisitCount1 = $totalHomevisitCount;
       }else
       {
        $totalHomevisitCount1 = 0;
       }
       $totalCallvisitCount  = $totalcallVisit;
       if($totalCallvisitCount)
       {
        $totalCallvisitCount1= $totalCallvisitCount;
       }else
       {
        $totalCallvisitCount1 = 0;
       }
        //echo $this->db->last_query();die;
       if($language_type=='en'){
        $msg = 'earning history show successfully';
       }else if($language_type=='hi'){
        $msg = 'कमाई का इतिहास सफलतापूर्वक दिखा।';
       }
      $response = ['status'=>"SUCCESS",'message'=>$msg,'monthlyEarning'=>$monthEarning1,'totalHomeEarning'=>$totalHomeEarning1,'totlaCallEarning'=>$totalcallEarning1,'totalCall'=>$totalCallvisitCount1,'totalHome'=>$totalHomevisitCount1]; 
      echo json_encode($response);
      
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
 

  function earningDetails()
  {
     if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $date = $this->input->post('date');
      $type = $this->input->post('type');
      $language_type = $this->input->post('language_type'); 
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

   $checkToken =   $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));
 
      if($checkToken)
      {
          $doctorId = $checkToken[0]['id'];
       
       $cond = "doctor_id=$doctorId";
       if($date) 
       {
        $cond .= " AND created_date = '".date('Y-m-d',strtotime($date))."'";
       }
       if($type)
       {
        $cond .= " AND payment_type= '".$type."'";
       }
      // echo $cond;die;
       $earningDetails = $this->user_model->getCondResultArray(PAYMENT,'id,amount,created_date',$cond);
       if(!empty($earningDetails))
       {
        foreach($earningDetails as $earning)
        $earningDetail[] = array(
                                 'id'=>$earning['id'],
                                 'amount'=> round($earning['amount']),
                                 'created_date'=>$earning['created_date'],
                                );
       }else
       {
        $earningDetail = array();
       }
        //echo $this->db->last_query();die;
       if($language_type=='en'){
        $msg = 'earning history show successfully.';
       }else if($language_type=='hi'){
        $msg = 'कमाई का इतिहास सफलतापूर्वक दिखा।'; 
       }
      $response = ['status'=>"SUCCESS",'message'=>$msg,'earningDetails'=>$earningDetail]; 
      echo json_encode($response);
      
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


    function aboutUs()
    {
      $data['about'] = $this->user_model->fieldCondRow(PAGE,'title,description',array('page_type'=>'0','type'=>'0'));
      $this->load->view('api/about_view_doctor',$data);
    }

     function termsAndConditions()
    {
      $data['terms'] = $this->user_model->fieldCondRow(PAGE,'title,description',array('page_type'=>'2','type'=>'0'));
      $this->load->view('api/terms_view_doctor',$data);
    }

    function faq()
    {
      $data['faq'] = $this->user_model->fieldCondRow(PAGE,'title,description',array('page_type'=>'1','type'=>'0'));
      $this->load->view('api/faq_view_doctor',$data);
    }
    
      function policy()
    {
      $data['policy'] = $this->user_model->fieldCondRow(PAGE,'title,description',array('page_type'=>'3','type'=>'0'));
      $this->load->view('api/policy_doctor',$data);
    }
 

  function sendnotification(){

   $x= $this->user_model->android_pushh("c5ReCwhuWY0:APA91bFdlR9x9524f3coK6COBFJFZWv0wN07TBGGBIAyFT4HibhmiMuEjADJWWvBdwfM6P50U7Lg3uuCa3Kbf_gFI6qSSapzBAcNqjKqKzVnAbnps9lTc9jklnSGsHd5YIYKYz7WkVCj","hello",'title for testing');
   print_r($x);
  }   

  function iphone()
  {

    $type = "";
    $device_token="F8F5A4C5D111C8F90383C70934CC4EF27D8D72902886AAEDCFF5CB0B83E21D21";
    $body="hello";
    $title = "title";
   // $arr =  array();
                  
    $x =$this->user_model->iphone1($device_token,$body,$title,$type,"2");
    print_r($x);
  }

    function SaveDoctorChat()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $message = $this->input->post('message');
       $language_type = $this->input->post('language_type'); 
     
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

         if (empty($message)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Message is empty';
            echo json_encode($response);die;
        }

         
   $checkToken =   $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));
      if($checkToken)
      {
        $doctor_id = $checkToken[0]['id'];
        
      $insertData = array(
        
                        'user_id'=>$doctor_id,
                        'message'=>$message,
                        'sender_type'=>'sender',
                        'user_type'=>'doctor',
                        'status'=>'1',
                        'badge_count'=>'1',
                        'created_date'=> date('Y-m-d H:i:s'),
                       );

       

       

       $insertid =  $this->user_model->insert_data('doctor_chat',$insertData);

       
        //end of uploaded multiple images
      // echo $this->db->last_query();die;

      if($insertid){
       
            $response['status']     = "SUCCESS";
            if($language_type=='en'){
            $response['message']    = 'Message send successfully.';
             }else if($language_type=='hi'){
              $response['message']    = 'संदेश सफलतापूर्वक भेजा गया।';  
             }
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

//chat list
  function chatList()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $language_type = $this->input->post('language_type'); 
     
     
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }


         
   $checkToken =   $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));

      if($checkToken)
      {
        $doctor_id = $checkToken[0]['id'];
         $update = $this->user_model->update_data('notification',array('status'=>'1','badge_count'=>'0'),array('doctor_id'=>$doctor_id,'type'=>'doctor','type'=>'adminChatDoctor')) ; 
        $this->load->model('com_model');
       $userChat = $this->user_model->doctorChat(array('user_id'=>$doctor_id,'user_type'=>'doctor'));
       if(!empty($userChat))
       {
        foreach($userChat as $chat)
        {
        $time =   $this->com_model->calculateTime($chat->created_date);
         if($chat->sender_type=='sender')
        {
         $name = $chat->name;
         $image = $chat->image;
        }else
        {
          $name = "Admin";
          $image = base_url('assets/images/avtar_dummy.png');
        }
          $chatArr[] = array(
                              'chat_id' => $chat->id,
                              'doctor_name' => $name,
                              'image'=> $image,
                              'message'=> $chat->message,
                              'sender_type'=>$chat->sender_type,
                              'time' => $time
                            );
        }
        if($language_type=='en'){
            $msg = 'chat list seen successfully';
        }else if($language_type=='hi'){
            $msg = 'चैट सूची सफलतापूर्वक देखी गई';
        }

        $response = ['status'=>"SUCCESS",'message'=>$msg,'chatList'=>$chatArr];
        echo json_encode($response);die;
       }else
       {
         $response['status']  = "FAILURE";
         if($language_type=='en'){
          $response['message'] = 'No chat record found';
      }else if($language_type=='hi'){
        $response['message'] = 'कोई चैट रिकॉर्ड नहीं मिला';
      }
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

  //doctor avg rating
  function doctorAvgRating()
  {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $language_type = $this->input->post('language_type'); 
     
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }


         
     $checkToken =   $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));

      if($checkToken)
      {
        
         $doctor_id =  $checkToken[0]['id'];
         $doctorRating =  $this->user_model->AvgRating('doctor_rating',array('doctor_id'=>$doctor_id));
         $doctorRate =  round($doctorRating->rate,1);
         if($doctorRate)
         {
          $rate = $doctorRate;
         }else {
          $rate = 0;
         }
         $response['status']     = "SUCCESS";
         if($language_type=='en'){
         $response['message']    = 'rating show successfully';
          }else if($language_type=='hi'){
          $response['message']    = 'रेटिंग सफलतापूर्वक प्रदर्शित होती है';  
          }
         $response['rating']     = $rate;
        echo json_encode($response);
       
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


  //save language 
   function saveLanguage()
  {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
        $token = $this->input->post('token');
        $language_type = $this->input->post('language_type');
     
       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

         if (empty($language_type)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Language Type is empty';
            echo json_encode($response);die;
        }
         
     $checkToken =   $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));

      if($checkToken)
      {
        
         $doctor_id =  $checkToken[0]['id'];
         $update = $this->user_model->update_data(DOCTOR,array('language_type'=>$language_type),array('id'=>$doctor_id)) ; 
         if($update){
         $response['status']     = "SUCCESS";
         $response['message']    = 'Language Saved';
       
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
     else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }  
    
  }



    function contactus()
  {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
        $token = $this->input->post('token');
        $language_type = $this->input->post('language_type');
     
       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

         if (empty($language_type)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Language Type is empty';
            echo json_encode($response);die;
        }
         
     $checkToken =   $this->user_model->getCondResultArray(DOCTOR,'id',array('token'=>$token));

      if($checkToken)
      {
         $contactInfo  = $this->user_model->getCondResultArray('doctor_contact','id,mobile,location',array('status'=>'1'));
         //$doctor_id =  $checkToken[0]['id'];
         //$update = $this->user_model->update_data(DOCTOR,array('language_type'=>$language_type),array('id'=>$doctor_id)) ; 
         if(!empty($checkToken)){
         $response['status']     = "SUCCESS";
         $response['contactus']  = $contactInfo;
         $response['message']    = 'contact Information show successfully';
         echo json_encode($response);
     }else
     {
         $response['status']     = "FAILURE";
        
         $response['message']    = 'No record found';
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
     else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }  
    
  }


  function mytime()
  {
    $x= $this->user_model->getTime('H147, H ब्लॉक, सेक्टर ६३, नोएडा, उत्तर प्रदेश 201301, भारत','B-179, पॉकेट 2, block 30, केंद्रीय विहार 2, सेक्टर');
  echo $x->rows[0]->elements[0]->duration->text;

  }


 
  


}
?>
