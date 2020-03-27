<?php

function getPage($db) {
// Inscrire vos contrôleurs ici
    $lesPages['accueil'] = "actionAccueil;0";
    $lesPages['maintenance'] = "actionMaintenance;0";
    $lesPages['apropos'] = "actionApropos;0";
    $lesPages['contact'] = "actionContactvttl;0";
    $lesPages['mentions'] = "actionMentions;0";
    $lesPages['commentaire'] = "actionVTTCommentaires;0";
    $lesPages['connexion'] = "actionVTTConnexion;0";
    $lesPages['deconnexion'] = "actionDeconnexion;0";
    $lesPages['inscription'] = "actionVTTInscription;0";
    $lesPages['contactadmin'] = "actionContactAdminvttl;1";
    $lesPages['commentaireadmin'] = "actionVTTCommentairesAdmin;1";
    $lesPages['utilisateuradmin'] = "actionVTTUtilisateur;1";
    $lesPages['profil'] = "actionVTTProfil;0";
    $lesPages['modifprofil'] = "actionVTTModifProfil;0";
    $lesPages['modifphoto'] = "actionVTTModifPhoto;0";
    $lesPages['puzzle'] = "actionPuzzle;1";
    $lesPages['mdpoublie'] = "actionMdpOublie;0";
    $lesPages['checkmail'] = "actionCheckMail;0";
    $lesPages['modifmotdepasse'] = "actionModifMotDePasse;0";
    $lesPages['ajoutcours'] = "actionAjoutCours;1";
    $lesPages['logsadmin'] = "actionLogsAdmin;1";
    $lesPages['logsvttl'] = "actionLogsVttl;0";
    $lesPages['stats'] = "actionStats;1";
    $lesPages['cours'] = "actionCours;0";
    $lesPages['listecourspdf'] = "actionListeCoursPdf;0";
    $lesPages['difficulte'] = "actionDifficulte;1";
    $lesPages['modifdifficulte'] = "actionModifDifficulte;1";
    $lesPages['paneladmin'] = "actionPanelAdmin;1";
    $lesPages['voircours'] = "actionVoirCours;0";
    $lesPages['modifcours'] = "actionModifCours;1";
    $lesPages['telechargercours'] = "actionTelechargerCoursPdf;0";
    $lesPages['stats'] = "actionStats;1";
    $lesPages['recherches'] = "actionRecherches;0";
    $lesPages['resultatrecherches'] = "actionResultatRecherches;0";
    $lesPages['checkcompte'] = "actionCheckCompte;0";
    $lesPages['validecompte'] = "actionValideCompte;0";
    $lesPages['sommaire'] = "actionSommaire;0";

    if ($db != null) {
        if (isset($_GET['page'])) {
// Nous mettons dans la variable $page, la valeur qui a été passée dans le lien
            $page = $_GET['page'];
        } else {
// S'il n'y a rien en mémoire, nous lui donnons la valeur « accueil » afin de lui afficher une page
//par défaut
            $page = 'accueil';
        }
        if (!isset($lesPages[$page])) {
// Nous rentrons ici si cela n'existe pas, ainsi nous redirigeons l'utilisateur sur la page d'accueil
            $page = 'accueil';
        }

        $explose = explode(";", $lesPages[$page]);
        $role = $explose[1];
        if ($role != 0) {
            if (isset($_SESSION['login'])) {
                if (isset($_SESSION['role'])) {
                    if ($role != $_SESSION['role']) {
                        $contenu = 'actionAccueil';
                    } else {
                        $contenu = $explose[0];
                    }
                } else {
                    $contenu = 'actionAccueil';
                }
            } else {
                $contenu = 'actionAccueil';
            }
        } else {
            $contenu = $explose[0];
        }
    } else {
// Si $db est null
        $contenu = 'actionMaintenance';
    }
// La fonction envoie le contenu
    return $contenu;
}

?>