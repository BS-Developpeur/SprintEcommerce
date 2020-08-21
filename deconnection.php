<?php
session_start();
unset($_SESSION['identifiant_client']); // ou session_unset()
session_destroy();
header('Location: pageclient.php'); 
?>