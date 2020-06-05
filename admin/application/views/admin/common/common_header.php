<header class="main-header">
        <!-- Logo -->
        <a href="<?php echo site_url(_get_user_redirect($this)); ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>G</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b> <?php echo $this->lang->line("site_title");?></b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only"> <?php echo $this->lang->line("Toggle navigation");?></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <!--li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
       <span class="hidden-xs"><?php echo ($this->session->userdata('language') == "arabic") ? "ar" : "en";  ?></span>
                </a>
                <ul class="dropdown-menu">
                  <User image >
                  <li>
                    <a href="?lang=english">English</a>
                  </li>
                  <li>
                    <a href="?lang=arabic">Arabic</a>
                  </li>
                </ul>
              </li
              <li><label class="" style="color:white;padding-top: 15px;padding-bottom: 0px;"><?php echo $this->lang->line("Shop Name :");?></label> </li>
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding-top: 8px;padding-bottom: 0px;line-height: 0px;">
                  <?php $shps = _get_all_shops();

                    $session_shop_id  = '';
                    
                  ?>
                <form name="shop_list_form" id="shop_list_form" method="post" action="<?php echo site_url("/admin/setsession"); ?>">
                  <select name="shop_list" id="shop_list" class="form-control" onchange="SetSession('shop_list_form');">
                    <option value="">Select</option>

                  <?php
                  
                  foreach($shps as $shops)
                  {
                  ?>  
                      <option value="<?php echo $shops->shop_id.','.$shops->shop_name; ?>" <?php if(isset($_SESSION["shop_id"])){
                      if($shops->shop_id==$_SESSION["shop_id"]) { ?> selected <?php } } ?>><?php echo $shops->shop_name; ?></option>
                  <?php  
                  }
                  ?> 
                  </select>
                  <input type="hidden" name="previous_controller_name" value="<?= $this->uri->uri_string(); ?>" />
                </form>
                </a>
              </li>
            -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo base_url("img/user2-160x160.jpg"); ?>" class="user-image" alt="User Image">
                  <span class="hidden-xs"><?php echo _get_current_user_name($this); ?></span>
                </a>
                
                <ul class="dropdown-menu" style="width: 50%;">
                  <!-- User image -->
                  
                  <!-- Menu Body -->
                  <li>
                    <a href="<?php echo site_url("users/edit_user/"._get_current_user_id($this)); ?>" > <i class="fa fa-user"></i> Edit Profile </a>
                  </li>
                  <li>
                      <a href="<?php echo site_url("admin/signout") ?>" > <i class="fa fa-sign-out"></i><?php echo $this->lang->line("Sign out");?></a>
                  </li>
                  <!-- Menu Footer-->
                  
                </ul>
              </li> 
            </ul>
          </div>
        </nav>
      </header>
      <script>
        function SetSession(form_name)
        {         
          //alert(form_name);
          $("#"+form_name).submit();
        }
      </script>