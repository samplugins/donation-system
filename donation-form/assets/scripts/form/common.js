function JsonResponse(jsonResponse)
{
    if(jsonResponse.ice_response.success != null && jsonResponse.ice_response.success != undefined)
        return jsonResponse.ice_response.success;
    else if(jsonResponse.ice_response.error != null && jsonResponse.ice_response.error != undefined)      
         return jsonResponse.ice_response.error;               
}


function RequiredValidation()
{
    var is_error = false;
    var is_focus = false;
     
    $(".req_class").each(function(index){
        var _value = jQuery.trim($(this).val());
        var field = this.name;
        if(_value == '')
        {
           if(is_focus == false)
           {
               is_focus = true;
               $(this).focus();
           }
           
           ShowVisibility("#err_"+field);
           is_error = true;
        }else
        {
            HideVisibility("#err_"+field);
        }
    });
    
    return  is_error;
}

function doValidate()
{
   var is_error = RequiredValidation();
   if(is_error == true)
   { 
       return false; 
   }else
   {
       return true;
   }
}

function onChangeHandle(obj)
{
    if(jQuery.trim(obj.value) != '')
    {
       HideVisibility("#err_"+obj.id); 
    }else
    {
       ShowVisibility("#err_"+obj.id); 
    }
}
