

<?php
 session_start();
require_once("require/connectDB.php");
require_once("require/sql.php");

if (isset($_POST['envoi'])) {

    $identifiant = trim(strtolower($_POST['login'])); // Trim et met tout les caractères en minuscule
    $mot_de_passe = trim($_POST['mot_de_passe']);


    if (sqlControlerUtilisateur($conn,$identifiant, $mot_de_passe) == 1) {
       
        $_SESSION['identifiant_utilisateur'] =$identifiant;
        // var_dump($_POST);
    //die();
         
        $_SESSION['type_utilisateur'] = sqlLireUserType($conn,$identifiant);
        // Si l'utilisateur est l'admin, redirige vers le dashboard
            
        if (isset($_SESSION['identifiant_utilisateur']))
            header('Location: admine.php');
       
    } else {
        $erreur = "Identifiant ou mot de passe incorrect.";
    }
  
}

?>

<html>

<head>
    <meta charset="utf-8">
    <title>connection </title>
    <link rel="stylesheet" href="css/stylelogin2.css">

</head>

<body>

    <header>

        <img alt=" image de lentete" src="img/fsecure.jpg">
    </header>
    <main >
<span><?php echo isset($erreur) ? $erreur : "&nbsp;"  ?></span>
         <img alt="fond du main en image " src="img/cadenas.png">
        
        <form id="authentification" action="" method="post">
            <label></label>
            <input type="text" name="login" placeholder="Entrer votre login " value="" required><br>
            <label></label>
            <input type="password" name="mot_de_passe" placeholder="*****************" value="" required><br>
            <input type="submit" name="envoi" value="Login">
        </form>



    </main>



    <footer>
    </footer>
</body>

</html>
