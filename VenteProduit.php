<?php // Réaliser par Lucas JUSTINE?>
<?php 
session_start();
require("Connexion/ConnexionBD.php");

if(!isset($_SESSION['id'])){
        header('Location:Connexion.php?Achat=true');
        exit();
}

$produit = $_POST['Vente'];

$prix = $produit['prix'];
$id = $produit['id'];
$business = $produit['IdEntreprise'];



//Requete pour tester si la quantité pour l'objet n'est pas 0 et le prix du produit
$requeteQuantite = "select quantity,price from BusinessBuy where typeItem = ? and business = ?";
$stmtQuantite = mysqli_prepare($db,$requeteQuantite);
mysqli_stmt_bind_param($stmtQuantite,"ii",$id,$business);
mysqli_stmt_execute($stmtQuantite);
$res=mysqli_stmt_get_result($stmtQuantite);
$resultatQuantite= mysqli_fetch_assoc($res);
$resultatPrice= $resultatQuantite['price'];
$RealPrice = array($resultatPrice,round($resultatPrice*0.25,0,PHP_ROUND_HALF_UP),round($resultatPrice*0.75,0,PHP_ROUND_HALF_UP));
if(!in_array($prix,$RealPrice)){                //Si l'utilisateur a changé le prix 
    header('Location:Produit.php?erreur=5');
    exit();
}
if($resultatQuantite['quantity'] <= 0){        // Si l'utilisateur arrive à demander la vente d'un produit alors qu'il n'y a plus de produit 
    header('Location:Produit.php?erreur=3');
    exit();
}


// il faut vérifier que on ne puisse pas augmenter le prix du produit dans la vente 



//Requete pour retirer un element lors de la vente 
$requeteProduitMoins = "Update BusinessBuy set quantity = quantity - 1  where typeItem = ? and business = ?";
$stmtProduitMoins= mysqli_prepare($db,$requeteProduitMoins);
mysqli_stmt_bind_param($stmtProduitMoins,"ii",$id,$business);
mysqli_stmt_execute($stmtProduitMoins);

//Requete pour augmenter la cagnotte de l'utilisateur  
$requeteVente = "Update Customer set stash = stash + ?  where id = ?";
$stmtVente = mysqli_prepare($db,$requeteVente);
mysqli_stmt_bind_param($stmtVente,"ii",$prix,$_SESSION['id']);
mysqli_stmt_execute($stmtVente);

//Requete pour augmenter l'historique de vente de l'utilisateur  
$requeteHistoriqueVente = "Insert into Vente values(?,?,?,?,now())";
$stmtHistoriqueVente = mysqli_prepare($db,$requeteHistoriqueVente);
mysqli_stmt_bind_param($stmtHistoriqueVente,"iiii",$id,$_SESSION['id'],$business,$prix);
mysqli_stmt_execute($stmtHistoriqueVente);


//Requete pour augmenter l'extraction  de l'utilisateur
$requeteExtraction = "select element,quantity from ExtractionFromTypeItem where typeItem = ?";
$stmtExtraction = mysqli_prepare($db,$requeteExtraction);
mysqli_stmt_bind_param($stmtExtraction,"i",$id);
mysqli_stmt_execute($stmtExtraction);
$res=mysqli_stmt_get_result($stmtExtraction);
$resultatExtraction = mysqli_fetch_all($res,MYSQLI_ASSOC);

$requeteUpdate = "INSERT INTO CustomerExtraction(Customer,element,quantity) 
                  values(?,?,?)
                  ON DUPLICATE KEY UPDATE quantity = quantity + ?";

$stmtUpdate = mysqli_prepare($db,$requeteUpdate);



foreach($resultatExtraction as $resultat => $value){
    mysqli_stmt_bind_param($stmtUpdate,"iiii",$_SESSION['id'],$value['element'],$value['quantity'],$value['quantity']);
    mysqli_stmt_execute($stmtUpdate);
}

header('Location:Produit.php');
exit();

?>