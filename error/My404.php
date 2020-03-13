<?php 
class my404 extends MY_Controller 
{
    public function __construct() 
    {
        parent::__construct(); 
        $this->load->helper('url');
    } 

    public function index() { 
	///echo "<h1>PAGE NOT FOUND</h1>";
		//$this->load->view('web/common/header');
		$this->load->view('errors/404');
		//$this->load->view('web/common/footer');
		
    } 
} 
?> 