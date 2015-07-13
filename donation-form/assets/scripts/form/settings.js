  
 var response_div =  "#settings_response_div";
 var formID =  "#settings_form";
 
jQuery(document).ready(function() 
{
     // prepare Options Object 
    var options = { 
        targetDiv:     response_div, 
        beforeSubmit: validate,
        success:       onSuccess,
        error:       onError,
        dataType:  'json'
    }; 
 
 // bind to the form's submit event 
    $(formID).submit(function() { 
        
        $(this).ajaxSubmit(options); 

        return false; 
    }); 
});

function onError(xhr, ajaxOptions, thrownError)
{
    $('#settings_btn').removeAttr('disabled'); 
    $(".ajax_loading").hide();
                       
        
    JumpFadeInDiv(response_div,"Oops! We are unable to complete your request. Please try again.","r_error");  
}


function onSuccess(responseText, statusText, xhr, $form)  
{ 
    var jsonResponse = responseText;
    
    $(".ajax_loading").hide();  
    $('#settings_btn').removeAttr('disabled');  

    if(jsonResponse.code == "ERROR")
    {
        var error_str = '<p class="error">Oops!</p>';
        var jSONResponse = JsonResponse(jsonResponse).response;
        
        if(jSONResponse.message != undefined)
        {   
            error_str += "<ul class='error'>";     
            $.each(jSONResponse.message, function(key,value){
                error_str +=  "<li>" + value + "</li>";
            });
            
            error_str += "</ul>";
        }


        JumpFadeInDiv(response_div,error_str,"r_error");

    } 
    else if(jsonResponse.code == "SUCCESS")
    {
        //$(formID).hide();

        var msg = JsonResponse(jsonResponse).response.message;
       
        JumpFadeInDiv(response_div,msg,"r_success");
        
        setTimeout("hideFlashMessage()",20000);
    }
}

function hideFlashMessage()
{
    $(response_div).fadeOut();
}

function validate(formData, jqForm, options) 
{                   
   $(options.targetDiv).html("");
   $(options.targetDiv).hide();

   var is_validated = doValidate();
   if(is_validated == false)
   {
        return false;
   }

   $(".ajax_loading").show();     
   $('input[type=submit]', jqForm).attr('disabled', 'disabled');
   return true;
}

