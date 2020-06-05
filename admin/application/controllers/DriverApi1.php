<?php 

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 date_default_timezone_set('Asia/Kolkata');
class DriverApi extends CI_Controller {

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
		
        public function testme()dr
        {
            header('Content-type: text/html');
            date_default_timezone_set('Asia/Kolkata');
            
            $order_id = 3;
            $this->load->model('Product_model');
            $data['order'] = $this->Product_model->get_sale_order_by_id($order_id);
            $data['order_items'] = $this->Product_model->get_sale_order_items($order_id);            
            $header = "From:testmakos@gmail.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";
            $subject = "Order placed Successully !";
            $body = $this->load->view('api/order_template', $data, true);
            echo $body;
            
          
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

public function UpdateProfile()
{
                $data = array(); 
                $_POST = $_REQUEST; 
                $this->load->library('form_validation');
                $this->form_validation->set_rules('driver_id', 'Driver ID', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["responce"] = false;  
        			$data["error"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
        			$data["details"]=array();
                    
        		}else
                {
                
         		if(isset($_FILES["image"]) && $_FILES["image"]["size"] > 0){
                    $config['upload_path']          = './uploads/driver/';
                    $config['allowed_types']        = 'gif|jpg|png|jpeg';
                    $config['encrypt_name'] = TRUE;
                    $this->load->library('upload', $config);
    
                    if ( ! $this->upload->do_upload('image'))
                    {
                    $data["code"] = 2;  
        			$data["msg"] =  strip_tags($this->form_validation->error_string());
                           
                    }
                    else
                    {
                        $img_data = $this->upload->data();
                        $this->load->model("common_model");
                        $this->common_model->data_update("driver", array(
                                            "profile_photo"=>$img_data['file_name']
                                            ),array("driver_id"=>$this->input->post("driver_id")));
                                            
                        $data["code"] = 1;  
        			    $data["msg"] =  "profile photo uploaded successfully";
                        $data["details"] = $img_data['file_name'];
                    }
                    
               		}else{
               	    $data["code"] = 2;  
        			$data["msg"] =  'Please choose profile image';               	
        			$data["details"]=array();
               		}                              
                  }                  
                    $data['request']=$_POST;
                     echo json_encode($data);        
 }     

public function ChangePassword(){
            $data = array(); 
            $_POST = $_REQUEST; 
                $this->load->library('form_validation');
                /* add users table validation */
                $this->form_validation->set_rules('driver_id', 'Driver Id', 'trim|required');
                $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
                $this->form_validation->set_rules('new_password', 'New Password', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["code"] = 2;  
                    $data["msg"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
        			$data["details"]=array();
                    
        		}else
                {
                    $this->load->model("common_model");
                    $q = $this->db->query("select * from driver where driver_id = '".$this->input->post("driver_id")."' and  password = '".md5($this->input->post("current_password"))."' limit 1");
                    $user = $q->row();
                    
                    if(!empty($user)){
                    $this->common_model->data_update("driver", array(
                                            "password"=>md5($this->input->post("new_password"))
                                            ),array("driver_id"=>$user->driver_id));
                    
                    $data["code"] = 1; 
                    $data["msg"] = 'New Password changed successfully';
                    }else{
                    $data["code"] = 2;  
                    $data["msg"] = "Current password doesn't match.";
        			$data["details"]=array();  
        			
                    }
                  }                  
                    $data['request']=$_POST;
                     echo json_encode($data);
}      


public function UpdateDriverProfile(){
                $data = array(); 
                $_POST = $_REQUEST; 
                $this->load->library('form_validation');
                /* add users table validation */
                $this->form_validation->set_rules('driver_id', 'User ID', 'trim|required');
                $this->form_validation->set_rules('first_name', 'First Name', 'trim');
                $this->form_validation->set_rules('last_name', 'last Name', 'trim');
                $this->form_validation->set_rules('email', ' email id', 'trim|valid_email');
                $this->form_validation->set_rules('phone', 'contact number', 'trim|required|numeric|regex_match[/^[0-9,]+$/]|min_length[10]|max_length[10]');
           		$this->form_validation->set_rules('driver_address', ' address', 'trim');   
           		$this->form_validation->set_rules('licence_plate', ' licence plate', 'trim|required');
           		$this->form_validation->set_rules('color', ' color', 'trim|required');
                
                
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["code"] = 2;
        			$data["msg"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                    $insert_array=  array(
                                            "phone"=>$this->input->post("phone"),
                                            "color"=>$this->input->post("color"),
                                            "licence_plate"=>$this->input->post("licence_plate"),
                                            "date_modified"=>date('Y-m-d h:i:s') 
                                        );
                     
                    $this->load->model("common_model");
                    
                    $this->common_model->data_update("driver",$insert_array,array("driver_id"=>$this->input->post("driver_id"))); 
                    $path=base_url()."uploads/driver/";
                    $q = $this->db->query("Select driver_id, on_duty, first_name, last_name, email, phone, username, transport_type, licence_plate, color, status, date_created, date_modified, last_login, location_lat, location_lng, token, concat('$path',profile_photo) as profile_photo, driver_address from `driver` where(driver_id='".$this->input->post('driver_id')."' ) Limit 1");  
                    
                    $row = $q->row();
                    $data["code"] = 1;
                    $data["details"] =$q->row();
                    $data["msg"] = 'Profile details updated successfully';
					
                  }                  
                    $data['request']=$_POST;
                     echo json_encode($data);
}
public function GetDriverProfile(){
                $data = array(); 
                $_POST = $_REQUEST; 
                $this->load->library('form_validation');
                /* add users table validation */
                $this->form_validation->set_rules('driver_id', 'Driver ID', 'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["code"] = 2;
        			$data["msg"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                    $path=base_url()."uploads/driver/";
                    $q = $this->db->query("Select driver_id, on_duty, first_name, last_name, email, phone, username, transport_type, licence_plate, color, status, date_created, date_modified, last_login, location_lat, location_lng, token, concat('$path',profile_photo) as profile_photo, driver_address from `driver` where(driver_id='".$this->input->post('driver_id')."' ) Limit 1");  
                    $row = $q->row();
                    $data["code"] = 1;
                    $data["details"] =$q->row();
                    $data["msg"] = 'Profile details ';
					
                  }                  
                    $data['request']=$_POST;
                    echo json_encode($data);
}           

/* user login json */

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
        			    $data["error"] = 'Your account currently deleted.Please Contact Admin';
        			    echo json_encode($data);
        			    exit();
                        
                    }elseif($checkuser1->status == "0")
                    {
                                $data["responce"] = false;  
   			                    $data["error"] = 'Your account currently inactive.Please Contact Admin';
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
                    
                    $header = "From:testmakos@gmail.com \r\n";
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
                    
                    $header = "From:testmakos@gmail.com \r\n";
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
                    
                    $header = "From:testmakos@gmail.com \r\n";
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
                    
                    $header = "From:testmakos@gmail.com \r\n";
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
        
        function getTaskCompleted()
        {
               $data = array(); 
               $_POST = $_REQUEST;      
                $this->load->library('form_validation');
                $this->form_validation->set_rules('driver_id', 'driver ',  'trim|required');
                $this->form_validation->set_rules('date', 'date',  'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["code"] = 2;  
        			$data["msg"] =  strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                    $this->load->model("product_model");
                    $result = $this->product_model->get_sale_by_user2(false,$this->input->post("driver_id"),$this->input->post("date"));
                    if(!empty($result))
                    {
                              $data["code"] = 1;  
   			                  $data["msg"]="Completed Task";
   			                  $data['details']=$result;
                    }else{
                              $data["code"] = 2;  
   			                  $data["msg"]="data not found";
   			                  $data['details']=array();
                        
                    }
                    
                }
                $data['request']=$_POST;
                echo json_encode($data);
        }
        
        public function ChangeDutyStatus(){
               $data = array(); 
               $_POST = $_REQUEST;      
                $this->load->library('form_validation');
                $this->form_validation->set_rules('driver_id', 'driver ',  'trim|required');
                $this->form_validation->set_rules('onduty', 'status',  'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["code"] = 2;  
        			$data["msg"] =  strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                    $result = $this->db->query("update driver set on_duty='".$this->input->post("onduty")."' where driver_id=".$this->input->post("driver_id"));  
                    if(!empty($result))
                    {
                              $data["code"] = 1;  
                              if($this->input->post("onduty")==1)
   			                    $data["msg"]="Driver is Online";
   			                  else
   			                    $data["msg"]="Driver is Offline";
   			                  $data['details']=array();
                    }else{
                              $data["code"] = 2;  
   			                  $data["msg"]="data not found";
   			                  $data['details']=array();
                        
                    }
                    
                }
                $data['request']=$_POST;
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
        		    $data["code"] = 2;  
        			$data["msg"] = strip_tags($this->form_validation->error_string());                                        
        		}else
                {
					$this->load->model("product_model");
                    
                    $rs=$this->product_model->get_sale_order_by_id($this->input->post("sale_id"));
                    if(empty($rs))
                    {
                        $data["code"] = 2;  
        			    $data["msg"] ="Order not found";
        			    
                    }else{
                        $data["code"] = 1;  
        			    $data["msg"] ="Order details";
        			    $data['details']['item'] = $this->product_model->get_sale_order_items_android($this->input->post("sale_id"));				
        			    $data['details']['sale'] = $rs;
                    }
                    
                    
                    
				}	
				$data['request']=$_POST;
				echo json_encode($data);  					
}

    public function cancel_order(){
                $data = array(); 
                $_POST = $_REQUEST;      
                
                $this->load->library('form_validation');				
			    $this->form_validation->set_rules('sale_id', 'Sale ID',  'trim|required');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                $this->form_validation->set_rules('driver_id', 'User ID',  'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["code"] = 2;  
        			$data["msg"] =  strip_tags($this->form_validation->error_string());
        		}else
                {
                    $q = $this->db->query("Select * from registers where user_id = '".$this->input->post("user_id")."'");  
				    $details1=$this->db->query("SELECT * FROM sale where sale_id = '".$this->input->post("sale_id")."' "); 
                    $details=$details1->row();
                    
                    $check=$this->db->query("Update sale set status = 3 where user_id = '".$this->input->post("user_id")."' and  sale_id = '".$this->input->post("sale_id")."' ");    
                    if($check)
                    {
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
                                                    $user = $q->row();  
                            $message["title"] = "Cancel  Order";
                            $message["body"] = "Your order Number '".$this->input->post("sale_id")."' cancel successfully";
                            $message["image"] = "";
                            $message["created_at"] = date("Y-m-d h:i:s"); 
                            $message["obj"] = "";
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                           if($user->user_fcm_code != ""){
                            $result = $gcm->send_notification(array($user->user_fcm_code),$message ,"android");
                            
                            }
                             if($user->user_ios_token != ""){
                            $result = $gcm->send_notification(array($user->user_ios_token),$message ,"ios");
                             }
                             
                    $sale_items=$this->db->query("Select * from sale_items where sale_id = '".$this->input->post("sale_id")."' "); 
                    $sales=$sale_items->result();
                    if(!empty($sales))
                    {
                        foreach($sales as $row)
                        {
                            $product_id=$row->product_id;
                            $qty=$row->qty;
                            $this->db->query("update purchase SET  qty=qty+'$qty' where product_id ='$product_id'");
                            
                        }    
                    }
                        $data["code"] = 1;  
        			    $data["msg"] = "Order cancel successfully";
                    }else{
                        $data["code"] = 2;  
        			    $data["msg"] = "Unable to cancel order";
                    }
                }
                $data['details']=array();
                $data['request']=$_POST;
                echo json_encode($data);
        }
        
        
    public function delivered_order_complete(){
                $data = array(); 
                $_POST = $_REQUEST;      
                
                $this->load->library('form_validation');				
			    $this->form_validation->set_rules('sale_id', 'Sale ID',  'trim|required');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                $this->form_validation->set_rules('driver_id', 'User ID',  'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["code"] = 2;  
        			$data["msg"] =  strip_tags($this->form_validation->error_string());
        		}else
                {
                    $q = $this->db->query("Select * from registers where user_id = '".$this->input->post("user_id")."'");  
				    $details1=$this->db->query("SELECT * FROM sale where sale_id = '".$this->input->post("sale_id")."' "); 
                    $details=$details1->row();
                    $order=$details1->row();
                    $check1=$this->db->query("Update sale set status = 4 where user_id = '".$this->input->post("user_id")."' and  sale_id = '".$this->input->post("sale_id")."' ");    
                    if($check1)
                    {
                $check2=$this->db->query("update sale set status = 4 where sale_id = '".$this->input->post("sale_id")."'");
$this->db->query("INSERT INTO delivered_order (sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method,total_net_amt)
SELECT sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method,total_net_amt FROM sale
where sale_id = '".$this->input->post("sale_id")."'"); 
                
                if($order->cash_back>0)
                {
                    $this->db->insert("wallet_history", array("user_id"=>$order->user_id,
                                            "amount"=>$order->cash_back,
                                             "Status"=>1,                                          
                                            ));
                            $this->db->query("UPDATE registers  SET wallet=wallet+'$order->cash_back' WHERE  user_id= '$order->user_id'");

                }
                
                if($check2)
                {
                    $sale_items=$this->db->query("Select * from sale_items where sale_id = '".$this->input->post("sale_id")."' ");    
                    $sales=$sale_items->result();
                    if(!empty($sales))
                    {
                        foreach($sales as $row)
                        {
                            $product_id=$row->product_id;
                            $qty=$row->qty;
                            $this->db->query("update purchase SET  qty=qty-'$qty' where product_id ='$product_id'");
                            
                        }    
                    }
                    
                }
                
                    $sale_items_count=$this->db->query("SELECT count(sale_id) as order_count from sale where status = 4 AND user_id ='".$order->user_id."'");
                    $sale_items_count1=$sale_items_count->row();

                    if($sale_items_count1->order_count==1)
                    {
                        $user_details=$q->row();
                        $money=$this->db->query("Select * from global_setting where globe_setting_id='".$user_details->globe_setting_id."'");																		
                        $get_money=$money->row();
                        
                        $this->db->query("UPDATE registers  SET wallet=wallet+'$get_money->new_user_reg_amt' WHERE  user_id= '$order->user_id' ");
                                $this->db->insert("wallet_history", array("user_id"=>$order->user_id,
                                                "amount"=>$get_money->new_user_reg_amt,
                                                 "Status"=>1,                                          
                                                ));
                                                
                        if(!empty($user_details->from_referral_code))
                        {
                            $user_refrral1=$this->db->query("SELECT user_id FROM registers WHERE  referral_code='".$user_details->from_referral_code."'");																		    
                            $user_refrral=$user_refrral1->row();
                            
                            if($user_refrral)
                            {
                                $this->db->query("UPDATE registers  SET wallet=wallet+'$get_money->refer_and_earn' WHERE  user_id= '$user_refrral->user_id' ");
                                $this->db->insert("wallet_history", array("user_id"=>$user_refrral->user_id,
                                                "amount"=>$get_money->refer_and_earn,
                                                 "Status"=>1,                                          
                                                ));
                            }
                        }
                    }
                            $user = $q->row();  
                            
                            $message["title"] = "Order delivery  completed ";
                            $message["body"] = "Your order Number '".$order->sale_id."' Delivered successfully. Thank you for being with us";
                            $message["body"] = "Your order Number '".$this->input->post("sale_id")."' cancel successfully";
                            $message["image"] = "";
                            $message["created_at"] = date("Y-m-d h:i:s"); 
                            $message["obj"] = "";
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                           if($user->user_fcm_code != ""){
                            $result = $gcm->send_notification(array($user->user_fcm_code),$message ,"android");
                            
                            }
                             if($user->user_ios_token != ""){
                            $result = $gcm->send_notification(array($user->user_ios_token),$message ,"ios");
                             }
                             
                    $sale_items=$this->db->query("Select * from sale_items where sale_id = '".$this->input->post("sale_id")."' "); 
                    $sales=$sale_items->result();
                    if(!empty($sales))
                    {
                        foreach($sales as $row)
                        {
                            $product_id=$row->product_id;
                            $qty=$row->qty;
                            $this->db->query("update purchase SET  qty=qty+'$qty' where product_id ='$product_id'");
                            
                        }    
                    }
                        $data["code"] = 1;  
        			    $data["msg"] = "Order delivery  completed successfully";
                    }else{
                        $data["code"] = 2;  
        			    $data["msg"] = "Unable to  completed order";
                    }
                }
                $data['details']=array();
                $data['request']=$_POST;
                echo json_encode($data);
        }
        
        
    public function confirm_order(){
                $data = array(); 
                $_POST = $_REQUEST;      
                
                $this->load->library('form_validation');				
			    $this->form_validation->set_rules('sale_id', 'Sale ID',  'trim|required');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                $this->form_validation->set_rules('driver_id', 'User ID',  'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["code"] = 2;  
        			$data["msg"] =  strip_tags($this->form_validation->error_string());
        		}else
                {
                    $q = $this->db->query("Select * from registers where user_id = '".$this->input->post("user_id")."'");  
				    $details1=$this->db->query("SELECT * FROM sale where sale_id = '".$this->input->post("sale_id")."' "); 
                    $details=$details1->row();
                    $check=$this->db->query("Update sale set status = 1 where user_id = '".$this->input->post("user_id")."' and  sale_id = '".$this->input->post("sale_id")."' ");    
                    if($check)
                    {
                            $user = $q->row();  
                            $message["title"] = "Confirmed  Order";
                            $message["body"] = "Your order Number '".$this->input->post("sale_id")."' confirmed successfully";
                            $message["image"] = "";
                            $message["created_at"] = date("Y-m-d h:i:s"); 
                            $message["obj"] = "";
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                           if($user->user_fcm_code != ""){
                            $result = $gcm->send_notification(array($user->user_fcm_code),$message ,"android");
                            
                            }
                             
                             if($user->user_ios_token != ""){
                                $result = $gcm->send_notification(array($user->user_ios_token),$message ,"ios");
                             }
                        $data["code"] = 1;  
        			    $data["msg"] = "Order confirmed successfully";
                    }else{
                        $data["code"] = 2;  
        			    $data["msg"] = "Unable to confirmed order";
                    }
                }
                $data['details']=array();
                $data['request']=$_POST;
                echo json_encode($data);
        }
        
     public function out_order(){
                $data = array(); 
                $_POST = $_REQUEST;      
                
                $this->load->library('form_validation');				
			    $this->form_validation->set_rules('sale_id', 'Sale ID',  'trim|required');
                $this->form_validation->set_rules('user_id', 'User ID',  'trim|required');
                $this->form_validation->set_rules('driver_id', 'User ID',  'trim|required');
                
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["code"] = 2;  
        			$data["msg"] =  strip_tags($this->form_validation->error_string());
        		}else
                {
                    $q = $this->db->query("Select * from registers where user_id = '".$this->input->post("user_id")."'");  
				    $details1=$this->db->query("SELECT * FROM sale where sale_id = '".$this->input->post("sale_id")."' "); 
                    $details=$details1->row();
                    $check=$this->db->query("Update sale set status = 2 where user_id = '".$this->input->post("user_id")."' and  sale_id = '".$this->input->post("sale_id")."' ");    
                    if($check)
                    {
                            $user = $q->row();  
                            $message["title"] = "Delivered  Order";
                            $message["body"] = "Your order Number '".$this->input->post("sale_id")."' Delivered successfully. Thank you for being with us";
                            $message["image"] = "";
                            $message["created_at"] = date("Y-m-d h:i:s"); 
                            $message["obj"] = "";
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                           if($user->user_fcm_code != ""){
                            $result = $gcm->send_notification(array($user->user_fcm_code),$message ,"android");
                            
                            }
                             if($user->user_ios_token != ""){
                            $result = $gcm->send_notification(array($user->user_ios_token),$message ,"ios");
                             }
                             
                        $data["code"] = 1;  
        			    $data["msg"] = "Delivered  Order successfully";
                    }else{
                        $data["code"] = 2;  
        			    $data["msg"] = "Unable to Delivered order";
                    }
                }
                $data['details']=array();
                $data['request']=$_POST;
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
    
    
    
       public function ForgotPassword(){
            $data = array();
            $_POST = $_REQUEST; 
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'Email', 'trim|required');
            if ($this->form_validation->run() == FALSE) 
            {
               $data["code"] = 2;  
               $data["msg"] = 'Warning! : '.strip_tags($this->form_validation->error_string());
                        
            }else
            {
                   $request = $this->db->query("Select * from driver where email = '".$this->input->post("email")."' limit 1");
                   if($request->num_rows() > 0){
                                
                                $user = $request->row();
                                $token = rand(1111111111,9999999999);
                                $this->db->update("driver",array("password"=>md5($token)),array("driver_id"=>$user->driver_id)); 
                                $this->load->library('email');
                                
                                 $email = $user->email;
                                 $name = $user->last_name.' '.$user->first_name;
                                 $return = $this->send_email_verified_mail($email,$token,$name);
                                if (!$return)
                                {
                                      $data["code"] = 2;    
                                      $data["msg"] = 'Warning! : Something is wrong with system to send mail.';

                                }else{
                                      $data["code"] = 1;  
                                      $data["msg"] = 'Success! : New password  sent to your email address please check.';
    
                                }
                   }else{
                              $data["code"] = 2;  
                              $data["msg"] = 'Warning! : No user found with this email.';
    
                   }
                }
                $data['request']=$_POST;
                echo json_encode($data);
        }
        
    public function send_email_verified_mail($email,$token,$name)
    {
        $header = "From:testmakos@gmail.com \r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";
        $subject = "Forgot password request.";
        $body = "Hi ".$name.","." <br><br> Your new password is ".$token;
        return mail ($email,$subject,$body,$header);
                    
                      
    }
    /* End Forgot Password */   
        public function delivery_boy_login(){
            $data = array();            
            $_POST = $_REQUEST;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('email', 'email', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');  
            $this->form_validation->set_rules('fcm_code','fcm_code','trim|required'); 
            
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["code"] = 2;  
        			$data["msg"] =  strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                   $path=base_url()."uploads/driver/";
                    $q = $this->db->query("SELECT driver_id, on_duty, first_name, last_name, email, phone, username, transport_type, licence_plate, color, status, date_created, date_modified, last_login, location_lat, location_lng, token, concat('$path',profile_photo) as profile_photo, driver_address from driver where email= '".$this->input->post('email')."' AND password='".md5($this->input->post('password'))."'");                    
                    if (!empty($q->result()))
                    {
                        $row = $q->row(); 
                        
                        if(!empty($row) && $row->status=="Deactive")
                        {
                            $data["code"] = 2;
   			                $data["msg"] = 'Your account currently inactive.Please Contact Admin';
                            
                        }                       
                        else
                        {
                            if(!empty($row))
                            {
                            $this->db->query("update driver set fcm_token='".$this->input->post("fcm_code")."' where driver_id=".$row->driver_id);    
                            }
                            
                            //echo $this->db->last_query();exit();
                            $data["code"] = 1;  
   			                $data["details"]=$q->result();
   			                $data["msg"] = 'Login Successful';
   			                   
                        }
                    }
                    else
                    {
                              $data["code"] = 2;  
   			                  $data["msg"] = 'Login failed. either username or password is incorrect';
                    }
                    $data['request']=$_POST;
                   
                    
                }
           echo json_encode($data);
            
}

public function getTaskByDate(){
            $data = array();            
            $_POST = $_REQUEST;
            $this->load->library('form_validation');
            $this->form_validation->set_rules('date', 'date', 'trim|required');
            $this->form_validation->set_rules('driver_id', 'driver', 'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		    $data["code"] = 2;
        			$data["msg"] =  strip_tags($this->form_validation->error_string());
                    
        		}else
                {
                    
                    $q = $this->db->query("SELECT sale.*,registers.user_fullname,registers.user_phone from sale INNER JOIN registers ON registers.user_id= sale.user_id where assign_driver= '".$this->input->post('driver_id')."' AND on_date='".$this->input->post('date')."' AND sale.status NOT IN (3,4) AND ((payment_method='Online Payment' AND txn_id IS NOT NULL) or (payment_method='COD' AND txn_id IS NULL)) ");                    
                    
                    if(!empty($q->row()))
                    {
                            $data["code"] = 1;
                            $data["details"]=$q->result();
                            $data["msg"] = 'Today tasks';
                    
                    }
                    else
                    {
                              $data["code"] = 2;
   			                  $data["msg"] = 'No task for the day';
                    }
                   
                    
                }
                $data['request']=$_POST;
           echo json_encode($data);
            
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
