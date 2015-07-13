<?PHP
/**
 * Script Init
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_STRICT);
 
ob_start();
session_start();   

define('PATH_INCLUDE', dirname(__FILE__) . DIRECTORY_SEPARATOR );

require_once PATH_INCLUDE . "config/config.php";
require_once PATH_INCLUDE . "common.php";
require_once PATH_INCLUDE . "abstract/validator.php";
require_once PATH_INCLUDE . "class.db.mysql.php";    
require_once PATH_INCLUDE . "class.ajax.php";    
require_once PATH_INCLUDE . "class.validation.php";
require_once PATH_INCLUDE . "class.donation.validator.php";
require_once PATH_INCLUDE . "abstract/handler.php";
require_once PATH_INCLUDE . "models/clsAbstractStatusCodes.php";
require_once PATH_INCLUDE . "models/clsDonationStatus.php";
require_once PATH_INCLUDE . "models/donationBO.php";
require_once PATH_INCLUDE . "models/donations.php";
require_once PATH_INCLUDE . "models/settings.php";
require_once PATH_INCLUDE . "models/login.php";
require_once PATH_INCLUDE . "models/messages.php";
require_once PATH_INCLUDE . "class.mail.php";
require_once PATH_INCLUDE . "class.csv.php";
require_once PATH_INCLUDE . "class.previewform.handler.php";
require_once PATH_INCLUDE . "class.paging.php";
require_once PATH_INCLUDE . "class.array.helper.php";
require_once PATH_INCLUDE . "abstract.donation.handler.php";
require_once PATH_INCLUDE . "class.paypal.donation.handler.php";
require_once PATH_INCLUDE . "abstract.payment.php";
require_once PATH_INCLUDE . "class.paypal.php";

@date_default_timezone_set("America/New_York");

function DemoNotice()
{
     global $config;
     
     if($config['demo_mode'] == true):
     ?>
        <div class="message_container" id="inactive_notification">
             <div class="stack-messages"> 
                <div class="message message-attention">
                    <a class="close-btn" href="#" onclick="$('#inactive_notification').fadeOut(); return false;">x</a>
                    <p><strong>Demo Mode:</strong> Live donation won't be applicable in demo mode and Email functionality is also disabled in demo mode for spamming purpose. Regardless of the settings you do using admin panel - There's a demo mode setting in config file which restricts email sending.</p>
                </div>
            </div>
        </div>
     <?
     endif;
}
?>