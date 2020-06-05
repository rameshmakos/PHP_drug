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
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/themes/base/jquery-ui.css" type="text/css" media="all" />  
        <link rel="stylesheet" href="http://static.jquery.com/ui/css/demo-docs-theme/ui.theme.css" type="text/css" media="all" />  
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js" type="text/javascript"></script>  
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js" type="text/javascript"></script>  
    
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
                         <?php echo "Edit Coupon"?>
                        <small> <?php echo $this->lang->line("Preview");?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line("Home");?></a></li>
                        <li><a href="#"> <?php echo $this->lang->line("Coupons");?></a></li>
                        <li class="active"> <?php echo $this->lang->line("coupon_list");?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <?php  if(isset($error)){ echo $error; }
                                    echo $this->session->flashdata('success_req'); ?>
                            <div class="box box-primary">
                                <div class="box-header">
                                    <!--<h3 class="box-title"> <?php echo $this->lang->line("coupon_list");?></h3>  --> 
                                    <!--<a class="pull-right" href="<?php echo site_url("admin/addCoupon"); ?>"> <?php echo $this->lang->line("add_coupon");?></a> --> 
                                    <!--<p class="pull-right"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"><?= $this->lang->line("add_coupon");?></button></p>-->
                                </div><!-- /.box-header -->
                                
                               
  
                               <div class="box-body table-responsive">
     
                                <form action="" method="post" enctype="multipart/form-data">

                                      <?php echo form_error('shop_list'); ?>
                                        <div class="form-group">
                                            
                                            <label class=""><?php echo $this->lang->line('nameofcoupon');?>  <span class="text-danger">*</span></label>
                                            
                                            <input type="text" name="coupon_title" class="form-control" value="<?= $coupon['coupon_name']; ?>" placeholder="<?= $this->lang->line('coupon_title');?>" required minlength="1" maxlength="15"/>
                                            <?php echo form_error('coupon_title'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label class=""><?= $this->lang->line('coupon_code');?>  <span class="text-danger">*</span></label>
                                            <input type="text" name="coupon_code" class="form-control" value="<?= $coupon['coupon_code']; ?>" placeholder="<?= $this->lang->line('couponcode');?>" required  maxlength="6"/>
                                            <?php echo form_error('coupon_code'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label class="" width="100%"><?php echo "validity :";?>  <span class="text-danger">*</span></label>
                                            <input type='text' id='txtDate' name="from" value="<?= $coupon['valid_from']; ?>" placeholder="From" required /><input type='text' name="to" value="<?= $coupon['valid_to']; ?>" id='txtDate2' placeholder="To" required/>
                                            <?php echo form_error('from'); ?>
                                            <?php echo form_error('to'); ?>
                                        </div>
                                        <!--<div class="form-group">
                                            <label class=""><?php echo "Choose Any One :";?> <span class="text-danger">*</span></label>
                                            <select class="text-input form-control" name="product_type" id="type" onchange="yesnoCheck11(this.value,'<?php echo base_url(); ?>');">
                                                <?php if ($coupon['validity_type']=='Product') { ?>
                                                   <option value="<?= $coupon['validity_type']; ?>"><?= $coupon['validity_type']; ?></option>
                                                <option value="Category">Category</option>
                                                <option value="Sub Category">Sub Category</option>
                                               <?php }elseif ($coupon['validity_type']=='Category') {?>
                                                   <option value="<?= $coupon['validity_type']; ?>"><?= $coupon['validity_type']; ?></option>
                                                <option value="Product">Product</option>
                                                <option value="Sub Category">Sub Category</option>
                                              <?php }elseif ($coupon['validity_type']=='Sub Category') {?>
                                                   <option value="<?= $coupon['validity_type']; ?>"><?= $coupon['validity_type']; ?></option>
                                                <option value="Category">Category</option>
                                                <option value="Product">Product</option>
                                              <?php } ?> ?>
                                                
                                            </select>
                                            <?php echo form_error('product_type'); ?>
                                           
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo "Selected:";?>  </label>
                                           
                                            <?php echo form_error('printable_name'); ?>
                                            <div class="well" id="result" style="display:none;"></div>
                                            <div class="form-group" id="ifYes" style="display: none;">
                                              
                                           
                                              <select multiple="multiple" name="printable_name[]" class="testSelAll" style="width:1000px;">
                                                    
                                              </select>
                                          </div>
                                          
                                        </div>-->
                                        <div class="form-group"> 
                                        <label class="" width="100%"><?php echo "Discount Type:";?>  </label>
                                            <div class="">
                                                <label>
                                                    
                                                    <input type="radio" name="discount_type" id="optionsRadios1" <?= ($coupon['discount_type']==1) ? "checked" : ""; ?> value="1"/>
                                                    <?php echo "Percentage(%)";?>
                                                    <?php echo form_error('discount_type'); ?>
                                                </label>
                                            </div>
                                            <div class="">
                                                <label>
                                                    <input type="radio" name="discount_type" <?= ($coupon['discount_type']==1) ? "" : "checked";?> id="optionsRadios2" value="0"/>
                                                    <?php echo "Amount ";?>(<i class="fa fa-inr"></i>)

                                                </label>
                                            </div>
                                           
                                        </div>
                                    
                                    
                                        <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("value");?> </label>
                                            <input type="text" name="value" class="form-control" value="<?= $coupon['discount_value'];?>" placeholder="00.00"/>
                                            <?php echo form_error('value'); ?>
                                        </div>
                                        <!--<div class="form-group">
                                            <label class=""><?php echo $this->lang->line("cart_value");?> <span class="text-danger">*</span></label>
                                            <input type="text" name="cart_value" class="form-control" value="<?= $coupon['cart_value'];?>"  placeholder="00"/>
                                             <?php echo form_error('cart_value'); ?>
                                        </div>-->
                                       <!--  <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("uses_restriction");?> <span class="text-danger">*</span></label>                                           
                                            <input type="text" name="restriction" class="form-control "value="<?= $coupon['uses_restriction'];?>" placeholder="00.00"/>    
                                             <?php echo form_error('restriction'); ?>
                                        </div> -->

                                      <!--   <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("user_type");?> <span class="text-danger">*</span></label>                                           
                                            <select name="user_type" id="user_type" class="form-control">
                                                <option value="">Select</option>
                                                 <option value="new_user" <?php if($coupon['user_type']=='new_user') { ?> selected="selected" <?php } ?> >New User</option>
                                                <option value="subscribe_user" <?php if($coupon['user_type']=='subscribe_user') { ?>selected="selected" <?php } ?> >Subscribe User</option>
                                                <option value="all_user" <?php if($coupon['user_type']=='all_user') { ?> selected="selected" <?php } ?> >All User</option>
                                            </select>
                                             <?php echo form_error('user_type'); ?>
                                        </div>-->
                                        <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Coupon max count :");?> <span class="text-danger">*</span></label>                                           
                                            <input type="number" min="1" name="coupon_max_count" value="<?= $coupon['max_count'];?>" class="form-control " placeholder="00"/>    
                                             <?php echo form_error('coupon_max_count'); ?>
                                        </div>
                                         <div class="form-group">
                                            <label class=""> <?php echo $this->lang->line("Free Delivery"); ?></label>
                                           <!--  <textarea name="subscription_details2" class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea> -->
                                            <!-- <p class="help-block"></p> -->
                                            <?php $free_deliv = $coupon['free_delivery'];
                                           
                                            ?>

                                             <input type="checkbox" name="free_delivery" value="<?= $coupon['free_delivery']; ?>" id="free_delivery" onclick="changevalue('free_delivery')" <?= ($coupon['free_delivery']==1) ? "checked" : ""; ?>  />
                                              <?php echo form_error('free_delivery'); ?>
                                        </div>

                                        <div class="form-group">
                                            <label class=""> <?php echo $this->lang->line("Cashback :"); ?></label>
                                            <input type="text" name="cashback_amt" id="cashback_amt" placeholder="Enter amount " class="form-control" value="<?= $coupon['cashback']; ?>" />
                                             <?php echo form_error('cashback_amt'); ?>
                                        </div>

                                          <div class="form-group">
                                            <label class=""> <?php echo $this->lang->line("Amount Min :"); ?>(RS)</label>
                                           <input type="text" name="min_amount_apply" id="min_amount_apply" placeholder="Enter min amount" class="form-control" value="<?= $coupon['min_limit']; ?>" required/>
                                            <?php echo form_error('min_amount_apply'); ?>
                                          </div>
                                           <div class="form-group">
                                            <label class=""> <?php echo $this->lang->line("Amount Max :"); ?>(RS)</label>
                                           <input type="text" name="max_amount_apply" id="max_amount_apply"  placeholder="Enter max amount" class="form-control" value="<?= $coupon['max_limit']; ?>" required />
                                            <?php echo form_error('max_amount_apply'); ?>
                                          </div>
                                    <div class="modal-footer">
                                        <input type="submit" class="btn btn-primary" name="addcatg" value="Edit Coupon" />
                                         <a href="<?php echo site_url("admin/coupons"); ?>" class="btn btn-danger">Cancel</a>
                                    </div>
                               
                                    </div>
                                    </form>
                                  </div>
                                   
                                
                            </div>
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
    <script src="<?php echo base_url($this->config->item("theme_admin")."/dist/js/test.js"); ?>"></script>
	
	<script>
	function checkamt()
	{
		var max_amount_apply =$("#max_amount_apply").val();
		var min_amount_apply =$("#min_amount_apply").val();
		//alert(min_amount_apply);
		if(max_amount_apply < min_amount_apply)
		{
			//$("#min_amount_apply").attr()
			alert("wrong");
		}
	}
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
    <script>
        function changevalue(text){           
            var field_name  =   text;
            //alert($("#"+field_name).is(":checked"));
            if($("#"+field_name).is(":checked")){
                $("#"+field_name).val('1');
            }
            else{
                $("#"+field_name).val('0');
                }
            }
      
    </script>
    <script type="text/javascript">  
   function yesnoCheck11(that,base_url) {
        if (that!="") {
            
            getlist11(that,base_url);
            
            document.getElementById("ifYes").style.display = "block";
            } else {
               document.getElementById("ifYes").style.display = "none";
            }
        }
        
                
        
        $(document).ready(function() {

    $("#txtDate").datepicker({
        showOn: 'button',
        buttonText: 'Show Date',
        buttonImageOnly: true,
        buttonImage: 'http://jqueryui.com/resources/demos/datepicker/images/calendar.gif',
        dateFormat: 'dd/mm/yy',
        constrainInput: true
    });

    $(".ui-datepicker-trigger").mouseover(function() {
        $(this).css('cursor', 'pointer');
    });

});

$(document).ready(function() {

    $("#txtDate2").datepicker({
        showOn: 'button',
        buttonText: 'Show Date',
        buttonImageOnly: true,
        buttonImage: 'http://jqueryui.com/resources/demos/datepicker/images/calendar.gif',
        dateFormat: 'dd/mm/yy',
        constrainInput: true
    });

    $(".ui-datepicker-trigger").mouseover(function() {
        $(this).css('cursor', 'pointer');
    });

});
    </script>
            
   <script type="text/javascript">
      $(document).ready(function(){         
       var current_page_link =   window.location.pathname;

      var id_name = current_page_link.split("admin/");
     // alert(id_name[1].search("categories"));
      if(id_name[1].search("editCoupon")!='-1')
      {
        if($(".set_active_class").hasClass("active"))
        {
          $(".set_active_class").removeClass("active");
          $("#coupons").addClass("active");  
        }
        else{
          $("#coupons").addClass("active");
        }
      }

      //alert(id_name[1]);
      });
    </script>
  </body>
</html>