<?php
  
session_start();

// echo "<pre>".print_r($_COOKIE, true)."</pre>";
// echo session_id();

if (!isset($_SESSION['identifiant_utilisateur'])) {
    // redirection vers la page authentification.php
    // pour la saisie de l'identifiant et du mot de passe 
    header('Location: authentification.php'); }

?>