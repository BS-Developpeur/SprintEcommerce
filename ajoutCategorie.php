<?php
require_once("require/connectDB.php");
require_once("require/sql.php");


if (isset($_POST['form'])) {
    
   
    // contrôles des champs saisis
    // ---------------------------
   
    $erreurs = array();//tableau associatif contenanst les message  erreurs de different champs
  
  // recuperation des valeurs du formulaire  
    
    $categorie_libelle = trim($_POST['categorie_libelle']);
     
 
    /* ========== gestion des expressions regulieres sur les formulaires =========*/


/*******************************/
    if (empty(  $categorie_libelle)) {
     $erreurs['categorie_libelle'] = "*saisie obligatoire.";
    
       
    }
/*******************************/

   
 
          
if (count($erreurs) === 0) {
 
        if (sqlAjoutCategorie($conn, $categorie_libelle) === 1) {
            $retSQL="Ajout effectué.";    
        } else {
            $retSQL ="Ajout non effectué.";    
        }
        // réinit pour une nouvelle saisie
          $categorie_libelle= "";
           
 }
  
  
}



 
   
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ajout d'une categorie ">
    <title>ajout d une categorie</title>
    <link rel="stylesheet" type="text/css" href="css/styleAjoutclient.css">
</head>

<body>
       <a href="admine.php">acceuil</a>
    <main>
        
        <h1>Ajout d'une categorie</h1>
        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p>
        <form method="POST" action="">
            <div>
                <label> libelle:</label><input type="text" name="categorie_libelle" />
                <span><?php echo isset($erreurs['categorie_libelle']) ? $erreurs['categorie_libelle'] : "&nbsp;"  ?></span>
            </div>

            <div>
                <input type="submit" value="enregistrer" name="form" />
            </div>

        </form>

    </main>
</body>

</html>
