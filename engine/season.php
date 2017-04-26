<?php
/*
 * Created on Aug 15, 2008
 *
 * Sets the season for everypage.  Just refer to $SEASON as a global variable.
*/
if (isset($_POST['season']) && $_POST['season'] > 0) {
    $SEASON = $_POST['season'];
} else if (isset($_GET['season']) && $_GET['season'] > 0) {
    $SEASON = $_GET['season'];
} else {
    $SEASON = get_site_variable_value("SEASON");
}
$smarty->assign('SEASON', $SEASON);
?>
