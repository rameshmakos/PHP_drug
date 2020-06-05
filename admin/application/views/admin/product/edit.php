<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Edit Product</title>
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
                         <?php echo $this->lang->line("Edit Products");?>
                        <small>Preview</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line("Admin");?></a></li>
                        <li><a href="#"><?php echo $this->lang->line("Products");?></a></li>
                        <li class="active"> <?php echo $this->lang->line("Edit Products");?></li>
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
                                    <h3 class="box-title"> <?php echo $this->lang->line("Edit Products");?></h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                        
                                             <div class="form-group">
                                            <label class=""><?php echo "Select Shop :";?> <span class="text-danger">*</span></label> 
                                            <?php $shps = _get_all_shops(); //print_r($shps);?>
                                            <select name="shop_id" id="shop_id" class="form-control" required />
                                            <option value="">Select</option>
                                            <option value="0" <?php if(isset($product->shop_id)){
                      if(0==$product->shop_id) { ?> selected <?php } } ?>>Inventory</option>
                        
                                          <?php
                                              foreach($shps as $shops)
                                              {
                                              ?>  
                                                  <option value="<?php echo $shops->shop_id; ?>" <?php if(isset($product->shop_id)){
                      if($shops->shop_id==$product->shop_id) { ?> selected <?php } } ?> ><?php echo $shops->shop_name; ?></option>
                                              <?php  
                                              }
                                              ?> 
                                          </select>
                                            
                                                    <!--<input type="text" name="prod_title" class="form-control" placeholder="Product Title"  />   --> 
                                         </div>
                                         
                                        <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Product Title :");?>  <span class="text-danger">*</span></label>
                                            <input type="text" name="prod_title" class="form-control" value="<?php echo $product->product_name; ?>" placeholder="Product Title" required/>
                                        </div>
                                        <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Product Category :");?> <span class="text-danger">*</span></label>
                                            <select class="text-input form-control" name="parent" required>
                                                <option value=""><?php echo $this->lang->line("Select Category");?></option>
                                                 <?php  
                                                    echo printCategory(0,0,$this,$product);
                                                    function printCategory($parent,$leval,$th,$product){
                                                    
                                                    $q = $th->db->query("SELECT a.*, Deriv1.count FROM `categories` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS count FROM `categories` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` WHERE a.`status`=1 and a.`parent`=" .$parent);
                                                    $rows = $q->result();
                            
                                                    foreach($rows as $row){
                                                        if ($row->count > 0) {
                                                				
                                                                    //print_r($row) ;
                                                					//echo "<option value='$row[id]_$co'>".$node.$row["alias"]."</option>";
                                                                    printRow($row,$product,true);
                                               					    printCategory($row->id, $leval + 1,$th,$product);
                                                					
                                                				} elseif ($row->count == 0) {
                                                					printRow($row,$product,false);
                                                                    //print_r($row);
                                                				}
                                                        }
                            
                                                    }
                                                    function printRow($d,$product,$bool){
                                                        
                                                   // foreach($data as $d){
                                                    
                                                    ?>
                                                       <option value="<?php echo $d->id; ?>" <?php if($product->category_id == $d->id){ echo "selected"; } ?> ><?php for($i=0; $i<$d->leval; $i++){ echo "_"; } echo $d->title; ?></option>
                                                         
                                                     <?php } ?> 
                                            </select>
                                        </div>
						<div class="form-group">
                                            <label class=""> Brand<span class="text-danger">*</span> </label>
                                            <select name="brand_id" id="brand" class="form-control" required>
                                                <option value="">Please select</option>
                                                <?php 
                                                    $q1 = $this->db->query("SELECT * from brand where status='Active'");
                                                    //print_r($th->db->last_query());
                                                    $rows1 = $q1->result();
                                                    if(!empty($rows1)){
                                                    foreach($rows1 as $row2)
                                                    {
                                                ?>
                                                <option value="<?php echo $row2->brand_id;?>" <?php if($product->brand_id==$row2->brand_id) { echo "selected";} ?>><?php echo $row2->name;?></option>
                                                <?php 
                                                        
                                                    }}
                                                ?>
                                            </select>
                                            
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="">Composition Name<span class="text-danger">*</span> </label>
                                            <select name="composition_id" id="composition_id" class="form-control" required>
                                                <option value="">Please select</option>
                                                <?php 
                                                    $q1 = $this->db->query("SELECT * from composition where status='Active'");
                                                    //print_r($th->db->last_query());
                                                    $rows1 = $q1->result();
                                                    if(!empty($rows1)){
                                                    foreach($rows1 as $row2)
                                                    {
                                                ?>
                                                <option value="<?php echo $row2->composition_id;?>" <?php if($product->composition_id==$row2->composition_id) { echo "selected";} ?> ><?php echo $row2->composition_name;?></option>
                                                <?php 
                                                        
                                                    }}
                                                ?>
                                            </select>
                                            
                                        </div>
    

                                        <div class="form-group">
                                            <label class=""> <?php echo $this->lang->line("Product Description :"); ?></label>
                                            <textarea name="product_description" class="textarea"  style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd;  "><?php echo $product->product_description; ?></textarea>
                                            <p class="help-block"> <?php echo $this->lang->line("Product Description."); ?></p>
                                        </div>
                                        <div class="form-group">
                                            <label><?php echo $this->lang->line("Product Image:");?>  </label>
                                            <input type="file" name="prod_img" accept="image/*"/>
                                        </div>
                                        <div class="form-group"> 
                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" name="prod_status" id="optionsRadios1" value="1"  <?php if($product->in_stock == 1){ echo "checked"; } ?> required/>
                                                    <?php echo $this->lang->line("In Stock");?>
                                                </label>
                                            </div>
                                            <div class="radio-inline">
                                                <label>
                                                    <input type="radio" name="prod_status" id="optionsRadios2" value="0" <?php if($product->in_stock == 0){ echo "checked"; } ?> />
                                                    <?php echo $this->lang->line("Out of stock");?>
                                                </label>
                                            </div>
                                            <p class="help-block"><?php echo $this->lang->line("Product Status.");?></p>
                                        </div>

                                         <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Top Selling :");?> <span class="text-danger">*</span></label>
                                            <input type="checkbox" name="top_selling" id="top_selling" onclick="changevalue('top_selling')" value="0" <?php if($product->top_selling=='1') { ?> checked <?php } ?>/>

                                            <label class="" style="margin-left:30px;"><?php echo $this->lang->line("Offer Product :");?> <span class="text-danger">*</span></label>
                                            <input type="checkbox" name="offer_product" onclick="changevalue('offer_product')" id="offer_product" value="0" <?php if($product->offer_product=='1') { ?> checked <?php } ?>/>
                                        </div>
                                        
                                    </div><!-- /.box-body -->
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("MRP Price :");?> <span class="text-danger">*</span></label>
                                            <input type="text" name="price" class="form-control" value="<?php echo $product->price; ?>" placeholder="00.00" required/>
                                        </div>                                        <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("SurfCity Price :");?> <span class="text-danger">*</span></label>
                                            <input type="text" name="surfcity_price" class="form-control" value="<?php echo $product->surfcity_price; ?>" placeholder="00.00" required/>
                                        </div>
