<?php

function actionVTTConnexion($twig, $db) {
    $form = array();
    if (isset($_POST['btVTTConnecter'])) {
        $form['valide'] = true;
        $inputEmail = $_POST['inputVTTEmail'];
        $inputPassword = $_POST['inputVTTPassword'];
        $utilisateur = new Utilisateurvttl($db); // lien avec la classe Utilisateurvttl
        $unUtilisateur = $utilisateur->connect($inputEmail);
        if ($unUtilisateur != null) {
            if (!password_verify($inputPassword, $unUtilisateur['mdp'])) {
                $form['valide'] = false;
                $form['message'] = 'Login ou mot de passe incorrect';
            } else {
                $_SESSION['login'] = $inputEmail;
                $_SESSION['role'] = $unUtilisateur['idRole']; 
                $datedernier = date("Y-m-d");
                $unUtilisateur = $utilisateur->updateconnect($inputEmail, $datedernier);
                header("Location:index.php");
            }
        } else {
            $form['valide'] = false;
            $form['message'] = 'Login ou mot de passe incorrect';
        }
    }
    echo $twig->render('vttconnexion.html.twig', array('form' => $form));
}

?>