<?php
/*
 * Created on Sept 23, 2010
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

// Get required variables
if($_GET || $_POST) {
	//Must have season id
	if(isset($_GET['seasonID']) && $_GET['seasonID'] > 0) {
		$SEASON = $_GET['seasonID'];
	} else if(isset($_POST['seasonID']) && $_POST['seasonID'] > 0) {
		$SEASON = $_POST['seasonID'];
	} else {
		header("Location: players.php");
	}
	
	
	//Must have team id
	if(isset($_GET['teamID']) && $_GET['teamID'] > 0) {
		$TEAMID = $_GET['teamID'];
	} else if(isset($_POST['teamID']) && $_POST['teamID'] > 0) {
		$TEAMID = $_POST['teamID'];
	} else {
		header("Location: players.php");
	}	
	
	//Must have player id
	if(isset($_GET['playerID']) && $_GET['playerID'] > 0) {
		$PLAYERID = $_GET['playerID'];
	} else if(isset($_POST['playerID']) && $_POST['playerID'] > 0) {
		$PLAYERID = $_POST['playerID'];
	} else {
		header("Location: players.php");
	}	
		
} else {
		header("Location: players.php");
}

$delete = 'DELETE FROM '.ROSTERSOFTEAMSOFSEASONS.' WHERE seasonID='.$SEASON.' AND teamID='.$TEAMID.' AND playerID='.$PLAYERID.' LIMIT 1';

	$result = mysql_query($delete, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
		header("Location: players.php");
	
?>
