<?php
    
/**
 * Fonction errSQL
 * Auteur : P21
 * Date   : 
 * But    : afficher le message d'erreur de la dernière "query" SQL 
 * Arguments en entrée : $conn = contexte de connexion
 * Valeurs de retour   : aucune
 */
function errSQL($conn) {
    ?>
<p>Erreur de requête : <?php echo mysqli_errno($conn)." – ".mysqli_error($conn) ?></p>
<?php 
}


/*========================================sprint1==================================   */


/**
 * Fonction clientLastId,
 * Auteur   : yapo,
 * Date     : 2019-11-26,
 * But      : Récupérer le dernier id de la table client,
 * entrees    : $conn = contexte de connexion,
 * sortie   : $last_id = dernier id de la table.
 */
function clientLastId($conn)
{
    $req = "SELECT MAX(client_id) FROM clients";
    if ($result = mysqli_query($conn, $req)) {
        $nbResult = mysqli_num_rows($result);
        $last_id = "";
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            $last_id = mysqli_fetch_row($result);
            $last_id = $last_id[0];
        }
        mysqli_free_result($result);
        return $last_id;
    }
}

/**
 * Fonction enregistrerCommande
 * Auteur : yapo
 * Date   : 
 * But    : ajout de ligne dans les tables commandes et produits_commandes  par le vendeur et autres
 * Arguments en entrée : $conn = contexte de connexion
 *                       $commande = tableau contenant les id et les quantités des produits commandés
 * Valeurs de retour   : aucune
 */
function enregistrerCommande($conn, array $commande, $client_id) {
    mysqli_begin_transaction($conn); // Début de la transaction

    // Création de la commande
    $req = "INSERT INTO commandes (fk_client_id) VALUES ($client_id);";
        
    if ($result = mysqli_query($conn, $req)) {
        $row = mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        mysqli_rollback($conn);
        exit;
    }

    $commande_id = mysqli_insert_id($conn);

    foreach($commande as $c) { // Pour chaque prodruit commandé
        // Récupération de la quantité actuelle des produits commandés
        $req = "SELECT produit_quantite FROM produits WHERE produit_id = ". $c["produit"];

        if ($result = mysqli_query($conn, $req)) {
            $row = mysqli_fetch_row($result);
            $quantite = $row[0]; 
        } else {
            errSQL($conn);
            mysqli_rollback($conn);
            exit;
        }

        $nouvelleQuantite = $quantite - $c["quantité"];

        // Insert les produits commandés dans la table produit_commande
        $req = "INSERT INTO produits_commandes (produits_produit_id, commandes_commande_id, produit_commande_quantite) VALUES (" . $c["produit"] . ", $commande_id," . $c["quantité"] . ");";
        
        if ($result = mysqli_query($conn, $req)) {
            $row = mysqli_affected_rows($conn);
        } else {
            errSQL($conn);
            mysqli_rollback($conn);
            exit;
        }

        // Si il y a suffisament de stock, mise à jours à jours de la quantité des produits commandés
        if ($c["quantité"] <= $quantite) {
            $req = "UPDATE produits SET produit_quantite = $nouvelleQuantite WHERE produit_id = " . $c["produit"];
    
            if ($result = mysqli_query($conn, $req)) {
                $row = mysqli_affected_rows($conn);
            } else {
                errSQL($conn);
                mysqli_rollback($conn);
                exit;
            }
        }
        else {
            mysqli_rollback($conn); ?>
<p class="erreur">Erreure : Plus assez de stock pour le produit numéro <?= $c["produit"] ?>.</p>
<?php  exit;
        }
    }
    mysqli_commit($conn);
}

/**
 * Fonction sqlControlerUtilisateur
 * Auteur : yapo
 * Date   : 
 * But    : contrôler l'authentification de l utilisateur dans   la table user pour valider sa connexion
 *il doit sincrire  ou a deja ete inscrit dans une base de donnees passé
 * Arguments en entrée : $conn = contexte de connexion
 *                       $identifiant
 *                       $mot_de_passe
                          
 
 * Valeurs de retour   : 1 si utilisateur type avec $identifiant et $mot_de_passe trouvé 
 */
