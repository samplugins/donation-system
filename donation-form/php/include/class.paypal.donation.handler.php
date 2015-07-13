<?php

class clsPayPalDonationHandler extends AbstractDonationHandler
{
    protected $_payment_method = 'paypal'; 
    protected $_paypal = null;
      
    public function getPayPal()
    {                            
        if($this->_paypal == null)
        {
            $this->_paypal = new clsPaypal();
        }
        
        return $this->_paypal;
    }
    
    private function setCheckoutfields()
    {
        $this->getPayPal()->addField('business', $this->PaymentSettings('merchant_email'));
        $this->getPayPal()->addField('return', $this->getLink('php/payment/paypal/return.php')); 
        $this->getPayPal()->addField('cancel_return',$this->getLink('php/payment/paypal/cancel.php'));          
        $this->getPayPal()->addField('notify_url',$this->getLink('php/payment/paypal/ipn.php'));       
        
        $this->getPayPal()->addField('email', $this->_data['email']);
        $this->getPayPal()->addField('invoice', $this->_donation_id."_".time());
        
        $this->getPayPal()->addField('item_name', $this->_data['item_name']);
        $this->getPayPal()->addField('quantity', 1);
        $this->getPayPal()->addField('amount', number_format($this->_donation_bo->amount, 2, '.', '')); 
        $this->getPayPal()->addField('currency_code', $this->_data['currency_code']);  
        
        $this->getPayPal()->addField('first_name',$this->_donation_bo->first_name);
        $this->getPayPal()->addField('last_name',$this->_donation_bo->last_name);
            
        if($this->_test_mode)
        {
            $this->getPayPal()->enableTestMode();
        }
    }
    
    protected function _preview()
    {
        
    }
    
    protected function _donate()
    {
         $this->setCheckoutfields();
        
        // Let's start the train!
        $this->getPayPal()->submitPayment();
    }
    
    
    protected function _success()
    {
        if($this->_test_mode)
        {
            $this->getPayPal()->enableTestMode();  
        }
        
        
        $txn_data = (array)$this->getPayPal()->validate_pdt($_GET['tx'],$this->PaymentSettings('pdt_auth_code'));
        
	$_POST = array_merge($_GET,$txn_data);
        
        
        
        $invoice =  explode("_",$_POST['invoice']);
        $donation_id = (int)$invoice[0];
        
        $_POST['donation_id'] = $donation_id;
        
        $link = 'donation.php?d='.$donation_id;
        
        if($txn_data['status'] == 'FAIL')
        {
            modMessages::Instance()->error("Transaction couldn't be verified. Invalid donation request");
            commonFunc::redirect($this->getLink($link));
        }
  
        $this->getPayPal()->validate_pdt($tx_token, $auth_token);

        $this->getPayPal()->set_ipn_data($txn_data);
        
        $donation_data = $this->DonationData($donation_id);
        
        if($donation_data['donation_id'] == 0)
        {
            modMessages::Instance()->error("Invalid donation request");
            commonFunc::redirect($this->getLink($link));
        }
        
        $donation_id_collection = array();
        if(isset($_SESSION['did']) && is_array($_SESSION['did']))
        {
            $donation_id_collection = $_SESSION['did'];
        }
        
        $donation_id_collection[] = $_POST['donation_id'];
        $_SESSION['did'] = $donation_id_collection;
        

        if($donation_data['status_id'] == clsAbstractStatusCodes::COMPLETED)
        {
            modMessages::Instance()->info("Donation already processed.");
            CommonFunc::redirect($this->getLink($link));
            exit;
        }
        
        $this->getModel()->logDonationTransactionData($txn_data,$donation_data['donation_id']);

        $payment_status = strtolower($txn_data['payment_status']);
        if($payment_status == '')
        {
            $payment_status = clsAbstractStatusCodes::PENDING_REVIEW;
        }
        
        $link = 'donation.php?d='.$donation_id;
        
        if($payment_status == clsAbstractStatusCodes::COMPLETED)
        {

            $business = urldecode($txn_data['business']);
            
            if($business != $this->PaymentSettings('merchant_email'))
            {
                 $payment_status = clsAbstractStatusCodes::PENDING_REVIEW;
                 modMessages::Instance()->error("Merchant couldn't be verified");
            }
            else if( $txn_data['mc_gross'] != $donation_data['amount'] )
            {
                 $payment_status = clsAbstractStatusCodes::PENDING_REVIEW;
                 modMessages::Instance()->error("Donation couldn't be verified. Amount mis-matched!"); 
            }
            else
            {
                $payment_status = clsAbstractStatusCodes::COMPLETED;
                modMessages::Instance()->success("Payment successfully processed. Thank you!");
                
                 $donation_data['status_id'] = $payment_status;
                 
                if(Settings::Get('enable_email'))
                {
                    $this->_payment_completed_mail($donation_data);
                }
            
            }
        }
        else
        {
            modMessages::Instance()->error("Payment Status: ".$payment_status." - Payment couldn't be processed");
        }
        
         $this->getModel()->UpdateStatus($payment_status,$donation_id); 
         CommonFunc::redirect($this->getLink($link));
    }
    
