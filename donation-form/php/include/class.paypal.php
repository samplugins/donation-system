<?php
class clsPaypal extends AbstractPaymentGateway
{

    function StatusCodes()
    {       
        if(count($this->status_array) > 0)
        {
            return $this->status_array;
        }
        
        $this->status_array[] = "Canceled_Reversal"; 
        $this->status_array[] = "Completed";      
        $this->status_array[] = "Created";       
        $this->status_array[] = "Denied";         
        $this->status_array[] = "Expired";         
        $this->status_array[] = "Failed";         
        $this->status_array[] = "Pending";          
        $this->status_array[] = "Refunded";           
        $this->status_array[] = "Reversed";             
        $this->status_array[] = "Processed";              
        $this->status_array[] = "Voided"; 
               
        return $this->status_array;                 
    }
    
    /**
	 * Initialize the Paypal gateway
	 *
	 * @param none
	 * @return void
	 */
	public function __construct()
	{
            parent::__construct();

        // Some default values of the class
		$this->gatewayUrl = 'https://www.paypal.com/cgi-bin/webscr';
		$this->ipnLogFile = 'payment_logs/paypal.ipn_results.log';

		// Populate $fields array with a few default
		$this->addField('rm', '2');           // Return method = POST
		$this->addField('cmd', '_xclick');
	}

    /**
     * Enables the test mode
     *
     * @param none
     * @return none
     */
    public function enableTestMode()
    {
        $this->testMode = TRUE;
        $this->gatewayUrl = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    }

    /**
	 * Validate the IPN notification
	 *
	 * @param none
	 * @return boolean
	 */
	public function validateIpn()
	{
		// parse the paypal URL
		$urlParsed = parse_url($this->gatewayUrl);

		// generate the post string from the _POST vars
		$postString = '';

		foreach ($_POST as $field=>$value)
		{
			$this->ipnData["$field"] = $value;
			$postString .= $field .'=' . urlencode(stripslashes($value)) . '&';
		}

		$postString .="cmd=_notify-validate"; // append ipn command

		// open the connection to paypal
		$fp = fsockopen($urlParsed[host], "80", $errNum, $errStr, 30);

		if(!$fp)
		{
			// Could not open the connection, log error if enabled
			$this->lastError = "fsockopen error no. $errNum: $errStr";
			$this->logResults(false);

			return false;
		}
		else
		{
			// Post the data back to paypal

			fputs($fp, "POST $urlParsed[path] HTTP/1.1\r\n");
			fputs($fp, "Host: $urlParsed[host]\r\n");
			fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
			fputs($fp, "Content-length: " . strlen($postString) . "\r\n");
			fputs($fp, "Connection: close\r\n\r\n");
			fputs($fp, $postString . "\r\n\r\n");

			// loop through the response from the server and append to variable
			while(!feof($fp))
			{
				$this->ipnResponse .= fgets($fp, 1024);
			}

		 	fclose($fp); // close connection
		}

		if (eregi("VERIFIED", $this->ipnResponse))
		{
		 	// Valid IPN transaction.
		 	$this->logResults(true);
		 	return true;
		}
		else
		{
		 	// Invalid IPN transaction.  Check the log for details.
			$this->lastError = "IPN Validation Failed . $urlParsed[path] : $urlParsed[host]";
			$this->logResults(false);
			return false;
		}
	}

    
    function validate_pdt($paypal_transaction_token,$auth_token){
        
      
  /*         Part - 1 */
                $req = 'cmd=_notify-synch';
		$req .= "&tx=$paypal_transaction_token&at=".$auth_token;  // test key
 
 /*         Part - 2 */
                
                 $paypal_url = parse_url($this->gatewayUrl);
                 
       
		$ipnexec = curl_init();
		curl_setopt($ipnexec, CURLOPT_URL, "https://".$paypal_url['host']."/webscr&"); 
		curl_setopt($ipnexec, CURLOPT_HEADER, 0);
		curl_setopt($ipnexec, CURLOPT_USERAGENT, 'Server Software: '.@$_SERVER['SERVER_SOFTWARE'].' PHP Version: '.phpversion());
		curl_setopt($ipnexec, CURLOPT_REFERER, $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].@$_SERVER['QUERY_STRING']);
		curl_setopt($ipnexec, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ipnexec, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ipnexec, CURLOPT_POST, 1);
		curl_setopt($ipnexec, CURLOPT_POSTFIELDS, $req);
		curl_setopt($ipnexec, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($ipnexec, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ipnexec, CURLOPT_TIMEOUT, 30);
		$ipnresult = trim(curl_exec($ipnexec));
		$ipnresult = "status=".$ipnresult;
		curl_close($ipnexec);
 
                /*         Part - 3 */
		$parameter_value_array = explode("\n", $ipnresult);

		foreach ($parameter_value_array as $key=>$value) {
			$key_values = explode("=", $value);
			$this->ipnData[$key_values[0]] = $key_values[1];
		}
 
            return $this->ipnData;
   }

}
