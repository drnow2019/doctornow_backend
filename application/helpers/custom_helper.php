<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('user_permission'))
{
    function user_permission($cond,$i,$menu_name)
    {

        //return ($cond['menu_id']); 
        $CI =& get_instance();

        $CI->db->where($cond);
        $CI->db->from(ROLES);
        $query = $CI->db->get();

        $chkd = ($query->num_rows() > 0)?"checked":FALSE;
        $result = ($query->num_rows() > 0)?$query->row():FALSE;

        $chkbox='<input type="checkbox" name="menu_'.$i.'" '.$chkd.' value='.$cond[menu_id].' '.set_checkbox("menu_".$i, $cond[menu_id]).'>';

        $data  = '<tr>';
        $data .= '<td>'.$chkbox.'<span style="padding:4px">'.$menu_name.'</span></td>';
        $data .= '<td align="center"><input type="checkbox" name="add_'.$i.'" value="1" '.set_checkbox("add_".$i, "1");
            if($result->add_id ==1)
                $data .= "checked";
        $data .= '></td>';
        $data .= '<td align="center"><input type="checkbox" name="edit_'.$i.'" value="2"'.set_checkbox('edit_'.$i, '2');
            if($result->edit_id == 2)
                $data .= "checked"; 
        $data .= '></td>';
        $data .= '<td align="center"><input type="checkbox" name="delete_'.$i.'" value="3"'.set_checkbox('delete_'.$i, '3');
            if($result->del_id == 3)
                $data .= "checked"; 
        $data .= '></td></tr>';
        return $data;

    }   
}