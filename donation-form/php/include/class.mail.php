<?PHP
/**
 * Native Mail Handler
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
class clsMail
{
    
	private $from = NULL;
    private $from_email = NULL;
	private $returnpath;
	private $headers = '';
	private $message;
	private $subject;
	private $contentType;
	private $charset  = "iso-8859-1";
    
    private $content_transfer_encoding;
    
    private $is_html;
    
    private $priority = 1;  /*Email priority (1 = High, 3 = Normal, 5 = low)*/
	
	function __construct(){
	    $this->IsHTML(true);
	}
	
	function IsHTML($bool) {
        $this->is_html = $bool;
        if($bool == true){
            $this->contentType = "text/html";
        }else{
            $this->contentType = "text/plain";
        }
    }
    
    function setCarset($set){
        $this->charset = $set;
    }
    
    function prep_headers($from,$from_email){
        $this->setHeader("MIME-Version: 1.0\n");
        $this->setHeader("Content-type: ".$this->contentType."; charset=".$this->charset."\n");
        $this->setHeader("From: \"".$from ."\" <".$from_email.">\n");
        $this->setHeader("Date: ".date("r")."\n");
        if($this->content_transfer_encoding != ''){
            $this->setHeader("Content-Transfer-Encoding: ".$this->content_transfer_encoding."\n");
        }
    }
    
    function setTransferEncoding($header){
        $this->content_transfer_encoding = $content_transfer_encoding;
    }
    
    function getTransferEncoding(){
        return $this->content_transfer_encoding;
    }
    	
    function setHeader($header){
            $this->headers .= $header;
    }

    function getHeaders(){
            return $this->headers.$this->getReturnPath();
    }

    function setFrom($from){
            $this->from = $from;
    }

    function getFrom(){
            return $this->from;
    }

    function setPriority($priority){
            $this->priority = $priority;
    }

    function getPriority(){
            return $this->priority;
    }

    function setReturnPath($returnpath){
            $this->returnpath = $returnpath;
    }

    function getReturnPath(){
            return $this->returnpath;
    }

    function setMessage($message){
            $this->message = $message;
    }

    function getMessage(){
    $message = $this->message;
    if($this->is_html)
    {
        $message = nl2br($this->message);
    }
    return $message;
    }

    function setSubject($subject){
            $this->subject = $subject;
    }

    function getSubject()
    {
            return $this->subject;
    }
	
    function send($to)
    {
        global $config;
        
        if($config['demo_mode'] == true)
        {
            return;  //disable emails in demo mode
        }
        
        $r = @mail($to,$this->getSubject(),$this->getMessage(), $this->getHeaders());
        if($r){
                return true;
        }else{
                return false;
        }
    }
}