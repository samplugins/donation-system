<?PHP     
/**
 * Model - Login Checker
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
class Login 
{
    private $_db;
        
    function __construct($db)
    {
        $this->_db = $db;
    }
    
    function loginCheck($username,$password)
    {
        $sql = "SELECT * FROM admin_users WHERE username = '".$username."' AND password = '".md5($password)."'";
        $response =  $this->_db->QuickCount($sql);
        
        if($response > 0)
        {
            $_SESSION['user'] = $username;
            return true;
        }
        else
        {
            return false;
        }
    }
}