<?php
require_once("require/connectDB.php");
require_once("require/sql.php");

// test retour de saisie du formulaire
// -----------------------------------        

if (isset($_POST['envoi'])) {

    $identifiant = trim($_POST['identifiant']);
    $telephone = trim($_POST['telephone']);

    
    if (sqlControlerClient($conn, $identifiant, $telephone) === 1) {
        session_start();
        //recuperer le telephone dans la session pour valider la commande
        $_SESSION['identifiant_client'] = $telephone;
        header('Location: pageClient.php'); 
    } else {
        $erreur = "votre nom ou telephone  incorrect.";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Authentification">
    <title>Authentification</title>
    <link rel="stylesheet" type="text/css" href="css/styleAjoutclient.css">
</head>

<body>
    <header>
    </header>
    <main>
        <h1>Authentification</h1>
        <p><?php echo isset($erreur) ? $erreur : "&nbsp;" ?></p>

        <form id="authentification" action="authentificationcli.php" method="post">
            <div><label>votre nom</label>
                <input type="text" name="identifiant" value="" required>
            </div>
            <div>
            <label>Telephone</label>
            <input type="text" name="telephone" value=""  placeholder="XXX-XXXX-XXXX " required>
            </div>
            <div>
            <input type="submit" name="envoi" value="Envoyez">
            </div>
        </form>
        <a href="ajoutClient.php">sinscrire</a>


    </main>
</body>

</html>
