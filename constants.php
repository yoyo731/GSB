<?php
/*
* Dans un site web dynamique, il faut toujours définir l'url pour charger des ressources (script, JS, CSS, images...)
*/

//URL l'url de votre site à modifier en fonction du déploiement
	define('URL', 'http://yoelhazan.fr/');
//CSSURL où se trouve mon css
	define('CSSURL',URL.'ressources/css/styles.css');
//CONTROLLERPATH où se trouve mes controleurs de page
	define('CONTROLLERSPATH',APPPATH.'controllers'.DIRECTORY_SEPARATOR);
//VIEWSPATH où se trouvent mes vues
	define('VIEWSPATH',APPPATH.'views'.DIRECTORY_SEPARATOR);
//MODELSPATH où se trouvent mes models
	define('MODELSPATH',APPPATH.'models'.DIRECTORY_SEPARATOR);
//TEMPLATESPATH où se trouvent mes templates
	define('TEMPLATESPATH',VIEWSPATH.'templates'.DIRECTORY_SEPARATOR);

//Les informations de connexion
//DB_HOST l'adresse IP ou le nom de la machine qui héberge le SGBD
	define('DB_HOST','yoelhazafc1.mysql.db');
//DB_NAME le nom de la base de données
	define('DB_NAME','yoelhazafc1');
//le login sur la base
	define('DB_LOGIN','yoelhazafc1');
//Le mot de passe sur la base
	define('DB_PASSWORD','YoelHazan73');
	
?>