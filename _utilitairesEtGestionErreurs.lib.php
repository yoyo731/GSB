<?php
/** 
 * Regroupe les fonctions utilitaires et de gestion des erreurs.
 * @package default
 * @todo  fonction estMoisValide � d�finir compl�tement ou � supprimer
 */

/** 
 * Fournit le libell� en fran�ais correspondant à un num�ro de mois.                     
 *
 * Fournit le libell� fran�ais du mois de num�ro $unNoMois.
 * Retourne une chaine vide si le num�ro n'est pas compris dans l'intervalle [1,12].
 * @param int num�ro de mois
 * @return string identifiant de connexion
 */
function obtenirLibelleMois($unNoMois) {
    $tabLibelles = array(1=>"Janvier", 
                            "Février", "Mars", "Avril", "Mai", "Juin", "Juillet",
                            "Août", "Septembre", "Octobre", "Novembre", "Décembre");
    $libelle="";
    if ( $unNoMois >=1 && $unNoMois <= 12 ) {
        $libelle = $tabLibelles[$unNoMois];
    }
    return $libelle;
}

/** 
 * V�rifie si une chaine fournie est bien une date valide, au format JJ/MM/AAAA.                     
 * 
 * Retrourne true si la chaine $date est une date valide, au format JJ/MM/AAAA, false sinon.
 * @param string date à v�rifier
 * @return boolean succès ou �chec
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
 * Transforme une date au format fran�ais jj/mm/aaaa vers le format anglais aaaa-mm-jj
 * @param $date au format  jj/mm/aaaa
 * @return string la date au format anglais aaaa-mm-jj
*/
function convertirDateFrancaisVersAnglais($date){
	@list($jour,$mois,$annee) = explode('/',$date);
	return date("Y-m-d", mktime(0, 0, 0, $mois, $jour, $annee));
}

/**
 * Transforme une date au format format anglais aaaa-mm-jj vers le format 
 * fran�ais jj/mm/aaaa 
 * @param $date au format  aaaa-mm-jj
 * @return string la date au format format fran�ais jj/mm/aaaa
*/
function convertirDateAnglaisVersFrancais($date){
    @list($annee,$mois,$jour) = explode('-',$date);
	return date("d/m/Y", mktime(0, 0, 0, $mois, $jour, $annee));
}

/**
 * Indique si une date est incluse ou non dans l'ann�e �coul�e.
 * 
 * Retourne true si la date $date est comprise entre la date du jour moins un an et la 
 * la date du jour. False sinon.   
 * @param $date date au format jj/mm/aaaa
 * @return boolean succès ou �chec
*/
function estDansAnneeEcoulee($date) {
	$dateAnglais = convertirDateFrancaisVersAnglais($date);
	$dateDuJourAnglais = date("Y-m-d");
	$dateDuJourMoinsUnAnAnglais = date("Y-m-d", mktime(0, 0, 0, date("m"), date("d"), date("Y") - 1));
	return ($dateAnglais >= $dateDuJourMoinsUnAnAnglais) && ($dateAnglais <= $dateDuJourAnglais);
}

/** 
 * V�rifie si une chaine fournie est bien num�rique enti�re positive.                     
 * 
 * Retrourne true si la valeur transmise $valeur ne contient pas d'autres 
 * caract�res que des chiffres, false sinon.
 * @param string chaine � v�rifier
 * @return boolean succ�s ou �chec
 */ 
function estEntierPositif($valeur) {
    return preg_match("/[^0-9]/", $valeur) == 0;
}

