<?php 
ob_start();
session_start();
//session_start();
if(!defined('BASEPATH')) exit('No direct access allowed');
class MY_Controller extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Calcutta');
		
		
	}
	
////-------  SUCCESS MESSAGE FUNCTION IN -----///////
	public function msgsuccess($msg)
	{
		 $dvidata='<div class="alert alert-success alert-dismissable">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">
	  &times;</a> <strong>Success ! </strong>'.$msg.' .</div>';
	  return $this->session->set_flashdata('msg',$dvidata);
	}	  ////---  END MSGSUCCESS
	
////-------  ERROR MESSAGE FUNCTION IN -----///////
	public function msgerror($msg)
	{
		 $dvidata='<div class="alert alert-danger alert-dismissable">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">
	  &times;</a> <strong>Warning ! </strong>'.$msg.' .</div>';
	  return $this->session->set_flashdata('msg',$dvidata);
	} ////---- END MSGERROR----/////
	
////-------  WARNING MESSAGE FUNCTION IN -----///////
	public function msgwarning($msg)
	{
		 $dvidata='<div class="alert alert-warning alert-dismissable">
	  <a href="#" class="close" data-dismiss="alert" aria-label="close">
	  &times;</a> <strong>Warning ! </strong>'.$msg.' .</div>';
	  return $this->session->set_flashdata('msg',$dvidata);
	} ////---- END MSGWARNING----/////
			
	public function sendingSMS($mob, $msg)
		{	
	//error_reporting(E_ALL);
	//echo $mob.$msg;
			
			$this->load->library('twilio');

			$from = '+12013659534';
					$tobj = new Twilio();
			$response = $tobj->sms($from, $mob, $msg);

		if($response->IsError)
				echo 'Error: ' . $response->ErrorMessage;
			//else
			//echo 'Sent message to ' . $mob;
	//exit;
		}
		public function paginations($baseurl="",$showrecords,$total_rows)
	{		
		$controller = $this->router->fetch_class();	
		$method = $this->router->fetch_method();
		if($baseurl == ""){ $url=$controller.'/'.$method; }
		else if($baseurl != "admin"){ $url=$baseurl; }
		else { $url=$baseurl.'/'.$controller.'/'.$method; }
			$config         =   array(
				 'base_url'      =>  base_url($url),
				 'per_page'      =>  $showrecords,
				 'total_rows'    =>  $total_rows,
				 'num_links'    =>  5,
				 'next_link'    =>  ">",
				 'prev_link'    =>  "<",
				 'full_tag_open' =>  "<ul class='pagination'>",
				 'full_tag_close'=>  "</ul>",
				 'first_link'	=>"FIRST",
				 'first_tag_open'	=>"<li>",
				 'first_tag_close'	=>"</li>",
				 'last_link'	=>"LAST",
				 'last_tag_open'	=>"<li>",
				 'last_tag_close'	=>"</li>",
				 	 
				 'next_tag_open' =>  "<li>",
				 'next_tag_close'=>  "</li>",
				 'prev_tag_open' =>  "<li>",
				 'prev_tag_close'=>  "</li>",
				 'num_tag_open'  =>  "<li>",
				 'num_tag_close' =>  "</li>",
				 'cur_tag_open' =>  "<li class='active'><a>",
				 'cur_tag_close'=>  "</a></li>",	 			  
				 );
				 
			
				 
			return	$this->pagination->initialize($config);
			
	}
		
	}

	class Admin_Controller extends MY_Controller {
		public function __construct(){
			parent::__construct();
			 if($this->session->userdata('user_logged_in')!=TRUE AND $this->session->userdata('user_logged_in')!="admin" ):
			 	 redirect('admin/adminlogin/logout');
			 endif;
		}
		public function topbar(){
			$this->load->view('admin/common/header'); 
			$this->load->view('admin/common/left-sidebar');
		}
		public function footer(){
			$this->load->view('admin/common/footer');
		}


	}

	class Api_Controller extends MY_Controller{
		public function __construct(){
			parent::__construct();
		}
	}


