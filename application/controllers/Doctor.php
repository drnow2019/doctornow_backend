<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/////====	START LEAD CONTROLLERS CLASS   =======///////
class Doctor extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
	    $this->load->model('my_model');
		$this->load->model('com_model');
		$this->load->model('user_model');
	   	$this->perPage = 10;
      
       // if($this->session->userdata('user_logged_in')==FALSE):
       //   redirect('logout');
       // endif;
		
	} 
	   

public function index()
	{ 
      $this->load->library('Ajax_pagination');
		  $tables = DOCTOR;
		  $data = array();
	  	$cond = "id > 0 ";
		  $keywords   = $this->input->get('keywords');
      $sortBy 	 = $this->input->get('sortBy');
      $perPage 	 = $this->input->get('perpage');
      $activePage  = $this->input->get('activePage');

   
       
      $page = $this->input->get('page');
        if(!$page)
            $offset = 0;
        else
            $offset = $page; 

        if($perPage)
			$this->perPage = $perPage;

	
		if($keywords){
			
				$cond .= " AND (concat(name LIKE '%".$keywords."%' OR email LIKE '%".$keywords."%' OR mobile LIKE '%".$keywords."%' ) )";

		  }
		    $fields = "*";
        $totalRec = $this->com_model->cuntrows($tables,"id",$cond);
        $config['target']      = '#postList';
        $config['base_url']    = base_url('doctor/ajaxPaginationData');
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
		    $config['colspan']     = 9;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;

        $this->ajax_pagination->initialize($config);

	   	$conditions['start'] = $offset;
	   	$conditions['limit'] = $this->perPage;  
		  $data['doctor'] = $this->com_model->getRows($tables,$fields,$cond,$conditions);
	
		//echo $this->db->last_query();die;
	   $data['title']  = COMPANYNAME.' | Doctor';	
	   $this->load->view('common/header',$data);
	   $this->load->view('common/left-sidebar');
	   $this->load->view('doctor/doctor_view');
	   $this->load->view('common/footer');
	}

	function ajaxPaginationData()
	{
		$this->load->library('Ajax_pagination');
	   		
        $conditions = array();
        $tables = DOCTOR;
        //calc offset number
        $page = $this->input->get('page');
        if(!$page)
            $offset = 0;
        else
            $offset = $page;
        
	      $keywords   = $this->input->get('keywords');
        $perPage 	= $this->input->get('perpage');
        $activePage = $this->input->get('activePage');
        $cond       = " id > 0";
        
		  if($keywords){
			
				$cond .= " AND (concat(name LIKE '%".$keywords."%' OR email LIKE '%".$keywords."%' OR mobile LIKE '%".$keywords."%' )) ";

		  }
		    $fields = "*";
		    $totalRec = $this->com_model->cuntrows($tables,"id",$cond);
		    $config['target']      = '#postList';
        $config['base_url']    = base_url().'doctor/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $perPage;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;
		    $config['colspan']     = 9;
        $this->ajax_pagination->initialize($config);
        
        $conditions['start'] = $offset;
        $conditions['limit'] = $perPage;
        
        $data['doctor'] = $this->com_model->getRows($tables,$fields,$cond,$conditions);
       // echo $this->db->last_query();die;
        $this->load->view('doctor/doctor_in', $data, false);
    }

  public function add()
  {   $data['country']  = $this->my_model->getfields1('countries','*');
       $data['qualification'] = $this->my_model->getfields('doctor_qualification','id,name',array('status'=>'1'));
       $data['city'] = $this->my_model->getfields('doctor_city','id,name',array('status'=>'1'));
       $data['specialtyList'] = $this->my_model->getfields('specility','id,name',array('status'=>'1'));
       $data['title']  = COMPANYNAME.' | Add Doctor';	
	     $this->load->view('common/header',$data);
	     $this->load->view('common/left-sidebar');
	     $this->load->view('doctor/adddoctor_view');
	     $this->load->view('common/footer');

  }	



    public function adddoctor()

    {
        
         //start upload iamge
    	$image = '';
      if (!empty($_FILES['profile']['name'])) {

            $type     = explode('.', $_FILES["profile"]["name"]);
            $type     = strtolower($type[count($type) - 1]);
            $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "user_profile/" . $filename;

            move_uploaded_file($_FILES["profile"]["tmp_name"], $url);
            $data['image'] = $filename;
            $image = base_url('user_profile/').$filename;
           // $imgArr = array('image'=>$image);
        }
        
          flush();
    //end upload image	
   
   
      //start upload document image
    	$document = '';
      if (!empty($_FILES['document']['name'])) {

            $type     = explode('.', $_FILES["document"]["name"]);
            $type     = strtolower($type[count($type) - 1]);
            $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "document/" . $filename;

            move_uploaded_file($_FILES["document"]["tmp_name"], $url);
            $data['image'] = $filename;
            $document = base_url('document/').$filename;
           // $imgArr = array('image'=>$image);
        }
        
          flush();
    //end upload signature image
    
    	$signature_file = '';
      if (!empty($_FILES['digital_sign']['name'])) {

            $type     = explode('.', $_FILES["digital_sign"]["name"]);
            $type     = strtolower($type[count($type) - 1]);
            $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "signature/" . $filename;

            move_uploaded_file($_FILES["digital_sign"]["tmp_name"], $url);
            $data['image'] = $filename;
            $signature_file = base_url('signature/').$filename;
           // $imgArr = array('image'=>$image);
        }
        
         
    //end upload document
      $address = $this->input->post('address');
      if(!empty($address))
      {
      $res = $this->user_model->getLatLong($address);
      $latitude =  $res['latitude'];
      $longitude =  $res['longitude'];
      }
     //get latlong
     
        //end
	
       $personalData = array(

                             'name'        => $this->input->post('name'),
                             'email'       => $this->input->post('email'),
                             'dob'         => date('Y-m-d',strtotime($this->input->post('dob'))),
                             'mobile'      => $this->input->post('mobile'),
                             'gender'      => $this->input->post('gen'),
                             'password'     => md5($this->input->post('password')),
                             'address'      => $this->input->post('address'),
                             'latitude'     => $latitude,
                             'longitude'     => $longitude,
                               'country_id'  => $this->input->post('country'),
                             'city_id'       => $this->input->post('city'),
                            'state_id'       => $this->input->post('state'),
                             'image'         => $image,
                             'status'         => '1',
                             'verify_status'  =>'1',
                        
                             'created_date'   =>date('Y-m-d h:i:s'),

		                    );
	if($this->input->post('home_visit_type')=="yes")
	{
	  $homeFrees = $this->user_model->fetchValue('doctor_fees','frees',array('status'=>'1'));
	    
	}
	
		if($this->input->post('call_visit_type1')=="yes")
	{
	  $callFrees = $this->user_model->fetchValue('doctor_fees','call_fees',array('status'=>'1'));
	    
	}

       $perofessionalData = array(

                             'specialty'            => $this->input->post('specialty'),
                             'license_no'           => $this->input->post('license'),
                             'document'             => $document,
                             'experience'           => $this->input->post('year'),
                             'month'                => $this->input->post('month'),
                             'qualification'        => $this->input->post('qualification'),
                             'frees'                => $homeFrees,
                             'call_fees'            => $callFrees,
                             'clinic_name'          => $this->input->post('clinic_name'),
                             'home_visit_type'      => $this->input->post('home_visit_type'),
                             'home_visit_days'      => implode(',',$this->input->post('home_visit_days')),
                             'call_visit_type'      => $this->input->post('call_visit_type1'),
                             'call_visit_days'      => implode(',',$this->input->post('call_visit_days')),
                             'city_operation'       => $this->input->post('city_operation'),
                             'distance'             => $this->input->post('distance'),
                              'digital_sign'        => $signature_file,
                             //'status'           =>'1', 
                             //'created_date' =>date('Y-m-d h:i:s'),

                        );
       //echo "<pre>";print_r($perofessionalData);die;

        $doctorArr=  array_merge($personalData,$perofessionalData);
        $insertid =$this->my_model->insert_data(DOCTOR,$doctorArr);
       // echo $this->db->last_query();die;

        $bankData = array(
                              'doctor_id'       => $insertid,
                             'bank_name'        => $this->input->post('bank_name'),
                             'ac_holder'       => $this->input->post('holder_name'),
                             'account_no'         => $this->input->post('account_no'),
                             'ifsc_code'      => $this->input->post('ifsc_code'),
                             'status'       => '1',
                             'created_date' =>date('Y-m-d h:i:s'),

                        );


        $insertBank =$this->my_model->insert_data(BANK,$bankData);
		//echo $this->db->last_query();die;
		//echo $this->db->last_query();die;
		if($insertid)
		{
           $this->msgsuccess("Doctor Created Successfully");
           redirect('doctor');
        }   
       else
       {
       	 $this->msgwarning("Doctor Not Created Successfully");
       	 redirect('doctor');
       }

    }


     public function edit($id="")
  {  
  	    $data['doctor']  = $doctor= $this->my_model->getfields(DOCTOR,'*',array('id'=>$id));
  	    $data['bank']  = $this->my_model->getfields(BANK,'id,bank_name,account_no,ac_holder,ifsc_code,status',array('doctor_id'=>$id));
        $data['qualification'] = $this->my_model->getfields('doctor_qualification','id,name',array('status'=>'1'));
        $data['city'] = $this->my_model->getfields('doctor_city','id,name',array('status'=>'1'));
        $data['specialtyList'] = $this->my_model->getfields('specility','id,name',array('status'=>'1'));
         $data['country']   = $this->my_model->getfields1('countries','*');
         $data['state']  = $con_id  = $this->my_model->getfields('states','*',array('country_id'=> $doctor[0]->country_id));
          $data['citys']  = $this->my_model->getfields('cities','*',array('state_id'=> $doctor[0]->state_id));

         $data['title']  = COMPANYNAME.' | Edit Doctor';	
  	    $this->load->view('common/header',$data);
  	    $this->load->view('common/left-sidebar');
  	    $this->load->view('doctor/editdoctor_view');
  	    $this->load->view('common/footer');

  }	


   public function editdoctor()

    {
       $docotr_id = $this->input->post('doctor_id');
       $document = $this->input->post('document1');
       $signature_file = $this->input->post('digital_sign1');
       $image = $this->input->post('profile1');
       
        //start upload iamge
    //	$image = '';
      if (!empty($_FILES['profile']['name'])) {

            $type     = explode('.', $_FILES["profile"]["name"]);
            $type     = strtolower($type[count($type) - 1]);
            $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "user_profile/" . $filename;

            move_uploaded_file($_FILES["profile"]["tmp_name"], $url);
            $data['image'] = $filename;
            $image = base_url('user_profile/').$filename;
           // $imgArr = array('image'=>$image);
        }
        
          flush();
    //end upload image	
   
   
      //start upload document image
    //	$document = '';
      if (!empty($_FILES['document']['name'])) {

            $type     = explode('.', $_FILES["document"]["name"]);
            $type     = strtolower($type[count($type) - 1]);
            $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "document/" . $filename;

            move_uploaded_file($_FILES["document"]["tmp_name"], $url);
            $data['image'] = $filename;
            $document = base_url('document/').$filename;
           // $imgArr = array('image'=>$image);
        }
        
          flush();
    //end upload signature image
    
    //	$signature_file = '';
      if (!empty($_FILES['digital_sign']['name'])) {

            $type     = explode('.', $_FILES["digital_sign"]["name"]);
            $type     = strtolower($type[count($type) - 1]);
            $name     = mt_rand(10000000, 99999999);
            $filename = $name . '.' . $type;

            $url = "signature/" . $filename;

            move_uploaded_file($_FILES["digital_sign"]["tmp_name"], $url);
            $data['image'] = $filename;
            $signature_file = base_url('signature/').$filename;
           // $imgArr = array('image'=>$image);
        }
        
         
    //end upload document
       $address = $this->input->post('address');
      if(!empty($address))
      {
      $res = $this->user_model->getLatLong($address);
      $latitude =  $res['latitude'];
      $longitude =  $res['longitude'];
      }
        
       $personalData = array(

                             'name'        => $this->input->post('name'),
                             'email'       => $this->input->post('email'),
                             'dob'         => date('Y-m-d',strtotime($this->input->post('dob'))),
                             'mobile'      => $this->input->post('mobile'),
                             'gender'      => $this->input->post('gen'),
                            // 'password'    => md5($this->input->post('password')),
                             'address'      => $this->input->post('address'),
                             'latitude'     => $latitude,
                             'longitude'     => $longitude,
                              'country_id'  => $this->input->post('country'),
                             'city_id'   => $this->input->post('city'),
                            'state_id'  => $this->input->post('state'),
                             'image'       => $image,
                            // 'status'       => '1',
                             'updated_date' =>date('Y-m-d h:i:s'),

		                    );

       $perofessionalData = array(

                             'specialty'        => $this->input->post('specialty'),
                             'license_no'       => $this->input->post('license'),
                             'document'         => $document,
                            // 'experience'      => $this->input->post('exp'),
                            'experience'           => $this->input->post('year'),
                             'month'                => $this->input->post('month'),
                             'clinic_name'      => $this->input->post('clinic_name'),
                             'home_visit_type'    => $this->input->post('home_visit_type'),
                             'home_visit_days'      => implode(',',$this->input->post('home_visit_days')),
                             'call_visit_type'       => $this->input->post('call_visit_type1'),
                             'call_visit_days'       => implode(',',$this->input->post('call_visit_days')),
                             'city_operation'       => $this->input->post('city_operation'),
                             'distance'       => $this->input->post('distance'),
                              'digital_sign'       => $signature_file,
                             //'status'           =>'1', 
                             //'created_date' =>date('Y-m-d h:i:s'),

                        );
       //echo "<pre>";print_r($perofessionalData);die;

        $doctorArr=  array_merge($personalData,$perofessionalData);
       $update =$this->my_model->update_data(DOCTOR,array('id'=>$docotr_id),$doctorArr);
      //  echo $this->db->last_query();die;

        $bankData = array(
                              //'doctor_id'       => $insertid,
                             'bank_name'        => $this->input->post('bank_name'),
                             'ac_holder'       => $this->input->post('holder_name'),
                             'account_no'         => $this->input->post('account_no'),
                             'ifsc_code'      => $this->input->post('ifsc_code'),
                             'status'       => '1',
                            // 'created_date' =>date('Y-m-d h:i:s'),

                        );


       $update =$this->my_model->update_data(BANK,array('doctor_id'=>$docotr_id),$bankData);

       if($update)
		{
           $this->msgsuccess("Doctor Updated Successfully");
           redirect('doctor');
        }   
       else
       {
       	 $this->msgwarning("Doctor Not  Updated");
       	 redirect('doctor');
       }

    }

  public function deleteRecords()
  {

	    $tablename = strrev($this->input->post('table'));
		$fieldname = $this->input->post('fieldname');
		$fieldvalue = $this->input->post('fieldvalue');
		//print_r($tablename);
		
		$cond = array($fieldname=>$fieldvalue);
	    $delete =$this->my_model->deleteRow(DOCTOR,$cond);
	   if($delete):
			$this->msgsuccess("Record has been successfully deleted ");
			echo "ok";
		else:
			$this->msgerror("Record deletion failed ");
			echo "fail";
		endif;
		//print_r($deleteval);
  		return TRUE;

	
  }
    
    public function checkemail()
    {
       $email = $this->input->post('email');	
      $checkemail  = $this->my_model->getfields(DOCTOR,'email',array('email'=>$email));
      if(!empty($checkemail))
      {
      	echo 1;
      }else
      {
      	echo 0;
      }

    }

     public function checkmobile()
    {
       $phone = $this->input->post('phone');
       $checkMobile  = $this->my_model->getfields(DOCTOR,'mobile',array('mobile'=>$phone));
      // echo $this->db->last_query();die;
      if(!empty($checkMobile))
      {
      	echo 1;
      }else
      {
      	echo 0;
      }

    }
    
    
    //for edit
    
     //for edit 
     public function updateMobile()
    {
       $phone = trim($this->input->post('phone'));
       $user_id=$this->input->post('user_id');
       $cond = "mobile=$phone and id!=$user_id";
       $checkMobile  = $this->my_model->getfields(DOCTOR,'mobile',$cond);
      if(!empty($checkMobile))
      {
      	echo 1;
      }else
      {
      	echo 0;
      }

    }
    
    function updateEmail()
    {
       $email = trim($this->input->post('email'));
       $user_id=$this->input->post('user_id');
       $cond = "email = $email and id!=$user_id";
       $checkEmail  = $this->my_model->getfields(DOCTOR,'email',array('email'=>$email,'id !='=>$user_id));
     //  print_r($checkEmail);die;
      // echo $this->db->last_query();die;
      if(!empty($checkEmail))
      {
         echo 1; 
      }else
      {
          echo 0;
      }
      
    }
    
      function change_status()
  {
    if($_GET['status']=='0'){ $status='1'; }
      else if($_GET['status']=='1'){ $status='0'; }
      else { $status=$_GET['status']; }
      if($_GET['status']=='1')
      {
        $msg = "Doctor Blocked Successfully.";
      }else
      {
        $msg = "Doctor Unblocked Successfully.";
      }
      $data = array( $_GET['statusfield'] => $status );
      $this->db->where($_GET['idfield'], $_GET['id']);
      $update=$this->db->update($_GET['table'], $data);
      //echo $this->db->last_query();
      if($update){ 
        echo "ok";
        $this->msgsuccess( $msg);
        
        }
      else { echo "fail";
        $this->msgwarning("Operation Failed ");
        }
  }
  
  
    function verifyStatus()
  {
    if($_GET['status']=='0'){ $status='1'; }
      else if($_GET['status']=='1'){ $status='0'; }
      else { $status=$_GET['status']; }
      if($_GET['status']=='1')
      {
        $msg = "Doctor Unverified Successfully.";
      }else
      {
        //send mail
        	 $this->load->model('Sendmail');
            $id = $_GET['id'];
           $doctor = $this->user_model->getCondResult(DOCTOR,'name,email',array('id'=>$id));
           $msg= "Dear ".ucfirst($doctor[0]->name)." ,<br>Thank you for registering with us!<br>
           Your account has been verified. Now you can login to your account.<br>
           Regards,<br>
           Dr. Now Team
           ";
             $this->Sendmail->sendmail($doctor[0]->email,'Account verification',$msg);
        //end send mail
        $msg = "Doctor Verified Successfully.";
      }
      $data = array( $_GET['statusfield'] => $status );
      $this->db->where($_GET['idfield'], $_GET['id']);
      $update=$this->db->update($_GET['table'], $data);
      //echo $this->db->last_query();
      if($update){ 
        echo "ok";
        $this->msgsuccess( $msg);
        
        }
      else { echo "fail";
        $this->msgwarning("Operation Failed ");
        }
  }




  function getstate()
  {
      $con_id = $this->input->post('con_id');
      $state =  $this->my_model->getfields('states','*',array('country_id'=>$con_id));
        $res = "<select name='state' class='form-control' onchange='getCity(this.value)'>";
        $res.= "<option value=''>Select State</option>";
      if(!empty($state))
      {
         foreach($state as $st)
         {
             $res .="<option value='$st->id'>$st->name</option>";
         }
         
      }
     $res .= "</select>"; 
     echo $res;
  }
  
  function getcity()
  {
       $state_id = $this->input->post('state_id');
      $city =  $this->my_model->getfields('cities','*',array('state_id'=>$state_id));
        $res = "<select name='city' class='form-control'>";
        $res.= "<option value=''>Select City</option>";
      if(!empty($city))
      {
         foreach($city as $cty)
         {
             $res .="<option value='$cty->id'>$cty->name</option>";
         }
         
      }
     $res .= "</select>"; 
     echo $res;
  }


 function earningHistory($id="")
 {
        $data['earning'] = $this->user_model->getCondResult(PAYMENT,'amount,created_date,payment_type',array('doctor_id'=>$id,'status'=>'TXN_SUCCESS'));
        $data['totalHome'] = $this->my_model->coutrow(PAYMENT,'id',array('doctor_id'=>$id,'payment_type'=>'home'));
        $data['totalcall'] = $this->my_model->coutrow(PAYMENT,'id',array('doctor_id'=>$id,'payment_type'=>'call'));
        $data['homeEarning'] = $this->user_model->fieldCRow(PAYMENT,'id,SUM(amount) as amount',array('doctor_id'=>$id,'payment_type'=>'home'));
       $data['callEarning'] = $this->user_model->fieldCRow(PAYMENT,'id,SUM(amount) as amount',array('doctor_id'=>$id,'payment_type'=>'call'));
        $data['title']  = COMPANYNAME.' | Earning History';  
        $this->load->view('common/header',$data);
        $this->load->view('common/left-sidebar');
        $this->load->view('doctor/earning_view');
        $this->load->view('common/footer');
 }
  

}
?>
