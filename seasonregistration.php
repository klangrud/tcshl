<?php

/*
 * Created on Aug 23, 2007
 *
*/

// Page requirements
define('LOGIN_REQUIRED', false);
define('PAGE_ACCESS_LEVEL', 0);
define('PAGE_TYPE', 'PUBLIC');

// Set for every page
require ('engine/common.php');

$smarty->assign('page_name', get_season_name($SEASON).' Season Registration');
$smarty->assign('registrationPage', 'TRUE');
$smarty->assign('ns', 'CHECKED'); // Will sub = no
$smarty->assign('nt', 'CHECKED'); // No Team Rep
$smarty->assign('nr', 'CHECKED'); // Will not ref
$smarty->assign('p1', 'CHECKED'); // Payment Plan 1
$smarty->assign('OPEN_REGISTRATION', get_site_variable_value("REGISTRATION"));


if ((isset ($_POST['action'])) && ($_POST['action'] == "Register")) {
	// If form does not validate, we need to return with errors.
	if ($errors = validate_seasonregistration_form()) {
		handle_errors($errors);
		handle_reposts();
	} else {
		// If errors occur while trying to create user, we need to return with errors.
		if ($errors = process_seasonregistration_form($smarty)) {
			handle_errors($errors);
			handle_reposts();
		} else {
			header("Location: seasonregistrationok.php");
		}		
	}
} else {
  $smarty->assign('jsxl', 'CHECKED'); // Jersey Size XL
  $smarty->assign('sl3', 'CHECKED'); // Skill Level Intermediate
  $smarty->assign('dl1', 'CHECKED'); // D.R.I.L. - Only TCSHL
}

