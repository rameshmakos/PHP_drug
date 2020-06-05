<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 date_default_timezone_set('Asia/Kolkata');
class Api extends CI_Controller {

        public function __construct()
        {
                parent::__construct();
                // Your own constructor code
                header('Content-type: text/json');
                date_default_timezone_set('Asia/Kolkata');
                $this->load->database();
                $this->load->helper('sms_helper');
                 $this->load->helper(array('form', 'url'));
                 $this->db->query("SET time_zone='+05:30'");
        }     
		
        public function testme()
        {
            header('Content-type: text/html');
            date_default_timezone_set('Asia/Kolkata');
            
            $order_id = 3;
            $this->load->model('Product_model');
            $data['order'] = $this->Product_model->get_sale_order_by_id($order_id);
            $data['order_items'] = $this->Product_model->get_sale_order_items($order_id);            
            $header = "From:onlineddapp@gmail.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";
            $subject = "Order placed Successully !";
            $body = $this->load->view('api/order_template', $data, true);
if( mail ('ramesh.makos@gmail.com',$subject,$body,$header) )
            {
                echo 'ok';
            }
            else
            {
                echo "Mail could not be sent...";
            }
//            echo $body;
            
          
        }

public function otp()
{
       $data = array(); 
            $_POST = $_REQUEST;      
                $this->load->library('form_validation');				
                /* add registers table validation */
                $this->form_validation->set_rules('user_mobile', 'Mobile Number', 'trim|required|is_unique[registers.user_phone]');
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}else
                {
                    		$data["responce"] = true; 	
                    		$data["otp"] = 123456; 	
							$data["message"] = "OTP send Sucessfully..";							
					      
				}                    
                     echo json_encode($data);
}
public function get_driver_location()
{
            $data = array(); 
            $_POST = $_REQUEST; 
                $this->load->library('form_validation');
                /* add users table validation */
                $this->form_validation->set_rules('driver_id', 'Driver Id', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                    $this->load->model("common_model");
                    $q = $this->db->query("select * from driver where driver_id = '".$this->input->post("driver_id")."' limit 1");
                    $user = $q->row();
                    
                    $data["responce"] = true; 
                    $data["location"] = $user;
                 
                 }
                 echo json_encode($data);
                 
}
public function signup()
{
       
	   $data = array(); 
            $_POST = $_REQUEST;      
                $this->load->library('form_validation');				
                /* add registers table validation */
                $this->form_validation->set_rules('user_name', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('user_mobile', 'Mobile Number', 'trim|required|is_unique[registers.user_phone]');
                $this->form_validation->set_rules('user_email', 'User Email', 'trim|required|is_unique[registers.user_email]');
                $this->form_validation->set_rules('password', 'Password', 'trim|required');
				 //$this->form_validation->set_rules('imeino','IMEI No','trim|required|is_unique[registers.user_id]');   
				$this->form_validation->set_rules('dob','dob','trim|required');
				$this->form_validation->set_rules('DL_no','DL no','trim|required');
				$this->form_validation->set_rules('DL_date','DL date','trim|required');
				$this->form_validation->set_rules('DL_expire_date','DL expire date','trim|required');
				$this->form_validation->set_rules('register_source','register_source','trim|required');
				
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}else
                {
                    
                        $paths=array();
                        
                        if(isset($_FILES["DL_image"]) && $_FILES["DL_image"]["size"] > 0){
                        $new_name = time().$_FILES["DL_image"]['name'];
                        $config['file_name'] = $new_name;
                        $config['upload_path']          = './uploads/profile/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        $config['encrypt_name'] = TRUE;
                        
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
        
                        if ( ! $this->upload->do_upload('DL_image'))
                        {
                           
                        }
                        else
                        {
                                            
                            $file_data = $this->upload->data();
                            $paths["DL_image"]=$file_data['file_name'];    
                            
                        }
                        
                   		}
                   		
                   		
                   		if(isset($_FILES["TL_Image1"]) && $_FILES["TL_Image1"]["size"] > 0){
                   		$new_name = time().$_FILES["TL_Image1"]['name'];
                        $config['file_name'] = $new_name;
                        $config['upload_path']          = './uploads/profile/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        $config['encrypt_name'] = TRUE;
                        
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ( ! $this->upload->do_upload('TL_Image1'))
                        {
                         
                               
                        }
                        else
                        {
                            
                            //
                            $file_data = $this->upload->data();
                            $paths["TL_Image1"]=$file_data['file_name'];//print_r($file_data);
                            
                        }
                        
                   		}
                   		
                   		if(isset($_FILES["TL_Image"]) && $_FILES["TL_Image"]["size"] > 0)
                   		{
                   		$new_name = time().$_FILES["TL_Image"]['name'];
                        $config['file_name'] = $new_name;
                        $config['upload_path']          = './uploads/profile/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        $config['encrypt_name'] = TRUE;
                        
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ( ! $this->upload->do_upload('TL_Image'))
                        {
                         
                               
                        }
                        else
                        {
                            
                            
                            $file_data = $this->upload->data();
                            $paths["TL_Image"]=$file_data['file_name'];
                        }
                        
                   		}
                   		if(isset($_FILES["GST_image"]) && $_FILES["GST_image"]["size"] > 0){
                   		$new_name = time().$_FILES["GST_image"]['name'];
                        $config['file_name'] = $new_name;
                        $config['upload_path']          = './uploads/profile/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg';
                        $config['encrypt_name'] = TRUE;
                        
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ( ! $this->upload->do_upload('GST_image'))
                        {
                         
                               
                        }
                        else
                        {
                            $file_data = $this->upload->data();
                            $paths["GST_image"]=$file_data['file_name'];
                        }
                        
                   		}
                   		
                        
                        
                    $user_imei=$this->db->query("SELECT * FROM registers where user_phone='".$this->input->post("user_mobile")."' or user_email='".$this->input->post("user_email")."'");
                   
				   if($user_imei->result())
					{
						     $data["responce"] = false; 									
							$data["message"] = "Already registered user";	
					}
					else
					{
				    
				          
                           		/**************************************************************************************************************/
						        //////////////////////////////////////////////////////////////
						
                    $new_referral_code = date("ymdhis");
					$money=$this->db->query("Select * from global_setting order by globe_setting_id DESC limit 1");											
					$ret = $money->row();
					//$newwallet=(int)$ret->new_user_reg_amt;
					$newwallet=0;
					$global_id=$ret->globe_setting_id;
					//echo $global_id;
					//die();
					//echo $this->input->post("user_fcm_code");
					
					if($this->input->post("from_referral_code") !='')
					{
						
						$refrral_code=$this->db->query("SELECT * FROM registers WHERE  referral_code='".$this->input->post("from_referral_code")."'");																		
						if ($refrral_code->num_rows() > 0)
						{  		
						        
								$this->db->insert("registers", array("user_phone"=>$this->input->post("user_mobile"),
                                            "user_fullname"=>$this->input->post("user_name"),
                                             "user_email"=>$this->input->post("user_email"),
											 "from_referral_code"=>$this->input->post("from_referral_code"),
											"referral_code"=>$new_referral_code,
											//"user_id"=>$this->input->post("imeino"),
                                             "user_password"=>md5($this->input->post("password")), 
											"wallet"=>$newwallet,
											"globe_setting_id"=>$global_id,
											"user_fcm_code" => $this->input->post("user_fcm_code"),
                                            "status" => 0,
                                            "user_fcm_code" => $this->input->post("user_fcm_code"),
                                            "dob" => $this->input->post("dob"),
                                            "DL_no" => $this->input->post("DL_no"),
                                            "DL_date" => $this->input->post("DL_date"),
                                            "DL_expire_date" => $this->input->post("DL_expire_date"),
                                            "GST_date" => $this->input->post("GST_date"),
                                            "GST_no" => $this->input->post("GST_no"),
                                            "TL_no" => $this->input->post("TL_no"),
                                            "TL_expire_date" => $this->input->post("TL_expire_date"),
                                            "TL_date" => $this->input->post("TL_date"),
                                            "register_source"=> $this->input->post("register_source"),
//						"DL_no1"=> $this->input->post("DL_no1"),
                                            ));
											
							$user_id =  $this->db->insert_id();  
							
							if($user_id)
							{

                                    $this->load->model("common_model");
                                    $this->common_model->data_update("registers", $paths,array("user_id"=>$user_id));
                                                        
							}
							$data["responce"] = true; 									
							$data["message"] = "User Register Sucessfully..";							
						}
						else
						{
								
							$data["responce"] = false; 
							$data["message"] = "Please enter valid referral code...  ";				
						}																		
					}
					else
					{												
								$this->db->insert("registers", array("user_phone"=>$this->input->post("user_mobile"),
                                            "user_fullname"=>$this->input->post("user_name"),
                                             "user_email"=>$this->input->post("user_email"),											 
											"referral_code"=>$new_referral_code,
                                             "user_password"=>md5($this->input->post("password")), 
											 //"user_id"=>$this->input->post("imeino"),
											"wallet"=>$newwallet,
											"globe_setting_id"=>$global_id,
											"user_fcm_code" => $this->input->post("user_fcm_code"),
                                            "status" => 0,
                                            "dob" => $this->input->post("dob"),
                                            "DL_no" => $this->input->post("DL_no"),
                                            "DL_date" => $this->input->post("DL_date"),
                                            "DL_expire_date" => $this->input->post("DL_expire_date"),
                                            "GST_date" => $this->input->post("GST_date"),
                                            "GST_no" => $this->input->post("GST_no"),
                                            "TL_no" => $this->input->post("TL_no"),
                                            "TL_expire_date" => $this->input->post("TL_expire_date"),
                                            "TL_date" => $this->input->post("TL_date"),
                                            "register_source"=> $this->input->post("register_source"),
						//"DL_no1"=> $this->input->post("DL_no1"),
                                            ));
							$user_id =  $this->db->insert_id();  
							
							if($user_id)
							{
							        $this->load->model("common_model");
                                    $this->common_model->data_update("registers", $paths,array("user_id"=>$user_id));
                                                        
                        
                           		/**************************************************************************************************************/
						        //////////////////////////////////////////////////////////////
							
							}
							
							$data["responce"] = true; 																		
							$data["message"] = "User Register Sucessfully..";								
					}                                        
				}         
				}                    
                     echo json_encode($data);
}
public function composition_search()
{
                $data = array(); 
                $_POST = $_REQUEST;      
                $this->load->library('form_validation');				
				
                /* add registers table validation */
				
                $this->form_validation->set_rules('search', 'search',  'trim|required');
				if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}else
                {
		$q =$this->db->query("SELECT * FROM products LEFT JOIN composition on products.composition_id=composition.composition_id WHERE (composition.composition_name LIKE '%".$this->input->post("search")."%' OR products.product_name LIKE '%".$this->input->post("search")."%')");
//echo $this->db->last_query();
                    $data["responce"]=true;
                    $data["data"]=$q->result();
                    
				}	     
				echo json_encode($data);  					
}




public function brand_search()
{
                $data = array();
                $_POST = $_REQUEST;
                $this->load->library('form_validation');

                /* add registers table validation */

                $this->form_validation->set_rules('search', 'search',  'trim|required');
                                if ($this->form_validation->run() == FALSE)
                        {
                            $data["responce"] = false;
                                $data["error"] = strip_tags($this->form_validation->error_string());                                       
                        }else
                {
                $q =$this->db->query("SELECT * FROM brand where status='Active' AND name LIKE '%".$this->input->post("search")."%'"); 
                    $data["responce"]=true;
                    $data["data"]=$q->result();

                                }
                                echo json_encode($data);
}
function checkNull($value)
{
            if ($value == null) {
                  return '';
            } else {
                  return $value;
            }
    
}

public function generate_sha_key(){
                $data = array(); 
                 $_POST = $_REQUEST;      
                 $this->load->library('form_validation');
                 $this->form_validation->set_rules('key', 'key',  'trim|required');
                 $this->form_validation->set_rules('txnid', 'txnid', 'trim|required');
				 $this->form_validation->set_rules('amount','amount','trim|required');
				 $this->form_validation->set_rules('productinfo','productinfo','trim|required');
				 $this->form_validation->set_rules('firstname','firstname','trim|required');
				 $this->form_validation->set_rules('email','email','trim|required');
				 $this->form_validation->set_rules('status','status','trim|required');
               
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  $data["error"] =  strip_tags($this->form_validation->error_string());
                }else{
                    
                        $key=$_POST["key"];
                        $txnId=$_POST["txnid"];
                        $amount=$_POST["amount"]; //Please use the amount value from database
                        $productName=$_POST["productinfo"];
                        $firstName=$_POST["firstname"];
                        $udf5=$_POST["udf5"];
                        $email=$_POST["email"];
                        $status = $_POST["status"];
                        $salt="ces3DddfT1";
                        
                        /***************** USER DEFINED VARIABLES GOES HERE ***********************/
                        //all varibles posted from client
                        $udf1=$_POST["udf1"];
                        $udf2=$_POST["udf2"];
                        $udf3=$_POST["udf3"];
                        $udf4=$_POST["udf4"];
                        $udf5=$_POST["udf5"];
                        
                        /***************** DO NOT EDIT ***********************/
                        $payhash_str = $key . '|' . $this->checkNull($txnId) . '|' .$this->checkNull($amount)  . '|' .$this->checkNull($productName)  . '|' . $this->checkNull($firstName) . '|' . $this->checkNull($email) . '|' . $this->checkNull($udf1) . '|' . $this->checkNull($udf2) . '|' . $this->checkNull($udf3) . '|' . $this->checkNull($udf4) . '|' . $this->checkNull($udf5) . '||||||'. $salt;
                        
                        
                        $hash = strtolower(hash('sha512', $payhash_str));
                        /***************** DO NOT EDIT ***********************/

                   
                        $data["responce"] = true;  
        			    $data["data"]["SHA"] =  $hash;
                    
                    
                }
           echo json_encode($data);
            
        }
        

public function generate_sha_key_old1(){
            $data = array(); 
            $_POST = $_REQUEST;      
                $this->load->library('form_validation');
                 $this->form_validation->set_rules('key', 'key',  'trim|required');
                 $this->form_validation->set_rules('txnid', 'txnid', 'trim|required');
				 $this->form_validation->set_rules('amount','amount','trim|required');
				 $this->form_validation->set_rules('productinfo','productinfo','trim|required');
				 $this->form_validation->set_rules('firstname','firstname','trim|required');
				 
				 $this->form_validation->set_rules('email','email','trim|required');
				 $this->form_validation->set_rules('status','status','trim|required');
               
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] =  strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                    $key=$_POST["key"];
                    $txnid=$_POST["txnid"];
                    $amount=$_POST["amount"]; 
                    $productinfo=$_POST["productinfo"];
                    $firstname=$_POST["firstname"];
                    $udf1=$_POST["udf1"];
                    $udf2=$_POST["udf2"];
                    $udf3=$_POST["udf3"];
                    $udf4=$_POST["udf4"];
                    $udf5=$_POST["udf5"];
                    $email=$_POST["email"];
                    $status = $_POST["status"];
                    $salt="ces3DddfT1";
                    
                   $keyString  = $key.'|'.$txnid.'|'.$amount.'|'.$productinfo.'|'.$firstname.'|'.$email.'|'.$udf1.'|'.$udf2.'|'.$udf3.'|'.$udf4.'|'.$udf5.'|||||'.$salt;
//$keyString = $key . '|' . checkNull($txnId) . '|' .checkNull($amount)  . '|' .checkNull($productName)  . '|' . checkNull($firstName) . '|' . checkNull($email) . '|' . checkNull($udf1) . '|' . checkNull($udf2) . '|' . checkNull($udf3) . '|' . checkNull($udf4) . '|' . checkNull($udf5) . '||||||'. $salt;
/*
function checkNull($value) {
            if ($value == null) {
                  return '';
            } else {
                  return $value;
            }
      }                
*/

	$calculated_hash 	= 	hash('sha512', $keyString);
                   
                    $data["responce"] = true;  
        			$data["data"]["SHA"] =  $calculated_hash;
                    
                    
                }
           echo json_encode($data);
            
        }
        

	public function generate_sha_key_old(){
            $data = array(); 
            $_POST = $_REQUEST;      
                $this->load->library('form_validation');
                 $this->form_validation->set_rules('key', 'key',  'trim|required');
                 $this->form_validation->set_rules('txnid', 'txnid', 'trim|required');
				 $this->form_validation->set_rules('amount','amount','trim|required');
				 $this->form_validation->set_rules('productinfo','productinfo','trim|required');
				 $this->form_validation->set_rules('firstname','firstname','trim|required');
				 $this->form_validation->set_rules('email','email','trim|required');
				 $this->form_validation->set_rules('status','status','trim|required');
               
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] =  strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                    $key=$_POST["key"];
                    $txnid=$_POST["txnid"];
                    $amount=$_POST["amount"]; //Please use the amount value from database
                    $productinfo=$_POST["productinfo"];
                    $firstname=$_POST["firstname"];
			$udf5='';
                    $email=$_POST["email"];
                    $status = $_POST["status"];
                    $salt="ces3DddfT1";
  /*                  
                    $responseHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
                    $calculated_hash = hash("sha512", $responseHashSeq);
*/
$keyString 	  		=  	$key.'|'.$txnid.'|'.$amount.'|'.$productinfo.'|'.$firstname.'|'.$email.'|||||'.$udf5.'|||||';
                    $keyArray 	  		= 	explode("|",$keyString);
                	$reverseKeyArray 	= 	array_reverse($keyArray);
                	$reverseKeyString	=	implode("|",$reverseKeyArray);
                	$calculated_hash 	= 	strtolower(hash('sha512', $salt.'|'.$status.'|'.$reverseKeyString));                   
                    $data["responce"] = true;  
        			$data["data"]["SHA"] =  $calculated_hash;
                    
                    
                }
           echo json_encode($data);
            
        }
	public function signup4()
{
       
	   $data = array(); 
            $_POST = $_REQUEST;      
                $this->load->library('form_validation');				
                /* add registers table validation */
                $this->form_validation->set_rules('user_name', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('user_mobile', 'Mobile Number', 'trim|required|is_unique[registers.user_phone]');
                $this->form_validation->set_rules('user_email', 'User Email', 'trim|required|is_unique[registers.user_email]');
                $this->form_validation->set_rules('password', 'Password', 'trim|required');
				 //$this->form_validation->set_rules('imeino','IMEI No','trim|required|is_unique[registers.user_id]');   
				$this->form_validation->set_rules('dob','dob','trim|required');
				$this->form_validation->set_rules('DL_no','DL no','trim|required');
				$this->form_validation->set_rules('DL_date','DL date','trim|required');
				$this->form_validation->set_rules('DL_expire_date','DL expire date','trim|required');
				$this->form_validation->set_rules('register_source','register_source','trim|required');
				
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}else
                {
                    $user_imei=$this->db->query("SELECT * FROM registers where user_phone='".$this->input->post("user_mobile")."' or user_email='".$this->input->post("user_email")."'");
                   
				   if($user_imei->result())
					{
						     $data["responce"] = false; 									
							$data["message"] = "Already registered user";	
					}
					else
					{
						
                    $new_referral_code = date("ymdhis");
					$money=$this->db->query("Select * from global_setting order by globe_setting_id DESC limit 1");											
					$ret = $money->row();
					//$newwallet=(int)$ret->new_user_reg_amt;
					$newwallet=0;
					$global_id=$ret->globe_setting_id;
					//echo $global_id;
					//die();
					//echo $this->input->post("user_fcm_code");
					
					if($this->input->post("from_referral_code") !='')
					{
						
						$refrral_code=$this->db->query("SELECT * FROM registers WHERE  referral_code='".$this->input->post("from_referral_code")."'");																		
						if ($refrral_code->num_rows() > 0)
						{  		
						        
								$this->db->insert("registers", array("user_phone"=>$this->input->post("user_mobile"),
                                            "user_fullname"=>$this->input->post("user_name"),
                                             "user_email"=>$this->input->post("user_email"),
											 "from_referral_code"=>$this->input->post("from_referral_code"),
											"referral_code"=>$new_referral_code,
											//"user_id"=>$this->input->post("imeino"),
                                             "user_password"=>md5($this->input->post("password")), 
											"wallet"=>$newwallet,
											"globe_setting_id"=>$global_id,
											"user_fcm_code" => $this->input->post("user_fcm_code"),
                                            "status" => 0,
                                            "user_fcm_code" => $this->input->post("user_fcm_code"),
                                            "dob" => $this->input->post("dob"),
                                            "DL_no" => $this->input->post("DL_no"),
                                            "DL_date" => $this->input->post("DL_date"),
                                            "DL_expire_date" => $this->input->post("DL_expire_date"),
                                            "GST_date" => $this->input->post("GST_date"),
                                            "GST_no" => $this->input->post("GST_no"),
                                            "TL_no" => $this->input->post("TL_no"),
                                            "TL_expire_date" => $this->input->post("TL_expire_date"),
                                            "TL_date" => $this->input->post("TL_date"),
                                            "register_source"=> $this->input->post("register_source"),
                                            ));
											
							$user_id =  $this->db->insert_id();  
							
							if($user_id)
							{
							    /////////////////////////1
						        if(isset($_FILES["DL_image"]) && $_FILES["DL_image"]["size"] > 0){
                                $config['upload_path']          = './uploads/profile/';
                                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                                $config['encrypt_name'] = TRUE;
                                $this->load->library('upload', $config);
                
                                if ( ! $this->upload->do_upload('DL_image'))
                                {
                                    
                                }
                                else
                                {
                                    $img_data = $this->upload->data();
                                    $this->load->model("common_model");
                                    $this->common_model->data_update("registers", array(
                                                        "DL_image"=>$img_data['file_name']
                                                        ),array("user_id"=>$user_id));
                                                        
                                }
                                
                           		}
                           		////////////////////////////////2
                           		if(isset($_FILES["GST_image"]) && $_FILES["GST_image"]["size"] > 0){
                                $config['upload_path']          = './uploads/profile/';
                                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                                $config['encrypt_name'] = TRUE;
                                $this->load->library('upload', $config);
                
                                if ( ! $this->upload->do_upload('GST_image'))
                                {
                                    
                                }
                                else
                                {
                                    $img_data = $this->upload->data();
                                    $this->load->model("common_model");
                                    $this->common_model->data_update("registers", array(
                                                        "GST_image"=>$img_data['file_name']
                                                        ),array("user_id"=>$user_id));
                                                        
                                }
                                
                           		}
                           		////////////////////////////////////3
                           		if(isset($_FILES["TL_image"]) && $_FILES["TL_image"]["size"] > 0){
                                $config['upload_path']          = './uploads/profile/';
                                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                                $config['encrypt_name'] = TRUE;
                                $this->load->library('upload', $config);
                
                                if ( ! $this->upload->do_upload('TL_image'))
                                {
                                       
                                }
                                else
                                {
                                    $img_data = $this->upload->data();
                                    $this->load->model("common_model");
                                    $this->common_model->data_update("registers", array(
                                                        "TL_image"=>$img_data['file_name']
                                                        ),array("user_id"=>$user_id));
                                                        
                                    $data["responce"] = true;
                                    $data["data"] = $img_data['file_name'];
                                }
                                
                           		}
                           		////////////////////////////////////////////////////4
                           		if(isset($_FILES["TL_image1"]) && $_FILES["TL_image1"]["size"] > 0){
                                $config['upload_path']          = './uploads/profile/';
                                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                                $config['encrypt_name'] = TRUE;
                                $this->load->library('upload', $config);
                
                                if ( ! $this->upload->do_upload('TL_image1'))
                                {
                                       
                                }
                                else
                                {
                                    $img_data = $this->upload->data();
                                    $this->load->model("common_model");
                                    $this->common_model->data_update("registers", array(
                                                        "TL_image"=>$img_data['file_name']
                                                        ),array("user_id"=>$user_id));
                                                        
                                    $data["responce"] = true;
                                    $data["data"] = $img_data['file_name'];
                                }
                                
                           		}
						        //////////////////////////////////////////////////////////////
							}
							$data["responce"] = true; 									
							$data["message"] = "User Register Sucessfully..";							
						}
						else
						{
								
							$data["responce"] = false; 
							$data["message"] = "Please enter valid referral code...  ";				
						}																		
					}
					else
					{												
								$this->db->insert("registers", array("user_phone"=>$this->input->post("user_mobile"),
                                            "user_fullname"=>$this->input->post("user_name"),
                                             "user_email"=>$this->input->post("user_email"),											 
											"referral_code"=>$new_referral_code,
                                             "user_password"=>md5($this->input->post("password")), 
											 //"user_id"=>$this->input->post("imeino"),
											"wallet"=>$newwallet,
											"globe_setting_id"=>$global_id,
											"user_fcm_code" => $this->input->post("user_fcm_code"),
                                            "status" => 0,
                                            "dob" => $this->input->post("dob"),
                                            "DL_no" => $this->input->post("DL_no"),
                                            "DL_date" => $this->input->post("DL_date"),
                                            "DL_expire_date" => $this->input->post("DL_expire_date"),
                                            "GST_date" => $this->input->post("GST_date"),
                                            "GST_no" => $this->input->post("GST_no"),
                                            "TL_no" => $this->input->post("TL_no"),
                                            "TL_expire_date" => $this->input->post("TL_expire_date"),
                                            "TL_date" => $this->input->post("TL_date"),
                                            "register_source"=> $this->input->post("register_source"),
                                            ));
							$user_id =  $this->db->insert_id();  
							
							if($user_id)
							{
							    /////////////////////////1
						        if(isset($_FILES["DL_image"]) && $_FILES["DL_image"]["size"] > 0){
                                $config['upload_path']          = './uploads/profile/';
                                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                                $config['encrypt_name'] = TRUE;
                                $this->load->library('upload', $config);
                
                                if ( ! $this->upload->do_upload('DL_image'))
                                {
                                    
                                }
                                else
                                {
                                    $img_data = $this->upload->data();
                                    $this->load->model("common_model");
                                    $this->common_model->data_update("registers", array(
                                                        "DL_image"=>$img_data['file_name']
                                                        ),array("user_id"=>$user_id));
                                                        
                                }
                                
                           		}
                           		////////////////////////////////2
                           		if(isset($_FILES["GST_image"]) && $_FILES["GST_image"]["size"] > 0){
                                $config['upload_path']          = './uploads/profile/';
                                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                                $config['encrypt_name'] = TRUE;
                                $this->load->library('upload', $config);
                
                                if ( ! $this->upload->do_upload('GST_image'))
                                {
                                    
                                }
                                else
                                {
                                    $img_data = $this->upload->data();
                                    $this->load->model("common_model");
                                    $this->common_model->data_update("registers", array(
                                                        "GST_image"=>$img_data['file_name']
                                                        ),array("user_id"=>$user_id));
                                                        
                                }
                                
                           		}
                           		////////////////////////////////////3
                           		if(isset($_FILES["TL_image"]) && $_FILES["TL_image"]["size"] > 0){
                                $config['upload_path']          = './uploads/profile/';
                                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                                $config['encrypt_name'] = TRUE;
                                $this->load->library('upload', $config);
                
                                if ( ! $this->upload->do_upload('TL_image'))
                                {
                                       
                                }
                                else
                                {
                                    $img_data = $this->upload->data();
                                    $this->load->model("common_model");
                                    $this->common_model->data_update("registers", array(
                                                        "TL_image"=>$img_data['file_name']
                                                        ),array("user_id"=>$user_id));
                                                        
                                    $data["responce"] = true;
                                    $data["data"] = $img_data['file_name'];
                                }
                                
                           		}
                           		////////////////////////////////////////////////////4
                           		if(isset($_FILES["TL_image1"]) && $_FILES["TL_image1"]["size"] > 0){
                                $config['upload_path']          = './uploads/profile/';
                                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                                $config['encrypt_name'] = TRUE;
                                $this->load->library('upload', $config);
                
                                if ( ! $this->upload->do_upload('TL_image1'))
                                {
                                       
                                }
                                else
                                {
                                    $img_data = $this->upload->data();
                                    $this->load->model("common_model");
                                    $this->common_model->data_update("registers", array(
                                                        "TL_image"=>$img_data['file_name']
                                                        ),array("user_id"=>$user_id));
                                                        
                                    $data["responce"] = true;
                                    $data["data"] = $img_data['file_name'];
                                }
                                
                           		}
						        //////////////////////////////////////////////////////////////
							}
							
							$data["responce"] = true; 																		
							$data["message"] = "User Register Sucessfully..";								
					}                                        
				}         
				}                    
                     echo json_encode($data);
}
        
        public function index(){
            echo json_encode(array("api"=>"welcome"));
        }
        public function get_categories(){
            $parent = 0 ;
            if($this->input->post("parent")){
                $parent    = $this->input->post("parent");
            }
        $categories = $this->get_categories_short($parent,0,$this) ;
        $data["responce"] = true;
        $data["data"] = $categories;
        echo json_encode($data);
        
    }
     public function get_categories_short($parent,$level,$th){
            $q = $th->db->query("Select a.*, ifnull(Deriv1.Count , 0) as Count, ifnull(Total1.PCount, 0) as PCount FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` 
                         LEFT OUTER JOIN (SELECT `category_id`,COUNT(*) AS PCount FROM `products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id` 
                         WHERE a.`parent`=" . $parent);
                        
                        $return_array = array();
                        
                        foreach($q->result() as $row){
                                    if ($row->Count > 0) {
                                        $sub_cat = 	$this->get_categories_short($row->id, $level + 1,$th);
                    				    $row->sub_cat = $sub_cat;   	
                                    } elseif ($row->Count==0) {
                    				
                                    }
                            $return_array[] = $row;
                        }
        return $return_array;
    }
        public function pincode(){
        	$q =$this->db->query("Select * from pincode");
        	 echo json_encode($q->result());
        }
/* user registration */               
public function signup1()
{
       
	   $data = array(); 
            $_POST = $_REQUEST;      
                $this->load->library('form_validation');				
                /* add registers table validation */
                $this->form_validation->set_rules('user_name', 'Full Name', 'trim|required');
                $this->form_validation->set_rules('user_mobile', 'Mobile Number', 'trim|required|is_unique[registers.user_phone]');
                $this->form_validation->set_rules('user_email', 'User Email', 'trim|required|is_unique[registers.user_email]');
                 $this->form_validation->set_rules('password', 'Password', 'trim|required');
				 //$this->form_validation->set_rules('imeino','IMEI No','trim|required|is_unique[registers.user_id]');   
				 $this->form_validation->set_rules('from_referral_code','Referral','trim');
				 
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}else
                {
                    $user_imei=$this->db->query("SELECT * FROM registers where user_phone='".$this->input->post("user_mobile")."' or user_email='".$this->input->post("user_email")."'");
                   
				   if($user_imei->result())
					{
						     $data["responce"] = false; 									
							$data["message"] = "Already registered user";	
					}
					else
					{
						
                    $new_referral_code = date("ymdhis");
					$money=$this->db->query("Select * from global_setting order by globe_setting_id DESC limit 1");											
					$ret = $money->row();
					//$newwallet=(int)$ret->new_user_reg_amt;
					$newwallet=0;
					$global_id=$ret->globe_setting_id;
					//echo $global_id;
					//die();
					//echo $this->input->post("user_fcm_code");
					
					if($this->input->post("from_referral_code") !='')
					{
						
						$refrral_code=$this->db->query("SELECT * FROM registers WHERE  referral_code='".$this->input->post("from_referral_code")."'");																		
						if ($refrral_code->num_rows() > 0)
						{  		
						        
								$this->db->insert("registers", array("user_phone"=>$this->input->post("user_mobile"),
                                            "user_fullname"=>$this->input->post("user_name"),
                                             "user_email"=>$this->input->post("user_email"),
											 "from_referral_code"=>$this->input->post("from_referral_code"),
											"referral_code"=>$new_referral_code,
											//"user_id"=>$this->input->post("imeino"),
                                             "user_password"=>md5($this->input->post("password")), 
											"wallet"=>$newwallet,
											"globe_setting_id"=>$global_id,
											"user_fcm_code" => $this->input->post("user_fcm_code"),
                                            "status" => 1
                                            ));
											
							$user_id =  $this->db->insert_id();  
							
							/*$this->db->insert("wallet_history", array("user_id"=>$user_id,
                                            "amount"=>$newwallet,
                                             "Status"=>1,                                          
                                            ));
							*/
							$data["responce"] = true; 									
							$data["message"] = "User Register Sucessfully..";							
						}
						else
						{
								
							$data["responce"] = false; 
							$data["message"] = "Please enter valid referral code...  ";				
						}																		
					}
					else
					{												
								$this->db->insert("registers", array("user_phone"=>$this->input->post("user_mobile"),
                                            "user_fullname"=>$this->input->post("user_name"),
                                             "user_email"=>$this->input->post("user_email"),											 
											"referral_code"=>$new_referral_code,
                                             "user_password"=>md5($this->input->post("password")), 
											 //"user_id"=>$this->input->post("imeino"),
											"wallet"=>$newwallet,
											"globe_setting_id"=>$global_id,
											"user_fcm_code" => $this->input->post("user_fcm_code"),
                                            "status" => 1
                                            ));
							$user_id =  $this->db->insert_id();  
							$data["responce"] = true; 																		
							$data["message"] = "User Register Sucessfully..";								
					}                                        
				}         
				}                    
                     echo json_encode($data);
}     
/* subcriptionList */
public function subscriptionList()
{	    
		 $q = $this->db->query("select * from subscription_plan where  	is_active=1 "); 
		 if ($q->num_rows() > 0)
		 {
			$data["responce"] = true;     
            $data['data'] = $q->result();
            echo json_encode($data);  					 
		 }
		 else{
			 $data["responce"] = false;     
            $data['message'] = "list subscription empty";
            echo json_encode($data);  					
		 }	            
}

    
public function purchase_subscribe()
{
    $data = array(); 
            $_POST = $_REQUEST;      
                $this->load->library('form_validation');				               
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
                $this->form_validation->set_rules('subscription_id', 'subscription', 'trim|required');
                $this->form_validation->set_rules('order_id', 'order id', 'trim|required');
                $this->form_validation->set_rules('txt_id', 'order id', 'trim|required');
                
				if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}else
                {
						$this->db->query("UPDATE subscribe_plan  SET purchase=0 WHERE  user_id= '".$this->input->post("user_id")."' ");
						
						$get_sub_details = $this->db->query("Select * from subscription_plan where subscription_id='".$this->input->post('subscription_id')."'  Limit 1");
                    
                    
                    if ($get_sub_details->num_rows() > 0)
                    {
                        $row = $get_sub_details->row(); 
                        $result=json_encode($row);
                        
                        
                        
                        $q =$this->db->query("INSERT INTO subscribe_plan (subscription_id, user_id,subscription_end_date, purchase, subscription_details, txt_id, order_id, amount,subscription_name) 
                        VALUES ('".$this->input->post("subscription_id")."','".$this->input->post("user_id")."',DATE_ADD(CURRENT_TIMESTAMP, INTERVAL '$row->subscription_days' DAY),1,'$result','".$this->input->post("txt_id")."','".$this->input->post("order_id")."','".$this->input->post("amount")."','$row->subscription_name')");
                        if($q){
                            
                            $data["responce"] = true; 									
							$data["message"] = "Subsciption plan purchased sucessfully..";	
                        }else{
                            $data["responce"] = false; 									
							$data["message"] = "subscription plan purchase not Sucessfully..";	
                            
                        }
                        
                        
                    }else{
                             $data["responce"] = false; 									
							$data["message"] = "something went to wrong";	
                    }
						
						
				}				
				echo json_encode($data);  	
				
			
}
public function get_purchase_subscribe_details()
{
            $data = array(); 
            $_POST = $_REQUEST;      
            $this->load->library('form_validation');				               
            $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
				if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}else
                {
						
					
					/*CURRENT_TIMESTAMP < subscription_end_date AND*/
					$get_sub_details = $this->db->query("Select * from subscribe_plan where  purchase=1 AND user_id='".$this->input->post('user_id')."'  Limit 1");
						
                    
                    if ($get_sub_details->num_rows() > 0)
                    {
                            $array=$get_sub_details->row();
    						$array1['subscribe_id']=$array->subscribe_id;
    						$array1['subscription_id']=$array->subscription_id;
    						$array1['user_id']=$array->user_id;
    						$array1['subscription_start_date']=date("d-m-Y H:i A",strtotime($array->subscription_start_date));
    						$array1['subscription_end_date']=date("d-m-Y H:i A",strtotime($array->subscription_end_date));
    						$array1['purchase']=$array->purchase;
    						$array1['subscription_name']=$array->subscription_name;
    						
    						$array2=json_decode($array->subscription_details);
    						$array1['unlock_member_price']=$array2->subscription_details1;
    						$array1['free_delivery']=$array2->subscription_details2;
    						$array1['cashback']=$array2->subscription_details3;
    						$array1['cashback_amt']=$array2->cashback_amt;
    						$array1['min_limit_apply']=$array2->min_limit_apply;
    						$array1['max_limit_apply']=$array2->max_limit_apply;
                        
                            if(date('Y-m-d H:i:s')<date('Y-m-d H:i:s', strtotime($array->subscription_end_date)))
                            {
                                $data["responce"] = true; 									
                                $data['subscription_plan']=$array1;
							    $data["message"] = "subscription plan purchase Sucessfully..";	    
                            }else{
                                $data["responce"] = false; 									
							    $data["message"] = "subscription plan expired";	
                            }
                        
                    }else{
                             $data["responce"] = false; 									
							$data["message"] = "Subscription plan not purchased yet";	
                    }
						
						
				}				
				echo json_encode($data);  	
				
			
}

