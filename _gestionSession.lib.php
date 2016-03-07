<?php
/** 
 * Regroupe les fonctions de gestion d'une session utilisateur.
 * @package default
 * @todo  RAS
 */

/** 
 * Demarre ou poursuit une session.                     
 *
 * @return void
 */
function initSession() {
    session_start();
}

/** 
 * Fournit l'id du visiteur connect�.                     
 *
 * Retourne l'id du visiteur connect�, une chaine vide si pas de visiteur connect�.
 * @return string id du visiteur connect�
 */
function obtenirIdUserConnecte() {
    $ident="";
    if ( isset($_SESSION["loginUser"]) ) {
        $ident = (isset($_SESSION["idUser"])) ? $_SESSION["idUser"] : '';   
    }  
    return $ident ;
}

/**
 * Conserve en variables session les informations du visiteur connect�
 * 
 * Conserve en variables session l'id $id et le login $login du visiteur connect�
 * @param string id du visiteur
 * @param string login du visiteur
 * @return void    
 */
function affecterInfosConnecte($id, $login) {
    $_SESSION["idUser"] = $id;
    $_SESSION["loginUser"] = $login;
}

/** 
 * D�connecte le visiteur qui s'est identifi� sur le site.                     
 *
 * @return void
 */
function deconnecterVisiteur() {
    unset($_SESSION["idUser"]);
    unset($_SESSION["loginUser"]);
}

/** 
 * V�rifie si un visiteur s'est connect� sur le site.                     
 *
 * Retourne true si un visiteur s'est identifié sur le site, false sinon. 
 * @return boolean �chec ou succ�s
 */
function estVisiteurConnecte() {
    // actuellement il n'y a que les visiteurs qui se connectent
    return isset($_SESSION["loginUser"]);
}



?>