function sqlControlerUtilisateur($conn, $identifiant, $mot_de_passe) {

    $req = "SELECT * FROM users
           where user_login =? AND user_mdp=? ";

    $stmt = mysqli_prepare($conn, $req);
    mysqli_stmt_bind_param($stmt, "ss",  $identifiant, $mot_de_passe);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_num_rows($result);
    } else {
        errSQL($conn);
        exit;
    }
}

/* =========================gestion des commandes ==============*/

/**
 * Fonction sqlLireCommande
 * Auteur : yapo
 * Date   : 
 * But    : Récupérer la commande par son identifiant clé primaire 
 * Arguments en entrée : $conn = contexte de connexion
 *                       $id   = clé primaire
 * Valeurs de retour   : $row  = ligne correspondant à la clé primaire
 *                               tableau vide si non trouvée 
                               sous forme de tableau associatif
 */
function sqlLireCommande($conn, $id) {

    $req = "
    SELECT count( C.commande_id ) as nombreCommande,
    C.commande_id as 'Numéro de commande',
    CONCAT(CL.client_prenom, ' ', CL.client_nom) as 'Nom du client',
    P.produit_libelle as 'Produit',
    PC.quantite_commande as 'Quantité'
    FROM
        commandes as C
    INNER JOIN
        produits_commandes as PC on PC.fk_commande_id = C.commande_id
    INNER JOIN
        produits as P on P.produit_id = PC.fk_produit_id
    INNER JOIN
        clients as CL on CL.client_id = C.fk_client_id 
        
        where c.commande_id='$id'
   
    ORDER BY `Numéro de commande` ASC";
     
    // $stmt = mysqli_prepare($conn, $req);
   // mysqli_stmt_bind_param($stmt, "i", $id);

    
   if ($result = mysqli_query($conn, $req, MYSQLI_STORE_RESULT)) {
        $nbResult = mysqli_num_rows($result);
        $liste = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            //les variables a afficher
            $commande_id = "";
            $commande_client = "";
            $commande_produit = "";
            $commande_quantite = "";
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                if ($commande_id !== $row['Numéro de commande']) {
                    if ($commande_id !== "") {
                        $liste [] = array(
									'commande_id' => $commande_id,
                                    'commande_client' => $commande_client,
                                    'commande_produit' => $commande_produit,
                                    'commande_quantite' => $commande_quantite,
                                    );
                    }
                    $commande_id = $row['Numéro de commande'];
                    $commande_client = $row['Nom du client'];
                    $commande_produit = [];
                    $commande_quantite = [];
                }
                $commande_produit[] = $row['Produit'];
                $commande_quantite[] = $row['Quantité'];
            }
            $liste [] = array(
                'commande_id' => $commande_id,
                'commande_client' => $commande_client,
                'commande_produit' => $commande_produit,
                'commande_quantite' =>  $commande_quantite);
        mysqli_free_result($result);
        return $liste;
    } else {
        errSQL($conn);
        exit;
    }
    }   
    
}





/** 
 * Fonction sqlModifierCommande
 * Auteur : yapo
 * Date   : 
 * But    : modifier une ligne dans la table produit 
 * Arguments en entrée : $conn = contexte de connexion
                         $id   = clé primaire du client à modifier
 *                      
 * Valeurs de retour   : 1    si modification effectuée
 *                       0    si aucune modification
 */
function sqlModifierCommande($conn,$commande_id,$commande_client,array $commande_produit, array $commande_quantite) {
 
        
        $req="UPDATE commandes as c 
        INNER JOIN
        produits_commandes as PC on PC.fk_commande_id = C.commande_id
        INNER JOIN
        produits as P on P.produit_id = PC.fk_produit_id
        INNER JOIN
        clients as CL on CL.client_id = C.fk_client_id
           CONCAT(CL.client_prenom, ' ', CL.client_nom) as nom
         SET
       'nom'='$commande_client',
       $i=0;
       foreach($commande_quantite as $q){
    
       'PC.quantite_commande '='$commande_quantite[$i]';    
    
         $i++;
         }
         foreach($commande_produit as $c) {
           P.produit_libelle='$commande_produit[$i]',
         $i++;
        }
  where C.commande_id=".$commande_id;
  
        if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        exit;
    } 
 
}



