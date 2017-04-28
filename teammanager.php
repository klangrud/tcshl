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
require_once ('com/tcshl/team/Team.php');
require_once ('com/tcshl/team/Teams.php');
$smarty->assign('div_newobject_style', 'display: none');
$smarty->assign('page_name', 'Team Manager');
$smarty->assign('newTeamFGColorSelect', select_color('teamFGColor', 'FFFFFF'));
$smarty->assign('newTeamBGColorSelect', select_color('teamBGColor', '000000'));
// Handle posts
if (isset($_POST['action'])) {
    // if Form post of a new team
    if ($_POST['action'] == "Add New Team") {
        $team = new Team(0);
        // If form does not validate, we need to return with errors.
        if ($team->formValidation()) {
            handle_errors($team->get_teamFormErrors());
            $team->formReposts($smarty);
            $smarty->assign('div_newobject_style', 'display: block');
        } else {
            // If errors occur while trying to create team, we need to return with errors.
            if ($team->formProcessInsert()) {
                handle_errors($team->get_teamFormErrors());
                $team->formReposts($smarty);
                $smarty->assign('div_newobject_style', 'display: block');
            } else {
                handle_success($team->get_teamFormSuccess());
            }
        }
    }
    // else if Form post of an edit to a team
    else if ($_POST['action'] == "Edit Team") {
        $team = new Team($_POST['teamID']);
        // If form does not validate, we need to return with errors.
        if ($team->formValidation()) {
            handle_errors($team->get_teamFormErrors());
            $team->formReposts($smarty);
        } else {
            // If errors occur while trying to update team, we need to return with errors.
            if ($team->formProcessUpdate()) {
                handle_errors($team->get_teamFormErrors());
                $team->formReposts($smarty);
            } else {
                handle_success($team->get_teamFormSuccess());
            }
        }
    }
}
// if GET request to Delete team
if (isset($_GET['teamID']) && $_GET['teamID'] > 0 && $_GET['delete'] == 1) {
    $team = new Team($_GET['teamID']);
    if ($team->formProcessDelete()) {
        handle_errors($team->get_teamFormErrors());
        $team->formReposts($smarty);
    } else {
        handle_success($team->get_teamFormSuccess());
    }
}
// Build list of teams
$Teams = new Teams();
$TeamsArray = $Teams->get_TeamArray(0);
if (count($TeamsArray) > 0) {
    $count = 0;
    $smarty->assign('teamID', array());
    $smarty->assign('teamName', array());
    $smarty->assign('teamShortName', array());
    $smarty->assign('teamFGColor', array());
    $smarty->assign('teamBGColor', array());
    $smarty->assign('teamSeasons', array());
    $smarty->assign('teamCanDelete', array());
    $smarty->assign('teamFGColorSelect', array());
    $smarty->assign('teamBGColorSelect', array());
    $smarty->assign('div_editobject_style', array());
    foreach ($TeamsArray as $Team) {
        $count++;
        $smarty->append('teamID', $Team->get_teamID());
        $smarty->append('teamName', $Team->get_teamName());
        $smarty->append('teamShortName', $Team->get_teamShortName());
        $smarty->append('teamFGColor', $Team->get_teamFGColor());
        $smarty->append('teamBGColor', $Team->get_teamBGColor());
        $smarty->append('teamSeasons', $Team->get_teamSeasons());
        $smarty->append('teamCanDelete', $Team->canDelete());
        $smarty->append('teamFGColorSelect', $Team->get_teamColorSelect('teamFGColor', $Team->get_teamFGColor()));
        $smarty->append('teamBGColorSelect', $Team->get_teamColorSelect('teamBGColor', $Team->get_teamBGColor()));
        if (isset($team) && $team->get_teamID() > 0 && $team->get_teamID() == $Team->get_teamID() && count($team->get_teamFormErrors()) > 0 && count($team->get_teamFormSuccess()) == 0) {
            $smarty->append('div_editobject_style', 'display: block');
        } else {
            $smarty->append('div_editobject_style', 'display: none');
        }
    }
    $smarty->assign('count', $count);
}
// Build the page
require ('global_begin.php');
$smarty->display('admin/teammanager.tpl');
require ('global_end.php');
?>
