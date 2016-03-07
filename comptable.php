<?php
/*
 *Le controleur de page qui gere les personnes
 */
if (isset($_GET['action']))
    $action = $_GET['action'];
else
    if (isset($_POST['action']))
        $action = $_POST['action'];
    else
        $action='connexion';

// si action=une_valeur est envoyée au script nous avons recupere dans $action la valeur et read sinon
switch ($action){
        case 'connexion':
				require_once MODELSPATH.'_init.inc.php';
                require_once TEMPLATESPATH.'_entete.inc.html';
				require_once TEMPLATESPATH.'_sommaire.inc.php';
				require_once VIEWSPATH.'cSeConnecter.php';
				require_once TEMPLATESPATH.'_pied.inc.html';
                break;
		case 'accueil':
				require_once MODELSPATH.'_init.inc.php';
                require_once TEMPLATESPATH.'_entete.inc.html';
				require_once TEMPLATESPATH.'_sommaire.inc.php';
				require_once VIEWSPATH.'cAccueil.php';
                break;
        case 'saisir':
				require_once MODELSPATH.'_init.inc.php';
                require_once TEMPLATESPATH.'_entete.inc.html';
				require_once TEMPLATESPATH.'_sommaire.inc.php';
				require_once VIEWSPATH.'cSaisieFicheFrais.php';
                require_once TEMPLATESPATH.'_pied.inc.html';
                break;
            
        case 'deconnecter':
				require_once MODELSPATH.'_init.inc.php';
				require_once VIEWSPATH.'cSeDeconnecter.php';
				unset($_SESSION["idUser"]);
				unset($_SESSION["loginUser"]);
				header('Location: '.URL.'index.php?');
                break;
				
        case'consulter':
				require_once MODELSPATH.'_init.inc.php';
				require_once TEMPLATESPATH.'_entete.inc.html';
				require_once TEMPLATESPATH.'_sommaire.inc.php';
				require_once VIEWSPATH.'cConsultFichesFrais.php';
                require_once TEMPLATESPATH.'_pied.inc.html';
                break;
                
        default;
                ;
                break;
}
?>