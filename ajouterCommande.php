    <?php
error_reporting(0);
session_start();
require_once("require/connectDB.php");
require_once("require/sql.php");


     //recuperer la liste des produit selectionne
if((isset($_SESSION['identifiant_client']) || isset($_SESSION['type_utilisateur'])) || (isset($_POST['envoi1']) )){
    
    // si la commande existe deja
 if(isset( $_SESSION['commande'])){
    // $commande= $_SESSION['commande'];
      // $commande = array();
        
      
   }else{
     $commande = array();
        
        
 }
    
    // gerer le choix qui a pour valeur produit_id dans la liste de produit a commande
if(isset($_POST['choix']) ){

     
  // recuperer la commande 
  foreach($_POST['choix'] as $idProduit){
      
      $i = count($commande);
       
     $commande[$i]['idproduit']=$idProduit;
     $commande[$i]['quantite']=$_POST['quantite'][$idProduit -1];
       
    

  }
  }
 
 
    $c=$_POST['commande_commentaire'];
     $e=$_POST['commande_etat'];
    //les commandes du client a mettre a jour
  $_SESSION['commande'] =  $commande;
   
    if(isset($_SESSION['identifiant_client'])){
    //Recuperer le id du client
   $usernameTel =$_SESSION['identifiant_client'];
 //$usernameTel="234-3455-5431";
   
   $req="SELECT client_id FROM clients WHERE client_telephone ='$usernameTel'";

     $resultId = mysqli_query($conn, $req);
         
 
  while ($row = mysqli_fetch_array( $resultId)){
      
      //recuperer  l id du client
         $_SESSION['idcli'] =$row["client_id"];
         
      $idclient = $_SESSION["idcli"];
      echo($idclient);
     if(sqlAjouterCommande($conn, $c,$e,$idclient)==1){
         echo("ajout effectue");
         
     }
     
  }
       }
    if((($_SESSION['type_utilisateur'])=== "vendeur" || ($_SESSION['type_utilisateur'])=== "gestionnaire" || ($_SESSION['type_utilisateur'])=== "admin")&& isset($_POST['envoi1'])){
         $client_id = trim($_POST['id']);
   echo( $client_id);
         if( sqlAjouterCommande($conn, $c,$e, $client_id)==1){
            echo("ajout effectue");   
         }
        
    }
    
    // ajout au cas ou les session de vendeur est ouverte e que cet client n est pas connecte
     if((($_SESSION['type_utilisateur'])=== "vendeur" || ($_SESSION['type_utilisateur'])=== "gestionnaire" || ($_SESSION['type_utilisateur'])=== "admin")&& isset($_POST['envoi'])){    
     $idclient= clientLastId($conn);
    if( sqlAjouterCommande($conn, $c,$e,$idclient)==1){
        echo("ajout effectué");
    }
     }
    
  
    
    // recupere tout les ide du commande du client  

    
    


    //Enregistrement dans la table commandes en recuperant la derniere commande

    
$req="SELECT commande_id FROM commandes order by commande_id DESC LIMIT 1";

     $resultat = mysqli_query($conn,$req);
 
 while ($row = mysqli_fetch_array($resultat)) {     
      //recuperer  l id du client
         $_SESSION['idcommande'] =$row["commande_id"];
         
      $idcommande = $_SESSION['idcommande'];
     
  }
    

for ($i=0;$i<count($_SESSION['commande']);$i++){
    
    
  $tab=($_SESSION['commande'][$i]);

   $quantite=($tab['quantite']);
   $idproduit=($tab['idproduit']);
    
      $req = "SELECT produit_quantite FROM produits WHERE produit_id = ".$idproduit;

        if ($result = mysqli_query($conn, $req)) {
            $row = mysqli_fetch_row($result);
            $quantiteStock = $row[0]; 
        } else {
            errSQL($conn);
           
            exit;
        }
          
        $quantiteAJour = $quantiteStock -  $quantite;
           sqlAjouterligneCommande($conn,$idproduit,$idcommande,$quantite); 
     // Si il y a suffisament de stock, mise à jours à jours de la quantité des produits commandés
        if ($quantite <= $quantiteStock) {
            $req = "UPDATE produits SET produit_quantite = $quantiteAJour WHERE produit_id = " .$idproduit;
    
            if ($result = mysqli_query($conn, $req)) {
                $row = mysqli_affected_rows($conn);
            } else {
                errSQL($conn);
                
                exit;
            }
        }
        else {
            ?>
<p class="erreur">Erreure : Plus assez de stock pour le produit numéro <?= $idproduit ?>.</p>
<?php  exit;
        }
}
   
    
    

//var_dump(mysqli_fetch_array( $result));



//les commandes du client

unset($_SESSION['commande']);
   
       if(isset($_SESSION['type_utilisateur'])){
     header("location:location:admine.php?page=insertionCommandeNews");
     } else{
           if(isset($_SESSION['identifiant_client'])){
           header("location:pageclient.php");
           }
       }
    
    }else{
     //if(isset($_SESSION['identifiant_client'])){
    // header("location:authentificationcli.php");
     //}
     header("location:ajoutClient.php");
     if(isset($_SESSION['type_utilisateur'])){
     header("location:admine.php?page=insertionCommandeNews");
     }
    else{
           header("location:authentificationcli.php");
       }
    
}
?>
