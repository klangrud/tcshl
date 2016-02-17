<?php

/*
 * Created on Aug 30, 2007
 *
*/

// Page requirements
define('LOGIN_REQUIRED', true);
define('PAGE_ACCESS_LEVEL', 2);
define('PAGE_TYPE', 'ADMIN');

// Set for every page
require ('engine/common.php');

$smarty->assign('page_name', 'Sponsors');

setup_sponsor_list();


// Build the page
require ('global_begin.php');
$smarty->display('admin/sponsors.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/


function setup_sponsor_list() {
	global $smarty;
	
	global $Link;
	
  $selectColumns = 'sponsorID,sponsorName';

	$sponsorsSelect = 'SELECT '.$selectColumns.' FROM '.SPONSORS.' ORDER BY sponsorName';

	$sponsorsResult = mysql_query($sponsorsSelect, $Link);
	
	
	if ($sponsorsResult) {
		if (mysql_num_rows($sponsorsResult) > 0) {			

		  $countSponsors=0;
		  $smarty->assign('sponsorID', array ());
		  $smarty->assign('sponsorName', array ());
            
			while ($sponsor = mysql_fetch_array($sponsorsResult, MYSQL_ASSOC)) {
				
				$countSponsors++;
				$sponsorId = $sponsor['sponsorID'];
				$sponsorName = $sponsor['sponsorName'];				
				
				$smarty->append('countSponsors', $countSponsors);
				$smarty->append('sponsorID', $sponsorId);
				$smarty->append('sponsorName', $sponsorName);           

			}
			$smarty->assign('countSponsors', $countSponsors);
		}
	}
}
?>