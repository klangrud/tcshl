<?php
/*
 * Created on Sep 23, 2009
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
require_once ('com/tcshl/player/Player.php');
require_once ('com/tcshl/player/Players.php');
$smarty->assign('div_newobject_style', 'display: none');
$smarty->assign('page_name', 'Player Manager');
$smarty->assign('seasonSelect', select_season());
$smarty->assign('skillLevelSelect', select_skill_level());
// Handle posts
if (isset($_POST['action'])) {
    // if Form post of a new player
    if ($_POST['action'] == "Add New Player") {
        $player = new Player(0);
        // If form does not validate, we need to return with errors.
        if ($player->formValidation()) {
            handle_errors($player->get_playerFormErrors());
            $player->formReposts($smarty);
            $smarty->assign('div_newobject_style', 'display: block');
        } else {
            // If errors occur while trying to create player, we need to return with errors.
            if ($player->formProcessInsert()) {
                handle_errors($player->get_playerFormErrors());
                $player->formReposts($smarty);
                $smarty->assign('div_newobject_style', 'display: block');
            } else {
                handle_success($player->get_playerFormSuccess());
            }
        }
    }
    // else if Form post of an edit to a player
    else if ($_POST['action'] == "Edit Player") {
        $player = new Player($_POST['playerID']);
        // If form does not validate, we need to return with errors.
        if ($player->formValidation()) {
            handle_errors($player->get_playerFormErrors());
            $player->formReposts($smarty);
        } else {
            // If errors occur while trying to update player, we need to return with errors.
            if ($player->formProcessUpdate()) {
                handle_errors($player->get_playerFormErrors());
                $player->formReposts($smarty);
            } else {
                $player->formPreLoad($smarty);
                handle_success($player->get_playerFormSuccess());
            }
        }
    }
}
// if GET request to Delete player
if (isset($_GET['playerID']) && $_GET['playerID'] > 0 && $_GET['delete'] == 1) {
    $player = new Player($_GET['playerID']);
    if ($player->formProcessDelete()) {
        handle_errors($player->get_playerFormErrors());
        $player->formReposts($smarty);
    } else {
        handle_success($player->get_playerFormSuccess());
    }
}
// Build list of players
$Players = new Players();
$PlayersArray = $Players->get_PlayerArray(0);
if (count($PlayersArray) > 0) {
    $count = 0;
    $smarty->assign('playerID', array());
    $smarty->assign('playerFName', array());
    $smarty->assign('playerLName', array());
    $smarty->assign('playerSkillLevel', array());
    $smarty->assign('playerSkillLevelSelect', array());
    $smarty->assign('playerRegistrationID', array());
    $smarty->assign('playerSeason', array());
    $smarty->assign('playerCanDelete', array());
    $smarty->assign('div_editobject_style', array());
    foreach ($PlayersArray as $Player) {
        $count++;
        $smarty->append('playerID', $Player->get_playerID());
        $smarty->append('playerFName', $Player->get_playerFName());
        $smarty->append('playerLName', $Player->get_playerLName());
        $smarty->append('playerSkillLevel', $Player->get_humanReadablePlayerSkillLevel());
        $smarty->append('playerSkillLevelSelect', $Player->get_playerSkillLevelSelect());
        $smarty->append('playerRegistrationID', $Player->get_playerRegistrationID());
        $smarty->append('playerSeason', $Player->get_humanReadableSeason());
        $smarty->append('playerSeasonSelect', $Player->get_playerSeasonSelect());
        $smarty->append('playerCanDelete', $Player->canDelete());
        if (isset($player) && $player->get_playerID() > 0 && $player->get_playerID() == $Player->get_playerID() && count($player->get_playerFormErrors()) > 0 && count($player->get_playerFormSuccess()) == 0) {
            $smarty->append('div_editobject_style', 'display: block');
        } else {
            $smarty->append('div_editobject_style', 'display: none');
        }
    }
    $smarty->assign('count', $count);
}
// Build the page
require ('global_begin.php');
$smarty->display('admin/playermanager.tpl');
require ('global_end.php');
?>
