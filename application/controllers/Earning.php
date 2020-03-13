<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/////====	START LEAD CONTROLLERS CLASS   =======///////
class Earning extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
	    $this->load->model('my_model');
		$this->load->model('com_model');
        $this->load->model('user_model');
	   	$this->perPage = 10;
	   // if($this->session->userdata('user_logged_in')==FALSE):
    //      redirect('logout');
    //    endif;		
	} 
	   

public function index()
	{ 
    $this->load->library('Ajax_pagination');
	
		$data = array();
		$cond = "id > 0 ";
		$keywords   = $this->input->get('keywords');
        $sortBy 	 = $this->input->get('sortBy');
        $perPage 	 = $this->input->get('perpage');
        $activePage  = $this->input->get('activePage');
        
         if(!empty($keywords))
             $conditions['search']['keywords'] = $keywords;

   
       
      $page = $this->input->get('page');
        if(!$page)
            $offset = 0;
        else
            $offset = $page; 

        if($perPage)
			$this->perPage = $perPage;

	
	
		$fields = "*";
        $totalRec = count($this->com_model->earning($conditions));
        $config['target']      = '#postList';
        $config['base_url']    = base_url('earning/ajaxPaginationData');
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
		$config['colspan']     = 9;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;

        $this->ajax_pagination->initialize($config);

	   	$conditions['start'] = $offset;
	   	$conditions['limit'] = $this->perPage;  
		$data['earning'] = $this->com_model->earning($conditions);
//	echo"<pre>";print_r($data['payment']);die;
	//	echo $this->db->last_query();die;
	   $data['title']  = COMPANYNAME.' | Manage Earning';	
	   $this->load->view('common/header',$data);
	   $this->load->view('common/left-sidebar');
	   $this->load->view('earning/earning_view');
	    $this->load->view('common/footer');
	}

	function ajaxPaginationData()
	{
		$this->load->library('Ajax_pagination');
	   		
        $conditions = array();
     
        //calc offset number
        $page = $this->input->get('page');
        if(!$page)
            $offset = 0;
        else
            $offset = $page;
        
	    $keywords   = $this->input->get('keywords');
        $perPage 	= $this->input->get('perpage');
        $activePage = $this->input->get('activePage');
        //$cond       = " id > 0";
        
         if(!empty($keywords))
            $conditions['search']['keywords'] = $keywords;
        
		 
		$fields = "*";
		$totalRec = count($this->com_model->earning($conditions));
		$config['target']      = '#postList';
        $config['base_url']    = base_url().'earning/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $perPage;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;
		$config['colspan']     = 9;
        $this->ajax_pagination->initialize($config);
        
        $conditions['start'] = $offset;
        $conditions['limit'] = $perPage;
        
        $data['earning'] = $this->com_model->earning($conditions);
        //echo $this->db->last_query();die;
        $this->load->view('earning/earning_in', $data, false);
    }



 function history($id="")
 {
        $data['earning'] = $this->user_model->getCondResult(PAYMENT,'amount,created_date,payment_type',array('doctor_id'=>$id,'status'=>'TXN_SUCCESS'));
        $data['totalHome'] = $this->my_model->coutrow(PAYMENT,'id',array('doctor_id'=>$id,'payment_type'=>'home'));
        $data['totalcall'] = $this->my_model->coutrow(PAYMENT,'id',array('doctor_id'=>$id,'payment_type'=>'call'));
        $data['homeEarning'] = $this->user_model->fieldCRow(PAYMENT,'id,SUM(amount) as amount',array('doctor_id'=>$id,'payment_type'=>'home'));
       $data['callEarning'] = $this->user_model->fieldCRow(PAYMENT,'id,SUM(amount) as amount',array('doctor_id'=>$id,'payment_type'=>'call'));
       $data['doctor_name'] = $this->user_model->fetchValue(DOCTOR,'name',array('id'=>$id));
        $data['title']  = COMPANYNAME.' | Earning History';  
        $this->load->view('common/header',$data);
        $this->load->view('common/left-sidebar');
        $this->load->view('doctor/earning_view');
        $this->load->view('common/footer');
 }
    
  


}
?>
