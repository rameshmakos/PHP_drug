<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Order Details</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/bootstrap/css/bootstrap.min.css"); ?>" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
<!--     <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" /> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.2.1/css/buttons.dataTables.min.css" /> -->
    <!-- DataTables -->
 <!--    <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/plugins/datatables/dataTables.bootstrap.css"); ?>"> -->
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
    <style>
     @media print{
        .non-print,.non-print-form{
            display: none;
        }
        
     }
     .table { 
        margin-bottom: 2px; 
        border-width: 0px; 
        }
     
     
     </style> 
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <?php  $this->load->view("admin/common/common_header"); ?>
      <!-- Left side column. contains the logo and sidebar -->
      <?php  $this->load->view("admin/common/common_sidebar"); 
        $this->load->helper('shop_helper');
      ?>

       <script type="text/javascript">
      $(document).ready(function(){         
       var current_page_link =   window.location.pathname;

      var id_name = current_page_link.split("admin/");
      alert(id_name[1].search("categories"));
      if(id_name[1].search("orderdetails")!='-1')
      {
        if($(".set_active_class").hasClass("active"))
        {
          $(".set_active_class").removeClass("active");
          $("#orders").addClass("active");  
        }
        else{
          $("#orders").addClass("active");
        }
      }

      //alert(id_name[1]);
      });
    </script>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

                <!-- Content Header (Page header) -->
                 <section class="content-header">
                    <h1>
                         <?php echo $this->lang->line("Order");?>
                        
                    </h1>
                    
                </section>

                <!-- Main content -->
                <section class="content">
                <div style="margin-top: 10px;">
                <!--<select name="assign_driver" id="assign_driver">
                    <option>xyz</option>
                </select> -->   
                
                <div class="row non-print-form" id="non-print-form" style="display:<?php if($order->status == 3 || $order->status == 4) echo "none"; else echo "block";?>">
                    
                    <form action="" method="post">
                        <div class="col-md-4">
                            <div class="form-group">
                                
                                            <label class=""> <?php echo "Select Driver Name"; ?></label> 
                                            <select name="driver_id" id="driver_id"  class="form-control" required>
                                                <option value="">please select driver</option>
                                                
                                                <?php
                                                $q=$this->db->query("SELECT driver_id,first_name,last_name from driver where status='Active'");
                                                $list_driver=$q->result();
                                                if(!empty($list_driver))
                                                {
                                                    foreach($list_driver as $value)
                                                    {
                                                        if($order->assign_driver==$value->driver_id)
                                                        {
                                                            echo "<option value='$value->driver_id' selected>".$value->last_name.' '.$value->first_name."</option>";    
                                                        }else{
                                                            echo "<option value='$value->driver_id'>".$value->last_name.' '.$value->first_name."</option>";
                                                        }
                                                        
                                                    }
                                                }
                                                ?>
                                                
                                            </select>
                            
                            </div>
                            <div class="form-group">
                                                <input type="submit" class="btn btn-primary" name="submit" value="Assign Driver">
                            </div>
                        </div>
                        </form>
                </div>
                <input type="button" value="Print" onclick="window.print()" class="btn btn-success non-print" />
         
         
                </div>
                    <div class="row">
                        <div class="col-md-12">
                            <?php  if(!empty($this->session->flashdata('message'))){ //echo $this->session->flashdata('message'); 
                            }
                                     ?>
                            <!-- general form elements -->
                            <table id="" class="table table-bordered data_table">
                                <thead>
                                    <tr>
                                        <th colspan="5"><h3> <?php echo $this->lang->line("Order Details :");?></h3></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="5">
                                        <table class="table">
                                            <tr>
                                                <td valign="top">
                                                    <strong> <?php echo $this->lang->line("Order Id : ");?><?php echo $order->sale_id; ?></strong>
                                                    <br />
                                                    <strong>  <?php echo $this->lang->line("Order Date : ");?><?php echo date("d-M-Y",strtotime($order->on_date)); ?></strong>
                                                    <br />
                                                </td>
                                                <td>
                                                    <strong> <?php echo $this->lang->line("Delivery Details : ");?></strong><br />
                                                    <strong>  <?php echo $this->lang->line("Contact : ");?><?php echo $order->user_fullname ; ?>, <br/> Phone : <?php echo $order->mobile; ?></strong><br />
                                                    <strong>  <?php echo $this->lang->line("Address :");?></strong>
                                                    <address>
                                                        <?php echo $order->delivery_address; ?><br />
                                                    </address><br />
                                                    <b><?php echo $this->lang->line("Delivery Time :");?> </b><?php echo $order->delivery_time_from."".$order->delivery_time_to; ?>
                                                    <?php //echo $this->lang->line("Delivery Time :");?> <?php //echo date("H:i A",strtotime($order->delivery_time_from))." to ".date("H:i A",strtotime($order->delivery_time_to)); ?></p>
                                                
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <th> <?php echo "Shop Name";?></th>
                                    <th> <?php echo $this->lang->line("Product Name");?></th>
                                    <th> <?php echo $this->lang->line("Qty");?></th>
                                    <th> <?php echo $this->lang->line("Total Price");?> <?php echo $this->config->item("currency");?></th>
                                </tr>
                                <?php
                                /*
                                $order_items1=$this->db->query("SELECT sale_items.*,products.shop_id ,shop_master.shop_name FROM sale_items LEFT JOIN products on sale_items.product_id=sale_items.product_id  LEFT JOIN shop_master ON products.shop_id=shop_master.shop_id where sale_id=".$order->sale_id);
                                */
                                $order_items1=$this->db->query("Select * from sale_items where sale_id=".$order->sale_id);
                                $order_items2=$order_items1->result();
                                //echo "<pre>";print_r($order_items2);//exit();
                                $total_price=0;
                                foreach($order_items2 as $items){
                                    ?>
                                    <tr>
                                        <td><?php echo _get_name_product_shops($items->product_id); ?></td>
                                        <td><?php echo $items->product_name; ?><br />
                                        <?php 
                                            if(0<$items->price)
                                            {
                                                $price1=$items->price/$items->qty;    
                                            }else{
                                                $price1=$items->price;
                                            }
                                            
                                        echo $items->unit_value." ".$items->unit. "(".$this->config->item("currency").( $price1)." )"; ?>
                                        </td>
                                        <td>
                                            <?php echo $items->qty ; ?>
                                        </td>
                                        <td>
                                            <?php 
                                            echo $items->price;
                                            //$total_price=$total_price+($items->qty*$items->price);
                                             ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                                <tr>
                                    <td colspan="3"><strong class="pull-right"> <?php echo $this->lang->line("Total :");?></strong></td>
                                    <td >
                                        <strong class=""><?php echo $order->total_amount; ?>  <?php echo $this->config->item("currency");?></strong>
                                    </td>
                                </tr>
                                <?php 
                                if(0<$order->wallet_amount)
                                { ?>
                                  <tr>
                                    <td colspan="3"><strong class="pull-right"> <?php echo "Wallet Amount :"?></strong></td>
                                    <td >
                                        <strong class=""><?php echo "-".$order->wallet_amount; ?>  <?php echo $this->config->item("currency");?></strong>
                                    </td>
                                </tr>
                                <?php }
                                if(0<$order->coupon_amount)
                                { ?>
                                <tr>
                                    <td colspan="3"><strong class="pull-right"> <?php echo "Coupon Amount :"?></strong></td>
                                    <td >
                                        <strong class=""><?php echo "-".$order->coupon_amount; ?>  <?php echo $this->config->item("currency");?></strong>
                                    </td>
                                </tr>
                                <?php }?>
                                <tr>
                                    <td colspan="3"><strong class="pull-right">Delivery Charges :</strong></td>
                                    <td >
                                        <strong class=""><?php echo $order->delivery_charge; ?> <?php echo $this->config->item("currency");?></strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><strong class="pull-right">Net Total Amount :</strong></td>
                                    <td >
                                        <strong class=""><?php echo $order->total_net_amt; ?><?php echo $this->config->item("currency");?> </strong>
                                        
                                        
                                        <?php //echo "<pre>";print_r($order); ?>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
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
    <!-- <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
    <script src="//code.jquery.com/jquery-1.12.3.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.1/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js"></script> -->
    <script>
    $(document).ready(function() {
    // $('.data_table').DataTable( {
    //     dom: 'Bfrtip',
    //     buttons: [
    //          'print'
    //     ]
    // } );
} );
    </script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <!-- Bootstrap 3.3.5 -->
<!--     <script src="<?php echo base_url($this->config->item("theme_admin")."/bootstrap/js/bootstrap.min.js"); ?>"></script>
    
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/datatables/jquery.dataTables.min.js"); ?>"></script>
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/datatables/dataTables.bootstrap.min.js"); ?>"></script> -->
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
     
  </body>
</html>
