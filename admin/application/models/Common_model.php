<?php

class Common_model extends CI_Model{

    function data_insert($table,$insert_array){

        $this->db->insert($table,$insert_array);

        return $this->db->insert_id();

    }

    function data_update($table,$set_array,$condition){

        $this->db->update($table,$set_array,$condition);

        return $this->db->affected_rows();

    }

    function data_remove($table,$condition){

        $this->db->delete($table,$condition);

    }

    function get_shop_list(){
        $q = $this->db->query('select * from shop_master where status="Active"');
        $shop_list =    $q->result(); 
        return $shop_list;
    }



}

?>