/** 
 * Fonction listesCommandes,
 * Auteur   : 
 * Date     : 
 * But      : Récupérer les commandes avec les données associées,
 * entrees    : $conn = contexte de connexion,
 *            $recherche = chaîne de caractères pour la recherche de commande par nom de client (optionnel),
 * retour  : $liste = tableau des lignes de la commande SELECT.
 */

function listesCommandes($conn)
{
  // $nombreDeElementsParPage = 5;
    /* On calcule le numéro du premier élément qu'on prend pour le LIMIT de MySQL */
// = ($page - 1) * $nombreDeElementsParPage;
/* requête pour le nombre total de la sélection */
//$reqNbrTotal = "SELECT COUNT(*) AS nbr FROM latable WHERE $where"; 
//$resNbrTotal = mysql_query($reqNbrTotal); 
//$nbr = mysql_fetch_assoc($resNbrTotal); 
//$nombreLignes = $nbr['nbr']; // total pour la requete = pas que sur cette page
/* le nombre de commande req="
     SELECT 
    count(C.commande_id )
    
    FROM
        commandes as C 
    INNER JOIN
        produits_commandes as PC on PC.fk_commande_id = C.commande_id
    INNER JOIN
        produits as P on P.produit_id = PC.fk_produit_id
    INNER JOIN
        clients as CL on CL.client_id = C.fk_client_id 
   
    ORDER BY  C.commande_id  ASC "  */
    $req = "
     SELECT 
    C.commande_id as 'Numéro de commande',
    CONCAT(CL.client_prenom, ' ', CL.client_nom) as 'Nom du client',
    P.produit_libelle as 'Produit',
    PC.quantite_commande as 'Quantité'
    FROM
        commandes as C 
    INNER JOIN
        produits_commandes as PC on PC.fk_commande_id = C.commande_id
    INNER JOIN
        produits as P on P.produit_id = PC.fk_produit_id
    INNER JOIN
        clients as CL on CL.client_id = C.fk_client_id 
   
    ORDER BY `Numéro de commande` ASC ";
    
   if ($result = mysqli_query($conn, $req, MYSQLI_STORE_RESULT)) {
        $nbResult = mysqli_num_rows($result);
        $liste = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            //les variables a afficher
            $commande_id = "";
            $commande_client = "";
            $commande_produit = "";
            $commande_quantite = "";
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                if ($commande_id !== $row['Numéro de commande']) {
                    if ($commande_id !== "") {
                        
                       
                        $liste [] = array(
									'commande_id' => $commande_id,
                                    'commande_client' => $commande_client,
                                    'commande_produit' => $commande_produit,
                                    'commande_quantite' => $commande_quantite,
                                    );
                    }
                    $commande_id = $row['Numéro de commande'];
                    $commande_client = $row['Nom du client'];
                    $commande_produit = [];
                    $commande_quantite = [];
                }
                $commande_produit[] = $row['Produit'];
                $commande_quantite[] = $row['Quantité'];
            }
            $liste [] = array(
                'commande_id' => $commande_id,
                'commande_client' => $commande_client,
                'commande_produit' => $commande_produit,
                'commande_quantite' =>  $commande_quantite);
        mysqli_free_result($result);
        return $liste;
    } else {
        errSQL($conn);
        exit;
    }
    }   
    
}









/** 
 * Fonction sqlAjouterCommande
 * Auteur : yapo
 * Date   : 
 * But    : ajouter une ligne dans la table commande
 * Arguments en entrée : $conn = contexte de connexion
 *                      $idclient
 * Valeurs de retour   : 1    si ajout effectuée
 *                       0    si aucun ajout
 
 */
