<?php
/*
 * Created on Aug 23, 2007
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

$Email = '';
$VerificationKey = '';

if(isset($_GET['email']) && isset($_GET['verificationKey'])) {
	$Email = $_GET['email'];
  $VerificationKey = $_GET['verificationKey'];
	$Verified = account_verifies();
	
	$smarty->assign('Verified', $Verified);
} else {
	$smarty->assign('Verified', false);
}

$smarty->assign('page_name', 'User Verification');

// Build the page
require ('global_begin.php');
$smarty->display('public/verification.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/

function account_verifies() {
	global $Email;
	global $VerificationKey;
	
	$Link = '';
	global $Link;
	
	// See if user verifies
	$Query = 'SELECT * FROM '.USER.' WHERE eMail="'.$Email.'" AND verificationKey="'.$VerificationKey.'"';
	$Result = mysql_query($Query, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
		
	if ($Result && mysql_num_rows($Result) > 0) {
		//If accessLevel is greater than zero, we will just return true on verified.  This way we do not reset a level 2 to a level 1.
		$entry = mysql_fetch_assoc($Result);
		if($entry['accessLevel'] > 0) {
			return true;
		}		
		
		//We get to this point if the accessLevel is not greater than 0.
		$Query = 'UPDATE '.USER.' SET accessLevel=1 WHERE eMail="'.$Email.'" AND verificationKey="'.$VerificationKey.'"';
		$Result = mysql_query($Query, $Link)
			or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($Result) {
    // TODO: Figure out why mysql_affected_rows throws a warning
		//if ($Result && mysql_affected_rows($Result) > 0) {
			
			return true;
		} else {
			
			return false;
		}
	} else {
		
		return false;
	}

}

?>