/* wallet history*/
public function wallet_history()
{	
	 $data = array(); 
            $_POST = $_REQUEST;      
                $this->load->library('form_validation');				               
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
                $this->form_validation->set_rules('amt', 'Amount', 'trim|required');
                $this->form_validation->set_rules('flag', 'Flag', 'trim|required');                                 
				if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}else
                {
						if($this->input->post("flag")==0)
						{							
							$this->db->insert("wallet_history", array("user_id"=>$this->input->post("user_id"),
                                            "amount"=>$this->input->post("amt"),
                                             "Status"=>$this->input->post("flag"),											
                                            ));
							$this->db->query("UPDATE registers  SET wallet=wallet-'".$this->input->post("amt")."' WHERE  user_id= '".$this->input->post("user_id")."' ");
							$data["responce"] = true; 									
							$data["message"] = "wallet Credit Sucessfully..";																					
						}
						elseif($this->input->post("flag")==1)
						{							
							$check=$this->db->insert("wallet_history", array("user_id"=>$this->input->post("user_id"),
                                            "amount"=>$this->input->post("amt"),
                                             "Status"=>$this->input->post("flag"),											
                                            ));
								$this->db->query("UPDATE registers  SET wallet=wallet+'".$this->input->post("amt")."' WHERE  user_id= '".$this->input->post("user_id")."' ");
							$data["responce"] = true; 									
							$data["message"] = "wallet debited Sucessfully..";									
						}
				}				
				echo json_encode($data);  	
				
}
/* subscribe details*/
public function subscribeDetails()
{
	
	$data = array(); 
    $_POST = $_REQUEST;      
    $this->load->library('form_validation');
                /* add registers table validation */
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');                
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}else
                {                    
					
					 //$q = $this->db->query("SELECT subscribe_plan.* ,DATE_ADD(subscription_start_date, INTERVAL  subscription_days DAY) as end_date FROM subscribe_plan where  user_id=".$this->input->post("user_id")); 
					 $q = $this->db->query("SELECT subscribe_plan.* ,subscription_details1,subscription_details2 ,subscription_details3,DATE_ADD(subscription_start_date, INTERVAL  subscribe_plan.subscription_days DAY) as end_date FROM subscribe_plan,subscription_plan where  subscribe_plan.subscription_id=subscription_plan.subscription_id AND user_id=".$this->input->post("user_id")); 

					 $row=$q->row();

					if($row->end_date>date("Y-m-d"))
					{
							$data["responce"] = true;     
							$data['data'] = $q->result();							
					}
					else
					{
						 $data["responce"] = false;     
					   	 $data['message'] = "subscription plan is expired....";
				
					}						
                 } 					 
				 echo json_encode($data);  					
}

/* Deliver timing */
public function deliver_timing1()
{
     $data = array(); 
     $_POST = $_REQUEST;
     $date=$this->input->post("date");
     //echo $date;exit();
     $q = $this->db->query("SELECT time_id,DATE_FORMAT(opening_time,'%H:%i') as opening_time,DATE_FORMAT(closing_time,'%H:%i') as closing_time FROM time_slots order by time_id ASC limit 2"); 
	 $q2 = $this->db->query("SELECT time_id,DATE_FORMAT(opening_time,'%H:%i') as opening_time,DATE_FORMAT(closing_time,'%H:%i') as closing_time FROM time_slots where DATE_FORMAT('$date','%H:%i')>DATE_FORMAT(CURRENT_TIMESTAMP,'%H:%i') order by time_id ASC limit 1"); 
	 echo $this->db->last_query();exit();
	 $q1 = $this->db->query("SELECT time_id,DATE_FORMAT(second_slot_opening_time,'%H:%i') as opening_time,DATE_FORMAT(second_slot_closing_time,'%H:%i') as closing_time FROM time_slots order by time_id ASC limit 1"); 
     $time=$q->result();
     $time1=$q1->row();
     $time[1]->opening_time=$time1->opening_time;
     $time[1]->closing_time=$time1->closing_time;
		 if (count($time) > 0)
		 {
			$data["responce"] = true;     
            $data['data'] = $time;
			//$data['server_time']=date('h:i A', strtotime(date('h:i A')));
            echo json_encode($data);  					 
		 }
		 else{
			 $data["responce"] = false;     
            $data['message'] = "list time slot empty";
            echo json_encode($data);  					
		 }	         
}

public function deliver_timing()
{
         $q = $this->db->query("SELECT time_id,DATE_FORMAT(opening_time,'%H:%i') as opening_time,DATE_FORMAT(closing_time,'%H:%i') as closing_time FROM time_slots order by time_id ASC limit 2");
         $q1 = $this->db->query("SELECT time_id,DATE_FORMAT(second_slot_opening_time,'%H:%i') as opening_time,DATE_FORMAT(second_slot_closing_time,'%H:%i') as closing_time FROM time_slots order by time_id ASC limit 1");
     $time=$q->result();
     $time1=$q1->row();
     $time[1]->opening_time=$time1->opening_time;
     $time[1]->closing_time=$time1->closing_time;
                 if ($q->num_rows() > 0)
                 {
                        $data["responce"] = true;
            $data['data'] = $time;
                        //$data['server_time']=date('h:i A', strtotime(date('h:i A')));
            echo json_encode($data);
                 }
                 else{
                         $data["responce"] = false;
            $data['message'] = "list subscription empty";
            echo json_encode($data);
                 }
}

public function deliver_timin_g()
{
       $data = array(); 
            $_POST = $_REQUEST;      
                $this->load->library('form_validation');                
                /* add registers table validation */
                $this->form_validation->set_rules('time_id', 'time_id', 'trim|required');
                if ($this->form_validation->run() == FALSE) 
                {
                    $data["responce"] = false;  
                    $data["error"] = strip_tags($this->form_validation->error_string());                                        
                }else
                {
                            $q1=$this->db->query("SELECT * FROM time_slots where time_id='".$this->input->post("time_id")."'");
                   
                   if(!$q1->result())
                    {
                             $data["responce"] = false;                                     
                            $data["message"] = "";    
                    }
                    else
                    {
                    
                            $data["responce"] = true;   
                            $data['data'] = $q1->row();
                    }
                }
                     echo json_encode($data);
}

public function deliver_timing12()
{
	 $q = $this->db->query("SELECT time_id,DATE_FORMAT(opening_time,'%H:%i') as opening_time,DATE_FORMAT(closing_time,'%H:%i') as closing_time FROM time_slots order by time_id ASC limit 2"); 
	 $q1 = $this->db->query("SELECT time_id,DATE_FORMAT(second_slot_opening_time,'%H:%i') as opening_time,DATE_FORMAT(second_slot_closing_time,'%H:%i') as closing_time FROM time_slots order by time_id ASC limit 1"); 
     $time=$q->result();
     $time1=$q1->row();
     $time[1]->opening_time=$time1->opening_time;
     $time[1]->closing_time=$time1->closing_time;
		 if ($q->num_rows() > 0)
		 {
			$data["responce"] = true;     
            $data['data'] = $time;
			//$data['server_time']=date('h:i A', strtotime(date('h:i A')));
            echo json_encode($data);  					 
		 }
		 else{
			 $data["responce"] = false;     
            $data['message'] = "list subscription empty";
            echo json_encode($data);  					
		 }	         
}


/* fetch referral_code */
public function get_referral_code()
{
		 $data = array(); 
            $_POST = $_REQUEST;      
                $this->load->library('form_validation');				
				
                /* add registers table validation */
				
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
				 if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}else
                {
						 $q = $this->db->query("SELECT user_id,referral_code FROM registers WHERE  user_id=".$this->input->post("user_id") );																	 
							if ($q->num_rows() > 0)
							{
									$data["responce"] = true;     
									$data['data'] = $q->result();
									echo json_encode($data);  					 
							}
							else{
									$data["responce"] = false;     
									$data['message'] = "list subscription empty";
									echo json_encode($data);  					
									}	     
				}
}


public function add_cart123()
{	
			    $data = array(); 
				$_POST = $_REQUEST; 
                $this->load->library('form_validation');				
                
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
				$this->form_validation->set_rules('sub_id', 'Subscription ID', 'trim');
				$this->form_validation->set_rules('pro_id', 'Product ID', 'trim|required');
				$this->form_validation->set_rules('qty', 'Quantity', 'trim|required');
				$this->form_validation->set_rules('price', 'Price', 'trim|required');
				
				if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}
				else					
                {

					
					$is_stock=$this->db->query("SELECT in_stock from products where product_id='".$this->input->post("pro_id")."'");
                    $is_stock1=$is_stock->row();
                    if(!empty($is_stock1) && $is_stock1->in_stock==0)
                    {
                        $data["responce"] = false; 									
					    $data["message"] = "Product is out of stock";	
					    echo json_encode($data);
					    exit();
                    }
                    
                    $purchase_stock=$this->db->query("SELECT * from purchase where product_id='".$this->input->post("pro_id")."'");
                    $purchase_stock1=$purchase_stock->row();
                    
                    if(!empty($purchase_stock->row()) && $purchase_stock1->qty <=0)
                    {
                        
                        $data["responce"] = false; 									
					    $data["message"] = "Product is out of stock";	
					    echo json_encode($data);
					    exit();
					    
                    }
                    
                
					$check=$this->db->query("SELECT * FROM add_cart_list WHERE  user_id= '".$this->input->post("user_id")."'  AND  product_id='".$this->input->post("pro_id")."'");
					$cart=$check->row();
					$check_stock=$this->db->query("SELECT * from purchase where product_id='".$this->input->post("pro_id")."'");
                    if(!empty($check_stock->row()) && 0 < $this->input->post("qty"))
                    {
                        $result=$check_stock->row();
                        if($result->qty==0 || (!empty($cart->qty) && $result->qty< ($cart->qty+1)))
                        {
                            $data["responce"] = false; 									
						    $data["message"] = "Product is out of stock";	
						    echo json_encode($data);
						    exit();
                        }
                    }
                    
					if($check->num_rows()==1)
					{
						$this->db->query("UPDATE add_cart_list  SET price='".$this->input->post("price")."',subscription_id='".$this->input->post("sub_id")."',qty=qty+'".$this->input->post("qty")."' WHERE  user_id= '".$this->input->post("user_id")."'  AND  product_id='".$this->input->post("pro_id")."'");
						$data["responce"] = true; 									
						$data["message"] = "add to card item sucessfully..";		
						
					}
					else{
							$this->db->insert("add_cart_list", array("user_id"=>$this->input->post("user_id"),
                                            "product_id"=>$this->input->post("pro_id"),
                                             "subscription_id"=>0,
											 "qty"=>$this->input->post("qty"),											
                                            ));
							$user_id =  $this->db->insert_id();  							
							$data["responce"] = true; 
							$data["message"] = "add to card item sucessfully..";
							}
				}	
				echo json_encode($data);  	
}

public function add_cart_dev()
{	
			    $data = array(); 
				$_POST = $_REQUEST; 
                $this->load->library('form_validation');				
                
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
				$this->form_validation->set_rules('sub_id', 'Subscription ID', 'trim');
				$this->form_validation->set_rules('pro_id', 'Product ID', 'trim|required');
				$this->form_validation->set_rules('qty', 'Quantity', 'trim|required');
				$this->form_validation->set_rules('price', 'Price', 'trim|required');
				
				if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}
				else					
                {
                    /*      deal of product check logic max count */
                    $deal_max_count=$this->db->query("Select deal_max_count from global_setting order by globe_setting_id DESC limit 1");		
                    $deal_max_count1 = $deal_max_count->row();
                    
    
                       
					    
                    $total_cart1=$this->db->query("SELECT sum(add_cart_list.qty) as total_cart FROM deal_product INNER JOIN add_cart_list on deal_product.product_id=add_cart_list.product_id WHERE (NOW() BETWEEN concat(start_date,' ',start_time) AND concat(end_date,' ',end_time)) AND add_cart_list.user_id='".$this->input->post("user_id")."'");
                    $total_cart=$total_cart1->row();
                    
                    //print_r($total_cart->total_cart);
                    
                    $deal_list1=$this->db->query("SELECT * FROM deal_product INNER JOIN add_cart_list on deal_product.product_id=add_cart_list.product_id WHERE (NOW() BETWEEN concat(start_date,' ',start_time) AND concat(end_date,' ',end_time)) AND add_cart_list.user_id='".$this->input->post("user_id")."' AND add_cart_list.product_id='".$this->input->post("pro_id")."'");
					$add_cart_deal = $deal_list1->row();
					if(!empty($add_cart_deal))
					{
					    if(!empty($total_cart->total_cart) &&  $deal_max_count1->deal_max_count <= $total_cart->total_cart && 0< $this->input->post("qty"))
					    {
					        $data["responce"] = false; 									
					        $data["message"] = "Total Deal of product maximum count is ".$deal_max_count1->deal_max_count;	
					        echo json_encode($data);
					        exit();  
					    }
					    
					    if($add_cart_deal->max_qty <= $add_cart_deal->qty && 0< $this->input->post("qty"))
					    {
					        $data["responce"] = false; 									
					        $data["message"] = "Deal max count is ".$add_cart_deal->max_qty;	
					        echo json_encode($data);
					        exit();  
					    }
					    
					}
					
					$is_stock=$this->db->query("SELECT in_stock from products where product_id='".$this->input->post("pro_id")."'");
                    $is_stock1=$is_stock->row();
                    if(!empty($is_stock1) && $is_stock1->in_stock==0)
                    {
                        $data["responce"] = false; 									
					    $data["message"] = "Product is out of stock";	
					    echo json_encode($data);
					    exit();
                    }
                    
                    $purchase_stock=$this->db->query("SELECT * from purchase where product_id='".$this->input->post("pro_id")."'");
                    $purchase_stock1=$purchase_stock->row();
                    
                    if(!empty($purchase_stock->row()) && $purchase_stock1->qty <=0)
                    {
                        $data["responce"] = false; 									
					    $data["message"] = "Product is out of stock";	
					    echo json_encode($data);
					    exit();
                    }
                    
                
					$check=$this->db->query("SELECT * FROM add_cart_list WHERE  user_id= '".$this->input->post("user_id")."'  AND  product_id='".$this->input->post("pro_id")."'");
					$cart=$check->row();
					$check_stock=$this->db->query("SELECT * from purchase where product_id='".$this->input->post("pro_id")."'");
                    if(!empty($check_stock->row()) && 0 < $this->input->post("qty"))
                    {
                        $result=$check_stock->row();
                        if($result->qty==0 || (!empty($cart->qty) && $result->qty< ($cart->qty+1)))
                        {
                            $data["responce"] = false; 									
						    $data["message"] = "Product is out of stock";	
						    echo json_encode($data);
						    exit();
                        }
                    }
                    
					if($check->num_rows()==1)
					{
						$this->db->query("UPDATE add_cart_list  SET price='".$this->input->post("price")."',subscription_id='".$this->input->post("sub_id")."',qty='".$this->input->post("qty")."' WHERE  user_id= '".$this->input->post("user_id")."'  AND  product_id='".$this->input->post("pro_id")."'");
						$data["responce"] = true; 									
						$data["message"] = "add to card item sucessfully..";		
						
					}
					else{
							$this->db->insert("add_cart_list", array("user_id"=>$this->input->post("user_id"),
                                            "product_id"=>$this->input->post("pro_id"),
                                             "subscription_id"=>0,
											 "qty"=>$this->input->post("qty"),											
                                            ));
							$user_id =  $this->db->insert_id();  							
							$data["responce"] = true; 
							$data["message"] = "add to card item sucessfully..";
							}
				}	
				echo json_encode($data);  	
}


