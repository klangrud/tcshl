<?php
/*
 * Created on Aug 31, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
// Page requirements
define('LOGIN_REQUIRED', false);
define('PAGE_ACCESS_LEVEL', 0);
define('PAGE_TYPE', 'PUBLIC');

// Set for every page
require ('engine/common.php');


if(isset($_POST['action']) && $_POST['action'] == 'Send Message') {
	  // Pass recaptcha
      // Setup recaptcha response object
	  $resp = recaptcha_check_answer (RECAPTCHA_PRIVATE_KEY,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);	  
	  if (!$resp->is_valid) {
	    // What happens when the CAPTCHA was entered incorrectly
	    $errors = array();
	    $errors[] = "The reCAPTCHA wasn't entered correctly.  Go back and try it again.  (reCAPTCHA said: " . $resp->error . ")";
	    handle_errors($errors);
	  } else {
	  	// Recaptcha successful, now onto the rest of the form.		
		// If form does not validate, we need to return with errors.
		if ($errors = validate_contact_form()) {
			handle_errors($errors);
		} else {
			// If errors occur while trying to create user, we need to return with errors.
			if ($errors = process_contact_form()) {
				handle_errors($errors);
			} else {
				$success = array();
				$success[] = 'Your message was sent successfully!';
				handle_success($success);
			}		
		}
	  }
}


$smarty->assign('page_name', 'Contact TCSHL');
$smarty->assign('recaptcha_html', recaptcha_get_html(RECAPTCHA_PUBLIC_KEY));

setup_boardmembers();

// Build the page
require ('global_begin.php');
$smarty->display('public/contact.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/ 

function validate_contact_form() {
	$errors = array();
	
	if(isset($_POST['msg']) && strlen($_POST['msg']) > 0) {
		//Do nothing
	} else {
		$errors[] = 'No message was entered!';
	}
	
	return $errors;
}


function process_contact_form() {
	global $smarty;
	
	  $emailAddress = '';
	  $emailSubject = 'Message from TCSHL.COM to ';
	  if($_POST['to'] == 'lbm')	{
	  	$emailAddress = BOARD_EMAIL;
	  	$emailSubject .= 'Board Members';
	  } else if($_POST['to'] == 'lps') {
	  	$emailAddress = PAYMENT_EMAIL;
	  	$emailSubject .= 'Payment Manager';
	  } else if($_POST['to'] == 'lrm') {
	  	$emailAddress = REF_EMAIL;
	  	$emailSubject .= 'Referee Manager';
	  } else if($_POST['to'] == 'lrg') {
	  	$emailAddress = REG_EMAIL;
	  	$emailSubject .= 'Registration Manager';
	  } else if($_POST['to'] == 'lsm') {
	  	$emailAddress = STATS_EMAIL;
	  	$emailSubject .= 'Stats Manager';
	  } else if($_POST['to'] == 'ltr') {
	  	$emailAddress = REP_EMAIL;
	  	$emailSubject .= 'Team Reps';
	  } else if($_POST['to'] == 'tsr') {
	  	$emailAddress = SITEREG_EMAIL;
	  	$emailSubject .= 'Site Registration Manager';
	  } else {
	  	$emailAddress = ADMIN_EMAIL;
	  	$emailSubject .= 'Administrator';
	  }
	  
	  $emailMessage = $_POST['msg'];
	  
	  if(isset($_POST['nme']) && strlen($_POST['nme']) > 0) {
	  	$emailMessage .= ' - '.$_POST['nme'];
	  }
	  
	  if(isset($_POST['eml']) && strlen($_POST['eml']) > 0) {
	  	$emailMessage .= ' - '.$_POST['eml'];
	  }
	  
	  if(isset($_POST['phn']) && strlen($_POST['phn']) > 0) {
	  	$emailMessage .= ' ('.$_POST['phn'].')';
	  }	  
	  
	  email_contact_page_message($emailAddress,$emailSubject,$emailMessage);
}

/*
 * Send email
 */
function email_contact_page_message($emailAddress = "", $emailSubject = "", $emailBody = "") {
	require_once('com/tcshl/mail/Mail.php');

	//$sender,$recipients,$subject,$body
	$Mail = new Mail(TCSHL_EMAIL,$emailAddress,$emailSubject,$emailBody);
	$Mail->sendMail();	
 }
 
/*
 * Setup Board Members
 */
function setup_boardmembers() {
	global $smarty;
	
	require_once('com/tcshl/board/BoardMember.php');
	require_once('com/tcshl/board/BoardMembers.php');
	
	// Build list of board members
	$BoardMembers = new BoardMembers();
	$BoardMembersArray = $BoardMembers->get_BoardMemberArray(0);
	
	if(count($BoardMembersArray) > 0) {
		$boardMemberCount=0;
		$smarty->assign('boardMemberID', array ());
		$smarty->assign('boardMemberName', array ());	
		$smarty->assign('boardMemberFirstName', array ());
		$smarty->assign('boardMemberLastName', array ());	
		$smarty->assign('boardMemberEmail', array ());
		$smarty->assign('boardMemberHomePhone', array ());
		$smarty->assign('boardMemberWorkPhone', array ());
		$smarty->assign('boardMemberCellPhone', array ());
		$smarty->assign('boardMemberDuties', array ());     
		foreach($BoardMembersArray as $BoardMember) {				
			$boardMemberCount++;
			$smarty->append('boardMemberID', $BoardMember->get_boardMemberID());
			$smarty->append('boardMemberName', $BoardMember->get_boardMemberFirstName().' '.$BoardMember->get_boardMemberLastName());
			$smarty->append('boardMemberFirstName', $BoardMember->get_boardMemberFirstName());
			$smarty->append('boardMemberLastName', $BoardMember->get_boardMemberLastName());	
			$smarty->append('boardMemberEmail', strToHex($BoardMember->get_boardMemberEmail()));				
			$smarty->append('boardMemberHomePhone', $BoardMember->get_boardMemberHomePhone());
			$smarty->append('boardMemberWorkPhone', $BoardMember->get_boardMemberWorkPhone());
			$smarty->append('boardMemberCellPhone', $BoardMember->get_boardMemberCellPhone());
			$smarty->append('boardMemberDuties', $BoardMember->get_boardMemberDuties());
		}
		$smarty->assign('boardMemberCount', $boardMemberCount);
	}	
} 
?>
