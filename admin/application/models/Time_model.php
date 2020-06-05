<?php

class Time_model extends CI_Model{

        function get_time_slot(){

           $q = $this->db->query("Select * from time_slots limit 1");

            return $q->row();

        }

        

        function get_closing_date($date){

          $shop_id    =   "";
          if(isset($_SESSION["shop_id"]))
          {
              $shop_id    =   $_SESSION["shop_id"];
              $condition  =   "and shop_id=".$shop_id;
          }
          else
          {
              $shop_id    =   "";
              $condition  =   "";
          }


           $q = $this->db->query("Select * from closing_hours where date >= '".date("Y-m-d",strtotime($date))."' ".$condition."");

            return $q->result(); 

        }

        function get_closing_hours($date){

           $q = $this->db->query("Select * from closing_hours where date = '".date("Y-m-d",strtotime($date))."'");

            return $q->result(); 

        }

}

?>