<?php
define('FCPATH', realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR);
define('APPPATH', FCPATH.'application'.DIRECTORY_SEPARATOR);
require_once APPPATH.'config'.DIRECTORY_SEPARATOR.'constants.php';

//inclure en utilisant CONTROLLERSPATH le controlleur de page visiteur.php
if (isset($_GET['module']))
	$module=$_GET['module'];
else
	if (isset($_POST['module']))
		$module=$_POST['module'];
	else
		$module='visiteur';

require_once CONTROLLERSPATH.$module.'.php';
?>