<?PHP
/**
 * Delete Donation
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */

require_once "include/init.php";

if(CommonFunc::isGet() && isset($_GET['id']))
{
    $contact = new modDonations(MySql::Instance()) ;
    if($contact->Delete($_GET['id']))
    {
        $_SESSION['contact-request-flash'] = "".CommonFunc::SUCCESS."|Entry deleted successfully.";
    }
    else
    {
         $_SESSION['contact-request-flash'] = "".CommonFunc::ERROR."|Entry couldn't be deleted";
    }
    
    CommonFunc::redirect("donations.php");
    
}else
{
    echo"Invalid request!";
}
?>