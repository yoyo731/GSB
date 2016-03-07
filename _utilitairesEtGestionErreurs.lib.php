<?php
/** 
 * Regroupe les fonctions utilitaires et de gestion des erreurs.
 * @package default
 * @todo  fonction estMoisValide ‡† dÈfinir complÈtement ou ‡† supprimer
 */

/** 
 * Fournit le libellÈ en franÁais correspondant √† un numÈro de mois.                     
 *
 * Fournit le libellÈ franÁais du mois de numÈro $unNoMois.
 * Retourne une chaine vide si le numÈro n'est pas compris dans l'intervalle [1,12].
 * @param int numÈro de mois
 * @return string identifiant de connexion
 */
function obtenirLibelleMois($unNoMois) {
    $tabLibelles = array(1=>"Janvier", 
                            "F√©vrier", "Mars", "Avril", "Mai", "Juin", "Juillet",
                            "Ao√ªt", "Septembre", "Octobre", "Novembre", "D√©cembre");
    $libelle="";
    if ( $unNoMois >=1 && $unNoMois <= 12 ) {
        $libelle = $tabLibelles[$unNoMois];
    }
    return $libelle;
}

/** 
 * VÈrifie si une chaine fournie est bien une date valide, au format JJ/MM/AAAA.                     
 * 
 * Retrourne true si la chaine $date est une date valide, au format JJ/MM/AAAA, false sinon.
 * @param string date √† vÈrifier
 * @return boolean succ√®s ou Èchec
 */ 
function estDate($date) {
	$tabDate = explode('/',$date);
	if (count($tabDate) != 3) {
	    $dateOK = false;
    }
    elseif (!verifierEntiersPositifs($tabDate)) {
        $dateOK = false;
    }
    elseif (!checkdate($tabDate[1], $tabDate[0], $tabDate[2])) {
        $dateOK = false;
    }
    else {
        $dateOK = true;
    }
	return $dateOK;
}

/**
 * Transforme une date au format franÁais jj/mm/aaaa vers le format anglais aaaa-mm-jj
 * @param $date au format  jj/mm/aaaa
 * @return string la date au format anglais aaaa-mm-jj
*/
function convertirDateFrancaisVersAnglais($date){
	@list($jour,$mois,$annee) = explode('/',$date);
	return date("Y-m-d", mktime(0, 0, 0, $mois, $jour, $annee));
}

/**
 * Transforme une date au format format anglais aaaa-mm-jj vers le format 
 * franÁais jj/mm/aaaa 
 * @param $date au format  aaaa-mm-jj
 * @return string la date au format format franÁais jj/mm/aaaa
*/
function convertirDateAnglaisVersFrancais($date){
    @list($annee,$mois,$jour) = explode('-',$date);
	return date("d/m/Y", mktime(0, 0, 0, $mois, $jour, $annee));
}

/**
 * Indique si une date est incluse ou non dans l'annÈe ÈcoulÈe.
 * 
 * Retourne true si la date $date est comprise entre la date du jour moins un an et la 
 * la date du jour. False sinon.   
 * @param $date date au format jj/mm/aaaa
 * @return boolean succ√®s ou Èchec
*/
function estDansAnneeEcoulee($date) {
	$dateAnglais = convertirDateFrancaisVersAnglais($date);
	$dateDuJourAnglais = date("Y-m-d");
	$dateDuJourMoinsUnAnAnglais = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y") - 1));
	return ($dateAnglais >= $dateDuJourMoinsUnAnAnglais) && ($dateAnglais <= $dateDuJourAnglais);
}

/** 
 * VÈrifie si une chaine fournie est bien numÈrique entiÈre positive.                     
 * 
 * Retrourne true si la valeur transmise $valeur ne contient pas d'autres 
 * caractÈres que des chiffres, false sinon.
 * @param string chaine ‡† vÈrifier
 * @return boolean succÈs ou Èchec
 */ 
function estEntierPositif($valeur) {
    return preg_match("/[^0-9]/", $valeur) == 0;
}

/** 
 * VÈrifie que chaque valeur est bien renseignÈe et numÈrique entiÈre positive.
 *  
 * Renvoie la valeur boolÈenne true si toutes les valeurs sont bien renseignÈes et
 * numÈriques entiËres positives. False si l'une d'elles ne l'est pas.
 * @param array $lesValeurs tableau des valeurs
 * @return boolÈen succËs ou Èchec
 */ 
function verifierEntiersPositifs($lesValeurs){
    $ok = true;     
    foreach ( $lesValeurs as $val ) {
        if ($val=="" || ! estEntierPositif($val) ) {
            $ok = false;
        }
    }
    return $ok; 
}

/** 
 * Fournit la valeur d'une donnÈe transmise par la mÈthode get (url).                    
 * 
 * Retourne la valeur de la donnÈe portant le nom $nomDonnee re√ßue dans l'url, 
 * $valDefaut si aucune donnÈe de nom $nomDonnee dans l'url 
 * @param string nom de la donnÈe
 * @param string valeur par dÈfaut 
 * @return string valeur de la donnÈe
 */ 
function lireDonneeUrl($nomDonnee, $valDefaut="") {
    if ( isset($_GET[$nomDonnee]) ) {
        $val = $_GET[$nomDonnee];
    }
    else {
        $val = $valDefaut;
    }
    return $val;
}

