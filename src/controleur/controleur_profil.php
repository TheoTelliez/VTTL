<?php

//function actionVTTProfil($twig, $db) {
//    $utilisateur = new Utilisateurvttl($db);    //mise en mémoire de tout les outils de la class_utilisateur.php
//    $liste = $utilisateur->select();
//    echo $twig->render('profil.html.twig', array('liste' => $liste));
//}
//function actionVTTModifProfil($twig, $db) {
//    $utilisateur = new Utilisateurvttl($db);
//    $form = $utilisateur->selectByEmail($_GET['email']);
//    echo $twig->render('utilisateurmodif.html.twig', array('form' => $form));
//}

function actionVTTProfil($twig, $db) {
    $form = array();
    if (isset($_GET['email'])) {
        $utilisateur = new Utilisateurvttl($db);
        $unUtilisateur = $utilisateur->selectByEmail($_GET['email']);
        if ($unUtilisateur != null) {
            $form['utilisateur'] = $unUtilisateur;
        } else {
            $form['message'] = 'Utilisateur incorrect';
        }
    } else {
        $form['message'] = 'Utilisateur non précisé';
    }
    echo $twig->render('profil.html.twig', array('form' => $form));
}

function actionVTTModifProfil($twig, $db) {
    $form = array();
    if (isset($_GET['email'])) {
        $utilisateur = new Utilisateurvttl($db);
        $unUtilisateur = $utilisateur->selectByEmail($_GET['email']);
        if ($unUtilisateur != null) {
            $form['utilisateur'] = $unUtilisateur;
            $role = new Rolevttl($db);
            $liste = $role->select();
            $form['roles'] = $liste;
        } else {
            $form['message'] = 'Utilisateur incorrect';
        }
    } else {
        if (isset($_POST['btModifierVTT'])) {
            $utilisateur = new Utilisateurvttl($db);
            $nom = $_POST['inputModifSurname'];
            $prenom = $_POST['inputModifName'];
            $role = $_POST['role'];
            $email = $_POST['email'];
            $mdp = $_POST['inputModifPassword'];
            $mdp2 = $_POST['inputModifPassword2'];
            if (empty($mdp)) {
                $form['message'] = 'Veuillez rentrer un mot de passe';
            } else {
                if ($mdp != $mdp2) {
                    $form['valide'] = false;
                    $form['message'] = 'Les mots de passe sont différents';
                } else {

                    $exec = $utilisateur->updatesansphoto($email, $role, $nom, $prenom, password_hash($mdp, PASSWORD_DEFAULT));
                    if (!$exec) {
                        $form['valide'] = false;
                        $form['message'] = 'Échec de la modification';
                    } else {
                        $form['valide'] = true;
                        $form['message'] = 'Modification réussie';
                    }
                }
            }
        }
    }
    $liste = $utilisateur->select();
    echo $twig->render('utilisateurmodif.html.twig', array('form' => $form, 'liste' => $liste));
}

?>
