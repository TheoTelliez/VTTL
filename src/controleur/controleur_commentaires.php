<?php

function actionVTTCommentaires($twig, $db) {
    $form = array();
    if (isset($_POST['btVTTCommentaires'])) { //Détermine si une variable est considérée définie, ceci signifie qu'elle est déclarée et est différente de NULL.
        $inputVTTCommentaireidUtilisateur = $_POST['inputVTTCommentaireidUtilisateur'];
        $inputVTTCommentaireTitre = $_POST['inputVTTCommentaireTitre'];
        $inputVTTCommentaireMessage = $_POST['inputVTTCommentaireMessage'];
        $inputVTTCommentaireNote = $_POST['inputVTTCommentaireNote'];
        $inputVTTCommentaireDate = $_POST['inputVTTCommentaireDate'];
        $form['valide'] = true;
        $form['inputVTTCommentaireidUtilisateur'] = $inputVTTCommentaireidUtilisateur;
        $form['inputVTTCommentaireTitre'] = $inputVTTCommentaireTitre;
        $form['inputVTTCommentaireNote'] = $inputVTTCommentaireNote;

        if ($inputVTTCommentaireNote > 5) {
            $inputVTTCommentaireNote = 5;
        }

        $form['inputVTTCommentaireMessage'] = $inputVTTCommentaireMessage;
        $form['inputVTTCommentaireDate'] = $inputVTTCommentaireDate;
        $commentairevttl = new Commentairevttl($db);
        $inputVTTCommentaireDate = date('Y-m-d H:i:s', strtotime($inputVTTCommentaireDate));
        $exec = $commentairevttl->insert($inputVTTCommentaireTitre, $inputVTTCommentaireMessage, $inputVTTCommentaireNote, $inputVTTCommentaireDate, $inputVTTCommentaireidUtilisateur);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème d\'insertion dans la table commentaire ';
        } else
            $form['message'] = 'Insertion dans la table commentaire validée';
    }
    $commentairevttl = new Commentairevttl($db);
    $liste = $commentairevttl->select();
    echo $twig->render('vttcommentaires.html.twig', array('form' => $form, 'liste' => $liste));
}

function actionVTTCommentairesAdmin($twig, $db) {
    $commentairevttl = new Commentairevttl($db);
    if (isset($_GET['id'])) {
        $exec = $commentairevttl->delete($_GET['id']);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table commentaire';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Commentaire supprimé avec succès';
        }
    }


    $limite = 2;
    if (!isset($_GET['nopage'])) {
        $inf = 0;
        $nopage = 0;
    } else {
        $nopage = $_GET['nopage'];
        $inf = $nopage * $limite;
    }
    $r = $commentairevttl->selectCount();
    $nb = $r['nb'];


    $liste = $commentairevttl->selectLimit($inf, $limite);
    $form['nbpages'] = ceil($nb / $limite);

    echo $twig->render('vttcommentairesadmin.html.twig', array('form' => $form, 'liste' => $liste));
}

?>
