<!DOCTYPE html>
<html id="homepage" lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ecommerce en ligne</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700|Roboto:100,300,300i,400,700,900" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Crimson+Text:400,400i,600,600i,700" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/sytyleNav-principale.css">
    <script src="assets/js/footer-cadre.js"></script>
    <script src="assets/js/scroll-menu.js"></script>
    <script src="assets/js/menu-scrol-active.js"></script>
    <script src="assets/js/toggle-nav-bar-active.js"></script>
    <script src="https://code.iconify.design/1/1.0.3/iconify.min.js"></script>
</head>

<body>
    <header>
        <div id="logo"><a href="index.html"><img width="150" alt="logo " src="img/triangle-and-letter-e.png"></a></div>

        <nav class="deroulant-menu" aria-label="Arborescence secondaire">

            <ul class="menu">
                <li> <a href="#"> <span class="iconify" data-inline="false" data-icon="ion:home-outline" style="color: blue; font-size: 16px;" data-flip="horizontal"></span>
                        Acceuil</a>

                </li>
                <li><a href=""><span>Contactez-nous</span></a></li>
                <li><a href="">magasin</a></li>
                <li><a href="authentificationcli.php">ouvrir une session</a></li>
                <li> <a href="">panier</a></li>
                <li> <a href="" lang="en"><span>English</span></a></li>
            </ul>

        </nav>
        <?php if(!isset($_SESSION['identifiant_utilisateur'])) 
   {?>
        <div> <a href="authentificationcli.php">connexion</a></div>
        <div> <a href="ajoutClient.php">sinscrire</a></div>
        <?php }?>


        <a href="deconnection.php">Deconnexion</a>


    </header>
    <nav id="nav" aria-label="Arborescence principale">

        <ul>

            <li> <a href="#">
                    Meubles</a>
                <ul>

                    <li><a href="#"> salon</a>
                        <ul>
                            <li><a href="#">Divans</a></li>
                            <li><a href="#">Fauteuil lit</a></li>
                            <li><a href="#">causeuse</a></li>
                            <li><a href="#">table de salon</a></li>
                        </ul>
                    </li>

                    <li><a href="#">cuisine et salle a manger</a>
                        <ul>
                            <li><a href="#">tables</a></li>
                            <li><a href="#">chaises</a></li>
                            <li><a href="#">Desserte</a></li>
                        </ul>
                    </li>
                    <li><a href="#">chambres a coucher</a>
                        <ul>
                            <li><a href="#">lits</a></li>
                            <li><a href="#">Armoires</a></li>
                            <li><a href="#">Ensembles de chambre a coucher</a></li>
                        </ul>
                    </li>

                </ul>
            </li>
            <li> <a href="#">Electronique</a>
                <ul>

                    <li><a href="#"> televiseur et accessoir</a>
                        <ul>
                            <li><a href="#">televiseur</a></li>
                            <li><a href="#">accessoire</a></li>

                        </ul>
                    </li>

                    <li><a href="#">ordinateurs et accessoire</a>
                        <ul>
                            <li><a href="#">ordinateur</a></li>
                            <li><a href="#">accessoires</a></li>

                        </ul>
                    </li>
                    <li><a href="#">Telecommunications</a>
                        <ul>
                            <li><a href="#">telephones sans fil et combinet telephonique</a></li>
                            <li><a href="#">modifier un gestionnaire</a></li>
                            <li><a href="#">supprimer un gestionnaire</a></li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li> <a href="#">Electromenager</a>

                <ul>

                    <li><a href="#"> refrigerateur et congelateur</a>
                        <ul>
                            <li><a href="#">refrigerateur</a></li>
                            <li><a href="#">congelateur</a></li>
                            <li><a href="#">accessoire</a></li>

                        </ul>
                    </li>

                    <li><a href="#">laveuse et secheuse</a>
                        <ul>
                            <li><a href="#">Ensembles laveuse et secheuse</a></li>
                            <li><a href="#">laveuse</a></li>
                            <li><a href="#">secheuse</a></li>

                        </ul>
                    </li>
                    <li><a href="#">cuisson</a>
                        <ul>
                            <li><a href="#">barbecue</a></li>
                            <li><a href="#">micronde</a></li>
                            <li><a href="#">cuisinieres</a></li>
                        </ul>
                    </li>
                </ul>
            </li>

            <li><a href="#"><span class="iconify" data-inline="false" data-icon="mdi:settings-transfer" style="color: white; font-size: 16px;" data-flip="horizontal"></span>services</a>

            </li>

        </ul>




    </nav>






    <main>
        <section>
            <header>
                <h1>veuillez passer vos commandes </h1>
            </header>
            <div class="conteneurs">
                <?php 
                 require_once('listeProduitsAcommande.php');    
                ?>
            </div>
        </section>
        <article class="formulaire">


        </article>


    </main>

    <footer>
        <nav aria-label="infolettre">
            <div class="contact">

                <header>
                    <h1>Abonnez-vous à notre infolettre</h1>
                </header>

                <figure>
                    <img alt="contact" src="images/tel%20(1).png">
                    <span>+1 43800000</span>


                </figure>
                <figure>
                    <img alt="locaisaion" src="images/point%20(1).png">
                    <span>Localiser nous</span>


                </figure>
                <figure>
                    <img alt="adresse" src="images/letre%20(1).png">

                    <span><a href="">contact@ecommerce.org</a></span>

                </figure>

            </div>


            <div class="mediasociau">
                <header>
                    <h1>Suivez-nous</h1>
                </header>

                <div>
                    <a href=""><img alt="logo facebook" src="assets/images/facebook.png"></a>

                    <a href=""><img alt="youtube" src="assets/images/youtube.png"></a>

                    <a href=""><img alt="tweeter" src="assets/images/tweeter.png"></a>

                    <a href=""><img alt="intagram" src="assets/images/instagram.png"></a>

                </div>
            </div>

        </nav>
        <span>Tous droits réservés © yapo — site ecommerce</span>

    </footer>
</body>

</html>
