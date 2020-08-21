<?php

require_once("require/connectDB.php");
require_once("require/sql.php");


if (isset($_POST['form'])) {
    
   
    // contrôles des champs saisis
    // ---------------------------
   
    $erreurs = array();//tableau associatif contenanst les message  erreurs de different champs
  
  // recuperation des valeurs du formulaire  
    
       $client_nom = trim($_POST['client_nom']);
       $client_prenom = trim($_POST['client_prenom']);
       $client_rue = $_POST['client_rue'];
       $client_ville = trim($_POST['client_ville']);
       $client_pays = trim($_POST['client_pays']);
       $client_cp = trim($_POST['client_cp']);
       $client_tel= trim($_POST['client_tel']);
     
 
    /* ========== gestion des expressions regulieres sur les formulaires =========*/
    //-----------------Validation---telephone---------------
   $client_tel = trim($_POST['client_tel']);
    if (!preg_match('/^(438{1}|514{1})-\d{3}-\d{4}$/', $client_tel)) {
        $erreurs['client_tel'] = "telephone incorrect";
    }

//A afire gerer l expressions reguliere du telephone
/*******************************/
    if (empty($client_nom)) {
     $erreurs['client_nom'] = "*saisie obligatoire.";
    
       
    }
/*******************************/

    if (empty($client_prenom)) {
     $erreurs['client_prenom'] = "*saisie obligatoire.";
  }

/*******************************/

    if (empty($client_rue)) {
     $erreurs['client_rue'] = "*saisie obligatoire.";
  }
/*******************************/

    if (empty($client_ville)) {
     $erreurs['client_ville'] = "* saisie obligatoire.";
  }

/*******************************/
    if (empty($client_pays)) {
     $erreurs['client_pays'] = "*saisie obligatoire.";

    }
    
/*******************************/
    if (empty($client_cp)) {
     $erreurs['client_cp'] = "*saisie obligatoire.";

    }
   
   
    /*******************************/
    if (empty($client_tel)) {
     $erreurs['client_tel'] = "*saisie obligatoire.";

    }
   
   
   
 
          
if (count($erreurs) === 0) {
 
        if (sqlAjouterClients($conn, $client_nom,$client_prenom,$client_rue,$client_ville,$client_pays,$client_cp,$client_tel) === 1) {
            $retSQL="Ajout effectué."; 
            
        } else {
            $retSQL ="Ajout non effectué.";    
        }
        // réinit pour une nouvelle saisie value="<?php echo $client_nom
      if(isset($_SESSION['identifiant_client'])){
           $client_nom = "";
           $client_prenom = "";
           $client_rue= "";
           $client_ville = "";

          $client_pays = "";
          $client_cp = "";
          $client_tel = "";
      }
    if(isset($_SESSION['type_utilisateur'])){
      $client_nom ;
           $client_prenom ;
           $client_rue;
           $client_ville ;

          $client_pays ;
          $client_cp ;
          $client_tel ;
     }
     
     if(isset($_SESSION['identifiant_client'])){
     header("location:authentificationcli.php");
     }
     if(isset($_SESSION['type_utilisateur'])){
     header("location:admine.php?page=insertionCommandeNews");
     }
     
     
 }
  
  
}



 
   
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ajout d'un client ">
    <title>inscription du client</title>
    <link rel="stylesheet" type="text/css" href="css/styleAjoutclient.css">
</head>

<body>
      
    <main>
        <h1>Ajout d'un client</h1>
       
        
        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p>
        
        <form method="POST" action="">
            <div>
                <label> Nom:</label><input type="text"    name="client_nom" />
                <span><?php echo isset($erreurs['client_nom']) ? $erreurs['client_nom'] : "&nbsp;"  ?></span>
            </div>

            <div>
                <label>Prenoms:</label><input type="text"  name="client_prenom" />
                <span><?php echo isset($erreurs['client_prenom']) ? $erreurs['client_prenom'] : "&nbsp;"  ?></span>
            </div>

            <div>
                <label> Rue:</label><input type="text" name="client_rue" />
                <span><?php echo isset($erreurs['client_rue']) ? $erreurs['client_rue'] : "&nbsp;"  ?></span>
            </div>

            <div>
                <label> Ville:</label><input type="text" name="client_ville" />
                <span><?php echo isset($erreurs['client_ville']) ? $erreurs['client_ville'] : "&nbsp;"  ?></span>
            </div>

            <div>
                <label> Pays:</label><input type="text" name="client_pays" />
                <span><?php echo isset($erreurs['client_pays']) ? $erreurs['client_pays'] : "&nbsp;"  ?></span>
            </div>

            <div>
                <label> code postal:</label><input type="text" name="client_cp" />
                <span><?php echo isset($erreurs['client_cp']) ? $erreurs['client_cp'] : "&nbsp;"  ?></span>
            </div>

            <div>
                <label> Telephone:</label><input type="text" placeholder="(438)ou(514)-xxx-xxxx" name="client_tel" />
                <span><?php echo isset($erreurs['client_tel']) ? $erreurs['client_tel'] : "&nbsp;"  ?></span>
            </div>
            <div>
                <input type="submit" value="enregistrer" name="form" />
            </div>

        </form>

    </main>
</body>

</html>
