<?php

function actionVTTUtilisateur($twig, $db) {
    $form = array();
    $utilisateur = new Utilisateurvttl($db);    //mise en mémoire de tout les outils de la class_utilisateur.php
    if (isset($_GET['email'])) {
        $exec = $utilisateur->delete($_GET['email']);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table utilisateurvttl';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Utilisateur supprimé avec succès';
        }
    }
    $liste = $utilisateur->select();
    echo $twig->render('utilisateuradmin.html.twig', array('form' => $form, 'liste' => $liste));
}


?>
