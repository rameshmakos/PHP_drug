<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Add Subscription</title>
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
                        <?php echo $this->lang->line("Add Subscription");?>
                        <small>Preview</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line("Admin");?></a></li>
                        <li><a href="#"><?php echo $this->lang->line("Subscription");?></a></li>
                        <li class="active"><?php echo $this->lang->line("Add Subscription");?></li>
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
                                    <h3 class="box-title"><?php echo $this->lang->line("Add Subscription");?></h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Subscription Title :");?> <span class="text-danger">*</span></label> 
                                                    <input type="text" name="subscription_name" class="form-control" required placeholder="Subscription Title" maxlength="12"/>    
                                         </div>
                                         
                                        <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Subscription Days :");?> <span class="text-danger">*</span></label>
                                            <input type="number" name="subscription_days" class="form-control" min="1" required placeholder="Days"/>
                                        </div>
                                          <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Subscription Price :");?> <span class="text-danger">*</span></label>
                                            <input type="number" min="1" name="subscription_price" class="form-control" required placeholder="00.00"/>
                                        </div>

                                        <div class="form-group">
                                            <label><?php echo $this->lang->line("Subscription Image :");?> </label>
                                            <input type="file" name="subscription_image" accept="image/*"/>
                                        </div>

                                        <div class="form-group">
                                            <label class=""> <?php echo $this->lang->line("Member Price Block/Unblock"); ?> </label>
                                           <!--  <textarea name="subscription_details1" class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea> -->
                                           <!--  <p class="help-block"> <?php echo $this->lang->line("Subscription Datail1 :"); ?></p> --> <br />
                                           <input type="checkbox" name="subscription_details1" value="0" id="subscription_details1"  onclick="changevalue('subscription_details1')"/>
                                        </div>

                                        <div class="form-group">
                                            <label class=""> <?php echo $this->lang->line("Free Delivery"); ?> </label>
                                           <!--  <textarea name="subscription_details2" class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea> -->
                                            <!-- <p class="help-block"> <?php echo $this->lang->line("Subscription Datail2 :"); ?></p> --><br />
                                             <input type="checkbox" name="subscription_details2" value="0" id="subscription_details2" value="0" onclick="changevalue('subscription_details2')"/>
                                             <input type="number" name="max_limit_apply" min="1" id="max_limit_apply"  placeholder="Enter max amount" class="form-control" style="display:none;"/>
                                        </div>

                                        <div class="form-group">
                                            <label class=""> <?php echo $this->lang->line("Cashback"); ?> </label>
                                           <!--  <textarea name="subscription_details3" class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea> -->
                                            <!-- <p class="help-block"> <?php echo $this->lang->line("Subscription Datail3 :"); ?></p> --><br />
                                            <input type="checkbox" name="subscription_details3" value="0" id="subscription_details3" onclick="changevalue('subscription_details3')" />
                                        </div>
                                        
                                        <div class="form-group" id="cashbackid" style="display: none;">
                                            <!--<label class="">Cashback Amount <span class="text-danger"></span></label>-->
                                          <br />
                                            <input type="number" name="cashbackamt" value="0" id="cashbackamt" min="0" class="form-control" placeholder="Cashback amount" />
                                        </div>

                                          <!--<div class="form-group">
                                            <label class=""> <?php echo $this->lang->line("Amount Min :"); ?></label>
                                           <input type="number" name="min_limit_apply" id="min_limit_apply"  placeholder="Enter min amount" class="form-control"/>
                                          </div>-->
                                          <!-- <div class="form-group">
                                            <label class=""> <?php echo $this->lang->line("Amount Max :"); ?></label>
                                           <input type="number" name="max_limit_apply" id="max_limit_apply"  placeholder="Enter max amount" class="form-control"/>
                                          </div>-->

                                        <div class="form-group"> 
                                        <label class=""> <?php echo $this->lang->line("Subscription Status.");?><span class="text-danger">*</span></label><br>
                                            <div class="radio-inline">
                                                
                                                <label>
                                                    <input type="radio" name="subs_status" id="optionsRadios1" value="1" checked/>
                                                    <?php echo $this->lang->line("Active");?>
                                                </label>
                                            </div>
                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" name="subs_status" id="optionsRadios2" value="0"/>
                                                    <?php echo $this->lang->line("Deactive");?>
                                                </label>
                                            </div>
                                           
                                        </div>
                                        
                                    </div><!-- /.box-body -->
                                    
                                    <div class="box-footer">
                                        <input type="submit" class="btn btn-primary" name="addcatg" value="Add Subscription" />
                                         <a href="<?php echo site_url("admin/subscription_list"); ?>" class="btn btn-danger">Cancel</a>
                                       
                                    </div>
                                </form>
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
    <script>
      $(function () {
        
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
        $("body").on("change",".tgl_checkbox",function(){
            var table = $(this).data("table");
            var status = $(this).data("status");
            var id = $(this).data("id");
            var id_field = $(this).data("idfield");
            var bin=0;
                                         if($(this).is(':checked')){
                                            bin = 1;
                                         }
            $.ajax({
              method: "POST",
              url: "<?php echo site_url("admin/change_status"); ?>",
              data: { table: table, status: status, id : id, id_field : id_field, on_off : bin }
            })
              .done(function( msg ) {
                alert(msg);
              }); 
        });
      });
    </script>
    <script type="text/javascript">
      function checkvalue(){

            var min_value = $("#min_limit_apply").val();
            var max_value = $("#max_limit_apply").val();  

            var isValidMin = false;
            var isValidMax = false;
            var regex = /^[0-9]*$/;
            var flag  = 0;

            if(min_value!="" && min_value!=null){
              isValidMin = regex.test(min_value);
            }
            
            if(max_value!="" && max_value!=null){
              isValidMax = regex.test(max_value);
            }
            
            if(!isValidMin){
                 alert('Please enter number only');
                 $("#min_limit_apply").focus();
                 flag  = 1;
            }
            else if(parseInt(min_value)>100){
                 alert('Please enter number only less than 100%');
                 $("#min_limit_apply").focus();
                 flag  = 1;                
            }
            else{
                flag  = 0;
            }

             if(!isValidMax){
                 alert('Please enter number only');
                 $("#max_limit_apply").focus();
                 flag  = 1;
            }
            else if(parseInt(max_value)>100){
                 alert('Please enter number only less than 100%');
                 $("#max_limit_apply").focus();
                 flag  = 1;               
            }
            else{
                 flag  = 0;
            }

            if(flag==0){
                if(min_value!="" && max_value!="")
                {                 
                  if(parseInt(min_value) > parseInt(max_value)){
                    alert('Minimum amount must be less than maximum amount');
                    $("#min_limit_apply").focus();
                    return false;
                  }
                }
            } 
      }

      function changevalue(text){           
            var field_name  =   text;
            //alert($("#"+field_name).is(":checked"));
            if($("#"+field_name).is(":checked")){
                $("#"+field_name).val('1');
                
                if(field_name=='subscription_details1')
                {
                }else if(field_name=='subscription_details2'){
                    $("#cashbackamt").hide();
                    $("#max_limit_apply").show();
                    $("#max_limit_apply").prop("required", true);
                }else{
                }
                
                
            }
            else{
                $("#"+field_name).val('0');
                if(field_name=='subscription_details2'){
                   $("#max_limit_apply").hide(); 
                   $("#max_limit_apply").prop("required", false);
                }
                $("#cashbackid").hide();
            }
      }
    </script>
<script type="text/javascript">
$(document).ready(function()
{
$("#cashbackid").hide();
});
 </script>
    <script type="text/javascript">
      $(document).ready(function(){         
       var current_page_link =   window.location.pathname;

      var id_name = current_page_link.split("admin/");
     // alert(id_name[1].search("categories"));
      if(id_name[1].search("add_subsription")!='-1')
      {
        if($(".set_active_class").hasClass("active"))
        {
          $(".set_active_class").removeClass("active");
          $("#subscription_list").addClass("active");  
        }
        else{
          $("#subscription_list").addClass("active");
        }
      }

      //alert(id_name[1]);
      });
    </script>
  </body>
</html>
