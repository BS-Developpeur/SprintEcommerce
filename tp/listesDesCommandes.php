<?php

require_once("require/connectDB.php");
require_once("require/sql.php");




$liste = listesCommandes($conn);

$nombre_lignes=count($liste);
//echo($nombre_lignes);
$nbCommandeParPage=10;
$numPage= ceil($nombre_lignes /$nbCommandeParPage);
//echo($numPage);
  
// ---------------------------------------
if(isset($_GET['p'])){
  $page= $_GET['p'] ;
}
else{
    $page=1;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Listes de commandes</title>
    <link rel="stylesheet" href="css/styleListedonnee.css">
     <script src="https://code.iconify.design/1/1.0.3/iconify.min.js"></script>
</head>

<body>
    <h1>Liste des commandes</h1>

    <table id="p">
        <thead>
            <tr>
                <th>Numéro de commande</th>
                <th>Nom du client</th>
                <th>Produits commandés</th>
                <th>Quantités commandées</th>
                <th>actions</th>
            </tr>
        </thead>
        
        <?php foreach ($liste as $row) :
        ?>
      <?php //for($i=0;$i<count($liste);$i++) :
        ?>
          <?php if(($row["commande_id"]>(($page*$nbCommandeParPage)+1) || $row["commande_id"]>=((($page-1)*$nbCommandeParPage)+1))&&($row["commande_id"])<(($page*$nbCommandeParPage)+1) ):
        ?>
        <tbody>
           
            <tr>
                <td style="text-align: center;"><?= $row["commande_id"] ?></td>
                <td><?= $row["commande_client"] ?></td>
                <td><?= implode("<br>", $row["commande_produit"]) ?></td>
                <td style="text-align: center;"><?= implode("<br>", $row["commande_quantite"]) ?></td>
                <td>
                    <ul>

                        <li><a href="modifierCommande.php?id=<?php echo $row['commande_id']?>"><span class="iconify" data-inline="false" data-icon="dashicons:edit" style="color: blue; font-size: 20px;" data-flip="horizontal"></span></a></li>
                        <li><a href="supprimerCommande.php?id=<?php echo $row['commande_id']?>"><span class="iconify" data-inline="false" data-icon="wpf:delete" style="font-size: 20px; color: blue;"></span></a></li>
                    </ul>
                </td>
            </tr>
            
        </tbody>
      
         <?php   endif; ?>
        <?php// endfor; ?>
        <?php endforeach; ?>
         
    </table>
      <?php for($i = 1 ; $i <= $numPage ; $i++) :
        ?>
        
           <?php echo '<a href="admine.php?page=listeCommande&p=' . $i . '">' . $i . '</a>'?>
       
        <?php endfor; ?>
</body>

</html>
