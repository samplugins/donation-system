<?PHP
/**
 * Login Form
 *
 * @author      Sam Plugins <samplugins@gmail.com>
 * @copyright   Sam Plugins <samplugins@gmail.com>
 * @twitter     http://twitter.com/samplugins
 */
require_once"include/init.php"; ?>
<?PHP
    if(isset($_SESSION['user']))
    {
        echo "<script>window.location='donations.php'</script>";
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" media="screen" href="../assets/style.css" />      
<!--[if lte IE 6]>
<link rel="stylesheet" type="text/css" href="../assets/ie6_less.css" media="screen" />
<script type="text/javascript" src="../assets/cal/iepngfix_tilebg.js"></script>
<![endif]-->                                                                                       
<script type="text/javascript" src="../assets/scripts/jquery.min.js"></script>
<script type="text/javascript" src="../assets/scripts/common/jquery.scrollTo-min.js"></script>     

</head>
<body>
<div class="wrapper">
	<h1>Login</h1>
    <div class="myForm">

    <?PHP if(isset($_SESSION['login-flash'])): $msgParts = explode("|",$_SESSION['login-flash']) ?>
    <div class="message_container" id="inactive_notification">
         <div class="stack-messages"> 
            <div class="message message-<?PHP echo $msgParts[0]; ?>">
                <a class="close-btn" href="#" onclick="$('#inactive_notification').fadeOut(); return false;">x</a>
                <p><?PHP echo $msgParts[1]; ?></p>
            </div>
        </div>
    </div>
    <?PHP unset($_SESSION['login-flash']);  endif; ?>
    
        <form method="post" action="loginCheck.php">
            <p><label>User Name</label><input type="text" id="username" name="username" class="text" /></p>
            <p><label>Password</label><input type="password" id="password" name="password" class="text" /></p>

            <p class="button">
                <input type="submit" name="button" value="Login" id="login_btn" class="btn" />
            </p>                                                                                                         

        </form>
	</div>
</div>
</body>
</html>