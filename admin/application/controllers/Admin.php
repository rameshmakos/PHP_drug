<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {
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
    function signout(){
        $this->session->sess_destroy();
        redirect("admin");
   } public function getUserDetails($id)
	{
	   if(_is_user_login($this))
       {
            $q = $this->db->query("select * from `registers` WHERE user_id=".$id);
            $data['user']=$q->row();
            if(isset($_REQUEST["savecat"]))
            {
                /*
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('cat_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('cat_id', 'Categories Id', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                if ($this->form_validation->run() == FALSE)
        		{
        		   if($this->form_validation->error_string()!=""){
        			  $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                   }
        		}
        		else
        		{
                    $this->load->model("category_model");
                    $this->category_model->edit_category(); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your category saved successfully...
                                    </div>');
                    redirect('admin/registers');
               	}*/
               	
            }
	   	   $this->load->view('admin/product/userdetails',$data);
        }
        else
        {
            redirect('admin');
        }
	}
	
    
    public function test()
    {
        $this->load->helper('shop_helper');
        print_r(_get_name_product_shops(1000));
    }
	public function index()
	{
		if(_is_user_login($this)){
            redirect(_get_user_redirect($this));
        }else{
            
            $data = array("error"=>"");       
            if(isset($_POST))
            {                
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('email', 'Email', 'trim|required');
                $this->form_validation->set_rules('password', 'Password', 'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		   if($this->form_validation->error_string()!=""){
        			$data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    }
        		}else
                {
                   
                    $q = $this->db->query("Select * from `users` where (`user_email`='".$this->input->post("email")."')
                    and user_password='".md5($this->input->post("password"))."' and user_login_status='1'");
                    
                   
                    if ($q->num_rows() > 0)
                    {
                        $row = $q->row(); 
                        if($row->user_status == "0")
                        {
                            $data["error"] = '<div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> Your account currently inactive.</div>';
                        }
                        else
                        {
                            $newdata = array(
                                                   'user_name'  => $row->user_fullname,
                                                   'user_email' => $row->user_email,
                                                   'logged_in' => TRUE,
                                                   'user_id'=>$row->user_id,
                                                   'user_type_id'=>$row->user_type_id
                                                  );
                            $this->session->set_userdata($newdata);
                            redirect(_get_user_redirect($this));
                         
                        }
                    }
                    else
                    {
                        $data["error"] = '<div class="alert alert-danger alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> Invalid User and password. </div>';
                    }
                   
                    
                }
            }
            $data["active"] = "login";            
            $this->load->view("admin/login",$data);
        }
	}
    public function dashboard(){
        if(_is_user_login($this)){
            $data = array();

            //$this->load->model('common_model');                
            //$data["shop_list"] = $this->common_model->get_shop_list();           

            $this->load->model("product_model");
            $date = date("Y-m-d");
            $data["today_orders"] = $this->product_model->get_sale_orders(" and sale.on_date = '".$date."' ");
            $nexday = date('Y-m-d', strtotime(' +1 day'));
            $data["nextday_orders"] = $this->product_model->get_sale_orders(" and sale.on_date = '".$nexday."' ");
            $this->load->view("admin/dashboard",$data);


        }
    }
    public function orders(){
        if(_is_user_login($this)){
            $data = array();
            $this->load->model("product_model");
            $fromdate = date("Y-m-d");
            $todate = date("Y-m-d");
            $data['date_range_lable'] = $this->input->post('date_range_lable');
           
             $filter = "";
            if($this->input->post("date_range")!=""){
				$filter = $this->input->post("date_range");
			    $dates = explode(",",$filter);                
                $fromdate =  date("Y-m-d", strtotime($dates[0]));
                $todate =  date("Y-m-d", strtotime($dates[1])); 
                $filter = " and sale.on_date >= '".$fromdate."' and sale.on_date <= '".$todate."' ";
            }
            $data["today_orders"] = $this->product_model->get_sale_orders($filter);
            
            $this->load->view("admin/orders/orderslist",$data);
        }
    }
    public function confirm_order($order_id){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if(!empty($order)){
               if(!empty($order->zip))
                {
                    $driver=$this->db->query("SELECT * FROM driver WHERE zip LIKE '%".$order->zip."%'");  
                    $d_id=$driver->row();
                    if(!empty($d_id))
                    {
                                $this->db->query("update sale set assign_driver='$d_id->driver_id' where sale_id = '".$order_id."'");        
                                $message["title"] = "New Order";
                                $message["body"] = "You assigned new order Number '".$order_id."' successfully";
                                $message["image"] = "";
                                $message["created_at"] = date("Y-m-d h:i:s"); 
                                $message["obj"] = "";
                            
                                $this->load->helper('gcm_helper');
                                $gcm = new GCM();   
    
                               if($d_id->fcm_token != "")
                               {
                               
                                $result = $gcm->send_notification(array($d_id->fcm_token),$message ,"android" ,1);
                                
                               }
                    }
                    
                    
                } 
                /* add money referal account*/
                $query1=$this->db->query("SELECT * FROM sale WHERE user_id = '".$order->user_id."'");

                    /*
                    if($query1->num_rows()==1)
                    {
                            $get_referral_details=$this->db->query("SELECT * FROM registers,global_setting WHERE registers.globe_setting_id=global_setting.globe_setting_id AND user_id = '".$order->user_id."'");
                            foreach($get_referral_details->result_array() as $row)
                            {
                            }
                            
                            if(!empty($row['refer_and_earn']) && !empty($row['from_referral_code']))
                            {
                            $this->db->query("UPDATE registers SET wallet=wallet+'".$row['refer_and_earn']."' WHERE referral_code=".$row['from_referral_code']);
                            }                                                                       
                    }*/


                
                /**/
                $this->db->query("update sale set delivery_datetime=CURRENT_TIMESTAMP,status = 1 where sale_id = '".$order_id."'");
				/**/
				$details1=$this->db->query("SELECT * FROM sale where sale_id = '".$order_id."'");
                $details=$details1->row();
                /*
                if($details->cash_back>0)
                {
                    $this->db->insert("wallet_history", array("user_id"=>$details->user_id,
                                            "amount"=>$details->cash_back,
                                             "Status"=>1,                                          
                                            ));
                            $this->db->query("UPDATE registers  SET wallet=wallet+'$details->cash_back' WHERE  user_id= '$details->user_id'");

                }*/
                
				/**/
				
				
                
                 $q = $this->db->query("Select * from registers where user_id = '".$order->user_id."'");
                $user = $q->row();
                
                
                                $message["title"] = "Confirmed  Order";
                                $message["body"] = "Your order Number '".$order->sale_id."' confirmed successfully";
                                $message["image"] = "";
                                $message["created_at"] = date("Y-m-d h:i:s"); 
                                $message["obj"] = "";
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                            if($user->user_fcm_code != ""){
                            
                            $result = $gcm->send_notification(array($user->user_fcm_code),$message ,"android",false);
                            }
                             if($user->user_ios_token != ""){
                            $result = $gcm->send_notification(array($user->user_ios_token),$message ,"ios",false);
                             }
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order confirmed. </div>');
            }
            redirect("admin/orders");
        }
    }
    
    public function delivered_order($order_id){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if(!empty($order)){
                $this->db->query("update sale set delivery_datetime=CURRENT_TIMESTAMP,status = 2 where sale_id = '".$order_id."'");
               
                /* $this->db->query("INSERT INTO delivered_order (sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method)
SELECT sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method FROM sale
where sale_id = '".$order_id."'"); 
*/
                
                $q = $this->db->query("Select * from registers where user_id = '".$order->user_id."'");
                $user = $q->row();
                
                        $message["title"] = "Out for delivery order";
                        $message["body"] = "Your order Number '".$order->sale_id."' Delivered successfully. Thank you for being with us";
                        $message["image"] = "";
                        $message["created_at"] = date("Y-m-d h:i:s"); 
                        $message["obj"] = "";
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                            if($user->user_fcm_code != ""){
                            $result = $gcm->send_notification(array($user->user_fcm_code),$message ,"android",false);
                            }
                             if($user->user_ios_token != "")
                             {
                                $result = $gcm->send_notification(array($user->user_ios_token),$message ,"ios",false);
                             }
                
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order delivered. </div>');
            }
            redirect("admin/orders");
        }
    }
    
    public function delivered_order_complete($order_id){
        if(_is_user_login($this)){
            
            
            
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if(!empty($order)){
                $check=$this->db->query("update sale set delivery_datetime=CURRENT_TIMESTAMP,status = 4 where sale_id = '".$order_id."'");
$this->db->query("INSERT INTO delivered_order (sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method,total_net_amt)
SELECT sale_id, user_id, on_date, delivery_time_from, delivery_time_to, status, note, is_paid, total_amount, total_rewards, total_kg, total_items, socity_id, delivery_address, location_id, delivery_charge, new_store_id, assign_to, payment_method,total_net_amt FROM sale
where sale_id = '".$order_id."'"); 
                
                if($order->cash_back>0)
                {
                    $this->db->insert("wallet_history", array("user_id"=>$order->user_id,
                                            "amount"=>$order->cash_back,
                                             "Status"=>1,                                          
                                            ));
                            $this->db->query("UPDATE registers  SET wallet=wallet+'$order->cash_back' WHERE  user_id= '$order->user_id'");

                }
                /*
                if($check)
                {
                    $sale_items=$this->db->query("Select * from sale_items where sale_id ='$order_id'");
                    $sales=$sale_items->result();
                    foreach($sales as $row)
                    {
                        $product_id=$row->product_id;
                        $qty=$row->qty;
                        $this->db->query("update purchase SET  qty=qty-'$qty' where product_id ='$product_id'");
                        
                    }
                }*/
                $q = $this->db->query("Select * from registers where user_id = '".$order->user_id."'");
                
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
                
                        $message["title"] = "Delivered  Order";
                        $message["body"] = "Your order Number '".$order->sale_id."' Delivered successfully. Thank you for being with us";
                        $message["image"] = "";
                        $message["created_at"] = date("Y-m-d h:i:s"); 
                        $message["obj"] = "";
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                            if($user->user_fcm_code != ""){
                            $result = $gcm->send_notification(array($user->user_fcm_code),$message ,"android",false);
                            }
                             if($user->user_ios_token != ""){
                            $result = $gcm->send_notification(array($user->user_ios_token),$message ,"ios",false);
                             }
                
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order delivered. </div>');
            }
            redirect("admin/orders");
        }
    }
    public function cancle_order($order_id){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if(!empty($order)){
                $this->db->query("update sale set delivery_datetime=CURRENT_TIMESTAMP,status = 3 where sale_id = '".$order_id."'");
                
                 // $q = $this->db->query("Select * from users where user_id = '".$order->user_id."'");  
                 
                 $q = $this->db->query("Select * from registers where user_id = '".$order->user_id."'");  
				 
				 $details1=$this->db->query("SELECT * FROM sale where sale_id = '".$order_id."'");
                $details=$details1->row();
                
                if($details)
                {
                    $sale_items=$this->db->query("Select * from sale_items where sale_id ='$order_id'");
                    $sales=$sale_items->result();
                    foreach($sales as $row)
                    {
                        $product_id=$row->product_id;
                        $qty=$row->qty;
                        $this->db->query("update purchase SET  qty=qty+'$qty' where product_id ='$product_id'");
                        
                    }
                }
                
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
                                $message["body"] = "Your order Number '".$order->sale_id."' cancel successfully";
                                $message["image"] = "";
                                $message["created_at"] = date("Y-m-d h:i:s"); 
                                $message["obj"] = "";
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   
                           // $result = $gcm->send_notification(array("c1C459gNffg:APA91bEXYsxjGF_B5apBYErThfhVNFsabGRCwSCXlD69YOXGAtDlAsZgsPtSLRjtmd54fAkoL7LIPJXy_nEj14Z7tMMZprCRn6A4BE2jGl_LBpqKFtZoKHCOVMEq3iOFoK9-vfHf5m5M"),$message ,"android");
                           if($user->user_fcm_code != ""){
                            //$result = $gcm->send_notification(array($user->user_fcm_code),$message ,"android");
                            $result = $gcm->send_notification(array($user->user_fcm_code),$message ,"android",false);
                            
                            }
                             if($user->user_ios_token != ""){
                            $result = $gcm->send_notification(array($user->user_ios_token),$message ,"ios",false);
                             }
                
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order Cancle. </div>');
            }
            redirect("admin/orders");
        }
    }
    
    public function delete_order($order_id){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $order = $this->product_model->get_sale_order_by_id($order_id);
            if(!empty($order)){
                $this->db->query("delete from sale where sale_id = '".$order_id."'");
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> Order deleted. </div>');
            }
            redirect("admin/orders");
        }
    }
    public function orderdetails($order_id){
        if(_is_user_login($this)){
            
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('driver_id', 'driver', 'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		   if($this->form_validation->error_string()!=""){
        			$data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    }
        		}else
                {
                    
                $check=$this->db->query("update sale set assign_driver='".$this->input->post("driver_id")."' where sale_id = '".$order_id."'");                
                if($check)
                {
                    
                    
                        $query=$this->db->query("select * from driver where driver_id=".$this->input->post("driver_id"));
                        $driver_details=$query->row();
                            $message["title"] = "New Order";
                                $message["body"] = "You assigned new order Number '".$order_id."' successfully";
                                $message["image"] = "";
                                $message["created_at"] = date("Y-m-d h:i:s"); 
                                $message["obj"] = "";
                            
                            $this->load->helper('gcm_helper');
                            $gcm = new GCM();   

                           if($driver_details->fcm_token != "")
                           {
                           
                            $result = $gcm->send_notification(array($driver_details->fcm_token),$message ,"android" ,1);
                            
                            }
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong>Driver assigned successfully...
                                    </div>');    
                                    redirect("admin/orders");
                }else{
                    $this->session->set_flashdata("message",'<div class="alert alert-danger alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> unable assign to driver...
                                    </div>');
                 redirect("admin/orders");                   
                }
                
                }                    
            }
            $data = array();
            $this->load->model("product_model");
            $data["order"] = $this->product_model->get_sale_order_by_id($order_id);
            $data["order_items"] = $this->product_model->get_sale_order_items($order_id);
			
            $this->load->view("admin/orders/orderdetails",$data);
        }
    }
    public function change_status(){
        $table = $this->input->post("table");
        $id = $this->input->post("id");
        $on_off = $this->input->post("on_off");
        $id_field = $this->input->post("id_field");
        $status = $this->input->post("status");
        
        $this->db->update($table,array("$status"=>$on_off),array("$id_field"=>$id));
    }
