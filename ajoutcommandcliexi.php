<!-- on a les produits selectionner ,les produits en promotion, les produits rechercher,les produits dune categorie donc faire des test -->
<?php 
error_reporting(0);
require_once("require/connectDB.php");
require_once("require/sql.php");

$resul="select * from clients ";
     
// si l'on clique sur categorie on recupere l id envoyer en paramere idCat
//si idCat existe
if (isset($_GET['idCat'])){
// recupere la valeur de idcat
  $idc =$_GET['idCat'];
// faire la requete en  selectionnant   dans la table  produit
    //selectionner tous les produit ou categorie_id=$idc envoyer en parametre

    
    
 

    
   $req = "SELECT  concat( P.produit_id) as produit_id, concat( P.produit_libelle) as produit_libelle , concat(P.produit_description)as produit_description , concat(p.produit_prix)as produit_prix  ,concat(P.produit_quantite) as produit_quantite  ,concat(P.produit_commentaire) as produit_commentaire  ,concat(C.categorie_libelle) as categorie_libelle   FROM produits as P 

INNER join categories as C ON P.fk_categorie_id = C.categorie_id 

       where C.categorie_id =$idc " ;
    
  
    
  
}
else {
    
   
     $req = "SELECT  concat( P.produit_id) as produit_id,concat( P.produit_libelle) as produit_libelle , concat(P.produit_description)as produit_description , concat(P.produit_prix)as produit_prix  ,concat(P.produit_quantite) as produit_quantite  ,concat(P.produit_commentaire) as produit_commentaire  ,concat(C.categorie_libelle) as categorie_libelle   FROM produits as P 

left join categories as C ON P.fk_categorie_id = C.categorie_id 

       ";

    
    
}

$r = mysqli_query($conn,$resul);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Liste des produits a commande">
    <title>Liste produits a commande</title>
    <link rel="stylesheet" type="text/css" href="css/styleProduitAcom.css">
</head>

<body>
   
    <main>
        <h1>Liste des produits disponible a l achat</h1>

        <?php
/* code PHP de consultation de la liste des joueurs
   =============================================== */
        //requete sql de selection


if ($result = mysqli_query($conn,$req, MYSQLI_STORE_RESULT)) {
    $nbResult = mysqli_num_rows($result);  // nombre de lignes du résultat
    if ($nbResult) {
        mysqli_data_seek($result, 0);  // deuxième paramètre = numéro de ligne de départ
        ?>

        <form method="post" action="ajouterCommande.php">
            <label>Nos clients</label>
            <select name="id">

                    <?php while($rows=mysqli_fetch_array($r,MYSQLI_ASSOC)) { ?>

                    <option value="<?php echo $rows['client_id'];?>"> <?php echo $rows['client_nom'];?><?php echo (" ");?><?php echo $rows['client_prenom'];?>
                    </option>
                  <?php } ?>
                </select>
           
            <table id="p">
                <thead>
                    <tr>
                        <th>choix</th>
                       
                        <th>libelle</th>
                        <th>description</th>
                        <th>prix</th>
                        <th>quantite en stock</th>
                        <th>commmentaire</th>
                        <th>categorie</th>
                        <th>nombre de commande</th>
                    </tr>
                </thead>
                <?php
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            ?>

                <tbody>
                    <tr>

                        <td><label> <input type="checkbox" name="choix[]" value="<?php echo($row['produit_id']) ?>" /></label> </td>
                        <input type="hidden" name="idproduit" value="<?php echo($row['produit_id']) ?>" />
                        <td> <input type="hidden" name="produit_libelle" value="<?php echo($row['produit_libelle']) ?>" /> <?php echo $row['produit_libelle'] ?></td>
                        <td> <input type="hidden" name="produit_description" value="<?php echo($row['produit_description']) ?>" /><?php echo $row['produit_description'] ?></td>
                        <td><input type="hidden" name="produit_prix" value="<?php echo($row['produit_prix']) ?>" /><br><?php echo $row['produit_prix'] ?></td>
                        <td><input type="hidden" name="produit_quantite" value="<?php echo($row['produit_quantite']) ?>" /><?php echo $row['produit_quantite'] ?></td>
                        <td><input type="hidden" name="produit_commentaire" value="<?php echo($row['produit_commentaire']) ?>" /><?php echo $row['produit_commentaire'] ?></td>
                        <td><input type="hidden" name="categorie_libelle" value="<?php echo( $row['categorie_libelle']) ?>" /><?php echo $row['categorie_libelle'] ?></td>
                         
                        <td> <input type="text" name="quantite[]" size="5" value="1" /></td>
                    </tr>
                
              
                </tbody>
                <?php 
        }
        ?>
            </table>
               <input type="hidden" name="commande_etat" value="En attente" />
             <label> vos commentaires suite a votre commande:</label><br>
                <textarea name="commande_commentaire" rows="4" cols="50">vos impressions</textarea>

            <!--afficher le bouton commande si l utilisateur est inscrit.-->
        
            <input type="submit" name="envoi1" value="commander" />
           
        </form>
        <?php
    } else {
        echo "Aucun produit  trouvé.";
    }
    mysqli_free_result($result); // libération de la mémoire

} else {
    errSQL($conn);
}
        
mysqli_close($conn);

/* fin du code PHP de consultation de la liste
   ====================================================== */
?>
    </main>
</body>

</html>