// Build the page
require ('global_begin.php');
$smarty->display('public/seasonregistration.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/

/*
 * Handle reposts.. it is a long form to have to fill out again, plus much can be overlooked.
 */
function handle_reposts() {
	global $smarty;
	$fn = "";
	$ln = "";
	$a1 = "";
	$a2 = "";	
	$cy = "";
	$state = "";
	$pc = "";	
	$em = "";	
	$hp = "";
	$wp = "";	
	$cp = "";
	$gl = "";
	$df = "";	
	$cr = "";	
	$wg = "";	
  $jsl = "";
  $jsxl = "";
  $jsxxl = "";
  $jsgoalie = "";
	$j1 = "";	
	$j2 = "";
	$j3 = "";
  $sl1 = "";
  $sl2 = "";
  $sl3 = "";
  $sl4 = "";
  $sl5 = "";	
	$tw = "";	
	$an = "";
	$su = "";	
	$sm = "";
	$st = "";	
	$sw = "";
	$sh = "";
	$sf = "";	
	$ss = "";
  $dl1 = "";
  $dl2 = "";
  $dl3 = "";  


	if ($_POST) {
		if (isset($_POST['firstname']) && $_POST['firstname']) {
			$fn = format_uppercase_text($_POST['firstname']);
		}
		if (isset($_POST['lastname']) && $_POST['lastname']) {
			$ln = format_uppercase_text($_POST['lastname']);
		}
		if (isset($_POST['addressOne']) && $_POST['addressOne']) {
			$a1 = $_POST['addressOne'];
		}
		if (isset($_POST['addressTwo']) && $_POST['addressTwo']) {
			$a2 = $_POST['addressTwo'];
		}
		if (isset($_POST['city']) && $_POST['city']) {
			$cy = format_uppercase_text($_POST['city']);
		}
		if (isset($_POST['state']) && $_POST['state']) {
			$state = format_uppercase_text($_POST['state']);
		}
		if (isset($_POST['postalCode']) && $_POST['postalCode']) {
			$pc = format_uppercase_text($_POST['postalCode']);
		}
		if (isset($_POST['email']) && $_POST['email']) {
			$em = format_trim(strtolower($_POST['email']));
		}
		if (isset($_POST['homePhone']) && $_POST['homePhone']) {
			$hp = $_POST['homePhone'];
		}
		if (isset($_POST['workPhone']) && $_POST['workPhone']) {
			$wp = $_POST['workPhone'];
		}
		if (isset($_POST['cellPhone']) && $_POST['cellPhone']) {
			$cp = $_POST['cellPhone'];
		}
		if (isset($_POST['goalie']) && $_POST['goalie'] == "on") {
			$gl = 'checked="checked"';
		}
		if (isset($_POST['defense']) && $_POST['defense'] == "on") {
			$df = 'checked="checked"';
		}
		if (isset($_POST['center']) && $_POST['center'] == "on") {
			$cr = 'checked="checked"';
		}
		if (isset($_POST['wing']) && $_POST['wing'] == "on") {
			$wg = 'checked="checked"';
		}
		if (isset($_POST['jerseySize']) && $_POST['jerseySize'] == "L") {
			$jsl = "CHECKED";
		} else if (isset($_POST['jerseySize']) && $_POST['jerseySize'] == "XL") {
			$jsxl = "CHECKED";
		} else if (isset($_POST['jerseySize']) && $_POST['jerseySize'] == "XXL") {
			$jsxxl = "CHECKED";
		} else if (isset($_POST['jerseySize']) && $_POST['jerseySize'] == "GOALIE") {
			$jsgoalie = "CHECKED";
		} else { 
			$jsxl = "CHECKED";
		}
		if ((isset($_POST['jerseyNumChoiceOne']) && $_POST['jerseyNumChoiceOne']) || $_POST['jerseyNumChoiceOne'] == 0) {
			$j1 = $_POST['jerseyNumChoiceOne'];
		}
		if ((isset($_POST['jerseyNumChoiceTwo']) && $_POST['jerseyNumChoiceTwo']) || $_POST['jerseyNumChoiceTwo'] == 0) {
			$j2 = $_POST['jerseyNumChoiceTwo'];
		}
		if ((isset($_POST['jerseyNumChoiceThree']) && $_POST['jerseyNumChoiceThree']) || $_POST['jerseyNumChoiceThree'] == 0) {
			$j3 = $_POST['jerseyNumChoiceThree'];
		}
		if (isset($_POST['skillLevel']) && $_POST['skillLevel'] == "1") {
			$sl1 = "CHECKED";
		} else if (isset($_POST['skillLevel']) && $_POST['skillLevel'] == "2") {
			$sl2 = "CHECKED";
		} else if (isset($_POST['skillLevel']) && $_POST['skillLevel'] == "3") {
			$sl3 = "CHECKED";
		} else if (isset($_POST['skillLevel']) && $_POST['skillLevel'] == "4") {
			$sl4 = "CHECKED";
		} else if (isset($_POST['skillLevel']) && $_POST['skillLevel'] == "5") {
			$sl5 = "CHECKED";		
		} else { 
			$sl3 = "CHECKED";
		}		
		if (isset($_POST['travelWith']) && $_POST['travelWith']) {
			$tw = $_POST['travelWith'];
		}
		if (isset($_POST['additionalNotes']) && $_POST['additionalNotes']) {
			$an = $_POST['additionalNotes'];
		}
		if (isset($_POST['willSub']) && $_POST['willSub'] == "Y") {
			$smarty->assign('ys', 'CHECKED'); // Will sub = yes
			$smarty->assign('ns', ''); // Will sub = no
			if (isset($_POST['sunSub']) && $_POST['sunSub'] == "on") {
				$su = 'checked="checked"';
			}
			if (isset($_POST['monSub']) && $_POST['monSub'] == "on") {
				$sm = 'checked="checked"';
			}
			if (isset($_POST['tueSub']) && $_POST['tueSub'] == "on") {
				$st = 'checked="checked"';
			}
			if (isset($_POST['wedSub']) && $_POST['wedSub'] == "on") {
				$sw = 'checked="checked"';
			}
			if (isset($_POST['thuSub']) && $_POST['thuSub'] == "on") {
				$sh = 'checked="checked"';
			}
			if (isset($_POST['friSub']) && $_POST['friSub'] == "on") {
				$sf = 'checked="checked"';
			}
			if (isset($_POST['satSub']) && $_POST['satSub'] == "on") {
				$ss = 'checked="checked"';
			}			
		}
	    if (isset($_POST['teamRep']) && $_POST['teamRep'] == "Y") {
			$smarty->assign('yr', 'CHECKED'); // Will be a team rep
			$smarty->assign('nt', ''); // Will not be a team rep
	    }
	    if (isset($_POST['referee']) && $_POST['referee'] == "Y") {
			$smarty->assign('wr', 'CHECKED'); // Will referee
			$smarty->assign('nr', ''); // Will not referee
	    }
	    if (isset($_POST['paymentPlan']) && $_POST['paymentPlan'] == "2") {
			$smarty->assign('p2', 'CHECKED'); // Payment Plan II
			$smarty->assign('p1', ''); // Payment Plan I
			$smarty->assign('p3', ''); // Payment Plan III
			$smarty->assign('p4', ''); // Payment Plan IV
	    } else if (isset($_POST['paymentPlan']) && $_POST['paymentPlan'] == "3") {
	   		$smarty->assign('p3', 'CHECKED'); // Payment Plan III
			$smarty->assign('p1', ''); // Payment Plan I
			$smarty->assign('p2', ''); // Payment Plan II
			$smarty->assign('p4', ''); // Payment Plan IV			
	    } else if (isset($_POST['paymentPlan']) && $_POST['paymentPlan'] == "4") {
	   		$smarty->assign('p4', 'CHECKED'); // Payment Plan IV
			$smarty->assign('p1', ''); // Payment Plan I
			$smarty->assign('p2', ''); // Payment Plan II
			$smarty->assign('p3', ''); // Payment Plan III			
	    }
	    
		if (isset($_POST['drilLeague']) && $_POST['drilLeague'] == "1") {
			$dl1 = "CHECKED";
		} else if (isset($_POST['drilLeague']) && $_POST['drilLeague'] == "2") {
			$dl2 = "CHECKED";
		} else if (isset($_POST['drilLeague']) && $_POST['drilLeague'] == "3") {
			$dl3 = "CHECKED";
		} else { 
			$dl1 = "CHECKED";
		}		    
	    
	}
	
	$smarty->assign('fn', $fn);
	$smarty->assign('ln', $ln);
	$smarty->assign('a1', $a1);
	$smarty->assign('a2', $a2);	
	$smarty->assign('cy', $cy);
	$smarty->assign('state', $state);
	$smarty->assign('pc', $pc);	
	$smarty->assign('em', $em);	
	$smarty->assign('hp', $hp);
	$smarty->assign('wp', $wp);	
	$smarty->assign('cp', $cp);
	$smarty->assign('gl', $gl);
	$smarty->assign('df', $df);	
	$smarty->assign('cr', $cr);	
	$smarty->assign('wg', $wg);	
  $smarty->assign('jsl', $jsl);
  $smarty->assign('jsxl', $jsxl);
  $smarty->assign('jsxxl', $jsxxl);
  $smarty->assign('jsgoalie', $jsgoalie);
	$smarty->assign('j1', $j1);	
	$smarty->assign('j2', $j2);
	$smarty->assign('j3', $j3);
  $smarty->assign('sl1', $sl1);
  $smarty->assign('sl2', $sl2);
  $smarty->assign('sl3', $sl3);
  $smarty->assign('sl4', $sl4);
  $smarty->assign('sl5', $sl5);	
	$smarty->assign('tw', $tw);	
	$smarty->assign('an', $an);	
	$smarty->assign('su', $su);	
	$smarty->assign('sm', $sm);
	$smarty->assign('st', $st);	
	$smarty->assign('sw', $sw);
	$smarty->assign('sh', $sh);
	$smarty->assign('sf', $sf);	
	$smarty->assign('ss', $ss);	
  $smarty->assign('dl1', $dl1);
  $smarty->assign('dl2', $dl2);
  $smarty->assign('dl3', $dl3);  
	
}

/*
 * Validate this information being provided .. just expect the worse sometimes
 */
function validate_seasonregistration_form() {
	$errors = array ();
	
#Firstname Validation
	if (isset($_POST['firstname']) && $_POST['firstname']) {
		if (strlen($_POST['firstname']) < 2) {
			$errors[] = "First name must be at least 2 characters long.";
		}
		if (!valid_text($_POST['firstname'])) {
			$errors[] = "First name contains invalid characters. Check for quotes.";
		}
	} else {
		$errors[] = "First name is a required field";
	}

#Lastname Validation
	if (isset($_POST['lastname']) && $_POST['lastname']) {
		if (strlen($_POST['lastname']) < 2) {
			$errors[] = "Last name must be at least 2 characters long.";
		}
		if (!valid_text($_POST['lastname'])) {
			$errors[] = "Last name contains invalid characters. Check for quotes.";
		}
	} else {
		$errors[] = "Last name is a required field";
	}

#Address One Validation
	if (isset($_POST['addressOne']) && $_POST['addressOne']) {
		//Do nothing  .. Not doing any AVS checks, so hopefully they give us a good address
	} else {
		$errors[] = "Address Field One is required";
	}

#City Validation
	if (isset($_POST['city']) && $_POST['city']) {
		//Do nothing  .. Not doing any AVS checks, so hopefully they give us a good city
	} else {
		$errors[] = "City is required";
	}

#State Validation
	if (isset($_POST['state']) && $_POST['state']) {
		//Do nothing  .. Not doing any AVS checks, so hopefully they give us a good state
	} else {
		$errors[] = "State is required";
	}
	
#Postal Code Validation
	if (isset($_POST['postalCode']) && $_POST['postalCode']) {
		//Do nothing  .. Not doing any AVS checks, so hopefully they give us a good zip
	} else {
		$errors[] = "Zipcode is required";
	}
	
#Email Validation
	if (isset($_POST['email']) && $_POST['email']) {
		if (validate_email(format_trim($_POST['email']))) {
			//Do nothing .. its a valid email, i guess
		} else {
			$errors[] = "Email is not valid.";
		}
	}

#Position Validation
	if ((isset($_POST['goalie']) && $_POST['goalie'] == "on")
	 || (isset($_POST['defense']) && $_POST['defense'] == "on")
	 || (isset($_POST['center']) && $_POST['center'] == "on")
	 || (isset($_POST['wing']) && $_POST['wing'] == "on")) {
		//Do nothing .. At least one position is checked
	} else {
		$errors[] = "Must provide at least one position you would like to play. (Goalie, Defense, Center, Wing)";
	}

#Jersey Information Validation
	#Jersey Choice 1 Validation
	//(isset($_POST['jerseyNumChoiceTwo']) && $_POST['jerseyNumChoiceTwo']) || $_POST['jerseyNumChoiceTwo'] == 0
	if ((isset($_POST['jerseyNumChoiceOne']) && $_POST['jerseyNumChoiceOne'] > -1) || $_POST['jerseyNumChoiceOne'] == 0) {
		//if (is_numeric($_POST['jerseyNumChoiceOne']) && is_int(intval($_POST['jerseyNumChoiceOne']))) {
			if (strlen($_POST['jerseyNumChoiceOne']) == strlen(intval($_POST['jerseyNumChoiceOne']))) {
			if(intval($_POST['jerseyNumChoiceOne']) < 0 || intval($_POST['jerseyNumChoiceOne']) > 99) {
				$errors[] = "Jersey Number Choice 1 must be between 0 - 99.";				
			}
		} else {
			$errors[] = "Must provide a valid jersey number for Choice 1. (0 - 99)";
		}		
	} else {
		$errors[] = "Must provide a valid jersey number for Choice 1. (0 - 99)";
	}
	
	#Jersey Choice 2 Validation
	if ((isset($_POST['jerseyNumChoiceTwo']) && $_POST['jerseyNumChoiceTwo'] > -1) || $_POST['jerseyNumChoiceTwo'] == 0) {
		if (strlen($_POST['jerseyNumChoiceTwo']) == strlen(intval($_POST['jerseyNumChoiceTwo']))) {
			if(intval($_POST['jerseyNumChoiceTwo']) < 0 || intval($_POST['jerseyNumChoiceTwo']) > 99) {
				$errors[] = "Jersey Number Choice 2 must be between 0 - 99.";				
			}
		} else {
			$errors[] = "Must provide a valid jersey number for Choice 2. (0 - 99)";
		}
	} else {
		$errors[] = "Must provide a valid jersey number for Choice 2. (0 - 99)";
	}
	
	#Jersey Choice 3 Validation
	if ((isset($_POST['jerseyNumChoiceThree']) && $_POST['jerseyNumChoiceThree'] > -1) || $_POST['jerseyNumChoiceThree'] == 0) {
		if (strlen($_POST['jerseyNumChoiceThree']) == strlen(intval($_POST['jerseyNumChoiceThree']))) {
			if(intval($_POST['jerseyNumChoiceThree']) < 0 || intval($_POST['jerseyNumChoiceThree']) > 99) {
				$errors[] = "Jersey Number Choice 3 must be between 0 - 99.";				
			}
		} else {
			$errors[] = "Must provide a valid jersey number for Choice 3. (0 - 99)";
		}
	} else {
		$errors[] = "Must provide a valid jersey number for Choice 3. (0 - 99)";
	}
	
	
#Will Sub? Validation
	if (isset($_POST['willSub']) && $_POST['willSub'] == "Y") {
		if ((isset($_POST['sunSub']) && $_POST['sunSub'] == "on")
		|| (isset($_POST['monSub']) && $_POST['monSub'] == "on")
		|| (isset($_POST['tueSub']) && $_POST['tueSub'] == "on")
		|| (isset($_POST['wedSub']) && $_POST['wedSub'] == "on")
		|| (isset($_POST['thuSub']) && $_POST['thuSub'] == "on")
		|| (isset($_POST['friSub']) && $_POST['friSub'] == "on")
		|| (isset($_POST['satSub']) && $_POST['satSub'] == "on")) {
			//Do nothing, they picked a day that they can sub
		} else {
			$errors[] = "Since you answered yes to: Will you sub?, you must indicate at least one day you are willing to sub.";
		}
	} else {
		//Do nothing .. they indicated "NO" for Will they sub?
	}

#Return Errors
return $errors;
}

/*
 * Process Form Data
 */

function process_seasonregistration_form($smarty) {
	global $SEASON;
	
	include ('database_connect.php');

	$errors = array();

		$playerid = 0;
		
		if (isset($_POST['firstname']) && $_POST['firstname']) {
			$fname = format_uppercase_text($_POST['firstname']);
		} // Required
		if (isset($_POST['lastname']) && $_POST['lastname']) {
			$lname = format_uppercase_text($_POST['lastname']);
		} // Required
		if (isset($_POST['addressOne']) && $_POST['addressOne']) {
			$addy1 = format_text($_POST['addressOne']);
		} // Required
		if (isset($_POST['addressTwo']) && $_POST['addressTwo']) {
			$addy2 = format_text($_POST['addressTwo']);
		} else {
			$addy2 = "";
		}
		if (isset($_POST['city']) && $_POST['city']) {
			$city = format_uppercase_text($_POST['city']);
		} //Required
		if (isset($_POST['state']) && $_POST['state']) {
			$state = format_text($_POST['state']);
		} //Required
		if (isset($_POST['postalCode']) && $_POST['postalCode']) {
			$postalcode = format_text($_POST['postalCode']);
		} //Required
		if (isset($_POST['email']) && $_POST['email']) {
			$email = format_text(strtolower($_POST['email']));
		} else {
			$email = "";
		}
		if (isset($_POST['homePhone']) && $_POST['homePhone']) {
			$homephone = format_text($_POST['homePhone']);
		} else {
			$homephone = "";
		}
		if (isset($_POST['workPhone']) && $_POST['workPhone']) {
			$workphone = format_text($_POST['workPhone']);
		} else {
			$workphone = "";
		}
		if (isset($_POST['cellPhone']) && $_POST['cellPhone']) {
			$cellphone = format_text($_POST['cellPhone']);
		} else {
			$cellphone = "";
		}
		if (isset($_POST['goalie']) && $_POST['goalie'] == "on") {
			$goalie = "Y";
		} else {
			$goalie = "N";
		}
		if (isset($_POST['defense']) && $_POST['defense'] == "on") {
			$defense = "Y";
		} else {
			$defense = "N";
		}
		if (isset($_POST['center']) && $_POST['center'] == "on") {
			$center = "Y";
		} else {
			$center = "N";
		}
		if (isset($_POST['wing']) && $_POST['wing'] == "on") {
			$wing = "Y";
		} else {
			$wing = "N";
		}
		if (isset($_POST['jerseySize']) && $_POST['jerseySize']) {
			$jerseysize = $_POST['jerseySize'];
		} //Required		
		if ((isset($_POST['jerseyNumChoiceOne']) && $_POST['jerseyNumChoiceOne']) || $_POST['jerseyNumChoiceOne'] == 0) {
			$jersey1 = $_POST['jerseyNumChoiceOne'];
		} //Required
		if ((isset($_POST['jerseyNumChoiceTwo']) && $_POST['jerseyNumChoiceTwo']) || $_POST['jerseyNumChoiceTwo'] == 0) {
			$jersey2 = $_POST['jerseyNumChoiceTwo'];
		} //Required
		if ((isset($_POST['jerseyNumChoiceThree']) && $_POST['jerseyNumChoiceThree']) || $_POST['jerseyNumChoiceThree'] == 0) {
			$jersey3 = $_POST['jerseyNumChoiceThree'];
		} //Required
		if (isset($_POST['travelWith']) && $_POST['travelWith']) {
			$travelwith = format_text($_POST['travelWith']);
		} else {
			$travelwith = "";
		}
		if (isset($_POST['additionalNotes']) && $_POST['additionalNotes']) {
			$additionalnotes = format_text($_POST['additionalNotes']);
		} else {
			$additionalnotes = "";
		}
	  if (isset($_POST['skillLevel']) && $_POST['skillLevel']) {
			$skilllevel = $_POST['skillLevel'];
		}//Required		
		if (isset($_POST['willSub']) && $_POST['willSub'] == "Y") {
			$willSub = 1;			
			if (isset($_POST['sunSub']) && $_POST['sunSub'] == "on") {
				$sunSub = 1;
			} else {
				$sunSub = 0;
			}
			if (isset($_POST['monSub']) && $_POST['monSub'] == "on") {
				$monSub = 1;
			} else {
				$monSub = 0;
			}
			if (isset($_POST['tueSub']) && $_POST['tueSub'] == "on") {
				$tueSub = 1;
			} else {
				$tueSub = 0;
			}
			if (isset($_POST['wedSub']) && $_POST['wedSub'] == "on") {
				$wedSub = 1;
			} else {
				$wedSub = 0;
			}
			if (isset($_POST['thuSub']) && $_POST['thuSub'] == "on") {
				$thuSub = 1;
			} else {
				$thuSub = 0;
			}
			if (isset($_POST['friSub']) && $_POST['friSub'] == "on") {
				$friSub = 1;
			} else {
				$friSub = 0;
			}
			if (isset($_POST['satSub']) && $_POST['satSub'] == "on") {
				$satSub = 1;
			} else {
				$satSub = 0;
			}			
		} else {
			$willSub = 0;
			$sunSub = 0;
			$monSub = 0;
			$tueSub = 0;
			$wedSub = 0;
			$thuSub = 0;
			$friSub = 0;
			$satSub = 0;
		}	
	  if (isset($_POST['teamRep']) && $_POST['teamRep'] == "Y") {
			$teamrep = 1;
		} else {
			$teamrep = 0;
		}	
	  if (isset($_POST['referee']) && $_POST['referee'] == "Y") {
			$willref = 1;
		} else {
			$willref = 0;
		}	
    if (isset($_POST['paymentPlan']) && $_POST['paymentPlan'] == "1") {
			$payment = 1;
    } else if (isset($_POST['paymentPlan']) && $_POST['paymentPlan'] == "2") {
			$payment = 2;		
    } else if (isset($_POST['paymentPlan']) && $_POST['paymentPlan'] == "3") {
			$payment = 3;	
    } else if (isset($_POST['paymentPlan']) && $_POST['paymentPlan'] == "4") {
			$payment = 4;	
    }

		#Setup the positions comma separated value
		$positions = "";		
		if($goalie == "Y") {
			if($defense == "Y" || $center == "Y" || $wing == "Y") {
				$positions .= "G, ";
			} else {
				$positions .= "G";
			}
		}
		if($defense == "Y") {
			if($center == "Y" || $wing == "Y") {
				$positions .= "D, ";
			} else {
				$positions .= "D";
			}
		}
		if($center == "Y") {
			if($wing == "Y") {
				$positions .= "C, ";
			} else {
				$positions .= "C";
			}
		}
		if($wing == "Y") {
			$positions .= "W";
		}
		
	  if (isset($_POST['drilLeague']) && $_POST['drilLeague']) {
			$drilLeague = $_POST['drilLeague'];
		}//Required			

$registrationColumns = '`seasonId`,`fName`,`lName`,`addressOne`,`addressTwo`,`city`,`state`,`postalCode`,`';
$registrationColumns .= 'eMail`,`position`,`jerseySize`,`jerseyNumberOne`,`jerseyNumberTwo`,`jerseyNumberThree`,`';
$registrationColumns .= 'homePhone`,`workPhone`,`cellPhone`,`skillLevel`,`wantToSub`,`subSunday`,`subMonday`,`subTuesday`,`';
$registrationColumns .= 'subWednesday`,`subThursday`,`subFriday`,`subSaturday`,`travelingWithWho`,`wantToBeATeamRep`,`';
$registrationColumns .= 'wantToBeARef`,`paymentPlan`,`notes`,`drilLeague`';

$registrationInsert = 'INSERT INTO '.REGISTRATION.' ('.$registrationColumns.') ';
$registrationInsert .= 'VALUES('.$SEASON.',';
$registrationInsert .= '"'.$fname.'",';
$registrationInsert .= '"'.$lname.'",';
$registrationInsert .= '"'.$addy1.'",';
$registrationInsert .= '"'.$addy2.'",';
$registrationInsert .= '"'.$city.'",';
$registrationInsert .= '"'.$state.'",';
$registrationInsert .= '"'.$postalcode.'",';
$registrationInsert .= '"'.$email.'",';
$registrationInsert .= '"'.$positions.'",';
$registrationInsert .= '"'.$jerseysize.'",';
$registrationInsert .= ''.$jersey1.',';
$registrationInsert .= ''.$jersey2.',';
$registrationInsert .= ''.$jersey3.',';
$registrationInsert .= '"'.$homephone.'",';
$registrationInsert .= '"'.$workphone.'",';
$registrationInsert .= '"'.$cellphone.'",';
$registrationInsert .= ''.$skilllevel.',';
$registrationInsert .= ''.$willSub.',';
$registrationInsert .= ''.$sunSub.',';
$registrationInsert .= ''.$monSub.',';
$registrationInsert .= ''.$tueSub.',';
$registrationInsert .= ''.$wedSub.',';
$registrationInsert .= ''.$thuSub.',';
$registrationInsert .= ''.$friSub.',';
$registrationInsert .= ''.$satSub.',';
$registrationInsert .= '"'.$travelwith.'",';
$registrationInsert .= ''.$teamrep.',';
$registrationInsert .= ''.$willref.',';
$registrationInsert .= ''.$payment.',';
$registrationInsert .= '"'.$additionalnotes.'",';
$registrationInsert .= ''.$drilLeague.'';
$registrationInsert .= ')';

$result = mysql_query($registrationInsert, $Link)
  or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());

//Notify league that there is a new league registration.
send_admin_email();

	
	return $errors;
} // End of function


 /*
 * Send Admin Email - For Season Registration
 */
 
 function send_admin_email() {	
 	$emailAddress = REG_EMAIL;
 	
 	$VerificationLink = DOMAIN_NAME.'/manageregistrations.php';
 	
 	$fn = format_uppercase_text($_POST['firstname']);
	$ln = format_uppercase_text($_POST['lastname']);
 	
 	$emailBody = $fn.' '.$ln.' has just registered for TCSHL league membership.  Click on the following link to approve registration: ';
 	$emailBody .= $VerificationLink;
 	
	$headers = 'From: '.VERIFICATION_EMAIL_SENDER;
 	
	//Send email
	mail($emailAddress, VERIFICATION_EMAIL_SUBJECT, $emailBody, $headers);
 }
?>