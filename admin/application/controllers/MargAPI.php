<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MargAPI extends MY_Controller {
    public function __construct()
    {
                parent::__construct();
                // Your own constructor coded
                $this->load->database();
                $this->load->helper('login_helper');
                $this->load->helper('sms_helper');  
                $this->load->helper('shop_helper');  
                $this->load->library('session');   
    }
    function checkBrand($brand_name)
    {
          $q = $this->db->query("Select * from brand where name = '".$brand_name."'");
          $brand_details = $q->row();
          if(!empty($brand_details))
          {
              return $brand_details->brand_id;
          }else
          {
              $array['name']=$brand_name;
              $array['status']='Active';
              $this->db->insert("brand",$array);
              $brand_id =  $this->db->insert_id();
              return $brand_id;
              
          }
    }
    
    function checkProduct($rid)
    {
          $q = $this->db->query("Select rid from products where rid = '".$rid."'");
          $product_details = $q->row();
          if(!empty($product_details))
          {
              return true;
          }else{
              
              return false;
          }
    }
    
    function decrypt($key,$encrypted)
	{
		$mcrypt_cipher = @MCRYPT_RIJNDAEL_128;
		$mcrypt_mode = @MCRYPT_MODE_CBC;
		$iv=$key . "\0\0\0\0";
		$key=$key . "\0\0\0\0";
					
		$encrypted = base64_decode($encrypted);		
		$decrypted = rtrim(@mcrypt_decrypt($mcrypt_cipher, $key, $encrypted, $mcrypt_mode, $iv), "\0");
		if($decrypted != '')
		{
			$dec_s2 = strlen($decrypted);
			$padding = ord($decrypted[$dec_s2-1]);
			$decrypted = substr($decrypted, 0, -$padding);
		}
		return $decrypted;
	}
	
	function MargMST2017API()
	{
	    $key = '42HEIAUA8BU5';
        $ch = curl_init( "https://wservices.margcompusoft.com/api/eOnlineData/MargMST2017" );
        $payload = json_encode( array("CompanyCode" => "Ramesh2","MargID" => "152538","Datetime" => "", "index" => "0"));
    
    
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
        
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        
        if ($err) {
          return false;
        }else{
            
            $result = $this->decrypt($key,$response);
            $data =  gzinflate(base64_decode($result));
             if ($data === false) 
             {
                return false;
             }
             else{
                //print_r();
                //print_r(json_decode($data, true));
                return $data;
                
             }
        }
	    
	}
	function insert_salt($Stype)
	{
	    foreach($Stype as $key => $value)
	    {
	        if(!in_array($value->sgcode,array('COMMCD','ZZZZZZ','AREA','CATEGO')))
	        {
	                  $q='';
	                  $q1=trim($value->scode,' ');
	                  $q="Select * from composition where salt ='".$q1."'";
	                  $query = $this->db->query($q);
	                  $q1=$query->row();
	                  if(empty($q1))
	                  {
    	                  $array=array();
    	                  $array['composition_name']=$value->name;
    	                  $array['salt']=$q1;
    	                  $array['status']='Active';    	                  
                          $this->db->insert("composition",$array);
                          $composition_id =  $this->db->insert_id();    
	                  }
	                  
	        }
	    }
	}
	function get_composition_id($catcode)
	{
	              $q = $this->db->query("Select * from composition where salt = '".$catcode."'");
                  $composition = $q->row();
                  
                  if(!empty($composition))
                  {
                      return $composition->composition_id;
                  }
	}
	function get_category_id($Stype,$catcode)
	{
	    foreach($Stype as $key => $value)
	    {
	        if($value->sgcode=='CATEGO' && $value->scode==$catcode)
	        {
	             
	              $q = $this->db->query("Select * from categories where title = '".$value->name."'");
                  $categories = $q->row();
                  if(!empty($categories))
                  {
                      return $categories->id;
                  }else
                  {
                      $array['title']=$value->name;
                      $array['slug']=$value->name;
                      $array['parent']=0;
                      $array['leval']=0;
                      $array['description']=
                      $array['image']='';
                      $array['status']=1;
                      $array['shop_id']=0;
                      $this->db->insert("categories",$array);
                      $categories_id =  $this->db->insert_id();
                      return $categories_id;
                      
                  }
	        }
	    }
	}
	
	function get_HSN($Stype,$catcode)
	{
	    foreach($Stype as $key => $value)
	    {
	        
	        if(strcmp(trim($value->scode,' '),$catcode)==0 && $value->sgcode=='COMMCD')
	        {
	        
	        return trim($value->name,' ');    
	        }
	        
	    }
	    //print_r($Stype);
	}
    public function get_product()
    {
        //unlink(APPPATH."assets/data.txt"); 
       
        $this->load->helper('file');
        $data1=$this->MargMST2017API();
        $this->load->helper("url");
        echo "<pre>";
        $data=json_decode(trim($data1,'﻿'));       
        $Stype=array();
        
        
        if(!empty($data->Details->Stype))
        {
            $Stype=$data->Details->Stype;
            $this->insert_salt($Stype);
        }
        
        $this->load->model("common_model");
        
        if($data)
        {
                $product_details=$data->Details->pro_N;
                
                
                foreach ($product_details as $key => $value) {
                $product=array();
                
                $fetch_id=$this->checkBrand($value->company);
                $product['rid']=$value->rid;
                $product['product_name']=$value->name;
                $product['product_description']=" ";
                $product['product_image']=" ";
                $product['category_id']=71;
                $product['in_stock']=1;
                $product['price']=$value->MRP;
                $product['surfcity_price']=$value->Rate;
                $product['subscription_price']=$value->Rate;
                $product['cashback']=0;
                $product['top_selling']=0;
                $product['offer_product']=0;
                $product['shop_id']=0;
                $product['brand_id']=$fetch_id;
                $product['composition_id']=$this->get_composition_id($value->Salt);
                $category_id=$this->get_category_id($Stype,$value->catcode);
                $product['category_id']=$category_id;
                $product['HSN']=$this->get_HSN($Stype,trim($value->catcode,' '));
                
                
                if(!empty($product['category_id']))
                {
                    
                    $checkproduct=$this->checkProduct($value->rid);
                    if($checkproduct)
                    {
                        
                        $this->common_model->data_update("products",$product,array("rid"=>$value->rid));
                    
                        
                    }else{
                        
                        $this->db->insert("products",$product);
                        $product_id =  $this->db->insert_id();  
                    }    
                }
               }    
        }
        
        redirect("admin/products");
        
    }
    
}        
