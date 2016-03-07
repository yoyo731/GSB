<?php
/** 
 * Initialise les ressources necessaires au fonctionnement de l'application
 * @package default
 * @todo  RAS
 */
  require_once("_bdGestionDonnees.lib.php");
  require_once("_gestionSession.lib.php");
  require_once("_utilitairesEtGestionErreurs.lib.php");
  // demarrage ou reprise de la session
  initSession();
  // initialisation, aucune erreur ...
  $tabErreurs = array();
    
  // Demande-t-on une deconnexion ?
  $demandeDeconnexion = lireDonneeUrl("cmdDeconnecter");
  if ( $demandeDeconnexion == "on") {
      deconnecterVisiteur();
	  header('Location: '.URL.'index.php?');
  }
    
  // etablissement d'une connexion avec le serveur de donnees 
  // puis selection de la BD qui contient les donnees des visiteurs et de leurs frais
  $idConnexion=connecterServeurBD();
  if (!$idConnexion) {
      ajouterErreur($tabErreurs, "Echec de la connexion au serveur MySql");
  }
  elseif (!activerBD($idConnexion)) {
      ajouterErreur($tabErreurs, "La base de donnees gsb_frais est inexistante ou non accessible");
  }
  
?>