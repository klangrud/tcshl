<?php
/*
 * Created on Sep 25, 2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
 class Mail {
 	private $sender;
 	private $recipients;
 	private $subject;
 	private $body;
 	
 	function __construct($sender,$recipients,$subject,$body) {
 	  $this->sender=(string)$sender;
 	  $this->recipients=(string)$recipients;
 	  $this->subject=(string)$subject;
 	  $this->body=(string)$body;
 	}
 	
 	public function sendMail() {
 		if(ENVIRONMENT == 'prod') {
			//Send email
			mail($this->get_recipients(), $this->get_subject(), $this->get_body(), 'From: '.$this->get_sender());
 		} else {
			//Send email - All dev and stg emails can go to the following email
			mail('kurt.langrud@tcshl.com', $this->get_subject(), $this->get_body(), 'From: '.$this->get_sender()); 			
 		}
 	}
 	
	// Get set sender 
	public function set_sender($sender) { 
	    $this->sender=$sender; 
	} 
	public function get_sender() { 
	    return $this->sender; 
	} 
	 
	// Get set recipients 
	public function set_recipients($recipients) { 
	    $this->recipients=$recipients; 
	} 
	public function get_recipients() { 
	    return $this->recipients; 
	} 
	 
	// Get set subject 
	public function set_subject($subject) { 
	    $this->subject=$subject; 
	} 
	public function get_subject() { 
	    return $this->subject; 
	} 
	 
	// Get set body 
	public function set_body($body) { 
	    $this->body=$body; 
	} 
	public function get_body() { 
	    return $this->body; 
	} 
 }
?>
