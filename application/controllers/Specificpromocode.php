<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/////====	START LEAD CONTROLLERS CLASS   =======///////
class Specificpromocode extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		
	    $this->load->model('my_model');
		$this->load->model('com_model');
	   	$this->perPage = 10;
		
	} 
	   

public function index()
	{ 
    $this->load->library('Ajax_pagination');
		$tables = 'doctor_specificpromo';
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
        $totalRec = count($this->com_model->specificPromo($conditions));
        $config['target']      = '#postList';
        $config['base_url']    = base_url('specificpromocode/ajaxPaginationData');
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
		$config['colspan']     = 9;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;

        $this->ajax_pagination->initialize($config);

	   	$conditions['start'] = $offset;
	   	$conditions['limit'] = $this->perPage;  
		$data['specificpromocode'] = $this->com_model->specificPromo($conditions);
//	echo"<pre>";print_r($data['specificpromocode']);die;
		//echo $this->db->last_query();die;
	   $data['title']  = COMPANYNAME.' | Specific Promo Code';	
	   $this->load->view('common/header',$data);
	   $this->load->view('common/left-sidebar');
	   $this->load->view('specificpromo/promo_view');
	    $this->load->view('common/footer');
	}

	function ajaxPaginationData()
	{
		$this->load->library('Ajax_pagination');
	   		
        $conditions = array();
        $tables = 'doctor_specificpromo';
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
		$totalRec = count($this->com_model->specificPromo($conditions));
		$config['target']      = '#postList';
        $config['base_url']    = base_url().'specificpromocode/ajaxPaginationData';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $perPage;
        $config['link_func']   = 'searchFilter';
        $config['activePage']  = $activePage;
		$config['colspan']     = 9;
        $this->ajax_pagination->initialize($config);
        
        $conditions['start'] = $offset;
        $conditions['limit'] = $perPage;
        
        $data['specificpromocode'] = $this->com_model->specificPromo($conditions);
        //echo $this->db->last_query();die;
        $this->load->view('specificpromo/promo_in', $data, false);
    }

  public function add()
  {
         $data['title']  = COMPANYNAME.' | Add Sepcific Promocode';	
         $data['doctor']  = $this->my_model->getfields(DOCTOR,'id,name',array('status'=>'1'));
         $data['user']  = $this->my_model->getfields(USER,'id,name',array('status'=>'1'));
         $data['specialty']  = $this->my_model->getfields('specility','id,name',array('status'=>'1'));
	     $this->load->view('common/header',$data);
	     $this->load->view('common/left-sidebar');
	     $this->load->view('specificpromo/addpromo_view');
	     $this->load->view('common/footer');

  }	



    public function addpromo()

    {
   
       $promocodeData = array(

                           //  'clinic_name'        => $this->input->post('clinic_name'),
                             'doctor_id'            => $this->input->post('doctor'),
                             'validity'          => date('Y-m-d',strtotime($this->input->post('validity'))),
                             'specialty_id'         => $this->input->post('specialty'),
                            // 'user_id'              => $this->input->post('user'),
                             'promocode'       => $this->input->post('promo_code'),
                             'offer_discount'    => $this->input->post('offer_discount'),
                            // 'location'         => $this->input->post('location'),
                             'status'           => '1',
                             'created_date'     =>date('Y-m-d h:i:s'),

		                    );

       
        $insertid =$this->my_model->insert_data('doctor_specificpromo',$promocodeData);
      // echo $this->db->last_query();die;

       
		if($insertid)
		{
           $this->msgsuccess("Specific Promo Code Created Successfully");
           redirect('specificpromocode');
        }   
       else
       {
       	 $this->msgwarning("Specific Promo code not Created Successfully");
       	 redirect('specificpromocode');
       }

    }


     public function edit($id="")
  {  
  	    $data['spePromo']  = $this->my_model->getfields('doctor_specificpromo','id,clinic_name,offer_discount,doctor_id,user_id,promocode,validity,specialty_id,',array('id'=>$id));
  	    $data['doctor']  = $this->my_model->getfields(DOCTOR,'id,name',array('status'=>'1'));
       //  $data['user']  = $this->my_model->getfields(USER,'id,name',array('status'=>'1'));
         $data['specialty']  = $this->my_model->getfields('specility','id,name',array('status'=>'1'));
        $data['title']  = COMPANYNAME.' | Edit';	
	    $this->load->view('common/header',$data);
	    $this->load->view('common/left-sidebar');
	    $this->load->view('specificpromo/editpromo_view');
	    $this->load->view('common/footer');

  }	


   public function editpromo()

    {
       $id= $this->input->post('promo_id');
       $promocodeData = array(

                          //   'clinic_name'        => $this->input->post('clinic_name'),
                             'doctor_id'            => $this->input->post('doctor'),
                             'validity'          => date('Y-m-d',strtotime($this->input->post('validity'))),
                             'specialty_id'         => $this->input->post('specialty'),
                           //  'user_id'              => $this->input->post('user'),
                             'promocode'       => $this->input->post('promo_code'),
                             'offer_discount'    => $this->input->post('offer_discount'),
                            // 'location'         => $this->input->post('location'),
                             'status'           => '1',
                             'created_date'     =>date('Y-m-d h:i:s'),

		                    );

       
        $insertid =$this->my_model->update_data('doctor_specificpromo',array('id'=>$id),$promocodeData);
      // echo $this->db->last_query();die;

       
		if($insertid)
		{
           $this->msgsuccess("Specific Promo Code Updated Successfully");
           redirect('specificpromocode');
        }   
       else
       {
       	 $this->msgwarning("Specific Promo Code not updated Successfully");
       	 redirect('specificpromocode');
       }

    }


    
  


}
?>
