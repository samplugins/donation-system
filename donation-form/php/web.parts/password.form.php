<script type="text/javascript" src="../assets/scripts/common/jquery.scrollTo-min.js"></script>
<script type="text/javascript" src="../assets/scripts/common/jquery.form.js"></script> 
<script type="text/javascript" src="../assets/scripts/common/common.jquery.js"></script>
<script type="text/javascript" src="../assets/scripts/form/common.js"></script> 
<script type="text/javascript" src="../assets/scripts/form/password.js"></script> 
<h2>Change your password</h2>
<form id="pwd_form" method="post" action="change_password.php">
    <table width="100%" cellpadding="0" cellspacing="0" class="tbl">
      
         
        <tr class="datarow_even">
              <td width="20%"><label>New Password</label></td>
              <td width="80%"><input type="password" class="text" name="new_password" /></td>
        </tr> 
        
         <tr class="datarow_odd">
              <td width="20%"><label>Confirm Password</label></td>
              <td width="80%"><input type="password" class="text" name="confirm_password" /></td>
        </tr> 
       
       
        <tr class="tbltotalbottom">
            <td colspan="2" style="text-align: center;"><input type="submit" id="settings_btn" value="Change" class="btn ajax_submit_btn" />
                <span class="ajax_loading"><img src="../assets/images/ajax-loader.gif" /></span></td>
        </tr> 
    </table>
</form>
<div align="center">
    <div id="settings_response_div" class="reponse_div no_display"></div>
</div>