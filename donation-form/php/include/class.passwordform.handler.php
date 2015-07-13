<?php
/**
 * clsPasswordFormHandler
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
class clsPasswordFormHandler  extends FormHandler
{	
    public function Validate()
    {
       include 'class.password.validator.php';
       
       $pwdValidator = new PasswordValidator();
       
       if($pwdValidator->Validate($this->_data)->isValidated())
        {
            
           $this->_response = array(
                "response"=>array(
                    "message"=>"Password changed successfully.",
                )
             );
             
             return true;
        }
        else
        {
            $this->_response = array(
                "response"=>array(
                    "message"=> $pwdValidator->getMessage()
                )
             );          
             
             return false;                                                                                                                        
        } 
    }
    
    function Handle()
    {
        $ajax = Ajax::Instance();
                                               
        if($this->Validate())
        {
            try
            {
                $this->_process();
                
                $ajax->setSuccessResponse($this->_response); 
            }
            catch(Exception $ex)
            {
                $this->_response = array(
                    "response"=>array(
                        "message"=> array("Request couldn't be completed. " . $ex->getMessage())
                    )
                 );    
                 
                 $ajax->setErrorResponse($this->_response);                                                                                                                                          
            }
        }
        else
        {
            $ajax->setErrorResponse($this->_response);                                                                                                                                    
        }
        
        $ajax->renderJSONResponse();
    }
    
    private function _process()
    {
         
        $sql = "UPDATE admin_users SET password = '".md5($this->_data['new_password'])."' WHERE username = '".$_SESSION['user']."'";
         MySql::Instance()->query($sql);
    }
    

}
?>