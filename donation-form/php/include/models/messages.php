<?PHP
class modMessages 
{
    private static $_instance = null;
    
    public static function Instance()
    {
        if(self::$_instance === null)
            self::$_instance = new modMessages();
        
        return self::$_instance;
    }
    
    private $_error = array(); 
    private $_info = array();  
    private $_success = array();  
     
    private function _construct(){}

    function _set_string($m,$type_str){
        if(is_array($m)){
            foreach($m as $k=>$v){
               $_SESSION[$type_str][] =  $v;   
            }
        }else{
             $_SESSION[$type_str][] =  $m;
        }
    }
    function error($m){  
        $this->_set_string($m,"error_message"); 
    }
    
    function success($m){
       $this->_set_string($m,"success_message");    
    }
    
    function info($m){
        $this->_set_string($m,"info_message");
    }
    
    function white($m)
    {
        $this->sys($m);
    }
    
    function sys($m){
       $this->_set_string($m,"white_message");    
    }
    
    function render_msg($msg)
    {
        return '<span class="ico"></span><strong class="system_title">'.$msg.'</strong>';
        
    }
    
    function message($messages,$class,$ul_class='',$id="")
    {
        $messages = (array) $messages;
        $count = count($messages);
        
        if($count == 0)
            return '';
        
        $id_str = '';
        if($id != "")
            $id_str = " id='".$id."'";

        
        if($ul_class != "")
            $ul_class = " ".$ul_class;
            
        $_str = '<ul class="system_messages'.$ul_class.'"'.$id_str.'>';
        for($i=0; $i<$count; $i++){
            $_str .= "<li class='".$class."'>".$this->render_msg($messages[$i])."</li>" ;
        }
        $_str .= "</ul>"; 
        
        return $_str;
    }
    
    private $_messages_count = 0;
    
    function render()
    {
        $errors = count($_SESSION['error_message']);
        $succ = count($_SESSION['success_message']);
        $info = count($_SESSION['info_message']);
        $white_message = count($_SESSION['white_message']);
        
        $this->_messages_count += $errors;
        $this->_messages_count += $succ;
        $this->_messages_count += $info;
        $this->_messages_count += $white_message;
        
        if($white_message){
            $w_str = $this->message($_SESSION['white_message'],'white');
        }
        
        if($errors){
            $e_str = $this->message($_SESSION['error_message'],'red');
        }  
        
     
        if($succ){
            $s_str = $this->message($_SESSION['success_message'],'green');
        }
                      
        if($info){
            $i_str = $this->message($_SESSION['info_message'],'yellow');
        }
        

        unset($_SESSION['error_message']);
        unset($_SESSION['success_message']);
        unset($_SESSION['info_message']);
        unset($_SESSION['white_message']);
        
        $str  =   $e_str.$s_str.$i_str.$w_str;
        return $str;
    }
    
    function messageRenderable()
    {
        return ($this->_messages_count > 0);
    }
	
}//class ends


?>