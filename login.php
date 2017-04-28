<?php
/*
 * Created on Aug 28, 2006
 *
 * This will probably be changed into a redirect file to the public interface.
*/
/*
 * Below is your typical setup for a php page that uses the Smarty template
 * engine.  Notice that when a php file is run by the server, it should run
 * all php code before any html code is run.  Otherwise you end up with
 * header errors.  Which is a pain when developing on different environment
 * setups.
*/
// Page requirements
define('LOGIN_REQUIRED', false);
define('PAGE_ACCESS_LEVEL', 0);
define('PAGE_TYPE', 'SECURITY');
// Set for every page
require ('engine/common.php');
if ((isset($_POST['action'])) && ($_POST['action'] == "Login")) {
    $username = $_POST['email'];
    $password = $_POST['password'];
    process_login_form($smarty);
}
$smarty->assign('page_name', 'Login');
// Build the page
require ('global_begin.php');
$smarty->display('security/login.tpl');
require ('global_end.php');
/*
 * ********************************************************************************
 * ********************************************************************************
 * **************************L O C A L  F U N C T I O N S**************************
 * ********************************************************************************
 * ********************************************************************************
*/
/*
 * Handle Repost
 * - Keeps user from having to retype information.
*/
function handle_reposts() {
    global $smarty;
    $email = "";
    if ($_POST) {
        if ($_POST['email']) {
            $email = $_POST['email'];
        }
    }
    $smarty->assign('email', $email);
}
function process_login_form($smarty) {
    global $Link;
    $errors = array();
    global $username;
    global $password;
    $Query = 'SELECT * FROM ' . USER . ' WHERE eMail = "' . $username . '" AND password = "' . md5($password) . '" AND accessLevel > 0';
    $Results = mysql_query($Query, $Link) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    $num_rows = mysql_num_rows($Results);
    if (($num_rows == 1) && ($row = mysql_fetch_array($Results))) {
        // OK to Enter;
        // set userdata;
        $_SESSION['logged_in'] = true;
        $_SESSION['userid'] = $row['userID'];
        $_SESSION['playerid'] = $row['playerId'];
        $_SESSION['username'] = $row['eMail'];
        $_SESSION['firstname'] = $row['firstName'];
        $_SESSION['lastname'] = $row['lastName'];
        $_SESSION['email'] = $row['eMail'];
        $_SESSION['site_access'] = $row['accessLevel'];
        session_write_close();
        set_cookie($row);
        //TODO: Setup where the user goes once login is verified
        if (true) { // User
            header("Location: account.php");
        } else { // Disabled Account
            header("Location: logout.php");
        }
    } else {
        $errors[] = "Access Not Permitted:<br />Username / Password Error";
        handle_errors($errors);
        handle_reposts();
    }
}
// SESSION_TIMEOUT(seconds) is defined in engine/definitions.php
function set_cookie($row) {
    global $username;
    if (@$_POST['active']) {
        setcookie("user", $username, time() + LONG_SESSION_TIMEOUT, "/");
        if ($row['type'] >= 3) setcookie("admin", TRUE, time() + LONG_SESSION_TIMEOUT, "/");
        else setcookie("admin", '', time() - ONE_DAY);
    } else {
        setcookie('user', $username, time() + SESSION_TIMEOUT, "/");
        if ($row['type'] >= 3) setcookie('admin', TRUE, time() + SESSION_TIMEOUT, "/");
        else setcookie('admin', '', time() - ONE_DAY, "/");
    }
}
?>

