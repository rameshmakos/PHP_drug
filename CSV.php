<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CSV extends MY_Controller {
    public function __construct()
    {
                parent::__construct();
                // Your own constructor coded
                $this->load->database();
                $this->load->helper('login_helper');
                $this->load->helper('sms_helper');  
                $this->load->helper('url_helper');
                $this->load->helper('shop_helper');  
                $this->load->library('session');   
                $this->load->model("common_model");
                
    }
    
    public function upload_file1()
	{
        $this->load->view('admin/csv/upload_csv');
	}
    public function upload_file()
	{
	   if(_is_user_login($this)){
	       
            $data["error"] = "";
            if(isset($_REQUEST["addcatg"]))
            {
               
               
                    $file = $_FILES['file']['tmp_name'];
                    $handle = fopen($file, "r");
			        
			        $CSVfp = fopen($file, "r");
                    $i=0;
                    
                    if($CSVfp !== FALSE) {
                    while(! feof($CSVfp)) {
                    	$data = fgetcsv($CSVfp, 1000, ",");
                    
                    	echo "<pre>";
                        if($i!=0)
                        {
                        if(!empty($data[0]) && $data[1] && $data[19])
                        {
                            $product['rid']=$data[0];
                            $product['brand_id']=$this->checkBrand($data[1]);
                            $product['product_name']=$data[3];
                            $product['product_description']=" ";
                            $product['product_image']=" ";
                            $product['HSN']=$data[4];
                            $product['price']=$data[15];
                            $product['surfcity_price']=$data[12];
                            $product['subscription_price']=$data[12];
                            $category_id=$this->get_category_id($data[18]);
                            $product['category_id']=$category_id;
                            if(0<$data[16])
                            {
                                $product['in_stock']=1;    
                            }else{
                                $product['in_stock']=0;
                            }
                            $product['cashback']=0;
                            $product['top_selling']=0;
                            $product['offer_product']=0;
                            $product['shop_id']=0;
                            $product['composition_id']=$this->get_composition_id($data[19]);
                            
                            if(!empty($product['category_id']) && !empty($data[0]) && !empty($data[3]))
                            {
                                
                                $checkproduct=$this->checkProduct($data[0]);
                                if($checkproduct)
                                {
                                    
                                    $this->common_model->data_update("products",$product,array("rid"=>$data[0]));
                                
                                    
                                }else{
                                    
                                    $this->db->insert("products",$product);
                                    $product_id =  $this->db->insert_id();  
                                }    
                            }
                            
                            
                            
                            }
                        }
                        $i++;
                    	
                    }
                    
                    fclose($CSVfp);
                    
               	
            }
            
            
                    
            }
            
	   	        
        }
        echo "Uploaded file successfully".'<a href="'.site_url("admin/products").'>BACK</a>';
        exit();
            
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
    
    
	
	function get_composition_id($catcode)
	{
	              $q = $this->db->query("Select * from composition where composition_name = '".$catcode."'");
                  $composition = $q->row();
                  
                  if(!empty($composition))
                  {
                      return $composition->composition_id;
                  }else{
                          $array=array();
    	                  $array['composition_name']=$catcode;
    	                  $array['salt']=$catcode;
    	                  $array['status']='Active';
                          $this->db->insert("composition",$array);
                          $composition_id =  $this->db->insert_id();    
                  }
	}
	function get_category_id($catcode)
	{
	    $q = $this->db->query("Select * from categories where title = '".$catcode."'");
                  $categories = $q->row();
                  if(!empty($categories))
                  {
                      return $categories->id;
                  }else
                  {
                      $array['title']=$catcode;
                      $array['slug']=$catcode;
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