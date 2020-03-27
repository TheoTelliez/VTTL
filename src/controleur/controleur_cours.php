<?php

// Visualisation des cours //
 
// Visualiser la liste des cours : //

function actionCours($twig, $db) {
    $form = array();
    $form['valide'] = true;
    $cours = new Cours($db);

    if (isset($_GET['supp'])) {
        $exec = $cours->deletesection($_GET['supp']);
        $exec = $cours->deletecours($_GET['supp']);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table cours';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Cours supprimé avec succès';
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
    $r = $cours->selectCount();
    $nb = $r['nb'];


    $listecours = $cours->selectLimit($inf, $limite);
    $form['nbpages'] = ceil($nb / $limite);

    echo $twig->render('cours.html.twig', array('form' => $form, 'listecours' => $listecours));
}


// Visualiser un cours en particulier avec son ID : //

function actionVoirCours($twig, $db) {
    $form = array();
    $form['valide'] = true;

    if (isset($_GET['idcours'])) {
        $section = new Section($db);
        $uneSection = $section->selectByIdcours($_GET['idcours']);
        if ($uneSection != null) {
            $form['section'] = $uneSection;
        } else {
            $form['message'] = 'Section incorrecte';
        }
        $cours = new Cours($db);
        $unCours = $cours->selectByIdcours($_GET['idcours']);
        if ($unCours != null) {
            $form['cours'] = $unCours;
        } else {
            $form['message'] = 'Cours incorrect';
        }
    } else {
        $form['message'] = 'Cours non précisé';
    }

    echo $twig->render('voircours.html.twig', array('form' => $form));
}

?>
