<?php
class Subscription_model extends CI_Model{
      function get_all_subscription($search="", $page = ""){

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
                $filter .=" and subscription_name like '".$search."' ";
            }
            $q = $this->db->query("Select * from subscription_plan ".$condition." ".$filter." ".$limit);
            $subscription =$q->result();
          
            return $subscription; 
      }

      function get_subscription_by_id($subscription_id)
      {
         $q = $this->db->query("Select * from subscription_plan where subscription_id = '".$subscription_id."'");
            return $q->row();
      }

}
?>