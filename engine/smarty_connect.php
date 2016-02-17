<?php

// load Smarty library
// Smarty.class.php must be in the classpath to use relative path
// Otherwise an absolute path must be used.
require('net/smarty/libs/Smarty.class.php');

class smarty_connect extends Smarty 
{
   function smarty_connect()
   {
        // Class Constructor. 
        // These automatically get set with each new instance.

		$this->Smarty();

		$this->template_dir = '@web.server.docs@/@project@/templates';
		$this->compile_dir = '@web.server.docs@/@project@/templates_c';

		$this->assign('app_name', 'TCSHL');
   }
}
?>