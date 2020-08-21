<?php
require_once("require/connectDB.php");
require_once("require/sql.php");



 
   
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ajout d'un client ">
    <title>inscription du client</title>
    <link rel="stylesheet" type="text/css" href="css/styleAjoutclient.css">
</head>

<body>

    
        <h1>Ajouter un commande d un client</h1>
        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p>
        <?php // if(isset($_POST['ajoutClient.php'])) 
        {?>
        <?=  require_once('ajoutClient.php');  ?>
        <?php }?>


        
            <?= require_once('listeProduitsAcommande.php'); ?>





    
</body>

</html>
