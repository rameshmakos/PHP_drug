<?php

class Setting_model extends CI_Model{

        function get_settings(){

        $shop_id    =   "";    
	    if(isset($_SESSION["shop_id"]))
	    {
	        $shop_id    =   $_SESSION["shop_id"];
	        $condition  =   "where shop_id=".$shop_id;
	    }
	    else
	    {
            $shop_id    =   "";
            $condition  =   "";
        }

           $q = $this->db->query("Select * from settings ".$condition."");

            return $q->result();

        }

        

        function get_setting_by_id($id){

        $q = $this->db->query("Select * from settings where id = '".$id."'"); 

            return $q->row();

      }

}

?>