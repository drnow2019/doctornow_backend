<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/////====	START LEAD CONTROLLERS CLASS   =======///////
class Promocode extends MY_Controller
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
		$tables = PROMOCODE;
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
        $config['base_url']    = base_url('promocode/ajaxPaginationData');
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
	   $data['title']  = COMPANYNAME.' | Promo Code';	
	   $this->load->view('common/header',$data);
	   $this->load->view('common/left-sidebar');
	   $this->load->view('promocode/promo_view');
	   $this->load->view('common/footer');
	}

	function ajaxPaginationData()
	{
		$this->load->library('Ajax_pagination');
	   		
        $conditions = array();
        $tables = PROMOCODE;
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
        $config['base_url']    = base_url().'promocode/ajaxPaginationData';
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
       $data['title']  = COMPANYNAME.' | Add Promocode';	
	     $this->load->view('common/header',$data);
	     $this->load->view('common/left-sidebar');
	     $this->load->view('promocode/addpromo_view');
	     $this->load->view('common/footer');

  }	



    public function addpromo()

    {
   
   
       $promoData = array(

                            // 'clinic_name'      => $this->input->post('clinic_name'),
                             'promo_code'        => $this->input->post('promo_code'),
                             'offer_discount'    => $this->input->post('offer_discount'),
                             'validity'         => date('Y-m-d',strtotime($this->input->post('validity'))),
                             'location'         => $this->input->post('location'),
                             'status'           => '1',
                             'created_date'     =>date('Y-m-d h:i:s'),

		                    );

        $insertid =$this->my_model->insert_data(PROMOCODE,$promoData);
     

		if($insertid)
		{
           $this->msgsuccess("Promocode Added Successfully");
           redirect('promocode');
        }   
       else
       {
       	 $this->msgwarning("Promocode Not Added Successfully");
       	 redirect('promocode');
       }

    }


     public function edit($id="")
  {  
  	  $data['promocode']  = $this->my_model->getfields(PROMOCODE,'id,promo_code,validity,status,location,offer_discount',array('id'=>$id));
  	   
      $data['title']  = COMPANYNAME.' | Edit Promocode';	
	    $this->load->view('common/header',$data);
	    $this->load->view('common/left-sidebar');
	    $this->load->view('promocode/editpromo_view');
	    $this->load->view('common/footer');

  }	


   public function editpromo()

    {
        $promo_id = $this->input->post('promo_id');

       $promoData = array(

                            // 'clinic_name'      => $this->input->post('clinic_name'),
                             'promo_code'       => $this->input->post('promo_code'),
                              'offer_discount'    => $this->input->post('offer_discount'),
                             'validity'         => date('Y-m-d',strtotime($this->input->post('validity'))),
                             'location'         => $this->input->post('location'),
                            // 'status'           => '1',
                             'updated_date'     =>date('Y-m-d h:i:s'),

                        );
                        //print_r($promoData);die;

        $update =$this->my_model->update_data(PROMOCODE,array('id'=>$promo_id),$promoData);
      // echo $this->db->last_query();die;
     

    if($update)
    {
           $this->msgsuccess("Promocode Updated Successfully");
           redirect('promocode');
        }   
       else
       {
         $this->msgwarning("Promocode Not Updated Successfully");
         redirect('promocode');
       }

    }

  
  


}
?>
