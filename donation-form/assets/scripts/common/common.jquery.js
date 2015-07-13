function isValidEmailAddress(emailAddress) 
{
    var pattern = new RegExp(/^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i);
    return pattern.test(emailAddress);
}


function jumpTo(divID)
{
    var target = $(divID);
    target = target.length && target
    var targetOffset = target.offset().top;
    $("html,body").animate({scrollTop: targetOffset}, 1000);
}

function ShowVisibility(div_id)
{
    $(div_id).css("visibility","visible");
}

function HideVisibility(div_id)
{
    $(div_id).css("visibility","hidden");
}

var current_response_class = "";
function JumpFadeInDiv(divID,msg,divClass)
{
    if(current_response_class != "")
    {
        $(divID).removeClass(current_response_class);
    }
    
    if(divClass != null && divClass != undefined)
    {
        $(divID).addClass(divClass);
    }
    
    current_response_class = divClass;
    
    $(divID).html(msg);
    $(divID).fadeIn();
    jumpTo(divID);
}

function DisplayDiv(divID,msg,divClass)
{
    if(current_response_class != "")
    {
        $(divID).removeClass(current_response_class);
    }
    
    if(divClass != null && divClass != undefined)
    {
        $(divID).addClass(divClass);
    }
    
    current_response_class = divClass;
    
    $(divID).html(msg);
    $(divID).fadeIn();
}
