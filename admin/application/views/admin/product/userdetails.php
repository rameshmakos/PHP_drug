<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | User Details</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/bootstrap/css/bootstrap.min.css"); ?>" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/plugins/datatables/dataTables.bootstrap.css"); ?>">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/dist/css/AdminLTE.css
    "); ?>">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/dist/css/skins/_all-skins.min.css"); ?>">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <?php  $this->load->view("admin/common/common_header"); ?>
      <!-- Left side column. contains the logo and sidebar -->
      <?php  $this->load->view("admin/common/common_sidebar"); ?>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

                <!-- Content Header (Page header) -->
                 <section class="content-header">
                    <h1>
                         <?php echo "User Details";?>
                        <small>Preview</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line("Admin");?></a></li>
                        
                        
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-6">
                            <?php  if(isset($error)){ echo $error; }
                                    echo $this->session->flashdata('message'); ?>
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <!--<form action="" method="post" enctype="multipart/form-data">-->
                                    <div class="box-body">
                                        
                                        
                                             
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label class=""><?php echo "User Name: ";?> </label>
                                            
                                            <?php echo $user->user_fullname; ?>
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">User Mobile No:</label>
                                            
                                            <?php echo $user->user_phone; ?>
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">User Email:</label>
                                            
                                            <?php echo $user->user_email; ?>
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">User DOB:</label>
                                            
                                            <?php echo $user->dob; ?>
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">DL Number:</label>
                                            
                                            <?php echo $user->DL_no; ?>
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">DL Number 1:</label>
                                            
                                            <?php echo $user->DL_no1; ?>
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">DL Date:</label>
                                            
                                            <?php echo $user->DL_date; ?>
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">DL Expire Date:</label>
                                            
                                            <?php echo $user->DL_expire_date; ?>
                                        </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">GST No:</label>
                                            
                                            <?php echo $user->GST_no; ?>
                                        </div></div>
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">GST Date:</label>
                                            
                                            <?php echo $user->GST_date; ?>
                                        </div></div>
                                        
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">TL No:</label>
                                            
                                            <?php echo $user->TL_no; ?>
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">TL Date:</label>
                                            
                                            <?php echo $user->TL_date; ?>
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="">TL Expire Date:</label>
                                            
                                            <?php echo $user->TL_expire_date; ?>
                                        </div>
                                        </div>
                                        
                                        <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="">Status</label>
                                            
                                            <?php if($user->status == "1"){ ?>
                      <span class="label label-success" ><a href="<?php echo site_url("admin/updateuserdetails/".$user->user_id."/0"); ?>" ><label style="color:white;"><?php echo $this->lang->line("Active");?></label><a></span><?php } else { ?><span class="label label-danger"><a href="<?php echo site_url("admin/updateuserdetails/".$user->user_id."/1"); ?>" ><label style="color:white;"><?php echo $this->lang->line("Deactive");?></label></a></span><?php } ?>
                                        </div>
                                        </div>
                                        
                                        
                                        <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="">DL Image:</label>
                                            
                                            <?php if(!empty($user->DL_image)) {?>    
                                            <img id="imageresource" width="50%" height="50%" src="<?php echo $this->config->item('base_url').'uploads/profile/'.$user->DL_image; ?>" />
                                            <?php } ?>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="">GST Image:</label>
                                            
                                            <?php if(!empty($user->DL_image)) {?>    
                                            <img id="imageresource" width="50%" height="50%" src="<?php echo $this->config->item('base_url').'uploads/profile/'.$user->GST_image; ?>" />
                                            <?php } ?>
                                        </div>
                                        
                                        
                                        <div class="form-group">
                                            <label class="">TL Image:</label>
                                            
                                            <?php if(!empty($user->DL_image))
 {?>    
                                            <img id="imageresource" width="50%" height="50%" src="<?php echo $this->config->item('base_url').'uploads/profile/'.$user->TL_image; ?>" />
                                            <?php } ?>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="">TL Image 1:</label>
                                            
                                            <?php if(isset($user->DL_image)) {?>    
                                            <img id="imageresource" width="50%" height="50%" src="<?php echo $this->config->item('base_url').'uploads/profile/'.$user->TL_Image1; ?>" />
                                            <?php } ?>
                                        </div>
                                        
                                        
                                        
                                        
                                        
                                         
                                    </div>
                                    <!--<div class="box-footer">
                                        <input type="submit" class="btn btn-primary" name="addcatg" value="Edit Product" />
                                        <a href="<?php echo site_url("admin/products"); ?>" class="btn btn-danger">Cancel</a>
                                    </div>
                                </form>-->
                            </div><!-- /.box -->
                        </div>
                    </div>
                    <!-- Main row -->
                </section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- /.content-wrapper -->
      
      <?php  $this->load->view("admin/common/common_footer"); ?>  

      
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/jQuery/jQuery-2.1.4.min.js"); ?>"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/bootstrap/js/bootstrap.min.js"); ?>"></script>
    <!-- DataTables -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/datatables/jquery.dataTables.min.js"); ?>"></script>
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/datatables/dataTables.bootstrap.min.js"); ?>"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/dist/js/app.min.js"); ?>"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/dist/js/demo.js"); ?>"></script>
    
  </body>
</html>

