<?php
/*
 * Created on Oct 29, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
// Page requirements
define('LOGIN_REQUIRED', true);
define('PAGE_ACCESS_LEVEL', 1);
define('PAGE_TYPE', 'USER');

// Set for every page
require ('engine/common.php');

if ((isset ($_POST['action'])) && ($_POST['action'] == "Send Email")) {
	// If form does not validate, we need to return with errors.
	if ($errors = validate_emailer_form()) {
		handle_errors($errors);
		//handle_reposts();
	} else {
		// If errors occur while trying to create user, we need to return with errors.
		if ($errors = process_emailer_form($smarty)) {
			handle_errors($errors);
			//handle_reposts();
		} else {
			$success = array ();
			$success[] = 'Email Sent.';
			handle_success($success);
		}		
	}
}

$smarty->assign('page_name', 'Email Manager');
setup_email_groups();
$smarty->assign('senderName', $_SESSION['firstname'].' '.$_SESSION['lastname']);

$smarty->assign('season_name', get_season_name($SEASON));

// Build the page
require ('global_begin.php');
$smarty->display('user/emailmanager.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/

function setup_email_groups() {
	global $smarty;
	
	//Goes to global functions to get team candidates
	setup_team_candidates();
	
	
}


function validate_emailer_form() {
	$errors = array();
	
	return $errors;
}

function process_emailer_form() {
	$to_email_array = get_email_addresses();
	$subject = $_POST['sub'];
	$message = $_POST['msg'];
	if((isset ($_POST['omitName'])) && $_POST['omitName'] == 1) {
		// Sender wishes to omit their name from the email message.
	} else {
		$message .= ' -'.$_POST['from'];
	}
	//email_message($to,$subject,$message);
	send_bcc_email($to_email_array,$subject,$message);
}

/*
 * Get email addresses
 */
function get_email_addresses() {
  $toValue = $_POST['to'];
  $webemail_array = array();
  $webemail_array[] = TCSHL_EMAIL;
  
  if($toValue > 0) {
  	$addressArray =  get_team_addresses($toValue);
  } else if($toValue == 'mass') {
  	$addressArray =  get_every_address();
  } else if($toValue == 'all') {
  	$addressArray =  get_all_player_addresses();  	
  } else if($toValue == 'rep') {
  	$addressArray =  get_all_rep_addresses();
  } else if($toValue == 'ref') {
  	$addressArray =  get_all_ref_addresses();
  } else if($toValue == 'site') {
  	$addressArray =  get_all_registered_user_addresses();
  } else if($toValue == 'web') {
        $addressArray = array();
        $addressArray[] = WEBMASTER_EMAIL;
  }
  
  $webemail_array = array_merge($webemail_array,$addressArray);
  return $webemail_array;
  
}

/*
 * Team Email Addresses
 */
function get_team_addresses($TEAMID) {
  global $SEASON;
  
  $subQuery = 'SELECT registrationId FROM '.PLAYER.' WHERE seasonid='.$SEASON;
  $subQuery2 = 'SELECT playerid FROM '.ROSTERSOFTEAMSOFSEASONS.' WHERE teamID='.$TEAMID.' AND seasonID='.$SEASON;
  
  $select = 'SELECT eMail FROM '.REGISTRATION;
  $select .= ' WHERE seasonid='.$SEASON;
  $select .= ' AND registrationId IN ('.$subQuery.')';
  $select .= ' AND playerId IN ('.$subQuery2.')';
  $select .= ' AND eMail IS NOT NULL';
  $select .= ' AND eMail != ""';
  $select .= ' GROUP BY eMail';
  
  return emails($select);	
}


/*
 * Get All Addresses
 */
function get_every_address() {
  $subQuery = 'SELECT eMail FROM '.USER.' WHERE accessLevel > 0 ORDER BY eMail';
  
  $select = 'SELECT distinct eMail FROM '.REGISTRATION;
  $select .= ' WHERE eMail NOT IN ('.$subQuery.')';
  $select .= ' AND eMail IS NOT NULL';
  $select .= ' AND eMail != ""';
  $select .= ' AND eMail != "administrator@tcshl.com"';
  $select .= ' AND eMail != "board@tcshl.com"';
  $select .= ' AND eMail != "payment@tcshl.com"';
  $select .= ' AND eMail != "referees@tcshl.com"';
  $select .= ' AND eMail != "registration@tcshl.com"';
  $select .= ' AND eMail != "teamreps@tcshl.com"';
  $select .= ' AND eMail != "siteregistration@tcshl.com"';
  $select .= ' AND eMail != "stats@tcshl.com"';
  $select .= ' AND eMail != "tcshl@tcshl.com"';
  $select .= ' ORDER BY eMail';
  
  $everyEmail = array_merge(emails($subQuery),emails($select));
     
  return $everyEmail;  
}


