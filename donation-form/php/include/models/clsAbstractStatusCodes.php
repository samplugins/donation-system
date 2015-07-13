<?PHP
abstract class clsAbstractStatusCodes 
{
    const APPROVED = "approved";
    const PENDING = "pending";
    const PENDING_REVIEW = "pending-review";
    const IN_PROGRESS = "in-progress";
    const FAILED = "failed";
    const COMPLETED = "completed";
    const REJECTED = "rejected";
    const _PUBLIC = "public";
    const _PRIVATE = "private";
    
    const ACTIVE = 1;
    const INACTIVE = 0;

    protected $_codes;

    public abstract function getStatusCodes();

    function Combo($value='',$append_string=''){
        $data = $this->getStatusCodes();
        $str = '';
        foreach($data as $k=>$v){
            $slcted = '';
            if($v == $value){
               $slcted .= " selected='selected'"; 
            }
            
            $display_str = ucWords($v);
            if($append_string != '')
            {
                $display_str .= " " . $append_string; 
            }
            
            $str .= "<option value='".$v."'".$slcted.">".$display_str."</option>";
        }
        return $str;
    } 
    
     function Radio($name,$value='',$class='check_radio',$js_event_str=''){
        $data = $this->getStatusCodes();
        $str = '';
        foreach($data as $k=>$v){
            $slcted = '';
            if($v == $value){
               $slcted .= " checked='checked'"; 
            }
            $str .= "<input type='radio' name='".$name."' value='".$v."'".$slcted." class='".$class."'".$js_event_str."> ".ucWords($v)." ";
        }
        return $str;
    } 

}
?>