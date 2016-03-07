<?php  
/** 
 * Script de contrôle et d'affichage du cas d'utilisation "Se déconnecter"
 * @package default
 * @todo  RAS
 */
  $repInclude = './include/';
  //require_once(MODELSPATH. "_init.inc.php");
  unset($_SESSION["idUser"]);
    unset($_SESSION["loginUser"]);  
  //header('Location: '.URL.'index.php?action=connexion');
  
?>