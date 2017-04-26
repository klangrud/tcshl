<?php
/*
 * Created on Sep 16, 2008
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
if ((isset($_POST['action'])) && ($_POST['action'] == "Add Award")) {
    // If form does not validate, we need to return with errors.
    if ($errors = validate_addnewaward_form()) {
        handle_errors($errors);
        handle_reposts();
    } else {
        // If errors occur while trying to create user, we need to return with errors.
        if ($errors = process_addnewaward_form($smarty)) {
            handle_errors($errors);
            handle_reposts();
        } else {
            header("Location: awardmanager.php");
        }
    }
}
if ($_POST && isset($_POST['priority']) && $_POST['priority'] > 0) {
    $priority = $_POST['priority'];
} else {
    $priority = 5;
}
$smarty->assign('page_name', 'Add New Award');
$smarty->assign('seasonSelect', select_season());
$smarty->assign('prioritySelect', select_priority($priority));
// Build the page
require ('global_begin.php');
$smarty->display('admin/addnewaward.tpl');
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
    $aw = "";
    $re = "";
    $ab = "";
    if ($_POST) {
        if ($_POST['award']) {
            $aw = $_POST['award'];
        }
        if ($_POST['recipient']) {
            $re = $_POST['recipient'];
        }
        if ($_POST['about']) {
            $ab = $_POST['about'];
        }
    }
    $smarty->assign('aw', $aw);
    $smarty->assign('re', $re);
    $smarty->assign('ab', $ab);
}
function validate_addnewaward_form() {
    $errors = array();
    if (isset($_POST['award']) && $_POST['award']) {
        if (strlen($_POST['award']) < 2) {
            $errors[] = "Name of award must be at least 2 characters long.";
        }
    } else {
        $errors[] = "Award name is a required field";
    }
    if (isset($_POST['recipient']) && $_POST['recipient']) {
        if (strlen($_POST['recipient']) < 2) {
            $errors[] = "Recipient of award must be at least 2 characters long.";
        }
    } else {
        $errors[] = "Recipient of award is a required field";
    }
    if (isset($_FILES['image']['type']) && $_FILES['image']['size'] > 0) {
        if (($_FILES['image']['type'] != 'image/jpeg' && $_FILES['image']['type'] != 'image/gif')) {
            $errors[] = "Image can only be a GIF or JPEG";
        }
    }
    return $errors;
}
/*
 * Process Form Data
*/
function process_addnewaward_form($smarty) {
    global $Link;
    global $SEASON;
    $errors = array();
    $award = format_doublequotes($_POST['award']);
    $recipient = format_doublequotes($_POST['recipient']);
    $seasonID = $_POST['season'];
    $priority = $_POST['priority'];
    $about = format_paragraph(format_doublequotes($_POST['about']));
    $awardInsert = 'INSERT INTO ' . AWARDS . ' (`seasonID`, `award`, `recipient`, `priority`, `about`';
    if ($_FILES['image']['size'] > 0 && ($_FILES['image']['type'] == 'image/jpeg' || $_FILES['image']['type'] == 'image/gif')) {
        $awardInsert.= ', `image`, `imageWidth`, `imageHeight`';
    }
    $awardInsert.= ') VALUES (' . $seasonID . ', "' . $award . '", "' . $recipient . '", "' . $priority . '", "' . $about . '"';
    if ($_FILES['image']['size'] > 0 && ($_FILES['image']['type'] == 'image/jpeg' || $_FILES['image']['type'] == 'image/gif')) {
        $awardInsert.= get_image_sql_info();
    }
    $awardInsert.= ')';
    $awardResult = mysql_query($awardInsert, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    return $errors;
} // End of function
/*
 * Upload Logo
*/
function get_image_sql_info() {
    $fileName = $_FILES['image']['name'];
    $tmpName = $_FILES['image']['tmp_name'];
    $fileSize = $_FILES['image']['size'];
    $fileType = $_FILES['image']['type'];
    $fp = fopen($tmpName, 'r');
    $content = fread($fp, $fileSize);
    $content = addslashes($content);
    fclose($fp);
    $imageSize = getimagesize($tmpName);
    $imageWidth = $imageSize[0];
    $imageHeight = $imageSize[1];
    return ', "' . $content . '", "' . $imageWidth . '", "' . $imageHeight . '"';
}
?>