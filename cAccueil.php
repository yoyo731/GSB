<?php
/** 
 * Page d'accueil de l'application web AppliFrais
 * @package default
 * @todo  RAS
 */
  $repInclude = './include/';
  require_once MODELSPATH.'_gestionSession.lib.php';

  // page inaccessible si visiteur non connecté
  if ( ! estVisiteurConnecte() ) 
  {
        header('location: '.URL.'index.php?action=connexion');  
  }
  //require_once TEMPLATESPATH."_entete.inc.html";
  //require_once TEMPLATESPATH."_sommaire.inc.php";
?>
  <!-- Division principale -->
  <div id="contenu">
      <h2>Bienvenue sur l'intranet GSB</h2>
  </div>
<?php        
  //require_once TEMPLATESPATH."_pied.inc.html";
  require_once MODELSPATH."_fin.inc.php";
?>