     private function _payment_completed_mail($donation_data)
    {

        $Mail = new clsMail();  
       
        $fromName = Settings::Get('from_name');
        $no_reply = Settings::Get('no_reply_email');
        $contact_to_email = explode(',',Settings::Get('to_email'));
        $reply_to = Settings::Get('reply_to');
        
        $Mail->IsHTML(true);
        $Mail->prep_headers($fromName,$no_reply);

        $Mail->setSubject("Online Payment Completed By ".$donation_data['first_name']." ".$donation_data['last_name']."");

        $message="<html><body><table cellpadding='0' cellspacing='0' width='100%'>";

      
        $message .="<tr><td width='30%'>First Name</td><td width='70%' colspan='2'>".$donation_data['first_name']."</td></tr>";
        $message .="<tr><td width='30%'>Last Name</td><td width='70%' colspan='2'>".$donation_data['last_name']."</td></tr>";
        $message .="<tr><td width='30%'>Email</td><td width='70%' colspan='2'>".$donation_data['email']."</td></tr>";
        $message .="<tr><td width='30%'>Payment Status</td><td width='70%' colspan='2'>".strtoupper($donation_data['status_id'])."</td></tr>";
        $message .="<tr><td width='30%'>More Details:</td><td width='70%' colspan='2'><a href='".DonationConfig::get('site_url')."php/view.php?id=".$donation_data['donation_id']."'>Click here</a></td></tr>";

        $message .="<tr><td>IP Address</td><td colspan='2'>".$donation_data['ip_address']."</td></tr></table></body></html>";
        
        $Mail->setMessage($message);

        // Email form to multiple email addresses - Added on: 14/April/2011
        foreach($contact_to_email as $k=>$to_email)
        { 
            @$Mail->send($to_email);
        }
        
       
        $subject = '['.Settings::get('donation_statement_title').'] Your Donation';
        if(Settings::get('subject') != '')
        {
            $subject = Settings::get('subject');
        }
        
        $message = Settings::Get('message');
        $message = str_replace('[NAME]', $donation_data['first_name'] . ' ' . $donation_data['last_name'], $message);
        $message = str_replace('[DATE]', CommonFunc::getFormatedDateTime($donation_data['donation_date']) , $message);
        $message = str_replace('[STATUS]', strtoupper($donation_data['status_id']) , $message);

        $Mail->prep_headers($fromName,$reply_to);
        $Mail->setSubject($subject);

        $Mail->setMessage($message);
        @$Mail->send($donation_data['email']);
        
    }
    
    protected function _cancel()
    {
        CommonFunc::redirect($this->getLink());
    }
    
    protected function _ipn()
    {
        if($this->getPayPal()->validateIpn())
        { 
            $invoice =  explode("_",$txn_data['invoice']);
            $donation_id = $invoice[0];
            
            $txn_data['donation_id'] = $donation_id;
            
            $this->getModel()->UpdateStatus($txn_data['transaction_status'],$donation_id); 
        }
    }

}
?>
