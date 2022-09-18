<?php // Réaliser par Lucas JUSTINE?>

<?php 

$requeteHis = "SELECT NumeroCommande,DATE_FORMAT(date,\"%d/%m/%Y\") as date,quantite,objet,TypeItem.name,Business.name as nom
               FROM `Commande` natural join HistoriqueCommande 
               join TypeItem on HistoriqueCommande.objet = TypeItem.id 
               join Business on HistoriqueCommande.idEntreprise = Business.id 
               where idClient = ".$_SESSION['id'];
$queryHis = mysqli_query($db,$requeteHis);
$resultatHistorique = mysqli_fetch_all($queryHis,MYSQLI_ASSOC);


$requeteVente = "SELECT idProduit,DATE_FORMAT(date, '%d/%m/%Y') as date,TypeItem.name,prix ,Business.name as nom 
                FROM `Vente` join TypeItem on Vente.idProduit = TypeItem.id 
                join Business on Vente.idEntreprise = Business.id 
                where idClient = ".$_SESSION['id'];
$queryVente = mysqli_query($db,$requeteVente);
$resultatHistoriqueVente = mysqli_fetch_all($queryVente,MYSQLI_ASSOC);


?>