<?php
/** 
 * Contient la division pour le sommaire, sujet à des variations suivant la 
 * connexion ou non d'un utilisateur, et dans l'avenir, suivant le type de cet utilisateur 
 * @todo  RAS
 */
require_once(MODELSPATH.'_gestionSession.lib.php');
require_once(MODELSPATH.'_bdGestionDonnees.lib.php');
echo'blablabla';
?>
    <!-- Division pour le sommaire -->
    <div id="menuGauche">
       

        <ul id="menuList">
           <li class="smenu">
              <a href="<?php echo URL.'index.php?action=read'; ?>">Accueil</a>
           </li>
           <li class="smenu">
              <a href="cSeDeconnecter.php" title="Se déconnecter">Se déconnecter</a>
           </li>
           <li class="smenu">
              <a href="cSaisieFicheFrais.php" title="Saisie fiche de frais du mois courant">Saisie fiche de frais</a>
           </li>
           <li class="smenu">
              <a href="cConsultFichesFrais.php" title="Consultation de mes fiches de frais">Mes fiches de frais</a>
           </li>
         </ul>
        
    </div>