/*=========USER MANAGEMENT==============*/   
    public function user_types(){
        $data = array();
        if(isset($_POST))
            {
                
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('user_type', 'User Type', 'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		   if($this->form_validation->error_string()!=""){
        			$data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                    }
        		}else
                {
                        $user_type = $this->input->post("user_type");
                        
                            $this->load->model("common_model");
                            $this->common_model->data_insert("user_types",array("user_type_title"=>$user_type));
                            $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Success!</strong> User Type added Successfully
                                </div>') ;
                             redirect("admin/user_types/");   
                        
                }
            }
        
        $this->load->model("users_model");
        $data["user_types"] = $this->users_model->get_user_type();
        $this->load->view("admin/user_types",$data);
    }
    function user_type_delete($type_id){
        $data = array();
            $this->load->model("users_model");
            $usertype  = $this->users_model->get_user_type_id($type_id);
           if($usertype){
                $this->db->query("Delete from user_types where user_type_id = '".$usertype->user_type_id."'");
                redirect("admin/user_types");
           }
    }
    public function user_access($user_type_id){
        if($_POST){
               
                $this->load->library('form_validation');
                
                $this->form_validation->set_rules('user_type_id', 'User Type', 'trim|required');
                if ($this->form_validation->run() == FALSE) 
        		{
        		   if($this->form_validation->error_string()!=""){
        		      	$data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                  <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                </div>';
                 }
      		    }else{
      		        //$user_type_id = $this->input->post("user_type_id");
      		        $this->load->model("common_model");
                    $this->common_model->data_remove("user_type_access",array("user_type_id"=>$user_type_id));
                    
                    $sql = "Insert into user_type_access(user_type_id,class,method,access) values";
                    $sql_insert = array();
                    foreach(array_keys($_POST["permission"]) as $controller){
                        foreach($_POST["permission"][$controller] as $key=>$methods){
                            if($key=="all"){
                                $key = "*";
                            }
                            $sql_insert[] = "($user_type_id,'$controller','$key',1)";
                        }
                    }
                    $sql .= implode(',',$sql_insert)." ON DUPLICATE KEY UPDATE access=1";
                    $this->db->query($sql);
      		    }
        }
        $data['user_type_id'] = $user_type_id;
        $data["controllers"] = $this->config->item("controllers");
        $this->load->model("users_model");
        $data["user_access"] = $this->users_model->get_user_type_access($user_type_id);
        
        //$data["user_types"] = $this->users_model->get_user_type();
        $this->load->view("admin/user_access",$data);
    }
