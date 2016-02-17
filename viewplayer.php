<?php
/*
 * Created on Sep 16, 2009
 *
 */
 
 // Page requirements
define('LOGIN_REQUIRED', true);
define('PAGE_ACCESS_LEVEL', 2);
define('PAGE_TYPE', 'ADMIN');

// Set for every page
require ('engine/common.php');

// Class includes
require_once("com/tcshl/player/Player.php"); 

$playerid = 0;
if($_GET) {
	if(isset($_GET['playerid']) && $_GET['playerid'] > 0) {
		$playerid = $_GET['playerid'];
	} else {
		header("Location: index.php");
	}	
} else {
	header("Location: index.php");
}

$Player = new Player($playerid);

$smarty->assign('page_name', 'Player - '.$Player->get_playerFName().' '.$Player->get_playerLName());
$smarty->assign('PlayerName', $Player->get_playerFName().' '.$Player->get_playerLName());
$smarty->assign('CurrentSkillLevel', $Player->get_humanReadablePlayerSkillLevel());
$smarty->assign('CurrentRegistrationID', $Player->get_playerRegistrationID());
$smarty->assign('LastActiveSeason', $Player->get_humanReadableSeason());
$smarty->assign('SeasonsPlayed', array());

$SeasonsPlayed = $Player->get_playerSeasons();

foreach($SeasonsPlayed as $Season) {
	$smarty->append('SeasonsPlayed', $Season);
}

// Build the page
require ('global_begin.php');
$smarty->display('admin/viewplayer.tpl');
require ('global_end.php');
 
?>
