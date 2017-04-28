<?php
/*
 * Created on Sep 4, 2007
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
$userID = $_SESSION['userid'];
setup_selects();
if ((isset($_POST['action'])) && ($_POST['action'] == "Add Announcement")) {
    // If form does not validate, we need to return with errors.
    if ($errors = validate_addannouncement_form()) {
        handle_errors($errors);
        handle_reposts();
    } else {
        // If errors occur while trying to create user, we need to return with errors.
        if ($errors = process_addannouncement_form($smarty)) {
            handle_errors($errors);
            handle_reposts();
        } else {
            $success = array();
            $success[] = 'Announcement was added successfully.';
            handle_success($success);
        }
    }
}
$smarty->assign('page_name', 'Post Announcement');
// Build the page
require ('global_begin.php');
$smarty->display('admin/addannouncement.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
function handle_reposts() {
    global $smarty;
    $at = "";
    $an = "";
    if ($_POST) {
        if ($_POST['announcementtitle']) {
            $at = format_text($_POST['announcementtitle']);
            if ($_POST['announcementbody']) {
                $an = format_text($_POST['announcementbody']);
            }
        }
    }
    $smarty->assign('at', $at);
    $smarty->assign('an', $an);
}
function setup_selects() {
    global $smarty;
    $beginDateSelect = '<select name="bMonth">' . select_month("0") . '<select name="bDay">' . select_day("0") . '<select name="bYear">' . select_year("0");
    $smarty->assign('announcementbegindate', $beginDateSelect);
    $endDateSelect = '<select name="eMonth">' . select_month("0") . '<select name="eDay">' . select_day("0") . '<select name="eYear">' . select_year("0");
    $smarty->assign('announcementenddate', $endDateSelect);
}
function validate_addannouncement_form() {
    $errors = array();
    if ($_POST['announcementtitle']) {
        //Do nothing
        
    } else {
        $errors[] = "Announcement title is a required field";
    }
    if ($_POST['announcementbody']) {
        //Do nothing
        
    } else {
        $errors[] = "Announcement body is a required field";
    }
    $b_date = mktime(0, 0, 0, $_POST['bMonth'], $_POST['bDay'], $_POST['bYear'], -1);
    $e_date = mktime(0, 0, 0, $_POST['eMonth'], $_POST['eDay'], $_POST['eYear'], -1);
    if ($b_date > $e_date) {
        $errors[] = "Announcement end date cannot be before begin date.";
    }
    return $errors;
}
/*
 * Process Form Data
*/
function process_addannouncement_form($smarty) {
    global $userID;
    global $Link;
    $errors = array();
    $atitle = format_doublequotes($_POST['announcementtitle']);
    $abody = format_paragraph(format_doublequotes($_POST['announcementbody']));
    $abegin = mktime(0, 0, 0, $_POST['bMonth'], $_POST['bDay'], $_POST['bYear'], -1);
    $aend = mktime(23, 59, 59, $_POST['eMonth'], $_POST['eDay'], $_POST['eYear'], -1);
    $announceColumns = '`announceTitle`,`announcement`,`announceBeginDate`,`announceEndDate`,`userID`';
    $announceInsertSQL = 'INSERT INTO ' . ANNOUNCEMENTS . ' (' . $announceColumns . ') VALUES ("' . $atitle . '","' . $abody . '","' . $abegin . '","' . $aend . '","' . $userID . '")';
    $announceInsertResult = mysql_query($announceInsertSQL, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    return $errors;
} // End of function

?>
