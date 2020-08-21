<?php
require_once("require/connectDB.php");
require_once("require/sql.php");

// retour du formulaire de confirmation
// ------------------------------------
        
$confirme = isset($_POST['confirme']) ? $_POST['confirme'] : "";

if ($confirme !== "") {

    if ($confirme === "OUI") {
        $id = $_POST['categorie_id'];
        $codRet = sqlSupprimerCategorie($conn, $id);
        if      ($codRet === 1)  $message = "Suppression effectuée.";
        elseif  ($codRet === 0)  $message = "Aucune supression.";
    } else {
        $message = "Suppression non effectuée.";
    }

} else {
    
    // lecture de la categorie à supprimer
    // ----------------------------

    $id = isset($_GET['id']) ? $_GET['id'] : "";                
    $row = array();
    if ( $id !== "" ) $row = sqlLireCategories($conn, $id);
}

mysqli_close($conn);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Liste des categorie">
    
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <header><a href="admine.php?page=listeCategorie">RETOUR</a></header>
    <main>
        <h1>Suppression d'une categorie</h1>

        <p><?php echo isset($message) ? $message : "&nbsp;" ?></p>
    
<?php if (isset($row)) : ?>
    <?php if (count($row) > 0) : ?>
        <section>
            <p>Confirmez la suppression de la categorie <?php echo $row['categorie_libelle'] ?>  </p>
            <form class="form-suppression" action="supprimerCategorie.php" method="post"> 
                <input type="hidden" name="categorie_id" value="<?php echo $id ?>">
                <input type="submit" name="confirme" value="OUI"> 
                <input type="submit" name="confirme" value="NON">
            </form>
        </section>
    <?php else : ?>
        <p>Il n'y a pas de categorie pour cet identifiant.</p>
    <?php endif; ?>
<?php endif; ?>
        
    </main>
</body>
</html>	
