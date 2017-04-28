<?php
/*
 * Created on Oct 23, 2009
 *
 * Setup header for mobile site
*/
/*
 * Determine css style and javascript dynamically
*/
// If for a public page
if (PAGE_TYPE == 'PUBLIC') {
    $smarty->assign('css_file', 'public');
    $smarty->assign('js_file', 'public');
}
// If for a user page
else if (PAGE_TYPE == 'USER') {
    $smarty->assign('css_file', 'user');
    $smarty->assign('js_file', 'user');
}
// If for a admin page
else if (PAGE_TYPE == 'ADMIN') {
    $smarty->assign('css_file', 'admin');
    $smarty->assign('js_file', 'admin');
}
// If for a security page
else if (PAGE_TYPE == 'SECURITY') {
    $smarty->assign('css_file', 'security');
    $smarty->assign('js_file', 'security');
}
// If for an undetermined page
else {
    $smarty->assign('css_file', 'none');
    $smarty->assign('js_file', 'none');
}
//Determine User Session
if ($_SESSION) {
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
        $smarty->assign('user', $_SESSION['firstname']);
        $smarty->assign('logged_in', $_SESSION['logged_in']);
        $smarty->assign('site_access', $_SESSION['site_access']);
    } else {
        $smarty->clear_assign('user');
        $smarty->clear_assign('logged_in');
        $smarty->clear_assign('site_access');
    }
}
//Creates the header
$smarty->display('global/global_mobile_header.tpl');
?>
