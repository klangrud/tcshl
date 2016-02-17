<?php
/*
 * Created on Sep 19, 2007
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

$GAMEID = 0;

if($_GET || $_POST) {
	if(isset($_GET['gameid']) && $_GET['gameid'] > 0) {
		$GAMEID = $_GET['gameid'];
	} else if(isset($_POST['gameid']) && $_POST['gameid'] > 0) {
		$GAMEID = $_POST['gameid'];
	} else {
		header("Location: gamemanager.php");
	}	
}

$smarty->assign('page_name', 'Edit Game Stats');
$smarty->assign('managerMode',true);

//Setup this game's information
setup_game_info();

// Setup player and goalie stats
require ('includes/inc_setup_game_player_stats.php');
require ('includes/inc_setup_game_goalie_stats.php');

// Build the page
require ('global_begin.php');
$smarty->display('admin/managegamestats.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/ 


function setup_game_info() {
	global $smarty;
	global $GAMEID;

	
	global $Link;
	
	$gameInfoSelect = 'SELECT gameID,gameTime,gameGuestTeam,gameHomeTeam FROM '.GAME;
	$gameInfoSelect .= ' WHERE gameID='.$GAMEID;
	
	$gameInfoResult = mysql_query($gameInfoSelect, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
		
	if ($gameInfoResult && mysql_num_rows($gameInfoResult) > 0) {
	  $game = mysql_fetch_assoc($gameInfoResult);			

    $gameGuestID = $game['gameGuestTeam'];
    $gameHomeID = $game['gameHomeTeam']; 

    $smarty->assign('gameTime', date('D, M j, Y g:i a',$game['gameTime']));
	  $smarty->assign('gameGuestTeam', get_team_name($gameGuestID));
	  $smarty->assign('gameHomeTeam', get_team_name($gameHomeID));
	  
	}		
}
?>
