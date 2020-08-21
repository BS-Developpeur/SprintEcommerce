<?php
error_reporting(0);
session_start();
require_once("require/connectDB.php");
require_once("require/sql.php");
$listeProduit = mysqli_query($conn, "SELECT produit_id ,produit_libelle FROM produits");

// Catalogue des commandes client
//$recherche = isset($_POST['recherche']) ? trim($_POST['recherche']) : "";
 $listes = array();
if (isset($_POST['envoi'])){
    
   
// contrôles des champs saisis
// ---------------------------

//$erreurs = array();
$produitAncien= array(); 
  // recuperation des valeurs du formulaire
      $row["commande_id"]= $_POST['id'];
     $row["commande_client"]= $_POST['client'];
     
 // recuperation du produitsà
    
  // echo(count ($tab));
       foreach($_POST['produit'] as $p ){
    
  // echo($p); 
  
  }  
    
   // $i=0;
 foreach($_POST['quantite'] as $q){
   // echo($q);  
     // effectuer les modification
 
     
 //$i++;
  }
  
  if(sqlModifierCommande($conn, $row["commande_id"],$_POST['produit'],$q)==1){
     echo("modification effectuer");
 }
      

     

 

  

}else{
     if (isset($_GET['id']))//{
// recupere la valeur de id du joueur envoyee en parametre
$idp =intval($_GET['id']);
       

   $listes =sqlLireCommande($conn,$idp);

}
     
//}


     
/* code PHP de consultation de la liste*/
               
        
mysqli_close($conn);
  
  
        
//$liste = listesCommandes($conn);
$tab=array();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Listes de commandes</title>
    <link rel="stylesheet" href="css/styleAjoutclient.css">
</head>

<body>
     <header><a href="admine.php?page=listeCommande">RETOUR</a></header>
<main>
    <form method="post" action="modifierCommande.php">

         <?php foreach($listes as $row) :
        ?>
        
        <h1>modification de la commande de <?php echo  $row["commande_client"]?></h1><br>
        

        <input type="hidden" name="id" value="<?php echo $row["commande_id"]  ?>">

       <div> <label></label>
        <input type="hidden" name="client"  value="<?php echo $row["commande_client"]?>">
        </div>
      <div>
        <?php foreach ($row["commande_produit"] as $rowp) :
        ?>
        
         
        <label>libelle du produit</label> 
           <select name="produit[]">

                    <?php while($rows=mysqli_fetch_array($listeProduit,MYSQLI_ASSOC)) { ?>
                          
                    <option value="<?php echo $rows['produit_id'];?>"> <?php echo $rows['produit_libelle'];?>
                    </option>
                  <?php } ?>
                </select>
           
    
        <?php endforeach; ?>
          </div>
       <br>
        <div>
        <?php foreach ($row["commande_quantite"]as $rowq) :
        
        ?>
      
       <label>quantite</label> <input type="text" name="quantite[]" value="<?php echo $rowq ?>">
        
        
        <?php endforeach; ?>
            </div>
        <br>
        <?php endforeach; ?>
        

     <div>   <input type="submit" name="envoi" value="modifier" /></div>

    </form>
</main>
</body>

</html>
