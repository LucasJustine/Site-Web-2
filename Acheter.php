<?php // Réaliser par Lucas JUSTINE?>

<?php 
session_start();
require("Connexion/ConnexionBD.php");
require("FonctionPanier.php");
require("Informations/InfoPanier.php");

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$requeteArgent = "Select stash from Customer where id = ?;";
$stmtArgent=mysqli_prepare($db,$requeteArgent);
mysqli_stmt_bind_param($stmtArgent,"i",$_SESSION['id']);
mysqli_stmt_execute($stmtArgent);
$resultArgent=mysqli_stmt_get_result($stmtArgent);
$resultatArgent = mysqli_fetch_assoc($resultArgent);
$PorteMonnaie = $resultatArgent['stash'];


if($PorteMonnaie < $MontantGlobal){
    header('Location:Panier.php?erreur=1');
    exit();
}

$requeteQuantite = "Select quantity
                    from BusinessSell
                    join TypeItem on BusinessSell.typeItem = TypeItem.id
                    where TypeItem.id = ? and Business.id = ?";
$stmtArgent=mysqli_prepare($db,$requeteArgent);
mysqli_stmt_bind_param($stmtArgent,"i",$_SESSION['id']);
mysqli_stmt_execute($stmtArgent);
$resultArgent=mysqli_stmt_get_result($stmtArgent);
$resultatArgent = mysqli_fetch_assoc($resultArgent);
$PorteMonnaie = $resultatArgent['stash'];

//Requete pour ajouter la commande à l'historique 
$requeteHistorique = "Insert Into Commande(Date,IdClient) values (now(),?) ";
$stmtHistorique=mysqli_prepare($db,$requeteHistorique);
mysqli_stmt_bind_param($stmtHistorique,"i", $_SESSION['id']);
mysqli_stmt_execute($stmtHistorique);


$Num = mysqli_insert_id($db);

$InsertObjet = "Insert Into HistoriqueCommande(objet,idEntreprise,quantite,NumeroCommande) values (?,?,?,?)";              
$stmtObjet=mysqli_prepare($db,$InsertObjet);


$nbArticles=count($_SESSION['panier']['id']);

for ($i=0 ;$i < $nbArticles ; $i++):
    mysqli_stmt_bind_param($stmtObjet,"iiii",$_SESSION['panier']['id'][$i],$_SESSION['panier']['Entreprise'][$i], $_SESSION['panier']['QteProduit'][$i],$Num);
    mysqli_stmt_execute($stmtObjet);
endfor;

$updateQuantite = "UPDATE BusinessSell 
                  join Business on Business.id = BusinessSell.business 
                  set quantity = quantity - ? 
                  where Business.id = ? and typeItem = ? ;";              
$stmtQuantite=mysqli_prepare($db,$updateQuantite);


for ($i=0 ;$i < $nbArticles ; $i++):
    mysqli_stmt_bind_param($stmtQuantite,"iii", $_SESSION['panier']['QteProduit'][$i],$_SESSION['panier']['Entreprise'][$i], $_SESSION['panier']['id'][$i]);
    mysqli_stmt_execute($stmtQuantite);
endfor;

$montant = $MontantGlobal;

$updateArgent = "UPDATE Customer set stash = stash - ? where id = ?;";            
$stmtCagnotte=mysqli_prepare($db,$updateArgent);
mysqli_stmt_bind_param($stmtCagnotte,"ii",$montant,$_SESSION['id']);
mysqli_stmt_execute($stmtCagnotte);


supprimePanier();

header('Location:Panier.php');
exit();

?>