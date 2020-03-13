<?php
//////------ COMMON MODEL -------/////
class My_model extends CI_Model
{
	function __construct() 
  {
    /* Call the Model constructor */
    parent::__construct();

  }
  
  /////-----INSERT DATA MODEL-------//////
	public function insert_data($tbl,$data)
	{
		$this->db->insert($tbl,$data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}    //////-----CLOSE INSERT MODEL 
	
	/////----  UPDATE DATA MODEL-----/////
	public function update_data($tbl,$con,$data_array)
	{
	  	return $this->db
				 ->where($con)
				 ->update($tbl,$data_array);
				  return $this->db->last_query();
	} ////----- CLOSE UPDATE MODEL 

	 public function deleteRow($table,$cond)
    {
  		$this->db->where($cond);
  		$this->db->delete($table);
  		$this->db->cache_delete_all();
  		return TRUE;
    }
	
	
	////----- GET SINGLE FIELDS VALUE WITH CONDITION -----/////
	public function getfields($table,$fields,$condition,$conor="")
	{
		$this->db->select($fields);
        $this->db->from($table);
        $this->db->where($condition);
		$fieldname = $this->db->list_fields($table)[0];
		$this->db->order_by($fieldname,"DESC");
		if($conor){ $this->db->or_where($conor); }	
		
		
 //print_r($this->db->list_fields($table)[0]);		
		 ///$this->db->or_where($conor);
        
        $results=$this->db->get(); 
		return $results->result();
	}    //////------- CLOSE SINGLE FIELDS 
	////---- FETCH ALL RECODS WITH CODITION AND SEARCH LIMIT ORDERS WITH PAGINATION ---------//////
	
public function fieldResult($table,$filed)
    {
       $data = $this->db
	                ->select($filed)
					->from($table)
					->get();
	  return ($data->num_rows() > 0)?$data->result():FALSE; 
	}

function db_action_perform($table,$data,$action,$condition_arr='')
	{	
	
	if($action == 'insert')
		{
			$this->db->trans_start();
			$this->db->insert($table,$data);
			$insert_id = $this->db->insert_id();
			//echo $insert_id;
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE)
			{
				log_message('error','profile data not inserted in db_action_perform()');
			}
			//echo $this->db->last_query();exit;
			return $insert_id;
			exit();
		}
		if($action == 'update')
		{
		    $this->db->trans_start();
			$this->db->where($condition_arr);
			$this->db->update($table,$data);
			$this->db->trans_complete();
			if($this->db->trans_status() === FALSE)
			{
				log_message('error','existing user profile data not update in db_action_perform');
				return false;
				exit();
			}
			return true;
		}
	}
	
	public function fetch_all_records($table,$limit="",$con="",$search="",$orderfields="", $ordertype="",$conor="")
    {
		$url =$this->uri->segment_array();
		$offset= end($url);
		$orderfields="id";
		$this->db->select('*');
		$this->db->from($table);
		if($con != ""){ $this->db->where($con); }
		///if($search != ""){ $this->db->or_like($search); }
		if($search != ""){ $this->db->like($search); }
		if($conor != ""){ $this->db->or_where($conor); }


		if($limit != ""){ $this->db->limit($limit,$offset); }
		if($orderfields != "" AND $ordertype != ""){ $this->db->order_by($orderfields,$ordertype); }
		else if($orderfields != "" AND $ordertype == ""){ $this->db->order_by($orderfields,"ASC"); }
		else if($orderfields == "" AND $ordertype != ""){ $this->db->order_by("id",$ordertype); }
		else if($orderfields == "" AND $ordertype == ""){ $this->db->order_by("id","DESC"); }
		$data = $this->db->get();
		   //return  $data->result();
		return ($data->num_rows()>0)?$data->result():FALSE;		

					
    }  ////---- CLOSE FETCH ALL RECORDS WITH CONDTITIONAL 
	
	
	////=====	COUNT ALL RECORDS ROWS FROM USING PAGINATION 
	public function fetch_all_records_count($table,$con="",$conor="",$search="")
    {
		//if(!empty($fields)){ $this->db->select($fields); }
		//else { $this->db->select('id'); }
		$this->db->select('id');
		$this->db->from($table);
		if($con != ""){ $this->db->where($con); }
		//if($search != ""){ $this->db->or_like($search); }
		if($search != ""){ $this->db->like($search); }
		if($conor != ""){ $this->db->or_where($conor); }
		$data = $this->db->get();
		return ($data->num_rows()>0)?$data->num_rows():FALSE;		
					
    }  ////---- CLOSE COUNT ALL RECORDS ROWS FROM USING PAGINATION 
	
	
	
