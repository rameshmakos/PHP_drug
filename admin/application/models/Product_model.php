<?php
class Product_model extends CI_Model{
      function get_products($in_stock=false,$cat_id="",$search="", $page = ""){
            
            $filter = "";
            $limit = "";
            $page_limit = 10;
            if($page != ""){
                $limit .= " limit ".(($page - 1) * $page_limit).",".$page_limit." ";
            }
            if($in_stock){
                $filter .=" and products.in_stock = 1 ";
            }
            if($cat_id!=""){
                $filter .=" and products.category_id = '".$cat_id."' ";
            }
             if($search!=""){
                $filter .=" and products.product_name like '".$search."' ";
            }

            $shop_id    =   "";
            if(isset($_SESSION["shop_id"]))
            {
                //$shop_id    =   $_SESSION["shop_id"];
                //$shop_id    =   "";
                //$condition  =   "where products.shop_id=".$shop_id;
                $shop_id    =   "";
                $condition  =   "where 1";
            }
            else
            {
                $shop_id    =   "";
                $condition  =   "where 1";
            }

            $q = $this->db->query("Select dp.*,products.*, ( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,categories.title from products 
            inner join categories on categories.id = products.category_id
            left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id
           left join deal_product dp on dp.product_id=products.product_id ".$condition." ".$filter." ".$limit);
            //print_r($this->db->last_query());  

            $products =$q->result();
            //inner join product_price on product_price.product_id = products.product_id
            
            
            
            /*$prices = $this->get_product_price($in_stock);
            
            $products_output = array();
            foreach($products as $product){
                $price_array = array();
                foreach($prices as $price){
                    
                    if($price->product_id == $product->product_id){
                            $price_array[] = $price;        
                    }
                }
                $product->prices = $price_array;
                $products_output[] = $product;        
            }
            */
            //print_r($products);
            return $products; 
      }
      
      function get_header_products($in_stock=false,$cat_id="",$search="", $page = ""){
            $filter = "";
            $limit = "";
            $page_limit = 10;
            if($page != ""){
                $limit .= " limit ".(($page - 1) * $page_limit).",".$page_limit." ";
            }
            if($in_stock){
                $filter .=" and header_products.in_stock = 1 ";
            }
            if($cat_id!=""){
                $filter .=" and header_products.category_id = '".$cat_id."' ";
            }
             if($search!=""){
                $filter .=" and header_products.product_name like '".$search."' ";
            }
            if(isset($_SESSION["shop_id"]))
            {
                $shop_id    =   $_SESSION["shop_id"];
                $condition  =   "where products.shop_id=".$shop_id;
            }
            else
            {
                $shop_id    =   "";
                $condition  =   "where 1";
            }

            $q = $this->db->query("Select header_products.*,( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock ,header_categories.title from header_products 
            inner join header_categories on header_categories.id = header_products.category_id
            left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = header_products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = header_products.product_id ".$condition." ".$filter." ".$limit);
            $products = $q->result();
            //inner join product_price on product_price.product_id = products.product_id
            
            
            
            /*$prices = $this->get_product_price($in_stock);
            
            $products_output = array();
            foreach($products as $product){
                $price_array = array();
                foreach($prices as $price){
                    
                    if($price->product_id == $product->product_id){
                            $price_array[] = $price;        
                    }
                }
                $product->prices = $price_array;
                $products_output[] = $product;        
            }
            */
            return $products; 
      }
      
      function get_products_suggestion($in_stock=false,$cat_id="",$search="", $page = ""){
            $name=$_REQUEST['product_name'];
            $filter = "";
            $limit = "";
            $page_limit = 10;
            if($page != ""){
                $limit .= " limit ".(($page - 1) * $page_limit).",".$page_limit." ";
            }
            if($in_stock){
                $filter .=" and products.in_stock = 1 ";
            }
            if($cat_id!=""){
                $filter .=" and products.category_id = '".$cat_id."' ";
            }
             if($search!=""){
                $filter .=" and products.product_name like '.$search%%.'";
            }
            $q = $this->db->query("Select products.product_name, products.price, products.product_id from products where products.product_name like '$name%%'".$limit );
            $products = $q->result();
            //inner join product_price on product_price.product_id = products.product_id
            
            
            
            /*$prices = $this->get_product_price($in_stock);
            
            $products_output = array();
            foreach($products as $product){
                $price_array = array();
                foreach($prices as $price){
                    
                    if($price->product_id == $product->product_id){
                            $price_array[] = $price;        
                    }
                }
                $product->prices = $price_array;
                $products_output[] = $product;        
            }
            */
            return $products; 
      }
      
      function get_product_by_id($prod_id){
            $q = $this->db->query("Select products.*, categories.title from products 
            inner join categories on categories.id = products.category_id
            where 1 and products.product_id = '".$prod_id."' limit 1");
            return $q->row();
            
      }
      
      function get_header_product_by_id($prod_id){
            $q = $this->db->query("Select header_products.*, header_categories.title from header_products 
            inner join header_categories on header_categories.id = header_products.category_id
            where 1 and header_products.product_id = '".$prod_id."' limit 1");
            return $q->row();
            
      }
      
      function get_purchase_list(){
        //$q = $this->db->query("SELECT purchase. * , products.product_name, users.user_fullname FROM purchase INNER JOIN users ON purchase.store_id_login = users.user_id INNER JOIN products ON products.product_id = purchase.product_id WHERE 1 ");
        $q = $this->db->query("SELECT purchase. * , products.product_name, users.user_fullname FROM purchase INNER JOIN users ON users.user_id=1 INNER JOIN products ON products.product_id = purchase.product_id WHERE 1 ");

            //print_r($this->db->last_query());  
            return $q->result();
            
      }
      function get_purchase_by_id($id){
        $q = $this->db->query("Select purchase.* from purchase 
            where 1 and purchase_id = '".$id."' limit 1");
            return $q->row();
      }
      function get_product_price($in_stock=false,$prod_id=""){
            $filter = "";
            if($in_stock){
                $filter .=" and products.in_stock = 1 ";
            }
            if($prod_id!=""){
                $filter .=" and products.product_id = '".$prod_id."' ";
            }
            $q = $this->db->query("Select product_price.* from product_price 
            inner join products on products.product_id = product_price.product_id 
            where 1 ".$filter);
            return $q->result();
      } 
      
     
      
      
      function get_prices_by_ids($ids){
            $q = $this->db->query("Select product_price.* from product_price 
            where 1 and price_id in (".$ids.")");
            return $q->result();
      }
      function get_price_by_id($price_id){
        $q = $this->db->query("Select * from product_price 
            where 1 and price_id = '".$price_id."'");
            return $q->row();
      }
      function get_socity_by_id($id){
        $q = $this->db->query("Select * from socity 
            where 1 and socity_id = '".$id."'");
            return $q->row();
      }

      function get_socities($page="",$search=""){
        
        $shop_id    =   "";

        if(isset($_SESSION["shop_id"]))
        {
            $shop_id    =   $_SESSION["shop_id"];
            $condition  =   "and `shop_id`=".$shop_id;
        }
        else
        {
            $shop_id    =   "";
            $condition  =   "";
        }

         $filter = "";
         $limit = "";
         $page_limit = 10;
         if($page != ""){
             $limit.= " limit ".(($page - 1) * $page_limit).",".$page_limit." ";
         }
        
          if($search!=""){
             $filter.="where socity_name like '".$search."' ";
         }
         
         $q = $this->db->query("Select * from socity ".$filter."".$condition."".$limit." ORDER BY socity_id DESC");
            return $q->result();
      }
      function rewards_value(){
        
        $q = $this->db->query("Select point from rewards where id=1");
            return $q->result();
      }
      
      function update_reward($data){
         
        $this->db->where('id', 1);
        $this->db->update('rewards', $data);
        
      }
      
      function couponexist($coupon_code){
            $q = $this->db->query("Select id from coupons where coupon_code='".$coupon_code."'");
            return $q->result();
      }

      function coupon($data)
      {          
          $check=$this->db->insert('coupons',$data);
          
          return true;
      }
      
      function coupon_list($search="",$page="")
      {
          $shop_id    =   "";

          if(isset($_SESSION["shop_id"]))
          {
              $shop_id    =   $_SESSION["shop_id"];
              //$condition  =   "where `shop_id`=".$shop_id;
              $condition  =   "";
          }
          else
          {
              $shop_id    =   "";
              $condition  =   "";
          }

            $filter = "";
            $limit = "";
            $page_limit = 10;
            if($page != ""){
                $limit .= " limit ".(($page - 1) * $page_limit).",".$page_limit." ";
            }
           
             if($search!=""){
                $filter .=" and coupon_name like '".$search."' ";
            }
          
            $q = $this->db->query("Select * from coupons ".$condition." ".$filter." ".$limit." ");
          //  return $q->result();
          // $this->db->where($condition);
          // $query = $this->db->get('coupons');
          // //$this->db->where($condition);
          // //print_r($this->db->last_query());
          return $q->result();
      }

      function editCoupon($id,$data)
      {
        $this->db->where('id', $id);
        $this->db->update('coupons', $data);
        return true;
      }

      function deleteCoupon($id)
      {
         $this->db->where('id', $id);
        $this->db->delete('coupons');
        return true;
      }

      function getCoupon($id)
      {
        $this->db->select('*');
        $this->db->from('coupons');
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row_array(); 
      }

      function lookup($keyword){ 
        $this->db->select('*')->from('products'); 
       // $this->db->like('product_name',$keyword,'after'); 

        //$this->db->or_like('iso',$keyword,'after'); 
        $query = $this->db->get();     
        return $query->result(); 
      } 

       function looku($keyword){ 
        $this->db->select('*')->from('categories'); 

       // $this->db->like('title',$keyword,'after');
        $this->db->where('parent',0) ;
        //$this->db->or_like('iso',$keyword,'after'); 
        $query = $this->db->get();     
        return $query->result(); 
      } 

       function look($keyword){ 
        $this->db->select('*')->from('categories'); 
        //$this->db->like('title',$keyword,'after');
        $this->db->where('parent>',0) ; 
        //$this->db->or_like('iso',$keyword,'after'); 
        $query = $this->db->get();     
        return $query->result(); 
      } 

      function get_sale_by_user($user_id){
            $q = $this->db->query("Select * from sale where user_id = '".$user_id."' and  status != 4 ORDER BY sale_id DESC");
            return $q->result();
      }
      function get_sale_by_user2($user_id,$driver_id=false,$date=false){
            if($user_id)
            {
            $q = $this->db->query("Select delivered_order.*,sale.delivery_datetime from delivered_order INNER JOIN sale ON sale.sale_id=delivered_order.sale_id where delivered_order.user_id = '".$user_id."' and delivered_order.status != 3 ORDER BY sale_id DESC");    
            }
            if($driver_id)
            {
                $q = $this->db->query("Select delivered_order.*,sale.delivery_datetime,registers.user_fullname, registers.user_phone,registers.pincode,
         registers.socity_id,registers.house_no from delivered_order INNER JOIN sale ON sale.sale_id=delivered_order.sale_id  inner join registers on registers.user_id = sale.user_id where assign_driver = '".$driver_id."' and delivered_order.on_date='".$date."' and delivered_order.status != 3 ORDER BY sale_id DESC");
            }
            
            //echo $this->db->last_query();exit();
            return $q->result();
      }
      function get_sale_orders($filter=""){
         $sql = "Select distinct sale.*,registers.user_fullname, registers.user_phone,registers.pincode,
         registers.socity_id,registers.house_no, socity.socity_name,user_location.socity_id, sale.new_store_id ,
         user_location.pincode, user_location.house_no, user_location.receiver_name, user_location.receiver_mobile,driver.driver_id,driver.first_name,driver.last_name
         from sale 
            inner join registers on registers.user_id = sale.user_id
            left outer join user_location on user_location.location_id = sale.location_id
            left outer join socity on socity.socity_id = user_location.socity_id
            left outer join users on users.user_id = user_location.store_id
            left join driver on driver.driver_id=sale.assign_driver
            where  1 ".$filter." AND ((payment_method='Online Payment' AND txn_id IS NOT NULL) or (payment_method='COD' AND txn_id IS NULL)) ORDER BY sale_id DESC ";
            $q = $this->db->query($sql);
            return $q->result();
      } 
      
      function get_sale_order_by_id($order_id){
            $q = $this->db->query("Select distinct sale.*,sale.mobile as alter_mobile,concat('House Number: ',user_location.house_no,' ',user_location.pincode) address, registers.user_fullname,registers.user_phone,registers.pincode,registers.socity_id,registers.house_no, socity.socity_name, user_location.socity_id, user_location.pincode, user_location.house_no, user_location.receiver_name, user_location.receiver_mobile from sale 
            inner join registers on registers.user_id = sale.user_id
            left outer join user_location on user_location.location_id = sale.location_id
            left outer join socity on socity.socity_id = user_location.socity_id
            where sale_id = ".$order_id." limit 1");
           // echo $this->db->last_query();exit;
            return $q->row();
      } 
      function get_sale_order_items($sale_id){
        $q = $this->db->query("Select si.*,p.*,si.price as sale_price, si.product_name as p_name from sale_items si 
        inner join products p on p.product_id = si.product_id where sale_id = '".$sale_id."'");
       /* $data['data'][]= $q->result();
        $q = $this->db->query("Select si.*,hp.* from sale_items si 
        inner join header_products hp on hp.product_id = si.product_id 
        where sale_id = '".$sale_id."'");
		$data['data'][] = $q->result();
		/*if(empty($data)){
		 $q = $this->db->query("Select si.*,hp.* from sale_items si 
        inner join header_products hp on hp.product_id = si.product_id 
        where sale_id = '".$sale_id."'");
		}*/

    //int_r($data);exit();*/
            return $q->result();
      }
      
      function get_sale_order_items_android($sale_id){
        $q = $this->db->query("Select si.*,p.product_image,si.price as sale_price, si.product_name as p_name ,(si.price/si.qty) as single_price from sale_items si 
        inner join products p on p.product_id = si.product_id where sale_id = '".$sale_id."'");
            return $q->result();
      }
      
      function get_leftstock($search="",$page=""){

        $filter = "";
        $limit = "";
        $page_limit = 10;
        if($page != ""){
            $limit .= " limit ".(($page - 1) * $page_limit).",".$page_limit." ";
        }
        
         if($search!=""){
            $filter .=" AND products.product_name like '".$search."' ";
        }

        $q = $this->db->query("Select products.*,( ifnull (producation.p_qty,0) - ifnull(consuption.c_qty,0)) as stock from products 
        left outer join(select SUM(qty) as c_qty,product_id from sale_items group by product_id) as consuption on consuption.product_id = products.product_id 
            left outer join(select SUM(qty) as p_qty,product_id from purchase group by product_id) as producation on producation.product_id = products.product_id where products.shop_id=0 ".$filter." ".$limit."");
            
            /*echo "<pre>";
            //echo $this->db->last_query();
            print_r($q->result());
            exit;*/
        return $q->result();
      }
      
      function get_all_users($search="",$page=""){

            $filter = "";
            $limit = "";
            $page_limit = 10;
            if($page != ""){
                $limit .= " limit ".(($page - 1) * $page_limit).",".$page_limit." ";
            }
           
            if($search!=""){
                $filter .=" and registers.user_fullname like '".$search."' or registers.user_email like '".$search."' or registers.user_phone like '".$search."'";
            }
             
         $sql = "Select subscribe_plan.subscription_name,registers.*, ifnull(sale_order.total_amount, 0) as total_amount, total_orders, ifnull(sale_order.total_rewards, 0) as total_rewards  from registers 
            
            left outer join (Select sum(total_amount) as total_amount, count(sale_id) as total_orders, sum(total_rewards) as total_rewards, user_id from sale group by user_id) as sale_order on sale_order.user_id = registers.user_id
            left outer join subscribe_plan ON (registers.user_id=subscribe_plan.user_id AND subscribe_plan.purchase=1)
            where 1 ".$filter." order by user_id DESC ".$limit;
            $q = $this->db->query($sql);
            return $q->result();
      }

      function adddealproduct($data)
      {
        $this->db->insert('deal_product',$data);
        return true;
      }

       function getdealproducts()
      {
          $shop_id    =   "";

          if(isset($_SESSION["shop_id"]))
          {
              $shop_id    =   0;//$_SESSION["shop_id"];
              $condition  =   "where `shop_id`=".$shop_id;
          }
          else
          {
              $shop_id    =   "";
              $condition  =   "";
          }

          $query = $this->db->query("Select * from deal_product ".$condition."");
         // $query = $this->db->get('deal_product');
          return $query->result();
      }
      
      function getdealproduct($id)
      {
          $this->db->where('id',$id);
          $query=$this->db->get('deal_product');
          return $query->row();
      }
      
      function edit_deal_product($id,$data)
      {
          $this->db->where('id',$id);
          $this->db->update('deal_product',$data);
          return true;
      }
	  
	  function get_order_list()
	  {
		  
	  }
	  function delivery_boy_order($delivery_boy_id){
            $q = $this->db->query("Select * from sale where assign_to = '".$delivery_boy_id."'");
            return $q->result();
      }

      //22-3-19 vidyadhar//

        function get_all_product(){ 
        $this->db->select('*')->from('products'); 
        $query = $this->db->get();     
        return $query->result(); 
      } 
}
?>