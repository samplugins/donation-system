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
                   
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>PHP Donation Form</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" media="screen" href="assets/style.css" /> 
<script type="text/javascript" src="assets/scripts/jquery.min.js"></script>
<script type="text/javascript" src="assets/scripts/common/jquery.scrollTo-min.js"></script>
<script type="text/javascript" src="assets/scripts/common/jquery.form.js"></script> 
<script type="text/javascript" src="assets/scripts/form/common.js"></script> 
<script type="text/javascript" src="assets/scripts/common/common.jquery.js"></script>   
<script type="text/javascript" src="assets/scripts/donate-form/form.js"></script>   
</head>

<body>
    	<div class="wrapper">         
            <h1>PHP Donation Form</h1> 
            <?PHP include 'php/web.parts/donation-form.php'; ?>

        </div>
</body>
</html>