public function add_cart_old_11_04()
{	
			    $data = array(); 
				$_POST = $_REQUEST; 
                $this->load->library('form_validation');				
                
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
				$this->form_validation->set_rules('sub_id', 'Subscription ID', 'trim');
				$this->form_validation->set_rules('pro_id', 'Product ID', 'trim|required');
				$this->form_validation->set_rules('qty', 'Quantity', 'trim|required');
				$this->form_validation->set_rules('price', 'Price', 'trim|required');
				$this->form_validation->set_rules('unit', 'Price', 'trim|required');
				$this->form_validation->set_rules('unit_value', 'Price', 'trim|required');
				
				if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}
				else					
                {
                    /*      deal of product check logic max count */
                    $deal_max_count=$this->db->query("Select deal_max_count from global_setting order by globe_setting_id DESC limit 1");		
                    $deal_max_count1 = $deal_max_count->row();
                    
                    /*
                    $intial_deal1=$this->db->query("SELECT sum(add_cart_list.qty) as total_cart FROM deal_product INNER JOIN add_cart_list on deal_product.product_id=add_cart_list.product_id WHERE (NOW() BETWEEN concat(start_date,' ',start_time) AND concat(end_date,' ',end_time)) AND add_cart_list.user_id='".$this->input->post("user_id")."'");
                    $intial_deal=$intial_deal1->row();
                    print_r($intial_deal);exit();   
					*/
					
                    $total_cart1=$this->db->query("SELECT sum(add_cart_list.qty) as total_cart FROM deal_product INNER JOIN add_cart_list on deal_product.product_id=add_cart_list.product_id WHERE (NOW() BETWEEN concat(start_date,' ',start_time) AND concat(end_date,' ',end_time)) AND add_cart_list.user_id='".$this->input->post("user_id")."' AND add_cart_list.unit_value='".$this->input->post("unit_value")."' AND add_cart_list.unit='".$this->input->post("unit")."'");
                    
                    $total_cart=$total_cart1->row();
                    if(empty($total_cart->total_cart))
                    {
                        if($deal_max_count1->deal_max_count<$this->input->post("qty"))
                        {
                            $data["responce"] = false; 									
					        $data["message"] = "Total Deal of product maximum count is ".$deal_max_count1->deal_max_count;	
					        echo json_encode($data);
					        exit();  
                        }
                        $total_max_qty1=$this->db->query("SELECT *  FROM deal_product  WHERE (NOW() BETWEEN concat(start_date,' ',start_time) AND concat(end_date,' ',end_time)) AND product_id='".$this->input->post("pro_id")."'AND deal_unit_value='".$this->input->post("unit_value")."' AND deal_unit='".$this->input->post("unit")."'");
                        $total_max_qty=$total_max_qty1->row();
                        if(!empty($total_max_qty) && $total_max_qty->max_qty < $this->input->post("qty"))
                        {
                            $data["responce"] = false; 									
					        $data["message"] = "The product item count not greater than ".$total_max_qty->max_qty;	
					        echo json_encode($data);
					        exit();  
                        }
                    }
                    
                    //print_r($total_cart->total_cart);
                    
                    $deal_list1=$this->db->query("SELECT * FROM deal_product INNER JOIN add_cart_list on deal_product.product_id=add_cart_list.product_id WHERE (NOW() BETWEEN concat(start_date,' ',start_time) AND concat(end_date,' ',end_time)) AND add_cart_list.user_id='".$this->input->post("user_id")."' AND add_cart_list.product_id='".$this->input->post("pro_id")."' AND add_cart_list.unit_value='".$this->input->post("unit_value")."' AND add_cart_list.unit='".$this->input->post("unit")."'");
					$add_cart_deal = $deal_list1->row();
					if(!empty($add_cart_deal))
					{
					    if(!empty($total_cart->total_cart) &&  $deal_max_count1->deal_max_count <= $total_cart->total_cart && 0< $this->input->post("qty"))
					    {
					        $data["responce"] = false; 									
					        $data["message"] = "Total Deal of product maximum count is ".$deal_max_count1->deal_max_count;	
					        echo json_encode($data);
					        exit();  
					    }
					    
					    if($add_cart_deal->max_qty <= $add_cart_deal->qty && 0< $this->input->post("qty"))
					    {
					        $data["responce"] = false; 									
					        $data["message"] = "The product item count not greater than ".$add_cart_deal->max_qty;	
					        echo json_encode($data);
					        exit();  
					    }
					    
					    if($add_cart_deal->max_qty < ($add_cart_deal->qty+$this->input->post("qty")) && 0< $this->input->post("qty"))
					    {
					        $data["responce"] = false; 									
					        $data["message"] = "The product item count not greater than ".$add_cart_deal->max_qty;	
					        echo json_encode($data);
					        exit();  
					    }
					}
					
					$is_stock=$this->db->query("SELECT in_stock from products where product_id='".$this->input->post("pro_id")."'");
                    $is_stock1=$is_stock->row();
                    if(!empty($is_stock1) && $is_stock1->in_stock==0)
                    {
                        $data["responce"] = false; 									
					    $data["message"] = "Product is out of stock..";	
					    echo json_encode($data);
					    exit();
                    }
                    /*
                    $purchase_stock=$this->db->query("SELECT * from purchase where product_id='".$this->input->post("pro_id")."'");
                    $purchase_stock1=$purchase_stock->row();
                    
                    if(!empty($purchase_stock->row()) && $purchase_stock1->qty <=0)
                    {
                        $data["responce"] = false; 									
					    $data["message"] = "Product is out of stock";	
					    echo json_encode($data);
					    exit();
                    }
                    */
                
					$check=$this->db->query("SELECT * FROM add_cart_list WHERE  user_id= '".$this->input->post("user_id")."'  AND  product_id='".$this->input->post("pro_id")."' AND  unit='".$this->input->post("unit")."' AND  unit_value='".$this->input->post("unit_value")."'");
					$cart=$check->row();
					/*
					$check_stock=$this->db->query("SELECT * from purchase where product_id='".$this->input->post("pro_id")."'");
                    
                    if(!empty($check_stock->row()) && 0 < $this->input->post("qty"))
                    {
                        $result=$check_stock->row();
                        if($result->qty==0 || (!empty($cart->qty) && $result->qty< ($cart->qty+1)))
                        {
                            $data["responce"] = false; 									
						    $data["message"] = "Product is out of stock";	
						    echo json_encode($data);
						    exit();
                        }
                    }
                    */
					if($check->num_rows()==1)
					{
						$this->db->query("UPDATE add_cart_list  SET price='".$this->input->post("price")."',subscription_id='".$this->input->post("sub_id")."',qty=qty+'".$this->input->post("qty")."' WHERE  user_id= '".$this->input->post("user_id")."'  AND  product_id='".$this->input->post("pro_id")."'AND  unit='".$this->input->post("unit")."' AND  unit_value='".$this->input->post("unit_value")."'");
						$data["responce"] = true; 									
						$data["message"] = "add to card item sucessfully..";		
						
					}
					else{
							$this->db->insert("add_cart_list", array("user_id"=>$this->input->post("user_id"),
                                            "product_id"=>$this->input->post("pro_id"),
                                             "subscription_id"=>0,
											 "qty"=>$this->input->post("qty"),
											 "unit"=>$this->input->post("unit"),
											 "unit_value"=>$this->input->post("unit_value"),
                                            ));
							$user_id =  $this->db->insert_id();  							
							$data["responce"] = true; 
							$data["message"] = "add to card item sucessfully..";
							}
				}	
				echo json_encode($data);  	
}

public function add_cart()
{	
			    $data = array(); 
				$_POST = $_REQUEST; 
                $this->load->library('form_validation');				
                
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
				$this->form_validation->set_rules('sub_id', 'Subscription ID', 'trim');
				$this->form_validation->set_rules('pro_id', 'Product ID', 'trim|required');
				$this->form_validation->set_rules('qty', 'Quantity', 'trim|required');
				//$this->form_validation->set_rules('price', 'Price', 'trim|required');
				$this->form_validation->set_rules('unit', 'Price', 'trim|required');
				$this->form_validation->set_rules('unit_value', 'Price', 'trim|required');
				
				if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}
				else					
                {
                    /*      deal of product check logic max count */
                    $deal_max_count=$this->db->query("Select deal_max_count from global_setting order by globe_setting_id DESC limit 1");		
                    $deal_max_count1 = $deal_max_count->row();
                    
                    /*
                    $intial_deal1=$this->db->query("SELECT sum(add_cart_list.qty) as total_cart FROM deal_product INNER JOIN add_cart_list on deal_product.product_id=add_cart_list.product_id WHERE (NOW() BETWEEN concat(start_date,' ',start_time) AND concat(end_date,' ',end_time)) AND add_cart_list.user_id='".$this->input->post("user_id")."'");
                    $intial_deal=$intial_deal1->row();
                    print_r($intial_deal);exit();   
					*/
					
                    $total_cart1=$this->db->query("SELECT sum(add_cart_list.qty) as total_cart FROM deal_product INNER JOIN add_cart_list on deal_product.product_id=add_cart_list.product_id WHERE (NOW() BETWEEN concat(start_date,' ',start_time) AND concat(end_date,' ',end_time)) AND add_cart_list.user_id='".$this->input->post("user_id")."' ");
                    $total_cart=$total_cart1->row();
            
                    if(empty($total_cart->total_cart))
                    {
                        if($deal_max_count1->deal_max_count<$this->input->post("qty"))
                        {
                            $data["responce"] = false; 									
					        $data["message"] = "Total Deal of product maximum count is ".$deal_max_count1->deal_max_count;	
					        echo json_encode($data);
					        exit();  
                        }
                        $total_max_qty1=$this->db->query("SELECT *  FROM deal_product  WHERE (NOW() BETWEEN concat(start_date,' ',start_time) AND concat(end_date,' ',end_time)) AND product_id='".$this->input->post("pro_id")."'AND deal_unit_value='".$this->input->post("unit_value")."' AND deal_unit='".$this->input->post("unit")."'");
                        $total_max_qty=$total_max_qty1->row();
                        if(!empty($total_max_qty) && $total_max_qty->max_qty < $this->input->post("qty"))
                        {
                            $data["responce"] = false; 									
					        $data["message"] = "The product item count not greater than ".$total_max_qty->max_qty;	
					        echo json_encode($data);
					        exit();  
                        }
                    }
                    
                    //print_r($total_cart->total_cart);
                    
                    $deal_list1=$this->db->query("SELECT * FROM deal_product INNER JOIN add_cart_list on deal_product.product_id=add_cart_list.product_id WHERE (NOW() BETWEEN concat(start_date,' ',start_time) AND concat(end_date,' ',end_time)) AND add_cart_list.user_id='".$this->input->post("user_id")."' AND add_cart_list.product_id='".$this->input->post("pro_id")."' AND add_cart_list.unit_value='".$this->input->post("unit_value")."' AND add_cart_list.unit='".$this->input->post("unit")."'");
					$add_cart_deal = $deal_list1->row();
					//echo "<pre>";print_r($add_cart_deal);exit();
					if(!empty($add_cart_deal))
					{
					    if(!empty($total_cart->total_cart) &&  $deal_max_count1->deal_max_count <= $total_cart->total_cart && 0< $this->input->post("qty"))
					    {
					        $data["responce"] = false; 									
					        $data["message"] = "Total Deal of product maximum count is ".$deal_max_count1->deal_max_count;	
					        echo json_encode($data);
					        exit();  
					    }
					    
					    if($add_cart_deal->max_qty <= $add_cart_deal->qty && 0< $this->input->post("qty"))
					    {
					        $data["responce"] = false; 									
					        $data["message"] = "The product item count not greater than ".$add_cart_deal->max_qty;	
					        echo json_encode($data);
					        exit();  
					    }
					    
					    if($add_cart_deal->max_qty < ($add_cart_deal->qty+$this->input->post("qty")) && 0< $this->input->post("qty"))
					    {
					        $data["responce"] = false; 									
					        $data["message"] = "The product item count not greater than ".$add_cart_deal->max_qty;	
					        echo json_encode($data);
					        exit();  
					    }
					}
					
					$is_stock=$this->db->query("SELECT in_stock from products where product_id='".$this->input->post("pro_id")."'");
                    $is_stock1=$is_stock->row();
                    if(!empty($is_stock1) && $is_stock1->in_stock==0)
                    {
                        $data["responce"] = false; 									
					    $data["message"] = "Product is out of stock..";	
					    echo json_encode($data);
					    exit();
                    }
                    /*
                    $purchase_stock=$this->db->query("SELECT * from purchase where product_id='".$this->input->post("pro_id")."'");
                    $purchase_stock1=$purchase_stock->row();
                    
                    if(!empty($purchase_stock->row()) && $purchase_stock1->qty <=0)
                    {
                        $data["responce"] = false; 									
					    $data["message"] = "Product is out of stock";	
					    echo json_encode($data);
					    exit();
                    }
                    */
                
					$check=$this->db->query("SELECT * FROM add_cart_list WHERE  user_id= '".$this->input->post("user_id")."'  AND  product_id='".$this->input->post("pro_id")."' AND  unit='".$this->input->post("unit")."' AND  unit_value='".$this->input->post("unit_value")."'");
					$cart=$check->row();
					/*
					$check_stock=$this->db->query("SELECT * from purchase where product_id='".$this->input->post("pro_id")."'");
                    
                    if(!empty($check_stock->row()) && 0 < $this->input->post("qty"))
                    {
                        $result=$check_stock->row();
                        if($result->qty==0 || (!empty($cart->qty) && $result->qty< ($cart->qty+1)))
                        {
                            $data["responce"] = false; 									
						    $data["message"] = "Product is out of stock";	
						    echo json_encode($data);
						    exit();
                        }
                    }
                    */
					if($check->num_rows()==1)
					{
						$this->db->query("UPDATE add_cart_list  SET price='".$this->input->post("price")."',subscription_id='".$this->input->post("sub_id")."',qty='".$this->input->post("qty")."' WHERE  user_id= '".$this->input->post("user_id")."'  AND  product_id='".$this->input->post("pro_id")."'AND  unit='".$this->input->post("unit")."' AND  unit_value='".$this->input->post("unit_value")."'");
						$data["responce"] = true; 									
						$data["message"] = "add to card item sucessfully..";		
						
					}
					else{
							$this->db->insert("add_cart_list", array("user_id"=>$this->input->post("user_id"),
                                            "product_id"=>$this->input->post("pro_id"),
                                             "subscription_id"=>0,
											 "qty"=>$this->input->post("qty"),
											 "unit"=>$this->input->post("unit"),
											 "unit_value"=>$this->input->post("unit_value"),
                                            ));
							$user_id =  $this->db->insert_id();  							
							$data["responce"] = true; 
							$data["message"] = "add to card item sucessfully..";
							}
				}	
				echo json_encode($data);  	
}
public function cart_delete()
{
	$data = array(); 
				$_POST = $_REQUEST; 
                $this->load->library('form_validation');				               
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');				
				$this->form_validation->set_rules('pro_id', 'Product ID', 'trim|required');
				//$this->form_validation->set_rules('unit', 'unit', 'trim|required');
				//$this->form_validation->set_rules('unit_value', 'unit value', 'trim|required');
				//$this->form_validation->set_rules('price', 'Price', 'trim|required');
				
				 if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}
				else					
				{
					//$this->db->delete("add_cart_list",array("product_id"=>$this->input->post("pro_id")));
					$check=$this->db->query("DELETE FROM add_cart_list WHERE user_id='".$this->input->post("user_id")."' AND  product_id=".$this->input->post("pro_id"));
					
					$data["responce"] = true; 									
					$data["message"] = "Removed product  Sucessfully..";											
				}
				echo json_encode($data);  	
}

public function c_v()
{
	$data = array(); 
            $_POST = $_REQUEST;      
                $this->load->library('form_validation');				
                /* add registers table validation */
				
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
				//$this->form_validation->set_rules('wallet_amount', 'Wallet amt', 'trim');
				$this->form_validation->set_rules('coup_id', 'Coupon ID', 'trim');
				
				if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}else
                {
                	//echo "yes";
                	$query=$this->db->query("SELECT add_cart_list.*,category_id FROM add_cart_list,products WHERE add_cart_list.product_id=products.product_id AND user_id=".$this->input->post("user_id"));
                	//print_r($query->result());
                	//die();
                	/*		check for product */
                	$status=0;
                	foreach ($query->result() as $row) 
                	{
                		//echo $row->product_id."<br>";
                		$product_check=$this->db->query("SELECT * FROM coupons WHERE $row->product_id IN (type_id) AND validity_type='Product'AND id='".$this->input->post("coup_id")."'");
                		//print_r($product_check->result());
                		if(!empty($product_check->result()))
                		$status=$status+1;

                	}
                	
                	/*		check for category_id 		*/
                	foreach ($query->result() as $row) 
                	{
                		//echo $row->product_id."<br>";

                		$product_check=$this->db->query("SELECT * FROM coupons WHERE $row->category_id IN (type_id) AND validity_type='Category'AND id='".$this->input->post("coup_id")."'");
                		//print_r($product_check->result());
                		if(!empty($product_check->result()))
                		$status=$status+1;
                	}
                	//print_r($query->result());
				}
				if($status!=0)
				{
					$data["responce"]=true;
					$data["message"]="coupons applied";
					$data["user_id"]=$this->input->post("user_id");
					$data["coup_id"]=$this->input->post("coup_id");

				}
				else
				{
					$data["responce"]=false;
					$data["message"]="coupons not applied";
					
				}
				//echo $status;
				//die();
				echo json_encode($data);
}
public function cart_count()
{
	$data = array(); 
            $_POST = $_REQUEST;      
                $this->load->library('form_validation');				
                /* add registers table validation */
				
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');		
				if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}else
               {

                	$product_count = $this->db->query("SELECT sum(qty) as cart_qty_sum, COUNT(user_id) as  cart_qty_count FROM add_cart_list WHERE product_id!='0' and user_id=".$this->input->post("user_id")); 
                	//print_r($product_count->result_array());
                	
                    $row=$product_count->result_array();
                   // echo $row[0]['cart_qty_count'];

                    
                    $subs_count = $this->db->query("SELECT COUNT(user_id) as  cart_qty_count FROM add_cart_list WHERE product_id=0 AND subscription_id!='0' and user_id=".$this->input->post("user_id")); 
                    //print_r($subs_count->result_array());
                    
					$rows=$subs_count->result_array();
					//echo $rows[0]['cart_qty_count'];
					//die();
					//print_r();
					//die();

                    $total_count=$row[0]['cart_qty_count']+$rows[0]['cart_qty_count'];
                    $data["responce"] = true;
                    $data["data"]=$total_count;		
				}
				echo json_encode($data);
}
public function subscriptionremove()
{
	$data = array(); 
            $_POST = $_REQUEST;      
                $this->load->library('form_validation');				
                /* add registers table validation */
				
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
				$this->form_validation->set_rules('sub_id', 'Subscription ID', 'trim|required');
				
				if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}else
                {
                	$this->db->query("DELETE FROM subscribe_plan WHERE subscription_id='".$this->input->post("sub_id")."' AND user_id='".$this->input->post("user_id")."'");
                	$this->db->query("UPDATE add_cart_list  SET subscription_id=0 WHERE  user_id= '".$this->input->post("user_id")."'");
                	$this->db->query("DELETE FROM add_cart_list WHERE product_id=0 AND qty=0 AND user_id='".$this->input->post("user_id")."'");

				}	
				$data["message"]="Removed subscription";

				echo json_encode($data);
}
/*
public function get_cart_list()
{
	 $data = array(); 
            $_POST = $_REQUEST; 
            $sub=0;     
                $this->load->library('form_validation');				
                
				
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
				$this->form_validation->set_rules('wallet_amount', 'Wallet amt', 'trim');
				$this->form_validation->set_rules('coup_id', 'Coupon ID', 'trim');
				
				if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}else
                {
						$q = $this->db->query("select * from add_cart_list ,products where products.product_id=add_cart_list.product_id AND user_id=".$this->input->post("user_id")); 																													
						if(!empty($this->input->post("coup_id")))
						{							
							$cou_id=$this->input->post("coup_id");
						}
						else
						{
								$cou_id=0;
						}
						
						$coupon_amt=$this->db->query("SELECT * FROM coupons WHERE id=".$cou_id);						
						$total_product_amt=0;
						$total_amt=0;
						$subscribe_amt=0;						
						$discount_type=0;  //$discount_type=0 means amt and  1 means %
						$discount_value=0;
						$final_amount=0;		
						$sub=0;
						$coup_details=$coupon_amt->result();												
						foreach($coupon_amt->result_array() as $r)
						{
							$discount_type=$r['discount_type'];							
							$discount_value=$r['discount_value'];
							
						}
						
						foreach ($q->result_array() as $row)
						{								
								if(isset($row['subscription_id']) && $row['subscription_id']!=0)
								{
									$total_amt=$total_amt+($row['qty']*$row['subscription_price']);
								}
								else
								{
									$total_amt=$total_amt+($row['qty']*$row['surfcity_price']);
								}
								$sub=$row['subscription_id'];								
						}						
						
						//echo $total_amt;						
						$final_amount=$total_amt-$this->input->post("wallet_amount");
						
						/*
						if($discount_type==1)
						{
							$discount_value=$total_amt*($discount_value/100);
							$total*(100/100);
						}						
						*/
						
	//					$final_amount=$final_amount-$discount_value;
						
						//echo  $final_amount;
						
						//$row=$q->result();
						//print_r($row);
						
						//die();
		/*				$subscribe_details=$this->db->query("SELECT *  FROM subscription_plan WHERE  subscription_id=".$sub);

						foreach ($subscribe_details->result_array() as $row)
						{
							if(!empty($row['subscription_id']))
							{
							
							$qq=$this->db->query("SELECT * FROM subscribe_plan WHERE user_id='".$this->input->post("user_id")."' AND subscription_id=".$row['subscription_id']);
							
								if($qq->result())
								{
									$final_amount=$final_amount+0;		
								}
								else 
								{
									
								
									$array=array("subscription_id"=>$row['subscription_id'],
                                            "user_id"=>$this->input->post("user_id"),
                                            "subscription_days"=>$row['subscription_days'],
                                             "subscription_start_date"=>date('Y-m-d'));

									$this->db->insert("subscribe_plan",$array);
									//print_r($this->db->last_query());
									
									$this->db->insert_id();
									$final_amount=$final_amount+$row['subscription_price'];
									//$final_amount=$final_amount+$row['subscription_price'];		
								}
							}
							//$final_amount=$final_amount+$row['subscription_price'];
						}
						
						//$subscribe_details=$this->db->query("SELECT *  FROM subscription_plan WHERE  subscription_id=".$this->input->post("user_id"));
						
						$data["responce"] = true;     
					    $data['data'] = $q->result();
						$data['subscribe_data']=$subscribe_details->result();																		
						$data['coupon_amt']=$discount_value;
						$data['wallet_amt']=$this->input->post("wallet_amount");
						$data['total_amt']=$total_amt;
						$data['net_total_amt']=$final_amount;
				}
				echo json_encode($data);  	
}
*/


public function get_cart_list123()
{
       	    $data = array(); 
            $_POST = $_REQUEST; 
           // print_r($_POST);exit();
            $sub=0;     
                $this->load->library('form_validation');				
                /* add registers table validation */
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
				$this->form_validation->set_rules('wallet_amount', 'Wallet amt', 'trim');
				$this->form_validation->set_rules('coup_id', 'Coupon ID', 'trim');
				$this->form_validation->set_rules('subscription_id', 'subscription ID', 'trim');
				
				if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}
        		else
                {
                        $this->db->query("delete from temp_cart_sale where user_id =".$this->input->post("user_id"));
						/*prodcut total 3 type*/
						$coupon_price=0;
						$total_product_amt=0;
						$total_amt=0;
						$subscribe_amt=0;						
						$discount_type=0;  //$discount_type=0 means amt and  1 means %
						$discount_value=0;
						$final_amount=0;		
						$sub=0;
						$cashback=0;
						$delivery_charge=0;
						
						/*	get delivery charge 	*/
						$dc=$this->db->query("Select delivery_charges from global_setting order by globe_setting_id DESC limit 1");
						$dc1=$dc->row_array();
						if(isset($dc1))
						{
						    $delivery_charge=$dc1['delivery_charges'];    
						}
						
						
						/*	get deal of product by send as  product_id and max_qty	*/
						$deal_product_id=$this->db->query("SELECT deal_product.product_id,deal_product.max_qty FROM add_cart_list INNER JOIN deal_product ON deal_product.product_id=add_cart_list.product_id  AND (NOW() BETWEEN concat(start_date,' ',start_time) AND concat(end_date,' ',end_time)) WHERE user_id=".$this->input->post("user_id")); 											
						
						//$q = $this->db->query("select products.*,add_cart_list.* ,deal_price from (add_cart_list INNER JOIN products on products.product_id=add_cart_list.product_id) LEFT JOIN deal_product ON add_cart_list.product_id=deal_product.product_id AND (NOW() BETWEEN concat(deal_product.start_date,' ',deal_product.start_time) AND concat(deal_product.end_date,' ',deal_product.end_time)) where user_id=".$this->input->post("user_id")); 	
						
						/*	get cart_list also get product details and deal_product_price if deal of product not present return deal_price as null or blank*/									
						$q=$this->db->query("SELECT add_cart_list.*,products.* ,deal_product.deal_price FROM `add_cart_list` INNER JOIN products ON add_cart_list.product_id=products.product_id LEFT JOIN deal_product ON deal_product.product_id=add_cart_list.product_id AND (NOW() BETWEEN concat(deal_product.start_date,' ',deal_product.start_time) AND concat(deal_product.end_date,' ',deal_product.end_time)) where add_cart_list.user_id=".$this->input->post("user_id"));
						
						/*----------Set subscription plan------*/
						$free_delivery=0;
						$unlock_subscrption_price=0;
						$unlock_cash_back=0;
						$free_delivery_max_amt=0;
						/*-------------------*/
						$subscriptiondetails1=$this->db->query("SELECT * FROM subscribe_plan INNER JOIN subscription_plan ON subscribe_plan.purchase=1 AND subscription_plan.subscription_id=subscribe_plan.subscription_id AND NOW() <= subscribe_plan.subscription_end_date WHERE subscribe_plan.user_id=".$this->input->post("user_id"));
						$sb1=$subscriptiondetails1->row_array();
						
						if(!empty($sb1))
						{
						    $unlock_subscrption_price=$sb1['subscription_details1'];
						    $free_delivery=$sb1['subscription_details2'];
						    $unlock_cash_back=$sb1['subscription_details3'];
						    $free_delivery_max_amt=$sb1['max_limit_apply'];
						}
						
						/*  get coupon details 		*/			
						
						/* coupon_amt  */
						//$this->input->post("coup_id")=0;
						$coup_id=0;
						if(!empty($this->input->post("coup_id")))
						{
						    $coup_id=$this->input->post("coup_id");
						}
						$coupon_amt=$this->db->query("SELECT * FROM coupons where valid_to>='".date('d/m/Y')."' AND  id=".$coup_id);		 
						$coup_details=$coupon_amt->row();
						
						if($coupon_amt->result())
						{
                        $result=$coupon_amt->row();
                         
                         $cp_count = $this->db->query("SELECT count(coupons_id) as coupons_count FROM sale where user_id='".$this->input->post("user_id")."' AND coupons_id='$result->id'");
                        $cp_count1=$cp_count->row();
                        if($result->max_count<=$cp_count1->coupons_count)
                        {
                            $coup_details=array();
                        }
                        }
						print_r($coup_details);exit();
						
						foreach ($q->result_array() as $row)
						{		
						        $product_list=array();
						        //print_r($row);
						        $t_p=0;
								if(!empty($row['deal_price']))
								{
								    $t_p=$row['deal_price']*$row['qty'];        
								}
								elseif($unlock_subscrption_price==1)
								{
								    $t_p=$row['subscription_price']*$row['qty'];
								}else{
								    $t_p=$row['surfcity_price']*$row['qty'];        
								}
								
								$product_list['product_id']=$row['product_id'];
								$product_list['user_id']=$this->input->post("user_id");
								$product_list['product_name']=$row['product_name'];
								$product_list['qty']=$row['qty'];
								$product_list['unit']=$row['unit'];
								$product_list['price']=$t_p;
								//print_r($product_list);
								$this->db->insert("temp_cart_sale",$product_list);
								$total_product_amt=$total_product_amt+$t_p;
								
								if($unlock_cash_back==1)
								{
								    $cashback=$cashback+$row['cashback'];								    
								}
								
						}	
						
						
						/*  FREE DELIVERY   */
						if($free_delivery==1)
						{
						    if($free_delivery_max_amt<=$total_product_amt)
						    {
						        $delivery_charge=0;    
						    }
						}
						// coupons discount_type=0 means amt and  1 means %
						if(!empty($coup_details))
                        {
                            //print_r($coup_details);
                            //echo $coup_details->min_limit;
                            //echo "\n";
                            //echo $coup_details->max_limit;
                            //echo "\n";
                            if($coup_details->min_limit<=$total_product_amt)
                            {
                            
                                if($coup_details->free_delivery==1)
                                {
                                    $delivery_charge=0; 
                                }
                                if($coup_details->discount_type==0)
                                {
                                    $coupon_price=$coup_details->discount_value;
                                }
                                
                                if($coup_details->discount_type==1 && ( $coup_details->min_limit <= $total_product_amt && $total_product_amt <= $coup_details->max_limit ))
                                {
                                    $coupon_price=($total_product_amt*$coup_details->discount_value)/100;
                                    
                                }else{
                                    if($coup_details->discount_type==1)
                                    {
                                    $coupon_price=($coup_details->max_limit*$coup_details->discount_value)/100;
                                    }
                                    
                                }
                                $cashback=$cashback+$coup_details->cashback;
                            }
                            
                        }
                        
						$total_amt=$total_product_amt+$delivery_charge;
						$total_amt=$total_amt-$coupon_price;
						$temp=0.0;
						if($this->input->post("wallet_amount")<$total_amt)
						{
						    $temp=$this->input->post("wallet_amount");    
						}
						
						$total_amt=$total_amt-$temp;
						$data["responce"] = true;     
						$data["deal_product_id"]=$deal_product_id->result();
					    $data['data'] = $q->result();		
						$data['subscribe_data']=$subscriptiondetails1->result();
						$data['delivery_charge']=$delivery_charge;
						$data['total_product_amt']=$total_product_amt;		
						$data['coupon_amt']=$coupon_price;
						$data['wallet_amt']=number_format($temp,1);
						$data['total_amt']=$total_amt;
						$data['cashback']=$cashback;
						$data['net_total_amt']=$total_amt;
				}		
				
				echo json_encode($data);  	
}

