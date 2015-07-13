<?PHP   
/**
 * Settings Validator
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
class SettingsValidator extends Validator
{
    function Validate($data)
    {       
        $oV = new Validation();

        if($oV->isempty($data['from_name']))
        {
              $this->setMessage("From Name - required");
        }
        else if($oV->alpha_space_only($data['from_name']))
        {
              $this->setMessage("From Name can only contain alphabets");
        }
        
        if($oV->isempty($data['no_reply_email']))
        {
            $this->setMessage("No Reply Email - required");
        }
        else if($oV->isemail($data['no_reply_email']) == false)
        {
           $this->setMessage("No Reply Email - Invalid");  
        }   
    
        
        if($oV->isempty($data['from_email']))
        {
            $this->setMessage("From Email - required");
        }
        else if($oV->isemail($data['from_email']) == false)
        {
           $this->setMessage("From Email - Invalid");  
        }   
    
        
        if($oV->isempty($data['reply_to']))
        {
            $this->setMessage("Reply-To Email - required");
        }
        else if($oV->isemail($data['reply_to']) == false)
        {
           $this->setMessage("Reply-To Email - Invalid");  
        }   
        
        if($oV->isempty($data['to_email']))
        {
            $this->setMessage("To Email - required");
        }
        
        if($oV->isempty($data['donation_statement_title']))
        {
            $this->setMessage("Statement Title - required");
        }
    
        if($data['enable_auto_response'] == 1)
        {
            if($oV->isempty($data['subject']))
            {
                $this->setMessage("Auto Response Subject - Required");
            }        

            if($oV->isempty($data['message']))
            {
                $this->setMessage("Auto Response Message - Required");
            }
        }
 
        return $this;
        
    }

}//class ends