<?php
class City_model extends CI_Model{
        /* ========== City========== */
        
         public function sel_city(){
            $q = $this->db->query("select * from city");
            return $q->result();
        } 
        
        public function get_city($id){
            $q = $this->db->query("select * from city WHERE city_id =".$id);
            return $q->row();
        } 
        
        public function get_city_active(){
            $q = $this->db->query("select * from city WHERE status=1");
            return $q->result();
        } 
        
}
?>