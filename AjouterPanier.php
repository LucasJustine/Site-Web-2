<?php // Réaliser par Lucas JUSTINE?>

<?php 
require("Connexion/ConnexionBD.php");
require("FonctionPanier.php");
session_start();

if(!isset($_SESSION['id'])){
    header('Location:Connexion.php?Achat=true');
    exit();
}

   
    // Oublier le if isset 
    $produit = $_POST['Produit'];
    $id = $produit['id'];
    $nombre = $produit['NB'];
    $entreprise=$produit['IdEntreprise'];
    
    if($nombre <= 0 ){
        header('Location:Produit.php?erreur=4'); // Erreur quantité trop petite ou inferieur à 0
        exit();
    }

    $requetePrix = "Select price,quantity from BusinessSell where TypeItem = ? and business = ?";
    $stmtPrix= mysqli_prepare($db,$requetePrix);
    mysqli_stmt_bind_param($stmtPrix,"ii",$id,$entreprise);
    mysqli_stmt_execute($stmtPrix);
    $resultPrix=mysqli_stmt_get_result($stmtPrix);
    $resultatPrix = mysqli_fetch_assoc($resultPrix);
    $price = $resultatPrix['price'];
    $max = $resultatPrix['quantity'];
    

    // Ajouter au panier id-entreprise-quantité-prix 
    if( $max !=0 )
        ajouterAuPanier($id,$entreprise,$nombre,$price,$max);
    
    header('Location:Produit.php');
    exit();
   
   

?>  