<?php
/*
 * Created on Sep 8, 2008
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
*/
if (get_site_variable_value("MARQUEE") == 1) {
    $marquee = get_site_marquee();
    $smarty->assign('MARQUEE', $marquee);
}
?>
