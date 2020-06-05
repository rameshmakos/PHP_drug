function yesnoCheck(that,values,base_url) {
      //alert(that);
      // alert(values);
        if (that!="") {
           // alert(that);
            getlist(that,values,base_url);
            document.getElementById("ifYes").style.display = "block";
            } else {
               document.getElementById("ifYes").style.display = "none";
            }
        }

function getlist(value,values,base_url){
        //alert(value);
        //alert(values);
        var selected_values  = [];
        var select_val  = "";
        if(values.search(',')!='-1'){
          selected_values  =  values.split(',');
        } 
        else
        {
          select_val = values;
        }
        //alert(selected_values);
        if(value=='Product'){  //start if
            $.ajax({  
                url: base_url+"index.php/admin/lookup",  
                dataType: 'json',  
                type: 'POST',  
                data: {}, 
                success:      
                function(data){  
                    //$(".testSelAll").html(data);
                    $(".testSelAll").empty();
                    if(data.response =="true"){ 
                      
                       $.each(data.message, function(index, element) {
                         // alert(element.value_id);
                        var $DropDown = $('.testSelAll');
                       var selected_or_not =   "";
                       //alert(selected_values[index]);
                        if(selected_values[index]!='undefined'){
                            if(element.value_id.trim()==selected_values[index]){
                            selected_or_not =   "selected";
                          }
                        }
                        else
                        {
                          if(element.value_id==select_val){
                              selected_or_not =   "selected";
                          }
                        }
                        //$DropDown.append('<option value="">Select</option>');
                       $DropDown.append('"<option value="' + element.value_id + '" '+selected_or_not+'>'+ element.value + '</option>');
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
                url: base_url+"index.php/admin/looku",  
                dataType: 'json',  
                type: 'POST',  
                data: {}, 
                success:      
                function(data){  
                   // $("#result").html(data);
                    $(".testSelAll").empty();
                    if(data.response =="true"){ 
                      //  alert(selected_values.length);
                       $.each(data.message, function(index, element) {
                          
                      //  $('#result').append("<p  class='element'"+ " id='location_" + index + "' hrf='" + element.value + "'>" + element.value +"</p>");
                       var $DropDown = $('.testSelAll');
                       var selected_or_not =   "";

                        if(selected_values.length>0){
                            if(element.value_id==selected_values[index]){
                            selected_or_not =   "selected";
                          }
                        }
                        else
                        {
                          if(element.value_id==select_val){
                              selected_or_not =   "selected";
                          }
                        }
                        //$DropDown.append('<option value="">Select</option>');
                       $DropDown.append('"<option value="' + element.value_id + '" '+selected_or_not+'>'+ element.value + '</option>');
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
                url: base_url+"index.php/admin/look",  
                dataType: 'json',  
                type: 'POST',  
                data: {}, 
                success:      
                function(data){  
                    //$("#result").html(data);
                    $(".testSelAll").empty();
                    if(data.response =="true"){ 
                       // alert(selected_values.length);
                       $.each(data.message, function(index, element) {
                          
                       var $DropDown = $('.testSelAll');
                       var selected_or_not =   "";
                       //alert(selected_values[index].trim());
                       //alert(element.value_id==selected_values[index]);
                        if(element.value_id==selected_values[index]){
                            selected_or_not =   "selected";                         
                        }
                        else
                        {
                          if(element.value_id==select_val){
                              selected_or_not =   "selected";
                          }
                          else{
                            selected_or_not =   "";
                          }
                        }
                        //$DropDown.append('<option value="">Select</option>');
                       $DropDown.append('"<option value="' + element.value_id + '" '+selected_or_not+'>'+ element.value + '</option>');
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