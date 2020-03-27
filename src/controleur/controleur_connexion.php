<?php

function actionVTTConnexion($twig, $db) {
    $form = array();

    if (isset($_POST['btVTTConnecter'])) {
        $form['valide'] = true;
        $inputEmail = $_POST['inputVTTEmail'];
        $inputPassword = $_POST['inputVTTPassword'];
        $utilisateur = new Utilisateurvttl($db); // lien avec la classe Utilisateurvttl
        $connexion = new Connexion($db);
        $unUtilisateur = $utilisateur->connect($inputEmail);

        $unUtilisateur2 = $utilisateur->selectByEmail($_POST['inputVTTEmail']);

        if ($unUtilisateur != null) {
            if (!password_verify($inputPassword, $unUtilisateur['mdp'])) {
                $form['valide'] = false;
                $form['message'] = 'Login ou mot de passe incorrect';
            } else {
                
                if ($unUtilisateur2['valide'] == 1) {

                    $_SESSION['login'] = $inputEmail;
                    $_SESSION['role'] = $unUtilisateur['idRole'];
                    date_default_timezone_set('Europe/Paris');
                    $datedernier = date("Y-m-d H:i:s");
                    $dateco = date("Y-m-d H:i:s"); 
                    $unUtilisateur = $utilisateur->updateconnect($inputEmail, $datedernier);
                    $connexion->connexion($inputEmail, $dateco);
                    header("Location:index.php");
                } else {
                    $form['valide'] = false;
                    $form['message'] = 'Inscription non validée.';
                }
            }
        } else {
            $form['valide'] = false;
            $form['message'] = 'Login ou mot de passe incorrect';
        }
    }
    echo $twig->render('vttconnexion.html.twig', array('form' => $form));
}

?>