function sqlAjouterCommande($conn,$commentaire,$etat,$idclient) {
    //$req="INSERT INTO commandes (commande_date,commande_commentaire,commande_etat,fk_client_id) values (NOW(),$commentaire,$etat,$idclient)";
 
    $req="INSERT INTO commandes(commande_date,commande_commentaire,commande_etat,fk_client_id) values (NOW(), ?,?, ? )";


    $stmt = mysqli_prepare($conn, $req);
    mysqli_stmt_bind_param($stmt, "ssi",$commentaire,$etat,$idclient);
    if (mysqli_stmt_execute($stmt)) {
        return mysqli_stmt_affected_rows($stmt);
    } else {
        errSQL($conn);
        exit;
    }
}
/**
 * Fonction sqlSupprimerCommandes
 * Auteur : yapo
 * Date   : 
 * But    : supprimer une ligne de la table produits 
 * Arguments en entrée : $conn = contexte de connexion
 *                       $id   = valeur de la clé primaire 
 * Valeurs de retour   : 1    si suppression effectuée
 *                       0    si aucune suppression
 */
function sqlSupprimerCommandes($conn, $id) {
    
      
    $req = "DELETE FROM commandes WHERE commande_id=".$id;
     $req = "DELETE FROM produits-commande WHERE commande_id=".$id;


    if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        exit;
    }
}


/** 
 * Fonction sqlAjouterligneCommande
 * Auteur : yapo
 * Date   : 
 * But    : ajouter une ligne dans la table commande
 * Arguments en entrée : $conn = contexte de connexion
 *                    $conn,$idcommande,$idproduit,$quantite
 * Valeurs de retour   : 1    si ajout effectuée
 *                       0    si aucun ajout
 */
function  sqlAjouterligneCommande($conn,$idproduit,$idcommande,$quantite) {
    $req="INSERT INTO produits_commandes(fk_produit_id,fk_commande_id,quantite_commande) values ($idproduit,$idcommande,$quantite)";

    if (mysqli_query($conn,$req)) {
        $retSQL="Ajout effectué."; 
    } else {
       $retSQL ="Ajout non effectué.";   
        exit;
    }
}

/* ========= CLIENT= ==============================*/
/** 
 * Fonction sqlAjouterClients
 * Auteur : yapo
 * Date   : 
 * But    : ajouter une ligne dans la table clients 
 * Arguments en entrée : $conn = contexte de connexion
 *                     $client_nom,$client_prenom,$client_rue,$client_ville,$client_pays,$client_cp,$client_tel
 * Valeurs de retour   : 1    si ajout effectuée
 *                       0    si aucun ajout
 */
function sqlAjouterClients($conn,$client_nom,$client_prenom,$client_rue,$client_ville,$client_pays,$client_cp,$client_tel) {
    
    
    $req="INSERT INTO clients(client_nom,client_prenom,client_rue,client_ville,client_pays,client_cp,client_telephone) values ( ?, ?,?, ?, ?,?,? )";


    $stmt = mysqli_prepare($conn, $req);
    mysqli_stmt_bind_param($stmt, "sssssss",$client_nom,$client_prenom,$client_rue,$client_ville,$client_pays,$client_cp,$client_tel);
    if (mysqli_stmt_execute($stmt)) {
        return mysqli_stmt_affected_rows($stmt);
    } else {
        errSQL($conn);
        exit;
    }
}

/**
 * Fonction sqlLireClient
 * Auteur : yapo
 * Date   : 
 * But    : Récupérer le client par son identifiant clé primaire 
 * Arguments en entrée : $conn = contexte de connexion
 *                       $id   = clé primaire
 * Valeurs de retour   : $row  = ligne correspondant à la clé primaire
 *                               tableau vide si non trouvée 
                               sous forme de tableau associatif
 */
function sqlLireClient($conn, $id) {

    $req = "SELECT * FROM clients WHERE client_id=".$id;
    
    if ($result = mysqli_query($conn, $req)) {
        $nbResult = mysqli_num_rows($result);
        $row = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
        mysqli_free_result($result);
        return $row;
    } else {
        errSQL($conn);
        exit;
    }
}


/** lireUserType($conn, $identifiant)
 * Fonction sqlModifierClients
 * Auteur : yapo
 * Date   : 
 * But    : modifier une ligne dans la table client 
 * Arguments en entrée : $conn = contexte de connexion
                         $id   = clé primaire du client à modifier
 *                      
 * Valeurs de retour   : 1    si modification effectuée
 *                       0    si aucune modification
 */
