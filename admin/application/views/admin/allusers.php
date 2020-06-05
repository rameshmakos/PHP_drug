<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <!-- <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/bootstrap/css/bootstrap.min.css"); ?>" />
  
    <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/plugins/daterangepicker/daterangepicker-bs3.css"); ?>">
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
   
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.1/css/buttons.dataTables.min.css" />
   
    <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/dist/css/AdminLTE.min.css
    "); ?>">
   
    <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/dist/css/skins/_all-skins.min.css"); ?>"> -->
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
            <?php echo $this->lang->line("Admin");?>
            <small><?php echo "App Users";?></small>
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
          <?php echo $this->session->flashdata("message"); ?>
          <h3><?php echo "App Users";?></h3>

          <div class="box-body table-responsive">
          <table id="example1" class="table table-bordered table-striped" >
                <thead>
                <tr>
                    <th class="text-center"><?php echo $this->lang->line("User ID");?></th>
                    <th><?php echo $this->lang->line("Name");?></th> 
                    <th><?php echo $this->lang->line("Phone");?>  </th>
                    <th><?php echo $this->lang->line("User Email");?></th> 
                    <th><?php echo $this->lang->line("Total Orders");?></th>
                    <th>Current Active subscription plan</th>
                     <td><b><?php echo "Wallet"; ?></b></td> 
                    <td><b><?php echo "From Referral Code"; ?></b></td>
			<td><b><?php echo "Last login"; ?></b></td>
                    <th><?php echo $this->lang->line("Referral Code");?></th> 
                    <th><?php echo $this->lang->line("Status");?></th>
			<th>User Details</th>
                </tr>
                </thead>
          <tbody>
          <?php
          $counter  = 0;
          foreach($users as $user)
          {
            
            ?>
           
                <tr>                    
                    <td class="text-center"><?php echo $counter + 1; ?></td>
                    <td><?php echo $user->user_fullname; ?></td> 
                    <td><?php echo $user->user_phone; ?></td>
                    <td><?php echo $user->user_email; ?></td> 
                    <td><?php echo $user->total_orders; ?></td>
                    <td><?php echo $user->subscription_name; ?></td>
                     <td><?php echo $user->wallet; ?></td> 
                    <td><?php if($user->from_referral_code!='') { echo $user->from_referral_code; } else { echo '-';} ?></td>
<td><?php echo $user->last_logged_in; ?></td>
                    <!-- <td><?php echo (($user->total_amount*100)/100); ?></td>  -->
                    <td><?php if($user->referral_code!='') { echo $user->referral_code; } else { echo '-';} ?></td>
                    <td><?php if($user->status == "1"){ ?>
                      <span class="label label-success" ><a href="<?php echo site_url("admin/updateuserdetails/".$user->user_id."/0"); ?>" ><label style="color:white;"><?php echo $this->lang->line("Active");?></label><a></span><?php } else { ?><span class="label label-danger"><a href="<?php echo site_url("admin/updateuserdetails/".$user->user_id."/1"); ?>" ><label style="color:white;"><?php echo $this->lang->line("Deactive");?></label></a></span><?php } ?></td>
<td><a href="<?php echo site_url("admin/getUserDetails/".$user->user_id.""); ?>" ><button class="btn btn-primary">User Details</button><a></span></td>
</tr>
            <?php
            $counter++;
          }
          ?>
          </tbody> 
          </table> 
        </div>

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      
      <?php  $this->load->view("admin/common/common_footer"); ?>  

      
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/jQuery/jQuery-2.1.4.min.js"); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/daterangepicker/daterangepicker.js"); ?>"></script>

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
        $('#daterange-btn').daterangepicker(
            {
              ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
              },
              startDate: moment().subtract(29, 'days'),
              endDate: moment()
            },
        function (start, end) {
          $('#reportrange').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
          $('#date_range_lable').val(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
          $('#date_range_field').val(start.format('YYYY-MM-D')+','+end.format('YYYY-MM-D'));
        }
        );
    });
    </script>
    <!-- jQuery UI 1.11.4 -->
   <!--  <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.1/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.1/js/buttons.flash.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script>
    <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.1/js/buttons.html5.min.js"></script> -->
   <!--  <script>
    $(document).ready(function() {
    $('.data_table').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
} );
    </script> -->
    <script>
      $(function () {
        
        $('#example1').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true,
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
      $(document).ready(function(){         
       var current_page_link =   window.location.pathname;

      var id_name = current_page_link.split("admin/");
     // alert(id_name[1].search("categories"));
      if(id_name[1].search("registers")!='-1' || id_name[1].search("updateuserdetails")!='-1')
      {
        if($(".set_active_class").hasClass("active"))
        {
          $(".set_active_class").removeClass("active");
          $("#registers").addClass("active");  
        }
        else{
          $("#registers").addClass("active");
        }
      }

      //alert(id_name[1]);
      });
    </script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/bootstrap/js/bootstrap.min.js"); ?>"></script>
    
    <!-- AdminLTE App -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/dist/js/app.min.js"); ?>"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/dist/js/pages/dashboard.js"); ?>"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/dist/js/demo.js"); ?>"></script>
    <!-- date-range-picker -->
    <!-- DataTables -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/datatables/jquery.dataTables.min.js"); ?>"></script>
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/datatables/dataTables.bootstrap.min.js"); ?>"></script>
  </body>
</html>
