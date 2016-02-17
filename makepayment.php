<?php
/*
 * Created on Aug 5, 2011
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
// Page requirements
define('LOGIN_REQUIRED', false);
define('PAGE_ACCESS_LEVEL', 0);
define('PAGE_TYPE', 'USER');

// Set for every page
require ('engine/common.php');

$firstname = "";
$lastname = "";

if ((isset ($_POST['action'])) && ($_POST['action'] == "Find Registration")) {

	if($_POST && $_POST['firstname']) {
	    $firstname = $_POST['firstname'];
		$smarty->assign('firstname', $firstname);
	}
	if($_POST && $_POST['lastname']) {
	    $lastname = $_POST['lastname'];
		$smarty->assign('lastname', $lastname);
	}

	setup_registrations();	
}


$smarty->assign('page_name', 'Make Payment');
// Build the page
require ('global_begin.php');
$smarty->display('public/makepayment.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/

function setup_registrations() {
	global $smarty;
	global $SEASON;
	global $firstname;
	global $lastname;
	
	global $Link;
	

	$selectColumns = 'registrationId,fName,lName,addressOne,addressTwo,city,state,postalCode';
	
	// Select base query
	$select = 'SELECT '.$selectColumns.' FROM '.REGISTRATION.' WHERE seasonId='.$SEASON;
	

	// Select filter firstname
	if($firstname != '') {
		$select .= ' AND fName LIKE \'%'.$firstname.'%\'';		
	}
	
	// Select filter lastname
	if($lastname != '') {
		$select .= ' AND lName LIKE \'%'.$lastname.'%\'';		
	}	

	// Select ORDER BY
	$select .= ' ORDER BY lName';
	

	$result = mysql_query($select, $Link)
  		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	if ($result && mysql_num_rows($result) > 0) {			
	  
	  $loopID = 0;
	  $smarty->assign('loopID', array ());
	  $smarty->assign('registrationId', array ());
	  $smarty->assign('name', array ());
	  $smarty->assign('addressOne', array ());
      $smarty->assign('addressTwo', array ());
      $smarty->assign('cityStateZip', array ());
            
			while ($registration = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$loopID++;
				$registrationId = $registration['registrationId'];
				$name = $registration['fName'].' '.$registration['lName'];
				$addressOne = $registration['addressOne'];
				if(isset($registration['addressTwo']) && strlen($registration['addressTwo']) > 0) {
				  $addressTwo = $registration['addressTwo'];
				} else {
					$addressTwo = '&nbsp;';
				}
				$cityStateZip = $registration['city'].' '.$registration['state'].' '.$registration['postalCode'];
				
				
				$smarty->append('loopID', $loopID);
				$smarty->append('registrationId', $registrationId);
				$smarty->append('name', $name);
				$smarty->append('addressOne', $addressOne);
				$smarty->append('addressTwo', $addressTwo);
				$smarty->append('cityStateZip', $cityStateZip);         

			}
		}
		
		// If we get one registration back, we nailed it.  Just forward to the payment page for that registration.

		if($loopID == 1) {
			header("Location: payment.php?registrationid=".$registrationId);
		}
	
} 

?>
