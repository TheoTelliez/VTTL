<?php

function actionAjoutCours($twig, $db) {
    $form = array();
    $nb = 3;
    
    if (isset($_POST['inputNbTitre'])) {
    $nb = (int)$_POST['inputNbTitre'];
//    var_dump($nb);
    }

    if (isset($_POST['btAjoutSection'])) {
        $nb = $nb+1;
        }
    
    if (isset($_POST['btAjoutCours'])) {
        $inputTitre = $_POST['inputTitre'];
        $inputSousTitre = $_POST['inputSousTitre'];
        $inputContenu = $_POST['inputContenu'];
        $form['valide'] = true;
        $form['inputTitre'] = $inputTitre;
        $form['inputSousTitre'] = $inputSousTitre;
        $form['inputContenu'] = $inputContenu;
 
    }

    echo $twig->render('ajoutcours.html.twig', array('form' => $form, 'nb' => $nb ));
}