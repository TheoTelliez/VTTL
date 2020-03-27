<?php
$connect = mysqli_connect("localhost", "login4059", "kFILYMNLotHlbgo", "dblogin4059VTTL");   // équivalent du fichier config
$query = "SELECT emailco, count(*) as nombredeco FROM connexions GROUP BY emailco"; //équivalent de la classe dans le MVC
$result = mysqli_query($connect, $query);  //données qui sont normalement transmises
?>  
<!DOCTYPE html> 

<html> 
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/css/main.css" />
        <link href="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/images/favicon.ico" rel="icon" />
        <title>VTT Learning - Statistiques</title>
        <link href="images/favicon.ico" rel="icon" />
        <link href="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/css/main.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/2f4aa51ca0.js" crossorigin="anonymous"></script> 
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>  
        <script type="text/javascript">  
            google.charts.load('current', {'packages':['corechart']});   
            google.charts.setOnLoadCallback(drawChart);  
            function drawChart()  
            {  
            var data = google.visualization.arrayToDataTable([  
            ['emailco', 'Number'],  
            <?php
            while ($row = mysqli_fetch_array($result)) {
                echo "['" . $row["emailco"] . "', " . $row["nombredeco"] . "],";
            }
            ?>  
            ]);  
            var options = {  
            <!--                title: 'Pourcentages de co par emails', -->
            backgroundColor: 'white',
            is3D:true,  
            legend:{position: 'bottom'},
            //pieHole: 0.4  
            };  
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));  
            chart.draw(data, options);  
            }  
        </script>  
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

        <h2>Statistiques de connexions des utilisateurs sur le site :</h2>

        <br /><br />


        <div>
            <div id="piechart" style="height: 600px; margin-left: 5%; margin-right: 5%;"></div>  
        </div>



        <br /><br /><br /> 

        <!-- Footer -->

        <footer id="footer" style="width: 100%">
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
    <script>window.jQuery || document.write ( '<script src="js/jquery-3.2.1.min.js"><\/script>')</script>
    <script src="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/js/bootstrap.min.js"></script>
    <!-- Scripts -->
    <script src="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/js/jquery.min.js"></script>
    <script src="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/js/jquery.scrolly.min.js"></script>
    <script src="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/js/jquery.scrollex.min.js"></script>
    <script src="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/js/skel.min.js"></script>
    <script src="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/js/util.js"></script>
    <script src="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/js/main.js"></script>
    <script src="http://serveur1.arras-sio.com/symfony4-4059/VTTL/web/js/script.js"></script>

</body>

</html>  
