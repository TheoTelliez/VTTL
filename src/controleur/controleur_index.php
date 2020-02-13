<?php

function actionAccueil($twig, $db) {
    $commentairevttl = new Commentairevttl($db);
    $listedernier = $commentairevttl->selectLeDernier();
    $listedernier1 = $commentairevttl->selectLeDernier1();
    $listedernier2 = $commentairevttl->selectLeDernier2();
    $listedernier3 = $commentairevttl->selectLeDernier3();
    echo $twig->render('index.html.twig', array('listedernier' => $listedernier, 'listedernier1' => $listedernier1, 'listedernier2' => $listedernier2, 'listedernier3' => $listedernier3));
}

function actionApropos($twig) {
    echo $twig->render('apropos.html.twig', array());
}

function actionMentions($twig) {
    echo $twig->render('mentions.html.twig', array());
}

function actionDeconnexion($twig) {
    session_unset();
    session_destroy();
    header("Location:index.php");
}


?>