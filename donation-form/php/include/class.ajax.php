<?PHP
/**
 * Ajax Response Generator
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
class Ajax  
{
    private static $_instance = null;
    
    public static function Instance()
    {
        if(self::$_instance === null)
        {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }
    
    private function __construct(){}
    
    const SESSION_TIME_OUT = "SESSION_TIME_OUT";
    const CONNECTION_FAILED = "CONNECTION_FAILED";
    const SUCCESS_CODE = "SUCCESS";
	const ERROR_CODE = "ERROR";
    
    private $_data = array();
    
    function setResponse($code,$responseTxt)
    {
        $this->_data['code'] = $code;
        $this->_data['ice_response'] = $responseTxt;
    
        return $this;
    }
    
    /**
    * Helper method
    * 
    * @param mixed $message
    */
    function setErrorResponse($message)
    {
        $this->setResponse(self::ERROR_CODE,$this->getFormattedArray($message,'error'));
    }
    
    /**
    * Helper method
    * 
    * @param mixed $message
    */
    function setSuccessResponse($message)
    {
        $this->setResponse(self::SUCCESS_CODE,$this->getFormattedArray($message,'success'));
    }
    
    private function getFormattedArray($data_str,$key)
    {
        $data = array();
        $data[$key] = (array)$data_str;
        return $data;
    }
    
    public function renderJSONResponse($response_code=0)
    {
        if($response_code > 0)
        {
            header('content-type: application/json',false,$response_code); 
        } 
        else
        {
            header('content-type: application/json');
        }
        echo json_encode($this->_data);
    } 
}