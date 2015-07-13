<?PHP   
/**
 * Password Validator
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
class PasswordValidator extends Validator
{
    function Validate($data)
    {       
        $oV = new Validation();

        if($oV->isempty($data['new_password']))
        {
              $this->setMessage("New Password - required");
        }
        
        if($oV->isempty($data['confirm_password']))
        {
              $this->setMessage("New Password - required");
        }
        
        if($data['confirm_password'] != $data['new_password'] && $data['new_password'] != '' && $data['confirm_password'] != '')
        {
              $this->setMessage("Passwords didn't match.");
        }
        
 
        return $this;
        
    }

}//class ends