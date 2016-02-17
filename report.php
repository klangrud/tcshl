<?php
/*
 * Created on Sep 3, 2008
 *
 * Report page.  This page takes a Season Arg and Report Arg.
 */
 
// Page requirements
define('LOGIN_REQUIRED', true);
define('PAGE_ACCESS_LEVEL', 2);
define('PAGE_TYPE', 'ADMIN');

// Set for every page
require ('engine/common.php');

$ZERO = 0;
$MAX = 8;

if(isset($_POST['report']) && $_POST['report'] > $ZERO && $_POST['report'] <= $MAX) {
	$REPORT = $_POST['report'];
} else if(isset($_GET['report']) && $_GET['report'] > $ZERO && $_GET['report'] <= $MAX) {
	$REPORT = $_GET['report'];
} else {
  header("Location: account.php");
}

// Initialize
$ADDRESS = false;
$EMAIL = false;
$HOMEPHONE = false;
$WORKPHONE = false;
$CELLPHONE = false;
$SKILLLEVEL = false;
$POSITION = false;
$JERSEYSIZE = false;
$JERSEYNUMBER1 = false;
$JERSEYNUMBER2 = false;
$JERSEYNUMBER3 = false;
$PAYMENTPLAN = false;
$DRILLEAGUE = false;
$USAHOCKEYMEMBERSHIP = false;

$SEASON_NAME = get_season_name($SEASON);
$REPORT_NAME = $SEASON_NAME;

initialize_db_columns();
$DB_COLUMNS = 'registrationId,'.get_columns().' fName, lName';
initialize_report();
run_report();

$smarty->assign('SEASON_ID', $SEASON);
$smarty->assign('SEASON_NAME', $SEASON_NAME);
$smarty->assign('PAGE_NAME', $REPORT_NAME);

