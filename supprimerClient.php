<?php
require_once("require/connectDB.php");
require_once("require/sql.php");

// retour du formulaire de confirmation
// ------------------------------------
        
$confirme = isset($_POST['confirme']) ? $_POST['confirme'] : "";

if ($confirme !== "") {

    if ($confirme === "OUI") {
        $id = $_POST['client_id'];
        $codRet = sqlSupprimerClient($conn, $id);
        if      ($codRet === 1)  $message = "Suppression effectuée.";
        elseif  ($codRet === 0)  $message = "Aucune supression.";
    } else {
        $message = "Suppression non effectuée.";
    }

} else {
    
    // lecture du client à supprimer
    // ----------------------------

    $id = isset($_GET['id']) ? $_GET['id'] : "";                
    $row = array();
    if ( $id !== "" ) $row = sqlLireClient($conn, $id);
}

mysqli_close($conn);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Liste des genres">

    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<header> 
<body>
    <header> <a href="admine.php?page=listeClient">RETOUR</a></header>
    <main>
        <h1>Suppression d'un client</h1>

        <p><?php echo isset($message) ? $message : "&nbsp;" ?></p>

        <?php if (isset($row)) : ?>
        <?php if (count($row) > 0) : ?>
        <section>
            <p>Confirmez la suppression du client <?php echo $row['client_nom'] ?> <?php echo $row['client_prenom'] ?></p>
            <form class="form-suppression" action="supprimerClient.php" method="post">
                <input type="hidden" name="client_id" value="<?php echo $id ?>">
                <input type="submit" name="confirme" value="OUI">
                <input type="submit" name="confirme" value="NON">
            </form>
        </section>
        <?php else : ?>
        <p>Il n'y a pas de client pour cet identifiant.</p>
        <?php endif; ?>
        <?php endif; ?>

    </main>
</body>

</html>