function sqlModifierClients($conn,$id,$client_nom,$client_prenom,$client_rue,$client_ville,$client_pays,$client_cp,$client_tel) {
    

 $req="UPDATE clients SET
 client_nom='$client_nom',
 client_prenom= '$client_prenom',
 client_rue= '$client_rue',
 client_ville='$client_ville',
 client_cp='$client_cp',
 client_pays='$client_pays',
 client_telephone= '$client_tel'
  where client_id=".$id;

 
    if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        exit;
    }
}


/**
 * Fonction sqlSupprimerClient
 * Auteur : yapo
 * Date   : 
 * But    : supprimer une ligne de la table client  
 * Arguments en entrée : $conn = contexte de connexion
 *                       $id   = valeur de la clé primaire 
 * Valeurs de retour   : 1    si suppression effectuée
 *                       0    si aucune suppression
 */
function sqlSupprimerClient($conn, $id) {
    
    $req = "DELETE FROM clients WHERE client_id=".$id;
    
    if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        exit;
    }
}

/**
 * Fonction sqlControlerClient
 * Auteur : yapo
 * Date   : 
 * But    : contrôler l'authentification du client dans   la table client pour valider sa commande 
 *il doit sincrire  ou a deja ete inscrit dans une commande passé
 * Arguments en entrée : $conn = contexte de connexion
 *                       $identifiant
 *                       $telephone
 * Valeurs de retour   : 1 si utilisateur avec $identifiant et $mot_de_passe trouvé 
 */
function sqlControlerClient($conn, $identifiant, $telephone) {

    $req = "SELECT * FROM clients
            WHERE client_nom=? AND client_telephone =? ";

    $stmt = mysqli_prepare($conn, $req);
    mysqli_stmt_bind_param($stmt, "ss", $identifiant, $telephone);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_num_rows($result);
    } else {
        errSQL($conn);
        exit;
    }
}


/*----                -CATEGORIE   ------ */
/** 
 * Fonction sqlAjoutCategorie
 * Auteur : yapo
 * Date   : 
 * But    : ajouter une ligne dans la table categories 
 * Arguments en entrée : $conn = contexte de connexion
 *                     $categorie_libelle
 * Valeurs de retour   : 1    si ajout effectuée
 *                       0    si aucun ajout
 */
function sqlAjoutCategorie($conn,$categorie_libelle) {
    
    
    $req="INSERT INTO categories(categorie_libelle) values ( ?)";


    $stmt = mysqli_prepare($conn, $req);
    mysqli_stmt_bind_param($stmt, "s",$categorie_libelle);
    if (mysqli_stmt_execute($stmt)) {
        return mysqli_stmt_affected_rows($stmt);
    } else {
        errSQL($conn);
        exit;
    }
}


/**
 * Fonction sqlLireCategorie
 * Auteur : yapo
 * Date   : 
 * But    : Récupérer la categorie par son identifiant clé primaire 
 * Arguments en entrée : $conn = contexte de connexion
 *                       $id   = clé primaire
 * Valeurs de retour   : $row  = ligne correspondant à la clé primaire
 *                               tableau vide si non trouvée 
                               sous forme de tableau associatif
 */
function sqlLireCategories($conn, $id) {

    $req = "SELECT * FROM categories WHERE categorie_id=".$id;
    
    if ($result = mysqli_query($conn, $req)) {
        $nbResult = mysqli_num_rows($result);
        $row = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
        mysqli_free_result($result);
        return $row;
    } else {
        errSQL($conn);
        exit;
    }
}


/** 
 * Fonction sqlModifierCategorie
 * Auteur : yapo
 * Date   : 
 * But    : modifier une ligne dans la table categorie 
 * Arguments en entrée : $conn = contexte de connexion
                         $id   = clé primaire du client à modifier
 *                      
 * Valeurs de retour   : 1    si modification effectuée
 *                       0    si aucune modification
 */
