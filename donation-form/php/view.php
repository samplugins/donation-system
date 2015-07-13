<?PHP
/**
 * View Request Details
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
require_once"include/init.php"; ?>
<?PHP 

$id = (int)$_GET['id'];
$oDonation = new modDonations(MySql::Instance());
$is_pop = 1;

if(CommonFunc::isPost())
{
    $is_pop = (int)$_POST['is_pop'];
    $id = (int)$_POST['id'];
    
    if($_POST['action'] == 'update_status')
    {
        $payment_status = $_POST['payment_status'];
        
        $r = $oDonation->UpdateStatus($payment_status, $id);
        if($r)
        {
             CommonFunc::SetFlashMessage( "".CommonFunc::SUCCESS."|Payment status updated successfully." );
        }
        else
        {
            CommonFunc::SetFlashMessage( "".CommonFunc::ERROR."|Payment status updated successfully." );
        }
    }
}


include"web.parts/header.php"; ?>
   <?PHP    
    
    $request_data = $oDonation->Row($id);
    if($request_data['donation_id'] > 0):
    ?>
     <?PHP include "web.parts/donation_details.php"; ?>  
    <?PHP else: ?>
        <p>Invalid Request</p>
    <?PHP endif; ?>

<?PHP include"web.parts/footer.php"; ?>