public function get_cart_list()
{
       	    $data = array(); 
            $_POST = $_REQUEST; 
           // print_r($_POST);exit();
            $sub=0;     
                $this->load->library('form_validation');				
                /* add registers table validation */
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
				$this->form_validation->set_rules('wallet_amount', 'Wallet amt', 'trim');
				$this->form_validation->set_rules('coup_id', 'Coupon ID', 'trim');
				$this->form_validation->set_rules('subscription_id', 'subscription ID', 'trim');
				
				if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}
        		else
                {
                        $this->db->query("delete from temp_cart_sale where user_id =".$this->input->post("user_id"));
						/*prodcut total 3 type*/
						$coupon_price=0;
						$total_product_amt=0;
						$total_amt=0;
						$subscribe_amt=0;						
						$discount_type=0;  //$discount_type=0 means amt and  1 means %
						$discount_value=0;
						$final_amount=0;		
						$sub=0;
						$cashback=0;
							$GST=0;
						$delivery_charge=0;
				        $iscouponapply='';		
						/*	get delivery charge 	*/
						$dc=$this->db->query("Select delivery_charges from global_setting order by globe_setting_id DESC limit 1");
						$dc1=$dc->row_array();
						if(isset($dc1))
						{
						    $delivery_charge=$dc1['delivery_charges'];    
						}
						
						
						/*	get deal of product by send as  product_id and max_qty	*/
						$deal_product_id=$this->db->query("SELECT deal_product.product_id,deal_product.max_qty FROM add_cart_list INNER JOIN deal_product ON deal_product.product_id=add_cart_list.product_id  AND (NOW() BETWEEN concat(start_date,' ',start_time) AND concat(end_date,' ',end_time)) WHERE user_id=".$this->input->post("user_id")); 											
						
						//$q = $this->db->query("select products.*,add_cart_list.* ,deal_price from (add_cart_list INNER JOIN products on products.product_id=add_cart_list.product_id) LEFT JOIN deal_product ON add_cart_list.product_id=deal_product.product_id AND (NOW() BETWEEN concat(deal_product.start_date,' ',deal_product.start_time) AND concat(deal_product.end_date,' ',deal_product.end_time)) where user_id=".$this->input->post("user_id")); 	
						
						/*	get cart_list also get product details and deal_product_price if deal of product not present return deal_price as null or blank*/									
						$q=$this->db->query("SELECT add_cart_list.*,products.* ,deal_product.deal_price FROM `add_cart_list` INNER JOIN products ON add_cart_list.product_id=products.product_id LEFT JOIN deal_product ON deal_product.product_id=add_cart_list.product_id AND (NOW() BETWEEN concat(deal_product.start_date,' ',deal_product.start_time) AND concat(deal_product.end_date,' ',deal_product.end_time)) where add_cart_list.user_id=".$this->input->post("user_id"));
						
						/*----------Set subscription plan------*/
						$free_delivery=0;
						$msg='';
						$unlock_subscrption_price=0;
						$unlock_cash_back=0;
						$free_delivery_max_amt=0;
						/*-------------------*/
						$subscriptiondetails1=$this->db->query("SELECT * FROM subscribe_plan INNER JOIN subscription_plan ON subscribe_plan.purchase=1 AND subscription_plan.subscription_id=subscribe_plan.subscription_id AND NOW() <= subscribe_plan.subscription_end_date WHERE subscribe_plan.user_id=".$this->input->post("user_id"));
						$sb1=$subscriptiondetails1->row_array();
						
						if(!empty($sb1))
						{
						    $unlock_subscrption_price=$sb1['subscription_details1'];
						    $free_delivery=$sb1['subscription_details2'];
						    $unlock_cash_back=$sb1['subscription_details3'];
						    $free_delivery_max_amt=$sb1['max_limit_apply'];
						}
						
						/*  get coupon details 		*/			
						
						/* coupon_amt  */
						//$this->input->post("coup_id")=0;
						$coup_id=0;
						if(!empty($this->input->post("coup_id")))
						{
						    $coup_id=$this->input->post("coup_id");
                            $iscouponapply=0;
						}
						$coupon_amt=$this->db->query("SELECT * FROM coupons where valid_to>='".date('d/m/Y')."' AND  id=".$coup_id);		 
						$coup_details=$coupon_amt->row();
						
						if($coupon_amt->result())
						{
                        $result=$coupon_amt->row();
                         
                        $cp_count = $this->db->query("SELECT count(coupons_id) as coupons_count FROM sale where user_id='".$this->input->post("user_id")."' AND coupons_id='$result->id'");
                        $cp_count1=$cp_count->row();
                    
                        if($result->max_count<=$cp_count1->coupons_count)
                        {
                            $coup_details=array();
                            $msg="You already used this coupon";
                        }
                        }
						
						
						foreach ($q->result_array() as $row)
						{		
						        $product_list=array();
						        //print_r($row);
						        $t_p=0;
								if(!empty($row['deal_price']))
								{
								    $t_p=$row['deal_price']*$row['qty'];        
								}
								elseif($unlock_subscrption_price==1)
								{
								    $t_p=$row['subscription_price']*$row['qty'];
								}else{
								    $t_p=$row['surfcity_price']*$row['qty'];        
								}
								
								$product_list['product_id']=$row['product_id'];
								$product_list['user_id']=$this->input->post("user_id");
								$product_list['product_name']=$row['product_name'];
								$product_list['qty']=$row['qty'];
								$product_list['unit']=$row['unit'];
								$product_list['price']=$t_p;
								//print_r($product_list);
								$this->db->insert("temp_cart_sale",$product_list);
								$total_product_amt=$total_product_amt+$t_p;
								
								if($unlock_cash_back==1)
								{
								    $cashback=$cashback+$row['cashback'];								    
								}
								
						}	
						
						
						/*  FREE DELIVERY   */
						if($free_delivery==1)
						{
						    if($free_delivery_max_amt<=$total_product_amt)
						    {
						        $delivery_charge=0;    
						    }
						}
						// coupons discount_type=0 means amt and  1 means %
						if(!empty($coup_details))
                        {
                            //print_r($coup_details);
                            //echo $coup_details->min_limit;
                            //echo "\n";
                            //echo $coup_details->max_limit;
                            //echo "\n";
                            if($coup_details->min_limit<=$total_product_amt)
                            {
                            
                                if($coup_details->free_delivery==1)
                                {
                                    $delivery_charge=0; 
                                    $iscouponapply=1;
                                }
                                if($coup_details->discount_type==0)
                                {
                                    $coupon_price=$coup_details->discount_value;
                                    $cashback=$cashback+$coup_details->cashback;
                                    $iscouponapply=1;
                                }
                                
                                if($coup_details->discount_type==1 && ( $coup_details->min_limit <= $total_product_amt && $total_product_amt <= $coup_details->max_limit ))
                                {
                                    if(0< $coup_details->discount_value)
                                    {
                                        $coupon_price=($total_product_amt*$coup_details->discount_value)/100;    
                                    }
                                    if(0<$coup_details->cashback && isset($coup_details->cashback))
                                    {
                                    $coupon_ck=($total_product_amt*$coup_details->cashback)/100;
                                    $cashback=$cashback+$coupon_ck;    
                                    }
                                    $iscouponapply=1;
                                    
                                }else{
                                    if($coup_details->discount_type==1)
                                    {
                                    if(0< $coup_details->discount_value && isset($coup_details->discount_value))
                                    {
                                        $coupon_price=($coup_details->max_limit*$coup_details->discount_value)/100;    
                                    }
                                    if(0<$coup_details->cashback && isset($coup_details->cashback)){
                                    $coupon_ck=($coup_details->max_limit*$coup_details->cashback)/100;
                                    $cashback=$cashback+$coupon_ck;    
                                    }
                                    $iscouponapply=1;
                                    }
                                }
                            }
                        }
                        
						$total_amt=$total_product_amt+$delivery_charge;
						$total_amt=$total_amt-$coupon_price;
						$temp=0.0;
						if($this->input->post("wallet_amount")<$total_amt)
						{
						    $temp=$this->input->post("wallet_amount");    
						}
						
						$total_amt=$total_amt-$temp;
						$data["responce"] = true;     
						$data["deal_product_id"]=$deal_product_id->result();
					    $data['data'] = $q->result();		
						$data['subscribe_data']=$subscriptiondetails1->result();
						$data['delivery_charge']=$delivery_charge;
						$data['total_product_amt']=$total_product_amt;
						if(0<$total_amt)
						{
						    $total_amt=$total_amt;
						}else{
						    $total_amt=0;    
						}
								
						$data['coupon_amt']=$coupon_price;
						$data['wallet_amt']=number_format($temp,1);
						$data['total_amt']=$total_amt;
						$data['cashback']=$cashback;
						$data['net_total_amt']=$total_amt;
						$data['message']=$msg;
						$data['iscouponapply']=$iscouponapply;
				}		
				
				echo json_encode($data);  	
}
public function get_cart_list_dev()
{
       	    $data = array(); 
            $_POST = $_REQUEST; 
           // print_r($_POST);exit();
            $sub=0;     
                $this->load->library('form_validation');				
                /* add registers table validation */
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
				$this->form_validation->set_rules('wallet_amount', 'Wallet amt', 'trim');
				$this->form_validation->set_rules('coup_id', 'Coupon ID', 'trim');
				$this->form_validation->set_rules('subscription_id', 'subscription ID', 'trim');
				
				if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}
        		else
                {
                        $this->db->query("delete from temp_cart_sale where user_id =".$this->input->post("user_id"));
						/*prodcut total 3 type*/
						$coupon_price=0;
						$total_product_amt=0;
						$total_amt=0;
						$subscribe_amt=0;						
						$discount_type=0;  //$discount_type=0 means amt and  1 means %
						$discount_value=0;
						$final_amount=0;		
						$sub=0;
						$cashback=0;
						$GST=0;
						$delivery_charge=0;
						$iscouponapply='';		
						
						/*	get delivery charge 	*/
						$dc=$this->db->query("Select delivery_charges from global_setting order by globe_setting_id DESC limit 1");
						$dc1=$dc->row_array();
						if(isset($dc1))
						{
						    $delivery_charge=$dc1['delivery_charges'];    
						}
						
						
						/*	get deal of product by send as  product_id and max_qty	*/
						$deal_product_id=$this->db->query("SELECT deal_product.product_id,deal_product.max_qty FROM add_cart_list INNER JOIN deal_product ON deal_product.product_id=add_cart_list.product_id  AND (NOW() BETWEEN concat(start_date,' ',start_time) AND concat(end_date,' ',end_time)) AND deal_product.deal_unit_value=add_cart_list.unit_value AND deal_product.deal_unit=add_cart_list.unit WHERE user_id=".$this->input->post("user_id")); 											
						
						//$q = $this->db->query("select products.*,add_cart_list.* ,deal_price from (add_cart_list INNER JOIN products on products.product_id=add_cart_list.product_id) LEFT JOIN deal_product ON add_cart_list.product_id=deal_product.product_id AND (NOW() BETWEEN concat(deal_product.start_date,' ',deal_product.start_time) AND concat(deal_product.end_date,' ',deal_product.end_time)) where user_id=".$this->input->post("user_id")); 	
						
						/*	get cart_list also get product details and deal_product_price if deal of product not present return deal_price as null or blank*/									
						$q=$this->db->query("SELECT add_cart_list.cart_id, add_cart_list.user_id ,add_cart_list.qty, add_cart_list.subscription_id, 
						add_cart_list.unit as cart_unit,add_cart_list.unit_value as cart_unit_value,products.* ,deal_product.deal_price,deal_product.deal_unit,
						deal_product.deal_unit_value FROM `add_cart_list` INNER JOIN products ON add_cart_list.product_id=products.product_id LEFT JOIN deal_product ON deal_product.product_id=add_cart_list.product_id AND (NOW() BETWEEN concat(deal_product.start_date,' ',deal_product.start_time) AND concat(deal_product.end_date,' ',deal_product.end_time)) AND deal_product.deal_unit=add_cart_list.unit AND deal_product.deal_unit_value=add_cart_list.unit_value where add_cart_list.user_id=".$this->input->post("user_id"));
						
						/*----------Set subscription plan------*/
						$free_delivery=0;
						$msg='';
						$unlock_subscrption_price=0;
						$unlock_cash_back=0;
						$free_delivery_max_amt=0;
						/*-------------------*/
						$subscriptiondetails1=$this->db->query("SELECT * FROM subscribe_plan INNER JOIN subscription_plan ON subscribe_plan.purchase=1 AND subscription_plan.subscription_id=subscribe_plan.subscription_id AND NOW() <= subscribe_plan.subscription_end_date WHERE subscribe_plan.user_id=".$this->input->post("user_id"));
						$sb1=$subscriptiondetails1->row_array();
						
						if(!empty($sb1))
						{
						    $unlock_subscrption_price=$sb1['subscription_details1'];
						    $free_delivery=$sb1['subscription_details2'];
						    $unlock_cash_back=$sb1['subscription_details3'];
						    $free_delivery_max_amt=$sb1['max_limit_apply'];
						}
						
						/*  get coupon details 		*/			
						
						/* coupon_amt  */
						//$this->input->post("coup_id")=0;
						$coup_id=0;
						if(!empty($this->input->post("coup_id")))
						{
						    $coup_id=$this->input->post("coup_id");
						    $iscouponapply=0;		
						}
						$coupon_amt=$this->db->query("SELECT * FROM coupons where valid_to>='".date('d/m/Y')."' AND  id=".$coup_id);		 
						$coup_details=$coupon_amt->row();
						
						if($coupon_amt->result())
						{
                        $result=$coupon_amt->row();
                         
                         $cp_count = $this->db->query("SELECT count(coupons_id) as coupons_count FROM sale where user_id='".$this->input->post("user_id")."' AND coupons_id='$result->id'");
                        $cp_count1=$cp_count->row();
                    
                        if($result->max_count<=$cp_count1->coupons_count)
                        {
                            $coup_details=array();
                            $msg="You already used this coupon";
                        }
                        }
						
						//echo "<pre>";print_r($q->result_array());exit();
						$productarray=$q->result_array();
						foreach ($productarray as $key => $row)
						{		
						        $product_list=array();
						        $t_p=0;
						        $temp_price=0;
						        $temp_s_price=0;
						        $temp_sb_price=0;
						        $productarray[$key]['isdealofproduct']=false;
								if(!empty($row['deal_price']))
								{
								    $t_p=$row['deal_price']*$row['qty'];   
								    $productarray[$key]['isdealofproduct']=true;    
								    
								}
								elseif($unlock_subscrption_price==1)
								{
								    if($row['unit']==$row['cart_unit'] && $row['unit_value']==$row['cart_unit_value'])
								    {
								    $t_p=$row['subscription_price']*$row['qty'];    
								    
								    $temp_price=$row['price'];
						            $temp_s_price=$row['surfcity_price'];
						            $temp_sb_price=$row['subscription_price'];
								    
								    }elseif($row['unit1']==$row['cart_unit'] && $row['unit_value1']==$row['cart_unit_value'])
								    {
								        $t_p=$row['subscription_price1']*$row['qty'];    
								        
								        $temp_price=$row['price1'];
						                $temp_s_price=$row['surfcity_price1'];
						                $temp_sb_price=$row['subscription_price1'];
								    
								    }else{
								    $t_p=$row['subscription_price2']*$row['qty'];  
								        $temp_price=$row['price2'];
						                $temp_s_price=$row['surfcity_price2'];
						                $temp_sb_price=$row['subscription_price2'];
								    }
						    
								}else{
								    if($row['unit']==$row['cart_unit'] && $row['unit_value']==$row['cart_unit_value']){
								        $t_p=$row['surfcity_price']*$row['qty'];
								        
								        $temp_price=$row['price'];
						                $temp_s_price=$row['surfcity_price'];
						                $temp_sb_price=$row['subscription_price'];
								        
								    }
								    elseif($row['unit1']==$row['cart_unit'] && $row['unit_value1']==$row['cart_unit_value']){
								    $t_p=$row['surfcity_price1']*$row['qty'];       
								    
								        $temp_price=$row['price1'];
						                $temp_s_price=$row['surfcity_price1'];
						                $temp_sb_price=$row['subscription_price1'];
						                
						            }else{
						                
								    $t_p=$row['surfcity_price2']*$row['qty'];        
								        
								        $temp_price=$row['price2'];
						                $temp_s_price=$row['surfcity_price2'];
						                $temp_sb_price=$row['subscription_price2'];
						            }
								}
								$temp_gst=0;								
								$product_list['product_id']=$row['product_id'];
								$product_list['user_id']=$this->input->post("user_id");
								$product_list['product_name']=$row['product_name'];
								$product_list['qty']=$row['qty'];
								$product_list['unit']=$row['cart_unit'];
								$product_list['unit_value']=$row['cart_unit_value'];
								$product_list['price']=$t_p;
	  								if(!empty($row['HSN']))
    								{
    								        if($row['HSN']==3004)//12%
    								        {
    								            $temp_gst=($t_p/100)*12;    
    								        }elseif($row['HSN']==3006)//5%
    								        {
    								            $temp_gst=($t_p/100)*5;    
    								        }elseif($row['HSN']==2106)//18%
    								        {
    								            $temp_gst=($t_p/100)*18;    
    								        }else{
    								            
    								        }
    								        $GST=$GST+$temp_gst+$temp_gst;

    								}
    									$product_list['CGST']=$temp_gst;
									$product_list['SGST']=$temp_gst;
	
								$this->db->insert("temp_cart_sale",$product_list);
								$total_product_amt=$total_product_amt+$t_p;
								
								if($unlock_cash_back==1)
								{
								    $cashback=$cashback+$row['cashback'];								    
								}
								        
								$productarray[$key]['price']=$temp_price;
								$productarray[$key]['surfcity_price']= $temp_s_price;
								$productarray[$key]['subscription_price']=$temp_sb_price;
								$productarray[$key]['unit']=$row['cart_unit'];
								$productarray[$key]['unit_value']=$row['cart_unit_value'];
								unset($productarray[$key]['unit_value1']);
								unset($productarray[$key]['price1']);
								unset($productarray[$key]['surfcity_price1']);
								unset($productarray[$key]['subscription_price1']);
								unset($productarray[$key]['unit_value1']);
								unset($productarray[$key]['unit1']);
								unset($productarray[$key]['price2']);
								unset($productarray[$key]['surfcity_price2']);
								unset($productarray[$key]['subscription_price2']);
								unset($productarray[$key]['unit_value2']);
								unset($productarray[$key]['unit2']);
								
						}	
						
						
						/*  FREE DELIVERY   */
						if($free_delivery==1)
						{
						    if($free_delivery_max_amt<=$total_product_amt)
						    {
						        $delivery_charge=0;    
						    }
						}
						// coupons discount_type=0 means amt and  1 means %
						if(!empty($coup_details))
                        {
                            //print_r($coup_details);
                            //echo $coup_details->min_limit;
                            //echo "\n";
                            //echo $coup_details->max_limit;
                            //echo "\n";
                            if($coup_details->min_limit<=$total_product_amt)
                            {
                            
                                if($coup_details->free_delivery==1)
                                {
                                    $delivery_charge=0; 
                                    $iscouponapply=1;		
                                }
                                if($coup_details->discount_type==0)
                                {
                                    $coupon_price=$coup_details->discount_value;
                                    $cashback=$cashback+$coup_details->cashback;
                                    $iscouponapply=1;
                                }
                                
                                if($coup_details->discount_type==1 && ( $coup_details->min_limit <= $total_product_amt && $total_product_amt <= $coup_details->max_limit ))
                                {
                                    if(0<$coup_details->discount_value && isset($coup_details->discount_value))
                                    {
                                    $coupon_price=($total_product_amt*$coup_details->discount_value)/100;    
                                    }
                                    if(0<$coup_details->cashback && isset($coup_details->cashback))
                                    {
                                        $coupon_ck=($total_product_amt*$coup_details->cashback)/100;
                                        $cashback=$cashback+$coupon_ck;    
                                    }
                                    
                                    $iscouponapply=1;
                                    
                                }else{
                                    if($coup_details->discount_type==1)
                                    {
                                        if(0<$coup_details->discount_value && isset($coup_details->discount_value))
                                        {
                                            $coupon_price=($coup_details->max_limit*$coup_details->discount_value)/100;        
                                        }
                                    if(0<$coup_details->cashback && isset($coup_details->cashback))
                                    {
                                        $coupon_ck=($coup_details->max_limit*$coup_details->cashback)/100;
                                        $cashback=$cashback+$coupon_ck;    
                                    }
                                    
                                    $iscouponapply=1;
                                    }
                                }
                            }
                        }
                        
						$total_amt=$total_product_amt+$delivery_charge+$GST;
						$total_amt=$total_amt-$coupon_price;
						$temp=0.0;
						if($this->input->post("wallet_amount")<$total_amt)
						{
						    $temp=$this->input->post("wallet_amount");    
						}
						
						$total_amt=$total_amt-$temp;
						$data["responce"] = true;     
						$data["deal_product_id"]=$deal_product_id->result();
					    $data['data'] = $productarray;	
						$data['subscribe_data']=$subscriptiondetails1->result();
						$data['delivery_charge']=$delivery_charge;
						$data['total_product_amt']=$total_product_amt;		
						$data['coupon_amt']=$coupon_price;
						$data['wallet_amt']=number_format($temp,1);
						if(0<$total_amt)
						{
						    $total_amt=$total_amt;
						}else{
						    
						    $total_amt=0;    
						}
						
						$data['total_amt']=$total_amt;
						$data['cashback']=$cashback;
						$data['net_total_amt']=$total_amt;
						$data['message']=$msg;
						$data['iscouponapply']=$iscouponapply;
				}		
				
				echo json_encode($data);  	
}


public function offer_product()
{
	$data = array(); 
	$q = $this->db->query("select * from products where offer_product=1"); 
					 if ($q->num_rows() > 0)
					{
							$data["responce"] = true;     
							$data['data'] = $q->result();
							echo json_encode($data);  					 
					}
					else
					{
						 $data["responce"] = false;     
					   	 $data['message'] = "list product empty";
						 echo json_encode($data);  					
					}
				
}

