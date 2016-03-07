<?php
/** 
 * Contient la division pour le sommaire, sujet à des variations suivant la 
 * connexion ou non d'un utilisateur, et dans l'avenir, suivant le type de cet utilisateur 
 * @todo  RAS
 */
require_once MODELSPATH.'_gestionSession.lib.php';
?>
    <!-- Division pour le sommaire -->
    <div id="menuGauche">
     <div id="infosUtil">
    <?php      
      if (estVisiteurConnecte() ) {
          $idUser = obtenirIdUserConnecte() ;
          $lgUser = obtenirDetailVisiteur($idConnexion, $idUser);
          $nom = $lgUser['nom'];
          $prenom = $lgUser['prenom'];            
    ?>
        <h2>
    <?php  
            echo $nom . " " . $prenom ; ?>
        </h2><?php
			if(testerComptable($idUser)==1)
			{ ?>
				<h3>Comptable</h3>
			<?php }
			else{ ?>	
				<h3>Visiteur médical</h3>        
			<?php }
       }
    ?>  
      </div>  
<?php      
  if (estVisiteurConnecte() ) {
  if(testerComptable($idUser)==1){ ?>
        <ul id="menuList">
           <li class="smenu">
              <a href="<?php echo URL.'index.php?action=accueil'; ?>" title="Accueil"> > Accueil</a>
           </li>
           <li class="smenu">
              <a href="<?php echo URL.'index.php?action=deconnecter'; ?>" title="Se déconnecter"> > Se déconnecter</a>
           </li>
           <li class="smenu">
              <a href="<?php echo URL.'index.php?action=rechercher'; ?>" title="Chercher visiteur"> > Chercher visiteurs</a>
           </li>
         </ul>
        <?php }
  else{
?>
        <ul id="menuList">
           <li class="smenu">
              <a href="<?php echo URL.'index.php?action=accueil'; ?>" title="Accueil"> > Accueil</a>
           </li>
           <li class="smenu">
              <a href="<?php echo URL.'index.php?action=deconnecter'; ?>" title="Se déconnecter"> > Se déconnecter</a>
           </li>
           <li class="smenu">
              <a href="<?php echo URL.'index.php?action=saisir'; ?>" title="Saisie fiche de frais du mois courant"> > Saisie fiche de frais</a>
           </li>
           <li class="smenu">
              <a href="<?php echo URL.'index.php?action=consulter'; ?>" title="Consultation de mes fiches de frais"> > Mes fiches de frais</a>
           </li>
           <!--<li class="smenu">
              <a href="<?php echo URL.'index.php?action=refuser'; ?>" title="Fiche de frais refusée"> > Fiche de frais refusée</a>
           </li>-->
         </ul>
        <?php
		}
          // affichage des éventuelles erreurs déjà détectées
          if ( nbErreurs($tabErreurs) > 0 ) {
              echo toStringErreurs($tabErreurs) ;
          }
  }
        ?>
    </div>
    