 Programme d'actualisation des lignes des tables,  
 cette mise à jour peut prendre plusieurs minutes...
<?php
include("application/models/fct.inc.php");

/* Modification des paramètres de connexion */

$serveur='mysql:host=yoelhazafc1.mysql.db';
$bdd='dbname=yoelhazafc1';   		
$user='yoelhazafc1' ;    		
$mdp='YoelHazan73' ;	

/* fin paramètres*/

$pdo = new PDO($serveur.';'.$bdd, $user, $mdp);
$pdo->query("SET CHARACTER SET utf8"); 

set_time_limit(0);
creationfichesfrais($pdo);
creationfraisforfait($pdo);
creationfraishorsforfait($pdo);
majfichefrais($pdo);

?>