

 <?php 
/** 
 * Script de contrôle et d'affichage du cas d'utilisation "Consulter une fiche de frais"
 * @package default
 * @todo  RAS
 */
  $repInclude = './include/';
  //require(MODELSPATH. "_init.inc.php");

  // page inaccessible si visiteur non connecté
  if ( ! estVisiteurConnecte() ) {
      header('location: '.URL.'index.php?action=controler');  
  }
  
  // acquisition des données entrées, ici le numéro de mois et l'étape du traitement
 
  if ($etapeV == "validerVis") { // l'utilisateur valide ses nouvelles données
                
      // vérification de l'existence de la fiche de frais pour le mois demandé
      $existemois = existemois($idConnexion, $visiteursaisi);
      // si elle n'existe pas, on la crée avec les élets frais forfaitisés à 0
      if ( !$existemois ) {
          ajouterErreur($tabErreurs, "Pas de mois pour ce visiteur.");
      }
      else {
          // récupération des données sur la fiche de frais demandée
          $DetailVisiteur=obtenirDetailVisiteur($idConnexion, $visiteursaisi);
      }
  }  
?>
  <!-- Division principale -->
  
  <div id="contenu">
        
	<?php 
	if ( $etapeV == "validerVis" ) {
        if ( nbErreurs($tabErreurs) > 0 ) {
            echo toStringErreurs($tabErreurs) ;
        }
        else { ?>
      <h2><?php  echo $DetailVisiteur['nom']." ".$DetailVisiteur['prenom']; ?></h2>
      <h3>Mois à sélectionner : </h3>
      <form action="index.php?action=validermois" method="post">
      <div class="corpsForm">
		  <input type="hidden" name="etapeR" value="nonRemb" />
		  <input type="hidden" name="etapeV" value="validerVis" />
          <input type="hidden" name="etape" value="validerConsult" />
		  <input type="hidden" name="lstVisiteur" value="<?php echo $visiteursaisi ?>" />
      <p>
        <label for="lstMois">Mois : </label>
        <select id="lstMois" name="lstMois" title="Sélectionnez le mois souhaité pour la fiche de frais">
            <?php
                // on propose tous les mois pour lesquels le visiteur a une fiche de frais
                $req = obtenirReqMoisFicheFrais($visiteursaisi);
                $idJeuMois = mysql_query($req);
                $lgMois = mysql_fetch_assoc($idJeuMois);
                while ( is_array($lgMois) ) {
                    $mois = $lgMois["mois"];
                    $noMois = intval(substr($mois, 4, 2));
                    $annee = intval(substr($mois, 0, 4));
            ?>    
            <option value="<?php echo $mois; ?>"<?php if (isset($moisSaisi) and $moisSaisi == $mois) { ?> selected="selected"<?php } ?>><?php echo obtenirLibelleMois($noMois) . " " . $annee; ?></option>
            <?php
                    $lgMois = mysql_fetch_assoc($idJeuMois);        
                }
                mysql_free_result($idJeuMois);
            ?>
        </select>
      </p>
      </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20"
               title="Demandez à consulter la fiche de frais pour le mois" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div>
        
      </form>
	  </div>
	 
<?php      
}} 
?>    

<?php    
  //require($repInclude . "_pied.inc.html");
  require(MODELSPATH."_fin.inc.php");
?> 