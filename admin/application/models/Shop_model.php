<?php
class Shop_model extends CI_Model{
      function get_shop($search="", $page = ""){
            
            $shop_id    =   "";
            if(isset($_SESSION["shop_id"]))
            {
                $shop_id    =   $_SESSION["shop_id"];
                $condition  =   "where shop_id=".$shop_id;
            }
            else
            {
                $shop_id    =   "";
                $condition  =   "where 1";
            }
            
            $filter = "";
            $limit = "";
            $page_limit = 10;
            if($page != ""){
                $limit .= " limit ".(($page - 1) * $page_limit).",".$page_limit." ";
            }
            
             if($search!=""){
                $filter .="and shop_name like '".$search."' ";
            }

            $q = $this->db->query("Select * from shop_master ".$condition." ".$filter." ".$limit);
            $shops =$q->result();
           
            return $shops; 
      }
      
      function get_all_shop(){
        
            $q = $this->db->query("Select * from shop_master ORDER BY shop_id Desc");
            $shops =$q->result();
           
            return $shops; 
      }

      function get_shop_by_id($shop_id)
      {
         $q = $this->db->query("Select * from shop_master where shop_id = '".$shop_id."' limit 1");
            return $q->row();
      }

    }
?> 