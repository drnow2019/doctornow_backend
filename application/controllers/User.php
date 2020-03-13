<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/////====	START LEAD CONTROLLERS CLASS   =======///////
class User extends MY_Controller
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
		    $tables = USER;
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
        $config['base_url']    = base_url('user/ajaxPaginationData');
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
		    $config['colspan']     = 9;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;

        $this->ajax_pagination->initialize($config);

	   	$conditions['start'] = $offset;
	   	$conditions['limit'] = $this->perPage;  
		  $data['user'] = $this->com_model->getRows($tables,$fields,$cond,$conditions);
	
		//echo $this->db->last_query();die;
	    $data['title']  = COMPANYNAME.' | User';	
	    $this->load->view('common/header',$data);
	    $this->load->view('common/left-sidebar');
	    $this->load->view('user/user_view');
	    $this->load->view('common/footer');
	}

	function ajaxPaginationData()
	{
		$this->load->library('Ajax_pagination');
	   		
        $conditions = array();
        $tables = USER;
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
        $config['base_url']    = base_url().'user/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $perPage;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;
		    $config['colspan']     = 9;
        $this->ajax_pagination->initialize($config);
        
        $conditions['start'] = $offset;
        $conditions['limit'] = $perPage;
        
        $data['user'] = $this->com_model->getRows($tables,$fields,$cond,$conditions);
        //echo $this->db->last_query();die;
        $this->load->view('user/user_in', $data, false);
    }

  public function add()
  {
         $data['country']  = $this->my_model->getfields1('countries','*');

         $data['title']  = COMPANYNAME.' | Add User';	
	     $this->load->view('common/header',$data);
	     $this->load->view('common/left-sidebar');
	     $this->load->view('user/adduser_view');
	     $this->load->view('common/footer');

  }	



    public function adduser()

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
    //end upload image	
    
    
     $address = $this->input->post('address');
      if(!empty($address))
      {
      $res = $this->user_model->getLatLong($address);
      $latitude =  $res['latitude'];
      $longitude =  $res['longitude'];
      }
       $insertData = array(

                             'name'        => $this->input->post('name'),
                             'email'       => $this->input->post('email'),
                             'dob'         => date('Y-m-d',strtotime($this->input->post('dob'))),
                             'mobile'      => $this->input->post('phone'),
                             'gender'      => $this->input->post('gen'),
                             'password'    => md5($this->input->post('password')),
                             'address'      => $this->input->post('address'),
                             'latitude'     => $latitude,
                             'longitude'     => $longitude,
                             'image'       => $image,
                           //  'country_id'  => $this->input->post('country'),
                             //'city_id'   => $this->input->post('city'),
                            // 'state_id'  => $this->input->post('state'),
                             'status'       => '1',
                             'created_date' =>date('Y-m-d h:i:s'),

		                    );
      // echo "<pre>";
     //  print_r($insertData);die;
      
		$insert =$this->my_model->insert_data(USER,$insertData);
    // echo $this->db->last_query(); die;
		//echo $this->db->last_query();die;
		if($insert)
		{
           $this->msgsuccess("User Created Successfully");
           redirect('user');
        }   
       else
       {
       	 $this->msgwarning("User Not Created Successfully");
       	 redirect('user');
       }

    }


     public function edit($id="")
  {  
  	   $data['user']  = $this->my_model->getfields(USER,'*',array('id'=>$id));
  	 // $data['country']  = $this->my_model->getfields1('countries','*','');
  	//  $data['state']  = $this->my_model->getfields1('states','*','');
  	       //  $data['city']  = $this->my_model->getfields1('cities','*','');
       $data['title']  = COMPANYNAME.' | Edit User';	
	    $this->load->view('common/header',$data);
	    $this->load->view('common/left-sidebar');
	    $this->load->view('user/edituser_view');
	    $this->load->view('common/footer');

  }	


   public function edituser()

    {
        
        //start upload iamge
    	$image = $this->input->post('img');
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
    //end upload image
       $user_id = $this->input->post('user_id');
       $pass  = $this->input->post('password');
       
        $address = $this->input->post('address');
      if(!empty($address))
      {
      $res = $this->user_model->getLatLong($address);
      $latitude =  $res['latitude'];
      $longitude =  $res['longitude'];
      }
       $updateData = array(

                             'name'        => $this->input->post('name'),
                             'email'       => $this->input->post('email'),
                             'dob'         => date('Y-m-d',strtotime($this->input->post('dob'))),
                             'mobile'      => $this->input->post('phone'),
                             'gender'      => $this->input->post('gen'),
                             //'password'    => md5($this->input->post('password')),
                             'address'      => $this->input->post('address'),
                             'latitude'     => $latitude,
                             'longitude'     => $longitude,
                             //'status'       => '1',
                             'image'        => $image,
                             'updated_date' =>date('Y-m-d h:i:s'),

		                    );

       $passwordData = array('password'=>md5($pass));
        if($pass){
       $updateData = array_merge($updateData,$passwordData);
        }
      // echo"<pre>";
      // print_r($updateData);die;
		$update =$this->my_model->update_data(USER,array('id'=>$user_id),$updateData);
		//echo $this->db->last_query();die;
		if($update)
		{
           $this->msgsuccess("User Updated Successfully");
           redirect('user');
        }   
       else
       {
       	 $this->msgwarning("User Not Updated Successfully");
       	 redirect('user');
       }

    }

  public function deleteRecords()
  {

	  $tablename = strrev($this->input->post('table'));
		$fieldname = $this->input->post('fieldname');
		$fieldvalue = $this->input->post('fieldvalue');
		//print_r($tablename);
		
		 $cond = array($fieldname=>$fieldvalue);
	    $delete =$this->my_model->deleteRow(USER,$cond);
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
      $checkemail  = $this->my_model->getfields(USER,'email',array('email'=>$email));
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
       $phone = trim($this->input->post('phone'));	
       $checkMobile  = $this->my_model->getfields(USER,'mobile',array('mobile'=>$phone));
      if(!empty($checkMobile))
      {
      	echo 1;
      }else
      {
      	echo 0;
      }

    }
    //for edit 
     public function updateMobile()
    {
       $phone = trim($this->input->post('phone'));
       $user_id=$this->input->post('user_id');
       $cond = "mobile=$phone and id!=$user_id";
       $checkMobile  = $this->my_model->getfields(USER,'mobile',$cond);
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
       $email = $this->input->post('email');
       $user_id=$this->input->post('user_id');
       $cond = "email = $email and id!=$user_id";
       $checkEmail  = $this->my_model->getfields(USER,'email',array('email'=>$email,'id !='=>$user_id));
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


   public function faimlymember($id)
  {    $data['user_id'] = $this->uri->segment(3);
       $data['member']  = $this->my_model->getfields('user_member','*',array('user_id'=>$id));
       $data['title']  = COMPANYNAME.' | Faimly Member'; 
       $this->load->view('common/header',$data);
       $this->load->view('common/left-sidebar');
       $this->load->view('user/family_member_view');
       $this->load->view('common/footer');

  } 

  public function addmember($id)
  {    
       $data['user_id'] = $this->uri->segment(3);
       $data['member']  = $this->my_model->getfields('user_member','*',array('user_id'=>$id));
       $data['title']  = COMPANYNAME.' | Faimly Member'; 
       $this->load->view('common/header',$data);
       $this->load->view('common/left-sidebar');
       $this->load->view('user/add_faimly_member');
       $this->load->view('common/footer');

  } 

  public function addmembervalue($id)
  {
    $insertData = array(
                        'user_id' => $this->input->post('user_id'),
                        'name' => $this->input->post('name'),
                        'dob'   => date('Y-m-d',strtotime($this->input->post('dob'))),
                        'relationship'  => $this->input->post('relationship'),
                        'gender' => $this->input->post('gen'),
                        'status'         => '1',
                        'created_date' => date('Y-m-d h:i:s'),
                       );


      $insert =$this->my_model->insert_data('user_member',$insertData);
    // echo $this->db->last_query(); die;
    //echo $this->db->last_query();die;
    if($insert)
    {
           $this->msgsuccess("User Member added Successfully");
           redirect('user');
        }   
       else
       {
         $this->msgwarning("User Member added Successfully");
         redirect('user');
       }

  }


 public function editmember($id)
  {    
      
       $data['member']  = $this->my_model->getfields('user_member','*',array('id'=>$id));
       $data['title']  = COMPANYNAME.' | Edit  Member'; 
       $this->load->view('common/header',$data);
       $this->load->view('common/left-sidebar');
       $this->load->view('user/edit_faimly_member');
       $this->load->view('common/footer');

  } 

 public function editmembervalue()
 {
   $id = $this->input->post('member_id');
   $insertData = array(
                        //'user_id' => $this->input->post('user_id'),
                        'name' => $this->input->post('name'),
                        'dob'   => date('Y-m-d',strtotime($this->input->post('dob'))),
                        'relationship'  => $this->input->post('relationship'),
                        'gender' => $this->input->post('gen'),
                        'status'         => '1',
                        'created_date' => date('Y-m-d h:i:s'),
                       );


      $insert =$this->my_model->update_data('user_member',array('id'=>$id),$insertData);
    // echo $this->db->last_query(); die;
    //echo $this->db->last_query();die;
    if($insert)
    {
           $this->msgsuccess("User Member edit Successfully");
           redirect('user');
        }   
       else
       {
         $this->msgwarning("User Member edit Successfully");
         redirect('user');
       }
 } 
  function change_status()
  {
    if($_GET['status']=='0'){ $status='1'; }
      else if($_GET['status']=='1'){ $status='0'; }
      else { $status=$_GET['status']; }
      if($_GET['status']=='1')
      {
        $msg = "User Blocked Successfully.";
      }else
      {
        $msg = "User Unblocked Successfully.";
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
  
  function medicalHistory($id="")
  {
       //$user_id = $this->input->post('id');
         $data['username']   = $this->user_model->fetchValue(USER,'name',array('id'=>$id));
         $data['hospital']  = $this->my_model->getfields('user_hospital_records','id,hospital_name,provider_name,provider_specility,service_date',array('user_id'=>$id,'user_type'=>'user'));
         $data['lab']       = $this->my_model->getfields('user_lab_records','id,lab_name	,prescription_name,lab_date',array('user_id'=>$id,'user_type'=>'user'));
         $data['pharmacy']  = $this->my_model->getfields('user_pharmacy_script','id,pharmacy_name,pharmacy_provider_name,service_date',array('user_id'=>$id,'user_type'=>'user'));
         $data['physical']  = $this->my_model->getfields('user_physical_therapist_records','id,therapy_name	,therapy_date',array('user_id'=>$id,'user_type'=>'user'));
         $data['specialty']  = $this->my_model->getfields('user_specialty_records','id,specialty,specialty_type,service_date',array('user_id'=>$id,'user_type'=>'user'));
         $data['other']     = $this->my_model->getfields('user_other_records','id,description,date',array('user_id'=>$id));
         $data['title']     = COMPANYNAME.' | Medical Records';	
	     $this->load->view('common/header',$data);
	     $this->load->view('common/left-sidebar');
	     $this->load->view('user/medical_history_view',$data);
	     $this->load->view('common/footer');
     
  }
  
  
   function membermedicalHistory($id="")
  {      //here user id is member id
       //$user_id = $this->input->post('id');
         $data['username']   = $this->user_model->fetchValue('user_member','name',array('id'=>$id));
         $data['hospital']  = $this->my_model->getfields('user_hospital_records','id,hospital_name,provider_name,provider_specility,service_date',array('user_id'=>$id,'user_type'=>'member'));
         $data['lab']       = $this->my_model->getfields('user_lab_records','id,lab_name	,prescription_name,lab_date',array('user_id'=>$id,'user_type'=>'member'));
         $data['pharmacy']  = $this->my_model->getfields('user_pharmacy_script','id,pharmacy_name,pharmacy_provider_name,service_date	',array('user_id'=>$id,'user_type'=>'member'));
         $data['physical']  = $this->my_model->getfields('user_physical_therapist_records','id,therapy_name	,therapy_date',array('user_id'=>$id,'user_type'=>'member'));
         $data['specialty']  = $this->my_model->getfields('user_specialty_records','id,specialty,specialty_type,service_date',array('user_id'=>$id,'user_type'=>'member'));
         $data['other']     = $this->my_model->getfields('user_other_records','id,description,date',array('user_id'=>$id,'user_type'=>'member'));
         $data['title']     = COMPANYNAME.' | Medical Records';	
	     $this->load->view('common/header',$data);
	     $this->load->view('common/left-sidebar');
	     $this->load->view('user/member_medical_history_view',$data);
	     $this->load->view('common/footer');
     
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
  
  
  function test()
  {
      $lat = "28.5355161";
      $long ="77.3910265";
     // $res= $this->db->query("SELECT id, ( 6371   * acos( cos( radians($lat) ) * cos( radians( latitude) ) * cos( radians(longitude) - radians($long) ) + sin( radians($lat) ) * sin( radians(latitude) ) ) ) AS distance FROM doctor_docotr HAVING distance < 25 ORDER BY distance;
   
//")->result();

   $doctor = $this->my_model->custom("SELECT id,name, ( 3959 * acos( cos( radians($lat) ) * cos( radians(latitude) ) * cos( radians(longitude ) - radians($long) ) + sin( radians($lat) ) * sin( radians(latitude) ) ) ) AS distance FROM doctor_user HAVING distance < 25 ORDER BY distance LIMIT 0 , 20
");
     echo"<pre>";
     print_r($doctor);
  }

}
?>
