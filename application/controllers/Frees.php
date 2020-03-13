<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/////====	START LEAD CONTROLLERS CLASS   =======///////
class Frees extends MY_Controller
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
     $data['frees']  = $this->my_model->getfields('doctor_fees','id,frees,status,call_fees',array('id'=>'1'));
	   $data['title']  = COMPANYNAME.' | Frees';	
	   $this->load->view('common/header',$data);
	   $this->load->view('common/left-sidebar');
	   $this->load->view('frees/frees_view');
	   $this->load->view('common/footer');
	}

	


   


   public function update()

    {   

       $freesData = array(

                             'frees'      => $this->input->post('frees'),
                             'call_fees'  => $this->input->post('call_fee'),
                            

                        );
        $update =$this->my_model->update_data('doctor_fees',array('id'=>'1'),$freesData);
      //  echo $this->db->last_query();die;
     

    if($update)
    {
           $this->msgsuccess("Frees Amount Updated Successfully");
           redirect('frees');
        }   
       else
       {
         $this->msgwarning("Frees Amount Not Updated Successfully");
         redirect('frees');
       }

    }

  
  


}
?>