/** 
 * Fournit la valeur d'une donnÈe transmise par la mÈthode post 
 *  (corps de la requËte HTTP).                    
 * 
 * Retourne la valeur de la donnÈe portant le nom $nomDonnee reÁue dans le corps de la requËte http, 
 * $valDefaut si aucune donnÈe de nom $nomDonnee dans le corps de requËte
 * @param string nom de la donnÈe
 * @param string valeur par dÈfaut 
 * @return string valeur de la donnÈe
 */ 
function lireDonneePost($nomDonnee, $valDefaut="") {
    if ( isset($_POST[$nomDonnee]) ) {
        $val = $_POST[$nomDonnee];
    }
    else {
        $val = $valDefaut;
    }
    return $val;
}

/** 
 * Fournit la valeur d'une donnÈe transmise par la mÈthode get (url) ou post 
 *  (corps de la requÈte HTTP).                    
 * 
 * Retourne la valeur de la donnÈe portant le nom $nomDonnee
 * reÁue dans l'url ou corps de requËte, 
 * $valDefaut si aucune donnÈe de nom $nomDonnee ni dans l'url, ni dans corps.
 * Si le mÍme nom a ÈtÈ transmis ‡† la fois dans l'url et le corps de la requËte,
 * c'est la valeur transmise par l'url qui est retourn√©e.  
 * @param string nom de la donn√©e
 * @param string valeur par d√©faut 
 * @return string valeur de la donn√©e
 */ 
function lireDonnee($nomDonnee, $valDefaut="") {
    if ( isset($_GET[$nomDonnee]) ) {
        $val = $_GET[$nomDonnee];
    }
    elseif ( isset($_POST[$nomDonnee]) ) {
        $val = $_POST[$nomDonnee];
    }
    else {
        $val = $valDefaut;
    }
    return $val;
}

/** 
 * Ajoute un message dans le tableau des messages d'erreurs.                    
 * 
 * Ajoute le message $msg en fin de tableau $tabErr. Ce tableau est pass√© par 
 * r√©f√©rence afin que les modifications sur ce tableau soient visibles de l'appelant.  
 * @param array $tabErr  
 * @param string message
 * @return void
 */ 
function ajouterErreur(&$tabErr,$msg) {
    $tabErr[count($tabErr)]=$msg;
}

/** 
 * Retourne le nombre de messages d'erreurs enregistr√©s.                    
 * 
 * Retourne le nombre de messages d'erreurs enregistr√©s dans le tableau $tabErr. 
 * @param array $tabErr tableau des messages d'erreurs  
 * @return int nombre de messages d'erreurs
 */ 
function nbErreurs($tabErr) {
    return count($tabErr);
}
 
/** 
 * Fournit les messages d'erreurs sous forme d'une liste √† puces HTML.                    
 * 
 * Retourne le source HTML, division contenant une liste √† puces, d'apr√®s les
 * messages d'erreurs contenus dans le tableau des messages d'erreurs $tabErr. 
 * @param array $tabErr tableau des messages d'erreurs  
 * @return string source html
 */ 
function toStringErreurs($tabErr) {
    $str = '<div class="erreur">';
    $str .= '<ul>';
    foreach($tabErr as $erreur){
        $str .= '<li>' . $erreur . '</li>';
	}
    $str .= '</ul>';
    $str .= '</div>';
    return $str;
} 

/** 
 * Echappe les caract√®res consid√©r√©s sp√©ciaux en HTML par les entit√©s HTML correspondantes.
 *  
 * Renvoie une copie de la cha√Æne $str √† laquelle les caract√®res consid√©r√©s sp√©ciaux
 * en HTML (tq la quote simple, le guillemet double, les chevrons), auront √©t√©
 * remplac√©s par les entit√©s HTML correspondantes. 
 * @param string $str cha√Æne √† √©chapper
 * @return string cha√Æne √©chapp√©e 
 */ 
function filtrerChainePourNavig($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/** 
 * V√©rifie la validit√© des donn√©es d'une ligne de frais hors forfait.
 *  
 * Renseigne le tableau des messages d'erreurs d'apr√®s les erreurs rencontr√©es
 * sur chaque donn√©e d'une ligne de frais hors forfait : v√©rifie que chaque 
 * donn√©e est bien renseign√©e, le montant est num√©rique positif, la date valide
 * et dans l'ann√©e √©coul√©e.  
 * @param array $date date d'engagement de la ligne de frais HF
 * @param array $libelle libell√© de la ligne de frais HF
 * @param array $montant montant de la ligne de frais HF
 * @param array $tabErrs tableau des messages d'erreurs pass√© par r√©f√©rence
 * @return void
 */ 
function verifierLigneFraisHF($date, $libelle, $montant, &$tabErrs) {
    // v√©rification du libell√© 
    if ($libelle == "") {
		ajouterErreur($tabErrs, "Le libell√© doit √™tre renseign√©.");
	}
	// v√©rification du montant
	if ($montant == "") {
		ajouterErreur($tabErrs, "Le montant doit √™tre renseign√©.");
	}
	elseif ( !is_numeric($montant) || $montant < 0 ) {
        ajouterErreur($tabErrs, "Le montant doit √™tre num√©rique positif.");
    }
    // v√©rification de la date d'engagement
	if ($date == "") {
		ajouterErreur($tabErrs, "La date d'engagement doit √™tre renseign√©e.");
	}
	elseif (!estDate($date)) {
		ajouterErreur($tabErrs, "La date d'engagement doit √™tre valide au format JJ/MM/AAAA");
	}	
	elseif (!estDansAnneeEcoulee($date)) {
	    ajouterErreur($tabErrs,"La date d'engagement doit se situer dans l'ann√©e √©coul√©e");
    }
}
?>