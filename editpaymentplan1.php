<?php
/*
 * Created on Sep 4, 2008
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

$smarty->assign('PAGE_NAME', 'Edit Payments');

$id = 0;
if($_GET) {
	if(isset($_GET['id']) && $_GET['id'] > 0 && idCheck_paymentDB($_GET['id'],1)) {
		$id = $_GET['id'];
	} else {
		header("Location: paymentmanager.php");
	}	
	if(isset($_GET['success']) && $_GET['success'] == 'yes') {
		$success = array();
		$success[] = 'You have successfully updated payments for current person.';
		handle_success($success);
	}		
}

if($_POST) {
	if(isset($_POST['id']) && $_POST['id'] > 0) {
		$id = $_POST['id'];
	} else {
		header("Location: paymentmanager.php");
	}	
}

$P1_AUDIT = $_SESSION['userid'];
$P1_NAME = get_registrant_name($id);
$P1_ID = $id;
$P1_PAY1_PROCESS = '';
$P1_PAY1_DATE = '';
$P1_PAY1_DATE_DB = '';
$P1_PAY1_DATE_SELECT = '';
$P1_PAY1_CHECK = '';


$PAYMENT_DATE_1 = '';
initialize_payment_dates($SEASON);
$smarty->assign('daysToFirstPayment', get_payment_date_difference(1));


if ((isset ($_POST['action'])) && ($_POST['action'] == "Edit Payments")) {
	// If form does not validate, we need to return with errors.
	if ($errors = validate_payments_form()) {
		handle_errors($errors);
		handle_reposts();
	} else {
		// If errors occur while trying to create user, we need to return with errors.
		if ($errors = process_payments_form()) {
			handle_errors($errors);
			handle_reposts();
		} else {
			header("Location: editpaymentplan1.php?id={$P1_ID}&success=yes");
		}		
	}
} else {
	populateFieldsFromDatabase();
}

format_date_fields();

$smarty->assign('P1_AUDIT', $P1_AUDIT);
$smarty->assign('P1_NAME', $P1_NAME);
$smarty->assign('P1_ID', $P1_ID);
$smarty->assign('P1_PAY1_PROCESS', $P1_PAY1_PROCESS);
$smarty->assign('P1_PAY1_DATE_SELECT', $P1_PAY1_DATE_SELECT);
$smarty->assign('P1_PAY1_DATE', $P1_PAY1_DATE);
$smarty->assign('P1_PAY1_DATE_DB', $P1_PAY1_DATE_DB);
$smarty->assign('P1_PAY1_CHECK', $P1_PAY1_CHECK);

// Build the page
require ('global_begin.php');
$smarty->display('admin/editpaymentplan1.tpl');
require ('global_end.php');

/*
* ********************************************************************************
* ********************************************************************************
* **************************L O C A L  F U N C T I O N S**************************
* ********************************************************************************
* ********************************************************************************
*/