	////--- GET TABLE ROW LAST ID -----//// 
	public function custom($query)
	{
		$result=$this->db->query($query)->result();
		return $result;
	} ////---- CLOSE LAST ID 
	
	////--- GET TABLE ROW LAST ID -----//// 
	public function maxid($table,$field)
	{
		$results=$this->db->query("SELECT MAX(".$field.") as maxid FROM ".$table."");
		return $results->result();
	} ////---- CLOSE LAST ID 
	
	
	public function coutrow($table,$fields,$condition){
		$this->db->select($fields);
        $this->db->from($table);
        $this->db->where($condition);
		//if($conor){ $this->db->or_where($conor); }		
        return $this->db->count_all_results();
        //$results=$this->db->get(); 
		//return $results->result();
	}
	public function coutrow1($table,$fields){
		$this->db->select($fields);
        $this->db->from($table);
         // $this->db->where($condition);
       $this->db->group_by(array('user_id','booking_type')); 
       return $this->db->count_all_results();
        
	}
	
		public function coutrows($table,$fields){
		$this->db->select($fields);
        $this->db->from($table);
//$this->db->where($condition);
		//if($conor){ $this->db->or_where($conor); }		
        return $this->db->count_all_results();
        //$results=$this->db->get(); 
		//return $results->result();
	}
	public function fieldsum($table,$fields,$condition){
		$this->db->select("SUM(".$fields.") AS total");
        $this->db->from($table);
        $this->db->where($condition); 
		$getdata = $this->db->get();
		 if($getdata->num_rows() > 0)
			return $getdata->result_array();
		else
		return null;
	}

	
  
	

	public function fetchValue($table,$field,$con)
    {
       $data = $this->db
	                ->select($field)
					->from($table)
					->where($con)
					->get();
		$result = $data->row();
	   	return ($data->num_rows() >0)?$result->$field:FALSE;
	}

	public function authenticate($tbl,$condition)
    {
		$q = $this->db
			  ->where($condition)
			  ->get($tbl);
			  return $q->row();
	}

	

	public function getfields1($table,$fields,$conor="")
	{
		$this->db->select($fields);
        $this->db->from($table);
        //$this->db->where($condition);
		$fieldname = $this->db->list_fields($table)[0];
		$this->db->order_by($fieldname,"ASC");
		if($conor){ $this->db->or_where($conor); }	
       $results=$this->db->get(); 
		return $results->result();
	} 

	public function getfieldsstaff($table,$fields,$condition,$conor="")
	{
		$this->db->select($fields);
        $this->db->from($table);
        $this->db->where($condition);
		$fieldname = $this->db->list_fields($table)[0];
		$this->db->order_by($fieldname,"ASC");
		if($conor){ $this->db->or_where($conor); }	
       $results=$this->db->get(); 
		return $results->result_array();
	} 

	 public function mysqlNumRows($table,$field,$cond)
    {
        $this->db->select($field);
        $this->db->where($cond);
        $data = $this->db->get($table);
        return ($data->num_rows() >0)?$data->num_rows():0;
    }

     public function deleteRole($id,$data = array())
    {
    	if($id != "" && !empty($data) )
    	{
    		$this->db->where('staff_id',$id);
    		$this->db->where_in('menu_id',$data);
    		$this->db->delete(ROLES);
    		
    	}



}

 public function getRoles($id)
    {
    	if(empty($id))
    	{
    		return FALSE;
    	}else{
    		$this->db->select('menu_id');
    		$this->db->from(ROLES);
    		$this->db->where('staff_id',$id);
    		$query = $this->db->get();
    		//return $this->db->last_query();
    		return ($query->num_rows() > 0)?$query->result_array():FALSE;
    	}
    	
    }

    public function getSum($table,$feilds,$cond)   { 
       $fields = "amount";
       $this->db->select("SUM(".$fields.") AS total");
        $this->db->from(EARNING);
        
        $this->db->where($cond);
         $data =  $this->db->get();
        return ($data->num_rows() > 0)?$data->row():0;
    } 
    
    	public function getfields2($table,$fields,$cond="",$conor="")
	{
		$this->db->select($fields);
        $this->db->from($table);
        if($cond){
        $this->db->where($cond);}
	//	$fieldname = $this->db->list_fields($table)[0];
		$this->db->order_by('name',"ASC");
		if($conor){ $this->db->or_where($conor); }	
       $results=$this->db->get(); 
		return $results->result();
	} 
	
	
}