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


if ((isset ($_POST['action'])) && ($_POST['action'] == "Add Sponsor")) {
	// If form does not validate, we need to return with errors.
	if ($errors = validate_addnewsponsor_form()) {
		handle_errors($errors);
		handle_reposts();
	} else {
		// If errors occur while trying to create user, we need to return with errors.
		if ($errors = process_addnewsponsor_form($smarty)) {
			handle_errors($errors);
			handle_reposts();
		} else {
			header("Location: sponsors.php");
		}		
	}
}

$smarty->assign('page_name', 'Add New Sponsor');

// Build the page
require ('global_begin.php');
$smarty->display('admin/addnewsponsor.tpl');
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
	}
	$smarty->assign('sn', $sn);
	$smarty->assign('su', $su);
	$smarty->assign('sa', $sa);
}

function validate_addnewsponsor_form() {
	$errors = array ();
	if (isset($_POST['sponsorname']) && $_POST['sponsorname']) {
		if (strlen($_POST['sponsorname']) < 2) {
			$errors[] = "Sponsor name must be at least 2 characters long.";
		}
	} else {
		$errors[] = "Sponsor name is a required field";
	}
	
  if (isset($_FILES['logo']['type']) && $_FILES['logo']['size'] > 0) {
  	if(($_FILES['logo']['type'] != 'image/jpeg' && $_FILES['logo']['type'] != 'image/gif')) {
  				$errors[] = "Logo can only be a GIF or JPEG";
  	}
  }

	return $errors;
}

/*
 * Process Form Data
 */

function process_addnewsponsor_form($smarty) {
	global $Link;

	$errors = array();

	$sname = format_doublequotes($_POST['sponsorname']);
	$surl = $_POST['sponsorurl'];
	$sabout = format_paragraph(format_doublequotes($_POST['sponsorabout']));

	$sponsorNameInsertSQL = 'INSERT INTO '.SPONSORS.' (`sponsorName`, `sponsorURL`, `sponsorAbout`';
  if ($_FILES['logo']['size'] > 0 && ($_FILES['logo']['type'] == 'image/jpeg' || $_FILES['logo']['type'] == 'image/gif')) {
		$sponsorNameInsertSQL .= ', `sponsorLogo`, `sponsorLogoWidth`, `sponsorLogoHeight`';
	}
	$sponsorNameInsertSQL .= ') VALUES ("'.$sname.'", "'.$surl.'", "'.$sabout.'"';
  if ($_FILES['logo']['size'] > 0 && ($_FILES['logo']['type'] == 'image/jpeg' || $_FILES['logo']['type'] == 'image/gif')) {
		$sponsorNameInsertSQL .= get_logo_sql_info();
	}
  $sponsorNameInsertSQL .= ')';

	$sponsorNameInsertResult = mysql_query($sponsorNameInsertSQL, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());

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
				
				return ', "'.$content.'", "'.$logoWidth.'", "'.$logoHeight.'"';				
}


?>