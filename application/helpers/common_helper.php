<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function getCountryName($countryID=0){
	if($countryID>0){
		$CI =& get_instance();
	  $SETTING = $CI->db->select('name')
					  ->from('md_countries')
					  ->where('id',$countryID)
					  ->get()
					  ->row();
	 echo $billingtype = $SETTING->name;
		
	}
	
}

function get_BankDetaisl($bankDetailsID=0){
	if($bankDetailsID>0){
		$CI 		=& get_instance();
		$data 	= $CI->db->select('*')
					  ->from('md_bank_details')
					  ->where('id',$bankDetailsID)
					  ->get();
		if($data->num_rows()>0){		

			$details = $data->row();
			$address = '<table ><tr><th>A/C No :-</th> <td>'.$details->account_no.'</td></tr>';
			$address .= '<tr><th>Branch Name :-</th> <td> '.$details->branch_name.'</td></tr>';
			$address .= '<tr><th>Bank Name:- </th> <td> '.$details->bank_name.'</td></tr>';
			$address .= '<tr><th>IFSC No :- </th> <td> '.$details->ifsc_code.'</td></tr>';
			$address .= '<tr><th>Account Holder Name :- </th> <td> '.$details->account_holder_name.'</td></tr>';
			$address .= '<tr><th>Swift Code :-  </th> <td>'.$details->swift_code.'</td></tr>';
			return $address .= '<tr><th>Other Info :- </th> <td>'.$details->others.'</td></tr></table>';
			
		}	
	}
}

function getTotalExpertAmount($expertID){
	$CI =& get_instance();
	if($expertID>0){	
		
		$CI->db->select("SUM(credit)-sum(debit) AS total");
        $CI->db->from(EARNING);
        
        $CI->db->where('expert_id='.$expertID);
        $a=$CI->db->get();
        $data =  ($a->num_rows() > 0)?$a->row():0;
		if($a->num_rows()>0){
			return $data->total;
		}else{
			return 0;
		}
		
	}else{
		return 0;
	}	
}

function getStateName($stateID=0){
	if($stateID>0){
		$CI =& get_instance();
	    $SETTING = $CI->db->select('name')
					  ->from('md_states')
					  ->where('id',$stateID)
					  ->get()
					  ->row();
	  echo  $billingtype = $SETTING->name;
		
	}
	
}


function addmonth($billdate,$addmonth)
{
  $CI =& get_instance();
  $SETTING = $CI->db->select('billingtype')
                  ->from('isp_setting')
                  ->where('id','1')
                  ->get()
                  ->row();
  $billingtype = $SETTING->billingtype;

  if($billingtype == 1)
  {
      $datetime = new DateTime($billdate);
    
      $month  = $datetime->format('n'); //without zeroes
      $day    = $datetime->format('j'); //without zeroes
      $year   = $datetime->format('Y');
      
      if($day == 31 && $addmonth==1)
      {
             
             if($month==1){
               $datetime=new DateTime( $year.'-3-1');
             }
             else {
                   if($month==12){
                 $month = 1;
                 $year = $year+1;
                 }else $month= $month+1;
                  
                              $day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                  $datetime=new DateTime( $year.'-'.$month.'-'.$day );
            }
             
                      }else if($day == 29 || $day == 30){
            
                          if($month == 1 && $addmonth==1){
                   if($year%4 == 0){
                  $datetime->modify('+ '.$addmonth.'  month');  
                     }
                 else{
                 $datetime=new DateTime( $year.'-3-1');
                 } 
                                  
                          }else{
                              $datetime->modify('+ '.$addmonth.'  month');                                
                          }
                      }else{
                          $datetime->modify('+ '.$addmonth.'  month');
                      }
        $nextbilldate= $datetime->format('Y-m-d');
        return $nextbilldate;
  }
  else
  {

    $days = $addmonth*30;
    return date('Y-m-d', strtotime($billdate. "+".$days." days"));
  }
  
}

