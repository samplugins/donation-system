<?PHP
/**
 * Array Helper Class
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
class clsArray
{

    static function arrayToComboOptions($array,$current_value='',$ignore_values='',$use_value_as_key=false)
    {
        

        if($ignore_values == '')
            $ignore_values = array(); //init :P
            
        $str = '';
        foreach ($array as $key => $value){
            if($use_value_as_key)
                $key  = $value;
                        
            if($key == $current_value){
                $selected = " selected";
            }else{
                 $selected = "";
            }
            
            if(!in_array($key,$ignore_values)){
                 $str .= '<option value="'.$key.'"'.$selected.'>'.$value.'</option>';
            }
            
           
        } 
        return $str;
        
    }
    
     function arrayToRadioOptions($array,$name,$current_value='',$class='check_radio',$js_event_str='')
     {
         $str = '';

        foreach ($array as $key => $value){
            if($key == $current_value){
                $selected = "checked";
            }else{
                 $selected = "";
            }
            $str .= '<input type="radio" name="'.$name.'" value="'.$key.'" '.$selected.' class="'.$class.'"'.$js_event_str.'> '.$value.'  ';
        } 
        return $str;
    }
    
    function arrayTocheckboxes($array,$name,$data_array=array(),$class='check_radio'
    ){
        $str = '';
        foreach ($array as $key => $value){
            if(in_array($key,$data_array)){
                $selected = "checked";
            }else{
                 $selected = "";
            }
            $str .= '<input type="checkbox" id="'.$name.'" name="'.$name.'" value="'.$key.'"'.$selected.' class="'.$class.'">'.$value;
        } 
        return $str;
    }
}
?>