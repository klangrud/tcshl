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
if ($_GET) {
    if (isset($_GET['id']) && $_GET['id'] > 0 && idCheck_paymentDB($_GET['id'], 3)) {
        $id = $_GET['id'];
    } else {
        header("Location: paymentmanager.php");
    }
    if (isset($_GET['success']) && $_GET['success'] == 'yes') {
        $success = array();
        $success[] = 'You have successfully updated payments for current person.';
        handle_success($success);
    }
}
if ($_POST) {
    if (isset($_POST['id']) && $_POST['id'] > 0) {
        $id = $_POST['id'];
    } else {
        header("Location: paymentmanager.php");
    }
}
$P3_AUDIT = $_SESSION['userid'];
$P3_NAME = get_registrant_name($id);
$P3_ID = $id;
$P3_PAY1_PROCESS = '';
$P3_PAY1_DATE = '';
$P3_PAY1_DATE_DB = '';
$P3_PAY1_DATE_SELECT = '';
$P3_PAY1_CHECK = '';
$P3_PAY2_PROCESS = '';
$P3_PAY2_DATE = '';
$P3_PAY2_DATE_DB = '';
$P3_PAY2_DATE_SELECT = '';
$P3_PAY2_CHECK = '';
$P3_PAY3_PROCESS = '';
$P3_PAY3_DATE = '';
$P3_PAY3_DATE_DB = '';
$P3_PAY3_DATE_SELECT = '';
$P3_PAY3_CHECK = '';
$PAYMENT_DATE_1 = '';
$PAYMENT_DATE_2 = '';
$PAYMENT_DATE_3 = '';
initialize_payment_dates($SEASON);
$smarty->assign('daysToFirstPayment', get_payment_date_difference(1));
$smarty->assign('daysToSecondPayment', get_payment_date_difference(2));
$smarty->assign('daysToThirdPayment', get_payment_date_difference(3));
if ((isset($_POST['action'])) && ($_POST['action'] == "Edit Payments")) {
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
            header("Location: editpaymentplan3.php?id={$P3_ID}&success=yes");
        }
    }
} else {
    populateFieldsFromDatabase();
}
format_date_fields();
$smarty->assign('P3_AUDIT', $P3_AUDIT);
$smarty->assign('P3_NAME', $P3_NAME);
$smarty->assign('P3_ID', $P3_ID);
$smarty->assign('P3_PAY1_PROCESS', $P3_PAY1_PROCESS);
$smarty->assign('P3_PAY1_DATE_SELECT', $P3_PAY1_DATE_SELECT);
$smarty->assign('P3_PAY1_DATE', $P3_PAY1_DATE);
$smarty->assign('P3_PAY1_DATE_DB', $P3_PAY1_DATE_DB);
$smarty->assign('P3_PAY1_CHECK', $P3_PAY1_CHECK);
$smarty->assign('P3_PAY2_PROCESS', $P3_PAY2_PROCESS);
$smarty->assign('P3_PAY2_DATE_SELECT', $P3_PAY2_DATE_SELECT);
$smarty->assign('P3_PAY2_DATE', $P3_PAY2_DATE);
$smarty->assign('P3_PAY2_DATE_DB', $P3_PAY2_DATE_DB);
$smarty->assign('P3_PAY2_CHECK', $P3_PAY2_CHECK);
$smarty->assign('P3_PAY3_PROCESS', $P3_PAY3_PROCESS);
$smarty->assign('P3_PAY3_DATE_SELECT', $P3_PAY3_DATE_SELECT);
$smarty->assign('P3_PAY3_DATE', $P3_PAY3_DATE);
$smarty->assign('P3_PAY3_DATE_DB', $P3_PAY3_DATE_DB);
$smarty->assign('P3_PAY3_CHECK', $P3_PAY3_CHECK);
// Build the page
require ('global_begin.php');
$smarty->display('admin/editpaymentplan3.tpl');
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
    global $P3_ID;
    global $P3_PAY1_DATE;
    global $P3_PAY1_DATE_DB;
    global $P3_PAY1_CHECK;
    global $P3_PAY2_DATE;
    global $P3_PAY2_DATE_DB;
    global $P3_PAY2_CHECK;
    global $P3_PAY3_DATE;
    global $P3_PAY3_DATE_DB;
    global $P3_PAY3_CHECK;
    $select = 'SELECT * FROM ' . PAYMENTPLANTHREE . ' WHERE registrationID=' . $P3_ID;
    $result = mysql_query($select, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($result && mysql_num_rows($result) > 0) {
        $p3 = mysql_fetch_assoc($result);
        //$rName = $p3['fName'].' '.$p3['lName'];
        $P3_PAY1_DATE = $p3['paymentOneDate'];
        $P3_PAY1_DATE_DB = $p3['paymentOneDate'];
        $P3_PAY1_CHECK = $p3['p1_checknum'];
        $P3_PAY2_DATE = $p3['paymentTwoDate'];
        $P3_PAY2_DATE_DB = $p3['paymentTwoDate'];
        $P3_PAY2_CHECK = $p3['p2_checknum'];
        $P3_PAY3_DATE = $p3['paymentThreeDate'];
        $P3_PAY3_DATE_DB = $p3['paymentThreeDate'];
        $P3_PAY3_CHECK = $p3['p3_checknum'];
    }
}
function format_date_fields() {
    global $P3_PAY1_DATE;
    global $P3_PAY2_DATE;
    global $P3_PAY3_DATE;
    global $P3_PAY1_DATE_SELECT;
    global $P3_PAY2_DATE_SELECT;
    global $P3_PAY3_DATE_SELECT;
    $P3_PAY1_DATE_SELECT = select_payment_month('p3_pay1_month', $P3_PAY1_DATE) . select_payment_day('p3_pay1_day', $P3_PAY1_DATE) . select_payment_year('p3_pay1_year', $P3_PAY1_DATE);
    $P3_PAY2_DATE_SELECT = select_payment_month('p3_pay2_month', $P3_PAY2_DATE) . select_payment_day('p3_pay2_day', $P3_PAY2_DATE) . select_payment_year('p3_pay2_year', $P3_PAY2_DATE);
    $P3_PAY3_DATE_SELECT = select_payment_month('p3_pay3_month', $P3_PAY3_DATE) . select_payment_day('p3_pay3_day', $P3_PAY3_DATE) . select_payment_year('p3_pay3_year', $P3_PAY3_DATE);
}
function handle_reposts() {
    global $P3_PAY1_DATE;
    global $P3_PAY1_DATE_DB;
    global $P3_PAY1_CHECK;
    global $P3_PAY2_DATE;
    global $P3_PAY2_DATE_DB;
    global $P3_PAY2_CHECK;
    global $P3_PAY3_DATE;
    global $P3_PAY3_DATE_DB;
    global $P3_PAY3_CHECK;
    $P3_PAY1_DATE = $_POST['p3_pay1_year'] . '-' . $_POST['p3_pay1_month'] . '-' . $_POST['p3_pay1_day'] . ' 00:00:00';
    $P3_PAY2_DATE = $_POST['p3_pay2_year'] . '-' . $_POST['p3_pay2_month'] . '-' . $_POST['p3_pay2_day'] . ' 00:00:00';
    $P3_PAY3_DATE = $_POST['p3_pay3_year'] . '-' . $_POST['p3_pay3_month'] . '-' . $_POST['p3_pay3_day'] . ' 00:00:00';
    $P3_PAY1_DATE_DB = $_POST['p3_pay1_date_db'];
    $P3_PAY2_DATE_DB = $_POST['p3_pay2_date_db'];
    $P3_PAY3_DATE_DB = $_POST['p3_pay3_date_db'];
    $P3_PAY1_CHECK = $_POST['p1_checknum'];
    $P3_PAY2_CHECK = $_POST['p2_checknum'];
    $P3_PAY3_CHECK = $_POST['p3_checknum'];
}
function initialize_payment_dates($season) {
    global $Link;
    global $PAYMENT_DATE_1;
    global $PAYMENT_DATE_2;
    global $PAYMENT_DATE_3;
    $select = 'SELECT paymentOneDate, paymentTwoDate, paymentThreeDate FROM ' . PAYMENTDATESALT . ' WHERE seasonID=' . $season;
    $result = mysql_query($select, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($result && mysql_num_rows($result) > 0) {
        $paymentdates = mysql_fetch_assoc($result);
        $PAYMENT_DATE_1 = $paymentdates['paymentOneDate'];
        $PAYMENT_DATE_2 = $paymentdates['paymentTwoDate'];
        $PAYMENT_DATE_3 = $paymentdates['paymentThreeDate'];
    }
}
function get_payment_date_difference($paymentDate) {
    global $PAYMENT_DATE_1;
    global $PAYMENT_DATE_2;
    global $PAYMENT_DATE_3;
    $today = time();
    if ($paymentDate == 1) {
        $diff = intval((((get_epoch($PAYMENT_DATE_1) - $today) / 60) / 60) / 24);
    } else if ($paymentDate == 2) {
        $diff = intval((((get_epoch($PAYMENT_DATE_2) - $today) / 60) / 60) / 24);
    } else if ($paymentDate == 3) {
        $diff = intval((((get_epoch($PAYMENT_DATE_3) - $today) / 60) / 60) / 24);
    }
    return $diff;
}
function get_epoch($timestamp) {
    $year = substr($timestamp, 0, 4);
    $month = substr($timestamp, 5, 2);
    $day = substr($timestamp, 8, 2);
    $hour = substr($timestamp, 11, 2);
    $minute = substr($timestamp, 14, 2);
    $second = substr($timestamp, 17, 2);
    return mktime($hour, $minute, $second, $month, $day, $year);
}
function validate_payments_form() {
    $errors = array();
    if (isset($_POST['update1']) && $_POST['update1'] == "YES" || isset($_POST['update2']) && $_POST['update2'] == "YES" || isset($_POST['update3']) && $_POST['update3'] == "YES") {
        // At least one is checked
        
    } else {
        $errors[] = 'Please choose at least one payment to edit by checking the appropriate box.';
    }
    return $errors;
}
function process_payments_form() {
    global $Link;
    global $P3_ID;
    global $P3_AUDIT;
    $countComma = 1;
    $update = 'UPDATE ' . PAYMENTPLANTHREE . ' SET ';
    if (isset($_POST['update1']) && $_POST['update1'] == "YES") {
        $value1 = $_POST['p3_pay1_year'] . '-' . $_POST['p3_pay1_month'] . '-' . $_POST['p3_pay1_day'] . ' 00:00:00';
        $value2 = $_POST['p1_checknum'];
        $update.= ' paymentOneDate="' . $value1 . '"@' . $countComma . '@ ';
        $countComma++;
        $update.= ' p1_checknum="' . $value2 . '"@' . $countComma . '@ ';
        $countComma++;
        $update.= ' audit1="' . $P3_AUDIT . '"@' . $countComma . '@ ';
        $countComma++;
    }
    if (isset($_POST['update2']) && $_POST['update2'] == "YES") {
        $value1 = $_POST['p3_pay2_year'] . '-' . $_POST['p3_pay2_month'] . '-' . $_POST['p3_pay2_day'] . ' 00:00:00';
        $value2 = $_POST['p2_checknum'];
        $update.= ' paymentTwoDate="' . $value1 . '"@' . $countComma . '@ ';
        $countComma++;
        $update.= ' p2_checknum="' . $value2 . '"@' . $countComma . '@ ';
        $countComma++;
        $update.= ' audit2="' . $P3_AUDIT . '"@' . $countComma . '@ ';
        $countComma++;
    }
    if (isset($_POST['update3']) && $_POST['update3'] == "YES") {
        $value1 = $_POST['p3_pay3_year'] . '-' . $_POST['p3_pay3_month'] . '-' . $_POST['p3_pay3_day'] . ' 00:00:00';
        $value2 = $_POST['p3_checknum'];
        $update.= ' paymentThreeDate="' . $value1 . '"@' . $countComma . '@ ';
        $countComma++;
        $update.= ' p3_checknum="' . $value2 . '"@' . $countComma . '@ ';
        $countComma++;
        $update.= ' audit3="' . $P3_AUDIT . '"@' . $countComma . '@ ';
        $countComma++;
    }
    $update.= ' WHERE registrationID=' . $P3_ID;
    $update = str_replace('@' . ($countComma - 1) . '@', '', $update);
    for ($i = 1;$i < $countComma - 1;$i++) {
        $update = str_replace('@' . $i . '@', ',', $update);
    }
    mysql_query($update, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
}
// *************************MONTH PULL DOWN MENU*************************
function select_payment_month($name = "", $timestamp = "") {
    if (strlen($timestamp) < 1) {
        $timestamp = date('Y') . '-' . date('m') . '-' . date('d') . ' 00:00:00';
    }
    $monthSelected = substr($timestamp, 5, 2);
    $month = '<select name="' . $name . '">';
    $month.= '<option value="01">Jan</option>';
    $month.= '<option value="02">Feb</option>';
    $month.= '<option value="03">Mar</option>';
    $month.= '<option value="04">Apr</option>';
    $month.= '<option value="05">May</option>';
    $month.= '<option value="06">Jun</option>';
    $month.= '<option value="07">Jul</option>';
    $month.= '<option value="08">Aug</option>';
    $month.= '<option value="09">Sep</option>';
    $month.= '<option value="10">Oct</option>';
    $month.= '<option value="11">Nov</option>';
    $month.= '<option value="12">Dec</option>';
    $month.= '</select>';
    if (strlen($monthSelected) > 0) {
        $month = str_replace('value="' . $monthSelected . '"', 'value="' . $monthSelected . '" selected="selected"', $month);
    }
    return $month;
}
// *************************DAY PULL DOWN MENU*************************
function select_payment_day($name = "", $timestamp = "") {
    if (strlen($timestamp) < 1) {
        $timestamp = date('Y') . '-' . date('m') . '-' . date('d') . ' 00:00:00';
    }
    $daySelected = substr($timestamp, 8, 2);
    $day = '<select name="' . $name . '">';
    $day.= '<option value="01">1</option>';
    $day.= '<option value="02">2</option>';
    $day.= '<option value="03">3</option>';
    $day.= '<option value="04">4</option>';
    $day.= '<option value="05">5</option>';
    $day.= '<option value="06">6</option>';
    $day.= '<option value="07">7</option>';
    $day.= '<option value="08">8</option>';
    $day.= '<option value="09">9</option>';
    $day.= '<option value="10">10</option>';
    $day.= '<option value="11">11</option>';
    $day.= '<option value="12">12</option>';
    $day.= '<option value="13">13</option>';
    $day.= '<option value="14">14</option>';
    $day.= '<option value="15">15</option>';
    $day.= '<option value="16">16</option>';
    $day.= '<option value="17">17</option>';
    $day.= '<option value="18">18</option>';
    $day.= '<option value="19">19</option>';
    $day.= '<option value="20">20</option>';
    $day.= '<option value="21">21</option>';
    $day.= '<option value="22">22</option>';
    $day.= '<option value="23">23</option>';
    $day.= '<option value="24">24</option>';
    $day.= '<option value="25">25</option>';
    $day.= '<option value="26">26</option>';
    $day.= '<option value="27">27</option>';
    $day.= '<option value="28">28</option>';
    $day.= '<option value="29">29</option>';
    $day.= '<option value="30">30</option>';
    $day.= '<option value="31">31</option>';
    $day.= "</select>";
    if (strlen($daySelected) > 0) {
        $day = str_replace('value="' . $daySelected . '"', 'value="' . $daySelected . '" selected="selected"', $day);
    }
    return $day;
}
// *************************YEAR PULL DOWN MENU*************************
function select_payment_year($name = "", $timestamp = "") {
    if (strlen($timestamp) < 1) {
        $timestamp = date('Y') . '-' . date('m') . '-' . date('d') . ' 00:00:00';
    }
    $yearSelected = substr($timestamp, 0, 4);
    $first_year = '2007';
    $this_year = date("Y");
    $year = '<select name="' . $name . '">';
    for ($i = ($first_year);$i <= ($this_year + 1);$i++) {
        $year.= '<option value="' . $i . '">' . $i . '</option>';
    }
    $year.= '</select>';
    if (strlen($yearSelected) > 0) {
        $year = str_replace('value="' . $yearSelected . '"', 'value="' . $yearSelected . '" selected="selected"', $year);
    }
    return $year;
}
?>
