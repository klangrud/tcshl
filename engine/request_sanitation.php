<?php
/*
 * Created on Sep 17, 2008
 *
 * This code will fix the whole magic_quotes_gpc issues
 * that I have been having.  It checks if magic quotes
 * is turned on and does some work to the $_REQUEST if
 * it is.
*/
// Is magic quotes on?
if (get_magic_quotes_gpc()) {
    // Yes? Strip the added slashes
    $_REQUEST = array_map('stripslashes', $_REQUEST);
    $_GET = array_map('stripslashes', $_GET);
    $_POST = array_map('stripslashes', $_POST);
    $_COOKIE = array_map('stripslashes', $_COOKIE);
}
?>