/*============USRE MANAGEMENT===============*/

  
/* ========== Categories =========== */
    public function addcategories()
	{
	   if(_is_user_login($this)){
	       
            $data["error"] = "";
            $data["active"] = "addcat";
            if(isset($_REQUEST["addcatg"]))
            {
                $this->load->library('form_validation');
                // if(!isset($_SESSION["shop_id"]))
                // {
                // 	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
                // }

                $this->form_validation->set_rules('cat_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
        		{
        		   if($this->form_validation->error_string()!=""){
        			  $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                    }
        		}
        		else
        		{
                    $this->load->model("category_model");
                    $this->category_model->add_category(); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/listcategories');
               	}
            }
	   	$this->load->view('admin/icon_categories/addcat',$data);
        }
        else
        {
            redirect('admin');
        }
	}
	
	public function add_header_categories()
	{
	   if(_is_user_login($this)){
	       
            $data["error"] = "";
            $data["active"] = "addcat";
            if(isset($_REQUEST["addcatg"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('cat_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
        		{
        		   if($this->form_validation->error_string()!=""){
        			  $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                    }
        		}
        		else
        		{
                    $this->load->model("category_model");
                    $this->category_model->add_header_category(); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/add_header_categories');
               	}
            }
	   	$this->load->view('admin/icon_categories/addcat',$data);
        }
        else
        {
            redirect('admin');
        }
	}
    
    public function editcategory($id)
	{
	   if(_is_user_login($this))
       {
            $q = $this->db->query("select * from `categories` WHERE id=".$id);
            $data["getcat"] = $q->row();
            
	        $data["error"] = "";
            $data["active"] = "listcat";
            if(isset($_REQUEST["savecat"]))
            {
                $this->load->library('form_validation');
                // if(!isset($_SESSION["shop_id"]))
                // {
                // 	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
                // }

                $this->form_validation->set_rules('cat_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('cat_id', 'Categories Id', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                if ($this->form_validation->run() == FALSE)
        		{
        		   if($this->form_validation->error_string()!=""){
        			  $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                   }
        		}
        		else
        		{
                    $this->load->model("category_model");
                    $this->category_model->edit_category(); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your category saved successfully...
                                    </div>');
                    redirect('admin/listcategories');
               	}
            }
	   	   $this->load->view('admin/categories/editcat',$data);
        }
        else
        {
            redirect('admin');
        }
	}
    
     public function edit_header_category($id)
	{
	   if(_is_user_login($this))
       {
            $q = $this->db->query("select * from `header_categories` WHERE id=".$id);
            $data["getcat"] = $q->row();
            
	        $data["error"] = "";
            $data["active"] = "listcat";
            if(isset($_REQUEST["savecat"]))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('cat_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('cat_id', 'Categories Id', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                if ($this->form_validation->run() == FALSE)
        		{
        		   if($this->form_validation->error_string()!=""){
        			  $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
                   }
        		}
        		else
        		{
                    $this->load->model("category_model");
                    $this->category_model->edit_header_category(); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your category saved successfully...
                                    </div>');
                    redirect('admin/header_categories');
               	}
            }
	   	   $this->load->view('admin/icon_categories/editcat',$data);
        }
        else
        {
            redirect('admin');
        }
	}
    
    public function listcategories()
	{
	   if(_is_user_login($this)){
	       $data["error"] = "";
	       $data["active"] = "listcat";
           $this->load->model("category_model");
           $data["allcat"] = $this->category_model->get_categories();
           $this->load->view('admin/categories/listcat',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function header_categories()
	{
	   if(_is_user_login($this)){
	       $data["error"] = "";
	       $data["active"] = "listcat";
           $this->load->model("category_model");
           $data["allcat"] = $this->category_model->get_header_categories();
           $this->load->view('admin/icon_categories/listcat',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function deletecat($id)
	{
	   if(_is_user_login($this)){
	        
            $this->db->delete("categories",array("id"=>$id));
            $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your item deleted successfully...
                                    </div>');
            redirect('admin/listcategories');
        }
        else
        {
            redirect('admin');
        }
    }
    
    public function delete_header_categories($id)
	{
	   if(_is_user_login($this)){
	        
            $this->db->delete("header_categories",array("id"=>$id));
            $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your item deleted successfully...
                                    </div>');
            redirect('admin/header_categories');
        }
        else
        {
            redirect('admin');
        }
    }

      
/* ========== End Categories ========== */    
/* ========== Products ==========*/
function products(){
        $this->load->model("product_model");
        $data["products"]  = $this->product_model->get_products();
        
        $this->load->view("admin/product/list",$data);    
}
 
 function header_products(){
        $this->load->model("product_model");
        $data["products"]  = $this->product_model->get_header_products();
        $this->load->view("admin/icon_product/list",$data);    
}

function edit_products($prod_id){
	   if(_is_user_login($this)){
	    
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('prod_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                $this->form_validation->set_rules('price', 'price', 'trim|required|numeric|regex_match[/^[0-9]+$/]');
                $this->form_validation->set_rules('surfcity_price', 'surfcity price', 'trim|required|numeric|regex_match[/^[0-9]+$/]');
         //       $this->form_validation->set_rules('subscription_price', 'subscription price', 'trim|required|numeric|regex_match[/^[0-9]+$/]');
                $this->form_validation->set_rules('cashback', 'cashback', 'trim|required|numeric|regex_match[/^[0-9]+$/]');
                $this->form_validation->set_rules('qty', 'qty', 'trim|required|numeric|regex_match[/^[0-9]+$/]'); 
                $this->form_validation->set_rules('rewards', 'rewards', 'trim|required|numeric|regex_match[/^[0-9]+$/]'); 
                
                if ($this->form_validation->run() == FALSE)
        		{
        		   if($this->form_validation->error_string()!=""){
        			  $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                   }
        		}
        		else
        		{
        			$top_selling  	=   '0';
                    $offer_product  =   '0';

                    if($this->input->post("top_selling")==null AND $this->input->post("top_selling")!='1')
                    {
                       $top_selling   =   '0';     
                    }
                    else
                    {
                        $top_selling   =   '1';   
                    }     

                    if($this->input->post("offer_product")==null AND $this->input->post("offer_product")!='1')
                    {
                       $offer_product   =   '0';     
                    }
                    else
                    {
                        $offer_product   =   '1';   
                    } 
                    
                    $this->load->model("common_model");
                    $array =array( 
                    "product_name"=>$this->input->post("prod_title"), 
                    "category_id"=>$this->input->post("parent"),
                    "in_stock"=>$this->input->post("prod_status"),
                    "product_description"=>$this->input->post("product_description"),
                    
                    "price"=>$this->input->post("price"),
                    "surfcity_price"=>$this->input->post("surfcity_price"),
                    "subscription_price"=>$this->input->post("surfcity_price"),
                    "unit_value"=>$this->input->post("qty"),
                    "unit"=>$this->input->post("unit"), 
                    
                    "price1"=>$this->input->post("price1"),
                    "surfcity_price1"=>$this->input->post("surfcity_price1"),
                    "subscription_price1"=>$this->input->post("subscription_price1"),
                    "unit_value1"=>$this->input->post("qty1"),
                    "unit1"=>$this->input->post("unit1"), 
                    
                    "price2"=>$this->input->post("price2"),
                    "surfcity_price2"=>$this->input->post("surfcity_price2"),
                    "subscription_price2"=>$this->input->post("subscription_price2"),
                    "unit_value2"=>$this->input->post("qty2"),
                    "unit2"=>$this->input->post("unit2"), 
                    
                    "cashback"=>$this->input->post("cashback"),
                    "rewards"=>$this->input->post("rewards"),
                    //"shop_id"=>$_SESSION["shop_id"],
                     "shop_id"=>$this->input->post("shop_id"),   
                    "top_selling"=>$top_selling,
                    "offer_product"=>$offer_product,
	"brand_id"=>$this->input->post("brand_id"),
    "composition_id"=>$this->input->post("composition_id"),
                    ); 
                    
                    if($_FILES["prod_img"]["size"] > 0){
                        $config['upload_path']          = './uploads/products/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg|jfif';
                        $this->load->library('upload', $config);
        
                        if ( ! $this->upload->do_upload('prod_img'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $array["product_image"]=$img_data['file_name'];
                        }                        
                   }
                    
                    $this->common_model->data_update("products",$array,array("product_id"=>$prod_id)); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/products');
               	}
            }
            $this->load->model("product_model");
            $pro=$this->product_model->get_product_by_id($prod_id);
            
            if($pro->price1==0)$pro->price1='';
            if($pro->surfcity_price1==0)$pro->surfcity_price1='';
            if($pro->subscription_price1==0)$pro->subscription_price1='';
            if($pro->unit_value1==0)$pro->unit_value1='';
            if($pro->price2==0)$pro->price2='';
            if($pro->surfcity_price2==0)$pro->surfcity_price2='';
            if($pro->subscription_price2==0)$pro->subscription_price2='';
            if($pro->unit_value2==0)$pro->unit_value2='';
            //echo "<pre>";print_r($pro);exit();
            $data["product"] = $pro;
            $this->load->view("admin/product/edit",$data);
        }
        else
        {
            redirect('admin');
        }
    
}

function edit_header_products($prod_id){
	   if(_is_user_login($this)){
	    
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('prod_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
        		{
        		   if($this->form_validation->error_string()!=""){
        			  $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                   }
        		}
        		else
        		{
                    $this->load->model("common_model");
                    $array = array( 
                    "product_name"=>$this->input->post("prod_title"), 
                    "category_id"=>$this->input->post("parent"), 
                    "product_description"=>$this->input->post("product_description"),
                    "in_stock"=>$this->input->post("prod_status"),
                    "price"=>$this->input->post("price"),
                    "unit_value"=>$this->input->post("qty"),
                    "unit"=>$this->input->post("unit"),
                    "rewards"=>$this->input->post("rewards")
                    
                    );
                    if($_FILES["prod_img"]["size"] > 0){
                        $config['upload_path']          = './uploads/products/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg|jfif';
                        $this->load->library('upload', $config);
        
                        if ( ! $this->upload->do_upload('prod_img'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $array["product_image"]=$img_data['file_name'];
                        }
                        
                   }
                    
                    $this->common_model->data_update("header_products",$array,array("product_id"=>$prod_id)); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/header_products');
               	}
            }
            $this->load->model("product_model");
            $data["product"] = $this->product_model->get_header_product_by_id($prod_id);
            $this->load->view("admin/icon_product/edit",$data);
        }
        else
        {
            redirect('admin');
        }
    
}

function add_products(){
	   if(_is_user_login($this)){
	    
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                // if(!isset($_SESSION["shop_id"]))
                // {
                // 	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
                // }  
                $this->form_validation->set_rules('prod_title', 'categories title', 'trim|required');
                $this->form_validation->set_rules('parent', 'categories parent', 'trim|required');
                $this->form_validation->set_rules('price', 'price', 'trim|required|numeric|regex_match[/^[0-9]+$/]');
                $this->form_validation->set_rules('surfcity_price', 'surfcity price', 'trim|required|numeric|regex_match[/^[0-9]+$/]');
                //$this->form_validation->set_rules('subscription_price', 'subscription price', 'trim|required|numeric|regex_match[/^[0-9]+$/]');
                $this->form_validation->set_rules('cashback', 'cashback', 'trim|required|numeric|regex_match[/^[0-9]+$/]');
                $this->form_validation->set_rules('qty', 'qty', 'trim|required|numeric|regex_match[/^[0-9]+$/]'); 
                $this->form_validation->set_rules('rewards', 'rewards', 'trim|required|numeric|regex_match[/^[0-9]+$/]'); 
                
                if ($this->form_validation->run() == FALSE)
        		{
        		      if($this->form_validation->error_string()!="") { 
        			  $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                 }
                                   
        		}
        		else
        		{
        			$top_selling  	=   '0';
                    $offer_product  =   '0';

                    if($this->input->post("top_selling")==null OR $this->input->post("top_selling")!='1')
                    {
                       $top_selling   =   '0';     
                    }
                    else
                    {
                        $top_selling   =   '1';   
                    }     

                    if($this->input->post("offer_product")==null OR $this->input->post("offer_product")!='1')
                    {
                       $offer_product   =   '0';     
                    }
                    else
                    {
                        $offer_product   =   '1';   
                    } 

                    $this->load->model("common_model");
                    $array = array( 
                    "product_name"=>$this->input->post("prod_title"), 
                    "category_id"=>$this->input->post("parent"),
                    "in_stock"=>$this->input->post("prod_status"),
                    "product_description"=>$this->input->post("product_description"),
                    
                    "price"=>$this->input->post("price"),
                    "surfcity_price"=>$this->input->post("surfcity_price"),
                    "subscription_price"=>$this->input->post("surfcity_price"),
                    "unit_value"=>$this->input->post("qty"),
                    "unit"=>$this->input->post("unit"), 
                    
                    "price1"=>$this->input->post("price1"),
                    "surfcity_price1"=>$this->input->post("surfcity_price1"),
                    "subscription_price1"=>$this->input->post("subscription_price1"),
                    "unit_value1"=>$this->input->post("qty1"),
                    "unit1"=>$this->input->post("unit1"), 
                    
                    "price2"=>$this->input->post("price2"),
                    "surfcity_price2"=>$this->input->post("surfcity_price2"),
                    "subscription_price2"=>$this->input->post("subscription_price2"),
                    "unit_value2"=>$this->input->post("qty2"),
                    "unit2"=>$this->input->post("unit2"), 
                    
                    "cashback"=>$this->input->post("cashback"),
                    "rewards"=>$this->input->post("rewards"),
                    //"shop_id"=>$_SESSION["shop_id"],
                     "shop_id"=>$this->input->post("shop_id"),   
                    "top_selling"=>$top_selling,
                    "offer_product"=>$offer_product,
		"brand_id"=>$this->input->post("brand_id"),
    "composition_id"=>$this->input->post("composition_id"),
                    );

                    if($_FILES["prod_img"]["size"] > 0){
                        $config['upload_path']          = './uploads/products/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg|jfif';
                        $this->load->library('upload', $config);
        
                        if ( ! $this->upload->do_upload('prod_img'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $array["product_image"]=$img_data['file_name'];
                        }
                        
                   }
                    
                    //$this->common_model->data_insert("products",$array); 
                    
                    $product_id=$this->common_model->data_insert("products",$array);
                    
                    if($this->input->post("shop_id")==0)
                    {
                        $purchase_array['product_id']=$product_id;
                        $purchase_array['price']=0;
                        $purchase_array['qty']=0;
                        $purchase_array['unit']=$this->input->post("unit");
                        $purchase_array['store']=1;
                        $purchase_array['store_id_login']=1;                
                        $this->common_model->data_insert("purchase",$purchase_array);
                        
                    }
                    
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/products');
               	}
            }
            
            $this->load->view("admin/product/add");
        }
        else
        {
            redirect('admin');
        }   
    }

function add_header_products(){
	   if(_is_user_login($this)){
	    
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('prod_title', 'Categories Title', 'trim|required');
                $this->form_validation->set_rules('parent', 'Categories Parent', 'trim|required');
                 $this->form_validation->set_rules('price', 'price', 'trim|required');
                $this->form_validation->set_rules('qty', 'qty', 'trim|required'); 
                
                if ($this->form_validation->run() == FALSE)
        		{
        		      if($this->form_validation->error_string()!="") { 
        			  $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                 }
                                   
        		}
        		else
        		{
                    $this->load->model("common_model");
                    $array = array( 
                    "product_name"=>$this->input->post("prod_title"), 
                    "category_id"=>$this->input->post("parent"),
                    "in_stock"=>$this->input->post("prod_status"),
                    "product_description"=>$this->input->post("product_description"),
                    "price"=>$this->input->post("price"),
                    "unit_value"=>$this->input->post("qty"),
                    "unit"=>$this->input->post("unit"), 
                    "rewards"=>$this->input->post("rewards")
                    );
                    if($_FILES["prod_img"]["size"] > 0){
                        $config['upload_path']          = './uploads/products/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg|jfif';
                        $this->load->library('upload', $config);
        
                        if ( ! $this->upload->do_upload('prod_img'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $array["product_image"]=$img_data['file_name'];
                        }
                        
                   }
                    
                    $this->common_model->data_insert("header_products",$array); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/header_products');
               	}
            }
            
            $this->load->view("admin/icon_product/add");
        }
        else
        {
            redirect('admin');
        }
    
}

function delete_product($id){
        if(_is_user_login($this)){

            $this->db->query("Delete from products where product_id = '".$id."'");
             $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request deleted successfully...
                                    </div>');
            redirect("admin/products");
        }
        
}

function delete_header_product($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from header_products where product_id = '".$id."'");
            redirect("admin/header_products");
        }
}

/* ========== Products ==========*/  
/* ========== Purchase ==========*/
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
                    "unit"=>$this->input->post("unit")
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
function edit_purchase($id){
    if(_is_user_login($this)){
	    
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                //$this->form_validation->set_rules('product_id', 'product_id', 'trim|required');
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
      		        $total_price=$this->input->post("qty")*$this->input->post("price");
                    $this->load->model("common_model");
                    $array = array(
                    //"product_id"=>$this->input->post("product_id"),
                    "qty"=>($this->input->post("prev_qty")+$this->input->post("qty")),
                    "price"=>$this->input->post("price"),
                    "unit"=>$this->input->post("unit"),
                    "total_price"=>($this->input->post('total_price')+$total_price)
                    );
                    $this->common_model->data_update("purchase",$array,array("purchase_id"=>$id));
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/add_purchase");
                }
                
                $this->load->model("product_model");
                $data["purchase"]  = $this->product_model->get_purchase_by_id($id);
                $data["products"]  = $this->product_model->get_products();
                $this->load->view("admin/product/edit_purchase",$data);  
                
            }
        }
}

function delete_purchase($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from purchase where purchase_id = '".$id."'");
            redirect("admin/add_purchase");
        }
}
/* ========== Purchase END ==========*/
    public function socity(){
    if(_is_user_login($this)){
	    
            if(isset($_POST))
            {
                $this->load->library('form_validation');
				// if(!isset($_SESSION["shop_id"]))
    //             {
    //             	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
    //             }                

                $this->form_validation->set_rules('pincode', 'pincode', 'trim|required|numeric|regex_match[/^[0-9]+$/]');
                $this->form_validation->set_rules('socity_name', 'Socity Name', 'trim|required');
                 $this->form_validation->set_rules('delivery', 'Delivery Charges', 'trim|required|numeric|regex_match[/^[0-9]+$/]');

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
                    "socity_name"=>$this->input->post("socity_name"),
                    "pincode"=>$this->input->post("pincode"),
                    "delivery_charge"=>$this->input->post("delivery")
                    //"shop_id"=>$_SESSION["shop_id"]

                    );
                    $this->common_model->data_insert("socity",$array);
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/socity");
                }
                
                $this->load->model("product_model");
                $data["socities"]  = $this->product_model->get_socities();
                $this->load->view("admin/socity/list",$data);  
                
            }
        }
        
    }
    
    public function declared_rewards(){
    if(_is_user_login($this)){
	    
            $this->load->library('form_validation');
           $this->load->model("product_model");
           	$result=	false;
               
                
                 $this->form_validation->set_rules('delivery', 'Delivery Charges', 'trim|required|numeric|regex_match[/^[0-9]+$/]');

                if (!$this->form_validation->run() == FALSE)
        		{
        		    
        		    $point = array(
                       'point' => $this->input->post('delivery')
                      
                    );
                    
        		    $result =	$this->product_model->update_reward($point);
        		    
        		    
        		  if($this->form_validation->error_string()!=""){
        			  $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
        		  }
        			else{
        				$this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request updated successfully...
                                    </div>');
        			}
        		
               }
                
                $data['rewards']  = $this->product_model->rewards_value();
            
               
                $this->load->view("admin/declared_rewards/edit",$data);  
                
            
        }
        
    }
    
    public function edit_socity($id){
    if(_is_user_login($this)){
	    
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                //print_r($_SESSION);
                // if(!isset($_SESSION["shop_id"]))
                // {
                // 	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
                // } 
                $this->form_validation->set_rules('pincode', 'pincode', 'trim|required|numeric|regex_match[/^[0-9]+$/]');
                $this->form_validation->set_rules('socity_name', 'Socity Name', 'trim|required');
                $this->form_validation->set_rules('delivery', 'Delivery Charges', 'trim|required|numeric|regex_match[/^[0-9]+$/]');

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
                    "socity_name"=>$this->input->post("socity_name"),
                    "pincode"=>$this->input->post("pincode"),
                    "delivery_charge"=>$this->input->post("delivery")
                    //"shop_id"=>$_SESSION["shop_id"]

                    );
                    $this->common_model->data_update("socity",$array,array("socity_id"=>$id));
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/socity");
                }
                
                $this->load->model("product_model");
                $data["socity"]  = $this->product_model->get_socity_by_id($id);
                $this->load->view("admin/socity/edit",$data);  
                
            }
        }
        
    }
    function delete_socity($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from socity where socity_id = '".$id."'");
             $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request deleted successfully...
                                    </div>');
            redirect("admin/socity");
        }
    }
    function registers(){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $users = $this->product_model->get_all_users();
            $this->load->view("admin/allusers",array("users"=>$users));
        }
    }

    function updateuserdetails($user_id,$status){
    	 if(_is_user_login($this)){
    	 	//echo $user_id;
    	 	//echo $status;
    	 	//echo $this->input->post("status");
    	 	//die();
            $this->db->query("Update registers set status='".$status."' where user_id = '".$user_id."'");
            $this->load->model("product_model");
            $users = $this->product_model->get_all_users();
            $this->load->view("admin/allusers",array("users"=>$users));
        }
    }
 
 /* ========== Page app setting =========*/
public function addpage_app()
	{
	   if(_is_user_login($this))
       {
	       
            $data["error"] = "";
            $data["active"] = "addpageapp"; 
            
            if(isset($_REQUEST["addpageapp"]))
            {
                $this->load->library('form_validation');
                // if(!isset($_SESSION["shop_id"]))
                // {
                // 	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
                // } 
                $this->form_validation->set_rules('page_title', 'Page  Title', 'trim|required');
                $this->form_validation->set_rules('page_descri', 'Page Description', 'trim|required');
                if ($this->form_validation->run() == FALSE)
        		{
        		  if($this->form_validation->error_string()!="")
        			  $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
        		}
        		else
        		{
                    $this->load->model("page_app_model");
                    $this->page_app_model->add_page(); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Page added successfully...</div>');
                    redirect('admin/addpage_app');
               	}

            }
            $this->load->view('admin/page_app/addpage_app',$data);
        }
        else
        {
            redirect('login');
        }
    }
    
    public function allpageapp()
	{
	   if(_is_user_login($this)){
	       $data["error"] = "";
	       $data["active"] = "allpage";
           
           $this->load->model("page_app_model");
           $data["allpages"] = $this->page_app_model->get_pages();
           
           $this->load->view('admin/page_app/allpage_app',$data);
        }
        else
        {
            redirect('login');
        }
    }
    public function editpage_app($id)
	{
	   if(_is_user_login($this)){
	       $data["error"] = "";
	       $data["active"] = "allpage";
           
           $this->load->model("page_app_model");
           $data["onepage"] = $this->page_app_model->one_page($id);
           
           if(isset($_REQUEST["savepageapp"]))
            {
                $this->load->library('form_validation');
                // if(!isset($_SESSION["shop_id"]))
                // {
                // 	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
                // } 
                $this->form_validation->set_rules('page_title', 'Page Title', 'trim|required');
                $this->form_validation->set_rules('page_id', 'Page Id', 'trim|required');
                $this->form_validation->set_rules('page_descri', 'Page Description', 'trim|required');
                if ($this->form_validation->run() == FALSE)
        		{
        		  if($this->form_validation->error_string()!="")
        			  $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
        		}
        		else
        		{
                    $this->load->model("page_app_model");
                    $this->page_app_model->set_page(); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert"><i class="fa fa-check"></i><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your page saved successfully...</div>');
                    redirect('admin/allpageapp');
               	}
            }
           $this->load->view('admin/page_app/editpage_app',$data);
        }
        else
        {
            redirect('login');
        }
    }
    public function deletepageapp($id)
	{
	   if(_is_user_login($this)){
	        
            $this->db->delete("pageapp",array("id"=>$id));
            $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your page deleted successfully...
                                    </div>');
            redirect('admin/allpageapp');
        }
        else
        {
            redirect('login');
        }
    }

/* ========== End page page setting ========*/

 public function setting(){
    if(_is_user_login($this)){
	      $this->load->model("setting_model"); 
                $data["settings"]  = $this->setting_model->get_settings(); 
              
                $this->load->view("admin/setting/settings",$data);  
                
            
        }
    }
 public function edit_settings($id){
    if(_is_user_login($this)){
	    
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                // if(!isset($_SESSION["shop_id"]))
                // {
                // 	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
                // }  
                $this->form_validation->set_rules('value', 'Amount', 'trim|required');
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
                    "title"=>$this->input->post("title"), 
                    "value"=>$this->input->post("value")
                    //"shop_id"=>$_SESSION["shop_id"]
                    );
                    
                    $this->common_model->data_update("settings",$array,array("id"=>$id));
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/setting");
                }
                
                $this->load->model("setting_model");
                $data["editsetting"]  = $this->setting_model->get_setting_by_id($id);
                $this->load->view("admin/setting/edit_settings",$data);                  
            }
        }
        
    }
    
    function stock(){
        if(_is_user_login($this)){
            $this->load->model("product_model");
            $data["stock_list"] = $this->product_model->get_leftstock();
            $this->load->view("admin/product/stock",$data);
        }
    }