/** 
 * V�rifie que chaque valeur est bien renseign�e et num�rique enti�re positive.
 *  
 * Renvoie la valeur bool�enne true si toutes les valeurs sont bien renseign�es et
 * num�riques enti�res positives. False si l'une d'elles ne l'est pas.
 * @param array $lesValeurs tableau des valeurs
 * @return bool�en succ�s ou �chec
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
 * Fournit la valeur d'une donn�e transmise par la m�thode get (url).                    
 * 
 * Retourne la valeur de la donn�e portant le nom $nomDonnee reçue dans l'url, 
 * $valDefaut si aucune donn�e de nom $nomDonnee dans l'url 
 * @param string nom de la donn�e
 * @param string valeur par d�faut 
 * @return string valeur de la donn�e
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
 * Fournit la valeur d'une donn�e transmise par la m�thode post 
 *  (corps de la requ�te HTTP).                    
 * 
 * Retourne la valeur de la donn�e portant le nom $nomDonnee re�ue dans le corps de la requ�te http, 
 * $valDefaut si aucune donn�e de nom $nomDonnee dans le corps de requ�te
 * @param string nom de la donn�e
 * @param string valeur par d�faut 
 * @return string valeur de la donn�e
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
 * Fournit la valeur d'une donn�e transmise par la m�thode get (url) ou post 
 *  (corps de la requ�te HTTP).                    
 * 
 * Retourne la valeur de la donn�e portant le nom $nomDonnee
 * re�ue dans l'url ou corps de requ�te, 
 * $valDefaut si aucune donn�e de nom $nomDonnee ni dans l'url, ni dans corps.
 * Si le m�me nom a �t� transmis � la fois dans l'url et le corps de la requ�te,
 * c'est la valeur transmise par l'url qui est retournée.  
 * @param string nom de la donnée
 * @param string valeur par défaut 
 * @return string valeur de la donnée
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
 * Ajoute le message $msg en fin de tableau $tabErr. Ce tableau est passé par 
 * référence afin que les modifications sur ce tableau soient visibles de l'appelant.  
 * @param array $tabErr  
 * @param string message
 * @return void
 */ 
function ajouterErreur(&$tabErr,$msg) {
    $tabErr[count($tabErr)]=$msg;
}

/** 
 * Retourne le nombre de messages d'erreurs enregistrés.                    
 * 
 * Retourne le nombre de messages d'erreurs enregistrés dans le tableau $tabErr. 
 * @param array $tabErr tableau des messages d'erreurs  
 * @return int nombre de messages d'erreurs
 */ 
function nbErreurs($tabErr) {
    return count($tabErr);
}
 
/** 
 * Fournit les messages d'erreurs sous forme d'une liste à puces HTML.                    
 * 
 * Retourne le source HTML, division contenant une liste à puces, d'après les
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
 * Echappe les caractères considérés spéciaux en HTML par les entités HTML correspondantes.
 *  
 * Renvoie une copie de la chaîne $str à laquelle les caractères considérés spéciaux
 * en HTML (tq la quote simple, le guillemet double, les chevrons), auront été
 * remplacés par les entités HTML correspondantes. 
 * @param string $str chaîne à échapper
 * @return string chaîne échappée 
 */ 
function filtrerChainePourNavig($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/** 
 * Vérifie la validité des données d'une ligne de frais hors forfait.
 *  
 * Renseigne le tableau des messages d'erreurs d'après les erreurs rencontrées
 * sur chaque donnée d'une ligne de frais hors forfait : vérifie que chaque 
 * donnée est bien renseignée, le montant est numérique positif, la date valide
 * et dans l'année écoulée.  
 * @param array $date date d'engagement de la ligne de frais HF
 * @param array $libelle libellé de la ligne de frais HF
 * @param array $montant montant de la ligne de frais HF
 * @param array $tabErrs tableau des messages d'erreurs passé par référence
 * @return void
 */ 
function verifierLigneFraisHF($date, $libelle, $montant, &$tabErrs) {
    // vérification du libellé 
    if ($libelle == "") {
		ajouterErreur($tabErrs, "Le libellé doit être renseigné.");
	}
	// vérification du montant
	if ($montant == "") {
		ajouterErreur($tabErrs, "Le montant doit être renseigné.");
	}
	elseif ( !is_numeric($montant) || $montant < 0 ) {
        ajouterErreur($tabErrs, "Le montant doit être numérique positif.");
    }
    // vérification de la date d'engagement
	if ($date == "") {
		ajouterErreur($tabErrs, "La date d'engagement doit être renseignée.");
	}
	elseif (!estDate($date)) {
		ajouterErreur($tabErrs, "La date d'engagement doit être valide au format JJ/MM/AAAA");
	}	
	elseif (!estDansAnneeEcoulee($date)) {
	    ajouterErreur($tabErrs,"La date d'engagement doit se situer dans l'année écoulée");
    }
}
?>