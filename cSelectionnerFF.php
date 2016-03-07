

 <?php 
/** 
 * Script de controle et d'affichage du cas d'utilisation "Consulter une fiche de frais"
 * @package default
 * @todo  RAS
 */
  $repInclude = './include/';
  //require(MODELSPATH. "_init.inc.php");

  // page inaccessible si visiteur non connecté
  if ( ! estVisiteurConnecte() ) {
      header('location: '.URL.'index.php?action=controler');  
  }
  
	//require_once TEMPLATESPATH.'_sommaire.inc.php';
  //require($repInclude . "_entete.inc.html");
  //require($repInclude . "_sommaire.inc.php");
  
  // acquisition des données entrées, ici le numéro de mois et l'étape du traitement
  
 
  


  /*if ($etape != "demanderConsult" && $etape != "validerConsult" && $etapeV != "validerVis") {
      // si autre valeur, on considère que c'est le début du traitement
      $etape = "demanderConsult";
  } */
 
  if ($etape == "validerConsult" && $etapeV == "validerVis") { // l'utilisateur valide ses nouvelles données
                
      // vérification de l'existence de la fiche de frais pour le mois demandé
      $existeFicheFrais = existeFicheFrais($idConnexion, $mois, $visiteursaisi);
      // si elle n'existe pas, on la crée avec les élets frais forfaitisés à 0
	  
	  
      if ( !$existeFicheFrais ) {
          ajouterErreur($tabErreurs, "Le mois demandé est invalide");
      }
      else {
          // récupération des données sur la fiche de frais demandée
          $tabFicheFrais = obtenirDetailFicheFrais($idConnexion, $mois, $visiteursaisi);
      }
  } 
  
  if ($etapeR == "validerRemb") {
      modifierEtatFicheFrais($idConnexion, $mois,$visiteursaisi,'VA');
  }
  else if ($etapeR == "refuserRemb") {
      modifierEtatFicheFrais($idConnexion, $mois,$visiteursaisi,'CR');
  }

 
?>
  <!-- Division principale -->
  
 <div id="contenu">
	 
<?php      
 //echo $mois; 
