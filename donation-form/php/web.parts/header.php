<?PHP
if($not_check_login == false)
{
    if(!isset($_SESSION['user']))
    {
        echo "<script>window.location='login.php'</script>";
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Donation Form - Administration</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" media="screen" href="../assets/style.css" />      
<!--[if lte IE 6]>
<link rel="stylesheet" type="text/css" href="../assets/ie6_less.css" media="screen" />
<script type="text/javascript" src="../assets/cal/iepngfix_tilebg.js"></script>
<![endif]-->
<script type="text/javascript" src="../assets/scripts/jquery.min.js"></script>                 
<script type="text/javascript" src="../assets/scripts/jquery.dynDateTime-0.2/jquery.dynDateTime.js"></script>     
<script type="text/javascript" src="../assets/scripts/admin/menu.js"></script>  

<script type="text/javascript">
    var GB_ROOT_DIR = "../assets/scripts/greybox/";
</script>

<script type="text/javascript" src="../assets/scripts/greybox/AJS.js"></script>
<script type="text/javascript" src="../assets/scripts/greybox/AJS_fx.js"></script>
<script type="text/javascript" src="../assets/scripts/greybox/gb_scripts.js"></script>
<script type="text/javascript" src="../assets/scripts/admin.js"></script>
<link href="../assets/scripts/greybox/gb_styles.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="wrapper">
    <h1>Donation Form - Administrative Panel</h1>
    <?PHP if($not_check_login == false):
        if($is_pop != 1): ?>
        <?PHP include 'menu.php' ;?>
         <?PHP endif; ?>
    <?PHP endif; ?>
    
    <?PHP DemoNotice(); ?>