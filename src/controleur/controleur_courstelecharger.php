<?php

// Téléchargement des cours //
// Télécharger la liste entière des cours : //

function actionListeCoursPdf($twig, $db) {
    $cours = new Cours($db);
    $listecours = $unCours = $cours->select();
    $html = $twig->render('cours-liste-pdf.html.twig', array('listecours' => $listecours)); // Nous envoyons notre liste de cours dans le moteur de template TWIG.
    $entetevttl = $twig->render('entetevttl.html.twig', array()); // Nous envoyons notre entête dans le moteur de template TWIG.
    try {
        ob_end_clean(); // Cette commande s'assure de ne pas envoyer de données avant le fichier PDF
        $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'fr'); // Création d'une page au format A4 de langue française orienté en mode portrait.
//        $html2pdf->WriteHTML($entetevttl); // pour prendre en compte les head, meta, etc.
        $html2pdf->writeHTML($html); //Nous écrivons le résultat de twig dans la variable html2pdf

        $html2pdf->output('listedescours.pdf'); // Nous écrivons dans un fichier PDF nommé listedescours
    } catch (Html2PdfException $e) {
        echo 'erreur ' . $e;
    }
}

// Télécharger un cours en particulier avec son ID : //

function actionTelechargerCoursPdf($twig, $db) {

    $cours = new Cours($db);
    $lecours = $unCours = $cours->selectByIdcours($_GET['idcours']);
    if ($unCours != null) {
        $form['cours'] = $unCours;
    } else {
        $form['message'] = 'Cours incorrect';
    }
    $section = new Section($db);
    $uneSection = $section->selectByIdcours($_GET['idcours']);
    if ($uneSection != null) {
        $form['section'] = $uneSection;
    } else {
        $form['message'] = 'Section incorrecte';
    }

    $html = $twig->render('cours-telecharger-pdf.html.twig', array('form' => $form, 'lecours' => $lecours)); // Nous envoyons notre liste de cours dans le moteur de template TWIG.
    $entetevttl = $twig->render('entetevttl.html.twig', array()); // Nous envoyons notre entête dans le moteur de template TWIG.
    try {
        ob_end_clean(); // Cette commande s'assure de ne pas envoyer de données avant le fichier PDF
        $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'fr'); // Création d'une page au format A4 de langue française orienté en mode portrait.
        $html2pdf->writeHTML($html); //Nous écrivons le résultat de twig dans la variable html2pdf

        $html2pdf->output('cours.pdf'); // Nous écrivons dans un fichier PDF nommé cours
    } catch (Html2PdfException $e) {
        echo 'erreur ' . $e;
    }
}

?>
