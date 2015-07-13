<?PHP
/**
 * abstract Validator
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
abstract class Validator
{   
    protected $message = array(); 
    
    protected $isEdit = false;   
            
	abstract function Validate($data);
    
    function setMessage($message_string)
    { 
        $this->message[] = $message_string;
    }  
    
    function getEditMode()
    {
        return $this->isEdit;
    }  
     
    function setEditMode($isEdit=false)
    {
        $this->isEdit = $isEdit;
    }  
    
    function getMessage()
    {
        return $this->message;
    }   
    
    function isValidated()
    {                 
        if(count($this->message) > 0)
            return false;
        return true;
    }
}//class ends