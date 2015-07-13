<?PHP    
/**
 * Model - Settings
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
class Settings 
{

    function Update($data)
    {
        $sql = "UPDATE settings SET     
                subject = '".$data['subject']."',
                message = '".$data['message']."',
                enable_auto_response = '".$data['enable_auto_response']."',
                enable_email = '".$data['enable_email']."',
                from_name  = '".$data['from_name']."',
                no_reply_email = '".$data['no_reply_email']."',  
                from_email = '".$data['from_email']."',  
                reply_to = '".$data['reply_to']."',
                to_email = '".$data['to_email']."',
                donation_statement_title = '".$data['donation_statement_title']."',
                merchant_test_mode = '".$data['merchant_test_mode']."'
                ";
                
        $response = MySql::Instance()->query($sql);
        if($response)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
      
    public static $_settings = array();
    
    static function Get($key='')
    {
        if(count(self::$_settings) == 0)
        {
            self::$_settings = MySql::Instance()->QuickArray("SELECT * FROM settings");
        }
        
        if(self::$_settings[$key] != null)
        {
            return self::$_settings[$key];
        }
        
        return  self::$_settings;
    }   
                            
}//class ends