<!--                                         <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Subscription Price :");?> <span class="text-danger">*</span></label>
                                            <input type="text" name="subscription_price" class="form-control" value="<?php echo $product->subscription_price; ?>" placeholder="00.00" required/>
                                        </div>-->
                                        
                                        <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Qty :");?> <span class="text-danger">*</span></label>
                                            <input type="text" name="qty" class="form-control" value="<?php echo $product->unit_value; ?>"  placeholder="00" required/>
                                        </div>
                                        <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Unit :");?> <span class="text-danger">*</span></label>                                           
                                            <input type="text" name="unit" class="form-control" value="<?php echo $product->unit; ?>" placeholder="KG/ BAG/ NOS/ QTY / etc " required/>    
                                               
                                        </div>
<!--                                        
                                        <div class="form-group"> 
                                        
                                        <p class="btn btn-primary" onclick="showdiv()">+</p><p class="btn btn-danger" onclick="hidediv()">-</p>
                                        </div>
    -->                                    
                                        <?php $counter=1; ?>
                                        <div class="form-group" id="div1" style="display:<?php if(0<$product->price1){echo 'block'; $counter=1;}else{  echo 'none';} ?>">
                                            <label class=""><?php echo "Price 2";?></label>&nbsp;&nbsp;<br>
                                            <label class=""><?php echo $this->lang->line("MRP Price :");?> </label>
                                            <input type="number" name="price1" id="price1"  value="<?php echo $product->price1; ?>" class="form-control" placeholder="00.00" <?php if($product->price1!=0){echo 'required';}else{  echo '';} ?> min="1"/>
                                            <label class=""><?php echo $this->lang->line("SurfCity Price :");?> </label>
                                            <input type="number" name="surfcity_price1" id="surfcity_price1"  value="<?php echo $product->surfcity_price1; ?>" class="form-control" placeholder="00.00"  min="1" <?php if($product->surfcity_price1!=0){echo 'required';}else{  echo '';} ?> />
                                            <label class=""><?php echo $this->lang->line("Subscription Price :");?> </label>
                                            <input type="number" name="subscription_price1"  id="subscription_price1"  value="<?php echo $product->subscription_price1; ?>" class="form-control" placeholder="00.00" <?php if($product->subscription_price1!=0){echo 'required';}else{  echo '';} ?>/>
                                            <label class=""><?php echo $this->lang->line("Qty :");?> </label>
                                            <input type="number" name="qty1" id="qty1" class="form-control"   value="<?php echo $product->unit_value1; ?>" placeholder="00"  min="1" <?php if($product->unit_value1!=0){echo 'required';}else{  echo '';} ?> />
                                            <label class=""><?php echo $this->lang->line("Unit :");?></label>
                                            <input type="text" name="unit1" id="unit1" class="form-control"  value="<?php echo $product->unit1; ?>" placeholder="KG/ BAG/ NOS/ QTY / etc " <?php if(!empty($product->unit1)){echo 'required';}else{  echo '';} ?> />
                                        </div>
                                        
                                        
                                        <div class="form-group" id="div2" style="display:<?php if(0<$product->price2){echo 'block'; $counter=2; }else{ echo 'none';} ?>">
                                            <label class=""><?php echo "Price 3";?></label><br>
                                            <label class=""><?php echo $this->lang->line("MRP Price :");?> </label>
                                            <input type="number" min="1" name="price2" id="price2" class="form-control" value="<?php echo $product->price2; ?>" placeholder="00.00" <?php if($product->price2!=0){echo 'required';}else{  echo '';} ?>/>
                                            <label class=""><?php echo $this->lang->line("SurfCity Price :");?> </label>
                                            <input type="number" min="1" name="surfcity_price2" id="surfcity_price2" class="form-control" placeholder="00.00" value="<?php echo $product->surfcity_price2; ?>" <?php if($product->surfcity_price2!=0){echo 'required';}else{  echo '';} ?>/>
                                            <label class=""><?php echo $this->lang->line("Subscription Price :");?> </label>
                                            <input type="number" min="1" name="subscription_price2" id="subscription_price2" class="form-control" placeholder="00.00" value="<?php echo $product->subscription_price2; ?>" <?php if($product->subscription_price2!=0){echo 'required';}else{  echo '';} ?>/>
                                            <label class=""><?php echo $this->lang->line("Qty :");?> </label>
                                            <input type="number" min="1" name="qty2" id="qty2" class="form-control"  placeholder="00"  value="<?php echo $product->unit_value2; ?>" <?php if($product->unit_value2!=0){echo 'required';}else{  echo '';} ?>/>
                                            <label class=""><?php echo $this->lang->line("Unit :");?></label>
                                            <input type="text" name="unit2" id="unit2" class="form-control" placeholder="KG/ BAG/ NOS/ QTY / etc "  value="<?php echo $product->unit2; ?>" <?php if(!empty($product->unit2)){echo 'required';}else{  echo '';} ?>/>
                                        </div>
                                        
                                         <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Cashback :");?> <span class="text-danger">*</span></label>
                                            <input type="number" name="cashback" class="form-control" value="<?php echo $product->cashback; ?>" min="0" placeholder="00.00" required />
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class=""><?php echo "Rewards :";?> <span class="text-danger">*</span></label>
                                            <input type="text" name="rewards" class="form-control" value="<?php echo $product->rewards; ?>"  placeholder="00" value="1" />
                                        </div>
                                        
                                         
                                    </div>
                                    <div class="box-footer">
                                        <input type="submit" class="btn btn-primary" name="addcatg" value="Edit Product" />
                                        <a href="<?php echo site_url("admin/products"); ?>" class="btn btn-danger">Cancel</a>
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
    var i="<?php echo $counter; ?>";
        function hidediv()
        {
            if(0<2)
            {
            $("#div"+i).hide();    
            }else{
                alert("You can remove only 2 prices");
            }
            $("#price"+i).val('');
            $("#surfcity_price"+i).val('');
            $("#subscription_price"+i).val('');
            $("#qty"+i).val('');
            $("#unit"+i).val('');
            
            document.getElementById("price"+i).required = false;
            document.getElementById("surfcity_price"+i).required = false;
            document.getElementById("subscription_price"+i).required = false;
            document.getElementById("qty"+i).required = false;
            document.getElementById("unit"+i).required = false;
            
            if(i!=0)
            {
                i--;    
            }
            
            
        }
        
        function showdiv()
        {
            
        	if(i==2)
            {
                alert("You can add maximum 3 prices");
            }
            if(2 > i)
            {
                i++;
            }
            if(i<=2)
            {
                $("#div"+i).show();    
            }
            
            $("#price"+i).attr('required','required');
            $("#surfcity_price"+i).attr('required','required');
            $("#subscription_price"+i).attr('required','required');
            $("#qty"+i).attr('required','required');
            $("#unit"+i).attr('required','required');
            
            
            
        }
        
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
      $(document).ready(function(){         
       var current_page_link =   window.location.pathname;

      var id_name = current_page_link.split("admin/");
     // alert(id_name[1].search("categories"));
      if(id_name[1].search("edit_products")!='-1')
      {
        if($(".set_active_class").hasClass("active"))
        {
          $(".set_active_class").removeClass("active");
          $("#products").addClass("active");  
        }
        else{
          $("#products").addClass("active");
        }
      }

      //alert(id_name[1]);
      });
    </script>
  </body>
</html>