/* total calculate deal price */
public function productDetails()
{
	$data = array(); 
    $_POST = $_REQUEST;      
    $productdata= array(); 
    $deal_price=0;
    $this->load->library('form_validation');
                /* add registers table validation */
                $this->form_validation->set_rules('pro_id', 'Product ID', 'trim|required');
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}else
                {                    
					
					 $q = $this->db->query("select * from products where product_id=".$this->input->post("pro_id")); 
					 $productdata=$q->result();
					 
					 $q1=$this->db->query("SELECT deal_price,deal_unit,deal_unit_value,max_qty FROM deal_product INNER JOIN products on deal_product.product_id=products.product_id INNER JOIN categories ON products.category_id=categories.id WHERE  deal_product.product_id='".$this->input->post("pro_id")."' AND (CURRENT_DATE BETWEEN start_date AND end_date)");
					
					$cart_product_count = $this->db->query("select qty from add_cart_list where user_id=".$this->input->post("user_id")); 
					$count=0;
					 if(!empty($cart_product_count->row()))
					 {
					     $rs=$cart_product_count->row();
					     $count=$rs->qty;
					 }
					 
					 foreach($productdata as $key => $value) 
					 {
					     
					     
					    if(!empty($q1->row()))
					    {
					        $deal_price1=$q1->row();
					        
					        $value->deal_price=$deal_price1->deal_price;
					        $value->deal_unit=$deal_price1->deal_unit;
					        $value->deal_unit_value=$deal_price1->deal_unit_value;
					        $value->deal_cart_count=$this->get_cart_count($this->input->post("user_id"),$this->input->post("pro_id"),$deal_price1->deal_unit,$deal_price1->deal_unit_value);
					        $value->isdealofproduct=true;
					    }else{
					        $value->deal_price=0;
					        $value->deal_unit=0;
					        $value->deal_unit_value="";
					        $value->deal_cart_count=0;
					        $value->isdealofproduct=false;
					    }
					 
					    
					        
					            /*
                                $price[0]['price']=$value->price;
					            $price[0]['surfcity_price']=$value->surfcity_price;
					            $price[0]['subscription_price']=$value->subscription_price;
					            $price[0]['unit_value']=$value->unit_value;
					            $price[0]['unit']=$value->unit;*/
					            
					            $value->cart_count=$value->cart_count2=$this->get_cart_count($this->input->post("user_id"),$this->input->post("pro_id"),$value->unit,$value->unit_value);
					            $value->isSingleItem=true;
					            
					            if(0< $value->price1 && 0<$value->surfcity_price1 && 0< $value->subscription_price1){
    					           /*
    					            $price[1]['price']=$value->price1;
    					            $price[1]['surfcity_price']=$value->surfcity_price1;
    					            $price[1]['subscription_price']=$value->subscription_price1;
    					            $price[1]['unit_value']=$value->unit_value1;
    					            $price[1]['unit']=$value->unit1;
    					            unset($value->price1,$value->surfcity_price1,$value->subscription_price1,$value->unit1,$value->unit_value1);
    					            */
    					            
    					            $value->cart_count1=$this->get_cart_count($this->input->post("user_id"),$this->input->post("pro_id"),$value->unit1,$value->unit_value1);
    					            $value->isSingleItem=false;
    					            
					            }
					            if(0< $value->price2 && 0<$value->surfcity_price2 && 0< $value->subscription_price2)
					            {
					                
    					            /*$price[2]['price']=$value->price2;
    					            $price[2]['surfcity_price']=$value->surfcity_price2;
    					            $price[2]['subscription_price']=$value->subscription_price2;
    					            $price[2]['unit_value']=$value->unit_value2;
    					            $price[2]['unit']=$value->unit2;   */
    					            $value->cart_count2=$this->get_cart_count($this->input->post("user_id"),$this->input->post("pro_id"),$value->unit2,$value->unit_value2);
    					            
    				
    					            //unset($value->price2,$value->surfcity_price2,$value->subscription_price2,$value->unit2,$value->unit_value2);
    					            $value->isSingleItem=false;
					            }
					            
					 }
					 
					 if ($q->num_rows() > 0)
					{
							$data["responce"] = true;     
							$data['data'] = $productdata;
							$data['cart_count']=$count;
							echo json_encode($data);  					 
					}
					else
					{
						 $data["responce"] = false;     
					   	 $data['message'] = "list product empty";
						 echo json_encode($data);  					
					}
						
                 }                             
    
}
function get_cart_count($user_id,$product_id,$unit,$unit_value)
{
    
    	$cart_product_count = $this->db->query("select qty from add_cart_list where user_id=$user_id AND product_id=$product_id AND unit='$unit' AND unit_value='$unit_value'"); 
    	//echo $this->db->last_query();
    	$cart_product_count1=$cart_product_count->row();
    	//print_r($cart_product_count1);exit();
    	if($cart_product_count->num_rows()==1)
    	{
    	    return $cart_product_count1->qty;
    	}else{
    	    return 0;
    	}
    	
}
public function productDetails_test()
{
	$data = array(); 
    $_POST = $_REQUEST;      
    $productdata= array(); 
    $deal_price=0;
    $this->load->library('form_validation');
                /* add registers table validation */
                $this->form_validation->set_rules('pro_id', 'Product ID', 'trim|required');
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}else
                {                    
					
					 $q = $this->db->query("select * from products where product_id=".$this->input->post("pro_id")); 
					 $productdata=$q->result();
					 
					 $q1=$this->db->query("SELECT deal_price FROM deal_product INNER JOIN products on deal_product.product_id=products.product_id INNER JOIN categories ON products.category_id=categories.id WHERE  deal_product.product_id='".$this->input->post("pro_id")."' AND (CURRENT_DATE BETWEEN start_date AND end_date)");
					
					$cart_product_count = $this->db->query("select qty from add_cart_list where user_id=".$this->input->post("user_id")); 
					$count=0;
					 if(!empty($cart_product_count->row()))
					 {
					     $rs=$cart_product_count->row();
					     $count=$rs->qty;
					 }
					 if(!empty($q1->row()))
					 {
					    $deal_price1=$q1->row();
					    $deal_price= $deal_price1->deal_price;    
					 }
					 
					 foreach($productdata as $key => $value) 
					 {
					     $value->deal_price=$deal_price;
					     if(0<$deal_price)
					     {
					     $value->price=$deal_price;    
					     }
					     
					        $price=array();
					         
                                $price[0]['price']=$value->price;
					            $price[0]['surfcity_price']=$value->surfcity_price;
					            $price[0]['subscription_price']=$value->subscription_price;
					            $price[0]['unit_value']=$value->unit_value;
					            $price[0]['unit']=$value->unit;
					            $price[0]['cart_count']=0;
					            $value->isSingleItem=true;
					            
					            if(0< $value->price1 && 0<$value->surfcity_price1 && 0< $value->subscription_price1){
    					            $price[1]['price']=$value->price1;
    					            $price[1]['surfcity_price']=$value->surfcity_price1;
    					            $price[1]['subscription_price']=$value->subscription_price1;
    					            $price[1]['unit_value']=$value->unit_value1;
    					            $price[1]['unit']=$value->unit1;
    					            $price[1]['cart_count']=0;
    					            unset($value->price1,$value->surfcity_price1,$value->subscription_price1,$value->unit1,$value->unit_value1);
    					            $value->isSingleItem=false;
    					            
					            }
					            if(0< $value->price2 && 0<$value->surfcity_price2 && 0< $value->subscription_price2)
					            {
    					            $price[2]['price']=$value->price2;
    					            $price[2]['surfcity_price']=$value->surfcity_price2;
    					            $price[2]['subscription_price']=$value->subscription_price2;
    					            $price[2]['unit_value']=$value->unit_value2;
    					            $price[2]['unit']=$value->unit2;   
    					            $price[2]['cart_count']=0;
    					            unset($value->price2,$value->surfcity_price2,$value->subscription_price2,$value->unit2,$value->unit_value2);
    					            $value->isSingleItem=false;
					            }
					            $value->size=$price;
					            
					            $value->deal_price=array();
					 }
					 
					 
					 if ($q->num_rows() > 0)
					{
							$data["responce"] = true;     
							$data['data'] = $productdata;
							$data['cart_count']=$count;
							echo json_encode($data);  					 
					}
					else
					{
						 $data["responce"] = false;     
					   	 $data['message'] = "list product empty";
						 echo json_encode($data);  					
					}
						
                 }                             
    
}

public function categoriesList()
{
	    
		 $q = $this->db->query("select * from categories where status=1 AND parent=0"); 
		 if ($q->num_rows() > 0)
		 {
			$data["responce"] = true;     
            $data['data'] = $q->result();
            echo json_encode($data);  					 
		 }
		 else{
			 $data["responce"] = false;     
            $data['message'] = "list categories empty";
            echo json_encode($data);  					
		 }	             
}

public function ShopcategoriesList()
{
	$data = array(); 
    $_POST = $_REQUEST;      
    $this->load->library('form_validation');
                /* add registers table validation */
                $this->form_validation->set_rules('brand_id', 'brand ID', 'trim|required');                
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}else
                {           

                
					
					 $q = $this->db->query("SELECT categories.id,categories.title,categories.slug,categories.parent,categories.leval, categories.description,categories.image, categories.status,products.shop_id FROM `products` INNER JOIN categories ON products.category_id=categories.id WHERE products.brand_id='".$this->input->post("brand_id")."' group BY categories.title"); 

					
   
					 
					 if ($q->num_rows() > 0)
					{
							$data["responce"] = true;     
							$data['data'] = $q->result();
							echo json_encode($data);  					 
					}
					else
					{
						 $data["responce"] = false;     
					   	 $data['message'] = "list categories empty";
						 echo json_encode($data);  					
					}
						
                 }                             
    
}
/*shop list*/
public function shopList(){
	    
		 $q = $this->db->query("select * from shop_master where status='Active'"); 
		 if ($q->num_rows() > 0)
		 {
			$data["responce"] = true;     
            $data['data'] = $q->result();
            echo json_encode($data);  					 
		 }
		 else{
			 $data["responce"] = false;     
            $data['message'] = "list Shop empty";
            echo json_encode($data);  					
		 }	             
}

/* product list*/

public function selectProductlist()
{
	$data = array(); 
    $_POST = $_REQUEST;      
    $this->load->library('form_validation');
                /* add registers table validation */
                $this->form_validation->set_rules('cat_id', 'Cat ID', 'trim');   
                $this->form_validation->set_rules('shop_id', 'Shop ID', 'trim');
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}else
                {                    
                    if($this->input->post("shop_id")!='')
                    {
                        
                    //$q = $this->db->query("select * from products where shop_id=".$this->input->post("shop_id")); 
                    $q = $this->db->query("select * from products where category_id='".$this->input->post("cat_id")."' AND shop_id='".$this->input->post("shop_id")."'");
					    if ($q->num_rows() > 0)
					    {
					        $products=$q->result();
					        foreach($products as $key => $value) {
					            $price=array();
					            /*
					            $price[0]['price']=$value->price;
					            $price[0]['surfcity_price']=$value->surfcity_price;
					            $price[0]['subscription_price']=$value->subscription_price;
					            $price[0]['unit_value']=$value->unit_value;
					            $price[0]['unit']=$value->unit;
					            */
					            $value->isSingleItem=true;
					            if(0< $value->price1 && 0<$value->surfcity_price1 && 0< $value->subscription_price1){
    					            /*
    					            $price[1]['price']=$value->price1;
    					            $price[1]['surfcity_price']=$value->surfcity_price1;
    					            $price[1]['subscription_price']=$value->subscription_price1;
    					            $price[1]['unit_value']=$value->unit_value1;
    					            $price[1]['unit']=$value->unit1;
    					            unset($value->price1,$value->surfcity_price1,$value->subscription_price1,$value->unit1,$value->unit_value1);
    					            */
    					            $value->isSingleItem=false;
    					            
					            }
					            if(0< $value->price2 && 0<$value->surfcity_price2 && 0< $value->subscription_price2)
					            {
					                /*
    					            $price[2]['price']=$value->price2;
    					            $price[2]['surfcity_price']=$value->surfcity_price2;
    					            $price[2]['subscription_price']=$value->subscription_price2;
    					            $price[2]['unit_value']=$value->unit_value2;
    					            $price[2]['unit']=$value->unit2;   
    					            unset($value->price2,$value->surfcity_price2,$value->subscription_price2,$value->unit2,$value->unit_value2);
    					            */
    					            $value->isSingleItem=false;
					            }
					            
					            
					            //$value->size=$price;
					            
					            
					            
					        }
							$data["responce"] = true;     
							$data['data'] = $products;
						
					    }
					    else
					   {
						 $data["responce"] = false;     
					   	 $data['message'] = "list product empty";
						 
					    }
                    }
                    else
                    {
					     $q = $this->db->query("select * from products where shop_id=0 AND category_id=".$this->input->post("cat_id")); 
					    if ($q->num_rows() > 0)
					    {
					        
					        $products=$q->result();
					        foreach($products as $key => $value) {
					            
					            /*
					            $price=array();
					            $price[0]['price']=$value->price;
					            $price[0]['surfcity_price']=$value->surfcity_price;
					            $price[0]['subscription_price']=$value->subscription_price;
					            $price[0]['unit_value']=$value->unit_value;
					            $price[0]['unit']=$value->unit;
					            */
					            
					            $value->isSingleItem=true;
					            if(0< $value->price1 && 0<$value->surfcity_price1 && 0< $value->subscription_price1){
    					            /*
    					            $price[1]['price']=$value->price1;
    					            $price[1]['surfcity_price']=$value->surfcity_price1;
    					            $price[1]['subscription_price']=$value->subscription_price1;
    					            $price[1]['unit_value']=$value->unit_value1;
    					            $price[1]['unit']=$value->unit1;
    					            unset($value->price1,$value->surfcity_price1,$value->subscription_price1,$value->unit1,$value->unit_value1);
    					            */
    					            $value->isSingleItem=false;
    					            
					            }
					            if(0< $value->price2 && 0<$value->surfcity_price2 && 0< $value->subscription_price2)
					            {
					                /*
    					            $price[2]['price']=$value->price2;
    					            $price[2]['surfcity_price']=$value->surfcity_price2;
    					            $price[2]['subscription_price']=$value->subscription_price2;
    					            $price[2]['unit_value']=$value->unit_value2;
    					            $price[2]['unit']=$value->unit2;   
    					            unset($value->price2,$value->surfcity_price2,$value->subscription_price2,$value->unit2,$value->unit_value2);
    					            */
    					            $value->isSingleItem=false;
					            }
					            
					            
					            //$value->size=$price;
					            
					            
					            
					        }
							$data["responce"] = true;     
							$data['data'] = $products;
						
					    }
					    else
					    {
						 $data["responce"] = false;     
					   	 $data['message'] = "list product empty";
						
					    }
						
                    }   
                     
                     echo json_encode($data);  					
                    
                }                      
                     
}
 public function update_profile_pic()
 {
        $data = array(); 
                $this->load->library('form_validation');
                /* add users table validation */
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                
         		if(isset($_FILES["image"]) && $_FILES["image"]["size"] > 0){
                    $config['upload_path']          = './uploads/profile/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);
    
                    if ( ! $this->upload->do_upload('image'))
                    {
                    $data["responce"] = false;  
        			$data["error"] = 'Error! : '.$this->upload->display_errors();
                           
                    }
                    else
                    {
                        $img_data = $this->upload->data();
                        $this->load->model("common_model");
                        $this->common_model->data_update("registers", array(
                                            "user_image"=>$img_data['file_name']
                                            ),array("user_id"=>$this->input->post("user_id")));
                                            
                        $data["responce"] = true;
                        $data["data"] = $img_data['file_name'];
                    }
                    
               		}else{
               	$data["responce"] = false;  
        			$data["error"] = 'Please choose profile image';               	
               		}                              
                  }                  
           
                     echo json_encode($data);        
 }     

public function change_password(){
            $data = array(); 
                $this->load->library('form_validation');
                /* add users table validation */
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
                $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
                $this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                    $this->load->model("common_model");
                    $q = $this->db->query("select * from registers where user_id = '".$this->input->post("user_id")."' and  user_password = '".md5($this->input->post("current_password"))."' limit 1");
                    $user = $q->row();
                    
                    if(!empty($user)){
                    $this->common_model->data_update("registers", array(
                                            "user_password"=>md5($this->input->post("new_password"))
                                            ),array("user_id"=>$user->user_id));
                    
                    $data["responce"] = true;
                    }else{
                    $data["responce"] = false;  
        			$data["error"] = 'Current password do not match';
                    }
                  }                  
           
                     echo json_encode($data);
}      

public function update_userdata(){
          $data = array(); 
                $this->load->library('form_validation');
                /* add users table validation */
                $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
                $this->form_validation->set_rules('user_fullname', 'Full Name', 'trim|required');
                 $this->form_validation->set_rules('user_mobile', 'Mobile', 'trim|required');
                
                
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                    $insert_array=  array(
                                            "user_fullname"=>$this->input->post("user_fullname"),
                                            "user_phone"=>$this->input->post("user_mobile")
                                            
                                            );
                     
                    $this->load->model("common_model");
                    //$this->db->where(array("user_id",$this->input->post("user_id")));
                    if(isset($_FILES["image"]) && $_FILES["image"]["size"] > 0){
                    $config['upload_path']          = './uploads/profile/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);
                   
                    if ( ! $this->upload->do_upload('image'))
                    {
                    $data["responce"] = false;  
        			$data["error"] = 'Error! : '.$this->upload->display_errors();
                           
                    }
                    else
                    {
                         $img_data = $this->upload->data();
                         $image_name = $img_data['file_name'];
                         $insert_array["user_image"]=$image_name;
                    }
                    
               		}                     
                   $this->common_model->data_update("registers",$insert_array,array("user_id"=>$this->input->post("user_id")));                    
                    $q = $this->db->query("Select * from `registers` where(user_id='".$this->input->post('user_id')."' ) Limit 1");  

                    $row = $q->row();

                    $data["responce"] = true;
                    $data["data"] = array("user_id"=>$row->user_id,"user_fullname"=>$row->user_fullname,"user_email"=>$row->user_email,"user_phone"=>$row->user_phone,"user_image"=>$row->user_image,"pincode"=>$row->pincode,"socity_id"=>$row->socity_id,"house_no"=>$row->house_no) ;
					
                  }                  
           
                     echo json_encode($data);
}           

/* user login json */

public function login(){
            $data = array(); 
            $_POST = $_REQUEST;      
                $this->load->library('form_validation');
                 $this->form_validation->set_rules('user_email', 'Mobile number',  'trim|required');
                 $this->form_validation->set_rules('password', 'Password', 'trim|required');
				 $this->form_validation->set_rules('user_fcm_code','user_fcm_code','trim|required');
               
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] =  strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                   //users.user_email='".$this->input->post('user_email')."' or
 $q = $this->db->query("Select * from registers where(user_email='".$this->input->post('user_email')."' OR user_phone = '".$this->input->post('user_email')."') and user_password='".md5($this->input->post('password'))."' Limit 1");
                    
                    
                    if ($q->num_rows() > 0)
                    {
                        $row = $q->row(); 
                        if($row->status == "0")
                        {
                                $data["responce"] = false;  
   			                  $data["error"] = 'Your account currently inactive.Please Contact Admin';
                            
                        }                       
                        else
                        {
                            $sub=$this->db->query("SELECT subscription_id FROM registers,subscribe_plan WHERE registers.user_id=subscribe_plan.user_id AND registers.user_phone='".$this->input->post('user_email')."'OR registers.user_email='".$this->input->post('user_email')."'");
                        	
                              $data["responce"] = true;  
                              $data["sub_details"]=$sub->result();
					            $data["data"] = array("user_id"=>$row->user_id,"user_fullname"=>$row->user_fullname,
                        "user_email"=>$row->user_email,"user_phone"=>$row->user_phone,"user_image"=>$row->user_image,"wallet"=>$row->wallet,"rewards"=>$row->rewards) ;
								$this->db->query("update registers set user_fcm_code='".$this->input->post("user_fcm_code")."' where user_id=".$row->user_id);
                        }
                    }
                    else
                    {
                              $data["responce"] = false;  
   			                  $data["error"] = 'Invalid Username or Passwords';
                    }
                   
                    
                }
           echo json_encode($data);
            
        }

     
public function loginwithgoogle(){
            $data = array(); 
            $_POST = $_REQUEST;      
                $this->load->library('form_validation');
                 $this->form_validation->set_rules('user_email', 'email number',  'trim|required');
                 $this->form_validation->set_rules('user_name', 'Full Name', 'trim|required');
                 $this->form_validation->set_rules('user_mobile', 'Mobile Number', 'trim');
                 $this->form_validation->set_rules('user_email', 'User Email', 'trim|required');
				 $this->form_validation->set_rules('user_fcm_code','user_fcm_code','trim|required');
				 $this->form_validation->set_rules('google_token','google token','trim|required');
               
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] =  strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                   //users.user_email='".$this->input->post('user_email')."' or
                    $q = $this->db->query("Select * from registers where user_email='".$this->input->post('user_email')."' OR google_token='".$this->input->post('google_token')."' Limit 1");
                    if ($q->num_rows() > 0)
                    {
                        $row = $q->row(); 
                        if($row->status == "0")
                        {
                              $data["responce"] = false;  
   			                  $data["error"] = 'Your account currently inactive.Please Contact Admin';
                            
                        }                       
                        else
                        {
                            $sub=$this->db->query("SELECT subscription_id FROM registers,subscribe_plan WHERE registers.user_id=subscribe_plan.user_id AND registers.user_phone='".$this->input->post('user_email')."'OR registers.user_email='".$this->input->post('user_email')."'");
                        	
                                $data["responce"] = true;  
                                $data["sub_details"]=$sub->result();
					            $data["data"] = array("user_id"=>$row->user_id,"user_fullname"=>$row->user_fullname,
                                "user_email"=>$row->user_email,"user_phone"=>$this->input->post("user_mobile"),"user_image"=>$row->user_image,"wallet"=>$row->wallet,"rewards"=>$row->rewards) ;
								$this->db->query("update registers set user_fcm_code='".$this->input->post("user_fcm_code")."' ,user_phone='".$this->input->post("user_mobile")."' where user_id=".$row->user_id);
                        }
                    }
                    else
                    {
                        $new_referral_code = date("ymdhis");
                        $money=$this->db->query("Select * from global_setting order by globe_setting_id DESC limit 1");                                         
                        $ret = $money->row();
                        $newwallet=0;
                        $global_id=$ret->globe_setting_id;
                        
                               $this->db->insert("registers", array("user_phone"=>$this->input->post("user_mobile"),
                                            "user_fullname"=>$this->input->post("user_name"),
                                             "user_email"=>$this->input->post("user_email"),
                                            "referral_code"=>$new_referral_code,
                                             "user_password"=>md5('%^#@&!&'), 
                                            "wallet"=>$newwallet,
                                            "globe_setting_id"=>$global_id,
                                            "user_fcm_code" => $this->input->post("user_fcm_code"),
                                            "status" => 1,
                                            "google_token"=>$this->input->post("google_token"),
                                            ));
                                            
                                $user_id =  $this->db->insert_id();
                                if(!empty($user_id))
                                {
                                $sub=$this->db->query("SELECT subscription_id FROM registers,subscribe_plan WHERE registers.user_id=subscribe_plan.user_id AND registers.user_id='$user_id'");
                        	
                                $data["responce"] = true;  
                                $data["sub_details"]=$sub->result();
					            $data["data"] = array("user_id"=>$user_id,
                    					              "user_fullname"=>$this->input->post("user_fullname"),
                                                      "user_email"=>$this->input->post("user_email"),
                                                      "user_phone"=>$this->input->post("user_phone"),
                                                      "user_image"=>'',
                                                      "wallet"=>$newwallet,
                                                      "rewards"=>''
                                                    ) ;
                                }else
                                {
                                    $data["responce"] = false;  
                                    $data["error"] = 'Invalid ';      
                                }
                                
                              
                    }
                   
                    
                }
           echo json_encode($data);
            
        }
public function loginwithfacebook(){
            $data = array(); 
            $_POST = $_REQUEST;      
                $this->load->library('form_validation');
                 $this->form_validation->set_rules('user_email', 'email number',  'trim|required');
                 $this->form_validation->set_rules('user_name', 'Full Name', 'trim|required');
                 $this->form_validation->set_rules('user_mobile', 'Mobile Number', 'trim');
                 $this->form_validation->set_rules('user_email', 'User Email', 'trim|required');
				 $this->form_validation->set_rules('user_fcm_code','user_fcm_code','trim|required');
				 $this->form_validation->set_rules('facebook_token','google token','trim|required');
               
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] =  strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                   //users.user_email='".$this->input->post('user_email')."' or
                    $q = $this->db->query("Select * from registers where user_email='".$this->input->post('user_email')."' OR facebook_token='".$this->input->post('facebook_token')."' Limit 1");
                    if ($q->num_rows() > 0)
                    {
                        $row = $q->row(); 
                        if($row->status == "0")
                        {
                              $data["responce"] = false;  
   			                  $data["error"] = 'Your account currently inactive.Please Contact Admin';
                            
                        }                       
                        else
                        {
                            $sub=$this->db->query("SELECT subscription_id FROM registers,subscribe_plan WHERE registers.user_id=subscribe_plan.user_id AND registers.user_phone='".$this->input->post('user_email')."'OR registers.user_email='".$this->input->post('user_email')."'");
                        	
                                $data["responce"] = true;  
                                $data["sub_details"]=$sub->result();
					            $data["data"] = array("user_id"=>$row->user_id,"user_fullname"=>$row->user_fullname,
                                "user_email"=>$row->user_email,"user_phone"=>$this->input->post("user_mobile"),"user_image"=>$row->user_image,"wallet"=>$row->wallet,"rewards"=>$row->rewards) ;
								$this->db->query("update registers set last_logged_in='".date("y:m:d h:i:s")."',user_fcm_code='".$this->input->post("user_fcm_code")."' ,user_phone='".$this->input->post("user_mobile")."' where user_id=".$row->user_id);
                        }
                    }
                    else
                    {
                        $new_referral_code = date("ymdhis");
                        $money=$this->db->query("Select * from global_setting order by globe_setting_id DESC limit 1");                                         
                        $ret = $money->row();
                        $newwallet=0;
                        $global_id=$ret->globe_setting_id;
                        
                               $this->db->insert("registers", array("user_phone"=>$this->input->post("user_mobile"),
                                            "user_fullname"=>$this->input->post("user_name"),
                                             "user_email"=>$this->input->post("user_email"),
                                            "referral_code"=>$new_referral_code,
                                             "user_password"=>md5('%^#@&!&'), 
                                            "wallet"=>$newwallet,
                                            "globe_setting_id"=>$global_id,
                                            "user_fcm_code" => $this->input->post("user_fcm_code"),
                                            "status" => 1,
                                            "facebook_token"=>$this->input->post("facebook_token"),
                                            ));
                                            
                                $user_id =  $this->db->insert_id();
                                if(!empty($user_id))
                                {
                                $sub=$this->db->query("SELECT subscription_id FROM registers,subscribe_plan WHERE registers.user_id=subscribe_plan.user_id AND registers.user_id='$user_id'");
                        	
                                $data["responce"] = true;  
                                $data["sub_details"]=$sub->result();
					            $data["data"] = array("user_id"=>$user_id,
                    					              "user_fullname"=>$this->input->post("user_fullname"),
                                                      "user_email"=>$this->input->post("user_email"),
                                                      "user_phone"=>$this->input->post("user_phone"),
                                                      "user_image"=>'',
                                                      "wallet"=>$newwallet,
                                                      "rewards"=>''
                                                    ) ;
                                }else
                                {
                                    $data["responce"] = false;  
                                    $data["error"] = 'Invalid ';      
                                }
                                
                              
                    }
                   
                    
                }
           echo json_encode($data);
            
        }
