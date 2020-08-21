<?php
require_once("require/connectDB.php");
require_once("require/sql.php");
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Liste des categorie">
    <title>Liste des clients</title>
    <link rel="stylesheet" type="text/css" href="css/styleListedonnee.css">
      <script src="https://code.iconify.design/1/1.0.3/iconify.min.js"></script>
</head>

<body>

    <main>
        <h1>Liste des categories</h1>



        <?php
/* code PHP de consultation de la liste des joueurs
   =============================================== */
        //requete sql de selection

$req = "SELECT * from categories";

if ($result = mysqli_query($conn, $req, MYSQLI_STORE_RESULT)) {
    $nbResult = mysqli_num_rows($result);  // nombre de lignes du résultat
    if ($nbResult) {
        mysqli_data_seek($result, 0);  // deuxième paramètre = numéro de ligne de départ
        ?>
        <table id="p">
            <thead>
                <tr>
                    <th>Numero</th>
                    <th>libelle</th>
                     <th>Actions</th>


                </tr>
            </thead>
            <?php
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            ?>
            <tbody>
                <tr>
                    <td><?php echo $row['categorie_id'] ?></td>
                    <td><?php echo $row['categorie_libelle'] ?></td>
                    <td>
                        <ul>
                            <li> <a href="modifierCategorie.php?id=<?php echo $row['categorie_id'] ?>"><span class="iconify" data-inline="false" data-icon="dashicons:edit" style="color: blue; font-size: 20px;" data-flip="horizontal"></span></a>
                            </li>
                            <li><a href="supprimerCategorie.php?id=<?php echo $row['categorie_id'] ?>"><span class="iconify" data-inline="false" data-icon="wpf:delete" style="font-size: 20px; color: blue;"></span></a></li>
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
        echo "Aucune categorie trouvée.";
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
