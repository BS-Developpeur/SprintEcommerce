<?php
require_once("require/connectDB.php");
require_once("require/sql.php");

 $listes = array();
if (isset($_POST['form'])){
    
   
// contrôles des champs saisis
// ---------------------------

$erreurs = array();
  
  // recuperation des valeurs du formulaire
      $listes["user_id"]= $_POST['id'];
      $listes["user_login"] = trim($_POST['user_login']);
      $listes["user_mdp"]= trim($_POST['user_pwd']);
      $listes["user_type"] = $_POST["user_type"];
     

 // effectuer les modification
 
   if (sqlModifierUtilisateur($conn, $listes["user_id"],  $listes["user_login"], $listes["user_mdp"], $listes["user_type"]) === 1) {
          $retSQL="Modification effectuée.";    
     } else {
            $retSQL ="Modification non effectuée.";    
        }

    
}else{
     if (isset($_GET['id'])){
// recupere la valeur de id du joueur envoyee en parametre
$idu =$_GET['id'];
       
// faire la requete en selectionnant dans la table users
//selectionner tous les infos users ou user_id=$idu envoyer en parametre
$listes = array();
         // lecture du user à modifier, à la première ouverture de la page
   $listes = sqlLireUtilisateur($conn,$idu);

}
     
}
     

mysqli_close($conn);
  
  
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="modifier des utlisateur">
    <title>Liste des clients</title>
    <link rel="stylesheet" type="text/css" href="css/styleAjoutclient.css">
</head>

<body><header>  <a href="admine.php?page=listeUsers">RETOUR</a></header>

    <main>
        <h1>MISE A JOUR De l utilisateur</h1>

        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p>
        <form method="POST" action="modifierUtilisateur.php">
            <div>
                <input type="hidden" name="id" value="<?php echo $listes["user_id"] ?>">
            </div>
            <div>
                <label> login:</label> <input type="text" name="user_login" value="<?php echo $listes['user_login'] ?>">
            </div>
            <div>
                <label> mot de passe:</label><input type="password" name="user_pwd" value="<?php echo $listes['user_mdp'] ?>" />
            </div>
            <div>
                <label> type:</label><input type="text" name="user_type" value="<?php echo $listes['user_type'] ?>" />
            </div>
           
            <div>
                <input type="submit" value="modifier" name="form" />
            </div>
        </form>



    </main>
</body>

</html>
