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
    if (isset($_GET['id']) && $_GET['id'] > 0 && idCheck_paymentDB($_GET['id'], 4)) {
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
$P4_AUDIT = $_SESSION['userid'];
$P4_NAME = get_registrant_name($id);
$P4_ID = $id;
$P4_PAY1_PROCESS = '';
$P4_PAY1_DATE = '';
$P4_PAY1_DATE_DB = '';
$P4_PAY1_DATE_SELECT = '';
$P4_PAY1_CHECK = '';
$P4_PAY2_PROCESS = '';
$P4_PAY2_DATE = '';
$P4_PAY2_DATE_DB = '';
$P4_PAY2_DATE_SELECT = '';
$P4_PAY2_CHECK = '';
$P4_PAY3_PROCESS = '';
$P4_PAY3_DATE = '';
$P4_PAY3_DATE_DB = '';
$P4_PAY3_DATE_SELECT = '';
$P4_PAY3_CHECK = '';
$P4_PAY4_PROCESS = '';
$P4_PAY4_DATE = '';
$P4_PAY4_DATE_DB = '';
$P4_PAY4_DATE_SELECT = '';
$P4_PAY4_CHECK = '';
$PAYMENT_DATE_1 = '';
$PAYMENT_DATE_2 = '';
$PAYMENT_DATE_3 = '';
$PAYMENT_DATE_4 = '';
initialize_payment_dates($SEASON);
$smarty->assign('daysToFirstPayment', get_payment_date_difference(1));
$smarty->assign('daysToSecondPayment', get_payment_date_difference(2));
$smarty->assign('daysToThirdPayment', get_payment_date_difference(3));
$smarty->assign('daysToFourthPayment', get_payment_date_difference(4));
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
            header("Location: editpaymentplan4.php?id={$P4_ID}&success=yes");
        }
    }
} else {
    populateFieldsFromDatabase();
}
format_date_fields();
$smarty->assign('P4_AUDIT', $P4_AUDIT);
$smarty->assign('P4_NAME', $P4_NAME);
$smarty->assign('P4_ID', $P4_ID);
$smarty->assign('P4_PAY1_PROCESS', $P4_PAY1_PROCESS);
$smarty->assign('P4_PAY1_DATE_SELECT', $P4_PAY1_DATE_SELECT);
$smarty->assign('P4_PAY1_DATE', $P4_PAY1_DATE);
$smarty->assign('P4_PAY1_DATE_DB', $P4_PAY1_DATE_DB);
$smarty->assign('P4_PAY1_CHECK', $P4_PAY1_CHECK);
$smarty->assign('P4_PAY2_PROCESS', $P4_PAY2_PROCESS);
$smarty->assign('P4_PAY2_DATE_SELECT', $P4_PAY2_DATE_SELECT);
$smarty->assign('P4_PAY2_DATE', $P4_PAY2_DATE);
$smarty->assign('P4_PAY2_DATE_DB', $P4_PAY2_DATE_DB);
$smarty->assign('P4_PAY2_CHECK', $P4_PAY2_CHECK);
$smarty->assign('P4_PAY3_PROCESS', $P4_PAY3_PROCESS);
$smarty->assign('P4_PAY3_DATE_SELECT', $P4_PAY3_DATE_SELECT);
$smarty->assign('P4_PAY3_DATE', $P4_PAY3_DATE);
$smarty->assign('P4_PAY3_DATE_DB', $P4_PAY3_DATE_DB);
$smarty->assign('P4_PAY3_CHECK', $P4_PAY3_CHECK);
$smarty->assign('P4_PAY4_PROCESS', $P4_PAY4_PROCESS);
$smarty->assign('P4_PAY4_DATE_SELECT', $P4_PAY4_DATE_SELECT);
$smarty->assign('P4_PAY4_DATE', $P4_PAY4_DATE);
$smarty->assign('P4_PAY4_DATE_DB', $P4_PAY4_DATE_DB);
$smarty->assign('P4_PAY4_CHECK', $P4_PAY4_CHECK);
// Build the page
require ('global_begin.php');
$smarty->display('admin/editpaymentplan4.tpl');
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
    global $P4_ID;
    global $P4_PAY1_DATE;
    global $P4_PAY1_DATE_DB;
    global $P4_PAY1_CHECK;
    global $P4_PAY2_DATE;
    global $P4_PAY2_DATE_DB;
    global $P4_PAY2_CHECK;
    global $P4_PAY3_DATE;
    global $P4_PAY3_DATE_DB;
    global $P4_PAY3_CHECK;
    global $P4_PAY4_DATE;
    global $P4_PAY4_DATE_DB;
    global $P4_PAY4_CHECK;
    $select = 'SELECT * FROM ' . PAYMENTPLANFOUR . ' WHERE registrationID=' . $P4_ID;
    $result = mysql_query($select, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($result && mysql_num_rows($result) > 0) {
        $p4 = mysql_fetch_assoc($result);
        //$rName = $p4['fName'].' '.$p4['lName'];
        $P4_PAY1_DATE = $p4['paymentOneDate'];
        $P4_PAY1_DATE_DB = $p4['paymentOneDate'];
        $P4_PAY1_CHECK = $p4['p1_checknum'];
        $P4_PAY2_DATE = $p4['paymentTwoDate'];
        $P4_PAY2_DATE_DB = $p4['paymentTwoDate'];
        $P4_PAY2_CHECK = $p4['p2_checknum'];
        $P4_PAY3_DATE = $p4['paymentThreeDate'];
        $P4_PAY3_DATE_DB = $p4['paymentThreeDate'];
        $P4_PAY3_CHECK = $p4['p3_checknum'];
        $P4_PAY4_DATE = $p4['paymentFourDate'];
        $P4_PAY4_DATE_DB = $p4['paymentFourDate'];
        $P4_PAY4_CHECK = $p4['p4_checknum'];
    }
}
function format_date_fields() {
    global $P4_PAY1_DATE;
    global $P4_PAY2_DATE;
    global $P4_PAY3_DATE;
    global $P4_PAY4_DATE;
    global $P4_PAY1_DATE_SELECT;
    global $P4_PAY2_DATE_SELECT;
    global $P4_PAY3_DATE_SELECT;
    global $P4_PAY4_DATE_SELECT;
    $P4_PAY1_DATE_SELECT = select_payment_month('p4_pay1_month', $P4_PAY1_DATE) . select_payment_day('p4_pay1_day', $P4_PAY1_DATE) . select_payment_year('p4_pay1_year', $P4_PAY1_DATE);
    $P4_PAY2_DATE_SELECT = select_payment_month('p4_pay2_month', $P4_PAY2_DATE) . select_payment_day('p4_pay2_day', $P4_PAY2_DATE) . select_payment_year('p4_pay2_year', $P4_PAY2_DATE);
    $P4_PAY3_DATE_SELECT = select_payment_month('p4_pay3_month', $P4_PAY3_DATE) . select_payment_day('p4_pay3_day', $P4_PAY3_DATE) . select_payment_year('p4_pay3_year', $P4_PAY3_DATE);
    $P4_PAY4_DATE_SELECT = select_payment_month('p4_pay4_month', $P4_PAY4_DATE) . select_payment_day('p4_pay4_day', $P4_PAY4_DATE) . select_payment_year('p4_pay4_year', $P4_PAY4_DATE);
}
function handle_reposts() {
    global $P4_PAY1_DATE;
    global $P4_PAY1_DATE_DB;
    global $P4_PAY1_CHECK;
    global $P4_PAY2_DATE;
    global $P4_PAY2_DATE_DB;
    global $P4_PAY2_CHECK;
    global $P4_PAY3_DATE;
    global $P4_PAY3_DATE_DB;
    global $P4_PAY3_CHECK;
    global $P4_PAY4_DATE;
    global $P4_PAY4_DATE_DB;
    global $P4_PAY4_CHECK;
    $P4_PAY1_DATE = $_POST['p4_pay1_year'] . '-' . $_POST['p4_pay1_month'] . '-' . $_POST['p4_pay1_day'] . ' 00:00:00';
    $P4_PAY2_DATE = $_POST['p4_pay2_year'] . '-' . $_POST['p4_pay2_month'] . '-' . $_POST['p4_pay2_day'] . ' 00:00:00';
    $P4_PAY3_DATE = $_POST['p4_pay3_year'] . '-' . $_POST['p4_pay3_month'] . '-' . $_POST['p4_pay3_day'] . ' 00:00:00';
    $P4_PAY4_DATE = $_POST['p4_pay4_year'] . '-' . $_POST['p4_pay4_month'] . '-' . $_POST['p4_pay4_day'] . ' 00:00:00';
    $P4_PAY1_DATE_DB = $_POST['p4_pay1_date_db'];
    $P4_PAY2_DATE_DB = $_POST['p4_pay2_date_db'];
    $P4_PAY3_DATE_DB = $_POST['p4_pay3_date_db'];
    $P4_PAY4_DATE_DB = $_POST['p4_pay4_date_db'];
    $P4_PAY1_CHECK = $_POST['p1_checknum'];
    $P4_PAY2_CHECK = $_POST['p2_checknum'];
    $P4_PAY3_CHECK = $_POST['p3_checknum'];
    $P4_PAY4_CHECK = $_POST['p4_checknum'];
}
function initialize_payment_dates($season) {
    global $Link;
    global $PAYMENT_DATE_1;
    global $PAYMENT_DATE_2;
    global $PAYMENT_DATE_3;
    global $PAYMENT_DATE_4;
    $select = 'SELECT paymentOneDate, paymentTwoDate, paymentThreeDate, paymentFourDate FROM ' . PAYMENTDATES . ' WHERE seasonID=' . $season;
    $result = mysql_query($select, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($result && mysql_num_rows($result) > 0) {
        $paymentdates = mysql_fetch_assoc($result);
        $PAYMENT_DATE_1 = $paymentdates['paymentOneDate'];
        $PAYMENT_DATE_2 = $paymentdates['paymentTwoDate'];
        $PAYMENT_DATE_3 = $paymentdates['paymentThreeDate'];
        $PAYMENT_DATE_4 = $paymentdates['paymentFourDate'];
    }
}
function get_payment_date_difference($paymentDate) {
    global $PAYMENT_DATE_1;
    global $PAYMENT_DATE_2;
    global $PAYMENT_DATE_3;
    global $PAYMENT_DATE_4;
    $today = time();
    if ($paymentDate == 1) {
        $diff = intval((((get_epoch($PAYMENT_DATE_1) - $today) / 60) / 60) / 24);
    } else if ($paymentDate == 2) {
        $diff = intval((((get_epoch($PAYMENT_DATE_2) - $today) / 60) / 60) / 24);
    } else if ($paymentDate == 3) {
        $diff = intval((((get_epoch($PAYMENT_DATE_3) - $today) / 60) / 60) / 24);
    } else if ($paymentDate == 4) {
        $diff = intval((((get_epoch($PAYMENT_DATE_4) - $today) / 60) / 60) / 24);
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
    if (isset($_POST['update1']) && $_POST['update1'] == "YES" || isset($_POST['update2']) && $_POST['update2'] == "YES" || isset($_POST['update3']) && $_POST['update3'] == "YES" || isset($_POST['update4']) && $_POST['update4'] == "YES") {
        // At least one is checked
        
    } else {
        $errors[] = 'Please choose at least one payment to edit by checking the appropriate box.';
    }
    return $errors;
}
function process_payments_form() {
    global $Link;
    global $P4_ID;
    global $P4_AUDIT;
    $countComma = 1;
    $update = 'UPDATE ' . PAYMENTPLANFOUR . ' SET ';
    if (isset($_POST['update1']) && $_POST['update1'] == "YES") {
        $value1 = $_POST['p4_pay1_year'] . '-' . $_POST['p4_pay1_month'] . '-' . $_POST['p4_pay1_day'] . ' 00:00:00';
        $value2 = $_POST['p1_checknum'];
        $update.= ' paymentOneDate="' . $value1 . '"@' . $countComma . '@ ';
        $countComma++;
        $update.= ' p1_checknum="' . $value2 . '"@' . $countComma . '@ ';
        $countComma++;
        $update.= ' audit1="' . $P4_AUDIT . '"@' . $countComma . '@ ';
        $countComma++;
    }
    if (isset($_POST['update2']) && $_POST['update2'] == "YES") {
        $value1 = $_POST['p4_pay2_year'] . '-' . $_POST['p4_pay2_month'] . '-' . $_POST['p4_pay2_day'] . ' 00:00:00';
        $value2 = $_POST['p2_checknum'];
        $update.= ' paymentTwoDate="' . $value1 . '"@' . $countComma . '@ ';
        $countComma++;
        $update.= ' p2_checknum="' . $value2 . '"@' . $countComma . '@ ';
        $countComma++;
        $update.= ' audit2="' . $P4_AUDIT . '"@' . $countComma . '@ ';
        $countComma++;
    }
    if (isset($_POST['update3']) && $_POST['update3'] == "YES") {
        $value1 = $_POST['p4_pay3_year'] . '-' . $_POST['p4_pay3_month'] . '-' . $_POST['p4_pay3_day'] . ' 00:00:00';
        $value2 = $_POST['p3_checknum'];
        $update.= ' paymentThreeDate="' . $value1 . '"@' . $countComma . '@ ';
        $countComma++;
        $update.= ' p3_checknum="' . $value2 . '"@' . $countComma . '@ ';
        $countComma++;
        $update.= ' audit3="' . $P4_AUDIT . '"@' . $countComma . '@ ';
        $countComma++;
    }
    if (isset($_POST['update4']) && $_POST['update4'] == "YES") {
        $value1 = $_POST['p4_pay4_year'] . '-' . $_POST['p4_pay4_month'] . '-' . $_POST['p4_pay4_day'] . ' 00:00:00';
        $value2 = $_POST['p4_checknum'];
        $update.= ' paymentFourDate="' . $value1 . '"@' . $countComma . '@ ';
        $countComma++;
        $update.= ' p4_checknum="' . $value2 . '"@' . $countComma . '@ ';
        $countComma++;
        $update.= ' audit4="' . $P4_AUDIT . '"@' . $countComma . '@ ';
        $countComma++;
    }
    $update.= ' WHERE registrationID=' . $P4_ID;
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
