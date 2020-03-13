<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/////====	START LEAD CONTROLLERS CLASS   =======///////
class Managecontact extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
	    $this->load->model('my_model');
		  $this->load->model('com_model');
	   	$this->perPage = 10;

       // if($this->session->userdata('user_logged_in')==FALSE):
       //   redirect('logout');
       // endif;
		
	} 
	   

public function index()
	{ 

    $this->load->library('Ajax_pagination');
		$tables = 'doctor_contact';
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
			
				$cond .= " AND (concat(clinic_name LIKE '%".$keywords."%' OR promo_code LIKE '%".$keywords."%' OR location LIKE '%".$keywords."%' ) )";

		  }
		    $fields = "*";
        $totalRec = $this->com_model->cuntrows($tables,"id",$cond);
        $config['target']      = '#postList';
        $config['base_url']    = base_url('managecontact/ajaxPaginationData');
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
		    $config['colspan']     = 9;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;

        $this->ajax_pagination->initialize($config);

	   	$conditions['start'] = $offset;
	   	$conditions['limit'] = $this->perPage;  
		  $data['promocode'] = $this->com_model->getRows($tables,$fields,$cond,$conditions);
	
		//echo $this->db->last_query();die;
	   $data['title']  = COMPANYNAME.' | Manage Contact';	
	   $this->load->view('common/header',$data);
	   $this->load->view('common/left-sidebar');
	   $this->load->view('managecontact/managecontact_view');
	   $this->load->view('common/footer');
	}

	function ajaxPaginationData()
	{
		$this->load->library('Ajax_pagination');
	   		
        $conditions = array();
        $tables = 'doctor_contact';
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
      
        $cond .= " AND (concat(clinic_name LIKE '%".$keywords."%' OR promo_code LIKE '%".$keywords."%' OR location LIKE '%".$keywords."%' ) )";

      }
		    $fields = "*";
		    $totalRec = $this->com_model->cuntrows($tables,"id",$cond);
		    $config['target']      = '#postList';
        $config['base_url']    = base_url().'managecontact/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $perPage;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;
		    $config['colspan']     = 9;
        $this->ajax_pagination->initialize($config);
        
        $conditions['start'] = $offset;
        $conditions['limit'] = $perPage;
        
        $data['promocode'] = $this->com_model->getRows($tables,$fields,$cond,$conditions);
        //echo $this->db->last_query();die;
        $this->load->view('promocode/promo_in', $data, false);
    }

  public function add()
  {
       $data['title']  = COMPANYNAME.' | Add Contact';	
	     $this->load->view('common/header',$data);
	     $this->load->view('common/left-sidebar');
	     $this->load->view('managecontact/addmanagecontact_view');
	     $this->load->view('common/footer');

  }	



    public function addcontact()

    {
   
   
       $contactData = array(

                           
                             'mobile'        => $this->input->post('contact_no'),
                             'location'    => $this->input->post('location'),
                             'status'           => '1',
                             'created_date'     =>date('Y-m-d h:i:s'),

		                    );

        $insertid =$this->my_model->insert_data('doctor_contact',$contactData);
     

		if($insertid)
		{
           $this->msgsuccess("New contact  Added Successfully");
           redirect('managecontact');
        }   
       else
       {
       	 $this->msgwarning("New contact Not Added Successfully");
       	 redirect('managecontact');
       }

    }


     public function edit($id="")
  {  
  	  
  	   $data['contact'] = $this->my_model->getfields('doctor_contact','id,mobile,status,location',array('id'=>$id));
        $data['title']  = COMPANYNAME.' | Edit Contact';	
	    $this->load->view('common/header',$data);
	    $this->load->view('common/left-sidebar');
	    $this->load->view('managecontact/editmanagecontact_view');
	    $this->load->view('common/footer');

  }	


   public function editcontact()

    {
        $contact_id = $this->input->post('contact_id');

             $contactData = array(

                           
                             'mobile'        => $this->input->post('contact_no'),
                             'location'    => $this->input->post('location'),
                             'status'           => '1',
                             'created_date'     =>date('Y-m-d h:i:s'),

		                    );
                        //print_r($promoData);die;

        $update =$this->my_model->update_data('doctor_contact',array('id'=>$contact_id),$contactData);
      // echo $this->db->last_query();die;
     

    if($update)
    {
           $this->msgsuccess("New contact  Updated Successfully");
           redirect('managecontact');
        }   
       else
       {
         $this->msgwarning("New contact  Updated Successfully");
         redirect('managecontact');
       }

    }

  
  


}
?>
