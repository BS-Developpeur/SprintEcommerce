<?php
error_reporting(0);
require_once("require/connectDB.php");
require_once("require/sql.php");


$liste=array();

$liste = listesCommandes($conn);
// ---------------------------------------
if(isset($_GET['p'])){
  $page= $_GET['p'] ;
}
else{
    $page=1;
}


$nombre_lignes=count($liste);
$nbCommandeParPage=10;
$numPage= ceil($nombre_lignes /$nbCommandeParPage);

  
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
                <th>adresse de livraison </th>
                <th>etat </th>
                <th>date</th>
                <th>actions</th>
            </tr>
        </thead>
        
       <? $i=0; ?>
      <?php for($i=(($page-1)*$nbCommandeParPage);$i<((($page)*($nbCommandeParPage)));$i++) :
        ?>
        <?php if($i<$nombre_lignes)  :
        ?>
      
     
        <tbody>
           
            <tr>
                <td style="text-align: center;"><?= $liste[$i]["commande_id"] ?></td>
                 <td><?= $liste[$i]["commande_client"] ?></td>
                <td><?= implode("<br>", $liste[$i]["commande_produit"]) ?></td>
                <td style="text-align: center;"><?= implode("<br>", $liste[$i]["commande_quantite"]) ?></td>
                    <td><?= $liste[$i]["adresse"] ?></td>             
                 <td><?= $liste[$i]["commande_etat"] ?></td>
                 <td><?= $liste[$i]["commande_date"] ?></td>
                <td>
                  
                    <ul>

                        <li><a href="modifierCommande.php?id=<?php echo $liste[$i]['commande_id']?>"><span class="iconify" data-inline="false" data-icon="dashicons:edit" style="color: blue; font-size: 20px;" data-flip="horizontal"></span></a></li>
                        <li><a href="supprimerCommande.php?id=<?php echo $liste[$i]['commande_id']?>"><span class="iconify" data-inline="false" data-icon="wpf:delete" style="font-size: 20px; color: blue;"></span></a></li>
                    </ul>
                    
                </td>
                 
                 
            </tr>
            
        </tbody>
        
        <?php endif; ?>
        <?php endfor; ?>
       
         
    </table>
      <?php for($i = 1 ; $i <= $numPage ; $i++) :
        ?>
        
           <?php echo '<a href="admine.php?page=listeCommande&p=' . $i . '">' . $i . '</a>'?>
       
        <?php endfor; ?>
</body>

</html>
