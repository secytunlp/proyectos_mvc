<?php

	if ($_SERVER['DOCUMENT_ROOT'] == "")
   		$_SERVER['DOCUMENT_ROOT'] = 'D:/Documents/Mis Webs';
	define ( 'APP_NAME', '/proyectos_mvc/' );
	define ( 'APP_PATH', $_SERVER['DOCUMENT_ROOT'] . APP_NAME );
	define ( 'WEB_PATH', 'http://localhost/proyectos_mvc' );
	
	include_once APP_PATH . 'conf/constants.php';
	define("CLASS_LOADER_FROM_SESSION", 1, true);
	include_once APP_PATH . 'conf/modules.php';
	include_once APP_PATH . 'conf/tables.php';
	include_once APP_PATH . 'conf/bbdd_config.php'; 
	include_once APP_PATH . 'conf/templates.php';
	include_once APP_PATH . 'conf/messages.php'; 
	
?>
