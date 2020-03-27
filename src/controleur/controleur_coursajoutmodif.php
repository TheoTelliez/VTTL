<?php

// Édition ou Modification des cours //
// 
// Ajouter un cours : //

function actionAjoutCours($twig, $db) {

    $form = array();
    $nb = 1;

    if (isset($_POST['inputNbTitre'])) {
        $nb = (int) $_POST['inputNbTitre'];
    }

    if (isset($_POST['btAjoutSection'])) {
        $nb = $nb + 1;
    }

    if (isset($_POST['btAjoutCours'])) {
        $auteur = $_SESSION['login'];
        $inputTitre = $_POST['inputTitre'];
        $inputSousTitre = $_POST['inputSousTitre'];
        $inputContenu = $_POST['inputContenu'];
        $difficultecours = $_POST['difficultecours'];
        date_default_timezone_set('Europe/Paris');
        $dateajout = date("Y-m-d H:i:s");
        $datedernieremodif = date("Y-m-d H:i:s");
        $difficulte = new Difficulte($db);
        $listedifficulte = $difficulte->select();



        $form['valide'] = true;
        $form['auteur'] = $auteur;
        $form['inputTitre'] = $inputTitre;
        $form['inputSousTitre'] = $inputSousTitre;
        $form['inputContenu'] = $inputContenu;
        $form['difficultecours'] = $difficultecours; //bien différencier le $difficultecours du $listedifficulte sinon cela crée un conflit : Notice: Array to string conversion in...
        $form['dateajout'] = $dateajout;
        $form['datedernieremodif'] = $datedernieremodif;
        $form['difficulte'] = $listedifficulte;
        $form['ajoutdifficulte'] = $difficulte->selectByIdDifficulte($difficultecours);

        $cours = new Cours($db);
        $exec = $cours->insert($inputTitre, $difficultecours, $dateajout, $datedernieremodif, $auteur);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème d\'insertion dans la table cours';
        } else {
            $form['message'] = 'Insertion dans la table cours validée';
        }

        $idcours = $db->lastInsertId();

        $contenu = new Section($db);

        $nbSousTitre = count($inputSousTitre);

        for ($i = 0; $i < count($inputSousTitre); $i++) {
            if (empty($inputSousTitre[$i]) && empty($inputContenu[$i])) {
                $form['message'] = 'Une section n\'a pas été ajoutée car elle était vide';
            } else {
                $exec = $contenu->insert($inputSousTitre[$i], $inputContenu[$i], $idcours);
            }
        }
    }

    $difficulte = new Difficulte($db);
    $listedifficulte = $difficulte->select();
    $form['difficulte'] = $listedifficulte;


    echo $twig->render('ajoutcours.html.twig', array('form' => $form, 'listedifficulte' => $listedifficulte, 'nb' => $nb));
}

// Modifier un cours : //

function actionModifCours($twig, $db) {
    $form = array();
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
            $difficulte = new Difficulte($db);
            $listedifficulte = $difficulte->select();
            $form['difficulte'] = $listedifficulte;
        } else {
            $form['message'] = 'Cours incorrect';
        }
//        var_dump($uneSection);
    } else {
        if (isset($_POST['btModifierCours'])) {
            $auteur = $_SESSION['login'];
            $inputModifTitre = $_POST['inputModifTitre'];
            $inputModifSousTitre = $_POST['inputModifSousTitre'];
            $inputModifContenu = $_POST['inputModifContenu'];
            $modifdifficultecours = $_POST['modifdifficultecours'];
            date_default_timezone_set('Europe/Paris');
            $datedernieremodif = date("Y-m-d H:i:s");
            $difficulte = new Difficulte($db);
            $listedifficulte = $difficulte->select();
            $idcours = $_POST['idcours'];

            $difficulte = new Difficulte($db);

            $form['valide'] = true;
            $form['auteur'] = $auteur;
            $form['idcours'] = $idcours;
            $form['inputModifTitre'] = $inputModifTitre;
            $form['inputModifSousTitre'] = $inputModifSousTitre;
            $form['inputModifContenu'] = $inputModifContenu;
            $form['modifdifficultecours'] = $difficulte->selectByIdDifficulte($modifdifficultecours); //bien différencier le $difficultecours du $listedifficulte sinon cela crée un conflit : Notice: Array to string conversion in...
            $form['datedernieremodif'] = $datedernieremodif;
            $form['difficulte'] = $listedifficulte;

            $cours = new Cours($db);
            $exec = $cours->updatecours($inputModifTitre, $modifdifficultecours, $datedernieremodif, $idcours);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Problème de modification du cours';
            } else {
                $form['message'] = 'Modification du cours validée';
            }

            $section = new Section($db);
            $uneSection = $section->selectByIdcours($_GET['idcours']);
            if ($uneSection != null) {
                $form['section'] = $uneSection;
            } else {
                $form['message'] = 'Section incorrecte';
            }

            $idsoustitre = $_POST['idsoustitre'];

            $nbSousTitre = count($inputModifSousTitre);
            
            
            for ($i = 0; $i < count($inputModifSousTitre); $i++) {
            if (empty($inputModifSousTitre[$i]) && empty($inputModifContenu[$i])) {
                $exec = $section->deletesection($idsoustitre[$i]);
            } else {
                $exec = $section->updatesection($idsoustitre[$i], $inputModifSousTitre[$i], $inputModifContenu[$i]);
            }
        }

//            for ($i = 0; $i < count($inputModifSousTitre); $i++) {
//                $exec = $section->updatesection($idsoustitre[$i], $inputModifSousTitre[$i], $inputModifContenu[$i]);
//            }
        }
    }
    echo $twig->render('modifcours.html.twig', array('form' => $form, 'listedifficulte' => $listedifficulte));
}
?> 
