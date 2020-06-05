<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Dashboard</title>
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
                        <?php echo $this->lang->line("Add Global Setting");?>
                        <small>Preview</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line("Admin");?></a></li>
                        <li><a href="#"><?php echo $this->lang->line("Setting");?></a></li>
                        <li class="active"><?php echo $this->lang->line("Add Global Setting");?></li>
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
                                    <h3 class="box-title"><?php echo $this->lang->line("Add Global Setting");?></h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("New User Registration :");?> <span class="text-danger">*</span></label> 
                                            <input type="text" name="new_user_reg_amt" class="form-control" value="<?php if(isset($globe_setting)){echo $globe_setting->new_user_reg_amt;} ?>" placeholder="Reg Amount"/>
                                         </div>
                                          <div class="form-group">
                                            <label class=""> <?php echo $this->lang->line("Wallet % Limit Min :"); ?></label>
                                           <input type="text" name="wallet_percntg_amt_min" id="wallet_percntg_amt_min" onkeyup="checkvalue();" value="<?php if(isset($globe_setting)){echo $globe_setting->wallet_limit_min;} ?>" class="form-control" placeholder="Wallet amount min"/>
                                          </div>
                                           <div class="form-group">
                                            <label class=""> <?php echo $this->lang->line("Wallet % Limit Max :"); ?></label>
                                           <input type="text" name="wallet_percntg_amt_max" id="wallet_percntg_amt_max" onkeyup="checkvalue();" value="<?php if(isset($globe_setting)){echo $globe_setting->wallet_limit_max;} ?>" class="form-control" placeholder="Wallet amount max"/>
                                          </div>
                                         <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Refer & Earn :");?> <span class="text-danger">*</span></label>
                                            <input type="text" name="refer_and_earn_amt" value="<?php if(isset($globe_setting)){echo $globe_setting->refer_and_earn;} ?>" class="form-control" placeholder="Refer & earn amount"/>                                          
                                        </div>
                                        <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Delivery Charges :");?> <span class="text-danger">*</span></label>
                                             <input type="text" name="delivery_charges" value="<?php if(isset($globe_setting)){echo $globe_setting->delivery_charges;} ?>" id="delivery_charges" class="form-control" placeholder="Delivery charges"/> 
                                        </div>
                                         <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Deal Max Count :");?> <span class="text-danger">*</span></label>
                                             <input type="number" min="1" name="deal_max_count" value="<?php if(isset($globe_setting)){echo $globe_setting->deal_max_count;} ?>" id="deal_max_count" class="form-control" placeholder="Deal max count"/> 
                                        </div>
                                       
                                    </div><!-- /.box-body -->

                                        

                                    <div class="box-footer">
                                        <input type="submit" class="btn btn-primary" name="addcatg" value="Add / Update Setting" />
                                    </div>
                                </form>
                            </div><!-- /.box -->
                        </div>
                        <div class="col-xs-6">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo $this->lang->line("Setting");?></h3>                                    
                                </div><!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center"><?php echo $this->lang->line("ID");?></th>
                                                <th><?php echo $this->lang->line("New User Registration");?></th>
                                                <th><?php echo $this->lang->line("Wallet % Limit Min");?></th>
                                                <th><?php echo $this->lang->line("Wallet % Limit Max");?></th>
                                                <th><?php echo $this->lang->line("Refer & Earn");?></th>
                                                <th><?php echo $this->lang->line("Delivery Charges");?></th>
                                                <th><?php echo $this->lang->line("Deal Max Count");?></th>
                                                <th><?php echo $this->lang->line("DateTime");?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php $counter = 0; foreach($globe_settings_all as $globe_setting_all){ ?>
                                            <tr>
                                                <td class="text-center"><?php echo $counter+1; ?></td>
                                                <td><?php echo $globe_setting_all->new_user_reg_amt; ?></td>
                                                <td><?php echo $globe_setting_all->wallet_limit_min; ?></td>
                                                <td><?php echo $globe_setting_all->wallet_limit_max; ?></td>
                                                <td><?php echo $globe_setting_all->refer_and_earn; ?></td>
                                                <td><?php echo $globe_setting_all->delivery_charges; ?></td>
                                                <td><?php echo $globe_setting_all->deal_max_count; ?></td>
                                                <td><?php echo $globe_setting_all->created_date; ?></td>
                                            </tr>
                                            <?php $counter++; } ?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
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
        
        $('#example1').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
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

            var min_value = $("#wallet_percntg_amt_min").val();
            var max_value = $("#wallet_percntg_amt_max").val();  

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
                 $("#wallet_percntg_amt_min").focus();
                 flag  = 1;
            }
            else if(parseInt(min_value)>100){
                 alert('Please enter number only less than 100%');
                 $("#wallet_percntg_amt_min").focus();
                 flag  = 1;                
            }
            else{
                flag  = 0;
            }

             if(!isValidMax){
                 alert('Please enter number only');
                 $("#wallet_percntg_amt_max").focus();
                 flag  = 1;
            }
            else if(parseInt(max_value)>100){
                 alert('Please enter number only less than 100%');
                 $("#wallet_percntg_amt_max").focus();
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
                    $("#wallet_percntg_amt_min").focus();
                    return false;
                  }
                }
            } 
      }
    </script>

    <script type="text/javascript">
      $(document).ready(function(){         
       var current_page_link =   window.location.pathname;

      var id_name = current_page_link.split("admin/");
     // alert(id_name[1].search("categories"));
      if(id_name[1].search("global_setting")!='-1')
      {
        if($(".set_active_class").hasClass("active"))
        {
          $(".set_active_class").removeClass("active");
          $("#global_setting").addClass("active");  
        }
        else{
          $("#global_setting").addClass("active");
        }
      }

      //alert(id_name[1]);
      });
    </script>

  </body>
</html>
