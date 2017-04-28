<?php
/*
 * Created on Aug 30, 2007
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
//This page must have a sponsor.
if (isset($_GET['sponsor']) && $_GET['sponsor'] > 0) {
    $SPONSOR = $_GET['sponsor'];
} else if (isset($_POST['sponsor']) && $_POST['sponsor'] > 0) {
    $SPONSOR = $_POST['sponsor'];
} else {
    header("Location: sponsors.php");
}
$IMAGE_WIDTH = 200;
if ((isset($_POST['action'])) && ($_POST['action'] == "Edit Sponsor")) {
    // If form does not validate, we need to return with errors.
    if ($errors = validate_editsponsor_form()) {
        handle_errors($errors);
        handle_reposts();
    } else {
        // If errors occur while trying to create user, we need to return with errors.
        if ($errors = process_editsponsor_form($smarty)) {
            handle_errors($errors);
            handle_reposts();
        } else {
            header("Location: sponsors.php");
        }
    }
} else {
    get_current_sponsor_from_db();
}
$smarty->assign('page_name', 'Edit Sponsor');
$smarty->assign('sponsor', $SPONSOR);
// Build the page
require ('global_begin.php');
$smarty->display('admin/editsponsor.tpl');
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
    global $IMAGE_WIDTH;
    $sn = "";
    $su = "";
    $sa = "";
    if ($_POST) {
        if ($_POST['sponsorname']) {
            $sn = $_POST['sponsorname'];
        }
        if ($_POST['sponsorurl']) {
            $su = $_POST['sponsorurl'];
        }
        if ($_POST['sponsorabout']) {
            $sa = $_POST['sponsorabout'];
        }
        if (isset($_POST['logoWidth']) && $_POST['logoWidth'] > 0) {
            $logoWidth = $_POST['logoWidth'];
        } else {
            $logoWidth = 0;
        }
        if (isset($_POST['logoHeight']) && $_POST['logoHeight'] > 0) {
            $logoHeight = $_POST['logoHeight'];
        } else {
            $logoHeight = 0;
        }
    }
    $smarty->assign('sn', $sn);
    $smarty->assign('su', $su);
    $smarty->assign('sa', $sa);
    $smarty->assign('logoWidth', $logoWidth);
    $smarty->assign('logoHeight', $logoHeight);
    if ($logoWidth > 0) {
        $smarty->assign('imageSize', imageSize($logoWidth, $logoHeight, $IMAGE_WIDTH));
    }
}
function get_current_sponsor_from_db() {
    global $smarty;
    global $Link;
    global $SPONSOR;
    global $IMAGE_WIDTH;
    $sponsorSelect = 'SELECT sponsorName, sponsorURL, sponsorAbout, sponsorLogoWidth, sponsorLogoHeight FROM ' . SPONSORS . ' WHERE sponsorID=' . $SPONSOR;
    $sponsorResult = mysql_query($sponsorSelect, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($sponsorResult && mysql_num_rows($sponsorResult) > 0) {
        $sponsor = mysql_fetch_array($sponsorResult, MYSQL_ASSOC);
        $sn = $sponsor['sponsorName'];
        $su = $sponsor['sponsorURL'];
        $sa = $sponsor['sponsorAbout'];
        $logoWidth = $sponsor['sponsorLogoWidth'];
        $logoHeight = $sponsor['sponsorLogoHeight'];
        $sa = str_replace('<br />', '', $sa);
        $smarty->assign('sn', $sn);
        $smarty->assign('su', $su);
        $smarty->assign('sa', $sa);
        $smarty->assign('logoWidth', $logoWidth);
        $smarty->assign('logoHeight', $logoHeight);
        if ($logoWidth > 0) {
            $smarty->assign('imageSize', imageSize($logoWidth, $logoHeight, $IMAGE_WIDTH));
        }
    }
}
function validate_editsponsor_form() {
    $errors = array();
    if (isset($_POST['sponsorname']) && $_POST['sponsorname']) {
        if (strlen($_POST['sponsorname']) < 2) {
            $errors[] = "Sponsor name must be at least 2 characters long.";
        }
    } else {
        $errors[] = "Sponsor name is a required field";
    }
    if (isset($_FILES['logo']['type']) && $_FILES['logo']['size'] > 0) {
        if (($_FILES['logo']['type'] != 'image/jpeg' && $_FILES['logo']['type'] != 'image/gif')) {
            $errors[] = "Logo can only be a GIF or JPEG.  Attempted file is '" . $_FILES['logo']['type'] . "'.";
        }
    }
    return $errors;
}
/*
 * Process Form Data
*/
function process_editsponsor_form($smarty) {
    global $Link;
    global $SPONSOR;
    $errors = array();
    $sname = format_doublequotes($_POST['sponsorname']);
    $surl = $_POST['sponsorurl'];
    $sabout = format_paragraph(format_doublequotes($_POST['sponsorabout']));
    $sponsorNameInsertSQL = 'UPDATE ' . SPONSORS . ' SET sponsorName="' . $sname . '", sponsorURL="' . $surl . '", sponsorAbout="' . $sabout . '"';
    if ($_FILES['logo']['size'] > 0 && ($_FILES['logo']['type'] == 'image/jpeg' || $_FILES['logo']['type'] == 'image/gif')) {
        $sponsorNameInsertSQL.= get_logo_sql_info();
    }
    $sponsorNameInsertSQL.= ' WHERE sponsorID=' . $SPONSOR;
    $sponsorNameInsertResult = mysql_query($sponsorNameInsertSQL, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    return $errors;
} // End of function
/*
 * Upload Logo
*/
function get_logo_sql_info() {
    $fileName = $_FILES['logo']['name'];
    $tmpName = $_FILES['logo']['tmp_name'];
    $fileSize = $_FILES['logo']['size'];
    $fileType = $_FILES['logo']['type'];
    $fp = fopen($tmpName, 'r');
    $content = fread($fp, $fileSize);
    $content = addslashes($content);
    fclose($fp);
    $imageSize = getimagesize($tmpName);
    $logoWidth = $imageSize[0];
    $logoHeight = $imageSize[1];
    return ', sponsorLogo="' . $content . '", sponsorLogoWidth="' . $logoWidth . '", sponsorLogoHeight="' . $logoHeight . '"';
}
?>