function populateFieldsFromDatabase() {
  global $Link;
  global $P1_ID;
  global $P1_PAY1_DATE;
  global $P1_PAY1_DATE_DB;
  global $P1_PAY1_CHECK;


  $select = 'SELECT * FROM '.PAYMENTPLANONE.' WHERE registrationID='.$P1_ID;
  
	$result = mysql_query($select, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	if ($result && mysql_num_rows($result) > 0) {
		$p1 = mysql_fetch_assoc($result);
		//$rName = $p1['fName'].' '.$p1['lName'];
  	$P1_PAY1_DATE = $p1['paymentOneDate'];
  	$P1_PAY1_DATE_DB = $p1['paymentOneDate'];  	
  	$P1_PAY1_CHECK = $p1['p1_checknum'];	
	}  
}

function format_date_fields() {
  global $P1_PAY1_DATE;
  global $P1_PAY1_DATE_SELECT; 
  
  $P1_PAY1_DATE_SELECT = select_payment_month('p1_pay1_month',$P1_PAY1_DATE).select_payment_day('p1_pay1_day',$P1_PAY1_DATE).select_payment_year('p1_pay1_year',$P1_PAY1_DATE);  
}

function handle_reposts() {
  global $P1_PAY1_DATE;
  global $P1_PAY1_DATE_DB;  
  global $P1_PAY1_CHECK;
  
  $P1_PAY1_DATE = $_POST['p1_pay1_year'].'-'.$_POST['p1_pay1_month'].'-'.$_POST['p1_pay1_day'].' 00:00:00';

  $P1_PAY1_DATE_DB = $_POST['p1_pay1_date_db'];

	$P1_PAY1_CHECK = $_POST['p1_checknum'];
  	
}

function initialize_payment_dates($season) {
	global $Link;
	global $PAYMENT_DATE_1;
	
	$select = 'SELECT paymentOneDate FROM '.PAYMENTDATES.' WHERE seasonID='.$season;


	$result = mysql_query($select, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
	if ($result && mysql_num_rows($result) > 0) {
	  $paymentdates = mysql_fetch_assoc($result);	
	  
			$PAYMENT_DATE_1 = $paymentdates['paymentOneDate']; 
	}
}

function get_payment_date_difference($paymentDate) {
  global $PAYMENT_DATE_1;
	global $PAYMENT_DATE_3;
	$today = time();
	
	if($paymentDate == 1) {
		$diff = intval((((get_epoch($PAYMENT_DATE_1) - $today) / 60) / 60) / 24);
	} else if($paymentDate == 3) {
		$diff = intval((((get_epoch($PAYMENT_DATE_3) - $today) / 60) / 60) / 24);
	}
	
	return $diff;
}

function get_epoch($timestamp) {
	$year=substr($timestamp,0,4);
	$month=substr($timestamp,5,2);
	$day=substr($timestamp,8,2);
	$hour=substr($timestamp,11,2);
	$minute=substr($timestamp,14,2);
	$second=substr($timestamp,17,2);
	return mktime($hour,$minute,$second,$month,$day,$year);	
}

function validate_payments_form() {
	$errors = array();
	if(isset($_POST['update1']) && $_POST['update1'] == "YES") {
		// Update checkbox is checked.
	}	else {
		$errors[] = 'Please check update box to update.';
	}
	return $errors;
}

function process_payments_form() {
	global $Link;
	global $P1_ID;
	global $P1_AUDIT;
	
	$update = 'UPDATE '.PAYMENTPLANONE.' SET ';
	
	if(isset($_POST['update1']) && $_POST['update1'] == "YES") {
		$value1 = $_POST['p1_pay1_year'].'-'.$_POST['p1_pay1_month'].'-'.$_POST['p1_pay1_day'].' 00:00:00';
		$value2 = $_POST['p1_checknum'];
		$update .= ' paymentOneDate="'.$value1.'", ';
		$update .= ' p1_checknum="'.$value2.'", ';
		$update .= ' audit1="'.$P1_AUDIT.'"';	
	}
	
	$update .= ' WHERE registrationID='.$P1_ID;
	
	mysql_query($update, $Link)
		or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
	
}


// *************************MONTH PULL DOWN MENU*************************
function select_payment_month($name = "", $timestamp = "") {
if(strlen($timestamp) < 1) {
	$timestamp = date('Y').'-'.date('m').'-'.date('d').' 00:00:00';
}
$monthSelected = substr($timestamp,5,2);

$month = '<select name="'.$name.'">';
$month .= '<option value="01">Jan</option>';
$month .= '<option value="02">Feb</option>';
$month .= '<option value="03">Mar</option>';
$month .= '<option value="04">Apr</option>';
$month .= '<option value="05">May</option>';
$month .= '<option value="06">Jun</option>';
$month .= '<option value="07">Jul</option>';
$month .= '<option value="08">Aug</option>';
$month .= '<option value="09">Sep</option>';
$month .= '<option value="10">Oct</option>';
$month .= '<option value="11">Nov</option>';
$month .= '<option value="12">Dec</option>';
$month .= '</select>';

if(strlen($monthSelected) > 0) {
	$month = str_replace('value="'.$monthSelected.'"', 'value="'.$monthSelected.'" selected="selected"' ,$month);
}

return $month;	
}

// *************************DAY PULL DOWN MENU*************************
function select_payment_day($name = "", $timestamp = "") {
if(strlen($timestamp) < 1) {
	$timestamp = date('Y').'-'.date('m').'-'.date('d').' 00:00:00';
}
$daySelected = substr($timestamp,8,2);

$day = '<select name="'.$name.'">';
$day .= '<option value="01">1</option>';
$day .= '<option value="02">2</option>';
$day .= '<option value="03">3</option>';
$day .= '<option value="04">4</option>';
$day .= '<option value="05">5</option>';
$day .= '<option value="06">6</option>';
$day .= '<option value="07">7</option>';
$day .= '<option value="08">8</option>';
$day .= '<option value="09">9</option>';
$day .= '<option value="10">10</option>';
$day .= '<option value="11">11</option>';
$day .= '<option value="12">12</option>';
$day .= '<option value="13">13</option>';
$day .= '<option value="14">14</option>';
$day .= '<option value="15">15</option>';
$day .= '<option value="16">16</option>';
$day .= '<option value="17">17</option>';
$day .= '<option value="18">18</option>';
$day .= '<option value="19">19</option>';
$day .= '<option value="20">20</option>';
$day .= '<option value="21">21</option>';
$day .= '<option value="22">22</option>';
$day .= '<option value="23">23</option>';
$day .= '<option value="24">24</option>';
$day .= '<option value="25">25</option>';
$day .= '<option value="26">26</option>';
$day .= '<option value="27">27</option>';
$day .= '<option value="28">28</option>';
$day .= '<option value="29">29</option>';
$day .= '<option value="30">30</option>';
$day .= '<option value="31">31</option>';
$day .= "</select>";

if(strlen($daySelected) > 0) {
	$day = str_replace('value="'.$daySelected.'"', 'value="'.$daySelected.'" selected="selected"' ,$day);
}
return $day;	
}


// *************************YEAR PULL DOWN MENU*************************
function select_payment_year($name = "", $timestamp = "") {
if(strlen($timestamp) < 1) {
	$timestamp = date('Y').'-'.date('m').'-'.date('d').' 00:00:00';
}
$yearSelected = substr($timestamp,0,4);

$first_year = '2007';
$this_year = date("Y");

	$year = '<select name="'.$name.'">';

for($i = ($first_year); $i <= ($this_year + 1); $i++) {
	$year .= '<option value="'.$i.'">'.$i.'</option>';
}

$year .= '</select>';

if(strlen($yearSelected) > 0) {
	$year = str_replace('value="'.$yearSelected.'"', 'value="'.$yearSelected.'" selected="selected"' ,$year);
}

return $year;	
}
?>
