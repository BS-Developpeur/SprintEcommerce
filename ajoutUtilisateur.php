<?php
require_once("require/connectDB.php");
require_once("require/sql.php");


if (isset($_POST['form'])) {
    
   
    // contrôles des champs saisis
    // ---------------------------
   
    $erreurs = array();//tableau associatif contenanst les message  erreurs de different champs
  
  // recuperation des valeurs du formulaire  
    
       $user_login = trim($_POST['user_login']);
       $user_pwd = trim($_POST['user_pwd']);
       $user_type = $_POST['user_type'];
      
     
 
    /* ========== gestion des expressions regulieres sur les formulaires =========*/

// gere  l expression reguliere pour le mot de passe 
/*******************************/
    if (empty( $user_login)) {
     $erreurs[' user_login'] = "*saisie obligatoire.";
    
       
    }
/*******************************/

    if (empty($user_pwd)) {
     $erreurs['user_pwd'] = "*saisie obligatoire.";
  }

/*******************************/

    if (empty( $user_type)) {
     $erreurs['user_type'] = "*saisie obligatoire.";
  }

   
 
          
if (count($erreurs) === 0) {
 
        if (sqlAjouterUtilisateur($conn, $user_login,$user_pwd,$user_type) === 1) {
            $retSQL="Ajout effectué.";    
        } else {
            $retSQL ="Ajout non effectué.";    
        }
        // réinit pour une nouvelle saisie
           $user_login = "";
           $user_pwd = "";
           $user_type= "";
    
           
 }
   
  
}


   
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ajout d'un utilisateur ">
    <title>inscription de l utilisateur</title>
    <link rel="stylesheet" type="text/css" href="css/styleAjoutclient.css">
</head>

<body>

    <main>
        <h1>Ajout d'un utilisateur</h1>
        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p>
        <form method="POST" action="">
            <div>
                <label> login:</label><input type="text" name="user_login" />
                <span><?php echo isset($erreurs['user_login']) ? $erreurs['user_login'] : "&nbsp;"  ?></span>
            </div>

            <div>
                <label>mot de passe:</label><input type="password" name="user_pwd" />
                <span><?php echo isset($erreurs['user_pwd']) ? $erreurs['user_pwd'] : "&nbsp;"  ?></span>
            </div>

            <div>
                <label> type d'utilisateur:</label><input type="text" name="user_type" />
                <span><?php echo isset($erreurs['user_type']) ? $erreurs['user_type'] : "&nbsp;"  ?></span>
            </div>


            <div>
                <input type="submit" value="enregistrer" name="form" />
            </div>

        </form>

    </main>
</body>

</html>
