<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if(! function_exists('_get_all_shops')){

    function _get_all_shops(){
       //get main CodeIgniter object
       $ci =& get_instance();
       
       //load databse library
       $ci->load->database();
       
       //get data from database
       $query = $ci->db->get_where('shop_master',array('status'=>'Active'));
       
       if($query->num_rows() > 0){
           $result = $query->result();
           return $result;
       }else{
           return false;
       }
   }

}

if(! function_exists('_get_name_shops')){

    function _get_name_shops($id){
       //get main CodeIgniter object
       $ci =& get_instance();
       
       //load databse library
       $ci->load->database();
       
       //get data from database
       $query = $ci->db->get_where('shop_master',array('shop_id'=>$id));
       
       if($query->num_rows() > 0){
           $result = $query->row();
           //print_r($result->shop_name);
           return $result->shop_name;
       }else{
           return false;
       }
   }

}

if(! function_exists('_get_name_product_shops')){
    

    function _get_name_product_shops($id){
       //get main CodeIgniter object
       $ci =& get_instance();
       
       //load databse library
       $ci->load->database();
       
       //get data from database
       $query = $ci->db->query("SELECT shop_master.shop_name ,products.shop_id FROM `products` INNER JOIN shop_master ON shop_master.shop_id=products.product_id WHERE product_id=".$id);
       
       if($query->num_rows() > 0){
           $result = $query->row();
           if($result->shop_id==0)
           {
            return "Inventory";    
           }else{
               return $result->shop_name;
           }
           
       }else{
           return false;
       }
   }

}

