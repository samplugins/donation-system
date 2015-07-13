  
 var response_div =  "#donate_response_div";
 var formID =  "#donate_form";
 
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
    $('#donate_btn').removeAttr('disabled'); 
    $(".ajax_loading").hide();
    
    alert(xhr.responseText);

    JumpFadeInDiv(response_div,"Oops! We are unable to complete your request. Please try again.","r_error");  
}


function onSuccess(responseText, statusText, xhr, $form)  
{ 
    var jsonResponse = responseText;
    
    $(".ajax_loading").hide();  
    $('#donate_btn').removeAttr('disabled');  


    if(jsonResponse.code == "ERROR")
    {

        var error_str = '<p class="error">Oops!</p>';
        var jSONResponse = JsonResponse(jsonResponse).response;
        
        if(jSONResponse.message != undefined)
        {   
            error_str += "<ul class='error'>";     
                error_str +=  "<li>" + jSONResponse.message + "</li>";
            error_str += "</ul>";
        }
                                        
        JumpFadeInDiv(response_div,error_str,"r_error");

    } 
    else if(jsonResponse.code == "SUCCESS")
    {
        var msg = JsonResponse(jsonResponse).response.message;             
        var redirect_to = JsonResponse(jsonResponse).response.redirect_to;             

        $("#div_donation_form").hide();
        window.location = redirect_to;
    }
}

function ActivateModifyInterface()
{
    $("#div_donation_form").show();
    $("#div_preview_donation_details").hide();
    jumpTo("#div_donation_form");
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
   else if(isNaN(security_code) == true)
   {
        JumpFadeInDiv(options.targetDiv,"Invalid security code!","r_error");
       return false; 
   }
   
   $(".ajax_loading").show();     
   $('input[type=submit]', jqForm).attr('disabled', 'disabled');
   return true;
}

function isValidEmailAddress(emailAddress) 
{
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}

function JsonResponse(jsonResponse)
{
    if(jsonResponse.ice_response.success != null && jsonResponse.ice_response.success != undefined)
        return jsonResponse.ice_response.success;
    else if(jsonResponse.ice_response.error != null && jsonResponse.ice_response.error != undefined)      
         return jsonResponse.ice_response.error;               
}


