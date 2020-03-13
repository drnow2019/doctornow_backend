<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/////====	START LEAD CONTROLLERS CLASS   =======///////
class Api  extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		
	    $this->load->model('my_model');
		  $this->load->model('user_model');
	   	$this->perPage = 10;

       if($this->session->userdata('user_logged_in')==FALSE):
         redirect('logout');
       endif;
		
	} 


  function index()
  {
    echo "hello";
  }
	   

  
  


}
?>
