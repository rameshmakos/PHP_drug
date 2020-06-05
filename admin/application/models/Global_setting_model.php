<?php
class Global_setting_model extends CI_Model{
      function get_global_setting_last_id(){
           
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

            $q = $this->db->query("Select * from global_setting ".$condition." order by globe_setting_id DESC limit 1");
            return $q->row();               
        }

        function get_global_setting_all($page = ""){

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
        	
        	$filter = "";
            $limit = "";
            $page_limit = 10;
            if($page != ""){
                $limit .= " limit ".(($page - 1) * $page_limit).",".$page_limit." ";
            }           
            
            $q = $this->db->query("Select * from global_setting ".$condition." order by globe_setting_id DESC ".$limit);
            $all_setting =$q->result();
           
            return $all_setting;
        }
    }
?> 