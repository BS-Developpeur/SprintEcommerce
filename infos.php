<?php

require_once("require/connectDB.php");
require_once("require/sql.php");

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="infos principale">
    <title>infos</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,700|Roboto:100,300,300i,400,700,900" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,400i,700,700i,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Crimson+Text:400,400i,600,600i,700" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styleInfos.css">
    <script src="assets/js/footer-cadre.js"></script>
    <script src="assets/js/scroll-menu.js"></script>
    <script src="assets/js/menu-scrol-active.js"></script>
    <script src="assets/js/toggle-nav-bar-active.js"></script>
    <script src="https://code.iconify.design/1/1.0.3/iconify.min.js"></script>
	
</head>
<body>
   
    <main>
        <section>
            <header>
                <h1> Mr _<?= $_SESSION["identifiant_utilisateur"] ?>  ,bienvenue dans l'application de gestion des commandes </h1>
            </header>
            <div class="conteneurs">
                <article class="cadre">
                    <div class="icone-menu"><span class="iconify" data-inline="false" data-icon="simple-line-icons:people" style="color: white; font-size: 60px;" data-flip="horizontal"></span> </div>

                    <p> gestion des TIERS ()</p>
                    <p> Gestion des clients et des utilisateurs 
                      </p>
                    <a href="">Besoin d'aide...</a>

                </article>
                <article class="cadre">

                    <div class="icone-menu"><span class="iconify" data-inline="false" data-icon="gridicons:product-downloadable" style="color: white; font-size: 60px;" data-flip="horizontal"></span></div>

                    <p> gestion des ARTICLES()</p>
                    <p> gerer les categories et les produits </p>
                    <a href="">Besoin d'aide...</a>


                </article>
                <article class="cadre">
                    <div class="icone-menu"><span class="iconify" data-inline="false" data-icon="gridicons:product-external" style="color: white; font-size: 60px;" data-flip="horizontal"></span> </div>

                    <p> gestion des commandes ()</p>
                    <p>gerer toutes les commandes dans la courtoisie avec les  clients</p>
                    <a href="">Besoin d'aide...</a>

                </article>
                <article class="cadre">

                     <div class="icone-menu"><span class="iconify" data-inline="false" data-icon="mdi:settings-transfer" style="color: white; font-size: 60px;" data-flip="horizontal"></span> </div>

                    <p> portail de l'administrateur</p>
                    <a href="">Besoin d'aide...</a>


                </article>

            </div>
        </section>
    </main>


</body>
</html>	
