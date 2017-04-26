<?php
/*
 * Created on Aug 30, 2007
 *
*/
// Page requirements
define('LOGIN_REQUIRED', false);
define('PAGE_ACCESS_LEVEL', 0);
define('PAGE_TYPE', 'PUBLIC');
// Set for every page
require ('engine/common.php');
//This page must have a sponsor.
if (isset($_GET['sponsor']) && $_GET['sponsor'] > 0) {
    $SPONSOR = $_GET['sponsor'];
} else if (isset($_POST['sponsor']) && $_POST['sponsor'] > 0) {
    $SPONSOR = $_POST['sponsor'];
} else {
    header("Location: index.php");
}
$smarty->assign('page_name', 'TCSHL Sponsor');
setup_sponsor();
// Build the page
require ('global_begin.php');
$smarty->display('public/sponsor.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
function setup_sponsor() {
    global $smarty;
    global $SPONSOR;
    global $Link;
    $columns = 'sponsorID, sponsorName, sponsorURL, sponsorAbout, sponsorLogoWidth, sponsorLogoHeight';
    $sponsorsSelect = 'SELECT ' . $columns . ' FROM ' . SPONSORS . ' WHERE sponsorID=' . $SPONSOR;
    $sponsorsResult = mysql_query($sponsorsSelect, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($sponsorsResult && mysql_num_rows($sponsorsResult) > 0) {
        $sponsor = mysql_fetch_array($sponsorsResult, MYSQL_ASSOC);
        $id = $sponsor['sponsorID'];
        $name = $sponsor['sponsorName'];
        $url = $sponsor['sponsorURL'];
        $about = $sponsor['sponsorAbout'];
        $logoWidth = $sponsor['sponsorLogoWidth'];
        $logoHeight = $sponsor['sponsorLogoHeight'];
        $smarty->assign('sponsorID', $id);
        $smarty->assign('sponsorName', $name);
        $smarty->assign('sponsorURL', $url);
        $smarty->assign('sponsorAbout', $about);
        if ($logoWidth > 0) {
            $smarty->assign('imageSize', imageSize($logoWidth, $logoHeight, 400));
        }
    }
}
?>