<!-- on a les produits selectionner ,les produits en promotion, les produits rechercher,les produits dune categorie donc faire des test -->
<?php 

require_once("require/connectDB.php");
require_once("require/sql.php");


     
// si l'on clique sur categorie on recupere l id envoyer en paramere idCat
//si idCat existe
if (isset($_GET['idCat'])){
// recupere la valeur de idcat
  $idc =$_GET['idCat'];
// faire la requete en  selectionnant   dans la table  produit
    //selectionner tous les produit ou categorie_id=$idc envoyer en parametre

    
    
 

    
   $req = "SELECT  concat( P.`produit_id`) as produit_id, concat( P.`produit_libelle`) as produit_libelle , concat(p.`produit_description`)as produit_description , concat(p.produit_prix)as produit_prix  ,concat(p.`produit_quantite`) as produit_quantite  ,concat(p.`produit_commentaire`) as produit_commentaire  ,concat(c.categorie_libelle) as categorie_libelle   FROM `produits` as P 

INNER join categories as C ON p.fk_categorie_id = c.categorie_id 

       where c.categorie_id =$idc " ;
    
  
    
   // $resultcat = mysqli_query($conn,"select * from produits where categorie_id = $idc");
}
else {
    
     // $req = "select * from produits ";
     $req = "SELECT  concat( P.`produit_id`) as produit_id,concat( P.`produit_libelle`) as produit_libelle , concat(p.`produit_description`)as produit_description , concat(p.produit_prix)as produit_prix  ,concat(p.`produit_quantite`) as produit_quantite  ,concat(p.`produit_commentaire`) as produit_commentaire  ,concat(c.categorie_libelle) as categorie_libelle   FROM `produits` as P 
INNER join categories as C ON p.fk_categorie_id = c.categorie_id 

       ";

    
    
}

// on execute maintenant la requete avec query
  



?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Liste des joueurs">
    <title>Liste produits</title>
    <link rel="stylesheet" type="text/css" href="css/styleListedonnee.css">
    <script src="https://code.iconify.design/1/1.0.3/iconify.min.js"></script>
    
</head>

<body>
    
    <main>
        <h1>Liste des produit</h1>




        <?php
/* code PHP de consultation de la liste des joueurs
   =============================================== */
        //requete sql de selection


if ($result = mysqli_query($conn,$req, MYSQLI_STORE_RESULT)) {
    $nbResult = mysqli_num_rows($result);  // nombre de lignes du résultat
    if ($nbResult) {
        mysqli_data_seek($result, 0);  // deuxième paramètre = numéro de ligne de départ
        ?>


        <table id="p">
            <thead>
                <tr>
                    <th>numero</th>
                    <th>libelle</th>
                    <th>description</th>
                    <th>prix</th>
                    <th>quantite en stock</th>
                    <th>commmentaire</th>
                    <th>categorie</th>
                    <th>Actions</th>

                </tr>
            </thead>
            <?php
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            ?>

            <tbody>
                <tr>
                    <td><?php echo $row['produit_id'] ?></td>
                    <td><?php echo $row['produit_libelle'] ?></td>
                    <td><?php echo $row['produit_description'] ?></td>
                    <td><?php echo $row['produit_prix'] ?></td>
                    <td><?php echo $row['produit_quantite'] ?></td>
                    <td><?php echo $row['produit_commentaire'] ?></td>
                    <td><?php echo $row['categorie_libelle'] ?></td>
                    <td>
                        <ul>
                            <li><a href="modifierProduit.php?id=<?php echo $row['produit_id'] ?>"><span class="iconify" data-inline="false" data-icon="dashicons:edit" style="color: blue; font-size: 20px;" data-flip="horizontal"></span></a></li>
                            <li><a href="supprimerProduit.php?id=<?php echo $row['produit_id'] ?>"><span class="iconify" data-inline="false" data-icon="wpf:delete" style="font-size: 24px; color: blue;"></span></a></li>
                        </ul>





                    </td>
                </tr>
            </tbody>
            <?php 
        }
        ?>
        </table>



        <?php
    } else {
        echo "Aucun produit  trouvé.";
    }
    mysqli_free_result($result); // libération de la mémoire

} else {
    errSQL($conn);
}
        
mysqli_close($conn);

/* fin du code PHP de consultation de la liste des genres
   ====================================================== */
?>
    </main>
</body>

</html>