// demande et affichage des différents éléments (forfaitisés et non forfaitisés)
// de la fiche de frais demandée, uniquement si pas d'erreur détecté au contrôle
    if ( $etape == "validerConsult" ) {
        if ( nbErreurs($tabErreurs) > 0 ) {
            echo toStringErreurs($tabErreurs) ;
        }
        else {
?>
	<form action="<?php echo URL.'index.php?action=validermois'; ?>" method="post">
	
		<input type="hidden" name="etapeR" value="validerRemb" />
		<input type="hidden" name="etapeV" value="validerVis" />
        <input type="hidden" name="etape" value="validerConsult" />
		<input type="hidden" name="lstVisiteur" value="<?php echo $visiteursaisi ?>" />
		<input type="hidden" name="lstMois" value="<?php echo $mois ?>" />
    <h3>Fiche de frais du mois de <?php echo obtenirLibelleMois(intval(substr($mois,4,2))) . " " . substr($mois,0,4); ?> : 
    <em><?php echo $tabFicheFrais["libelleEtat"]; ?> </em>
    depuis le <em><?php echo $tabFicheFrais["dateModif"]; ?></em></h3>
    <div class="encadre">
    <p>Montant validé : <?php echo $tabFicheFrais["montantValide"] ;
        ?>              
    </p>
<?php          
            // demande de la requête pour obtenir la liste des éléments 
            // forfaitisés du visiteur connecté pour le mois demandé
            $req = obtenirReqEltsForfaitFicheFrais($mois, $visiteursaisi);
            $idJeuEltsFraisForfait = mysql_query($req, $idConnexion);
            echo mysql_error($idConnexion);
            $lgEltForfait = mysql_fetch_assoc($idJeuEltsFraisForfait);
            // parcours des frais forfaitisés du visiteur connecté
            // le stockage intermédiaire dans un tableau est nécessaire
            // car chacune des lignes du jeu d'enregistrements doit être doit être
            // affichée au sein d'une colonne du tableau HTML
            $tabEltsFraisForfait = array();
            while ( is_array($lgEltForfait) ) {
                $tabEltsFraisForfait[$lgEltForfait["libelle"]] = $lgEltForfait["quantite"];
                $lgEltForfait = mysql_fetch_assoc($idJeuEltsFraisForfait);
            }
            mysql_free_result($idJeuEltsFraisForfait);
            ?>
  	<table class="listeLegere">
  	   <caption>Quantités des éléments forfaitisés</caption>
        <tr>
            <?php
            // premier parcours du tableau des frais forfaitisés du visiteur connecté
            // pour afficher la ligne des libellés des frais forfaitisés
            foreach ( $tabEltsFraisForfait as $unLibelle => $uneQuantite ) {
            ?>
                <th><?php echo $unLibelle ; ?></th>
            <?php
            }
            ?>
        </tr>
        <tr>
            <?php
            // second parcours du tableau des frais forfaitisés du visiteur connecté
            // pour afficher la ligne des quantités des frais forfaitisés
            foreach ( $tabEltsFraisForfait as $unLibelle => $uneQuantite ) {
            ?>
                <td class="qteForfait"><?php echo $uneQuantite ; ?></td>
            <?php
            }
            ?>
        </tr>
    </table>
  	<table class="listeLegere">
  	   <caption>Descriptif des éléments hors forfait - <?php echo $tabFicheFrais["nbJustificatifs"]; ?> justificatifs reçus -
       </caption>
             <tr>
                <th class="date">Date</th>
                <th class="libelle">Libellé</th>
                <th class="montant">Montant</th>                
             </tr>
<?php          
            // demande de la requête pour obtenir la liste des éléments hors
            // forfait du visiteur connecté pour le mois demandé
            $req = obtenirReqEltsHorsForfaitFicheFrais($mois, $visiteursaisi);
            $idJeuEltsHorsForfait = mysql_query($req, $idConnexion);
            $lgEltHorsForfait = mysql_fetch_assoc($idJeuEltsHorsForfait);
            
            // parcours des éléments hors forfait 
            while ( is_array($lgEltHorsForfait) ) {
            ?>
                <tr>
                   <td><?php echo $lgEltHorsForfait["date"] ; ?></td>
                   <td><?php echo filtrerChainePourNavig($lgEltHorsForfait["libelle"]) ; ?></td>
                   <td><?php echo $lgEltHorsForfait["montant"] ; ?></td>
                </tr>
            <?php
                $lgEltHorsForfait = mysql_fetch_assoc($idJeuEltsHorsForfait);
            }
            mysql_free_result($idJeuEltsHorsForfait);
  ?>
    </table>
  </div>
<?php
        }
    }
?>    
<input type='submit' name='btnvalider' value='Valider le remboursement'
onclick="alert('La fiche de frais a bien été validée.');">
</form>
<form action="<?php echo URL.'index.php?action=modifier'; ?>" method="post">
	
		<input type="hidden" name="etapeR" value="refuserRemb" />
		<input type="hidden" name="etapeV" value="validerVis" />
        <input type="hidden" name="etape" value="validerConsult" />
		<input type="hidden" name="lstVisiteur" value="<?php echo $visiteursaisi ?>" />
		<input type="hidden" name="lstMois" value="<?php echo $mois ?>" />
<input type='submit' name='btnmodifier' value='Modifier la fiche de frais'>
</form>
<input type="button" name="imprimer" value="Imprimer" onclick="return print();">

<form action="index.php?action=valider" method="post">
		  <input type="hidden" name="etapeV" value="validerVis" />
		  <input type="hidden" name="lstVisiteur" value="<?php echo $visiteursaisi ?>" />
		  <input type='submit' name='btnretour' value='Retour'>
</form>
  </div>
<?php      
  //require($repInclude . "_pied.inc.html");
  require(MODELSPATH."_fin.inc.php");
?> 