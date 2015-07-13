<?PHP
/**
 * View Request Details
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
require_once"include/init.php";

if(CommonFunc::isPost() && CommonFunc::isAjax())
{
    include 'include/class.settingsform.handler.php';
    $handler = new clsSettingsFormHandler($config,$_POST);
    $handler->handle();
    exit;
}

?>
<?PHP $is_pop = 1;
include"web.parts/header.php"; ?>

     <?PHP 
     $settings = Settings::Get();
     include "web.parts/settings.form.php"; ?>  

<?PHP include"web.parts/footer.php"; ?>