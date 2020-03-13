<?php

class MY_Form_validation extends CI_Form_validation{

    public function edit_unique($str, $field)
    {
        sscanf($field, '%[^.].%[^.].%[^.].%[^.]', $table, $field, $column, $id);
      // echo $table.' | '.$field.' | '.$column.' | '.$id; die;
        return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str, $column.' !=' => $id))->num_rows() === 0)
            : FALSE;
    }

}