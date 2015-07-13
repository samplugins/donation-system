<p>Please verify the information below in order to process your donation.</p>
<br />
<table width="100%" cellpadding="0" cellspacing="0" class="preview">
    <thead>
        <tr>
            <th colspan="2">Your details</th>
        </tr>
    </thead>
    <tbody>
      
        <tr class="second">
            <td width="20%"><label>First Name</label></td>
            <td width="80%"><?PHP echo $donation_data['first_name']; ?></td>
        </tr>  

        <tr class="second">
            <td><label>Last Name</label></td>
            <td><?PHP echo $donation_data['last_name']; ?></td>
        </tr>
        
        <tr class="second">
            <td><label>Email</label></td>
            <td><?PHP echo $donation_data['email']; ?></td>
        </tr>

    </tbody>
</table>
<table width="100%" cellpadding="0" cellspacing="0" class="preview">
    <thead>
        <tr>
            <th colspan="2">Donation details</th>
        </tr>
    </thead>
    <tbody>
        <tr class="second">
            <td width="20%"><label>Amount (in <?PHP echo $config['currency']; ?>)</label></td>
            <td width="80%"><?PHP echo number_format($donation_data['amount'],2); ?></td>
        </tr>
        
    </tbody>
</table>


<div align="center">
    <br /><p><strong>Note:</strong> On "pressing" the continue button, you will be taken to a secured payment page where you can enter your credit card details.</p>
    <br />
    <form method="POST" action="php/donation_process.php">
        <input type="hidden" name='donation_id' value="<?PHP echo $donation_data['donation_id']; ?>" />
        <input type="button" value="Modify Details" class="btn" onclick="ActivateModifyInterface()" />
        <input type="submit" value="Continue" class="btn" />
    </form>
</div>

