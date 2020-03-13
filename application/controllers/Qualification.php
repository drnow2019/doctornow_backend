<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/////====	START LEAD CONTROLLERS CLASS   =======///////
class Qualification extends MY_Controller
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
		$tables = 'doctor_qualification';
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
			
				$cond .= " AND (concat(name LIKE '%".$keywords."%' ) )";

		  }
		    $fields = "*";
        $totalRec = $this->com_model->cuntrows($tables,"id",$cond);
        $config['target']      = '#postList';
        $config['base_url']    = base_url('qualification/ajaxPaginationData');
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
		    $config['colspan']     = 9;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;

        $this->ajax_pagination->initialize($config);

	   	$conditions['start'] = $offset;
	   	$conditions['limit'] = $this->perPage;  
		  $data['qualification'] = $this->com_model->getRows($tables,$fields,$cond,$conditions);
	
		//echo $this->db->last_query();die;
	   $data['title']  = COMPANYNAME.' | Promo Code';	
	   $this->load->view('common/header',$data);
	   $this->load->view('common/left-sidebar');
	   $this->load->view('qualification/qualification_view');
	   $this->load->view('common/footer');
	}

	function ajaxPaginationData()
	{
		$this->load->library('Ajax_pagination');
	   		
        $conditions = array();
        $tables = 'doctor_qualification';
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
      
        $cond .= " AND (concat(name LIKE '%".$keywords."%' ) )";

      }
		    $fields = "*";
		    $totalRec = $this->com_model->cuntrows($tables,"id",$cond);
		    $config['target']      = '#postList';
        $config['base_url']    = base_url().'qualification/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $perPage;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;
		    $config['colspan']     = 9;
        $this->ajax_pagination->initialize($config);
        
        $conditions['start'] = $offset;
        $conditions['limit'] = $perPage;
        
        $data['qualification'] = $this->com_model->getRows($tables,$fields,$cond,$conditions);
        //echo $this->db->last_query();die;
        $this->load->view('qualification/qualification_in', $data, false);
    }

  public function add()
  {
       $data['title']  = COMPANYNAME.' | Add Qualification';	
	     $this->load->view('common/header',$data);
	     $this->load->view('common/left-sidebar');
	     $this->load->view('qualification/addqualification_view');
	     $this->load->view('common/footer');

  }	



    public function addqualification()

    {
   
   
       $qualificationData = array(

                             'name'      => strtoupper($this->input->post('qualification')),
                             'status'       => $this->input->post('status'),
                             'created_date'     =>date('Y-m-d h:i:s'),

		                    );

        $insertid =$this->my_model->insert_data('doctor_qualification',$qualificationData);
     

		if($insertid)
		{
           $this->msgsuccess("Qualification Added Successfully");
           redirect('qualification');
        }   
       else
       {
       	 $this->msgwarning("Qualification Not Added Successfully");
       	 redirect('qualification');
       }

    }


     public function edit($id="")
  {  
  	  $data['qualification']  = $this->my_model->getfields('doctor_qualification','id,name,status',array('id'=>$id));
  	   
      $data['title']  = COMPANYNAME.' | Edit Promocode';	
	    $this->load->view('common/header',$data);
	    $this->load->view('common/left-sidebar');
	    $this->load->view('qualification/editqualification_view');
	    $this->load->view('common/footer');

  }	


   public function editqualification()

    {   $id = $this->input->post('id');

       $qualificationData = array(

                             'name'      => strtoupper($this->input->post('qualification')),
                             'status'       => $this->input->post('status'),
                             'created_date'     =>date('Y-m-d h:i:s'),

                        );
        $update =$this->my_model->update_data('doctor_qualification',array('id'=>$id),$qualificationData);
      //  echo $this->db->last_query();die;
     

    if($update)
    {
           $this->msgsuccess("Qualification Updated Successfully");
           redirect('qualification');
        }   
       else
       {
         $this->msgwarning("Qualification Not Updated Successfully");
         redirect('qualification');
       }

    }

  
  


}
?>
