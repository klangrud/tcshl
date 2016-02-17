<?php
/*
 * Created on Aug 30, 2007
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 
// Page requirements
define('LOGIN_REQUIRED', true);
define('PAGE_ACCESS_LEVEL', 2);
define('PAGE_TYPE', 'ADMIN');

// Set for every page
require ('engine/common.php');

if ((isset ($_POST['action'])) && ($_POST['action'] == "Add Sponsor To Team")) {
	//No validation needed since we give them the values to post.
	process_addsponsortoteam_form($smarty);
}

$pageName = 'Add Sponsor to Team';
$smarty->assign('page_name', $pageName);
$smarty->assign('seasonName', get_season_name($SEASON));

setup_teams_this_season();
setup_sponsor_select();

// Build the page
require ('global_begin.php');
$smarty->display('admin/addsponsortoteam.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/


/*
 * Process Form Data
 */

function process_addsponsortoteam_form($smarty) {
	global $SEASON;
	global $Link;

	$errors = array();

	$teamCandidateID = $_POST['candidateTeams'];
	$sponsorCandidateID = $_POST['candidateSponsors'];

	//Check if user exists with accessLevel > 0.  If true, then we will just error out registration and explain that user exists.
	$query = 'INSERT INTO '.SPONSORSOFSEASONS. ' (`seasonID`, `teamID`, `sponsorID`) VALUES ('.$SEASON.','.$teamCandidateID.','.$sponsorCandidateID.')';
	
	mysql_query($query, $Link)
	  or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());

	

} // End of function

function setup_teams_this_season(){
	global $smarty;
	global $SEASON;
	
	global $Link;
	
	$teamsThisSeasonSelect = 'SELECT teamID, teamName FROM '.TEAMS.' WHERE teamID IN (SELECT teamID FROM '.TEAMSOFSEASONS.' WHERE seasonID='.$SEASON.')';
	
	$teamsThisSeasonResult = mysql_query($teamsThisSeasonSelect, $Link)
	  or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	
	if ($teamsThisSeasonResult && mysql_num_rows($teamsThisSeasonResult) > 0) {			

		  $countTeams=0;
		  $smarty->assign('teamID', array ());
		  $smarty->assign('teamName', array ());
		  $smarty->assign('teamCandidateID', array ());
		  $smarty->assign('teamCandidateName', array ());
		  $smarty->assign('teamSponsors', array ());	  
            
			while ($team = mysql_fetch_array($teamsThisSeasonResult, MYSQL_ASSOC)) {
				
				$countTeams++;
				$teamId = $team['teamID'];
				$teamName = $team['teamName'];
				$teamSponsors = get_team_sponsors($teamId);
				

				$smarty->append('teamID', $teamId);
				$smarty->append('teamName', $teamName);
				$smarty->append('teamCandidateID', $teamId);
				$smarty->append('teamCandidateName', $teamName);
				$smarty->append('teamSponsors', $teamSponsors);			
			}
			$smarty->assign('countTeams', $countTeams);
			$smarty->assign('countCandidateTeams', $countTeams);			
		}
	
		
}

function get_team_sponsors($teamId) {
	global $Link;
	global $SEASON;
	
	$subQuery = 'SELECT sponsorID from '.SPONSORSOFSEASONS.' WHERE teamID='.$teamId.' AND seasonID='.$SEASON;
	$select = 'SELECT sponsorID, sponsorName FROM '.SPONSORS.' WHERE sponsorID IN ('.$subQuery.')';
	
	$result = mysql_query($select, $Link)
	  or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	$sponsors = '';
	if ($result && mysql_num_rows($result) > 0) {	
			$sponsors = '';
      $count=1;
			while ($sponsor = mysql_fetch_array($result, MYSQL_ASSOC)) {
				$sponsors .= $count.'. '.$sponsor['sponsorName'].'<br />';
				$count++;
			}
		}	
	return $sponsors;
}

function setup_sponsor_select() {
	global $smarty;
	
	global $Link;

	$sponsorCandidatesSelect = 'SELECT sponsorID, sponsorName FROM '.SPONSORS;
	
	$sponsorCandidatesResult = mysql_query($sponsorCandidatesSelect, $Link)
	  or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	
	if ($sponsorCandidatesResult && mysql_num_rows($sponsorCandidatesResult) > 0) {			

			$countCandidateSponsors=0;
		  $smarty->assign('sponsorCandidateID', array ());
		  $smarty->assign('sponsorCandidateName', array ());
           
			while ($sponsor = mysql_fetch_array($sponsorCandidatesResult, MYSQL_ASSOC)) {
				
				$countCandidateSponsors++;
				$sponsorId = $sponsor['sponsorID'];
				$sponsorName = $sponsor['sponsorName'];
				

				$smarty->append('sponsorCandidateID', $sponsorId);
				$smarty->append('sponsorCandidateName', $sponsorName);
			}
			$smarty->assign('countCandidateSponsors', $countCandidateSponsors);
		}		
}

?>