<?php
/*
 * PHP Paypal IPN verification Class
 *
 * Rewrite of Micah Carrick's paypal class (http://www.micahcarrick.com)
 * With help from http://www.johnboy.com/blog/http-11-paypal-ipn-example-php-code
 *
 * Copyleft Jean-Emmanuel Doucet - 2014
 * You are free to use, distribute, and modify this software
 * under the terms of the GNU General Public License v3.
 *
 *
 * Usage : 
 * $p = new ipn_class;
 * $p->testing=false; // if you are using paypal's sandbox
 * if ($p->validate_ipn()) {
 *   if($p->ipn_data['payment_status']=='Completed') {
 *     // Do what you want with $p->ipn_data['PAYPAL_FIELD'];
 *     // https://developer.paypal.com/docs/classic/ipn/integration-guide/IPNandPDTVariables/
 *   } else {
 *     // Paiement not completed 
 * } else {
 *    // Paypal verification failed (see logs)
 * }
 *
 */

class ipn_class {
    var $last_error;                 // holds the last error encountered
    var $ipn_log;                    // bool: log IPN results to text file?
    var $ipn_log_file;               // filename of the IPN log
    var $ipn_response;               // holds the IPN response from paypal   
    var $ipn_data = array();         // array contains the POST values for IPN
    
    var $paypalhost = 'www.paypal.com';
    var $sandboxhost = 'sandbox.paypal.com';
    
    function ipn_class() {
        // initialization constructor.  Called when class is created.
        $this->testing = false;
        $this->last_error = '';
        $this->ipn_log_file = 'ipn_log.txt';
        $this->ipn_log = true;
        $this->ipn_response = '';
    }


    function validate_ipn() {
        // Select Host
        if ($this->testing) {
            $host = $this->sandboxhost;
        } else {
            $host = $this->paypalhost;
        }

        // Build POST request for paypal and store datas
        $req = 'cmd=_notify-validate';
        foreach ($_POST as $key => $value) {
            $safevalue = trim(urlencode(stripslashes($value)));
            $req .= "&$key=$safevalue";
            $this->ipn_data["$key"] = $value;
        }
        
        // Build header to post datas back to paypal validation system
        $header = "POST /cgi-bin/webscr HTTP/1.1\r\n";
        $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
        $header .= "Host:" . $host . "\r\n";
        $header .= "Connection: close\r\n";
        $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
        
        $fp = fsockopen ('ssl://' . $host, 443, $errno, $errstr, 30);
        
        if(!$fp) {

            // could not connect to paypal
            $this->last_error = "fsockopen error no. $errnum: $errstr";
            $this->log_ipn_results(false);       
            return false;

        } else { 
        
            fputs ($fp, $header . $req);
            
            // Loop through response and store it
            while(!feof($fp)) { 
                $this->ipn_response .= fgets($fp, 1024); 
            }
            // Close connection
            fclose($fp);

            if (mb_eregi("VERIFIED",$this->ipn_response)) {

                // Valid IPN transaction.
                $this->log_ipn_results(true);
                return true;       

            } else {

                // Invalid IPN transaction.
                $this->last_error = 'IPN Validation Failed.';
                $this->log_ipn_results(false);   
                return false;

            }

        }
    }
    
    
    function log_ipn_results($success) {

        if (!$this->ipn_log) return;  // is logging turned off?

        // Timestamp
        $text = '['.date('m/d/Y g:i A').'] - '; 

        // Success or failure being logged?
        if ($success) $text .= "SUCCESS!\n";
        else $text .= 'FAIL: '.$this->last_error."\n";

        // Log the POST variables
        $text .= "IPN POST Vars from Paypal:\n";
        if ($this->testing) {
            foreach ($this->ipn_data as $key=>$value) {
                $text .= "$key=$value, ";
            }
        } else {
            $text .= "[confidential]\n";
        }

        // Log the response from the paypal server
        $text .= "\nIPN Response from Paypal Server:\n ".$this->ipn_response;

        // Write to log
        $fo=fopen($this->ipn_log_file,'a');
        fwrite($fo, $text . "\n\n"); 

        fclose($fo);  // close file
    }
}
?>