function sqlModifierCategorie($conn,$id,$categorie_libelle) {
    

 $req="UPDATE categories SET
 categorie_libelle='$categorie_libelle'
 
  where categorie_id=".$id;

 
    if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        exit;
    }
}


/**
 * Fonction sqlSupprimerCategorie
 * Auteur : yapo
 * Date   : 
 * But    : supprimer une ligne de la table categorie  
 * Arguments en entrée : $conn = contexte de connexion
 *                       $id   = valeur de la clé primaire 
 * Valeurs de retour   : 1    si suppression effectuée
 *                       0    si aucune suppression
 */
function sqlSupprimerCategorie($conn, $id) {
    
    $req = "DELETE FROM categories WHERE categorie_id=".$id;

    if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        exit;
    }
}

/*-----  =====  PRODUITS--- =====              -------*/

/** 
 * Fonction sqlAjouterProduits
 * Auteur : yapo
 * Date   : 
 * But    : ajouter une ligne dans la table pproduits 
 * Arguments en entrée : $conn = contexte de connexion
 *                    
 * Valeurs de retour   : 1    si ajout effectuée
 *                       0    si aucun ajout
 */
function sqlAjouterProduits($conn, $produit_libelle,$produit_description,$produit_prix,$produit_quantite,$produit_commentaire,$categorie_id) {
    
    
    $req="INSERT INTO Produits( produit_libelle,produit_description,produit_prix,produit_quantite,produit_commentaire,fk_categorie_id) values ( ?, ?,?, ?, ?,? )";


    $stmt = mysqli_prepare($conn, $req);
    mysqli_stmt_bind_param($stmt, "ssiisi", $produit_libelle,$produit_description,$produit_prix,$produit_quantite,$produit_commentaire,$categorie_id);
    if (mysqli_stmt_execute($stmt)) {
        return mysqli_stmt_affected_rows($stmt);
    } else {
        errSQL($conn);
        exit;
    }
}


/**
 * Fonction sqlLireProduit
 * Auteur : yapo
 * Date   : 
 * But    : Récupérer le pproduit par son identifiant clé primaire 
 * Arguments en entrée : $conn = contexte de connexion
 *                       $id   = clé primaire
 * Valeurs de retour   : $row  = ligne correspondant à la clé primaire
 *                               tableau vide si non trouvée 
                               sous forme de tableau associatif
 */
function sqlLireProduit($conn, $id) {

    $req = "SELECT * FROM produits WHERE produit_id=".$id;
    
    if ($result = mysqli_query($conn, $req)) {
        $nbResult = mysqli_num_rows($result);
        $row = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
        mysqli_free_result($result);
        return $row;
    } else {
        errSQL($conn);
        exit;
    }
}

/** 
 * Fonction sqlModifierProduit
 * Auteur : yapo
 * Date   : 
 * But    : modifier une ligne dans la table produit 
 * Arguments en entrée : $conn = contexte de connexion
                         $id   = clé primaire du client à modifier
 *                      
 * Valeurs de retour   : 1    si modification effectuée
 *                       0    si aucune modification
 */
function sqlModifierProduits($conn,$produit_id,  $produit_libelle, $produit_description,  $produit_prix,  $produit_quantite ,    $produit_commentaire, $fk_categorie_id) {
    

 $req="UPDATE produits SET
  produit_libelle=' $produit_libelle',
produit_description= '$produit_description',
  produit_prix= ' $produit_prix',
 produit_quantite ='$produit_quantite ',
produit_commentaire='$produit_commentaire',
 fk_categorie_id='$fk_categorie_id'

  where produit_id=".$produit_id;

 
    if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        exit;
    }
}


/**
 * Fonction sqlSupprimerProduit
 * Auteur : yapo
 * Date   : 
 * But    : supprimer une ligne de la table produits 
 * Arguments en entrée : $conn = contexte de connexion
 *                       $id   = valeur de la clé primaire 
 * Valeurs de retour   : 1    si suppression effectuée
 *                       0    si aucune suppression
 */
function sqlSupprimerProduit($conn, $id) {
    
      
    $req = "DELETE FROM produits WHERE produit_id=".$id;

    if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        exit;
    }
}

