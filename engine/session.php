<?php
session_start();
// Create session from cookie if it exists
if (!isset($_SESSION['logged_in']) && isset($_COOKIE['user'])) {
    set_user_session($_COOKIE['user']);
}
// Cancel session if cookie has expired.
if (isset($_SESSION['logged_in']) && !isset($_COOKIE['user'])) {
    unset_user_session();
}
if (LOGIN_REQUIRED) {
    // Check current session
    if (isset($_SESSION['logged_in'])) {
        if ($_SESSION['logged_in'] == false) {
            header('Location: login.php');
        }
    } else {
        header('Location: login.php');
    }
}
// Sets the user session, if the cookie indicates a still open session.
function set_user_session($username = "") {
    global $Link;
    $Query = 'SELECT * FROM ' . USER . ' WHERE eMail = "' . $username . '"';
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
    }
}
function unset_user_session() {
    $_SESSION['logged_in'] = false;
    $_SESSION['userid'] = "";
    $_SESSION['playerid'] = "";
    $_SESSION['username'] = "";
    $_SESSION['firstname'] = "";
    $_SESSION['lastname'] = "";
    $_SESSION['email'] = "";
    $_SESSION['site_access'] = 0;
}
?>