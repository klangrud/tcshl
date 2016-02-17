<?php

/*
 * Created on Setp 8, 2007
 *
*/

// Page requirements
define('LOGIN_REQUIRED', false);
define('PAGE_ACCESS_LEVEL', 0);
define('PAGE_TYPE', 'PUBLIC');

// Set for every page
require ('engine/common.php');

$smarty->assign('page_name', 'Season Registrations');

setup_seasonregistrations_list();


// Build the page
require ('global_begin.php');
$smarty->display('public/seasonregistrations.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/


function setup_seasonregistrations_list() {
	global $smarty;
	global $SEASON;
	$smarty->assign('seasonName', get_season_name($SEASON));
	
	global $Link;
       
    $selectColumns = 'fName,lName';

	$registrationsSelect = 'SELECT '.$selectColumns.' FROM '.REGISTRATION.' WHERE seasonId='.$SEASON.' ORDER BY lName';

	$registrationsResult = mysql_query($registrationsSelect, $Link);
	
	
	if ($registrationsResult && mysql_num_rows($registrationsResult) > 0) {			

		  $countPlayers=0;
		  $smarty->assign('countRegistrants', array ());
		  $smarty->assign('registrantFName', array ());
          $smarty->assign('registrantLName', array ());
            
			while ($player = mysql_fetch_array($registrationsResult, MYSQL_ASSOC)) {
				
				$countPlayers++;
				$registrantFName = $player['fName'];
				$registrantLName = $player['lName'];
				
				
				$smarty->append('countRegistrants', $countPlayers);
				$smarty->append('registrantFName', $registrantFName);				
				$smarty->append('registrantLName', $registrantLName);           

			}
			$smarty->assign('countPlayers', $countPlayers);
		}
	
}
?>