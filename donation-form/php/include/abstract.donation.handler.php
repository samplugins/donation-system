<?php
abstract class AbstractDonationHandler 
{
    protected $_payment_method = null;
    protected $_merchant_settings = null;
    protected $_donation_bo = null;
    protected $_donation_id = null;
    protected $_donation_data = null;
    
    protected $_test_mode = null;
    
    public function __construct() {
        $this->_test_mode = Settings::Get('merchant_test_mode');
    }

    
    abstract protected function _donate();
    abstract protected function _preview();
    abstract protected function _success();
    abstract protected function _cancel();
    abstract protected function _ipn();

    public function getModel()
    {
        if($this->_model == null)
            $this->_model = new modDonations();
        
        return $this->_model;
    }
    
    public function getDonationId()
    {
        return $this->_donation_id;
    }
    
    public function DonationData($donation_id)
    {
         if($this->_donation_data == null)
         {
             $this->_donation_data = $this->getModel()->Row($donation_id);
         }
         
         return $this->_donation_data;
    }

    
    
    public function PaymentSettings($key='')
    {
        global $payment_config;
      
        $config = $payment_config[$this->_payment_method];
        
        if($key != null && $key !='')
        {
            return $config[$key];
        }
        return $config;
    }
    
    private function setBusinessObjectData($data)
    {
        if(is_object($this->_donation_bo) == false)
        {
            return;
        }
        
        foreach($data as $key => $value)
        {
            $this->_donation_bo->$key = CommonFunc::Safe($value);
        }
        
     
    }
    
    private function SaveDonationData()
    {
        $this->_donation_bo = new modDonationBO();                                 
        $this->_donation_bo->session_id = session_id();
        $this->_donation_bo->status_id = clsAbstractStatusCodes::PENDING;                   
        $this->_donation_bo->payment_method = $this->_payment_method;                   
        
        $this->_donation_bo->donation_id = $this->getModel()->GetPendingDonationID($this->_donation_bo->session_id);
      
        if($this->_donation_bo->donation_id > 0)
        {
            $this->setBusinessObjectData($this->DonationData($this->_donation_bo->donation_id));
        }
        else
        {
            $this->setBusinessObjectData($this->getData());
        }
            

        $this->_donation_id = $this->getModel()->Save($this->_donation_bo);
      
        $this->_donation_bo->donation_id = $this->_donation_id;
    }

    public function donate()
    {
        $this->SaveDonationData();
        $this->_donate();
    }
    
    public function preview()
    {
        if(CommonFunc::isAjax())
        {
            $this->SaveDonationData();
            $this->_preview();
        }
    }

    private function success()
    {
        session_regenerate_id();
        $this->_success();
    }   
     
    private function ipn()
    {
        session_regenerate_id();
        $this->_ipn();
    }
    
    private function cancel()
    {
        session_regenerate_id();
        $this->_cancel();
    }

    public function Execute()
    {
        $method = strtolower($this->getMethod());
        
        if(method_exists($this,$method) == false)
        {
            die("Invalid request");
        } 
        
        $this->$method();
    }
    
    protected function getLink($page='')
    {
        $str = DonationConfig::get('site_url');
        
        if($page != '')
        {
            $str  = $str . $page;
        }
        
        return $str;
    }
    
    protected function getOrderID()
    {
        return $this->_donation_id."_".time();
    }
    
    // Data | ARRAY 
    protected $_data;
    
    // model Class Object
    protected $_model;
    
    //by default comamnd is not executed
    protected $_isExecuted = false;
    
    protected $_response;
    
    //model's method name
    protected $_method;
    
    public function setResponse($response)
    {
        $this->_response = $response; 
        
        return $this;
    }
    
    public function getResponse()
    {
        return $this->_response;
    }
    
    public function setExecuted($execution_status)
    {
        $this->_isExecuted  = $execution_status;
    }  
      
    public function isExecuted()
    {
        return $this->_isExecuted;
    }
    
    public function setModel($oModel)
    {
        if(is_object($oModel) == false)
            throw new Exception("".$oModel." is invalid model object.");
            
         $this->_model = $oModel;
         
         return $this;
    }   
     
   
    public function setMethod($method)
    {
        $this->_method =  $method;
        
        return $this;
    }
    
    public function getMethod()
    {
        //set command Name as Default Method Name
        if($this->_method == NULL || !isset($this->_method))
        {
           $this->_method = substr(get_class($this),3);
        }
        
        return $this->_method;
    }
    
    public function setData($data)
    {
        $this->_data = $data;
        
        return $this;
    }  
                    
    public function getData($key='')
    {
        if($key === '')
            return $this->_data;
        else 
            return $this->_data[$key];
    }                  

}
?>
