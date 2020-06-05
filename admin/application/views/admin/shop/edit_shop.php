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
                    
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line("Admin");?></a></li>
                        <li><a href="#"><?php echo $this->lang->line("Shop");?></a></li>
                        <li class="active"><?php echo $this->lang->line("Add Shop");?></li>
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
                                    <h3 class="box-title"><?php echo $this->lang->line("Edit Shop");?></h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                          <div class="form-group">
                                            <label><?php echo "Shop Logo";?> </label>
                                            <input type="file" name="logo" />
                                        </div>
                                        <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Shop Title :");?> <span class="text-danger">*</span></label> 
                                            <input type="text" name="shop_title" value="<?php echo $shop->shop_name; ?>" class="form-control" placeholder="Shop Title" required/>    
                                         </div>
                                        <div class="form-group">
                                            <label class=""> <?php echo $this->lang->line("Email Id :"); ?></label>
                                           <input type="email" name="shop_email" class="form-control" value="<?php echo $shop->shop_email_id; ?>" placeholder="Email id" required/>
                                        </div>
                                         <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Contact Number :");?> <span class="text-danger">*</span></label>
                                            <input type="text" name="contact_number" class="form-control" value="<?php echo $shop->shop_contact_no; ?>" placeholder="Contact number" required  maxlength="10"/>                                         
                                        </div>
                                         <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Shop Address :");?> <span class="text-danger">*</span></label>
                                            <input type="text" name="shop_address" id="shop_address" value="<?php echo $shop->shop_address; ?>" class="form-control" placeholder="Address" onkeyup="initMap();" required/>
                                             <div id="map" style="display:none;"></div>
                                             <input type="hidden" name="shop_lat" id="shop_lat"/>
                                             <input type="hidden" name="shop_long" id="shop_long"/>       
                                        </div>

                                    </div><!-- /.box-body -->

                                        

                                    <div class="box-footer">
                                        <input type="submit" class="btn btn-primary" name="addcatg" value="Edit Shop" />
                                         <a href="<?php echo site_url("admin/shop"); ?>" class="btn btn-danger">Cancel</a>
                                       
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
    <!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB8wIay8QVdMkSlMuO2X_DsOoTnCN1sk28&libraries=places"></script>-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1kMLgGMIdfAvQ1gXvOF8gXlrVY62GofU&libraries=places&callback=initMap"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
      $.widget.bridge('uibutton', $.ui.button);

      $(document).ready(function(){

        var shop_id    =    "<?php echo $shop->shop_id ?>";
       //alert(shop_id);
        if(shop_id!='')
        {
            $("#shop_lat").val("<?php echo $shop->shop_lat ?>");
            $("#shop_long").val("<?php echo $shop->shop_long ?>");
            
            initMap();
        } 

        function initMap() {
               // alert();
                var map = new google.maps.Map(document.getElementById('map'), {
                 // center: {lat: -33.8688, lng: 151.2195},
                 // zoom: 13
                });
                
              //  document.getElementById('shop_lat').val="";
              //  document.getElementById('shop_long').val="";
                
               //$("#shop_lat").val("");
               //$("#shop_long").val("");

                var input = document.getElementById('shop_address');
                //alert(document.getElementById('shop_address'));
                map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

                var autocomplete = new google.maps.places.Autocomplete(input);
                autocomplete.bindTo('bounds', map);

                var infowindow = new google.maps.InfoWindow();
                var marker = new google.maps.Marker({
                    map: map,
                    anchorPoint: new google.maps.Point(0, -29)
                });

                autocomplete.addListener('place_changed', function() {
                    infowindow.close();
                    marker.setVisible(false);
                    var place = autocomplete.getPlace();
                    if (!place.geometry) {
                        window.alert("Autocomplete's returned place contains no geometry");
                        return;
                    }
              
                    // If the place has a geometry, then present it on a map.
                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(17);
                    }
                    marker.setIcon(({
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(35, 35)
                    }));
                    marker.setPosition(place.geometry.location);
                    marker.setVisible(true);
                
                    var address = '';
                    if (place.address_components) {
                        address = [
                          (place.address_components[0] && place.address_components[0].short_name || ''),
                          (place.address_components[1] && place.address_components[1].short_name || ''),
                          (place.address_components[2] && place.address_components[2].short_name || '')
                        ].join(' ');
                    }
                
                    infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
                    infowindow.open(map, marker);
                  
                    //Location details
                    for (var i = 0; i < place.address_components.length; i++) {
                        if(place.address_components[i].types[0] == 'postal_code'){
                            //document.getElementById('postal_code').innerHTML = place.address_components[i].long_name;
                        }
                        if(place.address_components[i].types[0] == 'country'){
                            //document.getElementById('country').innerHTML = place.address_components[i].long_name;
                        }
                    }
                    //document.getElementById('location').innerHTML = place.formatted_address;
                   // document.getElementById('shop_lat').val=place.geometry.location.lat();
                    //document.getElementById('shop_long').val=place.geometry.location.lng();

                   // alert(place.geometry.location.lat());

                    $("#shop_lat").val(place.geometry.location.lat());
                    $("#shop_long").val(place.geometry.location.lng());
                });
            }
      })
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
      $(document).ready(function(){         
       var current_page_link =   window.location.pathname;

      var id_name = current_page_link.split("admin/");
     // alert(id_name[1].search("categories"));
      if(id_name[1].search("edit_shop")!='-1')
      {
        if($(".set_active_class").hasClass("active"))
        {
          $(".set_active_class").removeClass("active");
          $("#shop").addClass("active");  
        }
        else{
          $("#shop").addClass("active");
        }
      }

      //alert(id_name[1]);
      });
    </script>
  </body>
</html>