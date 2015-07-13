<table width="100%" cellpadding="0" cellspacing="0" class="tbl">
    <tr class="tbltoprow">
        <td colspan="2">Donation# <?PHP echo $request_data['donation_id']; ?></td>
    </tr>
    <tr class="datarow_even">
        <td width="20%"><label>Donation Date</label></td>
        <td width="80%"><?PHP echo CommonFunc::getFormatedDateTime($request_data['donation_date']); ?></td>
    </tr>
    <tr class="datarow_odd">
        <td width="20%"><label>First Name</label></td>
        <td width="80%"><?PHP echo $request_data['first_name']; ?></td>
    </tr>
     <tr class="datarow_odd">
        <td width="20%"><label>Last Name</label></td>
        <td width="80%"><?PHP echo $request_data['last_name']; ?></td>
    </tr>
     <tr class="datarow_even">
          <td width="20%"><label>Email</label></td>
        <td width="80%"><?PHP echo $request_data['email']; ?></td>
    </tr> 
      <tr class="datarow_odd">
        <td width="20%"><label>Amount</label></td>
        <td width="80%"><?PHP echo DonationConfig::get('currency'); ?> <?PHP echo $request_data['amount']; ?></td>
    </tr>
    <tr class="datarow_even">
          <td width="20%"><label>IP Address</label></td>
        <td width="80%"><?PHP echo $request_data['ip_address']; ?></td>
    </tr> 
     <tr class="datarow_even">
          <td width="20%"><label>Payment Method</label></td>
          <td width="80%"><?PHP echo strtoupper($request_data['payment_method']); ?></td>
    </tr> 
    <tr class="datarow_even">
          <td width="20%"><label>Payment Status</label></td>
          <td width="80%"><?PHP echo strtoupper($request_data['status_id']); ?> 
              <?PHP if($request_data['status_updated_on'] != '0000-00-00 00:00:00'): ?>
                - <small><?PHP echo CommonFunc::getFormatedDateTime($request_data['status_updated_on']); ?></small>
              <?PHP endif; ?>
      </td>
    </tr> 
    <?PHP if($request_data['donation_transaction_data'] != ''):
        $txn_data = (array)json_decode($request_data['donation_transaction_data']);
    

        ?>
      <tr class="tbltoprow">
        <td colspan="2"><?PHP echo strtoupper($request_data['payment_method']); ?> Transaction Details</td>
    </tr>
    <?PHP foreach($txn_data as $k => $v): ?>
     <tr class="datarow_even">
         <td width="20%"><label><?PHP echo strtoupper($k); ?></label></td>
          <td width="80%"><?PHP echo $v; ?></td>
    </tr>
    <?PHP endforeach; ?>
    
    <?PHP endif; ?>
</table>


<?PHP if($request_data['status_id'] != clsDonationStatus::COMPLETED && $request_data['donation_id'] > 0): ?>
<form name="filterfrm" id="filterfrm" action='view.php' method="post">
    <input type="hidden" name="id" value="<?PHP echo (int)$request_data['donation_id']; ?>" />
    <input type="hidden" name="is_pop" value="<?PHP echo (int)$is_pop; ?>" />
    <input type="hidden" name="action" value="update_status" />
 <table width="100%" cellpadding="0" cellspacing="0" class="tbl" style="margin-top:20px;">   
     <tr class="tbltoprow">
        <td colspan="2">Update Payment Status</td>
    </tr>
     <tr class="datarow_even">
          <td width="20%"><label>Select Status</label></td>
          <td width="80%">
              <select name="payment_status">
                  <?PHP echo clsDonationStatus::Instance()->Combo($request_data['status_id']); ?>
              </select>
              <br /><small>Once Status marked as 'Complete' - Action can't be undone!</small>
              <br /><small>On every status update - Date will be captured.</small>
          </td>
    </tr> 
    <tr class="datarow_odd">
        <td colspan="2"> <input name="btn" type="submit" value="Update Status" class="btn" /> </td>
    </tr>
 </table> 
</form>
<?PHP endif; ?>