/*
 * Get All Player Addresses
 */
function get_all_player_addresses() {
  global $SEASON;
  
  $subQuery = 'SELECT registrationId FROM '.PLAYER.' WHERE seasonid='.$SEASON;
  
  $select = 'SELECT eMail FROM '.REGISTRATION;
  $select .= ' WHERE seasonid='.$SEASON;
  $select .= ' AND registrationId IN ('.$subQuery.')';
  $select .= ' AND eMail IS NOT NULL';
  $select .= ' AND eMail != ""';
  $select .= ' GROUP BY eMail';
  
  return emails($select);  
}

/*
 * Get All Team Rep Addresses
 */
function get_all_rep_addresses() {
  global $SEASON;
  
  $subQuery = 'SELECT teamRep FROM '.TEAMSOFSEASONS.' WHERE seasonID='.$SEASON;
  
  $select = 'SELECT eMail FROM '.REGISTRATION;
  $select .= ' WHERE seasonid='.$SEASON;
  $select .= ' AND playerId IN ('.$subQuery.')';
  $select .= ' AND eMail IS NOT NULL';
  $select .= ' AND eMail != ""';
  $select .= ' GROUP BY eMail';
  
  return emails($select);		
}

/*
 * Get All Ref Addresses
 */
function get_all_ref_addresses() {
  global $SEASON;
  
  $subQuery = 'SELECT registrationId FROM '.PLAYER.' WHERE seasonid='.$SEASON;
  $subQuery2 = 'SELECT playerid FROM '.REFEREESOFSEASONS.' WHERE seasonID='.$SEASON;
  
  $select = 'SELECT eMail FROM '.REGISTRATION;
  $select .= ' WHERE seasonid='.$SEASON;
  $select .= ' AND registrationId IN ('.$subQuery.')';
  $select .= ' AND playerId IN ('.$subQuery2.')';
  $select .= ' AND eMail IS NOT NULL';
  $select .= ' AND eMail != ""';
  $select .= ' GROUP BY eMail';
  
  return emails($select);		
}

/*
 * Get All Site Registered User Addresses
 */
function get_all_registered_user_addresses() {
  global $SEASON;
  
  $select = 'SELECT eMail FROM '.USER;
  $select .= ' WHERE accessLevel > 0';
  $select .= ' GROUP BY eMail';
  
  return emails($select);			
}

/*
 * Returns email address string and takes a select as an argument
 */
function emails($select = "") {
	global $Link;
	
        $emailArray = array();

	$addressResult = mysql_query($select, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	$emailAddresses = '';
	
	if ($addressResult && mysql_num_rows($addressResult) > 0) {            
			while ($person = mysql_fetch_array($addressResult, MYSQL_ASSOC)) {
				if(strlen($person['eMail']) > 0) {
				  $emailArray[] = $person['eMail'];
				}
			}
		}
		
	return $emailArray;	
}


/*
 * Send email
 */
function email_message($emailAddresses = "", $subject = "", $message = "") {
	// Note these emails need to be Blind Carbon Coby
	$from = TCSHL_EMAIL;
	$replyTo = $_SESSION['email'];
	//$headers = "From: ".$from. "\r\n";
	//$headers .= "Reply-To: ".$replyTo. "\r\n";
	//$headers .= "Bcc: ".$emailAddresses. "\r\n";
	//$headers .= "X-Mailer: PHP/".phpversion();
		
	$headers = 'From: '.$from. "\r\n".
	    'Reply-To: '.$replyTo. "\r\n".
	    'Bcc: '.$emailAddresses. "\r\n".
	    'Return-Path: '.$from. "\r\n".
	    'X-Mailer: PHP/'.phpversion();

	//Send email
	$emailSent = mail('', $subject, $message, $headers);

 	// If email does not send, need to send webmaster an email so he can debug it.
        if(!$emailSent || get_site_variable_value("DEBUG_EMAIL") == 1) {
          $debugSubject = "EmailManager tcshl.com - debug info";
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

          // Send mail to webmaster
	  mail(WEBMASTER_EMAIL, $debugSubject, $debugMessage, $debugHeaders);
        }
 } 
?>
