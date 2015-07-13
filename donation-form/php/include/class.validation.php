<?PHP
/**
 * Validation Class
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
class Validation
{
    
    function only_alpha_numeric($string)
    {             
        return preg_match('/^[0-9a-z_ ]+$/i', $string);
    }	
    
    function only_numeric($string)
    {             
        return  preg_match('/^[0-9]+$/i', $string);
    }
    
    function is_alpha($testcase){
        if (ctype_alpha($testcase)) {
          return false;
        }
        return true;
    }
    
    function is_number($testcase){
        if (is_numeric($testcase)) {
          return false;
        }
        return true;
    }
    
    function is_alpha_only_string($string){
        return $this->is_alpha($string);
    }
    
    function alpha_space_only($string)
    {                              
        return preg_match('/^[^A-Za-z ]$/i', $string);
    }
    
	function isempty($string){
		if(trim($string) == ''){
			return true;
		}
		return false;
	}
	
	function isequal($value1,$value2){
		if($value1 == $value2){
			return true;
		}
		return false;
	}
	
	public function isemail($email) {
             return filter_var($email, FILTER_VALIDATE_EMAIL);
	}
    
    public function validate_url($url,$protocols='http|https')
    {
        if (preg_match('/^('.$protocols.'):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url)) {
            return true;
        } else {
            return false;
        }
    }

     /**
     * --Validate username--
     * Validate username, consist of alpha-numeric (a-z, A-Z, 0-9), underscores, and has minimum 5 character and maximum 20 character. You could change the minimum character
     * and maximum character to any number you like.
     * 
     * @param mixed $username
     */
     public function validate_username($username)
     {
        if (preg_match('/^[a-z\d_]{5,20}$/i', $username)) {
            return true;
        } else {
            return false;
        }
     }
}