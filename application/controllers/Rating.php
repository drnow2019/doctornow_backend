<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/////====	START LEAD CONTROLLERS CLASS   =======///////
class Rating extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
	    $this->load->model('my_model');
		$this->load->model('com_model');
		$this->load->model('user_model');
	   	$this->perPage = 10;
      
      // if($this->session->userdata('user_logged_in')==FALSE):
      //    redirect('logout');
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

	
		if(!empty($keywords))
             $conditions['search']['keywords'] = $keywords;
             
		    $fields = "*";
        $totalRec = count($this->com_model->rating($conditions));
        $config['target']      = '#postList';
        $config['base_url']    = base_url('rating/ajaxPaginationData');
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
		$config['colspan']     = 9;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;

        $this->ajax_pagination->initialize($config);

	   	$conditions['start'] = $offset;
	   	$conditions['limit'] = $this->perPage;  
		$data['rating'] = $this->com_model->rating($conditions);
	 // echo "<pre>";
	//  print_r($data['rating']);die;
		//echo $this->db->last_query();die;
	   $data['title']  = COMPANYNAME.' | Rating Management';	
	   $this->load->view('common/header',$data);
	   $this->load->view('common/left-sidebar');
	   $this->load->view('rating/rating_view');
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
        
		 	if(!empty($keywords))
             $conditions['search']['keywords'] = $keywords;
             
		 $fields = "*";
		$totalRec = count($this->com_model->rating($conditions));
		$config['target']      = '#postList';
        $config['base_url']    = base_url().'rating/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $perPage;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;
		$config['colspan']     = 9;
        $this->ajax_pagination->initialize($config);
        
        $conditions['start'] = $offset;
        $conditions['limit'] = $perPage;
        
        $data['rating'] = $this->com_model->rating($conditions);
       // echo $this->db->last_query();die;
        $this->load->view('rating/rating_in', $data, false);
    }

 


}
?>
