<?php 
//session_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//doctor now
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
    $language_type = $this->input->post('language_type'); 
    $randomToken = $this->user_model->getToken();
     $email     = $this->input->post('email');
     $mobile    = $this->input->post('mobile');
     $password  = $this->input->post('password');

     if (empty($email)) {
            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Email/Phone is empty';
             }else if($language_type=='hi')
             {
            $response['message']    = 'ईमेल / फोन नंबर अमान्य है';
             }
            $response['requestKey'] = "login";

            echo json_encode($response);
        }
        if (empty($password)) {

            $response['status']     = "FAILURE";
            if($language_type=='en')
             {   
            $response['message']    = 'Please enter Password';
           }else if($language_type=='hi'){
              $response['message']    = 'कृप्या पास्वर्ड भरो';
           }
            $response['requestKey'] = "login";
            echo json_encode($response);die;
        }

        $cond = "(email = '".$email."' OR mobile = '".$email."') AND password = '".md5($password)."'";

        $result = $this->user_model->getCondResultArray(USER,'id,name,email,mobile,country_code,dob,gender,address,image,address_detail',$cond);
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
                 'latitude'     => $this->input->post('latitude'),
                'longitude'     => $this->input->post('longitude'),
                'language_type'=>$language_type,
                'login_status' => '0',
            );
             $this->user_model->update_data(USER,$updateToken,array('id'=>$result[0]['id']));
            

            if($language_type=='en')
            {
              $successMsg = 'User Login Successfully';  
            }else if($language_type=='hi')
            {
              $successMsg = 'उपयोगकर्ता सफलतापूर्वक लॉग इन किया है';  
            }

            $response['status']                      = "SUCCESS";
            $response['message']                     = $successMsg;
            $response['requestKey']                  = "login";
            $response["login"]['user_id']            = $result[0]['id'];
            $response["login"]['name']               = $result[0]['name'];
            $response["login"]['email']              = $email;
            $response["login"]['mobile']             = $result[0]['mobile'];
            $response["login"]['country_code']       = $result[0]['country_code'];
            $response["login"]['dob']                = $result[0]['dob'];
             $response["login"]['image']             = $result[0]['image'];
            $response["login"]['gender']             = $result[0]['gender'];
            $response["login"]['address']            = $result[0]['address'];
            $response["login"]['address_detail']     = $result[0]['address_detail'];
            $response["login"]['token']              =  $updateToken['token'];


          echo json_encode($response);die; 

      }else
      {
            if($language_type=='en')
            {
              $blockMsg = 'Your account has been blocked due to some suspicious activity.Please contact admin';  
            }else if($language_type=='hi')
            {
              $blockMsg = 'कुछ संदिग्ध गतिविधि के कारण आपका खाता ब्लॉक कर दिया गया है। कृपया संपर्क व्यवस्थापक से संपर्क करें';  
            }
          echo json_encode(array('status' => "FAILURE", "message" =>$blockMsg ));
      }
        
   
}else{
         echo json_encode(array('status' => "FAILURE", "message" => "User Already Login."));
}
}
        else
        {
            if($language_type=='en')
            {
              $invalidMsg = 'Invalid Email Id or Password!';  
            }else if($language_type=='hi')
            {
              $invalidMsg = 'ईमेल आईडी या पासवर्ड अमान्य है!';  
            }
          echo json_encode(array('status' => "FAILURE", "message" =>$invalidMsg));
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
     $language_type = $this->input->post('language_type'); 



    $signup_type =  $this->input->post('signup_type');

       if (empty($signup_type)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Signup type is empty';
            $response['requestKey'] = "adduser";
            echo json_encode($response);die;
        }


    if($signup_type=='normal')
    {
      $address = $this->input->post('address');
      if(!empty($address))
      {
      $res = $this->user_model->getLatLong($address);
      $address_latitude =  $res['latitude'];
      $address_longitude =  $res['longitude'];
      }
     $userData = array(
                        'name'              => $this->input->post('name'),
                        'email'             => $this->input->post('email'),
                        'password'          => md5($pass),
                        'mobile'            => $this->input->post('mobile'),
                        'country_code'    => $this->input->post('country_code'),
                        'dob'               => date('Y-m-d',strtotime($this->input->post('dob'))),
                        'gender'            => $this->input->post('gender'),
                        'address'           => $this->input->post('address'),
                        'latitude'          => $this->input->post('latitude'),
                        'longitude'         => $this->input->post('longitude'),
                        'address_latitude'  => $address_latitude,
                        'address_longitude' => $address_longitude,
                        'address_detail'    =>  $this->input->post('address_detail'),
                        'token'             => $randomToken,
                        'device_type'       => $this->input->post('device_type'),
                        'device_token'      => $this->input->post('device_token'),
                        'status'            => '1',
                        'language_type'     => $language_type,
                        'notification_status' =>'on',
                        'created_date'      => date('Y-m-d h:i:s'),
                        'updated_date'      => date('Y-m-d h:i:s'),
                       );


  

     if (empty($userData['name'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please enter Name';
             }else if($language_type=='hi')
             {
            $response['message'] = 'कृपया नाम दर्ज करें';
             }
            $response['requestKey'] = "adduser";
            echo json_encode($response);die;
        }

        if (empty($userData['email'])) {
            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please enter Email';
           }else if($language_type=='hi'){
             $response['message']    = 'कृपया ईमेल दर्ज करें';
           }
            $response['requestKey'] = "adduser";
            echo json_encode($response);die;
        }

         if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Invalid email format';
            }else if($language_type=='hi'){
             $response['message']    = 'अमान्य ईमेल प्रारूप';   
            }
            $response['requestKey'] = "adduser";
            echo json_encode($response);die;
        }


        if (!is_numeric($userData['mobile'])) {
            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please enter valid Phone no';
             }else if($language_type=='hi'){
             $response['message']    = 'कृपया मान्य फ़ोन नंबर दर्ज करें'; 
             }
            $response['requestKey'] = "adduser";
            echo json_encode($response);die;
        }

        if (empty($userData['mobile'])) {

            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please enter Phone no';
             }else if($language_type=='hi'){
               $response['message']    = 'कृपया फ़ोन नंबर दर्ज करें';  
             }
            $response['requestKey'] = "adduser";
            echo json_encode($response);die;
        }


 if (empty($pass)) {

            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please enter Password';
             }else if($language_type=='hi'){
              $response['message']    = 'अपना पासवर्ड दर्ज करें';  
             }
            $response['requestKey'] = "adduser";
            echo json_encode($response);die;
        }

        if ($pass!=$conf_pass) {

            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Password must be equal to Confim  Password.';
            }else if($language_type=='hi'){
            $response['message']    = 'पासवर्ड, कॉन्फिम पासवर्ड के बराबर होना चाहिए।';  
            }
            $response['requestKey'] = "adduser";
            echo json_encode($response);die;
        }

         if (empty($userData['dob'])) {

            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please enter DOB';
             }else if($language_type=='hi'){
             $response['message']    = 'कृपया DOB दर्ज करें'; 
             }
            $response['requestKey'] = "adduser";
            echo json_encode($response);die;
        }

        $dob = date('Y-m-d',strtotime($userData['dob']));
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


         if (empty($userData['address'])) {

            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please enter address';
             }else if($language_type=='hi'){
             $response['message']    = 'कृपया पता दर्ज करें';   
             }
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
                        // 'notification_status' =>'on',
                        'created_date'     => date('Y-m-d h:i:s'),
                       );

         
         if (!empty($this->input->post('member_name'))) {  
          $this->my_model->insert_data('user_member',$memberData);  
         } 
        //end add member
     $result = $this->user_model->getCondResultArray(USER,'id,name,email,mobile,country_code,dob,gender,address,address_detail,token,office_address',array('id'=>$insert));
     if($insert)
     {
        if($language_type=='en'){
          $addSuccessMsg = 'Thank you for the registeration. You can now proceed further.' ; 
        }else if($language_type=='hi'){
          $addSuccessMsg = 'पंजीकरण के लिए धन्यवाद। अब आप आगे बढ़ सकते हैं' ;    
        }
        $response['status']                   = "SUCCESS";
        $response['message']                  = $addSuccessMsg;
        $response['requestKey']               = "adduser";
        $response["adduser"]['user_id']      = $insert;
        $response["adduser"]['name']         = $result[0]['name'];
        $response["adduser"]['email']        = $result[0]['email'];
        $response["adduser"]['mobile']       = $result[0]['mobile'];
         $response["adduser"]['country_code'] = $result[0]['country_code'];
        $response["adduser"]['dob']          = date('d-m-Y',strtotime($result[0]['dob']));
        $response["adduser"]['image']       = $result[0]['image'];
        $response["adduser"]['gender']       = $result[0]['gender'];
        $response["adduser"]['address']      = $result[0]['address'];
        $response["adduser"]['address_detail']  = $result[0]['address_detail'];
        $response["adduser"]['office_address']  = $result[0]['office_address'];
        $response["adduser"]['token']        =  $result[0]['token'];
         echo json_encode($response);die;
       
     }
   }
    elseif ($signup_type=='facebook') //facebook signup
    {
    //  echo "string";die;
    $cond = array('email'=> $this->input->post('email'),'type' =>$signup_type);
    $fb_signup =  $this->user_model->getCondResultArray(USER,'id',$cond);
    if(!$fb_signup)
    {
       $token = $this->user_model->getToken();
       // echo "token".$fb_signup[0];die;

                 $fbData = [
                    'name'        => $this->input->post('name'),
                    'email'       => $this->input->post('email'),
                    'mobile'      => $this->input->post('mobile'),
                    'country_code'    => $this->input->post('country_code'),
                    'type' => $signup_type,
                    'token' => $token,
                    'social_token' => $this->input->post('socialToken'),
                    'image' => $this->input->post('profilePic'),
                    'status' => '1',
                     'notification_status' =>'on',
                    'device_type'  => $this->input->post('device_type'),
                    'device_token' => $this->input->post('device_token'),
                     'latitude'     => $this->input->post('latitude'),
                    'longitude'     => $this->input->post('longitude'),
                ];



       
             $insertid =   $this->my_model->insert_data(USER,$fbData);
             $getData =   $this->user_model->fieldCondRow(USER,'id,name,email,type,token,mobile,country_code,image,gender,address,address_detail',array('id'=>$insertid));
             if($language_type=='en'){
               $userDetailMsg = 'user detail seen successfully.'; 
             }else if($language_type=='hi'){
              $userDetailMsg = 'उपयोगकर्ता विवरण सफलतापूर्वक देखा गया है।';   
             }
             $response = ['fb_signup' => $getData,'message'=>$userDetailMsg, 'status' => "SUCCESS"];
             echo json_encode($response);die;
    }
    // else
    // {
    //   $getData =   $this->user_model->fieldCondRow(USER,'id,name,email,type,token,mobile,image,gender,address,address_detail',array('id'=>$fb_signup[0]['id']));
    //   $response = ['fb_signup' => $getData,'message'=>'user detail seen successfully', 'status' => "SUCCESS"];
    //   echo json_encode($response);die;
    // }
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
                    'name'          => $this->input->post('name'),
                    'email'         => $this->input->post('email'),
                     'mobile'       => $this->input->post('mobile'),
                     'country_code'    => $this->input->post('country_code'),
                    'type'          => $signup_type,
                    'token'         => $token,
                    'social_token'  => $this->input->post('socialToken'),
                    'image'         => $this->input->post('profilePic'),
                    'status'        => '1',
                     'notification_status' =>'on',
                    'device_type'   => $this->input->post('device_type'),
                    'device_token'  => $this->input->post('device_token'),
                     'latitude'     => $this->input->post('latitude'),
                    'longitude'     => $this->input->post('longitude'),
                ];

       




                
             $insertid =   $this->my_model->insert_data(USER,$googleData);
            // echo $this->db->last_query();
             $getData =   $this->user_model->fieldCondRow(USER,'id,name,email,type,token,mobile,country_code,image,gender,address,token',array('id'=>$insertid));
              if($language_type=='en'){
               $userDetailMsg = 'user detail seen successfully.'; 
             }else if($language_type=='hi'){
              $userDetailMsg = 'उपयोगकर्ता विवरण सफलतापूर्वक देखा गया है।';   
             }
             $response = ['google_signup' => $getData,'message'=>$userDetailMsg, 'status' => "SUCCESS"];
             echo json_encode($response);die;

    }
      {
    //  $getData =   $this->user_model->fieldCondRow(USER,'id,name,email,type,token,mobile,image,gender,address,address_detail',array('id'=>$google_signup[0]['id']));
     // $response = ['google_signup' => $getData,'message'=>'user detail seen successfully.', 'status' => "SUCCESS"];
      //echo json_encode($response);die;
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
      $checkEmail  =    $this->user_model->getCondResult(USER,'id',array('email'=>$email));
      $checkMobile  =    $this->user_model->getCondResult(USER,'id',array('mobile'=>$mobile));
      $language_type = $this->input->post('language_type');

      //doctor
     // $doctorEmail  =    $this->user_model->getCondResult(DOCTOR,'id',array('email'=>$email));
     // $doctorMobile  =    $this->user_model->getCondResult(DOCTOR,'id',array('mobile'=>$mobile));
      
      if($checkEmail)
      {

         $response['status']  = "FAILURE";
         if($language_type=='en'){
         $response['message'] = 'Email Id already exists.';
          }else if($language_type=='hi'){
         $response['message'] = 'ईमेल आईडी पहले से मौजूद है।';
          }
         $response['requestKey'] = "checkEmail";
         echo json_encode($response);
      }else
      {
         
      if($checkMobile)
      {
         $response['status']  = "FAILURE";
         if($language_type=='en'){
         $response['message'] = 'Mobile Number already exists.';
         }else if($language_type=='hi'){
         $response['message'] = 'मोबाइल नंबर पहले से मौजूद है।'; 
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

      //}
      //}
}
  
 //Check Social Token
  function checkSocialToken()
   {
      $token  = $this->input->post('socialToken');
      $device_type =  $this->input->post('device_type');
      $device_token =  $this->input->post('device_token');
     
      
      $checkSocialToken  =  $this->user_model->getCondResult(USER,'id,name,email,mobile,country_code,dob,gender,address,image,address_detail,token,office_address',array('social_token'=>$token));
    

     
      if($checkSocialToken)
      {
        $tkn = $this->user_model->getToken();  
         $this->user_model->update_data(USER,array('token'=>$tkn,'device_type'=>$device_type,'device_token'=>$device_token),array('id'=>$checkSocialToken[0]->id));
         $response['status']  = "FAILURE";
         $response['message'] = 'Social Token already exists.';
        // $response['requestKey'] = "checkEmail";

            $response["userdetial"]['id']                 = $checkSocialToken[0]->id;
            $response["userdetial"]['name']               = $checkSocialToken[0]->name;
            $response["userdetial"]['email']              = $checkSocialToken[0]->email;
            $response["userdetial"]['mobile']             = $checkSocialToken[0]->mobile;
            $response["userdetial"]['country_code']       = $checkSocialToken[0]->country_code;
            $response["userdetial"]['dob']                = $checkSocialToken[0]->dob;
            $response["userdetial"]['image']              = $checkSocialToken[0]->image;
            $response["userdetial"]['gender']             = $checkSocialToken[0]->gender;
            $response["userdetial"]['address']            = $checkSocialToken[0]->address;
            $response["userdetial"]['address_detail']     = $checkSocialToken[0]->address_detail;
             $response["userdetial"]['office_address']     = $checkSocialToken[0]->office_address;
            $response["userdetial"]['token']              =  $tkn;
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
     $office_address  = $this->input->post('office_address');
     $token    = $this->input->post('token');
     $language_type = $this->input->post('language_type');
     
      $address = $this->input->post('address');
      if(!empty($address))
      {
      $res = $this->user_model->getLatLong($address);
      $latitude =  $res['latitude'];
      $longitude =  $res['longitude'];
      }

    $checkToken = $this->user_model->getCondResultArray(USER,'id,name,email,mobile,dob,gender,address,language_type',array('token'=>$token));
    if($checkToken)
    {
     //$language_type = $checkToken[0]['language_type'];
    //start upload iamge
        $imgArr =array();
      if (!empty($_FILES['image']['name'])) {
         // print_r($_FILES['image']['name']);die;
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
                        'name'                  => $this->input->post('name'),
                        'email'                 => $this->input->post('email'),
                       // 'password'            => $pass,
                        'mobile'                => $this->input->post('mobile'),
                        'country_code'          => $this->input->post('country_code'),
                        'dob'                   => date('Y-m-d',strtotime($this->input->post('dob'))),
                        'gender'                => $this->input->post('gender'),
                        'address'               => $this->input->post('address'),
                        'address_latitude'      => $latitude,
                        'address_longitude'     => $longitude,
                        'address_detail'        =>  $this->input->post('address_detail'),
                        'office_address'        => $office_address ,
                       // 'status'              => '1',
                        'updated_date'          => date('Y-m-d h:i:s'),
                       );
     $finalArr = array_merge($imgArr,$userData);
    // echo "<pre>";
    // print_r($finalArr);die;

     if (empty($userData['name'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please enter Full name';
             }else if($language_type=='hi'){
              $response['message'] = 'कृपया पूरा नाम दर्ज करें';  
             }
            $response['requestKey'] = "updateProfile";
            echo json_encode($response);die;
        }

        if (empty($userData['email'])) {
            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please enter Email ID';
             }else if($language_type=='hi'){
                $response['message']    = 'कृपया ईमेल आईडी दर्ज करें'; 
             }
            $response['requestKey'] = "updateProfile";
            echo json_encode($response);die;
        }

         


        if (!is_numeric($userData['mobile'])) {
            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please enter valid Phone number';
             }else if($language_type=='hi'){
              $response['message']    = 'कृपया एक वैध नंबर डालें';  
             }
            $response['requestKey'] = "updateProfile";
            echo json_encode($response);die;
        }

        if (empty($userData['mobile'])) {

            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please enter Phone number';
             }else if($language_type=='hi'){
             $response['message']    = 'कृपया फ़ोन नंबर दर्ज करें';  
             }
            $response['requestKey'] = "updateProfile";
            echo json_encode($response);die;
        }

        if (empty($userData['dob'])) {

            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please enter DOB';
             }else if($language_type=='hi'){
             $response['message']    = 'कृपया DOB दर्ज करें'; 
             }
            $response['requestKey'] = "adduser";
            echo json_encode($response);die;
        }


         if (empty($userData['address'])) {

            $response['status']     = "FAILURE";
            if($language_type=='en'){
            $response['message']    = 'Please enter address';
             }else if($language_type=='hi'){
             $response['message']    = 'कृपया पता दर्ज करें';   
             }
            $response['requestKey'] = "adduser";
            echo json_encode($response);die;

        }


   

     $update =  $this->user_model->update_data(USER,$finalArr,array('id'=>$checkToken[0]['id']));
    $userDetail =  $this->user_model->getCondResultArray(USER,'id,name,image',array('id'=>$checkToken[0]['id']));
     if($update)
     {
        $response['status']              = "SUCCESS";
        if($language_type=='en'){
         $response['message']             = 'User edit Successfully';
         }else if($language_type=='hi'){
          $response['message']             = 'उपयोगकर्ता ने विवरण को सफलतापूर्वक संपादित किया है';
         }
        $response['requestKey']          = "updateProfile";
        $response["updateProfile"]['id'] = $userDetail[0]['id'];
        $response["updateProfile"]['name'] = $userDetail[0]['name'];
        $response["updateProfile"]['image'] = $userDetail[0]['image'];
       
     }
      echo json_encode($response);die;
  }
  else
  {         
           // if($language_type=='en'){
            $errors = "token mismatch ...Please logOut.";
             // }else if($language_type=='hi'){
             //  $errors = "टोकन मिसमैच ... कृपया लॉगआउट करें।";  
             // }
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
        $language_type = $this->input->post('language_type');
        $result = $this->user_model->getCondResultArray(USER,'id,name,email,mobile,country_code,dob,gender,address,address_detail,image,office_address',array('token'=>$token));
        if($result)
        {
            if($result[0]['dob']=='0000-00-00' || $result[0]['dob']=='')
            {
                $dob = '0000-00-00';
            }else
            {
                $dob = date('d-m-Y',strtotime($result[0]['dob']));
            }
            if($language_type =='en')
            {
              $msg = 'Users Data seen successfully';  
            }else if($language_type=='hi'){
              $msg = 'उपयोगकर्ता डेटा सफलतापूर्वक देखा गया';    
            }
            $response['status']                           = "SUCCESS";
            $response['message']                         = $msg;
            $response['requestKey']                     = "userProfile";
            $response["userProfile"]['id']              = $result[0]['id'];
            $response["userProfile"]['name']            = $result[0]['name'];
            $response["userProfile"]['email']           = $result[0]['email'];
            $response["userProfile"]['mobile']          = $result[0]['mobile'];
             $response["userProfile"]['country_code']   = $result[0]['country_code'];
            $response["userProfile"]['dob']             = $dob;
            $response["userProfile"]['gender']          = $result[0]['gender'];
            $response["userProfile"]['address']         = $result[0]['address'];
            $response["userProfile"]['address_detail']  = $result[0]['address_detail'];
            $response["userProfile"]['office_address']  = $result[0]['office_address'];
           // $response["response"]['image']        =  base_url('user_profile/'.$result[0]['image']);
            $response["userProfile"]['image']           = $result[0]['image'];
            echo json_encode($response);die;

        }
        else
        {
            //if($language_type=='en'){
            $errors = "token mismatch ...Please logOut.";
             // }else if($language_type=='hi'){
             //  $errors = "टोकन मिसमैच ... कृपया लॉगआउट करें।";  
             // }
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

  


function changePassword()
   {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
    {
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

  $checkToken = $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
  $user_id = $checkToken[0]['id'];
  if($checkToken){

  if (empty($oldpass)) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter current password";
             }else if($language_type=='hi'){
            $response['message'] = "कृपया वर्तमान पासवर्ड दर्ज करें"; 
             }
            $response['requestKey'] = "changePassword";
            echo json_encode($response);die;
        }

   if (empty($newpass)) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter new password";
             }else if($language_type=='hi'){
               $response['message'] = "कृपया नया पासवर्ड दर्ज करें"; 
             }
            $response['requestKey'] = "changePassword";
            echo json_encode($response);die;
        }

        if (empty($conpass)) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter confirm password";
             }else if($language_type=='hi'){
              $response['message'] = "कृपया पुष्टि पासवर्ड दर्ज करें";  
             }
            $response['requestKey'] = "changePassword";
            echo json_encode($response);die;
        }

       

   
    if($newpass != $conpass)    
    { 
               $response['status']     = "FAILURE";
                if($language_type=='en'){
                $response['message']    = "New Password and Confirm Password does not match";
               }else if($language_type=='hi'){
                  $response['message']    = "नया पासवर्ड और कन्फर्म पासवर्ड मेल नहीं खाते हैं";
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
   $passwordFound = $this->user_model->getCondResultArray(USER,'password',array('id'=>$user_id,'password'=>md5($oldpass)));
    if($passwordFound)
    {

    
    $new_pass=md5($newpass);
   

    
      
      $updatedata=array("password"=>$new_pass);
     
      $update=$this->my_model->update_data(USER,array('id'=>$user_id),$updatedata);
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
            $response['message']    = "Current Password is incorrect";
             }else if($language_type=='hi')
             {
               $response['message']    = "मौजूदा पासवर्ड गलत है"; 
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
    $language_type = $this->input->post('language_type');
    $con =array('mobile'=>$mobile );
    $fields = "id,name,email";
    $user=$this->my_model->getfields(USER,$fields,$con);
 
  
  if(!empty($user)){
   $name         = ucfirst($user[0]->name);
   $email        = $user[0]->email;
  
   $otp = rand(1000, 9999);
 
   $this->my_model->update_data(USER,array('mobile' =>$mobile),array('confirm_code'=>$otp));
   
  
    
      // $getResponse = file_get_contents("https://www.smsgatewayhub.com/api/mt/SendSMS?APIKey=K0IbqH3mHE2PAyuTBlUipA&senderid=EDUIAP&channel=2&DCS=0&flashsms=0&number=" . $mobile . "&text=Your%20verification%20code%20is%20" . $otp . ".&route=13");
    
            $errors = "Mobile number is registered.";
            $response = ['message' => $errors, 'status' => "SUCCESS"];
    
    }
    else{
            if($language_type=='en'){
            $errors = "Mobile number is not registered.";
             }else if($language_type=='hi'){
            $errors = "मोबाइल नंबर पंजीकृत नहीं है।"; 
             }
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
  $language_type = $this->input->post('language_type');
  $mobile = $this->input->post('mobile');
   if (empty($mobile)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Please enter mobile no';
           // $response['requestKey'] = "updatepassword";
            echo json_encode($response);die;
        }

  // $checkOtpToken = $this->user_model->getCondResultArray(USER,'id',array('mobi'=>$otp));
  // if($checkOtpToken){

 
   if (empty($newpass)) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter New Password";
             }else if($language_type=='hi'){
              $response['message'] = "कृपया नया पासवर्ड दर्ज करें";  
             }
          //  $response['requestKey'] = "updatepassword";
            echo json_encode($response);die;
        }

        if (empty($conpass)) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please enter confirm Password';
             }else if($language_type=='hi')
             {
              $response['message'] = 'कृपया पासवर्ड दर्ज करें';  
             }
           // $response['requestKey'] = "updatepassword";
            echo json_encode($response);die;
        }

   
    if($newpass != $conpass)    
    { 
         $response['status']  = "FAILURE";
         if($language_type=='en'){
            $response['message'] = "New Password and Confirm Password does not match";
             }else if($language_type=='hi'){
            $response['message'] = "नया पासवर्ड और पुष्टि पासवर्ड मैच नहीं कर रहा है"; 
             }
          //  $response['requestKey'] = "updatepassword";
            echo json_encode($response);die;
          
    }

    
    $new_pass=md5($newpass);
    $con_pass=md5($conpass);

    
      $con=array("mobile"=>$mobile);
      $updatedata=array("password"=>$new_pass);
     
      $update=$this->my_model->update_data(USER,$con,$updatedata);
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
 //           // $response['requestKey'] = "updatepassword";

 //            echo json_encode($response);
 // }
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
        $language_type = $this->input->post('language_type');
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
            if($language_type=='en'){
            $response['message'] = "Please enter member name";
             }else if($language_type=='hi'){
             $response['message'] = "कृपया सदस्य का नाम दर्ज करें";   
             }
            $response['requestKey'] = "addMember";
            echo json_encode($response);die;
        }  
        
          if (empty($this->input->post('dob'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please select Date of birth";
             }else if($language_type=='hi'){
             $response['message'] = "कृपया जन्म तिथि का चयन करें";  
             }
            $response['requestKey'] = "addMember";
            echo json_encode($response);die;
        }  
        
         if (empty($this->input->post('gender'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please select gender";
             }else if($language_type=='hi'){
               $response['message'] = "कृपया लिंग चुनें";  
             }
            $response['requestKey'] = "addMember";
            echo json_encode($response);die;
        }  
   
     if (empty($memberData['relationship'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please select relationship";
             }else if($language_type=='hi'){
              $response['message'] = "कृपया संबंध चुनें";   
             }
            $response['requestKey'] = "addMember";
            echo json_encode($response);die;
        }  
        
         $insert = $this->my_model->insert_data('user_member',$memberData);

          $response['status']              = "SUCCESS";
          if($language_type=='en'){
          $response['message']             = 'User member added Successfully';
           }else if($language_type=='hi'){
            $response['message']             = 'उपयोगकर्ता सदस्य सफलतापूर्वक जोड़ा गया';
           }
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
         $language_type = $this->input->post('language_type');
        $checkToken = $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
          if($checkToken)
        {
        $member = $this->user_model->getCondResultArray('user_member','id,name,dob,gender,relationship,image',array('user_id'=>$checkToken[0]['id']));
        if($member){
      

            if($language_type=='en'){
                $msg = 'Users Member seen successfully';
            }else if($language_type=='hi'){
               $msg = 'उपयोगकर्ता सदस्य सफलतापूर्वक देखे गए'; 
            }
         
            $response = [ 'status' => "SUCCESS",'message'=>$msg,'memberList' => $member];
            echo json_encode($response);die;
          }
          else
        {
            $response['status']     = "SUCCESS";
            if($language_type=='en'){
            $response['message']    = 'No member list found this user id';
             }else if($language_type=='hi'){
               $response['message']    = 'कोई सदस्य नहीं मिला';  
             }
            $response['requestKey'] = "memberList";
            echo json_encode($response);
        }

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
        $language_type = $this->input->post('language_type');
        $result = $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
        if($result)
        {
         $member = $this->user_model->getCondResultArray('user_member','id,name,dob,gender,relationship,image',array('id'=>$member_id,'user_id'=>$result[0]['id']));
         //echo $this->db->last_query();die;
            $response['status']                      = "SUCCESS";
            if($language_type=='en'){
            $response['message']                     = 'Member Data seen successfully';
             }else if($language_type=='hi'){
              $response['message']                     = 'उपयोगकर्ता सदस्य सफलतापूर्वक देखे गए';  
             }
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
        $language_type = $this->input->post('language_type');

         if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            $response['requestKey'] = "editProfile";
            echo json_encode($response);die;
        }  

        if (empty($member_id)) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please enter Full name';
             }else if($language_type=='hi'){
               $response['message'] = 'कृपया पूरा नाम दर्ज करें';  
             }
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
        
         if (empty($memberData['name'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter member name";
             }else if($language_type=='hi'){
              $response['message'] = "कृपया सदस्य का नाम दर्ज करें";  
             }
            $response['requestKey'] = "addMember";
            echo json_encode($response);die;
        }  
        
          if (empty($this->input->post('dob'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please select Date of birth";
             }else if($language_type=='hi'){
                $response['message'] = "कृपया जन्म तिथि का चयन करें"; 
             }
            $response['requestKey'] = "addMember";
            echo json_encode($response);die;
        }  
        
         if (empty($memberData['gender'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please select gender";
         }else if($language_type=='hi'){
            $response['message'] = "कृपया लिंग चुनें"; 
         }
            $response['requestKey'] = "addMember";
            echo json_encode($response);die;
        }  
   
     if (empty($memberData['relationship'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please select relationship";
             }else if($language_type=='hi'){
               $response['message'] = "कृपया संबंध चुनें";  
             }
            $response['requestKey'] = "addMember";
            echo json_encode($response);die;
        }  

        
         $insert = $this->my_model->update_data('user_member',array('user_id'=>$result[0]['id'],'id'=>$member_id),$finalArr);
        // echo $this->db->last_query();die;

          $response['status']              = "SUCCESS";
          if($language_type=='en'){
          $response['message']             = 'User member edit Successfully';
           }else if($language_type=='hi'){
             $response['message']             = 'उपयोगकर्ता सदस्य सफलतापूर्वक संपादित करें';
           }
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
         $language_type = $this->input->post('language_type');

          if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            $response['requestKey'] = "editProfile";
            echo json_encode($response);die;
        }  
        $member_id = $this->input->post('member_id');


        $result = $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
        if($result)
        { 

             if (empty($member_id)) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Member id  is empty';
        }else if($language_type=='hi'){
            $response['message'] = 'कोई सदस्य उपलब्ध नहीं है';
        }
            $response['requestKey'] = "deleteMember";
            echo json_encode($response);die;
        }  

          $delete =   $this->user_model->deleteRow('user_member',array('user_id'=>$result[0][id],'id'=>$member_id));
          $response['status']              = "SUCCESS";
          if($language_type=='en'){
          $response['message']             = 'User member delete Successfully';
           }else if($language_type=='hi'){
            $response['message']             = 'सदस्य को सफलतापूर्वक हटा दिया गया';
           }
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
        $language_type = $this->input->post('language_type');
       $userTokenCheck =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
       // if($result)
        if($userTokenCheck) {
        $userLogout = $this->user_model->update_data(USER,array('token'=>'','login_status'=>'0','device_token'=>''),array('id'=>$userTokenCheck[0]['id']));
    
            if($userLogout) {
                if($language_type=='en'){
                $msg = 'Logout successfully';
                }else if($language_type=='hi'){
                 $msg = 'सफलतापूर्वक लॉग आउट किया गया';
                }
                $response = ['message' => $msg, 'status' => "SUCCESS"];
     
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
   //this is old api for search
   function searchDoctor1()
   {
    $doctor_type = trim($this->input->post('doctor_type'));
    $token = $this->input->post('token');
    $language_type = $this->input->post('language_type');

     if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
           // $response['requestKey'] = "updatepassword";
            echo json_encode($response);die;
        } 
    if (empty($doctor_type)) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please select Doctor Type';
        }else if($language_type=='hi'){
            $response['message'] = 'कृपया डॉक्टर के प्रकार का चयन करें';
        }
           // $response['requestKey'] = "updatepassword";
            echo json_encode($response);die;
        } 

 
       $user = $this->user_model->getCondResultArray(USER,'id,latitude,longitude,address,office_address',array('token'=>$token));
       $latitude = $user[0]['latitude'];
       $longitude  = $user[0]['longitude'];
       $user_id = $user[0]['id'];
      
    //this query is used to get near by doctor through user lat long
    $result =  $this->db->query("select id,name,mobile,email,specialty,license_no,experience,month,clinic_name,distance,available_status,image,qualification,frees,( 3959 * acos( cos( radians($latitude) ) * cos( radians(latitude) ) * cos( radians(longitude ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians(latitude) ) ) ) AS distance from doctor_doctor where status='1'  and specialty= '".$doctor_type."' HAVING distance < 20")->result_array();
    


     if($user[0]['address'])
     {
      $homeAdd = $user[0]['address'];
     }else{
      $homeAdd = "";
     }

     if($user[0]['office_address'])
     {
      $officeAdd = $user[0]['office_address'];
     }else
     {
      $officeAdd = " ";
     }

     //check booking 
     $checkUserBooking =  $this->user_model->getCondResultArray(BOOKING,'id',array('user_id'=>$user_id));
     $Promocode =  $this->user_model->fieldCRow('doctor_promocode','id,promo_code,validity,offer_discount,location',array('status'=>'1'));
     if($checkUserBooking)
     {
      $checkBooking = "1";
     }else{
      $checkBooking = "0";
     }

   // echo $this->db->last_query();die;
    if($result){
      foreach($result as $values){

         if($home['month'])
           {
               $month = $home['month'];
           }else
        {
              $month = "";
          }

     //check rating
      $doctorRating =  $this->user_model->AvgRating('doctor_rating',array('doctor_id'=>$home['id']));
      if($doctorRating->rate)
     {
      $rate = round($doctorRating->rate,1);
     }else
     {
      $rate = 5;
     }

      $specialtyName =  $this->user_model->fieldCondRow('specility','name,hi_name',array('id'=>$values['specialty']));
     if($language_type=='en'){
        $speName = $specialtyName->name;
     }else if($language_type=='hi'){
       $speName = $specialtyName->hi_name; 
     }

      
         $resultArr[] = array(
                              'id' => $values['id'], 
                              'name' => $values['name'],  
                              'mobile' => $values['mobile'],  
                              'email' => $values['email'],  
                              'specialty' => $speName,  
                              'license_no' => $values['license_no'],  
                              'experience' => $values['experience'],  
                              'month' => $month,   
                              'clinic_name' => $values['clinic_name'], 
                              'distance' => $values['distance'], 
                              'image' => $values['image'], 
                              'qualification' => $values['qualification'],
                               'frees' => $values['frees'], 
                               'home_address'=> $homeAdd,
                               'office_address' => $officeAdd, 
                               'available_status'=> $values['available_status'],
                               'rating' => "$rate",
                            );
     }
     if($language_type=='en'){
        $msg = 'search record show successfully.';
     }else if($language_type=='hi'){
        $msg = 'रिकॉर्ड सफलतापूर्वक दिखाया गया है';
     }
     $response = [ 'status' => "SUCCESS",'message'=>$msg,'checkBooking'=>$checkBooking,'promocode'=>$Promocode,'doctorListing' => $resultArr];
    }else
    {
        if($language_type=='en'){
       $errors = "No record found.";
     }else if($language_type){
       $errors = "कोई रिकॉर्ड नहीं मिला"; 
     }
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
          date_default_timezone_set('Asia/Calcutta'); 

            $bookingData = array(

                                   'doctor_id'      => $this->input->post('doctor_id'),
                                   'user_id'        => $user_id,
                                   'address_type'   => $this->input->post('address_type'),
                                   'address'        => $this->input->post('address'),
                                   'promocode'      => $this->input->post('promocode'),
                                   'frees'          => $this->input->post('frees'),
                                   'member_name'    => $this->input->post('member_name'),
                                   'member_id'      => $this->input->post('member_id'),
                                   'reason_visit'   => $this->input->post('reason_visit'),
                                   'status'         => '1',
                                   'booking_status' =>'0',
                                   'booking_type'   => 'home',
                                  // 'session_status'=>'0',
                                   'created_date'  => date('Y-m-d H:i:s')
                                 );

    if (empty($bookingData['address_type'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Please select address type';
            echo json_encode($response);die;
        } 

        if (empty($bookingData['address'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Please enter address';
            echo json_encode($response);die;
        }  

         if (empty($bookingData['doctor_id'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Doctor id  is empty';
            echo json_encode($response);die;
        }  


         if (empty($bookingData['reason_visit'])) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Please enter reason for visit';
            echo json_encode($response);die;
        }  
        
    //check doctor is avialabe or not
    $doctorAvialableDay = $this->user_model->fetchValue(DOCTOR,'home_visit_days',array('id'=>$bookingData['doctor_id']));
    $doctorDaysArr = explode(',',$doctorAvialableDay);
  // echo  print_r($doctorDaysArr);
    $todayDate = date('Y-m-d');
    $dayName = date('D', strtotime($todayDate));

if($dayName=="Sun")
{
 $day = "7";
}

if($dayName=="Mon")
{
 $day = "1";
}

if($dayName=="Tue")
{
 $day = "2";
}

if($dayName=="Wed")
{
 $day = "3";
}

if($dayName=="Thu")
{
 $day = "4";
}
if($dayName=="Fri")
{
 $day = "5";
}
if($dayName=="Sat")
{
 $day = "6";
}

if(!in_array($day,$doctorDaysArr))
{
       $response['status']              = "FAILURE";
       $response['message']             = 'Doctor is not available now';
       echo json_encode($response);die;
}

//echo $day;
    //end of doctor days avialable

     $insert =  $this->my_model->insert_data('doctor_booking',$bookingData);
    // echo $this->db->last_query();die;
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
        $language_type = $this->input->post('language_type');

         if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        } 
        $result = $this->user_model->getCondResultArray(USER,'id,name,address',array('token'=>$token));
        $user_id = $result[0]['id'];
        $username = $result[0]['name'];
        $userAddress = $result[0]['address'];
        $doctorId = $this->input->post('doctor_id');
        if($result)
        { 

          //calaculate eta time here
            $doctorDetail = $this->user_model->fieldCRow('doctor_doctor','address',array('id'=>$doctorId));
            $doctorAdd = $doctorDetail->address;
           $timeDuration  = $this->user_model->getTime($userAddress,$doctorAdd);
           $time =  $timeDuration->rows[0]->elements[0]->duration->text;

        $checkBooking = $this->user_model->fieldCondRow1(BOOKING,'id,eta_time',array('doctor_id'=>$doctorId,'booking_type'=>'call'));
        if($checkBooking){
             $getDoctorEta = $checkBooking->eta_time;
             $etaTime = $time+$getDoctorEta+30;
           }else
           {
            $etaTime = $time+30;
           }
          //end eta time  
            $bookingData = array(

                                   'doctor_id'      => $doctorId,
                                   'user_id'        => $user_id,
                                   'booking_type'   => 'call',
                                   'eta_time'       => $etaTime,
                                  // 'address_type'   => $this->input->post('address_type'),
                                   //'address'        => $this->input->post('address'),
                                   'promocode'      => $this->input->post('promocode'),   //optional
                                   'frees'          => $this->input->post('frees'),
                                   'member_name'    => $this->input->post('member_name'),
                                   'member_id'      => $this->input->post('member_id'),
                                   'reason_visit'   => $this->input->post('reason_visit'),
                                   'status'         => '1',
                                   'booking_status'  =>'0',
                                   'session_status' =>'0',
                                   'created_date'   => date('Y-m-d H:i:s')
                                 );

             if (empty($bookingData['doctor_id'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Doctor id  is empty';
        }else if($language_type=='hi'){
           $response['message'] = 'डॉक्टर आईडी खाली है'; 
        }
            echo json_encode($response);die;
        }   

         if (empty($bookingData['reason_visit'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please enter reason for call';
             }else if($language_type=='hi'){
               $response['message'] = 'कृपया कॉल करने का कारण दर्ज करें';  
             }
            echo json_encode($response);die;
        } 


        //check promocode
if(!empty($this->input->post('promocode'))){
 $checkBooking = $this->user_model->getCondResultArray(BOOKING,'id',array('user_id'=>$user_id)); 
if(!$checkBooking){ 
$checkPromo = $this->user_model->getCondResultArray('doctor_promocode','promo_code,validity',array('promo_code'=>$this->input->post('promocode')));
$ExpDate = $checkPromo[0]['validity'];
$todayDate = date('Y-m-d');
if(!$checkPromo)
{
  $response['status']              = "FAILURE";
  if($language_type=='en'){
  $response['message']             = 'Please enter a valid promotional or Voucher Code.';
   }else if($language_type=='hi'){
     $response['message']             = 'कृपया एक वैध प्रचारक या वाउचर कोड दर्ज करें।';
   }
  echo json_encode($response);die;
}

if($todayDate>$ExpDate)
{
  $response['status']              = "FAILURE";
  if($language_type=='en'){
  $response['message']             = 'Expired promotional or Voucher Code.';
   }else if($language_type=='hi'){
    $response['message']             = 'प्रचारित प्रचार या वाउचर कोड।';
   }
  echo json_encode($response);die;
}
}
else
{
  //specific Booking check here 
  //check this promocode is exit or not
  $chekPromoExit = $this->user_model->getCondResultArray(BOOKING,'id',array('promocode'=>$this->input->post('promocode'),'user_id'=>$user_id));
  if(!empty($chekPromoExit))
  {
    $response['status']              = "FAILURE";
    if($language_type=='en'){
  $response['message']             = 'This promocode is already used.';
   }else if($language_type=='hi'){
    $response['message']             = 'यह प्रोमोकोड पहले से ही इस्तेमाल किया गया है।';
   }
 echo json_encode($response);die;
  }
  //end check promocode  
$checkPromo = $this->user_model->getCondResultArray('doctor_specificpromo','promocode,validity',array('promocode'=>$this->input->post('promocode'),'doctor_id'=>$doctorId));
//echo $this->db->last_query();die;
$ExpDate = $checkPromo[0]['validity'];
$todayDate = date('Y-m-d');
if(!$checkPromo)
{
  $response['status']              = "FAILURE";
  if($language_type=='en'){
  $response['message']             = 'Please enter a valid promotional or Voucher Code.';
   }else if($language_type=='hi'){
    $response['message']             = 'कृपया एक वैध प्रचारक या वाउचर कोड दर्ज करें।';
   }
  echo json_encode($response);die;
}

if($todayDate>$ExpDate)
{
  $response['status']              = "FAILURE";
  if($language_type=='en'){
  $response['message']             = 'Expire promotional or Voucher Code.';
   }else if($language_type=='hi'){
    $response['message']             = 'प्रोमोशनल या वाउचर कोड समाप्त हो गया है।';
   }
  echo json_encode($response);die;
}
}
} 
        
          //check doctor is avialabe or not
    $doctorAvialableDay = $this->user_model->fetchValue(DOCTOR,'call_visit_days',array('id'=>$bookingData['doctor_id']));
    $doctorDaysArr = explode(',',$doctorAvialableDay);
   // print_r($doctorDaysArr);die;
    $date = date('Y-m-d');
    $dayName = date('D', strtotime($date));

if($dayName=="Sun")
{
 $day = "7";
}

if($dayName=="Mon")
{
 $day = "1";
}

if($dayName=="Tue")
{
 $day = "2";
}

if($dayName=="Wed")
{
 $day = "3";
}

if($dayName=="Thu")
{
 $day = "4";
}
if($dayName=="Fri")
{
 $day = "5";
}
if($dayName=="Sat")
{
 $day = "6";
}

if(!in_array($day,$doctorDaysArr))
{
       $response['status']              = "FAILURE";
       if($language_type=='en'){
       $response['message']             = 'Doctor is not available now';
        }else if($language_type=='hi'){
          $response['message']           = 'अभी डॉक्टर उपलब्ध नहीं है';   
        }
       echo json_encode($response);die;
}

//check here user cant book till 30 min
 $date = date('Y-m-d');
 $checkUserBooking = $this->db->query("select id,created_date from doctor_booking where user_id = $user_id && created_date like  '$date%' && booking_status != 5 && booking_type = 'call' order by id DESC ")->result();
 //echo $this->db->last_query();die;
 if($checkUserBooking)
         {
         $time = date('H:i',strtotime($checkUserBooking[0]->created_date));
         $currentTime = date('H:i');


      //echo  date('H:i',strtotime("1:30 PM"));die;
             $after30minTime = date("H:i", strtotime('+30 minutes', strtotime($time)));
             $datetime1 = strtotime($time);
             $datetime2 = strtotime($currentTime);
             $interval  = abs($datetime2 - $datetime1);
             $minutes   = round($interval / 60);
          // echo  'Diff. in minutes is: '.$minutes; die; 
             if($minutes<=30)
           {
            $response['status']  = "FAILURE";
           // $response['message'] = 'Provider is busy form '.date('h:i a',strtotime($time)).' to '.date('h:i a',strtotime($afterTwoHoursTime));
            
             // $response['message'] = "Service Provider is not available this time,please book after ".date('h:i A',strtotime('+2 hours', strtotime($time)))
            $response['message']  = "You have already done a booking. Please wait for 30 mins to book another appointment";
            echo json_encode($response);die;
           }  
          }
//end check

//echo $day;
    //end of doctor days avialable

    $doctorDetails = $this->user_model->getCondResultArray(DOCTOR,'id,device_token,device_type,notification_status,language_type',array('id'=>$bookingData['doctor_id']));
     $device_token = $doctorDetails[0]['device_token'];
     $device_type = $doctorDetails[0]['device_type'];
     $notification_status = $doctorDetails[0]['notification_status'];
     $language_type1 = $doctorDetails[0]['language_type'];
     $insert =  $this->my_model->insert_data('doctor_booking',$bookingData);
       if($insert)
     {
   //  echo $this->db->last_query();die;
     //send notification start
      if($notification_status=="on"){  //check notification status
        $booking_id = $insert;
        if($language_type1=='en'){
        $message = "You have a new booking request";
        $title = "You have a new booking request";
         }else if($language_type1=='hi'){
           $message = "आपको एक नया बुकिंग अनुरोध प्राप्त हुआ है";
           $title = "आपको एक नया बुकिंग अनुरोध प्राप्त हुआ है";
         }
        $type = 'addbooking';
        $notificationData = array(
                                  'user_id'=> $user_id,
                                  'doctor_id'=> $this->input->post('doctor_id'),
                                  'booking_id'=> $booking_id,
                                  'title'=> $title,
                                  'message'=> $message,
                                  'type'   => $type,
                                  'status'=>'0',
                                  'badge_count'=>'1',
                                  'send_to'=>'doctor',
                                 // 'status'=>'1',
                                  'created_date'=> date('Y-m-d H:i:s'),
                                 );
      $notificationId =  $this->user_model->insert_data('notification',$notificationData); 
     $notificationCount = count($this->user_model->getCondResult('notification','id',array('doctor_id'=>$this->input->post('doctor_id'),'status'=>'0','badge_count'=>'1','send_to'=>'doctor','type !='=>'adminChatDoctor')));
      if($device_type=="android"){
         $this->user_model->android_pushh1($device_token,$message,$title,$type,$notificationId,$notificationCount);
      }
      //ios
       if($device_type=="Iphone"){
          $this->user_model->iphone1($device_token,$message,$title,$type,$notificationId,$notificationCount);
      }
     }   //end check notification status
    //send notification end 
   
          $response['status']              = "SUCCESS";
          if($language_type=='en'){
          $response['message']             = 'Call Booking added Successfully';
           }else if($language_type=='hi'){
             $response['message']             = 'आपको एक नया बुकिंग अनुरोध प्राप्त हुआ है';
           }
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
 // echo "hi";die;
     if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
        $token     = $this->input->post('token');
        $language_type = $this->input->post('language_type');

         if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        } 
        $result = $this->user_model->getCondResultArray(USER,'id,name,address,language_type',array('token'=>$token));
        $user_id = $result[0]['id'];
        $username = $result[0]['name'];
        $userAddress = $result[0]['address'];
        //$language_type1 = $result[0]['language_type'];
        $doctor_id = $this->input->post('doctor_id');
        if($result)
        { 

             //calaculate eta time here
        $doctorDetail = $this->user_model->fieldCRow('doctor_doctor','address',array('id'=>$doctor_id));
        $doctorAdd = $doctorDetail->address;
        $timeDuration  = $this->user_model->getTime($userAddress,$doctorAdd);
        $time =  $timeDuration->rows[0]->elements[0]->duration->text;

        $checkBooking = $this->user_model->fieldCondRow1(BOOKING,'id,eta_time',array('doctor_id'=>$doctor_id,'booking_type'=>'home'));
        if($checkBooking){
             $getDoctorEta = $checkBooking->eta_time;
             $etaTime = $time+$getDoctorEta+30;
           }else
           {
            $etaTime = $time+30;
           }
          //end eta time 

           $address = $this->input->post('address');
         // if(!empty($address))
        //  {
          //$res = $this->user_model->getLatLong($address);
         // $latitude =  $res['latitude'];
         // $longitude =  $res['longitude'];
     // } 
            $latitude     = $this->input->post('latitude'); 
            $longitude     = $this->input->post('longitude'); 
            $scheduleData = array(

                                   'doctor_id'          => $doctor_id,
                                   'user_id'            => $user_id,
                                  // 'booking_type'     => 'call',
                                   'address_type'       => $this->input->post('address_type'),
                                   'address'            => $this->input->post('address'),
                                   'schedule_time'      => date('H:i:s',strtotime($this->input->post('schedule_time'))),
                                   'schedule_date'      => date('Y-m-d',strtotime($this->input->post('schedule_date'))),
                                   'promocode'          => $this->input->post('promocode'),   //optional
                                   'member_name'        => $this->input->post('member_name'),
                                   'member_id'          => $this->input->post('member_id'),
                                   'reason_visit'       => $this->input->post('reason_visit'),
                                   'booking_type'       => 'home',
                                   'eta_time'           => $etaTime,
                                   'booking_status'     => '0', 
                                   'session_status'     =>'0',
                                   'booking_latitude'   =>$latitude,
                                   'booking_longitude'  =>$longitude,
                                   'frees'              => $this->input->post('frees'),
                                   'status'             => '1',
                                   'created_date'       => date('Y-m-d H:i:s')
                                 );

            if (empty($scheduleData['doctor_id'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Doctor id  is empty';
           }else if($language_type=='hi'){
            $response['message'] = 'डॉक्टर आईडी खाली है';
           }
            echo json_encode($response);die;
        } 


             if (empty($scheduleData['address_type'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please select address type';
             }else if($language_type=='hi'){
              $response['message'] = 'कृपया पते का प्रकार चुनें';  
             }
            echo json_encode($response);die;
        } 

         if (empty($scheduleData['address'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please enter address';
             }else if($language_type=='hi'){
               $response['message'] = 'कृपया पता दर्ज करें';  
             }
            echo json_encode($response);die;
        } 

        if (empty($this->input->post('schedule_date'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please select date';
             }else if($language_type=='hi')
             {
                $response['message'] = 'कृपया तारीख का चयन करें'; 
             }
            echo json_encode($response);die;
        } 

        if (empty($scheduleData['schedule_time'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please select Time';
             }else if($language_type=='hi'){
               $response['message'] = 'कृपया समय का चयन करें';  
             }
            echo json_encode($response);die;
        } 

         

         if (empty($scheduleData['reason_visit'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please enter reason for visit';
           }else if($language_type=='hi'){
            $response['message'] = 'कृपया आने का कारण दर्ज करें';
           }
            echo json_encode($response);die;
        }  
        
         //check doctor is avialabe or not
     $doctorAvialableDay = $this->user_model->fetchValue(DOCTOR,'home_visit_days',array('id'=>$scheduleData['doctor_id']));
    $doctorDaysArr = explode(',',$doctorAvialableDay);
   // print_r($doctorDaysArr);die;
    $date = $this->input->post('schedule_date');
    $dayName = date('D', strtotime($date));


if($dayName=="Sun")
{
 $day = "7";
}

if($dayName=="Mon")
{
 $day = "1";
}

if($dayName=="Tue")
{
 $day = "2";
}

if($dayName=="Wed")
{
 $day = "3";
}

if($dayName=="Thu")
{
 $day = "4";
}
if($dayName=="Fri")
{
 $day = "5";
}
if($dayName=="Sat")
{
 $day = "6";
}
//echo $day;die;
if(!in_array($day,$doctorDaysArr))
{
       $response['status']              = "FAILURE";
       if($language_type=='en'){
       $response['message']             = '"Doctor is not available for this date. Please choose another date';
        }else if($language_type=='hi'){
          $response['message']             = 'इस तिथि के लिए डॉक्टर उपलब्ध नहीं है। कृपया कोई अन्य तिथि चुनें';   
        }
       echo json_encode($response);die;
}

//check here user cant book till 30 min
 $schedule_date = date('Y-m-d');
 $checkUserBooking = $this->db->query("select id,schedule_time,schedule_date,created_date from doctor_booking where user_id = $user_id && schedule_date = '$schedule_date' && booking_status != 5 && booking_type = 'home' order by id DESC ")->result();
 //echo $this->db->last_query();die;
 if($checkUserBooking)
         {
         $time = date('H:i',strtotime($checkUserBooking[0]->created_date));
         $currentTime = date('H:i');


      //echo  date('H:i',strtotime("1:30 PM"));die;
             $after30minTime = date("H:i", strtotime('+30 minutes', strtotime($time)));
             $datetime1 = strtotime($time);
             $datetime2 = strtotime($currentTime);
             $interval  = abs($datetime2 - $datetime1);
             $minutes   = round($interval / 60);
          // echo  'Diff. in minutes is: '.$minutes; die; 
             if($minutes<=30)
           {
            $response['status']  = "FAILURE";
           // $response['message'] = 'Provider is busy form '.date('h:i a',strtotime($time)).' to '.date('h:i a',strtotime($afterTwoHoursTime));
            
             // $response['message'] = "Service Provider is not available this time,please book after ".date('h:i A',strtotime('+2 hours', strtotime($time)))
            $response['message']  = "You have already done a booking. Please wait for 30 mins to book another appointment";
            echo json_encode($response);die;
           }  
          }
//end check

//echo $day;
    //end of doctor days avialable

//check promocode
if(!empty($this->input->post('promocode'))){
$checkBooking = $this->user_model->getCondResultArray(BOOKING,'id',array('user_id'=>$user_id)); 
if(!$checkBooking){
$checkPromo = $this->user_model->getCondResultArray('doctor_promocode','promo_code,validity',array('promo_code'=>$this->input->post('promocode')));
$ExpDate = $checkPromo[0]['validity'];
$todayDate = date('Y-m-d');
if(!$checkPromo)
{
  $response['status']              = "FAILURE";
  if($language_type=='en'){
  $response['message']             = 'Please enter a valid promotional or Voucher Code.';
   }else if($language_type=='hi'){
    $response['message']             = 'कृपया एक वैध प्रचारक या वाउचर कोड दर्ज करें।';
   }
  echo json_encode($response);die;
}

if($todayDate>$ExpDate)
{
  $response['status']              = "FAILURE";
  if($language_type=='en'){
  $response['message']             = 'Expire promotional or Voucher Code.';
   }else if($language_type=='hi'){
    $response['message']             = 'प्रचारित प्रचार या वाउचर कोड।';
   }
  echo json_encode($response);die;
}
}  //end check Booking 
else
{ 
//specific Booking check here 
$checkPromo = $this->user_model->getCondResultArray('doctor_specificpromo','promocode,validity',array('promocode'=>$this->input->post('promocode'),'doctor_id'=>$doctor_id));
//check this promocode is exit or not
  $chekPromoExit = $this->user_model->getCondResultArray(BOOKING,'id',array('promocode'=>$this->input->post('promocode'),'user_id'=>$user_id));
  if(!empty($chekPromoExit))
  {
    $response['status']              = "FAILURE";
    if($language_type=='en'){
  $response['message']             = 'This promocode is already used.';
   }else if($language_type=='hi'){
    $response['message']             = 'यह प्रोमोकोड पहले से ही इस्तेमाल किया गया है।';
   }
 echo json_encode($response);die;
  }
  //end check promocode 
$ExpDate = $checkPromo[0]['validity'];
$todayDate = date('Y-m-d');
if(!$checkPromo)
{
  $response['status']              = "FAILURE";
  if($language_type=='en'){
  $response['message']             = 'Please enter a valid promotional or Voucher Code.';
   }else if($language_type=='hi'){
    $response['message']             = 'कृपया एक वैध प्रचारक या वाउचर कोड दर्ज करें।';
   }
  echo json_encode($response);die;
}

if($todayDate>$ExpDate)
{
  $response['status']              = "FAILURE";
  if($language_type=='en'){
  $response['message']             = 'Expired promotional or Voucher Code.';
   }else if($language_type=='hi'){
    $response['message']             = 'प्रोमोशनल या वाउचर कोड समाप्त हो गया है।';
   }
  echo json_encode($response);die;
}
}
}

     $doctorDetails = $this->user_model->getCondResultArray(DOCTOR,'id,device_token,device_type,notification_status,language_type',array('id'=>$scheduleData['doctor_id']));
     $device_token = $doctorDetails[0]['device_token'];
     $device_type = $doctorDetails[0]['device_type'];
     $notification_status = $doctorDetails[0]['notification_status'];
     $language_type1  = $doctorDetails[0]['language_type'];
     $insert =  $this->my_model->insert_data('doctor_booking',$scheduleData);
   //  echo $this->db->last_query();die;
     if($insert)
     {
      //send notification start
      if($notification_status=="on") { //check notification status
         $doctorId = $scheduleData['doctor_id'];
         
        $booking_id = $insert;
        if($language_type1=='en'){
        $message = "You have a new booking request";
        $title = "You have a new booking request";
         }else if($language_type1=='hi'){
            $message = "आपको एक नया बुकिंग अनुरोध प्राप्त हुआ है";
        $title = "आपको एक नया बुकिंग अनुरोध प्राप्त हुआ है";  
         }
        $type = 'addbooking';
          $notificationData = array(
                                  'user_id'=> $user_id,
                                  'doctor_id'=> $this->input->post('doctor_id'),
                                  'booking_id'=> $booking_id,
                                  'title'=> $title,
                                  'message'=> $message,
                                  'type'   => $type,
                                  'status'=>'0',
                                  'badge_count'=>'1',
                                  'send_to'=>'doctor',
                                  'created_date'=> date('Y-m-d H:i:s'),
                                 );
      $notificationId = $this->user_model->insert_data('notification',$notificationData);  
      $notificationCount = count($this->user_model->getCondResult('notification','id',array('doctor_id'=>$doctorId,'status'=>'0','badge_count'=>'1','send_to'=>'doctor','type !='=>'adminChatDoctor')));
      if($device_type=="android"){

         $this->user_model->android_pushh1($device_token,$message,$title,$type,$notificationId,$notificationCount);
        }
      //ios
       if($device_type=="Iphone"){
       
       $this->user_model->iphone1($device_token,$message,$title,$type,$notificationId,$notificationCount);
      
      
      }
    } //check end of notification status
  //send notification end 
          $response['status']              = "SUCCESS";
          if($language_type=='en'){
          $response['message']             = 'Schedule added Successfully';
           }else if($language_type=='hi'){
            $response['message']             = 'बुकिंग को सफलतापूर्वक शेड्यूल किया गया है'; 
           }
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
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {
      $update =  $this->user_model->update_data(USER,array('notification_status'=>$status),array('id'=>$checkToken[0]['id']));
      if($update){
       
            $response['status']     = "SUCCESS";
            if($language_type=='en'){
            $response['message']    = 'Status changed successfully';
             }else if($language_type=='hi'){
               $response['message']    = 'स्थिति को सफलतापूर्वक बदल दिया गया है';  
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
       $language_type = $this->input->post('language_type');
     // $status = $this->input->post('status');

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

         
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id,notification_status    ',array('token'=>$token));
      if($checkToken)
      {
      //$getStatus =  $this->user_model->fetchValue(USER,'notification',array('token'=>$token));
    
       
            $response['status']     = "SUCCESS";
             $response['getNotificationStatus']     = $checkToken[0]['notification_status'];
             if($language_type=='en'){
            $response['message']    = 'status seen successfully.';
             }else if($language_type=='hi'){
              $response['message']    = 'स्थिति सफलतापूर्वक देखी गई है';  
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
// USER MEDICAL HISTORY CODE HERE


  //add hospital records

  function addHospitalRecords()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token      = $this->input->post('token');
      $user_type  = $this->input->post('user_type');
       $language_type = $this->input->post('language_type');

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

        if (empty($user_type)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'User Type is empty';
            echo json_encode($response);die;
        }


        
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {

        
        if($user_type=='member')
        {
          $user_id = $this->input->post('member_id');   // member id
        }
        if($user_type=='user')
        {
           $user_id = $checkToken[0]['id'];
        }

        
        $insertData = array(

                              'user_id'  => $user_id,
                              'hospital_name' => $this->input->post('hospital_name'),
                              'provider_name' => $this->input->post('provider_name'),
                              'provider_specility' => $this->input->post('provider_specility'),
                              'service_date '    => date('Y-m-d',strtotime($this->input->post('service_date'))),
                              'user_type'           => $user_type,
                              'type'            => 'hospital',
                              'status'     => '1',
                              'created_date'    => date('Y-m-d h:i:s')
                             );

       

         if (empty($insertData['hospital_name'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter Hospital Name";
             }else if($language_type=='hi'){
             $response['message'] = "कृपया अस्पताल का नाम दर्ज करें";   
             }
            echo json_encode($response);die;
        }

         if (empty($insertData['provider_name'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter Provider Name" ;
             }else if($language_type=='hi'){
               $response['message'] = "कृपया प्रदाता का नाम दर्ज करें" ;  
             }
            echo json_encode($response);die;
        }

        //  if (empty($insertData['provider_specility'])) {
        //     $response['status']  = "FAILURE";
        //     $response['message'] = "Please enter Provider Speciality Type";
        //     echo json_encode($response);die;
        // }


         if (empty($this->input->post('service_date'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please select Date of service";
             }else if($language_type=='hi'){
              $response['message'] = "कृपया सेवा की तारीख चुनें";  
             }
            echo json_encode($response);die;
        }

         if (empty($_FILES['image']['name'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please Select image';
             }else if($language_type=='hi'){
               $response['message'] = 'कृपया छवि का चयन करें';  
             }
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
            if($language_type=='en'){
            $response['message']    = 'User hospital record added successfully.';
             }else if($language_type=='hi'){
              $response['message']    = 'उपयोगकर्ता अस्पताल रिकॉर्ड सफलतापूर्वक जोड़ा गया';  
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
 

 //edit hospital records 

  function editHospitalRecords()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
       $language_type = $this->input->post('language_type');
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

                             // 'user_id'  => $checkToken[0]['id'],
                              'hospital_name' => $this->input->post('hospital_name'),
                              'provider_name' => $this->input->post('provider_name'),
                              'provider_specility' => $this->input->post('provider_specility'),
                              'service_date '    => date('Y-m-d',strtotime($this->input->post('service_date'))),
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
            if($language_type=='en'){
            $response['message'] = "Please enter Hospital Name";
             }else if($language_type=='hi'){
             $response['message'] = "कृपया अस्पताल का नाम दर्ज करें";   
             }
            echo json_encode($response);die;
        }

         if (empty($insertData['provider_name'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter Provider Name" ;
             }else if($language_type=='hi'){
               $response['message'] = "कृपया प्रदाता का नाम दर्ज करें" ;  
             }
            echo json_encode($response);die;
        }

        


         if (empty($this->input->post('service_date'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please select Date of service";
             }else if($language_type=='hi'){
              $response['message'] = "कृपया सेवा की तारीख चुनें";  
             }
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
            if($language_type=='en'){
            $response['message']    = 'User hospital record edit successfully.';
             }else if($language_type=='hi'){
             $response['message']    = 'उपयोगकर्ता अस्पताल का रिकॉर्ड सफलतापूर्वक संपादित किया गया है।';  
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

//show all medical detail related to user



  //show user hostpital detail

//this function is used to get all user medical records with multiple images
function medicalHistory()
{
     $token = $this->input->post('token');
     $user_type = $this->input->post('user_type');
     $language_type = $this->input->post('language_type');

     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }


       if (empty($user_type)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'User Type is empty';
            echo json_encode($response);die;
        }

   

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {

         if($user_type=='member')
        {
          $user_id = $this->input->post('member_id');   // member id
        }
        if($user_type=='user')
        {
           $user_id = $checkToken[0]['id'];
        }
            //hospital
            $hostpital =   $this->user_model->getCondResultArray('user_hospital_records','id,hospital_name,provider_name,provider_specility,service_date,type',array('user_id'=>$user_id,'user_type'=>$user_type));

            
              
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
             $specialty =   $this->user_model->getCondResultArray('user_specialty_records','id,specialty,specialty_type,service_date,type',array('user_id'=>$user_id,'user_type'=>$user_type));
            
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
              $lab =   $this->user_model->getCondResultArray('user_lab_records','id,lab_name,prescription_name,lab_date,type',array('user_id'=>$user_id,'user_type'=>$user_type));
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

              $physical =   $this->user_model->getCondResultArray('user_physical_therapist_records','id,therapy_name,therapy_date,type',array('user_id'=>$user_id,'user_type'=>$user_type));
            
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
          $other =   $this->user_model->getCondResultArray('user_other_records','id,description,date,type',array('user_id'=>$user_id,'user_type'=>$user_type));
            
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
                                      'other_date' => $othr['date'],
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

                $pharmacy =   $this->user_model->getCondResultArray('user_pharmacy_script','id,pharmacy_name,pharmacy_provider_name,service_date,type',array('user_id'=>$user_id,'user_type'=>$user_type));
            

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
            if($language_type=='en'){
                $msg = 'medical detail seen successfully.';
            }else if($language_type=='hi'){
             $msg = 'medical detail seen successfully.';   
            }
  
            $response = [ 'status' => "SUCCESS",'message'=>$msg,'hospitalDetail' => $HospitalArr,'specialtyDetail'=>$SpecialtyArr,'labDetail'=>$LabArr,'physicalDetails'=>$PhyArr,'otherDetail'=>$OtherArr,'pharmacyDetail'=>$PharmacyArr];
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
      $language_type = $this->input->post('language_type');
     

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


        if($language_type=='en'){
        
        $medicalMsg     = 'medical detail seen successfully.';
        $specialtyMsg   = 'specialty detail seen successfully.';
        $labMsg         = 'Lab detail seen successfully.';
        $otherMsg       = 'other detail seen successfully.';
        $pharmacyMsg    = 'pharmacy detail seen successfully.';
        $physicalMsg    = 'physical detail seen successfully.';
        }else if($language_type=='hi'){
        $medicalMsg     = 'चिकित्सा विवरण सफलतापूर्वक देखा गया है';
        $specialtyMsg   = 'विशेष विवरण सफलतापूर्वक देखे गए हैं।';
        $labMsg         = 'लैब डिटेल सफलतापूर्वक देखी गई।';
        $otherMsg       = 'अन्य विवरण सफलतापूर्वक देखे गए हैं।';
        $pharmacyMsg    = 'फार्मेसी विवरण सफलतापूर्वक देखा गया।';
        $physicalMsg    = 'भौतिक विवरण सफलतापूर्वक देखे गए';
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
              
              $response = [ 'status' => "SUCCESS",'message'=>$medicalMsg,'editdetail' => $HospitalArr];
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

         $response = [ 'status' => "SUCCESS",'message'=>$specialtyMsg,'editdetail' => $SpecialtyArr];
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

          $response = [ 'status' => "SUCCESS",'message'=>$labMsg,'editdetail' => $LabArr];
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
          $response = [ 'status' => "SUCCESS",'message'=>$otherMsg,'editdetail' => $OtherArr];
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
           $response = [ 'status' => "SUCCESS",'message'=>$pharmacyMsg,'editdetail' => $PharmacyArr];
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
          $response = [ 'status' => "SUCCESS",'message'=>$physicalMsg,'editdetail' => $PhyArr];
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
      $language_type = $this->input->post('language_type');
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
      $user_type = $this->input->post('user_type');
      $language_type = $this->input->post('language_type');
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {

         
         if($user_type=='member')
        {
          $user_id = $this->input->post('member_id');   // member id
        }
        if($user_type=='user')
        {
           $user_id = $checkToken[0]['id'];
        }

        $insertData = array(

                              'user_id'         => $user_id,
                              'specialty'       => $this->input->post('specialty'),
                              'specialty_type'  => $this->input->post('specialty_type'),
                              'service_date '   => date('Y-m-d',strtotime($this->input->post('service_date'))),
                              'user_type'       => $user_type,
                              'type'            =>'specialty',
                              'status'          => '1',
                              'created_date'    => date('Y-m-d h:i:s')
                             );

       

         if (empty($insertData['specialty'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter Specialist name";
             }else if($language_type=='hi'){
               $response['message'] = "कृपया विशेषज्ञ का नाम दर्ज करें";  
             }
            echo json_encode($response);die;
        }

        //  if (empty($insertData['specialty_type'])) {
        //     $response['status']  = "FAILURE";
        //     $response['message'] = "Please enter Speciality type";
        //     echo json_encode($response);die;
        // }

        if (empty($user_type)) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please enter User Type';
             }else if($language_type=='hi'){
             $response['message'] = 'कृपया उपयोगकर्ता प्रकार दर्ज करें';   
             }
            echo json_encode($response);die;
        }

          if (empty($this->input->post('service_date'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please select Date of service";
             }else if($language_type=='hi'){
                $response['message'] = "कृपया सेवा की तारीख चुनें"; 
             }
            echo json_encode($response);die;
        }

        if (empty($_FILES['image']['name'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please Select image';
             }else if($language_type=='hi'){
              $response['message'] = 'कृपया छवि का चयन करें';  
             }
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
            if($language_type=='en'){
            $response['message']    = 'User Specialty record added successfully.';
             }else if($language_type=='hi'){
             $response['message']    = 'उपयोगकर्ता विशेषता रिकॉर्ड सफलतापूर्वक जोड़ा गया।';   
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

 
  //update specality

    function editSpecialty()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $id    = $this->input->post('id');
      $language_type = $this->input->post('language_type');
     

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

                             // 'user_id'         => $checkToken[0]['id'],
                              'specialty'       => $this->input->post('specialty'),
                              'specialty_type'  => $this->input->post('specialty_type'),
                              'service_date '   => date('Y-m-d',strtotime($this->input->post('service_date'))),
                              //'image'           => $image,
                              'status'          => '1',
                              'updated_date'    => date('Y-m-d h:i:s')
                             );

       

           if (empty($insertData['specialty'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter Specialist name";
             }else if($language_type=='hi'){
               $response['message'] = "कृपया विशेषज्ञ का नाम दर्ज करें";  
             }
            echo json_encode($response);die;
        }

      

          if (empty($this->input->post('service_date'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please select Date of service";
             }else if($language_type=='hi'){
                $response['message'] = "कृपया सेवा की तारीख चुनें"; 
             }
            echo json_encode($response);die;
        }
       


       $insertid =  $this->user_model->update_data('user_specialty_records',$insertData,array('id'=>$id));
     //  echo $this->db->last_query();die;
       $delete = $this->user_model->deleteRow('medical_record_image',array('record_id'=>$id,'type'=>'specialty'));
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
                               'type'  => 'specialty',
                               'record_id' => $id,
                               'status' =>'1',
                               'created_date'=>date('Y-m-d h:i:s'),
                              );
           $this->user_model->insert_data('medical_record_image',$imageData);
        }

        }
    }
       //end upload ultiple images 

      if($insertid){
       
            $response['status']     = "SUCCESS";
            if($language_type=='en'){
            $response['message']    = 'User Specialty record edit successfully.';
            }else if($language_type=='hi'){
              $response['message']    = 'उपयोगकर्ता विशेषता रिकॉर्ड सफलतापूर्वक संपादित किया गया है';   
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



  //show user specialty

  function showSpecialtyDetail()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $id = $this->input->post('id');
      $language_type = $this->input->post('language_type');

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
      $user_type = $this->input->post('user_type');
      $language_type = $this->input->post('language_type');
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

         if (empty($user_type)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'User Type is empty';
            echo json_encode($response);die;
        }

        
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {
         if($user_type=='member')
        {
          $user_id = $this->input->post('member_id');   // member id
        }
        if($user_type=='user')
        {
           $user_id = $checkToken[0]['id'];
        }
      
        $insertData = array(

                              'user_id'         => $user_id,
                              'lab_name'       => $this->input->post('lab_name'),
                              'prescription_name'  => $this->input->post('prescription_name'),
                              'lab_date '   => date('Y-m-d',strtotime($this->input->post('lab_date'))),
                              'user_type'        => $user_type,
                              'type'           =>'lab',
                              'status'          => '1',
                              'created_date'    => date('Y-m-d h:i:s')
                             );

       

         if (empty($insertData['lab_name'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter Lab name";
             }else if($language_type=='hi'){
              $response['message'] = "कृपया लैब का नाम दर्ज करें";  
             }
            echo json_encode($response);die;
        }

         if (empty($insertData['prescription_name'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter Prescription MD Name";
             }else if($language_type=='hi'){
             $response['message'] = "कृपया प्रिस्क्रिप्शन एमडी का नाम दर्ज करें";   
             }
            echo json_encode($response);die;
        }

         if (empty($this->input->post('lab_date'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter Date of Lab done";
             }else if($language_type=='hi'){
              $response['message'] = "कृपया लैब की तिथि दर्ज करें";  
             }
            echo json_encode($response);die;
        }
      
        if (empty($_FILES['image']['name'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please Select Image';
             }else if($language_type=='hi'){
              $response['message'] = 'कृपया छवि का चयन करें';  
             }
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
            if($language_type=='en'){
            $response['message']    = 'User Lab record added successfully.';
             }else if($language_type=='hi'){
               $response['message']    = 'उपयोगकर्ता लैब रिकॉर्ड सफलतापूर्वक जोड़ा गया है';  
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


  //edit lab detail 

   function editLab()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $id    = $this->input->post('id');
      $language_type = $this->input->post('language_type');

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

                            //  'user_id'         => $checkToken[0]['id'],
                              'lab_name'       => $this->input->post('lab_name'),
                              'prescription_name'  => $this->input->post('prescription_name'),
                              'lab_date '   => date('Y-m-d',strtotime($this->input->post('lab_date'))),
                             // 'image'        => $image,
                              'status'          => '1',
                              'created_date'    => date('Y-m-d h:i:s')
                             );

       

           if (empty($insertData['lab_name'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter Lab name";
             }else if($language_type=='hi'){
              $response['message'] = "कृपया लैब का नाम दर्ज करें";  
             }
            echo json_encode($response);die;
        }

         if (empty($insertData['prescription_name'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter Prescription MD Name";
             }else if($language_type=='hi'){
             $response['message'] = "कृपया प्रिस्क्रिप्शन एमडी का नाम दर्ज करें";   
             }
            echo json_encode($response);die;
        }

         if (empty($this->input->post('lab_date'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter Date of Lab done";
             }else if($language_type=='hi'){
              $response['message'] = "कृपया लैब की तिथि दर्ज करें";  
             }
            echo json_encode($response);die;
        }
       


       $update =  $this->user_model->update_data('user_lab_records',$insertData,array('id'=>$id));
      $delete = $this->user_model->deleteRow('medical_record_image',array('record_id'=>$id,'type'=>'lab'));
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
                               'type'  => 'lab',
                               'record_id' => $id,
                               'status' =>'1',
                               'created_date'=>date('Y-m-d h:i:s'),
                              );
           $this->user_model->insert_data('medical_record_image',$imageData);
        }

        }
    }
       //end upload ultiple images 
      // echo $this->db->last_query();die;

      if($update){
       
            $response['status']     = "SUCCESS";
            if($language_type=='en'){
            $response['message']    = 'User Lab record edit successfully.';
             }else if($language_type=='hi'){
              $response['message']    = 'उपयोगकर्ता लैब रिकॉर्ड सफलतापूर्वक संपादित किया गया है।';  
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


//show lab records
 function showLabDetails()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $id = $this->input->post('id');
      $language_type = $this->input->post('language_type');

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
      $user_type = $this->input->post('user_type');
      $language_type = $this->input->post('language_type');
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

         if (empty($user_type)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'User Type is empty';
            echo json_encode($response);die;
        }

        
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {

      
       if($user_type=='member')
        {
          $user_id = $this->input->post('member_id');   // member id
        }
        if($user_type=='user')
        {
           $user_id = $checkToken[0]['id'];
        }
        $insertData = array(

                              'user_id'         => $user_id,
                              'therapy_name'    => $this->input->post('therapy_name'),
                              'therapy_date '   => date('Y-m-d',strtotime($this->input->post('therapy_date'))),
                              'user_type'       => $user_type,
                              'type'            =>'physical',
                              'status'          => '1',
                              'created_date'    => date('Y-m-d h:i:s')
                             );

       

         if (empty($insertData['therapy_name'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter Therapist Name";
             }else if($language_type=='hi'){
              $response['message'] = "कृपया चिकित्सक का नाम दर्ज करें";   
             }
            echo json_encode($response);die;
        }

        if (empty($user_type)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'User Type is empty';
            echo json_encode($response);die;
        }

               if (empty($this->input->post('therapy_date'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please select Date of therapy";
             }else if($language_type=='hi'){
               $response['message'] = "कृपया चिकित्सा की तिथि चुनें";  
             }
            echo json_encode($response);die;
        }

        if (empty($_FILES['image']['name'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please select image';
             }else if($language_type=='hi'){
               $response['message'] = 'कृपया छवि का चयन करें';  
             }
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
            if($language_type=='en'){
            $response['message']    = 'User Physical Therapy record added successfully.';
             }else if($language_type=='hi'){
              $response['message']    = 'उपयोगकर्ता भौतिक थेरेपी रिकॉर्ड सफलतापूर्वक जोड़ा गया है।';  
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



  //update physical therapy

  function editPhysicalTherapy()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $id    = $this->input->post('id');
      $language_type = $this->input->post('language_type');
     

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

                             // 'user_id'         => $checkToken[0]['id'],
                              'therapy_name'    => $this->input->post('therapy_name'),
                              'therapy_date '   => date('Y-m-d',strtotime($this->input->post('therapy_date'))),
                              //'image'           => $image,
                              'status'          => '1',
                              //'created_date'    => date('Y-m-d h:i:s')
                             );

       

          if (empty($insertData['therapy_name'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter Therapist Name";
             }else if($language_type=='hi'){
              $response['message'] = "कृपया चिकित्सक का नाम दर्ज करें";   
             }
            echo json_encode($response);die;
        }

               if (empty($this->input->post('therapy_date'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please select Date of therapy";
             }else if($language_type=='hi'){
               $response['message'] = "कृपया चिकित्सा की तिथि चुनें";  
             }
            echo json_encode($response);die;
        }
       


       $update =  $this->user_model->update_data('user_physical_therapist_records',$insertData,array('id'=>$id));
        $delete = $this->user_model->deleteRow('medical_record_image',array('record_id'=>$id,'type'=>'physical'));
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
                               'type'  => 'physical',
                               'record_id' => $id,
                               'status' =>'1',
                               'created_date'=>date('Y-m-d h:i:s'),
                              );
           $this->user_model->insert_data('medical_record_image',$imageData);
        }

        }
    }
       //end upload ultiple images 
      // echo $this->db->last_query();die;

      if($update){
       
            $response['status']     = "SUCCESS";
            if($language_type=='en'){
            $response['message']    = 'User Physical Therapy record edit successfully.';
             }else if($language_type=='hi'){
              $response['message']    = 'उपयोगकर्ता भौतिक थेरेपी रिकॉर्ड सफलतापूर्वक संपादित किया गया है।';   
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
      $user_type = $this->input->post('user_type');
      $language_type = $this->input->post('language_type');
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

        
        if (empty($user_type)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'User Type is empty';
            echo json_encode($response);die;
        }

        if (empty($this->input->post('date'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please select Date of service";
             }else if($language_type=='hi'){
              $response['message'] = "कृपया सेवा की तारीख चुनें";  
             }
            echo json_encode($response);die;
        }

         if (empty($_FILES['image']['name'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please select image';
             }else if($language_type=='hi'){
              $response['message'] = 'कृपया छवि का चयन करें';  
             }
            echo json_encode($response);die;
        }

        if (empty($this->input->post('description'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter description";
             }else if($language_type=='hi'){
              $response['message'] = "कृपया विवरण दर्ज करें";  
             }
            echo json_encode($response);die;
        }

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {

       if($user_type=='member')
        {
          $user_id = $this->input->post('member_id');   // member id
        }
        if($user_type=='user')
        {
           $user_id = $checkToken[0]['id'];
        }
      
        $insertData = array(

                              'user_id'         => $user_id,
                              'description'     => $this->input->post('description'),
                              'date '            => date('Y-m-d',strtotime($this->input->post('date'))),
                              'status'          => '1',
                              'user_type'       => $user_type,
                              'type'            =>'other',
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
            if($language_type=='en'){
            $response['message']    = 'User other  record added successfully.';
             }else if($language_type=='hi'){
            $response['message']    = 'उपयोगकर्ता अन्य रिकॉर्ड सफलतापूर्वक जोड़ा गया है।';
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



//edit other detals

  function editOther()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $id = $this->input->post('id');
      $language_type = $this->input->post('language_type');
     

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

        if (empty($this->input->post('description'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter description";
             }else if($language_type=='hi'){
              $response['message'] = "कृपया विवरण दर्ज करें";  
             }
            echo json_encode($response);die;
        }

        if (empty($this->input->post('date'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please select Date of service";
             }else if($language_type=='hi'){
              $response['message'] = "कृपया सेवा की तारीख चुनें";  
             }
            echo json_encode($response);die;
        }

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {


       
        $insertData = array(

                             // 'user_id'         => $checkToken[0]['id'],
                              'description'     => $this->input->post('description'),
                              'date '            => date('Y-m-d',strtotime($this->input->post('date'))),
                              'status'          => '1',
                             // 'image'           => $image,
                              'created_date'    => date('Y-m-d h:i:s')
                             );

        $insertid =  $this->user_model->update_data('user_other_records',$insertData,array('id'=>$id));
         $delete = $this->user_model->deleteRow('medical_record_image',array('record_id'=>$id,'type'=>'other'));
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
                               'type'  => 'other',
                               'record_id' => $id,
                               'status' =>'1',
                               'created_date'=>date('Y-m-d h:i:s'),
                              );
           $this->user_model->insert_data('medical_record_image',$imageData);
        }

        }
    }
      // echo $this->db->last_query();die;

      if($insertid){
       
            $response['status']     = "SUCCESS";
            if($language_type=='en'){
            $response['message']    = 'User other  record edit successfully.';
             }else if($language_type=='hi'){
              $response['message']    = 'उपयोगकर्ता अन्य रिकॉर्ड सफलतापूर्वक संपादित करें।';   
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
      $user_type = $this->input->post('user_type');
       $language_type = $this->input->post('language_type');
      

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

        if (empty($user_type)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'User Type is empty';
            echo json_encode($response);die;
        }

        
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {

      if($user_type=='member')
        {
          $user_id = $this->input->post('member_id');   // member id
        }
        if($user_type=='user')
        {
           $user_id = $checkToken[0]['id'];
        } 
        
        $insertData = array(

                              'user_id'                    => $user_id,
                              'pharmacy_name'              => $this->input->post('pharmacy_name'),
                              'pharmacy_provider_name   '    => $this->input->post('pharmacy_provider_name'),
                              'service_date         '          => date('Y-m-d',strtotime($this->input->post('service_date'))),
                              'status'                     => '1',
                              'type'                       => 'pharmacy',
                              'user_type'                  => $user_type,
                              'created_date'               => date('Y-m-d h:i:s')
                             );

         if (empty($this->input->post('pharmacy_name'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter Pharmacy name";
             }else if($language_type=='hi'){
              $response['message'] = "कृपया फार्मेसी का नाम दर्ज करें";  
             }
            echo json_encode($response);die;
        }

          if (empty($this->input->post('pharmacy_provider_name'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter Prescription Provider Name";
             }else if($language_type=='hi'){
              $response['message'] = "कृपया प्रिस्क्रिप्शन प्रदाता का नाम दर्ज करें";  
             }
            echo json_encode($response);die;
        }

        if (empty($this->input->post('service_date'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please select Date of service";
             }else if($language_type=='hi'){
               $response['message'] = "कृपया सेवा की तारीख चुनें";  
             }
            echo json_encode($response);die;
        }

         if (empty($_FILES['image']['name'])) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please select image';
             }else if($language_type=='hi'){
              $response['message'] = 'कृपया छवि का चयन करें';  
             }
            echo json_encode($response);die;
        }

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
            if($language_type=='en'){
            $response['message']    = 'User Pharmacy  record added successfully.';
             }else if($language_type=='hi'){
              $response['message']    = 'उपयोगकर्ता फार्मेसी रिकॉर्ड सफलतापूर्वक जोड़ा गया है।';  
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

  //edit pharmacy details

  function editPharmacy()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $id    = $this->input->post('id');
      $language_type = $this->input->post('language_type');
     

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

                            //  'user_id'                    => $checkToken[0]['id'],
                              'pharmacy_name'              => $this->input->post('pharmacy_name'),
                              'pharmacy_provider_name   '  => $this->input->post('pharmacy_provider_name'),
                              'service_date         '      => date('Y-m-d',strtotime($this->input->post('service_date'))),
                              'status'                     => '1',
                              //'image'                     => $image,
                              'created_date'               => date('Y-m-d h:i:s')
                             );

          if (empty($this->input->post('pharmacy_name'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter Pharmacy name";
             }else if($language_type=='hi'){
              $response['message'] = "कृपया फार्मेसी का नाम दर्ज करें";  
             }
            echo json_encode($response);die;
        }

          if (empty($this->input->post('pharmacy_provider_name'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please enter Prescription Provider Name";
             }else if($language_type=='hi'){
              $response['message'] = "कृपया प्रिस्क्रिप्शन प्रदाता का नाम दर्ज करें";  
             }
            echo json_encode($response);die;
        }

        if (empty($this->input->post('service_date'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = "Please select Date of service";
             }else if($language_type=='hi'){
               $response['message'] = "कृपया सेवा की तारीख चुनें";  
             }
            echo json_encode($response);die;
        }

        $insertid =  $this->user_model->update_data('user_pharmacy_script',$insertData,array('id'=>$id));
      $delete = $this->user_model->deleteRow('medical_record_image',array('record_id'=>$id,'type'=>'pharmacy'));
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
                               'type'  => 'pharmacy',
                               'record_id' => $id,
                               'status' =>'1',
                               'created_date'=>date('Y-m-d h:i:s'),
                              );
           $this->user_model->insert_data('medical_record_image',$imageData);
        }

        }
    }
      // echo $this->db->last_query();die;

      if($insertid){
       
            $response['status']     = "SUCCESS";
            if($language_type=='en'){
            $response['message']    = 'User Pharmacy  record edit successfully.';
             }else if($language_type=='hi'){
              $response['message']    = 'उपयोगकर्ता फार्मेसी रिकॉर्ड सफलतापूर्वक संपादित करें।';  
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


  //show pharmacy detail 

  function showPharmacyDetail()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $id = $this->input->post('id');
      $language_type = $this->input->post('language_type');

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
    $language_type = $this->input->post('language_type');

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
        $delete =   $this->user_model->deleteRow('user_hospital_records',array('id'=> $id));
        if($delete)
        {
              $response['status']     = "SUCCESS";
              if($language_type=='en'){
              $response['message']    = 'User hospital record delete successfully.';
            }else if($language_type=='hi'){
             $response['message']    = 'उपयोगकर्ता अस्पताल का रिकॉर्ड सफलतापूर्वक हटा दिया गया है';   
            }
              echo json_encode($response);die; 
        }
        }
    //delete speciality
        if($type=='specialty')
        {
        $delete =   $this->user_model->deleteRow('user_specialty_records',array('id'=> $id));
        if($delete)
        {
              $response['status']     = "SUCCESS";
              if($language_type=='en'){
              $response['message']    = 'User Specialty record delete successfully.';
               }else if($language_type=='hi'){
                $response['message']    = 'उपयोगकर्ता विशेषता रिकॉर्ड सफलतापूर्वक हटा दिया गया है।';
               }
              echo json_encode($response);die; 
        }
        }
     //delete lab
        if($type=='lab')
        {
        $delete =   $this->user_model->deleteRow('user_lab_records',array('id'=> $id));
        if($delete)
        {
              $response['status']     = "SUCCESS";
              if($language_type=='en'){
              $response['message']    = 'User Lab record delete successfully.';
               }else if($language_type=='hi'){
                  $response['message']    = 'उपयोगकर्ता लैब रिकॉर्ड सफलतापूर्वक हटा दिया गया है';
               }
              echo json_encode($response);die; 
        }
        }
    //delete therapy
       if($type=='physical')
        {
        $delete =   $this->user_model->deleteRow('user_physical_therapist_records',array('id'=> $id));
        if($delete)
        {
              $response['status']     = "SUCCESS";
              if($language_type=='en'){
              $response['message']    = 'User therapy record delete successfully.';
               }else if($language_type=='hi'){
                $response['message']    = 'उपयोगकर्ता थेरेपी रिकॉर्ड सफलतापूर्वक हटाएं।';
               }
              echo json_encode($response);die; 
        }
        }

    //delete other detail
       if($type=='other')
        {
        $delete =   $this->user_model->deleteRow('user_other_records',array('id'=> $id));
        if($delete)
        {
              $response['status']     = "SUCCESS";
              if($language_type=='en'){
              $response['message']    = 'User other record delete successfully.';
               }else if($language_type=='hi'){
                $response['message']    = 'उपयोगकर्ता के अन्य रिकॉर्ड को सफलतापूर्वक हटा दिया गया है।';
               }
              echo json_encode($response);die; 
        }
        }

        if($type=='pharmacy')
        {
        $delete =   $this->user_model->deleteRow('user_pharmacy_script',array('id'=> $id));
        if($delete)
        {
              $response['status']     = "SUCCESS";
              if($language_type=='en'){
              $response['message']    = 'User pharmacy record delete successfully.';
               }else if($language_type=='hi'){
                 $response['message']    = 'उपयोगकर्ता फ़ार्मेसी रिकॉर्ड सफलतापूर्वक हटाएं।';
               }
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
      $language_type = $this->input->post('language_type');
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

        
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id,name',array('token'=>$token));
      if($checkToken)
      {
          $userId =  $checkToken[0]['id']; 
          $userName =  $checkToken[0]['name']; 
          $ratingData = array(

                              'user_id'           => $checkToken[0]['id'],
                              'doctor_id'         => $this->input->post('doctor_id'),
                              'booking_id'        => $this->input->post('booking_id'),
                              'rating'                => $this->input->post('rating'),
                              'comment'             => $this->input->post('comment'),
                              'status'            => strtolower($this->input->post('status')),
                              'created_date'      => date('Y-m-d h:i:s')
                             );

        if (empty($this->input->post('doctor_id'))) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Doctor id  is empty';
            echo json_encode($response);die;
        }

         if (empty($this->input->post('booking_id'))) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Booking id  is empty';
            echo json_encode($response);die;
        }

          if (empty($this->input->post('rating'))) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Rating is empty';
             }else if($language_type=='hi'){
              $response['message'] = 'रेटिंग खाली है';  
             }
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
          //send notification start
       // $booking_id = $insert;
        $doctorDetails = $this->user_model->getCondResultArray(DOCTOR,'device_token,device_type,notification_status,language_type',array('id'=>$this->input->post('doctor_id')));
        
        $device_token = $doctorDetails[0]['device_token'];
        $device_type = $doctorDetails[0]['device_type'];
        $notification_status = $doctorDetails[0]['notification_status'];
        $language_type1 = $doctorDetails->language_type; 
       if($notification_status=="on") { // check notification status
        if($language_type1=='en'){
        $message = "Whoa ! ".ucwords($userName)." has rated you for your session";
        $title = "Whoa ! ".ucwords($userName)." has rated you for your session";
         }else if($language_type1=='hi'){
         $message = "वाह! ".ucwords($userName)." ने आपको अपने सत्र के लिए रेट किया है";
         $title = "वाह! ".ucwords($userName)." ने आपको अपने सत्र के लिए रेट किया है"; 
         }
        $type = 'addRating';
        $notificationData = array(
                                  'user_id'=> $userId,
                                  'doctor_id'=> $this->input->post('doctor_id'),
                                  'booking_id'=> $this->input->post('booking_id'),
                                  'title'=> $title,
                                  'message'=> $message,
                                  'type'   => $type,
                                  'status'=>'0',
                                  'badge_count'=>'1',
                                  'send_to'=>'doctor',
                                  'created_date'=> date('Y-m-d H:i:s'),
                                 );
      $notificationId =  $this->user_model->insert_data('notification',$notificationData);  
       $notificationCount = count($this->user_model->getCondResult('notification','id',array('doctor_id'=>$this->input->post('doctor_id'),'status'=>'0','badge_count'=>'1','send_to'=>'doctor','type !='=>'adminChatDoctor')));
     if($device_type=="android"){
         $this->user_model->android_pushh1($device_token,$message,$title,$type,$notificationId,$notificationCount);
      }
      //ios
    if($device_type=="Iphone"){
          $this->user_model->iphone1($device_token,$message,$title,$type,$notificationId,$notificationCount);
      }
    } //end check notification status
      //send notification end 
       
            $response['status']     = "SUCCESS";
            if($language_type=='en'){
            $response['message']    = 'rating  added successfully.';
             }else if($language_type=='hi'){
                 $response['message']    = 'रेटिंग को सफलतापूर्वक जोड़ा गया है।'; 
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
 //show doctor home visit listing
 function homeVistiLIsting()
 {
      //  echo "ello";die;
        $user_id = $this->input->post('user_id');
        $sort_by = $this->input->post('sort_by');
        $language_type = $this->input->post('language_type');
           if (empty($this->input->post('user_id'))) {
            $response['status']  = "FAILURE";
            $response['message'] = 'User id is empty';
            echo json_encode($response);die;
        }
        $user = $this->user_model->getCondResultArray(USER,'address,office_address,latitude,longitude,address_latitude,address_longitude',array('id'=>$user_id));
     if($sort_by=='address'){
        $latitude = $user[0]['address_latitude'];
        $longitude = $user[0]['address_longitude']; 
      }else
      {
       $latitude = $user[0]['latitude'];  //current location
       $longitude  = $user[0]['longitude']; 
      }
       
     $userAddress  = $user[0]['address'];
      // $res = $this->user_model->getCondResultArray(DOCTOR,'id,distance',array('status'=>'1','home_visit_type'=>'yes','verify_status'=>'1'));
     // foreach($res as $dis){ 
    $homeVisit =  $this->db->query("select id,name,mobile,email,specialty,license_no,experience,month,clinic_name,distance,image,qualification,frees,available_status,latitude,longitude,address from doctor_doctor where status='1' and home_visit_type='yes' and verify_status='1'")->result_array();
   // echo $this->db->last_query();die;
   // echo "<pre>";print_r($homeVisit);die;
       $doctor_id = $homeVisit[0]['id'];
    
      
        // $doctorRate =  $doctorRating->rate;
     
       if($user[0]['address'])
     {
      $homeAdd = $user[0]['address'];
     }else{
      $homeAdd = "";
     }

     if($user[0]['office_address'])
     {
      $officeAdd = $user[0]['office_address'];
     }else
     {
      $officeAdd = " ";
     }

     //check booking 
     $checkUserBooking =  $this->user_model->getCondResultArray(BOOKING,'id',array('user_id'=>$user_id));
     $Promocode =  $this->user_model->fieldCRow('doctor_promocode','id,promo_code,validity,offer_discount,location',array('status'=>'1'));
     if(!empty($Promocode))
     {
        $Promocode1 = $Promocode;
     }else
     {
        $Promocode1 = (object)[];
     }
     if($checkUserBooking)
     {
      $checkBooking = "1";
     }else{
      $checkBooking = "0";
     }

    

    
      if(!empty($homeVisit))
      {

        foreach($homeVisit as $home)
        {

           if($home['month'])
           {
               $month = $home['month'];
           }else
        {
              $month = "";
          }

     //check rating
      $doctorRating =  $this->user_model->AvgRating('doctor_rating',array('doctor_id'=>$home['id']));
     // echo $this->db->last_query();die;
      if($doctorRating->rate)
     {
      $rate = round($doctorRating->rate,1);
     }else
     {
      $rate = 5;
     }

       $latitudeFrom = $home['latitude'];
       $longitudeFrom = $home['longitude'];
       $doctorAdd = $home['address'];


    //Calculate distance from latitude and longitude
    $theta = $longitudeFrom - $longitude;
    $dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitude)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitude)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $distance = ($miles * 1.609344).' km';
    //End Calculate distance from latitude and longitude
       // $distance =  $this->user_model->distance($latitude,$longitude,$latitudeFrom,$longitudeFrom,'K');
       
        $distance = round($distance,1); 
       if($home['distance']=='')
       {
        $doctorDistance = 20;
       } else
       {
        $doctorDistance = $home['distance']; 
       }
       if($distance <= $doctorDistance){

      $specialtyName =  $this->user_model->fieldCondRow('specility','name,hi_name',array('id'=>$home['specialty']));
     if($language_type=='en'){
        $speName = $specialtyName->name;
     }else if($language_type=='hi'){
       $speName = $specialtyName->hi_name; 
     }


     //start calulate time
    $timeDuration  = $this->user_model->getTime($userAddress,$doctorAdd);
    $time =  $timeDuration->rows[0]->elements[0]->duration->text;
     //end calculate time 
    $getetaTime = $this->user_model->fieldCondRow1(BOOKING,'id,eta_time',array('doctor_id'=>$home['id'],'booking_type'=>'home'));
    if($getetaTime)
    {
      $etaTime = $time+$getetaTime->eta_time.' mins';  
  }else
  {
    $etaTime = $time;
  }
  //  echo $getetaTime->eta_time;die;
     
  //  echo $this->db->last_query();
    // $bookingUserId = $getEtaTime->user_id;


          $homeArr[] = array(
                               //'mydis'=> $doctorDistance,
                              'id' => $home['id'], 
                              'name' => $home['name'],  
                              'mobile' => $home['mobile'],  
                              'email' => $home['email'],  
                              'specialty' => $speName,  
                              'license_no' => $home['license_no'],  
                              'experience' => $home['experience'],  
                              'month' => $month,   
                              'clinic_name' => $home['clinic_name'], 
                              'distance' => $distance, 
                              'image' => $home['image'], 
                              'qualification' => $home['qualification'],
                               'frees' => $home['frees'], 
                               'home_address'=> $homeAdd,
                               'office_address' => $officeAdd, 
                               'available_status'=> $home['available_status'],
                               'rating' => "$rate",
                               'time' => $etaTime,
                              // 'mydis'=>$home['distance'],
                            );
       }
    }
  //echo "<pre>";print_r($homeArr);die;

       //sort by distance array 
         $distance = array();
         foreach($homeArr as $key=>$home1)
         {
         
          $distance[$key] = $home1['distance'];
       
         }
         array_multisort($distance, SORT_ASC, $homeArr);
           
         //end sort by distance array 
       if($language_type=='en'){
        $msg = 'home visit seen successfully.';
       }else if($language_type=='hi'){
        $msg = '"होम विजिट" सफलतापूर्वक देखी गई।';
       }  
      $response = [ 'status' => "SUCCESS",'message'=>$msg,'checkBooking'=>$checkBooking,'promocode'=>$Promocode1,'homeVisit' => $homeArr];
      //echo "<pre>";print_r($response);die;
      echo json_encode($response);die;
  }else
  {  
      if($language_type=='en'){
     $response = [ 'status' => "FAILURE",'message' => 'No record found!'];
     }else if($language_type=='hi'){
      $response = [ 'status' => "FAILURE",'message' => 'कोई रिकॉर्ड नहीं मिला!'];  
     }
      echo json_encode($response);die;
  }
 }

 //show call visit doctor listing
 function callVistListing()
 {
    $user_id = $this->input->post('user_id');
     $language_type = $this->input->post('language_type');
     $sort_by = $this->input->post('sort_by');
     $user = $this->user_model->getCondResultArray(USER,'address,office_address,latitude,longitude,address_latitude,address_longitude',array('id'=>$user_id));
      if($sort_by=='address'){
        $latitude = $user[0]['address_latitude'];
        $longitude = $user[0]['address_longitude']; 
      }else
      {
       $latitude = $user[0]['latitude'];
       $longitude  = $user[0]['longitude'];
      }
     
     $userAddress  = $user[0]['address'];

    // $callVisit =  $this->db->query("select id,name,mobile,email,specialty,license_no,experience,month,clinic_name,distance,image,qualification,available_status,call_fees,latitude,longitude,( 3959 * acos( cos( radians($latitude) ) * cos( radians(latitude) ) * cos( radians(longitude ) - radians($longitude) ) + sin( radians($latitude) ) * sin( radians(latitude) ) ) ) AS distance from doctor_doctor where status='1' and call_visit_type='yes' and verify_status='1' HAVING distance < 20")->result_array();

     $callVisit =  $this->db->query("select id,name,mobile,email,specialty,license_no,experience,month,clinic_name,distance,image,qualification,available_status,call_fees,latitude,longitude,address from doctor_doctor where status='1' and call_visit_type='yes' and verify_status='1' ")->result_array();
    $doctor_id = $homeVisit[o]['id'];
      
    
     if($user[0]['address'])
     {
      $homeAdd = $user[0]['address'];
     }else{
      $homeAdd = "";
     }

     if($user[0]['office_address'])
     {
      $officeAdd = $user[0]['office_address'];
     }else
     {
      $officeAdd = " ";
     }
    
      //check booking 
     $checkUserBooking =  $this->user_model->getCondResultArray(BOOKING,'id',array('user_id'=>$user_id));
     $Promocode =  $this->user_model->fieldCRow('doctor_promocode','id,promo_code,validity,offer_discount,location',array('status'=>'1'));
     if(!empty($Promocode))
     {
        $Promocode1 = $Promocode;
     }else
     {
        $Promocode1 = (object)[];
     }
     if($checkUserBooking)
     {
      $checkBooking = "1";
     }else{
      $checkBooking = "0";
     }

   
      if(!empty($callVisit))
      {
    foreach($callVisit as $call)
        {

     if($call['month'])
     {
      $month = $call['month'];
     }else
     {
      $month = "";
     }

      $doctorRating =  $this->user_model->AvgRating('doctor_rating',array('doctor_id'=>$call['id']));
         $doctorRate =  $doctorRating->rate;

    if($doctorRate)
     {
      $rate = round($doctorRate,1);
     }else
     {
      $rate = 5;
     }

    $specialtyName =  $this->user_model->fieldCondRow('specility','name,hi_name',array('id'=>$call['specialty']));
     if($language_type=='en'){
        $speName = $specialtyName->name;
     }else if($language_type=='hi'){
       $speName = $specialtyName->hi_name; 
     }

        $latitudeFrom = $call['latitude'];
        $longitudeFrom = $call['longitude'];
      // $distance =  $this->user_model->distance($latitude,$longitude,$latitudeFrom,$longitudeFrom,'K');  
       $theta = $longitudeFrom - $longitude;
        $dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitude)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitude)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        $distance = ($miles * 1.609344).' km';
       $distance = round($distance,1);  
         if($call['distance']=='')
       {
        $doctorDistance = 20;
       } else
       {
        $doctorDistance = $call['distance']; 
       }
       if($distance <= $doctorDistance){

        //start calulate time
    $doctorAdd = $call['address'];    
    $timeDuration  = $this->user_model->getTime($userAddress,$doctorAdd);
    $time =  $timeDuration->rows[0]->elements[0]->duration->text;
     //end calculate time 
    $getetaTime = $this->user_model->fieldCondRow1(BOOKING,'id,eta_time',array('doctor_id'=>$call['id'],'booking_type'=>'call'));
    if($getetaTime)
    {
      $etaTime = $time+$getetaTime->eta_time.' mins';  
    }else
    {
    $etaTime = $time;
    }

           $callArr[] = array(
                              'id' => $call['id'], 
                              'name' => $call['name'],  
                              'mobile' => $call['mobile'],  
                              'email' => $call['email'],  
                              'specialty' => $speName,  
                              'license_no' => $call['license_no'],  
                              'experience' => $call['experience'],  
                              'month' => $month,   
                              'clinic_name' => $call['clinic_name'], 
                              'distance' => $call['distance'], 
                              'image' => $call['image'], 
                              'qualification' => $call['qualification'],
                              'available_status'=> $call['available_status'],
                               'frees' => $call['call_fees'], 
                               'home_address'=> $homeAdd,
                               'office_address' => $officeAdd, 
                                'rating' => "$rate",
                                'time'  => $etaTime,
                            );
         }
}
       //sort by distance array 
         $distance = array();
         foreach($callArr as $key=>$call1)
         {
         
          $distance[$key] = $call1['distance'];
       
         }
         array_multisort($distance, SORT_ASC, $callArr);
          
         //end sort by distance array  
        if($language_type=='en'){
        $msg = 'call visit seen successfully.';
       }else if($language_type=='hi'){
        $msg = 'कॉल को सफलतापूर्वक देखा गया है';
       }    
      $response = [ 'status' => "SUCCESS",'message'=>$msg,'checkBooking'=>$checkBooking,'promocode'=>$Promocode1,'callVist' => $callArr];
      echo json_encode($response);die;
  }else
  {   
      if($language_type=='en'){
       $response = [ 'status' => "FAILURE",'message' => 'No record found!'];
      }else if($language_type=='hi'){
      $response = [ 'status' => "FAILURE",'message' => 'कोई रिकॉर्ड नहीं मिला!'];
      }
      echo json_encode($response);die;
  }
 }
 //pending booking
  function pendingBookingList()  // when confirm status 0
  {

     $token = $this->input->post('token');
      $language_type = $this->input->post('language_type'); 

     if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

     $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
     $id = $checkToken[0]['id'];
     $userName = $checkToken[0]['name'];

    if($checkToken)
    {
         $dateto = date('Y-m-d');
    
    
    $booking_status = 0 ;
    $query = "SELECT b.doctor_id,d.name,d.email,d.mobile,d.image,d.qualification,d.experience,d.month,d.clinic_name,d.specialty,b.frees,b.created_date,b.address,b.address_type,b.booking_type,b.reason_visit,b.member_name,b.user_id,b.schedule_time,b.schedule_date,b.id FROM `doctor_booking` as b INNER JOIN doctor_doctor as d on b.doctor_id=d.id  WHERE b.user_id = '".$id."' and booking_status = '".$booking_status."' ORDER BY b.id DESC ";     
    $result = $this->db->query($query)->result_array(); 
  if($result){
    foreach($result as $values)
    {
    $rating =   $this->user_model->getCondResultArray('doctor_rating','rating',array('doctor_id'=>$values['doctor_id'],'booking_id'=>$values['id']));
    if($rating)
    {
      $rate = round($rating[0]['rating'],1);
    }else{ $rate= '';}
   // echo $this->db->last_query();
   
    //check member is blanck then show username
    if($values['member_name'])
    {
        $memberName = $values['member_name'];
    }else
    {
        $memberName = $userName;
    }

     $specialtyName =  $this->user_model->fieldCondRow('specility','name,hi_name',array('id'=>$values['specialty']));
     if($language_type=='en'){
        $speName = $specialtyName->name;
     }else if($language_type=='hi'){
       $speName = $specialtyName->hi_name; 
     }
 
      $Arr[]  = array(
                   
                    'doctor_id'      => $values['doctor_id'],
                    'booking_id'     => $values['id'],
                    'name'           => $values['name'],
                    'email'          => $values['email'],
                    'mobile'         => $values['mobile'],
                    'image'          => $values['image'],
                    'qualification'  => $values['qualification'],
                    'experience'     => $values['experience'],
                    'month'          => $values['month'],
                    'clinic_name'    => $values['clinic_name'],
                    'specialty'      => $speName,
                    'frees'          => $values['frees'],
                    'created_date'   => date('d-m-Y h:i A',strtotime($values['created_date'])),
                    'address'        => $values['address'],
                    'address_type'   => $values['address_type'],
                    'booking_type'   => $values['booking_type'],
                    'reason_visit'   => $values['reason_visit'],
                    'member_name'    => $memberName,
                    'scheduling_time'  => date('h:i A',strtotime($values['schedule_time'])),
                    'scheduling_date' => date('d-m-Y',strtotime($values['schedule_date'])),
                    'rating'          =>"$rate",



                   );
    }
   // print_r($Arr);die;
    //echo $this->db->last_query();die;
    if($language_type=='en'){
        $msg = 'Pending Booking seen successfully';
    }else if($language_type=='hi'){
       $msg = 'विचाराधीन की बुकिंग सफलतापूर्वक देखी गई';  
    }
  
    $response = ['status' => "SUCCESS",'message'=>$msg,'pendingbooking' => $Arr];
    echo json_encode($response);die;
 }
 else{
       $response['status']     = "FAILURE";
       if($language_type=='en'){
       $response['message']    = 'No pending booking record found.';
        }else if($language_type=='hi'){
        $response['message']    = 'कोई भी लंबित बुकिंग रिकॉर्ड नहीं मिला।';    
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
 
 //show user past booking list
  function pastBookingList()  // when confirm status 4
  {

     $token = $this->input->post('token');
      $language_type = $this->input->post('language_type'); 

     if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

     $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
     $id = $checkToken[0]['id'];
     $userName = $checkToken[0]['name'];

    if($checkToken)
    {
         $dateto = date('Y-m-d');
    
    
    // $query = "SELECT d.name,d.email,d.mobile,d.image,d.qualification,b.created_date,b.address,b.address_type,b.booking_type FROM `doctor_booking` as b INNER JOIN doctor_doctor as d on b.doctor_id=d.id  WHERE b.user_id = '".$id."' and str_to_date(b.created_date,'%Y-%m-%d') < '".$dateto."' ORDER BY b.id DESC ";
    $booking_status = 4 ;
    $query = "SELECT b.doctor_id,d.name,d.email,d.mobile,d.image,d.qualification,d.experience,d.month,d.clinic_name,d.specialty,b.frees,b.created_date,b.address,b.address_type,b.booking_type,b.reason_visit,b.member_name,b.user_id,b.schedule_time,b.schedule_date,b.id FROM `doctor_booking` as b INNER JOIN doctor_doctor as d on b.doctor_id=d.id  WHERE b.user_id = '".$id."' and booking_status = '".$booking_status."' ORDER BY b.id DESC ";     
    $result = $this->db->query($query)->result_array(); 
  if($result){
    foreach($result as $values)
    {
    $rating =   $this->user_model->getCondResultArray('doctor_rating','rating',array('doctor_id'=>$values['doctor_id'],'booking_id'=>$values['id']));
    if($rating)
    {
      $rate = round($rating[0]['rating'],1);
    }else{ $rate= '';}
   // echo $this->db->last_query();
   
    //check member is blanck then show username
    if($values['member_name'])
    {
        $memberName = $values['member_name'];
    }else
    {
        $memberName = $userName;
    }

     $specialtyName =  $this->user_model->fieldCondRow('specility','name,hi_name',array('id'=>$values['specialty']));
     if($language_type=='en'){
        $speName = $specialtyName->name;
     }else if($language_type=='hi'){
       $speName = $specialtyName->hi_name; 
     }
 
      $Arr[]  = array(
                   
                    'doctor_id'      => $values['doctor_id'],
                    'booking_id'     => $values['id'],
                    'name'           => $values['name'],
                    'email'          => $values['email'],
                    'mobile'         => $values['mobile'],
                    'image'          => $values['image'],
                    'qualification'  => $values['qualification'],
                    'experience'     => $values['experience'],
                    'month'          => $values['month'],
                    'clinic_name'    => $values['clinic_name'],
                    'specialty'      => $speName,
                    'frees'          => $values['frees'],
                    'created_date'   => date('d-m-Y h:i A',strtotime($values['created_date'])),
                    'address'        => $values['address'],
                    'address_type'   => $values['address_type'],
                    'booking_type'   => $values['booking_type'],
                    'reason_visit'   => $values['reason_visit'],
                    'member_name'    => $memberName,
                    'scheduling_time'  => date('h:i A',strtotime($values['schedule_time'])),
                    'scheduling_date' => date('d-m-Y',strtotime($values['schedule_date'])),
                    'rating'          =>"$rate",



                   );
    }
   // print_r($Arr);die;
    //echo $this->db->last_query();die;
    if($language_type=='en'){
        $msg = 'Past Booking seen successfully';
    }else if($language_type=='hi'){
       $msg = 'अतीत की बुकिंग सफलतापूर्वक देखी गई';  
    }
  
    $response = ['status' => "SUCCESS",'message'=>$msg,'pastbooking' => $Arr];
    echo json_encode($response);die;
 }
 else{
       $response['status']     = "FAILURE";
       if($language_type=='en'){
       $response['message']    = 'No past booking record found.';
        }else if($language_type=='hi'){
        $response['message']    = 'पिछले कोई बुकिंग रिकॉर्ड नहीं मिले हैं।';    
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

function upcomingBookingList()  //when payment success then show upcoming (status==3)
  {

     $token = $this->input->post('token');
      $language_type = $this->input->post('language_type'); 
      

     if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

     $checkToken =   $this->user_model->getCondResultArray(USER,'id,name,address',array('token'=>$token));
     $id = $checkToken[0]['id'];
     $userName = $checkToken[0]['name'];
     $userAddress = $checkToken[0]['address'];

    if($checkToken)
    {
         $dateto = date('Y-m-d');
    
    
    // $query = "SELECT d.name,d.email,d.mobile,d.image,b.created_date,b.address,b.address_type,b.booking_type FROM `doctor_booking` as b INNER JOIN doctor_doctor as d on b.doctor_id=d.id  WHERE b.user_id = '".$id."' and str_to_date(b.created_date,'%Y-%m-%d') >='".$dateto."' ORDER BY b.id DESC ";
     $booking_status = 3; 
     $query = "SELECT b.doctor_id,d.name,d.email,d.mobile,d.image,d.qualification,d.experience,d.month,d.clinic_name,d.specialty,b.frees,d.latitude,d.longitude,b.created_date,b.address,b.address_type,b.booking_type,b.reason_visit,b.member_name,b.schedule_time,b.schedule_date,b.id,d.address as doctor_address FROM `doctor_booking` as b INNER JOIN doctor_doctor as d on b.doctor_id=d.id  WHERE b.user_id = '".$id."' and b.booking_status='".$booking_status."' ORDER BY b.id DESC ";     
    $result = $this->db->query($query)->result_array(); 
    //print_r($resul);die;
    //echo $this->db->last_query();die;
    if($result){

       foreach($result as $values)
    {
    $rating = $this->user_model->AvgRating('doctor_rating',array('doctor_id'=>$values['doctor_id']));
    //echo "<pre>";
  // print_r($rating);
   // $rating =   $this->user_model->fetchValue('doctor_rating','rating',array('doctor_id'=>$values['doctor_id'],'user_id'=>$id));
    if($rating->rate!='')
    {
      $rate = round($rating->rate,1);
    }else{ $rate= 5;}
   // echo $this->db->last_query();
   
    //check member is blanck then show username
    if($values['member_name'])
    {
        $memberName = $values['member_name'];
    }else
    {
        $memberName = $userName;
    }

     $specialtyName =  $this->user_model->fieldCondRow('specility','name,hi_name',array('id'=>$values['specialty']));
     if($language_type=='en'){
        $speName = $specialtyName->name;
     }else if($language_type=='hi'){
       $speName = $specialtyName->hi_name; 
     }

     $checkSessionstatus = $this->user_model->getCondResult(BOOKING,'session_status',array('doctor_id'=>$values['doctor_id']));
    
       $arr = array();
       foreach($checkSessionstatus as $status)
       {
        array_push($arr,$status->session_status);
     //   $sta = array($status->session_status);
       }
     
       if(in_array('1',$arr))
       {
       $session_status = 1;
      }else {
        $session_status = 0;
      }
 
     
        //start calulate time
    $doctorAdd = $values['doctor_address']; 
    $userAddress = $values['address'];      
    $timeDuration  = $this->user_model->getTime($userAddress,$doctorAdd);
    $time =  $timeDuration->rows[0]->elements[0]->duration->text;
     //end calculate time 
      $Arr[]  = array(
                   
                    'doctor_id'      => $values['doctor_id'],
                    'booking_id'     => $values['id'],
                    'name'           => $values['name'],
                    'email'          => $values['email'],
                    'mobile'         => $values['mobile'],
                    'image'          => $values['image'],
                    'qualification'  => $values['qualification'],
                    'experience'     => $values['experience'],
                    'month'          => $values['month'],
                    'clinic_name'    => $values['clinic_name'],
                    'specialty'      => $speName,
                    'frees'          => $values['frees'],
                    'created_date'   => date('d-m-Y h:i A',strtotime($values['created_date'])),
                    'address'        => $values['address'],
                    'address_type'   => $values['address_type'],
                    'booking_type'   => $values['booking_type'],
                    'reason_visit'   => $values['reason_visit'],
                    'member_name'    => $memberName,
                    'scheduling_time'  => date('h:i A',strtotime($values['schedule_time'])),
                    'scheduling_date' => date('d-m-Y',strtotime($values['schedule_date'])),
                    'rating'         =>"$rate",
                    'time'           => $time,
                    'session_status' => $session_status,



                   );
    }
      if($language_type=='en'){
        $msg = 'upcoming booking seen successfully';
      }else if($language_type=='hi'){
        $msg = 'आगामी बुकिंग सफलतापूर्वक देखी गई';
      }
    $response = ['status' => "SUCCESS",'message'=>$msg,'upcomingBooking' => $Arr];
    echo json_encode($response);die;
 }
 else{
       $response['status']     = "FAILURE";
       if($language_type=='en'){
       $response['message']    = 'No Upcoming booking record found.';
        }else if($language_type=='hi'){
          $response['message']    = 'अपकमिंग बुकिंग के रिकॉर्ड नहीं मिले हैं';   
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


 function memberListById()
   {
   
    $user_id = $this->input->post('user_id');
     $language_type = $this->input->post('language_type'); 

     if (empty($user_id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'User is empty';
            echo json_encode($response);die;
        }

    $memberList = $this->user_model->getCondResultArray('user_member','id,name',array('user_id'=>$user_id));
    if(!empty($memberList))
    {
       if($language_type=='en'){
        $msg = 'Member List seen successfully.';
       } else if($language_type=='hi'){
        $msg = 'सदस्य सूची सफलतापूर्वक देखी गई।';
       }
      $response = [ 'status' => "SUCCESS",'message'=>$msg,'memberList'=>$memberList];
      echo json_encode($response);die;
    }else{
         $response['status']     = "FAILURE";
         if($language_type=='en'){
         $response['message']    = 'No member List found this user id.';
          }else if($language_type=='hi'){
           $response['message']    = 'कोई सदस्य नहीं मिला';  
          }
         echo json_encode($response);
    }
   }


     function doctorType()
   {
   // echo "hi";
     $language_type = $this->input->post('language_type'); 
    $doctorType = $this->user_model->getCondResultArray('specility','id,name,hi_name',array('status'=>'1'));
    if(!empty($doctorType))
    {
         if($language_type=='en'){
            $msg = 'Doctor Type seen successfully.';
         }else if($language_type=='hi'){
            $msg = 'डॉक्टर टाइप ने सफलतापूर्वक देखा है।';
         }

         foreach($doctorType as $type)
         {
           if($language_type=='en'){
            $name = $type['name'];
           } else if($language_type=='hi'){
            $name = $type['hi_name'];
           }
           $doctorTypeArr[] = array(
                                    'id' => $type['id'],
                                    'name'=>$name,
                                   ); 
         }
        $response = [ 'status' => "SUCCESS",'message'=>$msg,'doctorType'=>$doctorTypeArr];
      echo json_encode($response);die;
    }else{
        $response['status']     = "FAILURE";
        if($language_type=='en'){
        $response['message']    = 'No record found.';
         }else if($language_type=='hi'){
           $response['message']    = 'कोई रिकॉर्ड नहीं मिला।';  
         }
        echo json_encode($response);
    }
   }

   //start get all user medical history


   function pastMedicalDetails()
   {
     $token = $this->input->post('token');
     $user_type = $this->input->post('user_type');
     $language_type = $this->input->post('language_type'); 

     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }


       if (empty($user_type)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'User Type is empty';
            echo json_encode($response);die;
        }

   

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {

         if($user_type=='member')
        {
          $user_id = $this->input->post('member_id');   // member id
        }
        if($user_type=='user')
        {
           $user_id = $checkToken[0]['id'];
        }
            //hospital
        $hostpital =   $this->user_model->getCondResultArray('user_hospital_records','id,hospital_name,provider_name,provider_specility,service_date,type,created_date',array('user_id'=>$user_id,'user_type'=>$user_type));

        
          
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
                             'service_date' => date('d-m-Y',strtotime($hos['service_date'])),
                              'type' => $hos['type'],
                             'images'        => $hos_img,
                             'date'    => date('d-m-Y',strtotime($hos['created_date'])),

                             );
             }
         }else
         {
          $HospitalArr = array();
         }
           
         
        // $HospitalArr = array_merge($hostpital,$img);

         //end hospital
            //specialty
         $specialty =   $this->user_model->getCondResultArray('user_specialty_records','id,specialty,specialty_type,service_date,type,created_date',array('user_id'=>$user_id,'user_type'=>$user_type));
        
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
                                      'service_date' => date('d-m-Y',strtotime($spe['service_date'])),
                                      'type' => $spe['type'],
                                      'images' => $spe_img,
                                      'date'    => date('d-m-Y',strtotime($spe['created_date'])),
                               );
         }

     }else
     {
      $SpecialtyArr = array();
     }
        
         //end specialty

         //lab 
          $lab =   $this->user_model->getCondResultArray('user_lab_records','id,lab_name,prescription_name,lab_date,type,created_date',array('user_id'=>$user_id,'user_type'=>$user_type));
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
                                      'lab_date' => date('d-m-Y',strtotime($lb['lab_date'])),
                                      'type' => $lb['type'],
                                      'images' => $lab_img,
                                      'date'    => date('d-m-Y',strtotime($lb['created_date'])),
                               );
         }
     }else
     {
             $LabArr =array();
     }
         //end lab

         //physical

          $physical =   $this->user_model->getCondResultArray('user_physical_therapist_records','id,therapy_name,therapy_date,type,created_date',array('user_id'=>$user_id,'user_type'=>$user_type));
        
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
                                      'therapy_date' => date('d-m-Y',strtotime($py['therapy_date'])),
                                      'type' => $py['type'],
                                      'images' => $phy_img,
                                      'date'    => date('d-m-Y',strtotime($py['created_date'])),
                               );
         }
     }else
     {
      $PhyArr = array();
     }

         //end physical
              //other
      $other =   $this->user_model->getCondResultArray('user_other_records','id,description,date,type,created_date',array('user_id'=>$user_id,'user_type'=>$user_type));
        
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
                                      'other_date' => date('d-m-Y',strtotime($othr['date'])),
                                      'type' => $othr['type'],
                                      'images' => $other_img,
                                      'date'    => date('d-m-Y',strtotime($othr['created_date'])),
                               );
         }
     }
     else
     {
      $OtherArr =array();
     }

         //end other

            $pharmacy =   $this->user_model->getCondResultArray('user_pharmacy_script','id,pharmacy_name,pharmacy_provider_name,service_date,type,created_date',array('user_id'=>$user_id,'user_type'=>$user_type));
        

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
                                           'service_date' => date('d-m-Y',strtotime($ph['service_date'])),
                                          'type' => $ph['type'],
                                          'images' => $ph_img,
                                          'date'    => date('d-m-Y',strtotime($ph['created_date'])),
                                   );
       }

          }

        else
        {
          $PharmacyArr =array();
        }

        //start get session data
      $getSessionData =   $this->user_model->getCondResultArray('doctor_session','doctor_id,subjective,objective,assessment,planning,digital_signature,image,created_date,id',array('user_id'=>$user_id));
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


      $pastHistory =  $this->user_model->fieldCondRow1('doctor_session','past_history,created_date,doctor_id',array('user_id'=>$user_id,'user_type'=>$user_type));
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

      //$PastArr =  (array) $pastHis;


        //end get session data code
       if($language_type=='en'){
        $msg = 'medical detail seen successfully.';
       }else if($language_type=='hi'){
        $msg = 'चिकित्सा विवरण सफलतापूर्वक देखा गया।';
       }
  
          $response = [ 'status' => "SUCCESS",'message'=>$msg,'hospitalDetail' => $HospitalArr,'specialtyDetail'=>$SpecialtyArr,'labDetail'=>$LabArr,'physicalDetails'=>$PhyArr,'otherDetail'=>$OtherArr,'pharmacyDetail'=>$PharmacyArr,'sessionDetail'=>$SessArr,'pastHistory'=>$pastHis];
      echo json_encode($response);die;
//
}else
{
        $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            echo json_encode($response);
}

}


   //end get all medical history api

//dilevery status update

function dileveryStatus()
    {
       if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $status = $this->input->post('status');
      $sess_id = $this->input->post('session_id');
      $language_type = $this->input->post('language_type'); 

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

         
     

      $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {
     
   $update  = $this->my_model->update_data('doctor_session',array('id'=>$sess_id),array('delivery_status'=>$status)); //update session status 1 means session start      

       
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
     
     }else
          {
          $response['status']     = "FAILURE";
          $response['message']    = 'This method is not allowed.';
          echo json_encode($response);die; 
        }  

  }


   function getDoctorByLatlong()
  {
     // $lat = "28.5355161";
     // $long ="77.3910265";
      $lat = $this->input->post('latitude');
      $long = $this->input->post('longitude');
      $user_id = $this->input->post('user_id');
      $language_type = $this->input->post('language_type'); 

      if (empty($lat)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Please enter latitude';
            echo json_encode($response);die;
            //die;
        }

      if (empty($long)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Please enter longitude';
            echo json_encode($response);die;
        }

   $doctor = $this->my_model->custom("SELECT id,latitude,longitude, ( 3959 * acos( cos( radians($lat) ) * cos( radians(latitude) ) * cos( radians(longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians(latitude) ) ) ) AS distance FROM doctor_user HAVING distance < 25 ORDER BY distance LIMIT 0 , 20
");
    $cond = "user_id=$user_id and status=0 and badge_count='1' and send_to='user' and type !='adminChatUser'";
    $notificationCount = $this->my_model->coutrow('notification','id',$cond); 
    //echo $notificationCount;die;
    //echo $this->db->last_query();die;
     $notificationChatcount = $this->my_model->coutrow('notification','id',array('user_id'=>$user_id,'status'=>'0','badge_count'=>'1','send_to'=>'user','type'=>'adminChatUser')); 
  // echo $this->db->last_query();
   if(!empty($doctor))
   {
      $response['status']     = "SUCCESS";
      if($language_type=='en'){
       $response['message']     = "doctor list show successfully";
        }else if($language_type=='hi'){
         $response['message']     = "डॉक्टर सूची सफलतापूर्वक दिखाती है";   
        }
       $response['notification_count'] = $notificationCount;
       $response['chat_notification_count'] = $notificationChatcount;
      $response['doctorList']    = $doctor;
      echo json_encode($response);die;
   }else
   {
       $response['status']     = "SUCCESS";
       if($language_type=='en'){
       $response['message']    = "no record found.";
        }else if($language_type=='hi'){
           $response['message']    = "कोई रिकॉर्ड नहीं मिला।";  
        }
       echo json_encode($response);die;
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

   $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
   $userId = $checkToken[0]['id'];
      if($checkToken)
      {
        //$notification = $this->user_model->notification(array('n.user_id'=>$userId,'send_to'=>'user'));
       //read notification
    //  $condition ="user_id ='".$userId."' and send_to ='user' and type != 'adminChatUser'";  
     // $update = $this->user_model->update_data('notification',array('status'=>'1','badge_count'=>'0'),$condition) ;  
      //echo $this->db->last_query();die;
        $cond ="user_id ='".$userId."' and send_to ='user' and type != 'adminChatUser'";
       $notification= $this->user_model->getCondResult1('notification','id,doctor_id,booking_id,title,message,status,type,created_date',$cond);
      //  echo $this->db->last_query();die;
        if(!empty($notification))
        {
         foreach($notification as $notify)
         {
          $doctor_name = $this->user_model->fetchValue(DOCTOR,'name',array('id'=>$notify->doctor_id));
          $arr[] = array(
                          'id'                   => $notify->id,
                          'doctor_id'            => $notify->doctor_id,
                          'doctor_name'          => $doctor_name,  
                          'booking_id'           => $notify->booking_id,
                          'title'                => $notify->title,
                          'message'              => $notify->message,
                          'type'                 => $notify->type,
                          'notification_status'  => $notify->status,
                          'date'                 => date('d-m-Y',strtotime($notify->created_date)),
                          'time'                 => date('h:i a',strtotime($notify->created_date)),
                          );
        }
           if($language_type=='en'){
           $msg = 'notification list seen successfully';
           }else if($language_type=='hi'){
            $msg = 'अधिसूचना सूची सफलतापूर्वक देखी गई';
           }
          $response = ['status'=>"SUCCESS",'message'=>$msg,'notificationList'=>$arr];
          echo json_encode($response);die;
         
        }else
        {
             $response['status']     = "FAILURE";
             if($language_type=='en'){
            $response['message']    = 'No record found';
             }else if($language_type=='hi'){
               $response['message']    = 'कोई रिकॉर्ड नहीं मिला।';  
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


  function notificationDetails()
  {
    $notification_id  = $this->input->post('notification_id');
    $language_type = $this->input->post('language_type'); 
   // $status  = $this->input->post('status');
    if(empty($notification_id))
    {
      $response['status']     = "FAILURE";
      $response['message']    = 'Booking id is empty';
      echo json_encode($response);die;
    }

   
     //  $this->my_model->update_data('notification',array('id'=>$notification_id),array('status'=>'1','badge_count'=>'0')); 
   // }

  $notify =   $this->user_model->notificationDetails(array('n.id'=>$notification_id));
  if(!empty($notify))
  {
   // foreach($notification as $notify)
    if($notify[0]->booking_type=="home")
    {
      $bookingType = "Home Visit";
    }else if($notify[0]->booking_type=="call")
    {
      $bookingType = "On Call";
    }

   $SpecialtyName =  $this->user_model->fetchValue('specility','name',array('id'=>$notify[0]->specialty));
       //  {
          $arr = array(
                          'user_name'      => $notify[0]->user_name,
                          'doctor_name'    => $notify[0]->doctor_name,
                           'doctor_id'     => $notify[0]->doctor_id,
                          'booking_id'    => $notify[0]->booking_id,
                          'image'          => $notify[0]->image,
                          'booking_type'   => $bookingType,
                          'specialty'      => ucwords($SpecialtyName),
                          'fees'           => $notify[0]->frees,
                          'clinic_name'    => $notify[0]->clinic_name,
                          'reason_visit'   => $notify[0]->reason_visit,
                          'member_name'    => $notify[0]->member_name,
                          'title'          => $notify[0]->title,
                          'message'        => $notify[0]->message,
                          'type'           => $notify[0]->type,
                          'date'           => date('d-m-Y',strtotime($notify[0]->created_date)),
                          'time'           => date('h:i A',strtotime($notify[0]->created_date)),
                          );
       // }
          if($language_type=='en'){
          $msg = 'notification detail seen successfully';
          }else if($language_type=='hi'){
          $msg = 'अधिसूचना विवरण सफलतापूर्वक देखा गया';
          }
          $response = ['status'=>"SUCCESS",'message'=>$msg,'notificationDetails'=>$arr];
          echo json_encode($response);die;
   //echo "<pre>";print_r($notification); 
  }else
  {
      $response['status']     = "FAILURE";
      if($language_type=='en'){
      $response['message']    = 'No record found';
       }else if($language_type=='hi'){
         $response['message']    = 'कोई रिकॉर्ड नहीं मिला';
      echo json_encode($response);die;
  }
  }

}


  //doctor tracking
  function doctorTrackingLatlong()
  {
     if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $booking_id = $this->input->post('booking_id');
       $language_type = $this->input->post('language_type'); 
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

        if (empty($booking_id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Booking id is empty';
            echo json_encode($response);die;
        }

       $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
       $userId = $checkToken[0]['id'];
      if($checkToken)
      {
      $bookingDetails =  $this->user_model->fieldCRow('doctor_tracking','user_lat,user_long,doctor_lat,doctor_long,status',array('booking_id'=>$booking_id)); 
      if(!empty($bookingDetails))
      {
    //  echo $this->db->last_query();die;

      $response = ['status'=>"SUCCESS",'message'=>"tracking",'tracking'=>$bookingDetails];
       echo json_encode($response);die;  

      
      }else
      {
        $response['status']     = "FAILURE";
        if($language_type=='en'){
        $response['message']    = 'No latlong found';
         }else if($language_type=='hi'){
          $response['message']    = 'No latlong found';  
         }
        echo json_encode($response);die;
      }
    }
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
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
    
      $status = $this->input->post('status'); // 1
      $notification_id = $this->input->post('notification_id');
      $language_type = $this->input->post('language_type'); 
     

     

  if (empty($notification_id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Notification id is empty';
            echo json_encode($response);die;
        }


    $update = $this->user_model->update_data('notification',array('status'=>'1'),array('id'=>$notification_id)) ;   
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

  function specificPromocode()
  {
    $user_id = $this->input->post('user_id');
    $promocode = $this->input->post('promocode');
    $doctorId = $this->input->post('doctor_id');
     $language_type = $this->input->post('language_type'); 
    //$userId = $this->input->post('user_id');
    $checkPromo =  $this->user_model->fieldCRow('doctor_specificpromo','id,validity,offer_discount',array('promocode'=>$promocode,'doctor_id'=>$doctorId));

     $checkUserPromo =  $this->user_model->fieldCRow(BOOKING,'id',array('promocode'=>$promocode,'user_id'=>$user_id));
    // echo $this->db->last_query();die;
     if($checkUserPromo)
        {
          $response['status']              = "FAILURE";
         if($language_type=='en'){
        $response['message']             = 'This promocode is already used';
         }else if($language_type=='hi'){
          $response['message']             = 'यह प्रोमोकोड पहले से ही इस्तेमाल किया गया है';  
         }
        echo json_encode($response);die;  
        }
    if($checkPromo)
    {
    $ExpDate =   $checkPromo->validity;
    $todayDate = date('Y-m-d');
    $discount  = $checkPromo->offer_discount;

      if($todayDate>$ExpDate)
      {
        $response['status']              = "FAILURE";
        if($language_type=='en'){
        $response['message']             = 'Expired promotional or Voucher Code.';
         }else if($language_type=='hi'){
          $response['message']             = 'प्रचारित प्रचार या वाउचर कोड।';  
         }
        echo json_encode($response);die;
      }

        $response['status']              = "SUCCESS";
        if($language_type=='en'){
        $response['message']             = 'promotional or Voucher Code is correct.';
         }else if($language_type=='hi'){
          $response['message']             = 'प्रचार या वाउचर कोड सही है।';  
         }
        $response['discount']             = $discount;
        echo json_encode($response);die; 
    }
    else
    {
       $response['status']     = "FAILURE";
       if($language_type=='en'){
       $response['message']    = 'Please enter a valid promotional or Voucher Code.';
        }else if($language_type=='hi'){
           $response['message']    = 'कृपया एक वैध प्रचारक या वाउचर कोड दर्ज करें।';  
        }
       echo json_encode($response);die; 
    }

  }


  //paytm generate checksum
 

function generateChecksum()
 {

     // $this->load->model('Encdec_paytm');
  // $token = $this->input->post('token'); 
    // if (empty($token)) {
    //         $response['status']  = "FAILURE";
    //         $response['message'] = 'Token is empty';
    //         echo json_encode($response);die;
    //     }
   // $checkToken =   $this->user_model->getCondResultArray(USER,'id,name',array('token'=>$token));
   //     $userId = $checkToken[0]['id'];
   //     $userName = $checkToken[0]['name'];
   //    if($checkToken)
   //    {     
   require_once(APPPATH."libraries/encdec_paytm.php");
 $checkSum = "";
// below code snippet is mandatory, so that no one can use your checksumgeneration url for other purpose .
$findme   = 'REFUND';
$findmepipe = '|';
$paramList = array();
$paramList["MID"] = '';
$paramList["ORDER_ID"] = '';
$paramList["CUST_ID"] = '';
$paramList["INDUSTRY_TYPE_ID"] = '';
$paramList["CHANNEL_ID"] = '';
$paramList["TXN_AMOUNT"] = '';
$paramList["WEBSITE"] = '';
//$merchentKey = 'izMBfkOlTL@DgF1v';
$merchentKey = 'lriR9t5cr%pZ2y&_';
foreach($_POST as $key=>$value)
{  
  $pos = strpos($value, $findme);
  $pospipe = strpos($value, $findmepipe);
  if ($pos === false || $pospipe === false) 
    {
        $paramList[$key] = $value;
    }
}

//Here checksum string will return by getChecksumFromArray() function.
//$checkSum = getChecksumFromString($paramList,$merchentKey);
    $checkSum = getChecksumFromArray($paramList,$merchentKey);
    $response['status']     = "SUCCESS";
    $response['message']    = 'check sum';
    $response['checksum']    = $checkSum;
    echo json_encode($response);
// }else
// {
//        $response['status']     = "FAILURE";
//        $response['message']    = 'token mismatch ...Please logOut.';
//         echo json_encode($response);die; 
// }

}

  // public function transaction_status()
  //   {
       
  //       if ($this->input->post()) {
  //           require_once(APPPATH."libraries/encdec_paytm.php");
  //           $ORDER_ID          = "";
  //           $requestParamList  = array();
  //           $responseParamList = array();
  //           $data              = $this->data;
  //           $requestParamList  = array("MID" => $data['MID'], "ORDERID" => $data['ORDERID']);

  //           $checkSum                         = getChecksumFromArray($requestParamList, 'B5@GcAs#ME6WKHiM');
  //           $requestParamList['CHECKSUMHASH'] = urlencode($checkSum);
  //           //$data['CHECKSUMHASH']

  //           $data_string = "JsonData=" . json_encode($requestParamList);
  //           //echo $data_string;

  //           $ch = curl_init(); // initiate curl
  //           //$url = "https://securegw-stage.paytm.in/merchant-status/getTxnStatus?";
  //           //$url = "https://pguat.paytm.com/oltp/HANDLER_INTERNAL/getTxnStatus?"; // where you want to post data
  //           //$url = "https://secure.paytm.in/oltp/HANDLER_INTERNAL/getTxnStatus?"; // where you want to post data

  //           $url = "https://securegw.paytm.in/merchant-status/getTxnStatus?";
  //           curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
  //           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
  //           curl_setopt($ch, CURLOPT_URL, $url);
  //           curl_setopt($ch, CURLOPT_POST, true); // tell curl you want to post something
  //           curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string); // define what you want to post
  //           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return the output in string format
  //           $headers   = array();
  //           $headers[] = 'Content-Type: application/json';
  //           curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  //           $output = curl_exec($ch); // execute
  //           $info   = curl_getinfo($ch);

  //           //echo "kkk".$output;
  //           $output = json_decode($output, true);
  //           echo json_encode(array("response" => $output));die;
  //       }
  //   }


    function addPayment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
      {
      $token = $this->input->post('token');
      $booking_id = $this->input->post('booking_id');
      $doctor_id = $this->input->post('doctor_id');
       $amount = $this->input->post('amount');
       $status  = $this->input->post('status');
       $transaction_id = $this->input->post('transaction_id');
       $order_id = $this->input->post('order_id');
       $type     = $this->input->post('type');
       $language_type = $this->input->post('language_type'); 
     

       if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
            echo json_encode($response);die;
        }

        if (empty($booking_id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Booking id is empty';
            echo json_encode($response);die;
        }

         if (empty($doctor_id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Doctor id is empty';
            echo json_encode($response);die;
        }


         if (empty($amount)) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Amount  is empty';
             }else if($language_type=='hi'){
              $response['message'] = 'कृपया राशि दर्ज करें';  
             }
            echo json_encode($response);die;
        }


         if (empty($status)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Payment status is empty';
            echo json_encode($response);die;
        }

        //  if (empty($transaction_id)) {
        //     $response['status']  = "FAILURE";
        //     $response['message'] = 'Transaction id is empty';
        //     echo json_encode($response);die;
        // }

        if (empty($order_id)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Order id is empty';
            echo json_encode($response);die;
        }
        if($status=="TXN_SUCCESS")
        {
         if($language_type=='en'){   
         $error_msg = 'Payment add Successfully.';
          }else if($language_type=='hi'){
             $error_msg = 'भुगतान सफलतापूर्वक जोड़ा गया।';
          }
         $statusMsg ="SUCCESS";
        }
        else if($status=="TXN_FAILURE")
        {
          if($language_type=='en'){  
          $error_msg = 'Payment failed.';
           }else if($language_type=='hi'){
             $error_msg = 'भुगतान असफल हुआ।';
           } 
          $statusMsg = "FAILURE";
        }

       $checkToken =   $this->user_model->getCondResultArray(USER,'id,name',array('token'=>$token));
       $userId = $checkToken[0]['id'];
       $userName = $checkToken[0]['name'];
      if($checkToken)
      {
         $insertPayment = array(
                                'user_id'         => $userId,
                                'doctor_id'       => $doctor_id,
                                'booking_id'      => $booking_id,
                                'trasaction_id'   => $transaction_id,
                                'order_id'        => $order_id,
                                'amount'          => $amount,
                                'status'          => $status,
                                'payment_type'    => $type,
                                'created_date'    => date('Y-m-d h:i:s'),
                               // 'time'            => date('Y-m-d h:i:s'),


                                );
        $insertid =  $this->user_model->insert_data('doctor_payment',$insertPayment);
        if($insertid)
        {
           //send notification start
        $doctorDetails = $this->user_model->fieldCondRow(DOCTOR,'id,name,device_token,device_type,notification_status,language_type',array('id'=>$doctor_id));
        $device_token       = $doctorDetails->device_token;
       $device_type         = $doctorDetails->device_type;
       $notification_status = $doctorDetails->notification_status;  
       $doctorName          = $doctorDetails->name; 
       $language_type1 = $doctorDetails->language_type; 
       if($status=='TXN_SUCCESS'){
      if($notification_status=="on"){  //check notification status
        $booking_id = $booking_id;
        if($language_type1=='en'){
        $message = "Hi ! Payment has been confirmed by ".ucwords($userName).", Please start the session";
        $title = "Hi ! Payment has been confirmed by ".ucwords($userName).", Please start the session";
         }else if($language_type1=='hi'){
           $message = "नमस्ते ! भुगतान की पुष्टि ".ucwords ($userName)." द्वारा की गई है। कृपया सत्र शुरू करें";
           $title = "नमस्ते ! भुगतान की पुष्टि ".ucwords ($userName)." द्वारा की गई है। कृपया सत्र शुरू करें"; 
         }
        $type = 'addPayment';
        $notificationData = array(
                                  'user_id'=> $userId,
                                  'doctor_id'=> $doctor_id,
                                  'booking_id'=> $booking_id,
                                  'title'=> $title,
                                  'message'=> $message,
                                  'type'   => $type,
                                  'status'=>'0',
                                  'badge_count'=>'1',
                                  'send_to'=>'doctor',
                                 // 'status'=>'1',
                                  'created_date'=> date('Y-m-d H:i:s'),
                                 );
      $notificationId =  $this->user_model->insert_data('notification',$notificationData);  
       $notificationCount = count($this->user_model->getCondResult('notification','id',array('doctor_id'=>$doctor_id,'status'=>'0','badge_count'=>'1','send_to'=>'doctor','type !='=>'adminChatDoctor'))); 
      if($device_type=="android"){
         $this->user_model->android_pushh1($device_token,$message,$title,$type,$notificationId,$notificationCount);
      }
      //ios
       if($device_type=="Iphone"){
          $this->user_model->iphone1($device_token,$message,$title,$type,$notificationId,$notificationCount);
      }
     }   //end check notification status
 }
    //send notification end 
          //update booking status
           if($status=="TXN_SUCCESS"){
            $bookingstatus = '3';
           }else {
            $bookingstatus = '6';  //if payment is faild then booking is not show anywhere
            }
          $this->user_model->update_data(BOOKING,array('booking_status'=>$bookingstatus),array('id'=>$booking_id)) ;  
         // echo $this->db->last_query();die;
          $response['status']     = $statusMsg;
          $response['message']    = $error_msg;

          echo json_encode($response);die;
        }
       }
      else
      {
            $response['status']     = "FAILURE";
            $response['message']    = 'token mismatch ...Please logOut.';
            echo json_encode($response);die;
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
      $data['about'] = $this->user_model->fieldCondRow(PAGE,'title,description',array('page_type'=>'0','type'=>'1'));
      $this->load->view('api/about_view_user',$data);
    }

    function termsAndConditions()
    {
      $data['terms'] = $this->user_model->fieldCondRow(PAGE,'title,description',array('page_type'=>'2','type'=>'1'));
      $this->load->view('api/terms_view_user',$data);
    }

 function faq()
    {
      $data['faq'] = $this->user_model->fieldCondRow(PAGE,'title,description',array('page_type'=>'1','type'=>'1'));
      $this->load->view('api/faq_view_user',$data);
    }
    
     function ploicy()
    {
      $data['policy'] = $this->user_model->fieldCondRow(PAGE,'title,description',array('page_type'=>'3','type'=>'1'));
      $this->load->view('api/policy_user',$data);
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
         
     $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));

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

  
 

   function GetDrivingDistance($lat1, $lat2, $long1, $long2)
{
   $u = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=bareilly&destinations=pilibhit&key=AIzaSyCHu8t8gkBK-yT0hkzrp5P5Fa51kFNUjUk";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $u);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
$response = curl_exec($ch);
curl_close($ch);
$response_a = json_decode($response, true);

    $x =  array('distance' => $dist, 'time' => $time);
    print_r($response_a);die;
}

  function SaveUserChat()
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
            if($language_type=='en'){
            $response['message'] = 'Message is empty';
             }else if($language_type=='hi'){
              $response['message'] = 'कृपया संदेश दर्ज करें';  
             }
            echo json_encode($response);die;
        }

         
   $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {
        $user_id = $checkToken[0]['id'];
        
      $insertData = array(
        
                        'user_id'=>$user_id,
                        'message'=>$message,
                        'sender_type'=>'sender',
                        'user_type'=>'user',
                        'status'=>'1',
                        'badge_count'=>'1',
                        'created_date'=> date('Y-m-d H:i:s'),
                       );

       

       

       $insertid =  $this->user_model->insert_data('doctor_chat',$insertData);
        $userChat = $this->user_model->userChat(array('user_id'=>$user_id));
        $this->load->model('com_model');
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
                              'user_name'=> $name,
                              'image'    => $image,
                              'message'=> $chat->message,
                              'sender_type'=>$chat->sender_type,
                              'time' => $time
                            );
       
        }

        


       
        //end of uploaded multiple images
      // echo $this->db->last_query();die;

      if($insertid){
       
            $response['status']     = "SUCCESS";
            if($language_type=='en'){
            $response['message']    = 'Message send successfully.';
             }else if($language_type=='hi'){
                $response['message']    = 'संदेश सफलतापूर्वक भेजा गया।'; 
             }
            $response['chatList'] = $chatArr;
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


         
   $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));
      if($checkToken)
      {
          $user_id = $checkToken[0]['id'];
         // $cond = "type!='adminChatUser' and user_id=$user_id and user_type='user'";
          $update = $this->user_model->update_data('notification',array('status'=>'1','badge_count'=>'0'),array('user_id'=>$user_id,'type'=>'user','type'=>'adminChatUser')) ; 
         // echo $this->db->last_query();
        $this->load->model('com_model');
       $userChat = $this->user_model->userChat(array('user_id'=>$user_id,'user_type'=>'user'));
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
                              'user_name'=> $name,
                              'image'    => $image,
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


         
     $checkToken =   $this->user_model->getCondResultArray(USER,'id',array('token'=>$token));

      if($checkToken)
      {
        
         $user_id =  $checkToken[0]['id'];
         $update = $this->user_model->update_data(USER,array('language_type'=>$language_type),array('id'=>$user_id)) ; 
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

//this is new api for search doctor
 function searchDoctor()
 {
        
        $language_type = $this->input->post('language_type');
        $doctor_type = trim($this->input->post('doctor_type'));
        $token = $this->input->post('token');
        $service_type = strtolower($this->input->post('service_type'));

         if (empty($token)) {
            $response['status']  = "FAILURE";
            $response['message'] = 'Token is empty';
           // $response['requestKey'] = "updatepassword";
            echo json_encode($response);die;
        } 
    if (empty($doctor_type)) {
            $response['status']  = "FAILURE";
            if($language_type=='en'){
            $response['message'] = 'Please select Doctor Type';
        }else if($language_type=='hi'){
            $response['message'] = 'कृपया डॉक्टर के प्रकार का चयन करें';
        }
           // $response['requestKey'] = "updatepassword";
            echo json_encode($response);die;
        } 
    
       $user = $this->user_model->getCondResultArray(USER,'address,office_address,latitude,longitude',array('token'=>$token));
     
       
       $latitude = $user[0]['latitude'];
       $longitude  = $user[0]['longitude'];

     if($service_type=='home'){
       $cond = "status='1' and verify_status='1' and specialty= '".$doctor_type."' and home_visit_type='yes'"; 
     }else if($service_type=='call'){
       $cond = "status='1' and verify_status='1' and specialty= '".$doctor_type."' and call_visit_type='yes'";  
     }
     $homeVisit =  $this->db->query("select id,name,mobile,email,specialty,license_no,experience,month,clinic_name,distance,image,qualification,frees,available_status,latitude,longitude from doctor_doctor where $cond")->result_array();
   // echo "<pre>";print_r($homeVisit);die;
       $doctor_id = $homeVisit[0]['id'];
    
      
        
     
    if($user[0]['address'])
     {
      $homeAdd = $user[0]['address'];
     }else{
      $homeAdd = "";
     }

     if($user[0]['office_address'])
     {
      $officeAdd = $user[0]['office_address'];
     }else
     {
      $officeAdd = " ";
     }

     //check booking 
     $checkUserBooking =  $this->user_model->getCondResultArray(BOOKING,'id',array('user_id'=>$user_id));
     $Promocode =  $this->user_model->fieldCRow('doctor_promocode','id,promo_code,validity,offer_discount,location',array('status'=>'1'));
     if($checkUserBooking)
     {
      $checkBooking = "1";
     }else{
      $checkBooking = "0";
     }

    

    
      if(!empty($homeVisit))
      {

        foreach($homeVisit as $home)
        {

           if($home['month'])
           {
               $month = $home['month'];
           }else
        {
              $month = "";
          }

     //check rating
      $doctorRating =  $this->user_model->AvgRating('doctor_rating',array('doctor_id'=>$home['id']));
     // echo $this->db->last_query();die;
      if($doctorRating->rate)
     {
      $rate = round($doctorRating->rate,1);
     }else
     {
      $rate = 5;
     }

       $latitudeFrom = $home['latitude'];
       $longitudeFrom = $home['longitude'];


    //Calculate distance from latitude and longitude
    $theta = $longitudeFrom - $longitude;
    $dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitude)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitude)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    $distance = ($miles * 1.609344).' km';
    $distance = round($distance,1);
    //End Calculate distance from latitude and longitude
       
       
       
       if($home['distance']=='')
       {
        $doctorDistance = 20;
       } else
       {
        $doctorDistance = $home['distance']; 
       }
       if($distance <= $doctorDistance){

      $specialtyName =  $this->user_model->fieldCondRow('specility','name,hi_name',array('id'=>$home['specialty']));
     if($language_type=='en'){
        $speName = $specialtyName->name;
     }else if($language_type=='hi'){
       $speName = $specialtyName->hi_name; 
     }

          $homeArr[] = array(
                              
                              'id' => $home['id'], 
                              'name' => $home['name'],  
                              'mobile' => $home['mobile'],  
                              'email' => $home['email'],  
                              'specialty' => $speName,  
                              'license_no' => $home['license_no'],  
                              'experience' => $home['experience'],  
                              'month' => $month,   
                              'clinic_name' => $home['clinic_name'], 
                              'distance' => $distance, 
                              'image' => $home['image'], 
                              'qualification' => $home['qualification'],
                               'frees' => $home['frees'], 
                               'home_address'=> $homeAdd,
                               'office_address' => $officeAdd, 
                               'available_status'=> $home['available_status'],
                               'rating' => "$rate",
                              // 'mydis'=>$home['distance'],
                            );
       }
    }
  //echo "<pre>";print_r($homeArr);die;

       //sort by distance array 
         $distance = array();
         foreach($homeArr as $key=>$home1)
         {
         
          $distance[$key] = $home1['distance'];
       
         }
         array_multisort($distance, SORT_ASC, $homeArr);
           
         //end sort by distance array 
        if($language_type=='en'){
        $msg = 'search record show successfully.';
     }else if($language_type=='hi'){
        $msg = 'रिकॉर्ड सफलतापूर्वक दिखाया गया है';
     }
      $response = [ 'status' => "SUCCESS",'message'=>$msg,'checkBooking'=>$checkBooking,'promocode'=>$Promocode,'doctorListing' => $homeArr];
      //echo "<pre>";print_r($response);die;
      echo json_encode($response);die;
  }else
  {  
      if($language_type=='en'){
     $response = [ 'status' => "FAILURE",'message' => 'No record found!'];
     }else if($language_type=='hi'){
      $response = [ 'status' => "FAILURE",'message' => 'कोई रिकॉर्ड नहीं मिला!'];  
     }
      echo json_encode($response);die;
  }
 }


  function test1()
  {
    $device_token = 'eQbPFGRJqS4:APA91bGmgbz5bJ12KZ9ph7_r9sUAI9lTPyQKlnFqIvVQgZu9xmF0G8hSJnyLCtSG5v8KdPUwH5-KRo63kHaLPg0gkSGyKAhuIHTCOG9UebqZDy4AgtrPq05_PJFleSNXvUVSsNZw1FI_';
   $x = $this->user_model->android_pushh1($device_token,"msg","title","type",2,4);
   print_r($x);die;
  }

}
?>
