<?PHP
/**
 * abstract Form Handler
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
abstract class FormHandler
{   
    protected $_data = array();
    protected $_config = array();
    protected $_validator;
    
    protected $_response;
    
    protected $_email_settings = null;   
    
   public function __construct($config,$form_data)
    {
        $this->_config = $config;
        $this->_data = $form_data;    
    }

    private function _SetEmailSettings()
    {
        if($this->_email_settings == null)
        {
            $this->_email_settings = array
            (
                'from_name'=> Settings::Get('from_name'),
                'no_reply_email'=>  Settings::Get('no_reply_email'),
                'from_email'=>  Settings::Get('from_email'),
                'reply_to'=>  Settings::Get('reply_to'),
                'to_email'=>  Settings::Get('to_email'),
                'auto_response_template' => array
                (
                    'enable_auto_response' => Settings::Get('enable_auto_response'),
                    'subject' => Settings::Get('subject'),
                    'message' => Settings::Get('message')
                )
            );
        }
    }
    
    protected function EmailSettings($key='')
    {
        $this->_SetEmailSettings();
        
        if($key == '' || $key == null)
        {
            return $this->_email_settings;
        }
        else
        {
             return $this->_email_settings[$key];
        }
    }

    public function setValidator(Validator $validator)
    {
        $this->_validator = $validator;
    }
    
    public function getValidator()
    {
        if($this->_validator == null)
        {
            $this->_validator = new FormValidator();
        }
        
        return $this->_validator;
    }  
    
    public function getConfig($section_key,$key)
    {
        $Data = $this->_config[$section_key];
        return $Data[$key];
    }
        
    public function Validate()
    {
        if($this->getValidator()->Validate($this->_data)->isValidated())
        {
             return true;
        }
        else
        {
            $this->_response = array(
                "response"=>array(
                    "message"=> $this->getValidator()->getMessage()
                    )
             );          
             
             return false;                                                                                                                        
        } 
    }
    
    abstract function Handle();
}//class ends