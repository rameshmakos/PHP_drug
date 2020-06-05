<head><link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous"><aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="<?php echo base_url("img/user2-160x160.jpg"); ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><?php _get_current_user_name($this); ?></p>
              <a href="#"><i class="fa fa-circle text-success"></i>  <?php echo $this->lang->line("Online");?></a>
            </div>
          </div>
          
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header"><?php echo $this->lang->line("MAIN NAVIGATION");?></li>
            <li class="set_active_class treeview" id="dashboard">
              <a href="<?php echo site_url("admin/dashboard"); ?>">
                <i class="fab fa-dashcube"></i> <spadn> <?php echo $this->lang->line("Dashboard");?></span></i>
              </a>
            </li>
            <?php if(_get_current_user_type_id($this)==0){ ?>
            
            <li id="registers" class="set_active_class">
              <a href="<?php echo site_url("admin/registers"); ?>">
                <i class="fa fa-users"></i><span> <?php echo "App Users";?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li>
            <li id="listcategories" class="set_active_class">
              <a href="<?php echo site_url("admin/listcategories"); ?>">
                <i class="fa fa-folder-open"></i><span><?php echo $this->lang->line("Categories");?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li>
            <li id="brand" class="set_active_class">
              <a href="<?php echo site_url("admin/brand"); ?>">
                <i class="fa fa-circle"></i><span><?php echo "Brand";?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li>
		<li id="composition" class="set_active_class">
              <a href="<?php echo site_url("admin/composition"); ?>">
                <i class="fa fa-circle"></i><span><?php echo "Composition";?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li>
            <li id="products" class="set_active_class">
              <a href="<?php echo site_url("admin/products"); ?>">
                <i class="fab fa-product-hunt"></i><span><?php echo $this->lang->line("Products");?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li>
            
            <li id="driver" class="set_active_class">
              <a href="<?php echo site_url("admin/driver"); ?>">
                <i class="fa fa-motorcycle"></i><span><?php echo "Drivers";?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li>
            
             <li id="delivery_schedule_hours" class="set_active_class">
              <a href="#">
                <i class="fa fa-calendar-alt"></i><span><?php echo $this->lang->line("Delivery Schedule Hours");?></span><i class="fa fa-angle-left pull-right"></i></small>
              </a>
              <ul class="treeview-menu" class="set_active_class">
                    <li id="time_slot">
                      <a href="<?php echo site_url("admin/time_slot"); ?>">
                        <i class="fas fa-clock"></i><span><?php echo $this->lang->line("Time Slot");?></span> <small class="label pull-right bg-green"></small>
                      </a>
                    </li>
                    <li id="closing_hours" class="set_active_class">
                      <a href="<?php echo site_url("admin/closing_hours"); ?>">
                        <i class="fa fa-clock-o"></i><span><?php echo $this->lang->line("Closing Hours");?></span> <small class="label pull-right bg-green"></small>
                      </a>
                    </li>
                </ul>
            </li>
            <li id="add_purchase" class="set_active_class">
              <a href="<?php echo site_url("admin/add_purchase"); ?>">
                <i class="fab fa-stack-exchange"></i><span><?php echo "Stock Update";?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li>
            <li id="orders" class="set_active_class">
              <a href="<?php echo site_url("admin/orders"); ?>">
                <i class="fa fa-cart-arrow-down"></i><span><?php echo $this->lang->line("Orders_name");?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li>
            
            <li id="users" class="set_active_class">
              <a href="#">
                <i class="fa fa-thumbtack"></i><span><?php echo "Store Management";?></span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu"> 
                        <li><a href="<?php echo site_url("users"); ?>"><i class="fas fa-list-ol"></i>
                         <?php echo "List Store Users";?></a></li>
                        
                        
              </ul>
            </li>
            
            <li id="pages" class="set_active_class">
              <a href="#">
                <i class="fas fa-file-alt"></i><span><?php echo $this->lang->line("Pages");?></span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                         <li><a href="<?php echo site_url("admin/allpageapp"); ?>"><i class="fas fa-list-ol"></i><?php echo $this->lang->line("List");?></a></li>
                        
              </ul>
            </li>
            
            <!--<li id="declared_rewards" class="set_active_class">
              <a href="<?php echo site_url("admin/declared_rewards"); ?>">
                <i class="fas fa-rupee-sign"></i><span><?php echo "Declared Reward Value";?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li>-->
            
             <li id="setting" class="set_active_class">
              <a href="<?php echo site_url("admin/setting"); ?>">
                <i class="fa fa-cogs"></i><span><?php echo $this->lang->line("Order Limit Setting");?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li> 
             <li id="stock" class="set_active_class">
              <a href="<?php echo site_url("admin/stock"); ?>">
                <i class="fab fa-stack-overflow"></i><span><?php echo $this->lang->line("Stock");?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li> 
            <li id="notification" class="set_active_class">
              <a href="<?php echo site_url("admin/notification"); ?>">
                <i class="fa fa-bell"></i><span><?php echo $this->lang->line("Notification");?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li> 
             <li class="treeview" id="slider" class="set_active_class">
              <a href="#">
                <i class="fas fa-images"></i>
                <span> <?php echo $this->lang->line("Slider");?> </span>
                <span class="label label-primary pull-right"></span><i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu" >
                <li id="listslider" class="set_active_class"><a href="<?php echo site_url("admin/listslider"); ?>"><i class="fas fa-list-ol"></i><?php echo "  Main Slider";?> </a></li>
                <!--li><a href="<?php echo site_url("admin/addslider"); ?>"><i class="fas fa-plus-square"></i><?php echo $this->lang->line("Add New");?>  </a></li-->
                <li id="banner" class="set_active_class"><a href="<?php echo site_url("admin/banner"); ?>"><i class="fa fa-picture-o"></i><?php echo " All Banner";?>  </a></li>
                <li id="feature_banner" class="set_active_class"><a href="<?php echo site_url("admin/feature_banner"); ?>"><i class="far fa-image"></i><?php echo "  Featured Banner";?>  </a></li>
              </ul>
            </li>
            <!--li>
              <a href="<?php echo site_url("admin/banner"); ?>">
                <i class="fa fa-picture-o"></i> <span> <?php echo " Secondry Banner";?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li> 
            <li>
              <a href="<?php echo site_url("admin/feature_banner"); ?>">
                <i class="far fa-image"></i> <span> <?php echo "Featured Brand Banner";?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li--> 
            <li id="coupons" class="set_active_class">
              <a href="<?php echo site_url("admin/coupons"); ?>">
                <i class="fas fa-copyright" aria-hidden="true"></i><span><?php echo $this->lang->line("Coupons");?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li> 
            <li id="dealofday" class="set_active_class">
              <a href="<?php echo site_url("admin/dealofday"); ?>">
                <i class="fab fa-dyalog" aria-hidden="true"></i><span><?php echo $this->lang->line("dealofday");?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li> 
            <!--li>
              <a href="<?php echo site_url("admin/header_categories"); ?>">
                <i class="fa fa-list"></i> <span> <?php echo "Header Categories";?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li--> 
           <!--  <li id="help" class="set_active_class">
              <a href="<?php echo site_url("admin/help"); ?>">
                <i class="fa fa-list-alt"></i> <span> <?php echo "Rise a Ticket";?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li> --> 
             <li id="shop" class="set_active_class">
              <a href="<?php echo site_url("admin/shop"); ?>">
                <i class="fas fa-store"></i><span><?php echo "Shop";?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li> 
            <li id="global_setting" class="set_active_class">
              <a href="<?php echo site_url("admin/global_setting"); ?>">
               <i class="fa fa-users-cog"></i><span><?php echo "Global Setting";?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li> 
             <li id="subscription_list" class="set_active_class">
              <a href="<?php echo site_url("admin/subscription_list"); ?>">
               <i class="fab fa-stripe-s"></i><span><?php echo "Subscription";?></span> <small class="label pull-right bg-green"></small>
              </a>
            </li>            
            <?php  } ?>
             
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
