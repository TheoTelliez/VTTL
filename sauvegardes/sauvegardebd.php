<?php

$connect = new PDO("mysql:host=localhost;dbname=dblogin4059VTTL", "login4059", "kFILYMNLotHlbgo"); //Requête de connexion à la BD
$get_all_table_query = "SHOW TABLES"; //Affichage des tables en SQL
$statement = $connect->prepare($get_all_table_query); //On lie la fonction connect et on récupère les tables
$statement->execute(); //On exécute
$result = $statement->fetchAll(); //Attention à bien faire un fetchAll et pas un fetch sinon beh c'est buggué
if (isset($_POST['table'])) { //Si on récupère les tables correctement...
    $output = ''; //Outpout c'est pour écrire dans le fichier donc la c'est un vide 
    foreach ($_POST["table"] as $table) { //On fait un changement de valeur 
        $show_table_query = "SHOW CREATE TABLE " . $table . ""; //Ici c'est le début de notre requête 
        $statement = $connect->prepare($show_table_query); //On prépare toutes les tables
        $statement->execute(); //On exécute
        $show_table_result = $statement->fetchAll(); //Bien faire encore une fois attention au fetchAll

        foreach ($show_table_result as $show_table_row) { //Boucle qui fait en sorte de définir le nombre de lignes selon le nombre de BD 
            $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n"; //Ici c'est la suite de notre requête SQL
        }
        $select_query = "SELECT * FROM " . $table . ""; //Ici c'est la suite de notre requête SQL aussi
        $statement = $connect->prepare($select_query); //On prépare le fait d'envoyer le select
        $statement->execute(); //On exécute
        $total_row = $statement->rowCount(); //On compte le nombre de lignes au total

        for ($count = 0; $count < $total_row; $count++) { //Ici c'est pour faire en sorte que le nombre de lignes total s'affiche et se repète en boucle dans la requête SQL
            $single_result = $statement->fetch(PDO::FETCH_ASSOC); //On affiche un seul résultat de PDO statement (d'ou le fetch)
            $table_column_array = array_keys($single_result);
            $table_value_array = array_values($single_result);
            $output .= "\nINSERT INTO $table ("; //Ici c'est la suite de notre requête SQL encore
            $output .= "" . implode(", ", $table_column_array) . ") VALUES ("; //Ici c'est la suite de notre requête SQL encore et encore
            $output .= "'" . implode("','", $table_value_array) . "');\n"; //Ici c'est la suite de notre requête SQL encore et encore et encore
        }
    }
    $file_name = 'Sauvegarde_Base_De_Donnees_VTTL_du_' . date('y-m-d_His') . '.sql'; //Ici c'est pour définir le nom du fichier que l'on va télécharger
    $file_handle = fopen($file_name, 'w+'); //w+ c'est pour le writing mode
    fwrite($file_handle, $output); // On ouvre le fichier et on écrit dedans ce qu'on a stocké
    fclose($file_handle); //On ferme le fichier
    header('Content-Description: File Transfer'); //Début de tout les headers
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file_name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_name)); //Fin des headers
    ob_clean();
    flush(); //ATTENTION AU FLUSH QUI EST SUPER IMPORTANT !!
    readfile($file_name); //Le readfile c'est pour le téléchargement
    unlink($file_name); //Et la on décharge notre fichier
    //Commentaires par Théo TELLIEZ 
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/css/main.css" />
        <link href="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/images/favicon.ico" rel="icon" />
        <title>VTT Learning - Sauvegarde BD</title>
        <script src="https://kit.fontawesome.com/2f4aa51ca0.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

    </head>
    <center> 
        <!-- Header -->
        <header id="header" class="alt">
            <div class="logo"><a href="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/index.php">VTT Learning</a></div>
            <a href="#menu"><span></span></a>
        </header>

        <nav id="menu">
            <ul class="links">
                <li><a href="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/index.php">Accueil</a></li>
                <li><a href="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/index.php?page=cours">Cours</a></li>
                <li>
                    <a class="dropdown-toggle" href="" id="dropdown01" data-toggle="dropdown" ariahaspopup="
                       true" aria-expanded="false">Administration</a>
                    <ul>
                        <li><a class="dropdown-item" href="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/index.php?page=paneladmin" style="color:#FFFFFF;">Panel d'administration</a></li>
                        <li><a class="dropdown-item" href="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/index.php?page=ajoutcours" style="color:#FFFFFF;">Ajouter un cours</a></li> <!-- Si je ne mets pas le style color, étant donné que le lien n’est pas défaut dans le css en rouge il ne se voit pas dans le menu donc je le redéfini en blanc avec le #FFFFFF  -->
                        <li><a class="dropdown-item" href="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/index.php?page=difficulte" style="color:#FFFFFF;">Gestion des difficultés</a></li>
                        <li><a class="dropdown-item" href="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/index.php?page=contactadmin" style="color:#FFFFFF;">Messages de contact</a></li>
                        <li><a class="dropdown-item" href="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/index.php?page=commentaireadmin" style="color:#FFFFFF;">Liste des commentaires</a></li>
                        <li><a class="dropdown-item" href="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/index.php?page=utilisateuradmin" style="color:#FFFFFF;">Gestion des utilisateurs</a></li>
                        <li><a class="dropdown-item" href="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/index.php?page=logsadmin" style="color:#FFFFFF;">Connexions des utilisateurs</a></li>
                        <li><a class="dropdown-item" href="http://serveur1.arras-sio.com/symfony4-4059/VTTL/src/controleur/statistiques_vttl.php" style="color:#FFFFFF;">Graphique de connexions</a></li>
                    </ul>
                </li>
                <li><a href="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/index.php?page=apropos">A propos</a></li>
                <li><a href="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/index.php?page=mentions">Mentions légales</a></li>
                <li><a href="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/index.php?page=contact">Contact</a></li>
                <li><a href="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/index.php?page=commentaire">Commentaires</a></li>
                <li><a href="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/index.php?page=recherches">Recherches</a></li>
                <li><a href="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/index.php?page=deconnexion">Se déconnecter</a></li>
            </ul>
        </nav>
    </center> 
    <body>  
    <center>
        <h2> </h2><br /> 

        <h2>Sauvegarde de la base de données du site VTT Learning :</h2>

        <br /><br />  
        <div class="container">

            <form method="post" id="export_form">
                <h3><u>Sélectionnez la ou les table(s) à exporter :</u></h3>
                <br />
                <div class="form-group">
                    <input type="checkbox" id="toutcocher" onclick="cocherTout(this.checked);"><h4>Tout cocher / décocher</h4>

                    <br/><br/>
                </div>

                <?php
                foreach ($result as $table) {
                    ?>
                    <div>
                        <label><input type="checkbox" id="toutcocher1" class="checkbox_table" name="table[]" value="<?php echo $table["Tables_in_dblogin4059VTTL"]; ?>" > 
                            <h4><?php echo $table["Tables_in_dblogin4059VTTL"]; ?></h4></label>

                    </div>

                    <?php
                }
                ?>
                <div>
                    <br/><br/>
                    <input type="submit" name="submit" style="background-color: #F64747; border-color: #F64747" id="submit" class="button special fit" value="Exporter" />
                </div>
            </form>


        </div>
        <br /><br /><br /><br />  

        <!-- Footer -->
        <footer id="footer">
            <div class="inner">
                <ul class="icons">
                    <li><a href="https://twitter.com/LearningVtt" target="_blank" class="icon round fa-twitter"><span class="label">Twitter</span></a></li>
                    <li><a href="https://www.facebook.com/vtt.learning.1" target="_blank" class="icon round fa-facebook"><span class="label">Facebook</span></a></li>
                    <li><a href="https://www.instagram.com/vttlearning/" target="_blank" class="icon round fa-instagram"><span class="label">Instagram</span></a></li>
                </ul>

                <div class="copyright">
                    &copy; VTT Learning. Modèle: <a target='_blank' href="https://templated.co">TEMPLATED</a>. Images: <a target='_blank' href="https://unsplash.com/s/photos/mountain-bike">Unsplash</a>. Créateur: <a href="#">Théo TELLIEZ</a>.
                </div>

            </div>
        </footer>
    </center>



    <!-- Bootstrap core JavaScript
================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery-3.2.1.min.js"><\/script>')</script>
    <script src="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/js/bootstrap.min.js"></script>
    <!-- Scripts -->
    <script src="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/js/jquery.min.js"></script>
    <script src="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/js/jquery.scrolly.min.js"></script>
    <script src="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/js/jquery.scrollex.min.js"></script>
    <script src="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/js/skel.min.js"></script>
    <script src="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/js/util.js"></script>
    <script src="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/js/main.js"></script>
    <script src="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/js/script.js"></script>
    <script src="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/js/tablessql.js"></script>
    <script src="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/js/toutcocher.js"></script>


</body>
</html>
