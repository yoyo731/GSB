

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
  

 
?>
  <!-- Division principale -->
  
  <div id="contenu">
      <h2>Les visiteurs</h2>
      <h3>Visiteur à sélectionner : </h3>
      <form action="index.php?action=valider" method="post">
      <div class="corpsForm">
	  
          <input type="hidden" name="etapeV" value="validerVis" />
      <p>
        <label for="lstVisiteur">Visiteur : </label>
        <select id="lstVisiteur" name="lstVisiteur" title="Sélectionnez le visiteur souhaité pour les fiche de frais">
            <?php
                // on propose tous les mois pour lesquels le visiteur a une fiche de frais
				//obtenirReqMoisFicheFrais(obtenirIdUserConnecte());
				
connecterServeurBD();
$sql = 'select nom,prenom, id from visiteur where comptable=0 order by nom';
$req=mysql_query($sql);
$Visiteur= mysql_fetch_assoc($req);
                while ( is_array($Visiteur) ) {
                    $nom = $Visiteur["nom"];
					$prenom = $Visiteur["prenom"];
					$id=$Visiteur["id"];
            ?>    
            <option value="<?php echo $id; ?>"<?php if (isset($visiteursaisi) and $visiteursaisi == $id) { ?> selected="selected"<?php } ?>><?php echo $nom." ".$prenom; ?></option>
            <?php
                    $Visiteur = mysql_fetch_assoc($req);        
                }
                mysql_free_result($req);
            ?>
        </select>
      </p>
      </div>
	  
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20"
               title="Demandez à consulter cette fiche de frais" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
        </div>
	<?php  
  //require($repInclude . "_pied.inc.html");
  require(MODELSPATH."_fin.inc.php");
?> 