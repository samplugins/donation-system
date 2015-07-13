<?PHP
    $oDonation = new modDonations(MySql::Instance());
    $donation_data = $oDonation->getPendingDonationData(session_id());
    
    $donation_id = (int)$donation_data['donation_id'];
    $q = CommonFunc::security_question();
     
    $style_form = '';
    $style_preview_form = ' style="display:none;"';
    
    $preview_applicable = false;
    $security_code = '';
    if($donation_id > 0 && isset($_GET['p']) && $_GET['p'] == 1)
    {
        $style_preview_form = '';
        $style_form = ' style="display:none;"';
        $preview_applicable = true;
        
        $security_code = $q['a'];
    }
    ?>

    <div id="div_donation_form"<?PHP echo $style_form; ?>>
        <div id="donate_response_div" class="reponse_div no_display"></div>
        <form method="post" id="donate_form" action="php/preview-process.php" class="WebForm">
            <h2>Your Details</h2>

            <p>
                    <label>First Name <em>*</em> <em id="err_first_name" class="error">required</em></label>
                <span><input type="text" id="first_name" value="<?PHP echo $donation_data['first_name']; ?>" name="first_name" class="text req_class" /></span>
            </p>
            <p>
                    <label>Last Name <em>*</em> <em id="err_last_name" class="error">required</em></label>
                <span><input type="text" id="last_name" name="last_name" value="<?PHP echo $donation_data['last_name']; ?>" class="text req_class" /></span>
                    </p>
            <p>
                    <label>Email <em>*</em> <em id="err_email" class="error">required</em></label>
                <span><input type="text" id="email" name="email" value="<?PHP echo $donation_data['email']; ?>" class="text req_class" /></span>
            </p>


            <h2>Donation Details</h2>

            <p>
                <label>Amount (in <?PHP echo $config['currency']; ?>) <em>*</em> <em id="err_amount" class="error">required</em></label>
                <span><input type="text" id="amount" value="<?PHP echo $donation_data['amount']; ?>" name="amount" class="text smalltext req_class" /></span>
            </p>

            <h2>Security Check</h2>
          
            <p>
                <label>Simple Maths? <em>*</em> <em id="err_security_code" class="error">required</em> <br /><em id='em_security_code'><?PHP echo $q['q']; ?></em></label>
                <span><input type="text" maxlength="2" id="security_code" name="security_code" value="<?PHP echo $security_code; ?>" class="text smalltext req_class" maxlength="3" /></span>
                    </p>
            <p class="button">
                <label>&nbsp;</label>
                <span>
                <input type="hidden" name='spam_answer' value="<?PHP echo base64_encode($q['a']); ?>" />
                <input type="submit" name="button" value="Proceed" id="donate_btn" class="btn ajax_submit_btn" />
                </span>
                <span class="ajax_loading"><img src="images/ajax-loader.gif" /></span>
            </p>                                                                                                         
       </form>
    </div>

    <div id="div_preview_donation_details"<?PHP echo $style_preview_form; ?>>
        <?PHP if($preview_applicable): ?>
            <?PHP include 'preview-details.php'; ?>
        <?PHP endif; ?>
    </div>