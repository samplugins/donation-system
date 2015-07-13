<?php
/**
 * Preview Form Handler
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
class clsPreviewFormHandler  extends FormHandler
{	               
    function Handle()
    {
        $ajax = Ajax::Instance();
                                               
        if($this->Validate())
        {
            try
            {
                $this->_process();
                
                $this->_response = array(
                    "response"=>array(
                        "message" => array('Success'),
                        "redirect_to" => 'index.php?p=1'
                        )
                 );    
   
                $ajax->setSuccessResponse($this->_response); 
            }
            catch(Exception $ex)
            {
                $this->_response = array(
                    "response"=>array(
                        "message"=> array("Request couldn't be submitted. Please try again.")
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
        $cmd = new clsPayPalDonationHandler();
        $cmd->setData($this->_data);
        $cmd->preview();

        return $cmd->getDonationId(); 
    }
}
?>