function city()
{
                     $q = $this->db->query("SELECT * FROM `city`");
                     $city["city"] = $q->result();
                     echo json_encode($city);
} 
function store()
{
         $data = array(); 
            $_POST = $_REQUEST;          
            $getdata =$this->input->post('city_id');
            if($getdata!='')  {      
 $q = $this->db->query("Select user_fullname ,user_id FROM `users` where (user_city='".$this->input->post('city_id')."')");
  $data["data"] = $q->result();                  
  echo json_encode($data);
               }
               else
               {
              $data["data"] ="Error";                 
  echo json_encode($data);  
               }
}

function get_products()
{
                 $this->load->model("product_model");
                $cat_id = "";
                if($this->input->post("cat_id")){
                    $cat_id = $this->input->post("cat_id");
                }
              $search= $this->input->post("search");
                
                $data["responce"] = true;  
                $datas = $this->product_model->get_products(false,$cat_id,$search,$this->input->post("page"));
				//print_r( $datas);exit();
                foreach ($datas as  $product) {
					$present = date('m/d/Y h:i:s a', time());
					  $date1 = $product->start_date." ".$product->start_time;
					  $date2 = $product->end_date." ".$product->end_time;

					 if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
					 {
						
					   if(empty($product->deal_price))   ///Runing
					   {
						   $price= $product->price;
					   }else{
							 $price= $product->deal_price;
					   }
					
					 }else{
					  $price= $product->price;//expired
					 } 
							
                  $data['data'][] = array(
                  'product_id' => $product->product_id,
                  'product_name'=> $product->product_name,
                  'category_id'=> $product->category_id,
                  'product_description'=>$product->product_description,
                  'deal_price'=>'',
                  'start_date'=>"",
                  'start_time'=>"",
                  'end_date'=>"",
                  'end_time'=>"",
                  'price' =>$price,
                  'product_image'=>$product->product_image,
                  'status' => '0',
                  'in_stock' =>$product->in_stock,
                  'unit_value'=>$product->unit_value,
                  'unit'=>$product->unit,
                  'increament'=>$product->increament,
                  'rewards'=>$product->rewards,
                  'stock'=>$product->stock,
                  'title'=>$product->title
                 );
			}




                echo json_encode($data);
}       
        
        function get_products_suggestion(){
             $this->load->model("product_model");
                $cat_id = "";
                if($this->input->post("cat_id"))
                {
                    $cat_id = $this->input->post("cat_id");
                }
                $search= $this->input->post("search");
                
                //$data["responce"] = true;  
                $data["data"] = $this->product_model->get_products_suggestion(false,$cat_id,$search,$this->input->post("page"));
                echo json_encode($data);

        }
	function get_time_slot(){ 
            
            $this->load->library('form_validation');
                $this->form_validation->set_rules('date', 'date',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                    
					$date = date("Y-m-d",strtotime($this->input->post("date")));                    
                    $time = date("H:i:s");                    
                    $this->load->model("time_model");
                    $time_slot = $this->time_model->get_time_slot();
                    $cloasing_hours =  $this->time_model->get_closing_hours($date);
                    
                    
                    $begin = new DateTime($time_slot->opening_time);
                    $end   = new DateTime($time_slot->closing_time);
                    
                    $interval = DateInterval::createFromDateString($time_slot->time_slot.' min');
                    
                    $times    = new DatePeriod($begin, $interval, $end);
                    $time_array = array();
                    foreach ($times as $time) {
                        if(!empty($cloasing_hours)){
                            foreach($cloasing_hours as $c_hr){
                            if($date == date("Y-m-d")){
                            	if(strtotime($time->format('h:i A')) > strtotime(date("h:i A")) &&  strtotime($time->format('h:i A')) > strtotime($c_hr->from_time) && strtotime($time->format('h:i A')) <  strtotime($c_hr->to_time) ){
                                    
                                }else{
                                    $time_array[] =  $time->format('h:i A'). ' - '. 
                                    $time->add($interval)->format('h:i A')
                                     ;
                                }
                            
                            }else{
                                if(strtotime($time->format('h:i A')) > strtotime($c_hr->from_time) && strtotime($time->format('h:i A')) <  strtotime($c_hr->to_time) ){
                                    
                                }else{
                                    $time_array[] =  $time->format('h:i A'). ' - '. 
                                    $time->add($interval)->format('h:i A')
                                     ;
                                }
                            }
                            
                            }
                        }else{
                        	if(strtotime($date) == strtotime(date("Y-m-d"))){
                        		if(strtotime($time->format('h:i A')) > strtotime(date("h:i A"))){
                        		$time_array[] =  $time->format('h:i A'). ' - '. 
                                	$time->add($interval)->format('h:i A');
                        		} 
                        	}else{
                            		$time_array[] =  $time->format('h:i A'). ' - '. 
                                	$time->add($interval)->format('h:i A')
                                 ;
                                 }
                        }
                    }
                    $data["responce"] = true;
                    $data["times"] = $time_array;
                }
                echo json_encode($data);
            
        } 
         
        function text_for_send_order(){
            echo json_encode(array("data"=>"<p>Our delivery boy will come withing your choosen time and will deliver your order. \n 
            </p>"));
        }

function send_order_dev()
{	
			      $data = array(); 
                  $_POST = $_REQUEST;    
                  $this->load->library('form_validation');
                  $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                  $this->form_validation->set_rules('date', 'Date',  'trim|required');
                  $this->form_validation->set_rules('time', 'Time',  'trim|required');
                  $this->form_validation->set_rules('payment_method', 'payment_method',  'trim|required');
                  $this->form_validation->set_rules('location', 'Location',  'trim|required');
				  $this->form_validation->set_rules('cou_amt', 'cou_amt',  'trim');
				  $this->form_validation->set_rules('wallet_amt', 'wallet_amt',  'trim');
				  $this->form_validation->set_rules('total_amt', 'total_amt',  'trim|required');
				  $this->form_validation->set_rules('net_total_amt', 'Net Total amt',  'trim|required');
				  $this->form_validation->set_rules('coupons_id', 'coupons ID',  'trim');
				  $this->form_validation->set_rules('cashback', 'cashback amount',  'trim');
				  $this->form_validation->set_rules('total_product_amt', 'total product amount',  'trim');
				  $this->form_validation->set_rules('delivery_charge', 'delivery charge',  'trim|required');
				  $this->form_validation->set_rules('address', 'address',  'trim|required');
				  $this->form_validation->set_rules('mobile', 'mobile',  'trim|required');
				 $this->form_validation->set_rules('zip', 'zip',  'trim|required'); 
				  
				  
				  
				  
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                    $uid=$this->input->post("user_id");                
                    $checkuser=$this->db->query("select * from registers WHERE user_id=".$uid);
                    $checkuser1=$checkuser->row();
                    if(empty($checkuser1))
                    {
                        $data["responce"] = false;  
        			    $data["error"] = 'Your account currently deleted.Please contact to admin';
        			    echo json_encode($data);
        			    exit();
                        
                    }elseif($checkuser1->status == "0")
                    {
                                $data["responce"] = false;  
   			                    $data["error"] = 'Your account currently inactive.Please contact to admin';
   			                    echo json_encode($data);
   			                    exit();
                            
                    }
                    
                   if($this->input->post("wallet_amt")>0)
                   {
                   	$this->db->insert("wallet_history", array("user_id"=>$this->input->post("user_id"),
                                            "amount"=>$this->input->post("wallet_amt"),
                                             "Status"=>0,											
                                            ));
					$this->db->query("UPDATE registers SET wallet=wallet-'".$this->input->post("wallet_amt")."' WHERE  user_id= '".$this->input->post("user_id")."' ");
                   }
                   
					$ld = $this->db->query("select user_location.*, socity.* from user_location
                    inner join socity on socity.socity_id = user_location.socity_id
                     where user_location.location_id = '".$this->input->post("location")."' limit 1");
                    $location = $ld->row(); 
                    
                    $store_id= $this->input->post("store_id");
                    $payment_method= $this->input->post("payment_method");
                    $date = date("Y-m-d", strtotime($this->input->post("date")));
                    
                    $user_id = $this->input->post("user_id");
					
                    $insert_array = array("user_id"=>$user_id,
                    "on_date"=>$date,
                    //"delivery_time_from"=>$this->input->post("time"),
                    "delivery_time_to"=>$this->input->post("time"),
                   "delivery_address"=>$this->input->post("address"),
                    "socity_id" => 0, 
                    "location_id" => 0, 
                    "coupons_id"=>$this->input->post("coupons_id"),
			"coupon_amount"=>$this->input->post("cou_amt"),
			"wallet_amount"=>$this->input->post("wallet_amt"),
			"cash_back"=>$this->input->post("cashback"),
			"total_amount"=>$this->input->post("total_product_amt"),
			"total_net_amt"=>$this->input->post("net_total_amt"),
	               	"delivery_charge"=>$this->input->post("delivery_charge"),
                    "payment_method" => $payment_method,
                    "mobile"=>$this->input->post("mobile"),
                    "new_store_id" => $store_id,
		    "zip"=>$this->input->post("zip"),
                    );
					
                    $this->load->model("common_model");
                    $id = $this->common_model->data_insert("sale",$insert_array);
                    
					$total_amt=0;
					$total_items=0;
					$q = $this->db->query("select * from temp_cart_sale where user_id=".$this->input->post("user_id"));
					foreach ($q->result_array() as $row)
					{			
					            $qty=$row['qty'];
					            $product_id=$row['product_id'];
	                           $total_items=$total_items+1;				    
								 $array = array("product_id"=>$row['product_id'],
								"product_name"=>$row['product_name'],
								"qty"=>$row['qty'],
								"unit"=>$row['unit'],
								"unit_value"=>$row['unit_value'],
								"price"=>$row['price'],
								"sale_id"=>$id,
								"CGST"=>$row['CGST'],
								"SGST"=>$row['SGST'],
								
                        );
                                $this->db->query("update purchase SET  qty=qty-'$qty' where product_id ='$product_id'");
								$this->common_model->data_insert("sale_items",$array);	
					}
					$this->common_model->data_update("sale",array("total_items"=>$total_items),array("sale_id"=>$id)); 
					
                    $total_price = $this->input->post("net_total_amt");//$total_price + 0;//$location->delivery_charge;
                    //$this->db->query("Update sale set total_amount = '".$total_price."', total_kg = '".$total_kg."', total_items = '".count($total_items)."', total_rewards = '".$total_rewards."' where sale_id = '".$id."'");
					
                    $this->db->query("DELETE FROM temp_cart_sale WHERE user_id=".$_REQUEST["user_id"]);
                    
                    $data["responce"] = true;  
					$data["message"]="Your order No ".$id." is sent successfully";
                    $data['order_id'] = $id;
                    header('Content-type: text/html');
                    date_default_timezone_set('Asia/Kolkata');
                    
                    $order_id = $id;
                    $this->load->model('Product_model');
                    $data1['order'] = $this->Product_model->get_sale_order_by_id($order_id);
                    $data1['order_items'] = $this->Product_model->get_sale_order_items($order_id);
                    
                    $header = "From:onlineddapp@gmail.com \r\n";
                    $header .= "MIME-Version: 1.0\r\n";
                    $header .= "Content-type: text/html\r\n";
                    $subject = "Your order No #".$id." has been sent successfully.";
                    $body = $this->load->view('api/order_template', $data1, true);
                    
                    $request = $this->db->query("Select * from registers where user_id = '".$user_id."' limit 1");
                    $user = $request->row();
                    mail ($user->user_email,$subject,$body,$header);
                    
                }
				$this->db->query("DELETE FROM add_cart_list WHERE user_id=".$_REQUEST["user_id"]);
                header('Content-type: text/json');
                date_default_timezone_set('Asia/Kolkata');
                echo json_encode($data);
 } 
        
function send_order_dev_testing()
{	
			      $data = array(); 
                  $_POST = $_REQUEST;    
                  $this->load->library('form_validation');
                  $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                  $this->form_validation->set_rules('date', 'Date',  'trim|required');
                  $this->form_validation->set_rules('time', 'Time',  'trim|required');
                  $this->form_validation->set_rules('payment_method', 'payment_method',  'trim|required');
                  $this->form_validation->set_rules('location', 'Location',  'trim|required');
				  $this->form_validation->set_rules('cou_amt', 'cou_amt',  'trim');
				  $this->form_validation->set_rules('wallet_amt', 'wallet_amt',  'trim');
				  $this->form_validation->set_rules('total_amt', 'total_amt',  'trim|required');
				  $this->form_validation->set_rules('net_total_amt', 'Net Total amt',  'trim|required');
				  $this->form_validation->set_rules('coupons_id', 'coupons ID',  'trim');
				  $this->form_validation->set_rules('cashback', 'cashback amount',  'trim');
				  $this->form_validation->set_rules('total_product_amt', 'total product amount',  'trim');
				  $this->form_validation->set_rules('delivery_charge', 'delivery charge',  'trim|required');
				  
				  
				  
				  
				  
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                   
                
                   if($this->input->post("wallet_amt")>0)
                   {
                   	$this->db->insert("wallet_history", array("user_id"=>$this->input->post("user_id"),
                                            "amount"=>$this->input->post("wallet_amt"),
                                             "Status"=>0,											
                                            ));
					$this->db->query("UPDATE registers SET wallet=wallet-'".$this->input->post("wallet_amt")."' WHERE  user_id= '".$this->input->post("user_id")."' ");
                   }
					$ld = $this->db->query("select user_location.*, socity.* from user_location
                    inner join socity on socity.socity_id = user_location.socity_id
                     where user_location.location_id = '".$this->input->post("location")."' limit 1");
                    $location = $ld->row(); 
                    //print_r($location);exit();
                    //$ld = $this->db->query("select user_location.* from user_location where user_location.location_id = '".$this->input->post("location")."' limit 1");
                    $location = $ld->row(); 
                    //print_r($location);exit;
                    $store_id= $this->input->post("store_id");
                    $payment_method= $this->input->post("payment_method");
                    $date = date("Y-m-d", strtotime($this->input->post("date")));
                    //$timeslot = explode("-",$this->input->post("timeslot"));
                    
                    //$times = explode('-',$this->input->post("time"));
                   // $fromtime = date("h:i a",strtotime(trim($times[0]))) ;
                    //$totime = date("h:i a",strtotime(trim($times[1])));
					
                    $user_id = $this->input->post("user_id");
					
                    $insert_array = array("user_id"=>$user_id,
                    "on_date"=>$date,
                    //"delivery_time_from"=>$this->input->post("time"),
                    "delivery_time_to"=>$this->input->post("time"),
                   "delivery_address"=>$location->house_no."\n, ".$location->house_no,
                    "socity_id" => $location->socity_id, 
                     //"delivery_charge" => $location->delivery_charge,
                    "location_id" => $location->location_id, 
                    "coupons_id"=>$this->input->post("coupons_id"),
					"coupon_amount"=>$this->input->post("cou_amt"),
					"wallet_amount"=>$this->input->post("wallet_amt"),
					"cash_back"=>$this->input->post("cashback"),
					"total_amount"=>$this->input->post("total_product_amt"),
					"total_net_amt"=>$this->input->post("net_total_amt"),
					"delivery_charge"=>$this->input->post("delivery_charge"),
                    "payment_method" => $payment_method,
                    "new_store_id" => $store_id
                    );
					
                    $this->load->model("common_model");
                    $id = $this->common_model->data_insert("sale",$insert_array);
                    
					$total_amt=0;
					$total_items=0;
					$q = $this->db->query("select * from temp_cart_sale where user_id=".$this->input->post("user_id"));
					foreach ($q->result_array() as $row)
					{			
					            $qty=$row['qty'];
					            $product_id=$row['product_id'];
	                             $total_items=$total_items+1;				    
								 $array = array("product_id"=>$row['product_id'],
								"product_name"=>$row['product_name'],
								"qty"=>$row['qty'],
								"unit"=>$row['unit'],
								"unit_value"=>$row['unit_value'],
								"price"=>$row['price'],
								"sale_id"=>$id,
								
                        );
                                //echo $qty;
                                //echo $product_id;
                                
                                echo $this->db->query("update purchase SET  qty=qty-'$qty' where product_id ='$product_id'");
								$this->common_model->data_insert("sale_items",$array);	
					}
					exit();
					
					$this->common_model->data_update("sale",array("total_items"=>$total_items),array("sale_id"=>$id)); 
					
                    $total_price = $this->input->post("net_total_amt");//$total_price + 0;//$location->delivery_charge;
                    //$this->db->query("Update sale set total_amount = '".$total_price."', total_kg = '".$total_kg."', total_items = '".count($total_items)."', total_rewards = '".$total_rewards."' where sale_id = '".$id."'");
					
                //    $this->db->query("DELETE FROM temp_cart_sale WHERE user_id=".$_REQUEST["user_id"]);
                    
                    $data["responce"] = true;  
					$data["message"]="Your order No ".$id." is send successfully";
                    $data['order_id'] = $id;
                    header('Content-type: text/html');
                    date_default_timezone_set('Asia/Kolkata');
                    
                    $order_id = $id;
                    $this->load->model('Product_model');
                    $data1['order'] = $this->Product_model->get_sale_order_by_id($order_id);
                    $data1['order_items'] = $this->Product_model->get_sale_order_items($order_id);
                    
                    $header = "From:onlineddapp@gmail.com \r\n";
                    $header .= "MIME-Version: 1.0\r\n";
                    $header .= "Content-type: text/html\r\n";
                    $subject = "Your order No #".$id." has been sent successfully.";
                    $body = $this->load->view('api/order_template', $data1, true);
                    
                    $request = $this->db->query("Select * from registers where user_id = '".$user_id."' limit 1");
                    $user = $request->row();
                    mail ($user->user_email,$subject,$body,$header);
                    
                }
				$this->db->query("DELETE FROM add_cart_list WHERE user_id=".$_REQUEST["user_id"]);
                header('Content-type: text/json');
                date_default_timezone_set('Asia/Kolkata');
                echo json_encode($data);
 }  
function send_order()
{	
			$data = array(); 
            $_POST = $_REQUEST;    
			
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                 $this->form_validation->set_rules('date', 'Date',  'trim|required');
                 $this->form_validation->set_rules('time', 'Time',  'trim|required');
                 $this->form_validation->set_rules('payment_method', 'payment_method',  'trim|required');
                  $this->form_validation->set_rules('location', 'Location',  'trim|required');
				  $this->form_validation->set_rules('cou_amt', 'cou_amt',  'trim');
				  $this->form_validation->set_rules('wallet_amt', 'wallet_amt',  'trim');
				  $this->form_validation->set_rules('total_amt', 'total_amt',  'trim|required');
				  $this->form_validation->set_rules('net_total_amt', 'Net Total amt',  'trim|required');
				  $this->form_validation->set_rules('net_total_amt', 'Net Total amt',  'trim|required');
				  //$this->form_validation->set_rules('store_id', 'store ID',  'trim|required');
				  
				  
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                   
                  $datanew=$this->db->query("SELECT * FROM add_cart_list WHERE product_id=0 AND qty=0 AND user_id=".$this->input->post("user_id"));
                   
                  $record=$datanew->row_array();
                  
                   if(!empty($record))
                   {
                       $record['user_id'];
                       
                       $record['subscription_id'];
                       $this->db->query("UPDATE subscribe_plan SET purchase=1 WHERE  user_id= '".$this->input->post("user_id")."' AND subscription_id=".$record['subscription_id']);
                       
                   }
                  
                
                   if($this->input->post("wallet_amt")>0)
                   {
                   	$this->db->insert("wallet_history", array("user_id"=>$this->input->post("user_id"),
                                            "amount"=>$this->input->post("wallet_amt"),
                                             "Status"=>0,											
                                            ));
					$this->db->query("UPDATE registers SET wallet=wallet-'".$this->input->post("wallet_amt")."' WHERE  user_id= '".$this->input->post("user_id")."' ");
                   }
                   $cashback=$this->db->query("SELECT sum(cashback*qty) AS cashback FROM add_cart_list INNER JOIN products ON add_cart_list.product_id=products.product_id WHERE user_id=".$this->input->post("user_id")); 
					$cb=$cashback->row();
					$c_b=$cb->cashback;
					if(empty($c_b))
					{
						$c_b=0;
					}
				
				
					$ld = $this->db->query("select user_location.*, socity.* from user_location
                    inner join socity on socity.socity_id = user_location.socity_id
                     where user_location.location_id = '".$this->input->post("location")."' limit 1");
                    $location = $ld->row(); 
                    
                    //$ld = $this->db->query("select user_location.* from user_location where user_location.location_id = '".$this->input->post("location")."' limit 1");
                    $location = $ld->row(); 
                    //print_r($location);exit;
                    $store_id= $this->input->post("store_id");
                    $payment_method= $this->input->post("payment_method");
                    $date = date("Y-m-d", strtotime($this->input->post("date")));
                    //$timeslot = explode("-",$this->input->post("timeslot"));
                    
                    //$times = explode('-',$this->input->post("time"));
                   // $fromtime = date("h:i a",strtotime(trim($times[0]))) ;
                    //$totime = date("h:i a",strtotime(trim($times[1])));
					
                    $user_id = $this->input->post("user_id");
					
                    $insert_array = array("user_id"=>$user_id,
                    "on_date"=>$date,
                    //"delivery_time_from"=>$this->input->post("time"),
                    "delivery_time_to"=>$this->input->post("time"),
                   "delivery_address"=>$location->house_no."\n, ".$location->house_no,
                    "socity_id" => $location->socity_id, 
                     "delivery_charge" => $location->delivery_charge,
                    "location_id" => $location->location_id, 
                    "coupons_id"=>$this->input->post("coupons_id"),
					"coupon_amount"=>$this->input->post("cou_amt"),
					"wallet_amount"=>$this->input->post("wallet_amt"),
					"cash_back"=>$c_b,
					"total_amount"=>$this->input->post("total_amt"),
					"total_net_amt"=>$this->input->post("net_total_amt"),					
                    "payment_method" => $payment_method,
                   "new_store_id" => $store_id
                    );
					
                    $this->load->model("common_model");
                    $id = $this->common_model->data_insert("sale",$insert_array);
                    
					$total_amt=0;
					$q = $this->db->query("select * from add_cart_list ,products where products.product_id=add_cart_list.product_id AND user_id=".$this->input->post("user_id"));
					foreach ($q->result_array() as $row)
					{			$total_amt=0;					
								if(isset($row['subscription_id']))
								{
									$total_amt=$total_amt+($row['qty']*$row['subscription_price']);
								}
								else
								{
									$total_amt=$total_amt+($row['qty']*$row['surfcity_price']);
								}																								
								 $array = array("product_id"=>$row['product_id'],
								"qty"=>$row['qty'],																
								"sale_id"=>$id,
								"price"=>$total_amt,
								
                        );
								$this->common_model->data_insert("sale_items",$array);	
								
					}
					/*
                    foreach($data_array as $dt)
					{
						/*
						$qty_in_kg = $dt->qty; 
                        if($dt->unit=="gram"){
                            $qty_in_kg =  ($dt->qty * $dt->unit_value) / 1000;     
                        }
                        $total_rewards = $total_rewards + ($dt->qty * $dt->rewards);
                        $total_price = $total_price + ($dt->qty * $dt->price);
                        $total_kg = $total_kg + $qty_in_kg;
                        $total_items[$dt->product_id] = $dt->product_id;    
                        
                        $array = array("product_id"=>$dt->product_id,
                        "qty"=>$dt->qty,
                        "unit"=>$dt->unit,
                        "unit_value"=>$dt->unit_value,
                        "sale_id"=>$id,
                        "price"=>$dt->price,
                        "qty_in_kg"=>$qty_in_kg,
                        "rewards" =>$dt->rewards
                        );
						
						
                        $this->common_model->data_insert("sale_items",$array);					
							
							
                    }
					*/
                    $total_price = $this->input->post("net_total_amt");//$total_price + 0;//$location->delivery_charge;
                    //$this->db->query("Update sale set total_amount = '".$total_price."', total_kg = '".$total_kg."', total_items = '".count($total_items)."', total_rewards = '".$total_rewards."' where sale_id = '".$id."'");
					
                    
                    $data["responce"] = true;  
					
        			/*$data["data"] =  "Your order No #".$id." is send successfully  Our delivery person will delivered order 
                    between ".$this->input->post("time")."  on ".$date." 
                    Please keep ".$total_price." on delivery
                    Thanks for being with Us.";
					*/
					$data["message"]="Your order No ".$id." is send successfully";
                    $data['order_id'] = $id;
                   
                    header('Content-type: text/html');
                    date_default_timezone_set('Asia/Kolkata');
                    
                    $order_id = $id;
                    $this->load->model('Product_model');
                    $data1['order'] = $this->Product_model->get_sale_order_by_id($order_id);
                    $data1['order_items'] = $this->Product_model->get_sale_order_items($order_id);
                    
                    $header = "From:onlineddapp@gmail.com \r\n";
                    $header .= "MIME-Version: 1.0\r\n";
                    $header .= "Content-type: text/html\r\n";
                    $subject = "Your order No #".$id." has been sent successfully.";
                    $body = $this->load->view('api/order_template', $data1, true);
                    
                    $request = $this->db->query("Select * from registers where user_id = '".$user_id."' limit 1");
                    $user = $request->row();
                    mail ($user->user_email,$subject,$body,$header);
                    
                }
				$this->db->query("DELETE FROM add_cart_list WHERE user_id=".$_REQUEST["user_id"]);
                header('Content-type: text/json');
                date_default_timezone_set('Asia/Kolkata');
                echo json_encode($data);
 }   

function send_order1()
{	
			$data = array(); 
            $_POST = $_REQUEST;    
			
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                 $this->form_validation->set_rules('date', 'Date',  'trim|required');
                 $this->form_validation->set_rules('time', 'Time',  'trim|required');
                 $this->form_validation->set_rules('payment_method', 'payment_method',  'trim|required');
                  $this->form_validation->set_rules('location', 'Location',  'trim|required');
				  $this->form_validation->set_rules('cou_amt', 'cou_amt',  'trim');
				  $this->form_validation->set_rules('wallet_amt', 'wallet_amt',  'trim');
				  $this->form_validation->set_rules('total_amt', 'total_amt',  'trim|required');
				  $this->form_validation->set_rules('net_total_amt', 'Net Total amt',  'trim|required');
				  //$this->form_validation->set_rules('store_id', 'store ID',  'trim|required');
				  
				  
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
        		}else
                {
					/*
					 if($this->input->post("wallet_amt") >0)
                   {
                   	$this->db->insert("wallet_history", array("user_id"=>$this->input->post("user_id"),
                                            "amount"=>$this->input->post("wallet_amt"),
                                             "Status"=>0,											
                                            ));
					$this->db->query("UPDATE registers  SET wallet=wallet-'".$this->input->post("wallet_amt")."' WHERE  user_id= '".$this->input->post("user_id")."' ");
							
                   }
				   */
                   $cashback=$this->db->query("SELECT sum(cashback*qty) AS cashback FROM add_cart_list INNER JOIN products ON add_cart_list.product_id=products.product_id WHERE user_id=".$this->input->post("user_id")); 
					$cb=$cashback->row();
					$c_b=$cb->cashback;
					if(empty($c_b))
					{
						$c_b=0;
					}
					$ld = $this->db->query("select user_location.*, socity.* from user_location
                    inner join socity on socity.socity_id = user_location.socity_id
                     where user_location.location_id = '".$this->input->post("location")."' limit 1");
                    $location = $ld->row(); 
                    
                    //$ld = $this->db->query("select user_location.* from user_location where user_location.location_id = '".$this->input->post("location")."' limit 1");
                    $location = $ld->row(); 
                    //print_r($location);exit;
                    $store_id= $this->input->post("store_id");
                    $payment_method= $this->input->post("payment_method");
                    $date = date("Y-m-d", strtotime($this->input->post("date")));
                    //$timeslot = explode("-",$this->input->post("timeslot"));
                    
                    //$times = explode('-',$this->input->post("time"));
                   // $fromtime = date("h:i a",strtotime(trim($times[0]))) ;
                    //$totime = date("h:i a",strtotime(trim($times[1])));
					
                    $user_id = $this->input->post("user_id");
					
                    $insert_array = array("user_id"=>$user_id,
                    "on_date"=>$date,
                    //"delivery_time_from"=>$this->input->post("time"),
                    "delivery_time_to"=>$this->input->post("time"),
                   "delivery_address"=>$location->house_no."\n, ".$location->house_no,
                    "socity_id" => $location->socity_id, 
                     "delivery_charge" => $location->delivery_charge,
                    "location_id" => $location->location_id, 
					"coupon_amount"=>$this->input->post("cou_amt"),
					"wallet_amount"=>$this->input->post("wallet_amt"),
					"cash_back"=>$c_b,
					"total_amount"=>$this->input->post("total_amt"),
					"total_net_amt"=>$this->input->post("net_total_amt"),					
                    "payment_method" => $payment_method,
                   "new_store_id" => $store_id
                    );
					
                    $this->load->model("common_model");
                    $id = $this->common_model->data_insert("sale",$insert_array);
                    /*
                    $data_post = $this->input->post("data");
                    $data_array = json_decode($data_post);
                    $total_rewards = 0;
                    $total_price = 0;
                    $total_kg = 0;
                    $total_items = array();
					*/
					$total_amt=0;
					$q = $this->db->query("select * from add_cart_list ,products where products.product_id=add_cart_list.product_id AND user_id=".$this->input->post("user_id"));
					foreach ($q->result_array() as $row)
					{			$total_amt=0;					
								if(isset($row['subscription_id']))
								{
									$total_amt=$total_amt+($row['qty']*$row['subscription_price']);
								}
								else
								{
									$total_amt=$total_amt+($row['qty']*$row['surfcity_price']);
								}																								
								 $array = array("product_id"=>$row['product_id'],
								"qty"=>$row['qty'],																
								"sale_id"=>$id,
								"price"=>$total_amt,
								
                        );
								$this->common_model->data_insert("sale_items",$array);	
								
					}
					/*
                    foreach($data_array as $dt)
					{
						/*
						$qty_in_kg = $dt->qty; 
                        if($dt->unit=="gram"){
                            $qty_in_kg =  ($dt->qty * $dt->unit_value) / 1000;     
                        }
                        $total_rewards = $total_rewards + ($dt->qty * $dt->rewards);
                        $total_price = $total_price + ($dt->qty * $dt->price);
                        $total_kg = $total_kg + $qty_in_kg;
                        $total_items[$dt->product_id] = $dt->product_id;    
                        
                        $array = array("product_id"=>$dt->product_id,
                        "qty"=>$dt->qty,
                        "unit"=>$dt->unit,
                        "unit_value"=>$dt->unit_value,
                        "sale_id"=>$id,
                        "price"=>$dt->price,
                        "qty_in_kg"=>$qty_in_kg,
                        "rewards" =>$dt->rewards
                        );
						
						
                        $this->common_model->data_insert("sale_items",$array);					
							
							
                    }
					*/
                    $total_price = $this->input->post("net_total_amt");//$total_price + 0;//$location->delivery_charge;
                    //$this->db->query("Update sale set total_amount = '".$total_price."', total_kg = '".$total_kg."', total_items = '".count($total_items)."', total_rewards = '".$total_rewards."' where sale_id = '".$id."'");
					
                    
                    $data["responce"] = true;  
					
        			/*$data["data"] =  "Your order No #".$id." is send successfully  Our delivery person will delivered order 
                    between ".$this->input->post("time")."  on ".$date." 
                    Please keep ".$total_price." on delivery
                    Thanks for being with Us.";
					*/
					$data["message"]="Your order No ".$id." is send successfully";
                    $data['order_id'] = $id;
                   
                    header('Content-type: text/html');
                    date_default_timezone_set('Asia/Kolkata');
                    
                    $order_id = $id;
                    $this->load->model('Product_model');
                    $data1['order'] = $this->Product_model->get_sale_order_by_id($order_id);
                    $data1['order_items'] = $this->Product_model->get_sale_order_items($order_id);
                    
                    $header = "From:onlineddapp@gmail.com \r\n";
                    $header .= "MIME-Version: 1.0\r\n";
                    $header .= "Content-type: text/html\r\n";
                    $subject = "Your order No #".$id." has been sent successfully.";
                    $body = $this->load->view('api/order_template', $data1, true);
                    
                    $request = $this->db->query("Select * from registers where user_id = '".$user_id."' limit 1");
                    $user = $request->row();
                    mail ($user->user_email,$subject,$body,$header);
                    
                }
				$this->db->query("DELETE FROM add_cart_list WHERE user_id=".$_REQUEST["user_id"]);
                header('Content-type: text/json');
                date_default_timezone_set('Asia/Kolkata');
                echo json_encode($data);
 }   
 
/*							end sender 			*/
        function my_orders(){
            $data = array(); 
                $_POST = $_REQUEST;    
    			
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                    $this->load->model("product_model");
                    $data = $this->product_model->get_sale_by_user($this->input->post("user_id"));
                    //print_r($data);exit();
                }
                echo json_encode($data);
        }
        
        function delivered_complete(){
            
                $data = array(); 
                $_POST = $_REQUEST;    
    			
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                    $this->load->model("product_model");
                    $data = $this->product_model->get_sale_by_user2($this->input->post("user_id"),false,false);
                    
                }
                echo json_encode($data);
        }
        
