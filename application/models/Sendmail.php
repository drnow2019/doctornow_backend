<?php
	////--- SEND MAIL FROM SEND GRID MODELS ------/////
class Sendmail extends CI_Model
{
	function __construct() 
	  {
		/* Call the Model constructor */
		parent::__construct();
		$this->load->library('email');
		
			

		
	  }
	public function index()
		{   //// call DEFAULT FINCTION IN INDEX    
		}
	/////----- EMAIL SENDING SCRIPT MODEL -----/////	
  	public function sendmail($to,$subject,$msg){ 
		$this->email->initialize(
			array(
          'protocol' => 'smtp',
          'smtp_host' => 'ssl://smtp.gmail.com',
          'smtp_user' => 'testmobulous123@gmail.com',
                  'smtp_pass' => 'testmobulous123',
          'smtp_port' => 465,
          'mailtype' => 'html',
          'crlf' => "\r\n",
          'newline' => "\r\n"
        )
      );

    //$msg = "hellonew";
   //$to1 = "anas@finesofttechnologies.com";
		$this->email->from('info@doctornow.com', ' DOCTOR NOW ');
		$this->email->to($to);
		//$this->email->cc('another@another-example.com');
		//$this->email->bcc('them@their-example.com');
		$htmltemplates='
		<table cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff" style="width:600px;border:1px solid #42B599;"> 
   <tbody>
   <tr> 
     <td align="center" bgcolor="#42B599" style="line-height:0px">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="line-height:0px"> 
       <tbody>
        <tr> 
         <td style="height:50px; line-height:50px; text-align:center; color:#fff; font-family:arial; font-size:18px; font-weight:600;">DOCTOR NOW</td> 
        </tr> 
       
       
        <tr> 
         <td bgcolor="#42B599"></td> 
        </tr> 
       </tbody>
      </table></td> 
    </tr>
    <tr> 
<td>
<table style="width:100%; font-size:14px; padding:20px; font-family:arial;">
<tr><td>
'.$msg.'
</td></tr>
<tr><td>&nbsp;</td></tr>

</table>	 
</td> 
    </tr> 
   
      
    <tr> 
     <td align="center" bgcolor="#42B599" style="line-height:0px">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" style="line-height:0px"> 
       <tbody>
        <tr> 
         <td style="height:25px; line-height:25px; text-align:center; color:#fff; font-family:arial; font-size:12px; font-weight:600;"></td> 
        </tr> 
       
       
        <tr> 
         <td bgcolor="#ff2341"></td> 
        </tr> 
       </tbody>
      </table></td> 
    </tr>
   </tbody>
  </table> ';
	//echo $htmltemplates; exit;
		$this->email->subject($subject);
		$this->email->message($htmltemplates);
		$this->email->send();
	//	echo $this->email->print_debugger();
				
	}	
  
}		
