<?php

function actionDifficulte($twig, $db) {
    $form = array();
    $difficulte = new Difficulte($db);
    if (isset($_POST['btDifficulte'])) {
        $inputDifficulte = $_POST['inputDifficulte'];
        $form['valide'] = true;
        $difficulte = new Difficulte($db);
        $exec = $difficulte->insert($inputDifficulte);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème d\'insertion dans la table difficulté';
        } else
            $form['message'] = 'Insertion dans la table difficulté validée';
    }
    if (isset($_GET['id'])) {
        $difficulte = new Difficulte($db);
        $exec = $difficulte->delete($_GET['id']);
        if (!$exec) {
            $form['valide'] = false;
            $form['message'] = 'Problème de suppression dans la table difficulte';
        } else {
            $form['valide'] = true;
            $form['message'] = 'Difficulté supprimée avec succès';
        }
    }

    $limite = 3;
    if (!isset($_GET['nopage'])) {
        $inf = 0;
        $nopage = 0;
    } else {
        $nopage = $_GET['nopage'];
        $inf = $nopage * $limite;
    }
    $r = $difficulte->selectCount();
    $nb = $r['nb'];


    $liste = $difficulte->selectLimit($inf, $limite);
    $form['nbpages'] = ceil($nb / $limite);

    // Bien faire attention au fait que le $liste doit apparaitre une seule fois avec le selectLimit et pas le select (on doit l'enlever)
    //    $listedifficulte = $difficulte->select();

    echo $twig->render('difficulte.html.twig', array('form' => $form, 'liste' => $liste));
}

function actionModifDifficulte($twig, $db) {
    $form = array();
    if (isset($_GET['difficulte'])) {
        $difficulte = new Difficulte($db);
        $uneDifficulte = $difficulte->selectByIdDifficulte($_GET['difficulte']);
        if ($uneDifficulte != null) {
            $form['difficulte'] = $uneDifficulte;
        } else {
            $form['message'] = 'Difficulté incorrect';
        }
    } else {
        if (isset($_POST['btModifDifficulte'])) {
            $difficulte = new Difficulte($db);
            $nomdifficulte = $_POST['inputModifDifficulte'];
            $iddifficulte = $_POST['id'];
            $exec = $difficulte->update($iddifficulte, $nomdifficulte);
            if (!$exec) {
                $form['valide'] = false;
                $form['message'] = 'Échec de la modification de la difficulté';
            } else {
                $form['valide'] = true;
                $form['message'] = 'Modification de la difficulté réussie';
            }
        } else {
            $form['message'] = 'Difficulté non précisé';
        }
    }



    echo $twig->render('difficulte-modif.html.twig', array('form' => $form));
}

?> 