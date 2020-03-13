<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
       $this->load->model('user_model');
	   $this->load->model('My_model');
    } 
	   
	/* public function index($catid='')
	{
		$js = 'style="border:1px solid #999; padding:5px;"';

		if($catid=='1'){
			$complaint_arr = unserialize(COMPLAINTARR);
			echo form_dropdown('subcat',$complaint_arr,set_value('subcat',3),$js ); 
		}
		if($catid=='2'){
			$renewal_arr = unserialize(RENEWALARR);
			echo form_dropdown('subcat',$renewal_arr,set_value('subcat',3),$js ); 
		}
	} */
	
	
	
		////////--------  CHANGE STATUS FOR COMMON ---------///////
	 	public function change_status()
		{ 
		//print_r($_GET);
			if($_GET['status']=='0'){ $status='1'; }
			else if($_GET['status']=='1'){ $status='0'; }
			else { $status=$_GET['status']; }
			
			$data = array( $_GET['statusfield'] => $status );
			$this->db->where($_GET['idfield'], $_GET['id']);
			$update=$this->db->update($_GET['table'], $data);
			//echo $this->db->last_query();
			if($update){ 
				echo "ok";
				$this->msgsuccess("Status change successfully ");
				
				}
			else { echo "fail";
				$this->msgwarning("Operation Failed ");
				}
		
		}  /////-------  CLOSE CHANGE STATUS 

	public function setSideMenuState()
	{
	   $currClass = $this->input->get("curClass");
	   $cookieName = "sideBarStateName";
	   if($currClass=="skin-blue sidebar-mini sidebar-collapse")
	   {
	    $cookivalue = "skin-blue sidebar-mini";
	   }
	   else
	   {
	     $cookivalue = "skin-blue sidebar-mini sidebar-collapse";
	   }	
	   setcookie($cookieName,$cookivalue,time()+31556926 ,'/');
	   
	   //echo $_COOKIE[$cookieName];
	} 

	public function del_single(){		
	    $tablename = strrev($this->input->post('table'));
		$fieldname = $this->input->post('fieldname');
		$fieldvalue = $this->input->post('fieldvalue');
		//print_r($tablename);
		
		$cond = array($fieldname=>$fieldvalue);
		$this->db->where($cond);
  		$deleteval = $this->db->delete($tablename);
  		
  		$this->db->cache_delete_all();
		if($deleteval):
			$this->msgsuccess("Record has been successfully deleted ");
			echo "ok";
		else:
			$this->msgerror("Record deletion failed ");
			echo "fail";
		endif;
		//print_r($deleteval);
  		return TRUE;
	}
	
	public function status_change(){
		$transactionID = $this->input->post('transactionID');
		$requestID 	= $this->input->post('requestID');
		
		if($transactionID !='' && $requestID >0){
			$data = array( 'status' => 2 ,'update_date'=>date('Y-m-d H:i:s'));
			$this->db->where('id', $requestID );		
			$update=$this->db->update('md_request_payment', $data);
			$transactionDetais = $this->db->select("*")->from('md_request_payment')->where('id='.$requestID)->get()->row();
			
			$expertId = $transactionDetais->expert_id;
			$request_amount = $transactionDetais->request_amount;
			if($update){ 
				$data = array(
						'expert_id'		=>$expertId,
						'debit'		=>$request_amount,
						'transaction_id'=>$transactionID,
						'status'		=>1,
					);
				$insertData = $this->My_model->insert_data('md_expert_earning',$data);
				if($insertData){
					 $this->msgsuccess("Status change successfully..");
					redirect('admin/paymentrequest'); 
				}else{
					$this->msgerror("Status not changged successfully.");
					redirect('admin/paymentrequest'); 
				}
			}else{
				$this->msgerror("Status not changged successfully.");
				redirect('admin/paymentrequest'); 
			}
			
		}else{
			$this->msgerror("Status not changged successfully.");
			redirect('admin/paymentrequest'); 
		}		
		
	}
	
	
	
}


?>