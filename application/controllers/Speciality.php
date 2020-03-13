<?php 
session_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Speciality  extends My_Controller
{
	public function __construct()
	{
		parent::__construct();
		
	    $this->load->model('my_model');
		$this->load->model('user_model');
		$this->load->model('com_model');
		//date_default_timezone_set('Asia/Calcutta'); 
		 // if($this->session->userdata('user_logged_in')==FALSE):
   //       redirect('logout');
   //     endif;
	   	

	} 


	public function index()
	{

		 $this->load->library('Ajax_pagination');
		    $tables = SPECIALITY;
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
			
				$cond .= " AND (concat(title LIKE '%".$keywords."%' OR description LIKE '%".$keywords."%') )";

		  }
		    $fields = "*";
        $totalRec = $this->com_model->cuntrows($tables,"id",$cond);
        $config['target']      = '#postList';
        $config['base_url']    = base_url('speciality/ajaxPaginationData');
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
		$config['colspan']     = 9;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;

        $this->ajax_pagination->initialize($config);

	   	$conditions['start'] = $offset;
	   	$conditions['limit'] = $this->perPage;  
		$data['speciality'] = $this->com_model->getRows($tables,$fields,$cond,$conditions);
		$data['title']  = COMPANYNAME.' | speciality Management';	
	    $this->load->view('common/header',$data);
	    $this->load->view('common/left-sidebar');
	    $this->load->view('speciality/speciality_view');
	    $this->load->view('common/footer');
	}


	function ajaxPaginationData()
	{
		$this->load->library('Ajax_pagination');
	   		
        $conditions = array();
        $tables = SPECIALITY;
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
			
				$cond .= " AND name LIKE '%".$keywords."%' ";

		  }
		 $fields = "*";
		 $totalRec = $this->com_model->cuntrows($tables,"id",$cond);
		$config['target']      = '#postList';
        $config['base_url']    = base_url().'speciality/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $perPage;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;
		$config['colspan']     = 9;
        $this->ajax_pagination->initialize($config);
        
        $conditions['start'] = $offset;
        $conditions['limit'] = $perPage;
        
        $data['speciality'] = $this->com_model->getRows($tables,$fields,$cond,$conditions);
        //echo $this->db->last_query();die;
        $this->load->view('speciality/speciality_in', $data, false);
    }

    public function add()
  {
       $data['title']  = COMPANYNAME.' | Add Speciality';	
	    $this->load->view('common/header',$data);
	    $this->load->view('common/left-sidebar');
	    $this->load->view('speciality/addspeciality_view');
	    $this->load->view('common/footer');

  }	
  
  public function addspeciality(){
      
         $insertData = array(

                             'name'          => $this->input->post('speciality_name'),
                              'hi_name'      => $this->input->post('hi_speciality_name'),
                             'status'        => $this->input->post('status'),
                             'created_date'  =>date('Y-m-d h:i:s'),

		                    );

        $insertid =$this->my_model->insert_data(SPECIALITY,$insertData);
     

		if($insertid)
		{
           $this->msgsuccess("Speciality Added Successfully");
           redirect('speciality');
        }   
       else
       {
       	 $this->msgwarning("Speciality Not Added Successfully");
       	 redirect('speciality');
       }
  }
  
   public function edit($id="")
  {
        $data['speciality']  = $this->my_model->getfields(SPECIALITY,'id,name,hi_name,status',array('id'=>$id));
        $data['title']  = COMPANYNAME.' | Edit Speciality';	
	    $this->load->view('common/header',$data);
	    $this->load->view('common/left-sidebar');
	    $this->load->view('speciality/editspeciality_view');
	    $this->load->view('common/footer');

  }	
  
  public function editspeciality(){
           $id = $this->input->post('spe_id');
         $insertData = array(

                             'name'          => $this->input->post('speciality_name'),
                              'hi_name'          => $this->input->post('hi_speciality_name'),
                             'status'        => $this->input->post('status'),
                            // 'created_date'  =>date('Y-m-d h:i:s'),

		                    );

       $update =$this->my_model->update_data(SPECIALITY,array('id'=>$id),$insertData);
     // echo $this->db->last_query();die;
     

		if($update)
		{
           $this->msgsuccess("Speciality Updated Successfully");
           redirect('speciality');
        }   
       else
       {
       	 $this->msgwarning("Speciality Not Updated Successfully");
       	 redirect('speciality');
       }
  }
  
  
  

}