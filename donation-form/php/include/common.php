<?PHP   
/**
 * Common Helper Funcs
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
class CommonFunc
{
    const INFO = "info";
    const SUCCESS = "success";
    const ERROR = "error";
    const ATTENTION = "attention";
    
    static function security_question($key='security_code')
    {
        $n1 = rand(1,3);
        $n2 = rand(4,8);
        $ans = $n1 + $n2;

        $a['q'] = "What is ".$n1." + ".$n2." ?";
        $a['a'] = $ans;
        $_SESSION[$key] = $a['a'];
        return $a;
    }
    
    static function isPost(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            return true;    
        }
        return false;
    }
    
    
    static  function isGet(){
        if($_SERVER['REQUEST_METHOD'] == "GET"){
            return true;    
        }
        return false;
    }
    
    static function isAjax() {
      return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ( $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));
    }
    
    static function redirect($url)
    {
        header("Location: ".$url.""); 
    }
    
    static  function textCut($text,$limit=60)
    {
        $matches = array();
        preg_match('/(^.{'.$limit.',}?) /', $text, $matches);
        if (isset($matches[1])) {
            return $matches[1] . "...";
        } else {
            return $text;
        }
    }
    
    static  function getFormatedDateTime($dbstr)
    {
        return date("d M, Y - g:i:s", strtotime($dbstr));
    }
    
    static function CurrentDateFileName()
    {
        return date("d-M-Y", time());
    }
    
    static  function tr_class($index)
    {
         if($index % 2)
            return "even";
         return "odd";
    }
    
    static function SetFlashMessage($type,$message)
    {
        $_SESSION['msg-request-flash'] = $type . "|" . $message;
    }
    
    static function RenderFlashMessage()
    {
       if(isset($_SESSION['msg-request-flash'])): $msgParts = explode("|",$_SESSION['msg-request-flash']) ?>
         <div class="message_container" id="msgFlashDiv">
             <div class="stack-messages"> 
                <div class="message message-<?PHP echo $msgParts[0]; ?>">
                    <a class="close-btn" href="#" onclick="$('#msgFlashDiv').fadeOut(); return false;">x</a>
                    <p><?PHP echo $msgParts[1]; ?></p>
                </div>
            </div>
        </div>
        <?PHP unset($_SESSION['msg-request-flash']);  endif; 
    }
    
     static function safe($string){
        return self::escape(stripslashes($string));
    }
    
    static  function escape($v){
        if(!is_array($v)){
            return @mysql_real_escape_string($v);
        }else{
            return @array_map("mysql_real_escape_string",$v); 
        }
    }
}
?>