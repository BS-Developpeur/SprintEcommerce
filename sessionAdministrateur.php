 <?php
  
session_start();

// Si L'utilisateur n'est pas administrateur
if ($_SESSION['identifiant_utilisateur'] !== "admin") {
    // redirection vers la page authentification.php
    // pour la saisie de l'identifiant et du mot de passe 
    header('Location:pageClient.php'); }

?>