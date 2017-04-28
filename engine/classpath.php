<?php
# This file gets around the nasty include issues, this way the project can
# be kept a bit more organized.  This allows you to access files in the
# following folders without needing to know the absolute path.
# These comments in this file need to stay with the # instead of a forward
# slash because I do a find and replace on all forward slashes to take care
# of directory separator issues from windows to linux.
ini_set('include_path', ini_get('include_path') . '@classpath_token@/@project@/src/php');
ini_set('include_path', ini_get('include_path') . '@classpath_token@/@project@/engine');
ini_set('include_path', ini_get('include_path') . '@classpath_token@/@project@/global');
?>