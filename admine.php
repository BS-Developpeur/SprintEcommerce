<?php
error_reporting(0);
session_start();
require_once("require/connectDB.php");
require_once("require/sql.php");

?>

<!DOCTYPE html>
<html id="homepage" lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administation gestion des commandes</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700|Roboto:100,300,300i,400,700,900" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Crimson+Text:400,400i,600,600i,700" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styleadmine.css">
    <script src="assets/js/footer-cadre.js"></script>
    <script src="assets/js/scroll-menu.js"></script>
    <script src="assets/js/menu-scrol-active.js"></script>
    <script src="assets/js/toggle-nav-bar-active.js"></script>
    <script src="https://code.iconify.design/1/1.0.3/iconify.min.js"></script>
</head>

<body>
    <header>
        <div id="logo"><a href="admine.php"><img width="150" alt="logo " src="img/triangle-and-letter-e.png"></a></div>
          <div class="icone-admin">
            <span class="iconify" data-inline="false" data-icon="dashicons:admin-users" style="color: blue; font-size: 100px;" data-flip="horizontal"></span>

            <p><?= $_SESSION["identifiant_utilisateur"] ?> / <?= $_SESSION["type_utilisateur"] ?> </p>

        </div>
         <div class="authentification">
            <?php if(!isset($_SESSION['identifiant_utilisateur'])) 
   {?>
            <a href="indexe.php">connexion</a>
            <a href="ajoutUtilisateur.php">s'inscrire</a>
            <?php }?>

            <a href="deconnexionAdmin.php">Deconnexion</a>

        </div>
        <nav id="nav" aria-label="Arborescence principale">

            <ul>
                <li> <a href="admine.php?page=infos"> <span class="iconify" data-inline="false" data-icon="ion:home-outline" style="color: blue; font-size: 16px;" data-flip="horizontal"></span>
                        Acceuil</a>

                </li>
                <?php if(($_SESSION['type_utilisateur'])=== "gestionnaire" || ($_SESSION['type_utilisateur'])=== "admin") 
   {?>
                <li> <a href="#"><span class="iconify" data-inline="false" data-icon="gridicons:product-downloadable" style="color: blue; font-size: 16px;" data-flip="horizontal"></span>
                        Articles</a>
                    <ul>

                        <li><a href="#"> Gestion des produits</a>
                            <ul>
                                <li><a href="admine.php?page=insertionProduit">ajout un produits</a></li>

                                <li><a href="admine.php?page=listeProduit">liste des produits</a></li>
                            </ul>
                        </li>

                        <li><a href="#">Gestion des categories</a>
                            <ul>
                                <li><a href="admine.php?page=insertionCategorie">ajout une categories</a></li>

                                <li><a href="admine.php?page=listeCategorie">listes des categories</a></li>
                            </ul>
                        </li>

                    </ul>
                </li>
                <?php }?>

                <?php if(($_SESSION['type_utilisateur'])=== "vendeur" || ($_SESSION['type_utilisateur'])=== "gestionnaire" || ($_SESSION['type_utilisateur'])=== "admin" ) 
   {?>
                <li> <a href="#"><span class="iconify" data-inline="false" data-icon="simple-line-icons:people" style="color: blue; font-size: 16px;" data-flip="horizontal"></span>
                        Tiers</a>
                    <ul>

                        <li><a href="#">gestion des clients</a>
                            <ul>
                                <li><a href="admine.php?page=insertionClient"> ajout un client</a></li>

                                <li><a href="admine.php?page=listeClient">liste des clients</a></li>
                            </ul>
                        </li>
                        <?php if(($_SESSION['type_utilisateur'])=== "admin")  
   {?>
                        <li><a href="#"> gestion des vendeurs</a>
                            <ul>

                                <li><a href="admine.php?page=insertionVendeurs">ajout un vendeur</a></li>

                                <li><a href="admine.php?page=listeVendeur">liste des vendeurs</a></li>
                            </ul>
                        </li>
                        <li><a href="#">gestion des gestionnaires</a>
                            <ul>
                                <li><a href="admine.php?page=insertionGestionnaire">ajout un gestionnaire</a></li>

                                <li><a href="admine.php?page=listeGestionnaire">listes gestionnaire</a></li>
                            </ul>
                        </li>
                        <li><a href="admine.php?page=listeUsers">liste des utilisateurs</a></li>
                        <?php }?>
                    </ul>
                </li>
                <?php }?>
                <?php if(($_SESSION['type_utilisateur'])=== "vendeur" || ($_SESSION['type_utilisateur'])=== "gestionnaire" || ($_SESSION['type_utilisateur'])=== "admin") 
   {?>
                <li> <a href="#"><span class="iconify" data-inline="false" data-icon="gridicons:product-external" style="color: blue; font-size: 16px;" data-flip="horizontal"></span>commandes</a>

                    <ul>
                        <li><a href="admine.php?page=insertionCommandeNews">ajout une nouvelle commande</a></li>
                        <li><a href="admine.php?page=insertionCommande">ajout commande client existant</a></li>
                        <li><a href="admine.php?page=listeCommande">liste des commandes</a></li>
                    </ul>
                </li>
                <?php }?>
                <?php if(($_SESSION['type_utilisateur'])=== "admin") 
   {?>
                <li><a href="#"><span class="iconify" data-inline="false" data-icon="mdi:settings-transfer" style="color: blue; font-size: 16px;" data-flip="horizontal"></span>administrateur</a>

                </li>
                <?php }?>

            </ul>

 
        </nav>

     
      



    </header>

 
    <?php
                
                
               // require_once('infos.php');
                //si les paramettre existe 
                //on affiche le lien correspondant au parametre
             
                   switch($_GET["page"])
                   {
                          case "insertionClient": require_once('ajoutClient.php');
                           break;
                           case "listeClient":  require_once('listedesclients.php');
                           break;
                            case "insertionProduit": require_once('ajoutProduit.php');
                           break;
                           case "listeProduit":  require_once('listeProduits.php');
                           break;
                              
                          case "insertionVendeurs": require_once('ajoutUtilisateur.php');
                           break;
                           case "insertionGestionnaire":  require_once('ajoutUtilisateur.php');
                           break;
                            case "listeUsers":  require_once('listeUtilisateur.php');
                           break;
                           
                          
                           case "insertionCategorie": require_once('ajoutCategorie.php');
                           break;
                           case "listeCategorie":  require_once('listeCategorie.php');
                           break;
                          
                           case "insertionCommandeNews": require_once('enregistrerCommande.php');
                           break;
                           case "insertionCommande": require_once('ajoutcommandcliexi.php');
                           break;
                           case "listeCommande": require_once('listesDesCommandes.php');
                              break;
                          default:require_once('infos.php');
                            
                   }
                    
                ?>
    <footer>


        <nav aria-label="infolettre">
            <div class="contact">

                <header>
                    <h1>Securité maximale</h1>
                </header>

                <figure>
                    <img alt="img partenaire" src="images/tel%20(1).png">
                    <span>+1 43800000</span>


                </figure>
                <figure>
                    <img alt="immag" src="images/point%20(1).png">
                   


                </figure>
                <figure>
                    <img alt="adresse" src="images/letre%20(1).png">

                    <span><a href="">secureTi@admin.org</a></span>

                </figure>

            </div>


            <div class="mediasociau">
                <header>
                    <h1>Partenaires</h1>
                </header>

                <div>
                    <a href=""><img alt="logo facebook" src="assets/images/facebook.png"></a>

                    <a href=""><img alt="youtube" src="assets/images/youtube.png"></a>

                    <a href=""><img alt="tweeter" src="assets/images/tweeter.png"></a>

                    <a href=""><img alt="intagram" src="assets/images/instagram.png"></a>

                </div>
            </div>

        </nav>
        <span>Tous droits réservés © yapo — security</span>

    </footer>
</body>

</html>
