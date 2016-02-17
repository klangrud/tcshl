<?php
/*
 * Created on Sep 16, 2009
 */
 
 // Page requirements
define('LOGIN_REQUIRED', true);
define('PAGE_ACCESS_LEVEL', 2);
define('PAGE_TYPE', 'ADMIN');

// Set for every page
require ('engine/common.php');

// Class includes
require_once("com/tcshl/player/Players.php"); 


$Players = new Players();
$PlayersArray = $Players->get_PlayerArray(0);

$smarty->assign('page_name', 'League Players');

if(count($PlayersArray) > 0) {
	$count=0;
	$smarty->assign('playerID', array ());
	$smarty->assign('playerName', array ());
	$smarty->assign('CurrentSkillLevel', array ());
	$smarty->assign('CurrentRegistrationID', array ());
	$smarty->assign('LastActiveSeason', array ());            
	foreach($PlayersArray as $Player) {				
		$count++;
		$smarty->append('PlayerID', $Player->get_playerID());
		$smarty->append('PlayerName', $Player->get_playerFName().' '.$Player->get_playerLName());
		$smarty->append('CurrentSkillLevel', $Player->get_humanReadablePlayerSkillLevel());				
		$smarty->append('CurrentRegistrationID', $Player->get_playerRegistrationID());
		$smarty->append('LastActiveSeason', $Player->get_humanReadableSeason());
	}
	$smarty->assign('count', $count);
} else {
	header("Location: index.php");	
}

// Build the page
require ('global_begin.php');
$smarty->display('admin/viewplayers.tpl');
require ('global_end.php'); 
?>
