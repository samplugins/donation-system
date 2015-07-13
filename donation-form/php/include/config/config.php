<?PHP
/**
 * Config File
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */


define('PHP_FOLDER_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR.  '..' . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR);

$config = array(
    "site_url"=> "http://localhost:50/cc/donation-form/",  // must ends with slash - Trailing slash must be there
    "demo_mode"=> true,
    "currency"=> 'USD',
    "database"  => array(
        'host'=>'localhost',
        'user'=>'root',
        'password'=>'root',
        'db'=>'donation_form'
    )
);

$payment_config = array(
    'paypal' => array
    (
        'merchant_email' => 'icemvc_1327561752_biz@gmail.com',
        'pdt_auth_code' => 'ZrzsgLIK23zrz_FEDP2sTGOdjd9xi4YiXSTz9IFloD9uGOE2Q3jlhdyJkvq',
    ) 
);
  
##Do not touch below this line##

class DonationConfig
{
    static function get($key)
    {
        global $config;
        
        return $config[$key];
        
    }
}
?>