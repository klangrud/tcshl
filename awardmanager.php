<?php

/*
 * Created on Sep 16, 2008
 *
*/

// Page requirements
define('LOGIN_REQUIRED', true);
define('PAGE_ACCESS_LEVEL', 2);
define('PAGE_TYPE', 'ADMIN');

// Set for every page
require ('engine/common.php');

$smarty->assign('page_name', 'Awards Manager');

setup_award_list();


// Build the page
require ('global_begin.php');
$smarty->display('admin/awardmanager.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/


function setup_award_list() {
	global $smarty;
	
	global $Link;
	
  $selectColumns = 'awardID, award, priority, seasonName';

	$awardsSelect = 'SELECT '.$selectColumns.' FROM '.AWARDS;
	$awardsSelect .= ' JOIN '.SEASONS.' ON '.AWARDS.'.seasonID='.SEASONS.'.seasonId';
	$awardsSelect .= ' ORDER BY seasonName DESC, priority, award';

	$awardsResult = mysql_query($awardsSelect, $Link);
	
	
	if ($awardsResult) {
		if (mysql_num_rows($awardsResult) > 0) {			

		  $countAwards=0;
		  $smarty->assign('awardID', array ());
		  $smarty->assign('awardName', array ());
		  $smarty->assign('priority', array ());
		  $smarty->assign('seasonName', array ());		  
            
			while ($award = mysql_fetch_array($awardsResult, MYSQL_ASSOC)) {
				
				$countAwards++;
				$awardId = $award['awardID'];
				$awardName = $award['award'];	
				$priority = $award['priority'];
				$seasonName = $award['seasonName'];			
				
				$smarty->append('countAwards', $countAwards);
				$smarty->append('awardID', $awardId);
				$smarty->append('awardName', $awardName);   
				$smarty->append('priority', $priority);       
				$smarty->append('seasonName', $seasonName);    

			}
			$smarty->assign('countAwards', $countAwards);
		}
	}
}
?>