<script type="text/javascript" src="../assets/scripts/common/jquery.scrollTo-min.js"></script>
<script type="text/javascript" src="../assets/scripts/common/jquery.form.js"></script> 
<script type="text/javascript" src="../assets/scripts/common/common.jquery.js"></script>
<script type="text/javascript" src="../assets/scripts/form/common.js"></script> 
<script type="text/javascript" src="../assets/scripts/form/settings.js"></script> 
<h2>Settings</h2>
<form id="settings_form" method="post" action="settings.php">
    <table width="100%" cellpadding="0" cellspacing="0" class="tbl">
      
         <tr class="tbltoprow">
            <td colspan="2">Donation Settings</td>
        </tr>
        <tr class="datarow_even">
              <td width="20%"><label>Statement Title</label></td>
              <td width="80%"><input type="text" class="text" name="donation_statement_title" value="<?PHP echo $settings['donation_statement_title']; ?>" /></td>
        </tr> 
        <tr class="datarow_odd">
              <td width="20%"><label>Test Mode</label></td>
              <td width="80%">
                   <select style="width:150px;" name="merchant_test_mode">
                    <?PHP
                    $options[1] = 'Enabled';
                    $options[0] = 'Disabled';
                    echo clsArray::arrayToComboOptions($options,$settings['merchant_test_mode']);
                    ?>
                </select>
                <br /><small>Enable/Disable Paypal's Test Mode</small>
                <br /><small>If enabled, PayPal transaction will be in test mode.</small>
                  
              </td>
        </tr>
          <tr class="tbltoprow">
            <td colspan="2">Email Settings</td>
        </tr>
    <tr class="datarow_even">
              <td width="20%"><label>Email</label></td>
            <td width="80%">
                <select style="width:150px;" name="enable_email">
                    <?PHP
                    $options[1] = 'Enabled';
                    $options[0] = 'Disabled';
                    echo clsArray::arrayToComboOptions($options,$settings['enable_email']);
                    ?>
                </select>
                <br /><small>Enable/Disable Email</small>
            </td>
        </tr> 
        <tr class="datarow_odd">
            <td width="20%"><label>From Name</label></td>
            <td width="80%"><input type="text" class="text" name="from_name" value="<?PHP echo $settings['from_name']; ?>" />
        </tr>
         <tr class="datarow_even">
              <td width="20%"><label>No-Reply Email</label></td>
            <td width="80%"><input type="text" class="text" name="no_reply_email" value="<?PHP echo $settings['no_reply_email']; ?>" />
            </td>
        </tr> 
          <tr class="datarow_odd">
            <td width="20%"><label>From Email</label></td>
            <td width="80%">
                <input type="text" class="text" name="from_email" value="<?PHP echo $settings['from_email']; ?>" />
            <br /><small>Confirmation email will be sent from this email address</small>
            </td>
        </tr>
        <tr class="datarow_even">
              <td width="20%"><label>To Email(s)</label></td>
            <td width="80%">
                 <textarea rows="5" cols="60" name="to_email"><?PHP echo $settings['to_email']; ?></textarea>
                <br /><small>Form submissions will be sent to these email(s) <br /> For multiple email - use comma to separate email addresses</small>
            </td>
        </tr> 
         <tr class="datarow_odd">
              <td width="20%"><label>Reply-to Email</label></td>
            <td width="80%"><input type="text" class="text" name="reply_to" value="<?PHP echo $settings['reply_to']; ?>" />
            </td>
        </tr> 
         <tr class="tbltoprow">
            <td colspan="2">Auto Response Settings</td>
        </tr>
        <tr class="datarow_odd">
              <td width="20%"><label>Enable Auto Response</label></td>
            <td width="80%">
                <select style="width:80px;" name="enable_auto_response">
                    <?PHP
                    $options[1] = 'Yes';
                    $options[0] = 'No';
                    echo clsArray::arrayToComboOptions($options,$settings['enable_auto_response']);
                    ?>
                </select>
                <br /><small>Allow you to enable/disable auto response email trigger</small>
            </td>
        </tr> 
       
        <tr class="datarow_even">
              <td width="20%"><label>Subject</label></td>
            <td width="80%"><input type="text" class="text" name="subject" value="<?PHP echo $settings['subject']; ?>" /></td>
        </tr> 
        <tr class="datarow_odd">
              <td width="20%"><label>Message</label></td>
            <td width="80%">
                <textarea rows="10" cols="60" name="message"><?PHP echo $settings['message']; ?></textarea>
            </td>
        </tr> 
        <tr class="tbltotalbottom">
            <td colspan="2" style="text-align: center;"><input type="submit" id="settings_btn" value="Save Settings" class="btn ajax_submit_btn" />
                <span class="ajax_loading"><img src="../assets/images/ajax-loader.gif" /></span></td>
        </tr> 
    </table>
</form>
<div align="center">
    <div id="settings_response_div" class="reponse_div no_display"></div>
</div>