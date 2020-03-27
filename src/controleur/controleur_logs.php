<?php

function actionLogsAdmin($twig, $db) {
    $form = array();
    $logs = new Connexion($db);

    if (isset($_POST['btToutVider'])) {
        $form['valide'] = true;
        $logs = new Connexion($db);
        $exec = $logs->toutVider();
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Echec lors du vidage de la table connexions';
        } else
            $form['message'] = 'Vidage de la table connexions validé';
    }


    $limite = 5; // On règle ici la limite d'affichages dans le tableau
    if (!isset($_GET['nopage'])) {
        $inf = 0;
        $nopage = 0;
    } else {
        $nopage = $_GET['nopage'];
        $inf = $nopage * $limite;
    }
    $r = $logs->selectCount();
    $nb = $r['nb'];


    $liste = $logs->selectLimit($inf, $limite); // Bien faire attention au fait que le $liste doit apparaitre une seule fois avec le selectLimit et pas le select (on doit l'enlever)
    $form['nbpages'] = ceil($nb / $limite);
    echo $twig->render('logsadmin.html.twig', array('form' => $form, 'liste' => $liste));
}

function actionLogsVttl($twig, $db) {
    $form = array();
    $logs = new Connexion($db);
    $limite = 5; // On règle ici la limite d'affichages dans le tableau
    if (!isset($_GET['nopage'])) {
        $inf = 0;
        $nopage = 0;
    } else {
        $nopage = $_GET['nopage'];
        $inf = $nopage * $limite;
    }
    $emailco = $_SESSION['login'];
    $r = $logs->selectCountEmail($emailco);
    $nb = $r['nb'];


    $liste = $logs->selectLimitEmail($inf, $limite, $emailco); // Bien faire attention au fait que le $liste doit apparaitre une seule fois avec le selectLimit et pas le select (on doit l'enlever)
    $form['nbpages'] = ceil($nb / $limite);
    echo $twig->render('logsvttl.html.twig', array('form' => $form, 'liste' => $liste));
}

?>
