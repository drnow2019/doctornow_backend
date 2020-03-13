<?php
class Com_model extends CI_Model
{   
    public function getRows($tables,$fields,$cond,$params = array())
    {     
		$this->db->cache_on();
		$this->db->cache_off();
        $this->db->select($fields);
        $this->db->from($tables);
        if($cond != ""):
			$this->db->where($cond);
		endif;
        //sort data by ascending or desceding order
        $this->db->order_by('id','desc');

        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit'],$params['start']);
        elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit']);
        
        //get records
        $query = $this->db->get();
		$this->db->cache_off();
		//echo $this->db->last_query();
        //return fetched data
        return ($query->num_rows() > 0)?$query->result():NULL;
    }
	

    
	public function cuntrows($tables,$fields,$cond)
    {     
        $this->db->select($fields);
        $this->db->from($tables);
        if($cond != ""):
			$this->db->where($cond);
		endif;
        //sort data by ascending or desceding order
        $this->db->order_by('id','desc');

        //set start and limit
       /*  if(array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit'],$params['start']);
        elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit']);
         */
        //get records
        $query = $this->db->get();
		//echo $this->db->last_query();
        //return fetched data
        return ($query->num_rows() > 0)?$query->num_rows():NULL;
    }
    
    public function payment($params = array())
{
   // print_r($params);die;
          $this->db->select('p.id,u.name as username,u.mobile as usermobile,u.email as useremail,d.name,d.mobile,d.email,p.amount,p.status,p.created_date');
          $this->db->from('doctor_payment as p');
          $this->db->join(USER.' as u', 'u.id=p.user_id','inner');
          $this->db->join(DOCTOR.' as d', 'd.id=p.doctor_id','inner');
         
          $cond = "p.id>0";
          if(isset($params['search']['keywords'])){
             $keywords = trim($params['search']['keywords']);
            // echo"<pre>";print_r($keywords);die;
          if($keywords)
             	$cond .= " AND (concat(u.name LIKE '%".$keywords."%' OR d.name LIKE '%".$keywords."%' OR u.email LIKE '%".$keywords."%' OR u.mobile LIKE '%".$keywords."%' )) ";

          }
      
        if(array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit'],$params['start']);
        elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit']);
            $this->db->where($cond);
            $this->db->order_by('p.id','DESC');
             $data = $this->db->get();
       
        return ($data->num_rows() >0)?$data->result():NULL;

}

 public function earning($params = array())
{
   // print_r($params);die;
          $this->db->select('p.id,d.name,d.mobile,d.email,SUM(amount) as amt,p.status,p.created_date,p.doctor_id');
          $this->db->from('doctor_payment as p');
          $this->db->join(DOCTOR.' as d', 'd.id=p.doctor_id','inner');
         
          $cond = "p.id>0";
          if(isset($params['search']['keywords'])){
             $keywords = trim($params['search']['keywords']);
            // echo"<pre>";print_r($keywords);die;
          if($keywords)
             	$cond .= " AND (concat(d.name LIKE '%".$keywords."%' OR d.mobile LIKE '%".$keywords."%' OR d.email LIKE '%".$keywords."%' )) ";

          }
      
        if(array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit'],$params['start']);
        elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit']);
            $this->db->where($cond);
            $this->db->order_by('p.id','DESC');
            $this->db->group_by('p.doctor_id');
             $data = $this->db->get();
       
        return ($data->num_rows() >0)?$data->result():NULL;

}
    
    
    
public function specificPromo($params = array())
{
   // print_r($params);die;
          $this->db->select('spe.id,spe.clinic_name,d.name as doctor,sp.name as spe,spe.promocode,spe.status,spe.created_date,spe.validity,spe.location,spe.offer_discount');
          $this->db->from('doctor_specificpromo as spe');
         // $this->db->join(USER.' as u', 'u.id=spe.user_id','inner');
          $this->db->join(DOCTOR.' as d', 'd.id=spe.doctor_id','inner');
           $this->db->join('specility as sp', 'sp.id=spe.specialty_id','inner');
          $cond = " spe.status = 1";
          if(isset($params['search']['keywords'])){
             $keywords = trim($params['search']['keywords']);
            // echo"<pre>";print_r($keywords);die;
          if($keywords)
             	$cond .= " AND (concat(spe.clinic_name LIKE '%".$keywords."%' OR d.name LIKE '%".$keywords."%' OR u.name LIKE '%".$keywords."%' OR spe.promocode LIKE '%".$keywords."%' )) ";

          }
      
        if(array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit'],$params['start']);
        elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit']);
            $this->db->where($cond);
            $this->db->order_by('spe.id','DESC');
             $data = $this->db->get();
       
        return ($data->num_rows() >0)?$data->result():NULL;

}

public function medicine($params = array())
{
   // print_r($params);die;
          $this->db->select('s.id,s.delivery_status,u.name,u.email,u.address,s.del_status,s.delivery_confirm_status,s.image');
          $this->db->from('doctor_session as s');
          $this->db->join(USER.' as u', 'u.id=s.user_id','inner');
         
          $cond = " s.id>0 and del_status=0";
          if(isset($params['search']['keywords'])){
             $keywords = trim($params['search']['keywords']);
            // echo"<pre>";print_r($keywords);die;
          if($keywords)
             	$cond .= " AND (concat(u.name LIKE '%".$keywords."%' OR u.email LIKE '%".$keywords."%' OR u.address LIKE '%".$keywords."%')) ";

          }
      
        if(array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit'],$params['start']);
        elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit']);
            $this->db->where($cond);
            $this->db->order_by('s.id','DESC');
             $data = $this->db->get();
       
        return ($data->num_rows() >0)?$data->result():NULL;

}


    
public function homeBooking($params = array())
{
   // print_r($params);die;
          $this->db->select('b.id as booking_id,b.user_id,u.name as user,u.mobile,u.email,d.name as doctor,b.created_date,b.address,b.address_type,b.promocode,b.booking_status,b.booking_type,b.frees,b.reason_visit,b.member_name');
          $this->db->from(BOOKING.' as b');
          $this->db->join(USER.' as u', 'u.id=b.user_id','inner');
          $this->db->join(DOCTOR.' as d', 'd.id=b.doctor_id','inner');
    
          $cond = "booking_type='home'";
          if(isset($params['search']['keywords'])){
             $keywords = trim($params['search']['keywords']);
            // echo"<pre>";print_r($keywords);die;
          if($keywords)
             	$cond .= " AND (concat(u.name LIKE '%".$keywords."%' OR u.mobile LIKE '%".$keywords."%' OR u.email LIKE '%".$keywords."%' )) ";

          }
      
        if(array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit'],$params['start']);
        elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit']);
            $this->db->where($cond);
            // $this->db->group_by('b.user_id'); 

            $this->db->order_by('b.id','DESC');
             $data = $this->db->get();
       
        return ($data->num_rows() >0)?$data->result():NULL;

}


public function callBooking($params = array())
{
   // print_r($params);die;
          $this->db->select('b.id as booking_id,b.user_id,u.name as user,u.mobile,u.email,d.name as doctor,b.created_date,b.address,b.address_type,b.promocode,b.booking_status,b.booking_type,b.frees,b.reason_visit,b.member_name');
          $this->db->from(BOOKING.' as b');
          $this->db->join(USER.' as u', 'u.id=b.user_id','inner');
          $this->db->join(DOCTOR.' as d', 'd.id=b.doctor_id','inner');
    
          $cond = "booking_type='call'";
          if(isset($params['search']['keywords'])){
             $keywords = trim($params['search']['keywords']);
            // echo"<pre>";print_r($keywords);die;
          if($keywords)
             	$cond .= " AND (concat(u.name LIKE '%".$keywords."%' OR u.mobile LIKE '%".$keywords."%' OR u.email LIKE '%".$keywords."%' )) ";

          }
      
        if(array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit'],$params['start']);
        elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit']);
            $this->db->where($cond);
            // $this->db->group_by('b.user_id'); 

            $this->db->order_by('b.id','DESC');
             $data = $this->db->get();
       
        return ($data->num_rows() >0)?$data->result():NULL;

}

public function bookingDetail($cond)
{
     $this->db->select('b.id as booking_id,d.name as doctor,d.specialty,d.clinic_name,d.image,u.name as user,b.booking_status,b.reason_visit,b.member_name,b.address,b.address_type');
          $this->db->from(BOOKING.' as b');
           $this->db->join(USER.' as u', 'u.id=b.user_id','inner');
          $this->db->join(DOCTOR.' as d', 'd.id=b.doctor_id','inner');
          $this->db->where($cond);
          $this->db->order_by('b.id','DESC');
          $data = $this->db->get();
       
        return ($data->num_rows() >0)?$data->result():NULL;
}

public function rating($params = array())
{
     $this->db->select('r.id,r.rating,d.name,d.clinic_name,r.doctor_id as doctor_id');
          $this->db->from(RATING.' as r');
         //  $this->db->join(USER.' as u', 'u.id=b.user_id','inner');
          $this->db->join(DOCTOR.' as d', 'd.id=r.doctor_id','inner');
          $cond = "r.id>0";
         if(isset($params['search']['keywords'])){
             $keywords = trim($params['search']['keywords']);
            // echo"<pre>";print_r($keywords);die;
          if($keywords)
             	$cond .= " AND (concat(d.name LIKE '%".$keywords."%' OR d.clinic_name LIKE '%".$keywords."%' )) ";

          }
      
        if(array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit'],$params['start']);
        elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit']);
            $this->db->where($cond);
             $this->db->group_by('r.doctor_id'); 

            $this->db->order_by('r.id','DESC');
             $data = $this->db->get();
       
        return ($data->num_rows() >0)?$data->result():NULL;
    
}

public function scheduleBooking($params = array())
{
   // print_r($params);die;
          $this->db->select('b.user_id,u.name as user,u.mobile,u.email,d.name as doctor,b.created_date,b.address,b.address_type,b.promocode,b.booking_status,b.booking_type,b.frees,b.reason_visit,b.member_name');
          $this->db->from(BOOKING.' as b');
          $this->db->join(USER.' as u', 'u.id=b.user_id','inner');
          $this->db->join(DOCTOR.' as d', 'd.id=b.doctor_id','inner');
    
          $cond = " b.status = 1 and booking_type='scheduling'";
          if(isset($params['search']['keywords'])){
             $keywords = trim($params['search']['keywords']);
            // echo"<pre>";print_r($keywords);die;
          if($keywords)
             	$cond .= " AND (concat(u.name LIKE '%".$keywords."%' OR u.mobile LIKE '%".$keywords."%' OR u.email LIKE '%".$keywords."%' )) ";

          }
      
        if(array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit'],$params['start']);
        elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit']);
            $this->db->where($cond);
             $this->db->group_by('b.user_id'); 

            $this->db->order_by('b.id','DESC');
             $data = $this->db->get();
       
        return ($data->num_rows() >0)?$data->result():NULL;

}

public function sceduleDetail($cond)
{
     $this->db->select('b.id as booking_id,d.name as doctor,d.specialty,d.clinic_name,d.image,u.name as user,b.booking_status,b.schedule_date,b.schedule_time');
          $this->db->from(BOOKING.' as b');
           $this->db->join(USER.' as u', 'u.id=b.user_id','inner');
          $this->db->join(DOCTOR.' as d', 'd.id=b.doctor_id','inner');
          $this->db->where($cond);
          $this->db->order_by('b.id','DESC');
          $data = $this->db->get();
       
        return ($data->num_rows() >0)?$data->result():NULL;
}

public function notification($params = array())
{
   // print_r($params);die;
          $this->db->select('n.id,n.message,n.title,u.name as username,u.email as useremail,u.mobile as usermobile,n.created_date');
          $this->db->from('notification as n');
          $this->db->join(USER.' as u', 'u.id=n.user_id','inner');
         // $this->db->join(DOCTOR.' as d', 'd.id=n.doctor_id','inner');
           //$this->db->join('specility as sp', 'sp.id=spe.specialty_id','inner');
          $cond = " n.id>0 and send_to='user'";
          if(isset($params['search']['keywords'])){
             $keywords = trim($params['search']['keywords']);
            // echo"<pre>";print_r($keywords);die;
          if($keywords)
             	$cond .= " AND (concat(u.name LIKE '%".$keywords."%' OR u.email LIKE '%".$keywords."%' OR u.mobile LIKE '%".$keywords."%' )) ";

          }
      
        if(array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit'],$params['start']);
        elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit']);
            $this->db->where($cond);
            $this->db->order_by('n.id','DESC');
             $data = $this->db->get();
       
        return ($data->num_rows() >0)?$data->result():NULL;

}

public function doctor_notification($params = array())
{
   // print_r($params);die;
          $this->db->select('n.id,n.message,n.title,d.name,d.email,d.mobile,n.created_date');
          $this->db->from('notification as n');
         // $this->db->join(USER.' as u', 'u.id=n.user_id','inner');
          $this->db->join(DOCTOR.' as d', 'd.id=n.doctor_id','inner');
           //$this->db->join('specility as sp', 'sp.id=spe.specialty_id','inner');
          $cond = " n.id>0 and send_to='doctor'";
          if(isset($params['search']['keywords'])){
             $keywords = trim($params['search']['keywords']);
            // echo"<pre>";print_r($keywords);die;
          if($keywords)
             	$cond .= " AND (concat(d.name LIKE '%".$keywords."%' OR d.email LIKE '%".$keywords."%' OR d.mobile LIKE '%".$keywords."%' )) ";

          }
      
        if(array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit'],$params['start']);
        elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params))
            $this->db->limit($params['limit']);
            $this->db->where($cond);
            $this->db->order_by('n.id','DESC');
             $data = $this->db->get();
       
        return ($data->num_rows() >0)?$data->result():NULL;

}

//for user chat
public function userChat($cond)
{
     $this->db->select('c.message,c.created_date,c.sender_type,c.user_type,u.name,u.image,u.id as userid');
          $this->db->from('doctor_chat as c');
           $this->db->join(USER.' as u', 'u.id=c.user_id','inner');
         // $this->db->join(DOCTOR.' as d', 'd.id=b.doctor_id','inner');
          $this->db->where($cond);
          $this->db->order_by('c.id','ASC');
          $data = $this->db->get();
       
        return ($data->num_rows() >0)?$data->result():NULL;
}

//for doctor chat
public function doctorChat($cond)
{
     $this->db->select('c.message,c.created_date,c.sender_type,c.user_type,d.name,d.image,d.id as userid');
          $this->db->from('doctor_chat as c');
           $this->db->join(DOCTOR.' as d', 'd.id=c.user_id','inner');
         // $this->db->join(DOCTOR.' as d', 'd.id=b.doctor_id','inner');
          $this->db->where($cond);
          $this->db->order_by('c.id','ASC');
          $data = $this->db->get();
       
        return ($data->num_rows() >0)?$data->result():NULL;
}

function calculateTime($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

	
	
}



?>