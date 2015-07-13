<?PHP
/**
 * Form Handler
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
require_once"include/init.php";  

$cmd = new clsPayPalDonationHandler();
$data = array();
$data['item_name'] = Settings::Get('donation_statement_title');
$data['currency_code'] = DonationConfig::Get('currency');

$cmd->setData($data)->donate();
?>