/* ========== End page page setting ========*/
   function testnoti(){
        $token =  "cSXtuv8Qkf0:APA91bHtG45TntSc1bSq97VLo2zX70tivsYjY0pVAd5sxFU08-uljOOj16-_qwFJ9ZgZOQTpSDYs2xNkaJgdlk1YX7Wf2ycrm3PPVRzhxfciPFemEE-iYizVoS6A06LwqqpA38sjZjml";
    }
     function notification(){
         if(_is_user_login($this)){
	    
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('descri', 'Description', 'trim|required');
                  if ($this->form_validation->run() == FALSE)
        		  {
                              if($this->form_validation->error_string()!="")
        			  $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                  }else{
                                $message["title"] = $this->config->item("company_title");
                                $message["body"] = $this->input->post("descri");
                                $image_path='';
                                
                                
                                if($_FILES["prod_img"]["size"] > 0){
                                    $config['upload_path']          = './uploads/notification/';
                                    $config['allowed_types']        = 'gif|jpg|png|jpeg|jfif';
                                    $this->load->library('upload', $config);
                    
                                    if ( ! $this->upload->do_upload('prod_img'))
                                    {
                                            $error = array('error' => $this->upload->display_errors());
                                    }
                                    else
                                    {
                                        $img_data = $this->upload->data();
                                        $image_path=base_url().'uploads/notification/'.$img_data['file_name'];
                                    }
                                
                                }
                                
                                
                                
                                        

                                $message["image"] = $image_path;
                                $message["created_at"] = date("Y-m-d h:i:s");  
                            
                    $q = $this->db->query("Select user_fcm_code from registers where 1");   
                    $users = $q->result();
                    //echo "<pre>";print_r($users);exit();
                    $this->load->helper('gcm_helper');
                    $gcm = new GCM();   
                     if(!empty($users))
                     {
                           
                            foreach($users as $row){
                                
                            if($row->user_fcm_code != ""){
                            $result = $gcm->send_notification(array($row->user_fcm_code),$message ,"android",false);
                            
                            }    
                            }
                            
                            $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Notification sent successfully...
                                    </div>');
                            
                            
                     
                     }
                     else{
                     		 $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> No token available </div>');
                                      unlink($image_path);
                     }
                    
                            
                             redirect("admin/notification");
                  }
                   
                   $this->load->view("admin/product/notification");
                
            }
        }
        
    }
    
    function time_slot(){
        if(_is_user_login($this)){
                $this->load->model("time_model");
                $timeslot = $this->time_model->get_time_slot();
                
                $this->load->library('form_validation');
                // if(!isset($_SESSION["shop_id"])){

                // 	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
                // }
                $this->form_validation->set_rules('opening_time', 'Opening Hour', 'trim|required');
                $this->form_validation->set_rules('closing_time', 'Closing Hour', 'trim|required');
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
        		  if(empty($timeslot)){//,shop_id
                    $q = $this->db->query("Insert into time_slots(opening_time,closing_time,time_slot,second_slot_opening_time,second_slot_closing_time) values('".date("H:i:s",strtotime($this->input->post('opening_time')))."','".date("H:i:s",strtotime($this->input->post('closing_time')))."','".$this->input->post('interval')."','".date("H:i:s",strtotime($this->input->post('second_slot_opening_time')))."','".date("H:i:s",strtotime($this->input->post('second_slot_closing_time')))."')");//,'".$_SESSION["shop_id"]."'
                  }else{
             //       $q = $this->db->query("Update time_slots set opening_time = '".date("H:i:s",strtotime($this->input->post('opening_time')))."' ,closing_time = '".date("H:i:s",strtotime($this->input->post('closing_time')))."',time_slot = '".$this->input->post('interval')."',second_slot_opening_time='".date("H:i:s",strtotime($this->input->post('second_slot_opening_time')))."',second_slot_closing_time='".date("H:i:s",strtotime($this->input->post('second_slot_closing_time')))."'");//, shop_id='".$_SESSION["shop_id"]."'
 $q = $this->db->query("Insert into time_slots(delivery_date,opening_time,closing_time,time_slot,second_slot_opening_time,second_slot_closing_time) values('".$this->input->post('delivery_date')."','".date("H:i:s",strtotime($this->input->post('opening_time')))."','".date("H:i:s",strtotime($this->input->post('closing_time')))."','".$this->input->post('interval')."','".date("H:i:s",strtotime($this->input->post('second_slot_opening_time')))."','".date("H:i:s",strtotime($this->input->post('second_slot_closing_time')))."')");//,'".$_SESSION["shop_id"]."'               
   }  
                }            
            
            $timeslot = $this->time_model->get_time_slot();
            $this->load->view("admin/timeslot/edit",array("schedule"=>$timeslot));
        }
    }
    function closing_hours(){
        $this->load->library('form_validation');
        // if(!isset($_SESSION["shop_id"])){

        // 	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
        // }
        		$this->form_validation->set_rules('date', 'Date', 'trim|required');
                $this->form_validation->set_rules('opening_time', 'Start Hour', 'trim|required');
                $this->form_validation->set_rules('closing_time', 'End Hour', 'trim|required');
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
        		      $array = array("date"=>date("Y-m-d",strtotime($this->input->post("date"))),
                      "from_time"=>date("H:i:s",strtotime($this->input->post("opening_time"))),
                      "to_time"=>date("H:i:s",strtotime($this->input->post("closing_time")))
                     // "shop_id"=>$_SESSION["shop_id"]
                      ); 
                      $this->db->insert("closing_hours",$array); 
                       $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                }
        
         $this->load->model("time_model");
         $timeslot = $this->time_model->get_closing_date(date("Y-m-d"));
         $this->load->view("admin/timeslot/closing_hours",array("schedule"=>$timeslot));
         
                        
    }
    
     
     function delete_closing_date($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from closing_hours where id = '".$id."'");
               $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request deleted successfully...
                                    </div>');
            redirect("admin/closing_hours");
        }
    
    }
    public function addslider()
	{
	   if(_is_user_login($this)){
	       
            $data["error"] = "";
            $data["active"] = "addslider";
            
            if(isset($_REQUEST["addslider"]))
            {
                $this->load->library('form_validation');
          //       if(!isset($_SESSION["shop_id"])){

		        // 	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
		        // }
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
                if (empty($_FILES['slider_img']['name']))
                {
                    $this->form_validation->set_rules('slider_img', 'Slider Image', 'required');
                }
                
                if ($this->form_validation->run() == FALSE)
        		{
        			  $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
        		}
        		else
        		{
                    $add = array(
                                    "slider_title"=>$this->input->post("slider_title"),
                                    "slider_status"=>$this->input->post("slider_status"),
                                    "slider_url"=>$this->input->post("slider_url"),
                                    "brand_id"=>$this->input->post("sub_cat")
                                    //"shop_id"=>$_SESSION["shop_id"]
                                    );
                    
                        	if($_FILES["slider_img"]["size"] > 0){
                            $config['upload_path']          = './uploads/sliders/';
                            $config['allowed_types']        = 'gif|jpg|png|jpeg|JFIF';
                            $this->load->library('upload', $config);
            
                            if ( ! $this->upload->do_upload('slider_img'))
                            {
                                    $error = array('error' => $this->upload->display_errors());
                            }
                            else
                            {
                                $img_data = $this->upload->data();
                                //echo $this->img_data['file_ext'];
                                //die();
                                $add["slider_image"]=$img_data['file_name'];
                            }

                           // echo $this->img_data['file_ext'];
                            
                       }
                       
                       $this->db->insert("slider",$add);
                    
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider added successfully...
                                    </div>');
                    redirect('admin/listslider');
               	}
            }
	   	$this->load->view('admin/slider/addslider',$data);
        }
        else
        {
            redirect('login');
        }
	}
 
     public function listslider()
	{
	   if(_is_user_login($this)){
	       $data["error"] = "";
	       $data["active"] = "listslider";
           $this->load->model("slider_model");
           $data["allslider"] = $this->slider_model->get_slider();
           $this->load->view('admin/slider/listslider',$data);
        }
        else
        {
            redirect('login');
        }
    }
    

    public function updatesliderdetails($slider_id,$status){
    	 if(_is_user_login($this)){
    	 	
            $this->db->query("Update slider set slider_status='".$status."' where id = '".$slider_id."'");
          	//redirct('admin/listslider');
          	$data["error"] = "";
	        $data["active"] = "listslider";
            $this->load->model("slider_model");
            $data["allslider"] = $this->slider_model->get_slider();
             $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider updated successfully...
                                    </div>');
            $this->load->view('admin/slider/listslider',$data);
        }
    }

    
    public function add_Banner()
	{
	   if(_is_user_login($this)){
	       
            $data["error"] = "";
            $data["active"] = "addslider";
            
            if(isset($_REQUEST["addslider"]))
            {
                $this->load->library('form_validation');
          //       if(!isset($_SESSION["shop_id"])){

		        // 	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
		        // }
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
                if (empty($_FILES['slider_img']['name']))
                {
                    $this->form_validation->set_rules('slider_img', 'Slider Image', 'required');
                }
                
                if ($this->form_validation->run() == FALSE)
        		{
        			  $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
        		}
        		else
        		{
                    $add = array(
                                    "slider_title"=>$this->input->post("slider_title"),
                                    "slider_status"=>$this->input->post("slider_status"),
                                    "slider_url"=>$this->input->post("slider_url"),
                                    "sub_cat"=>$this->input->post("sub_cat")
                                    //"shop_id"=>$_SESSION["shop_id"]
                                    );
                    
                        if($_FILES["slider_img"]["size"] > 0){
                            $config['upload_path']          = './uploads/sliders/';
                            $config['allowed_types']        = 'gif|jpg|png|jpeg|jfif';
                            $this->load->library('upload', $config);
            
                            if ( ! $this->upload->do_upload('slider_img'))
                            {
                                    $error = array('error' => $this->upload->display_errors());
                            }
                            else
                            {
                                $img_data = $this->upload->data();
                                $add["slider_image"]=$img_data['file_name'];
                            }
                            
                       }
                       
                       $this->db->insert("banner",$add);
                    
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider added successfully...
                                    </div>');
                    //redirect('admin/add_Banner');
                    redirect('admin/banner');
               	}
            }
	   	$this->load->view('admin/banner/addslider',$data);
        }
        else
        {
            redirect('login');
        }
	}
    
    public function banner()
	{
	   if(_is_user_login($this)){
	       $data["error"] = "";
	       $data["active"] = "listslider";
           $this->load->model("slider_model");
           $data["allslider"] = $this->slider_model->banner();
           $this->load->view('admin/banner/listslider',$data);
        }
        else
        {
            redirect('login');
        }
    }
     public function edit_banner($id)
	{
	   if(_is_user_login($this))
       {
            
            $this->load->model("slider_model");
           $data["slider"] = $this->slider_model->get_banner($id);
           
	        $data["error"] = "";
            $data["active"] = "listslider";
            if(isset($_REQUEST["saveslider"]))
            {
                $this->load->library('form_validation');
          //       if(!isset($_SESSION["shop_id"])){

		        // 	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
		        // }
                $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
               
                  if ($this->form_validation->run() == FALSE)
        		{
        		  if($this->form_validation->error_string()!="")
        			  $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>';
        		}
        		else
        		{
                    $this->load->model("slider_model");
                    $this->slider_model->edit_banner($id); 
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your Slider saved successfully...
                                    </div>');
                    redirect('admin/banner');
               	}
            }
	   	   $this->load->view('admin/banner/editslider',$data);
        }
        else
        {
            redirect('login');
        }
	}
	
	public function editslider($id)
	{
	   if(_is_user_login($this))
           {
                
                $this->load->model("slider_model");
               $data["slider"] = $this->slider_model->get_slider_by_id($id);
               
    	        $data["error"] = "";
                $data["active"] = "listslider";
                if(isset($_REQUEST["saveslider"]))
                {
                    $this->load->library('form_validation');
           //          if(!isset($_SESSION["shop_id"])){

			        // 	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
			        // }

                    $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
                   
                      if ($this->form_validation->run() == FALSE)
            		{
            		  if($this->form_validation->error_string()!="")
            			  $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                            <i class="fa fa-warning"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                        </div>';
            		}
            		else
            		{
                        $this->load->model("slider_model");
                        $this->slider_model->edit_slider($id); 
                        $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your Slider saved successfully...
                                        </div>');
                        redirect('admin/listslider');
                   	}
                }
    	   	   $this->load->view('admin/slider/editslider',$data);
            }
            else
            {
                redirect('login');
            }
	}
	
     function deleteslider($id,$slider_image){
        $data = array();
            $this->load->model("slider_model");
            $slider  = $this->slider_model->get_slider_by_id($id);
           if($slider){
                $this->db->query("Delete from slider where id = '".$slider->id."'");
                unlink("uploads/sliders/".$slider->slider_image);
                    $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your slider deleted successfully...
                                    </div>');
                redirect("admin/listslider");
           }
    }

     function updatebannerdetails($id,$status){
    	 if(_is_user_login($this)){
    	     	 	
            $this->db->query("Update banner set slider_status='".$status."' where id = '".$id."'");
            $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request updated successfully...
                                    </div>');
           	redirect("admin/banner");
        }
    }
    
    function delete_banner($id,$slider_image){
        $data = array();
				$this->db->query("Delete from banner where id = '".$id."'");                
				unlink("uploads/sliders/".$slider_image);
				$this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request deleted successfully...
                                    </div>');
                redirect("admin/banner");
    }
    
    function coupons(){

        $this->load->helper('form');
        $this->load->model('product_model');
        $this->load->library('session');


       
        $this->load->library('form_validation');
        // if(!isset($_SESSION["shop_id"])){

        // 	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
        // }
        
        $this->form_validation->set_rules('coupon_title', 'Coupon name', 'trim|required|max_length[15]');
        $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required|max_length[6]|alpha_numeric');
        $this->form_validation->set_rules('from', 'From', 'required|callback_date_valid');
        $this->form_validation->set_rules('to', 'To', 'required|callback_date_valid');
        //$this->form_validation->set_rules('product_type', 'Product Type', 'required');

  
        $this->form_validation->set_rules('discount_type', 'Discount Name', 'required');
        //$this->form_validation->set_rules('value', 'Value', 'required|numeric');
        /*$this->form_validation->set_rules('cart_value', 'Cart Value', 'required|numeric');*/
        //$this->form_validation->set_rules('restriction', 'Uses restriction', 'required|numeric');
        //$this->form_validation->set_rules('user_type', 'User type', 'required');
        $this->form_validation->set_rules('coupon_max_count', 'Enter max count', 'required');

        $this->form_validation->set_rules('cashback_amt', 'Enter valid amount', 'trim|numeric|greater_than[0.99]|less_than[100]');

        if($this->input->post("valid_date_or_not")=='No'){
        	$this->session->set_flashdata('errormessage','Selected date is not valid');
            $data= array();
        	$data['coupons'] = $this->product_model->coupon_list();
        	$this->load->view("admin/coupons/coupon_list",$data);
        	return false;
        }

        $data= array();
        $data['coupons'] = $this->product_model->coupon_list();
        if($this->form_validation->run() == FALSE)
        {
            $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
            
            $this->load->view("admin/coupons/coupon_list",$data); 
             
        }else{


        	$selected_list_count	=	count($this->input->post('printable_name'));

        	$selected_id 	=	"";
        	for($i=0;$i<$selected_list_count;$i++){

        		if($selected_id!='')
        		{
        			$selected_id.=",".$this->input->post('printable_name')[$i];
        		}
        		else{
        			$selected_id.=$this->input->post('printable_name')[$i];	
        		}        		
        	}

        	$flag	=	0;

        	$check_exist	=	$this->product_model->couponexist($this->input->post('coupon_code'));

        	if(!empty($check_exist))
        	{
        		$flag	=	1;	
        	}
        	else
        	{
        		$flag	=	0;
        	}
        

        	if($flag==1)
        	{
        	    $msg='<div class="alert alert-danger alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Danger!</strong> Coupon code already exist...
                                    </div>';
                                    
        		$this->session->set_flashdata('errormessage',$msg);
            
            	$this->load->view("admin/coupons/coupon_list",$data);
            	return false;
        	}

             $free_delivery  =   '0';
                   
             if($this->input->post("free_delivery")==null OR $this->input->post("free_delivery")!='1')
             {
                 $free_delivery   =   '0';     
             }
             else
             {
                 $free_delivery   =   '1';   
             }     
          
            $data = array(
            'coupon_name'=>$this->input->post('coupon_title'),
            'coupon_code'=> $this->input->post('coupon_code'),
            'valid_from'=> $this->input->post('from'),
            'valid_to'=> $this->input->post('to'),
    //        'validity_type'=> $this->input->post('product_type'),
      //      'type_id'=> $selected_id,
            'discount_type'=> $this->input->post('discount_type'),
            'discount_value'=> $this->input->post('value'),
          //  'cart_value'=> $this->input->post('cart_value'),
        //    'user_type'=> $this->input->post('user_type'),
            'max_count'=>$this->input->post('coupon_max_count'),            
            'cashback'=>$this->input->post('cashback_amt'),
            'free_delivery'=>$free_delivery,
            'min_limit'=>$this->input->post('min_amount_apply'),
            'max_limit'=>$this->input->post('max_amount_apply')
             );
           
			
             if($this->product_model->coupon($data))
             {
                
				$this->session->set_flashdata('addmessage','Coupon added Successfully.');
                $data['coupons'] = $this->product_model->coupon_list();
                $this->load->view("admin/coupons/coupon_list",$data);
				
             }
			 
        }
       
        
    }   
    public function date_valid($date)
    {
     $parts = explode("/", $date);
      if (count($parts) == 3) {      
       if (checkdate($parts[1], $parts[0], $parts[2]))
       {
        return TRUE;
       }
    }
     $this->form_validation->set_message('date_valid', 'The Date field must be dd/mm/yyyy');
     return false;
    }

    public function lookup(){  
        $this->load->model("product_model");  
        $this->load->helper("url");  
        $this->load->helper('form');
        // process posted form data  
        $keyword = $this->input->post('term');
        $type = $this->input->post('type');  
        $data['response'] = 'false'; //Set default response  
        if($type=='Category')
        {
            
        } 
        elseif ($type=='Sub Category') {
            
        }
        else{
            $query = $this->product_model->lookup($keyword); //Search DB 
        }
        if( ! empty($query) )  
        {  
            $data['response'] = 'true'; //Set response  
            $data['message'] = array(); //Create array  
            foreach( $query as $row )  
            {  
                $data['message'][] = array(   
                                          
                                        'value' => $row->product_name,
                                        'value_id' => $row->product_id  
                                         
                                     );  //Add a row to array  
            }  
        }
      
        if('IS_AJAX')  
        {  
            echo json_encode($data); //echo json string if ajax request 
            //$this->load->view('admin/coupons/coupon_list',$data);
        }  
        else 
        {  
            $this->load->view('admin/coupons/coupon_list',$data); //Load html view of search results  
        }  
    }  
    
    function looku(){

        $this->load->model("product_model");  
        $this->load->helper("url");  
        $this->load->helper('form');
        // process posted form data  
        $keyword = $this->input->post('term');
        $type = $this->input->post('type');  
        $data['response'] = 'false'; //Set default response  
        
            $query = $this->product_model->looku($keyword); //Search DB 
        
        if( ! empty($query) )  
        {  
            $data['response'] = 'true'; //Set response  
            $data['message'] = array(); //Create array  
            foreach( $query as $row )  
            {  
                $data['message'][] = array(   
                                          
                                        'value' => $row->title,
                                        'value_id' => $row->id 
                                         
                                     );  //Add a row to array  
            }  
        }
        
        if('IS_AJAX')  
        {  
            echo json_encode($data); //echo json string if ajax request 
            //$this->load->view('admin/coupons/coupon_list',$data);
        }  
        else 
        {  
            $this->load->view('admin/coupons/coupon_list',$data); //Load html view of search results  
        }  
    }

    function look(){

        $this->load->model("product_model");  
        $this->load->helper("url");  
        $this->load->helper('form');
        // process posted form data  
        $keyword = $this->input->post('term');
        $type = $this->input->post('type');  
        $data['response'] = 'false'; //Set default response  
        if($type=='Category')
        {
            
        } 
        elseif ($type=='Sub Category') {
            
        }
        else{
            $query = $this->product_model->look($keyword); //Search DB 
        }
        if( ! empty($query) )  
        {  
            $data['response'] = 'true'; //Set response  
            $data['message'] = array(); //Create array  
            foreach( $query as $row )  
            {  
                $data['message'][] = array(   
                                          
                                        'value' => $row->title,
                                        'value_id' => $row->id 
                                         
                                     );  //Add a row to array  
            }  
        }
        
        if('IS_AJAX')  
        {  
            echo json_encode($data); //echo json string if ajax request 
            //$this->load->view('admin/coupons/coupon_list',$data);
        }  
        else 
        {  
            $this->load->view('admin/coupons/coupon_list',$data); //Load html view of search results  
        }  
    }


    function editCoupon($id){
        //echo $id;die();
        $this->load->helper('form');
      	$this->load->library('form_validation');       
       	$this->load->model('product_model');	

       	// if(!isset($_SESSION["shop_id"])){

        // 	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
        // }
        $this->form_validation->set_rules('coupon_title', 'Coupon name', 'trim|required');
        $this->form_validation->set_rules('coupon_code', 'Coupon Code', 'trim|required|alpha_numeric');
        $this->form_validation->set_rules('from', 'From', 'required|callback_date_valid');
        $this->form_validation->set_rules('to', 'To', 'required|callback_date_valid');
       // $this->form_validation->set_rules('product_type', 'Product Type', 'required');
        //$this->form_validation->set_rules('printable_name', 'Product Name', 'required');

        $this->form_validation->set_rules('discount_type', 'Discount Name', 'required');
        //$this->form_validation->set_rules('value', 'Value', 'required|numeric');
        //$this->form_validation->set_rules('cart_value', 'Cart Value', 'required|numeric');
        //$this->form_validation->set_rules('restriction', 'Uses restriction', 'required|numeric');
        //$this->form_validation->set_rules('user_type', 'Uses type', 'required');
        $this->form_validation->set_rules('coupon_max_count', 'Enter max count', 'required');
        // $this->form_validation->set_rules('user_type', 'User type', 'required');
        $this->form_validation->set_rules('coupon_max_count', 'Enter max count', 'required');

        $this->form_validation->set_rules('cashback_amt', 'Enter valid amount', 'trim|numeric|greater_than[0.99]|less_than[100]');


        $data= array();
        if($this->form_validation->run() == FALSE)
        {
            $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
            $data['coupon'] = $this->product_model->getCoupon($id);
            $this->load->view("admin/coupons/couponform",$data); 
             
        }else{
        	$selected_list_count	=	count($this->input->post('printable_name'));

        	$selected_id 	=	"";
        	for($i=0;$i<$selected_list_count;$i++){

        		if($selected_id!='')
        		{
        			$selected_id.=",".$this->input->post('printable_name')[$i];
        		}
        		else{
        			$selected_id.=$this->input->post('printable_name')[$i];	
        		}
        		
        	}
            $free_delivery  =   '0';
                   
             if($this->input->post("free_delivery")==null OR $this->input->post("free_delivery")!='1')
             {
                 $free_delivery   =   '0';     
             }
             else
             {
                 $free_delivery   =   '1';   
             }     
          
            $data = array(
            'coupon_name'=>$this->input->post('coupon_title'),
            'coupon_code'=> $this->input->post('coupon_code'),
            'valid_from'=> $this->input->post('from'),
            'valid_to'=> $this->input->post('to'),
            'validity_type'=> $this->input->post('product_type'),
            'type_id'=> $selected_id,
            'discount_type'=> $this->input->post('discount_type'),
            'discount_value'=> $this->input->post('value'),
            //'cart_value'=> $this->input->post('cart_value'),
            //'uses_restriction'=> $this->input->post('restriction'),
            'user_type'=> $this->input->post('user_type'),
            //'shop_id'=> $_SESSION["shop_id"],
            'max_count'=> $this->input->post('coupon_max_count'),
             'cashback'=>$this->input->post('cashback_amt'),
            'free_delivery'=>$free_delivery,
            'min_limit'=>$this->input->post('min_amount_apply'),
            'max_limit'=>$this->input->post('max_amount_apply')
             );
             
             if($this->product_model->editCoupon($id,$data)){
                $this->session->set_flashdata('addmessage','Coupon edited Successfully.');
                redirect("admin/coupons");
             }
        }
       
        
    }

    function deleteCoupon($id)
    {
        $this->load->model('product_model');
        if($this->product_model->deleteCoupon($id))
        {
            $this->session->set_flashdata('addmessage','One Coupon deleted Successfully.');
            redirect("admin/coupons");
        }
    }

    function dealofday()
    {

        $this->load->model("product_model");
        $data["deal_products"]  = $this->product_model->getdealproducts(); 

        $this->load->view('admin/deal/deal_list',$data);
    }

    function add_dealproduct(){
        $this->load->helper('form');

       if(_is_user_login($this)){

            if(isset($_POST))
            {
                $this->load->library('form_validation');
          //       if(!isset($_SESSION["shop_id"])){

		        // 	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
		        // }
                $this->form_validation->set_rules('prod_title', 'Product', 'trim|required');
                $this->form_validation->set_rules('deal_price', 'Price', 'trim|required|numeric|regex_match[/^[0-9,]+$/]');
                $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
                $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
                $this->form_validation->set_rules('end_date', 'End Date', 'trim|required'); 
                $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');  
                $this->form_validation->set_rules('max_qty', 'Max quantity', 'trim|required|numeric');  
                $this->form_validation->set_rules('qty_unit', ' qty & unit', 'trim|required');
                //$this->form_validation->set_rules('deal_unit', 'Unit', 'trim|required');

               
				                
                if ($this->form_validation->run() == FALSE)
                {
                      if($this->form_validation->error_string()!="") { 
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                 }
                                   
                }
                else
                {
                    $value  =   $this->input->post("prod_title");
                    $product_value  =   explode(',',$value);
                    
                    $qty_unit=explode('-',$this->input->post("qty_unit"));

                    $this->load->model("product_model");
                    $array = array( 
                    "product_id"=>$product_value[0],     
                    "product_name"=>$product_value[1], 
                    "deal_price"=>$this->input->post("deal_price"),
                    "start_date"=>$this->input->post("start_date"),
                    "start_time"=>$this->input->post("start_time"),
                    "end_date"=>$this->input->post("end_date"),
                    "end_time"=>$this->input->post("end_time"),
                   // "shop_id"=>$_SESSION["shop_id"],
                    "max_qty"=>$this->input->post("max_qty"),       
                    "deal_unit_value"=>$qty_unit[0],
                    "deal_unit"=>$qty_unit[1]
                    );                    
                    
                    $this->product_model->adddealproduct($array); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/dealofday');
                }
            }
            
            $this->load->model("product_model");
            $data["all_products"]  = $this->product_model->get_all_product(); 
            $this->load->view("admin/deal/add",$data);
        }
        else
        {
            redirect('admin');
        }
    
    }
    
    function edit_deal_product($id){
	   if(_is_user_login($this)){
	    
            if(isset($_POST))
            {
                $this->load->library('form_validation');
          //       if(!isset($_SESSION["shop_id"])){

		        // 	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
		        // }
                 $this->form_validation->set_rules('prod_title', 'Product', 'trim|required');
                $this->form_validation->set_rules('deal_price', 'Price', 'trim|required|numeric|regex_match[/^[0-9,]+$/]');
                $this->form_validation->set_rules('start_date', 'Start Date', 'trim|required');
                $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
                $this->form_validation->set_rules('end_date', 'End Date', 'trim|required'); 
                $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');  
                $this->form_validation->set_rules('max_qty', 'Max quantity', 'trim|required|numeric');
                //$this->form_validation->set_rules('deal_unit_value', ' qty', 'trim|required');
                //$this->form_validation->set_rules('deal_unit', 'Unit', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
        		{
        		   if($this->form_validation->error_string()!=""){
        			  $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                   }
        		}
        		else
        		{
                    $value  =   $this->input->post("prod_title");
                    $product_value  =   explode(',',$value);
                    $qty_unit=explode('-',$this->input->post("qty_unit"));
                    $this->load->model("product_model");
                    $array = array( 
                    "product_id"=>$product_value[0],    
                    "product_name"=>$product_value[1], 
                    "deal_price"=>$this->input->post("deal_price"),
                    "start_date"=>$this->input->post("start_date"),
                    "start_time"=>$this->input->post("start_time"),
                    "end_date"=>$this->input->post("end_date"),
                    "end_time"=>$this->input->post("end_time"),
                    //"shop_id"=>$_SESSION["shop_id"],
                    "max_qty"=>$this->input->post("max_qty"),       
                    "deal_unit_value"=>$qty_unit[0],
                    "deal_unit"=>$qty_unit[1]
                    );
                    
                   $this->product_model->edit_deal_product($id,$array); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request edited successfully...
                                    </div>');
                    redirect('admin/dealofday');
               	}
            }
            $this->load->model("product_model");
            $data["product"] = $this->product_model->getdealproduct($id);
            $data["all_products"]  = $this->product_model->get_all_product(); 
            $this->load->view("admin/deal/edit",$data);
        }
        else
        {
            redirect('admin');
        }
    
}

