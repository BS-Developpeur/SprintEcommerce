<?php
require_once("require/connectDB.php");
require_once("require/sql.php");

 $listes = array();
if (isset($_POST['form'])){
    
   
// contrôles des champs saisis
// ---------------------------

$erreurs = array();
  
  // recuperation des valeurs du formulaire
     $listes["categorie_id"]= $_POST['id'];
      $listes["categorie_libelle"] = trim($_POST['categorie_libelle']);
     

 // effectuer la modification  
 
   if (sqlModifierCategorie($conn, $listes["categorie_id"],  $listes["categorie_libelle"]) === 1) {
          $retSQL="Modification effectuée.";    
     } else {
            $retSQL ="Modification non effectuée.";    
        }

    
}else{
     if (isset($_GET['id'])){
// recupere la valeur de id dle la categorie envoyee en parametre
$idc =$_GET['id'];
       
// faire la requete en selectionnant dans la table joueur
//selectionner tous les infos joueurs ou joueur_id=$id envoyer en parametre
$listes = array();
         // lecture categorie à modifier, à la première ouverture de la page
   $listes = sqlLireCategories($conn,$idc);

}
     
}
     
       
        
mysqli_close($conn);
  
  
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="modifier categorie">
    <title>Liste des clients</title>
    <link rel="stylesheet" type="text/css" href="css/styleAjoutclient.css">
</head>

<body>
<header> <a href="admine.php?page=listeCategorie">RETOUR</a></header>
    <main>
        <h1>MISE A JOUR De la CATEGORIE</h1>

        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p>
        <form method="POST" action="">
            <div>
                <input type="hidden" name="id" value="<?php echo $listes["categorie_id"] ?>">
                <label> libelle:</label> <input type="text" name="categorie_libelle" value="<?php echo $listes['categorie_libelle'] ?>">
            </div>
            <div>

                <input type="submit" value="modifier" name="form" />
            </div>
        </form>



    </main>
</body>

</html>