/*============= UTILISATEUR========== */ 
/** 
 * Fonction sqlAjouterUtilisateur
 * Auteur : yapo
 * Date   : 
 * But    : ajouter une ligne dans la table users
 * Arguments en entrée : $conn = contexte de connexion
 *                   
 * Valeurs de retour   : 1    si ajout effectuée
 *                       0    si aucun ajout
 */
function sqlAjouterUtilisateur($conn,$user_login,$user_pwd,$user_type) {
    
    
    $req="INSERT INTO users(user_login,user_mdp,user_type) values ( ?, ?,? )";


    $stmt = mysqli_prepare($conn, $req);
    mysqli_stmt_bind_param($stmt, "sss",$user_login,$user_pwd,$user_type);
    if (mysqli_stmt_execute($stmt)) {
        return mysqli_stmt_affected_rows($stmt);
    } else {
        errSQL($conn);
        exit;
    }
}

/**
 * Fonction sqlLireUtilisateur
 * Auteur : yapo
 * Date   : 
 * But    : Récupérer l utilisateur par son identifiant clé primaire 
 * Arguments en entrée : $conn = contexte de connexion
 *                       $id   = clé primaire
 * Valeurs de retour   : $row  = ligne correspondant à la clé primaire
 *                               tableau vide si non trouvée 
                               sous forme de tableau associatif
 */
function sqlLireUtilisateur($conn, $id) {

    $req = "SELECT * FROM users WHERE user_id=".$id;
    
    if ($result = mysqli_query($conn, $req)) {
        $nbResult = mysqli_num_rows($result);
        $row = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        }
        mysqli_free_result($result);
        return $row;
    } else {
        errSQL($conn);
        exit;
    }
}

/** 
 * Fonction sqlModifierUtilisateur
 * Auteur : yapo
 * Date   : 
 * But    : modifier une ligne dans la table users
 * Arguments en entrée : $conn = contexte de connexion
                         $id   = clé primaire du client à modifier
 *                      
 * Valeurs de retour   : 1    si modification effectuée
 *                       0    si aucune modification
 */
function sqlModifierUtilisateur($conn,$user_id,$user_login,$user_pwd,$user_type) {
    

 $req="UPDATE users SET
  user_login=' $user_login',
user_mdp= '$user_pwd',
  user_type= '$user_type'

  where user_id=".$user_id;

 
    if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        exit;
    }
}


/**
 * Fonction sqlSupprimerUtilisateur
 * Auteur : yapo
 * Date   : 
 * But    : supprimer une ligne de la table users 
 * Arguments en entrée : $conn = contexte de connexion
 *                       $id   = valeur de la clé primaire 
 * Valeurs de retour   : 1    si suppression effectuée
 *                       0    si aucune suppression
 */
function sqlSupprimerUtilisateur($conn, $id) {
    
    $req = "DELETE FROM users WHERE user_id=".$id;

    if (mysqli_query($conn, $req)) {
        return mysqli_affected_rows($conn);
    } else {
        errSQL($conn);
        exit;
    }
}

/**
 * Fonction sqlLireUserType
 * Auteur : yapo
 * Date   : 
 * But    : Récupérer l user par son identifiant clé primaire 
 * Arguments en entrée : $conn = contexte de connexion
 *                       $identifiant  = clé primaire
 * Valeurs de retour   : $row  = ligne correspondant à la clé primaire
 *                               tableau vide si non trouvée 
                               sous forme de tableau associatif
 */
function sqlLireUserType($conn,$id) {
 $req = "SELECT * FROM users WHERE user_login='$id'";
    //$req = "SELECT * FROM clients WHERE client_courriel ='$identifiant'";
    
    if ($result = mysqli_query($conn,$req)) {
        $nbResult = mysqli_num_rows($result);
        $row = array();
        if ($nbResult) {
            mysqli_data_seek($result, 0);
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        }
        mysqli_free_result($result);
        $user_type= $row['user_type'];
        return  $user_type;
    } else {
        errSQL($conn);
        exit;
    }
}


/** lireUserType($conn, $identifiant)

/*======================================== fin sprint1==================================   */
