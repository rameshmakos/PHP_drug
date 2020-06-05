<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Edit Banner</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/bootstrap/css/bootstrap.min.css"); ?>" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/plugins/morris/morris.css"); ?>" >
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/plugins/jvectormap/jquery-jvectormap-1.2.2.css"); ?>" >
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/dist/css/AdminLTE.min.css"); ?>">
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
              Banner <?php echo $this->lang->line("");?> 
          </h1>
          
        </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <?php  if(isset($error)){ echo $error; }
                                    echo $this->session->flashdata('success_req'); ?>
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Edit Banner <?php echo $this->lang->line("");?> </h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                    <div class="col-md-6">
                                     <div class="form-group">
                                            <label class="">Banner Title<?php echo $this->lang->line("");?>  : <span class="text-danger">*</span></label>
                                            <input type="text" name="slider_title" class="form-control" placeholder="Banner Title" value="<?php echo $slider->slider_title; ?>"/>
                                        </div>
                                        </div>
                                   <div class="col-md-6">
                                     <div class="form-group">
                                            <label class="">Banner Url <?php echo $this->lang->line("");?>  : </label>
                                            <input type="text" name="slider_url" class="form-control" placeholder="Banner Url/Link" value="<?php echo $slider->slider_url;?>" />
                                        </div>
                                  </div>
                                   
                                         
                                        <div class="col-md-6">
                                     <div class="cat-img" style="width: 300px; height: 100px;"><img width="100%" height="100%" src="<?php echo $this->config->item('base_url').'uploads/sliders/'.$slider->slider_image ?>" /></div>
                                        <div class="form-group">
                                        
                                            <label><?php echo $this->lang->line("Image");?> : <span class="text-danger">*</span> </label>
                                            <input type="file" name="slider_img" />
                                        </div>
                                        </div>
                               
                                        <div class="col-md-6">
                                            
                                        <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Status");?> : <span class="text-danger">*</span></label>
                                            <select class="text-input form-control" name="slider_status">
                                                <option value="1" <?php if($slider->slider_status=="1"){echo "selected";} ?>> <?php echo $this->lang->line("Active");?>  </option>
                                                <option value="0" <?php if($slider->slider_status=="0"){echo "selected";} ?>> <?php echo $this->lang->line("Deactive");?>  </option>
                                                      
                                            </select>
                                        </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="">Category : <span class="text-danger">*</span></label>
                                                <select class="text-input form-control" name="sub_cat">
                                                   <option value="">Select</option>
                                                    
                                                    <?php  
                                                    $catid=$slider->sub_cat;
                                                    echo printCategory(0,0,$this);
                                                    function printCategory($parent,$leval,$th){
                                                    
                                                    $q = $th->db->query("SELECT a.*, Deriv1.count FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` WHERE a.`parent`=" . $parent);
                                                    $rows = $q->result();
                            
                                                    foreach($rows as $row){
                                                        if ($row->count > 0) {
                                                				
                                                                    //print_r($row) ;
                                                					//echo "<option value='$row[id]_$co'>".$node.$row["alias"]."</option>";
                                                                    printRow($row);
                                               					   // printCategory($row->id, $leval + 1,$th);
                                                					
                                                				} elseif ($row->count == 0) {
                                                					printRow($row);
                                                                    //print_r($row);
                                                				}
                                                        }
                            
                                                    }
                                                    function printRow($d){
                                                          
                                                    ?>
                                                     <option value="<?php echo $d->id; ?>"><?php for($i=0; $i<$d->leval; $i++){ echo "_"; } echo $d->title; ?></option>
                                                        
                                                     <?php } ?> 
                                                     
                                                </select>
                                            </div>
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <input type="submit" class="btn btn-primary" name="saveslider" value="Edit Banner" />
                                        <a href="<?php echo site_url("admin/banner"); ?>" class="btn btn-danger">Cancel</a>
                                    </div>
                                </form>
                            </div><!-- /.box -->
                        </div>

                    </div>
                    <!-- Main row -->
                </section><!-- /.content -->
           
        </div><!-- ./wrapper -->

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
    
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/morris/morris.min.js"); ?>"></script>
    <!-- Sparkline -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/sparkline/jquery.sparkline.min.js"); ?>"></script>
    <!-- jvectormap -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"); ?>"></script>
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"); ?>"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/knob/jquery.knob.js"); ?>"></script>
    
    <!-- AdminLTE App -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/dist/js/app.min.js"); ?>"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/dist/js/demo.js"); ?>"></script>
   
    <script type="text/javascript">
      $(document).ready(function(){         
       var current_page_link =   window.location.pathname;

      var id_name = current_page_link.split("admin/");
     // alert(id_name[1].search("categories"));
      if(id_name[1].search("edit_banner")!='-1')
      {
        if($(".set_active_class").hasClass("active"))
        {
          $(".set_active_class").removeClass("active");
          $("#slider").addClass("active");  
        }
        else{
          $("#slider").addClass("active");
        }
      }

      //alert(id_name[1]);
      });
    </script>
  </body>
</html>