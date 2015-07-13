<?PHP
/**
 * Login Checker
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
require_once"include/init.php";

if(CommonFunc::isPost())
{
    $Login = new Login(MySql::Instance());

    if($Login->loginCheck(CommonFunc::safe($_POST['username']),  CommonFunc::safe($_POST['password'])))
    {
        echo "<script>window.location='donations.php'</script>";
    }
    else
    {
        $_SESSION['login-flash'] = "".CommonFunc::ERROR."|Invalid username and/or password";
        echo "<script>window.location='login.php'</script>";
    }

}
?>