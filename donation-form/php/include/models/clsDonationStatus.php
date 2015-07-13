<?PHP
class clsDonationStatus extends clsAbstractStatusCodes
{
    private static $_instance;
    
    public static function Instance()
    {
        if(self::$_instance == null)
        {
            self::$_instance = new self();
        }
        
        return self::$_instance;
    }
    
 
   public function getStatusCodes()
   {
       if(is_array($this->_codes) == false)
            $this->_codes = array(self::PENDING,self::IN_PROGRESS,self::PENDING_REVIEW,self::FAILED, self::COMPLETED);
       
       return $this->_codes;
   }
   
   public function isCompleted($status)
   {
        if($status == self::COMPLETED)
        {
            return true;
        }
        return false;
   }
    
}


?>