function delete_deal_product($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from deal_product where id = '".$id."'");
             $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request deleted successfully...
                                    </div>');
                    redirect('admin/dealofday');
            redirect("admin/dealofday");
        }
}

    public function feature_banner()
    	{
    	   if(_is_user_login($this)){
    	       $data["error"] = "";
    	       $data["active"] = "listslider";
               $this->load->model("slider_model");
               $data["allslider"] = $this->slider_model->feature_banner();
               $this->load->view('admin/feature_banner/listslider',$data);
            }
            else
            {
                redirect('login');
            }
        }

    public function add_feature_Banner()
    	{
    	   if(_is_user_login($this)){
    	       
                $data["error"] = "";
                $data["active"] = "addslider";
                
                if(isset($_REQUEST["addslider"]))
                {
                    $this->load->library('form_validation');
           //          if(!isset($_SESSION["shop_id"])){
			        // 	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
			        // }
                    $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
                    if (empty($_FILES['slider_img']['name']))
                    {
                        $this->form_validation->set_rules('slider_img', 'Slider Image', 'required');
                    }
                    
                    if ($this->form_validation->run() == FALSE)
            		{
            			  $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                            <i class="fa fa-warning"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                        </div>';
            		}
            		else
            		{
                        $add = array(
                                        "slider_title"=>$this->input->post("slider_title"),
                                        "slider_status"=>$this->input->post("slider_status"),
                                        "slider_url"=>$this->input->post("slider_url"),
                                        "brand_id"=>$this->input->post("sub_cat")
                                        //"shop_id"=>$_SESSION["shop_id"]
                                        );
                        
                            if($_FILES["slider_img"]["size"] > 0){
                                $config['upload_path']          = './uploads/sliders/';
                                $config['allowed_types']        = 'gif|jpg|png|jpeg|jfif';
                                $this->load->library('upload', $config);
                
                                if ( ! $this->upload->do_upload('slider_img'))
                                {
                                        $error = array('error' => $this->upload->display_errors());
                                }
                                else
                                {
                                    $img_data = $this->upload->data();
                                    $add["slider_image"]=$img_data['file_name'];
                                }
                                
                           }
                           
                           $this->db->insert("feature_slider",$add);
                        
                        $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your Slider added successfully...
                                        </div>');
                        redirect('admin/feature_banner');
                   	}
                }
    	   	$this->load->view('admin/feature_banner/addslider',$data);
            }
            else
            {
                redirect('login');
            }
    	}
        
     public function edit_feature_banner($id)
    	{
    	   if(_is_user_login($this))
           {
                
                $this->load->model("slider_model");
               $data["slider"] = $this->slider_model->get_feature_banner($id);
               
    	        $data["error"] = "";
                $data["active"] = "listslider";
                if(isset($_REQUEST["saveslider"]))
                {
                    $this->load->library('form_validation');
           //          if(!isset($_SESSION["shop_id"])){
			        // 	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
			        // }
                    $this->form_validation->set_rules('slider_title', 'Slider Title', 'trim|required');
                   
                      if ($this->form_validation->run() == FALSE)
            		{
            		  if($this->form_validation->error_string()!="")
            			  $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                            <i class="fa fa-warning"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                        </div>';
            		}
            		else
            		{
                        $this->load->model("slider_model");
                        $this->slider_model->edit_feature_banner($id); 
                        $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your Slider saved successfully...
                                        </div>');
                        redirect('admin/feature_banner');
                   	}
                }
    	   	   $this->load->view('admin/feature_banner/editslider',$data);
            }
            else
            {
                redirect('login');
            }
    	}

    	function updatefeaturebannerdetails($id,$status){
	    	 if(_is_user_login($this)){
	    	     	 	
	            $this->db->query("Update feature_slider set slider_status='".$status."' where id = '".$id."'");
	            $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
	                                        <i class="fa fa-check"></i>
	                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	                                      <strong>Success!</strong> Your request updated successfully...
	                                    </div>');
	           	redirect("admin/feature_banner");
	        }
    	}

        function delete_feature_banner($id,$slider_image){
            $data = array();
            
           
                $this->db->query("Delete from feature_slider where id = '".$id."'");
                unlink("uploads/sliders/".$slider_image);
                 $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
	                                        <i class="fa fa-check"></i>
	                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	                                      <strong>Success!</strong> Your request deleted successfully...
	                                    </div>');
                redirect("admin/feature_banner");
        }
        
        public function help()
    	{
    	   if(_is_user_login($this)){
    	       
                $data["error"] = "";
                $data["active"] = "addcat";
                if(isset($_REQUEST["addcatg"]))
                {
                    $this->load->library('form_validation');
                    $this->form_validation->set_rules('mobile', 'Categories Title', 'trim|required|numeric|regex_match[/^[0-9,]+$/]|min_length[10]|max_length[10]');
                    $this->form_validation->set_rules('email', 'Categories Parent', 'trim|required|valid_email');
                    
                    if ($this->form_validation->run() == FALSE)
            		{
            		   if($this->form_validation->error_string()!=""){
            			  $data["error"] = '<div class="alert alert-warning alert-dismissible" role="alert">
                                            <i class="fa fa-warning"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                        </div>';
                        }
            		}
            		else
            		{
                        $this->load->model("category_model");
                        $this->category_model->add_category(); 
                        $this->session->set_flashdata("success_req",'<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your request Send successfully...
                                        </div>');
                        redirect('admin/addcategories');
                   	}
                }
    	   	$this->load->view('admin/help/form');
            }
            else
            {
                redirect('admin');
            }
    	}

    	function welcome_wallet(){
	   if(_is_user_login($this)){ 
          //  echo "hi";

	   		$this->load->library('form_validation');
            $this->form_validation->set_rules('wallet_amt', 'Enter amount', 'trim|required');	

            $this->load->view('admin/');
        }
        else
        {
            redirect('admin');
        }
      } 
        function shop(){
	   		if(_is_user_login($this)){ 
          
	   		 $this->load->model("shop_model");
		     $data["shops"]  = $this->shop_model->get_all_shop();
		    
		     $this->load->view("admin/shop/list",$data);
		   }
		 }
/*************************************************************************************************************************/
		 
		 function brand(){
	   		if(_is_user_login($this)){ 
          
    		 $q=$this->db->query("SELECT * FROM `brand` WHERE 1");
		     $data["brand"]  = $q->result();
		     $this->load->view("admin/brand/list",$data);
		   }
		 }
		 
		 function add_brand(){   

			if(_is_user_login($this)){  

	   		if(isset($_POST))
            {
                $this->load->library('form_validation');               
                $this->form_validation->set_rules('name', ' title', 'trim|required');

                if ($this->form_validation->run() == FALSE)
        		{
        		      if($this->form_validation->error_string()!="") { 
        			     $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                    }
                }
                else
                {
                    $this->load->model("common_model");
                    $array = array( 
                    "name"=>$this->input->post("name"), 
                    "status"=>"Active"
                    );
                   
                   
                    $this->common_model->data_insert("brand",$array); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/brand');
                }
            }
             $this->load->view("admin/brand/add_shop");

          }
          else
          {
            redirect('admin');
          }           
      }


		 
		 function edit_brand($brand_id){
       if(_is_user_login($this)){
        
           // $this->load->model("shop_model");
           // $data["shop"]  = $this->shop_model->get_shop_by_id($shop_id);
           // $this->load->view("admin/shop/edit_shop",$data);

            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('name', ' Title', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                   }
                }
                else
                {
                    $this->load->model("common_model");
                    $array = array( 
                    "name"=>$this->input->post("name"), 
                    "status"=>$this->input->post("status"), 
                    );
                    $this->common_model->data_update("brand",$array,array("brand_id"=>$brand_id)); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/brand');
                }
            }
            
            $q=$this->db->query("SELECT * FROM `brand` WHERE brand_id=".$brand_id);
            $data["brand"] =$q->row();
            $this->load->view("admin/brand/edit_shop",$data);
        }
        else
        {
            redirect('admin');
        }
    
    } 

		 
		 function delete_brand($id){
            if(_is_user_login($this)){
                $this->db->query("Delete from brand where brand_id = '".$id."'");
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your request deleted successfully...
                                        </div>');
                redirect("admin/brand");
            }        
        }
        
        
        
        function composition(){
	   		if(_is_user_login($this)){ 
          
    		 $q=$this->db->query("SELECT * FROM `composition` WHERE 1");
		     $data["composition"]  = $q->result();
		     $this->load->view("admin/composition/list",$data);
		   }
		 }
		 
		 function add_composition(){   

			if(_is_user_login($this)){  

	   		if(isset($_POST))
            {
                $this->load->library('form_validation');               
                $this->form_validation->set_rules('composition_name', ' title', 'trim|required');

                if ($this->form_validation->run() == FALSE)
        		{
        		      if($this->form_validation->error_string()!="") { 
        			     $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                    }
                }
                else
                {
                    $this->load->model("common_model");
                    $array = array( 
                    "composition_name"=>$this->input->post("composition_name"), 
                    "status"=>"Active"
                    );
                   
                   
                    $this->common_model->data_insert("composition",$array); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/composition');
                }
            }
             $this->load->view("admin/composition/add_shop");

          }
          else
          {
            redirect('admin');
          }           
      }


		 
		 function edit_composition($composition_id){
       if(_is_user_login($this)){
        
           // $this->load->model("shop_model");
           // $data["shop"]  = $this->shop_model->get_shop_by_id($shop_id);
           // $this->load->view("admin/shop/edit_shop",$data);

            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('composition_name', ' composition name', 'trim|required');
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                   }
                }
                else
                {
                    $this->load->model("common_model");
                    $array = array( 
                    "composition_name"=>$this->input->post("composition_name"), 
                    "status"=>$this->input->post("status"), 
                    );
                    $this->common_model->data_update("composition",$array,array("composition_id"=>$composition_id)); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/composition');
                }
            }
            
            $q=$this->db->query("SELECT * FROM `composition` WHERE composition_id=".$composition_id);
            $data["composition"] =$q->row();
            $this->load->view("admin/composition/edit_shop",$data);
        }
        else
        {
            redirect('admin');
        }
    
    } 

		 
		 function delete_composition($id){
            if(_is_user_login($this)){
                $this->db->query("Delete from composition where composition_id = '".$id."'");
                $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your request deleted successfully...
                                        </div>');
                redirect("admin/composition");
            }        
        }
        
        
    
    
		 
		 /*************************************************************************************************************************/
		  
		 
		 function driver(){
	   		if(_is_user_login($this)){ 
          
	   		 $q=$this->db->query("SELECT * FROM `driver` WHERE 1");
		     $data["drivers"]  = $q->result();
		    
		     $this->load->view("admin/driver/list",$data);
		   }
		 }
		 
		 function add_driver(){   

			if(_is_user_login($this)){  

	   		if(isset($_POST))
            {
                $this->load->library('form_validation');               
                $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
                $this->form_validation->set_rules('last_name', 'last Name', 'trim|required');
                $this->form_validation->set_rules('email', ' email id', 'trim|required|valid_email|is_unique[driver.email]');
                $this->form_validation->set_rules('phone', 'contact number', 'trim|required|numeric|regex_match[/^[0-9,]+$/]|min_length[10]|max_length[10]|is_unique[driver.phone]');
           		$this->form_validation->set_rules('driver_address', ' address', 'trim|required');   
           		$this->form_validation->set_rules('licence_plate', ' licence plate', 'trim|required');
           		$this->form_validation->set_rules('color', ' color', 'trim|required');
           		
               
              
                if ($this->form_validation->run() == FALSE)
        		{
        		      if($this->form_validation->error_string()!="") { 
        			     $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                    }
                }
                else
                {
$zip=implode(', ',$this->input->post("zip"));
                    $this->load->model("common_model");
                    $array = array( 
                    "first_name"=>$this->input->post("first_name"), 
                    "last_name"=>$this->input->post("last_name"),
                    "email"=>$this->input->post("email"),
                    "phone"=>$this->input->post("phone"),
                    "password"=>md5($this->input->post("password")),
                    "transport_type"=>$this->input->post("transport_type"),
                    "color"=>$this->input->post("color"),
                    "driver_address"=>$this->input->post("driver_address"),
                    "licence_plate"=>$this->input->post("licence_plate"),
                    "status"=>"Active",
                    "date_created"=>date('Y-m-d h:i:s'),
"zip"=>$zip
                    );
                   
                    if($_FILES["profile_photo"]["size"] > 0){
                        $config['upload_path']          = './uploads/driver/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg|jfif';
                        $this->load->library('upload', $config);
        
                        if ( ! $this->upload->do_upload('profile_photo'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $array["profile_photo"]=$img_data['file_name'];
                        }
                        
                   }
                   
                    $this->common_model->data_insert("driver",$array); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/driver');
                }
            }
             $this->load->view("admin/driver/add_driver");

          }
          else
          {
            redirect('admin');
          }           
      }
      
      
    
      function edit_driver($driver_id){
       if(_is_user_login($this)){
        
           // $this->load->model("shop_model");
           // $data["shop"]  = $this->shop_model->get_shop_by_id($shop_id);
           // $this->load->view("admin/shop/edit_shop",$data);

            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
                $this->form_validation->set_rules('last_name', 'last Name', 'trim|required');
                $this->form_validation->set_rules('email', ' email id', 'trim|required|valid_email');
                $this->form_validation->set_rules('phone', 'contact number', 'trim|required|numeric|regex_match[/^[0-9,]+$/]|min_length[10]|max_length[10]');
           		$this->form_validation->set_rules('driver_address', ' address', 'trim|required');   
           		$this->form_validation->set_rules('licence_plate', ' licence plate', 'trim|required');
           		$this->form_validation->set_rules('color', ' color', 'trim|required');
           		
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                   }
                }
                else
                {
$zip=implode(', ',$this->input->post("zip"));
                    $this->load->model("common_model");
                    $array = array( 
                    "first_name"=>$this->input->post("first_name"), 
                    "last_name"=>$this->input->post("last_name"),
                    "email"=>$this->input->post("email"),
                    "phone"=>$this->input->post("phone"),
                    "transport_type"=>$this->input->post("transport_type"),
                    "color"=>$this->input->post("color"),
			"zip"=>$this->input->post("zip"),
                    "driver_address"=>$this->input->post("driver_address"),
                    "licence_plate"=>$this->input->post("licence_plate"),
                    "date_modified"=>date('Y-m-d h:i:s'),
'zip'=>$zip,
                    );
                    
                    if(!empty($this->input->post("password")))
                    {
                        $array["password"]=md5($this->input->post("password"));    
                    }
                    
                    if($_FILES["profile_photo"]["size"] > 0){
                        $config['upload_path']          = './uploads/driver/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg|jfif';
                        $this->load->library('upload', $config);
        
                        if ( ! $this->upload->do_upload('profile_photo'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $array["profile_photo"]=$img_data['file_name'];
                        }
                        
                   }
                   
                    
                    $this->common_model->data_update("driver",$array,array("driver_id"=>$driver_id)); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request updated successfully...
                                    </div>');
                    redirect('admin/driver');
                }
            }
            $this->load->model("shop_model");
            $q=$this->db->query("SELECT * FROM driver where driver_id=".$driver_id);
            $data["driver"] = $q->row();
            $this->load->view("admin/driver/edit_driver",$data);
        }
        else
        {
            redirect('admin');
        }
    
    } 
    
          function updatedriverdetails($driver_id,$status){
    	 if(_is_user_login($this)){
    	 	//echo $user_id;
    	 	//echo $status;
    	 	//echo $this->input->post("status");
    	 	//die();
    	 	$update_status	=	"";
    	 	if($status==0){
    	 		$update_status	=	"Deactive";
    	 	}
    	 	else{
    	 		$update_status	=	"Active";
    	 	}
            $this->db->query("Update driver set status='".$update_status."' where driver_id = '".$driver_id."'");
            $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request updated successfully...
                                    </div>');
           	redirect("admin/driver");
        }
    }
    
    function delete_driver($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from driver where driver_id = '".$id."'");
            $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request deleted successfully...
                                    </div>');
            redirect("admin/driver");
        }        
    }

 

		function add_shop(){   

			if(_is_user_login($this)){  

	   		if(isset($_POST))
            {
                $this->load->library('form_validation');               
                $this->form_validation->set_rules('shop_title', 'shop title', 'trim|required');
                $this->form_validation->set_rules('shop_email', 'shop email id', 'trim|required|valid_email');
                $this->form_validation->set_rules('contact_number', 'shop contact number', 'trim|required|numeric|regex_match[/^[0-9,]+$/]|min_length[10]|max_length[10]');
           		$this->form_validation->set_rules('shop_address', 'shop address', 'trim|required');              	
               // $this->form_validation->set_rules('shop_lat', 'shop address', 'trim|required');
                //$this->form_validation->set_rules('shop_long', 'shop address', 'trim|required');
              
                if ($this->form_validation->run() == FALSE)
        		{
        		      if($this->form_validation->error_string()!="") { 
        			     $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                    }
                }
                else
                {
                    $this->load->model("common_model");
                    $array = array( 
                    "shop_name"=>$this->input->post("shop_title"), 
                    
                    "shop_email_id"=>$this->input->post("shop_email"),
                    "shop_contact_no"=>$this->input->post("contact_number"),
                    "shop_address"=>$this->input->post("shop_address"),
                    "shop_lat"=>$this->input->post("shop_lat"),
                    "shop_long"=>$this->input->post("shop_long"),
                    "status"=>"Active",
                    "created_date"=>date('Y-m-d')
                    );
                   
                    if($_FILES["logo"]["size"] > 0){
                        $config['upload_path']          = './uploads/shop/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg|jfif';
                        $this->load->library('upload', $config);
        
                        if ( ! $this->upload->do_upload('logo'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $array["logo"]=$img_data['file_name'];
                        }
                        
                   }
                   
                    $this->common_model->data_insert("shop_master",$array); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/shop');
                }
            }
             $this->load->view("admin/shop/add_shop");

          }
          else
          {
            redirect('admin');
          }           
      }


      function edit_shop($shop_id){
       if(_is_user_login($this)){
        
           // $this->load->model("shop_model");
           // $data["shop"]  = $this->shop_model->get_shop_by_id($shop_id);
           // $this->load->view("admin/shop/edit_shop",$data);

            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('shop_title', 'shop Title', 'trim|required');
                $this->form_validation->set_rules('shop_email', 'shop email id', 'trim|required|valid_email');
                $this->form_validation->set_rules('contact_number', 'shop contact number', 'trim|required|numeric|regex_match[/^[0-9,]+$/]|min_length[10]|max_length[10]');
                $this->form_validation->set_rules('shop_address', 'shop address', 'trim|required');

                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                   }
                }
                else
                {
                    $this->load->model("common_model");
                    $array = array( 
                    "shop_name"=>$this->input->post("shop_title"), 
                    "shop_email_id"=>$this->input->post("shop_email"), 
                    "shop_contact_no"=>$this->input->post("contact_number"),
                    "shop_address"=>$this->input->post("shop_address"),
                    "shop_long"=>$this->input->post("shop_lat"),
                    "shop_long"=>$this->input->post("shop_long"),
                    "status"=>"Active",
                    "updated_date"=>date('Y-m-d')                    
                    );
                    
                    if($_FILES["logo"]["size"] > 0){
                        $config['upload_path']          = './uploads/shop/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg|jfif';
                        $this->load->library('upload', $config);
        
                        if ( ! $this->upload->do_upload('logo'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $array["logo"]=$img_data['file_name'];
                        }
                        
                   }
                   
                    
                    $this->common_model->data_update("shop_master",$array,array("shop_id"=>$shop_id)); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/shop');
                }
            }
            $this->load->model("shop_model");
            $data["shop"] = $this->shop_model->get_shop_by_id($shop_id);
            $this->load->view("admin/shop/edit_shop",$data);
        }
        else
        {
            redirect('admin');
        }
    
    } 

    function delete_shop($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from shop_master where shop_id = '".$id."'");
            $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request deleted successfully...
                                    </div>');
            redirect("admin/shop");
        }        
    }

    function updateshopdetails($shop_id,$status){
    	 if(_is_user_login($this)){
    	 	//echo $user_id;
    	 	//echo $status;
    	 	//echo $this->input->post("status");
    	 	//die();
    	 	$update_status	=	"";
    	 	if($status==0){
    	 		$update_status	=	"Deactive";
    	 	}
    	 	else{
    	 		$update_status	=	"Active";
    	 	}
            $this->db->query("Update shop_master set status='".$update_status."' where shop_id = '".$shop_id."'");
            $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request updated successfully...
                                    </div>');
           	redirect("admin/shop");
        }
    }

    function global_setting(){
        if(_is_user_login($this)){

        

            if(isset($_POST))
            {
                $this->load->library('form_validation');

          //       if(!isset($_SESSION["shop_id"])){
		        // 	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
		        // }
                $this->form_validation->set_rules('new_user_reg_amt','Enter registration amount','trim|required|numeric|regex_match[/^[0-9,]+$/]');
                $this->form_validation->set_rules('wallet_percntg_amt_min','Enter wallet amount','trim|required|numeric|greater_than[0.99]|less_than[100]|regex_match[/^[0-9,]+$/]');
                $this->form_validation->set_rules('wallet_percntg_amt_max','Enter wallet amount','trim|required|numeric|greater_than[0.99]|less_than[100]|regex_match[/^[0-9,]+$/]');
                $this->form_validation->set_rules('refer_and_earn_amt','Enter refer and earn amount','trim|required|numeric|regex_match[/^[0-9,]+$/]');
                $this->form_validation->set_rules('delivery_charges','Enter delivery charges','trim|required|numeric|regex_match[/^[0-9,]+$/]');
                $this->form_validation->set_rules('deal_max_count','Enter deal max count','trim|required|numeric|regex_match[/^[0-9,]+$/]');

                if ($this->form_validation->run() == FALSE)
                {
                      if($this->form_validation->error_string()!="") { 
                         $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                <i class="fa fa-warning"></i>
                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                              <strong>Warning!</strong> '.$this->form_validation->error_string().'
                            </div>');
                        }
                }
                else{
                        $this->load->model("common_model");
                        $array = array( 
                        "new_user_reg_amt"=>$this->input->post("new_user_reg_amt"), 
                        "wallet_limit_min"=>$this->input->post("wallet_percntg_amt_min"), 
                        "wallet_limit_max"=>$this->input->post("wallet_percntg_amt_max"), 
                        "refer_and_earn"=>$this->input->post("refer_and_earn_amt"),
                        "delivery_charges"=>$this->input->post("delivery_charges"), 
                       // "shop_id"=>$_SESSION["shop_id"],      
                        "deal_max_count"=>$this->input->post("deal_max_count"),                           
                        "created_date"=>date('Y-m-d h:i:s A')                    
                        );
                                              
                        $this->common_model->data_insert("global_setting",$array); 
                        $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your request added successfully...
                                        </div>');
                        redirect('admin/global_setting');
                }                
            }
           // $this->load->view("admin/global_setting/add_global_setting");
           $this->load->model("global_setting_model");
           $data["globe_setting"]       = $this->global_setting_model->get_global_setting_last_id();
           $data["globe_settings_all"]  = $this->global_setting_model->get_global_setting_all();
           $this->load->view("admin/global_setting/add_global_setting.php",$data);
        }
        else
        {
             redirect('admin');
        }
    }    

    function add_subsription(){

        if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
				
				// if(!isset($_SESSION["shop_id"])){
		        // 	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
		        // }
                
				$this->form_validation->set_rules('subscription_name', 'subscription name', 'trim|required');
                $this->form_validation->set_rules('subscription_days', 'subscription days', 'trim|required|numeric|regex_match[/^[0-9,]+$/]');
                $this->form_validation->set_rules('subscription_price', 'subscription price', 'trim|required|numeric|regex_match[/^[0-9,]+$/]');
               // $this->form_validation->set_rules('subscription_image', 'subscription image', 'trim|required');
                //$this->form_validation->set_rules('subscription_details1', 'subscription details1', 'trim|required');
                //$this->form_validation->set_rules('subscription_details2', 'subscription details2', 'trim|required');
                //$this->form_validation->set_rules('subscription_details3', 'subscription details3', 'trim|required');
                //$this->form_validation->set_rules('min_limit_apply', 'Amount Min', 'trim|required|numeric');
                //$this->form_validation->set_rules('max_limit_apply', 'Amount Max', 'trim|required|numeric');
                $this->form_validation->set_rules('subs_status', 'subscription status', 'trim|required'); 
                
                if ($this->form_validation->run() == FALSE)
                {
                      if($this->form_validation->error_string()!="") { 
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                 }
                                   
                }
                else
                {
                    $blc_unblk  =   '0';
                    $free_deli  =   '0';
                    $cashback   =   '0';

                    if($this->input->post("subscription_details1")==null OR $this->input->post("subscription_details1")!='1')
                    {
                       $blc_unblk   =   '0';     
                    }
                    else
                    {
                        $blc_unblk   =   '1';   
                    }     

                    if($this->input->post("subscription_details2")==null OR $this->input->post("subscription_details2")!='1')
                    {
                       $free_deli   =   '0';     
                    }
                    else
                    {
                        $free_deli   =   '1';   
                    }   
                    $max_limit_apply=0;
                    if($free_deli==1)
                    {
                       $max_limit_apply=$this->input->post("max_limit_apply");
                    }

                    if($this->input->post("subscription_details3")==null OR $this->input->post("subscription_details3")!='1')
                    {
                       $cashback   =   '0';     
                    }
                    else
                    {
                        $cashback   =   '1';   
                    }                  

                    $this->load->model("common_model");
                    $array = array( 
                    "subscription_name"=>$this->input->post("subscription_name"), 
                    "subscription_days"=>$this->input->post("subscription_days"),
                    "subscription_price"=>$this->input->post("subscription_price"),
                    "subscription_details1"=>$this->input->post("subscription_details1"),
                    "subscription_details2"=>$free_deli,                    
                    "subscription_details3"=>$cashback,
                    //"cashback_amt"=>$this->input->post("cashbackamt"),
                    //"min_limit_apply"=>$this->input->post("min_limit_apply"),
                    "max_limit_apply"=>$max_limit_apply,
                    "is_active"=>$this->input->post("subs_status")
                    //"shop_id"=>$_SESSION["shop_id"]
                    );
                    if($_FILES["subscription_image"]["size"] > 0){
                        $config['upload_path']          = './uploads/subscription/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg|jfif';
                        $this->load->library('upload', $config);
        
                        if ( ! $this->upload->do_upload('subscription_image'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $array["subscription_image"]=$img_data['file_name'];
                        }
                        
                   }
                    
                    $this->common_model->data_insert("subscription_plan",$array); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/subscription_list');
                }
            }
            
            $this->load->view("admin/subscription/add_subscription");
        }
        else
        {
            redirect('admin');
        }  
    }

    function subscription_list(){
        if(_is_user_login($this)){

           $this->load->model("subscription_model");
           $data["subscriptions"] = $this->subscription_model->get_all_subscription();
           $this->load->view("admin/subscription/subscription_list",$data);
        }
        else{
            redirect('admin');
        }                    
    }

    function delete_subscription($subscription_id){
        if(_is_user_login($this)){
        $this->db->query("Delete from subscription_plan where subscription_id = '".$subscription_id."'");
         $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request deleted successfully...
                                    </div>');
        redirect("admin/subscription_list");
        }
    }

    function edit_subscription($subscription_id){
       if(_is_user_login($this)){
        
            if(isset($_POST))
            {
                $this->load->library('form_validation');
          //       if(!isset($_SESSION["shop_id"])){
		        // 	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
		        // }
                $this->form_validation->set_rules('subscription_name', 'subscription name', 'trim|required');
                $this->form_validation->set_rules('subscription_days', 'subscription days', 'trim|required|numeric|regex_match[/^[0-9,]+$/]');
                $this->form_validation->set_rules('subscription_price', 'subscription price', 'trim|required|numeric|regex_match[/^[0-9,]+$/]');
               // $this->form_validation->set_rules('subscription_image', 'subscription image', 'trim|required');
               // $this->form_validation->set_rules('subscription_details1', 'subscription details1', 'trim|required');
              //  $this->form_validation->set_rules('subscription_details2', 'subscription details2', 'trim|required');
               // $this->form_validation->set_rules('subscription_details3', 'subscription details3', 'trim|required');
                // $this->form_validation->set_rules('min_limit_apply', 'min limit apply', 'trim|required|numeric|regex_match[/^[0-9,]+$/]');
                //$this->form_validation->set_rules('max_limit_apply', 'max limit apply', 'trim|required|numeric|regex_match[/^[0-9,]+$/]');
                $this->form_validation->set_rules('subs_status', 'subscription status', 'trim|required'); 
                
                if ($this->form_validation->run() == FALSE)
                {
                   if($this->form_validation->error_string()!=""){
                      $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                        <i class="fa fa-warning"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Warning!</strong> '.$this->form_validation->error_string().'
                                    </div>');
                   }
                }
                else
                {
                    $blc_unblk  =   '0';
                    $free_deli  =   '0';
                    $cashback   =   '0';

                    if($this->input->post("subscription_details1")==null AND $this->input->post("subscription_details1")!='1')
                    {
                       $blc_unblc   =   '0';     
                    }
                    else
                    {
                        $blc_unblk   =   '1';   
                    }     

                    if($this->input->post("subscription_details2")==null AND $this->input->post("subscription_details2")!='1')
                    {
                       $free_deli   =   '0';     
                    }
                    else
                    {
                        $free_deli   =   '1';   
                    }   

                    if($this->input->post("subscription_details3")==null && $this->input->post("subscription_details3")!='1')
                    {
                       $cashback   =   '0';     
                    }
                    else
                    {
                        $cashback   =   '1';   
                    }   
                    $max_limit_apply=0;
                    if($free_deli==1)
                    {
                       $max_limit_apply=$this->input->post("max_limit_apply");
                    }
                    $this->load->model("common_model");
                    $array = array( 
                    "subscription_name"=>$this->input->post("subscription_name"), 
                    "subscription_days"=>$this->input->post("subscription_days"),
                    "subscription_price"=>$this->input->post("subscription_price"),
                    //"subscription_details1"=>$blc_unblk,
                    //"subscription_details2"=>$free_deli,                    
                    //"subscription_details3"=>$cashback,
                    //"cashback_amt"=>$this->input->post("cashbackamt"),
                    //"min_limit_apply"=>$this->input->post("min_limit_apply"),
                    //"max_limit_apply"=>$max_limit_apply,
                    "is_active"=>$this->input->post("subs_status")
                    //"shop_id"=>$_SESSION["shop_id"]
                    
                    );
                    if($_FILES["subscription_image"]["size"] > 0){
                        $config['upload_path']          = './uploads/subscription/';
                        $config['allowed_types']        = 'gif|jpg|png|jpeg|jfif';
                        $this->load->library('upload', $config);
        
                        if ( ! $this->upload->do_upload('subscription_image'))
                        {
                                $error = array('error' => $this->upload->display_errors());
                        }
                        else
                        {
                            $img_data = $this->upload->data();
                            $array["subscription_image"]=$img_data['file_name'];
                        }                        
                   }
                    
                    $this->common_model->data_update("subscription_plan",$array,array("subscription_id"=>$subscription_id)); 
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect('admin/subscription_list');
                }
            }
            $this->load->model("subscription_model");
            $data["subscriptions"] = $this->subscription_model->get_subscription_by_id($subscription_id);
            $this->load->view("admin/subscription/edit_subscription",$data);
        }
        else
        {
            redirect('admin');
        }   
    }
    
    
    public function city()
	{
	   if(_is_user_login($this)){
	       
	       if(isset($_POST))
            {
                $this->load->library('form_validation');

          //       if(!isset($_SESSION["shop_id"])){
		        // 	$this->form_validation->set_rules('shop_list', 'Select shop name', 'trim|required');
		        // }
                $this->form_validation->set_rules('city','Enter City name','trim|required');
            
                if ($this->form_validation->run() == FALSE)
                {
                      if($this->form_validation->error_string()!="") { 
                         $this->session->set_flashdata("message", '<div class="alert alert-warning alert-dismissible" role="alert">
                                <i class="fa fa-warning"></i>
                              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                              <strong>Warning!</strong> '.$this->form_validation->error_string().'
                            </div>');
                        }
                }
                else{
                        $this->load->model("common_model");
                        $array = array( 
                        "city_name"=>$this->input->post("city"), 
                        "status"=>$this->input->post("status"), 
                        );
                                              
                        $this->common_model->data_insert("city",$array); 
                        $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                            <i class="fa fa-check"></i>
                                          <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                          <strong>Success!</strong> Your request added successfully...
                                        </div>');
                        redirect('admin/city');
                }                
            }
            
	       
	       
	       
	       
	       $data["error"] = "";
	       $data["active"] = "listcat";
           $this->load->model("City_model");
           $data["city"] = $this->City_model->sel_city();
           $this->load->view('admin/city/list',$data);
        }
        else
        {
            redirect('admin');
        }
    }
    
    function delete_city($id){
        if(_is_user_login($this)){
            $this->db->query("Delete from city where city_id = '".$id."'");
             $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request deleted successfully...
                                    </div>');
            redirect("admin/city");
        }
    }
    
    public function edit_city($id){
    if(_is_user_login($this)){
	    
            if(isset($_POST))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('city', 'City', 'trim|required');
                
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
                    "city_name"=>$this->input->post("city"),
                    "status"=>$this->input->post("status")
                    );
                    $this->common_model->data_update("city",$array,array("city_id"=>$id));
                    
                    $this->session->set_flashdata("message",'<div class="alert alert-success alert-dismissible" role="alert">
                                        <i class="fa fa-check"></i>
                                      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                      <strong>Success!</strong> Your request added successfully...
                                    </div>');
                    redirect("admin/city");
                }
           
           $this->load->model("City_model");
           $data["city"] = $this->City_model->get_city($id);
           $this->load->view('admin/city/edit',$data);
            }
        }
        
    }
    
    function setsession()
    {
    	if(_is_user_login($this)){
			//echo $this->input->post("previous_controller_name");

    		if($this->input->post("shop_list")=="")
    		{
    			if(isset($_SESSION["shop_id"])){
    				$this->session->unset_userdata('shop_id');
    				$this->session->unset_userdata('shop_name');
    			}    			
    		}
    		else{
    			$shop_details	=	array();
				$shop_details	=	explode(',',$this->input->post("shop_list"));

				$newdata = array(
	                               'shop_id'  => $shop_details[0],
	                               'shop_name' => $shop_details[1]
	                              );
	             $this->session->set_userdata($newdata);
    		}	
			
            redirect($this->input->post("previous_controller_name"));
    	}
    	else
    	{
    		redirect("admin");
    	}
    	
    }
}        
