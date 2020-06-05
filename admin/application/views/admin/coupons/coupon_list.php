<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Coupons</title>
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
    <link rel="stylesheet" href="http://static.jquery.com/ui/css/demo-docs-theme/ui.theme.css" type="text/   css" media="all" />
    <!-- <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/plugins/sumoselect/sumoselect1.css
    "); ?>"> -->  
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js" type="text/javascript"></script>  
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js" type="text/javascript"></script>  

     <link rel="stylesheet" href="<?php echo base_url($this->config->item("theme_admin")."/plugins/datepicker/datepicker3.css.css"); ?>">

   <!--  <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/sumoselect/sumoselect.js"); ?>"></script> -->


    
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
                         <?php echo $this->lang->line("coupon_list");?>
                        <!--<small> <?php echo $this->lang->line("Preview");?></small>-->
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
                                    <!--<h3 class="box-title"> <?php echo $this->lang->line("coupon_list");?></h3>-->   
                                    <!--<a class="pull-right" href="<?php echo site_url("admin/addCoupon"); ?>"> <?php echo $this->lang->line("add_coupon");?></a> --> 
                                    <p class="pull-right"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"><?= $this->lang->line("add_coupon");?></button></p>
                                </div><!-- /.box-header -->
                                
                                <div class="container">
  

                                <!-- Modal -->
                                <div class="modal fade" id="myModal" role="dialog">
                                <div class="modal-dialog">
                                
                                  <!-- Modal content-->
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal">×</button>
                                      <h4 class="modal-title">Add Coupon</h4>
                                    </div>
                                    <div class="modal-body">
                                       <?php echo form_error('shop_list'); ?> 
                                      <form action="coupons" method="post" enctype="multipart/form-data">

                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class=""><?php echo $this->lang->line('nameofcoupon');?>  <span class="text-danger">*</span></label>
                                            
                                            <input type="text" name="coupon_title" class="form-control" required  value="" placeholder="<?= $this->lang->line('coupon_title');?>" required minlength="1" maxlength="15"/>
                                            <?php echo form_error('coupon_title'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label class=""><?= $this->lang->line('coupon_code');?>  <span class="text-danger">*</span></label>
                                            <input type="text" name="coupon_code" class="form-control"  value="" placeholder="<?= $this->lang->line('couponcode');?>" required  maxlength="6"/>
                                            <?php echo form_error('coupon_code'); ?>
                                        </div>
                                        <div class="form-group">
                                            <label class="" width="100%"><?php echo "validity :";?>  <span class="text-danger">*</span></label>
                                            <!-- <input type='text' id='txtDate' name="from" placeholder="From"/><input type='text' name="to" id='txtDate2' placeholder="To"/> -->
                                            <input type='text' id='txtDate' onchange="checkdate();" name="from" required placeholder="From" required /><input type='text' name="to" id='txtDate2' onchange="checkdate();" placeholder="To" required/>
                                            <input type="hidden" name="valid_date_or_not" required id="valid_date_or_not" />
                                           
                                            <?php echo form_error('from'); ?>
                                            <?php echo form_error('to'); ?>
                                            <?php echo form_error('date_valid'); ?>                                            
                                        </div>
                                       <!-- <div class="form-group">
                                            <label class=""><?php echo "Choose Any One :";?> <span class="text-danger">*</span></label>
                                            <select class="text-input form-control"  name="product_type" id="type" onchange="yesnoCheck(this);">
                                                <option value="">--Please Select--</option>
                                                <option value="Product">Product</option>
                                                <option value="Category">Category</option>
                                                <option value="Sub Category">Sub Category</option>
                                            </select>
                                            <?php echo form_error('product_type'); ?>
                                        </div>-->
                                        <!--<div class="form-group" id="ifYes" style="display: none;">
                                            <select multiple="multiple" name="printable_name[]"  class="testSelAll" style="width:550px;">
                                                  
                                            </select>
                                        </div>-->
                                        <div class="form-group"> 
                                        <label class="" width="100%"><?php echo "Discount Type:";?>  </label>
                                            <div class="">
                                                <label>
                                                    <input type="radio" name="discount_type" id="optionsRadios1" value="1" onclick="yesselect();" required />
                                                    <?php echo "Percentage(%)";?>
                                                    <?php echo form_error('discount_type'); ?>
                                                </label>
                                            </div>
                                            <div class="">
                                                <label>
                                                    <input type="radio" name="discount_type" id="optionsRadios2" value="0" onclick="yesselect();"/>
                                                    <?php echo "Amount ";?>(<i class="fa fa-inr"></i>)

                                                </label>
                                            </div>
                                           
                                        </div>
                                    </div><!-- /.box-body -->
                                    <div class="box-body" >
                                        <div class="form-group" id="value" style="display: none;">
                                            <label class=""><?php echo $this->lang->line("discount value");?> </label>
                                            <input type="text" name="value" class="form-control" value=""  placeholder="00.00"/>
                                            
                                        </div>
                                        
                                        <!--<div class="form-group">
                                            <label class=""><?php echo $this->lang->line("cart_value");?> <span class="text-danger">*</span></label>
                                            <input type="text" name="cart_value" class="form-control" value=""  placeholder="00"/>
                                             <?php echo form_error('cart_value'); ?>
                                        </div>-->
                                       <!--  <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("uses_restriction");?> <span class="text-danger">*</span></label>                                           
                                            <input type="text" name="restriction" class="form-control "value="" placeholder="00.00"/>    
                                             <?php echo form_error('restriction'); ?>
                                        </div> -->
                                         <!--<div class="form-group">
                                            <label class=""><?php echo $this->lang->line("user_type");?> <span class="text-danger">*</span></label>                                           
                                            <select name="user_type" id="user_type" class="form-control" required>
                                                <option value="">Select</option>
                                                <option value="new_user">New User</option>
                                                <option value="subscribe_user">Subscribe User</option>
                                                <option value="all_user">All User</option>
                                            </select>
                                             <?php echo form_error('user_type'); ?>
                                        </div>-->
                                        <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Coupon max count :");?> <span class="text-danger">*</span></label>                                           
                                            <input type="number" min="1" name="coupon_max_count" class="form-control " required placeholder="00"/>    
                                             <?php echo form_error('coupon_max_count'); ?>
                                        </div>
                                         <div class="form-group">
                                            <label class=""> <?php echo $this->lang->line("Free Delivery"); ?></label>
                                           <!--  <textarea name="subscription_details2" class="textarea" placeholder="Place some text here" style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea> -->
                                            <!-- <p class="help-block"> <?php echo $this->lang->line("Subscription Datail2 :"); ?></p> -->
                                             <input type="checkbox" name="free_delivery" value="0" id="free_delivery" onclick="changevalue('free_delivery')"/>
                                              <?php echo form_error('free_delivery'); ?>
                                        </div>

                                        <div class="form-group">
                                            <label class=""> <?php echo $this->lang->line("Cashback :"); ?></label>
                                            <input type="text" name="cashback_amt" id="cashback_amt" placeholder="Enter amount in %" class="form-control"/>
                                             <?php echo form_error('cashback_amt'); ?>
                                        </div>

                                          <div class="form-group">
                                            <label class=""> <?php echo $this->lang->line("Amount Limit Min :"); ?>(RS)</label>
                                           <input type="number" name="min_amount_apply" id="min_amount_apply"   placeholder="Enter min amount" min="1" class="form-control" required/>
                                            <?php echo form_error('min_amount_apply'); ?>
                                          </div>
                                           <div class="form-group">
                                            <label class=""> <?php echo $this->lang->line("Amount Limit Max :"); ?>(RS)</label>
                                           <input type="number" name="max_amount_apply" id="max_amount_apply"   placeholder="Enter max amount" min="1" class="form-control"required/>
                                            <?php echo form_error('max_amount_apply'); ?>
                                          </div>
                                    </div>
                                    
                               
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit" class="btn btn-primary" name="addcatg" value="Add Coupon" />
                                      <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                                   </form>
                                </div>
                                </div>
                           
                            </div>
                                
                             <!--- test only   --->  
                             
                             
                            </div><!-- /.box -->
                            <div class="box-body table-responsive">
                                <?php if($this->session->flashdata('addmessage')){ ?>
                                <div class="alert alert-dismissible alert-success">
                                <?= $this->session->flashdata('addmessage'); ?>
                                </div>
                            <?php } ?>
                                <?php if($this->session->flashdata('errormessage')){ ?>
                                
                                <?= $this->session->flashdata('errormessage'); ?>
                                
                            <?php } ?>
                                    
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">S.No </th>
                                                <th><?= $this->lang->line('coupon_name');?></th>
                                                <th><?= $this->lang->line('coupon_code');?></th>
                                                <th> <?= $this->lang->line('valid_from');?></th>
                                               <th> <?= $this->lang->line('valid_to');?></th>
                                               <!-- <th> <?= $this->lang->line('product');?></th> -->
                                                <!--<th> <?= $this->lang->line('validity_type');?></th>
                                                <th> <?= $this->lang->line('user_type');?></th>
                                                --><th><?= $this->lang->line('discount_type');?></th>
                                                <th> <?= $this->lang->line('discount_value');?></th>
                                                
                                               <!--  <th> <?= $this->lang->line('uses_restriction');?></th> -->
                                                <th style="width:59px;" > <?= $this->lang->line('action');?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <?php foreach($coupons as $coupon){ ?>
                                            <tr>
                                                <td class="text-center"><?= $coupon->id; ?></td>
                                                 <td><?= $coupon->coupon_name; ?></td>
                                                <td><?= $coupon->coupon_code;?></td>
                                                 <td><?= $coupon->valid_from;?></td>
                                                
                                                <td><?= $coupon->valid_to;?></td>
                                                <!-- <td><?= $coupon->type_id;?></td> -->
                                                <!--<td class="text-center"><?= $coupon->validity_type;?> </td>-->
                                                <!--<td><?= $coupon->user_type;?></td>-->
                                                <td><?php if($coupon->discount_type=='1') { echo "Percentage"; } else if($coupon->discount_type=='0') { echo "Amount"; } ?></td>
                                                <td><?= $coupon->discount_value;?></td>
                                                
                                                <!-- <td><?= $coupon->uses_restriction;?></td> -->
                                              <!--   <td><a href="<?= base_url('index.php/admin/editCoupon/'.$coupon->id.'');?>"><i class="fa fa-edit" aria-hidden="true"></a></i>/<a onClick="return doconfirm(); "href="<?= base_url('index.php/admin/deleteCoupon/'.$coupon->id.'');?>"><i class="fa fa-trash" aria-hidden="true"></i></a></td> -->
                                             <td class="text-center"><div class="btn-group"> <?php echo anchor('admin/editCoupon/'.$coupon->id, '<i class="fa fa-edit"></i>', array("class"=>"btn btn-success")); ?>
                                                          <?php echo anchor('admin/deleteCoupon/'.$coupon->id, '<i class="fa fa-times"></i>', array("class"=>"btn btn-danger", "onclick"=>"return confirm('Are you sure delete?')")); ?></div></td>
                                            </tr>   
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
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
    
    <script>
      $(function () {
        
        $('#example1').DataTable({
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
                    $(".testSelAll").show();

                    var d=[
                    'search='+$("#id").val(),
                    'type='+$("#type").val()
                    ];
                   
                },  
                     
            });
                
           
        });  
        
        
        
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

    

});
        
       
        </script>
        <script>
        function doconfirm()
        {
            job=confirm("Are you sure to delete permanently?");
            if(job!=true)
            {
                return false;
            }
        }


        function yesnoCheck(that) {
        if (!that.value == "") {
            
            getlist(that.value);
            document.getElementById("ifYes").style.display = "block";
            } else {
               document.getElementById("ifYes").style.display = "none";
            }
        }

        function yesselect(that) {
        if (document.getElementById('optionsRadios1').checked ||document.getElementById('optionsRadios2').checked) {
            document.getElementById('value').style.display = 'block';
        } else {
            document.getElementById('ifYes').style.display = 'none';
        }
    }

        function getlist(value){
               // alert(value);
                if(value=='Product'){  //start if
                    $.ajax({  
                        url: "<?php echo base_url(); ?>index.php/admin/lookup",  
                        dataType: 'json',  
                        type: 'POST',  
                        data: {}, 
                        success:      
                        function(data){  
                            //$(".testSelAll").html(data);
                            $(".testSelAll").empty();
                            if(data.response =="true"){ 
                                
                               $.each(data.message, function(index, element) {
                                  
                                // $('#result').append("<p  class='element'"+ " id='location_" + index + "' hrf='" + element.value + "'>" + element.value +"</p>");
                                //$('#result').append("<select class='form-control'"+ " id='location_" + index + "'></select>");
                                var $DropDown = $('.testSelAll');
                                //$DropDown.append('<option value="">Select</option>');
                                $DropDown.append('"<option value="' + element.value_id + '">' + element.value + '</option>');
                             });  
                                //$("#result").add(data.message);  
                                //$("#result").show();
                                console.log(data);
                                $(".element").click(function(){
                                //$("#result").hide();
                                //$("#id").val($(this).attr("hrf"));
                                });
                                
                            }else{
                            $('.testSelAll').html($('<p/>').text("No Data Found"));  
                        }   
                        },  
                    });
                }else if($("#type").val()=='Category'){


                    $.ajax({  
                        url: "<?php echo base_url(); ?>index.php/admin/looku",  
                        dataType: 'json',  
                        type: 'POST',  
                        data: {}, 
                        success:      
                        function(data){  
                           // $("#result").html(data);
                            $(".testSelAll").empty();
                            if(data.response =="true"){ 
                                
                               $.each(data.message, function(index, element) {
                                  
                              //  $('#result').append("<p  class='element'"+ " id='location_" + index + "' hrf='" + element.value + "'>" + element.value +"</p>");
                               var $DropDown = $('.testSelAll');
                                //$DropDown.append('<option value="">Select</option>');
                               $DropDown.append('"<option value="' + element.value_id + '">' + element.value + '</option>');
                             });  
                                //$("#result").add(data.message);  
                                console.log(data);
                                $(".element").click(function(){
                                //$("#result").hide();
                                //$("#id").val($(this).attr("hrf"));
                                });
                                
                            }else{
                            $('.testSelAll').html($('<p/>').text("No Data Found"));  
                        }   
                        },  
                    });

                }else if($("#type").val()=='Sub Category'){
                    

                    $.ajax({  
                        url: "<?php echo base_url(); ?>index.php/admin/look",  
                        dataType: 'json',  
                        type: 'POST',  
                        data: {}, 
                        success:      
                        function(data){  
                            //$("#result").html(data);
                            $(".testSelAll").empty();
                            if(data.response =="true"){ 
                                
                               $.each(data.message, function(index, element) {
                                  
                               // $('#result').append("<p  class='element'"+ " id='location_" + index + "' hrf='" + element.value + "'>" + element.value +"</p>");
                               var $DropDown = $('.testSelAll');
                                //$DropDown.append('<option value="">Select</option>');
                               $DropDown.append('"<option value="' + element.value_id + '">' + element.value + '</option>');
                             });  
                                //$("#result").add(data.message);  
                                console.log(data);
                                $(".element").click(function(){
                               // $("#result").hide();
                               // $("#id").val($(this).attr("hrf"));
                                });
                                
                            }else{
                            $('.testSelAll').html($('<p/>').text("No Data Found"));  
                        }   
                        },  
                    });

                } 
            }

