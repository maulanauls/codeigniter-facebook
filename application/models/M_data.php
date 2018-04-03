<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_data extends CI_Model {
protected $table = 'tbl_user';
    function get_user_login($val)
     {
        $this->db->from('tbl_user');
        $this->db->where('first_name', $val);
        $query = $this->db->get();
        return $query->row();
     }

    function get_max_user_id()
    {
        $QUERY 	= $this->db->query("SELECT MAX(user_id) AS id_user FROM tbl_user");
        $data = "";
        if($QUERY->num_rows() > 0) {
            foreach($QUERY->result() as $list){
                $data = ((int)$list->id_user)+1;
            }
        } else {
            $data = 1;
        }
        return $data;
    }

    function get_user_id($id)
    {
        $this->db->from('tbl_user');
        $this->db->where('user_id', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function save_register($data)
    {
      $this->db->insert('tbl_user', $data);
      return $this->db->insert_id();
    }
}
