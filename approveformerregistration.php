<?php
/*
 * Created on Aug 29, 2007
 *
*/

// Page requirements
define('LOGIN_REQUIRED', true);
define('PAGE_ACCESS_LEVEL', 2);
define('PAGE_TYPE', 'ADMIN');

// Set for every page
require ('engine/common.php');

$registrantid = 0;
$playerid = 0;
if($_GET) {
	if(isset($_GET['registrantid']) && $_GET['registrantid'] > 0) {
		$registrantid = $_GET['registrantid'];
	} else {
		header("Location: manageregistrations.php");
	}

	if(isset($_GET['playerid']) && $_GET['playerid'] > 0) {
		$playerid = $_GET['playerid'];
	}	
} else {
	header("Location: manageregistrations.php");
}

if($registrantid > 0 && $playerid > 0) {
  $success = activate_former_registration();
  handle_success($success);
} else {
	setup_eligible_former_players();  
}

$smarty->assign('page_name', 'Former Player Registration Approval');
$smarty->assign('season_name', get_season_name($SEASON).' Season');
$smarty->assign('registrantid', $registrantid);

// Build the page
require ('global_begin.php');
$smarty->display('admin/approveformerregistration.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/

function setup_eligible_former_players() {
  global $smarty;
  global $SEASON;
	global $registrantid;
	global $Link;
	
	$formerPlayersQuery = 'SELECT playerID, playerFName, playerLName FROM '.PLAYER.' WHERE seasonId !='.$SEASON.' ORDER BY playerLName';
	
	$formerPlayersResult = mysql_query($formerPlayersQuery, $Link)
  		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
  		
  		
	if ($formerPlayersResult && mysql_num_rows($formerPlayersResult) > 0) {			

		  $countPlayers=0;
		  $smarty->assign('playerId', array ());
		  $smarty->assign('playerFName', array ());
      $smarty->assign('playerLName', array ());
            
			while ($player = mysql_fetch_array($formerPlayersResult, MYSQL_ASSOC)) {
				
				$countPlayers++;
				$playerId = $player['playerID'];
				$playerFName = $player['playerFName'];
				$playerLName = $player['playerLName'];
				
				
				$smarty->append('countPlayers', $countPlayers);
				$smarty->append('playerId', $playerId);
				$smarty->append('playerFName', $playerFName);
        $smarty->append('playerLName', $playerLName);           

			}
			$smarty->assign('countPlayers', $countPlayers);
		}  		
  		
  			
}

function activate_former_registration() {
	global $registrantid;
	global $playerid;	
	global $SEASON;
	$playerExists = true; //We will asume true to avoid any accidental duplicate insertion
	
	global $Link;
	
	#See if player already exists.  Do not wanna any duplicates.
	$playerExistsCheckSQL = 'SELECT playerID FROM '.PLAYER.' WHERE registrationId='.$registrantid.' AND seasonId='.$SEASON;
		
	$playerExistsCheckResult = mysql_query($playerExistsCheckSQL, $Link)
  		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	if ($playerExistsCheckResult) {
		if (mysql_num_rows($playerExistsCheckResult) > 0) {
			$playerExists = true;	
		} else {
			$playerExists = false;
		}
	} else {
		//Error selecting from database
	}

	#Create new player
	if(!$playerExists) {
		//$updatePlayerSQL = 'UPDATE '.PLAYER.' SET registrationId='.$registrantid.', seasonId='.$SEASON.' WHERE playerID='.$playerid;
  		
		$updatePlayerSQL = 'SELECT skillLevel, paymentPlan FROM '.REGISTRATION.' WHERE registrationId='.$registrantid;
		
		$updatePlayerResult = mysql_query($updatePlayerSQL, $Link)
  		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
		
		if ($updatePlayerResult) {
			if (mysql_num_rows($updatePlayerResult) > 0) {
				$updatePlayer = mysql_fetch_assoc($updatePlayerResult);
				
				$updatePlayerSkillLevel = $updatePlayer['skillLevel'];
				$updatePlayerPaymentPlan = $updatePlayer['paymentPlan'];		
				
				//$createPlayerColumns = '`playerFName`,`playerLName`,`playerSkillLevel`,`registrationId`,`seasonId`';
				
				$updateFormerPlayerSQL = 'UPDATE '.PLAYER.' ';
				$updateFormerPlayerSQL .= 'SET playerSkillLevel='.$updatePlayerSkillLevel.',';				
				$updateFormerPlayerSQL .= 'registrationId='.$registrantid.',';
				$updateFormerPlayerSQL .= 'seasonId='.$SEASON;
				$updateFormerPlayerSQL .= ' WHERE playerID='.$playerid;
		
				$updateFormerPlayerResult = mysql_query($updateFormerPlayerSQL, $Link)
  				or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
				
				#If new player was created we want to set the playerId for that registrant in registration table.
				if($updateFormerPlayerResult)	{			
					$setPlayerIdSQL = 'UPDATE '.REGISTRATION.' SET playerId='.$playerid.', registrationApproved=1 WHERE registrationId='.$registrantid;

					$setPlayerIdResult = mysql_query($setPlayerIdSQL, $Link)
  					or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
  					
  				// Insert player into payment table
  				insert_player_into_payment_table($registrantid, $updatePlayerPaymentPlan);  					

				}			
			}
		}
	}
	
	$success = array ();
	$success[] = "Registration of former player approved successfully.";
  return $success;
}
?>
