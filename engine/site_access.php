<?php
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    define('USER_ACCESS_LEVEL', $_SESSION['site_access']);
    if (!site_access_allows(USER_ACCESS_LEVEL, PAGE_ACCESS_LEVEL)) {
        header("Location: account.php");
    }
}
function site_access_allows($user_access = 0, $page_access) {
    if ($user_access >= $page_access) {
        return true;
    } else {
        return false;
    }
}
?>