function checkvalue(){

            var min_value = $("#min_amount_apply").val();
            var max_value = $("#max_amount_apply").val();  

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
                 $("#min_amount_apply").focus();
                 flag  = 1;
            }
            else if(parseInt(min_value)>100){
                 alert('Please enter number only less than 100%');
                 $("#min_amount_apply").focus();
                 flag  = 1;                
            }
            else{
                flag  = 0;
            }

             if(!isValidMax){
                 alert('Please enter number only');
                 $("#max_amount_apply").focus();
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
                    $("#min_amount_apply").focus();
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
            }
            else{
                $("#"+field_name).val('0');
            }
      }

      function checkdate(){
        var date1   =   $("#txtDate").val();
        var date2   =   $("#txtDate2").val();

        if(date1!="" && date2!=""){
            if ($.datepicker.parseDate('dd/mm/yy', date2) > $.datepicker.parseDate('dd/mm/yy', date1)) {
                $("#valid_date_or_not").val('Yes');
               // $("#date_error").hide();
                return true;
            }
            else{
                $("#valid_date_or_not").val('No');
                alert("From date must be less than To date");
               // $("#date_error").show();
                return false;
            }      
        } 
        else if(date1=="" && date2==""){
            $("#valid_date_or_not").val('No');
            alert("Please select date first");
            //$("#date_error").show();
            return false;
        }      
        
      }
    </script>
    
       <!-- sumo select -->
                                         
        <!-- <script src="js/jquery.sumoselect.js"></script> -->
        <!-- <link href="css/sumoselect.css" rel="stylesheet" /> -->
      
        <script type="text/javascript">
          //  window.testSelAll = $('.testSelAll').SumoSelect({selectAll:true, search: true, searchText:'Enter here.', okCancelInMulti:true });    
          $(document).ready(function() {
                //$('.testSelAll').SumoSelect();
               // window#result = $('#result').SumoSelect({selectAll:true, search: true, searchText:'Enter here.', okCancelInMulti:true });    
            });
        </script>
        <script type="text/javascript">
      $(document).ready(function(){         
       var current_page_link =   window.location.pathname;

      var id_name = current_page_link.split("admin/");
     // alert(id_name[1].search("categories"));
      if(id_name[1].search("coupons")!='-1')
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
    <script src="<?php echo base_url($this->config->item("theme_admin")."/dist/js/demo.js"); ?>"></script>
     <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/datepicker/bootstrap-datepicker.js.js"); ?>"></script>
  </body>
</html>