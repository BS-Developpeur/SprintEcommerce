<?php

require_once("require/connectDB.php");
require_once("require/sql.php");


// Catalogue des commandes client
//$recherche = isset($_POST['recherche']) ? trim($_POST['recherche']) : "";
 $listes = array();
if (isset($_POST['envoi'])){
    
   
// contrôles des champs saisis
// ---------------------------

//$erreurs = array();
$quantite= array(); 
  // recuperation des valeurs du formulaire
      $row["commande_id"]= $_POST['id'];
     $row["commande_client"]= $_POST['client'];
   
 // $_POST['quantite'] 
       foreach($_POST['produit'] as $p ){
    
    echo($p);    
    

  }   
    $i=0;
     foreach($_POST['quantite'] as $q){
    
    echo($_POST['quantite'][$i]);    
    
 $i++;
  }
  
  
       

     

 // effectuer les modification
 
  if (sqlModifierCommande($conn, $row["commande_id"],  $row["commande_client"], $_POST['produit'],$_POST['quantite']) === 1) {
          $retSQL="Modification effectuée.";    
     } else {
            $retSQL ="Modification non effectuée.";    
       }

   

}else{
     if (isset($_GET['id']))//{
// recupere la valeur de id du joueur envoyee en parametre
$idp =$_GET['id'];
       
// faire la requete en selectionnant dans la table joueur
//selectionner tous les infos joueurs ou joueur_id=$id envoyer en parametre
//$listes = array();
         // lecture du client à modifier, à la première ouverture de la page
   $listes = sqlLireCommande($conn,$idp);

}
     
//}
     
/* code PHP de consultation de la liste*/
               
        
mysqli_close($conn);
  
  
        
//$liste = listesCommandes($conn);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Listes de commandes</title>
    <link rel="stylesheet" href="css/styletableau.css">
</head>

<body>
     <header><a href="admine.php?page=listeCommande">RETOUR</a></header>

    <form method="post" action="modifierCommande.php?">

         <?php foreach ($listes as $row) :
        ?>
        <h1>modification de la commande de <?php echo  $row["commande_client"]?></h1><br>
        

        <input type="hidden" name="id" value="<?php echo $row["commande_id"]  ?>">

        <label>nom et prenoms</label> <input type="text" name="client" value="<?php echo $row["commande_client"]?>">
        <br>
        <?php foreach ($row["commande_produit"] as $rowp) :
        ?>
       
        <label>libelle du produit</label> <input type="text" name="produit[]" value="<?php echo $rowp ?>">
        <?php endforeach; ?>
        <br>
        <?php foreach ($row["commande_quantite"]as $rowq) :
        ?>
        <label>quantite</label> <input type="text" name="quantite[]" value="<?php echo $rowq ?>">
        
        <?php endforeach; ?>
        <br>
        <?php endforeach; ?>
        

        <input type="submit" name="envoi" value="modifier" />

    </form>

</body>

</html>
