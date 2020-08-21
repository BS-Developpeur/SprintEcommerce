<?php
require_once("require/connectDB.php");
require_once("require/sql.php");

 $listes = array();
if (isset($_POST['form'])){
    
   
// contrôles des champs saisis
// ---------------------------

$erreurs = array();
  
  // recuperation des valeurs du formulaire
     $listes["client_id"]= $_POST['id'];
      $listes["client_nom"] = trim($_POST['nom']);
      $listes["client_prenom"]= trim($_POST['prenom']);
     $listes["client_rue"] = $_POST['rue'];
     $listes["client_ville"] = trim($_POST['ville']);
     $listes["client_cp"]  = trim($_POST['cp']);
     $listes["client_pays"] = trim($_POST['pays']);
     $listes["client_telephone"] = trim($_POST['tel']);
  

 // effectuer les modification
 
   if (sqlModifierClients($conn, $listes["client_id"],  $listes["client_nom"], $listes["client_prenom"], $listes["client_rue"], $listes["client_ville"], $listes["client_pays"], $listes["client_cp"], $listes["client_telephone"]) === 1) {
          $retSQL="Modification effectuée.";    
     } else {
            $retSQL ="Modification non effectuée.";    
        }

    
}else{
     if (isset($_GET['id'])){
// recupere la valeur de id du joueur envoyee en parametre
$idj =$_GET['id'];
       
// faire la requete en selectionnant dans la table joueur
//selectionner tous les infos joueurs ou joueur_id=$id envoyer en parametre
$listes = array();
         // lecture du client à modifier, à la première ouverture de la page
   $listes = sqlLireClient($conn,$idj);

}
     
}
     
            
        
mysqli_close($conn);
  
  
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Liste des client">
    <title>Liste des clients</title>
    <link rel="stylesheet" type="text/css" href="css/styleAjoutclient.css">
</head>

<body>
    <header>  <a href="admine.php?page=listeClient">RETOUR</a></header>

    <main>
        <h1>MISE A JOUR DU client</h1>

        <p><?php echo isset($retSQL) ? $retSQL : "&nbsp;" ?></p>
        <form method="POST" action="modifierClient.php">
            <div>
                <input type="hidden" name="id" value="<?php echo $listes["client_id"] ?>">
            </div>
            <div>
                <label> nom:</label> <input type="text" name="nom" value="<?php echo $listes['client_nom'] ?>">
            </div>
            <div>
                <label> prenoms:</label><input type="text" name="prenom" value="<?php echo $listes['client_prenom'] ?>" />
            </div>
            <div>
                <label> rue:</label><input type="text" name="rue" value="<?php echo $listes['client_rue'] ?>" />
            </div>
            <div>
                <label>ville:</label><input type="text" name="ville" value="<?php echo $listes['client_ville'] ?>" />
            </div>
            <div>
                <label> pays:</label><input type="text" name="pays" value="<?php echo $listes['client_pays'] ?>" />
            </div>
            <div>
                <label> code Postal:</label><input type="text" name="cp" value="<?php echo $listes['client_cp'] ?>" />
            </div>
            <div>
                <label> telephone:</label><input type="text" name="tel" value="<?php echo $listes['client_telephone'] ?>" />

            </div>
            <div>
                <input type="submit" value="modifier" name="form" />
            </div>
        </form>



    </main>
</body>

</html>
