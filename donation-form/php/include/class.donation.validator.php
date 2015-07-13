<?PHP   
/**
 * Form Validator
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
class FormValidator extends Validator
{
    function Validate($data)
    {       
        $oV = new Validation();

        if($oV->isempty($data['first_name']))
        {
              $this->setMessage("First Name - required");
        }
        else if($oV->alpha_space_only($data['first_name']))
        {
              $this->setMessage("First Name can only contain alphabets");
        }
        
        if($oV->isempty($data['last_name']))
        {
              $this->setMessage("Last Name - required");
        }
        else if($oV->alpha_space_only($data['last_name']))
        {
              $this->setMessage("Last Name can only contain alphabets");
        }
        
        if($oV->isempty($data['email']))
        {
            $this->setMessage("Email - required");
        }
        else if($oV->isemail($data['email']) == false)
        {
           $this->setMessage("Invalid Email address");  
        }   
       
        if($oV->isempty($data['security_code']))
        {
            $this->setMessage("Please provide answer");
        }
        else if($data['spam_answer'] != base64_encode($data['security_code']))
        {
            $this->setMessage("Invalid answer");    
        }
        
        return $this;
        
    }

}//class ends