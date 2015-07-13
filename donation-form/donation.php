<?PHP 
/**
 * Donation Form
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */

ob_start();
session_start();
include"php/include/common.php";
include"php/include/init.php";
     
$oDonation = new modDonations(MySql::Instance());
$donation_id = (int)$_GET['d'];


if($donation_id == 0 || !isset($_SESSION['did']))
{
    CommonFunc::redirect(DonationConfig::get('site_url'));
}


$donation_data = $oDonation->Row($donation_id);

if($donation_data['donation_id'] == 0)
{
    CommonFunc::redirect(DonationConfig::get('site_url'));
}
else if($donation_data['donation_id'] > 0 && !in_array($donation_data['donation_id'], (array)$_SESSION['did']))
{
    CommonFunc::redirect(DonationConfig::get('site_url'));
}


$messageData = array();
if($donation_data['status_id'] == clsAbstractStatusCodes::COMPLETED)
{
    $messageData = array
    (
        'heading' => 'Thank you!',
        'message' => 'Payment has been processed successfully.'
    );
}
else if($donation_data['status_id'] == clsAbstractStatusCodes::PENDING_REVIEW)
{
    $messageData = array
    (
        'heading' => 'Thank you!',
        'message' => 'Payment needs to be reviewed.'
    );
}
else
{
    $messageData = array
    (
        'heading' => 'Thank you for your request.',
        'message' => 'Your request has been submitted successfully. Payment Status: <strong>'.ucfirst($donation_data['status_id']).'</strong>'
    );
}

$msgs = modMessages::Instance()->render();
if($msgs != '')
{
    $messageData['message'] = $msgs;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Donation Status</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" media="screen" href="assets/style.css" /> 
<script type="text/javascript" src="assets/scripts/jquery.min.js"></script>
<script type="text/javascript" src="assets/scripts/common/jquery.scrollTo-min.js"></script>
</head>

<body>
    	<div class="wrapper">    
           
            <h1><?PHP echo $messageData['heading']; ?></h1> 
            <p><?PHP echo $messageData['message']; ?></p>
            
            <br /><a href="<?PHP echo DonationConfig::get('site_url'); ?>"><strong>Want to donate more?</strong></a>
        </div>
</body>
</html>