public function order_details()
{
		    $data = array(); 
            $_POST = $_REQUEST;      
                $this->load->library('form_validation');				
				
                /* add registers table validation */
				
                $this->form_validation->set_rules('sale_id', 'Sale ID',  'trim|required');
				if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}else
                {
					$this->load->model("product_model");
                    $data['item'] = $this->product_model->get_sale_order_items_android($this->input->post("sale_id"));				
                    $q1 = $this->db->query("Select delivery_datetime,total_amount,total_net_amt,coupon_amount,wallet_amount,cash_back,delivery_charge,assign_driver from sale where sale_id = '".$this->input->post("sale_id")."'");
                    $result=$q1->row();
                    $result_driver=array();
                    if(!empty($result->assign_driver))
                    {   $path=base_url()."uploads/driver/";
                        $q1 = $this->db->query("SELECT driver_id, on_duty, first_name, last_name, email, phone, username, transport_type, licence_plate, color, concat('$path',profile_photo) as profile_photo, driver_address from driver where driver_id= '$result->assign_driver'");
                        $result_driver=$q1->row();
                    }
                    $data['sale']=$result;
                    $data['sale']->driver=$result_driver;
                    
                    
				}	     
				echo json_encode($data);  					
}

/*
        function order_details(){
            $data = array(); 
				$_POST = $_REQUEST; 
                $this->load->library('form_validation');
                $this->form_validation->set_rules('sale_id', 'Sale ID',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                    $this->load->model("product_model");
                    $data = $this->product_model->get_sale_order_items($this->input->post("sale_id"));
                }
                echo json_encode($data);
        }
  */      
        function cancel_order(){
                $data = array(); 
                $_POST = $_REQUEST;      
                
                $this->load->library('form_validation');				
			    $this->form_validation->set_rules('sale_id', 'Sale ID',  'trim|required');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}else
                {
                    
                    $q = $this->db->query("Select * from registers where user_id = '".$this->input->post("user_id")."'");  
				 
				    $details1=$this->db->query("SELECT * FROM sale where sale_id = '".$this->input->post("sale_id")."' "); 
                    $details=$details1->row();
                
                    if($details->wallet_amount>0)
                    {
                        $this->db->insert("wallet_history", array("user_id"=>$details->user_id,
                                            "amount"=>$details->wallet_amount,
                                             "Status"=>1,                                          
                                            ));
                            $this->db->query("UPDATE registers  SET wallet=wallet+'$details->wallet_amount' WHERE  user_id= '$details->user_id'");

                    }
                
                    if($details->cash_back>0)
                    {
                        $this->db->insert("wallet_history", array("user_id"=>$details->user_id,
                                                "amount"=>$details->cash_back,
                                                 "Status"=>0,                                          
                                                ));
                                $this->db->query("UPDATE registers  SET wallet=wallet-'$details->cash_back' WHERE  user_id= '$details->user_id'");
    
                    }
				
				
                    
                    $this->db->query("Update sale set status = 3 where user_id = '".$this->input->post("user_id")."' and  sale_id = '".$this->input->post("sale_id")."' ");    
                    
                    $sale_items=$this->db->query("Select * from sale_items where sale_id = '".$this->input->post("sale_id")."' "); 
                    $sales=$sale_items->result();
                    foreach($sales as $row)
                    {
                        $product_id=$row->product_id;
                        $qty=$row->qty;
                        $this->db->query("update purchase SET  qty=qty+'$qty' where product_id ='$product_id'");
                        
                    }
                    
                    $data["responce"] = true;
                    $data["message"] = "Your order cancel successfully";
                }
                echo json_encode($data);
        }
        
        function get_society(){
                
                    $this->load->model("product_model");
                    $data  = $this->product_model->get_socities();
                
                echo json_encode($data);
        }
         
        function get_varients_by_id(){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('ComaSepratedIdsString', 'IDS',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                    $this->load->model("product_model");
                    $data  = $this->product_model->get_prices_by_ids($this->input->post("ComaSepratedIdsString"));
                }
                echo json_encode($data);
        }
        
        
        function get_sliders(){
            $q = $this->db->query("Select * from slider");
            echo json_encode($q->result());
        } 
        function get_banner(){
            $q = $this->db->query("Select * from banner");
            echo json_encode($q->result());
        }
       function get_date(){
            $q = $this->db->query("Select * from time_slots");
	$data['responce']=true;
	$data['data']=$q->result();
            echo json_encode($data);
        } 
        function get_feature_banner(){
            $q = $this->db->query("Select * from feature_slider");
            echo json_encode($q->result());
        }
        
        
        function get_limit_settings(){
            $q = $this->db->query("Select * from settings");
            echo json_encode($q->result());
        }
         
         
          function add_address(){
                {
                    $user_id = $_REQUEST['user_id'];
                    $pincode = $_REQUEST['pincode'];
                    $socity_id = $_REQUEST['socity_id'];
                    $house_no = $_REQUEST['house_no'];
                    $receiver_name = $_REQUEST['receiver_name'];
                    $receiver_mobile = $_REQUEST['receiver_mobile'];
                    
                    $array = array(
                    "user_id" => $user_id,
                    "pincode" => $pincode,
                    "socity_id" => $socity_id,
                    "house_no" => $house_no,
                    "receiver_name" => $receiver_name,
                    "receiver_mobile" => $receiver_mobile
                    );
                    
                    $this->db->insert("user_location",$array);
                    $insert_id = $this->db->insert_id();
                    $q = $this->db->query("Select user_location.*
                    from user_location 
                    where location_id = '".$insert_id."'");
                    $data["responce"] = true;
                    $data["data"] = $q->row();
                    
                }
                echo json_encode($data);
                
           /* $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'Pincode',  'trim|required');
                 $this->form_validation->set_rules('pincode', 'Pincode ID', 'trim|required');
                //$this->form_validation->set_rules('socity_id', 'Socity',  'trim|required');
                $this->form_validation->set_rules('house_no', 'House',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                    $user_id = $this->input->post("user_id");
                    $pincode = $this->input->post("pincode");
                    $socity_id = "0";//$this->input->post("socity_id");
                    $house_no = $this->input->post("house_no");
                    $receiver_name = $this->input->post("receiver_name");
                    $receiver_mobile = $this->input->post("receiver_mobile");
                    
                    $array = array(
                    "user_id" => $user_id,
                    "pincode" => $pincode,
                    "socity_id" => $socity_id,
                    "house_no" => $house_no,
                    "receiver_name" => $receiver_name,
                    "receiver_mobile" => $receiver_mobile
                    );
                    
                    $this->db->insert("user_location",$array);
                    $insert_id = $this->db->insert_id();
                    $q = $this->db->query("Select user_location.*,
                    socity.* from user_location 
                    inner join socity on socity.socity_id = user_location.socity_id
                    where location_id = '".$insert_id."'");
                    $data["responce"] = true;
                    $data["data"] = $q->row();
                    
                }
                echo json_encode($data);*/
        }
        
         public function edit_address_old(){
                $data = array(); 
                $_POST = $_REQUEST; 
                //print_r($_POST);exit();
                $this->load->library('form_validation');
                //print_r($this->load->library('form_validation'));exit();
                /* add users table validation */
                $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required');
                $this->form_validation->set_rules('socity_id', 'Socity ID', 'trim|required');
                $this->form_validation->set_rules('house_no', 'House Number', 'trim|required');
                $this->form_validation->set_rules('receiver_name', 'Receiver Name', 'trim|required');
                $this->form_validation->set_rules('receiver_mobile', 'Receiver Mobile', 'trim|required'); 
                $this->form_validation->set_rules('location_id', 'Location ID', 'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = 'field is required';
                    
        		}else
                {
                    $insert_array=  array(
                                            "pincode"=>$this->input->post("pincode"),
                                            "socity_id"=>$this->input->post("socity_id"),
                                            "house_no"=>$this->input->post("house_no"),
                                            "receiver_name"=>$this->input->post("receiver_name"),
                                            "receiver_mobile"=>$this->input->post("receiver_mobile")
                                            );
                     
                    $this->load->model("common_model");
                     
                    
                   $this->common_model->data_update("user_location",$insert_array,array("location_id"=>$this->input->post("location_id")));
                    
                      
                    $data["responce"] = true;
                    $data["data"] = "Your Address Update successfully";  
                  }                  
           
                     echo json_encode($data);
        }
        
public function edit_address()
	{
	    $data = array(); 
        $_POST = $_REQUEST; 
        $this->load->library('form_validation');
        $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required');
        $this->form_validation->set_rules('socity_id', 'Socity ID', 'trim|required');
        $this->form_validation->set_rules('house_no', 'House Number', 'trim|required');
        $this->form_validation->set_rules('receiver_name', 'Receiver Name', 'trim|required');
        $this->form_validation->set_rules('receiver_mobile', 'Receiver Mobile', 'trim|required'); 
        $this->form_validation->set_rules('location_id', 'Location ID', 'trim|required');
                
       
        if ($this->form_validation->run() == FALSE)
        		{
        			  $data["responce"] = false;
            		  			$data["error"] = strip_tags($this->form_validation->error_string());
        		}
       
	   else{
	        
            $insert_array=  array(
                                            "pincode"=>$this->input->post("pincode"),
                                            "socity_id"=>$this->input->post("socity_id"),
                                            "house_no"=>$this->input->post("house_no"),
                                            "receiver_name"=>$this->input->post("receiver_name"),
                                            "receiver_mobile"=>$this->input->post("receiver_mobile")
                                            );
                     
                    $this->load->model("common_model");
                     
                    
                   $this->common_model->data_update("user_location",$insert_array,array("location_id"=>$this->input->post("location_id")));
                    
                      
                    $data["responce"] = true;
                    $data["data"] = "Your Address Update successfully";  
        }
        echo json_encode($data);
    }        
/* Delete Address */

     public function delete_address()
	{
	    $data = array(); 
            $_POST = $_REQUEST; 
	    $this->load->library('form_validation');
                 $this->form_validation->set_rules('location_id', 'Location ID', 'trim|required');
       
        if ($this->form_validation->run() == FALSE)
        		{
        			  $data["responce"] = false;
            		  $data["error"] = 'field is required';
        		}
       
	   else{
	        
            $this->db->delete("user_location",array("location_id"=>$this->input->post("location_id")));
             
             $data["responce"] = true;
             $data["message"] = 'Your Address deleted successfully...';
        }
        echo json_encode($data);
    }
    /* End Delete  Address */
        
        
 function get_address(){
	  $data = array(); 
            $_POST = $_REQUEST;      
			
                $this->load->library('form_validation');
                $this->form_validation->set_rules('user_id', 'User',  'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                    $user_id = $this->input->post("user_id");
                    
        		    $q = $this->db->query("Select user_location.*,
                    socity.* from user_location 
                    inner join socity on socity.socity_id = user_location.socity_id
                    where user_id = '".$user_id."'");
                    $result = $q->result();
                    if(!$result){
                        $q = $this->db->query("Select user_location.* from user_location where user_id = '".$user_id."'");
                        $result = $q->result();
                    }
                    
                    $data["responce"] = true;
                    $data["data"] =$result;
                }
                echo json_encode($data);
        }
         
         
          /* contact us */
 
 public function support(){
    
     $q = $this->db->query("select * from `pageapp` WHERE id =1"); 
     
      
     $data["responce"] = true;
    $data['data'] = $q->result();
    
            
       echo json_encode($data);  
 }
 
 
 /* end contact us */
 
 /* about us */
  public function aboutus(){
    
     $q = $this->db->query("select * from `pageapp` where id=2"); 
     
      
     $data["responce"] = true;     
    $data['data'] = $q->result();
    
            
       echo json_encode($data);  
 }
 /* end about us */
/* about us */
  public function terms(){
    
     $q = $this->db->query("select * from `pageapp` where id=3"); 
     
      
     $data["responce"] = true;     
    $data['data'] = $q->result();
    
            
       echo json_encode($data);  
 }
 /* end about us */         
  
  	public function register_fcm(){
            $data = array();
            $this->load->library('form_validation');
            $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
            $this->form_validation->set_rules('token', 'Token', 'trim|required');
            $this->form_validation->set_rules('device', 'Device', 'trim|required');
            if ($this->form_validation->run() == FALSE) 
        {
                $data["responce"] = false;
               $data["error"] = $this->form_validation->error_string();
                                
        }else
            {   
                $device = $this->input->post("device");
                $token = $this->input->post("token");
                $user_id = $this->input->post("user_id");
                
                $field = "";
                if($device=="android"){
                    $field = "user_gcm_code";
                }else if($device=="ios"){
                    $field = "user_ios_token";
                }
                if($field!=""){
                    $this->db->query("update registers set ".$field." = '".$token."' where user_id = '".$user_id."'");
                    $data["responce"] = true;    
                }else{
                    $data["responce"] = false;
                    $data["error"] = "Device type is not set";
                }
                
                
            }
            echo json_encode($data);
    }
     public function test_fcm(){
        $message["title"] = "test";
        $message["message"] = "grocery test";
        $message["image"] = "";
        $message["created_at"] = date("Y-m-d h:i:s");  
    
    $this->load->helper('gcm_helper');
    $gcm = new GCM();   
    $result = $gcm->send_notification(array("AAAAgv35W5M:APA91bE4Q6EArUAWlBiJwV4GoHwnPmzj0aLf8aUSJDjXrFLHU3B0Jh9YSSbfUCIB2d33xNSDHh7LsY3BibyNkKE3cQfW0GjLuboEjtYQME3YAtJaSucbHWAsyJdGovRhWsf6TfbQB2I-"),$message ,"android");
      // $result = $gcm->send_topics("/topics/rabbitapp",$message ,"ios"); 
    print_r($result);
    }      
     
     /* Forgot Password */
    
    
    
       public function forgot_password(){
            $data = array(); 
            $_POST = $_REQUEST;      
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            if ($this->form_validation->run() == FALSE) 
        {
                  $data["responce"] = false;  
               $data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                        
        }else
            {
                   $request = $this->db->query("Select * from registers where user_email = '".$this->input->post("email")."' limit 1");
                   if($request->num_rows() > 0){
                                
                                $user = $request->row();
                                $token = uniqid(uniqid());
                                $this->db->update("registers",array("varified_token"=>$token),array("user_id"=>$user->user_id)); 
                                $this->load->library('email');
                               // $this->email->from($this->config->item('default_email'), $this->config->item('email_host'));
                                
                                $email = $user->user_email;
                                 $name = $user->user_fullname;
                                 $return = $this->send_email_verified_mail($email,$token,$name);
                                //exit;
                                 
                               
                                if (!$return){
                                                  $data["responce"] = false;  
                                                  $data["error"] = 'Warning! : Something is wrong with system to send mail.';
    
                                }else{
                                                  $data["responce"] = true;  
                                                  $data["message"] = 'Success! : Recovery mail sent to your email address please verify link.';
    
                                }
                   }else{
                                             $data["responce"] = false;  
                                             $data["error"] = 'Warning! : No user found with this email.';
    
                   }
                }
                echo json_encode($data);
        }
        
        
        public function send_email_verified_mail($email,$token,$name){
          //$message = $this->load->view('emails/email_verify',array("name"=>$name,"active_link"=>site_url("users/verify_email?email=".$email."&token=".$token)),TRUE);
//         echo $email.' '.$token;exit(); 
                           //$this->load->library('email');
/*
                            $this->email->from("test.makos@gmail.com","Grocery Store");
                            $list = array($email);
                            $this->email->to($list); 
                             $this->email->reply_to($email,"SurfCity");
                            $this->email->subject('Forgot password request');
                            $this->email->message("Hi ".$name." \n Your password forgot request is accepted plase visit following link to change your password. \n
                                ".site_url("users/modify_password/".$token)."
                                ");
                           print_r($this->email->send());*/

$header = "From:onlineddapp@gmail.com \r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-type: text/html\r\n";
$subject = "Forgot password request";
$body = "Hi ".$name." \n Your password forgot request is accepted plase visit following link to change your password. \n
   ".site_url("users/modify_password/".$token)."
                                ";
if( mail ($email,$subject,$body,$header) )
{
	return true;
}else{
	return false;
}

                      
    }
    /* End Forgot Password */   
        
    public function wallet(){
            $data = array(); 
            $_POST = $_REQUEST;
            if($this->input->get('user_id')==""){
                
            }
            else
			{
                $q = $this->db->query("Select * from registers where(user_id='".$this->input->get('user_id')."' ) Limit 1");
                $wallet_setting=$this->db->query("Select * from global_setting order by globe_setting_id DESC limit 1");
				$w_q=$this->db->query("Select * from wallet_history  where(user_id='".$this->input->post('user_id')." ORDER BY created_at DESC' )");
               
                error_reporting(0);
                if ($q->num_rows() > 0)
                    {                        
                            $row = $q->row(); 
                            $data["responce"] = true;   
                            $msg='';
                            if(0<$row->wallet)
                            {
                                $msg="success";
                            }else{
                                $msg="fail";
                            }
   			               $data= array("success" => $msg, "wallet"=>$row->wallet,"details"=>$wallet_setting->result(),"wallet_history"=>$w_q->result()) ;   			                     
                    }
                    else{
                        $data= array("success" => "unsucess", "wallet"=>0 ,"wallet_history"=>$w_q->result()) ;
                    }
            }
            echo json_encode($data);
        }
        
    public function rewards(){
            $data = array(); 
            $_GET = $_REQUEST;
            if($this->input->get('user_id')==""){
                $data= array("success" => unsucess, "total_rewards"=> 0 ) ;
            }
            else{
                $q = $this->db->query("Select sum(total_rewards) AS total_rewards from `delivered_order` where(user_id='".$this->input->get('user_id')."' )");
                error_reporting(0);
                if ($q->num_rows() > 0)
                    {
                        
                        $row = $q->row(); 
                       
                            $data["responce"] = true;  
   			                $data= array("success" => success, "total_rewards"=>$row->total_rewards) ;
   			                   
                    }
                    else{
                        $data= array("success" => hastalavista, "total_rewards"=> 0 ) ;
                    }
            }
            echo json_encode($data);
        }
        
    public function shift(){
            $data = array(); 
            $_POST = $_REQUEST;
            if($this->input->post('user_id')==""){
                $data= array("success" => unsucess, "total_rewards"=> 0 ) ;
            }
            else{
                error_reporting(0);
                $amount=$this->input->post('amount');
                $rewards=$this->input->post('rewards');
                //$user_id=$this->input->post('user_id');
                //$final_amount=$amount+$rewards;
                //$reward_value = $rewards*.50; 
                $final_rewards= 0;
   			                
   			                
   			    $select= $this->db->query("SELECT * from rewards where id=1");
   			    if ($select->num_rows() > 0)
                    {
                       $row = $select->row_array(); 
                       $point= $row['point'];
                    }
                    
                $reward_value = $point+$rewards;
                $final_amount=$amount+$reward_value;
                $data["wallet_amount"]= [array("final_amount"=>$final_amount, "final_rewards"=>0,"amount"=>$amount,"rewards"=>$rewards,"pont"=>$point)];
   			    $this->db->query("delete from delivered_order where user_id = '".$this->input->post('user_id')."'");
   			    $this->db->query("UPDATE `registers` SET wallet='".$final_amount."' where(user_id='".$this->input->post('user_id')."' )"); 
            }
            echo json_encode($data);
        }
        
    public function wallet_on_checkout(){
            $data = array(); 
            $_POST = $_REQUEST;
            if($this->input->post('wallet_amount')>=$this->input->post('total_amount')){
                $wallet_amount=$this->input->post('wallet_amount');
                $amount=$this->input->post('total_amount');
                
                $final_amount=$wallet_amount-$amount;
                $balance=0;
                
                $data["final_amount"]= [array("wallet"=>$final_amount, "total"=>$balance)];
            }
            if($this->input->post('wallet_amount')<=$this->input->post('total_amount')){
                $wallet_amount=$this->input->post('wallet_amount');
                $amount=$this->input->post('total_amount');
                
                $final_amount=0;
                $balance=$amount-$wallet_amount;
                
                $data["final_amount"]= [array("wallet"=>$final_amount, "total"=>$balance, "used_wallet" => $wallet_amount)];
            }
            else{
                
            }
            echo json_encode($data);
        }
    
    public function recharge_wallet(){
        $data = array(); 
        $_POST = $_REQUEST;
        
        $q = $this->db->query("Select wallet from `registers` where(user_id='".$this->input->post('user_id')."' )");
		
                error_reporting(0);
                if ($q->num_rows() > 0)
                    {
                      
                      $row = $q->row(); 
                      
                      $current_amount=$q->row()->wallet;
                      $request_amount=$this->input->post('wallet_amount');
                      
                      $new_amount=$current_amount+$request_amount;
                      $this->db->query("UPDATE `registers` SET wallet='".$new_amount."' where(user_id='".$this->input->post('user_id')."' )"); 
                      
                      $data= array("success" => success, "wallet_amount"=>"$new_amount") ;
                    }
            echo json_encode($data);
    }

  
  public function deelOfDay()
  {
    $data = array();
    $_POST = $_REQUEST;
    error_reporting(0);
    $q = $this->db->get('deelofday');
    $data[responce]="true";
    $data[Deal_of_the_day] = $q->result();
    echo json_encode($data);
  }
  
  public function top_selling_product()
  {
    $data = array();
    $_POST = $_REQUEST;
    error_reporting(0);
    $q = $this->db->query("SELECT * FROM products INNER JOIN categories on products.category_id=categories.id WHERE products.top_selling=1");
    $data[responce]="true";
    //print_r($q->result());exit();
    //$data[top_selling_product] = $q->result();
	foreach($q->result() as $product)
   {
	   /*
	   $present = date('m/d/Y h:i:s a', time());
					  $date1 = $product->start_date." ".$product->start_time;
					  $date2 = $product->start_date." ".$product->end_time;

					 if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
					 {
						
					   if(empty($product->deal_price))   ///Runing
					   {
						   $price= $product->price;
					   }else{
							 $price= $product->deal_price;
					   }
					
					 }else{
					  $price= $product->price;//expired
					 } 
	  */
	   $data[top_selling_product][] = array(
	    'product_id' => $product->product_id,
            'product_name'=> $product->product_name,
			'category_id' => $product->category_id,
            'product_description'=>$product->product_description,
            'deal_price'=>'',
            'start_date'=>'',
            'start_time'=>'',
            'end_date'=>'',
            'end_time'=>'',
            'price' =>$product->price,
			'surfcity_price'=>$product->surfcity_price,
            'subscription_price'=>$product->subscription_price,
            'product_image'=>$product->product_image,
            'status' => '',
            'in_stock' =>$product->in_stock,
            'unit_value'=>$product->unit_value,
            'unit'=>$product->unit,
            'increament'=>$product->increament,
            'rewards'=>$product->rewards,
			'stock' => '',
            'title'=>$product->title
           
        );
   }
    echo json_encode($data);
  }
  
  public function get_all_top_selling_product()
  {
	   $data = array();
    $_POST = $_REQUEST;
    error_reporting(0);
	if($this->input->post('top_selling_product')){
    $q = $this->db->query("select p.*,dp.start_date,dp.start_time,dp.end_time,dp.deal_price,c.title,count(si.product_id) as top,si.product_id from products p INNER join sale_items si on p.product_id=si.product_id INNER join categories c ON c.id=p.category_id left join deal_product dp on dp.product_id=si.product_id GROUP BY si.product_id order by top DESC LIMIT 8");
    
	$data[responce]="true";
   foreach($q->result() as $product)
   {
	   $present = date('m/d/Y h:i:s a', time());
					  $date1 = $product->start_date." ".$product->start_time;
					  $date2 = $product->end_date." ".$product->end_time;

					 if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
					 {
						
					   if(empty($product->deal_price))   ///Runing
					   {
						   $price= $product->price;
					   }else{
							 $price= $product->deal_price;
					   }
					
					 }else{
					  $price= $product->price;//expired
					 } 
	   
	   $data[top_selling_product][] = array(
	    'product_id' => $product->product_id,
            'product_name'=> $product->product_name,
			'category_id' => $product->category_id,
            'product_description'=>$product->product_description,
            'deal_price'=>'',
            'start_date'=>'',
            'start_time'=>'',
            'end_date'=>'',
            'end_time'=>'',
            'price' =>$price,
            'product_image'=>$product->product_image,
            'status' => '',
            'in_stock' =>$product->in_stock,
            'unit_value'=>$product->unit_value,
            'unit'=>$product->unit,
            'increament'=>$product->increament,
            'rewards'=>$product->rewards,
			'stock' => '',
            'title'=>$product->title
           
        );
   }
	}
    echo json_encode($data);
  }

  
  public function deal_product()
  {

    $data = array();
    $_POST = $_REQUEST;
    $status=0;
    error_reporting(0);

    $global_setting=$this->db->query("Select deal_max_count from global_setting order by globe_setting_id DESC limit 1");
    $data['global_setting']=$global_setting->row();
   //$q=$this->db->query("SELECT * FROM deal_product INNER JOIN products on deal_product.product_id=products.product_id INNER JOIN categories ON products.category_id=categories.id WHERE (CURRENT_DATE BETWEEN start_date AND end_date) AND (CURRENT_TIME BETWEEN start_time AND end_time)");
   $q=$this->db->query("SELECT * FROM deal_product INNER JOIN products on deal_product.product_id=products.product_id INNER JOIN categories ON products.category_id=categories.id WHERE (NOW() BETWEEN concat(start_date,' ',start_time) AND concat(end_date,' ',end_time))");
   //$this->db->query("SELECT * FROM deal_product INNER JOIN products on deal_product.product_id=products.product_id INNER JOIN categories ON products.category_id=categories.id WHERE (CURRENT_DATE BETWEEN start_date AND end_date)");
    
    $data['responce']="true";
  // $data['Deal_of_the_day']=array();
   foreach ($q->result() as $product) {
      

      $data['Deal_of_the_day'][] = array(
            'product_id' => $product->product_id,
            'product_name'=> $product->product_name,
            'product_description'=>$product->product_description,
            'deal_price'=>$product->deal_price,
            'start_date'=>$product->start_date,
            'start_time'=>$product->start_time,
            'end_date'=>$product->end_date,
            'end_time'=>$product->end_time,
            'price' =>$product->surfcity_price,
            'product_image'=>$product->product_image,
            'in_stock' =>$product->in_stock,
            'unit_value'=>$product->deal_unit_value,
            'unit'=>$product->deal_unit,
            'increament'=>$product->increament,
            'rewards'=>$product->rewards,
            'title'=>$product->title,
            'max_qty'=>$product->max_qty,
            'status'=>$status,
            'isSingleItem'=>true
        );
    }
  echo json_encode($data);
  }
  
  public function shop_list()
{
	$data = array();
    $_POST = $_REQUEST;
    error_reporting(0);
    $q = $this->db->query("SELECT * FROM shop_master");
    $data['responce']="true";
    $data['shop_list'] = $q->result();
    echo json_encode($data);

}

  public function get_all_deal_product()
  {


    $data = array();
    $_POST = $_REQUEST;
    $status=0;
    error_reporting(0);


   //$q=$this->db->query("SELECT * FROM deal_product INNER JOIN products on deal_product.product_id=products.product_id INNER JOIN categories ON products.category_id=categories.id WHERE (CURRENT_DATE BETWEEN start_date AND end_date)"); //AND (CURRENT_TIME BETWEEN start_time AND end_time)
   
   $q=$this->db->query("SELECT * FROM deal_product INNER JOIN products on deal_product.product_id=products.product_id INNER JOIN categories ON products.category_id=categories.id WHERE (NOW() BETWEEN concat(start_date,' ',start_time) AND concat(end_date,' ',end_time))");
  $data['responce']="true";
  // $data['Deal_of_the_day']=array();
   foreach ($q->result() as $product) {
      $data['Deal_of_the_day'][] = array(
            'product_id' => $product->product_id,
            'product_name'=> $product->product_name,
            'product_description'=>$product->product_description,
            'deal_price'=>$product->deal_price,
            'start_date'=>$product->start_date,
            'start_time'=>$product->start_time,
            'end_date'=>$product->end_date,
            'end_time'=>$product->end_time,
            'price' =>$product->surfcity_price,
            'product_image'=>$product->product_image,
            'in_stock' =>$product->in_stock,
            'unit_value'=>$product->deal_unit_value,
            'unit'=>$product->deal_unit,
            'increament'=>$product->increament,
            'rewards'=>$product->rewards,
            'title'=>$product->title,
            'max_qty'=>$product->max_qty,
            'status'=>$status,
            'isSingleItem'=>true
        );
    }
  echo json_encode($data);
  
}
  
  
  public function icon(){
            $parent = 0 ;
            if($this->input->post("parent")){
                $parent    = $this->input->post("parent");
            }
        $categories = $this->get_header_categories_short($parent,0,$this) ;
        $data["responce"] = true;
        $data["data"] = $categories;
        echo json_encode($data);
        
    }

    
    public function get_header_categories_short($parent,$level,$th){
            $q = $th->db->query("Select a.*, ifnull(Deriv1.Count , 0) as Count, ifnull(Total1.PCount, 0) as PCount FROM `header_categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `header_categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` 
                         LEFT OUTER JOIN (SELECT `category_id`,COUNT(*) AS PCount FROM `header_products` GROUP BY `category_id`) Total1 ON a.`id` = Total1.`category_id` 
                         WHERE a.`parent`=" . $parent);
                        
                        $return_array = array();
                        
                        foreach($q->result() as $row){
                                    if ($row->Count > 0) {
                                        $sub_cat = 	$this->get_header_categories_short($row->id, $level + 1,$th);
                    				    $row->sub_cat = $sub_cat;   	
                                    } elseif ($row->Count==0) {
                    				
                                    }
                            $return_array[] = $row;
                        }
        return $return_array;
    }
    
    function get_header_products(){
                 $this->load->model("product_model");
                $cat_id = "";
                if($this->input->post("cat_id")){
                    $cat_id = $this->input->post("cat_id");
                }
              $search= $this->input->post("search");
                
                $data["responce"] = true;  
   $datas = $this->product_model->get_header_products(false,$cat_id,$search,$this->input->post("page"));

foreach ($datas as $product) {
 $data['data'][] =  array(
            'product_id' => $product->product_id,
                  'product_name'=> $product->product_name,
                  'category_id'=> $product->category_id,
                  'product_description'=>$product->product_description,
                  'deal_price'=>"",
                  'start_date'=>"",
                  'start_time'=>"",
                  'end_date'=>"",
                  'end_time'=>"",
                  'price' =>$product->price,
                  'product_image'=>$product->product_image,
                  'status' => '0',
                  'in_stock' =>$product->in_stock,
                  'unit_value'=>$product->unit_value,
                  'unit'=>$product->unit,
                  'increament'=>$product->increament,
                  'rewards'=>$product->rewards,
                  'stock'=>$product->stock,
                  'title'=>$product->title
           
        );
}
                echo json_encode($data);
        }
        
public function coupons()
{
			$date=date("d/m/Y");
            $q = $this->db->query("SELECT * FROM coupons where (CURRENT_DATE BETWEEN DATE_FORMAT(STR_TO_DATE(valid_from, '%d/%m/%y'), '%Y-%m-%d') AND DATE_FORMAT(STR_TO_DATE(valid_to, '%d/%m/%y'), '%Y-%m-%d'))"); 
            $data["responce"] = true;     
            $data['data'] = $q->result();
			$data['date']=$date;
            echo json_encode($data);  
}


/*        
public function get_coupons()
{			
			$data = array(); 
            $_POST = $_REQUEST;      
            $this->load->library('form_validation');				
            
            $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required');                
            if ($this->form_validation->run() == FALSE) 
        	{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        	}
			else
            {
            
			$q = $this->db->query("SELECT * FROM coupons where valid_to>='".date('d/m/Y')."' AND coupon_code='".$this->input->post("coupon_code")."' ");//where coupon_code=");            	
			//echo $this->input->post("coupon_code");	
			$count=count($q->result());//));
			
            if($count==1)
            {    		
				$data["responce"] = true; 									
				$data['coupons_details']=$q->result();
				$data["message"] = "Coupon code  correct..!";								
			}
			else
			{
				$data["responce"] = false; 												
			    $data["message"] = "coupon_code wrong ";							
				
			}			
			
			}
            echo json_encode($data);
}
*/

public function get_coupons()
{
	$data = array(); 
            $_POST = $_REQUEST;      
                $this->load->library('form_validation');				
                /* add registers table validation */
				
            $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
				//$this->form_validation->set_rules('wallet_amount', 'Wallet amt', 'trim');
			$this->form_validation->set_rules('coupon_code', 'Coupon ID', 'trim|required');
			$this->form_validation->set_rules('coupon_code', 'Coupon ID', 'trim|required');
				
				if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = strip_tags($this->form_validation->error_string());                                        
        		}else
                {
                	
    				
    					$q = $this->db->query("SELECT * FROM coupons where valid_to>='".date('d/m/Y')."' AND coupon_code='".$this->input->post("coupon_code")."' ");
    		        
    		        if($q->result()){
    		            $result=$q->row();
    		             
    		             $cp_count = $this->db->query("SELECT count(coupons_id) as coupons_count FROM sale where user_id='".$this->input->post("user_id")."' AND coupons_id='$result->id'");
    		            $cp_count1=$cp_count->row();
    		            
    		            if($cp_count1->coupons_count<=$result->max_count)
    		            {
    		                $data["responce"]=true;
        					$data["message"]="coupons applied";
        					$data["user_id"]=$this->input->post("user_id");
        					$data["data"]=$q->result();
            
    		            }else{
    		                $data["responce"]=false;
    					    $data["message"]="coupon limit exceeded";
    		                
    		            }
    					
    				}
    				else
    				{
    					$data["responce"]=false;
    					$data["message"]="coupons not applied";
    					
    				}
				
				}
				echo json_encode($data);
}
/*
public function get_sub_cat(){
            $parent = 0 ;
            if($this->input->post("sub_cat")!=0){
                $q = $this->db->query("SELECT * FROM `categories` where id='".$this->input->post("sub_cat")."'");
                    $data["responce"] = true;
                     $data["subcat"] = $q->result();
                     echo json_encode($data);
            }
            else{
                $data["responce"] = false;
                $data["subcat"]="";
                echo json_encode($data);
            }                
        }
*/      
function get_sub_cat(){
                $data = array();
                $_POST = $_REQUEST;
                $this->load->library('form_validation');
                $this->form_validation->set_rules('sub_cat', 'category ID',  'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                    $parent = 0 ;
                    if($this->input->post("sub_cat")!=0){
                        $q = $this->db->query("SELECT * FROM `categories` where id='".$this->input->post("sub_cat")."'");
                            $data["responce"] = true;
                             $data["subcat"] = $q->result();
                     
                    }
                    else{
                        $data["responce"] = false;
                        $data["subcat"]="";
                     
                    }      
                }
                echo json_encode($data);
        }
        
public function delivery_boy()
{
    
            $q = $this->db->query("select id,user_name from `delivery_boy` where user_status=1");
            $data['delivery_boy'] = $q->result();
            
            echo json_encode($data); 
         }
         
         public function delivery_boy_login(){
            $data = array();
            
            $this->load->library('form_validation');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');  
            
                if (!$this->input->post('user_password')) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] =  strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                   //users.user_email='".$this->input->post('user_email')."' or
                    $q = $this->db->query("Select * from delivery_boy where user_password='".md5($this->input->post('user_password'))."'");
                    
                    if ($q->result() > 0)
                    {
                        $row = $q->row(); 
                        $access=$row->user_status;
                        if($access=="0")
                        {
                            $data["responce"] = false;  
   			                $data["data"] = 'Your account currently inactive.Please Contact Admin';
                            
                        }
                       
                        else
                        {
                            //$error_reporting(0);
                            $data["responce"] = true;  
                            $q = $this->db->query("Select id,user_name from delivery_boy where user_password='".md5($this->input->post('user_password'))."'");
   			                $product=$q->result();
   			                $data['product']= $product;
   			                   
                        }
                    }
                    else
                    {
                              $data["responce"] = false;  
   			                  $data["data"] = 'Invalide Username or Passwords';
                    }
                   
                    
                }
           echo json_encode($data);
            
        }
        
        
        public function add_purchase(){
    if(_is_user_login($this)){
	    
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('product_id', 'product_id', 'trim|required');
                $this->form_validation->set_rules('qty', 'Qty', 'trim|required');
                $this->form_validation->set_rules('unit', 'Unit', 'trim|required');
                if ($this->form_validation->run() == FALSE)
        		{
        		  if($this->form_validation->error_string()!="")
        			  $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
        		}
        		else
        		{
      		  
                    $this->load->model("common_model");
                    $array = array(
                    "product_id"=>$this->input->post("product_id"),
                    "qty"=>$this->input->post("qty"),
                    "price"=>$this->input->post("price"),
                    "unit"=>$this->input->post("unit"),
                    "store_id_login"=>$this->input->post("store_id_login")
                    );
                    $this->common_model->data_insert("purchase",$array);
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/add_purchase");
                }                
                $this->load->model("product_model");
                $data["purchases"]  = $this->product_model->get_purchase_list();
                $data["products"]  = $this->product_model->get_products();
                $this->load->view("admin/product/purchase",$data);  
                
            }
        }
    
}

        public function stock() 
        {
                 $this->load->model("product_model");
                $cat_id = "";
                if($this->input->post("cat_id")){
                    $cat_id = $this->input->post("cat_id");
                }
              $search= $this->input->post("search");
                
                $datas = $this->product_model->get_products(false,$cat_id,$search,$this->input->post("page"));
				//print_r( $datas);exit();
                foreach ($datas as  $product) {
					$present = date('m/d/Y h:i:s a', time());
					  $date1 = $product->start_date." ".$product->start_time;
					  $date2 = $product->end_date." ".$product->end_time;

					 if(strtotime($date1) <= strtotime($present) && strtotime($present) <=strtotime($date2))
					 {
						
					   if(empty($product->deal_price))   ///Runing
					   {
						   $price= $product->price;
					   }else{
							 $price= $product->deal_price;
					   }
					
					 }else{
					  $price= $product->price;//expired
					 } 
							
                  $data['products'][] = array(
                  'product_id' => $product->product_id,
                  'product_name'=> $product->product_name
                  
                 );
                }
                
                echo json_encode($data);
        }
        
        public function stock_insert()
        {
             $this->load->library('form_validation');
             
                $this->input->post('product_id');
                $this->input->post('qty');
                $this->input->post('unit');
                if (!$this->input->post('product_id'))
        		{
   			             $data["data"] = 'Please select the product';
        		}
        		else
        		{
      		  
                    $this->load->model("common_model");
                    $array = array(
                    "product_id"=>$this->input->post("product_id"),
                    "qty"=>$this->input->post("qty"),
                    "price"=>$this->input->post("price"),
                    "unit"=>$this->input->post("unit"),
                    "store_id_login"=>$this->input->post("store_id_login")
                    );
                    $this->common_model->data_insert("purchase",$array);
                    
                        $data['product'][] = array("msg"=>'Your Stock is Updated');  
                        
                }
                echo json_encode($data);
                $this->load->model("product_model");
                $data["purchases"]  = $this->product_model->get_purchase_list();
                $data["products"]  = $this->product_model->get_products();
        }
        
        public function assign()
        {
            $order=$this->input->post("order_id");
            $order=$this->input->post("d_boy");
            $this->load->model("common_model");
            $this->common_model->data_update("sale",$update_array,array("sale_id"=>$order));
        }
        
        public function delivery_boy_order()
        {
            $delivery_boy_id=$this->input->post("d_id");
            
            $this->load->model("product_model");
            $data = $this->product_model->delivery_boy_order($delivery_boy_id);
            
            //$q = $this->db->query("Select * from sale where assign_to = '".$delivery_boy_id."'");
            //$data['assign_orders'] = $q->result();
            echo json_encode($data);
        }
        
        public function assign_order()
        {
            $order_id = $this->input->post("order_id");
            $boy_name = $this->input->post("boy_name");
                    
            $update_array = array("assign_to"=>$boy_name);
                       
            $this->load->model("common_model");
            $q= $this->common_model->data_update("sale",$update_array,array("sale_id"=>$order_id));
            
            if($q){
                $data['assign'][]=array("msg"=>"Assign Successfully");
            }
            else{
                $data['assign'][]=array("msg"=>"Assign Not Successfully");
            }
            echo json_encode($data);
        }
        
        public function mark_delivered()
        {   
            
            $this->load->library('form_validation');
            $signature = $this->input->post("signature");
            
                if (empty($_FILES['signature']['name']))
                {
                    $this->form_validation->set_rules('signature', 'signature', 'required');
                }
                
                if ($this->form_validation->run() == FALSE)
            {
                $data["error"] = $data["error"] = array("error"=>"not found");
            }
            else
            {
                    $add = array(
                                    "order_id"=>$this->input->post("id")
                                    );
                    
                        if($_FILES["signature"]["size"] > 0){
                            $config['upload_path']          = './uploads/signature/';
                            $config['allowed_types']        = 'gif|jpg|png|jpeg';
                            $this->load->library('upload', $config);
            
                            if ( ! $this->upload->do_upload('signature'))
                            {
                                    $error = array('error' => $this->upload->display_errors());
                            }
                            else
                            {
                                $img_data = $this->upload->data();
                                $add["signature"]=$img_data['file_name'];
                            }
                            
                       }
                       
                    $q =$this->db->insert("signature",$add);
                    if($q){
                        $data=array("msg"=>"Upload Successfull");
                    }
                    else{
                        $data=array("msg"=>"Upload Not Successfull");
                    }
                }
            
                echo json_encode($data);
                
        }
        
        public function mark_delivered2(){

        
            if ((($_FILES["signature"]["type"] == "image/gif")
            || ($_FILES["signature"]["type"] == "image/jpeg")
            || ($_FILES["signature"]["type"] == "image/jpg")
            || ($_FILES["signature"]["type"] == "image/jpeg")
            || ($_FILES["signature"]["type"] == "image/png")
            || ($_FILES["signature"]["type"] == "image/png"))) {
        
        
                //Move the file to the uploads folder
                move_uploaded_file($_FILES["signature"]["tmp_name"], "./uploads/signature/" . $_FILES["signature"]["name"]);
        
                //Get the File Location
                $filelocation = 'http://neerajbisht.com/grocery_test/uploads/signature/'.$_FILES["signature"]["name"];
        
                //Get the File Size
                $order_id=$this->input->post("id");
                
                $q =$this->db->query("INSERT INTO signature (order_id, signature) VALUES ('$order_id', '$filelocation')");
                
                //$this->db->insert("signature",$add);
                    if($q){
                        $data=array("success"=>"1", "msg"=>"Upload Successfull");
                        $this->db->query("UPDATE `sale` SET `status`=4 WHERE `sale_id`='".$order_id."'");
                        $this->db->query("INSERT INTO delivered_order (sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method)
SELECT sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method FROM sale
where sale_id = '".$order_id."'");
                    }
                    else{
                        $data=array("success"=>"0", "msg"=>"Upload Not Successfull");
                    }
            }
            else
            {
                $data=array("success"=>"0", "msg"=>"Image Type Not Right");
            }
            echo json_encode($data);
        }
        
public function edit_order_payment()
{
               $data = array(); 
			   
               $_POST = $_REQUEST;      
               $this->load->library('form_validation');               
               $this->form_validation->set_rules('sale_id', 'Sale ID', 'trim|required');
               $this->form_validation->set_rules('txn_id', 'TXN ID', 'trim|required');
               $this->form_validation->set_rules('order_id', 'ORDER ID', 'trim|required');
			   $this->form_validation->set_rules('user_id', 'User ID', 'trim|required');
			   
                
               if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());

        		}
				else
                {
					//echo $query->num_rows();
					//die();
					$insert_array=  array("txn_id"=>$_REQUEST["txn_id"],'order_id'=>$_REQUEST["order_id"]);
                    $this->load->model("common_model");
                    $this->common_model->data_update("sale",$insert_array,array("sale_id"=>$_REQUEST["sale_id"]));
					/*		first order place add  to wallet amt  	*/
					$query=$this->db->query("SELECT * FROM sale WHERE user_id=".$_REQUEST["user_id"]);
					if($query->num_rows()==1)
					{
							$get_referral_details=$this->db->query("SELECT * FROM registers,global_setting WHERE registers.globe_setting_id=global_setting.globe_setting_id AND user_id=".$_REQUEST["user_id"]);
							foreach($get_referral_details->result_array() as $row)
							{
							}
							
							if(!empty($row['refer_and_earn']))
							{
							$this->db->query("UPDATE registers SET wallet=wallet+'".$row['refer_and_earn']."' WHERE referral_code=".$row['from_referral_code']);
							}																		
					}					
					$this->db->query("DELETE FROM add_cart_list WHERE user_id=".$_REQUEST["user_id"]);
                    
                    $data["responce"] = true;
                    $data["data"] = "Your Order Update successfully";  
                  }                             
                     echo json_encode($data);
        }
