<?PHP
/**
 * Logout - Destroys Session
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
require_once"include/init.php";

    if(isset($_SESSION['user']))
    {
        session_destroy();
        echo "<script>window.location='login.php'</script>";
    }
    
?>