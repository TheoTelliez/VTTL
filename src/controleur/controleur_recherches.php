<?php

function actionRecherches($twig) {
    echo $twig->render('recherches.html.twig', array());
}

function actionResultatRecherches($twig, $db) {
    $form = array();

    $cours = new Cours($db);
    $difficulte = new Difficulte($db);
    $utilisateurvttl = new Utilisateurvttl($db);
    $connexion = new Connexion($db);
    $contact = new Contactvttl($db);
    $commentaire = new Commentairevttl($db);

// Pour une recherche de cours  

    if (isset($_POST['btrecherchecours'])) { // cours
        $recherche = $_POST['inputrecherchecours'];
        
        $listerecherchedifficulte = NULL;
        $listerechercheutilisateur = NULL;
        $listerechercheconnexion = NULL;
        $listerecherchecontact = NULL;
        $listerecherchecommentaire = NULL;


        if (empty($_POST['inputrecherchecours'])) {
            $recherche = 'azertyuioppoiuytreza'; //Pour faire en sorte que si je mets rien dans la recherche et que je clique sur le bouton, alors, il recherche quelque chose de fou qui aboutira sur rien.
        }
        $listerecherchecours = $cours->rechercher($recherche);
    }

// Pour une recherche de difficulté(s)     
    elseif (isset($_POST['btrecherchedifficulte'])) { // difficulte
        $recherche = $_POST['inputrecherchedifficulte'];
        
        $listerecherchecours = NULL;
        $listerechercheutilisateur = NULL;
        $listerechercheconnexion = NULL;
        $listerecherchecontact = NULL;
        $listerecherchecommentaire = NULL;

        if (empty($_POST['inputrecherchedifficulte'])) {
            $recherche = 'azertyuioppoiuytreza'; //Pour faire en sorte que si je mets rien dans la recherche et que je clique sur le bouton, alors, il recherche quelque chose de fou qui aboutira sur rien.
        }
        $listerecherchedifficulte = $difficulte->rechercher($recherche);
    }

// Pour une recherche d'utilisateur(s)   
    elseif (isset($_POST['btrechercheutilisateur'])) {
        $recherche = $_POST['inputrechercheutilisateur'];
        
        $listerecherchecours = NULL;
        $listerecherchedifficulte = NULL;
        $listerechercheconnexion = NULL;
        $listerecherchecontact = NULL;
        $listerecherchecommentaire = NULL;

        if (empty($_POST['inputrechercheutilisateur'])) {
            $recherche = 'azertyuioppoiuytreza'; //Pour faire en sorte que si je mets rien dans la recherche et que je clique sur le bouton, alors, il recherche quelque chose de fou qui aboutira sur rien.
        }
        $listerechercheutilisateur = $utilisateurvttl->rechercher($recherche);
    }


// Pour une recherche de connexion(s)  
    elseif (isset($_POST['btrechercheconnexion'])) {
        $recherche = $_POST['inputrechercheconnexion'];
        
        $listerecherchecours = NULL;
        $listerecherchedifficulte = NULL;
        $listerechercheutilisateur = NULL;
        $listerecherchecontact = NULL;
        $listerecherchecommentaire = NULL;

        if (empty($_POST['inputrechercheconnexion'])) {
            $recherche = 'azertyuioppoiuytreza'; //Pour faire en sorte que si je mets rien dans la recherche et que je clique sur le bouton, alors, il recherche quelque chose de fou qui aboutira sur rien.
        }
        $listerechercheconnexion = $connexion->rechercher($recherche);
    }
    
// Pour une recherche de contact(s)
    elseif (isset($_POST['btrecherchecontact'])) {
        $recherche = $_POST['inputrecherchecontact'];
        
        $listerecherchecours = NULL;
        $listerecherchedifficulte = NULL;
        $listerechercheutilisateur = NULL;
        $listerechercheconnexion = NULL;
        $listerecherchecommentaire = NULL;

        if (empty($_POST['inputrecherchecontact'])) {
            $recherche = 'azertyuioppoiuytreza'; //Pour faire en sorte que si je mets rien dans la recherche et que je clique sur le bouton, alors, il recherche quelque chose de fou qui aboutira sur rien.
        }
        $listerecherchecontact = $contact->rechercher($recherche);
    }
    
// Pour une recherche de commentaire(s)
    elseif (isset($_POST['btrecherchecommentaire'])) {
        $recherche = $_POST['inputrecherchecommentaire'];
        
        $listerecherchecours = NULL;
        $listerecherchedifficulte = NULL;
        $listerechercheutilisateur = NULL;
        $listerechercheconnexion = NULL;
        $listerecherchecontact = NULL;

        if (empty($_POST['inputrecherchecommentaire'])) {
            $recherche = 'azertyuioppoiuytreza'; //Pour faire en sorte que si je mets rien dans la recherche et que je clique sur le bouton, alors, il recherche quelque chose de fou qui aboutira sur rien.
        }
        $listerecherchecommentaire = $commentaire->rechercher($recherche);
    }

// Pour faire en sorte que quand il n'y a pas de bouton et qu'on accède quand même à la page resultatrecherches, alors il ne mets pas d'erreur.      
    else {
        $listerecherchecours = NULL;
        $listerecherchedifficulte = NULL;
        $listerechercheutilisateur = NULL;
        $listerechercheconnexion = NULL;
        $listerecherchecontact = NULL;
        $listerecherchecommentaire = NULL;
    }





    echo $twig->render('resultatrecherches.html.twig', array('form' => $form, 'listerecherchecours' => $listerecherchecours, 'listerecherchedifficulte' => $listerecherchedifficulte, 'listerechercheutilisateur' => $listerechercheutilisateur, 'listerechercheconnexion' => $listerechercheconnexion, 'listerecherchecontact' => $listerecherchecontact, 'listerecherchecommentaire' => $listerecherchecommentaire));
}

?>