<?php 
session_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rejectreason  extends My_Controller
{
	public function __construct()
	{
		parent::__construct();
		
	    $this->load->model('my_model');
		$this->load->model('user_model');
		$this->load->model('com_model');
		//date_default_timezone_set('Asia/Calcutta'); 
	   // if($this->session->userdata('user_logged_in')==FALSE):
    //      redirect('logout');
    //    endif; 	

	} 


	public function index()
	{

		 $this->load->library('Ajax_pagination');
		    $tables = REASON;
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
        $config['base_url']    = base_url('rejectreason/ajaxPaginationData');
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
		$config['colspan']     = 9;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;

        $this->ajax_pagination->initialize($config);

	   	$conditions['start'] = $offset;
	   	$conditions['limit'] = $this->perPage;  
		$data['rejectreason'] = $this->com_model->getRows($tables,$fields,$cond,$conditions);
		$data['title']  = COMPANYNAME.' | Reject Reason Management';	
	    $this->load->view('common/header',$data);
	    $this->load->view('common/left-sidebar');
	    $this->load->view('rejectreason/rejectreason_view');
	    $this->load->view('common/footer');
	}


	function ajaxPaginationData()
	{
		$this->load->library('Ajax_pagination');
	   		
        $conditions = array();
        $tables = REASON;
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
        $config['base_url']    = base_url().'rejectreason/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $perPage;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;
		$config['colspan']     = 9;
        $this->ajax_pagination->initialize($config);
        
        $conditions['start'] = $offset;
        $conditions['limit'] = $perPage;
        
        $data['rejectreason'] = $this->com_model->getRows($tables,$fields,$cond,$conditions);
        //echo $this->db->last_query();die;
        $this->load->view('rejectreason/rejectreason_in', $data, false);
    }

    public function add()
  {
       $data['title']  = COMPANYNAME.' | Add Reject Reason';	
	    $this->load->view('common/header',$data);
	    $this->load->view('common/left-sidebar');
	    $this->load->view('rejectreason/addrejectreason_view');
	    $this->load->view('common/footer');

  }	
  
  public function addrejectreason(){
      
         $insertData = array(

                             'name'          => $this->input->post('reason_name'),
                             'hi_name'          => $this->input->post('hi_reason_name'),
                             'status'        => $this->input->post('status'),
                             'created_date'  =>date('Y-m-d h:i:s'),

		                    );
		                  //  echo "<pre>";print_r($insertData);die;

        $insertid =$this->my_model->insert_data(REASON,$insertData);
      //  echo $this->db->last_query();die;
     

		if($insertid)
		{
           $this->msgsuccess("Reason Added Successfully");
           redirect('rejectreason');
        }   
       else
       {
       	 $this->msgwarning("Reason Not Added Successfully");
       	 redirect('rejectreason');
       }
  }
  
   public function edit($id="")
  {
        $data['rejectreason']  = $this->my_model->getfields(REASON,'id,name,hi_name,status',array('id'=>$id));
        $data['title']  = COMPANYNAME.' | Edit Reject Reason';	
	    $this->load->view('common/header',$data);
	    $this->load->view('common/left-sidebar');
	    $this->load->view('rejectreason/editrejectreason_view');
	    $this->load->view('common/footer');

  }	
  
  public function editrejectreason(){
           $id = $this->input->post('res_id');
         $insertData = array(

                             'name'          => $this->input->post('reason_name'),
                             'hi_name'          => $this->input->post('hi_reason_name'),
                             'status'        => $this->input->post('status'),
                            // 'created_date'  =>date('Y-m-d h:i:s'),

		                    );

       $update =$this->my_model->update_data(REASON,array('id'=>$id),$insertData);
     // echo $this->db->last_query();die;
     

		if($update)
		{
           $this->msgsuccess("Reason Updated Successfully");
           redirect('rejectreason');
        }   
       else
       {
       	 $this->msgwarning("Reason Not Updated Successfully");
       	 redirect('rejectreason');
       }
  }
  
  
  

}