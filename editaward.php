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

//This page must have a award.
if(isset($_GET['award']) && $_GET['award'] > 0) {
	$AWARD = $_GET['award'];
} else if(isset($_POST['award']) && $_POST['award'] > 0) {
	$AWARD = $_POST['award'];
} else {
	header("Location: awardmanager.php");
}

$IMAGE_WIDTH = 200;
$priority = 0;

if ((isset ($_POST['action'])) && ($_POST['action'] == "Edit Award")) {
	// If form does not validate, we need to return with errors.
	if ($errors = validate_editaward_form()) {
		handle_errors($errors);
		handle_reposts();
	} else {
		// If errors occur while trying to create user, we need to return with errors.
		if ($errors = process_editaward_form($smarty)) {
			handle_errors($errors);
			handle_reposts();
		} else {
			header("Location: awardmanager.php");
		}		
	}
} else {
	get_current_award_from_db();
}

if($_POST && isset($_POST['priority']) && $_POST['priority'] > 0) {
	$priority = $_POST['priority'];
} else if($priority == 0) {
	$priority = 5;
}

$smarty->assign('page_name', 'Edit Award');
$smarty->assign('award', $AWARD);
$smarty->assign('seasonSelect', select_season());
$smarty->assign('prioritySelect', select_priority($priority));

// Build the page
require ('global_begin.php');
$smarty->display('admin/editaward.tpl');
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
	$aw = "";
	$re = "";	
	$ab = "";

	if ($_POST) {
		if ($_POST['awardName']) {
			$aw = $_POST['awardName'];
		}
		if ($_POST['recipient']) {
			$re = $_POST['recipient'];
		}		
		if ($_POST['about']) {
			$ab = $_POST['about'];
		}
		if (isset($_POST['imageWidth']) && $_POST['imageWidth'] > 0) {
			$imageWidth = $_POST['imageWidth'];
		}	else {
			$imageWidth = 0;
		}	
		if (isset($_POST['imageHeight']) && $_POST['imageHeight'] > 0) {
			$imageHeight = $_POST['imageHeight'];
		}	else {
			$imageHeight = 0;
		}	
	}
	$smarty->assign('aw', $aw);
	$smarty->assign('re', $re);	
	$smarty->assign('ab', $ab);
	
	$smarty->assign('imageWidth', $imageWidth);
	$smarty->assign('imageHeight', $imageHeight);
			
	if ($imageWidth > 0) {
	  $smarty->assign('imageSize', imageSize($imageWidth, $imageHeight, $IMAGE_WIDTH));
	}			
}

function get_current_award_from_db() {
	global $smarty;
	global $Link;
	global $AWARD;
	global $IMAGE_WIDTH;
	global $priority;
	global $SEASON;
	
	$awardSelect = 'SELECT award, seasonID, recipient, about, priority, imageWidth, imageHeight FROM '.AWARDS.' WHERE awardID='.$AWARD;
	
	$awardResult = mysql_query($awardSelect, $Link)
		or die("sp_clubs (Line ".__LINE__."): ".mysql_errno().": ".mysql_error());
	
	
	if ($awardResult && mysql_num_rows($awardResult) > 0) {
			$award = mysql_fetch_array($awardResult, MYSQL_ASSOC);

			$awardName = $award['award'];
			$SEASON = $award['seasonID'];
			$recipient = $award['recipient'];
			$priority = $award['priority'];
			$about = $award['about'];
			$imageWidth = $award['imageWidth'];
			$imageHeight = $award['imageHeight'];			
			
			$about = str_replace('<br />', '', $about);

			$smarty->assign('aw', $awardName);
			$smarty->assign('re', $recipient);
			$smarty->assign('ab', $about);
			
			$smarty->assign('imageWidth', $imageWidth);
			$smarty->assign('imageHeight', $imageHeight);
			
		  if ($imageWidth > 0) {
				$smarty->assign('imageSize', imageSize($imageWidth, $imageHeight, $IMAGE_WIDTH));
			}			
	}		
}

function validate_editaward_form() {
	$errors = array ();
	if (isset($_POST['awardName']) && $_POST['awardName']) {
		if (strlen($_POST['awardName']) < 2) {
			$errors[] = "Award name must be at least 2 characters long.";
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
  	if(($_FILES['image']['type'] != 'image/jpeg' && $_FILES['image']['type'] != 'image/gif')) {
  				$errors[] = "Logo can only be a GIF or JPEG.  Attempted file is '".$_FILES['image']['type']."'.";
  	}
  }

	return $errors;
}

/*
 * Process Form Data
 */

function process_editaward_form($smarty) {
	global $Link;
	global $AWARD;

	$errors = array();

	$award = format_doublequotes($_POST['awardName']);
	$recipient = format_doublequotes($_POST['recipient']);
	$seasonID = $_POST['season'];
	$priority = $_POST['priority'];
	$about = format_paragraph(format_doublequotes($_POST['about']));

	$awardNameUpdate = 'UPDATE '.AWARDS.' SET award="'.$award.'", recipient="'.$recipient.'", about="'.$about.'", priority="'.$priority.'", seasonID='.$seasonID.'';
  if ($_FILES['image']['size'] > 0 && ($_FILES['image']['type'] == 'image/jpeg' || $_FILES['image']['type'] == 'image/gif')) {
		$awardNameUpdate .= get_image_sql_info();
	}
  $awardNameUpdate .= ' WHERE awardID='.$AWARD;

	$awardNameResult = mysql_query($awardNameUpdate, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());

	return $errors;
} // End of function

/*
 * Upload Image
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
				
				return ', image="'.$content.'", imageWidth="'.$imageWidth.'", imageHeight="'.$imageHeight.'"';				
}


?>