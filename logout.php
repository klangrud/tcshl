<?php
// Page requirements
define('LOGIN_REQUIRED', false);
define('PAGE_ACCESS_LEVEL', 0);
define('PAGE_TYPE', 'SECURITY');
// Set for every page
require ('engine/common.php');
// OK to Enter;
// Clear userdata;
$_SESSION['logged_in'] = false;
$_SESSION['userid'] = "";
$_SESSION['username'] = "";
$_SESSION['firstname'] = "";
$_SESSION['lastname'] = "";
$_SESSION['email'] = "";
$_SESSION['site_access'] = 0;
unset_cookie();
session_write_close();
header("Location: index.php");
exit();
function unset_cookie() {
    setcookie("user", '', time() - ONE_DAY);
    setcookie("admin", '', time() - ONE_DAY);
}
?>