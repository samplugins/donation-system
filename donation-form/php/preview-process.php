<?PHP
/**
 * Form Handler
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
require_once"include/init.php";  
$handler = new clsPreviewFormHandler($config,$_POST);
$handler->handle();
?>