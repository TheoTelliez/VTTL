<?php

function actionContactvttl($twig, $db) {
    $form = array();
    if (isset($_POST['btVTTContact'])) { //Détermine si une variable est considérée définie, ceci signifie qu'elle est déclarée et est différente de NULL.
        $inputVTTContactNom = $_POST['inputVTTContactNom'];
        $inputVTTContactPrenom = $_POST['inputVTTContactPrenom'];
        $inputVTTContactEmail = $_POST['inputVTTContactEmail'];
        $inputVTTContactDate = $_POST['inputVTTContactDate'];
        $inputVTTContactMessage = $_POST['inputVTTContactMessage'];
        $form['valide'] = true;
        $form['inputVTTContactNom'] = $inputVTTContactNom;
        $form['inputVTTContactPrenom'] = $inputVTTContactPrenom;
        $form['inputVTTContactEmail'] = $inputVTTContactEmail;
        $form['inputVTTContactDate'] = $inputVTTContactDate;
        $form['inputVTTContactMessage'] = $inputVTTContactMessage;
        $contactvttl = new Contactvttl($db);
        $inputVTTContactDate = date('Y-m-d H:i:s', strtotime($inputVTTContactDate));
        $exec = $contactvttl->insert($inputVTTContactNom, $inputVTTContactPrenom, $inputVTTContactEmail, $inputVTTContactDate, $inputVTTContactMessage);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème d\'insertion dans la table commentaire ';
        } else
            $form['message'] = 'Insertion dans la table commentaire validée';
    }
    $contactvttl = new Contactvttl($db);
    $liste = $contactvttl->select();
    echo $twig->render('contact.html.twig', array('form' => $form, 'liste' => $liste));
}

function actionContactAdminvttl($twig, $db) {
    $contactvttl = new Contactvttl($db);
    if (isset($_GET['id'])) {
        $exec = $contactvttl->delete($_GET['id']);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table contact';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Message de contact supprimé avec succès';
        }
    }
    $liste = $contactvttl->select();
    echo $twig->render('contactadmin.html.twig', array('liste' => $liste));
}
?>

