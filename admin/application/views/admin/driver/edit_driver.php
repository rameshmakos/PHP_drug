<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin | Edit Driver</title>
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
                        <?php echo "Edit Driver";?>
                        
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> <?php echo $this->lang->line("Admin");?></a></li>
                        <li><a href="#"><?php echo "Driver";?></a></li>
                        <li class="active"><?php echo "Edit Driver";?></li>
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
                                <!--<div class="box-header">
                                    <h3 class="box-title"><?php echo $this->lang->line("Add Shop");?></h3>
                                </div>--><!-- /.box-header -->
                                <!-- form start -->
                                <form action="" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label><?php echo "Profile Photo";?> </label>
                                            <input type="file" name="profile_photo" />
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class=""><?php echo "First Name";?> <span class="text-danger">*</span></label> 
                                            <input type="text" name="first_name" class="form-control" placeholder="First Name" value="<?php echo $driver->first_name; ?>" required/>   
                                         </div>
                                         
                                         <div class="form-group">
                                            <label class=""><?php echo "Last Name";?> <span class="text-danger">*</span></label> <?php  //print_r($driver->last_name); ?>
                                            <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="<?php echo $driver->last_name; ?>" required/>   
                                         </div>
                                         
                                          <div class="form-group">
                                            <label class=""> <?php echo $this->lang->line("Email Id :"); ?><span class="text-danger">*</span></label>
                                           <input type="email" name="email" class="form-control" placeholder="Email id" value="<?php echo $driver->email; ?>" required/>
                                        </div>
                                        
                                        
                                        <div class="form-group">
                                            <label class=""> <?php echo "Password"; ?></label>
                                        <input placeholder="Password"  type="password" value="" name="password" id="password" class="form-control">
                                        </div>
                                         <div class="form-group">
                                            <label class=""><?php echo $this->lang->line("Contact Number :");?> <span class="text-danger">*</span></label>
                                            <input type="number" name="phone" class="form-control" id="phone" value="<?php echo $driver->phone; ?>" placeholder="Contact number" required maxlength="10"/>                                          
                                        </div>
                                        <div class="form-group">
                                            <label class=""><?php echo "Driver Address";?> <span class="text-danger">*</span></label>
                                             <input type="text" name="driver_address" id="shop_address" class="form-control" placeholder="Address"  required value="<?php echo $driver->driver_address; ?>" />
                                             
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class=""><?php echo "Transport Type";?> <span class="text-danger">*</span></label>
                                             <select name="transport_type" id="transport_type" class="form-control"   required />
                                                <option value="" >Please select</option>
                                                <option value="truck" <?php if($driver->transport_type=="truck") echo "selected"; ?>>Truck</option>
                                                <option value="car" <?php if($driver->transport_type=="car") echo "selected"; ?>>Car</option>
                                                <option value="bike" <?php if($driver->transport_type=="bike") echo "selected"; ?> >Bike</option>
                                                <option value="bicycle" <?php if($driver->transport_type=="bicycle") echo "selected"; ?>>Bicycle</option>
                                                <option value="scooter" <?php if($driver->transport_type=="scooter") echo "selected"; ?>>Scooter</option>
                                                <option value="walk" <?php if($driver->transport_type=="walk") echo "selected"; ?>>Walk</option>
                                                </select>
                                             </select>
                                             
                                        </div>
                                        
                                        <div class="form-group">
                                        <label class=""><?php echo "Licence Plate";?> <span class="text-danger">*</span></label>
                                        <input placeholder="MH13-AA-0000" type="text" required value="<?php echo $driver->licence_plate; ?>" name="licence_plate" id="licence_plate" class="form-control">
                                       </div>
                                       
                                       <div class="form-group">
                                           <label class=""><?php echo "color";?> <span class="text-danger">*</span></label>
                                        <input placeholder="color" type="text"  name="color" id="color" class="form-control" value="<?php echo $driver->color; ?>">
                                    </div><!--
                                       <div class="form-group">
                                        <label class=""><?php echo "Zip";?> <span class="text-danger">*</span></label>
                                        <input placeholder="123456" type="number" value="<?php echo $driver->zip; ?>" name="zip" id="zip" class="form-control" min="100000" max="999999">
                                       </div>-->

<div class="form-group">
                                       <button type="button" class="btn btn-primary add_field_button">Add Zip</button>
                                        <button type="button" class="btn btn-primary remove_field_button">Remove Zip</button>
                                    </div>
                                       <div class="form-group input_fields_wrap">
                                        <label class=""><?php echo "Zip";?> <span class="text-danger">*</span></label>
                                        <?php $zips=explode(',',$driver->zip);?>
                                        <?php foreach($zips as $values){?>
                                        <input placeholder="123456" type="text" value="<?php echo $values; ?>" name="zip[]" id="zip" class="form-control number"  required>
                                        <?php }?>
                                       </div>
                                    </div><!-- /.box-body -->

                                        

                                    <div class="box-footer">
                                        <input type="submit" class="btn btn-primary" name="addcatg" value="Edit Driver" />
                                         <a href="<?php echo site_url("admin/driver"); ?>" class="btn btn-danger">Cancel</a>
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

    <script>
    function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
     // center: {lat: -33.8688, lng: 151.2195},
     // zoom: 13
    });
    
  //  document.getElementById('shop_lat').val="";
  //  document.getElementById('shop_long').val="";
    
    $("#shop_lat").val("");
    $("#shop_long").val("");

    var input = document.getElementById('shop_address');
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

        $("#shop_lat").val(place.geometry.location.lat());
        $("#shop_long").val(place.geometry.location.lng());
    });
}
</script>
      
      <!-- Add the sidebar's background. This div must be placed
           immediately after the control sidebar -->
      <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url($this->config->item("theme_admin")."/plugins/jQuery/jQuery-2.1.4.min.js"); ?>"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

    <!-- Google api for lat long -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1kMLgGMIdfAvQ1gXvOF8gXlrVY62GofU&libraries=places&callback=initMap"></script>
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
     
     

      $(document).ready(function(){         
       var current_page_link =   window.location.pathname;

      var id_name = current_page_link.split("admin/");
      if(id_name[1].search("edit_driver")!='-1')
      {
        if($(".set_active_class").hasClass("active"))
        {
          $(".set_active_class").removeClass("active");
          $("#driver").addClass("active");  
        }
        else{
          $("#driver").addClass("active");
        }
      }

      //alert(id_name[1]);
      });
    </script>
    
     <script>
 $(document).ready(function () {

	$("#phone").keypress(function (e) {
	//if the letter is not digit then display error and don't type anything
	if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
	//display error message
	alert("Mobile number must be 10 digits.")
	return false;
	}
	});
	});
	
</script>
<script>
    var max_fields      = 50;
var wrapper         = $(".input_fields_wrap"); 
var add_button      = $(".add_field_button");
var remove_button   = $(".remove_field_button");

$(add_button).click(function(e){
    e.preventDefault();
    var total_fields = wrapper[0].childNodes.length;
    if(total_fields < max_fields){
        $(wrapper).append('<input placeholder="123456" type="number" value="" name="zip[]" id="zip" class="form-control" min="100000" max="999999" required>');
    }
});
$(remove_button).click(function(e){
    e.preventDefault();
    var total_fields = wrapper[0].childNodes.length;
    if(total_fields>1){
        wrapper[0].childNodes[total_fields-1].remove();
    }
});
    
</script>
  </body>
</html>
