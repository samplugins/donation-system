<?php
/**
 * Settings Form Handler
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
class clsSettingsFormHandler  extends FormHandler
{	
    public function Validate()
    {
       include 'class.settings.validator.php';
       
       $SettingsValidator = new SettingsValidator();
       
       if($SettingsValidator->Validate($this->_data)->isValidated())
        {
            
           $this->_response = array(
                "response"=>array(
                    "message"=>"Settings Successfully saved.",
                )
             );
             
             return true;
        }
        else
        {
            $this->_response = array(
                "response"=>array(
                    "message"=> $SettingsValidator->getMessage()
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
                        "message"=> array("Request couldn't be submitted. " . $ex->getMessage())
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
          $Settings = new Settings();
          $Settings->Update($this->_data);
    }
    

}
?>