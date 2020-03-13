<?php 
session_start();
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Content  extends My_Controller
{
	public function __construct()
	{
		parent::__construct();
		
	    $this->load->model('my_model');
		$this->load->model('user_model');
		$this->load->model('com_model');
		//date_default_timezone_set('Asia/Calcutta'); 
	   	

	} 


	public function index()
	{

		    $this->load->library('Ajax_pagination');
		    $tables = PAGE;
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
        $config['base_url']    = base_url('content/ajaxPaginationData');
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
		$config['colspan']     = 9;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;

        $this->ajax_pagination->initialize($config);

	   	$conditions['start'] = $offset;
	   	$conditions['limit'] = $this->perPage;  
		$data['content'] = $this->com_model->getRows($tables,$fields,$cond,$conditions);
		$data['title']  = COMPANYNAME.' | Content Management';	
	    $this->load->view('common/header',$data);
	    $this->load->view('common/left-sidebar');
	    $this->load->view('page/static_content_view');
	    $this->load->view('common/footer');
	}


	function ajaxPaginationData()
	{
		$this->load->library('Ajax_pagination');
	   		
        $conditions = array();
        $tables = PAGE;
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
			
				$cond .= " AND (concat(title LIKE '%".$keywords."%' OR description LIKE '%".$keywords."%')) ";

		  }
		$fields = "*";
		$totalRec = $this->com_model->cuntrows($tables,"id",$cond);
		$config['target']      = '#postList';
        $config['base_url']    = base_url().'content/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $perPage;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;
		$config['colspan']     = 9;
        $this->ajax_pagination->initialize($config);
        
        $conditions['start'] = $offset;
        $conditions['limit'] = $perPage;
        
        $data['content'] = $this->com_model->getRows($tables,$fields,$cond,$conditions);
        //echo $this->db->last_query();die;
        $this->load->view('page/static_content_in', $data, false);
    }

    public function add()
  {
        $data['title']  = COMPANYNAME.' | Add Page';	
	    $this->load->view('common/header',$data);
	    $this->load->view('common/left-sidebar');
	    $this->load->view('page/addcontent_view');
	    $this->load->view('common/footer');

  }	
  
  public function addcontent(){
      
         $pageData = array(

                             'title'              => $this->input->post('title'),
                             'description'        => $this->input->post('description'),
                             'type'               => $this->input->post('type'),
                             'page_type'          => $this->input->post('page_type'),
                             'status'             => '1',
                             'created_date'      =>date('Y-m-d h:i:s'),

		                    );

        $insertid =$this->my_model->insert_data('doctor_page',$pageData);
     //echo $this->db->last_query();die;

		if($insertid)
		{
           $this->msgsuccess("Page Added Successfully");
           redirect('content');
        }   
       else
       {
       	 $this->msgwarning("Page Not Added Successfully");
       	 redirect('content');
       }
  }
  
   public function edit($id="")
  {
        $data['page']  = $this->my_model->getfields(PAGE,'id,title,description,type,page_type',array('id'=>$id));
        $data['title']  = COMPANYNAME.' | Add Page';	
	    $this->load->view('common/header',$data);
	    $this->load->view('common/left-sidebar');
	    $this->load->view('page/editcontent_view');
	    $this->load->view('common/footer');

  }	
  
  public function editcontent(){
         $id = $this->input->post('page_id');
         $pageData = array(

                             'title'              => $this->input->post('title'),
                             'description'        => $this->input->post('description'),
                             'type'               => $this->input->post('type'),
                             'page_type'          => $this->input->post('page_type'),
                             'status'             => '1',
                           

		                    );

       $update =$this->my_model->update_data(PAGE,array('id'=>$id),$pageData);
    // echo $this->db->last_query();die;
     

		if($update)
		{
           $this->msgsuccess("Page Updated Successfully");
           redirect('content');
        }   
       else
       {
       	 $this->msgwarning("Page Not Updated Successfully");
       	 redirect('content');
       }
  }
  
  
  

}