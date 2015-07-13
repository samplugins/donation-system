  
 var response_div =  "#donation_response_div";
 var formID =  "#donation_form";
 
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
    
    $(".req_class").change(function() { 
       onChangeHandle(this);
    }); 
  
});

function onError(xhr, ajaxOptions, thrownError)
{
    $('#donation_btn').removeAttr('disabled'); 
    $(".ajax_loading").hide();

    JumpFadeInDiv(response_div,"Oops! We are unable to complete your request. Please try again.","r_error");  
}


function onSuccess(responseText, statusText, xhr, $form)  
{ 
    var jsonResponse = responseText;
    
    $(".ajax_loading").hide();  
    $('#donation_btn').removeAttr('disabled');  

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
                                        
        $("#em_security_code").html(jSONResponse.security_question.q);
        $("#security_code").val('');

        JumpFadeInDiv(response_div,error_str,"r_error");

    } 
    else if(jsonResponse.code == "SUCCESS")
    {
        $(formID).hide();

        var msg = JsonResponse(jsonResponse).response.message;
        var redirect_to = JsonResponse(jsonResponse).response.redirect_to;
        
        JumpFadeInDiv(response_div,msg,"r_success");
        
        if(redirect_to != undefined && redirect_to != "" && redirect_to != null)
        {
            setTimeout("redirectTo('"+redirect_to+"')",2000);
        }
    }
}

function redirectTo(_url)
{
    window.location = _url;
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

   var email = $(""+formID+" input[name=email]").val();

   if(isValidEmailAddress(email) == false)
   {
       JumpFadeInDiv(options.targetDiv,"Email address is Invalid","r_error");
       return false; 
   }  
   
   var amount = $(""+formID+" input[name=amount]").val();
    
   var rexp = /^[0-9]*([0-9]+\.[0-9]{0,2})?$/;
   if(rexp.test(amount) == false)          
   {
       $(""+formID+" input[name=amount]").val('');
       JumpFadeInDiv(options.targetDiv,"Amount is Invalid","r_error");
       return false; 
   } 
    
   var security_code = $(""+formID+" input[name=security_code]").val();
   if(jQuery.trim(security_code) == false)
   {
       JumpFadeInDiv(options.targetDiv,"Please provide security code!","r_error");
       return false; 
   }
   
   $(".ajax_loading").show();     
   $('input[type=submit]', jqForm).attr('disabled', 'disabled');
   return true;
}
