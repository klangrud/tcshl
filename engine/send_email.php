<?php
/*
 * Created on Feb 15, 2012
 *
 */
 
/*
 * Send email
 */
function send_bcc_email($emailto_array = array(), $subject = "", $message = "") {
	$from = TCSHL_EMAIL;
	$replyTo = $_SESSION['email'];
		
	//Send email - one email per email in $emailto_array
        for ($i = 0; $i < count($emailto_array); $i++) {
	  $headers = 'From: '.$from. "\r\n".
	      'Reply-To: '.$replyTo. "\r\n".
	      'Bcc: '.$emailto_array[$i]. "\r\n".
	      'Return-Path: '.$from. "\r\n".
	      'X-Mailer: PHP/'.phpversion();

	  # Send email
	  $emailSent = mail('', $subject, $message, $headers);
          
          /*
           * DEBUG CODE
           */

 	  // Debug - If email does not send, need to send webmaster an email so they can debug it.
          if(!$emailSent || get_site_variable_value("DEBUG_EMAIL") == 1) {
            $debugSubject = "EmailManager example.com - debug info";
            $debugFrom = TCSHL_EMAIL;
	    $debugReplyTo = WEBMASTER_EMAIL;
	    $debugHeaders = "From: ".$debugFrom. "\r\n";
  	    $debugHeaders .= "Reply-To: ".$debugReplyTo. "\r\n";
    	    $debugHeaders .= "X-Mailer: PHP/".phpversion();
  
            $debugDate = date("m-d-Y H:i e",time());

            $debugMessage = "Message attempt by: ".$replyTo."\r\n";
            $debugMessage .= "Message attempt date: ".$debugDate."\r\n";
            $debugMessage .= "Message headers: \n".$headers."\r\n";
            $debugMessage .= "Message subject: ".$subject."\r\n";
            $debugMessage .= "Message body: \n";
            $debugMessage .= $message."\r\n";

            // Send debug mail to webmaster
	    mail(WEBMASTER_EMAIL, $debugSubject, $debugMessage, $debugHeaders);
          }
        }
 } 
?>