/*sawat code*/
public function test_notification(){
        $device_id  =   "c1C459gNffg:APA91bEXYsxjGF_B5apBYErThfhVNFsabGRCwSCXlD69YOXGAtDlAsZgsPtSLRjtmd54fAkoL7LIPJXy_nEj14Z7tMMZprCRn6A4BE2jGl_LBpqKFtZoKHCOVMEq3iOFoK9-vfHf5m5M";

        $message    =   "Hello";

        return $this->senAndroidNotification($device_id,$message);
    }

    public function senAndroidNotification($device_id,$message)
    {

        $device_id = $device_id;
        // API access key from Google API's Console
        //

        //define( 'API_ACCESS_KEY', 'AIzaSyDtwrj_hmjvLZ2MtTrnGKTlhFFI-3rh5vA' ); 
      define( 'API_ACCESS_KEY', 'AAAA-dg9gSA:APA91bFGfM1j6Vyx4dWB-juNoPCYZjeJspimLhkeZwRG6Uv5KLdNROMAaDKaasfCevZYWrSdRutwTP32J0mNb5SR8w1iNpFq_rzQWQl9SCZVSoUBjegb0E9HVhN5HzPcsy9bp-o38Zrg' );  





// TAKE NEW API KEY FROM DEVELOPER
       

        $registrationIds = array($device_id);

        // prep the bundle
        $msg = array
        (
            'body'   => $message,
            'title'     => 'Test By Code',
            'subtitle'  => '',
            'tickerText'=> '',
            'vibrate'   => 1,
            'sound'     => 1,
            'largeIcon' => '',
            'smallIcon' => ''
        );
        $fields = array
        (
            'registration_ids'  => $registrationIds,
            'data'          => $msg
        );
         
        $headers = array
        (
            'Authorization: key=' . API_ACCESS_KEY,
            'Content-Type: application/json'
        );
         
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );

        print_r($result);
        curl_close( $ch );
    }
		
}
?>
