<?php

require_once('modules/mail/Mail.php');

$mailer = new mailer();

class mailer {
	
	var $smtp;
	var $enabled;
	
	function loadSmtp() {
	    global $stgs;
	    
	    if ($stgs->getConf("smtp_host")) {
	    
	        $param['host']      = $stgs->getConf("smtp_host");
	        $param['auth']      = ($stgs->getConf("smtp_auth") == "enabled");
	        if ($stgs->getConf("smtp_port")) {
	        	$param['port']      = $stgs->getConf("smtp_port");
			}
	        $param['username']      = $stgs->getConf("smtp_user");
	        $param['password']  = $stgs->getConf("smtp_pass");

            $this->smtp = Mail::factory('smtp', $param );
        } else {
            $this->smtp = false;
        }

	}
	
	function send( $content ) {
		global $stgs;
		
		if ( $this->smtp ) {
			$this->sendPear( $content );
		} else {
		
			$Name = $stgs->getConf("sitename");
			$email = $content['From'];
			$header = "From: ". $Name . " <" . $email . ">\r\n";

			mail($content['To'], $content['Subject'], $content['body'], $header);
		}
	}
	
	function sendPear( $content ) {
	    
        $body  = $content['body'];
            
        unset($content['body']);

        $result = $this->smtp->send($content['To'], $content, $body);
        
        if (PEAR::isError($result)) {
	           manage_error(1000);
	    }

        return true;
    }
	
	
	
}
