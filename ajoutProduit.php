<?php
require_once("require/connectDB.php");
require_once("require/sql.php");



// Perform query
$resultcat = mysqli_query($conn, "SELECT categorie_id ,categorie_libelle FROM categories");
 
if (isset($_POST['form'])) {
    
 
    
    // contrôles des champs saisis
    // ---------------------------
   
    $erreurs = array();//tableau associatif contenanst les message  erreurs de different champs
  
  // recuperation des valeurs du formulaire   
    
       $produit_libelle = trim($_POST['produit_libelle']);
     $produit_description = trim($_POST['produit_description']);
     $produit_prix = $_POST['produit_prix'];
    $produit_quantite = trim($_POST['produit_quantite']);
    $produit_commentaire = $_POST['produit_commentaire'];
   
   $categorie_id = trim($_POST['categorie']);
     
    
    
    /* ========== gestion des expressions regulieres sur les formulaires =========*/

if (empty($produit_libelle)) {
     $erreurs['produit_libelle'] = "* saisie obligatoire.";
    
}
  

/*******************************/
    if (empty($produit_description)) {
     $erreurs['produit_description'] = "*saisie obligatoire.";
    
       
    }
/*******************************/

    if (empty($produit_prix)) {
     $erreurs['produit_prix'] = "*saisie obligatoire.";
  }

/*******************************/

    if (empty($produit_quantite)) {
     $erreurs['produit_quantite'] = "*saisie obligatoire.";
  }
/*******************************/

    if (empty($categorie_id)) {
     $erreurs['categorie'] = "* saisie obligatoire.";
  }

   
   
    
          
if (count($erreurs) === 0) {
 
        if (sqlAjouterProduits($conn, $produit_libelle,$produit_description,$produit_prix,$produit_quantite,$produit_commentaire,$categorie_id) === 1) {
            $retSQL="Ajout effectué.";    
        } else {
            $retSQL ="Ajout non effectué.";    
        }
        // réinit pour une nouvelle saisie
       $produit_libelle = "";
           $produit_description = "";
           $produit_prix = "";
           $produit_quantite = "";
        $produit_commentaire = "";
           $categorie_id = "";
  
   
     
 }
  


  
}



 
   
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ajout d'un produit">
    <title>inscription</title>
    <link rel="stylesheet" type="text/css" href="css/styleAjoutclient.css">
</head>

<body>
   
    <main>
        <h1>ajout un produit</h1>
        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p>
        <form method="POST" action="">
            <div>
                <label> libelle:</label><input type="text" name="produit_libelle" />
                <span><?php echo isset($erreurs['produit_libelle']) ? $erreurs['produit_libelle'] : "&nbsp;"  ?></span>
            </div>
            <div>
                <label>description:</label><input type="text" name="produit_description" />
                <span><?php echo isset($erreurs['produit_description']) ? $erreurs['produit_description'] : "&nbsp;"  ?></span>
            </div>
            <div>
                <label> prix:</label><input type="number" name="produit_prix" />
                <span><?php echo isset($erreurs['produit_prix']) ? $erreurs['produit_prix'] : "&nbsp;"  ?></span>
            </div>
            <div>
                <label> quantite:</label><input type="number " name="produit_quantite" />
                <span><?php echo isset($erreurs['produit_quantite']) ? $erreurs['produit_quantite'] : "&nbsp;"  ?></span>
            </div>
            <div>
                <label> commentaire:</label>
                <textarea name="produit_commentaire" rows="4" cols="50"></textarea>

            </div>
            <div>

                <label> Veuillez choisir la categorie:</label>

                <select name="categorie">

                    <?php while($rows=mysqli_fetch_array($resultcat)) { ?>

                    <option value="<?php echo $rows['categorie_id'];?>"><?php echo $rows['categorie_libelle'];?>
                    </option> <?php } ?>
                </select>
                <span><?php echo isset($erreurs['categorie']) ? $erreurs['categorie'] : "&nbsp;"  ?></span>
            </div>
            <div>
                <input type="submit" value="enregistrer" name="form" />
            </div>


        </form>



    </main>
</body>

</html>
