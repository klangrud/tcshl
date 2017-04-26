<?php
/*
 * Created on Sep 4, 2008
 *
 * Payment Mangager
*/
// Page requirements
define('LOGIN_REQUIRED', true);
define('PAGE_ACCESS_LEVEL', 2);
define('PAGE_TYPE', 'ADMIN');
// Set for every page
require ('engine/common.php');
// Payment Dates for Plans 1,2,4
$PAYMENT_DATE_1 = '';
$PAYMENT_DATE_2 = '';
$PAYMENT_DATE_3 = '';
$PAYMENT_DATE_4 = '';
// Payment Dates for Plan 3
$PAYMENT_DATE_ALT_1 = '';
$PAYMENT_DATE_ALT_2 = '';
$PAYMENT_DATE_ALT_3 = '';
initialize_payment_dates($SEASON);
setup_plan4_players();
setup_plan3_players();
setup_plan2_players();
setup_plan1_players();
$smarty->assign('daysToFirstPayment', get_payment_date_difference(1));
$smarty->assign('daysToSecondPayment', get_payment_date_difference(2));
$smarty->assign('daysToThirdPayment', get_payment_date_difference(3));
$smarty->assign('daysToFourthPayment', get_payment_date_difference(4));
$smarty->assign('daysToFirstPaymentAlt', get_payment_date_difference(5));
$smarty->assign('daysToSecondPaymentAlt', get_payment_date_difference(6));
$smarty->assign('daysToThirdPaymentAlt', get_payment_date_difference(7));
$smarty->assign('page_name', 'Payment Manager - ' . get_season_name($SEASON) . ' Season');
// Build the page
require ('global_begin.php');
$smarty->display('admin/paymentmanager.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
function setup_plan4_players() {
    global $smarty;
    global $Link;
    global $SEASON;
    $subQuery = 'SELECT registrationId FROM ' . REGISTRATION . ' WHERE seasonId=' . $SEASON;
    $columns = 'fName, lName, ' . PAYMENTPLANFOUR . '.registrationID, paymentOneDate, p1_checknum, paymentTwoDate, p2_checknum, paymentThreeDate, p3_checknum, paymentFourDate, p4_checknum, audit1, audit2, audit3, audit4';
    $select = 'SELECT ' . $columns . ' FROM ' . PAYMENTPLANFOUR;
    $select.= ' JOIN ' . REGISTRATION . ' ON ' . PAYMENTPLANFOUR . '.registrationID=' . REGISTRATION . '.registrationID';
    $select.= ' WHERE ' . PAYMENTPLANFOUR . '.registrationID IN (' . $subQuery . ')';
    $select.= ' ORDER BY lName';
    $result = mysql_query($select, $Link);
    if ($result && mysql_num_rows($result) > 0) {
        $count = 0;
        $smarty->assign('p4_name', array());
        $smarty->assign('p4_id', array());
        $smarty->assign('p4_paymentOneDate', array());
        $smarty->assign('p4_p1_checknum', array());
        $smarty->assign('p4_p1_audit', array());
        $smarty->assign('p4_paymentTwoDate', array());
        $smarty->assign('p4_p2_checknum', array());
        $smarty->assign('p4_p2_audit', array());
        $smarty->assign('p4_paymentThreeDate', array());
        $smarty->assign('p4_p3_checknum', array());
        $smarty->assign('p4_p3_audit', array());
        $smarty->assign('p4_paymentFourDate', array());
        $smarty->assign('p4_p4_checknum', array());
        $smarty->assign('p4_p4_audit', array());
        while ($player = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $count++;
            $name = $player['fName'] . ' ' . $player['lName'];
            $id = $player['registrationID'];
            if (isset($player['paymentOneDate']) && $player['paymentOneDate'] != NULL) {
                $paymentOneDate = format_date($player['paymentOneDate']);
            } else {
                $paymentOneDate = "&nbsp;";
            }
            if (isset($player['p1_checknum']) && strlen($player['p1_checknum']) > 0) {
                $p1_checknum = $player['p1_checknum'];
            } else {
                $p1_checknum = "&nbsp;";
            }
            if (isset($player['audit1']) && strlen($player['audit1']) > 0) {
                $audit1 = get_site_user_initials($player['audit1']);
            } else {
                $audit1 = "&nbsp;";
            }
            if (isset($player['paymentTwoDate']) && $player['paymentTwoDate'] != NULL) {
                $paymentTwoDate = format_date($player['paymentTwoDate']);
            } else {
                $paymentTwoDate = "&nbsp;";
            }
            if (isset($player['p2_checknum']) && strlen($player['p2_checknum']) > 0) {
                $p2_checknum = $player['p2_checknum'];
            } else {
                $p2_checknum = "&nbsp;";
            }
            if (isset($player['audit2']) && strlen($player['audit2']) > 0) {
                $audit2 = get_site_user_initials($player['audit2']);
            } else {
                $audit2 = "&nbsp;";
            }
            if (isset($player['paymentThreeDate']) && $player['paymentThreeDate'] != NULL) {
                $paymentThreeDate = format_date($player['paymentThreeDate']);
            } else {
                $paymentThreeDate = "&nbsp;";
            }
            if (isset($player['p3_checknum']) && strlen($player['p3_checknum']) > 0) {
                $p3_checknum = $player['p3_checknum'];
            } else {
                $p3_checknum = "&nbsp;";
            }
            if (isset($player['audit3']) && strlen($player['audit3']) > 0) {
                $audit3 = get_site_user_initials($player['audit3']);
            } else {
                $audit3 = "&nbsp;";
            }
            if (isset($player['paymentFourDate']) && $player['paymentFourDate'] != NULL) {
                $paymentFourDate = format_date($player['paymentFourDate']);
            } else {
                $paymentFourDate = "&nbsp;";
            }
            if (isset($player['p4_checknum']) && strlen($player['p4_checknum']) > 0) {
                $p4_checknum = $player['p4_checknum'];
            } else {
                $p4_checknum = "&nbsp;";
            }
            if (isset($player['audit4']) && strlen($player['audit4']) > 0) {
                $audit4 = get_site_user_initials($player['audit4']);
            } else {
                $audit4 = "&nbsp;";
            }
            $smarty->append('p4_name', $name);
            $smarty->append('p4_id', $id);
            $smarty->append('p4_paymentOneDate', $paymentOneDate);
            $smarty->append('p4_p1_checknum', $p1_checknum);
            $smarty->append('p4_p1_audit', $audit1);
            $smarty->append('p4_paymentTwoDate', $paymentTwoDate);
            $smarty->append('p4_p2_checknum', $p2_checknum);
            $smarty->append('p4_p2_audit', $audit2);
            $smarty->append('p4_paymentThreeDate', $paymentThreeDate);
            $smarty->append('p4_p3_checknum', $p3_checknum);
            $smarty->append('p4_p3_audit', $audit3);
            $smarty->append('p4_paymentFourDate', $paymentFourDate);
            $smarty->append('p4_p4_checknum', $p4_checknum);
            $smarty->append('p4_p4_audit', $audit4);
        }
        $smarty->assign('p4_count', $count);
    }
}
function setup_plan3_players() {
    global $smarty;
    global $Link;
    global $SEASON;
    $subQuery = 'SELECT registrationId FROM ' . REGISTRATION . ' WHERE seasonId=' . $SEASON;
    $columns = 'fName, lName, ' . PAYMENTPLANTHREE . '.registrationID, paymentOneDate, p1_checknum, paymentTwoDate, p2_checknum, paymentThreeDate, p3_checknum, audit1, audit2, audit3';
    $select = 'SELECT ' . $columns . ' FROM ' . PAYMENTPLANTHREE;
    $select.= ' JOIN ' . REGISTRATION . ' ON ' . PAYMENTPLANTHREE . '.registrationID=' . REGISTRATION . '.registrationID';
    $select.= ' WHERE ' . PAYMENTPLANTHREE . '.registrationID IN (' . $subQuery . ')';
    $select.= ' ORDER BY lName';
    $result = mysql_query($select, $Link);
    if ($result && mysql_num_rows($result) > 0) {
        $count = 0;
        $smarty->assign('p3_name', array());
        $smarty->assign('p3_id', array());
        $smarty->assign('p3_paymentOneDate', array());
        $smarty->assign('p3_p1_checknum', array());
        $smarty->assign('p3_p1_audit', array());
        $smarty->assign('p3_paymentTwoDate', array());
        $smarty->assign('p3_p2_checknum', array());
        $smarty->assign('p3_p2_audit', array());
        $smarty->assign('p3_paymentThreeDate', array());
        $smarty->assign('p3_p3_checknum', array());
        $smarty->assign('p3_p3_audit', array());
        while ($player = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $count++;
            $name = $player['fName'] . ' ' . $player['lName'];
            $id = $player['registrationID'];
            if (isset($player['paymentOneDate']) && $player['paymentOneDate'] != NULL) {
                $paymentOneDate = format_date($player['paymentOneDate']);
            } else {
                $paymentOneDate = "&nbsp;";
            }
            if (isset($player['p1_checknum']) && strlen($player['p1_checknum']) > 0) {
                $p1_checknum = $player['p1_checknum'];
            } else {
                $p1_checknum = "&nbsp;";
            }
            if (isset($player['audit1']) && strlen($player['audit1']) > 0) {
                $audit1 = get_site_user_initials($player['audit1']);
            } else {
                $audit1 = "&nbsp;";
            }
            if (isset($player['paymentTwoDate']) && $player['paymentTwoDate'] != NULL) {
                $paymentTwoDate = format_date($player['paymentTwoDate']);
            } else {
                $paymentTwoDate = "&nbsp;";
            }
            if (isset($player['p2_checknum']) && strlen($player['p2_checknum']) > 0) {
                $p2_checknum = $player['p2_checknum'];
            } else {
                $p2_checknum = "&nbsp;";
            }
            if (isset($player['audit2']) && strlen($player['audit2']) > 0) {
                $audit2 = get_site_user_initials($player['audit2']);
            } else {
                $audit2 = "&nbsp;";
            }
            if (isset($player['paymentThreeDate']) && $player['paymentThreeDate'] != NULL) {
                $paymentThreeDate = format_date($player['paymentThreeDate']);
            } else {
                $paymentThreeDate = "&nbsp;";
            }
            if (isset($player['p3_checknum']) && strlen($player['p3_checknum']) > 0) {
                $p3_checknum = $player['p3_checknum'];
            } else {
                $p3_checknum = "&nbsp;";
            }
            if (isset($player['audit3']) && strlen($player['audit3']) > 0) {
                $audit3 = get_site_user_initials($player['audit3']);
            } else {
                $audit3 = "&nbsp;";
            }
            $smarty->append('p3_name', $name);
            $smarty->append('p3_id', $id);
            $smarty->append('p3_paymentOneDate', $paymentOneDate);
            $smarty->append('p3_p1_checknum', $p1_checknum);
            $smarty->append('p3_p1_audit', $audit1);
            $smarty->append('p3_paymentTwoDate', $paymentTwoDate);
            $smarty->append('p3_p2_checknum', $p2_checknum);
            $smarty->append('p3_p2_audit', $audit2);
            $smarty->append('p3_paymentThreeDate', $paymentThreeDate);
            $smarty->append('p3_p3_checknum', $p3_checknum);
            $smarty->append('p3_p3_audit', $audit3);
        }
        $smarty->assign('p3_count', $count);
    }
}
function setup_plan2_players() {
    global $smarty;
    global $Link;
    global $SEASON;
    $subQuery = 'SELECT registrationId FROM ' . REGISTRATION . ' WHERE seasonId=' . $SEASON;
    $columns = 'fName, lName, ' . PAYMENTPLANTWO . '.registrationID, paymentOneDate, p1_checknum, paymentTwoDate, p2_checknum, audit1, audit2';
    $select = 'SELECT ' . $columns . ' FROM ' . PAYMENTPLANTWO;
    $select.= ' JOIN ' . REGISTRATION . ' ON ' . PAYMENTPLANTWO . '.registrationID=' . REGISTRATION . '.registrationID';
    $select.= ' WHERE ' . PAYMENTPLANTWO . '.registrationID IN (' . $subQuery . ')';
    $select.= ' ORDER BY lName';
    $result = mysql_query($select, $Link);
    if ($result && mysql_num_rows($result) > 0) {
        $count = 0;
        $smarty->assign('p2_name', array());
        $smarty->assign('p2_id', array());
        $smarty->assign('p2_paymentOneDate', array());
        $smarty->assign('p2_p1_checknum', array());
        $smarty->assign('p2_p1_audit', array());
        $smarty->assign('p2_paymentTwoDate', array());
        $smarty->assign('p2_p2_checknum', array());
        $smarty->assign('p2_p2_audit', array());
        while ($player = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $count++;
            $name = $player['fName'] . ' ' . $player['lName'];
            $id = $player['registrationID'];
            if (isset($player['paymentOneDate']) && $player['paymentOneDate'] != NULL) {
                $paymentOneDate = format_date($player['paymentOneDate']);
            } else {
                $paymentOneDate = "&nbsp;";
            }
            if (isset($player['p1_checknum']) && strlen($player['p1_checknum']) > 0) {
                $p1_checknum = $player['p1_checknum'];
            } else {
                $p1_checknum = "&nbsp;";
            }
            if (isset($player['audit1']) && strlen($player['audit1']) > 0) {
                $audit1 = get_site_user_initials($player['audit1']);
            } else {
                $audit1 = "&nbsp;";
            }
            if (isset($player['paymentTwoDate']) && $player['paymentTwoDate'] != NULL) {
                $paymentTwoDate = format_date($player['paymentTwoDate']);
            } else {
                $paymentTwoDate = "&nbsp;";
            }
            if (isset($player['p2_checknum']) && strlen($player['p2_checknum']) > 0) {
                $p2_checknum = $player['p2_checknum'];
            } else {
                $p2_checknum = "&nbsp;";
            }
            if (isset($player['audit2']) && strlen($player['audit2']) > 0) {
                $audit2 = get_site_user_initials($player['audit2']);
            } else {
                $audit2 = "&nbsp;";
            }
            $smarty->append('p2_name', $name);
            $smarty->append('p2_id', $id);
            $smarty->append('p2_paymentOneDate', $paymentOneDate);
            $smarty->append('p2_p1_checknum', $p1_checknum);
            $smarty->append('p2_p1_audit', $audit1);
            $smarty->append('p2_paymentTwoDate', $paymentTwoDate);
            $smarty->append('p2_p2_checknum', $p2_checknum);
            $smarty->append('p2_p2_audit', $audit2);
        }
        $smarty->assign('p2_count', $count);
    }
}
function setup_plan1_players() {
    global $smarty;
    global $Link;
    global $SEASON;
    $subQuery = 'SELECT registrationId FROM ' . REGISTRATION . ' WHERE seasonId=' . $SEASON;
    $columns = 'fName, lName, ' . PAYMENTPLANONE . '.registrationID, paymentOneDate, p1_checknum, audit1';
    $select = 'SELECT ' . $columns . ' FROM ' . PAYMENTPLANONE;
    $select.= ' JOIN ' . REGISTRATION . ' ON ' . PAYMENTPLANONE . '.registrationID=' . REGISTRATION . '.registrationID';
    $select.= ' WHERE ' . PAYMENTPLANONE . '.registrationID IN (' . $subQuery . ')';
    $select.= ' ORDER BY lName';
    $result = mysql_query($select, $Link);
    if ($result && mysql_num_rows($result) > 0) {
        $count = 0;
        $smarty->assign('p1_name', array());
        $smarty->assign('p1_id', array());
        $smarty->assign('p1_paymentOneDate', array());
        $smarty->assign('p1_p1_checknum', array());
        $smarty->assign('p1_p1_audit', array());
        while ($player = mysql_fetch_array($result, MYSQL_ASSOC)) {
            $count++;
            $name = $player['fName'] . ' ' . $player['lName'];
            $id = $player['registrationID'];
            if (isset($player['paymentOneDate']) && $player['paymentOneDate'] != NULL) {
                $paymentOneDate = format_date($player['paymentOneDate']);
            } else {
                $paymentOneDate = "&nbsp;";
            }
            if (isset($player['p1_checknum']) && strlen($player['p1_checknum']) > 0) {
                $p1_checknum = $player['p1_checknum'];
            } else {
                $p1_checknum = "&nbsp;";
            }
            if (isset($player['audit1']) && strlen($player['audit1']) > 0) {
                $audit1 = get_site_user_initials($player['audit1']);
            } else {
                $audit1 = "&nbsp;";
            }
            $smarty->append('p1_name', $name);
            $smarty->append('p1_id', $id);
            $smarty->append('p1_paymentOneDate', $paymentOneDate);
            $smarty->append('p1_p1_checknum', $p1_checknum);
            $smarty->append('p1_p1_audit', $audit1);
        }
        $smarty->assign('p1_count', $count);
    }
}
function get_payment_date_difference($paymentDate) {
    global $PAYMENT_DATE_1;
    global $PAYMENT_DATE_2;
    global $PAYMENT_DATE_3;
    global $PAYMENT_DATE_4;
    global $PAYMENT_DATE_ALT_1;
    global $PAYMENT_DATE_ALT_2;
    global $PAYMENT_DATE_ALT_3;
    $today = time();
    if ($paymentDate == 1) {
        $diff = intval((((get_epoch($PAYMENT_DATE_1) - $today) / 60) / 60) / 24);
    } else if ($paymentDate == 2) {
        $diff = intval((((get_epoch($PAYMENT_DATE_2) - $today) / 60) / 60) / 24);
    } else if ($paymentDate == 3) {
        $diff = intval((((get_epoch($PAYMENT_DATE_3) - $today) / 60) / 60) / 24);
    } else if ($paymentDate == 4) {
        $diff = intval((((get_epoch($PAYMENT_DATE_4) - $today) / 60) / 60) / 24);
    } else if ($paymentDate == 5) {
        $diff = intval((((get_epoch($PAYMENT_DATE_ALT_1) - $today) / 60) / 60) / 24);
    } else if ($paymentDate == 6) {
        $diff = intval((((get_epoch($PAYMENT_DATE_ALT_2) - $today) / 60) / 60) / 24);
    } else if ($paymentDate == 7) {
        $diff = intval((((get_epoch($PAYMENT_DATE_ALT_3) - $today) / 60) / 60) / 24);
    }
    return $diff;
}
function initialize_payment_dates($season) {
    global $Link;
    global $PAYMENT_DATE_1;
    global $PAYMENT_DATE_2;
    global $PAYMENT_DATE_3;
    global $PAYMENT_DATE_4;
    global $PAYMENT_DATE_ALT_1;
    global $PAYMENT_DATE_ALT_2;
    global $PAYMENT_DATE_ALT_3;
    // Setup payment dates for payment plans 1,2,4
    $select = 'SELECT paymentOneDate, paymentTwoDate, paymentThreeDate, paymentFourDate FROM ' . PAYMENTDATES . ' WHERE seasonID=' . $season;
    $result = mysql_query($select, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($result && mysql_num_rows($result) > 0) {
        $paymentdates = mysql_fetch_assoc($result);
        $PAYMENT_DATE_1 = $paymentdates['paymentOneDate'];
        $PAYMENT_DATE_2 = $paymentdates['paymentTwoDate'];
        $PAYMENT_DATE_3 = $paymentdates['paymentThreeDate'];
        $PAYMENT_DATE_4 = $paymentdates['paymentFourDate'];
    }
    // Setup payment dates for payment plan 3
    $selectAlt = 'SELECT paymentOneDate, paymentTwoDate, paymentThreeDate FROM ' . PAYMENTDATESALT . ' WHERE seasonID=' . $season;
    $resultAlt = mysql_query($selectAlt, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($resultAlt && mysql_num_rows($resultAlt) > 0) {
        $paymentdatesAlt = mysql_fetch_assoc($resultAlt);
        $PAYMENT_DATE_ALT_1 = $paymentdatesAlt['paymentOneDate'];
        $PAYMENT_DATE_ALT_2 = $paymentdatesAlt['paymentTwoDate'];
        $PAYMENT_DATE_ALT_3 = $paymentdatesAlt['paymentThreeDate'];
    }
}
/*
 * Format YYYY-mm-dd 00:00:00 -> mm/dd/YYYY
*/
function format_date($timestamp) {
    $year = substr($timestamp, 0, 4);
    $month = substr($timestamp, 5, 2);
    $day = substr($timestamp, 8, 2);
    $hour = substr($timestamp, 11, 2);
    $minute = substr($timestamp, 14, 2);
    $second = substr($timestamp, 17, 2);
    $epoch = mktime($hour, $minute, $second, $month, $day, $year);
    return date('m/d/Y', $epoch);
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
?>
