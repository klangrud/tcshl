<?php
/*
 * Created on Sep 16, 2008
 *
*/
// Page requirements
define('LOGIN_REQUIRED', false);
define('PAGE_ACCESS_LEVEL', 0);
define('PAGE_TYPE', 'PUBLIC');
// Set for every page
require ('engine/common.php');
//This page must have a award.
if (isset($_GET['award']) && $_GET['award'] > 0) {
    $AWARD = $_GET['award'];
} else if (isset($_POST['award']) && $_POST['award'] > 0) {
    $AWARD = $_POST['award'];
} else {
    header("Location: index.php");
}
$smarty->assign('page_name', 'TCSHL Award');
setup_award();
// Build the page
require ('global_begin.php');
$smarty->display('public/award.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
function setup_award() {
    global $smarty;
    global $AWARD;
    global $Link;
    $columns = 'awardID, seasonID, award, about, recipient, imageWidth, imageHeight';
    $awardSelect = 'SELECT ' . $columns . ' FROM ' . AWARDS . ' WHERE awardID=' . $AWARD;
    $awardResult = mysql_query($awardSelect, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($awardResult && mysql_num_rows($awardResult) > 0) {
        $award = mysql_fetch_array($awardResult, MYSQL_ASSOC);
        $id = $award['awardID'];
        $awardName = $award['award'];
        $recipient = $award['recipient'];
        $about = $award['about'];
        $seasonName = get_season_name($award['seasonID']);
        $imageWidth = $award['imageWidth'];
        $imageHeight = $award['imageHeight'];
        $smarty->assign('awardID', $id);
        $smarty->assign('award', $awardName);
        $smarty->assign('recipient', $recipient);
        $smarty->assign('about', $about);
        $smarty->assign('seasonName', $seasonName);
        if ($imageWidth > 0) {
            $smarty->assign('imageSize', imageSize($imageWidth, $imageHeight, 700));
        }
    }
}
?>