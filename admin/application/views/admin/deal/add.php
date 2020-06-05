<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Add Deal of Product</title>
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
                        <?php echo $this->lang->line("deal");?>
                        <small>Preview</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line("Admin");?></a></li>
                        <li><a href="#"><?php echo $this->lang->line("deal");?></a></li>
                        <li class="active"><?php echo $this->lang->line("adddeal");?></li>
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
                                <!-- /.box-header -->
                                <!-- form start -->
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Product Title :");?> <span class="text-danger">*</span></label> 
                                                    <!-- <input type="text" id="id" name="prod_title" class="form-control" placeholder="Product Title"/> 
                                                     <div class="well" id="result" style="display:none;"></div>  -->  
                                                    <?php //echo "<pre>";print_r($all_products);exit();?>
                                                     <select name="prod_title" id="prod_title" class="form-control" required >
                                                         <option value="">Select Product</option>
                                                         <?php
                                                            foreach($all_products as $all_product)
                                                            {
                                                          ?>
                                                                <option value="<?php echo $all_product->product_id.','.$all_product->product_name; ?>"
                                                                
                                                                data-unit="<?php echo $all_product->unit_value.'-'.$all_product->unit; ?>"
                                                                data-unit1="<?php if(0<$all_product->unit_value1){ echo $all_product->unit_value1.'-'.$all_product->unit1; }else { echo "";} ?>"
                                                                data-unit2="<?php if(0<$all_product->unit_value2){ echo $all_product->unit_value2.'-'.$all_product->unit2; }else { echo "";} ?>"
                                                                ><?php echo $all_product->product_name; ?></option>
                                                          <?php      
                                                            }
                                                         ?>
                                                     </select>


                                         </div>
                                        
                                        <div class="form-group">
                                        <label class=""><?php echo "Qty-Unit :";?> </label>
                                            <select name="qty_unit" id="qty_unit" class="form-control"   required/>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line("dealprice");?> </label>
                                             <input type="number"  name="deal_price" class="form-control" placeholder="Deal Price" required min="1"/> 
                                        </div>
                                        
                                   
                                        
                                        <div class="form-group">
                                            <label class="">Date From: <span class="text-danger">*</span></label>
                                            <input type="date" name="start_date" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label class="">Start Time: <span class="text-danger">*</span></label>
                                            <input type="time" name="start_time" class="form-control" placeholder="00.00"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="">End Date: <span class="text-danger">*</span></label>
                                            <input type="date" name="end_date" class="form-control"/>
                                        </div>
                                        <div class="form-group">
                                            <label class="">End Time: <span class="text-danger">*</span></label>
                                            <input type="time" name="end_time" class="form-control"  placeholder="00"/>
                                        </div>
                                         <div class="form-group">
                                            <label class="">Max Qty : <span class="text-danger">*</span></label>
                                            <input type="number" min="1" name="max_qty" class="form-control"  placeholder="00"/>
                                        </div>
                                        
                                       
                                        
                                    </div><!-- /.box-body -->

                                        

                                    <div class="box-footer">
                                        <input type="submit" class="btn btn-primary" name="addcatg" value="Add Product" />
                                        <a href="<?php echo site_url("admin/dealofday"); ?>" class="btn btn-danger">Cancel</a>
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
        
        
    $('#prod_title').change(function() {
    $("#qty_unit").html('');
    if($(this).find(':selected').data('unit')!='')
    {
        $("#qty_unit").append("<option value=''>Please select option</option>");
        $("#qty_unit").append("<option value="+$(this).find(':selected').data('unit')+">"+$(this).find(':selected').data('unit')+"</option>");
    }
    
    if($(this).find(':selected').data('unit1')!='')
    {
        $("#qty_unit").append("<option value="+$(this).find(':selected').data('unit1')+">"+$(this).find(':selected').data('unit1')+"</option>");
    }
    
    if($(this).find(':selected').data('unit2')!='')
    {
        $("#qty_unit").append("<option value="+$(this).find(':selected').data('unit2')+">"+$(this).find(':selected').data('unit2')+"</option>");
    }
});
    </script>
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
        
        $(this).ready( function() {
           
        
            $("#id").autocomplete({  
                
                minLength: 1,  
                source:   
                function(req, add){
                    $("#result").show();

                    var d=[
                    'search='+$("#id").val(),
                    'type='+$("#type").val()
                    ];
                   
                    
                    $.ajax({  
                        url: "<?php echo base_url(); ?>index.php/admin/lookup",  
                        dataType: 'json',  
                        type: 'POST',  
                        data: req, 
                        success:      
                        function(data){  
                            $("#result").html(data);
                            if(data.response =="true"){ 
                                
                               $.each(data.message, function(index, element) {
                                  
                                $('#result').append("<p  class='element'"+ " id='location_" + index + "' hrf='" + element.value + "'>" + element.value +"</p>");
                             });  
                                //$("#result").add(data.message);  
                                console.log(data);
                                $(".element").click(function(){
                                $("#result").hide();
                                $("#id").val($(this).attr("hrf"));
                                });
                                
                            }else{
                            $('#result').html($('<p/>').text("No Data Found"));  
                        }   
                        },  
                    });
               
                },  
                     
            });
                
           
        });  

    </script>
    <script type="text/javascript">
      $(document).ready(function(){         
       var current_page_link =   window.location.pathname;

      var id_name = current_page_link.split("admin/");
     // alert(id_name[1].search("categories"));
      if(id_name[1].search("add_dealproduct")!='-1')
      {
        if($(".set_active_class").hasClass("active"))
        {
          $(".set_active_class").removeClass("active");
          $("#dealofday").addClass("active");  
        }
        else{
          $("#dealofday").addClass("active");
        }
      }

      //alert(id_name[1]);
      });
    </script>
  </body>
</html>
