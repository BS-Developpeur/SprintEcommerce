<?php
require_once("require/connectDB.php");
require_once("require/sql.php");
$resultcat = mysqli_query($conn, "SELECT categorie_id ,categorie_libelle FROM categories");
 $listes = array();
if (isset($_POST['form'])){
    
   
// contrôles des champs saisis
// ---------------------------

$erreurs = array();
  
  // recuperation des valeurs du formulaire
     $listes["produit_id"]= $_POST['id'];
      $listes["produit_libelle"] = trim($_POST['produit_libelle']);
      $listes["produit_description"]= trim($_POST['produit_description']);
     $listes["produit_prix"] = $_POST['produit_prix'];
     $listes["produit_quantite"] = trim($_POST['produit_quantite']);
     $listes["produit_commentaire"]  = trim($_POST['produit_commentaire']);
     $listes["fk_categorie_id"] = trim($_POST['categorie']);
    

 // effectuer les modification
 
   if (sqlModifierProduits($conn,  $listes["produit_id"],   $listes["produit_libelle"], $listes["produit_description"],    $listes["produit_prix"],  $listes["produit_quantite"] ,    $listes["produit_commentaire"],     $listes["fk_categorie_id"]) === 1) {
          $retSQL="Modification effectuée.";    
     } else {
            $retSQL ="Modification non effectuée.";    
        }

    
}else{
     if (isset($_GET['id'])){
// recupere la valeur de id du joueur envoyee en parametre
$idp =$_GET['id'];
       
// faire la requete en selectionnant dans la table joueur
//selectionner tous les infos joueurs ou joueur_id=$id envoyer en parametre
$listes = array();
         // lecture du client à modifier, à la première ouverture de la page
   $listes = sqlLireProduit($conn,$idp);

}
     
}
     
/* code PHP de consultation de la liste*/
               
        
mysqli_close($conn);
  
  
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Liste des client">
    <title>Liste des clients</title>
    <link rel="stylesheet" type="text/css" href="css/styleAjoutclient.css">
</head>

<body>
    <header> <a href="admine.php?page=listeProduit">RETOUR</a></header>

    <main>
        <h1>MISE A JOUR DU Produit</h1>

        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p>
        <form method="POST" action="modifierProduit.php">

            <input type="hidden" name="id" value="<?php echo $listes["produit_id"] ?>">
            <div>
                <label> libelle:</label> <input type="text" name="produit_libelle" value="<?php echo $listes['produit_libelle'] ?>">
            </div>
            <div>
                <label> Description:</label><input type="text" name="produit_description" value="<?php echo $listes['produit_description'] ?>" />
            </div>
            <div>
                <label> prix:</label><input type="number" name="produit_prix" value="<?php echo $listes['produit_prix'] ?>" />
            </div>
            <div>
                <label>quantite:</label><input type="nume" name="produit_quantite" value="<?php echo $listes['produit_quantite'] ?>" />
            </div>
            <div>
                <label> commentaire:</label> <textarea name="produit_commentaire" rows="4" cols="50"></textarea>
            </div>
            <div>

                <label> modifier la categorie:</label>

                <select name="categorie">

                    <?php while($rows=mysqli_fetch_array($resultcat)) { ?>

                    <option value="<?php echo $rows['categorie_id'];?>"> <?php echo   $rows['categorie_libelle'];?>
                    </option> <?php } ?>
                </select>
            </div>
            <div>
                <input type="submit" value="modifier" name="form" />
            </div>
        </form>
    </main>
</body>

</html>
