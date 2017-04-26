<?php
/*
 * Created on Sep 22, 2009
 *
*/
downloadFile($_GET['id']);
function downloadFile($id) {
    require ('common_lite.php');
    $Query = 'SELECT boardMemberImage FROM ' . BOARDMEMBER . ' WHERE boardMemberID=' . $id;
    $Results = mysql_query($Query) or die("sp_clubs (Line " . __LINE__ . "): " . mysql_errno() . ": " . mysql_error());
    if ($Results) {
        if (mysql_num_rows($Results) > 0) {
            while ($row = mysql_fetch_array($Results)) {
                header("Content-Disposition: attachment; filename=boardmember.jpg");
                echo $row['boardMemberImage'];
            }
        }
    } else {
        print 'Sorry, File Error - ' . $id . ' does not exist in the system!';
    }
}
?>