// Build the page
require ('global_begin.php');
$smarty->display('admin/report.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/

function initialize_db_columns() {
	global $ADDRESS;
	global $EMAIL;
	global $HOMEPHONE;
	global $WORKPHONE;
	global $CELLPHONE;
	global $SKILLLEVEL;
	global $POSITION;
	global $JERSEYSIZE;
	global $JERSEYNUMBER1;
	global $JERSEYNUMBER2;
	global $JERSEYNUMBER3;
	global $PAYMENTPLAN;
	global $DRILLEAGUE;
	global $USAHOCKEYMEMBERSHIP;
	
	global $REPORT;
	
	if($REPORT == 1) {
		$JERSEYSIZE = true;
		$JERSEYNUMBER1 = true;
		$JERSEYNUMBER2 = true;
		$JERSEYNUMBER3 = true;		
	} else if($REPORT == 2) {
		// Filler, Do nothing
	} else if($REPORT == 3) {
		// Filler, Do nothing
	} else if($REPORT == 4) {
		$SKILLLEVEL = true;
	} else if($REPORT == 5) {
		$PAYMENTPLAN = true;
	} else if($REPORT == 6) {
		$ADDRESS = true;
		$EMAIL = true;
		$HOMEPHONE = true;
		$WORKPHONE = true;
		$CELLPHONE = true;		
	} else if($REPORT == 7) {
		$DRILLEAGUE = true;	
	} else if($REPORT == 8) {
		$USAHOCKEYMEMBERSHIP = true;
	}
	
}

function initialize_report() {
	global $REPORT;
	global $REPORT_NAME;
	
	if($REPORT == 1) {
		$REPORT_NAME .= ' Player Jersey Requests';	
	} else if($REPORT == 2) {
		$REPORT_NAME .= ' Team Rep Wannabe Report';
	} else if($REPORT == 3) {
		$REPORT_NAME .= ' Referee Wannabe Report';
	} else if($REPORT == 4) {
		$REPORT_NAME .= ' Player Skill Levels Report';
	} else if($REPORT == 5) {
		$REPORT_NAME .= ' Player Payment Plan Report';
	} else if($REPORT == 6) {
		$REPORT_NAME .= ' Player Contact Info';	
	} else if($REPORT == 7) {
		$REPORT_NAME .= ' Players Interested in D.R.I.L.';	
	} else if($REPORT == 8) {
		$REPORT_NAME .= ' USA Hockey Membership';
	}
	
}

function get_columns() {
	global $ADDRESS;
	global $EMAIL;
	global $HOMEPHONE;
	global $WORKPHONE;
	global $CELLPHONE;
	global $SKILLLEVEL;
	global $POSITION;
	global $JERSEYSIZE;
	global $JERSEYNUMBER1;
	global $JERSEYNUMBER2;
	global $JERSEYNUMBER3;
	global $PAYMENTPLAN;
	global $DRILLEAGUE;
	global $USAHOCKEYMEMBERSHIP;
	
	$columns = '';
	if($ADDRESS == true) {
		$columns .= ' addressOne, addressTwo, city, state, postalCode,';
	}
	if($EMAIL == true) {
		$columns .= ' eMail,';
	}	
	if($HOMEPHONE == true) {
		$columns .= ' homePhone,';
	}	
	if($WORKPHONE == true) {
		$columns .= ' workPhone,';
	}	
	if($CELLPHONE == true) {
		$columns .= ' cellPhone,';
	}	
	if($SKILLLEVEL == true) {
		$columns .= ' skillLevel,';
	}	
	if($POSITION == true) {
		$columns .= ' position,';
	}	
	if($JERSEYSIZE == true) {
		$columns .= ' jerseySize,';
	}	
	if($JERSEYNUMBER1 == true) {
		$columns .= ' jerseyNumberOne,';
	}	
	if($JERSEYNUMBER2 == true) {
		$columns .= ' jerseyNumberTwo,';
	}	
	if($JERSEYNUMBER3 == true) {
		$columns .= ' jerseyNumberThree,';
	}	
	if($PAYMENTPLAN == true) {
		$columns .= ' paymentPlan,';
	}	
	if($DRILLEAGUE == true) {
		$columns .= ' drilLeague,';
	}
	if($USAHOCKEYMEMBERSHIP == true) {
		$columns .= ' usaHockeyMembership,';
	}
				
	return $columns;	
}

function run_report() {
	global $smarty;
	global $Link;
	global $SEASON;
	
	global $ADDRESS;
	global $EMAIL;
	global $HOMEPHONE;
	global $WORKPHONE;
	global $CELLPHONE;
	global $SKILLLEVEL;
	global $POSITION;
	global $JERSEYSIZE;
	global $JERSEYNUMBER1;
	global $JERSEYNUMBER2;
	global $JERSEYNUMBER3;
	global $PAYMENTPLAN;
	global $DRILLEAGUE;
	global $USAHOCKEYMEMBERSHIP;
	
	global $DB_COLUMNS;
	global $REPORT;
	
	
	$select = 'SELECT '.$DB_COLUMNS.' FROM '.REGISTRATION.' WHERE seasonId='.$SEASON;
	$select .= ' AND fName != "Open"';
	
	if($REPORT == 1) {
	  $select .= ' ORDER BY lName';	
	} else if($REPORT == 2) {
	  $select .= ' AND wantToBeATeamRep = 1 ORDER BY lName';	
	} else if($REPORT == 3) {
	  $select .= ' AND wantToBeARef = 1 ORDER BY lName';	
	} else if($REPORT == 4) {
	  $select .= ' ORDER BY skillLevel DESC, lName';	
	} else if($REPORT == 5) {
	  $select .= ' ORDER BY paymentPlan, lName';	
	} else if($REPORT == 6) {
	  $select .= ' ORDER BY lName';		
	} else if($REPORT == 7) {
	  $select .= ' AND drilLeague > 1 ORDER BY drilLeague, lName';		
	} else if($REPORT == 8) {
	  $select .= ' ORDER BY usaHockeyMembership ASC, lName';
	}


	$result = mysql_query($select, $Link)
     or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	
	if ($result && mysql_num_rows($result) > 0) {			

		  $count=0;
		  $smarty->assign('count', array ());
		  $smarty->assign('id', array ());
		  $smarty->assign('fname', array ());
      $smarty->assign('lname', array ());
          
          
          
	if($ADDRESS == true) {
		$smarty->assign('address', array ());
	}
	if($EMAIL == true) {
		$smarty->assign('email', array ());
	}	
	if($HOMEPHONE == true) {
		$smarty->assign('homephone', array ());
	}	
	if($WORKPHONE == true) {
		$smarty->assign('workphone', array ());
	}	
	if($CELLPHONE == true) {
		$smarty->assign('cellphone', array ());
	}	
	if($SKILLLEVEL == true) {
		$smarty->assign('skilllevel', array ());
	}	
	if($POSITION == true) {
		$smarty->assign('position', array ());
	}	
	if($JERSEYSIZE == true) {
		$smarty->assign('jerseysize', array ());
	}	
	if($JERSEYNUMBER1 == true) {
		$smarty->assign('jerseynumber1', array ());
	}	
	if($JERSEYNUMBER2 == true) {
		$smarty->assign('jerseynumber2', array ());
	}	
	if($JERSEYNUMBER3 == true) {
		$smarty->assign('jerseynumber3', array ());
	}	
	if($PAYMENTPLAN == true) {
		$smarty->assign('paymentplan', array ());
	}	
	if($DRILLEAGUE == true) {
		$smarty->assign('drilleague', array ());
	} 
	if($USAHOCKEYMEMBERSHIP == true) {
		$smarty->assign('usaHockeyMembership', array ());
	}
          
            
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
				
				$count++;
				$id = $row['registrationId'];
				$fname = $row['fName'];
				$lname = $row['lName'];
				
				
				$smarty->append('count', $count);
				$smarty->append('id', $id);					
				$smarty->append('fname', $fname);				
				$smarty->append('lname', $lname);
				
				
				if($ADDRESS == true) {				
					$smarty->append('address', $row['addressOne'].' '.$row['addressTwo'].'<br />'.$row['city'].', '.$row['state'].'<br />'.$row['postalCode']);
				}
				if($EMAIL == true) {
					if(isset($row['eMail']) && strlen($row['eMail']) > 0) {
					  $email = $row['eMail'];
					} else {
						$email = '&nbsp;';
					}					
					$smarty->append('email', $email);
				}	
				if($HOMEPHONE == true) {
					if(isset($row['homePhone']) && strlen($row['homePhone']) > 0) {
					  $homePhone = $row['homePhone'];
					} else {
						$homePhone = '&nbsp;';
					}								
					$smarty->append('homephone', $homePhone);
				}	
				if($WORKPHONE == true) {
					if(isset($row['workPhone']) && strlen($row['workPhone']) > 0) {
					  $workPhone = $row['workPhone'];
					} else {
						$workPhone = '&nbsp;';
					}							
					$smarty->append('workphone', $workPhone);
				}	
				if($CELLPHONE == true) {
					if(isset($row['cellPhone']) && strlen($row['cellPhone']) > 0) {
					  $cellPhone = $row['cellPhone'];
					} else {
						$cellPhone = '&nbsp;';
					}							
					$smarty->append('cellphone', $cellPhone);
				}	
				if($SKILLLEVEL == true) {
					$smarty->append('skilllevel', get_skill($row['skillLevel']));
				}	
				if($POSITION == true) {
					$smarty->append('position', $row['position']);
				}	
				if($JERSEYSIZE == true) {
					$smarty->append('jerseysize', $row['jerseySize']);
				}	
				if($JERSEYNUMBER1 == true) {
					$smarty->append('jerseynumber1', $row['jerseyNumberOne']);
				}	
				if($JERSEYNUMBER2 == true) {
					$smarty->append('jerseynumber2', $row['jerseyNumberTwo']);
				}	
				if($JERSEYNUMBER3 == true) {
					$smarty->append('jerseynumber3', $row['jerseyNumberThree']);
				}	
				if($PAYMENTPLAN == true) {
					$smarty->append('paymentplan', $row['paymentPlan']);
				}
				if($DRILLEAGUE == true) {
					$smarty->append('drilleague', $row['drilLeague']);
				}
				if($USAHOCKEYMEMBERSHIP == true) {
					if(isset($row['usaHockeyMembership']) && strlen($row['usaHockeyMembership']) > 0) {
					  $usaHockeyMembership = $row['usaHockeyMembership'];
					} else {
						$usaHockeyMembership = 'NONE';
					}							
					$smarty->append('usaHockeyMembership', $usaHockeyMembership);
				}				

			}
			$smarty->assign('count', $count);
		}	
	
}
?>
